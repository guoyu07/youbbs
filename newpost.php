<?php
define('IN_SAESPOT', 1);

include_once(dirname(__FILE__) . '/config.php');
include_once(dirname(__FILE__) . '/common.php');

if (!$cur_user) {
    include_once(dirname(__FILE__) . '/401.php');
    exit;
} else {
    if ($cur_user['flag'] == 0){
        $error_code = 4032;
        include_once(dirname(__FILE__) . '/403.php');
        exit;
    }
    if ($cur_user['flag'] == 1){
        $error_code = 4011;
        include_once(dirname(__FILE__) . '/403.php');
        exit;
    }
}

$cid = intval($_GET['cid']);
if($cid<1){
    header('Location: /');
    exit;
}

if($options['main_nodes']){
    $main_nodes_arr = explode(",", $options['main_nodes']);
    if(!in_array($cid, $main_nodes_arr)){
       $main_nodes_arr[] = $cid;
    }
    $main_nodes_str = implode(",", $main_nodes_arr);
    $query = $DBS->query("SELECT id, name FROM yunbbs_categories WHERE id in($main_nodes_str)");

    $main_nodes_arr = array();
    while($node = $DBS->fetch_array($query)) {
        $main_nodes_arr[$node['id']] = $node['name'];
    }

    unset($node);
    $DBS->free_result($query);
}


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(empty($_SERVER['HTTP_REFERER']) || $_POST['formhash'] != formhash() || preg_replace("/https?:\/\/([^\:\/]+).*/i", "\\1", $_SERVER['HTTP_REFERER']) !== preg_replace("/([^\:]+).*/", "\\1", $_SERVER['HTTP_HOST'])) {
    	exit('Error 403: unknown referer.');
    }

    $p_title = addslashes(trim($_POST['title']));
    $p_content = addslashes(trim($_POST['content']));

    if($p_title =='test' || $p_title=='测试'){
        exit('Error 403: no test anymore.');
    }

    // spam_words
    if($options['spam_words'] && $cur_user['flag']<99){
        $check_con = ' '.$p_title.$p_content;
        $spam_words_arr = explode(",", $options['spam_words']);
        foreach($spam_words_arr as $spam){
            if(strpos($check_con, $spam)){
                // has spam word
                $DBS->unbuffered_query("UPDATE yunbbs_users SET flag='0' WHERE id='$cur_uid'");
                $MMC->delete('u_'.$cur_uid);
                exit('Error 403: do not post any spam.');
            }
        }
    }


    if($options['main_nodes']){
        $cid = $_POST['select_cid'];
    }
    if(($timestamp - $cur_user['lastposttime']) > $options['article_post_space']){
        if($p_title){
            if(mb_strlen($p_title,'utf-8')<=$options['article_title_max_len'] && mb_strlen($p_content,'utf-8')<=$options['article_content_max_len']){
                $conmd5 = md5($p_title.$p_content);
                if($MMC->get('cm_'.$conmd5)){
                    $tip = '请勿发布相同的内容 或 灌水';
                }else{
                    $p_title = htmlspecialchars($p_title);
                    $p_content = htmlspecialchars($p_content);
                    $DBS->query("INSERT INTO yunbbs_articles (id,cid,uid,title,content,addtime,edittime) VALUES (null,$cid,$cur_uid, '$p_title', '$p_content', $timestamp, $timestamp)");
                    $new_aid = $DBS->insert_id();
                    $DBS->unbuffered_query("UPDATE yunbbs_categories SET articles=articles+1 WHERE id='$cid'");
                    $DBS->unbuffered_query("UPDATE yunbbs_users SET articles=articles+1, lastposttime=$timestamp WHERE id='$cur_uid'");
                    // 更新u_code
                    $cur_user['lastposttime'] = $timestamp;
                    //
                    $MMC->delete('u_'.$cur_uid);
                    $new_ucode = md5($cur_uid.$cur_user['password'].$cur_user['regtime'].$cur_user['lastposttime'].$cur_user['lastreplytime']);
                    setcookie("cur_uid", $cur_uid, $timestamp+ 86400 * 365, '/');
                    setcookie("cur_uname", $cur_uname, $timestamp+86400 * 365, '/');
                    setcookie("cur_ucode", $new_ucode, $timestamp+86400 * 365, '/');
                    // del cache
                    $MMC->delete('home-article-list');
                    $MMC->delete('cat-page-article-list-'.$cid.'-1');
                    $MMC->delete('n-'.$cid);
                    $MMC->delete('site_infos');
                    // mentions 没有提醒用户的id，等缓存自动过期，提醒有600秒延迟
                    $mentions = find_mentions(' '.$p_title.' '.$p_content, $cur_uname);
                    if($mentions && count($mentions)<=10){
                        foreach($mentions as $m_name){
                            $DBS->unbuffered_query("UPDATE yunbbs_users SET notic =  concat('$new_aid,', notic) WHERE name='$m_name'");
                        }
                    }

                    // 保存内容md5值
                    $MMC->set('cm_'.$conmd5, '1', 0, 3600);

                    $p_title = $p_content = '';
                    header('Location: /topic-'.$new_aid.'-1.html');
                    exit;
                }
            }else{
                $tip = '标题'.mb_strlen($p_title,'utf-8').' 或 内容'.mb_strlen($p_content,'utf-8').' 太长了';
            }
        }else{
            $tip = '标题 不能留空';
        }
    }else{
        $tip = '发帖最小间隔时间是 '.$options['article_post_space'].'秒';
    }
}else{
    $p_title = '';
    $p_content = '';
    $tip = '';
    $c_obj = $DBS->fetch_one_array("SELECT * FROM yunbbs_categories WHERE id='".$cid."'");
    if(!$c_obj){
        exit(header('Location: /static/error/404.html'));
    }
}
// 页面变量
$title = '发新帖子 - '.$options['name'].' 社区';
// 设置处理图片的最大宽度
$img_max_w = 650;
$newpost_page = '1';

//$newest_nodes = get_newest_nodes();

$pagefile = dirname(__FILE__) . '/templates/default/'.$tpl.'newpost.php';

include_once(dirname(__FILE__) . '/templates/default/'.$tpl.'layout.php');

?>
