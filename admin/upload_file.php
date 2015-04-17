<?php
/*
* 文件上传 2010-12-21 liuanqi$
*/


function upload_file($upfile, $maxsize, $updir)
{
    global $_SGLOBAL;
    $name     = $upfile["name"];
    $type     = $upfile["type"];
    $size     = $upfile["size"];
    $tmp_name = $upfile["tmp_name"];
    $error    = $upfile["error"]; 
    $newname = substr(md5($name . $_SGLOBAL['timestamp']), 0, 20);

    switch($type){
        case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' :$extend=".docs"; break;
        case 'application/octet-stream'  : $extend=".rar"; break;
        case 'application/pdf'   : $extend=".pdf"; break;
    }
    if (empty($extend)) {
        cpmessage("警告！只能上传文件类型：RAR PDF DOC", '');
        exit;
    }
    /*
    if ($size > $maxsize && false) {
        $maxpr = $maxsize/1000;
        showmessage("警告！上传图片大小不能超过" . $maxpr . "K!", '');
        exit;
    }
    */
    $destfile = S_ROOT . $updir . $newname . $extend;

    if ($error == 0 && move_uploaded_file($tmp_name, $destfile)) {
        return $updir . $newname . $extend;
    }
}
/**
 * 递归创建文件目录
 * @param $dir
 * @return bool
 */
function forceDirectory($dir)
{
    return is_dir($dir) || (forceDirectory(dirname($dir)) && mkdir($dir, 0777));
}