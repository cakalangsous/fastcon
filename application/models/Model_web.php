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

	public function get_variant_value($product_id, $group_by)
	{
		$this->db->where('product_id', $product_id);
		$this->db->group_by($group_by);
		return $this->db->get('view_product_variant')->result();
	}

	public function get_cart()
	{
		$this->db->select('c.*, v.*');
		$this->db->from('fastcon_product_cart c');
		$this->db->join('view_product_option_variant v', 'v.variant_id = c.variant_id');
		$this->db->where('c.member_id', $this->session->userdata('member')['member_id']);
		return $this->db->get()->result();
	}

	public function get_useable_voucher()
	{
		$this->db->select('v.*')
				->from('fastcon_voucher v')
				->where('NOT EXISTS (SELECT * FROM fastcon_product_orders po WHERE v.voucher_id=po.voucher_id AND po.member_id='.$this->session->userdata('member')['member_id'].')','', false);

		return $this->db->get()->result();
	}
}

/* End of file Model_web.php */
/* Location: ./application/models/Model_web.php */