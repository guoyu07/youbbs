<?php
if (!defined('IN_SAESPOT')) {
    $dir_arr = explode(DIRECTORY_SEPARATOR, dirname(__FILE__));
    array_pop(array_pop($dir_arr));
    define('ROOT', implode(DIRECTORY_SEPARATOR, $dir_arr));
    include_once(ROOT . '/error/403.php');
    exit;
};

echo '
<form action="',$_SERVER["REQUEST_URI"],'" method="post">
<div class="title">
    <a href="/">',$options['name'],'</a> &raquo;&nbsp;
    <select name="select_cid">';
foreach($all_nodes as $n_id=>$n_name){
    if($t_obj['cid'] == $n_id){
        $sl_str = ' selected="selected"';
    }else{
        $sl_str = '';
    }
    echo '<option value="',$n_id,'"',$sl_str,'>',$n_name,'</option>';
}

echo '
</select>
&nbsp;- 修改帖子
</div>

<div class="main-box">';
if($tip){
    echo '<p class="red">',$tip,'</p>';
}

echo '

<p>
<input type="text" name="title" value="',$p_title,'" class="sll" />
</p>
<p><textarea id="id-content" name="content" class="mll tall">',$p_content,'</textarea></p>';

if(!$options['close_upload']){
    include_once(dirname(__FILE__) . '/upload.php');
}

echo '
<p><label><input type="checkbox" name="closecomment" value="1" ',$t_obj['closecomment'],'/> 关闭评论</label>&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="visible" value="1" ',$t_obj['visible'],'/> 显示帖子</label>&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="top" value="1" ',$t_obj['top'],'/> 置顶</label></p>
<div class="float-left"><input type="submit" value=" 保 存 " name="submit" class="textbtn" /></div>
</form>
<div class="float-right cancel-edit"><a href="/topic-',$tid,'-1.html">取消编辑并返回</a></div><div class="c"></div>
</div>';


?>
