<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	
	+ Module  		: Laporan Kunjungan Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_lap_waktu_tunggu.php
 	+ Author  		: Natalie
	
*/

//class of tindakan
class C_lap_waktu_tunggu extends Controller {

	//constructor
	function C_lap_waktu_tunggu(){
		parent::Controller();
		$this->load->model('m_lap_waktu_tunggu', '', TRUE);
		$this->load->plugin('to_excel');
	}

	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_lap_waktu_tunggu');
	}


	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->lap_waktu_tunggu_list();
				break;
			case "LIST2":
				$this->lap_waktu_tunggu_list2();
				break;
			case "GET":
				$this->get_daftar_customer();
				break;
			case "SEARCH":
				$this->lap_waktu_tunggu_search();
				break;
			case "SEARCH2":
				$this->lap_waktu_tunggu_average_search();
				break;
			case "PRINT":
				$this->lap_waktu_tunggu_print();
				break;
			case "EXCEL":
				$this->lap_lunjungan_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function lap_waktu_tunggu_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_lap_waktu_tunggu->lap_waktu_tunggu_list($query,$start,$end);
		echo $result;
	}	
	
	function lap_waktu_tunggu_list2(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_lap_waktu_tunggu->lap_waktu_tunggu_list2($query,$start,$end);
		echo $result;
	}

	function lap_waktu_tunggu_average_search(){
		$lap_waktu_tunggu_id=trim(@$_POST["lap_waktu_tunggu_id"]);
		if(trim(@$_POST["tgl_start"])!="")
			$tgl_start=date('Y-m-d', strtotime(trim(@$_POST["tgl_start"])));
		else
			$tgl_start="";
		if(trim(@$_POST["tgl_end"])!="")
			$tgl_end=date('Y-m-d', strtotime(trim(@$_POST["tgl_end"])));
		else
			$tgl_end="";
			
		$groupby=trim(@$_POST["groupby"]);
		$groupby=str_replace("/(<\/?)(p)([^>]*>)", "",$groupby);
		$groupby=str_replace("'", '"',$groupby);
		
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		$menit=(isset($_POST['menit']) ? @$_POST['menit'] : @$_GET['menit']);

		$tgl_awal=$tahun."-".$bulan;
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_lap_waktu_tunggu->lap_waktu_tunggu_average_search($menit,$tgl_awal,$periode,$lap_waktu_tunggu_id ,$tgl_start ,$tgl_end ,$groupby, $start,$end);
		echo $result;
	}
	
	//function for advanced search
	function lap_waktu_tunggu_search(){
		//POST varibale here
		$lap_waktu_tunggu_id=trim(@$_POST["lap_waktu_tunggu_id"]);
		if(trim(@$_POST["tgl_start"])!="")
			$tgl_start=date('Y-m-d', strtotime(trim(@$_POST["tgl_start"])));
		else
			$tgl_start="";
		if(trim(@$_POST["tgl_end"])!="")
			$tgl_end=date('Y-m-d', strtotime(trim(@$_POST["tgl_end"])));
		else
			$tgl_end="";
			
		$groupby=trim(@$_POST["groupby"]);
		$groupby=str_replace("/(<\/?)(p)([^>]*>)", "",$groupby);
		$groupby=str_replace("'", '"',$groupby);
		
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		$menit=(isset($_POST['menit']) ? @$_POST['menit'] : @$_GET['menit']);

		$tgl_awal=$tahun."-".$bulan;
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_lap_waktu_tunggu->lap_waktu_tunggu_search($menit,$tgl_awal,$periode,$lap_waktu_tunggu_id ,$tgl_start ,$tgl_end ,$groupby, $start,$end);
		echo $result;
	}

	function get_daftar_customer(){
		$tgl_tindakan=trim(@$_POST["tgl_tindakan"]);
		
		$lap_waktu_tunggu_id=trim(@$_POST["lap_waktu_tunggu_id"]);
		if(trim(@$_POST["tgl_start"])!="")
			$tgl_start=date('Y-m-d', strtotime(trim(@$_POST["tgl_start"])));
		else
			$tgl_start="";
		if(trim(@$_POST["tgl_end"])!="")
			$tgl_end=date('Y-m-d', strtotime(trim(@$_POST["tgl_end"])));
		else
			$tgl_end="";
			
		$lap_waktu_tunggu_kelamin=trim(@$_POST["lap_waktu_tunggu_kelamin"]);
		$lap_waktu_tunggu_kelamin=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_waktu_tunggu_kelamin);
		$lap_waktu_tunggu_kelamin=str_replace("'", '"',$lap_waktu_tunggu_kelamin);
		$lap_waktu_tunggu_member=trim(@$_POST["lap_waktu_tunggu_member"]);
		$lap_waktu_tunggu_member=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_waktu_tunggu_member);
		$lap_waktu_tunggu_member=str_replace("'", '"',$lap_waktu_tunggu_member);
		$groupby=trim(@$_POST["groupby"]);
		$groupby=str_replace("/(<\/?)(p)([^>]*>)", "",$groupby);
		$groupby=str_replace("'", '"',$groupby);
		$lap_waktu_tunggu_umurstart=trim(@$_POST["lap_waktu_tunggu_umurstart"]);
		$lap_waktu_tunggu_umurstart=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_waktu_tunggu_umurstart);
		$lap_waktu_tunggu_umurstart=str_replace("'", '"',$lap_waktu_tunggu_umurstart);
		$lap_waktu_tunggu_umurend=trim(@$_POST["lap_waktu_tunggu_umurend"]);
		$lap_waktu_tunggu_umurend=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_waktu_tunggu_umurend);
		$lap_waktu_tunggu_umurend=str_replace("'", '"',$lap_waktu_tunggu_umurend);
		$lap_waktu_tunggu_tgllahir =(isset($_POST['lap_waktu_tunggu_tgllahir']) ? @$_POST['lap_waktu_tunggu_tgllahir'] : @$_GET['lap_waktu_tunggu_tgllahir']);
		$lap_waktu_tunggu_tgllahirend =(isset($_POST['lap_waktu_tunggu_tgllahirend']) ? @$_POST['lap_waktu_tunggu_tgllahirend'] : @$_GET['lap_waktu_tunggu_tgllahirend']);
		$lap_waktu_tunggu_tgllahirend=trim(@$_POST["lap_waktu_tunggu_tgllahirend"]);
		
		//$dpaket_paket = isset($_POST['dpaket_paket']) ? $_POST['dpaket_paket'] : 0;*/
		//$dapaket_dpaket = isset($_POST['dapaket_dpaket']) ? $_POST['dapaket_dpaket'] : 0;
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_lap_waktu_tunggu->get_daftar_customer($lap_waktu_tunggu_id ,$lap_waktu_tunggu_tgllahir, $lap_waktu_tunggu_tgllahirend,$lap_waktu_tunggu_umurstart, $lap_waktu_tunggu_umurend,$tgl_start ,$tgl_end ,$lap_waktu_tunggu_kelamin, $lap_waktu_tunggu_member,$groupby, $tgl_tindakan,$start,$end);
		echo $result;
	}
	
	
	function lap_waktu_tunggu_print(){
  		//POST varibale here
		$trawat_id=trim(@$_POST["trawat_id"]);
		$trawat_cust=trim(@$_POST["trawat_cust"]);
	
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$lap_waktu_tunggu_id=trim(@$_POST["lap_waktu_tunggu_id"]);
		if(trim(@$_POST["tgl_start"])!="")
			$tgl_start=date('Y-m-d', strtotime(trim(@$_POST["tgl_start"])));
		else
			$tgl_start="";
		if(trim(@$_POST["tgl_end"])!="")
			$tgl_end=date('Y-m-d', strtotime(trim(@$_POST["tgl_end"])));
		else
			$tgl_end="";
			
		$groupby=trim(@$_POST["groupby"]);
		$groupby=str_replace("/(<\/?)(p)([^>]*>)", "",$groupby);
		$groupby=str_replace("'", '"',$groupby);
		
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		$menit=(isset($_POST['menit']) ? @$_POST['menit'] : @$_GET['menit']);

		$tgl_awal=$tahun."-".$bulan;
		
		if($periode=="tanggal"){
			$data["periode"]="Periode : ".$tgl_start." s/d ".$tgl_end." ";
		}else if($periode=="bulan"){
			$data["periode"]="Periode : " ." ".get_ina_month_name($bulan,'long')." ".$tahun;
		}
		
		if($groupby=="Semua"){
			$data["groupby"]="";
		}else{
			$data["groupby"]="Tindakan ".$groupby." ";
		}

		
		
		$data["data_print"]= $this->m_lap_waktu_tunggu->get_laporan_tunggu($menit,$tgl_awal,$periode,$lap_waktu_tunggu_id ,$tgl_start ,$tgl_end ,$groupby,  $trawat_id ,$trawat_cust ,$option,$filter);
		
		$print_view=$this->load->view("main/p_lap_wkt_tunggu_formcetak.php",$data,TRUE);
		
		//if(!file_exists("print")){
		//	mkdir("print");
	//	}
		
		$file = fopen("waktu_tunggu.html",'w');

		fwrite($file, $print_view);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function lap_lunjungan_export_excel(){
		//POST varibale here
		$trawat_id=trim(@$_POST["trawat_id"]);
		$trawat_dokter=trim(@$_POST["trawat_dokter"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_lap_waktu_tunggu->lap_lunjungan_export_excel($trawat_id ,$trawat_dokter ,$option,$filter);
		
		to_excel($query,"tindakan"); 
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