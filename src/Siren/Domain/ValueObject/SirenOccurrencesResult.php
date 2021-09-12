<?php

namespace App\Siren\Domain\ValueObject;

final class SirenOccurrencesResult
{
    public int $occurrencesCount;
    public array $occurrencesIndexes = [];
}