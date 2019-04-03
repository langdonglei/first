<?php
require_once '../inc/d.php';
require_once '../admin/class/D.class.php';
require_once '../admin/class/T.class.php';
require_once '../admin/class/F.class.php';
require_once '../admin/class/I.class.php';
$conn = new \langdonglei\D();
$tool = new \langdonglei\T();
$file = new \langdonglei\F();
$image = new \langdonglei\I();
session_start();
if (isset($_SESSION['admin'])) {
} else {
    header('location:login.php');
}