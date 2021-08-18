<section id="content">
    <div class="content-wrap">
        <div class="container">
            <div class="row register-title-wrap">
                <div class="col-12 text-center">
                    <h1 class="fastcon-h1 cl-grey-900 text-uppercase"><?=lang('fill_register_form')?></h1>
                </div>
            </div>

            <?php if ($this->session->flashdata('error')): ?>
                        
                <div class="style-msg errormsg">
                    <div class="sb-msg"><?=$this->session->flashdata('error');?></div>
                </div>

            <?php endif ?>

            <div class="row">
                <div class="col-12">
                    <h4 class="fastcon-h4 cl-primary-900 mb-30 text-uppercase"><img src="<?=BASE_ASSET?>fastcon/img/icons/contact.png" alt="">  <?=lang('personal_data')?></h4>
                    <?=form_open(site_url('register_submit'), ['method' => "post", 'class' => "register-form"]);?>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="fullname" class="fastcon-label cl-grey-900"><?=lang('fullname')?>*</label>
                                    <input type="text" class="form-control" id="fullname" name="fullname" placeholder="<?=lang('enter_here')?>">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="email" class="fastcon-label cl-grey-900"><?=lang('email')?>*</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="<?=lang('enter_here')?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="password" class="fastcon-label cl-grey-900"><?=lang('password')?>*</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="<?=lang('enter_here')?>">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="c_password" class="fastcon-label cl-grey-900"><?=lang('confirm_password')?>*</label>
                                    <input type="password" class="form-control" id="c_password" name="c_password" placeholder="<?=lang('enter_here')?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-check">
                                <input type="checkbox" value="1" checked id="agree"> <span class="fastcon-description cl-grey-900"><?=lang('personal_data_agree')?></span>
                            </div>
                        </div> 

                        <div class="btn-wrap">
                            <button type="submit" class="fastcon-btn primary-btn text-uppercase"><?=lang('register_now')?></button>
                        </div>
                    <?=form_close();?>
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