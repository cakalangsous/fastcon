<section id="content">
    <div class="member-wrapper">
        <?php include "_navbar.php";?>

        <div class="member-content-wrap">
            <div class="login-alert">
                <p class="fastcon-nav">ANDA BERHASIL LOGIN!</p>
            </div>
            <div class="member-container">
                <div class="content-wrap">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="fastcon-h2 cl-grey-900 text-uppercase">SELAMAT DATANG, EKA RAHARJO!</h2>
    
                            <form action="#" class="edit-profile-wrap">
                                <div class="form-group">
                                    <label for="name" class="fastcon-label cl-grey-900">Nama Lengkap*</label>
                                    <input type="text" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Ketik disini">
                                </div>
    
                                <div class="form-group">
                                    <label for="email" class="fastcon-label cl-grey-900">E-mail</label>
                                    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Ketik disini">
                                </div>

                                <div class="form-group">
                                    <label for="phone" class="fastcon-label cl-grey-900">KATA SANDI*</label>
                                    <input type="password" class="form-control" id="phone" placeholder="Ketik disini">
                                </div>
                                
                                <div class="form-group">
                                    <label for="phone" class="fastcon-label cl-grey-900">ULANGI KATA SANDI*</label>
                                    <input type="password" class="form-control" id="phone" placeholder="Ketik disini">
                                </div>

                                <div class="form-check pl-0">
                                    <input type="checkbox" value="1" checked> <span class="fastcon-description cl-grey-900">Saya menyetujui data pribadi Anda akan digunakan untuk mendukung pengalaman Anda di seluruh situs web ini</span>
                                </div>

                                <button type="submit" class="fastcon-btn primary-btn">SIMPAN</button>
                            </form>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="address-wraper">
                                <h3 class="fastcon-h3 cl-grey-900 mb-30">DAFTAR ALAMAT</h3>
                                <a href="#" class="w-100 text-center fastcon-btn secondary-btn">+ TAMBAH ALAMAT</a>

                                <div class="address-wrap active">
                                    <div class="title-wrap">
                                        <h4 class="fastcon-h4 cl-primary-900">DATA PENGIRIMAN</h4>
                                    </div>

                                    <div class="address-card">
                                        <p class="receiver-name">Eka Raharjo</p>
                                        <p class="receiver-email">ekaraharjo@gmail.com</p>
                                        <p class="receiver-email">081234567890</p>
                                        <p class="address">Jln. HOS. Cokroaminoto, Kel. Tulungrejo, Kediri, Jawa Timur, 64212 (Sebelah toko listrik Sinar Jaya) DEDDY HERMAWAN 082211334455</p>
                                    </div>

                                    <div class="address-links">
                                        <a href="#" class="edit-link">
                                            <h4 class="fastcon-h4 cl-primary-900">
                                                <img src="<?=BASE_ASSET?>fastcon/img/icons/pencil.png" alt="">
                                                UBAH
                                            </h4>
                                        </a>

                                        <a href="#" class="edit-link">
                                            <h4 class="fastcon-h4 cl-error">
                                                <img src="<?=BASE_ASSET?>fastcon/img/icons/trash.png" alt="">
                                                Hapus
                                            </h4>
                                        </a>
                                    </div>
                                </div>

                                <div class="address-wrap">
                                    <div class="title-wrap">
                                        <h4 class="fastcon-h4 cl-primary-900">DATA PENGIRIMAN</h4>
                                    </div>

                                    <div class="address-card">
                                        <p class="receiver-name">Eka Raharjo</p>
                                        <p class="receiver-email">ekaraharjo@gmail.com</p>
                                        <p class="receiver-email">081234567890</p>
                                        <p class="address">Jln. HOS. Cokroaminoto, Kel. Tulungrejo, Kediri, Jawa Timur, 64212 (Sebelah toko listrik Sinar Jaya) DEDDY HERMAWAN 082211334455</p>
                                    </div>

                                    <div class="address-links">
                                        <a href="#" class="fastcon-btn secondary-btn">
                                            GANTI ALAMAT
                                        </a>
                                        <a href="#" class="edit-link">
                                            <h4 class="fastcon-h4 cl-primary-900">
                                                <img src="<?=BASE_ASSET?>fastcon/img/icons/pencil.png" alt="">
                                                UBAH
                                            </h4>
                                        </a>

                                        <a href="#" class="edit-link">
                                            <h4 class="fastcon-h4 cl-error">
                                                <img src="<?=BASE_ASSET?>fastcon/img/icons/trash.png" alt="">
                                                Hapus
                                            </h4>
                                        </a>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
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