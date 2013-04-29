<?php
define('IN_SAESPOT', 1);

include_once(dirname(__FILE__) . '/config.php');
include_once(dirname(__FILE__) . '/common.php');

//
$via = $_GET['via'];
if($via && $is_mobie){
    setcookie('vtpl', $via, $timestamp+86400 * 365, '/');
}
header('Location: /');
exit;

?>
