<?php
require_once('header_admin.php');//goi noi dung
include_once('connect.php');//goi noi dung
$c = new Connect();
$dbLink = $c->connectToMySQL();//truy van k dieu kien

if (isset($_GET["page"])) {
    $current_page = $_GET["page"];
} else {
    $current_page = 1;
}
$limit = 4;
$start = ($current_page - 1) * $limit;
$sql = "SELECT * FROM xe ORDER BY Ngaynhap DESC LIMIT $start, $limit";
$re=$dbLink->query($sql);
$sql = "SELECT COUNT(*) FROM xe";
$result = mysqli_query($dbLink, $sql);
$row = mysqli_fetch_row($result);
$total_xe = $row[0];
$total_pages = ceil($total_xe / $limit);

$range = 2;
$min_page = $current_page - $range;
$max_page = $current_page + $range;

if($re->num_rows>0){
?>
    
    <div class="container">
        <div class="row mx-auto">
            <?php 
                while($row=$re->fetch_assoc()){
            ?>
            
            <div class="card mb-3 col-3 mx-auto" style="width: 18rem;">
                <img src="img/<?=$row['Hinhanh']?>" 
                class="card-img-top" alt="...">
                <div class="card-body">

                    <a href="detail_admin.php?Maxe=<?=$row['Maxe']?>" class="text-decoration-none">
                        <h6 class="text-center" style="font-size: 15px; color: black;"><?=$row['TenXe']?></h6>
                    </a>
                    <p class="card-cost text-center my-3" style="font-weight: bold; font-size: 30px;"><small class="text-muted"><?=$row['Giatien']?>&#8363;</small></p>

                    
                </div>

            </div> 
            <?php 
                }//while
            }//if
            ?>
        </div>
    </div>
    <?php 
    if ($min_page < 1) {
        $min_page = 1;
    }

    if ($max_page > $total_pages) {
        $max_page = $total_pages;
    }

    // Lấy địa chỉ của trang hiện tại
    $url = $_SERVER['PHP_SELF'];

    // Thêm CSS cho phân trang
    echo "<style>
    .pagination-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .pagination {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .pagination li {
        display: inline-block;
        margin: 5px;
    }
    .pagination a {
        display: block;
        padding: 5px 10px;
        text-decoration: none;
        color: black;
        border: 1px solid #ccc;
    }
    .pagination a.active {
        background-color: #0078d4;
        color: white;
        border: 1px solid #0078d4;
    }
    .pagination a:hover {
        background-color: #eee;
    }
    </style>";

    echo "<div class='pagination-container'>";
    echo "<ul class='pagination'>";

    if ($current_page > 1) {
        echo "<li><a href='$url?page=" . ($current_page - 1) . "'>Prev</a></li>";
    }

    if ($min_page > 1) {
        echo "<li><a href='$url?page=1'>1</a></li>";
        echo "<li><span>...</span></li>";
    }

    for ($i = $min_page; $i <= $max_page; $i++) {
        if ($i == $current_page) {
            echo "<li><a class='active' href='$url?page=$i'>$i</a></li>";
        } else {
            echo "<li><a href='$url?page=$i'>$i</a></li>";
        }
    }

    if ($max_page < $total_pages) {
        echo "<li><span>...</span></li>";
        echo "<li><a href='$url?page=$total_pages'>$total_pages</a></li>";
    }

    if ($current_page < $total_pages) {
        echo "<li><a href='$url?page=" . ($current_page + 1) . "'>Next</a></li>";
    }
    echo "</ul>";
    echo "</div>";
?>
<?php
require_once('footer.php');
?>