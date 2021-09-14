<?php

namespace App\Siren\Domain\Services;

use App\Siren\Domain\ValueObject\CompanyResultInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class JsonFormatter
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function format(CompanyResultInterface $companyResult): string
    {
        return $this->serializer->serialize($companyResult, 'json');
    }
}