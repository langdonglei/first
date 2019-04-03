<?php
require_once 'log.php';
if (isset($_GET['id'])) {
    require_once '../inc/d.php';
    deleteByPId('book', $_GET['id']);
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php require_once 'head.php' ?>
</head>
<body>
<div class="panel admin-panel">
    <div class="panel-head">
        <strong class="icon-reorder">客户留言</strong>
    </div>
    <table class="table table-hover text-center">
        <tr>
            <th>姓名</th>
            <th>性别</th>
            <th>电话</th>
            <th>邮箱</th>
            <th>地址</th>
            <th>标题</th>
            <th>类别</th>
            <th>内容</th>
        </tr>
        <?php
        require_once '../inc/d.php';
        $book_s = page('book', 5);
        foreach ($book_s['rows'] as $book) {
            ?>
            <tr>
                <td>
                    <?= $book['nam'] ?>
                </td>
                <td>
                    <?= $book['sex'] ?>
                </td>
                <td>
                    <?= $book['tel'] ?>
                </td>
                <td>
                    <?= $book['eml'] ?>
                </td>
                <td>
                    <?= $book['adr'] ?>
                </td>
                <td>
                    <?= $book['tit'] ?>
                </td>
                <td>
                    <?= $book['cat'] ?>
                </td>
                <td>
                    <?= $book['content'] ?>
                </td>
                <td>
                    <div class="button-group">
                        <a class="button border-red" href="?id=<?= $book['id'] ?>">
                            <span class="icon-trash-o"></span>
                            <span>删除</span>
                        </a>
                    </div>
                </td>
            </tr>
        <?php } ?>
    </table>
    <?php echo $book_s['info'] ?>
</div>
</body>
</html>