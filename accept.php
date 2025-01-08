<?php
include("structure.php");
$conn = new mysqli("localhost", "root", "Scp90706!", "user_information", 3306);
if ($conn->connect_error) {
    die('连接失败：' . $conn->connect_error);
}
$stmt=$conn->prepare("SELECT * FROM communication WHERE time >=?");
$stmt->bind_param("i",$_SESSION['time']);
$stmt->execute();
$result=$stmt->get_result();
//判断用户有没有发送过消息，没发送过就把$_SESSION['text'] = [];初始化
if (!isset($_SESSION['text'])) {
    $_SESSION['text'] = [];
}
// 提取结果并保存到会话变量
while ($row = $result->fetch_assoc()) {
    $_SESSION['text'][] = $row['text'];
}
$_SESSION['time']=time();
?>
