<section id="content">
    <div class="content-wrap">
        <div class="container">
            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    <div class="forgot-wrap" style="width: 100%;">
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
                        <p class="fastcon-body mb-20"><?=lang('new_password_body')?></p>
                        <?=form_open(site_url('new_password_submit'), ['method' => 'post', 'class' => 'login-form']);?>
                            <div class="form-group">
                                <label for="password" class="fastcon-label cl-grey-900"><?=lang('password')?>*</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Ketik disini">
                            </div>
                            <input type="hidden" name="k" value="<?=$key?>">

                            <div class="form-group mb-0">
                                <label for="c_password" class="fastcon-label cl-grey-900"><?=lang('confirm_password')?>*</label>
                                <input type="password" class="form-control" name="c_password" id="c_password" placeholder="Ketik disini">
                            </div>

                            <div class="btn-wrap">
                                <button type="submit" class="fastcon-btn primary-btn w-100"><?=lang('update_password')?></button>
                            </div>
                        <?=form_close();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>