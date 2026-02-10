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
        // Multiplicadores por marca de ropa
        $brandMultipliers = [
            'Zara' => 1.10,      // +10%
            'H&M' => 1.05,       // +5%
            'Mango' => 1.15,     // +15%
            'Massimo Dutti' => 1.25, // +25%
            'Gucci' => 2.50,     // +150%
            'Prada' => 2.30,     // +130%
            'Louis Vuitton' => 2.80, // +180%
            'Armani' => 2.00,    // +100%
        ];

        $multiplier = $brandMultipliers[$brand] ?? 1.0;

        return $currentPrice * $multiplier;
    }

    public function getDescription(): string
    {
        return 'Ajusta el precio según la marca del producto';
    }
}
