<?php

namespace App\Siren\Application\Command;

use App\CQRS\Command;
use App\Siren\Domain\ValueObject\SirenResultInterface;

class GetCompanyInfoCommand implements Command
{
    public SirenResultInterface $result;

    public function __construct(SirenResultInterface $result)
    {
        $this->result = $result;
    }
}