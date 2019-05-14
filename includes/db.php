<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REMOTE_ADDR'] == '::1') {
    $db['db_host'] = "localhost";
    $db['db_user'] = "root";
    $db['db_pass'] = "";
    $db['db_name'] = "cms";
} else {
    $db['db_host'] = "localhost";
    $db['db_user'] = 'hostmywi_1';
    $db['db_pass'] = 'lE#N~#A@C#X-';
    $db['db_name'] = 'hostmywi_1';
}


require_once 'ez_sql_core.php';
require_once 'ez_sql.php';
$ezdb = new ezSQL_mysqli($db['db_user'], $db['db_pass'], $db['db_name'], $db['db_host']);
$ezdb->show_errors();

//print_r($db);
//die();

//foreach($db as $key => $value){
//    define(strtoupper($key), $value);
//}


$connection = mysqli_connect($db['db_host'], $db['db_user'], $db['db_pass'], $db['db_name']);


define('HASH_PREFIX', 'Y4qD:\gh');
?>