<?php
/* 
		Miracle IT Team
*/

//class of master_jual_paket
class C_master_jual_paket extends Controller {

	//constructor
	function C_master_jual_paket(){
		parent::Controller();
		$this->load->model('m_master_jual_paket', '', TRUE);
		session_start();
		$this->load->plugin('to_excel');
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_master_jual_paket');
	}
	
	function laporan(){
		$this->load->view('main/v_lap_jual_paket');
	}
	
	function print_laporan(){
		$tgl_awal=(isset($_POST['tgl_awal']) ? @$_POST['tgl_awal'] : @$_GET['tgl_awal']);
		$tgl_akhir=(isset($_POST['tgl_akhir']) ? @$_POST['tgl_akhir'] : @$_GET['tgl_akhir']);
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$opsi=(isset($_POST['opsi']) ? @$_POST['opsi'] : @$_GET['opsi']);
		$opsi_status=(isset($_POST['opsi_status']) ? @$_POST['opsi_status'] : @$_GET['opsi_status']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		$group=(isset($_POST['group']) ? @$_POST['group'] : @$_GET['group']);
		
		$data["jenis"]='Paket';
		if($periode=="all"){
			$data["periode"]="Semua Periode";
		}else if($periode=="bulan"){
			$tgl_awal=$tahun."-".$bulan;
			$data["periode"]=get_ina_month_name($bulan,'long')." ".$tahun;
		}else if($periode=="tanggal"){
			$data["periode"]="Periode : ".$tgl_awal." s/d ".$tgl_akhir.", ";
		}
		
		$data["data_print"]=$this->m_master_jual_paket->get_laporan($tgl_awal,$tgl_akhir,$periode,$opsi,$opsi_status,$group);
			
		if($opsi=='rekap'){
			$data["opsi"]='Rekap';
			switch($group){
				case "Tanggal": $print_view=$this->load->view("main/p_rekap_jual_tanggal.php",$data,TRUE);break;
				case "Customer": $print_view=$this->load->view("main/p_rekap_jual_customer.php",$data,TRUE);break;
				case "Voucher": $print_view=$this->load->view("main/p_rekap_jual_voucher.php",$data,TRUE);break;
				default: $print_view=$this->load->view("main/p_rekap_jual.php",$data,TRUE);break;
			}
		}else{
			$data["opsi"]='Detail';
			switch($group){
				case "Tanggal": $print_view=$this->load->view("main/p_detail_jual_tanggal.php",$data,TRUE);break;
				case "Tanggal 2 (PPN)": $print_view=$this->load->view("main/p_detail_jual_tanggal2.php",$data,TRUE);break;
				case "Customer": $print_view=$this->load->view("main/p_detail_jual_customer.php",$data,TRUE);break;
				case "Paket": $print_view=$this->load->view("main/p_detail_jual_produk.php",$data,TRUE);break;
				case "Sales": $print_view=$this->load->view("main/p_detail_jual_sales.php",$data,TRUE);break;
				case "Jenis Diskon": $print_view=$this->load->view("main/p_detail_jual_diskon.php",$data,TRUE);break;
				default: $print_view=$this->load->view("main/p_detail_jual_semua.php",$data,TRUE);break;
			}
		}
		if(!file_exists("print")){
			mkdir("print");
		}
		if($opsi=='rekap')
			$print_file=fopen("print/report_jpaket.html","w+");
		else
			$print_file=fopen("print/report_jpaket.html","w+");
			
		fwrite($print_file, $print_view);
		echo '1'; 
	}
	
	function detail_pengguna_paket_list(){
		$master_id = isset($_POST['master_id']) ? $_POST['master_id'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_master_jual_paket->detail_pengguna_paket_list($master_id,$start,$end);
		echo $result;
	}
	
	function detail_pengguna_paket_insert(){
		$ppaket_id = $_POST['ppaket_id']; // Get our array back and translate it :
		$array_ppaket_id = json_decode(stripslashes($ppaket_id));
		
		$ppaket_master=trim(@$_POST["ppaket_master"]);
		
		$ppaket_cust = $_POST['ppaket_cust']; // Get our array back and translate it :
		$array_ppaket_cust = json_decode(stripslashes($ppaket_cust));
		
		$result=$this->m_master_jual_paket->detail_pengguna_paket_insert($array_ppaket_id, $ppaket_master, $array_ppaket_cust);
		echo $result;
	}
	
	function get_bank_list(){
		$result=$this->m_public_function->get_bank_list();
		echo $result;
	}
	
	function get_info_pajak(){
		$result=$this->m_master_jual_paket->get_info_pajak();
		echo $result;
	}
	
	function get_reveral_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_master_jual_paket->get_reveral_list($query,$start,$end);
		echo $result;
	}
	
	
	function get_customer_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
//		$result=$this->m_master_jual_paket->get_customer_list($query,$start,$end);
		$result=$this->m_public_function->get_customer_list($query,$start,$end);
		echo $result;
	}
	
	function get_customer_pengguna_list(){
		$jpaket_id = trim(@$_POST['jpaket_id']);
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_master_jual_paket->get_customer_pengguna_list($jpaket_id,$query,$start,$end);
		echo $result;
	}
	
