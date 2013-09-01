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

$nid = intval($_GET['nid']);
if($nid){
    $query = "SELECT * FROM yunbbs_categories WHERE id='$nid'";
    $c_obj = $DBS->fetch_one_array($query);
    if(!$c_obj){
        $error_code = 4046;
        $title = $options['name'].' › 节点未找到';
        $pagefile = ROOT . '/templates/default/404.php';
        include_once(ROOT . '/templates/default/'.$tpl.'layout.php');
        exit;
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $action = $_POST['action'];

    switch ($action) {
        case 'find':
            $n_id = trim($_POST['findid']);
            $n_id ? header('Location: /admin-node-'.$n_id) : header('Location: /admin-node#edit');
            break;

        case 'add':
            $n_name = addslashes(trim($_POST['name']));
            $n_about = addslashes(trim($_POST['about']));
            if ($n_name) {
                $check_obj = $DBS->fetch_one_array("SELECT * FROM yunbbs_categories WHERE name='$n_name'");
                if ($check_obj) {
                    $tip1 = $n_name.' 节点已存在，请修改为不同的节点名';
                } else {
                    if ($DBS->query("INSERT INTO yunbbs_categories (id,name,about) VALUES (null,'$n_name','$n_about')")) {
                        //更新缓存
                        $MMC->delete('newest_nodes');
                        $MMC->delete('bot_nodes');
                        $MMC->delete('site_infos');
                        $tip1 = '已成功添加';
                    } else {
                        $tip1 = '数据库更新失败，修改尚未保存，请稍后再试';
                    }
                }
            } else {
                $tip1 = '节点名不能留空';
            }
            break;

        case 'edit':
            $n_name = addslashes(trim($_POST['name']));
            $n_about = addslashes(trim($_POST['about']));
            if ($n_name) {
                if ($DBS->unbuffered_query("UPDATE yunbbs_categories SET name='$n_name',about='$n_about' WHERE id='$nid'")) {
                    //更新缓存
                    $MMC->delete('newest_nodes');
                    $MMC->delete('bot_nodes');
                    $MMC->delete('n-'.$nid);
                    $c_obj['name'] = $n_name;
                    $c_obj['about'] = $n_about;
                    $tip2 = '已成功保存';
                } else {
                    $tip2 = '数据库更新失败，修改尚未保存，请稍后再试';
            }

            } else {
                $tip2 = '节点名不能留空';
            }
            break;
    }
}

// 页面变量
$title = '节点管理 - '.$options['name'];

$pagefile = ROOT . '/templates/default/'.$tpl.'admin-node.php';

include_once(ROOT . '/templates/default/'.$tpl.'layout.php');

?>
