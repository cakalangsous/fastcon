<section id="banner" class="projects-banner" style="background-image: url('<?=BASE_ASSET?>fastcon/img/dist.jpg');">
    <div class="title-card">
        <h2 class="fastcon-h2"><?=lang('distributor_list_title')?></h2>
    </div>
</section>
<section id="content">
    <div class="container large-only">
        <div class="breadcrumbs breadcrumbs-right mb-0">
            <span><?=lang('home')?></span> <span><?=lang('distributor')?></span>
        </div>
    </div>
    <div class="content-wrap">
        <div class="container">

            <div class="select-wrapper small-only">
                <div class="form-group">
                    <label class="fastcon-label cl-grey-900">Provinsi</label>
                    <select class="form-control selectpicker select-change-page">
                        <option value="<?=site_url('distributor')?>">Semua Provinsi</option>
                        <?php foreach ($province as $p): ?>
                            <option value="<?=site_url('distributor?p='.$p->province_id)?>" <?=$this->input->get('p')==$p->province_id?'selected':''?>><?=$lang=='indonesian'?$p->province_name:$p->province_name_en?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>

            <div class="nav-wrapper">
                <div class="w-100">
                    <div class="large-medium-only">
                        <div class="scroller scroller-left float-left"><i class="icon-chevron-left"></i></div>
                        <div class="scroller scroller-right float-right"><i class="icon-chevron-right"></i></div>
                        <div class="wrapper">
                            <nav class="nav nav-tabs list" id="myTab" role="tablist">
                                <a class="nav-item nav-link <?=$this->input->get('p')==null?'active':''?>" href="<?=site_url('distributor')?>">Semua Provinsi</a>
                                <?php foreach ($province as $p): ?>
                                    <a class="nav-item nav-link <?=$this->input->get('p')==$p->province_id?'active':''?>" href="<?=site_url('distributor?p='.$p->province_id)?>"><?=$lang=='indonesian'?$p->province_name:$p->province_name_en?></a>
                                <?php endforeach ?>

                            </nav>
                        </div>
                    </div>
                    <div class="tab-content corin-tab-content" id="myTabContent">
                        <div class="tab-pane fade active show">
                            <div class="container">
                                <div class="row fastcon-distributor-wrap">
                                    <div class="col-lg-6 col-md-12">
                                        <?php foreach ($dist as $d): ?>
                                            
                                            <div class="distributor-item">
                                                <div class="distributor-title">
                                                    <h3 class="fastcon-h3 cl-primary-900"><?=$d->distributor_name?></h3>
                                                </div>
                                                <?php foreach (db_get_all_data('fastcon_distributor_branch', ['distributor_id' => $d->id]) as $db): ?>
                                                    <div class="distributor-body">
                                                        <p class="distributor-body-title"><?=$db->distributor_city?></p>
                                                        <p class="fastcon-body"><?=$db->distributor_address?></p>
                                                        <p class="fastcon-body"><?=$db->phone?></p>
                                                    </div>
                                                <?php endforeach ?>
                                            </div>

                                        <?php endforeach ?>
    
                                        <!-- <div class="distributor-item">
                                            <div class="distributor-title">
                                                <h3 class="fastcon-h3 cl-primary-900">PT. AGUS JAYA SAKTI</h3>
                                            </div>
                                            <div class="distributor-body">
                                                <p class="distributor-body-title">Surabaya, MADURA, MALANG, BLORA</p>
                                                <p class="fastcon-body">JL. BONGKARAN NO. 65 BONGKARAN, PABEAN CANTIAN SURABAYA</p>
                                                <p class="fastcon-body">031-3550492 / 082245751438</p>
                                            </div>
                                        </div>
    
                                        <div class="distributor-item">
                                            <div class="distributor-title">
                                                <h3 class="fastcon-h3 cl-primary-900">PT. AGUS JAYA SAKTI</h3>
                                            </div>
                                            <div class="distributor-body">
                                                <p class="distributor-body-title">Surabaya, MADURA, MALANG, BLORA</p>
                                                <p class="fastcon-body">JL. BONGKARAN NO. 65 BONGKARAN, PABEAN CANTIAN SURABAYA</p>
                                                <p class="fastcon-body">031-3550492 / 082245751438</p>
                                            </div>
                                            <div class="distributor-body">
                                                <p class="distributor-body-title">Surabaya, MADURA, MALANG, BLORA</p>
                                                <p class="fastcon-body">JL. BONGKARAN NO. 65 BONGKARAN, PABEAN CANTIAN SURABAYA</p>
                                                <p class="fastcon-body">031-3550492 / 082245751438</p>
                                            </div>
                                        </div> -->


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
