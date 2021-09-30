<?php

namespace App\Siren\Domain\Services;

use App\Siren\Domain\Enum\SirenFinderStrategyEnum;
use App\Siren\Domain\Exception\SirenNotFoundException;
use App\Siren\Domain\ValueObject\SirenResultInterface;

final class SirenFromCsvFinder implements SirenFinderStrategy
{
    private string $path;
    private SirenOccurrencesFinder $occurrencesFinder;

    public function __construct(
        string $path,
        SirenOccurrencesFinder $occurrencesFinder
    ) {
        $this->path = $path;
        $this->occurrencesFinder = $occurrencesFinder;
    }

    public function isEligible(string $mode): bool
    {
        return $mode === SirenFinderStrategyEnum::BY_CSV;
    }

    /**
     * Return SirenResultInterface or throw an exception
     *
     * @throws SirenNotFoundException
     */
    public function find(string $siren): SirenResultInterface
    {
        $data = [];
        $file = fopen($this->path, "r");
        while (($csv = fgetcsv($file, 2048, ";")) !== false) {
            for ($column = 0; $column < 1; $column++) {
                $data[] = $csv[$column];
            }
        }
        fclose($file);

        $result = $this->occurrencesFinder->findOccurrences($data, $siren);
        if (0 === $result->occurrencesCount) {
            throw new SirenNotFoundException("No company found with siren: $siren");
        } else {
            return $result;
        }
    }
}