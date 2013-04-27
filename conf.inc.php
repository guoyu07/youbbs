<?php
if (!defined('IN_SAESPOT')) {
    include_once(dirname(__FILE__) . '/403.php');
    exit;
};

define ( 'BCS_HOST', 'bcs.duapp.com' );
//AK 公钥
define ( 'BCS_AK', 'XXXXX' ); //XXXXX 换成自己的 Access Key
//SK 私钥
define ( 'BCS_SK', 'XXXXX' ); //XXXXX 换成自己的 Secure Key
//superfile 每个object分片后缀
define ( 'BCS_SUPERFILE_POSTFIX', '_bcs_superfile_' );
//sdk superfile分片大小 ，单位 B（字节）
define ( 'BCS_SUPERFILE_SLICE_SIZE', 1024 * 1024 );
//bucket 名称
define( 'BUCKET','XXXXX' ); //XXXXX 换成自己的 bucket 名称

?>
