<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Fastcon About Controller
*| --------------------------------------------------------------------------
*| Fastcon About site
*|
*/
class Fastcon_about extends Admin
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_fastcon_about');
	}

	/**
	* show all Fastcon Abouts
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('fastcon_about_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['fastcon_abouts'] = $this->model_fastcon_about->get($filter, $field, $this->limit_page, $offset);
		$this->data['fastcon_about_counts'] = $this->model_fastcon_about->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/fastcon_about/index/',
			'total_rows'   => $this->model_fastcon_about->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);
		$this->data['datables'] = true;

		$this->template->title('About List');
		$this->render('backend/standart/administrator/fastcon_about/fastcon_about_list', $this->data);
	}

	public function data_ajax()
	{
		$this->is_allowed('fastcon_about_list');
		$fastcon_abouts = $this->model_fastcon_about->get($_GET['search']['value'], '', $this->input->get('length'), $this->input->get('start'), 0);
		$data = array();
        $no = $this->input->get('draw');


        foreach($fastcon_abouts as $fastcon_about){
        	$button = '';
        	$row = [];

			
	        $button .= '<a href="'.site_url("administrator/fastcon_about/view/" . $fastcon_about->id).'" class="label-default mr-3"><i class="fa fa-newspaper-o" style="padding-right:3px;"></i> '.cclang("view_button").'</a>';

			        	if($this->is_allowed('fastcon_about_update'))
        	{
		        $button .= '<a href="'.site_url("administrator/fastcon_about/edit/" . $fastcon_about->id) .'" class="label-default mr-3"><i class="fa fa-edit "></i> '.cclang('update_button').'</a>';
        	}
			      //   	if($this->is_allowed('fastcon_about_delete'))
        	// {
		       //  $button .= '<a href="javascript:void(0);" onclick="delete_this(\''.BASE_URL.'administrator/fastcon_about/delete/'.$fastcon_about->id.'\')" class="label-default remove-data"><i class="fa fa-close"></i>'.cclang('remove_button').'</a>';
        	// }



	    	$row[] = $fastcon_about->about;

	    	$row[] = $fastcon_about->about_en;

	    	$row[] = $fastcon_about->vision_mission;

	    	$row[] = $fastcon_about->vision_mission_en;

	    
	        $row[] = $button;
	    	$data[] = $row;
        }

        $output = array(
            "draw" => $this->input->get('draw'),
            "recordsTotal" => $this->model_fastcon_about->count_all(),
            "recordsFiltered" => $this->model_fastcon_about->count_all(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	
	
		/**
	* Update view Fastcon Abouts
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('fastcon_about_update');

		$this->data['fastcon_about'] = $this->model_fastcon_about->find($id);

		$this->template->title('About Update');
		$this->render('backend/standart/administrator/fastcon_about/fastcon_about_update', $this->data);
	}

	/**
	* Update Fastcon Abouts
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('fastcon_about_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('about', 'About', 'trim|required');
		$this->form_validation->set_rules('about_en', 'About En', 'trim|required');
		$this->form_validation->set_rules('vision_mission', 'Vision Mission', 'trim|required');
		$this->form_validation->set_rules('vision_mission_en', 'Vision Mission En', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'about' => $this->input->post('about'),
				'about_en' => $this->input->post('about_en'),
				'vision_mission' => $this->input->post('vision_mission'),
				'vision_mission_en' => $this->input->post('vision_mission_en'),
			];

			
			$save_fastcon_about = $this->model_fastcon_about->change($id, $save_data);

			if ($save_fastcon_about) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/fastcon_about', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_about');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_about');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Fastcon Abouts
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('fastcon_about_delete');

		$this->load->helper('file');

		$arr_id = $this->input->get('id');
		$remove = false;

		if (!empty($id)) {
			$remove = $this->_remove($id);
		} elseif (count($arr_id) >0) {
			foreach ($arr_id as $id) {
				$remove = $this->_remove($id);
			}
		}

		if ($remove) {
            set_message(cclang('has_been_deleted', 'fastcon_about'), 'success');
        } else {
            set_message(cclang('error_delete', 'fastcon_about'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Fastcon Abouts
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('fastcon_about_view');

		$this->data['fastcon_about'] = $this->model_fastcon_about->join_avaiable()->find($id);

		$this->template->title('About Detail');
		$this->render('backend/standart/administrator/fastcon_about/fastcon_about_view', $this->data);
	}
	
	/**
	* delete Fastcon Abouts
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$fastcon_about = $this->model_fastcon_about->find($id);

		
		
		return $this->model_fastcon_about->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('fastcon_about_export');

		$this->model_fastcon_about->export('fastcon_about', 'fastcon_about');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('fastcon_about_export');

		$this->model_fastcon_about->pdf('fastcon_about', 'fastcon_about');
	}
}


/* End of file fastcon_about.php */
/* Location: ./application/controllers/administrator/Fastcon About.php */
