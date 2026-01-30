<?php

namespace Core\Mail;

/**
 * Mailer
 *
 * Sends emails via SMTP using native PHP socket connections.
 * Supports TLS encryption, authentication, HTML/plain text bodies,
 * and MIME multipart attachments with no external dependencies.
 */
class Mailer
{
    /**
     * Full mail configuration array
     *
     * @var array
     */
    protected array $config;

    /**
     * SMTP socket resource
     *
     * @var resource|null
     */
    protected $socket = null;

    /**
     * Recipients (To)
     *
     * @var array
     */
    protected array $to = [];

    /**
     * CC recipients
     *
     * @var array
     */
    protected array $cc = [];

    /**
     * BCC recipients
     *
     * @var array
     */
    protected array $bcc = [];

    /**
     * Email subject
     *
     * @var string
     */
    protected string $subject = '';

    /**
     * HTML body content
     *
     * @var string
     */
    protected string $htmlBody = '';

    /**
     * Plain text body content
     *
     * @var string
     */
    protected string $textBody = '';

    /**
     * Sender address
     *
     * @var string
     */
    protected string $fromAddress = '';

    /**
     * Sender name
     *
     * @var string
     */
    protected string $fromName = '';

    /**
     * Reply-To address
     *
     * @var string
     */
    protected string $replyToAddress = '';

    /**
     * Reply-To name
     *
     * @var string
     */
    protected string $replyToName = '';

    /**
     * File attachments
     *
     * @var array
     */
    protected array $attachments = [];

    /**
     * Last SMTP error message
     *
     * @var string
     */
    protected string $lastError = '';

    /**
     * Constructor
     *
     * @param array $config Full mail configuration from config/mail.php
     */
    public function __construct(array $config)
    {
        $this->config = $config;

        // Set default from address from config
        $this->fromAddress = $config['from']['address'] ?? 'noreply@example.com';
        $this->fromName = $config['from']['name'] ?? '';
    }

    /**
     * Set To recipient(s)
     *
     * @param string|array $address Single email or array of emails
     * @return static
     */
    public function to(string|array $address): static
    {
        $this->to = array_merge($this->to, $this->normalizeAddresses($address));
        return $this;
    }

    /**
     * Set CC recipient(s)
     *
     * @param string|array $address Single email or array of emails
     * @return static
     */
    public function cc(string|array $address): static
    {
        $this->cc = array_merge($this->cc, $this->normalizeAddresses($address));
        return $this;
    }

    /**
     * Set BCC recipient(s)
     *
     * @param string|array $address Single email or array of emails
     * @return static
     */
    public function bcc(string|array $address): static
    {
        $this->bcc = array_merge($this->bcc, $this->normalizeAddresses($address));
        return $this;
    }

    /**
     * Set email subject
     *
     * @param string $subject
     * @return static
     */
    public function subject(string $subject): static
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * Set HTML body
     *
     * @param string $html
     * @return static
     */
    public function body(string $html): static
    {
        $this->htmlBody = $html;
        return $this;
    }

    /**
     * Set plain text body
     *
     * @param string $text
     * @return static
     */
    public function text(string $text): static
    {
        $this->textBody = $text;
        return $this;
    }

    /**
     * Attach a file
     *
     * @param string $path Absolute path to the file
     * @param string|null $name Display name for the attachment (defaults to basename)
     * @return static
     */
    public function attach(string $path, ?string $name = null): static
    {
        if (!file_exists($path) || !is_readable($path)) {
            throw new \RuntimeException("Attachment file not found or not readable: {$path}");
        }

        $this->attachments[] = [
            'path' => $path,
            'name' => $name ?? basename($path),
        ];

        return $this;
    }

    /**
     * Override the From address
     *
     * @param string $address
     * @param string $name
     * @return static
     */
    public function from(string $address, string $name = ''): static
    {
        $this->fromAddress = $address;
        $this->fromName = $name;
        return $this;
    }

    /**
     * Set Reply-To address
     *
     * @param string $address
     * @param string $name
     * @return static
     */
    public function replyTo(string $address, string $name = ''): static
    {
        $this->replyToAddress = $address;
        $this->replyToName = $name;
        return $this;
    }

