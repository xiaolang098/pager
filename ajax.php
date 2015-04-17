<?php
include_once('./common.php');
$acs = array('checkemail','checknickname','uploadicon');
$ac = isset($_REQUEST['ac']) ? $_REQUEST['ac'] : '';
if(!in_array($ac,$acs)){
	exit('Undefined Action!');
}
if(in_array($ac,array('checkemail','checknickname'))){
	$msg_arr = array('email'=>'此邮箱已经注册，请换一个','nickname'=>'此昵称已经注册，请换一个');
	$feild = str_replace('check','',$ac);
	$value = queryHelper($feild,'');
	$where = " where $feild ='{$value}'";
	$result = checkUnique('member',$where);
    if($result){
		$msg = siconv($msg_arr[$feild], 'utf-8', 'gbk');
 		echo 'var data = '.json_encode(array('id' => $feild, 'msg' =>$msg));
		exit;
    }
}elseif($ac == 'uploadicon'){
	$flag  = 0;
	$msg = '等待上传！';
	$msg_id = 'sd_u_icon';
	if(isset($_FILES['icon'])){
		if(!in_array($_FILES['icon']['type'],array('image/gif','image/jpeg'))){
			$msg = '请上传jpg,gif格式的图片！';
		}elseif($_FILES['icon']['size']>(2*1024*1024)){
			$msg = '图片大小不能超过2M！';
		}else{
			$strs = '';
			for($i=0;$i<4;$i++){ 
				$strs.=$_SC['rand'][mt_rand(0,61)]; 
			}
			$file_name = time().$strs.strstr($_FILES['icon']['name'],'.');
			$real_dir = mkImgdir(S_ROOT.$_SC['attachdir'],array(date('y'),date('m'),date('d')));
			if(move_uploaded_file($_FILES['icon']['tmp_name'],$real_dir[0].$file_name)){
				$msg = '<img src="'.escape(getImageUrl($real_dir[1].$file_name)).'" />';
				$flag = 1;
			}else{
				$msg = '图片上传失败！';
			}
		}
	}else{
		$msg = '图上传失败，请重新上传！';
	}
	echo "<script>window.parent.showImage('".$msg_id."','".$msg."',".$flag.");</script>";
}



exit;
/**
 * 【极客】AJAX调用
 * $Id: ajax.php 27 2010-09-25 11:33:10Z wukai$ 
 */
include_once('./common.php');
include_once(S_ROOT . './source/function_space.php');
include_once(S_ROOT . "./source/function_discuz.php");

//允许动作
$dos = array('up', 'down', 'tagin', 'tagout', 'getreply', 'doreply', 'pm', 'friend', 'report',
             'getgroup', 'changegroup', 'checkseccode', 'getTag', 'feedback', 'guide', 'guide_status', 'gethelplogin');
$do = (empty($_POST['do']) || !in_array($_POST['do'], $dos)) ? '' : $_POST['do'];

//初始化变量
$return = false;
$oneReplys = $title = $summary = $msg ='';

//初始化已登录用户空间
if($_SGLOBAL['supe_uid']) {
    $space = getspace($_SGLOBAL['supe_uid']);
}

