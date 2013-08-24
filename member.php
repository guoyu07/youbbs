<?php
define('IN_SAESPOT', 1);
define('ROOT', dirname(__FILE__));

include_once(ROOT . '/config.php');
include_once(ROOT . '/common.php');

$g_mid = $_GET['mid'];
// mid 可能是 ID 或用户名，用户注册时要限制名字不能为全数字
if(preg_match('/^[\w\d\x{4e00}-\x{9fa5}]{1,20}$/iu', $g_mid)){
    $mid = intval($g_mid);
    if($mid){
        $query = "SELECT id,name,flag,avatar,url,articles,replies,regtime,about FROM yunbbs_users WHERE id=$mid";
    }else{
        $query = "SELECT id,name,flag,avatar,url,articles,replies,regtime,about FROM yunbbs_users WHERE name='$g_mid'";
    }
}else{
    $error_code = 4041;
    $title = $options['name'].' › 用户未找到';
    $pagefile = ROOT . '/templates/default/404.php';
    include_once(ROOT . '/templates/default/'.$tpl.'layout.php');
    exit;
}

$m_obj = $DBS->fetch_one_array($query);
if($m_obj && !($m_obj['flag'] == 0 && (!$cur_user || $cur_user && $cur_user['flag']<99))){
    if(!$mid){
        header("HTTP/1.1 301 Moved Permanently");
        header("Status: 301 Moved Permanently");
        header('Location: /member-'.$m_obj['id'].'.html');
        exit;
    }
    $openid_user = $DBS->fetch_one_array("SELECT name FROM yunbbs_qqweibo WHERE uid=$mid");
    $weibo_user = $DBS->fetch_one_array("SELECT openid FROM yunbbs_weibo WHERE uid=$mid");
}else{
    $error_code = 4041;
    $title = $options['name'].' › 用户未找到';
    $pagefile = ROOT . '/templates/default/404.php';
    include_once(ROOT . '/templates/default/'.$tpl.'layout.php');
    exit;
}

$m_obj['regtime'] = showtime($m_obj['regtime']);

// 获取用户最近文章列表
if($m_obj['articles']){
    $mc_key = 'member-article-list-'.$mid;
    $articledb = $MMC->get($mc_key);
    if(!$articledb){
        $query_sql = "SELECT a.id,a.cid,a.ruid,a.title,a.addtime,a.edittime,a.comments,c.name as cname,ru.name as rauthor
            FROM yunbbs_articles a
            LEFT JOIN yunbbs_categories c ON c.id=a.cid
            LEFT JOIN yunbbs_users ru ON a.ruid=ru.id
            WHERE a.uid=$mid
            ORDER BY id DESC
            LIMIT 10";
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
}

// 用户最近回复文章列表不能获取，若想实现则在 users 表里添加一列来保存最近回复文章的 id

// 页面变量
$title =  $options['name'].' › '.$m_obj['name'];
$show_sider_ad = "1";
//$meta_keywords = htmlspecialchars();
if ($m_obj['about']) {
    $meta_des = htmlspecialchars(mb_substr($m_obj['about'], 0, 150, 'utf-8'));
}

$pagefile = ROOT . '/templates/default/'.$tpl.'member.php';

include_once(ROOT . '/templates/default/'.$tpl.'layout.php');

?>
