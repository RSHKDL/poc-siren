<?php

namespace App\Siren\Domain\ValueObject;

final class SirenCsvResult implements SirenResultInterface
{
    private string $strategy;
    public int $occurrencesCount;
    public array $occurrencesIndexes = [];

    public function __construct(string $strategy)
    {
        $this->strategy = $strategy;
    }

    public function getStrategy(): string
    {
        return $this->strategy;
    }

    public function getSiret(): ?string
    {
        return null;
    }

    public function getIndexes(): array
    {
        return $this->occurrencesIndexes;
    }
}