<?php
ini_set('session.gc_maxlifetime', 57600); // 16 hours
// Probability of garbage collection of session
// session.gc_probability / session.gc_divisor = 1/1 = 100%
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 1);
session_start();
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- ######################   Page Top   ############################## -->
        <meta charset="utf-8">
        <title>VTSRC Referee Advisements</title>
        <meta name="author" content="Jace Laquerre">
        <meta name="description" content="VT referee advisement information">
        <meta name="apple-mobile-web-app-title" content="VTSRC Referee Advisements">
        <meta name="application-name" content="VT referee advisement information">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href= "css/cssV4.css">

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
        <script data-require="jquery@3.1.1" data-semver="3.1.1" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="js/tableSort.js"></script>
        <!-- Google reCaptcha -->
        <script src="https://www.google.com/recaptcha/api.js" async></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Nerko+One&display=swap" rel="stylesheet">
        <link rel="shortcut icon" href="https://i.postimg.cc/K8G6D2hd/USSFbadge.png" />
        <link rel="icon" type="image/png" sizes="32x32" href="https://i.postimg.cc/K8G6D2hd/USSFbadge.png">
        <link rel="icon" type="image/png" sizes="16x16" href="https://i.postimg.cc/K8G6D2hd/USSFbadge.png">


        <?php
        // %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
        //
        // inlcude all libraries.
        //
        // %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
        print '<!-- begin including libraries -->';

        include 'lib/constants.php';
        include LIB_PATH . '/security.php';
        include LIB_PATH . '/mail-message.php';
        include LIB_PATH . '/validation-functions.php';
        include LIB_PATH . '/Connect-With-Database.php';

        print '<!-- libraries complete-->';

        ?>
    </head>
    <?php
        print '<!-- ######################   End of Page Top   ############################## -->';
        print '<!-- #### Start of Body #### -->';
        include("header.php");
        print PHP_EOL;
        include("nav.php");
    ?>
