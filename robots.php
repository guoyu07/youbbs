<?php
header("Content-Type: text/plain");

$base_url = 'http://'.$_SERVER['HTTP_HOST'];
echo 'User-agent: *
Disallow: /login
Disallow: /logout
Disallow: /sigin
Disallow: /qqsetname
Disallow: /qqlogin
Disallow: /qqcallback
Disallow: /wblogin
Disallow: /wbcallback
Disallow: /wbsetname
Disallow: /admin
Disallow: /forgot
Disallow: /newpost
Disallow: /upload
Disallow: /viewat
Disallow: /setting
Disallow: /notifications
Disallow: /favorites
Disallow: /install
Disallow: /seccode

Sitemap: ', $base_url, '/sitemap.xml
';

?>
