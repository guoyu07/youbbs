<?
header("HTTP/1.1 401 Unauthorized");
header("Status: 401 Unauthorized");
header("Content-Type: text/html; charset=UTF-8");

if ($error_code) {
    if ($error_code == 4011) {
        $tips = '该账户还在审核中，请耐心等待。 <a href="/" style="color: red;">返回主页</a>';
    }
    if ($error_code == 4012) {
        $tips = '这个页面需要登录后才能访问，请使用管理员账户 <a href="/login" style="color: red;">登录</a> 或 <a href="/" style="color: red;">返回主页</a> 。';
    }
} else {
    $tips = '嗯~&nbsp;这个页面需要登录后才能访问哦，请 <a href="/login" style="color: red;">登录</a> 或 <a href="/" style="color: red;">返回主页</a> 。';
}

echo '<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="robots" content="none" />
        <title>SinoSky 社区 - 401 Unauthorized!</title>
        <link type="text/css" rel="stylesheet" href="/static/error/error.css" charset="utf-8" />
        <link rel="icon" type="image/png" href="/static/error/favicon.png" />
    </head>
    <body>
        <div class="wrapper">
            <div class="wrap">
                <div class="content">
                    <div class="logo">
                        <a href="/" >
                            <img border="0" width="153" height="56" alt="SinoSky" title="SinoSky - 自由 平等 开放 分享" src="/static/error/logo.jpg"/>
                        </a>
                    </div>
                    <div class="main">
                        <h2>401 Unauthorized!</h2>
                        <br/><br/>
                        <center>
                            <img src="/static/error/error.png" alt="401: Unauthorized" title="401: Unauthorized" />
                            <br/>
                            <p>
                                ', $tips, '

                            </p>
                        </center>
                        <a href="/" >
                            <img border="0" class="icon" alt="SinoSky" title="SinoSky - 自由 平等 开放 分享" src="/static/error/favicon.png"/>
                        </a>
                    </div>
                    <span class="clear"></span>
                </div>
            </div>
        </div>
        <div class="footerWrapper">
            <div class="footer">
                Copyright&nbsp;&nbsp;&copy;&nbsp;2012-2013 <a href="/" style="color: blue;">SinoSky</a>,&nbsp;All Rights Reserved.
            </div>
        </div>
    </body>
</html>
';
?>