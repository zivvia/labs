<?php
!defined("IN_LOVE") && die("Accessed Defined!");
//生成随机数
function randStr($len) {
    $s = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'; //随机数字(字母)取值范围
    $max = strlen($s)-1;
    $result = '';
    for ($i=0; $i<$len; $i++) {
        $r = rand(0, $max);
        $result .= $s[$r];
    }
    return $result;
}
//生成随机数字
function rnd($len) {
    $s = '0123456789'; //随机数字取值范围
    $max = strlen($s)-1;
    $result = '';
    for ($i=0; $i<$len; $i++) {
        $r = rand(0, $max);
        $result .= $s[$r];
    }
    return '0.'.$result;
}
//检测PHP设置参数
function getcon($varName)
    {
        switch($res = get_cfg_var($varName))
        {
            case 0:
            return NO;
            break;
            case 1:
            return YES;
            break;
            default:
            return $res;
            break;
        }
         
    }	
//把字符串中的每个字符转换成十六进制数
function Hex($sa) 
	{
		$buf = "";
		for ($i = 0; $i < strlen($sa); $i++)
		{
			$val = dechex(ord($sa{$i}));	    
			if(strlen($val)< 2) 
				$val = "0".$val;
			$buf .= $val;
		}
		return $buf;
	}
	/*
	 *  把十六进制数转换成字符串
	 */
	function fromHex($sa)
	{
		$buf = "";
		for($i = 0; $i < strlen($sa); $i += 2)
		{
			$val = chr(hexdec(substr($sa, $i, 2)));
			$buf .= $val;
		}
		return $buf;
	}
function dsetcookie($var, $value, $life = 0, $prefix = 1) {
	global $cookiedomain, $cookiepath, $timestamp, $_SERVER;
	setcookie($var, $value,
		$life ? $timestamp + $life : 0, $cookiepath,
		$cookiedomain, $_SERVER['SERVER_PORT'] == 443 ? 1 : 0);
}
function submitcheck() {
	global $seccodestatus;
	if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['formhash'] == _FORMHASH_ && (empty($_SERVER['HTTP_REFERER']) ||
		preg_replace("/https?:\/\/([^\:\/]+).*/i", "\\1", $_SERVER['HTTP_REFERER']) == preg_replace("/([^\:]+).*/", "\\1", $_SERVER['HTTP_HOST']))) {
		if($seccodestatus[$_REQUEST['a']]) {
			list($checkseccode, $expiration) = explode("\t", authcode($_COOKIE['love_secc'], 'DECODE'));
			include_once LOVE_ROOT.'./include/seccode.class.php';
			$code = new seccode();
			$code->seccodeconvert($checkseccode);
			if($timestamp - $expiration > 600) {
				exit('Access Denied');
			}
			if($checkseccode != strtoupper($_REQUEST['seccode'])) {
				$messageid = 9998;
				include template('message.htm');
				exit;
			}
		}
		return TRUE;
	} else {
		return FALSE;
	}
}
function template($tplfile, $tplpath = '', $tplcachepath = '', $userpack = '', $userpackpath = '', $cachelimit = '') {
	$tplpath = $tplpath != '' ? $tplpath : (defined("_TPLPath_") ? _TPLPath_ : '');
	$tplfile = $tplpath.$tplfile;
	$tplcachelimit = $cachelimit === '' ? (defined("_TPLCacheLimit_") ? _TPLCacheLimit_ : 0) : $cachelimit;
	$cachefile = ($tplcachepath !== '' ? $tplcachepath : (defined("_TPLCachePath_") ? _TPLCachePath_ : '')).str_replace(array('/', '.'), '_', $tplfile.($userpack ? '.'.($userpackpath ? $userpackpath : '').$userpack : '')).'.php';
	if ($tplcachelimit || !($cachetime = @filemtime($cachefile))) {
		if (time() - $cachetime > $tplcachezlimit || @filemtime($tplfile) > $cachetime) {
			$nemotpl = new nemo;
			$nemotpl->userpack = $userpack ? ($userpackpath ? $userpackpath : $tplpath).$userpack.'.php' : '';
			$nemotpl->template = file_get_contents($tplfile);
			$nemotpl->tplpath = $tplpath;
			$nemotpl->cachefile = $cachefile;
			$nemotpl->extraparms = ',\\\''.$tplpath.'\\\',\\\''.$tplcachepath.'\\\',\\\''.$userpack.'\\\',\\\''.$userpackpath.'\\\'';
			return $nemotpl->compile();
		}
	}
	return $cachefile;
}
function formhash() {
	global $bayi_username, $bayi_uid, $timestamp;
	return substr(md5(substr($timestamp, 0, -7).$bayi_username.$bayi_uid.$_SERVER['HTTP_USER_AGENT']), 8, 8);
}
	/**
	 * 翻页函数
	 *
	 * @param int $num 总纪录数
	 * @param int $perpage 每页大小
	 * @param int $curpage 当前页面
	 * @param string $mpurl url
	 * @return string 类似于: <div class="page">***</div>
	 */
