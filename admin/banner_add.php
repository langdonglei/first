<?php
require_once 'log.php';
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
            <span>添加广告</span>
        </strong>
    </div>
    <div class="body-content">
        <form method="post" class="form-x" action="banner_addX.php" enctype="multipart/form-data">
            <div class="form-group">
                <div class="label">
                    <label>广告名称：</label>
                </div>
                <div class="field">
                    <input type="text" class="input w50" autofocus name="name" data-validate="required:请输入广告名称"/>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>广告图片：</label>
                </div>
                <div class="field">
                    <input type="file" class="" id="image1" name="file">
                    <div class="tips">图片尺寸：1000*500</div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>链接地址：</label>
                </div>
                <div class="field">
                    <input type="text" class="input w50" value="#" name="url" data-validate="required:请输入链接地址"/>
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