<?php


function x_deux_ip($ip){
$ch3 = curl_init();
curl_setopt ($ch3, CURLOPT_URL, 'https://json.geoiplookup.io/'.$ip.'');
curl_setopt ($ch3, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt ($ch3, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
//Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.64 Safari/537.31
curl_setopt ($ch3, CURLOPT_TIMEOUT, 1000);
curl_setopt($ch3, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt ($ch3, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt ($ch3, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($ch3);

$exp = explode('"country_name": "', $result);
$exp1 = explode('",', $exp[1]);
return $exp1[0];

}



?>
