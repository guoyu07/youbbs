<?php
/**
 *程序官方支持社区 http://youbbs.sinaapp.com/
 *欢迎交流！
 *youBBS是开源项目，可自由修改，但要保留Powered by 链接信息
 *在 youBBS 的代码基础之上发布派生版本，名字可以不包含youBBS，
 *但是页脚需要带有 based on youBBS 的字样和链接。
 *v1.04 百度BAE云存储(BCS)版 Modified by Jat
 *http://www.sinosky.org
 */
// 定义头像、图库基础网址
define('TUCHUANG_URL', 'http://bcs.duapp.com/XXXXX'); //XXXXX 换成自己的 bucket 名称

//数据库主机名或IP
$servername = getenv('HTTP_BAE_ENV_ADDR_SQL_IP');
//数据库用户名
$dbusername = getenv('HTTP_BAE_ENV_AK');
//数据库密码
$dbpassword = getenv('HTTP_BAE_ENV_SK');
//数据库名
$dbname = 'XXXXX'; //XXXXX 换成自己的数据库名称
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