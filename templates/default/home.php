<?php
if (!defined('IN_SAESPOT')) {
    $dir_arr = explode(DIRECTORY_SEPARATOR, dirname(__FILE__));
    array_pop(array_pop($dir_arr));
    define('ROOT', implode(DIRECTORY_SEPARATOR, $dir_arr));
    include_once(ROOT . '/error/403.php');
    exit;
};

echo '
<div class="title">
    <div class="float-left fs14">
        <a href="/">',$options['name'],'</a> &raquo; 最近更新
    </div>';
if($cur_user && $cur_user['flag']>4 && $newest_nodes){
  //echo '<div class="float-right grey">请先选择相关节点再发帖</div>';
    echo '
    <div class="float-right">
        <a href="/newpost-' . $options['newpost_node'] . '" class="newpostbtn">+发新帖</a>
    </div>';
}
echo '
    <div class="c"></div>
</div>

<div class="main-box home-box-list">';

foreach($articledb as $article){
echo '
<div class="post-list">
    <div class="item-avatar">
        <a href="/member-',$article['uid'],'.html"><img src="',TUCHUANG_URL,'/avatar/normal/',$article['uavatar'],'.png" alt="',$article['author'],'" /></a>
    </div>
    <div class="item-content">
        <h1><a href="/topic-',$article['id'],'-1.html">',$article['title'],'</a></h1>
        <span class="item-date"><a href="/node-',$article['cid'],'-1.html">',$article['cname'],'</a>&nbsp;&nbsp;•&nbsp;&nbsp;<a href="/member-',$article['uid'],'.html">',$article['author'],'</a>';
if($article['comments']){
    echo '&nbsp;&nbsp;•&nbsp;&nbsp;',$article['edittime'],'&nbsp;&nbsp;•&nbsp;&nbsp;最后回复来自 <a href="/member-',$article['ruid'],'.html">',$article['rauthor'],'</a>';
}else{
    echo '&nbsp;&nbsp;•&nbsp;&nbsp;',$article['addtime'];
}
echo '        </span>
    </div>';
if($article['comments']){
    $gotopage = ceil($article['comments']/$options['commentlist_num']);
    echo '<div class="item-count"><a href="/topic-',$article['id'],'-',$gotopage,'.html#reply',$article['comments'],'">',$article['comments'],'</a></div>';
}
echo '    <div class="c"></div>
</div>';
}

echo '<div class="pagination">
    <a href="/feed" class="feed float-left">订阅</a>
    ';

if ($all_visible_article > $options['home_shownum']) echo '<a href="/page-2.html" class="page float-right">下一页 &raquo;</a>';

echo '
    <div class="c"></div>
</div>
</div>';

if ($bot_nodes) {
echo '
<div class="title">节点导航</div>
<div class="main-box main-box-node">
<span class="btn">';
foreach ($bot_nodes as $k=>$v) {
    echo '<a href="/',$k,'-1.html">',$v,'</a>';
}
echo '
</span>
<div class="c"></div>

</div>';
}

?>