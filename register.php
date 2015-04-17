<?php

/**
 *   [Discuz!] (C)2001-2007 Comsenz Inc.
 *   This is NOT a freeware, use is subject to license terms
 *   $RCSfile: register.php,v $
 *   $Revision: 1.63.2.6 $
 *   $Date: 2007/03/21 15:52:05 $
 */

define('CURSCRIPT', 'register');
define('NOROBOT', TRUE);

require_once './config.php';
if ( !defined('SSO_HOST') ) {
    die('BAD REQUEST<!--Nead SSO_HOST-->');    // ±ØÐë¶¨ÒåSSO_HOST
}
require_once './common.php';

if (defined('SSO_HOST')) {
    $referer = dreferer();
    $rurl = urlencode( "http://".$_SERVER['HTTP_HOST']."/logging.php?action=login&loginsubmit=1&referer=$referer" );
    header("Location: ". SSO_HOST . "/Register?return_url=$rurl");
    exit();
}

?>
