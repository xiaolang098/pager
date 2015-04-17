<?php
/**
 * 【极客】共用函数库
 * $Id: function_common.php 27 2010-09-25 11:33:10Z wukai$
 */

if(!defined('IN_UCHOME')) {
    exit('Access Denied');
}

//数据库连接
function dbconnect() {
    global $_SGLOBAL, $_SC;

    include_once(S_ROOT . './source/class_mysql.php');

    if(empty($_SGLOBAL['db'])) {
        $_SGLOBAL['db'] = new dbstuff;
        $_SGLOBAL['db']->charset = $_SC['dbcharset'];
        $_SGLOBAL['db']->connect($_SC['dbhost'], $_SC['dbuser'], $_SC['dbpw'], $_SC['dbname'], $_SC['pconnect']);
    }
}

//数据库连接
function dbconnect_uc($dbhost, $dbuser, $dbpw, $dbname, $pconnect) {
    global $_SGLOBAL, $_SC;

    include_once(S_ROOT . './source/class_mysql.php');

    if(empty($_SGLOBAL['db_uc'])) {
        $_SGLOBAL['db_uc'] = new dbstuff;
        $_SGLOBAL['db_uc']->charset = $_SC['dbcharset'];
        $_SGLOBAL['db_uc']->connect($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
    }
}

//获取到表名
function tname($name) {
    global $_SC;
    return $_SC['tablepre'] . $name;
}

//连接字符
function simplode($ids) {
    return "'".implode("','", $ids)."'";
}

//SQL ADDSLASHES
function saddslashes($string) {
    if(is_array($string)) {
        foreach($string as $key => $val) {
            $string[$key] = saddslashes($val);
        }
    } else {
        $string = addslashes($string);
    }
    return $string;
}

//获取站点链接
function getsiteurl() {
    global $_SCONFIG;

    if(empty($_SCONFIG['siteallurl'])) {
        //$uri = $_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : ($_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME']);
        return shtmlspecialchars('http://' . $_SERVER['HTTP_HOST'] . '/');
    } else {
        return $_SCONFIG['siteallurl'];
    }
}

//处理搜索关键字
function stripsearchkey($string) {
    $string = trim($string);
    $string = str_replace('*', '%', addcslashes($string, '%_'));
    $string = str_replace('_', '\_', $string);
    return $string;
}

//去掉slassh
function sstripslashes($string) {
    if(is_array($string)) {
        foreach($string as $key => $val) {
            $string[$key] = sstripslashes($val);
        }
    } else {
        $string = stripslashes($string);
    }
    return $string;
}

//编码转换
function siconv($str, $out_charset, $in_charset='') {
    global $_SC;

    $in_charset = empty($in_charset) ? strtoupper($_SC['charset']) : strtoupper($in_charset);
    $out_charset = strtoupper($out_charset);
    if($in_charset != $out_charset) {
        if (function_exists('iconv') && (@$outstr = iconv("$in_charset//IGNORE", "$out_charset//IGNORE", $str))) {
            return $outstr;
        } elseif (function_exists('mb_convert_encoding') && (@$outstr = mb_convert_encoding($str, $out_charset, $in_charset))) {
            return $outstr;
        }
    }
    return $str;//转换失败
}

//字符串时间化
function sstrtotime($string) {
    global $_SGLOBAL, $_SCONFIG;
    $time = '';
    if($string) {
        $time = strtotime($string);
        if(gmdate('H:i', $_SGLOBAL['timestamp'] + $_SCONFIG['timeoffset'] * 3600) != date('H:i', $_SGLOBAL['timestamp'])) {
            $time = $time - $_SCONFIG['timeoffset'] * 3600;
        }
    }
    return $time;
}


/*gaohua*/
function checkauth() {
    global $_SGLOBAL, $_SCOOKIE;
    if($_SCOOKIE['auth']) {
        @list($password, $uid) = explode("\t", authcode($_SCOOKIE['auth'], 'DECODE'));
        $_SGLOBAL['supe_uid'] = intval($uid);
        if($password && $_SGLOBAL['supe_uid']) {
            $query = $_SGLOBAL['db']->query("SELECT * FROM " . tname('member') . " WHERE id='$_SGLOBAL[supe_uid]'");
            if($member = $_SGLOBAL['db']->fetch_array($query)) {
                if(!$member['password'] == $password) {
                    $_SGLOBAL['supe_uid'] = 0;
                }
            } else {
                $_SGLOBAL['supe_uid'] = 0;
            }
        }
    }
    if(empty($_SGLOBAL['supe_uid'])) {
        clearcookie();
    } else {
        $_SGLOBAL['username'] = $member['nickname'];
        $_SGLOBAL['email'] = $member['email'];
    }
}

//获取数目
function getcount($tablename, $wherearr=array(), $whererange='', $get='COUNT(*)') {
    global $_SGLOBAL;
    if(empty($wherearr)) {
        $wheresql = '1';
    } else {
        $wheresql = $mod = '';
        foreach ($wherearr as $key => $value) {
            $wheresql .= $mod."`$key`='$value'";
            $mod = ' AND ';
        }
    }
    !empty($whererange) && ($wheresql .= $whererange); //区间范围查询sql OR 特殊处理SQL
    return intval($_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT $get FROM " . tname($tablename) . " WHERE $wheresql LIMIT 1"), 0));
}


//判断提交是否正确
function submitcheck($var) {
    if(!empty($_POST[$var]) && $_SERVER['REQUEST_METHOD'] == 'POST') {
        if((empty($_SERVER['HTTP_REFERER']) || preg_replace("/https?:\/\/([^\:\/]+).*/i", "\\1", $_SERVER['HTTP_REFERER']) == preg_replace("/([^\:]+).*/", "\\1", $_SERVER['HTTP_HOST'])) && $_POST['formhash'] == formhash()) {
            return true;
        } else {
            showmessage('submit_invalid');
        }
    } else {
        return false;
    }
}

//产生form防伪码
function formhash() {
    global $_SGLOBAL, $_SCONFIG;

    if(empty($_SGLOBAL['formhash'])) {
        $hashadd = defined('IN_ADMINCP') ? 'Only For UCenter Home AdminCP' : '';
        $_SGLOBAL['formhash'] = substr(md5(substr($_SGLOBAL['timestamp'], 0, -7) . '|' . $_SGLOBAL['supe_uid'] . '|' . md5($_SCONFIG['sitekey']) . '|' . $hashadd), 8, 8);
    }
    return $_SGLOBAL['formhash'];
}


//对话框
function showmessage($msgkey, $url_forward = '', $second=1, $values = array()) {
    global $_SGLOBAL, $_SC, $_SCONFIG, $_TPL, $space, $_SN;

    obclean();

    //去掉广告
    $_SGLOBAL['ad'] = array();
    
    //语言
    include_once(S_ROOT . './language/lang_showmessage.php');
    if(isset($_SGLOBAL['msglang'][$msgkey])) {
        $message = lang_replace($_SGLOBAL['msglang'][$msgkey], $values);
    } else {
        $message = $msgkey;
    }
    //显示
    if(empty($_SGLOBAL['inajax']) && $url_forward && empty($second)) {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: $url_forward");
    } else {
        if($_SGLOBAL['inajax']) {
            if($url_forward) {
                $message = "<a href=\"$url_forward\">$message</a><ajaxok>";
            }
            echo $message;
            ob_out();
        } else {
            if($url_forward) {
                $message = "<a href=\"$url_forward\">$message</a><script>setTimeout(\"window.location.href ='$url_forward';\", ".($second*1000).");</script>";
            }
            if($ac == ''){
                $ac = 'index';
            }
            $extracss = uc_relapath();
            include template('showmessage');
        }
    }
    exit();
}
//计算UC相对根目录路径
function uc_relapath()
{
    global $_SC;
    $extra_css_paht = parse_url($_SC['siteurl']);
    $pathi = substr_count($extra_css_paht['path'],'/');
    for($i=0;$i<$pathi;$i++){
        if($i){
            $extrapath .= '../';
        }else{
            $extrapath = './';
        }
    }
    return $extrapath;
}

//字符串解密加密
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {

    $ckey_length = 4;   // 随机密钥长度 取值 0-32;
                // 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
                // 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
                // 当此值为 0 时，则不产生随机密钥

    $key = md5($key ? $key : UC_KEY);
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

//清空cookie
function clearcookie() {
    global $_SGLOBAL, $_SC;

    obclean();
    ssetcookie('auth', '', -86400 * 365);
    setcookie('sso_token', '', -86400 * 365, '/', $_SC['cookiedomain']);
    setcookie('uchome_auth', '', -86400 * 365, '/', $_SC['cookiedomain']);
    $_SGLOBAL['supe_uid'] = 0;
    $_SGLOBAL['supe_username'] = '';
    $_SGLOBAL['member'] = array();
}

//cookie设置
function ssetcookie($var, $value, $life=0) {
    global $_SGLOBAL, $_SC, $_SERVER;
    setcookie($_SC['cookiepre'] . $var, $value, $life?($_SGLOBAL['timestamp'] + $life) : 0, $_SC['cookiepath'], $_SC['cookiedomain'], $_SERVER['SERVER_PORT'] == 443 ? 1 : 0);
}

//添加数据
function inserttable($tablename, $insertsqlarr, $returnid=0, $replace = false, $silent=0) {
    global $_SGLOBAL;

    $insertkeysql = $insertvaluesql = $comma = '';
    foreach ($insertsqlarr as $insert_key => $insert_value) {
        $insertkeysql .= $comma . '`' . $insert_key . '`';
        $insertvaluesql .= $comma . '\'' . $insert_value . '\'';
        $comma = ', ';
    }
    $method = $replace ? 'REPLACE' : 'INSERT';
    $_SGLOBAL['db']->query($method . ' INTO ' . tname($tablename) . ' (' . $insertkeysql . ') VALUES (' . $insertvaluesql . ')', $silent ? 'SILENT' : '');
    if($returnid && !$replace) {
        return $_SGLOBAL['db']->insert_id();
    }
}

//更新数据
function updatetable($tablename, $setsqlarr, $wheresqlarr, $silent=0) {
    global $_SGLOBAL;

    $setsql = $comma = '';
    foreach ($setsqlarr as $set_key => $set_value) {//fix
        $setsql .= $comma . '`' . $set_key . '`' . '=\'' . $set_value . '\'';
        $comma = ', ';
    }
    $where = $comma = '';
    if(empty($wheresqlarr)) {
        $where = '1';
    } elseif(is_array($wheresqlarr)) {
        foreach ($wheresqlarr as $key => $value) {
            $where .= $comma . '`' . $key . '`' . '=\'' . $value . '\'';
            $comma = ' AND ';
        }
    } else {
        $where = $wheresqlarr;
    }
    $_SGLOBAL['db']->query('UPDATE ' . tname($tablename) . ' SET ' . $setsql . ' WHERE ' . $where, $silent ? 'SILENT' : '');
}

/**
 * 截取指定长度的字符串
 * @param $string $string
 * @param $length
 * @param $dot
 * @return $string
 */
function cutstr($string, $length, $dot = '')
{
    global $_SC;
    if($length && strlen($string) > $length) {
        //截断字符
        $wordscut = '';
        if(strtolower($_SC['charset']) == 'utf-8') {
            //utf8编码
            $n = 0;
            $tn = 0;
            $noc = 0;
            while ($n < strlen($string)) {
                $t = ord($string[$n]);
                if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                    $tn = 1;
                    $n++;
                    $noc++;
                } elseif(194 <= $t && $t <= 223) {
                    $tn = 2;
                    $n += 2;
                    $noc += 2;
                } elseif(224 <= $t && $t < 239) {
                    $tn = 3;
                    $n += 3;
                    $noc += 2;
                } elseif(240 <= $t && $t <= 247) {
                    $tn = 4;
                    $n += 4;
                    $noc += 2;
                } elseif(248 <= $t && $t <= 251) {
                    $tn = 5;
                    $n += 5;
                    $noc += 2;
                } elseif($t == 252 || $t == 253) {
                    $tn = 6;
                    $n += 6;
                    $noc += 2;
                } else {
                    $n++;
                }
                if ($noc >= $length) {
                    break;
                }
            }
            if ($noc > $length) {
                $n -= $tn;
            }
            $wordscut = substr($string, 0, $n);
        } else {
            for($i = 0; $i < $length - 1; $i++) {
                if(ord($string[$i]) > 127) {
                    $wordscut .= $string[$i] . $string[$i + 1];
                    $i++;
                } else {
                    $wordscut .= $string[$i];
                }
            }
        }
        $string = $wordscut.$dot;
    }
    return $string;
}

//判断字符串是否存在
function strexists($haystack, $needle) {
    return !(strpos($haystack, $needle) === FALSE);
}

//模板调用
function template($name) {
    global $_SCONFIG, $_SGLOBAL;
    if(strexists($name, '/')) {
        $tpl = $name;
    } else {
        $tpl = "template/$name";
    }
    $objfile = S_ROOT . './data/tpl_cache/' . str_replace('/', '_', $tpl) . '.php';
    if(!file_exists($objfile)) {
        include_once(S_ROOT . './source/function_template.php');
        parse_template($tpl);
    }
    return $objfile;
}

//子模板更新检查
function subtplcheck($subfiles, $mktime, $tpl) {
    global $_SC, $_SCONFIG;

    if($_SC['tplrefresh'] && ($_SC['tplrefresh'] == 1 || mt_rand(1, $_SC['tplrefresh']) == 1)) {
        $subfiles = explode('|', $subfiles);
        foreach ($subfiles as $subfile) {
            $tplfile = S_ROOT . './' . $subfile . '.htm';
            if(!file_exists($tplfile)) {
                $tplfile = str_replace('/' . $_SCONFIG['template'] . '/', '/default/', $tplfile);
            }
            @$submktime = filemtime($tplfile);
            if($submktime > $mktime) {
                include_once(S_ROOT . './source/function_template.php');
                parse_template($tpl);
                break;
            }
        }
    }
}

//调整输出
function ob_out() {
    global $_SGLOBAL, $_SCONFIG, $_SC;

    $content = ob_get_contents();

    $preg_searchs = $preg_replaces = $str_searchs = $str_replaces = array();

    if($_SCONFIG['allowrewrite']) {
        // space.php?uid=id&do=my&op=publish
        $preg_searchs[] = "/\<a href\=\"\/space\.php\?(do)+\=(my|friend|feed)\&(op)+\=([a-z0-9\=\&]+?)\"/ie";
        $preg_searchs[] = "/\<a href\=\"\/space.php\"/i";

        $preg_searchs[] = "/\<a href\=\"\/space\.php\?(do)+\=(info|passwd|docomment|mycomment|myreply)\"/ie";
        $preg_searchs[] = "/\<a href\=\"\/space.php\"/i";
        
        $preg_searchs[] = "/\<a href\=\"\/space\.php\?(uid)+\=([a-z0-9\=\&]+?)\"/ie";
        $preg_searchs[] = "/\<a href\=\"\/space.php\"/i";
        
        
        //评论 comment.php
        $preg_searchs[] = "/\<a href\=\"\/comment\.php\?(do)+\=([a-z0-9\=\&]+?)\&(page)+\=([a-z0-9\=\&]+?)\"/ie";
        $preg_searchs[] = "/\<a href\=\"\/comment.php\"/i";

        $preg_searchs[] = "/\<a href\=\"\/comment\.php\?(do)+\=([a-z0-9\=\&]+?)\&(id)+\=([a-z0-9\=\&]+?)\"/ie";
        $preg_searchs[] = "/\<a href\=\"\/comment.php\"/i";

        $preg_searchs[] = "/\<a href\=\"\/comment\.php\?(do)+\=([a-z0-9\=\&]+?)\"/ie";
        $preg_searchs[] = "/\<a href\=\"\/comment.php\"/i";
        
        //短消息
        /*$preg_searchs[] = "/\<a href\=\"\/space\.php\?(do)+\=(pm)\&(filter)+\=([a-z0-9\=\&]+?)\"/ie";
        $preg_searchs[] = "/\<a href\=\"\/space.php\"/i";*/

        // index.html index.php?ac=common&od=new&sort=up&page=2
        $preg_searchs[] = "/\<a href\=\"\/index\.php\?(ac|op)+\=([a-z0-9\=\&]+?)\&(od|id)+\=([a-z0-9\=\&]+?)\&(sort)+\=([a-z0-9\=\&]+?)\&(page)+\=([a-z0-9\=\&]+?)\"/ie";
        $preg_searchs[] = "/\<a href\=\"\/index.php\"/i";
        
        //index.php?ac=article&id=1&list=reply&page=1
         $preg_searchs[] = "/\<a href\=\"\/index\.php\?(ac)+\=([a-z0-9\=\&]+?)\&(id)+\=([a-z0-9\=\&]+?)\&(list)+\=([a-z0-9\=\&]+?)\&(page)+\=([a-z0-9\=\&]+?)\"/ie";
        $preg_searchs[] = "/\<a href\=\"\/index.php\"/i";

        //index.php?ac=category&id=$categoryId&od=hot&page=1
        $preg_searchs[] = "/\<a href\=\"\/index\.php\?(ac)+\=([a-z0-9\=\&]+?)\&(id)+\=([a-z0-9\=\&]+?)\&(od)+\=([a-z0-9\=\&]+?)\&(page)+\=([a-z0-9\=\&]+?)\"/ie";
        $preg_searchs[] = "/\<a href\=\"\/index.php\"/i";
        // index.php?ac=tag&id=1&od=new&sort=up
        $preg_searchs[] = "/\<a href\=\"\/index\.php\?(ac|op)+\=([a-z0-9\=\&]+?)\&(id)+\=([a-z0-9\=\&]+?)\&(od)+\=([a-z0-9\=\&]+?)\&(sort)+\=([a-z0-9\=\&]+?)\"/ie";
        $preg_searchs[] = "/\<a href\=\"\/index.php\"/i";

        //index.php?ac=common&od=new&sort=up 分页
        $preg_searchs[] = "/\<a href\=\"\/index\.php\?(ac|op)+\=([a-z0-9\=\&]+?)\&(od)+\=([a-z0-9\=\&]+?)\&(sort)+\=([a-z0-9\=\&]+?)\"/ie";
        $preg_searchs[] = "/\<a href\=\"\/index.php\"/i";
        
        //seo url
        $preg_searchs[] = "/\<a href\=\"\/index\.php\?(ac)+\=(article|category|tag|file)\&(id)+\=([a-z0-9\=\&]+?)\"/ie";
        $preg_searchs[] = "/\<a href\=\"\/index.php\"/i";
        
        $preg_searchs[] = "/\<a href\=\"\/index\.php\?(op)+\=([a-z0-9\=\&]+?)\&(id)+\=([a-z0-9\=\&]+?)\"/ie";
        $preg_searchs[] = "/\<a href\=\"\/index.php\"/i";

        //index.php?ac=common&od=new&page=2分页
        $preg_searchs[] = "/\<a href\=\"\/index\.php\?(ac|op)+\=([a-z0-9\=\&]+?)\&(od)+\=([a-z0-9\=\&]+?)\&(page)+\=([a-z0-9\=\&]+?)\"/ie";
        $preg_searchs[] = "/\<a href\=\"\/index.php\"/i";

        $preg_searchs[] = "/\<a href\=\"\/index\.php\?(op)+\=([a-z0-9\=\&]+?)\"/ie";
        $preg_searchs[] = "/\<a href\=\"\/index.php\"/i";
        

        //////替换
        //////
        // space.php?uid=id&do=my&op=publish
        $preg_replaces[] = 'rewrite_url(\'space-\',\'\\2\',\'\\4\',\'\\6\')';
        $preg_replaces[] = '<a href="space.html"';

        $preg_replaces[] = 'sso_rewrite_url(\'space/\',\'\\2\',\'\\4\')';
        $preg_replaces[] = '<a href="space.html"';

        $preg_replaces[] = 'rewrite_url(\'space-\',\'\\2\')';
        $preg_replaces[] = '<a href="space.html"';
        
        //评论 comment.php

        $preg_replaces[] = 'sso_rewrite_url(\'\\2/\',\'page\',\'\\4\')';
        $preg_replaces[] = '<a href="comment.html"';

        $preg_replaces[] = 'sso_rewrite_url(\'\\2/\',\'\\4\')';
        $preg_replaces[] = '<a href="comment.html"';

        $preg_replaces[] = 'sso_rewrite_url(\'\\2\')';
        $preg_replaces[] = '<a href="comment.html"';


        //短消息
       /* $preg_replaces[] = 'rewrite_url(\'space-\',\'\\2\',\'\\4\')';
        $preg_replaces[] = '<a href="space.html"';*/
        //index.html index.php?ac=common&od=new&sort=up&page=2
        $preg_replaces[] = 'rewrite_url(\'index-\',\'\\2\',\'\\4\',\'\\6\',\'\\8\')';
        $preg_replaces[] = '<a href="index.html"';
        //index.php?ac=article&id=1&page=1&list=reply
        $preg_replaces[] = 'rewrite_url(\'index-\',\'\\2\',\'\\4\',\'\\6\',\'\\8\')';
        $preg_replaces[] = '<a href="index.html"';

        //index.php?ac=category&id=$categoryId&od=hot&page=1
        $preg_replaces[] = 'rewrite_url(\'index-\',\'\\2\',\'\\4\',\'\\6\',\'\\8\')';
        $preg_replaces[] = '<a href="index.html"';
        // index.php?ac=tag&id=1&od=new&sort=up
        $preg_replaces[] = 'rewrite_url(\'index-\',\'\\2\',\'\\4\',\'\\6\',\'\\8\')';
        $preg_replaces[] = '<a href="index.html"';
        //index.php?ac=common&od=new&sort=up
        $preg_replaces[] = 'rewrite_url(\'index-\',\'\\2\',\'\\4\',\'\\6\',\'\\8\')';
        $preg_replaces[] = '<a href="index.html"';

        //sso url
        $preg_replaces[] = 'sso_rewrite_url(\'\\2/\',\'\\4\')';
        $preg_replaces[] = '<a href="index.html"';
        
        $preg_replaces[] = 'rewrite_url(\'index-\',\'\\2\',\'\\4\')';
        $preg_replaces[] = '<a href="index.html"';
        //index.php?ac=common&od=new&page=2分页
        $preg_replaces[] = 'rewrite_url(\'index-\',\'\\2\',\'\\4\',\'\\6\')';
        $preg_replaces[] = '<a href="index.html"';

        $preg_replaces[] = 'rewrite_url(\'index-\',\'\\2\')';
        $preg_replaces[] = '<a href="index.html"';
    }


    if($_SGLOBAL['inajax']) {
        $preg_searchs[] = "/([\x01-\x09\x0b-\x0c\x0e-\x1f])+/";
        $preg_replaces[] = ' ';

        $str_searchs[] = ']]>';
        $str_replaces[] = ']]&gt;';
    }

    if($preg_searchs) {
        $content = preg_replace($preg_searchs, $preg_replaces, $content);
    }
    if($str_searchs) {
        $content = trim(str_replace($str_searchs, $str_replaces, $content));
    }

    obclean();
    if($_SGLOBAL['inajax']) {
        xml_out($content);
    } else{
        if($_SCONFIG['headercharset']) {
            @header('Content-Type: text/html; charset=' . $_SC['charset']);
        }
        echo $content;
        if(SQL_BUG) {
            @include_once(S_ROOT . './source/inc_debug.php');
        }
    }
}

//外链
function iframe_url($url) {
    $url = rawurlencode($url);
    return "<a href=\"link.php?url=http://$url\"";
}
//sso url
function sso_rewrite_url($pre, $para, $four = ''){
    $para = str_replace(array('&','='), array('-', '-'), $para);
    if($four){
       $four = rewrite_url_replace($four);
    }
    if($six){
        $six = rewrite_url_replace($six);
    }
    if($eight){
        $eight = rewrite_url_replace($eight);
    }
    return '<a href="/'.$pre. $para . $four . $six . $eight .'.html"';
}
//rewrite链接
function rewrite_url($pre, $para, $four = '', $six = '', $eight = '') {
    $para = str_replace(array('&','='), array('-', '-'), $para);
    if($four){
       $four = rewrite_url_replace($four);
    }
    if($six){
        $six = rewrite_url_replace($six);
    }
    if($eight){
        $eight = rewrite_url_replace($eight);
    }
    return '<a href="/'.$pre. $para . $four . $six . $eight .'.html"';
}
function rewrite_url_replace($temp){
    $temp = str_replace(array('&','='), array('-', '-'), $temp);
    return "-" . $temp;
}
function shtmlspecialchars($string) {
    if(is_array($string)) {
        foreach($string as $key => $val) {
            $string[$key] = shtmlspecialchars($val);
        }
    } else {
        $string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4})|[a-zA-Z][a-z0-9]{2,5});)/', '&\\1',
            str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string));
    }
    return $string;
}

