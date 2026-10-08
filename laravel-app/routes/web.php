<?php

use App\Infrastructure\Http\Controllers\CreateEventController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');
Route::post('/events', CreateEventController::class)->name('events.store');
