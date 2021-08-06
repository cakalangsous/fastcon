<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Fastcon Member Controller
*| --------------------------------------------------------------------------
*| Fastcon Member site
*|
*/
class Fastcon_member extends Admin
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_fastcon_member');
	}

	/**
	* show all Fastcon Members
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('fastcon_member_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['fastcon_members'] = $this->model_fastcon_member->get($filter, $field, $this->limit_page, $offset);
		$this->data['fastcon_member_counts'] = $this->model_fastcon_member->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/fastcon_member/index/',
			'total_rows'   => $this->model_fastcon_member->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);
		$this->data['datables'] = true;

		$this->template->title('Fastcon Member List');
		$this->render('backend/standart/administrator/fastcon_member/fastcon_member_list', $this->data);
	}

	public function data_ajax()
	{
		$this->is_allowed('fastcon_member_list');
		$fastcon_members = $this->model_fastcon_member->get($_GET['search']['value'], '', $this->input->get('length'), $this->input->get('start'), 0);
		$data = array();
        $no = $this->input->get('draw');


        foreach($fastcon_members as $fastcon_member){
        	$button = '';
        	$row = [];

			
	        $button .= '<a href="'.site_url("administrator/fastcon_member/view/" . $fastcon_member->member_id).'" class="label-default mr-3"><i class="fa fa-newspaper-o" style="padding-right:3px;"></i> '.cclang("view_button").'</a>';

			        	if($this->is_allowed('fastcon_member_delete'))
        	{
		        $button .= '<a href="javascript:void(0);" onclick="delete_this(\''.BASE_URL.'administrator/fastcon_member/delete/'.$fastcon_member->member_id.'\')" class="label-default remove-data"><i class="fa fa-close"></i>'.cclang('remove_button').'</a>';
        	}



	    	$row[] = $fastcon_member->fullname;

	    	$row[] = $fastcon_member->email;

	    	$row[] = $fastcon_member->registered_at;

	    
	        $row[] = $button;
	    	$data[] = $row;
        }

        $output = array(
            "draw" => $this->input->get('draw'),
            "recordsTotal" => $this->model_fastcon_member->count_all(),
            "recordsFiltered" => $this->model_fastcon_member->count_all(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	
	
	
	/**
	* delete Fastcon Members
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('fastcon_member_delete');

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
            set_message(cclang('has_been_deleted', 'fastcon_member'), 'success');
        } else {
            set_message(cclang('error_delete', 'fastcon_member'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Fastcon Members
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('fastcon_member_view');

		$this->data['fastcon_member'] = $this->model_fastcon_member->join_avaiable()->find($id);

		$this->template->title('Fastcon Member Detail');
		$this->render('backend/standart/administrator/fastcon_member/fastcon_member_view', $this->data);
	}
	
	/**
	* delete Fastcon Members
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$fastcon_member = $this->model_fastcon_member->find($id);

		
		
		return $this->model_fastcon_member->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('fastcon_member_export');

		$this->model_fastcon_member->export('fastcon_member', 'fastcon_member');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('fastcon_member_export');

		$this->model_fastcon_member->pdf('fastcon_member', 'fastcon_member');
	}
}


/* End of file fastcon_member.php */
/* Location: ./application/controllers/administrator/Fastcon Member.php */
