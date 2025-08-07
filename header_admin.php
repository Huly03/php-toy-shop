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
                    <a href="admin.php" class="navbar-brand">Mon Store</a>
                    <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navsup"> <!--button: định dạng nút cho chữ -->
                        <span class="navbar-toggler-icon"></span> 
                    </button>
                    <div class="collapse navbar-collapse" id="navsup">
                        <!--left-->
                        <div class="navbar-nav">
                            <a href="add_product.php" class="nav-link">Thêm </a>
                            <a href="oder_management.php" class="nav-link">Quản lý đơn hàng</a>
                            <a href="view_oder.php" class="nav-link">Xem đơn hàng</a>
                            <a href="statistics.php" class="nav-link">Thống kê</a>
                        </div>
                        <!--right-->
                        <div class="navbar-nav ms-auto">
                        <a href="login.php" class="nav-item nav-link">Xin chào, Admin</a>
                        <a href="logout.php" class="nav-item nav-link">Đăng xuất</a>
                    </div>
                </div>
            </nav>
            <section class="py-5 text-center container" style="background-image: url(https://wallpapers.com/images/high/vintage-car-on-pink-background-lq8bbct40x1zwfut.webp); background-position: center center; background-repeat: no-repeat; background-size: cover; font-weight: light;">
            </section> 
            <div class="b-example-divider"></div>