<?php
session_start();
include_once 'connect.php';
$db = new DB();
$conn = $db->conn;
$sql = "SELECT * FROM products";
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$products = $stmt->fetchAll();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Danh sách sản phẩm</h1>
        <?php
            if (isset($_SESSION['action'])){
                $action = $_SESSION['action'];
                echo "<div class='alert alert-success'>$action</div>";
                session_unset();
                session_destroy();
            }
        ?>

        <a href="create.php" class="btn btn-primary">Thêm mới</a>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Ảnh</th>
                <th>Chi tiết sản phẩm</th>
                <th>Ngày tạo</th>
                <th>Thao tác</th>
            </tr>
            </thead>
            <tbody>
            <?php
                if (isset($products)){
                    foreach ($products as $product){
                        ?>
                        <tr>
                            <td><?php echo $product['id'] ?></td>
                            <td><?php echo $product['title'] ?></td>
                            <td><?php echo $product['price'] ?></td>
                            <td><img style="width: 150px" src="<?php echo $product['avatar'] ?>"></td>
                            <td><?php echo $product['content'] ?></td>
                            <td><?php echo $product['created_at'] ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $product['id'] ?>" class="btn btn-warning">Sửa</a>
                                <a onclick="return confirm('Bạn có chắc muốn xóa không?')" href="delete.php?id=<?php echo $product['id'] ?>" class="btn btn-danger">Xóa</a>
                            </td>
                        </tr>
                        <?php
                    }
                }
            ?>
            </tbody>
        </table>
</div>
</body>
</html>
