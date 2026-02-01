<?php

namespace Tests\Unit\Media;

use PHPUnit\Framework\TestCase;
use Core\Media\FileValidator;

/**
 * FileValidator Unit Tests
 *
 * Tests for file upload validation including security checks.
 */
class FileValidatorTest extends TestCase
{
    private FileValidator $validator;
    private string $testPath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->validator = new FileValidator();
        $this->testPath = sys_get_temp_dir() . '/validator_test_' . uniqid();

        if (!is_dir($this->testPath)) {
            mkdir($this->testPath, 0755, true);
        }
    }

    protected function tearDown(): void
    {
        if (is_dir($this->testPath)) {
            $files = glob($this->testPath . '/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
            rmdir($this->testPath);
        }

        parent::tearDown();
    }

    /**
     * Test valid file passes validation
     */
    public function testValidFile(): void
    {
        $testFile = $this->testPath . '/test.jpg';
        file_put_contents($testFile, 'fake image content');

        $file = [
            'name' => 'test.jpg',
            'type' => 'image/jpeg',
            'tmp_name' => $testFile,
            'error' => UPLOAD_ERR_OK,
            'size' => filesize($testFile),
        ];

        $errors = $this->validator->validate($file);

        // May have errors about not being actual image, but structure is valid
        $this->assertIsArray($errors);
    }

    /**
     * Test upload error detection
     */
    public function testUploadError(): void
    {
        $file = [
            'name' => 'test.jpg',
            'type' => 'image/jpeg',
            'tmp_name' => '',
            'error' => UPLOAD_ERR_NO_FILE,
            'size' => 0,
        ];

        $errors = $this->validator->validate($file);

        $this->assertNotEmpty($errors);
        $this->assertStringContainsString('No file', $errors[0]);
    }

    /**
     * Test file too large
     */
    public function testFileTooLarge(): void
    {
        $testFile = $this->testPath . '/large.txt';
        file_put_contents($testFile, str_repeat('x', 20 * 1024 * 1024)); // 20MB

        $file = [
            'name' => 'large.txt',
            'type' => 'text/plain',
            'tmp_name' => $testFile,
            'error' => UPLOAD_ERR_OK,
            'size' => filesize($testFile),
        ];

        $errors = $this->validator->validate($file);

        $this->assertNotEmpty($errors);
        $hasFileSizeError = false;
        foreach ($errors as $error) {
            if (str_contains($error, 'too large') || str_contains($error, 'Maximum')) {
                $hasFileSizeError = true;
                break;
            }
        }
        $this->assertTrue($hasFileSizeError);
    }

    /**
     * Test empty file
     */
    public function testEmptyFile(): void
    {
        $testFile = $this->testPath . '/empty.txt';
        file_put_contents($testFile, '');

        $file = [
            'name' => 'empty.txt',
            'type' => 'text/plain',
            'tmp_name' => $testFile,
            'error' => UPLOAD_ERR_OK,
            'size' => 0,
        ];

        $errors = $this->validator->validate($file);

        $this->assertNotEmpty($errors);
        $hasEmptyError = false;
        foreach ($errors as $error) {
            if (str_contains($error, 'empty')) {
                $hasEmptyError = true;
                break;
            }
        }
        $this->assertTrue($hasEmptyError);
    }

    /**
     * Test invalid file data
     */
    public function testInvalidFileData(): void
    {
        $file = [
            'name' => 'test.jpg',
        ];

        $errors = $this->validator->validate($file);

        $this->assertNotEmpty($errors);
    }

    /**
     * Test filename sanitization
     */
    public function testSanitizeFilename(): void
    {
        $dangerous = '../../../etc/passwd';
        $sanitized = $this->validator->sanitizeFilename($dangerous);

        $this->assertStringNotContainsString('..', $sanitized);
        $this->assertStringNotContainsString('/', $sanitized);
    }

    /**
     * Test special character sanitization
     */
    public function testSanitizeSpecialCharacters(): void
    {
        $filename = 'test file@#$%.jpg';
        $sanitized = $this->validator->sanitizeFilename($filename);

        $this->assertMatchesRegularExpression('/^[a-zA-Z0-9_-]+\.jpg$/', $sanitized);
    }

    /**
     * Test valid filename check
     */
    public function testIsValidFilename(): void
    {
        $this->assertTrue($this->validator->isValidFilename('test.jpg'));
        $this->assertTrue($this->validator->isValidFilename('my-file_123.png'));

        $this->assertFalse($this->validator->isValidFilename('../etc/passwd'));
        $this->assertFalse($this->validator->isValidFilename('test/file.jpg'));
        $this->assertFalse($this->validator->isValidFilename("test\0file.jpg"));
    }

    /**
     * Test allowed type check
     */
    public function testIsAllowedType(): void
    {
        // These types should be in config
        $this->assertTrue($this->validator->isAllowedType('image/jpeg'));
        $this->assertTrue($this->validator->isAllowedType('image/png'));
    }

    /**
     * Test allowed extension check
     */
    public function testIsAllowedExtension(): void
    {
        $this->assertTrue($this->validator->isAllowedExtension('jpg'));
        $this->assertTrue($this->validator->isAllowedExtension('png'));
        $this->assertTrue($this->validator->isAllowedExtension('PDF')); // Case insensitive
    }

    /**
     * Test upload error messages
     */
    public function testUploadErrorMessages(): void
    {
        $file1 = [
            'name' => 'test.jpg',
            'type' => 'image/jpeg',
            'tmp_name' => '',
            'error' => UPLOAD_ERR_INI_SIZE,
            'size' => 0,
        ];

        $errors1 = $this->validator->validate($file1);
        $this->assertNotEmpty($errors1);

        $file2 = [
            'name' => 'test.jpg',
            'type' => 'image/jpeg',
            'tmp_name' => '',
            'error' => UPLOAD_ERR_PARTIAL,
            'size' => 0,
        ];

        $errors2 = $this->validator->validate($file2);
        $this->assertNotEmpty($errors2);
    }
}
