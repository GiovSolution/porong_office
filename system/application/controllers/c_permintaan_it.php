<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: gudang Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_gudang.php
 	+ Author  		: Zainal, Mukhlison
 	+ Created on 11/Jul/2009 06:46:58
	
*/

//class of gudang
class c_permintaan_it extends Controller {

	//constructor
	function c_permintaan_it(){
		parent::Controller();
		session_start();
		$this->load->model('m_permintaan_it', '', TRUE);
		$this->load->plugin('to_excel');
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_permintaan_it');
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->permintaan_list();
				break;
			case "UPDATE":
				$this->permintaan_update();
				break;
			case "CREATE":
				$this->permintaan_create();
				break;
			case "DELETE":
				$this->gudang_delete();
				break;
			case "SEARCH":
				$this->permintaan_search();
				break;
			case "PRINT":
				$this->gudang_print();
				break;
			case "EXCEL":
				$this->gudang_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function permintaan_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);

		$result=$this->m_permintaan_it->permintaan_list($query,$start,$end);
		echo $result;
	}
	
	function get_cabang_list(){
		$result=$this->m_permintaan_it->get_cabang_list();
		echo $result;
	}
	
	function get_karyawan_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_public_function->get_karyawan_list($query,$start,$end);
		echo $result;
	}
	
	function get_user_login(){
		$result=$this->m_permintaan_it->get_user_login();
		echo $result;
	}
	
	//list detail handler action
	
	function  detail_catatan_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_permintaan_it->detail_catatan_list($master_id,$query,$start,$end);
		echo $result;
	}
	
	//end of handler
	
	//add detail
	function detail_catatan_insert(){
		//POST variable here
		$dcatatan_id = $_POST['dcatatan_id']; // Get our array back and translate it :
		$array_dcatatan_id = json_decode(stripslashes($dcatatan_id));
		
		$dcatatan_master=trim(@$_POST["dcatatan_master"]);
		
		$dcatatan_tanggal = $_POST['dcatatan_tanggal']; // Get our array back and translate it :
		$array_dcatatan_tanggal = json_decode(stripslashes($dcatatan_tanggal));
		
		$dcatatan_user = $_POST['dcatatan_user']; // Get our array back and translate it :
		$array_dcatatan_user = json_decode(stripslashes($dcatatan_user));
		
		$dcatatan_isi = $_POST['dcatatan_isi']; // Get our array back and translate it :
		$array_dcatatan_isi = json_decode(stripslashes($dcatatan_isi));
		/*
		$dpaket_jumlah = $_POST['dpaket_jumlah']; // Get our array back and translate it :
		$array_dpaket_jumlah = json_decode(stripslashes($dpaket_jumlah));
		
		$dpaket_harga = $_POST['dpaket_harga']; // Get our array back and translate it :
		$array_dpaket_harga = json_decode(stripslashes($dpaket_harga));
		
		$dpaket_diskon_jenis = $_POST['dpaket_diskon_jenis']; // Get our array back and translate it :
		$array_dpaket_diskon_jenis = json_decode(stripslashes($dpaket_diskon_jenis));
		
		$dpaket_diskon = $_POST['dpaket_diskon']; // Get our array back and translate it :
		$array_dpaket_diskon = json_decode(stripslashes($dpaket_diskon));
		
		$dpaket_sales = $_POST['dpaket_sales']; // Get our array back and translate it :
		$array_dpaket_sales = json_decode(stripslashes($dpaket_sales));
		
		$cetak=trim(@$_POST['cetak']);
		*/
		
		$result=$this->m_permintaan_it->detail_catatan_insert($array_dcatatan_id ,$dcatatan_master ,$array_dcatatan_tanggal, $array_dcatatan_user, $array_dcatatan_isi);
		echo $result;
	}

	//function for update record
	function permintaan_update(){
		//POST variable here
		
		$permintaan_id=trim(@$_POST["permintaan_id"]);
		$permintaan_client=trim(@$_POST["permintaan_client"]);
		//$permintaan_cabang_id=trim(@$_POST["permintaan_cabang_id"]);
		$permintaan_nama=trim(@$_POST["permintaan_nama"]);
		$permintaan_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$permintaan_nama);
		$permintaan_nama=str_replace("'", '"',$permintaan_nama);
		$permintaan_cabang=trim(@$_POST["permintaan_cabang"]);
		//$permintaan_cabang=str_replace("/(<\/?)(p)([^>]*>)", "",$permintaan_cabang);
		//$permintaan_cabang=str_replace("'", '"',$permintaan_cabang);
		$permintaan_tanggalmasalah=trim(@$_POST["permintaan_tanggalmasalah"]);
		$permintaan_tipe=trim(@$_POST["permintaan_tipe"]);
		$permintaan_tipe=str_replace("/(<\/?)(p)([^>]*>)", "",$permintaan_tipe);
		$permintaan_tipe=str_replace("'", '"',$permintaan_tipe);
		$permintaan_tipe2=trim(@$_POST["permintaan_tipe2"]);
		$permintaan_tipe2=str_replace("/(<\/?)(p)([^>]*>)", "",$permintaan_tipe2);
		$permintaan_tipe2=str_replace("'", '"',$permintaan_tipe2);
		$permintaan_tipe3=trim(@$_POST["permintaan_tipe3"]);
		$permintaan_tipe3=str_replace("/(<\/?)(p)([^>]*>)", "",$permintaan_tipe3);
		$permintaan_tipe3=str_replace("'", '"',$permintaan_tipe3);
		$permintaan_judul=trim(@$_POST["permintaan_judul"]);
		$permintaan_judul=str_replace("/(<\/?)(p)([^>]*>)", "",$permintaan_judul);
		$permintaan_judul=str_replace("'", '"',$permintaan_judul);
		$permintaan_permintaan=trim(@$_POST["permintaan_permintaan"]);
		$permintaan_permintaan=str_replace("/(<\/?)(p)([^>]*>)", "",$permintaan_permintaan);
		$permintaan_permintaan=str_replace("'", '"',$permintaan_permintaan);
		$permintaan_prioritas=trim(@$_POST["permintaan_prioritas"]);
		$permintaan_prioritas=str_replace("/(<\/?)(p)([^>]*>)", "",$permintaan_prioritas);
		$permintaan_prioritas=str_replace("'", '"',$permintaan_prioritas);
		$permintaan_mengetahui=trim(@$_POST["permintaan_mengetahui"]);
		$permintaan_mengetahui=str_replace("/(<\/?)(p)([^>]*>)", "",$permintaan_mengetahui);
		$permintaan_mengetahui=str_replace("'", '"',$permintaan_mengetahui);
		
		$permintaan_mengetahuistatus=trim(@$_POST["permintaan_mengetahuistatus"]);
		$permintaan_mengetahuistatus=str_replace("/(<\/?)(p)([^>]*>)", "",$permintaan_mengetahuistatus);
		$permintaan_mengetahuistatus=str_replace("'", '"',$permintaan_mengetahuistatus);
		$permintaan_mengetahuiketerangan=trim(@$_POST["permintaan_mengetahuiketerangan"]);
		$permintaan_mengetahuiketerangan=str_replace("/(<\/?)(p)([^>]*>)", "",$permintaan_mengetahuiketerangan);
		$permintaan_mengetahuiketerangan=str_replace("'", '"',$permintaan_mengetahuiketerangan);
		$permintaan_mengetahuistatus2=trim(@$_POST["permintaan_mengetahuistatus2"]);
		$permintaan_mengetahuistatus2=str_replace("/(<\/?)(p)([^>]*>)", "",$permintaan_mengetahuistatus2);
		$permintaan_mengetahuistatus2=str_replace("'", '"',$permintaan_mengetahuistatus2);
		$permintaan_mengetahuiketerangan2=trim(@$_POST["permintaan_mengetahuiketerangan2"]);
		$permintaan_mengetahuiketerangan2=str_replace("/(<\/?)(p)([^>]*>)", "",$permintaan_mengetahuiketerangan2);
		$permintaan_mengetahuiketerangan2=str_replace("'", '"',$permintaan_mengetahuiketerangan2);
		
		$permintaan_mengetahui2=trim(@$_POST["permintaan_mengetahui2"]);
		$permintaan_mengetahui2=str_replace("/(<\/?)(p)([^>]*>)", "",$permintaan_mengetahui2);
		$permintaan_mengetahui2=str_replace("'", '"',$permintaan_mengetahui2);
		$permintaan_penyelesaian=trim(@$_POST["permintaan_penyelesaian"]);
		$permintaan_penyelesaian=str_replace("/(<\/?)(p)([^>]*>)", "",$permintaan_penyelesaian);
		$permintaan_penyelesaian=str_replace("'", '"',$permintaan_penyelesaian);
		$permintaan_status=trim(@$_POST["permintaan_status"]);
		$permintaan_status=str_replace("/(<\/?)(p)([^>]*>)", "",$permintaan_status);
		$permintaan_status=str_replace("'", '"',$permintaan_status);
		$permintaan_tanggalselesai=trim(@$_POST["permintaan_tanggalselesai"]);
		
		$result=$this->m_permintaan_it->permintaan_update($permintaan_id, $permintaan_client, $permintaan_nama ,$permintaan_cabang ,$permintaan_tanggalmasalah ,$permintaan_tipe,$permintaan_tipe2,$permintaan_tipe3 ,$permintaan_judul ,$permintaan_permintaan ,$permintaan_prioritas, $permintaan_mengetahui, $permintaan_mengetahuistatus, $permintaan_mengetahuiketerangan, $permintaan_mengetahuistatus2, $permintaan_mengetahuiketerangan2, $permintaan_mengetahui2 ,$permintaan_penyelesaian ,$permintaan_status, $permintaan_tanggalselesai );
		echo $result;
	}
	
	//function for create new record
	function permintaan_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$permintaan_nama=trim(@$_POST["permintaan_nama"]);
		$permintaan_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$permintaan_nama);
		$permintaan_nama=str_replace("'", '"',$permintaan_nama);
		$permintaan_cabang=trim(@$_POST["permintaan_cabang"]);
		//$permintaan_cabang=str_replace("/(<\/?)(p)([^>]*>)", "",$permintaan_cabang);
		//$permintaan_cabang=str_replace("'", '"',$permintaan_cabang);
		$permintaan_tanggalmasalah=trim(@$_POST["permintaan_tanggalmasalah"]);
		$permintaan_tipe=trim(@$_POST["permintaan_tipe"]);
		$permintaan_tipe=str_replace("/(<\/?)(p)([^>]*>)", "",$permintaan_tipe);
		$permintaan_tipe=str_replace("'", '"',$permintaan_tipe);
		$permintaan_tipe2=trim(@$_POST["permintaan_tipe2"]);
		$permintaan_tipe2=str_replace("/(<\/?)(p)([^>]*>)", "",$permintaan_tipe2);
		$permintaan_tipe2=str_replace("'", '"',$permintaan_tipe2);
		$permintaan_tipe3=trim(@$_POST["permintaan_tipe3"]);
		$permintaan_tipe3=str_replace("/(<\/?)(p)([^>]*>)", "",$permintaan_tipe3);
		$permintaan_tipe3=str_replace("'", '"',$permintaan_tipe3);
		$permintaan_judul=trim(@$_POST["permintaan_judul"]);
		$permintaan_judul=str_replace("/(<\/?)(p)([^>]*>)", "",$permintaan_judul);
		$permintaan_judul=str_replace("'", '"',$permintaan_judul);
		$permintaan_permintaan=trim(@$_POST["permintaan_permintaan"]);
		$permintaan_permintaan=str_replace("/(<\/?)(p)([^>]*>)", "",$permintaan_permintaan);
		$permintaan_permintaan=str_replace("'", '"',$permintaan_permintaan);
		$permintaan_prioritas=trim(@$_POST["permintaan_prioritas"]);
		$permintaan_prioritas=str_replace("/(<\/?)(p)([^>]*>)", "",$permintaan_prioritas);
		$permintaan_prioritas=str_replace("'", '"',$permintaan_prioritas);
		$permintaan_mengetahui=trim(@$_POST["permintaan_mengetahui"]);
		$permintaan_mengetahui=str_replace("/(<\/?)(p)([^>]*>)", "",$permintaan_mengetahui);
		$permintaan_mengetahui=str_replace("'", '"',$permintaan_mengetahui);
		
		$permintaan_mengetahuistatus=trim(@$_POST["permintaan_mengetahuistatus"]);
		$permintaan_mengetahuistatus=str_replace("/(<\/?)(p)([^>]*>)", "",$permintaan_mengetahuistatus);
		$permintaan_mengetahuistatus=str_replace("'", '"',$permintaan_mengetahuistatus);
		$permintaan_mengetahuiketerangan=trim(@$_POST["permintaan_mengetahuiketerangan"]);
		$permintaan_mengetahuiketerangan=str_replace("/(<\/?)(p)([^>]*>)", "",$permintaan_mengetahuiketerangan);
		$permintaan_mengetahuiketerangan=str_replace("'", '"',$permintaan_mengetahuiketerangan);
		$permintaan_mengetahuistatus2=trim(@$_POST["permintaan_mengetahuistatus2"]);
		$permintaan_mengetahuistatus2=str_replace("/(<\/?)(p)([^>]*>)", "",$permintaan_mengetahuistatus2);
		$permintaan_mengetahuistatus2=str_replace("'", '"',$permintaan_mengetahuistatus2);
		$permintaan_mengetahuiketerangan2=trim(@$_POST["permintaan_mengetahuiketerangan2"]);
		$permintaan_mengetahuiketerangan2=str_replace("/(<\/?)(p)([^>]*>)", "",$permintaan_mengetahuiketerangan2);
		$permintaan_mengetahuiketerangan2=str_replace("'", '"',$permintaan_mengetahuiketerangan2);
		
		$permintaan_mengetahui2=trim(@$_POST["permintaan_mengetahui2"]);
		$permintaan_mengetahui2=str_replace("/(<\/?)(p)([^>]*>)", "",$permintaan_mengetahui2);
		$permintaan_mengetahui2=str_replace("'", '"',$permintaan_mengetahui2);
		$permintaan_penyelesaian=trim(@$_POST["permintaan_penyelesaian"]);
		$permintaan_penyelesaian=str_replace("/(<\/?)(p)([^>]*>)", "",$permintaan_penyelesaian);
		$permintaan_penyelesaian=str_replace("'", '"',$permintaan_penyelesaian);
		$permintaan_status=trim(@$_POST["permintaan_status"]);
		$permintaan_status=str_replace("/(<\/?)(p)([^>]*>)", "",$permintaan_status);
		$permintaan_status=str_replace("'", '"',$permintaan_status);
		$permintaan_tanggalselesai=trim(@$_POST["permintaan_tanggalselesai"]);

		$result=$this->m_permintaan_it->permintaan_create($permintaan_nama ,$permintaan_cabang ,$permintaan_tanggalmasalah ,$permintaan_tipe,$permintaan_tipe2,$permintaan_tipe3,$permintaan_judul ,$permintaan_permintaan ,$permintaan_prioritas , $permintaan_mengetahui, $permintaan_mengetahuistatus, $permintaan_mengetahuiketerangan, $permintaan_mengetahuistatus2, $permintaan_mengetahuiketerangan2, $permintaan_mengetahui2, $permintaan_penyelesaian ,$permintaan_status, $permintaan_tanggalselesai );
		echo $result;
	}

	//function for delete selected record
	function gudang_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_gudang->gudang_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function permintaan_search(){
		//POST varibale here
		$permintaan_nama=trim(@$_POST["permintaan_nama"]);
		$permintaan_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$permintaan_nama);
		$permintaan_nama=str_replace("'", '"',$permintaan_nama);
		$permintaan_cabang=trim(@$_POST["permintaan_cabang"]);
		//$permintaan_cabang=str_replace("/(<\/?)(p)([^>]*>)", "",$permintaan_cabang);
		//$permintaan_cabang=str_replace("'", '"',$permintaan_cabang);
		$permintaan_tanggalmasalah=trim(@$_POST["permintaan_tanggalmasalah"]);
		$permintaan_tipe=trim(@$_POST["permintaan_tipe"]);
		$permintaan_tipe=str_replace("/(<\/?)(p)([^>]*>)", "",$permintaan_tipe);
		$permintaan_tipe=str_replace("'", '"',$permintaan_tipe);
		$permintaan_judul=trim(@$_POST["permintaan_judul"]);
		$permintaan_judul=str_replace("/(<\/?)(p)([^>]*>)", "",$permintaan_judul);
		$permintaan_judul=str_replace("'", '"',$permintaan_judul);
		$permintaan_prioritas=trim(@$_POST["permintaan_prioritas"]);
		$permintaan_prioritas=str_replace("/(<\/?)(p)([^>]*>)", "",$permintaan_prioritas);
		$permintaan_prioritas=str_replace("'", '"',$permintaan_prioritas);
		$permintaan_status=trim(@$_POST["permintaan_status"]);
		$permintaan_status=str_replace("/(<\/?)(p)([^>]*>)", "",$permintaan_status);
		$permintaan_status=str_replace("'", '"',$permintaan_status);
		$permintaan_tanggalselesai=trim(@$_POST["permintaan_tanggalselesai"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_permintaan_it->permintaan_search($permintaan_nama ,$permintaan_cabang ,$permintaan_tanggalmasalah ,$permintaan_tipe ,$permintaan_judul ,$permintaan_prioritas ,$permintaan_status, $permintaan_tanggalselesai, $start, $end );
		echo $result;
	}


	function gudang_print(){
  		//POST varibale here
		$gudang_id=trim(@$_POST["gudang_id"]);
		$gudang_nama=trim(@$_POST["gudang_nama"]);
		$gudang_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_nama);
		$gudang_nama=str_replace("'", '"',$gudang_nama);
		$gudang_lokasi=trim(@$_POST["gudang_lokasi"]);
		$gudang_lokasi=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_lokasi);
		$gudang_lokasi=str_replace("'", '"',$gudang_lokasi);
		$gudang_keterangan=trim(@$_POST["gudang_keterangan"]);
		$gudang_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_keterangan);
		$gudang_keterangan=str_replace("'", '"',$gudang_keterangan);
		$gudang_aktif=trim(@$_POST["gudang_aktif"]);
		$gudang_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_aktif);
		$gudang_aktif=str_replace("'", '"',$gudang_aktif);
		$gudang_creator=trim(@$_POST["gudang_creator"]);
		$gudang_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_creator);
		$gudang_creator=str_replace("'", '"',$gudang_creator);
		$gudang_date_create=trim(@$_POST["gudang_date_create"]);
		$gudang_update=trim(@$_POST["gudang_update"]);
		$gudang_update=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_update);
		$gudang_update=str_replace("'", '"',$gudang_update);
		$gudang_date_update=trim(@$_POST["gudang_date_update"]);
		$gudang_revised=trim(@$_POST["gudang_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$result = $this->m_gudang->gudang_print($gudang_id ,$gudang_nama ,$gudang_lokasi ,$gudang_keterangan ,$gudang_aktif ,$gudang_creator ,$gudang_date_create ,$gudang_update ,$gudang_date_update ,$gudang_revised ,$option,$filter);
		$nbrows=$result->num_rows();
		$totcolumn=10;
   		/* We now have our array, let's build our HTML file */
		$file = fopen("gudanglist.html",'w');
		fwrite($file, "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Printing the Gudang Grid</title><link rel='stylesheet' type='text/css' href='assets/modules/main/css/printstyle.css'/></head>");
		fwrite($file, "<body><table summary='Gudang List'><caption>DAFTAR GUDANG</caption><thead><tr><th scope='col'>No</th><th scope='col'>Nama</th><th scope='col'>Lokasi</th><th scope='col'>Keterangan</th><th scope='col'>Aktif</th></tr></thead><tfoot><tr><th scope='row'>Total</th><td colspan='$totcolumn'>");
		fwrite($file, $nbrows);
		fwrite($file, " Gudang</td></tr></tfoot><tbody>");
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
				fwrite($file, $data['gudang_nama']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['gudang_lokasi']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['gudang_keterangan']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['gudang_aktif']);
				fwrite($file, "</td></tr>");
			}
		}
		fwrite($file, "</tbody></table></body></html>");	
		fclose($file);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function gudang_export_excel(){
		//POST varibale here
		$gudang_id=trim(@$_POST["gudang_id"]);
		$gudang_nama=trim(@$_POST["gudang_nama"]);
		$gudang_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_nama);
		$gudang_nama=str_replace("'", '"',$gudang_nama);
		$gudang_lokasi=trim(@$_POST["gudang_lokasi"]);
		$gudang_lokasi=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_lokasi);
		$gudang_lokasi=str_replace("'", '"',$gudang_lokasi);
		$gudang_keterangan=trim(@$_POST["gudang_keterangan"]);
		$gudang_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_keterangan);
		$gudang_keterangan=str_replace("'", '"',$gudang_keterangan);
		$gudang_aktif=trim(@$_POST["gudang_aktif"]);
		$gudang_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_aktif);
		$gudang_aktif=str_replace("'", '"',$gudang_aktif);
		$gudang_creator=trim(@$_POST["gudang_creator"]);
		$gudang_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_creator);
		$gudang_creator=str_replace("'", '"',$gudang_creator);
		$gudang_date_create=trim(@$_POST["gudang_date_create"]);
		$gudang_update=trim(@$_POST["gudang_update"]);
		$gudang_update=str_replace("/(<\/?)(p)([^>]*>)", "",$gudang_update);
		$gudang_update=str_replace("'", '"',$gudang_update);
		$gudang_date_update=trim(@$_POST["gudang_date_update"]);
		$gudang_revised=trim(@$_POST["gudang_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_gudang->gudang_export_excel($gudang_id ,$gudang_nama ,$gudang_lokasi ,$gudang_keterangan ,$gudang_aktif ,$gudang_creator ,$gudang_date_create ,$gudang_update ,$gudang_date_update ,$gudang_revised ,$option,$filter);
		
		to_excel($query,"gudang"); 
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