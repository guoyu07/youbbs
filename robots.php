<?php
define('IN_SAESPOT', 1);

include_once(dirname(__FILE__) . '/config.php');
include_once(dirname(__FILE__) . '/common.php');

header("Content-Type: text/plain");
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

';

$table_status = $DBS->fetch_one_array("SHOW TABLE STATUS LIKE 'yunbbs_articles'");
$post_num = $table_status['Auto_increment'] -1;

$max_num = 39000;
$taltol_page = ceil($post_num/$max_num);
$base_url = 'http://'.$_SERVER['HTTP_HOST'];

for($i = 1; $i <= $post_num; $i+=$max_num){
    echo 'Sitemap: ',$base_url,'/sitemap-',$i,".xml\n";
}

?>
