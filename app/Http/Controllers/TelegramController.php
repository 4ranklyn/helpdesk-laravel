<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TelegramController extends Controller
{
    /**
     * Handle incoming Telegram updates.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function webhook(Request $request)
    {
        $update = $request->all();

        // Log the entire update for debugging purposes
        Log::info('Telegram webhook update received:', $update);

        if (isset($update['my_chat_member'])) {
            $chatMember = $update['my_chat_member'];
            $chat = $chatMember['chat'];

            if ($chat['type'] === 'group' || $chat['type'] === 'supergroup') {
                $newStatus = $chatMember['new_chat_member']['status'];

                if ($newStatus === 'member' || $newStatus === 'administrator') {
                    $this->handleBotAddedToGroup($chat);
                }
            }
        }

        return response()->json(['status' => 'ok']);
    }

    /**
     * Handle the event when the bot is added to a group.
     *
     * @param array $chat
     * @return void
     */
    protected function handleBotAddedToGroup(array $chat)
    {
        $groupId = $chat['id'];
        $groupTitle = $chat['title'];

        // Try to find a unit with a matching name
        $unit = Unit::where('name', $groupTitle)->first();

        if ($unit) {
            $unit->telegram_group_id = $groupId;
            $unit->save();
            Log::info("Associated group '{$groupTitle}' (ID: {$groupId}) with unit '{$unit->name}'.");
        } else {
            Log::warning("A bot was added to group '{$groupTitle}' (ID: {$groupId}), but no matching unit was found.");
        }
    }
}
