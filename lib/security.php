<?php
print PHP_EOL . '<!-- BEGIN include security -->' . PHP_EOL;
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// performs a simple security check to see if our page has submitted the form to itself
function securityCheck($myFormURL = ""){
    $debugThis = true; // you have to specifically want to test this
    
    $status = true; // start off thinking everything is ok
    
    // when it is a form page check to make sure everything is good until a test fails
    if ($myFormURL != "") {
        $fromPage = htmlentities($_SERVER['HTTP_REFERER'], ENT_QUOTES, 'UTF-8');
        
        // remove http or https
        $fromPage = preg_replace('#^https?:#', '', $fromPage);
        
        if ($debugThis) {
            print '<p class="container">From: ' . trim($fromPage) . ' should match your Url: ' . trim($myFormURL);
        }

        if ($fromPage != $myFormURL) {
            $status = false;
        }
    }

    return $status;
}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// Google reCATPCHA
function reCaptcha($recaptcha) {
    $secret = RECAPTCHA_SECRET_KEY;
    $postvars = array("secret"=>$secret, "response"=>$recaptcha);
    $url = "https://www.google.com/recaptcha/api/siteverify";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
    $data = curl_exec($ch);
    curl_close($ch);
    print $data;
    return json_decode($data, true);
}
print PHP_EOL . '<!-- End include security -->' . PHP_EOL;
?>
