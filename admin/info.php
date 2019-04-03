<?php
require_once 'log.php';
$js=file_get_contents('view.text');
$view=json_decode($js,true);
var_dump($js);
var_dump($view);
?>
<!DOCTYPE html>
<html>
<head>
    <?php require_once 'head.php' ?>
</head>
<body>
<div class="panel admin-panel">
    <div class="panel-head">
        <strong class="icon-reorder">欢迎回来</strong>
    </div>
    <span>总访问量></span>
    <span>昨日访问量<?= file_get_contents('view.text') ?></span>
</div>
</body>
</html>