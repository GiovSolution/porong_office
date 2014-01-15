<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: cetak_kwitansi Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_cetak_kwitansi.php
 	+ Author  		: masongbee
 	+ Created on 26/Jan/2010 12:21:55
	
*/

//class of cetak_kwitansi
class C_cetak_kwitansi extends Controller {

	//constructor
	function C_cetak_kwitansi(){
		parent::Controller();
		session_start();
		$this->load->model('m_cetak_kwitansi', '', TRUE);
		$this->load->plugin('to_excel');
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_cetak_kwitansi');
	}
	
	function laporan(){
		$this->load->view('main/v_lap_kuitansi');
	}
	
	function print_laporan(){
		$tgl_awal=(isset($_POST['tgl_awal']) ? @$_POST['tgl_awal'] : @$_GET['tgl_awal']);
		$tgl_akhir=(isset($_POST['tgl_akhir']) ? @$_POST['tgl_akhir'] : @$_GET['tgl_akhir']);
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		$opsi=(isset($_POST['opsi']) ? @$_POST['opsi'] : @$_GET['opsi']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		$group=(isset($_POST['group']) ? @$_POST['group'] : @$_GET['group']);
		
		if($periode=="all"){
			$data["periode"]="Semua Periode";
		}else if($periode=="bulan"){
			$tgl_awal=$tahun."-".$bulan;
			if($group=="Sisa Kuitansi (Akumulatif)"){
				$data["periode"]="Periode : Awal s/d ".get_ina_month_name($bulan,'long')." ".$tahun; 
				$data["jenis"]='Sisa Kuitansi (Akumulatif)';
			} else {
				$data["periode"]=get_ina_month_name($bulan,'long')." ".$tahun;
				$data["jenis"]='No. Kuitansi';
			}
		}else if($periode=="tanggal"){
			$date = substr($tgl_awal,8,2);
			$month = substr($tgl_awal,5,2);
			$year = substr($tgl_awal,0,4);
			$tgl_awal_show = $date.'-'.$month.'-'.$year;
			
			$date_akhir = substr($tgl_akhir,8,2);
			$month_akhir = substr($tgl_akhir,5,2);
			$year_akhir = substr($tgl_akhir,0,4);
			$tgl_akhir_show = $date_akhir.'-'.$month_akhir.'-'.$year_akhir;
			
			if($group=="Sisa Kuitansi (Akumulatif)"){
				$data["periode"]="Periode : Awal s/d ".$tgl_akhir_show."";
				$data["jenis"]='Sisa Kuitansi (Akumulatif)';
			} else {
				$data["periode"]="Periode : ".$tgl_awal_show." s/d ".$tgl_akhir_show.", ";
				$data["jenis"]='No. Kuitansi';
			}
		}
		
		
		$data["data_print"]=$this->m_cetak_kwitansi->get_laporan($tgl_awal,$tgl_akhir,$periode,$opsi,$group,$bulan,$tahun);
		
		if(!file_exists("print")){
			mkdir("print");
		}
		
		if($opsi=='rekap'){
			
			switch($group){
				case "Tanggal": $print_view=$this->load->view("main/p_rekap_kuitansi_tanggal.php",$data,TRUE);break;
				case "Customer": $print_view=$this->load->view("main/p_rekap_kuitansi_customer.php",$data,TRUE);break;
				case "Sisa Kuitansi (Akumulatif)": $print_view=$this->load->view("main/p_rekap_kuitansi.php",$data,TRUE);break;
				default: $print_view=$this->load->view("main/p_rekap_kuitansi.php",$data,TRUE);break;
			}
			$print_file=fopen("print/report_kuitansi.html","w");
			
		}else{
			switch($group){
				case "Tanggal": $print_view=$this->load->view("main/p_detail_kuitansi_tanggal.php",$data,TRUE);break;
				case "Tanggal (Adjustment)": $print_view=$this->load->view("main/p_detail_kuitansi_tanggal_adj.php",$data,TRUE);break;
				case "Customer": $print_view=$this->load->view("main/p_detail_kuitansi_customer.php",$data,TRUE);break;
				case "No Faktur": $print_view=$this->load->view("main/p_detail_kuitansi_faktur.php",$data,TRUE);break;
				default: $print_view=$this->load->view("main/p_detail_kuitansi.php",$data,TRUE);break;
			}
			$print_file=fopen("print/report_kuitansi.html","w");

		}
		
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
	
	function get_customer_kwitansi_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_cetak_kwitansi->get_customer_kwitansi_list($query,$start,$end);
		echo $result;
	}
	
	function get_cek_by_ref(){
		$ref_id = (isset($_POST['no_faktur']) ? $_POST['no_faktur'] : $_GET['no_faktur']);
		$cara_bayar_ke = 1;
		$result = $this->m_public_function->get_cek_by_ref($ref_id ,$cara_bayar_ke);
		echo $result;
	}
	
	function get_card_by_ref(){
		$ref_id = (isset($_POST['no_faktur']) ? $_POST['no_faktur'] : $_GET['no_faktur']);
		$cara_bayar_ke = 1;
		$result = $this->m_public_function->get_card_by_ref($ref_id ,$cara_bayar_ke);
		echo $result;
	}
	
	function get_transfer_by_ref(){
		$ref_id = (isset($_POST['no_faktur']) ? $_POST['no_faktur'] : $_GET['no_faktur']);
		$cara_bayar_ke = 1;
		$result = $this->m_public_function->get_transfer_by_ref($ref_id ,$cara_bayar_ke);
		echo $result;
	}
	
	function get_tunai_by_ref(){
		$ref_id = (isset($_POST['no_faktur']) ? $_POST['no_faktur'] : $_GET['no_faktur']);
		$cara_bayar_ke = 1;
		$result = $this->m_public_function->get_tunai_by_ref($ref_id ,$cara_bayar_ke);
		echo $result;
	}
	
	//for detail action
	//list detail handler action
	function  detail_jual_kwitansi_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_cetak_kwitansi->detail_jual_kwitansi_list($master_id,$query,$start,$end);
		echo $result;
	}
	//end of handler
	
