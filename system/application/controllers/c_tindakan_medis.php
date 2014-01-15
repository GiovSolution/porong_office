<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: tindakan Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_tindakan_medis.php
 	+ Author  		: masongbee
 	+ Created on 27/Oct/2009 14:21:34
	
*/

//class of tindakan
class C_tindakan_medis extends Controller {

	//constructor
	function C_tindakan_medis(){
		parent::Controller();
		session_start();
		$this->load->model('m_tindakan_medis', '', TRUE);
		
		
	}
	
	function laporan(){
		$this->load->view('main/v_lap_tindakan_medis');
	}
	
	function print_laporan(){
		$tgl_awal=(isset($_POST['tgl_awal']) ? @$_POST['tgl_awal'] : @$_GET['tgl_awal']);
		$tgl_akhir=(isset($_POST['tgl_akhir']) ? @$_POST['tgl_akhir'] : @$_GET['tgl_akhir']);
		$bulan=(isset($_POST['bulan']) ? @$_POST['bulan'] : @$_GET['bulan']);
		$tahun=(isset($_POST['tahun']) ? @$_POST['tahun'] : @$_GET['tahun']);
		//$opsi=(isset($_POST['opsi']) ? @$_POST['opsi'] : @$_GET['opsi']);
		$periode=(isset($_POST['periode']) ? @$_POST['periode'] : @$_GET['periode']);
		$group=(isset($_POST['group']) ? @$_POST['group'] : @$_GET['group']);
		
		if($periode=="all"){
			$data["periode"]="Semua Periode";
		}else if($periode=="bulan"){
			$tgl_awal=$tahun."-".$bulan;
			$data["periode"]=get_ina_month_name($bulan,'long')." ".$tahun;
		}else if($periode=="tanggal"){
			$date = substr($tgl_awal,8,2);
			$month = substr($tgl_awal,5,2);
			$year = substr($tgl_awal,0,4);
			$tgl_awal_show = $date.'-'.$month.'-'.$year;
			
			$date_akhir = substr($tgl_akhir,8,2);
			$month_akhir = substr($tgl_akhir,5,2);
			$year_akhir = substr($tgl_akhir,0,4);
			$tgl_akhir_show = $date_akhir.'-'.$month_akhir.'-'.$year_akhir;

			$data["periode"]="Periode : ".$tgl_awal_show." s/d ".$tgl_akhir_show.", ";
		}

		$data["data_print"]=$this->m_tindakan_medis->get_laporan($tgl_awal,$tgl_akhir,$periode,$group);
		
		if(!file_exists("print")){
			mkdir("print");
		}
		
		switch($group){
			case "Tanggal": $print_view=$this->load->view("main/p_detail_tmedis_tanggal.php",$data,TRUE);break;
			case "Customer": $print_view=$this->load->view("main/p_detail_tmedis_customer.php",$data,TRUE);break;
			case "Perawatan": $print_view=$this->load->view("main/p_detail_tmedis_perawatan.php",$data,TRUE);break;
			case "Dokter": $print_view=$this->load->view("main/p_detail_tmedis_dokter.php",$data,TRUE);break;
			case "Status": $print_view=$this->load->view("main/p_detail_tmedis_status.php",$data,TRUE);break;
			default: $print_view=$this->load->view("main/p_detail_tmedis_tanggal.php",$data,TRUE);break;
		}
		
		$print_file=fopen("print/report_tindakan_medis.html","w");
		fwrite($print_file, $print_view);
		fclose($print_file);
		echo '1'; 
	}
	
	function punya_paket_checking(){
		$this->m_tindakan_medis->punya_paket_checking();
	}
	
	function get_customer_paket_list(){
		//$apaket_id = isset($_POST['master_id']) ? $_POST['master_id'] : 0;
		$trawat_cust_id = isset($_POST['trawat_cust_id']) ? $_POST['trawat_cust_id'] : 0;
		$dtrawat_rawat_id = isset($_POST['dtrawat_rawat_id']) ? $_POST['dtrawat_rawat_id'] : 0;
		//$dapaket_paket = isset($_POST['dapaket_paket']) ? $_POST['dapaket_paket'] : 0;
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_tindakan_medis->get_customer_paket_list($trawat_cust_id,$dtrawat_rawat_id,$start,$end);
		echo $result;
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_tindakan_medis');
	}
	
