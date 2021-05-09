<?php
session_start();
include_once 'connect.php';
$db = new DB();
if (isset($_GET['id']) && $_GET['id']>0){
    $id = $_GET['id'];
    $sql = "DELETE FROM products WHERE id=$id";
    $db->conn->exec($sql);
    $_SESSION['action'] = 'Xóa thành công';
    header('location:index.php');
    exit();
}
