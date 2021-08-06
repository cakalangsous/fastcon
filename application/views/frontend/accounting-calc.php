<section id="content">
    <div class="content-wrap">
        <div class="container">
            <h1 class="fastcon-h1 cl-grey-900 text-uppercase mb-30">Kalkulator Bata Ringan</h1>

            <div class="calc-content-wrap">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </p>
                <br>
    
                <p>
                    <b>Panduan Pengunaan Kalkulator:</b>
                    <ol>
                        <li>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium</li>
                        <li>Totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo</li>
                        <li>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt</li>
                    </ol>
                </p>
            </div>

            <div class="calc-form-wrap">
                <h3 class="fastcon-h3 cl-grey-900">KALKULATOR BATA RINGAN SEDERHANA</h3>

                <form id="calculator_form">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="panjang" class="fastcon-label cl-grey-900">PANJANG DINDING (m)*</label>
                                <input type="number" value="" onkeyup="calc()" class="form-control" id="panjang" name="panjang" placeholder="Ketik disini">
                                <small class="form-text text-muted">Isi panjang bangunan dalam satuan meter</small>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="lebar" class="fastcon-label cl-grey-900">LEBAR DINDING (m)</label>
                                <input type="number" value="" onkeyup="calc()" class="form-control" id="lebar" name="lebar" placeholder="Ketik disini">
                                <small class="form-text text-muted">Isi lebar bangunan dalam satuan meter</small>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="tinggi" class="fastcon-label cl-grey-900">TINGGI DINDING (m)</label>
                                <input type="number" value="" onkeyup="calc()" class="form-control" id="tinggi" name="tinggi" placeholder="Ketik disini">
                                <small class="form-text text-muted">Isi tinggi bangunan dalam satuan meter</small>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="name" class="fastcon-label cl-grey-900">KETEBALAN BATA ANDA</label>
                                <select onchange="calc()" class="form-control selectpicker" name="ketebalan" id="ketebalan">
                                    <?php foreach ($bricks as $b): ?>
                                        <option value="<?=$b->ketebalan?>"><?=$b->ketebalan?> mm</option>
                                    <?php endforeach ?>
                                </select>
                                <small class="form-text text-muted">Anda bisa memilih ukuran bata di atas</small>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="calc-result-wrap">
                <h3 class="fastcon-h3 cl-grey-900">BAYANGKAN ANDA MEMBANGUN DENGAN LUASAN SEPERTI DATA DI ATAS, ANDA AKAN MEMBUTUHKAN BATA RINGAN SEBAGAI BERIKUT:</h3>

                <div class="row">
                    <div class="col-md-4 col-6 mb-30">
                        <p class="fastcon-label cl-grey-900">JUMLAH BATA RINGAN YANG DIBUTUHKAN (BUAH)</p>
                        <h1 class="fastcon-calc-result cl-primary-900" id="needs">0</h1>
                    </div>

                    <div class="col-md-4 col-6 mb-30">
                        <p class="fastcon-label cl-grey-900">JUMLAH KUBIKASI YANG DIBUTUHKAN (M3)</p>
                        <h1 class="fastcon-calc-result cl-primary-900" id="kubik_needs">0</h1>
                    </div>

                    <div class="col-md-4 col-6 mb-30">
                        <p class="fastcon-label cl-grey-900">JUMLAH PEMBELIAN MINIMAL PABRIK (M3)</p>
                        <h1 class="fastcon-calc-result cl-primary-900">0</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>