<?php

namespace DarkDarin\TelegramNotification;

use DarkDarin\TelegramBotSdk\DTO\InlineKeyboardButton;
use DarkDarin\TelegramBotSdk\DTO\InlineKeyboardMarkup;
use DarkDarin\TelegramBotSdk\Telegram;
use Illuminate\Notifications\Notification;

readonly class TelegramChannel
{
    public function __construct(private Telegram $telegram) {}

    public function send(object $notifiable, Notification $notification): void
    {
        if (!method_exists($notification, 'toTelegram')) {
            return;
        }

        $message = $notification->toTelegram($notifiable);
        if (is_string($message)) {
            $message = TelegramMessage::create($message);
        }

        if (!$message instanceof TelegramMessage || $message->getChatId() === null) {
            return;
        }

        $markup = null;
        if ($message->getActionUrl() !== null) {
            $keyboard = [
                [
                    new InlineKeyboardButton(text: $message->getActionText(), url:  $message->getActionUrl())
                ]
            ];

            $markup = new InlineKeyboardMarkup($keyboard);
        }

        $this->telegram->bot($message->getBotName())
            ->sendMessage(
                chat_id:      $message->getChatId(),
                text:         $message->getText(),
                parse_mode:   $message->getParseMode(),
                reply_markup: $markup,
            );
    }
}
