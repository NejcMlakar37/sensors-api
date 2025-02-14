<?php

namespace App\Mail;

use App\Models\Sensor;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AlertEmail extends Mailable
{
    use Queueable, SerializesModels;

    private array $sensor;
    private array $incident;

    /**
     * Create a new message instance.
     */
    public function __construct(Sensor $sensor, string $message, bool $isAlert)
    {
        $this->sensor = $sensor->toArray();
        $this->incident = array(
            'time' => Carbon::now()->format('H:i:s d.M.Y'),
            'isAlert' => $isAlert,
            'message' => $message
        );
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Alert Email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.alert',
            with: [
                'sensor' => $this->sensor,
                'incident' => $this->incident,
            ],
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
