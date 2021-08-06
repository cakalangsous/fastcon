<section id="content">
    <div class="member-wrapper">
        <?php include "_navbar.php";?>

        <div class="member-content-wrap">
            <div class="member-container">
                <div class="content-wrap">
                    <div class="row coupon-wrap">

                        <?php foreach ($coupon as $c): ?>
                            <div class="col-lg-6 col-md-12">
                                <div class="coupon-item" data-code="<?=$c->voucher_code?>" data-desc="<?=$lang=='indonesian'?$c->voucher_description:$c->voucher_description_en?>">
                                    <h2 class="fastcon-h2 cl-grey-900 text-uppercase"><?=$c->voucher_code?></h2>
                                    <p class="fastcon-body"><?=$c->short_desc?></p>
                                    <div class="row coupon-details">
                                        <div class="col-lg-4 col-md-3 col-6">
                                            <span class="fastcon-label cl-primary-900">CASHBACK</span>
                                            <h4 class="fastcon-h4 cl-grey-900">Rp <?=number_format($c->voucher_discount)?></h4>
                                        </div>
        
                                        <div class="col-lg-4 col-md-3 col-6">
                                            <span class="fastcon-label cl-primary-900">BERLAKU HINGGA</span>
                                            <h4 class="fastcon-h4 cl-grey-900"><?=date('d M Y', strtotime($c->end_date))?></h4>
                                        </div>
        
                                        <div class="col-lg-4 col-md-3 col-6">
                                            <span class="fastcon-label cl-primary-900">MIN. TRANSAKSI</span>
                                            <h4 class="fastcon-h4 cl-grey-900">RP<?=number_format($c->min_purchase)?></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>


                        <!-- <div class="col-lg-6 col-md-12">
                            <div class="coupon-item" data-toggle="modal" data-target=".coupon-details-modal">
                                <h2 class="fastcon-h2 cl-grey-900 text-uppercase">FAST50</h2>
                                <p class="fastcon-body">Cashback senilai Rp5.000.000 untuk semua produk. Syarat dan ketentuan berlaku.</p>
                                <div class="row coupon-details">
                                    <div class="col-lg-4 col-md-3 col-6">
                                        <span class="fastcon-label cl-primary-900">CASHBACK</span>
                                        <h4 class="fastcon-h4 cl-grey-900">Rp5.000.000</h4>
                                    </div>
    
                                    <div class="col-lg-4 col-md-3 col-6">
                                        <span class="fastcon-label cl-primary-900">BERLAKU HINGGA</span>
                                        <h4 class="fastcon-h4 cl-grey-900">27 mar 2021</h4>
                                    </div>
    
                                    <div class="col-lg-4 col-md-3 col-6">
                                        <span class="fastcon-label cl-primary-900">MIN. TRANSAKSI</span>
                                        <h4 class="fastcon-h4 cl-grey-900">RP50.000.000</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12">
                            <div class="coupon-item" data-toggle="modal" data-target=".coupon-details-modal">
                                <h2 class="fastcon-h2 cl-grey-900 text-uppercase">FAST50</h2>
                                <p class="fastcon-body">Cashback senilai Rp5.000.000 untuk semua produk. Syarat dan ketentuan berlaku.</p>
                                <div class="row coupon-details">
                                    <div class="col-lg-4 col-md-3 col-6">
                                        <span class="fastcon-label cl-primary-900">CASHBACK</span>
                                        <h4 class="fastcon-h4 cl-grey-900">Rp5.000.000</h4>
                                    </div>
    
                                    <div class="col-lg-4 col-md-3 col-6">
                                        <span class="fastcon-label cl-primary-900">BERLAKU HINGGA</span>
                                        <h4 class="fastcon-h4 cl-grey-900">27 mar 2021</h4>
                                    </div>
    
                                    <div class="col-lg-4 col-md-3 col-6">
                                        <span class="fastcon-label cl-primary-900">MIN. TRANSAKSI</span>
                                        <h4 class="fastcon-h4 cl-grey-900">RP50.000.000</h4>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        


                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade coupon-details-modal" tabindex="-1" role="dialog" aria-labelledby="addressModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-body">
            <div class="modal-content">
                <div class="modal-body">
                    <h3 class="fastcon-h3 cl-grey-900 text-uppercase text-center mb-20" id="voucher_code"></h3>

                    <div class="coupon-description" id="voucher_description"></div>
                    
                    <div class="row">
                        <div class="col-12 button-submit-wrap">
                            <a href="<?=site_url('products')?>" class="fastcon-btn primary-btn">GUNAKAN KUPON</a>
                            <a href="#" class="fastcon-btn secondary-btn" data-dismiss="modal" aria-hidden="true">KEMBALI</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>