<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends Front {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Model_web');

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

		if (!$product = db_get_row_data('fastcon_product', ['product_id' => $id])) {
			$this->not_found();
			return;
		}

		$this->data['title'] = $product->product_name;
		$this->data['product'] = $product;

		$this->data['product_option'] = $this->Model_web->get_product_option($id);
		// echo '<pre>';
		// print_r($this->db->last_query());
		// echo '<br>';
		// print_r($this->data['product_option']);
		// exit;
		
		$this->render('product-details', $this->data);
	}

	public function get_related_variants()
	{
		if (!$this->input->is_ajax_request()) {
			$this->not_found();
			return;
		}

		$arr = $this->input->post();
		
		if (!is_array($arr['result'])) {
			echo json_encode("Unknown Request!");
			return;
		}

		$options = [];
		foreach ($arr['result'] as $a) {
			$sku = db_get_row_data('view_product_variants', ['product_id' => $a['product'], 'product_option_id' => $a['option'], 'product_option_value_id' => $a['value']], false, false, 'sku_id');

			$next = db_get_all_data('view_product_variants', ['sku_id' => $sku->sku_id, 'product_option_id !=' => $a['option']], false, false, 'product_option_name, product_option_name_en, product_option_id, product_option_value_id, option_value');

			array_push($options, $next);
		}

		echo json_encode(['status' => true, 'message' => 'Get data success', 'data' => $options]);

	}

	public function add_to_cart()
	{
		if (!$this->input->is_ajax_request()) {
			$this->not_found();
			return;
		}

		if (!$this->session->userdata('member')) {
			$this->session->set_flashdata('error', 'You need to login to access this page!');
			echo json_encode(['status' => false, 'message' => 'You need to login to access this page!', 'redirect' => site_url('login')]);
			return;
		}

		$arr = $this->input->post();

		$variant = [];
		$product_id = false;
		foreach ($arr['selected_value'] as $a) {
			$product_id = $a['product'];
			$prod = db_get_row_data('view_product_variants', ['product_id' => $a['product'], 'product_option_id' => $a['option'], 'product_option_value_id' => $a['value']]);

			if ($prod) {
				array_push($variant, $prod->sku_id);
			}
		}


		$variant = array_unique($variant);
		if (count($variant) > 1) {
			echo json_encode(['status' => false, 'message' => 'Sku not found']);
			return;
		}

		if ($current = db_get_row_data('fastcon_product_cart', ['product_id' => $a['product'], 'sku_id' => $variant[0]])) {
			update_this_data('fastcon_product_cart', ['cart_id' => $current->cart_id], ['quantity' => $current->quantity + $arr['quantity']]);
		}else{
			if (!$cart = insert_this_data('fastcon_product_cart', ['product_id' => $product_id, 'sku_id' => $variant[0], 'member_id' => $this->session->userdata('member')['member_id'], 'quantity' => $a['quantity']])) {
				echo json_encode(['status' => false, 'message' => 'Something went wrong. Please try again']);
				return;
			}
		}


		echo json_encode(['status' => true, 'message' => 'Product added to cart']);
	}

	public function cart()
	{
		if (!$this->session->userdata('member')) {
			$this->session->set_flashdata('error', 'You need to login to access this page!');
			redirect(site_url('login'));
		}

		$this->data['title'] = 'Cart';
		$this->data['products'] = $this->Model_web->get_product_on_cart();
		$this->data['cart'] = $this->Model_web->get_cart();
		$this->render('cart', $this->data);
	}
}

/* End of file Products.php */
/* Location: ./application/controllers/Products.php */