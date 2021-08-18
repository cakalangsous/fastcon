<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends Front {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Model_web');
		$this->load->library('cart');
		$this->data['active'] = 'product';
	}

	public function index($offset=false)
	{
		$limit = 12;
		if ($this->input->get('l')) {
			$limit = $this->input->get('l');
		}
		$this->data['title'] = 'Products';
		$this->data['products'] = db_get_all_data('fastcon_product', false, $limit, $offset, false, 'product_id desc');
		$this->render('products', $this->data);
	}

	public function details($id=false, $slug=false)
	{
		if (!$id) {
			$this->not_found();
			return;
		}

		if (!$product = db_get_row_data('view_product_with_option', ['product_id' => $id])) {
			$this->not_found();
			return;
		}

		$variants = db_get_all_data('fastcon_product_variant', ['product_id' => $id], false, false, false, 'price');

		$cheap = reset($variants);
		$expensive = '';
		if (count($variants) > 0) {
			$expensive = end($variants)->price;
		}

		$this->data['cheap'] = $cheap->price;
		$this->data['expensive'] = $expensive;

		$this->data['title'] = $product->product_name;
		$this->data['product'] = $product;
		
		$this->render('product-details', $this->data);
	}

	
	public function get_option2()
	{
		if (!$this->input->is_ajax_request()) {
			$this->not_found();
			return;
		}

		$arr = $this->input->post();

		$option2 = db_get_all_data('view_product_variant', ['product_id' => $arr['product'], 'option_value1_id' => $arr['option1']]);

		$status = 200;
		if ($option2[0]->product_option2==NULL) {
			$status = 404;
		}
		echo json_encode(['status' => $status, 'message' => 'Success', 'data' => db_get_all_data('view_product_variant', ['product_id' => $arr['product'], 'option_value1_id' => $arr['option1']]) ]);
		return;
	}

	public function get_variant()
	{
		if (!$this->input->is_ajax_request()) {
			$this->not_found();
			return;
		}

		$arr = $this->input->post();

		$variant = db_get_row_data('view_product_variant', ['product_id' => $arr['product'], 'option_value1_id' => $arr['option1'], 'option_value2_id' => $arr['option2']]);

		echo json_encode(['status' => true, 'message' => 'Success', 'data' => $variant]);
		return;
	}

	public function add_to_cart()
	{
		if (!$this->input->is_ajax_request()) {
			$this->not_found();
			return;
		}

		$arr = $this->input->post();
		if (!$arr['option']['option1']) {
			echo json_encode(['status' => false, 'option' => 'option1', 'message' => 'Variant not found!']);
			return;
		}

		$product_variant = db_get_row_data('view_product_option_variant', ['product_id' => $arr['product'], 'product_option_value1' => $arr['option']['option1']]);


		if (isset($arr['option']['option2'])) {
			if (!$arr['option']['option2']) {
				echo json_encode(['status' => false, 'option' => 'option2', 'message' => 'Variant not found!']);
				return;
			}
			$product_variant = db_get_row_data('view_product_option_variant', ['product_id' => $arr['product'], 'product_option_value1' => $arr['option']['option1'], 'product_option_value2' => $arr['option']['option2']]);
		}

		$cart_data = [
			'product_id' => $product_variant->product_id,
			'variant_id' => $product_variant->variant_id,
			'quantity' => $arr['quantity'],
			'product_images' => $product_variant->product_images
		];

		if (!$this->session->userdata('member')) {
			$cart_data['id'] = $product_variant->variant_id;
			$cart_data['price'] = $product_variant->price;
			$cart_data['qty'] = $arr['quantity'];
			$cart_data['name'] = $product_variant->product_id;
			$cart_data['discount'] = $product_variant->discount;

			$insert = $this->cart->insert($cart_data);
		}else{
			$cart_data['member_id'] = $this->session->userdata('member')['member_id'];

			$cart = db_get_row_data('fastcon_product_cart', ['member_id' => $this->session->userdata('member')['member_id'], 'variant_id' => $product_variant->variant_id]);
			if (!$cart) {
				insert_this_data('fastcon_product_cart', $cart_data);
			}else{
				update_this_data('fastcon_product_cart', ['member_id' => $this->session->userdata('member')['member_id'], 'variant_id' => $product_variant->variant_id], ['quantity' => $cart->quantity + $arr['quantity']]);
			}
		}

		echo json_encode(['status' => true, 'message' => 'Added to cart!']);
		return;
	}

	public function cart()
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
		}else {
			$cart = $this->Model_web->get_cart();
		}

		$this->data['title'] = 'Cart';
		if (empty($cart)) {
			$this->data['cart']['title'] = lang('cart_empty_title');
			$this->data['cart']['content'] = lang('cart_empty_content');
			$this->render('thankyou', $this->data);
			return;
		}

		$this->data['active'] = 'cart';
		$this->data['cart'] = $cart;
		$this->render('cart', $this->data);
	}

	public function delete_cart_item()
	{
		if (!$this->input->is_ajax_request()) {
			$this->not_found();
			return;
		}

		$arr = $this->input->post();

		if (!$this->session->userdata('member')) {
			$data['rowid'] = $arr['variant'];
			$data['qty'] = 0;

			$update = $this->cart->update($data);

			echo json_encode(['status' => true, 'message' => 'Cart updated']);
			return;
		}

		$cart = db_get_row_data('fastcon_product_cart', ['member_id' => $this->session->userdata('member')['member_id'], 'variant_id' => $arr['variant']]);
		if (!$cart) {
			echo json_encode(['status' => false, 'message' => 'Cart not found']);
			return;
		}

		delete_this_data('fastcon_product_cart', ['member_id' => $this->session->userdata('member')['member_id'], 'variant_id' => $arr['variant']]);
		echo json_encode(['status' => true, 'message' => 'Cart updated']);
		return;
	}

	// public function update_cart()
	// {
	// 	if (!$this->session->userdata('member')) {

	// 	}
	// }
}

/* End of file Products.php */
/* Location: ./application/controllers/Products.php */