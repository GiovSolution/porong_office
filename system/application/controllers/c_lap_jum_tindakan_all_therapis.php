<?php
/* 	
	+ Module  		: Laporan Tindakan Semua Therapis Controller
	+ Description	: For record controller process back-end
	+ Filename 		: c_lap_jum_tindakan_all_therapis.php
 	+ Author  		: Isaac

	
*/

//class of tindakan
class c_lap_jum_tindakan_all_therapis extends Controller {

	//constructor
	function c_lap_jum_tindakan_all_therapis(){
		parent::Controller();
		session_start();
		$this->load->model('m_lap_jum_tindakan_all_therapis', '', TRUE);
		$this->load->plugin('to_excel');
	}
	
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_lap_jum_tindakan_all_therapis');
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
				$this->report_tindakan_therapis_search();
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
	function report_tindakan_therapis_search(){
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
		$result = $this->m_lap_jum_tindakan_all_therapis->report_tindakan_therapis_search($tgl_awal,$periode, $trawat_tglapp_start ,$trawat_tglapp_end, $report_groupby, $start, $end, $cabang);
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
		
		
		$result = $this->m_lap_jum_tindakan_all_therapis->report_tindakan_searchtotal($tgl_awal,$periode, $trawat_tglapp_start ,$trawat_tglapp_end, $report_groupby, $cabang);
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
		$result = $this->m_lap_jum_tindakan_all_therapis->report_daftar_dokter($tgl_awal,$periode, $trawat_tglapp_start ,$trawat_tglapp_end ,$trawat_dokter, $report_groupby, $start,$end, $cabang,0);
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
		$result = $this->m_lap_jum_tindakan_all_therapis->report_tindakan_search2($tgl_awal,$periode ,$trawat_tglapp_start ,$trawat_tglapp_end ,$trawat_dokter, $report_groupby, $start,$end);
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
		
		
		$data["data_print1"] = $this->m_lap_jum_tindakan_all_therapis->report_tindakan_print($tgl_awal,$periode, $trawat_tglapp_start ,$trawat_tglapp_end, $report_groupby, $cabang);
		//$nbrows=$result->num_rows();
		
		$data["data_print2"] = $this->m_lap_jum_tindakan_all_therapis->report_tindakan_print2($tgl_awal,$periode, $trawat_tglapp_start ,$trawat_tglapp_end, $report_groupby, $cabang);	
		//print_r($data["data_print2"][0]);
		//$nbrows2 = $result->num_rows();
		//if($nbrows>0){
		//	foreach($result2->result_array() as $data2);
		//}
		
		// ambil nama dokter
		$start = 0;
		$end = 50;
		$list_dokter = '';
		$result_dokter = $this->m_lap_jum_tindakan_all_therapis->report_daftar_dokter($tgl_awal,$periode, $trawat_tglapp_start ,$trawat_tglapp_end ,$trawat_dokter, $report_groupby, $start,$end, $cabang, 1);
		$decode_result_dokter = json_decode($result_dokter, true);
		$numrows_dokter = count($decode_result_dokter);

		
		for ($i=0; $i<$numrows_dokter; $i++) {
			$list_dokter = $list_dokter."<th scope='col'>".$decode_result_dokter[$i]['karyawan_username']."</th>";
			
		}
		$data["numrows_dokter"] = $numrows_dokter;
		$data["list_dokter"] = $list_dokter;
		// eof ambil nama dokter
		
		$viewdata=$this->load->view("main/p_lap_jum_all_terapis",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$this->load->plugin('to_excel');
		$print_file=fopen("print/Laporan_JumAllTerapis.html","w+");
		fwrite($print_file, $viewdata);
		
		//$totcolumn=8;
		
   		/* We now have our array, let's build our HTML file */
		/*
		$file = fopen("tindakanlist.html",'w');
		fwrite($file, "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Printing the Tindakan Grid</title><link rel='stylesheet' type='text/css' href='assets/modules/main/css/printstyle.css'/></head>");
		fwrite($file, "<body onload='window.print()'>
			<table summary='Tindakan List'>
			<caption>LAPORAN JUMLAH TINDAKAN THERAPIS</caption>
			<thead>
				<tr>
					<th scope='col'>No</th>
					<th scope='col'>Kode</th>
					<th scope='col'>Perawatan</th>".$list_dokter."
				</tr>
			</thead>
		<tfoot><tr><th>Total</th><td colspan='2'>");
		fwrite($file, $nbrows);
		fwrite($file, "</td><td align='right' class='numeric'>");
		
		for ($i=0; $i<$numrows_dokter; $i++) {
			$nama_param = 'tjtt_total_ref'.$i;
			fwrite($file, $data2[$nama_param]);
			fwrite($file, "</td><td align='right' class='numeric'>");
		}
		fwrite($file, "</td></tr></tfoot><tbody>");
		
		
		$i=0;
		if($nbrows>0){
			foreach($result->result_array() as $data){
				fwrite($file,'<tr');
				/*if($i%1==0){
					fwrite($file," class='odd'");
				}*/
		/*
				$i=$i+1;
				fwrite($file, "><td >");
				fwrite($file, $i);
				fwrite($file,"</td><td>");
				fwrite($file, $data['rawat_kode']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['rawat_nama']);
				fwrite($file, "</td><td align='right' class='numeric'>");
				
				for ($i=0; $i<$numrows_dokter; $i++) {
					$nama_param = 'tjtt_ref'.$i;
					fwrite($file, $data[$nama_param]);
					fwrite($file, "</td><td align='right' class='numeric'>");
				}
				fwrite($file, "</td></tr>");
			}
		}
		fwrite($file, "</tbody></table></body></html>");	
		fclose($file);
		*/
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function report_tindakan_export_excel(){
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
		
		
		$data["data_print1"] = $this->m_lap_jum_tindakan_all_therapis->report_tindakan_print($tgl_awal,$periode, $trawat_tglapp_start ,$trawat_tglapp_end, $report_groupby, $cabang);
		//$nbrows=$result->num_rows();
		
		$data["data_print2"] = $this->m_lap_jum_tindakan_all_therapis->report_tindakan_print2($tgl_awal,$periode, $trawat_tglapp_start ,$trawat_tglapp_end, $report_groupby, $cabang);	
		//print_r($data["data_print2"][0]);
		//$nbrows2 = $result->num_rows();
		//if($nbrows>0){
		//	foreach($result2->result_array() as $data2);
		//}
		
		// ambil nama dokter
		$start = 0;
		$end = 50;
		$list_dokter = '';
		$result_dokter = $this->m_lap_jum_tindakan_all_therapis->report_daftar_dokter($tgl_awal,$periode, $trawat_tglapp_start ,$trawat_tglapp_end ,$trawat_dokter, $report_groupby, $start,$end, $cabang, 1);
		$decode_result_dokter = json_decode($result_dokter, true);
		$numrows_dokter = count($decode_result_dokter);

		
		for ($i=0; $i<$numrows_dokter; $i++) {
			$list_dokter = $list_dokter."<th scope='col'>".$decode_result_dokter[$i]['karyawan_username']."</th>";
			
		}
		$data["numrows_dokter"] = $numrows_dokter;
		$data["list_dokter"] = $list_dokter;
		// eof ambil nama dokter
		
		$viewdata=$this->load->view("main/p_lap_jum_all_terapis",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$this->load->plugin('to_excel');
		$print_file=fopen("print/Laporan_JumAllTerapis.xls","w+");
		fwrite($print_file, $viewdata);
		
		/*
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
		
		$query = $this->m_lap_jum_tindakan_all_therapis->report_tindakan_export_excel($tgl_awal,$periode, $trawat_tglapp_start ,$trawat_tglapp_end, $report_groupby, $cabang);
		$this->load->plugin('to_excel');
		to_excel($query,"Report_Tindakan_Dokter"); 
		*/
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