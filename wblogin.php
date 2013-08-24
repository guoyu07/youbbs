<?php
define('IN_SAESPOT', 1);
define('ROOT', dirname(__FILE__));

include_once(ROOT . '/config.php');
include_once(ROOT . '/common.php');

include_once(ROOT . "/libs/saetv2.ex.class.php");

$o = new SaeTOAuthV2( $options['wb_key'] , $options['wb_secret'] );

$code_url = $o->getAuthorizeURL( 'http://'.$_SERVER['HTTP_HOST'].'/wbcallback' );

header("Location:$code_url");
exit;

?>
