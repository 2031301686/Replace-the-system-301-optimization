<?php
//载入配置文件
$config = require_once "./config.php";


//重定向
$conditionstxt = '/conditions.txt';
// 读取自定义txt文件中的条件
$conditions = file($_SERVER['DOCUMENT_ROOT'] . $conditionstxt, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// 获取访问的页面
$requestedPageUrl = $_SERVER['REQUEST_URI'];
$parsedUrl = parse_url($requestedPageUrl);
$requestedPage = $parsedUrl['path']; // 获取URL路径部分

//UA检测
$UA = $_SERVER['HTTP_USER_AGENT'];



// 遍历条件，查找匹配的重定向规则
foreach ($conditions as $condition) {
  list($from, $to) = explode(' ', $condition);
  if ($requestedPage === $from) {
    $btz = 1;
    //新地址
    $url = $config['scheme'] . $config['domain'] . $to;
    $btntxt = $config['btntxt1'];
    $content = $config['content'];
    //蜘蛛301跳转
    foreach ($config['spider'] as $value) {
        if (stripos($UA, $value) !== false) {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: $url");
            return;
        }
    }
    break;
  }else {
    $btz = 0;
    $url = $config['zzy'];
    $urlx = $config['scheme'] . $config['domain'];
    $btntxt = $config['zzytxt'];
    $content = $config['content1'];
    //蜘蛛301跳转
    foreach ($config['spider'] as $value) {
        if (stripos($UA, $value) !== false) {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: $urlx");
            return;
        }
    }
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
                        <?php echo $content ?>
                    </div>
                    <div class="mdui-container">
                        <div class="mdui-progress">
                            <div class="mdui-progress-determinate" id="djs"></div>
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
var btz = <?php echo $btz ?>; // 获取php中的变量$btz
if (btz === 1) { // 如果$btz等于1
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
}
</script>
</body>
