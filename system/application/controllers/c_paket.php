<?php
/* 	
	Miracle IT Team
*/

//class of paket
class C_paket extends Controller {

	//constructor
	function C_paket(){
		parent::Controller();
		session_start();
		$this->load->model('m_paket', '', TRUE);
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_paket');
	}
	
	function get_satuan_list(){
		$result=$this->m_public_function->get_satuan_list();
		echo $result;
	}
	
	function get_group_list(){
		$result=$this->m_public_function->get_group_list();
		echo $result;
	}
	
	function get_group_paket_list(){
		$result=$this->m_paket->get_group_paket_list();
		echo $result;
	}
	
	function get_kategori_list(){
		$result=$this->m_public_function->get_kategori_produk_list();
		echo $result;
	}
	
	function get_produk_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_public_function->get_produk_list($query, $start, $end);
		echo $result;
	}
	
	function get_rawat_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_paket->get_rawat_list($query,$start,$end);
		echo $result;
	}
	
	function get_kategori_paket_list(){
		$result=$this->m_paket->get_kategori_paket_list();
		echo $result;
	}
	
	function get_group_by_id(){
		$group_id = (integer) (isset($_POST['group_id']) ? $_POST['group_id'] : $_GET['group_id']);
		$result=$this->m_public_function->get_group_by_id($group_id);
		echo $result;
	}
	
	//for detail action
	//list detail handler action
	function  detail_paket_isi_perawatan_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_paket->detail_paket_isi_perawatan_list($master_id,$query,$start,$end);
		echo $result;
	}
	//end of handler
	
	//purge all detail
	function detail_paket_isi_perawatan_purge(){
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_paket->detail_paket_isi_perawatan_purge($master_id);
		echo $result;
	}
	//eof
	
	//get master id, note: not done yet
	function get_master_id(){
		$result=$this->m_paket->get_master_id();
		echo $result;
	}
	//
	
	//add detail
	function detail_paket_isi_perawatan_insert(){
	//POST variable here
		$rpaket_id=trim(@$_POST["rpaket_id"]);
		$rpaket_master=trim(@$_POST["rpaket_master"]);
		$rpaket_perawatan=trim(@$_POST["rpaket_perawatan"]);
		$rpaket_jumlah=trim(@$_POST["rpaket_jumlah"]);
		$result=$this->m_paket->detail_paket_isi_perawatan_insert($rpaket_id ,$rpaket_master ,$rpaket_perawatan ,$rpaket_jumlah );
		echo $result;
	}
	
	//DETAIL PRODUK FUNCTION
	//list detail handler action
	function  detail_paket_isi_produk_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_paket->detail_paket_isi_produk_list($master_id,$query,$start,$end);
		echo $result;
	}
	//end of handler
	
	//purge all detail
	function detail_paket_isi_produk_purge(){
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_paket->detail_paket_isi_produk_purge($master_id);
		echo $result;
	}
	//eof
	
	
	//add detail
	function detail_paket_isi_produk_insert(){
	//POST variable here
		$ipaket_id=trim(@$_POST["ipaket_id"]);
		$ipaket_master=trim(@$_POST["ipaket_master"]);
		$ipaket_produk=trim(@$_POST["ipaket_produk"]);
		$ipaket_jumlah=trim(@$_POST["ipaket_jumlah"]);
		$ipaket_satuan=trim(@$_POST["ipaket_satuan"]);
		$result=$this->m_paket->detail_paket_isi_produk_insert($ipaket_id ,$ipaket_master ,$ipaket_produk ,$ipaket_jumlah );
		echo $result;
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->paket_list();
				break;
			case "UPDATE":
				$this->paket_update();
				break;
			case "CREATE":
				$this->paket_create();
				break;
			case "DELETE":
				$this->paket_delete();
				break;
			case "SEARCH":
				$this->paket_search();
				break;
			case "PRINT":
				$this->paket_print();
				break;
			case "EXCEL":
				$this->paket_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function paket_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_paket->paket_list($query,$start,$end);
		echo $result;
	}
	
	function get_permission(){
		$group = (integer) (isset($_POST['group']) ? @$_POST['group'] : @$_GET['group']);
		$result=$this->m_paket->get_permission($group);
		echo $result;
	}

	//function for update record
	function paket_update(){
		//POST variable here
		$paket_id=trim(@$_POST["paket_id"]);
		$paket_kode=trim(@$_POST["paket_kode"]);
		$paket_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_kode);
		$paket_kode=str_replace(",", ",",$paket_kode);
		$paket_kode=str_replace("'", '"',$paket_kode);
		$paket_kodelama=trim(@$_POST["paket_kodelama"]);
		$paket_kodelama=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_kodelama);
		$paket_kodelama=str_replace(",", ",",$paket_kodelama);
		$paket_kodelama=str_replace("'", '"',$paket_kodelama);
		$paket_nama=trim(@$_POST["paket_nama"]);
		$paket_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_nama);
		$paket_nama=str_replace(",", ",",$paket_nama);
		$paket_nama=str_replace("'", '"',$paket_nama);
		$paket_edit_harga=trim(@$_POST["paket_edit_harga"]);
		$paket_group=trim(@$_POST["paket_group"]);
		$paket_kategori=trim(@$_POST["paket_kategori"]);
		$paket_keterangan=trim(@$_POST["paket_keterangan"]);
		$paket_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_keterangan);
		$paket_keterangan=str_replace(",", ",",$paket_keterangan);
		$paket_keterangan=str_replace("'", '"',$paket_keterangan);
		$paket_du=trim(@$_POST["paket_du"]);
		$paket_dm=trim(@$_POST["paket_dm"]);
		$paket_dultah=trim(@$_POST["paket_dultah"]);
		$paket_dcard=trim(@$_POST["paket_dcard"]);
		$paket_dkolega=trim(@$_POST["paket_dkolega"]);
		$paket_dkeluarga=trim(@$_POST["paket_dkeluarga"]);
		$paket_downer=trim(@$_POST["paket_downer"]);
		$paket_dgrooming=trim(@$_POST["paket_dgrooming"]);
		$paket_dwartawan=trim(@$_POST["paket_dwartawan"]);
		$paket_dstaffdokter=trim(@$_POST["paket_dstaffdokter"]);
		$paket_dstaffnondokter=trim(@$_POST["paket_dstaffnondokter"]);
		$paket_dpromo=trim(@$_POST["paket_dpromo"]);
		$paket_point=trim(@$_POST["paket_point"]);
		$paket_harga=trim(@$_POST["paket_harga"]);
		$paket_harga_ki=trim(@$_POST["paket_harga_ki"]);
		$paket_harga_mdn=trim(@$_POST["paket_harga_mdn"]);
		$paket_harga_mnd=trim(@$_POST["paket_harga_mnd"]);
		$paket_harga_ygk=trim(@$_POST["paket_harga_ygk"]);
		$paket_harga_mta=trim(@$_POST["paket_harga_mta"]);
		$paket_harga_btm=trim(@$_POST["paket_harga_btm"]);
		$paket_harga_lbk=trim(@$_POST["paket_harga_lbk"]);
		$paket_harga_hr=trim(@$_POST["paket_harga_hr"]);
		$paket_harga_tp=trim(@$_POST["paket_harga_tp"]);
		$paket_harga_dps=trim(@$_POST["paket_harga_dps"]);
		$paket_harga_jkt=trim(@$_POST["paket_harga_jkt"]);
		$paket_harga_blpn=trim(@$_POST["paket_harga_blpn"]);
		$paket_harga_kuta=trim(@$_POST["paket_harga_kuta"]);
		$paket_harga_smg=trim(@$_POST["paket_harga_smg"]);
		$paket_harga_mks=trim(@$_POST["paket_harga_mks"]);
		$paket_harga_mlg=trim(@$_POST["paket_harga_mlg"]);
		$paket_expired=trim(@$_POST["paket_expired"]);
		$paket_aktif=trim(@$_POST["paket_aktif"]);
		$paket_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_aktif);
		$paket_aktif=str_replace(",", ",",$paket_aktif);
		$paket_aktif=str_replace("'", '"',$paket_aktif);
		$paket_aktif_th=trim(@$_POST["paket_aktif_th"]);
		$paket_aktif_th=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_aktif_th);
		$paket_aktif_th=str_replace(",", ",",$paket_aktif_th);
		$paket_aktif_th=str_replace("'", '"',$paket_aktif_th);
		$paket_aktif_ki=trim(@$_POST["paket_aktif_ki"]);
		$paket_aktif_ki=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_aktif_ki);
		$paket_aktif_ki=str_replace(",", ",",$paket_aktif_ki);
		$paket_aktif_ki=str_replace("'", '"',$paket_aktif_ki);
		$paket_aktif_hr=trim(@$_POST["paket_aktif_hr"]);
		$paket_aktif_hr=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_aktif_hr);
		$paket_aktif_hr=str_replace(",", ",",$paket_aktif_hr);
		$paket_aktif_hr=str_replace("'", '"',$paket_aktif_hr);
		$paket_aktif_tp=trim(@$_POST["paket_aktif_tp"]);
		$paket_aktif_tp=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_aktif_tp);
		$paket_aktif_tp=str_replace(",", ",",$paket_aktif_tp);
		$paket_aktif_tp=str_replace("'", '"',$paket_aktif_tp);
		$paket_aktif_dps=trim(@$_POST["paket_aktif_dps"]);
		$paket_aktif_dps=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_aktif_dps);
		$paket_aktif_dps=str_replace(",", ",",$paket_aktif_dps);
		$paket_aktif_dps=str_replace("'", '"',$paket_aktif_dps);
		$paket_aktif_jkt=trim(@$_POST["paket_aktif_jkt"]);
		$paket_aktif_jkt=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_aktif_jkt);
		$paket_aktif_jkt=str_replace(",", ",",$paket_aktif_jkt);
		$paket_aktif_jkt=str_replace("'", '"',$paket_aktif_jkt);
		$paket_aktif_mta=trim(@$_POST["paket_aktif_mta"]);
		$paket_aktif_mta=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_aktif_mta);
		$paket_aktif_mta=str_replace(",", ",",$paket_aktif_mta);
		$paket_aktif_mta=str_replace("'", '"',$paket_aktif_mta);
		$paket_aktif_blpn=trim(@$_POST["paket_aktif_blpn"]);
		$paket_aktif_blpn=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_aktif_blpn);
		$paket_aktif_blpn=str_replace(",", ",",$paket_aktif_blpn);
		$paket_aktif_blpn=str_replace("'", '"',$paket_aktif_blpn);
		$paket_aktif_kuta=trim(@$_POST["paket_aktif_kuta"]);
		$paket_aktif_kuta=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_aktif_kuta);
		$paket_aktif_kuta=str_replace(",", ",",$paket_aktif_kuta);
		$paket_aktif_kuta=str_replace("'", '"',$paket_aktif_kuta);
		$paket_aktif_btm=trim(@$_POST["paket_aktif_btm"]);
		$paket_aktif_btm=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_aktif_btm);
		$paket_aktif_btm=str_replace(",", ",",$paket_aktif_btm);
		$paket_aktif_btm=str_replace("'", '"',$paket_aktif_btm);
		$paket_aktif_mks=trim(@$_POST["paket_aktif_mks"]);
		$paket_aktif_mks=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_aktif_mks);
		$paket_aktif_mks=str_replace(",", ",",$paket_aktif_mks);
		$paket_aktif_mks=str_replace("'", '"',$paket_aktif_mks);
		$paket_aktif_mdn=trim(@$_POST["paket_aktif_mdn"]);
		$paket_aktif_mdn=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_aktif_mdn);
		$paket_aktif_mdn=str_replace(",", ",",$paket_aktif_mdn);
		$paket_aktif_mdn=str_replace("'", '"',$paket_aktif_mdn);
		$paket_aktif_lbk=trim(@$_POST["paket_aktif_lbk"]);
		$paket_aktif_lbk=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_aktif_lbk);
		$paket_aktif_lbk=str_replace(",", ",",$paket_aktif_lbk);
		$paket_aktif_lbk=str_replace("'", '"',$paket_aktif_lbk);
		$paket_aktif_mnd=trim(@$_POST["paket_aktif_mnd"]);
		$paket_aktif_mnd=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_aktif_mnd);
		$paket_aktif_mnd=str_replace(",", ",",$paket_aktif_mnd);
		$paket_aktif_mnd=str_replace("'", '"',$paket_aktif_mnd);
		$paket_aktif_ygk=trim(@$_POST["paket_aktif_ygk"]);
		$paket_aktif_ygk=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_aktif_ygk);
		$paket_aktif_ygk=str_replace(",", ",",$paket_aktif_ygk);
		$paket_aktif_ygk=str_replace("'", '"',$paket_aktif_ygk);
		$paket_aktif_mlg=trim(@$_POST["paket_aktif_mlg"]);
		$paket_aktif_mlg=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_aktif_mlg);
		$paket_aktif_mlg=str_replace(",", ",",$paket_aktif_mlg);
		$paket_aktif_mlg=str_replace("'", '"',$paket_aktif_mlg);
		$paket_aktif_smg=trim(@$_POST["paket_aktif_smg"]);
		$paket_aktif_smg=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_aktif_smg);
		$paket_aktif_smg=str_replace(",", ",",$paket_aktif_smg);
		$paket_aktif_smg=str_replace("'", '"',$paket_aktif_smg);
		
		$result = $this->m_paket->paket_update($paket_id ,$paket_kode ,$paket_kodelama,$paket_nama,$paket_group,$paket_kategori,$paket_edit_harga, $paket_keterangan ,
											$paket_du ,$paket_dm , $paket_dultah, $paket_dcard, $paket_dkolega, $paket_dkeluarga, $paket_downer, $paket_dgrooming, $paket_dwartawan, $paket_dstaffdokter, $paket_dpromo, $paket_dstaffnondokter,
											$paket_point ,$paket_harga ,$paket_expired ,$paket_aktif ,$paket_aktif_th ,$paket_aktif_ki ,$paket_aktif_hr ,$paket_aktif_tp ,$paket_aktif_dps ,$paket_aktif_jkt ,$paket_aktif_mta ,$paket_aktif_blpn ,$paket_aktif_kuta ,$paket_aktif_btm ,$paket_aktif_mks ,$paket_aktif_mdn ,$paket_aktif_lbk ,$paket_aktif_mnd ,$paket_aktif_ygk,$paket_aktif_mlg, $paket_aktif_smg,$paket_harga_ki,$paket_harga_mdn,$paket_harga_mnd,$paket_harga_ygk,$paket_harga_mta, $paket_harga_btm,$paket_harga_lbk, $paket_harga_hr, $paket_harga_tp, $paket_harga_dps, $paket_harga_blpn, $paket_harga_kuta, $paket_harga_jkt,$paket_harga_smg, $paket_harga_mks, $paket_harga_mlg);
		echo $result;
	}
	
	//function for create new record
	function paket_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$paket_kode=trim(@$_POST["paket_kode"]);
		$paket_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_kode);
		$paket_kode=str_replace("'", '"',$paket_kode);
		$paket_kodelama=trim(@$_POST["paket_kodelama"]);
		$paket_kodelama=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_kodelama);
		$paket_kodelama=str_replace("'", '"',$paket_kodelama);
		$paket_nama=trim(@$_POST["paket_nama"]);
		$paket_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_nama);
		$paket_nama=str_replace("'", '"',$paket_nama);

		$paket_edit_harga=trim(@$_POST["paket_edit_harga"]);
		$paket_group=trim(@$_POST["paket_group"]);
		$paket_kategori=trim(@$_POST["paket_kategori"]);
		$paket_keterangan=trim(@$_POST["paket_keterangan"]);
		$paket_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_keterangan);
		$paket_keterangan=str_replace("'", '"',$paket_keterangan);
		$paket_du=trim(@$_POST["paket_du"]);
		$paket_dm=trim(@$_POST["paket_dm"]);
		$paket_dultah=trim(@$_POST["paket_dultah"]);
		$paket_dcard=trim(@$_POST["paket_dcard"]);
		$paket_dkolega=trim(@$_POST["paket_dkolega"]);
		$paket_dkeluarga=trim(@$_POST["paket_dkeluarga"]);
		$paket_downer=trim(@$_POST["paket_downer"]);
		$paket_dgrooming=trim(@$_POST["paket_dgrooming"]);
		$paket_dwartawan=trim(@$_POST["paket_dwartawan"]);
		$paket_dstaffdokter=trim(@$_POST["paket_dstaffdokter"]);
		$paket_dstaffnondokter=trim(@$_POST["paket_dstaffnondokter"]);
		$paket_dpromo=trim(@$_POST["paket_dpromo"]);
		$paket_point=trim(@$_POST["paket_point"]);
		$paket_harga=trim(@$_POST["paket_harga"]);
		$paket_harga_ki=trim(@$_POST["paket_harga_ki"]);
		$paket_harga_mdn=trim(@$_POST["paket_harga_mdn"]);
		$paket_harga_mnd=trim(@$_POST["paket_harga_mnd"]);
		$paket_harga_ygk=trim(@$_POST["paket_harga_ygk"]);
		$paket_harga_mta=trim(@$_POST["paket_harga_mta"]);
		$paket_harga_btm=trim(@$_POST["paket_harga_btm"]);
		$paket_harga_lbk=trim(@$_POST["paket_harga_lbk"]);
		$paket_harga_hr=trim(@$_POST["paket_harga_hr"]);
		$paket_harga_tp=trim(@$_POST["paket_harga_tp"]);
		$paket_harga_dps=trim(@$_POST["paket_harga_dps"]);
		$paket_harga_jkt=trim(@$_POST["paket_harga_jkt"]);
		$paket_harga_blpn=trim(@$_POST["paket_harga_blpn"]);
		$paket_harga_kuta=trim(@$_POST["paket_harga_kuta"]);
		$paket_harga_smg=trim(@$_POST["paket_harga_smg"]);
		$paket_harga_mks=trim(@$_POST["paket_harga_mks"]);
		$paket_harga_mlg=trim(@$_POST["paket_harga_mlg"]);
		$paket_expired=trim(@$_POST["paket_expired"]);
		$paket_aktif=trim(@$_POST["paket_aktif"]);
		$paket_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_aktif);
		$paket_aktif=str_replace("'", '"',$paket_aktif);
		$paket_aktif_th=trim(@$_POST["paket_aktif_th"]);
		$paket_aktif_th=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_aktif_th);
		$paket_aktif_th=str_replace("'", '"',$paket_aktif_th);
		$paket_aktif_ki=trim(@$_POST["paket_aktif_ki"]);
		$paket_aktif_ki=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_aktif_ki);
		$paket_aktif_ki=str_replace("'", '"',$paket_aktif_ki);
		$paket_aktif_hr=trim(@$_POST["paket_aktif_hr"]);
		$paket_aktif_hr=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_aktif_hr);
		$paket_aktif_hr=str_replace("'", '"',$paket_aktif_hr);
		$paket_aktif_tp=trim(@$_POST["paket_aktif_tp"]);
		$paket_aktif_tp=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_aktif_tp);
		$paket_aktif_tp=str_replace("'", '"',$paket_aktif_tp);
		$paket_aktif_dps=trim(@$_POST["paket_aktif_dps"]);
		$paket_aktif_dps=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_aktif_dps);
		$paket_aktif_dps=str_replace("'", '"',$paket_aktif_dps);
		$paket_aktif_jkt=trim(@$_POST["paket_aktif_jkt"]);
		$paket_aktif_jkt=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_aktif_jkt);
		$paket_aktif_jkt=str_replace("'", '"',$paket_aktif_jkt);
		$paket_aktif_mta=trim(@$_POST["paket_aktif_mta"]);
		$paket_aktif_mta=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_aktif_mta);
		$paket_aktif_mta=str_replace("'", '"',$paket_aktif_mta);
		$paket_aktif_blpn=trim(@$_POST["paket_aktif_blpn"]);
		$paket_aktif_blpn=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_aktif_blpn);
		$paket_aktif_blpn=str_replace("'", '"',$paket_aktif_blpn);
		$paket_aktif_kuta=trim(@$_POST["paket_aktif_kuta"]);
		$paket_aktif_kuta=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_aktif_kuta);
		$paket_aktif_kuta=str_replace("'", '"',$paket_aktif_kuta);
		$paket_aktif_btm=trim(@$_POST["paket_aktif_btm"]);
		$paket_aktif_btm=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_aktif_btm);
		$paket_aktif_btm=str_replace("'", '"',$paket_aktif_btm);
		$paket_aktif_mks=trim(@$_POST["paket_aktif_mks"]);
		$paket_aktif_mks=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_aktif_mks);
		$paket_aktif_mks=str_replace("'", '"',$paket_aktif_mks);
		$paket_aktif_mdn=trim(@$_POST["paket_aktif_mdn"]);
		$paket_aktif_mdn=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_aktif_mdn);
		$paket_aktif_mdn=str_replace("'", '"',$paket_aktif_mdn);
		$paket_aktif_lbk=trim(@$_POST["paket_aktif_lbk"]);
		$paket_aktif_lbk=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_aktif_lbk);
		$paket_aktif_lbk=str_replace("'", '"',$paket_aktif_lbk);
		$paket_aktif_mnd=trim(@$_POST["paket_aktif_mnd"]);
		$paket_aktif_mnd=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_aktif_mnd);
		$paket_aktif_mnd=str_replace("'", '"',$paket_aktif_mnd);
		$paket_aktif_ygk=trim(@$_POST["paket_aktif_ygk"]);
		$paket_aktif_ygk=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_aktif_ygk);
		$paket_aktif_ygk=str_replace("'", '"',$paket_aktif_ygk);
		$paket_aktif_mlg=trim(@$_POST["paket_aktif_mlg"]);
		$paket_aktif_mlg=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_aktif_mlg);
		$paket_aktif_mlg=str_replace("'", '"',$paket_aktif_mlg);
		$paket_aktif_smg=trim(@$_POST["paket_aktif_smg"]);
		$paket_aktif_smg=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_aktif_smg);
		$paket_aktif_smg=str_replace("'", '"',$paket_aktif_smg);
		
		$result=$this->m_paket->paket_create($paket_kode ,$paket_kodelama ,$paket_nama , $paket_group ,$paket_kategori, $paket_edit_harga,  $paket_keterangan ,
											$paket_du ,$paket_dm , $paket_dultah, $paket_dcard, $paket_dkolega, $paket_dkeluarga, $paket_downer, $paket_dgrooming, $paket_dwartawan, $paket_dstaffdokter, $paket_dpromo, $paket_dstaffnondokter,
											$paket_point ,$paket_harga ,$paket_expired ,$paket_aktif ,$paket_aktif_th ,$paket_aktif_ki ,$paket_aktif_hr ,$paket_aktif_tp ,$paket_aktif_dps ,$paket_aktif_jkt,$paket_aktif_mta ,$paket_aktif_blpn ,$paket_aktif_kuta ,$paket_aktif_btm ,$paket_aktif_mks ,$paket_aktif_mdn ,$paket_aktif_lbk ,$paket_aktif_mnd ,$paket_aktif_ygk,$paket_aktif_mlg, $paket_aktif_smg,$paket_harga_ki,$paket_harga_mdn,$paket_harga_mnd,$paket_harga_ygk,$paket_harga_mta,$paket_harga_btm, $paket_harga_lbk, $paket_harga_hr, $paket_harga_tp, $paket_harga_dps, $paket_harga_blpn, $paket_harga_kuta, $paket_harga_jkt,$paket_harga_smg, $paket_harga_mks, $paket_harga_mlg);
		echo $result;
	}

	//function for delete selected record
	function paket_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_paket->paket_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function paket_search(){
		//POST varibale here
		$paket_id=trim(@$_POST["paket_id"]);
		$paket_kode=trim(@$_POST["paket_kode"]);
		$paket_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_kode);
		$paket_kode=str_replace("'", '"',$paket_kode);
		$paket_kodelama=trim(@$_POST["paket_kodelama"]);
		$paket_kodelama=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_kodelama);
		$paket_kodelama=str_replace("'", '"',$paket_kodelama);
		$paket_nama=trim(@$_POST["paket_nama"]);
		$paket_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_nama);
		$paket_nama=str_replace("'", '"',$paket_nama);
		$paket_group=trim(@$_POST["paket_group"]);
		$paket_kategori=trim(@$_POST["paket_kategori"]);
		$paket_keterangan=trim(@$_POST["paket_keterangan"]);
		$paket_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_keterangan);
		$paket_keterangan=str_replace("'", '"',$paket_keterangan);
		$paket_du=trim(@$_POST["paket_du"]);
		$paket_dm=trim(@$_POST["paket_dm"]);
		$paket_dultah=trim(@$_POST["paket_dultah"]);
		$paket_dcard=trim(@$_POST["paket_dcard"]);
		$paket_dkolega=trim(@$_POST["paket_dkolega"]);
		$paket_dkeluarga=trim(@$_POST["paket_dkeluarga"]);
		$paket_downer=trim(@$_POST["paket_downer"]);
		$paket_dgrooming=trim(@$_POST["paket_dgrooming"]);
		$paket_point=trim(@$_POST["paket_point"]);
		$paket_harga=trim(@$_POST["paket_harga"]);
		$paket_expired=trim(@$_POST["paket_expired"]);
		$paket_aktif=trim(@$_POST["paket_aktif"]);
		$paket_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_aktif);
		$paket_aktif=str_replace("'", '"',$paket_aktif);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_paket->paket_search($paket_id, $paket_kode, $paket_kodelama, $paket_nama, $paket_group,$paket_kategori, $paket_keterangan ,
												$paket_du, $paket_dm, $paket_dultah, $paket_dcard, $paket_dkolega, $paket_dkeluarga, $paket_downer, $paket_dgrooming,
												$paket_point, $paket_harga, $paket_expired, $paket_aktif, $start, $end);
		echo $result;
	}


	function paket_print(){
  		//POST varibale here
		$paket_kode=trim(@$_POST["paket_kode"]);
		$paket_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_kode);
		$paket_kode=str_replace("'", '"',$paket_kode);
		$paket_kodelama=trim(@$_POST["paket_kodelama"]);
		$paket_kodelama=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_kodelama);
		$paket_kodelama=str_replace("'", '"',$paket_kodelama);
		$paket_nama=trim(@$_POST["paket_nama"]);
		$paket_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_nama);
		$paket_nama=str_replace("'", '"',$paket_nama);
		$paket_group=trim(@$_POST["paket_group"]);
		$paket_keterangan=trim(@$_POST["paket_keterangan"]);
		$paket_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_keterangan);
		$paket_keterangan=str_replace("'", '"',$paket_keterangan);
		$paket_du=trim(@$_POST["paket_du"]);
		$paket_dm=trim(@$_POST["paket_dm"]);
		$paket_dultah=trim(@$_POST["paket_dultah"]);
		$paket_dcard=trim(@$_POST["paket_dcard"]);
		$paket_dkolega=trim(@$_POST["paket_dkolega"]);
		$paket_dkeluarga=trim(@$_POST["paket_dkeluarga"]);
		$paket_downer=trim(@$_POST["paket_downer"]);
		$paket_dgrooming=trim(@$_POST["paket_dgrooming"]);
		$paket_point=trim(@$_POST["paket_point"]);
		$paket_harga=trim(@$_POST["paket_harga"]);
		$paket_expired=trim(@$_POST["paket_expired"]);
		$paket_aktif=trim(@$_POST["paket_aktif"]);
		$paket_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_aktif);
		$paket_aktif=str_replace("'", '"',$paket_aktif);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$result = $this->m_paket->paket_print($paket_kode 
												,$paket_kodelama 
												,$paket_nama 
												,$paket_group 
												,$paket_keterangan 
												,$paket_du 
												,$paket_dm
												,$paket_dultah
												,$paket_dcard
												,$paket_dkolega
												,$paket_dkeluarga
												,$paket_downer
												,$paket_dgrooming
												,$paket_point 
												,$paket_harga 
												,$paket_expired 
												,$paket_aktif 
												,$option
												,$filter);
		$nbrows=$result->num_rows();
		$totcolumn=16;
   		/* We now have our array, let's build our HTML file */
		$file = fopen("paketlist.html",'w');
		fwrite($file, "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Printing the Paket Grid</title><link rel='stylesheet' type='text/css' href='assets/modules/main/css/printstyle.css'/></head>");
		fwrite($file, "<body onload='window.print()'><table summary='Paket List'><caption>DAFTAR PAKET</caption><thead><tr><th scope='col'>No.</th><th scope='col'>Kode Lama</th><th scope='col'>Kode Baru</th><th scope='col'>Nama</th><th scope='col'>Group</th><th scope='col'>Du</th><th scope='col'>Dm</th><th scope='col'>Point</th><th scope='col'>Harga</th><th scope='col'>Expired</th><th scope='col'>Aktif</th></tr></thead><tfoot><tr><th scope='row'>Total</th><td colspan='$totcolumn'>");
		fwrite($file, $nbrows);
		fwrite($file, " Paket</td></tr></tfoot><tbody>");
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
				fwrite($file, $data['paket_kodelama']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['paket_kode']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['paket_nama']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['group_nama']);
				fwrite($file,"</td><td>");
				// fwrite($file, $data['paket_keterangan']);
				// fwrite($file,"</td><td>");
				fwrite($file, $data['paket_du']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['paket_dm']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['paket_dultah']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['paket_dcard']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['paket_dkolega']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['paket_dkeluarga']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['paket_downer']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['paket_dgrooming']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['paket_point']);
				fwrite($file,"</td><td>");
				fwrite($file, number_format($data['paket_harga']));
				fwrite($file,"</td><td>");
				fwrite($file, $data['paket_expired']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['paket_aktif']);
				fwrite($file, "</td></tr>");
				// fwrite($file, $data['paket_creator']);
				// fwrite($file, "</td></tr>");
				// fwrite($file, $data['paket_date_create']);
				// fwrite($file, "</td></tr>");
				// fwrite($file, $data['paket_update']);
				// fwrite($file, "</td></tr>");
				// fwrite($file, $data['paket_date_update']);
				// fwrite($file, "</td></tr>");
				// fwrite($file, $data['paket_revised']);
				// fwrite($file, "</td></tr>");
			}
		}
		fwrite($file, "</tbody></table></body></html>");	
		fclose($file);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function paket_export_excel(){
		//POST varibale here
		$paket_kode=trim(@$_POST["paket_kode"]);
		$paket_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_kode);
		$paket_kode=str_replace("'", '"',$paket_kode);
		$paket_kodelama=trim(@$_POST["paket_kodelama"]);
		$paket_kodelama=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_kodelama);
		$paket_kodelama=str_replace("'", '"',$paket_kodelama);
		$paket_nama=trim(@$_POST["paket_nama"]);
		$paket_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_nama);
		$paket_nama=str_replace("'", '"',$paket_nama);
		$paket_group=trim(@$_POST["paket_group"]);
		$paket_keterangan=trim(@$_POST["paket_keterangan"]);
		$paket_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_keterangan);
		$paket_keterangan=str_replace("'", '"',$paket_keterangan);
		$paket_du=trim(@$_POST["paket_du"]);
		$paket_dm=trim(@$_POST["paket_dm"]);
		$paket_dultah=trim(@$_POST["paket_dultah"]);
		$paket_dcard=trim(@$_POST["paket_dcard"]);
		$paket_dkolega=trim(@$_POST["paket_dkolega"]);
		$paket_dkeluarga=trim(@$_POST["paket_dkeluarga"]);
		$paket_downer=trim(@$_POST["paket_downer"]);
		$paket_dgrooming=trim(@$_POST["paket_dgrooming"]);
		$paket_point=trim(@$_POST["paket_point"]);
		$paket_harga=trim(@$_POST["paket_harga"]);
		$paket_expired=trim(@$_POST["paket_expired"]);
		$paket_aktif=trim(@$_POST["paket_aktif"]);
		$paket_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_aktif);
		$paket_aktif=str_replace("'", '"',$paket_aktif);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_paket->paket_export_excel($paket_kode ,$paket_kodelama ,$paket_nama ,$paket_group ,$paket_keterangan ,
												$paket_du ,$paket_dm , $paket_dultah, $paket_dcard, $paket_dkolega, $paket_dkeluarga, $paket_downer, $paket_dgrooming,
												$paket_point ,$paket_harga ,$paket_expired ,$paket_aktif ,$option,$filter);
		
		$this->load->plugin('to_excel');
		to_excel($query,"paket"); 
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