<?php
if (!defined('IN_SAESPOT')) {
    $dir_arr = explode(DIRECTORY_SEPARATOR, dirname(__FILE__));
    array_pop(array_pop($dir_arr));
    define('ROOT', implode(DIRECTORY_SEPARATOR, $dir_arr));
    include_once(ROOT . '/403.php');
    exit;
};

echo '
<div class="title">
    个人收藏的帖子 （',$user_fav['articles'],'）
</div>

<div class="main-box home-box-list">';

if($articledb){

foreach($articledb as $article){
echo '
<div class="post-list">
    <div class="item-avatar"><a href="/member-',$article['uid'],'.html"><img src="',TUCHUANG_URL,'/avatar/mini/',$article['uavatar'],'.png" alt="',$article['author'],'" /></a></div>
    <div class="item-content count',$article['comments'],'">
        <h1><a href="/topic-',$article['id'],'-1.html">',$article['title'],'</a></h1>
        <span class="item-date"><a href="/node-',$article['cid'],'-1.html">',$article['cname'],'</a>';
if($article['comments']){
    echo ' • <a href="/member-',$article['ruid'],'.html">',$article['rauthor'],'</a> ',$article['edittime'],'回复';
}else{
    echo ' • <a href="/member-',$article['uid'],'.html">',$article['author'],'</a> ',$article['addtime'],'发表';
}
echo ' •  <<a href="/favorites?act=del&id=',$article['id'],'">取消收藏</a>></span>
    </div>';
if($article['comments']){
    echo '<div class="item-count"><a href="/topic-',$article['id'],'-1.html">',$article['comments'],'</a></div>';
}
echo '    <div class="c"></div>
</div>';

}


if($user_fav['articles'] > $options['list_shownum']){
echo '<div class="pagination">';
if($page>1){
echo '<a href="/favorites?page=',$page-1,'" class="float-left">&laquo; 上一页</a>';
}
if($page<$taltol_page){
echo '<a href="/favorites?page=',$page+1,'" class="float-right">下一页 &raquo;</a>';
}
echo '<div class="c"></div>
</div>';
}


}else{
    echo '<p>&nbsp;&nbsp;&nbsp;暂无收藏帖子</p>';
}

echo '</div>';

?>