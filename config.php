<?php
/**
 * �����͡�վ�������ļ�
 * $Id: config.php-dist 27 2009-09-25 11:33:10Z wukai$ 
 */

//Ucenter Home���ò���
//190 ���Ի�

$_SC = array();
$_SC['dbhost']          = '127.0.0.1'; //��������ַ
$_SC['dbuser']          = 'root'; //�û�
$_SC['dbpw']            = 'xiaolang'; //����
$_SC['dbcharset']       = 'gbk'; //�ַ���
$_SC['pconnect']        = 0; //�Ƿ��������
$_SC['dbname']          = 'shuodao'; //���ݿ�
$_SC['tablepre']        = ''; //����ǰ׺
$_SC['charset']         = 'gbk'; //ҳ���ַ���

$_SC['gzipcompress']    = 0; //����gzip

$_SC['cookiepre']       = 'sd_'; //COOKIEǰ׺
$_SC['cookiedomain']    = '.shuodaoer.com'; //COOKIE������
$_SC['cookiepath']      = '/'; //COOKIE����·��
/*modify*/
$_SC['attachdir']       = 'attachments\\'; //�������ر���λ��(������·��, ���� 777, ����Ϊ web �ɷ��ʵ���Ŀ¼, ���Ŀ¼����� "./" ��ͷ, ĩβ�� "/")

$_SC['siteurl']         = 'http://www.shuodaoer.com/'; //վ��ķ���URL��ַ(http:// ��ͷ�ľ��Ե�ַ, ĩβ�� "/")��Ϊ�յĻ���ϵͳ���Զ�ʶ��
$_SC['attachurl']       = $_SC['siteurl'].'attachments/'; //��������URL��ַ(��Ϊ��ǰ URL �µ���Ե�ַ�� http:// ��ͷ�ľ��Ե�ַ, ĩβ�� "/")


$_SC['tplrefresh']      = 0; //�ж�ģ���Ƿ���µ�Ч�ʵȼ�����ֵԽ��Ч��Խ��; ����Ϊ0�����ò��ж�

//Ucenter Home��ȫ���
$_SC['founder']         = '24050324'; //��ʼ�� UID, ����֧�ֶ����ʼ�ˣ�֮��ʹ�� ��,�� �ָ������ֹ�����ֻ�д�ʼ�˲ſɲ�����
$_SC['allowedittpl']    = 0; //�Ƿ��������߱༭ģ�塣Ϊ�˷�������ȫ��ǿ�ҽ���ر�

/*gaohua*/
$_SC['cookieexpire'] = '315360000';
$_SC['cssdir'] = $_SC['siteurl'].'css/';
$_SC['jsdir'] = $_SC['siteurl'].'js/';
$_SC['imgdir'] = $_SC['siteurl'].'images/';
$_SC['email_msg']

 = '
<pre>
��л��ע��˵����! 

��ĵ�¼����Ϊ:

<<LOGIN_NAME>>

�����ϵ������ע��ȷ�����ӣ��������˵�����ʺţ� 

<<ACTIVE_LINK>>

����������48Сʱ����Ч��48Сʱ��Ҫ����ע�ᣩ 

������������޷����ʣ��뽫����ַ���Ʋ�ճ�����µ�����������С�  

����������յ��˴˵����ʼ���������ִ���κβ�����ȡ���ʺţ����ʺŽ����������� 

��ֻ��һ��ϵͳ�Զ��������ʼ����벻Ҫֱ�ӻظ���</pre> ';
$_SC['rand'] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

?>
