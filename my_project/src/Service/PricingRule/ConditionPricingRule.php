<?php

namespace App\Service\PricingRule;

use App\Enum\ProductCondition;

/**
 * Regla: Ajuste de precio según el estado del producto
 *
 * Ejemplo: Si el estado es "nuevo", multiplica por 1.5
 */
class ConditionPricingRule implements PricingRuleInterface
{
    public function apply(float $currentPrice, string $brand, string $category, ProductCondition $condition): float
    {
        // Multiplicadores según el estado del producto
        $conditionMultipliers = [
            ProductCondition::NEW => 1.5,   // Nuevo: +50%
            ProductCondition::GOOD => 1.0,  // Bueno: sin cambio
            ProductCondition::FAIR => 0.7,  // Aceptable: -30%
        ];

        $multiplier = $conditionMultipliers[$condition->getValue()] ?? 1.0;

        return $currentPrice * $multiplier;
    }

    public function getDescription(): string
    {
        return 'Ajusta el precio según el estado/condición del producto';
    }
}
