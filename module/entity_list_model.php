<?php
class Entity_list_model extends Model 
{
	var $tableName ; 
	var $linkHref  ;
	var $cat_type ;
	
	function entity_list_model()
	{
		parent::Model(); 
	    $this->tableName  = 'entity';
		$this->linkHref	  =	base_url().'index.php/admin/category/' ;
	}
	function set_cattype($cat_type)
	{
		$this->cat_type   =	$cat_type;		
	}
	 
	public  function createDropDown( $selectedId = NULL  , $parentId=0 , $counter = 0  )
	{ 
		if ($counter == 0 )
		{ 
			echo "<select name='parentId' id='parentId' style='width:200px'>";
			echo "<option value=''>Select</option>";   
		 
		} 
		
		$ci=& get_instance();
		$ci->load->database(); 
		$sql = "select * from entity where e_id='$parentId'";
		$i = 0;
		$result = $ci->db->query($sql)->result_array();
		// fetch all the result 
		while($i<count($result)) 
		{ 
				// if only selectedId parameter is provided.
                 if(isset($selectedId))			  
				$sel = $result[$i]['id'] == $selectedId ? 'selected="selected"':''; 
				echo "<option value='{$result[$i]['id']}' {$sel}>". $this->timer($counter).'&bull;&nbsp;'.$result[$i]['name'] . "</option>"; 
				// calling same function , recusrion 
				$this->createDropDown($selectedId, $result[$i]['id'] , $counter+1) ; 
				$i++;
		} 
		if ($counter == 0 )
			echo "</select>" ; 	
	} 
	 
	public  function createNestedDropDown( $selectedId = NULL  , $parentId=0 , $counter = 0  )
	{ 
		if ($counter == 0 )
		{ 
			echo "<select name='parentId' id='parentId' style='width:200px'>";
			
			echo "<option value=''>Select</option>";   
		} 
		
		$ci=& get_instance();
		$ci->load->database(); 
		$sql = "select * from categories where top_id='$parentId' and type = '$this->cat_type'";
		$i = 0;
		$result = $ci->db->query($sql)->result_array();
		// fetch all the result 
		while($i<count($result)) 
		{ 
				// if only selectedId parameter is provided.
                 if(isset($selectedId))			  
				$sel = $result[$i]['id'] == $selectedId ? 'selected="selected"':''; 
				echo "<option value='{$result[$i]['id']}' {$sel}>". $this->timer($counter).'&bull;&nbsp;'.$result[$i]['name'] . "</option>"; 
				// calling same function , recusrion 
				$this->createNestedDropDown($selectedId, $result[$i]['id'] , $counter+1) ; 
				$i++;
		} 
		if ($counter == 0 )
			echo "</select>" ; 	
	} 
	
	// to create the space on the drop down menu as the depth of the categories increases.
	private function timer( $counter  ) 
	{ 
		$space = ''; 
		for ($i = 0;$i < $counter ; $i++ ) 
			$space .= "&nbsp;&nbsp;";  
		return $space; 
	}
	
    // creates the nested list with ul , li , ul .................. can be use for the navigation and menus.
	public function createNestedList($parentId=0 , $counter = 0  )
	{ 
		if ($counter == 0 )
			 echo "<ul class='subMenu'>";  
	 		$ci=& get_instance();
			$ci->load->database(); 
			
			$sql = " select * from categories where top_id = '$parentId' ";
		
			$i = 0;
			$result = $ci->db->query($sql)->result_array();
		
		while($i<count($result)) 
		{ 

				$query = $this->db->get_where('categories',(array('top_id' => $result[$i]['id'])));
				$res = $query->result_array();
		
				//$res 	= 	$this->_mysqli->query ( " select * from {$this->tableName} where parentId = '" .$row->id . "'" ); 
				
				$tot 	= 	count($res);
				$href 	= 	$this->linkHref; 
				$ul 	=  	$tot == 0 ? "":'<ul>'; 
				$_ul 	= 	$tot == 0 ? "":'</ul>'; 
				echo "<li><a href='{$href}{$result[$i]['id']}'>{$result[$i]['name']}</a>"; 
				echo "{$ul}";  
				$this->createNestedList($result[$i]['id'] , $counter+1) ; 
				echo "{$_ul}"; 
				echo "</li>"; 
				$i++;
		} 
		
		if ($counter == 0 )
			echo "</ul>" ; 	
	} 
	
