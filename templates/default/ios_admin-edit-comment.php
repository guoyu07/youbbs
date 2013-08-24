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
    <a href="/">',$options['name'],'</a> &raquo; - 修改评论';
echo '
</div>

<div class="main-box">';
if($tip){
    echo '<p class="red">',$tip,'</p>';
}

echo '
<form action="',$_SERVER["REQUEST_URI"],'" method="post">
<p><textarea id="id-content" name="content" class="comment-text mll wb96">',$r_content,'</textarea></p>
<p><input type="submit" value=" 保 存 " name="submit" class="textbtn wb96" /></p>
</form>
<a href="/topic-',$r_obj['articleid'],'-1.html">查看这条评论所在的帖子</a>
</div>';


?>
