<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AllDataExportMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $filePath;
    public string $userName;

    public function __construct(string $filePath, string $userName)
    {
        $this->filePath = $filePath;
        $this->userName = $userName;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Xuất dữ liệu - Đăng ký, Lời hứa, Ghi chú'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.all_data_export',
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromStorageDisk('local', $this->filePath)
                ->as('du_lieu_cua_toi.xlsx')
                ->withMime('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'),
        ];
    }
}
