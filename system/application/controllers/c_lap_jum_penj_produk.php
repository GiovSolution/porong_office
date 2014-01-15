<?php
/* 	
	+ Module  		: Laporan Jmlh Penjualan Produk Controller
	+ Description	: For record controller process back-end
	+ Filename 		: c_lap_jum_penj_produk.php
 	+ Author  		: Fred

	
*/

//class of tindakan
class C_lap_jum_penj_produk extends Controller {

	//constructor
	function C_lap_jum_penj_produk(){
		parent::Controller();
		session_start();
		$this->load->model('m_lap_jum_penj_produk', '', TRUE);
		$this->load->plugin('to_excel');
	}
	
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_lap_jum_penj_produk');
	}
	
	function get_dokter_list(){
		//ID dokter pada tabel departemen adalah 8
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$tgl_app = isset($_POST['tgl_app']) ? $_POST['tgl_app'] : "";
		$result=$this->m_lap_jum_penj_produk->get_petugas_list($query,$tgl_app,"Dokter","Staff");
		echo $result;
	}


	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->lap_jum_penj_produk_list();
				break;
			case "LIST2":
				$this->lap_jum_penj_produk_list2();
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
			case "SEARCH":
				$this->lap_jum_penj_produk_search();
				break;
			case "SEARCH2":
				$this->lap_jum_penj_produk_search2();
				break;
			case "PRINT":
				$this->report_tindakan_print();
				break;
			case "EXCEL":
				$this->lap_jum_penj_produk_exportExcel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function lap_jum_penj_produk_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_lap_jum_penj_produk->lap_jum_penj_produk_list($query,$start,$end);
		echo $result;
	}
	
	function get_group1_list(){
		$query = isset($_POST['query']) ? @$_POST['query'] : @$_GET['query'];
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
			
		$result=$this->m_public_function->get_group1_list($query,$start,$end);
		echo $result;
	}
	
	//function fot list record
	function lap_jum_penj_produk_list2(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_lap_jum_penj_produk->lap_jum_penj_produk_list2($query,$start,$end);
		echo $result;
	}

	//function for advanced search
	function lap_jum_penj_produk_search(){
		//POST varibale here
		$ljpp_id=trim(@$_POST["ljpp_id"]);
		if(trim(@$_POST["ljpp_tgl_start"])!="")
			$ljpp_tgl_start=date('Y-m-d', strtotime(trim(@$_POST["ljpp_tgl_start"])));
		else
			$ljpp_tgl_start="";
		if(trim(@$_POST["ljpp_tgl_end"])!="")
			$ljpp_tgl_end=date('Y-m-d', strtotime(trim(@$_POST["ljpp_tgl_end"])));
		else
			$ljpp_tgl_end="";

		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);	
		$opsi_jproduk = (isset($_POST['opsi_jproduk']) ? @$_POST['opsi_jproduk'] : @$_GET['opsi_jproduk']);
		$group1_id = (integer) (isset($_POST['group1_id']) ? @$_POST['group1_id'] : @$_GET['group1_id']);
		
		$ljpp_karyawan_id=trim(@$_POST["ljpp_karyawan_id"]);
		//$ljpp_groupby=trim(@$_POST["ljpp_groupby"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_lap_jum_penj_produk->lap_jum_penj_produk_search($group1_id,$bulan, $tahun, $opsi_jproduk,$periode,$ljpp_id ,$ljpp_tgl_start ,$ljpp_tgl_end ,$ljpp_karyawan_id, /*$ljpp_groupby, */$start,$end);
		echo $result;
	}

	function lap_jum_penj_produk_search2(){
		//POST varibale here
		$ljpp_id=trim(@$_POST["ljpp_id"]);
		if(trim(@$_POST["ljpp_tgl_start"])!="")
			$ljpp_tgl_start=date('Y-m-d', strtotime(trim(@$_POST["ljpp_tgl_start"])));
		else
			$ljpp_tgl_start="";
		if(trim(@$_POST["ljpp_tgl_end"])!="")
			$ljpp_tgl_end=date('Y-m-d', strtotime(trim(@$_POST["ljpp_tgl_end"])));
		else
			$ljpp_tgl_end="";

		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);	
		$opsi_jproduk = (isset($_POST['opsi_jproduk']) ? @$_POST['opsi_jproduk'] : @$_GET['opsi_jproduk']);
		$group1_id = (integer) (isset($_POST['group1_id']) ? @$_POST['group1_id'] : @$_GET['group1_id']);
			
		$ljpp_karyawan_id=trim(@$_POST["ljpp_karyawan_id"]);
		//$ljpp_groupby=trim(@$_POST["ljpp_groupby"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_lap_jum_penj_produk->lap_jum_penj_produk_search2($group1_id,$bulan, $tahun, $opsi_jproduk,$periode,$ljpp_id ,$ljpp_tgl_start ,$ljpp_tgl_end ,$ljpp_karyawan_id, /*$ljpp_groupby,*/ $start,$end);
		echo $result;
	}
	
	function report_tindakan_print(){
  		//POST varibale here
		if(trim(@$_POST["ljpp_tgl_start"])!="")
			$ljpp_tgl_start=date('Y-m-d', strtotime(trim(@$_POST["ljpp_tgl_start"])));
		else
			$ljpp_tgl_start="";
		if(trim(@$_POST["ljpp_tgl_end"])!="")
			$ljpp_tgl_end=date('Y-m-d', strtotime(trim(@$_POST["ljpp_tgl_end"])));
		else
			$ljpp_tgl_end="";
		
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$opsi_jproduk = (isset($_POST['opsi_jproduk']) ? @$_POST['opsi_jproduk'] : @$_GET['opsi_jproduk']);
		$group1_id = (integer) (isset($_POST['group1_id']) ? @$_POST['group1_id'] : @$_GET['group1_id']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		
		if($bulan == '01'){
			$bulan_text = 'Januari';
		}else if($bulan == '2'){
			$bulan_text = 'Februari';
		}else if($bulan == '03'){
			$bulan_text = 'Maret';
		}else if($bulan == '04'){
			$bulan_text = 'April';
		}else if($bulan == '05'){
			$bulan_text = 'Mei';
		}else if($bulan == '06'){
			$bulan_text = 'Juni';
		}else if($bulan == '07'){
			$bulan_text = 'Juli';
		}else if($bulan == '08'){
			$bulan_text = 'Agustus';
		}else if($bulan == '09'){
			$bulan_text = 'September';
		}else if($bulan == '10'){
			$bulan_text = 'Oktober';
		}else if($bulan == '11'){
			$bulan_text = 'November';
		}else{
			$bulan_text = 'Desember';
		}
		
		if($periode == 'bulan'){
			$label = $bulan_text.' '.$tahun;
		}else{
			$label = $ljpp_tgl_start.'-'.$ljpp_tgl_end;
		}
		
		$ljpp_karyawan_id=trim(@$_POST["ljpp_karyawan_id"]);
		//$ljpp_groupby=trim(@$_POST["ljpp_groupby"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$result = $this->m_lap_jum_penj_produk->report_tindakan_print($group1_id,$bulan, $tahun, $opsi_jproduk,$periode,$ljpp_tgl_start , $ljpp_tgl_end, $ljpp_karyawan_id,
																				/*$ljpp_groupby,*/ $option, $filter);
		$nbrows=$result->num_rows();
		
		/*untuk nama dokter*/
		$rs=$result->row();
		$jumlah_result=$result->result();		
		$karyawan_username=$rs->karyawan_username;
		
		
		$totcolumn=6;
   		/* We now have our array, let's build our HTML file */
		$file = fopen("tindakanlist.html",'w');
		fwrite($file, "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Printing the Tindakan Grid</title><link rel='stylesheet' type='text/css' href='assets/modules/main/css/printstyle.css'/></head>");
		fwrite($file, "<body><table summary='Tindakan List'><caption>Laporan Jumlah Penjualan Produk <br> $karyawan_username, Periode $label </caption><thead><tr><th scope='col'>No</th><th scope='col'>Kode Produk</th><th scope='col'>Produk</th><th scope='col'>Jumlah</th><th scope='col'>Kredit(Rp)</th><th scope='col'>Tot Kredit (Rp)</th></tr></thead><tfoot><tr><th scope='row'>Total</th><td colspan='$totcolumn'>");
		fwrite($file, $nbrows);
		fwrite($file, " item </td></tr></tfoot><tbody>");
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
				fwrite($file, $data['produk_kode']);
				fwrite($file,"</td><td align='right' class='numeric'>");
				fwrite($file, $data['produk_nama']);
				fwrite($file,"</td><td align='right' class='numeric'>");
				fwrite($file, $data['Jumlah_produk']);
				fwrite($file, "</td><td align='right' class='numeric'>");
				fwrite($file, $data['komisi_satuan']);
				fwrite($file,"</td><td align='right' class='numeric'>");
				fwrite($file, $data['komisi']);
				fwrite($file, "</td></tr>");
			}
			
		}
		fwrite($file, "</tbody></table></body></html>");	
		fclose($file);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function lap_jum_penj_produk_exportExcel(){
		//POST varibale here
		if(trim(@$_POST["ljpp_tgl_start"])!="")
			$ljpp_tgl_start=date('Y-m-d', strtotime(trim(@$_POST["ljpp_tgl_start"])));
		else
			$ljpp_tgl_start="";
		if(trim(@$_POST["ljpp_tgl_end"])!="")
			$ljpp_tgl_end=date('Y-m-d', strtotime(trim(@$_POST["ljpp_tgl_end"])));
		else
			$ljpp_tgl_end="";
	
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$opsi_jproduk = (isset($_POST['opsi_jproduk']) ? @$_POST['opsi_jproduk'] : @$_GET['opsi_jproduk']);
		$group1_id = (integer) (isset($_POST['group1_id']) ? @$_POST['group1_id'] : @$_GET['group1_id']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		
		$ljpp_karyawan_id=trim(@$_POST["ljpp_karyawan_id"]);
		//$ljpp_groupby=trim(@$_POST["ljpp_groupby"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_lap_jum_penj_produk->lap_jum_penj_produk_exportExcel($group1_id,$bulan, $tahun, $opsi_jproduk,$periode,$ljpp_tgl_start , $ljpp_tgl_end, $ljpp_karyawan_id,
																				/*$ljpp_groupby, */$option, $filter);
		$this->load->plugin('to_excel');
		to_excel($query,"Report_Jmlh_Penj_Produk"); 
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