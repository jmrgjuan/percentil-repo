<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ValuationControllerTest extends WebTestCase
{
    public function testEstimateEndpointWithValidData(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/v1/valuation/estimate',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'brand' => 'Zara',
                'category' => 'chaqueta',
                'condition' => 'good'
            ])
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $responseData = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals('ok', $responseData['status']);
        $this->assertArrayHasKey('data', $responseData);
        $this->assertEquals('Zara', $responseData['data']['brand']);
        $this->assertEquals('chaqueta', $responseData['data']['category']);
        $this->assertEquals('good', $responseData['data']['condition']);
        $this->assertArrayHasKey('estimated_price', $responseData['data']);
        $this->assertIsNumeric($responseData['data']['estimated_price']);
    }

    public function testEstimateEndpointWithMissingBrand(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/v1/valuation/estimate',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'category' => 'chaqueta',
                'condition' => 'good'
            ])
        );

        $this->assertEquals(400, $client->getResponse()->getStatusCode());

        $responseData = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('error', $responseData);
        $this->assertStringContainsString('Missing required fields', $responseData['error']);
    }

    public function testEstimateEndpointWithMissingCategory(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/v1/valuation/estimate',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'brand' => 'Zara',
                'condition' => 'good'
            ])
        );

        $this->assertEquals(400, $client->getResponse()->getStatusCode());

        $responseData = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('error', $responseData);
        $this->assertStringContainsString('Missing required fields', $responseData['error']);
    }

    public function testEstimateEndpointWithMissingCondition(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/v1/valuation/estimate',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'brand' => 'Zara',
                'category' => 'chaqueta'
            ])
        );

        $this->assertEquals(400, $client->getResponse()->getStatusCode());

        $responseData = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('error', $responseData);
        $this->assertStringContainsString('Missing required fields', $responseData['error']);
    }

    public function testEstimateEndpointWithInvalidCondition(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/v1/valuation/estimate',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'brand' => 'Zara',
                'category' => 'chaqueta',
                'condition' => 'invalid_condition'
            ])
        );

        $this->assertEquals(400, $client->getResponse()->getStatusCode());

        $responseData = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('error', $responseData);
        $this->assertStringContainsString('Invalid condition', $responseData['error']);
    }

    public function testEstimateEndpointWithNewCondition(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/v1/valuation/estimate',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'brand' => 'Zara',
                'category' => 'chaqueta',
                'condition' => 'new'
            ])
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $responseData = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals('new', $responseData['data']['condition']);
        // El precio con condición 'new' debería ser mayor que con 'good'
        $this->assertGreaterThan(100, $responseData['data']['estimated_price']);
    }

    public function testEstimateEndpointWithFairCondition(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/v1/valuation/estimate',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'brand' => 'NoName',
                'category' => 'chaqueta',
                'condition' => 'fair'
            ])
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $responseData = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals('fair', $responseData['data']['condition']);
        // El precio con condición 'fair' debería ser menor que 100 (precio base)
        $this->assertLessThan(100, $responseData['data']['estimated_price']);
    }

    public function testEstimateEndpointWithEmptyBody(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/v1/valuation/estimate',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{}'
        );

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }
}
