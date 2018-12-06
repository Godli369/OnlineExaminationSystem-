<?php
//载入函数库
require './common/function.php';
//获取ID
$id = getTestId();
//获取题库
$data = getDataById($id);
//判断题库是否存在
if(!$data){
	require './view/notFound.html';
	exit;
}
//获取题库信息（将函数返回的数组中的各元素依次赋值给变量）
list($count, $score) = getDataInfo($data['data']);
//显示HTML模板
require './view/test.html';