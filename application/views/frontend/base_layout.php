<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="Benny Kindangen" />

	<link rel="icon" href="<?=BASE_ASSET?>logo/<?=get_option('site_favicon')?>">
	<link href="https://fonts.googleapis.com/css2?family=Jura:wght@300;400;500;600;700&family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="<?=BASE_ASSET?>fastcon/css/bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="<?=BASE_ASSET?>fastcon/style.css" type="text/css" />
	<link rel="stylesheet" href="<?=BASE_ASSET?>fastcon/css/swiper.css" type="text/css" />
	<link rel="stylesheet" href="<?=BASE_ASSET?>fastcon/css/dark.css" type="text/css" />
	<link rel="stylesheet" href="<?=BASE_ASSET?>fastcon/css/font-icons.css" type="text/css" />
	<link rel="stylesheet" href="<?=BASE_ASSET?>fastcon/css/animate.css" type="text/css" />
	<link rel="stylesheet" href="<?=BASE_ASSET?>fastcon/css/magnific-popup.css" type="text/css" />
	<link rel="stylesheet" href="<?=BASE_ASSET?>fastcon/slick/slick.css" type="text/css" />
	<link rel="stylesheet" href="<?=BASE_ASSET?>fastcon/slick/slick-theme.css" type="text/css" />
	<link rel="stylesheet" href="<?=BASE_ASSET?>fastcon/css/components/bs-select.css" type="text/css" />
	<link rel="stylesheet" href="<?=BASE_ASSET?>fastcon/css/components/bs-filestyle.css" type="text/css" />

	<link rel="stylesheet" href="<?=BASE_ASSET?>fastcon/css/custom/custom.css" type="text/css" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<title><?=$title?> | Fastcon</title>

</head>

