<?php
include ("top.php");
// Get URL
$thisURL = DOMAIN . PHP_SELF;

$refereeID = $_GET["refereeID"];
if ($refereeID != -1) {
    $query = "SELECT * FROM `Referees` 
                      WHERE `ID` = ?";

    if ($thisDatabaseReader->querySecurityOk($query, 1, 0, 0, 0, 0)) {
        $query = $thisDatabaseReader->sanitizeQuery($query, 1, 0, 1, 0, 0);
        $records = $thisDatabaseReader->select($query, array($refereeID));
    }

    foreach ($records as $record) {
        $refFirst = $record['FirstName'];
        $refLast = $record['LastName'];
        $refEmail = $record['Email'];
        $refScore = $record['RefScore'];
        $numAdvisements = $record['NumAdvisements'];
        print PHP_EOL;
    }
} else {
    $refFirst = "";
    $refLast = "";
    $refEmail = "";
    $refScore = 0.0;
    $numAdvisements = 0;
}

$advisorID = $_GET["advisorID"];
if ($advisorID != -1) {
    $query = "SELECT `FirstName`, `LastName`, `Email` 
                FROM `Advisors` 
               WHERE `ID` = ?";

    if ($thisDatabaseReader->querySecurityOk($query, 1, 0, 0, 0, 0)) {
        $query = $thisDatabaseReader->sanitizeQuery($query, 1, 0, 1, 0, 0);
        $records = $thisDatabaseReader->select($query, array($advisorID));
    }

    foreach ($records as $record) {
        $advisFirst = $record['FirstName'];
        $advisLast = $record['LastName'];
        $advisEmail = $record['Email'];
        print PHP_EOL;
    }
} else {
    $advisFirst = "";
    $advisLast = "";
    $advisEmail = "";
}

$date = date('Y-m-d', time());
$time = "12:00";
$location = "";
$homeTeam = "";
$awayTeam = "";
$age = 0;
$gender = "";
$appearance = 0;
$confidence = 0;
$positioning = 0;
$whistle = 0;
$mechanics = 0;
$knowledge = 0;
$enforcement = 0;
$respect = 0;
$subs = 0;
$techArea = 0;
$feedback = 0;
$good = "";
$bad = "";
$comments = "";

$res = "";
$recaptcha = "";

$email = "";
$messages = [];

$questionArray = array(
    1 => "Did the referee present a good appearance (proper uniform)?",
    2 => "Did the referee display self-confidence?	",
    3 => "Did the referee move with play and were they trying to get into good position to observe the play?",
    4 => "Did the referee use a loud whistle?",
    5 => "Did the referee use good mechanics (signals)?	",
    6 => "Did the referee exhibit good knowledge of the LOTG?",
    7 => "Did the referee enforce the LOTG; make calls that were needed?",
    8 => "Did the players respect the referee’s calls?",
    9 => "Did the referee properly manage substitutions?",
    10 => "Did the referee manage the technical area well?",
    11 => "Was the referee receptive to your feedback?",
);

$keywordArray = array(
    1 => "appearance",
    2 => "confidence",
    3 => "positioning",
    4 => "whistle",
    5 => "mechanics",
    6 => "knowledge",
    7 => "enforcement",
    8 => "respect",
    9 => "subs",
    10 => "techArea",
    11 => "feedback",
);

$variableArray = array(
    "appearance" => $appearance,
    "confidence" => $confidence,
    "positioning" => $positioning,
    "whistle" => $whistle,
    "mechanics" => $mechanics,
    "knowledge" => $knowledge,
    "enforcement" => $enforcement,
    "respect" => $respect,
    "subs" => $subs,
    "techArea" => $techArea,
    "feedback" => $feedback,
);

