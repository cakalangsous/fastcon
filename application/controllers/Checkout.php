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
		if ($this->session->userdata('member') OR $this->session->userdata('guest')) {
			redirect(site_url('checkout/summary'),'refresh');
		}

		$this->data['title'] = 'Guest';
		$this->render('guest', $this->data);
	}

	public function save_guest_address()
	{
		
	}

	public function summary()
	{
		$cart = [];

		if (!$this->session->userdata('member')) {

			foreach ($this->cart->contents() as $c) {
				$product = db_get_row_data('view_product_option_variant', ['variant_id' => $c['id']]);
				if ($product AND $product->variant_id == $c['id']) {
					$product->id = $c['id'];
					$product->rowid = $c['rowid'];
					$product->qty = $c['qty'];
					$product->quantity = $c['quantity'];

				}
				array_push($cart, $product);
			}

			$this->data['address'] = [];
			$this->data['member_address'] = [];
			$this->data['ongkir'] = 0;
		}else {
			$this->data['address'] = db_get_row_data('fastcon_member_address', ['member_id' => $this->session->userdata('member')['member_id'], 'active' => 1]);
			$this->data['member_address'] = db_get_all_data('fastcon_member_address', ['member_id' => $this->session->userdata('member')['member_id']], false, false, false, 'active desc');

			$ongkir = db_get_row_data('fastcon_coverage_province', ['province_id' => $this->data['address']->province_id]);
			$this->data['ongkir'] = 0;
			if ($ongkir) {
				$this->data['ongkir'] = $ongkir->shipping_price;
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
			$this->not_found();
			return;
		}

		if (!$voucher->active) {
			$this->not_found();
			return;
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
		if (!$this->session->userdata('member')) {
			
		} else {
			/* member order */

			// get active address
			$active_address = db_get_row_data('fastcon_member_address', ['member_id' => $this->session->userdata('member')['member_id'], 'active' => 1]);
			if (!$active_address) {
				$this->session->set_flashdata('error', 'Please select delivery address');
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
		} // end member area (else)

		$this->session->set_flashdata('response', ['title' => lang('order_title'), 'content' => lang('order_body')]);
		redirect(site_url('thankyou'));
	}
	
}

/* End of file Checkout.php */
/* Location: ./application/controllers/Checkout.php */