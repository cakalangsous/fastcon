<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends Front {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Model_web');
		$this->load->library('cart');

		$cart = [];
		if (!$this->session->userdata('member')) {
			$cart = $this->cart->contents();
		}else{
			$cart = $this->Model_web->get_cart();
		}

		if (empty($cart)) {
			redirect(site_url('products/cart'));
		}
	}

	public function index()
	{
		if ($this->session->userdata('member') OR $this->session->userdata('guest')) {
			redirect(site_url('checkout/summary'),'refresh');
		}

		$this->data['title'] = 'Cart Options';
		$this->render('member-guest', $this->data);
	}

	public function guest()
	{

		if ($this->session->userdata('member') OR ($this->session->userdata('guest'))) {
			redirect(site_url('checkout/summary'),'refresh');
		}


		$this->data['title'] = 'Guest';
		$this->render('guest', $this->data);
	}

	public function save_guest_address()
	{

		$this->form_validation->set_rules('email', lang('email'), 'trim|required|valid_email');
		$this->form_validation->set_rules('fullname', lang('fullname'), 'trim|required');
		$this->form_validation->set_rules('phone', lang('phone'), 'trim|required');
		$this->form_validation->set_rules('province_id', lang('province'), 'trim|required');
		$this->form_validation->set_rules('kota_kecamatan', lang('city_province'), 'trim|required');
		$this->form_validation->set_rules('address', lang('address'), 'trim|required');
		$this->form_validation->set_rules('additional_info', lang('additional_info'), 'trim|required');
		$this->form_validation->set_rules('receiver_name', lang('fullname'), 'trim|required');
		$this->form_validation->set_rules('receiver_phone', lang('phone'), 'trim|required');

		if ($this->form_validation->run() == false) {
			$this->session->set_flashdata('error', validation_errors());
			redirect_back();
		}

		$arr = $this->input->post();

		if ($this->session->userdata('guest')) {
			$this->session->unset_userdata('guest');
		}

		$guest_data = [
			'fullname' => $arr['fullname'],
			'email' => $arr['email'],
			'phone' => $arr['phone'],
		];
		
		$guest = insert_this_data_last_id('fastcon_guest', $guest_data);

		$guest_data['id'] = md5(uniqid(rand(), true));
		$guest_data['guest_id'] = $guest;
		$this->session->set_userdata( ['guest' => $guest_data] );

		$destination = explode(',', $arr['kota_kecamatan']);
		$destination_code = db_get_row_data('fastcon_address_master',[
			'provinsi' => isset($destination[0])?$destination[0]:'',
			'kabupaten' => isset($destination[1])?substr($destination[1], 1):'',
			'kecamatan' => isset($destination[2])?substr($destination[2], 1):'',
			'kelurahan' => isset($destination[3])?substr($destination[3], 1):'',
			'kode_pos' => isset($destination[4])?substr($destination[4], 1):'',
		]);
		
		$guest_address = [
			'name'		=> $arr['receiver_name'],
			'email'		=> $arr['email'],
			'phone'		=> $arr['receiver_phone'],
			'province_id'=> $arr['province_id'],
			'provinsi' 	=> $destination_code->provinsi,
			'kabupaten' => $destination_code->kabupaten,
			'kecamatan' => $destination_code->kecamatan,
			'kelurahan' => $destination_code->kelurahan,
			'kode_pos' 	=> $destination_code->kode_pos,
			'address'	=> $arr['address'],
			'member_id' => 0,
			'guest_id' 	=> $guest_data['guest_id'],
			'active'  	=> 1
		];

		insert_this_data('fastcon_member_address', $guest_address);
		
		// $this->session->set_userdata( ['guest_address' => $guest_address] );

		redirect(site_url('checkout'));
	}

	public function change_guest_address($address_id=false)
	{
		if (!$address_id) {
			$this->not_found();
			return;
		}

		if (!$selected_address = db_get_row_data('fastcon_member_address', ['guest_id' => $this->session->userdata('guest')['guest_id'], 'id' => $address_id] )) {
			$this->not_found();
			return;
		}

		$this->form_validation->set_rules('fullname', 'Fullname', 'trim|required');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
		$this->form_validation->set_rules('email', 'E-mail', 'trim|required');
		$this->form_validation->set_rules('province_id', 'Province', 'trim|required');
		$this->form_validation->set_rules('kota_kecamatan', 'City or District', 'trim|required');
		$this->form_validation->set_rules('address', 'Address', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect_back();
		}

		$arr = $this->input->post();

		$destination = explode(',', $arr['kota_kecamatan']);
		$destination_code = db_get_row_data('fastcon_address_master',[
			'provinsi' => isset($destination[0])?$destination[0]:'',
			'kabupaten' => isset($destination[1])?substr($destination[1], 1):'',
			'kecamatan' => isset($destination[2])?substr($destination[2], 1):'',
			'kelurahan' => isset($destination[3])?substr($destination[3], 1):'',
			'kode_pos' => isset($destination[4])?substr($destination[4], 1):'',
		]);

		$address = [
			'name'			=> $arr['fullname'],
			'email'			=> $arr['email'],
			'phone'			=> $arr['phone'],
			'province_id'	=> (int) $arr['province_id'],
			'provinsi' 		=> $destination_code->provinsi,
			'kabupaten' 	=> $destination_code->kabupaten,
			'kecamatan' 	=> $destination_code->kecamatan,
			'kelurahan' 	=> $destination_code->kelurahan,
			'kode_pos' 		=> $destination_code->kode_pos,
			'address'		=> $arr['address'],
			'member_id' 	=> $this->session->userdata('guest')['id'],
			'active'  		=> $selected_address->active
		];

		update_this_data('fastcon_member_address', ['id' => $address_id], $address);
		$this->session->set_flashdata('welcome', 'Address successfully updated.');
		redirect_back();
	}

	public function summary()
	{
		$cart = [];

		if (!$this->session->userdata('member')) {
			if (!$this->session->userdata('guest')) {
				redirect(site_url('products/cart'));
			}
			foreach ($this->cart->contents() as $c) {
				$product = db_get_row_data('view_product_option_variant', ['variant_id' => $c['id']]);
				if ($product AND $product->variant_id == $c['id']) {
					$product->id = $c['id'];
					$product->rowid = $c['rowid'];
					$product->qty = $c['qty'];
					$product->quantity = $c['quantity'];
					$product->discount = $c['discount'];

				}
				array_push($cart, $product);
			}

			// $this->data['address'] = (Object) $this->session->userdata('guest_address');
			$this->data['address'] = db_get_row_data('fastcon_member_address', ['guest_id' => $this->session->userdata('guest')['guest_id'], 'active' => 1]);
			$this->data['member_address'] = [];
			$this->data['ongkir'] = 0;

			if ($this->data['address']) {
				$ongkir = db_get_row_data('fastcon_coverage_province', ['province_id' => $this->data['address']->province_id]);

				if ($ongkir) {
					$this->data['ongkir'] = $ongkir->shipping_price;
				}
			}

		}else {
			$this->data['address'] = db_get_row_data('fastcon_member_address', ['member_id' => $this->session->userdata('member')['member_id'], 'active' => 1]);
			$this->data['member_address'] = db_get_all_data('fastcon_member_address', ['member_id' => $this->session->userdata('member')['member_id']], false, false, false, 'active desc');

			$this->data['ongkir'] = 0;
			if ($this->data['address']) {
				$ongkir = db_get_row_data('fastcon_coverage_province', ['province_id' => $this->data['address']->province_id]);
				if ($ongkir) {
					$this->data['ongkir'] = $ongkir->shipping_price;
				}
			}
			$cart = $this->Model_web->get_cart();
		}

		$this->data['cart'] = $cart;

		$this->data['title'] = 'Checkout';
		$this->data['checkout'] = true;
		$this->render('checkout', $this->data);
	}

	public function voucher()
	{
		if (!$arr = $this->input->post()) {
			$this->not_found();
			return;
		}


		$voucher = db_get_row_data('fastcon_voucher', ['voucher_code' => strtoupper($arr['voucher'])]);
		if (!$voucher) {
			$this->session->set_flashdata('voucher_error', 'Voucher tidak ditemukan');
			redirect_back();
		}

		// if (!$this->Model_web->get_useable_voucher()) {
		if (!db_get_row_data('view_usable_voucher', ['voucher_id' => $voucher->voucher_id])) {
			$this->session->set_flashdata('voucher_error', 'Voucher telah digunakan');
			redirect_back();
		}

		if (!$voucher->active) {
			$this->session->set_flashdata('voucher_error', 'Voucher tidak berlaku');
			redirect_back();
		}

		if (date('Y-m-d', strtotime('now')) < $voucher->start_date OR date('Y-m-d', strtotime('now')) > $voucher->end_date) {
			$this->session->set_flashdata('voucher_error', 'Periode kupon telah berakhir');
			redirect_back();
		}

		if (get_cart_total() < $voucher->min_purchase) {
			$this->session->set_flashdata('voucher_error', 'Pembelian minimum untuk menggunakan kupon ini adalah Rp'.number_format($voucher->min_purchase));
			redirect_back();
		}

		$array = [
			'voucher_id' => $voucher->voucher_id,
			'voucher_code' => $voucher->voucher_code,
			'voucher_discount' => $voucher->voucher_discount,
			'min_purchase' => $voucher->min_purchase,
			'start_date' => $voucher->start_date,
			'end_date' => $voucher->end_date,
		];
		
		$this->session->set_userdata(['voucher' => $array]);
		redirect_back();
	}

	public function voucher_delete()
	{
		if ($this->session->userdata('voucher')) {
			$this->session->unset_userdata('voucher');
		}

		redirect_back();
	}

	public function submit_order()
	{

		// guest order
		$account_email = '';
		if (!$this->session->userdata('member')) {

			// get active address
			$active_address = db_get_row_data('fastcon_member_address', ['guest_id' => $this->session->userdata('guest')['guest_id'], 'active' => 1]);
			if (!$active_address) {
				$this->session->set_flashdata('error', 'Please select delivery address');
				redirect_back();
			}

			// check active address to get ongkir
			if ($active_address->province_id==0) {
				$this->session->set_flashdata('error', 'Delivery Price not available');
				redirect_back();
			}

			// get cart
			if (!$cart = $this->cart->contents()) {
				redirect(site_url('products/cart'));
			}

			// get subtotal
			$subtotal = 0;
			foreach ($cart as $c) {
				$subtotal = $subtotal + (($c['price'] - $c['discount']) * $c['quantity']);
			}

			// get ppn 
			$ppn = 0.1 * $subtotal;

			// get ongkir
			$ongkir = db_get_row_data('fastcon_coverage_province', ['province_id' => $active_address->province_id]);
			if (!$ongkir) {
				$this->session->set_flashdata('error', 'Ongkir not found');
				redirect_back();
			}
			$ongkir = $ongkir->shipping_price;

			$grand_total = $subtotal + $ppn + $ongkir;

			$order_code = 'FAST'.date('Ymd').rand(100,999);

			foreach ($cart as $c) {
				$variant = db_get_row_data('view_product_option_variant', ['variant_id' => $c['variant_id']]);

				$order_data = [
					'order_code' => $order_code,
					'guest_id' => $this->session->userdata('guest')['guest_id'],
					'product_category_id' => $variant->product_category,
					'product_category_name' => $variant->category_name,
					'product_category_name_en' => $variant->category_name_en,
					'product_id' => $variant->product_id,
					'product_name' => $variant->product_name,
					'product_images' => $variant->product_images,
					'variant_id' => $variant->variant_id,
					'sku' => $variant->sku,
					'product_option1_id' => $variant->product_option1,
					'product_option1_name' => $variant->product_option1_name,
					'product_option1_name_en' => $variant->product_option1_name_en,
					'product_option1_value_id' => $variant->product_option_value1,
					'product_option1_value' => $variant->option_value1,
					'product_option2_id' => $variant->product_option2,
					'product_option2_name' => $variant->product_option2_name,
					'product_option2_name_en' => $variant->product_option2_name_en,
					'product_option2_value_id' => $variant->product_option_value2,
					'product_option2_value' => $variant->option_value2,
					'price' => $c['price'],
					'discount' => $c['discount'],
					'qty' => $c['quantity'],
					'subtotal' => $subtotal,
					'shipping_cost' => $ongkir,
					'total' => $grand_total,
					'voucher_id' => null,
					'voucher_code' => null,
					'voucher_discount' => null,
					'voucher_start_date' => null,
					'voucher_end_date' => null,
					'member_address_id' => $active_address->id,
					'nama_penerima' => $active_address->name,
					'email' => $active_address->email,
					'no_telp' => $active_address->phone,
					'province_id' => $active_address->province_id,
					'province_name' => $active_address->provinsi, // ganti dengan data dari coverage province
					'provinsi' => $active_address->provinsi,
					'kabupaten' => $active_address->kabupaten,
					'kecamatan' => $active_address->kecamatan,
					'kelurahan' => $active_address->kelurahan,
					'kode_pos' => $active_address->kode_pos,
					'alamat_lengkap' => $active_address->address
					// payment_type
					// fraud_status
					// status_message
					// transaction_id
					// transaction_time
					// va_numbers
					// midtrans_bill_code
					// midtrans_bill_key
					// transaction_status
					// pdf_url
					// status_pembelian
					// midtrans_response
				];

				insert_this_data('fastcon_product_orders', $order_data);
			}

			$account_email = $this->session->userdata('guest')['email'];

			$this->session->unset_userdata('cart_contents');

		} else {
			/* member order */

			// get active address
			$active_address = db_get_row_data('fastcon_member_address', ['member_id' => $this->session->userdata('member')['member_id'], 'active' => 1]);
			if (!$active_address) {
				$this->session->set_flashdata('error', 'Please select delivery address');
				redirect_back();
			}

			// check active address to get ongkir
			if ($active_address->province_id==0) {
				$this->session->set_flashdata('error', 'Delivery Price not available');
				redirect_back();
			}

			// get cart
			$cart = $this->Model_web->get_cart();
			if (empty($cart)) {
				redirect(site_url('products/cart'));
			}

			// get subtotal
			$subtotal = 0;
			foreach ($cart as $c) {
				$subtotal = $subtotal + (($c->price - $c->discount) * $c->quantity);
			}

			// get ppn 
			$ppn = 0.1 * $subtotal;

			// get ongkir
			$ongkir = db_get_row_data('fastcon_coverage_province', ['province_id' => $active_address->province_id]);
			if (!$ongkir) {
				$this->session->set_flashdata('error', 'Ongkir not found');
				redirect_back();
			}

			$ongkir = $ongkir->shipping_price;

			$voucher_discount = 0;
			$voucher_data = null;
			// check if any voucher used
			if ($this->session->userdata('voucher')) {
				$voucher = $this->session->userdata('voucher');
				$voucher_data = [
					'voucher_id' => $voucher['voucher_id'],
					'voucher_code' => $voucher['voucher_code'],
					'voucher_discount' => $voucher['voucher_discount'],
					'min_purchase' => $voucher['min_purchase'],
					'start_date' => $voucher['start_date'],
					'end_date' => $voucher['end_date'],
				];

				$voucher_discount = $voucher['voucher_discount'];
			}

			// count grand total
			$grand_total = $subtotal + $ppn + $ongkir - $voucher_discount;

			$order_code = 'FAST'.date('Ymd').rand(100,999);

			foreach ($cart as $c) {
				$order_data = [
					'order_code' => $order_code,
					'member_id' => $this->session->userdata('member')['member_id'],
					'product_category_id' => $c->product_category,
					'product_category_name' => $c->category_name,
					'product_category_name_en' => $c->category_name_en,
					'product_id' => $c->product_id,
					'product_name' => $c->product_name,
					'product_images' => $c->product_images,
					'variant_id' => $c->variant_id,
					'sku' => $c->sku,
					'product_option1_id' => $c->product_option1,
					'product_option1_name' => $c->product_option1_name,
					'product_option1_name_en' => $c->product_option1_name_en,
					'product_option1_value_id' => $c->product_option_value1,
					'product_option1_value' => $c->option_value1,
					'product_option2_id' => $c->product_option2,
					'product_option2_name' => $c->product_option2_name,
					'product_option2_name_en' => $c->product_option2_name_en,
					'product_option2_value_id' => $c->product_option_value2,
					'product_option2_value' => $c->option_value2,
					'price' => $c->price,
					'discount' => $c->discount,
					'qty' => $c->quantity,
					'subtotal' => $subtotal,
					'shipping_cost' => $ongkir,
					'total' => $grand_total,
					'voucher_id' => $voucher_data!=null?$voucher_data['voucher_id']:null,
					'voucher_code' => $voucher_data!=null?$voucher_data['voucher_code']:null,
					'voucher_discount' => $voucher_data!=null?$voucher_data['voucher_discount']:null,
					'voucher_start_date' => $voucher_data!=null?$voucher_data['start_date']:null,
					'voucher_end_date' => $voucher_data!=null?$voucher_data['end_date']:null,
					'member_address_id' => $active_address->id,
					'nama_penerima' => $active_address->name,
					'email' => $active_address->email,
					'no_telp' => $active_address->phone,
					'province_id' => $active_address->province_id,
					'province_name' => $active_address->provinsi, // ganti dengan data dari coverage province
					'provinsi' => $active_address->provinsi,
					'kabupaten' => $active_address->kabupaten,
					'kecamatan' => $active_address->kecamatan,
					'kelurahan' => $active_address->kelurahan,
					'kode_pos' => $active_address->kode_pos,
					'alamat_lengkap' => $active_address->address
					// payment_type
					// fraud_status
					// status_message
					// transaction_id
					// transaction_time
					// va_numbers
					// midtrans_bill_code
					// midtrans_bill_key
					// transaction_status
					// pdf_url
					// status_pembelian
					// midtrans_response
				];

				insert_this_data('fastcon_product_orders', $order_data);
			}

			$account_email = $this->session->userdata('member')['email'];

			// delete cart for this member
			delete_this_data('fastcon_product_cart', ['member_id' => $this->session->userdata('member')['member_id']]);

			// delete voucher if any
			if ($this->session->userdata('voucher')) {
				$this->session->unset_userdata('voucher');
			}

		} // end member area (else)

		$info['title']		= lang('order_title');
		$info['caption']	= lang('order_body');
		$info['marketplace']= $this->data['marketplace'];
		$info['contact_settings']	= $this->data['contact_settings'];
		$info['lang'] = $this->data['lang'];
		$info['cart'] = db_get_all_data('fastcon_product_orders', ['order_code' => $order_code]);
		$info['order_details'] = db_get_row_data('fastcon_product_orders', ['order_code' => $order_code]);

		$html = $this->load->view('email/index', $info, true);

		$this->load->library('email');

		$this->email->initialize($this->mail_config());
		$this->email->set_newline("\r\n");
		$this->email->from(getenv('EMAIL_SENDER'), getenv('SENDER_NAME'));
		$this->email->to($account_email);
		$this->email->subject('Fastcon - Thank you for purchase');
		$this->email->message($html);
		
		$this->email->send();

		$this->session->set_flashdata('response', ['title' => lang('order_title'), 'content' => lang('order_body')]);
		redirect(site_url('thankyou'));
	}
	
}

/* End of file Checkout.php */
/* Location: ./application/controllers/Checkout.php */