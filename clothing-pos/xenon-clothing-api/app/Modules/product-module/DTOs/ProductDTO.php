<?php

namespace App\Modules\Product\DTOs;

class ProductDTO
{
    private string $name;
    private ?string $description;
    private float $sellingPrice;
    private ?string $specialNote;
    private bool $isEnabled;
    private string $code;
    private array $batches;
    private array $sizes;
    private array $colors;
    private array $images;

    public function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->description = $data['description'] ?? null;
        $this->sellingPrice = $data['selling_price'];
        $this->specialNote = $data['special_note'] ?? null;
        $this->isEnabled = $data['is_enabled'];
        $this->code = $data['code'];
        $this->batches = $data['batches'] ?? [];
        $this->sizes = $data['sizes'] ?? [];
        $this->colors = $data['colors'] ?? [];
        $this->images = $data['images'] ?? [];
    }

    // Getters
    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getSellingPrice(): float
    {
        return $this->sellingPrice;
    }

    public function getSpecialNote(): ?string
    {
        return $this->specialNote;
    }

    public function isEnabled(): bool
    {
        return $this->isEnabled;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getBatches(): array
    {
        return $this->batches;
    }

    public function getSizes(): array
    {
        return $this->sizes;
    }

    public function getColors(): array
    {
        return $this->colors;
    }

    public function getImages(): array
    {
        return $this->images;
    }

    // Setters (optional)
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function setSellingPrice(float $sellingPrice): void
    {
        $this->sellingPrice = $sellingPrice;
    }

    public function setSpecialNote(?string $specialNote): void
    {
        $this->specialNote = $specialNote;
    }

    public function setIsEnabled(bool $isEnabled): void
    {
        $this->isEnabled = $isEnabled;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function setBatches(array $batches): void
    {
        $this->batches = $batches;
    }

    public function setSizes(array $sizes): void
    {
        $this->sizes = $sizes;
    }

    public function setColors(array $colors): void
    {
        $this->colors = $colors;
    }

    public function setImages(array $images): void
    {
        $this->images = $images;
    }
}