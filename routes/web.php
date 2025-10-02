<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\IntegrationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ElementController;
use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Route;

Route::get("/", function () {
    return response()->json([
        "result" => "Flowchin Api Services v1.0.0"
    ]);
});


Route::group(["prefix" => "admin"], function () {

    Route::get("/", [AdminController::class, "login"])->name("login");
    Route::post("/", [AdminController::class, "auth"])->name("auth");
    Route::get("/dashboard", [DashboardController::class, "index"])->name("dashboard");

    Route::group(["prefix" => "integrations"], function () {
        Route::get("/", [IntegrationController::class, "index"])->name("integrations.index");
        Route::get("/create", [IntegrationController::class, "create"])->name("integrations.create");
        Route::get("/create/{id}", [IntegrationController::class, "show"])->name("integrations.show");
        Route::get("/delete/{id}", [IntegrationController::class, "remove"])->name("integrations.remove");
        Route::post("/", [IntegrationController::class, "store"])->name("integrations.store");
        Route::post("/{id}", [IntegrationController::class, "update"])->name("integrations.update");
    });


    Route::group(["prefix" => "elements"], function () {
        Route::get("/", [ElementController::class, "index"])->name("elements.index");
        Route::get("/create", [ElementController::class, "create"])->name("elements.create");
        Route::get("/create/{id}", [ElementController::class, "show"])->name("elements.show");
        Route::get("/delete/{id}", [ElementController::class, "remove"])->name("elements.remove");
        Route::post("/", [ElementController::class, "store"])->name("elements.store");
        Route::post("/{id}", [ElementController::class, "update"])->name("elements.update");
    });
});


Route::group(["prefix" => "google-services"], function () {
    Route::get('redirect', [GoogleController::class, 'redirect']);
    Route::get('callback', [GoogleController::class, 'callback']);
});
