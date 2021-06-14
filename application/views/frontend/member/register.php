<section id="content">
    <div class="content-wrap">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="fastcon-h1 cl-grey-900 text-uppercase">mohon isi formulir pendaftaran</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <h4 class="fastcon-h4 cl-primary-900 mb-30"><img src="<?=BASE_ASSET?>fastcon/img/icons/contact.png" alt="">  DATA DIRI</h4>
                    <form action="#" class="register-form">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="email" class="fastcon-label cl-grey-900">Nama lengkap*</label>
                                    <input type="text" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Ketik disini">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="email" class="fastcon-label cl-grey-900">E-mail*</label>
                                    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Ketik disini">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="phone" class="fastcon-label cl-grey-900">KATA SANDI*</label>
                                    <input type="password" class="form-control" id="phone" placeholder="Ketik disini">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="phone" class="fastcon-label cl-grey-900">ULANGI KATA SANDI*</label>
                                    <input type="password" class="form-control" id="phone" placeholder="Ketik disini">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-check">
                                <input type="checkbox" value="1" checked> <span class="fastcon-description cl-grey-900">Saya menyetujui data pribadi Anda akan digunakan untuk mendukung pengalaman Anda di seluruh situs web ini</span>
                            </div>
                        </div> 

                        <div class="btn-wrap">
                            <button type="submit" class="fastcon-btn primary-btn text-uppercase">daftar sekarang</button>

                        </div>
                        <a href="<?=site_url('member/dashboard')?>">Temp link to member dashboard</a>
                    </form>
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