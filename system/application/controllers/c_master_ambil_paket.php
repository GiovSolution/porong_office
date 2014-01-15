<?php
/* 	
	Miracle IT Team
*/

//class of paket
class C_master_ambil_paket extends Controller {

	//constructor
	function C_master_ambil_paket(){
		parent::Controller();
		$this->load->model('m_master_ambil_paket', '', TRUE);
		session_start();
		$this->load->plugin('to_excel');
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_master_ambil_paket');
	}
	
	function laporan(){
		$this->load->view('main/v_lap_ambil_paket');
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
		
		//$data["jenis"]='Produk';
		if($periode=="all"){
			$data["periode"]="Semua Periode";
		}else if($periode=="bulan"){
			$tgl_awal=$tahun."-".$bulan;
			$data["periode"]=get_ina_month_name($bulan,'long')." ".$tahun;
			$data["tanggal_akhir"]="Periode : Awal s/d ".get_ina_month_name($bulan,'long')." ".$tahun; 
		}else if($periode=="tanggal"){
			$date = substr($tgl_awal,8,2);
			$month = substr($tgl_awal,5,2);
			$year = substr($tgl_awal,0,4);
			$tgl_awal_show = $date.'-'.$month.'-'.$year;
			
			
			$date = substr($tgl_akhir,8,2);
			$month = substr($tgl_akhir,5,2);
			$year = substr($tgl_akhir,0,4);
			$tgl_akhir_show = $date.'-'.$month.'-'.$year;
			
			//$tgl_awal_show = $tgl_awal;
			//$tgl_akhir_show = $tgl_akhir;
			//$tgl_awal_show = date("d-m-Y");
			//$tgl_akhir_show = date("d-m-Y");
			$data["periode"]="Periode : ".$tgl_awal_show." s/d ".$tgl_akhir_show.", ";
			$data["tanggal_akhir"]="Periode : Awal s/d ".$tgl_akhir_show.", ";
		}
		
		$data["group"]= $group;
		$data["data_print"]=$this->m_master_ambil_paket->get_laporan($tgl_awal,$tgl_akhir,$periode,$opsi,$opsi_status,$group,$bulan,$tahun);
		
		if(!file_exists("print")){
			mkdir("print");
		}
		
		if($opsi=='rekap'){
		
			switch($group){
				case "Tanggal": $print_view=$this->load->view("main/p_rekap_ambil_paket_tanggal.php",$data,TRUE);break;
				case "Customer": $print_view=$this->load->view("main/p_rekap_ambil_paket_customer.php",$data,TRUE);break;
				case "Paket": $print_view=$this->load->view("main/p_rekap_ambil_paket_paket.php",$data,TRUE);break;
				case "Sisa Paket (Akumulatif)": $print_view=$this->load->view("main/p_rekap_ambil_paket_sisa_paket.php",$data,TRUE);break;
				default: $print_view=$this->load->view("main/p_rekap_ambil_paket.php",$data,TRUE);break;
			}
			$print_file=fopen("print/report_ambil_paket.html","w");
			fwrite($print_file, $print_view);
			echo '1'; 
			
		}else{
			switch($group){
				case "Tanggal": $print_view=$this->load->view("main/p_detail_ambil_paket_tanggal.php",$data,TRUE);break;
				case "Tanggal 2 (PPN)": $print_view=$this->load->view("main/p_detail_ambil_paket_tanggal2.php",$data,TRUE);break;
				case "Customer": $print_view=$this->load->view("main/p_detail_ambil_paket_customer.php",$data,TRUE);break;
				case "Paket": $print_view=$this->load->view("main/p_detail_ambil_paket_paket.php",$data,TRUE);break;
				case "Perawatan Semua": $print_view=$this->load->view("main/p_detail_ambil_paket_rawat.php",$data,TRUE);break;
				case "Perawatan Medis": $print_view=$this->load->view("main/p_detail_ambil_paket_rawat.php",$data,TRUE);break;
				case "Perawatan Non Medis": $print_view=$this->load->view("main/p_detail_ambil_paket_rawat.php",$data,TRUE);break;
				case "Perawatan Anti Aging": $print_view=$this->load->view("main/p_detail_ambil_paket_rawat.php",$data,TRUE);break;
				case "Perawatan Surgery": $print_view=$this->load->view("main/p_detail_ambil_paket_rawat.php",$data,TRUE);break;
				case "Perawatan Lain-Lain": $print_view=$this->load->view("main/p_detail_ambil_paket_rawat.php",$data,TRUE);break;
				case "Pemakai": $print_view=$this->load->view("main/p_detail_ambil_paket_pemakai.php",$data,TRUE);break;
				case "Referal": $print_view=$this->load->view("main/p_detail_ambil_paket_referal.php",$data,TRUE);break;
				case "No Faktur": $print_view=$this->load->view("main/p_detail_ambil_paket.php",$data,TRUE);break;
				case "Sisa Paket (Akumulatif)": $print_view=$this->load->view("main/p_rekap_ambil_paket_sisa_paket.php",$data,TRUE);break;
				default: $print_view=$this->load->view("main/p_detail_ambil_paket.php",$data,TRUE);break;
			}
			$print_file=fopen("print/report_ambil_paket.html","w");
			fwrite($print_file, $print_view);
			fclose($print_file);
			echo '1'; 
		}
		/*if(!file_exists("print")){
			mkdir("print");
		}*/
		/*if($opsi=='rekap')
			$print_file=fopen("print/report_jproduk.html","w+");
		else
			$print_file=fopen("print/report_jproduk.html","w+");*/
			
		/*fwrite($print_file, $print_view);
		echo '1'; */
	}
	
