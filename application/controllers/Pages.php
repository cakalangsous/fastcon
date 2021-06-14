<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends Front {

	public function index()
	{
		$this->data['title'] = 'Home';
		$this->render('home', $this->data);
	}

	public function distributor()
	{
		$this->data['title'] = 'Distributor';
		$this->render('distributor', $this->data);
	}

	public function about()
	{
		$this->data['title'] = 'About';
		$this->render('about', $this->data);
	}

	public function contact()
	{
		$this->data['title'] = 'Contact';
		$this->render('contact', $this->data);
	}

	public function calculator()
	{
		$this->data['title'] = 'Accounting Calculator';
		$this->render('accounting-calc', $this->data);
	}

}

/* End of file Pages.php */
/* Location: ./application/controllers/Pages.php */