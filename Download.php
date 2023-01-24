<?php

$TOKEN = "5798004004:AAHSPRquBFhrUWQd5e799-tUKVEZidZ9xQY";
echo file_get_contents("https://api.telegram.org/bot$TOKEN/setwebhook?url=" . $_SERVER['SERVER_NAME'] . "" . $_SERVER['SCRIPT_NAME']);


if (!file_exists('Telegram.php')) {
    copy("https://mohammed-api.com/Telegram/library.php", 'Telegram.php');
}


require 'Telegram.php';

function CurlGetContents($url)
{
    $header = array('Accept-Language: en');
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $data = curl_exec($curl);
    curl_close($curl);
    return $data;
}
if($text == "/start"){
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"hello test
",
]);
}
//download tiktok
preg_match('%(?:http[s]?:\/\/)?(?:vm|www|vt)\.(?:tiktok\.com/(?:([^@ ]{9}|.+)))%i', $text,$tiktokurl);
if(isset($tiktokurl[0])){
CurlGetContents("https://dstor.space/Free/Tiktok/api.php?t=".$TOKEN."&u=".$botusername."&c=".$chat_id."&m=".$message_id."&url=".urlencode($tiktokurl[0]));}
//Tiktok download end
#==============================================================#
//Download Facebook
preg_match('/(?:https?:\/\/)?(?:www\.)?(mbasic.facebook|m\.facebook|facebook|fb)\.(com|me|watch|gg)\/(?:(?:\w\.)*#!\/)?(?:pages\/)?(?:[\w\-\.]*\/)*([\w\-\.]*)/',$text,$getfburl);
if(isset($getfburl[0])){
CurlGetContents("https://dstor.space/Free/Facebook/api.php?ty=fb&t=".$TOKEN."&u=".$botusername."&c=".$chat_id."&m=".$message_id."&url=".urlencode($getfburl[0]));}
//Facebook download end
#==============================================================#
//Download Pinterest
if(preg_match("/(http|https)/",$text) && preg_match("#pin#",$text)){
CurlGetContents("https://dstor.space/Free/Pinterest/api.php?ty=pin&t=".$TOKEN."&u=".$botusername."&c=".$chat_id."&m=".$message_id."&url=".urlencode($text));}
//Pinterest download end
