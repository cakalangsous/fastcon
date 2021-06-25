<nav class="member-navbar">
    <div class="content-wrap">
        <ul class="member-menu">
            <li class="active"><a href="<?=site_url('member/dashboard')?>">Profil</a></li>
            <li><a href="<?=site_url('member/history')?>">HISTORI TRANSAKSI</a></li>
            <li><a href="<?=site_url('member/coupon')?>">KUPON BELANJA (3)</a></li>
            <li><a href="javascript:void(0)" data-toggle="modal" data-target=".logout-modal">KELUAR <img src="<?=BASE_ASSET?>fastcon/img/icons/logout.png" alt=""></a></li>
        </ul>
    </div>
</nav>

<nav class="member-nav medium-small-only">
    <div class="w-100 medium-small-only">
        <select class="form-control selectpicker rounded-0 select-change-page member-nav-select">
            <option value="<?=site_url('member/dashboard')?>">Profil</option>
            <option value="<?=site_url('member/history')?>">HISTORI TRANSAKSI</option>
            <option value="<?=site_url('member/coupon')?>">KUPON BELANJA (3)</option>
            <option value="logout">KELUAR</option>
        </select>
    </div>
</nav>