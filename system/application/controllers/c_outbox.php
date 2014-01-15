<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: outbox Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_outbox.php
 	+ creator  		: 
 	+ Created on 01/Feb/2010 14:30:05
	
*/

//class of outbox
class C_outbox extends Controller {

	//constructor
	function C_outbox(){
		parent::Controller();
		session_start();
		$this->load->model('m_outbox', '', TRUE);
	}
	
	//set index
	function index(){
		
		$this->load->helper('asset');
		$this->load->view('main/v_outbox');
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->outbox_list();
				break;
			case "STATUS_SENT":
				$this->outbox_status_sent();
				break;
			case "STATUS_UNSENT":
				$this->outbox_status_unsent();
				break;
			case "STATUS_FAILED":
				$this->outbox_status_failed();
				break;
			case "DELETE":
				$this->outbox_delete();
				break;
			case "DELETE ALL":
				$this->outbox_delete_all();
				break;
			case "SEARCH":
				$this->outbox_search();
				break;
			case "PRINT":
				$this->outbox_print();
				break;
			case "EXCEL":
				$this->outbox_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function outbox_list(){
		
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result=$this->m_outbox->outbox_list($query,$start,$end);
		echo $result;
	}
	
	//function fot list record
	function outbox_status_sent(){
		
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result=$this->m_outbox->outbox_status_sent($query,$start,$end);
		echo $result;
	}
	
	//function fot list record
	function outbox_status_unsent(){
		
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result=$this->m_outbox->outbox_status_unsent($query,$start,$end);
		echo $result;
	}
	
	//function fot list record
	function outbox_status_failed(){
		
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result=$this->m_outbox->outbox_status_failed($query,$start,$end);
		echo $result;
	}
	
	
	//function for delete selected record
	function outbox_delete(){
		$ids = @$_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_outbox->outbox_delete($pkid);
		echo $result;
	}

	function outbox_delete_all(){
		$result=$this->m_outbox->outbox_delete_all();
		echo $result;
	}

	//function for advanced search
	function outbox_search(){
		//POST varibale here
		$ID=trim(@$_POST["ID"]);
		$outbox_destination=trim(@$_POST["outbox_destination"]);
		$outbox_destination=str_replace("/(<\/?)(p)([^>]*>)", "",$outbox_destination);
		$outbox_destination=str_replace("'", "''",$outbox_destination);
		$outbox_message=trim(@$_POST["outbox_message"]);
		$outbox_message=str_replace("/(<\/?)(p)([^>]*>)", "",$outbox_message);
		$outbox_message=str_replace("'", "''",$outbox_message);
		$outbox_date=trim(@$_POST["outbox_date"]);
		$outbox_status=trim(@$_POST["outbox_status"]);
		$outbox_creator=NULL;
		$outbox_date_create=NULL;
		$outbox_update=NULL;
		$outbox_date_update=NULL;
		$outbox_revised=NULL;
		$outbox_message=htmlspecialchars($outbox_message,ENT_QUOTES);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_outbox->outbox_search($ID ,$outbox_destination ,$outbox_message ,$outbox_date , $outbox_status, $outbox_creator ,
												 $outbox_date_create ,$outbox_update ,$outbox_date_update ,$outbox_revised ,$start,$end);
		echo $result;
	}


	function outbox_print(){
  		//POST varibale here
		$ID=trim(@$_POST["ID"]);
		$outbox_destination=trim(@$_POST["outbox_destination"]);
		$outbox_destination=str_replace("/(<\/?)(p)([^>]*>)", "",$outbox_destination);
		$outbox_destination=str_replace("'", "''",$outbox_destination);
		$outbox_message=trim(@$_POST["outbox_message"]);
		$outbox_message=str_replace("/(<\/?)(p)([^>]*>)", "",$outbox_message);
		$outbox_message=str_replace("'", "''",$outbox_message);
		$outbox_date=trim(@$_POST["outbox_date"]);
		$outbox_status=trim(@$_POST["outbox_status"]);
		$outbox_creator=NULL;
		$outbox_date_create=NULL;
		$outbox_update=NULL;
		$outbox_date_update=NULL;
		$outbox_revised=NULL;
		
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$data["data_print"] = $this->m_outbox->outbox_print($ID ,$outbox_destination ,$outbox_message ,$outbox_date ,$outbox_status,
															$outbox_creator , $outbox_date_create ,$outbox_update ,$outbox_date_update ,
															$outbox_revised ,$option, $filter);
		$print_view=$this->load->view("main/p_outbox.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$print_file=fopen("print/outbox_printlist.html","w+");
		fwrite($print_file, $print_view);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function outbox_export_excel(){
		//POST varibale here
		$ID=trim(@$_POST["ID"]);
		$outbox_destination=trim(@$_POST["outbox_destination"]);
		$outbox_destination=str_replace("/(<\/?)(p)([^>]*>)", "",$outbox_destination);
		$outbox_destination=str_replace("'", "''",$outbox_destination);
		$outbox_message=trim(@$_POST["outbox_message"]);
		$outbox_message=str_replace("/(<\/?)(p)([^>]*>)", "",$outbox_message);
		$outbox_message=str_replace("'", "''",$outbox_message);
		$outbox_date=trim(@$_POST["outbox_date"]);
		$outbox_status=trim(@$_POST["outbox_status"]);
		$outbox_creator=NULL;
		$outbox_date_create=NULL;
		$outbox_update=NULL;
		$outbox_date_update=NULL;
		$outbox_revised=NULL;
		
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_outbox->outbox_export_excel($ID ,$outbox_destination ,$outbox_message ,$outbox_date,$outbox_status,$outbox_creator ,
													  $outbox_date_create ,$outbox_update ,$outbox_date_update ,$outbox_revised ,$option,$filter);
		
		$this->load->plugin('to_excel');
		to_excel($query,"outbox"); 
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