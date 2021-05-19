<?php

defined('BASEPATH') OR exit('No direct script access allowed');





class Model_access extends MY_Model {



	private $primary_key 	= 'perm_id';

	private $table_name 	= 'aauth_perm_to_group';

	private $field_search 	= array('perm_id', 'group_id');



	public function __construct()

	{

		$config = array(

			'primary_key' 	=> $this->primary_key,

		 	'table_name' 	=> $this->table_name,

		 	'field_search' 	=> $this->field_search,

		 );



		parent::__construct($config);

	}



	public function count_all($q = '', $field = '')

	{

		$iterasi = 1;

        $num = count($this->field_search);

        $where = NULL;

        $q = $this->scurity($q);

		$field = $this->scurity($field);



        if (empty($field)) {

	        foreach ($this->field_search as $field) {

	            if ($iterasi == 1) {

	                $where .= "(" . $field . " LIKE '%" . $q . "%' ";

	            } else if ($iterasi == $num) {

	                $where .= "OR " . $field . " LIKE '%" . $q . "%') ";

	            } else {

	                $where .= "OR " . $field . " LIKE '%" . $q . "%' ";

	            }

	            $iterasi++;

	        }

        } else {

        	$where .= "(" . $field . " LIKE '%" . $q . "%' )";

        }



        $this->db->where($where);

		$query = $this->db->get($this->table_name);



		return $query->num_rows();

	}



	public function get($q = '', $field = '', $limit = 0, $offset = 0)

	{

		$iterasi = 1;

        $num = count($this->field_search);

        $where = NULL;

        $q = $this->scurity($q);

		$field = $this->scurity($field);



        if (empty($field)) {

	        foreach ($this->field_search as $field) {

	            if ($iterasi == 1) {

	                $where .= "(" . $field . " LIKE '%" . $q . "%' ";

	            } else if ($iterasi == $num) {

	                $where .= "OR " . $field . " LIKE '%" . $q . "%') ";

	            } else {

	                $where .= "OR " . $field . " LIKE '%" . $q . "%' ";

	            }

	            $iterasi++;

	        }

        } else {

        	$where .= "(" . $field . " LIKE '%" . $q . "%' )";

        }



        $this->db->where($where);

        $this->db->limit($limit, $offset);

        $this->db->order_by($this->primary_key, "DESC");

		$query = $this->db->get($this->table_name);



		return $query->result();

	}

	public function get_perm_name($perm_id=0)
	{
		return $this->db->get_where('aauth_perms', array('id' => $perm_id))->result();
	}

	public function get_perm_id_by_name($perm_name='')
	{
		return $this->db->get_where('aauth_perms', array('name' => $perm_name))->result();
	}



}



/* End of file Model_access.php */

/* Location: ./application/models/Model_access.php */