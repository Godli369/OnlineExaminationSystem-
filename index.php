<?php
//载入函数库
require './common/function.php';

//统计题库目录下的“.php”文件个数
$count = count(glob('./data/*.php'));  //要求题库序号必须是连续的

//自动读取题库
$info = [];  //保存试题信息
for($i=1; $i<=$count; $i++){
	//获取题库
	$data = getDataById($i);
	//判断题库是否存在
	if(!$data){
		require './view/notFound.html';
		exit;
	}
	//从题库中读取数据
	$info[$i] = [
		'title' => $data['title'],			       //题库标题
		'time' => round($data['timeout'] / 60),	   //答题时限（分钟数）
		'score' => getDataTotal($data['data'])     //总分数
	];
}
unset($data);  //题库已经用不到，删除变量

//载入HTML模板
require './view/index.html';