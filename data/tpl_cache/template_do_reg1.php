<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('template/do_reg1|template/header_reg|template/footer', '1312047185', 'template/do_reg1');?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<link rel="stylesheet" href="<?=$_SC['cssdir']?>reg.css" type="text/css" />

<script type="text/javascript" src="<?=$_SC['jsdir']?>public.js"></script>
</head>
<body>
<div id="sd_wrap">
<div id ="sd_header" class="sd_h125">
<a id="sd_logo" href="www.baidu.com"><img src="images/logo.gif"/></a>
<span id="sd_h1">��������������</span><br/>
<span id="sd_regh1">���û�ע��</span>
</div>


<div id="sd_center">
<div id="sd_regleft">
<?php if($err_msg) { ?>
<div class="sd_r_msg"><?=$err_msg?></div>
<?php } ?>
<form id="regform" name="regform" onsubmit="return sdpost.checkForm();">
<p>
<span class="sd_regltxt">��½����</span><input type="text" name="email" value="<?=$email?>" id="email" class="sd_input" onclick="sdpost.checkField(this,0)" onblur="sdpost.checkField(this,0)" />
<span id="emailTip" class="onFocus">
<span class="span_tip">
<span class="span_tip1">
</span>
<span class="span_tip2">
</span>
</span>
</span>
</p>
<p>
<span class="sd_regltxt">��&nbsp;&nbsp;&nbsp;&nbsp;��</span><input type="text" name="nickname" value="<?=$nickname?>" id="nickname" class="sd_input"  maxlength="20" onclick="sdpost.checkField(this,1)" onblur="sdpost.checkField(this,1)" />
<span id="nicknameTip" class="onError">
<span class="span_tip">
<span class="span_tip1">
4-20���ַ���һ��������2���ַ���ע��ɹ��󲻿��޸�
</span>
<span class="span_tip2">
</span>
</span>
</span>
</p>
<p>
<span class="sd_regltxt">��&nbsp;&nbsp;&nbsp;&nbsp;��</span><input type="password" name="password1" value="" id="password1" class="sd_input"  maxlength="16" onpaste="return false;" onclick="sdpost.checkField(this,2)" onblur="sdpost.checkField(this,2)"  />
<span id="password1Tip" class="onFocus">
<span class="span_tip">
<span class="span_tip1">
��������6-16���ַ������֡���ĸ���»��ߣ���ɣ����ִ�Сд������ʹ���ظ�����������ĸ�����ֻ��»���
</span>
<span class="span_tip2">
</span>
</span>
</span>
</p>
<p>
<span class="sd_regltxt">ȷ������</span><input type="password" name="password2" value="" id="password2" class="sd_input"  maxlength="16" onpaste="return false;" onclick="sdpost.checkField(this,3)" onblur="sdpost.checkField(this,3)"  />
<span id="password2Tip" class="onCorrect">
<span class="span_tip">
<span class="span_tip1">
</span>
<span class="span_tip2">
</span>
</span>
</span>
</p>
<p>
<span class="sd_regltxt">��&nbsp;֤&nbsp;��</span><input type="text" name="verify" value="" id="verify" class="sd_input" onclick="sdpost.checkField(this,4)" onblur="sdpost.checkField(this,4)"  />
<span id="verifyTip" class="onCorrect">
<span class="span_tip">
<span class="span_tip1">
</span>
<span class="span_tip2">
</span>
</span>
</span>
</p>
<p>
<span class="sd_regltxt">&nbsp;</span><span class="sd_verify"><img src="/index.php?ac=code" height="36" width="130" onclick="this.src='/index.php?ac=code&rand='+Math.random();" /><a class="sd_blue">�����壿���ͼƬ��һ�ţ�</a></span>
</p>
<p>
<span class="sd_regltxt">&nbsp;</span><label class="sd_regbtn1"><input type="hidden" name="register" value="register"><input type="submit" name="post" value="����ע��" id="register" class="sd_regbtn2" /></label>
</p>
</form>
</div>

<div id="sd_regright">
<p class="sd_reglogin">
<strong>����˵���˺�</strong>
<br>
<a href="" style="color:blue;text-decoration:underline;font-size:14px;">��½</a>
</p>
<p>��Ҳ����ͨ��������վ�˺ŵ�½<br><br>
<a href="" class="sd_regr1"></a><br>
<a href="" class="sd_regr2"></a><br>
<a href="" class="sd_regr3"></a><br>
</p>
</div>
</div>
<script type="text/javascript">
sdpost.init([
{id:'email',reg:/^[_\.0-9a-zA-Z-]+[0-9a-zA-Z]@([0-9a-zA-Z-]+\.)+[a-zA-Z]{2,4}$/,minlen:0,maxlen:0,isunique:1,isempty:0,matchid:'',empty_msg:'����û����д��¼����',focus_msg:'��������Ч�������䣬���ڵ�¼���һ�����',error_msg:'��¼�����ʽ����ȷ',correct_msg:''},
{id:'nickname',reg:/^[\w|\u4E00-\u9FA5]+$/,minlen:4,maxlen:20,isunique:1,isempty:0,matchid:'',empty_msg:'����û����д�ǳ�',focus_msg:'4-20���ַ���һ��������2���ַ���ע��ɹ��󲻿��޸�',error_msg:'��Ҫ4-20���ַ���һ��������2���ַ�,������д�����ַ�',correct_msg:''},
{id:'password1',reg:/^[\w]+$/,minlen:6,maxlen:16,isunique:0,isempty:0,matchid:'',empty_msg:'����û����д����',focus_msg:'��������6-16���ַ������֡���ĸ���»��ߣ���ɣ����ִ�Сд',error_msg:'��������6-16���ַ������֡���ĸ���»��ߣ����',correct_msg:''},
{id:'password2',reg:/^[\w]+$/,minlen:6,maxlen:16,isunique:0,isempty:0,matchid:'password1',empty_msg:'���ٴ���������',focus_msg:'���ٴ���������',error_msg:'����̫�̻��������벻һ��',correct_msg:''},
{id:'verify',reg:/^[\w]+$/,minlen:4,maxlen:4,isunique:0,isempty:0,matchid:'',empty_msg:'����û����д��֤��',focus_msg:'��������֤��',error_msg:'��֤���ʽ����ȷ',correct_msg:''}]);
</script>
<div id="sd_footer">
<dl>
<dt>��������</dt>
<dd><a href="">������˭</a></dd>
<dd><a href="">���ǵĲ�Ʒ</a></dd>
<dd><a href="">ý�屨��</a></dd>
<dd><a href="">��ϵ����</a></dd>
</dl>
<dl>
<dt>��������</dt>
<dd><a href="">��������</a></dd>
<dd><a href="">��˽����</a></dd>
<dd><a href="">�û�Э��</a></dd>
<dd><a href="">�������</a></dd>
</dl>
<dl>
<dt>�������</dt>
<dd><a href="">��������</a></dd>
<dd><a href="">Ʒ����֤</a></dd>
<dd><a href="">�μӻ�Ա�</a></dd>
<dd><a href="">�ṩ�Ż�ȯ</a></dd>
</dl>
<dl style="width:100px;padding-top:30px;">
<a id="sd_logo" href="www.baidu.com"><img src="images/logo.png"/></a>
</dl>
 
</div>
</div>
</BODY>
</HTML>

