<?php
/**
 * 下载中心
 * @author liuanqi  2011-4-3 上午05:31:07
 * 
 * index_file.php
 */

if(!defined('IN_UCHOME')) {
    exit('Access Denied');
}

$articleId = intval($_GET['id']);

if(!empty($articleId)){
    $where_article = " AND a.id='{$articleId}' "; 
    $sql = "select a.title, a.src, a.createTime, a.id
            FROM " . tname('files') . " a 
            where 1 $where_article " ;
     $query = $_SGLOBAL['db']->query($sql);
     $result = $_SGLOBAL['db']->fetch_array($query);
     $result['createTime'] = date('Y-m-d', $result['createTime']);
     $result['code'] = base64_encode($result['id']);
}

include_once template('index_file');
