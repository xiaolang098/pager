<?php
include_once('./common.php');
header("Content-type: application/xml");

//变量初始化
$do = empty($_GET['do']) ? '' : trim($_GET['do']);
$where = empty($_GET['type']) ? '' : " WHERE a.articleTypeId=" . intval($_GET['type']);

if($do == 'new') {
    $orderby =" ORDER BY a.createTime DESC";
} else if ($do == 'hot') {
    $orderby = " ORDER BY a.viewnum DESC";
} else if ($do == 'num') {
    $orderby = " ORDER BY a.replynum DESC";
}

$sql_rssArticle="SELECT ac.summary, a.title, a.articleId, a.authorName, a.createTime 
                 FROM " . tname('_articles') . " a 
                 LEFT JOIN " . tname('_articleContent ') . " ac 
                 ON a.articleId = ac.articleId "
                 . $where . $orderby . " 
                 LIMIT 0, 300";
$query_rssArticle = $_SGLOBAL['db']->query($sql_rssArticle);
while(($value_rssArticle = $_SGLOBAL['db']->fetch_array($query_rssArticle)) !== false) {
    $rssArticles[] = $value_rssArticle;
}
unset($sql_rssArticle, $query_rssArticle, $value_rssArticle);

//取文章类型名称
if(intval($_GET['type'])){
    $sql_typename = "SELECT articleTypeName 
                     FROM " . tname('_articleTypes') . " 
                     WHERE articleTypeId=".intval($_GET['type']);
    $query_typename = $_SGLOBAL['db']->query($sql_typename);
    $typename = $_SGLOBAL['db']->fetch_array($query_typename);
    $typename = empty($typename['articleTypeName']) ? '' : "【".$typename['articleTypeName']."】";
    unset($sql_typename, $query_typename);
}

$rss = "<?xml version='1.0' encoding='gbk'?>
        <rss version='2.0'>
        <channel>
        <title>极客最新文章" .$typename. "</title>
        <link>rss.php</link>
        <description>极客网站最新" .$typename. "文章订阅</description>
        <copyright>极客</copyright>
        <generator>极客</generator>
        <lastBuildDate>" . date('Y-m-d H:i:s', $_SGLOBAL['timestamp']) . "</lastBuildDate>";

foreach($rssArticles as $rssArticle){
$rss .= "<item>
        <title><![CDATA[" . $rssArticle['title'] . "]]></title>
        <link>index.php?ac=article&amp;id=" . $rssArticle['articleId'] . "</link>
        <description><![CDATA[" . $rssArticle['summary'] . "]]></description>
        <author>" . $rssArticle['authorName'] . "</author>
        <pubDate>" . date('Y-m-d H:i:s', $rssArticle['createTime']) . "</pubDate>
        </item>";
}
$rss .= "</channel></rss>";
//文章类型sql语句
function typeArticle($rssTypeId){
    $sql_rssArticle="SELECT ac.summary, a.title, a.articleId 
                     FROM " . tname('_articles') . " a
                     LEFT JOIN " . tname('_articleContent') . " ac
                     ON a.articleId = ac.articleId 
                     WHERE a.articleTypeId = " . $rssTypeId . "
                     ORDER BY a.createTime DESC ";
    return $sql_rssArticle;
}
echo $rss;
?> 