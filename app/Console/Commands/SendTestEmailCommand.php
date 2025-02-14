<?php

namespace App\Console\Commands;

use App\Mail\EscalationEmail;
use App\Models\Sensor;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTestEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-test-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending test email.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $message = Mail::to('n.mlakar@resistec.si')
            ->send(new EscalationEmail([
                'id' => 5,
                'name' => 'Test',
                'location' => 'Test',
                'position' => 24,
                'active_temp_alarm' => false,
                'active_humid_alert' => false,
            ], 'temp', 18, 25, 50));
    }
}
