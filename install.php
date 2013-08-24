<?php
define('IN_SAESPOT', 1);
define('ROOT', dirname(__FILE__));

header("Content-Type: text/html; charset=UTF-8");

$configFile = ROOT . '/config.php';
if(!is_readable($configFile)) {
	exit('配置文件不存在，请按照说明编辑 config.sample.php 并保存为 config.php 后再安装');
}

$sqlFile = ROOT . '/yunbbs_mysql.sql';
if(!is_readable($sqlFile)) {
	exit('数据库文件不存在 或 读取失败');
}

$fp = fopen($sqlFile, 'rb');
$sql = fread($fp, 2048000);
fclose($fp);

include_once (ROOT . '/config.php');
include_once (ROOT . '/libs/mysql.class.php');

$DBS = new DB_MySQL;
$DBS->connect($servername, $dbport, BCS_AK, BCS_SK, $dbname);

$DBS->select_db($dbname);
if($DBS->geterrdesc()) {
	if(mysql_get_server_info() > '4.1') {
		$DBS->query("CREATE DATABASE $dbname DEFAULT CHARACTER SET $dbcharset");
	} else {
		$DBS->query("CREATE DATABASE $dbname");
	}

	if($DBS->geterrdesc()) {
		exit('指定的数据库不存在, 系统也无法自动建立, 无法安装');
	} else {
		$DBS->select_db($dbname);
		//成功建立指定数据库
	}
}

$DBS->query("SELECT COUNT(*) FROM yunbbs_settings", 'SILENT');
if(!$DBS->geterrdesc()) {
	// BAE目前不支持清空缓存
	// $MMC->flush();
	header('Location: /');
	exit('程序已经装好了，不能重复安装，若要重装，先删除 MySQL 里全部数据。 直接进入<a href="/">首页</a>');
}

runquery($sql);

$timestamp = time();
$DBS->unbuffered_query("UPDATE yunbbs_settings SET value='$timestamp' WHERE title='site_create'");

$DBS->close();

// BAE目前不支持清空缓存
//$MMC->flush();

// 拷贝三种格式默认头像
// 上传到云存储
include_once(ROOT . '/libs/bcs.class.php');

$baidu_bcs = new BaiduBCS ( BCS_AK, BCS_SK, BCS_HOST );

try{
    $response = (array)$baidu_bcs->create_object(BUCKET, '/avatar/large/0.png', 'static/avatar/0-large.png', array('acl'=>'public-read'));
}catch (Exception $e){
    exit('百度云存储创建 large 对象失败，请稍后再试！' );
}
try{
    $response = (array)$baidu_bcs->create_object(BUCKET, '/avatar/normal/0.png', 'static/avatar/0-normal.png', array('acl'=>'public-read'));
}catch (Exception $e){
    exit('百度云存储创建 normal 对象失败，请稍后再试！' );
}
try{
    $response = (array)$baidu_bcs->create_object(BUCKET, '/avatar/mini/0.png', 'static/avatar/0-mini.png', array('acl'=>'public-read'));
}catch (Exception $e){
    exit('百度云存储创建 normal 对象失败，请稍后再试！' );
}


function runquery($sql) {
	global $dbcharset, $DBS;

	$sql = str_replace("\r", "\n", $sql);
	$ret = array();
	$num = 0;
	foreach(explode(";\n", trim($sql)) as $query) {
		$queries = explode("\n", trim($query));
		foreach($queries as $query) {
			$ret[$num] .= $query[0] == '#' ? '' : $query;
		}
		$num++;
	}
	unset($sql);

	foreach($ret as $query) {
		$query = trim($query);
		if($query) {
			if(substr($query, 0, 12) == 'CREATE TABLE') {
				$name = preg_replace("/CREATE TABLE ([a-z0-9_]+) .*/is", "\\1", $query);
				//echo '创建表 '.$name.' ... 成功<br />';
				$DBS->query(createtable($query, $dbcharset));
			} else {
				$DBS->query($query);
			}
		}
	}
}

function createtable($sql, $dbcharset) {
	$type = strtoupper(preg_replace("/^\s*CREATE TABLE\s+.+\s+\(.+?\).*(ENGINE|TYPE)\s*=\s*([a-z]+?).*$/isU", "\\2", $sql));
	$type = in_array($type, array('MYISAM', 'HEAP')) ? $type : 'MYISAM';
	return preg_replace("/^\s*(CREATE TABLE\s+.+\s+\(.+?\)).*$/isU", "\\1", $sql).(mysql_get_server_info() > '4.1' ? " ENGINE=$type DEFAULT CHARSET=$dbcharset" : " TYPE=$type");
}

// echo '安装完成！ 进入<a href="/">首页</a>';
header('Location: /');

?>
