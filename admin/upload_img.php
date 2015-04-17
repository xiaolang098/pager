<?php
/**
 * 图片上传功能
 * $Id: upload_img.php 2010-12-13 liuanqi$ 
 */
include_once('../common.php');

$articleId = empty($_GET['picid']) ? 0 : intval(trim($_GET['picid']));
$year  = date('Y', time());
$month = date('m', time());

if($articleId) {
   /*
   * do something
   */

} else {

    if($_FILES['upfile']) {

        $upfile = $_FILES['upfile'];
        $maxsize = '';

        //图片存储路径
        $updir = 'attachments/pics/' . $year . '/' . $month . '/';
        //递归检测、建立目录
        @forceDirectory(S_ROOT . $updir);

        $imgsrc = upload($upfile, $maxsize, $updir);

        if($imgsrc) {
            $insertarr = array(
                'src'         => $imgsrc, 
                'createTime'  => $_SGLOBAL['timestamp'], 
            );
            $picId = intval($_POST['picId']);
            if(!empty($picId)){
                updatetable('pics', $insertarr, array('id' => $picId));
            }else{
                $picId = inserttable('pics', $insertarr, 1);
            }
        }

    } else if($_GET['img'] && $_GET['picId']) {
		$imgsrc = $_GET['img'];
		$picId = $_GET['picId'];
        $file = S_ROOT . $_GET['img'];
        if(is_file($file) && file_exists($file)){
            echo "<img src='" . $_SC['siteurl'] . $_GET['img'] . "' /><input type='hidden' name='picId' value='{$_GET['picId']}' />";
        } else {
            echo "Error, File does not exist!";exit;
        }
    }
?>

<body onload="getimg('<?php echo $imgsrc; ?>', '<?php echo $picId; ?>');">
<script type="text/javascript">
    function getimg(imgsrc, picId) {
    var url="admin/upload_img.php?img=" + imgsrc + "&picId=" + picId;
    if(parent.ajaxget) {
        parent.ajaxget("upimg", url, '0');
    }
}
</script>
</body>

<?php
}
/**
 * 图片上传方法
 * return src;
 */
function upload($upfile, $maxsize, $updir)
{
    global $_SGLOBAL;
    $name     = $upfile["name"];
    $type     = $upfile["type"];
    $size     = $upfile["size"];
    $tmp_name = $upfile["tmp_name"];
    $error    = $upfile["error"]; 
    $newname = substr(md5($name . $_SGLOBAL['timestamp']), 0, 20);

    switch($type){
        case 'image/pjpeg' :
        case 'image/jpeg'  : $extend=".jpg"; break;
        case 'image/gif'   : $extend=".gif"; break;
        case 'image/png'   : $extend=".png"; break;
    }
    if (empty($extend)) {
        showmessage("警告！只能上传图片类型：GIF JPG PNG", '');
        exit;
    }
    if ($size > $maxsize && false) {
        $maxpr = $maxsize/1000;
        showmessage("警告！上传图片大小不能超过" . $maxpr . "K!", '');
        exit;
    }

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



?>
