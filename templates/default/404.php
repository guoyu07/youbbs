<?php
if (!defined('IN_SAESPOT')) {
    $dir_arr = explode(DIRECTORY_SEPARATOR, dirname(__FILE__));
    array_pop(array_pop($dir_arr));
    define('ROOT', implode(DIRECTORY_SEPARATOR, $dir_arr));
    include_once(ROOT . '/error/403.php');
    exit;
};

switch ($error_code) {
    case 4041:
        $error_docs = '用户未找到';
        $tips = '<p>你试图查看的用户不存在，有两种可能：</p><ul><li>你输入了一个确实不存在的用户 ID</li><li>该用户已被 ban</li></ul>';
        break;
    case 4042:
        $error_docs = '节点未找到';
        $tips = '<p>你试图查看的节点不存在，有两种可能：</p><ul><li>你输入了一个确实不存在的节点 ID</li><li>该节点目前位于一个 invisible 位面</li></ul>';
        break;
    case 4043:
        $error_docs = '主题未找到';
        $tips = '<p>你试图查看的节点不存在，有两种可能：</p><ul><li>你输入了一个确实不存在的主题 ID</li><li>该主题目前位于一个 invisible 位面</li></ul>';
        break;
    case 4044:
        $error_docs = '评论未找到';
        $tips = '<p>你试图编辑的评论不存在。</p>';
        break;
    case 4045:
        $error_docs = '用户未找到';
        $tips = '<p>你试图编辑的用户不存在。</p>';
        break;
    case 4046:
        $error_docs = '节点未找到';
        $tips = '<p>你试图编辑的节点不存在。</p>';
        break;
    case 4047:
        $error_docs = '主题未找到';
        $tips = '<p>你试图编辑的主题不存在。</p>';
        break;
    default:
        $error_docs = '404 Not Found';
        $tips = '<p>呀！找不到了。</p>';
}

echo '
<div class="title">
    <div class="float-left fs14">
        <a href="/">', $options['name'], '</a> › ', $error_docs, '
    </div>
    <div class="c"></div>
</div>

<div class="main-box not-found">
    ', $tips, '
</div>';

?>