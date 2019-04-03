<?php
require_once 'log.php';
require_once '../inc/d.php';
require_once '../inc/f.php';
//改
if (isset($_POST['aid'])) {
    $d['article_id'] = $_POST['aid'];
    $d['article_class'] = $_POST['class'];
    $d['article_name'] = $_POST['name'];
    $d['article_author'] = $_POST['author'];
    $d['article_from'] = $_POST['from'];
    $d['article_content'] = $_POST['content'];
    $img = upload('../upload/article/titleImage/');
    if (empty($img)) {
    } else {
        $d['article_img'] = $img[0];
    }
    updateArrayInnerPK('hw_article', $d);
    header('location:article_manager.php' . $_POST['p']);
}
//查
$article = queryByPID('hw_article', $_GET['aid'])
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
            <span>修改文章</span>
        </strong>
    </div>
    <div class="body-content">
        <form action="" method="post" id="fm" class="form-x" enctype="multipart/form-data">
            <input type="hidden" name="aid" value="<?= $article['article_id'] ?>">
            <div class="form-group">
                <div class="label"><label>文章类别：</label></div>
                <div class="field">
                    <select name="class">
                        <?php
                        require_once '../inc/d.php';
                        $class_s = query('hw_article_class');
                        foreach ($class_s as $class) {
                            if ($class['class_id'] == $article['article_class']) {
                                printf('<option selected value="%d">%s</option>', $class['class_id'], $class['class_name']);
                                continue;
                            } else {
                                printf('<option value="%d">%s</option>', $class['class_id'], $class['class_name']);
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="label"><label>标题图片：</label></div>
                <div class="field">
                    <input type="file" name="img" id="img"/>
                    <div class="tips">图片要求</div>
                </div>
            </div>
            <div class="form-group">
                <div class="label"><label>标题：</label></div>
                <div class="field">
                    <input type="text" value="<?= $article['article_name'] ?>" class="input w50" name="name"
                           data-validate="required:请输入文章名称"/>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label"><label>作者：</label></div>
                <div class="field">
                    <input type="text" value="<?= $article['article_author'] ?>" class="input w50" name="author"
                           data-validate="required:请输入作者"/>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label"><label>来源：</label></div>
                <div class="field">
                    <input type="text" value="<?= $article['article_from'] ?>" class="input w50" name="from"
                           data-validate="required:请输入来源"/>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="ue">
                <script id="container" name="content" type="text/plain"><?= $article['article_content'] ?></script>
                <script src="ue/ueditor.config.js"></script>
                <script src="ue/ueditor.all.js"></script>
                <script>
                    var cfg = {
                        imagePopup: true,
                        autoClearinitialContent: false,
                        emotionLocalization: true,
                        elementPathEnabled: false,
                        wordCount: true,
                        maximumWords: 10000,
                        initialFrameWidth: '90%',
                        initialFrameHeight: 500,
                        toolbars: [[
                            'fullscreen', 'source', '|', 'undo', 'redo', '|',
                            'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
                            'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
                            'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
                            'directionalityltr', 'directionalityrtl', 'indent', '|',
                            'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
                            'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
                            'simpleupload', 'insertimage', 'emotion', 'scrawl', 'insertvideo', 'music', 'attachment', 'map', 'gmap', 'insertframe', 'insertcode', 'webapp', 'pagebreak', 'template', 'background', '|',
                            'horizontal', 'date', 'time', 'spechars', 'snapscreen', 'wordimage', '|',
                            'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', 'charts', '|',
                            'print', 'preview', 'searchreplace', 'drafts', 'help'
                        ]]
                    };
                    var ue = UE.getEditor('container', cfg);
                </script>
            </div>
            <div class="form-group">
                <div class="label"><label></label></div>
                <div class="field">
                    <button type="button" id="sb" class="button bg-main icon-check-square-o">提交</button>
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