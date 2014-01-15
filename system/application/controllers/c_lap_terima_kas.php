<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: jual_bank Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_lap_terima_kas.php
 	+ Author  		: Zainal, Mukhlison
 	+ Created on 11/Jul/2009 06:46:58
	
*/

//class of jual_bank
class C_lap_terima_kas extends Controller {

	//constructor
	function C_lap_terima_kas(){
		parent::Controller();
		session_start();
		$this->load->model('m_lap_terima_kas', '', TRUE);
		$this->load->plugin('to_excel');
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_lap_terima_kas');
	}
	
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "SEARCH":
				$this->laporan_terimakas_search();
				break;
			case "SEARCH2":
				$this->laporan_terimakas_search2();
				break;
			case "SEARCH3":
				$this->laporan_terimakas_search3();
				break;
			case "TARGET":
				$this->laporan_terimakas_target();
				break;
			case "CONN":
				$this->laporan_terimakas_conn();
				break;
			case "CHART":
				$this->prepare_chart();
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

	function laporan_terimakas_search(){
		$tgl_awal=(isset($_POST['tgl_awal']) ? @$_POST['tgl_awal'] : @$_GET['tgl_awal']);
		$tgl_akhir=(isset($_POST['tgl_akhir']) ? @$_POST['tgl_akhir'] : @$_GET['tgl_akhir']);
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$opsi=(isset($_POST['opsi']) ? @$_POST['opsi'] : @$_GET['opsi']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		$cabang=(isset($_POST['cabang']) ? @$_POST['cabang'] : @$_GET['cabang']);
		
		if($periode=="bulan"){
			$tgl_awal=$tahun."-".$bulan;
		}
		
		$result=$this->m_public_function->get_laporan_terima_kas($tgl_awal, $tgl_akhir, $periode, $opsi, $cabang);
		
		echo $result; 
	}

	function laporan_terimakas_search2(){
		$tgl_awal=(isset($_POST['tgl_awal']) ? @$_POST['tgl_awal'] : @$_GET['tgl_awal']);
		$tgl_akhir=(isset($_POST['tgl_akhir']) ? @$_POST['tgl_akhir'] : @$_GET['tgl_akhir']);
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		$cabang=(isset($_POST['cabang']) ? @$_POST['cabang'] : @$_GET['cabang']);
		
		if($periode=="bulan"){
			$tgl_awal=$tahun."-".$bulan;
		}
		
		$result=$this->m_public_function->get_laporan_terima_kas_total($tgl_awal, $tgl_akhir, $periode, $cabang);
		
		echo $result; 
	}
	
	function laporan_terimakas_search3(){
		$tgl_awal=(isset($_POST['tgl_awal']) ? @$_POST['tgl_awal'] : @$_GET['tgl_awal']);
		$tgl_akhir=(isset($_POST['tgl_akhir']) ? @$_POST['tgl_akhir'] : @$_GET['tgl_akhir']);
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		$cabang=(isset($_POST['cabang']) ? @$_POST['cabang'] : @$_GET['cabang']);
		
		if($periode=="bulan"){
			$tgl_awal=$tahun."-".$bulan;
		}
		
		$result=$this->m_lap_terima_kas->get_laporan_terima_kas_total2($tgl_awal, $tgl_akhir, $periode, $cabang);
		
		echo $result; 
	}

	
	function laporan_terimakas_target(){
		$cabang=(isset($_POST['cabang']) ? @$_POST['cabang'] : @$_GET['cabang']);
		$tgl_awal=(isset($_POST['tgl_awal']) ? @$_POST['tgl_awal'] : @$_GET['tgl_awal']);
		$tgl_akhir=(isset($_POST['tgl_akhir']) ? @$_POST['tgl_akhir'] : @$_GET['tgl_akhir']);				
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		
		$result=$this->m_public_function->get_laporan_terima_kas_target($tgl_awal, $tgl_akhir, $periode, $cabang);
		//$result=$this->m_public_function->get_laporan_terima_kas_target();
		
		echo $result; 
	}
	
	function print_laporan(){
		$tgl_awal=(isset($_POST['tgl_awal']) ? @$_POST['tgl_awal'] : @$_GET['tgl_awal']);
		$tgl_akhir=(isset($_POST['tgl_akhir']) ? @$_POST['tgl_akhir'] : @$_GET['tgl_akhir']);
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$opsi=(isset($_POST['opsi']) ? @$_POST['opsi'] : @$_GET['opsi']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		$cabang=(isset($_POST['cabang']) ? @$_POST['cabang'] : @$_GET['cabang']);
		
		
		$data["jenis"]='Produk';
		if($periode=="all"){
			$data["periode"]="Semua Periode";
		}else if($periode=="bulan"){
			$tgl_awal=$tahun."-".$bulan;
			$data["periode"]=get_ina_month_name($bulan,'long')." ".$tahun;
		}else if($periode=="tanggal"){
			$data["periode"]="Periode ".$tgl_awal." s/d ".$tgl_akhir;
		}
		
		
		$data["data_print"]=$this->m_public_function->get_laporan_terima_kas($tgl_awal,$tgl_akhir,$periode,$opsi, $cabang);
		$data["sql"]=$this->db->last_query();
		$print_view=$this->load->view("main/p_lap_terima_kas.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		if($opsi=='rekap')
			$print_file=fopen("print/report_terimakas.html","w+");
		else
			$print_file=fopen("print/report_terimakas.html","w+");
			
		fwrite($print_file, $print_view);
		echo '1'; 
	}
	
	function prepare_chart()
	{
		$this->load->library('highcharts');
		$title = "";
		$subtitle = "";
	    
		$tgl_awal=(isset($_POST['tgl_awal']) ? @$_POST['tgl_awal'] : @$_GET['tgl_awal']);
		$tgl_akhir=(isset($_POST['tgl_akhir']) ? @$_POST['tgl_akhir'] : @$_GET['tgl_akhir']);
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		$cabang=(isset($_POST['cabang']) ? @$_POST['cabang'] : @$_GET['cabang']);
		
		if($periode=="bulan"){
			$tgl_awal=$tahun."-".$bulan;
		}
		
		$result=$this->m_lap_terima_kas->get_laporan_terima_kas_total2($tgl_awal, $tgl_akhir, $periode, $cabang);
		$result_target=$this->m_public_function->get_laporan_terima_kas_target($tgl_awal, $tgl_akhir, $periode, $cabang);
		
			if ($periode == "tanggal")
			{
			  $bulan_title = " ".date("d F Y",strtotime($tgl_awal))." - ".date("d F Y",strtotime($tgl_akhir));
			}
			else
			{
				$bulan_title = date("F",strtotime("01-".$bulan."-".$tahun));
			}
		
		$title = "Laporan Penerimaan Kas ".$bulan_title;
		
		$terimakas_type = array("nilai_grand_total" => "Total");
		
		$result_data = explode(",",$result,2);
		$count = strlen($result_data[1]) - 1;
	
		if ($result_target==1)
			echo 1;
		else {
		
			$result_data_target = explode(",",$result_target,2);
			$count_target = strlen($result_data_target[1]) - 1;
		
			$data_parse = json_decode("{".substr($result_data[1],0,$count),true);
			$data_parse_target = json_decode("{".substr($result_data_target[1],0,$count_target),true);
						
			//print_r($data_parse_target);
						
			echo $data_parse['results'][0]['nilai_grand_total'] / $data_parse_target['results'][0]['tt_rp'];
		}				
	}
	
	function clearBrowserCache() {
		header("Cache-Control: no-cache, must-revalidate");
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Content-Type: application/xml; charset=utf-8");
	}
	
}
?>