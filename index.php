<?php
define('IN_SAESPOT', 1);
define('ROOT', dirname(__FILE__));

$configFile = ROOT . '/config.php';
if(!file_exists($configFile)) {
    header("Content-Type: text/html; charset=UTF-8");
    echo "配置文件不存在，请按照说明编辑 config.sample.php 并保存为 config.php，然后访问 /install 安装。";
    exit;
}

include_once(ROOT . '/config.php');
include_once(ROOT . '/common.php');

// 获取总帖数
$hide_nodes_str = $options['hide_nodes'] ? "AND cid <> ".str_replace(",", " AND cid <> ", $options['hide_nodes']) : "";
$table_status = $DBS->fetch_one_array("SELECT COUNT(*) FROM yunbbs_articles WHERE visible = 1 $hide_nodes_str");
$all_visible_article = $table_status['COUNT(*)'];

// 获取帖子列表
$articledb = $MMC->get('home-article-list');
if(!$articledb){
    $query_sql = "SELECT a.id,a.cid,a.uid,a.ruid,a.title,a.addtime,a.edittime,a.comments,c.name as cname,u.avatar as uavatar,u.name as author,ru.name as rauthor
        FROM yunbbs_articles a
        LEFT JOIN yunbbs_categories c ON c.id=a.cid
        LEFT JOIN yunbbs_users u ON a.uid=u.id
        LEFT JOIN yunbbs_users ru ON a.ruid=ru.id
        WHERE visible = 1 $hide_nodes_str
        ORDER BY top DESC, edittime DESC
        LIMIT ".$options['home_shownum'];
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
    $MMC->set('home-article-list', $articledb, 0, 600);
}

// 页面变量
$title = $options['name'];
if ($options['description']) $title .= ' - '.$options['description'];

$site_infos = get_site_infos();
$bot_nodes = get_bot_nodes();
$newest_nodes = get_newest_nodes();
if (count($bot_nodes) > $options['newest_node_num']) $hot_nodes = get_hot_nodes();
if (!$is_mobie && count($bot_nodes) < $options['newest_node_num'] + $options['hot_node_num']) unset($bot_nodes);

$show_sider_ad = "1";
$links = get_links();

if($options['keywords']){
    $meta_keywords = htmlspecialchars($options['keywords']);
}
if($options['site_des']){
    $meta_des = htmlspecialchars(mb_substr($options['site_des'], 0, 150, 'utf-8'));
}

$pagefile = ROOT . '/templates/default/'.$tpl.'home.php';

include_once(ROOT . '/templates/default/'.$tpl.'layout.php');

?>
