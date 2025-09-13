<?php

use App\Http\Controllers\admin\IntegrationController;
use App\Http\Controllers\FlowController;
use App\Http\Controllers\GoogleController;
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
    Route::post("/{unique_id}", [FlowController::class, "update"]);
});


Route::group(["prefix" => "integrations"], function () {
    Route::get("/", [IntegrationController::class, "integrations"]);
});
 

Route::get('/user', [UserController::class, "user"])->middleware('auth:sanctum');

