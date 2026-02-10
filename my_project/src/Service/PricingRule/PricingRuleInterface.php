<?php

namespace App\Service\PricingRule;

use App\Enum\ProductCondition;

/**
 * Interfaz para las reglas de pricing (Strategy Pattern)
 *
 * Cada regla de negocio implementará esta interfaz y modificará
 * el precio según sus propios criterios
 */
interface PricingRuleInterface
{
    /**
     * Aplica la regla de pricing al precio actual
     *
     * @param float $currentPrice Precio actual
     * @param string $brand Marca del producto
     * @param string $category Categoría del producto
     * @param ProductCondition $condition Estado del producto
     * @return float Precio modificado
     */
    public function apply(float $currentPrice, string $brand, string $category, ProductCondition $condition): float;

    /**
     * Devuelve una descripción de qué hace esta regla
     *
     * @return string
     */
    public function getDescription(): string;
}