	//creates  breadCrumb as with all the parent categories. 
	public function breadCrumb ( $categoryId,$type, $loop=0 ) 
	{ 	
		
		$ci=& get_instance();
		$ci->load->database(); 
		
		$sql = " select * from categories where id = '$categoryId' ";
		$result = $ci->db->query($sql)->result_array();
		//echo "<pre>";
		//print_r($result);
		//exit;
		
		if( $loop > 0 ){
			if($result[0]['id']==0)
			{	
				$a  =	"<a href=".$this->linkHref."category_management/".$result[0]['id']."/".$result[0]['type'].">".$result[0]['name']."</a>";
			}
			else
			{
				$a  =	"<a href=".$this->linkHref."sub_categories/".$result[0]['id']."/".$result[0]['type'].">".$result[0]['name']."</a>";
			}	
		}
		else
		{	$a	=	"<strong>{$result[0]['name']}</strong>";
		}
		 $id = $result[0]['top_id'];
			if($id!=0)
			{ 
				echo  $this->breadCrumb($id,$result[0]['type'],$loop+1)."&nbsp;&raquo;&nbsp;".$a;
			}
			else 
			{
				echo   $a;
			}
	} 
		
	function display_child($parent, $level) 
	{
		$sql = "SELECT * from `category` WHERE p_id='$parent'";
		$result = mysql_query($sql);
		while ($row = mysql_fetch_array($result)) 
		{
				echo '<option value="'.$row['id'].'">'.str_repeat('-',$level).$row['name'].'</option>';
				 display_child($row['id'], $level+1);
		}
	}   
    
	function getMainCatDetails($subCatId)
	{
	   $sql_query="SELECT * FROM gallery_type WHERE id='".$subCatId."'";
	   return $this->db->query($sql_query)->result_array();
	}	
	
	function insertSubCategory($arr, $cat_id)
	{
		$data = array('type_id'=>$cat_id, 'sub_gal_name'=>$arr['sub_category'], 'created_date'=>'now()', 'sub_status'=>('A'));
		$this->db->insert('sub_gallery_type', $data);
		$categoryid = $this->db->insert_id();
	   return true;
	}
	
	function insertCategory($arr)
	{	 
		$data = array('type_name'=>$arr['category'], 'created_date'=>'now()', 'g_status'=>('A'));
		$this->db->insert('gallery_type', $data);
		$categoryid = $this->db->insert_id();
	   return true;
	}
	
	function getAllCategories()
	{
	  return $this->db->get('gallery_type')->result();	
	}
	
	function getAllSubCategories($cat_id)
	{
		$this->db->select('sub_gallery_type.*,gallery_type.*');
		$this->db->from('sub_gallery_type');
		$this->db->join('gallery_type','gallery_type.id = sub_gallery_type.type_id','LEFT');	
		$this->db->where('sub_gallery_type.type_id', $cat_id);
		$this->db->order_by("sub_gallery_type.sub_gal_id","ASC");  
	 	return $this->db->get()->result();
		//print_r($this->db->last_query()); die;
	}
	
	function changeSubCatStat($subCatId, $stat)
	{	
		switch($stat)
		{
			case 1: $status='A'; break;  case 2: $status='I'; break;
		}
		
		$categoryInfo = $this->db->get_where('sub_gallery_type', array('sub_gal_id' =>$subCatId))->result();
		//print_r($userInfo);
		if($status=='A')
		{
			$data = array('sub_status'=>'I');
			$this->db->where('sub_gal_id', $subCatId);
			$this->db->update('sub_gallery_type', $data); 	
		}
		elseif($status=='I')
		{
			$data = array('sub_status'=>'A');
			$this->db->where('sub_gal_id', $subCatId);
			$this->db->update('sub_gallery_type', $data); 	
		}
	}
	
	function getSubCatDetails($subCatId)
	{
	   $sql_query="SELECT * FROM sub_gallery_type WHERE sub_gal_id='".$subCatId."'";
	   return $this->db->query($sql_query)->result_array();
	}
		
	function updateSubCategory($subCatId, $arr)
	{
	//print_r($arr);
		$data_update=array('sub_gal_name'=>$arr['sub_category']);	
		
		$this->db->where('sub_gal_id', $arr['subCatId']);
		$this->db->update('sub_gallery_type', $data_update); 
		return true;
	}
	
