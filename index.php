<?php
//载入配置文件
$config = require_once "./config.php";

//UA检测
$UA = $_SERVER['HTTP_USER_AGENT'];

//新地址
$url = $config['scheme'] . $config['domain'];
$btntxt = $config['btntxt2'];
//蜘蛛301跳转
foreach ($config['spider'] as $value) {
    if (stripos($UA, $value) !== false) {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: $url");
        return;
    }
}
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <title><?= $config['title'] ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="stylesheet" href="https://unpkg.com/mdui@1.0.2/dist/css/mdui.min.css" />
</head>
<body class="mdui-theme-primary-indigo mdui-theme-accent-pink">
<style>
.zdy-card {
        width: 360px;
        height: auto;/*500px*/
        margin: 10px auto;
    }
</style>

<div class="mdui-container">
    <div class="mdui-row">
        <div class="mdui-col-sm-6 mdui-col-md-12">
            <div class="mdui-card zdy-card">
                <div class="mdui-card-media">
                    <img src="<?= $config['img'] ?>" />
                </div>
                <div class="mdui-card-actions mdui-card-actions-stacked">
                    <div class="mdui-card-primary-title">
                        <?= $config['title'] ?>
                    </div>
                    <div class="mdui-card-content">
                        <?= $config['content'] ?>
                    </div>
                    <div class="mdui-container">
                        <div class="mdui-progress">
                            <div class="mdui-progress-determinate" id="djs">
                            </div>
                        </div>
                    </div>
                    <div class="mdui-container mdui-p-t-3">
                        <a href="<?php echo $url?>" class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent"><?php echo $btntxt?></a>
                    </div>
                    <hr>
                    <center>
                    <a target="_blank" href="<?= $config['icpurl'] ?>">"<?= $config['icp'] ?>"</a>
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">  
// 获取进度条元素
var progress = document.getElementById("djs");
var countDown = 100; // 初始化倒计时
function updateElement() {
    countDown--; // 每次减少1
    progress.style.width = (100 - countDown) + "%"; // 根据倒计时更新进度条宽度
    if (countDown == 0) { // 如果倒计时结束
        clearInterval(interval); // 清除定时器
        window.location.replace("<?php echo $url?>"); // 跳转到指定网址
    }
}

updateElement(); // 初始调用一次
var interval = setInterval(function() {
    updateElement(); // 每50毫秒调用一次updateElement函数
},50);
</script>
</body>
