<?php 
class Entity_comparisons extends Controller {

	function entity_comparisons()
	{
		parent::Controller();	
		$this->load->model('login_model');
		$this->load->library('session');
		$this->load->model('manage_registered_model');
		$this->load->model('manage_entity_model');
		$this->load->model('manage_seo_contents');
		$this->load->helper('financial_helper');
	}
	
	function comparisons($ename,$year = NULL)
	{
		//decode url valuee to plane id
		$name = explode("_",$ename);
	 	$arr['entity_id'] = $this->manage_entity_model->get_entity_id($name[0],$name[1],$name[2]);
	  	$e_id = $arr['entity_id'][0]['e_id'];
	  	$data = array('e_id'  => $e_id);
		$this->session->set_userdata($data); 
	 	$arr['e_name'] = $ename;
		
		$arr['entity_data'] = $this->manage_entity_model->get_entity_details($e_id);
		$arr['data_5'] = $this->manage_seo_contents->get_seo_content(24);

		
		//for active tab
		$arr['cur_tab'] = 'Comparisons';	
			 		
		if($this->session->userdata('user_id')!='')
		{
			$user_role_id = $this->session->userdata('user_role_id');
			$arr['entity_data'] = $this->manage_entity_model->get_entity_details($e_id); 
	
		}
		else
		{
			 $arr['e_id'] =	$e_id;
			 $arr['data'] = $this->manage_registered_model->get_unregistered_levels();
		}	
		$arr['e_id'] =	$e_id;
		$arr['entity_data'] = $this->manage_entity_model->get_entity_details($e_id);
		$arr['year_data'] = $this->manage_entity_model->get_entity_financial_year_new($e_id);

		//tag data...
		$arr['tag_data'] = $this->manage_entity_model->get_tag_data($e_id);

		//get user selected peers
		$user_pers= array();
		if($this->session->userdata('user_id') != '')
			$user_pers = $this->manage_entity_model->get_user_added_peer($this->session->userdata('user_id'));


		$admin_pers = $this->manage_entity_model->get_defaultPeers($e_id); 
		$new_peers = array();
		for($i=0; $i < count($admin_pers); $i++)
		{
			$new_peers[$i]['e_id'] = '';
			$new_peers[$i]['e_name'] = '';	
			$new_peers[$i]['type'] = 'A';				
			$new_peers[$i]['state_2char'] = '';	
			$new_peers[$i]['et_descr'] = '';	
									
			if( !empty($admin_pers[$i]['e_id']) )
			{
				$new_peers[$i]['e_id'] = $admin_pers[$i]['e_id'];
				$new_peers[$i]['e_name'] = $admin_pers[$i]['e_name'];	
				$new_peers[$i]['type'] = 'A';	
				$new_peers[$i]['state_2char'] =  $admin_pers[$i]['state_2char'];	
				$new_peers[$i]['et_descr'] = $admin_pers[$i]['et_descr'];									
			}
		}
				
		for($i=count($admin_pers),$j = 0 ; $j < count($user_pers); $i++,$j++)
		{
			$new_peers[$i]['e_id'] = '';
			$new_peers[$i]['e_name'] = '';	
			$new_peers[$i]['type'] = 'U';	
			$new_peers[$i]['state_2char'] = '';	
			$new_peers[$i]['et_descr'] = '';							
						
			if( !empty($user_pers[$j]['e_id']) )
			{
				$new_peers[$i]['e_id'] = $user_pers[$j]['e_id'];
				$new_peers[$i]['e_name'] = $user_pers[$j]['e_name'];	
				$new_peers[$i]['type'] = 'U';	
				$new_peers[$i]['state_2char'] =  $user_pers[$j]['state_2char'];	
				$new_peers[$i]['et_descr'] = $user_pers[$j]['et_descr'];											
			}
		}
		$arr['admin_pers'] = $new_peers;
		if($year == '')
		{
			$arr['cur_year'] = $arr['year_data'][0]->efs_year;
		}
		else
		{
			$arr['cur_year'] = $year;
		}
		$this->load->view('entity_comparisons',$arr);	
	}
	
	
	function ajax_entity_comparisons()
	{
		$e_id = $_REQUEST['e_id'];
		$year = $_REQUEST['year'];
		
		#----------Get Admin/User Peers---------#	
		//get user selected peers
		$user_pers= array();
		if($this->session->userdata('user_id') != '')
			$user_pers = $this->manage_entity_model->get_user_added_peer($this->session->userdata('user_id'));
//	echo '<pre>';
//	echo $this->db->last_query();
//	print_r($user_pers);
//	exit;
		//Get default peers 
		$admin_pers = $this->manage_entity_model->get_defaultPeers($e_id); 
		$new_peers = array();
		for($i=0; $i < count($admin_pers); $i++)
		{
			$new_peers[$i]['e_id'] = '';
			$new_peers[$i]['e_name'] = '';	
			$new_peers[$i]['type'] = 'A';				
			$new_peers[$i]['state_2char'] = '';	
			$new_peers[$i]['et_descr'] = '';	
									
			if( !empty($admin_pers[$i]['e_id']) )
			{
				$new_peers[$i]['e_id'] = $admin_pers[$i]['e_id'];
				$new_peers[$i]['e_name'] = $admin_pers[$i]['e_name'];	
				$new_peers[$i]['type'] = 'A';	
				$new_peers[$i]['state_2char'] =  $admin_pers[$i]['state_2char'];	
				$new_peers[$i]['et_descr'] = $admin_pers[$i]['et_descr'];									
			}
		}
				
		for($i=count($admin_pers),$j = 0 ; $j < count($user_pers); $i++,$j++)
		{
			$new_peers[$i]['e_id'] = '';
			$new_peers[$i]['e_name'] = '';	
			$new_peers[$i]['type'] = 'U';	
			$new_peers[$i]['state_2char'] = '';	
			$new_peers[$i]['et_descr'] = '';							
						
			if( !empty($user_pers[$j]['e_id']) )
			{
				$new_peers[$i]['e_id'] = $user_pers[$j]['e_id'];
				$new_peers[$i]['e_name'] = $user_pers[$j]['e_name'];	
				$new_peers[$i]['type'] = 'U';	
				$new_peers[$i]['state_2char'] =  $user_pers[$j]['state_2char'];	
				$new_peers[$i]['et_descr'] = $user_pers[$j]['et_descr'];											
			}
		}
		$arr['admin_pers'] = $new_peers;	
		//echo "<pre>"; print_r($arr['admin_pers']); echo "</pre>";exit;
		#----------End Admin/User Peers---------#			
		

		$arr['e_id'] =	$e_id;
		$arr['year'] =	$_REQUEST['year'];
		$arr['entity_data'] = $this->manage_entity_model->get_entity_details($e_id); 
		$arr['financial_data'] = $this->manage_entity_model->get_entity_financial_sum($e_id); // entity information 
		$arr['fund_data'] = $this->manage_entity_model->get_entity_financial_fund($e_id); 
		$arr['year_data'] = $this->manage_entity_model->get_entity_financial_year($e_id); 		    
		//echo "<pre>"; print_r($arr); echo "</pre>"; 
		$this->load->view('ajax_ entity_comparisons', $arr);			
	}