// Initialize error flags
$errorMsg = array();
$mailed = false;

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// Process for when the form is submitted
//
if (isset($_GET["btnSubmit"])) {
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // Security
    //
    //    if (securityCheck($thisURL)) {
    //        $msg = '<p class="container">Sorry you cannot access this page. ';
    //        $msg .= 'Security breach detected and reported.</p>';
    //        print($msg);
    //    }

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // Sanitize (clean) data
    $refereeID = htmlentities($_GET["refereeID"], ENT_QUOTES, "UTF-8");
    if ($refereeID == -1) {
        $refFirst = htmlentities($_GET["refFirst"], ENT_QUOTES, "UTF-8");
        $refLast = htmlentities($_GET["refLast"], ENT_QUOTES, "UTF-8");
        $refEmail = filter_var($_GET["refEmail"], FILTER_SANITIZE_EMAIL);
    }
    $advisorID = htmlentities($_GET["advisorID"], ENT_QUOTES, "UTF-8");
    if ($advisorID == -1) {
        $advisFirst = htmlentities($_GET["advisFirst"], ENT_QUOTES, "UTF-8");
        $advisLast = htmlentities($_GET["advisLast"], ENT_QUOTES, "UTF-8");
        $advisEmail = filter_var($_GET["advisEmail"], FILTER_SANITIZE_EMAIL);
    }
    $date = htmlentities($_GET["date"], ENT_QUOTES, "UTF-8");
    $time = htmlentities($_GET["time"], ENT_QUOTES, "UTF-8");
    $location = htmlentities($_GET["location"], ENT_QUOTES, "UTF-8");
    $homeTeam = htmlentities($_GET["homeTeam"], ENT_QUOTES, "UTF-8");
    $awayTeam = htmlentities($_GET["awayTeam"], ENT_QUOTES, "UTF-8");
    $age = htmlentities($_GET["age"], ENT_QUOTES, "UTF-8");
    $gender = htmlentities($_GET["gender"], ENT_QUOTES, "UTF-8");
    $appearance = htmlentities($_GET["appearance"], ENT_QUOTES, "UTF-8");
    $confidence = htmlentities($_GET["confidence"], ENT_QUOTES, "UTF-8");
    $positioning = htmlentities($_GET["positioning"], ENT_QUOTES, "UTF-8");
    $whistle = htmlentities($_GET["whistle"], ENT_QUOTES, "UTF-8");
    $mechanics = htmlentities($_GET["mechanics"], ENT_QUOTES, "UTF-8");
    $knowledge = htmlentities($_GET["knowledge"], ENT_QUOTES, "UTF-8");
    $enforcement = htmlentities($_GET["enforcement"], ENT_QUOTES, "UTF-8");
    $respect = htmlentities($_GET["respect"], ENT_QUOTES, "UTF-8");
    $subs = htmlentities($_GET["subs"], ENT_QUOTES, "UTF-8");
    $techArea = htmlentities($_GET["techArea"], ENT_QUOTES, "UTF-8");
    $feedback = htmlentities($_GET["feedback"], ENT_QUOTES, "UTF-8");
    $good = htmlentities($_GET["good"], ENT_QUOTES, "UTF-8");
    $bad = htmlentities($_GET["bad"], ENT_QUOTES, "UTF-8");
    $comments = htmlentities($_GET["comments"], ENT_QUOTES, "UTF-8");
    $recaptcha = htmlentities($_GET["g-recaptcha-response"], ENT_QUOTES, "UTF-8");

    // Update Array
    $variableArray = array(
        "appearance" => $appearance,
        "confidence" => $confidence,
        "positioning" => $positioning,
        "whistle" => $whistle,
        "mechanics" => $mechanics,
        "knowledge" => $knowledge,
        "enforcement" => $enforcement,
        "respect" => $respect,
        "subs" => $subs,
        "techArea" => $techArea,
        "feedback" => $feedback,
    );

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    // 
    // SECTION: 2c Validation
    
    if ($recaptcha == "") {
        $errorMsg[] = "You must complete reCAPTCHA.";
    } else {
        $res = reCaptcha($recaptcha);
        if (!($res)){
            header("HTTPS/1.1 429 Too Many Requests");
            print '<article style="align-content: center; text-align: center;">';
            $errorMsg = "Google reCAPTCHA thinks you are a robot. We've blocked IP address {$_SERVER['REMOTE_ADDR']} for a few minutes.";
            print '<h3>' . $errorMsg . '</h3>';
            print '</article>';
            exit();
        }
    }

    if ($refereeID == -1) {
        if ($refFirst == "") {
            $errorMsg[] = 'Please enter the referees first name.';
        }
        if ($refLast == "") {
            $errorMsg[] = 'Please enter the referees last name.';
        }
        if ($refEmail == "") {
            $errorMsg[] = 'Please enter the Referees email address.';
        } elseif (!verifyEmail($refEmail)) {
            $errorMsg[] = 'Referees email address appears to be incorrect.';
        }
    }
    if ($advisorID == -1) {
        if ($advisFirst == "") {
            $errorMsg[] = 'Please enter your first name.';
        }
        if ($advisLast == "") {
            $errorMsg[] = 'Please enter your last name.';
        }
        if ($advisEmail == "") {
            $errorMsg[] = 'Please enter your email address.';
        } elseif (!verifyEmail($advisEmail)) {
            $errorMsg[] = 'Your email address appears to be incorrect.';
        }
    }

    if ($gender == "") {
        $errorMsg[] = "Please enter the players gender.";
    } else {
        if (!verifyAlphaNum($gender)) {
            $errorMsg[] = "Players gender appears to have extra characters that are not allowed.";
        }
    }

    if ($age == 0) {
        $errorMsg[] = "Please enter the players age.";
    } else {
        if (!verifyAlphaNum($age)) {
            $errorMsg[] = "Players age appears to have extra characters that are not allowed.";
        }
    }

    if ($location == "") {
        $errorMsg[] = 'Please enter the field location.';
    }

    if ($homeTeam == "") {
        $errorMsg[] = 'Please enter Home Team.';
    }

    if ($awayTeam == "") {
        $errorMsg[] = 'Please enter Away Team.';
    }

    if (($appearance == 0) or ($confidence == 0) or ($positioning == 0) or ($whistle == 0) or ($mechanics == 0)
        or ($knowledge == 0) or ($enforcement == 0) or ($respect == 0) or ($subs == 0) or ($techArea == 0) or ($feedback == 0)) {
        $errorMsg[] = 'One of your 1-5 scores is missing';
    }

    if ($bad == "") {
        $errorMsg[] = 'Please enter things for referee to work on.';
    }

    if ($good == "") {
        $errorMsg[] = 'Please enter things referee did good.';
    }

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // Process Form - Passed Validation
    //
    if (empty($errorMsg)) {
        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // Save Data
        //
        // This block saves the data to the SQL database
        if ($refereeID == -1) {

            $query= "INSERT INTO `Referees`(`ID`, `FirstName`, `LastName`, `Email`)
                          VALUES (?,?,?,?)";

            if ($thisDatabaseWriter->querySecurityOk($query, 0, 0, 0, 0, 0)) {
                $query = $thisDatabaseWriter->sanitizeQuery($query, 0, 0, 0, 0, 0);
                $result = $thisDatabaseWriter->insert($query, array(null, $refFirst, $refLast, $refEmail));
                $refereeID = $thisDatabaseWriter->lastInsert();
            }
        }

        if ($advisorID == -1) {
            $query= "INSERT INTO `Advisors`(`ID`, `FirstName`, `LastName`, `Email`) 
                          VALUES (?,?,?,?)";

            if ($thisDatabaseWriter->querySecurityOk($query, 0, 0, 0, 0, 0)) {
                $query = $thisDatabaseWriter->sanitizeQuery($query, 0, 0, 0, 0, 0);
                $result = $thisDatabaseWriter->insert($query, array(null, $advisFirst, $advisLast, $advisEmail));
                $advisorID = $thisDatabaseWriter->lastInsert();
            }
        }

        // Calculate score from all questions
        $total = $appearance + $confidence + $positioning + $whistle + $mechanics + $knowledge + $enforcement +
            $respect + $subs + $techArea + $feedback;
        define('NUM_QUESTIONS', 11);
        $score = round((float)$total / (float)NUM_QUESTIONS, 1 , PHP_ROUND_HALF_UP);

        $query = "INSERT INTO `Advisement`(`ID`, `RefereeID`, `AdvisorID`, `Date`, `Time`, `Location`, `HomeTeam`, 
                         `VisitingTeam`, `Age`, `Gender`, `Appearance`, `Confidence`, `Positioning`, `Whistle`, 
                         `Mechanics`, `Knowledge`, `Enforcement`, `Respect`, `Subs`, `TechArea`, `Feedback`, `Score`, `Good`, `Bad`, `Comments`) 
                       VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

        if ($thisDatabaseWriter->querySecurityOk($query, 0, 0, 0, 0, 0)) {
            $query = $thisDatabaseWriter->sanitizeQuery($query, 1, 1, 1, 0, 0);
            $result = $thisDatabaseWriter->insert($query, array(null, $refereeID, $advisorID, $date,
            $time, $location, $homeTeam, $awayTeam, $age, $gender, $appearance, $confidence, $positioning,
            $whistle, $mechanics, $knowledge, $enforcement, $respect, $subs, $techArea, $feedback, $score, $good, $bad, $comments));
            $reportID = $thisDatabaseWriter->lastInsert();
        }

        // Create full names of refs and advisors for emails
        $advisName = $advisFirst . ' ' . $advisLast;
        $refName = $refFirst . ' ' . $refLast;

        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // Create message for SYRA
        //
        $billMessage = "";
        $billMessage .= '<h3>Bill Edwards, </h3>';
        $billMessage .= '<h3>' . $advisName . ' has submitted their Referee Advisor Report for ' . $refName . '.</h3>';
        $billMessage .= '<p>You can view the report here: <a href = http://vtsrc.com/report.php?reportID=' . $reportID .
            '>http://vtsrc.com/report.php?reportID=' . $reportID . '</a></p>';
        $billMessage .= '<br><p>----------</p>';
        $billMessage .= '<p>This has been an automated email from: <a href = http://vtsrc.com/>http://vtsrc.com/</a></p>';
        $billMessage .= '<p>Do not reply to this email as it is not monitored.</p>';
        $billMessage .= '<p>----------</p>';

        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // Create message for Advisor
        //
        $message = "";
        $message .= '<h3>' . $advisName . ', </h3>';
        $message .= '<h3>Your Referee Advisor Report for ' . $refName . ' has been successfully submitted.</h3>';
        $message .= '<p>You can view the report here: <a href = http://vtsrc.com/report.php?reportID=' . $reportID .
            '>http://vtsrc.com/report.php?reportID=' . $reportID . '</a></p>';
        $message .= '<br><p>----------</p>';
        $message .= '<p>This has been an automated email from: <a href = http://vtsrc.com>http://vtsrc.com</a></p>';
        $message .= '<p>Do not reply to this email as it is not monitored.</p>';
        $message .= '<p>----------</p>';

        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // Create message for Referee
        //
        $refMessage = "";
        $refMessage .= '<style>
                            table, th, td {
                              border: 1px solid black;
                              text-align: center;
                            }
                            
                            table {
                              border-collapse: collapse;
                              width: 98%;
                              text-align: center;
                              margin-left: auto;
                              margin-right: auto;
                            }
                            
                            th, td {
                              padding: 10px;
                            }
                            
                            td a {
                              display: block;
                            }
                            
                            * {
                              box-sizing: border-box;
                            }
                            </style>';
        $refMessage .= '<h3>' . $refName . ', </h3>';
        $refMessage .= '<h3>Your Referee Advisor Report from ' . $advisName . ' is available to be viewed.</h3>';
        $refMessage .= '<table id="wider" style="table-layout: fixed">
                <caption><h3><strong>Report Information</strong></h3></caption>
                <tr>
                    <th>Referee</th>
                    <th>Advisor</th>
                </tr>
                
                <tr><td>' . $refName . '</td>
                <td>' . $advisName . '</td></tr>' . PHP_EOL .
                '<tr><td><a href="mailto:' . $refEmail . '">' . $refEmail . '</a></td>
                <td><a href="mailto:' . $advisEmail . '">' . $advisEmail . '</a></td></tr>'. PHP_EOL .
            '</table><br>';
        $refMessage .= '<table id="wider" style="table-layout: fixed">
                <caption><strong>Game Information</strong></caption>
                <tr><td>Game Date: ' . $date . '</td>
                <td>Game Time: ' . $time . '</td></tr>' . PHP_EOL .
                '<tr><td>Location: ' . $location . '</td>
                <td>Age/Gender: U' . $age . ' ' . $gender . '</td></tr>' . PHP_EOL .
                '<tr><td>Home Team: ' . $homeTeam . '</td>
                <td>Away Team: ' . $awayTeam . '</td></tr>' . PHP_EOL .
            '</table>
            <br>';
        $clnOutputGood = "";
        $clnOutputGood = str_ireplace("&amp;#39;", "'", $good);
        $clnOutputGood = str_ireplace("&amp;#34;", '"', $clnOutputGood);
        $clnOutputBad = "";
        $clnOutputBad = str_ireplace("&amp;#39;", "'", $bad);
        $clnOutputBad = str_ireplace("&amp;#34;", '"', $clnOutputBad);
        $refMessage .= '<table id="wider">
                <caption><strong>Performance Comments</strong></caption>
                <tr><td><strong>Things Done Well</strong></td></tr>
                <tr><td style="text-align: left">' . $clnOutputGood . '</td></tr>
                <tr><td><strong>Things to Work On</strong></td></tr>
                <tr><td style="text-align: left">' . $clnOutputBad . '</td></tr>
            </table>';
        $refMessage .= '<br><p>If you have any questions, please reach out to your Advisor.</p>';
        $refMessage .= '<br><p>----------</p>';
        $refMessage .= '<p>This has been an automated email from the VT State Referee Committee.</p>';
        $refMessage .= '<p>Do not reply to this email as it is not monitored.</p>';
        $refMessage .= '<p>----------</p>';

        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // Mail to Advisor, Referee & Bill
        //
        $to = $advisEmail; // the person who filled out the form
        $cc = '';
        $bcc = '';

        $from = 'noreply@vtsrc.com';

        // subject of email
        $subject = 'Advisor Report Submission Confirmation';

        $mailed = sendMail($to, $cc, $bcc, $from, $subject, $message, $advisName, $billMessage, $refEmail, $refMessage, $refName);

    } // end if form is valid
} // ends if form was submitted
?>

