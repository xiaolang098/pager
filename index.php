<?php
/*
* ��ҳ index.php 2010-12-10 liuanqi $
*/
include_once('./common.php');

//������
$acs = array('index', 'category', 'article', 'search', 'code', 'file', 'home');
$ac = (!empty($_GET['ac']) && in_array($_GET['ac'], $acs)) ? $_GET['ac'] : 'index';
if($ac == 'home' ){
	if($_SGLOBAL['supe_uid']){
		include_once template('index');
	}else{
		include_once template('home');
	}
}elseif($ac == 'index'){
	echo 11;
}else{
	include_once(S_ROOT . "./source/index_{$ac}.php");
}

// ����ģ��ķ���
/*
if($ac == 'index'){
    include_once template('index');
}else{
    include_once(S_ROOT . "./source/index_{$ac}.php");
}
*/
