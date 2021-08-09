<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Fastcon Brick Thickness Controller
*| --------------------------------------------------------------------------
*| Fastcon Brick Thickness site
*|
*/
class Fastcon_brick_thickness extends Admin
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_fastcon_brick_thickness');
	}

	/**
	* show all Fastcon Brick Thicknesss
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('fastcon_brick_thickness_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['fastcon_brick_thicknesss'] = $this->model_fastcon_brick_thickness->get($filter, $field, $this->limit_page, $offset);
		$this->data['fastcon_brick_thickness_counts'] = $this->model_fastcon_brick_thickness->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/fastcon_brick_thickness/index/',
			'total_rows'   => $this->model_fastcon_brick_thickness->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);
		$this->data['datables'] = true;

		$this->template->title('Brick Thickness List');
		$this->render('backend/standart/administrator/fastcon_brick_thickness/fastcon_brick_thickness_list', $this->data);
	}

	public function data_ajax()
	{
		$this->is_allowed('fastcon_brick_thickness_list');
		$fastcon_brick_thicknesss = $this->model_fastcon_brick_thickness->get($_GET['search']['value'], '', $this->input->get('length'), $this->input->get('start'), 0);
		$data = array();
        $no = $this->input->get('draw');


        foreach($fastcon_brick_thicknesss as $fastcon_brick_thickness){
        	$button = '';
        	$row = [];

						if($this->is_allowed('fastcon_brick_thickness_add'))
        	{
		        $button .= '<a href="'.site_url("administrator/fastcon_brick_thickness/clone_data/" . $fastcon_brick_thickness->id) .'" class="label-default mr-3"><i class="fa fa-copy"></i> '.cclang('clone').'</a>';
        	}
			
	        $button .= '<a href="'.site_url("administrator/fastcon_brick_thickness/view/" . $fastcon_brick_thickness->id).'" class="label-default mr-3"><i class="fa fa-newspaper-o" style="padding-right:3px;"></i> '.cclang("view_button").'</a>';

			        	if($this->is_allowed('fastcon_brick_thickness_update'))
        	{
		        $button .= '<a href="'.site_url("administrator/fastcon_brick_thickness/edit/" . $fastcon_brick_thickness->id) .'" class="label-default mr-3"><i class="fa fa-edit "></i> '.cclang('update_button').'</a>';
        	}
			        	if($this->is_allowed('fastcon_brick_thickness_delete'))
        	{
		        $button .= '<a href="javascript:void(0);" onclick="delete_this(\''.BASE_URL.'administrator/fastcon_brick_thickness/delete/'.$fastcon_brick_thickness->id.'\')" class="label-default remove-data"><i class="fa fa-close"></i>'.cclang('remove_button').'</a>';
        	}



	    	$row[] = $fastcon_brick_thickness->ketebalan;

	    
	        $row[] = $button;
	    	$data[] = $row;
        }

        $output = array(
            "draw" => $this->input->get('draw'),
            "recordsTotal" => $this->model_fastcon_brick_thickness->count_all(),
            "recordsFiltered" => $this->model_fastcon_brick_thickness->count_all(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	/**
	* Add new fastcon_brick_thicknesss
	*
	*/
	public function add()
	{
		$this->is_allowed('fastcon_brick_thickness_add');

		$this->template->title('Brick Thickness New');
		$this->render('backend/standart/administrator/fastcon_brick_thickness/fastcon_brick_thickness_add', $this->data);
	}

	/**
	* Add New Fastcon Brick Thicknesss
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('fastcon_brick_thickness_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('ketebalan', 'Ketebalan', 'trim|required');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
				'ketebalan' => $this->input->post('ketebalan'),
			];

			
			$save_fastcon_brick_thickness = $this->model_fastcon_brick_thickness->store($save_data);

			if ($save_fastcon_brick_thickness) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_fastcon_brick_thickness;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/fastcon_brick_thickness/edit/' . $save_fastcon_brick_thickness, 'Edit Fastcon Brick Thickness'),
						anchor('administrator/fastcon_brick_thickness', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/fastcon_brick_thickness/edit/' . $save_fastcon_brick_thickness, 'Edit Fastcon Brick Thickness')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_brick_thickness');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_brick_thickness');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	
	/**
	* Clone data Fastcon Brick Thickness	*
	*/
	public function clone_data($id=0)
	{
		if($id<=0)
		{
			$this->data['success'] = false;
    		$this->data['message'] = cclang('data_not_found');
			$this->data['redirect'] = base_url('administrator/fastcon_brick_thickness');
			set_message(cclang('data_not_found'), 'warning');
		}

		$this->is_allowed('fastcon_brick_thickness_add');

		if($data = db_get_row_data('fastcon_brick_thickness', ['id' => $id]))
		{
			clone_this_data('fastcon_brick_thickness', ['id' => $id]);
			$this->data['success'] = true;
    		$this->data['message'] = cclang('data_cloned');
			$this->data['redirect'] = base_url('administrator/fastcon_brick_thickness');

			set_message(cclang('data_cloned'), 'success');
		}else{
			set_message(cclang('data_not_found'), 'warning');
		}

		redirect('administrator/fastcon_brick_thickness');

	}

	
		/**
	* Update view Fastcon Brick Thicknesss
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('fastcon_brick_thickness_update');

		$this->data['fastcon_brick_thickness'] = $this->model_fastcon_brick_thickness->find($id);

		$this->template->title('Brick Thickness Update');
		$this->render('backend/standart/administrator/fastcon_brick_thickness/fastcon_brick_thickness_update', $this->data);
	}

	/**
	* Update Fastcon Brick Thicknesss
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('fastcon_brick_thickness_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('ketebalan', 'Ketebalan', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'ketebalan' => $this->input->post('ketebalan'),
			];

			
			$save_fastcon_brick_thickness = $this->model_fastcon_brick_thickness->change($id, $save_data);

			if ($save_fastcon_brick_thickness) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/fastcon_brick_thickness', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_brick_thickness');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_brick_thickness');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Fastcon Brick Thicknesss
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('fastcon_brick_thickness_delete');

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
            set_message(cclang('has_been_deleted', 'fastcon_brick_thickness'), 'success');
        } else {
            set_message(cclang('error_delete', 'fastcon_brick_thickness'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Fastcon Brick Thicknesss
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('fastcon_brick_thickness_view');

		$this->data['fastcon_brick_thickness'] = $this->model_fastcon_brick_thickness->join_avaiable()->find($id);

		$this->template->title('Brick Thickness Detail');
		$this->render('backend/standart/administrator/fastcon_brick_thickness/fastcon_brick_thickness_view', $this->data);
	}
	
	/**
	* delete Fastcon Brick Thicknesss
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$fastcon_brick_thickness = $this->model_fastcon_brick_thickness->find($id);

		
		
		return $this->model_fastcon_brick_thickness->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('fastcon_brick_thickness_export');

		$this->model_fastcon_brick_thickness->export('fastcon_brick_thickness', 'fastcon_brick_thickness');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('fastcon_brick_thickness_export');

		$this->model_fastcon_brick_thickness->pdf('fastcon_brick_thickness', 'fastcon_brick_thickness');
	}
}


/* End of file fastcon_brick_thickness.php */
/* Location: ./application/controllers/administrator/Fastcon Brick Thickness.php */
