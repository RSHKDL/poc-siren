<?php

namespace App\Siren\Domain\Services;

use App\Siren\Domain\Model\Company;
use App\Siren\Domain\Model\CompanyAddress;
use App\Siren\Domain\ValueObject\CompanyApiResult;
use App\Siren\Domain\ValueObject\CompanyResultInterface;
use App\Siren\Domain\ValueObject\SirenResultInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class CompanyInfoFromApiGetter implements CompanyInfoGetterStrategy
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

    public function getCompanyInfo(SirenResultInterface $data): CompanyResultInterface
    {
        try {
            $response = $this->httpClient->request(
                "GET",
                "https://api.insee.fr/entreprises/sirene/V3/siret/{$data->getSiret()}",
                ['auth_bearer' => $this->token]
            );
            $company = $this->createCompanyFromApiData($response->toArray());
            $result = new CompanyApiResult($company);
        } catch (\Throwable $throwable) {
            //todo handle api response when errors
            dd("todo", $throwable);
            $result = new CompanyApiResult();
        }

        return $result;
    }

    private function createCompanyFromApiData(array $data): Company
    {
        $c = $data["etablissement"];
        $u = $c["uniteLegale"];
        $company = new Company($c["siren"], $c["nic"]);
        $company->setName($u["denominationUniteLegale"]);
        $company->setBrand($u["sigleUniteLegale"]);
        $company->setCategory($u["categorieEntreprise"]);

        $a = $c["adresseEtablissement"];
        $address = new CompanyAddress();
        $address->setStreetAddress(
            "{$a['numeroVoieEtablissement']} {$a['typeVoieEtablissement']} {$a['libelleVoieEtablissement']}"
        );
        $address->setPostalCode($a["codePostalEtablissement"]);
        $address->setAddressLocality($a["libelleCommuneEtablissement"]);
        $address->setAddressRegion($a["libelleCedexEtablissement"]);
        $address->setAddressCountry($a["libellePaysEtrangerEtablissement"]);

        $company->setAddress($address);

        return $company;
    }
}