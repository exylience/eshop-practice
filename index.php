<?php
// запускаем сессию
session_start();
// импортируем файл с подключением к БД
require_once 'includes/db.php';

// составляем запрос на выборку всех категорий
$query = "SELECT * FROM `categories`";
// выполняем запрос
$response = mysqli_query($db, $query);
// парсим полученные категории в ассоциативный массив
$categories = mysqli_fetch_all($response, MYSQLI_ASSOC);

// составляем запрос на выборку всех товаров
$query = "SELECT * FROM `products`";
// выполняем запрос
$response = mysqli_query($db, $query);
// парсим полученные товары в ассоциативный массив
$products = mysqli_fetch_all($response, MYSQLI_ASSOC);
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
<!--	<div class="preloader">-->
<!--		<div class="preloader-inner">-->
<!--			<div class="preloader-icon">-->
<!--				<span></span>-->
<!--				<span></span>-->
<!--			</div>-->
<!--		</div>-->
<!--	</div>-->

    <?php
        // если в сессии есть сообщение, выводим его
        if (isset($_SESSION['message'])) {
            ?>
            <div class="msg <?= $_SESSION['message']['type'] ?>">
                <p class="msg-text"><?= $_SESSION['message']['text'] ?></p>
            </div>
            <?php
        }
    ?>

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
                                    <?php
                                        foreach ($categories as $category) {
                                            ?>
                                                <li><a href="#"><?= $category['name'] ?></a></li>
                                            <?php
                                        }
                                    ?>
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

	<section class="hero-slider">
		<div class="single-slider">
			<div class="container">
				<div class="row no-gutters">
					<div class="col-lg-9 offset-lg-3 col-12">
						<div class="text-inner">
							<div class="row">
								<div class="col-lg-7 col-12">
									<div class="hero-text">
										<h1><span>UP TO 50% OFF </span>Shirt For Man</h1>
										<p>Maboriosam in a nesciung eget magnae <br> dapibus disting tloctio in the find it pereri <br> odiy maboriosm.</p>
										<div class="button">
											<a href="#" class="btn">Shop Now!</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

    <div class="product-area section">
            <div class="container">
				<div class="row">
					<div class="col-12">
						<div class="section-title">
							<h2>Trending Item</h2>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-12">
						<div class="product-info">
							<div class="nav-main">
								<ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <?php
                                        foreach ($categories as $key => $category) {
                                            ?>
                                                <li class="nav-item">
                                                    <a
                                                        class="nav-link <?= array_search($key, array_keys($categories)) === 0 ? 'active' : ''?>"
                                                        data-toggle="tab"
                                                        href="#<?= strtolower($category['name']) ?>"
                                                        role="tab"
                                                    >
                                                        <?= $category['name'] ?>
                                                    </a>
                                                </li>
                                            <?php
                                        }
                                    ?>
								</ul>
							</div>

							<div class="tab-content" id="myTabContent">
                                <?php
                                    foreach ($categories as $key => $category) {
                                        ?>
                                            <div class="tab-pane fade <?= array_search($key, array_keys($categories)) === 0 ? 'show active' : ''?>" id="<?= strtolower($category['name']) ?>" role="tabpanel">
                                                <div class="tab-single">
                                                    <div class="row">
                                                        <?php
                                                            foreach ($products as $product) {
                                                                if ($product['category_id'] === $category['id']) {
                                                                    ?>
                                                                        <div class="col-xl-3 col-lg-4 col-md-4 col-12">
                                                                            <div class="single-product">
                                                                                <div class="product-img">
                                                                                    <a href="product-details.php?id=<?= $product['id'] ?>">
                                                                                        <?php
                                                                                            if (is_null($product['image_url'])) {
                                                                                                ?>
                                                                                                    <img class="default-img" src="https://via.placeholder.com/550x750" alt="#">
                                                                                                <?php
                                                                                            } else {
                                                                                                ?>
                                                                                                    <img class="default-img" src="<?= $product['image_url'] ?>" alt="#">
                                                                                                <?php
                                                                                            }
                                                                                        ?>
                                                                                    </a>

                                                                                    <div class="button-head">
                                                                                        <div class="product-action">
                                                                                            <a title="Wishlist" href="#"><i class="ti-heart"></i><span>Add to Wishlist</span></a>
                                                                                        </div>
                                                                                        <div class="product-action-2">
                                                                                            <a title="Add to cart" href="#">Add to cart</a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="product-content">
                                                                                    <h3><a href="product-details.html"><?= $product['title'] ?></a></h3>
                                                                                    <div class="product-price">
                                                                                        <span>$<?= $product['price'] ?></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <?php
                                                                }
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                    }
                                ?>
							</div>
						</div>
					</div>
				</div>
            </div>
    </div>

	<div class="product-area most-popular section">
        <div class="container">
            <div class="row">
				<div class="col-12">
					<div class="section-title">
						<h2>Hot Item</h2>
					</div>
				</div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="owl-carousel popular-slider">
						<div class="single-product">
							<div class="product-img">
								<a href="product-details.html">
									<img class="default-img" src="https://via.placeholder.com/550x750" alt="#">
									<img class="hover-img" src="https://via.placeholder.com/550x750" alt="#">
									<span class="out-of-stock">Hot</span>
								</a>
								<div class="button-head">
									<div class="product-action">
										<a data-toggle="modal" data-target="#exampleModal" title="Quick View" href="#"><i class=" ti-eye"></i><span>Quick Shop</span></a>
										<a title="Wishlist" href="#"><i class=" ti-heart "></i><span>Add to Wishlist</span></a>
										<a title="Compare" href="#"><i class="ti-bar-chart-alt"></i><span>Add to Compare</span></a>
									</div>
									<div class="product-action-2">
										<a title="Add to cart" href="#">Add to cart</a>
									</div>
								</div>
							</div>
							<div class="product-content">
								<h3><a href="product-details.html">Black Sunglass For Women</a></h3>
								<div class="product-price">
									<span class="old">$60.00</span>
									<span>$50.00</span>
								</div>
							</div>
						</div>

						<div class="single-product">
                            <div class="product-img">
                                <a href="product-details.html">
                                    <img class="default-img" src="https://via.placeholder.com/550x750" alt="#">
                                    <img class="hover-img" src="https://via.placeholder.com/550x750" alt="#">
                                </a>
								<div class="button-head">
									<div class="product-action">
										<a data-toggle="modal" data-target="#exampleModal" title="Quick View" href="#"><i class=" ti-eye"></i><span>Quick Shop</span></a>
										<a title="Wishlist" href="#"><i class=" ti-heart "></i><span>Add to Wishlist</span></a>
										<a title="Compare" href="#"><i class="ti-bar-chart-alt"></i><span>Add to Compare</span></a>
									</div>
									<div class="product-action-2">
										<a title="Add to cart" href="#">Add to cart</a>
									</div>
								</div>
                            </div>
                            <div class="product-content">
                                <h3><a href="product-details.html">Women Hot Collection</a></h3>
                                <div class="product-price">
                                    <span>$50.00</span>
                                </div>
                            </div>
                        </div>

						<div class="single-product">
                            <div class="product-img">
                                <a href="product-details.html">
                                    <img class="default-img" src="https://via.placeholder.com/550x750" alt="#">
                                    <img class="hover-img" src="https://via.placeholder.com/550x750" alt="#">
									<span class="new">New</span>
                                </a>
								<div class="button-head">
									<div class="product-action">
										<a data-toggle="modal" data-target="#exampleModal" title="Quick View" href="#"><i class=" ti-eye"></i><span>Quick Shop</span></a>
										<a title="Wishlist" href="#"><i class=" ti-heart "></i><span>Add to Wishlist</span></a>
										<a title="Compare" href="#"><i class="ti-bar-chart-alt"></i><span>Add to Compare</span></a>
									</div>
									<div class="product-action-2">
										<a title="Add to cart" href="#">Add to cart</a>
									</div>
								</div>
                            </div>
                            <div class="product-content">
                                <h3><a href="product-details.html">Awesome Pink Show</a></h3>
                                <div class="product-price">
                                    <span>$50.00</span>
                                </div>
                            </div>
                        </div>

						<div class="single-product">
                            <div class="product-img">
                                <a href="product-details.html">
                                    <img class="default-img" src="https://via.placeholder.com/550x750" alt="#">
                                    <img class="hover-img" src="https://via.placeholder.com/550x750" alt="#">
                                </a>
								<div class="button-head">
									<div class="product-action">
										<a data-toggle="modal" data-target="#exampleModal" title="Quick View" href="#"><i class=" ti-eye"></i><span>Quick Shop</span></a>
										<a title="Wishlist" href="#"><i class=" ti-heart "></i><span>Add to Wishlist</span></a>
										<a title="Compare" href="#"><i class="ti-bar-chart-alt"></i><span>Add to Compare</span></a>
									</div>
									<div class="product-action-2">
										<a title="Add to cart" href="#">Add to cart</a>
									</div>
								</div>
                            </div>
                            <div class="product-content">
                                <h3><a href="product-details.html">Awesome Bags Collection</a></h3>
                                <div class="product-price">
                                    <span>$50.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<section class="shop-home-list section">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-md-6 col-12">
					<div class="row">
						<div class="col-12">
							<div class="shop-section-title">
								<h1>On sale</h1>
							</div>
						</div>
					</div>

					<div class="single-list">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-12">
								<div class="list-image overlay">
									<img src="https://via.placeholder.com/115x140" alt="#">
									<a href="#" class="buy"><i class="fa fa-shopping-bag"></i></a>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-12 no-padding">
								<div class="content">
									<h4 class="title"><a href="#">Licity jelly leg flat Sandals</a></h4>
									<p class="price with-discount">$59</p>
								</div>
							</div>
						</div>
					</div>

					<div class="single-list">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-12">
								<div class="list-image overlay">
									<img src="https://via.placeholder.com/115x140" alt="#">
									<a href="#" class="buy"><i class="fa fa-shopping-bag"></i></a>
								</div>
							</div>

							<div class="col-lg-6 col-md-6 col-12 no-padding">
								<div class="content">
									<h5 class="title"><a href="#">Licity jelly leg flat Sandals</a></h5>
									<p class="price with-discount">$44</p>
								</div>
							</div>
						</div>
					</div>

					<div class="single-list">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-12">
								<div class="list-image overlay">
									<img src="https://via.placeholder.com/115x140" alt="#">
									<a href="#" class="buy"><i class="fa fa-shopping-bag"></i></a>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-12 no-padding">
								<div class="content">
									<h5 class="title"><a href="#">Licity jelly leg flat Sandals</a></h5>
									<p class="price with-discount">$89</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 col-12">
					<div class="row">
						<div class="col-12">
							<div class="shop-section-title">
								<h1>Best Seller</h1>
							</div>
						</div>
					</div>

					<div class="single-list">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-12">
								<div class="list-image overlay">
									<img src="https://via.placeholder.com/115x140" alt="#">
									<a href="#" class="buy"><i class="fa fa-shopping-bag"></i></a>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-12 no-padding">
								<div class="content">
									<h5 class="title"><a href="#">Licity jelly leg flat Sandals</a></h5>
									<p class="price with-discount">$65</p>
								</div>
							</div>
						</div>
					</div>

					<div class="single-list">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-12">
								<div class="list-image overlay">
									<img src="https://via.placeholder.com/115x140" alt="#">
									<a href="#" class="buy"><i class="fa fa-shopping-bag"></i></a>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-12 no-padding">
								<div class="content">
									<h5 class="title"><a href="#">Licity jelly leg flat Sandals</a></h5>
									<p class="price with-discount">$33</p>
								</div>
							</div>
						</div>
					</div>

					<div class="single-list">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-12">
								<div class="list-image overlay">
									<img src="https://via.placeholder.com/115x140" alt="#">
									<a href="#" class="buy"><i class="fa fa-shopping-bag"></i></a>
								</div>
							</div>

							<div class="col-lg-6 col-md-6 col-12 no-padding">
								<div class="content">
									<h5 class="title"><a href="#">Licity jelly leg flat Sandals</a></h5>
									<p class="price with-discount">$77</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 col-12">
					<div class="row">
						<div class="col-12">
							<div class="shop-section-title">
								<h1>Top viewed</h1>
							</div>
						</div>
					</div>

					<div class="single-list">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-12">
								<div class="list-image overlay">
									<img src="https://via.placeholder.com/115x140" alt="#">
									<a href="#" class="buy"><i class="fa fa-shopping-bag"></i></a>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-12 no-padding">
								<div class="content">
									<h5 class="title"><a href="#">Licity jelly leg flat Sandals</a></h5>
									<p class="price with-discount">$22</p>
								</div>
							</div>
						</div>
					</div>

					<div class="single-list">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-12">
								<div class="list-image overlay">
									<img src="https://via.placeholder.com/115x140" alt="#">
									<a href="#" class="buy"><i class="fa fa-shopping-bag"></i></a>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-12 no-padding">
								<div class="content">
									<h5 class="title"><a href="#">Licity jelly leg flat Sandals</a></h5>
									<p class="price with-discount">$35</p>
								</div>
							</div>
						</div>
					</div>

					<div class="single-list">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-12">
								<div class="list-image overlay">
									<img src="https://via.placeholder.com/115x140" alt="#">
									<a href="#" class="buy"><i class="fa fa-shopping-bag"></i></a>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-12 no-padding">
								<div class="content">
									<h5 class="title"><a href="#">Licity jelly leg flat Sandals</a></h5>
									<p class="price with-discount">$99</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="shop-services section home">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6 col-12">
					<div class="single-service">
						<i class="ti-rocket"></i>
						<h4>Free shipping</h4>
						<p>Orders over $100</p>
					</div>
				</div>

				<div class="col-lg-3 col-md-6 col-12">
					<div class="single-service">
						<i class="ti-reload"></i>
						<h4>Free Return</h4>
						<p>Within 30 days returns</p>
					</div>
				</div>

				<div class="col-lg-3 col-md-6 col-12">
					<div class="single-service">
						<i class="ti-lock"></i>
						<h4>Secured Payment</h4>
						<p>100% secure payment</p>
					</div>
				</div>

				<div class="col-lg-3 col-md-6 col-12">
					<div class="single-service">
						<i class="ti-tag"></i>
						<h4>Best Price</h4>
						<p>Guaranteed price</p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="shop-newsletter section">
		<div class="container">
			<div class="inner-top">
				<div class="row">
					<div class="col-lg-8 offset-lg-2 col-12">
						<div class="inner">
							<h4>Newsletter</h4>
							<p> Subscribe to our newsletter and get <span>10%</span> off your first purchase</p>
							<form action="#" method="get" class="newsletter-inner">
								<input name="EMAIL" placeholder="Your email address" required="" type="email">
								<button class="btn">Subscribe</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Shop Newsletter -->

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
							<p class="call">Got Question? Call us 24/7<span><a href="tel:88005553535">88005553535</a></span></p>
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
								<p>Copyright © 2022 Internet Shop</p>
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
 
	<!-- Jquery -->
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.0.js"></script>
	<script src="js/jquery-ui.min.js"></script>
	<!-- Popper JS -->
	<script src="js/popper.min.js"></script>
	<!-- Bootstrap JS -->
	<script src="js/bootstrap.min.js"></script>
	<!-- Slicknav JS -->
	<script src="js/slicknav.min.js"></script>
	<!-- Owl Carousel JS -->
	<script src="js/owl-carousel.js"></script>
	<!-- Magnific Popup JS -->
	<script src="js/magnific-popup.js"></script>
	<!-- Waypoints JS -->
	<script src="js/waypoints.min.js"></script>
	<!-- Countdown JS -->
	<script src="js/finalcountdown.min.js"></script>
	<!-- Nice Select JS -->
	<script src="js/nicesellect.js"></script>
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