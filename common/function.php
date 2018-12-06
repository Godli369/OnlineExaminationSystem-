<?php
//功能函数库

/**
 * 获取题库ID
 */
function getTestId(){
	//读取用户访问的题库序号
	$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;
	//题库序号最小为1
	return max($id, 1);
}

/**
 * 根据序号载入题库
 * @param int $id   题库序号
 * @param bool $toHTML  是否对题库进行转义
 * $return 如果题库存在，读取并返回数据；不存在，返回false。
 */
function getDataById($id, $toHTML=true){
	//根据序号拼接题库文件路径
	$target = "./data/$id.php";
	//判断题库文件是否存在
	if(!file_exists($target)){
		return false;
	}
	//载入题库
	$data = require $target;
	//对题库数组进行递归转义
	$func = function($data) use(&$func){
		$result = [];
		foreach($data as $k=>$v){
			//如果是数组，则继续递归，如果是字符串，则转义
			$result[$k] = is_array($v) ? $func($v) : (is_string($v) ? toHTML($v) : $v);
		}
		return $result;
	};
	//返回数据
	return $toHTML ? $func($data) : $data;
}

/**
 * 获取题库信息
 * @param array $data   题库
 * @param array $score  分数
 * $return array 每种题型的个数、每种题型下1道题的分数
 */
function getDataInfo($data){
	$count = []; //保存每种题型个数
	$score = []; //保存每种题型下1道题的分数
	//从题库中读取信息
	foreach($data as $k=>$v){
		//计算各题型下的题目个数
		$count[$k] = count($v['data']);
		//计算各题型中单题的分数
		//单题分数 =  该题型总分数 ÷ 该题型下的题目个数
		$score[$k] = round($v['score'] / $count[$k]);
	}
	return [$count, $score];
}

/**
 * 计算总分
 * @params array $data 题库
 * $return int 总分数
 */
function getDataTotal($data){
	$sum = 0; //保存总分
	//从题库中读取信息
	foreach($data as $v){
		$sum += $v['score'];
	}
	return $sum;
}

/**
 * 将字符串编码为HTML
 * 转换的特殊字符有：& " ' < > 和空格
 * 未对换行符进行转换，如果需要，再调用nl2br函数即可
 * @param string $str 输入的字符串
 * @return string 编码后的字符串
 */
function toHTML($str){
	$str = htmlspecialchars($str, ENT_QUOTES);
	return str_replace(' ', '&nbsp;', $str);
}
