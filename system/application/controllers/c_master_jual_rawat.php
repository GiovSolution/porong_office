<?php
/* 	
	Miracle IT Team
*/

//class of master_jual_rawat
class C_master_jual_rawat extends Controller {

	//constructor
	function C_master_jual_rawat(){
		parent::Controller();
		session_start();
		$this->load->model('m_master_jual_rawat', '', TRUE);
		$this->load->plugin('to_excel');
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_master_jual_rawat');
	}
	
	function laporan(){
		$this->load->view('main/v_lap_jual_rawat');
	}
	
	function get_info_pajak(){
		$result=$this->m_master_jual_rawat->get_info_pajak();
		echo $result;
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
		
		$data["jenis"]='Perawatan';
		if($periode=="all"){
			$data["periode"]="Semua Periode";
		}else if($periode=="bulan"){
			$tgl_awal=$tahun."-".$bulan;
			$data["periode"]=get_ina_month_name($bulan,'long')." ".$tahun;
		}else if($periode=="tanggal"){
			$data["periode"]="Periode : ".$tgl_awal." s/d ".$tgl_akhir.", ";
		}
		
		$data["data_print"]=$this->m_master_jual_rawat->get_laporan($tgl_awal,$tgl_akhir,$periode,$opsi,$opsi_status,$group);
			
		if($opsi=='rekap'){
			$data["opsi"]='Rekap';
			switch($group){
				case "Tanggal": $print_view=$this->load->view("main/p_rekap_jual_tanggal.php",$data,TRUE);break;
				case "Customer": $print_view=$this->load->view("main/p_rekap_jual_customer.php",$data,TRUE);break;
				case "Voucher": $print_view=$this->load->view("main/p_rekap_jual_voucher.php",$data,TRUE);break;
				default: $print_view=$this->load->view("main/p_rekap_jual.php",$data,TRUE);break;
			}
		}else if($opsi=='detail'){
			$data["opsi"]='Detail';
			switch($group){
				case "Tanggal": $print_view=$this->load->view("main/p_detail_jual_tanggal.php",$data,TRUE);break;
				case "Tanggal 2 (PPN)": $print_view=$this->load->view("main/p_detail_jual_tanggal2.php",$data,TRUE);break;
				case "Customer": $print_view=$this->load->view("main/p_detail_jual_customer.php",$data,TRUE);break;
				case "Perawatan Semua": $print_view=$this->load->view("main/p_detail_jual_produk.php",$data,TRUE);break;
				case "Perawatan Medis": $print_view=$this->load->view("main/p_detail_jual_produk.php",$data,TRUE);break;
				case "Perawatan Non Medis": $print_view=$this->load->view("main/p_detail_jual_produk.php",$data,TRUE);break;
				case "Perawatan Surgery": $print_view=$this->load->view("main/p_detail_jual_produk.php",$data,TRUE);break;
				case "Perawatan Anti Aging": $print_view=$this->load->view("main/p_detail_jual_produk.php",$data,TRUE);break;
				case "Perawatan Lain-Lain": $print_view=$this->load->view("main/p_detail_jual_produk.php",$data,TRUE);break;
				case "Referal": $print_view=$this->load->view("main/p_detail_jual_sales.php",$data,TRUE);break;
				case "Jenis Diskon": $print_view=$this->load->view("main/p_detail_jual_diskon.php",$data,TRUE);break;
				default: $print_view=$this->load->view("main/p_detail_jual_semua.php",$data,TRUE);break;
			}
		}
		else if($opsi=='grooming'){
			$data["opsi"]='Grooming';
			switch($group){
				case "Tanggal": $print_view=$this->load->view("main/p_detail_jual_tanggal.php",$data,TRUE);break;
				case "Tanggal 2 (PPN)": $print_view=$this->load->view("main/p_detail_jual_tanggal2.php",$data,TRUE);break;
				case "Karyawan": $print_view=$this->load->view("main/p_detail_jual_customer.php",$data,TRUE);break;
				default: $print_view=$this->load->view("main/p_detail_jual.php",$data,TRUE);break;
			}
		}
		
		
		if(!file_exists("print")){
			mkdir("print");
		}
		if($opsi=='rekap')
			$print_file=fopen("print/report_jrawat.html","w+");
		else
			$print_file=fopen("print/report_jrawat.html","w+");
			
		fwrite($print_file, $print_view);
		echo '1'; 
	}
	
	function get_bank_list(){
		$result=$this->m_public_function->get_bank_list();
		echo $result;
	}
	
