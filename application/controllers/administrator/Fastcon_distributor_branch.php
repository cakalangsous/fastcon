<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Fastcon Distributor Branch Controller
*| --------------------------------------------------------------------------
*| Fastcon Distributor Branch site
*|
*/
class Fastcon_distributor_branch extends Admin
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_fastcon_distributor_branch');
	}

	/**
	* show all Fastcon Distributor Branchs
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('fastcon_distributor_branch_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['fastcon_distributor_branchs'] = $this->model_fastcon_distributor_branch->get($filter, $field, $this->limit_page, $offset);
		$this->data['fastcon_distributor_branch_counts'] = $this->model_fastcon_distributor_branch->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/fastcon_distributor_branch/index/',
			'total_rows'   => $this->model_fastcon_distributor_branch->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);
		$this->data['datables'] = true;

		$this->template->title('Distributor Branch List');
		$this->render('backend/standart/administrator/fastcon_distributor_branch/fastcon_distributor_branch_list', $this->data);
	}

	public function data_ajax()
	{
		$this->is_allowed('fastcon_distributor_branch_list');
		$fastcon_distributor_branchs = $this->model_fastcon_distributor_branch->get($_GET['search']['value'], '', $this->input->get('length'), $this->input->get('start'), 0);
		$data = array();
        $no = $this->input->get('draw');


        foreach($fastcon_distributor_branchs as $fastcon_distributor_branch){
        	$button = '';
        	$row = [];

			
	        $button .= '<a href="'.site_url("administrator/fastcon_distributor_branch/view/" . $fastcon_distributor_branch->branch_id).'" class="label-default mr-3"><i class="fa fa-newspaper-o" style="padding-right:3px;"></i> '.cclang("view_button").'</a>';

			        	if($this->is_allowed('fastcon_distributor_branch_update'))
        	{
		        $button .= '<a href="'.site_url("administrator/fastcon_distributor_branch/edit/" . $fastcon_distributor_branch->branch_id) .'" class="label-default mr-3"><i class="fa fa-edit "></i> '.cclang('update_button').'</a>';
        	}
			        	if($this->is_allowed('fastcon_distributor_branch_delete'))
        	{
		        $button .= '<a href="javascript:void(0);" onclick="delete_this(\''.BASE_URL.'administrator/fastcon_distributor_branch/delete/'.$fastcon_distributor_branch->branch_id.'\')" class="label-default remove-data"><i class="fa fa-close"></i>'.cclang('remove_button').'</a>';
        	}



	    			$row[] = $fastcon_distributor_branch->distributor_name;
	    	$row[] = $fastcon_distributor_branch->distributor_city;

	    	$row[] = $fastcon_distributor_branch->distributor_address;

	    	$row[] = $fastcon_distributor_branch->phone;

	    
	        $row[] = $button;
	    	$data[] = $row;
        }

        $output = array(
            "draw" => $this->input->get('draw'),
            "recordsTotal" => $this->model_fastcon_distributor_branch->count_all(),
            "recordsFiltered" => $this->model_fastcon_distributor_branch->count_all(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	/**
	* Add new fastcon_distributor_branchs
	*
	*/
	public function add()
	{
		$this->is_allowed('fastcon_distributor_branch_add');

		$this->template->title('Distributor Branch New');
		$this->render('backend/standart/administrator/fastcon_distributor_branch/fastcon_distributor_branch_add', $this->data);
	}

	/**
	* Add New Fastcon Distributor Branchs
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('fastcon_distributor_branch_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('distributor_id', 'Distributor Id', 'trim|required');
		$this->form_validation->set_rules('distributor_city', 'Distributor City', 'trim|required');
		$this->form_validation->set_rules('distributor_address', 'Distributor Address', 'trim|required');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
				'distributor_id' => $this->input->post('distributor_id'),
				'distributor_city' => $this->input->post('distributor_city'),
				'distributor_address' => $this->input->post('distributor_address'),
				'phone' => $this->input->post('phone'),
			];

			
			$save_fastcon_distributor_branch = $this->model_fastcon_distributor_branch->store($save_data);

			if ($save_fastcon_distributor_branch) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_fastcon_distributor_branch;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/fastcon_distributor_branch/edit/' . $save_fastcon_distributor_branch, 'Edit Fastcon Distributor Branch'),
						anchor('administrator/fastcon_distributor_branch', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/fastcon_distributor_branch/edit/' . $save_fastcon_distributor_branch, 'Edit Fastcon Distributor Branch')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_distributor_branch');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_distributor_branch');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	
		/**
	* Update view Fastcon Distributor Branchs
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('fastcon_distributor_branch_update');

		$this->data['fastcon_distributor_branch'] = $this->model_fastcon_distributor_branch->find($id);

		$this->template->title('Distributor Branch Update');
		$this->render('backend/standart/administrator/fastcon_distributor_branch/fastcon_distributor_branch_update', $this->data);
	}

	/**
	* Update Fastcon Distributor Branchs
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('fastcon_distributor_branch_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('distributor_id', 'Distributor Id', 'trim|required');
		$this->form_validation->set_rules('distributor_city', 'Distributor City', 'trim|required');
		$this->form_validation->set_rules('distributor_address', 'Distributor Address', 'trim|required');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'distributor_id' => $this->input->post('distributor_id'),
				'distributor_city' => $this->input->post('distributor_city'),
				'distributor_address' => $this->input->post('distributor_address'),
				'phone' => $this->input->post('phone'),
			];

			
			$save_fastcon_distributor_branch = $this->model_fastcon_distributor_branch->change($id, $save_data);

			if ($save_fastcon_distributor_branch) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/fastcon_distributor_branch', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_distributor_branch');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_distributor_branch');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Fastcon Distributor Branchs
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('fastcon_distributor_branch_delete');

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
            set_message(cclang('has_been_deleted', 'fastcon_distributor_branch'), 'success');
        } else {
            set_message(cclang('error_delete', 'fastcon_distributor_branch'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Fastcon Distributor Branchs
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('fastcon_distributor_branch_view');

		$this->data['fastcon_distributor_branch'] = $this->model_fastcon_distributor_branch->join_avaiable()->find($id);

		$this->template->title('Distributor Branch Detail');
		$this->render('backend/standart/administrator/fastcon_distributor_branch/fastcon_distributor_branch_view', $this->data);
	}
	
	/**
	* delete Fastcon Distributor Branchs
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$fastcon_distributor_branch = $this->model_fastcon_distributor_branch->find($id);

		
		
		return $this->model_fastcon_distributor_branch->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('fastcon_distributor_branch_export');

		$this->model_fastcon_distributor_branch->export('fastcon_distributor_branch', 'fastcon_distributor_branch');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('fastcon_distributor_branch_export');

		$this->model_fastcon_distributor_branch->pdf('fastcon_distributor_branch', 'fastcon_distributor_branch');
	}
}


/* End of file fastcon_distributor_branch.php */
/* Location: ./application/controllers/administrator/Fastcon Distributor Branch.php */
