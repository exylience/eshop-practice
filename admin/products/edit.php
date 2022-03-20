<?php
// запускаем сессию
session_start();
// импортируем файл с подключением к БД
require_once '../../includes/db.php';

// если пользователь НЕ аутентифицирован или НЕ является админом, переносим его на главную
if (
    !isset($_SESSION['user']) ||
    $_SESSION['user']['group'] !== 2
) {
    header('Location: /index.php');
}

// получаем id товара из GET параметра
$id = $_GET['id'];

// составляем запрос на получение записи из таблицы
$query = "SELECT 
       `products`.`id`, `products`.`title`, `products`.`description`, `products`.`price`, `products`.`image_url`,
       `products`.`category_id` 
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
    header('Location: /admin/products/index.php');
}

// составляем запрос на выборку всех категорий
$query = "SELECT * FROM `categories`";
// выполняем запрос
$response = mysqli_query($db, $query);
// парсим полученные категории в ассоциативный массив
$categories = mysqli_fetch_all($response, MYSQLI_ASSOC);
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
	<link rel="icon" type="image/png" href="../../images/favicon.png">
	<!-- Web Font -->
	<link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
	
	<!-- StyleSheet -->
	
	<!-- Bootstrap -->
	<link rel="stylesheet" href="../../css/bootstrap.css">
	<!-- Magnific Popup -->
    <link rel="stylesheet" href="../../css/magnific-popup.min.css">
	<!-- Font Awesome -->
    <link rel="stylesheet" href="../../css/font-awesome.css">
	<!-- Fancybox -->
	<link rel="stylesheet" href="../../css/jquery.fancybox.min.css">
	<!-- Themify Icons -->
    <link rel="stylesheet" href="../../css/themify-icons.css">
	<!-- Nice Select CSS -->
    <link rel="stylesheet" href="../../css/niceselect.css">
	<!-- Animate CSS -->
    <link rel="stylesheet" href="../../css/animate.css">
	<!-- Flex Slider CSS -->
    <link rel="stylesheet" href="../../css/flex-slider.min.css">
	<!-- Owl Carousel -->
    <link rel="stylesheet" href="../../css/owl-carousel.css">
	<!-- Slicknav -->
    <link rel="stylesheet" href="../../css/slicknav.min.css">
	
	<!-- Eshop StyleSheet -->
	<link rel="stylesheet" href="../../css/reset.css">
	<link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="../../css/responsive.css">
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
								<li><i class="ti-user"></i> <a href="#">My account</a></li>
								<li><i class="ti-power-off"></i><a href="login.html#">Logout</a></li>
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
							<a href="index.php"><img src="../../images/logo.png" alt="logo"></a>
						</div>

						<div class="mobile-nav"></div>
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
								<h3 class="cat-heading"><i class="fa fa-bolt" aria-hidden="true"></i>Admin Panel</h3>
							</div>
						</div>

						<div class="col-lg-9 col-12">
							<div class="menu-area">
								<nav class="navbar navbar-expand-lg">
									<div class="navbar-collapse">
										<div class="nav-inner">
											<ul class="nav main-menu menu navbar-nav">
												<li><a href="../../index.php">Home</a></li>
												<li><a href="../categories/index.php">Categories</a></li>
												<li class="active"><a href="index.php">Products</a></li>
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
				<div class="col-12 d-flex justify-content-between align-items-center">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="../../index.php">Home<i class="ti-arrow-right"></i></a></li>
							<li><a href="#">Admin Panel<i class="ti-arrow-right"></i></a></li>
							<li><a href="index.php">Products<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="#">Edit Product</a></li>
						</ul>
					</div>

					<div class="navbar-links">
						<a href="add.php"><i class="ti-plus mr-2"></i> Create Product</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<section id="contact-us" class="contact-us section">
		<div class="container">
			<div class="contact-head">
				<div class="row justify-content-center">
					<div class="col-lg-8 col-12">
						<div class="form-main">
							<form class="form" method="post" action="../../vendor/products/edit.php" enctype="multipart/form-data">
								<div class="row">
									<div class="col-lg-12 col-12">
										<div class="form-group">
                                            <!-- раскидываем данные по инпутам -->
											<label>Product Name<span>*</span></label>
											<input name="title" type="text" value="<?= $product['title'] ?>" required>
										</div>
									</div>

									<div class="col-lg-12 col-12">
										<div class="form-group">
											<label>Product Image</label>
											<input name="image" type="file">
                                            <!-- скрытый инпут для передачи в обработчик картинки товара -->
											<input name="image_url" type="hidden" value="<?= $product['image_url'] ?>">
										</div>
									</div>

									<div class="col-12">
										<div class="form-group">
											<label>Price<span>*</span></label>
											<input name="price" type="number" value="<?= $product['price'] ?>" required>
										</div>
									</div>

									<div class="col-12">
										<div class="form-group message">
											<label>Description<span>*</span></label>
											<textarea name="description"><?= $product['description'] ?></textarea>
										</div>
									</div>

									<div class="col-12">
										<div class="form-group">
											<label>Category<span>*</span></label>
											<select name="category_id" id="category">
                                                <?php
                                                    // перебираем в цикле все категории и выводим в выпадающий список в качестве пунктов
                                                    foreach ($categories as $category) {
                                                        ?>
                                                            <option
                                                                value="<?= $category['id'] ?>"
                                                                <?= (int)$product['category_id'] === (int)$category['id'] ? 'selected="selected"' : '' ?>
                                                            >
                                                                <?= $category['name'] ?>
                                                            </option>
                                                        <?php
                                                    }
                                                ?>
											</select>
										</div>
									</div>

                                    <!-- скрытый инпут для передачи в обработчик id товара -->
                                    <input name="id" type="hidden" value="<?= $product['id'] ?>">

									<div class="col-12">
										<div class="form-group button">
											<button type="submit" class="btn">Create</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<footer class="footer">
		<div class="copyright">
			<div class="container">
				<div class="inner">
					<div class="row">
						<div class="col-lg-6 col-12">
							<div class="left">
								<p>Copyright © 2022 EShop</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<!-- /End Footer Area -->
	
	<!-- Jquery -->
    <script src="../../js/jquery.min.js"></script>
    <script src="../../js/jquery-migrate-3.0.0.js"></script>
	<script src="../../js/jquery-ui.min.js"></script>
	<!-- Popper JS -->
	<script src="../../js/popper.min.js"></script>
	<!-- Bootstrap JS -->
	<script src="../../js/bootstrap.min.js"></script>
	<!-- Color JS -->
	<script src="../../js/colors.js"></script>
	<!-- Slicknav JS -->
	<script src="../../js/slicknav.min.js"></script>
	<!-- Owl Carousel JS -->
	<script src="../../js/owl-carousel.js"></script>
	<!-- Magnific Popup JS -->
	<script src="../../js/magnific-popup.js"></script>
	<!-- Fancybox JS -->
	<script src="../../js/facnybox.min.js"></script>
	<!-- Waypoints JS -->
	<script src="../../js/waypoints.min.js"></script>
	<!-- Countdown JS -->
	<script src="../../js/finalcountdown.min.js"></script>
	<!-- Nice Select JS -->
	<script src="../../js/nicesellect.js"></script>
	<!-- Ytplayer JS -->
	<script src="../../js/ytplayer.min.js"></script>
	<!-- Flex Slider JS -->
	<script src="../../js/flex-slider.js"></script>
	<!-- ScrollUp JS -->
	<script src="../../js/scrollup.js"></script>
	<!-- Onepage Nav JS -->
	<script src="../../js/onepage-nav.min.js"></script>
	<!-- Easing JS -->
	<script src="../../js/easing.js"></script>
	<!-- Active JS -->
	<script src="../../js/active.js"></script>
</body>
</html>