	function get_customer_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_public_function->get_customer_list($query,$start,$end);
		echo $result;
	}
	
	function get_dokter_list(){
		//ID dokter pada tabel departemen adalah 8
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$tgl_app = isset($_POST['tgl_app']) ? $_POST['tgl_app'] : "";
		$result=$this->m_public_function->get_petugas_list($query,$tgl_app,"Dokter");
		echo $result;
	}
	
	function get_terapis_list(){
		//ID dokter pada tabel departemen adalah 9
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$tgl_app = isset($_POST['tgl_app']) ? $_POST['tgl_app'] : "";
		$result=$this->m_tindakan_medis->get_petugas_list($query,$tgl_app,"Suster");
		echo $result;
	}
	
	function get_tindakan_medis_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : $_GET['query'];
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_public_function->get_tindakan_medis_list($query,$start,$end);
		echo $result;
	}
	
	//for detail action
	//list detail handler action
	function  detail_tindakan_detail_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_tindakan_medis->detail_tindakan_detail_list($master_id,$query,$start,$end);
		echo $result;
	}
	//end of handler
	
	//purge all detail
	function detail_tindakan_medis_detail_purge(){
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_tindakan_medis->detail_tindakan_medis_detail_purge($master_id);
	}
	//eof
	
	//get master id, note: not done yet
	function get_master_id(){
		$result=$this->m_tindakan_medis->get_master_id();
		echo $result;
	}
	//
	
	//add detail
	/*function detail_tindakan_medis_detail_insert(){
		//POST variable here
		$dtrawat_id = $_POST['dtrawat_id']; // Get our array back and translate it :
		$array_dtrawat_id = json_decode(stripslashes($dtrawat_id));
		
		$dtrawat_master=trim(@$_POST["dtrawat_master"]);
		
		$dtrawat_perawatan = $_POST['dtrawat_perawatan']; // Get our array back and translate it :
		$array_dtrawat_perawatan = json_decode(stripslashes($dtrawat_perawatan));
		
		$dtrawat_petugas1 = $_POST['dtrawat_petugas1']; // Get our array back and translate it :
		$array_dtrawat_petugas1 = json_decode(stripslashes($dtrawat_petugas1));
		
		$dtrawat_jamreservasi = $_POST['dtrawat_jamreservasi']; // Get our array back and translate it :
		$array_dtrawat_jamreservasi = json_decode(stripslashes($dtrawat_jamreservasi));
		
		$dtrawat_status = $_POST['dtrawat_status']; // Get our array back and translate it :
		$array_dtrawat_status = json_decode(stripslashes($dtrawat_status));
		
		$dtrawat_keterangan = $_POST['dtrawat_keterangan']; // Get our array back and translate it :
		$array_dtrawat_keterangan = json_decode(stripslashes($dtrawat_keterangan));
		
		$dtrawat_cust=trim(@$_POST["dtrawat_cust"]);
		
		$result=$this->m_tindakan_medis->detail_tindakan_medis_detail_insert($array_dtrawat_id ,$dtrawat_master ,$array_dtrawat_perawatan ,$array_dtrawat_petugas1 ,$array_dtrawat_jamreservasi ,$array_dtrawat_status ,$array_dtrawat_keterangan ,$dtrawat_cust );
		echo $result;
	}*/
	
	function detail_tindakan_medis_detail_insert($dtrawat_id
												 ,$dtrawat_master
												 ,$dtrawat_perawatan
												 ,$dtrawat_jumlah
												 ,$dtrawat_petugas1
												 ,$dtrawat_jamreservasi
												 ,$dtrawat_status
												 ,$dtrawat_keterangan
												 ,$dtrawat_cust){
		//POST variable here
		$array_dtrawat_id = json_decode(stripslashes($dtrawat_id));
		$array_dtrawat_perawatan = json_decode(stripslashes($dtrawat_perawatan));
		$array_dtrawat_jumlah = json_decode(stripslashes($dtrawat_jumlah));
		$array_dtrawat_petugas1 = json_decode(stripslashes($dtrawat_petugas1));
		$array_dtrawat_jamreservasi = json_decode(stripslashes($dtrawat_jamreservasi));
		$array_dtrawat_status = json_decode(stripslashes($dtrawat_status));
		$array_dtrawat_keterangan = json_decode(stripslashes($dtrawat_keterangan));
		
		$result=$this->m_tindakan_medis->detail_tindakan_medis_detail_insert($array_dtrawat_id
																			 ,$dtrawat_master
																			 ,$array_dtrawat_perawatan
																			 ,$array_dtrawat_jumlah
																			 ,$array_dtrawat_petugas1
																			 ,$array_dtrawat_jamreservasi
																			 ,$array_dtrawat_status
																			 ,$array_dtrawat_keterangan
																			 ,$dtrawat_cust );
		return $result;
	}
	
	/* START NON-MEDIS Function */
	function  dtindakan_jual_nonmedis_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_tindakan_medis->dtindakan_jual_nonmedis_list($master_id,$query,$start,$end);
		echo $result;
	}
	
	function get_nonmedis_in_tmedis_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : $_GET['query'];
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_tindakan_medis->get_nonmedis_in_tmedis_list($query,$start,$end);
		echo $result;
	}
	
	function detail_tindakan_nonmedis_detail_purge(){
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_tindakan_medis->detail_tindakan_nonmedis_detail_purge($master_id);
	}
	
	/*function detail_dtindakan_jual_nonmedis_insert(){
		//*$dtrawat_id=trim(@$_POST["dtrawat_id"]);
		//$dtrawat_master=trim(@$_POST["dtrawat_master"]);
		//$dtrawat_perawatan=trim(@$_POST["dtrawat_perawatan"]);
		//$dtrawat_keterangan=trim(@$_POST["dtrawat_keterangan"]);
		//$dtrawat_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$dtrawat_keterangan);
		//$dtrawat_keterangan=str_replace("\\", "",$dtrawat_keterangan);
		//$customer_id=trim(@$_POST["customer_id"]);
		//$dtrawat_jumlah=trim(@$_POST["dtrawat_jumlah"]);
		//$result=$this->m_tindakan_medis->detail_dtindakan_jual_nonmedis_insert($dtrawat_id ,$dtrawat_master ,$dtrawat_perawatan ,$dtrawat_keterangan ,$customer_id ,$dtrawat_jumlah);
		$dtrawat_id = $_POST['dtrawat_id']; // Get our array back and translate it :
		$array_dtrawat_id = json_decode(stripslashes($dtrawat_id));
		
		$dtrawat_master=trim(@$_POST["dtrawat_master"]);
		
		$dtrawat_perawatan = $_POST['dtrawat_perawatan']; // Get our array back and translate it :
		$array_dtrawat_perawatan = json_decode(stripslashes($dtrawat_perawatan));
		
		$dtrawat_keterangan = $_POST['dtrawat_keterangan']; // Get our array back and translate it :
		$array_dtrawat_keterangan = json_decode(stripslashes($dtrawat_keterangan));
		
		$dtrawat_jumlah = $_POST['dtrawat_jumlah']; // Get our array back and translate it :
		$array_dtrawat_jumlah = json_decode(stripslashes($dtrawat_jumlah));
		
		$customer_id=trim(@$_POST["customer_id"]);
		
		$result=$this->m_tindakan_medis->detail_dtindakan_jual_nonmedis_insert($array_dtrawat_id ,$dtrawat_master ,$array_dtrawat_perawatan ,$array_dtrawat_keterangan ,$customer_id ,$array_dtrawat_jumlah);
	}*/
		
	function detail_dtindakan_jual_nonmedis_insert($dtrawat_id
												   ,$dtrawat_master
												   ,$dtrawat_perawatan
												   ,$dtrawat_suster
												   ,$dtrawat_keterangan
												   ,$customer_id
												   ,$dtrawat_jumlah
												   ,$dtrawat_status){
		$array_dtrawat_id = json_decode(stripslashes($dtrawat_id));
		$array_dtrawat_perawatan = json_decode(stripslashes($dtrawat_perawatan));
		$array_dtrawat_suster = json_decode(stripslashes($dtrawat_suster));
		$array_dtrawat_keterangan = json_decode(stripslashes($dtrawat_keterangan));
		$array_dtrawat_jumlah = json_decode(stripslashes($dtrawat_jumlah));
		$array_dtrawat_status = json_decode(stripslashes($dtrawat_status));
		
		$result=$this->m_tindakan_medis->detail_dtindakan_jual_nonmedis_insert($array_dtrawat_id
																			   ,$dtrawat_master
																			   ,$array_dtrawat_perawatan
																			   ,$array_dtrawat_suster
																			   ,$array_dtrawat_keterangan
																			   ,$customer_id
																			   ,$array_dtrawat_jumlah
																			   ,$array_dtrawat_status);
		return $result;
	}
	
	/* END NON-MEDIS Function */
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		$mode_edit_case = '';
		$mode_edit_case = @$_POST['mode_edit'];
		switch($task){
			case "LIST":
				$this->tindakan_list();
				break;
			case "UPDATE":
				$this->tindakan_update($mode_edit_case);
				break;
			case "CREATE":
				$this->tindakan_create();
				break;
			case "DELETE":
				$this->tindakan_delete();
				break;
			case "SEARCH":
				$this->tindakan_search();
				break;
			case "PRINT":
				$this->tindakan_print();
				break;
			case "EXCEL":
				$this->tindakan_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function tindakan_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_tindakan_medis->tindakan_list($query,$start,$end);
		echo $result;
	}

	//function for update record
	/*function tindakan_update(){
		//POST variable here
		$trawat_id=trim(@$_POST["trawat_id"]);
		$trawat_cust=trim(@$_POST["trawat_cust"]);
		$trawat_keterangan=trim(@$_POST["trawat_keterangan"]);
		$trawat_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$trawat_keterangan);
		$dtrawat_status=trim(@$_POST["dtrawat_status"]);
		$trawat_cust_id=trim(@$_POST["trawat_cust_id"]);
		$dtrawat_perawatan_id=trim(@$_POST["dtrawat_perawatan_id"]);
		$dtrawat_perawatan=trim(@$_POST["dtrawat_perawatan"]);
		$dtrawat_id=trim(@$_POST["dtrawat_id"]);
		$rawat_harga=trim(@$_POST["rawat_harga"]);
		$rawat_du=trim(@$_POST["rawat_du"]);
		$rawat_dm=trim(@$_POST["rawat_dm"]);
		$cust_member=trim(@$_POST["cust_member"]);
		$dtrawat_dokter=trim(@$_POST["dtrawat_dokter"]);
		$dtrawat_dokter_id=trim(@$_POST["dtrawat_dokter_id"]);
		$dtrawat_keterangan=trim(@$_POST["dtrawat_keterangan"]);
		$dtrawat_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$dtrawat_keterangan);
		$dtrawat_dapp=trim(@$_POST["dtrawat_dapp"]);
		$dtrawat_ambil_paket=trim(@$_POST["dtrawat_ambil_paket"]);
		$dapaket_dpaket=trim(@$_POST["dapaket_dpaket"]);
		$dapaket_jpaket=trim(@$_POST["dapaket_jpaket"]);
		$dapaket_paket=trim(@$_POST["dapaket_paket"]);
		$dapaket_item=trim(@$_POST["dapaket_item"]);
		$mode_edit=trim(@$_POST["mode_edit"]);
		$result = $this->m_tindakan_medis->tindakan_update($trawat_id ,$trawat_cust ,$trawat_keterangan ,$dtrawat_status ,$trawat_cust_id ,$dtrawat_perawatan_id ,$dtrawat_perawatan ,$dtrawat_id ,$rawat_harga ,$rawat_du ,$rawat_dm ,$cust_member ,$dtrawat_dokter ,$dtrawat_dokter_id ,$dtrawat_keterangan ,$dtrawat_dapp ,$dtrawat_ambil_paket ,$dapaket_dpaket ,$dapaket_jpaket ,$dapaket_paket ,$dapaket_item ,$mode_edit);
		echo $result;
	}*/
	
	function tindakan_update($mode_edit_case){
		//POST variable here
		if($mode_edit_case=='update_list'){
			//Edit InLine
			$trawat_id=trim(@$_POST["trawat_id"]);
			$trawat_cust_id=trim(@$_POST["trawat_cust_id"]);
			$dtrawat_id=trim(@$_POST["dtrawat_id"]);
			$dtrawat_perawatan=trim(@$_POST["dtrawat_perawatan"]);
			$dtrawat_perawatan_id=trim(@$_POST["dtrawat_perawatan_id"]);
			$dtrawat_dokter=trim(@$_POST["dtrawat_dokter"]);
			$dtrawat_jam=trim(@$_POST["dtrawat_jam"]);
			$dtrawat_keterangan=trim(@$_POST["dtrawat_keterangan"]);
			$dtrawat_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$dtrawat_keterangan);
			$dtrawat_ambil_paket=trim(@$_POST["dtrawat_ambil_paket"]);
			$dtrawat_dpaket_id=trim(@$_POST["dtrawat_dpaket_id"]);
			$dpaket_id=trim(@$_POST["dpaket_id"]);
			$dtrawat_status=trim(@$_POST["dtrawat_status"]);
			$dtrawat_jumlah=trim(@$_POST["dtrawat_jumlah"]);
			
			$result = $this->m_tindakan_medis->tindakan_update_list($trawat_id
																,$trawat_cust_id
															   ,$dtrawat_id
															   ,$dtrawat_perawatan
															   ,$dtrawat_perawatan_id
															   ,$dtrawat_dokter
															   ,$dtrawat_jam
															   ,$dtrawat_keterangan
															   ,$dtrawat_ambil_paket
															   ,$dtrawat_dpaket_id
															   ,$dpaket_id
															   ,$dtrawat_status
															   ,$dtrawat_jumlah);
			echo $result;
			
		}else{
			//Edit Form
			$trawat_id=trim(@$_POST["trawat_id"]);
			$trawat_cust=trim(@$_POST["trawat_cust"]);
			$trawat_keterangan=trim(@$_POST["trawat_keterangan"]);
			$trawat_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$trawat_keterangan);
			
			//menerima POST Detail List Tindakan Medis
			$dtrawat_medis_id = $_POST['dtrawat_medis_id']; // Get our array back and translate it :
			$dtrawat_medis_perawatan = $_POST['dtrawat_medis_perawatan']; // Get our array back and translate it :
			$dtrawat_medis_jumlah = $_POST['dtrawat_medis_jumlah'];
			$dtrawat_medis_petugas1 = $_POST['dtrawat_medis_petugas1']; // Get our array back and translate it :
			$dtrawat_medis_jamreservasi = $_POST['dtrawat_medis_jamreservasi']; // Get our array back and translate it :
			$dtrawat_medis_status = $_POST['dtrawat_medis_status']; // Get our array back and translate it :
			$dtrawat_medis_keterangan = $_POST['dtrawat_medis_keterangan']; // Get our array back and translate it :
			
			//menerima POST Detail List Tindakan Non Medis
			$dtrawat_nonmedis_id = $_POST['dtrawat_nonmedis_id']; // Get our array back and translate it :
			$dtrawat_nonmedis_perawatan = $_POST['dtrawat_nonmedis_perawatan']; // Get our array back and translate it :
			$dtrawat_nonmedis_suster = $_POST['dtrawat_nonmedis_suster']; // Get our array back and translate it :
			$dtrawat_nonmedis_keterangan = $_POST['dtrawat_nonmedis_keterangan']; // Get our array back and translate it :
			$dtrawat_nonmedis_jumlah = $_POST['dtrawat_nonmedis_jumlah']; // Get our array back and translate it :
			$dtrawat_nonmedis_status = $_POST['dtrawat_nonmedis_status']; // Get our array back and translate it :
			
			
			$result_master = $this->m_tindakan_medis->tindakan_update($trawat_id ,$trawat_keterangan);
			
			if($result_master==1){
				//printf('masuk');
				//Proses Insert Detail List Tindakan Medis
				$result_medis = $this->detail_tindakan_medis_detail_insert($dtrawat_medis_id
														   ,$trawat_id
														   ,$dtrawat_medis_perawatan
														   ,$dtrawat_medis_jumlah
														   ,$dtrawat_medis_petugas1
														   ,$dtrawat_medis_jamreservasi
														   ,$dtrawat_medis_status
														   ,$dtrawat_medis_keterangan
														   ,$trawat_cust);
				
				//Proses Insert Detail List Tindakan Non Medis
				$result_nonmedis = $this->detail_dtindakan_jual_nonmedis_insert($dtrawat_nonmedis_id
															 ,$trawat_id
															 ,$dtrawat_nonmedis_perawatan
															 ,$dtrawat_nonmedis_suster
															 ,$dtrawat_nonmedis_keterangan
															 ,$trawat_cust
															 ,$dtrawat_nonmedis_jumlah
															 ,$dtrawat_nonmedis_status);
				
				$result = $result_master + $result_medis + $result_nonmedis;
				echo $result;
			}else{
				echo 0;
			}
			
		}
	}
	
	//function for create new record
	function tindakan_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$trawat_cust=trim(@$_POST["trawat_cust"]);
		$trawat_keterangan=trim(@$_POST["trawat_keterangan"]);
		$trawat_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$trawat_keterangan);
		$trawat_keterangan=str_replace("'", "''",$trawat_keterangan);
		$result=$this->m_tindakan_medis->tindakan_create($trawat_cust ,$trawat_keterangan );
		echo $result;
	}

	//function for delete selected record
	function tindakan_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_tindakan_medis->tindakan_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function tindakan_search(){
		//POST varibale here
		$trawat_cust=trim(@$_POST["trawat_cust"]);
		/*$trawat_keterangan=trim(@$_POST["trawat_keterangan"]);
		$trawat_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$trawat_keterangan);
		$trawat_keterangan=str_replace("'", "''",$trawat_keterangan);*/
		if(trim(@$_POST["trawat_tglapp_start"])!="")
			$trawat_tglapp_start=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_start"])));
		else
			$trawat_tglapp_start="";
		if(trim(@$_POST["trawat_tglapp_end"])!="")
			$trawat_tglapp_end=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_end"])));
		else
			$trawat_tglapp_end="";
		$trawat_rawat=trim(@$_POST["trawat_rawat"]);
		$trawat_dokter=trim(@$_POST["trawat_dokter"]);
		$trawat_status=trim(@$_POST["trawat_status"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_tindakan_medis->tindakan_search($trawat_cust ,$trawat_tglapp_start ,$trawat_tglapp_end ,$trawat_rawat ,$trawat_dokter ,$trawat_status ,$start,$end);
		echo $result;
	}


	function tindakan_print(){
  		//POST varibale here
		$trawat_cust=trim(@$_POST["trawat_cust"]);
		if(trim(@$_POST["trawat_tglapp_start"])!="")
			$trawat_tglapp_start=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_start"])));
		else
			$trawat_tglapp_start="";
		if(trim(@$_POST["trawat_tglapp_end"])!="")
			$trawat_tglapp_end=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_end"])));
		else
			$trawat_tglapp_end="";
		$trawat_rawat=trim(@$_POST["trawat_rawat"]);
		$trawat_dokter=trim(@$_POST["trawat_dokter"]);
		$trawat_status=trim(@$_POST["trawat_status"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$data["data_print"] = $this->m_tindakan_medis->tindakan_print($trawat_cust ,$trawat_tglapp_start ,$trawat_tglapp_end ,$trawat_rawat ,$trawat_dokter ,$trawat_status ,$option,$filter);
		$print_view=$this->load->view("main/p_tindakan_medis.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$print_file=fopen("print/tindakan_medislist.html","w+");
		fwrite($print_file, $print_view);
		echo '1';
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function tindakan_export_excel(){
		//POST varibale here
		$trawat_cust=trim(@$_POST["trawat_cust"]);
		if(trim(@$_POST["trawat_tglapp_start"])!="")
			$trawat_tglapp_start=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_start"])));
		else
			$trawat_tglapp_start="";
		if(trim(@$_POST["trawat_tglapp_end"])!="")
			$trawat_tglapp_end=date('Y-m-d', strtotime(trim(@$_POST["trawat_tglapp_end"])));
		else
			$trawat_tglapp_end="";
		$trawat_rawat=trim(@$_POST["trawat_rawat"]);
		$trawat_dokter=trim(@$_POST["trawat_dokter"]);
		$trawat_status=trim(@$_POST["trawat_status"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_tindakan_medis->tindakan_export_excel($trawat_cust ,$trawat_tglapp_start ,$trawat_tglapp_end ,$trawat_rawat ,$trawat_dokter ,$trawat_status ,$option,$filter);
		
		$this->load->plugin('to_excel');
		to_excel($query,"tindakan_medis"); 
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