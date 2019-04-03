<?php
require_once 'log.php';
require_once '../inc/d.php';
if (isset($_POST['qid4u'])) {
    $d['quali_id'] = $_POST['qid4u'];
    $d['quali_name'] = $_POST['name'];
    $d['quali_url'] = $_POST['url'];
    $d['quali_flag'] = $_POST['flag'];
    updateArrayInnerPK('hw_quali', $d);
    header('location:quali_manager.php');
}
$quali = queryByPID('hw_quali', $_GET['qid']);
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
            <span>修改资质</span>
        </strong>
    </div>
    <div class="body-content">
        <form method="post" class="form-x" action="" enctype="multipart/form-data">
            <input type="hidden" name="uid" value="<?= $quali['quali_id'] ?>">
            <div class="form-group">
                <div class="label">
                    <label>资质名称：</label>
                </div>
                <div class="field">
                    <input type="text" class="input w50" autofocus name="name" data-validate="required:请输入链接地址"
                           value="<?= $quali['quali_name'] ?>"/>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>资质图片：</label>
                </div>
                <div class="field">
                    <input type="file" class="" id="image1" name="file">
                    <div class="tips">图片尺寸：500*500</div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>链接地址：</label>
                </div>
                <div class="field">
                    <input type="text" class="input w50" value="<?= $quali['quali_url'] ?>" name="url"
                           data-validate="required:请输入链接地址"/>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>是否显示：</label>
                </div>
                <div class="field">
                    <label><input type="radio" class="" value="y" name="flag" checked/>显示</label>
                    <label><input type="radio" class="" value="n" name="flag"/>不显示</label>
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