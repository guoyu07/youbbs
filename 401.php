<?
header("HTTP/1.1 401 Unauthorized");
header("Status: 401 Unauthorized");
header("Content-Type: text/html; charset=UTF-8");

switch ($error_code) {
    case 4011:
        $tips = '该账户还在审核中，请耐心等待。 返回<a href="/">首页</a>';
        break;
    case 4012:
        $tips = '这个页面需要登录后才能访问，请使用管理员账户 <a href="/login">登录</a> 或 返回<a href="/">首页</a> 。';
        break;
    default:
        $tips = '嗯~&nbsp;这个页面需要登录后才能访问哦，请 <a href="/login">登录</a> 或 返回<a href="/">首页</a> 。';
}

echo '<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="robots" content="none" />
        <title>401 Unauthorized!</title>
        <link type="text/css" rel="stylesheet" href="/static/error/error.css" charset="utf-8" />
        <link rel="icon" type="image/png" href="/favicon.ico" />
    </head>
    <body>
        <div class="wrapper">
            <div class="wrap">
                <div class="content">
                    <div class="main">
                        <h2>401 Unauthorized!</h2>
                        <img src="/static/error/error.png" alt="401: Unauthorized" title="401: Unauthorized" />
                        <p>', $tips, '</p>
                    </div>
                    <span class="clear"></span>
                </div>
            </div>
        </div>
    </body>
</html>
';
?>