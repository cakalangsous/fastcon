<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_fastcon_distributor_branch extends MY_Model {

	private $primary_key 	= 'branch_id';
	private $table_name 	= 'fastcon_distributor_branch';
	private $field_search 	= ['distributor_id', 'distributor_city', 'distributor_address', 'phone'];

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
	                $where .= "fastcon_distributor_branch.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "fastcon_distributor_branch.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "fastcon_distributor_branch.".$field . " LIKE '%" . $q . "%' )";
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
	                $where .= "fastcon_distributor_branch.".$field . " LIKE '%" . $q . "%' ";
	            } else {
	                $where .= "OR " . "fastcon_distributor_branch.".$field . " LIKE '%" . $q . "%' ";
	            }
	            $iterasi++;
	        }

	        $where = '('.$where.')';
        } else {
        	$where .= "(" . "fastcon_distributor_branch.".$field . " LIKE '%" . $q . "%' )";
        }

        if (is_array($select_field) AND count($select_field)) {
        	$this->db->select($select_field);
        }
		
		$this->join_avaiable();
        $this->db->where($where);
        $this->db->limit($limit, $offset);
	    $this->db->order_by('fastcon_distributor_branch.'.$this->primary_key, "DESC");
        if (isset($_GET['order'])) {
        	$this->db->order_by($_GET['order']['0']['column']==0?$this->primary_key:$_GET['order']['0']['column'], $_GET['order']['0']['dir']);
        }else{
		    $this->db->order_by('fastcon_distributor_branch.'.$this->primary_key, "DESC");
        }
		$query = $this->db->get($this->table_name);

		return $query->result();
	}

	public function join_avaiable() {
		$this->db->join('fastcon_distributor', 'fastcon_distributor.id = fastcon_distributor_branch.distributor_id', 'LEFT');
	    
    	return $this;
	}

}

/* End of file Model_fastcon_distributor_branch.php */
/* Location: ./application/models/Model_fastcon_distributor_branch.php */