<?php
$message = ""; // 初始化消息变量
// 第一次判断是否是POST请求
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 处理表单提交的逻辑
    //链接user_information数据库
    $conn = new mysqli("localhost", "root", "Scp90706!", "user_information", 3306);
    if ($conn->connect_error) {//第二次判断是否链接成功
        die('连接失败：' . $conn->connect_error);
    }
    // 获取表单提交的用户名和密码
    if (isset($_POST['username']) && isset($_POST['password'])) {//第二次判断是否有数据
        $username = $_POST['username'];//第三次判断数据是否有效
        $password = $_POST['password'];
        // 验证用户名和密码是否正确
        $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {//第五次判断用户名是否存在
            $user = mysqli_fetch_assoc($result);
            if ($password == $user['userpassword']) {//第六次判断密码是否正确
                // 登录成功，跳转到主页,并存储session信息
                session_start();
                $_SESSION['username'] = $username; //存放用户的用户名
                $_SESSION['password'] = $password; //存放用户的密码
                header("Location: http://localhost/chat/structure.php");
                exit();
            } else {
                $message = "密码错误";
            }
        } else {
            $message = "用户名不存在";
        }
    } else {
        $message = "请完整的用户名与密码";
    }

} else {
    $message = "输入完毕后请点击登录按钮，谢谢配合";
}

?>

<!--------------------- html ---------------------->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登录页面</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        h2 {
            text-align: center;
            color: #333333;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            color: #555555;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #cccccc;
            border-radius: 5px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #5cb85c;
            /* 聚焦时边框颜色变化 */
            outline: none;
            /* 去掉默认的轮廓 */
        }

        input[type="checkbox"] {
            margin-right: 5px;
        }

        input[type="submit"] {
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 12px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            transition: background-color 0.3s;
            /* 添加过渡效果 */
        }

        input[type="submit"]:hover {
            background-color: #4cae4c;
            /* 鼠标悬停时变化 */
        }

        .message {
            color: #d9534f;
            /* 错误信息的颜色 */
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>登录</h2>
        <?php if (!empty($message)): ?>
            <div class="message">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <form action="" method="post">
            <label for="username">用户名</label>
            <input type="text" id="username" name="username" required><br>
            <label for="password">密码</label>
            <input type="password" id="password" name="password" required><br>
            <label for="remember-me">
                <input type="checkbox" id="remember-me" name="remember-me"> 记住密码？
            </label><br><br>
            <label for="registration"><a href="registration.php">未有账号？点此注册</a></label>
            <br><br>
            <input type="submit" value="登录">
        </form>
    </div>
</body>
</html>