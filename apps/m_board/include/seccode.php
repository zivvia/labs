<?php
if(!defined('IN_LOVE')) {exit('Access Denied');}
//��֤����ʾ
$seccode = rand(100000, 999999);

setcookie('love_secc', authcode($seccode."\t".$timestamp, 'ENCODE'));
@header("Expires: -1");
@header("Cache-Control: no-store, private, post-check=0, pre-check=0, max-age=0", FALSE);
@header("Pragma: no-cache");
include_once LOVE_ROOT.'include/seccode.class.php';
		
$code = new seccode();
$code->code = $seccode;					//100000-999999 ��Χ�����
$code->type = $seccodedata['type'];                             //0 Ӣ��ͼƬ��֤��		�������Ŀ¼:/fonts/gif, /fonts/en
								//1 ����ͼƬ��֤��		�������Ŀ¼:/fonts/ch
								//2 Flash ��֤��		�������Ŀ¼:/seccode/flash
								//3 ������֤��			�������Ŀ¼:/seccode/sound, /seccode/flash
$code->width = $seccodedata['width'];                           //���
$code->height = $seccodedata['height'];                         //�߶�
$code->background = $seccodedata['background'];                 //���ͼƬ����			�������Ŀ¼:/seccode/background
$code->adulterate = $seccodedata['adulterate'];                 //�������ͼ��
$code->ttf = $seccodedata['ttf'];                               //��� TTF ����			�������Ŀ¼:/fonts/en, /fonts/ch
$code->angle = $seccodedata['angle'];                           //�����б��
$code->color = $seccodedata['color'];                           //�����ɫ
$code->size = $seccodedata['size'];                             //�����С
$code->shadow = $seccodedata['shadow'];                         //������Ӱ
$code->animator = $seccodedata['animator'];                     //GIF ����			���Class:/include/gifmerge.class.php
$code->fontpath = LOVE_ROOT.'images/fonts/';		//TTF �ֿ�Ŀ¼
$code->datapath = LOVE_ROOT.'images/seccode/';		//ͼƬ��������Flash ������Ŀ¼
$code->includepath = LOVE_ROOT.'include/';	//���������ļ�Ŀ¼
$code->display();
?>