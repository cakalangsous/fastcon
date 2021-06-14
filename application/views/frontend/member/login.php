<section id="content">
    <div class="content-wrap login-wrap">
        <div class="container">
            <div class="row login-wrapper">
                <div class="col-lg-6 col-md-12 login-title-wrap">
                    <h1 class="fastcon-h1 cl-grey-900 mb-20">MASUK KE AKUN ANDA</h1>
                    <p class="fastcon-body">Masuk ke akun Anda agar dapat menikmati banyak promo menarik dan melihat histori sampai status transaksi lewat website.</p>
                </div>

                <div class="col-lg-6 col-md-12 login-form-wrap">
                    <form action="#" class="login-form">

                        <div class="form-group">
                            <label for="email" class="fastcon-label cl-grey-900">E-mail*</label>
                            <input type="email" class="form-control" id="email" placeholder="Ketik disini">
                        </div>

                        <div class="form-group">
                            <label for="password" class="fastcon-label cl-grey-900">KATA SANDI* (LUPA KATA SANDI?)</label>
                            <input type="password" class="form-control" id="password" placeholder="Ketik disini">
                        </div>

                        <div class="form-check p-0">
                            <input type="checkbox" value="1" checked> <span class="fastcon-description cl-grey-900">Ingat saya</span>
                        </div>

                        <div class="btn-wrap">
                            <button type="submit" class="fastcon-btn primary-btn">MASUK</button>
                            <a href="<?=site_url('member/register')?>" class="fastcon-btn secondary-btn">BELUM PUNYA AKUN?</a>
                        </div>

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