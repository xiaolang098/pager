<?php
/*
 * ��ҳ ��� ����
 */

if(!defined('IN_UCHOME')) {
    exit('Access Denied');
}
//����֪ͨ
$sql_notice = "SELECT * FROM notice WHERE typeid = 2 ORDER BY createTime DESC LIMIT 5";
$query_notice = $_SGLOBAL['db']->query($sql_notice);
while($row = $_SGLOBAL['db']->fetch_array($query_notice)){
    $result_notice_send[] = $row;
}
//������ά��
$sql_weixiu = "SELECT * FROM articles WHERE typeid = 4 ORDER BY id DESC LIMIT 4 ";
$query_weixu = $_SGLOBAL['db']->query($sql_weixiu);
while($row = $_SGLOBAL['db']->fetch_array($query_weixu)){
    $result_weixu[] = $row;
}
//��������

$sql_down = "SELECT * FROM files ORDER BY createTime DESC LIMIT 5";
$query_down = $_SGLOBAL['db']->query($sql_down);
while($row_down = $_SGLOBAL['db']->fetch_array($query_down)){
    $result_down[] = $row_down;
}
