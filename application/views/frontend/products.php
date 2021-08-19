<section id="content">
    <div class="content-wrap">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h2 class="fastcon-h2">PRODUK PILIHAN</h2>
                </div>
            </div>

            <div class="row products-wrap">
                <div class="col-12">
                    <div class="tabs-bb clearfix">

                        <ul class="tab-nav clearfix text-center large-medium-only">
                            <li <?=$this->input->get('c')==null?'class="ui-tabs-active"':''?>><a href="<?=site_url('products')?>"><?=lang('all_products')?></a></li>
                            <?php foreach ($product_category as $pc): ?>
                                <li <?=$this->input->get('c')==$pc->category_id?'class="ui-tabs-active"':''?>><a href="<?=site_url('products?c='.$pc->category_id)?>"><?=$lang=='indonesian'?$pc->category_name:$pc->category_name_en?></a></li>
                            <?php endforeach ?>
                        </ul>

                        <div class="tab-container">

                            <div class="tab-content clearfix">
                                <div class="row">

                                    <div class="col-lg-3 col-md-6 col-sm-12 small-only">
                                        <div class="form-group">
                                            <label class="fastcon-label cl-grey-900">KATEGORI</label>
                                            <select class="form-control selectpicker select-change-page">
                                                <option value=""><?=lang('all_products')?></option>
                                                <?php foreach ($product_category as $pc): ?>
                                                    <option value="<?=site_url('products?c='.$pc->category_id)?>" <?=$this->input->get('c')==$pc->category_id?'selected':''?> ><?=$lang=='indonesian'?$pc->category_name:$pc->category_name_en?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="fastcon-label cl-grey-900">URUTKAN BERDASARKAN</label>
                                            <select class="form-control selectpicker select-change-page">
                                                <option value="<?=site_url('products?s=1')?>" <?=($this->input->get('s') AND $this->input->get('s')==1)?'selected':''?>>Terbaru</option>
                                                <option value="<?=site_url('products?s=2')?>" <?=($this->input->get('s') AND $this->input->get('s')==2)?'selected':''?>>Alphabet A-Z</option>
                                                <option value="<?=site_url('products?s=3')?>" <?=($this->input->get('s') AND $this->input->get('s')==3)?'selected':''?>>Alphabet Z-A</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="fastcon-label cl-grey-900">LIHAT</label>
                                            <select class="form-control selectpicker select-change-page">
                                                <option value="<?=check_query_string() ?current_url_query().'&l=12':site_url('products?l=12')?>" <?=($this->input->get('l')!=null AND $this->input->get('l')==12)?'selected':''?>>12 per halaman</option>
                                                <option value="<?=check_query_string() ?current_url_query().'&l=18':site_url('products?l=18')?>" <?=($this->input->get('l')!=null AND $this->input->get('l')==18)?'selected':''?>>18 per halaman</option>
                                                <option value="<?=check_query_string() ?current_url_query().'&l=24':site_url('products?l=24')?>" <?=($this->input->get('l')!=null AND $this->input->get('l')==24)?'selected':''?>>24 per halaman</option>
                                                <option value="<?=check_query_string() ?current_url_query().'&l=48':site_url('products?l=48')?>" <?=($this->input->get('l')!=null AND $this->input->get('l')==48)?'selected':''?>>48 per halaman</option>
                                                <option value="<?=check_query_string() ?current_url_query().'&l=60':site_url('products?l=60')?>" <?=($this->input->get('l')!=null AND $this->input->get('l')==60)?'selected':''?>>60 per halaman</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="row fastcon-product-list">

                                    <?php foreach ($products as $p): ?>
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <a href="<?=site_url('products/details/'.$p->product_id.'/'.$p->product_slug)?>" class="product-item">
                                                <div class="product-img">
                                                    <img src="<?=site_url('uploads/fastcon_product/'.explode(',', $p->product_images)[0] )?>" alt="<?=$p->product_name?>">
                                                </div>
        
                                                <div class="product-desc">
                                                    <p class="fastcon-description cl-grey-900 text-uppercase"><?=db_get_row_data('fastcon_product_category', ['category_id' => $p->product_category])->category_name ?></p>
                                                    <h4 class="fastcon-h4"><?=$p->product_name?></h4>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endforeach ?>
                                    
                                </div>
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
</section>