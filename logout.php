<?php
define('IN_SAESPOT', 1);

include_once(dirname(__FILE__) . '/config.php');
include_once(dirname(__FILE__) . '/common.php');

if($cur_user){
    setcookie("cur_uid", '', $timestamp-86400 * 365, '/');
    setcookie("cur_uname", '', $timestamp-86400 * 365, '/');
    setcookie("cur_ucode", '', $timestamp-86400 * 365, '/');
    $MMC->delete('u_'.$cur_user['id']);
    header('Location: /');
}else{
    header('Location: /');
}
exit;

?>
