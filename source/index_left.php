<?php
/*
 * 首页 左侧 内容
 */

if(!defined('IN_UCHOME')) {
    exit('Access Denied');
}
//发货通知
$sql_notice = "SELECT * FROM notice WHERE typeid = 2 ORDER BY createTime DESC LIMIT 5";
$query_notice = $_SGLOBAL['db']->query($sql_notice);
while($row = $_SGLOBAL['db']->fetch_array($query_notice)){
    $result_notice_send[] = $row;
}
//服务与维修
$sql_weixiu = "SELECT * FROM articles WHERE typeid = 4 ORDER BY id DESC LIMIT 4 ";
$query_weixu = $_SGLOBAL['db']->query($sql_weixiu);
while($row = $_SGLOBAL['db']->fetch_array($query_weixu)){
    $result_weixu[] = $row;
}
//下载中心

$sql_down = "SELECT * FROM files ORDER BY createTime DESC LIMIT 5";
$query_down = $_SGLOBAL['db']->query($sql_down);
while($row_down = $_SGLOBAL['db']->fetch_array($query_down)){
    $result_down[] = $row_down;
}