	function comparisons_new($ename,$year = NULL)
	{
		$name = explode("_",$ename);
	 	$arr['entity_id'] = $this->manage_entity_model->get_entity_id($name[0],$name[1],$name[2]);
	  	$e_id = $arr['entity_id'][0]['e_id'];
	  	$data = array('e_id'  => $e_id);
		$this->session->set_userdata($data); 
		
	 	$arr['e_name'] = $ename;
		$arr['entity_data'] = $this->manage_entity_model->get_entity_details($e_id);
		$arr['data_5'] = $this->manage_seo_contents->get_seo_content(24);
		//for active tab
		$arr['cur_tab'] = 'Comparisons';	
			 		
		if($this->session->userdata('user_id')!='')
		{
			$user_role_id = $this->session->userdata('user_role_id');
			$arr['entity_data'] = $this->manage_entity_model->get_entity_details($e_id); 
		}
		else
		{
			 $arr['e_id'] =	$e_id;
			 $arr['data'] = $this->manage_registered_model->get_unregistered_levels();
		}
		$arr['e_id'] =	$e_id;	
		$arr['entity_data'] = $this->manage_entity_model->get_entity_details($e_id); 
		$arr['financial_data'] = $this->manage_entity_model->get_entity_financial_sum($e_id); // entity information 
		$arr['fund_data'] = $this->manage_entity_model->get_entity_financial_fund($e_id); 
		$arr['year_data'] = $this->manage_entity_model->get_entity_financial_year_new($e_id);
		//START...
		$meta_data = $this->manage_entity_model->getEfsData($e_id);

		$parent_ids = array();
		$depth5_arr = array();
		//$depth5_arr = $this->manage_entity_model->get_depth5_rec();
		for($i=0; $i < count($meta_data); $i++)
		{
			//DONE (manage_entity_model) line 996...
			$meta_data[$i]['parent_tree'] = $this->manage_entity_model->getParent_tree($meta_data[$i]['efs_object']);

			if ( ! in_array($meta_data[$i]['t_depth'],$parent_ids ))
			{
				array_push($parent_ids,$meta_data[$i]['t_depth']);
			}
			//this code remove the depth_5 tag whos parent tag is not FINANCIAL...(coz now we added COMBINING_AN... tag but it is useful for future.. just comment this for loop to get all 5 depth arr)...
			for($a = 0; $a < count($meta_data[$i]['parent_tree']); $a++)
			{
				if($meta_data[$i]['parent_tree'][$a]['t_depth'] == 5 and !in_array($meta_data[$i]['parent_tree'][$a]['t_id'],$depth5_arr))
				{
					$fin_parent_status = display_parent_tag($meta_data[$i]['parent_tree'][$a]['t_id']);
					if($fin_parent_status == 'Financial')
						array_push($depth5_arr,$meta_data[$i]['parent_tree'][$a]['t_id']);
				}
			}
		}


		$arr['depth5_arr'] = $depth5_arr;
		//DONE (manage_entity_model) line 996...
		if(! empty($depth5_arr))
			$arr['depth5_arr'] = $this->manage_entity_model->getDepth5_arr($depth5_arr);
		else
			$arr['depth5_arr'] = array();

		for($z=0; $z < count($arr['depth5_arr']); $z++)
		{
			$depth5_arr[$z] = $arr['depth5_arr'][$z]['t_id'];
		}
		$arr['depth5_arr'] = $depth5_arr;
		//END...
		$user_pers= array();
		if($this->session->userdata('user_id') != '')
			$user_pers = $this->manage_entity_model->get_user_added_peer($this->session->userdata('user_id'));
		$arr['year'] = $year;
		$admin_pers = $this->manage_entity_model->get_defaultPeers($e_id);
		$new_peers = array();
		for($i=0; $i < count($admin_pers); $i++)
		{
			$new_peers[$i]['e_id'] = '';
			$new_peers[$i]['e_name'] = '';	
			$new_peers[$i]['type'] = 'A';				
			$new_peers[$i]['state_2char'] = '';	
			$new_peers[$i]['et_descr'] = '';	
									
			if( !empty($admin_pers[$i]['e_id']) )
			{
				$new_peers[$i]['e_id'] = $admin_pers[$i]['e_id'];
				$new_peers[$i]['e_name'] = $admin_pers[$i]['e_name'];	
				$new_peers[$i]['type'] = 'A';	
				$new_peers[$i]['state_2char'] =  $admin_pers[$i]['state_2char'];	
				$new_peers[$i]['et_descr'] = $admin_pers[$i]['et_descr'];									
			}
		}
				
		for($i=count($admin_pers),$j = 0 ; $j < count($user_pers); $i++,$j++)
		{
			$new_peers[$i]['e_id'] = '';
			$new_peers[$i]['e_name'] = '';	
			$new_peers[$i]['type'] = 'U';	
			$new_peers[$i]['state_2char'] = '';	
			$new_peers[$i]['et_descr'] = '';							
						
			if( !empty($user_pers[$j]['e_id']) )
			{
				$new_peers[$i]['e_id'] = $user_pers[$j]['e_id'];
				$new_peers[$i]['e_name'] = $user_pers[$j]['e_name'];	
				$new_peers[$i]['type'] = 'U';	
				$new_peers[$i]['state_2char'] =  $user_pers[$j]['state_2char'];	
				$new_peers[$i]['et_descr'] = $user_pers[$j]['et_descr'];											
			}
		}
		$arr['admin_pers'] = $new_peers;

		$this->load->view('vw_entity_comparisons',$arr);	
	}

