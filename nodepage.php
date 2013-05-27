<?php
define('IN_SAESPOT', 1);

include_once(dirname(__FILE__) . '/config.php');
include_once(dirname(__FILE__) . '/common.php');

$cid = intval($_GET['cid']);
$page = intval($_GET['page']);

$c_obj = $MMC->get('n-'.$cid);
if(!$c_obj){
    $c_obj = $DBS->fetch_one_array("SELECT * FROM yunbbs_categories WHERE id=$cid");
    if(!$c_obj){
        $error_code = 4042;
        $title = $options['name'].' › 节点未找到';
        $pagefile = dirname(__FILE__) . '/templates/default/404.php';
        include_once(dirname(__FILE__) . '/templates/default/'.$tpl.'layout.php');
        exit;
    }
    $MMC->set('n-'.$cid, $c_obj, 0, 3600);
}

// 处理正确的页数
// 因为有隐藏帖的存在，这里有 bug
$taltol_page = ceil($c_obj['articles']/$options['list_shownum']);
if ($taltol_page == 0) $taltol_page = 1;
if ($page<=0) {
    header("HTTP/1.1 301 Moved Permanently");
    header("Status: 301 Moved Permanently");
    header('Location: /node-'.$cid.'-1.html');
    exit;
}
if ($page>$taltol_page) {
    header('Location: /node-'.$cid.'-'.$taltol_page.'.html');
    exit;
}

// 获取最近文章列表
if ($page == 0) $page = 1;
$mc_key = 'cat-page-article-list-'.$cid.'-'.$page;
$articledb = $MMC->get($mc_key);
if(!$articledb){
    $visible_str = $cur_user && $cur_user['flag'] >= 88 ? "" : " AND visible = 1";
    $query_sql = "SELECT a.id,a.uid,a.ruid,a.title,a.addtime,a.edittime,a.comments,u.avatar as uavatar,u.name as author,ru.name as rauthor
            FROM yunbbs_articles a
            LEFT JOIN yunbbs_users u ON a.uid=u.id
            LEFT JOIN yunbbs_users ru ON a.ruid=ru.id
            WHERE a.cid=$cid$visible_str
            ORDER BY top DESC, edittime DESC
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

include_once(dirname(__FILE__) . '/templates/default/'.$tpl.'layout.php');

?>
