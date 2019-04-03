<?php
require_once 'log.php';
require_once '../inc/d.php';
require_once '../inc/f.php';
require_once '../inc/i.php';
if (isset($_POST['pid_u'])) {
//添加产品图片
    $img_s = upload('../upload/product/big');
    if (!empty($img_s)) {
        foreach ($img_s as $img) {
            thumbs('../upload/product/big/' . $img, 'mid', 400, 400);
            thumbs('../upload/product/big/' . $img, 'small', 68, 68);
            thumbs('../upload/product/big/' . $img, 'box', 147, 80);
            logo('../upload/product/big/' . $img);
            $dd['image_pid'] = $_POST['uid'];
            $dd['image_img'] = $img;
            saveArray('hw_image', $dd);
        }
    }
//删除产品图片
    if (isset($_POST['imgs'])) {
        foreach ($_POST['imgs'] as $filename) {
            @unlink('../upload/product/big/' . $filename);
            @unlink('../upload/product/mid/' . $filename);
            @unlink('../upload/product/small/' . $filename);
            deleteByWhere('hw_image', "image_img='$filename'");
        }
    }
//修改产品信息
    $d['product_id'] = $_POST['pid_u'];
    $d['product_name'] = $_POST['name'];
    $d['product_class'] = $_POST['class'];
    $d['sub'] = $_POST['sub'];
    $d['product_model'] = $_POST['model'];
    $d['product_content'] = $_POST['content'];
    updateArrayInnerPK('hw_image_product', $d);
//跳转携带页码
    header('location:product_manager.php?p=' . $_POST['p']);
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
            <span>修改产品</span>
        </strong>
    </div>
    <div class="body-content">
        <form id="fm" method="post" class="form-x" action="" enctype="multipart/form-data">
            <input type="hidden" name="pid_u" value="<?= $_GET['uid'] ?>">
            <input type="hidden" name="p" value="<?= $_GET['p'] ?>"/>
            <!--主类别下拉菜单-->
            <div class="form-group">
                <div class="label"><label>类别：</label></div>
                <div class="field">
                    <select id="cat" name="class"
                            onchange="location.href='product_update.php?uid=<?= $_GET['uid'] ?>&p=<?= $_GET['p'] ?>&pid='+this.value">
                        <?php
                        require_once '../inc/d.php';
                        $product = queryByPID('hw_image_product', $_GET['uid']);
                        $class_s = query('hw_product_class');
                        foreach ($class_s as $class) {
                            if (isset($_GET['pid']) && $_GET['pid'] == $class['class_id']) {
                                printf('<option selected value="%d">%s</option>', $class['class_id'], $class['class_name']);
                                continue;
                            } elseif ($class['class_id'] == $product['product_class']) {
                                printf('<option selected value="%d">%s</option>', $class['class_id'], $class['class_name']);
                                continue;
                            }
                            printf('<option value="%d">%s</option>', $class['class_id'], $class['class_name']);
                        } ?>
                    </select>
                </div>
            </div>
            <!--子类别下拉菜单-->
            <div class=" form-group">
                <div class="label"><label>子类别：</label></div>
                <div class="field">
                    <select id="sub" name="sub">
                        <?php
                        //修改主类后 在子类下拉菜单中写入所选主类的所有子类
                        if (isset($_GET['pid'])) {
                            $sub_s = query('sub', 'pid=' . $_GET['pid']);
                            if (empty($sub_s)) {
                                printf('<option>无子类</option>');
                            } else {
                                foreach ($sub_s as $sub) {
                                    printf('<option value="%d">%s</option>', $sub['id'], $sub['nam']);
                                }
                            }
                            //初始子类下拉菜单中显示当前修改的产品所属于子类
                        } else {
                            $sub_s = query('sub', 'pid=' . $product['product_class']);
                            if (empty($sub_s)) {
                                printf('<option>无子类</option>');
                            } else {
                                foreach ($sub_s as $sub) {
                                    //子类默认selected
                                    if ($sub['id'] == $product['sub']) {
                                        printf('<option selected value="%d">%s</option>', $sub['id'], $sub['nam']);
                                        continue;
                                    }
                                    printf('<option value="%d">%s</option>', $sub['id'], $sub['nam']);
                                }
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <!--删除图片-->
            <div class="form-group">
                <div class="label"><label>删除图片：</label></div>
                <div class="field">
                    <div class="imgbox">
                        <?php
                        $image_s = query('hw_image', 'image_pid=' . $_GET['uid']);
                        foreach ($image_s as $image) {
                            printf('<div><img src="../upload/product/small/%s"><img src="images/duihao30.png" class="nomask"></div>', $image['image_img']);
                        } ?>
                    </div>
                </div>
            </div>
            <!--添加图片-->
            <div class="form-group">
                <div class="label">
                    <label>添加图片：</label>
                </div>
                <div class="field">
                    <input type="file" name="file[]" multiple>
                    <div class="tips">图片尺寸：1000*500,可多选</div>
                </div>
            </div>
            <!--名称-->
            <div class="form-group">
                <div class="label">
                    <label>名称：</label>
                </div>
                <div class="field">
                    <input type="text" id="nam" name="name" value="<?= $product['product_name'] ?>"
                           class="input w50" autofocus/>
                    <span class="mtip"></span>
                </div>
            </div>
            <!--型号-->
            <div class="form-group">
                <div class="label">
                    <label>型号：</label>
                </div>
                <div class="field">
                    <input id="mod" type="text" value="<?= $product['product_model'] ?>" class="input w50" name="model"
                           data-validate="required:请输入产品型号"/>
                    <div class="tips"></div>
                </div>
            </div>
            <!--内容-->
            <div class="ue">
                <script id="container" name="content" type="text/plain"><?= $product['product_content'] ?></script>
                <script src="ue/ueditor.config.js"></script>
                <script src="ue/ueditor.all.js"></script>
                <script>
                    var cfg = {
                        imagePopup: true,
                        emotionLocalization: true,
                        elementPathEnabled: false,
                        wordCount: true,
                        maximumWords: 10000,
                        initialFrameWidth: '100%',
                        initialFrameHeight: 500,
                        toolbars: [[
                            'undo', 'source',
                            '|', 'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript',
                            '|', 'removeformat', 'formatmatch', 'autotypeset',
                            '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc',
                            '|', 'rowspacingtop', 'rowspacingbottom', 'lineheight',
                            '|', 'fontfamily', 'fontsize',
                            '|', 'indent', 'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify',
                            '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter',
                            '|', 'simpleupload', 'insertimage', 'emotion'
                        ]]
                    }
                    var ue = UE.getEditor('container', cfg);
                </script>
            </div>
            <!--提交-->
            <div class="form-group">
                <div class="label"><label></label></div>
                <div class="field">
                    <button type="button" onclick="location.href='product_manager.php?pid='<?= $_GET['p'] ?>"
                            class="button bg-main icon-check-square-o">返回
                    </button>
                    <button type="button" id="sb" class="button bg-main icon-check-square-o mysubmit">
                        提交
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    //删除图片
    var imgs = $(".imgbox").find("img:first-child");
    var imgcnt = imgs.size();
    imgs.click(function () {
        var pathname = $(this).attr("src");
        var filename = pathname.substring(pathname.lastIndexOf("/") + 1);
        var me = $(this);
        if (imgcnt == 1 && me.next().attr("class") == "nomask") {
            alert('至少要留一张图片');
        } else if (me.next().attr("class") == "nomask") {
            var node = '<input type="hidden" name="imgs[]" value="' + filename + '"/>';
            me.next().after(node);
            me.next().attr("class", "mask");
            imgcnt--;
        } else {
            me.next().next().remove();
            me.next().attr("class", "nomask");
            imgcnt++;
        }
    });
    //验证产品名
    var t;
    var onam = $('#nam').val()
    $('#nam').on('input', function () {
        clearTimeout(t);
        var me = $(this);
        if (me.val() == onam) {
            $('#sb').removeAttr('disabled');
            me.next().html('');
        } else {
            t = setTimeout(function () {
                $.ajax({
                    url: 'ajax.php',
                    type: 'post',
                    cache: false,
                    async: false,
                    data: {
                        pnam: me.val()
                    },
                    dataTye: 'text',
                    success: function (t) {
                        if (eval(t)) {
                            $('#sb').removeAttr('disabled');
                            me.next().html('');
                        } else {
                            $('#sb').prop('disabled', true);
                            me.next().html('已存在');
                        }
                    }
                });
            }, 1000);
        }
    });
    //提交
    //TODO
    $('#sb').click(function () {
        if ($('#nam').val() == '') {
            alert('请检查');
        } else {
            $('#fm').submit();
        }
    })
</script>
</body>
</html>