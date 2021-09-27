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
		<?php if (isset($line) AND $line==true): ?>
			<div class="border-wrapper">
				<div class="background-border"></div>
				<div class="background-border"></div>
				<div class="background-border"></div>
			</div>
		<?php endif ?>

		<header id="header" class="full-header" data-sticky-menu-padding="32" data-menu-padding="32" data-sticky-logo-height="46" data-logo-height="46" data-mobile-sticky="true" data-mobile-logo-height="50" data-mobile-sticky-logo-height="50" data-sticky-class="not-dark">
			<div id="header-wrap">
				<div class="container">
					<div class="header-row large-only">

						<div id="logo">
							<a href="<?=site_url()?>" class="standard-logo" data-dark-logo="<?=BASE_ASSET?>logo/<?= get_option('site_logo'); ?>"><img src="<?=BASE_ASSET?>logo/<?= get_option('site_logo'); ?>" width="212" alt="<?= get_option('site_name'); ?>"></a>
							<a href="<?=site_url()?>" class="retina-logo" data-dark-logo="<?=BASE_ASSET?>logo/<?= get_option('site_logo'); ?>"><img src="<?=BASE_ASSET?>logo/<?= get_option('site_logo'); ?>" width="212" alt="<?= get_option('site_name'); ?>"></a>
						</div>

						<?php if (!isset($checkout)): ?>
							
							<div class="header-misc">

								<div id="top-search" class="header-misc-icon">
									<a href="<?=site_url('products/cart')?>" ><i class="icon-line-shopping-cart <?=$cart_badge?'cart-not-empty':''?>"></i></a>
								</div>

								<div id="top-cart" class="header-misc-icon d-none d-sm-flex align-items-center">
									<a href="<?=site_url('login')?>">
										<svg width="14" height="14" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M13.6569 10.3431C12.7855 9.47181 11.7484 8.82678 10.6168 8.43631C11.8288 7.60159 12.625 6.20463 12.625 4.625C12.625 2.07478 10.5502 0 8 0C5.44978 0 3.375 2.07478 3.375 4.625C3.375 6.20463 4.17122 7.60159 5.38319 8.43631C4.25163 8.82678 3.2145 9.47181 2.34316 10.3431C0.832156 11.8542 0 13.8631 0 16H1.25C1.25 12.278 4.27803 9.25 8 9.25C11.722 9.25 14.75 12.278 14.75 16H16C16 13.8631 15.1678 11.8542 13.6569 10.3431ZM8 8C6.13903 8 4.625 6.486 4.625 4.625C4.625 2.764 6.13903 1.25 8 1.25C9.86097 1.25 11.375 2.764 11.375 4.625C11.375 6.486 9.86097 8 8 8Z" fill="#212121"/>
										</svg>
									</a>
									<?php if ($this->session->userdata('member') AND isset($member)): ?>
										<span class="member_initial"><?=strtoupper(substr($member->fullname, 0, 2)) ?></span>
									<?php endif ?>
								</div>

							</div>
							
							<nav class="primary-menu mobile-menu with-arrows on-click">

								<ul class="menu-container">
									<li class="menu-item <?=$active=='product'?'active':''?>">
										<a class="menu-link" href="javascript:void(0)"><div><?=lang('product')?></div></a>
										<ul class="sub-menu-container">
											<li class="menu-item">
												<a class="menu-link" href="<?=site_url('products')?>"><div><?=lang('all_products')?></div></a>
											</li>
											<?php foreach ($product_category as $pc): ?>
												<li class="menu-item">
													<a class="menu-link" href="<?=site_url('products')?>"><div><?=$lang=='indonesian'?$pc->category_name:$pc->category_name_en?></div></a>
												</li>
											<?php endforeach ?>
										</ul>
									</li>
									<li class="menu-item <?=$active=='project'?'active':''?>">
										<a class="menu-link" href="<?=site_url('projects')?>"><div><?=lang('project')?></div></a>
									</li>

									<li class="menu-item <?=$active=='dist'?'active':''?>">
										<a class="menu-link" href="<?=site_url('distributor')?>"><div><?=lang('distributor')?></div></a>
									</li>

									<li class="menu-item <?=$active=='news'?'active':''?>">
										<a class="menu-link" href="<?=site_url('news')?>"><div><?=lang('news')?></div></a>
									</li>

									<li class="menu-item <?=$active=='contact'?'active':''?>">
										<a class="menu-link" href="<?=site_url('contact')?>"><div><?=lang('contact')?></div></a>
									</li>
								</ul>

							</nav>
						<?php endif ?>


					</div>

					<div class="header-row medium-small-only">

						<div class="header-misc">

							<?php if (!isset($checkout)): ?>

								<div id="top-search" class="header-misc-icon">
									<a href="<?=site_url('products/cart')?>" ><i class="icon-line-shopping-cart <?=$cart_badge?'cart-not-empty':''?>"></i></a>
								</div>

								<div class="header-misc-icon d-none d-sm-flex align-items-center">
									<a href="<?=site_url('login')?>">
										<svg width="14" height="14" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M13.6569 10.3431C12.7855 9.47181 11.7484 8.82678 10.6168 8.43631C11.8288 7.60159 12.625 6.20463 12.625 4.625C12.625 2.07478 10.5502 0 8 0C5.44978 0 3.375 2.07478 3.375 4.625C3.375 6.20463 4.17122 7.60159 5.38319 8.43631C4.25163 8.82678 3.2145 9.47181 2.34316 10.3431C0.832156 11.8542 0 13.8631 0 16H1.25C1.25 12.278 4.27803 9.25 8 9.25C11.722 9.25 14.75 12.278 14.75 16H16C16 13.8631 15.1678 11.8542 13.6569 10.3431ZM8 8C6.13903 8 4.625 6.486 4.625 4.625C4.625 2.764 6.13903 1.25 8 1.25C9.86097 1.25 11.375 2.764 11.375 4.625C11.375 6.486 9.86097 8 8 8Z" fill="#212121"/>
										</svg>
									</a>
									<?php if ($this->session->userdata('member') AND isset($member)): ?>
										<span class="member_initial"><?=strtoupper(substr($member->fullname, 0, 2)) ?></span>
									<?php endif ?>
								</div>
							<?php endif ?>

						</div>

						<div id="logo">
							<a href="<?=site_url()?>" class="standard-logo" data-dark-logo="<?=BASE_ASSET?>logo/<?= get_option('site_logo'); ?>"><img src="<?=BASE_ASSET?>logo/<?= get_option('site_logo'); ?>" width="212" alt="<?= get_option('site_name'); ?>"></a>
							<a href="<?=site_url()?>" class="retina-logo" data-dark-logo="<?=BASE_ASSET?>logo/<?= get_option('site_logo'); ?>"><img src="<?=BASE_ASSET?>logo/<?= get_option('site_logo'); ?>" width="212" alt="<?= get_option('site_name'); ?>"></a>
						</div>


						<?php if (!isset($checkout)): ?>
							<div id="primary-menu-trigger">
								<svg class="svg-trigger" viewBox="0 0 100 100"><path d="m 30,33 h 40 c 3.722839,0 7.5,3.126468 7.5,8.578427 0,5.451959 -2.727029,8.421573 -7.5,8.421573 h -20"></path><path d="m 30,50 h 40"></path><path d="m 70,67 h -40 c 0,0 -7.5,-0.802118 -7.5,-8.365747 0,-7.563629 7.5,-8.634253 7.5,-8.634253 h 20"></path></svg>
							</div>
						<?php endif ?>

						<nav class="primary-menu">
							<ul class="account-link-wrap small-only <?=$this->session->userdata('member')!=null?'logged_in':''?>">
								<div class="container">
									<li class="menu-item">
										<a href="<?=site_url('login')?>">
											<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M13.6569 10.3431C12.7855 9.47181 11.7484 8.82678 10.6168 8.43631C11.8288 7.60159 12.625 6.20463 12.625 4.625C12.625 2.07478 10.5502 0 8 0C5.44978 0 3.375 2.07478 3.375 4.625C3.375 6.20463 4.17122 7.60159 5.38319 8.43631C4.25163 8.82678 3.2145 9.47181 2.34316 10.3431C0.832156 11.8542 0 13.8631 0 16H1.25C1.25 12.278 4.27803 9.25 8 9.25C11.722 9.25 14.75 12.278 14.75 16H16C16 13.8631 15.1678 11.8542 13.6569 10.3431ZM8 8C6.13903 8 4.625 6.486 4.625 4.625C4.625 2.764 6.13903 1.25 8 1.25C9.86097 1.25 11.375 2.764 11.375 4.625C11.375 6.486 9.86097 8 8 8Z" fill="#212121"/>
											</svg>
											<?=($this->session->userdata('member')!=null AND isset($member))?$member->fullname:'Sudah Punya Akun?'?>
										</a>
									</li>
								</div>
							</ul>
							<ul class="menu-container">
								<li class="menu-item <?=$active=='product'?'active':''?>">
									<a class="menu-link" href="<?=site_url('products')?>"><div><?=lang('product')?></div></a>
									<ul class="sub-menu-container">
										<li class="menu-item">
											<a class="menu-link" href="<?=site_url('products')?>"><div><?=lang('all_products')?></div></a>
										</li>
										<?php foreach ($product_category as $pc): ?>
											<li class="menu-item">
												<a class="menu-link" href="<?=site_url('products')?>"><div><?=$lang=='indonesian'?$pc->category_name:$pc->category_name_en?></div></a>
											</li>
										<?php endforeach ?>
									</ul>
								</li>

								<li class="menu-item <?=$active=='project'?'active':''?>">
									<a class="menu-link" href="<?=site_url('projects')?>"><div><?=lang('project')?></div></a>
								</li>

								<li class="menu-item <?=$active=='dist'?'active':''?>">
									<a class="menu-link" href="<?=site_url('distributor')?>"><div><?=lang('distributor')?></div></a>
								</li>

								<li class="menu-item <?=$active=='news'?'active':''?>">
									<a class="menu-link" href="<?=site_url('news')?>"><div><?=lang('news')?></div></a>
								</li>

								<li class="menu-item <?=$active=='contact'?'active':''?>">
									<a class="menu-link" href="<?=site_url('contact')?>"><div><?=lang('contact')?></div></a>
								</li>
							</ul>

						</nav>
					</div>
				</div>
			</div>
			<div class="header-wrap-clone"></div>
		</header>

		<?php $this->load->view($view)?>

		<footer id="footer">
			<div class="container">

				<div class="footer-widgets-wrap">
					<div class="row col-mb-50">
						<div class="col-lg-2 col-md-4">
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
						
						<div class="col-lg-10 col-md-8">
							<div class="row col-mb-50">
								<div class="col-12">
									<div class="row">
										<div class="col-lg-6 col-md-12">
											<div class="row">
												<div class="col-sm-6 footer-column fastcon-footer-about">
													<h4 class="fastcon-h4 cl-grey-900"><?=lang('contact_us')?></h4>
													<?php foreach ($contact_settings as $cs): ?>
														<?php if ($cs->setting_item=='office'): ?>
															<?=$cs->setting_value?>

															<a href="tel:<?=$cs->phone?>" class="fastcon-body">
																<img src="<?=BASE_ASSET?>fastcon/img/icons/phone-call.svg" style="margin-right: 8px;" width="16" alt="phone">
																<?=$cs->phone?>
															</a>
														<?php endif ?>
													<?php endforeach ?>
												</div>
												<div class="col-sm-6 footer-column fastcon-footer-about">
													<h4 class="fastcon-h4 cl-grey-900"><?=lang('our_factory')?></h4>
													<?php foreach ($contact_settings as $cs): ?>
														<?php if ($cs->setting_item=='factory'): ?>
															<?=$cs->setting_value?>

															<a href="tel:<?=$cs->phone?>" class="fastcon-body">
																<img src="<?=BASE_ASSET?>fastcon/img/icons/phone-call.svg" style="margin-right: 8px;" width="16" alt="phone">
																<?=$cs->phone?>
															</a>
														<?php endif ?>
													<?php endforeach ?>
												</div>
											</div>
										</div>
	
										<div class="col-lg-6 col-md-12">
											<div class="row">
												<div class="col-lg-5 col-sm-6 footer-column">
													<a href="<?=site_url('calc')?>" class="fastcon-nav cl-grey-900"><?=lang('calculator')?></a>

													<a href="<?=site_url('about')?>" class="fastcon-nav cl-grey-900"><?=lang('about_us')?></a>

													<a href="<?=site_url('products')?>" class="fastcon-nav cl-grey-900"><?=lang('product')?></a>

													<a href="<?=site_url('projects')?>" class="fastcon-nav cl-grey-900"><?=lang('project')?></a>

													<a href="<?=site_url('distributor')?>" class="fastcon-nav cl-grey-900"><?=lang('distributor')?></a>

													<?php foreach ($pages as $p): ?>
														<a href="<?=site_url('page/'.$p->id.'/'.$p->slug)?>" class="fastcon-nav cl-grey-900"><?=$lang=='indonesian'?$p->title:$p->title_en?></a>
													<?php endforeach ?>
												</div>
												<div class="col-lg-7 col-sm-6 footer-column">
													<h4 class="fastcon-h4 cl-grey-900"><?=lang('our_marketplace')?></h4>
													
													<div class="mp-icons">
														<?php foreach ($marketplace as $mp): ?>
															<a href="<?=$mp->link?>" target="_blank"><img src="<?=site_url('uploads/fastcon_marketplace/'.$mp->icon)?>" alt=""></a>
														<?php endforeach ?>
													</div>

													<h4 class="fastcon-h4"><?=lang('our_qualification')?></h4>
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
							<?php 
								$current_lang = $this->session->userdata('fastcon_lang');
								$lang_toset = $current_lang=='indonesian'?'english':'indonesian';
							?>
							<p class="fastcon-description"><?=lang('select_language')?>: <a href="<?=site_url('pages/set_lang/'.$lang_toset)?>"><img src="<?=BASE_ASSET?>fastcon/img/icons/<?=$current_lang=='indonesian'?'ID':'EN'?>.png" alt=""></p></a> 
						</div>
						<div class="col-md-6 col-sm-12 cr">
							<p class="fastcon-description cl-grey-600">©2021 FASTCON. All Rights Reserved</p>
						</div>
					</div>
				</div>
			</div>

		</footer>

	</div>

	<div class="modal fade logout-modal" id="logout_modal" tabindex="-1" role="dialog" aria-labelledby="logoutModal" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-body">
				<div class="modal-content">
					<div class="modal-body">
						<h2 class="fastcon-h2 cl-grey-900 text-uppercase text-center mb-20">LOG OUT</h2>

						<p class="fastcon-body-large cl-grey-900 text-center"><?=lang('logout_title')?></p>
						
						<div class="btn-wrap">
							<a href="javascript:void(0)" class="fastcon-btn primary-btn" data-dismiss="modal" aria-hidden="true"><?=lang('discard')?></a>
							<a href="<?=site_url('member/logout')?>" class="fastcon-btn secondary-error-btn"><?=lang('logout')?></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade logout-modal" id="delete_address_modal" tabindex="-1" role="dialog" aria-labelledby="logoutModal" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-body">
				<div class="modal-content">
					<div class="modal-body">
						<h2 class="fastcon-h2 cl-grey-900 text-uppercase text-center mb-20"><?=lang('remove_address')?></h2>

						<p class="fastcon-body-large cl-grey-900 text-center"><?=lang('remove_address_title')?></p>
						
						<div class="btn-wrap">
							<a href="javascript:void(0)" class="fastcon-btn primary-btn" data-dismiss="modal" aria-hidden="true"><?=lang('discard')?></a>
							<a class="fastcon-btn secondary-error-btn remove-btn"><?=lang('remove')?></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="whatsapp-wrap">
		<?php foreach ($contact_settings as $cs): ?>
			<?php if ($cs->setting_item=='whatsapp'): ?>
				<a href="https://wa.me/<?=urlencode($cs->phone)?>?text=<?=urlencode(strip_tags($cs->setting_value))?>" target="_blank">
					<img src="<?=BASE_ASSET?>fastcon/img/icons/whatsapp-big.png" alt="">
				</a>
			<?php endif ?>
		<?php endforeach ?>
	</div>

	<script>
		const base_url = '<?=site_url()?>';
		const active_page = '<?=$active?>';
		const csrf_name = '<?=$this->security->get_csrf_token_name(); ?>';
		const csrf_val = '<?=$this->security->get_csrf_hash(); ?>';
		const lang = '<?=$lang?>';
		const member = '<?=$this->session->userdata('member')?$this->session->userdata("member")["member_id"]:""?>';
	</script>

	<script src="<?=BASE_ASSET?>fastcon/js/jquery.js"></script>
	<script src="<?=BASE_ASSET?>fastcon/js/plugins.min.js"></script>

	<script src="<?=BASE_ASSET?>fastcon/js/functions.js"></script>

	<script src="<?=BASE_ASSET?>fastcon/js/components/bs-filestyle.js"></script>
	<script src="<?=BASE_ASSET?>fastcon/js/components/bs-select.js"></script>

	<script src="<?=BASE_ASSET?>fastcon/slick/slick.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
	
	<script src="<?=BASE_ASSET?>fastcon/js/custom.js"></script>

</body>
</html>