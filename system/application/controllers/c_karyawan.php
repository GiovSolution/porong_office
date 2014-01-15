<?php
/* 	These code was generated using phpCIGen v 0.1.b (21/04/2009)
	# GIOV SOLUTION 
	
	+ Module  		: karyawan View
	+ Description	: For record view
	+ Filename 		: v_karyawan.php
 	+ Author  		: Isaac and Freddy
 	+ Created on 07/Dec/2012 12:48:00
	
*/

//class of karyawan
class C_karyawan extends Controller {

	//constructor
	function C_karyawan(){
		parent::Controller();
		session_start();
		$this->load->model('m_karyawan', '', TRUE);
		$this->load->plugin('to_excel');
	}
	
	//set index
	function index(){
		$this->load->helper('asset');
		$this->load->view('main/v_karyawan');
	}
	
	function get_karyawan_jabatan_list(){
		$result=$this->m_karyawan->get_karyawan_jabatan_list();
		echo $result;
	}
	
	function get_karyawan_bank_list(){
		$result=$this->m_karyawan->get_karyawan_bank_list();
		echo $result;
	}
	
	function get_karyawan_atasan_list(){
		$karyawan_id = trim(@$_POST["karyawan_id"]);
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$result=$this->m_karyawan->get_karyawan_atasan_list($karyawan_id,$query);
		echo $result;
	}
	
	
	function get_karyawan_cabang_list(){
		$result=$this->m_karyawan->get_karyawan_cabang_list();
		echo $result;
	}
	
	function get_karyawan_departemen_list(){
		$result=$this->m_karyawan->get_karyawan_departemen_list();
		echo $result;
	}
	
	function get_karyawan_golongan_list(){
		$result=$this->m_karyawan->get_karyawan_golongan_list();
		echo $result;
	}
	
