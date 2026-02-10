<?php

namespace App\Service\PricingRule;

use App\Enum\ProductCondition;

/**
 * Regla: Ajuste de precio según la marca
 * 
 * Ejemplo: Si la marca es "Zara", añade un 10%
 */
class BrandPricingRule implements PricingRuleInterface
{
    public function apply(float $currentPrice, string $brand, string $category, ProductCondition $condition): float
    {
        // TODO: Implementar lógica de ajuste por marca
        // 
        // Ejemplos:
        // - Si marca es "Zara" -> +10%
        // - Si marca es "Apple" -> +20%
        // - Si marca es "Samsung" -> +15%
        
        return $currentPrice;
    }

    public function getDescription(): string
    {
        return 'Ajusta el precio según la marca del producto';
    }
}
