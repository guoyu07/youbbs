<?php
define('IN_SAESPOT', 1);
define('ROOT', dirname(__FILE__));

include_once(ROOT . '/config.php');
include_once(ROOT . '/common.php');

$page = intval($_GET['page']);

$hide_nodes_str = $options['hide_nodes'] ? "AND cid <> ".str_replace(",", " AND cid <> ", $options['hide_nodes']) : "";

// 处理正确的页数
$table_status = $DBS->fetch_one_array("SELECT COUNT(*) FROM yunbbs_articles WHERE visible = 1 $hide_nodes_str");
$taltol_article = $table_status['COUNT(*)'];
$taltol_page = ceil($taltol_article/$options['list_shownum']);
if ($taltol_page == 0) $taltol_page = 1;
if ($page <= 0) {
    header("HTTP/1.1 301 Moved Permanently");
    header("Status: 301 Moved Permanently");
    header('Location: /page-1.html');
    exit;
}
if ($page > $taltol_page) {
    header('Location: /page-'.$taltol_page.'.html');
    exit;
}

// 获取最近文章列表
$query_sql = "SELECT a.id,a.cid,a.uid,a.ruid,a.title,a.addtime,a.edittime,a.comments,c.name as cname,u.avatar as uavatar,u.name as author,ru.name as rauthor
    FROM yunbbs_articles a
    LEFT JOIN yunbbs_categories c ON c.id=a.cid
    LEFT JOIN yunbbs_users u ON a.uid=u.id
    LEFT JOIN yunbbs_users ru ON a.ruid=ru.id
    WHERE visible = 1 $hide_nodes_str
    ORDER BY top,edittime DESC
    LIMIT ".($page-1)*$options['list_shownum'].", ".$options['list_shownum'];
$query = $DBS->query($query_sql);
$articledb=array();
while ($article = $DBS->fetch_array($query)) {
    // 格式化内容
    $article['addtime'] = showtime($article['addtime']);
    $article['edittime'] = showtime($article['edittime']);
    $articledb[] = $article;
}
unset($article);
$DBS->free_result($query);


// 页面变量
$title = $options['name'].' - 第 '.$page.' 页';

$site_infos = get_site_infos();
$bot_nodes = get_bot_nodes();
$newest_nodes = get_newest_nodes();
if (count($bot_nodes) > $options['newest_node_num']) $hot_nodes = get_hot_nodes();
if (!$is_mobie && count($bot_nodes) < $options['newest_node_num'] + $options['hot_node_num']) unset($bot_nodes);

$show_sider_ad = 1;
$links = get_links();

if ($options['keywords']) $meta_keywords = htmlspecialchars($options['keywords']);

if ($options['site_des']) $meta_des = htmlspecialchars(mb_substr($options['site_des'], 0, 150, 'utf-8'));

$pagefile = ROOT . '/templates/default/'.$tpl.'indexpage.php';

include_once(ROOT . '/templates/default/'.$tpl.'layout.php');

?>
