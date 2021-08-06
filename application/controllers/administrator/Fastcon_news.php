<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Fastcon News Controller
*| --------------------------------------------------------------------------
*| Fastcon News site
*|
*/
class Fastcon_news extends Admin
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_fastcon_news');
	}

	/**
	* show all Fastcon Newss
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('fastcon_news_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['fastcon_newss'] = $this->model_fastcon_news->get($filter, $field, $this->limit_page, $offset);
		$this->data['fastcon_news_counts'] = $this->model_fastcon_news->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/fastcon_news/index/',
			'total_rows'   => $this->model_fastcon_news->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);
		$this->data['datables'] = true;

		$this->template->title('News List');
		$this->render('backend/standart/administrator/fastcon_news/fastcon_news_list', $this->data);
	}

	public function data_ajax()
	{
		$this->is_allowed('fastcon_news_list');
		$fastcon_newss = $this->model_fastcon_news->get($_GET['search']['value'], '', $this->input->get('length'), $this->input->get('start'), 0);
		$data = array();
        $no = $this->input->get('draw');


        foreach($fastcon_newss as $fastcon_news){
        	$button = '';
        	$row = [];

			
	        $button .= '<a href="'.site_url("administrator/fastcon_news/view/" . $fastcon_news->id).'" class="label-default mr-3"><i class="fa fa-newspaper-o" style="padding-right:3px;"></i> '.cclang("view_button").'</a>';

			        	if($this->is_allowed('fastcon_news_update'))
        	{
		        $button .= '<a href="'.site_url("administrator/fastcon_news/edit/" . $fastcon_news->id) .'" class="label-default mr-3"><i class="fa fa-edit "></i> '.cclang('update_button').'</a>';
        	}
			        	if($this->is_allowed('fastcon_news_delete'))
        	{
		        $button .= '<a href="javascript:void(0);" onclick="delete_this(\''.BASE_URL.'administrator/fastcon_news/delete/'.$fastcon_news->id.'\')" class="label-default remove-data"><i class="fa fa-close"></i>'.cclang('remove_button').'</a>';
        	}



	    	if (!empty($fastcon_news->image)){
                if (is_image($fastcon_news->image)){
	                $row[] = '<a class="fancybox" rel="group" href="'.BASE_URL . 'uploads/fastcon_news/'. $fastcon_news->image.'">
	                            <img src="'.BASE_URL . 'uploads/fastcon_news/' . $fastcon_news->image.'" class="image-responsive" alt="image fastcon_news" title="image fastcon_news" width="40px">
	                        </a>';
                }else{
	                $row[] =  '<a href="'.BASE_URL . 'administrator/file/download/fastcon_news/' . $fastcon_news->image.'">
	                       <img src="'.get_icon_file($fastcon_news->image).'" class="image-responsive image-icon" alt="image fastcon_news" title="image fastcon_news" width="40px">
	                     </a>';
                }
            }else{
				$row[] = null;
			}
	    	$row[] = $fastcon_news->title;

	    	$row[] = $fastcon_news->title_en;

	    	$row[] = $fastcon_news->slug;

	    	$row[] = $fastcon_news->content;

	    	$row[] = $fastcon_news->content_en;

	    	$row[] = $fastcon_news->created_at;

	    
	        $row[] = $button;
	    	$data[] = $row;
        }

        $output = array(
            "draw" => $this->input->get('draw'),
            "recordsTotal" => $this->model_fastcon_news->count_all(),
            "recordsFiltered" => $this->model_fastcon_news->count_all(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	/**
	* Add new fastcon_newss
	*
	*/
	public function add()
	{
		$this->is_allowed('fastcon_news_add');

		$this->template->title('News New');
		$this->render('backend/standart/administrator/fastcon_news/fastcon_news_add', $this->data);
	}

	/**
	* Add New Fastcon Newss
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('fastcon_news_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('fastcon_news_image_name', 'Image', 'trim|required');
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('title_en', 'Title En', 'trim|required');
		$this->form_validation->set_rules('slug', 'Slug', 'trim|required');
		$this->form_validation->set_rules('content', 'Content', 'trim|required');
		$this->form_validation->set_rules('content_en', 'Content En', 'trim|required');
		

		if ($this->form_validation->run()) {
			$fastcon_news_image_uuid = $this->input->post('fastcon_news_image_uuid');
			$fastcon_news_image_name = $this->input->post('fastcon_news_image_name');
		
			$save_data = [
				'title' => $this->input->post('title'),
				'title_en' => $this->input->post('title_en'),
				'slug' => $this->input->post('slug'),
				'content' => $this->input->post('content'),
				'content_en' => $this->input->post('content_en'),
			];

			if (!is_dir(FCPATH . '/uploads/fastcon_news/')) {
				mkdir(FCPATH . '/uploads/fastcon_news/');
			}

			if (!empty($fastcon_news_image_name)) {
				$fastcon_news_image_name_copy = date('YmdHis') . '-' . $fastcon_news_image_name;

				rename(FCPATH . 'uploads/tmp/' . $fastcon_news_image_uuid . '/' . $fastcon_news_image_name,
						FCPATH . 'uploads/fastcon_news/' . $fastcon_news_image_name_copy);

				if (!is_file(FCPATH . '/uploads/fastcon_news/' . $fastcon_news_image_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['image'] = $fastcon_news_image_name_copy;
			}
		
			
			$save_fastcon_news = $this->model_fastcon_news->store($save_data);

			if ($save_fastcon_news) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_fastcon_news;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/fastcon_news/edit/' . $save_fastcon_news, 'Edit Fastcon News'),
						anchor('administrator/fastcon_news', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/fastcon_news/edit/' . $save_fastcon_news, 'Edit Fastcon News')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_news');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_news');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	
		/**
	* Update view Fastcon Newss
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('fastcon_news_update');

		$this->data['fastcon_news'] = $this->model_fastcon_news->find($id);

		$this->template->title('News Update');
		$this->render('backend/standart/administrator/fastcon_news/fastcon_news_update', $this->data);
	}

	/**
	* Update Fastcon Newss
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('fastcon_news_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('fastcon_news_image_name', 'Image', 'trim|required');
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('title_en', 'Title En', 'trim|required');
		$this->form_validation->set_rules('slug', 'Slug', 'trim|required');
		$this->form_validation->set_rules('content', 'Content', 'trim|required');
		$this->form_validation->set_rules('content_en', 'Content En', 'trim|required');
		
		if ($this->form_validation->run()) {
			$fastcon_news_image_uuid = $this->input->post('fastcon_news_image_uuid');
			$fastcon_news_image_name = $this->input->post('fastcon_news_image_name');
		
			$save_data = [
				'title' => $this->input->post('title'),
				'title_en' => $this->input->post('title_en'),
				'slug' => $this->input->post('slug'),
				'content' => $this->input->post('content'),
				'content_en' => $this->input->post('content_en'),
			];

			if (!is_dir(FCPATH . '/uploads/fastcon_news/')) {
				mkdir(FCPATH . '/uploads/fastcon_news/');
			}

			if (!empty($fastcon_news_image_uuid)) {
				$fastcon_news_image_name_copy = date('YmdHis') . '-' . $fastcon_news_image_name;

				rename(FCPATH . 'uploads/tmp/' . $fastcon_news_image_uuid . '/' . $fastcon_news_image_name,
						FCPATH . 'uploads/fastcon_news/' . $fastcon_news_image_name_copy);

				if (!is_file(FCPATH . '/uploads/fastcon_news/' . $fastcon_news_image_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['image'] = $fastcon_news_image_name_copy;
			}
		
			
			$save_fastcon_news = $this->model_fastcon_news->change($id, $save_data);

			if ($save_fastcon_news) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/fastcon_news', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_news');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_news');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Fastcon Newss
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('fastcon_news_delete');

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
            set_message(cclang('has_been_deleted', 'fastcon_news'), 'success');
        } else {
            set_message(cclang('error_delete', 'fastcon_news'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Fastcon Newss
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('fastcon_news_view');

		$this->data['fastcon_news'] = $this->model_fastcon_news->join_avaiable()->find($id);

		$this->template->title('News Detail');
		$this->render('backend/standart/administrator/fastcon_news/fastcon_news_view', $this->data);
	}
	
	/**
	* delete Fastcon Newss
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$fastcon_news = $this->model_fastcon_news->find($id);

		if (!empty($fastcon_news->image)) {
			$path = FCPATH . '/uploads/fastcon_news/' . $fastcon_news->image;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}
		
		
		return $this->model_fastcon_news->remove($id);
	}
	
	/**
	* Upload Image Fastcon News	*
	* @return JSON
	*/
	public function upload_image_file()
	{
		if (!$this->is_allowed('fastcon_news_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'fastcon_news',
			'allowed_types' => 'jpg|jpeg|png',
		]);
	}

	/**
	* Delete Image Fastcon News	*
	* @return JSON
	*/
	public function delete_image_file($uuid)
	{
		if (!$this->is_allowed('fastcon_news_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid,
            'delete_by'         => $this->input->get('by'),
            'field_name'        => 'image',
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'fastcon_news',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/fastcon_news/'
        ]);
	}

	/**
	* Get Image Fastcon News	*
	* @return JSON
	*/
	public function get_image_file($id)
	{
		if (!$this->is_allowed('fastcon_news_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$fastcon_news = $this->model_fastcon_news->find($id);

		echo $this->get_file([
            'uuid'              => $id,
            'delete_by'         => 'id',
            'field_name'        => 'image',
            'table_name'        => 'fastcon_news',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/fastcon_news/',
            'delete_endpoint'   => 'administrator/fastcon_news/delete_image_file'
        ]);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('fastcon_news_export');

		$this->model_fastcon_news->export('fastcon_news', 'fastcon_news');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('fastcon_news_export');

		$this->model_fastcon_news->pdf('fastcon_news', 'fastcon_news');
	}
}


/* End of file fastcon_news.php */
/* Location: ./application/controllers/administrator/Fastcon News.php */
