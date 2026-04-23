<?php


/*
$allowed_countries = ['Australia', 'New Zealand'];
if (!in_array(x_deux_ip(getenv('REMOTE_ADDR')), $allowed_countries)) {
    include './verifen/popular.php';
    exit();
}
*/

function x_deux_isp($ipp){
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://pro.ip-api.com/json/' . $ipp . '?fields=66842623&key=ipapiq9SFY1Ic4');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:142.0) Gecko/20100101 Firefox/142.0',
        'Accept: */*',
        'Accept-Language: en-US,en;q=0.5',
        'Referer: https://members.ip-api.com/',
        'Origin: https://members.ip-api.com',
        'Connection: keep-alive',
        'DNT: 1',
        'Pragma: no-cache',
        'Cache-Control: no-cache',
    ]);

    $result = curl_exec($ch);
    curl_close($ch);

    // If the request failed, treat as proxy to block
    if (!$result) {
        return ['ISP' => '', 'PROXY' => 'TRUE'];
    }

    $data = json_decode($result, true);

    // If JSON is invalid or API returned error, treat as proxy to block
    if (!$data || !isset($data['status']) || $data['status'] !== 'success') {
        return ['ISP' => '', 'PROXY' => 'TRUE'];
    }

    $isp  = isset($data['isp']) ? $data['isp'] : '';
    $prox = !empty($data['proxy']) ? 'TRUE' : 'FALSE';

    return ['ISP' => $isp, 'PROXY' => $prox];
}

	?>
