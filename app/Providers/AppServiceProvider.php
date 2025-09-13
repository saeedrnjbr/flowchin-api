<?php

namespace App\Providers;

use App\Models\PersonalAccessToken;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Sanctum::usePersonalAccessTokenModel(
            PersonalAccessToken::class
        );

        Response::macro('success', function ($data) {

            if (is_object($data)) {
                return Response::json(array_merge([
                    "error" => false,
                    "message" => ""
                ], $data->toArray()));
            }

            return Response::json([
                'error'  => false,
                'message' => "",
                'data' => $data,
            ]);
        });

        Response::macro('error', function ($data) {
            return Response::json([
                'error'  => true,
                "message" => $data,
                'data' => [],
            ]);
        });
    }
}
