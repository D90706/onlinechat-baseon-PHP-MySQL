<?php
session_start();
if($_SESSION['username']){
    // 检查是否已经弹出过警告
    if (!isset($_SESSION['alert_shown'])) {
        echo "<script>alert('欢迎回来！" . $_SESSION['username'] . "');</script>";
        $_SESSION['alert_shown'] = true; // 设置标记
    }
}else{
echo"<script>alert('请先登录！');window.location.href='log-in.php';</script>";
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>页面基本框架</title>
    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: gray; /* 保留背景颜色为灰色 */
        }

        #main {
            width: 60%; /* 左右边框距边界20%，总宽度为60% */
            height: 60%; /* 上下边框距边界20%，总高度为60% */
            background-color: black; /* 黑色背景 */
            border: 2px solid white; /* 边框颜色为白色 */
            color: white; /* 文本颜色为白色 */
            font-family: Arial, sans-serif; /* 改为现代字体 */
            padding: 20px; /* 增加内边距 */
            box-sizing: border-box; /* 包含边框和内边距 */
            overflow: auto;
            overflow-y: scroll;
            display: flex;  
            flex-direction: column;  
            justify-content: flex-end;  
        }

        form {
            display: flex;
            justify-content: space-between; /* 使标签和输入框保持一定的间距 */
            align-items: center; /* 垂直居中对齐 */
            margin-top: auto; /* 确保位于底部 */
        }

        h2 {
            text-align: center; 
            margin-bottom: 20px; /* 添加底部边距 */
        }

        #communication {
            width: 70%; /* 输入框宽度 */
            padding: 10px; /* 内部填充 */
            border: 1px solid #fff; /* 边框颜色为白色 */
            border-radius: 5px; /* 圆角效果 */
            background-color: #444; /* 输入框背景颜色 */
            color: white; /* 输入框文字颜色 */
        }

        #communication:focus {
            outline: none; /* 去掉默认的轮廓 */
            border-color: #5dade2; /* 聚焦时的边框颜色 */
        }

        label {
            width: 15%; /* 标签宽度 */
            color: white; /* 标签文字颜色 */
        }

        #submit {
            width: 15%; /* 按钮宽度 */
            padding: 10px; /* 内部填充 */
            border: none; /* 无边框 */
            border-radius: 5px; /* 圆角效果 */
            background-color: #5dade2; /* 按钮背景颜色 */
            color: white; /* 按钮文字颜色 */
            cursor: pointer; /* 鼠标指针样式 */
            transition: background-color 0.3s; /* 背景颜色过渡效果 */
        }

        #submit:hover {
            background-color: #3498db; /* 鼠标悬停时的背景颜色 */
        }

    </style>
</head>
<body>

<div id="main">
  <h2>页面基本框架</h2>
    <form action="send.php" method="post">
        <label for="communication">请输入内容:</label>
        <input type="text" id="communication" name="communication"> <!-- 改为 text 类型 -->
        <input type="submit" id="submit" value="发送">
    </form>
</div>

</body>
</html>
