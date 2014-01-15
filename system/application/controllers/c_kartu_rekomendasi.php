<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: tindakan Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_tindakan_medis.php
 	+ Author  		: masongbee
 	+ Created on 27/Oct/2009 14:21:34
	
*/

//class of tindakan
class C_kartu_rekomendasi extends Controller {

	//constructor
	function C_kartu_rekomendasi(){
		parent::Controller();
		$this->load->model('m_kartu_rekomendasi', '', TRUE);
		$this->load->plugin('to_excel');
	}
	
	function punya_paket_checking(){
		$this->m_kartu_rekomendasi->punya_paket_checking();
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_kartu_rekomendasi');
	}
	
	function get_customer_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_public_function->get_customer_list($query,$start,$end);
		echo $result;
	}
	
	function get_dokter_list(){
		//ID dokter pada tabel departemen adalah 8
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$tgl_app = isset($_POST['tgl_app']) ? $_POST['tgl_app'] : "";
		$result=$this->m_public_function->get_petugas_list($query,$tgl_app,"Dokter");
		echo $result;
	}
	
	function get_terapis_list(){
		//ID dokter pada tabel departemen adalah 9
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$tgl_app = isset($_POST['tgl_app']) ? $_POST['tgl_app'] : "";
		$result=$this->m_public_function->get_petugas_list($query,$tgl_app,"Therapist");
		echo $result;
	}
	
	function get_tindakan_medis_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : $_GET['query'];
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_public_function->get_tindakan_medis_list($query,$start,$end);
		echo $result;
	}
	
	//for detail action
	//list detail handler action
	function  detail_rekomendasi_detail_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_kartu_rekomendasi->detail_rekomendasi_detail_list($master_id,$query,$start,$end);
		echo $result;
	}
	//end of handler
	
	//purge all detail
	function detail_rekomendasi_medisdetail_purge(){
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_kartu_rekomendasi->detail_rekomendasi_medisdetail_purge($master_id);
	}
	//eof
	
	//get master id, note: not done yet
	function get_master_id(){
		$result=$this->m_kartu_rekomendasi->get_master_id();
		echo $result;
	}
	//
	
	//add detail
	function detail_rekomendasi_medisdetail_insert(){
	//POST variable here
		$drawatm_id=trim(@$_POST["drawatm_id"]);
		$drawatm_master=trim(@$_POST["drawatm_master"]);
		$drawatm_perawatan=trim(@$_POST["drawatm_perawatan"]);
		$drawatm_tanggal=trim(@$_POST["drawatm_tanggal"]);
		$drawatm_keterangan=trim(@$_POST["drawatm_keterangan"]);
		$drawatm_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$drawatm_keterangan);
		$drawatm_keterangan=str_replace("\\", "",$drawatm_keterangan);
		$result=$this->m_kartu_rekomendasi->detail_rekomendasi_medisdetail_insert($drawatm_id ,$drawatm_master ,$drawatm_perawatan, $drawatm_tanggal, $drawatm_keterangan);
		echo $result;
	}
	
	/* START NON-MEDIS Function */
	function  rekomendasi_nonmedis_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_kartu_rekomendasi->rekomendasi_nonmedis_list($master_id,$query,$start,$end);
		echo $result;
	}
	
	function get_nonmedis_in_rekomendasi_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : $_GET['query'];
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_kartu_rekomendasi->get_nonmedis_in_rekomendasi_list($query,$start,$end);
		echo $result;
	}
	
	function detail_rekomendasi_nonmedis_detail_purge(){
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_kartu_rekomendasi->detail_rekomendasi_nonmedis_detail_purge($master_id);
	}
	
	function rekomendasi_nonmedisdetail_insert(){
		$drawatn_id=trim(@$_POST["drawatn_id"]);
		$drawatn_master=trim(@$_POST["drawatn_master"]);
		$drawatn_perawatan=trim(@$_POST["drawatn_perawatan"]);
		$drawatn_tanggal=trim(@$_POST["drawatn_tanggal"]);
		$drawatn_keterangan=trim(@$_POST["drawatn_keterangan"]);
		$drawatn_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$drawatn_keterangan);
		$drawatn_keterangan=str_replace("\\", "",$drawatn_keterangan);
		$result=$this->m_kartu_rekomendasi->rekomendasi_nonmedisdetail_insert($drawatn_id ,$drawatn_master ,$drawatn_perawatan , $drawatn_tanggal, $drawatn_keterangan);
	}
	/* END NON-MEDIS Function */
	
	function get_produk_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_kartu_rekomendasi->get_produk_list($query,$start,$end);
		echo $result;
	}
	
	function detail_produk_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_kartu_rekomendasi->detail_produk_list($master_id,$query,$start,$end);
		echo $result;
	}
	
	function rekomendasi_produkdetail_insert(){
		$dproduk_id=trim(@$_POST["dproduk_id"]);
		$dproduk_master=trim(@$_POST["dproduk_master"]);
		$dproduk_produk=trim(@$_POST["dproduk_produk"]);
		$dproduk_tanggal=trim(@$_POST["dproduk_tanggal"]);
		$dproduk_keterangan=trim(@$_POST["dproduk_keterangan"]);
		$dproduk_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$dproduk_keterangan);
		$dproduk_keterangan=str_replace("\\", "",$dproduk_keterangan);
		
		$result=$this->m_kartu_rekomendasi->rekomendasi_produkdetail_insert($dproduk_id ,$dproduk_master ,$dproduk_produk , $dproduk_tanggal, $dproduk_keterangan);
	}

	function detail_produk_purge(){
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_kartu_rekomendasi->detail_produk_purge($master_id);
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->kartu_rekomendasi_list();
				break;
			case "UPDATE":
				$this->kartu_rekomendasi_update();
				break;
			case "CREATE":
				$this->kartu_rekomendasi_create();
				break;
			case "DELETE":
				$this->kartu_rekomendasi_delete();
				break;
			case "SEARCH":
				$this->kartu_rekomendasi_search();
				break;
			case "PRINT":
				$this->kartu_rekomendasi_print();
				break;
			case "EXCEL":
				$this->kartu_rekomendasi_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function kartu_rekomendasi_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_kartu_rekomendasi->kartu_rekomendasi_list($query,$start,$end);
		echo $result;
	}

	//function for update record
	function kartu_rekomendasi_update(){
		//POST variable here
		$card_id=trim(@$_POST["card_id"]);
		$card_cust=trim(@$_POST["card_cust"]);
		$card_keterangan=trim(@$_POST["card_keterangan"]);
		$card_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$card_keterangan);
		$card_keterangan=str_replace(",", "\,",$card_keterangan);
		$card_keterangan=str_replace("'", "''",$card_keterangan);
		$card_dokter=trim(@$_POST["card_dokter"]);
		$card_tgl=trim(@$_POST["card_tgl"]);
		$card_wl1=trim(@$_POST["card_wl1"]);
		$card_wl2=trim(@$_POST["card_wl2"]);
		$card_wl3=trim(@$_POST["card_wl3"]);
		$card_wl4=trim(@$_POST["card_wl4"]);
		$card_wl5=trim(@$_POST["card_wl5"]);
		$card_wl6=trim(@$_POST["card_wl6"]);
		$card_wl7=trim(@$_POST["card_wl7"]);
		$card_wl8=trim(@$_POST["card_wl8"]);
		$card_wl9=trim(@$_POST["card_wl9"]);
		$card_wl10=trim(@$_POST["card_wl10"]);
		$card_wl11=trim(@$_POST["card_wl11"]);
		$card_wl12=trim(@$_POST["card_wl12"]);
		$card_wl13=trim(@$_POST["card_wl13"]);
		$card_wl14=trim(@$_POST["card_wl14"]);
		$card_wl15=trim(@$_POST["card_wl15"]);
		$card_wl16=trim(@$_POST["card_wl16"]);
		$card_wl17=trim(@$_POST["card_wl17"]);
		$card_wl18=trim(@$_POST["card_wl18"]);
		$card_wl19=trim(@$_POST["card_wl19"]);
		$card_wl20=trim(@$_POST["card_wl20"]);
		$card_wl21=trim(@$_POST["card_wl21"]);
		$card_wl22=trim(@$_POST["card_wl22"]);
		$mode_edit=trim(@$_POST["mode_edit"]);
		$result = $this->m_kartu_rekomendasi->kartu_rekomendasi_update($card_id, $card_cust ,$card_keterangan ,$card_dokter ,$card_tgl, $card_wl1, $card_wl2, $card_wl3, $card_wl4, $card_wl5, $card_wl6, $card_wl7, $card_wl8, $card_wl9, $card_wl10, $card_wl11, $card_wl12, $card_wl13, $card_wl14, $card_wl15, $card_wl16, $card_wl17, $card_wl18, $card_wl19, $card_wl20, $card_wl21, $card_wl22, $mode_edit);
		echo $result;
	}
	
	//function for create new record
	function kartu_rekomendasi_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$card_cust=trim(@$_POST["card_cust"]);
		$card_dokter=trim(@$_POST["card_dokter"]);
		$card_keterangan=trim(@$_POST["card_keterangan"]);
		$card_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$card_keterangan);
		$card_keterangan=str_replace("'", "''",$card_keterangan);
		$card_wl1=trim(@$_POST["card_wl1"]);
		$card_wl2=trim(@$_POST["card_wl2"]);
		$card_wl3=trim(@$_POST["card_wl3"]);
		$card_wl4=trim(@$_POST["card_wl4"]);
		$card_wl5=trim(@$_POST["card_wl5"]);
		$card_wl6=trim(@$_POST["card_wl6"]);
		$card_wl7=trim(@$_POST["card_wl7"]);
		$card_wl8=trim(@$_POST["card_wl8"]);
		$card_wl9=trim(@$_POST["card_wl9"]);
		$card_wl10=trim(@$_POST["card_wl10"]);
		$card_wl11=trim(@$_POST["card_wl11"]);
		$card_wl12=trim(@$_POST["card_wl12"]);
		$card_wl13=trim(@$_POST["card_wl13"]);
		$card_wl14=trim(@$_POST["card_wl14"]);
		$card_wl15=trim(@$_POST["card_wl15"]);
		$card_wl16=trim(@$_POST["card_wl16"]);
		$card_wl17=trim(@$_POST["card_wl17"]);
		$card_wl18=trim(@$_POST["card_wl18"]);
		$card_wl19=trim(@$_POST["card_wl19"]);
		$card_wl20=trim(@$_POST["card_wl20"]);
		$card_wl21=trim(@$_POST["card_wl21"]);
		$card_wl22=trim(@$_POST["card_wl22"]);
		
		$result=$this->m_kartu_rekomendasi->kartu_rekomendasi_create($card_cust, $card_dokter, $card_keterangan, $card_wl1, $card_wl2, $card_wl3, $card_wl4, $card_wl5, $card_wl6, $card_wl7, $card_wl8, $card_wl9, $card_wl10, $card_wl11, $card_wl12, $card_wl13, $card_wl14, $card_wl15, $card_wl16, $card_wl17, $card_wl18, $card_wl19, $card_wl20, $card_wl21, $card_wl22);
		echo $result;
	}

	//function for delete selected record
	function kartu_rekomendasi_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_kartu_rekomendasi->kartu_rekomendasi_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function kartu_rekomendasi_search(){
		//POST varibale here
		$trawat_id=trim(@$_POST["trawat_id"]);
		$card_cust=trim(@$_POST["card_cust"]);
		if(trim(@$_POST["trawat_tglapp_start"])!="")
			$trawat_tglapp_start=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_start"])));
		else
			$trawat_tglapp_start="";
		if(trim(@$_POST["trawat_tglapp_end"])!="")
			$trawat_tglapp_end=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_end"])));
		else
			$trawat_tglapp_end="";
		$trawat_rawat=trim(@$_POST["trawat_rawat"]);
		$trawat_dokter=trim(@$_POST["trawat_dokter"]);
		$trawat_status=trim(@$_POST["trawat_status"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_kartu_rekomendasi->kartu_rekomendasi_search($trawat_id ,$card_cust ,$trawat_tglapp_start ,$trawat_tglapp_end ,$trawat_rawat ,$trawat_dokter ,$trawat_status ,$start,$end);
		echo $result;
	}


	function kartu_rekomendasi_print(){
  		//POST varibale here
		$trawat_id=trim(@$_POST["trawat_id"]);
		$card_cust=trim(@$_POST["card_cust"]);
		$card_keterangan=trim(@$_POST["card_keterangan"]);
		$card_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$card_keterangan);
		$card_keterangan=str_replace("'", "''",$card_keterangan);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$result = $this->m_kartu_rekomendasi->kartu_rekomendasi_print($trawat_id ,$card_cust ,$card_keterangan ,$option,$filter);
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
				fwrite($file, $data['card_cust']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['card_keterangan']);
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
	function kartu_rekomendasi_export_excel(){
		//POST varibale here
		$trawat_id=trim(@$_POST["trawat_id"]);
		$card_cust=trim(@$_POST["card_cust"]);
		$card_keterangan=trim(@$_POST["card_keterangan"]);
		$card_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$card_keterangan);
		$card_keterangan=str_replace("'", "''",$card_keterangan);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_kartu_rekomendasi->kartu_rekomendasi_export_excel($trawat_id ,$card_cust ,$card_keterangan ,$option,$filter);
		
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