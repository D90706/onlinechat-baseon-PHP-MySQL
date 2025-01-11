window.onload = function () {
    //获取表单元素
    const username = document.getElementById('username');
    const username_error = document.getElementById('username_error');
    const password = document.getElementById('password');
    const password_error = document.getElementById('password_error');
    const repassword = document.getElementById('repassword');
    const repassword_error = document.getElementById('repassword_error');
    const submit = document.querySelector("input[type='submit']");
    //定义正则表达式
    function hasSpecialCharacters(input) {
        // 定义一个正则表达式，匹配特殊字符
        const specialCharacterRegex  = /^[a-zA-Z0-9\u4e00-\u9fa5]+$/; // 只允许字母、数字和汉字
        return specialCharacterRegex.test(input); // 返回 true 表示包含特殊字符，false 表示不包含
    }
    //表单验证
    submit.addEventListener('click', function () {
        let check = true; // 默认值设置为true，表示通过

        // 检查表单非空
        if (username.value.length === 0 || password.value.length === 0 || repassword.value.length === 0) {
            event.preventDefault(); 
            check = false;
            username_error.innerHTML = "Please fill in all the options.";
            //alert("Please fill in all the options.");
            return false; 
        }
        else{
            username_error.innerHTML = "";
        }
        
        // 特殊字符验证
        if (hasSpecialCharacters(username.value)&&hasSpecialCharacters(password.value)){ 
           
            username_error.innerHTML = "";
            password_error.innerHTML = ""; 
           
        }else{
             event.preventDefault(); 
            check = false;
            username_error.innerHTML = "Username mustn't contain special characters";
            password_error.innerHTML = "Password mustn't contain special characters";
            //alert("Username must not contain special characters. Password must not contain special characters.");
            return false; 
        }
        
        // 检查用户名长度
        if (username.value.length > 20||username.value.length < 1) {
            event.preventDefault(); 
            check = false;
            username_error.innerHTML = "Username must be 1~20characters.";
            //alert("Username must be between 1 and 20 characters.");
            return false; 
        }else{
            username_error.innerHTML = "";
        }
        
        // 检查密码长度
        if (password.value.length < 6 || password.value.length > 10) {
            event.preventDefault(); 
            check = false;
            password_error.innerHTML = "Password must be 6~10characters.";
            //alert("Password must be between 6 and 10 characters.");
            return false; 
        }else{
            password_error.innerHTML = "";
        }
        
        // 检查密码是否匹配
        if (password.value !== repassword.value) {
           event.preventDefault(); 
            check = false;
            repassword_error.innerHTML = "Repasswords do not match.";
           // alert("Repasswords do not match.");
           return false; 
        }else{
            repassword_error.innerHTML = "";
        }
        
        // 最终检查
        if (check) {
            return true; // 所有检查通过
        } else {
            event.preventDefault(); // 阻止表单提交
            alert("Form submission is blocked"); // 提示错误信息
            return false; // 返回false指示验证失败
        }
        
    });
}      