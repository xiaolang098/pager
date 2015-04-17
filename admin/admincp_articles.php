<?php
/*
* 文章后台管理 admincp_article.php 2010-12-10 liuanqi $
*/
if(!defined('IN_UCHOME') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}

$dos = array('edit', 'add', 'del', 'list');
$do = (!empty($_GET['do']) && in_array($_GET['do'], $dos)) ? $_GET['do'] : 'list';

if($do == 'add'){
    if(submitcheck('articlesubmit')){
       $productInfo = $imgsrc = '';

       $title = stripslashes($_POST['title']);
       $content = stripslashes($_POST['content1']);
       $productInfo = stripslashes($_POST['content2']);
       $typeid = intval($_POST['typeid']);
       $createTime = $_SGLOBAL['timestamp'];
       $publishTime = empty($_POST['publistTime']) ? $createTime : strtotime($_POST['publistTime']);
       $author = stripslashes($_POST['author']);
       
       $insertsqlarr = array(
            'title' => $title,
            'typeid' => $typeid,
            'viewnum' => 0,
            'createTime' => $createTime,
            'publishTime' => $publishTime,
            'author' => $author
        );
       $articleId = inserttable('articles', $insertsqlarr, 1);
       if($typeid == '3'){
           
            if($_FILES['upfile']['name']) {

                $upfile = $_FILES['upfile'];
                $maxsize = '';
                $year  = date('Y', time());
                $month = date('m', time());

                //图片存储路径
                $updir = 'attachments/pics/' . $year . '/' . $month . '/';
                //递归检测、建立目录
                @forceDirectory(S_ROOT . $updir);

                $imgsrc = upload($upfile, $maxsize, $updir);
            }
       }
       if($articleId){
           $result = $_SGLOBAL['db']->query("insert into " . tname('articles_content') . " (articleid, content, pic, productInfo) values ('$articleId', '$content', '$imgsrc', '$productInfo')");
           if($result){
                cpmessage('添加成功', 'admincp.php?ac=article&do=list');
           }
       }
    }
}else if ($do == 'edit'){
    if(submitcheck('articleeditsubmit')){
      $productInfo = $imgsrc = $condition = '';

      $id = intval($_POST['articleId']);
      $title = stripslashes($_POST['title']);
      $content = stripslashes($_POST['content1']);
      $productInfo = stripslashes(trim($_POST['content2']));
      $typeid = intval($_POST['typeid']);
      $createTime = $_SGLOBAL['timestamp'];
      $publishTime = empty($_POST['publistTime']) ? $createTime : strtotime($_POST['publistTime']);      
      $author = stripslashes($_POST['author']);
    
      $updatesqlarr = array(
        'title' => $title,
        'typeid' => $typeid,
        'viewnum' => 0,
        'createTime' => $createTime,
        'publishTime' => $publishTime,      
        'author' => $author
      );
        
      $wheresqlarr = array(
        'id' => $id,      
      );

      updatetable('articles', $updatesqlarr, $wheresqlarr);

      if($typeid == '3'){
          
            if($_FILES['upfile']['name']) {

                $upfile = $_FILES['upfile'];
                $maxsize = '';
                $year  = date('Y', time());
                $month = date('m', time());
                //图片存储路径
                $updir = 'attachments/pics/' . $year . '/' . $month . '/';
                //递归检测、建立目录
                @forceDirectory(S_ROOT . $updir);

                $imgsrc = upload($upfile, $maxsize, $updir);
            
                if($imgsrc){
                    $condition .= " , pic = '$imgsrc' ";
                }
                if(!empty($productInfo)){
                    $condition .= " , productInfo = '$productInfo'";
                }
            }

       }

      if($_SGLOBAL['db']->query("update " . tname('articles_content') . " set content = '$content' {$condition} where articleid = '$id'")){
         cpmessage('更新成功', 'admincp.php?ac=articles&do=list');
      }else{
         cpmessage('更新失败，请联系管理员', 'admincp.php?ac=article&do=list', 3); 
      }
    }else{
        $articleId = intval($_GET['id']);
        $query = $_SGLOBAL['db']->query(" select a.*, c.content, c.productInfo from " . tname('articles') . " a left join " . tname('articles_content') ." c on a.id = c.articleid where a.id = '$articleId'");
        while($row = $_SGLOBAL['db']->fetch_array($query)){
            $articleOneInfo = $row;
        }
    }
}else if ($do == 'del'){
    $articleId = intval($_GET['id']);
    $_SGLOBAL['db']->query("update " . tname('articles') . " set isAvailable =0 where id='$articleId'");
    cpmessage('操作成功', 'admincp.php?ac=articles&do=list', 3);
}else{
    $query = $_SGLOBAL['db']->query("select t.*,c.content, c.productInfo from " . tname('articles') . " t 
                    left join " .tname('articles_content') . " c on t.id = c.articleid  
                    where t.isAvailable = 1" );
    while($row = $_SGLOBAL['db']->fetch_array($query)){
        $row['typeName'] = $_SGLOBAL['articletype'][$row['typeId']];
        $row['createTime'] = date('Y-m-d H:i', $row['createTime']);
        $articleInfo[] = $row;
    }

    $pageurl = $adminurl . "&do=$do";
    //生成分页
    $multi = multi($count, $perpage, $page, $pageurl, 2);
}

