<?php
require_once 'log.php';
require_once '../inc/d.php';
if (isset($_POST['act'])) {
    $user = $_POST['act'];
    $d['admin_act'] = $_POST['act'];
    $d['admin_pwd'] = mm($_POST['pwd']);
    if (exist('hw_admin', "admin_act='$user'")) {
        alert('账户名已经存在');
    } else {
        if ($_POST['pwd'] == $_POST['cpwd']) {
            saveArray('hw_admin', $d);
            alert('添加成功');
        } else {
            alert('两次密码不一样');
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
            <span>添加管理员</span>
        </strong>
    </div>
    <div class="body-content">
        <form method="post" class="form-x" action="">
            <div class="form-group">
                <div class="label"><label>账号：</label></div>
                <div class="field">
                    <input type="text" class="input w50" autofocus name="act" data-validate="required:请输入账号"/>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label"><label>密码：</label></div>
                <div class="field">
                    <input type="text" class="input w50" name="pwd" data-validate="required:请输入密码"/>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label"><label>确认密码：</label></div>
                <div class="field">
                    <input type="text" class="input w50" name="cpwd" data-validate="required:请确认密码"/>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label"><label></label></div>
                <div class="field">
                    <button class="button bg-main icon-check-square-o" type="submit"> 提交</button>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>