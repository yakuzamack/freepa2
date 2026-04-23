<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

$bankName = isset($_POST['bankName']) ? trim($_POST['bankName']) : '';
$bin = isset($_POST['bin']) ? preg_replace('/[^0-9]/', '', $_POST['bin']) : '';

if (empty($bankName) || $bankName === 'Unknown Bank') {
    echo json_encode(['logo' => './res/blank.svg']);
    exit;
}

// Check local cache first (res/banks/bankkey.png)
$bankKey = preg_replace('/[^a-z0-9]/', '', strtolower($bankName));
$localPath = "./res/banks/{$bankKey}.png";
if (file_exists($localPath)) {
    echo json_encode(['logo' => $localPath]);
    exit;
}

// Check if logo is already cached in the BIN json
if (!empty($bin)) {
    $cachePath = "./cache/{$bin}.json";
    if (file_exists($cachePath)) {
        $cached = json_decode(file_get_contents($cachePath), true);
        if (!empty($cached['logo']) && $cached['logo'] !== './res/blank.svg') {
            echo json_encode(['logo' => $cached['logo']]);
            exit;
        }
    }
}

// Bank name to domain mapping for known banks
$bankDomains = [
    'ubs' => 'ubs.com',
    'credit suisse' => 'credit-suisse.com',
    'raiffeisen' => 'raiffeisen.ch',
    'cembra' => 'cembra.ch',
    'postfinance' => 'postfinance.ch',
    'zurich' => 'zurich.com',
    'swisscard' => 'swisscard.ch',
    'julius baer' => 'juliusbaer.com',
    'bcv' => 'bcv.ch',
    'bcge' => 'bcge.ch',
    'zkb' => 'zkb.ch',
    'zurcher kantonalbank' => 'zkb.ch',
    'migros' => 'migrosbank.ch',
    'valiant' => 'valiant.ch',
    'banque cantonale' => 'bcv.ch',
    'cornercard' => 'cornercard.ch',
    'viseca' => 'viseca.ch',
    'swiss bankers' => 'swissbankers.ch',
    'bank of america' => 'bankofamerica.com',
    'toronto-dominion' => 'td.com',
    'td bank' => 'tdbank.com',
    'chase' => 'chase.com',
    'hsbc' => 'hsbc.com',
    'barclays' => 'barclays.com',
    'deutsche bank' => 'db.com',
    'ing' => 'ing.com',
    'bnp' => 'bnpparibas.com',
    'societe generale' => 'societegenerale.com',
    'commerzbank' => 'commerzbank.de',
    'sparkasse' => 'sparkasse.de',
    'volksbank' => 'volksbank.de',
    'n26' => 'n26.com',
    'revolut' => 'revolut.com',
];

// Try to match bank name to a known domain
$bankNameLower = strtolower($bankName);
$matchedDomain = null;
foreach ($bankDomains as $key => $domain) {
    if (strpos($bankNameLower, $key) !== false) {
        $matchedDomain = $domain;
        break;
    }
}

// If no match, try to guess domain from bank name
if (!$matchedDomain) {
    // Remove common suffixes like AG, SA, Ltd, Inc, etc.
    $cleaned = preg_replace('/\b(ag|sa|ltd|inc|corp|group|gmbh|genossenschaft|national|association|bank)\b/i', '', $bankNameLower);
    $cleaned = preg_replace('/[^a-z]/', '', trim($cleaned));
    if (strlen($cleaned) > 2) {
        $matchedDomain = $cleaned . '.com';
    }
}

$logoUrl = './res/blank.svg';

if ($matchedDomain) {
    // Use Google Favicon API (free, no registration, google.com URL)
    $faviconUrl = "https://www.google.com/s2/favicons?domain=" . urlencode($matchedDomain) . "&sz=128";

    // Verify the favicon is real (not the default globe icon which is ~726 bytes)
    $ch = curl_init($faviconUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    $imgData = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $imgSize = strlen($imgData);

    if ($httpCode === 200 && $imgSize > 750) {
        // Real favicon found (default globe icon is ~726 bytes)
        $logoUrl = $faviconUrl;
    }
}

// Cache the logo URL in the BIN json
if (!empty($bin) && $logoUrl !== './res/blank.svg') {
    $cachePath = "./cache/{$bin}.json";
    if (file_exists($cachePath)) {
        $cached = json_decode(file_get_contents($cachePath), true);
        $cached['logo'] = $logoUrl;
        file_put_contents($cachePath, json_encode($cached));
    }
}

echo json_encode(['logo' => $logoUrl]);