	function get_referal_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$result=$this->m_master_ambil_paket->get_referal_list($query);
		echo $result;
	}
	
	function get_customer_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_public_function->get_customer_list($query,$start,$end);
		echo $result;
	}
	
	//function fot list record
	function phonegroup_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);

		$result=$this->m_master_ambil_paket->phonegroup_list($query,$start,$end);
		echo $result;
	}
	
	function get_paket_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_master_ambil_paket->get_paket_list($query,$start,$end);
		echo $result;
	}
	
	function get_history_ambil_paket(){
		/*$dpaket_master = isset($_POST['dpaket_master']) ? $_POST['dpaket_master'] : 0;
		$dpaket_paket = isset($_POST['dpaket_paket']) ? $_POST['dpaket_paket'] : 0;*/
		$dapaket_dpaket = isset($_POST['dapaket_dpaket']) ? $_POST['dapaket_dpaket'] : 0;
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		//$result = $this->m_master_ambil_paket->get_history_ambil_paket($dpaket_master,$dpaket_paket,$start,$end);
		$result = $this->m_master_ambil_paket->get_history_ambil_paket($dapaket_dpaket,$start,$end);
		echo $result;
	}
	
	function get_daftar_pemakai_paket(){
		$dpaket_master = isset($_POST['dpaket_master']) ? $_POST['dpaket_master'] : 0;
		//$dpaket_paket = isset($_POST['dpaket_paket']) ? $_POST['dpaket_paket'] : 0;*/
		//$dapaket_dpaket = isset($_POST['dapaket_dpaket']) ? $_POST['dapaket_dpaket'] : 0;
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		//$result = $this->m_master_ambil_paket->get_history_ambil_paket($dpaket_master,$dpaket_paket,$start,$end);
		$result = $this->m_master_ambil_paket->get_daftar_pemakai_paket($dpaket_master,$start,$end);
		echo $result;
	}
	
	
	function get_isi_rawat_list(){
		//$apaket_id = isset($_POST['master_id']) ? $_POST['master_id'] : 0;
		$dapaket_dpaket = isset($_POST['dapaket_dpaket']) ? $_POST['dapaket_dpaket'] : 0;
		$dapaket_jpaket = isset($_POST['dapaket_jpaket']) ? $_POST['dapaket_jpaket'] : 0;
		$dapaket_paket = isset($_POST['dapaket_paket']) ? $_POST['dapaket_paket'] : 0;
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_master_ambil_paket->get_isi_rawat_list($dapaket_dpaket,$dapaket_jpaket,$dapaket_paket,$start,$end);
		echo $result;
	}
	
	function get_pengguna_paket_list(){
		$dpaket_master = isset($_POST['dpaket_master']) ? $_POST['dpaket_master'] : 0;
		$result = $this->m_master_ambil_paket->get_pengguna_paket_list($dpaket_master);
		echo $result;
	}
	
	//for detail action
	//list detail handler action
	function  detail_ambil_paket_isi_perawatan_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_master_ambil_paket->detail_ambil_paket_isi_perawatan_list($master_id,$query,$start,$end);
		echo $result;
	}
	//end of handler
	
	//purge all detail
	function detail_ambil_paket_isi_perawatan_purge(){
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_master_ambil_paket->detail_ambil_paket_isi_perawatan_purge($master_id);
	}
	//eof
	
	//get master id, note: not done yet
	function get_master_id(){
		$result=$this->m_master_ambil_paket->get_master_id();
		echo $result;
	}
	//
	
	//add detail
	function detail_ambil_paket_isi_perawatan_insert(){
		//POST variable here
		$dapaket_dpaket=trim(@$_POST["dapaket_dpaket"]);
		$dapaket_jpaket=trim(@$_POST["dapaket_jpaket"]);
		$dapaket_paket=trim(@$_POST["dapaket_paket"]);
		$dapaket_item=trim(@$_POST["dapaket_item"]);
		$dapaket_jumlah=trim(@$_POST["dapaket_jumlah"]);
		$dapaket_cust=trim(@$_POST["dapaket_cust"]);
		$tgl_ambil=trim(@$_POST["tgl_ambil"]);
		$keterangan=trim(@$_POST["keterangan"]);
		$keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$keterangan);
		$dapaket_referal=trim(@$_POST["dapaket_referal"]);
		
		$count=trim(@$_POST['count']);
		$dcount=trim(@$_POST['dcount']);
		
		$result=$this->m_master_ambil_paket->detail_ambil_paket_isi_perawatan_insert($dapaket_dpaket, $dapaket_jpaket, $dapaket_paket, $dapaket_item, $dapaket_jumlah, $dapaket_cust, $tgl_ambil, $keterangan, $dapaket_referal, $count, $dcount);
		echo $result;
	}
	
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->ambil_paket_list();
				break;
			case "UPDATE":
				$this->ambil_paket_update();
				break;
			case "CREATE":
				$this->ambil_paket_create();
				break;
			case "CEK_BATAL":
				$this->ambil_paket_pengecekan_batal();
				break;
			case "CEK_AMBIL":
				$this->ambil_paket_pengecekan_ambil();
				break;
			case "ADJ":
				$this->ambil_paket_status_adj();
				break;
			case "DELETE":
				$this->ambil_paket_delete();
				break;
			case "PHONEGROUP":
				$this->ambil_paket_phonegroup_create();
				break;
			case "SEARCH":
				$this->ambil_paket_search();
				break;
			case "PRINT":
				$this->ambil_paket_print();
				break;
			case "PRINT2":
				$this->daftar_ambil_paket_print();
				break;
			case "EXCEL":
				$this->ambil_paket_export_excel();
				break;
			case "EXCEL2":
				$this->daftar_ambil_paket_export_excel();
				break;
				
			case "BATAL":
				$this->ambil_paket_batal();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function ambil_paket_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_master_ambil_paket->ambil_paket_list($query,$start,$end);
		echo $result;
	}

	
	function ambil_paket_pengecekan_batal(){
	
		$tanggal_pengecekan=trim(@$_POST["tgl_ambil"]);
		//$dapaket_id = $_POST['dapaket_id']; // Get our array back and translate it :
		$tanggal_pengecekan = json_decode(stripslashes($tanggal_pengecekan));
	
		$result=$this->m_master_ambil_paket->pengecekan_dokumen_untuk_batal($tanggal_pengecekan);
		echo $result;
	}
	
	function ambil_paket_pengecekan_ambil(){
	
		$tanggal_pengecekan=trim(@$_POST["tgl_ambil"]);
	
		$result=$this->m_public_function->pengecekan_dokumen($tanggal_pengecekan);
		echo $result;
	}
	
	
	
	function ambil_paket_status_adj(){
	
		//$tanggal_pengecekan=trim(@$_POST["tgl_ambil"]);
		$dapaket_id = $_POST['dapaket_id']; // Get our array back and translate it :
		$dapaket_id = json_decode(stripslashes($dapaket_id));
		//$tanggal_pengecekan = json_decode(stripslashes($tanggal_pengecekan));
	
		$result=$this->m_master_ambil_paket->ambil_paket_status_adj($dapaket_id);
		echo $result;
	}
	
	
	
	//function for update record
	function ambil_paket_update(){
		//POST variable here
		$paket_id=trim(@$_POST["ambil_paket_id"]);
		$paket_kode=trim(@$_POST["ambil_paket_kode"]);
		$paket_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_kode);
		$paket_kode=str_replace(",", "\,",$paket_kode);
		$paket_kode=str_replace("'", "\'",$paket_kode);
		$paket_nama=trim(@$_POST["ambil_paket_nama"]);
		$paket_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_nama);
		$paket_nama=str_replace(",", "\,",$paket_nama);
		$paket_nama=str_replace("'", "\'",$paket_nama);
		$paket_expired=trim(@$_POST["ambil_paket_expired"]);
		$result = $this->m_master_ambil_paket->ambil_paket_update($paket_id ,$paket_kode ,$paket_nama ,$paket_expired );
		echo $result;
	}
	
	//function for create new record
	function ambil_paket_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$paket_kode=trim(@$_POST["paket_kode"]);
		$paket_kode=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_kode);
		$paket_kode=str_replace("'", "\'",$paket_kode);
		$paket_nama=trim(@$_POST["paket_nama"]);
		$paket_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$paket_nama);
		$paket_nama=str_replace("'", "\'",$paket_nama);
		$paket_expired=trim(@$_POST["paket_expired"]);
		$result=$this->m_master_ambil_paket->ambil_paket_create($paket_kode ,$paket_nama ,$paket_expired );
		echo $result;
	}

	//function for delete selected record
	function ambil_paket_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_master_ambil_paket->ambil_paket_delete($pkid);
		echo $result;
	}
	
	//function for create new record
	function ambil_paket_phonegroup_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$hapus_cust = trim(@$_POST["hapus_cust"]);
		$phonegroup_id=trim(@$_POST["phonegroup_id"]);
		$phonegroup_id=str_replace("/(<\/?)(p)([^>]*>)", "",$phonegroup_id);
		$phonegroup_id=str_replace("'", "''",$phonegroup_id);
		$apaket_faktur=trim(@$_POST["apaket_faktur"]);
		$apaket_faktur=str_replace("/(<\/?)(p)([^>]*>)", "",$apaket_faktur);
		$apaket_faktur=str_replace("'", "\'",$apaket_faktur);
		$apaket_cust=trim(@$_POST["apaket_cust"]);
		$apaket_paket=trim(@$_POST["apaket_paket"]);
		$apaket_sisa=trim(@$_POST["apaket_sisa"]);
		$apaket_jenis=trim(@$_POST["apaket_jenis"]);
		$apaket_kadaluarsa=trim(@$_POST["apaket_kadaluarsa"]);
		$apaket_kadaluarsa_akhir=trim(@$_POST["apaket_kadaluarsa_akhir"]);
		$apaket_tgl_faktur=trim(@$_POST["apaket_tgl_faktur"]);
		$apaket_tgl_faktur_akhir=trim(@$_POST["apaket_tgl_faktur_akhir"]);
		$apaket_jenis_kadaluarsa=trim(@$_POST["apaket_jenis_kadaluarsa"]);
		$apaket_transaksi_start=trim(@$_POST["apaket_tgl_transaksi_start"]);
		$apaket_transaksi_end=trim(@$_POST["apaket_tgl_transaksi_end"]);
		$apaket_tidak_transaksi_start=trim(@$_POST["apaket_tidak_tgl_transaksi_start"]);
		$apaket_tidak_transaksi_end=trim(@$_POST["apaket_tidak_tgl_transaksi_end"]);
		
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		//$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		//$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		
		//$phonegroup_data=@$_POST["phonegroup_data"];
		$result=$this->m_master_ambil_paket->ambil_paket_phonegroup_create($apaket_faktur, $apaket_cust, $apaket_paket, $apaket_kadaluarsa, $apaket_kadaluarsa_akhir, $apaket_tgl_faktur, $apaket_tgl_faktur_akhir, $apaket_sisa,$apaket_jenis, $apaket_jenis_kadaluarsa, $apaket_transaksi_start, $apaket_transaksi_end, $apaket_tidak_transaksi_start, $apaket_tidak_transaksi_end,$hapus_cust,$option,$filter,$phonegroup_id);
		echo $result;
	}
	
	function ambil_paket_batal(){
		$dapaket_id = $_POST['dapaket_id']; // Get our array back and translate it :
		$dapaket_id = json_decode(stripslashes($dapaket_id));
		$result=$this->m_master_ambil_paket->ambil_paket_batal($dapaket_id);
		echo $result;
	}

	//function for advanced search
	function ambil_paket_search(){
		//POST varibale here
		$apaket_faktur=trim(@$_POST["apaket_faktur"]);
		$apaket_faktur=str_replace("/(<\/?)(p)([^>]*>)", "",$apaket_faktur);
		$apaket_faktur=str_replace("'", "\'",$apaket_faktur);
		$apaket_cust=trim(@$_POST["apaket_cust"]);
		$apaket_paket=trim(@$_POST["apaket_paket"]);
		$apaket_sisa=trim(@$_POST["apaket_sisa"]);
		$apaket_jenis=trim(@$_POST["apaket_jenis"]);
		$apaket_sortby=trim(@$_POST["apaket_sortby"]);
		$apaket_kadaluarsa=trim(@$_POST["apaket_kadaluarsa"]);
		$apaket_kadaluarsa_akhir=trim(@$_POST["apaket_kadaluarsa_akhir"]);
		$apaket_tgl_faktur=trim(@$_POST["apaket_tgl_faktur"]);
		$apaket_tgl_faktur_akhir=trim(@$_POST["apaket_tgl_faktur_akhir"]);
		$apaket_jenis_kadaluarsa=trim(@$_POST["apaket_jenis_kadaluarsa"]);
		$apaket_transaksi_start=trim(@$_POST["apaket_tgl_transaksi_start"]);
		$apaket_transaksi_end=trim(@$_POST["apaket_tgl_transaksi_end"]);
		$apaket_tidak_transaksi_start=trim(@$_POST["apaket_tidak_tgl_transaksi_start"]);
		$apaket_tidak_transaksi_end=trim(@$_POST["apaket_tidak_tgl_transaksi_end"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_master_ambil_paket->ambil_paket_search($apaket_faktur, $apaket_cust, $apaket_paket, $apaket_kadaluarsa, $apaket_kadaluarsa_akhir, $apaket_tgl_faktur, $apaket_tgl_faktur_akhir, $apaket_sisa, $apaket_jenis, $apaket_sortby, $apaket_jenis_kadaluarsa, $apaket_transaksi_start, $apaket_transaksi_end, $apaket_tidak_transaksi_start, $apaket_tidak_transaksi_end,$start, $end);
		echo $result;
	}


	function ambil_paket_print(){
  		//POST varibale here
		$apaket_faktur=trim(@$_POST["apaket_faktur"]);
		$apaket_faktur=str_replace("/(<\/?)(p)([^>]*>)", "",$apaket_faktur);
		$apaket_faktur=str_replace("'", "\'",$apaket_faktur);
		$apaket_cust=trim(@$_POST["apaket_cust"]);
		$apaket_paket=trim(@$_POST["apaket_paket"]);
		$apaket_sisa=trim(@$_POST["apaket_sisa"]);
		$apaket_jenis=trim(@$_POST["apaket_jenis"]);
		$apaket_jenis_kadaluarsa=trim(@$_POST["apaket_jenis_kadaluarsa"]);
		$apaket_kadaluarsa=trim(@$_POST["apaket_kadaluarsa"]);
		$apaket_kadaluarsa_akhir=trim(@$_POST["apaket_kadaluarsa_akhir"]);
		$apaket_tgl_faktur=trim(@$_POST["apaket_tgl_faktur"]);
		$apaket_tgl_faktur_akhir=trim(@$_POST["apaket_tgl_faktur_akhir"]);
		$apaket_transaksi_start=trim(@$_POST["apaket_tgl_transaksi_start"]);
		$apaket_transaksi_end=trim(@$_POST["apaket_tgl_transaksi_end"]);
		$apaket_tidak_transaksi_start=trim(@$_POST["apaket_tidak_tgl_transaksi_start"]);
		$apaket_tidak_transaksi_end=trim(@$_POST["apaket_tidak_tgl_transaksi_end"]);
		
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$data["data_print"] = $this->m_master_ambil_paket->ambil_paket_print($apaket_faktur
																			,$apaket_cust
																			,$apaket_paket
																			,$apaket_kadaluarsa
																			,$apaket_kadaluarsa_akhir
																			,$apaket_tgl_faktur
																			,$apaket_tgl_faktur_akhir
																			,$apaket_sisa
																			,$apaket_jenis
																			,$apaket_jenis_kadaluarsa
																			,$apaket_transaksi_start, $apaket_transaksi_end, $apaket_tidak_transaksi_start, $apaket_tidak_transaksi_end,$option
																			,$filter);
		$print_view=$this->load->view("main/p_master_ambil_paket.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$print_file=fopen("print/ambil_paketlist.html","w+");
		fwrite($print_file, $print_view);
		echo '1';
	}
	/* End Of Function */
	
	function daftar_ambil_paket_print(){
  		//POST varibale here
		$dapaket_dpaket = isset($_POST['dapaket_dpaket']) ? $_POST['dapaket_dpaket'] : 0;
		$rawat_nama=trim(@$_POST["rawat_nama"]);
		$dapaket_jumlah=trim(@$_POST["dapaket_jumlah"]);
		$cust_nama=trim(@$_POST["cust_nama"]);
		$tgl_ambil=trim(@$_POST["tgl_ambil"]);
		$tgl_ambil=date('Y-m-d', strtotime(trim(@$_POST["tgl_ambil"])));
		$referal=trim(@$_POST["referal"]);
		$keterangan=trim(@$_POST["keterangan"]);
		$dapaket_stat_dok=trim(@$_POST["dapaket_stat_dok"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		$paket_nobukti=trim(@$_POST["paket_nobukti"]);
		$cust_no=trim(@$_POST["cust_no"]);
		$paket_nama=trim(@$_POST["paket_nama"]);
		
		//$data["rawat_nama"]=" ".$rawat_nama." ";
		/*$data["rawat_nama"]=" ".$rawat_nama." ";*/
		
		
		
		
		$data["data_print"] = $this->m_master_ambil_paket->daftar_ambil_paket_print($rawat_nama
																	   ,$dapaket_jumlah
																	   ,$tgl_ambil
																	   ,$referal
																	   ,$keterangan
																	   ,$dapaket_stat_dok
																	   ,$cust_nama
																	   ,$option
																	   ,$filter,$dapaket_dpaket);
		$data["paket_nobukti"]=" ".$paket_nobukti." ";
		$data["cust_no"]=" ".$cust_no." ";
		$data["paket_nama"]=" ".$paket_nama." ";
		$data["cust_nama"]=" ".$cust_nama." ";
		$data["tgl_ambil"]=" ".$tgl_ambil." ";
		
		
		$print_view=$this->load->view("main/p_daftar_ambil_paket.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$print_file=fopen("print/daftar_ambil_paketlist.html","w+");
		fwrite($print_file, $print_view);
		echo '1';
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function ambil_paket_export_excel(){
		//POST varibale here
		$apaket_faktur=trim(@$_POST["apaket_faktur"]);
		$apaket_faktur=str_replace("/(<\/?)(p)([^>]*>)", "",$apaket_faktur);
		$apaket_faktur=str_replace("'", "\'",$apaket_faktur);
		$apaket_cust=trim(@$_POST["apaket_cust"]);
		$apaket_paket=trim(@$_POST["apaket_paket"]);
		$apaket_sisa=trim(@$_POST["apaket_sisa"]);
		$apaket_jenis=trim(@$_POST["apaket_jenis"]);
		$apaket_jenis_kadaluarsa=trim(@$_POST["apaket_jenis_kadaluarsa"]);
		$apaket_kadaluarsa=trim(@$_POST["apaket_kadaluarsa"]);
		$apaket_kadaluarsa_akhir=trim(@$_POST["apaket_kadaluarsa_akhir"]);
		$apaket_tgl_faktur=trim(@$_POST["apaket_tgl_faktur"]);
		$apaket_tgl_faktur_akhir=trim(@$_POST["apaket_tgl_faktur_akhir"]);
		$apaket_jenis=trim(@$_POST["apaket_jenis"]);
		$apaket_transaksi_start=trim(@$_POST["apaket_tgl_transaksi_start"]);
		$apaket_transaksi_end=trim(@$_POST["apaket_tgl_transaksi_end"]);
		$apaket_tidak_transaksi_start=trim(@$_POST["apaket_tidak_tgl_transaksi_start"]);
		$apaket_tidak_transaksi_end=trim(@$_POST["apaket_tidak_tgl_transaksi_end"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_master_ambil_paket->ambil_paket_export_excel($apaket_faktur
																		,$apaket_cust
																		,$apaket_paket
																		,$apaket_kadaluarsa
																		,$apaket_kadaluarsa_akhir
																		,$apaket_tgl_faktur
																		,$apaket_tgl_faktur_akhir
																		,$apaket_jenis
																		,$apaket_jenis_kadaluarsa
																		,$apaket_sisa,$apaket_transaksi_start, $apaket_transaksi_end, $apaket_tidak_transaksi_start, $apaket_tidak_transaksi_end
																		,$option
																		,$filter);
		
		to_excel($query,"pengambilan_paket"); 
		echo '1';
			
	}
	
	/* Function to Export Excel document */
	function daftar_ambil_paket_export_excel(){
		//POST varibale here
		$dapaket_dpaket = isset($_POST['dapaket_dpaket']) ? $_POST['dapaket_dpaket'] : 0;
		$rawat_nama=trim(@$_POST["rawat_nama"]);
		$dapaket_jumlah=trim(@$_POST["dapaket_jumlah"]);
		$cust_nama=trim(@$_POST["cust_nama"]);
		$tgl_ambil=trim(@$_POST["tgl_ambil"]);
		$referal=trim(@$_POST["referal"]);
		$keterangan=trim(@$_POST["keterangan"]);
		$dapaket_stat_dok=trim(@$_POST["dapaket_stat_dok"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_master_ambil_paket->daftar_ambil_paket_export_excel($rawat_nama
																	   ,$dapaket_jumlah
																	   ,$tgl_ambil
																	   ,$referal
																	   ,$keterangan
																	   ,$dapaket_stat_dok
																	   ,$cust_nama
																	   ,$option
																	   ,$filter,$dapaket_dpaket);
		
		to_excel($query,"pengambilan_paket"); 
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