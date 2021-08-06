<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Fastcon Product Sku Controller
*| --------------------------------------------------------------------------
*| Fastcon Product Sku site
*|
*/
class Fastcon_product_sku extends Admin
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_fastcon_product_sku');
	}

	/**
	* show all Fastcon Product Skus
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('fastcon_product_sku_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['fastcon_product_skus'] = $this->model_fastcon_product_sku->get($filter, $field, $this->limit_page, $offset);
		$this->data['fastcon_product_sku_counts'] = $this->model_fastcon_product_sku->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/fastcon_product_sku/index/',
			'total_rows'   => $this->model_fastcon_product_sku->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);
		$this->data['datables'] = true;

		$this->template->title('Product Sku List');
		$this->render('backend/standart/administrator/fastcon_product_sku/fastcon_product_sku_list', $this->data);
	}

	public function data_ajax()
	{
		$this->is_allowed('fastcon_product_sku_list');
		$fastcon_product_skus = $this->model_fastcon_product_sku->get($_GET['search']['value'], '', $this->input->get('length'), $this->input->get('start'), 0);
		$data = array();
        $no = $this->input->get('draw');


        foreach($fastcon_product_skus as $fastcon_product_sku){
        	$button = '';
        	$row = [];

						if($this->is_allowed('fastcon_product_sku_add'))
        	{
		        $button .= '<a href="'.site_url("administrator/fastcon_product_sku/clone_data/" . $fastcon_product_sku->sku_id) .'" class="label-default mr-3"><i class="fa fa-copy"></i> '.cclang('clone').'</a>';
        	}
			
	        $button .= '<a href="'.site_url("administrator/fastcon_product_sku/view/" . $fastcon_product_sku->sku_id).'" class="label-default mr-3"><i class="fa fa-newspaper-o" style="padding-right:3px;"></i> '.cclang("view_button").'</a>';

			        	if($this->is_allowed('fastcon_product_sku_update'))
        	{
		        $button .= '<a href="'.site_url("administrator/fastcon_product_sku/edit/" . $fastcon_product_sku->sku_id) .'" class="label-default mr-3"><i class="fa fa-edit "></i> '.cclang('update_button').'</a>';
        	}
			        	if($this->is_allowed('fastcon_product_sku_delete'))
        	{
		        $button .= '<a href="javascript:void(0);" onclick="delete_this(\''.BASE_URL.'administrator/fastcon_product_sku/delete/'.$fastcon_product_sku->sku_id.'\')" class="label-default remove-data"><i class="fa fa-close"></i>'.cclang('remove_button').'</a>';
        	}



	    			$row[] = $fastcon_product_sku->product_name;
	    	$row[] = $fastcon_product_sku->sku;

	    	$row[] = $fastcon_product_sku->price;

	    	$row[] = $fastcon_product_sku->discount;

	    
	        $row[] = $button;
	    	$data[] = $row;
        }

        $output = array(
            "draw" => $this->input->get('draw'),
            "recordsTotal" => $this->model_fastcon_product_sku->count_all(),
            "recordsFiltered" => $this->model_fastcon_product_sku->count_all(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	/**
	* Add new fastcon_product_skus
	*
	*/
	public function add()
	{
		$this->is_allowed('fastcon_product_sku_add');

		$this->template->title('Product Sku New');
		$this->render('backend/standart/administrator/fastcon_product_sku/fastcon_product_sku_add', $this->data);
	}

	/**
	* Add New Fastcon Product Skus
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('fastcon_product_sku_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('product_id', 'Product Id', 'trim|required');
		$this->form_validation->set_rules('sku', 'Sku', 'trim|required');
		$this->form_validation->set_rules('price', 'Price', 'trim|required');
		$this->form_validation->set_rules('discount', 'Discount', 'trim|required');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
				'product_id' => $this->input->post('product_id'),
				'sku' => $this->input->post('sku'),
				'price' => $this->input->post('price'),
				'discount' => $this->input->post('discount'),
			];

			
			$save_fastcon_product_sku = $this->model_fastcon_product_sku->store($save_data);

			if ($save_fastcon_product_sku) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_fastcon_product_sku;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/fastcon_product_sku/edit/' . $save_fastcon_product_sku, 'Edit Fastcon Product Sku'),
						anchor('administrator/fastcon_product_sku', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/fastcon_product_sku/edit/' . $save_fastcon_product_sku, 'Edit Fastcon Product Sku')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_product_sku');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_product_sku');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	
	/**
	* Clone data Fastcon Product Sku	*
	*/
	public function clone_data($id=0)
	{
		if($id<=0)
		{
			$this->data['success'] = false;
    		$this->data['message'] = cclang('data_not_found');
			$this->data['redirect'] = base_url('administrator/fastcon_product_sku');
			set_message(cclang('data_not_found'), 'warning');
		}

		$this->is_allowed('fastcon_product_sku_add');

		if($data = db_get_row_data('fastcon_product_sku', ['sku_id' => $id]))
		{
			clone_this_data('fastcon_product_sku', ['sku_id' => $id]);
			$this->data['success'] = true;
    		$this->data['message'] = cclang('data_cloned');
			$this->data['redirect'] = base_url('administrator/fastcon_product_sku');

			set_message(cclang('data_cloned'), 'success');
		}else{
			set_message(cclang('data_not_found'), 'warning');
		}

		redirect('administrator/fastcon_product_sku');

	}

	
		/**
	* Update view Fastcon Product Skus
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('fastcon_product_sku_update');

		$this->data['fastcon_product_sku'] = $this->model_fastcon_product_sku->find($id);

		$this->template->title('Product Sku Update');
		$this->render('backend/standart/administrator/fastcon_product_sku/fastcon_product_sku_update', $this->data);
	}

	/**
	* Update Fastcon Product Skus
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('fastcon_product_sku_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('product_id', 'Product Id', 'trim|required');
		$this->form_validation->set_rules('sku', 'Sku', 'trim|required');
		$this->form_validation->set_rules('price', 'Price', 'trim|required');
		$this->form_validation->set_rules('discount', 'Discount', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'product_id' => $this->input->post('product_id'),
				'sku' => $this->input->post('sku'),
				'price' => $this->input->post('price'),
				'discount' => $this->input->post('discount'),
			];

			
			$save_fastcon_product_sku = $this->model_fastcon_product_sku->change($id, $save_data);

			if ($save_fastcon_product_sku) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/fastcon_product_sku', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_product_sku');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_product_sku');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Fastcon Product Skus
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('fastcon_product_sku_delete');

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
            set_message(cclang('has_been_deleted', 'fastcon_product_sku'), 'success');
        } else {
            set_message(cclang('error_delete', 'fastcon_product_sku'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Fastcon Product Skus
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('fastcon_product_sku_view');

		$this->data['fastcon_product_sku'] = $this->model_fastcon_product_sku->join_avaiable()->find($id);

		$this->template->title('Product Sku Detail');
		$this->render('backend/standart/administrator/fastcon_product_sku/fastcon_product_sku_view', $this->data);
	}
	
	/**
	* delete Fastcon Product Skus
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$fastcon_product_sku = $this->model_fastcon_product_sku->find($id);

		
		
		return $this->model_fastcon_product_sku->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('fastcon_product_sku_export');

		$this->model_fastcon_product_sku->export('fastcon_product_sku', 'fastcon_product_sku');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('fastcon_product_sku_export');

		$this->model_fastcon_product_sku->pdf('fastcon_product_sku', 'fastcon_product_sku');
	}
}


/* End of file fastcon_product_sku.php */
/* Location: ./application/controllers/administrator/Fastcon Product Sku.php */
