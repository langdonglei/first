<?php
require_once 'log.php';
if(isset($_GET['qid4d'])){
    require_once 'log.php';
    require_once '../inc/d.php';
    deleteByPId('hw_quali', $_GET['qid4d']);
    header('location:quali_manager.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php require_once 'head.php' ?>
</head>
<body>
<div class="panel admin-panel">
    <div class="panel-head">
        <strong class="icon-reorder">管理资质</strong>
    </div>
    <div class="padding border-bottom">
        <ul class="search" style="padding-left:10px;">
            <li><a class="button border-main icon-plus-square-o" href="quali_add.php">添加资质</a></li>
            <li>搜索：</li>
            <li>
                <input type="text" placeholder="请输入搜索关键字" name="keywords" class="input"
                       style="width:250px; line-height:17px;display:inline-block"/>
                <a href="javascript:void(0)" class="button border-main icon-search" onclick="changesearch()">搜索</a>
            </li>
        </ul>
    </div>
    <table class="table table-hover text-center">
        <tr>
            <th>ID</th>
            <th>资质名称</th>
            <th>资质图片</th>
            <th>链接地址</th>
            <th>是否显示</th>
            <th>操作</th>
        </tr>
        <?php
        require_once '../inc/d.php';
        $quali_s = query('hw_quali');
        foreach ($quali_s as $quali) {
            ?>
            <tr>
                <td>
                    <?= $quali['quali_id'] ?>
                </td>
                <td>
                    <?= $quali['quali_name'] ?>
                </td>
                <td>
                    <img width="50" src="../upload/quali/<?= $quali['quali_img'] ?>">
                </td>
                <td>
                    <?= $quali['quali_url'] ?>
                </td>
                <td>
                    <?= $quali['quali_flag'] ?>
                </td>
                <td>
                    <div class="button-group">
                        <a class="button border-main" href="quali_update.php?qid=<?= $quali['quali_id'] ?>">
                            <span class="icon-edit"></span>
                            <span>修改</span>
                        </a>
                        <a class="button border-red" href="?qid4d=<?= $quali['quali_id'] ?>">
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