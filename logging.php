<?php
/**
 * 【极客】登录、退出
 * $Id: login.php 27 2010-10-13 11:33:10Z limeng$ 
 */
include_once('./common.php');

//允许动作
$dos = array('login', 'logout');
if(!empty($_GET['action'])){
    $_GET['do'] = $_GET['action'];
}
$do = (!empty($_GET['do']) && in_array($_GET['do'], $dos)) ? $_GET['do'] : '';

if($do == 'login' ) {
    if(!empty($_SGLOBAL['supe_uid'])){
        if($_GET['referer']){
            $logined = $_GET['referer'];
        }else{
            $logined = $_SC['siteurl'];
        }
       showmessage('已登录成功',$logined);
    }

    if ((!$_SGLOBAL['supe_uid']) && defined('SSO_HOST') ) {
        include_once BBSLIB_DIR . '/include/sso_client.func.php';
        $t_ref = urlencode(dreferer());
        $return_url = 'http://' . $_SERVER['HTTP_HOST'] . '/logging.php?action=login&loginsubmit=1&referer='.$t_ref;
        if( !is_array($sso_user) ) ssoVerifyLogin($return_url);    // 验证用户，如果失败则重定向到SSO
    }

} else if ($do == 'logout') {
    if($_GET['uhash'] == $_SGLOBAL['uhash']) {
        //删除session
        if($_SGLOBAL['supe_uid']) {
            $_SGLOBAL['db']->query("DELETE FROM ".tname('session')." WHERE uid='$_SGLOBAL[supe_uid]'");
            $_SGLOBAL['db']->query("DELETE FROM ".tname('adminsession')." WHERE uid='$_SGLOBAL[supe_uid]'");//管理平台
        }

        if($_SCONFIG['uc_status']) {
            include_once S_ROOT.'./uc_client/client.php';
            $ucsynlogout = uc_user_synlogout();
        } else {
            $ucsynlogout = '';
        }
        clearcookie();
        ssetcookie('_refer', '');
        //同步退出
        foreach($valid_domains as $valid_domains_arr){
            $extrahead .= '<script type="text/javascript" src="http://'.$valid_domains_arr.'/Cookie?a=clear&c=js"></script>';
        }
    }
    include template('logout');
    exit;

} else {
    showmessage('undefined action');
}
?>
