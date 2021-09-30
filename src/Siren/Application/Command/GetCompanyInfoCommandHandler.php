<?php

namespace App\Siren\Application\Command;

use App\CQRS\Command;
use App\CQRS\CommandHandler;
use App\Siren\Domain\Exception\UnknownFinderStrategyException;
use App\Siren\Domain\Services\CompanyInfoGetterStrategy;
use App\Siren\Domain\ValueObject\CompanyResultInterface;

class GetCompanyInfoCommandHandler implements CommandHandler
{
    private iterable $strategies;

    public function __construct(iterable $strategies)
    {
        $this->strategies = $strategies;
    }

    /**
     * @param GetCompanyInfoCommand $command
     */
    public function handle(Command $command): CompanyResultInterface
    {
        $mode = $command->result->getStrategy();

        /** @var CompanyInfoGetterStrategy $strategy */
        foreach ($this->strategies as $strategy) {
            if ($strategy->isEligible($mode)) {
                return $strategy->getCompanyInfo($command->result);
            }
        }

        throw new UnknownFinderStrategyException("{$mode} is not supported");
    }
}