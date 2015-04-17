<?php
/**
 * ˵���� ��¼���˳�
 * $Id: login.php 27 2010-10-13 11:33:10Z gaohua$ 
 */

include_once('./common.php');
$acs = array('login', 'logout','active','register','reg_check');
$ac = empty($_GET['ac'])?'':$_GET['ac'];
if(empty($_GET['ac']) || !in_array($ac, $acs)) {
   showmessage('enter_the_space', 'index.php', 0);
}

if($ac == 'login' ){
    if(!empty($_SGLOBAL['supe_uid'])) {
            $logined = formHelper('referer',$_SC['siteurl']);
       showmessage('���ѵ�¼�ɹ�',$logined);
    } else {
    	if(isset($_POST['login']) && $_POST['login'] == 'login') {
			$password = formHelper('password','');
			$username = formHelper('email','');
			$cookietime = formHelper('cookietime','') ? formHelper('cookietime','') : $_SC['cookieexpire'];
			if(empty($password) || empty($username)) {
				showmessage('�û��������벻��Ϊ��', 'index.php?do=home');
			}
			if(!$passport = getpassport($username, md5($password))) {
				showmessage('�û��������벻��ȷ', 'index.php?do=home');
			}
			if(!$passport['isactive']){
				showmessage('�����û���δ����', 'index.php?do=home');
			}
			$setarr = array(
				'uid' => $passport['id'],
				'password' => md5($password)
			);
			//����cookie
			ssetcookie('auth', authcode("$setarr[password]\t$setarr[uid]", 'ENCODE'), $cookietime);
			ssetcookie('loginuser', $passport['nickname'], $cookietime);
			ssetcookie('_refer', '');
			$_SGLOBAL['supe_uid'] = $passport['uid'];
			showmessage('��½�ɹ�','index.php');
		}
	}
} else if($ac == 'register') {
	session_start();
	$err_msg = '';
	$email = formHelper('email','');
	$nickname = formHelper('nickname','');
	$password1 = formHelper('password1','');
	$password2 = formHelper('password2','');
	$verify = strtolower(formHelper('verify',''));
	$seccode = strtolower(authcode($_SCOOKIE['seccode'], 'DECODE'));
	if(isset($_POST['register']) && $_POST['register'] == 'register'){
		if(!preg_match('/^[_\.0-9a-zA-Z-]+[0-9a-zA-Z]@([0-9a-zA-Z-]+\.)+[a-zA-Z]{2,4}$/',$email)){
			$err_msg = '���䲻���Ϲ淶������������';
		}elseif(!preg_match('/^[\w\x80-\xff]+$/',$nickname) || strlen($nickname)>20 || strlen($nickname)<4){
			$err_msg = '�ǳƲ����Ϲ淶������������';
		}elseif(!preg_match('/^[\w]+$/',$password1) || strlen($password1)>16 || strlen($password1)<6 || !preg_match('/^[\w]+$/',$password2) || strlen($password2)>16 || strlen($password2)<6){
			$err_msg = '���벻���Ϲ淶������������';
		}elseif($password1 != $password2){
			$err_msg = '�������벻һ�£�����������';	
		}elseif($verify != $seccode){
			$err_msg = '��֤�벻��ȷ������������';
		}
		if(!$err_msg){
			$email_q = "where email ='{$email}'";
			$result_e = checkUnique('member',$email_q);
			if($result_e){
				$err_msg = '�������Ѿ�ע�ᣬ�뻻һ��';
			}
			$name_q = "where nickname ='{$nickname}'";
			$result_n = checkUnique('member',$name_q);
			if($result_n){
				$err_msg = '���ǳ��Ѿ�ע�ᣬ�뻻һ��';
			}
		}
		if(!$err_msg){
			$user_info = array(
				'email'=>$email,
				'password'=>md5($password1),
				'nickname'=>$nickname,
				'lastlogin'=>time(),
				'ip'=>getonlineip(),
			);
			$user_id = inserttable('member',$user_info,1);
			if($user_id){
				$encode = authcode("$user_id\t".md5($password1)."\t$email", 'ENCODE');
				//$active_link = '<a style="color:blue;" href="'.$_SC['siteurl'].'do.php?ac=active&encode='.$encode.'">���������˺�</a>';
				//$email_msg = str_replace('<<ACTIVE_LINK>>',$active_link,$_SC['email_msg']);
				//$email_msg = str_replace('<<LOGIN_NAME>>',$email,$email_msg);
				//mail();
				echo "<script>window.location.href='do.php?ac=reg_check&encode=".$encode."'</script>";
				exit;
			}
		}
	}
	include_once template('do_reg1');
}else if($ac == 'reg_check'){
	$encode = queryHelper('encode','');
	if($encode){
		$email_link = '';
		@list($uid,$password,$email) = explode("\t", authcode($encode, 'DECODE'));
		if($uid && $password && $email){
			//$email_link = 'http://mail.'.trim(strstr($email,'@'),'@');
			$active_link = '<a style="color:blue;" href="'.$_SC['siteurl'].'do.php?ac=active&encode='.$encode.'">���������˺�</a>';
			$email_msg = str_replace('<<ACTIVE_LINK>>',$active_link,$_SC['email_msg']);
			$email_msg = str_replace('<<LOGIN_NAME>>',$email,$email_msg);
			//mail();
			//echo $email_msg;

		}else{
			//showmessage('����û��ע��','do.php?ac=register');
			exit;
		}
		include_once template('do_reg2');
	}else{
		//showmessage('����û��ע��','do.php?ac=register');
		exit;
	}
} else if($ac == 'active') {
	$encode = queryHelper('encode','');
	if($encode){
		@list($uid,$password,$email) = explode("\t", authcode($encode, 'DECODE'));
		if($uid && $password && $email){
			//update member isactive;
		}else{
			showmessage('����û��ע��','do.php?ac=register');
			exit;
		}
		include_once template('do_reg3');
	}else{
		showmessage('����û��ע��','do.php?ac=register');
	}

} else if ($ac == 'logout') {
    if($_GET['uhash'] == $_SGLOBAL['uhash']){
        //ɾ��session
        if($_SGLOBAL['supe_uid']){
            $_SGLOBAL['db']->query("DELETE FROM ".tname('session')." WHERE uid='$_SGLOBAL[supe_uid]'");
            $_SGLOBAL['db']->query("DELETE FROM ".tname('adminsession')." WHERE uid='$_SGLOBAL[supe_uid]'");//����ƽ̨
        }

        if($_SCONFIG['uc_status']){
            include_once S_ROOT.'./uc_client/client.php';
            $ucsynlogout = uc_user_synlogout();
        } else {
            $ucsynlogout = '';
        }
        clearcookie();
        ssetcookie('_refer', '');
        //ͬ���˳�
        foreach($valid_domains as $valid_domains_arr){
            $extrahead .= '<script type="text/javascript" src="http://'.$valid_domains_arr.'/Cookie?a=clear&c=js"></script>';
        }
    }
    //include template('logout');
    exit;

} else {
   // include_once(S_ROOT . "./source/do_{$ac}.php");
}
?>
