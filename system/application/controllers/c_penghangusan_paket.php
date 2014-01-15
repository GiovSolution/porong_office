<?php
/* 	
	+ Module  		: Penghangusan Paket Controller
	+ Description	: For record controller process back-end
	+ Filename 		: Penghangusan Paket .php
 	+ creator 		: Fred
	
*/

//class of member_setup
class C_penghangusan_paket extends Controller {

	//constructor
	function C_penghangusan_paket(){
		parent::Controller();
		session_start();
		$this->load->model('m_penghangusan_paket', '', TRUE);
	}
	
	
	//set index
	function index(){
		$this->load->plugin('to_excel');
		$this->load->view('main/v_penghangusan_paket');
	}
	
	function laporan(){
		$this->load->view('main/v_lap_penghangusan_paket');
	}

	function print_laporan(){
		$tgl_awal=(isset($_POST['tgl_awal']) ? @$_POST['tgl_awal'] : @$_GET['tgl_awal']);
		$tgl_akhir=(isset($_POST['tgl_akhir']) ? @$_POST['tgl_akhir'] : @$_GET['tgl_akhir']);
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$opsi=(isset($_POST['opsi']) ? @$_POST['opsi'] : @$_GET['opsi']);
		$opsi_status=(isset($_POST['opsi_status']) ? @$_POST['opsi_status'] : @$_GET['opsi_status']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		$group=(isset($_POST['group']) ? @$_POST['group'] : @$_GET['group']);
		
		$data["jenis"]='Paket';
		if($periode=="all"){
			$data["periode"]="Semua Periode";
		}else if($periode=="bulan"){
			$tgl_awal=$tahun."-".$bulan;
			$data["periode"]=get_ina_month_name($bulan,'long')." ".$tahun;
		}else if($periode=="tanggal"){
			$data["periode"]="Periode : ".$tgl_awal." s/d ".$tgl_akhir.", ";
		}
		
		$data["data_print"]=$this->m_penghangusan_paket->get_laporan($tgl_awal,$tgl_akhir,$periode,$opsi,$opsi_status,$group);
			
		if($opsi=='rekap'){
			$data["opsi"]='Rekap';
			switch($group){
				case "Paket": $print_view=$this->load->view("main/p_rekap_jual_tanggal.php",$data,TRUE);break;
				case "Customer": $print_view=$this->load->view("main/p_rekap_jual_customer.php",$data,TRUE);break;
				//case "Voucher": $print_view=$this->load->view("main/p_rekap_jual_voucher.php",$data,TRUE);break;
				default: $print_view=$this->load->view("main/p_rekap_penghangusan_paket.php",$data,TRUE);break; // kelompokkan by Paket
			}
		}else{
			$data["opsi"]='Detail';
			switch($group){
				case "Tanggal": $print_view=$this->load->view("main/p_detail_jual_tanggal.php",$data,TRUE);break;
				case "Customer": $print_view=$this->load->view("main/p_detail_jual_customer.php",$data,TRUE);break;
				case "Paket": $print_view=$this->load->view("main/p_detail_jual_produk.php",$data,TRUE);break;
				case "Sales": $print_view=$this->load->view("main/p_detail_jual_sales.php",$data,TRUE);break;
				case "Jenis Diskon": $print_view=$this->load->view("main/p_detail_jual_diskon.php",$data,TRUE);break;
				default: $print_view=$this->load->view("main/p_detail_jual_semua.php",$data,TRUE);break;
			}
		}
		if(!file_exists("print")){
			mkdir("print");
		}
		if($opsi=='rekap')
			$print_file=fopen("print/report_ppaket.html","w+");
		else
			$print_file=fopen("print/report_ppaket.html","w+");
			
		fwrite($print_file, $print_view);
		echo '1'; 
	}
	
	
	function get_paket_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		//$paket_id = (integer) (isset($_POST['paket_id']) ? $_POST['paket_id'] : $_GET['paket_id']);
		$result=$this->m_penghangusan_paket->get_paket_list($query,$start,$end);
		echo $result;
	}
	
	function get_info_paket_by_paket_id(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$paket_id = (integer) (isset($_POST['paket_id']) ? $_POST['paket_id'] : $_GET['paket_id']);
		$result=$this->m_penghangusan_paket->get_info_paket_by_paket_id($query,$start,$end, $paket_id);
		echo $result;
	}
	

	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->perpanjang_paket_list();
				break;
			case "CREATE":
				$this->perpanjang_paket_create();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function perpanjang_paket_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);

		$result=$this->m_penghangusan_paket->perpanjang_paket_list($query,$start,$end);
		echo $result;
	}
	
	//function for update record
	function perpanjang_paket_create(){
		//POST variable here
		$penghangusan_id=trim(@$_POST["penghangusan_id"]);
		$penghangusan_id=str_replace("/(<\/?)(p)([^>]*>)", "",$penghangusan_id);
		$penghangusan_id=str_replace("'", '"',$penghangusan_id);
		$penghangusan_dpaket_id=trim(@$_POST["penghangusan_dpaket_id"]);
		$penghangusan_paket_id=trim(@$_POST["penghangusan_paket_id"]);
		$penghangusan_cust_id=trim(@$_POST["penghangusan_cust_id"]);
		$penghangusan_dpaket_master=trim(@$_POST["penghangusan_dpaket_master"]);
		$penghangusan_sisa_sebelum=trim(@$_POST["penghangusan_sisa_sebelum"]);
		$penghangusan_tanggal=trim(@$_POST["penghangusan_tanggal"]);
		$penghangusan_keterangan=trim(@$_POST["penghangusan_keterangan"]);
		$penghangusan_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$penghangusan_keterangan);
		$penghangusan_keterangan=str_replace("'", '"',$penghangusan_keterangan);
		$perpanjang_creator=trim(@$_POST["perpanjang_creator"]);
		$perpanjang_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$perpanjang_creator);
		$perpanjang_creator=str_replace("'", '"',$perpanjang_creator);
		$perpanjang_date_create=trim(@$_POST["perpanjang_date_create"]);
		$perpanjang_update=trim(@$_POST["perpanjang_update"]);
		$perpanjang_update=str_replace("/(<\/?)(p)([^>]*>)", "",$perpanjang_update);
		$perpanjang_update=str_replace("'", '"',$perpanjang_update);
		$perpanjang_date_update=trim(@$_POST["perpanjang_date_update"]);
		$perpanjang_revised=trim(@$_POST["perpanjang_revised"]);

		$result = $this->m_penghangusan_paket->perpanjang_paket_create($penghangusan_id, $penghangusan_dpaket_id, $penghangusan_tanggal, $penghangusan_keterangan, $perpanjang_creator, $perpanjang_date_create, $penghangusan_dpaket_master, $penghangusan_sisa_sebelum, $penghangusan_paket_id, $penghangusan_cust_id);
		echo $result;
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