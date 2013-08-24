<?php
if (!defined('IN_SAESPOT')) {
    $dir_arr = explode(DIRECTORY_SEPARATOR, dirname(__FILE__));
    array_pop(array_pop($dir_arr));
    define('ROOT', implode(DIRECTORY_SEPARATOR, $dir_arr));
    include_once(ROOT . '/error/403.php');
    exit;
};

echo '
<a name="add"></a>
<div class="title">
    <a href="/">',$options['name'],'</a> &raquo; 添加节点
</div>

<div class="main-box">';
if($tip1){
    echo '<p class="red">',$tip1,'</p>';
}

echo '
<form action="',$_SERVER["REQUEST_URI"],'#add" method="post">
<input type="hidden" name="action" value="add"/>
<p>输入新节点名： <input type="text" class="sl w200" name="name" value="" /><br/>
节点简介： (255个字节以内)<br/>
<textarea class="ml w500" name="about"></textarea><br/>
<input type="submit" value=" 添 加 " name="submit" class="textbtn" /></p>
<p class="grey fs12">注：节点添加后不能删除，只能修改。</p>
</form>
</div>';

echo '
<a name="edit"></a>
<div class="title">修改节点</div>

<div class="main-box">';
if($tip2){
    echo '<p class="red">',$tip2,'</p>';
}

echo '
<form action="',$_SERVER["REQUEST_URI"],'#edit" method="post">';
if($c_obj){
echo '
<input type="hidden" name="action" value="edit"/>
<p>节点名： <input type="text" class="sl w200" name="name" value="',htmlspecialchars($c_obj['name']),'" /><br/>
节点简介： (255个字节以内)<br/>
<textarea class="ml w500" name="about">',htmlspecialchars(stripslashes($c_obj['about'])),'</textarea><br/>
<input type="submit" value=" 保 存 " name="submit" class="textbtn" /></p>';

}else{
echo '
<input type="hidden" name="action" value="find"/>
<p>输入节点id查找： <input type="text" class="sl w100" name="findid" value="" /> 如红色部分：node-<span class="red">1</span>-1.html
<input type="submit" value=" 查 找 " name="submit" class="textbtn" /></p>';

}

echo '</form>
</div>';

?>
