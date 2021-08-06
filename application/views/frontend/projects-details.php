<section id="content">
    <div class="content-wrap">
        <div class="container">
            <div class="row project-details-content-wrap">
                <div class="col-lg-4 project-content">
                    <div class="project-content-header">
                        <?php 
                            $cat = db_get_row_data('fastcon_project_category', ['category_id' => $project->category]);
                        ?>
                        <p class="fastcon-description"><?=$lang=='indonesian'?$cat->category_name:$cat->category_name_en?></p>
                        <h1 class="fastcon-h1 cl-grey-900"><?=$lang=='indonesian'?$project->title:$project->title_en?></h1>
                    </div>

                    <div class="project-content-body">
                        <?=$lang=='indonesian'?$project->content:$project->content_en?>
                    </div>

                    <div class="share">
                        <p class="fastcon-description"><?=lang('share')?>:</p>
                        <a href="mailto:?subject=Fastcon - <?=$lang=='indonesian'?$project->title:$project->title_en?>&body=<?=$lang=='indonesian'?$project->title:$project->title_en?> <?=' <br> '. base_url(uri_string())?>">
                            <img src="<?=BASE_ASSET?>fastcon/img/icons/email.png" alt="">
                        </a>
                        <a href="javascript:void(0)" onclick="javascript:window.open('https://www.facebook.com/sharer.php?u=<?=base_url(uri_string())?>',
                                        '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=800,width=800'); return false;">
                            <img src="<?=BASE_ASSET?>fastcon/img/icons/facebook.png" alt="">
                        </a>
                        <a href="javascript:void(0)" onclick="javascript:window.open('https://twitter.com/intent/tweet?text=Fastcon - <?=$lang=='indonesian'?$project->title:$project->title_en?> <?=base_url(uri_string())?>',
                                        '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                            <img src="<?=BASE_ASSET?>fastcon/img/icons/twitter.png" alt="">
                        </a>
                        <a href="https://wa.me/?text=<?=urlencode('Fastcon - '.$lang=='indonesian'?$project->title:$project->title_en.' '.base_url(uri_string()))?>" target="_blank">
                            <img src="<?=BASE_ASSET?>fastcon/img/icons/whatsapp.png" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-8 large-medium-only">
                    <div id="oc-images" class="owl-carousel image-carousel carousel-widget" data-items-xs="1" data-items-sm="1" data-items-lg="1" data-items-xl="1" data-nav="false" data-autoplay="4000" data-loop="true" data-speed="1000">

                        <?php foreach (explode(',', $project->images) as $img): ?>
                            
                            <div class="oc-item">
                                <a href="javascript:void(0)"><img src="<?=site_url('uploads/fastcon_projects/'.$img)?>" alt="<?=$project->title_en?>"></a>
                            </div>

                        <?php endforeach ?>
                    </div>
                </div>
            </div>

            <?php if ($related_project): ?>
                
                <div class="row projects-wrap project-details-related">
                    <div class="col-12 related-title">
                        <h3 class="fastcon-h3">PROYEK TERKAIT</h3>
                    </div>

                    <?php $i=0; foreach ($related_project as $p): ?>
                        <?php 
                            $class = 'right';
                            if ($i%2==0) {
                                $class = 'left';
                            }
                        ?>
                        <div class="col-md-6 col-sm-12 project-item <?=$class?>">
                            <div class="project-img">
                                <a href="<?=site_url('projects/details/'.$p->id.'/'.$p->slug)?>">
                                    <img src="<?=site_url('uploads/fastcon_projects/'.explode(',', $p->images)[0])?>" alt="">
                                    <div class="overlay"></div>
                                </a>
                            </div>
                            <div class="project-description">
                                <?php 
                                    $cat = db_get_row_data('fastcon_project_category', ['category_id' => $p->category]);
                                ?>
                                <p class="category"><?=$lang=='indonesian'?$cat->category_name:$cat->category_name_en?></p>
                                <a href="<?=site_url('projects/details/1/asdf')?>">
                                    <h3 class="fastcon-h3 text-uppercase"><?=$lang=='indonesian'?$p->title:$p->title_en?></h3>
                                </a>
                                <p class="fastcon-body"><?=$lang=='indonesian'?substr(strip_tags($p->content), 0, 100):substr(strip_tags($p->content_en), 0, 100)?></p>
                            </div>
                        </div>
                    <?php $i++; endforeach ?>
                </div>

            <?php endif ?>

        </div>
    </div>
    <div class="small-only project-details-slider-mobile">
        <div id="oc-images" class="owl-carousel image-carousel carousel-widget" data-items-xs="1" data-items-sm="1" data-items-lg="1" data-items-xl="1" data-nav="false" data-autoplay="4000" data-loop="true">

           <?php foreach (explode(',', $project->images) as $img): ?>
                            
                <div class="oc-item">
                    <a href="javascript:void(0)"><img src="<?=site_url('uploads/fastcon_projects/'.$img)?>" alt="<?=$project->title_en?>"></a>
                </div>

            <?php endforeach ?>
        </div>
    </div>
    <div class="project-slider-bg"></div>
</section>