<?php

echo "This file BY >> coder-iq <br>";

$API_KEY = 'AAEXDKU7qCrEG0hiLVqowWjwUu1K6V6gBdo'; // توكن
echo "https://api.telegram.org/bot$API_KEY/setwebhook?url=".$_SERVER['SERVER_NAME']."".$_SERVER['SCRIPT_NAME']; 

define('API_KEY',$API_KEY);
function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
$admin = 1109412636; /*ايدي المطور*/
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$from_id = $message->from->id;
$chat_id = $message->chat->id;
$text = $message->text;
$data = $update->callback_query->data;
$message_id = $update->callback_query->message->message_id;
$chat_id2 = $update->callback_query->message->chat->id;
$us = explode("\n", file_get_contents("us.txt"));

if ($message and !in_array($chat_id, $us)) {
    file_put_contents("us.txt", "\n".$chat_id,FILE_APPEND);
}
if ($text == '/us') {
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>count($us)
    ]);
}
if ($text == '/start') {
    mkdir('photos');
  bot('sendMessage',[
    'chat_id'=>$chat_id,
    'text'=>'- بەخێربێتٮ بۆ بۆتی فۆتۆشۆپٮ📷؛
• تەنها وێنەکەت بنێرە و شێوازێ هەڵبژێرە ❤

- تێبینی * 📩 : ئێمە هیچ وێنەک لای خۆمان سێڤن ناکەین ، دوای تەواو بوونی ئەم مانگە دەسڕدرێتەوە  📌 

•  خوارەوە لە ژێر گەشەسەندندایە و زۆر کەس زیاد دەکرێت
فیلتەر و ئامێرەکان  ⚡️',
    'reply_markup'=>json_encode([
      'inline_keyboard'=>[
        [['text'=>'• کەناڵی ئێمە 💭 -','url'=>'t.me/eso_hawlery']]
      ]
    ])
  ]);
}
if($message->sticker){
    $path = bot('getfile',['file_id'=>$message->sticker->file_id])->result->file_path;
    file_put_contents("photos/$chat_id.jpg", file_get_contents('https://api.telegram.org/file/bot'.$API_KEY.'/'.$path));
    bot('sendphoto',[
        'chat_id'=>$chat_id,
        'text'=>new CURLFile("photos/$chat_id.jpg")
        ]);
}
if($message->photo){
    $path = bot('getfile',['file_id'=>$message->photo[2]->file_id])->result->file_path;
    mkdir('photos');
    file_put_contents("photos/$chat_id.jpg", file_get_contents('https://api.telegram.org/file/bot'.$API_KEY.'/'.$path));
    bot('sendphoto',[
        'chat_id'=>$chat_id,
        'photo'=>new CURLFile("photos/$chat_id.jpg"),
        'caption'=>'By : ESO WORK ',
        'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                [['text'=>'- توسيط عامودي ⤴️','callback_data'=>'twV'],['text'=>'- توسيط افقي ↩️','callback_data'=>'twH']],
                [['text'=>'• الفلاتر 💎؛','callback_data'=>'filters']],
                [['text'=>'تدوير يمين ➡️ ','callback_data'=>'roR'],['text'=>'تدوير يسار ⬅️ ','callback_data'=>'roL']],
            ]
        ])
        ]);
}
if ($data == 'twV') {
    $data = getimagesize("photos/$chat_id2.jpg");
    $dest = imagecreatefromjpeg("photos/$chat_id2.jpg");
  $src = imagecreatetruecolor($data[0] ,$data[1] + 250);
    imagefill($src, 0, 0, imagecolorallocate($src,255,255,255));
    imagecopy($src, $dest, 0, 125, 0, 0 ,$data[0] , $data[1]);
    imagejpeg($src,"photos/$chat_id2.jpg");
    imagedestroy($src);
    imagedestroy($dest);
    bot('sendphoto',[
        'chat_id'=>$chat_id2,
        'photo'=>new CURLFile("photos/$chat_id2.jpg"),
        'caption'=>'By : ESO HAWLERY ',
        'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                [['text'=>'- توسيط عامودي ⤴️','callback_data'=>'twV'],['text'=>'- توسيط افقي ↩️','callback_data'=>'twH']],
                [['text'=>'• الفلاتر 💎؛','callback_data'=>'filters']],
                [['text'=>'تدوير يمين ➡️ ','callback_data'=>'roR'],['text'=>'تدوير يسار ⬅️ ','callback_data'=>'roL']],
            ]
        ])
        ]);
        bot('deleteMessage',['chat_id'=>$chat_id2,'message_id'=>$message_id]);
}
if ($data == 'twH') {
    $data = getimagesize("photos/$chat_id2.jpg");
    $dest = imagecreatefromjpeg("photos/$chat_id2.jpg");
  $src = imagecreatetruecolor($data[0] + 250,$data[1]);
  imagefill($src, 0, 0, imagecolorallocate($src,255,255,255));
  imagecopy($src, $dest, 125, 0, 0, 0 ,$data[0] , $data[1]);
  imagejpeg($src,"photos/$chat_id2.jpg");
  imagedestroy($src);
  imagedestroy($dest);
    bot('sendphoto',[
        'chat_id'=>$chat_id2,
        'photo'=>new CURLFile("photos/$chat_id2.jpg"),
        'caption'=>'By : Eso work ',
        'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                [['text'=>'- توسيط عامودي ⤴️','callback_data'=>'twV'],['text'=>'- توسيط افقي ↩️','callback_data'=>'twH']],
                [['text'=>'• الفلاتر 💎؛','callback_data'=>'filters']],
                [['text'=>'تدوير يمين ➡️ ','callback_data'=>'roR'],['text'=>'تدوير يسار ⬅️ ','callback_data'=>'roL']],
            ]
        ])
        ]);
        bot('deleteMessage',['chat_id'=>$chat_id2,'message_id'=>$message_id]);
}
if($data == 'gray'){
     $im = imagecreatefromjpeg("photos/$chat_id2.jpg");
    imagefilter($im, IMG_FILTER_GRAYSCALE);
    imagejpeg($im,"photos/$chat_id2.jpg");
    
    bot('sendphoto',[
        'chat_id'=>$chat_id2,
        'photo'=>new CURLFile("photos/$chat_id2.jpg"),
        'caption'=>'By : eso work ',
        'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                [['text'=>'- توسيط عامودي ⤴️','callback_data'=>'twV'],['text'=>'- توسيط افقي ↩️','callback_data'=>'twH']],
                [['text'=>'• الفلاتر 💎؛','callback_data'=>'filters']],
                [['text'=>'تدوير يمين ➡️ ','callback_data'=>'roR'],['text'=>'تدوير يسار ⬅️ ','callback_data'=>'roL']],
            ]
        ])
        ]);
        bot('deleteMessage',['chat_id'=>$chat_id2,'message_id'=>$message_id]);
}
if ($data == 'roR') {
    $source = imagecreatefromjpeg("photos/$chat_id2.jpg");
$rotate = imagerotate($source, -90, 0);
imagejpeg($rotate,"photos/$chat_id2.jpg");
    bot('sendphoto',[
        'chat_id'=>$chat_id2,
        'photo'=>new CURLFile("photos/$chat_id2.jpg"),
        'caption'=>'By :♕︎𝐄𝐬𝐨 𝐰𝐨𝐫𝐤♕︎ ',
        'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                [['text'=>'- توسيط عامودي ⤴️','callback_data'=>'twV'],['text'=>'- توسيط افقي ↩️','callback_data'=>'twH']],
                [['text'=>'• الفلاتر 💎؛','callback_data'=>'filters']],
                [['text'=>'تدوير يمين ➡️ ','callback_data'=>'roR'],['text'=>'تدوير يسار ⬅️ ','callback_data'=>'roL']],
            ]
        ])
        ]);
        bot('deleteMessage',['chat_id'=>$chat_id2,'message_id'=>$message_id]);
}
if ($data == 'roL') {
$source = imagecreatefromjpeg("photos/$chat_id2.jpg");
$rotate = imagerotate($source, 90, 0);
imagejpeg($rotate,"photos/$chat_id2.jpg");
    bot('sendphoto',[
        'chat_id'=>$chat_id2,
        'photo'=>new CURLFile("photos/$chat_id2.jpg"),
        'caption'=>': یـەکـێتـیمـ😻💚 بـــۆکانیــمـ⁦❤️⁩ ',
        'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                [['text'=>'- توسيط عامودي ⤴️','callback_data'=>'twV'],['text'=>'- توسيط افقي ↩️','callback_data'=>'twH']],
                [['text'=>'• الفلاتر 💎؛','callback_data'=>'filters']],
                [['text'=>'تدوير يمين ➡️ ','callback_data'=>'roR'],['text'=>'تدوير يسار ⬅️ ','callback_data'=>'roL']],
            ]
        ])
        ]);
        bot('deleteMessage',['chat_id'=>$chat_id2,'message_id'=>$message_id]);
}
if ($data == 'fiO') {
    $myImage = imagecreatefromjpeg("photos/$chat_id2.jpg");
  imagefilter($myImage,IMG_FILTER_GRAYSCALE);
  imagefilter($myImage,IMG_FILTER_BRIGHTNESS,-30);
  imagefilter($myImage,IMG_FILTER_COLORIZE, 90, 55, 30);  
  header("Content-type: image/jpeg");
  imagejpeg($myImage,"photos/$chat_id2.jpg");
  imagedestroy( $myImage );
    bot('sendphoto',[
        'chat_id'=>$chat_id2,
        'photo'=>new CURLFile("photos/$chat_id2.jpg"),
        'caption'=>'By :
(★سەرۆڪ یوسف بلاڪ ڕوسی★) ',
        'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                [['text'=>'- توسيط عامودي ⤴️','callback_data'=>'twV'],['text'=>'- توسيط افقي ↩️','callback_data'=>'twH']],
                [['text'=>'• الفلاتر 💎؛','callback_data'=>'filters']],
                [['text'=>'تدوير يمين ➡️ ','callback_data'=>'roR'],['text'=>'تدوير يسار ⬅️ ','callback_data'=>'roL']],
            ]
        ])
        ]);
        bot('deleteMessage',['chat_id'=>$chat_id2,'message_id'=>$message_id]);
}
if ($data == 'fiB') {
    file_put_contents("photos/$chat_id2.jpg", file_get_contents("http://powerful.elithost.ga/photoeffect/?filter=frozen&url=https://".$_SERVER['SERVER_NAME']."/p/photos/$chat_id2.jpg"));
    bot('sendphoto',[
        'chat_id'=>$chat_id2,
        'photo'=>new CURLFile("photos/$chat_id2.jpg"),
        'caption'=>' ',
        'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                [['text'=>'- توسيط عامودي ⤴️','callback_data'=>'twV'],['text'=>'- توسيط افقي ↩️','callback_data'=>'twH']],
                [['text'=>'• الفلاتر 💎؛','callback_data'=>'filters']],
                [['text'=>'تدوير يمين ➡️ ','callback_data'=>'roR'],['text'=>'تدوير يسار ⬅️ ','callback_data'=>'roL']],
            ]
        ])
        ]);
        bot('deleteMessage',['chat_id'=>$chat_id2,'message_id'=>$message_id]);
}
if ($data == 'fiL') {
    file_put_contents("photos/$chat_id2.jpg", file_get_contents("http://powerful.elithost.ga/photoeffect/?filter=antique&url=https://".$_SERVER['SERVER_NAME']."/p/photos/$chat_id2.jpg"));
    bot('sendphoto',[
        'chat_id'=>$chat_id2,
        'photo'=>new CURLFile("photos/$chat_id2.jpg"),
        'caption'=>'By : یوسف هەولێری ',
        'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                [['text'=>'- توسيط عامودي ⤴️','callback_data'=>'twV'],['text'=>'- توسيط افقي ↩️','callback_data'=>'twH']],
                [['text'=>'• الفلاتر 💎؛','callback_data'=>'filters']],
                [['text'=>'تدوير يمين ➡️ ','callback_data'=>'roR'],['text'=>'تدوير يسار ⬅️ ','callback_data'=>'roL']],
            ]
        ])
        ]);
        bot('deleteMessage',['chat_id'=>$chat_id2,'message_id'=>$message_id]);
}
if ($data == 'fiD') {
    file_put_contents("photos/$chat_id2.jpg", file_get_contents("http://powerful.elithost.ga/photoeffect/?filter=blur&url=https://".$_SERVER['SERVER_NAME']."/p/photos/$chat_id2.jpg"));
    bot('sendphoto',[
        'chat_id'=>$chat_id2,
        'photo'=>new CURLFile("photos/$chat_id2.jpg"),
        'caption'=>'By : eso ',
        'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                [['text'=>'- توسيط عامودي ⤴️','callback_data'=>'twV'],['text'=>'- توسيط افقي ↩️','callback_data'=>'twH']],
                [['text'=>'• الفلاتر 💎؛','callback_data'=>'filters']],
                [['text'=>'تدوير يمين ➡️ ','callback_data'=>'roR'],['text'=>'تدوير يسار ⬅️ ','callback_data'=>'roL']],
            ]
        ])
        ]);
        bot('deleteMessage',['chat_id'=>$chat_id2,'message_id'=>$message_id]);
}
if ($data == 'fiR') {
    file_put_contents("photos/$chat_id2.jpg", file_get_contents("http://powerful.elithost.ga/photoeffect/?filter=hermajesty&url=https://".$_SERVER['SERVER_NAME']."/p/photos/$chat_id2.jpg"));
    bot('sendphoto',[
        'chat_id'=>$chat_id2,
        'photo'=>new CURLFile("photos/$chat_id2.jpg"),
        'hermajestycaption'=>'By : eso',
        'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                [['text'=>'- توسيط عامودي ⤴️','callback_data'=>'twV'],['text'=>'- توسيط افقي ↩️','callback_data'=>'twH']],
                [['text'=>'• الفلاتر 💎؛','callback_data'=>'filters']],
                [['text'=>'تدوير يمين ➡️ ','callback_data'=>'roR'],['text'=>'تدوير يسار ⬅️ ','callback_data'=>'roL']],
            ]
        ])
        ]);
        bot('deleteMessage',['chat_id'=>$chat_id2,'message_id'=>$message_id]);
}
if ($data == 'fiG') {
    file_put_contents("photos/$chat_id2.jpg", file_get_contents("http://powerful.elithost.ga/photoeffect/?filter=everglow&url=https://".$_SERVER['SERVER_NAME']."/p/photos/$chat_id2.jpg"));
    bot('sendphoto',[
        'chat_id'=>$chat_id2,
        'photo'=>new CURLFile("photos/$chat_id2.jpg"),
        'hermajestycaption'=>'By : eso ',
        'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                [['text'=>'- توسيط عامودي ⤴️','callback_data'=>'twV'],['text'=>'- توسيط افقي ↩️','callback_data'=>'twH']],
                [['text'=>'• الفلاتر 💎؛','callback_data'=>'filters']],
                [['text'=>'تدوير يمين ➡️ ','callback_data'=>'roR'],['text'=>'تدوير يسار ⬅️ ','callback_data'=>'roL']],
            ]
        ])
        ]);
        bot('deleteMessage',['chat_id'=>$chat_id2,'message_id'=>$message_id]);
}
if ($data == 'filters') {
    bot('sendphoto',[
        'chat_id'=>$chat_id2,
        'photo'=>new CURLFile("photos/$chat_id2.jpg"),
        'caption'=>'By : eso ',
        'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                [['text'=>'- وێنەی کۆن 🌪 ','callback_data'=>'fiO'],['text'=>'- ڕەش و سپی 📸؛','callback_data'=>'gray']],
                [['text'=>'• ئەرخەوانی💎؛','callback_data'=>'fiB'],['text'=>'•  ڕووناڪی 🔦 -','callback_data'=>'fiL']],
                [['text'=>'- شیرین ✨ ،','callback_data'=>'fiD']],
                [['text'=>'- احمر باهت 🎈 ؛','callback_data'=>'fiR'],['text'=>'- اخضر باهت ❇️ -','callback_data'=>'fiG']],
                [['text'=>'-شین 💙 ،','callback_data'=>'fiD']],
            ]
        ])
        ]);
    bot('deleteMessage',['chat_id'=>$chat_id2,'message_id'=>$message_id]);
}
