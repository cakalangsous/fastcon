<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends Front {

	public function __construct()
	{
		parent::__construct();
		$this->data['line'] = false;

		if (!$this->session->userdata('member')) {
			$this->session->set_flashdata('error', 'You need to login to access this page!');
			redirect(site_url('login'));
		}
		
		$this->load->model('Model_web');

		$this->data['member_menu'] = 'dashboard';
		$this->data['total_coupon'] = count($this->Model_web->get_useable_voucher());
	}


	public function dashboard()
	{
		$this->data['title'] = 'Dashboard';
		$this->data['member'] = db_get_row_data('fastcon_member', ['member_id' => $this->session->userdata('member')['member_id']]);
		$this->data['member_address'] = db_get_all_data('fastcon_member_address', ['member_id' => $this->session->userdata('member')['member_id']], false, false, false, 'active desc');

		$this->render('member/dashboard', $this->data);
	}

	public function update_profile()
	{

		$arr = $this->input->post();

		$this->form_validation->set_rules('fullname', 'Fullname', 'trim|required');
		if (isset($arr['password']) AND $arr['password']!='') {
			$this->form_validation->set_rules('password', 'Password', 'min_length[8]');
			$this->form_validation->set_rules('c_password', 'Confirm Password', 'min_length[8]|matches[password]');
		}else {
			unset($arr['password']);
		}
		unset($arr['c_password']);

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect_back();
		}

		if (isset($arr['password']) AND $arr['password']!='') {
			$arr['salt']			= substr(sha1(uniqid(rand(), true)), 0, 50);
			$arr['password']		= sha1($arr['salt'].$arr['password'].$arr['salt']);

		}

		update_this_data('fastcon_member', ['member_id' => $this->session->userdata('member')['member_id']], $arr);

		$this->session->set_flashdata('response', 'Profile Updated!');
		redirect_back();
	}

	public function save_address()
	{
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

		if (count(db_get_all_data('fastcon_member_address', ['member_id' => $this->session->userdata('member')['member_id']])) == 3 ) {
			$this->session->set_flashdata('error', 'You\'ve reached the maximum address (3) for your account.');
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

		$current_active = db_get_all_data('fastcon_member_address', ['member_id' => $this->session->userdata('member')['member_id'], 'active' => 1]);
		if ($current_active) {
			update_this_data('fastcon_member_address', ['member_id' => $this->session->userdata('member')['member_id'], 'active' => 1], ['active' => 0]);
		}

		$address = [
			'name'		=> $arr['fullname'],
			'email'		=> $arr['email'],
			'phone'		=> $arr['phone'],
			'province_id'=> $arr['province_id'],
			'provinsi' 	=> $destination_code->provinsi,
			'kabupaten' => $destination_code->kabupaten,
			'kecamatan' => $destination_code->kecamatan,
			'kelurahan' => $destination_code->kelurahan,
			'kode_pos' 	=> $destination_code->kode_pos,
			'address'	=> $arr['address'],
			'member_id' => $this->session->userdata('member')['member_id'],
			'active'  	=> 1
		];

		if (!insert_this_data('fastcon_member_address', $address)) {
			$this->session->set_flashdata('error', 'Something went wrong! Please try again');
			redirect_back();
		}

		$this->session->set_flashdata('welcome', 'New address saved.');
		redirect_back();
	}

	public function change_active($address_id=false)
	{
		if (!$address_id) {
			$this->not_found();
			return;
		}

		$address = db_get_row_data('fastcon_member_address', ['id' => $address_id]);
		if (!$address OR $address->member_id != $this->session->userdata('member')['member_id']) {
			$this->not_found();
			return;
		}

		update_this_data('fastcon_member_address', ['member_id' => $this->session->userdata('member')['member_id'], 'active' => 1], ['active' => 0]);
		update_this_data('fastcon_member_address', ['id' => $address_id], ['active' => 1]);

		$this->session->set_flashdata('welcome', 'Active address successfully changed.');
		redirect_back();
	}

	public function update_address($address_id=false)
	{
		if (!$address_id) {
			$this->not_found();
			return;
		}

		if (!$selected_address = db_get_row_data('fastcon_member_address', ['member_id' => $this->session->userdata('member')['member_id'], 'id' => $address_id] )) {
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
			'member_id' 	=> $this->session->userdata('member')['member_id'],
			'active'  		=> $selected_address->active
		];

		update_this_data('fastcon_member_address', ['id' => $address_id], $address);
		$this->session->set_flashdata('welcome', 'Address successfully updated.');
		redirect_back();
	}

	public function delete_address($address_id=false)
	{
		if (!$address_id) {
			$this->not_found();
			return;
		}

		$address = db_get_row_data('fastcon_member_address', ['id' => $address_id]);
		if (!$address OR $address->member_id != $this->session->userdata('member')['member_id']) {
			$this->not_found();
			return;
		}

		if ($address->active == 1) {
			$set_active = db_get_row_data('fastcon_member_address', ['member_id' => $this->session->userdata('member')['member_id'], 'id !=' => $address_id ], false, false, false, 'id desc');
			if ($set_active) {
				update_this_data('fastcon_member_address', ['id' => $set_active->id], ['active' => 1]);
			}
		}

		delete_this_data('fastcon_member_address', ['id' => $address_id]);

		$this->session->set_flashdata('welcome', 'Address deleted.');
		redirect_back();
	}

	public function history()
	{
		$this->data['title'] = 'History';
		$this->data['member_menu'] = 'history';
		$this->data['transaction_history'] = db_get_all_data('fastcon_product_orders', ['member_id' => $this->session->userdata('member')['member_id']]);
		$this->data['transaction_history_grouped'] = db_get_all_data('view_order_grouped', ['member_id' => $this->session->userdata('member')['member_id']], false, false, false, 'order_id desc', 'order_code');

		// echo '<pre>';
		// print_r($this->data['transaction_history_grouped']);
		// exit;

		$this->render('member/history', $this->data);
	}

	public function cancel_order($order_code = false)
	{
		if (!$order_code) {
			$this->not_found();
			return;
		}

		$orders = db_get_all_data('fastcon_product_orders', ['order_code' => $order_code]);
		if (!$orders OR $orders[0]->member_id != $this->session->userdata('member')['member_id'] OR $orders[0]->order_status!=1) {
			$this->not_found();
			return;
		}

		foreach ($orders as $o) {
			update_this_data('fastcon_product_orders', ['order_id' => $o->order_id], ['order_status' => 4]);
		}

		$info['title']		= lang('order_cancelled_title');
		$info['caption']	= lang('order_cancelled_email');
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
		$this->email->to($this->session->userdata('member')['email']);
		$this->email->subject('Fastcon - Thank you for purchase');
		$this->email->message($html);
		
		$this->email->send();

		$this->session->set_flashdata('response', 'Order cancelled.');
		redirect(site_url('member/history'));
	}

	public function coupon()
	{
		$this->data['title'] = 'Coupon';
		$this->data['member_menu'] = 'coupon';
		$this->data['coupon'] = $this->Model_web->get_useable_voucher();
		// $this->data['coupon'] = db_get_all_data('view_usable_voucher');
		$this->render('member/coupon', $this->data);
	}

	// public function use_coupon($voucher_id=false)
	// {
	// 	if (!$voucher_id) {
	// 		$this->not_found();
	// 		return;
	// 	}

	// 	if (!$voucher = db_get_row_data('view_usable_voucher', ['voucher_id' => $voucher_id])) {
	// 		$this->not_found();
	// 		return;
	// 	}

	// 	if ($this->session->userdata('voucher')) {
	// 		$this->session->unset_userdata('voucher');
	// 	}

	// 	$array = [
	// 		'voucher_id' => $voucher->voucher_id,
	// 		'voucher_code' => $voucher->voucher_code,
	// 		'voucher_discount' => $voucher->voucher_discount,
	// 		'min_purchase' => $voucher->min_purchase,
	// 		'start_date' => $voucher->start_date,
	// 		'end_date' => $voucher->end_date,
	// 	];
		
	// 	$this->session->set_userdata(['voucher' => $array]);
	// 	redirect(site_url('products'));

	// }

	public function logout()
	{
		$this->session->unset_userdata('member');
		if ($this->session->userdata('cart')) {
			$this->session->unset_userdata('cart');
		}
		if ($this->session->userdata('voucher')) {
			$this->session->unset_userdata('voucher');
		}
		redirect(site_url());
	}

}

/* End of file Member.php */
/* Location: ./application/controllers/Member.php */