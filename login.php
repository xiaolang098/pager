<?php
/*
* �û���¼
* $ID login.php 2011/2/20 15:01 liuanqi$
*/

include_once('./common.php');

if($_GET['do'] == 'login'){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $passwd = md5($_POST['passwd']);

    $sql = "select * from members where username = '$username' and passwd = '$passwd'";
    $query = $_SGLOBAL['db']->query($sql);

    $result = $_SGLOBAL['db']->fetch_array($query);
    if(!empty($result)){
        ssetcookie('username', $username);
        ssetcookie('uid',$result['id']);
        showmessage('��¼�ɹ�', 'index.php');
    }else{
        echo "��¼ʧ��";
    }

}elseif($_GET['do'] == 'logout'){
    echo "aa";
    ssetcookie('username', '');
    ssetcookie('uid','');
    showmessage('�˳��ɹ�', 'index.php');
}
