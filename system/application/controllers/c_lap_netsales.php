<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: netsales Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_lap_netsales.php
 	+ Author  		: Zainal, Mukhlison
 	+ Created on 11/Jul/2009 06:46:58
	
*/

//class of netsales
class C_lap_netsales extends Controller {

	//constructor
	function C_lap_netsales(){
		parent::Controller();
		$this->load->model('m_lap_netsales', '', TRUE);
		$this->load->helper('url');
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_lap_netsales');
	}
	
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->laporan_netsales_list();
				break;
			case "LISTTOTAL":
				$this->laporan_netsalestotal_list();
				break;
			case "RECALC":
				$this->laporan_netsales_recalc();
				break;
			case "RECALC2":
				$this->laporan_netsales_search2();
				break;
			case "SEARCH":
				$this->laporan_netsales_search();
				break;
			case "SEARCH2":
				$this->laporan_netsales_search2();
				break;
			case "PRINT":
				$this->laporan_netsales_print();
				break;
			case "EXCEL":
				$this->laporan_netsales_export_excel();
				break;
			case "CHART":
				$this->laporan_netsales_chart();
				break;
			case "CHART_SEARCH":
				$search= true;
				$this->laporan_netsales_chart($search);
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	function laporan_netsales_recalc(){
		$tgl_awal=(isset($_POST['tgl_awal']) ? @$_POST['tgl_awal'] : @$_GET['tgl_awal']);
		$tgl_akhir=(isset($_POST['tgl_akhir']) ? @$_POST['tgl_akhir'] : @$_GET['tgl_akhir']);
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		$groupby	= (isset($_POST['groupby']) ? @$_POST['groupby'] : @$_GET['groupby']);

		$result=$this->m_lap_netsales->get_laporan_netsales_recalc($tgl_awal, $tgl_akhir, $periode, $bulan, $tahun, $groupby);
		
		echo $result; 
	}
	
	function laporan_netsales_search(){
		$tgl_awal=(isset($_POST['tgl_awal']) ? @$_POST['tgl_awal'] : @$_GET['tgl_awal']);
		$tgl_akhir=(isset($_POST['tgl_akhir']) ? @$_POST['tgl_akhir'] : @$_GET['tgl_akhir']);
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		$groupby	= (isset($_POST['groupby']) ? @$_POST['groupby'] : @$_GET['groupby']);
		
		$result=$this->m_lap_netsales->get_laporan_netsales($tgl_awal, $tgl_akhir, $periode, $bulan, $tahun, $groupby);
		
		echo $result; 
	}
	
	function laporan_netsales_list(){
		$tgl_awal="";
		$tgl_akhir="";
		$bulan=date("m");
		$tahun=date("Y");
		$periode="bulan";
		
		$result=$this->m_lap_netsales->get_laporan_netsales($tgl_awal, $tgl_akhir, $periode, $bulan, $tahun);
		
		echo $result; 
	}
	
	function laporan_netsales_search2(){
		$tgl_awal=(isset($_POST['tgl_awal']) ? @$_POST['tgl_awal'] : @$_GET['tgl_awal']);
		$tgl_akhir=(isset($_POST['tgl_akhir']) ? @$_POST['tgl_akhir'] : @$_GET['tgl_akhir']);
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		
		$result=$this->m_lap_netsales->get_laporan_netsalestotal($tgl_awal, $tgl_akhir, $periode, $bulan, $tahun);
		
		echo $result; 
	}

	function laporan_netsalestotal_list(){
		$tgl_awal="";
		$tgl_akhir="";
		$bulan=date("m");
		$tahun=date("Y");
		$periode="bulan";
		
		
		$result=$this->m_lap_netsales->get_laporan_netsalestotal($tgl_awal, $tgl_akhir, $periode, $bulan, $tahun);
		
		echo $result; 
	}
	
