<?php
/* 
	+ Module  		: top Spender Controller
	+ Description	: For record controller process back-end
	+ Filename 		: c_report_top_spender.php
 	+ Author  		: Isaac
	Edited by 		: Fred 
	
*/

//class of tindakan
class C_report_top_spender extends Controller {

	//constructor
	function C_report_top_spender(){
		parent::Controller();
		$this->load->model('m_report_top_spender', '', TRUE);
		$this->load->plugin('to_excel');
	}
	
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_report_top_spender');
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			/*case "LIST":
				$this->top_spender_list();
				break;*/
			/*case "LIST2":
				$this->top_spender_list2();
				break;*/
			/*case "UPDATE":
				$this->tindakan_update();
				break;*/
			/*case "CREATE":
				$this->tindakan_create();
				break;*/
			/*case "DELETE":
				$this->tindakan_delete();
				break;*/
			case "SEARCH":
				$this->top_spender_search();
				break;
			/*case "SEARCH2":
				$this->top_spender_search2();
				break;*/
			case "PRINT":
				$this->tindakan_print();
				break;
			case "EXCEL":
				$this->tindakan_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	

	//function for advanced search
	function top_spender_search(){
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

		//$trawat_dokter=trim(@$_POST["trawat_dokter"]);
		$top_jenis=trim(@$_POST["top_jenis"]);
		$top_jumlah=trim(@$_POST["top_jumlah"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		//$result = $this->m_report_top_spender->top_spender_search($trawat_id ,$trawat_tglapp_start ,$trawat_tglapp_end ,$trawat_dokter ,$start,$end);
		$result = $this->m_report_top_spender->top_spender_search($trawat_id ,$trawat_tglapp_start ,$trawat_tglapp_end ,$top_jenis,$top_jumlah ,$start,$end);
		echo $result;
	}


	function tindakan_print(){
  		//POST varibale here
		$trawat_id=trim(@$_POST["trawat_id"]);
		$trawat_cust=trim(@$_POST["trawat_cust"]);
		$trawat_keterangan=trim(@$_POST["trawat_keterangan"]);
		$trawat_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$trawat_keterangan);
		$trawat_keterangan=str_replace("'", "''",$trawat_keterangan);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$result = $this->m_tindakan_medis->tindakan_print($trawat_id ,$trawat_cust ,$trawat_keterangan ,$option,$filter);
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
	function tindakan_export_excel(){
		//POST varibale here
		$trawat_id=trim(@$_POST["trawat_id"]);
		//$trawat_dokter=trim(@$_POST["trawat_dokter"]);
		
		if(trim(@$_POST["trawat_tglapp_start"])!="")
			$trawat_tglapp_start=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_start"])));
		else
			$trawat_tglapp_start="";
		if(trim(@$_POST["trawat_tglapp_end"])!="")
			$trawat_tglapp_end=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_end"])));
		else
			$trawat_tglapp_end="";

		//$trawat_dokter=trim(@$_POST["trawat_dokter"]);
		$top_jenis=trim(@$_POST["top_jenis"]);
		$top_jumlah=trim(@$_POST["top_jumlah"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_report_top_spender->tindakan_export_excel($trawat_id, $trawat_tglapp_start ,$trawat_tglapp_end, $top_jenis ,$top_jumlah ,$option,$filter);

		to_excel($query,"top_spender"); 
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