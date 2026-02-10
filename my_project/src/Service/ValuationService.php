<?php

namespace App\Service;

use App\Enum\ProductCondition;

/**
 * Servicio principal de evaluación de productos
 *
 * Calcula el precio estimado de un producto aplicando:
 * - Precio base según categoría
 * - Reglas de negocio dinámicas usando patrón Strategy
 */
class ValuationService
{
    private $pricingRules = [];

    public function __construct()
    {
        // TODO: Inyectar las reglas de pricing mediante Dependency Injection
        // $this->pricingRules = $pricingRules;
    }

    /**
     * Calcula el precio estimado del producto
     *
     * @param string $brand Marca del producto
     * @param string $category Categoría del producto
     * @param ProductCondition $condition Estado del producto
     * @return float Precio estimado
     */
    public function calculatePrice(string $brand, string $category, ProductCondition $condition): float
    {
        // 1. Obtener precio base según categoría
        $basePrice = $this->getBasePrice($category);

        // 2. Aplicar reglas de negocio dinámicas (Strategy Pattern)
        // TODO: Iterar sobre $this->pricingRules y aplicar cada una
        // foreach ($this->pricingRules as $rule) {
        //     $basePrice = $rule->apply($basePrice, $brand, $category, $condition);
        // }

        return $basePrice;
    }

    /**
     * Obtiene el precio base según la categoría del producto
     *
     * @param string $category
     * @return float
     */
    private function getBasePrice(string $category): float
    {
        // TODO: Definir precios base por categoría
        // Podría venir de base de datos, configuración, etc.

        $basePrices = [
            'chaqueta' => 100.0,
            'pantalon_vaquero' => 300.0,
            'falda_corta' => 150.0,
            'camisa' => 80.0,
            'zapatos' => 200.0,
            'bolso' => 250.0,
            'traje_hombre' => 500.0,
            'vestido_largo' => 400.0,
            // ... más categorías
        ];

        return $basePrices[$category] ?? 50.0; // Precio por defecto
    }
}
