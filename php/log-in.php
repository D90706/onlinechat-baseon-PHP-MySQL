<?php
include("../html/index.html");
    // 处理表单提交的逻辑
    //链接user_information数据库
    $conn = new mysqli("localhost", "root", "Scp90706!", "user_information", 3306);
    if ($conn->connect_error) {//是否链接成功
        die('连接失败：' . $conn->connect_error);
    }
    // 获取表单提交的用户名和密码
    if (isset($_POST['username']) && isset($_POST['password'])) {//是否有数据
        $username = $_POST['username'];
        $password = $_POST['password'];
        // 验证用户名和密码是否正确
        $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {//判断用户名是否存在
            $user = mysqli_fetch_assoc($result);
            if ($password == $user['userpassword']) {//判断密码是否正确
                // 登录成功，跳转到主页,并存储session信息
                session_start();
                $_SESSION['username'] = $username; //存放用户的用户名
                //准备跳转
                header("Location: http://localhost/onlinechat-baseon-PHP-MySQL/php/chat.php");
                exit();
            } else {
                echo"<script> alert('password is not correct');</script>";
                exit();
            }
        } else {
            echo"<script> alert('username is not exist');</script>";
            exit();
        }
    } else {

    }