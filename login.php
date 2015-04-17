<?php
/*
* 用户登录
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
        showmessage('登录成功', 'index.php');
    }else{
        echo "登录失败";
    }

}elseif($_GET['do'] == 'logout'){
    echo "aa";
    ssetcookie('username', '');
    ssetcookie('uid','');
    showmessage('退出成功', 'index.php');
}
