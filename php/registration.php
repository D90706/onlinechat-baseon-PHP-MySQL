<?php
include("../html/registration.html");

// 处理表单提交的逻辑
//链接user_information数据库
$conn = new mysqli("localhost", "root", "", "user_information", 3306);
if ($conn->connect_error) {

    die('连接失败：' . $conn->connect_error);
}
//获取表单数据
//判断数据是否为空
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['repassword'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];
    // 使用预处理语句防止 SQL 注入
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");//预处理SQL语句
    $stmt->bind_param("s", $username);//将具体的值与预处理语句中的占位符关联，并指定数据类型，s就是字符串类型的
    $stmt->execute();//执行SQL语句
    $result = $stmt->get_result();//返回SQL语句执行结果
    if ($result->num_rows > 0) {//第五次判断用户名是否存在num_rows是mysqli_result类的属性，表示查询结果的行数，大于0表示用户名已存在
        echo "<script>username_error.innerHTML='The username already exists.  ';</script>";
    } else {//没有查询到用户名，则开始将数据导入数据库
        echo "<script>username_error.innerHTML='';</script>";
        $stmt = $conn->prepare("INSERT INTO users(username,userpassword) VALUES(?,?)");
        $stmt->bind_param("ss", $username, $password);
        if ($stmt->execute()) {//第六次判断是否数据插入成功
            echo "<script>username_error.innerHTML='Registration successful';</script>";
            echo "<script>alert('注册成功！');</script>";
            header("Location:http://localhost/onlinechat-baseon-PHP-MySQL/php/log-in.php");//跳转到登录页面
            exit();
        } else {
            echo "<script>alert('注册失败！');</script>";
            echo "<script>username_error.innerHTML='Registration failed';</script>";
        }
    }
    $stmt->close();//关闭第一次预处理语句
    $conn->close(); // 关闭数据库连接

} else {
}



?>