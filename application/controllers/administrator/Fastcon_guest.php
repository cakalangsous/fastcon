<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Fastcon Guest Controller
*| --------------------------------------------------------------------------
*| Fastcon Guest site
*|
*/
class Fastcon_guest extends Admin
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_fastcon_guest');
	}

	/**
	* show all Fastcon Guests
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('fastcon_guest_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['fastcon_guests'] = $this->model_fastcon_guest->get($filter, $field, $this->limit_page, $offset);
		$this->data['fastcon_guest_counts'] = $this->model_fastcon_guest->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/fastcon_guest/index/',
			'total_rows'   => $this->model_fastcon_guest->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);
		$this->data['datables'] = true;

		$this->template->title('Guest List');
		$this->render('backend/standart/administrator/fastcon_guest/fastcon_guest_list', $this->data);
	}

	public function data_ajax()
	{
		$this->is_allowed('fastcon_guest_list');
		$fastcon_guests = $this->model_fastcon_guest->get($_GET['search']['value'], '', $this->input->get('length'), $this->input->get('start'), 0);
		$data = array();
        $no = $this->input->get('draw');


        foreach($fastcon_guests as $fastcon_guest){
        	$button = '';
        	$row = [];

			
	        $button .= '<a href="'.site_url("administrator/fastcon_guest/view/" . $fastcon_guest->guest_id).'" class="label-default mr-3"><i class="fa fa-newspaper-o" style="padding-right:3px;"></i> '.cclang("view_button").'</a>';

			        	if($this->is_allowed('fastcon_guest_delete'))
        	{
		        $button .= '<a href="javascript:void(0);" onclick="delete_this(\''.BASE_URL.'administrator/fastcon_guest/delete/'.$fastcon_guest->guest_id.'\')" class="label-default remove-data"><i class="fa fa-close"></i>'.cclang('remove_button').'</a>';
        	}



	    	$row[] = $fastcon_guest->fullname;

	    	$row[] = $fastcon_guest->email;

	    	$row[] = $fastcon_guest->phone;

	    	$row[] = $fastcon_guest->created_at;

	    
	        $row[] = $button;
	    	$data[] = $row;
        }

        $output = array(
            "draw" => $this->input->get('draw'),
            "recordsTotal" => $this->model_fastcon_guest->count_all(),
            "recordsFiltered" => $this->model_fastcon_guest->count_all(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	
	
	
	/**
	* delete Fastcon Guests
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('fastcon_guest_delete');

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
            set_message(cclang('has_been_deleted', 'fastcon_guest'), 'success');
        } else {
            set_message(cclang('error_delete', 'fastcon_guest'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Fastcon Guests
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('fastcon_guest_view');

		$this->data['fastcon_guest'] = $this->model_fastcon_guest->join_avaiable()->find($id);

		$this->template->title('Guest Detail');
		$this->render('backend/standart/administrator/fastcon_guest/fastcon_guest_view', $this->data);
	}
	
	/**
	* delete Fastcon Guests
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$fastcon_guest = $this->model_fastcon_guest->find($id);

		
		
		return $this->model_fastcon_guest->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('fastcon_guest_export');

		$this->model_fastcon_guest->export('fastcon_guest', 'fastcon_guest');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('fastcon_guest_export');

		$this->model_fastcon_guest->pdf('fastcon_guest', 'fastcon_guest');
	}
}


/* End of file fastcon_guest.php */
/* Location: ./application/controllers/administrator/Fastcon Guest.php */
