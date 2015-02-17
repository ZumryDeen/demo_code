<?php
class Manage_entity_model extends Model 
{
	function manage_entity_model()
	{
		parent::Model(); 
	}
 
 	function getAllenitity_count($entity_name = '')   // get all user count for pagination  
	{
		$search_keyword = preg_replace("/[^a-zA-Z0-9]/", "", $entity_name);
		if(!empty($search_keyword))
		{
			$sql = "select * from entity_full_text_search, entity LEFT JOIN entity_type ON entity_type.et_id = entity.e_type_id  LEFT JOIN states ON states.state_id = entity.e_state_id where plainto_tsquery('english', '".$search_keyword."') @@ efts_vector and efts_entity = e_id and e_type_id in (4,5,6,7) order by e_name";
	 		$cnt = $this->db->query($sql)->result_array();
		
			return  count($cnt);		
		}
		else
		{
			$this->db->select('count(*)');
			$this->db->from('entity');
			$this->db->join('entity_type','entity_type.et_id = entity.e_type_id','LEFT');
			$this->db->join('county_codes', 'county_codes.cnty_id = entity.e_cnty_id','LEFT');
			$this->db->join('states', 'states.state_id = entity.e_state_id','LEFT');
			$this->db->like('lower(e_name)',strtolower($search_keyword));
			$this->db->where('entity.e_status','A');

			$rSetData = $this->db->get()->result_array();
			return $rSetData[0]['count'];
		}
	} 	

	 function getenitity($num,$offset,$entity_name=NULL,$sort,$order_by) // get all Entity infimation 
	 { 
			if(!empty($entity_name))
			{
				$this->db->like('lower(e_name)', strtolower($entity_name));
			}
			$this->db->select('entity.*,entity_type.et_descr,entity_type.et_id,entity_gov_type.egt_id,entity_gov_type.egt_descr,states.state_id,states.state_name');
			$this->db->from('entity');
			$this->db->join('entity_type','entity_type.et_id = entity.e_type_id','LEFT');
			$this->db->join('entity_gov_type','entity_gov_type.egt_id = entity.e_gov_type_id','LEFT');
			$this->db->join('states','states.state_id = entity.e_state_id','LEFT');
			$this->db->where('entity.e_status','A');
			$this->db->order_by("entity.e_name","ASC"); 
			$this->db->limit($num,$offset);
			return $this->db->get()->result_array();
 	}
	
	function getAllenititypersonnel_count($entity_name)   // get all user count for pagination  
	{
	 
/*	  if(!empty($entity_name))
	  {
			$this->db->like('lower(e_name)', strtolower($entity_name));
	  }
		$this->db->where(array('e_status'=>'A'));
		$this->db->order_by("e_name ", "desc"); 
		$total_rows = $this->db->get('entity') ;
		return $rowcount = $total_rows->num_rows();*/
		
		if(!empty($entity_name))
		{
			$sql = "select * from entity_full_text_search, entity LEFT JOIN entity_type ON entity_type.et_id = entity.e_type_id  LEFT JOIN states ON states.state_id = entity.e_state_id where plainto_tsquery('english', '".$entity_name."') @@ efts_vector and efts_entity = e_id and e_type_id in (4,5,6,7) order by e_name";
	 		$cnt = $this->db->query($sql)->result_array();
		
			return  count($cnt);		
		}
		else
		{
			$this->db->where(array('e_status'=>'A'));
			$this->db->order_by("e_name ", "desc"); 
			$total_rows = $this->db->get('entity') ;
			return $rowcount = $total_rows->num_rows();		
		}
	} 	


	function getenititypersonnel($num,$offset,$entity_name=NULL,$sort,$order_by) // get all Entity infimation 
	 { 
			if(!empty($entity_name))
			{
				$this->db->like('lower(e_name)', strtolower($entity_name));
			}
			$this->db->select('personnel.*,entity.*,entity_type.et_descr,entity_type.et_id,entity_gov_type.egt_id,entity_gov_type.egt_descr,states.state_id,states.state_name');
			$this->db->from('personnel');
			$this->db->join('entity','entity.e_id = personnel.p_entity_id','LEFT');
			$this->db->join('entity_type','entity_type.et_id = entity.e_type_id','LEFT');
			$this->db->join('entity_gov_type','entity_gov_type.egt_id = entity.e_gov_type_id','LEFT');
			$this->db->join('states','states.state_id = entity.e_state_id','LEFT');
			$this->db->where('entity.e_status','A');
			$this->db->order_by("entity.e_name","ASC"); 
			$this->db->limit($num,$offset);
			return $this->db->get()->result_array();
 	}
	
	
	function entity_type_dropdown()
	 { 
		$this->db->select('*');
		$this->db->from('entity_type');
	    $this->db->order_by("et_id", "asc"); 
	    return $this->db->get()->result_array();
	 }
	 function get_userrole_dropdown()
	 { 
		$this->db->select('*');
		$this->db->from('entity_type');
	    $this->db->order_by("et_id", "asc"); 
	    return $this->db->get()->result_array();
    }
    
    
	function get_status_dropdown()
	 { 
		$this->db->select('*');
		$this->db->from('user_status');
	    $this->db->order_by("us_id", "asc"); 
	    return $this->db->get()->result_array();
    }
	 
	 
	 function get_govttype()
	 {
		$this->db->select('*');
		$this->db->from('entity_gov_type');
	    $this->db->order_by("egt_id", "asc"); 
	    return $this->db->get()->result_array();
	 }
	 
	function get_states($county_id)
	{  
	    $this->db->select('*');
		$this->db->from('states');
	    $this->db->where('state_country_code',$county_id);
	 	$this->db->order_by("state_name", "asc");    
		return $this->db->get()->result_array();
	   /* print($this->db->last_query()); 
	  		 die;*/
	} 
	
	function getUserDetailsInfo($userid) // view single user information function 
	{  
		$this->db->select('*');
		$this->db->from('users');
	    $this->db->join('user_status', 'user_status.us_id = users.user_status_id','LEFT');
		$this->db->join('user_roles', 'user_roles.ur_id = users.user_role_id','LEFT');
		$this->db->where('users.user_id',$userid);
	 	$this->db->order_by("users.user_id", "asc"); 
	 	return $this->db->get()->result_array();
 	}
	
 	
	function get_data_single_user($userid) // view single user information  function 
	{
	 	$this->db->select('*');
		$this->db->from('users');
	    $this->db->join('user_status', 'user_status.us_id = users.user_status_id','LEFT');
		$this->db->join('user_roles', 'user_roles.ur_id = users.user_role_id','LEFT');
		$this->db->join('states', 'states.state_id = users.user_state','LEFT');
		$this->db->join('country_codes', 'country_codes.ct_id = users.user_country','LEFT');
		$this->db->where('users.user_id',$userid);
	 	$this->db->order_by("users.user_id", "asc"); 
	 	return $this->db->get()->result_array();
	}

	function change_user_status($user_id,$status) // change users status 
	{ 
		if(trim($status)=="Suspended")
		{
			$status= 1;
		}
		else if(trim($status)!="Suspended")
		{
			$status=4;
		}
		$data = array('user_status_id'=>$status);
		$this->db->where('user_id',$user_id);
		return $this->db->update('users',$data);
	}

