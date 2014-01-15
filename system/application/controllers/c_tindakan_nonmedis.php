<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: tindakan Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_tindakan_nonmedis.php
 	+ Author  		: masongbee
 	+ Created on 22/Oct/2009 19:16:47
	
*/

//class of tindakan
class C_tindakan_nonmedis extends Controller {

	//constructor
	function C_tindakan_nonmedis(){
		parent::Controller();
		session_start();
		$this->load->model('m_tindakan_nonmedis', '', TRUE);
		
		
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_tindakan_nonmedis');
	}
	
	function laporan(){
		$this->load->view('main/v_lap_tindakan_nonmedis');
	}
	
	function print_laporan(){
		$tgl_awal=(isset($_POST['tgl_awal']) ? @$_POST['tgl_awal'] : @$_GET['tgl_awal']);
		$tgl_akhir=(isset($_POST['tgl_akhir']) ? @$_POST['tgl_akhir'] : @$_GET['tgl_akhir']);
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		//$opsi=(isset($_POST['opsi']) ? @$_POST['opsi'] : @$_GET['opsi']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		$group=(isset($_POST['group']) ? @$_POST['group'] : @$_GET['group']);
		
		if($periode=="all"){
			$data["periode"]="Semua Periode";
		}else if($periode=="bulan"){
			$tgl_awal=$tahun."-".$bulan;
			$data["periode"]=get_ina_month_name($bulan,'long')." ".$tahun;
		}else if($periode=="tanggal"){
			$date = substr($tgl_awal,8,2);
			$month = substr($tgl_awal,5,2);
			$year = substr($tgl_awal,0,4);
			$tgl_awal_show = $date.'-'.$month.'-'.$year;
			
			$date_akhir = substr($tgl_akhir,8,2);
			$month_akhir = substr($tgl_akhir,5,2);
			$year_akhir = substr($tgl_akhir,0,4);
			$tgl_akhir_show = $date_akhir.'-'.$month_akhir.'-'.$year_akhir;

			$data["periode"]="Periode : ".$tgl_awal_show." s/d ".$tgl_akhir_show.", ";
		}

		$data["data_print"]=$this->m_tindakan_nonmedis->get_laporan($tgl_awal,$tgl_akhir,$periode,$group);
		
		if(!file_exists("print")){
			mkdir("print");
		}
		
		switch($group){
			case "Tanggal": $print_view=$this->load->view("main/p_detail_tnonmedis_tanggal.php",$data,TRUE);break;
			case "Customer": $print_view=$this->load->view("main/p_detail_tnonmedis_customer.php",$data,TRUE);break;
			case "Perawatan": $print_view=$this->load->view("main/p_detail_tnonmedis_perawatan.php",$data,TRUE);break;
			case "Terapis": $print_view=$this->load->view("main/p_detail_tnonmedis_terapis.php",$data,TRUE);break;
			case "Status": $print_view=$this->load->view("main/p_detail_tnonmedis_status.php",$data,TRUE);break;
			default: $print_view=$this->load->view("main/p_detail_tnonmedis_tanggal.php",$data,TRUE);break;
		}
		
		$print_file=fopen("print/report_tindakan_nonmedis.html","w");
		fwrite($print_file, $print_view);
		fclose($print_file);
		echo '1'; 
	}
	
