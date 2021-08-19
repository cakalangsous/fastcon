<section id="content">
    <div class="content-wrap">
        <div class="container">
            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    <div class="forgot-wrap">
                        <?php if ($this->session->userdata('error')): ?>
                            <div class="fastcon-alert fastcon-alert-error">
                                <div class="alert-header">
                                    <p class="alert-title"></p>
                                </div>
                                <div class="alert-body">
                                    <p class="alert-message"><?=$this->session->userdata('error')?></p>
                                </div>
                            </div>
                        <?php endif ?>
                        <p class="fastcon-body mb-20"><?=lang('reset_password_body')?>.</p>
                        <?=form_open(site_url('forgot_password_submit'), ['method' => 'post', 'class' => 'login-form']);?>
                            <div class="form-group mb-0">
                                <label for="email" class="fastcon-label cl-grey-900">E-mail*</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="<?=lang('enter_here')?>">
                            </div>

                            <div class="btn-wrap">
                                <button type="submit" class="fastcon-btn primary-btn text-uppercase"><?=lang('reset_password')?></button>

                                <a href="<?=site_url('member/login')?>" class="fastcon-btn secondary-btn"><?=lang('back')?></a>
                            </div>
                        <?=form_close();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>