<?php
session_start();
$conn = new mysqli("localhost", "root", "Scp90706!", "user_information", 3306);

if ($conn->connect_error) {
    die('连接失败：' . $conn->connect_error);
}

if (isset($_POST['message'])) {
    $text = $_POST['message'];
    $username = $_SESSION['username'];
    $ip = $_SERVER["REMOTE_ADDR"];
    $time = time();

    // 插入数据库
    $stmt = $conn->prepare("INSERT INTO communication(time, ip, username, text) VALUES(?, ?, ?, ?)");
    $stmt->bind_param("isss", $time, $ip, $username, $text);
    $stmt->execute();
    
    // 将消息对象添加到会话消息数组中
    $_SESSION['messages'][] = (object)[
        'username' => htmlspecialchars($username),
        'text' => htmlspecialchars($text)
    ];

    // 返回当前会话的所有消息
    echo json_encode($_SESSION['messages']); // 返回最新的消息数组
    exit();
}

$conn->close();
?>
