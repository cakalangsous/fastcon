<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8"> <!-- utf-8 works for most cases -->
    <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
    <meta name="x-apple-disable-message-reformatting">  <!-- Disable auto-scale in iOS 10 Mail entirely -->
    <title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->

    <link href="https://fonts.googleapis.com/css2?family=Jura:wght@300;400;500;600;700&family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">

    <!-- CSS Reset : BEGIN -->
    <style>

        /* What it does: Remove spaces around the email design added by some email clients. */
        /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
        html,
body {
    margin: 0 auto !important;
    padding: 0 !important;
    height: 100% !important;
    width: 100% !important;
    background: #f1f1f1;
    font-family: "Open Sans" !important;
}

/* What it does: Stops email clients resizing small text. */
* {
    -ms-text-size-adjust: 100%;
    -webkit-text-size-adjust: 100%;
}

/* What it does: Centers email on Android 4.4 */
div[style*="margin: 16px 0"] {
    margin: 0 !important;
}

/* What it does: Stops Outlook from adding extra spacing to tables. */
table,
td {
    mso-table-lspace: 0pt !important;
    mso-table-rspace: 0pt !important;
}

/* What it does: Fixes webkit padding issue. */
table {
    border-spacing: 0 !important;
    border-collapse: collapse !important;
    table-layout: fixed !important;
    margin: 0 auto !important;
}

/* What it does: Uses a better rendering method when resizing images in IE. */
img {
    -ms-interpolation-mode:bicubic;
}

/* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */
a {
    text-decoration: none;
}

p {
  font-size: 14px;
  line-height: 26px !important;
  font-weight: normal;
  color: #000;
}

/* What it does: A work-around for email clients meddling in triggered links. */
*[x-apple-data-detectors],  /* iOS */
.unstyle-auto-detected-links *,
.aBn {
    border-bottom: 0 !important;
    cursor: default !important;
    color: inherit !important;
    text-decoration: none !important;
    font-size: inherit !important;
    font-family: inherit !important;
    font-weight: inherit !important;
    line-height: inherit !important;
}

/* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */
.a6S {
    display: none !important;
    opacity: 0.01 !important;
}

/* What it does: Prevents Gmail from changing the text color in conversation threads. */
.im {
    color: inherit !important;
}

.mtani-sub-title {
  font-size: 28px !important;
  font-weight: 700 !important;
}

/* If the above doesn't work, add a .g-img class to any image in question. */
img.g-img + div {
    display: none !important;
}

/* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
/* Create one of these media queries for each additional viewport size you'd like to fix */

/* iPhone 4, 4S, 5, 5S, 5C, and 5SE */
@media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
    u ~ div .email-container {
        min-width: 320px !important;
    }

    .v2-sub-title {
      font-weight: 300 !important;
      font-size: 24px !important;
      line-height: 32px !important;
    }
}
/* iPhone 6, 6S, 7, 8, and X */
@media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
    u ~ div .email-container {
        min-width: 375px !important;
    }
}
/* iPhone 6+, 7+, and 8+ */
@media only screen and (min-device-width: 414px) {
    u ~ div .email-container {
        min-width: 414px !important;
    }
}

    </style>

    <!-- CSS Reset : END -->

    <!-- Progressive Enhancements : BEGIN -->
    <style>

.primary{
	background: #30e3ca;
}
.bg_black{
	background: #000000;
}
.bg_dark{
	background: rgba(0,0,0,.8);
}

/*BUTTON*/
.btn{
	padding: 10px 15px;
	display: inline-block;
}
.btn.btn-primary{
	background-color: #ED1B24;
  color: #fff;
  border-radius: 8px;
  font-size: 16px;
  line-height: 24px;
  font-weight: normal;
}
.btn.btn-white{
	border-radius: 5px;
	background: #ffffff;
	color: #000000;
}
.btn.btn-white-outline{
	border-radius: 5px;
	background: transparent;
	border: 1px solid #fff;
	color: #fff;
}
.btn.btn-black-outline{
	border-radius: 0px;
	background: transparent;
	border: 2px solid #000;
	color: #000;
	font-weight: 700;
}


/*LOGO*/

