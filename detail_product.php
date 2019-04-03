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
            <div class="detail_product">
                <div class="title2">详细信息</div>
                <div class="content2">
                    <div class="zoom">
                        <div class="preview">
                            <div id="vertical" class="bigImg">
                                <?php
                                require_once 'inc/d.php';
                                $image_s = query('hw_image', 'image_pid=' . $_GET['id']);
                                ?>
                                <img src="upload/product/mid/<?= $image_s[0]['image_img'] ?>" id="midimg"/>
                                <div style="display:none;" id="winSelector"></div>
                            </div>
                            <div class="smallImg">
                                <div class="scrollbutton smallImgUp disabled"></div>
                                <div id="imageMenu">
                                    <ul>
                                        <?php foreach ($image_s as $image) { ?>
                                            <li><img src="upload/product/small/<?= $image['image_img'] ?>"></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <div class="scrollbutton smallImgDown"></div>
                            </div>
                            <div id="bigView" style="display:none;">
                                <img width="800" height="800"/>
                            </div>
                        </div>
                        <div class="product_info">
                            <?php
                            $product = queryByPID('hw_image_product', $_GET['id']);
                            ?>
                            <table>
                                <tr>
                                    <td>名称：</td>
                                    <td><?= $product['product_name'] ?></td>
                                </tr>
                                <tr>
                                    <td>型号：</td>
                                    <td><?= $product['product_model'] ?></td>
                                </tr>
                                <tr>
                                    <td>类型：</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>描述：</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="product_content">
                        <?php
                        echo $product['product_content']
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="cf"></div>
<?php include 'z_bottom.php' ?>
</body>
</html>