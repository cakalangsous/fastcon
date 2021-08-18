<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Fastcon Voucher Controller
*| --------------------------------------------------------------------------
*| Fastcon Voucher site
*|
*/
class Fastcon_voucher extends Admin
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_fastcon_voucher');
	}

	/**
	* show all Fastcon Vouchers
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('fastcon_voucher_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['fastcon_vouchers'] = $this->model_fastcon_voucher->get($filter, $field, $this->limit_page, $offset);
		$this->data['fastcon_voucher_counts'] = $this->model_fastcon_voucher->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/fastcon_voucher/index/',
			'total_rows'   => $this->model_fastcon_voucher->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);
		$this->data['datables'] = true;

		$this->template->title('Voucher List');
		$this->render('backend/standart/administrator/fastcon_voucher/fastcon_voucher_list', $this->data);
	}

	public function data_ajax()
	{
		$this->is_allowed('fastcon_voucher_list');
		$fastcon_vouchers = $this->model_fastcon_voucher->get($_GET['search']['value'], '', $this->input->get('length'), $this->input->get('start'), 0);
		$data = array();
        $no = $this->input->get('draw');


        foreach($fastcon_vouchers as $fastcon_voucher){
        	$button = '';
        	$row = [];

			
	        $button .= '<a href="'.site_url("administrator/fastcon_voucher/view/" . $fastcon_voucher->voucher_id).'" class="label-default mr-3"><i class="fa fa-newspaper-o" style="padding-right:3px;"></i> '.cclang("view_button").'</a>';

			        	if($this->is_allowed('fastcon_voucher_update'))
        	{
		        $button .= '<a href="'.site_url("administrator/fastcon_voucher/edit/" . $fastcon_voucher->voucher_id) .'" class="label-default mr-3"><i class="fa fa-edit "></i> '.cclang('update_button').'</a>';
        	}
			        	if($this->is_allowed('fastcon_voucher_delete'))
        	{
		        $button .= '<a href="javascript:void(0);" onclick="delete_this(\''.BASE_URL.'administrator/fastcon_voucher/delete/'.$fastcon_voucher->voucher_id.'\')" class="label-default remove-data"><i class="fa fa-close"></i>'.cclang('remove_button').'</a>';
        	}



	    	$row[] = $fastcon_voucher->voucher_code;

	    	$row[] = $fastcon_voucher->short_desc;

	    	$row[] = substr(strip_tags($fastcon_voucher->voucher_description), 0, 150);

	    	$row[] = substr(strip_tags($fastcon_voucher->voucher_description_en), 0, 150);

	    	$row[] = $fastcon_voucher->voucher_discount;

	    	$row[] = $fastcon_voucher->min_purchase;

	    	$row[] = $fastcon_voucher->start_date;

	    	$row[] = $fastcon_voucher->end_date;

	    	$row[] = $fastcon_voucher->active;

	    	$row[] = $fastcon_voucher->created;

	    
	        $row[] = $button;
	    	$data[] = $row;
        }

        $output = array(
            "draw" => $this->input->get('draw'),
            "recordsTotal" => $this->model_fastcon_voucher->count_all(),
            "recordsFiltered" => $this->model_fastcon_voucher->count_all(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	/**
	* Add new fastcon_vouchers
	*
	*/
	public function add()
	{
		$this->is_allowed('fastcon_voucher_add');

		$this->template->title('Voucher New');
		$this->render('backend/standart/administrator/fastcon_voucher/fastcon_voucher_add', $this->data);
	}

	/**
	* Add New Fastcon Vouchers
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('fastcon_voucher_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('voucher_code', 'Voucher Code', 'trim|required');
		$this->form_validation->set_rules('short_desc', 'Short Desc', 'trim|required');
		$this->form_validation->set_rules('voucher_description', 'Voucher Description', 'trim|required');
		$this->form_validation->set_rules('voucher_description_en', 'Voucher Description En', 'trim|required');
		$this->form_validation->set_rules('voucher_discount', 'Voucher Discount', 'trim|required');
		$this->form_validation->set_rules('min_purchase', 'Min Purchase', 'trim|required');
		$this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
		$this->form_validation->set_rules('end_date', 'End Date', 'trim|required');
		$this->form_validation->set_rules('active', 'Active', 'trim|required');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
				'voucher_code' => $this->input->post('voucher_code'),
				'short_desc' => $this->input->post('short_desc'),
				'voucher_description' => $this->input->post('voucher_description'),
				'voucher_description_en' => $this->input->post('voucher_description_en'),
				'voucher_discount' => $this->input->post('voucher_discount'),
				'min_purchase' => $this->input->post('min_purchase'),
				'start_date' => $this->input->post('start_date'),
				'end_date' => $this->input->post('end_date'),
				'active' => $this->input->post('active'),
			];

			
			$save_fastcon_voucher = $this->model_fastcon_voucher->store($save_data);

			if ($save_fastcon_voucher) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_fastcon_voucher;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/fastcon_voucher/edit/' . $save_fastcon_voucher, 'Edit Fastcon Voucher'),
						anchor('administrator/fastcon_voucher', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/fastcon_voucher/edit/' . $save_fastcon_voucher, 'Edit Fastcon Voucher')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_voucher');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_voucher');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	
		/**
	* Update view Fastcon Vouchers
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('fastcon_voucher_update');

		$this->data['fastcon_voucher'] = $this->model_fastcon_voucher->find($id);

		$this->template->title('Voucher Update');
		$this->render('backend/standart/administrator/fastcon_voucher/fastcon_voucher_update', $this->data);
	}

	/**
	* Update Fastcon Vouchers
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('fastcon_voucher_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('voucher_code', 'Voucher Code', 'trim|required');
		$this->form_validation->set_rules('short_desc', 'Short Desc', 'trim|required');
		$this->form_validation->set_rules('voucher_description', 'Voucher Description', 'trim|required');
		$this->form_validation->set_rules('voucher_description_en', 'Voucher Description En', 'trim|required');
		$this->form_validation->set_rules('voucher_discount', 'Voucher Discount', 'trim|required');
		$this->form_validation->set_rules('min_purchase', 'Min Purchase', 'trim|required');
		$this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
		$this->form_validation->set_rules('end_date', 'End Date', 'trim|required');
		$this->form_validation->set_rules('active', 'Active', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'voucher_code' => $this->input->post('voucher_code'),
				'short_desc' => $this->input->post('short_desc'),
				'voucher_description' => $this->input->post('voucher_description'),
				'voucher_description_en' => $this->input->post('voucher_description_en'),
				'voucher_discount' => $this->input->post('voucher_discount'),
				'min_purchase' => $this->input->post('min_purchase'),
				'start_date' => $this->input->post('start_date'),
				'end_date' => $this->input->post('end_date'),
				'active' => $this->input->post('active'),
			];

			
			$save_fastcon_voucher = $this->model_fastcon_voucher->change($id, $save_data);

			if ($save_fastcon_voucher) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/fastcon_voucher', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_voucher');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_voucher');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Fastcon Vouchers
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('fastcon_voucher_delete');

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
            set_message(cclang('has_been_deleted', 'fastcon_voucher'), 'success');
        } else {
            set_message(cclang('error_delete', 'fastcon_voucher'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Fastcon Vouchers
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('fastcon_voucher_view');

		$this->data['fastcon_voucher'] = $this->model_fastcon_voucher->join_avaiable()->find($id);

		$this->template->title('Voucher Detail');
		$this->render('backend/standart/administrator/fastcon_voucher/fastcon_voucher_view', $this->data);
	}
	
	/**
	* delete Fastcon Vouchers
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$fastcon_voucher = $this->model_fastcon_voucher->find($id);

		
		
		return $this->model_fastcon_voucher->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('fastcon_voucher_export');

		$this->model_fastcon_voucher->export('fastcon_voucher', 'fastcon_voucher');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('fastcon_voucher_export');

		$this->model_fastcon_voucher->pdf('fastcon_voucher', 'fastcon_voucher');
	}
}


/* End of file fastcon_voucher.php */
/* Location: ./application/controllers/administrator/Fastcon Voucher.php */
