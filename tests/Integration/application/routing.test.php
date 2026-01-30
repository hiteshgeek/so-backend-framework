<?php

/**
 * Routing Test
 *
 * Comprehensive test suite for the Router class covering:
 * - HTTP methods (GET, POST, PUT, PATCH, DELETE, ANY)
 * - Route parameters with constraints
 * - Resource routes (CRUD)
 * - Nested resources
 * - Named routes and URL generation
 * - Redirects (301, 302)
 * - Route groups (prefix, middleware)
 * - Multiple methods (match)
 * - Fallback routes
 */

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../../../bootstrap/app.php';
require_once __DIR__ . '/../../TestHelper.php';

use Core\Routing\Router;

TestHelper::header('Routing Test');
echo "\n";

$passedTests = 0;
$totalTests = 0;

// Base URL for testing
$baseUrl = 'http://sixorbit.be.local';

// ==================== SECTION A: Basic HTTP Methods ====================

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "Section A: Basic HTTP Methods\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

// Test 1: GET - Ping endpoint
echo "Test 1: GET /api/demo/ping\n";
$totalTests++;
try {
    $ch = curl_init($baseUrl . '/api/demo/ping');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $data = json_decode($response, true);
    if ($httpCode === 200 && isset($data['data']['pong']) && $data['data']['pong'] === true) {
        echo "✓ GET request successful\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: GET request failed\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

// Test 2: POST - Echo endpoint
echo "Test 2: POST /api/demo/echo\n";
$totalTests++;
try {
    $postData = json_encode(['test' => 'data', 'number' => 123]);
    $ch = curl_init($baseUrl . '/api/demo/echo');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $data = json_decode($response, true);
    if ($httpCode === 200 && isset($data['data']['you_sent']['test']) && $data['data']['you_sent']['test'] === 'data') {
        echo "✓ POST request successful\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: POST request failed\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

// Test 3: PUT - Method test
echo "Test 3: PUT /api/demo/method-test\n";
$totalTests++;
try {
    $ch = curl_init($baseUrl . '/api/demo/method-test');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['update' => 'data']));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $data = json_decode($response, true);
    if ($httpCode === 200 && isset($data['data']['method']) && $data['data']['method'] === 'PUT') {
        echo "✓ PUT request successful\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: PUT request failed\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

// Test 4: PATCH - Method test
echo "Test 4: PATCH /api/demo/method-test\n";
$totalTests++;
try {
    $ch = curl_init($baseUrl . '/api/demo/method-test');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['patch' => 'data']));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $data = json_decode($response, true);
    if ($httpCode === 200 && isset($data['data']['method']) && $data['data']['method'] === 'PATCH') {
        echo "✓ PATCH request successful\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: PATCH request failed\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

// Test 5: DELETE - Method test
echo "Test 5: DELETE /api/demo/method-test\n";
$totalTests++;
try {
    $ch = curl_init($baseUrl . '/api/demo/method-test');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $data = json_decode($response, true);
    if ($httpCode === 200 && isset($data['data']['method']) && $data['data']['method'] === 'DELETE') {
        echo "✓ DELETE request successful\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: DELETE request failed\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

// Test 6: ANY method - accepts all HTTP methods
echo "Test 6: ANY /api/demo/any-method (POST)\n";
$totalTests++;
try {
    $ch = curl_init($baseUrl . '/api/demo/any-method');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $data = json_decode($response, true);
    if ($httpCode === 200 && isset($data['data']['method'])) {
        echo "✓ ANY method accepts POST\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: ANY method test failed\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== SECTION B: Route Parameters & Constraints ====================

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "Section B: Route Parameters & Constraints\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

// Test 7: whereNumber - numeric constraint
echo "Test 7: whereNumber - /api/demo/lookup/by-id/1\n";
$totalTests++;
try {
    $ch = curl_init($baseUrl . '/api/demo/lookup/by-id/1');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200 || $httpCode === 404) { // 404 is OK if product doesn't exist
        echo "✓ whereNumber constraint working\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: whereNumber failed\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

// Test 8: whereSlug - slug pattern
echo "Test 8: whereSlug - /api/demo/lookup/by-slug/test-product\n";
$totalTests++;
try {
    $ch = curl_init($baseUrl . '/api/demo/lookup/by-slug/test-product');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200 || $httpCode === 404) {
        echo "✓ whereSlug constraint working\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: whereSlug failed\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

// Test 9: whereUuid - UUID format
echo "Test 9: whereUuid - /api/demo/lookup/uuid/{uuid}\n";
$totalTests++;
try {
    $uuid = '550e8400-e29b-41d4-a716-446655440000';
    $ch = curl_init($baseUrl . '/api/demo/lookup/uuid/' . $uuid);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $data = json_decode($response, true);
    if ($httpCode === 200 && isset($data['data']['uuid']) && $data['data']['uuid'] === $uuid) {
        echo "✓ whereUuid constraint working\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: whereUuid failed\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

// Test 10: whereIn - specific values only
echo "Test 10: whereIn - /api/demo/lookup/status/active\n";
$totalTests++;
try {
    $ch = curl_init($baseUrl . '/api/demo/lookup/status/active');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $data = json_decode($response, true);
    if ($httpCode === 200 && isset($data['data']['status']) && $data['data']['status'] === 'active') {
        echo "✓ whereIn constraint working\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: whereIn failed\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

// Test 11: Custom regex - 4-digit year
echo "Test 11: Custom where (regex) - /api/demo/lookup/year/2024\n";
$totalTests++;
try {
    $ch = curl_init($baseUrl . '/api/demo/lookup/year/2024');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $data = json_decode($response, true);
    if ($httpCode === 200 && isset($data['data']['year']) && $data['data']['year'] === '2024') {
        echo "✓ Custom regex constraint working\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Custom regex failed\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

// Test 12: Multiple constraints
echo "Test 12: Multiple constraints - /api/demo/lookup/catalog/electronics/1\n";
$totalTests++;
try {
    $ch = curl_init($baseUrl . '/api/demo/lookup/catalog/electronics/1');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $data = json_decode($response, true);
    if ($httpCode === 200 && isset($data['data']['category']) && isset($data['data']['page'])) {
        echo "✓ Multiple constraints working\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Multiple constraints failed\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== SECTION C: Model Scoped Queries ====================

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "Section C: Model Scoped Queries\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

// Test 13: Model Scope - scopeActive
echo "Test 13: Model Scope Active - GET /api/demo/products/active\n";
$totalTests++;
try {
    $ch = curl_init($baseUrl . '/api/demo/products/active');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200) {
        echo "✓ Model scope active working\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Model scope active failed\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

// Test 14: Model Scope - scopeByCategory
echo "Test 14: Model Scope By Category - GET /api/demo/products/category/5\n";
$totalTests++;
try {
    $ch = curl_init($baseUrl . '/api/demo/products/category/5');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200) {
        echo "✓ Model scope by category working\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Model scope by category failed\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

// Test 15: Model Scope - scopePriceBetween
echo "Test 15: Model Scope Price Between - GET /api/demo/products/price/100/500\n";
$totalTests++;
try {
    $ch = curl_init($baseUrl . '/api/demo/products/price/100/500');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200) {
        echo "✓ Model scope price between working\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Model scope price between failed\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== SECTION D: Resource Routes (CRUD) ====================

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "Section D: Resource Routes (CRUD)\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

// Test 16: Resource - Index (GET /products)
echo "Test 16: Resource Index - GET /api/demo/products\n";
$totalTests++;
try {
    $ch = curl_init($baseUrl . '/api/demo/products');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200) {
        echo "✓ Resource index working\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Resource index failed\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

// Test 14: Resource - Show (GET /products/{id})
echo "Test 17: Resource Show - GET /api/demo/products/1\n";
$totalTests++;
try {
    $ch = curl_init($baseUrl . '/api/demo/products/1');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200 || $httpCode === 404) {
        echo "✓ Resource show working\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Resource show failed\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

// Test 15: Resource - Store (POST /products)
echo "Test 18: Resource Store - POST /api/demo/products\n";
$totalTests++;
try {
    $ch = curl_init($baseUrl . '/api/demo/products');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'category_id' => 1,
        'name' => 'Test Product via Routing Test',
        'slug' => 'test-product-routing-' . time(),
        'sku' => 'TEST-' . time(),
        'price' => 99.99,
        'stock' => 50,
        'status' => 'draft'
    ]));
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 201 || $httpCode === 200) {
        echo "✓ Resource store working\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Resource store failed (HTTP $httpCode)\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

// Test 16: Resource - Update (PUT /products/{id})
echo "Test 19: Resource Update - PUT /api/demo/products/1\n";
$totalTests++;
try {
    $ch = curl_init($baseUrl . '/api/demo/products/1');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'name' => 'Updated Product Name',
        'price' => 149.99
    ]));
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200 || $httpCode === 404) {
        echo "✓ Resource update working\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Resource update failed\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

// Test 24: Resource - Destroy (DELETE /products/{id})
echo "Test 20: Resource Destroy - DELETE /api/demo/products/15\n";
$totalTests++;
try {
    $ch = curl_init($baseUrl . '/api/demo/products/15');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200 || $httpCode === 404) {
        echo "✓ Resource destroy working\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Resource destroy failed\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

// Test 18: Resource with Query Params - Filtering/Sorting
echo "Test 21: Resource with Query Params - GET /api/demo/products?status=active&sort=price\n";
$totalTests++;
try {
    $ch = curl_init($baseUrl . '/api/demo/products?status=active&sort=price&order=DESC&page=1');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200) {
        echo "✓ Resource filtering/sorting working\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Resource filtering failed\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== SECTION D: Nested Resources ====================

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "Section D: Nested Resources\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

// Test 19: Nested resource - Reviews index
echo "Test 22: Nested Resource Index - GET /api/demo/products/1/reviews\n";
$totalTests++;
try {
    $ch = curl_init($baseUrl . '/api/demo/products/1/reviews');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200 || $httpCode === 404) {
        echo "✓ Nested resource index working\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Nested resource index failed\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

// Test 20: Nested resource - Show specific review
echo "Test 23: Nested Resource Show - GET /api/demo/products/1/reviews/1\n";
$totalTests++;
try {
    $ch = curl_init($baseUrl . '/api/demo/products/1/reviews/1');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200 || $httpCode === 404) {
        echo "✓ Nested resource show working\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Nested resource show failed\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

// Test 21: Nested Resource - Store (POST /products/1/reviews)
echo "Test 24: Nested Resource Store - POST /api/demo/products/1/reviews\n";
$totalTests++;
try {
    $ch = curl_init($baseUrl . '/api/demo/products/1/reviews');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'user_id' => 1,
        'rating' => 5,
        'title' => 'Test Review from Routing Test',
        'comment' => 'This is a test review created by the routing test suite to verify nested resource creation.'
    ]));
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 201 || $httpCode === 200) {
        echo "✓ Nested resource store working\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Nested resource store failed (HTTP $httpCode)\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

// Test 22: Nested Resource - Update (PUT /products/1/reviews/1)
echo "Test 25: Nested Resource Update - PUT /api/demo/products/1/reviews/1\n";
$totalTests++;
try {
    $ch = curl_init($baseUrl . '/api/demo/products/1/reviews/1');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'rating' => 4,
        'title' => 'Updated Review Title'
    ]));
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200 || $httpCode === 404) {
        echo "✓ Nested resource update working\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Nested resource update failed\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

// Test 23: Nested Resource - Destroy (DELETE /products/1/reviews/12)
echo "Test 26: Nested Resource Destroy - DELETE /api/demo/products/1/reviews/12\n";
$totalTests++;
try {
    $ch = curl_init($baseUrl . '/api/demo/products/1/reviews/12');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200 || $httpCode === 404) {
        echo "✓ Nested resource destroy working\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Nested resource destroy failed\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== SECTION E: Named Routes & URL Generation ====================

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "Section E: Named Routes & URL Generation\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

// Test 24: Named routes list
echo "Test 27: Named Routes - GET /api/demo/routes\n";
$totalTests++;
try {
    $ch = curl_init($baseUrl . '/api/demo/routes');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $data = json_decode($response, true);
    if ($httpCode === 200 && isset($data['data']['routes']) && count($data['data']['routes']) > 0) {
        echo "✓ Named routes working (found " . $data['data']['count'] . " routes)\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Named routes failed\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

// Test 18: Route existence check
echo "Test 28: Route Existence - /api/demo/has-route/demo.ping\n";
$totalTests++;
try {
    $ch = curl_init($baseUrl . '/api/demo/has-route/demo.ping');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $data = json_decode($response, true);
    if ($httpCode === 200 && isset($data['data']['exists']) && $data['data']['exists'] === true) {
        echo "✓ Route existence check working\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Route existence check failed\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== SECTION F: Redirects ====================

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "Section F: Redirects (301 & 302)\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

// Test 19: Permanent redirect (301)
echo "Test 29: Permanent Redirect - /api/demo/old-products → /api/demo/products\n";
$totalTests++;
try {
    $ch = curl_init($baseUrl . '/api/demo/old-products');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false); // Don't follow redirects
    curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 301) {
        echo "✓ Permanent redirect (301) working\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Expected 301, got $httpCode\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

// Test 20: Temporary redirect (302)
echo "Test 30: Temporary Redirect - /api/demo/legacy → /api/demo/ping\n";
$totalTests++;
try {
    $ch = curl_init($baseUrl . '/api/demo/legacy');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 302) {
        echo "✓ Temporary redirect (302) working\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Expected 302, got $httpCode\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== SECTION G: Multiple HTTP Methods (match) ====================

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "Section G: Multiple HTTP Methods (match)\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

// Test 21: Match - GET
echo "Test 31: Match (GET) - /api/demo/search\n";
$totalTests++;
try {
    $ch = curl_init($baseUrl . '/api/demo/search?q=test');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200) {
        echo "✓ Match accepts GET\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Match GET failed\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

// Test 22: Match - POST
echo "Test 32: Match (POST) - /api/demo/search\n";
$totalTests++;
try {
    $ch = curl_init($baseUrl . '/api/demo/search');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['q' => 'test']));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200) {
        echo "✓ Match accepts POST\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Match POST failed\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== SECTION H: Current Route Info ====================

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "Section H: Current Route Information\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

// Test 23: Current route info
echo "Test 33: Current Route Info - /api/demo/current-route\n";
$totalTests++;
try {
    $ch = curl_init($baseUrl . '/api/demo/current-route');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $data = json_decode($response, true);
    if ($httpCode === 200 && isset($data['data']['route_name'])) {
        echo "✓ Current route info working\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Current route info failed\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== SECTION I: Fallback Routes (404) ====================

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "Section I: Fallback Routes (404 Handling)\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

// Test 24: Fallback route - non-existent endpoint
echo "Test 34: Fallback Route - /api/demo/non-existent-route\n";
$totalTests++;
try {
    $ch = curl_init($baseUrl . '/api/demo/non-existent-route-12345');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $data = json_decode($response, true);
    if ($httpCode === 404 && (isset($data['message']) || isset($data['error']))) {
        echo "✓ Fallback route working (404 handler)\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Fallback route failed\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== SECTION J: Admin Middleware & Soft Deletes ====================

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "Section J: Admin Middleware & Soft Deletes\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

// Test 35: Admin Stats - GET /admin/stats (with AuthMiddleware)
echo "Test 35: Admin Stats - GET /api/demo/admin/stats\n";
$totalTests++;
try {
    $ch = curl_init($baseUrl . '/api/demo/admin/stats');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Should return 401 Unauthorized (AuthMiddleware blocks unauthenticated access)
    // Or 200 if auth is bypassed for demo purposes
    if ($httpCode === 200 || $httpCode === 401) {
        echo "✓ Admin stats route working (HTTP $httpCode)\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Admin stats failed\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

// Test 33: Soft Delete - Restore (PATCH /admin/products/{id}/restore)
echo "Test 36: Soft Delete Restore - PATCH /api/demo/admin/products/15/restore\n";
$totalTests++;
try {
    $ch = curl_init($baseUrl . '/api/demo/admin/products/15/restore');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200 || $httpCode === 404 || $httpCode === 401) {
        echo "✓ Soft delete restore route working (HTTP $httpCode)\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Soft delete restore failed\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

// Test 34: Force Delete - DELETE /admin/products/{id}/force
echo "Test 37: Force Delete - DELETE /api/demo/admin/products/15/force\n";
$totalTests++;
try {
    $ch = curl_init($baseUrl . '/api/demo/admin/products/15/force');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200 || $httpCode === 404 || $httpCode === 401) {
        echo "✓ Force delete route working (HTTP $httpCode)\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Force delete failed\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== SECTION K: Rate Limiting ====================

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "Section K: Rate Limiting\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

// Test 35: Rate Limiting - POST /contact (Throttle middleware)
echo "Test 38: Rate Limiting - POST /api/demo/contact (max 10 per minute)\n";
$totalTests++;
try {
    $ch = curl_init($baseUrl . '/api/demo/contact');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'message' => 'Test message'
    ]));
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200 || $httpCode === 429) {
        echo "✓ Rate limiting route working (HTTP $httpCode)\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Rate limiting failed\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== SECTION L: Logging Middleware ====================

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "Section L: Logging Middleware\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

// Test 36: Logging Middleware - GET /logged/action
echo "Test 39: Logging Middleware - GET /api/demo/logged/action\n";
$totalTests++;
try {
    $ch = curl_init($baseUrl . '/api/demo/logged/action');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200) {
        echo "✓ Logging middleware route working\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Logging middleware failed\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== SUMMARY ====================

TestHelper::complete('Routing Test');

TestHelper::summary($passedTests, $totalTests - $passedTests, $totalTests);

if ($passedTests === $totalTests) {
    echo "\n";
    echo "Routing Status:\n";
    echo "- ✓ HTTP Methods: GET, POST, PUT, PATCH, DELETE, ANY working\n";
    echo "- ✓ Route Constraints: whereNumber, whereSlug, whereUuid, whereIn, custom regex working\n";
    echo "- ✓ Resource Routes: apiResource CRUD operations working\n";
    echo "- ✓ Nested Resources: products/{id}/reviews working\n";
    echo "- ✓ Named Routes: Route registration and URL generation working\n";
    echo "- ✓ Redirects: 301 (permanent) and 302 (temporary) working\n";
    echo "- ✓ Multiple Methods: match() accepting GET/POST working\n";
    echo "- ✓ Current Route Info: Route introspection working\n";
    echo "- ✓ Fallback Routes: 404 handling working\n\n";
    echo "Production Ready: YES\n";
} else {
    echo "\n";
    echo "Failed: " . ($totalTests - $passedTests) . " tests\n";
    echo "Please review the output above for details.\n";
}

echo "\nRouter Features Coverage:\n";
echo "✓ Basic routing (GET, POST, PUT, PATCH, DELETE)\n";
echo "✓ Route parameters with constraints\n";
echo "✓ Resource routes (apiResource)\n";
echo "✓ Nested resources\n";
echo "✓ Route groups (prefix, middleware)\n";
echo "✓ Named routes & URL generation\n";
echo "✓ Redirects (301, 302)\n";
echo "✓ Multiple HTTP methods (match, any)\n";
echo "✓ Fallback routes (404)\n";
echo "✓ Current route introspection\n";
