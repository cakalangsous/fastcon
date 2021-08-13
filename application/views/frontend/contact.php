<section id="banner" class="projects-banner contact-banner" style="background-image: url('<?=BASE_ASSET?>fastcon/img/contact-banner.jpg');">
    <div class="title-card">
        <h2 class="fastcon-h2"><?=lang('contact_us')?></h2>
    </div>
</section>

<section id="content">
    <div class="container large-only">
        <div class="breadcrumbs breadcrumbs-right mb-0">
            <span><?=lang('home')?></span> <span><?=lang('contact')?></span>
        </div>
    </div>

    <div class="content-wrap">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <div class="row contact-address-wrap">
                        <div class="col-md-6 fastcon-footer-about contact-about">
                            <h3 class="fastcon-h3 cl-primary-900 mb-20 text-uppercase"><?=lang('our_office')?></h3>
                            <?php foreach ($contact_settings as $cs): ?>
                                <?php if ($cs->setting_item=='office'): ?>
                                    <?=$cs->setting_value?>

                                    <a href="tel:<?=$cs->phone?>" class="fastcon-body"><?=$cs->phone?></a>
                                <?php endif ?>
                            <?php endforeach ?>
                        </div>

                        <div class="col-md-6 fastcon-footer-about contact-about">
                            <h3 class="fastcon-h3 cl-primary-900 mb-20 text-uppercase"><?=lang('our_factory')?></h3>
                            <?php foreach ($contact_settings as $cs): ?>
                                <?php if ($cs->setting_item=='factory'): ?>
                                    <?=$cs->setting_value?>

                                    <a href="tel:<?=$cs->phone?>" class="fastcon-body"><?=$cs->phone?></a>
                                <?php endif ?>
                            <?php endforeach ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 maps-wrap">
                            <?php
                                $maps = '';
                                foreach ($contact_settings as $cs) {
                                    if ($cs->setting_item=='maps') {
                                        $maps = $cs->setting_value;
                                    }
                                }
                            ?>
                            <iframe src="<?=strip_tags($maps)?>" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 col-sm-12">
                    <?php if ($this->session->flashdata('error')): ?>
                        
                        <div class="style-msg errormsg">
                            <div class="sb-msg"><?=$this->session->flashdata('error');?></div>
                        </div>

                    <?php endif ?>
                    <?=form_open(site_url('contact_submit'), ['class' => 'contact-form', 'method' => 'post']);?>

                        <div class="form-group">
                            <label for="name" class="fastcon-label cl-grey-900"><?=lang('fullname')?>*</label>
                            <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" placeholder="Ketik disini">
                        </div>

                        <div class="form-group">
                            <label for="email" class="fastcon-label cl-grey-900"><?=lang('email')?></label>
                            <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Ketik disini">
                        </div>

                        <div class="form-group">
                            <label for="phone" class="fastcon-label cl-grey-900"><?=lang('phone')?>*</label>
                            <input type="number" class="form-control" id="phone" name="phone" aria-describedby="emailHelp" placeholder="Ketik disini">
                        </div>

                        <div class="form-group">
                            <label class="fastcon-label cl-grey-900"><?=lang('topic')?>*</label>
                            <select class="form-control selectpicker" name="topic">
                                <?php foreach ($topic as $t): ?>
                                    <option value="<?=$t->topid_id?>"><?=$lang=='indonesian'?$t->topic_name:$t->topic_name_en?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="pesan" class="fastcon-label cl-grey-900"><?=lang('message')?>*</label>
                            <textarea class="form-control" id="pesan" rows="4" name="message"></textarea>
                        </div>

                        <p class="fastcon-description">*Wajib diisi</p>

                        <button type="submit" class="fastcon-btn primary-btn text-uppercase"><?=lang('send_message')?></button>

                    <?=form_close();?>
                </div>
            </div>
        </div>
    </div>
</section>
