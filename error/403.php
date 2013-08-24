<?
header("HTTP/1.1 403 Forbidden");
header("Status: 403 Forbidden");
header("Content-Type: text/html; charset=UTF-8");

switch ($error_code) {
    case 4031:
        $tips = '你没有权限访问这个页面，请使用管理员账户 <a href="/login">登录</a> 或 返回<a href="/">首页</a> 。';
        break;
    case 4032:
        $tips = '该账户已禁用。 返回<a href="/">首页</a>';
        break;
    case 4033:
        $tips = '错误的 HTTP Referer。 返回<a href="/">首页</a>';
        break;
    case 4034:
        $tips = '请勿发布垃圾评论，该账户已被禁用。 返回<a href="/">首页</a>';
        break;
    case 4035:
        $tips = '附件上传已禁用。 返回<a href="/">首页</a>';
        break;
    case 4036:
        $tips = '无法获取你的 IP 地址。';
        break;
    case 4037:
        $tips = '登录失败超过 5 次。 返回<a href="/">首页</a>';
        break;
    case 4038:
        $tips = '使用 QQ 账号登录失败，请尝试 重新<a href="/qqlogin">登录</a> 或 返回<a href="/">首页</a> 。';
        break;
    case 4039:
        $tips = '使用 新浪微博 账号登录失败，请尝试 重新<a href="/wblogin">登录</a> 或 返回<a href="/">首页</a> 。';
        break;
    case 4030:
        $tips = '一个 ip 最小注册间隔时间是 '.$options['reg_ip_space'].' 秒，请稍后再来注册或让管理员把这个时间改小点。 返回<a href="/">首页</a> 。';
        break;
    default:
        $tips = '嗯~&nbsp;看来你没有权限访问这个页面哦，请 <a href="/login">登录</a> 或 返回<a href="/">首页</a> 。';
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