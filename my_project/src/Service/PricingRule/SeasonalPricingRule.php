<?php

namespace App\Service\PricingRule;

use App\Enum\ProductCondition;

/**
 * Regla: Ajuste de precio por temporada alta
 * 
 * Ejemplo: Si es temporada alta (Black Friday, Navidad, etc.), suma un bonus
 */
class SeasonalPricingRule implements PricingRuleInterface
{
    public function apply(float $currentPrice, string $brand, string $category, ProductCondition $condition): float
    {
        // TODO: Implementar lógica de ajuste por temporada
        // 
        // Ejemplos:
        // - Si fecha actual está en temporada alta -> +15%
        // - Temporadas altas: Noviembre-Diciembre (Navidad, Black Friday)
        // - Temporadas altas: Junio-Julio (Verano)
        
        return $currentPrice;
    }

    public function getDescription(): string
    {
        return 'Ajusta el precio según la temporada del año';
    }
}
