<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class XenditNotifCallback extends Api {

	public function success_get()
	{
		$this->response([
				'status' => true,
				'message' => 'Testing success'
			], Api::HTTP_OK);
			return;
	}

	public function success_post()
	{
		if (!$this->head('X-CALLBACK-TOKEN') OR $this->head('X-CALLBACK-TOKEN') !== getenv('XENDIT_CALLBACK_TOKEN')) {
			$callback_data = [
				'status' => false,
				'xendit_response_json' => json_encode($this->head()).' - '.json_encode($this->post())
			];
			insert_this_data('fastcon_xendit_callback_hit', $callback_data);

			$this->response([
				'status' => false,
				'message' => 'Unknown Request'
			], Api::HTTP_FORBIDDEN);
			return;
		}

		$order = false;
		$order_status = false;
		$email_title = '';
		$email_body = '';
		$payer_name = false;

		if ($this->post('external_id')) {
			$order = db_get_row_data('fastcon_product_orders', ['order_code' => $this->post('external_id')]);
		}

		if ($this->post('status')) {
			switch ($this->post('status')) {
				case 'PENDING':
					$order_status = 1;
					break;
				
				case 'PAID':
					$order_status = 2;
					$email_title = lang('payment_received_title');
					$email_body = lang('payment_received_email');
					break;

				case 'EXPIRED':
					$order_status = 4;
					$email_title = lang('order_cancelled_title');
					$email_body = lang('order_cancelled_email');
					break;

				default:
					$order_status = 1;
					break;
			}
		}

		$callback_data = [
			'status' => 'success',
			'xendit_id' => $this->post('id'),
			'xendit_external_id' => $this->post('external_id'),
			'xendit_response_json' => json_encode($this->post())
		];


		if ($this->post('status')) {
			$callback_data['xendit_status'] = $this->post('status');
		}

		if ($this->post('bank_code')) {
			$callback_data['bank_code'] = $this->post('bank_code');
		}

		if ($this->post('retail_outlet_name')) {
			$callback_data['retail_outlet_name'] = $this->post('retail_outlet_name');
		}

		if ($this->post('ewallet_type')) {
			$callback_data['ewallet_type'] = $this->post('ewallet_type');
		}

		insert_this_data('fastcon_xendit_callback_hit', $callback_data);


		if ($order AND $order_status) {
			$order_update = [
				'order_status' => $order_status,
				'status' => $this->post('status')
			];

			update_this_data('fastcon_product_orders', ['order_code' => $this->post('external_id')], $order_update);

			if ($order_status!=1) {
				// send email to customer by fastcon mailing

				$payer_name = $order->payer_name;

				$info['title']		= $email_title;
				$info['caption']	= $email_body;
				$info['payer_name'] = $payer_name;
				$info['marketplace']= $this->data['marketplace'];
				$info['contact_settings']	= $this->data['contact_settings'];
				$info['lang'] = $this->data['lang'];
				$info['cart'] = db_get_all_data('fastcon_product_orders', ['order_code' => $this->post('external_id')]);
				$info['order_details'] = db_get_row_data('fastcon_product_orders', ['order_code' => $this->post('external_id')]);

				$html = $this->load->view('email/index', $info, true);

				$this->load->library('email');

				$this->email->initialize($this->mail_config());
				$this->email->set_newline("\r\n");
				$this->email->from(getenv('EMAIL_SENDER'), getenv('SENDER_NAME'));
				$this->email->to($order->payer_email);
				$this->email->subject('Fastcon - '.$email_title);
				$this->email->message($html);
				
				$this->email->send();
				
			}
			$this->response([
				'status' => true,
				'message' => 'Notif received successfully'
			], Api::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Unknown Request'
			], Api::HTTP_NOT_FOUND);
		}
		
	}

}

/* End of file XenditNotifCallback.php */
/* Location: ./application/controllers/api/XenditNotifCallback.php */