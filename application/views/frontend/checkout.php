<section id="content">
    <div class="content-wrap">
        <div class="container">
            <div class="row checkout-wrap">
                <div class="col-lg-5">
                    <h4 class="fastcon-h4 cl-primary-900 text-uppercase"><?=lang('shopping_cart')?></h4>
                    <div class="cart-card-wrap">

                        <?php foreach ($cart as $c): ?>

                            <?php
                                $qty = $c->quantity;

                                if (!$this->session->userdata('member')) {
                                    $qty = $c->qty;
                                }
                            ?>
                            <div class="cart-card-item">
                                <div class="card-img">
                                    <img src="<?=site_url('uploads/fastcon_product/'.explode(',', $c->product_images)[0] )?>" alt="">
                                </div>
                                
                                <div class="card-desc">
                                    <h4 class="fastcon-h4"><?=$c->product_name?></h4>
                                    <?php if ($c->discount>0): ?>
                                        <del class="normal-price">Rp<?=number_format($c->price)?></del>
                                    <?php endif ?>
                                    <h4 class="fastcon-h4 main-price <?=$c->discount>0?'cl-error':''?>">Rp<?=number_format($c->price-$c->discount)?></h4>
                                    <p class="card-desc-details"><span class="desc-title"><?=$lang=='indonesian'?$c->product_option1_name:$c->product_option1_name_en?>: </span><?=$c->option_value1?></p>

                                    <?php if ($c->product_option2): ?>
                                        <p class="card-desc-details"><span class="desc-title"><?=$lang=='indonesian'?$c->product_option2_name:$c->product_option2_name_en?>: </span><?=$c->option_value2?></p>
                                    <?php endif ?>
                                </div>
                            </div>
                        <?php endforeach ?>

                    </div>
                </div>
                <div class="col-lg-7">
                    <h2 class="fastcon-h2">CHECKOUT</h2>
                    <div class="address-wrap">
                        <div class="title-wrap">
                            <h4 class="fastcon-h4 cl-primary-900 text-uppercase"><?=lang('delivery_details')?></h4>
                            <a href="javascript:void(0)" class="edit-link large-medium-only" data-toggle="modal" data-target=".address-modal">
                                <h4 class="fastcon-h4 cl-primary-900 text-uppercase">
                                    <img src="<?=BASE_ASSET?>fastcon/img/icons/pencil.png" alt="">
                                    <?=lang('edit')?>
                                </h4>
                            </a>
                        </div>

                        <?php if ($address): ?>
                            <div class="address-card">
                                <p class="receiver-name"><?=$address->name?></p>
                                <p class="receiver-email"><?=$address->email?></p>
                                <p class="receiver-email"><?=$address->phone?></p>
                                <p class="address"><?=$address->address.', '.$address->kelurahan.', '.$address->kecamatan.', '.$address->kabupaten.', '.$address->provinsi.', '.$address->kelurahan.', '.$address->kode_pos?></p>
                            </div>

                            <div class="link-wrap small-only">
                                <a href="javascript:void(0)" class="edit-link" data-toggle="modal" data-target=".address-modal">
                                    <h4 class="fastcon-h4 cl-primary-900">
                                        <img src="<?=BASE_ASSET?>fastcon/img/icons/pencil.png" alt="">
                                        <?=lang('edit')?>
                                    </h4>
                                </a>
                            </div>
                        <?php endif ?>

                    </div>

                    <!-- <div class="fastcon-alert fastcon-alert-error">
                        <div class="alert-header">
                            <p class="alert-title">Peringatan!</p>
                        </div>
                        <div class="alert-body">
                            <p class="alert-message">Biaya pengiriman tidak tersedia, silahkan hubungi call center kami di (031) 7421270 atau kontak kami untuk melanjutkan transaksi Anda.</p>
                        </div>
                    </div> -->

                    <?php if ($this->session->flashdata('voucher_error')): ?>
                        <div class="fastcon-alert fastcon-alert-error">
                            <div class="alert-header">
                                <p class="alert-title">Peringatan!</p>
                            </div>
                            <div class="alert-body">
                                <p class="alert-message"><?=$this->session->flashdata('voucher_error');?></p>
                            </div>
                        </div>

                    <?php endif ?>

                    <div class="card-summary">
                        <h4 class="fastcon-h4 cl-primary-900 text-center text-uppercase"><?=lang('summary')?></h4>

                        <?php $total=0; foreach ($cart as $c): ?>

                            <?php
                                $qty = $c->quantity;

                                if (!$this->session->userdata('member')) {
                                    $qty = $c->qty;
                                }

                                $total = $total + ($qty * ($c->price-$c->discount));
                            ?>
                            <div class="card-summary-product-item">
                                <div class="product">
                                    <p class="fastcon-description"><?=$c->product_name?></p>
                                    <p class="fastcon-description"><?=$lang=='indonesian'?$c->product_option1_name:$c->product_option1_name_en?>: <?=$c->option_value1?></p>
                                    <?php if ($c->product_option2): ?>
                                        <p class="fastcon-description"><?=$lang=='indonesian'?$c->product_option2_name:$c->product_option2_name_en?>: <?=$c->option_value2?></p>
                                    <?php endif ?>
                                    <p class="fastcon-description"><b>x<?=$qty?></b></p>
                                </div>
                                <div class="price">
                                    <p>Rp<?=number_format($qty * ($c->price-$c->discount))?></p>
                                </div>
                            </div>
                        <?php endforeach ?>

                        <div class="line"></div>

                        <div class="card-summary-product-item mb-0">
                            <div class="product">
                                <p class="fastcon-description">Subtotal</p>
                            </div>
                            <div class="price">
                                <p>Rp<?=number_format($total)?></p>
                            </div>
                        </div>

                        <div class="card-summary-product-item mb-0">
                            <div class="product">
                                <p class="fastcon-description">PPN (10%)</p>
                            </div>
                            <div class="price">
                                <p>Rp<?=number_format(0.1*$total)?></p>
                            </div>
                        </div>

                        <?php if ($ongkir): ?>
                            <div class="card-summary-product-item mb-0">
                                <div class="product">
                                    <p class="fastcon-description"><?=lang('delivery_cost')?></p>
                                </div>
                                <div class="price">
                                    <p>Rp<?=number_format($ongkir)?></p>
                                </div>
                            </div>
                        <?php endif ?>
                        <?php if ($voucher = $this->session->userdata('voucher')): ?>
                            <div class="card-summary-product-item">
                                <div class="product">
                                    <p class="fastcon-description"><?=lang('coupon_discount')?></p>
                                </div>
                                <div class="price">
                                    <p class="cl-error"> - Rp<?=number_format($voucher['voucher_discount'])?></p>
                                </div>
                            </div>
                        <?php $total = $total-$voucher['voucher_discount']; endif ?>


                        <div class="card-summary-product-item mt-3">
                            <div class="product">
                                <p class="fastcon-description"><b>Catatan:</b></p>
                                <p class="fastcon-description">Biaya pengiriman tidak tersedia, silahkan hubungi call center kami di (031) 555 1234 atau kontak kami untuk melanjutkan transaksi Anda.</p>
                            </div>
                        </div>


                        <div class="line"></div>

                        <div class="card-summary-product-item">
                            <div class="product">
                                <p class="fastcon-description"><b>Total</b></p>
                            </div>
                            <div class="price">
                                <p><b>Rp<?=number_format($total + (0.1*$total) + $ongkir)?></b></p>
                            </div>
                        </div>

                        <div class="card-summary-btn-wrap">
                            <a href="<?=site_url('checkout/submit_order')?>" class="fastcon-btn primary-btn w-100"><?=lang('checkout_securely')?></a>
                        </div>

                    </div>

                    <?=form_open(site_url('checkout/voucher'), ['class' => 'coupon-form', 'method' => 'POST']);?>
                        <div class="form-group">
                            <label class="fastcon-label text-capitalize cl-grey-900" for="voucher"><?=lang('coupon_code')?></label>
                            <div class="d-flex">
                                <input type="text" class="form-control" id="voucher" value="<?=$this->session->userdata('voucher')!=null?strtoupper($this->session->userdata('voucher')['voucher_code']):''?>" name="voucher" aria-describedby="emailHelp" placeholder="Ketik disini">
                                <?php if ($this->session->userdata('voucher')): ?>
                                    <a href="<?=site_url('checkout/voucher_delete')?>" class="fastcon-btn coupon-btn error-btn width-md-fit width-sm-fit"><?=lang('remove_coupon')?></a>
                                <?php else: ?>
                                    <button type="submit" class="fastcon-btn coupon-btn secondary-btn width-md-fit width-sm-fit"><?=lang('update')?></button>
                                <?php endif ?>
                            </div>
                        </div>
                    <?=form_close();?>
                </div>
            </div>

        </div>
    </div>

