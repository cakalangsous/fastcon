<section id="content">
	<div class="content-wrap pt-0 ">
		<div class="row clearfix hero-section-wrap">
			<div class="col-lg-6 hero-section hero-section_info">
				<div class="hero-section_info-wrap">
					<div class="border-bottom-0">
						<h1 class="fastcon-h1"><?=$lang=='indonesian'?$banner->title:$banner->title_en ?></h1>
					</div>
					<p class="fastcon-body-large"><?=$lang=='indonesian'?$banner->caption:$banner->caption_en ?></p>
				</div>
				<div class="hero-section_info-btn">
					<a href="<?=site_url('products')?>" class="fastcon-btn primary-btn"><?=lang('see_product')?></a>
					<a href="<?=site_url('contact')?>" class="fastcon-btn secondary-btn"><?=lang('contact_us')?></a>
				</div>
				<div class="hero-section_info-iso">
					<img src="<?=BASE_ASSET?>fastcon/img/iso.png" alt="Fastcon ISO" class="iso-img">
				</div>
			</div>

			<div class="col-lg-6 center hero-section hero-section_bg">
				<div class="hero-bg-wrap">
					<img src="<?=site_url('uploads/fastcon_banner/'.$banner->bg_img)?>" class="hero-bg" alt="Fastcon">
					<img src="<?=site_url('uploads/fastcon_banner/'.$banner->fg_img)?>" class="hero-img" alt="Fastcon Hero">
				</div>
			</div>
		</div>

		<div class="container">
			<div class="row clearfix">
				<div class="col-12">
					<div class="row fastcon-benefits">
						<div class="col-12">
							<h2 class="fastcon-h2 text-uppercase"> <?=$this->session->userdata('language');?> <?=lang('benefits_of_fastcon')?></h2>
						</div>
						<div class="benefits-wrap">
							<?php foreach ($bennefits as $b): ?>
								
								<div class="col-lg-4 col-md-12 benefits-item">
									<div class="benefits-icon">
										<img src="<?=site_url('uploads/fastcon_benefits/'.$b->image)?>" alt="<?=$b->title?>">
									</div>
									<div class="benefits-item_desc">
										<h3 class="fastcon-h3 text-uppercase"><?=$lang=='indonesian'?$b->title:$b->title_en ?></h3>
										<p class="fastcon-body">
											<?=$lang=='indonesian'?$b->caption:$b->caption_en ?>
										</p>
									</div>
								</div>

							<?php endforeach ?>

						</div>
					</div>
				</div>
			</div>

			<div class="row clearfix our-location">
				<div class="col-12 text-center">
					<h2 class="fastcon-h2 text-uppercase"><?=lang('distribution_network')?></h2>

					<img src="<?=site_url('uploads/fastcon_our_location/'.$location->image)?>" alt="Fastcon Location">
				</div>
			</div>

			<div class="post-carousel-title">
				<div class="carousel-title">
					<h2 class="fastcon-h2 text-uppercase"><?=lang('industrial_sector')?></h2>
				</div>
				<div class="carousel-nav">
					<div class="fastcon-slick-nav">
						<button type="button" role="presentation" class="owl-prev disabled">
							<i class="icon-angle-left"></i>
						</button>

						<button type="button" role="presentation" class="owl-next">
							<i class="icon-angle-right"></i>
						</button>
					</div>
				</div>
			</div>
		</div><!-- .container end -->

		<div class="fastcon-post-home">
			<div class="container">
				<div class="fastcon-post fastcon-slick">

					<?php foreach ($projects as $p): ?>
						
						<div class="fastcon-post-item">
							<div class="post-img">
								<a href="<?=site_url('projects/details/'.$p->id.'/'.$p->slug)?>">
									<img src="<?=site_url('uploads/fastcon_projects/'. explode(',', $p->images)[0])?>" alt="">
								</a>
								<div class="overlay"></div>
							</div>
		
		
							<div class="fastcon-post-info">
								<?php 
									$pc = db_get_row_data('fastcon_project_category', ['category_id' => $p->category]);
								?>
								<p class="fastcon-description"><?=$lang=='indonesian'?$pc->category_name:$pc->category_name_en?></p>
		
								<a href="<?=site_url('projects/details/'.$p->id.'/'.$p->slug)?>">
									<h3 class="fastcon-h3 text-uppercase"><?=$lang=='indonesian'?$p->title:$p->title_en?></h3>
								</a>
								<?=$lang=='indonesian'?$p->short_desc:$p->short_desc_en?>
							</div>
						</div>

					<?php endforeach ?>

				</div>
			</div>
		</div>

		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h2 class="fastcon-h2"><?=lang('our_news')?></h2>
				</div>
			</div>
			<div class="row fastcon-news fastcon-news-home">
				<?php foreach ($news as $n): ?>
					
					<div class="col-lg-4 col-md-6 col-sm-12 fastcon-news-item">
						<div class="news-img">
							<a href="<?=site_url('news/details/'.$n->id.'/'.$n->slug)?>">
								<img src="<?=site_url('uploads/fastcon_news/'.$n->image)?>" alt="">
								<div class="overlay"></div>
							</a>
						</div>

						<div class="news-description">
							<a href="<?=site_url('news/details/'.$n->id.'/'.$n->slug)?>">
								<h3 class="fastcon-h3 text-uppercase news-title"><?=$lang=='indonesian'?$n->title:$n->title_en?></h3>
							</a>
							<p class="fastcon-label"><?=date('j F Y', strtotime($n->created_at))?></p>
						</div>
					</div>

				<?php endforeach ?>


			</div>

			<div class="news-btn-wrap">
				<a href="<?=site_url('news')?>" class="fastcon-btn secondary-btn"><?=lang('see_all_news')?></a>
			</div>
		</div>

	</div><!-- .content-wrap end -->
</section><!-- #content end -->

<div class="modal fade bs-example-modal-lg home-modal" id="home_modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-body">
			<div class="modal-content">
				<div class="modal-header">
				<img src="<?=BASE_ASSET?>logo/<?= get_option('site_logo'); ?>" width="212" alt="<?= get_option('site_name'); ?>">
				</div>
				<div class="modal-body">
					<h2 class="fastcon-h2 cl-grey-900">DAPATKAN KUPON SENILAI RP5.000.000*</h2>

					<p class="fastcon-body-large">Dapatkan kupon menarik dari Fastcon dengan melakukan daftar akun pada website kami dan dapatkan kupon senilai Rp5.000.000*. Syarat dan ketentuan berlaku.</p>

					<div class="button-wrap">
						<a href="<?=site_url('member/register')?>" class="fastcon-btn primary-btn">DAFTAR AKUN</a>
						<button type="button" class="fastcon-btn secondary-btn" data-dismiss="modal" aria-hidden="true">NANTI SAJA</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
