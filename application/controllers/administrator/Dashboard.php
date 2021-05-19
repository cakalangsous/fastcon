<?php

defined('BASEPATH') OR exit('No direct script access allowed');





/**

*| --------------------------------------------------------------------------

*| Dashboard Controller

*| --------------------------------------------------------------------------

*| For see your board

*|

*/

class Dashboard extends Admin	

{

	

	public function __construct()

	{

		parent::__construct();

	}



	public function index()

	{
		if ($this->session->userdata('dstat')!=1) {
			// if (!$this->aauth->is_allowed('dashboard')) {
			if (!$this->aauth->is_group_allowed('menu_dashboard')) {
			
				$this->session->sess_destroy();
				$this->session->set_flashdata('f_message', 'Sorry, You don\'t have permission to access this. Please contact your administrator');
				$this->session->set_flashdata('f_type', 'warning');
				redirect('/','refresh');

			}
		}


		$data = [];

		$this->render('backend/standart/dashboard', $data);

	}



	public function chart()

	{

		if (!$this->aauth->is_allowed('dashboard')) {

			redirect('/','refresh');

		}



		$data = [];

		$this->render('backend/standart/chart', $data);

	}

}



/* End of file Dashboard.php */

/* Location: ./application/controllers/administrator/Dashboard.php */