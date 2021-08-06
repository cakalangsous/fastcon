<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projects extends Front {

	public function __construct()
	{
		parent::__construct();
		$this->data['active'] = 'project';
	}


	public function index($offset=0)
	{
		$limit = 6;
		$this->data['title'] 			= lang('project');
		$this->data['projects'] 		= db_get_all_data('fastcon_projects', false, $limit, $offset, false, 'id desc');

		if ($cat = $this->input->get('c')) {
			$this->data['projects'] = db_get_all_data('fastcon_projects', ['category' => $cat], $limit, $offset, false, 'id desc');
			
		}
		$this->data['project_category'] = db_get_all_data('fastcon_project_category');

		$config = [
			'base_url'     => 'projects',
			'total_rows'   => count(db_get_all_data('fastcon_projects', $cat)),
			'per_page'     => $limit,
			'uri_segment'  => 2,
		];
		$this->data['pagination'] 	= $this->pagination_front($config);

		$this->render('projects', $this->data);
	}

	public function details($id=false, $slug=false)
	{
		$project = db_get_row_data('fastcon_projects', ['id' => $id]);
		if (!$project OR !$id) {
			$this->not_found();
			return;
		}
		$this->data['project'] 			= $project;
		$this->data['title'] 			= $this->data['lang']=='indonesian'?ucwords(strtolower($project->title)):ucwords(strtolower($project->title_en));
		$this->data['related_project'] 	= db_get_all_data('fastcon_projects', ['category' => $project->category, 'id' => '!='.$project->id], 2);
		$this->render('projects-details', $this->data);
	}
}

/* End of file Projects.php */
/* Location: ./application/controllers/Projects.php */