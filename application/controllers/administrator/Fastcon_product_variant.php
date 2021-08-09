<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Fastcon Product Variant Controller
*| --------------------------------------------------------------------------
*| Fastcon Product Variant site
*|
*/
class Fastcon_product_variant extends Admin
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_fastcon_product_variant');
	}

	/**
	* show all Fastcon Product Variants
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('fastcon_product_variant_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['fastcon_product_variants'] = $this->model_fastcon_product_variant->get($filter, $field, $this->limit_page, $offset);
		$this->data['fastcon_product_variant_counts'] = $this->model_fastcon_product_variant->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/fastcon_product_variant/index/',
			'total_rows'   => $this->model_fastcon_product_variant->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);
		$this->data['datables'] = true;

		$this->template->title('Product Variant List');
		$this->render('backend/standart/administrator/fastcon_product_variant/fastcon_product_variant_list', $this->data);
	}

	public function data_ajax()
	{
		$this->is_allowed('fastcon_product_variant_list');
		$fastcon_product_variants = $this->model_fastcon_product_variant->get($_GET['search']['value'], '', $this->input->get('length'), $this->input->get('start'), 0);
		$data = array();
        $no = $this->input->get('draw');


        foreach($fastcon_product_variants as $fastcon_product_variant){
        	$button = '';
        	$row = [];

						if($this->is_allowed('fastcon_product_variant_add'))
        	{
		        $button .= '<a href="'.site_url("administrator/fastcon_product_variant/clone_data/" . $fastcon_product_variant->variant_id) .'" class="label-default mr-3"><i class="fa fa-copy"></i> '.cclang('clone').'</a>';
        	}
			
	        $button .= '<a href="'.site_url("administrator/fastcon_product_variant/view/" . $fastcon_product_variant->variant_id).'" class="label-default mr-3"><i class="fa fa-newspaper-o" style="padding-right:3px;"></i> '.cclang("view_button").'</a>';

			        	if($this->is_allowed('fastcon_product_variant_update'))
        	{
		        $button .= '<a href="'.site_url("administrator/fastcon_product_variant/edit/" . $fastcon_product_variant->variant_id) .'" class="label-default mr-3"><i class="fa fa-edit "></i> '.cclang('update_button').'</a>';
        	}
			        	if($this->is_allowed('fastcon_product_variant_delete'))
        	{
		        $button .= '<a href="javascript:void(0);" onclick="delete_this(\''.BASE_URL.'administrator/fastcon_product_variant/delete/'.$fastcon_product_variant->variant_id.'\')" class="label-default remove-data"><i class="fa fa-close"></i>'.cclang('remove_button').'</a>';
        	}



	    			$row[] = $fastcon_product_variant->product_name;
	    			$row[] = $fastcon_product_variant->product_option_name;
	    			$row[] = $fastcon_product_variant->option_value;
	    			$row[] = $fastcon_product_variant->product_option_name;
	    			$row[] = $fastcon_product_variant->option_value;
	    	$row[] = $fastcon_product_variant->sku;

	    	$row[] = $fastcon_product_variant->price;

	    	$row[] = $fastcon_product_variant->discount;

	    
	        $row[] = $button;
	    	$data[] = $row;
        }

        $output = array(
            "draw" => $this->input->get('draw'),
            "recordsTotal" => $this->model_fastcon_product_variant->count_all(),
            "recordsFiltered" => $this->model_fastcon_product_variant->count_all(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	/**
	* Add new fastcon_product_variants
	*
	*/
	public function add()
	{
		$this->is_allowed('fastcon_product_variant_add');

		$this->template->title('Product Variant New');
		$this->render('backend/standart/administrator/fastcon_product_variant/fastcon_product_variant_add', $this->data);
	}

	public function get_option_value()
	{
		$this->is_allowed('fastcon_product_variant_add');

		$arr = $this->input->post();

		$option = db_get_all_data('fastcon_product_option_value', ['product_option_id' => $arr['option']]);

		if (!$option) {
			echo json_encode(['status' => false, 'message' => 'Option value not found']);
			return;
		}

		echo json_encode(['status' => true, 'message' => 'Get option value success', 'data' => $option]);
		return;

	}

	public function get_option2()
	{
		$this->is_allowed('fastcon_product_variant_add');

		$arr = $this->input->post();

		$option2 = db_get_all_data('fastcon_product_option', ['product_type_id !=' => $arr['option1']]);

		if (!$option2) {
			echo json_encode(['status' => false, 'message' => $this->db->last_query()]);
			return;
		}

		echo json_encode(['status' => true, 'message' => 'Get option value success', 'data' => $option2]);
		return;
	}

	public function get_option_text()
	{
		$this->is_allowed('fastcon_product_variant_add');
		
		$arr = $this->input->post();
		$text1 = $this->model_fastcon_product_variant->get_option_text($arr['option_value1']);

		$text2 = false;


		$html = '';
		$j = 0;
		foreach ($text1 as $t1) {
			$html .= '
				<tr>
					<td><input type="checkbox" name="check[]" value="'.$j.'" class="flat-red"></td>
	                <td><input type="hidden" name="product_option1[]" value="'.$t1->product_type_id.'"><input type="hidden" name="product_option_value1[]" value="'.$t1->option_value_id.'">'.$t1->option_value.'</td>
	                <td><input type="text" name="sku[]" class="form-control"></td>
	                <td><input type="number" name="price[]" class="form-control"></td>
	                <td><input type="number" name="discount[]" class="form-control"></td>
                </tr>
			';
			$j++;
		}

		if (isset($arr['option_value2'])) {
			$html = '';
			$text2 = $this->model_fastcon_product_variant->get_option_text($arr['option_value2']);
			$i = 0;
			foreach ($text1 as $t1) {

				foreach ($text2 as $t2) {
					$html .= '
						<tr>
							<td><input type="checkbox" name="check[]" value="'.$i.'" class="flat-red"></td>
			                <td><input type="hidden" name="product_option1[]" value="'.$t1->product_type_id.'"><input type="hidden" name="product_option_value1[]" value="'.$t1->option_value_id.'">'.$t1->option_value.'</td>
			                <td><input type="hidden" name="product_option2[]" value="'.$t2->product_type_id.'"><input type="hidden" name="product_option_value2[]" value="'.$t2->option_value_id.'">'.$t2->option_value.'</td>
			                <td><input type="text" name="sku[]" class="form-control"></td>
			                <td><input type="number" name="price[]" class="form-control"></td>
			                <td><input type="number" name="discount[]" class="form-control"></td>
		                </tr>
					';
					$i++;
				}
			}
		}



		echo $html;
	}

	/**
	* Add New Fastcon Product Variants
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('fastcon_product_variant_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('check[]', 'Please mark the option you want to save', 'trim|required');
		$this->form_validation->set_rules('product_id', 'Product', 'trim|required');
		$this->form_validation->set_rules('product_option1[]', 'Product Option1', 'trim|required');
		$this->form_validation->set_rules('product_option_value1[]', 'Product Option Value1', 'trim|required');
		// $this->form_validation->set_rules('product_option2', 'Product Option2', 'trim|required');
		// $this->form_validation->set_rules('product_option_value2[]', 'Product Option Value2', 'trim|required');
		// $this->form_validation->set_rules('sku[]', 'Sku', 'trim|required');
		// $this->form_validation->set_rules('price[]', 'Price', 'trim|required');
		// $this->form_validation->set_rules('discount[]', 'Discount', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
			echo json_encode($this->data);
			return;
		}

		$arr = $this->input->post();

		// echo '<pre>';
		// print_r($arr);
		// exit;


		// tambah validasi for input checkbox


		$data = [];

		$batch = [];
		for ($i = 0; $i < count($arr['check']); $i++) {
			$batch['product_id']			= $arr['product_id'];
			$batch['product_option1'] 		= $arr['product_option1'][$arr['check'][$i]];
			$batch['product_option_value1'] = $arr['product_option_value1'][$arr['check'][$i]];
			if (isset($arr['product_option2']) AND isset($arr['product_option_value2'])) {
				$batch['product_option2'] 		= $arr['product_option2'][$arr['check'][$i]];
				$batch['product_option_value2'] = $arr['product_option_value2'][$arr['check'][$i]];
			}

			$batch['sku'] 					= $arr['sku'][$arr['check'][$i]];
			$batch['price']					= $arr['price'][$arr['check'][$i]];
			$batch['discount'] 				= $arr['discount'][$arr['check'][$i]];

			array_push($data, $batch);
		}
			
		$save_fastcon_product_variant = $this->model_fastcon_product_variant->insert_batch($data);

		if ($save_fastcon_product_variant) {
			if ($this->input->post('save_type') == 'stay') {
				$this->data['success'] = true;
				$this->data['id'] 	   = $save_fastcon_product_variant;
				$this->data['message'] = cclang('success_save_data_stay', [
					anchor('administrator/fastcon_product_variant/edit/' . $save_fastcon_product_variant, 'Edit Fastcon Product Variant'),
					anchor('administrator/fastcon_product_variant', ' Go back to list')
				]);
			} else {
				set_message(
					cclang('success_save_data_redirect', [
					anchor('administrator/fastcon_product_variant/edit/' . $save_fastcon_product_variant, 'Edit Fastcon Product Variant')
				]), 'success');

        		$this->data['success'] = true;
				$this->data['redirect'] = base_url('administrator/fastcon_product_variant');
			}
		} else {
			if ($this->input->post('save_type') == 'stay') {
				$this->data['success'] = false;
				$this->data['message'] = cclang('data_not_change');
			} else {
        		$this->data['success'] = false;
        		$this->data['message'] = cclang('data_not_change');
				$this->data['redirect'] = base_url('administrator/fastcon_product_variant');
			}
		}

		echo json_encode($this->data);
	}
	
	
	/**
	* Clone data Fastcon Product Variant	*
	*/
	public function clone_data($id=0)
	{
		if($id<=0)
		{
			$this->data['success'] = false;
    		$this->data['message'] = cclang('data_not_found');
			$this->data['redirect'] = base_url('administrator/fastcon_product_variant');
			set_message(cclang('data_not_found'), 'warning');
		}

		$this->is_allowed('fastcon_product_variant_add');

		if($data = db_get_row_data('fastcon_product_variant', ['variant_id' => $id]))
		{
			clone_this_data('fastcon_product_variant', ['variant_id' => $id]);
			$this->data['success'] = true;
    		$this->data['message'] = cclang('data_cloned');
			$this->data['redirect'] = base_url('administrator/fastcon_product_variant');

			set_message(cclang('data_cloned'), 'success');
		}else{
			set_message(cclang('data_not_found'), 'warning');
		}

		redirect('administrator/fastcon_product_variant');

	}

	
		/**
	* Update view Fastcon Product Variants
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('fastcon_product_variant_update');

		$this->data['fastcon_product_variant'] = $this->model_fastcon_product_variant->find($id);

		$this->template->title('Product Variant Update');
		$this->render('backend/standart/administrator/fastcon_product_variant/fastcon_product_variant_update', $this->data);
	}

	/**
	* Update Fastcon Product Variants
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('fastcon_product_variant_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('product_id', 'Product Id', 'trim|required');
		$this->form_validation->set_rules('product_option1', 'Product Option1', 'trim|required');
		$this->form_validation->set_rules('product_option_value1[]', 'Product Option Value1', 'trim|required');
		$this->form_validation->set_rules('product_option2', 'Product Option2', 'trim|required');
		$this->form_validation->set_rules('product_option_value2', 'Product Option Value2', 'trim|required');
		$this->form_validation->set_rules('sku', 'Sku', 'trim|required');
		$this->form_validation->set_rules('price', 'Price', 'trim|required');
		$this->form_validation->set_rules('discount', 'Discount', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'product_id' => $this->input->post('product_id'),
				'product_option1' => $this->input->post('product_option1'),
				'product_option_value1' => implode(',', (array) $this->input->post('product_option_value1')),
				'product_option2' => $this->input->post('product_option2'),
				'product_option_value2' => $this->input->post('product_option_value2'),
				'sku' => $this->input->post('sku'),
				'price' => $this->input->post('price'),
				'discount' => $this->input->post('discount'),
			];

			
			$save_fastcon_product_variant = $this->model_fastcon_product_variant->change($id, $save_data);

			if ($save_fastcon_product_variant) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/fastcon_product_variant', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_product_variant');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_product_variant');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Fastcon Product Variants
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('fastcon_product_variant_delete');

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
            set_message(cclang('has_been_deleted', 'fastcon_product_variant'), 'success');
        } else {
            set_message(cclang('error_delete', 'fastcon_product_variant'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Fastcon Product Variants
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('fastcon_product_variant_view');

		$this->data['fastcon_product_variant'] = $this->model_fastcon_product_variant->join_avaiable()->find($id);

		$this->template->title('Product Variant Detail');
		$this->render('backend/standart/administrator/fastcon_product_variant/fastcon_product_variant_view', $this->data);
	}
	
	/**
	* delete Fastcon Product Variants
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$fastcon_product_variant = $this->model_fastcon_product_variant->find($id);

		
		
		return $this->model_fastcon_product_variant->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('fastcon_product_variant_export');

		$this->model_fastcon_product_variant->export('fastcon_product_variant', 'fastcon_product_variant');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('fastcon_product_variant_export');

		$this->model_fastcon_product_variant->pdf('fastcon_product_variant', 'fastcon_product_variant');
	}
}


/* End of file fastcon_product_variant.php */
/* Location: ./application/controllers/administrator/Fastcon Product Variant.php */
