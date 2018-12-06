<?php
/**
* 生成验证码
* @param int $count 验证码的位数
* @return 返回生成结果
*/
function captcha_create($count=5){
$charset = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789'; //随机因子
$code = ''; //保存生成的验证码
//生成随机码
$len = strlen($charset) - 1;
for($i=0; $i<$count; $i++) {
$code .= $charset[rand(0, $len)];
}
return $code; //返回验证码文本
}
/**
* 输出验证码图像
* @param string $code 验证码字符串
*/
function captcha_show($code){
//创建图片资源
$im = imagecreate($x=250, $y=62);
//随机生成背景颜色
imagecolorallocate($im, rand(50,200), rand(0,155), rand(0,155));
//设置字体颜色和样式
$fontColor = imagecolorallocate($im, 255, 255, 255);
$fontStyle = COMMON_PATH.'file/captcha.ttf';
//生成指定长度的验证码
for($i=0, $len=strlen($code); $i<$len; ++$i){
imagettftext($im,
30, //字符尺寸
rand(0,20) - rand(0,25), //随机设置字符倾斜角度
32 + $i*40, rand(30,50), //随机设置字符坐标
$fontColor, //字符颜色
$fontStyle, //字符样式
$code[$i] //字符内容
);
}
//添加 8 个干扰线
for($i=0; $i<8; ++$i){//随机生成干扰线颜色
$lineColor = imagecolorallocate($im, rand(0,255), rand(0,255), rand(0,255));
//随机生成干扰线
imageline($im, rand(0, $x), 0, rand(0, $x), $y, $lineColor);
}
//添加 250 个噪点
for($i=0; $i<250; ++$i) {
//随机生成噪点位置
imagesetpixel($im, rand(0, $x), rand(0, $y), $fontColor);
}
//设置发送的信息头内容
header('Content-type:image/png');
//输出图片
imagepng($im);
//释放图片所占内存
//imagedestroy($im);
}