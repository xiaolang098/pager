<?php
/*
    [UCenter Home] (C) 2007-2008 Comsenz Inc.
    $Id: lang_showmessage.php 13183 2009-08-17 04:35:11Z xupeng $
*/

if(!defined('IN_UCHOME')) {
    exit('Access Denied');
}

$_SGLOBAL['msglang'] = array(

    'box_title' => '��Ϣ',

    //common
    'do_success' => '���еĲ��������',
    'no_privilege' => '��Ŀǰû��Ȩ�޽��д˲���',
    'no_privilege_realname' => '����Ҫ��д��ʵ��������ܽ��е�ǰ������<a href="cp.php?ac=profile">������������ʵ����</a>',
    'no_privilege_videophoto' => '����Ҫ��Ƶ��֤ͨ������ܽ��е�ǰ������<a href="cp.php?ac=videophoto">�����������Ƶ��֤</a>',
    'no_open_videophoto' => 'Ŀǰվ���Ѿ��ر���Ƶ��֤����',
    'is_blacklist' => '�ܶԷ�����˽����Ӱ�죬��Ŀǰû��Ȩ�޽��б�����',
    'no_privilege_newusertime' => '��Ŀǰ���ڼ�ϰ�ڼ䣬��Ҫ�ȴ� \\1 Сʱ����ܽ��б�����',
    'no_privilege_avatar' => '����Ҫ�����Լ���ͷ�����ܽ��б�������<a href="cp.php?ac=avatar">����������</a>',
    'no_privilege_friendnum' => '����Ҫ��� \\1 ������֮�󣬲��ܽ��б�������<a href="cp.php?ac=friend&op=find">��������Ӻ���</a>',
    'no_privilege_email' => '����Ҫ��֤�����Լ����������ܽ��б�������<a href="cp.php?ac=profile&op=contact">�����Ｄ������</a>',
    'uniqueemail_check' => '������������ַ�Ѿ���ռ�ã��볢��ʹ����������',
    'uniqueemail_recheck' => '��Ҫ��֤�������ַ�Ѿ�������ˣ����������������������Լ�������',
    'you_do_not_have_permission_to_visit' => '���ѱ���ֹ���ʡ�',

    //mt.php
    'designated_election_it_does_not_exist' => 'ָ����Ⱥ�鲻���ڣ������Գ��Դ���',
    'mtag_tagname_error' => '���õ�Ⱥ�����Ʋ�����Ҫ��',
    'mtag_join_error' => '����ָ����Ⱥ��ʧ�ܣ��볢���������е����Ⱥ�飬������Ӧ��Ⱥ���������Ϊ��Ա',
    'mtag_join_field_error' => 'Ⱥ����� \\1 �������ֻ������� \\2 ��Ⱥ�飬���Ѿ���������',
    'mtag_creat_error' => '��Ҫ�鿴��Ⱥ��Ŀǰ��û�б�����',

    //index.php
    'enter_the_space' => '������˿ռ�ҳ��',

    //network.php
    'points_deducted_yes_or_no' => '���β������ۼ��� \\1 �����֣�\\2 ������ֵ��ȷ�ϼ�����<br><br><a href="\\3" class="submit">��������</a> &nbsp; <a href="javascript:history.go(-1);" class="button">ȡ��</a>',
    'points_search_error' => "�����ڵĻ��ֻ���ֵ���㣬�޷���ɱ�������",

    //source/cp_album.php
    'photos_do_not_support_the_default_settings' => 'Ĭ����᲻֧�ֱ�����',
    'album_name_errors' => '��û����ȷ���������',

    //source/space_app.php
    'correct_choice_for_application_show' => '��ѡ����ȷ��Ӧ�ý��в鿴',

    //source/do_login.php
    'users_were_not_empty_please_re_login' => '�Բ����û�������Ϊ�գ������µ�¼',
    'login_failure_please_re_login' => '�Բ���,��¼ʧ��,�����µ�¼',

    //source/cp_blog.php
    'no_authority_expiration_date' => '����ǰȨ���ѱ�����Ա��ʱ���ƣ��ָ���ʱ��Ϊ��\\1',
    'no_authority_expiration' => '����ǰȨ���ѱ�����Ա���ƣ���������ǵĹ���',
    'no_authority_to_add_log' => '��Ŀǰû��Ȩ�������־',
    'no_authority_operation_of_the_log' => '��û��Ȩ�޲�������־',
    'that_should_at_least_write_things' => '����Ӧ��дһ�㶫��',
    'failed_to_delete_operation' => 'ɾ��ʧ�ܣ��������',

    'click_error' => 'û�н��������ı�̬����',
    'click_item_error' => 'Ҫ��̬�Ķ��󲻴���',
    'click_no_self' => '�Լ����ܸ��Լ���̬',
    'click_have' => '���Ѿ����̬��',
    'click_success' => '�����̬�����',

    //source/cp_class.php
    'did_not_specify_the_type_of_operation' => 'û����ȷָ��Ҫ�����ķ���',
    'enter_the_correct_class_name' => '����ȷ���������',

    'note_wall_reply_success' => '�Ѿ��ظ��� \\1 �����԰�',

    //source/cp_comment.php

    'operating_too_fast' => "���η�������̫���ˣ���� \\1 ��������",
    'content_is_too_short' => '��������ݲ�������2���ַ�',
    'comments_do_not_exist' => 'ָ�������۲�����',
    'do_not_accept_comments' => '����־����������',
    'sharing_does_not_exist' => '���۵ķ�������',
    'non_normal_operation' => '����������',
    'the_vote_only_allows_friends_to_comment' => '��ͶƱֻ�����������',

    //source/cp_common.php
    'security_exit' => '���Ѿ���ȫ�˳���\\1',

    //source/cp_doing.php
    'should_write_that' => '����Ӧ��дһ�㶫��',
    'docomment_error' => '����ȷָ��Ҫ���۵ļ�¼',

    //source/cp_invite.php
    'mail_can_not_be_empty' => '�ʼ��б���Ϊ��',
    'send_result_1' => '�ʼ��Ѿ��ͳ������ĺ��ѿ�����Ҫ�����Ӻ�����յ��ʼ�',
    'send_result_2' => '<strong>�����ʼ�����ʧ��:</strong><br/>\\1',
    'send_result_3' => 'δ�ҵ���Ӧ�������¼, �ʼ��ط�ʧ��.',
    'there_is_no_record_of_invitation_specified' => '��ָ���������¼������',

    //source/cp_import.php
    'blog_import_no_result' => '"�޷���ȡԭ���ݣ���ȷ������ȷ�����վ��URL���ʺ���Ϣ������������:<br /><textarea name=\"tmp[]\" style=\"width:98%;\" rows=\"4\">\\1</textarea>"',
    'blog_import_no_data' => '��ȡ����ʧ�ܣ���ο�����������:<br />\\1',
    'support_function_has_not_yet_opened fsockopen' => 'վ����δ����fsockopen����֧�֣�������ʹ�ñ�����',
    'integral_inadequate' => "�����ڵĻ��� \\1 ��������ɱ��β���������������Ҫ����: \\2",
    'experience_inadequate' => "�����ڵľ���ֵ\\1 ��������ɱ��β���������������Ҫ����ֵ: \\2",
    'url_is_not_correct' => '�������վURL����ȷ',
    'choose_at_least_one_log' => '������ѡ��һ��Ҫ�������־',

    //source/cp_friend.php
    'friends_add' => '���� \\1 ��Ϊ������',
    'you_have_friends' => '�����Ѿ��Ǻ�����',
    'enough_of_the_number_of_friends' => '����ǰ�ĺ�����Ŀ�ﵽϵͳ���ƣ�����ɾ�����ֺ���',
    'enough_of_the_number_of_friends_with_magic' => '����ǰ�ĺ�����Ŀ�ﵽϵͳ���ƣ�<a id="a_magic_friendnum2" href="magic.php?mid=friendnum" onclick="ajaxmenu(event, this.id, 1)">ʹ�ú������ݿ�����</a>',
    'request_has_been_sent' => '���������Ѿ����ͣ���ȴ��Է���֤��',
    'waiting_for_the_other_test' => '���ڵȴ��Է���֤��',
    'please_correct_choice_groups_friend' => '����ȷѡ��������',
    'specified_user_is_not_your_friend' => 'ָ�����û����������ĺ���',

    //source/cp_mtag.php
    'mtag_managemember_no_privilege' => '�����ܶԵ�ǰѡ���ĳ�Ա����Ⱥ��Ȩ�ޱ��������������ѡ��',
    'mtag_max_inputnum' => '�޷����룬������Ŀ "\\1" �е�Ⱥ����Ŀ�Ѵﵽ \\2 ��������Ŀ',
    'you_are_already_a_member' => '���Ѿ��Ǹ�Ⱥ��ĳ�Ա��',
    'join_success' => '����ɹ����������Ǹ�Ⱥ��ĳ�Ա��',
    'the_discussion_topic_does_not_exist' => '�Բ��𣬲������۵Ļ��ⲻ����',
    'content_is_not_less_than_four_characters' => '�Բ������ݲ�������2���ַ�',
    'you_are_not_a_member_of' => '�����Ǹ�Ⱥ��ĳ�Ա',
    'unable_to_manage_self' => '�����ܶ��Լ����в���',
    'mtag_joinperm_1' => '���Ѿ�ѡ������Ⱥ�飬��ȴ�Ⱥ��������ļ�������',
    'mtag_joinperm_2' => '��Ⱥ����Ҫ�յ�Ⱥ���������ܼ���',
    'invite_mtag_ok' => '�ɹ������Ⱥ�飬�����ԣ�<a href="space.php?do=mtag&tagid=\\1" target="_blank">�������ʸ�Ⱥ��</a>',
    'invite_mtag_cancel' => '���Ը�Ⱥ���������',
    'failure_to_withdraw_from_group' => '�˳�˽��Ⱥ��ʧ��,����ָ��һ����Ⱥ��',
    'fill_out_the_grounds_for_the_application' => '����дȺ����������',

    //source/cp_pm.php
    'this_message_could_not_be_deleted' => 'ָ���Ķ���Ϣ���ܱ�ɾ��',
    'unable_to_send_air_news' => '���ܷ��Ϳ���Ϣ',
    'message_can_not_send' => '�Բ��𣬷��Ͷ���Ϣʧ��',
    'message_can_not_send1' => '����ʧ�ܣ�����ǰ������24Сʱ��������Ͷ���Ϣ��Ŀ',
    'message_can_not_send2' => '���η��Ͷ���Ϣ̫�죬���Ե�һ���ٷ���',
    'message_can_not_send3' => '�����ܸ��Ǻ����������Ͷ���Ϣ',
    'message_can_not_send4' => 'Ŀǰ��������ʹ�÷��Ͷ���Ϣ����',
    'not_to_their_own_greeted' => '�������Լ����к�',
    'has_been_hailed_overlooked' => '�к��Ѿ�������',

    //source/cp_profile.php
    'realname_too_short' => '��ʵ������������4���ַ�',
    'update_on_successful_individuals' => '�������ϸ��³ɹ���',

    //source/cp_poll.php
    'no_authority_to_add_poll' => '��Ŀǰû��Ȩ�����ͶƱ',
    'no_authority_operation_of_the_poll' => '��û��Ȩ�޲�����ͶƱ',
    'add_at_least_two_further_options' => '�����������������ͬ�ĺ�ѡ��',
    'the_total_reward_should_not_overrun' => '���������ܶ�ܳ���\\1',
    'wrong_total_reward' => '�����ܶ��С��ƽ�����Ͷ��',
    'voting_does_not_exist' => 'ͶƱ��Ϣ������',
    'already_voted' => '���Ѿ�Ͷ��Ʊ',
    'option_exceeds_the_maximum_number_of' => '���������,����ܳ���20��ͶƱ��',
    'the_total_reward_should_not_be_empty' => '�����ܶ��Ϊ��',
    'average_reward_should_not_be_empty' => 'ƽ��ÿ�����Ͷ�Ȳ���Ϊ��',
    'average_reward_can_not_exceed' => 'ƽ��ÿ��������߲��ܳ���\\1������',
    'added_option_should_not_be_empty' => '�����ӵĺ�ѡ���Ϊ��',
    'time_expired_error' => '����ʱ�䲻��С�ڵ�ǰʱ��',
    'please_select_items_to_vote' => '������ѡ��һ��ͶƱѡ��',
    'fill_in_at_least_an_additional_value' => '���������һ��׷������ֵ',

    //source/cp_share.php
    'blog_does_not_exist' => 'ָ������־������',
    'logs_can_not_share' => 'ָ������־����˽���ò��ܹ�������',
    'album_does_not_exist' => 'ָ������᲻����',
    'album_can_not_share' => 'ָ�����������˽���ò��ܹ�������',
    'image_does_not_exist' => 'ָ����ͼƬ������',
    'image_can_not_share' => 'ָ����ͼƬ����˽���ò��ܹ�������',
    'topics_does_not_exist' => 'ָ���Ļ��ⲻ����',
    'mtag_fieldid_does_not_exist' => 'ָ����Ⱥ����಻����',
    'tag_does_not_exist' => 'ָ���ı�ǩ������',
    'url_incorrect_format' => '�������ַ��ʽ����ȷ',
    'description_share_input' => '��������������',
    'poll_does_not_exist' => 'ָ����ͶƱ������',
    'share_not_self' => '�㲻�ܷ����Լ��������Ϣ(��ͼƬ)',
    'share_space_not_self' => '�㲻�ܷ����Լ�����ҳ',

    //source/cp_space.php
    'domain_length_error' => '���õĶ����������Ȳ���С��\\1���ַ�',
    'credits_exchange_invalid' => '�һ��Ļ��ַ����д����ܽ��жһ����뷵���޸ġ�',
    'credits_transaction_amount_invalid' => '��Ҫת�˻�һ��Ļ����������������뷵���޸ġ�',
    'credits_password_invalid' => '��û�����������������󣬲��ܽ��л��ֲ������뷵�ء�',
    'credits_balance_insufficient' => '�Բ������Ļ������㣬�һ�ʧ�ܣ��뷵�ء�',
    'extcredits_dataerror' => '�һ�ʧ�ܣ��������Ա��ϵ��',
    'domain_be_retained' => '���趨��������ϵͳ��������ѡ����������',
    'not_enabled_this_feature' => 'ϵͳ��û�п���������',
    'space_size_inappropriate' => '����ȷָ��Ҫ�һ����ϴ��ռ��С',
    'space_does_not_exist' => '�Բ�����ָ�����û��ռ䲻���ڡ�',
    'integral_convertible_unopened' => 'ϵͳĿǰû�п������ֶһ�����',
    'two_domain_have_been_occupied' => '���õĶ��������Ѿ�����ʹ����',
    'only_two_names_from_english_composition_and_figures' => '���õĶ���������Ҫ��Ӣ����ĸ��ͷ��ֻ��Ӣ�ĺ����ֹ���',
    'two_domain_length_not_more_than_30_characters' => '���õĶ����������Ȳ��ܳ���30���ַ�',
    'old_password_invalid' => '��û���������������������뷵��������д��',
    'no_change' => 'û�����κ��޸�',
    'protection_of_users' => '�ܱ������û���û��Ȩ���޸�',

    //source/cp_sendmail.php
    'email_input' => '����û���������䣬����<a href="cp.php?ac=profile&op=contact">��ϵ��ʽ</a>��׼ȷ��д��������',
    'email_check_sucess' => '�������䣨\\1����֤���������',
    'email_check_error' => '�������������֤���Ӳ���ȷ���������ڸ�������ҳ�棬���½����µ�������֤���ӡ�',
    'email_check_send' => '��֤����ļ��������Ѿ����͵����ղ���д������,�����ڼ�����֮���յ������ʼ�����ע����ա�',
    'email_error' => '��д�������ʽ����,��������д',

    //source/cp_theme.php
    'theme_does_not_exist' => 'ָ���ķ�񲻴���',
    'css_contains_elements_of_insecurity' => '���ύ�����ݺ��в���ȫԪ��',

    //source/cp_upload.php
    'upload_images_completed' => '�ϴ�ͼƬ�����',

    //source/cp_thread.php
    'to_login' => '����Ҫ�ȵ�¼���ܼ���������',
    'title_not_too_little' => '���ⲻ������2���ַ�',
    'posting_does_not_exist' => 'ָ���Ļ��ⲻ����',
    'settings_of_your_mtag' => '����Ⱥ����ܷ����⣬����Ҫ������һ�����Ⱥ�顣<br>ͨ��Ⱥ�飬�����Խ�ʶ��������ͬѡ������ѣ�������һ�������⡣<br><br><a href="cp.php?ac=mtag" class="submit">�����ҵ�Ⱥ��</a>',
    'first_select_a_mtag' => '������Ӧ��ѡ��һ��Ⱥ����ܷ����⡣<br><br><a href="cp.php?ac=mtag" class="submit">�����ҵ�Ⱥ��</a>',
    'no_mtag_allow_thread' => '��ǰ������Ⱥ������������㣬�����ܽ��з����������<br><br><a href="cp.php?ac=mtag" class="submit">�����ҵ�Ⱥ��</a>',
    'mtag_close' => 'ѡ���Ⱥ���Ѿ������������ܽ��б�����',

    //source/space_album.php
    'to_view_the_photo_does_not_exist' => '�������ˣ���Ҫ�鿴����᲻����',

    //source/space_blog.php
    'view_to_info_did_not_exist' => '�������ˣ���Ҫ�鿴����Ϣ�����ڻ����Ѿ���ɾ��',

    //source/space_pic.php
    'view_images_do_not_exist' => '��Ҫ�鿴��ͼƬ������',

    //source/mt_thread.php
    'topic_does_not_exist' => 'ָ���Ļ��ⲻ����',

    //source/do_inputpwd.php
    'news_does_not_exist' => 'ָ������Ϣ������',
    'proved_to_be_successful' => '��֤�ɹ������ڽ���鿴ҳ��',
    'password_is_not_passed' => '�������վ��¼���벻��ȷ,�뷵������ȷ��',



    //source/do_login.php
    'login_success' => '��¼�ɹ��ˣ����������������¼ǰҳ�� \\1',
    'not_open_registration' => '�ǳ���Ǹ����վĿǰ��ʱ������ע��',
    'not_open_registration_invite' => '�ǳ���Ǹ����վĿǰ��ʱ�������û�ֱ��ע�ᣬ��Ҫ�к����������Ӳ���ע��',

    //source/do_lostpasswd.php
    'getpasswd_account_notmatch' => '�����˻�������û��������Email��ַ������ʹ��ȡ�����빦�ܣ����������������Ա��ϵ��',
    'getpasswd_email_notmatch' => '�����Email��ַ���û�����ƥ�䣬������ȷ�ϡ�',
    'getpasswd_send_succeed' => 'ȡ������ķ����Ѿ�ͨ�� Email ���͵����������У�<br />���� 3 ��֮���޸��������롣',
    'user_does_not_exist' => '���û�����',
    'getpasswd_illegal' => '�����õ� ID �����ڻ��Ѿ����ڣ��޷�ȡ�����롣',
    'profile_passwd_illegal' => '����ջ�����Ƿ��ַ����뷵��������д��',
    'getpasswd_succeed' => '�����������������ã���ʹ���������¼��',
    'getpasswd_account_invalid' => '�Բ��𣬴�ʼ�ˡ��ܱ����û�����վ������Ȩ�޵��û�����ʹ��ȡ�����빦�ܣ��뷵�ء�',
    'reset_passwd_account_invalid' => '�Բ��𣬴�ʼ�ˡ��ܱ����û�����վ������Ȩ�޵��û�����ʹ���������ù��ܣ��뷵�ء�',

    //source/do_register.php
    'registered' => 'ע��ɹ��ˣ�������˿ռ�',
    'system_error' => 'ϵͳ����δ�ҵ�UCenter Client�ļ�',
    'password_inconsistency' => '������������벻һ��',
    'profile_passwd_illegal' => '����ջ�����Ƿ��ַ�����������д��',
    'user_name_is_not_legitimate' => '�û������Ϸ�',
    'include_not_registered_words' => '�û�������������ע��Ĵ���',
    'user_name_already_exists' => '�û����Ѿ�����',
    'email_format_is_wrong' => '��д�� Email ��ʽ����',
    'email_not_registered' => '��д�� Email ������ע��',
    'email_has_been_registered' => '��д�� Email �Ѿ���ע��',
    'regip_has_been_registered' => 'ͬһ��IP�� \\1 Сʱ��ֻ��ע��һ���˺�',
    'register_error' => 'ע��ʧ��',

    //tag.php
    'tag_does_not_exist' => 'ָ���ı�ǩ������',

    //cp_poke.php
    'poke_success' => '�Ѿ����ͣ�\\1�´η���ʱ���յ�֪ͨ',
    'mtag_minnum_erro' => '��Ⱥ���Ա������ \\1 ���������ܽ��б�����',

    //source/function_common.php
    'information_contains_the_shielding_text' => '�Բ��𣬷�������Ϣ�а���վ�����ε�����',
    'site_temporarily_closed' => 'վ����ʱ�ر�',
    'ip_is_not_allowed_to_visit' => '���ܷ��ʣ�����ǰ��IP����վ��������ʵķ�Χ�ڡ�',
    'no_data_pages' => 'ָ����ҳ���Ѿ�û��������',
    'length_is_not_within_the_scope_of' => '��ҳ����������ķ�Χ��',

    //source/function_block.php
    'page_number_is_beyond' => 'ҳ���Ƿ񳬳���Χ',
    //source/function_cp.php
    'incorrect_code' => '�������֤�벻����������ȷ��',

    //source/function_space.php
    'the_space_has_been_closed' => '��Ҫ���ʵĿռ��ѱ�ɾ����������������ϵ����Ա',

    //source/network_album.php
    'search_short_interval' => '�����������̫�̣���ȴ� \\1 ��������� (<a href="\\2">��������</a>)',
    'set_the_correct_search_content' => '�Բ�����������ȷ�Ĳ�������',

    //source/space_share.php
    'share_does_not_exist' => 'Ҫ�鿴�ķ�������',

    //source/space_tag.php
    'tag_locked' => '��ǩ�Ѿ�������',

    'invite_error' => '�޷���ȡ���������룬��ȷ�����Ƿ����㹻�Ļ��������б�����',
    'invite_code_error' => '�Բ��������ʵ��������Ӳ���ȷ����ȷ�ϡ�',
    'invite_code_fuid' => '�Բ��������ʵ����������Ѿ�������ʹ���ˡ�',

    //source/do_invite.php
    'should_not_invite_your_own' => '�Բ���������ͨ�������Լ������������������Լ���',
    'close_invite' => '�Բ���ϵͳ�Ѿ��ر��˺������빦��',

    'field_required' => '���������еı�����Ŀ��\\1�� ����Ϊ�գ���ȷ��',
    'friend_self_error' => '�Բ��������ܼ��Լ�Ϊ����',
    'change_friend_groupname_error' => 'ָ���ĺ����û��鲻�ܱ�����',

    'mtag_not_allow_to_do' => '�����Ǹû�������Ⱥ��ĳ�Ա��û��Ȩ�޽��б�����',

    //cp_task
    'task_unavailable' => '��Ҫ������н����񲻴��ڻ��߻�û�п�ʼ���޷���������',
    'task_maxnum' => '��Ҫ������н������Ѿ��������������������ˣ��������Զ�ʧЧ',
    'update_your_mood' => '���ȸ���һ�������ڵ�����״̬��',

    'showcredit_error' => '��д��������Ҫ����0������С�����Ļ���������ȷ��',
    'showcredit_fuid_error' => '��ָ�����û���������ĺ��ѣ���ȷ��',
    'showcredit_do_success' => '���Ѿ��ɹ������ϰ���֣��Ͽ�鿴�Լ�������������',
    'showcredit_friend_do_success' => '���Ѿ��ɹ����ͺ����ϰ���֣����ѻ��յ�֪ͨ��',

    'submit_invalid' => '����������·����ȷ�����֤���������޷��ύ���볢��ʹ�ñ�׼��web��������в�����',
    'no_privilege_my_status' => '�Բ��𣬵�ǰվ���Ѿ��ر����û���Ӧ�÷���',
    'no_privilege_myapp' => '�Բ��𣬸�Ӧ�ò����ڻ��ѹرգ�������<a href="cp.php?ac=userapp&my_suffix=%2Fapp%2Flist">ѡ������Ӧ��</a>',

    'report_error' => '�Բ�������ȷָ��Ҫ�ٱ��Ķ���',
    'report_success' => '��л���ľٱ������ǻᾡ�촦��',
    'manage_no_perm' => '��ֻ�ܶ��Լ���������Ϣ���й���<a href="javascript:;" onclick="hideMenu();">[�ر�]</a>',
    'repeat_report' => '�Բ����벻Ҫ�ظ��ٱ�',
    'the_normal_information' => 'Ҫ�ٱ��Ķ��󱻹���Ա��Ϊû��Υ�棬����Ҫ�ٴξٱ���',
    'friend_ignore_next' => '�ɹ������û� \\1 �ĺ������룬����������һ��������(<a href="cp.php?ac=friend&op=request">ֹͣ</a>)',
    'friend_addconfirm_next' => '���Ѿ��� \\1 ��Ϊ�˺��ѣ�����������һ������������(<a href="cp.php?ac=friend&op=request">ֹͣ</a>)',

    //source/cp_event.php
    'event_title_empty'=>'����Ʋ���Ϊ��',
    'event_classid_empty'=>'����ѡ������',
    'event_city_empty'=>'����ѡ������',
    'event_detail_empty'=>'������д�����',
    'event_bad_time_range'=>'�����ʱ�䲻�ܳ���60��',
    'event_bad_endtime'=>'�����ʱ�䲻�����ڿ�ʼʱ��',
    'event_bad_deadline'=>'�������ֹʱ�䲻�����ڻ����ʱ��',
    'event_bad_starttime'=>'���ʼʱ�䲻����������',
    'event_already_full'=>'�˻������������',
    'event_will_full' => '�����������������������',
    'no_privilege_add_event'=>'��û��Ȩ�޷����»',
    'no_privilege_edit_event'=>'��û��Ȩ�ޱ༭��������Ϣ',
    'no_privilege_manage_event_members' =>'��û��Ȩ�޹��������ĳ�Ա',
    'no_privilege_manage_event_comment' => '��û��Ȩ�޹�������������',
    'no_privilege_manage_event_pic' => '��û��Ȩ�޹������������',
    'no_privilege_do_eventinvite' =>'��û��Ȩ�޷��ͻ����',
    'event_does_not_exist'=>'������ڻ��ѱ�ɾ��',
    'event_create_failed'=>'�����ʧ�ܣ���������������Ϣ',
    'event_need_verify'=>'������ɹ����ȴ�����Ա���',
    'upload_photo_failed'=>'�ϴ������ʧ��',
    'choose_right_eventmember'=>'��ѡ����ʵĻ��Ա���в���',
    'choose_event_pic'=>'��ѡ����Ƭ',
    'only_creator_can_set_admin'=>'ֻ�д����߿�������������֯��',
    'event_not_set_verify'=>'�����Ҫ���',
    'event_join_limit'=>'�˻ֻ��ͨ��������ܼ���',
    'cannot_quit_event'=>'�������˳������Ϊ����û�м����������������ķ�����',
    'event_not_public'=>'����һ���ǹ������ֻ��ͨ��������ܲ鿴',
    'no_privilege_do_event_invite' => '�˻�����û��������',
    'event_under_verify' => '�˻���������',
    'cityevent_under_condition' => 'Ҫ���ͬ�ǻ����Ҫ���������ľ�ס��',
    'event_is_over' => '�˻�Ѿ�����',
    'event_meet_deadline'=>'��Ѿ���ֹ����',
    'bad_userevent_status'=>'��ѡ����ȷ�Ļ��Ա״̬',
    'event_has_followed'=>'���Ѿ���ע�˴˻',
    'event_has_joint'=>'���Ѿ������˴˻',
    'event_is_closed'=>'��Ѿ��ر�',
    'event_only_allows_members_to_comment'=>'�˻ֻ������Ա��������',
    'event_only_allows_admins_to_upload'=>'�˻ֻ����֯�߿����ϴ���Ƭ',
    'event_only_allows_members_to_upload'=>'ֻ�л��Ա�����ϴ����Ƭ',
    'eventinvite_does_not_exist'=>'��û�иû�Ļ����',
    'event_can_not_be_opened' => '�˻���ڲ��ܱ�����',
    'event_can_not_be_closed' => '�˻���ڲ��ܱ��ر�',
    'event_only_allows_member_thread' => 'ֻ�л��Ա���ܷ����ظ������',
    'event_mtag_not_match' => 'ָ��Ⱥ��û�й��������',
    'event_memberstatus_limit' => '�˻Ϊ˽�ܻ��ֻ�л��Ա���ܷ���',
    'choose_event_thread' => '��ѡ������һ���������в���',

    //source/cp_magic.php
    'magicuse_success' => '����ʹ�óɹ���',
    'unknown_magic' => 'ָ���ĵ��߲����ڻ��ѱ���ֹʹ��',
    'choose_a_magic' => '��ѡ��һ������',
    'magic_is_closed' => '�˵����ѱ�����',
    'magic_groupid_not_allowed' => '�����ڵ��û���û��Ȩ��ʹ�õ���',
    'input_right_buynum' => '����ȷ����Ҫ���������',
    'credit_is_not_enough' => '���Ļ��ֲ�������˵���',
    'not_enough_storage' => '���߿�������㣬�´β���ʱ���� \\1',
    'magicbuy_success' => '���߹���ɹ������ѻ��� \\1',
    'magicbuy_success_with_experence' => '���߹���ɹ������ѻ��� \\1, ���Ӿ��� \\2',
    'bad_friend_username_given' => '����ĺ�������Ч',
    'has_no_more_present_magic' => '����û�е���ת�����֤��<a id="a_buy_license" href="cp.php?ac=magic&op=buy&mid=license" onclick="ajaxmenu(event, this.id, 1)">����ȥ����</a>',
    'has_no_more_magic' => '����û�е��� \\1��<a id="\\2" href="\\3" onclick="ajaxmenu(event, this.id, 1)">���̹���</a>',
    'magic_can_not_be_presented' => '�˵��߲��ܱ�����',
    'magicpresent_success' => '�ѳɹ��� \\1 �����˵���',
    'magic_store_is_closed' => '�����̵��Ѿ��ر�',
    'magic_not_used_under_right_stage' => '�˵��߲����ڵ�ǰ����ʹ��',
    'magic_groupid_limit' => '����ǰ���ڵ��û��鲻�ܹ���õ���',
    'magic_usecount_limit' => '�ܵ���ʹ���������ƣ������ڻ�����ʹ�ô˵��ߡ�<br>���� \\1 ֮��ʹ��',
    'magicuse_note_have_no_friend' => '��û���κκ���',
    'magicuse_author_limit' => '�˵���ֻ�ܶ��Լ���������Ϣʹ��',
    'magicuse_object_count_limit' => '�˵��߶�ͬһ��Ϣʹ�ô����Ѵﵽ���ޣ�\\1 �Σ�',
    'magicuse_object_once_limit' => '�Ѿ��Ը���Ϣʹ�ù��˵��ߣ������ظ�ʹ��',
    'magicuse_bad_credit_given' => '������Ļ�������Ч',
    'magicuse_not_enough_credit' => '������Ļ�������������ǰӵ�еĻ���',
    'magicuse_bad_chunk_given' => '������ĵ��ݻ�������Ч',
    'magic_gift_already_given_out' => '����Ѿ���������',
    'magic_got_gift' => '���Ѿ���ȡ���˺�������� \\1 ������',
    'magic_had_got_gift' => '���Ѿ���ȡ���˴κ����',
    'magic_has_no_gift' => '��ǰ�ռ�û�����ú��',
    'magicuse_object_not_exist' => '���ߵ����ö��󲻴���',
    'magicuse_bad_object' => 'û����ȷѡ�����Ҫ���õĶ���',
    'magicuse_condition_limit' => '���ߵķ�����������',
    'magicuse_bad_dateline' => '�����ʱ����Ч',
    'magicuse_not_click_yet' => '����û�жԸ���Ϣ��̬��',
    'not_enough_coupon' => '����ȯ��Ŀ����',
    'magicuse_has_no_valid_friend' => '����ʹ��ʧ�ܣ�û���κκϷ��ĺ���',
    'magic_not_hidden_yet' => '�����ڲ�������״̬',
    'magic_not_for_sale' => '�˵��߲���ͨ��������',
    'not_set_gift' => '����ǰû�����ú��',
    'not_superstar_yet' => '�������ǳ�������',
    'no_flicker_yet' => '����û�жԴ���Ϣʹ�òʺ���',
    'no_color_yet' => '����û�жԴ���Ϣʹ�ò�ɫ��',
    'no_frame_yet' => '����û�жԴ���Ϣʹ�����',
    'no_bgimage_yet' => '����û�жԴ���Ϣʹ����ֽ',
    'bad_buynum' => '������Ĺ�����Ŀ����',

    'feed_no_found' => 'ָ��Ҫ�鿴�Ķ�̬������',
    'not_open_updatestat' => 'վ��û�п�������ͳ�ƹ���',
    
    'topic_subject_error' => '���ⳤ�Ȳ�Ҫ����4���ַ�',
    'topic_no_found' => 'ָ��Ҫ�鿴�����ֲ�����',
    'topic_list_none' => 'Ŀǰ��û�п��Բ��������',

    'space_has_been_locked' => '�ռ��ѱ������޷����ʣ�������������ϵ����Ա',

    
);

?>