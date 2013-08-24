<?php
define('IN_SAESPOT', 1);
define('ROOT', dirname(__FILE__));

include_once(ROOT . '/config.php');
include_once(ROOT . '/common.php');

if($options['authorized'] || $options['close']){
    include_once(dirname(__FILE__) . '/error/403.php');
    exit;
}

// 获取最近文章列表
$articledb = $MMC->get('feed-article-list');
if(!$articledb){
    if ($options['hide_nodes']) $hide_nodes_str = "AND cid <> ".str_replace(",", " AND cid <> ", $options['hide_nodes']);
    else $hide_nodes_str = "";
    $query_sql = "SELECT a.id,a.cid,a.uid,a.ruid,a.title,a.content,a.addtime,a.edittime,a.comments,c.name as cname,u.name as author
        FROM yunbbs_articles a
        LEFT JOIN yunbbs_categories c ON c.id=a.cid
        LEFT JOIN yunbbs_users u ON a.uid=u.id
        WHERE visible = 1 $hide_nodes_str
        ORDER BY id
        DESC LIMIT 10";
    $query = $DBS->query($query_sql);
    $articledb=array();
    while ($article = $DBS->fetch_array($query)) {
        // 格式化内容
        $article['addtime'] = gmdate('Y-m-dTH:M:SZ',$article['addtime']);
        $article['edittime'] = gmdate('Y-m-dTH:M:SZ',$article['edittime']);
        $articledb[] = $article;
    }
    unset($article);
    $DBS->free_result($query);
    $MMC->set('feed-article-list', $articledb, 0, 600);
}

$base_url = 'http://'.$_SERVER['HTTP_HOST'];


ob_start();
echo '<?xml version="1.0" encoding="utf-8"?>
<feed xmlns="http://www.w3.org/2005/Atom">
  <title>',htmlspecialchars($options['name']),'</title>
';
if ($options['description']) {
  echo '  <description>', $options['description'], '</description>
';
}
echo '  <link>',$base_url,'</link>
  <link rel="self" type="application/atom+xml" href="',$base_url,'/feed"/>
  <link rel="hub" href="https://code.google.com/p/pubsubhubbub/"/>
  <updated>',gmdate('Y-m-dTH:M:SZ',$timestamp),'</updated>
  <author>
    <name>',htmlspecialchars($options['name']),'</name>
  </author>
';

foreach($articledb as $article){
echo '
  <entry>
    <title>',htmlspecialchars($article['title']),'</title>
    <id>',$article['id'],'</id>
  <link rel="alternate" type="text/html" href="',$base_url,'/topic-',$article['id'],'-1.html" />
    <published>',$article['addtime'],'</published>
    <updated>',$article['edittime'],'</updated>
    <content type="html">
      ',htmlspecialchars($article['cname']),' - ',htmlspecialchars($article['author']);
if ($article['content']) {
  echo ' - ',htmlspecialchars(mb_substr($article['content'], 0, 150, 'utf-8'));
}
  echo '
    </content>
  </entry>';

}

echo '
</feed>';

$_output = ob_get_contents();
ob_end_clean();

header("Content-Type: application/atom+xml; charset=UTF-8");

echo $_output;

?>
