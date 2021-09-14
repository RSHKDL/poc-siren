<?php

namespace App\Siren\Application\Command;

use App\CQRS\Command;
use App\CQRS\CommandHandler;
use App\Siren\Domain\Enum\SirenFinderStrategyEnum;
use App\Siren\Domain\Exception\UnknownFinderStrategyException;
use App\Siren\Domain\Services\CompanyInfoFromApiGetter;
use App\Siren\Domain\Services\CompanyInfoFromCsvGetter;
use App\Siren\Domain\ValueObject\CompanyResultInterface;


class GetCompanyInfoCommandHandler implements CommandHandler
{
    private CompanyInfoFromCsvGetter $fromCsv;
    private CompanyInfoFromApiGetter $fromApi;

    public function __construct(
        CompanyInfoFromCsvGetter $fromCsv,
        CompanyInfoFromApiGetter $fromApi
    ) {
        $this->fromCsv = $fromCsv;
        $this->fromApi = $fromApi;
    }

    /**
     * @param GetCompanyInfoCommand $command
     */
    public function handle(Command $command): CompanyResultInterface
    {
        $strategy = $command->result->getStrategy();
        switch ($strategy) {
            case SirenFinderStrategyEnum::BY_API:
                $result = $this->fromApi->getCompanyInfo($command->result);
                break;
            case SirenFinderStrategyEnum::BY_CSV:
                $result = $this->fromCsv->getCompanyInfo($command->result);
                break;
            default:
                throw new UnknownFinderStrategyException("{$strategy} is not supported");
        }

        return $result;
    }
}