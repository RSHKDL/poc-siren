<?php

namespace App\Siren\Application\Query;

use App\CQRS\Query;
use App\CQRS\QueryHandler;
use App\Siren\Domain\Exception\UnknownFinderStrategyException;
use App\Siren\Domain\Services\SirenFinderStrategy;
use App\Siren\Domain\ValueObject\SirenResultInterface;

class FindCompanyQueryHandler implements QueryHandler
{
    private iterable $strategies;

    public function __construct(iterable $strategies)
    {
        $this->strategies = $strategies;
    }

    /**
     * @param FindCompanyQuery $query
     */
    public function handle(Query $query): SirenResultInterface
    {
        /** @var SirenFinderStrategy $strategy */
        foreach ($this->strategies as $strategy) {
            if ($strategy->isEligible($query->mode)) {
                return $strategy->find($query->siren);
            }
        }

        throw new UnknownFinderStrategyException("{$query->mode} is not supported");
    }


}