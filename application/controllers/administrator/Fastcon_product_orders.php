<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Fastcon Product Orders Controller
*| --------------------------------------------------------------------------
*| Fastcon Product Orders site
*|
*/
class Fastcon_product_orders extends Admin
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_fastcon_product_orders');
	}

	/**
	* show all Fastcon Product Orderss
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('fastcon_product_orders_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['fastcon_product_orderss'] = $this->model_fastcon_product_orders->get($filter, $field, $this->limit_page, $offset);
		$this->data['fastcon_product_orders_counts'] = $this->model_fastcon_product_orders->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/fastcon_product_orders/index/',
			'total_rows'   => $this->model_fastcon_product_orders->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);
		$this->data['datables'] = true;

		$this->template->title('Orders List');
		$this->render('backend/standart/administrator/fastcon_product_orders/fastcon_product_orders_list', $this->data);
	}

	public function data_ajax()
	{
		$this->is_allowed('fastcon_product_orders_list');
		$fastcon_product_orderss = $this->model_fastcon_product_orders->get($_GET['search']['value'], '', $this->input->get('length'), $this->input->get('start'), 0);
		$data = array();
        $no = $this->input->get('draw');


        foreach($fastcon_product_orderss as $fastcon_product_orders){
        	$button = '';
        	$row = [];

			
	        $button .= '<a href="'.site_url("administrator/fastcon_product_orders/view/" . $fastcon_product_orders->order_id).'" class="label-default mr-3"><i class="fa fa-newspaper-o" style="padding-right:3px;"></i> '.cclang("view_button").'</a>';

			        	if($this->is_allowed('fastcon_product_orders_delete'))
        	{
		        $button .= '<a href="javascript:void(0);" onclick="delete_this(\''.BASE_URL.'administrator/fastcon_product_orders/delete/'.$fastcon_product_orders->order_id.'\')" class="label-default remove-data"><i class="fa fa-close"></i>'.cclang('remove_button').'</a>';
        	}



	    	$row[] = $fastcon_product_orders->order_code;

	    	$row[] = $fastcon_product_orders->order_status;

	    	$row[] = $fastcon_product_orders->member_id;

	    	$row[] = $fastcon_product_orders->guest_id;

	    	$row[] = $fastcon_product_orders->product_category_id;

	    	$row[] = $fastcon_product_orders->product_category_name;

	    	$row[] = $fastcon_product_orders->product_category_name_en;

	    	$row[] = $fastcon_product_orders->product_id;

	    	$row[] = $fastcon_product_orders->product_name;

	    	if (!empty($fastcon_product_orders->product_images)){
                if (is_image($fastcon_product_orders->product_images)){
	                $row[] = '<a class="fancybox" rel="group" href="'.BASE_URL . 'uploads/fastcon_product_orders/'. $fastcon_product_orders->product_images.'">
	                            <img src="'.BASE_URL . 'uploads/fastcon_product_orders/' . $fastcon_product_orders->product_images.'" class="image-responsive" alt="image fastcon_product_orders" title="product_images fastcon_product_orders" width="40px">
	                        </a>';
                }else{
	                $row[] =  '<a href="'.BASE_URL . 'administrator/file/download/fastcon_product_orders/' . $fastcon_product_orders->product_images.'">
	                       <img src="'.get_icon_file($fastcon_product_orders->product_images).'" class="image-responsive image-icon" alt="image fastcon_product_orders" title="product_images fastcon_product_orders" width="40px">
	                     </a>';
                }
            }else{
				$row[] = null;
			}
	    	$row[] = $fastcon_product_orders->variant_id;

	    	$row[] = $fastcon_product_orders->sku;

	    	$row[] = $fastcon_product_orders->product_option1_id;

	    	$row[] = $fastcon_product_orders->product_option1_name;

	    	$row[] = $fastcon_product_orders->product_option1_name_en;

	    	$row[] = $fastcon_product_orders->product_option1_value_id;

	    	$row[] = $fastcon_product_orders->product_option1_value;

	    	$row[] = $fastcon_product_orders->product_option2_id;

	    	$row[] = $fastcon_product_orders->product_option2_name;

	    	$row[] = $fastcon_product_orders->product_option2_name_en;

	    	$row[] = $fastcon_product_orders->product_option2_value_id;

	    	$row[] = $fastcon_product_orders->product_option2_value;

	    	$row[] = $fastcon_product_orders->price;

	    	$row[] = $fastcon_product_orders->discount;

	    	$row[] = $fastcon_product_orders->qty;

	    	$row[] = $fastcon_product_orders->subtotal;

	    	$row[] = $fastcon_product_orders->shipping_cost;

	    	$row[] = $fastcon_product_orders->total;

	    	$row[] = $fastcon_product_orders->voucher_id;

	    	$row[] = $fastcon_product_orders->voucher_code;

	    	$row[] = $fastcon_product_orders->voucher_discount;

	    	$row[] = $fastcon_product_orders->voucher_start_date;

	    	$row[] = $fastcon_product_orders->voucher_end_date;

	    	$row[] = $fastcon_product_orders->member_address_id;

	    	$row[] = $fastcon_product_orders->nama_penerima;

	    	$row[] = $fastcon_product_orders->email;

	    	$row[] = $fastcon_product_orders->no_telp;

	    	$row[] = $fastcon_product_orders->province_id;

	    	$row[] = $fastcon_product_orders->province_name;

	    	$row[] = $fastcon_product_orders->provinsi;

	    	$row[] = $fastcon_product_orders->kabupaten;

	    	$row[] = $fastcon_product_orders->kecamatan;

	    	$row[] = $fastcon_product_orders->kelurahan;

	    	$row[] = $fastcon_product_orders->kode_pos;

	    	$row[] = $fastcon_product_orders->alamat_lengkap;

	    	$row[] = $fastcon_product_orders->courier_name;

	    	$row[] = $fastcon_product_orders->courier_phone;

	    	$row[] = $fastcon_product_orders->payment_type;

	    	$row[] = $fastcon_product_orders->fraud_status;

	    	$row[] = $fastcon_product_orders->status_message;

	    	$row[] = $fastcon_product_orders->transaction_id;

	    	$row[] = $fastcon_product_orders->transaction_time;

	    	$row[] = $fastcon_product_orders->va_numbers;

	    	$row[] = $fastcon_product_orders->midtrans_bill_code;

	    	$row[] = $fastcon_product_orders->midtrans_bill_key;

	    	$row[] = $fastcon_product_orders->transaction_status;

	    	$row[] = $fastcon_product_orders->pdf_url;

	    	$row[] = $fastcon_product_orders->midtrans_response;

	    	$row[] = $fastcon_product_orders->created;

	    
	        $row[] = $button;
	    	$data[] = $row;
        }

        $output = array(
            "draw" => $this->input->get('draw'),
            "recordsTotal" => $this->model_fastcon_product_orders->count_all(),
            "recordsFiltered" => $this->model_fastcon_product_orders->count_all(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	
	
	
	/**
	* delete Fastcon Product Orderss
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('fastcon_product_orders_delete');

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
            set_message(cclang('has_been_deleted', 'fastcon_product_orders'), 'success');
        } else {
            set_message(cclang('error_delete', 'fastcon_product_orders'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Fastcon Product Orderss
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('fastcon_product_orders_view');

		$this->data['fastcon_product_orders'] = $this->model_fastcon_product_orders->join_avaiable()->find($id);

		$this->template->title('Orders Detail');
		$this->render('backend/standart/administrator/fastcon_product_orders/fastcon_product_orders_view', $this->data);
	}
	
	/**
	* delete Fastcon Product Orderss
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$fastcon_product_orders = $this->model_fastcon_product_orders->find($id);

		if (!empty($fastcon_product_orders->product_images)) {
			$path = FCPATH . '/uploads/fastcon_product_orders/' . $fastcon_product_orders->product_images;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}
		
		
		return $this->model_fastcon_product_orders->remove($id);
	}
	
	/**
	* Upload Image Fastcon Product Orders	*
	* @return JSON
	*/
	public function upload_product_images_file()
	{
		if (!$this->is_allowed('fastcon_product_orders_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'fastcon_product_orders',
		]);
	}

	/**
	* Delete Image Fastcon Product Orders	*
	* @return JSON
	*/
	public function delete_product_images_file($uuid)
	{
		if (!$this->is_allowed('fastcon_product_orders_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid,
            'delete_by'         => $this->input->get('by'),
            'field_name'        => 'product_images',
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'fastcon_product_orders',
            'primary_key'       => 'order_id',
            'upload_path'       => 'uploads/fastcon_product_orders/'
        ]);
	}

	/**
	* Get Image Fastcon Product Orders	*
	* @return JSON
	*/
	public function get_product_images_file($id)
	{
		if (!$this->is_allowed('fastcon_product_orders_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$fastcon_product_orders = $this->model_fastcon_product_orders->find($id);

		echo $this->get_file([
            'uuid'              => $id,
            'delete_by'         => 'id',
            'field_name'        => 'product_images',
            'table_name'        => 'fastcon_product_orders',
            'primary_key'       => 'order_id',
            'upload_path'       => 'uploads/fastcon_product_orders/',
            'delete_endpoint'   => 'administrator/fastcon_product_orders/delete_product_images_file'
        ]);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('fastcon_product_orders_export');

		$this->model_fastcon_product_orders->export('fastcon_product_orders', 'fastcon_product_orders');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('fastcon_product_orders_export');

		$this->model_fastcon_product_orders->pdf('fastcon_product_orders', 'fastcon_product_orders');
	}
}


/* End of file fastcon_product_orders.php */
/* Location: ./application/controllers/administrator/Fastcon Product Orders.php */
