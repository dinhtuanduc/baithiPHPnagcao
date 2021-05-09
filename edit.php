<?php
session_start();
include_once 'connect.php';
$db = new DB();
$conn = $db->conn;
if(isset($_GET['id']) && $_GET['id']>0){
    $id =$_GET['id'];
    $sql = "SELECT * FROM products WHERE id=$id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $product = $stmt->fetchAll();
    $product =$product[0];
}
if (count($_POST)>0){
    if (!empty($_POST['name']) && !empty($_POST['price'])){
        $name = $_POST['name'];
        $price = $_POST['price'];
        if ($_FILES['avatar']['name'] != NULL){
            if ($_FILES['avatar']['type'] == "image/jpeg" || $_FILES['avatar']['type'] == "image/png" || $_FILES['avatar']['type'] == "image/gif" || $_FILES['avatar']['type'] == "image/jpg") {

                $path = "images/";
                $tmp_name = $_FILES['avatar']['tmp_name'];
                $img_name = $_FILES['avatar']['name'];
                move_uploaded_file($tmp_name, $path . $img_name);
                $image = $path.$img_name;
            } else {
                echo "<br>Kiểu file này không hợp lệ";
            }
        }else{
            $image = $product['avatar'];
        }
        $detail = $_POST['detail'];

        $sql ="UPDATE products
                SET title='$name',price=$price,avatar='$image',content='$detail'
                WHERE id=$id";
        $stmt = $conn->exec($sql);
        $_SESSION['action'] = 'Sửa thành công';
        header('location:index.php');
        exit();
    }else{
        echo "Vui lòng nhập đủ tên và giá";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <title>Document</title>
</head>
<body>
<div class="container">
    <h1 class="text-center">Thêm mới sản phẩm</h1>
    <a href="index.php" class="btn btn-primary">Về trang danh sách</a>
    <form method="post" enctype="multipart/form-data">
        <div class="form-row">
            <input type="hidden" name="getid" value="<?php echo $product['id'] ?>">
            <div class="form-group">
                <label for="name">Tên sản phẩm:</label>
                <input type="text" class="form-control" name="name" id="name" value="<?php echo $product['title'] ?>">
            </div>
            <div class="form-group">
                <label for="price">Giá:</label>
                <input type="text" class="form-control" name="price" id="price" value="<?php echo $product['price'] ?>">
            </div>
            <div class="form-group">
                <label for="avatar">Ảnh:</label>
                <input type="file" name="avatar" class="form-control">
                <?php
                    if(!empty($product['avatar'])){
                        $avatar = $product['avatar'];
                        echo "<img style='width: 100px' src='$avatar'>";
                    }
                ?>
            </div>
            <div class="form-group">
                <label for="detail">Chi tiết sản phẩm</label>
                <textarea class="form-control" name="detail" id="detail" cols="30" rows="10"><?php echo $product['content'] ?></textarea>
            </div>
            <div class="form-group">
                <br>
                <button type="submit" class="btn btn-success">Save</button>
                <button type="reset" class="btn btn-warning">Reset</button>
            </div>
    </form>
</div>
</div>
</body>
</html>
