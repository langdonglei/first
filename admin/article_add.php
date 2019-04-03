<?php
require_once 'log.php';
require_once '../inc/d.php';
require_once '../inc/f.php';
if (isset($_POST['cat'])) {
    $d['article_class'] = $_POST['cat'];
    $d['article_name'] = $_POST['name'];
    $d['article_author'] = $_POST['author'];
    $d['article_time'] = time();
    $d['article_from'] = $_POST['from'];
    $d['article_content'] = $_POST['content'];
    $d['article_img'] = upload('../upload/article/titleImage/')[0];
    saveArray('hw_article', $d);
    header('location:article_manager.php');
}
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <?php require_once 'head.php' ?>
</head>
<body>
<div class="panel admin-panel">
    <div class="panel-head" id="add">
        <strong>
            <span class="icon-pencil-square-o"></span>
            <span>添加文章</span>
        </strong>
    </div>
    <div class="body-content">
        <form id="fm" method="post" action="" class="form-x" enctype="multipart/form-data">
            <div class="form-group">
                <div class="label"><label>栏目类别：</label></div>
                <div class="field">
                    <select id="cat" name="cat" title="">
                        <?php
                        require_once '../inc/d.php';
                        $class_s = query('hw_article_class');
                        foreach ($class_s as $class) {
                            ?>
                            <option value="<?= $class['class_id'] ?>"><?= $class['class_name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="label"><label>标题图片：</label></div>
                <div class="field">
                    <input type="file" id="img" name="img"/>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label"><label>标题：</label></div>
                <div class="field">
                    <input type="text" name="name" class="input w50" title="" data-validate="required:请输入文章名称"/>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label"><label>作者：</label></div>
                <div class="field">
                    <input type="text" name="author" value="管理员" title="" class="input w50"
                           data-validate="required:请输入作者"/>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label"><label>来源：</label></div>
                <div class="field">
                    <input type="text" name="from" value="网络" title="" class="input w50"
                           data-validate="required:请输入来源"/>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="ue">
                <?php require_once 'ue.php' ?>
            </div>
            <div class="form-group">
                <div class="label"><label></label></div>
                <div class="field">
                    <button type="button" id="sb" class="button bg-main icon-check-square-o"> 提交</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    //提交
    $('#sb').click(function () {
        var flag = false;
        if ($('#img').val() == '') {
            flag = confirm('不再上传标题图片？');
        } else {
            flag = true;
        }
        if (flag) {
            $('#fm').submit();
        }

    })
</script>
</body>
</html>