function xml_out($content) {
    global $_SC;
    @header("Expires: -1");
    @header("Cache-Control: no-store, private, post-check=0, pre-check=0, max-age=0", FALSE);
    @header("Pragma: no-cache");
    @header("Content-type: application/xml; charset=$_SC[charset]");
    echo '<'."?xml version=\"1.0\" encoding=\"$_SC[charset]\"?>\n";
    echo "<root><![CDATA[" . trim($content) . "]]></root>";
    exit();
}

//ob
function obclean() {
    global $_SC;

    ob_end_clean();
    if ($_SC['gzipcompress'] && function_exists('ob_gzhandler')) {
        ob_start('ob_gzhandler');
    } else {
        ob_start();
    }
}

//获得前台语言
function lang($key, $vars=array()) {
    global $_SGLOBAL;

    include_once(S_ROOT . './language/lang_source.php');
    if(isset($_SGLOBAL['sourcelang'][$key])) {
        $result = lang_replace($_SGLOBAL['sourcelang'][$key], $vars);
    } else {
        $result = $key;
    }
    return $result;
}

//获得后台语言
function cplang($key, $vars=array()) {
    global $_SGLOBAL;

    include_once(S_ROOT . './language/lang_cp.php');
    if(isset($_SGLOBAL['cplang'][$key])) {
        $result = lang_replace($_SGLOBAL['cplang'][$key], $vars);
    } else {
        $result = $key;
    }
    return $result;
}

