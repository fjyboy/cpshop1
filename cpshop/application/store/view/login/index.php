<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>商城系统登录</title>

    <link href="/assets/store/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/assets/store/css/beyond.min.css" rel="stylesheet" />

</head>

<body class="page-login-v3">
<div class="login-container">
    <div class="loginbox bg-white">
        <form action="#"  id="login-form">
            <div class="loginbox-title">电商系统登录</div>

            <div class="loginbox-or">
                <div class="or-line"></div>
            </div>
            <div class="loginbox-textbox">
                <input type="text" class="form-control" name="user_name" placeholder="用户名" />
            </div>
            <div class="loginbox-textbox">
                <input type="password" class="form-control" name="password" placeholder="密码" />
            </div>
            <div class="loginbox-submit">
                <input type="submit" class="btn btn-primary btn-block" value="Login">
            </div>
        </form>
    </div>

</div>
</body>
<script src="/assets/store/js/jquery.min.js"></script>
<script src="/assets/layer/layer.js"></script>
<script src="/assets/store/js/jquery.form.min.js"></script>
<script>
    $(function () {
        // 表单提交
        var $form = $('#login-form');
        $form.submit(function () {
            $form.ajaxSubmit({
                type: "post",
                dataType: "json",
                // url: '',
                success: function (result) {
                    if (result.code === 1) {
                        layer.msg(result.msg,
                            {
                                time: 1500, anim: 1
                            },
                            function () {
                                window.location = result.url;
                            });
                        return true;
                    }
                    layer.msg(result.msg, {time: 1500, anim: 6});
                }
            });
            return false;
        });
    });
</script>
</html>