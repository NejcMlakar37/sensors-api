<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BatteryLowMail extends Mailable
{
    use Queueable, SerializesModels;

    private array $sensor;
    private float $battery;

    /**
     * Create a new message instance.
     */
    public function __construct(array $sensor, float $battery)
    {
        $this->sensor = $sensor;
        $this->battery = $battery;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Potrebna je zamenjava baterije!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.battery-low',
            with:  [
                'sensor' => $this->sensor,
                'battery' => $this->battery,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments(): array
    {
        return [];
    }
}
