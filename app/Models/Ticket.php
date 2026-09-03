<?php

namespace App\Models;

class Ticket
{
    private string $title;
    private string $description;

    public function __construct(
        string $title,
        string $description
    )
    {
        $this->title = $title;
        $this->description = $description;
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