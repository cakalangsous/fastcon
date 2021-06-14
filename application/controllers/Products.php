<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends Front {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->data['title'] = 'Products';
		$this->render('products', $this->data);
	}

	public function details($id=false, $slug=false)
	{
		$this->data['title'] = 'Product Details';
		$this->render('product-details', $this->data);
	}

	public function cart()
	{
		$this->data['title'] = 'Cart';
		$this->render('cart', $this->data);
	}

}

/* End of file Products.php */
/* Location: ./application/controllers/Products.php */