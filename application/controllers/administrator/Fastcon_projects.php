<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Fastcon Projects Controller
*| --------------------------------------------------------------------------
*| Fastcon Projects site
*|
*/
class Fastcon_projects extends Admin
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_fastcon_projects');
	}

	/**
	* show all Fastcon Projectss
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('fastcon_projects_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['fastcon_projectss'] = $this->model_fastcon_projects->get($filter, $field, $this->limit_page, $offset);
		$this->data['fastcon_projects_counts'] = $this->model_fastcon_projects->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/fastcon_projects/index/',
			'total_rows'   => $this->model_fastcon_projects->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);
		$this->data['datables'] = true;

		$this->template->title('Projects List');
		$this->render('backend/standart/administrator/fastcon_projects/fastcon_projects_list', $this->data);
	}

	public function data_ajax()
	{
		$this->is_allowed('fastcon_projects_list');
		$fastcon_projectss = $this->model_fastcon_projects->get($_GET['search']['value'], '', $this->input->get('length'), $this->input->get('start'), 0);
		$data = array();
        $no = $this->input->get('draw');


        foreach($fastcon_projectss as $fastcon_projects){
        	$button = '';
        	$row = [];

			
	        $button .= '<a href="'.site_url("administrator/fastcon_projects/view/" . $fastcon_projects->id).'" class="label-default mr-3"><i class="fa fa-newspaper-o" style="padding-right:3px;"></i> '.cclang("view_button").'</a>';

			        	if($this->is_allowed('fastcon_projects_update'))
        	{
		        $button .= '<a href="'.site_url("administrator/fastcon_projects/edit/" . $fastcon_projects->id) .'" class="label-default mr-3"><i class="fa fa-edit "></i> '.cclang('update_button').'</a>';
        	}
			        	if($this->is_allowed('fastcon_projects_delete'))
        	{
		        $button .= '<a href="javascript:void(0);" onclick="delete_this(\''.BASE_URL.'administrator/fastcon_projects/delete/'.$fastcon_projects->id.'\')" class="label-default remove-data"><i class="fa fa-close"></i>'.cclang('remove_button').'</a>';
        	}



	    			$row[] = $fastcon_projects->category_name;
	    	$file_fastcon_projects = '';
			foreach (explode(',', $fastcon_projects->images) as $file){
            	if (!empty($file)){
                	if (is_image($file)){
		                $file_fastcon_projects .= '<a class="fancybox" rel="group" href="'.BASE_URL . 'uploads/fastcon_projects/' . $file.'">
        		                  <img src="'.BASE_URL.'uploads/fastcon_projects/'. $file.'" class="image-responsive" alt="image fastcon_projects" title="'.$file.'" width="40px">
		                </a>';
	                }else{
	                	$file_fastcon_projects .= '<a href="'.BASE_URL . 'administrator/file/download/fastcon_projects/'. $file.'">
    		                		<img src="'.get_icon_file($file).'" class="image-responsive image-icon" alt="image fastcon_projects" title="'.$file.'" width="40px">
    		                	</a>';
	                }
	            }
            }
            $row[] = $file_fastcon_projects;
	    	$row[] = $fastcon_projects->title;

	    	$row[] = $fastcon_projects->title_en;

	    	$row[] = $fastcon_projects->slug;

	    	$row[] = $fastcon_projects->short_desc;

	    	$row[] = $fastcon_projects->short_desc_en;

	    	$row[] = substr(strip_tags($fastcon_projects->content), 0, 200);

	    	$row[] = substr(strip_tags($fastcon_projects->content_en), 0, 200);

	    	$row[] = $fastcon_projects->featured;

	    	$row[] = $fastcon_projects->created_at;

	    
	        $row[] = $button;
	    	$data[] = $row;
        }

        $output = array(
            "draw" => $this->input->get('draw'),
            "recordsTotal" => $this->model_fastcon_projects->count_all(),
            "recordsFiltered" => $this->model_fastcon_projects->count_all(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	/**
	* Add new fastcon_projectss
	*
	*/
	public function add()
	{
		$this->is_allowed('fastcon_projects_add');

		$this->template->title('Projects New');
		$this->render('backend/standart/administrator/fastcon_projects/fastcon_projects_add', $this->data);
	}

	/**
	* Add New Fastcon Projectss
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('fastcon_projects_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('category', 'Category', 'trim|required');
		$this->form_validation->set_rules('fastcon_projects_images_name[]', 'Images', 'trim|required');
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('title_en', 'Title En', 'trim|required');
		$this->form_validation->set_rules('slug', 'Slug', 'trim|required');
		$this->form_validation->set_rules('short_desc', 'Short Desc', 'trim|required');
		$this->form_validation->set_rules('short_desc_en', 'Short Desc En', 'trim|required');
		$this->form_validation->set_rules('content', 'Content', 'trim|required');
		$this->form_validation->set_rules('content_en', 'Content En', 'trim|required');
		$this->form_validation->set_rules('featured', 'Featured', 'trim|required');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
				'category' => $this->input->post('category'),
				'title' => $this->input->post('title'),
				'title_en' => $this->input->post('title_en'),
				'slug' => $this->input->post('slug'),
				'short_desc' => $this->input->post('short_desc'),
				'short_desc_en' => $this->input->post('short_desc_en'),
				'content' => $this->input->post('content'),
				'content_en' => $this->input->post('content_en'),
				'featured' => $this->input->post('featured'),
			];

			if (!is_dir(FCPATH . '/uploads/fastcon_projects/')) {
				mkdir(FCPATH . '/uploads/fastcon_projects/');
			}

			if (count((array) $this->input->post('fastcon_projects_images_name'))) {
				foreach ((array) $_POST['fastcon_projects_images_name'] as $idx => $file_name) {
					$fastcon_projects_images_name_copy = date('YmdHis') . '-' . $file_name;

					rename(FCPATH . 'uploads/tmp/' . $_POST['fastcon_projects_images_uuid'][$idx] . '/' .  $file_name,
							FCPATH . 'uploads/fastcon_projects/' . $fastcon_projects_images_name_copy);

					$listed_image[] = $fastcon_projects_images_name_copy;

					if (!is_file(FCPATH . '/uploads/fastcon_projects/' . $fastcon_projects_images_name_copy)) {
						echo json_encode([
							'success' => false,
							'message' => 'Error uploading file'
							]);
						exit;
					}
				}

				$save_data['images'] = implode($listed_image, ',');
			}
		
			
			$save_fastcon_projects = $this->model_fastcon_projects->store($save_data);

			if ($save_fastcon_projects) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_fastcon_projects;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/fastcon_projects/edit/' . $save_fastcon_projects, 'Edit Fastcon Projects'),
						anchor('administrator/fastcon_projects', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/fastcon_projects/edit/' . $save_fastcon_projects, 'Edit Fastcon Projects')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_projects');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_projects');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	
		/**
	* Update view Fastcon Projectss
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('fastcon_projects_update');

		$this->data['fastcon_projects'] = $this->model_fastcon_projects->find($id);

		$this->template->title('Projects Update');
		$this->render('backend/standart/administrator/fastcon_projects/fastcon_projects_update', $this->data);
	}

	/**
	* Update Fastcon Projectss
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('fastcon_projects_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('category', 'Category', 'trim|required');
		$this->form_validation->set_rules('fastcon_projects_images_name[]', 'Images', 'trim|required');
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('title_en', 'Title En', 'trim|required');
		$this->form_validation->set_rules('slug', 'Slug', 'trim|required');
		$this->form_validation->set_rules('short_desc', 'Short Desc', 'trim|required');
		$this->form_validation->set_rules('short_desc_en', 'Short Desc En', 'trim|required');
		$this->form_validation->set_rules('content', 'Content', 'trim|required');
		$this->form_validation->set_rules('content_en', 'Content En', 'trim|required');
		$this->form_validation->set_rules('featured', 'Featured', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'category' => $this->input->post('category'),
				'title' => $this->input->post('title'),
				'title_en' => $this->input->post('title_en'),
				'slug' => $this->input->post('slug'),
				'short_desc' => $this->input->post('short_desc'),
				'short_desc_en' => $this->input->post('short_desc_en'),
				'content' => $this->input->post('content'),
				'content_en' => $this->input->post('content_en'),
				'featured' => $this->input->post('featured'),
			];

			$listed_image = [];
			if (count((array) $this->input->post('fastcon_projects_images_name'))) {
				foreach ((array) $_POST['fastcon_projects_images_name'] as $idx => $file_name) {
					if (isset($_POST['fastcon_projects_images_uuid'][$idx]) AND !empty($_POST['fastcon_projects_images_uuid'][$idx])) {
						$fastcon_projects_images_name_copy = date('YmdHis') . '-' . $file_name;

						rename(FCPATH . 'uploads/tmp/' . $_POST['fastcon_projects_images_uuid'][$idx] . '/' .  $file_name,
								FCPATH . 'uploads/fastcon_projects/' . $fastcon_projects_images_name_copy);

						$listed_image[] = $fastcon_projects_images_name_copy;

						if (!is_file(FCPATH . '/uploads/fastcon_projects/' . $fastcon_projects_images_name_copy)) {
							echo json_encode([
								'success' => false,
								'message' => 'Error uploading file'
								]);
							exit;
						}
					} else {
						$listed_image[] = $file_name;
					}
				}
			}
			
			$save_data['images'] = implode($listed_image, ',');
		
			
			$save_fastcon_projects = $this->model_fastcon_projects->change($id, $save_data);

			if ($save_fastcon_projects) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/fastcon_projects', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_projects');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_projects');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Fastcon Projectss
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('fastcon_projects_delete');

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
            set_message(cclang('has_been_deleted', 'fastcon_projects'), 'success');
        } else {
            set_message(cclang('error_delete', 'fastcon_projects'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Fastcon Projectss
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('fastcon_projects_view');

		$this->data['fastcon_projects'] = $this->model_fastcon_projects->join_avaiable()->find($id);

		$this->template->title('Projects Detail');
		$this->render('backend/standart/administrator/fastcon_projects/fastcon_projects_view', $this->data);
	}
	
	/**
	* delete Fastcon Projectss
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$fastcon_projects = $this->model_fastcon_projects->find($id);

		
		if (!empty($fastcon_projects->images)) {
			foreach ((array) explode(',', $fastcon_projects->images) as $filename) {
				$path = FCPATH . '/uploads/fastcon_projects/' . $filename;

				if (is_file($path)) {
					$delete_file = unlink($path);
				}
			}
		}
		
		return $this->model_fastcon_projects->remove($id);
	}
	
	
	/**
	* Upload Image Fastcon Projects	*
	* @return JSON
	*/
	public function upload_images_file()
	{
		if (!$this->is_allowed('fastcon_projects_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'fastcon_projects',
			'allowed_types' => 'jpg|jpeg|png',
		]);
	}

	/**
	* Delete Image Fastcon Projects	*
	* @return JSON
	*/
	public function delete_images_file($uuid)
	{
		if (!$this->is_allowed('fastcon_projects_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid,
            'delete_by'         => $this->input->get('by'),
            'field_name'        => 'images',
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'fastcon_projects',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/fastcon_projects/'
        ]);
	}

	/**
	* Get Image Fastcon Projects	*
	* @return JSON
	*/
	public function get_images_file($id)
	{
		if (!$this->is_allowed('fastcon_projects_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$fastcon_projects = $this->model_fastcon_projects->find($id);

		echo $this->get_file([
            'uuid'              => $id,
            'delete_by'         => 'id',
            'field_name'        => 'images',
            'table_name'        => 'fastcon_projects',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/fastcon_projects/',
            'delete_endpoint'   => 'administrator/fastcon_projects/delete_images_file'
        ]);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('fastcon_projects_export');

		$this->model_fastcon_projects->export('fastcon_projects', 'fastcon_projects');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('fastcon_projects_export');

		$this->model_fastcon_projects->pdf('fastcon_projects', 'fastcon_projects');
	}
}


/* End of file fastcon_projects.php */
/* Location: ./application/controllers/administrator/Fastcon Projects.php */
