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
<span id="sd_h1">高质量评论社区</span><br/>
<span id="sd_regh1">新用户注册</span>
</div>


<div id="sd_center">
<div id="sd_regleft">
<?php if($err_msg) { ?>
<div class="sd_r_msg"><?=$err_msg?></div>
<?php } ?>
<form id="regform" name="regform" onsubmit="return sdpost.checkForm();">
<p>
<span class="sd_regltxt">登陆邮箱</span><input type="text" name="email" value="<?=$email?>" id="email" class="sd_input" onclick="sdpost.checkField(this,0)" onblur="sdpost.checkField(this,0)" />
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
<span class="sd_regltxt">昵&nbsp;&nbsp;&nbsp;&nbsp;称</span><input type="text" name="nickname" value="<?=$nickname?>" id="nickname" class="sd_input"  maxlength="20" onclick="sdpost.checkField(this,1)" onblur="sdpost.checkField(this,1)" />
<span id="nicknameTip" class="onError">
<span class="span_tip">
<span class="span_tip1">
4-20个字符，一个汉字是2个字符。注册成功后不可修改
</span>
<span class="span_tip2">
</span>
</span>
</span>
</p>
<p>
<span class="sd_regltxt">密&nbsp;&nbsp;&nbsp;&nbsp;码</span><input type="password" name="password1" value="" id="password1" class="sd_input"  maxlength="16" onpaste="return false;" onclick="sdpost.checkField(this,2)" onblur="sdpost.checkField(this,2)"  />
<span id="password1Tip" class="onFocus">
<span class="span_tip">
<span class="span_tip1">
密码需由6-16个字符（数字、字母、下划线）组成，区分大小写；不能使用重复、连续的字母、数字或下划线
</span>
<span class="span_tip2">
</span>
</span>
</span>
</p>
<p>
<span class="sd_regltxt">确认密码</span><input type="password" name="password2" value="" id="password2" class="sd_input"  maxlength="16" onpaste="return false;" onclick="sdpost.checkField(this,3)" onblur="sdpost.checkField(this,3)"  />
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
<span class="sd_regltxt">验&nbsp;证&nbsp;码</span><input type="text" name="verify" value="" id="verify" class="sd_input" onclick="sdpost.checkField(this,4)" onblur="sdpost.checkField(this,4)"  />
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
<span class="sd_regltxt">&nbsp;</span><span class="sd_verify"><img src="/index.php?ac=code" height="36" width="130" onclick="this.src='/index.php?ac=code&rand='+Math.random();" /><a class="sd_blue">看不清？点击图片换一张！</a></span>
</p>
<p>
<span class="sd_regltxt">&nbsp;</span><label class="sd_regbtn1"><input type="hidden" name="register" value="register"><input type="submit" name="post" value="立即注册" id="register" class="sd_regbtn2" /></label>
</p>
</form>
</div>

<div id="sd_regright">
<p class="sd_reglogin">
<strong>已有说道账号</strong>
<br>
<a href="" style="color:blue;text-decoration:underline;font-size:14px;">登陆</a>
</p>
<p>您也可以通过以下网站账号登陆<br><br>
<a href="" class="sd_regr1"></a><br>
<a href="" class="sd_regr2"></a><br>
<a href="" class="sd_regr3"></a><br>
</p>
</div>
</div>
<script type="text/javascript">
sdpost.init([
{id:'email',reg:/^[_\.0-9a-zA-Z-]+[0-9a-zA-Z]@([0-9a-zA-Z-]+\.)+[a-zA-Z]{2,4}$/,minlen:0,maxlen:0,isunique:1,isempty:0,matchid:'',empty_msg:'您还没有填写登录邮箱',focus_msg:'请输入有效电子邮箱，用于登录和找回密码',error_msg:'登录邮箱格式不正确',correct_msg:''},
{id:'nickname',reg:/^[\w|\u4E00-\u9FA5]+$/,minlen:4,maxlen:20,isunique:1,isempty:0,matchid:'',empty_msg:'您还没有填写昵称',focus_msg:'4-20个字符，一个汉字是2个字符，注册成功后不可修改',error_msg:'需要4-20个字符，一个汉字是2个字符,不能填写怪异字符',correct_msg:''},
{id:'password1',reg:/^[\w]+$/,minlen:6,maxlen:16,isunique:0,isempty:0,matchid:'',empty_msg:'您还没有填写密码',focus_msg:'密码需由6-16个字符（数字、字母、下划线）组成，区分大小写',error_msg:'密码需由6-16个字符（数字、字母、下划线）组成',correct_msg:''},
{id:'password2',reg:/^[\w]+$/,minlen:6,maxlen:16,isunique:0,isempty:0,matchid:'password1',empty_msg:'请再次输入密码',focus_msg:'请再次输入密码',error_msg:'密码太短或两次密码不一致',correct_msg:''},
{id:'verify',reg:/^[\w]+$/,minlen:4,maxlen:4,isunique:0,isempty:0,matchid:'',empty_msg:'您还没有填写验证码',focus_msg:'请输入验证码',error_msg:'验证码格式不正确',correct_msg:''}]);
</script>
<div id="sd_footer">
<dl>
<dt>关于我们</dt>
<dd><a href="">我们是谁</a></dd>
<dd><a href="">我们的产品</a></dd>
<dd><a href="">媒体报道</a></dd>
<dd><a href="">联系我们</a></dd>
</dl>
<dl>
<dt>常见问题</dt>
<dd><a href="">免责声明</a></dd>
<dd><a href="">隐私声明</a></dd>
<dd><a href="">用户协议</a></dd>
<dd><a href="">意见反馈</a></dd>
</dl>
<dl>
<dt>商务合作</dt>
<dd><a href="">友情链接</a></dd>
<dd><a href="">品牌认证</a></dd>
<dd><a href="">参加会员活动</a></dd>
<dd><a href="">提供优惠券</a></dd>
</dl>
<dl style="width:100px;padding-top:30px;">
<a id="sd_logo" href="www.baidu.com"><img src="images/logo.png"/></a>
</dl>
 
</div>
</div>
</BODY>
</HTML>

