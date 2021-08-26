<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_fastcon_product_orders extends MY_Model {

	private $primary_key 	= 'order_id';
	private $table_name 	= 'fastcon_product_orders';
	private $field_search 	= ['order_code', 'order_status', 'member_id', 'guest_id', 'product_category_id', 'product_category_name', 'product_category_name_en', 'product_id', 'product_name', 'product_images', 'variant_id', 'sku', 'product_option1_id', 'product_option1_name', 'product_option1_name_en', 'product_option1_value_id', 'product_option1_value', 'product_option2_id', 'product_option2_name', 'product_option2_name_en', 'product_option2_value_id', 'product_option2_value', 'price', 'discount', 'qty', 'subtotal', 'shipping_cost', 'total', 'voucher_id', 'voucher_code', 'voucher_discount', 'voucher_start_date', 'voucher_end_date', 'member_address_id', 'nama_penerima', 'email', 'no_telp', 'province_id', 'province_name', 'provinsi', 'kabupaten', 'kecamatan', 'kelurahan', 'kode_pos', 'alamat_lengkap', 'courier_name', 'courier_phone', 'payment_type', 'fraud_status', 'status_message', 'transaction_id', 'transaction_time', 'va_numbers', 'midtrans_bill_code', 'midtrans_bill_key', 'transaction_status', 'pdf_url', 'midtrans_response', 'created'];

	public function __construct()
	{
		$config = array(
			'primary_key' 	=> $this->primary_key,
		 	'table_name' 	=> $this->table_name,
		 	'field_search' 	=> $this->field_search,
		 );

		parent::__construct($config);
	}

	public function count_all($q = null, $field = null)
	{
		$iterasi = 1;
        $num = count($this->field_search);
        $where = NULL;
        $q = $this->scurity($q);
		$field = $this->scurity($field);

        if (empty($field)) {
	        foreach ($this->field_search as $field) {
	            if ($iterasi == 1) {
	                $where .= "fastcon_product_orders.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "fastcon_product_orders.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "fastcon_product_orders.".$field . " LIKE '%" . $q . "%' )";
        }

		$this->join_avaiable();
        $this->db->where($where);
		$query = $this->db->get($this->table_name);

		return $query->num_rows();
	}

	public function get($q = null, $field = null, $limit = 0, $offset = 0, $select_field = [])
	{
		$iterasi = 1;
        $num = count($this->field_search);
        $where = NULL;
        $q = $this->scurity($q);
		$field = $this->scurity($field);

        if (empty($field)) {
	        foreach ($this->field_search as $field) {
	            if ($iterasi == 1) {
	                $where .= "fastcon_product_orders.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "fastcon_product_orders.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "fastcon_product_orders.".$field . " LIKE '%" . $q . "%' )";
        }

        if (is_array($select_field) AND count($select_field)) {
        	$this->db->select($select_field);
        }
		
		$this->join_avaiable();
        $this->db->where($where);
        $this->db->limit($limit, $offset);
	    $this->db->order_by('fastcon_product_orders.'.$this->primary_key, "DESC");
        if (isset($_GET['order'])) {
        	$this->db->order_by($_GET['order']['0']['column']==0?$this->primary_key:$_GET['order']['0']['column'], $_GET['order']['0']['dir']);
        }else{
		    $this->db->order_by('fastcon_product_orders.'.$this->primary_key, "DESC");
        }
		$query = $this->db->get($this->table_name);

		return $query->result();
	}

	public function join_avaiable() {
		
    	return $this;
	}

}

/* End of file Model_fastcon_product_orders.php */
/* Location: ./application/models/Model_fastcon_product_orders.php */