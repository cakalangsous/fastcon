<?php 

if(!function_exists('generate_order_code')) {

	function generate_order_code() {

		$ci =& get_instance();

		$query = 'SELECT * from fastcon_product_orders where date(created) = CURDATE() GROUP BY order_code';
		$result = $ci->db->query($query)->result();

		$order_code = 'FAST'.date('Ymd').str_pad((count($result)+1), 3, 0, STR_PAD_LEFT);

		return $order_code;
	}
}

if(!function_exists('get_today_transactions')) {

	function get_today_transactions() {

		$ci =& get_instance();

		$query = 'SELECT * from fastcon_product_orders where date(created) = CURDATE()';
		return $ci->db->query($query)->result();
	}
}

if (!function_exists('array_group_by')) {
	function array_group_by($key, $data) {
	    $result = array();

	    foreach($data as $val) {
	        if(isset($val->$key)){
	            $result[$val->$key][] = $val;
	        }else{
	            $result[""][] = $val;
	        }
	    }

	    return $result;
	}
}
