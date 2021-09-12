<?php

namespace App\Siren\Application\Query;

use App\CQRS\Query;
use App\CQRS\QueryHandler;
use App\Siren\Domain\Exception\SirenNotFoundException;
use App\Siren\Domain\Services\SirenOccurrencesFinder;
use App\Siren\Domain\ValueObject\SirenOccurrencesResult;

class FindCompanyQueryHandler implements QueryHandler
{
    private string $path;
    private SirenOccurrencesFinder $sirenOccurrencesFinder;

    public function __construct(
        string $path,
        SirenOccurrencesFinder $sirenOccurrencesFinder
    ) {
        $this->path = $path;
        $this->sirenOccurrencesFinder = $sirenOccurrencesFinder;
    }

    /**
     * @param FindCompanyQuery $query
     * @throws SirenNotFoundException
     */
    public function handle(Query $query): SirenOccurrencesResult
    {
        $data = [];
        $file = fopen($this->path, "r");
        while (($csv = fgetcsv($file, 2048, ";")) !== false) {
            for ($column = 0; $column < 1; $column++) {
                $data[] = $csv[$column];
            }
        }
        fclose($file);

        return $this->sirenOccurrencesFinder->findOccurrences($data, $query->siren);
    }


}