<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Ollama API URL
    |--------------------------------------------------------------------------
    |
    | This option defines the URL for the Ollama API.
    |
    */

    'ollama_api_url' => env('MY_OLLAMA_API_URL', 'http://localhost:11434/api'),

    /*
    |--------------------------------------------------------------------------
    | Ollama Model
    |--------------------------------------------------------------------------
    |
    | This option defines the model to be used with the Ollama API.
    |
    */

    'ollama_model' => env('OLLAMA_MODEL', 'llama3.1'),

];