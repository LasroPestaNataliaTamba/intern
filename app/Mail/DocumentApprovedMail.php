<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;

class DocumentApprovedMail extends Mailable
{
    public string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Dokumen Permintaan Anda',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.document-approved',
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromPath($this->filePath),
        ];
    }
}