    /**
     * Send the email via SMTP
     *
     * @return bool True on success, false on failure
     */
    public function send(): bool
    {
        if (empty($this->to)) {
            $this->lastError = 'No recipients specified.';
            return false;
        }

        if (empty($this->subject)) {
            $this->lastError = 'No subject specified.';
            return false;
        }

        if (empty($this->htmlBody) && empty($this->textBody)) {
            $this->lastError = 'No email body specified.';
            return false;
        }

        try {
            // Connect to SMTP server
            if (!$this->connect()) {
                return false;
            }

            // Authenticate
            if (!$this->authenticate()) {
                $this->disconnect();
                return false;
            }

            // Set envelope sender
            if (!$this->sendCommand("MAIL FROM:<{$this->fromAddress}>", 250)) {
                $this->disconnect();
                return false;
            }

            // Set all recipients on the envelope
            $allRecipients = array_merge($this->to, $this->cc, $this->bcc);
            foreach ($allRecipients as $recipient) {
                if (!$this->sendCommand("RCPT TO:<{$recipient}>", [250, 251])) {
                    $this->disconnect();
                    return false;
                }
            }

            // Begin DATA
            if (!$this->sendCommand('DATA', 354)) {
                $this->disconnect();
                return false;
            }

            // Build and send the message body
            $message = $this->buildMessage();
            fwrite($this->socket, $message);
            fwrite($this->socket, "\r\n.\r\n");

            // Read server response to end-of-data
            $response = $this->readResponse();
            if (!$this->checkResponseCode($response, 250)) {
                $this->lastError = "DATA termination failed: {$response}";
                $this->disconnect();
                return false;
            }

            // Disconnect gracefully
            $this->disconnect();

            return true;
        } catch (\Throwable $e) {
            $this->lastError = $e->getMessage();
            $this->disconnect();
            return false;
        }
    }

    /**
     * Reset state for reuse
     *
     * @return static
     */
    public function reset(): static
    {
        $this->to = [];
        $this->cc = [];
        $this->bcc = [];
        $this->subject = '';
        $this->htmlBody = '';
        $this->textBody = '';
        $this->replyToAddress = '';
        $this->replyToName = '';
        $this->attachments = [];
        $this->lastError = '';

        // Restore defaults from config
        $this->fromAddress = $this->config['from']['address'] ?? 'noreply@example.com';
        $this->fromName = $this->config['from']['name'] ?? '';

        return $this;
    }

    /**
     * Get the last error message
     *
     * @return string
     */
    public function getLastError(): string
    {
        return $this->lastError;
    }

    // ------------------------------------------------------------------
    // Private SMTP communication methods
    // ------------------------------------------------------------------

    /**
     * Connect to the SMTP server and perform initial handshake
     *
     * @return bool
     */
    private function connect(): bool
    {
        $smtp = $this->config['smtp'] ?? [];
        $host = $smtp['host'] ?? 'localhost';
        $port = (int) ($smtp['port'] ?? 587);
        $encryption = $smtp['encryption'] ?? 'tls';
        $timeout = (int) ($smtp['timeout'] ?? 30);

        // For implicit SSL (port 465), wrap with ssl://
        $socketHost = ($encryption === 'ssl') ? 'ssl://' . $host : $host;

        $errno = 0;
        $errstr = '';

        $this->socket = @fsockopen($socketHost, $port, $errno, $errstr, $timeout);

        if (!$this->socket) {
            $this->lastError = "Could not connect to SMTP server {$host}:{$port} - {$errstr} ({$errno})";
            return false;
        }

        // Set stream timeout
        stream_set_timeout($this->socket, $timeout);

        // Read server greeting
        $greeting = $this->readResponse();
        if (!$this->checkResponseCode($greeting, 220)) {
            $this->lastError = "SMTP server greeting failed: {$greeting}";
            return false;
        }

        // Send EHLO
        $ehloHost = gethostname() ?: 'localhost';
        if (!$this->sendCommand("EHLO {$ehloHost}", 250)) {
            // Fallback to HELO
            if (!$this->sendCommand("HELO {$ehloHost}", 250)) {
                $this->lastError = 'EHLO/HELO handshake failed.';
                return false;
            }
        }

        // STARTTLS for port 587 or explicit TLS
        if ($encryption === 'tls') {
            if (!$this->sendCommand('STARTTLS', 220)) {
                $this->lastError = 'STARTTLS command failed.';
                return false;
            }

            // Upgrade the connection to TLS
            $cryptoMethod = STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT;
            if (defined('STREAM_CRYPTO_METHOD_TLSv1_3_CLIENT')) {
                $cryptoMethod |= STREAM_CRYPTO_METHOD_TLSv1_3_CLIENT;
            }

            $tlsResult = @stream_socket_enable_crypto($this->socket, true, $cryptoMethod);
            if (!$tlsResult) {
                $this->lastError = 'Failed to enable TLS encryption on the SMTP connection.';
                return false;
            }

            // Re-send EHLO after STARTTLS
            if (!$this->sendCommand("EHLO {$ehloHost}", 250)) {
                $this->lastError = 'EHLO after STARTTLS failed.';
                return false;
            }
        }

        return true;
    }