	function detete_users($arr) // delete users record 
	{ 
		if(count($arr)>0)
		{
			$ids = implode(',',$arr);
		}
		else
		{
			$ids = $id;
		}
		
			$data = array('user_status_id'=>5);

			$this->db->where('user_id IN('.$ids.')');
			return $this->db->update('users',$data);
	}

function insertUser($arr)
{ 
		   
		    if($this->input->post('newsletter')=='TRUE') {
				 $newsletter = "TRUE";
			}
			else
			{
			 	$newsletter = "FALSE";
		 	}
			$data = array(
			'user_fname'=>$this->input->post('firstname'),
			'user_mi'=>$this->input->post('middlename'),
			'user_lname'=>$this->input->post('lastname'),
			'user_address1'=>$this->input->post('permanent_address'),
			'user_address2'=>$this->input->post('local_address'),
			'user_country'=>$this->input->post('country_id'),
			'user_city'=>$this->input->post('city'),
			'user_state'=>$this->input->post('state_id'),
			'user_zip'=>$this->input->post('zip'),
			'user_phone'=>$this->input->post('phone'),
			'user_mobile'=>$this->input->post('mobile'),
			'user_email'=>$this->input->post('email'),
			'user_alt_email'=>$this->input->post('alt_email'),
			'user_password'=>$this->input->post('confirm_password'), 
			'user_created_ts'=>'now()',
			'user_modified_ts'=>'now()',
			'user_status_id'=>$this->input->post('status_id'),
			'user_role_id'=>$this->input->post('role_id'),
	    	'user_last_login_ts'=>'now()',
			'user_login_ct'=>'1',
			'user_pref_newsletter'=>$newsletter,
			'user_pref_email_fmt'=>$this->input->post('format'),
			'user_reset_pwd_flg'=>'TRUE' );
             $this->db->insert('users', $data);

 /*print($this->db->last_query()); 
	  		 die;*/
	 return $userId=$this->db->insert_id();
	
}
	function updateUser($user_id,$_POST)
	{
		extract($_POST);
	/*print_r($_POST);
		exit;*/
			if($this->input->post('user_pref_newsletter')=='TRUE') {
				 $newsletter = "TRUE";
			}
			else
			{
			 	$newsletter = "FALSE";
		 	}
			
			$data_update = array(
			'user_fname'=>$this->input->post('user_fname'),
			'user_mi'=>$this->input->post('user_mi'),
			'user_lname'=>$this->input->post('user_lname'),
			'user_address1'=>$this->input->post('user_address1'),
			'user_address2'=>$this->input->post('user_address2'),
			'user_country'=>$this->input->post('user_country'),
			'user_state'=>$this->input->post('user_state'),
			'user_city'=>$this->input->post('user_city'),
	 		'user_zip'=>$this->input->post('user_zip'),
			'user_phone'=>$this->input->post('user_phone'),
			'user_mobile'=>$this->input->post('user_mobile'),
			'user_email'=>$this->input->post('user_email'),
			'user_alt_email'=>$this->input->post('user_alt_email'),
			'user_modified_ts'=>'now()',
			'user_status_id'=>$this->input->post('user_status_id'),
			'user_role_id'=>$this->input->post('user_role_id'),
	    	'user_pref_newsletter'=>$newsletter,
			'user_pref_email_fmt'=>$this->input->post('user_pref_email_fmt'),
			'user_reset_pwd_flg'=>'TRUE' );
	  		$this->db->where('user_id', $id);
			$this->db->update('users', $data_update); 
			return true;
	}
	
 
// FUNCTION TO CHECK WHETHER Username  EXISTS OR NOT
	function chkUsernameExist($username)
	{
		$query = $this->db->get_where('tbl_users', array('username'=>$username));		
		return  $query->result();
	}

// FUNCTION TO CHECK WHETHER EMAIL EXISTS OR NOT
	function chkEmailExist($email)
	{
		$query = $this->db->get_where('users', array('user_email'=>$email));		
		return  $query->result();
	}
	
	function get_userdata()
	{
		$user_id = $this->input->post('user_id'); 
		$sql_query="SELECT * FROM tbl_users  WHERE user_id = '$user_id'";
		return $this->db->query($sql_query)->result_array();
	}
	
	function getUserAccess($id) // view single user information function 
	{  
		$this->db->select('*');
		$this->db->from('entity_admin');
		$this->db->join('users', 'users.user_id = entity_admin.eadm_user','LEFT');
		$this->db->join('user_roles', 'user_roles.ur_id = entity_admin.eadm_role','LEFT');
		$this->db->join('entity', 'entity.e_id = entity_admin.eadm_entity','LEFT');
		$this->db->where('entity_admin.eadm_id',$id);
		return $this->db->get()->result_array();
 	}
	/*function get_entity_logo($e_id) // view single user information function 
	{  

		$this->db->select('*');
		$this->db->from('entity');
		$this->db->join('entity_logo', 'entity_logo.el_id = entity.e_id','LEFT');
		$this->db->where('entity_admin.eadm_id',$id);
		return $this->db->get()->result_array();
 	}*/
	
	function viewAllAccess($userid) //view all acees privilage for user
	{	
		$this->db->select('*');
		$this->db->from('entity_admin');
		$this->db->join('users', 'users.user_id = entity_admin.eadm_user','LEFT');
		$this->db->join('user_roles', 'user_roles.ur_id = entity_admin.eadm_role','LEFT');
		$this->db->join('entity', 'entity.e_id = entity_admin.eadm_entity','LEFT');
		$this->db->where('entity_admin.eadm_user',$userid);
		return $this->db->get()->result_array();
	}
	function updateAccess($id,$access,$value)
	{
		$this->db->update("entity_admin",array($access=>$value),array("eadm_id"=>$id));
	}
	
	 
	
	//function to add access
	function add_access($data)
	{
		$this->db->insert("entity_admin",$data);
	}
	
	//function to delte acces data is array of id
	function delete_access($data)
	{
		foreach($data as $id)
		{
			$this->db->delete('entity_admin',array("eadm_id"=>$id));
		}
		//$this->db->delete('entity_admin');
	}
	/*function updateUser($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->update('tbl_users', $data_update); 
		return true;
	}*/
	
	function insertEntity($data)
	{
		return $this->db->insert('entity', $data);
	}
	
	function change_entity_status($entity_id,$status)
	{
		if(trim($status)=="A")
		{
			$status="I";
		}
		else if(trim($status)=="I")
		{
			$status="A";
		}
		$data = array('e_status'=>$status);
		$this->db->where('e_id',$entity_id);
		return $this->db->update('entity',$data);
	}
	
	function get_data_single_entity($entity_id)
	{
		//$this->db->select('*');
		$this->db->select('entity.*,entity_type.et_descr,entity_type.et_id,entity_gov_type.egt_id,entity_gov_type.egt_descr,states.state_id,states.state_name,country_codes.ct_name');
		$this->db->from('entity');
		$this->db->join('entity_type','entity_type.et_id = entity.e_type_id','LEFT');
	    $this->db->join('country_codes', 'country_codes.ct_id = entity.e_cnty_id','LEFT');
		$this->db->join('states', 'states.state_id = entity.e_state_id','LEFT');
		$this->db->join('entity_gov_type', 'entity_gov_type.egt_id = entity.e_gov_type_id','LEFT');		
		$this->db->where('entity.e_id',$entity_id);
		$this->db->order_by("entity.e_id", "asc"); 
	 	return $this->db->get()->result_array();
	}
	
	function getEntityDetailsInfo($entity_id)
	{
		$this->db->select('*');
		$this->db->from('entity');
		$this->db->where('entity.e_id',$entity_id);
		$this->db->order_by("entity.e_id", "asc"); 
	 	return $this->db->get()->result_array();
	}
	
	function updateEntity($entity_id,$arr)
	{	
		$this->db->where('e_id', $entity_id);
		$this->db->update('entity', $arr[0]); 
		return true;
	}
	
	function detete_entity($arr) // delete entity record 
	{ 
		if(count($arr)>0)
		{
			$ids = implode(',',$arr);
		}
		else
		{
			$ids = $id;
		}
		$data = array('e_status'=>'D');
		$this->db->where('e_id IN('.$ids.')');
		return $this->db->update('entity',$data);
	}
		
