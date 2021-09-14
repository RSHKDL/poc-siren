<?php

namespace App\Siren\Domain\Services;

use App\Siren\Domain\Enum\SirenFinderStrategyEnum;
use App\Siren\Domain\ValueObject\SirenCsvResult;

final class SirenOccurrencesFinder
{
    public function findOccurrences(array $array, int $siren): SirenCsvResult
    {
        $result = new SirenCsvResult(SirenFinderStrategyEnum::BY_CSV);
        $size = count($array);
        $index = $this->binarySearch($array, 0, $size - 1, $siren);

        if ($index == -1) {
            $result->occurrencesCount = 0;
        } else {
            $indexes = [];
            $indexes[] = $index;

            $count = 1;
            $left = $index - 1;
            while ($left >= 0 && $array[$left] == $siren)
            {
                $indexes[] = $left;
                $count++;
                $left--;
            }

            $right = $index + 1;
            while ($right < $size && $array[$right] == $siren)
            {
                $indexes[] = $right;
                $count++;
                $right++;
            }

            sort($indexes, SORT_NUMERIC);
            $result->occurrencesCount = $count;
            $result->occurrencesIndexes = $indexes;
        }

        return $result;
    }

    private function binarySearch(array &$array, int $min, int $max, int $x): int
    {
        if ($max < $min)
            return -1;

        $mid = ceil($min + ($max - $min) / 2);

        if ($array[$mid] == $x)
            return $mid;

        if ($array[$mid] > $x)
            return $this->binarySearch($array, $min, $mid - 1, $x);

        return $this->binarySearch($array, $mid + 1, $max, $x);
    }
}