//语言替换
function lang_replace($text, $vars) {
    if($vars) {
        foreach ($vars as $k => $v) {
            $rk = $k + 1;
            $text = str_replace('\\'.$rk, $v, $text);
        }
    }
    return $text;
}

//时间格式化
function sgmdate($dateformat, $timestamp='', $format=0) {
    global $_SCONFIG, $_SGLOBAL;
    if(empty($timestamp)) {
        $timestamp = $_SGLOBAL['timestamp'];
    }
    $timeoffset = strlen($_SGLOBAL['member']['timeoffset']) > 0 ? intval($_SGLOBAL['member']['timeoffset']) : intval($_SCONFIG['timeoffset']);
    $result = '';
    if($format) {
        $time = $_SGLOBAL['timestamp'] - $timestamp;
        //$result = gmdate($dateformat, $timestamp + $timeoffset * 3600);正常显示时间
        if($time > 12*30*7*24*3600) {
            $result = intval($time/(12*30*7*24*3600)) . lang('year') . lang('before');
        } elseif ($time > 30*7*24*3600) {
            $result = intval($time/(30*7*24*3600)) . lang('month') . lang('before');
        } elseif ($time > 7*24*3600) {
            $result = intval($time/(7*24*3600)) . lang('week') . lang('before');
        } elseif ($time > 24*3600) {
            $result = intval($time/(24*3600)) . lang('day') . lang('before');
        } elseif ($time > 3600) {
            $result = intval($time/3600) . lang('hour') . lang('before');
        } elseif ($time > 60) {
            $result = intval($time/60) . lang('minute') . lang('before');
        } elseif ($time > 0) {
            $result = $time . lang('second') . lang('before');
        } else {
            $result = lang('now');
        }
    } else {
        $result = gmdate($dateformat, $timestamp + $timeoffset * 3600);
    }
    return $result;
}