    /**
     * Authenticate with the SMTP server using AUTH LOGIN
     *
     * @return bool
     */
    private function authenticate(): bool
    {
        $smtp = $this->config['smtp'] ?? [];
        $username = $smtp['username'] ?? '';
        $password = $smtp['password'] ?? '';

        // Skip authentication if no credentials provided
        if (empty($username) && empty($password)) {
            return true;
        }

        // Initiate AUTH LOGIN
        if (!$this->sendCommand('AUTH LOGIN', 334)) {
            $this->lastError = 'AUTH LOGIN command not accepted.';
            return false;
        }

        // Send username (base64 encoded)
        if (!$this->sendCommand(base64_encode($username), 334)) {
            $this->lastError = 'SMTP authentication failed: username rejected.';
            return false;
        }

        // Send password (base64 encoded)
        if (!$this->sendCommand(base64_encode($password), 235)) {
            $this->lastError = 'SMTP authentication failed: password rejected.';
            return false;
        }

        return true;
    }

    /**
     * Send an SMTP command and verify the response code
     *
     * @param string $command The SMTP command to send
     * @param int|array $expectedCode Expected response code(s)
     * @return bool
     */
    private function sendCommand(string $command, int|array $expectedCode): bool
    {
        if (!$this->socket || !is_resource($this->socket)) {
            $this->lastError = 'No active SMTP connection.';
            return false;
        }

        fwrite($this->socket, $command . "\r\n");

        $response = $this->readResponse();

        if (!$this->checkResponseCode($response, $expectedCode)) {
            $this->lastError = "SMTP command failed [{$command}]: {$response}";
            return false;
        }

        return true;
    }

    /**
     * Read full response from the SMTP server (handles multi-line responses)
     *
     * @return string
     */
    private function readResponse(): string
    {
        $response = '';

        if (!$this->socket || !is_resource($this->socket)) {
            return '';
        }

        while (true) {
            $line = fgets($this->socket, 4096);

            if ($line === false) {
                break;
            }

            $response .= $line;

            // Multi-line responses have a hyphen after the code (e.g. "250-SIZE").
            // The final line has a space (e.g. "250 OK").
            if (isset($line[3]) && $line[3] === ' ') {
                break;
            }

            // Also break if the line is shorter than expected
            if (strlen($line) < 4) {
                break;
            }
        }

        return $response;
    }

    /**
     * Disconnect from the SMTP server
     *
     * @return void
     */
    private function disconnect(): void
    {
        if ($this->socket && is_resource($this->socket)) {
            // Send QUIT command (ignore failures during disconnect)
            @fwrite($this->socket, "QUIT\r\n");
            @fgets($this->socket, 4096);
            @fclose($this->socket);
        }

        $this->socket = null;
    }

    // ------------------------------------------------------------------
    // Message building helpers
    // ------------------------------------------------------------------

    /**
     * Build the complete MIME message (headers + body)
     *
     * @return string
     */
    private function buildMessage(): string
    {
        $headers = $this->buildHeaders();
        $body = $this->buildBody();

        return $headers . "\r\n" . $body;
    }

    /**
     * Build message headers
     *
     * @return string
     */
    private function buildHeaders(): string
    {
        $headers = [];

        // Date
        $headers[] = 'Date: ' . date('r');

        // From
        if ($this->fromName !== '') {
            $headers[] = 'From: ' . $this->encodeHeader($this->fromName) . ' <' . $this->fromAddress . '>';
        } else {
            $headers[] = 'From: ' . $this->fromAddress;
        }

        // To
        $headers[] = 'To: ' . implode(', ', $this->to);

        // CC (visible in headers)
        if (!empty($this->cc)) {
            $headers[] = 'Cc: ' . implode(', ', $this->cc);
        }

        // Subject
        $headers[] = 'Subject: ' . $this->encodeHeader($this->subject);

        // Reply-To
        if ($this->replyToAddress !== '') {
            if ($this->replyToName !== '') {
                $headers[] = 'Reply-To: ' . $this->encodeHeader($this->replyToName) . ' <' . $this->replyToAddress . '>';
            } else {
                $headers[] = 'Reply-To: ' . $this->replyToAddress;
            }
        }

        // Message-ID
        $domain = $this->extractDomain($this->fromAddress);
        $headers[] = 'Message-ID: <' . bin2hex(random_bytes(16)) . '@' . $domain . '>';

        // MIME version
        $headers[] = 'MIME-Version: 1.0';

        // Content-Type is set in buildBody because it depends on attachments
        $headers[] = $this->buildContentTypeHeader();

        // Mailer identifier
        $headers[] = 'X-Mailer: SO-Framework-Mailer';

        return implode("\r\n", $headers) . "\r\n";
    }