<article id="main" class="container">

<?php

if (isset($_GET["btnSubmit"]) and empty($errorMsg)) { //closing if marked with: end body submit
    $REDIRECT = 'Location: http://vtsrc.com/submit.php?reportID=' . $reportID . '&mailed=' . $mailed . '&to=' . $to;
    header($REDIRECT);
    exit();
} else {
    print '';

    //#########################################################################
    //
    // Error Messages
    //
    if ($errorMsg) {
        print '<section id="errors">' . PHP_EOL;
        print '<h3>Your report has the following mistakes that need to be fixed.</h3>' . PHP_EOL;
        print '<ol>' . PHP_EOL;

        foreach ($errorMsg as $err) {
            print '<li>' . $err . '</li><br>' . PHP_EOL;
        }
        print '</ol>' . PHP_EOL;
        print '</section>' . PHP_EOL;
    }
    ?>
    <section>
        <form action = "<?php print PHP_SELF; ?>"
              onsubmit = "return checkBeforeSubmit()"
              id = "ratingForm"
              method = "get"
              class = "form_container form"
              style="padding: 5% 10%;">
            <fieldset class="refinfo">
                <section class="col-25">
                    <h3>Referee Information</h3>
                </section>
                <script type="text/javascript">
                    var wasSubmitted = false;
                    function checkBeforeSubmit(){
                        if(!wasSubmitted) {
                            wasSubmitted = true;
                            return wasSubmitted;
                        }
                        return false;
                    }
                </script>

            <?php
            if ($refereeID == -1) {
            ?>
                <label class="form-label" for="refFirst">First Name:</label>
                <input class="form-control" type="text" id="refFirst" name="refFirst" value="<?php if (isset($refFirst)) echo $refFirst; ?>"/>
                <label class="form-label" for="refLast">Last Name:</label>
                <input class="form-control" type="text" id="refLast" name="refLast" value="<?php if (isset($refLast)) echo $refLast; ?>"/>
                <label class="form-label" for="refEmail">Email:</label>
                <input class="form-control" type="text" id="refEmail" name="refEmail" value="<?php if (isset($refEmail)) echo $refEmail; ?>"/>
            <?php
            } else {
                print '<p>' . $refFirst . ' ' . $refLast . '</p>';
                print '<p><a href="mailto:' . $refEmail . '">' . $refEmail . '</a></p>';
            }
            ?>
            <input class="form-control" type="hidden" id="refereeID" name="refereeID" value="<?php echo $refereeID; ?>">
            </fieldset>
            <hr>
            <fieldset class="advisinfo">
                <section class="col-25">
                    <h3>Advisor Information (You)</h3>
                </section>
                <?php
                if ($advisorID == -1) {
                    ?>
                    <label class="form-label" for="advisFirst">First Name:</label>
                    <input class="form-control" type="text" id="advisFirst" name="advisFirst" value="<?php if (isset($advisFirst)) echo $advisFirst; ?>"/>
                    <label class="form-label" for="advisLast">Last Name:</label>
                    <input class="form-control" type="text" id="advisLast" name="advisLast" value="<?php if (isset($advisLast)) echo $advisLast; ?>"/>
                    <label class="form-label" for="advisEmail">Email:</label>
                    <input class="form-control" type="text" id="advisEmail" name="advisEmail" value="<?php if (isset($advisEmail)) echo $advisEmail; ?>"/>
                    <?php
                } else {
                    print '<p>' . $advisFirst . ' ' . $advisLast . '</p>';
                    print '<p><a href="mailto:' . $advisEmail . '">' . $advisEmail . '</a></p>';
                }
                ?>
                <input class="form-control" type="hidden" id="advisorID" name="advisorID" value="<?php echo $advisorID; ?>">
            </fieldset>
            <hr>
            <fieldset class="gameinfo">
                <section class="col-25">
                    <h3>Game Information</h3>
                </section>
            <br>
            <label class="form-label" for="date">Game Date:</label>
            <input class="form-date" type="date" id="date" name="date"
                   value="<?php if ($date != date('Y-m-d', time())) { echo $date; } else { echo date('Y-m-d', time()); } ?>"
                   min="2018-01-01" max="2055-12-31" required/>
            <br>
            <label class="form-label" for="time">Game Time:</label>

            <input class="form-time" type="time" id="time" name="time"
                   value="<?php if ($time != '12:00') { echo $time; } else { echo '12:00'; } ?>"
                   min="00:00" max="24:00" required/>
            <br>
            <p>Player Gender: </p>
            <input class="form-radio" type="radio" id="male" name="gender" value="Boys" <?php if($gender === 'Boys') echo 'checked'; ?>/>
            <label class="form-label" for="male">Boys</label>
            <input class="form-radio" type="radio" id="female" name="gender" value="Girls" <?php if($gender === 'Girls') echo 'checked'; ?>/>
            <label class="form-label" for="female">Girls</label>
            <input class="form-radio" type="radio" id="coed" name="gender" value="Co-Ed" <?php if($gender === 'Co-Ed') echo 'checked'; ?>/>
            <label class="form-label" for="coed">Co-Ed</label>
            <br>
            <br>
            <label class="form-label" for="age">Player Age:</label>
            <select class="form-select" name="age" id="age">
                <option value="0" <?php if($age == 0) echo 'selected'; ?>>Select Age</option>
                <option value="8" <?php if($age == 8) echo 'selected'; ?>>U8</option>
                <option value="10" <?php if($age == 10) echo 'selected'; ?>>U10</option>
                <option value="12" <?php if($age == 12) echo 'selected'; ?>>U12</option>
                <option value="14" <?php if($age == 14) echo 'selected'; ?>>U14</option>
                <option value="16" <?php if($age == 16) echo 'selected'; ?>>U16</option>
                <option value="19" <?php if($age == 19) echo 'selected'; ?>>U19</option>
            </select>
            <br>
            <label class="form-label" for="location">Field Location:</label>
            <input class="form-control" type="text" id="location" name="location" value="<?php if (isset($location)) echo $location; ?>"/>
            <label class="form-label" for="homeTeam">Home Team:</label>
            <input class="form-control" type="text" id="homeTeam" name="homeTeam" value="<?php if (isset($homeTeam)) echo $homeTeam; ?>"/>
            <label class="form-label" for="awayTeam">Away Team:</label>
            <input class="form-control" type="text" id="awayTeam" name="awayTeam" value="<?php if (isset($awayTeam)) echo $awayTeam; ?>"/>
            </fieldset>
            <hr>
            <fieldset class="ratings">
                <section class="col-25">
                    <h3>Referee Performance</h3>
                    <p><strong>Please rate the referee's performance from 1-5 matching the following.</strong><p>
                    <p><strong>The ratings below will NOT be shared with the referee, so be honest.</strong><p>
                    <p><strong>1- Needs attention   2- Could use improvement   3- Meets Expectations</strong></p>
                    <p><strong>4- Exceeds Expectations  5- This is a strength</strong></p>
                </section>

                    <?php
                    foreach ($questionArray as $idx => $question ) {
                        print '<p>' . $question . '</p>' . PHP_EOL . '<div class="stars">';
                        if ($variableArray[$keywordArray[$idx]] == 5) {
                            print '<input class="star star-5 form-check-input" type="radio" id="' . $keywordArray[$idx] . '5" name="' . $keywordArray[$idx] . '" value="5" checked/>';
                        } else {
                            print '<input class="star star-5 form-check-input" type="radio" id="' . $keywordArray[$idx] . '5" name="' . $keywordArray[$idx] . '" value="5"/>';
                        }
                        print '<label style="margin-right:10px" class="star star-5" for="' . $keywordArray[$idx] . '5" title="This is a strength"></label>' . PHP_EOL;


                        if ($variableArray[$keywordArray[$idx]] == 4) {
                            print '<input class="star star-4 form-check-input" type="radio" id="' . $keywordArray[$idx] . '4" name="' . $keywordArray[$idx] . '" value="4" checked/>';
                        } else {
                            print '<input class="star star-4 form-check-input" type="radio" id="' . $keywordArray[$idx] . '4" name="' . $keywordArray[$idx] . '" value="4"/>';
                        }
                        print '<label style="margin-right:10px" class="star star-4" for="' . $keywordArray[$idx] . '4" title="Exceeds Expectations"></label>' . PHP_EOL;


                        if ($variableArray[$keywordArray[$idx]] == 3) {
                            print '<input class="star star-3 form-check-input" type="radio" id="' . $keywordArray[$idx] . '3" name="' . $keywordArray[$idx] . '" value="3" checked/>';
                        } else {
                            print '<input class="star star-3 form-check-input" type="radio" id="' . $keywordArray[$idx] . '3" name="' . $keywordArray[$idx] . '" value="3"/>';
                        }
                        print '<label style="margin-right:10px" class="star star-3" for="' . $keywordArray[$idx] . '3" title="Meets Expectations"></label>' . PHP_EOL;

                        if ($variableArray[$keywordArray[$idx]] == 2) {
                            print '<input class="star star-2 form-check-input" type="radio" id="' . $keywordArray[$idx] . '2" name="' . $keywordArray[$idx] . '" value="2" checked/>';
                        } else {
                            print '<input class="star star-2 form-check-input" type="radio" id="' . $keywordArray[$idx] . '2" name="' . $keywordArray[$idx] . '" value="2"/>';
                        }
                        print '<label style="margin-right:10px" class="star star-2" for="' . $keywordArray[$idx] . '2" title="Could use improvement"></label>' . PHP_EOL;

                        if ($variableArray[$keywordArray[$idx]] == 1) {
                            print '<input class="star star-1 form-check-input" type="radio" id="' . $keywordArray[$idx] . '1" name="' . $keywordArray[$idx] . '" value="1" checked/>';
                        } else {
                            print '<input class="star star-1 form-check-input" type="radio" id="' . $keywordArray[$idx] . '1" name="' . $keywordArray[$idx] . '" value="1"/>';
                        }
                        print '<label style="margin-right:10px" class="star star-1" for="' . $keywordArray[$idx] . '1" title="Needs attention"></label>' . PHP_EOL;
                        print '<br>' . PHP_EOL . '</div>';
                    }
                    ?>

                <br>
                <hr>
                <h3>Written Feedback</h3>
                <p style="color: darkred"><strong>&#9888; Warning: The two text fields below will be emailed to the Referee!</strong></p>
                <p>The referee will read this, you should write like you are talking to them.</p>
                <label class="form-label" for="good">List 2-3 things the referee did well: </label><br>
                <textarea class="form-control" id="good" name="good" rows="8" cols="90"><?php if (isset($good)) echo $good; ?></textarea>
                <br>
                <label class="form-label" for="bad">List 2-3 things the referee can work on: </label><br>
                <textarea class="form-control" id="bad" name="bad" rows="8" cols="90"><?php if (isset($bad)) echo $bad; ?></textarea>
                <br>
                <p><strong>The comments below will NOT be shared with the referee.</strong></p>
                <label class="form-label" for="comments">Private Comments for Bill / Assignors / SRC: </label><br>
                <textarea class="form-control" id="comments" name="comments" rows="8" cols="90"><?php if (isset($comments)) echo $comments; ?></textarea>
            </fieldset>
            <hr>
            <!-- Google reCAPTCHA block -->
            <div class="g-recaptcha" data-sitekey="6Lcu-gcgAAAAADxv4pXlOJgnva5MhonD8VrFIGv6"></div>
            <!-- Start Submit button -->
            <fieldset style="margin-top: 5%; text-align: center;">
                <input
                    class="btn btn-primary"
                    onclick="this.value='Submitting, please wait...';"
                    id="btnSubmit"
                    name="btnSubmit"
                    type="submit"
                    value="Submit Report"/>
            </fieldset>
            <!-- ends submit button -->
        </form>
    </section>
    <?php
    } //end body submit
    ?>
</article>
<?php
include ("footer.php");
?>
