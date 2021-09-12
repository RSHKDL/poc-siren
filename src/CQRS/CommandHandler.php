<?php

namespace App\CQRS;

interface CommandHandler
{
    public function handle(Command $command);
}