<?php
session_start();
include("send.php");
include("accept.php");
// 检查用户是否已登录
if (!isset($_SESSION['username'])) {
    echo "<script>alert('请先登录！');window.location.href='http://121.41.64.138:81/log-in.php';</script>";
} else {}
// 初始化消息数组
if (!isset($_SESSION['messages'])) {
    $_SESSION['messages'] = [];
}
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/structure.css">
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

    <div id="main">
        <h2>聊天页面</h2>
        <div id="messages">
            <?php foreach ($_SESSION['messages'] as $msg): ?>
                <div class="message"><?php echo $msg; ?></div>
            <?php endforeach; ?>
        </div>

        <form action="" method="post" onsubmit="scrollToBottom();">
            <input type="text" id="communication" name="message" placeholder="请输入内容..." required>
            <input type="submit" value="发送">
        </form>
        <form action="" method="get">
            <input type="submit" value="刷新">
        </form>
    </div>

</body>

</html>