.logo h1{
	margin: 0;
}
.logo h1 a{
	color: #30e3ca;
	font-size: 24px;
	font-weight: 700;
	font-family: 'Open Sans', sans-serif !important;
}

/*HERO*/
.hero{
	position: relative;
	z-index: 0;
}

.hero .text{
	color: rgba(0,0,0,.3);
}
.hero .text h2{
	color: #000;
	font-size: 40px;
	margin-bottom: 0;
	font-weight: 400;
	line-height: 1.4;
}
.hero .text h3{
	font-size: 24px;
	font-weight: 300;
}
.hero .text h2 span{
	font-weight: 600;
	color: #30e3ca;
}


/*HEADING SECTION*/
.heading-section{
}
.heading-section h2{
	color: #000000;
	font-size: 28px;
	margin-top: 0;
	line-height: 1.4;
	font-weight: 400;
}
.heading-section .subheading{
	margin-bottom: 20px !important;
	display: inline-block;
	font-size: 13px;
	text-transform: uppercase;
	letter-spacing: 2px;
	color: rgba(0,0,0,.4);
	position: relative;
}
.heading-section .subheading::after{
	position: absolute;
	left: 0;
	right: 0;
	bottom: -10px;
	content: '';
	width: 100%;
	height: 2px;
	background: #30e3ca;
	margin: 0 auto;
}

.heading {
  /*font-family: "Jura", sans-serif; !important;*/
  font-weight: 400;
  font-size: 18px;
  line-height: 21px;
  color: #212121;
  text-transform: uppercase;
  margin-bottom: 16px;
}

.fastcon-body {
  font-family: 'Open Sans', sans-serif;
  font-weight: normal;
  font-size: 14px;
  line-height: 19px !important;
  letter-spacing: 0;
}

.heading-section-white{
	color: rgba(255,255,255,.8);
}
.heading-section-white h2{
	font-family: 
	line-height: 1;
	padding-bottom: 0;
}
.heading-section-white h2{
	color: #ffffff;
}
.heading-section-white .subheading{
	margin-bottom: 0;
	display: inline-block;
	font-size: 13px;
	text-transform: uppercase;
	letter-spacing: 2px;
	color: rgba(255,255,255,.4);
}

.fastcon-btn {
  padding: 12px;
  font-family: 'Jura', sans-serif;
  font-size: 14px;
  line-height: 16px;
  font-weight: 600;
  text-transform: uppercase;
  border-radius: 8px;
  -webkit-transition: all .2s ease-in-out;
  transition: all .2s ease-in-out;
}

.fastcon-btn:hover {
  background-color: #79D090;
  color: #fff;
  border: 1px solid #79D090;
}

.primary-btn {
  background-color: #00672B;
  border: 1px solid #00672B;
  color: #fff;
}

.contact-us * {
    color: #212121;
    font-family: 'Open Sans', sans-serif !important;
    font-size: 14px;
}

.contact-us p {
    margin: 0;
}

li.marketplace img {
    margin-right:7px;
}


ul.social{
	padding: 0;
}
ul.social li{
	display: inline-block;
	margin-right: 10px;
}

.card-summary {
  padding: 20px;
  background: #FAFAFA;
  border: 1px dashed #9E9E9E;
  -webkit-box-sizing: border-box;
          box-sizing: border-box;
  border-radius: 8px;
}

.card-summary h4 {
  margin-bottom: 22px;
}

.card-summary .line {
  margin: 20px 0;
}

.card-summary-product-item {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  margin-bottom: 20px;
}

.mb-0 {
    margin-bottom: 0 !important;
}

.card-summary-table p {
  color: #212121;
  font-family: 'Jura', sans-serif;
  font-weight: normal;
}

.card-summary-product-item .price {
  margin-left: auto;
}

p {
    margin: 0 !important;
}

    </style>
</head>

