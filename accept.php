<?php
// 刷新消息
if (empty($_GET)) {
    // echo"成功触发get请求";
    // echo "<script>alert('刷新成功！');</script>";
    $conn = new mysqli("localhost", "root", "", "user_information", 3306);
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
    $_SESSION['time'] = time();
}

?>

