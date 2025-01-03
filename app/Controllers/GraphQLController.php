<?php

namespace App\Controllers;

use GraphQL\GraphQL as GraphQLBase;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;

class GraphQLController
{
    public function handle()
    {
        try {
            // Define Category type
            $categoryType = new ObjectType([
                'name' => 'Category',
                'fields' => [
                    'name' => Type::string(),
                ],
            ]);

            // Define Product type (expand as needed)
            $productType = new ObjectType([
                'name' => 'Product',
                'fields' => [
                    'id' => Type::string(),
                    'name' => Type::string(),
                    'category' => $categoryType,
                ],
            ]);

            // Define Query type
            $queryType = new ObjectType([
                'name' => 'Query',
                'fields' => [
                    'categories' => [
                        'type' => Type::listOf($categoryType),
                        'resolve' => fn() => [['name' => 'clothes'], ['name' => 'tech']],
                    ],
                    'products' => [
                        'type' => Type::listOf($productType),
                        'resolve' => fn() => [['id' => '1', 'name' => 'Product 1', 'category' => ['name' => 'tech']]],
                    ],
                ],
            ]);

            // Define Schema
            $schema = new Schema(['query' => $queryType]);

            // Handle GraphQL query
            $rawInput = file_get_contents('php://input');
            $input = json_decode($rawInput, true);
            $query = $input['query'] ?? '';
            $variables = $input['variables'] ?? null;

            $result = GraphQLBase::executeQuery($schema, $query, null, null, $variables);
            echo json_encode($result->toArray());
        } catch (\Throwable $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
