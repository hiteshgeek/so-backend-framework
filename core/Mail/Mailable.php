<?php

namespace Core\Mail;

/**
 * Mailable
 *
 * Abstract base class for creating reusable email templates.
 * Developers extend this class and override the build() method
 * to define recipient, subject, and body for each mail type.
 *
 * Example usage:
 *
 *   class WelcomeMail extends Mailable
 *   {
 *       public function __construct(protected string $username) {}
 *
 *       public function build(): static
 *       {
 *           return $this
 *               ->subject('Welcome!')
 *               ->view('emails.welcome', ['username' => $this->username]);
 *       }
 *   }
 *
 *   (new WelcomeMail('John'))->to('john@example.com')->send();
 */
abstract class Mailable
{
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
     * From address ['address' => '', 'name' => '']
     *
     * @var array
     */
    protected array $from = [];

    /**
     * Reply-To ['address' => '', 'name' => '']
     *
     * @var array
     */
    protected array $replyTo = [];

    /**
     * File attachments
     *
     * @var array
     */
    protected array $attachments = [];

    /**
     * HTML body content
     *
     * @var string
     */
    protected string $htmlContent = '';

    /**
     * Plain text body content
     *
     * @var string
     */
    protected string $textContent = '';

    /**
     * Build the message.
     *
     * Subclasses must implement this method to configure
     * the email subject, body, and any other properties.
     *
     * @return static
     */
    abstract public function build(): static;

    /**
     * Set To recipient(s)
     *
     * @param string|array $address
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
     * @param string|array $address
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
     * @param string|array $address
     * @return static
     */
    public function bcc(string|array $address): static
    {
        $this->bcc = array_merge($this->bcc, $this->normalizeAddresses($address));
        return $this;
    }

    /**
     * Set the email subject
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
     * Override the From address
     *
     * @param string $address
     * @param string $name
     * @return static
     */
    public function from(string $address, string $name = ''): static
    {
        $this->from = ['address' => $address, 'name' => $name];
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
        $this->replyTo = ['address' => $address, 'name' => $name];
        return $this;
    }

    /**
     * Attach a file
     *
     * @param string $path Absolute path to the file
     * @param string|null $name Display name (defaults to basename)
     * @return static
     */
    public function attach(string $path, ?string $name = null): static
    {
        $this->attachments[] = [
            'path' => $path,
            'name' => $name ?? basename($path),
        ];
        return $this;
    }

    /**
     * Render a PHP view template as the HTML body
     *
     * Uses the framework's View service to render a template
     * with the given data, and sets the result as the HTML body.
     *
     * @param string $viewPath View template path (dot notation, e.g. 'emails.welcome')
     * @param array $data Data to pass to the template
     * @return static
     */
    public function view(string $viewPath, array $data = []): static
    {
        $view = app('view');
        $this->htmlContent = $view->render($viewPath, $data);
        return $this;
    }

    /**
     * Set raw HTML as the email body
     *
     * @param string $content
     * @return static
     */
    public function html(string $content): static
    {
        $this->htmlContent = $content;
        return $this;
    }

    /**
     * Set plain text body
     *
     * @param string $content
     * @return static
     */
    public function text(string $content): static
    {
        $this->textContent = $content;
        return $this;
    }

    /**
     * Build the mailable and send it via the Mailer
     *
     * Calls build() to let the subclass configure the message,
     * then transfers all properties to the Mailer and sends.
     *
     * @param Mailer|null $mailer Optional Mailer instance. If null, resolves from the container.
     * @return bool True on success, false on failure
     */
    public function send(?Mailer $mailer = null): bool
    {
        // Call the subclass build method to configure the message
        $this->build();

        // Resolve the mailer from the container if not provided
        if ($mailer === null) {
            $mailer = app('mailer');
        }

        // Reset the mailer to ensure a clean state
        $mailer->reset();

        // Transfer recipients
        if (!empty($this->to)) {
            $mailer->to($this->to);
        }
        if (!empty($this->cc)) {
            $mailer->cc($this->cc);
        }
        if (!empty($this->bcc)) {
            $mailer->bcc($this->bcc);
        }

        // Transfer subject
        if ($this->subject !== '') {
            $mailer->subject($this->subject);
        }

        // Transfer from address
        if (!empty($this->from)) {
            $mailer->from($this->from['address'], $this->from['name'] ?? '');
        }

        // Transfer reply-to
        if (!empty($this->replyTo)) {
            $mailer->replyTo($this->replyTo['address'], $this->replyTo['name'] ?? '');
        }

        // Transfer body content
        if ($this->htmlContent !== '') {
            $mailer->body($this->htmlContent);
        }
        if ($this->textContent !== '') {
            $mailer->text($this->textContent);
        }

        // Transfer attachments
        foreach ($this->attachments as $attachment) {
            $mailer->attach($attachment['path'], $attachment['name']);
        }

        return $mailer->send();
    }

    /**
     * Normalize addresses into a flat array
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
}
