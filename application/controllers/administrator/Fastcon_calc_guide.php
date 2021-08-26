<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Fastcon Calc Guide Controller
*| --------------------------------------------------------------------------
*| Fastcon Calc Guide site
*|
*/
class Fastcon_calc_guide extends Admin
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_fastcon_calc_guide');
	}

	/**
	* show all Fastcon Calc Guides
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('fastcon_calc_guide_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['fastcon_calc_guides'] = $this->model_fastcon_calc_guide->get($filter, $field, $this->limit_page, $offset);
		$this->data['fastcon_calc_guide_counts'] = $this->model_fastcon_calc_guide->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/fastcon_calc_guide/index/',
			'total_rows'   => $this->model_fastcon_calc_guide->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);
		$this->data['datables'] = true;

		$this->template->title('AAC Calculator Guide List');
		$this->render('backend/standart/administrator/fastcon_calc_guide/fastcon_calc_guide_list', $this->data);
	}

	public function data_ajax()
	{
		$this->is_allowed('fastcon_calc_guide_list');
		$fastcon_calc_guides = $this->model_fastcon_calc_guide->get($_GET['search']['value'], '', $this->input->get('length'), $this->input->get('start'), 0);
		$data = array();
        $no = $this->input->get('draw');


        foreach($fastcon_calc_guides as $fastcon_calc_guide){
        	$button = '';
        	$row = [];

			
	        $button .= '<a href="'.site_url("administrator/fastcon_calc_guide/view/" . $fastcon_calc_guide->id).'" class="label-default mr-3"><i class="fa fa-newspaper-o" style="padding-right:3px;"></i> '.cclang("view_button").'</a>';

			        	if($this->is_allowed('fastcon_calc_guide_update'))
        	{
		        $button .= '<a href="'.site_url("administrator/fastcon_calc_guide/edit/" . $fastcon_calc_guide->id) .'" class="label-default mr-3"><i class="fa fa-edit "></i> '.cclang('update_button').'</a>';
        	}
			      //   	if($this->is_allowed('fastcon_calc_guide_delete'))
        	// {
		       //  $button .= '<a href="javascript:void(0);" onclick="delete_this(\''.BASE_URL.'administrator/fastcon_calc_guide/delete/'.$fastcon_calc_guide->id.'\')" class="label-default remove-data"><i class="fa fa-close"></i>'.cclang('remove_button').'</a>';
        	// }



	    	$row[] = $fastcon_calc_guide->guide;

	    	$row[] = $fastcon_calc_guide->guide_en;

	    
	        $row[] = $button;
	    	$data[] = $row;
        }

        $output = array(
            "draw" => $this->input->get('draw'),
            "recordsTotal" => $this->model_fastcon_calc_guide->count_all(),
            "recordsFiltered" => $this->model_fastcon_calc_guide->count_all(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	
	
		/**
	* Update view Fastcon Calc Guides
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('fastcon_calc_guide_update');

		$this->data['fastcon_calc_guide'] = $this->model_fastcon_calc_guide->find($id);

		$this->template->title('AAC Calculator Guide Update');
		$this->render('backend/standart/administrator/fastcon_calc_guide/fastcon_calc_guide_update', $this->data);
	}

	/**
	* Update Fastcon Calc Guides
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('fastcon_calc_guide_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('guide', 'Guide', 'trim|required');
		$this->form_validation->set_rules('guide_en', 'Guide En', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'guide' => $this->input->post('guide'),
				'guide_en' => $this->input->post('guide_en'),
			];

			
			$save_fastcon_calc_guide = $this->model_fastcon_calc_guide->change($id, $save_data);

			if ($save_fastcon_calc_guide) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/fastcon_calc_guide', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_calc_guide');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_calc_guide');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Fastcon Calc Guides
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('fastcon_calc_guide_delete');

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
            set_message(cclang('has_been_deleted', 'fastcon_calc_guide'), 'success');
        } else {
            set_message(cclang('error_delete', 'fastcon_calc_guide'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Fastcon Calc Guides
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('fastcon_calc_guide_view');

		$this->data['fastcon_calc_guide'] = $this->model_fastcon_calc_guide->join_avaiable()->find($id);

		$this->template->title('AAC Calculator Guide Detail');
		$this->render('backend/standart/administrator/fastcon_calc_guide/fastcon_calc_guide_view', $this->data);
	}
	
	/**
	* delete Fastcon Calc Guides
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$fastcon_calc_guide = $this->model_fastcon_calc_guide->find($id);

		
		
		return $this->model_fastcon_calc_guide->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('fastcon_calc_guide_export');

		$this->model_fastcon_calc_guide->export('fastcon_calc_guide', 'fastcon_calc_guide');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('fastcon_calc_guide_export');

		$this->model_fastcon_calc_guide->pdf('fastcon_calc_guide', 'fastcon_calc_guide');
	}
}


/* End of file fastcon_calc_guide.php */
/* Location: ./application/controllers/administrator/Fastcon Calc Guide.php */
