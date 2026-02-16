<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Neuron\Agents\MyOllamaAgent;
use NeuronAI\Chat\Messages\UserMessage;

class MyOllama extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:my-ollama';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Sending request to Ollama (this may take a minute)...");

        try {
            $response = MyOllamaAgent::make()->chat(
            // Use a natural language prompt
                new UserMessage("Read the file 'notes.txt' and tell me the first sentence."),
            );

            $this->info("Response received:");
            $this->info($response->getContent());
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
        } catch (\Throwable $e) {
            $this->error("Error: " . $e->getMessage());
        }
    }
}