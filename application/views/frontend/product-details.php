<section id="content">
    <div class="content-wrap product-details-wrap">
        <div class="container">
            <div class="breadcrumbs breadcrumbs-right">
                <span>Produk</span> <span>Bata Ringan AAC</span> <span>Single Cored Block</span>
            </div>

            <div class="row product-details-content-wrap">
                <div class="col-lg-6">

                    <div class="product-details-img-wrap">
                        <div class="slider-nav">
                            <?php foreach (explode(',', $product->product_images) as $img): ?>
                                <img src="<?=site_url('uploads/fastcon_product/'.$img)?>" alt="">
                            <?php endforeach ?>
                        </div>
                        <div class="slider-for">
                            <?php foreach (explode(',', $product->product_images) as $img): ?>
                                <img src="<?=site_url('uploads/fastcon_product/'.$img)?>" alt="">
                            <?php endforeach ?>
                        </div>
                    </div>

                    <div class="share">
                        <p class="fastcon-description">Bagikan:</p>
                        <a href="mailto:?subject=Fastcon - <?=$product->product_name?>&body=<?=$product->product_name .' <br> '. base_url(uri_string())?>'">
                            <img src="<?=BASE_ASSET?>fastcon/img/icons/email.png" alt="">
                        </a>
                        <a href="javascript:void(0)" onclick="javascript:window.open('https://www.facebook.com/sharer.php?u=<?=base_url(uri_string())?>',
                                        '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=800,width=800'); return false;">
                            <img src="<?=BASE_ASSET?>fastcon/img/icons/facebook.png" alt="">
                        </a>
                        <a href="javascript:void(0)" onclick="javascript:window.open('https://twitter.com/intent/tweet?text=Fastcon - <?=$product->product_name?> <?=base_url(uri_string())?>',
                                        '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                            <img src="<?=BASE_ASSET?>fastcon/img/icons/twitter.png" alt="">
                        </a>
                        <a href="https://wa.me/?text=<?=urlencode('Fastcon - '.$product->product_name.' '.base_url(uri_string()))?>" target="_blank">
                            <img src="<?=BASE_ASSET?>fastcon/img/icons/whatsapp.png" alt="">
                        </a>
                    </div>

                </div>

                <div class="col-lg-6">
                    <div class="product-details-info-wrap">
                        <h2 class="fastcon-h2 product-title"><?=$product->product_name?></h2>

                        <p class="fastcon-description cl-grey-900 product-sku"><span></span> Bata Ringan AAC</p>

                        <del class="normal-price"></del>

                        <h2 class="fastcon-h2 main-price cl-error"></h2>

                        <div class="row">

                            <?php if ($product->product_option1_name!=NULL): ?>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="fastcon-label cl-grey-900"><?=$lang=='indonesian'?$product->product_option1_name:$po->product_option1_name_en?></label>
                                        <select class="form-control selectpicker" name="product_options1" data-product="<?=$product->product_id?>" id="product_options1" title="Pilih Satu">
                                            <?php foreach ($this->Model_web->get_variant_value($product->product_id, 'option_value1_id') as $v): ?>
                                                <option value="<?=$v->option_value1_id?>"><?=$v->option_value1?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                            <?php endif ?>

                            <?php if ($product->product_option2_id!=NULL): ?>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="fastcon-label cl-grey-900"><?=$lang=='indonesian'?$product->product_option2_name:$po->product_option2_name_en?></label>
                                        <select class="form-control selectpicker" name="product_options2" data-product="<?=$product->product_id?>" id="product_options2" title="Pilih Satu"></select>
                                    </div>
                                </div>
                            <?php endif ?>

                        </div>

                        <form class="cart" method="post" enctype='multipart/form-data'>
                            <div class="row">
                                <div class="col-sm-12 qty-wrap">
                                    <label class="fastcon-label cl-grey-900">Jumlah/Kuantitas</label>
                                    <div class="quantity clearfix">
                                        <input type="button" value="-" class="minus">
                                        <input type="number" step="1" min="1" id="quantity" name="quantity" value="1" title="Qty" class="qty" />
                                        <input type="button" value="+" class="plus">
                                    </div>

                                </div>
                            </div>
                            <div class="row cart-btn-wrap">
                                <div class="col-sm-12">
                                    <button type="button" class="fastcon-btn primary-btn" data-product="<?=$product->product_id?>" id="add_to_cart_btn">TAMBAH KE TROLI BELANJA</button>
                                    <a href="#" class="fastcon-btn secondary-btn">KONTAK KAMI</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row product-details-description-wrap">
                <div class="col-sm-12">
                    <div class="product-desc">
                        <?=$product->product_desc?>
                    </div>
                </div>

                <div class="col-12">

                    <div class="tabs clearfix tab-product-details" id="tab-1">

                        <ul class="tab-nav clearfix tab-nav-product-details">
                            <li><a href="#tabs-1"><span> Spesifikasi</span></a></li>
                            <li><a href="#tabs-2"><span> Cara Pasang</span></a></li>
                            <li><a href="#tabs-3"><span> Sertifikat</span></a></li>
                        </ul>

                        <div class="tab-container">

                            <div class="tab-content clearfix" data-lightbox="gallery" id="tabs-1">
                                <a href="<?=BASE_ASSET?>fastcon/img/products/spek.png" data-lightbox="gallery-item">
                                    <img src="<?=site_url('uploads/fastcon_product/'.$product->spec)?>" alt="">
                                </a>
                            </div>
                            <div class="tab-content clearfix" id="tabs-2">
                                <img src="<?=site_url('uploads/fastcon_product/'.$product->cara_pasang)?>" alt="">
                            </div>
                            <div class="tab-content clearfix" id="tabs-3">
                                <img src="<?=site_url('uploads/fastcon_product/'.$product->certificate)?>" alt="">
                            </div>

                        </div>

                    </div>

                </div>
            </div>

            <div class="row related-product-wrap fastcon-product-list">
                <div class="col-12 text-center">
                    <h3 class="fastcon-h3">PRODUK TERKAIT</h3>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <a href="<?=site_url('products/details/1/asdf')?>" class="product-item mb-0">
                        <div class="product-img">
                            <img src="<?=BASE_ASSET?>fastcon/img/products/img.jpg" alt="">
                        </div>

                        <div class="product-desc">
                            <p class="fastcon-description">BATA RINGAN AAC</p>
                            <h4 class="fastcon-h4">BATA RINGAN FASTCON (BLOK STANDARD)</h4>
                        </div>
                    </a>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12">
                    <a href="<?=site_url('products/details/1/asdf')?>" class="product-item mb-0">
                        <div class="product-img">
                            <img src="<?=BASE_ASSET?>fastcon/img/products/img.jpg" alt="">
                        </div>

                        <div class="product-desc">
                            <p class="fastcon-description">BATA RINGAN AAC</p>
                            <h4 class="fastcon-h4">BATA RINGAN FASTCON (BLOK STANDARD)</h4>
                        </div>
                    </a>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12">
                    <a href="<?=site_url('products/details/1/asdf')?>" class="product-item mb-0">
                        <div class="product-img">
                            <img src="<?=BASE_ASSET?>fastcon/img/products/img-1.jpg" alt="">
                        </div>

                        <div class="product-desc">
                            <p class="fastcon-description">BATA RINGAN AAC</p>
                            <h4 class="fastcon-h4">BATA RINGAN FASTCON (BLOK STANDARD)</h4>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade bs-example-modal-lg added-to-cart-modal" id="added_to_cart_modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-body">
            <div class="modal-content">

                <div class="content-left">
                    <img src="<?=BASE_ASSET?>fastcon/img/icons/added_to_cart.png" alt="Thank You">
                </div>

                <div class="content-right">
                    <div class="modal-header">
                        <img src="<?=BASE_ASSET?>logo/<?= get_option('site_logo'); ?>" width="212" alt="<?= get_option('site_name'); ?>">
                    </div>
                    <div class="modal-body">
                        <h2 class="fastcon-h2 cl-grey-900 text-uppercase">Berhasil!</h2>

                        <p class="fastcon-body-large">Produk telah ditambahkan ke troli belanja. Belanja produk Fastcon sebagai solusi pembangunan ramah lingkungan.</p>

                        <div class="button-wrap">
                            <a href="<?=site_url('products/cart')?>" class="fastcon-btn primary-btn">KE TROLI BELANJA</a>
                            <a href="<?=site_url('products')?>" class="fastcon-btn secondary-btn">LANJUT BELANJA</a>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <p class="fastcon-description cl-grey-600 mb-0">©2021 FASTCON. All Rights Reserved</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>