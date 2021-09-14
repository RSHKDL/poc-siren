<?php

namespace App\Siren\Domain\ValueObject;

use Symfony\Component\HttpFoundation\Response;

final class SirenApiResult implements SirenResultInterface
{
    private string $strategy;
    public int $code = Response::HTTP_OK;
    public string $message = "success";
    public string $siren;
    public string $mostRecentNic;
    public int $periodsCount;

    public function __construct(string $strategy)
    {
        $this->strategy = $strategy;
    }

    public function getStrategy(): string
    {
        return $this->strategy;
    }

    public function isNotFound(): bool
    {
        $isNotFound = false;
        if (Response::HTTP_NOT_FOUND === $this->code || Response::HTTP_BAD_REQUEST === $this->code) {
            $isNotFound = true;
        }

        return $isNotFound;
    }

    public function getSiret(): ?string
    {
        return $this->siren . $this->mostRecentNic;
    }

    public function getIndexes(): array
    {
        return [];
    }
}