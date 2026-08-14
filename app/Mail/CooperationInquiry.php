<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CooperationInquiry extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly array $inquiry,
        public readonly string $language,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            replyTo: [new Address($this->inquiry['email'], $this->inquiry['name'])],
            subject: trans('cooperation.mail.subject', [
                'title' => $this->inquiry['initiative_title'],
            ], $this->language),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.cooperation-inquiry',
            with: [
                'language' => $this->language,
                'labels' => trans('cooperation.mail.labels', [], $this->language),
                'partnerType' => trans(
                    'cooperation.form.partner_types.'.$this->inquiry['partner_type'],
                    [],
                    $this->language,
                ),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
