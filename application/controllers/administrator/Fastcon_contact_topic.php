<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Fastcon Contact Topic Controller
*| --------------------------------------------------------------------------
*| Fastcon Contact Topic site
*|
*/
class Fastcon_contact_topic extends Admin
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_fastcon_contact_topic');
	}

	/**
	* show all Fastcon Contact Topics
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('fastcon_contact_topic_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['fastcon_contact_topics'] = $this->model_fastcon_contact_topic->get($filter, $field, $this->limit_page, $offset);
		$this->data['fastcon_contact_topic_counts'] = $this->model_fastcon_contact_topic->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/fastcon_contact_topic/index/',
			'total_rows'   => $this->model_fastcon_contact_topic->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);
		$this->data['datables'] = true;

		$this->template->title('Contact Topic List');
		$this->render('backend/standart/administrator/fastcon_contact_topic/fastcon_contact_topic_list', $this->data);
	}

	public function data_ajax()
	{
		$this->is_allowed('fastcon_contact_topic_list');
		$fastcon_contact_topics = $this->model_fastcon_contact_topic->get($_GET['search']['value'], '', $this->input->get('length'), $this->input->get('start'), 0);
		$data = array();
        $no = $this->input->get('draw');


        foreach($fastcon_contact_topics as $fastcon_contact_topic){
        	$button = '';
        	$row = [];

						if($this->is_allowed('fastcon_contact_topic_add'))
        	{
		        $button .= '<a href="'.site_url("administrator/fastcon_contact_topic/clone_data/" . $fastcon_contact_topic->topid_id) .'" class="label-default mr-3"><i class="fa fa-copy"></i> '.cclang('clone').'</a>';
        	}
			
	        $button .= '<a href="'.site_url("administrator/fastcon_contact_topic/view/" . $fastcon_contact_topic->topid_id).'" class="label-default mr-3"><i class="fa fa-newspaper-o" style="padding-right:3px;"></i> '.cclang("view_button").'</a>';

			        	if($this->is_allowed('fastcon_contact_topic_update'))
        	{
		        $button .= '<a href="'.site_url("administrator/fastcon_contact_topic/edit/" . $fastcon_contact_topic->topid_id) .'" class="label-default mr-3"><i class="fa fa-edit "></i> '.cclang('update_button').'</a>';
        	}
			        	if($this->is_allowed('fastcon_contact_topic_delete'))
        	{
		        $button .= '<a href="javascript:void(0);" onclick="delete_this(\''.BASE_URL.'administrator/fastcon_contact_topic/delete/'.$fastcon_contact_topic->topid_id.'\')" class="label-default remove-data"><i class="fa fa-close"></i>'.cclang('remove_button').'</a>';
        	}



	    	$row[] = $fastcon_contact_topic->topic_name;

	    	$row[] = $fastcon_contact_topic->topic_name_en;

	    	$row[] = $fastcon_contact_topic->email;

	    
	        $row[] = $button;
	    	$data[] = $row;
        }

        $output = array(
            "draw" => $this->input->get('draw'),
            "recordsTotal" => $this->model_fastcon_contact_topic->count_all(),
            "recordsFiltered" => $this->model_fastcon_contact_topic->count_all(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	/**
	* Add new fastcon_contact_topics
	*
	*/
	public function add()
	{
		$this->is_allowed('fastcon_contact_topic_add');

		$this->template->title('Contact Topic New');
		$this->render('backend/standart/administrator/fastcon_contact_topic/fastcon_contact_topic_add', $this->data);
	}

	/**
	* Add New Fastcon Contact Topics
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('fastcon_contact_topic_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('topic_name', 'Topic Name', 'trim|required|max_length[250]');
		$this->form_validation->set_rules('topic_name_en', 'Topic Name En', 'trim|required|max_length[250]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[250]');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
				'topic_name' => $this->input->post('topic_name'),
				'topic_name_en' => $this->input->post('topic_name_en'),
				'email' => $this->input->post('email'),
			];

			
			$save_fastcon_contact_topic = $this->model_fastcon_contact_topic->store($save_data);

			if ($save_fastcon_contact_topic) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_fastcon_contact_topic;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/fastcon_contact_topic/edit/' . $save_fastcon_contact_topic, 'Edit Fastcon Contact Topic'),
						anchor('administrator/fastcon_contact_topic', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/fastcon_contact_topic/edit/' . $save_fastcon_contact_topic, 'Edit Fastcon Contact Topic')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_contact_topic');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_contact_topic');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	
	/**
	* Clone data Fastcon Contact Topic	*
	*/
	public function clone_data($id=0)
	{
		if($id<=0)
		{
			$this->data['success'] = false;
    		$this->data['message'] = cclang('data_not_found');
			$this->data['redirect'] = base_url('administrator/fastcon_contact_topic');
			set_message(cclang('data_not_found'), 'warning');
		}

		$this->is_allowed('fastcon_contact_topic_add');

		if($data = db_get_row_data('fastcon_contact_topic', ['topid_id' => $id]))
		{
			clone_this_data('fastcon_contact_topic', ['topid_id' => $id]);
			$this->data['success'] = true;
    		$this->data['message'] = cclang('data_cloned');
			$this->data['redirect'] = base_url('administrator/fastcon_contact_topic');

			set_message(cclang('data_cloned'), 'success');
		}else{
			set_message(cclang('data_not_found'), 'warning');
		}

		redirect('administrator/fastcon_contact_topic');

	}

	
		/**
	* Update view Fastcon Contact Topics
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('fastcon_contact_topic_update');

		$this->data['fastcon_contact_topic'] = $this->model_fastcon_contact_topic->find($id);

		$this->template->title('Contact Topic Update');
		$this->render('backend/standart/administrator/fastcon_contact_topic/fastcon_contact_topic_update', $this->data);
	}

	/**
	* Update Fastcon Contact Topics
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('fastcon_contact_topic_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('topic_name', 'Topic Name', 'trim|required|max_length[250]');
		$this->form_validation->set_rules('topic_name_en', 'Topic Name En', 'trim|required|max_length[250]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[250]');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'topic_name' => $this->input->post('topic_name'),
				'topic_name_en' => $this->input->post('topic_name_en'),
				'email' => $this->input->post('email'),
			];

			
			$save_fastcon_contact_topic = $this->model_fastcon_contact_topic->change($id, $save_data);

			if ($save_fastcon_contact_topic) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/fastcon_contact_topic', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_contact_topic');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_contact_topic');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Fastcon Contact Topics
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('fastcon_contact_topic_delete');

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
            set_message(cclang('has_been_deleted', 'fastcon_contact_topic'), 'success');
        } else {
            set_message(cclang('error_delete', 'fastcon_contact_topic'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Fastcon Contact Topics
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('fastcon_contact_topic_view');

		$this->data['fastcon_contact_topic'] = $this->model_fastcon_contact_topic->join_avaiable()->find($id);

		$this->template->title('Contact Topic Detail');
		$this->render('backend/standart/administrator/fastcon_contact_topic/fastcon_contact_topic_view', $this->data);
	}
	
	/**
	* delete Fastcon Contact Topics
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$fastcon_contact_topic = $this->model_fastcon_contact_topic->find($id);

		
		
		return $this->model_fastcon_contact_topic->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('fastcon_contact_topic_export');

		$this->model_fastcon_contact_topic->export('fastcon_contact_topic', 'fastcon_contact_topic');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('fastcon_contact_topic_export');

		$this->model_fastcon_contact_topic->pdf('fastcon_contact_topic', 'fastcon_contact_topic');
	}
}


/* End of file fastcon_contact_topic.php */
/* Location: ./application/controllers/administrator/Fastcon Contact Topic.php */
