/***
 * author by wukai 2010.11.15
1、跨多浏览器，创建ajax对象xmlhttp
2、判断ajax请求状态
3、输出ajax响应数据
*/

xmlhttp = false;

function $(id) {
    return document.getElementById(id);
}

function ajax() {
    vertion = ["MSXML2.XMLHTTP.5.0","MSXML2.XMLHTTP.4.0","MSXML2.XMLHTTP.3.0","MSXML2.XMLHTTP","Microsoft.XMLHTTP"];
    if(window.ActiveXObject) {
        for( i = 0; i < vertion.length ; i++) {
           try{
               xmlhttp = new ActiveXObject(vertion[i]); 
               return xmlhttp;
              } catch(e){ }
        }
    } else if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
        return xmlhttp;
    } else {
        throw new Error("XMLHttp object could not be created.");
    }
}

function ajaxget(showId, url, isjson) {
    xmlhttp = ajax();
    xmlhttp.open('GET', url, true);
    xmlhttp.onreadystatechange = function(){
        if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            if(isjson == 1){
                $(showId).innerHTML = eval('(' + xmlhttp.responseText + ')');
            } else {
                $(showId).innerHTML = xmlhttp.responseText;
            }
        }
    };
    xmlhttp.send(null);
}

function ajaxget2(url) {
    xmlhttp = ajax();
    xmlhttp.open('GET', url, true);
    xmlhttp.onreadystatechange = function(){
        if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            msgwin(xmlhttp.responseText, 1000);
        }
    };
    xmlhttp.send(null);
}

function gettitle() {
    var articleId = $('articleid').value;
    articleId = articleId.replace(/^\s+|\s+$/g, "");
    if(articleId != '') {
        ajaxget('title', 'admin/upload_img.php?articleId=' + articleId, '1');
    }
}

function trim() {
    return this.replace(/\s+$|^\s+/g,"");
}

function uploadimg(){
    theform = document.uploadform;
    theform.target = 'upframe';
    theform.action = 'admin/upload_img.php';
    theform.submit();
}

function uploadfile(){
    theform = document.uploadform;
    theform.target = 'upframe';
    theform.action = 'admin/upload_file.php';
    theform.submit();
}

function saveimg(){
    theform = document.uploadform;
    theform.target = '';
    theform.action = 'admincp.php?ac=pic&do=add';
    theform.submit();
}

function editsaveimg(){
    theform = document.uploadform;
    theform.target = '';
    theform.action = 'admincp.php?ac=pic&do=editsave';
    theform.submit();
}

function changeorder(obj, id){
    if(obj.value == "") return false;
    var url = "admin/admincp_ajax.php?do=order&orderId=" + obj.value + "&picId=" + id;
    ajaxget2(url);
}

function changecategory(obj, id){
    if(obj.value == "") return false;
    var url = "admin/admincp_ajax.php?do=category&categoryId=" + obj.value + "&articleId=" + id;
    ajaxget2(url);
}
