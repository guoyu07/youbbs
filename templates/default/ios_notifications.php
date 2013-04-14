<?php
if (!defined('IN_SAESPOT')) exit(header('location: /403.html'));

echo '
<div class="title">
    站内提醒 &raquo; 有人在帖子中提及了你或在你发表的帖子中回复
</div>

<div class="main-box home-box-list">';

if($articledb){

foreach($articledb as $article){
echo '
<div class="post-list">
    <div class="item-avatar"><a href="/member-',$article['uid'],'.html"><img src="',TUCHUANG_URL,'/avatar/mini/',$article['uavatar'],'.png" alt="',$article['author'],'" /></a></div>
    <div class="item-content count',$article['comments'],'">
        <h1><a href="/goto-topic-',$article['id'],'">',$article['title'],'</a></h1>
        <span class="item-date"><a href="/node-',$article['cid'],'.html">',$article['cname'],'</a>';
if($article['comments']){
    echo ' • <a href="/member-',$article['ruid'],'.html">',$article['rauthor'],'</a> ',$article['edittime'],'回复';
}else{
    echo ' • <a href="/member-',$article['uid'],'.html">',$article['author'],'</a> ',$article['addtime'],'发表';
}
echo '        </span>
    </div>';
if($article['comments']){
    echo '<div class="item-count"><a href="/goto-topic-',$article['id'],'">',$article['comments'],'</a></div>';
}
echo '    <div class="c"></div>
</div>';

}

}else{
    echo '<p>&nbsp;&nbsp;&nbsp;暂无未读提醒</p>';
}

echo '</div>';

?>