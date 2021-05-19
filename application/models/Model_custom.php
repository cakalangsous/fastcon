<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Model_custom extends MY_Model {



	private $primary_key 	= 'id';

	private $table_name 	= 'page';

	private $field_search 	= ['title', 'type', 'link', 'created_at'];



	public function __construct()

	{

		$config = array(

			'primary_key' 	=> $this->primary_key,

		 	'table_name' 	=> $this->table_name,

		 	'field_search' 	=> $this->field_search,

		 );



		parent::__construct($config);

	}



	public function get_all_skin()

	{

		return $this->db->get('skin_option')->result();

	}

	public function get_site_logo($logo = '')
	{
		return $this->db->get_where('skin_option',array('option_name' => $logo))->result();
	}



}



/* End of file Model_custom.php */

/* Location: ./application/models/Model_skin.php */

/* For custom Settings by Benkin 20180502 */