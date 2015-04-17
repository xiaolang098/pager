<?php
/*
*ÎÒµÄÁôÑÔ
*$ID space_docomment.php  2011/2/22 14:35 liuanqi $
*/

if(!defined('IN_UCHOME')) {
    exit('Access Denied');
}

$sql = "SELECT * FROM  comment WHERE uid = '" . $_SGLOBAL['supe_uid'] ."' AND reply=1";
$query = $_SGLOBAL['db']->query($sql);
while($row = $_SGLOBAL['db']->fetch_array($query)){
  $result[] = $row;
}

include_once template('space_myreply'); 