<DOCTYPE html>
    <html lange="en">
        <head>
            <title></title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
        </head>
        <style>
            .dropdown:hover .dropdown-menu
            {
                display: block;
            }
            .b-example-divider
            {
                height: 3rem;
                background-color: rgba(0, 0, 0, .1);
                border: solid rgba(0, 0, 0, .15);
                border-width: 1px 0;
                box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1);
            }
        </style>
        <body>
            <nav class="navbar navbar-expand-sm navbar-dark bg-dark"> <!-- nav: thẻ bao gồm div -->
                <div class="container-fluid"> <!--div: thẻ --> 
                    <a href="home.php" class="navbar-brand">Mon Store</a>
                    <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navsup"> <!--button: định dạng nút cho chữ -->
                        <span class="navbar-toggler-icon"></span> 
                    </button>
                    <div class="collapse navbar-collapse" id="navsup">
                        <!--left-->
                        <div class="navbar-nav">
                            <a href="shopcart.php" class="nav-link">Giỏ hàng</a>
                            <a href="search.php" class="nav-link">Tìm kiếm</a>
                            <div class="dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Thể loại</a> <!-- quản lí thể loại -->
                                <div class="dropdown-menu">
                                    <a href="management.php?Theloai=1" class="dropdown-item">Xe ô tô</a>  <!--  "?" dùng để truy vấn -->
                                    <a href="management.php?Theloai=2" class="dropdown-item">Xe công trình</a>
                                    <a href="management.php?Theloai=3" class="dropdown-item">Xe mô tô</a>
                                    <a href="management.php?Theloai=4" class="dropdown-item">Xe chuyên dụng</a>

                                </div>
                            </div>
                        </div>
                        <!--right-->
                        <div class="navbar-nav ms-auto">
                        <?php
                        //session_start();
                            if(isset($_COOKIE['cc_Username'])):
                        ?>
                        <a href="login.php" class="nav-item nav-link">Xin chào, <?=$_COOKIE['cc_Username']?></a>
                        <a href="logout.php" class="nav-item nav-link">Đăng xuất</a>
                        <?php
                            else:
                        ?>
                        <a href="login.php" class="nav-item nav-link">Đăng nhập</a>
                        <?php
                        endif;
                        ?>
                        </div>
                    </div>
                </div>
            </nav>
            <section class="py-5 text-center container" style="background-image: url(https://wallpapers.com/images/high/vintage-car-on-pink-background-lq8bbct40x1zwfut.webp); background-position: center center; background-repeat: no-repeat; background-size: cover; font-weight: light;">
            </section> 
            <div class="b-example-divider"></div>
            