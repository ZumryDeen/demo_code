<?php
class get_data_v2 extends Model{
	function get_data_v2 (){
		parent:: Model();
	}
	
	
public function load_expenses_row($c_id){
$query= $this->db->query("select * from taxonomy_v2 where t_id in (select distinct efs_t_row from entity_financial_sum_v2 where efs_entity_id='$c_id') and (t_parent_id =1861 or t_parent_id =7089) and t_total_tag='f'");
//$query= $this->db->query("select * from taxonomy_v2 where t_id in (select distinct efs_t_row from entity_financial_sum_v2 where efs_entity_id='$c_id') and (t_parent_id =1861)");
return $query->result();
}
	

//get revenue row (changing net assist - overview)
public function load_row($c_id){
$query= $this->db->query("select * from taxonomy_v2 where t_id in(select distinct efs_t_row from entity_financial_sum_v2 where efs_entity_id='$c_id') and (t_parent_id = 1850 or t_parent_id =1854 or t_parent_id=1992 or t_parent_id=1936 or t_parent_id=2156 or t_parent_id=2086 or t_parent_id=2096) and  t_total_tag='f'");
//$query= $this-> db->query("select  DISTINCT t_label,t_tag,t_id,t_parent_tag from taxonomy_v2 left join entity_financial_sum_v2 on t_id=efs_t_row 
//where  efs_entity_id=$c_id and(t_parent_id = 1850 or t_parent_id =1854)and t_total_tag='f'");
return $query->result();
	}
	
	
	// Reveneu row
	
	//city comparison - Reveneu row
	public function city_reven_row($c_id1,$c_id2,$c_id3,$c_id4,$c_id5,$year){
		$query= $this->db->query("select * from taxonomy_v2 where t_id in (select distinct efs_t_row from entity_financial_sum_v2 where efs_entity_id='$c_id1' or efs_entity_id='$c_id2' or efs_entity_id='$c_id3' or efs_entity_id='$c_id4' or efs_entity_id='$c_id5' and (efs_year='$year')) and (t_parent_id = 1850 or t_parent_id =1854 or
				t_parent_id=1847 or t_parent_id=1992 or t_parent_id=1936 or t_parent_id=2156 or t_parent_id=2086 or t_parent_id=2096) and t_total_tag='f'");
		return $query->result();
		}
	
	
	
	//------------------------------------dyanamic Table---------------------------------------
	

