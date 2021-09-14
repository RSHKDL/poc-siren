<?php

namespace App\Siren\Domain\ValueObject;

use App\Siren\Domain\Model\Company;

final class CompanyApiResult implements CompanyResultInterface
{
    private ?Company $company;

    public function __construct(?Company $company = null)
    {
        $this->company = $company;
    }

    public function getCompanies(): array
    {
        return [$this->company];
    }
}