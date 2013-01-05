<?php 
if (!defined('IN_SAESPOT')) exit('error: 403 Access Denied'); 

echo '
<div class="title">
    <div class="float-left fs14">
        <a href="/">',$options['name'],'</a> &raquo; 最近更新
    </div>';
if($cur_user && $cur_user['flag']>4 && $newest_nodes){
    echo '<div class="float-right grey">请先选择相关分类再发帖</div>';
    //echo '<div class="float-right"><a href="/newpost/1" rel="nofollow" class="newpostbtn">+发新帖</a></div>';
}
echo '    <div class="c"></div>
</div>

<div class="main-box home-box-list">';

foreach($articledb as $article){
echo '
<div class="post-list">
    <div class="item-avatar"><a href="/member/',$article['uid'],'">';
if(!$is_spider){
    echo '<img src="',TUCHUANG_URL,'/avatar/normal/',$article['uavatar'],'.png" alt="',$article['author'],'" />';
}else{
    echo '<img src="/static/grey.gif" data-original="',TUCHUANG_URL,'/avatar/normal/',$article['uavatar'],'.png" alt="',$article['author'],'" />';
}
echo '    </a></div>
    <div class="item-content">
        <h1><a href="/t-',$article['id'],'">',$article['title'],'</a></h1>
        <span class="item-date"><a href="/n-',$article['cid'],'">',$article['cname'],'</a>&nbsp;&nbsp;•&nbsp;&nbsp;<a href="/member/',$article['uid'],'">',$article['author'],'</a>';
if($article['comments']){
    echo '&nbsp;&nbsp;•&nbsp;&nbsp;',$article['edittime'],'&nbsp;&nbsp;•&nbsp;&nbsp;最后回复来自 <a href="/member/',$article['ruid'],'">',$article['rauthor'],'</a>';
}else{
    echo '&nbsp;&nbsp;•&nbsp;&nbsp;',$article['addtime'];
}
echo '        </span>
    </div>';
if($article['comments']){
    $gotopage = ceil($article['comments']/$options['commentlist_num']);
    if($gotopage == 1){
        $c_page = '';
    }else{
        $c_page = '-'.$gotopage;
    }
    echo '<div class="item-count"><a href="/t-',$article['id'],$c_page,'#reply',$article['comments'],'">',$article['comments'],'</a></div>';
}
echo '    <div class="c"></div>
</div>';

}

echo '</div>';

if(isset($bot_nodes)){
echo '
<div class="title">热门分类</div>
<div class="main-box main-box-node">
<span class="btn">';
foreach( $bot_nodes as $k=>$v ){
    echo '<a href="/',$k,'">',$v,'</a>';
}
echo '
</span>
<div class="c"></div>

</div>';
}

?>