	/*function get_paket_list(){
		$result = $this->m_public_function->get_paket_list();
		echo $result;
	}*/
	function get_paket_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$aktif = trim(@$_POST["aktif"]);
		$result = $this->m_master_jual_paket->get_paket_list($query,$start,$end,$aktif);
		echo $result;
	}
	
	function get_kwitansi_by_ref(){
		$ref_id = (isset($_POST['no_faktur']) ? $_POST['no_faktur'] : $_GET['no_faktur']);
		$cara_bayar_ke = @$_POST['cara_bayar_ke'];
		$result = $this->m_public_function->get_kwitansi_by_ref($ref_id ,$cara_bayar_ke);
		echo $result;
	}
	
	function get_cek_by_ref(){
		$ref_id = (isset($_POST['no_faktur']) ? $_POST['no_faktur'] : $_GET['no_faktur']);
		$cara_bayar_ke = @$_POST['cara_bayar_ke'];
		$result = $this->m_public_function->get_cek_by_ref($ref_id ,$cara_bayar_ke);
		echo $result;
	}
	
	function get_card_by_ref(){
		$ref_id = (isset($_POST['no_faktur']) ? $_POST['no_faktur'] : $_GET['no_faktur']);
		$cara_bayar_ke = @$_POST['cara_bayar_ke'];
		$result = $this->m_public_function->get_card_by_ref($ref_id ,$cara_bayar_ke);
		echo $result;
	}
	
	function get_transfer_by_ref(){
		$ref_id = (isset($_POST['no_faktur']) ? $_POST['no_faktur'] : $_GET['no_faktur']);
		$cara_bayar_ke = @$_POST['cara_bayar_ke'];
		$result = $this->m_public_function->get_transfer_by_ref($ref_id ,$cara_bayar_ke);
		echo $result;
	}
	
	function get_tunai_by_ref(){
		$ref_id = (isset($_POST['no_faktur']) ? $_POST['no_faktur'] : $_GET['no_faktur']);
		$cara_bayar_ke = @$_POST['cara_bayar_ke'];
		$result = $this->m_public_function->get_tunai_by_ref($ref_id ,$cara_bayar_ke);
		echo $result;
	}
	
	function get_voucher_by_ref(){
		$ref_id = (isset($_POST['no_faktur']) ? $_POST['no_faktur'] : $_GET['no_faktur']);
		$cara_bayar_ke = @$_POST['cara_bayar_ke'];
		$result = $this->m_public_function->get_voucher_by_ref($ref_id ,$cara_bayar_ke);
		echo $result;
	}
	
	function  get_voucher_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_master_jual_paket->get_voucher_list($query,$start,$end);
		echo $result;
	}
	
	function  get_kwitansi_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$kwitansi_cust=trim(@$_POST["kwitansi_cust"]);
		$result=$this->m_public_function->get_kwitansi_list($query,$start,$end,$kwitansi_cust);
		echo $result;
	}
	
	function get_member_by_cust(){
		$member_cust = (integer) (isset($_POST['member_cust']) ? $_POST['member_cust'] : $_GET['member_cust']);
		$result=$this->m_public_function->get_member_by_cust($member_cust);
		echo $result;
	}
	//for detail action
	//list detail handler action
	function  detail_detail_jual_paket_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_master_jual_paket->detail_detail_jual_paket_list($master_id,$query,$start,$end);
		echo $result;
	}
	//end of handler
	
	//get master id, note: not done yet
	function get_master_id(){
		$result=$this->m_master_jual_paket->get_master_id();
		echo $result;
	}
	//
	
	function catatan_piutang_update(){
		$dpaket_master = isset($_POST['dpaket_master']) ? $_POST['dpaket_master'] : "";
		$result=$this->m_master_jual_paket->catatan_piutang_update($dpaket_master);
		echo $result;
	}
	
	//add detail
	function detail_detail_jual_paket_insert(){
		//POST variable here
		$dpaket_id = $_POST['dpaket_id']; // Get our array back and translate it :
		$array_dpaket_id = json_decode(stripslashes($dpaket_id));
		
		$dpaket_master=trim(@$_POST["dpaket_master"]);
		
		$dpaket_paket = $_POST['dpaket_paket']; // Get our array back and translate it :
		$array_dpaket_paket = json_decode(stripslashes($dpaket_paket));
		
		$dpaket_karyawan = $_POST['dpaket_karyawan']; // Get our array back and translate it :
		$array_dpaket_karyawan = json_decode(stripslashes($dpaket_karyawan));
		
		$dpaket_kadaluarsa = $_POST['dpaket_kadaluarsa']; // Get our array back and translate it :
		$array_dpaket_kadaluarsa = json_decode(stripslashes($dpaket_kadaluarsa));
		
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
		
		$result=$this->m_master_jual_paket->detail_detail_jual_paket_insert($array_dpaket_id ,$dpaket_master ,$array_dpaket_paket, $array_dpaket_karyawan, $array_dpaket_kadaluarsa ,$array_dpaket_jumlah ,$array_dpaket_harga ,$array_dpaket_diskon ,$array_dpaket_diskon_jenis ,$array_dpaket_sales, $cetak);
		echo $result;
	}
	
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->master_jual_paket_list();
				break;
			case "UPDATE":
				$this->master_jual_paket_update();
				break;
			case "CREATE":
				$this->master_jual_paket_create();
				break;
			case "CEK":
				$this->master_jual_paket_pengecekan();
				break;
			case "SEARCH":
				$this->master_jual_paket_search();
				break;
			case "PRINT":
				$this->master_jual_paket_print();
				break;
			case "EXCEL":
				$this->master_jual_paket_export_excel();
				break;
			case "BATAL":
				$this->master_jual_paket_batal();
				break;
			case "DDELETE":
				$this->detail_jual_paket_delete();
				break;
			case "PENGGUNADELETE":
				$this->pengguna_paket_delete();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function master_jual_paket_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_master_jual_paket->master_jual_paket_list($query,$start,$end);
		echo $result;
	}

	function master_jual_paket_pengecekan(){
	
		$tanggal_pengecekan=trim(@$_POST["tanggal_pengecekan"]);
	
		$result=$this->m_public_function->pengecekan_dokumen($tanggal_pengecekan);
		echo $result;
	}
	
	
	//function for update record
	function master_jual_paket_update(){
		//POST variable here
		$cetak=trim(@$_POST["cetak"]);
		$jpaket_id=trim(@$_POST["jpaket_id"]);
		$jpaket_nobukti=trim(@$_POST["jpaket_nobukti"]);
		$jpaket_nobukti=str_replace("/(<\/?)(p)([^>]*>)", "",$jpaket_nobukti);
		$jpaket_nobukti=str_replace("'", '"',$jpaket_nobukti);
		$jpaket_cust=trim(@$_POST["jpaket_cust"]);
		$jpaket_tanggal=trim(@$_POST["jpaket_tanggal"]);
		$jpaket_diskon=trim(@$_POST["jpaket_diskon"]);
		$jpaket_cara=trim(@$_POST["jpaket_cara"]);
		$jpaket_cara=str_replace("/(<\/?)(p)([^>]*>)", "",$jpaket_cara);
		$jpaket_cara=str_replace("'", '"',$jpaket_cara);
		
		$jpaket_cara2=trim(@$_POST["jpaket_cara2"]);
		$jpaket_cara2=str_replace("/(<\/?)(p)([^>]*>)", "",$jpaket_cara2);
		$jpaket_cara2=str_replace("'", '"',$jpaket_cara2);
		
		$jpaket_cara3=trim(@$_POST["jpaket_cara3"]);
		$jpaket_cara3=str_replace("/(<\/?)(p)([^>]*>)", "",$jpaket_cara3);
		$jpaket_cara3=str_replace("'", '"',$jpaket_cara3);
		
		$jpaket_keterangan=trim(@$_POST["jpaket_keterangan"]);
		$jpaket_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$jpaket_keterangan);
		$jpaket_keterangan=str_replace("'", '"',$jpaket_keterangan);
		
		$jpaket_ket_disk=trim(@$_POST["jpaket_ket_disk"]);
		$jpaket_ket_disk=str_replace("/(<\/?)(p)([^>]*>)", "",$jpaket_ket_disk);
		$jpaket_ket_disk=str_replace("'", '"',$jpaket_ket_disk);
		
		$jpaket_ket_disk_medis=trim(@$_POST["jpaket_ket_disk_medis"]);
		$jpaket_ket_disk_medis=str_replace("/(<\/?)(p)([^>]*>)", "",$jpaket_ket_disk_medis);
		$jpaket_ket_disk_medis=str_replace("'", '"',$jpaket_ket_disk_medis);
		
		$jpaket_stat_dok=trim(@$_POST["jpaket_stat_dok"]);
		$jpaket_stat_dok=str_replace("/(<\/?)(p)([^>]*>)", "",$jpaket_stat_dok);
		$jpaket_stat_dok=str_replace("'", '"',$jpaket_stat_dok);
		
		$jpaket_cashback=trim($_POST["jpaket_cashback"]);
		$jpaket_cashback_medis=trim($_POST["jpaket_cashback_medis"]);
		
		//tunai
		$jpaket_tunai_nilai=trim($_POST["jpaket_tunai_nilai"]);
		//tunai-2
		$jpaket_tunai_nilai2=trim($_POST["jpaket_tunai_nilai2"]);
		//tunai-3
		$jpaket_tunai_nilai3=trim($_POST["jpaket_tunai_nilai3"]);
		//voucher
		$jpaket_voucher_no=trim($_POST["jpaket_voucher_no"]);
		$jpaket_voucher_cashback=trim($_POST["jpaket_voucher_cashback"]);
		//voucher-2
		$jpaket_voucher_no2=trim($_POST["jpaket_voucher_no2"]);
		$jpaket_voucher_cashback2=trim($_POST["jpaket_voucher_cashback2"]);
		//voucher-3
		$jpaket_voucher_no3=trim($_POST["jpaket_voucher_no3"]);
		$jpaket_voucher_cashback3=trim($_POST["jpaket_voucher_cashback3"]);
		
		//bayar
		$jpaket_bayar=trim($_POST["jpaket_bayar"]);
		$jpaket_subtotal=trim($_POST["jpaket_subtotal"]);
		$jpaket_total=trim($_POST["jpaket_total"]);
		$jpaket_hutang=trim($_POST["jpaket_hutang"]);
		/*if($jpaket_cara=='tunai')
			$jpaket_bayar=$jpaket_subtotal;*/
		//card
		$jpaket_card_nama=trim($_POST["jpaket_card_nama"]);
		$jpaket_card_edc=trim($_POST["jpaket_card_edc"]);
		$jpaket_card_no=trim($_POST["jpaket_card_no"]);
		$jpaket_card_nilai=trim($_POST["jpaket_card_nilai"]);
		//card-2
		$jpaket_card_nama2=trim($_POST["jpaket_card_nama2"]);
		$jpaket_card_edc2=trim($_POST["jpaket_card_edc2"]);
		$jpaket_card_no2=trim($_POST["jpaket_card_no2"]);
		$jpaket_card_nilai2=trim($_POST["jpaket_card_nilai2"]);
		//card-3
		$jpaket_card_nama3=trim($_POST["jpaket_card_nama3"]);
		$jpaket_card_edc3=trim($_POST["jpaket_card_edc3"]);
		$jpaket_card_no3=trim($_POST["jpaket_card_no3"]);
		$jpaket_card_nilai3=trim($_POST["jpaket_card_nilai3"]);
		//kwitansi
		$jpaket_kwitansi_no=trim($_POST["jpaket_kwitansi_no"]);
		$jpaket_kwitansi_nama=trim(@$_POST["jpaket_kwitansi_nama"]);
		$jpaket_kwitansi_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$jpaket_kwitansi_nama);
		$jpaket_kwitansi_nama=str_replace("'", '"',$jpaket_kwitansi_nama);
		$jpaket_kwitansi_nilai=trim($_POST["jpaket_kwitansi_nilai"]);
		$jual_kwitansi_id=trim($_POST["jual_kwitansi_id"]);
		//kwitansi-2
		$jpaket_kwitansi_no2=trim($_POST["jpaket_kwitansi_no2"]);
		$jpaket_kwitansi_nama2=trim(@$_POST["jpaket_kwitansi_nama2"]);
		$jpaket_kwitansi_nama2=str_replace("/(<\/?)(p)([^>]*>)", "",$jpaket_kwitansi_nama2);
		$jpaket_kwitansi_nama2=str_replace("'", '"',$jpaket_kwitansi_nama2);
		$jpaket_kwitansi_nilai2=trim($_POST["jpaket_kwitansi_nilai2"]);
		$jual_kwitansi_id2=trim($_POST["jual_kwitansi_id2"]);
		//kwitansi-3
		$jpaket_kwitansi_no3=trim($_POST["jpaket_kwitansi_no3"]);
		$jpaket_kwitansi_nama3=trim(@$_POST["jpaket_kwitansi_nama3"]);
		$jpaket_kwitansi_nama3=str_replace("/(<\/?)(p)([^>]*>)", "",$jpaket_kwitansi_nama3);
		$jpaket_kwitansi_nama3=str_replace("'", '"',$jpaket_kwitansi_nama3);
		$jpaket_kwitansi_nilai3=trim($_POST["jpaket_kwitansi_nilai3"]);
		$jual_kwitansi_id3=trim($_POST["jual_kwitansi_id3"]);
		//cek
		$jpaket_cek_nama=trim($_POST["jpaket_cek_nama"]);
		$jpaket_cek_no=trim($_POST["jpaket_cek_no"]);
		$jpaket_cek_valid=trim($_POST["jpaket_cek_valid"]);
		$jpaket_cek_bank=trim($_POST["jpaket_cek_bank"]);
		$jpaket_cek_nilai=trim($_POST["jpaket_cek_nilai"]);
		//cek-2
		$jpaket_cek_nama2=trim($_POST["jpaket_cek_nama2"]);
		$jpaket_cek_no2=trim($_POST["jpaket_cek_no2"]);
		$jpaket_cek_valid2=trim($_POST["jpaket_cek_valid2"]);
		$jpaket_cek_bank2=trim($_POST["jpaket_cek_bank2"]);
		$jpaket_cek_nilai2=trim($_POST["jpaket_cek_nilai2"]);
		//cek-3
		$jpaket_cek_nama3=trim($_POST["jpaket_cek_nama3"]);
		$jpaket_cek_no3=trim($_POST["jpaket_cek_no3"]);
		$jpaket_cek_valid3=trim($_POST["jpaket_cek_valid3"]);
		$jpaket_cek_bank3=trim($_POST["jpaket_cek_bank3"]);
		$jpaket_cek_nilai3=trim($_POST["jpaket_cek_nilai3"]);
		//transfer
		$jpaket_transfer_bank=trim($_POST["jpaket_transfer_bank"]);
		$jpaket_transfer_nama=trim($_POST["jpaket_transfer_nama"]);
		$jpaket_transfer_nilai=trim($_POST["jpaket_transfer_nilai"]);
		//transfer-2
		$jpaket_transfer_bank2=trim($_POST["jpaket_transfer_bank2"]);
		$jpaket_transfer_nama2=trim($_POST["jpaket_transfer_nama2"]);
		$jpaket_transfer_nilai2=trim($_POST["jpaket_transfer_nilai2"]);
		//transfer-3
		$jpaket_transfer_bank3=trim($_POST["jpaket_transfer_bank3"]);
		$jpaket_transfer_nama3=trim($_POST["jpaket_transfer_nama3"]);
		$jpaket_transfer_nilai3=trim($_POST["jpaket_transfer_nilai3"]);
		
		
		$result = $this->m_master_jual_paket->master_jual_paket_update($jpaket_id ,$jpaket_nobukti ,$jpaket_cust ,$jpaket_tanggal ,$jpaket_stat_dok, $jpaket_diskon ,$jpaket_cara ,$jpaket_cara2 ,$jpaket_cara3 ,$jpaket_keterangan , $jpaket_cashback,$jpaket_cashback_medis, $jpaket_tunai_nilai, $jpaket_tunai_nilai2, $jpaket_tunai_nilai3, $jpaket_voucher_no, $jpaket_voucher_cashback, $jpaket_voucher_no2, $jpaket_voucher_cashback2, $jpaket_voucher_no3, $jpaket_voucher_cashback3, $jpaket_bayar, $jpaket_subtotal ,$jpaket_total ,$jpaket_hutang, $jpaket_kwitansi_no, $jpaket_kwitansi_nama, $jpaket_kwitansi_nilai, $jpaket_kwitansi_no2, $jpaket_kwitansi_nama2, $jpaket_kwitansi_nilai2, $jpaket_kwitansi_no3, $jpaket_kwitansi_nama3, $jpaket_kwitansi_nilai3, $jpaket_card_nama, $jpaket_card_edc, $jpaket_card_no, $jpaket_card_nilai, $jpaket_card_nama2, $jpaket_card_edc2, $jpaket_card_no2, $jpaket_card_nilai2, $jpaket_card_nama3, $jpaket_card_edc3, $jpaket_card_no3, $jpaket_card_nilai3, $jpaket_cek_nama, $jpaket_cek_no, $jpaket_cek_valid, $jpaket_cek_bank, $jpaket_cek_nilai, $jpaket_cek_nama2, $jpaket_cek_no2, $jpaket_cek_valid2, $jpaket_cek_bank2, $jpaket_cek_nilai2, $jpaket_cek_nama3, $jpaket_cek_no3, $jpaket_cek_valid3, $jpaket_cek_bank3, $jpaket_cek_nilai3, $jpaket_transfer_bank, $jpaket_transfer_nama, $jpaket_transfer_nilai, $jpaket_transfer_bank2, $jpaket_transfer_nama2, $jpaket_transfer_nilai2, $jpaket_transfer_bank3, $jpaket_transfer_nama3, $jpaket_transfer_nilai3, $cetak, $jpaket_ket_disk,$jpaket_ket_disk_medis, $jual_kwitansi_id, $jual_kwitansi_id2, $jual_kwitansi_id3);
		echo $result;
	}
	
	//function for create new record
	function master_jual_paket_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$cetak=trim(@$_POST["cetak"]);
		$jpaket_nobukti=trim(@$_POST["jpaket_nobukti"]);
		$jpaket_nobukti=str_replace("/(<\/?)(p)([^>]*>)", "",$jpaket_nobukti);
		$jpaket_nobukti=str_replace("'", '"',$jpaket_nobukti);
		$jpaket_cust=trim(@$_POST["jpaket_cust"]);
		$jpaket_tanggal=trim(@$_POST["jpaket_tanggal"]);
		$jpaket_diskon=trim(@$_POST["jpaket_diskon"]);
		$jpaket_cara=trim(@$_POST["jpaket_cara"]);
		$jpaket_cara=str_replace("/(<\/?)(p)([^>]*>)", "",$jpaket_cara);
		$jpaket_cara=str_replace("'", '"',$jpaket_cara);
		
		$jpaket_cara2=trim(@$_POST["jpaket_cara2"]);
		$jpaket_cara2=str_replace("/(<\/?)(p)([^>]*>)", "",$jpaket_cara2);
		$jpaket_cara2=str_replace("'", '"',$jpaket_cara2);
		
		$jpaket_cara3=trim(@$_POST["jpaket_cara3"]);
		$jpaket_cara3=str_replace("/(<\/?)(p)([^>]*>)", "",$jpaket_cara3);
		$jpaket_cara3=str_replace("'", '"',$jpaket_cara3);
		
		$jpaket_keterangan=trim(@$_POST["jpaket_keterangan"]);
		$jpaket_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$jpaket_keterangan);
		$jpaket_keterangan=str_replace("'", '"',$jpaket_keterangan);
		
		$jpaket_ket_disk=trim(@$_POST["jpaket_ket_disk"]);
		$jpaket_ket_disk=str_replace("/(<\/?)(p)([^>]*>)", "",$jpaket_ket_disk);
		$jpaket_ket_disk=str_replace("'", '"',$jpaket_ket_disk);
		
		$jpaket_ket_disk_medis=trim(@$_POST["jpaket_ket_disk_medis"]);
		$jpaket_ket_disk_medis=str_replace("/(<\/?)(p)([^>]*>)", "",$jpaket_ket_disk_medis);
		$jpaket_ket_disk_medis=str_replace("'", '"',$jpaket_ket_disk_medis);
		
		$jpaket_stat_dok=trim(@$_POST["jpaket_stat_dok"]);
		$jpaket_stat_dok=str_replace("/(<\/?)(p)([^>]*>)", "",$jpaket_stat_dok);
		$jpaket_stat_dok=str_replace("'", '"',$jpaket_stat_dok);
		
		$jpaket_cashback=trim($_POST["jpaket_cashback"]);
		$jpaket_cashback_medis=trim($_POST["jpaket_cashback_medis"]);
		//$jpaket_voucher=trim($_POST["jpaket_voucher"]);
		//tunai
		$jpaket_tunai_nilai=trim($_POST["jpaket_tunai_nilai"]);
		//tunai-2
		$jpaket_tunai_nilai2=trim($_POST["jpaket_tunai_nilai2"]);
		//tunai-3
		$jpaket_tunai_nilai3=trim($_POST["jpaket_tunai_nilai3"]);
		//voucher
		$jpaket_voucher_no=trim($_POST["jpaket_voucher_no"]);
		$jpaket_voucher_cashback=trim($_POST["jpaket_voucher_cashback"]);
		//voucher-2
		$jpaket_voucher_no2=trim($_POST["jpaket_voucher_no2"]);
		$jpaket_voucher_cashback2=trim($_POST["jpaket_voucher_cashback2"]);
		//voucher-3
		$jpaket_voucher_no3=trim($_POST["jpaket_voucher_no3"]);
		$jpaket_voucher_cashback3=trim($_POST["jpaket_voucher_cashback3"]);
		//bayar
		$jpaket_bayar=trim($_POST["jpaket_bayar"]);
		$jpaket_subtotal=trim($_POST["jpaket_subtotal"]);
		$jpaket_total=trim($_POST["jpaket_total"]);
		$jpaket_hutang=trim($_POST["jpaket_hutang"]);
		//if($jpaket_cara=='tunai')
			//$jpaket_bayar=$jpaket_subtotal;
		//card
		$jpaket_card_nama=trim($_POST["jpaket_card_nama"]);
		$jpaket_card_edc=trim($_POST["jpaket_card_edc"]);
		$jpaket_card_no=trim($_POST["jpaket_card_no"]);
		$jpaket_card_nilai=trim($_POST["jpaket_card_nilai"]);
		//card-2
		$jpaket_card_nama2=trim($_POST["jpaket_card_nama2"]);
		$jpaket_card_edc2=trim($_POST["jpaket_card_edc2"]);
		$jpaket_card_no2=trim($_POST["jpaket_card_no2"]);
		$jpaket_card_nilai2=trim($_POST["jpaket_card_nilai2"]);
		//card-3
		$jpaket_card_nama3=trim($_POST["jpaket_card_nama3"]);
		$jpaket_card_edc3=trim($_POST["jpaket_card_edc3"]);
		$jpaket_card_no3=trim($_POST["jpaket_card_no3"]);
		$jpaket_card_nilai3=trim($_POST["jpaket_card_nilai3"]);
		//kwitansi
		$jpaket_kwitansi_no=trim($_POST["jpaket_kwitansi_no"]);
		$jpaket_kwitansi_nama=trim(@$_POST["jpaket_kwitansi_nama"]);
		$jpaket_kwitansi_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$jpaket_kwitansi_nama);
		$jpaket_kwitansi_nama=str_replace("'", '"',$jpaket_kwitansi_nama);
		$jpaket_kwitansi_nilai=trim($_POST["jpaket_kwitansi_nilai"]);
		$jual_kwitansi_id=trim($_POST["jual_kwitansi_id"]);
		//kwitansi-2
		$jpaket_kwitansi_no2=trim($_POST["jpaket_kwitansi_no2"]);
		$jpaket_kwitansi_nama2=trim(@$_POST["jpaket_kwitansi_nama2"]);
		$jpaket_kwitansi_nama2=str_replace("/(<\/?)(p)([^>]*>)", "",$jpaket_kwitansi_nama2);
		$jpaket_kwitansi_nama2=str_replace("'", '"',$jpaket_kwitansi_nama2);
		$jpaket_kwitansi_nilai2=trim($_POST["jpaket_kwitansi_nilai2"]);
		$jual_kwitansi_id2=trim($_POST["jual_kwitansi_id2"]);
		//kwitansi-3
		$jpaket_kwitansi_no3=trim($_POST["jpaket_kwitansi_no3"]);
		$jpaket_kwitansi_nama3=trim(@$_POST["jpaket_kwitansi_nama3"]);
		$jpaket_kwitansi_nama3=str_replace("/(<\/?)(p)([^>]*>)", "",$jpaket_kwitansi_nama3);
		$jpaket_kwitansi_nama3=str_replace("'", '"',$jpaket_kwitansi_nama3);
		$jpaket_kwitansi_nilai3=trim($_POST["jpaket_kwitansi_nilai3"]);
		$jual_kwitansi_id3=trim($_POST["jual_kwitansi_id3"]);
		//cek
		$jpaket_cek_nama=trim($_POST["jpaket_cek_nama"]);
		$jpaket_cek_no=trim($_POST["jpaket_cek_no"]);
		$jpaket_cek_valid=trim($_POST["jpaket_cek_valid"]);
		$jpaket_cek_bank=trim($_POST["jpaket_cek_bank"]);
		$jpaket_cek_nilai=trim($_POST["jpaket_cek_nilai"]);
		//cek-2
		$jpaket_cek_nama2=trim($_POST["jpaket_cek_nama2"]);
		$jpaket_cek_no2=trim($_POST["jpaket_cek_no2"]);
		$jpaket_cek_valid2=trim($_POST["jpaket_cek_valid2"]);
		$jpaket_cek_bank2=trim($_POST["jpaket_cek_bank2"]);
		$jpaket_cek_nilai2=trim($_POST["jpaket_cek_nilai2"]);
		//cek-3
		$jpaket_cek_nama3=trim($_POST["jpaket_cek_nama3"]);
		$jpaket_cek_no3=trim($_POST["jpaket_cek_no3"]);
		$jpaket_cek_valid3=trim($_POST["jpaket_cek_valid3"]);
		$jpaket_cek_bank3=trim($_POST["jpaket_cek_bank3"]);
		$jpaket_cek_nilai3=trim($_POST["jpaket_cek_nilai3"]);
		//transfer
		$jpaket_transfer_bank=trim($_POST["jpaket_transfer_bank"]);
		$jpaket_transfer_nama=trim($_POST["jpaket_transfer_nama"]);
		$jpaket_transfer_nilai=trim($_POST["jpaket_transfer_nilai"]);
		//transfer-2
		$jpaket_transfer_bank2=trim($_POST["jpaket_transfer_bank2"]);
		$jpaket_transfer_nama2=trim($_POST["jpaket_transfer_nama2"]);
		$jpaket_transfer_nilai2=trim($_POST["jpaket_transfer_nilai2"]);
		//transfer-3
		$jpaket_transfer_bank3=trim($_POST["jpaket_transfer_bank3"]);
		$jpaket_transfer_nama3=trim($_POST["jpaket_transfer_nama3"]);
		$jpaket_transfer_nilai3=trim($_POST["jpaket_transfer_nilai3"]);
				
		$result=$this->m_master_jual_paket->master_jual_paket_create($jpaket_nobukti ,$jpaket_cust ,$jpaket_tanggal ,$jpaket_diskon ,$jpaket_stat_dok, $jpaket_cara ,$jpaket_cara2 ,$jpaket_cara3 ,$jpaket_keterangan , $jpaket_cashback,$jpaket_cashback_medis, $jpaket_tunai_nilai, $jpaket_tunai_nilai2, $jpaket_tunai_nilai3, $jpaket_voucher_no, $jpaket_voucher_cashback, $jpaket_voucher_no2, $jpaket_voucher_cashback2, $jpaket_voucher_no3, $jpaket_voucher_cashback3, $jpaket_bayar, $jpaket_subtotal, $jpaket_total, $jpaket_hutang, $jpaket_kwitansi_no, $jpaket_kwitansi_nama, $jpaket_kwitansi_nilai, $jpaket_kwitansi_no2, $jpaket_kwitansi_nama2, $jpaket_kwitansi_nilai2, $jpaket_kwitansi_no3, $jpaket_kwitansi_nama3, $jpaket_kwitansi_nilai3, $jpaket_card_nama, $jpaket_card_edc, $jpaket_card_no, $jpaket_card_nilai, $jpaket_card_nama2, $jpaket_card_edc2, $jpaket_card_no2, $jpaket_card_nilai2, $jpaket_card_nama3, $jpaket_card_edc3, $jpaket_card_no3, $jpaket_card_nilai3, $jpaket_cek_nama, $jpaket_cek_no, $jpaket_cek_valid, $jpaket_cek_bank, $jpaket_cek_nilai, $jpaket_cek_nama2, $jpaket_cek_no2, $jpaket_cek_valid2, $jpaket_cek_bank2, $jpaket_cek_nilai2, $jpaket_cek_nama3, $jpaket_cek_no3, $jpaket_cek_valid3, $jpaket_cek_bank3, $jpaket_cek_nilai3, $jpaket_transfer_bank, $jpaket_transfer_nama, $jpaket_transfer_nilai, $jpaket_transfer_bank2, $jpaket_transfer_nama2, $jpaket_transfer_nilai2, $jpaket_transfer_bank3, $jpaket_transfer_nama3, $jpaket_transfer_nilai3, $cetak, $jpaket_ket_disk,$jpaket_ket_disk_medis, $jual_kwitansi_id, $jual_kwitansi_id2, $jual_kwitansi_id3);
		echo $result;
	}
	
	function detail_jual_paket_delete(){
        $dpaket_id = trim(@$_POST["dpaket_id"]); // Get our array back and translate it :
		$result=$this->m_master_jual_paket->detail_jual_paket_delete($dpaket_id);
		echo $result;
    }
	
	function pengguna_paket_delete(){
        $ppaket_master = trim(@$_POST["ppaket_master"]);
		$ppaket_cust = trim(@$_POST["ppaket_cust"]);
		$result=$this->m_master_jual_paket->pengguna_paket_delete($ppaket_master ,$ppaket_cust);
		echo $result;
    }
	
	function master_jual_paket_batal(){
		$jpaket_id=trim($_POST["jpaket_id"]);
		$jpaket_tanggal=trim(@$_POST["jpaket_tanggal"]);
		$result=$this->m_master_jual_paket->master_jual_paket_batal($jpaket_id, $jpaket_tanggal);
		echo $result;
	}

	//function for advanced search
	function master_jual_paket_search(){
		//POST varibale here
		$jpaket_nobukti=trim(@$_POST["jpaket_nobukti"]);
		$jpaket_nobukti=str_replace("/(<\/?)(p)([^>]*>)", "",$jpaket_nobukti);
		$jpaket_nobukti=str_replace("'", '"',$jpaket_nobukti);
		$jpaket_cust=trim(@$_POST["jpaket_cust"]);
		$jpaket_tanggal=trim(@$_POST["jpaket_tanggal"]);
		$jpaket_tanggal_akhir=trim(@$_POST["jpaket_tanggal_akhir"]);
		$jpaket_diskon=trim(@$_POST["jpaket_diskon"]);
		$jpaket_cashback=trim(@$_POST["jpaket_cashback"]);
		$jpaket_cashback_medis=trim(@$_POST["jpaket_cashback_medis"]);
		$jpaket_voucher=trim(@$_POST["jpaket_voucher"]);
		$jpaket_voucher=str_replace("/(<\/?)(p)([^>]*>)", "",$jpaket_voucher);
		$jpaket_voucher=str_replace("'", '"',$jpaket_voucher);
		$jpaket_cara=trim(@$_POST["jpaket_cara"]);
		$jpaket_cara=str_replace("/(<\/?)(p)([^>]*>)", "",$jpaket_cara);
		$jpaket_cara=str_replace("'", '"',$jpaket_cara);
		$jpaket_bayar=trim(@$_POST["jpaket_bayar"]);
		$jpaket_keterangan=trim(@$_POST["jpaket_keterangan"]);
		$jpaket_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$jpaket_keterangan);
		$jpaket_keterangan=str_replace("'", '"',$jpaket_keterangan);
		$jpaket_stat_dok=trim(@$_POST["jpaket_stat_dok"]);
		$jpaket_stat_dok=str_replace("/(<\/?)(p)([^>]*>)", "",$jpaket_stat_dok);
		$jpaket_stat_dok=str_replace("'", '"',$jpaket_stat_dok);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_master_jual_paket->master_jual_paket_search($jpaket_nobukti ,$jpaket_cust ,$jpaket_tanggal, $jpaket_tanggal_akhir, $jpaket_diskon ,$jpaket_cashback ,$jpaket_cashback_medis,$jpaket_voucher ,$jpaket_cara ,$jpaket_bayar , $jpaket_keterangan, $jpaket_stat_dok, $start, $end);
		echo $result;
	}


	function master_jual_paket_print(){
  		//POST varibale here
		$jpaket_nobukti=trim(@$_POST["jpaket_nobukti"]);
		$jpaket_nobukti=str_replace("/(<\/?)(p)([^>]*>)", "",$jpaket_nobukti);
		$jpaket_nobukti=str_replace("'", '"',$jpaket_nobukti);
		$jpaket_cust=trim(@$_POST["jpaket_cust"]);
		$jpaket_tanggal=trim(@$_POST["jpaket_tanggal"]);
		$jpaket_tanggal_akhir=trim(@$_POST["jpaket_tanggal_akhir"]);
		$jpaket_diskon=trim(@$_POST["jpaket_diskon"]);
		$jpaket_cashback=trim(@$_POST["jpaket_cashback"]);
		$jpaket_voucher=trim(@$_POST["jpaket_voucher"]);
		$jpaket_voucher=str_replace("/(<\/?)(p)([^>]*>)", "",$jpaket_voucher);
		$jpaket_voucher=str_replace("'", '"',$jpaket_voucher);
		$jpaket_cara=trim(@$_POST["jpaket_cara"]);
		$jpaket_cara=str_replace("/(<\/?)(p)([^>]*>)", "",$jpaket_cara);
		$jpaket_cara=str_replace("'", '"',$jpaket_cara);
		$jpaket_bayar=trim(@$_POST["jpaket_bayar"]);
		$jpaket_keterangan=trim(@$_POST["jpaket_keterangan"]);
		$jpaket_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$jpaket_keterangan);
		$jpaket_keterangan=str_replace("'", '"',$jpaket_keterangan);
		$jpaket_stat_dok=trim(@$_POST["jpaket_stat_dok"]);
		$jpaket_stat_dok=str_replace("/(<\/?)(p)([^>]*>)", "",$jpaket_stat_dok);
		$jpaket_stat_dok=str_replace("'", '"',$jpaket_stat_dok);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$data["data_print"] = $this->m_master_jual_paket->master_jual_paket_print($jpaket_nobukti
																				,$jpaket_cust
																				,$jpaket_tanggal
																				,$jpaket_tanggal_akhir
																				,$jpaket_diskon
																				,$jpaket_cashback
																				,$jpaket_voucher
																				,$jpaket_cara
																				,$jpaket_bayar
																				,$jpaket_keterangan
																				,$jpaket_stat_dok
																				,$option
																				,$filter);
		$print_view=$this->load->view("main/p_master_jual_paket.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$print_file=fopen("print/master_jual_paketlist.html","w+");
		fwrite($print_file, $print_view);
		echo '1';
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function master_jual_paket_export_excel(){
		//POST varibale here
		$jpaket_nobukti=trim(@$_POST["jpaket_nobukti"]);
		$jpaket_nobukti=str_replace("/(<\/?)(p)([^>]*>)", "",$jpaket_nobukti);
		$jpaket_nobukti=str_replace("'", '"',$jpaket_nobukti);
		$jpaket_cust=trim(@$_POST["jpaket_cust"]);
		$jpaket_tanggal=trim(@$_POST["jpaket_tanggal"]);
		$jpaket_tanggal_akhir=trim(@$_POST["jpaket_tanggal_akhir"]);
		$jpaket_diskon=trim(@$_POST["jpaket_diskon"]);
		$jpaket_cashback=trim(@$_POST["jpaket_cashback"]);
		$jpaket_voucher=trim(@$_POST["jpaket_voucher"]);
		$jpaket_voucher=str_replace("/(<\/?)(p)([^>]*>)", "",$jpaket_voucher);
		$jpaket_voucher=str_replace("'", '"',$jpaket_voucher);
		$jpaket_cara=trim(@$_POST["jpaket_cara"]);
		$jpaket_cara=str_replace("/(<\/?)(p)([^>]*>)", "",$jpaket_cara);
		$jpaket_cara=str_replace("'", '"',$jpaket_cara);
		$jpaket_bayar=trim(@$_POST["jpaket_bayar"]);
		$jpaket_keterangan=trim(@$_POST["jpaket_keterangan"]);
		$jpaket_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$jpaket_keterangan);
		$jpaket_keterangan=str_replace("'", '"',$jpaket_keterangan);
		$jpaket_stat_dok=trim(@$_POST["jpaket_stat_dok"]);
		$jpaket_stat_dok=str_replace("/(<\/?)(p)([^>]*>)", "",$jpaket_stat_dok);
		$jpaket_stat_dok=str_replace("'", '"',$jpaket_stat_dok);
		
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_master_jual_paket->master_jual_paket_export_excel($jpaket_nobukti
																			,$jpaket_cust
																			,$jpaket_tanggal
																			,$jpaket_tanggal_akhir
																			,$jpaket_diskon
																			,$jpaket_cashback
																			,$jpaket_voucher
																			,$jpaket_cara
																			,$jpaket_bayar
																			,$jpaket_keterangan
																			,$jpaket_stat_dok
																			,$option
																			,$filter);
		
		to_excel($query,"master_jual_paket"); 
		echo '1';
			
	}
	
	function print_paper(){
  		//POST varibale here
		$jpaket_id=trim(@$_POST["jpaket_id"]);
		
		$result = $this->m_master_jual_paket->print_paper($jpaket_id);
		$iklan = $this->m_master_jual_paket->iklan();
		$rs=$result->row();
		$rsiklan=$iklan->row();
		$detail_jpaket=$result->result();
		
		$array_cara_bayar = $this->m_master_jual_paket->get_cara_bayar($jpaket_id);
		
		$cara_bayar=$this->m_master_jual_paket->cara_bayar($jpaket_id);
		$cara_bayar2=$this->m_master_jual_paket->cara_bayar2($jpaket_id);
		$cara_bayar3=$this->m_master_jual_paket->cara_bayar3($jpaket_id);
		
		$data['jpaket_nobukti']=$rs->jpaket_nobukti;
		$data['jpaket_jam']=$rs->jpaket_jam;
		$data['jpaket_tanggal']=date('d-m-Y', strtotime($rs->jpaket_tanggal));
		$data['cust_no']=$rs->cust_no;
		$data['cust_nama']=$rs->cust_nama;
		$data['iklantoday_keterangan']=$rsiklan->iklantoday_keterangan;
		$data['cust_alamat']=$rs->cust_alamat;
		$data['jumlah_subtotal']=ubah_rupiah($rs->jumlah_subtotal);
		//$data['jumlah_tunai']=$rs->jtunai_nilai;
		$data['jpaket_diskon']=$rs->jpaket_diskon;
		$data['jpaket_cashback']=$rs->jpaket_cashback;
		$data['jpaket_creator']=$rs->jpaket_creator;
		//$data['jpaket_totalbiaya']=$rs->jpaket_totalbiaya;
		$data['detail_jpaket']=$detail_jpaket;
			
		if($cara_bayar!==NULL){
			$data['cara_bayar1']=$cara_bayar->jpaket_cara;
			$data['nilai_bayar1']=$cara_bayar->bayar_nilai;
		}else{
			$data['cara_bayar1']="";
			$data['nilai_bayar1']="";
		}
		
		if($cara_bayar2!==NULL){
			$data['cara_bayar2']=$cara_bayar2->jpaket_cara2;
			$data['nilai_bayar2']=$cara_bayar2->bayar2_nilai;
		}else{
			$data['cara_bayar2']="";
			$data['nilai_bayar2']="";
		}
		
		if($cara_bayar3!==NULL){
			$data['cara_bayar3']=$cara_bayar3->jpaket_cara3;
			$data['nilai_bayar3']=$cara_bayar3->bayar3_nilai;
		}else{
			$data['cara_bayar3']="";
			$data['nilai_bayar3']="";
		}
		
		$viewdata=$this->load->view("main/jpaket_formcetak",$data,TRUE);
		$file = fopen("jpaket_paper.html",'w');
		fwrite($file, $viewdata);	
		fclose($file);
		echo '1';        
	}
	
	/*Function print paper2 untuk faktur pajak */
	function print_paper2(){
  		//POST varibale here
		$jpaket_id=trim(@$_POST["jpaket_id"]);
		$jpaket_cust=trim(@$_POST["jpaket_cust"]);
		$jpaket_tanggal=trim(@$_POST["jpaket_tanggal"]);
		$stat_dok=trim(@$_POST["stat_dok"]);
		$kategori_nama=trim(@$_POST["kategori_nama"]);

		$result_medis = $this->m_master_jual_paket->print_paper_medis($jpaket_id);
		$result_nonmedis = $this->m_master_jual_paket->print_paper_nonmedis($jpaket_id);
		$iklan = $this->m_master_jual_paket->iklan();
		
		$jum_medis=$result_medis->num_rows();
		$data['jum_medis']=$jum_medis;
		$jum_nonmedis=$result_nonmedis->num_rows();
		$data['jum_nonmedis']=$jum_nonmedis;
		
		if ($result_medis->row() != null){	
			$rs_medis=$result_medis->row();	
		}
		if ($result_nonmedis->row() != null){
			$rs_nonmedis=$result_nonmedis->row();		
		}
		
		$rsiklan=$iklan->row();
		$detail_jpaket_medis=$result_medis->result();
		$detail_jpaket_nonmedis=$result_nonmedis->result();
		
		$cara_bayar=$this->m_master_jual_paket->cara_bayar($jpaket_id);
		$cara_bayar2=$this->m_master_jual_paket->cara_bayar2($jpaket_id);
		$cara_bayar3=$this->m_master_jual_paket->cara_bayar3($jpaket_id);

		
		if ($result_medis->row() != null){
				$data['jpaket_nobukti']=$rs_medis->jpaket_nobukti;
				$data['jpaket_jam']=$rs_medis->jpaket_jam;
				$data['jpaket_tanggal']=date('d-m-Y', strtotime($rs_medis->jpaket_tanggal));
				$data['cust_no']=$rs_medis->cust_no;
				$data['cust_nama']=$rs_medis->cust_nama;
				$data['cust_alamat']=$rs_medis->cust_alamat;
				$data['jumlah_bayar']=$rs_medis->jpaket_bayar;
				$data['diskon']=$rs_medis->diskon;
				// DATA BEDA
				//$data['jpaket_nobukti_medis']=$rs_medis->jpaket_nobukti_medis;
				$data['jumlah_subtotal_medis']=ubah_rupiah($rs_medis->jumlah_subtotal_medis);
				$data['voucher_total_medis']=ubah_rupiah($rs_medis->voucher_total_medis);
				//printf (ubah_rupiah($rs_medis->voucher_total_medis));
				$data['jpaket_diskon']=$rs_medis->jpaket_diskon;
				$data['jpaket_cashback']=$rs_medis->jpaket_cashback;
				$data['pajak']=$rs_medis->pajak;
				//$data['uang_muka']=$rs_medis->uang_muka;
		}
		if ($result_nonmedis->row() != null){
				$data['jpaket_nobukti']=$rs_nonmedis->jpaket_nobukti;
				$data['jpaket_jam']=$rs_nonmedis->jpaket_jam;
				$data['jpaket_tanggal']=date('d-m-Y', strtotime($rs_nonmedis->jpaket_tanggal));
				$data['cust_no']=$rs_nonmedis->cust_no;
				$data['cust_nama']=$rs_nonmedis->cust_nama;
				$data['cust_alamat']=$rs_nonmedis->cust_alamat;
				$data['jumlah_bayar']=$rs_nonmedis->jpaket_bayar;
				$data['diskon']=$rs_nonmedis->diskon;
				// DATA BEDA
				$data['jpaket_nobukti_pajak']=$rs_nonmedis->jpaket_nobukti_pajak;
				$data['jumlah_subtotal_nonmedis']=ubah_rupiah($rs_nonmedis->jumlah_subtotal_nonmedis);
				$data['jpaket_diskon']=$rs_nonmedis->jpaket_diskon;
				$data['jpaket_cashback']=$rs_nonmedis->jpaket_cashback;
				$data['pajak']=$rs_nonmedis->pajak;
				//$data['uang_muka']=$rs_nonmedis->uang_muka;
		}
				
		
		$data['detail_jpaket_medis']=$detail_jpaket_medis;
		$data['detail_jpaket_nonmedis']=$detail_jpaket_nonmedis; 

		$data['iklantoday_keterangan']=$rsiklan->iklantoday_keterangan;
		
		if($cara_bayar!==NULL){
			$data['cara_bayar1']=$cara_bayar->jpaket_cara;
			$data['nilai_bayar1']=$cara_bayar->bayar_nilai;
		}else{
			$data['cara_bayar1']="";
			$data['nilai_bayar1']="";
		}
		
		if($cara_bayar2!==NULL){
			$data['cara_bayar2']=$cara_bayar2->jpaket_cara2;
			$data['nilai_bayar2']=$cara_bayar2->bayar2_nilai;
		}else{
			$data['cara_bayar2']="";
			$data['nilai_bayar2']="";
		}
		
		if($cara_bayar3!==NULL){
			$data['cara_bayar3']=$cara_bayar3->jpaket_cara3;
			$data['nilai_bayar3']=$cara_bayar3->bayar3_nilai;
		}else{
			$data['cara_bayar3']="";
			$data['nilai_bayar3']="";
		}
		
		$viewdata=$this->load->view("main/jpaket_formcetak2",$data,TRUE);
		$file = fopen("jpaket_paper2.html",'w');
		fwrite($file, $viewdata);	
		fclose($file);
		echo '1';        
	}
	
	
	function print_only(){
  		//POST varibale here
		$jpaket_id=trim(@$_POST["jpaket_id"]);
		
		$result = $this->m_master_jual_paket->print_paper($jpaket_id);
		$iklan = $this->m_master_jual_paket->iklan();
		$rs=$result->row();
		$rsiklan=$iklan->row();
		$detail_jpaket=$result->result();
		
		$array_cara_bayar = $this->m_master_jual_paket->get_cara_bayar($jpaket_id);
		
		$cara_bayar=$this->m_master_jual_paket->cara_bayar($jpaket_id);
		$cara_bayar2=$this->m_master_jual_paket->cara_bayar2($jpaket_id);
		$cara_bayar3=$this->m_master_jual_paket->cara_bayar3($jpaket_id);
		
		$data['jpaket_nobukti']=$rs->jpaket_nobukti;
		$data['jpaket_jam']=$rs->jpaket_jam;
		$data['jpaket_tanggal']=date('d-m-Y', strtotime($rs->jpaket_tanggal));
		$data['cust_no']=$rs->cust_no;
		$data['cust_nama']=$rs->cust_nama;
		$data['jpaket_creator']=$rs->jpaket_creator;
		$data['iklantoday_keterangan']=$rsiklan->iklantoday_keterangan;
		$data['cust_alamat']=$rs->cust_alamat;
		$data['jumlah_subtotal']=ubah_rupiah($rs->jumlah_subtotal);

		$data['jpaket_diskon']=$rs->jpaket_diskon;
		$data['jpaket_cashback']=$rs->jpaket_cashback;
		$data['detail_jpaket']=$detail_jpaket;
		
		if($cara_bayar!==NULL){
			$data['cara_bayar1']=$cara_bayar->jpaket_cara;
			$data['nilai_bayar1']=$cara_bayar->bayar_nilai;
		}else{
			$data['cara_bayar1']="";
			$data['nilai_bayar1']="";
		}
		
		if($cara_bayar2!==NULL){
			$data['cara_bayar2']=$cara_bayar2->jpaket_cara2;
			$data['nilai_bayar2']=$cara_bayar2->bayar2_nilai;
		}else{
			$data['cara_bayar2']="";
			$data['nilai_bayar2']="";
		}
		
		if($cara_bayar3!==NULL){
			$data['cara_bayar3']=$cara_bayar3->jpaket_cara3;
			$data['nilai_bayar3']=$cara_bayar3->bayar3_nilai;
		}else{
			$data['cara_bayar3']="";
			$data['nilai_bayar3']="";
		}
		
		$viewdata=$this->load->view("main/jpaket_formcetak_printonly",$data,TRUE);
		$file = fopen("jpaket_paper.html",'w');
		fwrite($file, $viewdata);	
		fclose($file);
		echo '1';        
	}
	
	/*Function print paper2 untuk faktur pajak */
	function print_only2(){
  		//POST varibale here
		$jpaket_id=trim(@$_POST["jpaket_id"]);
		$jpaket_cust=trim(@$_POST["jpaket_cust"]);
		$jpaket_tanggal=trim(@$_POST["jpaket_tanggal"]);
		$stat_dok=trim(@$_POST["stat_dok"]);
		$kategori_nama=trim(@$_POST["kategori_nama"]);

		$result_medis = $this->m_master_jual_paket->print_paper_medis($jpaket_id);
		$result_nonmedis = $this->m_master_jual_paket->print_paper_nonmedis($jpaket_id);
		$iklan = $this->m_master_jual_paket->iklan();
		
		$jum_medis=$result_medis->num_rows();
		$data['jum_medis']=$jum_medis;
		$jum_nonmedis=$result_nonmedis->num_rows();
		$data['jum_nonmedis']=$jum_nonmedis;
		
		if ($result_medis->row() != null){	
			$rs_medis=$result_medis->row();	
		}
		if ($result_nonmedis->row() != null){
			$rs_nonmedis=$result_nonmedis->row();		
		}
		
		$rsiklan=$iklan->row();
		$detail_jpaket_medis=$result_medis->result();
		$detail_jpaket_nonmedis=$result_nonmedis->result();
		
		$cara_bayar=$this->m_master_jual_paket->cara_bayar($jpaket_id);
		$cara_bayar2=$this->m_master_jual_paket->cara_bayar2($jpaket_id);
		$cara_bayar3=$this->m_master_jual_paket->cara_bayar3($jpaket_id);

		
		if ($result_medis->row() != null){
				$data['jpaket_nobukti']=$rs_medis->jpaket_nobukti;
				$data['jpaket_jam']=$rs_medis->jpaket_jam;
				$data['jpaket_tanggal']=date('d-m-Y', strtotime($rs_medis->jpaket_tanggal));
				$data['cust_no']=$rs_medis->cust_no;
				$data['cust_nama']=$rs_medis->cust_nama;
				$data['cust_alamat']=$rs_medis->cust_alamat;
				$data['jumlah_bayar']=$rs_medis->jpaket_bayar;
				$data['diskon']=$rs_medis->diskon;
				// DATA BEDA
				//$data['jpaket_nobukti_medis']=$rs_medis->jpaket_nobukti_medis;
				$data['jumlah_subtotal_medis']=ubah_rupiah($rs_medis->jumlah_subtotal_medis);
				$data['voucher_total_medis']=ubah_rupiah($rs_medis->voucher_total_medis);
				//printf (ubah_rupiah($rs_medis->voucher_total_medis));
				$data['jpaket_diskon']=$rs_medis->jpaket_diskon;
				$data['jpaket_cashback']=$rs_medis->jpaket_cashback;
				$data['pajak']=$rs_medis->pajak;
				//$data['uang_muka']=$rs_medis->uang_muka;
		}
		if ($result_nonmedis->row() != null){
				$data['jpaket_nobukti']=$rs_nonmedis->jpaket_nobukti;
				$data['jpaket_jam']=$rs_nonmedis->jpaket_jam;
				$data['jpaket_tanggal']=date('d-m-Y', strtotime($rs_nonmedis->jpaket_tanggal));
				$data['cust_no']=$rs_nonmedis->cust_no;
				$data['cust_nama']=$rs_nonmedis->cust_nama;
				$data['cust_alamat']=$rs_nonmedis->cust_alamat;
				$data['jumlah_bayar']=$rs_nonmedis->jpaket_bayar;
				$data['diskon']=$rs_nonmedis->diskon;
				// DATA BEDA
				$data['jpaket_nobukti_pajak']=$rs_nonmedis->jpaket_nobukti_pajak;
				$data['jumlah_subtotal_nonmedis']=ubah_rupiah($rs_nonmedis->jumlah_subtotal_nonmedis);
				$data['jpaket_diskon']=$rs_nonmedis->jpaket_diskon;
				$data['jpaket_cashback']=$rs_nonmedis->jpaket_cashback;
				$data['pajak']=$rs_nonmedis->pajak;
				//$data['uang_muka']=$rs_nonmedis->uang_muka;
		}
				
		
		$data['detail_jpaket_medis']=$detail_jpaket_medis;
		$data['detail_jpaket_nonmedis']=$detail_jpaket_nonmedis; 

		$data['iklantoday_keterangan']=$rsiklan->iklantoday_keterangan;
		
		if($cara_bayar!==NULL){
			$data['cara_bayar1']=$cara_bayar->jpaket_cara;
			$data['nilai_bayar1']=$cara_bayar->bayar_nilai;
		}else{
			$data['cara_bayar1']="";
			$data['nilai_bayar1']="";
		}
		
		if($cara_bayar2!==NULL){
			$data['cara_bayar2']=$cara_bayar2->jpaket_cara2;
			$data['nilai_bayar2']=$cara_bayar2->bayar2_nilai;
		}else{
			$data['cara_bayar2']="";
			$data['nilai_bayar2']="";
		}
		
		if($cara_bayar3!==NULL){
			$data['cara_bayar3']=$cara_bayar3->jpaket_cara3;
			$data['nilai_bayar3']=$cara_bayar3->bayar3_nilai;
		}else{
			$data['cara_bayar3']="";
			$data['nilai_bayar3']="";
		}
		
		$viewdata=$this->load->view("main/jpaket_formcetak2_printonly",$data,TRUE);
		$file = fopen("jpaket_paper2.html",'w');
		fwrite($file, $viewdata);	
		fclose($file);
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