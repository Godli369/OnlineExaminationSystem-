<?php


require './init.php';
require './view/login.html';
if($_POST){
doPost();
}
function doPost(){
$name=$_POST['name'];
$password=$_POST['password'];
$captcha=$_POST['captcha'];
//判断验证码
//require COMMON_PATH.'captcha.php'; //载入验证码函数
if(!checkCode($captcha)){
echo "<script>alert('登录失败：验证码输入有误。 ');</script>";echo "<script>window.location='login.php';</script>";
}
else{
$mysql_conf = array(
'host'=> '127.0.0.1:3306',
'db'=> 'admin',
'db_user'=> 'root',
'db_pwd'=> 'root',
);
$mysql_conn = mysqli_connect($mysql_conf['host'], $mysql_conf['db_user'],
$mysql_conf['db_pwd'],$mysql_conf['db']);
$sql = "select * from cms_admin where name='$name'";
$res = mysqli_query($mysql_conn,$sql);
$row = mysqli_fetch_assoc($res);
if(($row['password']==$password)&&($_POST['name']!=null)&&($_POST['password']!=null))
{
//echo "<script>window.location.href='index.php';</script>";
header("location:index.php");
}else{
//登录失败
echo "<script>alert('登录失败：用户名或密码错误。 ');</script>";
}
}}
function checkCode($code){
$captcha = $_SESSION['cms']['captcha'];
if(!empty($captcha)){
unset($_SESSION['cms']['captcha']); //清除验证码，防止重复验证
return strtoupper($captcha) == strtoupper($code); //不区分大小写
}
return false;
}
