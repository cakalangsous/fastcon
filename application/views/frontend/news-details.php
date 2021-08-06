<section id="content">
    <div class="content-wrap">
        <div class="container">
            <div class="row">
                <div class="col-12 news-title">
                    <h1 class="fastcon-h1 text-uppercase"><?=$lang=='indonesian'?$news->title:$news->title_en?></h1>
                    <p class="fastcon-label"><?=date('d F Y', strtotime($news->created_at))?></p>
                </div>
            </div>

            <div class="row news-details-wrap">
                <div class="col-lg-6 col-md-12 news-content">
                    <?=$lang='indonesian'?$news->content:$news->content_en?>

                    <div class="share">
                        <p class="fastcon-description"><?=lang('share')?>:</p>
                        <a href="mailto:?subject=Fastcon - <?=$lang=='indonesian'?$news->title:$news->title_en?>&body=<?=$lang=='indonesian'?$news->title:$news->title_en .' <br> '. base_url(uri_string())?>'">
                            <img src="<?=BASE_ASSET?>fastcon/img/icons/email.png" alt="">
                        </a>
                        <a href="javascript:void(0)" onclick="javascript:window.open('https://www.facebook.com/sharer.php?u=<?=base_url(uri_string())?>',
                                        '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=800,width=800'); return false;">
                            <img src="<?=BASE_ASSET?>fastcon/img/icons/facebook.png" alt="">
                        </a>
                        <a href="javascript:void(0)" onclick="javascript:window.open('https://twitter.com/intent/tweet?text=Fastcon - <?=$lang=='indonesian'?$news->title:$news->title_en?> <?=base_url(uri_string())?>',
                                        '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                            <img src="<?=BASE_ASSET?>fastcon/img/icons/twitter.png" alt="">
                        </a>
                        <a href="https://wa.me/?text=<?=urlencode('Fastcon - '.$lang=='indonesian'?$news->title:$news->title_en.' '.base_url(uri_string()))?>" target="_blank">
                            <img src="<?=BASE_ASSET?>fastcon/img/icons/whatsapp.png" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 news-img">
                    <img src="<?=site_url('uploads/fastcon_news/'.$news->image)?>" width="100%" alt="<?=$lang='indonesian'?$news->title:$news->title_en?>">
                </div>
            </div>
        </div>
    </div>
</section>