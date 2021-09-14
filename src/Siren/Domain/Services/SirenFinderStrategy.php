<?php

namespace App\Siren\Domain\Services;

use App\Siren\Domain\ValueObject\SirenResultInterface;

interface SirenFinderStrategy
{
    public function find(string $siren): SirenResultInterface;
}