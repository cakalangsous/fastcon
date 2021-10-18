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

		$this->template->title('Transactions List');
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

			
	        // $button .= '<a href="'.site_url("administrator/fastcon_product_orders/view/" . $fastcon_product_orders->order_id).'" class="label-default mr-3"><i class="fa fa-newspaper-o" style="padding-right:3px;"></i> '.cclang("view_button").'</a>';

			      //   	if($this->is_allowed('fastcon_product_orders_delete'))
        	// {
		       //  $button .= '<a href="javascript:void(0);" onclick="delete_this(\''.BASE_URL.'administrator/fastcon_product_orders/delete/'.$fastcon_product_orders->order_id.'\')" class="label-default remove-data"><i class="fa fa-close"></i>'.cclang('remove_button').'</a>';
        	// }

        	$show_to_admin = '';
        	switch ($fastcon_product_orders->order_status) {

        		case 2:
        			$show_to_admin = '<label class="label label-primary mr-3" style="font-size:1.3rem; font-weight:400;"> '.lang('payment_received').' </label> ';
        			break;

        		case 3:
        			$show_to_admin = '<label class="label label-success mr-3" style="font-size:1.3rem; font-weight:400;"> '.lang('sent').' </label>';
        			break;

        		case 4:
        			$show_to_admin = '<label class="label label-danger mr-3" style="font-size:1.3rem; font-weight:400;"> '.lang('cancelled').' </label>';
        			break;
        		
        		default:
        			$show_to_admin = '<label class="label label-warning mr-3" style="font-size:1.3rem; font-weight:400;"> '.lang('new_order').' </label>';
        			break;
        	}

	    	$row[] = '<a href="javascript:void(0)" class="order-details-btn" data-order="'.$fastcon_product_orders->order_code.'">'.$fastcon_product_orders->order_code.'</a>';

	    	$row[] = $show_to_admin;

	    	$row[] = $fastcon_product_orders->order_status == 2 ? '<button type="button" class="btn btn-success send-btn" data-order="'.$fastcon_product_orders->order_code.'">Send This Order</button>' : '';

	    	$row[] = $fastcon_product_orders->payer_name;

	    	$row[] = $fastcon_product_orders->payer_email;

	    	$row[] = $fastcon_product_orders->no_telp;

	    	$row[] = $fastcon_product_orders->courier_name;

	    	$row[] = $fastcon_product_orders->courier_phone;

	    	$row[] = date('F j, Y H:i:s', strtotime($fastcon_product_orders->created));

	    
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

		$this->template->title('Transactions Detail');
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

	public function send_order()
	{
		if (!$this->is_allowed('fastcon_product_orders_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'You do not have permission to access'
				]);
			exit;
		}

		if (!$this->input->is_ajax_request()) {
			echo json_encode([
				'success' => false,
				'message' => 'Unknown Request'
				]);
			exit;
		}

		$arr = $this->input->post();

		if (!$order = db_get_row_data('fastcon_product_orders', ['order_code' => $arr['order_code']] )) {
			echo json_encode([
				'success' => false,
				'message' => 'Unknown Request'
				]);
			exit;
		}

		$data_to_update = [
			'order_status' => 3,
			'status' => 'SENT',
			'courier_name' => $arr['courier_name'],
			'courier_phone' => $arr['courier_phone']
		];

		update_this_data('fastcon_product_orders', ['order_code' => $arr['order_code']], $data_to_update);

		$order = db_get_row_data('fastcon_product_orders', ['order_code' => $arr['order_code']] );

		// send email to customer by fastcon mailing
		$market_place = db_get_all_data('fastcon_marketplace');
        $contact_settings = db_get_all_data('fastcon_contact_settings');
        $lang = $this->session->userdata('fastcon_lang');

		$info['title']		= lang('order_sent_title');
		$info['caption']	= lang('order_sent_email');
		$info['marketplace']= $market_place;
		$info['contact_settings']	= $contact_settings;
		$info['lang'] = $lang;
		$info['cart'] = db_get_all_data('fastcon_product_orders', ['order_code' => $arr['order_code']]);
		$info['order_details'] = $order;

		$html = $this->load->view('email/index', $info, true);

		$this->load->library('email');

		$this->email->initialize($this->mail_config());
		$this->email->set_newline("\r\n");
		$this->email->from(getenv('EMAIL_SENDER'), getenv('SENDER_NAME'));
		$this->email->to($order->payer_email);
		$this->email->subject('Fastcon - '.lang('order_sent_title'));
		$this->email->message($html);
		
		$this->email->send();


		echo json_encode([
			'success' => true,
			'message' => 'Action completed successfully'
		]);

		return;
	}

	public function order_details()
	{
		if (!$this->input->is_ajax_request()) {
			echo json_encode([
				'success' => false,
				'message' => 'Unknown Request'
				]);
			exit;
		}

		$this->is_allowed('fastcon_product_orders_view');

		$arr = $this->input->post();

		if (!$order = db_get_all_data('fastcon_product_orders', ['order_code' => $arr['order_code']])) {
			echo json_encode([
				'success' => false,
				'message' => 'Unknown Request'
				]);
			exit;
		}

		$order_details = db_get_row_data('fastcon_product_orders', ['order_code' => $arr['order_code']]);

		echo json_encode(['success' => true, 'message' => 'Order found!', 'order' => $order, 'order_details' => $order_details]);
		return;
	}
}


/* End of file fastcon_product_orders.php */
/* Location: ./application/controllers/administrator/Fastcon Product Orders.php */
