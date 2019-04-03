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
            <div class="jianjie">
                <div class="title2">搜索结果</div>
                <div class="content2">
                    <ul>
                        <?php
                        if (isset($_GET['kw'])) {
                            $kw = $_GET['kw'];
                            $sa_s = query('hw_article', "article_name like '%$kw%' or article_content like '%$kw%'");
                            foreach ($sa_s as $sa) {
                                $sa['article_name'] = str_replace($kw, "<span style='color:red'>$kw</span>", $sa['article_name']);
                                $sa['article_content'] = preg_replace('/style=".*"/U', '', $sa['article_content']);
                                $sa['article_content'] = preg_replace('/<img.*\/>/U', '', $sa['article_content']);
                                $sa['article_content'] = substr($sa['article_content'], 0, 1200) . '【<a href="index.php">详情</a>】';
                                $sa['article_content'] = str_replace($kw, "<span style='color:red'>$kw</span>", $sa['article_content']);
                                printf('<li><a href="detail_article.php?id=%d">%s</a></li><li>%s</li>', $sa['article_id'], $sa['article_name'], $sa['article_content']);
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="cf"></div>
<?php include 'z_bottom.php' ?>
</body>
</html>