<?php

declare(strict_types=1);

namespace App\Neuron\Tools;

use NeuronAI\Tools\PropertyType;
use NeuronAI\Tools\Tool;
use NeuronAI\Tools\ToolProperty;

class ReadLocalFileTool extends Tool
{
    public function __construct()
    {
        // Define Tool name and description
        parent::__construct(
            name: 'read_file',
            description: 'Read the text content of a local file.'
        );
    }

    /**
     * Properties are the input arguments of the __invoke method.
     */
    protected function properties(): array
    {
        return [
            new ToolProperty(
                name: 'filename',
                type: PropertyType::STRING,
                description: 'The name of the local .txt file to read (e.g., info.txt).',
                required: true,
            ),
        ];
    }

    /**
     * Implementing the tool logic
     */
    public function __invoke(string $filename): string
    {
        dump("TOOL TRIGGERED! Reading file: " . $filename);

        // Use an absolute path to the project root to avoid any "searching" delay
        $path = base_path($filename);

        // If the file doesn't exist, return immediately so the LLM doesn't wait
        if (!file_exists($path)) {
            return "The file {$filename} does not exist in the project root.";
        }

        return file_get_contents($path);
    }
}