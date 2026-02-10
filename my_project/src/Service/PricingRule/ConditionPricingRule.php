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
        // TODO: Implementar lógica de ajuste por condición
        // 
        // Ejemplos:
        // - Si condition es "new" -> x1.5
        // - Si condition es "good" -> x1.0
        // - Si condition es "fair" -> x0.7
        
        return $currentPrice;
    }

    public function getDescription(): string
    {
        return 'Ajusta el precio según el estado/condición del producto';
    }
}
