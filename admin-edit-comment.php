<?php
define('IN_SAESPOT', 1);

include_once(dirname(__FILE__) . '/config.php');
include_once(dirname(__FILE__) . '/common.php');

if (!$cur_user) {
    $error_code = 4012;
    include_once(dirname(__FILE__) . '/401.php');
    exit;
}
if ($cur_user['flag']<88) {
    $error_code = 4031;
    include_once(dirname(__FILE__) . '/403.php');
    exit;
}

$rid = intval($_GET['rid']);
$query = "SELECT id,articleid,content FROM yunbbs_comments WHERE id='$rid'";
$r_obj = $DBS->fetch_one_array($query);
if(!$r_obj){
    $error_code = 4044;
    $title = $options['name'].' › 评论未找到';
    $pagefile = dirname(__FILE__) . '/templates/default/404.php';
    include_once(dirname(__FILE__) . '/templates/default/'.$tpl.'layout.php');
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $r_content = addslashes(trim($_POST['content']));

    if($r_content){
        $r_content = htmlspecialchars($r_content);
        $DBS->unbuffered_query("UPDATE yunbbs_comments SET content='$r_content' WHERE id='$rid'");
        $query = "SELECT comments FROM yunbbs_articles WHERE id='".$r_obj['articleid']."'";
        $t_obj = $DBS->fetch_one_array($query);
        $page = ceil($t_obj['comments']/$options['commentlist_num']);
        $MMC->delete('commentdb-'.$r_obj['articleid'].'-'.$page);
        $MMC->delete('commentdb-'.$r_obj['articleid'].'_ios-'.$page);
        $tip = '评论已成功修改';
    }else{
        $tip = '内容 不能留空';
    }
}else{
    $r_content = $r_obj['content'];
    $tip = '';
}

// 页面变量
$title = '修改评论 - '.$options['name'];
// 设置回复图片最大宽度
$img_max_w = 590;


$pagefile = dirname(__FILE__) . '/templates/default/'.$tpl.'admin-edit-comment.php';

include_once(dirname(__FILE__) . '/templates/default/'.$tpl.'layout.php');

?>