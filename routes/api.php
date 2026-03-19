<?php

use App\Ai\Agents\Contents\TopicResearchAgent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/agents/topic-research', function (Request $request) {
    $user = User::first();
    //dd($request->input('prompt'));
    try {
        $response = (new TopicResearchAgent($user))->forUser($user)->prompt($request->input('prompt'));

        return response()->json([
                                    'message' => 'success',
                                ]);
    } catch (\Throwable $e) {
        return response()->json([
                                    'message' => $e->getMessage(),
                                ], 500);
    }

})->name('agents.topic-research');