	function ajax_entity_comparisons_new()
	{
		$e_id = $_REQUEST['e_id'];
		$year = $_REQUEST['year'];

		#----------Get Admin/User Peers---------#	
		//get user selected peers
		$user_pers= array();
		if($this->session->userdata('user_id') != '')
			$user_pers = $this->manage_entity_model->get_user_added_peer($this->session->userdata('user_id'));
	
		//Get default peers 
		$admin_pers = $this->manage_entity_model->get_defaultPeers($e_id); 

		$new_peers = array();
		for($i=0; $i < count($admin_pers); $i++)
		{
			$new_peers[$i]['e_id'] = '';
			$new_peers[$i]['e_name'] = '';	
			$new_peers[$i]['type'] = 'A';				
			$new_peers[$i]['state_2char'] = '';	
			$new_peers[$i]['et_descr'] = '';	
									
			if( !empty($admin_pers[$i]['e_id']) )
			{
				$new_peers[$i]['e_id'] = $admin_pers[$i]['e_id'];
				$new_peers[$i]['e_name'] = $admin_pers[$i]['e_name'];	
				$new_peers[$i]['type'] = 'A';	
				$new_peers[$i]['state_2char'] =  $admin_pers[$i]['state_2char'];	
				$new_peers[$i]['et_descr'] = $admin_pers[$i]['et_descr'];									
			}
		}
				
		for($i=count($admin_pers),$j = 0 ; $j < count($user_pers); $i++,$j++)
		{
			$new_peers[$i]['e_id'] = '';
			$new_peers[$i]['e_name'] = '';	
			$new_peers[$i]['type'] = 'U';	
			$new_peers[$i]['state_2char'] = '';	
			$new_peers[$i]['et_descr'] = '';							
						
			if( !empty($user_pers[$j]['e_id']) )
			{
				$new_peers[$i]['e_id'] = $user_pers[$j]['e_id'];
				$new_peers[$i]['e_name'] = $user_pers[$j]['e_name'];	
				$new_peers[$i]['type'] = 'U';	
				$new_peers[$i]['state_2char'] =  $user_pers[$j]['state_2char'];	
				$new_peers[$i]['et_descr'] = $user_pers[$j]['et_descr'];											
			}
		}
		$arr['admin_pers'] = $new_peers;	
		//echo "<pre>"; print_r($new_peers); echo "</pre>";		
		#----------End Admin/User Peers---------#			
		

		$arr['e_id'] =	$e_id;
		$arr['year'] =	$_REQUEST['year'];
		$arr['entity_data'] = $this->manage_entity_model->get_entity_details($e_id);
		$arr['financial_data'] = $this->manage_entity_model->get_entity_financial_sum($e_id); // entity information 
		$arr['fund_data'] = $this->manage_entity_model->get_entity_financial_fund($e_id); 
		$arr['year_data'] = $this->manage_entity_model->get_entity_financial_year($e_id);

		//START...
		$arr['meta_data'] = $this->manage_entity_model->getEfsData($e_id);
//			echo '<pre>';
	//			print_r($arr['meta_data']);
		//	exit;
			$parent_ids = array();
			$depth5_arr = array();
			//$depth5_arr = $this->manage_entity_model->get_depth5_rec();
			for($i=0; $i < count($arr['meta_data']); $i++)
			{
				//DONE (manage_entity_model) line 996...
				$arr['meta_data'][$i]['parent_tree'] = $this->manage_entity_model->getParent_tree($arr['meta_data'][$i]['efs_object']);

				if ( ! in_array($arr['meta_data'][$i]['t_depth'],$parent_ids ))
				{
					array_push($parent_ids,$arr['meta_data'][$i]['t_depth']);
				}
				//this code remove the depth_5 tag whos parent tag is not FINANCIAL...(coz now we added COMBINING_AN... tag but it is useful for future.. just comment this for loop to get all 5 depth arr)...
				for($a = 0; $a < count($arr['meta_data'][$i]['parent_tree']); $a++)
				{
					if($arr['meta_data'][$i]['parent_tree'][$a]['t_depth'] == 5 and !in_array($arr['meta_data'][$i]['parent_tree'][$a]['t_id'],$depth5_arr))
					{
						$fin_parent_status = display_parent_tag($arr['meta_data'][$i]['parent_tree'][$a]['t_id']);
						if($fin_parent_status == 'Financial')
							array_push($depth5_arr,$arr['meta_data'][$i]['parent_tree'][$a]['t_id']);
					}
				}
			}

			$arr['depth5_arr'] = $depth5_arr;
			//DONE (manage_entity_model) line 996...
			if(! empty($depth5_arr))
				$arr['depth5_arr'] = $this->manage_entity_model->getDepth5_arr($depth5_arr);
			else
				$arr['depth5_arr'] = array();

			for($z=0; $z < count($arr['depth5_arr']); $z++)
			{
				$depth5_arr[$z] = $arr['depth5_arr'][$z]['t_id'];
			}
			$arr['depth5_arr'] = $depth5_arr;
		//END...
		$this->load->view('vw_ajax_entity_comparisons', $arr);			
	}
	
