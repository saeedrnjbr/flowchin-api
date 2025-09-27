<?php

use App\Http\Controllers\admin\IntegrationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ElementController;
use App\Http\Controllers\FlowController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkspaceController;
use Illuminate\Support\Facades\Route;

Route::group(["prefix" => "users"], function () {
    Route::post("/login", [UserController::class, "login"]);
    Route::post("/verify", [UserController::class, "verify"]);
    Route::post("/google", [UserController::class, "google"]);
});

Route::group(["prefix" => "workspaces", "middleware" => 'auth:sanctum'], function () {
    Route::get("/", [WorkspaceController::class, "index"]);
    Route::get("/delete/{id}", [WorkspaceController::class, "remove"]);
    Route::post("/", [WorkspaceController::class, "store"]);
    Route::post("/{id}", [WorkspaceController::class, "update"]);
});

Route::group(["prefix" => "flows", "middleware" => 'auth:sanctum'], function () {
    Route::get("/", [FlowController::class, "index"]);
    Route::post("/", [FlowController::class, "store"]);
    Route::get("/{unique_id}", [FlowController::class, "nodes"]);
    Route::get("/copy/{unique_id}", [FlowController::class, "copy"]);
    Route::get("/delete/{unique_id}", [FlowController::class, "remove"]);
    Route::post("/workspace/{unique_id}", [FlowController::class, "workspace"]);
    Route::post("/{unique_id}", [FlowController::class, "update"]);
});


Route::group(["prefix" => "integrations"], function () {
    Route::get("/", [IntegrationController::class, "integrations"]);
    Route::get("/interface", [IntegrationController::class, "interface"]);
});

Route::group(["prefix" => "elements"], function () {
    Route::get("/", [ElementController::class, "elements"]);
});

Route::group(["prefix" => "uploads"], function () {
    Route::post("/", [DashboardController::class, "uploads"]);
});

Route::get('/user', [UserController::class, "user"])->middleware('auth:sanctum');
