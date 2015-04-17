<?php
/**
 * 后台管理 通用函数库
 * $Id: function_admincp.php 27 2010-11-20 11:33:10Z $ 
 */

//对话框
function cpmessage($msgkey, $url_forward='', $second=1, $values=array()) {
    global $_SGLOBAL, $_SC, $_SCONFIG, $_TPL, $_SN, $space;
    
    //去掉广告
    $_SGLOBAL['ad'] = array();

    include_once(S_ROOT . './language/lang_cpmessage.php');
    if(isset($_SGLOBAL['cplang'][$msgkey])) {
        $message = lang_replace($_SGLOBAL['cplang'][$msgkey], $values);
    } else {
        $message = $msgkey;
    }
    
    //显示
    obclean();
    
    //菜单激活
    $menuactive = array('index' => ' class="active"');
    
    if(!empty($url_forward)) {
        $second = $second * 1000;
        $message .= "<script>setTimeout(\"window.location.href ='$url_forward';\", $second);</script>";
    }
    include template('admin/tpl/showmessage');
    exit();
}

//生成站点key
function mksitekey() {
    global $_SERVER, $_SC, $_SGLOBAL;
    //16位
    $sitekey = substr(md5($_SERVER['SERVER_ADDR'].$_SERVER['HTTP_USER_AGENT'].$_SC['dbhost'].$_SC['dbuser'].$_SC['dbpw'].$_SC['dbname'].substr($_SGLOBAL['timestamp'], 0, 6)), 8, 6).random(10);
    return $sitekey;
}


//统计数据
function getstatistics() {
    global $_SGLOBAL, $_SC, $_SCONFIG;
    
    $dbsize = 0;
    $query = $_SGLOBAL['db']->query("SHOW TABLE STATUS LIKE '$_SC[tablepre]%'", 'SILENT');
    while($table = $_SGLOBAL['db']->fetch_array($query)) {
        $dbsize += $table['Data_length'] + $table['Index_length'];
    }
    $sitekey = trim($_SCONFIG['sitekey']);
    if(empty($sitekey)) {
        $sitekey = mksitekey();
        $_SGLOBAL['db']->query("REPLACE INTO ".tname('config')." (var, datavalue) VALUES ('sitekey', '$sitekey')");
        include_once(S_ROOT.'./source/function_cache.php');
        config_cache(false);
    }
    $statistics = array(
        'sitekey' => $sitekey,
        'version' => X_VER,
        'release' => X_RELEASE,
        'php' => PHP_VERSION,
        'mysql' => $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT VERSION()"), 0),
        'dbsize' => $dbsize,
        'charset' => $_SC['charset'],
        'sitename' => preg_replace('/[\'\"\s]/s', '', $_SCONFIG['sitename']),
        'feednum' => getcount('feed', array()),
        'blognum' => getcount('blog', array()),
        'albumnum' => getcount('pic', array()),
        'threadnum' => getcount('thread', array()),
        'sharenum' => getcount('share', array()),
        'commentnum' => getcount('comment', array()),
        'myappnum' => getcount('myapp', array()),
        'spacenum' => getcount('space', array())
    );
    $statistics['update'] = rawurlencode(serialize($statistics)).'&h='.substr(md5($_SERVER['HTTP_USER_AGENT'].'|'.implode('|', $statistics)), 8, 8);

    return $statistics;
}

//日志
function admincp_log() {
    global $_GET, $_POST;
    
    $log_message = '';
    if($_GET) {
        $log_message .= 'GET{';
        foreach ($_GET as $g_k => $g_v) {
            $g_v = is_array($g_v)?serialize($g_v):$g_v;
            $log_message .= "{$g_k}={$g_v};";
        }
        $log_message .= '}';
    }
    if($_POST) {
        $log_message .= 'POST{';
        foreach ($_POST as $g_k => $g_v) {
            $g_v = is_array($g_v)?serialize($g_v):$g_v;
            $log_message .= "{$g_k}={$g_v};";
        }
        $log_message .= '}';
    }
    runlog('admincp', $log_message);
}

//颜色交叉
function mkcolor($color1='#FFFFFF', $color2='#FCF9E6') {
    global $_SGLOBAL;

    $_SGLOBAL['_color'] == $color1?$_SGLOBAL['_color'] = $color2:$_SGLOBAL['_color'] = $color1;
    return $_SGLOBAL['_color'];
}

/**
 * 图片上传方法
 * return src;
 */
function upload($upfile, $maxsize, $updir)
{
    global $_SGLOBAL;
    $name     = $upfile["name"];
    $type     = $upfile["type"];
    $size     = $upfile["size"];
    $tmp_name = $upfile["tmp_name"];
    $error    = $upfile["error"]; 
    $newname = substr(md5($name . $_SGLOBAL['timestamp']), 0, 20);

    switch($type){
        case 'image/pjpeg' :
        case 'image/jpeg'  : $extend=".jpg"; break;
        case 'image/gif'   : $extend=".gif"; break;
        case 'image/png'   : $extend=".png"; break;
    }
    if (empty($extend)) {
        showmessage("警告！只能上传图片类型：GIF JPG PNG", '');
        exit;
    }
    if ($size > $maxsize && false) {
        $maxpr = $maxsize/1000;
        showmessage("警告！上传图片大小不能超过" . $maxpr . "K!", '');
        exit;
    }

    $destfile = S_ROOT . $updir . $newname . $extend;

    if ($error == 0 && move_uploaded_file($tmp_name, $destfile)) {
        return $updir . $newname . $extend;
    }
}
/**
 * 递归创建文件目录
 * @param $dir
 * @return bool
 */
function forceDirectory($dir)
{
    return is_dir($dir) || (forceDirectory(dirname($dir)) && mkdir($dir, 0777));
}
?>