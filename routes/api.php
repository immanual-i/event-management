<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\AttendeeController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::apiResource('events', EventController::class)->middleware('auth:sanctum')->middleware('throttle:api')->only(['store', 'destroy', 'update']);
Route::apiResource('events.attendees', AttendeeController::class)->scoped()->except(['index', 'show', 'update'])->middleware('auth:sanctum')->middleware('throttle:60,1')->only(['store', 'destroy']);
