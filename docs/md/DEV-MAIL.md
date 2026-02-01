# Mail System - Developer Guide

**SO Framework** | **Sending Emails** | **Version 1.0**

A practical guide to sending emails, creating mail templates, and managing email delivery in the SO Framework.

---

## Table of Contents

1. [Overview](#overview)
2. [Creating Mail Classes](#creating-mail-classes)
3. [Sending Emails](#sending-emails)
4. [Mail Templates](#mail-templates)
5. [Attachments](#attachments)
6. [Best Practices](#best-practices)

---

## Overview

The SO Framework provides a simple, fluent interface for sending emails using PHP's native mail functionality or SMTP.

### Configuration

Email settings are defined in `config/mail.php`:

```php
return [
    'driver' => env('MAIL_DRIVER', 'smtp'),
    'host' => env('MAIL_HOST', 'smtp.mailtrap.io'),
    'port' => env('MAIL_PORT', 2525),
    'username' => env('MAIL_USERNAME'),
    'password' => env('MAIL_PASSWORD'),
    'encryption' => env('MAIL_ENCRYPTION', 'tls'),
    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'noreply@example.com'),
        'name' => env('MAIL_FROM_NAME', 'SO Framework'),
    ],
];
```

Set these in your `.env` file:

```env
MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@example.com
MAIL_FROM_NAME="Your App Name"
```

---

## Creating Mail Classes

### Generate a Mail Class

```bash
./sixorbit make:mail WelcomeEmail
```

Creates `app/Mail/WelcomeEmail.php`:

```php
<?php

namespace App\Mail;

use Core\Mail\Mailable;

class WelcomeEmail extends Mailable
{
    public function __construct(
        protected array $user
    ) {}

    public function build(): self
    {
        return $this->subject('Welcome to ' . config('app.name'))
            ->view('emails.welcome')
            ->with([
                'name' => $this->user['name'],
                'email' => $this->user['email'],
            ]);
    }
}
```

### Mail Class Structure

- **Constructor** -- Accept data needed for the email
- **build()** -- Define subject, view, and data
- **view()** -- Specify the email template
- **with()** -- Pass data to the template
- **subject()** -- Set email subject
- **attach()** -- Add file attachments

---

## Sending Emails

### Basic Usage

```php
use App\Mail\WelcomeEmail;
use Core\Mail\Mail;

public function register(Request $request): Response
{
    $user = User::create($request->all());

    // Send welcome email
    Mail::to($user->email)->send(new WelcomeEmail($user->toArray()));

    return redirect('/dashboard');
}
```

### Send to Multiple Recipients

```php
Mail::to(['user1@example.com', 'user2@example.com'])
    ->send(new NewsletterEmail());
```

### CC and BCC

```php
Mail::to('user@example.com')
    ->cc('manager@example.com')
    ->bcc('admin@example.com')
    ->send(new InvoiceEmail($invoice));
```

### Queue Emails

Send emails asynchronously using the queue system:

```php
use Core\Mail\Mail;

Mail::to($user->email)
    ->queue(new WelcomeEmail($user->toArray()));
```

---

## Mail Templates

### Creating Email Views

Email templates live in `resources/views/emails/`:

**resources/views/emails/welcome.php:**

```php
<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .button {
            background: #007bff;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome, <?= e($name) ?>!</h1>

        <p>Thank you for joining <?= config('app.name') ?>.</p>

        <p>Your account has been created with the email: <strong><?= e($email) ?></strong></p>

        <p>
            <a href="<?= url('/dashboard') ?>" class="button">
                Go to Dashboard
            </a>
        </p>

        <p>
            If you have any questions, feel free to reply to this email.
        </p>

        <p>
            Best regards,<br>
            The <?= config('app.name') ?> Team
        </p>
    </div>
</body>
</html>
```

### Using Data in Templates

Data passed via `with()` is available as variables:

```php
// In Mail class
return $this->view('emails.invoice')
    ->with([
        'invoiceNumber' => $invoice->number,
        'amount' => $invoice->amount,
        'dueDate' => $invoice->due_date,
    ]);
```

```php
<!-- In template -->
<h1>Invoice #<?= e($invoiceNumber) ?></h1>
<p>Amount: $<?= number_format($amount, 2) ?></p>
<p>Due: <?= date('M d, Y', strtotime($dueDate)) ?></p>
```

---

## Attachments

### Attach Files

```php
public function build(): self
{
    return $this->subject('Your Invoice')
        ->view('emails.invoice')
        ->attach(storage_path('invoices/invoice-123.pdf'));
}
```

### Attach with Custom Name

```php
return $this->attach(storage_path('invoices/invoice-123.pdf'), [
    'as' => 'Invoice.pdf',
    'mime' => 'application/pdf',
]);
```

### Attach from Data

```php
return $this->attachData($pdfContent, 'invoice.pdf', [
    'mime' => 'application/pdf',
]);
```

---

## Best Practices

### 1. Always Queue Emails

Never send emails synchronously in web requests:

```php
// Bad - blocks user request
Mail::to($user->email)->send(new WelcomeEmail($user));

// Good - sends via queue
Mail::to($user->email)->queue(new WelcomeEmail($user));
```

### 2. Use Plain Text Alternatives

Provide plain text versions for email clients that don't support HTML:

```php
return $this->view('emails.welcome')
    ->text('emails.welcome_plain');
```

### 3. Escape User Data

Always escape user data in templates:

```php
<h1>Hello, <?= e($name) ?>!</h1>
```

### 4. Test Emails in Development

Use a service like Mailtrap or MailHog to catch emails during development:

```env
MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
```

### 5. Handle Failures

Wrap email sending in try-catch blocks:

```php
try {
    Mail::to($user->email)->send(new WelcomeEmail($user));
} catch (\Exception $e) {
    logger()->error('Failed to send welcome email', [
        'user_id' => $user->id,
        'error' => $e->getMessage(),
    ]);
}
```

---

**Related Documentation:**
- [Queue System](/docs/dev/queues) - Background job processing
- [CLI Commands](/docs/dev/cli-commands) - Mail command reference
- [Events](/docs/dev/events) - Sending emails on events

---

**Last Updated**: 2026-01-31
**Framework Version**: 1.0
