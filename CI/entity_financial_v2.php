<?php
class entity_financial_v2 extends Controller {

	function entity_financial_v2()
	{
		parent::Controller();	
		$this->load->model('login_model');
		$this->load->library('session');	
		$this->load->model('manage_registered_model');	
		$this->load->model('manage_entity_model');
		$this->load->model('manage_seo_contents');				

	}
	
	
	function revenue($ename)
	{
		$Total_trg = 0;
		//decode url valuee to plane id
		$name = explode("_",$ename);
	 	$arr['entity_id'] = $this->manage_entity_model->get_entity_id($name[0],$name[1],$name[2]);
	  	$e_id = $arr['entity_id'][0]['e_id'];
	  	$data = array('e_id' => $e_id);
		$this->session->set_userdata($data); 
	 	$arr['e_name'] = $ename;
	 	$arr['c_id']=$e_id;
		$arr['entity_data'] = $this->manage_entity_model->get_entity_details($e_id);
		$arr['e_data'] = $this->manage_entity_model->get_entity_overview($e_id);
	 	$arr['get_city'] = $this->manage_entity_model->get_demographics($e_id);  	
	//	print_r($arr['get_state']);
		//exit;
	 	//$arr['dem_data'] = $this->manage_entity_model->get_demographics_city($e_id);
		//$arr['dem_data_county'] = $this->manage_entity_model->get_demographics_county($e_id);
		//$arr['dem_data_state'] = $this->manage_entity_model->get_demographics_state($e_id);

	 	$arr['data_5'] = $this->manage_seo_contents->get_seo_content(25);
	 	//for active tab
		$arr['cur_tab'] = 'Financial';		
		if($this->session->userdata('user_id')!='')
		{
			$user_role_id = $this->session->userdata('user_role_id');
			$arr['data'] = $this->manage_registered_model->get_levels($user_role_id);
			$arr['e_data'] = $this->manage_entity_model->get_entity_overview($e_id); 
			$arr['get_city'] = $this->manage_entity_model->get_demographics($e_id); 
		
			$this->load->model("get_data_v2");
			$arr['city'] = $this->get_data_v2->get_peer($this->session->userdata('user_id'));
			$arr['res'] = $this->get_data_v2->load_row($e_id);
			$arr['type'] = $this->get_data_v2->fincacial_type($e_id);
			$this->load->view('revenue',$arr);
		}
		else
		{
			$arr['data'] = $this->manage_registered_model->get_unregistered_levels();
			$arr['e_data'] = $this->manage_entity_model->get_entity_overview($e_id); 
			$arr['get_city'] = $this->manage_entity_model->get_demographics($e_id);
			$this->load->view('entity_demographics',$arr);	
		}	
	}
	
	
	// stanment of net assist - (Overwive)
	function sna_overview($ename)
	{
		$Total_trg = 0;
		//decode url valuee to plane id
		$name = explode("_",$ename);
	 	$arr['entity_id'] = $this->manage_entity_model->get_entity_id($name[0],$name[1],$name[2]);
	  	$e_id = $arr['entity_id'][0]['e_id'];
	  	$data = array('e_id' => $e_id);
		$this->session->set_userdata($data); 
	 	$arr['e_name'] = $ename;
	 	$arr['c_id']=$e_id;
		$arr['entity_data'] = $this->manage_entity_model->get_entity_details($e_id);
		$arr['e_data'] = $this->manage_entity_model->get_entity_overview($e_id);
	 	$arr['get_city'] = $this->manage_entity_model->get_demographics($e_id);  	
	

	 	$arr['data_5'] = $this->manage_seo_contents->get_seo_content(25);
	 	//for active tab
		$arr['cur_tab'] = 'Financial';		
		if($this->session->userdata('user_id')!='')
		{
			$user_role_id = $this->session->userdata('user_role_id');
			$arr['data'] = $this->manage_registered_model->get_levels($user_role_id);
			$arr['e_data'] = $this->manage_entity_model->get_entity_overview($e_id); 
			
			$this->load->model("get_data_v2");
			
	
			
			$arr['city'] = $this->get_data_v2->get_peer($this->session->userdata('user_id'));
			$arr['res'] = $this->get_data_v2->load_row($e_id);
			$arr['type'] = $this->get_data_v2->fincacial_type($e_id);
			$this->load->view('revenue',$arr);
		}
		else
		{
			$arr['data'] = $this->manage_registered_model->get_unregistered_levels();
			$arr['e_data'] = $this->manage_entity_model->get_entity_overview($e_id); 
			$arr['get_city'] = $this->manage_entity_model->get_demographics($e_id);
			$this->load->view('entity_demographics',$arr);	
		}	
	}
	
	
	