<body class="stretched fastcon-menu">
	<div id="wrapper" class="clearfix">

		<header id="header" class="full-header" data-sticky-menu-padding="32" data-menu-padding="32" data-sticky-logo-height="46" data-logo-height="46" data-mobile-sticky="true" data-mobile-logo-height="50" data-mobile-sticky-logo-height="50" data-sticky-class="not-dark">
			<div id="header-wrap">
				<div class="container">
					<div class="header-row large-only">

						<div id="logo">
							<a href="<?=site_url()?>" class="standard-logo" data-dark-logo="<?=BASE_ASSET?>logo/<?= get_option('site_logo'); ?>"><img src="<?=BASE_ASSET?>logo/<?= get_option('site_logo'); ?>" width="212" alt="<?= get_option('site_name'); ?>"></a>
							<a href="<?=site_url()?>" class="retina-logo" data-dark-logo="<?=BASE_ASSET?>logo/<?= get_option('site_logo'); ?>"><img src="<?=BASE_ASSET?>logo/<?= get_option('site_logo'); ?>" width="212" alt="<?= get_option('site_name'); ?>"></a>
						</div>

						<div class="header-misc">

							<div id="top-search" class="header-misc-icon">
								<a href="<?=site_url('products/cart')?>" ><i class="icon-line-shopping-cart"></i><i class="icon-line-cross"></i></a>
							</div>

							<div id="top-cart" class="header-misc-icon d-none d-sm-block">
								<a href="<?=site_url('member/login')?>">
									<svg width="14" height="14" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M13.6569 10.3431C12.7855 9.47181 11.7484 8.82678 10.6168 8.43631C11.8288 7.60159 12.625 6.20463 12.625 4.625C12.625 2.07478 10.5502 0 8 0C5.44978 0 3.375 2.07478 3.375 4.625C3.375 6.20463 4.17122 7.60159 5.38319 8.43631C4.25163 8.82678 3.2145 9.47181 2.34316 10.3431C0.832156 11.8542 0 13.8631 0 16H1.25C1.25 12.278 4.27803 9.25 8 9.25C11.722 9.25 14.75 12.278 14.75 16H16C16 13.8631 15.1678 11.8542 13.6569 10.3431ZM8 8C6.13903 8 4.625 6.486 4.625 4.625C4.625 2.764 6.13903 1.25 8 1.25C9.86097 1.25 11.375 2.764 11.375 4.625C11.375 6.486 9.86097 8 8 8Z" fill="#212121"/>
									</svg>
								</a>
							</div>

						</div>
						
						<nav class="primary-menu mobile-menu with-arrows on-click">

							<ul class="menu-container">
								<li class="menu-item">
									<a class="menu-link" href="<?=site_url('products')?>"><div>Products</div></a>
									<ul class="sub-menu-container">
										<li class="menu-item">
											<a class="menu-link" href="<?=site_url('products')?>"><div>Bata Ringan AAC</div></a>
										</li>
										<li class="menu-item">
											<a class="menu-link" href="<?=site_url('products')?>"><div>Mortar</div></a>
										</li>
										<li class="menu-item">
											<a class="menu-link" href="<?=site_url('products')?>"><div>Panel</div></a>
										</li>
									</ul>
								</li>
								<li class="menu-item">
									<a class="menu-link" href="<?=site_url('projects')?>"><div>Proyek</div></a>
								</li>

								<li class="menu-item active">
									<a class="menu-link" href="<?=site_url('distributor')?>"><div>Distributor</div></a>
								</li>

								<li class="menu-item">
									<a class="menu-link" href="<?=site_url('news')?>"><div>Berita</div></a>
								</li>

								<li class="menu-item">
									<a class="menu-link" href="<?=site_url('contact')?>"><div>Kontak</div></a>
								</li>
							</ul>

						</nav>

						<form class="top-search-form" action="search.html" method="get">
							<input type="text" name="q" class="form-control" value="" placeholder="Type &amp; Hit Enter.." autocomplete="off">
						</form>

					</div>

					<div class="header-row medium-small-only">

						<div class="header-misc">

							<div id="top-search" class="header-misc-icon">
								<a href="<?=site_url('products/cart')?>" ><i class="icon-line-shopping-cart"></i><i class="icon-line-cross"></i></a>
							</div>

							<div id="top-cart" class="header-misc-icon d-none d-sm-block">
								<a href="<?=site_url('member/login')?>" id="top-cart-trigger">
									<svg width="14" height="14" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M13.6569 10.3431C12.7855 9.47181 11.7484 8.82678 10.6168 8.43631C11.8288 7.60159 12.625 6.20463 12.625 4.625C12.625 2.07478 10.5502 0 8 0C5.44978 0 3.375 2.07478 3.375 4.625C3.375 6.20463 4.17122 7.60159 5.38319 8.43631C4.25163 8.82678 3.2145 9.47181 2.34316 10.3431C0.832156 11.8542 0 13.8631 0 16H1.25C1.25 12.278 4.27803 9.25 8 9.25C11.722 9.25 14.75 12.278 14.75 16H16C16 13.8631 15.1678 11.8542 13.6569 10.3431ZM8 8C6.13903 8 4.625 6.486 4.625 4.625C4.625 2.764 6.13903 1.25 8 1.25C9.86097 1.25 11.375 2.764 11.375 4.625C11.375 6.486 9.86097 8 8 8Z" fill="#212121"/>
									</svg>
								</a>
							</div>

						</div>

						<div id="logo">
							<a href="index.html" class="standard-logo" data-dark-logo="<?=BASE_ASSET?>logo/<?= get_option('site_logo'); ?>"><img src="<?=BASE_ASSET?>logo/<?= get_option('site_logo'); ?>" width="212" alt="<?= get_option('site_name'); ?>"></a>
							<a href="index.html" class="retina-logo" data-dark-logo="<?=BASE_ASSET?>logo/<?= get_option('site_logo'); ?>"><img src="<?=BASE_ASSET?>logo/<?= get_option('site_logo'); ?>" width="212" alt="<?= get_option('site_name'); ?>"></a>
						</div>

						<div id="primary-menu-trigger">
							<svg class="svg-trigger" viewBox="0 0 100 100"><path d="m 30,33 h 40 c 3.722839,0 7.5,3.126468 7.5,8.578427 0,5.451959 -2.727029,8.421573 -7.5,8.421573 h -20"></path><path d="m 30,50 h 40"></path><path d="m 70,67 h -40 c 0,0 -7.5,-0.802118 -7.5,-8.365747 0,-7.563629 7.5,-8.634253 7.5,-8.634253 h 20"></path></svg>
						</div>

						<nav class="primary-menu">

							<ul class="menu-container">
								<li class="menu-item">
									<a class="menu-link" href="<?=site_url('products')?>"><div>Products</div></a>
									<ul class="sub-menu-container">
										<li class="menu-item">
											<a class="menu-link" href="<?=site_url('products')?>"><div>Bata Ringan AAC</div></a>
										</li>
										<li class="menu-item">
											<a class="menu-link" href="<?=site_url('products')?>"><div>Mortar</div></a>
										</li>
										<li class="menu-item">
											<a class="menu-link" href="<?=site_url('products')?>"><div>Panel</div></a>
										</li>
									</ul>
								</li>

								<li class="menu-item">
									<a class="menu-link" href="<?=site_url('projects')?>"><div>Proyek</div></a>
								</li>

								<li class="menu-item">
									<a class="menu-link" href="<?=site_url('distributor')?>"><div>Distributor</div></a>
								</li>

								<li class="menu-item">
									<a class="menu-link" href="<?=site_url('news')?>"><div>Berita</div></a>
								</li>

								<li class="menu-item">
									<a class="menu-link" href="<?=site_url('contact')?>"><div>Kontak</div></a>
								</li>
							</ul>

						</nav>

						<form class="top-search-form" action="search.html" method="get">
							<input type="text" name="q" class="form-control" value="" placeholder="Type &amp; Hit Enter.." autocomplete="off">
						</form>

					</div>
				</div>
			</div>
			<div class="header-wrap-clone"></div>
		</header>

		<?php $this->load->view($view)?>

		<div class="whatsapp-wrap">
			<div class="container">
				<div class="col-12 d-flex justify-content-end">
					<img src="<?=BASE_ASSET?>fastcon/img/icons/whatsapp-big.png" alt="">
				</div>
			</div>
		</div>
		<footer id="footer">
			<div class="container">

				<div class="footer-widgets-wrap">
					<div class="row col-mb-50">
						<div class="col-lg-2">
							<div class="row col-mb-50">
								<div class="col-12">

									<div class="widget clearfix">
										<a href="<?=site_url()?>">
											<img src="<?=BASE_ASSET?>logo/<?= get_option('site_logo'); ?>" width="160" alt="<?= get_option('site_name'); ?>" class="footer-logo">
										</a>
									</div>

								</div>
							</div>
						</div>
						
						<div class="col-lg-10">
							<div class="row col-mb-50">
								<div class="col-12">
									<div class="row">
										<div class="col-lg-6 col-md-12">
											<div class="row">
												<div class="col-sm-6 footer-column">
													<h4 class="fastcon-h4 cl-grey-900">Kontak Kami</h4>
													<p class="fastcon-body">Gwalk Shop Houses A1-No. 2
														Citraland - Surabaya
														<br>
														<br>
														<br>
														<a href="tel:0317421270" class="cl-grey-900"><b>(031)</b> 7421270</a>
													</p>
												</div>
												<div class="col-sm-6 footer-column">
													<h4 class="fastcon-h4 cl-grey-900">Pabrik Kami</h4>
													<p class="fastcon-body">Jl. Raya Tarik No.Km, RW.1, Waru, Waruberon, Kec. BalongBendo, Kabupaten Sidoarjo, Jawa Timur 61263
														<br>
														<br>
														<br>
														<a href="tel:0318986336" class="cl-grey-900"><b>(031)</b> 8986336
													</p>
						
												</div>
											</div>
										</div>
	
										<div class="col-lg-6 col-md-12">
											<div class="row">
												<div class="col-lg-5 col-sm-6 footer-column">
													<a href="<?=site_url('calc')?>" class="fastcon-nav cl-grey-900">Kalkulator acc</a>

													<a href="<?=site_url('about-us')?>" class="fastcon-nav cl-grey-900">Tentang Kami</a>

													<a href="<?=site_url('products')?>" class="fastcon-nav cl-grey-900">Produk</a>

													<a href="<?=site_url('projects')?>" class="fastcon-nav cl-grey-900">Proyek</a>

													<a href="<?=site_url('distributor')?>" class="fastcon-nav cl-grey-900">Distributor</a>
												</div>
												<div class="col-lg-7 col-sm-6 footer-column">
													<h4 class="fastcon-h4 cl-grey-900">Marketplace Kami</h4>
													
													<div class="mp-icons">
														<img src="<?=BASE_ASSET?>fastcon/img/icons/tokped.png" alt="">
														<img src="<?=BASE_ASSET?>fastcon/img/icons/shopee.png" alt="">
													</div>

													<h4 class="fastcon-h4">Kualifikasi Kami</h4>
													<img src="<?=BASE_ASSET?>fastcon/img/iso.png" alt="Fastcon ISO" class="iso-img">
						
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row cr-wrap">
						<div class="col-md-6 col-sm-12 language">
							<p class="fastcon-description">Pilih bahasa: <img src="<?=BASE_ASSET?>fastcon/img/icons/ID.png" alt=""></p>
						</div>
						<div class="col-md-6 col-sm-12 cr">
							<p class="fastcon-description cl-grey-600">©2021 FASTCON. All Rights Reserved</p>
						</div>
					</div>
				</div>
			</div>

		</footer>

	</div>

	<script src="<?=BASE_ASSET?>fastcon/js/jquery.js"></script>
	<script src="<?=BASE_ASSET?>fastcon/js/plugins.min.js"></script>

	<script src="<?=BASE_ASSET?>fastcon/js/functions.js"></script>

	<script src="<?=BASE_ASSET?>fastcon/js/components/bs-filestyle.js"></script>
	<script src="<?=BASE_ASSET?>fastcon/js/components/bs-select.js"></script>

	<script src="<?=BASE_ASSET?>fastcon/slick/slick.js"></script>
	<script src="<?=BASE_ASSET?>fastcon/js/custom.js"></script>

</body>
</html>