<?php

namespace App\Console\Commands;

use App\Ai\Agents\SalesCoach;
use Illuminate\Console\Command;

class Aitest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:ai-test';

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

        try {
            $response = (new SalesCoach)->prompt('Hi i am looking to buy a new phone, can you help me?');
            $this->info('Response received:');
            $this->info($response);
        } catch (\Exception $e) {
            $this->error('Error: '.$e->getMessage());
        } catch (\Throwable $e) {
            $this->error('Error: '.$e->getMessage());
        }
    }
}
