<?php
/**
 * 【极客】管理后台
 * $Id: admincp.php 27 2010-10-15 11:33:10Z wukai$ 
 */
define('IN_ADMINCP', TRUE);
include_once('./common.php');
include_once(S_ROOT . './source/function_admincp.php');

//需要登录
if(empty($_SGLOBAL['supe_uid'])) {
    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        ssetcookie('_refer', rawurlencode($_SERVER['REQUEST_URI']));
    } else {
        ssetcookie('_refer', rawurlencode('admincp.php?ac=' . $_GET['ac']));
    }
    showmessage('您需要先登录才能继续本操作', $_SC['siteurl']);
}

$space = getspace($_SGLOBAL['supe_uid']);
if(empty($space)) {
    showmessage('对不起，您指定的用户空间不存在。', $_SC['siteurl']);
}

$isfounder = ckfounder($_SGLOBAL['supe_uid']);

$acs = array('article', 'member', 'pic', 'tag', 'usergroup', 'stat', 'log', 'reply');
$ac = (!empty($_GET['ac']) && in_array($_GET['ac'], $acs)) ? $_GET['ac'] : 'member';

//来源
if(!preg_match("/admincp\.php/", $_SGLOBAL['refer'])) $_SGLOBAL['refer'] = "admincp.php?ac=$ac";

//权限
$needlogin = 0;

$m_groupid = $_SGLOBAL['member']['groupid'];
@include_once(S_ROOT . './data/data_usergroup_' . $m_groupid . '.php');

$megroup = $_SGLOBAL['usergroup'][$m_groupid];
if($isfounder || $megroup['manageusergroup'] || $megroup['managemember'] || $megroup['managetag'] || $megroup['managepic'] || $megroup['managearticle'] || $megroup['managelog']) {
    $needlogin = 1;
}

if($needlogin == 0 && $space['_isGeek'] == 0) {
    header("Location:" . $_SC['siteurl']);
}

//二次登录确认(半个小时)
if($needlogin) {
    $cpaccess = 0;
    $query = $_SGLOBAL['db']->query("SELECT errorcount FROM " . tname('adminsession') . " WHERE uid='$_SGLOBAL[supe_uid]' AND dateline+1800>='$_SGLOBAL[timestamp]'");
    if(($session = $_SGLOBAL['db']->fetch_array($query)) != false) {
        if($session['errorcount'] == -1) {
            $_SGLOBAL['db']->query("UPDATE " . tname('adminsession') . " SET dateline='$_SGLOBAL[timestamp]' WHERE uid='$_SGLOBAL[supe_uid]'");
            $cpaccess = 2;
        } elseif ($session['errorcount'] <= 3) {
            $cpaccess = 1;
        }
    } else {
        $_SGLOBAL['db']->query("DELETE FROM " . tname('adminsession') . " WHERE uid='$_SGLOBAL[supe_uid]' OR dateline+1800<'$_SGLOBAL[timestamp]'");
        $_SGLOBAL['db']->query("INSERT INTO " . tname('adminsession') . " (uid, ip, dateline, errorcount)
                                VALUES ('$_SGLOBAL[supe_uid]', '" . getonlineip() . "', '$_SGLOBAL[timestamp]', '0')");
        $cpaccess = 1;
    }
} else {
    $cpaccess = 2;
}

switch ($cpaccess) {
    case '1'://可以登录
        if(submitcheck('loginsubmit')) {
            if(!$passport = getpassport($_SGLOBAL['supe_username'], $_POST['password'])) {
                $_SGLOBAL['db']->query("UPDATE " . tname('adminsession') . " SET errorcount=errorcount+1 WHERE uid='$_SGLOBAL[supe_uid]'");
                cpmessage('输入的密码不正确，请重新尝试', 'admincp.php');
            } else {
                $_SGLOBAL['db']->query("UPDATE " . tname('adminsession') . " SET errorcount='-1' WHERE uid='$_SGLOBAL[supe_uid]'");
                $refer = empty($_SCOOKIE['_refer']) ? $_SGLOBAL['refer'] : rawurldecode($_SCOOKIE['_refer']);
                if(empty($refer) || preg_match("/(login)/i", $refer)) {
                    $refer = 'admincp.php';
                }
                ssetcookie('_refer', '');
                showmessage('登录成功了，现在引导您进入登录前页面', $refer, 0);
            }
        } else {
            if($_SERVER['REQUEST_METHOD'] == 'GET') {
                ssetcookie('_refer', rawurlencode($_SERVER['REQUEST_URI']));
            } else {
                ssetcookie('_refer', rawurlencode('admincp.php?ac=' . $_GET['ac']));
            }
            $actives = array('advance' => ' class="active"');
            include template('admin/tpl/login');
            exit();
        }
        break;
    case '2'://登录成功
        break;
    default://尝试次数太多禁止登录
        cpmessage('您30分钟内尝试登录管理平台的次数超过了3次，为了数据安全，请稍候再试', $_SC['siteurl']);
        break;
}

//取消翻页限制
$_SCONFIG['maxpage'] = 0;

//log
if($needlogin) {
    admincp_log();
}

$adminurl = 'admincp.php?ac=' . $ac;

include_once(S_ROOT . './admin/admincp_' . $ac . '.php');
include_once template("admin/tpl/$ac");

?>