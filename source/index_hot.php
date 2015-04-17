<?php
//ÈÈµãÍÆ¼ö
$sql_pic = "select a.id,  c.pic, a.title 
              from articles a 
              left join articles_content c on a.id = c.articleId
              where a.typeId = 3 order by id desc limit 10";
$query_pic = $_SGLOBAL['db']->query($sql_pic);
while($row = $_SGLOBAL['db']->fetch_array($query_pic)){
    $arr_pic[] = $row;
}