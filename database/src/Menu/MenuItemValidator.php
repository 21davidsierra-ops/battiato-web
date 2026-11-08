<?php

declare(strict_types=1);

namespace Battiato\Menu;

/**
 * Valida en el servidor los datos de un producto antes de guardarlo.
 * Los límites coinciden con las columnas de la tabla menu_items.
 */
final class MenuItemValidator
{
    public const MAX_NAME_LENGTH = 150;
    public const MAX_PRICE_NOTE_LENGTH = 60;
    public const MAX_PRICE = 99999999.99;

    /**
     * Revisa los datos recibidos de un formulario.
     *
     * @param array<string, mixed> $input Datos del formulario ($_POST).
     *
     * @return string[] Mensajes de error en español; arreglo vacío si todo es válido.
     */
    public function validate(array $input): array
    {
        $errors = [];

        if (!$this->isPositiveInteger($input['category_id'] ?? null)) {
            $errors[] = 'Categoría inválida.';
        }

        $subcategory = $input['subcategory_id'] ?? '';
        if ($subcategory !== '' && !$this->isPositiveInteger($subcategory)) {
            $errors[] = 'Subcategoría inválida.';
        }

        $name = trim((string) ($input['name'] ?? ''));
        if ($name === '') {
            $errors[] = 'El nombre del producto es obligatorio.';
        } elseif ($this->textLength($name) > self::MAX_NAME_LENGTH) {
            $errors[] = 'El nombre no puede superar ' . self::MAX_NAME_LENGTH . ' caracteres.';
        }

        $price = $input['price'] ?? null;
        if (!is_numeric($price)) {
            $errors[] = 'El precio debe ser un número.';
        } elseif ((float) $price < 0) {
            $errors[] = 'El precio no puede ser negativo.';
        } elseif ((float) $price > self::MAX_PRICE) {
            $errors[] = 'El precio es demasiado alto.';
        }

        $priceNote = trim((string) ($input['price_note'] ?? ''));
        if ($this->textLength($priceNote) > self::MAX_PRICE_NOTE_LENGTH) {
            $errors[] = 'La nota del precio no puede superar ' . self::MAX_PRICE_NOTE_LENGTH . ' caracteres.';
        }

        $sortOrder = $input['sort_order'] ?? '';
        if ($sortOrder !== '' && !$this->isNonNegativeInteger($sortOrder)) {
            $errors[] = 'El orden debe ser un número entero mayor o igual a cero.';
        }

        return $errors;
    }

    private function isPositiveInteger(mixed $value): bool
    {
        return $this->isNonNegativeInteger($value) && (int) $value > 0;
    }

    private function isNonNegativeInteger(mixed $value): bool
    {
        if (is_int($value)) {
            return $value >= 0;
        }

        return is_string($value) && ctype_digit($value);
    }

    /** Cuenta caracteres (no bytes), para que "ñ" y las tildes cuenten como uno. */
    private function textLength(string $text): int
    {
        return function_exists('mb_strlen') ? mb_strlen($text, 'UTF-8') : strlen($text);
    }
}
