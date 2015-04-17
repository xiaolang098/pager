<?php
/*
* 文章内容
* $ID index_article.php 2011/2/20 11:14 liuanqi $
*/

if(!defined('IN_UCHOME')) {
    exit('Access Denied');
}

require_once 'index_hot.php';

$config_category = array(
    '1' => '涉税区',
    '2' => '非税区',
    '3' => '打印机',
    '4' => '服务与维修',
);

$articleId = intval($_GET['id']);

if(!empty($articleId)){
    $where_article = " AND a.id='{$articleId}' AND a.isAvailable = 1"; 
    $sql = "select a.title, a.publishTime, c.content, a.viewnum, a.typeId, c.pic, c.productInfo, a.author 
            FROM " . tname('articles') . " a 
            LEFT JOIN " . tname('articles_content') . " c 
            on a.id = c.articleid
            where 1 $where_article " ;
     $query = $_SGLOBAL['db']->query($sql);
     $result = $_SGLOBAL['db']->fetch_array($query);
     $result['date'] = date('Y-m-d', $result['publishTime']);
     //增加当前文章的浏览次数
     $_SGLOBAL['db']->query("UPDATE articles SET viewnum=viewnum+1 WHERE id='{$articleId}'");
}
if($result['typeId'] == 3){
    include_once template('index_print');
}else{
    include_once template('index_article');
}