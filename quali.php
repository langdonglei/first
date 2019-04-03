<!DOCTYPE html>
<html lang="zh">
<head>
    <?php require_once 'z_head.php' ?>
</head>
<body>
<?php require_once 'z_top.php' ?>
<div class="main">
    <div class="w">
        <?php include 'z_left.php' ?>
        <div class="box">
            <div class="quali">
                <div class="title2">企业资质</div>
                <div class="content2">
                    <?php
                    require_once 'inc/d.php';
                    $quali_s = query('hw_quali', "quali_flag='y'");
                    foreach ($quali_s as $quali) {
                        ?>
                        <div class="zizhi_box">
                            <a href="#">
                                <img src="upload/quali/<?= $quali['quali_img'] ?>">
                            </a>
                            <span><?= $quali['quali_name'] ?></span>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="cf"></div>
<?php include 'z_bottom.php' ?>
</body>
</html>