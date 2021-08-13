<nav class="member-navbar">
    <div class="content-wrap">
        <ul class="member-menu">
            <li <?=$member_menu=='dashboard'?'class="active"':'' ?> ><a href="<?=site_url('member/dashboard')?>"><?=lang('profile')?></a></li>
            <li <?=$member_menu=='history'?'class="active"':'' ?>><a href="<?=site_url('member/history')?>"><?=lang('transaction_history')?></a></li>
            <li <?=$member_menu=='coupon'?'class="active"':'' ?>><a href="<?=site_url('member/coupon')?>"><?=lang('coupon')?> (<?=$total_coupon?>)</a></li>
            <li><a href="javascript:void(0)" data-toggle="modal" data-target="#logout_modal"><?=lang('logout')?> <img src="<?=BASE_ASSET?>fastcon/img/icons/logout.png" alt=""></a></li>
        </ul>
    </div>
</nav>

<nav class="member-nav medium-small-only">
    <div class="w-100 medium-small-only">
        <select class="form-control selectpicker rounded-0 select-change-page member-nav-select">
            <option value="<?=site_url('member/dashboard')?>" <?=$member_menu=='dashboard'?'selected':'' ?>><?=lang('profile')?></option>
            <option value="<?=site_url('member/history')?>" <?=$member_menu=='history'?'selected':'' ?>><?=lang('transaction_history')?></option>
            <option value="<?=site_url('member/coupon')?>" <?=$member_menu=='coupon'?'selected':'' ?>><?=lang('coupon')?> (<?=$total_coupon?>)</option>
            <option value="logout"><?=lang('logout')?></option>
        </select>
    </div>
</nav>