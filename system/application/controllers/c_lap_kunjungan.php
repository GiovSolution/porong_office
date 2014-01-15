<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	
	+ Module  		: Laporan Kunjungan Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_lap_kunjungan.php
 	+ Author  		: Freddy
	
*/

//class of tindakan
class C_lap_kunjungan extends Controller {

	//constructor
	function C_lap_kunjungan(){
		parent::Controller();
		$this->load->model('m_lap_kunjungan', '', TRUE);
		$this->load->plugin('to_excel');
	}

	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_lap_kunjungan');
	}


	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->lap_kunjungan_list();
				break;
			case "LIST2":
				$this->lap_kunjungan_non_list();
				break;
			case "LIST3":
				$this->lap_average_list();
				break;
			case "GET":
				$this->get_daftar_customer();
				break;
			/*case "UPDATE":
				$this->report_tindakan_update();
				break;
			case "CREATE":
				$this->report_tindakan_create();
				break;
			case "DELETE":
				$this->report_tindakan_delete();
				break;*/
			case "DELETEDETAIL":
				$this->detail_kunjungan_delete();
				break;
			case "SEARCH":
				$this->lap_kunjungan_search();
				break;
			case "SEARCH2":
				$this->lap_kunjungan_search2();
				break;
			case "SEARCH3":
				$this->lap_kunjungan_search3();
				break;
			case "PRINT":
				$this->lap_kunjungan_print();
				break;
			case "PRINT2":
				$this->detail_kunjungan_print();
				break;
			case "EXCEL":
				$this->lap_kunjungan_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function lap_kunjungan_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_lap_kunjungan->lap_kunjungan_list($query,$start,$end);
		echo $result;
	}
	
	//function fot list record
	function lap_kunjungan_non_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_lap_kunjungan->lap_kunjungan_non_list($query,$start,$end);
		echo $result;
	}
	
	function lap_average_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_lap_kunjungan->lap_average_list($query,$start,$end);
		echo $result;
	}
	
	function detail_kunjungan_print(){
  		//POST varibale here
		$tgl_tindakan=trim(@$_POST["tgl_tindakan"]);
		
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		$tgl_awal=$tahun."-".$bulan;
		
		$lap_kunjungan_id=trim(@$_POST["lap_kunjungan_id"]);
		if(trim(@$_POST["trawat_tglapp_start"])!="")
			$trawat_tglapp_start=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_start"])));
		else
			$trawat_tglapp_start="";
		if(trim(@$_POST["trawat_tglapp_end"])!="")
			$trawat_tglapp_end=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_end"])));
		else
			$trawat_tglapp_end="";
			
		$lap_kunjungan_kelamin=trim(@$_POST["lap_kunjungan_kelamin"]);
		$lap_kunjungan_kelamin=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_kelamin);
		$lap_kunjungan_kelamin=str_replace("'", '"',$lap_kunjungan_kelamin);
		$lap_kunjungan_member=trim(@$_POST["lap_kunjungan_member"]);
		$lap_kunjungan_member=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_member);
		$lap_kunjungan_member=str_replace("'", '"',$lap_kunjungan_member);
		$lap_kunjungan_cust=trim(@$_POST["lap_kunjungan_cust"]);
		$lap_kunjungan_cust=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_cust);
		$lap_kunjungan_cust=str_replace("'", '"',$lap_kunjungan_cust);
		$lap_kunjungan_umurstart=trim(@$_POST["lap_kunjungan_umurstart"]);
		$lap_kunjungan_umurstart=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_umurstart);
		$lap_kunjungan_umurstart=str_replace("'", '"',$lap_kunjungan_umurstart);
		$lap_kunjungan_umurend=trim(@$_POST["lap_kunjungan_umurend"]);
		$lap_kunjungan_umurend=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_umurend);
		$lap_kunjungan_umurend=str_replace("'", '"',$lap_kunjungan_umurend);
		$lap_kunjungan_tgllahir =(isset($_POST['lap_kunjungan_tgllahir']) ? @$_POST['lap_kunjungan_tgllahir'] : @$_GET['lap_kunjungan_tgllahir']);
		$lap_kunjungan_tgllahirend =(isset($_POST['lap_kunjungan_tgllahirend']) ? @$_POST['lap_kunjungan_tgllahirend'] : @$_GET['lap_kunjungan_tgllahirend']);
		$lap_kunjungan_tgllahirend=trim(@$_POST["lap_kunjungan_tgllahirend"]);

		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$data["periode"]="$tgl_tindakan";
		$data["data_print"] = $this->m_lap_kunjungan->detail_kunjungan_print($tgl_awal,$periode,$lap_kunjungan_id ,$lap_kunjungan_tgllahir, $lap_kunjungan_tgllahirend,$lap_kunjungan_umurstart, $lap_kunjungan_umurend,$trawat_tglapp_start ,$trawat_tglapp_end ,$lap_kunjungan_kelamin, $lap_kunjungan_member,$lap_kunjungan_cust, $tgl_tindakan,$option,$filter);
		$print_view=$this->load->view("main/p_detail_kunjungan.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$print_file=fopen("print/detail_kunjungan_list.html","w+");
		fwrite($print_file, $print_view);
		echo '1';
	}
	/* End Of Function */


	//function for advanced search
	function lap_kunjungan_search(){
		//POST varibale here
		$lap_kunjungan_id=trim(@$_POST["lap_kunjungan_id"]);
		if(trim(@$_POST["trawat_tglapp_start"])!="")
			$trawat_tglapp_start=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_start"])));
		else
			$trawat_tglapp_start="";
		if(trim(@$_POST["trawat_tglapp_end"])!="")
			$trawat_tglapp_end=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_end"])));
		else
			$trawat_tglapp_end="";
			
		$lap_kunjungan_kelamin=trim(@$_POST["lap_kunjungan_kelamin"]);
		$lap_kunjungan_kelamin=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_kelamin);
		$lap_kunjungan_kelamin=str_replace("'", '"',$lap_kunjungan_kelamin);
		$lap_kunjungan_member=trim(@$_POST["lap_kunjungan_member"]);
		$lap_kunjungan_member=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_member);
		$lap_kunjungan_member=str_replace("'", '"',$lap_kunjungan_member);
		$lap_kunjungan_cust=trim(@$_POST["lap_kunjungan_cust"]);
		$lap_kunjungan_cust=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_cust);
		$lap_kunjungan_cust=str_replace("'", '"',$lap_kunjungan_cust);
		$lap_kunjungan_umurstart=trim(@$_POST["lap_kunjungan_umurstart"]);
		$lap_kunjungan_umurstart=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_umurstart);
		$lap_kunjungan_umurstart=str_replace("'", '"',$lap_kunjungan_umurstart);
		$lap_kunjungan_umurend=trim(@$_POST["lap_kunjungan_umurend"]);
		$lap_kunjungan_umurend=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_umurend);
		$lap_kunjungan_umurend=str_replace("'", '"',$lap_kunjungan_umurend);
		$lap_kunjungan_tgllahir =(isset($_POST['lap_kunjungan_tgllahir']) ? @$_POST['lap_kunjungan_tgllahir'] : @$_GET['lap_kunjungan_tgllahir']);
		$lap_kunjungan_tgllahirend =(isset($_POST['lap_kunjungan_tgllahirend']) ? @$_POST['lap_kunjungan_tgllahirend'] : @$_GET['lap_kunjungan_tgllahirend']);
		$lap_kunjungan_tgllahirend=trim(@$_POST["lap_kunjungan_tgllahirend"]);
		
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		
		
		$tgl_awal=$tahun."-".$bulan;
		
		//$trawat_dokter=trim(@$_POST["trawat_dokter"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_lap_kunjungan->lap_kunjungan_search($tgl_awal,$periode,$lap_kunjungan_id ,$lap_kunjungan_tgllahir, $lap_kunjungan_tgllahirend,$lap_kunjungan_umurstart, $lap_kunjungan_umurend,$trawat_tglapp_start ,$trawat_tglapp_end ,$lap_kunjungan_kelamin, $lap_kunjungan_member,$lap_kunjungan_cust, $start,$end);
		echo $result;
	}

	function get_daftar_customer(){
		$tgl_tindakan=trim(@$_POST["tgl_tindakan"]);
		
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		$tgl_awal=$tahun."-".$bulan;
		
		$lap_kunjungan_id=trim(@$_POST["lap_kunjungan_id"]);
		if(trim(@$_POST["trawat_tglapp_start"])!="")
			$trawat_tglapp_start=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_start"])));
		else
			$trawat_tglapp_start="";
		if(trim(@$_POST["trawat_tglapp_end"])!="")
			$trawat_tglapp_end=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_end"])));
		else
			$trawat_tglapp_end="";
			
		$lap_kunjungan_kelamin=trim(@$_POST["lap_kunjungan_kelamin"]);
		$lap_kunjungan_kelamin=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_kelamin);
		$lap_kunjungan_kelamin=str_replace("'", '"',$lap_kunjungan_kelamin);
		$lap_kunjungan_member=trim(@$_POST["lap_kunjungan_member"]);
		$lap_kunjungan_member=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_member);
		$lap_kunjungan_member=str_replace("'", '"',$lap_kunjungan_member);
		$lap_kunjungan_cust=trim(@$_POST["lap_kunjungan_cust"]);
		$lap_kunjungan_cust=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_cust);
		$lap_kunjungan_cust=str_replace("'", '"',$lap_kunjungan_cust);
		$lap_kunjungan_umurstart=trim(@$_POST["lap_kunjungan_umurstart"]);
		$lap_kunjungan_umurstart=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_umurstart);
		$lap_kunjungan_umurstart=str_replace("'", '"',$lap_kunjungan_umurstart);
		$lap_kunjungan_umurend=trim(@$_POST["lap_kunjungan_umurend"]);
		$lap_kunjungan_umurend=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_umurend);
		$lap_kunjungan_umurend=str_replace("'", '"',$lap_kunjungan_umurend);
		$lap_kunjungan_tgllahir =(isset($_POST['lap_kunjungan_tgllahir']) ? @$_POST['lap_kunjungan_tgllahir'] : @$_GET['lap_kunjungan_tgllahir']);
		$lap_kunjungan_tgllahirend =(isset($_POST['lap_kunjungan_tgllahirend']) ? @$_POST['lap_kunjungan_tgllahirend'] : @$_GET['lap_kunjungan_tgllahirend']);
		$lap_kunjungan_tgllahirend=trim(@$_POST["lap_kunjungan_tgllahirend"]);
		
		//$dpaket_paket = isset($_POST['dpaket_paket']) ? $_POST['dpaket_paket'] : 0;*/
		//$dapaket_dpaket = isset($_POST['dapaket_dpaket']) ? $_POST['dapaket_dpaket'] : 0;
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_lap_kunjungan->get_daftar_customer($tgl_awal,$periode,$lap_kunjungan_id ,$lap_kunjungan_tgllahir, $lap_kunjungan_tgllahirend,$lap_kunjungan_umurstart, $lap_kunjungan_umurend,$trawat_tglapp_start ,$trawat_tglapp_end ,$lap_kunjungan_kelamin, $lap_kunjungan_member,$lap_kunjungan_cust, $tgl_tindakan,$start,$end);
		echo $result;
	}
	
	function lap_kunjungan_search2(){
		//POST varibale here
		$lap_kunjungan_id=trim(@$_POST["lap_kunjungan_id"]);
		if(trim(@$_POST["trawat_tglapp_start"])!="")
			$trawat_tglapp_start=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_start"])));
		else
			$trawat_tglapp_start="";
		if(trim(@$_POST["trawat_tglapp_end"])!="")
			$trawat_tglapp_end=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_end"])));
		else
			$trawat_tglapp_end="";

		$lap_kunjungan_kelamin=trim(@$_POST["lap_kunjungan_kelamin"]);
		$lap_kunjungan_kelamin=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_kelamin);
		$lap_kunjungan_kelamin=str_replace("'", '"',$lap_kunjungan_kelamin);
		$lap_kunjungan_member=trim(@$_POST["lap_kunjungan_member"]);
		$lap_kunjungan_member=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_member);
		$lap_kunjungan_member=str_replace("'", '"',$lap_kunjungan_member);
		$lap_kunjungan_cust=trim(@$_POST["lap_kunjungan_cust"]);
		$lap_kunjungan_cust=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_cust);
		$lap_kunjungan_cust=str_replace("'", '"',$lap_kunjungan_cust);
		$trawat_dokter=trim(@$_POST["trawat_dokter"]);
		$lap_kunjungan_umurstart=trim(@$_POST["lap_kunjungan_umurstart"]);
		$lap_kunjungan_umurstart=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_umurstart);
		$lap_kunjungan_umurstart=str_replace("'", '"',$lap_kunjungan_umurstart);
		$lap_kunjungan_umurend=trim(@$_POST["lap_kunjungan_umurend"]);
		$lap_kunjungan_umurend=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_umurend);
		$lap_kunjungan_umurend=str_replace("'", '"',$lap_kunjungan_umurend);
		$lap_kunjungan_tgllahir =(isset($_POST['lap_kunjungan_tgllahir']) ? @$_POST['lap_kunjungan_tgllahir'] : @$_GET['lap_kunjungan_tgllahir']);
		$lap_kunjungan_tgllahirend =(isset($_POST['lap_kunjungan_tgllahirend']) ? @$_POST['lap_kunjungan_tgllahirend'] : @$_GET['lap_kunjungan_tgllahirend']);
		$lap_kunjungan_tgllahirend=trim(@$_POST["lap_kunjungan_tgllahirend"]);
		
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		
		
		$tgl_awal=$tahun."-".$bulan;
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_lap_kunjungan->lap_kunjungan_search2($tgl_awal,$periode,$lap_kunjungan_id ,$lap_kunjungan_tgllahir, $lap_kunjungan_tgllahirend,$lap_kunjungan_umurstart, $lap_kunjungan_umurend ,$trawat_tglapp_start ,$trawat_tglapp_end ,$lap_kunjungan_kelamin, $lap_kunjungan_member,$lap_kunjungan_cust, $start,$end);
		echo $result;
	}
	
	function lap_kunjungan_search3(){
		//POST varibale here
		$lap_kunjungan_id=trim(@$_POST["lap_kunjungan_id"]);
		if(trim(@$_POST["trawat_tglapp_start"])!="")
			$trawat_tglapp_start=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_start"])));
		else
			$trawat_tglapp_start="";
		if(trim(@$_POST["trawat_tglapp_end"])!="")
			$trawat_tglapp_end=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_end"])));
		else
			$trawat_tglapp_end="";

		$lap_kunjungan_kelamin=trim(@$_POST["lap_kunjungan_kelamin"]);
		$lap_kunjungan_kelamin=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_kelamin);
		$lap_kunjungan_kelamin=str_replace("'", '"',$lap_kunjungan_kelamin);
		$lap_kunjungan_member=trim(@$_POST["lap_kunjungan_member"]);
		$lap_kunjungan_member=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_member);
		$lap_kunjungan_member=str_replace("'", '"',$lap_kunjungan_member);
		$lap_kunjungan_cust=trim(@$_POST["lap_kunjungan_cust"]);
		$lap_kunjungan_cust=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_cust);
		$lap_kunjungan_cust=str_replace("'", '"',$lap_kunjungan_cust);
		$trawat_dokter=trim(@$_POST["trawat_dokter"]);
		$lap_kunjungan_umurstart=trim(@$_POST["lap_kunjungan_umurstart"]);
		$lap_kunjungan_umurstart=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_umurstart);
		$lap_kunjungan_umurstart=str_replace("'", '"',$lap_kunjungan_umurstart);
		$lap_kunjungan_umurend=trim(@$_POST["lap_kunjungan_umurend"]);
		$lap_kunjungan_umurend=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_umurend);
		$lap_kunjungan_umurend=str_replace("'", '"',$lap_kunjungan_umurend);
		$lap_kunjungan_tgllahir =(isset($_POST['lap_kunjungan_tgllahir']) ? @$_POST['lap_kunjungan_tgllahir'] : @$_GET['lap_kunjungan_tgllahir']);
		$lap_kunjungan_tgllahirend =(isset($_POST['lap_kunjungan_tgllahirend']) ? @$_POST['lap_kunjungan_tgllahirend'] : @$_GET['lap_kunjungan_tgllahirend']);
		$lap_kunjungan_tgllahirend=trim(@$_POST["lap_kunjungan_tgllahirend"]);
		
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		
		
		$tgl_awal=$tahun."-".$bulan;
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_lap_kunjungan->lap_kunjungan_search3($tgl_awal,$periode,$lap_kunjungan_id ,$lap_kunjungan_tgllahir, $lap_kunjungan_tgllahirend,$lap_kunjungan_umurstart, $lap_kunjungan_umurend ,$trawat_tglapp_start ,$trawat_tglapp_end ,$lap_kunjungan_kelamin, $lap_kunjungan_member,$lap_kunjungan_cust, $start,$end);
		echo $result;
	}
	
	
	function lap_kunjungan_print(){
  		//POST varibale here
		$lap_kunjungan_id=trim(@$_POST["lap_kunjungan_id"]);
		if(trim(@$_POST["trawat_tglapp_start"])!="")
			$trawat_tglapp_start=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_start"])));
		else
			$trawat_tglapp_start="";
		if(trim(@$_POST["trawat_tglapp_end"])!="")
			$trawat_tglapp_end=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_end"])));
		else
			$trawat_tglapp_end="";
			
		$lap_kunjungan_kelamin=trim(@$_POST["lap_kunjungan_kelamin"]);
		$lap_kunjungan_kelamin=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_kelamin);
		$lap_kunjungan_kelamin=str_replace("'", '"',$lap_kunjungan_kelamin);
		$lap_kunjungan_member=trim(@$_POST["lap_kunjungan_member"]);
		$lap_kunjungan_member=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_member);
		$lap_kunjungan_member=str_replace("'", '"',$lap_kunjungan_member);
		$lap_kunjungan_cust=trim(@$_POST["lap_kunjungan_cust"]);
		$lap_kunjungan_cust=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_cust);
		$lap_kunjungan_cust=str_replace("'", '"',$lap_kunjungan_cust);
		$lap_kunjungan_umurstart=trim(@$_POST["lap_kunjungan_umurstart"]);
		$lap_kunjungan_umurstart=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_umurstart);
		$lap_kunjungan_umurstart=str_replace("'", '"',$lap_kunjungan_umurstart);
		$lap_kunjungan_umurend=trim(@$_POST["lap_kunjungan_umurend"]);
		$lap_kunjungan_umurend=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_umurend);
		$lap_kunjungan_umurend=str_replace("'", '"',$lap_kunjungan_umurend);
		$lap_kunjungan_tgllahir =(isset($_POST['lap_kunjungan_tgllahir']) ? @$_POST['lap_kunjungan_tgllahir'] : @$_GET['lap_kunjungan_tgllahir']);
		$lap_kunjungan_tgllahirend =(isset($_POST['lap_kunjungan_tgllahirend']) ? @$_POST['lap_kunjungan_tgllahirend'] : @$_GET['lap_kunjungan_tgllahirend']);
		$lap_kunjungan_tgllahirend=trim(@$_POST["lap_kunjungan_tgllahirend"]);
		
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		
		$tgl_awal=$tahun."-".$bulan;
		
		if($periode == 'Bulan'){
			$periode_print = $periode." (".$tgl_awal.")";
		}else{
			$periode_print = $periode." (".$trawat_tglapp_start." s/d ".$trawat_tglapp_end.")";
		}
		
		if($lap_kunjungan_kelamin == 'S'){
			$jeniskel_print = "Semua";
		}else if($lap_kunjungan_kelamin == 'L'){
			$jeniskel_print = "Laki-laki";
		}else if($lap_kunjungan_kelamin == 'P'){
			$jeniskel_print = "Perempuan";
		}else{
		
		}
		
		if($lap_kunjungan_member == 'Semua'){
			$member_print = "Semua";
		}else if($lap_kunjungan_member == 'Baru'){
			$member_print = "Baru";
		}else if($lap_kunjungan_member == 'Lama'){
			$member_print = "Lama";
		}else{
			$member_print = "Non Member";
		}
		
		if($lap_kunjungan_cust == 'Semua'){
			$cust_print = "Semua";
		}else if($lap_kunjungan_cust == 'Baru'){
			$cust_print = "Baru";
		}else{
			$cust_print = "Lama";
		}
		
		if($lap_kunjungan_tgllahir == "" || $lap_kunjungan_tgllahirend == ""){
			$tgllahir_print = "antara - s/d -";
		}else{		
			$tgllahir_print = "antara ".$lap_kunjungan_tgllahir." s/d ".$lap_kunjungan_tgllahirend;
		}
		
		if($lap_kunjungan_umurstart == "" || $lap_kunjungan_umurend == ""){
			$umur_print = "antara - s/d -";
		}else{		
			$umur_print = "antara ".$lap_kunjungan_umurstart." tahun s/d ".$lap_kunjungan_umurend." tahun";
		}
		
		
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		
		
		$result = $this->m_lap_kunjungan->lap_kunjungan_print($tgl_awal,$periode,$lap_kunjungan_id ,$lap_kunjungan_tgllahir, $lap_kunjungan_tgllahirend,$lap_kunjungan_umurstart, $lap_kunjungan_umurend,$trawat_tglapp_start ,$trawat_tglapp_end ,$lap_kunjungan_kelamin, $lap_kunjungan_member,$lap_kunjungan_cust, $start,$end);
		$nbrows=$result->num_rows();
		$totcolumn=7;
		$tot_medis=0;
		$tot_surgery=0;
		$tot_anti=0;
		$tot_nonmedis=0;
		$tot_produk=0;
		$tot_total=0;
		
   		/* We now have our array, let's build our HTML file */
		$file = fopen("kunjunganlist.html",'w');
		fwrite($file, "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Printing the Kunjungan Grid</title><link rel='stylesheet' type='text/css' href='assets/modules/main/css/printstyle.css'/></head>");
		fwrite($file, "<body onload='window.print()'><table summary='Kunjungan List'><caption>Laporan Jumlah Kunjungan <br> Periode : $periode_print <br> Jenis Kelamin : $jeniskel_print <br> Member : $member_print | Customer : $cust_print <br> Tgl Lahir : $tgllahir_print | Umur : $umur_print</caption><thead><tr><th scope='col'>Tanggal</th><th scope='col'>Medis</th><th scope='col'>Surgery</th><th scope='col'>Anti Aging</th><th scope='col'>Non Medis</th><th scope='col'>Produk</th><th scope='col'>Total</th></tr></thead>");

		$i=0;
		if($nbrows>0){
			foreach($result->result_array() as $data){
				fwrite($file,'<tr');
				/*if($i%1==0){
					fwrite($file," class='odd'");
				}*/
			
				fwrite($file, "><th scope='row' id='r97'>");
				fwrite($file, $data['tgl_tindakan']);
				fwrite($file,"</th><td align='right' class='numeric'>");
				fwrite($file, $data['Medis']);
				fwrite($file,"</td><td align='right' class='numeric'>");
				fwrite($file, $data['Surgery']);
				fwrite($file, "</td><td align='right' class='numeric'>");
				fwrite($file, $data['Anti_Aging']);
				fwrite($file, "</td><td align='right' class='numeric'>");
				fwrite($file, $data['Non_Medis']);
				fwrite($file, "</td><td align='right' class='numeric'>");
				fwrite($file, $data['Produk']);
				fwrite($file, "</td><td align='right' class='numeric'>");
				fwrite($file, $data['Total']);
				fwrite($file, "</td></tr>");
				
			$tot_medis+= $data['Medis'];
			$tot_surgery+= $data['Surgery'];
			$tot_anti+= $data['Anti_Aging'];
			$tot_nonmedis+= $data['Non_Medis'];
			$tot_produk+= $data['Produk'];
			$tot_total+= $data['Total'];
			
			$avg_medis= round(($tot_medis / $nbrows),2);
			$avg_surgery= round(($tot_surgery / $nbrows),2);
			$avg_anti= round(($tot_anti / $nbrows),2);
			$avg_nonmedis= round(($tot_nonmedis / $nbrows),2);
			$avg_produk= round(($tot_produk / $nbrows),2);
			$avg_total= round(($tot_total / $nbrows),2);
			}

		}
		fwrite($file, "<tfoot><tr><th scope='row'>Total</th><td width='70px' align='right' class='numeric'>$tot_medis</td><td width='70px' align='right' class='numeric'>$tot_surgery</td><td width='70px' align='right' class='numeric'>$tot_anti</td><td width='70px' align='right' class='numeric'>$tot_nonmedis</td><td align='right' class='numeric'>$tot_produk</td><td align='right' class='numeric'>$tot_total</td></tr>
		<tr><th scope='row'>Avg</th><td width='70px' align='right' class='numeric'>$avg_medis</td><td width='70px' align='right' class='numeric'>$avg_surgery</td><td width='70px' align='right' class='numeric'>$avg_anti</td><td width='70px' align='right' class='numeric'>$avg_nonmedis</td><td width='70px' align='right' class='numeric'>$avg_produk</td><td width='70px' align='right' class='numeric'>$avg_total</td></tr>
		</tfoot><tbody></tbody></table></body></html>");	
		fclose($file);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function lap_kunjungan_export_excel(){
		//POST varibale here
				//POST varibale here
		$lap_kunjungan_id=trim(@$_POST["lap_kunjungan_id"]);
		if(trim(@$_POST["trawat_tglapp_start"])!="")
			$trawat_tglapp_start=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_start"])));
		else
			$trawat_tglapp_start="";
		if(trim(@$_POST["trawat_tglapp_end"])!="")
			$trawat_tglapp_end=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_end"])));
		else
			$trawat_tglapp_end="";
			
		$lap_kunjungan_kelamin=trim(@$_POST["lap_kunjungan_kelamin"]);
		$lap_kunjungan_kelamin=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_kelamin);
		$lap_kunjungan_kelamin=str_replace("'", '"',$lap_kunjungan_kelamin);
		$lap_kunjungan_member=trim(@$_POST["lap_kunjungan_member"]);
		$lap_kunjungan_member=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_member);
		$lap_kunjungan_member=str_replace("'", '"',$lap_kunjungan_member);
		$lap_kunjungan_cust=trim(@$_POST["lap_kunjungan_cust"]);
		$lap_kunjungan_cust=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_cust);
		$lap_kunjungan_cust=str_replace("'", '"',$lap_kunjungan_cust);
		$lap_kunjungan_umurstart=trim(@$_POST["lap_kunjungan_umurstart"]);
		$lap_kunjungan_umurstart=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_umurstart);
		$lap_kunjungan_umurstart=str_replace("'", '"',$lap_kunjungan_umurstart);
		$lap_kunjungan_umurend=trim(@$_POST["lap_kunjungan_umurend"]);
		$lap_kunjungan_umurend=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_umurend);
		$lap_kunjungan_umurend=str_replace("'", '"',$lap_kunjungan_umurend);
		$lap_kunjungan_tgllahir =(isset($_POST['lap_kunjungan_tgllahir']) ? @$_POST['lap_kunjungan_tgllahir'] : @$_GET['lap_kunjungan_tgllahir']);
		$lap_kunjungan_tgllahirend =(isset($_POST['lap_kunjungan_tgllahirend']) ? @$_POST['lap_kunjungan_tgllahirend'] : @$_GET['lap_kunjungan_tgllahirend']);
		$lap_kunjungan_tgllahirend=trim(@$_POST["lap_kunjungan_tgllahirend"]);
		
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		
		$tgl_awal=$tahun."-".$bulan;
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		
		$query = $this->m_lap_kunjungan->lap_kunjungan_export_excel($tgl_awal,$periode,$lap_kunjungan_id ,$lap_kunjungan_tgllahir, $lap_kunjungan_tgllahirend,$lap_kunjungan_umurstart, $lap_kunjungan_umurend,$trawat_tglapp_start ,$trawat_tglapp_end ,$lap_kunjungan_kelamin, $lap_kunjungan_member,$lap_kunjungan_cust, $start,$end);
		
		to_excel($query,"kunjungan"); 
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