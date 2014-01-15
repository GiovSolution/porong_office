<?php
/* 
	GIOV Solution - Keep IT Simple
*/

//class of bank
class c_daftar_hutang extends Controller {

	//constructor
	function c_daftar_hutang(){
		parent::Controller();
		session_start();
		$this->load->model('m_daftar_hutang', '', TRUE);
		$this->load->plugin('to_excel');
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_daftar_hutang');
	}
	
	function get_mbank_list(){
		$result=$this->m_public_function->get_mbank_list();
		echo $result;
	}
	
	function get_akun_list(){
		$result=$this->m_daftar_hutang->get_akun_list();
		echo $result;
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->daftar_hutang_list();
				break;
			case "UPDATE":
				$this->hutang_update();
				break;
			case "CREATE":
				$this->bank_create();
				break;
			case "DELETE":
				$this->bank_delete();
				break;
			case "SEARCH":
				$this->bank_search();
				break;
			case "PRINT":
				$this->bank_print();
				break;
			case "EXCEL":
				$this->bank_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	// ini store ketika event di klik, tampil di columnmodel bagian depannya
	function detail_list_hutang_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$supplier_id = (integer) (isset($_POST['supplier_id']) ? $_POST['supplier_id'] : $_GET['supplier_id']);
		$result=$this->m_daftar_hutang->detail_list_hutang_list($master_id, $supplier_id, $query,$start,$end);
		echo $result;
	}
	
