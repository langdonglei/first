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
                <div class="title2">成功案例</div>
                <div class="content2">
                    <?php
                    require_once 'inc/d.php';
                    $case_p = page('hw_article', 18, '*', 'article_class=23');
                    foreach ($case_p['rows'] as $case) {
                        ?>
                        <div class="my_product_box">
                            <a href="detail_article.php?id=<?= $case['article_id'] ?>">
                                <img src="upload/article/titleImage/<?= $case['article_img'] ?>">
                                <span><?= $case['article_name'] ?></span>
                            </a>
                        </div>
                        <?php
                    }
                    echo $case_p['info'];
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