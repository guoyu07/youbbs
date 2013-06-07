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
    <div class="float-left">
        &raquo; 第',$page,'页 / 共',$taltol_page,'页
    </div>';
if($cur_user && $cur_user['flag']>4 && $newest_nodes){
  //echo '<div class="float-right grey">请先选择相关节点再发帖</div>';
    echo '<div class="float-right"><a href="/newpost-1" class="newpostbtn">+发新帖</a></div>';
}
echo '    <div class="c"></div>
</div>

<div class="main-box home-box-list">';

foreach($articledb as $article){
echo '
<div class="post-list">
    <div class="item-avatar"><a href="/member-',$article['uid'],'.html">
    <img src="',TUCHUANG_URL,'/avatar/mini/',$article['uavatar'],'.png" alt="',$article['author'],'" />
    </a></div>
    <div class="item-content count',$article['comments'],'">
        <h1><a href="/topic-',$article['id'],'-1.html">',$article['title'],'</a></h1>
        <span class="item-date"><a href="/node-',$article['cid'],'-1.html">',$article['cname'],'</a>';
if($article['comments']){
    echo ' • <a href="/member-',$article['ruid'],'.html">',$article['rauthor'],'</a> ',$article['edittime'],'回复';
}else{
    echo ' • <a href="/member-',$article['uid'],'.html">',$article['author'],'</a> ',$article['addtime'],'发表';
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


if($taltol_article > $options['list_shownum']){
echo '<div class="pagination">';
if($page>1){
echo '<a href="/page-',$page-1,'.html" class="page float-left">&laquo; 上一页</a>';
}
if($page<$taltol_page){
echo '<a href="/page-',$page+1,'.html" class="page float-right">下一页 &raquo;</a>';
}
echo '<div class="c"></div>
</div>';
}


echo '</div>';


?>