    /**
     * Build the Content-Type header based on message composition
     *
     * @return string
     */
    private function buildContentTypeHeader(): string
    {
        $hasAttachments = !empty($this->attachments);
        $hasHtml = $this->htmlBody !== '';
        $hasText = $this->textBody !== '';
        $hasAlternative = $hasHtml && $hasText;

        if ($hasAttachments) {
            $boundary = $this->generateBoundary('mixed');
            return 'Content-Type: multipart/mixed; boundary="' . $boundary . '"';
        }

        if ($hasAlternative) {
            $boundary = $this->generateBoundary('alt');
            return 'Content-Type: multipart/alternative; boundary="' . $boundary . '"';
        }

        if ($hasHtml) {
            return 'Content-Type: text/html; charset=UTF-8';
        }

        return 'Content-Type: text/plain; charset=UTF-8';
    }

    /**
     * Build the message body (handles multipart MIME)
     *
     * @return string
     */
    private function buildBody(): string
    {
        $hasAttachments = !empty($this->attachments);
        $hasHtml = $this->htmlBody !== '';
        $hasText = $this->textBody !== '';
        $hasAlternative = $hasHtml && $hasText;

        // Simple plain text only
        if (!$hasHtml && !$hasAttachments) {
            return $this->textBody;
        }

        // Simple HTML only (no attachments, no plain text alternative)
        if ($hasHtml && !$hasText && !$hasAttachments) {
            return $this->htmlBody;
        }

        // Multipart message
        $body = '';

        if ($hasAttachments) {
            $mixedBoundary = $this->generateBoundary('mixed');
            $body .= "This is a multi-part message in MIME format.\r\n";

            if ($hasAlternative) {
                // mixed -> alternative -> text + html, then attachments
                $altBoundary = $this->generateBoundary('alt');

                $body .= "\r\n--{$mixedBoundary}\r\n";
                $body .= "Content-Type: multipart/alternative; boundary=\"{$altBoundary}\"\r\n\r\n";

                // Plain text part
                $body .= "--{$altBoundary}\r\n";
                $body .= "Content-Type: text/plain; charset=UTF-8\r\n";
                $body .= "Content-Transfer-Encoding: quoted-printable\r\n\r\n";
                $body .= $this->quotedPrintableEncode($this->textBody) . "\r\n";

                // HTML part
                $body .= "--{$altBoundary}\r\n";
                $body .= "Content-Type: text/html; charset=UTF-8\r\n";
                $body .= "Content-Transfer-Encoding: quoted-printable\r\n\r\n";
                $body .= $this->quotedPrintableEncode($this->htmlBody) . "\r\n";

                $body .= "--{$altBoundary}--\r\n";
            } elseif ($hasHtml) {
                // HTML only with attachments
                $body .= "\r\n--{$mixedBoundary}\r\n";
                $body .= "Content-Type: text/html; charset=UTF-8\r\n";
                $body .= "Content-Transfer-Encoding: quoted-printable\r\n\r\n";
                $body .= $this->quotedPrintableEncode($this->htmlBody) . "\r\n";
            } else {
                // Plain text only with attachments
                $body .= "\r\n--{$mixedBoundary}\r\n";
                $body .= "Content-Type: text/plain; charset=UTF-8\r\n";
                $body .= "Content-Transfer-Encoding: quoted-printable\r\n\r\n";
                $body .= $this->quotedPrintableEncode($this->textBody) . "\r\n";
            }

            // Attachments
            foreach ($this->attachments as $attachment) {
                $body .= $this->buildAttachmentPart($attachment, $mixedBoundary);
            }

            $body .= "--{$mixedBoundary}--\r\n";
        } else {
            // Alternative only (text + html, no attachments)
            $altBoundary = $this->generateBoundary('alt');

            $body .= "This is a multi-part message in MIME format.\r\n";

            // Plain text part
            $body .= "\r\n--{$altBoundary}\r\n";
            $body .= "Content-Type: text/plain; charset=UTF-8\r\n";
            $body .= "Content-Transfer-Encoding: quoted-printable\r\n\r\n";
            $body .= $this->quotedPrintableEncode($this->textBody) . "\r\n";

            // HTML part
            $body .= "--{$altBoundary}\r\n";
            $body .= "Content-Type: text/html; charset=UTF-8\r\n";
            $body .= "Content-Transfer-Encoding: quoted-printable\r\n\r\n";
            $body .= $this->quotedPrintableEncode($this->htmlBody) . "\r\n";

            $body .= "--{$altBoundary}--\r\n";
        }

        return $body;
    }

