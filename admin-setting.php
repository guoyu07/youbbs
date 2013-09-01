<?php
define('IN_SAESPOT', 1);
define('ROOT', dirname(__FILE__));

include_once(ROOT . '/config.php');
include_once(ROOT . '/common.php');

if (!$cur_user) {
    $error_code = 4012;
    include_once(ROOT . '/error/401.php');
    exit;
}
if ($cur_user['flag']<99) {
    $error_code = 4031;
    include_once(ROOT . '/error/403.php');
    exit;
}

unset($tip1, $tip2, $tip3);
$tips = array();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $action = trim($_POST['action']);
    switch ($action) {
        case 'base':
            // 修改设置一些默认参数
            $_POST['name'] = filter_chr($_POST['name']);
            $_POST['description'] = filter_chr($_POST['description']);
            $_POST['site_des'] = filter_chr($_POST['site_des']);
            $_POST['icp'] = filter_chr($_POST['icp']);

            $_POST['home_shownum'] = intval($_POST['home_shownum']);
            if(!$_POST['home_shownum']) $_POST['home_shownum'] = 20;

            $_POST['list_shownum'] = intval($_POST['list_shownum']);
            if(!$_POST['list_shownum']) $_POST['list_shownum'] = 20;

            $_POST['newest_node_num'] = intval($_POST['newest_node_num']);
            if(!$_POST['newest_node_num']) $_POST['newest_node_num'] = 20;

            $_POST['hot_node_num'] = intval($_POST['hot_node_num']);
            if(!$_POST['hot_node_num']) $_POST['hot_node_num'] = 20;

            $_POST['article_title_max_len'] = intval($_POST['article_title_max_len']);
            if(!$_POST['article_title_max_len']) $_POST['article_title_max_len'] = 60;

            $_POST['article_content_max_len'] = intval($_POST['article_content_max_len']);
            if(!$_POST['article_content_max_len']) $_POST['article_content_max_len'] = 3000;

            $_POST['article_post_space'] = intval($_POST['article_post_space']);
            if(!$_POST['article_post_space']) $_POST['article_post_space'] = 60;

            $_POST['comment_min_len'] = intval($_POST['comment_min_len']);
            if(!$_POST['comment_min_len']) $_POST['comment_min_len'] = 4;

            $_POST['comment_max_len'] = intval($_POST['comment_max_len']);
            if(!$_POST['comment_max_len']) $_POST['comment_max_len'] = 1200;

            $_POST['commentlist_num'] = intval($_POST['commentlist_num']);
            if(!$_POST['commentlist_num']) $_POST['commentlist_num'] = 32;

            $_POST['comment_post_space'] = intval($_POST['comment_post_space']);
            if(!$_POST['comment_post_space']) $_POST['comment_post_space'] = 20;

            $_POST['close'] = intval($_POST['close']);

            $_POST['close_note'] = filter_chr($_POST['close_note']);
            if(!$_POST['close_note']) $_POST['close_note'] = '数据调整中';

            $_POST['reg_ip_space'] = intval($_POST['reg_ip_space']);
            if(!$_POST['reg_ip_space']) $_POST['reg_ip_space'] = 3600;

            $_POST['authorized'] = intval($_POST['authorized']);
            $_POST['register_review'] = intval($_POST['register_review']);
            $_POST['close_register'] = intval($_POST['close_register']);
            $_POST['close_upload'] = intval($_POST['close_upload']);
            $_POST['show_debug'] = intval($_POST['show_debug']);
            $_POST['img_shuiyin'] = intval($_POST['img_shuiyin']);

            $_POST['jquery_lib'] = filter_chr($_POST['jquery_lib']);
            if(!$_POST['jquery_lib']) $_POST['jquery_lib'] = '/static/js/jquery-1.9.1.min.js';

            $_POST['safe_imgdomain'] = filter_chr($_POST['safe_imgdomain']);

            // qq_scope
            $qq_scope = filter_chr($_POST['qq_scope']);
            if(!$qq_scope) $qq_scope = 'get_user_info';
            if(!strpos(' '.$qq_scope, 'get_info') && !strpos(' '.$qq_scope, 'get_user_info')){
                $qq_scope = 'get_user_info,'.$qq_scope;
            }
            $_POST['qq_scope'] = $qq_scope;

            // 安全图床域名白名单 格式 www.xxx.com
            $safe_imgdomain = trim($_POST['safe_imgdomain']);
            if ($safe_imgdomain) {
                $safe_imgdomain = str_replace("\n\r", "\n", $safe_imgdomain);
                $safe_imgdomain = str_replace("\r", "\n", $safe_imgdomain);
                $safe_imgdomain = str_replace("http://", "", $safe_imgdomain);
                $safe_imgdomain = str_replace("https://", "", $safe_imgdomain);
                $safe_imgdomain = str_replace("/", "", $safe_imgdomain);
                $safe_arr = explode("\n",$safe_imgdomain);
                // 加入网站域名
                if ($_SERVER['HTTP_HOST'] && !in_array($_SERVER['HTTP_HOST'], $safe_arr)) {
                    $safe_arr[] = $_SERVER['HTTP_HOST'];
                }
                // 加入百度云存储
                if (!in_array("bcs.duapp.com", $safe_arr)) {
                    $safe_arr[] = "bcs.duapp.com";
                }
                $safe_arr = array_filter(array_unique($safe_arr));
                $_POST['safe_imgdomain'] = implode("|", $safe_arr);
            }

            // 获取节点数供下面使用
            $table_status = $DBS->fetch_one_array("SHOW TABLE STATUS LIKE 'yunbbs_categories'");
            $nodes_num = $table_status['Auto_increment'];

            // 默认发帖节点
            $_POST['newpost_node'] = intval($_POST['newpost_node']);
            if (!($_POST['newpost_node'] && $options['newpost_node'] != $_POST['newpost_node'] && $_POST['newpost_node'] < $nodes_num)) $_POST['newpost_node'] = 1;

            // 确保 main_nodes 正确
            $_POST['main_nodes'] = filter_chr($_POST['main_nodes']);
            if ($_POST['main_nodes'] && $options['main_nodes'] != $_POST['main_nodes']) {
                $main_nodes = str_replace(" ", ",", $_POST['main_nodes']);
                $main_nodes = str_replace("/", ",", $main_nodes);
                $main_nodes = str_replace("、", ",", $main_nodes);
                $main_nodes = str_replace("。", ",", $main_nodes);
                $main_nodes = str_replace("n-", ",", $main_nodes);
                $main_nodes = str_replace("，", ",", $main_nodes);
                $main_nodes_arr = explode(",", $main_nodes);
                $main_nodes_arr = array_filter(array_unique($main_nodes_arr));
                $new_main_nodes_arr = array();
                foreach ($main_nodes_arr as $node_id) {
                    $node_id = intval($node_id);
                    if ($node_id && $node_id < $nodes_num) {
                        $new_main_nodes_arr[] = $node_id;
                    }
                }
                if ($new_main_nodes_arr) {
                    $_POST['main_nodes'] = implode(",", $new_main_nodes_arr);
                } else {
                    $_POST['main_nodes'] = '';
                }
            }

            // 确保 hide_nodes 正确
            $_POST['hide_nodes'] = filter_chr($_POST['hide_nodes']);
            if ($_POST['hide_nodes'] && $options['hide_nodes'] != $_POST['hide_nodes']) {
                $hide_nodes = str_replace(" ", ",", $_POST['hide_nodes']);
                $hide_nodes = str_replace("/", ",", $hide_nodes);
                $hide_nodes = str_replace("、", ",", $hide_nodes);
                $hide_nodes = str_replace("。", ",", $hide_nodes);
                $hide_nodes = str_replace("n-", ",", $hide_nodes);
                $hide_nodes = str_replace("，", ",", $hide_nodes);
                $hide_nodes_arr = explode(",", $hide_nodes);
                $hide_nodes_arr = array_filter(array_unique($hide_nodes_arr));
                $new_hide_nodes_arr = array();
                foreach ($hide_nodes_arr as $node_id) {
                    $node_id = intval($node_id);
                    if ($node_id && $node_id < $nodes_num) {
                        $new_hide_nodes_arr[] = $node_id;
                    }
                }
                if ($new_hide_nodes_arr) {
                    $_POST['hide_nodes'] = implode(",", $new_hide_nodes_arr);
                } else {
                    $_POST['hide_nodes'] = '';
                }
            }

            // spam_words
            $spam_words = filter_chr($_POST['spam_words']);
            $spam_words = str_replace("，", ",", $spam_words);
            $spam_words_arr = explode(",", $spam_words);
            $spam_words_arr = array_filter(array_unique($spam_words_arr));
            $_POST['spam_words'] = implode(",", $spam_words_arr);

            // ext_list 扩展名列表
            $_POST['ext_list'] = filter_chr($_POST['ext_list']);
            if($_POST['ext_list'] && ($options['ext_list'] != $_POST['ext_list'] ) ){
                $ext_list = str_replace(" ", ",", $_POST['ext_list']);
                $ext_list = str_replace("/", ",", $ext_list);
                $ext_list = str_replace("，", ",", $ext_list);
                $ext_list = str_replace("。", ",", $ext_list);
                $ext_list = str_replace("、", ",", $ext_list);
                $ext_list_arr = explode(",", $ext_list);
                $ext_list_arr = array_filter(array_unique($ext_list_arr));
                if($ext_list_arr){
                    $_POST['ext_list'] = implode(",", $ext_list_arr);
                }else{
                    $_POST['ext_list'] = '';
                }
            }

            //keywords
            $_POST['keywords'] = filter_chr($_POST['keywords']);
            if($_POST['keywords'] && ($options['keywords'] != $_POST['keywords'] ) ){
                $keywords = str_replace(" ", ",", $_POST['keywords']);
                $keywords = str_replace("/", ",", $keywords);
                $keywords = str_replace("，", ",", $keywords);
                $keywords = str_replace("。", ",", $keywords);
                $keywords = str_replace("、", ",", $keywords);
                $keywords_arr = explode(",", $keywords);
                $keywords_arr = array_filter(array_unique($keywords_arr));
                if($keywords_arr){
                    $_POST['keywords'] = implode(", ", $keywords_arr);
                }else{
                    $_POST['keywords'] = '';
                }
            }

            $changed = 0;
            foreach($options as $k=>$v){
                if($k != 'site_create'){
                    // 使用反斜线引用字符串
                    $newv = addslashes(trim($_POST[$k]));
                    if(str_replace('\\', '', $newv)!= $v){
                        $DBS->unbuffered_query("UPDATE yunbbs_settings SET value='$newv' WHERE title='$k'");
                        $changed += 1;
                        // 更新原数据 去掉反斜线
                        $options[$k] = str_replace('\\', '', $newv);
                    }
                }
            }
            if($changed){
                $MMC->delete('options');
                $MMC->delete('regip_'.$onlineip);
                $tip1 = '已成功更改了 '.$changed.' 个设置';
            }
            break;


        case 'flushmc':
            // $MMC->flush();
            $tip2 = 'BAE目前不支持清空缓存';
            break;


        case 'flushdata':
            $DBS->query("DROP TABLE IF EXISTS yunbbs_articles");
            $DBS->query("DROP TABLE IF EXISTS yunbbs_categories");
            $DBS->query("DROP TABLE IF EXISTS yunbbs_comments");
            $DBS->query("DROP TABLE IF EXISTS yunbbs_links");
            $DBS->query("DROP TABLE IF EXISTS yunbbs_settings");
            $DBS->query("DROP TABLE IF EXISTS yunbbs_users");
            $DBS->query("DROP TABLE IF EXISTS yunbbs_favorites");
            $DBS->query("DROP TABLE IF EXISTS yunbbs_qqweibo");
            $DBS->query("DROP TABLE IF EXISTS yunbbs_weibo");

            //$MMC->flush();

            $tip3 = '所有数据已删除';
            header('Location: /install');
            break;

        default:
            break;
    }
}

// 页面变量
$title = '网站设置 - '.$options['name'];

$pagefile = ROOT . '/templates/default/'.$tpl.'admin-setting.php';

include_once(ROOT . '/templates/default/'.$tpl.'layout.php');

?>