	//code by mayur...............
	//function which return the result of all entities related to the word in search box.................
	function searchEntity($num,$offset,$search)
	{ 	
/*		$this->db->select('*');
		$this->db->from('entity');
		$this->db->join('entity_type','entity_type.et_id = entity.e_type_id','LEFT');
		$this->db->join('county_codes', 'county_codes.cnty_id = entity.e_cnty_id','LEFT');
 		$this->db->join('states', 'states.state_id = entity.e_state_id','LEFT');
		$this->db->like('lower(e_name)',strtolower($search));
		$this->db->where('entity.e_status','A');		
		$this->db->limit($num,$offset);
	 	$this->db->order_by("entity.e_name", "ASC"); 				
		 $this->db->get()->result_array();
		
		print_r($this->db->last_query()); */


		//$search_keyword = preg_replace("/[^a-zA-Z0-9]/", "", $search);
		$search_keyword = preg_replace("/[^a-zA-Z0-9\\ ]/i", "", $search);
		if(!empty($search_keyword))
		{

			$sql = "select * from entity_full_text_search, entity LEFT JOIN entity_type ON entity_type.et_id = entity.e_type_id  LEFT JOIN states ON states.state_id = entity.e_state_id where plainto_tsquery('english', '". $search_keyword ."') @@ efts_vector and efts_entity = e_id and e_type_id in (4,5,6,7) order by e_name LIMIT ".$num." OFFSET ".$offset;

			return $this->db->query($sql)->result_array();
		}
		else
		{
		
			$this->db->select('*');
			$this->db->from('entity');
			$this->db->join('entity_type','entity_type.et_id = entity.e_type_id','LEFT');
			$this->db->join('county_codes', 'county_codes.cnty_id = entity.e_cnty_id','LEFT');
			$this->db->join('states', 'states.state_id = entity.e_state_id','LEFT');
			$this->db->like('lower(e_name)',strtolower($search_keyword));
			$this->db->where('entity.e_status','A');		
			$this->db->limit($num,$offset);
			$this->db->order_by("entity.e_name", "ASC"); 				
			return $this->db->get()->result_array();		
		}
	}
	
	function get_entity_id($ename,$estate,$ecity) 
	{   
		$this->db->select('*');
		$this->db->from('entity'); 
		$this->db->join('county_codes', 'county_codes.cnty_id = entity.e_cnty_id','LEFT');
 		$this->db->join('states', 'states.state_id = entity.e_state_id','LEFT');
		$this->db->join('entity_type', 'entity_type.et_id = entity.e_type_id','LEFT');
	 	$this->db->where(array("replace(entity.e_name,'#','') ="=>$ename,'states.state_2char ='=>$estate ,'entity_type.et_descr ='=>$ecity));
	 	$this->db->order_by("entity.e_id", "asc"); 
	 	return $this->db->get()->result_array();
 	} 
	
	
	function get_entity_details($eid) // view single user information  function 
	{
	  //	cnty_id 	cnty_state_id 	cnty_code 	cnty_name
	 	$this->db->select('entity.e_id,entity.e_name,entity.e_type_id,entity.e_state_id,entity.e_cnty_id,entity.e_descr,county_codes.cnty_id,county_codes.cnty_state_id,county_codes.cnty_code,county_codes.cnty_name,entity_logo.el_id,entity_logo.el_filename,entity_logo.el_filename,entity_logo.el_status,entity_logo.el_ext,states.state_id,states.state_2char,states.state_name,states.state_country_code,states.state_in_country_code,demographics_1.dem_1_e_id,entity_gov_type.egt_id,entity_gov_type.egt_descr,entity_budget_summary.ebs_id,entity_budget_summary.ebs_e_id,entity_budget_summary.ebs_yr,entity_budget_summary.ebs_budget,entity_type.et_id,entity_type.et_descr,entity_internet_resource.eir_id,entity_internet_resource.eir_entity_id,entity_internet_resource.eir_type,entity_internet_resource.eir_data,entity_internet_resource.eir_descr,entity_internet_resource.eir_seq');
		$this->db->from('entity'); 
		$this->db->join('county_codes', 'county_codes.cnty_id = entity.e_cnty_id','LEFT');
		$this->db->join('entity_logo', 'entity_logo.el_id = entity.e_id','LEFT');
		$this->db->join('states', 'states.state_id = entity.e_state_id','LEFT');
		$this->db->join('demographics_1', 'demographics_1.dem_1_e_id = entity.e_id','LEFT');
		$this->db->join('entity_gov_type', 'entity_gov_type.egt_id = entity.e_gov_type_id','LEFT');
		$this->db->join('entity_budget_summary', 'entity_budget_summary.ebs_e_id = entity.e_id','LEFT');
		$this->db->join('entity_type', 'entity_type.et_id = entity.e_type_id','LEFT');
		$this->db->join('entity_internet_resource', 'entity_internet_resource.eir_entity_id = entity.e_id','LEFT');
		$this->db->where('entity.e_id',$eid);
	 	$this->db->order_by("entity.e_id", "asc"); 
	 	return $this->db->get()->result_array();
		//print($this->db->last_query()); 
	}
	
	function get_entity_overview($eid) // view single user information  function 
	{
		
	 	$this->db->select('entity.e_id,entity.e_name,entity.e_lat,entity.e_long,entity.e_id,entity.e_cpa_firm,entity.e_cpa_contact_fname,entity.e_cpa_contact_title, entity.e_cpa_address1,entity.e_cpa_address2,entity.e_cpa_city,entity.e_cpa_zip,entity.e_cpa_email, entity.e_cpa_phone,demographics_4.d0001_300,entity.e_cpa_fax, entity.e_cpa_audit_dt,entity.e_cpa_contact_lname,entity.e_descr,entity_tax_type.ett_descr,entity_budget_summary.ebs_yr,entity_budget_summary.ebs_budget,county_codes.cnty_name,states.state_name,entity.e_pop,demographics_3.b19301_1_est as incomePerCapita,entity_elec_svc.*,entity_gas_svc.*,entity_wastewater_svc.*,entity_water_svc.*,geo_code.area_land_characteristics,demographics_1.dem_1_yr,demographics_1.c19001_1_est,demographics_4.d0001_259,demographics_5.*,demographics_3.c08202_1_est,entity_tax_rates.*'); 
		 
		$this->db->from('entity');
		$this->db->join('country_codes', 'country_codes.ct_id = entity.e_cnty_id','LEFT');
 		$this->db->join('demographics_5','demographics_5.dem_5_e_id = entity.e_id','LEFT');
		$this->db->join('demographics_1','demographics_1.dem_1_e_id = entity.e_id','LEFT');
		$this->db->join('demographics_3','demographics_3.dem_3_e_id = entity.e_id','LEFT');
		$this->db->join('demographics_4','demographics_4.dem_4_e_id = entity.e_id','LEFT');
		$this->db->join('states','states.state_id = entity.e_state_id','LEFT');
		$this->db->join('county_codes','county_codes.cnty_id = entity.e_cnty_id','LEFT');
		$this->db->join('entity_geo_xref','entity_geo_xref.egx_entity_id = entity.e_id','LEFT');
		$this->db->join('geo_code','geo_code.geo_id = entity_geo_xref.egx_geo_id','LEFT');
		$this->db->join('entity_budget_summary', 'entity_budget_summary.ebs_e_id = entity.e_id','LEFT');
		$this->db->join('entity_tax_rates', 'entity_tax_rates.etr_e_id = entity.e_id','LEFT');
		$this->db->join('entity_tax_type', 'entity_tax_type.ett_id = entity_tax_rates.etr_tax_type_id','LEFT');
		//$this->db->join('entity_bond_rating', 'entity_bond_rating.ebr_e_id = entity_tax_rates.etr_tax_type_id','LEFT');
	    //$this->db->join('bond_rater', 'bond_rater.br_id = entity_bond_rating.ebr_br_id','LEFT');
	    $this->db->join('entity_elec_svc', 'entity_elec_svc.ees_entity_id = entity.e_id','LEFT');
		$this->db->join('entity_gas_svc', 'entity_gas_svc.egs_entity_id =entity.e_id','LEFT');
		$this->db->join('entity_wastewater_svc', 'entity_wastewater_svc.eww_entity_id = entity.e_id','LEFT');
		$this->db->join('entity_water_svc', 'entity_water_svc.ew_entity_id = entity.e_id','LEFT');
	 
	 	//$this->db->join('entity_financial_sum', 'entity_financial_sum.efs_entity_id = entity.e_id','LEFT');
	 	//$this->db->join('entity_coa', 'entity_financial_sum.efs_account = entity_coa.ecoa_code','LEFT');
	 	//$this->db->join('coa_class', 'coa_class.cc_id = entity_financial_sum.efs_function','LEFT');
	    $this->db->where('entity.e_id',$eid);
	 	$this->db->order_by("entity.e_id", "asc");
		
		
	//	die; 
	 return $this->db->get()->result_array();
	  // print($this->db->last_query()); 
	  
	}
	function dt_tax_rates($eid) // view single user information  function 
	{
	 	$this->db->select('*');
		$this->db->from('entity');
 	 	$this->db->join('entity_tax_rates', 'entity_tax_rates.etr_e_id = entity.e_id','LEFT');
		$this->db->join('entity_tax_type', 'entity_tax_type.ett_id = entity_tax_rates.etr_tax_type_id','LEFT');
	    $this->db->where(array('entity.e_id'=>$eid));
	 	return $this->db->get()->result_array();
		
	}
	
