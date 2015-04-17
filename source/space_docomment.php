<?php
/*
*ÎÒÒªÁôÑÔ
*$ID space_docomment.php  2011/2/22 14:35 liuanqi $
*/

if(!defined('IN_UCHOME')) {
    exit('Access Denied');
}

if(submitcheck('docommentsubmit')){
    $setarr = array(
            'title' => trim($_POST['title']),
            'content'  => trim($_POST['content']),
            'phone' => intval($_POST['phone']),
            'qq'   => intval($_POST['qq']),
            'email' => trim($_POST['email']),
        );
        if($_SGLOBAL['supe_uid']){
            $setarr['uid'] = $_SGLOBAL['supe_uid'];
        }else{
            $setarr['uid'] = 0;
        }
     inserttable('comment', $setarr);
}

include_once template('space_docomment'); 