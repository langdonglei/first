<?php
require_once 'log.php';
require_once '../inc/d.php';
if (isset($_POST['pwd'])) {
    if (trim($_POST['npwd']) != trim($_POST['cnpwd'])) {
        alert('两次密码不一致');
    } elseif (trim($_POST['npwd']) == trim($_POST['pwd'])) {
        alert('新旧密码不能一致');
    } else {
        $user = $_SESSION['admin'];
        $mm = mm($_POST['pwd']);
        //验证旧密码是否正确
        if (exist('hw_admin', "admin_act='$user' and admin_pwd='$mm'")) {
            $d['admin_pwd'] = mm($_POST['npwd']);
            updateArray('hw_admin', $d, "admin_act='$user'");
            alert('密码修改完成');
        } else {
            alert('原密码错误，无法修改');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <?php require_once 'head.php' ?>
</head>
<body>
<div class="panel admin-panel">
    <div class="panel-head" id="add">
        <strong>
            <span class="icon-pencil-square-o"></span>
            <span>修改当前账号密码</span>
        </strong>
    </div>
    <div class="body-content">
        <form method="post" class="form-x" action="">
            <div class="form-group">
                <div class="label">
                    <label>当前管理员：</label>
                </div>
                <div class="field">
                    <input type="text" class="input w50" name="act" disabled value="<?= $_SESSION['admin'] ?>"/>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>旧密码：</label>
                </div>
                <div class="field">
                    <input type="text" class="input w50" name="pwd" data-validate="required:请输入旧密码"/>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>新密码：</label>
                </div>
                <div class="field">
                    <input type="text" class="input w50" name="npwd" data-validate="required:请输入新密码"/>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>确认新密码：</label>
                </div>
                <div class="field">
                    <input type="text" class="input w50" name="cnpwd" data-validate="required:请确认新密码"/>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label></label>
                </div>
                <div class="field">
                    <button class="button bg-main icon-check-square-o" type="submit"> 提交</button>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>