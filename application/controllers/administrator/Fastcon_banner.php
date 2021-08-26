<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Fastcon Banner Controller
*| --------------------------------------------------------------------------
*| Fastcon Banner site
*|
*/
class Fastcon_banner extends Admin
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_fastcon_banner');
	}

	/**
	* show all Fastcon Banners
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('fastcon_banner_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['fastcon_banners'] = $this->model_fastcon_banner->get($filter, $field, $this->limit_page, $offset);
		$this->data['fastcon_banner_counts'] = $this->model_fastcon_banner->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/fastcon_banner/index/',
			'total_rows'   => $this->model_fastcon_banner->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);
		$this->data['datables'] = true;

		$this->template->title('Banner List');
		$this->render('backend/standart/administrator/fastcon_banner/fastcon_banner_list', $this->data);
	}

	public function data_ajax()
	{
		$this->is_allowed('fastcon_banner_list');
		$fastcon_banners = $this->model_fastcon_banner->get($_GET['search']['value'], '', $this->input->get('length'), $this->input->get('start'), 0);
		$data = array();
        $no = $this->input->get('draw');


        foreach($fastcon_banners as $fastcon_banner){
        	$button = '';
        	$row = [];

			
	        $button .= '<a href="'.site_url("administrator/fastcon_banner/view/" . $fastcon_banner->id).'" class="label-default mr-3"><i class="fa fa-newspaper-o" style="padding-right:3px;"></i> '.cclang("view_button").'</a>';

			        	if($this->is_allowed('fastcon_banner_update'))
        	{
		        $button .= '<a href="'.site_url("administrator/fastcon_banner/edit/" . $fastcon_banner->id) .'" class="label-default mr-3"><i class="fa fa-edit "></i> '.cclang('update_button').'</a>';
        	}



	    	if (!empty($fastcon_banner->bg_img)){
                if (is_image($fastcon_banner->bg_img)){
	                $row[] = '<a class="fancybox" rel="group" href="'.BASE_URL . 'uploads/fastcon_banner/'. $fastcon_banner->bg_img.'">
	                            <img src="'.BASE_URL . 'uploads/fastcon_banner/' . $fastcon_banner->bg_img.'" class="image-responsive" alt="image fastcon_banner" title="bg_img fastcon_banner" width="40px">
	                        </a>';
                }else{
	                $row[] =  '<a href="'.BASE_URL . 'administrator/file/download/fastcon_banner/' . $fastcon_banner->bg_img.'">
	                       <img src="'.get_icon_file($fastcon_banner->bg_img).'" class="image-responsive image-icon" alt="image fastcon_banner" title="bg_img fastcon_banner" width="40px">
	                     </a>';
                }
            }else{
				$row[] = null;
			}
	    	if (!empty($fastcon_banner->fg_img)){
                if (is_image($fastcon_banner->fg_img)){
	                $row[] = '<a class="fancybox" rel="group" href="'.BASE_URL . 'uploads/fastcon_banner/'. $fastcon_banner->fg_img.'">
	                            <img src="'.BASE_URL . 'uploads/fastcon_banner/' . $fastcon_banner->fg_img.'" class="image-responsive" alt="image fastcon_banner" title="fg_img fastcon_banner" width="40px">
	                        </a>';
                }else{
	                $row[] =  '<a href="'.BASE_URL . 'administrator/file/download/fastcon_banner/' . $fastcon_banner->fg_img.'">
	                       <img src="'.get_icon_file($fastcon_banner->fg_img).'" class="image-responsive image-icon" alt="image fastcon_banner" title="fg_img fastcon_banner" width="40px">
	                     </a>';
                }
            }else{
				$row[] = null;
			}
	    	$row[] = $fastcon_banner->title;

	    	$row[] = $fastcon_banner->title_en;

	    	$row[] = $fastcon_banner->caption;

	    	$row[] = $fastcon_banner->caption_en;

	    	$row[] = $fastcon_banner->primary_btn;

	    	$row[] = $fastcon_banner->primary_btn_en;

	    	$row[] = $fastcon_banner->primary_btn_link;

	    	$row[] = $fastcon_banner->secondary_btn;

	    	$row[] = $fastcon_banner->secondary_btn_en;

	    	$row[] = $fastcon_banner->secondary_btn_link;

	    
	        $row[] = $button;
	    	$data[] = $row;
        }

        $output = array(
            "draw" => $this->input->get('draw'),
            "recordsTotal" => $this->model_fastcon_banner->count_all(),
            "recordsFiltered" => $this->model_fastcon_banner->count_all(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	
	
		/**
	* Update view Fastcon Banners
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('fastcon_banner_update');

		$this->data['fastcon_banner'] = $this->model_fastcon_banner->find($id);

		$this->template->title('Banner Update');
		$this->render('backend/standart/administrator/fastcon_banner/fastcon_banner_update', $this->data);
	}

	/**
	* Update Fastcon Banners
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('fastcon_banner_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('fastcon_banner_bg_img_name', 'Bg Img', 'trim|required');
		$this->form_validation->set_rules('fastcon_banner_fg_img_name', 'Fg Img', 'trim|required');
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('title_en', 'Title En', 'trim|required');
		$this->form_validation->set_rules('caption', 'Caption', 'trim|required');
		$this->form_validation->set_rules('caption_en', 'Caption En', 'trim|required');
		$this->form_validation->set_rules('primary_btn', 'Primary Btn', 'trim|required');
		$this->form_validation->set_rules('primary_btn_en', 'Primary Btn En', 'trim|required');
		$this->form_validation->set_rules('primary_btn_link', 'Primary Btn Link', 'trim|required');
		
		if ($this->form_validation->run()) {
			$fastcon_banner_bg_img_uuid = $this->input->post('fastcon_banner_bg_img_uuid');
			$fastcon_banner_bg_img_name = $this->input->post('fastcon_banner_bg_img_name');
			$fastcon_banner_fg_img_uuid = $this->input->post('fastcon_banner_fg_img_uuid');
			$fastcon_banner_fg_img_name = $this->input->post('fastcon_banner_fg_img_name');
		
			$save_data = [
				'title' => $this->input->post('title'),
				'title_en' => $this->input->post('title_en'),
				'caption' => $this->input->post('caption'),
				'caption_en' => $this->input->post('caption_en'),
				'primary_btn' => $this->input->post('primary_btn'),
				'primary_btn_en' => $this->input->post('primary_btn_en'),
				'primary_btn_link' => $this->input->post('primary_btn_link'),
				'secondary_btn' => $this->input->post('secondary_btn'),
				'secondary_btn_en' => $this->input->post('secondary_btn_en'),
				'secondary_btn_link' => $this->input->post('secondary_btn_link'),
			];

			if (!is_dir(FCPATH . '/uploads/fastcon_banner/')) {
				mkdir(FCPATH . '/uploads/fastcon_banner/');
			}

			if (!empty($fastcon_banner_bg_img_uuid)) {
				$fastcon_banner_bg_img_name_copy = date('YmdHis') . '-' . $fastcon_banner_bg_img_name;

				rename(FCPATH . 'uploads/tmp/' . $fastcon_banner_bg_img_uuid . '/' . $fastcon_banner_bg_img_name,
						FCPATH . 'uploads/fastcon_banner/' . $fastcon_banner_bg_img_name_copy);

				if (!is_file(FCPATH . '/uploads/fastcon_banner/' . $fastcon_banner_bg_img_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['bg_img'] = $fastcon_banner_bg_img_name_copy;
			}
		
			if (!empty($fastcon_banner_fg_img_uuid)) {
				$fastcon_banner_fg_img_name_copy = date('YmdHis') . '-' . $fastcon_banner_fg_img_name;

				rename(FCPATH . 'uploads/tmp/' . $fastcon_banner_fg_img_uuid . '/' . $fastcon_banner_fg_img_name,
						FCPATH . 'uploads/fastcon_banner/' . $fastcon_banner_fg_img_name_copy);

				if (!is_file(FCPATH . '/uploads/fastcon_banner/' . $fastcon_banner_fg_img_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['fg_img'] = $fastcon_banner_fg_img_name_copy;
			}
		
			
			$save_fastcon_banner = $this->model_fastcon_banner->change($id, $save_data);

			if ($save_fastcon_banner) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/fastcon_banner', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_banner');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_banner');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Fastcon Banners
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('fastcon_banner_delete');

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
            set_message(cclang('has_been_deleted', 'fastcon_banner'), 'success');
        } else {
            set_message(cclang('error_delete', 'fastcon_banner'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Fastcon Banners
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('fastcon_banner_view');

		$this->data['fastcon_banner'] = $this->model_fastcon_banner->join_avaiable()->find($id);

		$this->template->title('Banner Detail');
		$this->render('backend/standart/administrator/fastcon_banner/fastcon_banner_view', $this->data);
	}
	
	/**
	* delete Fastcon Banners
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$fastcon_banner = $this->model_fastcon_banner->find($id);

		if (!empty($fastcon_banner->bg_img)) {
			$path = FCPATH . '/uploads/fastcon_banner/' . $fastcon_banner->bg_img;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}
		if (!empty($fastcon_banner->fg_img)) {
			$path = FCPATH . '/uploads/fastcon_banner/' . $fastcon_banner->fg_img;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}
		
		
		return $this->model_fastcon_banner->remove($id);
	}
	
	/**
	* Upload Image Fastcon Banner	*
	* @return JSON
	*/
	public function upload_bg_img_file()
	{
		if (!$this->is_allowed('fastcon_banner_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'fastcon_banner',
			'allowed_types' => 'jpg|png|jpeg',
		]);
	}

	/**
	* Delete Image Fastcon Banner	*
	* @return JSON
	*/
	public function delete_bg_img_file($uuid)
	{
		if (!$this->is_allowed('fastcon_banner_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid,
            'delete_by'         => $this->input->get('by'),
            'field_name'        => 'bg_img',
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'fastcon_banner',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/fastcon_banner/'
        ]);
	}

	/**
	* Get Image Fastcon Banner	*
	* @return JSON
	*/
	public function get_bg_img_file($id)
	{
		if (!$this->is_allowed('fastcon_banner_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$fastcon_banner = $this->model_fastcon_banner->find($id);

		echo $this->get_file([
            'uuid'              => $id,
            'delete_by'         => 'id',
            'field_name'        => 'bg_img',
            'table_name'        => 'fastcon_banner',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/fastcon_banner/',
            'delete_endpoint'   => 'administrator/fastcon_banner/delete_bg_img_file'
        ]);
	}
	
	/**
	* Upload Image Fastcon Banner	*
	* @return JSON
	*/
	public function upload_fg_img_file()
	{
		if (!$this->is_allowed('fastcon_banner_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'fastcon_banner',
			'allowed_types' => 'png',
		]);
	}

	/**
	* Delete Image Fastcon Banner	*
	* @return JSON
	*/
	public function delete_fg_img_file($uuid)
	{
		if (!$this->is_allowed('fastcon_banner_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid,
            'delete_by'         => $this->input->get('by'),
            'field_name'        => 'fg_img',
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'fastcon_banner',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/fastcon_banner/'
        ]);
	}

	/**
	* Get Image Fastcon Banner	*
	* @return JSON
	*/
	public function get_fg_img_file($id)
	{
		if (!$this->is_allowed('fastcon_banner_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$fastcon_banner = $this->model_fastcon_banner->find($id);

		echo $this->get_file([
            'uuid'              => $id,
            'delete_by'         => 'id',
            'field_name'        => 'fg_img',
            'table_name'        => 'fastcon_banner',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/fastcon_banner/',
            'delete_endpoint'   => 'administrator/fastcon_banner/delete_fg_img_file'
        ]);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('fastcon_banner_export');

		$this->model_fastcon_banner->export('fastcon_banner', 'fastcon_banner');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('fastcon_banner_export');

		$this->model_fastcon_banner->pdf('fastcon_banner', 'fastcon_banner');
	}
}


/* End of file fastcon_banner.php */
/* Location: ./application/controllers/administrator/Fastcon Banner.php */