if($do == 'gethelplogin') {//站点帮助登录log

    $ip = getonlineip();
    $selectSqlBegin = "SELECT * FROM " . tname('_helpLoginLog');
    $selectSql = $_SGLOBAL['supe_uid'] ? $selectSqlBegin . " WHERE uid = '{$_SGLOBAL['supe_uid']}'" : $selectSqlBegin . " WHERE ip = '{$ip}'";
    $insertSqlBegin = "INSERT INTO " . tname('_helpLoginLog');
    $insertSql = $_SGLOBAL['supe_uid'] ? $insertSqlBegin . " SET uid = '{$_SGLOBAL['supe_uid']}'" : $insertSqlBegin . " SET ip = '{$ip}'";
    $result = $_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query($selectSql));
    if($result == false) {
        $_SGLOBAL['db']->query($insertSql);
        echo true; exit;
    }
    echo false; exit;

} else if($do == 'guide') {//新手任务

    $ip = getonlineip();
    $where = $_SGLOBAL['supe_uid'] ? " WHERE uid = '{$_SGLOBAL['supe_uid']}'" : $where = " WHERE ip='{$ip}'";
    $insertSqlBegin = "INSERT INTO " . tname('_guide');
    $insertSql = $_SGLOBAL['supe_uid'] ? $insertSqlBegin . " SET uid = '{$_SGLOBAL['supe_uid']}' , guide = 2" : $insertSqlBegin . " SET ip = '{$ip}' , guide = 1";
    $res = $_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query("SELECT guide from " . tname('_guide') . $where));
    if($res == false) $_SGLOBAL['db']->query($insertSql);
    if($_SGLOBAL['supe_uid'] && $res == false) {
        if($space['_isGeek'] == 1) {
            $isArt = $_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query("select authorId from " . tname('_articles') . " where authorId = '{$_SGLOBAL['supe_uid']}'"));
            if($isArt == false) echo 3; exit;//未发表过文章
            $isUpDown = $_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query("select authorId from " . tname('_clicks') . " where authorId = '{$_SGLOBAL['supe_uid']}'"));;
            if($isUpDown == false) echo 4; exit;//未顶踩过
            echo 5; exit;
        }
        echo 2;exit;
    } else if($_SGLOBAL['supe_uid'] && $res != false) {
        if($space['_isGeek'] == 1 && $res['guide'] < 4) {
            echo 3; exit;//已是极客
        }
        echo $res['guide']; exit;
    } else if(!$_SGLOBAL['supe_uid'] && $res == false) {
        echo 1; exit;
    } else {
        echo $res['guide']; exit;
    }

} else if($do == 'guide_status') {//新手任务级别修改

    $ip = getonlineip();
    if($_SGLOBAL['supe_uid']) {
        $_SGLOBAL['db']->query("update " . tname('_guide') . "  set guide={$_POST['status']} WHERE ip='{$ip}'");
        echo $_SGLOBAL['db']->query("update " . tname('_guide') . "  set guide={$_POST['status']} WHERE uid='{$_SGLOBAL['supe_uid']}'");
    } else {
        echo $_SGLOBAL['db']->query("update " . tname('_guide') . "  set guide={$_POST['status']} WHERE ip='{$ip}'");
    }

} else if (in_array($do, array('up', 'down')) && ($_POST['id'] || $_POST['cid'])) {

    //顶、踩功能
    $articleId = $_POST['id'] ? intval($_POST['id']) : 0;
    $commentId = $_POST['cid'] ? intval($_POST['cid']) : 0;
    if($articleId) {
        $value_article = $_SGLOBAL['db']->fetch_array(
                         $_SGLOBAL['db']->query("SELECT title, summary FROM " . tname('_articles') . " a 
                                                 LEFT JOIN " . tname('_articleContent') . " ac 
                                                 ON a.articleId = ac.articleId
                                                 WHERE a.articleId='{$articleId}'")
        );
        $title   = "<a href='index.php?ac=article&id=$articleId' title=\"{$value_article['title']}\" target='_blank'>" . cutstr($value_article['title'], 37, '..') . "</a>";
        $summary = !empty($value_article['summary']) ? '【文章摘要】：' . cutstr(trim($value_article['summary']), 200, '..') : '【文章摘要】：暂无';
    }
    $ip = getonlineip();
    $wheresql = $articleId ? " ip='{$ip}' AND articleId='{$articleId}' " : " ip='{$ip}' AND commentId='{$commentId}' ";
    if($_SGLOBAL['supe_uid']) {
        $wheresql = $articleId ? " authorId='{$_SGLOBAL['supe_uid']}' AND articleId='{$articleId}' " : " authorId='{$_SGLOBAL['supe_uid']}' AND commentId='{$commentId}' ";
    }

    $num = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM " . tname('_clicks') . " WHERE $wheresql"), 0);

    if(empty($num) && ($articleId || $commentId)) {
        $up   = ($do == 'up')   ? 1 : 0;
        $down = ($do == 'down') ? 1 : 0;
        $insertsqlarr = array(
            'articleId' => $articleId,
            'commentId' => $commentId,
            'authorId'  => $_SGLOBAL['supe_uid'],
            'ip'        => $ip,
            'up'        => $up,
            'down'      => $down,
            'dateline'  => $_SGLOBAL['timestamp'],
        );
        $tagId = inserttable('_clicks', $insertsqlarr, 1);
        if($articleId) {
            $_SGLOBAL['db']->query("UPDATE " . tname('_articles') . " SET click_" . $do . "=click_" . $do . "+1 WHERE articleId='{$articleId}'");
        } else {
            $_SGLOBAL['db']->query("UPDATE " . tname('_comment') . " SET click_" . $do . "=click_" . $do . "+1 WHERE commentId='{$commentId}'");
        }

        if($_SGLOBAL['supe_uid'] && $tagId && $articleId) {
            $_SGLOBAL['db']->query("UPDATE " . tname('space') . " SET _" . $do . "=_" . $do . "+1 WHERE uid='{$_SGLOBAL['supe_uid']}'");
            //生成动态
            feed_add(array(), $do, $title, array(), $summary);
        }
        echo "true";
    } else {
        echo "false";
    }

} else if ($do == 'tagin' && !empty($_POST['newtag'])) {

    if(!$_SGLOBAL['supe_uid']) {
        $status = '0';
        $msg = siconv('对不起,您还没有登录', 'utf-8', 'gbk');
        echo json_encode(array('status' => $status, 'msg' => $msg));
        exit;
    }

    //个人TAG关注(添加)
    $tagIds = $_POST['newtag'];
    $query_tag = $_SGLOBAL['db']->query("SELECT tagId, tagName FROM " . tname('_tags') . " WHERE tagId in (" . simplode($tagIds) . ") AND isAvailable=1");
    while(($value_tag = $_SGLOBAL['db']->fetch_array($query_tag)) != false){
        $value_tag['tagName'] = siconv($value_tag['tagName'], 'utf-8', 'gbk');
        $returnArr[] = $value_tag;
    }
    foreach($tagIds as $k => $v){
        $value['tagId'] = $v;
        $value['uid'] = $_SGLOBAL['supe_uid'];
        $value['dateline'] = $_SGLOBAL['timestamp'];
        $insertsql .= "(" . $v . "," . $_SGLOBAL['supe_uid'] . "," . $_SGLOBAL['timestamp'] ."), ";
        $insertsqlarr[] = $value;
    }
    $insertsql = substr($insertsql, 0, -2);
    $sql = "INSERT INTO " . tname('_mytag') . " (tagId, uid, dateline) VALUES " . $insertsql;
    if($_SGLOBAL['db']->query($sql)){
        echo json_encode($returnArr);
    }


} else if ($do == 'tagout' && !empty($_POST['tagname'])) {

    if(!$_SGLOBAL['supe_uid']) {
        $status = '0';
        $msg = siconv('对不起,您还没有登录', 'utf-8', 'gbk');
        echo json_encode(array('status' => $status, 'msg' => $msg));
        exit;
    }

    //个人TAG关注(删除)
    $tagIds = $_POST['tagname'];
    $result = $_SGLOBAL['db']->query("DELETE FROM " . tname('_mytag') . " WHERE tagId IN (" . simplode($tagIds) . ") AND uid=" . $_SGLOBAL['supe_uid']);
    $return = empty($result) ? false : true;
    echo $return;

} else if ($do == 'getTag'){

    $mytagid_query = $_SGLOBAL['db']->query("SELECT tagid FROM " . tname('_mytag') . " 
                                    WHERE uid = '{$_SGLOBAL['supe_uid']}'" );
    while(($row = $_SGLOBAL['db']->fetch_array($mytagid_query)) != false){
        $arrMytagid[] = $row['tagid'];
    }
    if(!empty($arrMytagid)){
        $mytagids = implode(',', $arrMytagid);
        $condition_count = " AND tagid NOT IN ($mytagids) ";
        $condition_where = " AND t.tagid NOT IN ($mytagids) ";
    }
    $page = $count = 0;
    if($_POST['list'] == 1) {
        $page = empty($_POST['page']) ? 0 : intval($_POST['page']);
        $perpage = 18;
        $start = ($page - 1) * $perpage;
        $count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM " . tname('_tags') . " WHERE isAvailable=1 " . $condition_count), 0);
    } else {
        $start = 0;
        $perpage = 18;
    }
    //添加关注显示的消息
    $sql_hot_tag = "SELECT t.tagId, COUNT(t.tagId) AS num, t.tagName FROM " . tname('_tags') . " t 
                    LEFT JOIN " . tname('_articleTag') . " at 
                    ON at.tagId = t.tagId 
                    WHERE t.isAvailable=1 " . $condition_where . " 
                    GROUP BY  t.tagName 
                    ORDER BY num DESC 
                    LIMIT $start, $perpage";
    $query_hot_tag = $_SGLOBAL['db']->query($sql_hot_tag);
    while(($row = $_SGLOBAL['db']->fetch_array($query_hot_tag)) != false){
         $row['tagName'] = siconv($row['tagName'], 'utf-8', 'gbk');
         $hotTag[] = $row;
    }

    echo json_encode(array('page' => $page, 'count' => $count, 'list' => $hotTag));

} else if ($do == 'getreply' && $_POST['id'] && $_POST['catid']) {

    //取文章评论20条
    $articleId = intval($_POST['id']);
    $articleTypeId = intval($_POST['catid']);
    $where_reply = " articleId='{$articleId}' AND isSync=1 ";
    $commentCount = $count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM " . tname('_comment') . " WHERE " . $where_reply), 0);
    $sql_reply = "SELECT commentId, message, dateline, authorId, click_up, click_down 
                  FROM " . tname('_comment') . " 
                  WHERE " . $where_reply . " 
                  ORDER BY dateline DESC 
                  LIMIT 0, 20";
    $query_reply = $_SGLOBAL['db']->query($sql_reply);
    while(($value_reply = $_SGLOBAL['db']->fetch_array($query_reply)) !== false) {
        $getspace  = getspace($value_reply['authorId']);
        $avatarUrl = avatar($getspace['uid'], 'small', 'img1');
        $value_reply['isself']     = ($space['uid'] == $getspace['uid']) ? 1: 0;
        $value_reply['isfriend']   = in_array($space['uid'], explode(',', $getspace['friend'])) ? 1 : 0;
        $value_reply['floor']      = $count + 1; //和论坛楼层一致
        $value_reply['avatarUrl']  = $avatarUrl;
        $value_reply['viewNum']    = $getspace['_viewNum'];
        $value_reply['replyNum']   = $getspace['_replyNum'];
        $value_reply['articleNum'] = $getspace['_articleNum'];
        $value_reply['dateline']   = siconv(sgmdate('Y-m-d H:i:s', $value_reply['dateline'], 1), 'utf-8', 'gbk');
        $value_reply['message']    = siconv(discuzcode($value_reply['message'], 1, 0), 'utf-8', 'gbk');
        $value_reply['author']     = siconv($getspace['username'], 'utf-8', 'gbk');
        $value_reply['isGeek']     = $getspace['_isGeek']; 
        $oneReplys[] = $value_reply;
        $count--;
    }
    unset($sql_reply, $query_reply, $value_reply, $where_reply);

    if(empty($oneReplys)) {
        $status = '0';
        $msg = siconv('暂时没有评论数据', 'utf-8', 'gbk');
        echo json_encode(array('status' => $status, 'msg' => $msg));
        exit;
    } else {
        $status = '1';
        echo json_encode(array('status' => $status, 'msg' => $msg, 'allCommentCount' => $commentCount, 'commentList' => $oneReplys));
    }

} else if ($do == 'doreply' && $_POST['id'] ) {

    if(!$_SGLOBAL['supe_uid']) {
        $status = '0';
        $msg = siconv('对不起,您还没有登录', 'utf-8', 'gbk');
        echo json_encode(array('status' => $status, 'msg' => $msg));
        exit;
    }

    //回复评论
    $articleId = intval($_POST['id']);
    $bbcode = $_POST['bbcode'] ? intval($_POST['bbcode']) : 0;
    $message = siconv($_POST['message'], 'gbk', 'utf-8');
    if(trim($message) === false) {
        $status = '0';
        $msg = siconv('评论不能为空', 'utf-8', 'gbk');
        echo json_encode(array('status' => $status, 'msg' => $msg));
        exit;
    } else {
        $query = $_SGLOBAL['db']->query("SELECT title, bbsId, bbsTid, authorId FROM " . tname('_articles') . " WHERE articleId=" . $articleId . " AND checkState=1 AND isAvailable=1 AND isReleased=1 LIMIT 0, 1");
        $value = $_SGLOBAL['db']->fetch_array($query);
        //插入评论  走论坛回复接口
        $bbs_host = $bbs_map[$value['bbsId']];
        $bbstid = $value['bbsTid'];
        $authorid = $_SGLOBAL['supe_uid'];
        $author = $_SGLOBAL['supe_username'];
        $bbspost = urlencode($message);
        $bbspid = dfopen("http://".$bbs_host."/api/uchome.php?action=addpost", 0, "tid={$bbstid}&author={$author}&authorid={$authorid}&bbcode={$bbcode}&message={$bbspost}");
        if(empty($bbstime)){
            $bbstime = $_SGLOBAL['timestamp'];
        }
        $insertsqlarr = array(
            'articleId'     => $articleId,
            'bbsId'         => $value['bbsId'],
            'bbsTid'        => $value['bbsTid'],
            'bbsPid'        => $bbspid,
            'message'       => $message,
            'dateline'      => $bbstime,
            'authorId'      => $_SGLOBAL['supe_uid'],
            'author'        => $author,
            'isSync'        => 1,
        );
        $cid = inserttable('_comment', $insertsqlarr, 1);
        if($cid) {
            //生成动态
            $title = "<a href='index.php?ac=article&id=$articleId' title=\"{$value['title']}\" target='_blank'>" . cutstr($value['title'], 37, '..') . "</a>";
            feed_add(array(), 'ping', $title, array(), '【评论内容】：' . cutstr(trim($message), '200', '..'), array(), '', array(), array(), '', '', '', 0, $value['authorId']);
            //更新用户评论数与用户文章被评论数
            $_SGLOBAL['db']->query("UPDATE " . tname('space') . " SET _replyNum=_replyNum+1, _commentsNum=_commentsNum+1 WHERE uid=" . $_SGLOBAL['supe_uid']);
            //更新文章评论数
            $_SGLOBAL['db']->query("UPDATE " . tname('_articles') . " SET replynum=replynum+1 WHERE articleId=" . $articleId);

            //返回我的评论数据
            $where_reply = " articleId='{$articleId}' AND isSync=1 ";
            $count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM " . tname('_comment') . " WHERE " . $where_reply), 0);
            $sql_reply = "SELECT commentId, message, dateline, authorId, click_up, click_down 
                          FROM " . tname('_comment') . " 
                          WHERE commentId='{$cid}' AND isSync=1 
                          LIMIT 0, 1";
            $query_reply = $_SGLOBAL['db']->query($sql_reply);
            while(($value_reply = $_SGLOBAL['db']->fetch_array($query_reply)) !== false) {
                $getspace  = getspace($_SGLOBAL['supe_uid']);
                $avatarUrl = avatar($getspace['uid'], 'small', 'img1');
                $value_reply['isfriend']   = in_array($getspace['uid'], explode(',', $getspace['friend'])) ? 1 : 0;
                $value_reply['floor']      = $count + 1;
                $value_reply['avatarUrl']  = $avatarUrl;
                $value_reply['viewNum']    = $getspace['_viewNum'];
                $value_reply['replyNum']   = $getspace['_replyNum'];
                $value_reply['articleNum'] = $getspace['_articleNum'];
                $value_reply['dateline']   = siconv(sgmdate('Y-m-d H:i:s', $value_reply['dateline'], 1), 'utf-8', 'gbk');
                $value_reply['message']    = siconv(discuzcode($value_reply['message'], 1, 0), 'utf-8', 'gbk');
                $value_reply['author']     = siconv($getspace['username'], 'utf-8', 'gbk');
                $myReply = $value_reply;
            }
            unset($sql_reply, $query_reply, $value_reply);
            $status = '1';
            $msg = siconv('评论成功', 'utf-8', 'gbk');
            echo json_encode(array('status' => $status, 'msg' => $msg, 'commentInfo' => $myReply));
        }
    }

} else if ($do == 'friend' && $_POST['fid']) {

    if(!$_SGLOBAL['supe_uid']) {
        $status = '0';
        $msg = siconv('对不起,您还没有登录', 'utf-8', 'gbk');
        echo json_encode(array('status' => $status, 'msg' => $msg));
        exit;
    }

    //好友请求
    $friendid = intval($_POST['fid']);
    if($friendid == $_SGLOBAL['supe_uid']) {
        $status = '0';
        $msg = siconv('对不起，您不能加自己为好友', 'utf-8', 'gbk');
        echo json_encode(array('status' => $status, 'msg' => $msg));
        exit;
    } else if(empty($friendid)) {
        $status = '0';
        $msg = siconv('指定用户不存在或已被删除', 'utf-8', 'gbk');
        echo json_encode(array('status' => $status, 'msg' => $msg));
        exit;
    }

    $tospace  = getspace($friendid);
    //检测现在状态
    $mstatus = getfriendstatus($_SGLOBAL['supe_uid'], $friendid);
    if($mstatus == 1) {
        $status = '1';
        $msg = '你们已经是好友了';
    } else {
        //检查数目
        $maxfriendnum = checkperm('maxfriendnum');
        if($maxfriendnum && $space['friendnum'] >= $maxfriendnum + $space['addfriend']) {
            $status = '0';
            $msg = siconv('您当前的好友数目达到系统限制，请先删除部分好友', 'utf-8', 'gbk');
            echo json_encode(array('status' => $status, 'msg' => $msg));
            exit;
        }
        //对方是否把自己加为了好友
        $fstatus = getfriendstatus($friendid, $_SGLOBAL['supe_uid']);
        if($fstatus == -1) {
            //对方没有加好友，我加别人
            if($mstatus == -1) {
                //添加单向好友
                //if(submitcheck('addsubmit')) {
                    $setarr = array(
                        'uid'       => $_SGLOBAL['supe_uid'],
                        'fuid'      => $friendid,
                        'fusername' => addslashes($tospace['username']),
                        'gid'       => intval($_POST['gid']),
                        'note'      => cutstr(siconv($_POST['message'], 'gbk', 'utf-8'), 50),
                        'dateline'  => $_SGLOBAL['timestamp'],
                    );
                    inserttable('friend', $setarr);
                    //增加对方好友申请数
                    $_SGLOBAL['db']->query("UPDATE " . tname('space') . " SET addfriendnum=addfriendnum+1 WHERE uid='$friendid'");
                    $status = '1';
                    $msg = '好友请求已经发送，请等待对方验证中';
                //}
            } else {
                $status = '1';
                $msg = '正在等待对方验证中';
            }
        } else {
            //对方加了我为好友，我审核通过
           // if(submitcheck('add2submit')) {
                //成为好友
                $gid = intval($_POST['gid']);
                friend_update($space['uid'], $space['username'], $tospace['uid'], $tospace['username'], 'add', $gid);
                //事件发布
                //加好友不发布事件
                if(ckprivacy('friend', 1)) {
                    $fs = array();
                    $fs['icon'] = 'friend';
                    $fs['title_template'] = cplang('feed_friend_title');
                    $fs['title_data'] = array('touser'=>"<a href=\"space.php?uid=$tospace[uid]\">" . $_SN[$tospace['uid']] . "</a>");
                    $fs['body_template'] = '';
                    $fs['body_data'] = array();
                    $fs['body_general'] = '';
                    //feed_add(array(), $fs['icon'], $fs['title_template'], $fs['title_data'], $fs['body_template'], $fs['body_data'], $fs['body_general']);
                }
                //我的好友申请数进行变化
                $_SGLOBAL['db']->query("UPDATE " . tname('space') . " SET addfriendnum=addfriendnum-1 WHERE uid='$space[uid]' AND addfriendnum>0");
                $status = '1';
                $msg = "您和" . $tospace['username'] . "成为好友了";
            //}
        }
    }
    $msg = siconv($msg, 'utf-8', 'gbk');
    echo json_encode(array('status' => $status, 'msg' => $msg));
    exit;

} else if ($do == 'pm' && $_POST['touid'] && $_POST['message']) {

    $status = '0';
    if(!$_SGLOBAL['supe_uid']) {
        $msg = siconv('对不起,您还没有登录', 'utf-8', 'gbk');
        echo json_encode(array('status' => $status, 'msg' => $msg));
        exit;
    }

    //发短信
    $touid   = intval($_POST['touid']);
    $message = siconv($_POST['message'], 'gbk', 'utf-8');
    if($touid) {
        if($_SGLOBAL['supe_uid'] == $touid) {
            $msg = siconv('对不起，您不能给自己发信息', 'utf-8', 'gbk');
            echo json_encode(array('status' => $status, 'msg' => $msg));
            exit;
        }
        include_once(S_ROOT . './uc_client/client.php');
        $return = uc_pm_send($_SGLOBAL['supe_uid'], $touid, '', $message);
        $status = $return ? '1' : '0';
        $msg = $return ? '发送成功' : '对不起，消息发送失败'; 
    } else {
        $msg = '指定用户不存在或已经被删除'; 
    }
    $msg = siconv($msg, 'utf-8', 'gbk');
    echo json_encode(array('status' => $status, 'msg' => $msg));

} else if ($do == 'report') {

    $status = '0';
    if(!$_SGLOBAL['supe_uid']) {
        $msg = siconv('对不起,您还没有登录', 'utf-8', 'gbk');
        echo json_encode(array('status' => $status, 'msg' => $msg));
        exit;
    }
    //举报
    $ruid    = intval($_POST['ruid']);
    $replyId = intval($_POST['replyId']);
    $message = siconv($_POST['reason'], 'gbk', 'utf-8');
    if($ruid && $replyId && !empty($message)) {
        $setarr = array(
            'replyId'   => $replyId, 
            'ruid'      => $ruid,
            'suid'      => $_SGLOBAL['supe_uid'],
            'reason'    => $message,
            'dateline'  => $_SGLOBAL['timestamp'],
        );
        inserttable('_report', $setarr);
        $status = '1';
        $msg = siconv('举报成功，请等待管理员处理', 'utf-8', 'gbk');
    }elseif(empty($message)){
        $msg = siconv('请输入内容', 'utf-8', 'gbk');
    }else {
        $msg = siconv('举报失败', 'utf-8', 'gbk');
    }
    echo json_encode(array('status' => $status, 'msg' => $msg));

} else if($do == 'getgroup') {

    //获取好友分组
    $groups = getfriendgroup();
    foreach($groups as $k => $group) {
        $groups[$k] = siconv($group, 'utf-8', 'gbk');
    }
    echo json_encode($groups);

} else if ($do == 'changegroup') {

    //变更用户组
    if(!$_SGLOBAL['supe_uid']) {
        $status = '0';
        $msg = siconv('对不起,您还没有登录', 'utf-8', 'gbk');
        exit;
    }
    $gid  = $_POST['gid'];
    $fuid = $_POST['fuid'];
    if($fuid) {
        updatetable('friend', array('gid' => intval($_POST['gid'])), array('uid' => $_SGLOBAL['supe_uid'], 'fuid' => $fuid));
        friend_cache($_SGLOBAL['supe_uid']);
        $status = '1';
        $msg = '操作成功了';
    } else {
        $status = '0';
        $msg = '操作失败，请重试';
    }
    $msg = siconv($msg, 'utf-8', 'gbk');
    echo json_encode(array('status' => $status, 'msg' => $msg));

} else if ($do == 'checkseccode') {

    //验证码
    $msg = (ckseccode(trim($_POST['seccode']))) ? 1 : 0;
    echo $msg;

} else if ($do == 'feedback') {

    //用户反馈
    echo 'asdfasdf';exit;

} else {

    exit('Undefined Action!');

}
?>
