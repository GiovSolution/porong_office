<?php
/* 	
	+ Module  		: Report Tindakan Dokter Controller
	+ Description	: For record controller process back-end
	+ Filename 		: c_lap_jum_tindakan_terapis.php
 	+ Author  		: Fred

*/

//class of tindakan
class C_lap_jum_tindakan_terapis extends Controller {

	//constructor
	function C_lap_jum_tindakan_terapis(){
		parent::Controller();
		session_start();
		$this->load->model('m_lap_jum_tindakan_terapis', '', TRUE);
		$this->load->plugin('to_excel');
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_lap_jum_tindakan_terapis');
	}
	
	function get_terapis_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		//$tgl_app = isset($_POST['tgl_app']) ? $_POST['tgl_app'] : "";
		$result=$this->m_lap_jum_tindakan_terapis->get_terapis_list($query);
		echo $result;
	}


	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->lap_jum_tindakan_terapis_list();
				break;
			case "LIST2":
				$this->lap_jum_tindakan_terapis_list2();
				break;
			case "SEARCH":
				$this->lap_jum_tindakan_terapis_search();
				break;
			case "SEARCH2":
				$this->lap_jum_tindakan_terapis_search2();
				break;
			case "PRINT":
				$this->lap_jum_tindakan_terapis_print();
				break;
			case "EXCEL":
				$this->lap_jum_tindakan_terapis_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function lap_jum_tindakan_terapis_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_lap_jum_tindakan_terapis->lap_jum_tindakan_terapis_list($query,$start,$end);
		echo $result;
	}
	
	//function fot list record
	function lap_jum_tindakan_terapis_list2(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_lap_jum_tindakan_terapis->lap_jum_tindakan_terapis_list2($query,$start,$end);
		echo $result;
	}

	//function for advanced search
	function lap_jum_tindakan_terapis_search(){
		//POST varibale here
		$lap_jum_tindakan_terapis_id=trim(@$_POST["lap_jum_tindakan_terapis_id"]);
		if(trim(@$_POST["lapjum_tglapp_start"])!="")
			$lapjum_tglapp_start=date('Y-m-d', strtotime(trim(@$_POST["lapjum_tglapp_start"])));
		else
			$lapjum_tglapp_start="";
			
		if(trim(@$_POST["lapjum_tglapp_end"])!="")
			$lapjum_tglapp_end=date('Y-m-d', strtotime(trim(@$_POST["lapjum_tglapp_end"])));
		else
			$lapjum_tglapp_end="";

		$terapis_id=trim(@$_POST["terapis_id"]);
		$lapjum_groupby=trim(@$_POST["lapjum_groupby"]);
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		
		$tgl_awal=$tahun."-".$bulan;
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_lap_jum_tindakan_terapis->lap_jum_tindakan_terapis_search($tgl_awal,$periode,$lap_jum_tindakan_terapis_id ,$lapjum_tglapp_start ,$lapjum_tglapp_end ,$terapis_id ,$lapjum_groupby, $start,$end);
		echo $result;
	}

	function lap_jum_tindakan_terapis_search2(){
		//POST varibale here
		$lap_jum_tindakan_terapis_id=trim(@$_POST["lap_jum_tindakan_terapis_id"]);
		if(trim(@$_POST["lapjum_tglapp_start"])!="")
			$lapjum_tglapp_start=date('Y-m-d', strtotime(trim(@$_POST["lapjum_tglapp_start"])));
		else
			$lapjum_tglapp_start="";
		if(trim(@$_POST["lapjum_tglapp_end"])!="")
			$lapjum_tglapp_end=date('Y-m-d', strtotime(trim(@$_POST["lapjum_tglapp_end"])));
		else
			$lapjum_tglapp_end="";

		$terapis_id=trim(@$_POST["terapis_id"]);
		$lapjum_groupby=trim(@$_POST["lapjum_groupby"]);
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		
		$tgl_awal=$tahun."-".$bulan;
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_lap_jum_tindakan_terapis->lap_jum_tindakan_terapis_search2($tgl_awal,$periode,$lap_jum_tindakan_terapis_id ,$lapjum_tglapp_start ,$lapjum_tglapp_end ,$terapis_id ,$lapjum_groupby, $start,$end);
		echo $result;
	}
	
	function lap_jum_tindakan_terapis_print(){
  		//POST varibale here
		$lap_jum_tindakan_terapis_id=trim(@$_POST["lap_jum_tindakan_terapis_id"]);
		if(trim(@$_POST["lapjum_tglapp_start"])!="")
			$lapjum_tglapp_start=date('Y-m-d', strtotime(trim(@$_POST["lapjum_tglapp_start"])));
		else
			$lapjum_tglapp_start="";
			
		if(trim(@$_POST["lapjum_tglapp_end"])!="")
			$lapjum_tglapp_end=date('Y-m-d', strtotime(trim(@$_POST["lapjum_tglapp_end"])));
		else
			$lapjum_tglapp_end="";

		$terapis_id=trim(@$_POST["terapis_id"]);
		$lapjum_groupby=trim(@$_POST["lapjum_groupby"]);
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		
		$tgl_awal=$tahun."-".$bulan;
		
		if ($periode == 'bulan'){
			if($bulan==1){
				$bulan_label = "Januari ";
			}elseif($bulan==2){ 
				$bulan_label = "Februari ";
			}elseif($bulan==3){
				$bulan_label = "Maret ";
			}elseif($bulan==4){ 
				$bulan_label = "April ";
			}elseif($bulan==5){ 
				$bulan_label = "Mei ";
			}elseif($bulan==6){ 
				$bulan_label = "Juni ";
			}elseif($bulan==7){ 
				$bulan_label = "Juli ";
			}elseif($bulan==8){ 
				$bulan_label = "Agustus ";
			}elseif($bulan==9){ 
				$bulan_label = "September ";
			}elseif($bulan==10){ 
				$bulan_label = "Oktober ";
			}elseif ($bulan==11){ 
				$bulan_label = "November ";
			}elseif($bulan==12){ 
				$bulan_label = "Desember ";	
			}	

			$periode_label = "Periode ".$bulan_label.$tahun;
		}else{
			$lapjum_tglapp_start_label = date('d-m-Y', strtotime($lapjum_tglapp_start));
			$lapjum_tglapp_end_end_label = date('d-m-Y', strtotime($lapjum_tglapp_end));
			$periode_label = "Periode ".$lapjum_tglapp_start_label." s/d ".$lapjum_tglapp_end_end_label;
		}
		
		
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$result = $this->m_lap_jum_tindakan_terapis->lap_jum_tindakan_terapis_print($tgl_awal,$periode,$lap_jum_tindakan_terapis_id ,$lapjum_tglapp_start ,$lapjum_tglapp_end ,$terapis_id ,$lapjum_groupby, $option,$filter);
		$nbrows=$result->num_rows();
		
		/*untuk nama dokter*/
		$rs=$result->row();
		$jumlah_result=$result->result();		
		$karyawan_username=$rs->karyawan_username;
		
		$totcolumn=6;
		$grand_tot=0;
   		/* We now have our array, let's build our HTML file */
		$file = fopen("tindakanlist.html",'w');
		fwrite($file, "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Printing the Tindakan Grid</title><link rel='stylesheet' type='text/css' href='assets/modules/main/css/printstyle.css'/></head>");
		fwrite($file, "<body><table summary='Tindakan List'><caption>Laporan Jumlah Tindakan Therapist <br> $karyawan_username, $periode_label <br> Group By $lapjum_groupby </caption><thead><tr><th scope='col'>No</th><th scope='col'>Kode</th><th scope='col'>Perawatan</th><th scope='col'>Jumlah</th><th scope='col'>Kredit(Satuan)</th><th scope='col'>Total Kredit</th></tr></thead><tbody>");
		$i=0;
		if($nbrows>0){
			foreach($result->result_array() as $data){
				fwrite($file,'<tr');
				if($i%1==0){
					fwrite($file," class='odd'");
				}
				$i=$i+1;
				fwrite($file, "><th scope='row' id='r97'>");
				fwrite($file, $i);
				fwrite($file,"</th><td>");
				fwrite($file, $data['rawat_kode']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['rawat_nama']);
				fwrite($file,"</td><td align='right' class='numeric'>");
				fwrite($file, $data['Jumlah_rawat']);
				fwrite($file, "</td><td align='right' class='numeric'>");
				fwrite($file, $data['rawat_kredit']);
				fwrite($file, "</td><td align='right' class='numeric'>");
				fwrite($file, $data['Total_kredit']);
				fwrite($file, "</td></tr>");
				$grand_tot+= $data['Total_kredit'];
			}
		}
		fwrite($file, "</tbody><tfoot><tr><th scope='row'>Total</th><td colspan='3'>");
		fwrite($file, $nbrows);
		fwrite($file, " Tindakan</td><th scope='row'>Grand Total Kredit</th><td align='right' class='numeric'>");
		fwrite($file, $grand_tot);
		fwrite($file, "</td></tr></tfoot></table></body></html>");	
		fclose($file);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function lap_jum_tindakan_terapis_export_excel(){
		//POST varibale here
		$lapjum_id=trim(@$_POST["lapjum_id"]);
		if(trim(@$_POST["lapjum_tglapp_start"])!="")
			$lapjum_tglapp_start=date('Y-m-d', strtotime(trim(@$_POST["lapjum_tglapp_start"])));
		else
			$lapjum_tglapp_start="";
		if(trim(@$_POST["lapjum_tglapp_end"])!="")
			$lapjum_tglapp_end=date('Y-m-d', strtotime(trim(@$_POST["lapjum_tglapp_end"])));
		else
			$lapjum_tglapp_end="";

		$terapis_id=trim(@$_POST["terapis_id"]);
		$lapjum_groupby=trim(@$_POST["lapjum_groupby"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		
		$tgl_awal=$tahun."-".$bulan;
		
		$query = $this->m_lap_jum_tindakan_terapis->lap_jum_tindakan_terapis_export_excel($tgl_awal,$periode,$lapjum_id ,$terapis_id , $lapjum_tglapp_start, $lapjum_tglapp_end,
																							$lapjum_groupby, $option,$filter);
		$this->load->plugin('to_excel');
		to_excel($query,"Report_Tindakan_Terapis"); 
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