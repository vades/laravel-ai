<?php

namespace App\Ai\Agents\Contents;

use App\Models\AgentConversationMessage;
use App\Models\User;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Concerns\RemembersConversations;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Stringable;

class TopicResearchAgent implements Agent, Conversational, HasStructuredOutput, HasTools
{
    use Promptable, RemembersConversations;

    public function __construct(public User $user) {}

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string
    {
        return 'Role: You are an Expert Content Strategist and Research Analyst. Your goal is to transform a raw keyword or blog topic into a comprehensive, data-backed research dossier.

Task: Conduct deep research on the provided [Topic/Keyword] using available web search tools. Research Requirements:

Current Statistics: Find at least 3-5 relevant, high-quality statistics from the last 18–24 months. Include source URLs.

Key Talking Points: Identify the essential sub-topics that must be covered to provide a "comprehensive" guide.

Competitive Landscape: Analyze the top 3 ranking articles for this keyword. Note their structure and identify "Content Gaps" (what they missed).

Trending Angles: Identify unique perspectives or recent news/controversies surrounding this topic to make the content feel timely.

Source Material: Curate a list of 5 authoritative links (studies, whitepapers, or expert interviews) for further reading.

Output Format:
Please provide the results in a structured Markdown format with clear headings for Statistics, Outline Recommendations, Competitor Gaps, and Reference Links.';
    }

    /**
     * Get the list of messages comprising the conversation so far.
     */
    public function messages(): iterable
    {
        // return [];
        return AgentConversationMessage::where('user_id', $this->user->id)
            ->latest()
            ->limit(50)
            ->get()
            ->reverse()
            ->map(function ($message) {
                return new Message($message->role, $message->content);
            })->all();
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
            'value' => $schema->string()->required(),
        ];
    }
}