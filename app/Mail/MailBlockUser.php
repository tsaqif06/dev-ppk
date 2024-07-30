<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailBlockUser extends Mailable
{
    use Queueable, SerializesModels;

    protected $reason;

    public function __construct($reason)
    {
        $this->reason = $reason;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Account Blocked',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.block',
            with: [
                'reason' => $this->reason,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
