<?php

declare(strict_types=1);

namespace Battiato\Menu;

/**
 * Producto del menú (entidad). Corresponde a una fila de la tabla menu_items.
 *
 * Es inmutable: para cambiar un dato se crea una instancia nueva.
 */
final class MenuItem
{
    private ?int $id;
    private int $categoryId;
    private ?int $subcategoryId;
    private string $name;
    private ?string $description;
    private float $price;
    private ?string $priceNote;
    private int $sortOrder;
    private bool $active;

    public function __construct(
        ?int $id,
        int $categoryId,
        ?int $subcategoryId,
        string $name,
        ?string $description,
        float $price,
        ?string $priceNote,
        int $sortOrder,
        bool $active
    ) {
        $this->id = $id;
        $this->categoryId = $categoryId;
        $this->subcategoryId = $subcategoryId;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->priceNote = $priceNote;
        $this->sortOrder = $sortOrder;
        $this->active = $active;
    }

    /**
     * Construye el producto a partir de una fila de la base de datos
     * (llaves en snake_case: category_id, price_note, ...).
     *
     * @param array<string, mixed> $row Fila devuelta por PDO.
     */
    public static function fromRow(array $row): self
    {
        return new self(
            (int) $row['id'],
            (int) $row['category_id'],
            $row['subcategory_id'] !== null ? (int) $row['subcategory_id'] : null,
            (string) $row['name'],
            $row['description'] !== null ? (string) $row['description'] : null,
            (float) $row['price'],
            $row['price_note'] !== null ? (string) $row['price_note'] : null,
            (int) $row['sort_order'],
            (bool) (int) $row['active']
        );
    }

    /**
     * Construye el producto a partir de los datos de un formulario ($_POST).
     * Los textos se recortan y los vacíos quedan como null.
     * Se debe validar antes con MenuItemValidator::validate().
     *
     * @param array<string, mixed> $input Datos del formulario.
     */
    public static function fromInput(array $input): self
    {
        $id = (int) ($input['id'] ?? 0);
        $subcategory = (string) ($input['subcategory_id'] ?? '');
        $description = trim((string) ($input['description'] ?? ''));
        $priceNote = trim((string) ($input['price_note'] ?? ''));

        return new self(
            $id > 0 ? $id : null,
            (int) ($input['category_id'] ?? 0),
            $subcategory === '' ? null : (int) $subcategory,
            trim((string) ($input['name'] ?? '')),
            $description === '' ? null : $description,
            (float) ($input['price'] ?? 0),
            $priceNote === '' ? null : $priceNote,
            (int) ($input['sort_order'] ?? 0),
            isset($input['active'])
        );
    }

    /** Devuelve una copia del producto con el id asignado por la base de datos. */
    public function withId(int $id): self
    {
        return new self(
            $id,
            $this->categoryId,
            $this->subcategoryId,
            $this->name,
            $this->description,
            $this->price,
            $this->priceNote,
            $this->sortOrder,
            $this->active
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function getSubcategoryId(): ?int
    {
        return $this->subcategoryId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getPriceNote(): ?string
    {
        return $this->priceNote;
    }

    public function getSortOrder(): int
    {
        return $this->sortOrder;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * Devuelve el producto como arreglo asociativo con las mismas llaves que
     * la tabla (snake_case). Lo usan las vistas que recorren arreglos.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id'             => $this->id,
            'category_id'    => $this->categoryId,
            'subcategory_id' => $this->subcategoryId,
            'name'           => $this->name,
            'description'    => $this->description,
            'price'          => $this->price,
            'price_note'     => $this->priceNote,
            'sort_order'     => $this->sortOrder,
            'active'         => $this->active ? 1 : 0,
        ];
    }
}
