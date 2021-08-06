<section id="content">
    <div class="member-wrapper">
        <?php include "_navbar.php";?>

        <div class="member-content-wrap">
            <?php if ($this->session->flashdata('welcome')): ?>
                <div class="login-alert">
                    <p class="fastcon-nav"><?=$this->session->flashdata('welcome')?></p>
                </div>
            <?php endif ?>
            <div class="member-container">
                <div class="content-wrap">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="fastcon-h2 cl-grey-900 text-uppercase">SELAMAT DATANG, <?=$member->fullname?>!</h2>

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
    
                            <?=form_open(site_url('member/update_profile'), ['class' => "edit-profile-wrap"]);?>
                                <div class="form-group">
                                    <label for="name" class="fastcon-label cl-grey-900"><?=lang('fullname')?>*</label>
                                    <input type="text" class="form-control" id="name" name="fullname" value="<?=$member->fullname?>" placeholder="Ketik disini">
                                </div>
    
                                <div class="form-group">
                                    <label for="email" class="fastcon-label cl-grey-900"><?=lang('email')?></label>
                                    <input type="email" class="form-control disabled" id="email" value="<?=$member->email?>" placeholder="Ketik disini" disabled>
                                </div>

                                <div class="form-group">
                                    <label for="password" class="fastcon-label cl-grey-900"><?=lang('password')?>*</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Ketik disini">
                                </div>
                                
                                <div class="form-group">
                                    <label for="c_password" class="fastcon-label cl-grey-900"><?=lang('confirm_password')?>*</label>
                                    <input type="password" class="form-control" id="c_password" name="c_password" placeholder="Ketik disini">
                                </div>

                                <div class="form-check pl-0">
                                    <input type="checkbox" value="1" checked> <span class="fastcon-description cl-grey-900">Saya menyetujui data pribadi Anda akan digunakan untuk mendukung pengalaman Anda di seluruh situs web ini</span>
                                </div>

                                <button type="submit" class="fastcon-btn primary-btn">SIMPAN</button>
                            <?=form_close();?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="address-wraper">
                                <h3 class="fastcon-h3 cl-grey-900 mb-30">DAFTAR ALAMAT</h3>
                                <a href="javascript:void(0)" id="add_address_btn" class="fastcon-btn secondary-btn w-100 text-center mb-20">+ TAMBAH ALAMAT</a>

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
                                                        GANTI ALAMAT
                                                    </a>
                                                </div>

                                            <?php endif ?>
                                            <div class="card-btn-wrap">
                                                <a href="javascript:void(0)" class="edit-link edit_address"
                                                    data-name='<?=$ma->name?>'
                                                    data-email='<?=$ma->email?>'
                                                    data-id='<?=$ma->id?>'
                                                    data-phone='<?=$ma->phone?>'
                                                    data-address='<?=$ma->address?>'
                                                >
                                                    <h4 class="fastcon-h4 cl-primary-900">
                                                        <img src="<?=BASE_ASSET?>fastcon/img/icons/pencil.png" alt="">
                                                        UBAH
                                                    </h4>
                                                </a>
        
                                                <a href="<?=site_url('member/delete_address/'.$ma->id)?>" class="edit-link">
                                                    <h4 class="fastcon-h4 cl-error">
                                                        <img src="<?=BASE_ASSET?>fastcon/img/icons/trash.png" alt="">
                                                        HAPUS
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

    </div>
</section>

<div class="modal centered fade form-address-modal" id="address_modal_form" tabindex="-1" role="dialog" aria-labelledby="addressModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-body">
            <div class="modal-content">
                <div class="modal-body">
                    <?=form_open(site_url('member/save_address'), ['class' => "guest-form", 'id' => 'address_form_member']);?>
                        <div class="row">
                            <div class="col-12">
                                <h4 class="fastcon-h4 cl-primary-900"><img src="<?=BASE_ASSET?>fastcon/img/icons/contact.png" alt="">  DATA DIRI</h4>
                                <hr />
                                <div class="form-group">
                                    <label for="email" class="fastcon-label cl-grey-900">Nama lengkap*</label>
                                    <input type="text" class="form-control" name="fullname" placeholder="Ketik disini">
                                </div>
                                <div class="form-group">
                                    <label for="email" class="fastcon-label cl-grey-900">E-mail*</label>
                                    <input type="email" class="form-control" name="email" placeholder="Ketik disini">
                                </div>
                                <div class="form-group">
                                    <label for="phone" class="fastcon-label cl-grey-900">NOMOR HP*</label>
                                    <input type="text" class="form-control" name="phone" placeholder="Ketik disini">
                                </div>

                                <div class="form-group">
                                    <label for="kota_kecamatan" class="fastcon-label cl-grey-900">Kota, Kecamatan atau Kelurahan*</label>
                                    <input type="text" id="kota_kecamatan" name="kota_kecamatan" class="form-control" placeholder="Tulis minimal 3 karakter" autocomplete="on">
                                    <div id="auto_result" class="frontbox"></div>
                                </div>

                                <div class="form-group mb-0">
                                    <label for="address" class="fastcon-label cl-grey-900">Alamat Lengkap*</label>
                                    <textarea class="form-control" id="address" rows="4" name="address"></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12 button-submit-wrap">
                                <button class="fastcon-btn primary-btn">TAMBAH ALAMAT</button>
                                <a href="#" class="fastcon-btn secondary-btn" data-dismiss="modal" aria-hidden="true">KEMBALI</a>
                            </div>
                        </div>
                    <?=form_close();?>
                </div>
            </div>
        </div>
    </div>
</div>

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