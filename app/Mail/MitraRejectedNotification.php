<?php

namespace App\Mail;

use App\Models\Mitra;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MitraRejectedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Mitra $mitra) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[YSSC] Pendaftaran Mitra Anda Ditolak',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.mitra.rejected',
        );
    }
}
