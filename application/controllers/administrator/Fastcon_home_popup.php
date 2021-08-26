<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Fastcon Home Popup Controller
*| --------------------------------------------------------------------------
*| Fastcon Home Popup site
*|
*/
class Fastcon_home_popup extends Admin
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_fastcon_home_popup');
	}

	/**
	* show all Fastcon Home Popups
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('fastcon_home_popup_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['fastcon_home_popups'] = $this->model_fastcon_home_popup->get($filter, $field, $this->limit_page, $offset);
		$this->data['fastcon_home_popup_counts'] = $this->model_fastcon_home_popup->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/fastcon_home_popup/index/',
			'total_rows'   => $this->model_fastcon_home_popup->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);
		$this->data['datables'] = true;

		$this->template->title('Popup List');
		$this->render('backend/standart/administrator/fastcon_home_popup/fastcon_home_popup_list', $this->data);
	}

	public function data_ajax()
	{
		$this->is_allowed('fastcon_home_popup_list');
		$fastcon_home_popups = $this->model_fastcon_home_popup->get($_GET['search']['value'], '', $this->input->get('length'), $this->input->get('start'), 0);
		$data = array();
        $no = $this->input->get('draw');


        foreach($fastcon_home_popups as $fastcon_home_popup){
        	$button = '';
        	$row = [];

			
	        $button .= '<a href="'.site_url("administrator/fastcon_home_popup/view/" . $fastcon_home_popup->id).'" class="label-default mr-3"><i class="fa fa-newspaper-o" style="padding-right:3px;"></i> '.cclang("view_button").'</a>';

			        	if($this->is_allowed('fastcon_home_popup_update'))
        	{
		        $button .= '<a href="'.site_url("administrator/fastcon_home_popup/edit/" . $fastcon_home_popup->id) .'" class="label-default mr-3"><i class="fa fa-edit "></i> '.cclang('update_button').'</a>';
        	}



	    	$row[] = $fastcon_home_popup->popup_title;

	    	$row[] = $fastcon_home_popup->popup_title_en;

	    	$row[] = $fastcon_home_popup->body;

	    	$row[] = $fastcon_home_popup->body_en;

	    	$row[] = $fastcon_home_popup->btn_primary_text;

	    	$row[] = $fastcon_home_popup->btn_primary_text_en;

	    	$row[] = $fastcon_home_popup->btn_primary_link;

	    	$row[] = $fastcon_home_popup->btn_secondary_text;

	    	$row[] = $fastcon_home_popup->btn_secondary_text_en;

	    	$row[] = $fastcon_home_popup->btn_secondary_link;

	    	$row[] = $fastcon_home_popup->active;

	    
	        $row[] = $button;
	    	$data[] = $row;
        }

        $output = array(
            "draw" => $this->input->get('draw'),
            "recordsTotal" => $this->model_fastcon_home_popup->count_all(),
            "recordsFiltered" => $this->model_fastcon_home_popup->count_all(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	
	
		/**
	* Update view Fastcon Home Popups
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('fastcon_home_popup_update');

		$this->data['fastcon_home_popup'] = $this->model_fastcon_home_popup->find($id);

		$this->template->title('Popup Update');
		$this->render('backend/standart/administrator/fastcon_home_popup/fastcon_home_popup_update', $this->data);
	}

	/**
	* Update Fastcon Home Popups
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('fastcon_home_popup_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('popup_title', 'Popup Title', 'trim|required');
		$this->form_validation->set_rules('popup_title_en', 'Popup Title En', 'trim|required');
		$this->form_validation->set_rules('active', 'Active', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'popup_title' => $this->input->post('popup_title'),
				'popup_title_en' => $this->input->post('popup_title_en'),
				'body' => $this->input->post('body'),
				'body_en' => $this->input->post('body_en'),
				'btn_primary_text' => $this->input->post('btn_primary_text'),
				'btn_primary_text_en' => $this->input->post('btn_primary_text_en'),
				'btn_primary_link' => $this->input->post('btn_primary_link'),
				'btn_secondary_text' => $this->input->post('btn_secondary_text'),
				'btn_secondary_text_en' => $this->input->post('btn_secondary_text_en'),
				'btn_secondary_link' => $this->input->post('btn_secondary_link'),
				'active' => $this->input->post('active'),
			];

			
			$save_fastcon_home_popup = $this->model_fastcon_home_popup->change($id, $save_data);

			if ($save_fastcon_home_popup) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/fastcon_home_popup', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_home_popup');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_home_popup');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Fastcon Home Popups
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('fastcon_home_popup_delete');

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
            set_message(cclang('has_been_deleted', 'fastcon_home_popup'), 'success');
        } else {
            set_message(cclang('error_delete', 'fastcon_home_popup'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Fastcon Home Popups
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('fastcon_home_popup_view');

		$this->data['fastcon_home_popup'] = $this->model_fastcon_home_popup->join_avaiable()->find($id);

		$this->template->title('Popup Detail');
		$this->render('backend/standart/administrator/fastcon_home_popup/fastcon_home_popup_view', $this->data);
	}
	
	/**
	* delete Fastcon Home Popups
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$fastcon_home_popup = $this->model_fastcon_home_popup->find($id);

		
		
		return $this->model_fastcon_home_popup->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('fastcon_home_popup_export');

		$this->model_fastcon_home_popup->export('fastcon_home_popup', 'fastcon_home_popup');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('fastcon_home_popup_export');

		$this->model_fastcon_home_popup->pdf('fastcon_home_popup', 'fastcon_home_popup');
	}
}


/* End of file fastcon_home_popup.php */
/* Location: ./application/controllers/administrator/Fastcon Home Popup.php */
