<section id="content">
    <div class="content-wrap">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h2 class="fastcon-h2 mb-20 text-uppercase">Pilihan masuk</h2>
                    <p class="fastcon-body">Masuk dan selesaikan pesanan dengan data pribadi Anda atau daftar untuk menikmati semua manfaat memiliki akun Fastcon.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-12 cart-option-wrap">
                    <div class="cart-option-login">
                        <h4 class="fastcon-h4 cl-primary-900">AKUN SAYA</h4>
                        <p class="fastcon-body">Silakan masuk ke akun Anda untuk menyelesaikan pembayaran dengan data pribadi Anda.</p>

                        <?=form_open(site_url('authentication'), ['class' => 'login-form', 'method' => 'post']);?>
	                        <?php if ($this->session->flashdata('error')): ?>
		                        
				                <div class="style-msg errormsg">
				                    <div class="sb-msg"><?=$this->session->flashdata('error');?></div>
				                </div>

				            <?php endif ?>

		                	<?php if ($this->session->flashdata('response')): ?>
				                <div class="style-msg successmsg">
				                    <div class="sb-msg"><?=$this->session->flashdata('response');?></div>
				                </div>
				            <?php endif ?>
                            
                            <div class="form-group">
	                            <label for="email" class="fastcon-label cl-grey-900">E-mail*</label>
	                            <input type="email" class="form-control" id="email" name="email" placeholder="Ketik disini">
	                        </div>

	                        <div class="form-group">
	                            <label for="password" class="fastcon-label cl-grey-900"><?=lang('password')?>* <a href="<?=site_url('forgot-password')?>" class="cl-grey-900">(<?=lang('forget_password')?>?)</a></label>
	                            <input type="password" class="form-control" id="password" name="password" placeholder="Ketik disini">
	                        </div>

	                        <div class="form-check p-0">
	                            <input type="checkbox" value="1" checked> <span class="fastcon-description cl-grey-900"><?=lang('remember_me')?></span>
	                        </div>

	                        <div class="btn-wrap">
	                            <button type="submit" class="fastcon-btn primary-btn"><?=lang('login')?></button>
	                        </div>

	                    <?=form_close();?>
                    </div>

                    
                </div>
                <div class="col-md-6 col-sm-12 cart-option-wrap cart-option-register">
                    <h4 class="fastcon-h4 cl-primary-900">LANJUT TANPA DAFTAR</h4>
                    <p class="fastcon-body">Masuk dengan mengisi data diri dan alamat pengiriman dengan cepat disini tanpa melakukan pendaftaran akun.</p>

                    <a href="<?=site_url('checkout/guest')?>" class="fastcon-btn secondary-btn width-md-fit">BAYAR TANPA DAFTAR</a>
                </div>
            </div>
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