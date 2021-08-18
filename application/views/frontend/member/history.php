<section id="content">
    <div class="member-wrapper">
        <?php include "_navbar.php";?>

        <div class="member-content-wrap">
            <div class="member-container">
                <div class="content-wrap">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="fastcon-h4 cl-grey-900">LAGI DIPROSES</h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 history-wrapper">
                            <?php if ($this->session->flashdata('response')): ?>
                                <div class="style-msg successmsg mt-3">
                                    <div class="sb-msg"><?=$this->session->flashdata('response');?></div>
                                </div>
                            <?php endif ?>
                            <div class="history-item accordion" data-collapsible="true">
                                <?php foreach ($transaction_history_grouped as $hg): ?>
                                    <?php
                                        $status_class = '';
                                        $status_text = '';
                                        switch ($hg->order_status) {
                                            case 2:
                                                $status_class = 'primary-btn';
                                                $status_text = lang('payment_received');
                                                break;

                                            case 3:
                                                $status_class = 'sent-btn';
                                                $status_text = lang('sent');
                                                break;

                                            case 4:
                                                $status_class = 'cancelled-btn';
                                                $status_text = lang('cancelled');
                                                break;
                                            
                                            default:
                                                $status_class = 'new-order-btn';
                                                $status_text = lang('new_order');
                                                break;
                                        }
                                    ?>
                                    
                                    <hr />
                                    <div class="accordion-header <?=count(db_get_all_data('fastcon_product_orders', ['order_code' => $hg->order_code]))>1?'multiple':'' ?>">
                                        <div class="accordion-title">

                                            <div class="row">
                                                <div class="col-lg-3 col-md-3 col-12">
                                                    <div class="accordion-img">
                                                        <img src="<?=site_url('uploads/fastcon_product/'.explode(',', $hg->product_images)[0] )?>" alt="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-12">
                                                    <div class="info-body">
                                                        <div>
                                                            <p class="fastcon-body cl-grey-900"><b>Nomor Pesanan:</b></p>
                                                            <p class="fastcon-body cl-grey-900">#<?=$hg->order_code?></p>
                                                        </div>

                                                        <div>
                                                            <p class="fastcon-body cl-grey-900"><b>Tanggal:</b></p>
                                                            <p class="fastcon-body cl-grey-900"><?=date('F j, Y' ,strtotime($hg->created))?></p>
                                                        </div>

                                                        <div class="status-wrap">
                                                            <p class="fastcon-body cl-grey-900"><b>Status:</b></p>
                                                            <p class="label-btn <?=$status_class?>"><?=$status_text?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-12">
                                                    <div class="info-body">
                                                        <div>
                                                            <p class="fastcon-body cl-grey-900"><b>Kontak Kurir:</b></p>
                                                            <p class="fastcon-body cl-grey-900"><?=$hg->courier_name!=''?$hg->courier_name:'-'?></p>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-lg-3 col-md-3 col-12">
                                                    <div class="info-body text-right mr-4">
                                                        <div>
                                                            <p class="fastcon-body cl-grey-900">Rp<?=number_format($hg->total)?></p>
                                                            <p class="fastcon-body cl-grey-900">(<?=count(db_get_all_data('fastcon_product_orders', ['order_code' => $hg->order_code]))?> item)</p>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-icon">
                                            <i class="accordion-closed"><img src="<?=BASE_ASSET?>fastcon/img/icons/arrow-down.png" alt=""></i>
                                            <i class="accordion-open"><img src="<?=BASE_ASSET?>fastcon/img/icons/arrow-up.png" alt=""></i>
                                        </div>
                                    </div>
                                    <div class="accordion-content">
                                        <div class="row history-content-wrapper">
                                            <div class="col-lg-5 col-md-12">
                                                <div class="cart-card-wrap history-details-wrap">

                                                    <?php foreach ($transaction_history as $th): ?>
                                                        <?php if ($th->order_code == $hg->order_code): ?>
                                                            <div class="cart-card-item">

                                                                <div class="card-img">
                                                                    <img src="<?=site_url('uploads/fastcon_product/'.explode(',', $th->product_images)[0] )?>" alt="">
                                                                </div>

                                                                <div class="card-desc">
                                                                    <h4 class="fastcon-h4"><?=$th->product_name?></h4>
                                                                    <del class="normal-price"><?=$th->discount>0?'Rp'.number_format($th->price):''?></del>
                                                                    <h4 class="fastcon-h4 main-price cl-error">Rp<?=number_format($th->price - $th->discount)?></h4>
                                                                    <p class="card-desc-details"><span class="desc-title"><?=$lang=='indonesian'?$th->product_option1_name:$th->product_option1_name_en?>: </span><?=$th->product_option1_value?></p>
                                                                    <?php if ($th->product_option2_name!=null): ?>
                                                                        <p class="card-desc-details"><span class="desc-title"><?=$lang=='indonesian'?$th->product_option2_name:$th->product_option2_name_en?>: </span><?=$th->product_option2_value?></p>
                                                                    <?php endif ?>
                                                                </div>
                                                            </div>
                                                        <?php endif ?>
                                                        
                                                    <?php endforeach ?>

                                                </div>
                                            </div>

                                            <div class="col-lg-7 col-md-12">
                                                <div class="card-summary">
                                                    <h4 class="fastcon-h4 cl-primary-900 text-center text-uppercase"><?=lang('summary')?></h4>

                                                    <?php foreach ($transaction_history as $s): ?>
                                                        <?php if ($s->order_code == $hg->order_code): ?>
                                                            <div class="card-summary-product-item">
                                                                <div class="product">
                                                                    <p class="fastcon-description"><?=$s->product_name?></p>
                                                                    <p class="fastcon-description"><?=$lang=='indonesian'?$s->product_option1_name:$s->product_option1_name_en?>: <?=$s->product_option1_value?></p>
                                                                    <?php if ($th->product_option2_name!=null): ?>
                                                                        <p class="fastcon-description"><?=$lang=='indonesian'?$s->product_option2_name:$s->product_option2_name_en?>: <?=$s->product_option2_value?></p>
                                                                    <?php endif ?>
                                                                    <p class="fastcon-description"><b>x<?=$s->qty?></b></p>
                                                                </div>
                                                                <div class="price">
                                                                    <p>Rp<?=number_format($s->price - $s->discount)?></p>
                                                                </div>
                                                            </div>
                                                        <?php endif ?>
                                                    <?php endforeach ?>


                                                    <div class="line"></div>

                                                    <div class="card-summary-product-item mb-0">
                                                        <div class="product">
                                                            <p class="fastcon-description">Subtotal</p>
                                                        </div>
                                                        <div class="price">
                                                            <p>Rp<?=$s->subtotal?></p>
                                                        </div>
                                                    </div>

                                                    <div class="card-summary-product-item mb-0">
                                                        <div class="product">
                                                            <p class="fastcon-description"><?=lang('tax')?> (10%)</p>
                                                        </div>
                                                        <div class="price">
                                                            <p>Rp<?=number_format(0.1 * $s->subtotal)?></p>
                                                        </div>
                                                    </div>

                                                    <div class="card-summary-product-item mb-0">
                                                        <div class="product">
                                                            <p class="fastcon-description"><?=lang('delivery_cost')?></p>
                                                        </div>
                                                        <div class="price">
                                                            <p>Rp<?=number_format($s->shipping_cost)?></p>
                                                        </div>
                                                    </div>

                                                    <div class="line"></div>

                                                    <div class="card-summary-product-item">
                                                        <div class="product">
                                                            <p class="fastcon-description"><b>Total</b></p>
                                                        </div>
                                                        <div class="price">
                                                            <p><b>Rp<?=number_format($s->total)?></b></p>
                                                        </div>
                                                    </div>

                                                    <?php if ($hg->order_status==1): ?>
                                                        
                                                        <div class="card-summary-product-item">
                                                            <div class="price">
                                                                <a href="<?=site_url('member/cancel_order/'.strtolower($hg->order_code))?>" class="cl-error cancel-btn">
                                                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M15.3387 2.66133C13.6406 0.963316 11.3942 0 9 0C4.05503 0 0 4.04705 0 9C0 13.9556 4.04561 18 9 18C13.9326 18 18 13.9715 18 9C18 6.60582 17.0367 4.35934 15.3387 2.66133ZM9 15.8555C5.21065 15.8555 2.14453 12.7974 2.14453 9C2.14453 7.5234 2.60859 6.12067 3.46289 4.96051L13.0395 14.5265C11.8793 15.3914 10.4766 15.8555 9 15.8555ZM14.5266 13.0394L4.96051 3.46289C6.12074 2.60859 7.5234 2.14453 9 2.14453C12.7895 2.14453 15.8555 5.2026 15.8555 9C15.8555 10.4765 15.3914 11.8793 14.5266 13.0394Z" fill="#D3302F"/>
                                                                    </svg>
                                                                 BATALKAN</a>
                                                            </div>
                                                        </div>
                                                    <?php endif ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>

                                <!-- <hr />
                                <div class="accordion-header">
                                    <div class="accordion-title">

                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-12">
                                                <div class="accordion-img">
                                                    <img src="<?=BASE_ASSET?>fastcon/img/products/img.jpg" alt="">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-12">
                                                <div class="info-body">
                                                    <div>
                                                        <p class="fastcon-body cl-grey-900"><b>Nomor Pesanan:</b></p>
                                                        <p class="fastcon-body cl-grey-900">#1234567901234567</p>
                                                    </div>

                                                    <div>
                                                        <p class="fastcon-body cl-grey-900"><b>Tanggal:</b></p>
                                                        <p class="fastcon-body cl-grey-900">21 Maret 2021</p>
                                                    </div>

                                                    <div class="status-wrap">
                                                        <p class="fastcon-body cl-grey-900"><b>Status:</b></p>
                                                        <p class="label-btn cancelled-btn">Dibatalkan</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-12">
                                                <div class="info-body">
                                                    <div>
                                                        <p class="fastcon-body cl-grey-900"><b>Kontak Kurir:</b></p>
                                                        <p class="fastcon-body cl-grey-900">081234567890</p>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-lg-3 col-md-3 col-12">
                                                <div class="info-body text-right mr-4">
                                                    <div>
                                                        <p class="fastcon-body cl-grey-900">Rp45.082.000</p>
                                                        <p class="fastcon-body cl-grey-900">(4 item)</p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="accordion-icon">
                                        <i class="accordion-closed"><img src="<?=BASE_ASSET?>fastcon/img/icons/arrow-down.png" alt=""></i>
                                        <i class="accordion-open"><img src="<?=BASE_ASSET?>fastcon/img/icons/arrow-up.png" alt=""></i>
                                    </div>
                                </div>
                                <div class="accordion-content">
                                    <div class="row history-content-wrapper">
                                        <div class="col-lg-5 col-md-12">
                                            <div class="cart-card-wrap history-details-wrap">
                                                <div class="cart-card-item">

                                                    <div class="card-img">
                                                        <img src="<?=BASE_ASSET?>fastcon/img/products/img-2.jpg" alt="">
                                                    </div>

                                                    <div class="card-desc">
                                                        <h4 class="fastcon-h4">BATA RINGAN FASTCON (BLOK STANDARD)</h4>
                                                        <del class="normal-price">Rp7.000.000</del>
                                                        <h4 class="fastcon-h4 main-price cl-error">Rp5.000.000</h4>
                                                        <p class="card-desc-details"><span class="desc-title">Ketebalan Produk: </span>75 mm</p>
                                                        <p class="card-desc-details"><span class="desc-title">Ritase: </span>10.8 m3</p>
                                                    </div>
                                                </div>

                                                <div class="cart-card-item">

                                                    <div class="card-img">
                                                        <img src="<?=BASE_ASSET?>fastcon/img/products/img.jpg" alt="">
                                                    </div>

                                                    <div class="card-desc">
                                                        <h4 class="fastcon-h4">BATA RINGAN FASTCON (BLOK STANDARD)</h4>
                                                        <del class="normal-price">Rp7.000.000</del>
                                                        <h4 class="fastcon-h4 main-price cl-error">Rp5.000.000</h4>
                                                        <p class="card-desc-details"><span class="desc-title">Ketebalan Produk: </span>75 mm</p>
                                                        <p class="card-desc-details"><span class="desc-title">Ritase: </span>10.8 m3</p>
                                                    </div>
                                                </div>

                                                <div class="cart-card-item">

                                                    <div class="card-img">
                                                        <img src="<?=BASE_ASSET?>fastcon/img/products/img-3.jpg" alt="">
                                                    </div>

                                                    <div class="card-desc">
                                                        <h4 class="fastcon-h4">BATA RINGAN FASTCON (BLOK STANDARD)</h4>
                                                        <del class="normal-price">Rp7.000.000</del>
                                                        <h4 class="fastcon-h4 main-price cl-error">Rp5.000.000</h4>
                                                        <p class="card-desc-details"><span class="desc-title">Ketebalan Produk: </span>75 mm</p>
                                                        <p class="card-desc-details"><span class="desc-title">Ritase: </span>10.8 m3</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-12">
                                            <div class="card-summary">
                                                <h4 class="fastcon-h4 cl-primary-900 text-center">RINGKASAN</h4>

                                                <div class="card-summary-product-item">
                                                    <div class="product">
                                                        <p class="fastcon-description">Bata Ringan Fastcon (Blok Standard)</p>
                                                        <p class="fastcon-description">Ketebalan Produk: 75mm</p>
                                                        <p class="fastcon-description">Ritase: 10.8 m3</p>
                                                        <p class="fastcon-description"><b>x1</b></p>
                                                    </div>
                                                    <div class="price">
                                                        <p>Rp5.000.000</p>
                                                    </div>
                                                </div>

                                                <div class="card-summary-product-item">
                                                    <div class="product">
                                                        <p class="fastcon-description">Bata Ringan Fastcon (Blok Standard)</p>
                                                        <p class="fastcon-description">Ketebalan Produk: 75mm</p>
                                                        <p class="fastcon-description">Ritase: 10.8 m3</p>
                                                        <p class="fastcon-description"><b>x1</b></p>
                                                    </div>
                                                    <div class="price">
                                                        <p>Rp120.000</p>
                                                    </div>
                                                </div>

                                                <div class="card-summary-product-item">
                                                    <div class="product">
                                                        <p class="fastcon-description">Bata Ringan Fastcon (Blok Standard)</p>
                                                        <p class="fastcon-description">Ketebalan Produk: 75mm</p>
                                                        <p class="fastcon-description">Ritase: 10.8 m3</p>
                                                        <p class="fastcon-description"><b>x1</b></p>
                                                    </div>
                                                    <div class="price">
                                                        <p>Rp40.000.000</p>
                                                    </div>
                                                </div>

                                                <div class="line"></div>

                                                <div class="card-summary-product-item mb-0">
                                                    <div class="product">
                                                        <p class="fastcon-description">Subtotal</p>
                                                    </div>
                                                    <div class="price">
                                                        <p>Rp45.120.000</p>
                                                    </div>
                                                </div>

                                                <div class="card-summary-product-item mb-0">
                                                    <div class="product">
                                                        <p class="fastcon-description">PPN (10%)</p>
                                                    </div>
                                                    <div class="price">
                                                        <p>Rp4.512.000</p>
                                                    </div>
                                                </div>

                                                <div class="card-summary-product-item mb-0">
                                                    <div class="product">
                                                        <p class="fastcon-description">Ongkos Kirim</p>
                                                    </div>
                                                    <div class="price">
                                                        <p>Rp450.000</p>
                                                    </div>
                                                </div>

                                                <div class="line"></div>

                                                <div class="card-summary-product-item">
                                                    <div class="product">
                                                        <p class="fastcon-description"><b>Total</b></p>
                                                    </div>
                                                    <div class="price">
                                                        <p><b>Rp49.632.000</b></p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr />
                                <div class="accordion-header">
                                    <div class="accordion-title">

                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-12">
                                                <div class="accordion-img">
                                                    <img src="<?=BASE_ASSET?>fastcon/img/products/img-1.jpg" alt="">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-12">
                                                <div class="info-body">
                                                    <div>
                                                        <p class="fastcon-body cl-grey-900"><b>Nomor Pesanan:</b></p>
                                                        <p class="fastcon-body cl-grey-900">#1234567901234567</p>
                                                    </div>

                                                    <div>
                                                        <p class="fastcon-body cl-grey-900"><b>Tanggal:</b></p>
                                                        <p class="fastcon-body cl-grey-900">21 Maret 2021</p>
                                                    </div>

                                                    <div class="status-wrap">
                                                        <p class="fastcon-body cl-grey-900"><b>Status:</b></p>
                                                        <p class="label-btn sent-btn">Terkirim</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-12">
                                                <div class="info-body">
                                                    <div>
                                                        <p class="fastcon-body cl-grey-900"><b>Kontak Kurir:</b></p>
                                                        <p class="fastcon-body cl-grey-900">081234567890</p>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-lg-3 col-md-3 col-12">
                                                <div class="info-body text-right mr-4">
                                                    <div>
                                                        <p class="fastcon-body cl-grey-900">Rp45.082.000</p>
                                                        <p class="fastcon-body cl-grey-900">(4 item)</p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="accordion-icon">
                                        <i class="accordion-closed"><img src="<?=BASE_ASSET?>fastcon/img/icons/arrow-down.png" alt=""></i>
                                        <i class="accordion-open"><img src="<?=BASE_ASSET?>fastcon/img/icons/arrow-up.png" alt=""></i>
                                    </div>
                                </div>
                                <div class="accordion-content">
                                    <div class="row history-content-wrapper">
                                        <div class="col-lg-5 col-md-12">
                                            <div class="cart-card-wrap history-details-wrap">
                                                <div class="cart-card-item">

                                                    <div class="card-img">
                                                        <img src="<?=BASE_ASSET?>fastcon/img/products/img-2.jpg" alt="">
                                                    </div>

                                                    <div class="card-desc">
                                                        <h4 class="fastcon-h4">BATA RINGAN FASTCON (BLOK STANDARD)</h4>
                                                        <del class="normal-price">Rp7.000.000</del>
                                                        <h4 class="fastcon-h4 main-price cl-error">Rp5.000.000</h4>
                                                        <p class="card-desc-details"><span class="desc-title">Ketebalan Produk: </span>75 mm</p>
                                                        <p class="card-desc-details"><span class="desc-title">Ritase: </span>10.8 m3</p>
                                                    </div>
                                                </div>

                                                <div class="cart-card-item">

                                                    <div class="card-img">
                                                        <img src="<?=BASE_ASSET?>fastcon/img/products/img.jpg" alt="">
                                                    </div>

                                                    <div class="card-desc">
                                                        <h4 class="fastcon-h4">BATA RINGAN FASTCON (BLOK STANDARD)</h4>
                                                        <del class="normal-price">Rp7.000.000</del>
                                                        <h4 class="fastcon-h4 main-price cl-error">Rp5.000.000</h4>
                                                        <p class="card-desc-details"><span class="desc-title">Ketebalan Produk: </span>75 mm</p>
                                                        <p class="card-desc-details"><span class="desc-title">Ritase: </span>10.8 m3</p>
                                                    </div>
                                                </div>

                                                <div class="cart-card-item">

                                                    <div class="card-img">
                                                        <img src="<?=BASE_ASSET?>fastcon/img/products/img-3.jpg" alt="">
                                                    </div>

                                                    <div class="card-desc">
                                                        <h4 class="fastcon-h4">BATA RINGAN FASTCON (BLOK STANDARD)</h4>
                                                        <del class="normal-price">Rp7.000.000</del>
                                                        <h4 class="fastcon-h4 main-price cl-error">Rp5.000.000</h4>
                                                        <p class="card-desc-details"><span class="desc-title">Ketebalan Produk: </span>75 mm</p>
                                                        <p class="card-desc-details"><span class="desc-title">Ritase: </span>10.8 m3</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-12">
                                            <div class="card-summary">
                                                <h4 class="fastcon-h4 cl-primary-900 text-center">RINGKASAN</h4>

                                                <div class="card-summary-product-item">
                                                    <div class="product">
                                                        <p class="fastcon-description">Bata Ringan Fastcon (Blok Standard)</p>
                                                        <p class="fastcon-description">Ketebalan Produk: 75mm</p>
                                                        <p class="fastcon-description">Ritase: 10.8 m3</p>
                                                        <p class="fastcon-description"><b>x1</b></p>
                                                    </div>
                                                    <div class="price">
                                                        <p>Rp5.000.000</p>
                                                    </div>
                                                </div>

                                                <div class="card-summary-product-item">
                                                    <div class="product">
                                                        <p class="fastcon-description">Bata Ringan Fastcon (Blok Standard)</p>
                                                        <p class="fastcon-description">Ketebalan Produk: 75mm</p>
                                                        <p class="fastcon-description">Ritase: 10.8 m3</p>
                                                        <p class="fastcon-description"><b>x1</b></p>
                                                    </div>
                                                    <div class="price">
                                                        <p>Rp120.000</p>
                                                    </div>
                                                </div>

                                                <div class="card-summary-product-item">
                                                    <div class="product">
                                                        <p class="fastcon-description">Bata Ringan Fastcon (Blok Standard)</p>
                                                        <p class="fastcon-description">Ketebalan Produk: 75mm</p>
                                                        <p class="fastcon-description">Ritase: 10.8 m3</p>
                                                        <p class="fastcon-description"><b>x1</b></p>
                                                    </div>
                                                    <div class="price">
                                                        <p>Rp40.000.000</p>
                                                    </div>
                                                </div>

                                                <div class="line"></div>

                                                <div class="card-summary-product-item mb-0">
                                                    <div class="product">
                                                        <p class="fastcon-description">Subtotal</p>
                                                    </div>
                                                    <div class="price">
                                                        <p>Rp45.120.000</p>
                                                    </div>
                                                </div>

                                                <div class="card-summary-product-item mb-0">
                                                    <div class="product">
                                                        <p class="fastcon-description">PPN (10%)</p>
                                                    </div>
                                                    <div class="price">
                                                        <p>Rp4.512.000</p>
                                                    </div>
                                                </div>

                                                <div class="card-summary-product-item mb-0">
                                                    <div class="product">
                                                        <p class="fastcon-description">Ongkos Kirim</p>
                                                    </div>
                                                    <div class="price">
                                                        <p>Rp450.000</p>
                                                    </div>
                                                </div>

                                                <div class="line"></div>

                                                <div class="card-summary-product-item">
                                                    <div class="product">
                                                        <p class="fastcon-description"><b>Total</b></p>
                                                    </div>
                                                    <div class="price">
                                                        <p><b>Rp49.632.000</b></p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr />
                                <div class="accordion-header">
                                    <div class="accordion-title">
                                        
                                    <div class="row">
                                            <div class="col-lg-3 col-md-3 col-12">
                                                <div class="accordion-img">
                                                    <img src="<?=BASE_ASSET?>fastcon/img/products/img-3.jpg" alt="">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-12">
                                                <div class="info-body">
                                                    <div>
                                                        <p class="fastcon-body cl-grey-900"><b>Nomor Pesanan:</b></p>
                                                        <p class="fastcon-body cl-grey-900">#1234567901234567</p>
                                                    </div>

                                                    <div>
                                                        <p class="fastcon-body cl-grey-900"><b>Tanggal:</b></p>
                                                        <p class="fastcon-body cl-grey-900">21 Maret 2021</p>
                                                    </div>

                                                    <div class="status-wrap">
                                                        <p class="fastcon-body cl-grey-900"><b>Status:</b></p>
                                                        <p class="label-btn new-order-btn">Order Baru</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-12">
                                                <div class="info-body">
                                                    <div>
                                                        <p class="fastcon-body cl-grey-900"><b>Kontak Kurir:</b></p>
                                                        <p class="fastcon-body cl-grey-900">081234567890</p>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-lg-3 col-md-3 col-12">
                                                <div class="info-body text-right mr-4">
                                                    <div>
                                                        <p class="fastcon-body cl-grey-900">Rp45.082.000</p>
                                                        <p class="fastcon-body cl-grey-900">(4 item)</p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="accordion-icon">
                                        <i class="accordion-closed"><img src="<?=BASE_ASSET?>fastcon/img/icons/arrow-down.png" alt=""></i>
                                        <i class="accordion-open"><img src="<?=BASE_ASSET?>fastcon/img/icons/arrow-up.png" alt=""></i>
                                    </div>
                                </div>
                                <div class="accordion-content">
                                    <div class="row history-content-wrapper">
                                        <div class="col-lg-5 col-md-12">
                                            <div class="cart-card-wrap history-details-wrap">
                                                <div class="cart-card-item">

                                                    <div class="card-img">
                                                        <img src="<?=BASE_ASSET?>fastcon/img/products/img-4.jpg" alt="">
                                                    </div>

                                                    <div class="card-desc">
                                                        <h4 class="fastcon-h4">BATA RINGAN FASTCON (BLOK STANDARD)</h4>
                                                        <del class="normal-price">Rp7.000.000</del>
                                                        <h4 class="fastcon-h4 main-price cl-error">Rp5.000.000</h4>
                                                        <p class="card-desc-details"><span class="desc-title">Ketebalan Produk: </span>75 mm</p>
                                                        <p class="card-desc-details"><span class="desc-title">Ritase: </span>10.8 m3</p>
                                                    </div>
                                                </div>

                                                <div class="cart-card-item">

                                                    <div class="card-img">
                                                        <img src="<?=BASE_ASSET?>fastcon/img/products/img.jpg" alt="">
                                                    </div>

                                                    <div class="card-desc">
                                                        <h4 class="fastcon-h4">BATA RINGAN FASTCON (BLOK STANDARD)</h4>
                                                        <del class="normal-price">Rp7.000.000</del>
                                                        <h4 class="fastcon-h4 main-price cl-error">Rp5.000.000</h4>
                                                        <p class="card-desc-details"><span class="desc-title">Ketebalan Produk: </span>75 mm</p>
                                                        <p class="card-desc-details"><span class="desc-title">Ritase: </span>10.8 m3</p>
                                                    </div>
                                                </div>

                                                <div class="cart-card-item">

                                                    <div class="card-img">
                                                        <img src="<?=BASE_ASSET?>fastcon/img/products/img-3.jpg" alt="">
                                                    </div>

                                                    <div class="card-desc">
                                                        <h4 class="fastcon-h4">BATA RINGAN FASTCON (BLOK STANDARD)</h4>
                                                        <del class="normal-price">Rp7.000.000</del>
                                                        <h4 class="fastcon-h4 main-price cl-error">Rp5.000.000</h4>
                                                        <p class="card-desc-details"><span class="desc-title">Ketebalan Produk: </span>75 mm</p>
                                                        <p class="card-desc-details"><span class="desc-title">Ritase: </span>10.8 m3</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-12">
                                            <div class="card-summary">
                                                <h4 class="fastcon-h4 cl-primary-900 text-center">RINGKASAN</h4>

                                                <div class="card-summary-product-item">
                                                    <div class="product">
                                                        <p class="fastcon-description">Bata Ringan Fastcon (Blok Standard)</p>
                                                        <p class="fastcon-description">Ketebalan Produk: 75mm</p>
                                                        <p class="fastcon-description">Ritase: 10.8 m3</p>
                                                        <p class="fastcon-description"><b>x1</b></p>
                                                    </div>
                                                    <div class="price">
                                                        <p>Rp5.000.000</p>
                                                    </div>
                                                </div>

                                                <div class="card-summary-product-item">
                                                    <div class="product">
                                                        <p class="fastcon-description">Bata Ringan Fastcon (Blok Standard)</p>
                                                        <p class="fastcon-description">Ketebalan Produk: 75mm</p>
                                                        <p class="fastcon-description">Ritase: 10.8 m3</p>
                                                        <p class="fastcon-description"><b>x1</b></p>
                                                    </div>
                                                    <div class="price">
                                                        <p>Rp120.000</p>
                                                    </div>
                                                </div>

                                                <div class="card-summary-product-item">
                                                    <div class="product">
                                                        <p class="fastcon-description">Bata Ringan Fastcon (Blok Standard)</p>
                                                        <p class="fastcon-description">Ketebalan Produk: 75mm</p>
                                                        <p class="fastcon-description">Ritase: 10.8 m3</p>
                                                        <p class="fastcon-description"><b>x1</b></p>
                                                    </div>
                                                    <div class="price">
                                                        <p>Rp40.000.000</p>
                                                    </div>
                                                </div>

                                                <div class="line"></div>

                                                <div class="card-summary-product-item mb-0">
                                                    <div class="product">
                                                        <p class="fastcon-description">Subtotal</p>
                                                    </div>
                                                    <div class="price">
                                                        <p>Rp45.120.000</p>
                                                    </div>
                                                </div>

                                                <div class="card-summary-product-item mb-0">
                                                    <div class="product">
                                                        <p class="fastcon-description">PPN (10%)</p>
                                                    </div>
                                                    <div class="price">
                                                        <p>Rp4.512.000</p>
                                                    </div>
                                                </div>

                                                <div class="card-summary-product-item mb-0">
                                                    <div class="product">
                                                        <p class="fastcon-description">Ongkos Kirim</p>
                                                    </div>
                                                    <div class="price">
                                                        <p>Rp450.000</p>
                                                    </div>
                                                </div>

                                                <div class="line"></div>

                                                <div class="card-summary-product-item">
                                                    <div class="product">
                                                        <p class="fastcon-description"><b>Total</b></p>
                                                    </div>
                                                    <div class="price">
                                                        <p><b>Rp49.632.000</b></p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>