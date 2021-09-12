<?php

namespace App\Siren\Application\Command;

use App\CQRS\Command;
use App\CQRS\CommandHandler;
use App\Siren\Domain\Services\GetCompanyInfoFromCsv;


class GetCompanyInfoCommandHandler implements CommandHandler
{
    private GetCompanyInfoFromCsv $fromCsv;

    public function __construct(GetCompanyInfoFromCsv $fromCsv)
    {
        $this->fromCsv = $fromCsv;
    }

    /**
     * @param GetCompanyInfoCommand $command
     */
    public function handle(Command $command): array
    {
        return $this->fromCsv->getCompanyInfo($command->indexes);
    }
}