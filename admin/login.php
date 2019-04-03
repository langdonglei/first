<?php
session_start();
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <?php require_once 'head.php' ?>
    <title>登录</title>
    <style>
        .veri {
            background-repeat: no-repeat;
            background-position: 180px -5px;
        }

        .tm {
            background-image: url("images/a.png");
        }

        .dui {
            background-image: url("images/dui50.png");
        }

        .cuo {
            background-image: url("images/cuo50.png");
        }
    </style>
</head>
<body>
<div class="bg"></div>
<div class="container">
    <div class="line bouncein">
        <div class="xs6 xm4 xs3-move xm4-move">
            <div style="height:150px;"></div>
            <div class="media media-y margin-big-bottom"></div>
            <form action="" method="post">
                <div class="panel loginbox" style="min-height: 450px;">
                    <div class="text-center margin-big padding-big-top">
                        <h1>后台管理中心</h1>
                    </div>
                    <div class="panel-body" style="padding:10px 30px">
                        <!--账号-->
                        <div class="form-group">
                            <div class="field field-icon-right">
                                <input type="text" autofocus maxlength="12" id="user" class="input input-big" name="act"
                                       placeholder="登录账号" data-validate="required:请填写账号"/>
                                <span class="icon icon-user margin-small"></span>
                            </div>
                        </div>
                        <!--密码-->
                        <div class="form-group" style="margin-top: 20px;">
                            <div class="field field-icon-right">
                                <input type="password" maxlength="12" id="pwd" class="input input-big" name="pwd"
                                       placeholder="登录密码"
                                       data-validate="required:请填写密码"/>
                                <span class="icon icon-key margin-small"></span>
                            </div>
                        </div>
                        <!--验证码-->
                        <div class="form-group" style="margin-top: 20px;">
                            <div class="field">
                                <input type="text" maxlength="4" class="input input-big" id="veri" name="veri"
                                       placeholder="填写右侧的验证码"
                                       data-validate="required:请填写右侧的验证码"/>
                                <img src="class/captcha.php" width="100" height="32" class="passcode"
                                     style="height:44px;cursor:pointer;"
                                     onclick="this.src=this.src+'?'+(new Date()).getDate()">
                            </div>
                        </div>
                    </div>
                    <!--登陆-->
                    <div style="padding:30px;">
                        <input type="button" id="loginsb" value="登录"
                               class="button button-block input-block right-align bg-main text-big input-big">
                        <span id="msg" style="color:red; position: relative;top:13px;left: 5px"></span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    var flag = true;
    //清除错误提示
    $('#user,#pwd').keydown(function () {
        flag = true;
        $('#msg').html('');
    });
    //验证码
    var veri = $('#veri');
    veri.addClass('tm veri');
    veri.blur(function () {
        veri.removeClass('dui cuo veri');
        veri.addClass('tm veri');
    });
    veri.on('input focus', function () {
        var me = $(this);
        if (me.val().length == 4) {
            $.ajax({
                url: 'ajax.php',
                type: 'post',
                cache: false,
                async: false,
                data: {
                    veri: me.val()
                },
                dataType: 'text',
                success: function (t) {
                    if (eval(t)) {
                        flag = false;
                        veri.removeClass('cuo veri');
                        veri.addClass('dui veri');
                    } else {
                        flag = true;
                        veri.removeClass('dui veri');
                        veri.addClass('cuo veri');
                    }
                }
            })
        }
    });
    //点击提交
    $("#loginsb").click(function () {
        if ($("#user").val() == '') {
            $("#msg").html('账号不能为空');
        } else if ($('#pwd').val() == '') {
            $('#msg').html('密码不能为空');
        } else if ($('#veri').val() == '') {
            $('#msg').html('验证码不能为空');
        } else if (flag) {
            $('#msg').html('验证码错误');
        } else {
            login();
        }
    });
    //回车提交
    $(window).keydown(function (e) {
        if (e.keyCode == 13) {
            if ($('#user').val() == '') {
                $('#msg').html('账号不能为空');
            } else if ($('#pwd').val() == '') {
                $('#msg').html('密码不能为空');
            } else if ($('#veri').val() == '') {
                $('#msg').html('验证码不能为空');
            } else if (flag) {
                $('#msg').html('验证码错误');
            } else {
                login();
            }
        }
    });
    //提交方法
    function login() {
        $.ajax({
            url: 'ajax.php',
            type: 'post',
            cache: false,
            async: false,
            data: {
                user: $('#user').val(),
                pwd: $('#pwd').val()
            },
            dataType: 'text',
            success: function (t) {
                if (eval(t)) {
                    location.href = 'sys_main.php';
                } else {
                    $('#msg').html('用户名或密码错误');
                }
            }
        })
    }
</script>
</body>
</html>