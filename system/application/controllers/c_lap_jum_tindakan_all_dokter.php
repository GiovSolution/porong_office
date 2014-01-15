<?php
/* 	
	+ Module  		: Laporan Tindakan Dokter Controller
	+ Description	: For record controller process back-end
	+ Filename 		: c_lap_jum_tindakan_all_dokter.php
 	+ Author  		: Fred

	
*/

//class of tindakan
class c_lap_jum_tindakan_all_dokter extends Controller {

	//constructor
	function c_lap_jum_tindakan_all_dokter(){
		parent::Controller();
		session_start();
		$this->load->model('m_lap_jum_tindakan_all_dokter', '', TRUE);
		$this->load->plugin('to_excel');
	}
	
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_lap_jum_tindakan_all_dokter');
	}
	
	function get_dokter_list(){
		//ID dokter pada tabel departemen adalah 8
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$tgl_app = isset($_POST['tgl_app']) ? $_POST['tgl_app'] : "";
		$result=$this->m_public_function->get_petugas_list($query,$tgl_app,"Dokter");
		echo $result;
	}


	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "SEARCH":
				$this->report_tindakan_search();
				break;
			case "SEARCHTOTAL":
				$this->report_tindakan_searchtotal();
				break;
			case "PRINT":
				$this->report_tindakan_print();
				break;
			case "EXCEL":
				$this->report_tindakan_export_excel();
				break;
			case "LIST_DOKTER":
				$this->report_daftar_list_dokter();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	function get_cabang_list(){
		$result=$this->m_public_function->get_cabang_list();
		echo $result;
	}

	//function for advanced search
	function report_tindakan_search(){
		//POST varibale here
		if(trim(@$_POST["trawat_tglapp_start"])!="")
			$trawat_tglapp_start=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_start"])));
		else
			$trawat_tglapp_start="";
			
		if(trim(@$_POST["trawat_tglapp_end"])!="")
			$trawat_tglapp_end=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_end"])));
		else
			$trawat_tglapp_end="";

		$report_groupby=trim(@$_POST["report_groupby"]);
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		$cabang=(isset($_POST['cabang']) ? @$_POST['cabang'] : @$_GET['cabang']);
		
		$tgl_awal=$tahun."-".$bulan;
		
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_lap_jum_tindakan_all_dokter->report_tindakan_search($tgl_awal,$periode, $trawat_tglapp_start ,$trawat_tglapp_end, $report_groupby, $start, $end, $cabang);
		echo $result;
	}

	function report_tindakan_searchtotal(){
		//POST varibale here
		if(trim(@$_POST["trawat_tglapp_start"])!="")
			$trawat_tglapp_start=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_start"])));
		else
			$trawat_tglapp_start="";
			
		if(trim(@$_POST["trawat_tglapp_end"])!="")
			$trawat_tglapp_end=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_end"])));
		else
			$trawat_tglapp_end="";

		$report_groupby=trim(@$_POST["report_groupby"]);
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		$cabang=(isset($_POST['cabang']) ? @$_POST['cabang'] : @$_GET['cabang']);
		
		$tgl_awal=$tahun."-".$bulan;
		
		
		$result = $this->m_lap_jum_tindakan_all_dokter->report_tindakan_searchtotal($tgl_awal,$periode, $trawat_tglapp_start ,$trawat_tglapp_end, $report_groupby, $cabang);
		echo $result;
	}

	function report_daftar_list_dokter()
	{
		if(trim(@$_POST["trawat_tglapp_start"])!="")
			$trawat_tglapp_start=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_start"])));
		else
			$trawat_tglapp_start="";
			
		if(trim(@$_POST["trawat_tglapp_end"])!="")
			$trawat_tglapp_end=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_end"])));
		else
			$trawat_tglapp_end="";

		$trawat_dokter=trim(@$_POST["trawat_dokter"]);
		$report_groupby=trim(@$_POST["report_groupby"]);
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		$cabang=(isset($_POST['cabang']) ? @$_POST['cabang'] : @$_GET['cabang']);
		
		$tgl_awal=$tahun."-".$bulan;
		
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_lap_jum_tindakan_all_dokter->report_daftar_dokter($tgl_awal,$periode, $trawat_tglapp_start ,$trawat_tglapp_end ,$trawat_dokter, $report_groupby, $start,$end, $cabang, 0);
		echo $result;
	}
	
		function report_tindakan_search2(){
		//POST varibale here
		if(trim(@$_POST["trawat_tglapp_start"])!="")
			$trawat_tglapp_start=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_start"])));
		else
			$trawat_tglapp_start="";
		if(trim(@$_POST["trawat_tglapp_end"])!="")
			$trawat_tglapp_end=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_end"])));
		else
			$trawat_tglapp_end="";

		$trawat_dokter=trim(@$_POST["trawat_dokter"]);
		$report_groupby=trim(@$_POST["report_groupby"]);
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		
		$tgl_awal=$tahun."-".$bulan;

		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_lap_jum_tindakan_all_dokter->report_tindakan_search2($tgl_awal,$periode ,$trawat_tglapp_start ,$trawat_tglapp_end ,$trawat_dokter, $report_groupby, $start,$end);
		echo $result;
	}
	
	function report_tindakan_print(){
  		//POST varibale here
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		if(trim(@$_POST["trawat_tglapp_start"])!="")
			$trawat_tglapp_start=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_start"])));
		else
			$trawat_tglapp_start="";
		if(trim(@$_POST["trawat_tglapp_end"])!="")
			$trawat_tglapp_end=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_end"])));
		else
			$trawat_tglapp_end="";

		$trawat_dokter=trim(@$_POST["trawat_dokter"]);
		$report_groupby=trim(@$_POST["report_groupby"]);
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		$cabang=(isset($_POST['cabang']) ? @$_POST['cabang'] : @$_GET['cabang']);
		
		$tgl_awal=$tahun."-".$bulan;
		
		
		$data["data_print1"] = $this->m_lap_jum_tindakan_all_dokter->report_tindakan_print($tgl_awal,$periode, $trawat_tglapp_start ,$trawat_tglapp_end, $report_groupby, $cabang);
		//$nbrows=$result->num_rows();
		
		$data["data_print2"] = $this->m_lap_jum_tindakan_all_dokter->report_tindakan_print2($tgl_awal,$periode, $trawat_tglapp_start ,$trawat_tglapp_end, $report_groupby, $cabang);	
		/*$nbrows2 = $result->num_rows();
		if($nbrows>0){
			foreach($result2->result_array() as $data2);
		}*/
		
		// ambil nama dokter
		$start = 0;
		$end = 50;
		$list_dokter = '';
		$result_dokter = $this->m_lap_jum_tindakan_all_dokter->report_daftar_dokter($tgl_awal,$periode, $trawat_tglapp_start ,$trawat_tglapp_end ,$trawat_dokter, $report_groupby, $start,$end, $cabang, 1);
		$decode_result_dokter = json_decode($result_dokter, true);
		$numrows_dokter = count($decode_result_dokter);

		
		for ($i=0; $i<$numrows_dokter; $i++) {
			$list_dokter = $list_dokter."<th scope='col'>".$decode_result_dokter[$i]['karyawan_username']."</th>";
			
		}
		$data["numrows_dokter"] = $numrows_dokter;
		$data["list_dokter"] = $list_dokter;
		// eof ambil nama dokter
		
		$viewdata=$this->load->view("main/p_lap_jum_all_dokter",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$this->load->plugin('to_excel');
		$print_file=fopen("print/Laporan_JumAllDokter.html","w+");
		fwrite($print_file, $viewdata);

		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function report_tindakan_export_excel(){
		//POST varibale here
		if(trim(@$_POST["trawat_tglapp_start"])!="")
			$trawat_tglapp_start=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_start"])));
		else
			$trawat_tglapp_start="";
			
		if(trim(@$_POST["trawat_tglapp_end"])!="")
			$trawat_tglapp_end=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_end"])));
		else
			$trawat_tglapp_end="";

		$report_groupby=trim(@$_POST["report_groupby"]);
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		$cabang=(isset($_POST['cabang']) ? @$_POST['cabang'] : @$_GET['cabang']);		
		$trawat_dokter=trim(@$_POST["trawat_dokter"]);
		$tgl_awal=$tahun."-".$bulan;
		
		$data["data_print1"] = $this->m_lap_jum_tindakan_all_dokter->report_tindakan_print($tgl_awal,$periode, $trawat_tglapp_start ,$trawat_tglapp_end, $report_groupby, $cabang);
		//$nbrows=$result->num_rows();
		
		$data["data_print2"] = $this->m_lap_jum_tindakan_all_dokter->report_tindakan_print2($tgl_awal,$periode, $trawat_tglapp_start ,$trawat_tglapp_end, $report_groupby, $cabang);	
		
		// ambil nama dokter
		$start = 0;
		$end = 50;
		$list_dokter = '';
		$result_dokter = $this->m_lap_jum_tindakan_all_dokter->report_daftar_dokter($tgl_awal,$periode, $trawat_tglapp_start ,$trawat_tglapp_end ,$trawat_dokter, $report_groupby, $start,$end, $cabang, 1);
		$decode_result_dokter = json_decode($result_dokter, true);
		$numrows_dokter = count($decode_result_dokter);

		
		for ($i=0; $i<$numrows_dokter; $i++) {
			$list_dokter = $list_dokter."<th scope='col'>".$decode_result_dokter[$i]['karyawan_username']."</th>";
			
		}
		$data["numrows_dokter"] = $numrows_dokter;
		$data["list_dokter"] = $list_dokter;
		// eof ambil nama dokter
		
		$viewdata=$this->load->view("main/p_lap_jum_all_dokter",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$this->load->plugin('to_excel');
		$print_file=fopen("print/Laporan_JumAllDokter.xls","w+");
		fwrite($print_file, $viewdata);
		
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