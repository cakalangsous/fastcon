<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Fastcon Product Controller
*| --------------------------------------------------------------------------
*| Fastcon Product site
*|
*/
class Fastcon_product extends Admin
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_fastcon_product');
	}

	/**
	* show all Fastcon Products
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('fastcon_product_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['fastcon_products'] = $this->model_fastcon_product->get($filter, $field, $this->limit_page, $offset);
		$this->data['fastcon_product_counts'] = $this->model_fastcon_product->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/fastcon_product/index/',
			'total_rows'   => $this->model_fastcon_product->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);
		$this->data['datables'] = true;

		$this->template->title('Product List');
		$this->render('backend/standart/administrator/fastcon_product/fastcon_product_list', $this->data);
	}

	public function data_ajax()
	{
		$this->is_allowed('fastcon_product_list');
		$fastcon_products = $this->model_fastcon_product->get($_GET['search']['value'], '', $this->input->get('length'), $this->input->get('start'), 0);
		$data = array();
        $no = $this->input->get('draw');


        foreach($fastcon_products as $fastcon_product){
        	$button = '';
        	$row = [];

						if($this->is_allowed('fastcon_product_add'))
        	{
		        $button .= '<a href="'.site_url("administrator/fastcon_product/clone_data/" . $fastcon_product->product_id) .'" class="label-default mr-3"><i class="fa fa-copy"></i> '.cclang('clone').'</a>';
        	}
			
	        $button .= '<a href="'.site_url("administrator/fastcon_product/view/" . $fastcon_product->product_id).'" class="label-default mr-3"><i class="fa fa-newspaper-o" style="padding-right:3px;"></i> '.cclang("view_button").'</a>';

			        	if($this->is_allowed('fastcon_product_update'))
        	{
		        $button .= '<a href="'.site_url("administrator/fastcon_product/edit/" . $fastcon_product->product_id) .'" class="label-default mr-3"><i class="fa fa-edit "></i> '.cclang('update_button').'</a>';
        	}
			        	if($this->is_allowed('fastcon_product_delete'))
        	{
		        $button .= '<a href="javascript:void(0);" onclick="delete_this(\''.BASE_URL.'administrator/fastcon_product/delete/'.$fastcon_product->product_id.'\')" class="label-default remove-data"><i class="fa fa-close"></i>'.cclang('remove_button').'</a>';
        	}



	    			$row[] = $fastcon_product->category_name;
	    	$row[] = $fastcon_product->product_name;

	    	$row[] = $fastcon_product->product_slug;

	    	$file_fastcon_product = '';
			foreach (explode(',', $fastcon_product->product_images) as $file){
            	if (!empty($file)){
                	if (is_image($file)){
		                $file_fastcon_product .= '<a class="fancybox" rel="group" href="'.BASE_URL . 'uploads/fastcon_product/' . $file.'">
        		                  <img src="'.BASE_URL.'uploads/fastcon_product/'. $file.'" class="image-responsive" alt="image fastcon_product" title="'.$file.'" width="40px">
		                </a>';
	                }else{
	                	$file_fastcon_product .= '<a href="'.BASE_URL . 'administrator/file/download/fastcon_product/'. $file.'">
    		                		<img src="'.get_icon_file($file).'" class="image-responsive image-icon" alt="image fastcon_product" title="'.$file.'" width="40px">
    		                	</a>';
	                }
	            }
            }
            $row[] = $file_fastcon_product;
	    	$row[] = $fastcon_product->product_desc;

	    	if (!empty($fastcon_product->spec)){
                if (is_image($fastcon_product->spec)){
	                $row[] = '<a class="fancybox" rel="group" href="'.BASE_URL . 'uploads/fastcon_product/'. $fastcon_product->spec.'">
	                            <img src="'.BASE_URL . 'uploads/fastcon_product/' . $fastcon_product->spec.'" class="image-responsive" alt="image fastcon_product" title="spec fastcon_product" width="40px">
	                        </a>';
                }else{
	                $row[] =  '<a href="'.BASE_URL . 'administrator/file/download/fastcon_product/' . $fastcon_product->spec.'">
	                       <img src="'.get_icon_file($fastcon_product->spec).'" class="image-responsive image-icon" alt="image fastcon_product" title="spec fastcon_product" width="40px">
	                     </a>';
                }
            }else{
				$row[] = null;
			}
	    	if (!empty($fastcon_product->cara_pasang)){
                if (is_image($fastcon_product->cara_pasang)){
	                $row[] = '<a class="fancybox" rel="group" href="'.BASE_URL . 'uploads/fastcon_product/'. $fastcon_product->cara_pasang.'">
	                            <img src="'.BASE_URL . 'uploads/fastcon_product/' . $fastcon_product->cara_pasang.'" class="image-responsive" alt="image fastcon_product" title="cara_pasang fastcon_product" width="40px">
	                        </a>';
                }else{
	                $row[] =  '<a href="'.BASE_URL . 'administrator/file/download/fastcon_product/' . $fastcon_product->cara_pasang.'">
	                       <img src="'.get_icon_file($fastcon_product->cara_pasang).'" class="image-responsive image-icon" alt="image fastcon_product" title="cara_pasang fastcon_product" width="40px">
	                     </a>';
                }
            }else{
				$row[] = null;
			}
	    	if (!empty($fastcon_product->certificate)){
                if (is_image($fastcon_product->certificate)){
	                $row[] = '<a class="fancybox" rel="group" href="'.BASE_URL . 'uploads/fastcon_product/'. $fastcon_product->certificate.'">
	                            <img src="'.BASE_URL . 'uploads/fastcon_product/' . $fastcon_product->certificate.'" class="image-responsive" alt="image fastcon_product" title="certificate fastcon_product" width="40px">
	                        </a>';
                }else{
	                $row[] =  '<a href="'.BASE_URL . 'administrator/file/download/fastcon_product/' . $fastcon_product->certificate.'">
	                       <img src="'.get_icon_file($fastcon_product->certificate).'" class="image-responsive image-icon" alt="image fastcon_product" title="certificate fastcon_product" width="40px">
	                     </a>';
                }
            }else{
				$row[] = null;
			}
	    
	        $row[] = $button;
	    	$data[] = $row;
        }

        $output = array(
            "draw" => $this->input->get('draw'),
            "recordsTotal" => $this->model_fastcon_product->count_all(),
            "recordsFiltered" => $this->model_fastcon_product->count_all(),
            "data" => $data,
        );
        
        echo json_encode($output);
	}
	
	/**
	* Add new fastcon_products
	*
	*/
	public function add()
	{
		$this->is_allowed('fastcon_product_add');

		$this->template->title('Product New');
		$this->render('backend/standart/administrator/fastcon_product/fastcon_product_add', $this->data);
	}

	/**
	* Add New Fastcon Products
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('fastcon_product_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('product_category', 'Product Category', 'trim|required');
		$this->form_validation->set_rules('product_name', 'Product Name', 'trim|required');
		$this->form_validation->set_rules('product_slug', 'Product Slug', 'trim|required');
		$this->form_validation->set_rules('fastcon_product_product_images_name[]', 'Product Images', 'trim|required');
		$this->form_validation->set_rules('product_desc', 'Product Desc', 'trim|required');
		$this->form_validation->set_rules('fastcon_product_spec_name', 'Spec', 'trim|required');
		$this->form_validation->set_rules('fastcon_product_cara_pasang_name', 'Cara Pasang', 'trim|required');
		$this->form_validation->set_rules('fastcon_product_certificate_name', 'Certificate', 'trim|required');
		

		if ($this->form_validation->run()) {
			$fastcon_product_spec_uuid = $this->input->post('fastcon_product_spec_uuid');
			$fastcon_product_spec_name = $this->input->post('fastcon_product_spec_name');
			$fastcon_product_cara_pasang_uuid = $this->input->post('fastcon_product_cara_pasang_uuid');
			$fastcon_product_cara_pasang_name = $this->input->post('fastcon_product_cara_pasang_name');
			$fastcon_product_certificate_uuid = $this->input->post('fastcon_product_certificate_uuid');
			$fastcon_product_certificate_name = $this->input->post('fastcon_product_certificate_name');
		
			$save_data = [
				'product_category' => $this->input->post('product_category'),
				'product_name' => $this->input->post('product_name'),
				'product_slug' => $this->input->post('product_slug'),
				'product_desc' => $this->input->post('product_desc'),
			];

			if (!is_dir(FCPATH . '/uploads/fastcon_product/')) {
				mkdir(FCPATH . '/uploads/fastcon_product/');
			}

			if (!empty($fastcon_product_spec_name)) {
				$fastcon_product_spec_name_copy = date('YmdHis') . '-' . $fastcon_product_spec_name;

				rename(FCPATH . 'uploads/tmp/' . $fastcon_product_spec_uuid . '/' . $fastcon_product_spec_name,
						FCPATH . 'uploads/fastcon_product/' . $fastcon_product_spec_name_copy);

				if (!is_file(FCPATH . '/uploads/fastcon_product/' . $fastcon_product_spec_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['spec'] = $fastcon_product_spec_name_copy;
			}
		
			if (!empty($fastcon_product_cara_pasang_name)) {
				$fastcon_product_cara_pasang_name_copy = date('YmdHis') . '-' . $fastcon_product_cara_pasang_name;

				rename(FCPATH . 'uploads/tmp/' . $fastcon_product_cara_pasang_uuid . '/' . $fastcon_product_cara_pasang_name,
						FCPATH . 'uploads/fastcon_product/' . $fastcon_product_cara_pasang_name_copy);

				if (!is_file(FCPATH . '/uploads/fastcon_product/' . $fastcon_product_cara_pasang_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['cara_pasang'] = $fastcon_product_cara_pasang_name_copy;
			}
		
			if (!empty($fastcon_product_certificate_name)) {
				$fastcon_product_certificate_name_copy = date('YmdHis') . '-' . $fastcon_product_certificate_name;

				rename(FCPATH . 'uploads/tmp/' . $fastcon_product_certificate_uuid . '/' . $fastcon_product_certificate_name,
						FCPATH . 'uploads/fastcon_product/' . $fastcon_product_certificate_name_copy);

				if (!is_file(FCPATH . '/uploads/fastcon_product/' . $fastcon_product_certificate_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['certificate'] = $fastcon_product_certificate_name_copy;
			}
		
			if (count((array) $this->input->post('fastcon_product_product_images_name'))) {
				foreach ((array) $_POST['fastcon_product_product_images_name'] as $idx => $file_name) {
					$fastcon_product_product_images_name_copy = date('YmdHis') . '-' . $file_name;

					rename(FCPATH . 'uploads/tmp/' . $_POST['fastcon_product_product_images_uuid'][$idx] . '/' .  $file_name,
							FCPATH . 'uploads/fastcon_product/' . $fastcon_product_product_images_name_copy);

					$listed_image[] = $fastcon_product_product_images_name_copy;

					if (!is_file(FCPATH . '/uploads/fastcon_product/' . $fastcon_product_product_images_name_copy)) {
						echo json_encode([
							'success' => false,
							'message' => 'Error uploading file'
							]);
						exit;
					}
				}

				$save_data['product_images'] = implode($listed_image, ',');
			}
		
			
			$save_fastcon_product = $this->model_fastcon_product->store($save_data);

			if ($save_fastcon_product) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_fastcon_product;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/fastcon_product/edit/' . $save_fastcon_product, 'Edit Fastcon Product'),
						anchor('administrator/fastcon_product', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/fastcon_product/edit/' . $save_fastcon_product, 'Edit Fastcon Product')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_product');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_product');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	
	/**
	* Clone data Fastcon Product	*
	*/
	public function clone_data($id=0)
	{
		if($id<=0)
		{
			$this->data['success'] = false;
    		$this->data['message'] = cclang('data_not_found');
			$this->data['redirect'] = base_url('administrator/fastcon_product');
			set_message(cclang('data_not_found'), 'warning');
		}

		$this->is_allowed('fastcon_product_add');

		if($data = db_get_row_data('fastcon_product', ['product_id' => $id]))
		{
			clone_this_data('fastcon_product', ['product_id' => $id]);
			$this->data['success'] = true;
    		$this->data['message'] = cclang('data_cloned');
			$this->data['redirect'] = base_url('administrator/fastcon_product');

			set_message(cclang('data_cloned'), 'success');
		}else{
			set_message(cclang('data_not_found'), 'warning');
		}

		redirect('administrator/fastcon_product');

	}

	
		/**
	* Update view Fastcon Products
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('fastcon_product_update');

		$this->data['fastcon_product'] = $this->model_fastcon_product->find($id);

		$this->template->title('Product Update');
		$this->render('backend/standart/administrator/fastcon_product/fastcon_product_update', $this->data);
	}

	/**
	* Update Fastcon Products
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('fastcon_product_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('product_category', 'Product Category', 'trim|required');
		$this->form_validation->set_rules('product_name', 'Product Name', 'trim|required');
		$this->form_validation->set_rules('product_slug', 'Product Slug', 'trim|required');
		$this->form_validation->set_rules('fastcon_product_product_images_name[]', 'Product Images', 'trim|required');
		$this->form_validation->set_rules('product_desc', 'Product Desc', 'trim|required');
		$this->form_validation->set_rules('fastcon_product_spec_name', 'Spec', 'trim|required');
		$this->form_validation->set_rules('fastcon_product_cara_pasang_name', 'Cara Pasang', 'trim|required');
		$this->form_validation->set_rules('fastcon_product_certificate_name', 'Certificate', 'trim|required');
		
		if ($this->form_validation->run()) {
			$fastcon_product_spec_uuid = $this->input->post('fastcon_product_spec_uuid');
			$fastcon_product_spec_name = $this->input->post('fastcon_product_spec_name');
			$fastcon_product_cara_pasang_uuid = $this->input->post('fastcon_product_cara_pasang_uuid');
			$fastcon_product_cara_pasang_name = $this->input->post('fastcon_product_cara_pasang_name');
			$fastcon_product_certificate_uuid = $this->input->post('fastcon_product_certificate_uuid');
			$fastcon_product_certificate_name = $this->input->post('fastcon_product_certificate_name');
		
			$save_data = [
				'product_category' => $this->input->post('product_category'),
				'product_name' => $this->input->post('product_name'),
				'product_slug' => $this->input->post('product_slug'),
				'product_desc' => $this->input->post('product_desc'),
			];

			if (!is_dir(FCPATH . '/uploads/fastcon_product/')) {
				mkdir(FCPATH . '/uploads/fastcon_product/');
			}

			if (!empty($fastcon_product_spec_uuid)) {
				$fastcon_product_spec_name_copy = date('YmdHis') . '-' . $fastcon_product_spec_name;

				rename(FCPATH . 'uploads/tmp/' . $fastcon_product_spec_uuid . '/' . $fastcon_product_spec_name,
						FCPATH . 'uploads/fastcon_product/' . $fastcon_product_spec_name_copy);

				if (!is_file(FCPATH . '/uploads/fastcon_product/' . $fastcon_product_spec_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['spec'] = $fastcon_product_spec_name_copy;
			}
		
			if (!empty($fastcon_product_cara_pasang_uuid)) {
				$fastcon_product_cara_pasang_name_copy = date('YmdHis') . '-' . $fastcon_product_cara_pasang_name;

				rename(FCPATH . 'uploads/tmp/' . $fastcon_product_cara_pasang_uuid . '/' . $fastcon_product_cara_pasang_name,
						FCPATH . 'uploads/fastcon_product/' . $fastcon_product_cara_pasang_name_copy);

				if (!is_file(FCPATH . '/uploads/fastcon_product/' . $fastcon_product_cara_pasang_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['cara_pasang'] = $fastcon_product_cara_pasang_name_copy;
			}
		
			if (!empty($fastcon_product_certificate_uuid)) {
				$fastcon_product_certificate_name_copy = date('YmdHis') . '-' . $fastcon_product_certificate_name;

				rename(FCPATH . 'uploads/tmp/' . $fastcon_product_certificate_uuid . '/' . $fastcon_product_certificate_name,
						FCPATH . 'uploads/fastcon_product/' . $fastcon_product_certificate_name_copy);

				if (!is_file(FCPATH . '/uploads/fastcon_product/' . $fastcon_product_certificate_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
						]);
					exit;
				}

				$save_data['certificate'] = $fastcon_product_certificate_name_copy;
			}
		
			$listed_image = [];
			if (count((array) $this->input->post('fastcon_product_product_images_name'))) {
				foreach ((array) $_POST['fastcon_product_product_images_name'] as $idx => $file_name) {
					if (isset($_POST['fastcon_product_product_images_uuid'][$idx]) AND !empty($_POST['fastcon_product_product_images_uuid'][$idx])) {
						$fastcon_product_product_images_name_copy = date('YmdHis') . '-' . $file_name;

						rename(FCPATH . 'uploads/tmp/' . $_POST['fastcon_product_product_images_uuid'][$idx] . '/' .  $file_name,
								FCPATH . 'uploads/fastcon_product/' . $fastcon_product_product_images_name_copy);

						$listed_image[] = $fastcon_product_product_images_name_copy;

						if (!is_file(FCPATH . '/uploads/fastcon_product/' . $fastcon_product_product_images_name_copy)) {
							echo json_encode([
								'success' => false,
								'message' => 'Error uploading file'
								]);
							exit;
						}
					} else {
						$listed_image[] = $file_name;
					}
				}
			}
			
			$save_data['product_images'] = implode($listed_image, ',');
		
			
			$save_fastcon_product = $this->model_fastcon_product->change($id, $save_data);

			if ($save_fastcon_product) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/fastcon_product', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/fastcon_product');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/fastcon_product');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Fastcon Products
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('fastcon_product_delete');

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
            set_message(cclang('has_been_deleted', 'fastcon_product'), 'success');
        } else {
            set_message(cclang('error_delete', 'fastcon_product'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Fastcon Products
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('fastcon_product_view');

		$this->data['fastcon_product'] = $this->model_fastcon_product->join_avaiable()->find($id);

		$this->template->title('Product Detail');
		$this->render('backend/standart/administrator/fastcon_product/fastcon_product_view', $this->data);
	}
	
	/**
	* delete Fastcon Products
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$fastcon_product = $this->model_fastcon_product->find($id);

		if (!empty($fastcon_product->spec)) {
			$path = FCPATH . '/uploads/fastcon_product/' . $fastcon_product->spec;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}
		if (!empty($fastcon_product->cara_pasang)) {
			$path = FCPATH . '/uploads/fastcon_product/' . $fastcon_product->cara_pasang;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}
		if (!empty($fastcon_product->certificate)) {
			$path = FCPATH . '/uploads/fastcon_product/' . $fastcon_product->certificate;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}
		
		if (!empty($fastcon_product->product_images)) {
			foreach ((array) explode(',', $fastcon_product->product_images) as $filename) {
				$path = FCPATH . '/uploads/fastcon_product/' . $filename;

				if (is_file($path)) {
					$delete_file = unlink($path);
				}
			}
		}
		
		return $this->model_fastcon_product->remove($id);
	}
	
	/**
	* Upload Image Fastcon Product	*
	* @return JSON
	*/
	public function upload_spec_file()
	{
		if (!$this->is_allowed('fastcon_product_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'fastcon_product',
			'allowed_types' => 'jpg|jpeg|png',
		]);
	}

	/**
	* Delete Image Fastcon Product	*
	* @return JSON
	*/
	public function delete_spec_file($uuid)
	{
		if (!$this->is_allowed('fastcon_product_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid,
            'delete_by'         => $this->input->get('by'),
            'field_name'        => 'spec',
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'fastcon_product',
            'primary_key'       => 'product_id',
            'upload_path'       => 'uploads/fastcon_product/'
        ]);
	}

	/**
	* Get Image Fastcon Product	*
	* @return JSON
	*/
	public function get_spec_file($id)
	{
		if (!$this->is_allowed('fastcon_product_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$fastcon_product = $this->model_fastcon_product->find($id);

		echo $this->get_file([
            'uuid'              => $id,
            'delete_by'         => 'id',
            'field_name'        => 'spec',
            'table_name'        => 'fastcon_product',
            'primary_key'       => 'product_id',
            'upload_path'       => 'uploads/fastcon_product/',
            'delete_endpoint'   => 'administrator/fastcon_product/delete_spec_file'
        ]);
	}
	
	/**
	* Upload Image Fastcon Product	*
	* @return JSON
	*/
	public function upload_cara_pasang_file()
	{
		if (!$this->is_allowed('fastcon_product_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'fastcon_product',
			'allowed_types' => 'jpg|jpeg|png',
		]);
	}

	/**
	* Delete Image Fastcon Product	*
	* @return JSON
	*/
	public function delete_cara_pasang_file($uuid)
	{
		if (!$this->is_allowed('fastcon_product_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid,
            'delete_by'         => $this->input->get('by'),
            'field_name'        => 'cara_pasang',
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'fastcon_product',
            'primary_key'       => 'product_id',
            'upload_path'       => 'uploads/fastcon_product/'
        ]);
	}

	/**
	* Get Image Fastcon Product	*
	* @return JSON
	*/
	public function get_cara_pasang_file($id)
	{
		if (!$this->is_allowed('fastcon_product_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$fastcon_product = $this->model_fastcon_product->find($id);

		echo $this->get_file([
            'uuid'              => $id,
            'delete_by'         => 'id',
            'field_name'        => 'cara_pasang',
            'table_name'        => 'fastcon_product',
            'primary_key'       => 'product_id',
            'upload_path'       => 'uploads/fastcon_product/',
            'delete_endpoint'   => 'administrator/fastcon_product/delete_cara_pasang_file'
        ]);
	}
	
	/**
	* Upload Image Fastcon Product	*
	* @return JSON
	*/
	public function upload_certificate_file()
	{
		if (!$this->is_allowed('fastcon_product_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'fastcon_product',
			'allowed_types' => 'jpg|jpeg|png',
		]);
	}

	/**
	* Delete Image Fastcon Product	*
	* @return JSON
	*/
	public function delete_certificate_file($uuid)
	{
		if (!$this->is_allowed('fastcon_product_delete', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid,
            'delete_by'         => $this->input->get('by'),
            'field_name'        => 'certificate',
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'fastcon_product',
            'primary_key'       => 'product_id',
            'upload_path'       => 'uploads/fastcon_product/'
        ]);
	}

	/**
	* Get Image Fastcon Product	*
	* @return JSON
	*/
	public function get_certificate_file($id)
	{
		if (!$this->is_allowed('fastcon_product_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$fastcon_product = $this->model_fastcon_product->find($id);

		echo $this->get_file([
            'uuid'              => $id,
            'delete_by'         => 'id',
            'field_name'        => 'certificate',
            'table_name'        => 'fastcon_product',
            'primary_key'       => 'product_id',
            'upload_path'       => 'uploads/fastcon_product/',
            'delete_endpoint'   => 'administrator/fastcon_product/delete_certificate_file'
        ]);
	}
	
	
	/**
	* Upload Image Fastcon Product	*
	* @return JSON
	*/
	public function upload_product_images_file()
	{
		if (!$this->is_allowed('fastcon_product_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'fastcon_product',
			'allowed_types' => 'jpg|jpeg|png',
		]);
	}

	/**
	* Delete Image Fastcon Product	*
	* @return JSON
	*/
	public function delete_product_images_file($uuid)
	{
		if (!$this->is_allowed('fastcon_product_delete', false)) {
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
            'table_name'        => 'fastcon_product',
            'primary_key'       => 'product_id',
            'upload_path'       => 'uploads/fastcon_product/'
        ]);
	}

	/**
	* Get Image Fastcon Product	*
	* @return JSON
	*/
	public function get_product_images_file($id)
	{
		if (!$this->is_allowed('fastcon_product_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$fastcon_product = $this->model_fastcon_product->find($id);

		echo $this->get_file([
            'uuid'              => $id,
            'delete_by'         => 'id',
            'field_name'        => 'product_images',
            'table_name'        => 'fastcon_product',
            'primary_key'       => 'product_id',
            'upload_path'       => 'uploads/fastcon_product/',
            'delete_endpoint'   => 'administrator/fastcon_product/delete_product_images_file'
        ]);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('fastcon_product_export');

		$this->model_fastcon_product->export('fastcon_product', 'fastcon_product');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('fastcon_product_export');

		$this->model_fastcon_product->pdf('fastcon_product', 'fastcon_product');
	}
}


/* End of file fastcon_product.php */
/* Location: ./application/controllers/administrator/Fastcon Product.php */
