<?php
class Db_transact_model extends Model 
{
	function Db_transact_model()
	{
		parent::Model(); 
	}
  
  	function get_uniqueId()
	{
		$sql_query="SELECT * from uuid_generate_v4()";
		return $this->db->query($sql_query)->result_array();	
	}
	
	function add_record( $tbl, $data)
	{
		$this->db->insert( $tbl, $data);
	  	return $this->db->insert_id();
	}
	
	function update_record($tbl, $data, $cnd)
	{ 	
		$this->db->where( $cnd );	
		return $this->db->update( $tbl, $data);	
	}

	function chk_exist( $tbl, $cnd)
	{		
		$this->db->select('*');
		$this->db->from( $tbl );
		$this->db->where( $cnd );
		return $this->db->get()->result_array();
/*		print_r($this->db->last_query());
		exit;*/
	}	
	
	// Get single Record info
	function get_single_record( $tbl, $cnd)
	{		
		$this->db->select('*');
		$this->db->from( $tbl );
		$this->db->where( $cnd );
		return $this->db->get()->result_array();
	}
	
	//Delete single record
	function delete_single_record( $tbl, $cnd)
	{		
		return $this->db->delete($tbl,$cnd);
	}

	function get_user_role($uid = NULL)
	{
		$rinfo = '';
		if($uid != '')
		{
		$sql = "SELECT ur_descr from user_roles as r LEFT JOIN users ON users.user_role_id = r.ur_id WHERE users.user_id =".$uid;
		$rinfo = $this->db->query($sql)->result_array();
		}
		return $rinfo; 
	}
	
	//Get All Records
	function get_all_records( $tbl, $cnd, $ob, $ot='ASC')
	{		
		$this->db->select('*');
		$this->db->from( $tbl );
		$this->db->where( $cnd );
		$this->db->order_by( $ob, $ot);		
		$qry_info = $this->db->get()->result_array();
		//print_r($this->db->last_query());
		return $qry_info;
	}	
	
	// Get single Record info
	function get_singlerecord( $tbl, $cnd)
	{		
		$this->db->select('*');
		$this->db->from( $tbl );
		$this->db->where( $cnd );
		$tmp_res = $this->db->get()->result_array();
		return  $tmp_res[0];
	}
	
	function get_childsyById($parentId=0, $del_id, $e_id )
	{
		if($parentId != 0)
		{
			$cnd = "erc_parent_cat = ".$parentId." AND erc_e_id = ".$e_id;	
			$this->db->select('erc_id,erc_parent_cat');
			$this->db->from( 'entity_ref_category');
			$this->db->where( $cnd );
			$data = $this->db->get()->result_array();
		
			for($i = 0; $i<count($data); $i++) 
			{
				$_SESSION['TMP_ID'] .= ",".$data[$i]['erc_id'];
				$cnd1 = "erc_parent_cat = ".$data[$i]['erc_id'];
					
				if( $this->chk_exist('entity_ref_category', $cnd1))
					get_childsyById($data[$i]['erc_id'], $del_id,  $e_id); 
				else
					return  $del_id;
			}
		}	
		return $del_id;
	}
		
	//Fetch records by query
	function sql_qry($sql)
	{
		return $this->db->query($sql)->result_array();
	}
	
	function delete_personnel($pid)
	{
		$this->db->where('p_id',$pid);
		return $this->db->delete('personnel'); 
	}
}
?>
