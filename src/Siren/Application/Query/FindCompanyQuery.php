<?php

namespace App\Siren\Application\Query;

use App\CQRS\Query;

class FindCompanyQuery implements Query
{
    public int $siren;
    public string $mode;

    public function __construct(int $siren, string $mode)
    {
        $this->siren = $siren;
        $this->mode = $mode;
    }
}