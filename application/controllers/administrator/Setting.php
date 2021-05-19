<?php

defined('BASEPATH') OR exit('No direct script access allowed');





/**

*| --------------------------------------------------------------------------

*| Setting Controller

*| --------------------------------------------------------------------------

*| setting site

*|

*/

class Setting extends Admin	

{

	

	public function __construct()

	{

		parent::__construct();



		$this->load->model('model_setting');

		// if ($this->session->userdata('dstat')!=1) {

		// 	redirect('administrator/dashboard');

		// }

	}



	/**

	* show all setting

	*

	* @var String $offset

	*/

	public function index($offset = 0)

	{

		$this->is_allowed('setting');

		$this->load->model('model_page');

		$this->load->model('model_custom');



		$this->data = [

			'times' => [

				['label' => '15 Minutes', 'value' => '900'],

				['label' => '30 Minutes', 'value' => '1800'],

				['label' => '1 Hours', 'value' => '3600'],

				['label' => '2 Hours', 'value' => '7200'],

				['label' => '4 Hours', 'value' => '14400'],

				['label' => '6 Hours', 'value' => '21600'],

				['label' => '8 Hours', 'value' => '28800'],

				['label' => '12 Hours', 'value' => '43200'],

				['label' => '1 Days', 'value' => '86400'],

				['label' => '1 Week', 'value' => '604800'],

				['label' => '1 Month', 'value' => '2592000'],

				['label' => '6 Month', 'value' => '15552000'],

				['label' => '1 Years', 'value' => '31104000'],

				['label' => 'Always', 'value' => '0']

			],

			'pages' => $this->model_page->find_all(),

			'landing_page' => get_option('landing_page_id', 'default'),

			'timezone_opt' => get_option('timezone'),

			'skins' => $this->model_custom->get_all_skin(), //for skin setting by Benkin 20180502

			'site_logo' => $this->model_custom->get_site_logo('site_logo'),

			'site_logo_small' => $this->model_custom->get_site_logo('site_logo_small'),

			'site_favicon' => $this->model_custom->get_site_logo('site_favicon')

		];



		$this->template->title('Setting List');

		$this->render('backend/standart/administrator/setting/setting_general', $this->data);

	}



	/**

	* Update settings

	*

	*/

	public function save()

	{

		if (!$this->is_allowed('setting_update', false)) {

			return $this->response([

				'success' => false,

				'message' => 'Sorry you do not have permission to setting'

				]);

		}



		$this->load->helper('file');

		$this->load->helper(['cookie']);

		

		$this->form_validation->set_rules('site_name', 'Site Name', 'trim|required');

		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

		$this->form_validation->set_rules('encryption_key', 'Encryption Key', 'trim|required');

		$this->form_validation->set_rules('sess_expiration', 'Encryption Key', 'trim|numeric');

		$this->form_validation->set_rules('sess_time_to_update', 'Session Time to Update', 'trim|numeric');

		$this->form_validation->set_rules('global_xss_filtering', 'Global XSS Filtering', 'trim|required');

		$this->form_validation->set_rules('csrf_token_name', 'CSRF Token Name', 'trim|required');

		$this->form_validation->set_rules('csrf_cookie_name', 'CSRF Cookie Name', 'trim|required');

		$this->form_validation->set_rules('csrf_expire', 'CSRF Expire', 'trim|required');

		$this->form_validation->set_rules('sess_cookie_name', 'Session Cookie Name', 'trim|required');

		$this->form_validation->set_rules('permitted_uri_chars', 'Permitted URI Chars', 'trim|required');

		$this->form_validation->set_rules('landing_page_id', 'Default landing page', 'trim|required');


		if ($this->form_validation->run()) {

			set_option('site_name', $this->input->post('site_name'));

			set_option('email', $this->input->post('email'));

			set_option('author', $this->input->post('author'));

			set_option('site_description', $this->input->post('site_description'));

			set_option('keywords', $this->input->post('keywords'));

			set_option('landing_page_id', $this->input->post('landing_page_id'));

			set_option('timezone', $this->input->post('timezone'));

			set_option('skin', $this->input->post('skin')); //skin setting by Benkin 20180502

            if ($_FILES) {
            	foreach ($_FILES as $file => $value) {
            		if (is_dir(APPPATH.'./asset/logo/'.get_option($file))) {
	            		unlink(APPPATH.'./asset/logo/'.get_option($file));
            		}


            		$_FILES[$file]['name'] = $value['name'];
            		$_FILES[$file]['type'] = $value['type'];
            		$_FILES[$file]['tmp_name'] = $value['tmp_name'];
            		$_FILES[$file]['error'] = $value['error'];
            		$_FILES[$file]['size'] = $value['size'];



            		$config['file_ext_tolower']		= TRUE;
					$config['upload_path']          = 'asset/logo';
		            $config['allowed_types']        = 'gif|jpg|png|jpeg|svg|ico';
		            $config['max_size']             = 4092;
					$config['file_name'] = strtotime('now')."-".strtolower(str_replace(' ', '-', $_FILES[$file]['name']));
		            $this->load->library('upload', $config);
		            $this->upload->initialize($config);
		            if ( ! $this->upload->do_upload($file))
		            {
	                    $error = array('error' => $this->upload->display_errors());
						$this->response['success'] = FALSE;
		            }
		            else
		            {
						set_option($file, $config['file_name']); //site logo setting by Benkin 20180502
		            }
            	}
            }



			set_option('google_id', $this->input->post('google_id'));

			set_option('google_secret', $this->input->post('google_secret'));



        	set_cookie('language', $this->input->post('language'), (60 * 60 * 24) * 365 );





			$data = [

				'php_tag_open' 					=> '<?php',

				'permitted_uri_chars'			=> addslashes($this->input->post('permitted_uri_chars')),

				'url_suffix'					=> addslashes($this->input->post('url_suffix')),

				'encryption_key'				=> addslashes($this->input->post('encryption_key')),

				'sess_expiration'				=> addslashes($this->input->post('sess_expiration')),

				'sess_time_to_update'			=> addslashes($this->input->post('sess_time_to_update')),

				'global_xss_filtering'			=> addslashes($this->input->post('global_xss_filtering')),

				'csrf_token_name'				=> addslashes($this->input->post('csrf_token_name')),

				'csrf_cookie_name'				=> addslashes($this->input->post('csrf_cookie_name')),

				'csrf_expire'					=> addslashes($this->input->post('csrf_expire')),

				'sess_cookie_name'				=> addslashes($this->input->post('sess_cookie_name')),

				'language'						=> addslashes($this->input->post('language'))

			];



			$config_template = $this->parser->parse('core_template/config_template.txt', $data, TRUE);

			write_file(FCPATH . '/application/config/config.php', $config_template);



			$config_template = $this->parser->parse('core_template/setting/routes_landing.php', $data, TRUE);

			write_file(FCPATH . '/application/routes/routes_landing.php', $config_template);



			$this->response['success'] = true;

			$this->response['message'] = 'Your setting has been successfully updated. Press Ctrl + f5 if you change the skin settings';

		} else {

			$this->response['success'] = false;

			$this->response['message'] = validation_errors();

		}



		// return $this->response($this->response); #disabled for return ajax
		$this->session->set_flashdata('response', '<div class="message no-message-padding">'.$this->response['message'].'</div>');
		redirect($this->agent->referrer($this->response));

	}

}





/* End of file Setting.php */

/* Location: ./application/controllers/administrator/Setting.php */