</section>

<div class="modal fade address-modal" tabindex="-1" role="dialog" aria-labelledby="addressModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-body">
            <div class="modal-content">
                <div class="modal-body">
                    <h3 class="fastcon-h3 cl-grey-900 text-uppercase text-center mb-30"><?=lang('personal_data')?></h3>
                    <?php if (count($member_address)<3): ?>
                        <div class="d-flex w-100">
                            <a href="javascript:void(0)" id="add_address_btn" class="fastcon-btn secondary-btn w-100 text-center mb-20">+ TAMBAH ALAMAT</a>
                        </div>
                    <?php endif ?>

                    <div class="address-wraper">
                        <?php foreach ($member_address as $ma): ?>
                            <div class="address-wrap <?=$ma->active?'active':''?>">
                                <div class="address-card mw-100">
                                    <p class="receiver-name"><?=$ma->name?></p>
                                    <p class="receiver-email"><?=$ma->email?></p>
                                    <p class="receiver-email"><?=$ma->phone?></p>
                                    <p class="address"><?=$ma->address.', '.$ma->kelurahan.', '.$ma->kecamatan.', '.$ma->kabupaten.', '.$ma->provinsi.', '.$ma->kelurahan.', '.$ma->kode_pos?></p>
                                </div>

                                <div class="address-links">
                                    <?php if (!$ma->active): ?>
                                        
                                        <div class="btn-wrap">
                                            <a href="<?=site_url('member/change_active/'.$ma->id)?>" class="fastcon-btn secondary-btn">
                                                <?=lang('change_address')?>
                                            </a>
                                        </div>

                                    <?php endif ?>
                                    <div class="card-btn-wrap">
                                        <a href="javascript:void(0)" class="edit-link edit_address"
                                            data-name='<?=$ma->name?>'
                                            data-email='<?=$ma->email?>'
                                            data-id='<?=$ma->id?>'
                                            data-phone='<?=$ma->phone?>'
                                            data-province_id='<?=$ma->province_id?>'
                                            data-address='<?=$ma->address?>'
                                        >
                                            <h4 class="fastcon-h4 cl-primary-900 text-uppercase">
                                                <img src="<?=BASE_ASSET?>fastcon/img/icons/pencil.png" alt="">
                                                <?=lang('edit')?>
                                            </h4>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal centered fade form-address-modal" id="address_modal_form" tabindex="-1" role="dialog" aria-labelledby="addressModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-body">
            <div class="modal-content">
                <div class="modal-body">
                    <?=form_open(site_url('member/save_address'), ['class' => "guest-form", 'id' => 'address_form_member']);?>
                        <div class="row">
                            <div class="col-12">
                                <h4 class="fastcon-h4 cl-primary-900 text-uppercase"><img src="<?=BASE_ASSET?>fastcon/img/icons/contact.png" alt=""> <?=lang('personal_data')?></h4>
                                <hr />
                                <div class="form-group">
                                    <label for="email" class="fastcon-label cl-grey-900"><?=lang('fullname')?>*</label>
                                    <input type="text" class="form-control" name="fullname" placeholder="Ketik disini">
                                </div>
                                <div class="form-group">
                                    <label for="email" class="fastcon-label cl-grey-900"><?=lang('email')?>*</label>
                                    <input type="email" class="form-control" name="email" placeholder="Ketik disini">
                                </div>
                                <div class="form-group">
                                    <label for="phone" class="fastcon-label cl-grey-900"><?=lang('phone')?>*</label>
                                    <input type="text" class="form-control" name="phone" placeholder="Ketik disini">
                                </div>

                                <div class="form-group">
                                    <label class="fastcon-label cl-grey-900"><?=lang('province')?>*</label>
                                    <select class="form-control selectpicker" name="province_id" id="province_id" title="Pilih Satu">
                                        <?php foreach (db_get_all_data('fastcon_coverage_province') as $cp): ?>
                                            <option value="<?=$cp->province_id?>"><?=$lang=='indonesian'?$cp->province_name:$cp->province_name_en?></option>
                                        <?php endforeach ?>
                                        <option value="0"><?=$lang=='indonesian'?'Lainnya':'Others'?></option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="kota_kecamatan" class="fastcon-label cl-grey-900"><?=lang('city_province')?>*</label>
                                    <input type="text" id="kota_kecamatan" name="kota_kecamatan" class="form-control" placeholder="Tulis minimal 3 karakter" autocomplete="on">
                                    <div id="auto_result" class="frontbox"></div>
                                </div>

                                <div class="form-group mb-0">
                                    <label for="address" class="fastcon-label cl-grey-900"><?=lang('address')?>*</label>
                                    <textarea class="form-control" id="address" rows="4" name="address"></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12 button-submit-wrap">
                                <button class="fastcon-btn primary-btn">KIRIM</button>
                                <a href="#" class="fastcon-btn secondary-btn" data-dismiss="modal" aria-hidden="true"><?=lang('back')?></a>
                            </div>
                        </div>
                    <?=form_close();?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <div class="modal centered fade form-address-modal" tabindex="-1" role="dialog" aria-labelledby="addressModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-body">
            <div class="modal-content">
                <div class="modal-body">
                    <h3 class="fastcon-h3 cl-grey-900 text-uppercase text-center mb-30">Data Anda</h3>
                    
                    <form action="#" class="guest-form">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="fastcon-h4 cl-primary-900"><img src="<?=BASE_ASSET?>fastcon/img/icons/contact.png" alt="">  DATA DIRI</h4>
                                <hr />
                                <div class="form-group">
                                    <label for="email" class="fastcon-label cl-grey-900">E-mail*</label>
                                    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Ketik disini">
                                </div>
                                <div class="form-group">
                                    <label for="email" class="fastcon-label cl-grey-900">Nama lengkap*</label>
                                    <input type="text" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Ketik disini">
                                </div>
                                <div class="form-group">
                                    <label for="phone" class="fastcon-label cl-grey-900">NOMOR HP*</label>
                                    <input type="text" class="form-control" id="phone" placeholder="Ketik disini">
                                </div>
                            </div>

                            <div class="col-12">
                                <h4 class="fastcon-h4 cl-primary-900"><img src="<?=BASE_ASSET?>fastcon/img/icons/home.png" alt="">  ALAMAT PENGIRIMAN</h4>
                                <hr />
                                <div class="form-group">
                                    <label for="email" class="fastcon-label cl-grey-900">Alamat*</label>
                                    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Ketik disini">
                                </div>
                                <div class="form-group">
                                    <label for="email" class="fastcon-label cl-grey-900">Info Tambahan*</label>
                                    <input type="text" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Ketik disini">
                                </div>
                                <div class="form-group">
                                    <label for="phone" class="fastcon-label cl-grey-900">Kecamatan/Kelurahan*</label>
                                    <input type="text" class="form-control" id="phone" placeholder="Ketik disini">
                                </div>
                            </div>

                            <div class="col-12">
                                <h4 class="fastcon-h4 cl-primary-900"><img src="<?=BASE_ASSET?>fastcon/img/icons/cardbox.png" alt="">  DATA PENERIMA</h4>
                                <hr />
                                <div class="form-group">
                                    <label for="email" class="fastcon-label cl-grey-900">Nama Lengkap*</label>
                                    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Ketik disini">
                                </div>
                                <div class="form-group">
                                    <label for="phone" class="fastcon-label cl-grey-900">Nomor HP*</label>
                                    <input type="text" class="form-control" id="phone" placeholder="Ketik disini">
                                </div>
                                <div class="form-check p-0">
                                    <input type="checkbox" value="1"> <span class="fastcon-description cl-grey-900">Samakan dengan data diri</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12 button-submit-wrap">
                                <button class="fastcon-btn primary-btn">LANJUT KE CHECKOUT</button>
                                <a href="#" class="fastcon-btn secondary-btn" data-dismiss="modal" aria-hidden="true">KEMBALI</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->


