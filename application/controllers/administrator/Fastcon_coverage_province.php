<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Fastcon Coverage Province Controller
*| --------------------------------------------------------------------------
*| Fastcon Coverage Province site
*|
*/
class Fastcon_coverage_province extends Admin
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_fastcon_coverage_province');
	}

	/**
	* show all Fastcon Coverage Provinces
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('fastcon_coverage_province_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['fastcon_coverage_provinces'] = $this->model_fastcon_coverage_province->get($filter, $field, $this->limit_page, $offset);
		$this->data['fastcon_coverage_province_counts'] = $this->model_fastcon_coverage_province->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/fastcon_coverage_province/index/',
			'total_rows'   => $this->model_fastcon_coverage_province->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);
		$this->data['datables'] = true;

		$this->template->title('Coverage Province List');
		$this->render('backend/standart/administrator/fastcon_coverage_province/fastcon_coverage_province_list', $this->data);
	}

	public function data_ajax()
	{
		$this->is_allowed('fastcon_coverage_province_list');
		$fastcon_coverage_provinces = $this->model_fastcon_coverage_province->get($_GET['search']['value'], '', $this->input->get('length'), $this->input->get('start'), 0);
		$data = array();
        $no = $this->input->get('draw');


        foreach($fastcon_coverage_provinces as $fastcon_coverage_province){
        	$button = '';
        	$row = [];

						if($this->is_allowed('fastcon_coverage_province_add'))
        	{
		        $button .= '<a href="'.site_url("administrator/fastcon_coverage_province/clone_data/" . $fastcon_coverage_province->province_id) .'" class="label-default mr-3"><i class="fa fa-copy"></i> '.cclang('clone').'</a>';
        	}
			
	        $button .= '<a href="'.site_url("administrator/fastcon_coverage_province/view/" . $fastcon_coverage_province->province_id).'" class="label-default mr-3"><i class="fa fa-newspaper-o" style="padding-right:3px;"></i> '.cclang("view_button").'</a>';

			        	if($this->is_allowed('fastcon_coverage_province_update'))
        	{
		        $button .= '<a href="'.site_url("administrator/fastcon_coverage_province/edit/" . $fastcon_coverage_province->province_id) .'" class="label-default mr-3"><i class="fa fa-edit "></i> '.cclang('update_button').'</a>';
        	}
			        	if($this->is_allowed('fastcon_coverage_province_delete'))
        	{
		        $button .= '<a href="javascript:void(0);" onclick="delete_this(\''.BASE_URL.'administrator/fastcon_coverage_province/delete/'.$fastcon_coverage_province->province_id.'\')" class="label-default remove-data"><i class="fa fa-close"></i>'.cclang('remove_button').'</a>';
        	}



	    	$row[] = $fastcon_coverage_province->province_name;

	    	$row[] = $fastcon_coverage_province->province_name_en;

	    	$row[] = $fastcon_coverage_province->shipping_price;

	    
	        $row[] = $button;
	    	$data[] = $row;
        }

        $output = array(
            "draw" => $this->input->get('draw'),
            "recordsTotal" => $this->model_fastcon_coverage_province->count_all(),
            "recordsFiltered" => $this->model_fastcon_coverage_province->count_all(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	/**
	* Add new fastcon_coverage_provinces
	*
	*/
	public function add()
	{
		$this->is_allowed('fastcon_coverage_province_add');

		$this->template->title('Coverage Province New');
		$this->render('backend/standart/administrator/fastcon_coverage_province/fastcon_coverage_province_add', $this->data);
	}

	/**
	* Add New Fastcon Coverage Provinces
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('fastcon_coverage_province_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('province_name', 'Province Name', 'trim|required');
		$this->form_validation->set_rules('province_name_en', 'Province Name En', 'trim|required');
		$this->form_validation->set_rules('shipping_price', 'Shipping Price', 'trim|required');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
				'province_name' => $this->input->post('province_name'),
				'province_name_en' => $this->input->post('province_name_en'),
				'shipping_price' => $this->input->post('shipping_price'),
			];

			
			$save_fastcon_coverage_province = $this->model_fastcon_coverage_province->store($save_data);

			if ($save_fastcon_coverage_province) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_fastcon_coverage_province;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/fastcon_coverage_province/edit/' . $save_fastcon_coverage_province, 'Edit Fastcon Coverage Province'),
						anchor('administrator/fastcon_coverage_province', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/fastcon_coverage_province/edit/' . $save_fastcon_coverage_province, 'Edit Fastcon Coverage Province')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_coverage_province');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_coverage_province');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	
	/**
	* Clone data Fastcon Coverage Province	*
	*/
	public function clone_data($id=0)
	{
		if($id<=0)
		{
			$this->data['success'] = false;
    		$this->data['message'] = cclang('data_not_found');
			$this->data['redirect'] = base_url('administrator/fastcon_coverage_province');
			set_message(cclang('data_not_found'), 'warning');
		}

		$this->is_allowed('fastcon_coverage_province_add');

		if($data = db_get_row_data('fastcon_coverage_province', ['province_id' => $id]))
		{
			clone_this_data('fastcon_coverage_province', ['province_id' => $id]);
			$this->data['success'] = true;
    		$this->data['message'] = cclang('data_cloned');
			$this->data['redirect'] = base_url('administrator/fastcon_coverage_province');

			set_message(cclang('data_cloned'), 'success');
		}else{
			set_message(cclang('data_not_found'), 'warning');
		}

		redirect('administrator/fastcon_coverage_province');

	}

	
		/**
	* Update view Fastcon Coverage Provinces
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('fastcon_coverage_province_update');

		$this->data['fastcon_coverage_province'] = $this->model_fastcon_coverage_province->find($id);

		$this->template->title('Coverage Province Update');
		$this->render('backend/standart/administrator/fastcon_coverage_province/fastcon_coverage_province_update', $this->data);
	}

	/**
	* Update Fastcon Coverage Provinces
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('fastcon_coverage_province_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('province_name', 'Province Name', 'trim|required');
		$this->form_validation->set_rules('province_name_en', 'Province Name En', 'trim|required');
		$this->form_validation->set_rules('shipping_price', 'Shipping Price', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'province_name' => $this->input->post('province_name'),
				'province_name_en' => $this->input->post('province_name_en'),
				'shipping_price' => $this->input->post('shipping_price'),
			];

			
			$save_fastcon_coverage_province = $this->model_fastcon_coverage_province->change($id, $save_data);

			if ($save_fastcon_coverage_province) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/fastcon_coverage_province', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_coverage_province');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_coverage_province');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Fastcon Coverage Provinces
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('fastcon_coverage_province_delete');

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
            set_message(cclang('has_been_deleted', 'fastcon_coverage_province'), 'success');
        } else {
            set_message(cclang('error_delete', 'fastcon_coverage_province'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Fastcon Coverage Provinces
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('fastcon_coverage_province_view');

		$this->data['fastcon_coverage_province'] = $this->model_fastcon_coverage_province->join_avaiable()->find($id);

		$this->template->title('Coverage Province Detail');
		$this->render('backend/standart/administrator/fastcon_coverage_province/fastcon_coverage_province_view', $this->data);
	}
	
	/**
	* delete Fastcon Coverage Provinces
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$fastcon_coverage_province = $this->model_fastcon_coverage_province->find($id);

		
		
		return $this->model_fastcon_coverage_province->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('fastcon_coverage_province_export');

		$this->model_fastcon_coverage_province->export('fastcon_coverage_province', 'fastcon_coverage_province');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('fastcon_coverage_province_export');

		$this->model_fastcon_coverage_province->pdf('fastcon_coverage_province', 'fastcon_coverage_province');
	}
}


/* End of file fastcon_coverage_province.php */
/* Location: ./application/controllers/administrator/Fastcon Coverage Province.php */
