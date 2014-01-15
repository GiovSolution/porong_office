<?php
/* 
	Miracle IT Team
*/

//class of perawatan
class C_perawatan extends Controller {

	//constructor
	function C_perawatan(){
		parent::Controller();
		session_start();
		$this->load->model('m_perawatan', '', TRUE);
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_perawatan');
	}
	
	function get_jenis_perawatan_list(){
		$result=$this->m_public_function->get_jenis_perawatan_list();
		echo $result;
	}
	
	function get_produk_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : $_GET['query'];
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_perawatan->get_produk_list($query, $start, $end);
		echo $result;
	}
	
	function get_alat_list(){
		$result=$this->m_public_function->get_alat_list();
		echo $result;
	}
	
	function get_satuan_list(){
		$task = isset($_POST['task']) ? @$_POST['task'] : @$_GET['task'];
		$selected_id = isset($_POST['selected_id']) ? @$_POST['selected_id'] : @$_GET['selected_id'];
		$master_id = (integer) (isset($_POST['master_id']) ? @$_POST['master_id'] : @$_GET['master_id']);
		
		if($task=='detail')
			$result=$this->m_perawatan->get_satuan_detail_list($master_id);
		elseif($task=='produk')
			$result=$this->m_perawatan->get_satuan_produk_list($selected_id);
		elseif($task=='selected')
			$result=$this->m_perawatan->get_satuan_selected_list($selected_id);
			
		echo $result;
	}
	
	function get_group_list(){
		$result=$this->m_public_function->get_group_list();
		echo $result;
	}
	
	function get_group_perawatan_list(){
		$result=$this->m_public_function->get_group_perawatan_list();
		echo $result;
	}
	
	function get_kategori_perawatan_list(){
		$result=$this->m_public_function->get_kategori_perawatan_list();
		echo $result;
	}
	
	function get_gudang_list(){
		$result=$this->m_public_function->get_gudang_list();
		echo $result;
	}
	
	function get_kontribusi_rawat_list(){
		$result=$this->m_perawatan->get_kontribusi_rawat_list();
		echo $result;
	}
	
	//for detail action
	//list detail handler action
	function  detail_perawatan_konsumsi_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_perawatan->detail_perawatan_konsumsi_list($master_id,$query,$start,$end);
		echo $result;
	}
	//end of handler
	
	//list detail handler action
	function  detail_perawatan_alat_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_perawatan->detail_perawatan_alat_list($master_id,$query,$start,$end);
		echo $result;
	}
	//end of handler
	
	//purge all detail
	function detail_perawatan_konsumsi_purge(){
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_perawatan->detail_perawatan_konsumsi_purge($master_id);
		echo $result;
	}
	//eof
	
	//purge all detail
	function detail_perawatan_alat_purge(){
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_perawatan->detail_perawatan_alat_purge($master_id);
		echo $result;
	}
	//eof
	
	//get master id, note: not done yet
	function get_master_id(){
		$result=$this->m_perawatan->get_master_id();
		echo $result;
	}
	//
	
	//add detail
	function detail_perawatan_konsumsi_insert(){
	//POST variable here
		/*$krawat_id=trim(@$_POST["krawat_id"]);
		$krawat_master=trim(@$_POST["krawat_master"]);
		$krawat_produk=trim(@$_POST["krawat_produk"]);
		$krawat_satuan=trim(@$_POST["krawat_satuan"]);
		$krawat_jumlah=trim(@$_POST["krawat_jumlah"]);
		$result=$this->m_perawatan->detail_perawatan_konsumsi_insert($krawat_id ,$krawat_master ,$krawat_produk ,$krawat_satuan ,$krawat_jumlah );
		echo $result;*/
		
		$krawat_id=trim(@$_POST["krawat_id"]);
		$krawat_master=trim(@$_POST["krawat_master"]);
		$krawat_satuan=trim(@$_POST["krawat_satuan"]);
		$krawat_produk=trim(@$_POST["krawat_produk"]);
		$krawat_jumlah=trim(@$_POST["krawat_jumlah"]);
		
		$array_krawat_id = json_decode(stripslashes($krawat_id));
		$array_krawat_satuan = json_decode(stripslashes($krawat_satuan));
		$array_krawat_jumlah = json_decode(stripslashes($krawat_jumlah));
		$array_krawat_produk = json_decode(stripslashes($krawat_produk));

		$result=$this->m_perawatan->detail_perawatan_konsumsi_insert($array_krawat_id ,$krawat_master ,$array_krawat_produk ,
																	 $array_krawat_satuan ,$array_krawat_jumlah );
		echo $result;
		
	}
	
	//add detail
	function detail_perawatan_alat_insert(){
	//POST variable here
		/*$arawat_id=trim(@$_POST["arawat_id"]);
		$arawat_master=trim(@$_POST["arawat_master"]);
		$arawat_alat=trim(@$_POST["arawat_alat"]);
		$arawat_jumlah=trim(@$_POST["arawat_jumlah"]);
		$result=$this->m_perawatan->detail_perawatan_alat_insert($arawat_id ,$arawat_master ,$arawat_alat,$arawat_jumlah );
		echo $result;*/
		
		$arawat_id=trim(@$_POST["arawat_id"]);
		$arawat_master=trim(@$_POST["arawat_master"]);
		$arawat_alat=trim(@$_POST["arawat_alat"]);
		$arawat_jumlah=trim(@$_POST["arawat_jumlah"]);
		
		$array_arawat_id = json_decode(stripslashes($arawat_id));
		$array_arawat_jumlah = json_decode(stripslashes($arawat_jumlah));
		$array_arawat_alat = json_decode(stripslashes($arawat_alat));

		$result=$this->m_perawatan->detail_perawatan_alat_insert($array_arawat_id ,$arawat_master ,$array_arawat_alat ,
																 $array_arawat_jumlah );
		echo $result;
		
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->perawatan_list();
				break;
			case "UPDATE":
				$this->perawatan_update();
				break;
			case "CREATE":
				$this->perawatan_create();
				break;
			case "DELETE":
				$this->perawatan_delete();
				break;
			case "SEARCH":
				$this->perawatan_search();
				break;
			case "PRINT":
				$this->perawatan_print();
				break;
			case "EXCEL":
				$this->perawatan_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function perawatan_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		//$query = str_replace(" ", "%",$query);
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_perawatan->perawatan_list($query,$start,$end);
		echo $result;
	}

	//function for update record
	function perawatan_update(){
		//POST variable here
		$rawat_id=trim(@$_POST["rawat_id"]);
		$rawat_kode=trim(@$_POST["rawat_kode"]);
		$rawat_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_kode);
		$rawat_kode=str_replace(",", ",",$rawat_kode);
		$rawat_kode=str_replace("'", '"',$rawat_kode);
		$rawat_kodelama=trim(@$_POST["rawat_kodelama"]);
		$rawat_kodelama=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_kodelama);
		$rawat_kodelama=str_replace(",", ",",$rawat_kodelama);
		$rawat_kodelama=str_replace("'", '"',$rawat_kodelama);
		$rawat_nama=trim(@$_POST["rawat_nama"]);
		$rawat_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_nama);
		$rawat_nama=str_replace(",", ",",$rawat_nama);
		$rawat_nama=str_replace("'", '"',$rawat_nama);
		$rawat_highmargin=trim(@$_POST["rawat_highmargin"]);
		$rawat_edit_harga=trim(@$_POST["rawat_edit_harga"]);
		$rawat_group=trim(@$_POST["rawat_group"]);
		$rawat_kategori=trim(@$_POST["rawat_kategori"]);
		$rawat_kontribusi=trim(@$_POST["rawat_kontribusi"]);
		$rawat_jenis=trim(@$_POST["rawat_jenis"]);
		$rawat_keterangan=trim(@$_POST["rawat_keterangan"]);
		$rawat_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_keterangan);
		$rawat_keterangan=str_replace(",", ",",$rawat_keterangan);
		$rawat_keterangan=str_replace("'", '"',$rawat_keterangan);
		$rawat_du=trim(@$_POST["rawat_du"]);
		$rawat_dm=trim(@$_POST["rawat_dm"]);
		$rawat_dultah=trim(@$_POST["rawat_dultah"]);
		$rawat_dcard=trim(@$_POST["rawat_dcard"]);
		$rawat_dkolega=trim(@$_POST["rawat_dkolega"]);
		$rawat_dkeluarga=trim(@$_POST["rawat_dkeluarga"]);
		$rawat_downer=trim(@$_POST["rawat_downer"]);
		$rawat_dgrooming=trim(@$_POST["rawat_dgrooming"]);
		$rawat_dwartawan=trim(@$_POST["rawat_dwartawan"]);
		$rawat_dstaffdokter=trim(@$_POST["rawat_dstaffdokter"]);
		$rawat_dstaffnondokter=trim(@$_POST["rawat_dstaffnondokter"]);
		$rawat_dpromo=trim(@$_POST["rawat_dpromo"]);
		$rawat_point=trim(@$_POST["rawat_point"]);
		$rawat_durasi=trim(@$_POST["rawat_durasi"]);
		$rawat_kredit=trim(@$_POST["rawat_kredit"]);
		$rawat_kreditrp=trim(@$_POST["rawat_kreditrp"]);
		$rawat_jumlah_tindakan=trim(@$_POST["rawat_jumlah_tindakan"]);
		$rawat_harga=trim(@$_POST["rawat_harga"]);
		$rawat_harga_ki=trim(@$_POST["rawat_harga_ki"]);
		$rawat_harga_mdn=trim(@$_POST["rawat_harga_mdn"]);
		$rawat_harga_mnd=trim(@$_POST["rawat_harga_mnd"]);
		$rawat_harga_ygk=trim(@$_POST["rawat_harga_ygk"]);
		$rawat_harga_mta=trim(@$_POST["rawat_harga_mta"]);
		$rawat_harga_lbk=trim(@$_POST["rawat_harga_lbk"]);
		$rawat_harga_hr=trim(@$_POST["rawat_harga_hr"]);
		$rawat_harga_tp=trim(@$_POST["rawat_harga_tp"]);
		$rawat_harga_dps=trim(@$_POST["rawat_harga_dps"]);
		$rawat_harga_jkt=trim(@$_POST["rawat_harga_jkt"]);
		$rawat_harga_blpn=trim(@$_POST["rawat_harga_blpn"]);
		$rawat_harga_kuta=trim(@$_POST["rawat_harga_kuta"]);
		$rawat_harga_btm=trim(@$_POST["rawat_harga_btm"]);
		$rawat_harga_smg=trim(@$_POST["rawat_harga_smg"]);
		$rawat_harga_mks=trim(@$_POST["rawat_harga_mks"]);
		$rawat_harga_mlg=trim(@$_POST["rawat_harga_mlg"]);
		$rawat_gudang=trim(@$_POST["rawat_gudang"]);
		$rawat_aktif=trim(@$_POST["rawat_aktif"]);
		$rawat_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_aktif);
		$rawat_aktif=str_replace(",", ",",$rawat_aktif);
		$rawat_aktif=str_replace("'", '"',$rawat_aktif);
		
		$rawat_aktif_th=trim(@$_POST["rawat_aktif_th"]);
		$rawat_aktif_th=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_aktif_th);
		$rawat_aktif_th=str_replace(",", ",",$rawat_aktif_th);
		$rawat_aktif_th=str_replace("'", '"',$rawat_aktif_th);
		$rawat_aktif_ki=trim(@$_POST["rawat_aktif_ki"]);
		$rawat_aktif_ki=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_aktif_ki);
		$rawat_aktif_ki=str_replace(",", ",",$rawat_aktif_ki);
		$rawat_aktif_ki=str_replace("'", '"',$rawat_aktif_ki);
		$rawat_aktif_hr=trim(@$_POST["rawat_aktif_hr"]);
		$rawat_aktif_hr=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_aktif_hr);
		$rawat_aktif_hr=str_replace(",", ",",$rawat_aktif_hr);
		$rawat_aktif_hr=str_replace("'", '"',$rawat_aktif_hr);
		$rawat_aktif_tp=trim(@$_POST["rawat_aktif_tp"]);
		$rawat_aktif_tp=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_aktif_tp);
		$rawat_aktif_tp=str_replace(",", ",",$rawat_aktif_tp);
		$rawat_aktif_tp=str_replace("'", '"',$rawat_aktif_tp);
		$rawat_aktif_dps=trim(@$_POST["rawat_aktif_dps"]);
		$rawat_aktif_dps=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_aktif_dps);
		$rawat_aktif_dps=str_replace(",", ",",$rawat_aktif_dps);
		$rawat_aktif_dps=str_replace("'", '"',$rawat_aktif_dps);
		$rawat_aktif_jkt=trim(@$_POST["rawat_aktif_jkt"]);
		$rawat_aktif_jkt=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_aktif_jkt);
		$rawat_aktif_jkt=str_replace(",", ",",$rawat_aktif_jkt);
		$rawat_aktif_jkt=str_replace("'", '"',$rawat_aktif_jkt);
		$rawat_aktif_mta=trim(@$_POST["rawat_aktif_mta"]);
		$rawat_aktif_mta=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_aktif_mta);
		$rawat_aktif_mta=str_replace(",", ",",$rawat_aktif_mta);
		$rawat_aktif_mta=str_replace("'", '"',$rawat_aktif_mta);
		$rawat_aktif_blpn=trim(@$_POST["rawat_aktif_blpn"]);
		$rawat_aktif_blpn=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_aktif_blpn);
		$rawat_aktif_blpn=str_replace(",", ",",$rawat_aktif_blpn);
		$rawat_aktif_blpn=str_replace("'", '"',$rawat_aktif_blpn);
		$rawat_aktif_kuta=trim(@$_POST["rawat_aktif_kuta"]);
		$rawat_aktif_kuta=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_aktif_kuta);
		$rawat_aktif_kuta=str_replace(",", ",",$rawat_aktif_kuta);
		$rawat_aktif_kuta=str_replace("'", '"',$rawat_aktif_kuta);
		$rawat_aktif_btm=trim(@$_POST["rawat_aktif_btm"]);
		$rawat_aktif_btm=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_aktif_btm);
		$rawat_aktif_btm=str_replace(",", ",",$rawat_aktif_btm);
		$rawat_aktif_btm=str_replace("'", '"',$rawat_aktif_btm);
		$rawat_aktif_mks=trim(@$_POST["rawat_aktif_mks"]);
		$rawat_aktif_mks=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_aktif_mks);
		$rawat_aktif_mks=str_replace(",", ",",$rawat_aktif_mks);
		$rawat_aktif_mks=str_replace("'", '"',$rawat_aktif_mks);
		$rawat_aktif_mdn=trim(@$_POST["rawat_aktif_mdn"]);
		$rawat_aktif_mdn=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_aktif_mdn);
		$rawat_aktif_mdn=str_replace(",", ",",$rawat_aktif_mdn);
		$rawat_aktif_mdn=str_replace("'", '"',$rawat_aktif_mdn);
		$rawat_aktif_lbk=trim(@$_POST["rawat_aktif_lbk"]);
		$rawat_aktif_lbk=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_aktif_lbk);
		$rawat_aktif_lbk=str_replace(",", ",",$rawat_aktif_lbk);
		$rawat_aktif_lbk=str_replace("'", '"',$rawat_aktif_lbk);
		$rawat_aktif_mnd=trim(@$_POST["rawat_aktif_mnd"]);
		$rawat_aktif_mnd=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_aktif_mnd);
		$rawat_aktif_mnd=str_replace(",", ",",$rawat_aktif_mnd);
		$rawat_aktif_mnd=str_replace("'", '"',$rawat_aktif_mnd);
		$rawat_aktif_ygk=trim(@$_POST["rawat_aktif_ygk"]);
		$rawat_aktif_ygk=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_aktif_ygk);
		$rawat_aktif_ygk=str_replace(",", ",",$rawat_aktif_ygk);
		$rawat_aktif_ygk=str_replace("'", '"',$rawat_aktif_ygk);
		$rawat_aktif_mlg=trim(@$_POST["rawat_aktif_mlg"]);
		$rawat_aktif_mlg=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_aktif_mlg);
		$rawat_aktif_mlg=str_replace(",", ",",$rawat_aktif_mlg);
		$rawat_aktif_mlg=str_replace("'", '"',$rawat_aktif_mlg);
		$rawat_aktif_smg=trim(@$_POST["rawat_aktif_smg"]);
		$rawat_aktif_smg=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_aktif_smg);
		$rawat_aktif_smg=str_replace(",", ",",$rawat_aktif_smg);
		$rawat_aktif_smg=str_replace("'", '"',$rawat_aktif_smg);
		
		$result = $this->m_perawatan->perawatan_update($rawat_id ,$rawat_kode ,$rawat_kodelama ,$rawat_nama, $rawat_highmargin, $rawat_edit_harga, $rawat_group ,$rawat_kategori, $rawat_kontribusi ,$rawat_jenis ,$rawat_keterangan ,
														$rawat_du ,$rawat_dm , $rawat_dultah, $rawat_dcard, $rawat_dkolega, $rawat_dkeluarga, $rawat_downer, $rawat_dgrooming, $rawat_dwartawan, $rawat_dstaffdokter, $rawat_dstaffnondokter,$rawat_dpromo,
														$rawat_point , $rawat_durasi, $rawat_kredit, $rawat_kreditrp, $rawat_jumlah_tindakan, $rawat_harga ,$rawat_gudang ,$rawat_aktif,$rawat_aktif_th ,$rawat_aktif_ki ,$rawat_aktif_hr ,$rawat_aktif_tp ,$rawat_aktif_dps ,$rawat_aktif_jkt ,$rawat_aktif_mta ,$rawat_aktif_blpn ,$rawat_aktif_kuta ,$rawat_aktif_btm ,$rawat_aktif_mks ,$rawat_aktif_mdn ,$rawat_aktif_lbk ,$rawat_aktif_mnd ,$rawat_aktif_ygk,$rawat_aktif_mlg,$rawat_aktif_smg, $rawat_harga_ki,$rawat_harga_mdn,$rawat_harga_mnd,$rawat_harga_ygk,$rawat_harga_mta, $rawat_harga_lbk, $rawat_harga_hr, $rawat_harga_tp, $rawat_harga_dps, $rawat_harga_blpn, $rawat_harga_kuta,$rawat_harga_btm, $rawat_harga_jkt, $rawat_harga_smg, $rawat_harga_mks, $rawat_harga_mlg);
		echo $result;
	}
	
	//function for create new record
	function perawatan_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$rawat_kode=trim(@$_POST["rawat_kode"]);
		$rawat_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_kode);
		$rawat_kode=str_replace("'", '"',$rawat_kode);
		$rawat_kodelama=trim(@$_POST["rawat_kodelama"]);
		$rawat_kodelama=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_kodelama);
		$rawat_kodelama=str_replace("'", '"',$rawat_kodelama);
		$rawat_nama=trim(@$_POST["rawat_nama"]);
		$rawat_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_nama);
		$rawat_nama=str_replace("'", '"',$rawat_nama);
		$rawat_highmargin=trim(@$_POST["rawat_highmargin"]);
		$rawat_edit_harga=trim(@$_POST["rawat_edit_harga"]);
		$rawat_group=trim(@$_POST["rawat_group"]);
		$rawat_kategori=trim(@$_POST["rawat_kategori"]);
		$rawat_kontribusi=trim(@$_POST["rawat_kontribusi"]);
		$rawat_jenis=trim(@$_POST["rawat_jenis"]);
		$rawat_keterangan=trim(@$_POST["rawat_keterangan"]);
		$rawat_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_keterangan);
		$rawat_keterangan=str_replace("'", '"',$rawat_keterangan);
		$rawat_du=trim(@$_POST["rawat_du"]);
		$rawat_dm=trim(@$_POST["rawat_dm"]);
		$rawat_dultah=trim(@$_POST["rawat_dultah"]);
		$rawat_dcard=trim(@$_POST["rawat_dcard"]);
		$rawat_dkolega=trim(@$_POST["rawat_dkolega"]);
		$rawat_dkeluarga=trim(@$_POST["rawat_dkeluarga"]);
		$rawat_downer=trim(@$_POST["rawat_downer"]);
		$rawat_dgrooming=trim(@$_POST["rawat_dgrooming"]);
		$rawat_dwartawan=trim(@$_POST["rawat_dwartawan"]);
		$rawat_dstaffdokter=trim(@$_POST["rawat_dstaffdokter"]);
		$rawat_dstaffnondokter=trim(@$_POST["rawat_dstaffnondokter"]);
		$rawat_dpromo=trim(@$_POST["rawat_dpromo"]);
		$rawat_point=trim(@$_POST["rawat_point"]);
		$rawat_durasi=trim(@$_POST["rawat_durasi"]);
		$rawat_kredit=trim(@$_POST["rawat_kredit"]);
		$rawat_kreditrp=trim(@$_POST["rawat_kreditrp"]);
		$rawat_jumlah_tindakan=trim(@$_POST["rawat_jumlah_tindakan"]);
		$rawat_harga=trim(@$_POST["rawat_harga"]);
		$rawat_harga_ki=trim(@$_POST["rawat_harga_ki"]);
		$rawat_harga_mdn=trim(@$_POST["rawat_harga_mdn"]);
		$rawat_harga_mnd=trim(@$_POST["rawat_harga_mnd"]);
		$rawat_harga_ygk=trim(@$_POST["rawat_harga_ygk"]);
		$rawat_harga_mta=trim(@$_POST["rawat_harga_mta"]);
		$rawat_harga_lbk=trim(@$_POST["rawat_harga_lbk"]);
		$rawat_harga_hr=trim(@$_POST["rawat_harga_hr"]);
		$rawat_harga_tp=trim(@$_POST["rawat_harga_tp"]);
		$rawat_harga_dps=trim(@$_POST["rawat_harga_dps"]);
		$rawat_harga_jkt=trim(@$_POST["rawat_harga_jkt"]);
		$rawat_harga_blpn=trim(@$_POST["rawat_harga_blpn"]);
		$rawat_harga_kuta=trim(@$_POST["rawat_harga_kuta"]);
		$rawat_harga_btm=trim(@$_POST["rawat_harga_btm"]);
		$rawat_harga_smg=trim(@$_POST["rawat_harga_smg"]);
		$rawat_harga_mks=trim(@$_POST["rawat_harga_mks"]);
		$rawat_harga_mlg=trim(@$_POST["rawat_harga_mlg"]);
		$rawat_gudang=trim(@$_POST["rawat_gudang"]);
		$rawat_aktif=trim(@$_POST["rawat_aktif"]);
		$rawat_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_aktif);
		$rawat_aktif=str_replace("'", '"',$rawat_aktif);
		$rawat_aktif_th=trim(@$_POST["rawat_aktif_th"]);
		$rawat_aktif_th=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_aktif_th);
		$rawat_aktif_th=str_replace("'", '"',$rawat_aktif_th);
		$rawat_aktif_ki=trim(@$_POST["rawat_aktif_ki"]);
		$rawat_aktif_ki=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_aktif_ki);
		$rawat_aktif_ki=str_replace("'", '"',$rawat_aktif_ki);
		$rawat_aktif_hr=trim(@$_POST["rawat_aktif_hr"]);
		$rawat_aktif_hr=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_aktif_hr);
		$rawat_aktif_hr=str_replace("'", '"',$rawat_aktif_hr);
		$rawat_aktif_tp=trim(@$_POST["rawat_aktif_tp"]);
		$rawat_aktif_tp=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_aktif_tp);
		$rawat_aktif_tp=str_replace("'", '"',$rawat_aktif_tp);
		$rawat_aktif_dps=trim(@$_POST["rawat_aktif_dps"]);
		$rawat_aktif_dps=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_aktif_dps);
		$rawat_aktif_dps=str_replace("'", '"',$rawat_aktif_dps);
		$rawat_aktif_jkt=trim(@$_POST["rawat_aktif_jkt"]);
		$rawat_aktif_jkt=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_aktif_jkt);
		$rawat_aktif_jkt=str_replace("'", '"',$rawat_aktif_jkt);
		$rawat_aktif_mta=trim(@$_POST["rawat_aktif_mta"]);
		$rawat_aktif_mta=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_aktif_mta);
		$rawat_aktif_mta=str_replace("'", '"',$rawat_aktif_mta);
		$rawat_aktif_blpn=trim(@$_POST["rawat_aktif_blpn"]);
		$rawat_aktif_blpn=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_aktif_blpn);
		$rawat_aktif_blpn=str_replace("'", '"',$rawat_aktif_blpn);
		$rawat_aktif_kuta=trim(@$_POST["rawat_aktif_kuta"]);
		$rawat_aktif_kuta=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_aktif_kuta);
		$rawat_aktif_kuta=str_replace("'", '"',$rawat_aktif_kuta);
		$rawat_aktif_btm=trim(@$_POST["rawat_aktif_btm"]);
		$rawat_aktif_btm=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_aktif_btm);
		$rawat_aktif_btm=str_replace("'", '"',$rawat_aktif_btm);
		$rawat_aktif_mks=trim(@$_POST["rawat_aktif_mks"]);
		$rawat_aktif_mks=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_aktif_mks);
		$rawat_aktif_mks=str_replace("'", '"',$rawat_aktif_mks);
		$rawat_aktif_mdn=trim(@$_POST["rawat_aktif_mdn"]);
		$rawat_aktif_mdn=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_aktif_mdn);
		$rawat_aktif_mdn=str_replace("'", '"',$rawat_aktif_mdn);
		$rawat_aktif_lbk=trim(@$_POST["rawat_aktif_lbk"]);
		$rawat_aktif_lbk=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_aktif_lbk);
		$rawat_aktif_lbk=str_replace("'", '"',$rawat_aktif_lbk);
		$rawat_aktif_mnd=trim(@$_POST["rawat_aktif_mnd"]);
		$rawat_aktif_mnd=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_aktif_mnd);
		$rawat_aktif_mnd=str_replace("'", '"',$rawat_aktif_mnd);
		$rawat_aktif_ygk=trim(@$_POST["rawat_aktif_ygk"]);
		$rawat_aktif_ygk=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_aktif_ygk);
		$rawat_aktif_ygk=str_replace("'", '"',$rawat_aktif_ygk);
		$rawat_aktif_mlg=trim(@$_POST["rawat_aktif_mlg"]);
		$rawat_aktif_mlg=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_aktif_mlg);
		$rawat_aktif_mlg=str_replace("'", '"',$rawat_aktif_mlg);
		$rawat_aktif_smg=trim(@$_POST["rawat_aktif_smg"]);
		$rawat_aktif_smg=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_aktif_smg);
		$rawat_aktif_smg=str_replace("'", '"',$rawat_aktif_smg);
		
		$result=$this->m_perawatan->perawatan_create($rawat_kode ,$rawat_kodelama ,$rawat_nama ,$rawat_highmargin, $rawat_edit_harga, $rawat_group,$rawat_kategori, $rawat_kontribusi, $rawat_jenis ,$rawat_keterangan ,
													$rawat_du ,$rawat_dm, $rawat_dultah, $rawat_dcard, $rawat_dkolega, $rawat_dkeluarga, $rawat_downer, $rawat_dgrooming, $rawat_dwartawan, $rawat_dstaffdokter, $rawat_dstaffnondokter, $rawat_dpromo,	$rawat_point, $rawat_durasi, $rawat_kredit, $rawat_kreditrp, $rawat_jumlah_tindakan, $rawat_harga ,$rawat_gudang ,$rawat_aktif,$rawat_aktif_th ,$rawat_aktif_ki ,$rawat_aktif_hr ,$rawat_aktif_tp ,$rawat_aktif_dps ,$rawat_aktif_jkt ,$rawat_aktif_mta, $rawat_aktif_blpn ,$rawat_aktif_kuta ,$rawat_aktif_btm ,$rawat_aktif_mks ,$rawat_aktif_mdn ,$rawat_aktif_lbk ,$rawat_aktif_mnd ,$rawat_aktif_ygk,$rawat_aktif_mlg ,$rawat_aktif_smg, $rawat_harga_ki,$rawat_harga_mdn,$rawat_harga_mnd,$rawat_harga_ygk,$rawat_harga_mta, $rawat_harga_lbk, $rawat_harga_hr, $rawat_harga_tp, $rawat_harga_dps, $rawat_harga_blpn, $rawat_harga_kuta, $rawat_harga_btm, $rawat_harga_jkt, $rawat_harga_smg, $rawat_harga_mks, $rawat_harga_mlg);
		echo $result;
	}

	//function for delete selected record
	function perawatan_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_perawatan->perawatan_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function perawatan_search(){
		//POST varibale here
		$rawat_id=trim(@$_POST["rawat_id"]);
		$rawat_kode=trim(@$_POST["rawat_kode"]);
		$rawat_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_kode);
		$rawat_kode=str_replace("'", '"',$rawat_kode);
		$rawat_kodelama=trim(@$_POST["rawat_kodelama"]);
		$rawat_kodelama=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_kodelama);
		$rawat_kodelama=str_replace("'", '"',$rawat_kodelama);
		$rawat_nama=trim(@$_POST["rawat_nama"]);
		$rawat_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_nama);
		$rawat_nama=str_replace("'", '"',$rawat_nama);
		$rawat_group=trim(@$_POST["rawat_group"]);
		$rawat_kategori=trim(@$_POST["rawat_kategori"]);
		$kategori2_nama=trim(@$_POST["kategori2_nama"]);
		$rawat_jenis=trim(@$_POST["rawat_jenis"]);
		$rawat_keterangan=trim(@$_POST["rawat_keterangan"]);
		$rawat_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_keterangan);
		$rawat_keterangan=str_replace("'", '"',$rawat_keterangan);
		$rawat_du=trim(@$_POST["rawat_du"]);
		$rawat_dm=trim(@$_POST["rawat_dm"]);
		$rawat_dultah=trim(@$_POST["rawat_dultah"]);
		$rawat_dcard=trim(@$_POST["rawat_dcard"]);
		$rawat_dkolega=trim(@$_POST["rawat_dkolega"]);
		$rawat_dkeluarga=trim(@$_POST["rawat_dkeluarga"]);
		$rawat_downer=trim(@$_POST["rawat_downer"]);
		$rawat_dgrooming=trim(@$_POST["rawat_dgrooming"]);
		$rawat_point=trim(@$_POST["rawat_point"]);
		$rawat_durasi=trim(@$_POST["rawat_durasi"]);
		$rawat_kredit=trim(@$_POST["rawat_kredit"]);
		$rawat_jumlah_tindakan=trim(@$_POST["rawat_jumlah_tindakan"]);
		$rawat_harga=trim(@$_POST["rawat_harga"]);
		$rawat_gudang=trim(@$_POST["rawat_gudang"]);
		$rawat_aktif=trim(@$_POST["rawat_aktif"]);
		$rawat_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_aktif);
		$rawat_aktif=str_replace("'", '"',$rawat_aktif);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_perawatan->perawatan_search($rawat_id ,$rawat_kode ,$rawat_kodelama ,$rawat_nama ,$rawat_group ,$rawat_kategori ,$rawat_jenis ,$rawat_keterangan ,
														$rawat_du ,$rawat_dm ,$rawat_dultah, $rawat_dcard, $rawat_dkolega, $rawat_dkeluarga, $rawat_downer, $rawat_dgrooming,
														$rawat_point , $rawat_durasi, $rawat_kredit, $rawat_jumlah_tindakan, $rawat_harga ,$rawat_gudang ,$rawat_aktif ,$start,$end, $kategori2_nama);
		echo $result;
	}


	function perawatan_print(){
  		//POST varibale here
		$rawat_id=trim(@$_POST["rawat_id"]);
		$rawat_kode=trim(@$_POST["rawat_kode"]);
		$rawat_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_kode);
		$rawat_kode=str_replace("'", '"',$rawat_kode);
		$rawat_kodelama=trim(@$_POST["rawat_kodelama"]);
		$rawat_kodelama=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_kodelama);
		$rawat_kodelama=str_replace("'", '"',$rawat_kodelama);
		$rawat_nama=trim(@$_POST["rawat_nama"]);
		$rawat_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_nama);
		$rawat_nama=str_replace("'", '"',$rawat_nama);
		$rawat_group=trim(@$_POST["rawat_group"]);
		$rawat_kategori=trim(@$_POST["rawat_kategori"]);
		$rawat_jenis=trim(@$_POST["rawat_jenis"]);
		$rawat_keterangan=trim(@$_POST["rawat_keterangan"]);
		$rawat_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_keterangan);
		$rawat_keterangan=str_replace("'", '"',$rawat_keterangan);
		$rawat_du=trim(@$_POST["rawat_du"]);
		$rawat_dm=trim(@$_POST["rawat_dm"]);
		$rawat_dultah=trim(@$_POST["rawat_dultah"]);
		$rawat_dcard=trim(@$_POST["rawat_dcard"]);
		$rawat_dkolega=trim(@$_POST["rawat_dkolega"]);
		$rawat_dkeluarga=trim(@$_POST["rawat_dkeluarga"]);
		$rawat_downer=trim(@$_POST["rawat_downer"]);
		$rawat_dgrooming=trim(@$_POST["rawat_dgrooming"]);
		$rawat_point=trim(@$_POST["rawat_point"]);
		$rawat_durasi=trim(@$_POST["rawat_durasi"]);
		$rawat_kredit=trim(@$_POST["rawat_kredit"]);
		$rawat_jumlah_tindakan=trim(@$_POST["rawat_jumlah_tindakan"]);
		$rawat_harga=trim(@$_POST["rawat_harga"]);
		$rawat_gudang=trim(@$_POST["rawat_gudang"]);
		$rawat_aktif=trim(@$_POST["rawat_aktif"]);
		$rawat_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_aktif);
		$rawat_aktif=str_replace("'", '"',$rawat_aktif);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$this->load->database();
		$result = $this->m_perawatan->perawatan_print($rawat_id 
													,$rawat_kode 
													,$rawat_kodelama 
													,$rawat_nama 
													,$rawat_group 
													,$rawat_kategori 
													,$rawat_jenis 
													,$rawat_keterangan 
													,$rawat_du 
													,$rawat_dm
													,$rawat_dultah
													,$rawat_dcard
													,$rawat_dkolega
													,$rawat_dkeluarga
													,$rawat_downer
													,$rawat_dgrooming
													,$rawat_point
													,$rawat_durasi
													,$rawat_kredit
													,$rawat_jumlah_tindakan
													,$rawat_harga 
													,$rawat_gudang 
													,$rawat_aktif 
													,$option
													,$filter);
		//$this->firephp->log($result, 'result');
		$nbrows=$result->num_rows();
		$totcolumn=23;
   		/* We now have our array, let's build our HTML file */
		$file = fopen("perawatanlist.html",'w');
		fwrite($file, "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Printing the Perawatan Grid</title><link rel='stylesheet' type='text/css' href='assets/modules/main/css/printstyle.css'/></head>");
		fwrite($file, "<body onload='window.print()'><table summary='Perawatan List'><caption>DAFTAR PERAWATAN</caption><thead><tr>
		<th scope='col'>No</th>
		<th scope='col'>Kode Baru</th>
		<th scope='col'>Nama Perawatan</th>
		<th scope='col'>Group1</th>
		<th scope='col'>Group2</th>
		<th scope='col'>Jenis</th>
		<th scope='col'>Gudang</th>
		<th scope='col'>Harga(Rp)</th>
		<th scope='col'>Poin</th>
		<th scope='col'>Kr(Poin)</th>
		<th scope='col'>Kr(Rp)</th>
		<th scope='col'>Status</th>
		<th scope='col'>DU(%)</th>
		<th scope='col'>DM(%)</th>
		<th scope='col'>Ultah</th>
		<th scope='col'>Card</th>
		<th scope='col'>Kolega</th>
		<th scope='col'>Klrga</th>
		<th scope='col'>Owner</th>
		<th scope='col'>Groom</th>
		<th scope='col'>Wrtwn</th>
		<th scope='col'>Staf Dr</th>
		<th scope='col'>Staf Non</th>
		<th scope='col'>Promo</th>
		</tr></thead><tfoot><tr><th scope='row'>Total</th><td colspan='$totcolumn'>");
		fwrite($file, $nbrows);
		fwrite($file, " Perawatan</td></tr></tfoot><tbody>");
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
				fwrite($file,"</td><td>");
				fwrite($file, $data['rawat_kode']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['rawat_nama']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['group_nama']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['jenis_nama']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['kategori_nama']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['gudang_nama']);
				fwrite($file,"</td><td style=\"text-align:right\">");
				fwrite($file, number_format($data['rawat_harga']));
				fwrite($file,"</td><td>");
				fwrite($file, $data['rawat_point']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['rawat_kredit']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['rawat_kreditrp']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['rawat_aktif']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['rawat_du']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['rawat_dm']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['rawat_dultah']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['rawat_dcard']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['rawat_dkolega']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['rawat_dkeluarga']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['rawat_downer']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['rawat_dgrooming']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['rawat_dwartawan']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['rawat_dstaffdokter']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['rawat_dstaffnondokter']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['rawat_dpromo']);
				fwrite($file, "</td></tr>");
			}
		}
		fwrite($file, "</tbody></table></body></html>");	
		fclose($file);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function perawatan_export_excel(){
		//POST varibale here
		$rawat_id=trim(@$_POST["rawat_id"]);
		$rawat_kode=trim(@$_POST["rawat_kode"]);
		$rawat_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_kode);
		$rawat_kode=str_replace("'", '"',$rawat_kode);
		$rawat_kodelama=trim(@$_POST["rawat_kodelama"]);
		$rawat_kodelama=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_kodelama);
		$rawat_kodelama=str_replace("'", '"',$rawat_kodelama);
		$rawat_nama=trim(@$_POST["rawat_nama"]);
		$rawat_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_nama);
		$rawat_nama=str_replace("'", '"',$rawat_nama);
		$rawat_group=trim(@$_POST["rawat_group"]);
		$rawat_kategori=trim(@$_POST["rawat_kategori"]);
		$rawat_jenis=trim(@$_POST["rawat_jenis"]);
		$rawat_keterangan=trim(@$_POST["rawat_keterangan"]);
		$rawat_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_keterangan);
		$rawat_keterangan=str_replace("'", '"',$rawat_keterangan);
		$rawat_du=trim(@$_POST["rawat_du"]);
		$rawat_dm=trim(@$_POST["rawat_dm"]);
		$rawat_dultah=trim(@$_POST["rawat_dultah"]);
		$rawat_dcard=trim(@$_POST["rawat_dcard"]);
		$rawat_dkolega=trim(@$_POST["rawat_dkolega"]);
		$rawat_dkeluarga=trim(@$_POST["rawat_dkeluarga"]);
		$rawat_downer=trim(@$_POST["rawat_downer"]);
		$rawat_dgrooming=trim(@$_POST["rawat_dgrooming"]);
		$rawat_point=trim(@$_POST["rawat_point"]);
		$rawat_durasi=trim(@$_POST["rawat_durasi"]);
		$rawat_kredit=trim(@$_POST["rawat_kredit"]);
		$rawat_jumlah_tindakan=trim(@$_POST["rawat_jumlah_tindakan"]);
		$rawat_harga=trim(@$_POST["rawat_harga"]);
		$rawat_gudang=trim(@$_POST["rawat_gudang"]);
		$rawat_aktif=trim(@$_POST["rawat_aktif"]);
		$rawat_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$rawat_aktif);
		$rawat_aktif=str_replace("'", '"',$rawat_aktif);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_perawatan->perawatan_export_excel(
								$rawat_id ,
								$rawat_kode ,
								$rawat_kodelama ,
								$rawat_nama ,
								$rawat_group ,
								$rawat_kategori ,
								$rawat_jenis ,
								$rawat_keterangan ,
								$rawat_du ,
								$rawat_dm ,
								$rawat_dultah,
								$rawat_dcard,
								$rawat_dkolega,
								$rawat_dkeluarga,
								$rawat_downer,
								$rawat_dgrooming,
								$rawat_point ,
								$rawat_durasi,
								$rawat_kredit, 
								$rawat_jumlah_tindakan, 
								$rawat_harga ,
								$rawat_gudang ,
								$rawat_aktif ,
								$option,
								$filter
							);
		
		$this->load->plugin('to_excel');
		to_excel($query,"perawatan"); 
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