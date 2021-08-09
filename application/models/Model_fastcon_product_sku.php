<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_fastcon_product_sku extends MY_Model {

	private $primary_key 	= 'sku_id';
	private $table_name 	= 'fastcon_product_sku';
	private $field_search 	= ['product_id', 'sku', 'product_option1', 'product_option_value1', 'product_option2', 'product_option_value2', 'price', 'discount'];

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
	                $where .= "fastcon_product_sku.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "fastcon_product_sku.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "fastcon_product_sku.".$field . " LIKE '%" . $q . "%' )";
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
	                $where .= "fastcon_product_sku.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "fastcon_product_sku.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "fastcon_product_sku.".$field . " LIKE '%" . $q . "%' )";
        }

        if (is_array($select_field) AND count($select_field)) {
        	$this->db->select($select_field);
        }
		
		$this->join_avaiable();
        $this->db->where($where);
        $this->db->limit($limit, $offset);
	    $this->db->order_by('fastcon_product_sku.'.$this->primary_key, "DESC");
        if (isset($_GET['order'])) {
        	$this->db->order_by($_GET['order']['0']['column']==0?$this->primary_key:$_GET['order']['0']['column'], $_GET['order']['0']['dir']);
        }else{
		    $this->db->order_by('fastcon_product_sku.'.$this->primary_key, "DESC");
        }
		$query = $this->db->get($this->table_name);

		return $query->result();
	}

	public function join_avaiable() {
		$this->db->join('fastcon_product', 'fastcon_product.product_id = fastcon_product_sku.product_id', 'LEFT');
	    $this->db->join('fastcon_product_option', 'fastcon_product_option.product_type_id = fastcon_product_sku.product_option1', 'LEFT');
	    $this->db->join('fastcon_product_option_value', 'fastcon_product_option_value.option_value_id = fastcon_product_sku.product_option_value1', 'LEFT');
	    $this->db->join('fastcon_product_option fastcon_product_option1', 'fastcon_product_option1.product_type_id = fastcon_product_sku.product_option2', 'LEFT');
	    $this->db->join('fastcon_product_option_value fastcon_product_option_value1', 'fastcon_product_option_value1.option_value_id = fastcon_product_sku.product_option_value2', 'LEFT');
	    
    	return $this;
	}

}

/* End of file Model_fastcon_product_sku.php */
/* Location: ./application/models/Model_fastcon_product_sku.php */