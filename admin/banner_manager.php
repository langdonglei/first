<?php
require_once 'log.php';
?>
<!DOCTYPE html>
<html>
<head>
    <?php require_once 'head.php' ?>
</head>
<body>
<div class="panel admin-panel">
    <div class="panel-head">
        <strong class="icon-reorder">管理广告</strong>
    </div>
    <div class="padding border-bottom">
        <ul class="search" style="padding-left:10px;">
            <li><a class="button border-main icon-plus-square-o" href="banner_add.php">添加广告</a></li>
            <li>搜索：</li>
            <li>
                <input type="text" placeholder="请输入搜索关键字" name="keywords" class="input" style="width:250px; line-height:17px;display:inline-block"/>
                <a href="javascript:void(0)" class="button border-main icon-search" onclick="changesearch()">搜索</a>
            </li>
        </ul>
    </div>
    <table class="table table-hover text-center">
        <tr>
            <th>ID</th>
            <th>广告名称</th>
            <th>广告图片</th>
            <th>链接地址</th>
            <th>是否显示</th>
            <th>操作</th>
        </tr>
        <?php
        require_once '../inc/d.php';
        $banner_s = query('hw_banner');
        foreach ($banner_s as $banner) {
            ?>
            <tr>
                <td>
                    <?= $banner['banner_id'] ?>
                </td>
                <td>
                    <?= $banner['banner_name'] ?>
                </td>
                <td>
                    <img width="50" src="../upload/banner/<?= $banner['banner_img'] ?>">
                </td>
                <td>
                    <?= $banner['banner_url'] ?>
                </td>
                <td>
                    <?= $banner['banner_flag'] ?>
                </td>
                <td>
                    <div class="button-group">
                        <a class="button border-main" href="banner_update.php?uid=<?= $banner['banner_id'] ?>">
                            <span class="icon-edit"></span>
                            <span>修改</span>
                        </a>
                        <a class="button border-red" href="banner_managerX.php?did=<?= $banner['banner_id'] ?>">
                            <span class="icon-trash-o"></span>
                            <span>删除</span>
                        </a>
                    </div>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>