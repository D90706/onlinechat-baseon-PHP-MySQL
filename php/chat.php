<?php
session_start();
include("send.php");
include("accept.php");
// 检查用户是否已登录
if (!isset($_SESSION['username'])) {
    echo "<script>alert('请先登录！');window.location.href='log-in.php';</script>";
} else {
}
// 初始化消息
if (!isset($_SESSION['messages'])) {
    $_SESSION['messages'] = []; // 初始化为一个空数组
}


?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/chat_title.png" type="image/png">
   <link rel="stylesheet" href="../css/chat.css">
    <title>聊天页面</title>
    <script>
        function scrollToBottom() {
            const messagesDiv = document.getElementById("messages");
            messagesDiv.scrollTop = messagesDiv.scrollHeight; // 滚动到底部
        }
        window.onload = function () {
            scrollToBottom(); // 加载时滚动到底部
        };

    </script>
</head>

<body>

    <div class="container" id="main">
        <h2>聊天页面</h2>
        <form action="" method="post" onsubmit="scrollToBottom();">
        <div class="messages mbg32" id="messages">
            <?php foreach ($_SESSION['messages'] as $msg): ?>
                <div class="message">
                    <strong><?php echo $msg->username; ?></strong>: <?php echo $msg->text; ?>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="input-container" style="display: flex; align-items: center;">
            <div class="input-box" style="flex: 1;">
                <input type="text" id="communication" name="message" placeholder="请输入内容..." required style="width: 100%;">
                <i></i>
            </div>
            <input class="submit-btn" type="submit" value="发送">  
        </div> 
            <form action="" method="get" id="refreshForm">
            <input type="hidden"  value="刷新">  
        </form> 
        </form>  
        
    </div>

</body>
<script src="../js/jquery-3.7.1.js"></script>
<script>
  setInterval(function () {
        document.getElementById("refreshForm").submit(); // 提交表单
        console.log("定时提交表单");
    }, 10000);
</script>

</html>