<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Fastcon Product Option Controller
*| --------------------------------------------------------------------------
*| Fastcon Product Option site
*|
*/
class Fastcon_product_option extends Admin
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_fastcon_product_option');
	}

	/**
	* show all Fastcon Product Options
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('fastcon_product_option_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['fastcon_product_options'] = $this->model_fastcon_product_option->get($filter, $field, $this->limit_page, $offset);
		$this->data['fastcon_product_option_counts'] = $this->model_fastcon_product_option->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/fastcon_product_option/index/',
			'total_rows'   => $this->model_fastcon_product_option->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);
		$this->data['datables'] = true;

		$this->template->title('Product Option List');
		$this->render('backend/standart/administrator/fastcon_product_option/fastcon_product_option_list', $this->data);
	}

	public function data_ajax()
	{
		$this->is_allowed('fastcon_product_option_list');
		$fastcon_product_options = $this->model_fastcon_product_option->get($_GET['search']['value'], '', $this->input->get('length'), $this->input->get('start'), 0);
		$data = array();
        $no = $this->input->get('draw');


        foreach($fastcon_product_options as $fastcon_product_option){
        	$button = '';
        	$row = [];

						if($this->is_allowed('fastcon_product_option_add'))
        	{
		        $button .= '<a href="'.site_url("administrator/fastcon_product_option/clone_data/" . $fastcon_product_option->product_type_id) .'" class="label-default mr-3"><i class="fa fa-copy"></i> '.cclang('clone').'</a>';
        	}
			
	        $button .= '<a href="'.site_url("administrator/fastcon_product_option/view/" . $fastcon_product_option->product_type_id).'" class="label-default mr-3"><i class="fa fa-newspaper-o" style="padding-right:3px;"></i> '.cclang("view_button").'</a>';

			        	if($this->is_allowed('fastcon_product_option_update'))
        	{
		        $button .= '<a href="'.site_url("administrator/fastcon_product_option/edit/" . $fastcon_product_option->product_type_id) .'" class="label-default mr-3"><i class="fa fa-edit "></i> '.cclang('update_button').'</a>';
        	}
			        	if($this->is_allowed('fastcon_product_option_delete'))
        	{
		        $button .= '<a href="javascript:void(0);" onclick="delete_this(\''.BASE_URL.'administrator/fastcon_product_option/delete/'.$fastcon_product_option->product_type_id.'\')" class="label-default remove-data"><i class="fa fa-close"></i>'.cclang('remove_button').'</a>';
        	}



	    	$row[] = $fastcon_product_option->product_option_name;

	    	$row[] = $fastcon_product_option->product_option_name_en;

	    
	        $row[] = $button;
	    	$data[] = $row;
        }

        $output = array(
            "draw" => $this->input->get('draw'),
            "recordsTotal" => $this->model_fastcon_product_option->count_all(),
            "recordsFiltered" => $this->model_fastcon_product_option->count_all(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	/**
	* Add new fastcon_product_options
	*
	*/
	public function add()
	{
		$this->is_allowed('fastcon_product_option_add');

		$this->template->title('Product Option New');
		$this->render('backend/standart/administrator/fastcon_product_option/fastcon_product_option_add', $this->data);
	}

	/**
	* Add New Fastcon Product Options
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('fastcon_product_option_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('product_option_name', 'Product Option Name', 'trim|required');
		$this->form_validation->set_rules('product_option_name_en', 'Product Option Name En', 'trim|required');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
				'product_option_name' => $this->input->post('product_option_name'),
				'product_option_name_en' => $this->input->post('product_option_name_en'),
			];

			
			$save_fastcon_product_option = $this->model_fastcon_product_option->store($save_data);

			if ($save_fastcon_product_option) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_fastcon_product_option;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/fastcon_product_option/edit/' . $save_fastcon_product_option, 'Edit Fastcon Product Option'),
						anchor('administrator/fastcon_product_option', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/fastcon_product_option/edit/' . $save_fastcon_product_option, 'Edit Fastcon Product Option')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_product_option');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_product_option');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	
	/**
	* Clone data Fastcon Product Option	*
	*/
	public function clone_data($id=0)
	{
		if($id<=0)
		{
			$this->data['success'] = false;
    		$this->data['message'] = cclang('data_not_found');
			$this->data['redirect'] = base_url('administrator/fastcon_product_option');
			set_message(cclang('data_not_found'), 'warning');
		}

		$this->is_allowed('fastcon_product_option_add');

		if($data = db_get_row_data('fastcon_product_option', ['product_type_id' => $id]))
		{
			clone_this_data('fastcon_product_option', ['product_type_id' => $id]);
			$this->data['success'] = true;
    		$this->data['message'] = cclang('data_cloned');
			$this->data['redirect'] = base_url('administrator/fastcon_product_option');

			set_message(cclang('data_cloned'), 'success');
		}else{
			set_message(cclang('data_not_found'), 'warning');
		}

		redirect('administrator/fastcon_product_option');

	}

	
		/**
	* Update view Fastcon Product Options
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('fastcon_product_option_update');

		$this->data['fastcon_product_option'] = $this->model_fastcon_product_option->find($id);

		$this->template->title('Product Option Update');
		$this->render('backend/standart/administrator/fastcon_product_option/fastcon_product_option_update', $this->data);
	}

	/**
	* Update Fastcon Product Options
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('fastcon_product_option_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('product_option_name', 'Product Option Name', 'trim|required');
		$this->form_validation->set_rules('product_option_name_en', 'Product Option Name En', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'product_option_name' => $this->input->post('product_option_name'),
				'product_option_name_en' => $this->input->post('product_option_name_en'),
			];

			
			$save_fastcon_product_option = $this->model_fastcon_product_option->change($id, $save_data);

			if ($save_fastcon_product_option) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/fastcon_product_option', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_product_option');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_product_option');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Fastcon Product Options
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('fastcon_product_option_delete');

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
            set_message(cclang('has_been_deleted', 'fastcon_product_option'), 'success');
        } else {
            set_message(cclang('error_delete', 'fastcon_product_option'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Fastcon Product Options
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('fastcon_product_option_view');

		$this->data['fastcon_product_option'] = $this->model_fastcon_product_option->join_avaiable()->find($id);

		$this->template->title('Product Option Detail');
		$this->render('backend/standart/administrator/fastcon_product_option/fastcon_product_option_view', $this->data);
	}
	
	/**
	* delete Fastcon Product Options
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$fastcon_product_option = $this->model_fastcon_product_option->find($id);

		
		
		return $this->model_fastcon_product_option->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('fastcon_product_option_export');

		$this->model_fastcon_product_option->export('fastcon_product_option', 'fastcon_product_option');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('fastcon_product_option_export');

		$this->model_fastcon_product_option->pdf('fastcon_product_option', 'fastcon_product_option');
	}
}


/* End of file fastcon_product_option.php */
/* Location: ./application/controllers/administrator/Fastcon Product Option.php */