	// STATUS KARYAWAN
	// list detail status karyawan
	function detail_status_karyawan_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_karyawan->detail_status_karyawan_list($master_id,$query,$start,$end);
		echo $result;
	}
	
	//input detail status karyawan
	//add detail
	function detail_status_karyawan_insert(){
		//POST variable here
		$kstatus_id = $_POST['kstatus_id']; // Get our array back and translate it :
		$array_kstatus_id = json_decode(stripslashes($kstatus_id));
		
		$kstatus_master=trim(@$_POST["kstatus_master"]);
		
		$kstatus_karyawan = $_POST['kstatus_karyawan']; // Get our array back and translate it :
		$array_kstatus_karyawan = json_decode(stripslashes($kstatus_karyawan));
		
		$kstatus_tglawal = $_POST['kstatus_tglawal']; // Get our array back and translate it :
		$array_kstatus_tglawal = json_decode(stripslashes($kstatus_tglawal));
		
		$kstatus_tglakhir = $_POST['kstatus_tglakhir']; // Get our array back and translate it :
		$array_kstatus_tglakhir = json_decode(stripslashes($kstatus_tglakhir));
		
		$kstatus_keterangan = $_POST['kstatus_keterangan']; // Get our array back and translate it :
		$array_kstatus_keterangan = json_decode(stripslashes($kstatus_keterangan));
		
		$result=$this->m_karyawan->detail_status_karyawan_insert($array_kstatus_id ,$kstatus_master ,$array_kstatus_karyawan, $array_kstatus_tglawal, $array_kstatus_tglakhir, $array_kstatus_keterangan);
		echo $result;
	}
	
	function detail_status_karyawan_delete(){
        $kstatus_id = trim(@$_POST["kstatus_id"]); // Get our array back and translate it :
		$result=$this->m_karyawan->detail_status_karyawan_delete($kstatus_id);
		echo $result;
    }
	// EOF STATUS KARYAWAN
	
	// JABATAN
	// list detail status karyawan
	function detail_jabatan_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_karyawan->detail_jabatan_list($master_id,$query,$start,$end);
		echo $result;
	}
	
	//input detail status karyawan
	//add detail
	function detail_jabatan_insert(){
		//POST variable here
		$djabatan_id = $_POST['djabatan_id']; // Get our array back and translate it :
		$array_djabatan_id = json_decode(stripslashes($djabatan_id));
		
		$djabatan_master=trim(@$_POST["djabatan_master"]);
		
		$djabatan_departemen = $_POST['djabatan_departemen']; // Get our array back and translate it :
		$array_djabatan_departemen = json_decode(stripslashes($djabatan_departemen));
		
		$djabatan_jabatan = $_POST['djabatan_jabatan']; // Get our array back and translate it :
		$array_djabatan_jabatan = json_decode(stripslashes($djabatan_jabatan));
			
		$djabatan_golongan = $_POST['djabatan_golongan']; // Get our array back and translate it :
		$array_djabatan_golongan = json_decode(stripslashes($djabatan_golongan));
		
		$djabatan_pph21 = $_POST['djabatan_pph21']; // Get our array back and translate it :
		$array_djabatan_pph21 = json_decode(stripslashes($djabatan_pph21));
		
		$djabatan_atasan = $_POST['djabatan_atasan']; // Get our array back and translate it :
		$array_djabatan_atasan = json_decode(stripslashes($djabatan_atasan));
		
		$djabatan_tglawal = $_POST['djabatan_tglawal']; // Get our array back and translate it :
		$array_djabatan_tglawal = json_decode(stripslashes($djabatan_tglawal));
		
		$djabatan_tglakhir = $_POST['djabatan_tglakhir']; // Get our array back and translate it :
		$array_djabatan_tglakhir = json_decode(stripslashes($djabatan_tglakhir));
		
		$djabatan_keterangan = $_POST['djabatan_keterangan']; // Get our array back and translate it :
		$array_djabatan_keterangan = json_decode(stripslashes($djabatan_keterangan));
		
		$result=$this->m_karyawan->detail_jabatan_insert($array_djabatan_id ,$djabatan_master ,$array_djabatan_departemen, $array_djabatan_jabatan, $array_djabatan_golongan, 
		$array_djabatan_pph21, $array_djabatan_atasan, $array_djabatan_tglawal, $array_djabatan_tglakhir, $array_djabatan_keterangan);
		echo $result;
	}
	
	function detail_jabatan_delete(){
        $djabatan_id = trim(@$_POST["djabatan_id"]); // Get our array back and translate it :
		$result=$this->m_karyawan->detail_jabatan_delete($djabatan_id);
		echo $result;
    }
	
	// EOF JABATAN
	
	// PENDIDIKAN
	// list detail pendidikan
	function detail_pendidikan_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_karyawan->detail_pendidikan_list($master_id,$query,$start,$end);
		echo $result;
	}
	
	//input detail pendidikan
	//add detail
	function detail_pendidikan_insert(){
		//POST variable here
		$kpendidikan_id = $_POST['kpendidikan_id']; // Get our array back and translate it :
		$array_kpendidikan_id = json_decode(stripslashes($kpendidikan_id));
		
		$kpendidikan_master=trim(@$_POST["kpendidikan_master"]);
		
		$kpendidikan_pendidikan = $_POST['kpendidikan_pendidikan']; // Get our array back and translate it :
		$array_kpendidikan_pendidikan = json_decode(stripslashes($kpendidikan_pendidikan));
		
		$kpendidikan_sekolah = $_POST['kpendidikan_sekolah']; // Get our array back and translate it :
		$array_kpendidikan_sekolah = json_decode(stripslashes($kpendidikan_sekolah));
			
		$kpendidikan_jurusan = $_POST['kpendidikan_jurusan']; // Get our array back and translate it :
		$array_kpendidikan_jurusan = json_decode(stripslashes($kpendidikan_jurusan));
		
		$kpendidikan_thnmasuk = $_POST['kpendidikan_thnmasuk']; // Get our array back and translate it :
		$array_kpendidikan_thnmasuk = json_decode(stripslashes($kpendidikan_thnmasuk));
		
		$kpendidikan_thnselesai = $_POST['kpendidikan_thnselesai']; // Get our array back and translate it :
		$array_kpendidikan_thnselesai = json_decode(stripslashes($kpendidikan_thnselesai));
		
		$kpendidikan_wisuda = $_POST['kpendidikan_wisuda']; // Get our array back and translate it :
		$array_kpendidikan_wisuda = json_decode(stripslashes($kpendidikan_wisuda));
		
		$kpendidikan_keterangan = $_POST['kpendidikan_keterangan']; // Get our array back and translate it :
		$array_kpendidikan_keterangan = json_decode(stripslashes($kpendidikan_keterangan));
		
		$result=$this->m_karyawan->detail_pendidikan_insert($array_kpendidikan_id ,$kpendidikan_master ,$array_kpendidikan_pendidikan, $array_kpendidikan_sekolah, $array_kpendidikan_jurusan, $array_kpendidikan_thnmasuk, $array_kpendidikan_thnselesai, $array_kpendidikan_wisuda, $array_kpendidikan_keterangan);
		echo $result;
	}
	
	function detail_pendidikan_delete(){
        $kpendidikan_id = trim(@$_POST["kpendidikan_id"]); // Get our array back and translate it :
		$result=$this->m_karyawan->detail_pendidikan_delete($kpendidikan_id);
		echo $result;
    }
	
	// EOF PENDIDIKAN
	
	// KELUARGA
	// list detail keluarga
	function detail_keluarga_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_karyawan->detail_keluarga_list($master_id,$query,$start,$end);
		echo $result;
	}
	
	//input detail keluarga
	//add detail
	function detail_keluarga_insert(){
		//POST variable here
		$kkeluarga_id = $_POST['kkeluarga_id']; // Get our array back and translate it :
		$array_kkeluarga_id = json_decode(stripslashes($kkeluarga_id));
		
		$kkeluarga_master=trim(@$_POST["kkeluarga_master"]);
		
		$kkeluarga_nama = $_POST['kkeluarga_nama']; // Get our array back and translate it :
		$array_kkeluarga_nama = json_decode(stripslashes($kkeluarga_nama));
		
		$kkeluarga_hubungan = $_POST['kkeluarga_hubungan']; // Get our array back and translate it :
		$array_kkeluarga_hubungan = json_decode(stripslashes($kkeluarga_hubungan));
			
		$kkeluarga_keterangan = $_POST['kkeluarga_keterangan']; // Get our array back and translate it :
		$array_kkeluarga_keterangan = json_decode(stripslashes($kkeluarga_keterangan));
		
		$result=$this->m_karyawan->detail_keluarga_insert($array_kkeluarga_id ,$kkeluarga_master ,$array_kkeluarga_nama, $array_kkeluarga_hubungan, $array_kkeluarga_keterangan);
		echo $result;
	}
	
	function detail_keluarga_delete(){
        $kkeluarga_id = trim(@$_POST["kkeluarga_id"]); // Get our array back and translate it :
		$result=$this->m_karyawan->detail_keluarga_delete($kkeluarga_id);
		echo $result;
    }
	
	// EOF KELUARGA
	
	// CUTI
	// list detail cuti
	function detail_cuti_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_karyawan->detail_cuti_list($master_id,$query,$start,$end);
		echo $result;
	}
	
	//input detail cuti
	//add detail
	function detail_cuti_insert(){
		//POST variable here
		$kcuti_id = $_POST['kcuti_id']; // Get our array back and translate it :
		$array_kcuti_id = json_decode(stripslashes($kcuti_id));
		
		$kcuti_master=trim(@$_POST["kcuti_master"]);
		
		$kcuti_jenis = $_POST['kcuti_jenis']; // Get our array back and translate it :
		$array_kcuti_jenis = json_decode(stripslashes($kcuti_jenis));
		
		$kcuti_tglawal = $_POST['kcuti_tglawal']; // Get our array back and translate it :
		$array_kcuti_tglawal = json_decode(stripslashes($kcuti_tglawal));
			
		$kcuti_tglakhir = $_POST['kcuti_tglakhir']; // Get our array back and translate it :
		$array_kcuti_tglakhir = json_decode(stripslashes($kcuti_tglakhir));
		
		$kcuti_jmlhari = $_POST['kcuti_jmlhari']; // Get our array back and translate it :
		$array_kcuti_jmlhari = json_decode(stripslashes($kcuti_jmlhari));
		
		$kcuti_tglpengajuan = $_POST['kcuti_tglpengajuan']; // Get our array back and translate it :
		$array_kcuti_tglpengajuan = json_decode(stripslashes($kcuti_tglpengajuan));
		
		$kcuti_keterangan = $_POST['kcuti_keterangan']; // Get our array back and translate it :
		$array_kcuti_keterangan = json_decode(stripslashes($kcuti_keterangan));
		
		$result=$this->m_karyawan->detail_cuti_insert($array_kcuti_id , $kcuti_master, $array_kcuti_jenis ,$array_kcuti_tglawal, $array_kcuti_tglakhir, $array_kcuti_jmlhari, $array_kcuti_tglpengajuan, $array_kcuti_keterangan);
		echo $result;
	}
	
	function detail_cuti_delete(){
        $kcuti_id = trim(@$_POST["kcuti_id"]); // Get our array back and translate it :
		$result=$this->m_karyawan->detail_cuti_delete($kcuti_id);
		echo $result;
    }
	
	// EOF CUTI
	
	// GANTIOFF
	// list detail gantioff
	function detail_gantioff_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_karyawan->detail_gantioff_list($master_id,$query,$start,$end);
		echo $result;
	}
	
	//input detail gantioff
	//add detail
	function detail_gantioff_insert(){
		//POST variable here
		$kgantioff_id = $_POST['kgantioff_id']; // Get our array back and translate it :
		$array_kgantioff_id = json_decode(stripslashes($kgantioff_id));
		
		$kgantioff_master=trim(@$_POST["kgantioff_master"]);
		
		$kgantioff_jenis = $_POST['kgantioff_jenis']; // Get our array back and translate it :
		$array_kgantioff_jenis = json_decode(stripslashes($kgantioff_jenis));
		
		$kgantioff_tglawal = $_POST['kgantioff_tglawal']; // Get our array back and translate it :
		$array_kgantioff_tglawal = json_decode(stripslashes($kgantioff_tglawal));
			
		$kgantioff_tglakhir = $_POST['kgantioff_tglakhir']; // Get our array back and translate it :
		$array_kgantioff_tglakhir = json_decode(stripslashes($kgantioff_tglakhir));
		
		$kgantioff_jmlhari = $_POST['kgantioff_jmlhari']; // Get our array back and translate it :
		$array_kgantioff_jmlhari = json_decode(stripslashes($kgantioff_jmlhari));
		
		$kgantioff_tglgantiawal = $_POST['kgantioff_tglgantiawal']; // Get our array back and translate it :
		$array_kgantioff_tglgantiawal = json_decode(stripslashes($kgantioff_tglgantiawal));
			
		$kgantioff_tglgantiakhir = $_POST['kgantioff_tglgantiakhir']; // Get our array back and translate it :
		$array_kgantioff_tglgantiakhir = json_decode(stripslashes($kgantioff_tglgantiakhir));
		
		$kgantioff_tglpengajuan = $_POST['kgantioff_tglpengajuan']; // Get our array back and translate it :
		$array_kgantioff_tglpengajuan = json_decode(stripslashes($kgantioff_tglpengajuan));
		
		$kgantioff_keterangan = $_POST['kgantioff_keterangan']; // Get our array back and translate it :
		$array_kgantioff_keterangan = json_decode(stripslashes($kgantioff_keterangan));
		
		$result=$this->m_karyawan->detail_gantioff_insert($array_kgantioff_id , $kgantioff_master, $array_kgantioff_jenis ,$array_kgantioff_tglawal, $array_kgantioff_tglakhir, $array_kgantioff_jmlhari, $array_kgantioff_tglgantiawal, $array_kgantioff_tglgantiakhir, $array_kgantioff_tglpengajuan, $array_kgantioff_keterangan);
		echo $result;
	}
	
	function detail_gantioff_delete(){
        $kgantioff_id = trim(@$_POST["kgantioff_id"]); // Get our array back and translate it :
		$result=$this->m_karyawan->detail_gantioff_delete($kgantioff_id);
		echo $result;
    }
	
	// EOF GANTIOFF
	
	// MEDICAL
	// list detail medical
	function detail_medical_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_karyawan->detail_medical_list($master_id,$query,$start,$end);
		echo $result;
	}
	
	//input detail medical
	//add detail
	function detail_medical_insert(){
		//POST variable here
		$kmedical_id = $_POST['kmedical_id']; // Get our array back and translate it :
		$array_kmedical_id = json_decode(stripslashes($kmedical_id));
		
		$kmedical_master=trim(@$_POST["kmedical_master"]);
		
		$kmedical_tujuan = $_POST['kmedical_tujuan']; // Get our array back and translate it :
		$array_kmedical_tujuan = json_decode(stripslashes($kmedical_tujuan));
		
		$kmedical_jenis_rawat = $_POST['kmedical_jenis_rawat']; // Get our array back and translate it :
		$array_kmedical_jenis_rawat = json_decode(stripslashes($kmedical_jenis_rawat));
			
		$kmedical_jenis_klaim = $_POST['kmedical_jenis_klaim']; // Get our array back and translate it :
		$array_kmedical_jenis_klaim = json_decode(stripslashes($kmedical_jenis_klaim));
		
		$kmedical_jumlah = $_POST['kmedical_jumlah']; // Get our array back and translate it :
		$array_kmedical_jumlah = json_decode(stripslashes($kmedical_jumlah));
		
		$kmedical_total = $_POST['kmedical_total']; // Get our array back and translate it :
		$array_kmedical_total = json_decode(stripslashes($kmedical_total));
		
		$kmedical_tglkuitansi = $_POST['kmedical_tglkuitansi']; // Get our array back and translate it :
		$array_kmedical_tglkuitansi = json_decode(stripslashes($kmedical_tglkuitansi));
		
		$kmedical_tglpengajuan = $_POST['kmedical_tglpengajuan']; // Get our array back and translate it :
		$array_kmedical_tglpengajuan = json_decode(stripslashes($kmedical_tglpengajuan));
		
		$kmedical_keterangan = $_POST['kmedical_keterangan']; // Get our array back and translate it :
		$array_kmedical_keterangan = json_decode(stripslashes($kmedical_keterangan));
		
		$result=$this->m_karyawan->detail_medical_insert($array_kmedical_id , $kmedical_master, $array_kmedical_tujuan ,$array_kmedical_jenis_rawat, $array_kmedical_jenis_klaim, $array_kmedical_jumlah, $array_kmedical_total, $array_kmedical_tglkuitansi, $array_kmedical_tglpengajuan, $array_kmedical_keterangan);
		echo $result;
	}
	
	function detail_medical_delete(){
        $kmedical_id = trim(@$_POST["kmedical_id"]); // Get our array back and translate it :
		$result=$this->m_karyawan->detail_medical_delete($kmedical_id);
		echo $result;
    }
	
	// EOF MEDICAL
	
	// FASILITAS
	// list detail fasilitas
	function detail_fasilitas_list(){
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$master_id = (integer) (isset($_POST['master_id']) ? $_POST['master_id'] : $_GET['master_id']);
		$result=$this->m_karyawan->detail_fasilitas_list($master_id,$query,$start,$end);
		echo $result;
	}
	
	//input detail fasilitas
	//add detail
	function detail_fasilitas_insert(){
		//POST variable here
		$kfasilitas_id = $_POST['kfasilitas_id']; // Get our array back and translate it :
		$array_kfasilitas_id = json_decode(stripslashes($kfasilitas_id));
		
		$kfasilitas_master=trim(@$_POST["kfasilitas_master"]);
		
		$kfasilitas_item = $_POST['kfasilitas_item']; // Get our array back and translate it :
		$array_kfasilitas_item = json_decode(stripslashes($kfasilitas_item));
		
		$kfasilitas_tglserahterima = $_POST['kfasilitas_tglserahterima']; // Get our array back and translate it :
		$array_kfasilitas_tglserahterima = json_decode(stripslashes($kfasilitas_tglserahterima));
			
		$kfasilitas_keterangan = $_POST['kfasilitas_keterangan']; // Get our array back and translate it :
		$array_kfasilitas_keterangan = json_decode(stripslashes($kfasilitas_keterangan));
		
		$result=$this->m_karyawan->detail_fasilitas_insert($array_kfasilitas_id ,$kfasilitas_master ,$array_kfasilitas_item, $array_kfasilitas_tglserahterima, $array_kfasilitas_keterangan);
		echo $result;
	}
	
	function detail_fasilitas_delete(){
        $kfasilitas_id = trim(@$_POST["kfasilitas_id"]); // Get our array back and translate it :
		$result=$this->m_karyawan->detail_fasilitas_delete($kfasilitas_id);
		echo $result;
    }
	
	// EOF FASILITAS
	
	//event handler action
	function get_action(){
		$task = $_POST['task'];
		switch($task){
			case "LIST":
				$this->karyawan_list();
				break;
			case "UPDATE":
				$this->karyawan_update();
				break;
			case "CREATE":
				$this->karyawan_create();
				break;
			case "DELETE":
				$this->karyawan_delete();
				break;
			case "DDELETE":
				$this->detail_status_karyawan_delete();
				break;
			case "PDELETE":
				$this->detail_pendidikan_delete();
				break;
			case "KDELETE":
				$this->detail_keluarga_delete();
				break;
			case "CDELETE":
				$this->detail_cuti_delete();
				break;
			case "GDELETE":
				$this->detail_gantioff_delete();
				break;
			case "MDELETE":
				$this->detail_medical_delete();
				break;
			case "FDELETE":
				$this->detail_fasilitas_delete();
				break;
			case "SEARCH":
				$this->karyawan_search();
				break;
			case "PRINT":
				$this->karyawan_print();
				break;
			case "EXCEL":
				$this->karyawan_export_excel();
				break;
			default:
				echo "{failure:true}";
				break;
		}
	}
	
	//function fot list record
	function karyawan_list(){
		
		$query = isset($_POST['query']) ? $_POST['query'] : "";
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);

		$result=$this->m_karyawan->karyawan_list($query,$start,$end);
		echo $result;
	}

	//function for update record
	function karyawan_update(){
		//POST variable here
		$karyawan_id=trim(@$_POST["karyawan_id"]);
		$karyawan_no=trim(@$_POST["karyawan_no"]);
		$karyawan_no=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_no);
		$karyawan_no=str_replace(",", ",",$karyawan_no);
		$karyawan_no=str_replace("'", '"',$karyawan_no);
		
		$karyawan_noktp=trim(@$_POST["karyawan_noktp"]);
		$karyawan_noktp=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_noktp);
		$karyawan_noktp=str_replace(",", ",",$karyawan_noktp);
		$karyawan_noktp=str_replace("'", '"',$karyawan_noktp);
		$karyawan_alamatktp=trim(@$_POST["karyawan_alamatktp"]);
		$karyawan_alamatktp=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_alamatktp);
		$karyawan_alamatktp=str_replace(",", ",",$karyawan_alamatktp);
		$karyawan_alamatktp=str_replace("'", '"',$karyawan_alamatktp);
		$karyawan_agama=trim(@$_POST["karyawan_agama"]);
		$karyawan_agama=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_agama);
		$karyawan_agama=str_replace(",", ",",$karyawan_agama);
		$karyawan_agama=str_replace("'", '"',$karyawan_agama);
		$karyawan_bank=trim(@$_POST["karyawan_bank"]);
		$karyawan_bank=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_bank);
		$karyawan_bank=str_replace(",", ",",$karyawan_bank);
		$karyawan_bank=str_replace("'", '"',$karyawan_bank);
		$karyawan_bankcabang=trim(@$_POST["karyawan_bankcabang"]);
		$karyawan_bankcabang=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_bankcabang);
		$karyawan_bankcabang=str_replace(",", ",",$karyawan_bankcabang);
		$karyawan_bankcabang=str_replace("'", '"',$karyawan_bankcabang);
		$karyawan_norekening=trim(@$_POST["karyawan_norekening"]);
		$karyawan_norekening=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_norekening);
		$karyawan_norekening=str_replace(",", ",",$karyawan_norekening);
		$karyawan_norekening=str_replace("'", '"',$karyawan_norekening);
		$karyawan_atasnama=trim(@$_POST["karyawan_atasnama"]);
		$karyawan_atasnama=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_atasnama);
		$karyawan_atasnama=str_replace(",", ",",$karyawan_atasnama);
		$karyawan_atasnama=str_replace("'", '"',$karyawan_atasnama);
		$karyawan_jamsostek=trim(@$_POST["karyawan_jamsostek"]);
		$karyawan_jamsostek=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_jamsostek);
		$karyawan_jamsostek=str_replace(",", ",",$karyawan_jamsostek);
		$karyawan_jamsostek=str_replace("'", '"',$karyawan_jamsostek);
		
		$karyawan_sip=trim(@$_POST["karyawan_sip"]);
		$karyawan_sip=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_sip);
		$karyawan_sip=str_replace(",", ",",$karyawan_sip);
		$karyawan_sip=str_replace("'", '"',$karyawan_sip);
		$karyawan_npwp=trim(@$_POST["karyawan_npwp"]);
		$karyawan_npwp=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_npwp);
		$karyawan_npwp=str_replace(",", ",",$karyawan_npwp);
		$karyawan_npwp=str_replace("'", '"',$karyawan_npwp);
		$karyawan_username=trim(@$_POST["karyawan_username"]);
		$karyawan_username=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_username);
		$karyawan_username=str_replace(",", ",",$karyawan_username);
		$karyawan_username=str_replace("'", '"',$karyawan_username);
		$karyawan_jmlanak=trim(@$_POST["karyawan_jmlanak"]);
		$karyawan_jmlanak=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_jmlanak);
		$karyawan_jmlanak=str_replace(",", ",",$karyawan_jmlanak);
		$karyawan_jmlanak=str_replace("'", '"',$karyawan_jmlanak);
		$karyawan_nama=trim(@$_POST["karyawan_nama"]);
		$karyawan_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_nama);
		$karyawan_nama=str_replace(",", ",",$karyawan_nama);
		$karyawan_nama=str_replace("'", '"',$karyawan_nama);
		$karyawan_kelamin=trim(@$_POST["karyawan_kelamin"]);
		$karyawan_kelamin=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_kelamin);
		$karyawan_kelamin=str_replace(",", ",",$karyawan_kelamin);
		$karyawan_kelamin=str_replace("'", '"',$karyawan_kelamin);
		/*
		$karyawan_pph21=trim(@$_POST["karyawan_pph21"]);
		$karyawan_pph21=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_pph21);
		$karyawan_pph21=str_replace(",", ",",$karyawan_pph21);
		$karyawan_pph21=str_replace("'", '"',$karyawan_pph21);
		*/
		$karyawan_marriage=trim(@$_POST["karyawan_marriage"]);
		$karyawan_marriage=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_marriage);
		$karyawan_marriage=str_replace(",", ",",$karyawan_marriage);
		$karyawan_marriage=str_replace("'", '"',$karyawan_marriage);
		$karyawan_tgllahir=trim(@$_POST["karyawan_tgllahir"]);
		$karyawan_tmplahir=trim(@$_POST["karyawan_tmplahir"]);
		$karyawan_tmplahir=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_tmplahir);
		$karyawan_tmplahir=str_replace(",", ",",$karyawan_tmplahir);
		$karyawan_tmplahir=str_replace("'", '"',$karyawan_tmplahir);
		$karyawan_alamat=trim(@$_POST["karyawan_alamat"]);
		$karyawan_alamat=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_alamat);
		$karyawan_alamat=str_replace(",", ",",$karyawan_alamat);
		$karyawan_alamat=str_replace("'", '"',$karyawan_alamat);
		$karyawan_kota=trim(@$_POST["karyawan_kota"]);
		$karyawan_kota=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_kota);
		$karyawan_kota=str_replace(",", ",",$karyawan_kota);
		$karyawan_kota=str_replace("'", '"',$karyawan_kota);
		$karyawan_kodepos=trim(@$_POST["karyawan_kodepos"]);
		$karyawan_kodepos=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_kodepos);
		$karyawan_kodepos=str_replace(",", ",",$karyawan_kodepos);
		$karyawan_kodepos=str_replace("'", '"',$karyawan_kodepos);
		$karyawan_email=trim(@$_POST["karyawan_email"]);
		$karyawan_email=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_email);
		$karyawan_email=str_replace(",", ",",$karyawan_email);
		$karyawan_email=str_replace("'", '"',$karyawan_email);
		$karyawan_emiracle=trim(@$_POST["karyawan_emiracle"]);
		$karyawan_emiracle=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_emiracle);
		$karyawan_emiracle=str_replace(",", ",",$karyawan_emiracle);
		$karyawan_emiracle=str_replace("'", '"',$karyawan_emiracle);
		$karyawan_keterangan=trim(@$_POST["karyawan_keterangan"]);
		$karyawan_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_keterangan);
		$karyawan_keterangan=str_replace(",", ",",$karyawan_keterangan);
		$karyawan_keterangan=str_replace("'", '"',$karyawan_keterangan);
		$karyawan_notelp=trim(@$_POST["karyawan_notelp"]);
		$karyawan_notelp=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_notelp);
		$karyawan_notelp=str_replace(",", ",",$karyawan_notelp);
		$karyawan_notelp=str_replace("'", '"',$karyawan_notelp);
		$karyawan_notelp2=trim(@$_POST["karyawan_notelp2"]);
		$karyawan_notelp2=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_notelp2);
		$karyawan_notelp2=str_replace(",", ",",$karyawan_notelp2);
		$karyawan_notelp2=str_replace("'", '"',$karyawan_notelp2);
		$karyawan_notelp3=trim(@$_POST["karyawan_notelp3"]);
		$karyawan_notelp3=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_notelp3);
		$karyawan_notelp3=str_replace(",", ",",$karyawan_notelp3);
		$karyawan_notelp3=str_replace("'", '"',$karyawan_notelp3);
		$karyawan_notelp4=trim(@$_POST["karyawan_notelp4"]);
		$karyawan_notelp4=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_notelp4);
		$karyawan_notelp4=str_replace(",", ",",$karyawan_notelp4);
		$karyawan_notelp4=str_replace("'", '"',$karyawan_notelp4);
		$karyawan_cabang=trim(@$_POST["karyawan_cabang"]);
		/*
		$karyawan_jabatan=trim(@$_POST["karyawan_jabatan"]);
		$karyawan_departemen=trim(@$_POST["karyawan_departemen"]);
		$karyawan_golongantxt=trim(@$_POST["karyawan_golongantxt"]);
		$karyawan_golongantxt=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_golongantxt);
		$karyawan_golongantxt=str_replace("'", '"',$karyawan_golongantxt);
		if($karyawan_golongantxt<>"")
			$karyawan_idgolongan=$karyawan_golongantxt;
		else 
			$karyawan_idgolongan=trim(@$_POST["karyawan_idgolongan"]);
		*/
		$karyawan_tglmasuk=trim(@$_POST["karyawan_tglmasuk"]);
		//$karyawan_atasan=trim(@$_POST["karyawan_atasan"]);
		$karyawan_aktif=trim(@$_POST["karyawan_aktif"]);
		$karyawan_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_aktif);
		$karyawan_aktif=str_replace(",", ",",$karyawan_aktif);
		$karyawan_aktif=str_replace("'", '"',$karyawan_aktif);
		$karyawan_creator=trim(@$_POST["karyawan_creator"]);
		$karyawan_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_creator);
		$karyawan_creator=str_replace(",", ",",$karyawan_creator);
		$karyawan_creator=str_replace("'", '"',$karyawan_creator);
		$karyawan_date_create=trim(@$_POST["karyawan_date_create"]);
		$karyawan_update=trim(@$_POST["karyawan_update"]);
		$karyawan_update=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_update);
		$karyawan_update=str_replace(",", ",",$karyawan_update);
		$karyawan_update=str_replace("'", '"',$karyawan_update);
		$karyawan_date_update=trim(@$_POST["karyawan_date_update"]);
		$karyawan_revised=trim(@$_POST["karyawan_revised"]);
		$karyawan_cab_th=trim(@$_POST["karyawan_cab_th"]);
		$karyawan_cab_th=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_th);
		$karyawan_cab_th=str_replace(",", ",",$karyawan_cab_th);
		$karyawan_cab_th=str_replace("'", '"',$karyawan_cab_th);
		$karyawan_cab_ki=trim(@$_POST["karyawan_cab_ki"]);
		$karyawan_cab_ki=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_ki);
		$karyawan_cab_ki=str_replace(",", ",",$karyawan_cab_ki);
		$karyawan_cab_ki=str_replace("'", '"',$karyawan_cab_ki);
		$karyawan_cab_hr=trim(@$_POST["karyawan_cab_hr"]);
		$karyawan_cab_hr=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_hr);
		$karyawan_cab_hr=str_replace(",", ",",$karyawan_cab_hr);
		$karyawan_cab_hr=str_replace("'", '"',$karyawan_cab_hr);
		$karyawan_cab_tp=trim(@$_POST["karyawan_cab_tp"]);
		$karyawan_cab_tp=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_tp);
		$karyawan_cab_tp=str_replace(",", ",",$karyawan_cab_tp);
		$karyawan_cab_tp=str_replace("'", '"',$karyawan_cab_tp);
		$karyawan_cab_dps=trim(@$_POST["karyawan_cab_dps"]);
		$karyawan_cab_dps=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_dps);
		$karyawan_cab_dps=str_replace(",", ",",$karyawan_cab_dps);
		$karyawan_cab_dps=str_replace("'", '"',$karyawan_cab_dps);
		$karyawan_cab_jkt=trim(@$_POST["karyawan_cab_jkt"]);
		$karyawan_cab_jkt=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_jkt);
		$karyawan_cab_jkt=str_replace(",", ",",$karyawan_cab_jkt);
		$karyawan_cab_jkt=str_replace("'", '"',$karyawan_cab_jkt);
		$karyawan_cab_mta=trim(@$_POST["karyawan_cab_mta"]);
		$karyawan_cab_mta=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_mta);
		$karyawan_cab_mta=str_replace(",", ",",$karyawan_cab_mta);
		$karyawan_cab_mta=str_replace("'", '"',$karyawan_cab_mta);
		$karyawan_cab_blpn=trim(@$_POST["karyawan_cab_blpn"]);
		$karyawan_cab_blpn=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_blpn);
		$karyawan_cab_blpn=str_replace(",", ",",$karyawan_cab_blpn);
		$karyawan_cab_blpn=str_replace("'", '"',$karyawan_cab_blpn);
		$karyawan_cab_kuta=trim(@$_POST["karyawan_cab_kuta"]);
		$karyawan_cab_kuta=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_kuta);
		$karyawan_cab_kuta=str_replace(",", ",",$karyawan_cab_kuta);
		$karyawan_cab_kuta=str_replace("'", '"',$karyawan_cab_kuta);
		$karyawan_cab_btm=trim(@$_POST["karyawan_cab_btm"]);
		$karyawan_cab_btm=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_btm);
		$karyawan_cab_btm=str_replace(",", ",",$karyawan_cab_btm);
		$karyawan_cab_btm=str_replace("'", '"',$karyawan_cab_btm);
		$karyawan_cab_mks=trim(@$_POST["karyawan_cab_mks"]);
		$karyawan_cab_mks=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_mks);
		$karyawan_cab_mks=str_replace(",", ",",$karyawan_cab_mks);
		$karyawan_cab_mks=str_replace("'", '"',$karyawan_cab_mks);
		$karyawan_cab_mdn=trim(@$_POST["karyawan_cab_mdn"]);
		$karyawan_cab_mdn=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_mdn);
		$karyawan_cab_mdn=str_replace(",", ",",$karyawan_cab_mdn);
		$karyawan_cab_mdn=str_replace("'", '"',$karyawan_cab_mdn);
		$karyawan_cab_lbk=trim(@$_POST["karyawan_cab_lbk"]);
		$karyawan_cab_lbk=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_lbk);
		$karyawan_cab_lbk=str_replace(",", ",",$karyawan_cab_lbk);
		$karyawan_cab_lbk=str_replace("'", '"',$karyawan_cab_lbk);
		$karyawan_cab_mnd=trim(@$_POST["karyawan_cab_mnd"]);
		$karyawan_cab_mnd=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_mnd);
		$karyawan_cab_mnd=str_replace(",", ",",$karyawan_cab_mnd);
		$karyawan_cab_mnd=str_replace("'", '"',$karyawan_cab_mnd);
		$karyawan_cab_ygk=trim(@$_POST["karyawan_cab_ygk"]);
		$karyawan_cab_ygk=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_ygk);
		$karyawan_cab_ygk=str_replace(",", ",",$karyawan_cab_ygk);
		$karyawan_cab_ygk=str_replace("'", '"',$karyawan_cab_ygk);
		$karyawan_cab_sjl=trim(@$_POST["karyawan_cab_sjl"]);
		$karyawan_cab_sjl=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_sjl);
		$karyawan_cab_sjl=str_replace(",", ",",$karyawan_cab_sjl);
		$karyawan_cab_sjl=str_replace("'", '"',$karyawan_cab_sjl);
		$karyawan_cab_smg=trim(@$_POST["karyawan_cab_smg"]);
		$karyawan_cab_smg=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_smg);
		$karyawan_cab_smg=str_replace(",", ",",$karyawan_cab_smg);
		$karyawan_cab_smg=str_replace("'", '"',$karyawan_cab_smg);
		$karyawan_cab_mlg=trim(@$_POST["karyawan_cab_mlg"]);
		$karyawan_cab_mlg=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_mlg);
		$karyawan_cab_mlg=str_replace(",", ",",$karyawan_cab_mlg);
		$karyawan_cab_mlg=str_replace("'", '"',$karyawan_cab_mlg);
		$karyawan_cab_corp=trim(@$_POST["karyawan_cab_corp"]);
		$karyawan_cab_corp=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_corp);
		$karyawan_cab_corp=str_replace(",", ",",$karyawan_cab_corp);
		$karyawan_cab_corp=str_replace("'", '"',$karyawan_cab_corp);
		$karyawan_cab_maa=trim(@$_POST["karyawan_cab_maa"]);
		$karyawan_cab_maa=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_maa);
		$karyawan_cab_maa=str_replace(",", ",",$karyawan_cab_maa);
		$karyawan_cab_maa=str_replace("'", '"',$karyawan_cab_maa);
		$karyawan_cab_mg=trim(@$_POST["karyawan_cab_mg"]);
		$karyawan_cab_mg=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_mg);
		$karyawan_cab_mg=str_replace(",", ",",$karyawan_cab_mg);
		$karyawan_cab_mg=str_replace("'", '"',$karyawan_cab_mg);
		$karyawan_cabang=trim(@$_POST["karyawan_cabang"]);
		$karyawan_cabang=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cabang);
		$karyawan_cabang=str_replace(",", ",",$karyawan_cabang);
		$karyawan_cabang=str_replace("'", '"',$karyawan_cabang);
		
		$result = $this->m_karyawan->karyawan_update($karyawan_id ,$karyawan_no, $karyawan_noktp, $karyawan_alamatktp, $karyawan_agama, $karyawan_bank, $karyawan_bankcabang, $karyawan_norekening, $karyawan_atasnama, $karyawan_atasnama, $karyawan_jamsostek, $karyawan_sip, $karyawan_npwp ,$karyawan_username ,$karyawan_nama ,$karyawan_kelamin , $karyawan_marriage, $karyawan_jmlanak, $karyawan_tgllahir ,$karyawan_tmplahir, $karyawan_alamat ,$karyawan_kota ,$karyawan_kodepos ,$karyawan_email ,$karyawan_emiracle ,$karyawan_keterangan ,$karyawan_notelp ,$karyawan_notelp2 ,$karyawan_notelp3, $karyawan_notelp4 ,$karyawan_cabang, $karyawan_tglmasuk, $karyawan_aktif ,$karyawan_creator ,$karyawan_date_create ,$karyawan_update ,$karyawan_date_update ,$karyawan_revised, $karyawan_cab_th ,$karyawan_cab_ki ,$karyawan_cab_hr ,$karyawan_cab_tp ,$karyawan_cab_dps ,$karyawan_cab_jkt ,$karyawan_cab_mta ,$karyawan_cab_blpn ,$karyawan_cab_kuta ,$karyawan_cab_btm ,$karyawan_cab_mks ,$karyawan_cab_mdn ,$karyawan_cab_lbk ,$karyawan_cab_mnd ,$karyawan_cab_ygk,$karyawan_cab_smg, $karyawan_cab_sjl,$karyawan_cab_mlg ,$karyawan_cab_corp ,$karyawan_cab_maa,$karyawan_cab_mg );
		echo $result;
	}
	
	
	//function for create new record
	function karyawan_create(){
		//POST varible here
		//auto increment, don't accept anything from form values
		$karyawan_no=trim(@$_POST["karyawan_no"]);
		$karyawan_no=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_no);
		$karyawan_no=str_replace("'", '"',$karyawan_no);
		$karyawan_noktp=trim(@$_POST["karyawan_noktp"]);
		$karyawan_noktp=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_noktp);
		$karyawan_noktp=str_replace("'", '"',$karyawan_noktp);
		$karyawan_alamatktp=trim(@$_POST["karyawan_alamatktp"]);
		$karyawan_alamatktp=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_alamatktp);
		$karyawan_alamatktp=str_replace("'", '"',$karyawan_alamatktp);
		$karyawan_agama=trim(@$_POST["karyawan_agama"]);
		$karyawan_agama=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_agama);
		$karyawan_agama=str_replace("'", '"',$karyawan_agama);
		$karyawan_bank=trim(@$_POST["karyawan_bank"]);
		$karyawan_bank=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_bank);
		$karyawan_bank=str_replace("'", '"',$karyawan_bank);
		$karyawan_bankcabang=trim(@$_POST["karyawan_bankcabang"]);
		$karyawan_bankcabang=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_bankcabang);
		$karyawan_bankcabang=str_replace("'", '"',$karyawan_bankcabang);
		$karyawan_norekening=trim(@$_POST["karyawan_norekening"]);
		$karyawan_norekening=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_norekening);
		$karyawan_norekening=str_replace("'", '"',$karyawan_norekening);
		$karyawan_atasnama=trim(@$_POST["karyawan_atasnama"]);
		$karyawan_atasnama=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_atasnama);
		$karyawan_atasnama=str_replace("'", '"',$karyawan_atasnama);
		$karyawan_jamsostek=trim(@$_POST["karyawan_jamsostek"]);
		$karyawan_jamsostek=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_jamsostek);
		$karyawan_jamsostek=str_replace("'", '"',$karyawan_jamsostek);
		$karyawan_sip=trim(@$_POST["karyawan_sip"]);
		$karyawan_sip=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_sip);
		$karyawan_sip=str_replace("'", '"',$karyawan_sip);
		$karyawan_npwp=trim(@$_POST["karyawan_npwp"]);
		$karyawan_npwp=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_npwp);
		$karyawan_npwp=str_replace("'", '"',$karyawan_npwp);
		$karyawan_username=trim(@$_POST["karyawan_username"]);
		$karyawan_username=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_username);
		$karyawan_username=str_replace("'", '"',$karyawan_username);
		$karyawan_jmlanak=trim(@$_POST["karyawan_jmlanak"]);
		$karyawan_jmlanak=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_jmlanak);
		$karyawan_jmlanak=str_replace("'", '"',$karyawan_jmlanak);
		$karyawan_nama=trim(@$_POST["karyawan_nama"]);
		$karyawan_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_nama);
		$karyawan_nama=str_replace("'", '"',$karyawan_nama);
		$karyawan_kelamin=trim(@$_POST["karyawan_kelamin"]);
		$karyawan_kelamin=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_kelamin);
		$karyawan_kelamin=str_replace("'", '"',$karyawan_kelamin);
		//$karyawan_pph21=trim(@$_POST["karyawan_pph21"]);
		//$karyawan_pph21=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_pph21);
		//$karyawan_pph21=str_replace("'", '"',$karyawan_pph21);
		$karyawan_marriage=trim(@$_POST["karyawan_marriage"]);
		$karyawan_marriage=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_marriage);
		$karyawan_marriage=str_replace("'", '"',$karyawan_marriage);
		$karyawan_tgllahir=trim(@$_POST["karyawan_tgllahir"]);
		$karyawan_tmplahir=trim(@$_POST["karyawan_tmplahir"]);
		$karyawan_tmplahir=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_tmplahir);
		$karyawan_tmplahir=str_replace("'", '"',$karyawan_tmplahir);
		$karyawan_alamat=trim(@$_POST["karyawan_alamat"]);
		$karyawan_alamat=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_alamat);
		$karyawan_alamat=str_replace("'", '"',$karyawan_alamat);
		$karyawan_kota=trim(@$_POST["karyawan_kota"]);
		$karyawan_kota=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_kota);
		$karyawan_kota=str_replace("'", '"',$karyawan_kota);
		$karyawan_kodepos=trim(@$_POST["karyawan_kodepos"]);
		$karyawan_kodepos=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_kodepos);
		$karyawan_kodepos=str_replace("'", '"',$karyawan_kodepos);
		$karyawan_email=trim(@$_POST["karyawan_email"]);
		$karyawan_email=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_email);
		$karyawan_email=str_replace("'", '"',$karyawan_email);
		$karyawan_emiracle=trim(@$_POST["karyawan_emiracle"]);
		$karyawan_emiracle=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_emiracle);
		$karyawan_emiracle=str_replace("'", '"',$karyawan_emiracle);
		$karyawan_keterangan=trim(@$_POST["karyawan_keterangan"]);
		$karyawan_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_keterangan);
		$karyawan_keterangan=str_replace("'", '"',$karyawan_keterangan);
		$karyawan_notelp=trim(@$_POST["karyawan_notelp"]);
		$karyawan_notelp=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_notelp);
		$karyawan_notelp=str_replace("'", '"',$karyawan_notelp);
		$karyawan_notelp2=trim(@$_POST["karyawan_notelp2"]);
		$karyawan_notelp2=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_notelp2);
		$karyawan_notelp2=str_replace("'", '"',$karyawan_notelp2);
		$karyawan_notelp3=trim(@$_POST["karyawan_notelp3"]);
		$karyawan_notelp3=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_notelp3);
		$karyawan_notelp3=str_replace("'", '"',$karyawan_notelp3);
		$karyawan_notelp4=trim(@$_POST["karyawan_notelp4"]);
		$karyawan_notelp4=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_notelp4);
		$karyawan_notelp4=str_replace(",", ",",$karyawan_notelp4);
		$karyawan_notelp4=str_replace("'", '"',$karyawan_notelp4);
		$karyawan_cabang=trim(@$_POST["karyawan_cabang"]);
		//$karyawan_jabatan=trim(@$_POST["karyawan_jabatan"]);
		//$karyawan_departemen=trim(@$_POST["karyawan_departemen"]);
		//$karyawan_golongantxt=trim(@$_POST["karyawan_golongantxt"]);
		//$karyawan_golongantxt=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_golongantxt);
		//$karyawan_golongantxt=str_replace("'", '"',$karyawan_golongantxt);
		//if($karyawan_golongantxt<>"")
		//	$karyawan_idgolongan=$karyawan_golongantxt;
		//else 
		//	$karyawan_idgolongan=trim(@$_POST["karyawan_idgolongan"]);
		$karyawan_tglmasuk=trim(@$_POST["karyawan_tglmasuk"]);
		//$karyawan_tglbatas=trim(@$_POST["karyawan_tgl_batas"]);
		//$karyawan_atasan=trim(@$_POST["karyawan_atasan"]);
		$karyawan_aktif=trim(@$_POST["karyawan_aktif"]);
		$karyawan_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_aktif);
		$karyawan_aktif=str_replace("'", '"',$karyawan_aktif);
		$karyawan_creator=trim(@$_POST["karyawan_creator"]);
		$karyawan_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_creator);
		$karyawan_creator=str_replace("'", '"',$karyawan_creator);
		$karyawan_date_create=trim(@$_POST["karyawan_date_create"]);
		$karyawan_update=trim(@$_POST["karyawan_update"]);
		$karyawan_update=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_update);
		$karyawan_update=str_replace("'", '"',$karyawan_update);
		$karyawan_date_update=trim(@$_POST["karyawan_date_update"]);
		$karyawan_revised=trim(@$_POST["karyawan_revised"]);
		$karyawan_cab_th=trim(@$_POST["karyawan_cab_th"]);
		$karyawan_cab_th=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_th);
		$karyawan_cab_th=str_replace("'", '"',$karyawan_cab_th);
		$karyawan_cab_ki=trim(@$_POST["karyawan_cab_ki"]);
		$karyawan_cab_ki=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_ki);
		$karyawan_cab_ki=str_replace("'", '"',$karyawan_cab_ki);
		$karyawan_cab_hr=trim(@$_POST["karyawan_cab_hr"]);
		$karyawan_cab_hr=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_hr);
		$karyawan_cab_hr=str_replace("'", '"',$karyawan_cab_hr);
		$karyawan_cab_tp=trim(@$_POST["karyawan_cab_tp"]);
		$karyawan_cab_tp=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_tp);
		$karyawan_cab_tp=str_replace("'", '"',$karyawan_cab_tp);
		$karyawan_cab_dps=trim(@$_POST["karyawan_cab_dps"]);
		$karyawan_cab_dps=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_dps);
		$karyawan_cab_dps=str_replace("'", '"',$karyawan_cab_dps);
		$karyawan_cab_jkt=trim(@$_POST["karyawan_cab_jkt"]);
		$karyawan_cab_jkt=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_jkt);
		$karyawan_cab_jkt=str_replace("'", '"',$karyawan_cab_jkt);
		$karyawan_cab_mta=trim(@$_POST["karyawan_cab_mta"]);
		$karyawan_cab_mta=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_mta);
		$karyawan_cab_mta=str_replace("'", '"',$karyawan_cab_mta);
		$karyawan_cab_blpn=trim(@$_POST["karyawan_cab_blpn"]);
		$karyawan_cab_blpn=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_blpn);
		$karyawan_cab_blpn=str_replace("'", '"',$karyawan_cab_blpn);
		$karyawan_cab_kuta=trim(@$_POST["karyawan_cab_kuta"]);
		$karyawan_cab_kuta=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_kuta);
		$karyawan_cab_kuta=str_replace("'", '"',$karyawan_cab_kuta);
		$karyawan_cab_btm=trim(@$_POST["karyawan_cab_btm"]);
		$karyawan_cab_btm=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_btm);
		$karyawan_cab_btm=str_replace("'", '"',$karyawan_cab_btm);
		$karyawan_cab_mks=trim(@$_POST["karyawan_cab_mks"]);
		$karyawan_cab_mks=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_mks);
		$karyawan_cab_mks=str_replace("'", '"',$karyawan_cab_mks);
		$karyawan_cab_mdn=trim(@$_POST["karyawan_cab_mdn"]);
		$karyawan_cab_mdn=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_mdn);
		$karyawan_cab_mdn=str_replace("'", '"',$karyawan_cab_mdn);
		$karyawan_cab_lbk=trim(@$_POST["karyawan_cab_lbk"]);
		$karyawan_cab_lbk=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_lbk);
		$karyawan_cab_lbk=str_replace("'", '"',$karyawan_cab_lbk);
		$karyawan_cab_mnd=trim(@$_POST["karyawan_cab_mnd"]);
		$karyawan_cab_mnd=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_mnd);
		$karyawan_cab_mnd=str_replace("'", '"',$karyawan_cab_mnd);
		$karyawan_cab_ygk=trim(@$_POST["karyawan_cab_ygk"]);
		$karyawan_cab_ygk=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_ygk);
		$karyawan_cab_ygk=str_replace("'", '"',$karyawan_cab_ygk);		
		$karyawan_cab_sjl=trim(@$_POST["karyawan_cab_sjl"]);
		$karyawan_cab_sjl=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_sjl);
		$karyawan_cab_sjl=str_replace("'", '"',$karyawan_cab_sjl);	
		$karyawan_cab_smg=trim(@$_POST["karyawan_cab_smg"]);
		$karyawan_cab_smg=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_smg);
		$karyawan_cab_smg=str_replace("'", '"',$karyawan_cab_smg);	
		$karyawan_cab_mlg=trim(@$_POST["karyawan_cab_mlg"]);
		$karyawan_cab_mlg=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_mlg);
		$karyawan_cab_mlg=str_replace("'", '"',$karyawan_cab_mlg);
		$karyawan_cab_corp=trim(@$_POST["karyawan_cab_corp"]);
		$karyawan_cab_corp=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_corp);
		$karyawan_cab_corp=str_replace("'", '"',$karyawan_cab_corp);
		$karyawan_cab_maa=trim(@$_POST["karyawan_cab_maa"]);
		$karyawan_cab_maa=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_maa);
		$karyawan_cab_maa=str_replace("'", '"',$karyawan_cab_maa);
		$karyawan_cab_mg=trim(@$_POST["karyawan_cab_mg"]);
		$karyawan_cab_mg=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cab_mg);
		$karyawan_cab_mg=str_replace("'", '"',$karyawan_cab_mg);
		$karyawan_cabang=trim(@$_POST["karyawan_cabang"]);
		$karyawan_cabang=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cabang);
		$karyawan_cabang=str_replace("'", '"',$karyawan_cabang);
		$cabang_date_create=trim(@$_POST["cabang_date_create"]);
		$cabang_date_create=str_replace("/(<\/?)(p)([^>]*>)", "",$cabang_date_create);
		$cabang_date_create=str_replace("'", '"',$cabang_date_create);
		
		$result=$this->m_karyawan->karyawan_create($karyawan_no, $karyawan_noktp, $karyawan_alamatktp, $karyawan_agama, $karyawan_bank, $karyawan_bankcabang, $karyawan_norekening, $karyawan_atasnama, $karyawan_jamsostek, $karyawan_sip, $karyawan_npwp ,$karyawan_username ,$karyawan_nama ,$karyawan_kelamin ,$karyawan_marriage, $karyawan_jmlanak, $karyawan_tgllahir, $karyawan_tglmasuk, $karyawan_tmplahir ,$karyawan_alamat ,$karyawan_kota ,$karyawan_kodepos ,$karyawan_email ,$karyawan_emiracle ,$karyawan_keterangan ,$karyawan_notelp ,$karyawan_notelp2 ,$karyawan_notelp3, $karyawan_notelp4 ,$karyawan_cabang, $karyawan_aktif ,$karyawan_creator ,$karyawan_date_create ,$karyawan_update ,$karyawan_date_update ,$karyawan_revised, $karyawan_cab_th ,$karyawan_cab_ki ,$karyawan_cab_hr ,$karyawan_cab_tp ,$karyawan_cab_dps ,$karyawan_cab_jkt ,$karyawan_cab_mta ,$karyawan_cab_blpn ,$karyawan_cab_kuta ,$karyawan_cab_btm ,$karyawan_cab_mks ,$karyawan_cab_mdn ,$karyawan_cab_lbk ,$karyawan_cab_mnd ,$karyawan_cab_ygk, $karyawan_cab_smg,$karyawan_cab_sjl, $karyawan_cab_mlg ,$karyawan_cab_corp ,$karyawan_cab_maa,$karyawan_cab_mg,$cabang_date_create );
		echo $result;
	}

	//function for delete selected record
	function karyawan_delete(){
		$ids = $_POST['ids']; // Get our array back and translate it :
		$pkid = json_decode(stripslashes($ids));
		$result=$this->m_karyawan->karyawan_delete($pkid);
		echo $result;
	}

	//function for advanced search
	function karyawan_search(){
		//POST varibale here
		// GENERAL SEARCH
		$karyawan_id=trim(@$_POST["karyawan_id"]);
		$karyawan_cabang=trim(@$_POST["karyawan_cabang"]);
		$karyawan_no=trim(@$_POST["karyawan_no"]);
		$karyawan_no=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_no);
		$karyawan_no=str_replace("'", '"',$karyawan_no);
		$karyawan_npwp=trim(@$_POST["karyawan_npwp"]);
		$karyawan_npwp=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_npwp);
		$karyawan_npwp=str_replace("'", '"',$karyawan_npwp);
		$karyawan_jamsostek=trim(@$_POST["karyawan_jamsostek"]);
		$karyawan_jamsostek=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_jamsostek);
		$karyawan_jamsostek=str_replace("'", '"',$karyawan_jamsostek);
		$karyawan_sip=trim(@$_POST["karyawan_sip"]);
		$karyawan_sip=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_sip);
		$karyawan_sip=str_replace("'", '"',$karyawan_sip);
		$karyawan_noktp=trim(@$_POST["karyawan_noktp"]);
		$karyawan_noktp=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_noktp);
		$karyawan_noktp=str_replace("'", '"',$karyawan_noktp);
		$karyawan_alamatktp=trim(@$_POST["karyawan_alamatktp"]);
		$karyawan_alamatktp=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_alamatktp);
		$karyawan_alamatktp=str_replace("'", '"',$karyawan_alamatktp);
		$karyawan_username=trim(@$_POST["karyawan_username"]);
		$karyawan_username=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_username);
		$karyawan_username=str_replace("'", '"',$karyawan_username);
		$karyawan_nama=trim(@$_POST["karyawan_nama"]);
		$karyawan_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_nama);
		$karyawan_nama=str_replace("'", '"',$karyawan_nama);
		$karyawan_kelamin=trim(@$_POST["karyawan_kelamin"]);
		$karyawan_kelamin=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_kelamin);
		$karyawan_kelamin=str_replace("'", '"',$karyawan_kelamin);
		$karyawan_marriage=trim(@$_POST["karyawan_marriage"]);
		$karyawan_marriage=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_marriage);
		$karyawan_marriage=str_replace("'", '"',$karyawan_marriage);
		$karyawan_jmlanak=trim(@$_POST["karyawan_jmlanak"]);
		$karyawan_jmlanak=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_jmlanak);
		$karyawan_jmlanak=str_replace("'", '"',$karyawan_jmlanak);
		$karyawan_agama=trim(@$_POST["karyawan_agama"]);
		$karyawan_agama=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_agama);
		$karyawan_agama=str_replace("'", '"',$karyawan_agama);
		$karyawan_tglmasuk=trim(@$_POST["karyawan_tglmasuk"]);
		$karyawan_keterangan=trim(@$_POST["karyawan_keterangan"]);
		$karyawan_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_keterangan);
		$karyawan_keterangan=str_replace("'", '"',$karyawan_keterangan);
		$karyawan_aktif=trim(@$_POST["karyawan_aktif"]);
		$karyawan_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_aktif);
		$karyawan_aktif=str_replace("'", '"',$karyawan_aktif);
		// ALAMAT KONTAK SEARCH
		$karyawan_alamat=trim(@$_POST["karyawan_alamat"]);
		$karyawan_alamat=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_alamat);
		$karyawan_alamat=str_replace("'", '"',$karyawan_alamat);
		$karyawan_kota=trim(@$_POST["karyawan_kota"]);
		$karyawan_kota=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_kota);
		$karyawan_kota=str_replace("'", '"',$karyawan_kota);
		$karyawan_kodepos=trim(@$_POST["karyawan_kodepos"]);
		$karyawan_kodepos=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_kodepos);
		$karyawan_kodepos=str_replace("'", '"',$karyawan_kodepos);
		$karyawan_notelp=trim(@$_POST["karyawan_notelp"]);
		$karyawan_notelp=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_notelp);
		$karyawan_notelp=str_replace("'", '"',$karyawan_notelp);
		$karyawan_email=trim(@$_POST["karyawan_email"]);
		$karyawan_email=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_email);
		$karyawan_email=str_replace("'", '"',$karyawan_email);
		// INFO REKENING SEARCH
		$karyawan_bank=trim(@$_POST["karyawan_bank"]);
		$karyawan_bank=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_bank);
		$karyawan_bank=str_replace("'", '"',$karyawan_bank);
		$karyawan_bankcabang=trim(@$_POST["karyawan_bankcabang"]);
		$karyawan_bankcabang=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_bankcabang);
		$karyawan_bankcabang=str_replace("'", '"',$karyawan_bankcabang);
		$karyawan_norekening=trim(@$_POST["karyawan_norekening"]);
		$karyawan_norekening=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_norekening);
		$karyawan_norekening=str_replace("'", '"',$karyawan_norekening);
		$karyawan_atasnama=trim(@$_POST["karyawan_atasnama"]);
		$karyawan_atasnama=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_atasnama);
		$karyawan_atasnama=str_replace("'", '"',$karyawan_atasnama);
		// STATUS KEKARYAWANAN SEARCH
		$karyawan_statuskekaryawanan=trim(@$_POST["karyawan_statuskekaryawanan"]);
		$karyawan_statuskekaryawanan=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_statuskekaryawanan);
		$karyawan_statuskekaryawanan=str_replace("'", '"',$karyawan_statuskekaryawanan);
		$karyawan_statustglawalawal=trim(@$_POST["karyawan_statustglawalawal"]);
		$karyawan_statustglawalakhir=trim(@$_POST["karyawan_statustglawalakhir"]);
		$karyawan_statustglakhirawal=trim(@$_POST["karyawan_statustglakhirawal"]);
		$karyawan_statustglakhirakhir=trim(@$_POST["karyawan_statustglakhirakhir"]);
		$karyawan_statuskaryawan=trim(@$_POST["karyawan_statuskaryawan"]);
		$karyawan_statuskaryawan=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_statuskaryawan);
		$karyawan_statuskaryawan=str_replace("'", '"',$karyawan_statuskaryawan);
		// JABATAN SEARCH
		$karyawan_jabatan=trim(@$_POST["karyawan_jabatan"]);
		$karyawan_departemen=trim(@$_POST["karyawan_departemen"]);
		$karyawan_idgolongan=trim(@$_POST["karyawan_idgolongan"]);
		$karyawan_atasan=trim(@$_POST["karyawan_atasan"]);
		$karyawan_pph21=trim(@$_POST["karyawan_pph21"]);
		$karyawan_pph21=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_pph21);
		$karyawan_pph21=str_replace("'", '"',$karyawan_pph21);
		$karyawan_tgljbtawalawal=trim(@$_POST["karyawan_tgljbtawalawal"]);
		$karyawan_tgljbtawalakhir=trim(@$_POST["karyawan_tgljbtawalakhir"]);
		$karyawan_tgljbtakhirawal=trim(@$_POST["karyawan_tgljbtakhirawal"]);
		$karyawan_tgljbtakhirakhir=trim(@$_POST["karyawan_tgljbtakhirakhir"]);
		$karyawan_jabatanketerangan=trim(@$_POST["karyawan_jabatanketerangan"]);
		$karyawan_jabatanketerangan=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_jabatanketerangan);
		$karyawan_jabatanketerangan=str_replace("'", '"',$karyawan_jabatanketerangan);
		// PENDIDIKAN SEARCH
		$karyawan_pendidikan=trim(@$_POST["karyawan_pendidikan"]);
		$karyawan_pendidikan=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_pendidikan);
		$karyawan_pendidikan=str_replace("'", '"',$karyawan_pendidikan);
		$karyawan_namasekolah=trim(@$_POST["karyawan_namasekolah"]);
		$karyawan_namasekolah=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_namasekolah);
		$karyawan_namasekolah=str_replace("'", '"',$karyawan_namasekolah);
		$karyawan_jurusan=trim(@$_POST["karyawan_jurusan"]);
		$karyawan_jurusan=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_jurusan);
		$karyawan_jurusan=str_replace("'", '"',$karyawan_jurusan);
		$karyawan_thnmskawal=trim(@$_POST["karyawan_thnmskawal"]);
		$karyawan_thnmskawal=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_thnmskawal);
		$karyawan_thnmskawal=str_replace("'", '"',$karyawan_thnmskawal);
		$karyawan_thnmskakhir=trim(@$_POST["karyawan_thnmskakhir"]);
		$karyawan_thnmskakhir=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_thnmskakhir);
		$karyawan_thnmskakhir=str_replace("'", '"',$karyawan_thnmskakhir);
		$karyawan_thnslsawal=trim(@$_POST["karyawan_thnslsawal"]);
		$karyawan_thnslsawal=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_thnslsawal);
		$karyawan_thnslsawal=str_replace("'", '"',$karyawan_thnslsawal);
		$karyawan_thnslsakhir=trim(@$_POST["karyawan_thnslsakhir"]);
		$karyawan_thnslsakhir=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_thnslsakhir);
		$karyawan_thnslsakhir=str_replace("'", '"',$karyawan_thnslsakhir);
		$karyawan_wisudaawal=trim(@$_POST["karyawan_wisudaawal"]);
		$karyawan_wisudaawal=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_wisudaawal);
		$karyawan_wisudaawal=str_replace("'", '"',$karyawan_wisudaawal);
		$karyawan_wisudaakhir=trim(@$_POST["karyawan_wisudaakhir"]);
		$karyawan_wisudaakhir=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_wisudaakhir);
		$karyawan_wisudaakhir=str_replace("'", '"',$karyawan_wisudaakhir);
		$karyawan_pendidikanketerangan=trim(@$_POST["karyawan_pendidikanketerangan"]);
		$karyawan_pendidikanketerangan=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_pendidikanketerangan);
		$karyawan_pendidikanketerangan=str_replace("'", '"',$karyawan_pendidikanketerangan);
		// KELUARGA SEARCH
		// TANGGAL LAHIR SEARCH
		$karyawan_tempatlahir=trim(@$_POST["karyawan_tempatlahir"]);
		$karyawan_tempatlahir=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_tempatlahir);
		$karyawan_tempatlahir=str_replace("'", '"',$karyawan_tempatlahir);
		$karyawan_tgllahirawal=trim(@$_POST["karyawan_tgllahirawal"]);
		$karyawan_tgllahirakhir=trim(@$_POST["karyawan_tgllahirakhir"]);
		$karyawan_tgllahir=trim(@$_POST["karyawan_tgllahir"]);
		$karyawan_tgllahir=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_tgllahir);
		$karyawan_tgllahir=str_replace("'", '"',$karyawan_tgllahir);
		$karyawan_blnlahir=trim(@$_POST["karyawan_blnlahir"]);
		$karyawan_blnlahir=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_blnlahir);
		$karyawan_blnlahir=str_replace("'", '"',$karyawan_blnlahir);		
		// CUTI SEARCH
		$karyawan_jeniscuti=trim(@$_POST["karyawan_jeniscuti"]);
		$karyawan_jeniscuti=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_jeniscuti);
		$karyawan_jeniscuti=str_replace("'", '"',$karyawan_jeniscuti);
		$karyawan_tglcutiawalawal=trim(@$_POST["karyawan_tglcutiawalawal"]);
		$karyawan_tglcutiawalakhir=trim(@$_POST["karyawan_tglcutiawalakhir"]);
		$karyawan_tglcutiakhirawal=trim(@$_POST["karyawan_tglcutiakhirawal"]);
		$karyawan_tglcutiakhirakhir=trim(@$_POST["karyawan_tglcutiakhirakhir"]);
		$karyawan_jmlharicutiawal=trim(@$_POST["karyawan_jmlharicutiawal"]);
		$karyawan_jmlharicutiawal=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_jmlharicutiawal);
		$karyawan_jmlharicutiawal=str_replace("'", '"',$karyawan_jmlharicutiawal);
		$karyawan_jmlharicutiakhir=trim(@$_POST["karyawan_jmlharicutiakhir"]);
		$karyawan_jmlharicutiakhir=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_jmlharicutiakhir);
		$karyawan_jmlharicutiakhir=str_replace("'", '"',$karyawan_jmlharicutiakhir);
		$karyawan_jeniscuti=trim(@$_POST["karyawan_jeniscuti"]);
		$karyawan_jeniscuti=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_jeniscuti);
		$karyawan_jeniscuti=str_replace("'", '"',$karyawan_jeniscuti);
		$karyawan_tglpengajuanawal=trim(@$_POST["karyawan_tglpengajuanawal"]);
		$karyawan_tglpengajuanakhir=trim(@$_POST["karyawan_tglpengajuanakhir"]);
		$karyawan_cutiketerangan=trim(@$_POST["karyawan_cutiketerangan"]);
		$karyawan_cutiketerangan=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_cutiketerangan);
		$karyawan_cutiketerangan=str_replace("'", '"',$karyawan_cutiketerangan);
		// GANTIOFF SEARCH
		$karyawan_tgloffawalawal=trim(@$_POST["karyawan_tgloffawalawal"]);
		$karyawan_tgloffawalakhir=trim(@$_POST["karyawan_tgloffawalakhir"]);
		$karyawan_tgloffakhirawal=trim(@$_POST["karyawan_tgloffakhirawal"]);
		$karyawan_tgloffakhirakhir=trim(@$_POST["karyawan_tgloffakhirakhir"]);
		$karyawan_jmlharioffawal=trim(@$_POST["karyawan_jmlharioffawal"]);
		$karyawan_jmlharioffawal=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_jmlharioffawal);
		$karyawan_jmlharioffawal=str_replace("'", '"',$karyawan_jmlharioffawal);
		$karyawan_jmlharioffakhir=trim(@$_POST["karyawan_jmlharioffakhir"]);
		$karyawan_jmlharioffakhir=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_jmlharioffakhir);
		$karyawan_jmlharioffakhir=str_replace("'", '"',$karyawan_jmlharioffakhir);
		$karyawan_tgloffgantiawalawal=trim(@$_POST["karyawan_tgloffgantiawalawal"]);
		$karyawan_tgloffgantiawalakhir=trim(@$_POST["karyawan_tgloffgantiawalakhir"]);
		$karyawan_tgloffgantiakhirawal=trim(@$_POST["karyawan_tgloffgantiakhirawal"]);
		$karyawan_tgloffgantiakhirakhir=trim(@$_POST["karyawan_tgloffgantiakhirakhir"]);
		$karyawan_tgloffpengajuanakhirawal=trim(@$_POST["karyawan_tgloffpengajuanakhirawal"]);
		$karyawan_tgloffpengajuanakhirakhir=trim(@$_POST["karyawan_tgloffpengajuanakhirakhir"]);
		$karyawan_offketerangan=trim(@$_POST["karyawan_offketerangan"]);
		$karyawan_offketerangan=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_offketerangan);
		$karyawan_offketerangan=str_replace("'", '"',$karyawan_offketerangan);
		// MEDICAL SEARCH
		$karyawan_tujuanklaim=trim(@$_POST["karyawan_tujuanklaim"]);
		$karyawan_tujuanklaim=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_tujuanklaim);
		$karyawan_tujuanklaim=str_replace("'", '"',$karyawan_tujuanklaim);
		$karyawan_jenisrawat=trim(@$_POST["karyawan_jenisrawat"]);
		$karyawan_jenisrawat=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_jenisrawat);
		$karyawan_jenisrawat=str_replace("'", '"',$karyawan_jenisrawat);
		$karyawan_jenisklaim=trim(@$_POST["karyawan_jenisklaim"]);
		$karyawan_jenisklaim=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_jenisklaim);
		$karyawan_jenisklaim=str_replace("'", '"',$karyawan_jenisklaim);
		$karyawan_jmlkuitansiawal=trim(@$_POST["karyawan_jmlkuitansiawal"]);
		$karyawan_jmlkuitansiawal=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_jmlkuitansiawal);
		$karyawan_jmlkuitansiawal=str_replace("'", '"',$karyawan_jmlkuitansiawal);
		$karyawan_jmlkuitansiakhir=trim(@$_POST["karyawan_jmlkuitansiakhir"]);
		$karyawan_jmlkuitansiakhir=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_jmlkuitansiakhir);
		$karyawan_jmlkuitansiakhir=str_replace("'", '"',$karyawan_jmlkuitansiakhir);
		$karyawan_totalkuitansiawal=trim(@$_POST["karyawan_totalkuitansiawal"]);
		$karyawan_totalkuitansiawal=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_totalkuitansiawal);
		$karyawan_totalkuitansiawal=str_replace("'", '"',$karyawan_totalkuitansiawal);
		$karyawan_totalkuitansiakhir=trim(@$_POST["karyawan_totalkuitansiakhir"]);
		$karyawan_totalkuitansiakhir=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_totalkuitansiakhir);
		$karyawan_totalkuitansiakhir=str_replace("'", '"',$karyawan_totalkuitansiakhir);
		$karyawan_tglmedicalpengajuanawal=trim(@$_POST["karyawan_tglmedicalpengajuanawal"]);
		$karyawan_tglmedicalpengajuanakhir=trim(@$_POST["karyawan_tglmedicalpengajuanakhir"]);
		$karyawan_tglmedicalkuitansiawal=trim(@$_POST["karyawan_tglmedicalkuitansiawal"]);
		$karyawan_tglmedicalkuitansiakhir=trim(@$_POST["karyawan_tglmedicalkuitansiakhir"]);
		$karyawan_medicalketerangan=trim(@$_POST["karyawan_medicalketerangan"]);
		$karyawan_medicalketerangan=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_medicalketerangan);
		$karyawan_medicalketerangan=str_replace("'", '"',$karyawan_medicalketerangan);
		// FASILITAS SEARCH
		$karyawan_fasilitasitem=trim(@$_POST["karyawan_fasilitasitem"]);
		$karyawan_fasilitasitem=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_fasilitasitem);
		$karyawan_fasilitasitem=str_replace("'", '"',$karyawan_fasilitasitem);
		$karyawan_tglserahterimaawal=trim(@$_POST["karyawan_tglserahterimaawal"]);
		$karyawan_tglserahterimaakhir=trim(@$_POST["karyawan_tglserahterimaakhir"]);
		$karyawan_fasilitasketerangan=trim(@$_POST["karyawan_fasilitasketerangan"]);
		$karyawan_fasilitasketerangan=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_fasilitasketerangan);
		$karyawan_fasilitasketerangan=str_replace("'", '"',$karyawan_fasilitasketerangan);
		// GENERAL SEARCH
		$karyawan_creator=trim(@$_POST["karyawan_creator"]);
		$karyawan_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_creator);
		$karyawan_creator=str_replace("'", '"',$karyawan_creator);
		$karyawan_date_create=trim(@$_POST["karyawan_date_create"]);
		$karyawan_update=trim(@$_POST["karyawan_update"]);
		$karyawan_update=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_update);
		$karyawan_update=str_replace("'", '"',$karyawan_update);
		$karyawan_date_update=trim(@$_POST["karyawan_date_update"]);
		$karyawan_revised=trim(@$_POST["karyawan_revised"]);
		
		$start = (integer) (isset($_POST['start']) ? $_POST['start'] : $_GET['start']);
		$end = (integer) (isset($_POST['limit']) ? $_POST['limit'] : $_GET['limit']);
		$result = $this->m_karyawan->karyawan_search(
		// GENERAL SEARCH
		$karyawan_id, $karyawan_cabang, $karyawan_no, $karyawan_noktp, $karyawan_alamatktp, $karyawan_npwp, $karyawan_jamsostek, $karyawan_sip, $karyawan_username ,$karyawan_nama ,$karyawan_kelamin, $karyawan_marriage, $karyawan_agama, $karyawan_jmlanak, $karyawan_tglmasuk, $karyawan_aktif,
		// TEMPAT TANGGAL LAHIR SEARCH
		$karyawan_tempatlahir, $karyawan_tgllahirawal, $karyawan_tgllahirakhir, $karyawan_tgllahir, $karyawan_blnlahir,
		// ALAMAT KONTAK SEARCG
		$karyawan_alamat ,$karyawan_kota ,$karyawan_kodepos ,$karyawan_email, $karyawan_keterangan ,$karyawan_notelp,
		// INFO REKENING SEARCH
		$karyawan_bank, $karyawan_bankcabang, $karyawan_norekening, $karyawan_atasnama,
		// STATUS KEKARYAWANAN SEARCH
		$karyawan_statuskekaryawanan, $karyawan_statustglawalawal, $karyawan_statustglawalakhir, $karyawan_statustglakhirawal, $karyawan_statustglakhirakhir, $karyawan_statuskaryawan,
		// JABATAN SEARCH
		$karyawan_jabatan, $karyawan_departemen ,$karyawan_idgolongan  ,$karyawan_atasan, $karyawan_pph21, $karyawan_tgljbtawalawal, $karyawan_tgljbtawalakhir, $karyawan_tgljbtakhirawal, $karyawan_tgljbtakhirakhir, $karyawan_jabatanketerangan,
		// PENDIDIKAN SEARCH
		$karyawan_pendidikan, $karyawan_namasekolah, $karyawan_jurusan, $karyawan_thnmskawal, $karyawan_thnmskakhir, $karyawan_thnslsawal, $karyawan_thnslsakhir, $karyawan_wisudaawal, $karyawan_wisudaakhir, $karyawan_pendidikanketerangan,
		// CUTI SEARCH
		$karyawan_jeniscuti, $karyawan_tglcutiawalawal, $karyawan_tglcutiawalakhir, $karyawan_tglcutiakhirawal, $karyawan_tglcutiakhirakhir, $karyawan_jmlharicutiawal, $karyawan_jmlharicutiakhir, $karyawan_tglpengajuanawal, $karyawan_tglpengajuanakhir, $karyawan_cutiketerangan,
		// GANTIOFF SEARCH
		$karyawan_tgloffawalawal, $karyawan_tgloffawalakhir, $karyawan_tgloffakhirawal, $karyawan_tgloffakhirakhir, $karyawan_jmlharioffawal, $karyawan_jmlharioffakhir, $karyawan_tgloffgantiawalawal, $karyawan_tgloffgantiawalakhir, $karyawan_tgloffgantiakhirawal, $karyawan_tgloffgantiakhirakhir, $karyawan_tgloffpengajuanakhirawal, $karyawan_tgloffpengajuanakhirakhir, $karyawan_offketerangan,
		// MEDICAL SEARCH
		$karyawan_tujuanklaim, $karyawan_jenisrawat, $karyawan_jenisklaim, $karyawan_jmlkuitansiawal, $karyawan_jmlkuitansiakhir, $karyawan_totalkuitansiawal, $karyawan_totalkuitansiakhir, $karyawan_tglmedicalpengajuanawal, $karyawan_tglmedicalpengajuanakhir, $karyawan_tglmedicalkuitansiawal, $karyawan_tglmedicalkuitansiakhir, $karyawan_medicalketerangan,
		// FASILITAS SEARCH
		$karyawan_fasilitasitem, $karyawan_tglserahterimaawal, $karyawan_tglserahterimaakhir, $karyawan_fasilitasketerangan,
		// GENERAL SEARCH
		$karyawan_creator ,$karyawan_date_create ,$karyawan_update ,$karyawan_date_update ,$karyawan_revised ,$start,$end);
		echo $result;
	}


	function karyawan_print(){
  		//POST varibale here
		$karyawan_id=trim(@$_POST["karyawan_id"]);
		$karyawan_no=trim(@$_POST["karyawan_no"]);
		$karyawan_no=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_no);
		$karyawan_no=str_replace("'", '"',$karyawan_no);
		$karyawan_npwp=trim(@$_POST["karyawan_npwp"]);
		$karyawan_npwp=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_npwp);
		$karyawan_npwp=str_replace("'", '"',$karyawan_npwp);
		$karyawan_username=trim(@$_POST["karyawan_username"]);
		$karyawan_username=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_username);
		$karyawan_username=str_replace("'", '"',$karyawan_username);
		$karyawan_nama=trim(@$_POST["karyawan_nama"]);
		$karyawan_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_nama);
		$karyawan_nama=str_replace("'", '"',$karyawan_nama);
		$karyawan_kelamin=trim(@$_POST["karyawan_kelamin"]);
		$karyawan_kelamin=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_kelamin);
		$karyawan_kelamin=str_replace("'", '"',$karyawan_kelamin);
		$karyawan_tgllahir=trim(@$_POST["karyawan_tgllahir"]);
		$karyawan_alamat=trim(@$_POST["karyawan_alamat"]);
		$karyawan_alamat=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_alamat);
		$karyawan_alamat=str_replace("'", '"',$karyawan_alamat);
		$karyawan_kota=trim(@$_POST["karyawan_kota"]);
		$karyawan_kota=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_kota);
		$karyawan_kota=str_replace("'", '"',$karyawan_kota);
		$karyawan_kodepos=trim(@$_POST["karyawan_kodepos"]);
		$karyawan_kodepos=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_kodepos);
		$karyawan_kodepos=str_replace("'", '"',$karyawan_kodepos);
		$karyawan_email=trim(@$_POST["karyawan_email"]);
		$karyawan_email=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_email);
		$karyawan_email=str_replace("'", '"',$karyawan_email);
		$karyawan_emiracle=trim(@$_POST["karyawan_emiracle"]);
		$karyawan_emiracle=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_emiracle);
		$karyawan_emiracle=str_replace("'", '"',$karyawan_emiracle);
		$karyawan_keterangan=trim(@$_POST["karyawan_keterangan"]);
		$karyawan_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_keterangan);
		$karyawan_keterangan=str_replace("'", '"',$karyawan_keterangan);
		$karyawan_notelp=trim(@$_POST["karyawan_notelp"]);
		$karyawan_notelp=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_notelp);
		$karyawan_notelp=str_replace("'", '"',$karyawan_notelp);
		$karyawan_notelp2=trim(@$_POST["karyawan_notelp2"]);
		$karyawan_notelp2=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_notelp2);
		$karyawan_notelp2=str_replace("'", '"',$karyawan_notelp2);
		$karyawan_notelp3=trim(@$_POST["karyawan_notelp3"]);
		$karyawan_notelp3=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_notelp3);
		$karyawan_notelp3=str_replace("'", '"',$karyawan_notelp3);
		$karyawan_notelp4=trim(@$_POST["karyawan_notelp4"]);
		$karyawan_notelp4=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_notelp4);
		$karyawan_notelp4=str_replace(",", ",",$karyawan_notelp4);
		$karyawan_notelp4=str_replace("'", '"',$karyawan_notelp4);
		$karyawan_cabang=trim(@$_POST["karyawan_cabang"]);
		$karyawan_jabatan=trim(@$_POST["karyawan_jabatan"]);
		$karyawan_departemen=trim(@$_POST["karyawan_departemen"]);
		$karyawan_idgolongan=trim(@$_POST["karyawan_idgolongan"]);
		$karyawan_idgolongan=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_idgolongan);
		$karyawan_idgolongan=str_replace("'", '"',$karyawan_idgolongan);
		$karyawan_tglmasuk=trim(@$_POST["karyawan_tglmasuk"]);
		$karyawan_atasan=trim(@$_POST["karyawan_atasan"]);
		$karyawan_aktif=trim(@$_POST["karyawan_aktif"]);
		$karyawan_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_aktif);
		$karyawan_aktif=str_replace("'", '"',$karyawan_aktif);
		$karyawan_creator=trim(@$_POST["karyawan_creator"]);
		$karyawan_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_creator);
		$karyawan_creator=str_replace("'", '"',$karyawan_creator);
		$karyawan_date_create=trim(@$_POST["karyawan_date_create"]);
		$karyawan_update=trim(@$_POST["karyawan_update"]);
		$karyawan_update=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_update);
		$karyawan_update=str_replace("'", '"',$karyawan_update);
		$karyawan_date_update=trim(@$_POST["karyawan_date_update"]);
		$karyawan_revised=trim(@$_POST["karyawan_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$result = $this->m_karyawan->karyawan_print($karyawan_id ,$karyawan_no ,$karyawan_npwp ,$karyawan_username ,$karyawan_nama ,$karyawan_kelamin ,$karyawan_tgllahir ,$karyawan_alamat ,$karyawan_kota ,$karyawan_kodepos ,$karyawan_email ,$karyawan_emiracle ,$karyawan_keterangan ,$karyawan_notelp ,$karyawan_notelp2 ,$karyawan_notelp3, $karyawan_notelp4 ,$karyawan_cabang ,$karyawan_jabatan ,$karyawan_departemen ,$karyawan_idgolongan ,$karyawan_tglmasuk ,$karyawan_atasan ,$karyawan_aktif ,$karyawan_creator ,$karyawan_date_create ,$karyawan_update ,$karyawan_date_update ,$karyawan_revised ,$option,$filter);
		$nbrows=$result->num_rows();
		$totcolumn=26;
   		/* We now have our array, let's build our HTML file */
		$file = fopen("karyawanlist.html",'w');
		fwrite($file, "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /><title>Printing the Karyawan Grid</title><link rel='stylesheet' type='text/css' href='assets/modules/main/css/printstyle.css'/></head>");
		fwrite($file, "<body onload='window.print()'><table summary='Karyawan List'><caption>DAFTAR KARYAWAN</caption><thead><tr><th scope='col'>No</th><th scope='col'>No</th><th scope='col'>NPWP</th><th scope='col'>Username</th><th scope='col'>Nama</th><th scope='col'>Kelamin</th><th scope='col'>Tgl.lahir</th><th scope='col'>Alamat</th><th scope='col'>Kota</th><th scope='col'>Kodepos</th><th scope='col'>Email</th><th scope='col'>Email Miracle</th><th scope='col'>Keterangan</th><th scope='col'>No.telp</th><th scope='col'>No.telp.2</th><th scope='col'>No.telp.3</th><th scope='col'>Cabang</th><th scope='col'>Jabatan</th><th scope='col'>Departemen</th><th scope='col'>Golongan</th><th scope='col'>Tgl.masuk</th><th scope='col'>Atasan</th><th scope='col'>Aktif</th></tr></thead><tfoot><tr><th scope='row'>Total</th><td colspan='$totcolumn'>");
		fwrite($file, $nbrows);
		fwrite($file, " Karyawan</td></tr></tfoot><tbody>");
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
				fwrite($file, $data['karyawan_no']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['karyawan_npwp']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['karyawan_username']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['karyawan_nama']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['karyawan_kelamin']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['karyawan_tgllahir']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['karyawan_alamat']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['karyawan_kota']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['karyawan_kodepos']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['karyawan_email']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['karyawan_emiracle']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['karyawan_keterangan']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['karyawan_notelp']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['karyawan_notelp2']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['karyawan_notelp3']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['karyawan_cabang']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['karyawan_jabatan']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['karyawan_departemen']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['karyawan_idgolongan']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['karyawan_tglmasuk']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['karyawan_atasan']);
				fwrite($file,"</td><td>");
				fwrite($file, $data['karyawan_aktif']);
				fwrite($file, "</td></tr>");
			}
		}
		fwrite($file, "</tbody></table></body></html>");	
		fclose($file);
		echo '1';        
	}
	/* End Of Function */

	/* Function to Export Excel document */
	function karyawan_export_excel(){
		//POST varibale here
		$karyawan_id=trim(@$_POST["karyawan_id"]);
		$karyawan_no=trim(@$_POST["karyawan_no"]);
		$karyawan_no=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_no);
		$karyawan_no=str_replace("'", '"',$karyawan_no);
		$karyawan_npwp=trim(@$_POST["karyawan_npwp"]);
		$karyawan_npwp=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_npwp);
		$karyawan_npwp=str_replace("'", '"',$karyawan_npwp);
		$karyawan_username=trim(@$_POST["karyawan_username"]);
		$karyawan_username=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_username);
		$karyawan_username=str_replace("'", '"',$karyawan_username);
		$karyawan_nama=trim(@$_POST["karyawan_nama"]);
		$karyawan_nama=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_nama);
		$karyawan_nama=str_replace("'", '"',$karyawan_nama);
		$karyawan_kelamin=trim(@$_POST["karyawan_kelamin"]);
		$karyawan_kelamin=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_kelamin);
		$karyawan_kelamin=str_replace("'", '"',$karyawan_kelamin);
		$karyawan_tgllahir=trim(@$_POST["karyawan_tgllahir"]);
		$karyawan_alamat=trim(@$_POST["karyawan_alamat"]);
		$karyawan_alamat=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_alamat);
		$karyawan_alamat=str_replace("'", '"',$karyawan_alamat);
		$karyawan_kota=trim(@$_POST["karyawan_kota"]);
		$karyawan_kota=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_kota);
		$karyawan_kota=str_replace("'", '"',$karyawan_kota);
		$karyawan_kodepos=trim(@$_POST["karyawan_kodepos"]);
		$karyawan_kodepos=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_kodepos);
		$karyawan_kodepos=str_replace("'", '"',$karyawan_kodepos);
		$karyawan_email=trim(@$_POST["karyawan_email"]);
		$karyawan_email=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_email);
		$karyawan_email=str_replace("'", '"',$karyawan_email);
		$karyawan_emiracle=trim(@$_POST["karyawan_emiracle"]);
		$karyawan_emiracle=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_emiracle);
		$karyawan_emiracle=str_replace("'", '"',$karyawan_emiracle);
		$karyawan_keterangan=trim(@$_POST["karyawan_keterangan"]);
		$karyawan_keterangan=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_keterangan);
		$karyawan_keterangan=str_replace("'", '"',$karyawan_keterangan);
		$karyawan_notelp=trim(@$_POST["karyawan_notelp"]);
		$karyawan_notelp=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_notelp);
		$karyawan_notelp=str_replace("'", '"',$karyawan_notelp);
		$karyawan_notelp2=trim(@$_POST["karyawan_notelp2"]);
		$karyawan_notelp2=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_notelp2);
		$karyawan_notelp2=str_replace("'", '"',$karyawan_notelp2);
		$karyawan_notelp3=trim(@$_POST["karyawan_notelp3"]);
		$karyawan_notelp3=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_notelp3);
		$karyawan_notelp3=str_replace("'", '"',$karyawan_notelp3);
		$karyawan_notelp4=trim(@$_POST["karyawan_notelp4"]);
		$karyawan_notelp4=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_notelp4);
		$karyawan_notelp4=str_replace(",", ",",$karyawan_notelp4);
		$karyawan_notelp4=str_replace("'", '"',$karyawan_notelp4);
		$karyawan_cabang=trim(@$_POST["karyawan_cabang"]);
		$karyawan_jabatan=trim(@$_POST["karyawan_jabatan"]);
		$karyawan_departemen=trim(@$_POST["karyawan_departemen"]);
		$karyawan_idgolongan=trim(@$_POST["karyawan_idgolongan"]);
		$karyawan_idgolongan=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_idgolongan);
		$karyawan_idgolongan=str_replace("'", '"',$karyawan_idgolongan);
		$karyawan_tglmasuk=trim(@$_POST["karyawan_tglmasuk"]);
		$karyawan_atasan=trim(@$_POST["karyawan_atasan"]);
		$karyawan_aktif=trim(@$_POST["karyawan_aktif"]);
		$karyawan_aktif=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_aktif);
		$karyawan_aktif=str_replace("'", '"',$karyawan_aktif);
		$karyawan_creator=trim(@$_POST["karyawan_creator"]);
		$karyawan_creator=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_creator);
		$karyawan_creator=str_replace("'", '"',$karyawan_creator);
		$karyawan_date_create=trim(@$_POST["karyawan_date_create"]);
		$karyawan_update=trim(@$_POST["karyawan_update"]);
		$karyawan_update=str_replace("/(<\/?)(p)([^>]*>)", "",$karyawan_update);
		$karyawan_update=str_replace("'", '"',$karyawan_update);
		$karyawan_date_update=trim(@$_POST["karyawan_date_update"]);
		$karyawan_revised=trim(@$_POST["karyawan_revised"]);
		$option=$_POST['currentlisting'];
		$filter=$_POST["query"];
		
		$query = $this->m_karyawan->karyawan_export_excel($karyawan_id ,$karyawan_no ,$karyawan_npwp ,$karyawan_username ,$karyawan_nama ,$karyawan_kelamin ,$karyawan_tgllahir ,$karyawan_alamat ,$karyawan_kota ,$karyawan_kodepos ,$karyawan_email ,$karyawan_emiracle ,$karyawan_keterangan ,$karyawan_notelp ,$karyawan_notelp2 ,$karyawan_notelp3, $karyawan_notelp4 ,$karyawan_cabang ,$karyawan_jabatan ,$karyawan_departemen ,$karyawan_idgolongan ,$karyawan_tglmasuk ,$karyawan_atasan ,$karyawan_aktif ,$karyawan_creator ,$karyawan_date_create ,$karyawan_update ,$karyawan_date_update ,$karyawan_revised ,$option,$filter);
		
		to_excel($query,"karyawan"); 
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