	// get the expenses
	function expenses($ename)
	{
	
		
		//decode url valuee to plane id
		$name = explode("_",$ename);
		$arr['entity_id'] = $this->manage_entity_model->get_entity_id($name[0],$name[1],$name[2]);
		$e_id = $arr['entity_id'][0]['e_id'];
		$data = array('e_id' => $e_id);
		$this->session->set_userdata($data);
		$arr['e_name'] = $ename;
		$arr['c_id']=$e_id;
		$arr['entity_data'] = $this->manage_entity_model->get_entity_details($e_id);
		$arr['get_city'] = $this->manage_entity_model->get_demographics($e_id);
			

	
		$arr['data_5'] = $this->manage_seo_contents->get_seo_content(25);
		//for active tab
		$arr['cur_tab'] = 'Financial';
	
		if($this->session->userdata('user_id')!='')
		{
			$user_role_id = $this->session->userdata('user_role_id');
			$arr['data'] = $this->manage_registered_model->get_levels($user_role_id);
			$arr['e_data'] = $this->manage_entity_model->get_entity_overview($e_id);
			$arr['get_city'] = $this->manage_entity_model->get_demographics($e_id);
			
				
			$this->load->model("get_data_v2");
			$arr['res'] = $this->get_data_v2->load_expenses_row($e_id);
			$arr['type'] = $this->get_data_v2->fincacial_type($e_id);
				
			$this->load->view('expenses',$arr);
	
		}
		else
		{
			$arr['data'] = $this->manage_registered_model->get_unregistered_levels();
			$arr['e_data'] = $this->manage_entity_model->get_entity_overview($e_id);
			$arr['get_city'] = $this->manage_entity_model->get_demographics($e_id);
			$this->load->view('entity_demographics',$arr);
		}
	}
	
	
	// get the summery 
	function summery($ename)
	{
	
	
		//decode url valuee to plane id
		$name = explode("_",$ename);
		$arr['entity_id'] = $this->manage_entity_model->get_entity_id($name[0],$name[1],$name[2]);
		$e_id = $arr['entity_id'][0]['e_id'];
		$arr['e_data'] = $this->manage_entity_model->get_entity_overview($e_id); 
		$e_id = $arr['entity_id'][0]['e_id'];
		$data = array('e_id' => $e_id);
		$this->session->set_userdata($data);
		$arr['e_name'] = $ename;
		$arr['c_id']=$e_id;
		$arr['entity_data'] = $this->manage_entity_model->get_entity_details($e_id);
		$arr['get_city'] = $this->manage_entity_model->get_demographics($e_id);
	
			

		$arr['data_5'] = $this->manage_seo_contents->get_seo_content(25);
		//for active tab
		$arr['cur_tab'] = 'Financial';
	
		if($this->session->userdata('user_id')!='')
		{
			$user_role_id = $this->session->userdata('user_role_id');
			$arr['data'] = $this->manage_registered_model->get_levels($user_role_id);
			$arr['e_data'] = $this->manage_entity_model->get_entity_overview($e_id);
			$arr['get_city'] = $this->manage_entity_model->get_demographics($e_id);
			$this->load->model("get_data_v2");
			$arr['res'] = $this->get_data_v2->load_expenses_row($e_id);
	
			$this->load->view('summery',$arr);
	
		}
		
		else
		{
			$arr['data'] = $this->manage_registered_model->get_unregistered_levels();
			$arr['e_data'] = $this->manage_entity_model->get_entity_overview($e_id);
			$arr['get_city'] = $this->manage_entity_model->get_demographics($e_id);
			$this->load->view('entity_demographics',$arr);
		}
	}

	
	// jasper Report 
	function jasper($ename)
	{
	
	
		//decode url valuee to plane id
		$name = explode("_",$ename);
		$arr['entity_id'] = $this->manage_entity_model->get_entity_id($name[0],$name[1],$name[2]);
		$e_id = $arr['entity_id'][0]['e_id'];
		$arr['e_data'] = $this->manage_entity_model->get_entity_overview($e_id);
		$e_id = $arr['entity_id'][0]['e_id'];
		$data = array('e_id' => $e_id);
		$this->session->set_userdata($data);
		$arr['e_name'] = $ename;
		$arr['c_id']=$e_id;
		$arr['entity_data'] = $this->manage_entity_model->get_entity_details($e_id);
		$arr['get_city'] = $this->manage_entity_model->get_demographics($e_id);
	
			
	
		$arr['data_5'] = $this->manage_seo_contents->get_seo_content(25);
		//for active tab
		$arr['cur_tab'] = 'Financial';
	
		if($this->session->userdata('user_id')!='')
		{
			$user_role_id = $this->session->userdata('user_role_id');
			$arr['data'] = $this->manage_registered_model->get_levels($user_role_id);
			$arr['e_data'] = $this->manage_entity_model->get_entity_overview($e_id);
			$arr['get_city'] = $this->manage_entity_model->get_demographics($e_id);
		
	
			$this->load->model("get_data_v2");
			$arr['res'] = $this->get_data_v2->load_expenses_row($e_id);
	
			$this->load->view('jasper',$arr);
	
		}
	
		else
		{
			$arr['data'] = $this->manage_registered_model->get_unregistered_levels();
			$arr['e_data'] = $this->manage_entity_model->get_entity_overview($e_id);
			$arr['get_city'] = $this->manage_entity_model->get_demographics($e_id);
			$this->load->view('entity_demographics',$arr);
		}
	}
	
	
	
	
	// jasper Report
	function jasper_expenses($ename)
	{
	
	
		//decode url valuee to plane id
		$name = explode("_",$ename);
		$arr['entity_id'] = $this->manage_entity_model->get_entity_id($name[0],$name[1],$name[2]);
		$e_id = $arr['entity_id'][0]['e_id'];
		$arr['e_data'] = $this->manage_entity_model->get_entity_overview($e_id);
		$e_id = $arr['entity_id'][0]['e_id'];
		$data = array('e_id' => $e_id);
		$this->session->set_userdata($data);
		$arr['e_name'] = $ename;
		$arr['c_id']=$e_id;
		$arr['entity_data'] = $this->manage_entity_model->get_entity_details($e_id);
		$arr['get_city'] = $this->manage_entity_model->get_demographics($e_id);
	
			
			
	
		$arr['data_5'] = $this->manage_seo_contents->get_seo_content(25);

		$arr['cur_tab'] = 'Financial';
	
		if($this->session->userdata('user_id')!='')
		{
			$user_role_id = $this->session->userdata('user_role_id');
			$arr['data'] = $this->manage_registered_model->get_levels($user_role_id);
			$arr['e_data'] = $this->manage_entity_model->get_entity_overview($e_id);
			$arr['get_city'] = $this->manage_entity_model->get_demographics($e_id);
			$this->load->model("get_data_v2");
			$arr['res'] = $this->get_data_v2->load_expenses_row($e_id);
	
			$this->load->view('jasper_expenses',$arr);
	
		}
	
		else
		{
			$arr['data'] = $this->manage_registered_model->get_unregistered_levels();
			$arr['e_data'] = $this->manage_entity_model->get_entity_overview($e_id);
			$arr['get_city'] = $this->manage_entity_model->get_demographics($e_id);
			$this->load->view('entity_demographics',$arr);
		}
	}

	
	//chart comparison 
	function comparison_pie($ename)
	{
	
	
		//decode url valuee to plane id
		$name = explode("_",$ename);
		$arr['entity_id'] = $this->manage_entity_model->get_entity_id($name[0],$name[1],$name[2]);
		$e_id = $arr['entity_id'][0]['e_id'];
		$arr['e_data'] = $this->manage_entity_model->get_entity_overview($e_id);
		$e_id = $arr['entity_id'][0]['e_id'];
		$data = array('e_id' => $e_id);
		$this->session->set_userdata($data);
		$arr['e_name'] = $ename;
		$arr['c_id']=$e_id;
		$arr['entity_data'] = $this->manage_entity_model->get_entity_details($e_id);
		$arr['get_city'] = $this->manage_entity_model->get_demographics($e_id);
	
			
	
		$arr['data_5'] = $this->manage_seo_contents->get_seo_content(25);
		//for active tab
		$arr['cur_tab'] = 'Financial';
	
		if($this->session->userdata('user_id')!='')
		{
			$user_role_id = $this->session->userdata('user_role_id');
			$arr['data'] = $this->manage_registered_model->get_levels($user_role_id);
			$arr['e_data'] = $this->manage_entity_model->get_entity_overview($e_id);
			$arr['get_city'] = $this->manage_entity_model->get_demographics($e_id);
	
	
			$this->load->model("get_data_v2");
			$arr['res'] = $this->get_data_v2->load_expenses_row($e_id);
	
			$this->load->view('comarison_pie',$arr);
	
		}
	
		else
		{
			$arr['data'] = $this->manage_registered_model->get_unregistered_levels();
			$arr['e_data'] = $this->manage_entity_model->get_entity_overview($e_id);
			$arr['get_city'] = $this->manage_entity_model->get_demographics($e_id);
			$this->load->view('entity_demographics',$arr);
		}
	}
	
}
// END OF CLASS
?>