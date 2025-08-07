<?php
include_once('header_admin.php');
include_once('connect.php');
$c = new Connect();
$dbLink = $c->connectToMySQL();
?>
<div class="container px-4 py-5">
    <?php
    if (isset($_GET['delete_Maxe'])) {
        $deleteId = $_GET['delete_Maxe'];
        // Perform the deletion by running a DELETE SQL query
        $deleteSql = "DELETE FROM xe WHERE Maxe = ?";
        $deleteStmt = $dbLink->prepare($deleteSql);
        $deleteStmt->bind_param("i", $deleteId);

        if ($deleteStmt->execute()) {
            // Product deleted successfully
            echo "Xe đã bị xóa thành công!";
        } else {
            // Deletion failed
            echo "Không xóa được xe.";
        }
    }
    if (isset($_GET['Maxe'])) :
        $pid = $_GET['Maxe'];
        require_once 'connect.php';
        $conn = new Connect();
        $db_link = $conn->connectToPDO();
        $sql = "SELECT * FROM xe WHERE Maxe=?";
        $stmt = $db_link->prepare($sql);
        $stmt->execute(array($pid));
        $re = $stmt->fetch(PDO::FETCH_BOTH);
    ?>
        <div class="card mb-3 col-3 mx-auto my-3" style="width: 18rem;">
            <img src="img/<?= $re['Hinhanh'] ?>" class="card-img-top my-3 mx-auto" alt="..." style="max-width: 90%; height: auto; border: 1px solid black; border-radius: 6px;">
            <div class="card-body">
                <h2 class="text-center" style="color: black;"><?= $re['TenXe'] ?></h2>

                Giá tiền: <?= $re['Giatien'] ?>đ
                <br>
                Số lượng: <?= $re['Soluong'] ?>
                <br>
                Thông tin xe: <?= $re['Thongtinxe'] ?>
                <br>
            </div>
            <button type="submit" name="btnAdddelete" class="btn btn-dange mx-3">
                <!-- <a href="cart.php?id=<?=$row['Maxe']?>" class="text-decoration-none text-black">Add to cart</a><i class="fas fa-shopping-cart"></i> -->
                <a href="update.php?Maxe=<?=$re['Maxe']?>" class="btn btn-success">Cập nhật xe
                <i class="fa-solid fa-pen-to-square"></i></a>
            </button> 
            <button type="submit" name="btnAdddelete" class="btn btn-dange mx-3">
                <!-- <a href="cart.php?id=<?=$row['Maxe']?>" class="text-decoration-none text-black">Add to cart</a><i class="fas fa-shopping-cart"></i> -->
                <a href="?delete_Maxe=<?= $re['Maxe']?>" class="btn btn-danger">Xoá xe
                <i class="fa-solid fa-xmark"></i></a>
            </button>        
        </div>
        <?php
            // Fetch the category information of the current product
            $category_sql = "SELECT * FROM theloai WHERE Theloai = ?";
            $category_stmt = $db_link->prepare($category_sql);
            $category_stmt->execute(array($re['Theloai']));
            $category = $category_stmt->fetch(PDO::FETCH_BOTH);
        ?>
        <div class="b-example-divider"></div>
        <footer class="text-muted py-5">
        <h3 class="text-center mb-4"><strong>Sản phẩm liên quan</strong></h3>

        <?php
            // Fetch related products based on the same category
            $related_category_sql = "SELECT xe.*, theloai.Theloai 
                                    FROM xe 
                                    JOIN theloai ON xe.Theloai = theloai.Theloai 
                                    WHERE xe.Maxe <> ? AND xe.Theloai = ? 
                                    ORDER BY RAND() 
                                    LIMIT 4";

            $related_category_stmt = $db_link->prepare($related_category_sql);
            $related_category_stmt->execute(array($re['Maxe'], $re['Theloai']));
            $related_products_category = $related_category_stmt->fetchAll(PDO::FETCH_BOTH);
        ?>

        <div class="row" style="display: flex;">
            <?php foreach ($related_products_category as $product_category): ?>
                <div class="card mb-3 col-3 mx-auto my-3" style="width: 18rem;">
                 <img src="img/<?=$product_category['Hinhanh']?>" 
                class="card-img-top" alt="...">
                <div class="card-body">

                    <a href="detail_admin.php?Maxe=<?=$product_category['Maxe']?>" class="text-decoration-none">
                        <h6 class="text-center" style="font-size: 15px; color: black;"><?=$product_category['TenXe']?></h6>
                    </a>
                    <p class="card-cost text-center my-3" style="font-weight: bold; font-size: 30px;"><small class="text-muted"><?=$product_category['Giatien']?>&#8363;</small></p>

                    
                </div>

                </div>
            <?php endforeach; ?>
        </div>
        </footer>
    <?php
    else :
    ?>
        <h2>Không có gì để hiện thị</h2>
    <?php
    endif;
    ?>
</div>

<hr class="my-4">

<div class="pt-5">
    <h6 class="mb-0"><a href="admin.php" class="text-body">
            <i class="fas fa-long-arrow-alt-left me-2"></i>Quay lại trang chủ</a>
    </h6>
</div>
<?php
include_once('footer.php');
?>
