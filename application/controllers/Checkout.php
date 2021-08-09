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
		}else {
			$this->data['address'] = db_get_row_data('fastcon_member_address', ['member_id' => $this->session->userdata('member')['member_id'], 'active' => 1]);
			$this->data['member_address'] = db_get_all_data('fastcon_member_address', ['member_id' => $this->session->userdata('member')['member_id']]);
			$cart = $this->Model_web->get_cart();
		}

		if (!$cart) {
			//redirect to empty cart
		}


		$this->data['cart'] = $cart;

		$this->data['title'] = 'Checkout';
		$this->data['checkout'] = true;
		$this->render('checkout', $this->data);
	}
	
}

/* End of file Checkout.php */
/* Location: ./application/controllers/Checkout.php */