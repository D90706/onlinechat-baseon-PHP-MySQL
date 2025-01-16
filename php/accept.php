<?php
session_start();
$conn = new mysqli("localhost", "root", "Scp90706!", "user_information", 3306);
if ($conn->connect_error) {
    die('连接失败：' . $conn->connect_error);
}
$stmt = $conn->prepare("SELECT username, text FROM communication WHERE time >= ? &&username!=? ");
$stmt->bind_param("is", $_SESSION['time'], $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();

$messages = []; // 用于存储消息
while ($row = $result->fetch_assoc()) {
    // 创建一个新的消息对象
    $messageObject = (object) [
        'username' => $row['username'], // 数据库中应包含用户名字段
        'text' => $row['text']           // 消息内容
    ];
    $messages[] = $messageObject; // 将消息对象添加到消息数组
}
$_SESSION['messages'] = array_merge($_SESSION['messages'], $messages); // 合并新消息到会话消息数组中
echo json_encode($_SESSION['messages']); // 返回最新的消息数组
$_SESSION['time'] = time();

exit();

?>