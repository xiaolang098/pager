<?php
/**
 * �����͡����˿ռ�
 * $Id: space.php 27 2010-10-02 11:33:10Z wukai$ 
 */

include_once('./common.php');
include_once(S_ROOT . './source/initLogin.php');

//������
$dos = array('info', 'my', 'friend', 'article', 'track', 'feed', 'pm', 'apply');
$do = (!empty($_GET['do']) && in_array($_GET['do'], $dos)) ? $_GET['do'] : 'feed';

//��¼�ÿ�
if(!$space['self'] && $_SGLOBAL['supe_uid']) {
    $query = $_SGLOBAL['db']->query("SELECT dateline FROM " . tname('visitor') . " WHERE uid='{$space['uid']}' AND vuid='{$_SGLOBAL['supe_uid']}'");
    $visitor = $_SGLOBAL['db']->fetch_array($query);
    if(empty($visitor['dateline'])) {
        $setarr = array(
            'uid'       => $space['uid'],
            'vuid'      => $_SGLOBAL['supe_uid'],
            'vusername' => $_SGLOBAL['supe_username'],
            'dateline'  => $_SGLOBAL['timestamp'],
        );
        inserttable('visitor', $setarr, 0, true);
        //���¿ռ������
        $_SGLOBAL['db']->query("UPDATE " . tname('space') . " SET viewnum = viewnum + 1 WHERE uid='{$space['uid']}'");
    } else {
        if($_SGLOBAL['timestamp'] - $visitor['dateline'] >= 300) {
            updatetable('visitor', array('dateline' => $_SGLOBAL['timestamp'], 'vusername' => $_SGLOBAL['supe_username']), array('uid' => $space['uid'], 'vuid' => $_SGLOBAL['supe_uid']));
        }
    }
}

//������ʼ��
$theurl = "/space.php?do=" . $do;

//����ͷ��
$space['avatarUrl'] = addslashes(avatar($space['uid'], 'small', 'img1'));

include_once(S_ROOT . "./source/space_{$do}.php");

?>