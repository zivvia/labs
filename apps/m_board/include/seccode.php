<?php
if(!defined('IN_LOVE')) {exit('Access Denied');}
//验证码显示
$seccode = rand(100000, 999999);

setcookie('love_secc', authcode($seccode."\t".$timestamp, 'ENCODE'));
@header("Expires: -1");
@header("Cache-Control: no-store, private, post-check=0, pre-check=0, max-age=0", FALSE);
@header("Pragma: no-cache");
include_once LOVE_ROOT.'include/seccode.class.php';
		
$code = new seccode();
$code->code = $seccode;					//100000-999999 范围内随机
$code->type = $seccodedata['type'];                             //0 英文图片验证码		相关数据目录:/fonts/gif, /fonts/en
								//1 中文图片验证码		相关数据目录:/fonts/ch
								//2 Flash 验证码		相关数据目录:/seccode/flash
								//3 语音验证码			相关数据目录:/seccode/sound, /seccode/flash
$code->width = $seccodedata['width'];                           //宽度
$code->height = $seccodedata['height'];                         //高度
$code->background = $seccodedata['background'];                 //随机图片背景			相关数据目录:/seccode/background
$code->adulterate = $seccodedata['adulterate'];                 //随机背景图形
$code->ttf = $seccodedata['ttf'];                               //随机 TTF 字体			相关数据目录:/fonts/en, /fonts/ch
$code->angle = $seccodedata['angle'];                           //随机倾斜度
$code->color = $seccodedata['color'];                           //随机颜色
$code->size = $seccodedata['size'];                             //随机大小
$code->shadow = $seccodedata['shadow'];                         //文字阴影
$code->animator = $seccodedata['animator'];                     //GIF 动画			相关Class:/include/gifmerge.class.php
$code->fontpath = LOVE_ROOT.'images/fonts/';		//TTF 字库目录
$code->datapath = LOVE_ROOT.'images/seccode/';		//图片、声音、Flash 等数据目录
$code->includepath = LOVE_ROOT.'include/';	//其它包含文件目录
$code->display();
?>