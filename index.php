<?php

require_once "vendor/autoload.php";

$token = "749615950:AAHdhb8wQo_ykJZBaBc1HzqtwGYdGFLwLpE";
$bot = new \TelegramBot\Api\Client($token);

// команда для start
$bot->command("start", function ($message) use ($bot) {
    $answer = "Добро пожаловать! Отправьте ссылку на видео на сайте mover.uz и я отправлю Вам ссылки для скачивания.

Xush kelibsiz! Mover.uz saytidagi videoning manzili yuboring va men Sizga yuklab olish uchun manzil yuboraman.";
    $bot->sendMessage($message->getChat()->getId(), $answer);
});

$bot->command("test", function ($message) use ($bot) {
    $answerr = UR_exists("https://v.mover.uz/tuuBBO8m_s.mp4");
    $bot->sendMessage($message->getChat()->getId(), $answerr);
});

$bot->on(function ($Update) use ($bot) {
    $message = $Update->getMessage();
    $msg_text = $message->getText();
    $link = $msg_text;
    $answer = "";
    if (strpos($link, "mover.uz/watch") === false) {
        $answer = "Неверный адрес";
    } else {
        $link = str_replace("https://", "", $link);
        $link = str_replace("http://", "", $link);
        $link = "https://" . $link;
        $link = str_replace("mover.uz/watch", "v.mover.uz", $link);
        $temp = "";
        for ($i = 0; $i < strlen($link) - 1; $i++) {
            $temp .=  $link[$i];
        }
        $link = $temp;
        
        if (UR_exists($link."_s.mp4") == 1) {
            $answer .= "240p:\n";
            $answer .= $link . "_s.mp4\n\n";
        }
        
        if (UR_exists($link."_m.mp4") == 1) {
            $answer .= "360p:\n";
            $answer .= $link . "_m.mp4\n\n";
        }
        
        if (UR_exists($link."_b.mp4") == 1) {
            $answer .= "480p:\n";
            $answer .= $link . "_b.mp4\n\n";
        }
        
        if (UR_exists($link."_h.mp4") == 1) {
            $answer .= "720p:\n";
            $answer .= $link . "_h.mp4\n\n";
        }
        
    }
    $bot->sendMessage($message->getChat()->getId(), $answer);
    
}, function () { return true; });

function UR_exists($url){
   $headers=get_headers($url);
   $result = stripos($headers[0],"200 OK");
   if($result) {
       return 1;
   }
   return 0;
}

$bot->run()


?>