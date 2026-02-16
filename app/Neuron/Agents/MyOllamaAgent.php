<?php

declare(strict_types=1);

namespace App\Neuron\Agents;

use App\Neuron\Tools\ReadLocalFileTool;
use NeuronAI\Agent;
use NeuronAI\Providers\AIProviderInterface;
use NeuronAI\Providers\HttpClientOptions;
use NeuronAI\Providers\Ollama\Ollama;
use NeuronAI\SystemPrompt;
use NeuronAI\Tools\ToolInterface;
use NeuronAI\Tools\Toolkits\ToolkitInterface;

class MyOllamaAgent extends Agent
{
    protected function provider(): AIProviderInterface
    {
        return new Ollama(
            url: config('myapp.ollama_api_url'),
            model: config('myapp.ollama_model'),
            parameters: [],
            httpOptions: new HttpClientOptions(timeout: 300),
        );
    }

    public function instructions(): string
    {
        return (string) new SystemPrompt(
            background: ['You are a functional AI assistant. 
    When you need to read a file, you MUST call the "read_file" tool. 
    DO NOT tell the user you are calling the tool. 
    Just output the tool call and nothing else.'],
        );
    }

    /**
     * @return ToolInterface[]|ToolkitInterface[]
     */
    protected function tools(): array
    {
        return [
            // 2. Add the tool to the array
           new ReadLocalFileTool(),
        ];
    }
}