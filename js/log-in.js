
    window.onload = function () {
        //检查是否需要保存cookie
        const remember = document.getElementById("remember");
        //提示信息
        const username_message = document.getElementById("name_message");
        const password_message = document.getElementById("password_message");
        const submit = document.querySelector("input[type='submit']");

        //表单提交事件
        //检查cookie
        const cookies = document.cookie.split("; ");
        cookies.forEach(function (cookie) {
            const [key, value] = cookie.split("=");
            if (key === "username") {
                document.getElementById("username").value = value;
                document.getElementById("remember").checked = true;
                username_message.innerHTML = "";
            } else if (key === "password") {
                document.getElementById("password").value = value;
                password_message.innerHTML = "";
            }
        });
        submit.addEventListener("click", function (event) {
            //保存cookie
            if (remember.checked) {
                const username = document.getElementById("username").value;
                const password = document.getElementById("password").value;
                const date = new Date();
                date.setTime(date.getTime() + (30 * 24 * 60 * 60 * 1000));
                document.cookie = "username=" + username + ";expires=" + date.toGMTString();
                document.cookie = "password=" + password + ";expires=" + date.toGMTString();
            } else {
                document.cookie = "username=;expires=Thu, 01 Jan 1970 00:00:00 UTC";
                document.cookie = "password=;expires=Thu, 01 Jan 1970 00:00:00 UTC";
            }
        });

        
    }
