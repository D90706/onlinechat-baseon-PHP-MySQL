<?php
// 发送消息处理
if (!empty($_POST)) {
    //链接user_information数据库
    // echo "<script>alert('发送成功！');</script>";
    $conn = new mysqli("localhost", "root", "", "user_information", 3306);
    if ($conn->connect_error) {
        die('连接失败：' . $conn->connect_error);
    }

    // 获取表单内的数据
    $text = $_POST['message'];
    $username = $_SESSION['username'];
    $ip = $_SERVER["REMOTE_ADDR"];
    $time = time();

    // 将数据插入数据库
    $stmt = $conn->prepare("INSERT INTO communication(time,ip,username,text) VALUES(?,?,?,?)");
    $stmt->bind_param("isss", $time, $ip, $username, $text);
    $stmt->execute();

    // 添加到会话消息数组
    if ($text) {
        // 创建一个新对象以存储消息信息
        $messageObject = (object) [
            'username' => $_SESSION['username'], // 当前用户名
            'text' => htmlspecialchars($text)    // 消息内容，进行 HTML 实体转换以防止 XSS
        ];

        // 将消息对象添加到会话消息数组中
        $_SESSION['messages'][] = $messageObject;
    }

    $_SESSION['time'] = time();
    // echo "当前会话时间: {$_SESSION['time']}";
}
?>