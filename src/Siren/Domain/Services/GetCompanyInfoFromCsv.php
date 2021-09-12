<?php

namespace App\Siren\Domain\Services;

use App\Siren\Domain\Model\Company;
use App\Siren\Domain\Model\CompanyAddress;

final class GetCompanyInfoFromCsv
{
    private string $csvFile;

    public function __construct(
        string $csvFile
    ) {
        $this->csvFile = $csvFile;
    }

    /**
     * Parse a csv file and return an array of companies
     *
     * @return Company[]
     */
    public function getCompanyInfo(array $indexes): array
    {
        $file = fopen($this->csvFile, "r");
        $csvAsArray = [];
        while (!feof($file)) {
            $csvAsArray[] = fgetcsv($file, 2048, ";");
        }
        fclose($file);

        $companies = [];
        foreach ($indexes as $index) {
            $line = $csvAsArray[$index];
            $companies[] = $this->createCompanyFromCsvData($line);
        }

        return $companies;
    }

    private function createCompanyFromCsvData(array $data): Company
    {
        $company = new Company();
        $company->setSiren($data[0]);
        $company->setNic($data[1]);
        $company->setName($data[2]);
        $company->setBrand($data[36]);
        $company->setCategory(utf8_encode(trim($data[41])));

        $address = new CompanyAddress();
        $address->setStreetAddress($data[5]);
        $address->setPostalCode($data[20]);
        $address->setAddressLocality($data[28]);
        $address->setAddressRegion(utf8_encode(trim($data[23])));
        $address->setAddressCountry($data[8]);

        $company->setAddress($address);

        return $company;
    }
}