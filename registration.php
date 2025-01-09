<?php
//初始化提示语
$message = "";

//第一次判断是否是POST请求，是否通过表单提交数据
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 处理表单提交的逻辑
    //链接user_information数据库
    $conn = new mysqli("localhost", "root", "Scp90706!", "user_information", 3306);
    if ($conn->connect_error) {
        die('连接失败：' . $conn->connect_error);
    }
    //获取表单数据
    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['repassword'])) {//第二次判断是否有数据
        $username = $_POST['username'];//第三次判断数据是否有效
        $password = $_POST['password'];
        $repassword = $_POST['repassword'];
        if ($password !== $repassword) {//第四次判断两次密码是否一致
            $message = "两次输入的密码不一致";
        } else {
            // 使用预处理语句防止 SQL 注入
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");//预处理SQL语句
            $stmt->bind_param("s", $username);//将具体的值与预处理语句中的占位符关联，并指定数据类型，s就是字符串类型的
            $stmt->execute();//执行SQL语句
            $result = $stmt->get_result();//返回SQL语句执行结果
            if ($result->num_rows > 0) {//第五次判断用户名是否存在num_rows是mysqli_result类的属性，表示查询结果的行数，大于0表示用户名已存在
                $message = "用户名已存在";
            } else {//没有查询到用户名，则开始将数据导入数据库
                $stmt = $conn->prepare("INSERT INTO users(username,userpassword) VALUES(?,?)");
                $stmt->bind_param("ss", $username, vars: $password);
                if ($stmt->execute()) {//第六次判断是否数据插入成功
                    $message = "注册成功";
                    echo"<script>alert('注册成功！');</script>";
                    header("Location: http://localhost/chat/log-in.php");//跳转到登录页面
                    exit();
                } else {
                    $message = "注册失败";
                }
            }
            $stmt->close();//关闭第一次预处理语句
        }
    } else {
        $message = "请填写所有必填项";

    }
    $conn->close(); // 关闭数据库连接
} else {
    $message = "请填写数据后点击注册按钮，谢谢配合";
}
?>

<!-------------------------html代码 --------------------------------------------------->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/registration.css">
    <title>注册页面</title>

</head>

<body>
    <div class="container">
        <h2>注册</h2>
        <?php if (!empty($message)): ?>
        <div class="message">
            <?php echo $message; ?>
        </div>
        <span?php endif; ?>
        <form method="post" action="">
            <label for="username">用户名:</label><span id="username-error"></span>
            <input type="text" id="username" name="username" required>
            <label for="password">密码:</label><span id="password-error"></span>
            <input type="password" id="password" name="password" required>
            <label for="repassword">确认密码:</label><span id="repassword-error"></span>
            <input type="password" id="repassword" name="repassword" required>
            <label for="log-in"><a href="log-in.php">已有账号？点此登录</a></label>
            <input type="submit" value="提交">
        </form>
    </div>
</body>
<script>
    // 表单验证
    
</script>
</html>