	function bond_rator($eid) // view single user information  function 
	{ 	 
		 
		$this->db->select('*');
		$this->db->from('entity');
 	 	$this->db->join('entity_bond_rating', 'entity_bond_rating.ebr_e_id = entity.e_id','LEFT');
	 	$this->db->join('bond_rater', 'bond_rater.br_id = entity_bond_rating.ebr_br_id','LEFT');
		$this->db->where(array('entity.e_id'=>$eid));
	    return  $this->db->get()->result_array();
		// print($this->db->last_query()); 
	   
	}
	
	function get_entity_government_EL($eid) // view single user information  function 
	{ 	/*personnel*/
	 	$this->db->select('*');
		$this->db->from('personnel');
 	 	$this->db->join('entity', 'entity.e_id = personnel.p_entity_id','LEFT');
	    $this->db->where(array('personnel.p_entity_id'=>$eid,'personnel.p_type'=>"EL"));
	 	//$this->db->order_by("personnel.p_entity_id", "asc"); 
		$this->db->order_by("personnel.p_id", "asc");  
	 	return $this->db->get()->result_array();
	  
	}
	function get_entity_government_AD($eid) // view single user information  function 
	{ 	 
		$arr = array('EM','A');
	 	$this->db->select('*');
		$this->db->from('personnel');
	 	$this->db->join('entity', 'entity.e_id = personnel.p_entity_id','LEFT');
	    $this->db->where('personnel.p_entity_id',$eid);
		$this->db->where_in('personnel.p_type',$arr);
		$this->db->order_by("personnel.p_id", "asc"); 
	 	return $this->db->get()->result_array();
	  
	}
	
	function get_entity_financial_fund($eid) // view single user information  function 
	{ 
		$query='select distinct a.Fund from (select efs_year, t_ft.t_label as Fund, t_obj.t_label as Object ,t_obj.t_depth, t_obj.t_parent_tag,t_obj.t_order, efs_amount from entity_financial_sum efs left join taxonomy t_ft on efs_fundtype = t_ft.t_id left join taxonomy t_obj on efs_object = t_obj.t_id where efs_entity_id = '.$eid.' order by efs_year desc, efs_fundtype, t_obj.t_depth, t_obj.t_order) AS a';
	 return $this->db->query($query)->result();
	}
	
	function get_entity_financial_year($eid) // view single user information  function 
	{
		$query='select distinct efs_year from entity_financial_sum where efs_entity_id = '.$eid.' order by efs_year DESC limit 6';
		return $this->db->query($query)->result();
		/*print($this->db->last_query()); 
		die;*/
	}
	function get_entity_financial_sum_new($eid) // view single user information  function
	{
		$query = 'select distinct a.t_parent_tag from (select efs_year, t_ft.t_label as Fund, t_obj.t_label as Object ,t_obj.t_depth, t_obj.t_parent_tag,t_obj.t_order, efs_amount from entity_financial_sum efs left join taxonomy t_ft on efs_fundtype = t_ft.t_id  left join taxonomy t_obj on efs_object = t_obj.t_id where efs_entity_id = '.$eid.' order by efs_year desc, efs_fundtype, t_obj.t_depth, t_obj.t_order) AS a';
	  $data = $this->db->query($query)->result();
	}
	function get_entity_financial_sum($eid) // view single user information  function 
	{
	  $query = 'select distinct a.t_parent_tag from (select efs_year, t_ft.t_label as Fund, t_obj.t_label as Object ,t_obj.t_depth, t_obj.t_parent_tag,t_obj.t_order, efs_amount from entity_financial_sum efs left join taxonomy t_ft on efs_fundtype = t_ft.t_id  left join taxonomy t_obj on efs_object = t_obj.t_id where efs_entity_id = '.$eid.' order by efs_year desc, efs_fundtype, t_obj.t_depth, t_obj.t_order) AS a';
	  $data = $this->db->query($query)->result();
	  
	}
	
	function get_single_information($eid) // view single user information  function 
	{
	 	$this->db->select('*');
		$this->db->from('entity');
		$this->db->join('country_codes', 'country_codes.ct_id = entity.e_cnty_id','LEFT');
		$this->db->join('states', 'states.state_id = entity.e_state_id','LEFT');
		$this->db->join('demographics_1', 'demographics_1.dem_1_e_id = entity.e_id','LEFT');
		//$this->db->join('entity_budget_summary', 'entity_budget_summary.ebs_e_id = entity.e_id','LEFT');
		//$this->db->join('entity_financial_sum', 'entity_financial_sum.efs_entity_id = entity.e_id','LEFT');
	 	//$this->db->join('entity_coa', 'entity_financial_sum.efs_account = entity_coa.ecoa_code','LEFT');
	 	//$this->db->join('coa_class', 'coa_class.cc_id = entity_financial_sum.efs_function','LEFT');
	  
	    $this->db->where('entity.e_id',$eid);
	 	$this->db->order_by("entity.e_id", "asc"); 
	 	return $this->db->get()->result_array();
	  
	}
	
	function getPersonnelDat($id)
	{
	 	$this->db->select('*');
		$this->db->from('personnel');
	    $this->db->where('p_entity_id',$id);
		$this->db->order_by("personnel.p_seq", "asc");  
	 	return $this->db->get()->result_array();		
	}
	
	function getlibRecords($e_id)
	{
		$this->db->select('*');
		$this->db->from('tbl_entity_gallery');
		$this->db->where('entity_id =',$e_id);
		return $this->db->get()->result_array();
	}
	
	function getCategories()
	{
		$this->db->select('*');
		$this->db->from('categories');
		$this->db->where(array('status !='=>'D','type ='=>'E'));
		return $this->db->get()->result_array();
	}
	
