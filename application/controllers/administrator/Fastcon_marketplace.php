<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Fastcon Marketplace Controller
*| --------------------------------------------------------------------------
*| Fastcon Marketplace site
*|
*/
class Fastcon_marketplace extends Admin
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_fastcon_marketplace');
	}

	/**
	* show all Fastcon Marketplaces
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('fastcon_marketplace_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['fastcon_marketplaces'] = $this->model_fastcon_marketplace->get($filter, $field, $this->limit_page, $offset);
		$this->data['fastcon_marketplace_counts'] = $this->model_fastcon_marketplace->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/fastcon_marketplace/index/',
			'total_rows'   => $this->model_fastcon_marketplace->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);
		$this->data['datables'] = true;

		$this->template->title('Marketplace List');
		$this->render('backend/standart/administrator/fastcon_marketplace/fastcon_marketplace_list', $this->data);
	}

	public function data_ajax()
	{
		$this->is_allowed('fastcon_marketplace_list');
		$fastcon_marketplaces = $this->model_fastcon_marketplace->get($_GET['search']['value'], '', $this->input->get('length'), $this->input->get('start'), 0);
		$data = array();
        $no = $this->input->get('draw');


        foreach($fastcon_marketplaces as $fastcon_marketplace){
        	$button = '';
        	$row = [];

			
	        $button .= '<a href="'.site_url("administrator/fastcon_marketplace/view/" . $fastcon_marketplace->id).'" class="label-default mr-3"><i class="fa fa-newspaper-o" style="padding-right:3px;"></i> '.cclang("view_button").'</a>';

			        	if($this->is_allowed('fastcon_marketplace_update'))
        	{
		        $button .= '<a href="'.site_url("administrator/fastcon_marketplace/edit/" . $fastcon_marketplace->id) .'" class="label-default mr-3"><i class="fa fa-edit "></i> '.cclang('update_button').'</a>';
        	}
			        	if($this->is_allowed('fastcon_marketplace_delete'))
        	{
		        $button .= '<a href="javascript:void(0);" onclick="delete_this(\''.BASE_URL.'administrator/fastcon_marketplace/delete/'.$fastcon_marketplace->id.'\')" class="label-default remove-data"><i class="fa fa-close"></i>'.cclang('remove_button').'</a>';
        	}



	    	if (!empty($fastcon_marketplace->icon)){
                if (is_image($fastcon_marketplace->icon)){
	                $row[] = '<a class="fancybox" rel="group" href="'.BASE_URL . 'uploads/fastcon_marketplace/'. $fastcon_marketplace->icon.'">
	                            <img src="'.BASE_URL . 'uploads/fastcon_marketplace/' . $fastcon_marketplace->icon.'" class="image-responsive" alt="image fastcon_marketplace" title="icon fastcon_marketplace" width="40px">
	                        </a>';
                }else{
	                $row[] =  '<a href="'.BASE_URL . 'administrator/file/download/fastcon_marketplace/' . $fastcon_marketplace->icon.'">
	                       <img src="'.get_icon_file($fastcon_marketplace->icon).'" class="image-responsive image-icon" alt="image fastcon_marketplace" title="icon fastcon_marketplace" width="40px">
	                     </a>';
                }
            }else{
				$row[] = null;
			}
	    	$row[] = $fastcon_marketplace->link;

	    
	        $row[] = $button;
	    	$data[] = $row;
        }

        $output = array(
            "draw" => $this->input->get('draw'),
            "recordsTotal" => $this->model_fastcon_marketplace->count_all(),
            "recordsFiltered" => $this->model_fastcon_marketplace->count_all(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	/**
	* Add new fastcon_marketplaces
	*
	*/
	public function add()
	{
		$this->is_allowed('fastcon_marketplace_add');

		$this->template->title('Marketplace New');
		$this->render('backend/standart/administrator/fastcon_marketplace/fastcon_marketplace_add', $this->data);
	}

	/**
	* Add New Fastcon Marketplaces
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('fastcon_marketplace_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('fastcon_marketplace_icon_name', 'Icon', 'trim|required');
		$this->form_validation->set_rules('link', 'Link', 'trim|required');
		

		if ($this->form_validation->run()) {
			$fastcon_marketplace_icon_uuid = $this->input->post('fastcon_marketplace_icon_uuid');
			$fastcon_marketplace_icon_name = $this->input->post('fastcon_marketplace_icon_name');
		
			$save_data = [
				'link' => $this->input->post('link'),
			];

			if (!is_dir(FCPATH . '/uploads/fastcon_marketplace/')) {
				mkdir(FCPATH . '/uploads/fastcon_marketplace/');
			}

			if (!empty($fastcon_marketplace_icon_name)) {
				$fastcon_marketplace_icon_name_copy = date('YmdHis') . '-' . $fastcon_marketplace_icon_name;

				rename(FCPATH . 'uploads/tmp/' . $fastcon_marketplace_icon_uuid . '/' . $fastcon_marketplace_icon_name,
						FCPATH . 'uploads/fastcon_marketplace/' . $fastcon_marketplace_icon_name_copy);

				if (!is_file(FCPATH . '/uploads/fastcon_marketplace/' . $fastcon_marketplace_icon_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['icon'] = $fastcon_marketplace_icon_name_copy;
			}
		
			
			$save_fastcon_marketplace = $this->model_fastcon_marketplace->store($save_data);

			if ($save_fastcon_marketplace) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_fastcon_marketplace;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/fastcon_marketplace/edit/' . $save_fastcon_marketplace, 'Edit Fastcon Marketplace'),
						anchor('administrator/fastcon_marketplace', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/fastcon_marketplace/edit/' . $save_fastcon_marketplace, 'Edit Fastcon Marketplace')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_marketplace');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_marketplace');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	
		/**
	* Update view Fastcon Marketplaces
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('fastcon_marketplace_update');

		$this->data['fastcon_marketplace'] = $this->model_fastcon_marketplace->find($id);

		$this->template->title('Marketplace Update');
		$this->render('backend/standart/administrator/fastcon_marketplace/fastcon_marketplace_update', $this->data);
	}

	/**
	* Update Fastcon Marketplaces
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('fastcon_marketplace_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('fastcon_marketplace_icon_name', 'Icon', 'trim|required');
		$this->form_validation->set_rules('link', 'Link', 'trim|required');
		
		if ($this->form_validation->run()) {
			$fastcon_marketplace_icon_uuid = $this->input->post('fastcon_marketplace_icon_uuid');
			$fastcon_marketplace_icon_name = $this->input->post('fastcon_marketplace_icon_name');
		
			$save_data = [
				'link' => $this->input->post('link'),
			];

			if (!is_dir(FCPATH . '/uploads/fastcon_marketplace/')) {
				mkdir(FCPATH . '/uploads/fastcon_marketplace/');
			}

			if (!empty($fastcon_marketplace_icon_uuid)) {
				$fastcon_marketplace_icon_name_copy = date('YmdHis') . '-' . $fastcon_marketplace_icon_name;

				rename(FCPATH . 'uploads/tmp/' . $fastcon_marketplace_icon_uuid . '/' . $fastcon_marketplace_icon_name,
						FCPATH . 'uploads/fastcon_marketplace/' . $fastcon_marketplace_icon_name_copy);

				if (!is_file(FCPATH . '/uploads/fastcon_marketplace/' . $fastcon_marketplace_icon_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['icon'] = $fastcon_marketplace_icon_name_copy;
			}
		
			
			$save_fastcon_marketplace = $this->model_fastcon_marketplace->change($id, $save_data);

			if ($save_fastcon_marketplace) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/fastcon_marketplace', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_marketplace');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_marketplace');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Fastcon Marketplaces
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('fastcon_marketplace_delete');

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
            set_message(cclang('has_been_deleted', 'fastcon_marketplace'), 'success');
        } else {
            set_message(cclang('error_delete', 'fastcon_marketplace'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Fastcon Marketplaces
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('fastcon_marketplace_view');

		$this->data['fastcon_marketplace'] = $this->model_fastcon_marketplace->join_avaiable()->find($id);

		$this->template->title('Marketplace Detail');
		$this->render('backend/standart/administrator/fastcon_marketplace/fastcon_marketplace_view', $this->data);
	}
	
	/**
	* delete Fastcon Marketplaces
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$fastcon_marketplace = $this->model_fastcon_marketplace->find($id);

		if (!empty($fastcon_marketplace->icon)) {
			$path = FCPATH . '/uploads/fastcon_marketplace/' . $fastcon_marketplace->icon;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}
		
		
		return $this->model_fastcon_marketplace->remove($id);
	}
	
	/**
	* Upload Image Fastcon Marketplace	*
	* @return JSON
	*/
	public function upload_icon_file()
	{
		if (!$this->is_allowed('fastcon_marketplace_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'fastcon_marketplace',
			'allowed_types' => 'png',
		]);
	}

	/**
	* Delete Image Fastcon Marketplace	*
	* @return JSON
	*/
	public function delete_icon_file($uuid)
	{
		if (!$this->is_allowed('fastcon_marketplace_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid,
            'delete_by'         => $this->input->get('by'),
            'field_name'        => 'icon',
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'fastcon_marketplace',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/fastcon_marketplace/'
        ]);
	}

	/**
	* Get Image Fastcon Marketplace	*
	* @return JSON
	*/
	public function get_icon_file($id)
	{
		if (!$this->is_allowed('fastcon_marketplace_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$fastcon_marketplace = $this->model_fastcon_marketplace->find($id);

		echo $this->get_file([
            'uuid'              => $id,
            'delete_by'         => 'id',
            'field_name'        => 'icon',
            'table_name'        => 'fastcon_marketplace',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/fastcon_marketplace/',
            'delete_endpoint'   => 'administrator/fastcon_marketplace/delete_icon_file'
        ]);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('fastcon_marketplace_export');

		$this->model_fastcon_marketplace->export('fastcon_marketplace', 'fastcon_marketplace');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('fastcon_marketplace_export');

		$this->model_fastcon_marketplace->pdf('fastcon_marketplace', 'fastcon_marketplace');
	}
}


/* End of file fastcon_marketplace.php */
/* Location: ./application/controllers/administrator/Fastcon Marketplace.php */
