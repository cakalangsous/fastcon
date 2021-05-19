<?php

defined('BASEPATH') OR exit('No direct script access allowed');





/**

*| --------------------------------------------------------------------------

*| Access Controller

*| --------------------------------------------------------------------------

*| access site

*|

*/

class Access extends Admin	

{

	

	public function __construct()

	{

		parent::__construct();

		// if ($this->session->userdata('dstat')!=1) {

		// 	redirect($this->agent->referrer());

		// }



		$this->load->model([

			'model_access',

			'model_group'

		]);

	}



	/**

	* show all access

	*

	* @var $offset String

	*/

	public function index($offset = 0)

	{

		$this->is_allowed('access_list');



		$this->data['groups'] = $this->model_group->find_all();



		$this->template->title('Access List');

		$this->render('backend/standart/administrator/access/access_list', $this->data);

	}



	/**

	* Update accesss

	*

	* @var String $id 

	*/

	public function save()

	{

		if (!$this->is_allowed('access_update', false)) {

			return $this->response([

				'success' => false,

				'message' => cclang('sorry_you_do_not_have_permission_to_access')

				]);

		}

		// echo "<pre>";
		// print_r($this->input->post());
		// exit;


		$permissions = $this->input->post('id');

		$group_id = $this->input->post('group_id');

		$this->db->delete('aauth_perm_to_group', ['group_id' => $group_id]);

		$perm_name = [];

		if (count($permissions)) {

			$data = [];

			foreach ($permissions as $perms) {

				$query = $this->model_access->get_perm_name($perms);
				if ($query) {
					for ($i=0; $i<count($query) ; $i++) { 
						$temp_name[]=explode('_', $query[$i]->name);
						for ($i=0; $i<count($temp_name) ; $i++) { 
							$point_name[] = array_slice($temp_name[$i], 1,-1);
						}
					}
				}
				for ($i=0; $i<count($point_name) ; $i++) { 
					if (isset($point_name[$i][1])) {
						$point_name[$i][]= $point_name[$i][0].'_'.$point_name[$i][1];
					}
				}
				foreach ($point_name as $key => $value) {
					foreach ($value as $keys => $values) {
						$perm_name[] = $values;
					}
				}
				$filter_name = array();
				if (is_array($perm_name)) {
					$filter_name = array_unique($perm_name);
				}

				foreach ($filter_name as $key => $value) {
					$real_name[] = 'menu_'.$value;
				}

				

				$data[] = [

					'perm_id' => $perms,

					'group_id' => $group_id,

				];

			}
			if (isset($real_name)) {
				$arr = array_unique($real_name);
				foreach ($arr as $key => $value) {
					$get_real_name = $this->model_access->get_perm_id_by_name($value); //cari permission name
					if ($get_real_name) {
						$data[] = [
							'perm_id' => $get_real_name[0]->id,
							'group_id' => $group_id,
						];
					}
				}
			}

			$arr_default_permission = array(1,79);
			foreach ($arr_default_permission as $a) {
				$data[] = [
					'perm_id' => $a,
					'group_id' => $group_id,
				];
			}
			$save_access = $this->db->insert_batch('aauth_perm_to_group', $data);

		} else {

			$save_access = true;

		}



		if ($save_access) {

			$this->data = [

				'success' => true,

				'message' => cclang('success_save_data_stay', [
					anchor('administrator/permission', 'Permissions'),
					anchor('administrator/dashboard', ' Dashboard')
				]),

			];

		} else {

			$this->data = [

				'success' => false,

				'message' => cclang('data_not_change'),

			];

		}



		return $this->response($this->data);

	}



	/**

    * Get Access group

    *

    * @var String $group_id 

    */

    public function get_access_group($group_id)

    {

        if (!$this->is_allowed('access_list', false)) {

            echo '<center>Sorry you do not have permission to access</center>';

            exit;

        }

        $group_perms_groupping = [];



        $group_perms = $this->model_group->get_permission_group($group_id);

        foreach(db_get_all_data('aauth_perms') as $perms) { 
	    	$access = array('add','update','delete','list','view'); //20180503 by Benkin

            $group_name = 'other';

            $arr_dev = array('crud','form', 'skin option', 'user','rest', 'permission','page','extension','skin', 'setting', 'menu', 'group', 'access');

            $perm_tmp_arr = explode('_', $perms->name);

            if (isset($perm_tmp_arr[0]) AND !empty($perm_tmp_arr[0])) {

                $group_name =  strtolower($perm_tmp_arr[0]);
            }
            if ($perms->name_of_table!=NULL) {
            	$group_name =  strtolower(str_replace('_', ' ', $perms->name_of_table));
            }

            $group_perms_groupping[$group_name][] = $perms;

        }


        foreach($group_perms_groupping as $group_name => $childs) { 
        		if (!in_array($group_name, $arr_dev)) {
        	?>
        
            <tr class="">
                <td width="1">
					<label class="toggle-select-all-access flat-red check" data-target=".<?= str_replace(' ', '_', $group_name); ?>"><i class="fa fa-square-o"></i> 
					</label>				   
			    </td>
			    <td width="">
					<?= ucwords($group_name); ?>
			    </td>
                <?php foreach($childs as $perms) { 
                	$arr_menu = array('menu_list', 'menu_add', 'menu_update', 'menu_delete', 'menu_type_add');
					$temp_arr = explode('_', $perms->name); // explode perms->name 20180503 by Benkin
					if ((!in_array($perms->name, $arr_menu)) || $perms->name=='dashboard') { 
				?>
				<td width="145">
					<label style="font-weight:normal;">
						<input type="checkbox" class="flat-red check <?= str_replace(' ', '_', $group_name); ?>" name="id[]" value="<?= $perms->id; ?>" <?= array_search($perms->id, $group_perms) ? 'checked' : ''; ?>>
						<p><?= _ent(ucwords(clean_snake_case($perms->name))); ?></p>
					</label>
				</td>
				<?php } } ?>

<!--
                <div class="box box-primary box-solid">

                <div class="box-header with-border">




                  <div class="box-tools pull-right">

                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>

                    </button>

                  </div>

                </div>

                



                <div class="box-body" style="display: block;">

                <ul>

                    <?php /* foreach($childs as $perms) { 
                    	$temp_arr = explode('_', $perms->name); // explode perms->name 20180503 by Benkin
                    	if (in_array(end($temp_arr), $access) || $perms->name=='dashboard') { // get the last value in temp_arr and compare to access array
                    ?>

                    <li>

                        <label>

                            <input type="checkbox" class="flat-red check <?= $group_name; ?>" name="id[]" value="<?= $perms->id; ?>" <?= array_search($perms->id, $group_perms) ? 'checked' : ''; ?>>

                            <?= _ent(ucwords(clean_snake_case($perms->name))); ?>

                        </label>

                    </li>

                    <?php } } */?>

                </ul>



                </div>

              </div>
-->

            </tr>

            <?php

        } }

    }

	

}





/* End of file Access.php */

/* Location: ./application/controllers/administrator/Access.php */