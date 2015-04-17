<?php
/**
 * 【极客】站点配置文件
 * $Id: config.php-dist 27 2009-09-25 11:33:10Z wukai$ 
 */

//Ucenter Home配置参数
//190 测试机

$_SC = array();
$_SC['dbhost']          = '127.0.0.1'; //服务器地址
$_SC['dbuser']          = 'root'; //用户
$_SC['dbpw']            = 'xiaolang'; //密码
$_SC['dbcharset']       = 'gbk'; //字符集
$_SC['pconnect']        = 0; //是否持续连接
$_SC['dbname']          = 'shuodao'; //数据库
$_SC['tablepre']        = ''; //表名前缀
$_SC['charset']         = 'gbk'; //页面字符集

$_SC['gzipcompress']    = 0; //启用gzip

$_SC['cookiepre']       = 'sd_'; //COOKIE前缀
$_SC['cookiedomain']    = '.shuodaoer.com'; //COOKIE作用域
$_SC['cookiepath']      = '/'; //COOKIE作用路径
/*modify*/
$_SC['attachdir']       = 'attachments\\'; //附件本地保存位置(服务器路径, 属性 777, 必须为 web 可访问到的目录, 相对目录务必以 "./" 开头, 末尾加 "/")

$_SC['siteurl']         = 'http://www.shuodaoer.com/'; //站点的访问URL地址(http:// 开头的绝对地址, 末尾加 "/")，为空的话，系统会自动识别。
$_SC['attachurl']       = $_SC['siteurl'].'attachments/'; //附件本地URL地址(可为当前 URL 下的相对地址或 http:// 开头的绝对地址, 末尾加 "/")


$_SC['tplrefresh']      = 0; //判断模板是否更新的效率等级，数值越大，效率越高; 设置为0则永久不判断

//Ucenter Home安全相关
$_SC['founder']         = '24050324'; //创始人 UID, 可以支持多个创始人，之间使用 “,” 分隔。部分管理功能只有创始人才可操作。
$_SC['allowedittpl']    = 0; //是否允许在线编辑模板。为了服务器安全，强烈建议关闭

/*gaohua*/
$_SC['cookieexpire'] = '315360000';
$_SC['cssdir'] = $_SC['siteurl'].'css/';
$_SC['jsdir'] = $_SC['siteurl'].'js/';
$_SC['imgdir'] = $_SC['siteurl'].'images/';
$_SC['email_msg']

 = '
<pre>
感谢你注册说道儿! 

你的登录邮箱为:

<<LOGIN_NAME>>

请马上点击以下注册确认链接，激活你的说道儿帐号！ 

<<ACTIVE_LINK>>

（该链接在48小时内有效，48小时需要重新注册） 

如果以上链接无法访问，请将该网址复制并粘贴至新的浏览器窗口中。  

如果你错误地收到了此电子邮件，你无需执行任何操作来取消帐号！此帐号将不会启动。 

这只是一封系统自动发出的邮件，请不要直接回复。</pre> ';
$_SC['rand'] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

?>
