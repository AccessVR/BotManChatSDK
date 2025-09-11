<?php

namespace OrchestrateXR\BotManChatSDK\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use League\CommonMark\CommonMarkConverter;
use LLPhant\Chat\ChatInterface;
use LLPhant\Chat\FunctionInfo\FunctionInfo;
use LLPhant\Chat\FunctionInfo\Parameter;
use LLPhant\Chat\Message;
use OrchestrateXR\BotManChatSDK\Contracts\DefaultChatInterface;
use Psr\Log\LoggerInterface;

class ChatConversation extends Conversation
{
    protected string $chatInterfaceKey = DefaultChatInterface::class;

    protected Collection $messages;

    protected Collection $tools;

    protected bool $convertMarkdownToHtml = false;

    final public function __construct()
    {
        $this->messages = collect([]);
        $this->tools = collect([]);

        $this->system('You are a helpful assistant. You strive for brevity and clarity.');
    }

    public static function make(?string $prompt = null): static
    {
        $conversation = new static;
        if (! empty($prompt)) {
            $conversation->user($prompt);
        }

        return $conversation;
    }

    /**
     * Reset the message and tools in this conversation.
     *
     * @return $this
     */
    public function reset(): self
    {
        $this->messages = collect([]);
        $this->tools = collect([]);

        return $this;
    }

    /**
     * Set the system message for this conversation.
     *
     * @return $this
     */
    public function system(string $content): self
    {
        $this->messages = $this->messages->filter(function ($message) {
            if ($message instanceof Message) {
                return $message->role !== 'system';
            } else {
                return ! empty($message['role']) && $message['role'] !== 'system';
            }
        });

        $this->messages->prepend(Message::system($content));

        return $this;
    }

    /**
     * Append a user message to this conversation.
     *
     * @return $this
     */
    public function user(string $content): self
    {
        $this->messages->push(Message::user($content));

        return $this;
    }

    /**
     * Append an assistant message to this conversation.
     *
     * @return $this
     */
    public function assistant(string $content): self
    {
        $this->messages->push(Message::assistant($content));

        return $this;
    }

    public function withTool(FunctionInfo $tool): self
    {
        $this->tools->push($tool);

        return $this;
    }

    public function withCrawler(): self
    {
        $crawler = new FunctionInfo(
            'getContentsFromUrl',
            $this,
            'If the user provides a URL, you can use this function get get the contents of the URL.',
            [new Parameter('url', 'string', 'The URL to crawl')]
        );

        if (! $this->tools->contains($crawler)) { // this probably doesn't work...
            $this->tools->push($crawler);
        }

        return $this->withTool($crawler);
    }

    public function getContentsFromUrl(string $url): string
    {
        return Http::get($url)->body();
    }

    public function stopsConversation(IncomingMessage $message): bool
    {
        return $message->getText() === 'stop conversation';
    }

    protected function handleChatResponse(string $response): void
    {
        $this->log($response);

        $this->assistant($response);

        if ($this->convertMarkdownToHtml) {
            if (! $converter = app(CommonMarkConverter::class)) {
                throw new \Exception('CommonMarkConverter not found in container');
            }
            $response = (string) $converter->convert($response);
        }

        $this->ask($response, function (Answer $answer) {
            $this->log($answer);
            $this->user($answer->getText());
            $this->handleChatResponse($this->generateChatResponse());
        });
    }

    public function log($something): void
    {
        $this->logger()->info($something);
    }

    public function logger(): LoggerInterface
    {
        return Log::channel(null);
    }

    /**
     * @param  string|null  $chatInterfaceKey  Optionally, specify a container registration key for overriding default
     */
    public function chat(?string $chatInterfaceKey = null): ChatInterface|self
    {
        if (! empty($chatInterfaceKey)) {
            $this->chatInterfaceKey = $chatInterfaceKey;

            return $this;
        }

        $chat = $this->getChatInterfaceFromContainer();
        $this->tools->each(fn (FunctionInfo $tool) => $chat->addTool($tool));

        return $chat;
    }

    protected function getChatInterfaceFromContainer(): ChatInterface
    {
        return app($this->chatInterfaceKey);
    }

    /**
     * @return string The content of the generated chat response
     */
    protected function generateChatResponse(): string
    {
        $messages = collect($this->messages)->map(function ($message) {
            if ($message instanceof Message) {
                return $message;
            }

            return match ($message['role']) {
                'system' => Message::system($message['content']),
                'user' => Message::user($message['content']),
                'assistant' => Message::assistant($message['content']),
                default => throw new \Exception('Invalid message role: '.$message['role'])
            };
        })->toArray();

        return $this->chat()->generateChat($messages);
    }

    public function run(): void
    {
        $this->handleChatResponse($this->generateChatResponse());
    }

    public function convertMarkdownToHtml(bool $convertMarkdownToHtml): self
    {
        $this->convertMarkdownToHtml = $convertMarkdownToHtml;

        return $this;
    }
}
