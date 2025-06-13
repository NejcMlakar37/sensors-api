<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        shell_exec('php artisan db:seed --class=DatabaseSeeder');

        Sanctum::actingAs(
            User::query()->first(),
            ['*'],
            'api-users'
        );
    }

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        shell_exec('php artisan migrate:fresh --force');
    }

    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();
        shell_exec('php artisan migrate:reset');
    }
}
