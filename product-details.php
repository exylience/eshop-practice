<?php
// запускаем сессию
session_start();
// импортируем файл с подключением к БД
require_once 'includes/db.php';

// получаем id товара из GET параметра
$id = $_GET['id'];

// составляем запрос на выборку товара вместе с категорией
$query = "SELECT 
       `products`.`id`, `products`.`title`, `products`.`description`, `products`.`price`, `products`.`image_url`,
       `products`.`category_id`, `categories`.`name`
    FROM `products`
    INNER JOIN `categories`
    ON `products`.`category_id` = `categories`.`id`
    WHERE (`products`.`id` = '$id')";
// выполняем запрос
$response = mysqli_query($db, $query);
// проверяем, вернулись ли хоть какие-нибудь записи из таблицы
if (mysqli_num_rows($response) > 0) {
    // если да, то парсим данные категории в ассоциативный массив
    $product = mysqli_fetch_assoc($response);
} else { // если совпадений не нашлось
    // заносим в сессию ошибку 404
    $_SESSION['message'] = [
        'type' => 'error',
        'text' => 'Product not found'
    ];

    // возвращаем пользователя назад
    header('Location: /index.php');
}

$query = "SELECT 
    `reviews`.`id`, `reviews`.`message`, `reviews`.`user_id`, `reviews`.`stars`,
    `users`.`name`
    FROM `reviews`
    INNER JOIN `users`
    ON `reviews`.`user_id` = `users`.`id`
    WHERE (`reviews`.`id` = '$id')";
