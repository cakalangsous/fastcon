<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Skin Option Controller
*| --------------------------------------------------------------------------
*| Skin Option site
*|
*/
class Skin_option extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_skin_option');
	}

	/**
	* show all Skin Options
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('skin_option_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['skin_options'] = $this->model_skin_option->get($filter, $field, $this->limit_page, $offset);
		$this->data['skin_option_counts'] = $this->model_skin_option->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/skin_option/index/',
			'total_rows'   => $this->model_skin_option->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Skin Option List');
		$this->render('backend/standart/administrator/skin_option/skin_option_list', $this->data);
	}
	
	/**
	* Add new skin_options
	*
	*/
	public function add()
	{
		$this->is_allowed('skin_option_add');

		$this->template->title('Skin Option New');
		$this->render('backend/standart/administrator/skin_option/skin_option_add', $this->data);
	}

	/**
	* Add New Skin Options
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('skin_option_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('option_name', 'Option Name', 'trim|required|max_length[200]');
		$this->form_validation->set_rules('option_value', 'Option Value', 'trim|required|max_length[200]');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
				'option_name' => $this->input->post('option_name'),
				'option_value' => $this->input->post('option_value'),
				'description' => $this->input->post('description'),
			];

			
			$save_skin_option = $this->model_skin_option->store($save_data);

			if ($save_skin_option) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_skin_option;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/skin_option/edit/' . $save_skin_option, 'Edit Skin Option'),
						anchor('administrator/skin_option', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/skin_option/edit/' . $save_skin_option, 'Edit Skin Option')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/skin_option');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/skin_option');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
		/**
	* Update view Skin Options
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('skin_option_update');

		$this->data['skin_option'] = $this->model_skin_option->find($id);

		$this->template->title('Skin Option Update');
		$this->render('backend/standart/administrator/skin_option/skin_option_update', $this->data);
	}

	/**
	* Update Skin Options
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('skin_option_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('option_name', 'Option Name', 'trim|required|max_length[200]');
		$this->form_validation->set_rules('option_value', 'Option Value', 'trim|required|max_length[200]');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'option_name' => $this->input->post('option_name'),
				'option_value' => $this->input->post('option_value'),
				'description' => $this->input->post('description'),
			];

			
			$save_skin_option = $this->model_skin_option->change($id, $save_data);

			if ($save_skin_option) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/skin_option', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/skin_option');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/skin_option');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Skin Options
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('skin_option_delete');

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
            set_message(cclang('has_been_deleted', 'skin_option'), 'success');
        } else {
            set_message(cclang('error_delete', 'skin_option'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Skin Options
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('skin_option_view');

		$this->data['skin_option'] = $this->model_skin_option->join_avaiable()->find($id);

		$this->template->title('Skin Option Detail');
		$this->render('backend/standart/administrator/skin_option/skin_option_view', $this->data);
	}
	
	/**
	* delete Skin Options
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$skin_option = $this->model_skin_option->find($id);

		
		
		return $this->model_skin_option->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('skin_option_export');

		$this->model_skin_option->export('skin_option', 'skin_option');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('skin_option_export');

		$this->model_skin_option->pdf('skin_option', 'skin_option');
	}
}


/* End of file skin_option.php */
/* Location: ./application/controllers/administrator/Skin Option.php */