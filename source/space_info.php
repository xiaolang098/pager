<?php
/*
*用户信息
*$ID space_info.php 2011/2/21 23:24 liuanqi $
*/

if(!defined('IN_UCHOME')) {
    exit('Access Denied');
}

$ops = array('profile');
$op = (!empty($_GET['op']) && in_array($_GET['op'], $ops)) ? $_GET['op'] : 'profile';

if($op == 'profile'){
    if(submitcheck('profilesubmit')) {
        $setarr = array(
            'name' => trim($_POST['name']),
            'sex'  => intval($_POST['sex']),
            'phone' => intval($_POST['phone']),
            'qq'   => intval($_POST['qq']),
            'address' => trim($_POST['address']),
        );

        updatetable('members', $setarr, array('id' => $_SGLOBAL['supe_uid']));
    }
    $sql = "select * from members where id = '". $_SGLOBAL['supe_uid'] ."'";
    $query = $_SGLOBAL['db']->query($sql);
    $space_info = $_SGLOBAL['db']->fetch_array($query);

    include_once template('space_info');
}