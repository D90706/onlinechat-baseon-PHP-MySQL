<?php
session_start();

// 检查用户是否已登录
if (!isset($_SESSION['username'])) {
    echo "<script>alert('请先登录！');window.location.href='log-in.php';</script>";
} else {
    // $_SESSION['time'] = time();
    // echo"$_SESSION['time']";
//    echo "当前会话时间: {$_SESSION['time']}";
}
// 初始化消息数组
if (!isset($_SESSION['messages'])) {
    $_SESSION['messages'] = [];
}
// 发送消息处理
if (!empty($_POST)) {
    //链接user_information数据库
    // echo "<script>alert('发送成功！');</script>";
    $conn = new mysqli("localhost", "root", "Scp90706!", "user_information", 3306);
    if ($conn->connect_error) {
        die('连接失败：' . $conn->connect_error);
    }
    // 获取表单内的数据
    $text = trim($_POST['message']); // 去除两端空白
    $username = $_SESSION['username'];
    $ip = $_SERVER["REMOTE_ADDR"];
    $time = time();

    // 将数据插入数据库
    $stmt = $conn->prepare("INSERT INTO communication(time,ip,username,text) VALUES(?,?,?,?)");
    $stmt->bind_param("isss", $time, $ip, $username, $text);
    $stmt->execute();

    // 添加到会话消息数组
    if ($text) {
        $_SESSION['messages'][] = htmlspecialchars($text); // 统一使用 'messages'
    }

    $_SESSION['time'] = time();
    // echo "当前会话时间: {$_SESSION['time']}";
}

// 刷新消息
if (empty($_GET)) {
    // echo"成功触发get请求";
    // echo "<script>alert('刷新成功！');</script>";
    $conn = new mysqli("localhost", "root", "Scp90706!", "user_information", 3306);
    if ($conn->connect_error) {
        die('连接失败：' . $conn->connect_error);
    }
    $stmt = $conn->prepare("SELECT * FROM communication WHERE time > ?");
    $stmt->bind_param("i", $_SESSION['time']);
    $stmt->execute();
    $result = $stmt->get_result();

    $messages = []; // 用于存储消息
    while ($row = $result->fetch_assoc()) {
        $_SESSION['messages'][] = $row['text']; // 将消息添加到会话
        $messages[] = $row['text']; // 额外存储，以便后续使用
    }

    // // 将消息输出到控制台
    // echo "<script>console.log(" . json_encode($messages) . ");</script>";

    $_SESSION['time'] = time();
    // // 调试输出，可以临时使用
    // echo "刷新后会话时间: {$_SESSION['time']}";


}
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>聊天页面</title>
    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: gray;
            font-family: Arial, sans-serif;
        }

        #main {
            width: 60%;
            height: 80%;
            background-color: black;
            border: 2px solid white;
            color: white;
            padding: 20px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
        }

        #messages {
            flex: 1;
            overflow-y: auto;
            padding: 10px;
            margin-bottom: 10px;
        }

        .message {
            margin: 10px 0;
            padding: 15px;
            background-color: #3498db;
            border-radius: 10px;
            max-width: 70%;
            word-wrap: break-word;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        form {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
        }

        input[type="text"] {
            flex: 1;
            padding: 10px;
            margin-right: 10px;
            border: 1px solid #fff;
            border-radius: 5px;
            background-color: #444;
            color: white;
            font-size: 16px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #5dade2;
            color: white;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #3498db;
        }
    </style>
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