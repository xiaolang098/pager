;;;var iterate = function (obj){var	s="遍历对象"+obj+"的属性：\n";	for(var i in obj)	s+=i+":"+obj[i]+"\n<br />";	return s;};
String.prototype.trim = function(){
	return this.replace(/(^\s*)|(\s*$)/g, "");
};
/*Object*/
var $$ = function (id) {
	return 'string' == typeof id ? document.getElementById(id) : id;
};
var sdpost = 
{
	pool:[],
	poolLen:0,
	currentIndex:0,
	fieldClass:'',
	focusClass:'sd_input focus_c',
	errorClass:'sd_input error_c',
	correctClass:'sd_input ',
	focusClassTip:'onFocus',
	errorClassTip:'onError',
	correctClassTip:'onCorrect',
	tipFlag:'Tip',
	className:[],
	toggleHint:function(obj, hintstr){
		var active = document.activeElement;
		var defaultvalue = hintstr || obj.defaultValue;
		var currentvalue = obj.value;
		if('' == currentvalue && active != obj){
			obj.value = defaultvalue;
		}else if(currentvalue == defaultvalue  && active == obj){
			obj.value = '';
		}
	},
	toggleLabel:function(obj, hintstr){
		var active = document.activeElement;
		var labelobj = $$(obj.name+'_t').style.display;
		var currentvalue = obj.value;
		if(labelobj.toString() == 'none' && active != obj && !currentvalue){
			$$(obj.name+'_t').style.display = 'inline-block';
		}else if(labelobj.toString() == 'inline-block' && active == obj){
			$$(obj.name+'_t').style.display = "none";
		}
	},
	checkField:function(obj,i){
		var active = document.activeElement;
		var val_t = obj.value.trim();
		var val = obj.value;
		var len = val_t.length;
		var id = obj.id;
		if(active == obj){
			this.className = [this.focusClass,this.focusClassTip];
			this.showHint(obj,this.pool[i].focus_msg);
		}else{
			this.className = [this.errorClass,this.errorClassTip];
			if(this.pool[i].isempty == 0 && !val_t){
				this.showHint(obj,this.pool[i].empty_msg);
				//obj.focus();
				return false;
			}
			if(this.pool[i].minlen || this.pool[i].maxlen){
				if(len<this.pool[i].minlen || len>this.pool[i].maxlen){
					this.showHint(obj,this.pool[i].error_msg);
					//obj.focus();
					return false;
				}
			}
			if(this.pool[i].reg && !val.match(this.pool[i].reg)){
				this.showHint(obj,this.pool[i].error_msg);
				//obj.focus();
				return false;
			}
			if(this.pool[i].isunique){
				switch(id){
					case 'email' : 
						eval("var param = {'ac':'check'+id,'email':val,'rand':Math.random()}");
					break;
					case 'nickname' : 
						eval("var param = {'ac':'check'+id,'nickname':val,'rand':Math.random()}");
					break;
				}
				ajax.xhr({'url':'ajax.php','params':param,success:postSuccess,fail:postFaild});
			}
			if(this.pool[i].matchid){
				if(val != $$(this.pool[i].matchid).value){
					this.showHint(obj,this.pool[i].error_msg);
					//obj.focus();
					return false;
				}
			}
			this.className = [this.correctClass,this.correctClassTip];
			this.showHint(obj,this.pool[i].correct_msg);
			return true;
		}
	},
	checkForm:function(){
		var flag = 1;
		var formObj = document.regform;
		flag &= this.checkField($$('email'),0);
		flag &= this.checkField($$('password1'),2);
		flag &= this.checkField($$('password2'),3);
		flag &= this.checkField($$('verify'),4);
		flag &= this.checkField($$('nickname'),1);
		if(flag == 0){
			return false;
		}else{
			formObj.action = 'do.php?ac=register';
			formObj.method = 'post';
			formObj.target = '';
			formObj.submit();
		}
	},
	showHint:function(obj,txt){
		var tipId = obj.id+this.tipFlag;
		obj.className = this.className[0];
		$$(tipId).className = this.className[1];
		$$(tipId).children[0].children[0].innerHTML = txt;
		$$(tipId).children[0].style.display="block";
	},
	init:function(pool){
		this.pool = pool;
		this.poolLen = pool.length;
	}
};
var showImage = function(id,msg,flag){
	if(flag){
		$$(id).innerHTML = decodeURI(msg);
		$$(id+'_msg').className = '';
		$$(id+'_msg').innerHTML = '';
	}else{
		$$(id).innerHTML = '<img src="images/none.gif" >';
		$$(id+'_msg').className = 'sd_u_icon_msg';
		$$(id+'_msg').innerHTML = msg;
	}
};
var	postSuccess = function(data){
	eval(data);
	if(typeof(data.id) != 'undefined'){
		sdpost.className = [sdpost.errorClass,sdpost.errorClassTip];
		sdpost.showHint($$(data.id),data.msg);
		return false;
	}
};
var uploadSuccess = function(data){
	alert(data);
}
var postFaild = function(data){
	alert('ajax error');
	return false;
};
var ajax = 
{
	xhr:function(json)
	{
		var
		url = json.url,
		method = json.type || 'get',
		params = json.params || {},
		onComplete = json.success,
		charset = json.charset || 'utf8',
		onFailure = json.fail,
		refresh = (false == json.refresh) ? false : true,
		loading = json.loading,
		winscope = json.winscope || window;
		var createXhr = function(winscope){
			var xmlhttp = false;
			if (winscope.XMLHttpRequest){
				xmlhttp = new winscope.XMLHttpRequest();
			}
			else if(winscope.ActiveXObject){
				try{
					xmlhttp = new winscope.ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e){
					try{
						xmlhttp = new winscope.ActiveXObject("Microsoft.XMLHTTP");
					}
					catch(e){
						//xmlhttp = false;
					}
				}
			}
			return xmlhttp;
		};
		if(loading){
			loading();
		}
		var query = '';
		for (var i in params){
			var param = params[i];
			if ('gb2312'==charset){
				//	param = escape(param);
			}
			else{
				param = encodeURIComponent(param);
			}
			query += i+'='+param+'&';
		}
		var XHR = createXhr(winscope);
		XHR.onreadystatechange = function(){
			//	alert(XHR.readyState);
			if (XHR.readyState == 4){
				if (XHR.status == 200 || XHR.status == 304){
					if (onComplete){
						onComplete(XHR.responseText);
					}
				}else{
					if (onFailure){
						onFailure(XHR.responseText);
					};
				}
			}
		};
		method = ('get' == method.toLowerCase()) ? 'get' : 'post';
		if ('post' == method){
			XHR.open(method, url, true);
			//	XHR.setRequestHeader("charset",charset);
			XHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			XHR.send(query);
		}
		else{
			url += '?'+query ;
			if (refresh){
				url += Math.random();
			}
			XHR.open(method, url, true);
			//	XHR.setRequestHeader("charset",charset);
			XHR.send(null);
		}
		return XHR;
	}
}
 