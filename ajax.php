<?php
include_once('./common.php');
$acs = array('checkemail','checknickname','uploadicon');
$ac = isset($_REQUEST['ac']) ? $_REQUEST['ac'] : '';
if(!in_array($ac,$acs)){
	exit('Undefined Action!');
}
if(in_array($ac,array('checkemail','checknickname'))){
	$msg_arr = array('email'=>'�������Ѿ�ע�ᣬ�뻻һ��','nickname'=>'���ǳ��Ѿ�ע�ᣬ�뻻һ��');
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
	$msg = '�ȴ��ϴ���';
	$msg_id = 'sd_u_icon';
	if(isset($_FILES['icon'])){
		if(!in_array($_FILES['icon']['type'],array('image/gif','image/jpeg'))){
			$msg = '���ϴ�jpg,gif��ʽ��ͼƬ��';
		}elseif($_FILES['icon']['size']>(2*1024*1024)){
			$msg = 'ͼƬ��С���ܳ���2M��';
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
				$msg = 'ͼƬ�ϴ�ʧ�ܣ�';
			}
		}
	}else{
		$msg = 'ͼ�ϴ�ʧ�ܣ��������ϴ���';
	}
	echo "<script>window.parent.showImage('".$msg_id."','".$msg."',".$flag.");</script>";
}



exit;
/**
 * �����͡�AJAX����
 * $Id: ajax.php 27 2010-09-25 11:33:10Z wukai$ 
 */
include_once('./common.php');
include_once(S_ROOT . './source/function_space.php');
include_once(S_ROOT . "./source/function_discuz.php");

//������
$dos = array('up', 'down', 'tagin', 'tagout', 'getreply', 'doreply', 'pm', 'friend', 'report',
             'getgroup', 'changegroup', 'checkseccode', 'getTag', 'feedback', 'guide', 'guide_status', 'gethelplogin');
$do = (empty($_POST['do']) || !in_array($_POST['do'], $dos)) ? '' : $_POST['do'];

//��ʼ������
$return = false;
$oneReplys = $title = $summary = $msg ='';

//��ʼ���ѵ�¼�û��ռ�
if($_SGLOBAL['supe_uid']) {
    $space = getspace($_SGLOBAL['supe_uid']);
}

