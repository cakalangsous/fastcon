<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Fastcon Product Option Value Controller
*| --------------------------------------------------------------------------
*| Fastcon Product Option Value site
*|
*/
class Fastcon_product_option_value extends Admin
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_fastcon_product_option_value');
	}

	/**
	* show all Fastcon Product Option Values
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('fastcon_product_option_value_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['fastcon_product_option_values'] = $this->model_fastcon_product_option_value->get($filter, $field, $this->limit_page, $offset);
		$this->data['fastcon_product_option_value_counts'] = $this->model_fastcon_product_option_value->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/fastcon_product_option_value/index/',
			'total_rows'   => $this->model_fastcon_product_option_value->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);
		$this->data['datables'] = true;

		$this->template->title('Product Option Value List');
		$this->render('backend/standart/administrator/fastcon_product_option_value/fastcon_product_option_value_list', $this->data);
	}

	public function data_ajax()
	{
		$this->is_allowed('fastcon_product_option_value_list');
		$fastcon_product_option_values = $this->model_fastcon_product_option_value->get($_GET['search']['value'], '', $this->input->get('length'), $this->input->get('start'), 0);
		$data = array();
        $no = $this->input->get('draw');


        foreach($fastcon_product_option_values as $fastcon_product_option_value){
        	$button = '';
        	$row = [];

						if($this->is_allowed('fastcon_product_option_value_add'))
        	{
		        $button .= '<a href="'.site_url("administrator/fastcon_product_option_value/clone_data/" . $fastcon_product_option_value->option_value_id) .'" class="label-default mr-3"><i class="fa fa-copy"></i> '.cclang('clone').'</a>';
        	}
			
	        $button .= '<a href="'.site_url("administrator/fastcon_product_option_value/view/" . $fastcon_product_option_value->option_value_id).'" class="label-default mr-3"><i class="fa fa-newspaper-o" style="padding-right:3px;"></i> '.cclang("view_button").'</a>';

			        	if($this->is_allowed('fastcon_product_option_value_update'))
        	{
		        $button .= '<a href="'.site_url("administrator/fastcon_product_option_value/edit/" . $fastcon_product_option_value->option_value_id) .'" class="label-default mr-3"><i class="fa fa-edit "></i> '.cclang('update_button').'</a>';
        	}
			        	if($this->is_allowed('fastcon_product_option_value_delete'))
        	{
		        $button .= '<a href="javascript:void(0);" onclick="delete_this(\''.BASE_URL.'administrator/fastcon_product_option_value/delete/'.$fastcon_product_option_value->option_value_id.'\')" class="label-default remove-data"><i class="fa fa-close"></i>'.cclang('remove_button').'</a>';
        	}



	    			$row[] = $fastcon_product_option_value->product_option_name;
	    	$row[] = $fastcon_product_option_value->option_value;

	    
	        $row[] = $button;
	    	$data[] = $row;
        }

        $output = array(
            "draw" => $this->input->get('draw'),
            "recordsTotal" => $this->model_fastcon_product_option_value->count_all(),
            "recordsFiltered" => $this->model_fastcon_product_option_value->count_all(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	/**
	* Add new fastcon_product_option_values
	*
	*/
	public function add()
	{
		$this->is_allowed('fastcon_product_option_value_add');

		$this->template->title('Product Option Value New');
		$this->render('backend/standart/administrator/fastcon_product_option_value/fastcon_product_option_value_add', $this->data);
	}

	/**
	* Add New Fastcon Product Option Values
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('fastcon_product_option_value_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('product_option_id', 'Product Option Id', 'trim|required');
		$this->form_validation->set_rules('option_value', 'Option Value', 'trim|required');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
				'product_option_id' => $this->input->post('product_option_id'),
				'option_value' => $this->input->post('option_value'),
			];

			
			$save_fastcon_product_option_value = $this->model_fastcon_product_option_value->store($save_data);

			if ($save_fastcon_product_option_value) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_fastcon_product_option_value;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/fastcon_product_option_value/edit/' . $save_fastcon_product_option_value, 'Edit Fastcon Product Option Value'),
						anchor('administrator/fastcon_product_option_value', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/fastcon_product_option_value/edit/' . $save_fastcon_product_option_value, 'Edit Fastcon Product Option Value')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_product_option_value');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_product_option_value');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	
	/**
	* Clone data Fastcon Product Option Value	*
	*/
	public function clone_data($id=0)
	{
		if($id<=0)
		{
			$this->data['success'] = false;
    		$this->data['message'] = cclang('data_not_found');
			$this->data['redirect'] = base_url('administrator/fastcon_product_option_value');
			set_message(cclang('data_not_found'), 'warning');
		}

		$this->is_allowed('fastcon_product_option_value_add');

		if($data = db_get_row_data('fastcon_product_option_value', ['option_value_id' => $id]))
		{
			clone_this_data('fastcon_product_option_value', ['option_value_id' => $id]);
			$this->data['success'] = true;
    		$this->data['message'] = cclang('data_cloned');
			$this->data['redirect'] = base_url('administrator/fastcon_product_option_value');

			set_message(cclang('data_cloned'), 'success');
		}else{
			set_message(cclang('data_not_found'), 'warning');
		}

		redirect('administrator/fastcon_product_option_value');

	}

	
		/**
	* Update view Fastcon Product Option Values
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('fastcon_product_option_value_update');

		$this->data['fastcon_product_option_value'] = $this->model_fastcon_product_option_value->find($id);

		$this->template->title('Product Option Value Update');
		$this->render('backend/standart/administrator/fastcon_product_option_value/fastcon_product_option_value_update', $this->data);
	}

	/**
	* Update Fastcon Product Option Values
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('fastcon_product_option_value_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('product_option_id', 'Product Option Id', 'trim|required');
		$this->form_validation->set_rules('option_value', 'Option Value', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'product_option_id' => $this->input->post('product_option_id'),
				'option_value' => $this->input->post('option_value'),
			];

			
			$save_fastcon_product_option_value = $this->model_fastcon_product_option_value->change($id, $save_data);

			if ($save_fastcon_product_option_value) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/fastcon_product_option_value', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_product_option_value');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_product_option_value');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Fastcon Product Option Values
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('fastcon_product_option_value_delete');

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
            set_message(cclang('has_been_deleted', 'fastcon_product_option_value'), 'success');
        } else {
            set_message(cclang('error_delete', 'fastcon_product_option_value'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Fastcon Product Option Values
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('fastcon_product_option_value_view');

		$this->data['fastcon_product_option_value'] = $this->model_fastcon_product_option_value->join_avaiable()->find($id);

		$this->template->title('Product Option Value Detail');
		$this->render('backend/standart/administrator/fastcon_product_option_value/fastcon_product_option_value_view', $this->data);
	}
	
	/**
	* delete Fastcon Product Option Values
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$fastcon_product_option_value = $this->model_fastcon_product_option_value->find($id);

		
		
		return $this->model_fastcon_product_option_value->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('fastcon_product_option_value_export');

		$this->model_fastcon_product_option_value->export('fastcon_product_option_value', 'fastcon_product_option_value');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('fastcon_product_option_value_export');

		$this->model_fastcon_product_option_value->pdf('fastcon_product_option_value', 'fastcon_product_option_value');
	}
}


/* End of file fastcon_product_option_value.php */
/* Location: ./application/controllers/administrator/Fastcon Product Option Value.php */
