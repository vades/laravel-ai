<?php

use App\Ai\Agents\Contents\TopicResearchAgent;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');