function page($num, $perpage, $curpage, $mpurl) {
		$multipage = '';
		$mpurl .= strpos($mpurl, '?') ? '&' : '?';
		if($num > $perpage) {
			$page = 10;
			$offset = 2;

			$pages = @ceil($num / $perpage);

			if($page > $pages) {
				$from = 1;
				$to = $pages;
			} else {
				$from = $curpage - $offset;
				$to = $from + $page - 1;
				if($from < 1) {
					$to = $curpage + 1 - $from;
					$from = 1;
					if($to - $from < $page) {
						$to = $page;
					}
				} elseif($to > $pages) {
					$from = $pages - $page + 1;
					$to = $pages;
				}
			}

			$multipage = ($curpage - $offset > 1 && $pages > $page ? '<a href="'.$mpurl.'page=1" class="first"'.$ajaxtarget.'>1 ...</a>' : '').
			($curpage > 1 && !$simple ? '<a href="'.$mpurl.'page='.($curpage - 1).'" class="prev"'.$ajaxtarget.'>&lsaquo;&lsaquo;</a>' : '');
			for($i = $from; $i <= $to; $i++) {
				$multipage .= $i == $curpage ? '<strong>'.$i.'</strong>' :
				'<a href="'.$mpurl.'page='.$i.($ajaxtarget && $i == $pages && $autogoto ? '#' : '').'"'.$ajaxtarget.'>'.$i.'</a>';
			}

			$multipage .= ($curpage < $pages && !$simple ? '<a href="'.$mpurl.'page='.($curpage + 1).'" class="next"'.$ajaxtarget.'>&rsaquo;&rsaquo;</a>' : '').
			($to < $pages ? '<a href="'.$mpurl.'page='.$pages.'" class="last"'.$ajaxtarget.'>... '.$realpages.'</a>' : '').
			(!$simple && $pages > $page && !$ajaxtarget ? '<kbd><input type="text" name="custompage" size="3" onkeydown="if(event.keyCode==13) {window.location=\''.$mpurl.'page=\'+this.value; return false;}" /></kbd>' : '');
		}
		return $multipage;
	}
	/**
	 * 对翻页的起始位置进行判断和调整
	 *
	 * @param int $page 页码
	 * @param int $ppp 每页大小
	 * @param int $totalnum 总纪录数
	 * @return unknown
	 */

	function page_get_start($page, $ppp, $totalnum) {
		$totalpage = ceil($totalnum / $ppp);
		$page =  max(1, min($totalpage, intval($page)));
		return ($page - 1) * $ppp;
	}
		/**
	 * 对字符或者数组加逗号连接, 用来
	 *
	 * @param string/array $arr 可以传入数字或者字串
	 * @return string 这样的格式: '1','2','3'
	 */
	function timplode($arr) {
		return "'".implode("','", (array)$arr)."'";
	}
	
	function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {

	$ckey_length = 4;

	$key = md5($key ? $key : TM_KEY);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);

	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);

	$result = '';
	$box = range(0, 255);

	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}

	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}

	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}

	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		return $keyc.str_replace('=', '', base64_encode($result));
	}

}
function writesql( $file, $content )
{
	$fp = fopen( $file, "a+" );
	flock( $fp, 2 );
	fwrite( $fp, $content );
	fclose( $fp );
}
function delete_file($file){
	$delete = @unlink($file);
	clearstatcache();
	if(@file_exists($file)){
		$filesys = eregi_replace("/","//",$file);
		$delete = @system("del $filesys");
		clearstatcache();
		if(@file_exists($file)){
			$delete = @chmod ($file, 0777);
			$delete = @unlink($file);
			$delete = @system("del $filesys");
			}
		}
		clearstatcache();
		if(@file_exists($file)){
			return false;
		}else{
			return true;
	}
}
?>