<?php
/*
*��Ҫ����
*$ID space_docomment.php  2011/2/22 14:35 liuanqi $
*/

if(!defined('IN_UCHOME')) {
    exit('Access Denied');
}

if(submitcheck('deletesubmit')){
    $ids = $_POST['ids'];
    foreach($ids as $value){
        $id .= $value .',';
    }
    $id = substr($id,0,-1);
    $sql = "delete from commet where id in($id)";
    $_SGLOBAL['db']->query($sql);
    showmessage('ɾ���ɹ�', '/space.php?ac=mycomment');
}
$id = intval($_GET['id']);
if($id){
    $sql = "select * from comment where id = $id";
    $rs = $_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query($sql));
    include_once template('space_mycomment'); 
}else{
    //��ҳ��ʼ��
    $perpage = 9;
    $perpage = mob_perpage($perpage);
    $page = empty($_GET['page']) ? 0 : intval($_GET['page']);
    if($page < 1) $page = 1;
    $start = ($page - 1) * $perpage;
    //��鿪ʼ��
    ckstart($start, $perpage);
    $list = array();
    $count = 0;
    $multi = '';

    $count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select count(*) from comment where uid='".$_SGLOBAL['supe_uid']."'"),0);

    $sql = "select * from comment where uid='" .$_SGLOBAL['supe_uid'] ."' limit $start,$perpage ";
    $query = $_SGLOBAL['db']->query($sql);
    while($row = $_SGLOBAL['db']->fetch_array($query)){
        $result[] = $row;
    }

    $multi = multi($count , $perpage, $page, "/space.php?ac=mycomment", 1);
    include_once template('space_mycomment'); 
}