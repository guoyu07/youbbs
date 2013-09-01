<?php
define('IN_SAESPOT', 1);
define('ROOT', dirname(__FILE__));

include_once(ROOT . '/config.php');
include_once(ROOT . '/common.php');

// 屏蔽下面几行可以通过 用户名 和 密码 注册
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
    header('Location: /');
    exit;
}else{
    if($options['close_register']){
        header('Location: /login');
        exit;
    }
}

// 检测已注册ip
$regip = $MMC->get('regip_'.$onlineip);

$errors = array();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(empty($_SERVER['HTTP_REFERER']) || $_POST['formhash'] != formhash() || preg_replace("/https?:\/\/([^\:\/]+).*/i", "\\1", $_SERVER['HTTP_REFERER']) !== preg_replace("/([^\:]+).*/", "\\1", $_SERVER['HTTP_HOST'])) {
        $error_code = 4033;
        include_once(ROOT . '/error/403.php');
        exit;
    }

    if($regip){
        $error_code = 4030;
        include_once(ROOT . '/error/403.php');
        exit;
    }

    $name = addslashes(strtolower(trim($_POST["name"])));
    $pw = addslashes(trim($_POST["pw"]));
    $pw2 = addslashes(trim($_POST["pw2"]));
    $seccode = intval(trim($_POST["seccode"]));
    if($name && $pw && $pw2 && $seccode){
        if($pw === $pw2){
            if(strlen($name)<21 && strlen($pw)<32){
                //检测字符
                if(preg_match('/^[\w\d\x{4e00}-\x{9fa5}]{4,20}$/iu', $name)){
                    if(preg_match('/^\d{4,20}$/', $name)){
                        $errors[] = '名字不能全为数字';
                    }else{
                        error_reporting(0);
                        session_start();
                        if($seccode === intval($_SESSION['code'])){
                            $db_user = $DBS->fetch_one_array("SELECT id FROM yunbbs_users WHERE name='".$name."' LIMIT 1");
                            if(!$db_user){
                                //正常
                            }else{
                                $errors[] = '这名字太火了，已经被抢注了，换一个吧！';
                            }
                        }else{
                            $errors[] = '验证码输入不对';
                        }
                    }
                }else{
                    $errors[] = '名字 太长 或 太短 或 包含非法字符';
                }
            }else{
                $errors[] = '用户名 或 密码 太长了';
            }
        }else{
            $errors[] = '密码、重复密码 输入不一致';
        }
    }else{
       $errors[] = '用户名、密码、重复密码、验证码 必填';
    }
    ////
    if(!$errors){
        $pwmd5 = md5($pw);

        if($options['register_review']){
            $flag = 1;
        }else{
            $flag = 5;
        }
        $DBS->query("INSERT INTO yunbbs_users (id,name,flag,password,regtime) VALUES (null,'$name', $flag, '$pwmd5', $timestamp)");
        $new_uid = $DBS->insert_id();
        if($new_uid == 1){
            $DBS->unbuffered_query("UPDATE yunbbs_users SET flag = '99' WHERE id='1'");
        }
        $MMC->delete('site_infos');
        // 记录已注册ip
        $MMC->set('regip_'.$onlineip, '1', 0, intval($options['reg_ip_space']));

        //设置cookie
        $db_ucode = md5($new_uid.$pwmd5.$timestamp.'00');
        $cur_uid = $new_uid;
        setcookie("cur_uid", $cur_uid, $timestamp+ 86400 * 365, '/');
        setcookie("cur_uname", $name, $timestamp+86400 * 365, '/');
        setcookie("cur_ucode", $db_ucode, $timestamp+86400 * 365, '/');
        header('Location: /');
        exit;
    }
}

// 页面变量
$title = '注册 - '.$options['name'];

$pagefile = ROOT . '/templates/default/'.$tpl.'sigin_login.php';

include_once(ROOT . '/templates/default/'.$tpl.'layout.php');

?>