    /**
     * Build a single attachment MIME part
     *
     * @param array $attachment Attachment info with 'path' and 'name'
     * @param string $boundary The MIME boundary string
     * @return string
     */
    private function buildAttachmentPart(array $attachment, string $boundary): string
    {
        $filePath = $attachment['path'];
        $fileName = $attachment['name'];
        $mimeType = $this->detectMimeType($filePath);

        $fileContent = file_get_contents($filePath);
        $encoded = chunk_split(base64_encode($fileContent), 76, "\r\n");

        $part = "\r\n--{$boundary}\r\n";
        $part .= "Content-Type: {$mimeType}; name=\"{$fileName}\"\r\n";
        $part .= "Content-Transfer-Encoding: base64\r\n";
        $part .= "Content-Disposition: attachment; filename=\"{$fileName}\"\r\n\r\n";
        $part .= $encoded;

        return $part;
    }

    /**
     * Generate a deterministic MIME boundary for a given type
     *
     * Boundaries are generated per-send using a hash that incorporates
     * the type label and the current message-id seed.
     *
     * @param string $type Boundary type label (e.g. 'mixed', 'alt')
     * @return string
     */
    private function generateBoundary(string $type): string
    {
        // Cache boundaries so the same type always returns the same string
        // within a single message build cycle.
        static $boundaries = [];

        if (!isset($boundaries[$type])) {
            $boundaries[$type] = '----=_Part_' . $type . '_' . bin2hex(random_bytes(16));
        }

        return $boundaries[$type];
    }

    /**
     * Encode a header value for UTF-8 safety (RFC 2047)
     *
     * @param string $value
     * @return string
     */
    private function encodeHeader(string $value): string
    {
        // Only encode if non-ASCII characters are present
        if (mb_check_encoding($value, 'ASCII')) {
            return $value;
        }

        return '=?UTF-8?B?' . base64_encode($value) . '?=';
    }

    /**
     * Quoted-printable encode body text
     *
     * @param string $text
     * @return string
     */
    private function quotedPrintableEncode(string $text): string
    {
        return quoted_printable_encode($text);
    }

    /**
     * Normalize a string or array of email addresses into a flat array
     *
     * @param string|array $addresses
     * @return array
     */
    private function normalizeAddresses(string|array $addresses): array
    {
        if (is_string($addresses)) {
            return [trim($addresses)];
        }

        return array_map('trim', array_values($addresses));
    }

    /**
     * Extract the domain from an email address
     *
     * @param string $email
     * @return string
     */
    private function extractDomain(string $email): string
    {
        $parts = explode('@', $email);
        return $parts[1] ?? 'localhost';
    }

    /**
     * Detect MIME type of a file
     *
     * @param string $path
     * @return string
     */
    private function detectMimeType(string $path): string
    {
        // Use finfo if available
        if (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $path);
            finfo_close($finfo);

            if ($mime !== false) {
                return $mime;
            }
        }

        // Fallback: guess from extension
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        return match ($ext) {
            'pdf' => 'application/pdf',
            'zip' => 'application/zip',
            'gz', 'gzip' => 'application/gzip',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'ppt' => 'application/vnd.ms-powerpoint',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'jpg', 'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
            'csv' => 'text/csv',
            'txt' => 'text/plain',
            'html', 'htm' => 'text/html',
            'xml' => 'application/xml',
            'json' => 'application/json',
            default => 'application/octet-stream',
        };
    }

    /**
     * Check if the SMTP response starts with the expected code
     *
     * @param string $response
     * @param int|array $expected
     * @return bool
     */
    private function checkResponseCode(string $response, int|array $expected): bool
    {
        $code = (int) substr(trim($response), 0, 3);

        if (is_array($expected)) {
            return in_array($code, $expected, true);
        }

        return $code === $expected;
    }
}
