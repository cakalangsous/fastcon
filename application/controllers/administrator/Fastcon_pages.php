<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Fastcon Pages Controller
*| --------------------------------------------------------------------------
*| Fastcon Pages site
*|
*/
class Fastcon_pages extends Admin
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_fastcon_pages');
	}

	/**
	* show all Fastcon Pagess
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('fastcon_pages_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['fastcon_pagess'] = $this->model_fastcon_pages->get($filter, $field, $this->limit_page, $offset);
		$this->data['fastcon_pages_counts'] = $this->model_fastcon_pages->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/fastcon_pages/index/',
			'total_rows'   => $this->model_fastcon_pages->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);
		$this->data['datables'] = true;

		$this->template->title('Pages List');
		$this->render('backend/standart/administrator/fastcon_pages/fastcon_pages_list', $this->data);
	}

	public function data_ajax()
	{
		$this->is_allowed('fastcon_pages_list');
		$fastcon_pagess = $this->model_fastcon_pages->get($_GET['search']['value'], '', $this->input->get('length'), $this->input->get('start'), 0);
		$data = array();
        $no = $this->input->get('draw');


        foreach($fastcon_pagess as $fastcon_pages){
        	$button = '';
        	$row = [];

						if($this->is_allowed('fastcon_pages_add'))
        	{
		        $button .= '<a href="'.site_url("administrator/fastcon_pages/clone_data/" . $fastcon_pages->id) .'" class="label-default mr-3"><i class="fa fa-copy"></i> '.cclang('clone').'</a>';
        	}
			
	        $button .= '<a href="'.site_url("administrator/fastcon_pages/view/" . $fastcon_pages->id).'" class="label-default mr-3"><i class="fa fa-newspaper-o" style="padding-right:3px;"></i> '.cclang("view_button").'</a>';

			        	if($this->is_allowed('fastcon_pages_update'))
        	{
		        $button .= '<a href="'.site_url("administrator/fastcon_pages/edit/" . $fastcon_pages->id) .'" class="label-default mr-3"><i class="fa fa-edit "></i> '.cclang('update_button').'</a>';
        	}
			        	if($this->is_allowed('fastcon_pages_delete'))
        	{
		        $button .= '<a href="javascript:void(0);" onclick="delete_this(\''.BASE_URL.'administrator/fastcon_pages/delete/'.$fastcon_pages->id.'\')" class="label-default remove-data"><i class="fa fa-close"></i>'.cclang('remove_button').'</a>';
        	}



	    	$row[] = $fastcon_pages->slug;

	    	$row[] = $fastcon_pages->title;

	    	$row[] = $fastcon_pages->title_en;

	    	$row[] = $fastcon_pages->meta_title;

	    	$row[] = $fastcon_pages->meta_description;

	    	$row[] = $fastcon_pages->content;

	    	$row[] = $fastcon_pages->content_en;

	    	$row[] = $fastcon_pages->show_in_footer;

	    	$row[] = $fastcon_pages->publish;

	    	$row[] = $fastcon_pages->created_at;

	    
	        $row[] = $button;
	    	$data[] = $row;
        }

        $output = array(
            "draw" => $this->input->get('draw'),
            "recordsTotal" => $this->model_fastcon_pages->count_all(),
            "recordsFiltered" => $this->model_fastcon_pages->count_all(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	/**
	* Add new fastcon_pagess
	*
	*/
	public function add()
	{
		$this->is_allowed('fastcon_pages_add');

		$this->template->title('Pages New');
		$this->render('backend/standart/administrator/fastcon_pages/fastcon_pages_add', $this->data);
	}

	/**
	* Add New Fastcon Pagess
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('fastcon_pages_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('slug', 'Slug', 'trim|required');
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('title_en', 'Title En', 'trim|required');
		$this->form_validation->set_rules('meta_title', 'Meta Title', 'trim|required');
		$this->form_validation->set_rules('meta_description', 'Meta Description', 'trim|required');
		$this->form_validation->set_rules('content', 'Content', 'trim|required');
		$this->form_validation->set_rules('content_en', 'Content En', 'trim|required');
		$this->form_validation->set_rules('show_in_footer', 'Show In Footer', 'trim|required');
		$this->form_validation->set_rules('publish', 'Publish', 'trim|required');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
				'slug' => $this->input->post('slug'),
				'title' => $this->input->post('title'),
				'title_en' => $this->input->post('title_en'),
				'meta_title' => $this->input->post('meta_title'),
				'meta_description' => $this->input->post('meta_description'),
				'content' => $this->input->post('content'),
				'content_en' => $this->input->post('content_en'),
				'show_in_footer' => $this->input->post('show_in_footer'),
				'publish' => $this->input->post('publish'),
			];

			
			$save_fastcon_pages = $this->model_fastcon_pages->store($save_data);

			if ($save_fastcon_pages) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_fastcon_pages;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/fastcon_pages/edit/' . $save_fastcon_pages, 'Edit Fastcon Pages'),
						anchor('administrator/fastcon_pages', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/fastcon_pages/edit/' . $save_fastcon_pages, 'Edit Fastcon Pages')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_pages');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_pages');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	
	/**
	* Clone data Fastcon Pages	*
	*/
	public function clone_data($id=0)
	{
		if($id<=0)
		{
			$this->data['success'] = false;
    		$this->data['message'] = cclang('data_not_found');
			$this->data['redirect'] = base_url('administrator/fastcon_pages');
			set_message(cclang('data_not_found'), 'warning');
		}

		$this->is_allowed('fastcon_pages_add');

		if($data = db_get_row_data('fastcon_pages', ['id' => $id]))
		{
			clone_this_data('fastcon_pages', ['id' => $id]);
			$this->data['success'] = true;
    		$this->data['message'] = cclang('data_cloned');
			$this->data['redirect'] = base_url('administrator/fastcon_pages');

			set_message(cclang('data_cloned'), 'success');
		}else{
			set_message(cclang('data_not_found'), 'warning');
		}

		redirect('administrator/fastcon_pages');

	}

	
		/**
	* Update view Fastcon Pagess
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('fastcon_pages_update');

		$this->data['fastcon_pages'] = $this->model_fastcon_pages->find($id);

		$this->template->title('Pages Update');
		$this->render('backend/standart/administrator/fastcon_pages/fastcon_pages_update', $this->data);
	}

	/**
	* Update Fastcon Pagess
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('fastcon_pages_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('slug', 'Slug', 'trim|required');
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('title_en', 'Title En', 'trim|required');
		$this->form_validation->set_rules('meta_title', 'Meta Title', 'trim|required');
		$this->form_validation->set_rules('meta_description', 'Meta Description', 'trim|required');
		$this->form_validation->set_rules('content', 'Content', 'trim|required');
		$this->form_validation->set_rules('content_en', 'Content En', 'trim|required');
		$this->form_validation->set_rules('show_in_footer', 'Show In Footer', 'trim|required');
		$this->form_validation->set_rules('publish', 'Publish', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'slug' => $this->input->post('slug'),
				'title' => $this->input->post('title'),
				'title_en' => $this->input->post('title_en'),
				'meta_title' => $this->input->post('meta_title'),
				'meta_description' => $this->input->post('meta_description'),
				'content' => $this->input->post('content'),
				'content_en' => $this->input->post('content_en'),
				'show_in_footer' => $this->input->post('show_in_footer'),
				'publish' => $this->input->post('publish'),
			];

			
			$save_fastcon_pages = $this->model_fastcon_pages->change($id, $save_data);

			if ($save_fastcon_pages) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/fastcon_pages', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_pages');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_pages');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Fastcon Pagess
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('fastcon_pages_delete');

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
            set_message(cclang('has_been_deleted', 'fastcon_pages'), 'success');
        } else {
            set_message(cclang('error_delete', 'fastcon_pages'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Fastcon Pagess
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('fastcon_pages_view');

		$this->data['fastcon_pages'] = $this->model_fastcon_pages->join_avaiable()->find($id);

		$this->template->title('Pages Detail');
		$this->render('backend/standart/administrator/fastcon_pages/fastcon_pages_view', $this->data);
	}
	
	/**
	* delete Fastcon Pagess
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$fastcon_pages = $this->model_fastcon_pages->find($id);

		
		
		return $this->model_fastcon_pages->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('fastcon_pages_export');

		$this->model_fastcon_pages->export('fastcon_pages', 'fastcon_pages');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('fastcon_pages_export');

		$this->model_fastcon_pages->pdf('fastcon_pages', 'fastcon_pages');
	}
}


/* End of file fastcon_pages.php */
/* Location: ./application/controllers/administrator/Fastcon Pages.php */
