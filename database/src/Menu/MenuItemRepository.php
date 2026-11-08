<?php

declare(strict_types=1);

namespace Battiato\Menu;

use InvalidArgumentException;
use PDO;

/**
 * Acceso a datos de los productos del menú (tabla menu_items).
 * Reúne las cuatro operaciones CRUD: crear, consultar, actualizar y eliminar.
 */
final class MenuItemRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Inserta un producto nuevo.
     *
     * @return int Id asignado por la base de datos.
     */
    public function create(MenuItem $item): int
    {
        $statement = $this->pdo->prepare(
            'INSERT INTO menu_items
                (category_id, subcategory_id, name, description, price, price_note, sort_order, active)
             VALUES
                (:category_id, :subcategory_id, :name, :description, :price, :price_note, :sort_order, :active)'
        );
        $statement->execute($this->buildParameters($item));

        return (int) $this->pdo->lastInsertId();
    }

    /**
     * Consulta un producto por su id.
     *
     * @return MenuItem|null El producto, o null si no existe.
     */
    public function findById(int $id): ?MenuItem
    {
        $statement = $this->pdo->prepare('SELECT * FROM menu_items WHERE id = :id');
        $statement->execute(['id' => $id]);
        $row = $statement->fetch();

        return $row ? MenuItem::fromRow($row) : null;
    }

    /**
     * Consulta los productos de una categoría, ordenados por subcategoría
     * (los que no tienen subcategoría primero) y luego por su orden.
     *
     * @param bool $onlyActive true para el sitio público (solo visibles);
     *                         false para el panel (incluye los ocultos).
     *
     * @return MenuItem[]
     */
    public function findByCategory(int $categoryId, bool $onlyActive = true): array
    {
        $sql = 'SELECT * FROM menu_items WHERE category_id = :category_id';

        if ($onlyActive) {
            $sql .= ' AND active = 1';
        }

        $sql .= ' ORDER BY subcategory_id IS NULL DESC, subcategory_id ASC, sort_order ASC, id ASC';

        $statement = $this->pdo->prepare($sql);
        $statement->execute(['category_id' => $categoryId]);

        return array_map(
            static fn (array $row): MenuItem => MenuItem::fromRow($row),
            $statement->fetchAll()
        );
    }

    /**
     * Actualiza un producto existente.
     *
     * @return bool true si el producto existe (aunque no haya cambiado ningún dato);
     *              false si no hay ningún producto con ese id.
     *
     * @throws InvalidArgumentException Si el producto no tiene id.
     */
    public function update(MenuItem $item): bool
    {
        $id = $item->getId();

        if ($id === null) {
            throw new InvalidArgumentException('No se puede actualizar un producto sin id.');
        }

        $statement = $this->pdo->prepare(
            'UPDATE menu_items
             SET category_id = :category_id,
                 subcategory_id = :subcategory_id,
                 name = :name,
                 description = :description,
                 price = :price,
                 price_note = :price_note,
                 sort_order = :sort_order,
                 active = :active
             WHERE id = :id'
        );
        $statement->execute($this->buildParameters($item) + ['id' => $id]);

        return $this->findById($id) !== null;
    }

    /**
     * Elimina un producto.
     *
     * @return bool true si se eliminó; false si no existía.
     */
    public function delete(int $id): bool
    {
        $statement = $this->pdo->prepare('DELETE FROM menu_items WHERE id = :id');
        $statement->execute(['id' => $id]);

        return $statement->rowCount() > 0;
    }

    /**
     * @return array<string, int|float|string|null>
     */
    private function buildParameters(MenuItem $item): array
    {
        return [
            'category_id'    => $item->getCategoryId(),
            'subcategory_id' => $item->getSubcategoryId(),
            'name'           => $item->getName(),
            'description'    => $item->getDescription(),
            'price'          => $item->getPrice(),
            'price_note'     => $item->getPriceNote(),
            'sort_order'     => $item->getSortOrder(),
            'active'         => $item->isActive() ? 1 : 0,
        ];
    }
}
