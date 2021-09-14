<?php

namespace App\Siren\Domain\Services;

use App\Siren\Domain\ValueObject\CompanyResultInterface;
use App\Siren\Domain\ValueObject\SirenResultInterface;

interface CompanyInfoGetterStrategy
{
    public function getCompanyInfo(SirenResultInterface $data): CompanyResultInterface;
}