//获取数据
function data_get($var, $isarray=0) {
    global $_SGLOBAL;

    $query = $_SGLOBAL['db']->query("SELECT * FROM " . tname('data') . " WHERE var='$var' LIMIT 1");
    if($value = $_SGLOBAL['db']->fetch_array($query)) {
        return $isarray ? $value : $value['datavalue'];
    } else {
        return '';
    }
}

//更新数据
function data_set($var, $datavalue, $clean=0) {
    global $_SGLOBAL;

    if($clean) {
        $_SGLOBAL['db']->query("DELETE FROM " . tname('data') . " WHERE var='$var'");
    } else {
        if(is_array($datavalue)) $datavalue = serialize(sstripslashes($datavalue));
        $_SGLOBAL['db']->query("REPLACE INTO " . tname('data') . " (var, datavalue, dateline) VALUES ('$var', '" . addslashes($datavalue) . "', '$_SGLOBAL[timestamp]')");
    }
}

//自定义分页
function mob_perpage($perpage) {
    $newperpage = isset($_GET['perpage']) ? intval($_GET['perpage']) : 0;
    if($newperpage>0 && $newperpage < 500) {
        $perpage = $newperpage;
    }
    return $perpage;
}

//检查start
function ckstart($start, $perpage) {
    global $_SCONFIG;

    $maxstart = $perpage * intval($_SCONFIG['maxpage']);
    if($start < 0 || ($maxstart > 0 && $start >= $maxstart)) {
        showmessage('length_is_not_within_the_scope_of');
    }
}

