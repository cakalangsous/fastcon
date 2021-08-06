<section id="banner" class="projects-banner" style="background-image: url('<?=BASE_ASSET?>fastcon/img/about-banner.jpg');">
    <div class="title-card">
        <?php 
            $show_title = '';
            if (isset($about_active)) {
                if ($about_active=='about') {
                    $show_title = 'Tentang Perusahaan';
                }else {
                    $show_title = 'Visi dan Misi';
                }
            }else {
                $show_title = $lang=='indonesian'?$content->title:$content->title_en;
            }
        ?>
        <h2 class="fastcon-h2"><?=$show_title?></h2>
    </div>
</section>

<section id="content">
    <div class="container large-only">
        <div class="breadcrumbs breadcrumbs-right mb-0">
            <span><?=lang('home')?></span> <span><?=$show_title?></span>
        </div>
    </div>
    <div class="content-wrap">
        <div class="container">
            <div class="row">
                <div class="col-12 about-wrap">
                    <div class="tabs-bb clearfix">
                        <ul class="tab-nav clearfix text-center large-medium-only">
                            <li <?=isset($about_active) && $about_active=='about'?'class="ui-tabs-active"':''?>><a href="<?=site_url('about')?>"><?=lang('about_company')?></a></li>
                            <li <?=isset($about_active) && $about_active=='vision'?'class="ui-tabs-active"':''?>><a href="<?=site_url('vision_mission')?>"><?=lang('vision_mission')?></a></li>


                            <?php foreach (db_get_all_data('fastcon_pages') as $p): ?>
                                <li <?=(!isset($about_active) AND $content->id==$p->id)?'class="ui-tabs-active"':''?>><a href="<?=site_url('page/'.$p->id.'/'.$p->slug)?>"><?=$lang=='indonesian'?$p->title:$p->title_en?></a></li>
                            <?php endforeach ?>
                        </ul>

                        <div class="tab-container">
                            <div class="tab-content clearfix">
                                <div class="row">
                                    <div class="col-lg-3 col-md-6 col-sm-12 small-only">
                                        <div class="form-group">
                                            <label class="fastcon-label cl-grey-900">KATEGORI</label>
                                            <select class="form-control selectpicker select-change-page">
                                                <option value="<?=site_url('about')?>" <?=isset($about_active) && $about_active=='about'?'selected':''?>><?=lang('about_company')?></option>
                                                <option value="<?=site_url('vision_mission')?>" <?=isset($about_active) && $about_active=='vision'?'selected':''?>><?=lang('vision_mission')?></option>

                                                <?php foreach (db_get_all_data('fastcon_pages') as $p): ?>
                                                    <option value="<?=site_url('page/'.$p->id.'/'.$p->slug)?>" <?=(!isset($about_active) AND $content->id==$p->id)?'selected':''?>><?=$lang=='indonesian'?$p->title:$p->title_en?></option>
                                                <?php endforeach ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 about-content">
                                        <?php 
                                            $show_content = '';
                                            if (isset($about_active)) {
                                                if ($about_active=='about') {
                                                    if ($lang=='indonesian') {
                                                        $show_content = $content->about;
                                                    }else {
                                                        $show_content = $content->about_en;
                                                    }
                                                }else {
                                                    if ($lang=='indonesian') {
                                                        $show_content = $content->vision_mission;
                                                    }else {
                                                        $show_content = $content->vision_mission_en;
                                                    }
                                                }
                                            }else {
                                                $show_content = $lang=='indonesian'?$content->content:$content->content_en;
                                            }
                                        ?>

                                        <?=$show_content;?>
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