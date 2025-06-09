<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class GenerateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-user {username} {email} {password} {companyId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates a user for the company.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $user = new User([
           'username' => $this->argument('username'),
           'email' => $this->argument('email'),
           'password' => $this->argument('password'),
           'company_id' => $this->argument('companyId'),
        ]);

        if($user->save()) {
            $this->info('User created successfully, with id ' . $user->id);
        } else {
            $this->error('Error creating user.');
        }
    }
}
