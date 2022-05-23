<?php
include ("top.php");

$PIN = "";
$recaptcha = "";
$errorMsg = "";
$res = "";
$tries = $_SESSION['loginAttempts'];

// Check if the user already passed authentication
if ($_SESSION['loggedIn'] == true) {
    header('Location: /assignor.php');
}

if (isset($_GET["btnSubmit"])) {
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // Protect against brute force attack
    // if (!$tries) {
    //     header("HTTP/1.1 429 Too Many Requests");
    //     print '<article style="align-content: center; text-align: center;">';
    //     $errorMsg = "You've exceeded the number of login attempts. We've blocked IP address {$_SERVER['REMOTE_ADDR']} for a few minutes.";
    //     print '<h3>' . $errorMsg . '</h3>';
    //     print '</article>';
    //     $_SESSION['loginAttempts'] = $tries - 2;
    //     exit();
    // }
//    $apc_key = "{$_SERVER['SERVER_NAME']}~login:{$_SERVER['REMOTE_ADDR']}";
//    $apc_blocked_key = "{$_SERVER['SERVER_NAME']}~login-blocked:{$_SERVER['REMOTE_ADDR']}";
//    $tries = (int)apc_fetch($apc_key);

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // Sanitize (clean) data
    $PIN = htmlentities($_GET["pin"], ENT_QUOTES, "UTF-8");
    $recaptcha = htmlentities($_GET["g-recaptcha-response"], ENT_QUOTES, "UTF-8");

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2c Validation
    
    if ($recaptcha == "") {
        $errorMsg = "You must complete reCAPTCHA.";
    } else {
        $res = reCaptcha($recaptcha);
        print $_SERVER['HTTP_CLIENT_IP'] . 'xxxxxxxxxxx';
        print_r($_res);
        if (!($res)){
            header("HTTP/1.1 429 Too Many Requests");
            print '<article style="align-content: center; text-align: center;">';
            $errorMsg = "Google reCAPTCHA thinks you are a robot. We've blocked IP address {$_SERVER['REMOTE_ADDR']} for a few minutes.";
            print '<h3>' . $errorMsg . '</h3>';
            print '</article>';
            exit();
        }
    }

    if (strcmp($PIN, PASSWORD) !== 0) {
        $errorMsg = "The PIN is incorrect, try again.";
    }

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // Process Form - Passed Validation
    
    if ($errorMsg == "") {
        // Set to true to send to pages that require authentication
        $_SESSION['loggedIn'] = true;
        $_SESSION['loginAttempts'] = 0;
        header('Location: /assignor.php');
//        apc_delete($apc_key);
//        apc_delete($apc_blocked_key);
    } else {
        $_SESSION['loggedIn'] = false;
        ++$tries;
        $_SESSION['loginAttempts'] = $tries;
//        $blocked = (int)apc_fetch($apc_blocked_key);
//        $secs = 600;
//        apcu_inc($apc_key, $tries+1, $secs);  # store tries for 10 minutes
//        apc_store($apc_key, $tries + 1, pow(2, $blocked + 1) * 60);  # store tries for 2^(x+1) minutes: 2, 4, 8, 16, ...
//        apc_store($apc_blocked_key, $blocked + 1, 86400);  # store number of times blocked for 24 hours
    }
}
?>
<br>
<br>
<article style="align-content: center; text-align: center;">
    <h2>Enter PIN to view assignor resources.</h2>
    <?php
    //#########################################################################
    //
    // Error Messages
    //
    if ($errorMsg != "") {
    print '<section id="errors">' . PHP_EOL;
        print("&#9888; Error: " . $errorMsg);
        print '</section>' . PHP_EOL;
    }
    ?>
    <br>
    <section>
        <form id="authenticate"
              method = "get"
              action = "<?php print PHP_SELF; ?>"
              class="form"
              style="padding: 5% 40%;">


            <input type="text" name="pin"/>
            <br>
            <br>
            <!-- Google reCAPTCHA block -->
            <div class="g-recaptcha" data-sitekey="6Lcu-gcgAAAAADxv4pXlOJgnva5MhonD8VrFIGv6"></div>
            <input id="btnSubmit"
                class="btn btn-primary"
                name="btnSubmit"
                type="submit"
                value="Enter"
            />
        </form>
    </section>
</article>

<?php
include ("footer.php");
?>
