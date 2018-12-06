<?php

header('content-type:text/html;charset=utf-8');
define('COMMON_PATH','./common/');
session_start();
if(!isset($_SESSION['cms'])){
    $_SESSION=['cms'=>[]];
}