	//purge all detail
	function detail_jual_kwitansi_purge(){
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_cetak_kwitansi->detail_jual_kwitansi_purge($master_id);
	}
	//eof
	
	//get master id, note: not done yet
	function get_master_id(){
		$result=$this->m_cetak_kwitansi->get_master_id();
		echo $result;
	}
	//
	
	//add detail
	function detail_jual_kwitansi_insert(){
	//POST variable here
		$jkwitansi_id=trim(@$_POST["jkwitansi_id"]);
		$jkwitansi_master=trim(@$_POST["jkwitansi_master"]);
		$jkwitansi_no=trim(@$_POST["jkwitansi_no"]);
		$jkwitansi_no=str_replace("/(<\/?)(p)([^>]*>)", "",$jkwitansi_no);
		$jkwitansi_no=str_replace("\\", "",$jkwitansi_no);
		$jkwitansi_no=str_replace("'", "''",$jkwitansi_no);
		$jkwitansi_nilai=trim(@$_POST["jkwitansi_nilai"]);
		$jkwitansi_ref=trim(@$_POST["jkwitansi_ref"]);
		$jkwitansi_ref=str_replace("/(<\/?)(p)([^>]*>)", "",$jkwitansi_ref);
		$jkwitansi_ref=str_replace("\\", "",$jkwitansi_ref);
		$jkwitansi_ref=str_replace("'", "''",$jkwitansi_ref);
		$jkwitansi_creator=trim(@$_POST["jkwitansi_creator"]);
		$jkwitansi_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$jkwitansi_creator);
		$jkwitansi_creator=str_replace("\\", "",$jkwitansi_creator);
		$jkwitansi_creator=str_replace("'", "''",$jkwitansi_creator);
		$jkwitansi_date_create=trim(@$_POST["jkwitansi_date_create"]);
		$jkwitansi_update=trim(@$_POST["jkwitansi_update"]);
		$jkwitansi_update=str_replace("/(<\/?)(p)([^>]*>)", "",$jkwitansi_update);
		$jkwitansi_update=str_replace("\\", "",$jkwitansi_update);
		$jkwitansi_update=str_replace("'", "''",$jkwitansi_update);
		$jkwitansi_date_update=trim(@$_POST["jkwitansi_date_update"]);
		$jkwitansi_revised=trim(@$_POST["jkwitansi_revised"]);
		$result=$this->m_cetak_kwitansi->detail_jual_kwitansi_insert($jkwitansi_id ,$jkwitansi_master ,$jkwitansi_no ,$jkwitansi_nilai ,$jkwitansi_ref ,$jkwitansi_creator ,$jkwitansi_date_create ,$jkwitansi_update ,$jkwitansi_date_update ,$jkwitansi_revised );
	}
	
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->cetak_kwitansi_list();
				break;
			case "UPDATE":
				$this->cetak_kwitansi_update();
				break;
			case "BATAL":
				$this->cetak_kwitansi_batal();
				break;
			case "CREATE":
				$this->cetak_kwitansi_create();
				break;
			case "CEK":
				$this->cetak_kwitansi_pengecekan();
				break;
			case "ADJ":
				$this->kuitansi_status_adj();
				break;
			case "DELETE":
				$this->cetak_kwitansi_delete();
				break;
			case "SEARCH":
				$this->cetak_kwitansi_search();
				break;
			case "PRINT":
				$this->cetak_kwitansi_print();
				break;
			case "EXCEL":
				$this->cetak_kwitansi_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function cetak_kwitansi_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_cetak_kwitansi->cetak_kwitansi_list($query,$start,$end);
		echo $result;
	}

	
	function cetak_kwitansi_pengecekan(){
	
		$tanggal_pengecekan=trim(@$_POST["tanggal_pengecekan"]);
	
		$result=$this->m_public_function->pengecekan_dokumen($tanggal_pengecekan);
		echo $result;
	}
	
	function kuitansi_status_adj(){
	
		//$tanggal_pengecekan=trim(@$_POST["tgl_ambil"]);
		$kwitansi_id=trim(@$_POST["kwitansi_id"]);
		$adj_kwitansi_nilai=trim(@$_POST["adj_kwitansi_nilai"]);
		$adj_kwitansi_ket=trim(@$_POST["adj_kwitansi_ket"]);
		$adj_kwitansi_ket=str_replace("/(<\/?)(p)([^>]*>)", "",$adj_kwitansi_ket);
		$adj_kwitansi_ket=str_replace("'", "''",$adj_kwitansi_ket);
		//$tanggal_pengecekan = json_decode(stripslashes($tanggal_pengecekan));
	
		$result=$this->m_cetak_kwitansi->kuitansi_status_adj($kwitansi_id,$adj_kwitansi_nilai, $adj_kwitansi_ket);
		echo $result;
	}
	
	//function for update record
	function cetak_kwitansi_update(){
		//POST variable here
		$kwitansi_id=trim(@$_POST["kwitansi_id"]);
		$kwitansi_no=trim(@$_POST["kwitansi_no"]);
		$kwitansi_no=str_replace("/(<\/?)(p)([^>]*>)", "",$kwitansi_no);
		$kwitansi_cust=trim(@$_POST["kwitansi_cust"]);
		$kwitansi_tanggal=trim(@$_POST["kwitansi_tanggal"]);
		$kwitansi_ref=trim(@$_POST["kwitansi_ref"]);
		$kwitansi_nilai=trim(@$_POST["kwitansi_nilai"]);
		$kwitansi_keterangan=trim(@$_POST["kwitansi_keterangan"]);
		$kwitansi_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$kwitansi_keterangan);
		$kwitansi_keterangan=str_replace("'", "''",$kwitansi_keterangan);
		$kwitansi_status=trim(@$_POST["kwitansi_status"]);
		$kwitansi_status=str_replace("/(<\/?)(p)([^>]*>)", "",$kwitansi_status);
		
		$kwitansi_cara=trim(@$_POST["kwitansi_cara"]);
		$kwitansi_cara=str_replace("/(<\/?)(p)([^>]*>)", "",$kwitansi_cara);
		
		$kwitansi_bayar=trim(@$_POST["kwitansi_bayar"]);
		
		$kwitansi_tunai_nilai=trim($_POST["kwitansi_tunai_nilai"]);
		
		$kwitansi_card_nama=trim($_POST["kwitansi_card_nama"]);
		$kwitansi_card_edc=trim($_POST["kwitansi_card_edc"]);
		$kwitansi_card_no=trim($_POST["kwitansi_card_no"]);
		$kwitansi_card_nilai=trim($_POST["kwitansi_card_nilai"]);
		
		$kwitansi_cek_nama=trim($_POST["kwitansi_cek_nama"]);
		$kwitansi_cek_no=trim($_POST["kwitansi_cek_no"]);
		$kwitansi_cek_valid=trim($_POST["kwitansi_cek_valid"]);
		$kwitansi_cek_bank=trim($_POST["kwitansi_cek_bank"]);
		$kwitansi_cek_nilai=trim($_POST["kwitansi_cek_nilai"]);
		
		$kwitansi_transfer_bank=trim($_POST["kwitansi_transfer_bank"]);
		$kwitansi_transfer_nama=trim($_POST["kwitansi_transfer_nama"]);
		$kwitansi_transfer_nilai=trim($_POST["kwitansi_transfer_nilai"]);
		
		$cetak = trim($_POST["cetak"]);
		
		$kwitansi_update=$_SESSION[SESSION_USERID];
		$result = $this->m_cetak_kwitansi->cetak_kwitansi_update($kwitansi_id ,$kwitansi_no ,$kwitansi_cust ,$kwitansi_tanggal, $kwitansi_ref ,$kwitansi_nilai ,$kwitansi_keterangan ,$kwitansi_status ,$kwitansi_cara ,$kwitansi_bayar ,$kwitansi_tunai_nilai ,$kwitansi_card_nama ,$kwitansi_card_edc ,$kwitansi_card_no ,$kwitansi_card_nilai ,$kwitansi_cek_nama ,$kwitansi_cek_no ,$kwitansi_cek_valid ,$kwitansi_cek_bank ,$kwitansi_cek_nilai ,$kwitansi_transfer_bank ,$kwitansi_transfer_nama ,$kwitansi_transfer_nilai ,$kwitansi_update ,$cetak );
		echo $result;
	}
	
	function cetak_kwitansi_batal(){
		//POST variable here
		$kwitansi_id=trim(@$_POST["kwitansi_id"]);
		$kwitansi_status=trim(@$_POST["kwitansi_status"]);
		$kwitansi_status=str_replace("/(<\/?)(p)([^>]*>)", "",$kwitansi_status);
		
		$kwitansi_update=$_SESSION[SESSION_USERID];
		$result = $this->m_cetak_kwitansi->cetak_kwitansi_batal($kwitansi_id ,$kwitansi_status ,$kwitansi_update );
		echo $result;
	}
	
	//function for create new record
	function cetak_kwitansi_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$kwitansi_no=trim(@$_POST["kwitansi_no"]);
		$kwitansi_no=str_replace("/(<\/?)(p)([^>]*>)", "",$kwitansi_no);
		$kwitansi_no=str_replace("'", "''",$kwitansi_no);
		$kwitansi_cust=trim(@$_POST["kwitansi_cust"]);
		$kwitansi_tanggal=trim(@$_POST["kwitansi_tanggal"]);
		$kwitansi_ref=trim(@$_POST["kwitansi_ref"]);
		$kwitansi_nilai=trim(@$_POST["kwitansi_nilai"]);
		$kwitansi_keterangan=trim(@$_POST["kwitansi_keterangan"]);
		$kwitansi_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$kwitansi_keterangan);
		$kwitansi_keterangan=str_replace("'", "''",$kwitansi_keterangan);
		$kwitansi_status=trim(@$_POST["kwitansi_status"]);
		$kwitansi_status=str_replace("/(<\/?)(p)([^>]*>)", "",$kwitansi_status);
		$kwitansi_status=str_replace("'", "''",$kwitansi_status);
		
		$kwitansi_cara=trim(@$_POST["kwitansi_cara"]);
		$kwitansi_cara=str_replace("/(<\/?)(p)([^>]*>)", "",$kwitansi_cara);
		$kwitansi_cara=str_replace("'", '"',$kwitansi_cara);
		
		$kwitansi_bayar=trim(@$_POST["kwitansi_bayar"]);
		
		$kwitansi_tunai_nilai=trim($_POST["kwitansi_tunai_nilai"]);
		
		$kwitansi_card_nama=trim($_POST["kwitansi_card_nama"]);
		$kwitansi_card_edc=trim($_POST["kwitansi_card_edc"]);
		$kwitansi_card_no=trim($_POST["kwitansi_card_no"]);
		$kwitansi_card_nilai=trim($_POST["kwitansi_card_nilai"]);
		
		$kwitansi_cek_nama=trim($_POST["kwitansi_cek_nama"]);
		$kwitansi_cek_no=trim($_POST["kwitansi_cek_no"]);
		$kwitansi_cek_valid=trim($_POST["kwitansi_cek_valid"]);
		$kwitansi_cek_bank=trim($_POST["kwitansi_cek_bank"]);
		$kwitansi_cek_nilai=trim($_POST["kwitansi_cek_nilai"]);
		
		$kwitansi_transfer_bank=trim($_POST["kwitansi_transfer_bank"]);
		$kwitansi_transfer_nama=trim($_POST["kwitansi_transfer_nama"]);
		$kwitansi_transfer_nilai=trim($_POST["kwitansi_transfer_nilai"]);
		
		$cetak = trim($_POST["cetak"]);
		
		$kwitansi_creator=$_SESSION[SESSION_USERID];
		
		$result=$this->m_cetak_kwitansi->cetak_kwitansi_create($kwitansi_no ,$kwitansi_cust ,$kwitansi_tanggal, $kwitansi_ref ,$kwitansi_nilai ,$kwitansi_keterangan ,$kwitansi_status ,$kwitansi_cara ,$kwitansi_bayar ,$kwitansi_tunai_nilai ,$kwitansi_card_nama ,$kwitansi_card_edc ,$kwitansi_card_no ,$kwitansi_card_nilai ,$kwitansi_cek_nama ,$kwitansi_cek_no ,$kwitansi_cek_valid ,$kwitansi_cek_bank ,$kwitansi_cek_nilai ,$kwitansi_transfer_bank ,$kwitansi_transfer_nama ,$kwitansi_transfer_nilai ,$kwitansi_creator ,$cetak );
		echo $result;
	}

	//function for delete selected record
	function cetak_kwitansi_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_cetak_kwitansi->cetak_kwitansi_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function cetak_kwitansi_search(){
		//POST varibale here
		$kwitansi_no=trim(@$_POST["kwitansi_no"]);
		$kwitansi_no=str_replace("/(<\/?)(p)([^>]*>)", "",$kwitansi_no);
		$kwitansi_no=str_replace("'", "''",$kwitansi_no);
		$kwitansi_cust=trim(@$_POST["kwitansi_cust"]);
		$kwitansi_tanggal_start=trim(@$_POST["kwitansi_tanggal_start"]);
		$kwitansi_tanggal_end=trim(@$_POST["kwitansi_tanggal_end"]);
		$kwitansi_keterangan=trim(@$_POST["kwitansi_keterangan"]);
		$kwitansi_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$kwitansi_keterangan);
		$kwitansi_keterangan=str_replace("'", "''",$kwitansi_keterangan);
		$kwitansi_status=trim(@$_POST["kwitansi_status"]);
		$kwitansi_status=str_replace("/(<\/?)(p)([^>]*>)", "",$kwitansi_status);
		$kwitansi_status=str_replace("'", "''",$kwitansi_status);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_cetak_kwitansi->cetak_kwitansi_search($kwitansi_no ,$kwitansi_cust , $kwitansi_tanggal_start, $kwitansi_tanggal_end,$kwitansi_keterangan ,$kwitansi_status ,$start,$end);
		echo $result;
	}


	function cetak_kwitansi_print(){
  		//POST varibale here
		$kwitansi_no=trim(@$_POST["kwitansi_no"]);
		$kwitansi_no=str_replace("/(<\/?)(p)([^>]*>)", "",$kwitansi_no);
		$kwitansi_no=str_replace("'", "''",$kwitansi_no);
		$kwitansi_cust=trim(@$_POST["kwitansi_cust"]);
		$kwitansi_keterangan=trim(@$_POST["kwitansi_keterangan"]);
		$kwitansi_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$kwitansi_keterangan);
		$kwitansi_keterangan=str_replace("'", "''",$kwitansi_keterangan);
		$kwitansi_status=trim(@$_POST["kwitansi_status"]);
		$kwitansi_status=str_replace("/(<\/?)(p)([^>]*>)", "",$kwitansi_status);
		$kwitansi_status=str_replace("'", "''",$kwitansi_status);
		
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$data["data_print"] = $this->m_cetak_kwitansi->cetak_kwitansi_print($kwitansi_no ,$kwitansi_cust ,$kwitansi_keterangan ,$kwitansi_status ,$option,$filter);
		$print_view=$this->load->view("main/p_cetak_kwitansi.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$print_file=fopen("print/cetak_kwitansilist.html","w+");
		fwrite($print_file, $print_view);
		echo '1';
	}
	/* End Of Function */
	
	function print_paper(){
  		//POST varibale here
		$kwitansi_id=trim(@$_POST["kwitansi_id"]);
		
		$result = $this->m_cetak_kwitansi->print_paper($kwitansi_id);
		$rs=$result->row();
		$result_cara_bayar = $this->m_cetak_kwitansi->cara_bayar($kwitansi_id);
		
		$data["kwitansi_no"]=$rs->kwitansi_no;
		$data["kwitansi_tanggal"]=$rs->kwitansi_tanggal;
		$data["kwitansi_customer"]=$rs->cust_no."-".$rs->cust_nama;
		$data["kwitansi_nilai"]="Rp. ".ubah_rupiah($rs->kwitansi_nilai);
		$data["kwitansi_terbilang"]=strtoupper(terbilang($rs->kwitansi_nilai))." RUPIAH";
		$data["kwitansi_keterangan"]=$rs->kwitansi_keterangan;
		$data["kwitansi_cara"]=$rs->kwitansi_cara;
		
		$viewdata=$this->load->view("main/kwitansi_formcetak",$data,TRUE);
		$file = fopen("kwitansi_paper.html",'w');
		fwrite($file, $viewdata);	
		fclose($file);
		echo '1';        
	}
	
	function print_only(){
  		//POST varibale here
		$kwitansi_id=trim(@$_POST["kwitansi_id"]);
		
		$result = $this->m_cetak_kwitansi->print_paper($kwitansi_id);
		$rs=$result->row();
		$result_cara_bayar = $this->m_cetak_kwitansi->cara_bayar($kwitansi_id);
		
		$data["kwitansi_no"]=$rs->kwitansi_no;
		$data["kwitansi_tanggal"]=$rs->kwitansi_tanggal;
		$data["kwitansi_customer"]=$rs->cust_no."-".$rs->cust_nama;
		$data["kwitansi_nilai"]="Rp. ".ubah_rupiah($rs->kwitansi_nilai);
		$data["kwitansi_terbilang"]=strtoupper(terbilang($rs->kwitansi_nilai))." RUPIAH";
		$data["kwitansi_keterangan"]=$rs->kwitansi_keterangan;
		$data["kwitansi_cara"]=$rs->kwitansi_cara;
		
		$viewdata=$this->load->view("main/kwitansi_formcetak_printonly",$data,TRUE);
		$file = fopen("kwitansi_paper.html",'w');
		fwrite($file, $viewdata);	
		fclose($file);
		echo '1';        
	}

	/* Function to Export Excel document */
	function cetak_kwitansi_export_excel(){
		//POST varibale here
		$kwitansi_no=trim(@$_POST["kwitansi_no"]);
		$kwitansi_no=str_replace("/(<\/?)(p)([^>]*>)", "",$kwitansi_no);
		$kwitansi_no=str_replace("'", "''",$kwitansi_no);
		$kwitansi_cust=trim(@$_POST["kwitansi_cust"]);
		$kwitansi_keterangan=trim(@$_POST["kwitansi_keterangan"]);
		$kwitansi_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$kwitansi_keterangan);
		$kwitansi_keterangan=str_replace("'", "''",$kwitansi_keterangan);
		$kwitansi_status=trim(@$_POST["kwitansi_status"]);
		$kwitansi_status=str_replace("/(<\/?)(p)([^>]*>)", "",$kwitansi_status);
		$kwitansi_status=str_replace("'", "''",$kwitansi_status);
		
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_cetak_kwitansi->cetak_kwitansi_export_excel($kwitansi_no ,$kwitansi_cust ,$kwitansi_keterangan ,$kwitansi_status ,$option,$filter);
		
		to_excel($query,"cetak_kwitansi"); 
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