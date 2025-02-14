<?php

namespace App\Services;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class ResponseMacroServiceProvider extends ServiceProvider
{
    public function boot(): void {
        Response::macro('insert', function($id) {
            return Response::json([
                'success' => true,
                'last_insert_id' => $id
            ], 201);
        });

        Response::macro('success', function ($data) {
            return Response::json([
                'success' => true,
                'data' => $data,
            ]);
        });

        Response::macro('error', function ($message, $status = 500) {
            return Response::json([
                'success'  => false,
                'message' => $message,
            ], $status);
        });
    }
}
