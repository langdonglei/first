<?php
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
            <div class="news">
                <div class="title2">新闻资讯</div>
                <div class="content2">
                    <ul class="news_list">
                        <?php
                        require_once 'inc/d.php';
                        $article_p = page('hw_article', 20, '*', 'article_class=19', 'order by article_sort desc');
                        foreach ($article_p['rows'] as $article) {
                            ?>
                            <li><span><?= date('Y-m-d', $article['article_time']) ?></span><a
                                        href="detail_article.php?id=<?= $article['article_id'] ?>"><?= $article['article_name'] ?></a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                    <?php echo $article_p['info']; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="cf"></div>
<?php include 'z_bottom.php' ?>
</body>
</html>