<?php
if (!defined('IN_SAESPOT')) {
    $dir_arr = explode(DIRECTORY_SEPARATOR, dirname(__FILE__));
    array_pop(array_pop($dir_arr));
    define('ROOT', implode(DIRECTORY_SEPARATOR, $dir_arr));
    include_once(ROOT . '/error/403.php');
    exit;
};

echo '
<div class="title"><a href="/">',$options['name'],'</a> &raquo; ',$title,'</div>
<div class="main-box">
<p class="red" style="margin-left:60px;">';
foreach($errors as $error){
    echo '› ',$error,' <br/>';
}
echo '</p>
<p class="grey fs12">请填写登录名和个人设置里的邮箱：</p>
<form action="',$_SERVER["REQUEST_URI"],'" method="post">
<p><label>登录名： <input type="text" name="name" class="sl wb50" value="',htmlspecialchars($name),'" /></label>  <br/><span class="grey fs12">允许字母、数字、中文，不能全为数字，4~12个字节</span></p>
<p><label>邮　箱： <input type="text" name="email" class="sl wb50" value="" /></label></p>
<p><input type="submit" value="找回密码" name="submit" class="textbtn" style="margin-left:60px;" /> </p>';
if($url_path == 'login'){
    if($options['close_register'] || $options['close']){
        echo '<p class="grey fs12">网站暂时关闭 或 已停止新用户注册 ';
    }else{
        echo '<p class="grey fs12">还没来过？<a href="/sigin">现在注册</a> ';
    }
}else{
    echo '<p class="grey fs12">又想起来了？<a href="/login">现在登录</a> ';
}
echo '</p>
</form>
</div>';

?>
