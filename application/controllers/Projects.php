<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projects extends Front {

	public function __construct()
	{
		parent::__construct();
	}


	public function index()
	{
		$this->data['title'] = 'Projects';
		$this->render('projects', $this->data);
	}

	public function details($id=false, $slug=false)
	{
		$this->data['title'] = 'Projects';
		$this->render('projects-details', $this->data);
	}
}

/* End of file Projects.php */
/* Location: ./application/controllers/Projects.php */