<?php

namespace App\Console\Commands;

use App\Ai\Agents\Contents\TopicResearchAgent;
use App\Models\User;
use Illuminate\Console\Command;

class AgentTopicResearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:agent-topic-research';

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
        $this->info('Sending request to Gemini.');
        $user = User::first();

        try {
            $response = (new TopicResearchAgent($user))->forUser($user)->prompt('Create a comprehensive research dossier on the topic of "The Future of Remote Work". Include current statistics, key talking points, competitive landscape analysis, trending angles, and authoritative source material.');
            $this->info('Response received:');
            $this->info($response['result']);
        } catch (\Exception $e) {
            $this->error('Error: '.$e->getMessage());
        } catch (\Throwable $e) {
            $this->error('Error: '.$e->getMessage());
        }
    }
}