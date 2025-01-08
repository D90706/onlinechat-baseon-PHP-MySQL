<?php
//include("structure.php");
if (!empty($_POST)) {
    //链接user_information数据库
    $conn = new mysqli("localhost", "root", "Scp90706!", "user_information", 3306);
    if ($conn->connect_error) {
        die('连接失败：' . $conn->connect_error);
    }
    //获取表单内的数据
    $text = $_POST['message'];
    $username = $_SESSION['username'];
    $ip = $_SERVER["REMOTE_ADDR"];
    $time = time();
    //将数据插入数据库
    // 使用预处理语句防止 SQL 注入
    $stmt = $conn->prepare("INSERT INTO communication(time,ip,username,text) VALUES(?,?,?,?)");//预处理SQL语句
    $stmt->bind_param("isss", $time, $ip, $username, $text);//将具体的值与预处理语句中的占位符关联，并指定数据类型，s就是字符串类型的
    $stmt->execute();//执行SQL语句  
    $text = htmlspecialchars($_POST['message']);
    if ($text) {
        $_SESSION['massage'][] = $text; // 添加到会话消息数组
    }
    $_SESSION['time']=time();

} 
if(!empty($_GET)){
    $stmt=$conn->prepare("SELECT * FROM communication WHERE time >=?");
$stmt->bind_param("i",$_SESSION['time']);
$stmt->execute();
$result=$stmt->get_result();
// 提取结果并保存到会话变量
while ($row = $result->fetch_assoc()) {
    $_SESSION['massage'][] = $row['text'];
}
$_SESSION['time']=time();
}
?>