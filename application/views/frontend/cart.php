<section id="content">
    <div class="content-wrap">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="fastcon-h2 text-uppercase"><?=lang('shopping_cart')?></h2>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="cart-card-wrap">

                        <?php foreach ($cart as $c): ?>
                            <div class="cart-card-item">
                                <div class="card-img">
                                    <img src="<?=site_url('uploads/fastcon_product/'.explode(',', $c->product_images)[0] )?>" alt="">
                                </div>
                                
                                <div class="card-desc">
                                    <a href="<?=site_url('products/details/'.$c->product_id.'/'.$c->product_slug)?>"><h4 class="fastcon-h4"><?=$c->product_name?></h4></a>
                                    <?php if ($c->discount>0): ?>
                                        <del class="normal-price">Rp<?=number_format($c->price)?></del>
                                    <?php endif ?>
                                    <h4 class="fastcon-h4 main-price <?=$c->discount>0?'cl-error':''?>">Rp<?=number_format($c->price - $c->discount)?></h4>
                                    <p class="card-desc-details"><span class="desc-title"><?=$lang=='indonesian'?$c->product_option1_name:$c->product_option1_name_en?>: </span><?=$c->option_value1?></p>

                                    <?php if ($c->product_option2_name!=null): ?>
                                        <p class="card-desc-details"><span class="desc-title"><?=$lang=='indonesian'?$c->product_option2_name:$c->product_option2_name_en?>: </span><?=$c->option_value2?></p>
                                    <?php endif ?>
                                </div>
                                
                                <div class="card-qty">
                                    <div class="quantity clearfix">
                                        <input type="button" value="-" class="minus cart_minus" data-variant="<?=$this->session->userdata('member')!=null?$c->variant_id:$c->rowid?>">
                                        <input type="number" step="1" min="1" name="quantity" value="<?=$this->session->userdata('member')!=null ? $c->quantity:$c->qty?>" title="Qty" class="qty cart_qty customjs" id="<?=$this->session->userdata('member')!=null?$c->variant_id:$c->rowid?>" />
                                        <input type="button" value="+" class="plus cart_plus" data-variant="<?=$this->session->userdata('member')!=null?$c->variant_id:$c->rowid?>">
                                    </div>
                                </div>
        
                                <div class="delete-link">
                                    <a href="javascript:void(0)" class="delete-cart" data-product="<?=$c->product_name?>" data-image="<?=site_url('uploads/fastcon_product/'.explode(',', $c->product_images)[0] )?>" data-variant="<?=$c->variant_id?>" <?=isset($c->rowid)?'data-rowid="'.$c->rowid.'"':''?>>
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g opacity="0.5">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M23 1H1V23H23V1ZM0 0V24H24V0H0Z" fill="#D3302F"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.11116 17.8889L17.6465 7.35359L16.9393 6.64648L6.40405 17.1818L7.11116 17.8889Z" fill="#D3302F"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M16.9394 17.8889L6.40408 7.35359L7.11119 6.64648L17.6465 17.1818L16.9394 17.8889Z" fill="#D3302F"/>
                                            </g>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach ?>
                        <a href="<?=site_url('products/update_cart')?>" class="fastcon-btn primary-btn toast hide" id="update_cart">Update Cart</a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card-summary">
                        <h4 class="fastcon-h4 cl-primary-900 text-center text-uppercase"><?=lang('price_estimation')?></h4>

                        <?php $total=0; foreach ($cart as $c): ?>

                            <?php
                                $qty = $c->quantity;

                                if (!$this->session->userdata('member')) {
                                    $qty = $c->qty;
                                }

                                $total = $total + ($qty * ($c->price-$c->discount));
                            ?>
                            
                            <div class="card-summary-product-item">
                                <div class="product">
                                    <p class="fastcon-description"><?=$c->product_name?></p>
                                    <p class="fastcon-description"><?=$c->product_option1_name?>: <?=$c->option_value1?></p>

                                    <?php if ($c->product_option2_name!=null): ?>
                                        <p class="fastcon-description"><?=$c->product_option2_name?>: <?=$c->option_value2?></p>
                                    <?php endif ?>
                                    <p class="fastcon-description"><b>x<?=$this->session->userdata('member')!=null ? $c->quantity:$c->qty?></b></p>
                                </div>
                                <div class="price">
                                    <p>RP<?=number_format($qty * ($c->price-$c->discount))?></p>
                                </div>
                            </div>

                        <?php endforeach ?>


                        <div class="line"></div>

                        <div class="card-summary-product-item mb-0">
                            <div class="product">
                                <p class="fastcon-description">Subtotal</p>
                            </div>
                            <div class="price">
                                <p>Rp<?=number_format($total)?></p>
                            </div>
                        </div>

                        <div class="card-summary-product-item mb-0">
                            <div class="product">
                                <p class="fastcon-description"><?=lang('tax')?> (10%)</p>
                            </div>
                            <div class="price">
                                <p>Rp<?=number_format(0.1*$total)?></p>
                            </div>
                        </div>

                        <div class="line"></div>

                        <div class="card-summary-product-item">
                            <div class="product">
                                <p class="fastcon-description"><b>Total</b></p>
                            </div>
                            <div class="price">
                                <p><b>Rp<?=number_format($total + (0.1*$total))?></b></p>
                            </div>
                        </div>

                        <div class="card-summary-product-item">
                            <div class="product">
                                <p class="fastcon-description"><b><?=lang('notes')?>:</b></p>
                                <p class="fastcon-description"><?=lang('notes_body')?></p>
                            </div>
                        </div>

                        <div class="card-summary-btn-wrap">
                            <a href="<?=site_url('checkout')?>" class="fastcon-btn primary-btn w-100"><?=lang('continue')?></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<div class="modal bs-example-modal-lg delete-cart-modal" id="delete_cart_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-animate="slideInUp">
    <div class="modal-dialog modal-lg">
        <div class="modal-body">
            <div class="modal-content">
                <div class="modal-body">
                    <h2 class="fastcon-h2 cl-grey-900 text-center">HAPUS DARI TROLI</h2>

                    <p class="fastcon-body-large">Apakah Anda yakin ingin menghapus barang ini dari troli belanja?</p>

                    <img alt="">

                    <h4 class="fastcon-h4 cl-grey-900"></h4>

                    <div class="btn-wrap">
                        <a href="javascript:void(0)" class="fastcon-btn primary-btn" data-dismiss="modal" aria-hidden="true">KEMBALI</a>
                        <a href="javascript:void(0)" class="fastcon-btn secondary-error-btn delete_action">HAPUS PRODUK</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>