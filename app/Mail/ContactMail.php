<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    private string $senderName;
    private string $senderEmail;
    private ?string $senderPhone;
    private ?string $subjectType;
    private string $msgBody;

    public function __construct(
        string $name,
        string $email,
        ?string $phone,
        ?string $subjectType,
        string $msgBody
    ) {
        $this->senderName    = $name;
        $this->senderEmail  = $email;
        $this->senderPhone  = $phone;
        $this->subjectType  = $subjectType;
        $this->msgBody      = $msgBody;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[Toko Sembako] Pesan Baru: ' . $this->getSubjectLabel(),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact',
            with: [
                'name'    => $this->senderName,
                'email'   => $this->senderEmail,
                'phone'   => $this->senderPhone ?? '-',
                'subject' => $this->getSubjectLabel(),
                'msgBody' => $this->msgBody,
            ],
        );
    }

    private function getSubjectLabel(): string
    {
        $labels = [
            'order'       => 'Pertanyaan Pesanan',
            'product'     => 'Informasi Produk',
            'complaint'   => 'Keluhan',
            'suggestion'  => 'Saran',
            'partnership' => 'Kemitraan',
            'other'       => 'Lainnya',
        ];

        return $labels[$this->subjectType] ?? $this->subjectType ?? 'Tanpa Subjek';
    }
}
