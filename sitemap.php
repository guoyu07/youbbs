<?php
define('IN_SAESPOT', 1);

include_once(dirname(__FILE__) . '/config.php');
include_once(dirname(__FILE__) . '/common.php');

$base_url = 'http://'.$_SERVER['HTTP_HOST'];
$xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n ";
$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n ";

$query = $DBS->query("SELECT id FROM yunbbs_articles WHERE visible = 1 ORDER BY id");

while ($topic = $DBS->fetch_array($query)) {
    $xml .= '<url><loc>'.$base_url.'/topic-'.$topic['id'].'-1.html</loc></url>'."\n ";
}

$DBS->free_result($query);

$xml .= '</urlset>';

header("Content-Type: text/xml");
echo $xml;
?>
