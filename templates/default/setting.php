<?php
if (!defined('IN_SAESPOT')) {
    $dir_arr = explode(DIRECTORY_SEPARATOR, dirname(__FILE__));
    array_pop(array_pop($dir_arr));
    define('ROOT', implode(DIRECTORY_SEPARATOR, $dir_arr));
    include_once(ROOT . '/403.php');
    exit;
};
echo '
<a name="1"></a>
<div class="title"><a href="/">',$options['name'],'</a> &raquo; 设置</div>
<div class="main-box">
<p class="red">',$tip1,'</p>
<form method="post" action="',$_SERVER["REQUEST_URI"],'#1">
<input type="hidden" name="action" value="info"/>
<table cellpadding="5" cellspacing="8" border="0" width="100%" class="fs12">
    <tbody><tr>
        <td width="120" align="right">用户名</td>
        <td width="auto" align="left">',$cur_user['name'],'</td>
    </tr>
    <tr>
        <td width="120" align="right">电子邮件</td>
        <td width="auto" align="left"><input type="text" class="sl w200" name="email" value="',htmlspecialchars(stripslashes($cur_user['email'])),'" /> 不公开，仅供取回密码，务必正确填写且记住。</td>
    </tr>
    <tr>
        <td width="120" align="right">个人网站</td>
        <td width="auto" align="left"><input type="text" class="sl" name="url" value="',htmlspecialchars(stripslashes($cur_user['url'])),'" /> 不要忘了 http:// 或 https:// </td>
    </tr>
    <tr>
        <td width="120" align="right">个人简介</td>
        <td width="auto" align="left"><textarea class="ml" name="about">',htmlspecialchars(stripslashes($cur_user['about'])),'</textarea></td>
    </tr>
    <tr>
        <td width="120" align="right"></td>
        <td width="auto" align="left"><input type="submit" value="保存设置" name="submit" class="textbtn" /></td>
    </tr>

</tbody></table>
</form>

</div>

<a name="2"></a>
<div class="title">设置头像</div>
<div class="main-box">
<p class="red">',$tip2,'</p>
<form action="',$_SERVER["REQUEST_URI"],'#2" enctype="multipart/form-data" method="post">
<input type="hidden" name="action" value="avatar" />
<input type="hidden" name="MAX_FILE_SIZE" value="300000" />
<table cellpadding="5" cellspacing="8" border="0" width="100%" class="fs12">
    <tbody><tr>
        <td width="120" align="right">当前头像</td>
        <td width="auto" align="left">
      <img src="',TUCHUANG_URL,'/avatar/large/',$cur_user['avatar'],'.png','" class="avatar" border="0" align="default" auto=""> &nbsp;
        <img src="',TUCHUANG_URL,'/avatar/normal/',$cur_user['avatar'],'.png','" class="avatar" border="0" align="default" auto=""> &nbsp;
        <img src="',TUCHUANG_URL,'/avatar/mini/',$cur_user['avatar'],'.png','" class="avatar" border="0" align="default" auto=""></td>
    </tr>
    <tr>
        <td width="120" align="right">选择头像图片</td>
        <td width="auto" align="left"><input name="avatar" type="file" /> (最大300K)</td>
    </tr>
    <tr>
        <td width="120" align="right"></td>
        <td width="auto" align="left"><input type="submit" value="更新头像" name="submit" class="textbtn" /></td>
    </tr>

</tbody></table>
</form>

</div>';

if($cur_user['password']){

echo '
<a name="3"></a>
<div class="title">更改密码</div>
<div class="main-box">
<p class="red">',$tip3,'</p>
<form method="post" action="',$_SERVER["REQUEST_URI"],'#3">
<input type="hidden" name="action" value="chpw" />
<table cellpadding="5" cellspacing="8" border="0" width="100%" class="fs12">
    <tbody>
    <tr>
        <td width="120" align="right">当前密码</td>
        <td width="auto" align="left"><input type="password" class="sl" name="password_current" value="" /></td>
    </tr>
    <tr>
        <td width="120" align="right">新密码</td>
        <td width="auto" align="left"><input type="password" class="sl" name="password_new" value="" /></td>
    </tr>
    <tr>
        <td width="120" align="right">再次输入新密码</td>
        <td width="auto" align="left"><input type="password" class="sl" name="password_again" value="" /></td>
    </tr>
    <tr>
        <td width="120" align="right"></td>
        <td width="auto" align="left"><input type="submit" value="更改密码" name="submit" class="textbtn" /></td>
    </tr>

</tbody></table>
</form>

</div>';

}else{

echo '
<a name="3"></a>
<div class="title">设置登录密码： 你可以设置一个登录密码，以备急用</div>
<div class="main-box">
<p class="red">',$tip3,'</p>
<form method="post" action="',$_SERVER["REQUEST_URI"],'#3">
<input type="hidden" name="action" value="setpw" />
<table cellpadding="5" cellspacing="8" border="0" width="100%" class="fs12">
    <tbody>
    <tr>
        <td width="120" align="right"> </td>
        <td width="auto" align="left">当不用QQ登录时可以使用你的用户名和设置的密码登录</td>
    </tr>
    <tr>
        <td width="120" align="right">设置登录密码</td>
        <td width="auto" align="left"><input type="password" class="sl" name="password_new" value="" /></td>
    </tr>
    <tr>
        <td width="120" align="right">再次输入密码</td>
        <td width="auto" align="left"><input type="password" class="sl" name="password_again" value="" /></td>
    </tr>
    <tr>
        <td width="120" align="right"></td>
        <td width="auto" align="left"><input type="submit" value="设置登录密码" name="submit" class="textbtn" /></td>
    </tr>

</tbody></table>
</form>

</div>';

}

?>