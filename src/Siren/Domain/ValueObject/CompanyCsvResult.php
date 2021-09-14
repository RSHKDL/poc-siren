<?php

namespace App\Siren\Domain\ValueObject;

final class CompanyCsvResult implements CompanyResultInterface
{
    private array $companies;

    public function __construct(array $companies)
    {
        $this->companies = $companies;
    }

    public function getCompanies(): array
    {
        return $this->companies;
    }
}