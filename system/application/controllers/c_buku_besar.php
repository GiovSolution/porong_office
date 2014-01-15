<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: buku_besar Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_buku_besar.php
 	+ creator 		: 
 	+ Created on 27/May/2010 16:40:49
	
*/

//class of buku_besar
class C_buku_besar extends Controller {

	//constructor
	function C_buku_besar(){
		parent::Controller();
		session_start();
		$this->load->model('m_buku_besar', '', TRUE);
		$this->load->plugin('to_excel');
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_buku_besar');
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->buku_besar_list();
				break;
			case "UPDATE":
				$this->buku_besar_update();
				break;
			case "CREATE":
				$this->buku_besar_create();
				break;
			case "DELETE":
				$this->buku_besar_delete();
				break;
			case "SEARCH":
				$this->buku_besar_search();
				break;
			case "PRINT":
				$this->buku_besar_print();
				break;
			case "EXCEL":
				$this->buku_besar_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function buku_besar_list(){
		
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result=$this->m_buku_besar->buku_besar_list($query,$start,$end);
		echo $result;
	}
	
	function get_akun_list(){
		
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result=$this->m_buku_besar->get_akun_list($query,$start,$end);
		echo $result;
	}
	
	//function for create new record
	function buku_besar_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$buku_tanggal=trim(@$_POST["buku_tanggal"]);
		$buku_ref=trim(@$_POST["buku_ref"]);
		$buku_ref=str_replace("/(<\/?)(p)([^>]*>)", "",$buku_ref);
		$buku_ref=str_replace("'", "''",$buku_ref);
		$buku_akun=trim(@$_POST["buku_akun"]);
		$buku_debet=trim(@$_POST["buku_debet"]);
		$buku_kredit=trim(@$_POST["buku_kredit"]);
		$buku_author=@$_SESSION[SESSION_USERID];
		$buku_date_create=date(LONG_FORMATDATE);
		//$buku_update=NULL;
		//$buku_date_update=NULL;
		//$buku_revised=0;
		$result=$this->m_buku_besar->buku_besar_create($buku_tanggal ,$buku_ref ,$buku_akun ,$buku_debet ,$buku_kredit ,$buku_author ,$buku_date_create );
		echo $result;
	}
	
	
	//function for update record
	function buku_besar_update(){
		//POST variable here
		$buku_id=trim(@$_POST["buku_id"]);
		$buku_tanggal=trim(@$_POST["buku_tanggal"]);
		$buku_ref=trim(@$_POST["buku_ref"]);
		$buku_ref=str_replace("/(<\/?)(p)([^>]*>)", "",$buku_ref);
		$buku_ref=str_replace("'", "''",$buku_ref);
		$buku_akun=trim(@$_POST["buku_akun"]);
		$buku_debet=trim(@$_POST["buku_debet"]);
		$buku_kredit=trim(@$_POST["buku_kredit"]);
		//$buku_author="buku_author";
		//$buku_date_create="buku_date_create";
		$buku_update=@$_SESSION[SESSION_USERID];
		$buku_date_update=date(LONG_FORMATDATE);
		//$buku_revised="(revised+1)";
		$result = $this->m_buku_besar->buku_besar_update($buku_id,$buku_tanggal,$buku_ref,$buku_akun,$buku_debet,$buku_kredit,$buku_update,$buku_date_update);
		echo $result;
	}
	
	//function for delete selected record
	function buku_besar_delete(){
		$ids = @$_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_buku_besar->buku_besar_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function buku_besar_search(){
		//POST varibale here
		$buku_id=trim(@$_POST["buku_id"]);
		$buku_tanggal=trim(@$_POST["buku_tanggal"]);
		$buku_tanggalEnd=trim(@$_POST["buku_tanggalEnd"]);
		$buku_akun=trim(@$_POST["buku_akun"]);
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_buku_besar->buku_besar_search($buku_akun, $buku_tanggal ,$buku_tanggalEnd ,$start,$end);
		echo $result;
	}


	function buku_besar_print(){
  		//POST varibale here
		$buku_id=trim(@$_POST["buku_id"]);
		$buku_tanggal=trim(@$_POST["buku_tanggal"]);
		$buku_tanggalEnd=trim(@$_POST["buku_tanggalEnd"]);
		$buku_akun=trim(@$_POST["buku_akun"]);
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		
		$data["periode"]="";
		if($buku_tanggal!=="")
			$data["periode"].="Tanggal ".$buku_tanggal;
		
		if($buku_tanggalEnd!=="")
			$data["periode"].=" s/d ".$buku_tanggalEnd;
			
		$data["data_print"] = $this->m_buku_besar->buku_besar_print($buku_akun, $buku_tanggal, $buku_tanggalEnd ,$start,$end );
		
		$print_view=$this->load->view("main/p_buku_besar.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$print_file=fopen("print/buku_besar_printlist.html","w+");
		fwrite($print_file, $print_view);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function buku_besar_export_excel(){
		//$this->load->plugin('to_excel');
		//POST varibale here
		/*$buku_id=trim(@$_POST["buku_id"]);
		$buku_tanggal=trim(@$_POST["buku_tanggal"]);
		$buku_tanggalEnd=trim(@$_POST["buku_tanggalEnd"]);
		$buku_akun=trim(@$_POST["buku_akun"]);
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		
		$query = $this->m_buku_besar->buku_besar_export_excel($buku_akun, $buku_tanggal, $buku_tanggalEnd ,$start,$end );
			
		to_excel($query,"buku_besar"); 
		echo '1';*/
		$buku_id=trim(@$_POST["buku_id"]);
		$buku_tanggal=trim(@$_POST["buku_tanggal"]);
		$buku_tanggalEnd=trim(@$_POST["buku_tanggalEnd"]);
		$buku_akun=trim(@$_POST["buku_akun"]);
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		
		//$data["data_print"] = $this->m_buku_besar->buku_besar_print($buku_akun, $buku_tanggal, $buku_tanggalEnd ,$start,$end );
		$query = $this->m_buku_besar->buku_besar_print($buku_akun, $buku_tanggal, $buku_tanggalEnd ,$start,$end );
		
		to_excel($query,"bukubesar");
		/*
		$data["type"]="excel";
		$print_view=$this->load->view("main/p_buku_besar.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$print_file=fopen("print/buku_besar_printlist.xls","w+");
		fwrite($print_file, $print_view);
		*/
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
	
	function convertDate ($date) {
		  $tab = explode ("-", $date);
		  $r = $tab[1]."/".$tab[2]."/".$tab[0];
		  return $r;
	}
	
	
}
?>