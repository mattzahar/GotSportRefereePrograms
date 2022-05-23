<?php
define('DATABASE_NAME', 'refsite');
define('DATABASE_READER', 'jacelaquerre');
define('DATABASE_READER_PWD', 'r');
define('DATABASE_WRITER_PWD', 'w');
define('DATABASE_WRITER', 'jacelaquerre');
define('RECAPTCHA_SECRET_KEY', '6Lcu-gcgAAAAADxv4pXlOJgnva5MhonD8VrFIGv6');

define('ADMIN_EMAIL', 'noreply@vtsrc.com');

define('ADVISOR_PAY', 35);
define('JAMBOREE_PAY', 70);

// 2021 Seasons
define('YEAR_START_2021', '2021-01-01');
define('JAMBOREE_2021', '2021-05-05');
define('VSL_SPRING_2021', '2021-06-16');
define('TOURNAMENTS_2021', '2021-08-01');
define('VSL_FALL_2021', '2021-11-01');
define('YEAR_END_2021', '2021-12-31');

// 2022 Seasons
define('YEAR_START_2022', '2022-01-01');
define('JAMBOREE_2022', '2022-04-28');
define('VSL_SPRING_2022', '2022-06-16');
define('TOURNAMENTS_2022', '2022-08-01');
define('VSL_FALL_2022', '2022-11-01');
define('YEAR_END_2022', '2022-12-31');

// 2023 Seasons
define('YEAR_START_2023', '2023-01-01');
define('JAMBOREE_2023', '2023-05-05');
define('VSL_SPRING_2023', '2023-06-16');
define('TOURNAMENTS_2023', '2023-08-01');
define('VSL_FALL_2023', '2023-11-01');
define('YEAR_END_2023', '2023-12-31');

// 2024 Seasons
define('YEAR_START_2024', '2024-01-01');
define('JAMBOREE_2024', '2024-05-05');
define('VSL_SPRING_2024', '2024-06-16');
define('TOURNAMENTS_2024', '2024-08-01');
define('VSL_FALL_2024', '2024-11-01');
define('YEAR_END_2024', '2024-12-31');

// 2025 Seasons
define('YEAR_START_2025', '2025-01-01');
define('JAMBOREE_2025', '2025-05-05');
define('VSL_SPRING_2025', '2025-06-16');
define('TOURNAMENTS_2025', '2025-08-01');
define('VSL_FALL_2025', '2025-11-01');
define('YEAR_END_2025', '2025-12-31');

// sanitize the server global variable
$_SERVER = filter_input_array(INPUT_SERVER, FILTER_SANITIZE_STRING);

// sanitize GET global variables
if (!empty($_GET)) {
    $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
}

// sanitize POST global variables
if (!empty($_POST)) {
    $_POST = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
}

// sanitize COOKIE global variables
if (!empty($_COOKIE)) {
    $_COOKIE = filter_input_array(INPUT_COOKIE, FILTER_SANITIZE_STRING);
}

// sanitize ENV global variables
if (!empty($_ENV)) {
    $_ENV = filter_input_array(INPUT_ENV, FILTER_SANITIZE_STRING);
}

// sanitize SESSION global variables
if (!empty($_SESSION)) {
    $_SESSION = filter_var_array($_SESSION, FILTER_SANITIZE_STRING);
}

define('DEBUG', false);

define('SERVER', htmlentities($_SERVER['SERVER_NAME'], ENT_QUOTES, 'UTF-8'));

define('DOMAIN', '//' . SERVER);

define('PHP_SELF', htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'));
define('PATH_PARTS', pathinfo(PHP_SELF));

define('BASE_PATH', DOMAIN . PATH_PARTS['dirname'] . '/');

// sometimes you want to know where www-root is located in relation to where you
// are. Just count the / and then create the path
$www_rootPath='';
for($i=1; $i<substr_count(PHP_SELF, '/'); $i++){
    $www_rootPath .= '../';
}

define('WEB_ROOT_PATH', $www_rootPath);

// generally I put my passwords outside of the www-root folder so it is not
// in a public folder at all. The web server can access it so still don't
// print your passwords with php code
define('BIN_PATH', $www_rootPath . '../bin');

// here my lib folder is just in the same folder but you may have set up your
// lib folder in the www-root so its common to all your projects. If that is the
// case you would just define it like the bin path without going up a level more:
// define('LIB_PATH', $www_rootPath . 'lib');
define('LIB_PATH', 'lib');

if (DEBUG) {
    print '<p>Domain: ' . DOMAIN;
    print '<p>php Self: ' . PHP_SELF;
    print '<p>Path Parts<pre>';
    print_r(PATH_PARTS);
    print '</pre></p>';
    print '<p>BASE_PATH: ' . BASE_PATH;
    print '<p>WEB_ROOT_PATH: ' . WEB_ROOT_PATH;
    print '<p>BIN_PATH: ' . BIN_PATH;
    print '<p>LIB_PATH: ' . LIB_PATH;
}
?>