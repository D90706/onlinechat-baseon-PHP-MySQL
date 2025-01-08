<?php
session_start();

if ($_SESSION['username']) {
    // 检查是否已经弹出过警告
    if (!isset($_SESSION['alert_shown'])) {
        echo "<script>alert('欢迎回来！" . $_SESSION['username'] . "');</script>";
        $_SESSION['alert_shown'] = true; // 设置标记
    }
} else {
    echo "<script>alert('请先登录！');window.location.href='log-in.php';</script>";
}

// 初始化消息数组
if (!isset($_SESSION['messages'])) {
    $_SESSION['messages'] = [];
}

// 处理表单提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = htmlspecialchars($_POST['message']);
    if ($message) {
        $_SESSION['messages'][] = $message; // 添加到会话消息数组
    }
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
        }
        #main {
            width: 60%;
            height: 80%;
            background-color: black;
            border: 2px solid white;
            color: white;
            font-family: Arial, sans-serif;
            padding: 20px;
            box-sizing: border-box;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
        }
        .message {
            margin: 5px 0;
            padding: 10px;
            background-color: #3498db;
            border-radius: 5px;
        }
        form {
            display: flex;
            justify-content: space-between;
        }
        input[type="text"] {
            flex: 1;
            padding: 10px;
            margin-right: 10px;
            border: 1px solid #fff;
            border-radius: 5px;
            background-color: #444;
            color: white;
        }
        input[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #5dade2;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #3498db;
        }
    </style>
</head>
<body>

<div id="main">
    <h2>聊天页面</h2>
    <!-- 显示消息 -->
    <div id="messages">
        <?php foreach ($_SESSION['messages'] as $msg): ?>
            <div class="message"><?php echo $msg; ?></div>
        <?php endforeach; ?>
    </div>
    
    <!-- 表单输入 -->
    <form action="" method="post">
        <input type="text"  id="communication" name="message" placeholder="请输入内容..." required>
        <input type="submit" value="发送">
    </form>
</div>

</body>
</html>
