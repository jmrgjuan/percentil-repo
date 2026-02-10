<?php

namespace App\Tests\Service;

use App\Enum\ProductCondition;
use App\Service\PricingRule\BrandPricingRule;
use App\Service\PricingRule\ConditionPricingRule;
use App\Service\PricingRule\SeasonalPricingRule;
use App\Service\ValuationService;
use PHPUnit\Framework\TestCase;

class ValuationServiceTest extends TestCase
{
    private $valuationService;

    protected function setUp(): void
    {
        // Crear el servicio con todas las reglas de pricing
        $this->valuationService = new ValuationService([
            new ConditionPricingRule(),
            new BrandPricingRule(),
            new SeasonalPricingRule(),
        ]);
    }

    public function testCalculatePriceWithGoodConditionAndUnknownBrand(): void
    {
        $price = $this->valuationService->calculatePrice(
            'NoName',
            'chaqueta',
            ProductCondition::fromString('good')
        );

        // Precio base chaqueta: 100
        // Condición good: x1.0 = 100
        // Marca desconocida: x1.0 = 100
        // Temporada (Feb): x1.0 = 100
        $this->assertEquals(100.0, $price);
    }

    public function testCalculatePriceWithNewConditionAndZaraBrand(): void
    {
        $price = $this->valuationService->calculatePrice(
            'Zara',
            'chaqueta',
            ProductCondition::fromString('new')
        );

        // Precio base chaqueta: 100
        // Condición new: x1.5 = 150
        // Marca Zara: x1.10 = 165
        // Temporada (Feb): x1.0 = 165
        $this->assertEquals(165.0, $price);
    }

    public function testCalculatePriceWithFairCondition(): void
    {
        $price = $this->valuationService->calculatePrice(
            'H&M',
            'camisa',
            ProductCondition::fromString('fair')
        );

        // Precio base camisa: 80
        // Condición fair: x0.7 = 56
        // Marca H&M: x1.05 = 58.8
        // Temporada (Feb): x1.0 = 58.8
        $this->assertEquals(58.8, $price);
    }

    public function testCalculatePriceWithLuxuryBrand(): void
    {
        $price = $this->valuationService->calculatePrice(
            'Gucci',
            'bolso',
            ProductCondition::fromString('good')
        );

        // Precio base bolso: 250
        // Condición good: x1.0 = 250
        // Marca Gucci: x2.5 = 625
        // Temporada (Feb): x1.0 = 625
        $this->assertEquals(625.0, $price);
    }

    public function testCalculatePriceWithUnknownCategory(): void
    {
        // Categoría no definida debe usar precio por defecto (50)
        $price = $this->valuationService->calculatePrice(
            'Zara',
            'categoria_desconocida',
            ProductCondition::fromString('good')
        );

        // Precio base default: 50
        // Condición good: x1.0 = 50
        // Marca Zara: x1.10 = 55
        // Temporada (Feb): x1.0 = 55
        $this->assertEquals(55.0, $price);
    }

    public function testPriceIsRoundedToTwoDecimals(): void
    {
        $price = $this->valuationService->calculatePrice(
            'Mango',
            'vestido_largo',
            ProductCondition::fromString('new')
        );

        // Verificar que el precio tiene máximo 2 decimales
        $this->assertRegExp('/^\d+(\.\d{1,2})?$/', (string) $price);
    }
}
