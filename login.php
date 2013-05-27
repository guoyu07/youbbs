<?php
define('IN_SAESPOT', 1);

include_once(dirname(__FILE__) . '/config.php');
include_once(dirname(__FILE__) . '/common.php');

// 屏蔽下面几行可以通过 用户名 和 密码 登录
/*
if(($options['qq_appid'] && $options['qq_appkey']) || ($options['wb_key'] && $options['wb_secret'])){
    header("Content-Type: text/html; charset=UTF-8");
    echo '请用 ';
    if($options['wb_key'] && $options['wb_secret']){
        echo '&nbsp;<a href="/wblogin">微博登录</a>';
    }
    if($options['qq_appid'] && $options['qq_appkey']){
        echo '&nbsp;<a href="/qqlogin">QQ登录</a>';
    }
    echo '&nbsp;<a href="/">返回首页</a>';
    exit;
}
*/

if($cur_user){
    // 如果已经登录用户无聊打开这网址就让他重新登录吧
    $MMC->delete('u_'.$cur_uid);
    setcookie("cur_uid", '', $timestamp-86400 * 365, '/');
    setcookie("cur_uname", '', $timestamp-86400 * 365, '/');
    setcookie("cur_ucode", '', $timestamp-86400 * 365, '/');
    $cur_user = null;
    $cur_uid = '';
}

$errors = array();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(empty($_SERVER['HTTP_REFERER']) || $_POST['formhash'] != formhash() || preg_replace("/https?:\/\/([^\:\/]+).*/i", "\\1", $_SERVER['HTTP_REFERER']) !== preg_replace("/([^\:]+).*/", "\\1", $_SERVER['HTTP_HOST'])) {
        $error_code = 4033;
        include_once(dirname(__FILE__) . '/403.php');
        exit;
    }

    $name = addslashes(strtolower(trim($_POST["name"])));
    $pw = addslashes(trim($_POST["pw"]));
    if($name && $pw){
        if(strlen($name)<21 && strlen($pw)<32){
            if(preg_match('/^[\w\d\x{4e00}-\x{9fa5}]{4,20}$/iu', $name)){
                if(preg_match('/^\d{4,20}$/', $name)){
                    $errors[] = '名字不能全为数字';
                }else{
                    // 检测输错超过5次即屏蔽该ip 1个小时
                    $ck_key = 'login_'.$onlineip;
                    $ck_obj = $MMC->get($ck_key);
                    if($ck_obj && $ck_obj > 5){
                        $error_code = 4037;
                        include_once(dirname(__FILE__) . '/403.php');
                        exit;
                    }
                    $db_user = $DBS->fetch_one_array("SELECT * FROM yunbbs_users WHERE name='".$name."' LIMIT 1");
                    if($db_user){
                        $pwmd5 = md5($pw);
                        if($pwmd5 == $db_user['password']){
                            //设置缓存和cookie
                            $db_ucode = md5($db_user['id'].$db_user['password'].$db_user['regtime'].$db_user['lastposttime'].$db_user['lastreplytime']);
                            $cur_uid = $db_user['id'];
                            $MMC->set('u_'.$cur_uid, $check_user, 0, 600);
                            setcookie("cur_uid", $cur_uid, time()+ 86400 * 365, '/');
                            setcookie("cur_uname", $name, time()+86400 * 365, '/');
                            setcookie("cur_ucode", $db_ucode, time()+86400 * 365, '/');
                            $cur_user = $db_user;
                            unset($db_user);
                            if($ck_obj){
                                $MMC->delete($ck_key);
                            }
                            header('Location: /');
                            exit('logined');
                        }else{
                            // 用户名和密码不匹配
                            $errors[] = '用户名 或 密码 错误，出错不能超过5次';
                            if($ck_obj){
                                $MMC->increment($ck_key, 1);
                            }else{
                                $MMC->set($ck_key, 1, 0, 3600);
                            }
                        }
                    }else{
                        // 没有该用户名
                        $errors[] = '用户名 或 密码 错误，出错不能超过5次';
                        if($ck_obj){
                            $MMC->increment($ck_key, 1);
                        }else{
                            $MMC->set($ck_key, 1, 0, 3600);
                        }
                    }
                }
            }else{
                $errors[] = '名字 太长 或 太短 或 包含非法字符';
            }
        }else{
            $errors[] = '用户名 或 密码 太长了';
        }
    }else{
       $errors[] = '用户名 和 密码 必填';
    }
}

// 页面变量
$title = '登录 - '.$options['name'];

$pagefile = dirname(__FILE__) . '/templates/default/'.$tpl.'sigin_login.php';

include_once(dirname(__FILE__) . '/templates/default/'.$tpl.'layout.php');

?>