/**
 * 分页
 * @param $num
 * @param $perpage
 * @param $curpage
 * @param $mpurl
 * @param $style  0为index样式, 1为我的极客样式, 2为短消息样式
 * @param $todiv
 * @return html页码
 */
function multi($num, $perpage, $curpage, $mpurl, $style = 0, $todiv='') {
    global $_SCONFIG, $_SGLOBAL;

    $page = 5;
    if($_SGLOBAL['showpage']) $page = $_SGLOBAL['showpage'];

    $multipage = '';
    $mpurl .= strpos($mpurl, '?') ? '&' : '?';
    $realpages = 1;
    if($num > $perpage) {
        $offset = 2;
        $realpages = @ceil($num / $perpage);
        $pages = $_SCONFIG['maxpage'] && $_SCONFIG['maxpage'] < $realpages ? $_SCONFIG['maxpage'] : $realpages;
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
            } elseif ($to > $pages) {
                $from = $pages - $page + 1;
                $to = $pages;
            }
        }
        if($style == 0) {
            $multipage .= "<div class='page'>";
            $urlplus = $todiv ? "#$todiv" : '';
            if($curpage < $pages) {
                $multipage .= "<a ";
                $multipage .= "href=\"{$mpurl}page=" . ($curpage+1) . "{$urlplus}\"";
                $multipage .= " class=\"next\"></a>";
            }
            if($curpage > 1) {
                $multipage .= "<a ";
                $multipage .= "href=\"{$mpurl}page=" . ($curpage-1) . "$urlplus\"";
                $multipage .= " class=\"s\"></a>";
            }
            $multipage .= "</div>";
        } else if ($style == 1) {
            $multipage .= "<dl class='page1'><dt><a href='#' class='top'></a></dt><dd>";
            $urlplus = $todiv ? "#$todiv" : '';
            if($curpage - $offset > 1 && $pages > $page) {
                $multipage .= "<a ";
                $multipage .= "href=\"{$mpurl}page=1{$urlplus}\"";
                $multipage .= " class=\"here\">1 ...</a>";
            }
            if($curpage > 1) {
                $multipage .= "<a ";
                $multipage .= "href=\"{$mpurl}page=".($curpage-1)."$urlplus\"";
                $multipage .= " class=\"up\"></a>";
            }
            for($i = $from; $i <= $to; $i++) {
                if($i == $curpage) {
                    $multipage .= '<a class="here">'.$i.'</a>';
                } else {
                    $multipage .= "<a ";
                    $multipage .= "href=\"{$mpurl}page=$i{$urlplus}\"";
                    $multipage .= ">$i</a>";
                }
            }
            if($curpage < $pages) {
                $multipage .= "<a ";
                $multipage .= "href=\"{$mpurl}page=".($curpage+1)."{$urlplus}\"";
                $multipage .= " class=\"down\"></a>";
            }
            if($to < $pages) {
                $multipage .= "<a ";
                $multipage .= "href=\"{$mpurl}page=$pages{$urlplus}\"";
                $multipage .= " class=\"last\">... $realpages</a></dd></dl>";
            }
        } else if ($style == 2) {
            $multipage .= '<dd>';
            $urlplus = $todiv ? "#$todiv" : '';
            if($curpage > 1) {
                $multipage .= "<a ";
                $multipage .= "href=\"{$mpurl}page=".($curpage-1)."$urlplus\"";
                $multipage .= " class=\"prev\">&lsaquo;&lsaquo;</a>";
            }
            if($curpage - $offset > 1 && $pages > $page) {
                $multipage .= "<a ";
                $multipage .= "href=\"{$mpurl}page=1{$urlplus}\"";
                $multipage .= " class=\"first\">1</a><div> ... </div>";
            }
            for($i = $from; $i <= $to; $i++) {
                if($i == $curpage) {
                    $multipage .= "<a ";
                    $multipage .= "href=\"{$mpurl}page=".($curpage)."{$urlplus}\"";
                    $multipage .= ' class="here">'.$i.'</a>';
                } else {
                    $multipage .= "<a ";
                    $multipage .= "href=\"{$mpurl}page=$i{$urlplus}\"";
                    $multipage .= ">$i</a>";
                }
            }
            if($to < $pages) {
                $multipage .= "<div>... </div>";
                $multipage .= "<a href=\"{$mpurl}page=$pages{$urlplus}\"";
                $multipage .= " class=\"last\">$realpages</a>";
            }
            if($curpage < $pages) {
                $multipage .= "<a ";
                $multipage .= "href=\"{$mpurl}page=".($curpage+1)."{$urlplus}\"";
                $multipage .= " class=\"next\">&rsaquo;&rsaquo;</a>";
            }
            $multipage .= '</dd>';
        }
    }
    return $multipage;
}

