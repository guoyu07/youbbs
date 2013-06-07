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
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
';
if($meta_keywords){
    echo '<meta name="keywords" content="',$meta_keywords,'" />
';
}
if($meta_des){
    echo '<meta name="description" content="',$meta_des,'" />
';
}
echo '<link href="/static/default/style.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<link rel="alternate" href="/feed" title="',htmlspecialchars($options['name']),' - 订阅" type="application/atom+xml"/>
<script src="',$options['jquery_lib'],'" type="text/javascript"></script>
';
if($options['head_meta']){
    echo $options['head_meta'];
}

echo '
</head>
<body>
<div class="header-wrap">
    <div class="header">
        <div class="logo"><a href="/" name="top" title="',htmlspecialchars($options['name']);
if ($options['description']) {
    echo ' - ',$options['description'];
}
echo '">',htmlspecialchars($options['name']),'</a></div>
        <div class="scbox">
            <script type="text/javascript">
                var dispatch = function() {
                    q = document.getElementById("q");
                    if (q.value != "" && q.value != "搜索") {
                        window.open(\'https://www.google.com/search?q=site:',$_SERVER['HTTP_HOST'],'%20\' + q.value, "_blank");
                        return false;
                    } else {
                        return false;
                    }
                }
            </script>

            <form role="search" method="get" id="searchform" onsubmit="return dispatch()" target="_blank">
                <input type="text" maxlength="30" onfocus="if(this.value==\'搜索\') this.value=\'\';" onblur="if(this.value==\'\') this.value=\'搜索\';" value="搜索" name="q" id="q">
            </form>

        </div>
        <div class="banner">';

if($cur_user){
    echo '<img src="',TUCHUANG_URL,'/avatar/mini/',$cur_user['avatar'],'.png" alt="',$cur_user['name'],'"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

    if(!$cur_user['password']){
        //echo '<a href="/setting#3" style="color:yellow;">设置登录密码</a>&nbsp;&nbsp;&nbsp;';
    }

    if($cur_user['notic']){
        $notic_n = count(array_unique(explode(',', $cur_user['notic'])))-1;
        echo '<a href="/notifications" style="color:yellow;">',$notic_n,'条提醒</a>&nbsp;&nbsp;&nbsp;';
    }
    if($cur_user['flag'] == 0){
        echo '<span style="color:yellow;">已被禁用</span>&nbsp;&nbsp;&nbsp;';
    }elseif($cur_user['flag'] == 1){
        echo '<span style="color:yellow;">在等待审核</span>&nbsp;&nbsp;&nbsp;';
    }
    echo '<a href="/" title="论坛首页">首页</a>&nbsp;&nbsp;&nbsp;<a href="/member-',$cur_user['id'],'.html" title="个人主页">',$cur_user['name'],'</a>&nbsp;&nbsp;&nbsp;<a href="/favorites" title="收藏的帖子">收藏</a>&nbsp;&nbsp;&nbsp;<a href="/setting" title="账户设置">设置</a>&nbsp;&nbsp;&nbsp;<a href="/logout" title="登出">退出</a>';
}else{
    echo '<a href="/" title="论坛首页">首页</a>&nbsp;&nbsp;&nbsp;';
//  if(!($options['wb_key'] && $options['wb_secret']) && !($options['qq_appid'] && $options['qq_appkey'])){
    if(!$options['close_register']){
        echo '<a href="/sigin" title="注册">注册</a>&nbsp;&nbsp;&nbsp;';
    }
//  }
    echo '<a href="/login" rel="nofollow" title="登录">登录</a>';
    if($options['wb_key'] && $options['wb_secret']){
        echo '&nbsp;&nbsp;&nbsp;<a href="/wblogin" rel="nofollow"><img src="/static/weibo_login_55_24.png" alt="微博登录" title="用新浪微博登录"/></a>';
    }
    if($options['qq_appid'] && $options['qq_appkey']){
        echo '&nbsp;&nbsp;&nbsp;<a href="/qqlogin" rel="nofollow"><img src="/static/qq_login_55_24.png" alt="QQ登录" title="用QQ登录"/></a>';
    }
}
echo '       </div>
        <div class="c"></div>
    </div>
    <!-- header end -->
</div>

<div class="main-wrap">
    <div class="main">
        <div class="main-content">';

include_once($pagefile);

echo '       </div>
        <!-- main-content end -->
        <div class="main-sider">';

include_once(dirname(__FILE__) . '/sider.php');
echo '       </div>
        <!-- main-sider end -->
        <div class="c"></div>
    </div>
    <!-- main end -->
    <div class="c"></div>
</div>';

echo '
<!-- footer-begin -->
<div class="footer-wrap">
    <div class="footer center-align">
    <div class="footer-content float-left">
        ';
if($is_mobie){
    echo '<a href="/viewat-mobile">手机版</a>';
}

echo '
    </div>
    <div class="footer-content float-right">
        ';

$year = date("Y");
echo '&copy; ',$year,' - <a href="/">',$options['name'],'</a> • ';

if ($options['icp']) echo '<a href="http://www.miibeian.gov.cn/" target="_blank" rel="nofollow">',$options['icp'],'</a> • ';

// 尊重作者，请不要删除
echo 'Powered by <a href="http://youbbs.sinaapp.com" target="_blank">YouBBS</a>';

if($options['show_debug']){
    $mtime = explode(' ', microtime());
    $totaltime = number_format(($mtime[1] + $mtime[0] - $starttime), 6);
    echo '
        <p>Processed in ',$totaltime,' second(s), ',$DBS->querycount,' queries.</p>';
}
echo '
    </div>
    </div>
</div>
<!-- footer end -->
<script type="text/javascript" src="/static/default/go-top.js"></script>
<script>
/* <![CDATA[ */
(new GoTop()).init({
    pageWidth        :980,
    nodeId           :\'go-top\',
    nodeWidth        :50,
    distanceToBottom :50,
    distanceToPage   :20,
    hideRegionHeight :130,
    text             :\'\'
});
/* ]]> */
</script>
';

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