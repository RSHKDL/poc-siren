<?php

namespace App\Siren\Application\Query;

use App\CQRS\Query;
use App\CQRS\QueryHandler;
use App\Siren\Domain\Enum\SirenFinderStrategyEnum;
use App\Siren\Domain\Exception\SirenNotFoundException;
use App\Siren\Domain\Exception\UnknownFinderStrategyException;
use App\Siren\Domain\Services\SirenFromApiFinder;
use App\Siren\Domain\Services\SirenFromCsvFinder;
use App\Siren\Domain\ValueObject\SirenResultInterface;

class FindCompanyQueryHandler implements QueryHandler
{
    private SirenFromApiFinder $apiFinder;
    private SirenFromCsvFinder $csvFinder;

    public function __construct(
        SirenFromApiFinder $apiFinder,
        SirenFromCsvFinder $csvFinder
    ) {
        $this->apiFinder = $apiFinder;
        $this->csvFinder = $csvFinder;
    }

    /**
     * @param FindCompanyQuery $query
     * @throws SirenNotFoundException
     */
    public function handle(Query $query): SirenResultInterface
    {
        switch ($query->mode) {
            case SirenFinderStrategyEnum::BY_CSV:
                $result = $this->csvFinder->find($query->siren);
                break;
            case SirenFinderStrategyEnum::BY_API:
                $result = $this->apiFinder->find($query->siren);
                break;
            default:
                throw new UnknownFinderStrategyException("{$query->mode} is not supported");
        }

        return $result;
    }


}