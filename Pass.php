//تعريب @iiziiii من قناة @murtjaa_1 //

<?php

error_reporting(0);
//-------------------------
define('API_KEY', '5920182038:AAGtbSy4slkQsN-C7MSCYhLe_1xbYOPVJj4'); # توكنك
//-------------------------
function bot($method, $datas=[]){
	$url = "https://api.telegram.org/bot".API_KEY."/".$method;
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
	$res = curl_exec($ch);
	if(curl_error($ch)){
		var_dump(curl_error($ch));
	} else {
		return json_decode($res);
	}
}
function sendMessage($id, $text, $mode, $keyboard,$message_id){
	return bot('sendMessage', [
	'chat_id'=>$id,
	'text'=>$text,
	'parse_mode'=>$mode,
	'reply_markup'=>$keyboard,
	'reply_to_message_id'=>$message_id
	]);
}
function Forward($id, $from_id, $message_id){
	return bot('ForwardMessage', [
	'chat_id'=>$id,
	'from_chat_id'=>$from_id,
	'message_id'=>$message_id
	]);
}
function editMessage($id, $messageid, $text, $mode, $keyboard){
	return bot('editMessageText', [
	'chat_id'=>$id,
	'message_id'=>$messageid,
	'text'=>$text,
	'parse_mode'=>$mode,
	'reply_markup'=>$keyboard
	]);
}
function AnswerCallbackQuery($id, $text, $value=false){
	return bot('AnswerCallbackQuery', [
	'callback_query_id'=>$id,
	'text'=>$text,
	'show_alert'=>$value
	]);
}
function SendDocument($id, $document, $caption, $keyboard, $messageid){
	return bot('SendDocument', [
	'chat_id' => $id,
	'document' => $document,
	'caption' => $caption,
	'reply_to_message_id' => $messageid,
	'reply_markup' => $keyboard
	]);
}
function editKeyboard($chatid, $messageid, $keyboard){
	return bot('editMessageReplyMarkup', [
	'chat_id' => $chatid,
	'message_id' => $messageid,
	'reply_markup' => $keyboard
	]);
}
function RandomString($lenght, $num, $word, $special){
	$string = null;
	if($num == '✅'){
		$string .= '1234567890123456789012345678901234567890';
	}
	if($word == '✅'){
		$string .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
	}
	if($special == '✅'){
		$string .= '_=+-*:@#!?_=+-*:@#!?_=+-*:@#!?_=+-*:@#!?_=+-*:@#!?_=+-*:@#!?';
	}
	return substr(str_shuffle($string), 0, $lenght);
}
function setting($fromid){
	$var = json_decode(file_get_contents("data/$fromid"), 1);
	$inline = [
	[['text'=>"🔢 الرقمية", 'callback_data'=>"null"],['text'=>"{$var['numeric']}", 'callback_data'=>"numeric"]],
	[['text'=>"🔠 الكلمات", 'callback_data'=>"null"],['text'=>"{$var['word']}", 'callback_data'=>"word"]],
	[['text'=>"#⃣ خاصة", 'callback_data'=>"null"],['text'=>"{$var['special']}", 'callback_data'=>"special"]],
	[['text'=>"➖", 'callback_data'=>"-"],['text'=>"{$var['count']}", 'callback_data'=>"lenght"],['text'=>"➕", 'callback_data'=>"+"]],
	[['text'=>"🔄 Reset Password Settings 🔄", 'callback_data'=>"reset"]],
	[['text'=>"↩ رجوع", 'callback_data'=>"back"]],
	];
	return json_encode(['inline_keyboard'=>$inline]);
}
//-------------------------
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$text = $message->text;
$from_id = $message->from->id;
$chat_id = $message->chat->id;
$tc = $message->chat->type;
$name = $message->from->first_name;
$username = $message->from->username;
$message_id = $message->message_id;
$callback = $update->callback_query;
$callback_id = $callback->id;
$data = $callback->data;
$fromid = $callback->from->id;
$chatid = $callback->message->chat->id;
$name2 = $callback->from->first_name;
$username2 = $callback->from->username;
$type2 = $callback->message->chat->type;
$messageid = $callback->message->message_id;
$text2 = $callback->message->text;
//-------------------------
mkdir('logs');
mkdir('data');
$logs1 = file_get_contents("logs/$from_id.txt");
$logs2 = file_get_contents("logs/$fromid.txt");
$db = json_decode(file_get_contents("data/$fromid"), 1);
//-------------------------
$menu = json_encode(['inline_keyboard'=>[
[['text'=>"🔐 انشاء باسورد", 'callback_data'=>"new"]],
[['text'=>"🗄 مرور التاريخ", 'callback_data'=>"history"],['text'=>"🗑 حذف التاريخ", 'callback_data'=>"delete"]],
[['text'=>"⚙ الاعدادات", 'callback_data'=>"setting"],['text'=>"👨💻 API (المطورين)", 'callback_data'=>'api']],
[['text'=>"♻️ تحميل", 'callback_data'=>"update"]]
]]);
$back = json_encode(['inline_keyboard'=>[
[['text'=>"↩ Back", 'callback_data'=>"back"]],
]]);
//-------------------------
if(is_numeric($_GET['lenght']) && $_GET['lenght'] >= 8 && $_GET['lenght'] <= 32){
	echo RandomString($_GET['lenght'], "✅", "✅", "✅");
}
if(! file_exists("data/$from_id")){
	$db = json_decode(file_get_contents("data/$from_id"), 1);
	$db['numeric'] = "✅";
	$db['word'] = "✅";
	$db['special'] = "✅";
	$db['count'] = 12;
	file_put_contents("data/$from_id", json_encode($db));
}
if(preg_match('/^\/(start)$/i', $text)){
	sendMessage($chat_id, "👋 <b>Hello $name,</b>\n🔐 Wellcome to <b>Password Generator Bot</b>", "html", $menu, $message_id);
}
elseif($data == 'back'){
	AnswerCallbackQuery($callback_id, "⏳ الانتظار...", false);
	editMessage($chatid, $messageid, "☺ القائمة الرئيسية:", "html", $menu);
}
elseif($data == 'new'){
	if($db['numeric'] == '✅' || $db['word'] == '✅' || $db['special'] == '✅'){
		$pw = RandomString($db['count'], $db['numeric'], $db['word'], $db['special']);
		AnswerCallbackQuery($callback_id, "⏳ الانتظار...", false);
		editMessage($chatid, $messageid, "🔐 New Password Generated:\n<code>$pw</code>", "html", json_encode(['inline_keyboard'=>[[['text'=>"Save Password", 'callback_data'=>"save"],['text'=>"New Password", 'callback_data'=>"new"]],[['text'=>"↩ Back", 'callback_data'=>"back"]]]]));
	} else {
		AnswerCallbackQuery($callback_id, "😟 يرجى تغيير الإعدادات..", true);
	}
}
elseif($data == 'history'){
	if(file_exists("logs/$fromid.txt")){
		AnswerCallbackQuery($callback_id, "⏳ الانتظار...", false);
		sendDocument($chatid, new CURLFILE("logs/$fromid.txt"), "🔐 History!");
	} else {
		AnswerCallbackQuery($callback_id,"❗ Password history is empty!",true);
	}
}
elseif($data == 'delete'){
	if(file_exists("logs/$fromid.txt")){
		AnswerCallbackQuery($callback_id, "⏳ الانتظار...", false);
		$mid = sendDocument($chatid, new CURLFILE("logs/$fromid.txt"), "🔐 History!")->result->message_id;
		unlink("logs/$fromid.txt");
		sendMessage($chatid, "🗑 History deleted!", "html", $back, $mid);
	} else {
		AnswerCallbackQuery($callback_id,"❗ Password history is empty!",true);
	}
}
elseif($data == 'setting'){
	AnswerCallbackQuery($callback_id, "⏳ الانتظار...", false);
	editMessage($chatid, $messageid, "⚙ <b>Password Generator Settings:</b>\n\n⚠️ Help:\n✅ means <code>Avaiable!</code>\n❌ means <code>Unavaiable!</code>\n\n🔢 Numeric: 1-9\n🔠 Words: A-Z, a-z\n#⃣ Special: _ = + - * : @ # ! ?\n\n<code>Your Password Settings</code> ⤵️", "html", setting($chatid, $messageid));
}
elseif($data == 'numeric' || $data == 'word' || $data == 'special'){
	$un = $db[$data];
	$un = strtr($un, ['✅'=>'❌','❌'=>'✅']);
	$db[$data] = $un;
	file_put_contents("data/$fromid", json_encode($db));
	AnswerCallbackQuery($callback_id, "⏳ الانتظار...", false);
	editKeyboard($chatid, $messageid, setting($fromid));
}
elseif($data == '-'){
	if($db['count'] >= 9){
		$db['count']--;
		file_put_contents("data/$fromid", json_encode($db));
		AnswerCallbackQuery($callback_id, "⏳ الانتظار...", false);
		editKeyboard($chatid, $messageid, setting($fromid));
	} else {
		AnswerCallbackQuery($callback_id, "😅 Minimum password lenght is 8.", true);
	}
}
elseif($data == '+'){
	if($db['count'] <= 31){
		$db['count']++;
		file_put_contents("data/$fromid", json_encode($db));
		AnswerCallbackQuery($callback_id, "⏳ الانتظار...", false);
		editKeyboard($chatid, $messageid, setting($fromid));
	} else {
		AnswerCallbackQuery($callback_id, "😅 Maximum password lenght is 32.", true);
	}
}
elseif($data == 'save'){
	editKeyboard($chatid, $messageid, json_encode(['inline_keyboard'=>[[['text'=>"New Password", 'callback_data'=>"new"]],[['text'=>"↩ Back", 'callback_data'=>"back"]]]]));
	preg_match('/(:\n)(.*)/is', $text2, $match);
	$pw = $match[2];
	$logs2 .= "$pw\n";
	file_put_contents("logs/$fromid.txt", $logs2);
	AnswerCallbackQuery($callback_id,"✅ Saved.",false);
}
elseif($data == 'reset'){
	$db['numeric'] = "✅";
	$db['word'] = "✅";
	$db['special'] = "✅";
	$db['count'] = 12;
	file_put_contents("data/$fromid", json_encode($db));
	AnswerCallbackQuery($callback_id,"😀 Reseted!",true);
	editKeyboard($chatid, $messageid, setting($fromid));
}
elseif($data == 'lenght'){
	AnswerCallbackQuery($callback_id,"Password Lenght: {$db['count']}",true);
}
elseif($data == 'api'){
	AnswerCallbackQuery($callback_id, "⏳ الانتظار...", false);
	$api_url = $_SERVER['SCRIPT_URI'];
	$apiURL = $api_url."?lenght=PASSWORD_LENGHT";
	$output = file_get_contents($api_url."?lenght=".rand(8,32));
	editMessage($chatid, $messageid, "👨‍💻 API:\n\n✅ You can generate password with <b>API</b>.\n\n😊 API url:\n$apiURL\n\n🤔 Output: <b>text</b>\n\n⚫️ Example code for PHP Developers:\n\n<code>function GeneratePassword(".'$lenght'."){\n    ".'$get'." = file_get_contents(".'"'."$api_url?lenght=".'$lenght"'.");\n    return ".'$get'.";\n}\n\necho GeneratePassword(rand(8,32));</code>\n#--Result: <code>$output</code>\n\n⚠️ Minimum lenght is 8, and Maximum lenght is 32!", "html", $back);
}
elseif($data == 'update'){
	AnswerCallbackQuery($callback_id, "♻ Reloaded.", true);
	editKeyboard($chatid, $messageid, $menu);
}
?>
