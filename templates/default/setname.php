<?php
if (!defined('IN_SAESPOT')) {
    $dir_arr = explode(DIRECTORY_SEPARATOR, dirname(__FILE__));
    array_pop(array_pop($dir_arr));
    define('ROOT', implode(DIRECTORY_SEPARATOR, $dir_arr));
    include_once(ROOT . '/403.php');
    exit;
};

echo '
<div class="title"><a href="/">',$options['name'],'</a> &raquo; 设置名字</div>
<div class="main-box">';

if($options['close_register'] || $options['close']){
    echo '<p class="grey fs12">网站暂时关闭 或 已停止新用户注册';
}else{

echo '<p class="red fs12" style="margin-left:60px;">';
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
<h4 class="grey">欢迎<span class="red"> ',$name,' </span>用 <span class="red">',$logintype,'</span> 成功登录本站，请先设置您在本站显示的名字：</h4>
<br/><br/>
<h4 class="grey"> • 第一次来？请先设置在网站显示的名字</h4>
<br/>
<form action="',$_SERVER["REQUEST_URI"],'" method="post">
<input type="hidden" name="action" value="newuser"/>
<p><label>名　字： <input type="text" name="name" class="sl w200" value="',htmlspecialchars($name),'" /></label>  <span class="fs12">允许字母、数字、中文，不能全为数字，4~12个字节</span></p>
<p><input type="submit" value=" 提交 " name="submit" class="textbtn" style="margin-left:60px;" /> </p>

</form>';

echo '<p>&nbsp;</p>
<h4 class="grey"> • 以前有注册？请先输入原登录名和密码完成绑定</h4>
<br/>
<form action="',$_SERVER["REQUEST_URI"],'" method="post">
<input type="hidden" name="action" value="bind"/>
<p><label>原登录名： <input type="text" name="name" class="sl w200" value="" /></label>  <span class="fs12">允许字母、数字、中文，不能全为数字，4~12个字节</span></p>
<p><label>登录密码： <input type="password" name="pw" class="sl w200" value="" /></label><span class="grey fs12"> 忘记密码？<a href="/forgot">马上找回</a></span></p>
<p><input type="submit" value=" 绑定 " name="submit" class="textbtn" style="margin-left:60px;" /> </p>

</form>';

}

echo '</div>';

?>
