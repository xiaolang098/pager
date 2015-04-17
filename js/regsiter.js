//验证码
var lastSecCode = setCode= "";
function seccode() {
    var img = '/index.php?ac=code&rand='+Math.random();
    document.writeln('<a href="javascript:updateseccode();"><img id="img_seccode" src="'+img+'" align="absmiddle"></a>');
}
function updateseccode() {
    var img = '/index.php?ac=code&rand='+Math.random();
    if($('#img_seccode')) {
        $('#img_seccode').attr('src',img);
    }
}
function checkSeccode() { 
        $("#checkseccode").empty();
        var seccodeVerify = $('#seccode').val();
        if(seccodeVerify.length < 4 || seccodeVerify.length > 4){
            $("#checkseccode").html('请输入正确的验证码');
            return;
        }
        if(seccodeVerify == lastSecCode) {
            return;
        } else {
            lastSecCode = seccodeVerify;
        }
        $.ajax({
           type: "POST",
           url:  DOMAIN_ROOT + "ajax.php",
           cache: false,
           data: "do=checkseccode&seccode="+seccodeVerify,
           success: function(msg){
             if(msg == 1){
                $("#setCode").val('1');
                $("#checkseccode").append('验证码正确');
                var lastSecCode = '';
                
             }
             if(msg == 0){
                 $("#setCode").val('0');
                $("#checkseccode").append('请输入正确的验证码');
             }
           }
        });
}
// 注册
var uncheck = true;
var pwcheck = true;
var pwccheck = true;
var emcheck = true;


function getStrLong(str){
	var valueLen = 0;
	var charNum = 0;
	if (str != ""){
		for (i = 0; i < str.length; i++){
		  var code = escape(str.charAt(i));
		  if ((code.length >= 4) && (code < '%uFF60' || code > '%uFF9F')){
			valueLen += 2;
		  } else {
			valueLen +=1;
		  }
		}
	}
	return valueLen;
}

function loseun(value)
{
    
    var cname = /[`~@#$%\^&\*\(\)\=\+\'\"\;\:\|\\\,\<\.\>\/\?\{\}\[\] ]/g;
    var nameleng = getStrLong(value);
    var tuijian = '';
    if(nameleng>3 && nameleng<21){
        var pstr = '';
        var sstr = '';
        while((pstr=cname.exec(value))!=null)
        {
            sstr += pstr+' ';
        }
        var qstr = value.match(/[\uff00-\uffff]/g);
        if(qstr != null || sstr != ''){

            if(sstr == ''){
                $("#unerror").html("不能使用全角字符");
            }else{
                $("#unerror").html("该用户名含有特殊字符:'"+sstr+"'，请重新输入。");
            }
        }else{
            
			try{
				$.ajax({
				   type: "POST",
				   url: "http://mywork.localhost.com/ajax.php",
				   cache: false,
				   data: "do=checkusername&username="+value,
				   success: function(msg){
					 
					 if(msg == 1){
						$("#unerror").html('此名称已被使用');
						uncheck = false;
						
					 }else{
						 $("#unerror").html('此名称可正常注册');
					 }
					 
				   }
				 });
			}catch(e){};
        }
    }else if(nameleng>0){
        $("#unerror").html("用户名在4-20个字符内");
    }
}

function subcheck()
{
	imgcod = true;
    var imgcod = $('#setCode').val();

    if(imgcod == 0){
        imgcod = false;
    }
    if(uncheck==false ||  pwccheck==false || emcheck==false || imgcod==false){

        return false;
    }else{
		return true;
    }
}

function loseem(value)
{

	if(value.length > 0){
		var cemail = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;
		var email_arr = value.split('@');
		if(cemail.test(value) && email_arr[0].length<17){
			try{
				$.ajax({
				   type: "POST",
				   url: "http://mywork.localhost.com/ajax.php",
				   cache: false,
				   data: "do=checkemail&email="+value,
				   success: function(msg){
					 
					 if(msg == 1){
						$("#emailerror").html('此邮箱已被使用');
						emcheck = false;
						
					 }else{
						 $("#emailerror").html('此邮箱可正常注册');
						 emcheck = true;
					 }
					 
				   }
				 });
			}catch(e){};
		}else{
			$("#emailerror").html("请输入有效邮箱，作为邮件验证、登录、找回密码所用");
			emcheck = false;
		}
	}
}

function losepwc(value)
{
	
	var passwd2 = $('#passwd2').val();

	if(passwd2 != '' && value != ''){
		if(passwd2 == value){
			$('#pwderror').html('两次输入密码一致');
			pwccheck = true;
		}else{
			$('#pwderror').html('两次输入密码不一致');
			pwccheck = false;
		}
	}else{
		$('#pwc').val('');
		pwccheck = false;
	}
}


