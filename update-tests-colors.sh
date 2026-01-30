#!/bin/bash

# Script to add TestHelper to all test files

TEST_FILES=(
    "tests/Integration/application/validation.test.php"
    "tests/Integration/application/middleware.test.php"
    "tests/Integration/security/rate-limit.test.php"
    "tests/Integration/security/auth-lockout.test.php"
    "tests/Integration/security/jwt-auth.test.php"
    "tests/Integration/security/xss-prevention.test.php"
    "tests/Integration/infrastructure/activity-logging.test.php"
    "tests/Integration/infrastructure/cache-sessions.test.php"
    "tests/Integration/infrastructure/file-cache.test.php"
    "tests/Integration/infrastructure/queue.test.php"
    "tests/Integration/infrastructure/notifications.test.php"
)

for file in "${TEST_FILES[@]}"; do
    echo "Processing: $file"

    # Check if file already has TestHelper
    if grep -q "TestHelper" "$file"; then
        echo "  ✓ Already has TestHelper"
        continue
    fi

    # Add TestHelper require after bootstrap
    sed -i "/require_once.*bootstrap\/app.php/a require_once __DIR__ . '/../../TestHelper.php';" "$file"

    # Replace echo "=== Test Name ===" with TestHelper::header
    sed -i 's/echo "=== \(.*\) ===\\n\\n";/TestHelper::header('\''\1'\'');\necho "\\n";/' "$file"

    # Replace summary sections
    sed -i 's/echo "=== \(.*\) Complete ===\\n\\n";/TestHelper::complete('\''\1'\'');\n/' "$file"

    # Replace emoji checkmarks with text checkmarks
    sed -i 's/✅ ALL TESTS PASSED/✓ ALL TESTS PASSED/' "$file"
    sed -i 's/⚠️  SOME TESTS FAILED/⚠ SOME TESTS FAILED/' "$file"

    echo "  ✓ Updated"
done

echo ""
echo "All test files updated!"
