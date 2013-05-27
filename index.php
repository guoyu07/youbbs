<?php
define('IN_SAESPOT', 1);

include_once(dirname(__FILE__) . '/config.php');
include_once(dirname(__FILE__) . '/common.php');

// 获取最近文章列表
$articledb = $MMC->get('home-article-list');
if(!$articledb){
    $hide_nodes_arr = explode(",", $options['hide_nodes']);
    $hide_nodes_str = "AND cid <> ".implode(" AND cid <> ", $hide_nodes_arr);
    $query_sql = "SELECT a.id,a.cid,a.uid,a.ruid,a.title,a.addtime,a.edittime,a.comments,c.name as cname,u.avatar as uavatar,u.name as author,ru.name as rauthor
        FROM yunbbs_articles a
        LEFT JOIN yunbbs_categories c ON c.id=a.cid
        LEFT JOIN yunbbs_users u ON a.uid=u.id
        LEFT JOIN yunbbs_users ru ON a.ruid=ru.id
        WHERE visible = 1 ".$hide_nodes_str."
        ORDER BY edittime DESC LIMIT ".$options['home_shownum'];
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
if ($options['description']) {
    $title = $options['name'].' - '.$options['description'];
} else {
    $title = $options['name'];
}

$site_infos = get_site_infos();
$newest_nodes = get_newest_nodes();
if(count($newest_nodes)==$options['newest_node_num']){
    $bot_nodes = get_bot_nodes();
}

$show_sider_ad = "1";
$links = get_links();

if($options['keywords']){
    $meta_keywords = htmlspecialchars($options['keywords']);
}
if($options['site_des']){
    $meta_des = htmlspecialchars(mb_substr($options['site_des'], 0, 150, 'utf-8'));
}

$pagefile = dirname(__FILE__) . '/templates/default/'.$tpl.'home.php';

include_once(dirname(__FILE__) . '/templates/default/'.$tpl.'layout.php');

?>