	//function fot list record
	function daftar_hutang_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);

		$result=$this->m_daftar_hutang->daftar_hutang_list($query,$start,$end);
		echo $result;
	}

	//function for update record
	function hutang_update(){
		//POST variable here
		$hutang_order_id=trim(@$_POST["hutang_order_id"]);
		$hutang_supplier=trim(@$_POST["hutang_supplier"]);
		$hutang_tanggal=trim(@$_POST["hutang_tanggal"]);
		$hutang_tanggal_jatuh_tempo=trim(@$_POST["hutang_tanggal_jatuh_tempo"]);
		$hutang_order_faktur=trim(@$_POST["hutang_order_faktur"]);
		$hutang_order_faktur=str_replace("/(<\/?)(p)([^>]*>)", "",$hutang_order_faktur);
		$hutang_order_faktur=str_replace("'", '"',$hutang_order_faktur);
		$hutang_invoice=trim(@$_POST["hutang_invoice"]);
		$hutang_invoice=str_replace("/(<\/?)(p)([^>]*>)", "",$hutang_invoice);
		$hutang_invoice=str_replace("'", '"',$hutang_invoice);
		$hutang_keterangan=trim(@$_POST["hutang_keterangan"]);
		$hutang_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$hutang_keterangan);
		$hutang_keterangan=str_replace("'", '"',$hutang_keterangan);
		$hutang_status=trim(@$_POST["hutang_status"]);
		$hutang_status=str_replace("/(<\/?)(p)([^>]*>)", "",$hutang_status);
		$hutang_status=str_replace("'", '"',$hutang_status);
		$hutang_status_hutang=trim(@$_POST["hutang_status_hutang"]);
		$hutang_status_hutang=str_replace("/(<\/?)(p)([^>]*>)", "",$hutang_status_hutang);
		$hutang_status_hutang=str_replace("'", '"',$hutang_status_hutang);
		$hutang_total=trim(@$_POST["hutang_total"]);
		$result = $this->m_daftar_hutang->hutang_update($hutang_order_id ,$hutang_order_faktur , $hutang_supplier , $hutang_tanggal ,$hutang_tanggal_jatuh_tempo ,$hutang_keterangan,$hutang_invoice ,$hutang_status ,$hutang_status_hutang ,$hutang_total);
		echo $result;
	}
	
	//function for create new record
	function bank_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		/*
		$bank_kode=trim(@$_POST["bank_kode"]);
		$bank_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_kode);
		$bank_kode=str_replace("'", '"',$bank_kode);
		$bank_nama=trim(@$_POST["bank_nama"]);
		$bank_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_nama);
		$bank_nama=str_replace("'", '"',$bank_nama);
		$bank_norek=trim(@$_POST["bank_norek"]);
		$bank_norek=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_norek);
		$bank_norek=str_replace("'", '"',$bank_norek);
		*/
		$ship_nama=trim(@$_POST["ship_nama"]);
		$ship_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$ship_nama);
		$ship_nama=str_replace("'", '"',$ship_nama);
		//$bank_saldo=trim(@$_POST["bank_saldo"]);
		$ship_keterangan=trim(@$_POST["ship_keterangan"]);
		$ship_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$ship_keterangan);
		$ship_keterangan=str_replace("'", '"',$ship_keterangan);
		$ship_aktif=trim(@$_POST["ship_aktif"]);
		$ship_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$ship_aktif);
		$ship_aktif=str_replace("'", '"',$ship_aktif);
		
		$ship_creator=trim(@$_POST["ship_creator"]);
		$ship_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$ship_creator);
		$ship_creator=str_replace("'", '"',$ship_creator);
		$ship_date_create=trim(@$_POST["ship_date_create"]);
		$ship_update=trim(@$_POST["ship_update"]);
		$ship_update=str_replace("/(<\/?)(p)([^>]*>)", "",$ship_update);
		$ship_update=str_replace("'", '"',$ship_update);
		$ship_date_update=trim(@$_POST["ship_date_update"]);
		$ship_revised=trim(@$_POST["ship_revised"]);
		$result=$this->m_daftar_hutang->ship_create($ship_nama, $ship_keterangan ,$ship_aktif ,$ship_creator ,$ship_date_create ,$ship_update ,$ship_date_update ,$ship_revised );
		echo $result;
	}

	//function for delete selected record
	function bank_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_daftar_hutang->bank_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function bank_search(){
		//POST varibale here
		$bank_id=trim(@$_POST["bank_id"]);
		$bank_kode=trim(@$_POST["bank_kode"]);
		$bank_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_kode);
		$bank_kode=str_replace("'", '"',$bank_kode);
		$bank_nama=trim(@$_POST["bank_nama"]);
		$bank_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_nama);
		$bank_nama=str_replace("'", '"',$bank_nama);
		$bank_norek=trim(@$_POST["bank_norek"]);
		$bank_norek=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_norek);
		$bank_norek=str_replace("'", '"',$bank_norek);
		$bank_atasnama=trim(@$_POST["bank_atasnama"]);
		$bank_atasnama=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_atasnama);
		$bank_atasnama=str_replace("'", '"',$bank_atasnama);
		$bank_saldo=trim(@$_POST["bank_saldo"]);
		$bank_keterangan=trim(@$_POST["bank_keterangan"]);
		$bank_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_keterangan);
		$bank_keterangan=str_replace("'", '"',$bank_keterangan);
		$bank_aktif=trim(@$_POST["bank_aktif"]);
		$bank_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_aktif);
		$bank_aktif=str_replace("'", '"',$bank_aktif);
		$bank_creator=trim(@$_POST["bank_creator"]);
		$bank_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_creator);
		$bank_creator=str_replace("'", '"',$bank_creator);
		$bank_date_create=trim(@$_POST["bank_date_create"]);
		$bank_update=trim(@$_POST["bank_update"]);
		$bank_update=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_update);
		$bank_update=str_replace("'", '"',$bank_update);
		$bank_date_update=trim(@$_POST["bank_date_update"]);
		$bank_revised=trim(@$_POST["bank_revised"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_daftar_hutang->bank_search($bank_id ,$bank_kode ,$bank_nama ,$bank_norek ,$bank_atasnama ,$bank_saldo ,$bank_keterangan ,$bank_aktif ,$bank_creator ,$bank_date_create ,$bank_update ,$bank_date_update ,$bank_revised ,$start,$end);
		echo $result;
	}


	function bank_print(){
  		//POST varibale here
		$bank_id=trim(@$_POST["bank_id"]);
		$bank_kode=trim(@$_POST["bank_kode"]);
		$bank_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_kode);
		$bank_kode=str_replace("'", '"',$bank_kode);
		$bank_nama=trim(@$_POST["bank_nama"]);
		$bank_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_nama);
		$bank_nama=str_replace("'", '"',$bank_nama);
		$bank_norek=trim(@$_POST["bank_norek"]);
		$bank_norek=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_norek);
		$bank_norek=str_replace("'", '"',$bank_norek);
		$bank_atasnama=trim(@$_POST["bank_atasnama"]);
		$bank_atasnama=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_atasnama);
		$bank_atasnama=str_replace("'", '"',$bank_atasnama);
		$bank_saldo=trim(@$_POST["bank_saldo"]);
		$bank_keterangan=trim(@$_POST["bank_keterangan"]);
		$bank_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_keterangan);
		$bank_keterangan=str_replace("'", '"',$bank_keterangan);
		$bank_aktif=trim(@$_POST["bank_aktif"]);
		$bank_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_aktif);
		$bank_aktif=str_replace("'", '"',$bank_aktif);
		$bank_creator=trim(@$_POST["bank_creator"]);
		$bank_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_creator);
		$bank_creator=str_replace("'", '"',$bank_creator);
		$bank_date_create=trim(@$_POST["bank_date_create"]);
		$bank_update=trim(@$_POST["bank_update"]);
		$bank_update=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_update);
		$bank_update=str_replace("'", '"',$bank_update);
		$bank_date_update=trim(@$_POST["bank_date_update"]);
		$bank_revised=trim(@$_POST["bank_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$result = $this->m_daftar_hutang->bank_print($bank_id ,$bank_kode ,$bank_nama ,$bank_norek ,$bank_atasnama ,$bank_saldo ,$bank_keterangan ,$bank_aktif ,$bank_creator ,$bank_date_create ,$bank_update ,$bank_date_update ,$bank_revised ,$option,$filter);
		$nbrows=$result->num_rows();
		$totcolumn=13;
   		/* We now have our array, let's build our HTML file */
		$file = fopen("banklist.html",'w');
		fwrite($file, "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Printing the Rekening Grid</title><link rel='stylesheet' type='text/css' href='assets/modules/main/css/printstyle.css'/></head>");
		fwrite($file, "<body onload='window.print()'><table summary='Bank List'><caption>DAFTAR REKENING</caption><thead><tr><th scope='col'>No</th><th scope='col'>Kode</th><th scope='col'>Nama</th><th scope='col'>No.Rekening</th><th scope='col'>Atas Nama</th><th scope='col'>Saldo</th><th scope='col'>Keterangan</th><th scope='col'>Aktif</th></tr></thead><tfoot><tr><th scope='row'>Total</th><td colspan='$totcolumn'>");
		fwrite($file, $nbrows);
		fwrite($file, " Bank</td></tr></tfoot><tbody>");
		$i=0;
		if($nbrows>0){
			foreach($result->result_array() as $data){
				$i++;
				fwrite($file,'<tr');
				if($i%1==0){
					fwrite($file," class='odd'");
				}
			
				fwrite($file, "><th scope='row' id='r97'>");
				fwrite($file, $i);
				fwrite($file,"</th><td>");
				fwrite($file, $data['bank_kode']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['mbank_nama']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['bank_norek']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['bank_atasnama']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['bank_saldo']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['bank_keterangan']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['bank_aktif']);
				// fwrite($file,"</td><td>");
				// fwrite($file, $data['bank_creator']);
				// fwrite($file,"</td><td>");
				// fwrite($file, $data['bank_date_create']);
				// fwrite($file,"</td><td>");
				// fwrite($file, $data['bank_update']);
				// fwrite($file,"</td><td>");
				// fwrite($file, $data['bank_date_update']);
				// fwrite($file,"</td><td>");
				// fwrite($file, $data['bank_revised']);
				fwrite($file, "</td></tr>");
			}
		}
		fwrite($file, "</tbody></table></body></html>");	
		fclose($file);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function bank_export_excel(){
		//POST varibale here
		$bank_id=trim(@$_POST["bank_id"]);
		$bank_kode=trim(@$_POST["bank_kode"]);
		$bank_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_kode);
		$bank_kode=str_replace("'", '"',$bank_kode);
		$bank_nama=trim(@$_POST["bank_nama"]);
		$bank_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_nama);
		$bank_nama=str_replace("'", '"',$bank_nama);
		$bank_norek=trim(@$_POST["bank_norek"]);
		$bank_norek=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_norek);
		$bank_norek=str_replace("'", '"',$bank_norek);
		$bank_atasnama=trim(@$_POST["bank_atasnama"]);
		$bank_atasnama=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_atasnama);
		$bank_atasnama=str_replace("'", '"',$bank_atasnama);
		$bank_saldo=trim(@$_POST["bank_saldo"]);
		$bank_keterangan=trim(@$_POST["bank_keterangan"]);
		$bank_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_keterangan);
		$bank_keterangan=str_replace("'", '"',$bank_keterangan);
		$bank_aktif=trim(@$_POST["bank_aktif"]);
		$bank_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_aktif);
		$bank_aktif=str_replace("'", '"',$bank_aktif);
		$bank_creator=trim(@$_POST["bank_creator"]);
		$bank_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_creator);
		$bank_creator=str_replace("'", '"',$bank_creator);
		$bank_date_create=trim(@$_POST["bank_date_create"]);
		$bank_update=trim(@$_POST["bank_update"]);
		$bank_update=str_replace("/(<\/?)(p)([^>]*>)", "",$bank_update);
		$bank_update=str_replace("'", '"',$bank_update);
		$bank_date_update=trim(@$_POST["bank_date_update"]);
		$bank_revised=trim(@$_POST["bank_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_daftar_hutang->bank_export_excel($bank_id ,$bank_kode ,$bank_nama ,$bank_norek ,$bank_atasnama ,$bank_saldo ,$bank_keterangan ,$bank_aktif ,$bank_creator ,$bank_date_create ,$bank_update ,$bank_date_update ,$bank_revised ,$option,$filter);
		
		to_excel($query,"bank"); 
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
	
	// Encodes a YYYY-MM-DD into a MM-DD-YYYY string
	function codeDate ($date) {
	  $tab = explode ("-", $date);
	  $r = $tab[1]."/".$tab[2]."/".$tab[0];
	  return $r;
	}
	
}
?>