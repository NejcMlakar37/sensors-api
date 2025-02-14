<?php

namespace App\Mail;

use App\Models\Sensor;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DeEscalationEmail extends Mailable
{
    use Queueable, SerializesModels;

    private array $sensor;
    private array $incident;

    /**
     * Create a new message instance.
     */
    public function __construct(array $sensor, string $type)
    {
        $this->sensor = $sensor;
        $this->incident = array(
            'time' => Carbon::now()->format('H:i:s d.M.Y'),
            'type' => $type,
        );
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->incident['type'] == 'temp'?
                'Temperatura pri senzorju ' . $this->sensor['location'] . ' se je stabilizirala!' :
                'Vlaga pri senzorju ' . $this->sensor['location'] . ' se je stabilizirala!'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.deescalation',
            with: [
                'sensor' => $this->sensor,
                'incident' => $this->incident,
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
