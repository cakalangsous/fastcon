<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends Front {


	public function index()
	{
		$this->data['title'] 		= 'Home';
		$this->data['banner']		= db_get_row_data('fastcon_banner', ['id' => 1]);
		$this->data['bennefits'] 	= db_get_all_data('fastcon_benefits');
		$this->data['location'] 	= db_get_row_data('fastcon_our_location', ['id' => 1]);
		$this->data['projects']		= db_get_all_data('fastcon_projects', ['featured' => 'yes'], 6, false, false, 'id desc');
		$this->data['news']			= db_get_all_data('fastcon_news', false, 3, false, false, 'created_at desc' );
		$this->data['popup']		= db_get_row_data('fastcon_home_popup', ['id' => 1, 'active' => 'yes']);
		$this->render('home', $this->data);
	}

	public function distributor()
	{
		$this->data['active']	= 'dist';
		$this->data['title'] 	= 'Distributor';
		$this->data['province']	= db_get_all_data('fastcon_distributor_province');
		$this->data['dist'] 	= db_get_all_data('fastcon_distributor', false, false, false, false, 'id desc');

		$province = $this->input->get('p');
		if ($province!=null) {
			$this->data['dist'] 	= db_get_all_data('fastcon_distributor', ['distributor_province' => $province]);
		}
		$this->render('distributor', $this->data);
	}

	public function about()
	{
		$this->data['title'] 	= 'About';
		$this->data['about_active'] = 'about';
		$this->data['content'] = db_get_row_data('fastcon_about', ['id' => 1]);
		$this->render('about', $this->data);
	}

	public function vision_mission()
	{
		$this->data['title'] 	= 'Vision and Mission';
		$this->data['about_active'] = 'vision';
		$this->data['content'] = db_get_row_data('fastcon_about', ['id' => 1]);
		$this->render('about', $this->data);
	}

	public function page_details($id=false, $slug=false)
	{
		if (!$id) {
			$this->not_found();
			return;
		}

		if (!$page = db_get_row_data('fastcon_pages', ['id' => $id])) {	
			$this->not_found();
			return;
		}

		$this->data['content'] = $page;
		$this->data['title'] = $page->title_en;
		$this->render('about', $this->data);

	}

	public function contact()
	{
		$this->data['active']	= 'contact';
		$this->data['title'] 	= 'Contact';
		$this->data['topic']	= db_get_all_data('fastcon_contact_topic');
		$this->render('contact', $this->data);
	}

	public function contact_submit()
	{
		$this->form_validation->set_rules('name', 'Fullname', 'trim|required');
		$this->form_validation->set_rules('email', 'E-mail', 'valid_email');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required|numeric');
		$this->form_validation->set_rules('topic', 'Topic', 'trim|required|numeric');
		$this->form_validation->set_rules('message', 'Message', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect_back();
		}

		$arr = $this->input->post();

		$arr['ip_address'] = $this->input->ip_address();

		if (!insert_this_data('fastcon_contact_submit', $arr)) {
			$this->session->set_flashdata('error', 'Something went wrong. Please try again!');
			redirect_back();
		}

		$info['title']		= lang('thank_you_title');
		$info['caption']	= lang('thank_you_content');
		$info['marketplace']= $this->data['marketplace'];

		$html = $this->load->view('email/index', $info, true);

		print_r($html);
		exit;

		$this->load->library('email');

		$this->email->initialize($this->mail_config());
		$this->email->set_newline("\r\n");
		$this->email->from(getenv('NO_REPLY_EMAIL'), getenv('SENDER_NAME'));
		$this->email->to($arr['email']);
		$this->email->subject('Fastcon - Contact Submitted');
		$this->email->message($html);
		
		$this->email->send();


		$topic = db_get_row_data('fastcon_contact_topic', ['topid_id' => $arr['topic']]);

		$info['title']		= 'New Contact Inquiry Submitted';
		$info['caption']	= 'Dear admin, this is e-mail notification for new submitted inquiry from user. Please respond in 1x24 work hours via phone number or e-mail.';
		$info['marketplace']= $this->data['marketplace'];

		$html = $this->load->view('email/index', $info, true);

		$this->email->initialize($this->mail_config());
		$this->email->from($this->config->item('no_reply_email'), $this->config->item('sender_name'));
		$this->email->to($topic->email);
		$this->email->subject('Fastcon - New Contact Submitted');
		$this->email->message($html);
		
		$this->email->send();


		$this->session->set_flashdata('response', ['title' => lang('thank_you_title'), 'content' => lang('thank_you_content')]);

		redirect(site_url('thankyou'));

	}

	public function login()
	{
		if ($this->session->userdata('member')) {
			redirect(site_url('member/dashboard'));
		}

		$this->data['line'] = true;
		$this->data['title'] = 'Login';

		$this->render('member/login', $this->data);
	}

	public function register()
	{
		if ($this->session->userdata('member')) {
			redirect(site_url('member/dashboard'));
		}

		$this->data['line'] = true;
		$this->data['title'] = 'Register';
		$this->render('member/register', $this->data);
	}

	public function forgot_password()
	{
		if ($this->session->userdata('member')) {
			redirect(site_url('member/dashboard'));
		}

		$this->data['line'] = true;
		$this->data['title'] = 'Forgot Password';
		$this->render('member/forgot-password', $this->data);
	}

	public function register_submit()
	{
		if ($this->session->userdata('member')) {
			redirect(site_url('member/dashboard'));
		}

		$this->form_validation->set_rules('fullname', 'Fullname', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[fastcon_member.email]', [
			'is_unique' => 'Email registered'
		]);
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
		$this->form_validation->set_rules('c_password', 'Confirm Password', 'trim|required|min_length[8]|matches[password]');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect_back();
		}

		$arr = $this->input->post();
		unset($arr['c_password']);

		$arr['salt']			= substr(sha1(uniqid(rand(), true)), 0, 50);
		$arr['verified_key']	= substr(sha1(uniqid(rand(), true)), 0, 50);
		$arr['password']		= sha1($arr['salt'].$arr['password'].$arr['salt']);

		if (!insert_this_data('fastcon_member', $arr)) {
			$this->session->set_flashdata('error', 'Something went wrong. Please try again!');
			redirect_back();
		}

		$info['title']		= 'Thank you for registration';
		$info['caption']	= 'In order to login to our site, you need to verify your account. Click verify button below to verify your account.';
		$info['link']		= site_url('verify_email/'.$arr['verified_key'].'/'.sha1($arr['email']).'/'.$arr['salt']);

		$html = $this->load->view('email/index', $info, true);

		$this->load->library('email');

		$this->email->initialize($this->mail_config());
		$this->email->set_newline("\r\n");
		$this->email->from(getenv('NO_REPLY_EMAIL'), getenv('SENDER_NAME'));
		$this->email->to($arr['email']);
		$this->email->subject('Fastcon - Contact Submitted');
		$this->email->message($html);
		
		$this->email->send();


		$this->session->set_flashdata('response', ['title' => lang('register_email_title'), 'content' => '']);
		redirect(site_url('thankyou'));
	}

	public function verify_email($key=false, $email=false, $salt=false)
	{
		if ($this->session->userdata('member')) {
			redirect(site_url('member/dashboard'));
		}

		if (!$key OR !$email OR !$salt) {
			$this->not_found();
			return;
		}

		if (!$user = db_get_row_data('fastcon_member', ['verified_key' => $key])) {
			$this->not_found();
			return;
		}

		update_this_data('fastcon_member', ['member_id' => $user->member_id], ['verified_at' => date('Y-m-d H:i:s', strtotime('now'))]);

		$this->session->set_flashdata('response', 'Your email is successfully verified');
		redirect(site_url('login'));
	}

	public function authentication()
	{
		if ($this->session->userdata('member')) {
			redirect(site_url('member/dashboard'));
		}

		$this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect_back();
		}

		$arr = $this->input->post();

		if (!$user = db_get_row_data('fastcon_member', ['email' => $arr['email']])) {
			$this->session->set_flashdata('error', 'User not found!');
			redirect_back();
		}

		$password = sha1($user->salt.$arr['password'].$user->salt);

		if ($password != $user->password) {
			$this->session->set_flashdata('error', 'User not found!');
			redirect_back();
		}

		if ($user->verified_at == null) {
			$this->session->set_flashdata('error', 'Email not verified! Please check and confirm your email.');
			redirect_back();
		}

		$this->load->library('cart');

		if ($this->cart->contents()) {
			foreach ($this->cart->contents() as $c) {
				$cart_data = [
					'member_id' => $user->member_id,
					'product_id' => $c['product_id'],
					'quantity' => $c['qty']
				];

				$cart = db_get_row_data('fastcon_product_cart', ['member_id' => $user->member_id, 'variant_id' => $c['id']]);
				if ($cart) {
					update_this_data('fastcon_product_cart', ['member_id' => $user->member_id, 'variant_id' => $c['id']], $cart_data);
				}else {
					$cart_data['variant_id'] = $c['id'];
					insert_this_data('fastcon_product_cart', $cart_data);
				}

			}
		}

		$this->session->set_flashdata('welcome', lang('success_login'));

		$array = [
			'member' => [
				'member_id' => $user->member_id,
				'name' => $user->fullname,
				'email' => $user->email
			]
		];
		
		$this->session->set_userdata( $array );
		if($this->agent->referrer() == site_url('checkout')) {
			redirect('checkout');
		}
		redirect(site_url('member/dashboard'));
	}

	public function calculator()
	{
		$this->data['title'] = 'Accounting Calculator';
		$this->data['bricks'] = db_get_all_data('fastcon_brick_thickness');
		$this->render('accounting-calc', $this->data);
	}

	public function thankyou()
	{
		$this->data['title'] = 'Thank You';
		$this->render('thankyou', $this->data);
	}

}

/* End of file Pages.php */
/* Location: ./application/controllers/Pages.php */