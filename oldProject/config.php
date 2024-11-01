<?php namespace config;
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//PROD


//Local
$_ENV['HOST_LC1'] = '127.0.0.1';
$_ENV['PORT_LC1'] = 8889;
$_ENV['USER_LC1'] = 'root';
$_ENV['PASS_LC1'] = '123';
$_ENV['DB_LC1'] = 'test-case-php';
