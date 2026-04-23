<?php

function x_deux_check_mail($site3) {
    $ch3 = curl_init();

    // Set the URL for the request
    curl_setopt($ch3, CURLOPT_URL, $site3);

    // Enable SSL certificate verification
    curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch3, CURLOPT_SSL_VERIFYHOST, 2); // Ensure the certificate matches the host

    // Set the User-Agent to impersonate a browser (keeping it realistic)
    curl_setopt($ch3, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36");

    // Set a reasonable timeout (e.g., 30 seconds)
    curl_setopt($ch3, CURLOPT_TIMEOUT, 30);

    // Allow following redirects
    curl_setopt($ch3, CURLOPT_FOLLOWLOCATION, true);

    // Return the response as a string instead of outputting directly
    curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);

// Store cookies in a file for session persistence (use __DIR__ for absolute path)
    curl_setopt($ch3, CURLOPT_COOKIEJAR, __DIR__ . '/cookie12.txt');
    curl_setopt($ch3, CURLOPT_COOKIEFILE, __DIR__ . '/cookie12.txt');

    // Set the Referer header to the same site URL
    curl_setopt($ch3, CURLOPT_REFERER, $site3);

    // Execute the request
    $response = curl_exec($ch3);

    // Error handling in case the cURL request fails
    if(curl_errno($ch3)) {
        $error_msg = curl_error($ch3);
        // Log the error message (can be used for debugging)
        error_log("cURL Error: " . $error_msg);
        // Optionally, you can return a custom error message or handle it differently
        return "Error: Unable to retrieve the content.";
    }

    // Close the cURL session
    curl_close($ch3);

    // Return the response (HTML content or error message)
    return $response;
}

// Example usage: Fetch content from the given URL
$content = x_deux_check_mail('https://www.scalini-dubai.com');

// Output the result (HTML content or error message)
echo $content;

exit();
