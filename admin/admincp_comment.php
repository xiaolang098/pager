<?php
/*
* 留言后台管理 admincp_comment.php 2010-12-12 liuanqi $
*/
if(!defined('IN_UCHOME') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}

$dos = array('edit', 'add', 'del', 'list');
$do = (!empty($_GET['do']) && in_array($_GET['do'], $dos)) ? $_GET['do'] : 'list';

 if ($do == 'edit'){
    if(submitcheck('commentsubmit')){
        $id = intval($_POST['id']);
       $reply = stripslashes($_POST['content2']);
       
       $updatesqlarr = array(
            'reply' => $reply,
            'reply_dateline' => time(),
            'status' => 1,
        );
       $wheresqlarr = array(
        'id' => $id,      
       );

      updatetable('comment', $updatesqlarr, $wheresqlarr);
      cpmessage('更新成功', 'admincp.php?ac=comment',1);
    }else{
        $id = intval($_GET['id']);
        $sql = "select * from comment where id = {$id} order by id desc";
        $query = $_SGLOBAL['db']->query($sql);
        
        $result = $_SGLOBAL['db']->fetch_array($query);
    }
}else if ($do == 'del'){
    $typeId = intval($_GET['id']);
    $_SGLOBAL['db']->query("delete from " . tname('comment') . " where id = '$typeId'");
    cpmessage('操作成功', 'admincp.php?ac=comment&do=list', 1);
}else{

        $sql = "select * from comment order by id desc";
        $query = $_SGLOBAL['db']->query($sql);
        
        while($row = $_SGLOBAL['db']->fetch_array($query)){
            if($row['uid']){
                $query_username = $_SGLOBAL['db']->query("select username from members where id = {$row['uid']}");
                $_username = $_SGLOBAL['db']->fetch_array($query_username);
                $row['author'] = $_username['username'];
            }else{
                $row['author'] = ''; 
            }
            $result[] = $row;
        }

}
