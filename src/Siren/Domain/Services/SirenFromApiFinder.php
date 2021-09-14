<?php

namespace App\Siren\Domain\Services;

use App\Siren\Domain\Enum\SirenFinderStrategyEnum;
use App\Siren\Domain\Exception\SirenNotFoundException;
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

    /**
     * Return SirenResultInterface or throw an exception
     *
     * @throws SirenNotFoundException
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
            $result = $this->formatErrorResponse($throwable);
        }

        if ($result->isNotFound()) {
            throw new SirenNotFoundException("No company found with siren: $siren");
        } else {
            return $result;
        }
    }

    private function formatSuccessResponse(array $data): SirenApiResult
    {
        $result = new SirenApiResult(SirenFinderStrategyEnum::BY_API);
        $result->siren = $data["uniteLegale"]["siren"];
        $result->mostRecentNic = $data["uniteLegale"]["periodesUniteLegale"][0]["nicSiegeUniteLegale"];
        $result->periodsCount = count($data["uniteLegale"]["periodesUniteLegale"]);

        return $result;
    }

    private function formatErrorResponse(\Throwable $throwable): SirenApiResult
    {
        $result = new SirenApiResult(SirenFinderStrategyEnum::BY_API);
        $result->code = $throwable->getCode();
        $result->message = $throwable->getMessage();

        return $result;
    }
}