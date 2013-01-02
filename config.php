<?php
/**
 *程序官方支持社区 http://youbbs.sinaapp.com/
 *欢迎交流！
 *youBBS是开源项目，可自由修改，但要保留Powered by 链接信息
 * 1.04 百度BAE 云存储版 Jat修改
 * http://www.sinosky.org
 */
// 定义头像、图库基础网址
define('TUCHUANG_URL', 'http://bcs.duapp.com/XXXXX');  //XXXXX换成自己的bucket名称

//数据库主机名或IP
$servername = getenv('HTTP_BAE_ENV_ADDR_SQL_IP');
//数据库用户名
$dbusername = getenv('HTTP_BAE_ENV_AK');
//数据库密码
$dbpassword = getenv('HTTP_BAE_ENV_SK');
//数据库名
$dbname = 'XXXXX';//自己的数据库名称
//数据端口
$dbport = getenv('HTTP_BAE_ENV_ADDR_SQL_PORT');

//MySQL字符集
$dbcharset = 'utf8';
//系统默认字符集
$charset = 'utf-8';

// 定义缓存
require('BaeMemcache.class.php');
$MMC = new BaeMemcache();

?>