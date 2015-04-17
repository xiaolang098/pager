<?php
/*
* 咨询后台管理 admincp_news.php 2010-12-10 liuanqi $
*/
if(!defined('IN_UCHOME') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}

$dos = array('edit', 'add', 'del', 'list');
$do = (!empty($_GET['do']) && in_array($_GET['do'], $dos)) ? $_GET['do'] : 'list';

$config_type = array(
    '1' => '公司动态',
    '2' => '行业动态',
    '3' => '政策解读',
);
if($do == 'add'){
    if(submitcheck('newsubmit')){
       $content = stripslashes($_POST['content']);
       $typeid = intval($_POST['typeid']);
       $createTime = $_SGLOBAL['timestamp'];
       
       $insertsqlarr = array(
            'typeid' => $typeid,
            'createTime' => $createTime,
            'content' => $content,
            'typename' => $config_type[$typeid],
        );
       $articleId = inserttable('news', $insertsqlarr, 1);
       if($articleId){
                cpmessage('添加成功', 'admincp.php?ac=news&do=list');
       }
    }
}else if ($do == 'edit'){
    if(submitcheck('newseditsubmit')){
      $newsid = intval($_POST['newsId']);
      $content = stripslashes($_POST['content']);
      $typeid = intval($_POST['typeid']);
      $createTime = $_SGLOBAL['timestamp'];
    
      $updatesqlarr = array(
        'content' => $content,
        'typeid' => $typeid,
        'createTime' => $createTime,
        'typename' => $config_type[$typeid],
      );

      $wheresqlarr = array(
        'id' => $newsid,      
      );
      updatetable('news', $updatesqlarr, $wheresqlarr);
      cpmessage('更新成功', 'admincp.php?ac=news&do=list');
    }else{
        $newsId = intval($_GET['id']);
        $query = $_SGLOBAL['db']->query("SELECT * FROM news WHERE id = " . $newsId);
        while($row = $_SGLOBAL['db']->fetch_array($query)){
            $newsOneInfo = $row;
        }
    }
}else if ($do == 'del'){
    $articleId = intval($_GET['id']);
    $_SGLOBAL['db']->query("delete from  " . tname('news') . "  where id='$articleId'");
    cpmessage('操作成功', 'admincp.php?ac=news&do=list', 3);
}else{
    $query = $_SGLOBAL['db']->query("SELECT * FROM news ORDER BY createTime DESC" );
    while($row = $_SGLOBAL['db']->fetch_array($query)){
        $row['typeName'] = $_SGLOBAL['articletype'][$row['typeId']];
        $row['createTime'] = date('Y-m-d H:i', $row['createTime']);
        $articleInfo[] = $row;
    }
    $pageurl = $adminurl . "&do=$do";
    //生成分页
    $multi = multi($count, $perpage, $page, $pageurl, 2);
}

