<?php

namespace App\Siren\Domain\Services;

use App\Siren\Domain\Model\Company;
use App\Siren\Domain\Model\CompanyAddress;
use App\Siren\Domain\ValueObject\CompanyCsvResult;
use App\Siren\Domain\ValueObject\CompanyResultInterface;
use App\Siren\Domain\ValueObject\SirenResultInterface;

final class CompanyInfoFromCsvGetter implements CompanyInfoGetterStrategy
{
    private string $csvFile;

    public function __construct(string $csvFile)
    {
        $this->csvFile = $csvFile;
    }

    /**
     * Parse a csv file and return a CompanyResultInterface
     */
    public function getCompanyInfo(SirenResultInterface $data): CompanyResultInterface
    {
        $file = fopen($this->csvFile, "r");
        $csvAsArray = [];
        while (!feof($file)) {
            $csvAsArray[] = fgetcsv($file, 2048, ";");
        }
        fclose($file);

        $companies = [];
        foreach ($data->getIndexes() as $index) {
            $line = $csvAsArray[$index];
            $companies[] = $this->createCompanyFromCsvData($line);
        }

        return new CompanyCsvResult($companies);
    }

    private function createCompanyFromCsvData(array $data): Company
    {
        $company = new Company($data[0], $data[1]);
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