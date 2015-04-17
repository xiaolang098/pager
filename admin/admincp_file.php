<?php
/*
* ��̨�ļ��ϴ����� 2010-12-21 liuanqi $
*/
if(!defined('IN_UCHOME') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}

$dos = array('edit', 'add', 'del', 'list');
$do = (!empty($_GET['do']) && in_array($_GET['do'], $dos)) ? $_GET['do'] : 'list';

if($do == 'add'){

    if(submitcheck('filesubmit')){
        include_once(S_ROOT . './admin/upload_file.php');

        if($_FILES['upfile']) {

            $year  = date('Y', time());
            $month = date('m', time());
            $upfile = $_FILES['upfile'];
            $maxsize = '';

            //�ļ��洢·��
            $updir = 'attachments/files/' . $year . '/' . $month . '/';
            //�ݹ��⡢����Ŀ¼
            @forceDirectory(S_ROOT . $updir);

            $filesrc = upload_file($upfile, $maxsize, $updir);
            if($filesrc){
                $insertarr = array(
                   'title' => trim($_POST['title']),
                   'src'   => $filesrc,
                   'createTime' => $_SGLOBAL['timestamp'],
                );
                $fileId = inserttable('files', $insertarr, 1);
                if($fileId){
                    cpmessage('�ϴ��ļ��ɹ�', 'admincp.php?ac=file&do=list', 1);
                }
            }
        }else{
            cpmessage('��ѡ��Ҫ�ϴ����ļ�', 'admincp.php?ac=file&do=add', 1);
        }
    }

}elseif($do == 'edit'){
    if(submitcheck('fileEditSubmit')){
        $title = trim($_POST['title']);
        $id = trim($_POST['id']);
        $_SGLOBAL['db']->query("update " . tname('files') . " set title='$title' where id='$id'");

        cpmessage('�༭�ļ��ɹ�', 'admincp.php?ac=file&do=list', 1);
    }else{
        $fileId = $_GET['id'];
        if($fileId){
            $sql = "select title, id from " . tname('files') . " where id ='$fileId' ";
            $query = $_SGLOBAL['db']->query($sql);
            $fileInfo = $_SGLOBAL['db']->fetch_array($query);

        }else{
            cpmessage('��ѡ��Ҫ�༭���ļ�', 'admincp.php?ac=file&do=list', 3);
        }
    }
}elseif($do == 'del'){
    $fileId = intval($_GET['id']);
    $_SGLOBAL['db']->query("delete from " . tname('files') . " where id='$fileId'");
    cpmessage('�����ɹ�', 'admincp.php?ac=file&do=list', 3);
}else{
    //��ҳ��ʼ��
    $perpage = 10;
    $perpage = mob_perpage($perpage);
    $page = empty($_GET['page']) ? 0 : intval($_GET['page']);
    if($page < 1) $page = 1;
    $start = ($page - 1) * $perpage;
    //��鿪ʼ��
    ckstart($start, $perpage);
    $list = array();
    $count = 0;
    $multi = '';

    $sql = "select * from " . tname('files') . " order by createTime DESC limit $start, $perpage";
    $query = $_SGLOBAL['db']->query($sql);
    while($row = $_SGLOBAL['db']->fetch_array($query)){
        $row['createTime'] = date('Y-m-d', $row['createTime']);
        $fileInfo[] = $row;
    }

    $pageurl = $adminurl . "&do=$do";
    //���ɷ�ҳ
    $multi = multi($count, $perpage, $page, $pageurl, 2);

}