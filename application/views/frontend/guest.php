<section id="content">
    <div class="content-wrap">
        <div class="container">
            <h2 class="fastcon-h2 text-center">MOHON ISI DATA DIRI DAN ALAMAT PENGIRIMAN</h2>

            <?=form_open(site_url('checkout/save_guest_address'), ['class' => 'guest-form', 'method' => 'post']);?>
                <div class="row guest-wrap">
                    <div class="col-lg-4 col-md-12">
                        <h4 class="fastcon-h4 cl-primary-900"><img src="<?=BASE_ASSET?>fastcon/img/icons/contact.png" alt="">  DATA DIRI</h4>
                        <div class="form-group">
                            <label for="email" class="fastcon-label cl-grey-900"><?=lang('email')?>*</label>
                            <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Ketik disini">
                        </div>
                        <div class="form-group">
                            <label for="fullname" class="fastcon-label cl-grey-900"><?=lang('fullname')?>*</label>
                            <input type="text" class="form-control" id="fullname" id="fullname" aria-describedby="emailHelp" placeholder="Ketik disini">
                        </div>
                        <div class="form-group">
                            <label for="phone" class="fastcon-label cl-grey-900"><?=lang('phone')?>*</label>
                            <input type="number" class="form-control" name="phone" id="phone" placeholder="Ketik disini">
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-12">
                        <h4 class="fastcon-h4 cl-primary-900"><img src="<?=BASE_ASSET?>fastcon/img/icons/home.png" alt="">  ALAMAT PENGIRIMAN</h4>
                        <div class="form-group">
                            <label for="email" class="fastcon-label cl-grey-900"><?=lang('address')?>*</label>
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

                    <div class="col-lg-4 col-md-12">
                        <h4 class="fastcon-h4 cl-primary-900"><img src="<?=BASE_ASSET?>fastcon/img/icons/cardbox.png" alt="">  DATA PENERIMA</h4>
                        <div class="form-group">
                            <label for="email_penerima" class="fastcon-label cl-grey-900">Nama Lengkap*</label>
                            <input type="email" class="form-control" name="email_penerima" id="email_penerima" aria-describedby="emailHelp" placeholder="Ketik disini">
                        </div>
                        <div class="form-group">
                            <label for="phone_penerima" class="fastcon-label cl-grey-900">Nomor HP*</label>
                            <input type="text" class="form-control" name="phone_penerima" id="phone_penerima" placeholder="Ketik disini">
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
					<a href="<?=site_url('checkout/summary')?>" class="mt-2">Temp link to checkout</a>
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