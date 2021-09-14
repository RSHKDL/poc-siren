<?php

namespace App\Siren\Application\Query;

use App\CQRS\Query;

class FindCompanyQuery implements Query
{
    public string $siren;
    public string $mode;

    public function __construct(string $siren, string $mode)
    {
        $this->siren = $siren;
        $this->mode = $mode;
    }
}