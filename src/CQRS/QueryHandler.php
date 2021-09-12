<?php

namespace App\CQRS;

interface QueryHandler
{
    public function handle(Query $query);
}