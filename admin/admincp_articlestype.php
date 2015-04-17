<?php
/*
* ���·����̨���� admincp_articlestype.php 2010-12-12 liuanqi $
*/
if(!defined('IN_UCHOME') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}

$dos = array('edit', 'add', 'del', 'list');
$do = (!empty($_GET['do']) && in_array($_GET['do'], $dos)) ? $_GET['do'] : 'list';

if($do == 'add'){

    if(submitcheck('typeaddsubmit')){
       $typeName = stripslashes($_POST['typeName']);
       
       $insertsqlarr = array(
            'typeName' => $typeName,
        );
       $typeId = inserttable('articles_types', $insertsqlarr, 1);
       if($typeId){
         cpmessage('��ӳɹ�', 'admincp.php?ac=articlestype&do=list');
       }
    }
}else if ($do == 'edit'){
	if(submitcheck('typeeditsubmit')){
      $typeId = intval($_POST['typeId']);
      $typeName = stripslashes($_POST['typeName']);
      	
	  $updatesqlarr = array(
		'typeId' => $typeId,
        'typeName' => $typeName,  
	  );
		
	  $wheresqlarr = array(
		'typeId' => $typeId,	  
	  );

	  updatetable('articles_types', $updatesqlarr, $wheresqlarr);
      cpmessage('���³ɹ�', 'admincp.php?ac=articlestype&do=list',1);
	}else{
		$typeId = intval($_GET['id']);
		if(empty($_SGLOBAL['articletype'])){
			$query = $_SGLOBAL['db']->query(" select * from " . tname('articles_types') . " where typeId = '$typeId'");
			while($row = $_SGLOBAL['db']->fetch_array($query)){
				$typeInfo = $row;
			}
		}else{
			$typeInfo['typeId'] = $typeId;
			$typeInfo['typeName'] = $_SGLOBAL['articletype'][$typeId]; 
		}
	}
}else if ($do == 'del'){
    $typeId = intval($_GET['id']);
	$_SGLOBAL['db']->query("delete from " . tname('articles_types') . " where typeId = '$typeId'");
	cpmessage('�����ɹ�', 'admincp.php?ac=articlestype&do=list', 1);
}else{

	if(empty($_SGLOBAL['articletype'])){
		$query = $_SGLOBAL['db']->query("SELECT typeId, typeName FROM " . tname('articles_types') );
		while(($value =$_SGLOBAL['db']->fetch_array($query)) != false){
			$_SGLOBAL['articletype'][$value['typeId']] = $value['typeName'];
		}
	}

}
// ����д�� ���·��໺��
//if($do == 'list'){
	//unlink(S_ROOT . './data/data_articletype.php'); 
	include_once S_ROOT . './source/function_cache.php';
	//unset($_SGLOBAL['articletype']);
    articletype_cache();
//}