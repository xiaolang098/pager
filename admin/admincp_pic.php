<?php
/*
* 图片后台管理 admincp_pic.php 2010-12-13 liuanqi $
*/
if(!defined('IN_UCHOME') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}

$dos = array('edit', 'add', 'del', 'list');
$do = (!empty($_GET['do']) && in_array($_GET['do'], $dos)) ? $_GET['do'] : 'list';

$type = ($_GET['type'] && in_array($_GET['type'], array(1, 2, 3))) ? intval($_GET['type']) : 1;


if($do == 'add'){
    if($_POST['picId']){
       $typeId = ($_POST['typeid'] && in_array($_POST['typeid'], array(1, 2, 3))) ? intval($_POST['typeid']) : 1;

       $setsqlarr = array(
            'title' => trim($_POST['title']),
            'typeid' => $typeId,
        );
       updatetable('pics', $setsqlarr, array('id' => intval($_POST['picId'])));
       if($typeId == 2){
          $insertsqlarr = array(
            'picid' => intval($_POST['picId']),
            'content' => stripslashes($_POST['content']),
          );
          if(intval($_POST['editsave']) == 1){
            updatetable('pics_content', $insertsqlarr, array('picid' => intval($_POST['picId'])));
          }else{
            inserttable('pics_content', $insertsqlarr);
          }
       }
       
    }
}else if ($do == 'edit'){
    $picId = intval($_GET['picid']);
    $type = ($_GET['type'] && in_array($_GET['type'], array(1, 2, 3))) ? intval($_GET['type']) : 1;
    $query = $_SGLOBAL['db']->query("select * from "  . tname('pics') . " where id='$picId'");
    if($type == 2){
        $query = $_SGLOBAL['db']->query("select p.*, c.* from " . tname('pics') . " p
                LEFT JOIN pics_content c on p.id = c.picid 
                where p.typeid ='$type' and p.isAvailable = 1" );
    }
    while($row = $_SGLOBAL['db']->fetch_array($query)){
        $picInfo = $row;
    }
}else if($do == 'editsave'){
    // TODO something
}else if ($do == 'del'){
    $picId = intval($_GET['picid']);
    $isAvailable = intval($_GET['isAvailable']);
    $query = $_SGLOBAL['db']->query("select src from  " . tname('pics') . "  where id='$picId'");
    $info = $_SGLOBAL['db']->fetch_array($query);
    $_SGLOBAL['db']->query("delete from  " . tname('pics') . "  where id='$picId'");
    unlink($info['src']);
   // $_SGLOBAL['db']->query("update from " . tname('pics') . " set isAvailable = $isAvailable where id='$picId'");
    cpmessage('操作成功', $_SERVER['HTTP_REFERER'], 1);
}else{
    //分页初始化
    $perpage = 10;
    $perpage = mob_perpage($perpage);
    $page = empty($_GET['page']) ? 0 : intval($_GET['page']);
    if($page < 1) $page = 1;
    $start = ($page - 1) * $perpage;
    //检查开始数
    ckstart($start, $perpage);
    $list = array();
    $count = 0;
    $multi = '';
    
    $count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select count(*) from " . tname('pics') . " 
                where typeid ='$type' " ), 0);

    $query = $_SGLOBAL['db']->query("select * from " . tname('pics') . " 
                where typeid ='$type'  order by createTime DESC LIMIT $start, $perpage" );
    if($type == 2){
        $query = $_SGLOBAL['db']->query("select p.*, c.* from " . tname('pics') . " p
                LEFT JOIN pics_content c on p.id = c.picid 
                where p.typeid ='$type'  order by p.createTime DESC LIMIT $start, $perpage" );
    }
    while($row = $_SGLOBAL['db']->fetch_array($query)){
        $row['createTime'] = date('Y-m-d H:i', $row['createTime']);
        $picInfo[] = $row;
    } 
    $pageurl = $adminurl . "";
    //生成分页
    $multi = multi($count, $perpage, $page, $pageurl, 2);
}

