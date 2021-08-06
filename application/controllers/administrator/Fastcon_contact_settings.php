<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Fastcon Contact Settings Controller
*| --------------------------------------------------------------------------
*| Fastcon Contact Settings site
*|
*/
class Fastcon_contact_settings extends Admin
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_fastcon_contact_settings');
	}

	/**
	* show all Fastcon Contact Settingss
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('fastcon_contact_settings_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['fastcon_contact_settingss'] = $this->model_fastcon_contact_settings->get($filter, $field, $this->limit_page, $offset);
		$this->data['fastcon_contact_settings_counts'] = $this->model_fastcon_contact_settings->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/fastcon_contact_settings/index/',
			'total_rows'   => $this->model_fastcon_contact_settings->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);
		$this->data['datables'] = true;

		$this->template->title('Contact Settings List');
		$this->render('backend/standart/administrator/fastcon_contact_settings/fastcon_contact_settings_list', $this->data);
	}

	public function data_ajax()
	{
		$this->is_allowed('fastcon_contact_settings_list');
		$fastcon_contact_settingss = $this->model_fastcon_contact_settings->get($_GET['search']['value'], '', $this->input->get('length'), $this->input->get('start'), 0);
		$data = array();
        $no = $this->input->get('draw');


        foreach($fastcon_contact_settingss as $fastcon_contact_settings){
        	$button = '';
        	$row = [];

			
	        $button .= '<a href="'.site_url("administrator/fastcon_contact_settings/view/" . $fastcon_contact_settings->id).'" class="label-default mr-3"><i class="fa fa-newspaper-o" style="padding-right:3px;"></i> '.cclang("view_button").'</a>';

			        	if($this->is_allowed('fastcon_contact_settings_update'))
        	{
		        $button .= '<a href="'.site_url("administrator/fastcon_contact_settings/edit/" . $fastcon_contact_settings->id) .'" class="label-default mr-3"><i class="fa fa-edit "></i> '.cclang('update_button').'</a>';
        	}
			      //   	if($this->is_allowed('fastcon_contact_settings_delete'))
        	// {
		       //  $button .= '<a href="javascript:void(0);" onclick="delete_this(\''.BASE_URL.'administrator/fastcon_contact_settings/delete/'.$fastcon_contact_settings->id.'\')" class="label-default remove-data"><i class="fa fa-close"></i>'.cclang('remove_button').'</a>';
        	// }



	    	$row[] = $fastcon_contact_settings->setting_item;

	    	$row[] = $fastcon_contact_settings->setting_value;

	    
	        $row[] = $button;
	    	$data[] = $row;
        }

        $output = array(
            "draw" => $this->input->get('draw'),
            "recordsTotal" => $this->model_fastcon_contact_settings->count_all(),
            "recordsFiltered" => $this->model_fastcon_contact_settings->count_all(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	
	
		/**
	* Update view Fastcon Contact Settingss
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('fastcon_contact_settings_update');

		$this->data['fastcon_contact_settings'] = $this->model_fastcon_contact_settings->find($id);

		$this->template->title('Contact Settings Update');
		$this->render('backend/standart/administrator/fastcon_contact_settings/fastcon_contact_settings_update', $this->data);
	}

	/**
	* Update Fastcon Contact Settingss
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('fastcon_contact_settings_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('setting_item', 'Setting Item', 'trim|required');
		$this->form_validation->set_rules('setting_value', 'Setting Value', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'setting_item' => $this->input->post('setting_item'),
				'setting_value' => $this->input->post('setting_value'),
			];

			
			$save_fastcon_contact_settings = $this->model_fastcon_contact_settings->change($id, $save_data);

			if ($save_fastcon_contact_settings) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/fastcon_contact_settings', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_contact_settings');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_contact_settings');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Fastcon Contact Settingss
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('fastcon_contact_settings_delete');

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
            set_message(cclang('has_been_deleted', 'fastcon_contact_settings'), 'success');
        } else {
            set_message(cclang('error_delete', 'fastcon_contact_settings'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Fastcon Contact Settingss
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('fastcon_contact_settings_view');

		$this->data['fastcon_contact_settings'] = $this->model_fastcon_contact_settings->join_avaiable()->find($id);

		$this->template->title('Contact Settings Detail');
		$this->render('backend/standart/administrator/fastcon_contact_settings/fastcon_contact_settings_view', $this->data);
	}
	
	/**
	* delete Fastcon Contact Settingss
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$fastcon_contact_settings = $this->model_fastcon_contact_settings->find($id);

		
		
		return $this->model_fastcon_contact_settings->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('fastcon_contact_settings_export');

		$this->model_fastcon_contact_settings->export('fastcon_contact_settings', 'fastcon_contact_settings');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('fastcon_contact_settings_export');

		$this->model_fastcon_contact_settings->pdf('fastcon_contact_settings', 'fastcon_contact_settings');
	}
}


/* End of file fastcon_contact_settings.php */
/* Location: ./application/controllers/administrator/Fastcon Contact Settings.php */
