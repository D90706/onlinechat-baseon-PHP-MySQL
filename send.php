<?php
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




?>
