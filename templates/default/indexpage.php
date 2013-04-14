<?php
if (!defined('IN_SAESPOT')) exit(header('location: /403.html'));

echo '
<div class="title">
    <div class="float-left fs14">
        <a href="/">',$options['name'],'</a> &raquo; 第',$page,'页 / 共',$taltol_page,'页
    </div>';
if($cur_user && $cur_user['flag']>4 && $newest_nodes){
    echo '<div class="float-right grey">请先选择相关分类再发帖</div>';
    //echo '<div class="float-right"><a href="/newpost-1" class="newpostbtn">+发新帖</a></div>';
}
echo '    <div class="c"></div>
</div>

<div class="main-box home-box-list">';

foreach($articledb as $article){
echo '
<div class="post-list">
    <div class="item-avatar">
        <a href="/member-',$article['uid'],'.html"><img src="',TUCHUANG_URL,'/avatar/normal/',$article['uavatar'],'.png" alt="',$article['author'],'" /></a>
    </div>
    <div class="item-content">
        <h1><a href="/topic-',$article['id'],'.html">',$article['title'],'</a></h1>
        <span class="item-date"><a href="/node-',$article['cid'],'.html">',$article['cname'],'</a>  •  <a href="/member-',$article['uid'],'.html">',$article['author'],'</a>';
if($article['comments']){
    echo ' •  ',$article['edittime'],' •  最后回复来自 <a href="/member-',$article['ruid'],'.html">',$article['rauthor'],'</a>';
}else{
    echo ' •  ',$article['addtime'];
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
    if ($page==2) {
        echo '<a href="/" class="float-left">&laquo; 上一页</a>';
    } else {
        echo '<a href="/page-',$page-1,'.html" class="float-left">&laquo; 上一页</a>';
    }
}
if($page<$taltol_page){
echo '<a href="/page-',$page+1,'.html" class="float-right">下一页 &raquo;</a>';
}
echo '<div class="c"></div>
</div>';
}


echo '</div>';


?>