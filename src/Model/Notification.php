<?php

namespace App\Model;

class Notification
{
    public function __construct(
        private string $title,
        private string $description,
        private ?string $cta = null,
    ) {}

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getCta(): ?string
    {
        return $this->cta;
    }

    public function setCta(?string $cta): void
    {
        $this->cta = $cta;
    }
}
