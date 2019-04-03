<?php
require_once 'log.php';
require_once '../inc/d.php';
//删除
if (isset($_GET['aid'])) {
    deleteByPId('hw_article', $_GET['aid']);
    header('location:article_manager.php?p=' . $_GET['p']);
}
//删除已选
if (isset($_POST['aids'])) {
    foreach ($_POST['aids'] as $aid) {
        deleteByPId('hw_article', $aid);
    }
    header('location:article_manager.php?p=' . $_GET['p']);
}
//改
//删除
if (isset($_GET['aid4u'])) {
    deleteByPId('hw_article', $_GET['aid4d']);
    header('location:article_manager.php?p=' . $_GET['p']);
}
//查
$article_p = page('hw_article', 6, '*', '1=1', 'order by article_id desc', 'left join hw_article_class on article_class=class_id');
?>
<!DOCTYPE html>
<html>
<head>
    <?php require_once 'head.php' ?>
</head>
<body>
<form action="" method="post" id="fm"></form>
<div class="panel admin-panel">
    <div class="panel-head">
        <strong class="icon-reorder">管理文章</strong>
    </div>
    <div class="padding border-bottom">
        <ul class="search" style="padding-left:10px;">
            <li>
                <button id="ds" class="button border-red icon-trash-o">删除已选</button>
            </li>
            <li>
                <form action="" method="get">
                    <input type="text" name="kw" id="kw" placeholder="请输入搜索关键字" autofocus class="input"
                           style="width:250px;display:inline-block"/>
                    <button type="submit" class="button border-main icon-search">搜索</button>
                </form>
            </li>
        </ul>
    </div>
    <table class="table table-hover text-center">
        <tr>
            <th>
                <label for="sa">全选</label>
                <input type="checkbox" name="sa" id="sa">
            </th>
            <th>标题</th>
            <th>标题图片</th>
            <th>类别</th>
            <th>作者</th>
            <th>来源</th>
            <th>操作</th>
        </tr>
        <?php foreach ($article_p['rows'] as $article) { ?>
            <tr>
                <td>
                    <label></label>
                    <input type="checkbox" form="fm" name="aids[]" value="<?= $article['article_id'] ?>" title="">
                </td>
                <td>
                    <?= $article['article_name'] ?>
                </td>
                <td>
                    <?php if ($article['article_img'] == NULL) {
                        echo '无';
                    } else {
                        printf('<img height="30" src="../upload/article/titleImage/%s"/>', $article['article_img']);
                    } ?>
                </td>
                <td>
                    <?= $article['class_name'] ?>
                </td>
                <td>
                    <?= $article['article_author'] ?>
                </td>
                <td>
                    <?= $article['article_from'] ?>
                </td>
                <td>
                    <div class="button-group">
                        <a href="article_update.php?aid=<?= $article['article_id'] ?>&p=<?= $_GET['p'] ?>"
                           class="button border-red">
                            <span class="icon-edit"></span>
                            <span>修改</span>
                        </a>
                        <a href="?aid=<?= $article['article_id'] ?>&p=<?= $_GET['p'] ?>" class="button border-red">
                            <span class="icon-trash-o"></span>
                            <span>删除</span>
                        </a>
                    </div>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
<div>
    <?php echo $article_p['info'] ?>
</div>
<script>
    //全选
    $("#sa").click(function () {
        if (this.checked) {
            $("input[name='aids[]']").each(function () {
                this.checked = true;
            });
        } else {
            $("input[name='aids[]']").each(function () {
                this.checked = false;
            });
        }
    });
    //批量删除
    $('#ds').click(function () {
        var Checkbox = false;
        $("input[name='aids[]']").each(function () {
            if (this.checked == true) {
                Checkbox = true;
            }
        });
        if (Checkbox) {
            var t = confirm("您确认要删除选中的内容吗？");
            if (t == false) return false;
            $("#fm").submit();
        }
        else {
            alert("请选择您要删除的内容!");
            return false;
        }
    })
</script>
</body>
</html>