//处理分页
function smulti($start, $perpage, $count, $url, $ajaxdiv='') {
    global $_SGLOBAL;

    $multi = array('last'=>-1, 'next'=>-1, 'begin'=>-1, 'end'=>-1, 'html'=>'');
    if($start > 0) {
        if(empty($count)) {
            showmessage('no_data_pages');
        } else {
            $multi['last'] = $start - $perpage;
        }
    }

    $showhtml = 0;
    if($count == $perpage) {
        $multi['next'] = $start + $perpage;
    }
    $multi['begin'] = $start + 1;
    $multi['end'] = $start + $count;

    if($multi['begin'] >= 0) {
        if($multi['last'] >= 0) {
            $showhtml = 1;
            if($_SGLOBAL['inajax']) {
                $multi['html'] .= "<a href=\"javascript:;\" onclick=\"ajaxget('$url&ajaxdiv=$ajaxdiv', '$ajaxdiv')\">|&lt;</a> <a href=\"javascript:;\" onclick=\"ajaxget('$url&start=$multi[last]&ajaxdiv=$ajaxdiv', '$ajaxdiv')\">&lt;</a> ";
            } else {
                $multi['html'] .= "<a href=\"$url\">|&lt;</a> <a href=\"$url&start=$multi[last]\">&lt;</a> ";
            }
        } else {
            $multi['html'] .= "&lt;";
        }
        $multi['html'] .= " $multi[begin]~$multi[end] ";
        if($multi['next'] >= 0) {
            $showhtml = 1;
            if($_SGLOBAL['inajax']) {
                $multi['html'] .= " <a href=\"javascript:;\" onclick=\"ajaxget('$url&start=$multi[next]&ajaxdiv=$ajaxdiv', '$ajaxdiv')\">&gt;</a> ";
            } else {
                $multi['html'] .= " <a href=\"$url&start=$multi[next]\">&gt;</a>";
            }
        } else {
            $multi['html'] .= " &gt;";
        }
    }

    return $showhtml?$multi['html']:'';
}

//检查是否操作创始人
function ckfounder($uid) {
    global $_SC;

    $founders = empty($_SC['founder']) ? array() : explode(',', $_SC['founder']);
    if($uid && $founders) {
        return in_array($uid, $founders);
    } else {
        return false;
    }
}

//获取文件内容
function sreadfile($filename) {
    $content = '';
    if(function_exists('file_get_contents')) {
        @$content = file_get_contents($filename);
    } else {
        if(@$fp = fopen($filename, 'r')) {
            @$content = fread($fp, filesize($filename));
            @fclose($fp);
        }
    }
    return $content;
}

//获取目录
function sreaddir($dir, $extarr=array()) {
    $dirs = array();
    if($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            if(!empty($extarr) && is_array($extarr)) {
                if(in_array(strtolower(fileext($file)), $extarr)) {
                    $dirs[] = $file;
                }
            } else if($file != '.' && $file != '..') {
                $dirs[] = $file;
            }
        }
        closedir($dh);
    }
    return $dirs;
}

//写入文件
function swritefile($filename, $writetext, $openmod='w') {
    if(@$fp = fopen($filename, $openmod)) {
        flock($fp, 2);
        fwrite($fp, $writetext);
        fclose($fp);
        return true;
    } else {
        runlog('error', "File: $filename write error.");
        return false;
    }
}

