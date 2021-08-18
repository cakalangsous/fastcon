<section id="content">
    <div class="content-wrap">
        <div class="container">
            <h2 class="fastcon-h2 text-center">MOHON ISI DATA DIRI DAN ALAMAT PENGIRIMAN</h2>

            <?php if ($this->session->userdata('error')): ?>
                <div class="fastcon-alert fastcon-alert-error">
                    <div class="alert-header">
                        <p class="alert-title"></p>
                    </div>
                    <div class="alert-body">
                        <p class="alert-message"><?=$this->session->userdata('error')?></p>
                    </div>
                </div>
            <?php endif ?>

            <?=form_open(site_url('checkout/save_guest_address'), ['class' => 'guest-form', 'method' => 'post']);?>
                <div class="row guest-wrap">
                    <div class="col-lg-4 col-md-12">
                        <h4 class="fastcon-h4 cl-primary-900 text-uppercase"><img src="<?=BASE_ASSET?>fastcon/img/icons/contact.png" alt="">  <?=lang('personal_data')?></h4>
                        <div class="form-group">
                            <label for="email" class="fastcon-label cl-grey-900"><?=lang('email')?>*</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="<?=lang('enter_here')?>">
                        </div>
                        <div class="form-group">
                            <label for="fullname" class="fastcon-label cl-grey-900"><?=lang('fullname')?>*</label>
                            <input type="text" class="form-control" name="fullname" id="fullname" placeholder="<?=lang('enter_here')?>">
                        </div>
                        <div class="form-group">
                            <label for="phone" class="fastcon-label cl-grey-900"><?=lang('phone')?>*</label>
                            <input type="number" class="form-control" name="phone" id="phone" placeholder="<?=lang('enter_here')?>">
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-12">
                        <h4 class="fastcon-h4 cl-primary-900 text-uppercase"><img src="<?=BASE_ASSET?>fastcon/img/icons/home.png" alt="">  <?=lang('delivery_details')?></h4>
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
                            <input type="text" id="kota_kecamatan" name="kota_kecamatan" class="form-control" placeholder="<?=lang('min_3_char')?>" autocomplete="on">
                            <div id="auto_result" class="frontbox"></div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="fastcon-label cl-grey-900"><?=lang('address')?>*</label>
                            <input type="text" class="form-control" name="address" id="address" placeholder="<?=lang('enter_here')?>">
                        </div>
                        <div class="form-group">
                            <label for="additional_info" class="fastcon-label cl-grey-900"><?=lang('additional_info')?>*</label>
                            <input type="text" class="form-control" name="additional_info" id="additional_info" placeholder="<?=lang('enter_here')?>">
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-12">
                        <h4 class="fastcon-h4 cl-primary-900"><img src="<?=BASE_ASSET?>fastcon/img/icons/cardbox.png" alt="">  DATA PENERIMA</h4>
                        <div class="form-group">
                            <label for="receiver_name" class="fastcon-label cl-grey-900"><?=lang('fullname')?>*</label>
                            <input type="text" class="form-control" name="receiver_name" id="receiver_name" placeholder="<?=lang('enter_here')?>">
                        </div>
                        <div class="form-group">
                            <label for="receiver_phone" class="fastcon-label cl-grey-900"><?=lang('phone')?>*</label>
                            <input type="text" class="form-control" name="receiver_phone" id="receiver_phone" placeholder="<?=lang('enter_here')?>">
                        </div>
                        <div class="form-check p-0">
                            <input type="checkbox" value="1" id="copy_user"> <span class="fastcon-description cl-grey-900">Samakan dengan data diri</span>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4 button-submit-wrap">
                        <button class="fastcon-btn primary-btn">LANJUT KE CHECKOUT</button>

                    </div>
                    <div class="col-lg-4"></div>
                </div>
            <?=form_close();?>
        </div>
    </div>
</section>

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