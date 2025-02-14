<?php

namespace App\Mail;

use App\Models\Sensor;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EscalationEmail extends Mailable
{
    use Queueable, SerializesModels;

    private array $sensor;
    private array $incident;
    private array $measurements;

    /**
     * Create a new message instance.
     */
    public function __construct(array $sensor, string $type, float $value, float $min, float $max)
    {
        $this->sensor = $sensor;
        $this->incident = array(
            'time' => Carbon::now()->format('H:i:s d.M.Y'),
            'type' => $type,
        );
        $this->measurements = array(
            'min' => $min,
            'max' => $max,
            'value' => $value,
        );
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->incident['type'] == 'temp'?
                'Temperatura pri senzorju ' . $this->sensor['location'] . ' je izven mej!' :
                'Vlaga pri senzorju ' . $this->sensor['location'] . ' je izven mej!'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.escalation',
            with: [
                'sensor' => $this->sensor,
                'incident' => $this->incident,
                'measurements' => $this->measurements,
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
