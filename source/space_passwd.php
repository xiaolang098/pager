<?php
/*
*ÓÃ»§ÐÞ¸ÄÃÜÂë
*$ID space_info.php 2011/2/21 23:24 liuanqi $
*/
if(!defined('IN_UCHOME')) {
    exit('Access Denied');
}

if(submitcheck('passwdsubmit')) {
    $setarr = array(
      'passwd' => md5(trim($_POST['newpasswd'])),
    );

    updatetable('members', $setarr, array('id' => $_SGLOBAL['supe_uid']));
 }
  $sql = "select * from members where id = '". $_SGLOBAL['supe_uid'] ."'";
  $query = $_SGLOBAL['db']->query($sql);
  $space_info = $_SGLOBAL['db']->fetch_array($query);

  include_once template('space_passwd');