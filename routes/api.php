<?php

use App\Ai\Agents\Contents\TopicResearchAgent;
use App\Ai\Agents\Contents\TopicResearchAgentSimple;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/agents/topic-research-simple', function (Request $request) {
    $user = User::first();
    try {
        $response = (new TopicResearchAgentSimple($user, $request))->prompt($request->input('prompt'));

        return response()->json([
            'result' => $response,
            'message' => 'success',
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'message' => $e->getMessage(),
        ], 500);
    }

})->name('agents.topic-research');

Route::post('/agents/topic-research', function (Request $request) {
    $user = User::first();
    try {
        $response = (new TopicResearchAgent($user, $request))->forUser($user)->prompt($request->input('prompt'));

        return response()->json([
            'data' => $response,
            'message' => 'success',
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'message' => $e->getMessage(),
        ], 500);
    }

})->name('agents.topic-research');