	function getEntityGallery($e_id,$txtSearch)
	{
		if($txtSearch!='')
		{
			$txtSearch = strtolower($txtSearch);
			
			$this->db->like('lower(g_title)',$txtSearch);
			$this->db->or_like('lower(user_lname)',$txtSearch);
			$this->db->or_like('lower(user_fname)',$txtSearch);
			$this->db->or_like('lower(name)',$txtSearch);
		}
		
		$this->db->select('tbl_entity_gallery.*,users.user_fname,users.user_lname,categories.name');
		$this->db->from('tbl_entity_gallery');
		$this->db->join('users','users.user_id = tbl_entity_gallery.added_by');
		$this->db->join('categories','categories.id = tbl_entity_gallery.category_name');		
		$this->db->where(array('tbl_entity_gallery.entity_id ='=>$e_id,'tbl_entity_gallery.status'=>'A'));
		return $this->db->get()->result_array();
	}
	function get_demographics($eid) // view single user information  function 
	{    
	  $query='select  * from census_geo cg  join census_profile_data cdp using (stusab, logrecno) join geo on cast(cg.placens as integer) = feature_id join entity_geo_xref on egx_feature_id = feature_id  join entity on egx_entity_id = e_id  where e_id ='.$eid.''; 	
	  return $this->db->query($query)->result();
  	}
	
	 
	   

	function get_temperature_min($e_id)
	{  
		$this->db->select('temperature_min.*,geo_code.*,entity.e_id,entity.e_id');
		$this->db->from('entity');
		$this->db->join('entity_geo_xref','entity_geo_xref.egx_entity_id = entity.e_id','LEFT');
		$this->db->join('geo_code','geo_code.geo_id = entity_geo_xref.egx_geo_id','LEFT');
	 	$this->db->join('temperature_min','temperature_min.geo_id = entity_geo_xref.egx_geo_id','LEFT');
	 	$this->db->where('entity.e_id',$e_id); 
	 	return $this->db->get()->result_array();
	}
	
	function get_temperature_max($e_id)
	{  
		$this->db->select('temperature_max.*,geo_code.*,entity.e_id,entity.e_id');
		$this->db->from('entity');
		$this->db->join('entity_geo_xref','entity_geo_xref.egx_entity_id = entity.e_id','LEFT');
		$this->db->join('geo_code','geo_code.geo_id = entity_geo_xref.egx_geo_id','LEFT');
	 	$this->db->join('temperature_max','temperature_max.geo_id = entity_geo_xref.egx_geo_id','LEFT');
	 	$this->db->where('entity.e_id',$e_id);
	 	return $this->db->get()->result_array();
	}
	function get_temperature_avg($e_id)
	{  
		$this->db->select('temperature_avg.*,geo_code.*,entity.e_id,entity.e_id');
		$this->db->from('entity');
		$this->db->join('entity_geo_xref','entity_geo_xref.egx_entity_id = entity.e_id','LEFT');
		$this->db->join('geo_code','geo_code.geo_id = entity_geo_xref.egx_geo_id','LEFT');
		$this->db->join('temperature_avg','temperature_avg.geo_id = entity_geo_xref.egx_geo_id','LEFT');
	 	$this->db->where('entity.e_id',$e_id);
	    return $this->db->get()->result_array();
	}
	
 

	function search_entity($arr)   // get all user count for pagination  
	{ 
			$e_pop = str_replace(",","",$arr['population']);
									
			$e_popf = '';			 
			if($e_pop != "    e.g. 10000")
			{
				$e_popf = $e_pop;
			}

			if(!empty($e_popf))
			{
				$this->db->or_where('entity.e_pop >=', $e_popf);
			}
			
			$area = "";
			if($arr['area'] != "    e.g. Square Miles")
			{
				$area = $arr['area']; 
			}
			if(!empty($area))
			{
				$this->db->or_where('geo_code.area_land_characteristics', $area);
			}
			
			$state = "";
			if($arr['state'] != 0)
			{
				$state = $arr['state']; 
			}
			if(!empty($state))
			{
				 $this->db->or_where('entity.e_state_id', $state);
			}
			
			$e_name = ""; 
			if($arr['e_name'] != "    e.g. Orange County")
			{ 
				$e_name = $arr['e_name']; 
			}	
			if(!empty($e_name))
			{
				$this->db->or_where('lower(entity.e_name)', strtolower($e_name)); 
			}
			
			//echo "Pop: ".$e_popf." Area: ".$area." Entity: ".$e_name." State: ".$state;

			if($e_popf || $area || $e_name || ($state > 0) )
			{		
				$this->db->distinct("entity.e_id"); 
				$this->db->select('entity.*,entity_type.et_descr,entity_type.et_id,entity_gov_type.egt_id,entity_gov_type.egt_descr,states.state_id,states.state_name,demographics_1.dem_1_id,demographics_1.dem_1_e_id,geo_code.area_land_characteristics as dem_1_area');
				$this->db->from('entity');
				$this->db->join('entity_type','entity_type.et_id = entity.e_type_id','LEFT');
				$this->db->join('demographics_1','demographics_1.dem_1_e_id = entity.e_id','LEFT');
				$this->db->join('entity_gov_type','entity_gov_type.egt_id = entity.e_gov_type_id','LEFT');				
				$this->db->join('entity_geo_xref','entity_geo_xref.egx_entity_id = entity.e_id','LEFT');
				$this->db->join('geo_code','geo_code.geo_id = entity_geo_xref.egx_geo_id','LEFT');
				$this->db->join('states','states.state_id = entity.e_state_id','LEFT');
				$this->db->order_by("entity.e_name","ASC"); 
				
				$this->db->where('entity.e_status !=','D');
				return $this->db->get()->result_array();
				
				//print_r($this->db->last_query()); die;
				//return res;
			}
			else
				return;
	} 
	
	function add_user_sel_peer()   // get all user count for pagination  
	{ 
	 
		$data = array(
			'usp_entity'=>$this->input->post('id'),
			'usp_user_id'=>$this->input->post('user_id'),
			'usp_peer'=>$this->input->post('id'),
			'usp_modified_ts'=>'now()');
  	   $this->db->insert('user_sel_peers', $data); 
	/*  print($this->db->last_query()); 
	  		 die;*/
	  
	}
	
	function state_combo()
	{ 
		$this->db->select('*');
		$this->db->from('states');
		 $this->db->or_where('state_country_code', 1);
		$this->db->order_by("state_id", "asc"); 
		return $this->db->get()->result_array();
		
	}
	
	function get_user_added_peer($user_id)
	{  
		$this->db->distinct("entity.e_id"); 	
		$this->db->select('user_sel_peers.*,entity.e_id,entity.e_name,entity_type.et_descr, states.state_2char');
		$this->db->from('user_sel_peers');
		$this->db->join('entity','entity.e_id = user_sel_peers.usp_entity','LEFT');
		$this->db->join('states','states.state_id = entity.e_state_id','LEFT');	
		$this->db->join('entity_type', 'entity_type.et_id = entity.e_type_id','LEFT');					
		$this->db->where('user_sel_peers.usp_user_id',$user_id);	
		//$this->db->group_by('entity.e_id');			
	    $this->db->order_by("usp_modified_ts", "DESC"); 	

		return $this->db->get()->result_array(); 	
	} 
  
	function chkExist($id, $user_id)
	{	
		$this->db->select('user_sel_peers.*,entity_type.et_descr,entity.e_name');
		$this->db->from('user_sel_peers');
		$this->db->join('entity','entity.e_id = user_sel_peers.usp_entity','LEFT');
		$this->db->join('entity_type','entity_type.et_id = entity.e_type_id','LEFT');		
		$this->db->where(array('user_sel_peers.usp_entity'=>$id, 'user_sel_peers.usp_user_id'=>$user_id) );		
		return $this->db->get()->result_array();
	}
	
	function peer_delete($id)
	{  
		$this->db->where('usp_id',$id);
		return $this->db->delete('user_sel_peers'); 
 		 
	}
	