	function get_data($limit = 10)
	{
		$sql = "SELECT * FROM users limit ".$limit;
		echo '<pre>';
			print_r($this->db->query($sql)->result_array());
		exit;
	}
	
	function drill_up()
	{
		//get user selected peers
		$user_pers= array();
		if($this->session->userdata('user_id') != '')
			$user_pers = $this->manage_entity_model->get_user_added_peer($this->session->userdata('user_id'));


		$admin_pers = $this->manage_entity_model->get_defaultPeers($_REQUEST['e_id']); 
		$new_peers = array();
		for($i=0; $i < count($admin_pers); $i++)
		{
			$new_peers[$i]['e_id'] = '';
			$new_peers[$i]['e_name'] = '';	
			$new_peers[$i]['type'] = 'A';				
			$new_peers[$i]['state_2char'] = '';	
			$new_peers[$i]['et_descr'] = '';	
									
			if( !empty($admin_pers[$i]['e_id']) )
			{
				$new_peers[$i]['e_id'] = $admin_pers[$i]['e_id'];
				$new_peers[$i]['e_name'] = $admin_pers[$i]['e_name'];	
				$new_peers[$i]['type'] = 'A';	
				$new_peers[$i]['state_2char'] =  $admin_pers[$i]['state_2char'];	
				$new_peers[$i]['et_descr'] = $admin_pers[$i]['et_descr'];									
			}
		}
				
		for($i=count($admin_pers),$j = 0 ; $j < count($user_pers); $i++,$j++)
		{
			$new_peers[$i]['e_id'] = '';
			$new_peers[$i]['e_name'] = '';	
			$new_peers[$i]['type'] = 'U';	
			$new_peers[$i]['state_2char'] = '';	
			$new_peers[$i]['et_descr'] = '';							
						
			if( !empty($user_pers[$j]['e_id']) )
			{
				$new_peers[$i]['e_id'] = $user_pers[$j]['e_id'];
				$new_peers[$i]['e_name'] = $user_pers[$j]['e_name'];	
				$new_peers[$i]['type'] = 'U';	
				$new_peers[$i]['state_2char'] =  $user_pers[$j]['state_2char'];	
				$new_peers[$i]['et_descr'] = $user_pers[$j]['et_descr'];											
			}
		}
		$admin_pers = $new_peers;

		$tag_data = $this->manage_entity_model->get_tag_data_drill_up($_REQUEST['e_id']);

		$arr = $this->manage_entity_model->getChild_tree($_REQUEST['t_id'], $tag_data);
		$arr_tag = array();
		for($j=0; $j<count($tag_data); $j++)
		{
			$arr_tag[$tag_data[$j]['t_id']] = $tag_data[$j];
		}
		
		$e_parent_ids = '';
		for($i = 0;$i <count($arr['parent_ids']);$i++)
		{
			if($i === 0)
				$e_parent_ids = $arr['parent_ids'][$i];
			else
				$e_parent_ids .= ",".$arr['parent_ids'][$i];
		}
		
		$cnt = 0;
		for($i = 0;$i <count($arr['all_ids']);$i++)
		{
			if($i === 0)
				$e_all_ids = $arr['all_ids'][$i]."~".$arr_tag[$arr['all_ids'][$i]]['t_total_tag'];
			else
				$e_all_ids .= ",".$arr['all_ids'][$i]."~".$arr_tag[$arr['all_ids'][$i]]['t_total_tag'];
			if( ! in_array($arr['all_ids'][$i],$arr['parent_ids']) and $arr_tag[$arr['all_ids'][$i]]['t_total_tag'] == 'f')
			{
				$child_ids[$cnt] = $arr['all_ids'][$i];
				$cnt++;
			}
		}

		$e_id_year_data = get_year_data_drill($_REQUEST['e_id'], $_REQUEST['cur_year']);
		
		$parent_yr_total_amt = 0;
		for($z = 0;$z < count($child_ids);$z++)
		{
			if(isset($e_id_year_data[$child_ids[$z]]['amt']))
			{
				if($e_id_year_data[$child_ids[$z]]['scaler'] != 'P')
					$parent_yr_total_amt += $e_id_year_data[$child_ids[$z]]['amt'];
			}
		}

		$master_yr_total_amt = '';
		for($m = 0;$m<count($admin_pers); $m++)
		{
			$tag_data = $this->manage_entity_model->get_tag_data_drill_up($admin_pers[$m]['e_id']);

			$arr = $this->manage_entity_model->getChild_tree($_REQUEST['t_id'], $tag_data);
			$arr_tag = array();
			for($j=0; $j<count($tag_data); $j++)
			{
				$arr_tag[$tag_data[$j]['t_id']] = $tag_data[$j];
			}

			$parent_ids = '';
			for($i = 0;$i <count($arr['parent_ids']);$i++)
			{
				if($i === 0)
					$parent_ids = $arr['parent_ids'][$i];
				else
					$parent_ids .= ",".$arr['parent_ids'][$i];
			}

			$cnt = 0;
			for($i = 0;$i <count($arr['all_ids']);$i++)
			{
				if($i === 0)
					$all_ids = $arr['all_ids'][$i]."~".$arr_tag[$arr['all_ids'][$i]]['t_total_tag'];
				else
					$all_ids .= ",".$arr['all_ids'][$i]."~".$arr_tag[$arr['all_ids'][$i]]['t_total_tag'];
				if( ! in_array($arr['all_ids'][$i],$arr['parent_ids']) and $arr_tag[$arr['all_ids'][$i]]['t_total_tag'] == 'f')
				{
					$child_ids[$cnt] = $arr['all_ids'][$i];
					$cnt++;
				}
			}

			$e_id_year_data = get_year_data_drill($admin_pers[$m]['e_id'],  $_REQUEST['cur_year']);

			$yr_total_amt = 0;
			$yr_total_amt = 0;
			$child_ids;

			for($z = 0;$z < count($child_ids);$z++)
			{
				if(isset($e_id_year_data[$child_ids[$z]]['amt']))
				{
					if($e_id_year_data[$child_ids[$z]]['scaler'] != 'P')
						$yr_total_amt += $e_id_year_data[$child_ids[$z]]['amt'];
				}
			}
			
			if($m === 0)
				$master_yr_total_amt = $yr_total_amt;
			else
				$master_yr_total_amt .= ",".$yr_total_amt;
		}
		echo $e_all_ids.'_SEPRATOR_'.$e_parent_ids.'_SEPRATOR_'.$parent_yr_total_amt.'_SEPRATOR_'.$master_yr_total_amt;
	}
}// END OF CLASS
?>