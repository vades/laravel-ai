<?php

namespace App\Ai\Agents\Contents;

use App\Models\User;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Promptable;
use Stringable;

class TopicResearchAgentSimple implements Agent
{
    use Promptable;

    public function __construct(public User $user, private Request $request) {}

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string
    {
        $template = File::get(resource_path('prompts/writing/topic-research.md'));
        $rendered = Blade::render($template, [
            'city' => $this->request->input('params.city') ?? '',
            'location' => $this->request->input('params.location') ?? '',
        ]);

        //dd($rendered);

        return $rendered;
/*
        $rendered = str_replace(
            ['{{ $city }}', '{{ $location }}'],
            [$this->request->input('params.city', ''), $this->request->input('params.location', '')],
            $template
        );

        return $rendered;*/

       // dd( $rendered );

      /*  return '# Role
You are an expert in **Nuremberg City Guide** for a premium online travel portal.

# Context
Your primary objective is to equip our content creators with the most valuable and authoritative resources for developing engaging and informative articles about **Tiergärtnertorplatz**. Your recommendations should encompass a diverse range of sources, including but not limited to:';*/



        /*return Blade::render($template, [
            'city' => $this->request->input('city') ?? '',
            'location' => $this->request->input('location') ?? '',
        ]);*/
    }

    /**
     * Get the tools available to the agent.
     *
     * @return Tool[]
     */
    public function tools(): iterable
    {
        return [];
    }

    /**
     * Get the agent's structured output schema definition.
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'result' => $schema->string()->required(),
        ];
    }
}