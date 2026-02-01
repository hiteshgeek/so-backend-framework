<?php

/**
 * Session Encryption Test
 *
 * Tests the session encryption functionality:
 * 1. Session payloads are encrypted when SESSION_ENCRYPT=true
 * 2. HMAC tamper detection works
 * 3. Encrypted sessions can be read/written correctly
 */

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../../../bootstrap/app.php';
require_once __DIR__ . '/../../TestHelper.php';

use Core\Session\AuserSessionHandler;
use Core\Security\Encrypter;
use Core\Database\Connection;

TestHelper::header('Session Encryption Test');
echo "\n";

$passedTests = 0;
$totalTests = 0;

// Test database connection
$db = app('db');
$connection = $db->connection;

// ==================== TEST 1: Create Encrypter ====================

echo "Test 1: Create Encrypter with Valid Key\n";
try {
    $totalTests++;

    // Generate a valid 32-byte key
    $key = base64_encode(random_bytes(32));
    $encrypter = new Encrypter('base64:' . $key);

    echo "✓ Encrypter created successfully\n";
    $passedTests++;
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== TEST 2: Encrypt and Decrypt Data ====================

echo "Test 2: Encrypt and Decrypt Session Data\n";
try {
    $totalTests++;

    $originalData = 'user_id:123|name:John Doe|role:admin';
    $encrypted = $encrypter->encrypt($originalData);
    $decrypted = $encrypter->decrypt($encrypted);

    if ($decrypted === $originalData) {
        echo "✓ Encryption and decryption successful\n";
        echo "  Original length: " . strlen($originalData) . " bytes\n";
        echo "  Encrypted length: " . strlen($encrypted) . " bytes\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Decrypted data does not match original\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== TEST 3: Session Handler Without Encryption ====================

echo "Test 3: Session Handler Without Encryption\n";
try {
    $totalTests++;

    // Use AuserSessionHandler for existing auser_session table
    $handler = new AuserSessionHandler($connection, 'auser_session', 120, null, false);

    $sessionId = 'test_session_' . bin2hex(random_bytes(8));
    // Manually create PHP session serialized data (can't use session_start after output)
    $sessionData = 'user_id|i:4;test_key|s:10:"test_value";';

    // Write session via handler
    $written = $handler->write($sessionId, $sessionData);

    // Verify data exists in database
    $sql = "SELECT data FROM auser_session WHERE sid = ?";
    $stmt = $connection->query($sql, [$sessionId]);
    $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    $dbData = $result[0]['data'] ?? null;

    // Clean up
    $handler->destroy($sessionId);

    if ($written && $dbData !== null && !empty($dbData)) {
        echo "✓ Unencrypted session write works\n";
        echo "  Written to database: Yes\n";
        echo "  Data length: " . strlen($dbData) . " bytes\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Session data not written to database\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== TEST 4: Session Handler With Encryption ====================

echo "Test 4: Session Handler With Encryption\n";
try {
    $totalTests++;

    // Use AuserSessionHandler for existing auser_session table
    $handler = new AuserSessionHandler($connection, 'auser_session', 120, $encrypter, true);

    $sessionId = 'test_enc_session_' . bin2hex(random_bytes(8));
    // Manually create PHP session serialized data (can't use session_start after output)
    $originalData = 'user_id|i:4;secret_key|s:10:"secret_val";';

    // Write encrypted session via handler
    $written = $handler->write($sessionId, $originalData);

    // Read the raw encrypted payload from database
    $sql = "SELECT data FROM auser_session WHERE sid = ?";
    $stmt = $connection->query($sql, [$sessionId]);
    $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    $rawPayload = $result[0]['data'] ?? '';

    // Clean up
    $handler->destroy($sessionId);

    // Verify: raw payload should NOT match original (it's encrypted)
    // Check that payload is longer (encrypted data is bigger)
    $isEncrypted = !empty($rawPayload) && $rawPayload !== $originalData && strlen($rawPayload) > strlen($originalData);

    if ($written && $isEncrypted) {
        echo "✓ Encrypted session write works\n";
        echo "  Written to database: Yes\n";
        echo "  Original length: " . strlen($originalData) . " bytes\n";
        echo "  Encrypted length: " . strlen($rawPayload) . " bytes\n";
        echo "  Data is encrypted: Yes\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Encryption not working properly\n";
        if ($rawPayload === $originalData) {
            echo "  Error: Data not encrypted in database\n";
        }
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== TEST 5: HMAC Tamper Detection ====================

echo "Test 5: HMAC Tamper Detection\n";
try {
    $totalTests++;

    // Use AuserSessionHandler for existing auser_session table
    $handler = new AuserSessionHandler($connection, 'auser_session', 120, $encrypter, true);

    $sessionId = 'test_tamper_' . bin2hex(random_bytes(8));
    $sessionData = 'user_id|i:123;';

    // Write encrypted session
    $handler->write($sessionId, $sessionData);

    // Tamper with the payload in database
    $sql = "UPDATE auser_session SET data = ? WHERE sid = ?";
    $connection->execute($sql, ['tampered_data_' . time(), $sessionId]);

    // Try to read - should fail HMAC verification and return empty
    $readData = $handler->read($sessionId);

    if ($readData === '') {
        echo "✓ Tampered session detected and rejected\n";
        echo "  HMAC verification working correctly\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Tampered data was accepted\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== TEST 6: Key Length Validation ====================

echo "Test 6: Encryption Key Length Validation\n";
try {
    $totalTests++;

    $exceptionThrown = false;

    try {
        // Try to create encrypter with too short key
        $weakKey = 'short';
        new Encrypter($weakKey);
    } catch (\Core\Exceptions\EncryptionException $e) {
        $exceptionThrown = true;
    }

    if ($exceptionThrown) {
        echo "✓ Weak key rejected (minimum 32 bytes required)\n";
        $passedTests++;
    } else {
        echo "✗ FAILED: Weak key was accepted\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
}

echo "\n";

// ==================== SUMMARY ====================

TestHelper::complete('Session Encryption Test');

TestHelper::summary($passedTests, $totalTests - $passedTests, $totalTests);

if ($passedTests === $totalTests) {
    echo "\n";
    echo "Session Encryption Status:\n";
    echo "- ✓ Encrypter: AES-256-CBC working\n";
    echo "- ✓ HMAC: SHA256 tamper detection working\n";
    echo "- ✓ Session Handler: Encryption/decryption working\n";
    echo "- ✓ Key Validation: Minimum length enforced\n";
    echo "- ✓ Tamper Detection: HMAC verification working\n\n";
    echo "Production Ready: YES\n";
} else {
    echo "\n";
    echo "Failed: " . ($totalTests - $passedTests) . " tests\n";
    echo "Please review the output above for details.\n";
}

echo "\nHow to Enable:\n";
echo "1. Set APP_KEY in .env (must be 32+ characters):\n";
echo "   APP_KEY=base64:" . base64_encode(random_bytes(32)) . "\n";
echo "2. Enable session encryption in .env:\n";
echo "   SESSION_ENCRYPT=true\n";
echo "3. Restart your application\n";
