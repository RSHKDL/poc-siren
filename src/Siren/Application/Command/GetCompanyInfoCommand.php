<?php

namespace App\Siren\Application\Command;

use App\CQRS\Command;

class GetCompanyInfoCommand implements Command
{
    public array $indexes;

    public function __construct(array $indexes)
    {
        $this->indexes = $indexes;
    }
}