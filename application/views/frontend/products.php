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
                            <li class="ui-tabs-active"><a href="#">Semua Produk</a></li>
                            <?php foreach ($product_category as $pc): ?>
                                <li><a href="#"><?=$lang=='indonesian'?$pc->category_name:$pc->category_name_en?></a></li>
                            <?php endforeach ?>
                        </ul>

                        <div class="tab-container">

                            <div class="tab-content clearfix">
                                <div class="row">

                                    <div class="col-lg-3 col-md-6 col-sm-12 small-only">
                                        <div class="form-group">
                                            <label class="fastcon-label cl-grey-900">KATEGORI</label>
                                            <select class="form-control selectpicker">
                                                <option>Semua Produk</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="fastcon-label cl-grey-900">URUTKAN BERDASARKAN</label>
                                            <select class="form-control selectpicker">
                                                <option>Terbaru</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="fastcon-label cl-grey-900">LIHAT</label>
                                            <select class="form-control selectpicker">
                                                <option>12 per halaman</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
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
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>