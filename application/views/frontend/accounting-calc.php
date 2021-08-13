<section id="content">
    <div class="content-wrap">
        <div class="container">
            <h1 class="fastcon-h1 cl-grey-900 text-uppercase mb-30"><?=lang('aac_calc')?></h1>

            <div class="calc-content-wrap">
                <?=$lang=='indonesian'?$guide->guide:$guide->guide_en?>
            </div>

            <div class="calc-form-wrap">
                <h3 class="fastcon-h3 cl-grey-900"><?=lang('simple_aac_calc')?></h3>

                <form id="calculator_form">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="panjang" class="fastcon-label cl-grey-900 text-uppercase"><?=lang('wall_length')?> (m)*</label>
                                <input type="number" value="" onkeyup="calc()" class="form-control" id="panjang" name="panjang" placeholder="Ketik disini">
                                <small class="form-text text-muted"><?=lang('fill_length')?></small>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="lebar" class="fastcon-label cl-grey-900 text-uppercase"><?=lang('wall_width')?> (m)*</label>
                                <input type="number" value="" onkeyup="calc()" class="form-control" id="lebar" name="lebar" placeholder="Ketik disini">
                                <small class="form-text text-muted"><?=lang('fill_width')?></small>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="tinggi" class="fastcon-label cl-grey-900 text-uppercase"><?=lang('wall_height')?> (m)*</label>
                                <input type="number" value="" onkeyup="calc()" class="form-control" id="tinggi" name="tinggi" placeholder="Ketik disini">
                                <small class="form-text text-muted"><?=lang('fill_height')?></small>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="name" class="fastcon-label cl-grey-900 text-uppercase"><?=lang('your_brick_thick')?></label>
                                <select onchange="calc()" class="form-control selectpicker" name="ketebalan" id="ketebalan">
                                    <?php foreach ($bricks as $b): ?>
                                        <option value="<?=$b->ketebalan?>"><?=$b->ketebalan?> mm</option>
                                    <?php endforeach ?>
                                </select>
                                <small class="form-text text-muted"><?=lang('choose_thickness')?></small>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="calc-result-wrap">
                <h3 class="fastcon-h3 cl-grey-900 text-uppercase"><?=lang('imagine_data')?>:</h3>

                <div class="row">
                    <div class="col-md-4 col-6 mb-30">
                        <p class="fastcon-label cl-grey-900 text-uppercase"><?=lang('aac_needed')?></p>
                        <h1 class="fastcon-calc-result cl-primary-900" id="needs">0</h1>
                    </div>

                    <div class="col-md-4 col-6 mb-30">
                        <p class="fastcon-label cl-grey-900 text-uppercase"><?=lang('cubication_needed')?></p>
                        <h1 class="fastcon-calc-result cl-primary-900" id="kubik_needs">0</h1>
                    </div>

                    <div class="col-md-4 col-6 mb-30">
                        <p class="fastcon-label cl-grey-900 text-uppercase"><?=lang('factory_minimum')?></p>
                        <h1 class="fastcon-calc-result cl-primary-900">0</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>