<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Fastcon Member Address Controller
*| --------------------------------------------------------------------------
*| Fastcon Member Address site
*|
*/
class Fastcon_member_address extends Admin
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_fastcon_member_address');
	}

	/**
	* show all Fastcon Member Addresss
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('fastcon_member_address_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['fastcon_member_addresss'] = $this->model_fastcon_member_address->get($filter, $field, $this->limit_page, $offset);
		$this->data['fastcon_member_address_counts'] = $this->model_fastcon_member_address->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/fastcon_member_address/index/',
			'total_rows'   => $this->model_fastcon_member_address->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);
		$this->data['datables'] = true;

		$this->template->title('Member Address List');
		$this->render('backend/standart/administrator/fastcon_member_address/fastcon_member_address_list', $this->data);
	}

	public function data_ajax()
	{
		$this->is_allowed('fastcon_member_address_list');
		$fastcon_member_addresss = $this->model_fastcon_member_address->get($_GET['search']['value'], '', $this->input->get('length'), $this->input->get('start'), 0);
		$data = array();
        $no = $this->input->get('draw');


        foreach($fastcon_member_addresss as $fastcon_member_address){
        	$button = '';
        	$row = [];

			
	        $button .= '<a href="'.site_url("administrator/fastcon_member_address/view/" . $fastcon_member_address->id).'" class="label-default mr-3"><i class="fa fa-newspaper-o" style="padding-right:3px;"></i> '.cclang("view_button").'</a>';

			        	if($this->is_allowed('fastcon_member_address_delete'))
        	{
		        $button .= '<a href="javascript:void(0);" onclick="delete_this(\''.BASE_URL.'administrator/fastcon_member_address/delete/'.$fastcon_member_address->id.'\')" class="label-default remove-data"><i class="fa fa-close"></i>'.cclang('remove_button').'</a>';
        	}



	    	$row[] = $fastcon_member_address->name;

	    	$row[] = $fastcon_member_address->email;

	    	$row[] = $fastcon_member_address->phone;

	    	$row[] = $fastcon_member_address->provinsi;

	    	$row[] = $fastcon_member_address->kabupaten;

	    	$row[] = $fastcon_member_address->kecamatan;

	    	$row[] = $fastcon_member_address->kelurahan;

	    	$row[] = $fastcon_member_address->kode_pos;

	    	$row[] = $fastcon_member_address->address;

	    			$row[] = $fastcon_member_address->fullname;
	    	$row[] = $fastcon_member_address->active;

	    
	        $row[] = $button;
	    	$data[] = $row;
        }

        $output = array(
            "draw" => $this->input->get('draw'),
            "recordsTotal" => $this->model_fastcon_member_address->count_all(),
            "recordsFiltered" => $this->model_fastcon_member_address->count_all(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	
	
	
	/**
	* delete Fastcon Member Addresss
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('fastcon_member_address_delete');

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
            set_message(cclang('has_been_deleted', 'fastcon_member_address'), 'success');
        } else {
            set_message(cclang('error_delete', 'fastcon_member_address'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Fastcon Member Addresss
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('fastcon_member_address_view');

		$this->data['fastcon_member_address'] = $this->model_fastcon_member_address->join_avaiable()->find($id);

		$this->template->title('Member Address Detail');
		$this->render('backend/standart/administrator/fastcon_member_address/fastcon_member_address_view', $this->data);
	}
	
	/**
	* delete Fastcon Member Addresss
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$fastcon_member_address = $this->model_fastcon_member_address->find($id);

		
		
		return $this->model_fastcon_member_address->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('fastcon_member_address_export');

		$this->model_fastcon_member_address->export('fastcon_member_address', 'fastcon_member_address');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('fastcon_member_address_export');

		$this->model_fastcon_member_address->pdf('fastcon_member_address', 'fastcon_member_address');
	}
}


/* End of file fastcon_member_address.php */
/* Location: ./application/controllers/administrator/Fastcon Member Address.php */
