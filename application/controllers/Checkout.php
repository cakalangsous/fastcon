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
	
}

/* End of file Checkout.php */
/* Location: ./application/controllers/Checkout.php */