//获取在线IP
function getonlineip($format = 0) {
    global $_SGLOBAL;

    if(empty($_SGLOBAL['onlineip'])) {
        if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
            $onlineip = getenv('HTTP_CLIENT_IP');
        } elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
            $onlineip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
            $onlineip = getenv('REMOTE_ADDR');
        } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
            $onlineip = $_SERVER['REMOTE_ADDR'];
        }
        preg_match("/[\d\.]{7,15}/", $onlineip, $onlineipmatches);
        $_SGLOBAL['onlineip'] = $onlineipmatches[0] ? $onlineipmatches[0] : 'unknown';
    }
    if($format) {
        $ips = explode('.', $_SGLOBAL['onlineip']);
        for($i=0;$i<3;$i++) {
            $ips[$i] = intval($ips[$i]);
        }
        return sprintf('%03d%03d%03d', $ips[0], $ips[1], $ips[2]);
    } else {
        return $_SGLOBAL['onlineip'];
    }
}

//写运行日志
function runlog($file, $log, $halt=0) {
    global $_SGLOBAL, $_SERVER;

    $nowurl = $_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : ($_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME']);
    $log = sgmdate('Y-m-d H:i:s', $_SGLOBAL['timestamp']) 
           . "\t$type\t" . getonlineip() 
           . "\t$_SGLOBAL[supe_uid]\t{$nowurl}\t" 
           . str_replace(array("\r", "\n"), array(' ', ' '), trim($log)) 
           . "\n";
    $yearmonth = sgmdate('Ym', $_SGLOBAL['timestamp']);
    $logdir = './data/log/';
    if(!is_dir($logdir)) mkdir($logdir, 0777);
    $logfile = $logdir . $yearmonth . '_' . $file . '.php';
    if(@filesize($logfile) > 2048000) {
        $dir = opendir($logdir);
        $length = strlen($file);
        $maxid = $id = 0;
        while($entry = readdir($dir)) {
            if(strexists($entry, $yearmonth . '_' . $file)) {
                $id = intval(substr($entry, $length + 8, -4));
                $id > $maxid && $maxid = $id;
            }
        }
        closedir($dir);
        $logfilebak = $logdir . $yearmonth . '_' . $file . '_' . ($maxid + 1) . '.php';
        @rename($logfile, $logfilebak);
    }
    if($fp = @fopen($logfile, 'a')) {
        @flock($fp, 2);
        fwrite($fp, "<?PHP exit;?>\t" . str_replace(array('<?', '?>', "\r", "\n"), '', $log) . "\n");
        fclose($fp);
    }
    if($halt) exit();
}

//生成静态页
 function pubcontent($filename, $content)
 {
        $parthinfo = pathinfo($filename);
//        if(!mkdir_recursive($parthinfo['dirname'],0775)){
//            throw new Exception("目录".$parthinfo['dirname']."不存在或创建失败!\r\n");
//        }
        file_put_contents($filename, $content);
        return true;
 }


function dreferer($default = '') {
    global $referer, $indexname;

    $default = empty($default) ? $indexname : '';
    if(empty($referer) && isset($GLOBALS['_SERVER']['HTTP_REFERER'])) {
        $referer = preg_replace("/([\?&])((sid\=[a-z0-9]{6})(&|$))/i", '\\1', $GLOBALS['_SERVER']['HTTP_REFERER']);
        $referer = substr($referer, -1) == '?' ? substr($referer, 0, -1) : $referer;
    } else {
        $referer = dhtmlspecialchars($referer);
    }

    if(strpos($referer, 'logging.php')) {
        $referer = $default;
    }
    return $referer;
}

function dhtmlspecialchars($string) {
    if(is_array($string)) {
        foreach($string as $key => $val) {
            $string[$key] = dhtmlspecialchars($val);
        }
    } else {
        $string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4}));)/', '&\\1',
        //$string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4})|[a-zA-Z][a-z0-9]{2,5});)/', '&\\1',
        str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string));
    }
    return $string;
}

    
function dfopen($url, $limit = 0, $post = '', $cookie = '', $bysocket = FALSE, $ip = '', $timeout = 15, $block = TRUE) {
    $return = '';
    $matches = parse_url($url);
    $host = $matches['host'];
    $path = $matches['path'] ? $matches['path'].($matches['query'] ? '?'.$matches['query'] : '') : '/';
    $port = !empty($matches['port']) ? $matches['port'] : 80;

    if($post) {
        $out = "POST $path HTTP/1.0\r\n";
        $out .= "Accept: */*\r\n";
        //$out .= "Referer: $boardurl\r\n";
        $out .= "Accept-Language: zh-cn\r\n";
        $out .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
        $out .= "Host: $host\r\n";
        $out .= 'Content-Length: '.strlen($post)."\r\n";
        $out .= "Connection: Close\r\n";
        $out .= "Cache-Control: no-cache\r\n";
        $out .= "Cookie: $cookie\r\n\r\n";
        $out .= $post;
    } else {
        $out = "GET $path HTTP/1.0\r\n";
        $out .= "Accept: */*\r\n";
        //$out .= "Referer: $boardurl\r\n";
        $out .= "Accept-Language: zh-cn\r\n";
        $out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
        $out .= "Host: $host\r\n";
        $out .= "Connection: Close\r\n";
        $out .= "Cookie: $cookie\r\n\r\n";
    }
    $fp = @fsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
    if(!$fp) {
        return '';
    } else {
        stream_set_blocking($fp, $block);
        stream_set_timeout($fp, $timeout);
        @fwrite($fp, $out);
        $status = stream_get_meta_data($fp);
        if(!$status['timed_out']) {
            while (!feof($fp)) {
                if(($header = @fgets($fp)) && ($header == "\r\n" ||  $header == "\n")) {
                    break;
                }
            }

            $stop = false;
            while(!feof($fp) && !$stop) {
                $data = fread($fp, ($limit == 0 || $limit > 8192 ? 8192 : $limit));
                $return .= $data;
                if($limit) {
                    $limit -= strlen($data);
                    $stop = $limit <= 0;
                }
            }
        }
        @fclose($fp);
        return $return;
    }
}

