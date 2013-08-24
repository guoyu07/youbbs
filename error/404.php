<?
define('IN_SAESPOT', 1);

header("HTTP/1.1 404 Not Found");
header("Status: 404 Not Found");
header("Content-Type: text/html; charset=UTF-8");
echo '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="robots" content="none" />
    <title>404 Not Found!</title>
    <link rel="icon" type="image/png" href="/favicon.ico" />
</head>
<body>
<script type="text/javascript" src="http://www.qq.com/404/search_children.js" charset="utf-8"></script>
</body>
</html>
';
?>