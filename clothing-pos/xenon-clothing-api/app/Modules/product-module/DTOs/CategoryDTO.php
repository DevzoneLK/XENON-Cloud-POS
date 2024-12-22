<?php

namespace App\Modules\Product\DTOs;

class CategoryDTO
{
    private ?int $id;
    private string $name;
    private bool $isEnabled;

    /**
     * CategoryDTO constructor
     *  @param int $id
     * @param string $name
     * @param bool $isEnabled
     */
    public function __construct($data)
    {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'];
        $this->isEnabled = $data['is-enabled'];
    }

    /**
     * Get the id of the category
     *
     * @return string
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the name of the category
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the isEnabled status of the category
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->isEnabled;
    }

    public function toJsonResponse(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'is-enabled' => $this->isEnabled
        ];
    }
}
