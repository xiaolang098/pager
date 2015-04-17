<?php
/**
 * 用户组权限管理
 * $Id: admincpusergroup.php 2011/4/5 wukai$
 */
if(!defined('IN_UCHOME') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}


//用户组管理功能
$ops = array('grouplist', 'add', 'userlist', 'edit');
$op = (!empty($_GET['op']) && in_array($_GET['op'], $ops)) ? $_GET['op'] : 'grouplist';

//变量初始化
$insertsqlarr = $updatesqlarr = $group = $groups = array();

if($op == 'add') {
    if($isRead) {
        showmessage('对不起,您没有权限进行本管理操作');
    }
    //新增用户组
    if(submitcheck('groupsubmit')) {
        $groupName = trim($_POST['groupname']);
        if(empty($groupName)) {
            showmessage('用户组名不能为空！', $adminurl . "&op=add");
        }
        $count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM " . tname('usergroup') . " 
                WHERE groupname='" . trim($_POST['groupname'] . "'")), 0);
        if($count) {
            showmessage('用户组已经存在！请更换用户组名称', $adminurl . "&op=add");
        } else {
            if(intval($_POST['manageconfig']) == 1) {
                $insertsqlarr = array (
                    'groupname'       => $groupName,
                    'system'          => -1,
                    'managemember'    => 1,
                    'manageusergroup' => 1,
                    'managearticle'   => 1,
                    'managepic'       => 1,
                    'managetag'       => 1,
                    'managereply'     => 1,
                    'dateline'        => $_SGLOBAL['timestamp'],
                    'lastmodifytime'  => $_SGLOBAL['timestamp'],
                );
            } else if(intval($_POST['manageread']) == 1) {
                $insertsqlarr = array (
                    'groupname'       => $groupName,
                    'system'          => -2,
                    'managemember'    => 0,
                    'manageusergroup' => 0,
                    'managearticle'   => 0,
                    'managepic'       => 0,
                    'managetag'       => 0,
                    'managereply'     => 0,
                    'dateline'        => $_SGLOBAL['timestamp'],
                    'lastmodifytime'  => $_SGLOBAL['timestamp'],
                );
            } else {
                $insertsqlarr = array (
                    'groupname'       => $groupName,
                    'system'          => 1,
                    'managemember'    => intval($_POST['allowmember']),
                    'manageusergroup' => intval($_POST['allowusergroup']),
                    'managearticle'   => intval($_POST['allowarticle']),
                    'managepic'       => intval($_POST['allowpic']),
                    'managetag'       => intval($_POST['allowtag']),
                    'managereply'     => intval($_POST['allowreply']),
                    'dateline'        => $_SGLOBAL['timestamp'],
                    'lastmodifytime'  => $_SGLOBAL['timestamp'],
                );
            }
            inserttable('usergroup', $insertsqlarr);
            //更新用户组缓存
            include_once S_ROOT . './source/function_cache.php';
            //usergroup_cache();
            showmessage('添加用户组成功！', $adminurl);
        }
    }

} else if($op == 'userlist') {

    if($isRead && ($do == 'new' || $do == 'modify')) {
        showmessage('对不起,您没有权限进行本管理操作');
    }
    $dos = array('all', 'new', 'modify');
    $do = (!empty($_GET['do']) && in_array($_GET['do'], $dos)) ? $_GET['do'] : 'all';

    //管理用户组别，赋予用户组
    if(empty($_SGLOBAL['groupname'])) {
        if(!@include_once(S_ROOT . './data/datausergroup.php')) {
            include_once S_ROOT . './source/function_cache.php';
            usergroup_cache();
            include_once(S_ROOT . './data/data_usergroup.php');
        }
    }
    if($do == 'new') {
        if(submitcheck('newsubmit')) {
            $username = trim($_POST['username']);
            $gid = $_POST['gid'] ? intval($_POST['gid']) : 0;
            $uid = getuid($username);
            if(empty($uid)) {
                showmessage('该用户不存在，请重新输入', $adminurl . "&op=userlist&do=new");
            } else {
                updatetable('members', array('groupid' => $gid), array('id' => $uid));
                showmessage('成功更新用户的用户组别', $adminurl . "&op=userlist");
            }
        }
    } else if($do == 'modify') {
        $uid = intval($_POST['uid']);
        if(empty($uid)) {
            showmessage('请选要操作的用户！', $adminurl . "&op=userlist");
        }
        if(submitcheck('modifysubmit')) {
            $gid = $_POST['gid'] ? intval($_POST['gid']) : 0;
            updatetable('members', array('groupid' => $gid), array('id' => $uid));
            showmessage('成功更新用户的用户组别', $adminurl . "&op=userlist");
        } else if(submitcheck('delsubmit')) {
            updatetable('members', array('groupid' => 0), array('id' => $uid));
            showmessage('删除成功', $adminurl . "&op=userlist");
        }
    } else {
        $query = $_SGLOBAL['db']->query("SELECT groupid, username, id FROM " . tname('members') . " WHERE groupid != 0");
        while(($value = $_SGLOBAL['db']->fetch_array($query)) != false) {
            $users[] = $value;
        }
       
    }

} else if($op == 'edit') {

    if($isRead) {
        showmessage('对不起,您没有权限进行本管理操作');
    }
    if(submitcheck('editsubmit')) {
        $gid = $_POST['gid'];
        $count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM " . tname('usergroup') . " WHERE groupname='" . trim($_POST['groupname'] . "'")), 0);
        if($count && (trim($_POST['groupname']) != trim($_POST['gname']))) {
            showmessage('用户组已经存在！请更换用户组名称', $adminurl . "&op=edit&gid=$gid");
        } else {
            if(intval($_POST['manageconfig']) == 1) {
                $_POST['allowmember'] = $_POST['allowusergroup'] = $_POST['allowarticle'] = $_POST['allowpic'] = $_POST['allowtag'] = $_POST['allowsyslog'] = $_POST['allowuserlog'] = $_POST['allowreply'] = $_POST['allowcensor'] = 1;
                $system = -1;
            } else if(intval($_POST['manageconfig']) == 0) {
                $system = 1;
            } else if (intval($_POST['manageread']) == 1) {
                $_POST['allowmember'] = $_POST['allowusergroup'] = $_POST['allowarticle'] = $_POST['allowpic'] = $_POST['allowtag'] = $_POST['allowsyslog'] = $_POST['allowuserlog'] = $_POST['allowreply'] = $_POST['allowcensor'] = 0;
                $system = -2;
            } else if (intval($_POST['manageread']) == 0) {
                $system = 1;
            }
            //保存用户组
            $updatesqlarr = array (
                'groupname'       => trim($_POST['groupname']),
                'system'          => $system,
                'managemember'    => intval($_POST['allowmember']),
                'manageusergroup' => intval($_POST['allowusergroup']),
                'managearticle'   => intval($_POST['allowarticle']),
                'managepic'       => intval($_POST['allowpic']),
                'managetag'       => intval($_POST['allowtag']),
                'managesyslog'    => intval($_POST['allowsyslog']),
                'managereply'     => intval($_POST['allowreply']),
                'managecensor'    => intval($_POST['allowcensor']),
                'lastmodifytime'  => $_SGLOBAL['timestamp'],
            );
            updatetable('usergroup', $updatesqlarr, array('gid' => $gid));
            //更新用户组缓存
            include_once S_ROOT . './source/function_cache.php';
            usergroup_cache();
            showmessage('更新用户组成功！', $adminurl);
        }

    } else {

        //编辑用户组
        $gid = intval($_GET['gid']);
        if($gid) {
            $query = $_SGLOBAL['db']->query("SELECT * FROM " . tname('usergroup') . " WHERE gid=$gid");
            while(($value = $_SGLOBAL['db']->fetch_array($query)) != false) {
                $group = $value;
            }
        } else {
            showmessage('请选择要查看的用户组！', $adminurl);
        }
    }

} else {

    //用户组
    $count = getcount('usergroup');
    if($count) {
        $query = $_SGLOBAL['db']->query("SELECT * FROM " . tname('usergroup'));
        while(($value = $_SGLOBAL['db']->fetch_array($query)) != false) {
            $groups[] = $value;
        }
    }
    

}

$pageurl = $adminurl . "&op=$op";

?>