	function get_customer_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_public_function->get_customer_list($query,$start,$end);
		echo $result;
	}
	
	function get_referal_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$result=$this->m_master_jual_rawat->get_referal_list($query);
		echo $result;
	}
	
	function get_nik(){
		$karyawan_id = (integer) (isset($_POST['karyawan_id']) ? $_POST['karyawan_id'] : $_GET['karyawan_id']);
		$result=$this->m_public_function->get_auto_karyawan_sip($karyawan_id); //untuk mendapatkan nik karyawan
		echo $result;
	}
	
	function get_rawat_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$aktif = trim(@$_POST["aktif"]);
		$result = $this->m_master_jual_rawat->get_rawat_list($query,$start,$end,$aktif);
		echo $result;
	}
		
	function get_harga_rawat(){
		$rawat_id = (integer) (isset($_POST['rawat_id']) ? $_POST['rawat_id'] : $_GET['rawat_id']);
		$result = $this->m_public_function->get_harga_rawat($rawat_id);
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
		$result=$this->m_master_jual_rawat->get_voucher_list($query,$start,$end);
		echo $result;
	}
	
	function  get_kwitansi_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		//$query = isset($_POST['query']) ? $_POST['query'] : "";
		//$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		//$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$start=0;
		$end=10;
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
	function  detail_detail_jual_rawat_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_master_jual_rawat->detail_detail_jual_rawat_list($master_id,$query,$start,$end);
		echo $result;
	}
	//end of handler
	
	//purge all detail
	function detail_detail_jual_rawat_purge(){
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_master_jual_rawat->detail_detail_jual_rawat_purge($master_id);
	}
	//eof
	
	//get master id, note: not done yet
	function get_master_id(){
		$result=$this->m_master_jual_rawat->get_master_id();
		echo $result;
	}
	//
	
	function catatan_piutang_update(){
		$drawat_master = isset($_POST['drawat_master']) ? $_POST['drawat_master'] : "";
		$result=$this->m_master_jual_rawat->catatan_piutang_update($drawat_master);
		echo $result;
	}
	
	//for detail pengambilan paket
	//list detail handler action
	function  detail_ambil_paket_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		//$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$dpaket_id = (integer) (isset($_POST['dpaket_id']) ? $_POST['dpaket_id'] : 0);
		$tanggal = isset($_POST['tanggal']) ? $_POST['tanggal'] : "";
		$dapaket_cust = isset($_POST['dapaket_cust']) ? $_POST['dapaket_cust'] : 0;
		$dapaket_stat_dok=trim(@$_POST["dapaket_stat_dok"]);
		$dapaket_stat_dok=str_replace("/(<\/?)(p)([^>]*>)", "",$dapaket_stat_dok);
		$dapaket_stat_dok=str_replace("'", '"',$dapaket_stat_dok);
		$dapaket_nobukti_pajak	= trim(@$_POST["dapaket_nobukti_pajak"]);
		$dapaket_nobukti_medis	= trim(@$_POST["dapaket_nobukti_medis"]);
		$result=$this->m_master_jual_rawat->detail_ambil_paket_list($dpaket_id,$tanggal,$dapaket_cust,$query,$dapaket_stat_dok,$start,$end, $dapaket_nobukti_pajak, $dapaket_nobukti_medis);
		echo $result;
	}
	//end of handler
	
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->master_jual_rawat_list();
				break;
			case "UPDATE":
				$this->master_jual_rawat_update();
				break;
			case "CREATE":
				$this->master_jual_rawat_create();
				break;
			case "CEK":
				$this->master_jual_rawat_pengecekan();
				break;
			case "SEARCH":
				$this->master_jual_rawat_search();
				break;
			case "PRINT":
				$this->master_jual_rawat_print();
				break;
			case "EXCEL":
				$this->master_jual_rawat_export_excel();
				break;
            case "DDELETE":
				$this->detail_jual_rawat_delete();
				break;
			case "BATAL":
				$this->master_jual_rawat_batal();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function master_jual_rawat_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_master_jual_rawat->master_jual_rawat_list($query,$start,$end);
		echo $result;
	}

	function get_allkaryawan_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_master_jual_rawat->get_allkaryawan_list($query,$start,$end);
		echo $result;
	}
	
	function master_jual_rawat_pengecekan(){
	
		$tanggal_pengecekan=trim(@$_POST["tanggal_pengecekan"]);
	
		$result=$this->m_public_function->pengecekan_dokumen($tanggal_pengecekan);
		echo $result;
	}
	
	
	//function for update record
	function master_jual_rawat_update(){
		//POST variable here
		$jrawat_id=trim(@$_POST["jrawat_id"]);
		$jrawat_nobukti=trim(@$_POST["jrawat_nobukti"]);
		$jrawat_nobukti=str_replace("/(<\/?)(p)([^>]*>)", "",$jrawat_nobukti);
		$jrawat_nobukti=str_replace("'", '"',$jrawat_nobukti);
		$jrawat_grooming=trim(@$_POST["jrawat_grooming"]);
		
		$jrawat_nobukti_medis=trim(@$_POST["jrawat_nobukti_medis"]);
		$jrawat_nobukti_medis=str_replace("/(<\/?)(p)([^>]*>)", "",$jrawat_nobukti_medis);
		$jrawat_nobukti_medis=str_replace("'", '"',$jrawat_nobukti_medis);
		$jrawat_nobukti_pajak=trim(@$_POST["jrawat_nobukti_pajak"]);
		$jrawat_nobukti_pajak=str_replace("/(<\/?)(p)([^>]*>)", "",$jrawat_nobukti_pajak);
		$jrawat_nobukti_pajak=str_replace("'", '"',$jrawat_nobukti_pajak);
		$jrawat_total_medis=trim($_POST["jrawat_total_medis"]);
		$jrawat_total_nonmedis=trim($_POST["jrawat_total_nonmedis"]);
		
		$jrawat_cust=trim(@$_POST["jrawat_cust"]);
		$jrawat_tanggal=trim(@$_POST["jrawat_tanggal"]);
		$jrawat_diskon=trim(@$_POST["jrawat_diskon"]);
		$jrawat_cara=trim(@$_POST["jrawat_cara"]);
		$jrawat_cara=str_replace("/(<\/?)(p)([^>]*>)", "",$jrawat_cara);
		$jrawat_cara=str_replace("'", '"',$jrawat_cara);
		
		$jrawat_cara2=trim(@$_POST["jrawat_cara2"]);
		$jrawat_cara2=str_replace("/(<\/?)(p)([^>]*>)", "",$jrawat_cara2);
		$jrawat_cara2=str_replace("'", '"',$jrawat_cara2);
		
		$jrawat_cara3=trim(@$_POST["jrawat_cara3"]);
		$jrawat_cara3=str_replace("/(<\/?)(p)([^>]*>)", "",$jrawat_cara3);
		$jrawat_cara3=str_replace("'", '"',$jrawat_cara3);
		
		$jrawat_keterangan=trim(@$_POST["jrawat_keterangan"]);
		$jrawat_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$jrawat_keterangan);
		$jrawat_keterangan=str_replace("'", '"',$jrawat_keterangan);
		
		$jrawat_ket_disk=trim(@$_POST["jrawat_ket_disk"]);
		$jrawat_ket_disk=str_replace("/(<\/?)(p)([^>]*>)", "",$jrawat_ket_disk);
		$jrawat_ket_disk=str_replace("'", '"',$jrawat_ket_disk);
		
		$jrawat_ket_disk_medis=trim(@$_POST["jrawat_ket_disk_medis"]);
		$jrawat_ket_disk_medis=str_replace("/(<\/?)(p)([^>]*>)", "",$jrawat_ket_disk_medis);
		$jrawat_ket_disk_medis=str_replace("'", '"',$jrawat_ket_disk_medis);
		
		$jrawat_stat_dok=trim(@$_POST["jrawat_stat_dok"]);
		$jrawat_stat_dok=str_replace("/(<\/?)(p)([^>]*>)", "",$jrawat_stat_dok);
		$jrawat_stat_dok=str_replace("'", '"',$jrawat_stat_dok);
		
		$jrawat_cashback=trim($_POST["jrawat_cashback"]);
		$jrawat_cashback_medis=trim($_POST["jrawat_cashback_medis"]);
		
		//tunai
		$jrawat_tunai_nilai=trim($_POST["jrawat_tunai_nilai"]);
		//tunai-2
		$jrawat_tunai_nilai2=trim($_POST["jrawat_tunai_nilai2"]);
		//tunai-3
		$jrawat_tunai_nilai3=trim($_POST["jrawat_tunai_nilai3"]);
		//voucher
		$jrawat_voucher_no=trim($_POST["jrawat_voucher_no"]);
		$jrawat_voucher_cashback=trim($_POST["jrawat_voucher_cashback"]);
		//voucher-2
		$jrawat_voucher_no2=trim($_POST["jrawat_voucher_no2"]);
		$jrawat_voucher_cashback2=trim($_POST["jrawat_voucher_cashback2"]);
		//voucher-3
		$jrawat_voucher_no3=trim($_POST["jrawat_voucher_no3"]);
		$jrawat_voucher_cashback3=trim($_POST["jrawat_voucher_cashback3"]);
		
		//bayar
		$jrawat_total=trim($_POST["jrawat_total"]);
		$jrawat_bayar=trim($_POST["jrawat_bayar"]);
		$jrawat_subtotal=trim($_POST["jrawat_subtotal"]);
		$jrawat_hutang=trim($_POST["jrawat_hutang"]);
		//card
		$jrawat_card_nama=trim($_POST["jrawat_card_nama"]);
		$jrawat_card_edc=trim($_POST["jrawat_card_edc"]);
		$jrawat_card_no=trim($_POST["jrawat_card_no"]);
		$jrawat_card_nilai=trim($_POST["jrawat_card_nilai"]);
		//card-2
		$jrawat_card_nama2=trim($_POST["jrawat_card_nama2"]);
		$jrawat_card_edc2=trim($_POST["jrawat_card_edc2"]);
		$jrawat_card_no2=trim($_POST["jrawat_card_no2"]);
		$jrawat_card_nilai2=trim($_POST["jrawat_card_nilai2"]);
		//card-3
		$jrawat_card_nama3=trim($_POST["jrawat_card_nama3"]);
		$jrawat_card_edc3=trim($_POST["jrawat_card_edc3"]);
		$jrawat_card_no3=trim($_POST["jrawat_card_no3"]);
		$jrawat_card_nilai3=trim($_POST["jrawat_card_nilai3"]);
		//kwitansi
		$jrawat_kwitansi_no=trim($_POST["jrawat_kwitansi_no"]);
		$jrawat_kwitansi_nama=trim(@$_POST["jrawat_kwitansi_nama"]);
		$jrawat_kwitansi_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$jrawat_kwitansi_nama);
		$jrawat_kwitansi_nama=str_replace("'", '"',$jrawat_kwitansi_nama);
		$jrawat_kwitansi_nilai=trim($_POST["jrawat_kwitansi_nilai"]);
		$jual_kwitansi_id=trim($_POST["jual_kwitansi_id"]);
		//kwitansi-2
		$jrawat_kwitansi_no2=trim($_POST["jrawat_kwitansi_no2"]);
		$jrawat_kwitansi_nama2=trim(@$_POST["jrawat_kwitansi_nama2"]);
		$jrawat_kwitansi_nama2=str_replace("/(<\/?)(p)([^>]*>)", "",$jrawat_kwitansi_nama2);
		$jrawat_kwitansi_nama2=str_replace("'", '"',$jrawat_kwitansi_nama2);
		$jrawat_kwitansi_nilai2=trim($_POST["jrawat_kwitansi_nilai2"]);
		$jual_kwitansi_id2=trim($_POST["jual_kwitansi_id2"]);
		//kwitansi-3
		$jrawat_kwitansi_no3=trim($_POST["jrawat_kwitansi_no3"]);
		$jrawat_kwitansi_nama3=trim(@$_POST["jrawat_kwitansi_nama3"]);
		$jrawat_kwitansi_nama3=str_replace("/(<\/?)(p)([^>]*>)", "",$jrawat_kwitansi_nama3);
		$jrawat_kwitansi_nama3=str_replace("'", '"',$jrawat_kwitansi_nama3);
		$jrawat_kwitansi_nilai3=trim($_POST["jrawat_kwitansi_nilai3"]);
		$jual_kwitansi_id3=trim($_POST["jual_kwitansi_id3"]);
		//cek
		$jrawat_cek_nama=trim($_POST["jrawat_cek_nama"]);
		$jrawat_cek_no=trim($_POST["jrawat_cek_no"]);
		$jrawat_cek_valid=trim($_POST["jrawat_cek_valid"]);
		$jrawat_cek_bank=trim($_POST["jrawat_cek_bank"]);
		$jrawat_cek_nilai=trim($_POST["jrawat_cek_nilai"]);
		//cek-2
		$jrawat_cek_nama2=trim($_POST["jrawat_cek_nama2"]);
		$jrawat_cek_no2=trim($_POST["jrawat_cek_no2"]);
		$jrawat_cek_valid2=trim($_POST["jrawat_cek_valid2"]);
		$jrawat_cek_bank2=trim($_POST["jrawat_cek_bank2"]);
		$jrawat_cek_nilai2=trim($_POST["jrawat_cek_nilai2"]);
		//cek-3
		$jrawat_cek_nama3=trim($_POST["jrawat_cek_nama3"]);
		$jrawat_cek_no3=trim($_POST["jrawat_cek_no3"]);
		$jrawat_cek_valid3=trim($_POST["jrawat_cek_valid3"]);
		$jrawat_cek_bank3=trim($_POST["jrawat_cek_bank3"]);
		$jrawat_cek_nilai3=trim($_POST["jrawat_cek_nilai3"]);
		//transfer
		$jrawat_transfer_bank=trim($_POST["jrawat_transfer_bank"]);
		$jrawat_transfer_nama=trim($_POST["jrawat_transfer_nama"]);
		$jrawat_transfer_nilai=trim($_POST["jrawat_transfer_nilai"]);
		//transfer-2
		$jrawat_transfer_bank2=trim($_POST["jrawat_transfer_bank2"]);
		$jrawat_transfer_nama2=trim($_POST["jrawat_transfer_nama2"]);
		$jrawat_transfer_nilai2=trim($_POST["jrawat_transfer_nilai2"]);
		//transfer-3
		$jrawat_transfer_bank3=trim($_POST["jrawat_transfer_bank3"]);
		$jrawat_transfer_nama3=trim($_POST["jrawat_transfer_nama3"]);
		$jrawat_transfer_nilai3=trim($_POST["jrawat_transfer_nilai3"]);
		
		$cetak_jrawat=trim($_POST["cetak_jrawat"]);
		
		$drawat_count=trim($_POST["drawat_count"]);
		
		$dcount_drawat_id=trim($_POST["dcount_drawat_id"]);
		
		/*
		 * Penambahan Detail Penjualan Perawatan
		*/
		$drawat_id = $_POST['drawat_id']; // Get our array back and translate it :
		$array_drawat_id = json_decode(stripslashes($drawat_id));
		
		$drawat_dtrawat = $_POST['drawat_dtrawat']; // Get our array back and translate it :
		$array_drawat_dtrawat = json_decode(stripslashes($drawat_dtrawat));
		
		$drawat_rawat = $_POST['drawat_rawat']; // Get our array back and translate it :
		$array_drawat_rawat = json_decode(stripslashes($drawat_rawat));
		
		$drawat_jumlah = $_POST['drawat_jumlah']; // Get our array back and translate it :
		$array_drawat_jumlah = json_decode(stripslashes($drawat_jumlah));
		
		$drawat_harga = $_POST['drawat_harga']; // Get our array back and translate it :
		$array_drawat_harga = json_decode(stripslashes($drawat_harga));
		
		$drawat_diskon = $_POST['drawat_diskon']; // Get our array back and translate it :
		$array_drawat_diskon = json_decode(stripslashes($drawat_diskon));
		
		$drawat_diskon_jenis = $_POST['drawat_diskon_jenis']; // Get our array back and translate it :
		$array_drawat_diskon_jenis = json_decode(stripslashes($drawat_diskon_jenis));
		
		$drawat_sales = $_POST['drawat_sales']; // Get our array back and translate it :
		$array_drawat_sales = json_decode(stripslashes($drawat_sales));
		
		$drawat_karyawan = $_POST['drawat_karyawan']; // Get our array back and translate it :
		$array_drawat_karyawan = json_decode(stripslashes($drawat_karyawan));
		
		$result = $this->m_master_jual_rawat->master_jual_rawat_update($jrawat_id ,$jrawat_nobukti ,$jrawat_nobukti_medis,$jrawat_nobukti_pajak,$jrawat_total_medis,$jrawat_total_nonmedis,$jrawat_cust ,$jrawat_tanggal
																	   ,$jrawat_stat_dok, $jrawat_diskon ,$jrawat_cara ,$jrawat_cara2
																	   ,$jrawat_cara3 ,$jrawat_keterangan , $jrawat_cashback, $jrawat_cashback_medis, $jrawat_tunai_nilai
																	   ,$jrawat_tunai_nilai2, $jrawat_tunai_nilai3, $jrawat_voucher_no
																	   ,$jrawat_voucher_cashback, $jrawat_voucher_no2, $jrawat_voucher_cashback2
																	   ,$jrawat_voucher_no3, $jrawat_voucher_cashback3, $jrawat_total
																	   ,$jrawat_bayar, $jrawat_subtotal, $jrawat_hutang, $jrawat_kwitansi_no
																	   ,$jrawat_kwitansi_nama, $jrawat_kwitansi_nilai, $jrawat_kwitansi_no2
																	   ,$jrawat_kwitansi_nama2, $jrawat_kwitansi_nilai2, $jrawat_kwitansi_no3
																	   ,$jrawat_kwitansi_nama3, $jrawat_kwitansi_nilai3, $jrawat_card_nama
																	   ,$jrawat_card_edc, $jrawat_card_no, $jrawat_card_nilai, $jrawat_card_nama2
																	   ,$jrawat_card_edc2, $jrawat_card_no2, $jrawat_card_nilai2, $jrawat_card_nama3
																	   ,$jrawat_card_edc3, $jrawat_card_no3, $jrawat_card_nilai3, $jrawat_cek_nama
																	   ,$jrawat_cek_no, $jrawat_cek_valid, $jrawat_cek_bank, $jrawat_cek_nilai
																	   ,$jrawat_cek_nama2, $jrawat_cek_no2, $jrawat_cek_valid2, $jrawat_cek_bank2
																	   ,$jrawat_cek_nilai2, $jrawat_cek_nama3, $jrawat_cek_no3, $jrawat_cek_valid3
																	   ,$jrawat_cek_bank3, $jrawat_cek_nilai3, $jrawat_transfer_bank
																	   ,$jrawat_transfer_nama, $jrawat_transfer_nilai, $jrawat_transfer_bank2
																	   ,$jrawat_transfer_nama2, $jrawat_transfer_nilai2, $jrawat_transfer_bank3
																	   ,$jrawat_transfer_nama3, $jrawat_transfer_nilai3 ,$cetak_jrawat
																	   ,$jrawat_ket_disk, $jrawat_ket_disk_medis, $drawat_count, $dcount_drawat_id
																	   ,$array_drawat_id ,$array_drawat_dtrawat ,$array_drawat_rawat
																	   ,$array_drawat_jumlah ,$array_drawat_harga ,$array_drawat_diskon
																	   ,$array_drawat_diskon_jenis, $array_drawat_sales, $array_drawat_karyawan, $jrawat_grooming, $jual_kwitansi_id, $jual_kwitansi_id2, $jual_kwitansi_id3);
		echo $result;
	}
	
	//function for create new record
	function master_jual_rawat_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		/*$jrawat_nobukti=trim(@$_POST["jrawat_nobukti"]);
		$jrawat_nobukti=str_replace("/(<\/?)(p)([^>]*>)", "",$jrawat_nobukti);
		$jrawat_nobukti=str_replace("'", '"',$jrawat_nobukti);*/
		$jrawat_cust=trim(@$_POST["jrawat_cust"]);
		$jrawat_tanggal=trim(@$_POST["jrawat_tanggal"]);
		$jrawat_diskon=trim(@$_POST["jrawat_diskon"]);
		$jrawat_grooming=trim(@$_POST["jrawat_grooming"]);
		$jrawat_cara=trim(@$_POST["jrawat_cara"]);
		$jrawat_cara=str_replace("/(<\/?)(p)([^>]*>)", "",$jrawat_cara);
		$jrawat_cara=str_replace("'", '"',$jrawat_cara);
		
		$jrawat_cara2=trim(@$_POST["jrawat_cara2"]);
		$jrawat_cara2=str_replace("/(<\/?)(p)([^>]*>)", "",$jrawat_cara2);
		$jrawat_cara2=str_replace("'", '"',$jrawat_cara2);
		
		$jrawat_cara3=trim(@$_POST["jrawat_cara3"]);
		$jrawat_cara3=str_replace("/(<\/?)(p)([^>]*>)", "",$jrawat_cara3);
		$jrawat_cara3=str_replace("'", '"',$jrawat_cara3);
		
		$jrawat_keterangan=trim(@$_POST["jrawat_keterangan"]);
		$jrawat_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$jrawat_keterangan);
		$jrawat_keterangan=str_replace("'", '"',$jrawat_keterangan);
		
		$jrawat_ket_disk=trim(@$_POST["jrawat_ket_disk"]);
		$jrawat_ket_disk=str_replace("/(<\/?)(p)([^>]*>)", "",$jrawat_ket_disk);
		$jrawat_ket_disk=str_replace("'", '"',$jrawat_ket_disk);
		
		$jrawat_ket_disk_medis=trim(@$_POST["jrawat_ket_disk_medis"]);
		$jrawat_ket_disk_medis=str_replace("/(<\/?)(p)([^>]*>)", "",$jrawat_ket_disk_medis);
		$jrawat_ket_disk_medis=str_replace("'", '"',$jrawat_ket_disk_medis);
		
		$jrawat_stat_dok=trim(@$_POST["jrawat_stat_dok"]);
		$jrawat_stat_dok=str_replace("/(<\/?)(p)([^>]*>)", "",$jrawat_stat_dok);
		$jrawat_stat_dok=str_replace("'", '"',$jrawat_stat_dok);
		
		$jrawat_total_medis=trim($_POST["jrawat_total_medis"]);
		$jrawat_total_nonmedis=trim($_POST["jrawat_total_nonmedis"]);
		$jrawat_cashback=trim(@$_POST["jrawat_cashback"]);
		$jrawat_cashback_medis=trim(@$_POST["jrawat_cashback_medis"]);
		//$jrawat_voucher=trim($_POST["jrawat_voucher"]);
		//tunai
		$jrawat_tunai_nilai=trim(@$_POST["jrawat_tunai_nilai"]);
		//tunai-2
		$jrawat_tunai_nilai2=trim(@$_POST["jrawat_tunai_nilai2"]);
		//tunai-3
		$jrawat_tunai_nilai3=trim(@$_POST["jrawat_tunai_nilai3"]);
		//voucher
		$jrawat_voucher_no=trim(@$_POST["jrawat_voucher_no"]);
		$jrawat_voucher_cashback=trim(@$_POST["jrawat_voucher_cashback"]);
		//voucher-2
		$jrawat_voucher_no2=trim(@$_POST["jrawat_voucher_no2"]);
		$jrawat_voucher_cashback2=trim(@$_POST["jrawat_voucher_cashback2"]);
		//voucher-3
		$jrawat_voucher_no3=trim(@$_POST["jrawat_voucher_no3"]);
		$jrawat_voucher_cashback3=trim($_POST["jrawat_voucher_cashback3"]);
		//bayar
		$jrawat_total=trim(@$_POST["jrawat_total"]);
		$jrawat_bayar=trim(@$_POST["jrawat_bayar"]);
		$jrawat_subtotal=trim(@$_POST["jrawat_subtotal"]);
		$jrawat_hutang=trim(@$_POST["jrawat_hutang"]);
		//card
		$jrawat_card_nama=trim(@$_POST["jrawat_card_nama"]);
		$jrawat_card_edc=trim(@$_POST["jrawat_card_edc"]);
		$jrawat_card_no=trim(@$_POST["jrawat_card_no"]);
		$jrawat_card_nilai=trim(@$_POST["jrawat_card_nilai"]);
		//card-2
		$jrawat_card_nama2=trim(@$_POST["jrawat_card_nama2"]);
		$jrawat_card_edc2=trim(@$_POST["jrawat_card_edc2"]);
		$jrawat_card_no2=trim(@$_POST["jrawat_card_no2"]);
		$jrawat_card_nilai2=trim(@$_POST["jrawat_card_nilai2"]);
		//card-3
		$jrawat_card_nama3=trim(@$_POST["jrawat_card_nama3"]);
		$jrawat_card_edc3=trim(@$_POST["jrawat_card_edc3"]);
		$jrawat_card_no3=trim(@$_POST["jrawat_card_no3"]);
		$jrawat_card_nilai3=trim(@$_POST["jrawat_card_nilai3"]);
		//kwitansi
		$jrawat_kwitansi_no=trim(@$_POST["jrawat_kwitansi_no"]);
		$jrawat_kwitansi_nama=trim(@$_POST["jrawat_kwitansi_nama"]);
		$jrawat_kwitansi_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$jrawat_kwitansi_nama);
		$jrawat_kwitansi_nama=str_replace("'", '"',$jrawat_kwitansi_nama);
		$jrawat_kwitansi_nilai=trim(@$_POST["jrawat_kwitansi_nilai"]);
		$jual_kwitansi_id=trim($_POST["jual_kwitansi_id"]);
		//kwitansi-2
		$jrawat_kwitansi_no2=trim(@$_POST["jrawat_kwitansi_no2"]);
		$jrawat_kwitansi_nama2=trim(@$_POST["jrawat_kwitansi_nama2"]);
		$jrawat_kwitansi_nama2=str_replace("/(<\/?)(p)([^>]*>)", "",$jrawat_kwitansi_nama2);
		$jrawat_kwitansi_nama2=str_replace("'", '"',$jrawat_kwitansi_nama2);
		$jrawat_kwitansi_nilai2=trim(@$_POST["jrawat_kwitansi_nilai2"]);
		$jual_kwitansi_id2=trim($_POST["jual_kwitansi_id2"]);
		//kwitansi-3
		$jrawat_kwitansi_no3=trim(@$_POST["jrawat_kwitansi_no3"]);
		$jrawat_kwitansi_nama3=trim(@$_POST["jrawat_kwitansi_nama3"]);
		$jrawat_kwitansi_nama3=str_replace("/(<\/?)(p)([^>]*>)", "",$jrawat_kwitansi_nama3);
		$jrawat_kwitansi_nama3=str_replace("'", '"',$jrawat_kwitansi_nama3);
		$jrawat_kwitansi_nilai3=trim(@$_POST["jrawat_kwitansi_nilai3"]);
		$jual_kwitansi_id3=trim($_POST["jual_kwitansi_id3"]);
		//cek
		$jrawat_cek_nama=trim(@$_POST["jrawat_cek_nama"]);
		$jrawat_cek_no=trim(@$_POST["jrawat_cek_no"]);
		$jrawat_cek_valid=trim(@$_POST["jrawat_cek_valid"]);
		$jrawat_cek_bank=trim(@$_POST["jrawat_cek_bank"]);
		$jrawat_cek_nilai=trim(@$_POST["jrawat_cek_nilai"]);
		//cek-2
		$jrawat_cek_nama2=trim(@$_POST["jrawat_cek_nama2"]);
		$jrawat_cek_no2=trim(@$_POST["jrawat_cek_no2"]);
		$jrawat_cek_valid2=trim(@$_POST["jrawat_cek_valid2"]);
		$jrawat_cek_bank2=trim(@$_POST["jrawat_cek_bank2"]);
		$jrawat_cek_nilai2=trim(@$_POST["jrawat_cek_nilai2"]);
		//cek-3
		$jrawat_cek_nama3=trim(@$_POST["jrawat_cek_nama3"]);
		$jrawat_cek_no3=trim(@$_POST["jrawat_cek_no3"]);
		$jrawat_cek_valid3=trim(@$_POST["jrawat_cek_valid3"]);
		$jrawat_cek_bank3=trim(@$_POST["jrawat_cek_bank3"]);
		$jrawat_cek_nilai3=trim(@$_POST["jrawat_cek_nilai3"]);
		//transfer
		$jrawat_transfer_bank=trim(@$_POST["jrawat_transfer_bank"]);
		$jrawat_transfer_nama=trim(@$_POST["jrawat_transfer_nama"]);
		$jrawat_transfer_nilai=trim(@$_POST["jrawat_transfer_nilai"]);
		//transfer-2
		$jrawat_transfer_bank2=trim(@$_POST["jrawat_transfer_bank2"]);
		$jrawat_transfer_nama2=trim(@$_POST["jrawat_transfer_nama2"]);
		$jrawat_transfer_nilai2=trim(@$_POST["jrawat_transfer_nilai2"]);
		//transfer-3
		$jrawat_transfer_bank3=trim(@$_POST["jrawat_transfer_bank3"]);
		$jrawat_transfer_nama3=trim(@$_POST["jrawat_transfer_nama3"]);
		$jrawat_transfer_nilai3=trim(@$_POST["jrawat_transfer_nilai3"]);
		
		$cetak_jrawat=trim(@$_POST["cetak_jrawat"]);
		
		/*
		 * Penambahan Detail Penjualan Perawatan
		*/
		$drawat_id = $_POST['drawat_id']; // Get our array back and translate it :
		$array_drawat_id = json_decode(stripslashes($drawat_id));
		
		$drawat_dtrawat = $_POST['drawat_dtrawat']; // Get our array back and translate it :
		$array_drawat_dtrawat = json_decode(stripslashes($drawat_dtrawat));
		
		$drawat_rawat = $_POST['drawat_rawat']; // Get our array back and translate it :
		$array_drawat_rawat = json_decode(stripslashes($drawat_rawat));
		
		$drawat_jumlah = $_POST['drawat_jumlah']; // Get our array back and translate it :
		$array_drawat_jumlah = json_decode(stripslashes($drawat_jumlah));
		
		$drawat_harga = $_POST['drawat_harga']; // Get our array back and translate it :
		$array_drawat_harga = json_decode(stripslashes($drawat_harga));
		
		$drawat_diskon = $_POST['drawat_diskon']; // Get our array back and translate it :
		$array_drawat_diskon = json_decode(stripslashes($drawat_diskon));
		
		$drawat_diskon_jenis = $_POST['drawat_diskon_jenis']; // Get our array back and translate it :
		$array_drawat_diskon_jenis = json_decode(stripslashes($drawat_diskon_jenis));
		
		$drawat_sales = $_POST['drawat_sales']; // Get our array back and translate it :
		$array_drawat_sales = json_decode(stripslashes($drawat_sales));
		
		$drawat_karyawan = $_POST['drawat_karyawan']; // Get our array back and translate it :
		$array_drawat_karyawan = json_decode(stripslashes($drawat_karyawan));
		
		$result=$this->m_master_jual_rawat->master_jual_rawat_create($jrawat_cust ,$jrawat_total_medis,$jrawat_total_nonmedis,$jrawat_tanggal ,$jrawat_diskon ,$jrawat_cara ,$jrawat_stat_dok
																	 ,$jrawat_cara2 ,$jrawat_cara3 ,$jrawat_keterangan , $jrawat_cashback, $jrawat_cashback_medis
																	 ,$jrawat_tunai_nilai, $jrawat_tunai_nilai2, $jrawat_tunai_nilai3
																	 ,$jrawat_voucher_no, $jrawat_voucher_cashback, $jrawat_voucher_no2
																	 ,$jrawat_voucher_cashback2, $jrawat_voucher_no3, $jrawat_voucher_cashback3
																	 ,$jrawat_total, $jrawat_bayar, $jrawat_subtotal, $jrawat_hutang
																	 ,$jrawat_kwitansi_no, $jrawat_kwitansi_nama, $jrawat_kwitansi_nilai
																	 ,$jrawat_kwitansi_no2, $jrawat_kwitansi_nama2, $jrawat_kwitansi_nilai2
																	 ,$jrawat_kwitansi_no3, $jrawat_kwitansi_nama3, $jrawat_kwitansi_nilai3
																	 ,$jrawat_card_nama, $jrawat_card_edc, $jrawat_card_no, $jrawat_card_nilai
																	 ,$jrawat_card_nama2, $jrawat_card_edc2, $jrawat_card_no2, $jrawat_card_nilai2
																	 ,$jrawat_card_nama3, $jrawat_card_edc3, $jrawat_card_no3, $jrawat_card_nilai3
																	 ,$jrawat_cek_nama, $jrawat_cek_no, $jrawat_cek_valid, $jrawat_cek_bank
																	 ,$jrawat_cek_nilai, $jrawat_cek_nama2, $jrawat_cek_no2, $jrawat_cek_valid2
																	 ,$jrawat_cek_bank2, $jrawat_cek_nilai2, $jrawat_cek_nama3, $jrawat_cek_no3
																	 ,$jrawat_cek_valid3, $jrawat_cek_bank3, $jrawat_cek_nilai3
																	 ,$jrawat_transfer_bank, $jrawat_transfer_nama, $jrawat_transfer_nilai
																	 ,$jrawat_transfer_bank2, $jrawat_transfer_nama2, $jrawat_transfer_nilai2
																	 ,$jrawat_transfer_bank3, $jrawat_transfer_nama3, $jrawat_transfer_nilai3
																	 ,$cetak_jrawat, $jrawat_ket_disk, $jrawat_ket_disk_medis
																	 ,$array_drawat_id ,$array_drawat_dtrawat ,$array_drawat_rawat
																	 ,$array_drawat_jumlah ,$array_drawat_harga ,$array_drawat_diskon
																	 ,$array_drawat_diskon_jenis, $array_drawat_sales, $array_drawat_karyawan, $jrawat_grooming, $jual_kwitansi_id, $jual_kwitansi_id2, $jual_kwitansi_id3);
		echo $result;
	}
    
    function detail_jual_rawat_delete(){
        $ids = $_POST['ids'];
        $drawat_id = json_decode(stripslashes($ids));
		
		$drawat_master = $_POST['drawat_master'];
        $array_drawat_master = json_decode(stripslashes($drawat_master));
		
        $result=$this->m_master_jual_rawat->detail_jual_rawat_delete($drawat_id ,$array_drawat_master);
		echo $result;
    }
	
	function master_jual_rawat_batal(){
		$jrawat_nobukti = trim($_POST["jrawat_nobukti"]);
		$jrawat_tanggal=trim(@$_POST["jrawat_tanggal"]);
		$result=$this->m_master_jual_rawat->master_jual_rawat_batal($jrawat_nobukti, $jrawat_tanggal);
		echo $result;
	}

	//function for advanced search
	function master_jual_rawat_search(){
		//POST varibale here
		$jrawat_nobukti=trim(@$_POST["jrawat_nobukti"]);
		$jrawat_nobukti=str_replace("/(<\/?)(p)([^>]*>)", "",$jrawat_nobukti);
		$jrawat_nobukti=str_replace("'", '"',$jrawat_nobukti);
		$jrawat_cust=trim(@$_POST["jrawat_cust"]);
		$jrawat_diskon=trim(@$_POST["jrawat_diskon"]);
		$jrawat_cashback=trim(@$_POST["jrawat_cashback"]);
		$jrawat_voucher=trim(@$_POST["jrawat_voucher"]);
		$jrawat_voucher=str_replace("/(<\/?)(p)([^>]*>)", "",$jrawat_voucher);
		$jrawat_voucher=str_replace("'", '"',$jrawat_voucher);
		$jrawat_cara=trim(@$_POST["jrawat_cara"]);
		$jrawat_cara=str_replace("/(<\/?)(p)([^>]*>)", "",$jrawat_cara);
		$jrawat_cara=str_replace("'", '"',$jrawat_cara);
		$jrawat_bayar=trim(@$_POST["jrawat_bayar"]);
		$jrawat_keterangan=trim(@$_POST["jrawat_keterangan"]);
		$jrawat_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$jrawat_keterangan);
		$jrawat_keterangan=str_replace("'", '"',$jrawat_keterangan);
		$jrawat_stat_dok=trim(@$_POST["jrawat_stat_dok"]);
		$jrawat_stat_dok=str_replace("/(<\/?)(p)([^>]*>)", "",$jrawat_stat_dok);
		$jrawat_stat_dok=str_replace("'", '"',$jrawat_stat_dok);
		
		$jrawat_tgl_start=trim(@$_POST["jrawat_tgl_start"]);
		$jrawat_tgl_end=trim(@$_POST["jrawat_tgl_end"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_master_jual_rawat->master_jual_rawat_search($jrawat_nobukti ,$jrawat_cust ,$jrawat_diskon , $jrawat_stat_dok, $jrawat_cashback ,$jrawat_voucher ,$jrawat_cara ,$jrawat_bayar ,$jrawat_keterangan ,$jrawat_tgl_start ,$jrawat_tgl_end ,$start,$end);
		echo $result;
	}


	function master_jual_rawat_print(){
  		//POST varibale here
		$jrawat_nobukti=trim(@$_POST["jrawat_nobukti"]);
		$jrawat_nobukti=str_replace("/(<\/?)(p)([^>]*>)", "",$jrawat_nobukti);
		$jrawat_nobukti=str_replace("'", '"',$jrawat_nobukti);
		$jrawat_cust=trim(@$_POST["jrawat_cust"]);
		$jrawat_diskon=trim(@$_POST["jrawat_diskon"]);
		$jrawat_cashback=trim(@$_POST["jrawat_cashback"]);
		$jrawat_voucher=trim(@$_POST["jrawat_voucher"]);
		$jrawat_voucher=str_replace("/(<\/?)(p)([^>]*>)", "",$jrawat_voucher);
		$jrawat_voucher=str_replace("'", '"',$jrawat_voucher);
		$jrawat_cara=trim(@$_POST["jrawat_cara"]);
		$jrawat_cara=str_replace("/(<\/?)(p)([^>]*>)", "",$jrawat_cara);
		$jrawat_cara=str_replace("'", '"',$jrawat_cara);
		$jrawat_bayar=trim(@$_POST["jrawat_bayar"]);
		$jrawat_keterangan=trim(@$_POST["jrawat_keterangan"]);
		$jrawat_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$jrawat_keterangan);
		$jrawat_keterangan=str_replace("'", '"',$jrawat_keterangan);
		$jrawat_stat_dok=trim(@$_POST["jrawat_stat_dok"]);
		$jrawat_stat_dok=str_replace("/(<\/?)(p)([^>]*>)", "",$jrawat_stat_dok);
		$jrawat_stat_dok=str_replace("'", '"',$jrawat_stat_dok);
		
		$jrawat_tgl_start=trim(@$_POST["jrawat_tgl_start"]);
		$jrawat_tgl_end=trim(@$_POST["jrawat_tgl_end"]);
		
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$data["data_print"] = $this->m_master_jual_rawat->master_jual_rawat_print($jrawat_nobukti
																				,$jrawat_cust
																				,$jrawat_diskon
																				,$jrawat_stat_dok
																				,$jrawat_cashback
																				,$jrawat_voucher
																				,$jrawat_cara
																				,$jrawat_bayar
																				,$jrawat_keterangan
																				,$jrawat_tgl_start
																				,$jrawat_tgl_end
																				,$option
																				,$filter);
		$print_view=$this->load->view("main/p_master_jual_rawat.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$print_file=fopen("print/master_jual_rawatlist.html","w+");
		fwrite($print_file, $print_view);
		echo '1';
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function master_jual_rawat_export_excel(){
		//POST varibale here
		$jrawat_nobukti=trim(@$_POST["jrawat_nobukti"]);
		$jrawat_nobukti=str_replace("/(<\/?)(p)([^>]*>)", "",$jrawat_nobukti);
		$jrawat_nobukti=str_replace("'", '"',$jrawat_nobukti);
		$jrawat_cust=trim(@$_POST["jrawat_cust"]);
		$jrawat_diskon=trim(@$_POST["jrawat_diskon"]);
		$jrawat_cashback=trim(@$_POST["jrawat_cashback"]);
		$jrawat_voucher=trim(@$_POST["jrawat_voucher"]);
		$jrawat_voucher=str_replace("/(<\/?)(p)([^>]*>)", "",$jrawat_voucher);
		$jrawat_voucher=str_replace("'", '"',$jrawat_voucher);
		$jrawat_cara=trim(@$_POST["jrawat_cara"]);
		$jrawat_cara=str_replace("/(<\/?)(p)([^>]*>)", "",$jrawat_cara);
		$jrawat_cara=str_replace("'", '"',$jrawat_cara);
		$jrawat_bayar=trim(@$_POST["jrawat_bayar"]);
		$jrawat_keterangan=trim(@$_POST["jrawat_keterangan"]);
		$jrawat_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$jrawat_keterangan);
		$jrawat_keterangan=str_replace("'", '"',$jrawat_keterangan);
		$jrawat_stat_dok=trim(@$_POST["jrawat_stat_dok"]);
		$jrawat_stat_dok=str_replace("/(<\/?)(p)([^>]*>)", "",$jrawat_stat_dok);
		$jrawat_stat_dok=str_replace("'", '"',$jrawat_stat_dok);
		
		$jrawat_tgl_start=trim(@$_POST["jrawat_tgl_start"]);
		$jrawat_tgl_end=trim(@$_POST["jrawat_tgl_end"]);
		
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_master_jual_rawat->master_jual_rawat_export_excel($jrawat_nobukti
																			,$jrawat_cust
																			,$jrawat_diskon
																			,$jrawat_stat_dok
																			,$jrawat_cashback
																			,$jrawat_voucher
																			,$jrawat_cara
																			,$jrawat_bayar
																			,$jrawat_keterangan
																			,$jrawat_tgl_start
																			,$jrawat_tgl_end
																			,$option
																			,$filter);
		
		to_excel($query,"master_jual_rawat"); 
		echo '1';
			
	}
	
	function print_paper(){
  		//POST varibale here
		$jrawat_id=trim(@$_POST["jrawat_id"]);
		$jrawat_cust=trim(@$_POST["jrawat_cust"]);
		$jrawat_tanggal=trim(@$_POST["jrawat_tanggal"]);
		
		$result = $this->m_master_jual_rawat->print_paper($jrawat_id);
		$iklan = $this->m_master_jual_rawat->iklan();
		$rs=$result->row();
		$rsiklan=$iklan->row();
		$detail_jrawat=$result->result();
		
		$cara_bayar=$this->m_master_jual_rawat->cara_bayar($jrawat_id);
		$cara_bayar2=$this->m_master_jual_rawat->cara_bayar2($jrawat_id);
		$cara_bayar3=$this->m_master_jual_rawat->cara_bayar3($jrawat_id);
		
		$result_apaket = $this->m_master_jual_rawat->print_paper_apaket_bycust($jrawat_cust, $jrawat_tanggal);
		$detail_apaket=$result_apaket->result();
		
		$data['jrawat_nobukti']=$rs->jrawat_nobukti;
		$data['jrawat_jam']=$rs->jrawat_jam;
		$data['jrawat_tanggal']=date('d-m-Y', strtotime($rs->jrawat_tanggal));
		$data['jrawat_karyawan']=$rs->jrawat_karyawan;
		$data['jrawat_karyawan_no']=$rs->jrawat_karyawan_no;
		$data['cust_no']=$rs->cust_no;
		$data['cust_nama']=$rs->cust_nama;
		$data['cust_alamat']=$rs->cust_alamat;
		$data['jumlah_subtotal']=ubah_rupiah($rs->jumlah_subtotal);
		$data['jumlah_bayar']=$rs->jrawat_bayar;
		$data['jrawat_diskon']=$rs->jrawat_diskon;
		$data['jrawat_cashback']=$rs->jrawat_cashback;
		$data['jrawat_cashback_medis']=$rs->jrawat_cashback_medis;
		$data['jrawat_creator']=$rs->jrawat_creator;
		//$data['jrawat_totalbiaya']=$rs->jrawat_totalbiaya;
		$data['detail_jrawat']=$detail_jrawat;
		$data['detail_apaket']=$detail_apaket;
		$data['iklantoday_keterangan']=$rsiklan->iklantoday_keterangan;
		
		if($cara_bayar!==NULL){
			$data['cara_bayar']=$cara_bayar->jrawat_cara;
			$data['bayar_nilai']=$cara_bayar->bayar_nilai;
		}else{
			$data['cara_bayar']="";
			$data['bayar_nilai']="";
		}
		
		if($cara_bayar2!==NULL){
			$data['cara_bayar2']=$cara_bayar2->jrawat_cara2;
			$data['bayar2_nilai']=$cara_bayar2->bayar2_nilai;
		}else{
			$data['cara_bayar2']="";
			$data['bayar2_nilai']="";
		}
		
		if($cara_bayar3!==NULL){
			$data['cara_bayar3']=$cara_bayar3->jrawat_cara3;
			$data['bayar3_nilai']=$cara_bayar3->bayar3_nilai;
		}else{
			$data['cara_bayar3']="";
			$data['bayar3_nilai']="";
		}
		
		$viewdata=$this->load->view("main/jrawat_formcetak",$data,TRUE);
		$file = fopen("jrawat_paper.html",'w');
		fwrite($file, $viewdata);	
		fclose($file);
		echo '1';        
	}
	
	function print_paper2(){
  		//POST varibale here
		$jrawat_id=trim(@$_POST["jrawat_id"]);
		$jrawat_cust=trim(@$_POST["jrawat_cust"]);
		$jrawat_tanggal=trim(@$_POST["jrawat_tanggal"]);
		$stat_dok=trim(@$_POST["stat_dok"]);
		$kategori_nama=trim(@$_POST["kategori_nama"]);

		$result_medis = $this->m_master_jual_rawat->print_paper_medis($jrawat_id, $jrawat_cust, $jrawat_tanggal);
		$result_nonmedis = $this->m_master_jual_rawat->print_paper_nonmedis($jrawat_id);
		$iklan = $this->m_master_jual_rawat->iklan();
		
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
		$detail_jrawat_medis=$result_medis->result();
		$detail_jrawat_nonmedis=$result_nonmedis->result();
		
		$cara_bayar=$this->m_master_jual_rawat->cara_bayar($jrawat_id);
		$cara_bayar2=$this->m_master_jual_rawat->cara_bayar2($jrawat_id);
		$cara_bayar3=$this->m_master_jual_rawat->cara_bayar3($jrawat_id);
		
		//$result_apaket = $this->m_master_jual_rawat->print_paper_apaket_bycust($jrawat_cust, $jrawat_tanggal);
		//$detail_apaket=$result_apaket->result();
		// PENGAMBILAN PAKET
		$result_apaket_medis = $this->m_master_jual_rawat->print_paper_apaket_bycust_medis($jrawat_cust, $jrawat_tanggal, $jrawat_id, $stat_dok);
		$result_apaket_nonmedis = $this->m_master_jual_rawat->print_paper_apaket_bycust_nonmedis($jrawat_cust, $jrawat_tanggal, $jrawat_id, $stat_dok);
	
		$jum_apaket_medis=$result_apaket_medis->num_rows();
		$data['jum_apaket_medis']=$jum_apaket_medis;
		$jum_apaket_nonmedis=$result_apaket_nonmedis->num_rows();
		$data['jum_apaket_nonmedis']=$jum_apaket_nonmedis;
		
		$detail_apaket_medis=$result_apaket_medis->result();
		$detail_apaket_nonmedis=$result_apaket_nonmedis->result();
		if ($result_apaket_medis->row() != null){	
			$rs_medis_paket=$result_apaket_medis->row();	
		}
		if ($result_apaket_nonmedis->row() != null){
			$rs_nonmedis_paket=$result_apaket_nonmedis->row();		
		}
		// END OF PENGAMBILAN PAKET

		if ($result_medis->row() != null || $result_apaket_medis->row() != null ){
			if ($result_medis->row() != null) {
				$data['jrawat_nobukti']=$rs_medis->jrawat_nobukti;
				$data['jrawat_jam']=$rs_medis->jrawat_jam;
				$data['jrawat_tanggal']=date('d-m-Y', strtotime($rs_medis->jrawat_tanggal));
				$data['cust_no']=$rs_medis->cust_no;
				$data['cust_nama']=$rs_medis->cust_nama;
				$data['cust_alamat']=$rs_medis->cust_alamat;
				$data['jumlah_bayar']=$rs_medis->jrawat_bayar;
				$data['diskon']=$rs_medis->diskon;
				// DATA BEDA
				$data['jrawat_nobukti_medis']=$rs_medis->jrawat_nobukti_medis;
				$data['jumlah_subtotal_medis']=ubah_rupiah($rs_medis->jumlah_subtotal);
				$data['jrawat_cashback']=$rs_medis->jrawat_diskon;
				$data['jrawat_cashback']=$rs_medis->jrawat_cashback_medis;
				$data['pajak']=$rs_medis->pajak;
				$data['uang_muka']=$rs_medis->uang_muka;
			}
			if ($result_apaket_medis->row() != null) {
				$data['jpaket_nobukti']=$rs_medis_paket->jpaket_nobukti;
				$data['paket_nama']=$rs_medis_paket->paket_nama;
				$data['dapaket_tgl_ambil']=date('d-m-Y', strtotime($rs_medis_paket->dapaket_tgl_ambil));
				$data['cust_no']=$rs_medis_paket->cust_no;
				$data['cust_nama']=$rs_medis_paket->cust_nama;
				$data['cust_alamat']=$rs_medis_paket->cust_alamat;
				$data['dapaket_jumlah']=$rs_medis_paket->dapaket_jumlah;
				$data['harga_satuan']=$rs_medis_paket->harga_satuan;
				// DATA BEDA
				$data['jum_paket']=$rs_medis_paket->jum_paket;
				//$data['jumlah_subtotal_nonmedis']=ubah_rupiah($rs_medis_paket->jumlah_subtotal);
				//$data['jrawat_diskon_nonmedis']=$rs_medis_paket->jrawat_diskon;
				$data['dpaket_sisa_paket']=$rs_medis_paket->dpaket_sisa_paket;
				//$data['dpaket_kadaluarsa']=$rs_medis_paket->dpaket_kadaluarsa;
				//$data['pajak']=$rs_medis_paket->pajak;
				//$data['uang_muka']=$rs_medis_paket->uang_muka;
			}
		}
		
		if ($result_nonmedis->row() != null || $result_apaket_nonmedis->row() != null){
			if ($result_nonmedis->row() != null) {
				$data['jrawat_nobukti']=$rs_nonmedis->jrawat_nobukti;
				$data['jrawat_jam']=$rs_nonmedis->jrawat_jam;
				$data['jrawat_tanggal']=date('d-m-Y', strtotime($rs_nonmedis->jrawat_tanggal));
				$data['cust_no']=$rs_nonmedis->cust_no;
				$data['cust_nama']=$rs_nonmedis->cust_nama;
				$data['cust_alamat']=$rs_nonmedis->cust_alamat;
				$data['jumlah_bayar']=$rs_nonmedis->jrawat_bayar;
				$data['diskon']=$rs_nonmedis->diskon;
				// DATA BEDA
				$data['jrawat_nobukti_pajak']=$rs_nonmedis->jrawat_nobukti_pajak;
				$data['jumlah_subtotal_nonmedis']=ubah_rupiah($rs_nonmedis->jumlah_subtotal);
				$data['jrawat_cashback']=$rs_nonmedis->jrawat_diskon;
				$data['jrawat_cashback']=$rs_nonmedis->jrawat_cashback;
				$data['pajak']=$rs_nonmedis->pajak;
				$data['uang_muka']=$rs_nonmedis->uang_muka;
			}
			if ($result_apaket_nonmedis->row() != null) {
				$data['jpaket_nobukti']=$rs_nonmedis_paket->jpaket_nobukti;
				//$data['jrawat_jam']=$rs_nonmedis_paket->jrawat_jam;
				$data['jrawat_tanggal']=date('d-m-Y', strtotime($rs_nonmedis_paket->dapaket_tgl_ambil));
				$data['cust_no']=$rs_nonmedis_paket->cust_no;
				$data['cust_nama']=$rs_nonmedis_paket->cust_nama;
				$data['cust_alamat']=$rs_nonmedis_paket->cust_alamat;
				//$data['jumlah_bayar']=$rs_nonmedis_paket->jrawat_bayar;
				//$data['diskon']=$rs_nonmedis_paket->diskon;
				// DATA BEDA
				$data['jrawat_nobukti_pajak']=$rs_nonmedis_paket->dapaket_nobukti_pajak;
				//$data['jumlah_subtotal_nonmedis']=ubah_rupiah($rs_nonmedis_paket->jumlah_subtotal);
				//$data['jrawat_diskon_nonmedis']=$rs_nonmedis_paket->jrawat_diskon;
				//$data['jrawat_cashback_nonmedis']=$rs_nonmedis_paket->jrawat_cashback;
				//$data['pajak']=$rs_nonmedis_paket->pajak;
				//$data['uang_muka']=$rs_nonmedis_paket->uang_muka;
			}
			
		}
		
		//$data['jrawat_creator']=$rs->jrawat_creator;
		//$data['jrawat_totalbiaya']=$rs->jrawat_totalbiaya;

		$data['detail_jrawat_medis']=$detail_jrawat_medis;
		$data['detail_jrawat_nonmedis']=$detail_jrawat_nonmedis; //IKI YO DIKIRIM JEK.. 
		//$data['detail_apaket']=$detail_apaket;
		$data['detail_apaket_medis']=$detail_apaket_medis;
		$data['detail_apaket_nonmedis']=$detail_apaket_nonmedis;  // INI DIKIRIM SEMUA KE FORMCETAK2
		$data['iklantoday_keterangan']=$rsiklan->iklantoday_keterangan;
		
		if($cara_bayar!==NULL){
			$data['cara_bayar']=$cara_bayar->jrawat_cara;
			$data['bayar_nilai']=$cara_bayar->bayar_nilai;
		}else{
			$data['cara_bayar']="";
			$data['bayar_nilai']="";
		}
		
		if($cara_bayar2!==NULL){
			$data['cara_bayar2']=$cara_bayar2->jrawat_cara2;
			$data['bayar2_nilai']=$cara_bayar2->bayar2_nilai;
		}else{
			$data['cara_bayar2']="";
			$data['bayar2_nilai']="";
		}
		
		if($cara_bayar3!==NULL){
			$data['cara_bayar3']=$cara_bayar3->jrawat_cara3;
			$data['bayar3_nilai']=$cara_bayar3->bayar3_nilai;
		}else{
			$data['cara_bayar3']="";
			$data['bayar3_nilai']="";
		}
		
		$viewdata=$this->load->view("main/jrawat_formcetak2",$data,TRUE);
		$file = fopen("jrawat_paper2.html",'w');
		fwrite($file, $viewdata);	
		fclose($file);
		echo '1';        
	}
	
	function print_only(){
  		//POST varibale here
		$jrawat_id=trim(@$_POST["jrawat_id"]);
		$jrawat_cust=trim(@$_POST["jrawat_cust"]);
		$jrawat_tanggal=trim(@$_POST["jrawat_tanggal"]);
		
		$result = $this->m_master_jual_rawat->print_paper($jrawat_id);
		$iklan = $this->m_master_jual_rawat->iklan();
		$rs=$result->row();
		$rsiklan=$iklan->row();
		$detail_jrawat=$result->result();
		
		$cara_bayar=$this->m_master_jual_rawat->cara_bayar($jrawat_id);
		$cara_bayar2=$this->m_master_jual_rawat->cara_bayar2($jrawat_id);
		$cara_bayar3=$this->m_master_jual_rawat->cara_bayar3($jrawat_id);
		
		$result_apaket = $this->m_master_jual_rawat->print_paper_apaket_bycust($jrawat_cust, $jrawat_tanggal);
		$detail_apaket=$result_apaket->result();
		
		$data['jrawat_nobukti']=$rs->jrawat_nobukti;
		$data['jrawat_jam']=$rs->jrawat_jam;
		$data['jrawat_tanggal']=date('d-m-Y', strtotime($rs->jrawat_tanggal));
		$data['cust_no']=$rs->cust_no;
		$data['cust_nama']=$rs->cust_nama;
		$data['cust_alamat']=$rs->cust_alamat;
		$data['jumlah_subtotal']=ubah_rupiah($rs->jumlah_subtotal);
		$data['jumlah_bayar']=$rs->jrawat_bayar;
		$data['jrawat_diskon']=$rs->jrawat_diskon;
		$data['jrawat_cashback']=$rs->jrawat_cashback;
		$data['jrawat_cashback_medis']=$rs->jrawat_cashback_medis;
		$data['jrawat_creator']=$rs->jrawat_creator;
		$data['detail_jrawat']=$detail_jrawat;
		$data['detail_apaket']=$detail_apaket;
		$data['iklantoday_keterangan']=$rsiklan->iklantoday_keterangan;
		
		if($cara_bayar!==NULL){
			$data['cara_bayar']=$cara_bayar->jrawat_cara;
			$data['bayar_nilai']=$cara_bayar->bayar_nilai;
		}else{
			$data['cara_bayar']="";
			$data['bayar_nilai']="";
		}
		
		if($cara_bayar2!==NULL){
			$data['cara_bayar2']=$cara_bayar2->jrawat_cara2;
			$data['bayar2_nilai']=$cara_bayar2->bayar2_nilai;
		}else{
			$data['cara_bayar2']="";
			$data['bayar2_nilai']="";
		}
		
		if($cara_bayar3!==NULL){
			$data['cara_bayar3']=$cara_bayar3->jrawat_cara3;
			$data['bayar3_nilai']=$cara_bayar3->bayar3_nilai;
		}else{
			$data['cara_bayar3']="";
			$data['bayar3_nilai']="";
		}
		
		$viewdata=$this->load->view("main/jrawat_formcetak_printonly",$data,TRUE);
		$file = fopen("jrawat_paper.html",'w');
		fwrite($file, $viewdata);	
		fclose($file);
		echo '1';        
	}
	
	function print_only2(){
  		//POST varibale here
		$jrawat_id=trim(@$_POST["jrawat_id"]);
		$jrawat_cust=trim(@$_POST["jrawat_cust"]);
		$jrawat_tanggal=trim(@$_POST["jrawat_tanggal"]);
		$stat_dok=trim(@$_POST["stat_dok"]);
		$kategori_nama=trim(@$_POST["kategori_nama"]);

		$result_medis = $this->m_master_jual_rawat->print_paper_medis($jrawat_id, $jrawat_cust, $jrawat_tanggal);
		$result_nonmedis = $this->m_master_jual_rawat->print_paper_nonmedis($jrawat_id);
		$iklan = $this->m_master_jual_rawat->iklan();
		
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
		$detail_jrawat_medis=$result_medis->result();
		$detail_jrawat_nonmedis=$result_nonmedis->result();
		
		$cara_bayar=$this->m_master_jual_rawat->cara_bayar($jrawat_id);
		$cara_bayar2=$this->m_master_jual_rawat->cara_bayar2($jrawat_id);
		$cara_bayar3=$this->m_master_jual_rawat->cara_bayar3($jrawat_id);
		
		//$result_apaket = $this->m_master_jual_rawat->print_paper_apaket_bycust($jrawat_cust, $jrawat_tanggal);
		//$detail_apaket=$result_apaket->result();
		// PENGAMBILAN PAKET
		$result_apaket_medis = $this->m_master_jual_rawat->print_paper_apaket_bycust_medis($jrawat_cust, $jrawat_tanggal, $jrawat_id, $stat_dok);
		$result_apaket_nonmedis = $this->m_master_jual_rawat->print_paper_apaket_bycust_nonmedis($jrawat_cust, $jrawat_tanggal, $jrawat_id, $stat_dok);
	
		$jum_apaket_medis=$result_apaket_medis->num_rows();
		$data['jum_apaket_medis']=$jum_apaket_medis;
		$jum_apaket_nonmedis=$result_apaket_nonmedis->num_rows();
		$data['jum_apaket_nonmedis']=$jum_apaket_nonmedis;
		
		$detail_apaket_medis=$result_apaket_medis->result();
		$detail_apaket_nonmedis=$result_apaket_nonmedis->result();
		if ($result_apaket_medis->row() != null){	
			$rs_medis_paket=$result_apaket_medis->row();	
		}
		if ($result_apaket_nonmedis->row() != null){
			$rs_nonmedis_paket=$result_apaket_nonmedis->row();		
		}
		// END OF PENGAMBILAN PAKET

		if ($result_medis->row() != null || $result_apaket_medis->row() != null ){
			if ($result_medis->row() != null) {
				$data['jrawat_nobukti']=$rs_medis->jrawat_nobukti;
				$data['jrawat_jam']=$rs_medis->jrawat_jam;
				$data['jrawat_tanggal']=date('d-m-Y', strtotime($rs_medis->jrawat_tanggal));
				$data['cust_no']=$rs_medis->cust_no;
				$data['cust_nama']=$rs_medis->cust_nama;
				$data['cust_alamat']=$rs_medis->cust_alamat;
				$data['jumlah_bayar']=$rs_medis->jrawat_bayar;
				$data['diskon']=$rs_medis->diskon;
				// DATA BEDA
				$data['jrawat_nobukti_medis']=$rs_medis->jrawat_nobukti_medis;
				$data['jumlah_subtotal_medis']=ubah_rupiah($rs_medis->jumlah_subtotal);
				$data['jrawat_cashback']=$rs_medis->jrawat_diskon;
				$data['jrawat_cashback']=$rs_medis->jrawat_cashback_medis;
				$data['pajak']=$rs_medis->pajak;
				$data['uang_muka']=$rs_medis->uang_muka;
			}
			if ($result_apaket_medis->row() != null) {
				$data['jpaket_nobukti']=$rs_medis_paket->jpaket_nobukti;
				$data['paket_nama']=$rs_medis_paket->paket_nama;
				$data['dapaket_tgl_ambil']=date('d-m-Y', strtotime($rs_medis_paket->dapaket_tgl_ambil));
				$data['cust_no']=$rs_medis_paket->cust_no;
				$data['cust_nama']=$rs_medis_paket->cust_nama;
				$data['cust_alamat']=$rs_medis_paket->cust_alamat;
				$data['dapaket_jumlah']=$rs_medis_paket->dapaket_jumlah;
				$data['harga_satuan']=$rs_medis_paket->harga_satuan;
				// DATA BEDA
				$data['jum_paket']=$rs_medis_paket->jum_paket;
				//$data['jumlah_subtotal_nonmedis']=ubah_rupiah($rs_medis_paket->jumlah_subtotal);
				//$data['jrawat_diskon_nonmedis']=$rs_medis_paket->jrawat_diskon;
				$data['dpaket_sisa_paket']=$rs_medis_paket->dpaket_sisa_paket;
				//$data['dpaket_kadaluarsa']=$rs_medis_paket->dpaket_kadaluarsa;
				//$data['pajak']=$rs_medis_paket->pajak;
				//$data['uang_muka']=$rs_medis_paket->uang_muka;
			}
		}
		
		if ($result_nonmedis->row() != null || $result_apaket_nonmedis->row() != null){
			if ($result_nonmedis->row() != null) {
				$data['jrawat_nobukti']=$rs_nonmedis->jrawat_nobukti;
				$data['jrawat_jam']=$rs_nonmedis->jrawat_jam;
				$data['jrawat_tanggal']=date('d-m-Y', strtotime($rs_nonmedis->jrawat_tanggal));
				$data['cust_no']=$rs_nonmedis->cust_no;
				$data['cust_nama']=$rs_nonmedis->cust_nama;
				$data['cust_alamat']=$rs_nonmedis->cust_alamat;
				$data['jumlah_bayar']=$rs_nonmedis->jrawat_bayar;
				$data['diskon']=$rs_nonmedis->diskon;
				// DATA BEDA
				$data['jrawat_nobukti_pajak']=$rs_nonmedis->jrawat_nobukti_pajak;
				$data['jumlah_subtotal_nonmedis']=ubah_rupiah($rs_nonmedis->jumlah_subtotal);
				$data['jrawat_cashback']=$rs_nonmedis->jrawat_diskon;
				$data['jrawat_cashback']=$rs_nonmedis->jrawat_cashback;
				$data['pajak']=$rs_nonmedis->pajak;
				$data['uang_muka']=$rs_nonmedis->uang_muka;
			}
			if ($result_apaket_nonmedis->row() != null) {
				$data['jrawat_nobukti']=$rs_nonmedis_paket->jpaket_nobukti;
				//$data['jrawat_jam']=$rs_nonmedis_paket->jrawat_jam;
				$data['jrawat_tanggal']=date('d-m-Y', strtotime($rs_nonmedis_paket->dapaket_tgl_ambil));
				$data['cust_no']=$rs_nonmedis_paket->cust_no;
				$data['cust_nama']=$rs_nonmedis_paket->cust_nama;
				$data['cust_alamat']=$rs_nonmedis_paket->cust_alamat;
				//$data['jumlah_bayar']=$rs_nonmedis_paket->jrawat_bayar;
				$data['diskon']=$rs_nonmedis_paket->diskon;
				// DATA BEDA
				$data['jrawat_nobukti_pajak']=$rs_nonmedis_paket->dapaket_nobukti_pajak;
				//$data['jumlah_subtotal_nonmedis']=ubah_rupiah($rs_nonmedis_paket->jumlah_subtotal);
				//$data['jrawat_diskon_nonmedis']=$rs_nonmedis_paket->jrawat_diskon;
				//$data['jrawat_cashback_nonmedis']=$rs_nonmedis_paket->jrawat_cashback;
				//$data['pajak']=$rs_nonmedis_paket->pajak;
				//$data['uang_muka']=$rs_nonmedis_paket->uang_muka;
			}
			
		}
		
		//$data['jrawat_creator']=$rs->jrawat_creator;
		//$data['jrawat_totalbiaya']=$rs->jrawat_totalbiaya;

		$data['detail_jrawat_medis']=$detail_jrawat_medis;
		$data['detail_jrawat_nonmedis']=$detail_jrawat_nonmedis; //IKI YO DIKIRIM JEK.. 
		//$data['detail_apaket']=$detail_apaket;
		$data['detail_apaket_medis']=$detail_apaket_medis;
		$data['detail_apaket_nonmedis']=$detail_apaket_nonmedis;  // INI DIKIRIM SEMUA KE FORMCETAK2
		$data['iklantoday_keterangan']=$rsiklan->iklantoday_keterangan;
		
		if($cara_bayar!==NULL){
			$data['cara_bayar']=$cara_bayar->jrawat_cara;
			$data['bayar_nilai']=$cara_bayar->bayar_nilai;
		}else{
			$data['cara_bayar']="";
			$data['bayar_nilai']="";
		}
		
		if($cara_bayar2!==NULL){
			$data['cara_bayar2']=$cara_bayar2->jrawat_cara2;
			$data['bayar2_nilai']=$cara_bayar2->bayar2_nilai;
		}else{
			$data['cara_bayar2']="";
			$data['bayar2_nilai']="";
		}
		
		if($cara_bayar3!==NULL){
			$data['cara_bayar3']=$cara_bayar3->jrawat_cara3;
			$data['bayar3_nilai']=$cara_bayar3->bayar3_nilai;
		}else{
			$data['cara_bayar3']="";
			$data['bayar3_nilai']="";
		}
		
		$viewdata=$this->load->view("main/jrawat_formcetak2_printonly",$data,TRUE);
		$file = fopen("jrawat_paper2.html",'w');
		fwrite($file, $viewdata);	
		fclose($file);
		echo '1';        
	}
	
	function print_paper_apaket(){
		//$dapaket_jpaket=trim(@$_POST["jrawat_id"]);
		//$dapaket_dpaket=trim(@$_POST["dpaket_id"]);
		//$dapaket_date_create=trim(@$_POST["jrawat_tanggal"]);
		$dapaket_cust=trim(@$_POST["dapaket_cust"]);
		$dapaket_date_create=trim(@$_POST["tanggal"]);
		
		//$result = $this->m_master_jual_rawat->print_paper_apaket($dapaket_jpaket, $dapaket_cust, $dapaket_date_create);
		//$result = $this->m_master_jual_rawat->print_paper_apaket($dapaket_jpaket, $dapaket_dpaket, $dapaket_date_create);
		$result = $this->m_master_jual_rawat->print_paper_apaket($dapaket_cust ,$dapaket_date_create);
		$rs=$result->row();
		$detail_ambil_paket=$result->result();
		
		$data['dapaket_tanggal']=$rs->dapaket_tgl_ambil;
		//$data['cust_no']=$rs->cust_no;
		//$data['cust_nama']=$rs->cust_nama;
		//$data['cust_alamat']=$rs->cust_alamat;
		$data['jpaket_cust_no']=$rs->jpaket_cust_no;
		$data['jpaket_cust_nama']=$rs->jpaket_cust_nama;
		$data['jpaket_cust_alamat']=$rs->jpaket_cust_alamat;
		//$data['jpaket_nobukti']=$rs->jpaket_nobukti;
		$data['detail_ambil_paket']=$detail_ambil_paket;
		
		$viewdata=$this->load->view("main/apaket_formcetak",$data,TRUE);
		$file = fopen("apaket_paper.html",'w');
		fwrite($file, $viewdata);	
		fclose($file);
		echo '1'; 
	}
	
	function print_paper_apaket2(){
		$dapaket_cust=trim(@$_POST["dapaket_cust"]);
		$dapaket_date_create=trim(@$_POST["tanggal"]);
		$jrawat_nobukti_pajak=trim(@$_POST["jrawat_nobukti_pajak"]);
		$jrawat_nobukti_medis=trim(@$_POST["jrawat_nobukti_medis"]);
		
		$result_medis = $this->m_master_jual_rawat->print_paper_apaket_medis($dapaket_cust ,$dapaket_date_create, $jrawat_nobukti_medis);
		$result_nonmedis = $this->m_master_jual_rawat->print_paper_apaket_nonmedis($dapaket_cust ,$dapaket_date_create, $jrawat_nobukti_pajak);
		
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
		
		$detail_medis=$result_medis->result();
		$detail_nonmedis=$result_nonmedis->result();
		
		if ($result_medis->row() != null){
			$data['dapaket_tanggal']=$rs_medis->dapaket_tgl_ambil;
			$data['jpaket_cust_no']=$rs_medis->cust_no;
			$data['jpaket_cust_nama']=$rs_medis->cust_nama;
			$data['jpaket_cust_alamat']=$rs_medis->cust_alamat;
		}
		if ($result_nonmedis->row() != null){
			$data['dapaket_tanggal']=$rs_nonmedis->dapaket_tgl_ambil;
			$data['jpaket_cust_no']=$rs_nonmedis->cust_no;
			$data['jpaket_cust_nama']=$rs_nonmedis->cust_nama;
			$data['jpaket_cust_alamat']=$rs_nonmedis->cust_alamat;
			$data['dapaket_nobukti_pajak']=$rs_nonmedis->dapaket_nobukti_pajak;
		}
		//$data['dapaket_tanggal']=$rs->dapaket_tgl_ambil;
		//$data['cust_no']=$rs->cust_no;
		//$data['cust_nama']=$rs->cust_nama;
		//$data['cust_alamat']=$rs->cust_alamat;
		//$data['jpaket_cust_no']=$rs->jpaket_cust_no;
		//$data['jpaket_cust_nama']=$rs->jpaket_cust_nama;
		//$data['jpaket_cust_alamat']=$rs->jpaket_cust_alamat;
		//$data['jpaket_nobukti']=$rs->jpaket_nobukti;
		//$data['detail_ambil_paket']=$detail_ambil_paket;
		
		$data['detail_ambil_paket_medis']=$detail_medis;
		$data['detail_ambil_paket_nonmedis']=$detail_nonmedis;
		
		$viewdata=$this->load->view("main/apaket_formcetak2",$data,TRUE);
		$file = fopen("apaket_paper2.html",'w');
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