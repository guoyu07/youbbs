<?php
if (!defined('IN_SAESPOT')) exit(header('location: /403.html'));

echo '
<div class="title">
    <div class="float-left fs14">
        &raquo; ',$c_obj['name'],'(',$c_obj['articles'],')';
        if($cur_user && $cur_user['flag']>=99){
            echo ' &nbsp;&nbsp;&nbsp; • <a href="/admin-node-',$c_obj['id'],'#edit">编辑</a>';
        }
echo '    </div>';
if($cur_user && $cur_user['flag']>4){
    echo '<div class="float-right"><a href="/newpost-',$cid,'" rel="nofollow" class="newpostbtn">+发新帖</a></div>';
}
echo '    <div class="c"></div>
</div>

<div class="main-box home-box-list">';

if($c_obj['about']){
    echo '<div class="post-list grey"><p>',$c_obj['about'],'</p></div>';
}

foreach($articledb as $article){
echo '
<div class="post-list">
    <div class="item-avatar"><a href="/member-',$article['uid'],'.html">
    <img src="',TUCHUANG_URL,'/avatar/mini/',$article['uavatar'],'.png" alt="',$article['author'],'" /></a></div>
    <div class="item-content count',$article['comments'],'">
        <h1><a href="/topic-',$article['id'],'.html">',$article['title'],'</a></h1>
        <span class="item-date">';
if($article['comments']){
    echo $article['edittime'],' <a href="/member-',$article['ruid'],'.html">',$article['rauthor'],'</a> 回复';
}else{
    echo $article['addtime'],' <a href="/member-',$article['uid'],'.html">',$article['author'],'</a> 发表';
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

if($c_obj['articles'] > $options['list_shownum']){
echo '<div class="pagination">';
if($page>1){
echo '<a href="/node-',$cid,'-',$page-1,'.html" class="float-left">&laquo; 上一页</a>';
}
if($page<$taltol_page){
echo '<a href="/node-',$cid,'-',$page+1,'.html" class="float-right">下一页 &raquo;</a>';
}
echo '<div class="c"></div>
</div>';
}


echo '</div>';


?>