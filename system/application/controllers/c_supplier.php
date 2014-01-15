<?php
/* 
	GIOV Solution - Keep IT Simple
*/

//class of supplier
class C_supplier extends Controller {

	//constructor
	function C_supplier(){
		parent::Controller();
		session_start();
		$this->load->model('m_supplier', '', TRUE);
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_supplier');
	}
	
	function get_supplier_kategori_list(){
		$result=$this->m_supplier->get_supplier_kategori_list();
		echo $result;
	}

	//ini store ketika di klik Edit
	function detail_supplier_produk_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_supplier->detail_supplier_produk_list($master_id,$query,$start,$end);
		echo $result;
	}


	//get master id, note: not done yet
	function get_produk_list(){
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? @$_POST['master_id'] : @$_GET['master_id']);
		$task = isset($_POST['task']) ? @$_POST['task'] : @$_GET['task'];
		$selected_id = isset($_POST['selected_id']) ? @$_POST['selected_id'] : @$_GET['selected_id'];
		$supplier_id = isset($_POST['supplier_id']) ? @$_POST['supplier_id'] : @$_GET['supplier_id'];
		$produksi_id = isset($_POST['produksi_id']) ? @$_POST['produksi_id'] : @$_GET['produksi_id'];
		if($task=='detail')
			$result=$this->m_supplier->get_produk_detail_list($master_id,$query,$start,$end);
		elseif($task=='list')
			$result=$this->m_supplier->get_produk_all_list($query,$start,$end);
		elseif($task=='selected')
			$result=$this->m_supplier->get_produk_selected_list($master_id,$selected_id,$query,$start,$end);
		elseif($task=='op_last_price')
			$result=$this->m_supplier->get_op_last_price($supplier_id);
		elseif($task=='produksi')
			$result=$this->m_supplier->get_produk_pp_list($produksi_id,$query,$start,$end);
		echo $result;
	}
	//

	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->supplier_list();
				break;
			case "UPDATE":
				$this->supplier_update();
				break;
			case "CREATE":
				$this->supplier_create();
				break;
			case "DELETE":
				$this->supplier_delete();
				break;
			case "SEARCH":
				$this->supplier_search();
				break;
			case "PRINT":
				$this->supplier_print();
				break;
			case "EXCEL":
				$this->supplier_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function supplier_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);

		$result=$this->m_supplier->supplier_list($query,$start,$end);
		echo $result;
	}

	//function for update record
	function supplier_update(){
		//POST variable here
		$supplier_kategoritxt=trim(@$_POST["supplier_kategoritxt"]);
		$supplier_kategoritxt=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_kategoritxt);
		$supplier_kategoritxt=str_replace("'", '"',$supplier_kategoritxt);
		if($supplier_kategoritxt<>"")
			$supplier_kategori=$supplier_kategoritxt;
		else 
			$supplier_kategori=trim(@$_POST["supplier_kategori"]);
		
		$supplier_id=trim(@$_POST["supplier_id"]);
		$supplier_nama=trim(@$_POST["supplier_nama"]);
		$supplier_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_nama);
		$supplier_nama=str_replace("'", '"',$supplier_nama);
		$supplier_alamat=trim(@$_POST["supplier_alamat"]);
		$supplier_alamat=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_alamat);
		$supplier_alamat=str_replace("'", '"',$supplier_alamat);
		$supplier_kota=trim(@$_POST["supplier_kota"]);
		$supplier_kota=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_kota);
		$supplier_kota=str_replace("'", '"',$supplier_kota);
		$supplier_kodepos=trim(@$_POST["supplier_kodepos"]);
		$supplier_kodepos=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_kodepos);
		$supplier_kodepos=str_replace("'", '"',$supplier_kodepos);
		$supplier_propinsi=trim(@$_POST["supplier_propinsi"]);
		$supplier_propinsi=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_propinsi);
		$supplier_propinsi=str_replace("'", '"',$supplier_propinsi);
		$supplier_negara=trim(@$_POST["supplier_negara"]);
		$supplier_negara=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_negara);
		$supplier_negara=str_replace("'", '"',$supplier_negara);
		$supplier_notelp=trim(@$_POST["supplier_notelp"]);
		$supplier_notelp=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_notelp);
		$supplier_notelp=str_replace("'", '"',$supplier_notelp);
		$supplier_notelp2=trim(@$_POST["supplier_notelp2"]);
		$supplier_notelp2=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_notelp2);
		$supplier_notelp2=str_replace("'", '"',$supplier_notelp2);
		$supplier_nofax=trim(@$_POST["supplier_nofax"]);
		$supplier_nofax=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_nofax);
		$supplier_nofax=str_replace("'", '"',$supplier_nofax);
		$supplier_email=trim(@$_POST["supplier_email"]);
		$supplier_email=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_email);
		$supplier_email=str_replace("'", '"',$supplier_email);
		$supplier_website=trim(@$_POST["supplier_website"]);
		$supplier_website=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_website);
		$supplier_website=str_replace("'", '"',$supplier_website);
		$supplier_cp=trim(@$_POST["supplier_cp"]);
		$supplier_cp=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_cp);
		$supplier_cp=str_replace("'", '"',$supplier_cp);
		$supplier_contact_cp=trim(@$_POST["supplier_contact_cp"]);
		$supplier_contact_cp=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_contact_cp);
		$supplier_contact_cp=str_replace("'", '"',$supplier_contact_cp);
		$supplier_aktif=trim(@$_POST["supplier_aktif"]);
		$supplier_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_aktif);
		$supplier_aktif=str_replace("'", '"',$supplier_aktif);
		$supplier_creator=trim(@$_POST["supplier_creator"]);
		$supplier_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_creator);
		$supplier_creator=str_replace("'", '"',$supplier_creator);
		$supplier_date_create=trim(@$_POST["supplier_date_create"]);
		$supplier_update=trim(@$_POST["supplier_update"]);
		$supplier_update=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_update);
		$supplier_update=str_replace("'", '"',$supplier_update);
		$supplier_date_update=trim(@$_POST["supplier_date_update"]);
		$supplier_revised=trim(@$_POST["supplier_revised"]);
		$result = $this->m_supplier->supplier_update($supplier_id ,$supplier_kategori ,$supplier_nama ,$supplier_alamat ,$supplier_kota ,$supplier_kodepos ,$supplier_propinsi ,$supplier_negara ,$supplier_notelp ,$supplier_notelp2 ,$supplier_nofax ,$supplier_email ,$supplier_website ,$supplier_cp ,$supplier_contact_cp ,$supplier_aktif ,$supplier_creator ,$supplier_date_create ,$supplier_update ,$supplier_date_update ,$supplier_revised );
		echo $result;
	}
	
	//function for create new record
	function supplier_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$supplier_kategoritxt=trim(@$_POST["supplier_kategoritxt"]);
		$supplier_kategoritxt=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_kategoritxt);
		$supplier_kategoritxt=str_replace("'", '"',$supplier_kategoritxt);
		if($supplier_kategoritxt<>"")
			$supplier_kategori=$supplier_kategoritxt;
		else 
			$supplier_kategori=trim(@$_POST["supplier_kategori"]);
		
		$supplier_nama=trim(@$_POST["supplier_nama"]);
		$supplier_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_nama);
		$supplier_nama=str_replace("'", '"',$supplier_nama);
		$supplier_alamat=trim(@$_POST["supplier_alamat"]);
		$supplier_alamat=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_alamat);
		$supplier_alamat=str_replace("'", '"',$supplier_alamat);
		$supplier_kota=trim(@$_POST["supplier_kota"]);
		$supplier_kota=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_kota);
		$supplier_kota=str_replace("'", '"',$supplier_kota);
		$supplier_kodepos=trim(@$_POST["supplier_kodepos"]);
		$supplier_kodepos=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_kodepos);
		$supplier_kodepos=str_replace("'", '"',$supplier_kodepos);
		$supplier_propinsi=trim(@$_POST["supplier_propinsi"]);
		$supplier_propinsi=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_propinsi);
		$supplier_propinsi=str_replace("'", '"',$supplier_propinsi);
		$supplier_negara=trim(@$_POST["supplier_negara"]);
		$supplier_negara=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_negara);
		$supplier_negara=str_replace("'", '"',$supplier_negara);
		$supplier_notelp=trim(@$_POST["supplier_notelp"]);
		$supplier_notelp=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_notelp);
		$supplier_notelp=str_replace("'", '"',$supplier_notelp);
		$supplier_notelp2=trim(@$_POST["supplier_notelp2"]);
		$supplier_notelp2=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_notelp2);
		$supplier_notelp2=str_replace("'", '"',$supplier_notelp2);
		$supplier_nofax=trim(@$_POST["supplier_nofax"]);
		$supplier_nofax=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_nofax);
		$supplier_nofax=str_replace("'", '"',$supplier_nofax);
		$supplier_email=trim(@$_POST["supplier_email"]);
		$supplier_email=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_email);
		$supplier_email=str_replace("'", '"',$supplier_email);
		$supplier_website=trim(@$_POST["supplier_website"]);
		$supplier_website=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_website);
		$supplier_website=str_replace("'", '"',$supplier_website);
		$supplier_cp=trim(@$_POST["supplier_cp"]);
		$supplier_cp=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_cp);
		$supplier_cp=str_replace("'", '"',$supplier_cp);
		$supplier_contact_cp=trim(@$_POST["supplier_contact_cp"]);
		$supplier_contact_cp=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_contact_cp);
		$supplier_contact_cp=str_replace("'", '"',$supplier_contact_cp);
		$supplier_keterangan=trim(@$_POST["supplier_keterangan"]);
		$supplier_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_keterangan);
		$supplier_keterangan=str_replace("'", '"',$supplier_keterangan);
		$supplier_aktif=trim(@$_POST["supplier_aktif"]);
		$supplier_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_aktif);
		$supplier_aktif=str_replace("'", '"',$supplier_aktif);
		$supplier_creator=trim(@$_POST["supplier_creator"]);
		$supplier_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_creator);
		$supplier_creator=str_replace("'", '"',$supplier_creator);
		$supplier_date_create=trim(@$_POST["supplier_date_create"]);
		$supplier_update=trim(@$_POST["supplier_update"]);
		$supplier_update=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_update);
		$supplier_update=str_replace("'", '"',$supplier_update);
		$supplier_date_update=trim(@$_POST["supplier_date_update"]);
		$supplier_revised=trim(@$_POST["supplier_revised"]);

		//Detail Supplier Produk
		$dsupplier_id = $_POST['dsupplier_id'];
		$array_dsupplier_id = json_decode(stripslashes($dsupplier_id));
		
		$dsupplier_master=trim(@$_POST["dsupplier_master"]);
		
		$dsupplier_produk = $_POST['dsupplier_produk'];
		$array_dsupplier_produk = json_decode(stripslashes($dsupplier_produk));
		$dsupplier_keterangan = $_POST['dsupplier_keterangan'];
		$array_dsupplier_keterangan = json_decode(stripslashes($dsupplier_keterangan));
		//
		$result=$this->m_supplier->supplier_create($supplier_kategori ,$supplier_nama ,$supplier_alamat ,$supplier_kota ,$supplier_kodepos ,$supplier_propinsi ,$supplier_negara ,$supplier_notelp ,$supplier_notelp2 ,$supplier_nofax ,$supplier_email ,$supplier_website ,$supplier_cp ,$supplier_contact_cp ,$supplier_keterangan ,$supplier_aktif ,$supplier_creator ,$supplier_date_create ,$supplier_update ,$supplier_date_update ,$supplier_revised,
			$array_dsupplier_id, $dsupplier_master, $array_dsupplier_produk, $array_dsupplier_keterangan
		 );
		echo $result;
	}

	//function for delete selected record
	function supplier_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_supplier->supplier_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function supplier_search(){
		//POST varibale here
		$supplier_id=trim(@$_POST["supplier_id"]);
		$supplier_kategori=trim(@$_POST["supplier_kategori"]);
		$supplier_kategori=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_kategori);
		$supplier_kategori=str_replace("'", '"',$supplier_kategori);
		$supplier_nama=trim(@$_POST["supplier_nama"]);
		$supplier_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_nama);
		$supplier_nama=str_replace("'", '"',$supplier_nama);
		$supplier_alamat=trim(@$_POST["supplier_alamat"]);
		$supplier_alamat=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_alamat);
		$supplier_alamat=str_replace("'", '"',$supplier_alamat);
		$supplier_kota=trim(@$_POST["supplier_kota"]);
		$supplier_kota=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_kota);
		$supplier_kota=str_replace("'", '"',$supplier_kota);
		$supplier_kodepos=trim(@$_POST["supplier_kodepos"]);
		$supplier_kodepos=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_kodepos);
		$supplier_kodepos=str_replace("'", '"',$supplier_kodepos);
		$supplier_propinsi=trim(@$_POST["supplier_propinsi"]);
		$supplier_propinsi=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_propinsi);
		$supplier_propinsi=str_replace("'", '"',$supplier_propinsi);
		$supplier_negara=trim(@$_POST["supplier_negara"]);
		$supplier_negara=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_negara);
		$supplier_negara=str_replace("'", '"',$supplier_negara);
		$supplier_notelp=trim(@$_POST["supplier_notelp"]);
		$supplier_notelp=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_notelp);
		$supplier_notelp=str_replace("'", '"',$supplier_notelp);
		$supplier_notelp2=trim(@$_POST["supplier_notelp2"]);
		$supplier_notelp2=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_notelp2);
		$supplier_notelp2=str_replace("'", '"',$supplier_notelp2);
		$supplier_nofax=trim(@$_POST["supplier_nofax"]);
		$supplier_nofax=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_nofax);
		$supplier_nofax=str_replace("'", '"',$supplier_nofax);
		$supplier_email=trim(@$_POST["supplier_email"]);
		$supplier_email=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_email);
		$supplier_email=str_replace("'", '"',$supplier_email);
		$supplier_website=trim(@$_POST["supplier_website"]);
		$supplier_website=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_website);
		$supplier_website=str_replace("'", '"',$supplier_website);
		$supplier_cp=trim(@$_POST["supplier_cp"]);
		$supplier_cp=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_cp);
		$supplier_cp=str_replace("'", '"',$supplier_cp);
		$supplier_contact_cp=trim(@$_POST["supplier_contact_cp"]);
		$supplier_contact_cp=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_contact_cp);
		$supplier_contact_cp=str_replace("'", '"',$supplier_contact_cp);
		$supplier_aktif=trim(@$_POST["supplier_aktif"]);
		$supplier_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_aktif);
		$supplier_aktif=str_replace("'", '"',$supplier_aktif);
		$supplier_creator=trim(@$_POST["supplier_creator"]);
		$supplier_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_creator);
		$supplier_creator=str_replace("'", '"',$supplier_creator);
		$supplier_date_create=trim(@$_POST["supplier_date_create"]);
		$supplier_update=trim(@$_POST["supplier_update"]);
		$supplier_update=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_update);
		$supplier_update=str_replace("'", '"',$supplier_update);
		$supplier_date_update=trim(@$_POST["supplier_date_update"]);
		$supplier_revised=trim(@$_POST["supplier_revised"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_supplier->supplier_search($supplier_id ,$supplier_kategori ,$supplier_nama ,$supplier_alamat ,$supplier_kota ,$supplier_kodepos ,$supplier_propinsi ,$supplier_negara ,$supplier_notelp ,$supplier_notelp2 ,$supplier_nofax ,$supplier_email ,$supplier_website ,$supplier_cp ,$supplier_contact_cp ,$supplier_aktif ,$supplier_creator ,$supplier_date_create ,$supplier_update ,$supplier_date_update ,$supplier_revised ,$start,$end);
		echo $result;
	}


	function supplier_print(){
  		//POST varibale here
		$supplier_id=trim(@$_POST["supplier_id"]);
		$supplier_kategori=trim(@$_POST["supplier_kategori"]);
		$supplier_kategori=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_kategori);
		$supplier_kategori=str_replace("'", '"',$supplier_kategori);
		$supplier_nama=trim(@$_POST["supplier_nama"]);
		$supplier_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_nama);
		$supplier_nama=str_replace("'", '"',$supplier_nama);
		$supplier_alamat=trim(@$_POST["supplier_alamat"]);
		$supplier_alamat=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_alamat);
		$supplier_alamat=str_replace("'", '"',$supplier_alamat);
		$supplier_kota=trim(@$_POST["supplier_kota"]);
		$supplier_kota=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_kota);
		$supplier_kota=str_replace("'", '"',$supplier_kota);
		$supplier_kodepos=trim(@$_POST["supplier_kodepos"]);
		$supplier_kodepos=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_kodepos);
		$supplier_kodepos=str_replace("'", '"',$supplier_kodepos);
		$supplier_propinsi=trim(@$_POST["supplier_propinsi"]);
		$supplier_propinsi=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_propinsi);
		$supplier_propinsi=str_replace("'", '"',$supplier_propinsi);
		$supplier_negara=trim(@$_POST["supplier_negara"]);
		$supplier_negara=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_negara);
		$supplier_negara=str_replace("'", '"',$supplier_negara);
		$supplier_notelp=trim(@$_POST["supplier_notelp"]);
		$supplier_notelp=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_notelp);
		$supplier_notelp=str_replace("'", '"',$supplier_notelp);
		$supplier_notelp2=trim(@$_POST["supplier_notelp2"]);
		$supplier_notelp2=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_notelp2);
		$supplier_notelp2=str_replace("'", '"',$supplier_notelp2);
		$supplier_nofax=trim(@$_POST["supplier_nofax"]);
		$supplier_nofax=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_nofax);
		$supplier_nofax=str_replace("'", '"',$supplier_nofax);
		$supplier_email=trim(@$_POST["supplier_email"]);
		$supplier_email=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_email);
		$supplier_email=str_replace("'", '"',$supplier_email);
		$supplier_website=trim(@$_POST["supplier_website"]);
		$supplier_website=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_website);
		$supplier_website=str_replace("'", '"',$supplier_website);
		$supplier_cp=trim(@$_POST["supplier_cp"]);
		$supplier_cp=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_cp);
		$supplier_cp=str_replace("'", '"',$supplier_cp);
		$supplier_contact_cp=trim(@$_POST["supplier_contact_cp"]);
		$supplier_contact_cp=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_contact_cp);
		$supplier_contact_cp=str_replace("'", '"',$supplier_contact_cp);
		$supplier_aktif=trim(@$_POST["supplier_aktif"]);
		$supplier_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_aktif);
		$supplier_aktif=str_replace("'", '"',$supplier_aktif);
		$supplier_creator=trim(@$_POST["supplier_creator"]);
		$supplier_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_creator);
		$supplier_creator=str_replace("'", '"',$supplier_creator);
		$supplier_date_create=trim(@$_POST["supplier_date_create"]);
		$supplier_update=trim(@$_POST["supplier_update"]);
		$supplier_update=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_update);
		$supplier_update=str_replace("'", '"',$supplier_update);
		$supplier_date_update=trim(@$_POST["supplier_date_update"]);
		$supplier_revised=trim(@$_POST["supplier_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$result = $this->m_supplier->supplier_print($supplier_id ,$supplier_kategori ,$supplier_nama ,$supplier_alamat ,$supplier_kota ,$supplier_kodepos ,$supplier_propinsi ,$supplier_negara ,$supplier_notelp ,$supplier_notelp2 ,$supplier_nofax ,$supplier_email ,$supplier_website ,$supplier_cp ,$supplier_contact_cp ,$supplier_aktif ,$supplier_creator ,$supplier_date_create ,$supplier_update ,$supplier_date_update ,$supplier_revised ,$option,$filter);
		$nbrows=$result->num_rows();
		$totcolumn=22;
   		/* We now have our array, let's build our HTML file */
		$file = fopen("supplierlist.html",'w');
		fwrite($file, "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Printing the Supplier Grid</title><link rel='stylesheet' type='text/css' href='assets/modules/main/css/printstyle.css'/></head>");
		fwrite($file, "<body onload='window.print()'><table summary='Supplier List'><caption>DAFTAR SUPPLIER</caption><thead><tr><th scope='col'>No</th><th scope='col'>Kategori</th><th scope='col'>Nama</th><th scope='col'>Alamat</th><th scope='col'>Kota</th><th scope='col'>Kode Pos</th><th scope='col'>Propinsi</th><th scope='col'>Negara</th><th scope='col'>No.Telp.</th><th scope='col'>No.Telp.2</th><th scope='col'>No.Fax</th><th scope='col'>Email</th><th scope='col'>Website</th><th scope='col'>Contact Person</th><th scope='col'>Telp. Contact Person</th><th scope='col'>Aktif</th></tr></thead><tfoot><tr><th scope='row'>Total</th><td colspan='$totcolumn'>");
		fwrite($file, $nbrows);
		fwrite($file, " Supplier</td></tr></tfoot><tbody>");
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
				fwrite($file, $data['supplier_kategori']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['supplier_nama']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['supplier_alamat']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['supplier_kota']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['supplier_kodepos']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['supplier_propinsi']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['supplier_negara']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['supplier_notelp']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['supplier_notelp2']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['supplier_nofax']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['supplier_email']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['supplier_website']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['supplier_cp']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['supplier_contact_cp']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['supplier_aktif']);
				fwrite($file, "</td></tr>");
			}
		}
		fwrite($file, "</tbody></table></body></html>");	
		fclose($file);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function supplier_export_excel(){
		//POST varibale here
		$supplier_id=trim(@$_POST["supplier_id"]);
		$supplier_kategori=trim(@$_POST["supplier_kategori"]);
		$supplier_kategori=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_kategori);
		$supplier_kategori=str_replace("'", '"',$supplier_kategori);
		$supplier_nama=trim(@$_POST["supplier_nama"]);
		$supplier_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_nama);
		$supplier_nama=str_replace("'", '"',$supplier_nama);
		$supplier_alamat=trim(@$_POST["supplier_alamat"]);
		$supplier_alamat=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_alamat);
		$supplier_alamat=str_replace("'", '"',$supplier_alamat);
		$supplier_kota=trim(@$_POST["supplier_kota"]);
		$supplier_kota=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_kota);
		$supplier_kota=str_replace("'", '"',$supplier_kota);
		$supplier_kodepos=trim(@$_POST["supplier_kodepos"]);
		$supplier_kodepos=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_kodepos);
		$supplier_kodepos=str_replace("'", '"',$supplier_kodepos);
		$supplier_propinsi=trim(@$_POST["supplier_propinsi"]);
		$supplier_propinsi=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_propinsi);
		$supplier_propinsi=str_replace("'", '"',$supplier_propinsi);
		$supplier_negara=trim(@$_POST["supplier_negara"]);
		$supplier_negara=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_negara);
		$supplier_negara=str_replace("'", '"',$supplier_negara);
		$supplier_notelp=trim(@$_POST["supplier_notelp"]);
		$supplier_notelp=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_notelp);
		$supplier_notelp=str_replace("'", '"',$supplier_notelp);
		$supplier_notelp2=trim(@$_POST["supplier_notelp2"]);
		$supplier_notelp2=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_notelp2);
		$supplier_notelp2=str_replace("'", '"',$supplier_notelp2);
		$supplier_nofax=trim(@$_POST["supplier_nofax"]);
		$supplier_nofax=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_nofax);
		$supplier_nofax=str_replace("'", '"',$supplier_nofax);
		$supplier_email=trim(@$_POST["supplier_email"]);
		$supplier_email=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_email);
		$supplier_email=str_replace("'", '"',$supplier_email);
		$supplier_website=trim(@$_POST["supplier_website"]);
		$supplier_website=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_website);
		$supplier_website=str_replace("'", '"',$supplier_website);
		$supplier_cp=trim(@$_POST["supplier_cp"]);
		$supplier_cp=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_cp);
		$supplier_cp=str_replace("'", '"',$supplier_cp);
		$supplier_contact_cp=trim(@$_POST["supplier_contact_cp"]);
		$supplier_contact_cp=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_contact_cp);
		$supplier_contact_cp=str_replace("'", '"',$supplier_contact_cp);
		$supplier_aktif=trim(@$_POST["supplier_aktif"]);
		$supplier_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_aktif);
		$supplier_aktif=str_replace("'", '"',$supplier_aktif);
		$supplier_creator=trim(@$_POST["supplier_creator"]);
		$supplier_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_creator);
		$supplier_creator=str_replace("'", '"',$supplier_creator);
		$supplier_date_create=trim(@$_POST["supplier_date_create"]);
		$supplier_update=trim(@$_POST["supplier_update"]);
		$supplier_update=str_replace("/(<\/?)(p)([^>]*>)", "",$supplier_update);
		$supplier_update=str_replace("'", '"',$supplier_update);
		$supplier_date_update=trim(@$_POST["supplier_date_update"]);
		$supplier_revised=trim(@$_POST["supplier_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_supplier->supplier_export_excel($supplier_id ,$supplier_kategori ,$supplier_nama ,$supplier_alamat ,$supplier_kota ,$supplier_kodepos ,$supplier_propinsi ,$supplier_negara ,$supplier_notelp ,$supplier_notelp2 ,$supplier_nofax ,$supplier_email ,$supplier_website ,$supplier_cp ,$supplier_contact_cp ,$supplier_aktif ,$supplier_creator ,$supplier_date_create ,$supplier_update ,$supplier_date_update ,$supplier_revised ,$option,$filter);

		$this->load->plugin('to_excel');
		to_excel($query,"supplier"); 
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