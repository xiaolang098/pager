<?php
/*
*留言列表
*$ID comment_list.php  2011/5/8 18:37 liuanqi $
*/

if(!defined('IN_UCHOME')) {
    exit('Access Denied');
}

$id = intval($_GET['id']);

if($id){
    $sql = "select * from comment where id = $id";
    $rs = $_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query($sql));

    include_once template('comment_list'); 
}else{
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

    $sql = "select id, title from comment where isopen = 1 order by  commemts_dateline desc limit $start, $perpage ";

    $query = $_SGLOBAL['db']->query($sql);
    while($row = $_SGLOBAL['db']->fetch_array($query)){
        $result[] = $row;
    }

    $multi = multi($count , $perpage, $page, "/comment.php?do=commentlist", 1);
    include_once template('comment_list'); 
}
