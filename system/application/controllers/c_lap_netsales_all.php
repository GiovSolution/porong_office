<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: jual_bank Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_lap_netsales_all.php
 	+ Author  		: Zainal, Mukhlison
 	+ Created on 11/Jul/2009 06:46:58
	
*/

//class of jual_bank
class C_lap_netsales_all extends Controller {
	
	private $mResult;
	//constructor
	function C_lap_netsales_all(){
		parent::Controller();
		$this->load->model('m_lap_netsales_all', '', TRUE);
		//$this->load->plugin('to_excel');
		$this->load->helper('url');
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_lap_netsales_all');
	}
	
	function get_action(){

		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->laporan_netsales_all_list();
				break;
			case "LISTTOTAL":
				$this->laporan_netsales_alltotal_list();
				break;
			case "SEARCH":
				$this->laporan_netsales_all_search();
				break;
			case "SEARCH2":
				$this->laporan_netsales_all_search2();
				break;
			case "DETAIL":
				$this->laporan_netsales_all_searchdetail();
				break;
			case "PRINT":
				$this->tindakan_print();
				break;
			case "EXCEL":
				$this->tindakan_export_excel();
				break;
			case "CHART":
				$this->prepare_chart();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
		
	function laporan_netsales_all_search(){
		$tgl_awal=(isset($_POST['tgl_awal']) ? @$_POST['tgl_awal'] : @$_GET['tgl_awal']);
		$tgl_akhir=(isset($_POST['tgl_akhir']) ? @$_POST['tgl_akhir'] : @$_GET['tgl_akhir']);
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		$cabang_th	= (isset($_POST['cabang_th']) ? @$_POST['cabang_th'] : @$_GET['cabang_th']);
		$cabang_ki	= (isset($_POST['cabang_ki']) ? @$_POST['cabang_ki'] : @$_GET['cabang_ki']);
		$cabang_hr	= (isset($_POST['cabang_hr']) ? @$_POST['cabang_hr'] : @$_GET['cabang_hr']);
		$cabang_tp	= (isset($_POST['cabang_tp']) ? @$_POST['cabang_tp'] : @$_GET['cabang_tp']);
		$cabang_dps	= (isset($_POST['cabang_dps']) ? @$_POST['cabang_dps'] : @$_GET['cabang_dps']);
		$cabang_mta	= (isset($_POST['cabang_mta']) ? @$_POST['cabang_mta'] : @$_GET['cabang_mta']);
		$cabang_mdn	= (isset($_POST['cabang_mdn']) ? @$_POST['cabang_mdn'] : @$_GET['cabang_mdn']);
		$cabang_lbk	= (isset($_POST['cabang_lbk']) ? @$_POST['cabang_lbk'] : @$_GET['cabang_lbk']);
		$cabang_mnd	= (isset($_POST['cabang_mnd']) ? @$_POST['cabang_mnd'] : @$_GET['cabang_mnd']);
		$cabang_ygk	= (isset($_POST['cabang_ygk']) ? @$_POST['cabang_ygk'] : @$_GET['cabang_ygk']);
		$cabang_blpn	= (isset($_POST['cabang_blpn']) ? @$_POST['cabang_blpn'] : @$_GET['cabang_blpn']);
		
		$result=$this->m_lap_netsales_all->get_laporan_netsales_all($tgl_awal, $tgl_akhir, $periode, $bulan, $tahun, $cabang_th, $cabang_ki, $cabang_hr, $cabang_tp, $cabang_dps, $cabang_mta, $cabang_mdn, $cabang_lbk, $cabang_mnd, $cabang_ygk, $cabang_blpn);
		
		echo $result; 
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
		$cabang_th	= (isset($_POST['cabang_th']) ? @$_POST['cabang_th'] : @$_GET['cabang_th']);
		$cabang_ki	= (isset($_POST['cabang_ki']) ? @$_POST['cabang_ki'] : @$_GET['cabang_ki']);
		$cabang_hr	= (isset($_POST['cabang_hr']) ? @$_POST['cabang_hr'] : @$_GET['cabang_hr']);
		$cabang_tp	= (isset($_POST['cabang_tp']) ? @$_POST['cabang_tp'] : @$_GET['cabang_tp']);
		$cabang_dps	= (isset($_POST['cabang_dps']) ? @$_POST['cabang_dps'] : @$_GET['cabang_dps']);
		$cabang_mta	= (isset($_POST['cabang_mta']) ? @$_POST['cabang_mta'] : @$_GET['cabang_mta']);
		$cabang_mdn	= (isset($_POST['cabang_mdn']) ? @$_POST['cabang_mdn'] : @$_GET['cabang_mdn']);
		$cabang_lbk	= (isset($_POST['cabang_lbk']) ? @$_POST['cabang_lbk'] : @$_GET['cabang_lbk']);
		$cabang_mnd	= (isset($_POST['cabang_mnd']) ? @$_POST['cabang_mnd'] : @$_GET['cabang_mnd']);
		$cabang_ygk	= (isset($_POST['cabang_ygk']) ? @$_POST['cabang_ygk'] : @$_GET['cabang_ygk']);
		$cabang_blpn	= (isset($_POST['cabang_blpn']) ? @$_POST['cabang_blpn'] : @$_GET['cabang_blpn']);
		
		$result=$this->m_lap_netsales_all->get_laporan_netsales_all($tgl_awal, $tgl_akhir, $periode, $bulan, $tahun, $cabang_th, $cabang_ki, $cabang_hr, $cabang_tp, $cabang_dps, $cabang_mta, $cabang_mdn, $cabang_lbk, $cabang_mnd, $cabang_ygk, $cabang_blpn);
		
			if ($periode == "tanggal")
			{
			  //$tmp = explode("-",$tgl_awal);
			  //$tgl = strtotime($tmp[2]."-".$tmp[1]."-".$tmp[0]);
			  //$bulan = $tmp[1];
			  //$tahun = $tmp[0];
			  //$periode = "bulan";
			  //$bulan_title = " ".substr($tgl_awal,8,2)."-".substr($tgl_akhir,8,2)." ".date("F",strtotime("01-".$bulan."-".$tahun));
			  $bulan_title = " ".date("d F Y",strtotime($tgl_awal))." - ".date("d F Y",strtotime($tgl_akhir));
			}
			else
			{
				$bulan_title = date("F",strtotime("01-".$bulan."-".$tahun));
			}
		
		

		$title = "Laporan Net Sales ".$bulan_title;
		
		// data array untuk Y Axis
		$netsales_type = array("tns_medis" => "Medis",
							   "cabang_kode" => "Cabang",
							   "tns_nonmedis" => "Non Medis",
							   "tns_surgery" => "Surgery",
							   "tns_antiaging" => "Anti Aging",
							   "tns_produk" => "Produk",
							   "tns_lainlain" => "Lain-Lain",
							   "tns_total" => "Total");
		
		
		$result_data = explode(",",$result,2);
		$count = strlen($result_data[1]) - 1;
	
		$data_parse = json_decode("{".substr($result_data[1],0,$count),true);
		
		//print_r($result_data[1]);
		$page_count = 0;
		$page_line = file('print/lap_netsales_all_graph.log');
		
		$page_count = count($page_line);
		
		
		if ($page_count == 1)
		{
			$time = "time";
		}
		else
		{
			$time = "times";
		}
		$page_label = "this page has been viewed for {$page_count} {$time}";
		$opt_array = array('credits' => array('enabled'=> true,
										'text'	=> $page_label,
										'href' => '#'));
		
		$this->highcharts->set_type('column'); // chart type
		$this->highcharts->set_title($title, $subtitle); // set chart title: title, subtitle(optional)
		$this->highcharts->set_axis_titles('Bulan', 'Nominal'); // axis titles: x axis,  y axis
		$this->highcharts->set_global_options($opt_array);
		
		$data_axis['categories'] = array();
		
		$x=0;
		foreach($netsales_type as $type_idx => $type_name)
		{
		   if ($type_idx != "cabang_kode")
			{
				$data["'".$type_idx."'"]['data'] = array();
				$data["'".$type_idx."'"]['name'] = $type_idx;
			}

				

			$i = 0;
			foreach($data_parse['results'] as $row_data) {
				$value = 0;
				if ($type_idx == 'cabang_kode')
				{
				  
		          $data_axis['categories'][$i] = $row_data[$type_idx];
			    }
				else
				{
				  $data["'".$type_idx."'"]['data'][$i] = (int) $row_data[$type_idx];
				}
	
				$i++;

			}
			if ($type_idx != 'cabang_kode') 
			{
				$this->highcharts->set_serie($data["'".$type_idx."'"],$type_name);
			}
		}
		
		$data['axis']['categories'] = array();

		for ($y=0; $y<count($data_axis['categories']); $y++)
		{
			//$tmp_date = $data_axis['categories'][$y];
		    $data['axis']['categories'][$y] = $data_axis['categories'][$y];
		}
		
		$this->highcharts->set_xAxis($data['axis']);
		$this->highcharts->set_dimensions(1170,380);
		
		$graph_data = $this->highcharts->render();
		
		$data['charts'] = $graph_data;
		
		$print_view=$this->load->view("main/template_chart.php",$data,TRUE);
	
		if(!file_exists("print")){
			mkdir("print");
		}
		$filename = "print/lap_netsales_all_graph.php";
		$log_file = "print/lap_netsales_all_graph.log";
		if(file_exists($filename)){
			unlink($filename);
			$this->clearBrowserCache();
		}
	
		$print_file=fopen("print/lap_netsales_all_graph.php","w+");
		
		$fwrite = fwrite($print_file, $print_view);
		if ($fwrite !== false)
		{
		    $log_print = $_SERVER['REMOTE_ADDR']."\n";
			$log_file_open=fopen("print/lap_netsales_all_graph.log","a+");
			fwrite($log_file_open,$log_print);
		}
		echo '1';
		
	}
	
	function laporan_netsales_all_list(){
		$tgl_awal="";
		$tgl_akhir="";
		$bulan=date("m");
		$tahun=date("Y");
		$periode="bulan";
		
		$result=$this->m_lap_netsales_all->get_laporan_netsales_all($tgl_awal, $tgl_akhir, $periode, $bulan, $tahun);
		
		echo $result; 
	}
	
	function laporan_netsales_all_search2(){
		$tgl_awal=(isset($_POST['tgl_awal']) ? @$_POST['tgl_awal'] : @$_GET['tgl_awal']);
		$tgl_akhir=(isset($_POST['tgl_akhir']) ? @$_POST['tgl_akhir'] : @$_GET['tgl_akhir']);
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		$cabang_th	= (isset($_POST['cabang_th']) ? @$_POST['cabang_th'] : @$_GET['cabang_th']);
		$cabang_ki	= (isset($_POST['cabang_ki']) ? @$_POST['cabang_ki'] : @$_GET['cabang_ki']);
		$cabang_hr	= (isset($_POST['cabang_hr']) ? @$_POST['cabang_hr'] : @$_GET['cabang_hr']);
		$cabang_tp	= (isset($_POST['cabang_tp']) ? @$_POST['cabang_tp'] : @$_GET['cabang_tp']);
		$cabang_dps	= (isset($_POST['cabang_dps']) ? @$_POST['cabang_dps'] : @$_GET['cabang_dps']);
		$cabang_mta	= (isset($_POST['cabang_mta']) ? @$_POST['cabang_mta'] : @$_GET['cabang_mta']);
		$cabang_mdn	= (isset($_POST['cabang_mdn']) ? @$_POST['cabang_mdn'] : @$_GET['cabang_mdn']);
		$cabang_lbk	= (isset($_POST['cabang_lbk']) ? @$_POST['cabang_lbk'] : @$_GET['cabang_lbk']);
		$cabang_mnd	= (isset($_POST['cabang_mnd']) ? @$_POST['cabang_mnd'] : @$_GET['cabang_mnd']);
		$cabang_ygk	= (isset($_POST['cabang_ygk']) ? @$_POST['cabang_ygk'] : @$_GET['cabang_ygk']);
		$cabang_blpn	= (isset($_POST['cabang_blpn']) ? @$_POST['cabang_blpn'] : @$_GET['cabang_blpn']);
		
		$result=$this->m_lap_netsales_all->get_laporan_netsales_alltotal($tgl_awal, $tgl_akhir, $periode, $bulan, $tahun, $cabang_th, $cabang_ki, $cabang_hr, $cabang_tp, $cabang_dps, $cabang_mta, $cabang_mdn, $cabang_lbk, $cabang_mnd, $cabang_ygk, $cabang_blpn);
				
		echo $result; 
	}

	function laporan_netsales_all_searchdetail(){
		$tgl_awal=(isset($_POST['tgl_awal']) ? @$_POST['tgl_awal'] : @$_GET['tgl_awal']);
		$tgl_akhir=(isset($_POST['tgl_akhir']) ? @$_POST['tgl_akhir'] : @$_GET['tgl_akhir']);
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		$cabang	= (isset($_POST['cabang']) ? @$_POST['cabang'] : @$_GET['cabang']);
		
		$result=$this->m_lap_netsales_all->get_laporan_netsales_alldetail($tgl_awal, $tgl_akhir, $periode, $bulan, $tahun, $cabang);
		
		echo $result; 
	}

	function laporan_netsales_alltotal_list(){
		$tgl_awal="";
		$tgl_akhir="";
		$bulan=date("m");
		$tahun=date("Y");
		$periode="bulan";
		
		
		$result=$this->m_lap_netsales_all->get_laporan_netsales_alltotal($tgl_awal, $tgl_akhir, $periode, $bulan, $tahun);
		
		echo $result; 
	}
	
	function clearBrowserCache() {
		header("Cache-Control: no-cache, must-revalidate");
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Content-Type: application/xml; charset=utf-8");
	}
	
}
?>