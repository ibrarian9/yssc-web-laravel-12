<?php

namespace App\Mail;

use App\Models\Mitra;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MitraRegisteredNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Mitra $mitra) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[YSSC] Pendaftaran Mitra Baru — ' . $this->mitra->nama_perusahaan,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.mitra.registered',
        );
    }
}
