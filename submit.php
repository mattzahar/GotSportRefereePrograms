<?php
include ("top.php");

// Get URL
$thisURL = DOMAIN . PHP_SELF;

$reportID = $_GET["reportID"];
$mailed = $_GET["mailed"];
$to = $_GET["to"];

print '<article id="main" class="container">';

print '<h1>Your Report Has Been Submitted</h1>';

if ($mailed) {
    print '<h2>For your records, a confirmation of this submission has been sent';
} else {
    print '<h2>There was an ERROR when we tried to send a confirmation email';
}

print '</h2>';

print '<h2> To: ' . $to . '</h2>';

print '<h3>If the email does not appear in your inbox, please check your spam folder.</h3>';
print '<br>';

print '<h2>To view the report click <a href = http://vtsrc.com/report.php?reportID=' . $reportID .
    '>HERE</a></h2>';

print '<h2>To submit another report click <a href = http://vtsrc.com/addFirst.php>HERE</a></h2>';

print '</article>';
print '<br>';

include ("footer.php");
?>