<style>

	[type="checkbox"] {
	    width: 16px;
	    height: 16px;
	    background-color: white;
	    border-radius: 50%;
	    vertical-align: middle;
	    border: 1px solid #E0E0E0;
	    -webkit-appearance: none;
	    outline: none;
	    cursor: pointer;
        margin-right: 8px;
	}

	[type="checkbox"]:checked {
		background-color: #00672B !important;
	}


	[type="radio"]:checked,
	[type="radio"]:not(:checked) {
	    position: absolute;
	    left: -9999px;
	}
	[type="radio"]:checked + label,
	[type="radio"]:not(:checked) + label
	{
	    position: relative;
	    padding-left: 28px;
	    cursor: pointer;
	    line-height: 20px;
	    display: inline-block;
	    color: #666;
	}
	[type="radio"]:checked + label:before,
	[type="radio"]:not(:checked) + label:before {
	    content: '';
	    position: absolute;
	    left: 0;
	    top: 0;
	    width: 18px;
	    height: 18px;
	    border: 1px solid #E0E0E0;
	    border-radius: 100%;
	    background: #fff;
	}
	[type="radio"]:checked + label:after,
	[type="radio"]:not(:checked) + label:after {
	    content: '';
	    width: 18px;
	    height: 18px;
	    background: #6CC049;
	    position: absolute;
	    top: 0;
	    left: 0;
	    border-radius: 100%;
	    -webkit-transition: all 0.2s ease;
	    transition: all 0.2s ease;
	}
	[type="radio"]:not(:checked) + label:after {
	    opacity: 0;
	    -webkit-transform: scale(0);
	    transform: scale(0);
	}
	[type="radio"]:checked + label:after {
	    opacity: 1;
	    -webkit-transform: scale(1);
	    transform: scale(1);
	}
</style>