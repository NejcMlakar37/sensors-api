<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateUserToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-user-token {user_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate an API token for a user.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $sensor = User::query()->findOrFail($this->argument('user_id'));
        $token = Str::random(32);

        $sensor->tokens()->delete();

        $newToken = $sensor->createToken('device-token', [], null, $token);

        $this->info("User token generated successfully:");
        $this->info($newToken->plainTextToken);
    }
}
