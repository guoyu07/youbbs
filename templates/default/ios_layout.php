<?php
if (!defined('IN_SAESPOT')) {
    $dir_arr = explode(DIRECTORY_SEPARATOR, dirname(__FILE__));
    array_pop(array_pop($dir_arr));
    define('ROOT', implode(DIRECTORY_SEPARATOR, $dir_arr));
    include_once(ROOT . '/403.php');
    exit;
};

ob_start();

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh-CN" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<title>',$title,'</title>
<meta content="True" name="HandheldFriendly" />
<meta name="viewport" content="maximum-scale=1.0,width=device-width,initial-scale=1.0" />
<meta name="apple-mobile-web-app-capable" content="yes" />
';
if($meta_keywords){
    echo '<meta name="keywords" content="',$meta_keywords,'" />
';
}
if($meta_des){
    echo '<meta name="description" content="',$meta_des,'" />
';
}
echo '<link href="/static/default/style_ios.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<link rel="alternate" href="/feed" title="',htmlspecialchars($options['name']),' - 订阅" type="application/atom+xml"/>
';
if($options['head_meta']){
    echo $options['head_meta'];
}

echo '
</head>
<body>
<div class="header-wrap">
    <div class="header">
        <div class="logo"><a href="/" name="top">',htmlspecialchars($options['name']),'</a></div>
        <div class="banner">';

if($cur_user){
    echo '<a href="/member-',$cur_user['id'],'.html"><img src="',TUCHUANG_URL,'/avatar/mini/',$cur_user['avatar'],'.png" alt="',$cur_user['name'],'"/></a>&nbsp;&nbsp;<a href="/favorites">收藏</a>&nbsp;<a href="/setting">设置</a>&nbsp;<a href="/logout">退出</a>';
}else{
    if(!$options['close_register']){
        echo '<a href="/sigin">注册</a>&nbsp;';
    }
    echo '<a href="/login" rel="nofollow">登录</a>';
}
echo '       </div>
        <div class="c"></div>
    </div>
    <!-- header end -->
</div>

<div class="main-wrap">
    <div class="main">
        <div class="main-content">';

if($cur_user){
    if($cur_user['flag'] == 0){
        echo '<div class="tiptitle">站内提醒 &raquo; <span style="color:yellow;">帐户已被管理员禁用</span></div>';
    }elseif($cur_user['flag'] == 1){
        echo '<div class="tiptitle">站内提醒 &raquo; <span style="color:yellow;">帐户在等待管理员审核</span></div>';
    }else{
        if(!$cur_user['password']){
            echo '<div class="tiptitle">站内提醒 &raquo; <a href="/setting#3" style="color:yellow;">设置登录密码</a></div>';
        }
        if($cur_user['notic']){
            $notic_n = count(array_unique(explode(',', $cur_user['notic'])))-1;
            echo '<div class="tiptitle">站内提醒 &raquo; <a href="/notifications" style="color:yellow;">',$notic_n,'条提醒</a></div>';
        }
    }
}

if($options['close']){
echo '
<div class="tiptitle">论坛暂时关闭公告 &raquo;
<span style="color:yellow;">';
if($options['close_note']){
    echo $options['close_note'];
}else{
    echo '论坛维护中……';
}
echo '</span>
</div>';
}

if($cur_user && $cur_user['flag']>=99){
echo '
<div class="title">管理员面板</div>
<div class="main-box main-box-node">
<div class="btn">
<a href="/admin-node">节点管理</a><a href="/admin-setting">网站设置</a><a href="/admin-user-list">用户管理</a><a href="/admin-link-list">链接管理</a>';

echo '
<div class="c"></div>
</div>

</div>';
}

include_once($pagefile);

if($bot_nodes){
echo '
<div class="title">节点导航</div>
<div class="main-box main-box-node">
<div class="btn">';
foreach( $bot_nodes as $k=>$v ){
    echo '<a href="/',$k,'-1.html">',$v,'</a>';
}
echo '
<div class="c"></div>
</div>

</div>';
}

echo '       </div>
        <!-- main-content end -->
        <div class="c"></div>
    </div>
    <!-- main end -->
    <div class="c"></div>
</div>

<!-- footer begin -->
<div class="footer-wrap">
    <div class="footer">
    <div class="footer-content float-left">';

if($is_mobie){
    echo '<a href="/viewat-desktop">桌面版</a>';
}

$year = date("Y");
echo '</div>
    <div class="footer-content float-right">&copy; ',$yaer,' - <a href="/">',$options['name'],'</a></div>
    <div class="c"></div>
    </div>
</div>
<!-- footer end -->
';

if($show_sider_ad && $options['ad_sider_top']){
    echo $options['ad_web_bot'];
}

if($options['analytics_code']){
    echo $options['analytics_code'];
}

echo '
</body>
</html>';

$_output = ob_get_contents();
ob_end_clean();

if ($error_code) {
    header("HTTP/1.0 404 Not Found");
    header("Status: 404 Not Found");
} elseif (!$options['show_debug']) {
    $etag = md5($_output);
    if ($_SERVER['HTTP_IF_NONE_MATCH'] == $etag) {
        header("HTTP/1.1 304 Not Modified");
        header("Status: 304 Not Modified");
        header("Etag: ".$etag);
        exit;
    } else {
        header("Etag: ".$etag);
    }
}

header("Content-Type: text/html; charset=UTF-8");
echo $_output;

?>