function daddslashes($string, $force = 0) {
    !defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
    if(!MAGIC_QUOTES_GPC || $force) {
        if(is_array($string)) {
            foreach($string as $key => $val) {
                $string[$key] = daddslashes($val, $force);
            }
        } else {
            $string = $string;
        }
    }
    return $string;
}
//获得用户UID
function getuid($name) {
    global $_SGLOBAL;

    $wherearr = "username='$name'";
    $uid = 0;
    $query = $_SGLOBAL['db']->query("SELECT id, username FROM " . tname('members') . " WHERE " . $wherearr . " LIMIT 1");
    if(($space = $_SGLOBAL['db']->fetch_array($query)) != false) {
        $uid = $space['id'];
    }
    
    return $uid;
}
//检查权限
function checkperm($permtype) {
    global $_SGLOBAL, $space;

    if($permtype == 'admin') $permtype = 'manageconfig';

    $var = 'checkperm_'.$permtype;
    if(!isset($_SGLOBAL[$var])) {
        if(empty($_SGLOBAL['supe_uid'])) {
            $_SGLOBAL[$var] = '';
        } else {
            if(empty($_SGLOBAL['member'])) getmember();
            $gid = getgroupid($_SGLOBAL['member']['groupid']);//echo $gid;exit;
            if(!@include_once(S_ROOT . './data/data_usergroup_' . $gid . '.php')) {
                include_once(S_ROOT . './source/function_cache.php');
                usergroup_cache();
                @include_once(S_ROOT . './data/data_usergroup_' . $gid . '.php');
            }
            if($gid != $_SGLOBAL['member']['groupid']) {
                updatetable('space', array('groupid'=>$gid), array('uid'=>$_SGLOBAL['supe_uid']));
            }
            $_SGLOBAL[$var] = empty($_SGLOBAL['usergroup'][$gid][$permtype]) ? '' : $_SGLOBAL['usergroup'][$gid][$permtype];
            if(substr($permtype, 0, 6) == 'manage' && empty($_SGLOBAL[$var])) {
                $_SGLOBAL[$var] = $_SGLOBAL['usergroup'][$gid]['manageconfig'];//权限覆盖
                if(empty($_SGLOBAL[$var])) {
                    $_SGLOBAL[$var] = ckfounder($_SGLOBAL['supe_uid']) ? 1 : 0;//创始人
                }
            }
        }
    }
    return $_SGLOBAL[$var];
}

//产生随机字符
function random($length, $numeric = 0) {
    PHP_VERSION < '4.2.0' ? mt_srand((double)microtime() * 1000000) : mt_srand();
    $seed = base_convert(md5(print_r($_SERVER, 1).microtime()), 16, $numeric ? 10 : 35);
    $seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
    $hash = '';
    $max = strlen($seed) - 1;
    for($i = 0; $i < $length; $i++) {
        $hash .= $seed[mt_rand(0, $max)];
    }
    return $hash;
}
//检查验证码
function ckseccode($seccode) {
    global $_SGLOBAL, $_SCOOKIE, $_SCONFIG;

    $check = true;
    if(empty($_SGLOBAL['mobile'])) {
        if($_SCONFIG['questionmode']) {
            include_once(S_ROOT.'./data/data_spam.php');
            $cookie_seccode = intval($_SCOOKIE['seccode']);
            $seccode = trim($seccode);
            if($seccode != $_SGLOBAL['spam']['answer'][$cookie_seccode]) {
                $check = false;
            }
        } else {
            $cookie_seccode = empty($_SCOOKIE['seccode'])?'':authcode($_SCOOKIE['seccode'], 'DECODE');
            if(empty($cookie_seccode) || strtolower($cookie_seccode) != strtolower($seccode)) {
                $check = false;
            }
        }
    }
    return $check;
}

function clearHtml($message){
    $message = str_replace(
            array(
                '[/color]', '[/size]', '[/font]', '[/align]', '[b]', '[/b]', '[s]', '[/s]', '[hr]', '[/p]',
                '[i=s]', '[i]', '[/i]', '[u]', '[/u]', '[list]', '[list=1]', '[list=a]',
                '[list=A]', '[*]', '[/list]', '[indent]', '[/indent]', '[/float]',
                '[url]', '[/url]', '[hide]', '[/hide]', '[free]', '[/free]', '[email]', '[/email]'
            ), 
            array(),
            preg_replace(array(
                "/\[color=([#\w]+?)\]/i",
                "/\[size=(\d+?)\]/i",
                "/\[size=(\d+(\.\d+)?(px|pt|in|cm|mm|pc|em|ex|%)+?)\]/i",
                "/\[font=([^\[\<]+?)\]/i",
                "/\[align=(left|center|right)\]/i",
                "/\[p=(\d{1,2}), (\d{1,2}), (left|center|right)\]/i",
                "/\[float=(left|right)\]/i",
                "/\[url=(.*?)\]/i"
            ), array(), $message));
    return $message;
}

function skipDiscuzCode($mesage)
{
    $mesage = preg_replace(array("/\[quote\](.*?)\[\/quote\]/ies",
                                 "/\[b\]回复(.*?)\[\/b\]/ies"),
                                 array(),$mesage);
    return $mesage;
}

/*gaohua*/
function getpassport($username, $password) {
	global $_SGLOBAL, $_SC;
	$passport = array();
 	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('member')." WHERE email='{$username}' and password='{$password}' LIMIT 1");
	if($result = $_SGLOBAL['db']->fetch_array($query)) {
		$passport = $result;
	}
	return $passport;
}
function formHelper($key, $default = "") {
    $rval = $default;
    if(array_key_exists($key, $_POST)) {
        if(strlen($_POST[$key]) > 0) {
            $rval = $_POST[$key];
        }
    }        
    return $rval;    
}
function formHelperArray($key, $default = array()) {
    $rval = $default;
    if(array_key_exists($key, $_POST)) {
        if(count($_POST[$key]) > 0) {
            $rval = $_POST[$key];
        }
    }        
    return $rval;    
}
function getFromArray($arr,$i){
	if(array_key_exists($i,$arr))
		return $arr[$i];
	return NULL;
}
function queryHelper($key, $default = "") {
    $rval = $default;
    if(array_key_exists($key, $_GET)) {
        if(strlen($_GET[$key]) > 0) {
            $rval = $_GET[$key];
        }
    }            
    return $rval;
}

function checkUnique($table,$where){
	global $_SGLOBAL;
	$query = $_SGLOBAL['db']->query('select count(*) from '.$table.' '.$where);
	$result = $_SGLOBAL['db']->result($query,0);
	return $result;
}
function mkImgdir($root = '',$dir_arr = array()){
	$dir = '';
	foreach($dir_arr as $val){
		$dir .= $val.'/';
		if(!file_exists($root.$dir)){
			mkdir($root.$dir,0777);
		}
	}
	return array($root.$dir,$dir);
}
function getImageUrl($url){
	global $_SC;
	return $_SC['attachurl'].$url;
}
function escape($url)
{
   return str_replace(array('%2F','%3A','%5C'), array('/',':','\\'), urlencode($url));
}
