<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Fastcon Benefits Controller
*| --------------------------------------------------------------------------
*| Fastcon Benefits site
*|
*/
class Fastcon_benefits extends Admin
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_fastcon_benefits');
	}

	/**
	* show all Fastcon Benefitss
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('fastcon_benefits_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['fastcon_benefitss'] = $this->model_fastcon_benefits->get($filter, $field, $this->limit_page, $offset);
		$this->data['fastcon_benefits_counts'] = $this->model_fastcon_benefits->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/fastcon_benefits/index/',
			'total_rows'   => $this->model_fastcon_benefits->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);
		$this->data['datables'] = true;

		$this->template->title('Benefits List');
		$this->render('backend/standart/administrator/fastcon_benefits/fastcon_benefits_list', $this->data);
	}

	public function data_ajax()
	{
		$this->is_allowed('fastcon_benefits_list');
		$fastcon_benefitss = $this->model_fastcon_benefits->get($_GET['search']['value'], '', $this->input->get('length'), $this->input->get('start'), 0);
		$data = array();
        $no = $this->input->get('draw');


        foreach($fastcon_benefitss as $fastcon_benefits){
        	$button = '';
        	$row = [];

			
	        $button .= '<a href="'.site_url("administrator/fastcon_benefits/view/" . $fastcon_benefits->id).'" class="label-default mr-3"><i class="fa fa-newspaper-o" style="padding-right:3px;"></i> '.cclang("view_button").'</a>';

			        	if($this->is_allowed('fastcon_benefits_update'))
        	{
		        $button .= '<a href="'.site_url("administrator/fastcon_benefits/edit/" . $fastcon_benefits->id) .'" class="label-default mr-3"><i class="fa fa-edit "></i> '.cclang('update_button').'</a>';
        	}
			      //   	if($this->is_allowed('fastcon_benefits_delete'))
        	// {
		       //  $button .= '<a href="javascript:void(0);" onclick="delete_this(\''.BASE_URL.'administrator/fastcon_benefits/delete/'.$fastcon_benefits->id.'\')" class="label-default remove-data"><i class="fa fa-close"></i>'.cclang('remove_button').'</a>';
        	// }



	    	if (!empty($fastcon_benefits->image)){
                if (is_image($fastcon_benefits->image)){
	                $row[] = '<a class="fancybox" rel="group" href="'.BASE_URL . 'uploads/fastcon_benefits/'. $fastcon_benefits->image.'">
	                            <img src="'.BASE_URL . 'uploads/fastcon_benefits/' . $fastcon_benefits->image.'" class="image-responsive" alt="image fastcon_benefits" title="image fastcon_benefits" width="40px">
	                        </a>';
                }else{
	                $row[] =  '<a href="'.BASE_URL . 'administrator/file/download/fastcon_benefits/' . $fastcon_benefits->image.'">
	                       <img src="'.get_icon_file($fastcon_benefits->image).'" class="image-responsive image-icon" alt="image fastcon_benefits" title="image fastcon_benefits" width="40px">
	                     </a>';
                }
            }else{
				$row[] = null;
			}
	    	$row[] = $fastcon_benefits->title;

	    	$row[] = $fastcon_benefits->title_en;

	    	$row[] = $fastcon_benefits->caption;

	    	$row[] = $fastcon_benefits->caption_en;

	    
	        $row[] = $button;
	    	$data[] = $row;
        }

        $output = array(
            "draw" => $this->input->get('draw'),
            "recordsTotal" => $this->model_fastcon_benefits->count_all(),
            "recordsFiltered" => $this->model_fastcon_benefits->count_all(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	
	
		/**
	* Update view Fastcon Benefitss
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('fastcon_benefits_update');

		$this->data['fastcon_benefits'] = $this->model_fastcon_benefits->find($id);

		$this->template->title('Benefits Update');
		$this->render('backend/standart/administrator/fastcon_benefits/fastcon_benefits_update', $this->data);
	}

	/**
	* Update Fastcon Benefitss
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('fastcon_benefits_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('fastcon_benefits_image_name', 'Image', 'trim|required');
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('title_en', 'Title En', 'trim|required');
		$this->form_validation->set_rules('caption', 'Caption', 'trim|required');
		$this->form_validation->set_rules('caption_en', 'Caption En', 'trim|required');
		
		if ($this->form_validation->run()) {
			$fastcon_benefits_image_uuid = $this->input->post('fastcon_benefits_image_uuid');
			$fastcon_benefits_image_name = $this->input->post('fastcon_benefits_image_name');
		
			$save_data = [
				'title' => $this->input->post('title'),
				'title_en' => $this->input->post('title_en'),
				'caption' => $this->input->post('caption'),
				'caption_en' => $this->input->post('caption_en'),
			];

			if (!is_dir(FCPATH . '/uploads/fastcon_benefits/')) {
				mkdir(FCPATH . '/uploads/fastcon_benefits/');
			}

			if (!empty($fastcon_benefits_image_uuid)) {
				$fastcon_benefits_image_name_copy = date('YmdHis') . '-' . $fastcon_benefits_image_name;

				rename(FCPATH . 'uploads/tmp/' . $fastcon_benefits_image_uuid . '/' . $fastcon_benefits_image_name,
						FCPATH . 'uploads/fastcon_benefits/' . $fastcon_benefits_image_name_copy);

				if (!is_file(FCPATH . '/uploads/fastcon_benefits/' . $fastcon_benefits_image_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['image'] = $fastcon_benefits_image_name_copy;
			}
		
			
			$save_fastcon_benefits = $this->model_fastcon_benefits->change($id, $save_data);

			if ($save_fastcon_benefits) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/fastcon_benefits', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_benefits');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_benefits');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Fastcon Benefitss
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('fastcon_benefits_delete');

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
            set_message(cclang('has_been_deleted', 'fastcon_benefits'), 'success');
        } else {
            set_message(cclang('error_delete', 'fastcon_benefits'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Fastcon Benefitss
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('fastcon_benefits_view');

		$this->data['fastcon_benefits'] = $this->model_fastcon_benefits->join_avaiable()->find($id);

		$this->template->title('Benefits Detail');
		$this->render('backend/standart/administrator/fastcon_benefits/fastcon_benefits_view', $this->data);
	}
	
	/**
	* delete Fastcon Benefitss
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$fastcon_benefits = $this->model_fastcon_benefits->find($id);

		if (!empty($fastcon_benefits->image)) {
			$path = FCPATH . '/uploads/fastcon_benefits/' . $fastcon_benefits->image;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}
		
		
		return $this->model_fastcon_benefits->remove($id);
	}
	
	/**
	* Upload Image Fastcon Benefits	*
	* @return JSON
	*/
	public function upload_image_file()
	{
		if (!$this->is_allowed('fastcon_benefits_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'fastcon_benefits',
			'allowed_types' => 'png',
		]);
	}

	/**
	* Delete Image Fastcon Benefits	*
	* @return JSON
	*/
	public function delete_image_file($uuid)
	{
		if (!$this->is_allowed('fastcon_benefits_delete', false)) {
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
            'table_name'        => 'fastcon_benefits',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/fastcon_benefits/'
        ]);
	}

	/**
	* Get Image Fastcon Benefits	*
	* @return JSON
	*/
	public function get_image_file($id)
	{
		if (!$this->is_allowed('fastcon_benefits_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$fastcon_benefits = $this->model_fastcon_benefits->find($id);

		echo $this->get_file([
            'uuid'              => $id,
            'delete_by'         => 'id',
            'field_name'        => 'image',
            'table_name'        => 'fastcon_benefits',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/fastcon_benefits/',
            'delete_endpoint'   => 'administrator/fastcon_benefits/delete_image_file'
        ]);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('fastcon_benefits_export');

		$this->model_fastcon_benefits->export('fastcon_benefits', 'fastcon_benefits');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('fastcon_benefits_export');

		$this->model_fastcon_benefits->pdf('fastcon_benefits', 'fastcon_benefits');
	}
}


/* End of file fastcon_benefits.php */
/* Location: ./application/controllers/administrator/Fastcon Benefits.php */
