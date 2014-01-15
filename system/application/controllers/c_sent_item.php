<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: sent_item Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_sent_item.php
 	+ creator  		: Natalie
 	 	+ Created on 20/Apr/2011 14:17
	
*/

//class of sent_item
class C_sent_item extends Controller {

	//constructor
	function C_sent_item(){
		parent::Controller();
		session_start();
		$this->load->model('m_sent_item', '', TRUE);
	}
	
	//set index
	function index(){
		
		$this->load->helper('asset');
		$this->load->view('main/v_sent_item');
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->sent_item_list();
				break;
			/*case "STATUS_SENT":
				$this->sent_item_status_sent();
				break;
			case "STATUS_UNSENT":
				$this->sent_item_status_unsent();
				break;
			case "STATUS_FAILED":
				$this->sent_item_status_failed();
				break;*/
			case "DELETE":
				$this->sent_item_delete();
				break;
			case "DELETE ALL":
				$this->sent_item_delete_all();
				break;
			case "SEARCH":
				$this->sent_item_search();
				break;
			case "PRINT":
				$this->sent_item_print();
				break;
			case "RESEND":
				$this->sent_item_resend();
				break;
			case "EXCEL":
				$this->sent_item_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function sent_item_list(){
		
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result=$this->m_sent_item->sent_item_list($query,$start,$end);
		echo $result;
	}
	
	//function fot list record
	function sent_item_status_sent(){
		
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result=$this->m_sent_item->sent_item_status_sent($query,$start,$end);
		echo $result;
	}
	
	//function fot list record
	function sent_item_status_unsent(){
		
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result=$this->m_sent_item->sent_item_status_unsent($query,$start,$end);
		echo $result;
	}
	
	//function fot list record
	function sent_item_status_failed(){
		
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result=$this->m_sent_item->sent_item_status_failed($query,$start,$end);
		echo $result;
	}
	
	
	//function for delete selected record
	function sent_item_delete(){
		$ids = @$_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_sent_item->sent_item_delete($pkid);
		echo $result;
	}

	function sent_item_delete_all(){
		$result=$this->m_sent_item->sent_item_delete_all();
		echo $result;
	}

	//function for advanced search
	function sent_item_search(){
		//POST varibale here
		$ID=trim(@$_POST["ID"]);
		$DestinationNumber=trim(@$_POST["DestinationNumber"]);
		$DestinationNumber=str_replace("/(<\/?)(p)([^>]*>)", "",$DestinationNumber);
		$DestinationNumber=str_replace("'", "''",$DestinationNumber);
		$TextDecoded=trim(@$_POST["TextDecoded"]);
		$TextDecoded=str_replace("/(<\/?)(p)([^>]*>)", "",$TextDecoded);
		$TextDecoded=str_replace("'", "''",$TextDecoded);
		$SendingDateTime=trim(@$_POST["SendingDateTime"]);
		$SendingDateTimeEnd=trim(@$_POST["SendingDateTimeEnd"]);
		$SendingTime=trim(@$_POST["SendingTime"]);
		$SendingTimeEnd=trim(@$_POST["SendingTimeEnd"]);
		$Status=trim(@$_POST["Status"]);
		$SendingDateTime_create=NULL;
		$SendingDateTime_update=NULL;
		$TextDecoded=htmlspecialchars($TextDecoded,ENT_QUOTES);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_sent_item->sent_item_search($ID ,$DestinationNumber ,$TextDecoded ,$SendingDateTime,$SendingDateTimeEnd,$SendingTime,$SendingTimeEnd, $Status, $start,$end);
		echo $result;
	}


	function sent_item_resend(){
  		//POST varibale here
		$ID=trim(@$_POST["ID"]);
		$DestinationNumber=trim(@$_POST["DestinationNumber"]);
		$DestinationNumber=str_replace("/(<\/?)(p)([^>]*>)", "",$DestinationNumber);
		$DestinationNumber=str_replace("'", "''",$DestinationNumber);
		$TextDecoded=trim(@$_POST["TextDecoded"]);
		$TextDecoded=str_replace("/(<\/?)(p)([^>]*>)", "",$TextDecoded);
		$TextDecoded=str_replace("'", "''",$TextDecoded);
		$SendingDateTime=trim(@$_POST["SendingDateTime"]);
		$SendingDateTimeEnd=trim(@$_POST["SendingDateTimeEnd"]);
		$SendingTime=trim(@$_POST["SendingTime"]);
		$SendingTimeEnd=trim(@$_POST["SendingTimeEnd"]);
		$Status=trim(@$_POST["Status"]);
		$SendingDateTime_create=NULL;
		$SendingDateTime_update=NULL;
		
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$result = $this->m_sent_item->sent_item_resend($ID ,$DestinationNumber ,$TextDecoded ,$SendingDateTime ,$SendingDateTimeEnd,$SendingTime,$SendingTimeEnd, $Status,$option,$filter);
		echo $result;       
	}
	/* End Of Function */
	
	function sent_item_print(){
  		//POST varibale here
		$ID=trim(@$_POST["ID"]);
		$DestinationNumber=trim(@$_POST["DestinationNumber"]);
		$DestinationNumber=str_replace("/(<\/?)(p)([^>]*>)", "",$DestinationNumber);
		$DestinationNumber=str_replace("'", "''",$DestinationNumber);
		$TextDecoded=trim(@$_POST["TextDecoded"]);
		$TextDecoded=str_replace("/(<\/?)(p)([^>]*>)", "",$TextDecoded);
		$TextDecoded=str_replace("'", "''",$TextDecoded);
		$SendingDateTime=trim(@$_POST["SendingDateTime"]);
		
		$SendingDateTime_create=NULL;
		$SendingDateTime_update=NULL;
		
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$data["data_print"] = $this->m_sent_item->sent_item_print($ID ,$DestinationNumber ,$TextDecoded ,$SendingDateTime, $option,$filter);
		$print_view=$this->load->view("main/p_sent_item.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$print_file=fopen("print/sent_item_printlist.html","w+");
		fwrite($print_file, $print_view);
		echo '1';        
	}
	/* End Of Function */
	
	/* Function to Export Excel document */
	function sent_item_export_excel(){
		//POST varibale here
		$ID=trim(@$_POST["ID"]);
		$DestinationNumber=trim(@$_POST["DestinationNumber"]);
		$DestinationNumber=str_replace("/(<\/?)(p)([^>]*>)", "",$DestinationNumber);
		$DestinationNumber=str_replace("'", "''",$DestinationNumber);
		$TextDecoded=trim(@$_POST["TextDecoded"]);
		$TextDecoded=str_replace("/(<\/?)(p)([^>]*>)", "",$TextDecoded);
		$TextDecoded=str_replace("'", "''",$TextDecoded);
		$SendingDateTime=trim(@$_POST["SendingDateTime"]);
		$SendingDateTime_create=NULL;
		$SendingDateTime_update=NULL;
		
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_sent_item->sent_item_export_excel($ID ,$DestinationNumber ,$TextDecoded ,$SendingDateTime, $option,$filter);
		
		$this->load->plugin('to_excel');
		to_excel($query,"sentitems"); 
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