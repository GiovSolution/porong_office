<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: akun_setup Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_akun_setup.php
 	+ creator 		: 
 	+ Created on 18/Oct/2010 13:31:54
	
*/

//class of akun_setup
class C_akun_setup extends Controller {

	//constructor
	function C_akun_setup(){
		parent::Controller();
		session_start();
		$this->load->model('m_akun_setup', '', TRUE);
	}
	
	//set index
	function index(){
		$this->load->view('main/v_akun_setup');
	}
	
	function get_akun_setup(){
		$result=$this->m_akun_setup->get_akun_setup();
		echo $result;
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->akun_setup_list();
				break;
			case "UPDATE":
				$this->akun_setup_update();
				break;
			case "CREATE":
				$this->akun_setup_create();
				break;
			case "DELETE":
				$this->akun_setup_delete();
				break;
			case "SEARCH":
				$this->akun_setup_search();
				break;
			case "PRINT":
				$this->akun_setup_print();
				break;
			case "EXCEL":
				$this->akun_setup_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function akun_setup_list(){
		
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result=$this->m_akun_setup->akun_setup_list($query,$start,$end);
		echo $result;
	}
	
	//function for create new record
	function akun_setup_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$setup_periode_tahun=trim(@$_POST["setup_periode_tahun"]);
		$setup_periode_awal=trim(@$_POST["setup_periode_awal"]);
		$setup_periode_akhir=trim(@$_POST["setup_periode_akhir"]);
		$setup_author=@$_SESSION[SESSION_USERID];
		$setup_date_create=date(LONG_FORMATDATE);
		//$setup_update=NULL;
		//$setup_date_update=NULL;
		//$setup_revised=0;
		$result=$this->m_akun_setup->akun_setup_create($setup_periode_tahun ,$setup_periode_awal ,$setup_periode_akhir ,$setup_author ,
													   $setup_date_create );
		echo $result;
	}
	
	
	//function for update record
	function akun_setup_update(){
		//POST variable here
		$setup_id=trim(@$_POST["setup_id"]);
		$setup_periode_tahun=trim(@$_POST["setup_periode_tahun"]);
		$setup_periode_awal=trim(@$_POST["setup_periode_awal"]);
		$setup_periode_akhir=trim(@$_POST["setup_periode_akhir"]);
		//$setup_author="setup_author";
		//$setup_date_create="setup_date_create";
		$setup_update=@$_SESSION[SESSION_USERID];
		$setup_date_update=date(LONG_FORMATDATE);
		//$setup_revised="(revised+1)";
		$result = $this->m_akun_setup->akun_setup_update($setup_id,$setup_periode_tahun,$setup_periode_awal,$setup_periode_akhir,$setup_update,
														 $setup_date_update);
		echo $result;
	}
	
	//function for delete selected record
	function akun_setup_delete(){
		$ids = @$_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_akun_setup->akun_setup_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function akun_setup_search(){
		//POST varibale here
		$setup_id=trim(@$_POST["setup_id"]);
		$setup_periode_tahun=trim(@$_POST["setup_periode_tahun"]);
		$setup_periode_awal=trim(@$_POST["setup_periode_awal"]);
		$setup_periode_akhir=trim(@$_POST["setup_periode_akhir"]);
		$setup_author=trim(@$_POST["setup_author"]);
		$setup_author=str_replace("/(<\/?)(p)([^>]*>)", "",$setup_author);
		$setup_author=str_replace("'", "''",$setup_author);
		$setup_date_create=trim(@$_POST["setup_date_create"]);
		$setup_update=trim(@$_POST["setup_update"]);
		$setup_update=str_replace("/(<\/?)(p)([^>]*>)", "",$setup_update);
		$setup_update=str_replace("'", "''",$setup_update);
		$setup_date_update=trim(@$_POST["setup_date_update"]);
		$setup_revised=trim(@$_POST["setup_revised"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_akun_setup->akun_setup_search($setup_id ,$setup_periode_tahun ,$setup_periode_awal ,$setup_periode_akhir ,$setup_author ,
														 $setup_date_create ,$setup_update ,$setup_date_update ,$setup_revised ,$start,$end);
		echo $result;
	}


	function akun_setup_print(){
  		//POST varibale here
		$setup_id=trim(@$_POST["setup_id"]);
		$setup_periode_tahun=trim(@$_POST["setup_periode_tahun"]);
		$setup_periode_awal=trim(@$_POST["setup_periode_awal"]);
		$setup_periode_akhir=trim(@$_POST["setup_periode_akhir"]);
		$setup_author=trim(@$_POST["setup_author"]);
		$setup_author=str_replace("/(<\/?)(p)([^>]*>)", "",$setup_author);
		$setup_author=str_replace("'", "'",$setup_author);
		$setup_date_create=trim(@$_POST["setup_date_create"]);
		$setup_update=trim(@$_POST["setup_update"]);
		$setup_update=str_replace("/(<\/?)(p)([^>]*>)", "",$setup_update);
		$setup_update=str_replace("'", "'",$setup_update);
		$setup_date_update=trim(@$_POST["setup_date_update"]);
		$setup_revised=trim(@$_POST["setup_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$data["data_print"] = $this->m_akun_setup->akun_setup_print($setup_id ,$setup_periode_tahun ,$setup_periode_awal ,$setup_periode_akhir ,
																	$setup_author ,$setup_date_create ,$setup_update ,$setup_date_update ,
																	$setup_revised ,$option,$filter);
		$print_view=$this->load->view("main/p_akun_setup.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$print_file=fopen("print/akun_setup_printlist.html","w+");
		fwrite($print_file, $print_view);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function akun_setup_export_excel(){
		//POST varibale here
		$setup_id=trim(@$_POST["setup_id"]);
		$setup_periode_tahun=trim(@$_POST["setup_periode_tahun"]);
		$setup_periode_awal=trim(@$_POST["setup_periode_awal"]);
		$setup_periode_akhir=trim(@$_POST["setup_periode_akhir"]);
		$setup_author=trim(@$_POST["setup_author"]);
		$setup_author=str_replace("/(<\/?)(p)([^>]*>)", "",$setup_author);
		$setup_author=str_replace("'", "\'",$setup_author);
		$setup_date_create=trim(@$_POST["setup_date_create"]);
		$setup_update=trim(@$_POST["setup_update"]);
		$setup_update=str_replace("/(<\/?)(p)([^>]*>)", "",$setup_update);
		$setup_update=str_replace("'", "\'",$setup_update);
		$setup_date_update=trim(@$_POST["setup_date_update"]);
		$setup_revised=trim(@$_POST["setup_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_akun_setup->akun_setup_export_excel($setup_id ,$setup_periode_tahun ,$setup_periode_awal ,$setup_periode_akhir ,
															  $setup_author ,$setup_date_create ,$setup_update ,$setup_date_update ,$setup_revised ,
															  $option,$filter);
		
		to_excel($query,"akun_setup"); 
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
	
	
}
?>