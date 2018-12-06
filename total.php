<?php
//载入函数库
require './common/function.php';
//获取ID
$id = getTestId();
//获取题库
$data = getDataById($id, false);
//判断题库是否存在
if(!$data){
	require './view/notFound.html';
	exit;
}
//获取题库信息（每个题型的个数、每个题型中每道题的分数）
list($count, $score) = getDataInfo($data['data']);

//保存用户总得分
$sum = 0;
//保存用户的考试结果
$total = [];

//阅卷
foreach($data['data'] as $type=>$each){
	foreach($each['data'] as $k=>$v){
		//取出用户提交的答案
		$answer = isset($_POST[$type][$k])? $_POST[$type][$k] : '';
		//判断答案是否正确
		if($v['answer'] === $answer){
			$total[$type][$k] = true;
			$sum += $score[$type];
		}else{
			$total[$type][$k] = false;
		}
	}
}

require './view/total.html';