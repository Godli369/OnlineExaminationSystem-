<?php
define('NO_CHECK_LOGIN',true);
require './init.php';
require COMMON_PATH.'/captcha.php';
$code=captcha_create();
captcha_show($code);
$_SESSION['cms']['captcha']=$code;


