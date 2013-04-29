<?
header("HTTP/1.1 403 Forbidden");
header("Status: 403 Forbidden");
header("Content-Type: text/html; charset=UTF-8");

if ($error_code) {
    if ($error_code == 4031) {
        $tips = '你没有权限访问这个页面，请使用管理员账户 <a href="/login"">登录</a> 或 <a href="/"">返回主页</a> 。';
    }
    if ($error_code == 4032) {
        $tips = '该账户已禁用。 <a href="/"">返回主页</a>';
    }
    if ($error_code == 4033) {
        $tips = '未知的 HTTP Referer。 <a href="/"">返回主页</a>';
    }
    if ($error_code == 4034) {
        $tips = '请勿发布垃圾评论，该账户已被禁用。 <a href="/"">返回主页</a>';
    }
    if ($error_code == 4035) {
        $tips = '附件上传已禁用。 <a href="/"">返回主页</a>';
    }
    if ($error_code == 4036) {
        $tips = '无法获取你的 IP 地址。';
    }
} else {
    $tips = '嗯~&nbsp;看来你没有权限访问这个页面哦，请 <a href="/login"">登录</a> 或 <a href="/"">返回主页</a> 。';
}

echo '<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="robots" content="none" />
        <title>403 Forbidden!</title>
        <link type="text/css" rel="stylesheet" href="/static/error/error.css" charset="utf-8" />
        <link rel="icon" type="image/png" href="/favicon.ico" />
    </head>
    <body>
        <div class="wrapper">
            <div class="wrap">
                <div class="content">
                    <div class="main">
                        <h2>403 Forbidden!</h2>
                        <img src="/static/error/error.png" alt="403: Forbidden" title="403: Forbidden" />
                            <p>
                                ', $tips, '
                            </p>
                    </div>
                    <span class="clear"></span>
                </div>
            </div>
        </div>
    </body>
</html>
';
?>