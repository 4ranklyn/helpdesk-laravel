<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TelegramService
{
    protected $botToken;
    protected $apiUrl;

    public function __construct()
    {
        $this->botToken = config('telegram.bot_token');
        $this->apiUrl = 'https://api.telegram.org/bot' . $this->botToken;
    }

    /**
     * Send a message to a specific chat ID.
     *
     * @param int $chatId The ID of the group (negative) or user (positive).
     * @param string $text The message text.
     * @param string|null $parseMode 'MarkdownV2' or 'HTML'.
     * @return \Illuminate\Http\Client\Response
     */
    public function sendMessage(int $chatId, string $text, ?string $parseMode = 'MarkdownV2')
    {
        return Http::post($this->apiUrl . '/sendMessage', [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => $parseMode,
        ]);
    }

    /**
     * Escape special characters for MarkdownV2.
     *
     * @param string $text
     * @return string
     */
    public static function escapeMarkdown(string $text): string
    {
        $charactersToEscape = ['_', '*', '[', ']', '(', ')', '~', '`', '>', '#', '+', '-', '=', '|', '{', '}', '.', '!'];
        foreach ($charactersToEscape as $char) {
            $text = str_replace($char, '\\' . $char, $text);
        }
        return $text;
    }
}
