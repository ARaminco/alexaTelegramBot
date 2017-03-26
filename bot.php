<?php

$basedata 		= file_get_contents("php://input");
$data 		= json_decode(file_get_contents("php://input"), true);
$botapi = "275868918:AAEyC_Imz8r8nbIOxQD3Kt7mSUF80x7AxUk";
$botid= "0";
$adminID = "71595348";
//$shamsidate = jstrftime('%H:%M:%S | %A, %e / %B / %Y');


var_dump($data);
$cid = $data ["message"]["chat"]["id"];
$uid = $data ["message"]["from"]["id"];
$inText = $data["message"]["text"];
$fname = $data["message"]["from"]["first_name"];
$photo = $data["message"]["photo"]["0"]["file_id"];
$video = $data["message"]["video"]["file_id"];
$sticker = $data["message"]["sticker"]["file_id"];
$doc = $data["message"]["document"]["file_id"];
$uname = $data["message"]["from"]["username"];
$fname = $data["message"]["from"]["first_name"];
$lname = $data["message"]["from"]["last_name"];
$reply = $data["message"]["reply_to_message"]["text"];
$callback = $data ["callback_query"]["data"];

if($callback != ""){
	$cid = $data ["callback_query"]["from"]["id"];
    $uid = $cid;
	//$text = "$basedata";
	//$sendM = sendMessage($cid, $text, $botapi ,$encodedMarkup);
	
}



function sendMessage($cid, $text, $botapi ,$encodedMarkup) {
	$text = urlencode($text);
	$curl = curl_init("https://api.telegram.org/bot$botapi/sendMessage");
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, "chat_id=$cid&text=$text&reply_markup=$encodedMarkup&parse_mode=HTML");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	$result = curl_exec($curl);
	curl_close($curl);
	//echo $result ;
	return $result;
	}
function sendPhoto($cid, $photo, $botapi ,$caption ,$encodedMarkup) {
	$caption = urlencode($caption);
	$curl = curl_init("https://api.telegram.org/bot$botapi/sendPhoto");
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, "chat_id=$cid&photo=$photo&caption=$caption&reply_markup=$encodedMarkup");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	$result = curl_exec($curl);
	curl_close($curl);
	return $result;
	}
function sendDocument($cid, $doc, $botapi ,$caption) {
	$curl = curl_init("https://api.telegram.org/bot$botapi/sendDocument");
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, "chat_id=$cid&document=$text");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	$result = curl_exec($curl);
	curl_close($curl);
	return $result;
	}
function chekAlexaRank ($domain){
    $sWebSite=$domain;
    if($source = simplexml_load_file('http://data.alexa.com/data?cli=10&url='.$sWebSite)){

        if($source->SD->COUNTRY['RANK']){
            $country    = $source->SD->COUNTRY['RANK'];
            $country_name = $source->SD->COUNTRY['NAME'];
        }else{
            $country='Not Available';
        }
        if($source->SD->POPULARITY['TEXT']){
            $popularity     = $source->SD->POPULARITY['TEXT'];
        }else{
            $popularity='Not Available';
        }
        if($source->SD->REACH['RANK']){
            $reach=$source->SD->REACH['RANK'];
        }else{
            $reach='Not Available';
        }
    }else{
        $country='Not Available';
        $popularity='Not Available';
        $reach='Not Available';
    }

    //echo "<div class='text-center'>";
    //echo $country_name .' Rank : '.$country .'<br>';
    //echo ' Alexa Traffic Rank :' . $reach;
    //echo "</div>";
	$output = "
	📡 سایت : $domain
	
	
	✅ نتیجه : 
	
	📊 رتبه جهانی الکسا : $reach
	
	🌎 کشور : $country_name
	📊 رتبه در کشور : $country
	
	ربات برسی الکسا : @alexaTelegramBot
	";
	return $output ;
}






if($inText=="/start"){
	$text = "
	به ربات الکسا خوش آمدید !
	برای برسی الکسای سایت خود کافیست در هر زمان آدرس دامنه سایت خود را به صورت زیر برای ربات ارسال کنید !
	مثال : aliasgharramin.ir
	
	کاری از علی اصغر رامین 
	@aliasgharraminch
	@aliasghar_ramin
	
	";
	$sendM = sendMessage($cid, $text, $botapi ,$encodedMarkup);
}else{
	$photo = "http://www.marka-marka.org/wp-content/uploads/alexa.png";
	$caption = chekAlexaRank ($inText);
	
	
	$sendP = sendPhoto($cid, $photo, $botapi ,$caption ,$encodedMarkup) ;
}
?>


