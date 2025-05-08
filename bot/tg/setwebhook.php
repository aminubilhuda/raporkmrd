<?php
include 'config.php';
// $webHookUrl = "https://bot.abdinegara.com/index.php";
$webHookUrl = "https://25f0-125-164-4-187.ngrok-free.app/raporkm/bot/sendmessage.php";
$apiUrl = "https://api.telegram.org/bot{$BOT_TOKEN}/setWebhook?url={$webHookUrl}";
$response = file_get_contents($apiUrl);
echo $response;