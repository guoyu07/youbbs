<?php
define('IN_SAESPOT', 1);
define('ROOT', dirname(__FILE__));

include_once(ROOT . '/config.php');
include_once(ROOT . '/common.php');

//
$via = $_GET['via'];
if($via && $is_mobie){
    setcookie('vtpl', $via, $timestamp+86400 * 365, '/');
}
header('Location: /');
exit;

?>
