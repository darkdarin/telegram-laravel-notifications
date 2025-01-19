<?php

namespace DarkDarin\TelegramNotification;

use DarkDarin\TelegramBotSdk\DTO\InlineKeyboardButton;
use DarkDarin\TelegramBotSdk\DTO\ParseModeEnum;
use Illuminate\Support\Facades\View;

class TelegramMessage
{
    private string|int|null $chatId = null;
    private ?string $botName = null;
    private ?string $text = '';
    private ParseModeEnum $parseMode = ParseModeEnum::HTML;
    private ?string $actionUrl = null;
    private ?string $actionText = null;
    private ?array $keyboard = null;

    public static function create(string $text = ''): self
    {
        return (new self())->text($text);
    }

    public function bot(string $botName): self
    {
        $this->botName = $botName;
        return $this;
    }

    public function to(string|int $chatId): self
    {
        $this->chatId = $chatId;
        return $this;
    }

    public function text(string $text): self
    {
        $this->text = $text;
        return $this;
    }

    public function line(string $text): self
    {
        $this->text .= $text . "\n";
        return $this;
    }

    public function action(string $text, string $url): self
    {
        $this->actionUrl = $url;
        $this->actionText = $text;
        return $this;
    }

    /**
     * @param list<list<InlineKeyboardButton>> $keyboard
     * @return $this
     */
    public function keyboard(array $keyboard): self
    {
        $this->keyboard = $keyboard;
        return $this;
    }

    public function parseMode(ParseModeEnum $parseMode): self
    {
        $this->parseMode = $parseMode;
        return $this;
    }

    public function view(string $view, array $data = [], array $mergeData = []): self
    {
        return $this->text(View::make($view, $data, $mergeData)->render());
    }

    public function getBotName(): ?string
    {
        return $this->botName;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function getParseMode(): ParseModeEnum
    {
        return $this->parseMode;
    }

    public function getChatId(): int|string|null
    {
        return $this->chatId;
    }

    public function getActionUrl(): ?string
    {
        return $this->actionUrl;
    }

    public function getActionText(): ?string
    {
        return $this->actionText;
    }

    public function getKeyboard(): ?array
    {
        return $this->keyboard;
    }
}
