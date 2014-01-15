<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	
	+ Module  		: customer Controller
	+ Description	: For record controller process back-end
	+ Filename 		: C_customer.php
 	+ Author  		: zainal, mukhlison
 	+ Created on 16/Jul/2009 17:02:19
	
*/

//class of customer
class C_customer extends Controller {

	//constructor
	function C_customer(){
		parent::Controller();
		session_start();
		$this->load->model('m_customer', '', TRUE);
		$this->load->plugin('to_excel');
		
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_customer');
	}
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->customer_list();
				break;
			case "UPDATE":
				$this->customer_update();
				break;
			case "CREATE":
				$this->customer_create();
				break;
			case "PHONEGROUP":
				$this->customer_phonegroup_create();
				break;
			case "DELETE":
				$this->customer_delete();
				break;
			case "SEARCH":
				$this->customer_search();
				break;
			case "PRINT":
				$this->customer_print();
				break;
			case "PRINT_LABEL":
				$this->customer_print_label();
				break;
			case "EXCEL":
				$this->customer_export_excel();
				break;
			case "CRMVAL":
				$this->customer_crm_generator_create();
				break;
			case "CRMVAL2":
				$this->customer_crm_generator_create_all();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	
	function get_profesi_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$result=$this->m_customer->get_profesi_list($query);
		echo $result;
	}
	
	function get_hobi_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$result=$this->m_customer->get_hobi_list($query);
		echo $result;
	}
	
	function get_reflain_list(){
		$result=$this->m_customer->get_reflain_list();
		echo $result;
	}
	
	/*function get_cabang_list(){
		$result=$this->m_public_function->get_cabang_list();
		echo $result;
	}*/
	
	function get_phonegroup_list(){
		$query = isset($_POST['query']) ? @$_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? @$_POST['start'] : @$_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? @$_POST['limit'] : @$_GET['limit']);
		$result=$this->m_customer->get_phonegroup_list($query,$start,$end);
		echo $result;
	}
		
		
	function get_cabang_list(){
		$result=$this->m_customer->get_cabang_list();
		echo $result;
	}
	
	
	function get_cust_member(){
		$cust_id = isset($_POST['cust_id']) ? $_POST['cust_id'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_customer->get_cust_member($cust_id,$start,$end);
		echo $result;
	}
	
	function get_cust_note(){
		$cust_id = isset($_POST['cust_id']) ? $_POST['cust_id'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result=$this->m_customer->get_cust_note($cust_id,$start,$end);
		echo $result;
	}
	
	function cust_note_purge(){
		/*$master_id = isset($_POST['master_id']) ? $_POST['master_id'] : "";
		$result=$this->m_customer->cust_note_purge($master_id);
		echo $result;*/
	}
	
	//function for create new record
	function customer_phonegroup_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$hapus_cust = trim(@$_POST["hapus_cust"]);
		
		$phonegroup_nama=trim(@$_POST["phonegroup_nama"]);
		$phonegroup_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$phonegroup_nama);
		$phonegroup_nama=str_replace("'", "''",$phonegroup_nama);
		$phonegroup_id=trim(@$_POST["phonegroup_id"]);
		$phonegroup_id=str_replace("/(<\/?)(p)([^>]*>)", "",$phonegroup_id);
		$phonegroup_id=str_replace("'", "''",$phonegroup_id);
		
		$cust_id=trim(@$_POST["cust_id"]);
		$cust_no=trim(@$_POST["cust_no"]);
		$cust_no=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_no);
		$cust_no=str_replace("'", '"',$cust_no);
		$cust_no_awal=trim(@$_POST["cust_no_awal"]);
		$cust_no_awal=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_no_awal);
		$cust_no_awal=str_replace("'", '"',$cust_no_awal);
		$cust_no_akhir=trim(@$_POST["cust_no_akhir"]);
		$cust_no_akhir=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_no_akhir);
		$cust_no_akhir=str_replace("'", '"',$cust_no_akhir);
		$cust_nama=trim(@$_POST["cust_nama"]);
		$cust_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_nama);
		$cust_nama=str_replace("'", '"',$cust_nama);
		$cust_panggilan=trim(@$_POST["cust_panggilan"]);
		$cust_panggilan=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_panggilan);
		$cust_panggilan=str_replace("'", '"',$cust_panggilan);
		$cust_foreigner=trim(@$_POST["cust_foreigner"]);
		$cust_foreigner=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_foreigner);
		$cust_foreigner=str_replace("'", '"',$cust_foreigner);
		$cust_kelamin=trim(@$_POST["cust_kelamin"]);
		$cust_kelamin=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_kelamin);
		$cust_kelamin=str_replace("'", '"',$cust_kelamin);
		$cust_alamat=trim(@$_POST["cust_alamat"]);
		$cust_alamat=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_alamat);
		$cust_alamat=str_replace("'", '"',$cust_alamat);
		$cust_alamat2=trim(@$_POST["cust_alamat2"]);
		$cust_alamat2=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_alamat2);
		$cust_alamat2=str_replace("'", '"',$cust_alamat2);
		$cust_kota=trim(@$_POST["cust_kota"]);
		$cust_kota=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_kota);
		$cust_kota=str_replace("'", '"',$cust_kota);
		$cust_kodepos=trim(@$_POST["cust_kodepos"]);
		$cust_kodepos=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_kodepos);
		$cust_kodepos=str_replace("'", '"',$cust_kodepos);
		$cust_propinsi=trim(@$_POST["cust_propinsi"]);
		$cust_propinsi=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_propinsi);
		$cust_propinsi=str_replace("'", '"',$cust_propinsi);
		$cust_negara=trim(@$_POST["cust_negara"]);
		$cust_negara=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_negara);
		$cust_negara=str_replace("'", '"',$cust_negara);
		$cust_telprumah=trim(@$_POST["cust_telprumah"]);
		$cust_telprumah=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_telprumah);
		$cust_telprumah=str_replace("'", '"',$cust_telprumah);
		$cust_telprumah2=trim(@$_POST["cust_telprumah2"]);
		$cust_telprumah2=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_telprumah2);
		$cust_telprumah2=str_replace("'", '"',$cust_telprumah2);
		$cust_telpkantor=trim(@$_POST["cust_telpkantor"]);
		$cust_telpkantor=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_telpkantor);
		$cust_telpkantor=str_replace("'", '"',$cust_telpkantor);
		$cust_hp=trim(@$_POST["cust_hp"]);
		$cust_hp=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hp);
		$cust_hp=str_replace("'", '"',$cust_hp);
		$cust_hp2=trim(@$_POST["cust_hp2"]);
		$cust_hp2=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hp2);
		$cust_hp2=str_replace("'", '"',$cust_hp2);
		$cust_hp3=trim(@$_POST["cust_hp3"]);
		$cust_hp3=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hp3);
		$cust_hp3=str_replace("'", '"',$cust_hp3);
		$cust_email=trim(@$_POST["cust_email"]);
		$cust_email=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_email);
		$cust_email=str_replace("'", '"',$cust_email);
		$cust_agama=trim(@$_POST["cust_agama"]);
		$cust_agama=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_agama);
		$cust_agama=str_replace("'", '"',$cust_agama);
		$cust_pendidikan=trim(@$_POST["cust_pendidikan"]);
		$cust_pendidikan=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_pendidikan);
		$cust_pendidikan=str_replace("'", '"',$cust_pendidikan);
		$cust_profesi=trim(@$_POST["cust_profesi"]);
		$cust_profesi=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_profesi);
		$cust_profesi=str_replace("'", '"',$cust_profesi);
		$cust_terdaftar=trim(@$_POST["cust_terdaftar"]);
		$cust_tgldaftarend =(isset($_POST['cust_tgldaftarend']) ? @$_POST['cust_tgldaftarend'] : @$_GET['cust_tgldaftarend']);
		$cust_tgldaftarend=trim(@$_POST["cust_tgldaftarend"]);
		
		$member_terdaftarstart=trim(@$_POST["member_terdaftarstart"]);
		$member_terdaftarend=trim(@$_POST["member_terdaftarend"]);
		
		$cust_tglawaltrans=trim(@$_POST["cust_tglawaltrans"]);
		$cust_tglawaltransend =(isset($_POST['cust_tglawaltrans_end']) ? @$_POST['cust_tglawaltrans_end'] : @$_GET['cust_tglawaltrans_end']);
		$cust_tglawaltransend=trim(@$_POST["cust_tglawaltrans_end"]);
		$cust_bb=trim(@$_POST["cust_bb"]);
		$cust_bb=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_bb);
		$cust_bb=str_replace("'", '"',$cust_bb);
		$cust_tgllahir =(isset($_POST['cust_tgllahir']) ? @$_POST['cust_tgllahir'] : @$_GET['cust_tgllahir']);
		$cust_tgllahirend =(isset($_POST['cust_tgllahirend']) ? @$_POST['cust_tgllahirend'] : @$_GET['cust_tgllahirend']);
		$cust_tgllahirend=trim(@$_POST["cust_tgllahirend"]);
		//$cust_hobi=trim(@$_POST["cust_hobi"]);
		//$cust_hobi=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hobi);
		//$cust_hobi=str_replace("'", '"',$cust_hobi);
		$cust_hobi_baca=trim(@$_POST["cust_hobi_baca"]);
		$cust_hobi_olah=trim(@$_POST["cust_hobi_olah"]);
		$cust_hobi_masak=trim(@$_POST["cust_hobi_masak"]);
		$cust_hobi_travel=trim(@$_POST["cust_hobi_travel"]);
		$cust_hobi_foto=trim(@$_POST["cust_hobi_foto"]);
		$cust_hobi_lukis=trim(@$_POST["cust_hobi_lukis"]);
		$cust_hobi_nari=trim(@$_POST["cust_hobi_nari"]);
		$cust_hobi_lain=trim(@$_POST["cust_hobi_lain"]);
		//$cust_hobi=trim(@$_POST["cust_hobi"]);
		//$cust_hobi=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hobi);
		//$cust_hobi=str_replace("'", '"',$cust_hobi);
		$cust_referensi=trim(@$_POST["cust_referensi"]);
		$cust_referensi=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_referensi);
		$cust_referensi=str_replace("'", '"',$cust_referensi);
		$cust_referensilain=trim(@$_POST["cust_referensilain"]);
		$cust_referensilain=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_referensilain);
		$cust_referensilain=str_replace("'", '"',$cust_referensilain);
		$cust_keterangan=trim(@$_POST["cust_keterangan"]);
		$cust_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_keterangan);
		$cust_keterangan=str_replace("'", '"',$cust_keterangan);
		$cust_member=trim(@$_POST["cust_member"]);
		$cust_member=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_member);
		$cust_member=str_replace("'", '"',$cust_member);
		$cust_member2=trim(@$_POST["cust_member2"]);
		$cust_member2=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_member2);
		$cust_member2=str_replace("'", '"',$cust_member2);
		
		$cust_statusnikah=trim(@$_POST["cust_statusnikah"]);
		$cust_statusnikah=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_statusnikah);
		$cust_statusnikah=str_replace("'", '"',$cust_statusnikah);
		$cust_priority=trim(@$_POST["cust_priority"]);
		$cust_priority=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_priority);
		$cust_priority=str_replace("'", '"',$cust_priority);
		$cust_jmlanak=trim(@$_POST["cust_jmlanak"]);
		$cust_unit=trim(@$_POST["cust_unit"]);
		$cust_unit=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_unit);
		$cust_unit=str_replace("'", '"',$cust_unit);
		$cust_aktif=trim(@$_POST["cust_aktif"]);
		$cust_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_aktif);
		$cust_aktif=str_replace("'", '"',$cust_aktif);
		$sortby=trim(@$_POST["sortby"]);
		$sortby=str_replace("/(<\/?)(p)([^>]*>)", "",$sortby);
		$sortby=str_replace("'", '"',$sortby);
		$cust_fretfulness=trim(@$_POST["cust_fretfulness"]);
		$cust_fretfulness=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_fretfulness);
		$cust_fretfulness=str_replace("'", '"',$cust_fretfulness);
		$cust_umurstart=trim(@$_POST["cust_umurstart"]);
		$cust_umurstart=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_umurstart);
		$cust_umurstart=str_replace("'", '"',$cust_umurstart);
		$cust_umurend=trim(@$_POST["cust_umurend"]);
		$cust_umurend=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_umurend);
		$cust_umurend=str_replace("'", '"',$cust_umurend);
		
		$cust_umur=trim(@$_POST["cust_umur"]);
		$cust_umur=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_umur);
		$cust_umur=str_replace("'", '"',$cust_umur);
		$cust_creator=trim(@$_POST["cust_creator"]);
		$cust_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_creator);
		$cust_creator=str_replace("'", '"',$cust_creator);
		$cust_date_create=trim(@$_POST["cust_date_create"]);
		$cust_update=trim(@$_POST["cust_update"]);
		$cust_update=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_update);
		$cust_update=str_replace("'", '"',$cust_update);
		$cust_date_update=trim(@$_POST["cust_date_update"]);
		$cust_revised=trim(@$_POST["cust_revised"]);
		
		$cust_tgl=trim(@$_POST["cust_tgl"]);
		$cust_tgl=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_tgl);
		$cust_tgl=str_replace("'", '"',$cust_tgl);
		$cust_bulan=trim(@$_POST["cust_bulan"]);
		$cust_bulan=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_bulan);
		$cust_bulan=str_replace("'", '"',$cust_bulan);
		$cust_tglEnd=trim(@$_POST["cust_tglEnd"]);
		$cust_tglEnd=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_tglEnd);
		$cust_tglEnd=str_replace("'", '"',$cust_tglEnd);
		$cust_bulanEnd=trim(@$_POST["cust_bulanEnd"]);
		$cust_bulanEnd=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_bulanEnd);
		$cust_bulanEnd=str_replace("'", '"',$cust_bulanEnd);
		
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		
		$cust_transaksi_start=trim(@$_POST["cust_transaksi_start"]);
		$cust_transaksi_end=trim(@$_POST["cust_transaksi_end"]);
		$cust_tidak_transaksi_start=trim(@$_POST["cust_tidak_transaksi_start"]);
		$cust_tidak_transaksi_end=trim(@$_POST["cust_tidak_transaksi_end"]);
		
		//$phonegroup_data=@$_POST["phonegroup_data"];
		$result=$this->m_customer->customer_phonegroup_create($query, $phonegroup_nama, $phonegroup_id, /*$phonegroup_data, */$cust_id ,$cust_no, $cust_no_awal ,$cust_no_akhir ,$cust_nama , $cust_panggilan, $cust_foreigner, $cust_kelamin ,$cust_alamat ,$cust_alamat2 ,$cust_kota ,$cust_kodepos ,$cust_propinsi ,$cust_negara ,$cust_telprumah ,$cust_telprumah2 ,$cust_telpkantor ,$cust_hp ,$cust_hp2 ,$cust_hp3 ,$cust_email ,$cust_agama ,$cust_pendidikan ,$cust_profesi ,$cust_tgllahir ,$cust_tgllahirend,$cust_referensi ,$cust_keterangan ,$cust_member ,$cust_member2, $cust_terdaftar ,$cust_tglawaltrans, $cust_statusnikah , $cust_priority , $cust_jmlanak ,$cust_unit ,$cust_aktif, $sortby,$cust_fretfulness,$cust_creator ,$cust_date_create ,$cust_update ,$cust_date_update ,$cust_revised ,$option,$filter, $cust_umurstart, $cust_umurend, $cust_umur, $cust_bb,$cust_tgldaftarend ,$cust_tglawaltransend, $cust_referensilain,$hapus_cust,$cust_transaksi_start, $cust_transaksi_end, $cust_tidak_transaksi_start, $cust_tidak_transaksi_end, $member_terdaftarstart, $member_terdaftarend,$cust_tgl, $cust_bulan,$cust_tglEnd, $cust_bulanEnd);
		echo $result;
	}
	
	function cust_note_insert(){
		/*$note_cust = isset($_POST['note_cust']) ? $_POST['note_cust'] : "";
		$note_detail=trim(@$_POST["note_detail"]);
		$note_detail=str_replace("/(<\/?)(p)([^>]*>)", "",$note_detail);
		$note_detail=str_replace("'",'"',$note_detail);
		$result=$this->m_customer->cust_note_insert($note_cust, $note_detail);
		echo $result;*/
	}
	
	//function for update record
	function customer_crm_generator_create(){
		//POST variable here
		$crmvalue_id=trim(@$_POST["crmvalue_id"]);
		$crmvalue_id=str_replace("/(<\/?)(p)([^>]*>)", "",$crmvalue_id);
		$crmvalue_id=str_replace("'", '"',$crmvalue_id);
		$crmvalue_cust=trim(@$_POST["crmvalue_cust"]);
		$crmvalue_date=trim(@$_POST["crmvalue_date"]);
		$crmvalue_frequency=trim(@$_POST["crmvalue_frequency"]);
		$crmvalue_recency=trim(@$_POST["crmvalue_recency"]);
		$crmvalue_spending=trim(@$_POST["crmvalue_spending"]);
		$crmvalue_highmargin=trim(@$_POST["crmvalue_highmargin"]);
		$crmvalue_referal=trim(@$_POST["crmvalue_referal"]);
		$crmvalue_kerewelan=trim(@$_POST["crmvalue_kerewelan"]);
		$crmvalue_disiplin=trim(@$_POST["crmvalue_disiplin"]);
		$crmvalue_treatment=trim(@$_POST["crmvalue_treatment"]);
		
		
		$crmvalue_author=trim(@$_POST["crmvalue_author"]);
		$crmvalue_author=str_replace("/(<\/?)(p)([^>]*>)", "",$crmvalue_author);
		$crmvalue_author=str_replace("'", '"',$crmvalue_author);

		$query = isset($_POST['query']) ? $_POST['query'] : "";
		
		//inisialisasi awal untuk CRM_setup
		$setcrm_frequency_count = 0; $setcrm_frequency_days = 0; $setcrm_frequency_value_lessthan = 0; $setcrm_frequency_value_equal = 0; $setcrm_frequency_value_morethan = 0; $setcrm_recency_days = 0; $setcrm_recency_value_lessthan = 0; $setcrm_recency_value_morethan = 0;	$setcrm_spending_days = 0; $setcrm_spending_value_lessthan = 0; $setcrm_spending_value_equal = 0; $setcrm_spending_value_morethan = 0; $setcrm_highmargin_treatment = 0; $setcrm_highmargin_days = 0; $setcrm_highmargin_value_morethan = 0; $setcrm_highmargin_value_equal = 0; $setcrm_highmargin_value_lessthan = 0; $setcrm_referal_person = 0; $setcrm_referal_days = 0; $setcrm_referal_morethan = 0; $setcrm_referal_equal = 0; $setcrm_referal_lessthan = 0; $setcrm_kerewelan_high = 0; $setcrm_kerewelan_normal = 0; $setcrm_kerewelan_low = 0; $setcrm_disiplin_days = 0; $setcrm_disiplin_persentase_pembatalan = 0; $setcrm_disiplin_batal_value_morethan = 0;$setcrm_disiplin_batal_value_lessthan = 0; $setcrm_disiplin_persentase_telat = 0; $setcrm_disiplin_menit_telat = 0; $setcrm_disiplin_telat_value_morethan = 0; $setcrm_disiplin_telat_value_lessthan = 0; $setcrm_treatment_days = 0; $setcrm_treatment_nonmedis = 0; $setcrm_treatment_medis = 0; $setcrm_treatment_morethan = 0; $setcrm_treatment_equal = 0; $setcrm_treatment_lessthan = 0; $setcrm_result_nilai_atas = 0; $setcrm_result_nilai_bawah  = 0;
		
		$this->m_public_function->CRM_setup($setcrm_frequency_count, $setcrm_frequency_days, $setcrm_frequency_value_lessthan, $setcrm_frequency_value_equal, $setcrm_frequency_value_morethan, $setcrm_recency_days, $setcrm_recency_value_lessthan, $setcrm_recency_value_morethan,	$setcrm_spending_days, $setcrm_spending_value_lessthan, $setcrm_spending_value_equal, $setcrm_spending_value_morethan, $setcrm_highmargin_treatment, $setcrm_highmargin_days, $setcrm_highmargin_value_morethan, $setcrm_highmargin_value_equal, $setcrm_highmargin_value_lessthan, $setcrm_referal_person, $setcrm_referal_days, $setcrm_referal_morethan, $setcrm_referal_equal, $setcrm_referal_lessthan, $setcrm_kerewelan_high, $setcrm_kerewelan_normal, $setcrm_kerewelan_low, $setcrm_disiplin_days, $setcrm_disiplin_persentase_pembatalan, $setcrm_disiplin_batal_value_morethan,$setcrm_disiplin_batal_value_lessthan, $setcrm_disiplin_persentase_telat, $setcrm_disiplin_menit_telat, $setcrm_disiplin_telat_value_morethan, $setcrm_disiplin_telat_value_lessthan, $setcrm_treatment_days, $setcrm_treatment_nonmedis, $setcrm_treatment_medis, $setcrm_treatment_morethan, $setcrm_treatment_equal, $setcrm_treatment_lessthan, $setcrm_result_nilai_atas, $setcrm_result_nilai_bawah);
		
		$result = $this->m_public_function->customer_crm_generator_create($query, $crmvalue_id, $crmvalue_cust, $crmvalue_date, $crmvalue_frequency, $crmvalue_recency, $crmvalue_spending, $crmvalue_highmargin, $crmvalue_referal, $crmvalue_kerewelan, $crmvalue_disiplin, $crmvalue_treatment, $crmvalue_author, $setcrm_frequency_count, $setcrm_frequency_days, $setcrm_frequency_value_lessthan, $setcrm_frequency_value_equal, $setcrm_frequency_value_morethan, $setcrm_recency_days, $setcrm_recency_value_lessthan, $setcrm_recency_value_morethan,	$setcrm_spending_days, $setcrm_spending_value_lessthan, $setcrm_spending_value_equal, $setcrm_spending_value_morethan, $setcrm_highmargin_treatment, $setcrm_highmargin_days, $setcrm_highmargin_value_morethan, $setcrm_highmargin_value_equal, $setcrm_highmargin_value_lessthan, $setcrm_referal_person, $setcrm_referal_days, $setcrm_referal_morethan, $setcrm_referal_equal, $setcrm_referal_lessthan, $setcrm_kerewelan_high, $setcrm_kerewelan_normal, $setcrm_kerewelan_low, $setcrm_disiplin_days, $setcrm_disiplin_persentase_pembatalan, $setcrm_disiplin_batal_value_morethan,$setcrm_disiplin_batal_value_lessthan, $setcrm_disiplin_persentase_telat, $setcrm_disiplin_menit_telat, $setcrm_disiplin_telat_value_morethan, $setcrm_disiplin_telat_value_lessthan, $setcrm_treatment_days, $setcrm_treatment_nonmedis, $setcrm_treatment_medis, $setcrm_treatment_morethan, $setcrm_treatment_equal, $setcrm_treatment_lessthan, $setcrm_result_nilai_atas, $setcrm_result_nilai_bawah);
		echo $result;
	}
	
	
	//function for update record
	function customer_crm_generator_create_all(){
		//POST variable here
	
		$crmvalue_id=trim(@$_POST["crmvalue_id"]);
		$crmvalue_id=str_replace("/(<\/?)(p)([^>]*>)", "",$crmvalue_id);
		$crmvalue_id=str_replace("'", '"',$crmvalue_id);
		$crmvalue_cust=trim(@$_POST["crmvalue_cust"]);
		$crmvalue_date=trim(@$_POST["crmvalue_date"]);
		$crmvalue_frequency=trim(@$_POST["crmvalue_frequency"]);
		$crmvalue_recency=trim(@$_POST["crmvalue_recency"]);
		$crmvalue_spending=trim(@$_POST["crmvalue_spending"]);
		$crmvalue_highmargin=trim(@$_POST["crmvalue_highmargin"]);
		$crmvalue_referal=trim(@$_POST["crmvalue_referal"]);
		$crmvalue_kerewelan=trim(@$_POST["crmvalue_kerewelan"]);
		$crmvalue_disiplin=trim(@$_POST["crmvalue_disiplin"]);
		$crmvalue_treatment=trim(@$_POST["crmvalue_treatment"]);
		
		
		$crmvalue_author=trim(@$_POST["crmvalue_author"]);
		$crmvalue_author=str_replace("/(<\/?)(p)([^>]*>)", "",$crmvalue_author);
		$crmvalue_author=str_replace("'", '"',$crmvalue_author);

		$cust_id=trim(@$_POST["cust_id"]);
		$cust_no=trim(@$_POST["cust_no"]);
		$cust_no=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_no);
		$cust_no=str_replace("'", '"',$cust_no);
		$cust_no_awal=trim(@$_POST["cust_no_awal"]);
		$cust_no_awal=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_no_awal);
		$cust_no_awal=str_replace("'", '"',$cust_no_awal);
		$cust_no_akhir=trim(@$_POST["cust_no_akhir"]);
		$cust_no_akhir=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_no_akhir);
		$cust_no_akhir=str_replace("'", '"',$cust_no_akhir);
		$cust_nama=trim(@$_POST["cust_nama"]);
		$cust_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_nama);
		$cust_nama=str_replace("'", '"',$cust_nama);
		$cust_kelamin=trim(@$_POST["cust_kelamin"]);
		$cust_kelamin=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_kelamin);
		$cust_kelamin=str_replace("'", '"',$cust_kelamin);
		$cust_alamat=trim(@$_POST["cust_alamat"]);
		$cust_alamat=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_alamat);
		$cust_alamat=str_replace("'", '"',$cust_alamat);
		$cust_alamat2=trim(@$_POST["cust_alamat2"]);
		$cust_alamat2=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_alamat2);
		$cust_alamat2=str_replace("'", '"',$cust_alamat2);
		$cust_kota=trim(@$_POST["cust_kota"]);
		$cust_kota=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_kota);
		$cust_kota=str_replace("'", '"',$cust_kota);
		$cust_kodepos=trim(@$_POST["cust_kodepos"]);
		$cust_kodepos=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_kodepos);
		$cust_kodepos=str_replace("'", '"',$cust_kodepos);
		$cust_propinsi=trim(@$_POST["cust_propinsi"]);
		$cust_propinsi=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_propinsi);
		$cust_propinsi=str_replace("'", '"',$cust_propinsi);
		$cust_negara=trim(@$_POST["cust_negara"]);
		$cust_negara=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_negara);
		$cust_negara=str_replace("'", '"',$cust_negara);
		$cust_telprumah=trim(@$_POST["cust_telprumah"]);
		$cust_telprumah=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_telprumah);
		$cust_telprumah=str_replace("'", '"',$cust_telprumah);
		$cust_telprumah2=trim(@$_POST["cust_telprumah2"]);
		$cust_telprumah2=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_telprumah2);
		$cust_telprumah2=str_replace("'", '"',$cust_telprumah2);
		$cust_telpkantor=trim(@$_POST["cust_telpkantor"]);
		$cust_telpkantor=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_telpkantor);
		$cust_telpkantor=str_replace("'", '"',$cust_telpkantor);
		$cust_hp=trim(@$_POST["cust_hp"]);
		$cust_hp=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hp);
		$cust_hp=str_replace("'", '"',$cust_hp);
		$cust_hp2=trim(@$_POST["cust_hp2"]);
		$cust_hp2=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hp2);
		$cust_hp2=str_replace("'", '"',$cust_hp2);
		$cust_hp3=trim(@$_POST["cust_hp3"]);
		$cust_hp3=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hp3);
		$cust_hp3=str_replace("'", '"',$cust_hp3);
		$cust_email=trim(@$_POST["cust_email"]);
		$cust_email=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_email);
		$cust_email=str_replace("'", '"',$cust_email);
		$cust_agama=trim(@$_POST["cust_agama"]);
		$cust_agama=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_agama);
		$cust_agama=str_replace("'", '"',$cust_agama);
		$cust_pendidikan=trim(@$_POST["cust_pendidikan"]);
		$cust_pendidikan=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_pendidikan);
		$cust_pendidikan=str_replace("'", '"',$cust_pendidikan);
		$cust_profesi=trim(@$_POST["cust_profesi"]);
		$cust_profesi=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_profesi);
		$cust_profesi=str_replace("'", '"',$cust_profesi);
		$cust_tgldaftarend =(isset($_POST['cust_tgldaftarend']) ? @$_POST['cust_tgldaftarend'] : @$_GET['cust_tgldaftarend']);
		$cust_tgldaftarend=trim(@$_POST["cust_tgldaftarend"]);
		$cust_tglawaltransend =(isset($_POST['cust_tglawaltransend']) ? @$_POST['cust_tglawaltransend'] : @$_GET['cust_tglawaltransend']);
		$cust_tglawaltransend=trim(@$_POST["cust_tglawaltransend"]);
		$cust_bb=trim(@$_POST["cust_bb"]);
		$cust_bb=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_bb);
		$cust_bb=str_replace("'", '"',$cust_bb);
		$cust_tgllahir =(isset($_POST['cust_tgllahir']) ? @$_POST['cust_tgllahir'] : @$_GET['cust_tgllahir']);
		$cust_tgllahirend =(isset($_POST['cust_tgllahirend']) ? @$_POST['cust_tgllahirend'] : @$_GET['cust_tgllahirend']);
		$cust_tgllahirend=trim(@$_POST["cust_tgllahirend"]);
		//$cust_hobi=trim(@$_POST["cust_hobi"]);
		//$cust_hobi=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hobi);
		//$cust_hobi=str_replace("'", '"',$cust_hobi);
		$cust_hobi_baca=trim(@$_POST["cust_hobi_baca"]);
		$cust_hobi_olah=trim(@$_POST["cust_hobi_olah"]);
		$cust_hobi_masak=trim(@$_POST["cust_hobi_masak"]);
		$cust_hobi_travel=trim(@$_POST["cust_hobi_travel"]);
		$cust_hobi_foto=trim(@$_POST["cust_hobi_foto"]);
		$cust_hobi_lukis=trim(@$_POST["cust_hobi_lukis"]);
		$cust_hobi_nari=trim(@$_POST["cust_hobi_nari"]);
		$cust_hobi_lain=trim(@$_POST["cust_hobi_lain"]);
		//$cust_hobi=trim(@$_POST["cust_hobi"]);
		//$cust_hobi=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hobi);
		//$cust_hobi=str_replace("'", '"',$cust_hobi);
		$cust_referensi=trim(@$_POST["cust_referensi"]);
		$cust_referensi=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_referensi);
		$cust_referensi=str_replace("'", '"',$cust_referensi);
		$cust_referensilain=trim(@$_POST["cust_referensilain"]);
		$cust_referensilain=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_referensilain);
		$cust_referensilain=str_replace("'", '"',$cust_referensilain);
		$cust_keterangan=trim(@$_POST["cust_keterangan"]);
		$cust_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_keterangan);
		$cust_keterangan=str_replace("'", '"',$cust_keterangan);
		$cust_member=trim(@$_POST["cust_member"]);
		$cust_member=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_member);
		$cust_member=str_replace("'", '"',$cust_member);
		$cust_member2=trim(@$_POST["cust_member2"]);
		$cust_member2=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_member2);
		$cust_member2=str_replace("'", '"',$cust_member2);
		$cust_terdaftar=trim(@$_POST["cust_terdaftar"]);
		$cust_tglawaltrans=trim(@$_POST["cust_tglawaltrans"]);
		$cust_statusnikah=trim(@$_POST["cust_statusnikah"]);
		$cust_statusnikah=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_statusnikah);
		$cust_statusnikah=str_replace("'", '"',$cust_statusnikah);
		$cust_priority=trim(@$_POST["cust_priority"]);
		$cust_priority=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_priority);
		$cust_priority=str_replace("'", '"',$cust_priority);
		$cust_jmlanak=trim(@$_POST["cust_jmlanak"]);
		$cust_unit=trim(@$_POST["cust_unit"]);
		$cust_unit=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_unit);
		$cust_unit=str_replace("'", '"',$cust_unit);
		$cust_aktif=trim(@$_POST["cust_aktif"]);
		$cust_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_aktif);
		$cust_aktif=str_replace("'", '"',$cust_aktif);
		$sortby=trim(@$_POST["sortby"]);
		$sortby=str_replace("/(<\/?)(p)([^>]*>)", "",$sortby);
		$sortby=str_replace("'", '"',$sortby);
		$cust_fretfulness=trim(@$_POST["cust_fretfulness"]);
		$cust_fretfulness=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_fretfulness);
		$cust_fretfulness=str_replace("'", '"',$cust_fretfulness);
		$cust_umurstart=trim(@$_POST["cust_umurstart"]);
		$cust_umurstart=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_umurstart);
		$cust_umurstart=str_replace("'", '"',$cust_umurstart);
		$cust_umurend=trim(@$_POST["cust_umurend"]);
		$cust_umurend=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_umurend);
		$cust_umurend=str_replace("'", '"',$cust_umurend);
		
		$cust_umur=trim(@$_POST["cust_umur"]);
		$cust_umur=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_umur);
		$cust_umur=str_replace("'", '"',$cust_umur);
		$cust_tgl=trim(@$_POST["cust_tgl"]);
		$cust_tgl=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_tgl);
		$cust_tgl=str_replace("'", '"',$cust_tgl);
		$cust_bulan=trim(@$_POST["cust_bulan"]);
		$cust_bulan=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_bulan);
		$cust_bulan=str_replace("'", '"',$cust_bulan);
		$cust_creator=trim(@$_POST["cust_creator"]);
		$cust_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_creator);
		$cust_creator=str_replace("'", '"',$cust_creator);
		$cust_date_create=trim(@$_POST["cust_date_create"]);
		$cust_update=trim(@$_POST["cust_update"]);
		$cust_update=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_update);
		$cust_update=str_replace("'", '"',$cust_update);
		$cust_date_update=trim(@$_POST["cust_date_update"]);
		$cust_revised=trim(@$_POST["cust_revised"]);
		
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		
		if($query==''){
			$option='SEARCH';
		}
		else{
			$option='LIST';
		}
		
		list($hasil) = $this->m_public_function->CRM_setup();
	
		$result = $this->m_public_function->customer_crm_generator_create_all($query, $crmvalue_id, $crmvalue_cust, $crmvalue_date, $crmvalue_frequency, $crmvalue_recency, $crmvalue_spending, $crmvalue_highmargin, $crmvalue_referal, $crmvalue_kerewelan, $crmvalue_disiplin, $crmvalue_treatment, $crmvalue_author,$cust_id ,$cust_no, $cust_no_awal ,$cust_no_akhir ,$cust_nama ,$cust_kelamin ,$cust_alamat ,$cust_alamat2 ,$cust_kota ,$cust_kodepos ,$cust_propinsi ,$cust_negara ,$cust_telprumah ,$cust_telprumah2 ,$cust_telpkantor ,$cust_hp ,$cust_hp2 ,$cust_hp3 ,$cust_email ,$cust_agama ,$cust_pendidikan ,$cust_profesi ,$cust_tgllahir ,$cust_tgllahirend,$cust_referensi ,$cust_keterangan ,$cust_member ,$cust_member2, $cust_terdaftar ,$cust_tglawaltrans, $cust_statusnikah , $cust_priority , $cust_jmlanak ,$cust_unit ,$cust_aktif, $sortby,$cust_fretfulness,$cust_creator ,$cust_date_create ,$cust_update ,$cust_date_update ,$cust_revised ,$option,$filter, $cust_umurstart, $cust_umurend, $cust_umur,$cust_tgl, $cust_bulan, $cust_bb,$cust_tgldaftarend, $cust_tglawaltransend, $cust_referensilain, $hasil[0], $hasil[1], $hasil[2], $hasil[3], $hasil[4], $hasil[5], $hasil[6], $hasil[7], $hasil[8], $hasil[9], $hasil[10], $hasil[11], $hasil[12], $hasil[13], $hasil[14], $hasil[15], $hasil[16], $hasil[17], $hasil[18], $hasil[19], $hasil[20], $hasil[21], $hasil[22], $hasil[23], $hasil[24], $hasil[25], $hasil[26], $hasil[27], $hasil[28], $hasil[29], $hasil[30], $hasil[31], $hasil[32], $hasil[33], $hasil[34], $hasil[35], $hasil[36], $hasil[37], $hasil[38], $hasil[39], $hasil[40]);
		echo $result;
	}
	
	//function fot list record
	function customer_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);

		$result=$this->m_customer->customer_list($query,$start,$end);
		echo $result;
	}
	
	//function fot list record
	function phonegroup_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);

		$result=$this->m_customer->phonegroup_list($query,$start,$end);
		echo $result;
	}
	
	function get_propinsi_list(){
		
		$result=$this->m_public_function->get_propinsi_list();
		echo $result;
	}
	
	
	//function for update record
	function customer_update(){
		//POST variable here
		$cust_id=trim(@$_POST["cust_id"]);
		$cust_no=trim(@$_POST["cust_no"]);
		$cust_no=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_no);
		$cust_no=str_replace("'", '"',$cust_no);
		$cust_nolama=trim(@$_POST["cust_nolama"]);
		$cust_nolama=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_nolama);
		$cust_nolama=str_replace("'", '"',$cust_nolama);
		$cust_nama=trim(@$_POST["cust_nama"]);
		$cust_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_nama);
		$cust_nama=str_replace("'", '"',$cust_nama);
		$cust_title=trim(@$_POST["cust_title"]);
		$cust_title=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_title);
		$cust_title=str_replace("'", '"',$cust_title);
		$cust_panggilan=trim(@$_POST["cust_panggilan"]);
		$cust_panggilan=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_panggilan);
		$cust_panggilan=str_replace("'", '"',$cust_panggilan);
		$cust_foreigner=trim(@$_POST["cust_foreigner"]);
		$cust_foreigner=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_foreigner);
		$cust_foreigner=str_replace("'", '"',$cust_foreigner);
		$cust_kelamin=trim(@$_POST["cust_kelamin"]);
		$cust_kelamin=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_kelamin);
		$cust_kelamin=str_replace("'", '"',$cust_kelamin);
		$cust_alamat=trim(@$_POST["cust_alamat"]);
		$cust_alamat=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_alamat);
		$cust_alamat=str_replace("'", '"',$cust_alamat);
		$cust_kota=trim(@$_POST["cust_kota"]);
		$cust_kota=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_kota);
		$cust_kota=str_replace("'", '"',$cust_kota);
		$cust_kodepos=trim(@$_POST["cust_kodepos"]);
		$cust_kodepos=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_kodepos);
		$cust_kodepos=str_replace("'", '"',$cust_kodepos);
		$cust_propinsi=trim(@$_POST["cust_propinsi"]);
		$cust_propinsi=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_propinsi);
		$cust_propinsi=str_replace("'", '"',$cust_propinsi);
		$cust_negara=trim(@$_POST["cust_negara"]);
		$cust_negara=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_negara);
		$cust_negara=str_replace("'", '"',$cust_negara);
		$cust_alamat2=trim(@$_POST["cust_alamat2"]);
		$cust_alamat2=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_alamat2);
		$cust_alamat2=str_replace("'", '"',$cust_alamat2);
		$cust_kota2=trim(@$_POST["cust_kota2"]);
		$cust_kota2=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_kota2);
		$cust_kota2=str_replace("'", '"',$cust_kota2);
		$cust_kodepos2=trim(@$_POST["cust_kodepos2"]);
		$cust_kodepos2=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_kodepos2);
		$cust_kodepos2=str_replace("'", '"',$cust_kodepos2);
		$cust_propinsi2=trim(@$_POST["cust_propinsi2"]);
		$cust_propinsi2=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_propinsi2);
		$cust_propinsi2=str_replace("'", '"',$cust_propinsi2);
		$cust_negara2=trim(@$_POST["cust_negara2"]);
		$cust_negara2=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_negara2);
		$cust_negara2=str_replace("'", '"',$cust_negara2);
		$cust_telprumah=trim(@$_POST["cust_telprumah"]);
		$cust_telprumah=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_telprumah);
		$cust_telprumah=str_replace("'", '"',$cust_telprumah);
		$cust_telprumah2=trim(@$_POST["cust_telprumah2"]);
		$cust_telprumah2=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_telprumah2);
		$cust_telprumah2=str_replace("'", '"',$cust_telprumah2);
		$cust_telpkantor=trim(@$_POST["cust_telpkantor"]);
		$cust_telpkantor=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_telpkantor);
		$cust_telpkantor=str_replace("'", '"',$cust_telpkantor);
		$cust_hp=trim(@$_POST["cust_hp"]);
		$cust_hp=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hp);
		$cust_hp=str_replace("'", '"',$cust_hp);
		$cust_hp2=trim(@$_POST["cust_hp2"]);
		$cust_hp2=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hp2);
		$cust_hp2=str_replace("'", '"',$cust_hp2);
		$cust_hp3=trim(@$_POST["cust_hp3"]);
		$cust_hp3=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hp3);
		$cust_hp3=str_replace("'", '"',$cust_hp3);
		$cust_bb=trim(@$_POST["cust_bb"]);
		$cust_bb=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_bb);
		$cust_bb=str_replace("'", '"',$cust_bb);
		$cust_email=trim(@$_POST["cust_email"]);
		$cust_email=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_email);
		$cust_email=str_replace("'", '"',$cust_email);
		$cust_fb=trim(@$_POST["cust_fb"]);
		$cust_tweeter=trim(@$_POST["cust_tweeter"]);
		$cust_email2=trim(@$_POST["cust_email2"]);
		$cust_email2=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_email2);
		$cust_email2=str_replace("'", '"',$cust_email2);
		$cust_fb2=trim(@$_POST["cust_fb2"]);
		$cust_tweeter2=trim(@$_POST["cust_tweeter2"]);
		$cust_agama=trim(@$_POST["cust_agama"]);
		$cust_agama=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_agama);
		$cust_agama=str_replace("'", '"',$cust_agama);
		$cust_pendidikan=trim(@$_POST["cust_pendidikan"]);
		$cust_pendidikan=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_pendidikan);
		$cust_pendidikan=str_replace("'", '"',$cust_pendidikan);
		$cust_profesitxt=trim(@$_POST["cust_profesitxt"]);
		$cust_profesitxt=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_profesitxt);
		$cust_profesitxt=str_replace("'", '"',$cust_profesitxt);
		if($cust_profesitxt<>"")
			$cust_profesi=$cust_profesitxt;
		else
			$cust_profesi=$_POST["cust_profesi"];
		$cust_tmptlahir=trim(@$_POST["cust_tmptlahir"]);
		$cust_tmptlahir=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_tmptlahir);
		$cust_tmptlahir=str_replace("'", '"',$cust_tmptlahir);
		$cust_tgllahir=trim(@$_POST["cust_tgllahir"]);
		//$cust_tgllahirend=trim(@$_POST["cust_tgllahirend"]);
		$cust_hobitxt=trim(@$_POST["cust_hobitxt"]);
		$cust_hobitxt=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hobitxt);
		$cust_hobitxt=str_replace("'", '"',$cust_hobitxt);
		/*if($cust_hobitxt<>"")
			$cust_hobi=$cust_hobitxt;
		else
			$cust_hobi=$_POST["cust_hobi"];*/
		$cust_hobi_baca=trim(@$_POST["cust_hobi_baca"]);
		$cust_hobi_baca=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hobi_baca);
		$cust_hobi_baca=str_replace("'", '"',$cust_hobi_baca);
		$cust_hobi_olah=trim(@$_POST["cust_hobi_olah"]);
		$cust_hobi_olah=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hobi_olah);
		$cust_hobi_olah=str_replace("'", '"',$cust_hobi_olah);
		$cust_hobi_masak=trim(@$_POST["cust_hobi_masak"]);
		$cust_hobi_masak=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hobi_masak);
		$cust_hobi_masak=str_replace("'", '"',$cust_hobi_masak);
		$cust_hobi_travel=trim(@$_POST["cust_hobi_travel"]);
		$cust_hobi_travel=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hobi_travel);
		$cust_hobi_travel=str_replace("'", '"',$cust_hobi_travel);
		$cust_hobi_foto=trim(@$_POST["cust_hobi_foto"]);
		$cust_hobi_foto=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hobi_foto);
		$cust_hobi_foto=str_replace("'", '"',$cust_hobi_foto);
		$cust_hobi_lukis=trim(@$_POST["cust_hobi_lukis"]);
		$cust_hobi_lukis=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hobi_lukis);
		$cust_hobi_lukis=str_replace("'", '"',$cust_hobi_lukis);
		$cust_hobi_nari=trim(@$_POST["cust_hobi_nari"]);
		$cust_hobi_nari=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hobi_nari);
		$cust_hobi_nari=str_replace("'", '"',$cust_hobi_nari);
		$cust_hobi_lain=trim(@$_POST["cust_hobi_lain"]);
		$cust_hobi_lain=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hobi_lain);
		$cust_hobi_lain=str_replace("'", '"',$cust_hobi_lain);
		
			
		$cust_referensi=trim(@$_POST["cust_referensi"]);
		$cust_referensi=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_referensi);
		$cust_referensi=str_replace("'", '"',$cust_referensi);
		$cust_referensilaintxt=trim(@$_POST["cust_referensilaintxt"]);
		$cust_referensilaintxt=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_referensilaintxt);
		$cust_referensilaintxt=str_replace("'", '"',$cust_referensilaintxt);
		if($cust_referensilaintxt<>"")
			$cust_referensilain=$cust_referensilaintxt;
		else
			$cust_referensilain=$_POST["cust_referensilain"];
		$cust_keterangan=trim(@$_POST["cust_keterangan"]);
		$cust_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_keterangan);
		$cust_keterangan=str_replace("'", '"',$cust_keterangan);
		$cust_member=trim(@$_POST["cust_member"]);
		$cust_member=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_member);
		$cust_member=str_replace("'", '"',$cust_member);
		$cust_terdaftar=trim(@$_POST["cust_terdaftar"]);
		$cust_tglawaltrans=trim(@$_POST["cust_tglawaltrans"]);
		$cust_statusnikah=trim(@$_POST["cust_statusnikah"]);
		$cust_statusnikah=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_statusnikah);
		$cust_statusnikah=str_replace("'", '"',$cust_statusnikah);
		//$cust_priority=trim(@$_POST["cust_priority"]);
		//$cust_priority=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_priority);
		//$cust_priority=str_replace("'", '"',$cust_priority);
		$cust_jmlanak=trim(@$_POST["cust_jmlanak"]);
		$cust_unit=trim(@$_POST["cust_unit"]);
		$cust_unit=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_unit);
		$cust_unit=str_replace("'", '"',$cust_unit);
		$cust_aktif=trim(@$_POST["cust_aktif"]);
		$cust_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_aktif);
		$cust_aktif=str_replace("'", '"',$cust_aktif);
		$cust_fretfulness=trim(@$_POST["cust_fretfulness"]);
		$cust_fretfulness=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_fretfulness);
		$cust_fretfulness=str_replace("'", '"',$cust_fretfulness);
		$cust_creator=trim(@$_POST["cust_creator"]);
		$cust_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_creator);
		$cust_creator=str_replace("'", '"',$cust_creator);
		$cust_date_create=trim(@$_POST["cust_date_create"]);
		$cust_update=trim(@$_POST["cust_update"]);
		$cust_update=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_update);
		$cust_update=str_replace("'", '"',$cust_update);
		$cust_date_update=trim(@$_POST["cust_date_update"]);
		$cust_revised=trim(@$_POST["cust_revised"]);
		$cust_cp=trim(@$_POST["cust_cp"]);
		$cust_cp=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_cp);
		$cust_cp=str_replace("'", '"',$cust_cp);
		$cust_cptelp=trim(@$_POST["cust_cptelp"]);
		$cust_cptelp=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_cptelp);
		$cust_cptelp=str_replace("'", '"',$cust_cptelp);
		$result = $this->m_customer->customer_update($cust_id ,$cust_no ,$cust_nolama ,$cust_nama, $cust_title, $cust_panggilan, $cust_foreigner ,$cust_kelamin ,$cust_alamat ,$cust_kota ,$cust_kodepos ,$cust_propinsi ,$cust_negara,$cust_alamat2 ,$cust_kota2 ,$cust_kodepos2 ,$cust_propinsi2 ,$cust_negara2 ,$cust_telprumah ,$cust_telprumah2 ,$cust_telpkantor ,$cust_hp ,$cust_hp2 ,$cust_hp3 ,$cust_email ,$cust_fb ,$cust_tweeter , $cust_email2 ,$cust_fb2 ,$cust_tweeter2 ,$cust_agama ,$cust_pendidikan ,$cust_profesi ,$cust_tmptlahir ,$cust_tgllahir ,$cust_referensi, $cust_referensilain ,$cust_keterangan ,$cust_member ,$cust_terdaftar ,$cust_tglawaltrans, $cust_statusnikah , /*$cust_priority , */$cust_jmlanak ,$cust_unit ,$cust_aktif , $cust_fretfulness, $cust_creator ,$cust_date_create ,$cust_update ,$cust_date_update ,$cust_revised ,$cust_cp ,$cust_cptelp, $cust_hobi_baca, $cust_hobi_olah, $cust_hobi_masak, $cust_hobi_travel, $cust_hobi_foto, $cust_hobi_lukis, $cust_hobi_nari, $cust_hobi_lain, $cust_bb );
		echo $result;
	}
	
	//function for create new record
	function customer_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$cust_id=trim(@$_POST["cust_id"]);
		$cust_no=trim(@$_POST["cust_no"]);
		$cust_no=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_no);
		$cust_no=str_replace("'", '"',$cust_no);
		$cust_nolama=trim(@$_POST["cust_nolama"]);
		$cust_nolama=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_nolama);
		$cust_nolama=str_replace("'", '"',$cust_nolama);
		$cust_nama=trim(@$_POST["cust_nama"]);
		$cust_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_nama);
		$cust_nama=str_replace("'", '"',$cust_nama);
		$cust_title=trim(@$_POST["cust_title"]);
		$cust_title=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_title);
		$cust_title=str_replace("'", '"',$cust_title);
		$cust_panggilan=trim(@$_POST["cust_panggilan"]);
		$cust_panggilan=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_panggilan);
		$cust_panggilan=str_replace("'", '"',$cust_panggilan);
		$cust_foreigner=trim(@$_POST["cust_foreigner"]);
		$cust_foreigner=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_foreigner);
		$cust_foreigner=str_replace("'", '"',$cust_foreigner);
		$cust_kelamin=trim(@$_POST["cust_kelamin"]);
		$cust_kelamin=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_kelamin);
		$cust_kelamin=str_replace("'", '"',$cust_kelamin);
		$cust_alamat=trim(@$_POST["cust_alamat"]);
		$cust_alamat=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_alamat);
		$cust_alamat=str_replace("'", '"',$cust_alamat);
		$cust_kota=trim(@$_POST["cust_kota"]);
		$cust_kota=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_kota);
		$cust_kota=str_replace("'", '"',$cust_kota);
		$cust_kodepos=trim(@$_POST["cust_kodepos"]);
		$cust_kodepos=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_kodepos);
		$cust_kodepos=str_replace("'", '"',$cust_kodepos);
		$cust_propinsi=trim(@$_POST["cust_propinsi"]);
		$cust_propinsi=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_propinsi);
		$cust_propinsi=str_replace("'", '"',$cust_propinsi);
		$cust_negara=trim(@$_POST["cust_negara"]);
		$cust_negara=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_negara);
		$cust_negara=str_replace("'", '"',$cust_negara);
		$cust_alamat2=trim(@$_POST["cust_alamat2"]);
		$cust_alamat2=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_alamat2);
		$cust_alamat2=str_replace("'", '"',$cust_alamat2);
		$cust_kota2=trim(@$_POST["cust_kota2"]);
		$cust_kota2=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_kota2);
		$cust_kota2=str_replace("'", '"',$cust_kota2);
		$cust_kodepos2=trim(@$_POST["cust_kodepos2"]);
		$cust_kodepos2=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_kodepos2);
		$cust_kodepos2=str_replace("'", '"',$cust_kodepos2);
		$cust_propinsi2=trim(@$_POST["cust_propinsi2"]);
		$cust_propinsi2=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_propinsi2);
		$cust_propinsi2=str_replace("'", '"',$cust_propinsi2);
		$cust_negara2=trim(@$_POST["cust_negara2"]);
		$cust_negara2=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_negara2);
		$cust_negara2=str_replace("'", '"',$cust_negara2);
		$cust_telprumah=trim(@$_POST["cust_telprumah"]);
		$cust_telprumah=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_telprumah);
		$cust_telprumah=str_replace("'", '"',$cust_telprumah);
		$cust_telprumah2=trim(@$_POST["cust_telprumah2"]);
		$cust_telprumah2=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_telprumah2);
		$cust_telprumah2=str_replace("'", '"',$cust_telprumah2);
		$cust_telpkantor=trim(@$_POST["cust_telpkantor"]);
		$cust_telpkantor=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_telpkantor);
		$cust_telpkantor=str_replace("'", '"',$cust_telpkantor);
		$cust_hp=trim(@$_POST["cust_hp"]);
		$cust_hp=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hp);
		$cust_hp=str_replace("'", '"',$cust_hp);
		$cust_hp2=trim(@$_POST["cust_hp2"]);
		$cust_hp2=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hp2);
		$cust_hp2=str_replace("'", '"',$cust_hp2);
		$cust_hp3=trim(@$_POST["cust_hp3"]);
		$cust_hp3=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hp3);
		$cust_hp3=str_replace("'", '"',$cust_hp3);
		$cust_bb=trim(@$_POST["cust_bb"]);
		$cust_bb=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_bb);
		$cust_bb=str_replace("'", '"',$cust_bb);
		$cust_email=trim(@$_POST["cust_email"]);
		$cust_email=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_email);
		$cust_email=str_replace("'", '"',$cust_email);
		$cust_fb=trim(@$_POST["cust_fb"]);
		$cust_tweeter=trim(@$_POST["cust_tweeter"]);
		$cust_email2=trim(@$_POST["cust_email2"]);
		$cust_email2=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_email2);
		$cust_email2=str_replace("'", '"',$cust_email2);
		$cust_fb2=trim(@$_POST["cust_fb2"]);
		$cust_tweeter2=trim(@$_POST["cust_tweeter2"]);
		$cust_agama=trim(@$_POST["cust_agama"]);
		$cust_agama=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_agama);
		$cust_agama=str_replace("'", '"',$cust_agama);
		$cust_pendidikan=trim(@$_POST["cust_pendidikan"]);
		$cust_pendidikan=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_pendidikan);
		$cust_pendidikan=str_replace("'", '"',$cust_pendidikan);
		$cust_profesitxt=trim(@$_POST["cust_profesitxt"]);
		$cust_profesitxt=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_profesitxt);
		$cust_profesitxt=str_replace("'", '"',$cust_profesitxt);
		if($cust_profesitxt<>"")
			$cust_profesi=$cust_profesitxt;
		else
			$cust_profesi=trim(@$_POST["cust_profesi"]);
		$cust_tmptlahir=trim(@$_POST["cust_tmptlahir"]);
		$cust_tmptlahir=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_tmptlahir);
		$cust_tmptlahir=str_replace("'", '"',$cust_tmptlahir);
		$cust_tgllahir=trim(@$_POST["cust_tgllahir"]);
		//$cust_tgllahirend=trim(@$_POST["cust_tgllahirend"]);
		$cust_hobitxt=trim(@$_POST["cust_hobitxt"]);
		$cust_hobitxt=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hobitxt);
		$cust_hobitxt=str_replace("'", '"',$cust_hobitxt);
		/*if($cust_hobitxt<>"")
			$cust_hobi=$cust_hobitxt;
		else
			$cust_hobi=trim(@$_POST["cust_hobi"]);*/
		$cust_hobi_baca=trim(@$_POST["cust_hobi_baca"]);
		$cust_hobi_baca=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hobi_baca);
		$cust_hobi_baca=str_replace("'", '"',$cust_hobi_baca);
		$cust_hobi_olah=trim(@$_POST["cust_hobi_olah"]);
		$cust_hobi_olah=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hobi_olah);
		$cust_hobi_olah=str_replace("'", '"',$cust_hobi_olah);
		$cust_hobi_masak=trim(@$_POST["cust_hobi_masak"]);
		$cust_hobi_masak=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hobi_masak);
		$cust_hobi_masak=str_replace("'", '"',$cust_hobi_masak);
		$cust_hobi_travel=trim(@$_POST["cust_hobi_travel"]);
		$cust_hobi_travel=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hobi_travel);
		$cust_hobi_travel=str_replace("'", '"',$cust_hobi_travel);
		$cust_hobi_foto=trim(@$_POST["cust_hobi_foto"]);
		$cust_hobi_foto=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hobi_foto);
		$cust_hobi_foto=str_replace("'", '"',$cust_hobi_foto);
		$cust_hobi_lukis=trim(@$_POST["cust_hobi_lukis"]);
		$cust_hobi_lukis=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hobi_lukis);
		$cust_hobi_lukis=str_replace("'", '"',$cust_hobi_lukis);
		$cust_hobi_nari=trim(@$_POST["cust_hobi_nari"]);
		$cust_hobi_nari=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hobi_nari);
		$cust_hobi_nari=str_replace("'", '"',$cust_hobi_nari);
		$cust_hobi_lain=trim(@$_POST["cust_hobi_lain"]);
		$cust_hobi_lain=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hobi_lain);
		$cust_hobi_lain=str_replace("'", '"',$cust_hobi_lain);
		$cust_referensi=trim(@$_POST["cust_referensi"]);
		$cust_referensi=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_referensi);
		$cust_referensi=str_replace("'", '"',$cust_referensi);
		$cust_referensilaintxt=trim(@$_POST["cust_referensilaintxt"]);
		$cust_referensilaintxt=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_referensilaintxt);
		$cust_referensilaintxt=str_replace("'", '"',$cust_referensilaintxt);
		if($cust_referensilaintxt<>"")
			$cust_referensilain=$cust_referensilaintxt;
		else
			$cust_referensilain=trim(@$_POST["cust_referensilain"]);
		$cust_keterangan=trim(@$_POST["cust_keterangan"]);
		$cust_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_keterangan);
		$cust_keterangan=str_replace("'", '"',$cust_keterangan);
		$cust_member=trim(@$_POST["cust_member"]);
		$cust_member=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_member);
		$cust_member=str_replace("'", '"',$cust_member);
		$cust_terdaftar=trim(@$_POST["cust_terdaftar"]);
		$cust_tglawaltrans=trim(@$_POST["cust_tglawaltrans"]);
		$cust_statusnikah=trim(@$_POST["cust_statusnikah"]);
		$cust_statusnikah=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_statusnikah);
		$cust_statusnikah=str_replace("'", '"',$cust_statusnikah);
		//$cust_priority=trim(@$_POST["cust_priority"]);
		//$cust_priority=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_priority);
		//$cust_priority=str_replace("'", '"',$cust_priority);
		$cust_jmlanak=trim(@$_POST["cust_jmlanak"]);
		$cust_unit=trim(@$_POST["cust_unit"]);
		$cust_unit=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_unit);
		$cust_unit=str_replace("'", '"',$cust_unit);
		$cust_aktif=trim(@$_POST["cust_aktif"]);
		$cust_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_aktif);
		$cust_aktif=str_replace("'", '"',$cust_aktif);
		$cust_fretfulness=trim(@$_POST["cust_fretfulness"]);
		$cust_fretfulness=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_fretfulness);
		$cust_fretfulness=str_replace("'", '"',$cust_fretfulness);
		$cust_creator=trim(@$_POST["cust_creator"]);
		$cust_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_creator);
		$cust_creator=str_replace("'", '"',$cust_creator);
		$cust_date_create=trim(@$_POST["cust_date_create"]);
		$cust_update=trim(@$_POST["cust_update"]);
		$cust_update=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_update);
		$cust_update=str_replace("'", '"',$cust_update);
		$cust_date_update=trim(@$_POST["cust_date_update"]);
		$cust_revised=trim(@$_POST["cust_revised"]);
		$cust_cp=trim(@$_POST["cust_cp"]);
		$cust_cp=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_cp);
		$cust_cp=str_replace("'", '"',$cust_cp);
		$cust_cptelp=trim(@$_POST["cust_cptelp"]);
		$cust_cptelp=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_cptelp);
		$cust_cptelp=str_replace("'", '"',$cust_cptelp);
		
		$cust_umurstart=trim(@$_POST["cust_umurstart"]);
		$cust_umurstart=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_umurstart);
		$cust_umurstart=str_replace("'", '"',$cust_umurstart);
		$cust_umurend=trim(@$_POST["cust_umurend"]);
		$cust_umurend=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_umurend);
		$cust_umurend=str_replace("'", '"',$cust_umurend);
		
		$cust_umur=trim(@$_POST["cust_umur"]);
		$cust_umur=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_umur);
		$cust_umur=str_replace("'", '"',$cust_umur);
		
		$result = $this->m_customer->customer_create($cust_no ,$cust_nolama ,$cust_nama, $cust_title, $cust_panggilan, $cust_foreigner, $cust_kelamin, $cust_alamat ,$cust_kota ,$cust_kodepos ,$cust_propinsi ,$cust_negara,$cust_alamat2 ,$cust_kota2 ,$cust_kodepos2 ,$cust_propinsi2 ,$cust_negara2 ,$cust_telprumah ,$cust_telprumah2 ,$cust_telpkantor ,$cust_hp ,$cust_hp2 ,$cust_hp3 ,$cust_email ,$cust_fb ,$cust_tweeter , $cust_email2 ,$cust_fb2 ,$cust_tweeter2 ,$cust_agama ,$cust_pendidikan ,$cust_profesi ,$cust_tmptlahir ,$cust_tgllahir ,$cust_referensi, $cust_referensilain ,$cust_keterangan ,$cust_member ,$cust_terdaftar ,$cust_tglawaltrans, $cust_statusnikah , /*$cust_priority ,*/ $cust_jmlanak ,$cust_unit ,$cust_aktif , $cust_fretfulness, $cust_creator ,$cust_date_create ,$cust_update ,$cust_date_update ,$cust_revised ,$cust_cp ,$cust_cptelp, $cust_hobi_baca, $cust_hobi_olah, $cust_hobi_masak, $cust_hobi_travel, $cust_hobi_foto, $cust_hobi_lukis, $cust_hobi_nari, $cust_hobi_lain, $cust_umurstart, $cust_umurend, $cust_umur, $cust_bb  );
		echo $result;
	}
	
	//function for delete selected record
	function customer_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_customer->customer_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function customer_search(){
		//POST varibale here
		$cust_id=trim(@$_POST["cust_id"]);
		$cust_no=trim(@$_POST["cust_no"]);
		$cust_no=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_no);
		$cust_no=str_replace("'", '"',$cust_no);
		$cust_no_awal=trim(@$_POST["cust_no_awal"]);
		$cust_no_awal=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_no_awal);
		$cust_no_awal=str_replace("'", '"',$cust_no_awal);
		$cust_no_akhir=trim(@$_POST["cust_no_akhir"]);
		$cust_no_akhir=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_no_akhir);
		$cust_no_akhir=str_replace("'", '"',$cust_no_akhir);
		$cust_nama=trim(@$_POST["cust_nama"]);
		$cust_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_nama);
		$cust_nama=str_replace("'", '"',$cust_nama);
		$cust_panggilan=trim(@$_POST["cust_panggilan"]);
		$cust_panggilan=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_panggilan);
		$cust_panggilan=str_replace("'", '"',$cust_panggilan);
		$cust_foreigner=trim(@$_POST["cust_foreigner"]);
		$cust_foreigner=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_foreigner);
		$cust_foreigner=str_replace("'", '"',$cust_foreigner);
		$cust_kelamin=trim(@$_POST["cust_kelamin"]);
		$cust_kelamin=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_kelamin);
		$cust_kelamin=str_replace("'", '"',$cust_kelamin);
		$cust_alamat=trim(@$_POST["cust_alamat"]);
		$cust_alamat=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_alamat);
		$cust_alamat=str_replace("'", '"',$cust_alamat);
		$cust_alamat2=trim(@$_POST["cust_alamat2"]);
		$cust_alamat2=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_alamat2);
		$cust_alamat2=str_replace("'", '"',$cust_alamat2);
		$cust_kota=trim(@$_POST["cust_kota"]);
		$cust_kota=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_kota);
		$cust_kota=str_replace("'", '"',$cust_kota);
		$cust_kodepos=trim(@$_POST["cust_kodepos"]);
		$cust_kodepos=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_kodepos);
		$cust_kodepos=str_replace("'", '"',$cust_kodepos);
		$cust_propinsi=trim(@$_POST["cust_propinsi"]);
		$cust_propinsi=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_propinsi);
		$cust_propinsi=str_replace("'", '"',$cust_propinsi);
		$cust_negara=trim(@$_POST["cust_negara"]);
		$cust_negara=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_negara);
		$cust_negara=str_replace("'", '"',$cust_negara);
		$cust_telprumah=trim(@$_POST["cust_telprumah"]);
		$cust_telprumah=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_telprumah);
		$cust_telprumah=str_replace("'", '"',$cust_telprumah);
		$cust_telprumah2=trim(@$_POST["cust_telprumah2"]);
		$cust_telprumah2=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_telprumah2);
		$cust_telprumah2=str_replace("'", '"',$cust_telprumah2);
		$cust_telpkantor=trim(@$_POST["cust_telpkantor"]);
		$cust_telpkantor=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_telpkantor);
		$cust_telpkantor=str_replace("'", '"',$cust_telpkantor);
		$cust_hp=trim(@$_POST["cust_hp"]);
		$cust_hp=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hp);
		$cust_hp=str_replace("'", '"',$cust_hp);
		$cust_hp2=trim(@$_POST["cust_hp2"]);
		$cust_hp2=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hp2);
		$cust_hp2=str_replace("'", '"',$cust_hp2);
		$cust_hp3=trim(@$_POST["cust_hp3"]);
		$cust_hp3=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hp3);
		$cust_hp3=str_replace("'", '"',$cust_hp3);
		$cust_email=trim(@$_POST["cust_email"]);
		$cust_email=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_email);
		$cust_email=str_replace("'", '"',$cust_email);
		$cust_agama=trim(@$_POST["cust_agama"]);
		$cust_agama=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_agama);
		$cust_agama=str_replace("'", '"',$cust_agama);
		$cust_pendidikan=trim(@$_POST["cust_pendidikan"]);
		$cust_pendidikan=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_pendidikan);
		$cust_pendidikan=str_replace("'", '"',$cust_pendidikan);
		$cust_profesi=trim(@$_POST["cust_profesi"]);
		$cust_profesi=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_profesi);
		$cust_profesi=str_replace("'", '"',$cust_profesi);
		$cust_tgllahir=trim(@$_POST["cust_tgllahir"]);
		$cust_tgllahirend =(isset($_POST['cust_tgllahirend']) ? @$_POST['cust_tgllahirend'] : @$_GET['cust_tgllahirend']);
		$cust_tgllahirend=trim(@$_POST["cust_tgllahirend"]);
		$cust_umur=trim(@$_POST["cust_umur"]);
		
		$cust_hobi_baca=trim(@$_POST["cust_hobi_baca"]);
		$cust_hobi_olah=trim(@$_POST["cust_hobi_olah"]);
		$cust_hobi_masak=trim(@$_POST["cust_hobi_masak"]);
		$cust_hobi_travel=trim(@$_POST["cust_hobi_travel"]);
		$cust_hobi_foto=trim(@$_POST["cust_hobi_foto"]);
		$cust_hobi_lukis=trim(@$_POST["cust_hobi_lukis"]);
		$cust_hobi_nari=trim(@$_POST["cust_hobi_nari"]);
		$cust_hobi_lain=trim(@$_POST["cust_hobi_lain"]);
		$cust_referensi=trim(@$_POST["cust_referensi"]);
		$cust_referensi=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_referensi);
		$cust_referensi=str_replace("'", '"',$cust_referensi);
		$cust_referensilain=trim(@$_POST["cust_referensilain"]);
		$cust_referensilain=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_referensilain);
		$cust_referensilain=str_replace("'", '"',$cust_referensilain);
		$cust_keterangan=trim(@$_POST["cust_keterangan"]);
		$cust_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_keterangan);
		$cust_keterangan=str_replace("'", '"',$cust_keterangan);
		$cust_member=trim(@$_POST["cust_member"]);
		$cust_member=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_member);
		$cust_member=str_replace("'", '"',$cust_member);
		$cust_member2=trim(@$_POST["cust_member2"]);
		$cust_member2=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_member2);
		$cust_member2=str_replace("'", '"',$cust_member2);
		$cust_statusnikah=trim(@$_POST["cust_statusnikah"]);
		$cust_statusnikah=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_statusnikah);
		$cust_statusnikah=str_replace("'", '"',$cust_statusnikah);
		$cust_priority=trim(@$_POST["cust_priority"]);
		$cust_priority=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_priority);
		$cust_priority=str_replace("'", '"',$cust_priority);
		$cust_jmlanak=trim(@$_POST["cust_jmlanak"]);
		$cust_unit=trim(@$_POST["cust_unit"]);
		$cust_unit=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_unit);
		$cust_unit=str_replace("'", '"',$cust_unit);
		$cust_aktif=trim(@$_POST["cust_aktif"]);
		$cust_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_aktif);
		$cust_aktif=str_replace("'", '"',$cust_aktif);
		$sortby=trim(@$_POST["sortby"]);
		$sortby=str_replace("/(<\/?)(p)([^>]*>)", "",$sortby);
		$sortby=str_replace("'", '"',$sortby);
		$cust_fretfulness=trim(@$_POST["cust_fretfulness"]);
		$cust_fretfulness=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_fretfulness);
		$cust_fretfulness=str_replace("'", '"',$cust_fretfulness);
		$cust_creator=trim(@$_POST["cust_creator"]);
		$cust_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_creator);
		$cust_creator=str_replace("'", '"',$cust_creator);
		$cust_date_create=trim(@$_POST["cust_date_create"]);
		$cust_update=trim(@$_POST["cust_update"]);
		$cust_update=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_update);
		$cust_update=str_replace("'", '"',$cust_update);
		$cust_date_update=trim(@$_POST["cust_date_update"]);
		$cust_revised=trim(@$_POST["cust_revised"]);
		$cust_umurstart=trim(@$_POST["cust_umurstart"]);
		$cust_umurstart=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_umurstart);
		$cust_umurstart=str_replace("'", '"',$cust_umurstart);
		$cust_umurend=trim(@$_POST["cust_umurend"]);
		$cust_umurend=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_umurend);
		$cust_umurend=str_replace("'", '"',$cust_umurend);
		$cust_transaksi_start=trim(@$_POST["cust_transaksi_start"]);
		$cust_transaksi_end=trim(@$_POST["cust_transaksi_end"]);
		$cust_tidak_transaksi_start=trim(@$_POST["cust_tidak_transaksi_start"]);
		$cust_tidak_transaksi_end=trim(@$_POST["cust_tidak_transaksi_end"]);
		$cust_terdaftar=trim(@$_POST["cust_terdaftar"]);
		$cust_tgldaftarend =(isset($_POST['cust_tgldaftarend']) ? @$_POST['cust_tgldaftarend'] : @$_GET['cust_tgldaftarend']);
		$cust_tgldaftarend=trim(@$_POST["cust_tgldaftarend"]);
		$member_terdaftarstart=trim(@$_POST["member_terdaftarstart"]);
		$member_terdaftarend=trim(@$_POST["member_terdaftarend"]);
		$cust_tglawaltrans=trim(@$_POST["cust_tglawaltrans"]);
		$cust_tglawaltransend=trim(@$_POST["cust_tglawaltrans_end"]);
		$cust_tgl=trim(@$_POST["cust_tgl"]);
		$cust_tgl=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_tgl);
		$cust_tgl=str_replace("'", '"',$cust_tgl);
		$cust_bulan=trim(@$_POST["cust_bulan"]);
		$cust_bulan=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_bulan);
		$cust_bulan=str_replace("'", '"',$cust_bulan);
		$cust_tglEnd=trim(@$_POST["cust_tglEnd"]);
		$cust_tglEnd=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_tglEnd);
		$cust_tglEnd=str_replace("'", '"',$cust_tglEnd);
		$cust_bulanEnd=trim(@$_POST["cust_bulanEnd"]);
		$cust_bulanEnd=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_bulanEnd);
		$cust_bulanEnd=str_replace("'", '"',$cust_bulanEnd);
		$cust_bb=trim(@$_POST["cust_bb"]);
		$cust_bb=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_bb);
		$cust_bb=str_replace("'", '"',$cust_bb);		
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_customer->customer_search($cust_id ,$cust_no ,$cust_no_awal ,$cust_no_akhir ,$cust_nama, $cust_panggilan, $cust_foreigner ,$cust_kelamin ,$cust_alamat ,$cust_kota ,$cust_kodepos ,$cust_propinsi ,$cust_negara ,$cust_telprumah ,$cust_email ,$cust_agama ,$cust_pendidikan ,$cust_profesi ,$cust_tgllahir ,$cust_tgllahirend ,$cust_referensi ,$cust_referensilain ,$cust_keterangan ,$cust_member ,$cust_member2 ,$cust_terdaftar , $cust_tgldaftarend, $member_terdaftarstart, $member_terdaftarend, $cust_tglawaltrans, $cust_tglawaltransend, $cust_statusnikah , $cust_priority , $cust_jmlanak ,$cust_unit ,$cust_aktif , $sortby, $cust_fretfulness, $cust_creator ,$cust_date_create ,$cust_update ,$cust_date_update ,$cust_revised ,$start,$end, $cust_hobi_baca, $cust_hobi_olah, $cust_hobi_masak, $cust_hobi_travel, $cust_hobi_foto, $cust_hobi_lukis, $cust_hobi_nari, $cust_hobi_lain, $cust_umurstart, $cust_umurend, $cust_umur,$cust_tgl, $cust_bulan, $cust_tglEnd, $cust_bulanEnd, $cust_bb, $cust_transaksi_start, $cust_transaksi_end, $cust_tidak_transaksi_start, $cust_tidak_transaksi_end);
		echo $result;
	}


 	function customer_print(){
  		//POST varibale here
		$cust_id=trim(@$_POST["cust_id"]);
		$cust_no=trim(@$_POST["cust_no"]);
		$cust_no=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_no);
		$cust_no=str_replace("'", '"',$cust_no);
		$cust_no_awal=trim(@$_POST["cust_no_awal"]);
		$cust_no_awal=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_no_awal);
		$cust_no_awal=str_replace("'", '"',$cust_no_awal);
		$cust_no_akhir=trim(@$_POST["cust_no_akhir"]);
		$cust_no_akhir=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_no_akhir);
		$cust_no_akhir=str_replace("'", '"',$cust_no_akhir);
		$cust_nama=trim(@$_POST["cust_nama"]);
		$cust_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_nama);
		$cust_nama=str_replace("'", '"',$cust_nama);
		$cust_panggilan=trim(@$_POST["cust_panggilan"]);
		$cust_panggilan=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_panggilan);
		$cust_panggilan=str_replace("'", '"',$cust_panggilan);
		$cust_foreigner=trim(@$_POST["cust_foreigner"]);
		$cust_foreigner=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_foreigner);
		$cust_foreigner=str_replace("'", '"',$cust_foreigner);
		$cust_kelamin=trim(@$_POST["cust_kelamin"]);
		$cust_kelamin=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_kelamin);
		$cust_kelamin=str_replace("'", '"',$cust_kelamin);
		$cust_alamat=trim(@$_POST["cust_alamat"]);
		$cust_alamat=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_alamat);
		$cust_alamat=str_replace("'", '"',$cust_alamat);
		$cust_alamat2=trim(@$_POST["cust_alamat2"]);
		$cust_alamat2=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_alamat2);
		$cust_alamat2=str_replace("'", '"',$cust_alamat2);
		$cust_kota=trim(@$_POST["cust_kota"]);
		$cust_kota=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_kota);
		$cust_kota=str_replace("'", '"',$cust_kota);
		$cust_kodepos=trim(@$_POST["cust_kodepos"]);
		$cust_kodepos=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_kodepos);
		$cust_kodepos=str_replace("'", '"',$cust_kodepos);
		$cust_propinsi=trim(@$_POST["cust_propinsi"]);
		$cust_propinsi=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_propinsi);
		$cust_propinsi=str_replace("'", '"',$cust_propinsi);
		$cust_negara=trim(@$_POST["cust_negara"]);
		$cust_negara=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_negara);
		$cust_negara=str_replace("'", '"',$cust_negara);
		$cust_telprumah=trim(@$_POST["cust_telprumah"]);
		$cust_telprumah=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_telprumah);
		$cust_telprumah=str_replace("'", '"',$cust_telprumah);
		$cust_telprumah2=trim(@$_POST["cust_telprumah2"]);
		$cust_telprumah2=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_telprumah2);
		$cust_telprumah2=str_replace("'", '"',$cust_telprumah2);
		$cust_telpkantor=trim(@$_POST["cust_telpkantor"]);
		$cust_telpkantor=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_telpkantor);
		$cust_telpkantor=str_replace("'", '"',$cust_telpkantor);
		$cust_hp=trim(@$_POST["cust_hp"]);
		$cust_hp=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hp);
		$cust_hp=str_replace("'", '"',$cust_hp);
		$cust_hp2=trim(@$_POST["cust_hp2"]);
		$cust_hp2=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hp2);
		$cust_hp2=str_replace("'", '"',$cust_hp2);
		$cust_hp3=trim(@$_POST["cust_hp3"]);
		$cust_hp3=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hp3);
		$cust_hp3=str_replace("'", '"',$cust_hp3);
		$cust_email=trim(@$_POST["cust_email"]);
		$cust_email=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_email);
		$cust_email=str_replace("'", '"',$cust_email);
		$cust_agama=trim(@$_POST["cust_agama"]);
		$cust_agama=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_agama);
		$cust_agama=str_replace("'", '"',$cust_agama);
		$cust_pendidikan=trim(@$_POST["cust_pendidikan"]);
		$cust_pendidikan=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_pendidikan);
		$cust_pendidikan=str_replace("'", '"',$cust_pendidikan);
		$cust_profesi=trim(@$_POST["cust_profesi"]);
		$cust_profesi=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_profesi);
		$cust_profesi=str_replace("'", '"',$cust_profesi);
		$cust_tgllahir=trim(@$_POST["cust_tgllahir"]);
		$cust_tgllahirend =(isset($_POST['cust_tgllahirend']) ? @$_POST['cust_tgllahirend'] : @$_GET['cust_tgllahirend']);
		$cust_tgllahirend=trim(@$_POST["cust_tgllahirend"]);
		$cust_umur=trim(@$_POST["cust_umur"]);
		
		$cust_hobi_baca=trim(@$_POST["cust_hobi_baca"]);
		$cust_hobi_olah=trim(@$_POST["cust_hobi_olah"]);
		$cust_hobi_masak=trim(@$_POST["cust_hobi_masak"]);
		$cust_hobi_travel=trim(@$_POST["cust_hobi_travel"]);
		$cust_hobi_foto=trim(@$_POST["cust_hobi_foto"]);
		$cust_hobi_lukis=trim(@$_POST["cust_hobi_lukis"]);
		$cust_hobi_nari=trim(@$_POST["cust_hobi_nari"]);
		$cust_hobi_lain=trim(@$_POST["cust_hobi_lain"]);
		$cust_referensi=trim(@$_POST["cust_referensi"]);
		$cust_referensi=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_referensi);
		$cust_referensi=str_replace("'", '"',$cust_referensi);
		$cust_referensilain=trim(@$_POST["cust_referensilain"]);
		$cust_referensilain=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_referensilain);
		$cust_referensilain=str_replace("'", '"',$cust_referensilain);
		$cust_keterangan=trim(@$_POST["cust_keterangan"]);
		$cust_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_keterangan);
		$cust_keterangan=str_replace("'", '"',$cust_keterangan);
		$cust_member=trim(@$_POST["cust_member"]);
		$cust_member=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_member);
		$cust_member=str_replace("'", '"',$cust_member);
		$cust_member2=trim(@$_POST["cust_member2"]);
		$cust_member2=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_member2);
		$cust_member2=str_replace("'", '"',$cust_member2);
		$cust_statusnikah=trim(@$_POST["cust_statusnikah"]);
		$cust_statusnikah=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_statusnikah);
		$cust_statusnikah=str_replace("'", '"',$cust_statusnikah);
		$cust_priority=trim(@$_POST["cust_priority"]);
		$cust_priority=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_priority);
		$cust_priority=str_replace("'", '"',$cust_priority);
		$cust_jmlanak=trim(@$_POST["cust_jmlanak"]);
		$cust_unit=trim(@$_POST["cust_unit"]);
		$cust_unit=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_unit);
		$cust_unit=str_replace("'", '"',$cust_unit);
		$cust_aktif=trim(@$_POST["cust_aktif"]);
		$cust_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_aktif);
		$cust_aktif=str_replace("'", '"',$cust_aktif);
		$sortby=trim(@$_POST["sortby"]);
		$sortby=str_replace("/(<\/?)(p)([^>]*>)", "",$sortby);
		$sortby=str_replace("'", '"',$sortby);
		$cust_fretfulness=trim(@$_POST["cust_fretfulness"]);
		$cust_fretfulness=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_fretfulness);
		$cust_fretfulness=str_replace("'", '"',$cust_fretfulness);
		$cust_creator=trim(@$_POST["cust_creator"]);
		$cust_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_creator);
		$cust_creator=str_replace("'", '"',$cust_creator);
		$cust_date_create=trim(@$_POST["cust_date_create"]);
		$cust_update=trim(@$_POST["cust_update"]);
		$cust_update=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_update);
		$cust_update=str_replace("'", '"',$cust_update);
		$cust_date_update=trim(@$_POST["cust_date_update"]);
		$cust_revised=trim(@$_POST["cust_revised"]);
		$cust_umurstart=trim(@$_POST["cust_umurstart"]);
		$cust_umurstart=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_umurstart);
		$cust_umurstart=str_replace("'", '"',$cust_umurstart);
		$cust_umurend=trim(@$_POST["cust_umurend"]);
		$cust_umurend=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_umurend);
		$cust_umurend=str_replace("'", '"',$cust_umurend);
		$cust_transaksi_start=trim(@$_POST["cust_transaksi_start"]);
		$cust_transaksi_end=trim(@$_POST["cust_transaksi_end"]);
		$cust_tidak_transaksi_start=trim(@$_POST["cust_tidak_transaksi_start"]);
		$cust_tidak_transaksi_end=trim(@$_POST["cust_tidak_transaksi_end"]);
		$cust_terdaftar=trim(@$_POST["cust_terdaftar"]);
		$cust_tgldaftarend =(isset($_POST['cust_tgldaftarend']) ? @$_POST['cust_tgldaftarend'] : @$_GET['cust_tgldaftarend']);
		$cust_tgldaftarend=trim(@$_POST["cust_tgldaftarend"]);
		$member_terdaftarstart=trim(@$_POST["member_terdaftarstart"]);
		$member_terdaftarend=trim(@$_POST["member_terdaftarend"]);
		$cust_tglawaltrans=trim(@$_POST["cust_tglawaltrans"]);
		$cust_tglawaltransend=trim(@$_POST["cust_tglawaltrans_end"]);
		$cust_tgl=trim(@$_POST["cust_tgl"]);
		$cust_tgl=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_tgl);
		$cust_tgl=str_replace("'", '"',$cust_tgl);
		$cust_bulan=trim(@$_POST["cust_bulan"]);
		$cust_bulan=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_bulan);
		$cust_bulan=str_replace("'", '"',$cust_bulan);
		$cust_tglEnd=trim(@$_POST["cust_tglEnd"]);
		$cust_tglEnd=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_tglEnd);
		$cust_tglEnd=str_replace("'", '"',$cust_tglEnd);
		$cust_bulanEnd=trim(@$_POST["cust_bulanEnd"]);
		$cust_bulanEnd=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_bulanEnd);
		$cust_bulanEnd=str_replace("'", '"',$cust_bulanEnd);
		$cust_bb=trim(@$_POST["cust_bb"]);
		$cust_bb=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_bb);
		$cust_bb=str_replace("'", '"',$cust_bb);
	
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$data["data_print"] = $this->m_customer->customer_print($cust_id,$cust_no,$cust_no_awal ,$cust_no_akhir,$cust_nama, $cust_panggilan, $cust_foreigner,$cust_kelamin,$cust_alamat,$cust_kota,$cust_kodepos,$cust_propinsi,$cust_negara,$cust_telprumah,$cust_telprumah2,$cust_telpkantor,$cust_hp,$cust_hp2,$cust_hp3,$cust_email,$cust_agama,$cust_pendidikan,$cust_profesi,$cust_tgllahir,$cust_tgllahirend,$cust_referensi,$cust_referensilain,$cust_keterangan,$cust_member, $cust_member2, $cust_terdaftar,$cust_tgldaftarend, $member_terdaftarstart, $member_terdaftarend, $cust_tglawaltrans,$cust_tglawaltransend,$cust_statusnikah,$cust_priority,$cust_jmlanak,$cust_unit,$cust_aktif, $sortby, $cust_fretfulness,$cust_creator,$cust_date_create,$cust_update,$cust_date_update,$cust_revised, $cust_transaksi_start, $cust_transaksi_end, $cust_tidak_transaksi_start, $cust_tidak_transaksi_end, $cust_hobi_baca, $cust_hobi_olah, $cust_hobi_masak, $cust_hobi_travel, $cust_hobi_foto, $cust_hobi_lukis, $cust_hobi_nari, $cust_hobi_lain, $cust_umurstart, $cust_umurend, $cust_umur,$cust_tgl, $cust_bulan, $cust_tglEnd, $cust_bulanEnd,$cust_bb,$option,$filter)->result();
		
		$print_view=$this->load->view("main/p_customer.php",$data,TRUE);
		if(!file_exists("print")){
			mkdir("print");
		}
		$print_file=fopen("print/customerlist.html","w+");
		fwrite($print_file, $print_view);
		echo '1';  
	}
	/* End Of Function */
	
	/*Function of Print Label */
	function customer_print_label(){
  		//POST varibale here
				$cust_id=trim(@$_POST["cust_id"]);
		$cust_no=trim(@$_POST["cust_no"]);
		$cust_no=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_no);
		$cust_no=str_replace("'", '"',$cust_no);
		$cust_no_awal=trim(@$_POST["cust_no_awal"]);
		$cust_no_awal=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_no_awal);
		$cust_no_awal=str_replace("'", '"',$cust_no_awal);
		$cust_no_akhir=trim(@$_POST["cust_no_akhir"]);
		$cust_no_akhir=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_no_akhir);
		$cust_no_akhir=str_replace("'", '"',$cust_no_akhir);
		$cust_nama=trim(@$_POST["cust_nama"]);
		$cust_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_nama);
		$cust_nama=str_replace("'", '"',$cust_nama);
		$cust_panggilan=trim(@$_POST["cust_panggilan"]);
		$cust_panggilan=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_panggilan);
		$cust_panggilan=str_replace("'", '"',$cust_panggilan);
		$cust_foreigner=trim(@$_POST["cust_foreigner"]);
		$cust_foreigner=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_foreigner);
		$cust_foreigner=str_replace("'", '"',$cust_foreigner);
		$cust_kelamin=trim(@$_POST["cust_kelamin"]);
		$cust_kelamin=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_kelamin);
		$cust_kelamin=str_replace("'", '"',$cust_kelamin);
		$cust_alamat=trim(@$_POST["cust_alamat"]);
		$cust_alamat=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_alamat);
		$cust_alamat=str_replace("'", '"',$cust_alamat);
		$cust_alamat2=trim(@$_POST["cust_alamat2"]);
		$cust_alamat2=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_alamat2);
		$cust_alamat2=str_replace("'", '"',$cust_alamat2);
		$cust_kota=trim(@$_POST["cust_kota"]);
		$cust_kota=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_kota);
		$cust_kota=str_replace("'", '"',$cust_kota);
		$cust_kodepos=trim(@$_POST["cust_kodepos"]);
		$cust_kodepos=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_kodepos);
		$cust_kodepos=str_replace("'", '"',$cust_kodepos);
		$cust_propinsi=trim(@$_POST["cust_propinsi"]);
		$cust_propinsi=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_propinsi);
		$cust_propinsi=str_replace("'", '"',$cust_propinsi);
		$cust_negara=trim(@$_POST["cust_negara"]);
		$cust_negara=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_negara);
		$cust_negara=str_replace("'", '"',$cust_negara);
		$cust_telprumah=trim(@$_POST["cust_telprumah"]);
		$cust_telprumah=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_telprumah);
		$cust_telprumah=str_replace("'", '"',$cust_telprumah);
		$cust_telprumah2=trim(@$_POST["cust_telprumah2"]);
		$cust_telprumah2=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_telprumah2);
		$cust_telprumah2=str_replace("'", '"',$cust_telprumah2);
		$cust_telpkantor=trim(@$_POST["cust_telpkantor"]);
		$cust_telpkantor=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_telpkantor);
		$cust_telpkantor=str_replace("'", '"',$cust_telpkantor);
		$cust_hp=trim(@$_POST["cust_hp"]);
		$cust_hp=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hp);
		$cust_hp=str_replace("'", '"',$cust_hp);
		$cust_hp2=trim(@$_POST["cust_hp2"]);
		$cust_hp2=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hp2);
		$cust_hp2=str_replace("'", '"',$cust_hp2);
		$cust_hp3=trim(@$_POST["cust_hp3"]);
		$cust_hp3=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hp3);
		$cust_hp3=str_replace("'", '"',$cust_hp3);
		$cust_email=trim(@$_POST["cust_email"]);
		$cust_email=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_email);
		$cust_email=str_replace("'", '"',$cust_email);
		$cust_agama=trim(@$_POST["cust_agama"]);
		$cust_agama=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_agama);
		$cust_agama=str_replace("'", '"',$cust_agama);
		$cust_pendidikan=trim(@$_POST["cust_pendidikan"]);
		$cust_pendidikan=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_pendidikan);
		$cust_pendidikan=str_replace("'", '"',$cust_pendidikan);
		$cust_profesi=trim(@$_POST["cust_profesi"]);
		$cust_profesi=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_profesi);
		$cust_profesi=str_replace("'", '"',$cust_profesi);
		$cust_tgllahir=trim(@$_POST["cust_tgllahir"]);
		$cust_tgllahirend =(isset($_POST['cust_tgllahirend']) ? @$_POST['cust_tgllahirend'] : @$_GET['cust_tgllahirend']);
		$cust_tgllahirend=trim(@$_POST["cust_tgllahirend"]);
		$cust_umur=trim(@$_POST["cust_umur"]);
		
		$cust_hobi_baca=trim(@$_POST["cust_hobi_baca"]);
		$cust_hobi_olah=trim(@$_POST["cust_hobi_olah"]);
		$cust_hobi_masak=trim(@$_POST["cust_hobi_masak"]);
		$cust_hobi_travel=trim(@$_POST["cust_hobi_travel"]);
		$cust_hobi_foto=trim(@$_POST["cust_hobi_foto"]);
		$cust_hobi_lukis=trim(@$_POST["cust_hobi_lukis"]);
		$cust_hobi_nari=trim(@$_POST["cust_hobi_nari"]);
		$cust_hobi_lain=trim(@$_POST["cust_hobi_lain"]);
		$cust_referensi=trim(@$_POST["cust_referensi"]);
		$cust_referensi=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_referensi);
		$cust_referensi=str_replace("'", '"',$cust_referensi);
		$cust_referensilain=trim(@$_POST["cust_referensilain"]);
		$cust_referensilain=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_referensilain);
		$cust_referensilain=str_replace("'", '"',$cust_referensilain);
		$cust_keterangan=trim(@$_POST["cust_keterangan"]);
		$cust_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_keterangan);
		$cust_keterangan=str_replace("'", '"',$cust_keterangan);
		$cust_member=trim(@$_POST["cust_member"]);
		$cust_member=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_member);
		$cust_member=str_replace("'", '"',$cust_member);
		$cust_member2=trim(@$_POST["cust_member2"]);
		$cust_member2=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_member2);
		$cust_member2=str_replace("'", '"',$cust_member2);
		$cust_statusnikah=trim(@$_POST["cust_statusnikah"]);
		$cust_statusnikah=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_statusnikah);
		$cust_statusnikah=str_replace("'", '"',$cust_statusnikah);
		$cust_priority=trim(@$_POST["cust_priority"]);
		$cust_priority=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_priority);
		$cust_priority=str_replace("'", '"',$cust_priority);
		$cust_jmlanak=trim(@$_POST["cust_jmlanak"]);
		$cust_unit=trim(@$_POST["cust_unit"]);
		$cust_unit=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_unit);
		$cust_unit=str_replace("'", '"',$cust_unit);
		$cust_aktif=trim(@$_POST["cust_aktif"]);
		$cust_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_aktif);
		$cust_aktif=str_replace("'", '"',$cust_aktif);
		$sortby=trim(@$_POST["sortby"]);
		$sortby=str_replace("/(<\/?)(p)([^>]*>)", "",$sortby);
		$sortby=str_replace("'", '"',$sortby);
		$cust_fretfulness=trim(@$_POST["cust_fretfulness"]);
		$cust_fretfulness=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_fretfulness);
		$cust_fretfulness=str_replace("'", '"',$cust_fretfulness);
		$cust_creator=trim(@$_POST["cust_creator"]);
		$cust_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_creator);
		$cust_creator=str_replace("'", '"',$cust_creator);
		$cust_date_create=trim(@$_POST["cust_date_create"]);
		$cust_update=trim(@$_POST["cust_update"]);
		$cust_update=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_update);
		$cust_update=str_replace("'", '"',$cust_update);
		$cust_date_update=trim(@$_POST["cust_date_update"]);
		$cust_revised=trim(@$_POST["cust_revised"]);
		$cust_umurstart=trim(@$_POST["cust_umurstart"]);
		$cust_umurstart=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_umurstart);
		$cust_umurstart=str_replace("'", '"',$cust_umurstart);
		$cust_umurend=trim(@$_POST["cust_umurend"]);
		$cust_umurend=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_umurend);
		$cust_umurend=str_replace("'", '"',$cust_umurend);
		$cust_transaksi_start=trim(@$_POST["cust_transaksi_start"]);
		$cust_transaksi_end=trim(@$_POST["cust_transaksi_end"]);
		$cust_tidak_transaksi_start=trim(@$_POST["cust_tidak_transaksi_start"]);
		$cust_tidak_transaksi_end=trim(@$_POST["cust_tidak_transaksi_end"]);
		$cust_terdaftar=trim(@$_POST["cust_terdaftar"]);
		$cust_tgldaftarend =(isset($_POST['cust_tgldaftarend']) ? @$_POST['cust_tgldaftarend'] : @$_GET['cust_tgldaftarend']);
		$cust_tgldaftarend=trim(@$_POST["cust_tgldaftarend"]);
		$member_terdaftarstart=trim(@$_POST["member_terdaftarstart"]);
		$member_terdaftarend=trim(@$_POST["member_terdaftarend"]);
		$cust_tglawaltrans=trim(@$_POST["cust_tglawaltrans"]);
		$cust_tglawaltransend=trim(@$_POST["cust_tglawaltrans_end"]);
		$cust_tgl=trim(@$_POST["cust_tgl"]);
		$cust_tgl=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_tgl);
		$cust_tgl=str_replace("'", '"',$cust_tgl);
		$cust_bulan=trim(@$_POST["cust_bulan"]);
		$cust_bulan=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_bulan);
		$cust_bulan=str_replace("'", '"',$cust_bulan);
		$cust_tglEnd=trim(@$_POST["cust_tglEnd"]);
		$cust_tglEnd=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_tglEnd);
		$cust_tglEnd=str_replace("'", '"',$cust_tglEnd);
		$cust_bulanEnd=trim(@$_POST["cust_bulanEnd"]);
		$cust_bulanEnd=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_bulanEnd);
		$cust_bulanEnd=str_replace("'", '"',$cust_bulanEnd);
		$cust_bb=trim(@$_POST["cust_bb"]);
		$cust_bb=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_bb);
		$cust_bb=str_replace("'", '"',$cust_bb);
		
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$result = $this->m_customer->customer_print_label($cust_id,$cust_no,$cust_no_awal ,$cust_no_akhir,$cust_nama, $cust_panggilan, $cust_foreigner,$cust_kelamin,$cust_alamat,$cust_kota,$cust_kodepos,$cust_propinsi,$cust_negara,$cust_telprumah,$cust_telprumah2,$cust_telpkantor,$cust_hp,$cust_hp2,$cust_hp3,$cust_email,$cust_agama,$cust_pendidikan,$cust_profesi,$cust_tgllahir,$cust_tgllahirend,$cust_referensi,$cust_referensilain,$cust_keterangan,$cust_member, $cust_member2, $cust_terdaftar,$cust_tgldaftarend, $member_terdaftarstart, $member_terdaftarend, $cust_tglawaltrans,$cust_tglawaltransend,$cust_statusnikah,$cust_priority,$cust_jmlanak,$cust_unit,$cust_aktif, $sortby, $cust_fretfulness,$cust_creator,$cust_date_create,$cust_update,$cust_date_update,$cust_revised, $cust_transaksi_start, $cust_transaksi_end, $cust_tidak_transaksi_start, $cust_tidak_transaksi_end, $cust_hobi_baca, $cust_hobi_olah, $cust_hobi_masak, $cust_hobi_travel, $cust_hobi_foto, $cust_hobi_lukis, $cust_hobi_nari, $cust_hobi_lain, $cust_umurstart, $cust_umurend, $cust_umur,$cust_tgl, $cust_bulan, $cust_tglEnd, $cust_bulanEnd,$cust_bb,$option,$filter);
		
		$rs=$result->row();
		$jumlah_result=$result->result();
		
		if ($result->row() != null){	
		$data['cust_nama']=$rs->cust_nama;
		$data['cust_alamat']=$rs->cust_alamat;
		$data['cust_kota']=$rs->cust_kota;
		$data['cust_kodepos']=$rs->cust_kodepos;
		$data['jumlah_result']=$jumlah_result;
		}
		
		$nbrows=$result->num_rows();
		$viewdata=$this->load->view("main/p_cetak_label",$data,TRUE);
		
		$file = fopen("customerlist.html",'w');
		fwrite($file, $viewdata);
		fclose($file);
		echo '1';        
	}
	/* End Of Function */
	
	/* Function to Export Excel document */
	function customer_export_excel(){
		//POST varibale here
				$cust_id=trim(@$_POST["cust_id"]);
		$cust_no=trim(@$_POST["cust_no"]);
		$cust_no=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_no);
		$cust_no=str_replace("'", '"',$cust_no);
		$cust_no_awal=trim(@$_POST["cust_no_awal"]);
		$cust_no_awal=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_no_awal);
		$cust_no_awal=str_replace("'", '"',$cust_no_awal);
		$cust_no_akhir=trim(@$_POST["cust_no_akhir"]);
		$cust_no_akhir=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_no_akhir);
		$cust_no_akhir=str_replace("'", '"',$cust_no_akhir);
		$cust_nama=trim(@$_POST["cust_nama"]);
		$cust_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_nama);
		$cust_nama=str_replace("'", '"',$cust_nama);
		$cust_panggilan=trim(@$_POST["cust_panggilan"]);
		$cust_panggilan=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_panggilan);
		$cust_panggilan=str_replace("'", '"',$cust_panggilan);
		$cust_foreigner=trim(@$_POST["cust_foreigner"]);
		$cust_foreigner=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_foreigner);
		$cust_foreigner=str_replace("'", '"',$cust_foreigner);
		$cust_kelamin=trim(@$_POST["cust_kelamin"]);
		$cust_kelamin=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_kelamin);
		$cust_kelamin=str_replace("'", '"',$cust_kelamin);
		$cust_alamat=trim(@$_POST["cust_alamat"]);
		$cust_alamat=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_alamat);
		$cust_alamat=str_replace("'", '"',$cust_alamat);
		$cust_alamat2=trim(@$_POST["cust_alamat2"]);
		$cust_alamat2=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_alamat2);
		$cust_alamat2=str_replace("'", '"',$cust_alamat2);
		$cust_kota=trim(@$_POST["cust_kota"]);
		$cust_kota=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_kota);
		$cust_kota=str_replace("'", '"',$cust_kota);
		$cust_kodepos=trim(@$_POST["cust_kodepos"]);
		$cust_kodepos=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_kodepos);
		$cust_kodepos=str_replace("'", '"',$cust_kodepos);
		$cust_propinsi=trim(@$_POST["cust_propinsi"]);
		$cust_propinsi=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_propinsi);
		$cust_propinsi=str_replace("'", '"',$cust_propinsi);
		$cust_negara=trim(@$_POST["cust_negara"]);
		$cust_negara=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_negara);
		$cust_negara=str_replace("'", '"',$cust_negara);
		$cust_telprumah=trim(@$_POST["cust_telprumah"]);
		$cust_telprumah=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_telprumah);
		$cust_telprumah=str_replace("'", '"',$cust_telprumah);
		$cust_telprumah2=trim(@$_POST["cust_telprumah2"]);
		$cust_telprumah2=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_telprumah2);
		$cust_telprumah2=str_replace("'", '"',$cust_telprumah2);
		$cust_telpkantor=trim(@$_POST["cust_telpkantor"]);
		$cust_telpkantor=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_telpkantor);
		$cust_telpkantor=str_replace("'", '"',$cust_telpkantor);
		$cust_hp=trim(@$_POST["cust_hp"]);
		$cust_hp=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hp);
		$cust_hp=str_replace("'", '"',$cust_hp);
		$cust_hp2=trim(@$_POST["cust_hp2"]);
		$cust_hp2=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hp2);
		$cust_hp2=str_replace("'", '"',$cust_hp2);
		$cust_hp3=trim(@$_POST["cust_hp3"]);
		$cust_hp3=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_hp3);
		$cust_hp3=str_replace("'", '"',$cust_hp3);
		$cust_email=trim(@$_POST["cust_email"]);
		$cust_email=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_email);
		$cust_email=str_replace("'", '"',$cust_email);
		$cust_agama=trim(@$_POST["cust_agama"]);
		$cust_agama=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_agama);
		$cust_agama=str_replace("'", '"',$cust_agama);
		$cust_pendidikan=trim(@$_POST["cust_pendidikan"]);
		$cust_pendidikan=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_pendidikan);
		$cust_pendidikan=str_replace("'", '"',$cust_pendidikan);
		$cust_profesi=trim(@$_POST["cust_profesi"]);
		$cust_profesi=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_profesi);
		$cust_profesi=str_replace("'", '"',$cust_profesi);
		$cust_tgllahir=trim(@$_POST["cust_tgllahir"]);
		$cust_tgllahirend =(isset($_POST['cust_tgllahirend']) ? @$_POST['cust_tgllahirend'] : @$_GET['cust_tgllahirend']);
		$cust_tgllahirend=trim(@$_POST["cust_tgllahirend"]);
		$cust_umur=trim(@$_POST["cust_umur"]);
		
		$cust_hobi_baca=trim(@$_POST["cust_hobi_baca"]);
		$cust_hobi_olah=trim(@$_POST["cust_hobi_olah"]);
		$cust_hobi_masak=trim(@$_POST["cust_hobi_masak"]);
		$cust_hobi_travel=trim(@$_POST["cust_hobi_travel"]);
		$cust_hobi_foto=trim(@$_POST["cust_hobi_foto"]);
		$cust_hobi_lukis=trim(@$_POST["cust_hobi_lukis"]);
		$cust_hobi_nari=trim(@$_POST["cust_hobi_nari"]);
		$cust_hobi_lain=trim(@$_POST["cust_hobi_lain"]);
		$cust_referensi=trim(@$_POST["cust_referensi"]);
		$cust_referensi=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_referensi);
		$cust_referensi=str_replace("'", '"',$cust_referensi);
		$cust_referensilain=trim(@$_POST["cust_referensilain"]);
		$cust_referensilain=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_referensilain);
		$cust_referensilain=str_replace("'", '"',$cust_referensilain);
		$cust_keterangan=trim(@$_POST["cust_keterangan"]);
		$cust_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_keterangan);
		$cust_keterangan=str_replace("'", '"',$cust_keterangan);
		$cust_member=trim(@$_POST["cust_member"]);
		$cust_member=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_member);
		$cust_member=str_replace("'", '"',$cust_member);
		$cust_member2=trim(@$_POST["cust_member2"]);
		$cust_member2=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_member2);
		$cust_member2=str_replace("'", '"',$cust_member2);
		$cust_statusnikah=trim(@$_POST["cust_statusnikah"]);
		$cust_statusnikah=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_statusnikah);
		$cust_statusnikah=str_replace("'", '"',$cust_statusnikah);
		$cust_priority=trim(@$_POST["cust_priority"]);
		$cust_priority=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_priority);
		$cust_priority=str_replace("'", '"',$cust_priority);
		$cust_jmlanak=trim(@$_POST["cust_jmlanak"]);
		$cust_unit=trim(@$_POST["cust_unit"]);
		$cust_unit=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_unit);
		$cust_unit=str_replace("'", '"',$cust_unit);
		$cust_aktif=trim(@$_POST["cust_aktif"]);
		$cust_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_aktif);
		$cust_aktif=str_replace("'", '"',$cust_aktif);
		$sortby=trim(@$_POST["sortby"]);
		$sortby=str_replace("/(<\/?)(p)([^>]*>)", "",$sortby);
		$sortby=str_replace("'", '"',$sortby);
		$cust_fretfulness=trim(@$_POST["cust_fretfulness"]);
		$cust_fretfulness=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_fretfulness);
		$cust_fretfulness=str_replace("'", '"',$cust_fretfulness);
		$cust_creator=trim(@$_POST["cust_creator"]);
		$cust_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_creator);
		$cust_creator=str_replace("'", '"',$cust_creator);
		$cust_date_create=trim(@$_POST["cust_date_create"]);
		$cust_update=trim(@$_POST["cust_update"]);
		$cust_update=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_update);
		$cust_update=str_replace("'", '"',$cust_update);
		$cust_date_update=trim(@$_POST["cust_date_update"]);
		$cust_revised=trim(@$_POST["cust_revised"]);
		$cust_umurstart=trim(@$_POST["cust_umurstart"]);
		$cust_umurstart=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_umurstart);
		$cust_umurstart=str_replace("'", '"',$cust_umurstart);
		$cust_umurend=trim(@$_POST["cust_umurend"]);
		$cust_umurend=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_umurend);
		$cust_umurend=str_replace("'", '"',$cust_umurend);
		$cust_transaksi_start=trim(@$_POST["cust_transaksi_start"]);
		$cust_transaksi_end=trim(@$_POST["cust_transaksi_end"]);
		$cust_tidak_transaksi_start=trim(@$_POST["cust_tidak_transaksi_start"]);
		$cust_tidak_transaksi_end=trim(@$_POST["cust_tidak_transaksi_end"]);
		$cust_terdaftar=trim(@$_POST["cust_terdaftar"]);
		$cust_tgldaftarend =(isset($_POST['cust_tgldaftarend']) ? @$_POST['cust_tgldaftarend'] : @$_GET['cust_tgldaftarend']);
		$cust_tgldaftarend=trim(@$_POST["cust_tgldaftarend"]);
		$member_terdaftarstart=trim(@$_POST["member_terdaftarstart"]);
		$member_terdaftarend=trim(@$_POST["member_terdaftarend"]);
		$cust_tglawaltrans=trim(@$_POST["cust_tglawaltrans"]);
		$cust_tglawaltransend=trim(@$_POST["cust_tglawaltrans_end"]);
		$cust_tgl=trim(@$_POST["cust_tgl"]);
		$cust_tgl=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_tgl);
		$cust_tgl=str_replace("'", '"',$cust_tgl);
		$cust_bulan=trim(@$_POST["cust_bulan"]);
		$cust_bulan=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_bulan);
		$cust_bulan=str_replace("'", '"',$cust_bulan);
		$cust_tglEnd=trim(@$_POST["cust_tglEnd"]);
		$cust_tglEnd=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_tglEnd);
		$cust_tglEnd=str_replace("'", '"',$cust_tglEnd);
		$cust_bulanEnd=trim(@$_POST["cust_bulanEnd"]);
		$cust_bulanEnd=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_bulanEnd);
		$cust_bulanEnd=str_replace("'", '"',$cust_bulanEnd);
		$cust_bb=trim(@$_POST["cust_bb"]);
		$cust_bb=str_replace("/(<\/?)(p)([^>]*>)", "",$cust_bb);
		$cust_bb=str_replace("'", '"',$cust_bb);

		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_customer->customer_export_excel($cust_id,$cust_no,$cust_no_awal ,$cust_no_akhir,$cust_nama, $cust_panggilan, $cust_foreigner,$cust_kelamin,$cust_alamat,$cust_kota,$cust_kodepos,$cust_propinsi,$cust_negara,$cust_telprumah,$cust_telprumah2,$cust_telpkantor,$cust_hp,$cust_hp2,$cust_hp3,$cust_email,$cust_agama,$cust_pendidikan,$cust_profesi,$cust_tgllahir,$cust_tgllahirend,$cust_referensi,$cust_referensilain,$cust_keterangan,$cust_member, $cust_member2, $cust_terdaftar,$cust_tgldaftarend, $member_terdaftarstart, $member_terdaftarend, $cust_tglawaltrans,$cust_tglawaltransend,$cust_statusnikah,$cust_priority,$cust_jmlanak,$cust_unit,$cust_aktif, $sortby, $cust_fretfulness,$cust_creator,$cust_date_create,$cust_update,$cust_date_update,$cust_revised, $cust_transaksi_start, $cust_transaksi_end, $cust_tidak_transaksi_start, $cust_tidak_transaksi_end, $cust_hobi_baca, $cust_hobi_olah, $cust_hobi_masak, $cust_hobi_travel, $cust_hobi_foto, $cust_hobi_lukis, $cust_hobi_nari, $cust_hobi_lain, $cust_umurstart, $cust_umurend, $cust_umur,$cust_tgl, $cust_bulan, $cust_tglEnd, $cust_bulanEnd,$cust_bb,$option,$filter);
		
		to_excel($query,"customer"); 
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