if($do == 'gethelplogin') {//վ�������¼log

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

} else if($do == 'guide') {//��������

    $ip = getonlineip();
    $where = $_SGLOBAL['supe_uid'] ? " WHERE uid = '{$_SGLOBAL['supe_uid']}'" : $where = " WHERE ip='{$ip}'";
    $insertSqlBegin = "INSERT INTO " . tname('_guide');
    $insertSql = $_SGLOBAL['supe_uid'] ? $insertSqlBegin . " SET uid = '{$_SGLOBAL['supe_uid']}' , guide = 2" : $insertSqlBegin . " SET ip = '{$ip}' , guide = 1";
    $res = $_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query("SELECT guide from " . tname('_guide') . $where));
    if($res == false) $_SGLOBAL['db']->query($insertSql);
    if($_SGLOBAL['supe_uid'] && $res == false) {
        if($space['_isGeek'] == 1) {
            $isArt = $_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query("select authorId from " . tname('_articles') . " where authorId = '{$_SGLOBAL['supe_uid']}'"));
            if($isArt == false) echo 3; exit;//δ���������
            $isUpDown = $_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query("select authorId from " . tname('_clicks') . " where authorId = '{$_SGLOBAL['supe_uid']}'"));;
            if($isUpDown == false) echo 4; exit;//δ���ȹ�
            echo 5; exit;
        }
        echo 2;exit;
    } else if($_SGLOBAL['supe_uid'] && $res != false) {
        if($space['_isGeek'] == 1 && $res['guide'] < 4) {
            echo 3; exit;//���Ǽ���
        }
        echo $res['guide']; exit;
    } else if(!$_SGLOBAL['supe_uid'] && $res == false) {
        echo 1; exit;
    } else {
        echo $res['guide']; exit;
    }

} else if($do == 'guide_status') {//�������񼶱��޸�

    $ip = getonlineip();
    if($_SGLOBAL['supe_uid']) {
        $_SGLOBAL['db']->query("update " . tname('_guide') . "  set guide={$_POST['status']} WHERE ip='{$ip}'");
        echo $_SGLOBAL['db']->query("update " . tname('_guide') . "  set guide={$_POST['status']} WHERE uid='{$_SGLOBAL['supe_uid']}'");
    } else {
        echo $_SGLOBAL['db']->query("update " . tname('_guide') . "  set guide={$_POST['status']} WHERE ip='{$ip}'");
    }

} else if (in_array($do, array('up', 'down')) && ($_POST['id'] || $_POST['cid'])) {

    //�����ȹ���
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
        $summary = !empty($value_article['summary']) ? '������ժҪ����' . cutstr(trim($value_article['summary']), 200, '..') : '������ժҪ��������';
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
            //���ɶ�̬
            feed_add(array(), $do, $title, array(), $summary);
        }
        echo "true";
    } else {
        echo "false";
    }

} else if ($do == 'tagin' && !empty($_POST['newtag'])) {

    if(!$_SGLOBAL['supe_uid']) {
        $status = '0';
        $msg = siconv('�Բ���,����û�е�¼', 'utf-8', 'gbk');
        echo json_encode(array('status' => $status, 'msg' => $msg));
        exit;
    }

    //����TAG��ע(���)
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
        $msg = siconv('�Բ���,����û�е�¼', 'utf-8', 'gbk');
        echo json_encode(array('status' => $status, 'msg' => $msg));
        exit;
    }

    //����TAG��ע(ɾ��)
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
    //��ӹ�ע��ʾ����Ϣ
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

    //ȡ��������20��
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
        $value_reply['floor']      = $count + 1; //����̳¥��һ��
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
        $msg = siconv('��ʱû����������', 'utf-8', 'gbk');
        echo json_encode(array('status' => $status, 'msg' => $msg));
        exit;
    } else {
        $status = '1';
        echo json_encode(array('status' => $status, 'msg' => $msg, 'allCommentCount' => $commentCount, 'commentList' => $oneReplys));
    }

} else if ($do == 'doreply' && $_POST['id'] ) {

    if(!$_SGLOBAL['supe_uid']) {
        $status = '0';
        $msg = siconv('�Բ���,����û�е�¼', 'utf-8', 'gbk');
        echo json_encode(array('status' => $status, 'msg' => $msg));
        exit;
    }

    //�ظ�����
    $articleId = intval($_POST['id']);
    $bbcode = $_POST['bbcode'] ? intval($_POST['bbcode']) : 0;
    $message = siconv($_POST['message'], 'gbk', 'utf-8');
    if(trim($message) === false) {
        $status = '0';
        $msg = siconv('���۲���Ϊ��', 'utf-8', 'gbk');
        echo json_encode(array('status' => $status, 'msg' => $msg));
        exit;
    } else {
        $query = $_SGLOBAL['db']->query("SELECT title, bbsId, bbsTid, authorId FROM " . tname('_articles') . " WHERE articleId=" . $articleId . " AND checkState=1 AND isAvailable=1 AND isReleased=1 LIMIT 0, 1");
        $value = $_SGLOBAL['db']->fetch_array($query);
        //��������  ����̳�ظ��ӿ�
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
            //���ɶ�̬
            $title = "<a href='index.php?ac=article&id=$articleId' title=\"{$value['title']}\" target='_blank'>" . cutstr($value['title'], 37, '..') . "</a>";
            feed_add(array(), 'ping', $title, array(), '���������ݡ���' . cutstr(trim($message), '200', '..'), array(), '', array(), array(), '', '', '', 0, $value['authorId']);
            //�����û����������û����±�������
            $_SGLOBAL['db']->query("UPDATE " . tname('space') . " SET _replyNum=_replyNum+1, _commentsNum=_commentsNum+1 WHERE uid=" . $_SGLOBAL['supe_uid']);
            //��������������
            $_SGLOBAL['db']->query("UPDATE " . tname('_articles') . " SET replynum=replynum+1 WHERE articleId=" . $articleId);

            //�����ҵ���������
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
            $msg = siconv('���۳ɹ�', 'utf-8', 'gbk');
            echo json_encode(array('status' => $status, 'msg' => $msg, 'commentInfo' => $myReply));
        }
    }

} else if ($do == 'friend' && $_POST['fid']) {

    if(!$_SGLOBAL['supe_uid']) {
        $status = '0';
        $msg = siconv('�Բ���,����û�е�¼', 'utf-8', 'gbk');
        echo json_encode(array('status' => $status, 'msg' => $msg));
        exit;
    }

    //��������
    $friendid = intval($_POST['fid']);
    if($friendid == $_SGLOBAL['supe_uid']) {
        $status = '0';
        $msg = siconv('�Բ��������ܼ��Լ�Ϊ����', 'utf-8', 'gbk');
        echo json_encode(array('status' => $status, 'msg' => $msg));
        exit;
    } else if(empty($friendid)) {
        $status = '0';
        $msg = siconv('ָ���û������ڻ��ѱ�ɾ��', 'utf-8', 'gbk');
        echo json_encode(array('status' => $status, 'msg' => $msg));
        exit;
    }

    $tospace  = getspace($friendid);
    //�������״̬
    $mstatus = getfriendstatus($_SGLOBAL['supe_uid'], $friendid);
    if($mstatus == 1) {
        $status = '1';
        $msg = '�����Ѿ��Ǻ�����';
    } else {
        //�����Ŀ
        $maxfriendnum = checkperm('maxfriendnum');
        if($maxfriendnum && $space['friendnum'] >= $maxfriendnum + $space['addfriend']) {
            $status = '0';
            $msg = siconv('����ǰ�ĺ�����Ŀ�ﵽϵͳ���ƣ�����ɾ�����ֺ���', 'utf-8', 'gbk');
            echo json_encode(array('status' => $status, 'msg' => $msg));
            exit;
        }
        //�Է��Ƿ���Լ���Ϊ�˺���
        $fstatus = getfriendstatus($friendid, $_SGLOBAL['supe_uid']);
        if($fstatus == -1) {
            //�Է�û�мӺ��ѣ��Ҽӱ���
            if($mstatus == -1) {
                //��ӵ������
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
                    //���ӶԷ�����������
                    $_SGLOBAL['db']->query("UPDATE " . tname('space') . " SET addfriendnum=addfriendnum+1 WHERE uid='$friendid'");
                    $status = '1';
                    $msg = '���������Ѿ����ͣ���ȴ��Է���֤��';
                //}
            } else {
                $status = '1';
                $msg = '���ڵȴ��Է���֤��';
            }
        } else {
            //�Է�������Ϊ���ѣ������ͨ��
           // if(submitcheck('add2submit')) {
                //��Ϊ����
                $gid = intval($_POST['gid']);
                friend_update($space['uid'], $space['username'], $tospace['uid'], $tospace['username'], 'add', $gid);
                //�¼�����
                //�Ӻ��Ѳ������¼�
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
                //�ҵĺ������������б仯
                $_SGLOBAL['db']->query("UPDATE " . tname('space') . " SET addfriendnum=addfriendnum-1 WHERE uid='$space[uid]' AND addfriendnum>0");
                $status = '1';
                $msg = "����" . $tospace['username'] . "��Ϊ������";
            //}
        }
    }
    $msg = siconv($msg, 'utf-8', 'gbk');
    echo json_encode(array('status' => $status, 'msg' => $msg));
    exit;

} else if ($do == 'pm' && $_POST['touid'] && $_POST['message']) {

    $status = '0';
    if(!$_SGLOBAL['supe_uid']) {
        $msg = siconv('�Բ���,����û�е�¼', 'utf-8', 'gbk');
        echo json_encode(array('status' => $status, 'msg' => $msg));
        exit;
    }

    //������
    $touid   = intval($_POST['touid']);
    $message = siconv($_POST['message'], 'gbk', 'utf-8');
    if($touid) {
        if($_SGLOBAL['supe_uid'] == $touid) {
            $msg = siconv('�Բ��������ܸ��Լ�����Ϣ', 'utf-8', 'gbk');
            echo json_encode(array('status' => $status, 'msg' => $msg));
            exit;
        }
        include_once(S_ROOT . './uc_client/client.php');
        $return = uc_pm_send($_SGLOBAL['supe_uid'], $touid, '', $message);
        $status = $return ? '1' : '0';
        $msg = $return ? '���ͳɹ�' : '�Բ�����Ϣ����ʧ��'; 
    } else {
        $msg = 'ָ���û������ڻ��Ѿ���ɾ��'; 
    }
    $msg = siconv($msg, 'utf-8', 'gbk');
    echo json_encode(array('status' => $status, 'msg' => $msg));

} else if ($do == 'report') {

    $status = '0';
    if(!$_SGLOBAL['supe_uid']) {
        $msg = siconv('�Բ���,����û�е�¼', 'utf-8', 'gbk');
        echo json_encode(array('status' => $status, 'msg' => $msg));
        exit;
    }
    //�ٱ�
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
        $msg = siconv('�ٱ��ɹ�����ȴ�����Ա����', 'utf-8', 'gbk');
    }elseif(empty($message)){
        $msg = siconv('����������', 'utf-8', 'gbk');
    }else {
        $msg = siconv('�ٱ�ʧ��', 'utf-8', 'gbk');
    }
    echo json_encode(array('status' => $status, 'msg' => $msg));

} else if($do == 'getgroup') {

    //��ȡ���ѷ���
    $groups = getfriendgroup();
    foreach($groups as $k => $group) {
        $groups[$k] = siconv($group, 'utf-8', 'gbk');
    }
    echo json_encode($groups);

} else if ($do == 'changegroup') {

    //����û���
    if(!$_SGLOBAL['supe_uid']) {
        $status = '0';
        $msg = siconv('�Բ���,����û�е�¼', 'utf-8', 'gbk');
        exit;
    }
    $gid  = $_POST['gid'];
    $fuid = $_POST['fuid'];
    if($fuid) {
        updatetable('friend', array('gid' => intval($_POST['gid'])), array('uid' => $_SGLOBAL['supe_uid'], 'fuid' => $fuid));
        friend_cache($_SGLOBAL['supe_uid']);
        $status = '1';
        $msg = '�����ɹ���';
    } else {
        $status = '0';
        $msg = '����ʧ�ܣ�������';
    }
    $msg = siconv($msg, 'utf-8', 'gbk');
    echo json_encode(array('status' => $status, 'msg' => $msg));

} else if ($do == 'checkseccode') {

    //��֤��
    $msg = (ckseccode(trim($_POST['seccode']))) ? 1 : 0;
    echo $msg;

} else if ($do == 'feedback') {

    //�û�����
    echo 'asdfasdf';exit;

} else {

    exit('Undefined Action!');

}
?>
