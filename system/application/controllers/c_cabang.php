<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: cabang Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_cabang.php
 	+ Author  		: zainal, mukhlison
 	+ Created on 06/Aug/2009 15:46:36
	
*/

//class of cabang
class C_cabang extends Controller {

	//constructor
	function C_cabang(){
		parent::Controller();
		session_start();
		$this->load->model('m_cabang', '', TRUE);
		$this->load->plugin('to_excel');
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_cabang');
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->cabang_list();
				break;
			case "UPDATE":
				$this->cabang_update();
				break;
			case "CREATE":
				$this->cabang_create();
				break;
			case "DELETE":
				$this->cabang_delete();
				break;
			case "SEARCH":
				$this->cabang_search();
				break;
			case "PRINT":
				$this->cabang_print();
				break;
			case "EXCEL":
				$this->cabang_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function cabang_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);

		$result=$this->m_cabang->cabang_list($query,$start,$end);
		echo $result;
	}

	//function for update record
	function cabang_update(){
		//POST variable here
		$cabang_id=trim(@$_POST["cabang_id"]);
		$cabang_kode_akun=trim(@$_POST["cabang_kode_akun"]);
		$cabang_kode_akun=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_kode_akun);
		$cabang_kode_akun=str_replace(",", ",",$cabang_kode_akun);
		$cabang_kode_akun=str_replace("'", '"',$cabang_kode_akun);
		$cabang_kode=trim(@$_POST["cabang_kode"]);
		$cabang_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_kode);
		$cabang_kode=str_replace(",", ",",$cabang_kode);
		$cabang_kode=str_replace("'", '"',$cabang_kode);
		$cabang_nama=trim(@$_POST["cabang_nama"]);
		$cabang_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_nama);
		$cabang_nama=str_replace(",", ",",$cabang_nama);
		$cabang_nama=str_replace("'", '"',$cabang_nama);
		$cabang_alamat=trim(@$_POST["cabang_alamat"]);
		$cabang_alamat=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_alamat);
		$cabang_alamat=str_replace(",", ",",$cabang_alamat);
		$cabang_alamat=str_replace("'", '"',$cabang_alamat);
		$cabang_kota=trim(@$_POST["cabang_kota"]);
		$cabang_kota=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_kota);
		$cabang_kota=str_replace(",", ",",$cabang_kota);
		$cabang_kota=str_replace("'", '"',$cabang_kota);
		$cabang_kodepos=trim(@$_POST["cabang_kodepos"]);
		$cabang_kodepos=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_kodepos);
		$cabang_kodepos=str_replace(",", ",",$cabang_kodepos);
		$cabang_kodepos=str_replace("'", '"',$cabang_kodepos);
		$cabang_propinsi=trim(@$_POST["cabang_propinsi"]);
		$cabang_propinsi=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_propinsi);
		$cabang_propinsi=str_replace(",", ",",$cabang_propinsi);
		$cabang_propinsi=str_replace("'", '"',$cabang_propinsi);
		$cabang_keterangan=trim(@$_POST["cabang_keterangan"]);
		$cabang_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_keterangan);
		$cabang_keterangan=str_replace(",", ",",$cabang_keterangan);
		$cabang_keterangan=str_replace("'", '"',$cabang_keterangan);
		$cabang_aktif=trim(@$_POST["cabang_aktif"]);
		$cabang_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_aktif);
		$cabang_aktif=str_replace(",", ",",$cabang_aktif);
		$cabang_aktif=str_replace("'", '"',$cabang_aktif);
		$cabang_pajak=trim(@$_POST["cabang_pajak"]);
		$cabang_pajak=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_pajak);
		$cabang_pajak=str_replace(",", ",",$cabang_pajak);
		$cabang_pajak=str_replace("'", '"',$cabang_pajak);
		$result = $this->m_cabang->cabang_update($cabang_id ,$cabang_kode, $cabang_kode_akun,$cabang_nama ,$cabang_alamat ,$cabang_kota ,$cabang_kodepos ,$cabang_propinsi ,$cabang_keterangan ,$cabang_aktif,$cabang_pajak );
		echo $result;
	}
	
	//function for create new record
	function cabang_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$cabang_kode=trim(@$_POST["cabang_kode"]);
		$cabang_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_kode);
		$cabang_kode=str_replace("'", '"',$cabang_kode);
		$cabang_kode_akun=trim(@$_POST["cabang_kode_akun"]);
		$cabang_kode_akun=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_kode_akun);
		$cabang_kode_akun=str_replace("'", '"',$cabang_kode_akun);
		$cabang_nama=trim(@$_POST["cabang_nama"]);
		$cabang_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_nama);
		$cabang_nama=str_replace("'", '"',$cabang_nama);
		$cabang_alamat=trim(@$_POST["cabang_alamat"]);
		$cabang_alamat=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_alamat);
		$cabang_alamat=str_replace("'", '"',$cabang_alamat);
		$cabang_kota=trim(@$_POST["cabang_kota"]);
		$cabang_kota=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_kota);
		$cabang_kota=str_replace("'", '"',$cabang_kota);
		$cabang_kodepos=trim(@$_POST["cabang_kodepos"]);
		$cabang_kodepos=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_kodepos);
		$cabang_kodepos=str_replace("'", '"',$cabang_kodepos);
		$cabang_propinsi=trim(@$_POST["cabang_propinsi"]);
		$cabang_propinsi=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_propinsi);
		$cabang_propinsi=str_replace("'", '"',$cabang_propinsi);
		$cabang_keterangan=trim(@$_POST["cabang_keterangan"]);
		$cabang_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_keterangan);
		$cabang_keterangan=str_replace("'", '"',$cabang_keterangan);
		$cabang_aktif=trim(@$_POST["cabang_aktif"]);
		$cabang_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_aktif);
		$cabang_aktif=str_replace("'", '"',$cabang_aktif);
		$cabang_pajak=trim(@$_POST["cabang_pajak"]);
		$cabang_pajak=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_pajak);
		$cabang_pajak=str_replace(",", ",",$cabang_pajak);
		$cabang_pajak=str_replace("'", '"',$cabang_pajak);
		$result=$this->m_cabang->cabang_create($cabang_kode,$cabang_kode_akun,$cabang_nama ,$cabang_alamat ,$cabang_kota ,$cabang_kodepos ,$cabang_propinsi ,$cabang_keterangan ,$cabang_aktif,$cabang_pajak );
		echo $result;
	}

	//function for delete selected record
	function cabang_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_cabang->cabang_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function cabang_search(){
		//POST varibale here
		$cabang_id=trim(@$_POST["cabang_id"]);
		$cabang_nama=trim(@$_POST["cabang_nama"]);
		$cabang_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_nama);
		$cabang_nama=str_replace("'", '"',$cabang_nama);
		$cabang_alamat=trim(@$_POST["cabang_alamat"]);
		$cabang_alamat=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_alamat);
		$cabang_alamat=str_replace("'", '"',$cabang_alamat);
		$cabang_kota=trim(@$_POST["cabang_kota"]);
		$cabang_kota=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_kota);
		$cabang_kota=str_replace("'", '"',$cabang_kota);
		$cabang_kodepos=trim(@$_POST["cabang_kodepos"]);
		$cabang_kodepos=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_kodepos);
		$cabang_kodepos=str_replace("'", '"',$cabang_kodepos);
		$cabang_propinsi=trim(@$_POST["cabang_propinsi"]);
		$cabang_propinsi=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_propinsi);
		$cabang_propinsi=str_replace("'", '"',$cabang_propinsi);
		$cabang_keterangan=trim(@$_POST["cabang_keterangan"]);
		$cabang_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_keterangan);
		$cabang_keterangan=str_replace("'", '"',$cabang_keterangan);
		$cabang_aktif=trim(@$_POST["cabang_aktif"]);
		$cabang_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_aktif);
		$cabang_aktif=str_replace("'", '"',$cabang_aktif);
		$cabang_pajak=trim(@$_POST["cabang_pajak"]);
		$cabang_pajak=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_pajak);
		$cabang_pajak=str_replace(",", ",",$cabang_pajak);
		$cabang_pajak=str_replace("'", '"',$cabang_pajak);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_cabang->cabang_search($cabang_id ,$cabang_nama ,$cabang_alamat ,$cabang_kota ,$cabang_kodepos ,$cabang_propinsi ,$cabang_keterangan ,$cabang_aktif ,$start,$end,$cabang_pajak);
		echo $result;
	}


	function cabang_print(){
  		//POST varibale here
		$cabang_id=trim(@$_POST["cabang_id"]);
		$cabang_kode=trim(@$_POST["cabang_kode"]);
		$cabang_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_kode);
		$cabang_kode=str_replace("'", '"',$cabang_kode);
		$cabang_kode_akun=trim(@$_POST["cabang_kode_akun"]);
		$cabang_kode_akun=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_kode_akun);
		$cabang_kode_akun=str_replace("'", '"',$cabang_kode_akun);
		$cabang_nama=trim(@$_POST["cabang_nama"]);
		$cabang_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_nama);
		$cabang_nama=str_replace("'", '"',$cabang_nama);
		$cabang_alamat=trim(@$_POST["cabang_alamat"]);
		$cabang_alamat=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_alamat);
		$cabang_alamat=str_replace("'", '"',$cabang_alamat);
		$cabang_kota=trim(@$_POST["cabang_kota"]);
		$cabang_kota=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_kota);
		$cabang_kota=str_replace("'", '"',$cabang_kota);
		$cabang_kodepos=trim(@$_POST["cabang_kodepos"]);
		$cabang_kodepos=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_kodepos);
		$cabang_kodepos=str_replace("'", '"',$cabang_kodepos);
		$cabang_propinsi=trim(@$_POST["cabang_propinsi"]);
		$cabang_propinsi=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_propinsi);
		$cabang_propinsi=str_replace("'", '"',$cabang_propinsi);
		$cabang_keterangan=trim(@$_POST["cabang_keterangan"]);
		$cabang_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_keterangan);
		$cabang_keterangan=str_replace("'", '"',$cabang_keterangan);
		$cabang_aktif=trim(@$_POST["cabang_aktif"]);
		$cabang_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_aktif);
		$cabang_aktif=str_replace("'", '"',$cabang_aktif);
		$cabang_pajak=trim(@$_POST["cabang_pajak"]);
		$cabang_pajak=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_pajak);
		$cabang_pajak=str_replace(",", ",",$cabang_pajak);
		$cabang_pajak=str_replace("'", '"',$cabang_pajak);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$result = $this->m_cabang->cabang_print($cabang_id ,$cabang_kode,$cabang_kode_akun,$cabang_nama ,$cabang_alamat ,$cabang_kota ,$cabang_kodepos ,$cabang_propinsi ,$cabang_keterangan ,$cabang_aktif ,$option,$filter,$cabang_pajak);
		$nbrows=$result->num_rows();
		$totcolumn=12;
   		/* We now have our array, let's build our HTML file */
		$file = fopen("cabanglist.html",'w');
		fwrite($file, "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Printing the Cabang Grid</title><link rel='stylesheet' type='text/css' href='assets/modules/main/css/printstyle.css'/></head>");
		fwrite($file, "<body onload='window.print()'><table summary='Cabang List'><caption>DAFTAR CABANG</caption><thead><tr><th scope='col'>No</th><th scope='col'>Nama</th><th scope='col'>Alamat</th><th scope='col'>Kota</th><th scope='col'>Kode Pos</th><th scope='col'>Propinsi</th><th scope='col'>Keterangan</th><th scope='col'>Aktif</th></tr></thead><tfoot><tr><th scope='row'>Total</th><td colspan='$totcolumn'>");
		fwrite($file, $nbrows);
		fwrite($file, " Cabang</td></tr></tfoot><tbody>");
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
				fwrite($file, $data['cabang_nama']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['cabang_alamat']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['cabang_kota']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['cabang_kodepos']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['cabang_propinsi']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['cabang_keterangan']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['cabang_aktif']);
				fwrite($file, "</td></tr>");
			}
		}
		fwrite($file, "</tbody></table></body></html>");	
		fclose($file);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function cabang_export_excel(){
		//POST varibale here
		$cabang_id=trim(@$_POST["cabang_id"]);
		$cabang_kode=trim(@$_POST["cabang_kode"]);
		$cabang_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_kode);
		$cabang_kode=str_replace("'", '"',$cabang_kode);
		$cabang_kode_akun=trim(@$_POST["cabang_kode_akun"]);
		$cabang_kode_akun=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_kode_akun);
		$cabang_kode_akun=str_replace("'", '"',$cabang_kode_akun);
		$cabang_nama=trim(@$_POST["cabang_nama"]);
		$cabang_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_nama);
		$cabang_nama=str_replace("'", '"',$cabang_nama);
		$cabang_alamat=trim(@$_POST["cabang_alamat"]);
		$cabang_alamat=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_alamat);
		$cabang_alamat=str_replace("'", '"',$cabang_alamat);
		$cabang_kota=trim(@$_POST["cabang_kota"]);
		$cabang_kota=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_kota);
		$cabang_kota=str_replace("'", '"',$cabang_kota);
		$cabang_kodepos=trim(@$_POST["cabang_kodepos"]);
		$cabang_kodepos=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_kodepos);
		$cabang_kodepos=str_replace("'", '"',$cabang_kodepos);
		$cabang_propinsi=trim(@$_POST["cabang_propinsi"]);
		$cabang_propinsi=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_propinsi);
		$cabang_propinsi=str_replace("'", '"',$cabang_propinsi);
		$cabang_keterangan=trim(@$_POST["cabang_keterangan"]);
		$cabang_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_keterangan);
		$cabang_keterangan=str_replace("'", '"',$cabang_keterangan);
		$cabang_aktif=trim(@$_POST["cabang_aktif"]);
		$cabang_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_aktif);
		$cabang_aktif=str_replace("'", '"',$cabang_aktif);
		$cabang_pajak=trim(@$_POST["cabang_pajak"]);
		$cabang_pajak=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_pajak);
		$cabang_pajak=str_replace(",", ",",$cabang_pajak);
		$cabang_pajak=str_replace("'", '"',$cabang_pajak);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_cabang->cabang_export_excel($cabang_id ,$cabang_kode,$cabang_kode_akun,$cabang_nama ,$cabang_alamat ,$cabang_kota ,$cabang_kodepos ,$cabang_propinsi ,$cabang_keterangan ,$cabang_aktif ,$option,$filter,$cabang_pajak);
		
		to_excel($query,"cabang"); 
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