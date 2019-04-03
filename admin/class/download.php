<?php
require_once 'F.class.php';
$f = new \langdonglei\F();
if (isset($_GET['dowm'])) {
    if ($_GET['down'] == 6) {
        $f->download('download.php', '我的代码');
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>download</title>
</head>
<body>
<a href="?down=6">下载</a>
</body>
</html>