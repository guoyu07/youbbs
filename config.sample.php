<?php
define('ROOT', dirname(__FILE__));

if (!defined('IN_SAESPOT')) {
    include_once(dirname(__FILE__) . '/error/403.php');
    exit;
};

/*********************************
 ******** 请修改以下设置 *********
 *********************************/

// bucket 名称，访问 http://developer.baidu.com/bae/bcs/bucket/ 查看
define('BUCKET', 'bucket_name_here');

// 数据库名，参见 http://developer.baidu.com/wiki/index.php?title=docs/cplat/rt/php/mysql#.E7.AE.A1.E7.90.86
$dbname = 'database_name_here';

/*********************************
 ******* 请不要再继续编辑 ********
 *** 请保存本文件为 config.php ***
 *********************************/

//AK 公钥
define ('BCS_AK', getenv('HTTP_BAE_ENV_AK'));
//SK 私钥
define ('BCS_SK', getenv('HTTP_BAE_ENV_SK'));

//数据库主机名或IP
$servername = getenv('HTTP_BAE_ENV_ADDR_SQL_IP');

//数据端口
$dbport = getenv('HTTP_BAE_ENV_ADDR_SQL_PORT');

//MySQL字符集
$dbcharset = 'utf8';
//系统默认字符集
$charset = 'utf-8';

// 定义头像、图库基础网址
define('TUCHUANG_URL', 'http://bcs.duapp.com/'.BUCKET);

// 定义缓存
require('BaeMemcache.class.php');
$MMC = new BaeMemcache();

/*********************************
 ************* BCS ***************
 *********************************/

define ( 'BCS_HOST', 'bcs.duapp.com' );
//superfile 每个object分片后缀
define ( 'BCS_SUPERFILE_POSTFIX', '_bcs_superfile_' );
//sdk superfile分片大小 ，单位 B（字节）
define ( 'BCS_SUPERFILE_SLICE_SIZE', 1024 * 1024 );

?>