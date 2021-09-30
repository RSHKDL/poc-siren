<?php

namespace App\Siren\Domain\Services;

use App\Siren\Domain\Enum\SirenFinderStrategyEnum;
use App\Siren\Domain\Exception\SirenApiException;
use App\Siren\Domain\ValueObject\SirenApiResult;
use App\Siren\Domain\ValueObject\SirenResultInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class SirenFromApiFinder implements SirenFinderStrategy
{
    private string $token;
    private HttpClientInterface $httpClient;

    public function __construct(
        string $token,
        HttpClientInterface $httpClient
    ) {
        $this->token = $token;
        $this->httpClient = $httpClient;
    }

    public function isEligible(string $mode): bool
    {
        return $mode === SirenFinderStrategyEnum::BY_API;
    }

    /**
     * Return SirenResultInterface or throw an exception
     *
     * @throws SirenApiException
     */
    public function find(string $siren): SirenResultInterface
    {
        try {
            $response = $this->httpClient->request(
                "GET",
                "https://api.insee.fr/entreprises/sirene/V3/siren/{$siren}",
                ['auth_bearer' => $this->token]
            );
            $result = $this->formatSuccessResponse($response->toArray());
        } catch (\Throwable $throwable) {
            throw new SirenApiException($throwable->getMessage(), $throwable->getCode(), $throwable->getPrevious());
        }

        return $result;
    }

    private function formatSuccessResponse(array $data): SirenApiResult
    {
        $result = new SirenApiResult(SirenFinderStrategyEnum::BY_API);
        $result->siren = $data["uniteLegale"]["siren"];
        $result->mostRecentNic = $data["uniteLegale"]["periodesUniteLegale"][0]["nicSiegeUniteLegale"];
        $result->periodsCount = count($data["uniteLegale"]["periodesUniteLegale"]);

        return $result;
    }
}