<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Fastcon Distributor Controller
*| --------------------------------------------------------------------------
*| Fastcon Distributor site
*|
*/
class Fastcon_distributor extends Admin
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_fastcon_distributor');
	}

	/**
	* show all Fastcon Distributors
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('fastcon_distributor_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['fastcon_distributors'] = $this->model_fastcon_distributor->get($filter, $field, $this->limit_page, $offset);
		$this->data['fastcon_distributor_counts'] = $this->model_fastcon_distributor->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/fastcon_distributor/index/',
			'total_rows'   => $this->model_fastcon_distributor->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);
		$this->data['datables'] = true;

		$this->template->title('Distributor List');
		$this->render('backend/standart/administrator/fastcon_distributor/fastcon_distributor_list', $this->data);
	}

	public function data_ajax()
	{
		$this->is_allowed('fastcon_distributor_list');
		$fastcon_distributors = $this->model_fastcon_distributor->get($_GET['search']['value'], '', $this->input->get('length'), $this->input->get('start'), 0);
		$data = array();
        $no = $this->input->get('draw');


        foreach($fastcon_distributors as $fastcon_distributor){
        	$button = '';
        	$row = [];

						if($this->is_allowed('fastcon_distributor_add'))
        	{
		        $button .= '<a href="'.site_url("administrator/fastcon_distributor/clone_data/" . $fastcon_distributor->id) .'" class="label-default mr-3"><i class="fa fa-copy"></i> '.cclang('clone').'</a>';
        	}
			
	        $button .= '<a href="'.site_url("administrator/fastcon_distributor/view/" . $fastcon_distributor->id).'" class="label-default mr-3"><i class="fa fa-newspaper-o" style="padding-right:3px;"></i> '.cclang("view_button").'</a>';

			        	if($this->is_allowed('fastcon_distributor_update'))
        	{
		        $button .= '<a href="'.site_url("administrator/fastcon_distributor/edit/" . $fastcon_distributor->id) .'" class="label-default mr-3"><i class="fa fa-edit "></i> '.cclang('update_button').'</a>';
        	}
			        	if($this->is_allowed('fastcon_distributor_delete'))
        	{
		        $button .= '<a href="javascript:void(0);" onclick="delete_this(\''.BASE_URL.'administrator/fastcon_distributor/delete/'.$fastcon_distributor->id.'\')" class="label-default remove-data"><i class="fa fa-close"></i>'.cclang('remove_button').'</a>';
        	}



	    			$row[] = $fastcon_distributor->province_name;
	    	$row[] = $fastcon_distributor->distributor_name;

	    
	        $row[] = $button;
	    	$data[] = $row;
        }

        $output = array(
            "draw" => $this->input->get('draw'),
            "recordsTotal" => $this->model_fastcon_distributor->count_all(),
            "recordsFiltered" => $this->model_fastcon_distributor->count_all(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	/**
	* Add new fastcon_distributors
	*
	*/
	public function add()
	{
		$this->is_allowed('fastcon_distributor_add');

		$this->template->title('Distributor New');
		$this->render('backend/standart/administrator/fastcon_distributor/fastcon_distributor_add', $this->data);
	}

	/**
	* Add New Fastcon Distributors
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('fastcon_distributor_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('distributor_province', 'Distributor Province', 'trim|required');
		$this->form_validation->set_rules('distributor_name', 'Distributor Name', 'trim|required');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
				'distributor_province' => $this->input->post('distributor_province'),
				'distributor_name' => $this->input->post('distributor_name'),
			];

			
			$save_fastcon_distributor = $this->model_fastcon_distributor->store($save_data);

			if ($save_fastcon_distributor) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_fastcon_distributor;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/fastcon_distributor/edit/' . $save_fastcon_distributor, 'Edit Fastcon Distributor'),
						anchor('administrator/fastcon_distributor', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/fastcon_distributor/edit/' . $save_fastcon_distributor, 'Edit Fastcon Distributor')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_distributor');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_distributor');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	
	/**
	* Clone data Fastcon Distributor	*
	*/
	public function clone_data($id=0)
	{
		if($id<=0)
		{
			$this->data['success'] = false;
    		$this->data['message'] = cclang('data_not_found');
			$this->data['redirect'] = base_url('administrator/fastcon_distributor');
			set_message(cclang('data_not_found'), 'warning');
		}

		$this->is_allowed('fastcon_distributor_add');

		if($data = db_get_row_data('fastcon_distributor', ['id' => $id]))
		{
			clone_this_data('fastcon_distributor', ['id' => $id]);
			$this->data['success'] = true;
    		$this->data['message'] = cclang('data_cloned');
			$this->data['redirect'] = base_url('administrator/fastcon_distributor');

			set_message(cclang('data_cloned'), 'success');
		}else{
			set_message(cclang('data_not_found'), 'warning');
		}

		redirect('administrator/fastcon_distributor');

	}

	
		/**
	* Update view Fastcon Distributors
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('fastcon_distributor_update');

		$this->data['fastcon_distributor'] = $this->model_fastcon_distributor->find($id);

		$this->template->title('Distributor Update');
		$this->render('backend/standart/administrator/fastcon_distributor/fastcon_distributor_update', $this->data);
	}

	/**
	* Update Fastcon Distributors
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('fastcon_distributor_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('distributor_province', 'Distributor Province', 'trim|required');
		$this->form_validation->set_rules('distributor_name', 'Distributor Name', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'distributor_province' => $this->input->post('distributor_province'),
				'distributor_name' => $this->input->post('distributor_name'),
			];

			
			$save_fastcon_distributor = $this->model_fastcon_distributor->change($id, $save_data);

			if ($save_fastcon_distributor) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/fastcon_distributor', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_distributor');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_distributor');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Fastcon Distributors
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('fastcon_distributor_delete');

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
            set_message(cclang('has_been_deleted', 'fastcon_distributor'), 'success');
        } else {
            set_message(cclang('error_delete', 'fastcon_distributor'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Fastcon Distributors
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('fastcon_distributor_view');

		$this->data['fastcon_distributor'] = $this->model_fastcon_distributor->join_avaiable()->find($id);

		$this->template->title('Distributor Detail');
		$this->render('backend/standart/administrator/fastcon_distributor/fastcon_distributor_view', $this->data);
	}
	
	/**
	* delete Fastcon Distributors
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$fastcon_distributor = $this->model_fastcon_distributor->find($id);

		
		
		return $this->model_fastcon_distributor->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('fastcon_distributor_export');

		$this->model_fastcon_distributor->export('fastcon_distributor', 'fastcon_distributor');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('fastcon_distributor_export');

		$this->model_fastcon_distributor->pdf('fastcon_distributor', 'fastcon_distributor');
	}
}


/* End of file fastcon_distributor.php */
/* Location: ./application/controllers/administrator/Fastcon Distributor.php */
