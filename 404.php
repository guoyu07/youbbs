<?
header("HTTP/1.1 404 Not Found");
header("Status: 404 Not Found");
header("Content-Type: text/html; charset=UTF-8");
echo '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="robots" content="none" />
    <title>SinoSky 社区 - 404 Not Found!</title>
    <link rel="stylesheet" href="/static/error/404.css">
    <link rel="icon" type="image/png" href="/static/error/favicon.png" />
    <style type="text/css"></style><style>@-moz-keyframes nodeInserted{from{opacity:0.99;}to{opacity:1;}}@-webkit-keyframes nodeInserted{from{opacity:0.99;}to{opacity:1;}}@-o-keyframes nodeInserted{from{opacity:0.99;}to{opacity:1;}}@keyframes nodeInserted{from{opacity:0.99;}to{opacity:1;}}embed,object{animation-duration:.001s;-ms-animation-duration:.001s;-moz-animation-duration:.001s;-webkit-animation-duration:.001s;-o-animation-duration:.001s;animation-name:nodeInserted;-ms-animation-name:nodeInserted;-moz-animation-name:nodeInserted;-webkit-animation-name:nodeInserted;-o-animation-name:nodeInserted;}</style>
</head>
<body>
<div id="container">
    <header id="header">
        <a href="/" title="SinoSky - 自由 平等 开放 分享"><img alt="SinoSky" src="/static/error/logo-transparent.png"/></a>
    </header>
    <div id="main-wrap">
        <img src="/static/error/404.png" alt="404: Not Found" title="404: Not Found">
    </div>
    <footer id="colophon">
        <div class="border"></div>
        <div class="copyright">Copyright &copy; 2012-2013 <a href="/">SinoSky</a>, All Rights Resverved.</div>
    </footer>
</div>
</body>
</html>
';
?>