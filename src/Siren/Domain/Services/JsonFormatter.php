<?php

namespace App\Siren\Domain\Services;

use Symfony\Component\Serializer\SerializerInterface;

final class JsonFormatter
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function format(array $data): string
    {
        return $this->serializer->serialize($data, 'json');
    }
}