	function laporan_netsales_print(){
  		//POST varibale here
		
		if(trim(@$_POST["tgl_awal"])!="")
			$tgl_awal=date('Y-m-d', strtotime(trim(@$_POST["tgl_awal"])));
		else
			$tgl_awal="";
		if(trim(@$_POST["tgl_akhir"])!="")
			$tgl_akhir=date('Y-m-d', strtotime(trim(@$_POST["tgl_akhir"])));
		else
			$tgl_akhir="";
		
		$bulan=trim(@$_POST["bulan"]);
		$tahun=trim(@$_POST["tahun"]);
		$periode=trim(@$_POST["periode"]);
		$groupby=trim(@$_POST["groupby"]);
		
		if($periode=="bulan"){
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

			$data["periode"]="Periode : ".$tgl_awal_show." s/d ".$tgl_akhir_show." ";
		}else if ($periode == '' && $groupby == '') {
			$tahun = date('Y');
			$bulan = date('m');
			$tgl_awal=$tahun."-".$bulan;
			$data["periode"]=get_ina_month_name($bulan,'long')." ".$tahun;
		}
		
		$result = $this->m_lap_netsales->laporan_netsales_print($tgl_awal, $tgl_akhir, $bulan, $tahun, $periode, $groupby);		
		$rs=$result->row();
		$jumlah_result=$result->result();
		
		$data['tns_tanggal']=$rs->tns_tanggal;
		$data['tns_medis']=$rs->tns_medis;
		$data['tns_nonmedis']=$rs->tns_nonmedis;
		$data['tns_surgery']=$rs->tns_surgery;
		$data['tns_antiaging']=$rs->tns_antiaging;
		$data['tns_produk']=$rs->tns_produk;
		$data['tns_lainlain']=$rs->tns_lainlain;
		$data['tns_total']=$rs->tns_total;
		$data['jumlah_result']=$jumlah_result;
		
		//$nbrows=$result->num_rows();
		$viewdata=$this->load->view("main/p_lap_netsales",$data,TRUE);

		$file = fopen("print/lap_netsales.html",'w');
		fwrite($file, $viewdata);	
		fclose($file);
		echo '1';        
	}
	/* End Of Function */
	
