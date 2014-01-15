<?php
/* 
	+ Module  		: Laporan Kunjungan Non Transaksi Controller
	+ Description	: For record controller process back-end
	+ Filename 		: c_lap_kunjungan_non.php
 	+ Author  		: Fred
*/

//class of tindakan
class C_lap_kunjungan_non extends Controller {

	//constructor
	function C_lap_kunjungan_non(){
		parent::Controller();
		$this->load->model('m_lap_kunjungan_non', '', TRUE);
		$this->load->plugin('to_excel');
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_lap_kunjungan_non');
	}


	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->lap_kunjungan_non_list();
				break;
			case "LIST2":
				$this->lap_totalkunjungan_non_list();
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
				$this->lap_kunjungan_non_search();
				break;
			case "SEARCH2":
				$this->lap_kunjungan_non_search2();
				break;
			case "PRINT":
				$this->lap_kunjungan_non_print();
				break;
			case "EXCEL":
				$this->lap_kunjungan_non_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function lap_kunjungan_non_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_lap_kunjungan_non->lap_kunjungan_non_list($query,$start,$end);
		echo $result;
	}
	
	//function fot list record
	function lap_totalkunjungan_non_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_lap_kunjungan_non->lap_totalkunjungan_non_list($query,$start,$end);
		echo $result;
	}

	//function for advanced search
	function lap_kunjungan_non_search(){
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

		$lap_kunjungan_nonkelamin=trim(@$_POST["lap_kunjungan_nonkelamin"]);
		$lap_kunjungan_nonkelamin=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_nonkelamin);
		$lap_kunjungan_nonkelamin=str_replace("'", '"',$lap_kunjungan_nonkelamin);
		$lap_kunjungan_nonmember=trim(@$_POST["lap_kunjungan_nonmember"]);
		$lap_kunjungan_nonmember=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_nonmember);
		$lap_kunjungan_nonmember=str_replace("'", '"',$lap_kunjungan_nonmember);
		$lap_kunjungan_noncust=trim(@$_POST["lap_kunjungan_noncust"]);
		$lap_kunjungan_noncust=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_noncust);
		$lap_kunjungan_noncust=str_replace("'", '"',$lap_kunjungan_noncust);
		
		//$trawat_dokter=trim(@$_POST["trawat_dokter"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_lap_kunjungan_non->lap_kunjungan_non_search($lap_kunjungan_nonkelamin, $lap_kunjungan_nonmember, $lap_kunjungan_noncust,$lap_kunjungan_id ,$trawat_tglapp_start ,$trawat_tglapp_end ,$start,$end);
		echo $result;
	}

		function lap_kunjungan_non_search2(){
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

		$lap_kunjungan_nonkelamin=trim(@$_POST["lap_kunjungan_nonkelamin"]);
		$lap_kunjungan_nonkelamin=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_nonkelamin);
		$lap_kunjungan_nonkelamin=str_replace("'", '"',$lap_kunjungan_nonkelamin);
		$lap_kunjungan_nonmember=trim(@$_POST["lap_kunjungan_nonmember"]);
		$lap_kunjungan_nonmember=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_nonmember);
		$lap_kunjungan_nonmember=str_replace("'", '"',$lap_kunjungan_nonmember);
		$lap_kunjungan_noncust=trim(@$_POST["lap_kunjungan_noncust"]);
		$lap_kunjungan_noncust=str_replace("/(<\/?)(p)([^>]*>)", "",$lap_kunjungan_noncust);
		$lap_kunjungan_noncust=str_replace("'", '"',$lap_kunjungan_noncust);
		$trawat_dokter=trim(@$_POST["trawat_dokter"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_lap_kunjungan_non->lap_kunjungan_non_search2($lap_kunjungan_nonkelamin, $lap_kunjungan_nonmember, $lap_kunjungan_noncust, $lap_kunjungan_id ,$trawat_tglapp_start ,$trawat_tglapp_end ,$trawat_dokter ,$start,$end);
		echo $result;
	}
	
	function lap_kunjungan_non_print(){
  		//POST varibale here
		$trawat_id=trim(@$_POST["trawat_id"]);
		$trawat_cust=trim(@$_POST["trawat_cust"]);
		$trawat_keterangan=trim(@$_POST["trawat_keterangan"]);
		$trawat_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$trawat_keterangan);
		$trawat_keterangan=str_replace("'", "''",$trawat_keterangan);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$result = $this->m_tindakan_medis->lap_kunjungan_non_print($trawat_id ,$trawat_cust ,$trawat_keterangan ,$option,$filter);
		$nbrows=$result->num_rows();
		$totcolumn=8;
   		/* We now have our array, let's build our HTML file */
		$file = fopen("tindakanlist.html",'w');
		fwrite($file, "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Printing the Tindakan Grid</title><link rel='stylesheet' type='text/css' href='assets/modules/main/css/printstyle.css'/></head>");
		fwrite($file, "<body><table summary='Tindakan List'><caption>TINDAKAN</caption><thead><tr><th scope='col'>Trawat Id</th><th scope='col'>Trawat Cust</th><th scope='col'>Trawat Keterangan</th><th scope='col'>Trawat Creator</th><th scope='col'>Trawat Date Create</th><th scope='col'>Trawat Update</th><th scope='col'>Trawat Date Update</th><th scope='col'>Trawat Revised</th></tr></thead><tfoot><tr><th scope='row'>Total</th><td colspan='$totcolumn'>");
		fwrite($file, $nbrows);
		fwrite($file, " Tindakan</td></tr></tfoot><tbody>");
		$i=0;
		if($nbrows>0){
			foreach($result->result_array() as $data){
				fwrite($file,'<tr');
				if($i%1==0){
					fwrite($file," class='odd'");
				}
			
				fwrite($file, "><th scope='row' id='r97'>");
				fwrite($file, $data['trawat_id']);
				fwrite($file,"</th><td>");
				fwrite($file, $data['trawat_cust']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['trawat_keterangan']);
				fwrite($file, "</td></tr>");
				fwrite($file, $data['trawat_creator']);
				fwrite($file, "</td></tr>");
				fwrite($file, $data['trawat_date_create']);
				fwrite($file, "</td></tr>");
				fwrite($file, $data['trawat_update']);
				fwrite($file, "</td></tr>");
				fwrite($file, $data['trawat_date_update']);
				fwrite($file, "</td></tr>");
				fwrite($file, $data['trawat_revised']);
				fwrite($file, "</td></tr>");
			}
		}
		fwrite($file, "</tbody></table></body></html>");	
		fclose($file);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function lap_kunjungan_non_export_excel(){
		//POST varibale here
		$trawat_id=trim(@$_POST["trawat_id"]);
		$trawat_dokter=trim(@$_POST["trawat_dokter"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_lap_kunjungan_non->lap_kunjungan_non_export_excel($trawat_id ,$trawat_dokter ,$option,$filter);
		
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