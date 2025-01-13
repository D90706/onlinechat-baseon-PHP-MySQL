<?php
// 刷新消息
if (empty($_GET)) {
    // echo"成功触发get请求";
    // echo "<script>alert('刷新成功！');</script>";
    $conn = new mysqli("localhost", "root", "Scp90706!", "user_information", 3306);
    if ($conn->connect_error) {
        die('连接失败：' . $conn->connect_error);
    }
    $stmt = $conn->prepare("SELECT username, text FROM communication WHERE time > ?");
    $stmt->bind_param("i", $_SESSION['time']);
    $stmt->execute();
    $result = $stmt->get_result();

    $messages = []; // 用于存储消息
    while ($row = $result->fetch_assoc()) {
        // 创建一个新的消息对象
        $messageObject = (object) [
            'username' => $row['username'], // 数据库中应包含用户名字段
            'text' => $row['text']           // 消息内容
        ];
        
        // 将消息对象添加到会话消息数组
        $_SESSION['messages'][] = $messageObject; // 存储消息对象
        
        // 额外存储以便后续使用（可选）
        //$messages[] = $messageObject; // 可以直接存储对象而不是文本
    }
    $_SESSION['time'] = time();
}

?>