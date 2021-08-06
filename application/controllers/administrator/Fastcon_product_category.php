<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Fastcon Product Category Controller
*| --------------------------------------------------------------------------
*| Fastcon Product Category site
*|
*/
class Fastcon_product_category extends Admin
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_fastcon_product_category');
	}

	/**
	* show all Fastcon Product Categorys
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('fastcon_product_category_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['fastcon_product_categorys'] = $this->model_fastcon_product_category->get($filter, $field, $this->limit_page, $offset);
		$this->data['fastcon_product_category_counts'] = $this->model_fastcon_product_category->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/fastcon_product_category/index/',
			'total_rows'   => $this->model_fastcon_product_category->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);
		$this->data['datables'] = true;

		$this->template->title('Product Category List');
		$this->render('backend/standart/administrator/fastcon_product_category/fastcon_product_category_list', $this->data);
	}

	public function data_ajax()
	{
		$this->is_allowed('fastcon_product_category_list');
		$fastcon_product_categorys = $this->model_fastcon_product_category->get($_GET['search']['value'], '', $this->input->get('length'), $this->input->get('start'), 0);
		$data = array();
        $no = $this->input->get('draw');


        foreach($fastcon_product_categorys as $fastcon_product_category){
        	$button = '';
        	$row = [];

						if($this->is_allowed('fastcon_product_category_add'))
        	{
		        $button .= '<a href="'.site_url("administrator/fastcon_product_category/clone_data/" . $fastcon_product_category->category_id) .'" class="label-default mr-3"><i class="fa fa-copy"></i> '.cclang('clone').'</a>';
        	}
			
	        $button .= '<a href="'.site_url("administrator/fastcon_product_category/view/" . $fastcon_product_category->category_id).'" class="label-default mr-3"><i class="fa fa-newspaper-o" style="padding-right:3px;"></i> '.cclang("view_button").'</a>';

			        	if($this->is_allowed('fastcon_product_category_update'))
        	{
		        $button .= '<a href="'.site_url("administrator/fastcon_product_category/edit/" . $fastcon_product_category->category_id) .'" class="label-default mr-3"><i class="fa fa-edit "></i> '.cclang('update_button').'</a>';
        	}
			        	if($this->is_allowed('fastcon_product_category_delete'))
        	{
		        $button .= '<a href="javascript:void(0);" onclick="delete_this(\''.BASE_URL.'administrator/fastcon_product_category/delete/'.$fastcon_product_category->category_id.'\')" class="label-default remove-data"><i class="fa fa-close"></i>'.cclang('remove_button').'</a>';
        	}



	    	$row[] = $fastcon_product_category->category_name;

	    	$row[] = $fastcon_product_category->category_name_en;

	    
	        $row[] = $button;
	    	$data[] = $row;
        }

        $output = array(
            "draw" => $this->input->get('draw'),
            "recordsTotal" => $this->model_fastcon_product_category->count_all(),
            "recordsFiltered" => $this->model_fastcon_product_category->count_all(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	/**
	* Add new fastcon_product_categorys
	*
	*/
	public function add()
	{
		$this->is_allowed('fastcon_product_category_add');

		$this->template->title('Product Category New');
		$this->render('backend/standart/administrator/fastcon_product_category/fastcon_product_category_add', $this->data);
	}

	/**
	* Add New Fastcon Product Categorys
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('fastcon_product_category_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('category_name', 'Category Name', 'trim|required');
		$this->form_validation->set_rules('category_name_en', 'Category Name En', 'trim|required');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
				'category_name' => $this->input->post('category_name'),
				'category_name_en' => $this->input->post('category_name_en'),
			];

			
			$save_fastcon_product_category = $this->model_fastcon_product_category->store($save_data);

			if ($save_fastcon_product_category) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_fastcon_product_category;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/fastcon_product_category/edit/' . $save_fastcon_product_category, 'Edit Fastcon Product Category'),
						anchor('administrator/fastcon_product_category', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/fastcon_product_category/edit/' . $save_fastcon_product_category, 'Edit Fastcon Product Category')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_product_category');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_product_category');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	
	/**
	* Clone data Fastcon Product Category	*
	*/
	public function clone_data($id=0)
	{
		if($id<=0)
		{
			$this->data['success'] = false;
    		$this->data['message'] = cclang('data_not_found');
			$this->data['redirect'] = base_url('administrator/fastcon_product_category');
			set_message(cclang('data_not_found'), 'warning');
		}

		$this->is_allowed('fastcon_product_category_add');

		if($data = db_get_row_data('fastcon_product_category', ['category_id' => $id]))
		{
			clone_this_data('fastcon_product_category', ['category_id' => $id]);
			$this->data['success'] = true;
    		$this->data['message'] = cclang('data_cloned');
			$this->data['redirect'] = base_url('administrator/fastcon_product_category');

			set_message(cclang('data_cloned'), 'success');
		}else{
			set_message(cclang('data_not_found'), 'warning');
		}

		redirect('administrator/fastcon_product_category');

	}

	
		/**
	* Update view Fastcon Product Categorys
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('fastcon_product_category_update');

		$this->data['fastcon_product_category'] = $this->model_fastcon_product_category->find($id);

		$this->template->title('Product Category Update');
		$this->render('backend/standart/administrator/fastcon_product_category/fastcon_product_category_update', $this->data);
	}

	/**
	* Update Fastcon Product Categorys
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('fastcon_product_category_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('category_name', 'Category Name', 'trim|required');
		$this->form_validation->set_rules('category_name_en', 'Category Name En', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'category_name' => $this->input->post('category_name'),
				'category_name_en' => $this->input->post('category_name_en'),
			];

			
			$save_fastcon_product_category = $this->model_fastcon_product_category->change($id, $save_data);

			if ($save_fastcon_product_category) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/fastcon_product_category', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_product_category');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_product_category');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Fastcon Product Categorys
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('fastcon_product_category_delete');

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
            set_message(cclang('has_been_deleted', 'fastcon_product_category'), 'success');
        } else {
            set_message(cclang('error_delete', 'fastcon_product_category'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Fastcon Product Categorys
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('fastcon_product_category_view');

		$this->data['fastcon_product_category'] = $this->model_fastcon_product_category->join_avaiable()->find($id);

		$this->template->title('Product Category Detail');
		$this->render('backend/standart/administrator/fastcon_product_category/fastcon_product_category_view', $this->data);
	}
	
	/**
	* delete Fastcon Product Categorys
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$fastcon_product_category = $this->model_fastcon_product_category->find($id);

		
		
		return $this->model_fastcon_product_category->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('fastcon_product_category_export');

		$this->model_fastcon_product_category->export('fastcon_product_category', 'fastcon_product_category');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('fastcon_product_category_export');

		$this->model_fastcon_product_category->pdf('fastcon_product_category', 'fastcon_product_category');
	}
}


/* End of file fastcon_product_category.php */
/* Location: ./application/controllers/administrator/Fastcon Product Category.php */