	/* Function to Export Excel document */
	function laporan_netsales_export_excel(){
		if(trim(@$_POST["tgl_awal"])!="")
			$tgl_awal=date('Y-m-d', strtotime(trim(@$_POST["tgl_awal"])));
		else
			$tgl_awal="";
		if(trim(@$_POST["tgl_akhir"])!="")
			$tgl_akhir=date('Y-m-d', strtotime(trim(@$_POST["tgl_akhir"])));
		else
			$tgl_akhir="";
		
		$bulan=trim(@$_POST["bulan"]);
		$tahun=trim(@$_POST["tahun"]);
		$periode=trim(@$_POST["periode"]);
		$groupby=trim(@$_POST["groupby"]);
		
		if($periode=="bulan"){
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

			$data["periode"]="Periode : ".$tgl_awal_show." s/d ".$tgl_akhir_show." ";
		}else if ($periode == '' && $groupby == '') {
			$tahun = date('Y');
			$bulan = date('m');
			$tgl_awal=$tahun."-".$bulan;
			$data["periode"]=get_ina_month_name($bulan,'long')." ".$tahun;
		}
		$result = $this->m_lap_netsales->laporan_netsales_print($tgl_awal, $tgl_akhir, $bulan, $tahun, $periode, $groupby);		
		$rs=$result->row();
		$jumlah_result=$result->result();
		
		$data['tns_tanggal']=$rs->tns_tanggal;
		$data['tns_medis']=$rs->tns_medis;
		$data['tns_nonmedis']=$rs->tns_nonmedis;
		$data['tns_surgery']=$rs->tns_surgery;
		$data['tns_antiaging']=$rs->tns_antiaging;
		$data['tns_produk']=$rs->tns_produk;
		$data['tns_lainlain']=$rs->tns_lainlain;
		$data['tns_total']=$rs->tns_total;
		$data['jumlah_result']=$jumlah_result;
		
		$viewdata=$this->load->view("main/p_lap_netsales",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$this->load->plugin('to_excel');
		$print_file=fopen("print/Laporan_NetSales.xls","w+");
		fwrite($print_file, $viewdata);
		
		/*
		$data["data_print"] = $this->m_trial_balance->trial_balance_print($balance_tgl_awal, $balance_tgl_akhir,$start,$end );
		$data["type"]="excel";
		$print_view=$this->load->view("main/p_trial_balance.php",$data,TRUE);
		
		if(!file_exists("print")){
			mkdir("print");
		}
		$this->load->plugin('to_excel');
		$print_file=fopen("print/trial_balance_printlist.xls","w+");
		fwrite($print_file, $print_view);
		*/
		echo '1'; 
			
	}

	function laporan_netsales_chart($search=false)
	{	
		$this->load->library('highcharts');
		$title = "";
		$subtitle = "";
	    /**
		 * Mengelompokkan data apakah berasal dari proses search atau tampilan awal
		 */
		if ($search == false)
		{
		  $tgl_awal="";
		  $tgl_akhir="";
		  $tahun=date("Y");
		  $bulan=date("m");
		 		
		  $periode="bulan";
		  $subtitle = "";
		  $bulan_title = date("F",strtotime("01-".$bulan."-".$tahun));
		}
		else
		{   
			$tgl_awal=(isset($_POST['tgl_awal']) ? @$_POST['tgl_awal'] : @$_GET['tgl_awal']);
			$tgl_akhir=(isset($_POST['tgl_akhir']) ? @$_POST['tgl_akhir'] : @$_GET['tgl_akhir']);
			$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
			$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
			$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']); 
			if ($periode == "tanggal")
			{
			  $tmp = explode("-",$tgl_awal);
			  $tgl = strtotime($tmp[2]."-".$tmp[1]."-".$tmp[0]);
			  $bulan = $tmp[1];
			  $tahun = $tmp[0];
			  //$periode = "bulan";
			  //$bulan_title = " ".substr($tgl_awal,8,2)."-".substr($tgl_akhir,8,2)." ".date("F",strtotime("01-".$bulan."-".$tahun));
			  $bulan_title = " ".date("d F Y",strtotime($tgl_awal))." - ".date("d F Y",strtotime($tgl_akhir));
			}
			else
			{
				$bulan_title = date("F",strtotime("01-".$bulan."-".$tahun));
			}
		}
		

		$title = "Laporan Net Sales ".$bulan_title;
		
		// data array untuk Y Axis
		$netsales_type = array("tns_tanggal" => "Tanggal",
							   "tns_medis" => "Medis",
							   "tns_nonmedis" => "Non Medis",
							   "tns_surgery" => "Surgery",
							   "tns_antiaging" => "Anti Aging",
							   "tns_produk" => "Produk",
							   "tns_lainlain" => "Lain-Lain",
							   "tns_total" => "Total");
		
		$result=$this->m_lap_netsales->get_laporan_netsales($tgl_awal, $tgl_akhir, $periode, $bulan, $tahun,$chart='true');
		
		$page_count = 0;
		$page_line = file('print/lap_netsales_graph.log');
		if ($search == false)
		{
			$page_count = count($page_line)+1;
		}
		else
		{
			$page_count = count($page_line);
		}
		
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
		
		$this->highcharts->set_type('line'); // chart type
		$this->highcharts->set_title($title, $subtitle); // set chart title: title, subtitle(optional)
		$this->highcharts->set_axis_titles('Bulan', 'Nominal'); // axis titles: x axis,  y axis
		$this->highcharts->set_global_options($opt_array);
		
		$data_axis['categories'] = array();
		
		$x=0;
		foreach($netsales_type as $type_idx => $type_name)
		{
		    $data["'".$type_idx."'"]['data'] = array();
			$data["'".$type_idx."'"]['name'] = $type_idx;

				

			$i = 0;
			foreach($result as $row_data) {
				$value = 0;
				if ($type_idx == 'tns_tanggal')
				{
				  
		          $data_axis['categories'][$i] = $row_data->$type_idx;
			    }
				else
				{
				  $data["'".$type_idx."'"]['data'][$i] = (int) $row_data->$type_idx;
				}
	
				$i++;

			}
			if ($type_idx != 'tns_tanggal') 
			{
				$this->highcharts->set_serie($data["'".$type_idx."'"],$type_name);
			}
		}
		
		$data['axis']['categories'] = array();

		for ($y=0; $y<count($data_axis['categories']); $y++)
		{
			$tmp_date = $data_axis['categories'][$y];
		    $data['axis']['categories'][$y] = date('d M', strtotime($tmp_date));
		}
		
		$this->highcharts->set_xAxis($data['axis']);
		$this->highcharts->set_dimensions(1170,380);
		
		$graph_data = $this->highcharts->render();
		
		$data['charts'] = $graph_data;
		
		$print_view=$this->load->view("main/template_chart.php",$data,TRUE);
	
		if(!file_exists("print")){
			mkdir("print");
		}
		$filename = "print/lap_netsales_graph.php";
		$log_file = "print/lap_netsales_graph.log";
		if(file_exists($filename)){
			unlink($filename);
			$this->clearBrowserCache();
		}
	
		$print_file=fopen("print/lap_netsales_graph.php","w+");
		
		$fwrite = fwrite($print_file, $print_view);
		if ($fwrite !== false && $search == false)
		{
		    $log_print = $_SERVER['REMOTE_ADDR']."\n";
			$log_file_open=fopen("print/lap_netsales_graph.log","a+");
			fwrite($log_file_open,$log_print);
		}
		echo '1';
	}
	
	function clearBrowserCache() {
		header("Cache-Control: no-cache, must-revalidate");
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Content-Type: application/xml; charset=utf-8");
	}
	
}
?>