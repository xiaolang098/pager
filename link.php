<?php
/*
    [UCenter Home] (C) 2007-2008 Comsenz Inc.
    $Id: link.php 10953 2009-01-12 02:55:37Z liguode $
*/

include_once('./common.php');

if(empty($_GET['url'])) {
    showmessage('do_success', $refer, 0);
} else {
    $url = $_GET['url'];
    if(!$_SCONFIG['linkguide']) {
        showmessage('do_success', $url, 0);//ֱ����ת
    }
}

/**
 * MY_START author:limeng
 */

$urles = parse_url($_GET['url']);

if($urles['host'] != $_SC['siteurl']){
    $url = $_GET['url'];
    showmessage('do_success', $url, 0);
}
/** 
 * MY_END 
 */

$space = array();
if($_SGLOBAL['supe_uid']) {
    $space = getspace($_SGLOBAL['supe_uid']);
}

if(empty($space)) {
    //�ο�ֱ����ת
    showmessage('do_success', $url, 0);
}

$url = shtmlspecialchars($url);
if(!preg_match("/^http\:\/\//i", $url)) $url = "http://".$url;

//ģ�����
include_once template("iframe");

?>