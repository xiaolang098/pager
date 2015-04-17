<?php 
/*
 *录入发货通知  
 */

if(!defined('IN_UCHOME') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}

$dos = array('add', 'del', 'list');
$do = (!empty($_GET['do']) && in_array($_GET['do'], $dos)) ? $_GET['do'] : 'list';

if($do == 'add'){
    if(submitcheck('noticesubmit')){
       $title = stripslashes($_POST['content']);
       $typeid = intval($_POST['typeid']);
       $createTime = time();
       
       $insertsqlarr = array(
            'message' => $title,
            'typeid' => $typeid,
            'createTime' => $createTime,
        );
       $articleId = inserttable('notice', $insertsqlarr, 1);
       if($articleId){
                cpmessage('添加成功', 'admincp.php?ac=notice&do=list&typeid='.$typeid);
       }
    }
}else{
    $typeid = empty($_GET['typeid']) ? 1 : trim($_GET['typeid']);
    $sql = "SELECT * FROM notice WHERE typeid = " . $typeid;
    $query = $_SGLOBAL['db']->query($sql);
    while($row = $_SGLOBAL['db']->fetch_array($query)){
        $result[] = $row;
    }
    $count = count($result);
}
?>