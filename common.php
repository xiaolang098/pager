<?php
/**
 * 【极客】库文件初始化
 * $Id: common.php 27 2010-09-25 11:33:10Z wukai$ 
 */

@define('IN_UCHOME', TRUE);
define('D_BUG', '1');
define('SQL_BUG', '0');
define("MEM_CACHE", true); //是否开启memcache缓存, true为开启, false为关闭
define('URL_REWRITE', false);

D_BUG ? error_reporting(7) : error_reporting(0);
set_magic_quotes_runtime(0);

$_SGLOBAL = $_SCONFIG = $_SCOOKIE = $_SN = $_SBLOCK = $_TPL = $_SPACE = array();

//程序目录
define('S_ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);
include_once S_ROOT . '/config.php';
include_once S_ROOT . './source/function_common.php';

//时间
$mtime = explode(' ', microtime());
$_SGLOBAL['timestamp'] = $mtime[1];
$_SGLOBAL['supe_starttime'] = $_SGLOBAL['timestamp'] + $mtime[0];

//本站URL
if(empty($_SC['siteurl'])) $_SC['siteurl'] = getsiteurl();

//GPC过滤
$magic_quote = get_magic_quotes_gpc();
if(empty($magic_quote)) {
    $_GET = saddslashes($_GET);
    $_POST = saddslashes($_POST);
}

//链接数据库
dbconnect();

//链接uctner数据库
//dbconnect_uc(UC_DBHOST,UC_DBUSER,UC_DBPW,UC_DBNAME,0);

//缓存文件
if(!@include_once(S_ROOT . './data/data_config.php')) {
    include_once(S_ROOT . './source/function_cache.php');
    config_cache();
    include_once(S_ROOT . './data/data_config.php');
}
/*
//文章分类缓存
if(!@include_once(S_ROOT . './data/data_articletype.php')) {
    include_once S_ROOT . './source/function_cache.php';
    articletype_cache();
    include_once(S_ROOT . './data/data_articletype.php');
}
*/
//COOKIE
$prelength = strlen($_SC['cookiepre']);
foreach($_COOKIE as $key => $val) {
    if(substr($key, 0, $prelength) == $_SC['cookiepre']) {
        $_SCOOKIE[(substr($key, $prelength))] = empty($magic_quote) ? saddslashes($val) : $val;
    }
}

//初始化
$_SGLOBAL['supe_uid'] = 0;
$_SGLOBAL['supe_username'] = '';
$_SGLOBAL['inajax'] = empty($_GET['inajax']) ? 0 : intval($_GET['inajax']);
$_SGLOBAL['ajaxmenuid'] = empty($_GET['ajaxmenuid']) ? '' : $_GET['ajaxmenuid'];
$_SGLOBAL['refer'] = empty($_SERVER['HTTP_REFERER']) ? '' : $_SERVER['HTTP_REFERER'];

//取消翻页限制
$_SCONFIG['maxpage'] = 0;

//登录注册防灌水机
//if(empty($_SCONFIG['login_action'])) $_SCONFIG['login_action'] = md5('login'.md5($_SCONFIG['sitekey']));
//if(empty($_SCONFIG['register_action'])) $_SCONFIG['register_action'] = md5('register'.md5($_SCONFIG['sitekey']));

//处理REQUEST_URI
if(!isset($_SERVER['REQUEST_URI'])) {  
    $_SERVER['REQUEST_URI'] = $_SERVER['PHP_SELF'];
    if(isset($_SERVER['QUERY_STRING'])) $_SERVER['REQUEST_URI'] .= '?'.$_SERVER['QUERY_STRING'];
}
if($_SERVER['REQUEST_URI']) {
    $temp = urldecode($_SERVER['REQUEST_URI']);
    if(strexists($temp, '<') || strexists($temp, '"')) {
        $_GET = shtmlspecialchars($_GET);//XSS
    }
}

//判断用户登录状态
checkauth();
$_SGLOBAL['uhash'] = md5($_SGLOBAL['supe_uid']."\t".substr($_SGLOBAL['timestamp'], 0, 6));

//调整输出
ob_out();
