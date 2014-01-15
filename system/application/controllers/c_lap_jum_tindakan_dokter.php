<?php
/* 	
	+ Module  		: Laporan Tindakan Dokter Controller
	+ Description	: For record controller process back-end
	+ Filename 		: c_lap_jum_tindakan_Dokter.php
 	+ Author  		: Fred

	
*/

//class of tindakan
class C_lap_jum_tindakan_dokter extends Controller {

	//constructor
	function C_lap_jum_tindakan_dokter(){
		parent::Controller();
		session_start();
		$this->load->model('m_lap_jum_tindakan_dokter', '', TRUE);
		$this->load->plugin('to_excel');
	}
	
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_lap_jum_tindakan_dokter');
	}
	
	function get_dokter_list(){
		//ID dokter pada tabel departemen adalah 8
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$tgl_app = isset($_POST['tgl_app']) ? $_POST['tgl_app'] : "";
		$result=$this->m_lap_jum_tindakan_dokter->get_petugas_list($query,$tgl_app,"Dokter");
		echo $result;
	}


	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "SEARCH":
				$this->report_tindakan_search();
				break;
			case "SEARCH2":
				$this->report_tindakan_search2();
				break;
			case "PRINT":
				$this->report_tindakan_print();
				break;
			case "EXCEL":
				$this->report_tindakan_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	

	//function for advanced search
	function report_tindakan_search(){
		//POST varibale here
		$report_tindakan_id=trim(@$_POST["report_tindakan_id"]);
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
		$result = $this->m_lap_jum_tindakan_dokter->report_tindakan_search($tgl_awal,$periode,$report_tindakan_id ,$trawat_tglapp_start ,$trawat_tglapp_end ,$trawat_dokter, $report_groupby, $start,$end);
		echo $result;
	}

		function report_tindakan_search2(){
		//POST varibale here
		//$report_tindakan_id=trim(@$_POST["report_tindakan_id"]);
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
		$result = $this->m_lap_jum_tindakan_dokter->report_tindakan_search2($tgl_awal,$periode ,$trawat_tglapp_start ,$trawat_tglapp_end ,$trawat_dokter, $report_groupby, $start,$end);
		echo $result;
	}
	
	function report_tindakan_print(){
  		//POST varibale here
		//$trawat_id=trim(@$_POST["trawat_id"]);
		//$trawat_cust=trim(@$_POST["trawat_cust"]);
		//$trawat_keterangan=trim(@$_POST["trawat_keterangan"]);
		//$trawat_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$trawat_keterangan);
		//$trawat_keterangan=str_replace("'", "''",$trawat_keterangan);
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
			$trawat_tglapp_start_label = date('d-m-Y', strtotime($trawat_tglapp_start));
			$trawat_tglapp_end_label = date('d-m-Y', strtotime($trawat_tglapp_end));
			$periode_label = "Periode ".$trawat_tglapp_start_label." s/d ".$trawat_tglapp_end_label;
		}
		
		$result = $this->m_lap_jum_tindakan_dokter->report_tindakan_print($tgl_awal,$periode,$report_groupby,$trawat_dokter,$trawat_tglapp_start,$trawat_tglapp_end,$option,$filter);
		$nbrows=$result->num_rows();
		
		$result2 = $this->m_lap_jum_tindakan_dokter->report_tindakan_print2($tgl_awal,$periode ,$trawat_tglapp_start ,$trawat_tglapp_end ,$trawat_dokter, $report_groupby);	
		$nbrows2 = $result->num_rows();
		if($nbrows>0){
			foreach($result2->result_array() as $data2);
		}

		
		$totcolumn=8;
   		/* We now have our array, let's build our HTML file */
		$file = fopen("tindakanlist.html",'w');
		fwrite($file, "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Printing the Tindakan Grid</title><link rel='stylesheet' type='text/css' href='assets/modules/main/css/printstyle.css'/></head>");
		fwrite($file, "<body onload='window.print()'><table summary='Tindakan List'><caption>LAPORAN JUMLAH TINDAKAN DOKTER <br> $periode_label </caption><thead><tr><th scope='col'>Karyawan</th><th scope='col'>Kode</th><th scope='col'>Perawatan</th><th scope='col'>Jumlah</th><th scope='col'>Kredit (Poin)</th><th scope='col'>Kredit (Rp)</th><th scope='col'>Tot Kredit (Poin)</th><th scope='col'>Tot Kredit (Rp)</th></tr></thead>
		<tfoot>
			<tr>		
				<th>Grand Tot Kredit(Poin)</th>
				<td colspan='$totcolumn'>");
					fwrite($file,  $data2['grand_total']);
					fwrite($file, " 
				</td>
			</tr>
			<tr>
				<th>Grand Tot Kredit(Rp)</th>
				<td colspan='$totcolumn'>");
					fwrite($file,  number_format($data2['grand_total_rp'],0,',',','));
					fwrite($file, " 
				</td>
			</tr>
			<tr>		
				<th scope='row'>Total</th>
				<td colspan='$totcolumn'>");
					fwrite($file, $nbrows);
					fwrite($file, " Tindakan
				</td>
			</tr>
		</tfoot>
		<tbody>");
		$i=0;
		if($nbrows>0){
			foreach($result->result_array() as $data){
				fwrite($file,'<tr');
				/*if($i%1==0){
					fwrite($file," class='odd'");
				}*/
			
				fwrite($file, "><td >");
				fwrite($file, $data['karyawan_username']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['rawat_kode']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['rawat_nama']);
				fwrite($file, "</td><td align='right' class='numeric'>");
				fwrite($file, $data['Jumlah_rawat']);
				fwrite($file, "</td><td align='right' class='numeric'>");
				fwrite($file, $data['rawat_kredit']);
				fwrite($file, "</td><td align='right' class='numeric'> ");
				fwrite($file, number_format($data['rawat_kreditrp'],0,',',','));
				fwrite($file, " </td><td align='right' class='numeric'>");
				fwrite($file, $data['Total_kredit']);
				fwrite($file, "</td><td align='right' class='numeric'>");
				fwrite($file, number_format($data['Total_kreditrp'],0,',',','));
				fwrite($file, "</td></tr>");
			}
		}
		fwrite($file, "</tbody></table></body></html>");	
		fclose($file);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function report_tindakan_export_excel(){
		//POST varibale here
		$trawat_id=trim(@$_POST["trawat_id"]);
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
		$option=$_POST['currentlisting'];
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		
		$tgl_awal=$tahun."-".$bulan;

		$filter=$_POST["query"];
		
		$query = $this->m_lap_jum_tindakan_dokter->report_tindakan_export_excel($tgl_awal,$periode,$trawat_id ,$trawat_tglapp_start , $trawat_tglapp_end, $trawat_dokter,
																				$report_groupby, $option, $filter);
		$this->load->plugin('to_excel');
		to_excel($query,"Report_Tindakan_Dokter"); 
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