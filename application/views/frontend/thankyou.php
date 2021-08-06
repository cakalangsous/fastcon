<section id="content">
    <div class="content-wrap">
        <div class="container">
            <div class="row">
                <div class="col-12 thankyou-wrap">
                    <?php if ($this->session->flashdata('response')): ?>

                        <img src="<?=BASE_ASSET?>fastcon/img/icons/thankyou.png" alt="Thank You">

                        <h2 class="fastcon-h2 cl-grey-900"><?=$this->session->flashdata('response')['title']?></h2>

                        <p class="fastcon-body"><?=$this->session->flashdata('response')['content']?></p>

                        <div class="button-wrap">
                            <a href="<?=site_url()?>" class="fastcon-btn secondary-btn text-uppercase"><?=lang('back_to_home')?></a>
                        </div>

                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</section>