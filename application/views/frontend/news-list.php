<section id="content">
    <div class="content-wrap">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="fastcon-h1 text-uppercase"><?=lang('news_list_title')?></h1>
                </div>
            </div>
            <div class="row fastcon-news">
                <?php foreach ($news as $n): ?>
                    <div class="col-lg-4 col-md-6 col-sm-12 fastcon-news-item">
                        <div class="news-img">
                            <a href="<?=site_url('news/details/'.$n->id.'/'.$n->slug)?>">
                                <img src="<?=site_url('uploads/fastcon_news/'.$n->image)?>" alt="<?=$n->title_en?>">
                                <div class="overlay"></div>
                            </a>
                        </div>

                        <div class="news-description">
                            <a href="<?=site_url('news/details/'.$n->id.'/'.$n->slug)?>">
                                <h3 class="fastcon-h3 text-uppercase news-title"><?=$lang=='indonesian'?$n->title:$n->title_en?></h3>
                            </a>
                            <p class="fastcon-label"><?=date('j F Y', strtotime($n->created_at))?></p>
                        </div>
                    </div>
                <?php endforeach ?>

            </div>
        </div>
    </div>
</section>