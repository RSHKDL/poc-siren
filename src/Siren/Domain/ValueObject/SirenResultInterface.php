<?php

namespace App\Siren\Domain\ValueObject;

interface SirenResultInterface
{
    public function getStrategy(): string;
    public function getSiret(): ?string;
    public function getIndexes(): array;
}