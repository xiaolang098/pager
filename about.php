<?php
/**
 * 【极客】关于极客
 * $Id: about.php 27 2011-01-06 16:10:10Z wukai$
 */
include_once('./common.php');

$acs = array('aboutus', 'contact', 'zhaopin', 'map');
$ac = (!empty($_GET['ac']) && in_array($_GET['ac'], $acs)) ? $_GET['ac'] : 'aboutus';


include_once template('about');

?>