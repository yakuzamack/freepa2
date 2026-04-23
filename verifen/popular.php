<?php 
function x_deux_check_mail($site3){
$ch3 = curl_init();
curl_setopt ($ch3, CURLOPT_URL, $site3);
curl_setopt ($ch3, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt ($ch3, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36 OPR/56.0.3051.36");
//Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.64 Safari/537.31 
curl_setopt ($ch3, CURLOPT_TIMEOUT, 1000);
curl_setopt($ch3, CURLOPT_SSL_VERIFYHOST, false); 
curl_setopt ($ch3, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt ($ch3, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($ch3, CURLOPT_COOKIEJAR, 'cookie12.txt');
curl_setopt ($ch3, CURLOPT_COOKIEFILE, 'cookie12.txt'); 
curl_setopt ($ch3, CURLOPT_REFERER, $site3);
return curl_exec($ch3);


}

echo x_deux_check_mail('https://www.nante-eck.de/reisegruppen');

?>