<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_web extends MY_Model {

	public function get_kota_kecamatan($param='')
	{
		if ($param=='') {
			return false;
		}

		$this->db->select('provinsi, kabupaten, kecamatan, kelurahan, kode_pos')
				->like('kabupaten', $param)
				->or_like('kecamatan', $param)
				->or_like('kelurahan', $param)
				->order_by('provinsi');
		return $this->db->get('fastcon_address_master')->result();
	}

	public function get_product_option($product_id)
	{
		$this->db->select('product_option_id, product_option_name, product_option_name_en')
				->from('view_product_variants')
				->where('product_id', $product_id)
				->group_by('product_option_id')
				->order_by('product_option_id');
		return $this->db->get()->result();
	}

	public function get_variant_value($product_id, $product_option_id)
	{
		$this->db->select('product_option_value_id, option_value')
					->from('view_product_variants')
					->where('product_id', $product_id)
					->where('product_option_id', $product_option_id)
					->group_by('product_option_value_id')
					->order_by('product_option_value_id');

		return $this->db->get()->result();
	}

	public function get_cart()
	{
		$this->db->select('v.*');
		$this->db->from('fastcon_product_cart c');
		$this->db->join('view_product_variants v', 'v.sku_id = c.sku_id');
		$this->db->where('c.member_id', $this->session->userdata('member')['member_id']);
		return $this->db->get()->result();
	}

	public function get_product_on_cart()
	{
		$this->db->select('v.*');
		$this->db->from('fastcon_product_cart c');
		$this->db->join('view_product_variants v', 'v.sku_id = c.sku_id');
		$this->db->where('c.member_id', $this->session->userdata('member')['member_id']);
		$this->db->group_by('v.product_id');
		return $this->db->get()->result();
	}
}

/* End of file Model_web.php */
/* Location: ./application/models/Model_web.php */