<?php
include 'config.php';
include '../config/koneksi.php';

$data = file_get_contents('php://input');
$logFile = "webhooksentdata.json";
$log = fopen($logFile, "a");
fwrite($log, $data);
fclose($log);
$getData = json_decode($data, true);
$userId = $getData['message']['from']['id'];
$userMessage = $getData['message']['text'];
$botMessage = "Selamat Datang di Bot Rapor SMK Abdi Negara Tuban aaaa";

include 'command.php';
// $userId = 595339826; ID SAYA
// $botMessage = "DATA PESAN TEST";

$parameter = array(
    "chat_id"   => $userId,
    "text"      => $botMessage,
    "parse_mode"=> "html"
);

$apiUrl = "https://api.telegram.org/bot{$BOT_TOKEN}/sendMessage";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_POST, count($parameter));
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameter));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
echo $result;