$response = mysqli_query($db, $query);
$reviews = mysqli_fetch_all($response, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Meta Tag -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Title Tag  -->
        <title>Eshop</title>
        <!-- Favicon -->
        <link rel="icon" type="image/png" href="images/favicon.png">
        <!-- Web Font -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">

        <!-- StyleSheet -->

        <!-- Bootstrap -->
        <link rel="stylesheet" href="css/bootstrap.css">
        <!-- Magnific Popup -->
        <link rel="stylesheet" href="css/magnific-popup.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="css/font-awesome.css">
        <!-- Fancybox -->
        <link rel="stylesheet" href="css/jquery.fancybox.min.css">
        <!-- Themify Icons -->
        <link rel="stylesheet" href="css/themify-icons.css">
        <!-- Nice Select CSS -->
        <link rel="stylesheet" href="css/niceselect.css">
        <!-- Animate CSS -->
        <link rel="stylesheet" href="css/animate.css">
        <!-- Flex Slider CSS -->
        <link rel="stylesheet" href="css/flex-slider.min.css">
        <!-- Owl Carousel -->
        <link rel="stylesheet" href="css/owl-carousel.css">
        <!-- Slicknav -->
        <link rel="stylesheet" href="css/slicknav.min.css">

        <!-- Eshop StyleSheet -->
        <link rel="stylesheet" href="css/reset.css">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="css/responsive.css">
    </head>
    <body class="js">
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>

    <header class="header shop">
        <div class="topbar">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-md-12 col-12">
                        <div class="top-left">
                            <ul class="list-main">
                                <li><i class="ti-headphone-alt"></i> 88005553535</li>
                                <li><i class="ti-email"></i> info@company.com</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-7 col-md-12 col-12">
                        <div class="right-content">
                            <ul class="list-main">
                                <?php
                                    // проверяем аутентификацию пользователя и выводим подходящие ссылки в верстку
                                    if (isset($_SESSION['user'])) {
                                        ?>
                                            <?php
                                                // проверяем, админ он или нет
                                                if ($_SESSION['user']['group'] === 2) {
                                                    // если админ, выводим ссылку на админку
                                                    ?>
                                                        <li><i class="ti-bolt"></i> <a href="admin/products/index.php">Admin Panel</a></li>
                                                    <?php
                                                }
                                            ?>

                                            <li><i class="ti-user"></i> <a href="#">My account</a></li>
                                            <li><i class="ti-power-off"></i><a href="vendor/auth/logout.php">Logout</a></li>
                                        <?php
                                    } else {
                                        ?>
                                            <li><i class="ti-power-off"></i><a href="login.php">Login</a></li>
                                        <?php
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="middle-inner">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-12">
                        <div class="logo">
                            <a href="index.php"><img src="images/logo.png" alt="logo"></a>
                        </div>

                        <div class="search-top">
                            <div class="top-search"><a href="#0"><i class="ti-search"></i></a></div>

                            <div class="search-top">
                                <form class="search-form">
                                    <input type="text" placeholder="Search here..." name="search">
                                    <button value="search" type="submit"><i class="ti-search"></i></button>
                                </form>
                            </div>
                        </div>

                        <div class="mobile-nav"></div>
                    </div>
                    <div class="col-lg-8 col-md-7 col-12">
                        <div class="search-bar-top">
                            <div class="search-bar">
                                <select>
                                    <option selected="selected">All Category</option>
                                    <option>watch</option>
                                    <option>mobile</option>
                                    <option>kid’s item</option>
                                </select>
                                <form>
                                    <input name="search" placeholder="Search Products Here....." type="search">
                                    <button class="btnn"><i class="ti-search"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-3 col-12">
                        <div class="right-bar">
                            <div class="sinlge-bar">
                                <a href="#" class="single-icon"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                            </div>

                            <div class="sinlge-bar shopping">
                                <a href="#" class="single-icon"><i class="ti-bag"></i> <span class="total-count">2</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="header-inner">
            <div class="container">
                <div class="cat-nav-head">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="all-category">
                                <h3 class="cat-heading"><i class="fa fa-bars" aria-hidden="true"></i>CATEGORIES</h3>
                                <ul class="main-category">
                                    <li><a href="#">accessories</a></li>
                                    <li><a href="#">top 100 offer</a></li>
                                    <li><a href="#">sunglass</a></li>
                                    <li><a href="#">watch</a></li>
                                    <li><a href="#">man’s product</a></li>
                                    <li><a href="#">ladies</a></li>
                                    <li><a href="#">westrn dress</a></li>
                                    <li><a href="#">denim </a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-9 col-12">
                            <div class="menu-area">
                                <nav class="navbar navbar-expand-lg">
                                    <div class="navbar-collapse">
                                        <div class="nav-inner">
                                            <ul class="nav main-menu menu navbar-nav">
                                                <li class="active"><a href="#">Home</a></li>
                                                <li><a href="#">Product</a></li>
                                                <li><a href="#">Service</a></li>
                                                <li><a href="#">Shop<i class="ti-angle-down"></i></a>
                                                    <ul class="dropdown">
                                                        <li><a href="cart.php">Cart</a></li>
                                                        <li><a href="checkout.html">Checkout</a></li>
                                                    </ul>
                                                </li>
                                                <li><a href="contact.html">Contact Us</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="index1.html">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="blog-single.html">Cart</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="shop single section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="product-gallery">
                                <?php
                                    if (!is_null($product)) {
                                        ?>
                                            <img src="<?= $product['image_url'] ?>" alt="#">
                                        <?php
                                    }
                                ?>
                            </div>
                        </div>

                        <div class="col-lg-6 col-12">
                            <div class="product-des">
                                <div class="short">
                                    <h4><?= $product['title'] ?></h4>

                                    <div class="rating-main">
                                        <ul class="rating">
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star-half-o"></i></li>
                                            <li class="dark"><i class="fa fa-star-o"></i></li>
                                        </ul>

                                        <a href="#" class="total-review">(102) Review</a>
                                    </div>

                                    <p class="price">
                                        <span class="discount">$<?= $product['price'] ?></span>
                                    </p>

                                    <p class="description"><?= $product['description'] ?></p>
                                </div>

                                <div class="product-buy">
                                    <div class="add-to-cart">
                                        <a href="#" class="btn">Add to cart</a>
                                        <a href="#" class="btn min">
                                            <i class="ti-heart"></i>
                                        </a>
                                    </div>

                                    <p class="cat">
                                        Category : <a href="#"><?= $product['name'] ?></a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="product-info">
                                <div class="nav-main">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#description" role="tab" aria-selected="true">Description</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#reviews" role="tab" aria-selected="false">Reviews</a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="description" role="tablist">
                                        <div class="tab-single">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="single-des">
                                                        <p><?= $product['description'] ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-panel fade" id="reviews" role="tabpanel">
                                        <div class="tab-single review-panel">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="ratting-main">
                                                        <div class="avg-rating">
                                                            <h4>4.5 <span>Overall</span></h4>
                                                            <span>Based on <?= count($reviews) ?> Comments</span>
                                                        </div>
                                                    </div>

                                                    <?php
                                                        foreach ($reviews as $review) {
                                                            ?>
                                                                <div class="single-rating">
                                                                    <div class="rating-author">
                                                                        <img src="https://wpthemesgrid.com/themes/eshop/images/comments1.jpg" alt="#">
                                                                    </div>

                                                                    <div class="rating-des">
                                                                        <h6><?= $review['name'] ?></h6>

                                                                        <div class="ratings">
                                                                            <ul class="rating">
                                                                                <li><i class="fa fa-star"></i></li>
                                                                                <li><i class="fa fa-star"></i></li>
                                                                                <li><i class="fa fa-star"></i></li>
                                                                                <li><i class="fa fa-star-half-o"></i></li>
                                                                                <li><i class="fa fa-star-o"></i></li>
                                                                            </ul>

                                                                            <div class="rate-count">(<span><?= $review['stars'] ?></span>)</div>
                                                                        </div>

                                                                        <p><?= $review['message'] ?></p>
                                                                    </div>
                                                                </div>
                                                            <?php
                                                        }
                                                    ?>

                                                    <div class="comment-review">
                                                        <div class="add-review">
                                                            <h5>Add A Review</h5>
                                                            <p>Your email address will not be published. Required fields are marked</p>
                                                        </div>

                                                        <h4>Your Rating</h4>

                                                        <div class="review-inner">
                                                            <div class="ratings">
                                                                <ul class="rating">
                                                                    <li><i class="fa fa-star"></i></li>
                                                                    <li><i class="fa fa-star"></i></li>
                                                                    <li><i class="fa fa-star"></i></li>
                                                                    <li><i class="fa fa-star"></i></li>
                                                                    <li><i class="fa fa-star"></i></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <form class="form" method="post" action="#">
                                                        <div class="row">
                                                            <div class="col-lg-12 col-12">
                                                                <div class="form-group">
                                                                    <label>Write a review <span>*</span></label>
                                                                    <textarea name="message" rows="6"></textarea>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-12 col-12">
                                                                <div class="form-group button5">
                                                                    <button type="submit" class="btn">Submit</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-top section">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-lg-5 col-md-6 col-12">
                        <div class="single-footer about">
                            <div class="logo">
                                <a href="index.php"><img src="images/logo2.png" alt="#"></a>
                            </div>
                            <p class="text">Praesent dapibus, neque id cursus ucibus, tortor neque egestas augue,  magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.</p>
                            <p class="call">Got Question? Call us 24/7<span><a href="tel:123456789">+0123 456 789</a></span></p>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-12">
                        <div class="single-footer links">
                            <h4>Information</h4>
                            <ul>
                                <li><a href="#">About Us</a></li>
                                <li><a href="#">Faq</a></li>
                                <li><a href="#">Terms & Conditions</a></li>
                                <li><a href="#">Contact Us</a></li>
                                <li><a href="#">Help</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="copyright">
            <div class="container">
                <div class="inner">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="left">
                                <p>Copyright © 2022 EShop</p>
                            </div>
                        </div>

                        <div class="col-lg-6 col-12">
                            <div class="right">
                                <img src="images/payments.png" alt="#">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- /End Footer Area -->

    <!-- Jquery -->
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.0.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <!-- Popper JS -->
    <script src="js/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Color JS -->
    <script src="js/colors.js"></script>
    <!-- Slicknav JS -->
    <script src="js/slicknav.min.js"></script>
    <!-- Owl Carousel JS -->
    <script src="js/owl-carousel.js"></script>
    <!-- Magnific Popup JS -->
    <script src="js/magnific-popup.js"></script>
    <!-- Fancybox JS -->
    <script src="js/facnybox.min.js"></script>
    <!-- Waypoints JS -->
    <script src="js/waypoints.min.js"></script>
    <!-- Countdown JS -->
    <script src="js/finalcountdown.min.js"></script>
    <!-- Nice Select JS -->
    <script src="js/nicesellect.js"></script>
    <!-- Ytplayer JS -->
    <script src="js/ytplayer.min.js"></script>
    <!-- Flex Slider JS -->
    <script src="js/flex-slider.js"></script>
    <!-- ScrollUp JS -->
    <script src="js/scrollup.js"></script>
    <!-- Onepage Nav JS -->
    <script src="js/onepage-nav.min.js"></script>
    <!-- Easing JS -->
    <script src="js/easing.js"></script>
    <!-- Active JS -->
    <script src="js/active.js"></script>
</body>
</html>