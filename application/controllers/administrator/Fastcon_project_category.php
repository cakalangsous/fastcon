<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Fastcon Project Category Controller
*| --------------------------------------------------------------------------
*| Fastcon Project Category site
*|
*/
class Fastcon_project_category extends Admin
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_fastcon_project_category');
	}

	/**
	* show all Fastcon Project Categorys
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('fastcon_project_category_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['fastcon_project_categorys'] = $this->model_fastcon_project_category->get($filter, $field, $this->limit_page, $offset);
		$this->data['fastcon_project_category_counts'] = $this->model_fastcon_project_category->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/fastcon_project_category/index/',
			'total_rows'   => $this->model_fastcon_project_category->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);
		$this->data['datables'] = true;

		$this->template->title('Project Category List');
		$this->render('backend/standart/administrator/fastcon_project_category/fastcon_project_category_list', $this->data);
	}

	public function data_ajax()
	{
		$this->is_allowed('fastcon_project_category_list');
		$fastcon_project_categorys = $this->model_fastcon_project_category->get($_GET['search']['value'], '', $this->input->get('length'), $this->input->get('start'), 0);
		$data = array();
        $no = $this->input->get('draw');


        foreach($fastcon_project_categorys as $fastcon_project_category){
        	$button = '';
        	$row = [];

						if($this->is_allowed('fastcon_project_category_add'))
        	{
		        $button .= '<a href="'.site_url("administrator/fastcon_project_category/clone_data/" . $fastcon_project_category->category_id) .'" class="label-default mr-3"><i class="fa fa-copy"></i> '.cclang('clone').'</a>';
        	}
			
	        $button .= '<a href="'.site_url("administrator/fastcon_project_category/view/" . $fastcon_project_category->category_id).'" class="label-default mr-3"><i class="fa fa-newspaper-o" style="padding-right:3px;"></i> '.cclang("view_button").'</a>';

			        	if($this->is_allowed('fastcon_project_category_update'))
        	{
		        $button .= '<a href="'.site_url("administrator/fastcon_project_category/edit/" . $fastcon_project_category->category_id) .'" class="label-default mr-3"><i class="fa fa-edit "></i> '.cclang('update_button').'</a>';
        	}
			        	if($this->is_allowed('fastcon_project_category_delete'))
        	{
		        $button .= '<a href="javascript:void(0);" onclick="delete_this(\''.BASE_URL.'administrator/fastcon_project_category/delete/'.$fastcon_project_category->category_id.'\')" class="label-default remove-data"><i class="fa fa-close"></i>'.cclang('remove_button').'</a>';
        	}



	    	$row[] = $fastcon_project_category->category_name;

	    	$row[] = $fastcon_project_category->category_name_en;

	    
	        $row[] = $button;
	    	$data[] = $row;
        }

        $output = array(
            "draw" => $this->input->get('draw'),
            "recordsTotal" => $this->model_fastcon_project_category->count_all(),
            "recordsFiltered" => $this->model_fastcon_project_category->count_all(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	/**
	* Add new fastcon_project_categorys
	*
	*/
	public function add()
	{
		$this->is_allowed('fastcon_project_category_add');

		$this->template->title('Project Category New');
		$this->render('backend/standart/administrator/fastcon_project_category/fastcon_project_category_add', $this->data);
	}

	/**
	* Add New Fastcon Project Categorys
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('fastcon_project_category_add', false)) {
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

			
			$save_fastcon_project_category = $this->model_fastcon_project_category->store($save_data);

			if ($save_fastcon_project_category) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_fastcon_project_category;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/fastcon_project_category/edit/' . $save_fastcon_project_category, 'Edit Fastcon Project Category'),
						anchor('administrator/fastcon_project_category', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/fastcon_project_category/edit/' . $save_fastcon_project_category, 'Edit Fastcon Project Category')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_project_category');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_project_category');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	
	/**
	* Clone data Fastcon Project Category	*
	*/
	public function clone_data($id=0)
	{
		if($id<=0)
		{
			$this->data['success'] = false;
    		$this->data['message'] = cclang('data_not_found');
			$this->data['redirect'] = base_url('administrator/fastcon_project_category');
			set_message(cclang('data_not_found'), 'warning');
		}

		$this->is_allowed('fastcon_project_category_add');

		if($data = db_get_row_data('fastcon_project_category', ['category_id' => $id]))
		{
			clone_this_data('fastcon_project_category', ['category_id' => $id]);
			$this->data['success'] = true;
    		$this->data['message'] = cclang('data_cloned');
			$this->data['redirect'] = base_url('administrator/fastcon_project_category');

			set_message(cclang('data_cloned'), 'success');
		}else{
			set_message(cclang('data_not_found'), 'warning');
		}

		redirect('administrator/fastcon_project_category');

	}

	
		/**
	* Update view Fastcon Project Categorys
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('fastcon_project_category_update');

		$this->data['fastcon_project_category'] = $this->model_fastcon_project_category->find($id);

		$this->template->title('Project Category Update');
		$this->render('backend/standart/administrator/fastcon_project_category/fastcon_project_category_update', $this->data);
	}

	/**
	* Update Fastcon Project Categorys
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('fastcon_project_category_update', false)) {
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

			
			$save_fastcon_project_category = $this->model_fastcon_project_category->change($id, $save_data);

			if ($save_fastcon_project_category) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/fastcon_project_category', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_project_category');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_project_category');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Fastcon Project Categorys
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('fastcon_project_category_delete');

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
            set_message(cclang('has_been_deleted', 'fastcon_project_category'), 'success');
        } else {
            set_message(cclang('error_delete', 'fastcon_project_category'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Fastcon Project Categorys
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('fastcon_project_category_view');

		$this->data['fastcon_project_category'] = $this->model_fastcon_project_category->join_avaiable()->find($id);

		$this->template->title('Project Category Detail');
		$this->render('backend/standart/administrator/fastcon_project_category/fastcon_project_category_view', $this->data);
	}
	
	/**
	* delete Fastcon Project Categorys
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$fastcon_project_category = $this->model_fastcon_project_category->find($id);

		
		
		return $this->model_fastcon_project_category->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('fastcon_project_category_export');

		$this->model_fastcon_project_category->export('fastcon_project_category', 'fastcon_project_category');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('fastcon_project_category_export');

		$this->model_fastcon_project_category->pdf('fastcon_project_category', 'fastcon_project_category');
	}
}


/* End of file fastcon_project_category.php */
/* Location: ./application/controllers/administrator/Fastcon Project Category.php */
