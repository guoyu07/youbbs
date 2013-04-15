<?php
if (!defined('IN_SAESPOT')) exit(header('location: /static/error/403.html'));

define ( 'BCS_HOST', 'bcs.duapp.com' );
//AK 公钥
define ( 'BCS_AK', 'XXXXX' );
//SK 私钥
define ( 'BCS_SK', 'XXXXX' );
//superfile 每个object分片后缀
define ( 'BCS_SUPERFILE_POSTFIX', '_bcs_superfile_' );
//sdk superfile分片大小 ，单位 B（字节）
define ( 'BCS_SUPERFILE_SLICE_SIZE', 1024 * 1024 );
//bucket 名称
define( 'BUCKET','XXXXX' );

?>
