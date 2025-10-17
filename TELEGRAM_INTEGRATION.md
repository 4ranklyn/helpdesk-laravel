# Telegram Integration Setup Guide

This document provides a step-by-step guide to setting up the Telegram integration for receiving notifications about new tickets.

## 1. Create a Telegram Bot

1.  Open Telegram and search for the `@BotFather` bot.
2.  Start a chat with BotFather and use the `/newbot` command to create a new bot.
3.  Follow the instructions to choose a name and username for your bot.
4.  BotFather will provide you with a unique bot token. Copy this token and keep it safe.

## 2. Configure the Laravel Application

1.  Open the `.env` file in the root of your Laravel project.
2.  Add the following line to the end of the file, replacing `YOUR_BOT_TOKEN` with the token you received from BotFather:

    ```
    TELEGRAM_BOT_TOKEN=YOUR_BOT_TOKEN
    ```

## 3. Set Up the Webhook

1.  The application uses a webhook to receive updates from Telegram. The webhook URL is `https://your-domain.com/api/telegram/webhook`.
2.  You need to register this URL with Telegram by sending a request to the following URL, replacing `YOUR_BOT_TOKEN` and `YOUR_WEBHOOK_URL` with your actual bot token and webhook URL:

    ```
    https://api.telegram.org/bot<YOUR_BOT_TOKEN>/setWebhook?url=<YOUR_WEBHOOK_URL>
    ```

    For example:

    ```
    https://api.telegram.org/bot123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11/setWebhook?url=https://sistemkmm.rs.uns.ac.id/api/telegram/webhook
    ```

3.  You can do this by pasting the URL into your browser or using a tool like cURL.

## 4. Add the Bot to Your Groups

1.  Add the bot to the Telegram groups that correspond to the units in your application.
2.  Make sure that the group names in Telegram exactly match the unit names in the application. For example, if you have a unit named "IT Support", the Telegram group should also be named "IT Support".
3.  The bot will automatically detect when it has been added to a group and will save the group's `chat_id` to the corresponding unit in the database.

## 5. User Registration

1.  Users need to add their Telegram username and user ID to their profile in the web application.
2.  The application will use this information to mention the correct user when a new ticket is assigned to them.
3.  Users can get their user ID by sending the `/start` command to the `@userinfobot` bot on Telegram.

Once these steps are completed, the integration is ready. When a new ticket is created, a notification will be sent to the corresponding Telegram group, and the responsible user will be mentioned in the message.
