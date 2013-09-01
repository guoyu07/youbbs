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
    <a href="/">',$options['name'],'</a> &raquo; 修改评论
</div>

<div class="main-box">';
if($tip){
    echo '<p class="red">',$tip,'</p>';
}

echo '
<form action="',$_SERVER["REQUEST_URI"],'" method="post">
<p><textarea id="id-content" name="content" class="comment-text mll">',$r_content,'</textarea></p>';

if(!$options['close_upload']){
    include_once(dirname(__FILE__) . '/upload.php');
}

echo '
<div class="float-left"><input type="submit" value=" 保 存 " name="submit" class="textbtn" /></div>
</form>
<div class="float-right cancel-edit"><a href="/topic-',$r_obj['articleid'],'-1.html">取消编辑并返回</a></div><div class="c"></div>
</div>';

?>