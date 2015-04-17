<?php
/*
*文章分类列表
* $ID index_category.php 2011/2/20 10:46 liuanqi$
*/

if(!defined('IN_UCHOME')) {
    exit('Access Denied');
}
//分类ID
$categoryIds = array('1', '2', '3', '4', '5');
$categoryId = (!empty($_GET['id']) && in_array($_GET['id'], $categoryIds)) ? $_GET['id'] : 1;

$config_category = array(
    '1' => '涉税区',
    '2' => '非税区',
    '3' => '打印机',
    '4' => '服务与维修',
);

require_once 'index_hot.php';

//分页初始化
$perpage = 9;
$perpage = mob_perpage($perpage);
$page = empty($_GET['page']) ? 0 : intval($_GET['page']);
if($page < 1) $page = 1;
$start = ($page - 1) * $perpage;
//检查开始数
ckstart($start, $perpage);
$list = array();
$count = 0;
$multi = '';

//类别
$where_article = " AND typeId = '{$categoryId}' AND isAvailable =1 ";

//统计
$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM " . tname('articles') . "  WHERE 1 "  . $where_article), 0);

$sql = "select * from " . tname('articles') . " where 1 " . $where_article . " limit $start, $perpage " ;

$query = $_SGLOBAL['db']->query($sql);

while($row = $_SGLOBAL['db']->fetch_array($query)){
    $result[] = $row;
}

//分页

$multi = multi($count, $perpage, $page, "/index.php?ac=category&id=$categoryId");

include_once template("index_category");