<body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #f1f1f1; font-family: 'Open Sans', sans-serif !important;">
	<center style="width: 100%; background-color: #f1f1f1;">
    <div style="display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;"><?=$caption?>
    </div>
    <div style="max-width: 600px; margin: 0 auto;" class="email-container">
    	<!-- BEGIN BODY -->
      <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
      	<tr>
          <td valign="top" style="background: #ffffff;">
          	<table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
          		<tr>
          			<td class="logo" style="text-align: center; padding-top: 30px;">
                  <a href="<?=site_url()?>"><img src="<?=BASE_ASSET?>logo/<?=get_option('site_logo')?>" width="130" alt="Fastcon"></a>
			          </td>
          		</tr>
          	</table>
          </td>
	      </tr><!-- end tr -->
				<tr>
          <td valign="middle" style="background: #fff; min-height: 40vh; height: 60vh; padding: 0 20px;">
            <table>
            	<tr>
            		<td>
            			<div class="text" style="text-align: center;">
            				<h3 class="mtani-sub-title" style="font-family: 'Jura', sans-serif; color: #000; text-transform:uppercase;"><?=$title?></h3>
            				<p class="fastcon-body"><?=$caption?></p>
            			</div>

                        <?php if (isset($link)): ?>
                            <div class="text" style="text-align: center; margin-top: 3rem;">
                                <a href="<?=$link?>" style="padding: 10px 15px; display: inline-block; background-color: #00672B; color: #fff; border-radius: 8px; font-size: 16px; line-height: 24px; font-weight: normal; font-family:'Open Sans', sans-serif !important; "><?=$link_text?></a>
                            </div>
                        <?php endif ?>
            		</td>
            	</tr>
                <?php if (isset($cart)): ?>
                    <tr>
                        <td>
                            <div class="card-summary" style="margin:40px 0; padding: 20px; background: #FAFAFA; border: 1px dashed #9E9E9E; -webkit-box-sizing: border-box; box-sizing: border-box; border-radius: 8px;">
                                <?php if ($order_details): ?>
                                    <?php
                                        $style = '';
                                        $status_text = '';
                                        switch ($order_details->order_status) {
                                            case 2:
                                                $style = 'background-color: #00672B; border: 1px solid #00672B; color: #fff;';
                                                $status_text = lang('payment_received');
                                                break;

                                            case 3:
                                                $style = 'background-color: #e0e0e0; color: #fff; border: 1px solid #e0e0e0;';
                                                $status_text = lang('sent');
                                                break;

                                            case 4:
                                                $style = 'background-color: #D3302F; color: #fff; border: 1px solid #D3302F;';
                                                $status_text = lang('cancelled');
                                                break;
                                            
                                            default:
                                                $style = 'background-color: #F8C821; color: #fff; border: 1px solid #F8C821;';
                                                $status_text = lang('new_order');
                                                break;
                                        }
                                    ?>
                                    <h4 style="font-family: 'Jura', sans-serif !important; font-size: 18px; font-weight: normal; text-transform: uppercase; color: #00672B; text-align: center;"><?=lang('order_details')?></h4>

                                    
                                    <table class="card-summary-table" style="margin-bottom: 20px !important; width: 100%;">
                                        <tbody>
                                            <tr>
                                                <td colspan="2"><p class="fastcon-description" style="font-family: 'Jura', sans-serif !important; margin: 0;"><b>Order Status</b></p></td>
                                                <td><p style="font-family: 'Jura', sans-serif !important; margin: 0;<?=$style?> text-align: center; padding: 2px 7px; border-radius: 8px; text-transform: uppercase;"><b><?=$status_text?></b></p></td>
                                                
                                            </tr>
                                            <tr>
                                                <td colspan="2"><p class="fastcon-description" style="font-family: 'Jura', sans-serif !important; margin: 0;"><b>Order Code</b></p></td>
                                                <td><p style="margin: 0;"><b><?=$order_details->order_code?></b></p></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><p class="fastcon-description" style="font-family: 'Jura', sans-serif !important; margin: 0;"><b>Order Date</b></p></td>
                                                <td><p style="margin: 0;"><b><?=date('F j, Y', strtotime($order_details->created))?></b></p></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><p class="fastcon-description" style="font-family: 'Jura', sans-serif !important; margin: 0;"><b>Kontak Kurir</b></p></td>
                                                <td><p style="margin: 0;"><b><?=$order_details->courier_name?$order_details->courier_name:'-'?></b></p></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                <?php endif ?>

                                <div style="border-bottom: dashed 1px #000;"></div>

                                <h4 style="font-family: 'Jura', sans-serif !important; font-size: 18px; font-weight: normal; text-transform: uppercase; color: #00672B; text-align: center;"><?=lang('summary')?></h4>

                                <?php $total=0; foreach ($cart as $c): ?>

                                    <?php
                                        $ongkir = '';
                                        $total = $total + ($c->qty * ($c->price-$c->discount));
                                    ?>
                                    <div class="card-summary-product-item" style="margin-bottom: 20px !important; display: flex; align-items: center;">
                                        <div class="product">
                                            <p class="fastcon-description" style="font-family: 'Jura', sans-serif !important;"><?=$c->product_name?></p>
                                            <p class="fastcon-description" style="font-size: 12px; margin: 0 !important;"><?=$lang=='indonesian'?$c->product_option1_name:$c->product_option1_name_en?>: <?=$c->product_option1_value?></p>
                                            <?php if ($c->product_option2_id): ?>
                                                <p class="fastcon-description" style="font-size: 12px; margin: 0 !important;"><?=$lang=='indonesian'?$c->product_option2_name:$c->product_option2_name_en?>: <?=$c->product_option2_value?></p>
                                            <?php endif ?>
                                            <p class="fastcon-description" style="font-size: 12px; margin: 0 !important;"><b>x<?=$c->qty?></b></p>
                                        </div>
                                        <div class="price">
                                            <p style="font-size: 12px; margin: 0;">Rp<?=number_format($c->qty * ($c->price-$c->discount))?></p>
                                        </div>
                                    </div>
                                <?php $ongkir = $c->shipping_cost; endforeach ?>

                                <div class="line"></div>

                                <div class="card-summary-product-item" style="margin-bottom: 0 !important;">
                                    <div class="product">
                                        <p class="fastcon-description" style="font-size: 12px; margin: 0 !important; font-weight: bold;">Subtotal</p>
                                    </div>
                                    <div class="price">
                                        <p style="font-size: 12px; margin: 0;">Rp<?=number_format($total)?></p>
                                    </div>
                                </div>

                                <div class="card-summary-product-item" style="margin-bottom: 0 !important;">
                                    <div class="product">
                                        <p class="fastcon-description" style="font-size: 12px; margin: 0 !important; font-weight: bold;"><?=lang('tax')?> (10%)</p>
                                    </div>
                                    <div class="price">
                                        <p style="font-size: 12px; margin: 0;">Rp<?=number_format(0.1*$total)?></p>
                                    </div>
                                </div>

                                <?php if ($ongkir): ?>
                                    <div class="card-summary-product-item" style="margin-bottom: 0 !important;">
                                        <div class="product">
                                            <p class="fastcon-description" style="font-size: 12px; margin: 0 !important; font-weight: bold;"><?=lang('delivery_cost')?></p>
                                        </div>
                                        <div class="price">
                                            <p style="font-size: 12px; margin: 0;">Rp<?=number_format($ongkir)?></p>
                                        </div>
                                    </div>
                                <?php endif ?>
                                <?php if ($voucher = $this->session->userdata('voucher')): ?>
                                    <div class="card-summary-product-item">
                                        <div class="product">
                                            <p class="fastcon-description" style="font-size: 12px; margin: 0 !important;"><?=lang('coupon_discount')?></p>
                                        </div>
                                        <div class="price">
                                            <p class="cl-error"> - Rp<?=number_format($voucher['voucher_discount'])?></p>
                                        </div>
                                    </div>
                                <?php $total = $total-$voucher['voucher_discount']; endif ?>

                                <div class="line"></div>

                                <div class="card-summary-product-item">
                                    <div class="product">
                                        <p class="fastcon-description" style="font-size: 12px; margin: 0 !important;"><b>Total</b></p>
                                    </div>
                                    <div class="price">
                                        <p><b>Rp<?=number_format($total + (0.1*$total) + $ongkir)?></b></p>
                                    </div>
                                </div>

                            </div>
                        </td>
                    </tr>
                <?php endif ?>
            </table>
          </td>
	      </tr><!-- end tr -->
      <!-- 1 Column Text + Button : END -->
      </table>
      <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto; font-family: 'Open Sans', sans-serif !important;">
      	<tr>
          <td valign="middle" style="background: #f5f5f5; padding: 1.5em 2.5em; ">
            <table>
                <tr>
                    <td align="center">
                      	<a href="<?=site_url()?>" style="text-align: center;" ><img src="<?=BASE_ASSET?>logo/<?=get_option('site_logo')?>" width="180" alt="Fastcon"></a>
                    </td>
                </tr>
            </table>
            <table>
            	<tr>
                <td valign="top" align="center" width="50%" style="padding-top: 10px;">
                  <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                      <td style="text-align: center; padding-left: 5px; padding-right: 5px; color: #212121;">
                      	<ul style="margin: 30px 0 0; padding:0;">
                            <h4 class="heading" style="font-family: 'Jura', sans-serif;"><?=lang('contact_us')?></h4>
    		                <li class="contact-us" style="list-style: none; margin-bottom: 20px; color: #212121; font-family: 'Open Sans', sans-serif !important; font-size: 14px;">
                                <?php foreach ($contact_settings as $cs): ?>
                                    <?php if ($cs->setting_item=='office'): ?>
                                        <?=$cs->setting_value?>

                                        <a href="tel:<?=$cs->phone?>" class="fastcon-body">
                                            <img src="<?=BASE_ASSET?>fastcon/img/icons/phone-call.svg" style="margin-right: 8px;" width="16" alt="phone">
                                            <?=$cs->phone?>
                                        </a>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </li>
		                </ul>

                        <ul style="margin: 30px 0 0; padding:0;">
                            <h4 class="heading" style="font-family: 'Jura', sans-serif;"><?=lang('our_factory')?></h4>
                            <li class="contact-us" style="list-style: none; margin-bottom: 20px; color: #212121; font-family: 'Open Sans', sans-serif !important; font-size: 14px;">
                                <?php foreach ($contact_settings as $cs): ?>
                                    <?php if ($cs->setting_item=='factory'): ?>
                                        <?=$cs->setting_value?>

                                        <a href="tel:<?=$cs->phone?>" class="fastcon-body">
                                            <img src="<?=BASE_ASSET?>fastcon/img/icons/phone-call.svg" style="margin-right: 8px;" width="16" alt="phone">
                                            <?=$cs->phone?>
                                        </a>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </li>
                        </ul>
                      </td>
                    </tr>
                  </table>
                </td>
                <td valign="top" width="50%" style="padding-top: 10px;">
                  <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                      <td style="text-align: center; padding-left: 10px;">

                        <ul style="margin: 0 ; padding:0;">
                            <h4 class="heading" style="font-family: 'Jura', sans-serif;"><?=lang('our_marketplace')?></h4>
                            <li class="marketplace" style="list-style: none; margin-bottom: 7px;">
                                <?php foreach ($marketplace as $mp): ?>
                                    <a href="<?=$mp->link?>" target="_blank"><img src="<?=site_url('uploads/fastcon_marketplace/'.$mp->icon)?>" alt="" width="24"></a>
                                <?php endforeach ?>
                            </li>
                        </ul>

                        <ul style="margin: 4rem 0 0 0 ; padding:0;">
                            <h4 class="heading" style="font-family: 'Jura', sans-serif;"><?=lang('our_qualification')?></h4>
                            <li style="list-style: none; margin-bottom: 7px;">
                                <img src="<?=BASE_ASSET?>fastcon/img/iso.png" alt="Fastcon ISO" style="margin-right: 0; width: 100%; max-width: 165px;">
                            </li>
                        </ul>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr><!-- end: tr -->
        <tr>
          <td style="background: #f5f5f5; text-align: center;">
          	<p style="color: #212121; font-family: 'Jura'; font-size: 14px; padding-bottom: 30px;">&copy; 2021 <a href="<?=site_url()?>" style="color: #00672B; text-decoration: underline;">Fastcon</a>. All Rights Reserved. </p>
          </td>
        </tr>
      </table>

    </div>
  </center>
</body>
</html>