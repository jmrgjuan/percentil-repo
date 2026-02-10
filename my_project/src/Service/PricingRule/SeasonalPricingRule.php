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
        $currentMonth = (int) date('n'); // 1-12

        // Temporadas altas para ropa
        $highSeasonMonths = [
            11, // Noviembre (Black Friday)
            12, // Diciembre (Navidad)
            1,  // Enero (Rebajas)
            6,  // Junio (Verano)
            7,  // Julio (Verano)
        ];

        if (in_array($currentMonth, $highSeasonMonths, true)) {
            return $currentPrice * 1.15; // +15% en temporada alta
        }

        return $currentPrice;
    }

    public function getDescription(): string
    {
        return 'Ajusta el precio según la temporada del año';
    }
}