	//get default entity peers added by admin
	function get_defaultPeers($id=0)
	{
		$this->db->distinct("entity.e_id"); 
		$this->db->select('entity.e_id, entity.e_name, entity_type.et_descr, states.state_2char ');
		$this->db->from('entity_peers');
		$this->db->join('entity','entity.e_id = entity_peers.ep_peer' ,'LEFT');
		$this->db->join('states','states.state_id = entity.e_state_id','LEFT');	
		$this->db->join('entity_type', 'entity_type.et_id = entity.e_type_id','LEFT');	
		//$this->db->group_by('entity.e_id');						
		$this->db->order_by('entity.e_id', 'DESC');	
$this->db->where('ep_entity',$id);
		
		return $this->db->get()->result_array();
	}			
	
	function getEntityDat($eid)
	{
		$this->db->select('entity.e_id,entity.e_cpa_firm,entity.e_cpa_contact_fname,entity.e_cpa_contact_lname,entity.e_cpa_contact_title,entity.e_cpa_address1,entity.e_cpa_address2,entity.e_cpa_city,entity.e_cpa_zip,entity.e_cpa_email,entity.e_cpa_phone,entity.e_cpa_fax');
		$this->db->from('entity');
		$this->db->where('e_id',$eid);
		return $this->db->get()->result_array();
	}
	
	function updateEntityLogo($e_id,$updateData)
	{
		$this->db->select('*');
		$this->db->from('entity_logo');
		$this->db->where('el_id',$this->input->post('el_id'));
		$data = $this->db->get()->result_array();
		
		#-----------------------------------------------------------#
		//update the record from entity_logo .......(main updation)
		$this->db->where('el_id',$e_id);
		$this->db->update('entity_logo',$updateData);
		#-----------------------------------------------------------#
		
		//Insert records in DELTA_MASTER.....................
		$dmData = array('dm_entity_id' => $e_id ,'dm_created_by' => $this->session->userdata('user_id') ,'dm_created_ts'=> 'now()' ,'dm_operation_id'=>5);
		$this->db->insert('delta_master',$dmData);
		$dmLastId = $this->db->insert_id();
		#-----------------------------------------------------------#

			$newData['el_filename'] = $updateData['el_filename'];
			$oldData['el_filename'] = $data[0]['el_filename'];
			$ddLastId = $this->insertDelta_Field_Master('el_filename',$dmLastId,$e_id);
			$this->insertDDString($ddLastId,$oldData['el_filename'],$newData['el_filename']);

			$newData['modified_ts'] = 'now()';
			$oldData['modified_ts'] = $data[0]['modified_ts'];
			$ddLastId = $this->insertDelta_Field_Master('modified_ts',$dmLastId,$e_id);
			$this->db->insert('delta_details_timestamp',array('dd_id'=>$ddLastId,'old_value' => $oldData['modified_ts'],'new_value' => $newData['modified_ts']));

		//1]function which compare el_ext........
		if($updateData['el_ext'] != $data[0]['el_ext'])
		{
			$newData['el_ext'] = $updateData['el_ext'];
			$oldData['el_ext'] = $data[0]['el_ext'];
			$ddLastId = $this->insertDelta_Field_Master('el_ext',$dmLastId,$e_id);
			$this->insertDDString($ddLastId,$oldData['el_ext'],$newData['el_ext']);
		}

		//2]function which compare modified_by........
		if($updateData['modified_by'] != $data[0]['modified_by'])
		{
			$newData['modified_by'] = $updateData['modified_by'];
			$oldData['modified_by'] = $data[0]['modified_by'];
			$ddLastId = $this->insertDelta_Field_Master('modified_by',$dmLastId,$e_id);
			$this->db->insert('delta_details_integer',array('dd_id'=>$ddLastId,'old_value' => $oldData['modified_by'],'new_value' => $newData['modified_by']));
			//$this->insertDDString($ddLastId,$oldData['modified_by'],$newData['modified_by']);
		}
	}
	
	function insertEntityLogo($updateData)
	{
		$e_id = $updateData['el_id'];
		#-----------------------------------------------------------#
		//insert the record in entity_logo .......(main insertion)
		$this->db->insert('entity_logo', $updateData); 
		#-----------------------------------------------------------#
		
		#-----------------------------------------------------------#
		//Insert records in DELTA_MASTER.....................
		$dmData = array('dm_entity_id' => $e_id ,'dm_created_by' => $this->session->userdata('user_id') ,'dm_created_ts'=> 'now()' ,'dm_operation_id'=>1);
		$this->db->insert('delta_master',$dmData);
		$dmLastId = $this->db->insert_id();
		#-----------------------------------------------------------#

		$ddLastId = $this->insertDelta_Field_Master('el_id',$dmLastId,$e_id);
		$this->db->insert('delta_details_bigint',array('dd_id'=>$ddLastId,'old_value' => NULL,'new_value' => $updateData['el_id']));


		$ddLastId = $this->insertDelta_Field_Master('el_filename',$dmLastId,$e_id);
		$this->insertDDString($ddLastId,NULL,$updateData['el_filename']);

		$ddLastId = $this->insertDelta_Field_Master('modified_by',$dmLastId,$e_id);
		$this->db->insert('delta_details_bigint',array('dd_id'=>$ddLastId,'old_value' => NULL,'new_value' => $updateData['modified_by']));


		$ddLastId = $this->insertDelta_Field_Master('modified_ts',$dmLastId,$e_id);
		$this->db->insert('delta_details_timestamp',array('dd_id'=>$ddLastId,'old_value' => NULL,'new_value' => $updateData['modified_ts']));


		$ddLastId = $this->insertDelta_Field_Master('el_status',$dmLastId,$e_id);
		$this->insertDDString($ddLastId,NULL,$updateData['el_status']);

		$ddLastId = $this->insertDelta_Field_Master('el_ext',$dmLastId,$e_id);
		$this->insertDDString($ddLastId,NULL,$updateData['el_ext']);
	}
	
	function insertDelta_Field_Master($colName,$dmLastId,$eid)
	{
		//Insert records in to DELTA_FIELD_MASTER...........
		$dfmData = array('dfm_name' => $colName,'dfm_table' => 'entity_logo','dfm_modified_ts' => 'now()','dfm_description' => 'entity_logo');
		$this->db->insert('delta_field_master',$dfmData);
		$dfmLastId = $this->db->insert_id();

		//Insert records in DELTA_DETAILS................................
		$ddData = array('dd_entity_id' => $eid,'dd_field_id' => $dfmLastId, 'dd_delta_master_id' => $dmLastId);
		$this->db->insert('delta_details',$ddData);
		return $this->db->insert_id();
	}
	
	function insertDDString($ddLastId,$oldValue,$newValue)
	{
		$this->db->insert('delta_details_string',array('dd_id'=>$ddLastId,'old_value' => $oldValue,'new_value' => $newValue));
	}
	
	function isTop($id)
	{
		$this->db->select('erc_id,erc_parent_cat');
		$this->db->from('entity_ref_category');
		$this->db->where('erc_id',$id);
		return $this->db->get()->result_array();
	}
	
	function cat_name($id)
	{
		$this->db->select('erc_title');
		$this->db->from('entity_ref_category');
		$this->db->where('erc_id',$id);
		return $this->db->get()->result_array();
	}

	//this function returns the product result of efs n taxonomy for respected entity...
	function getEfsData($e_id)
	{
		$this->db->select('efs.efs_id,efs.efs_entity_id,efs.efs_year,efs.efs_object,efs.efs_amount,t_parent_id,t_tag,t_id,t_label,t_depth');
		$this->db->from('taxonomy as t');
		$this->db->join('entity_financial_sum as efs','efs.efs_object = t.t_id');
		$this->db->where(array('efs.efs_entity_id' => $e_id,'t.t_depth >='=> 2));
		$this->db->order_by('t.t_depth','ASC');
		$this->db->order_by('efs.efs_year', 'desc');
		return $this->db->get()->result_array();
	}

