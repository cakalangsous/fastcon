<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Fastcon Our Location Controller
*| --------------------------------------------------------------------------
*| Fastcon Our Location site
*|
*/
class Fastcon_our_location extends Admin
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_fastcon_our_location');
	}

	/**
	* show all Fastcon Our Locations
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('fastcon_our_location_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['fastcon_our_locations'] = $this->model_fastcon_our_location->get($filter, $field, $this->limit_page, $offset);
		$this->data['fastcon_our_location_counts'] = $this->model_fastcon_our_location->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/fastcon_our_location/index/',
			'total_rows'   => $this->model_fastcon_our_location->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);
		$this->data['datables'] = true;

		$this->template->title('Our Location List');
		$this->render('backend/standart/administrator/fastcon_our_location/fastcon_our_location_list', $this->data);
	}

	public function data_ajax()
	{
		$this->is_allowed('fastcon_our_location_list');
		$fastcon_our_locations = $this->model_fastcon_our_location->get($_GET['search']['value'], '', $this->input->get('length'), $this->input->get('start'), 0);
		$data = array();
        $no = $this->input->get('draw');


        foreach($fastcon_our_locations as $fastcon_our_location){
        	$button = '';
        	$row = [];

			
	        $button .= '<a href="'.site_url("administrator/fastcon_our_location/view/" . $fastcon_our_location->id).'" class="label-default mr-3"><i class="fa fa-newspaper-o" style="padding-right:3px;"></i> '.cclang("view_button").'</a>';

			        	if($this->is_allowed('fastcon_our_location_update'))
        	{
		        $button .= '<a href="'.site_url("administrator/fastcon_our_location/edit/" . $fastcon_our_location->id) .'" class="label-default mr-3"><i class="fa fa-edit "></i> '.cclang('update_button').'</a>';
        	}
			      //   	if($this->is_allowed('fastcon_our_location_delete'))
        	// {
		       //  $button .= '<a href="javascript:void(0);" onclick="delete_this(\''.BASE_URL.'administrator/fastcon_our_location/delete/'.$fastcon_our_location->id.'\')" class="label-default remove-data"><i class="fa fa-close"></i>'.cclang('remove_button').'</a>';
        	// }



	    	if (!empty($fastcon_our_location->image)){
                if (is_image($fastcon_our_location->image)){
	                $row[] = '<a class="fancybox" rel="group" href="'.BASE_URL . 'uploads/fastcon_our_location/'. $fastcon_our_location->image.'">
	                            <img src="'.BASE_URL . 'uploads/fastcon_our_location/' . $fastcon_our_location->image.'" class="image-responsive" alt="image fastcon_our_location" title="image fastcon_our_location" width="40px">
	                        </a>';
                }else{
	                $row[] =  '<a href="'.BASE_URL . 'administrator/file/download/fastcon_our_location/' . $fastcon_our_location->image.'">
	                       <img src="'.get_icon_file($fastcon_our_location->image).'" class="image-responsive image-icon" alt="image fastcon_our_location" title="image fastcon_our_location" width="40px">
	                     </a>';
                }
            }else{
				$row[] = null;
			}
	    
	        $row[] = $button;
	    	$data[] = $row;
        }

        $output = array(
            "draw" => $this->input->get('draw'),
            "recordsTotal" => $this->model_fastcon_our_location->count_all(),
            "recordsFiltered" => $this->model_fastcon_our_location->count_all(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	
	
		/**
	* Update view Fastcon Our Locations
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('fastcon_our_location_update');

		$this->data['fastcon_our_location'] = $this->model_fastcon_our_location->find($id);

		$this->template->title('Our Location Update');
		$this->render('backend/standart/administrator/fastcon_our_location/fastcon_our_location_update', $this->data);
	}

	/**
	* Update Fastcon Our Locations
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('fastcon_our_location_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('fastcon_our_location_image_name', 'Image', 'trim|required');
		
		if ($this->form_validation->run()) {
			$fastcon_our_location_image_uuid = $this->input->post('fastcon_our_location_image_uuid');
			$fastcon_our_location_image_name = $this->input->post('fastcon_our_location_image_name');
		
			$save_data = [
			];

			if (!is_dir(FCPATH . '/uploads/fastcon_our_location/')) {
				mkdir(FCPATH . '/uploads/fastcon_our_location/');
			}

			if (!empty($fastcon_our_location_image_uuid)) {
				$fastcon_our_location_image_name_copy = date('YmdHis') . '-' . $fastcon_our_location_image_name;

				rename(FCPATH . 'uploads/tmp/' . $fastcon_our_location_image_uuid . '/' . $fastcon_our_location_image_name,
						FCPATH . 'uploads/fastcon_our_location/' . $fastcon_our_location_image_name_copy);

				if (!is_file(FCPATH . '/uploads/fastcon_our_location/' . $fastcon_our_location_image_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['image'] = $fastcon_our_location_image_name_copy;
			}
		
			
			$save_fastcon_our_location = $this->model_fastcon_our_location->change($id, $save_data);

			if ($save_fastcon_our_location) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/fastcon_our_location', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_our_location');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_our_location');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Fastcon Our Locations
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('fastcon_our_location_delete');

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
            set_message(cclang('has_been_deleted', 'fastcon_our_location'), 'success');
        } else {
            set_message(cclang('error_delete', 'fastcon_our_location'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Fastcon Our Locations
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('fastcon_our_location_view');

		$this->data['fastcon_our_location'] = $this->model_fastcon_our_location->join_avaiable()->find($id);

		$this->template->title('Our Location Detail');
		$this->render('backend/standart/administrator/fastcon_our_location/fastcon_our_location_view', $this->data);
	}
	
	/**
	* delete Fastcon Our Locations
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$fastcon_our_location = $this->model_fastcon_our_location->find($id);

		if (!empty($fastcon_our_location->image)) {
			$path = FCPATH . '/uploads/fastcon_our_location/' . $fastcon_our_location->image;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}
		
		
		return $this->model_fastcon_our_location->remove($id);
	}
	
	/**
	* Upload Image Fastcon Our Location	*
	* @return JSON
	*/
	public function upload_image_file()
	{
		if (!$this->is_allowed('fastcon_our_location_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'fastcon_our_location',
			'allowed_types' => 'jpg|jpeg|png',
		]);
	}

	/**
	* Delete Image Fastcon Our Location	*
	* @return JSON
	*/
	public function delete_image_file($uuid)
	{
		if (!$this->is_allowed('fastcon_our_location_delete', false)) {
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
            'table_name'        => 'fastcon_our_location',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/fastcon_our_location/'
        ]);
	}

	/**
	* Get Image Fastcon Our Location	*
	* @return JSON
	*/
	public function get_image_file($id)
	{
		if (!$this->is_allowed('fastcon_our_location_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$fastcon_our_location = $this->model_fastcon_our_location->find($id);

		echo $this->get_file([
            'uuid'              => $id,
            'delete_by'         => 'id',
            'field_name'        => 'image',
            'table_name'        => 'fastcon_our_location',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/fastcon_our_location/',
            'delete_endpoint'   => 'administrator/fastcon_our_location/delete_image_file'
        ]);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('fastcon_our_location_export');

		$this->model_fastcon_our_location->export('fastcon_our_location', 'fastcon_our_location');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('fastcon_our_location_export');

		$this->model_fastcon_our_location->pdf('fastcon_our_location', 'fastcon_our_location');
	}
}


/* End of file fastcon_our_location.php */
/* Location: ./application/controllers/administrator/Fastcon Our Location.php */
