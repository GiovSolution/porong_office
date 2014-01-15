<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: member Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_member.php
 	+ Author  		: 
 	+ Created on 01/Sep/2009 10:36:44
	
*/

//class of member
class C_member extends Controller {

	//constructor
	function C_member(){
		parent::Controller();
		$this->load->model('m_member', '', TRUE);
		session_start();
		$this->load->plugin('to_excel');
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_member');
	}
	
	function get_customer_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_public_function->get_customer_list($query,$start,$end);
		echo $result;
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->member_list();
				break;
			case "UPDATE":
				$this->member_update();
				break;
			case "CREATE":
				$this->member_create();
				break;
			case "DELETE":
				$this->member_delete();
				break;
			case "SEARCH":
				$this->member_search();
				break;
			case "PRINT":
				$this->member_print();
				break;
			case "EXCEL":
				$this->member_export_excel();
				break;
			case "MEMBERADD":
				$this->member_add();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function member_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_member->member_list($query,$start,$end);
		echo $result;
	}

	//function for update record
	function member_update(){
		//POST variable here
		$member_id=trim(@$_POST["member_id"]);
		//$member_cust=trim(@$_POST["member_cust"]);
		$member_no=trim(@$_POST["member_no"]);
		$member_no=str_replace("/(<\/?)(p)([^>]*>)", "",$member_no);
		$member_no=str_replace("'", '"',$member_no);
		//$member_register=trim(@$_POST["member_register"]);
		//$member_valid=trim(@$_POST["member_valid"]);
		/*$member_nota_ref=trim(@$_POST["member_nota_ref"]);
		$member_nota_ref=str_replace("/(<\/?)(p)([^>]*>)", "",$member_nota_ref);
		$member_nota_ref=str_replace(",", ",",$member_nota_ref);
		$member_nota_ref=str_replace("'", '"',$member_nota_ref);
		$member_point=trim(@$_POST["member_point"]);
		$member_jenis=trim(@$_POST["member_jenis"]);
		$member_jenis=str_replace("/(<\/?)(p)([^>]*>)", "",$member_jenis);
		$member_jenis=str_replace(",", ",",$member_jenis);
		$member_jenis=str_replace("'", '"',$member_jenis); */
		$member_status=trim(@$_POST["member_status"]);
		$member_status=str_replace("/(<\/?)(p)([^>]*>)", "",$member_status);
		$member_status=str_replace(",", ",",$member_status);
		$member_status=str_replace("'", '"',$member_status);
		//$member_tglserahterima=trim(@$_POST["member_tglserahterima"]);
		//$result = $this->m_member->member_update($member_id ,$member_cust ,$member_no ,$member_register ,$member_valid ,$member_nota_ref ,$member_point ,$member_jenis ,$member_status );
		$result = $this->m_member->member_update($member_id ,$member_no , $member_status);
		echo $result;
	}
	
	//function for create new record
	function member_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$member_cust=trim(@$_POST["member_cust"]);
		$member_no=trim(@$_POST["member_no"]);
		$member_no=str_replace("/(<\/?)(p)([^>]*>)", "",$member_no);
		$member_no=str_replace("'", '"',$member_no);
		$member_register=trim(@$_POST["member_register"]);
		$member_valid=trim(@$_POST["member_valid"]);
		$member_nota_ref=trim(@$_POST["member_nota_ref"]);
		$member_nota_ref=str_replace("/(<\/?)(p)([^>]*>)", "",$member_nota_ref);
		$member_nota_ref=str_replace("'", '"',$member_nota_ref);
		$member_point=trim(@$_POST["member_point"]);
		$member_jenis=trim(@$_POST["member_jenis"]);
		$member_jenis=str_replace("/(<\/?)(p)([^>]*>)", "",$member_jenis);
		$member_jenis=str_replace("'", '"',$member_jenis);
		$member_status=trim(@$_POST["member_status"]);
		$member_status=str_replace("/(<\/?)(p)([^>]*>)", "",$member_status);
		$member_status=str_replace("'", '"',$member_status);
		$member_tglserahterima=trim(@$_POST["member_tglserahterima"]);
		$result=$this->m_member->member_create($member_cust ,$member_no ,$member_register ,$member_valid ,$member_nota_ref ,$member_point ,$member_jenis ,$member_status ,$member_tglserahterima );
		echo $result;
	}
	
	//Adding Member Tanpa-Transaksi
	function member_add(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$member_cust=trim(@$_POST["member_cust"]);
		$result=$this->m_member->member_add($member_cust );
		echo $result;
	}

	//function for delete selected record
	function member_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_member->member_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function member_search(){
		//POST varibale here
		$member_id=trim(@$_POST["member_id"]);
		$member_cust=trim(@$_POST["member_cust"]);
		$member_no=trim(@$_POST["member_no"]);
		$member_no=str_replace("/(<\/?)(p)([^>]*>)", "",$member_no);
		$member_no=str_replace("'", '"',$member_no);
		$member_register=trim(@$_POST["member_register"]);
		$member_register_end=trim(@$_POST["member_register_end"]);
		$member_valid=trim(@$_POST["member_valid"]);
		$member_valid_end=trim(@$_POST["member_valid_end"]);
//		$member_nota_ref=trim(@$_POST["member_nota_ref"]);
//		$member_nota_ref=str_replace("/(<\/?)(p)([^>]*>)", "",$member_nota_ref);
//		$member_nota_ref=str_replace("'", '"',$member_nota_ref);
		$member_point=trim(@$_POST["member_point"]);
		$member_jenis=trim(@$_POST["member_jenis"]);
		$member_jenis=str_replace("/(<\/?)(p)([^>]*>)", "",$member_jenis);
		$member_jenis=str_replace("'", '"',$member_jenis);
		$member_status=trim(@$_POST["member_status"]);
		$member_status=str_replace("/(<\/?)(p)([^>]*>)", "",$member_status);
		$member_status=str_replace("'", '"',$member_status);
		//$member_tglserahterima=trim(@$_POST["member_tglserahterima"]);
		//$member_tglserahterima_end=trim(@$_POST["member_tglserahterima_end"]);
		$member_tglcetak=trim(@$_POST["member_tglcetak"]);
		$member_tglcetak_end=trim(@$_POST["member_tglcetak_end"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_member->member_search($member_id ,$member_cust ,$member_no ,$member_register, $member_register_end, $member_valid, $member_valid_end, $member_point ,$member_jenis ,$member_status, $member_tglcetak, $member_tglcetak_end, $start,$end);
		echo $result;
	}

	function member_cetak(){
		
		$data["data_print"] = $this->m_member->member_cetak();
		$print_view=$this->load->view("main/p_member_cetak.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$print_file=fopen("print/member_cetak_printlist.html","w+");
		fwrite($print_file, $print_view);
		echo '1';    
	}
	
	function member_aktivasi(){
		$member_id=trim(@$_POST["member_id"]);
		$result=$this->m_member->member_aktivasi($member_id);
		echo '1';    
	}
	
	function member_print(){
  		//POST varibale here
		$member_id=trim(@$_POST["member_id"]);
		$member_cust=trim(@$_POST["member_cust"]);
		$member_no=trim(@$_POST["member_no"]);
		$member_no=str_replace("/(<\/?)(p)([^>]*>)", "",$member_no);
		$member_no=str_replace("'", '"',$member_no);
		$member_register=trim(@$_POST["member_register"]);
		$member_register_end=trim(@$_POST["member_register_end"]);
		$member_valid=trim(@$_POST["member_valid"]);
		$member_valid_end=trim(@$_POST["member_valid_end"]);
		$member_nota_ref=trim(@$_POST["member_nota_ref"]);
		$member_nota_ref=str_replace("/(<\/?)(p)([^>]*>)", "",$member_nota_ref);
		$member_nota_ref=str_replace("'", '"',$member_nota_ref);
		$member_point=trim(@$_POST["member_point"]);
		$member_jenis=trim(@$_POST["member_jenis"]);
		$member_jenis=str_replace("/(<\/?)(p)([^>]*>)", "",$member_jenis);
		$member_jenis=str_replace("'", '"',$member_jenis);
		$member_status=trim(@$_POST["member_status"]);
		$member_status=str_replace("/(<\/?)(p)([^>]*>)", "",$member_status);
		$member_status=str_replace("'", '"',$member_status);
		$member_tglcetak=trim(@$_POST["member_tglcetak"]);
		$member_tglcetak_end=trim(@$_POST["member_tglcetak_end"]);
		//$member_tglserahterima=trim(@$_POST["member_tglserahterima"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$data["data_print"] = $this->m_member->member_print($member_id
															,$member_cust
															,$member_no
															,$member_register
															,$member_register_end
															,$member_valid
															,$member_valid_end
															,$member_nota_ref
															,$member_point
															,$member_jenis
															,$member_status
															,$member_tglcetak
															,$member_tglcetak_end
															, /*$member_tglserahterima,*/ $option
															,$filter);
		$print_view=$this->load->view("main/p_member_cetak.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$print_file=fopen("print/member_printlist.html","w+");
		fwrite($print_file, $print_view);
		echo '1';
		
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function member_export_excel(){
		//POST varibale here
		$member_id=trim(@$_POST["member_id"]);
		$member_cust=trim(@$_POST["member_cust"]);
		$member_no=trim(@$_POST["member_no"]);
		$member_no=str_replace("/(<\/?)(p)([^>]*>)", "",$member_no);
		$member_no=str_replace("'", '"',$member_no);
		$member_register=trim(@$_POST["member_register"]);
		$member_register_end=trim(@$_POST["member_register_end"]);
		$member_valid=trim(@$_POST["member_valid"]);
		$member_valid_end=trim(@$_POST["member_valid_end"]);
		$member_nota_ref=trim(@$_POST["member_nota_ref"]);
		$member_nota_ref=str_replace("/(<\/?)(p)([^>]*>)", "",$member_nota_ref);
		$member_nota_ref=str_replace("'", '"',$member_nota_ref);
		$member_point=trim(@$_POST["member_point"]);
		$member_jenis=trim(@$_POST["member_jenis"]);
		$member_jenis=str_replace("/(<\/?)(p)([^>]*>)", "",$member_jenis);
		$member_jenis=str_replace("'", '"',$member_jenis);
		$member_status=trim(@$_POST["member_status"]);
		$member_status=str_replace("/(<\/?)(p)([^>]*>)", "",$member_status);
		$member_status=str_replace("'", '"',$member_status);
		$member_tglcetak=trim(@$_POST["member_tglcetak"]);
		$member_tglcetak_end=trim(@$_POST["member_tglcetak_end"]);
		//$member_tglserahterima=trim(@$_POST["member_tglserahterima"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_member->member_export_excel($member_id
													  ,$member_cust
													  ,$member_no
													  ,$member_register
													  ,$member_register_end
													  ,$member_valid
													  ,$member_valid_end
													  ,$member_nota_ref
													  ,$member_point
													  ,$member_jenis
													  ,$member_status
													  ,$member_tglcetak
													  ,$member_tglcetak_end
													  ,/*$member_tglserahterima,*/ $option
													  ,$filter);
		
		to_excel($query,"member"); 
		echo '1';
			
	}
	
	// Encodes a SQL array into a JSON formated string
	function JEncode($arr){
		if (version_compare(PHP_VERSION,"5.2","<"))
		{    
			require_once("./JSON.php"); //if php<5.2 need JSON class
			$json = new Services_JSON();//instantiate new json object
			$data=$json->encode($arr);  //encode the data in json format
		} else {
			$data = json_encode($arr);  //encode the data in json format
		}
		return $data;
	}
	
	// Decode a SQL array into a JSON formated string
	function JDecode($arr){
		if (version_compare(PHP_VERSION,"5.2","<"))
		{    
			require_once("./JSON.php"); //if php<5.2 need JSON class
			$json = new Services_JSON();//instantiate new json object
			$data=$json->decode($arr);  //decode the data in json format
		} else {
			$data = json_decode($arr);  //decode the data in json format
		}
		return $data;
	}
	
	// Encodes a YYYY-MM-DD into a MM-DD-YYYY string
	function codeDate ($date) {
	  $tab = explode ("-", $date);
	  $r = $tab[1]."/".$tab[2]."/".$tab[0];
	  return $r;
	}
	
}
?>