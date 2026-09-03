<?php

namespace App\Models;

class Ticket
{
    public function __construct(
        private readonly string $title,
        private readonly string $description
    )
    {
    }

    public function getTitle() : string
    {
        return $this->title;
    }

    public function title(): string
    {
        return "Meu primeiro ticket";
    }
}