	function get_customer_paket_list(){
		//$apaket_id = isset($_POST['master_id']) ? $_POST['master_id'] : 0;
		$trawat_cust_id = isset($_POST['trawat_cust_id']) ? $_POST['trawat_cust_id'] : 0;
		$dtrawat_rawat_id = isset($_POST['dtrawat_rawat_id']) ? $_POST['dtrawat_rawat_id'] : 0;
		//$dapaket_paket = isset($_POST['dapaket_paket']) ? $_POST['dapaket_paket'] : 0;
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_tindakan_nonmedis->get_customer_paket_list($trawat_cust_id,$dtrawat_rawat_id,$start,$end);
		echo $result;
	}
	
	
	function get_customer_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_public_function->get_customer_list($query,$start,$end);
		echo $result;
	}
	
	function get_terapis_list(){
		//ID dokter pada tabel departemen adalah 9
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$tgl_app = isset($_POST['tgl_app']) ? $_POST['tgl_app'] : "";
		$result=$this->m_public_function->get_petugas_list($query,$tgl_app,"Therapist");
		echo $result;
	}
	
	function get_tindakan_nonmedis_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : $_GET['query'];
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_public_function->get_tindakan_nonmedis_list($query,$start,$end);
		echo $result;
	}
	
	function get_perawatan_nonmedis_list(){
		$result=$this->m_public_function->get_perawatan_nonmedis_list();
		echo $result;
	}
	
	function get_karyawan_nonmedis_list(){
		$result=$this->m_public_function->get_karyawan_nonmedis_list();
		echo $result;
	}
	
	//for detail action
	//list detail handler action
	function  detail_tindakan_detail_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_tindakan_nonmedis->detail_tindakan_detail_list($master_id,$query,$start,$end);
		echo $result;
	}
	//end of handler
	
	//purge all detail
	function detail_tindakan_nonmedis_detail_purge(){
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_tindakan_nonmedis->detail_tindakan_nonmedis_detail_purge($master_id);
	}
	//eof
	
	//get master id, note: not done yet
	function get_master_id(){
		$result=$this->m_tindakan_nonmedis->get_master_id();
		echo $result;
	}
	//
	
	//add detail
	function detail_tindakan_nonmedis_detail_insert($dtrawat_id
													,$dtrawat_master
													,$dtrawat_perawatan
													,$dtrawat_petugas2
													,$dtrawat_jam
													,$dtrawat_status
													,$dtrawat_keterangan
													,$dtrawat_cust
													,$jumlah){
		//POST variable here
		$array_dtrawat_id = json_decode(stripslashes($dtrawat_id));
		$array_dtrawat_perawatan = json_decode(stripslashes($dtrawat_perawatan));
		$array_dtrawat_petugas2 = json_decode(stripslashes($dtrawat_petugas2));
		$array_dtrawat_jam = json_decode(stripslashes($dtrawat_jam));
		$array_dtrawat_jam = json_decode(stripslashes($dtrawat_jam));
		$array_dtrawat_status = json_decode(stripslashes($dtrawat_status));
		$array_dtrawat_keterangan = json_decode(stripslashes($dtrawat_keterangan));
		$array_jumlah = json_decode(stripslashes($jumlah));
		
		$result=$this->m_tindakan_nonmedis->detail_tindakan_nonmedis_detail_insert($array_dtrawat_id
																				   ,$dtrawat_master
																				   ,$array_dtrawat_perawatan
																				   ,$array_dtrawat_petugas2
																				   ,$array_dtrawat_jam
																				   ,$array_dtrawat_status
																				   ,$array_dtrawat_keterangan
																				   ,$dtrawat_cust
																				   ,$array_jumlah);
		return $result;
	}
	
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		$mode_edit_case = '';
		$mode_edit_case = @$_POST['mode_edit'];
		switch($task){
			case "LIST":
				$this->tindakan_list();
				break;
			case "UPDATE":
				$this->tindakan_update($mode_edit_case);
				break;
			case "CREATE":
				$this->tindakan_create();
				break;
			case "DELETE":
				$this->tindakan_delete();
				break;
			case "SEARCH":
				$this->tindakan_search();
				break;
			case "PRINT":
				$this->tindakan_print();
				break;
			case "EXCEL":
				$this->tindakan_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function tindakan_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_tindakan_nonmedis->tindakan_list($query,$start,$end);
		echo $result;
	}

	//function for update record
	function tindakan_update($mode_edit_case){
		//POST variable here
		if($mode_edit_case=='update_list'){
			//Edit InLine
			$trawat_id=trim(@$_POST["trawat_id"]);
			$trawat_cust_id=trim(@$_POST["trawat_cust_id"]);
			$dtrawat_id=trim(@$_POST["dtrawat_id"]);
			$dtrawat_perawatan=trim(@$_POST["dtrawat_perawatan"]);
			$dtrawat_perawatan_id=trim(@$_POST["dtrawat_perawatan_id"]);
			$dtrawat_terapis=trim(@$_POST["dtrawat_terapis"]);
			$dtrawat_jam=trim(@$_POST["dtrawat_jam"]);
			$dtrawat_keterangan=trim(@$_POST["dtrawat_keterangan"]);
			$dtrawat_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$dtrawat_keterangan);
			$dtrawat_ambil_paket=trim(@$_POST["dtrawat_ambil_paket"]);
			$dtrawat_dpaket_id=trim(@$_POST["dtrawat_dpaket_id"]);
			$dpaket_id=trim(@$_POST["dpaket_id"]);
			$dtrawat_status=trim(@$_POST["dtrawat_status"]);
			$dtrawat_jumlah=trim(@$_POST["dtrawat_jumlah"]);
			
			$result = $this->m_tindakan_nonmedis->tindakan_update_list($trawat_id
																	,$trawat_cust_id
																  ,$dtrawat_id
																  ,$dtrawat_perawatan
																  ,$dtrawat_perawatan_id
																  ,$dtrawat_terapis
																  ,$dtrawat_jam
																  ,$dtrawat_keterangan
																  ,$dtrawat_ambil_paket
																  ,$dtrawat_dpaket_id
																  ,$dpaket_id
																  ,$dtrawat_status
																  ,$dtrawat_jumlah);
			echo $result;
		}else{
			//Edit Form
			$trawat_id=trim(@$_POST["trawat_id"]);
			$trawat_cust=trim(@$_POST["trawat_cust"]);
			$trawat_keterangan=trim(@$_POST["trawat_keterangan"]);
			$trawat_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$trawat_keterangan);
			
			//menerima POST Detail List Tindakan Non Medis
			$dtrawat_nonmedis_id = $_POST['dtrawat_nonmedis_id']; // Get our array back and translate it :
			$dtrawat_nonmedis_perawatan = $_POST['dtrawat_nonmedis_perawatan']; // Get our array back and translate it :
			$dtrawat_nonmedis_petugas2 = $_POST['dtrawat_nonmedis_petugas2']; // Get our array back and translate it :
			$dtrawat_nonmedis_jam = $_POST['dtrawat_nonmedis_jam']; // Get our array back and translate it :
			$dtrawat_nonmedis_status = $_POST['dtrawat_nonmedis_status']; // Get our array back and translate it :
			$dtrawat_nonmedis_keterangan = $_POST['dtrawat_nonmedis_keterangan']; // Get our array back and translate it :
			$nonmedis_jumlah = $_POST['nonmedis_jumlah']; // Get our array back and translate it :
			
			$result_master = $this->m_tindakan_nonmedis->tindakan_update($trawat_id ,$trawat_keterangan );
			
			if($result_master==1){
				//Proses Insert Detail List Tindakan Non Medis
				$result_nonmedis = $this->detail_tindakan_nonmedis_detail_insert($dtrawat_nonmedis_id
																				,$trawat_id
																				,$dtrawat_nonmedis_perawatan
																				,$dtrawat_nonmedis_petugas2
																				,$dtrawat_nonmedis_jam
																				,$dtrawat_nonmedis_status
																				,$dtrawat_nonmedis_keterangan
																				,$trawat_cust
																				,$nonmedis_jumlah);
				$result = $result_master + $result_nonmedis;
				echo $result;
			}else{
				echo 0;
			}
			
		}
		
		
		
		
		
		/*$trawat_cust=trim(@$_POST["trawat_cust"]);
		$trawat_keterangan=trim(@$_POST["trawat_keterangan"]);
		$trawat_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$trawat_keterangan);
		
		$trawat_cust_id=trim(@$_POST["trawat_cust_id"]);
		$dtrawat_perawatan_id=trim(@$_POST["dtrawat_perawatan_id"]);
		
		
		$rawat_harga=trim(@$_POST["rawat_harga"]);
		$rawat_du=trim(@$_POST["rawat_du"]);
		$rawat_dm=trim(@$_POST["rawat_dm"]);
		$cust_member=trim(@$_POST["cust_member"]);
		
		$dtrawat_terapis_id=trim(@$_POST["dtrawat_terapis_id"]);
		
		$dtrawat_dapp=trim(@$_POST["dtrawat_dapp"]);
		
		$dapaket_dpaket=trim(@$_POST["dapaket_dpaket"]);
		$dapaket_jpaket=trim(@$_POST["dapaket_jpaket"]);
		$dapaket_paket=trim(@$_POST["dapaket_paket"]);
		$dapaket_item=trim(@$_POST["dapaket_item"]);
		$dtrawat_jumlah=trim(@$_POST["dtrawat_jumlah"]);
		$mode_edit=trim(@$_POST["mode_edit"]);
		$result = $this->m_tindakan_nonmedis->tindakan_update($trawat_id ,$trawat_cust ,$trawat_keterangan ,$dtrawat_status ,$trawat_cust_id ,$dtrawat_perawatan_id ,$dtrawat_perawatan ,$dtrawat_id ,$rawat_harga ,$rawat_du ,$rawat_dm ,$cust_member ,$dtrawat_terapis ,$dtrawat_terapis_id ,$dtrawat_keterangan ,$dtrawat_dapp ,$dtrawat_ambil_paket ,$dapaket_dpaket ,$dapaket_jpaket ,$dapaket_paket ,$dapaket_item ,$dtrawat_jumlah ,$mode_edit);
		echo $result;*/
	}
	
	//function for create new record
	function tindakan_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$trawat_cust=trim(@$_POST["trawat_cust"]);
		$trawat_keterangan=trim(@$_POST["trawat_keterangan"]);
		$trawat_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$trawat_keterangan);
		$trawat_keterangan=str_replace("'", "''",$trawat_keterangan);
		$result=$this->m_tindakan_nonmedis->tindakan_create($trawat_cust ,$trawat_keterangan );
		echo $result;
	}

	//function for delete selected record
	function tindakan_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_tindakan_nonmedis->tindakan_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function tindakan_search(){
		//POST varibale here
		$trawat_cust=trim(@$_POST["trawat_cust"]);
		if(trim(@$_POST["trawat_tglapp_start"])!="")
			$trawat_tglapp_start=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_start"])));
		else
			$trawat_tglapp_start="";
		if(trim(@$_POST["trawat_tglapp_end"])!="")
			$trawat_tglapp_end=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_end"])));
		else
			$trawat_tglapp_end="";
		$trawat_rawat=trim(@$_POST["trawat_rawat"]);
		$trawat_terapis=trim(@$_POST["trawat_terapis"]);
		$trawat_status=trim(@$_POST["trawat_status"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_tindakan_nonmedis->tindakan_search($trawat_cust ,$trawat_tglapp_start ,$trawat_tglapp_end ,$trawat_rawat ,$trawat_terapis ,$trawat_status ,$start,$end);
		echo $result;
	}


	function tindakan_print(){
  		//POST varibale here
		$trawat_cust=trim(@$_POST["trawat_cust"]);
		if(trim(@$_POST["trawat_tglapp_start"])!="")
			$trawat_tglapp_start=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_start"])));
		else
			$trawat_tglapp_start="";
		if(trim(@$_POST["trawat_tglapp_end"])!="")
			$trawat_tglapp_end=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_end"])));
		else
			$trawat_tglapp_end="";
		$trawat_rawat=trim(@$_POST["trawat_rawat"]);
		$trawat_terapis=trim(@$_POST["trawat_terapis"]);
		$trawat_status=trim(@$_POST["trawat_status"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$data["data_print"] = $this->m_tindakan_nonmedis->tindakan_print($trawat_cust
																		,$trawat_tglapp_start
																		,$trawat_tglapp_end
																		,$trawat_rawat
																		,$trawat_terapis
																		,$trawat_status
																		,$option
																		,$filter);
		$print_view=$this->load->view("main/p_tindakan_nonmedis.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$print_file=fopen("print/tindakan_nonmedislist.html","w+");
		fwrite($print_file, $print_view);
		echo '1';
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function tindakan_export_excel(){
		//POST varibale here
		$trawat_cust=trim(@$_POST["trawat_cust"]);
		if(trim(@$_POST["trawat_tglapp_start"])!="")
			$trawat_tglapp_start=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_start"])));
		else
			$trawat_tglapp_start="";
		if(trim(@$_POST["trawat_tglapp_end"])!="")
			$trawat_tglapp_end=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_end"])));
		else
			$trawat_tglapp_end="";
		$trawat_rawat=trim(@$_POST["trawat_rawat"]);
		$trawat_terapis=trim(@$_POST["trawat_terapis"]);
		$trawat_status=trim(@$_POST["trawat_status"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_tindakan_nonmedis->tindakan_export_excel($trawat_cust
																   ,$trawat_tglapp_start
																   ,$trawat_tglapp_end
																   ,$trawat_rawat
																   ,$trawat_terapis
																   ,$trawat_status
																   ,$option
																   ,$filter);
		$this->load->plugin('to_excel');
		to_excel($query,"tindakan_nonmedis"); 
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