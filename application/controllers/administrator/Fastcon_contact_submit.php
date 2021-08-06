<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Fastcon Contact Submit Controller
*| --------------------------------------------------------------------------
*| Fastcon Contact Submit site
*|
*/
class Fastcon_contact_submit extends Admin
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_fastcon_contact_submit');
	}

	/**
	* show all Fastcon Contact Submits
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('fastcon_contact_submit_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['fastcon_contact_submits'] = $this->model_fastcon_contact_submit->get($filter, $field, $this->limit_page, $offset);
		$this->data['fastcon_contact_submit_counts'] = $this->model_fastcon_contact_submit->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/fastcon_contact_submit/index/',
			'total_rows'   => $this->model_fastcon_contact_submit->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);
		$this->data['datables'] = true;

		$this->template->title('Contact Submit List');
		$this->render('backend/standart/administrator/fastcon_contact_submit/fastcon_contact_submit_list', $this->data);
	}

	public function data_ajax()
	{
		$this->is_allowed('fastcon_contact_submit_list');
		$fastcon_contact_submits = $this->model_fastcon_contact_submit->get($_GET['search']['value'], '', $this->input->get('length'), $this->input->get('start'), 0);
		$data = array();
        $no = $this->input->get('draw');


        foreach($fastcon_contact_submits as $fastcon_contact_submit){
        	$button = '';
        	$row = [];

			
	        $button .= '<a href="'.site_url("administrator/fastcon_contact_submit/view/" . $fastcon_contact_submit->id).'" class="label-default mr-3"><i class="fa fa-newspaper-o" style="padding-right:3px;"></i> '.cclang("view_button").'</a>';

			        	if($this->is_allowed('fastcon_contact_submit_delete'))
        	{
		        $button .= '<a href="javascript:void(0);" onclick="delete_this(\''.BASE_URL.'administrator/fastcon_contact_submit/delete/'.$fastcon_contact_submit->id.'\')" class="label-default remove-data"><i class="fa fa-close"></i>'.cclang('remove_button').'</a>';
        	}



	    	$row[] = $fastcon_contact_submit->name;

	    	$row[] = $fastcon_contact_submit->email;

	    	$row[] = $fastcon_contact_submit->phone;

	    			$row[] = $fastcon_contact_submit->topic_name;
	    	$row[] = $fastcon_contact_submit->message;

	    	$row[] = $fastcon_contact_submit->ip_address;

	    	$row[] = $fastcon_contact_submit->created_at;

	    
	        $row[] = $button;
	    	$data[] = $row;
        }

        $output = array(
            "draw" => $this->input->get('draw'),
            "recordsTotal" => $this->model_fastcon_contact_submit->count_all(),
            "recordsFiltered" => $this->model_fastcon_contact_submit->count_all(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	
	
	
	/**
	* delete Fastcon Contact Submits
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('fastcon_contact_submit_delete');

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
            set_message(cclang('has_been_deleted', 'fastcon_contact_submit'), 'success');
        } else {
            set_message(cclang('error_delete', 'fastcon_contact_submit'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Fastcon Contact Submits
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('fastcon_contact_submit_view');

		$this->data['fastcon_contact_submit'] = $this->model_fastcon_contact_submit->join_avaiable()->find($id);

		$this->template->title('Contact Submit Detail');
		$this->render('backend/standart/administrator/fastcon_contact_submit/fastcon_contact_submit_view', $this->data);
	}
	
	/**
	* delete Fastcon Contact Submits
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$fastcon_contact_submit = $this->model_fastcon_contact_submit->find($id);

		
		
		return $this->model_fastcon_contact_submit->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('fastcon_contact_submit_export');

		$this->model_fastcon_contact_submit->export('fastcon_contact_submit', 'fastcon_contact_submit');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('fastcon_contact_submit_export');

		$this->model_fastcon_contact_submit->pdf('fastcon_contact_submit', 'fastcon_contact_submit');
	}
}


/* End of file fastcon_contact_submit.php */
/* Location: ./application/controllers/administrator/Fastcon Contact Submit.php */
