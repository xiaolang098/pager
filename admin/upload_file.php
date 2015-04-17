<?php
/*
* �ļ��ϴ� 2010-12-21 liuanqi$
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
        cpmessage("���棡ֻ���ϴ��ļ����ͣ�RAR PDF DOC", '');
        exit;
    }
    /*
    if ($size > $maxsize && false) {
        $maxpr = $maxsize/1000;
        showmessage("���棡�ϴ�ͼƬ��С���ܳ���" . $maxpr . "K!", '');
        exit;
    }
    */
    $destfile = S_ROOT . $updir . $newname . $extend;

    if ($error == 0 && move_uploaded_file($tmp_name, $destfile)) {
        return $updir . $newname . $extend;
    }
}
/**
 * �ݹ鴴���ļ�Ŀ¼
 * @param $dir
 * @return bool
 */
function forceDirectory($dir)
{
    return is_dir($dir) || (forceDirectory(dirname($dir)) && mkdir($dir, 0777));
}