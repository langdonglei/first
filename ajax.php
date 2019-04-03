<?php
$kw = $_GET['term'];
require_once 'admin/class/D.class.php';
$d = new \langdonglei\D();
$rows = $d->queryByWhere('hw_article', "article_name like '%$kw%'");
$arr = array();
foreach ($rows as $row) {
    $arr[] = $row['article_name'];
}
echo json_encode($arr);