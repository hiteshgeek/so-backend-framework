<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap the application
$app = require_once __DIR__ . '/bootstrap/app.php';

use Core\Http\Request;

// Create request
$request = Request::createFromGlobals();

// Start session
session()->start();

echo "<pre>";
echo "=== LOGIN DEBUG INFO ===\n\n";

echo "1. REQUEST METHOD: " . $request->method() . "\n\n";

echo "2. POST DATA:\n";
var_dump($_POST);
echo "\n";

echo "3. REQUEST->ALL():\n";
var_dump($request->all());
echo "\n";

echo "4. REQUEST->INPUT():\n";
echo "   email: " . var_export($request->input('email'), true) . "\n";
echo "   password: " . var_export($request->input('password'), true) . "\n";
echo "   _csrf_token: " . var_export($request->input('_csrf_token'), true) . "\n\n";

echo "5. SESSION DATA:\n";
var_dump($_SESSION);
echo "\n";

echo "6. CSRF TOKEN:\n";
echo "   Session token: " . session()->get('_csrf_token', 'NOT SET') . "\n";
echo "   Request token: " . $request->input('_csrf_token', 'NOT PROVIDED') . "\n\n";

echo "7. AUTH STATUS:\n";
echo "   Is authenticated: " . (auth()->check() ? 'YES' : 'NO') . "\n";
echo "   User ID: " . var_export(auth()->id(), true) . "\n\n";

// Test database connection and user lookup
echo "8. DATABASE TEST:\n";
try {
    $email = $request->input('email');
    if ($email) {
        echo "   Looking up user: {$email}\n";
        $user = \App\Models\User::findByEmail($email);
        if ($user) {
            echo "   ✅ User found: ID={$user->id}, Email={$user->email}\n";
            echo "   User data: " . json_encode($user->toArray()) . "\n";
        } else {
            echo "   ❌ User not found\n";
        }
    } else {
        echo "   No email provided in request\n";
    }
} catch (Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}

echo "\n9. VALIDATION TEST:\n";
if ($request->method() === 'POST' && $request->input('email') && $request->input('password')) {
    $validator = \Core\Validation\Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required',
    ]);

    echo "   Validation " . ($validator->validate() ? "PASSED ✅" : "FAILED ❌") . "\n";

    if (!$validator->validate()) {
        echo "   Errors: " . json_encode($validator->errors()) . "\n";
    }
}

echo "</pre>";