		// Return rows for 5 Entity comparison 
public function find_rows_coparison($c_id1,$c_id2,$c_id3,$c_id4,$c_id5,$year,$parent,$column){
$query= $this->db->query("SELECT  DISTINCT t_total_tag,t_order,t_depth,t_label,t_id,efs_year
FROM entity_financial_sum_v2 JOIN taxonomy_v2 on efs_t_row = t_id WHERE efs_year='2009'and (efs_entity_id=8122 or efs_entity_id='$c_id2' or efs_entity_id='$c_id3' or efs_entity_id='$c_id4' or efs_entity_id='$c_id5')and t_total_tag='f'and  efs_t_row in
(WITH RECURSIVE taxonomy_hiearchy(t_id, t_parent_id) AS (
SELECT t_id, t_parent_id from taxonomy_v2
WHERE (t_parent_id=2096) AND t_dimension = 'R'
UNION ALL
SELECT tn.t_id, tn.t_parent_id
FROM taxonomy_hiearchy th, taxonomy_v2 tn
WHERE tn.t_parent_id = th.t_id and th.t_parent_id IS NOT NULL)
SELECT DISTINCT t_id
FROM taxonomy_hiearchy ORDER BY t_id) and efs_t_column=1847  order by t_depth DESC");
return $query->result();
}
		


public function find_current_rows_coparison($c_id,$year,$parent,$column){
	$query= $this->db->query("SELECT  DISTINCT t_total_tag,t_order,t_depth,t_label,t_id,efs_year
			FROM entity_financial_sum_v2 JOIN taxonomy_v2 on efs_t_row = t_id WHERE  efs_entity_id='$c_id' and  efs_year='$year'and efs_t_row in
			(WITH RECURSIVE taxonomy_hiearchy(t_id, t_parent_id) AS (
			SELECT t_id, t_parent_id from taxonomy_v2
			WHERE (t_parent_id=$parent) AND t_dimension = 'R'
			UNION ALL
			SELECT tn.t_id, tn.t_parent_id
			FROM taxonomy_hiearchy th, taxonomy_v2 tn
			WHERE tn.t_parent_id = th.t_id and th.t_parent_id IS NOT NULL)
			SELECT DISTINCT t_id
			FROM taxonomy_hiearchy ORDER BY t_id) efs_t_column=$column order by t_depth DESC");
	return $query->result();
}

public function find_rows($c_id,$year,$parent){
	$query= $this->db->query("SELECT  DISTINCT t_total_tag,t_order,t_depth,t_label,t_id,efs_year
			FROM entity_financial_sum_v2 JOIN taxonomy_v2 on efs_t_row = t_id WHERE  efs_entity_id =$c_id  and efs_year='$year'and efs_t_row in
			(WITH RECURSIVE taxonomy_hiearchy(t_id, t_parent_id) AS (
			SELECT t_id, t_parent_id from taxonomy_v2
			WHERE (t_parent_id=$parent) AND t_dimension = 'R'
			UNION ALL
			SELECT tn.t_id, tn.t_parent_id
			FROM taxonomy_hiearchy th, taxonomy_v2 tn
			WHERE tn.t_parent_id = th.t_id and th.t_parent_id IS NOT NULL)
			SELECT DISTINCT t_id
			FROM taxonomy_hiearchy ORDER BY t_id)  order by t_depth DESC");
return $query->result();
}


		// find column header for dyanamic table 
public function find_header($eid,$year,$fund){
$query= $this->db->query("SELECT DISTINCT t_id,t_total_tag ,t_dimension,t_id,t_order,t_depth,t_label,t_parent_tag,efs_entity_id, efs_year ,efs_t_column,efs_scaler
FROM entity_financial_sum_v2 JOIN taxonomy_v2 on efs_t_column = t_id WHERE  efs_entity_id =$eid and t_total_tag='f' and efs_year='$year' and efs_t_column in
(WITH RECURSIVE taxonomy_hiearchy(t_id, t_parent_id) AS (
SELECT t_id, t_parent_id from taxonomy_v2
WHERE (t_parent_id = $fund) 
UNION ALL
SELECT tn.t_id, tn.t_parent_id
FROM taxonomy_hiearchy th, taxonomy_v2 tn
WHERE tn.t_parent_id = th.t_id and th.t_parent_id IS NOT NULL)
SELECT DISTINCT t_id
FROM taxonomy_hiearchy ORDER BY t_id) order by efs_t_column");
			return $query->result();
		}
		
		// ged colum for comarison city eg: govermental type 
		public function find_header2($eid,$year,$fund){
		$query= pg_query("select efs_amount from entity_financial_sum_v2 where efs_t_row in
					(select distinct t_id from taxonomy_v2 where t_id=$p_id) and efs_t_column in(select distinct t_id from taxonomy_v2 where t_parent_id = 2671 and t_dimension = 'C' and t_total_tag = true) and efs_entity_id =$cid and efs_year='$year'");
			$row = pg_fetch_array($query);
			return $row[0];
				}

		
public function find_efs_amount($id,$colum_id,$eid,$year){
$query= $this->db->query("
select efs_amount from entity_financial_sum_v2 where efs_t_row in(select distinct t_id from taxonomy_v2 where efs_entity_id=$eid  ) 
and (efs_t_row=$id and efs_year ='2009' and  efs_t_column=$colum_id)");
return $query->result();
}



public function get_scaler($c_id,$year,$fund){
	$query=pg_query ("select DISTINCT efs_scaler as scl from taxonomy_v2 left join entity_financial_sum_v2 on t_id=efs_t_row
			where  efs_entity_id=$c_id and efs_year='$year' and t_parent_id =$fund");
	$row = pg_fetch_assoc($query);
	return $row['scl'];
}
		

// find sum of loaded rows 
public function find_sum_rows($id,$colum_id,$eid,$year,$parent){
	$query= pg_query("SELECT sum (efs_amount) as count
FROM entity_financial_sum_v2 JOIN taxonomy_v2 on efs_t_row = t_id WHERE  efs_entity_id =$eid  and efs_year='$year'and efs_t_row in
(WITH RECURSIVE taxonomy_hiearchy(t_id, t_parent_id) AS (
SELECT t_id, t_parent_id from taxonomy_v2
WHERE (t_parent_id=$parent) AND t_dimension = 'R'
UNION ALL
SELECT tn.t_id, tn.t_parent_id
FROM taxonomy_hiearchy th, taxonomy_v2 tn
WHERE tn.t_parent_id = th.t_id and th.t_parent_id IS NOT NULL)
SELECT DISTINCT t_id
FROM taxonomy_hiearchy ORDER BY t_id)  and efs_t_column=$colum_id");
			$row = pg_fetch_assoc($query);
			return $row['count'];
}



		
		//load tabels- 
	 
public function load_tabels(){
$query= $this->db->query("select t_label,t_id from taxonomy_v2 where t_parent_id = 1736");
return $query->result();
}
		
		//load fund-
		public function load_fund($id){
			$query= $this->db->query("select t_label,t_id from taxonomy_v2 where t_parent_id=$id");
			return $query->result();
			
			
		}
		
	
//city comparison - Expenses row 
public function city_expens_row($c_id,$c_id1,$c_id2,$c_id3,$c_id4,$c_id5,$gv_act){
$query= $this->db->query("select * from taxonomy_v2 where t_id in (select distinct efs_t_row from entity_financial_sum_v2 where  efs_t_column=$gv_act and t_total_tag='f' and ((efs_entity_id='$c_id') or (efs_entity_id='$c_id1') or (efs_entity_id='$c_id2') or (efs_entity_id='$c_id3') or (efs_entity_id='$c_id4') or (efs_entity_id='$c_id5'))) and (t_parent_id =1861 or t_parent_id =7089)");
return $query->result();
}
		

	
	//summery - Total govermantal activities 
public function summ_trg($col_id,$year,$c_id){
$query= pg_query("select sum(efs_amount)as count from entity_financial_sum_v2 where efs_t_row 
in(select distinct t_id from taxonomy_v2 where efs_entity_id=$c_id and 
(t_parent_id = 1850 or t_parent_id=1854) and t_total_tag='f') and (efs_year ='$year' and  efs_t_column=$col_id)");
$row = pg_fetch_assoc($query);
return $row['count'];
	}
	
	
public function find_column($id,$year1,$c_id,$gv_act){
$query= $this->db->query("select * from entity_financial_sum_v2 where efs_t_column in(select distinct t_id from taxonomy_v2 where efs_entity_id=$c_id and (t_parent_id=1789 or t_parent_id=2900)  and t_total_tag='f') and (efs_t_row=$id and efs_year ='$year1' and  efs_t_column=$gv_act)");
return $query->result();
	}

	

	
public function find_percentage($tax,$total){
$rank = $tax/$total*100;
return $rank;
	}
	
	

	
	//get population 
	
public function get_population($e_id){
$query=pg_query("select e_pop as qty from entity where e_id ='$e_id'");
		$row = pg_fetch_assoc($query);
		return $row['qty'];
		
		}
		
		//changing value 
		public function change($val1,$val2){
		
		if(empty($val1) or empty($val2) ){
			
			return false;
			
			}
			
			else 
			{
			$change= $val2- $val1;
			return $change ;
		}
		}
		
		
		//changing %
		public function Percentage($val1,$val2){	
			
			if(empty($val1))		
			{
				return false;
			}
			
			else 
			{
			$change= $val2/$val1;
			$change = $change-1;
			$change = $change * 100;
			return $change ;
			}
		}
		
		
		//per citizen %
		public function perCitizen($total,$pop,$scl){
		if (empty($total) or empty($pop)) {
			
			return false;
		}
		
		if($scl=='M'){
			$total = $total * 1000000;
			$rank = $total/$pop;
			return $rank ;
		}
		
		if($scl=='K'){
			$total = $total * 1000;
			$rank = $total/$pop;
			return $rank ;
		}
		
		
		else {
		$rank = $total/$pop;
		return $rank ;
				}
		}
		
		//sum_expenses
		public function sum_expenses($col_id,$year,$c_id){
	
			
			$query= pg_query("select sum(efs_amount)as count from entity_financial_sum_v2 where efs_t_row
					in(select distinct t_id from taxonomy_v2 where efs_entity_id=$c_id and
					(t_parent_id = 1861 or t_parent_id = 7089 ) and t_total_tag='f') and
					(efs_year ='$year' and  efs_t_column=$col_id)");
			
			$row = pg_fetch_assoc($query);
			return $row['count'];
		}
		

		//get selected peer
		public function get_peer($uid){
			
			$query= $this->db->query("select usp_entity from user_sel_peers where usp_user_id='$uid'");
			return $query->result();
		}
		
		//get selected city 
		public function get_cities($c_id_v2){
			$query= $this->db->query("select e_name from entity where e_id='$c_id_v2'");
			return $query->result();
		}
		


		public function to_array($result){
			$res_array = array();
			for ($count=0; $row = pg_fetch_array($result); $count ++)
			{
				$res_array[$count] = $row;
			}
			return $res_array;
		}
		
		
		//find table
		public function find_table($tid){
			$query= pg_query("select t_label from taxonomy_v2 where t_id=$tid");
			$row = pg_fetch_array($query);
			return $row[0];
		}
		
		
		//get fincacial type 
		public function find_column_type($c_id){
			
			$query= $this->db->query("select DISTINCT t_order,t_label,efs_t_column from entity_financial_sum_v2 left join taxonomy_v2 on
			efs_t_column = t_id
			where  efs_entity_id=$c_id and (t_parent_id =1789 or t_parent_id =2900 )  and t_total_tag='f'  and  t_dimension='C' order by t_order");
			return $query->result();

		}
		
		
		
		//get fincacial type for 5 city comparison
		public function fincacial_type_5($c_id1,$c_id2,$c_id3,$c_id4,$c_id5){
				
			$query= $this->db->query("select DISTINCT t_order,t_label,efs_t_column from entity_financial_sum_v2 left join taxonomy_v2 on
			efs_t_column = t_id
			where  t_total_tag='f' and (efs_entity_id='$c_id1' or efs_entity_id='$c_id2' or efs_entity_id='$c_id3' or efs_entity_id='$c_id4' or efs_entity_id='$c_id5') and (t_parent_id =1789 or t_parent_id =2900 )   and  t_dimension='C' order by t_order");
			return $query->result();
		
		}

		// No of House hold 
		
		public function house_hold($e_id){
		$query=pg_query("SELECT dpsf0180002 as nhh
		FROM entity
		join census_geo cg on cast( placens as bigint) = e_feature_id
		join   census_profile_data using (stusab,logrecno,chariter)
		where  e_id ='$e_id'");
		$row = pg_fetch_assoc($query);
		return $row['nhh'];
}
		 
		
		
		
		// get currency scaler
		public function get_currency($scl){
			if($scl =='M'){
				$curruncy = "Millions";
				return $curruncy;
			}
					if($scl =='K'){
					$curruncy = "Thousands";
					return $curruncy;
					}
					
	else {
			
				$curruncy = "Dollars";
				return $curruncy;	
			}
		}
		
		
		// Debt 
		
		
		
		public function find_debt_row($id,$year1){
			$query= $this->db->query("select DISTINCT t_id,t_label,t_tag,t_parent_id,t_parent_tag,t_order,efs_t_column,efs_t_row,t_depth,efs_scaler,efs_amount,t_total_tag,efs_entity_id,efs_year  from taxonomy_v2 left join entity_financial_sum_v2 on t_id=efs_t_row 
where  t_prefix = 'cp-tables' and t_label ilike '%debt%' and t_parent_id!=1788 and t_parent_id!=1789  and t_total_tag='f' and efs_entity_id =$id and efs_year='$year1' order by efs_t_column");
			return $query->result();
		}
		
		// find row (income and Expenses)
		public function find_common_row($eid,$year1,$parent){
$query= $this->db->query("SELECT  DISTINCT t_total_tag,t_order,t_depth,t_label,t_id,efs_amount,efs_scaler,t_parent_id
FROM entity_financial_sum_v2 JOIN taxonomy_v2 on efs_t_row = t_id WHERE  efs_entity_id =$eid and efs_year='$year1' and efs_t_row in
(WITH RECURSIVE taxonomy_hiearchy(t_id, t_parent_id) AS (
SELECT t_id, t_parent_id from taxonomy_v2
WHERE (t_parent_id=$parent) AND t_dimension = 'R'
UNION ALL
SELECT tn.t_id, tn.t_parent_id
FROM taxonomy_hiearchy th, taxonomy_v2 tn
WHERE tn.t_parent_id = th.t_id and th.t_parent_id IS NOT NULL)
SELECT DISTINCT t_id
FROM taxonomy_hiearchy ORDER BY t_id) and  efs_t_column in (select distinct t_id from taxonomy_v2 where t_total_tag = true) order by t_depth DESC");
			return $query->result();
		}
		
		// find Debt Due within one year 

				public function find_due_debt($eid,$year1,$parent){
				$query= pg_query("SELECT sum (efs_amount) as count
					FROM entity_financial_sum_v2 JOIN taxonomy_v2 on efs_t_row = t_id WHERE  efs_entity_id =$eid and efs_year='$year1' and efs_t_row in
					(WITH RECURSIVE taxonomy_hiearchy(t_id, t_parent_id) AS (
					SELECT t_id, t_parent_id from taxonomy_v2
					WHERE (t_parent_id=$parent) AND t_dimension = 'R'
					UNION ALL
					SELECT tn.t_id, tn.t_parent_id
					FROM taxonomy_hiearchy th, taxonomy_v2 tn
					WHERE tn.t_parent_id = th.t_id and th.t_parent_id IS NOT NULL AND t_total_tag = false)
					SELECT DISTINCT t_id
					FROM taxonomy_hiearchy ORDER BY t_id) and  efs_t_column in (select distinct t_id from taxonomy_v2 where t_dimension = 'C' and t_tag = 'DUEWITHINONEYEAR')");
					$row = pg_fetch_assoc($query);
					return $row['count'];
		
				}
				
				
		
		
		// find sum debt (tax)
		
		public function find_debt_sum ($eid,$year1,$parent){
			$query= pg_query("SELECT sum (efs_amount) as count
					FROM entity_financial_sum_v2 JOIN taxonomy_v2 on efs_t_row = t_id WHERE  efs_entity_id =$eid and efs_year='$year1' and efs_t_row in
					(WITH RECURSIVE taxonomy_hiearchy(t_id, t_parent_id) AS (
					SELECT t_id, t_parent_id from taxonomy_v2
					WHERE (t_parent_id=$parent) AND t_dimension = 'R'
					UNION ALL
					SELECT tn.t_id, tn.t_parent_id
					FROM taxonomy_hiearchy th, taxonomy_v2 tn
					WHERE tn.t_parent_id = th.t_id and th.t_parent_id IS NOT NULL AND t_total_tag = false)
					SELECT DISTINCT t_id
					FROM taxonomy_hiearchy ORDER BY t_id) and  efs_t_column in (select distinct t_id from taxonomy_v2 where t_total_tag = true)");
					$row = pg_fetch_assoc($query);
					return $row['count'];		
		}
		
		
		
		// find row (tax)
		public function find_tax_row($eid,$year1,$parent){
			$query= $this->db->query("SELECT  DISTINCT t_total_tag,t_order,t_depth,t_label,t_id,efs_amount,efs_scaler,t_parent_id
					FROM entity_financial_sum_v2 JOIN taxonomy_v2 on efs_t_row = t_id WHERE  efs_entity_id =$eid and efs_year='$year1' and efs_t_row in
					(WITH RECURSIVE taxonomy_hiearchy(t_id, t_parent_id) AS (
					SELECT t_id, t_parent_id from taxonomy_v2
					WHERE (t_parent_id=$parent or t_parent_id=6824 ) AND t_dimension = 'R'
					UNION ALL
					SELECT tn.t_id, tn.t_parent_id
					FROM taxonomy_hiearchy th, taxonomy_v2 tn
					WHERE tn.t_parent_id = th.t_id and th.t_parent_id IS NOT NULL)
					SELECT DISTINCT t_id
					FROM taxonomy_hiearchy ORDER BY t_id) and  efs_t_column in (select distinct t_id from taxonomy_v2 where t_total_tag = true) order by t_depth DESC");
					return $query->result();
				}
				
				
				// find sum (tax)
				public function find_tax_sum ($eid,$year1,$parent){
							$query= pg_query("SELECT sum (efs_amount) as count 
							FROM entity_financial_sum_v2 JOIN taxonomy_v2 on efs_t_row = t_id WHERE  efs_entity_id =$eid and efs_year='$year1' and efs_t_row in
							(WITH RECURSIVE taxonomy_hiearchy(t_id, t_parent_id) AS (
							SELECT t_id, t_parent_id from taxonomy_v2
							WHERE (t_parent_id=3621 or t_parent_id=6824 ) AND t_dimension = 'R'
							UNION ALL
							SELECT tn.t_id, tn.t_parent_id
							FROM taxonomy_hiearchy th, taxonomy_v2 tn
							WHERE tn.t_parent_id = th.t_id and th.t_parent_id IS NOT NULL)
							SELECT DISTINCT t_id
							FROM taxonomy_hiearchy ORDER BY t_id) and  efs_t_column in (select distinct t_id from taxonomy_v2 where t_total_tag = true)");
							$row = pg_fetch_assoc($query);
							return $row['count'];
	
							
				}
				
		
		
		
		// find tax summery  (total Expenses, Income)
		public function Debt_summery($id,$year1,$key){
			$query= pg_query("select sum(efs_amount)as count from  taxonomy_v2 left join entity_financial_sum_v2 on t_id=efs_t_row 
where  t_prefix = 'cp-tables' and t_label ilike '%$key%' and t_total_tag='f' and efs_entity_id =$id and efs_year='$year1'");
			$row = pg_fetch_assoc($query);
			return $row['count'];
		}
		
		
		// find total (total Expenses, Income)
		public function find_totals($cid,$year,$p_id){
			$query= pg_query("select efs_amount from entity_financial_sum_v2 where efs_t_row in
					(select distinct t_id from taxonomy_v2 where t_id=$p_id) and efs_t_column in(select distinct t_id from taxonomy_v2 where t_parent_id = 2671 and t_dimension = 'C' and t_total_tag = true) and efs_entity_id =$cid and efs_year='$year'");
			$row = pg_fetch_array($query);
			return $row[0];
		}
		
		
		
		
		
		
		// find county id and State ID 
		public function find_entity_detail($e_id){
			
			$query= $this->db->query("select e_id,e_state_id,e_cnty_id from entity entity where e_id=$e_id");
			return $query->result();
			
		}
		
		
public function find_capital_hoshold($e_id){
$query= $this->db->query("select e_id, e_name, hc01_vc86 as mean_household_income , hc01_vc115 as per_capita_income from entity
join entity_geo_xref on egx_entity_id = e_id
join census_acs_dp03 on geo_id = egx_geo_id
where e_id = $e_id
order by  acs_year desc, acs_period
limit 1;");
return $query->result();		
		}
		

		public function find_county($county_id){
			$query= pg_query("select e_id  from entity where e_cnty_id=$county_id  and e_type_id=3");
			$row = pg_fetch_array($query);
			return $row[0];
		}
		
		public function find_state($state_id){
			$query= pg_query("select e_id  from entity where e_state_id =$state_id and e_type_id = 2");
			$row = pg_fetch_array($query);
			return $row[0];
		}
	
		// find child
		public function find_child2($p_id,$dept,$key)
		    
		{
			$query= $this->db->query("WITH RECURSIVE taxonomy_hiearchy( t_id, t_depth, t_order, t_parent_id, t_label) AS (
    		select t_id, t_depth, t_order, t_parent_id, t_label from taxonomy_v2
			where t_total_tag='f' and t_label ilike '%$key%' and t_id=$p_id
  			UNION ALL
      		select  tn.t_id,  tn.t_depth, tn.t_order, tn.t_parent_id, tn.t_label
       		from taxonomy_hiearchy th, taxonomy_v2 tn
			where tn.t_id = th.t_parent_id and th.t_parent_id is not NULL
    																				)
			select distinct  t_id, t_depth, t_order, t_parent_id, t_label from taxonomy_hiearchy
			where t_depth >= 4 and t_depth!=$dept
			order by t_depth , t_parent_id, t_order;");
			return $query->result();
			}
		
		
	
			public function find_child($p_id,$dept)
			
			{
				$query= $this->db->query("WITH RECURSIVE taxonomy_hiearchy( t_id, t_depth, t_order, t_parent_id, t_label) AS (
						select t_id, t_depth, t_order, t_parent_id, t_label from taxonomy_v2
						where t_total_tag='f' and t_label ilike '%debt%' and t_id=$p_id
						UNION ALL
						select  tn.t_id,  tn.t_depth, tn.t_order, tn.t_parent_id, tn.t_label
						from taxonomy_hiearchy th, taxonomy_v2 tn
						where tn.t_id = th.t_parent_id and th.t_parent_id is not NULL
				)
						select distinct  t_id, t_depth, t_order, t_parent_id, t_label from taxonomy_hiearchy
						where t_depth >= 4 and t_depth!=$dept
						order by t_depth , t_parent_id, t_order;");
				return $query->result();
			}
			
			
		
		public function house_hold_county($county_id){
			$query= pg_query("SELECT sum(dpsf0180002)
		FROM entity
		join census_geo cg on cast( placens as bigint) = e_feature_id
		join   census_profile_data using (stusab,logrecno,chariter)
		where  e_id in (select e_id from entity where e_cnty_id = $county_id and e_type_id > 3 and e_type_id <= 7)");
			$row = pg_fetch_array($query);
			return $row[0];
		}
		
		
		
		
		// find currency
		
		public function convert($amount,$scl){
		
			if($scl=='M'){
				$amount = $amount * 1000000;
				return $amount;
			}
		
			if($scl=='K'){
				$amount = $amount * 1000;
				
				return $amount ;
			}
			else {
				return $amount ;
			}
		}

}
?>