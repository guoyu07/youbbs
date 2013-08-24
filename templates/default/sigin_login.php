<?php
if (!defined('IN_SAESPOT')) {
    $dir_arr = explode(DIRECTORY_SEPARATOR, dirname(__FILE__));
    array_pop(array_pop($dir_arr));
    define('ROOT', implode(DIRECTORY_SEPARATOR, $dir_arr));
    include_once(ROOT . '/error/403.php');
    exit;
};

echo '
<div class="title"><a href="/">',$options['name'],'</a> &raquo; ';
if($url_path == 'sigin'){
    echo '注 册';
}
if($url_path == 'login'){
    echo '登 录';
}
echo '</div>
<div class="main-box">
<p class="red fs12" style="margin-left:60px;">';
if($options['authorized']){
    echo $options['name'],' 已设置只有登录用户才能访问，请先登录！ <br/>';
}
if($options['register_review']){
    echo $options['name'],' 已设置注册用户验证，注册后需要管理员审核！ <br/>';
}

foreach($errors as $error){
    echo '› ',$error,' <br/>';
}

echo '</p>
<form action="',$_SERVER["REQUEST_URI"],'" method="post">
<input type="hidden" name="formhash" value="',$formhash,'" />
<p><label>登录名： <input type="text" name="name" class="sl w200" value="',htmlspecialchars($name),'" /></label>  <span class="fs12">允许字母、数字、中文，不能全为数字，4~12个字符</span></p>
<p><label>密　码： <input type="password" name="pw" class="sl w200" value="" /></label></p>';

if($url_path == 'sigin'){
    if($regip){
        echo '<p class="red">一个ip最小注册间隔时间是 ',$options['reg_ip_space'],' 秒，请稍后再来注册 或 让管理员把这个时间改小点。</p>';
    }else{
        echo '<p><label>重　复： <input type="password" name="pw2" class="sl w200" value="" /></label></p>';
        echo '<p><label>验证码： <input type="text" name="seccode" class="sl w100" value="" /></label> <img src="/seccode" align="absmiddle" /></p>';
    }
}

echo '<p><input type="submit" value="';
if($url_path == 'sigin'){
    echo '注 册';
}
if($url_path == 'login'){
    echo '登 录';
}
echo '" name="submit" class="textbtn" style="margin-left:60px;" /></p>';

if(($options['wb_key'] && $options['wb_secret']) && ($options['qq_appid'] && $options['qq_appkey'])){
    echo '<p><a href="/wblogin" rel="nofollow" style="margin-left:60px;"><img src="/static/weibo_login_120_24.png" alt="用新浪微博登录"/></a>&nbsp;&nbsp;&nbsp;<a href="/qqlogin" rel="nofollow"><img src="/static/qq_login_120_24.png" alt="用QQ登录"/></a></p>';
}else{
    if($options['wb_key'] && $options['wb_secret']){
        echo '<p><a href="/wblogin" rel="nofollow" style="margin-left:60px;"><img src="/static/weibo_login_120_24.png" alt="用新浪微博登录"/></a></p>';
    }
    if($options['qq_appid'] && $options['qq_appkey']){
        echo '<p><a href="/qqlogin" rel="nofollow" style="margin-left:60px;"><img src="/static/qq_login_120_24.png" alt="用QQ登录"/></a></p>';
    }
}

if($url_path == 'login'){
    if($options['close_register'] || $options['close']){
        echo '<p class="grey fs12">网站暂时关闭 或 已停止新用户注册&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;忘记密码？ <a href="/forgot">马上找回</a>';
    }else{
        echo '<p class="grey fs12">还没来过？ <a href="/sigin">现在注册</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;忘记密码？ <a href="/forgot">马上找回</a>';
    }
}else{
    echo '<p class="grey fs12">已有用户？ <a href="/login">现在登录</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;忘记密码？ <a href="/forgot">马上找回</a>';
}
echo '</p>
</form>
</div>';

?>