	//this function returns the tree of efs record to the respected limit...
	function getParent_tree($t_parent_id)
	{
		if($t_parent_id  != NULL)
		{
			$return_data = array(0);
			$this->db->select('t_id,t_label,t_parent_id,t_depth');
			$this->db->from('taxonomy');
			$this->db->where('t_id',$t_parent_id);
			$parent_data = $this->db->get()->result_array();
	
			$m = 0;

			while($parent_data[$m]['t_depth'] > '2')
			{
				$t = $m + 1;
				$parent_data[$t] = $this->getParent($parent_data[$m]['t_parent_id']);
				$m++;
			}
		}
		return $parent_data;
	}
	
	//this function used for the recursive iteration till get 64540 (i.e. FINANCIAL)...
	function getParent($parent_id)
	{
		$this->db->select('t_id,t_label,t_parent_id,t_depth');
		$this->db->from('taxonomy');
		$this->db->where('t_id',$parent_id);
		$data = $this->db->get()->result_array();
		return $data[0];
	}

	function getDepth5_arr($depth_arr)
	{
		$this->db->select('t_id');
		$this->db->from('taxonomy');
		$this->db->where_in('t_id', $depth_arr);
		$this->db->order_by("t_parent_id", 'ASC');
		$this->db->order_by("t_order", 'ASC');
		return $this->db->get()->result_array();
	}
	
	//new functions created for the _new style.........
	//on 22 March,2012....
	function get_entity_financial_sum_2($eid) // view single user information  function 
	{
	  $query = 'select distinct a.t_parent_tag from (select efs_year, t_ft.t_label as Fund, t_obj.t_label as Object ,t_obj.t_depth, t_obj.t_parent_tag,t_obj.t_order, efs_amount from entity_financial_sum efs left join taxonomy t_ft on efs_fundtype = t_ft.t_id  left join taxonomy t_obj on efs_object = t_obj.t_id where efs_entity_id = '.$eid.' order by efs_year desc, efs_fundtype, t_obj.t_depth, t_obj.t_order) AS a'; 	
	  return $this->db->query($query)->result();
	}

	function get_entity_financial_fund_new($eid)
	{ 
		$query = 'select distinct a.Fund from (select efs_year, t_ft.t_label as Fund, t_obj.t_label as Object ,t_obj.t_depth, t_obj.t_parent_tag,t_obj.t_order, efs_amount from entity_financial_sum efs left join taxonomy t_ft on efs_fundtype = t_ft.t_id left join taxonomy t_obj on efs_object = t_obj.t_id where efs_entity_id = '.$eid.' order by efs_year desc, efs_fundtype, t_obj.t_depth, t_obj.t_order) AS a ';
	 return $this->db->query($query)->result();
	}

	function get_entity_financial_year_new($eid)
	{
		$query = "select distinct efs_year from entity_financial_sum where efs_entity_id = '".$eid."' and efs_year <= '".@date("Y")."' order by efs_year DESC limit 6";
		return $this->db->query($query)->result();
	}
	
	function getChild_tree($t_id, $meta_data)
	{
		$arr['all_ids'] = array();
		$arr['parent_ids'] = array();

		$count = 0;
		$child_data = array();
		for($j = 0; $j<count($meta_data); $j++)
		{
			if($t_id == $meta_data[$j]['t_parent_id'])
			{
				$child_data[$count]['t_id'] = $meta_data[$j]['t_id'];

				for($m=0; $m<count($meta_data);$m++)
				{
					if($meta_data[$j]['t_id'] == $meta_data[$m]['t_parent_id'])
					{
						$child_data[$count]['isParent'] = 'Y';
						array_push($arr['parent_ids'], $child_data[$count]['t_id']);
						$m = count($meta_data)+1;
					}
				}
				array_push($arr['all_ids'], $child_data[$count]['t_id']);
				$child_tree_val =  $this->getChild_tree($child_data[$count]['t_id'], $meta_data);

				foreach ($child_tree_val['parent_ids'] as $tax_id)
				{
					if($tax_id != '')
						array_push($arr['parent_ids'], $tax_id);
				}

				foreach ($child_tree_val['all_ids'] as $tax_id)
				{
					if($tax_id != '')
						array_push($arr['all_ids'], $tax_id);
				}
				$count++;
			}
		}
		return $arr;
	}

	function getUnCollapse_child_tree($t_id, $str_col_arr = '')
	{
		if($str_col_arr != '')
			return $this->db->query("WITH RECURSIVE taxonomy_child_hiearchy( t_id, t_depth, t_order, t_parent_id, t_label) AS (select t_id, t_depth, t_order, t_parent_id, t_label from taxonomy where t_id = '".$t_id."' UNION ALL select  tn.t_id,  tn.t_depth, tn.t_order, tn.t_parent_id, tn.t_label from taxonomy_child_hiearchy th, taxonomy tn where  th.t_id = tn.t_parent_id and tn.t_parent_id is not NULL and tn.t_id not in(".$str_col_arr.")) select distinct  t_id, t_depth, t_order, t_parent_id, t_label from taxonomy_child_hiearchy order by t_depth , t_parent_id, t_order")->result_array();
		else
			return $this->db->query("WITH RECURSIVE taxonomy_child_hiearchy( t_id, t_depth, t_order, t_parent_id, t_label) AS (select t_id, t_depth, t_order, t_parent_id, t_label from taxonomy where t_id = '".$t_id."' UNION ALL select  tn.t_id,  tn.t_depth, tn.t_order, tn.t_parent_id, tn.t_label from taxonomy_child_hiearchy th, taxonomy tn where  th.t_id = tn.t_parent_id and tn.t_parent_id is not NULL ) select distinct  t_id, t_depth, t_order, t_parent_id, t_label from taxonomy_child_hiearchy order by t_depth , t_parent_id, t_order")->result_array();
	}
	
	function getParentTree($t_id)
	{
		return $this->db->query("WITH RECURSIVE taxonomy_hiearchy_1( t_id, t_depth, t_order, t_parent_id, t_label) AS (select t_id, t_depth, t_order, t_parent_id, t_label from taxonomy where t_id = '".$t_id."' UNION ALL select tn.t_id, tn.t_depth, tn.t_order, tn.t_parent_id, tn.t_label from taxonomy_hiearchy_1 th, taxonomy tn where tn.t_id = th.t_parent_id and th.t_parent_id is not NULL) select distinct  t_id, t_depth, t_order, t_parent_id, t_label from taxonomy_hiearchy_1 where t_id <> '".$t_id."' order by t_depth , t_parent_id, t_order;")->result_array();
	}
	
	function get_financial_child($e_id)
	{
		$meta_data = $this->db->query("WITH RECURSIVE taxonomy_hiearchy( t_id, t_depth, t_order, t_parent_id, t_label, t_parent_tag) AS ( select t_id, t_depth, t_order, t_parent_id, t_label, t_parent_tag from taxonomy where t_id in (select distinct efs_object from entity_financial_sum where efs_entity_id = '".$e_id."' and  efs_object is not NULL ) UNION ALL select  tn.t_id,  tn.t_depth, tn.t_order, tn.t_parent_id, tn.t_label, tn.t_parent_tag from taxonomy_hiearchy th, taxonomy tn where tn.t_id = th.t_parent_id and th.t_parent_id is not NULL) select distinct t_id, t_depth, t_order, t_parent_id, t_label, t_parent_tag from taxonomy_hiearchy order by t_depth , t_parent_id, t_order")->result_array();

		$t_id = 'FINANCIAL';
		//$t_id = 'COMBINING_AND_INDICIDUAL_FUND_STATEMENTS_AND_SCHEDULES';
		$arr = array();
		$count = 0;
		$child_data = array();
		for($j = 0; $j<count($meta_data); $j++)
		{
			if($t_id == $meta_data[$j]['t_parent_tag'])
			{
				$child_data[$count]['t_id'] = $meta_data[$j]['t_id'];
				array_push($arr, $child_data[$count]['t_id']);
				$child_tree_val =  $this->getChild_tree($child_data[$count]['t_id'], $meta_data);
				foreach ($child_tree_val['all_ids'] as $tax_id)
				{
					if($tax_id != '')
						array_push($arr, $tax_id);
				}
				$count++;
			}
		}
		return $arr;
	}