	function deleteSubCategory($arr) // delete users record 
	{  
		if(count($arr)>0)
		{
			$ids = implode(',',$arr);
		}
		else
		{
			$ids = $id;
		}
		
		$this->db->where('sub_gal_id IN('.$ids.')');
		return $this->db->delete('sub_gallery_type'); 

			 
	}
	/*function deleteSubCategory($subCatId)
	{
		$infArr=$this->db->get_where('sub_gal_name', array('sub_gal_id'=>$subCatId))->result();
		$this->db->delete('sub_gallery_type', array('sub_gal_id' => $subCatId)); 
		//$this->db->delete('sub_sub_category', array('sub_cat_id' => $subCatId)); 
	}*/
	function delete_multiple_categories()
	{	
	// echo "in ifff"; die;
	  $cnt = $this->input->post('chkmsg'); 
	  for($k=0; $k< count($cnt); $k++)
	  {
	     $this->db->where('sub_cat_id', $cnt[$k]);   
         $this->db->delete('sub_category');  
	  }	  
	}

# For sub sub categories
  function getSubMainCatDetails($sub_gal_id)
	{
	   $sql_query="SELECT * FROM sub_gallery_type WHERE sub_gal_id ='".$sub_gal_id."'";
	   return $this->db->query($sql_query)->result_array();
	}	
	
	function insertSubSubCategory($arr, $sub_gal_id)
	{
		$data = array('sub_gal_id'=>$sub_gal_id, 'sub_sub_gallery'=>$arr['sub_sub_category'], 'created_date'=>'now()', 'status'=>('I'));
		$this->db->insert('sub_sub_gallery', $data);
		$categoryid = $this->db->insert_id();
	   return true;
	}
	
	function getAllSubSub1Categories()
	{
	 	 return $this->db->get('category')->result();	
	}
	
	function getAllSubSubCategories($sub_gal_id)
	{
	   $this->db->select('sub_sub_gallery.*,sub_gallery_type.sub_gal_id,sub_gallery_type.sub_gal_name,gallery_type.id,gallery_type.type_name');
	   $this->db->from('sub_sub_gallery');
	   $this->db->join('sub_gallery_type', 'sub_sub_gallery.sub_gal_id = sub_gallery_type.sub_gal_id','left');
	   $this->db->join('gallery_type','sub_gallery_type.type_id = gallery_type.id','left');
	   $this->db->where('sub_sub_gallery.sub_gal_id', $sub_gal_id);	 
	   $this->db->order_by('sub_sub_gallery.sub_sub_gal_id','desc');	  
	  return $this->db->get()->result();
	}
	
	function changeSubSubCatStat($sub_sub_cat_id, $stat)
	{	
	
		switch($stat)
		{
			case 1: $status='Active'; break;  case 2: $status='Inactive'; break;
		}
		
		$categoryInfo=$this->db->get_where('sub_sub_gallery', array('sub_sub_gal_id' =>$sub_sub_cat_id))->result();
		//print_r($userInfo);
		if($status=='Active')
		{
			$data = array('status'=>'I');
			$this->db->where('sub_sub_gal_id', $sub_sub_cat_id);
			$this->db->update('sub_sub_gallery', $data); 	
		}
		elseif($status=='Inactive')
		{
			$data = array('status'=>'A');
			$this->db->where('sub_sub_gal_id', $sub_sub_cat_id);
			$this->db->update('sub_sub_gallery', $data); 	
		}
	}
	
	function getSubSubCatDetails($sub_sub_cat_id)
	{
	   $sql_query="SELECT * FROM sub_sub_gallery WHERE sub_sub_gal_id='".$sub_sub_cat_id."'";
	   return $this->db->query($sql_query)->result_array();
	}	
	
	function updateSubSubCategory($sub_sub_cat_id, $arr)
	{
	//print_r($arr);
		$data_update = array('sub_sub_gallery' => $arr['sub_sub_category']);	
		$this->db->where('sub_sub_gal_id', $arr['sub_sub_cat_id']);
		$this->db->update('sub_sub_gallery', $data_update); 
		return true;
	}
	function deleteSubSubCategory($sub_sub_cat_id)
	{
		$infArr=$this->db->get_where('sub_sub_gallery', array('sub_sub_gal_id'=>$sub_sub_cat_id))->result();
		$this->db->delete('sub_sub_gallery', array('sub_sub_gal_id' => $sub_sub_cat_id)); 
	}
	function detete_category($arr) // delete users record 
	{ 
		if(count($arr)>0)
		{
			$ids = implode(',',$arr);
		}
		else
		{
			$ids = $id;
		}
		
		$this->db->where('id IN('.$ids.')');
		return $this->db->delete('gallery_type'); 

			 
	}
	
}// CLASS END HERE
?>
