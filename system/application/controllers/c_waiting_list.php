<?php
/* 		
	+ Module  		: Waiting List Controller
	+ Description	: For record view
	+ Filename 		: c_waiting_list.php
 	+ Author  		: Fred
	
*/

//class of appointment
class C_waiting_list extends Controller {

	//constructor
	function C_waiting_list(){
		parent::Controller();
		session_start();
		$this->load->model('m_waiting_list', '', TRUE);
		
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_waiting_list');
	}
	
	function get_customer_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_public_function->get_customer_list($query,$start,$end);
		echo $result;
	}
	
	function get_rawat_medis_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$query = str_replace(" ", "%",$query);
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_public_function->get_rawat_medis_list($query,$start,$end);
		echo $result;
	}
	
	function get_rawat_nonmedis_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$query = str_replace(" ", "%",$query);
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_public_function->get_rawat_nonmedis_list($query,$start,$end);
		echo $result;
	}
	
	function get_dokter_list(){
		//ID dokter pada tabel departemen adalah 8
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$tgl_app = isset($_POST['tgl_app']) ? $_POST['tgl_app'] : "";
		$result=$this->m_waiting_list->get_dokter_list($query,$tgl_app,"Dokter");
		echo $result;
	}
	
	function get_terapis_list(){
		//ID dokter pada tabel departemen adalah 9
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$tgl_app = isset($_POST['tgl_app']) ? $_POST['tgl_app'] : "";
		$result=$this->m_waiting_list->get_terapis_list($query,$tgl_app,"Therapist");
		echo $result;
	}


	//event handler action
	function get_action(){
		$task = $_POST['task'];
		$mode_edit_case = @$_POST['mode_edit'];
		switch($task){
			case "LIST":
				$this->waiting_list_list();
				break;
			case "UPDATE":
				$this->waiting_list_update($mode_edit_case);
				break;
			case "CREATE":
				$this->waiting_list_create();
				break;
			case "DOWN":
				$this->waiting_list_down();
				break;
			case "UP":
				$this->waiting_list_up();
				break;
			case "SEARCH":
				$this->appointment_search();
				break;
			case "PRINT":
				$this->appointment_print();
				break;
			case "EXCEL":
				$this->appointment_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function waiting_list_list(){
		$jenis_rawat = isset($_POST['jenis_rawat']) ? $_POST['jenis_rawat'] : "";
		$tgl_app = isset($_POST['wl_tgl_app']) ? $_POST['wl_tgl_app'] : "";
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$karyawan_id = isset($_POST['karyawan_id']) ? $_POST['karyawan_id'] : "";
		$result=$this->m_waiting_list->waiting_list_list($query,$start,$end,$tgl_app,$jenis_rawat,$karyawan_id);
		echo $result;
	}

	
	function waiting_list_down(){
	
		$wl_id=trim(@$_POST["wl_id"]);
		$karyawan_id=trim(@$_POST["karyawan_id"]);
		$wl_priority=trim(@$_POST["wl_priority"]);
		$wl_date=trim(@$_POST["wl_date"]);

		
		//$wl_id = json_decode(stripslashes($wl_id));
		//$karyawan_id = json_decode(stripslashes($karyawan_id));
		//$wl_priority = json_decode(stripslashes($wl_priority));
		//$wl_date = json_decode(stripslashes($wl_date));
	
		$result=$this->m_waiting_list->waiting_list_down($wl_id,$karyawan_id, $wl_priority, $wl_date);
		echo $result;
	}
	
	function waiting_list_up(){
	
		$wl_id=trim(@$_POST["wl_id"]);
		$karyawan_id=trim(@$_POST["karyawan_id"]);
		$wl_priority=trim(@$_POST["wl_priority"]);
		$wl_date=trim(@$_POST["wl_date"]);
	
		$result=$this->m_waiting_list->waiting_list_up($wl_id,$karyawan_id, $wl_priority, $wl_date);
		echo $result;
	}
	
	
	//function for update record
	function waiting_list_update($mode_edit_case){
		//POST variable here
		if($mode_edit_case=='update_list'){
			//UPDATE db.appointment_detail selain status, dan kondisi ini bisa dipastikan status!='datang'
			$wl_id=trim(@$_POST["wl_id"]);
			$wl_date=trim(@$_POST["wl_date"]);
			$wl_keterangan=trim(@$_POST["wl_keterangan"]);
			$wl_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$wl_keterangan);
			$wl_keterangan=str_replace("'", "&#39",$wl_keterangan);
			$wl_status=trim(@$_POST["wl_status"]);
			$wl_status=str_replace("/(<\/?)(p)([^>]*>)", "",$wl_status);
			
			$wl_user=$_SESSION[SESSION_USERID];
			
			$result = $this->m_waiting_list->waiting_list_update_list($wl_id
																	,$wl_date
																	,$wl_keterangan
																	,$wl_status
																	,$wl_user);
			echo $result;
			
		}else if($mode_edit_case=='update_list_status'){
			$dapp_id=trim(@$_POST["dapp_id"]);
			$dapp_status=trim(@$_POST["dapp_status"]);
			$dapp_status=str_replace("/(<\/?)(p)([^>]*>)", "",$dapp_status);
			
			$app_user=$_SESSION[SESSION_USERID];
			
			$result = $this->m_waiting_list->waiting_list_update_list_status($dapp_id, $dapp_status, $app_user);
			echo $result;
			
		}else{
			$wl_id=trim(@$_POST["wl_id"]);
			$wl_customer=trim(@$_POST["wl_customer"]);
			$karyawan_id=trim(@$_POST["karyawan_id"]);
			$rawat_id=trim(@$_POST["rawat_id"]);
			$wl_tanggal=trim(@$_POST["wl_tanggal"]);
			$wl_keterangan=trim(@$_POST["wl_keterangan"]);
			$wl_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$wl_keterangan);
			$wl_keterangan=str_replace("'", "''",$wl_keterangan);
			
			$wl_user=$_SESSION[SESSION_USERID];
			
			$result = $this->m_waiting_list->waiting_list_update($wl_id
															   ,$wl_customer
															   ,$karyawan_id
															   ,$rawat_id
															   ,$wl_tanggal
															   ,$wl_keterangan
															   ,$wl_user);
			echo $result;
		}
	}
	
	//function for create new record
	function waiting_list_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$wl_customer=trim(@$_POST["wl_customer"]);
		$karyawan_id=trim(@$_POST["karyawan_id"]);
		$rawat_id=trim(@$_POST["rawat_id"]);
		$wl_tanggal=trim(@$_POST["wl_tanggal"]);
		$wl_keterangan=trim(@$_POST["wl_keterangan"]);
		$wl_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$wl_keterangan);
		$wl_keterangan=str_replace("'", "''",$wl_keterangan);
		
		$wl_user=$_SESSION[SESSION_USERID];
		
		$result=$this->m_waiting_list->waiting_list_create($wl_customer , $karyawan_id, $rawat_id, $wl_tanggal ,$wl_keterangan ,$wl_user);
		echo $result;
	}

	//function for delete selected record
	/*function appointment_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_waiting_list->appointment_delete($pkid);
		echo $result;
	}*/

	//function for advanced search
	function appointment_search(){
		//POST varibale here
		$app_customer=trim(@$_POST["app_customer"]);
		$app_cara=trim(@$_POST["app_cara"]);
		$app_cara=str_replace("/(<\/?)(p)([^>]*>)", "",$app_cara);
		$app_cara=str_replace("'", "''",$app_cara);
		$jenis_rawat=trim(@$_POST["jenis_rawat"]);
		$app_dokter=trim(@$_POST["app_dokter"]);
		$app_terapis=trim(@$_POST["app_terapis"]);
		$app_rawat_medis=trim(@$_POST["app_rawat_medis"]);
		$app_rawat_nonmedis=trim(@$_POST["app_rawat_nonmedis"]);
		if(trim(@$_POST["app_tgl_start_reservasi"])!="")
			$app_tgl_start_reservasi=date('Y-m-d', strtotime(trim(@$_POST["app_tgl_start_reservasi"])));
		else
			$app_tgl_start_reservasi="";
		if(trim(@$_POST["app_tgl_end_reservasi"])!="")
			$app_tgl_end_reservasi=date('Y-m-d', strtotime(trim(@$_POST["app_tgl_end_reservasi"])));
		else
			$app_tgl_end_reservasi="";
		if(trim(@$_POST["app_tgl_start_app"])!="")
			$app_tgl_start_app=date('Y-m-d', strtotime(trim(@$_POST["app_tgl_start_app"])));
		else
			$app_tgl_start_app="";
		if(trim(@$_POST["app_tgl_end_app"])!="")
			$app_tgl_end_app=date('Y-m-d', strtotime(trim(@$_POST["app_tgl_end_app"])));
		else
			$app_tgl_end_app="";
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_waiting_list->appointment_search($app_customer ,$app_cara ,$jenis_rawat, $app_dokter, $app_terapis, $app_rawat_medis, $app_rawat_nonmedis, $app_tgl_start_reservasi, $app_tgl_end_reservasi, $app_tgl_start_app, $app_tgl_end_app, $start,$end);
		echo $result;
	}


	function appointment_print(){
  		//POST varibale here
		$app_customer=trim(@$_POST["app_customer"]);
		$app_cara=trim(@$_POST["app_cara"]);
		$app_cara=str_replace("/(<\/?)(p)([^>]*>)", "",$app_cara);
		$app_cara=str_replace("'", "''",$app_cara);
		$jenis_rawat=trim(@$_POST["jenis_rawat"]);
		$app_dokter=trim(@$_POST["app_dokter"]);
		$app_terapis=trim(@$_POST["app_terapis"]);
		$app_rawat_medis=trim(@$_POST["app_rawat_medis"]);
		$app_rawat_nonmedis=trim(@$_POST["app_rawat_nonmedis"]);
		if(trim(@$_POST["app_tgl_start_reservasi"])!="")
			$app_tgl_start_reservasi=date('Y-m-d', strtotime(trim(@$_POST["app_tgl_start_reservasi"])));
		else
			$app_tgl_start_reservasi="";
		if(trim(@$_POST["app_tgl_end_reservasi"])!="")
			$app_tgl_end_reservasi=date('Y-m-d', strtotime(trim(@$_POST["app_tgl_end_reservasi"])));
		else
			$app_tgl_end_reservasi="";
		if(trim(@$_POST["app_tgl_start_app"])!="")
			$app_tgl_start_app=date('Y-m-d', strtotime(trim(@$_POST["app_tgl_start_app"])));
		else
			$app_tgl_start_app="";
		if(trim(@$_POST["app_tgl_end_app"])!="")
			$app_tgl_end_app=date('Y-m-d', strtotime(trim(@$_POST["app_tgl_end_app"])));
		else
			$app_tgl_end_app="";
		
		$tgl_app=trim(@$_POST["tgl_app"]);
		
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$data["data_print"] = $this->m_waiting_list->appointment_print($app_customer
																	,$app_cara
																	,$jenis_rawat
																	,$app_dokter
																	,$app_terapis
																	,$app_tgl_start_reservasi
																	,$app_tgl_end_reservasi
																	,$app_tgl_start_app
																	,$app_tgl_end_app
																	,$app_rawat_medis
																	,$app_rawat_nonmedis
																	,$tgl_app
																	,$option
																	,$filter);
		$print_view=$this->load->view("main/p_appointment.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$print_file=fopen("print/appointmentlist.html","w+");
		fwrite($print_file, $print_view);
		echo '1';
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function appointment_export_excel(){
		//POST varibale here
		$app_customer=trim(@$_POST["app_customer"]);
		$app_cara=trim(@$_POST["app_cara"]);
		$app_cara=str_replace("/(<\/?)(p)([^>]*>)", "",$app_cara);
		$app_cara=str_replace("'", "''",$app_cara);
		$jenis_rawat=trim(@$_POST["jenis_rawat"]);
		$app_dokter=trim(@$_POST["app_dokter"]);
		$app_terapis=trim(@$_POST["app_terapis"]);
		$app_rawat_medis=trim(@$_POST["app_rawat_medis"]);
		$app_rawat_nonmedis=trim(@$_POST["app_rawat_nonmedis"]);
		if(trim(@$_POST["app_tgl_start_reservasi"])!="")
			$app_tgl_start_reservasi=date('Y-m-d', strtotime(trim(@$_POST["app_tgl_start_reservasi"])));
		else
			$app_tgl_start_reservasi="";
		if(trim(@$_POST["app_tgl_end_reservasi"])!="")
			$app_tgl_end_reservasi=date('Y-m-d', strtotime(trim(@$_POST["app_tgl_end_reservasi"])));
		else
			$app_tgl_end_reservasi="";
		if(trim(@$_POST["app_tgl_start_app"])!="")
			$app_tgl_start_app=date('Y-m-d', strtotime(trim(@$_POST["app_tgl_start_app"])));
		else
			$app_tgl_start_app="";
		if(trim(@$_POST["app_tgl_end_app"])!="")
			$app_tgl_end_app=date('Y-m-d', strtotime(trim(@$_POST["app_tgl_end_app"])));
		else
			$app_tgl_end_app="";
		
		$tgl_app=trim(@$_POST["tgl_app"]);
		
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_waiting_list->appointment_export_excel($app_customer
																,$app_cara
																,$jenis_rawat
																,$app_dokter
																,$app_terapis
																,$app_tgl_start_reservasi
																,$app_tgl_end_reservasi
																,$app_tgl_start_app
																,$app_tgl_end_app
																,$app_rawat_medis
																,$app_rawat_nonmedis
																,$tgl_app
																,$option
																,$filter);
		$this->load->plugin('to_excel');
		to_excel($query,"appointment"); 
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