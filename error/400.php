<?
header("HTTP/1.1 400 Bad Request");
header("Status: 400 Bad Request");
header("Content-Type: text/html; charset=UTF-8");

switch ($error_code) {
    case 4001:
        $tips = 'No User Agent!';
        break;
    default:
        $tips = '400 Bad Request!';
}

echo '<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="robots" content="none" />
        <title>400 Bad Request!</title>
        <link rel="icon" type="image/png" href="/static/error/favicon.png" />
    </head>
    <body bgcolor="white">
        <center><h1>', $tips, '</h1></center>
        <hr><center>YouBBS(BAE)/', SAESPOT_VER, '</center>
    </body>
</html>
';
?>