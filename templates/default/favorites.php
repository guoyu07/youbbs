<?php
if (!defined('IN_SAESPOT')) exit(header('location: /403.html'));

echo '
<div class="title">
    <a href="/">',$options['name'],'</a> &raquo; 收藏的帖子 (',$user_fav['articles'],')
</div>

<div class="main-box home-box-list">';

if($articledb){

foreach($articledb as $article){
echo '
<div class="post-list">
    <div class="item-avatar">
        <a href="/member-',$article['uid'],'.html"><img src="',TUCHUANG_URL,'/avatar/normal/',$article['uavatar'],'.png" alt="',$article['author'],'" /></a>
    </div>
    <div class="item-content">
        <h1><a href="/topic-',$article['id'],'-1.html">',$article['title'],'</a></h1>
        <span class="item-date"><a href="/node-',$article['cid'],'-1.html">',$article['cname'],'</a>  •  <a href="/member-',$article['uid'],'.html">',$article['author'],'</a>';
if($article['comments']){
    echo ' •  ',$article['edittime'],' •  最后回复来自 <a href="/member-',$article['ruid'],'.html">',$article['rauthor'],'</a>';
}else{
    echo ' •  ',$article['addtime'];
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
    echo '<p>&nbsp;&nbsp;&nbsp;没有收藏的帖子</p>';
}

echo '</div>';

?>