	function getMasterCount($t_id)
	{
		$this->db->select('t_id,t_label,t_parent_id,t_depth');
		$this->db->from('taxonomy');
		$this->db->where('t_parent_id',$t_id);
		return $this->db->get()->result_array();
	}
	function isParent($t_id)
	{
		$this->db->select('count(*)');
		$this->db->from('taxonomy');
		$this->db->where('t_parent_id',$t_id);
		$rSetData = $this->db->get()->result_array();
		if($rSetData[0]['count'] > 0)
			return true;
		else
			return false;
	}
	
	function get_depth5_rec()
	{
		$this->db->select('t_parent_id');
		$this->db->from('taxonomy');
		$this->db->where('t_depth',5);
		echo '<pre>';
			print_r($this->db->get()->result_array());
		exit;
	}

	//this function returns the t_table_id of the t_id...
	function get_table_status($t_id)
	{
		$this->db->select('t_table_tag');
		$this->db->from('taxonomy');
		$this->db->where('t_id',$t_id);
		return $this->db->get()->result_array();
	}

	//this function returns the t_tag_id of the t_id...
	function get_total_status($t_id)
	{
		$this->db->select('t_total_tag');
		$this->db->from('taxonomy');
		$this->db->where('t_id',$t_id);
		return $this->db->get()->result_array();
	}
	function get_search_entity($num = NULL, $offset = NULL)
	{
		$condition = 'N';
		//check for the Population...
		if(trim($this->session->userdata('population')) != '' and trim($this->session->userdata('population')) != 'e.g. 10,000')
		{
			$poplatn = $this->session->userdata('population');
			$lst_digit = substr($this->session->userdata('population'), -1);
			if($lst_digit == 'K' || $lst_digit == 'k')
				$poplatn = $poplatn * (1000);
			$this->db->where('e_pop',str_replace(',','',$poplatn));
			$condition = 'Y';
		}//Ends check Population...

		//check for the Area...
		if(trim($this->session->userdata('area')) != '' and trim($this->session->userdata('area')) != 'e.g. Square Miles')
		{
			$this->db->select('geo_code.area_land_characteristics');
			$this->db->join('entity_geo_xref','entity_geo_xref.egx_entity_id = entity.e_id','LEFT');
		$this->db->join('geo_code','geo_code.geo_id = entity_geo_xref.egx_geo_id','LEFT');
			$this->db->where('geo_code.area_land_characteristics',str_replace(",", "", $this->session->userdata('area')));
			$condition = 'Y';
		}//Ends check Area...

		//check for the State...
		if($this->session->userdata('state') != 0)
		{
			$this->db->where('e_state_id', $this->session->userdata('state'));
			$condition = 'Y';
		}//Ends check State...

		//check for the entity name...
		if(trim($this->session->userdata('e_name')) != '' and trim($this->session->userdata('e_name')) != 'e.g. Carol Stream')
		{
			$this->db->like('LOWER(e_name)', strtolower($this->session->userdata('e_name')), 'both');
			$condition = 'Y';
		}//Ends check Entity Name...

		//check for the Latitude...
		if(trim($this->session->userdata('latitude')) != '' and trim($this->session->userdata('latitude')) != 'e.g. 37.2519964')
		{
			$this->db->like('CAST(e_lat AS char(20))',trim($this->session->userdata('latitude')));
			//select * from entity where CAST(e_lat AS char(20)) like '39.7242%'
			$condition = 'Y';
		}//Ends check Latitude...

		//check for the num and offset...
		if($num != NULL or $offset != NULL)
			$this->db->limit($num,$offset);
		//Ends num and offset...
		
		if($condition == 'Y')
		{
			//e_name  state_2char et_descr
			$this->db->select('states.state_2char,entity.e_id, e_name, entity.e_cpa_contact_fname, entity.e_cpa_contact_lname, entity_type.et_descr ');
			$this->db->from('entity');
			$this->db->join('states','states.state_id = entity.e_state_id','LEFT');
			$this->db->join('entity_type','entity_type.et_id = entity.e_type_id','LEFT');
			$this->db->order_by("entity.e_name","ASC"); 
			$this->db->where('entity.e_status !=','D');
		return $this->db->get()->result_array();
		}
		else
			return 'BLANK';
	}

	//this function returns the hierachy of tags w.r.t. the $e_id...
	//if record not found or $e_id = NULL then then return 'BLANK'...
	function get_tag_data($e_id = NULL)
	{
		if($e_id != NULL)
		{
			
			//$query= $this->db->query("select * from taxonomy_v2 where t_id in(select distinct efs_t_row from entity_financial_sum_v2 where efs_entity_id=$e_id) and (t_parent_id = 1850 or t_parent_id =1854 or t_parent_id=1847)");
			//return $query->result();
	//return $this->db->query("select * from taxonomy_v2 where t_id in(select distinct efs_t_row from entity_financial_sum_v2 where efs_entity_id=$e_id) and (t_parent_id = 1850 or t_parent_id =1854 or t_parent_id=1847)")->result_array();
	 		
	 	
	 		return $this->db->query("WITH RECURSIVE taxonomy_hiearchy( t_id, t_depth, t_order, t_parent_id, t_label,t_table_tag, t_default_expand_fg) AS (select t_id, t_depth, t_order, t_parent_id, t_label, t_table_tag, t_default_expand_fg from taxonomy where t_id in (select distinct efs_object from entity_financial_sum where efs_entity_id = '".$e_id."' and  efs_object is not NULL and efs_data_source = '102') UNION ALL select  tn.t_id,  tn.t_depth, tn.t_order, tn.t_parent_id, tn.t_label, tn.t_table_tag,tn.t_default_expand_fg from taxonomy_hiearchy th, taxonomy tn where tn.t_id = th.t_parent_id and th.t_parent_id is not NULL ) select distinct  t_id, t_depth, t_order, t_parent_id, t_label, t_table_tag, t_default_expand_fg from taxonomy_hiearchy where t_label <> '' order by t_depth , t_parent_id, t_order")->result_array();
		}
		else
		{
			return 'BLANK';
		}
	}
	
	function get_tag_data_drill_up($e_id)
	{
		//return $this->db->query("select * from taxonomy_v2 where t_id in(select distinct efs_t_row from entity_financial_sum_v2 where efs_entity_id=$e_id) and (t_parent_id = 1850 or t_parent_id =1854 or t_parent_id=1847)")->result_array();
		//return $this->db->query("WITH RECURSIVE taxonomy_hiearchy( t_id, t_depth, t_order, t_parent_id, t_label) AS (select t_id, t_depth, t_order, t_parent_id, t_label, t_total_tag from taxonomy where t_id in (select distinct efs_object from entity_financial_sum where efs_entity_id = '".$e_id."' and  efs_object is not NULL and efs_data_source = '102') UNION ALL select  tn.t_id,  tn.t_depth, tn.t_order, tn.t_parent_id, tn.t_label, tn.t_total_tag from taxonomy_hiearchy th, taxonomy tn where tn.t_id = th.t_parent_id and th.t_parent_id is not NULL ) select distinct  t_id, t_depth, t_order, t_parent_id, t_label, t_total_tag from taxonomy_hiearchy where t_label <> '' order by t_depth , t_parent_id, t_order")->result_array();
	}
}?>
