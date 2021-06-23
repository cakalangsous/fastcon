<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends Front {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->data['title'] = 'Cart Options';
		$this->render('member-guest', $this->data);
	}

	public function guest()
	{
		$this->data['title'] = 'Guest';
		$this->render('guest', $this->data);
	}

	public function summary()
	{
		$this->data['title'] = 'Checkout';
		$this->data['checkout'] = true;
		$this->render('checkout', $this->data);
	}
	
}

/* End of file Checkout.php */
/* Location: ./application/controllers/Checkout.php */