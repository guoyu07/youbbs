<?php
define('IN_SAESPOT', 1);

include(dirname(__FILE__) . '/config.php');
include(dirname(__FILE__) . '/common.php');

$cid = intval($_GET['cid']);
$page = intval($_GET['page']);

$c_obj = $MMC->get('n-'.$cid);
if(!$c_obj){
    $c_obj = $DBS->fetch_one_array("SELECT * FROM yunbbs_categories WHERE id='".$cid."'");
    if(!$c_obj){
        header("HTTP/1.0 404 Not Found");
        header("Status: 404 Not Found");
        include(dirname(__FILE__) . '/404.html');
        exit;
    }
    $MMC->set('n-'.$cid, $c_obj, 0, 3600);
}

// 处理正确的页数
$taltol_page = ceil($c_obj['articles']/$options['list_shownum']);
if($page<=0){
    header('location: /node-'.$cid.'-1.html');
    exit;
}
if($page!=1 && $page>$taltol_page){
    header('location: /node-'.$cid.'-'.$taltol_page.'.html');
    exit;
}

// 获取最近文章列表
if($page == 0) $page = 1;
$mc_key = 'cat-page-article-list-'.$cid.'-'.$page;
$articledb = $MMC->get($mc_key);
if(!$articledb){
    $query_sql = "SELECT a.id,a.uid,a.ruid,a.title,a.addtime,a.edittime,a.comments,u.avatar as uavatar,u.name as author,ru.name as rauthor
        FROM yunbbs_articles a
        LEFT JOIN yunbbs_users u ON a.uid=u.id
        LEFT JOIN yunbbs_users ru ON a.ruid=ru.id
        WHERE a.cid='".$cid."' ORDER BY edittime DESC LIMIT ".($page-1)*$options['list_shownum'].",".$options['list_shownum'];
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
    $MMC->set($mc_key, $articledb, 0, 600);
}

// 页面变量
if ($page>=2) {
    $title = $options['name'].' › '.$c_obj['name'].' - 第 '.$page.' 页';
} else {
    $title = $options['name'].' › '.$c_obj['name'];
}
$newest_nodes = get_newest_nodes();
$show_sider_ad = "1";
$links = get_links();
//$meta_keywords = htmlspecialchars();
if ($c_obj['about']) {
    $meta_des = htmlspecialchars(mb_substr($c_obj['about'], 0, 150, 'utf-8'));
}

$pagefile = dirname(__FILE__) . '/templates/default/'.$tpl.'node.php';

include(dirname(__FILE__) . '/templates/default/'.$tpl.'layout.php');

?>
