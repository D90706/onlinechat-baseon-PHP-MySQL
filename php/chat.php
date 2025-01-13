<?php
session_start(); // 启动会话

// 检查用户是否已登录
if (!isset($_SESSION['username'])) {
    echo "<script>alert('请先登录！');window.location.href='log-in.php';</script>";
    exit(); // 如果未登录，终止执行
}

// 初始化消息
if (!isset($_SESSION['messages'])) {
    $_SESSION['messages'] = []; // 如果没有消息，则初始化为一个空数组
}
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/chat.css" />
    <link rel="icon" href="../img/chat_title.png" type="image/png">
    <title>聊天页面</title>
</head>

<body>

    <div id="main">
        <h2>聊天页面</h2>
        <div id="messages">
            <!-- 遍历会话中的消息并显示 -->
            <?php foreach ($_SESSION['messages'] as $msg): ?>
                <div class="message">
                    <strong><?php echo htmlspecialchars($msg->username); ?></strong>: <?php echo htmlspecialchars($msg->text); ?>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- 消息输入表单 -->
        <form action="" method="post" onsubmit="scrollToBottom();">
            <input type="text" id="message" name="message" placeholder="请输入内容..." required>
            <input type="button" value="发送" id="send" name="send">
        </form>
    </div>

    <script src="../js/jquery-3.7.1.js"></script>
    <script>
        let send = document.getElementById("send"); // 获取发送按钮

        // 将消息框滚动到底部
        function scrollToBottom() {
            const messagesDiv = document.getElementById("messages");
            messagesDiv.scrollTop = messagesDiv.scrollHeight; // 滚动到底部，以便显示最新消息
        }

        // 页面加载时滚动到底部
        window.onload = function () {
            scrollToBottom(); 
        };

        // 点击发送按钮时执行
        send.addEventListener("click", function () {
            let message = document.getElementById("message"); // 获取输入框内容
            $.post("send.php", { message: message.value }, function (data) {
                console.log(data); // 输出服务器返回的数据

                // 更新消息列表
                updateMessageList(data);
                message.value = ''; // 清空输入框
                scrollToBottom(); // 发送后滚动到底部
            }, 'json');
        });

        // 更新消息列表函数
        function updateMessageList(messages) {
            const messagesDiv = document.getElementById("messages");
            messagesDiv.innerHTML = ''; // 清空现有消息
            messages.forEach(msg => {
                const msgDiv = document.createElement('div'); // 创建新的消息元素
                msgDiv.className = 'message';
                msgDiv.innerHTML = `<strong>${msg.username}</strong>: ${msg.text}`; // 设置消息内容
                messagesDiv.appendChild(msgDiv); // 将新消息添加到消息列表中
            });
        }
        // 定时刷新消息列表
        setInterval(function () {
            $.post("accept.php", function (data) {
                //console.log(data); // 输出服务器返回的数据
                updateMessageList(data); // 更新消息列表
            }, 'json');
        }, 1500);
    </script>

</body>
</html>

