<?php
require_once('header.php');
require_once('connect.php');
?>

<div class="container my-3">
    <div class="row d-flex justify-content-center align-items-center p-3">
        <div class="col-md-8">
            <form action="search.php" class="search">
                <input type="text" class="form-control" placeholder="Tìm kiếm..." name="search">

                <button class="btn btn-primary btn-rounded-pill my-2" name="btnSearch">Tìm kiếm</button>
            </form>
        </div>
    </div>

    <div class="row mx-auto">
        <?php
        $c = new Connect();
        $dblink = $c->connectToPDO();

        if (isset($_GET['search'])) {
            $nameP = $_GET['search'];
        } else {
            $nameP = "";
        }

        $sql = "SELECT * FROM xe WHERE TenXe LIKE ?";
        $re = $dblink->prepare($sql);
        $valueArray = ["%$nameP%"]; //dieu kien like
        $re->execute($valueArray);
        $row = $re->fetchAll(PDO::FETCH_BOTH); //fetchAll lay toan bo
        if ($re->rowCount() > 0) {
            foreach ($row as $r):
                ?>

                <div class="row card mb-3 col-3 mx-auto" style="width: 18rem;">
                    <img src="img/<?= $r['Hinhanh'] ?>" class="card-img-top my-3" alt="..."
                        style="max-width: 100%; height: auto; border: 1px solid black; border-radius: 6px;">

                    <div class="card-body mx-auto">
                        <a href="detail.php?id=<?= $r['Maxe'] ?>" class="text-decoration-none">
                            <h6 class="text-center" style="font-size: 15px; color: black;">
                                <?= $r['TenXe'] ?>
                            </h6>
                        </a>

                        <p class="card-cost text-center" style="font-weight: bold; font-size: 30px;"><small class="text-muted">
                                <?= $r['Giatien'] ?>
                            </small></p>

                        <div class="row add-to-cart mx-auto">
                            <button class="btn btn-warning btn-rounded-pill mx-auto">
                                <a href="shopcart.php?id=<?= $r['Maxe'] ?>" class="text-decoration-none text-black">Thêm vào giỏ hàng<i
                                        class="fas fa-shopping-cart"></i></a>
                            </button>
                        </div>
                    </div>
                </div>

                <?php
            endforeach;
            ?>

            <?php
        } else {
            echo "Không tìm thấy xe";
        }
        ?>
    </div>
</div>

<?php
require_once('footer.php');
?>