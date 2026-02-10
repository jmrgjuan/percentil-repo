<?php

namespace App\Controller;

use App\Enum\ProductCondition;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ValuationController extends AbstractController
{
    public function estimate(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $brand = $data['brand'] ?? null;
        $category = $data['category'] ?? null;
        $conditionString = $data['condition'] ?? null;

        // Validar que los campos requeridos estén presentes
        if (!$brand || !$category || !$conditionString) {
            return new JsonResponse([
                'error' => 'Missing required fields: brand, category, condition'
            ], 400);
        }

        // Convertir el string a objeto ProductCondition
        try {
            $condition = ProductCondition::fromString(strtolower($conditionString));
        } catch (\InvalidArgumentException $e) {
            return new JsonResponse([
                'error' => $e->getMessage()
            ], 400);
        }

        return new JsonResponse([
            'status' => 'ok',
            'data' => [
                'brand' => $brand,
                'category' => $category,
                'condition' => $condition->getValue()
            ]
        ]);
    }
}
