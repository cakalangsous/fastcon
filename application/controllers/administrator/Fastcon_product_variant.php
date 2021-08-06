<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Fastcon Product Variant Controller
*| --------------------------------------------------------------------------
*| Fastcon Product Variant site
*|
*/
class Fastcon_product_variant extends Admin
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_fastcon_product_variant');
	}

	/**
	* show all Fastcon Product Variants
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('fastcon_product_variant_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['fastcon_product_variants'] = $this->model_fastcon_product_variant->get($filter, $field, $this->limit_page, $offset);
		$this->data['fastcon_product_variant_counts'] = $this->model_fastcon_product_variant->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/fastcon_product_variant/index/',
			'total_rows'   => $this->model_fastcon_product_variant->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);
		$this->data['datables'] = true;

		$this->template->title('Product Variant List');
		$this->render('backend/standart/administrator/fastcon_product_variant/fastcon_product_variant_list', $this->data);
	}

	public function data_ajax()
	{
		$this->is_allowed('fastcon_product_variant_list');
		$fastcon_product_variants = $this->model_fastcon_product_variant->get($_GET['search']['value'], '', $this->input->get('length'), $this->input->get('start'), 0);
		$data = array();
        $no = $this->input->get('draw');


        foreach($fastcon_product_variants as $fastcon_product_variant){
        	$button = '';
        	$row = [];

			
	        $button .= '<a href="'.site_url("administrator/fastcon_product_variant/view/" . $fastcon_product_variant->variant_id).'" class="label-default mr-3"><i class="fa fa-newspaper-o" style="padding-right:3px;"></i> '.cclang("view_button").'</a>';

			        	if($this->is_allowed('fastcon_product_variant_update'))
        	{
		        $button .= '<a href="'.site_url("administrator/fastcon_product_variant/edit/" . $fastcon_product_variant->variant_id) .'" class="label-default mr-3"><i class="fa fa-edit "></i> '.cclang('update_button').'</a>';
        	}
			        	if($this->is_allowed('fastcon_product_variant_delete'))
        	{
		        $button .= '<a href="javascript:void(0);" onclick="delete_this(\''.BASE_URL.'administrator/fastcon_product_variant/delete/'.$fastcon_product_variant->variant_id.'\')" class="label-default remove-data"><i class="fa fa-close"></i>'.cclang('remove_button').'</a>';
        	}



	    			$row[] = $fastcon_product_variant->sku;
	    			$row[] = $fastcon_product_variant->product_option_name;
	    			$row[] = $fastcon_product_variant->option_value;
	    
	        $row[] = $button;
	    	$data[] = $row;
        }

        $output = array(
            "draw" => $this->input->get('draw'),
            "recordsTotal" => $this->model_fastcon_product_variant->count_all(),
            "recordsFiltered" => $this->model_fastcon_product_variant->count_all(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	/**
	* Add new fastcon_product_variants
	*
	*/
	public function add()
	{
		$this->is_allowed('fastcon_product_variant_add');

		$this->template->title('Product Variant New');
		$this->render('backend/standart/administrator/fastcon_product_variant/fastcon_product_variant_add', $this->data);
	}

	/**
	* Add New Fastcon Product Variants
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('fastcon_product_variant_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('sku_id', 'Sku Id', 'trim|required');
		$this->form_validation->set_rules('product_option_id', 'Product Option Id', 'trim|required');
		$this->form_validation->set_rules('product_option_value_id', 'Product Option Value Id', 'trim|required');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
				'sku_id' => $this->input->post('sku_id'),
				'product_option_id' => $this->input->post('product_option_id'),
				'product_option_value_id' => $this->input->post('product_option_value_id'),
			];

			
			$save_fastcon_product_variant = $this->model_fastcon_product_variant->store($save_data);

			if ($save_fastcon_product_variant) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_fastcon_product_variant;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/fastcon_product_variant/edit/' . $save_fastcon_product_variant, 'Edit Fastcon Product Variant'),
						anchor('administrator/fastcon_product_variant', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/fastcon_product_variant/edit/' . $save_fastcon_product_variant, 'Edit Fastcon Product Variant')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_product_variant');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_product_variant');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	
		/**
	* Update view Fastcon Product Variants
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('fastcon_product_variant_update');

		$this->data['fastcon_product_variant'] = $this->model_fastcon_product_variant->find($id);

		$this->template->title('Product Variant Update');
		$this->render('backend/standart/administrator/fastcon_product_variant/fastcon_product_variant_update', $this->data);
	}

	/**
	* Update Fastcon Product Variants
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('fastcon_product_variant_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('sku_id', 'Sku Id', 'trim|required');
		$this->form_validation->set_rules('product_option_id', 'Product Option Id', 'trim|required');
		$this->form_validation->set_rules('product_option_value_id', 'Product Option Value Id', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'sku_id' => $this->input->post('sku_id'),
				'product_option_id' => $this->input->post('product_option_id'),
				'product_option_value_id' => $this->input->post('product_option_value_id'),
			];

			
			$save_fastcon_product_variant = $this->model_fastcon_product_variant->change($id, $save_data);

			if ($save_fastcon_product_variant) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/fastcon_product_variant', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_product_variant');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_product_variant');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Fastcon Product Variants
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('fastcon_product_variant_delete');

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
            set_message(cclang('has_been_deleted', 'fastcon_product_variant'), 'success');
        } else {
            set_message(cclang('error_delete', 'fastcon_product_variant'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Fastcon Product Variants
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('fastcon_product_variant_view');

		$this->data['fastcon_product_variant'] = $this->model_fastcon_product_variant->join_avaiable()->find($id);

		$this->template->title('Product Variant Detail');
		$this->render('backend/standart/administrator/fastcon_product_variant/fastcon_product_variant_view', $this->data);
	}
	
	/**
	* delete Fastcon Product Variants
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$fastcon_product_variant = $this->model_fastcon_product_variant->find($id);

		
		
		return $this->model_fastcon_product_variant->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('fastcon_product_variant_export');

		$this->model_fastcon_product_variant->export('fastcon_product_variant', 'fastcon_product_variant');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('fastcon_product_variant_export');

		$this->model_fastcon_product_variant->pdf('fastcon_product_variant', 'fastcon_product_variant');
	}
}


/* End of file fastcon_product_variant.php */
/* Location: ./application/controllers/administrator/Fastcon Product Variant.php */
