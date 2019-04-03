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
            <div class="news">
                <div class="title2">产品中心</div>
                <div class="content2">
                    <?php
                    require_once 'inc/d.php';
                    if (isset($_GET['cid'])) {
                        $product_p = page('hw_image_product', 3, '*', 'product_class=' . $_GET['cid'], '', '', '&cid=' . $_GET['cid']);
                    } else {
                        $product_p = page('hw_image_product', 3);
                    }
                    foreach ($product_p['rows'] as $product) {
                        ?>
                        <div class="my_product_box">
                            <a href="detail_product.php?id=<?= $product['product_id'] ?>">
                                <img src="upload/product/box/<?= $product['product_img'] ?>">
                                <span><?= $product['product_name'] ?></span>
                            </a>
                        </div>
                        <?php
                    }
                    echo $product_p['info'];
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="cf"></div>
<?php include 'z_bottom.php' ?>
</body>
</html>