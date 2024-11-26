<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Classes\TelegramMessage;
use Illuminate\Support\Facades\Log;

class TelegramNotificationService
{
    protected $botToken;
    protected $chatId;

    public function __construct()
    {
        $this->botToken = env('TELEGRAM_BOT_TOKEN');
        $this->chatId = env('TELEGRAM_CHAT_ID');
    }

    public function sendMessage(TelegramMessage $telegramMessageObj, $parseMode = 'HTML')
    {
        $client = new Client();
        $url = "https://api.telegram.org/bot{$this->botToken}/sendMessage";

        try {
            $client->post($url, [
                'form_params' => [
                    'chat_id' => $this->chatId,
                    'text' => TelegramNotificationService::messageTemplate($telegramMessageObj),
                    'parse_mode' => $parseMode
                ],
            ]);
        } catch (\Exception $e) {
            Log::error("Telegram Notification Error: " . $e->getMessage());
        }
    }

    private function messageTemplate(TelegramMessage $telegramMessageObj): string
    {
        return "Type: <b>{$telegramMessageObj->type}</b>\nLabel: <b>{$telegramMessageObj->label}</b>\nAction: <b>{$telegramMessageObj->action}</b>\nBy: <b>{$telegramMessageObj->by}</b>";
    }
}