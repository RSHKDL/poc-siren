<?php

namespace App\Siren\Domain\ValueObject;

use App\Siren\Domain\Model\Company;

interface CompanyResultInterface
{
    /**
     * Return an array of Companies
     *
     * @return Company[]
     */
    public function getCompanies(): array;
}