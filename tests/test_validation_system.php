<?php

/**
 * Validation System Test
 *
 * Tests Validator class with 27+ validation rules.
 */

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../bootstrap/app.php';

echo "=== Validation System Test ===\n\n";

use Core\Validation\Validator;
use Core\Validation\ValidationException;
use Core\Validation\Rule;

// Test 1: Required Rule
echo "Test 1: Required Rule\n";
try {
    // Valid
    $validator = new Validator(['name' => 'John'], ['name' => ['required']]);
    if ($validator->passes()) {
        echo "✓ Required rule passes with value\n";
    }

    // Invalid - null
    $validator = new Validator(['name' => null], ['name' => ['required']]);
    if ($validator->fails()) {
        echo "✓ Required rule fails with null\n";
    }

    // Invalid - empty string
    $validator = new Validator(['name' => ''], ['name' => ['required']]);
    if ($validator->fails()) {
        echo "✓ Required rule fails with empty string\n";
    }

    // Invalid - empty array
    $validator = new Validator(['tags' => []], ['tags' => ['required']]);
    if ($validator->fails()) {
        echo "✓ Required rule fails with empty array\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 2: Email Rule
echo "Test 2: Email Rule\n";
try {
    $tests = [
        'valid@example.com' => true,
        'user.name+tag@domain.co.uk' => true,
        'invalid.email' => false,
        '@example.com' => false,
        'user@' => false,
    ];

    foreach ($tests as $email => $shouldPass) {
        $validator = new Validator(['email' => $email], ['email' => ['email']]);
        $result = $shouldPass ? $validator->passes() : $validator->fails();

        if ($result) {
            echo "✓ Email '" . substr($email, 0, 20) . "': " . ($shouldPass ? 'valid' : 'invalid') . "\n";
        } else {
            echo "✗ FAILED: Email validation for '$email'\n";
        }
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 3: Min/Max Rules
echo "Test 3: Min/Max Rules\n";
try {
    // String length
    $validator = new Validator(['password' => '12345678'], ['password' => ['min:8']]);
    if ($validator->passes()) {
        echo "✓ Min rule passes for string (length 8, min 8)\n";
    }

    $validator = new Validator(['password' => '123'], ['password' => ['min:8']]);
    if ($validator->fails()) {
        echo "✓ Min rule fails for string (length 3, min 8)\n";
    }

    // Numeric value
    $validator = new Validator(['age' => 25], ['age' => ['min:18']]);
    if ($validator->passes()) {
        echo "✓ Min rule passes for number (25, min 18)\n";
    }

    // Max rule
    $validator = new Validator(['title' => 'Short'], ['title' => ['max:100']]);
    if ($validator->passes()) {
        echo "✓ Max rule passes for string (length 5, max 100)\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 4: Between Rule
echo "Test 4: Between Rule\n";
try {
    $validator = new Validator(['age' => 25], ['age' => ['between:18,65']]);
    if ($validator->passes()) {
        echo "✓ Between rule passes (25 between 18 and 65)\n";
    }

    $validator = new Validator(['age' => 10], ['age' => ['between:18,65']]);
    if ($validator->fails()) {
        echo "✓ Between rule fails (10 not between 18 and 65)\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 5: In/Not In Rules
echo "Test 5: In/Not In Rules\n";
try {
    $validator = new Validator(['role' => 'admin'], ['role' => ['in:admin,user,guest']]);
    if ($validator->passes()) {
        echo "✓ In rule passes (admin in [admin, user, guest])\n";
    }

    $validator = new Validator(['role' => 'superadmin'], ['role' => ['in:admin,user,guest']]);
    if ($validator->fails()) {
        echo "✓ In rule fails (superadmin not in list)\n";
    }

    $validator = new Validator(['status' => 'active'], ['status' => ['not_in:banned,suspended']]);
    if ($validator->passes()) {
        echo "✓ Not in rule passes (active not in [banned, suspended])\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 6: Alpha/AlphaNum/AlphaDash Rules
echo "Test 6: Alpha/AlphaNum/AlphaDash Rules\n";
try {
    $validator = new Validator(['name' => 'JohnDoe'], ['name' => ['alpha']]);
    if ($validator->passes()) {
        echo "✓ Alpha rule passes (JohnDoe)\n";
    }

    $validator = new Validator(['username' => 'user123'], ['username' => ['alpha_num']]);
    if ($validator->passes()) {
        echo "✓ AlphaNum rule passes (user123)\n";
    }

    $validator = new Validator(['slug' => 'hello-world_123'], ['slug' => ['alpha_dash']]);
    if ($validator->passes()) {
        echo "✓ AlphaDash rule passes (hello-world_123)\n";
    }

    $validator = new Validator(['name' => 'John123'], ['name' => ['alpha']]);
    if ($validator->fails()) {
        echo "✓ Alpha rule fails with numbers (John123)\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 7: Numeric/Integer Rules
echo "Test 7: Numeric/Integer Rules\n";
try {
    $validator = new Validator(['price' => '19.99'], ['price' => ['numeric']]);
    if ($validator->passes()) {
        echo "✓ Numeric rule passes (19.99)\n";
    }

    $validator = new Validator(['quantity' => 5], ['quantity' => ['integer']]);
    if ($validator->passes()) {
        echo "✓ Integer rule passes (5)\n";
    }

    $validator = new Validator(['quantity' => 5.5], ['quantity' => ['integer']]);
    if ($validator->fails()) {
        echo "✓ Integer rule fails with float (5.5)\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 8: Type Rules (String, Array, Boolean)
echo "Test 8: Type Rules\n";
try {
    $validator = new Validator(['name' => 'John'], ['name' => ['string']]);
    if ($validator->passes()) {
        echo "✓ String rule passes\n";
    }

    $validator = new Validator(['tags' => ['php', 'js']], ['tags' => ['array']]);
    if ($validator->passes()) {
        echo "✓ Array rule passes\n";
    }

    $validator = new Validator(['active' => true], ['active' => ['boolean']]);
    if ($validator->passes()) {
        echo "✓ Boolean rule passes (true)\n";
    }

    $validator = new Validator(['active' => 1], ['active' => ['boolean']]);
    if ($validator->passes()) {
        echo "✓ Boolean rule passes (1)\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 9: Same/Different/Confirmed Rules
echo "Test 9: Same/Different/Confirmed Rules\n";
try {
    $validator = new Validator([
        'password' => 'secret123',
        'password_confirmation' => 'secret123'
    ], ['password' => ['confirmed']]);
    if ($validator->passes()) {
        echo "✓ Confirmed rule passes (passwords match)\n";
    }

    $validator = new Validator([
        'password' => 'secret123',
        'password_confirmation' => 'different'
    ], ['password' => ['confirmed']]);
    if ($validator->fails()) {
        echo "✓ Confirmed rule fails (passwords don't match)\n";
    }

    $validator = new Validator([
        'email' => 'test@example.com',
        'email_confirm' => 'test@example.com'
    ], ['email' => ['same:email_confirm']]);
    if ($validator->passes()) {
        echo "✓ Same rule passes\n";
    }

    $validator = new Validator([
        'new_password' => 'newsecret',
        'old_password' => 'oldsecret'
    ], ['new_password' => ['different:old_password']]);
    if ($validator->passes()) {
        echo "✓ Different rule passes\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 10: URL and IP Rules
echo "Test 10: URL and IP Rules\n";
try {
    $validator = new Validator(['website' => 'https://example.com'], ['website' => ['url']]);
    if ($validator->passes()) {
        echo "✓ URL rule passes (https://example.com)\n";
    }

    $validator = new Validator(['website' => 'not-a-url'], ['website' => ['url']]);
    if ($validator->fails()) {
        echo "✓ URL rule fails (not-a-url)\n";
    }

    $validator = new Validator(['ip' => '192.168.1.1'], ['ip' => ['ip']]);
    if ($validator->passes()) {
        echo "✓ IP rule passes (192.168.1.1)\n";
    }

    $validator = new Validator(['ip' => '999.999.999.999'], ['ip' => ['ip']]);
    if ($validator->fails()) {
        echo "✓ IP rule fails (999.999.999.999)\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 11: Date Rules
echo "Test 11: Date Rules\n";
try {
    $validator = new Validator(['birth_date' => '1990-01-15'], ['birth_date' => ['date']]);
    if ($validator->passes()) {
        echo "✓ Date rule passes (1990-01-15)\n";
    }

    $validator = new Validator([
        'start_date' => '2024-01-01'
    ], ['start_date' => ['before:2024-12-31']]);
    if ($validator->passes()) {
        echo "✓ Before rule passes (2024-01-01 before 2024-12-31)\n";
    }

    $validator = new Validator([
        'end_date' => '2024-12-31'
    ], ['end_date' => ['after:2024-01-01']]);
    if ($validator->passes()) {
        echo "✓ After rule passes (2024-12-31 after 2024-01-01)\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 12: Required If/With Rules
echo "Test 12: Required If/With Rules\n";
try {
    $validator = new Validator([
        'country' => 'USA',
        'state' => 'California'
    ], ['state' => ['required_if:country,USA']]);
    if ($validator->passes()) {
        echo "✓ Required if rule passes (state required when country=USA)\n";
    }

    $validator = new Validator([
        'country' => 'Canada'
    ], ['state' => ['required_if:country,USA']]);
    if ($validator->passes()) {
        echo "✓ Required if rule passes (state not required when country=Canada)\n";
    }

    $validator = new Validator([
        'phone' => '123-456-7890',
        'phone_ext' => '123'
    ], ['phone_ext' => ['required_with:phone']]);
    if ($validator->passes()) {
        echo "✓ Required with rule passes\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 13: ValidationException
echo "Test 13: ValidationException\n";
try {
    $validator = new Validator(
        ['email' => 'invalid'],
        ['email' => ['required', 'email']]
    );

    try {
        $validator->validate();
        echo "✗ FAILED: Should throw ValidationException\n";
    } catch (ValidationException $e) {
        echo "✓ ValidationException thrown\n";
        echo "✓ Exception code: " . $e->getCode() . " (expected 422)\n";

        $errors = $e->getErrors();
        if (isset($errors['email'])) {
            echo "✓ Errors contain 'email' field\n";
        }

        $first = $e->getFirstError();
        if ($first) {
            echo "✓ First error: " . substr($first, 0, 50) . "...\n";
        }
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 14: Custom Error Messages
echo "Test 14: Custom Error Messages\n";
try {
    $validator = new Validator(
        ['username' => ''],
        ['username' => ['required']],
        ['username.required' => 'Please provide a username!']
    );

    if ($validator->fails()) {
        $errors = $validator->errors();
        if (isset($errors['username'][0]) && str_contains($errors['username'][0], 'Please provide a username')) {
            echo "✓ Custom error message used\n";
            echo "  Message: " . $errors['username'][0] . "\n";
        } else {
            echo "✗ FAILED: Custom message not applied\n";
        }
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 15: Custom Rule (Closure)
echo "Test 15: Custom Rule (Closure)\n";
try {
    $validator = new Validator(
        ['code' => 'ABC'],
        ['code' => [function($attribute, $value) {
            return strtoupper($value) === $value ? true : "The $attribute must be uppercase.";
        }]]
    );

    if ($validator->passes()) {
        echo "✓ Custom closure rule passes (ABC is uppercase)\n";
    }

    $validator = new Validator(
        ['code' => 'abc'],
        ['code' => [function($attribute, $value) {
            return strtoupper($value) === $value ? true : "The $attribute must be uppercase.";
        }]]
    );

    if ($validator->fails()) {
        echo "✓ Custom closure rule fails (abc is lowercase)\n";
        $errors = $validator->errors();
        echo "  Error: " . $errors['code'][0] . "\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 16: Custom Rule (Class)
echo "Test 16: Custom Rule (Class)\n";
try {
    // Define custom rule class
    class UppercaseRule implements Rule {
        public function passes(string $attribute, $value): bool {
            return strtoupper($value) === $value;
        }

        public function message(): string {
            return 'The :attribute must be uppercase.';
        }
    }

    $validator = new Validator(
        ['name' => 'JOHN'],
        ['name' => ['required', new UppercaseRule]]
    );

    if ($validator->passes()) {
        echo "✓ Custom rule class passes (JOHN is uppercase)\n";
    }

    $validator = new Validator(
        ['name' => 'john'],
        ['name' => [new UppercaseRule]]
    );

    if ($validator->fails()) {
        echo "✓ Custom rule class fails (john is lowercase)\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 17: validate() Helper Function
echo "Test 17: validate() Helper Function\n";
try {
    $validated = validate(
        ['email' => 'test@example.com', 'age' => 25],
        ['email' => ['required', 'email'], 'age' => ['required', 'min:18']]
    );

    if ($validated['email'] === 'test@example.com' && $validated['age'] === 25) {
        echo "✓ validate() helper works\n";
        echo "  Validated data: " . json_encode($validated) . "\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 18: Validated Data Only Includes Validated Fields
echo "Test 18: Validated Data Filtering\n";
try {
    $validator = new Validator(
        ['email' => 'test@example.com', 'name' => 'John', 'extra' => 'ignored'],
        ['email' => ['required', 'email'], 'name' => ['required']]
    );

    $validated = $validator->validate();

    if (isset($validated['email']) && isset($validated['name']) && !isset($validated['extra'])) {
        echo "✓ Validated data only includes validated fields\n";
        echo "  Validated: " . json_encode($validated) . "\n";
    } else {
        echo "✗ FAILED: Extra fields included in validated data\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 19: Multiple Rules on Single Field
echo "Test 19: Multiple Rules on Single Field\n";
try {
    $validator = new Validator(
        ['password' => 'abc'],
        ['password' => ['required', 'min:8', 'alpha_num']]
    );

    if ($validator->fails()) {
        $errors = $validator->errors();
        if (count($errors['password']) > 0) {
            echo "✓ Multiple validation errors collected\n";
            echo "  Errors: " . count($errors['password']) . "\n";
            foreach ($errors['password'] as $error) {
                echo "    - " . $error . "\n";
            }
        }
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 20: Pipe Syntax for Rules
echo "Test 20: Pipe Syntax for Rules\n";
try {
    $validator = new Validator(
        ['email' => 'test@example.com'],
        ['email' => 'required|email|max:255']
    );

    if ($validator->passes()) {
        echo "✓ Pipe syntax works (required|email|max:255)\n";
    }

    $validator = new Validator(
        ['age' => 25],
        ['age' => 'required|integer|min:18|max:100']
    );

    if ($validator->passes()) {
        echo "✓ Pipe syntax with parameters works\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n=== Validation System Test Complete ===\n";
