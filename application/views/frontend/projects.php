<section id="banner" class="projects-banner" style="background-image: url('<?=BASE_ASSET?>fastcon/img/projects/banner.jpg');">
    <div class="title-card">
        <h2 class="fastcon-h2"><?=lang('project_list_title')?></h2>
    </div>
</section>
<section id="content">
    <div class="container large-only">
        <div class="breadcrumbs breadcrumbs-right mb-0">
            <span><?=lang('home')?></span> <span><?=lang('project')?></span>
        </div>
    </div>
    <div class="content-wrap project-list-wrap">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="tabs-bb clearfix">
                        <ul class="tab-nav clearfix text-center large-medium-only">
                            <li class="<?=$this->input->get('c')==null?'ui-tabs-active':''?>"><a href="<?=site_url('projects')?>"><?=lang('all_projects')?></a></li>
                            <?php foreach ($project_category as $pc): ?>
                                <li class="<?=$this->input->get('c')==$pc->category_id?'ui-tabs-active':''?>"><a href="<?=site_url('projects?c='.$pc->category_id)?>"><?=$lang=='indonesian'?$pc->category_name:$pc->category_name_en?></a></li>
                            <?php endforeach ?>
                        </ul>
                        <div class="col-sm-12 small-only">
                            <div class="form-group">
                                <label class="fastcon-label cl-grey-900">KATEGORI</label>
                                <select class="form-control selectpicker select-change-page">
                                    <option value="<?=site_url('projects')?>" <?=$this->input->get('c')==null?'selected':''?>><?=lang('all_projects')?></option>
                                    <?php foreach ($project_category as $pc): ?>
                                        <option value="<?=site_url('projects?c='.$pc->category_id)?>" <?=$this->input->get('c')==$pc->category_id?'selected':''?> ><?=$lang=='indonesian'?$pc->category_name:$pc->category_name_en?></option>
                                    <?php endforeach ?>   
                                </select>
                            </div>
                        </div>
                        <div class="tab-container projects-tab-container">
                            <div class="tab-content clearfix">
                                <div class="row projects-wrap">
                                    
                                    <?php $i=0; foreach ($projects as $p): ?>
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
                                                    $pc = db_get_row_data('fastcon_project_category', ['category_id' => $p->category]);
                                                ?>
                                                <p class="category"><?=$lang=='indonesian'?$pc->category_name:$pc->category_name_en?></p>
                                                <a href="<?=site_url('projects/details/'.$p->id.'/'.$p->slug)?>">
                                                    <h3 class="fastcon-h3 text-uppercase"><?=$lang=='indonesian'?$p->title:$p->title_en?></h3>
                                                </a>
                                                <p class="fastcon-body"><?=$lang=='indonesian'?$p->short_desc:$p->short_desc_en?></p>
                                            </div>
                                        </div>
                                    <?php $i++; endforeach ?>

                                    <div class="pagination-wrap">
                                        <?=$pagination?>
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