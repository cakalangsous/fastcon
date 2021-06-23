<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends Front {

	public function __construct()
	{
		parent::__construct();
		$this->data['line'] = false;
	}

	public function login()
	{
		$this->data['line'] = true;
		$this->data['title'] = 'Login';
		$this->render('member/login', $this->data);
	}

	public function register()
	{
		$this->data['line'] = true;
		$this->data['title'] = 'Register';
		$this->render('member/register', $this->data);
	}

	public function forgot_password()
	{
		$this->data['line'] = true;
		$this->data['title'] = 'Forgot Password';
		$this->render('member/forgot-password', $this->data);
	}

	public function dashboard()
	{
		$this->data['title'] = 'Dashboard';
		$this->render('member/dashboard', $this->data);
	}

	public function history()
	{
		$this->data['title'] = 'History';
		$this->render('member/history', $this->data);
	}

	public function coupon()
	{
		$this->data['title'] = 'Coupon';
		$this->render('member/coupon', $this->data);
	}

}

/* End of file Member.php */
/* Location: ./application/controllers/Member.php */