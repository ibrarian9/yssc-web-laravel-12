<?php

namespace App\Mail;

use App\Models\Mitra;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MitraApprovedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Mitra $mitra) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[YSSC] Selamat! Pendaftaran Mitra Anda Disetujui',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.mitra.approved',
        );
    }
}
