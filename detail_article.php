<?php
require_once 'inc/d.php';
require_once 'admin/class/D.class.php';
$d = new \langdonglei\D();
updateInc('hw_article', 'article_id=' . $_GET['id'], 'article_hits', 1);
$news = queryByPID('hw_article', $_GET['id']);
?>
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
            <div class="detail_article">
                <div class="title2">新闻资讯</div>
                <div class="content2">
                    <div class="article_info">
                        <span>来源：<?= $news['article_from'] ?></span>
                        <span>作者：<?= $news['article_author'] ?></span>
                        <span>发布时间：<?= date('Y-m-d', $news['article_time']) ?></span>
                        <span>阅读次数：<?= $news['article_hits'] ?></span>
                    </div>
                    <div class="article_content">
                        <?= $news['article_content'] ?>
                    </div>
                    <?php
                    echo $d->pianDiv('hw_article', 'article_name', "{$_GET['id']}", 'and article_class=19')
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