<?
/* 	
	GIOV Solution - Keep IT Simple
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<style type="text/css">
        p { width:650px; }
		.search-item {
			font:normal 11px tahoma, arial, helvetica, sans-serif;
			padding:3px 10px 3px 10px;
			border:1px solid #fff;
			border-bottom:1px solid #eeeeee;
			white-space:normal;
			color:#555;
		}
		.search-item h3 {
			display:block;
			font:inherit;
			font-weight:bold;
			color:#222;
		}
		
		.search-item h3 span {
			float: right;
			font-weight:normal;
			margin:0 0 5px 5px;
			width:100px;
			display:block;
			clear:none;
		}
    </style>
<script>
/* declare function */		
var karyawan_DataStore;
var karyawan_ColumnModel;
var karyawanListEditorGrid;
var karyawan_createForm;
var karyawan_createWindow;
var karyawan_searchForm;
var karyawan_searchWindow;
var karyawan_SelectedRow;
var karyawan_ContextMenu;
//declare konstant
var today=new Date();
var karyawan_post2db = '';
var msg = '';
var karyawan_pageS=15;

/* declare variable here */
var karyawan_idField;
var karyawan_noField;
var karyawan_noktpField;
var karyawan_alamatktpField;
var karyawan_agamaField;
var karyawan_sipField;
var karyawan_npwpField;
var karyawan_usernameField;
var karyawan_jmlanakField;
var karyawan_namaField;
var karyawan_kelaminField;
//var karyawan_pph21Field;
var karyawan_marriageField;
var karyawan_bankField;
var karyawan_bankcabangField;
var karyawan_norekeningField;
var karyawan_atasnamaField;
var karyawan_tgllahirField;
var karyawan_tmplahirField;
var karyawan_alamatField;
var karyawan_kotaField;
var karyawan_kodeposField;
var karyawan_emailField;
var karyawan_emiracleField;
var karyawan_jamsostekField;
var karyawan_keteranganField;
var karyawan_notelpField;
var karyawan_notelp2Field;
var karyawan_notelp3Field;
var karyawan_notelp4Field;
var karyawan_cabangField;
//var karyawan_jabatanField;
//var karyawan_departemenField;
//var karyawan_golonganField;
//var karyawan_golongantxtField;
var karyawan_tglmasukField;
//var karyawan_tglbatasField;
//var karyawan_atasanField;
var karyawan_aktifField;
//for detail status kekaryawanan
var detail_status_karyawan_ColumnModel;
var detail_status_karyawanListEditorGrid;
var editor_detail_status_karyawan;
var dkaryawan_tglakhirField;
var dkaryawan_tglawalField;
var dkaryawan_statuskaryawanField;

// for detail jabatan karyawan
var detail_jabatan_ColumnModel;
var detail_jabatanListEditorGrid;
var editor_detail_jabatan_karyawan;

// for detail pendidikan karyawan
var detail_pendidikan_ColumnModel;
var detail_pendidikanListEditorGrid;
var editor_detail_pendidikan_karyawan;

// for detail keluarga karyawan
var detail_keluarga_ColumnModel;
var detail_keluargaListEditorGrid;
var editor_detail_keluarga_karyawan;

// for detail cuti karyawan
var detail_cuti_ColumnModel;
var detail_cutiListEditorGrid;
var editor_detail_cuti_karyawan;
var kcuti_tglawalField;
var kcuti_tglakhirField;
var kcuti_jmlhariField;

// for detail gantioff karyawan
var detail_gantioff_ColumnModel;
var detail_gantioffListEditorGrid;
var editor_detail_gantioff_karyawan;

// for detail gantioff karyawan
var detail_medical_ColumnModel;
var detail_medicalListEditorGrid;
var editor_detail_medical_karyawan;

// for detail keluarga karyawan
var detail_fasilitas_ColumnModel;
var detail_fasilitasListEditorGrid;
var editor_detail_fasilitas_karyawan;

// GENERAL SEARCH
var karyawan_idSearchField;
var karyawan_cabangSearchField;
var karyawan_noSearchField;
var karyawan_noktpSearchField;
var karyawan_alamatktpSearchField;
var karyawan_agamaSearchField;
var karyawan_npwpSearchField;
var karyawan_jamsostekSearchField;
var karyawan_sipSearchField;
var karyawan_usernameSearchField;
var karyawan_namaSearchField;
var karyawan_kelaminSearchField;
var karyawan_marriageSearchField;
var karyawan_jmlanakSearchField;
var karyawan_tglmasukSearchField;
var karyawan_aktifSearchField;
// TEMPAT TANGGAL LAHIR SEARCH
var karyawan_tempatlahirSearchField;
var karyawan_tgllahirawalSearchField;
var karyawan_tgllahirakhirSearchField;
var karyawan_tgllahirSearchField;
var karyawan_blnlahirSearchField;
// ALAMAT SEARCH
var karyawan_alamatSearchField;
var karyawan_kotaSearchField;
var karyawan_kodeposSearchField;
var karyawan_emailSearchField;
//var karyawan_emiracleSearchField;
var karyawan_keteranganSearchField;
var karyawan_notelpSearchField;
//var karyawan_notelp2SearchField;
//var karyawan_notelp3SearchField;
//var karyawan_notelp4SearchField;
// INFO REKENING SEARCH
var karyawan_bankSearchField;
var karyawan_bankcabangSearchField;
var karyawan_norekeningSearchField;
var karyawan_atasnamaSearchField;
// STATUS KEKARYAWANAN SEARCH
var karyawan_statuskekaryawananSearchField;
var karyawan_statustglawalawalSearchField;
var karyawan_statustglawalakhirSearchField;
var karyawan_statustglakhirawalSearchField;
var karyawan_statustglakhirakhirSearchField;
var karyawan_statuskaryawanSearchField;
// JABATAN SEARCH
var karyawan_jabatanSearchField;
var karyawan_departemenSearchField;
var karyawan_golonganSearchField;
var karyawan_atasanSearchField;
var karyawan_pph21SearchField;
var karyawan_tgljbtawalawalSearchField;
var karyawan_tgljbtawalakhirSearchField;
var karyawan_tgljbtakhirawalSearchField;
var karyawan_tgljbtakhirakhirSearchField;
var karyawan_jabatanketeranganSearchField;
// PENDIDIKAN SEARCH
var karyawan_pendidikanSearchField;
var karyawan_namasekolahSearchField;
var karyawan_jurusanSearchField;
var karyawan_thnmskawalSearchField;
var karyawan_thnmskakhirSearchField;
var karyawan_thnslsawalSearchField;
var karyawan_thnslsakhirSearchField;
var karyawan_wisudaawalSearchField;
var karyawan_wisudaakhirSearchField;
var karyawan_pendidikanketeranganSearchField;
// CUTI SEARCH
var karyawan_jeniscutiSearchField;
var karyawan_tglcutiawalawalSearchField;
var karyawan_tglcutiawalakhirSearchField;
var karyawan_tglcutiakhirawalSearchField;
var karyawan_tglcutiakhirakhirSearchField;
var karyawan_jmlharicutiawalSearchField;
var karyawan_jmlharicutiakhirSearchField;
var karyawan_tglpengajuanawalSearchField;
var karyawan_tglpengajuanakhirSearchField;
var karyawan_cutiketeranganSearchField;
// GANTIOFF SEARCH
var karyawan_tgloffawalawalSearchField;
var karyawan_tgloffawalakhirSearchField;
var karyawan_tgloffakhirawalSearchField;
var karyawan_tgloffakhirakhirSearchField;
var karyawan_jmlharioffawalSearchField;
var karyawan_jmlharioffakhirSearchField;
var karyawan_tgloffgantiawalawalSearchField;
var karyawan_tgloffgantiawalakhirSearchField;
var karyawan_tgloffgantiakhirawalSearchField;
var karyawan_tgloffgantiakhirakhirSearchField;
var karyawan_tgloffpengajuanakhirawalSearchField;
var karyawan_tgloffpengajuanakhirakhirSearchField;
var karyawan_offketeranganSearchField;
// MEDICAL SEARCH
var karyawan_tujuanklaimSearchField;
var karyawan_jenisrawatSearchField;
var karyawan_jenisklaimSearchField;
var karyawan_jmlkuitansiawalSearchField;
var karyawan_jmlkuitansiakhirSearchField;
var karyawan_totalkuitansiawalSearchField;
var karyawan_totalkuitansiakhirSearchField;
var karyawan_tglmedicalpengajuanawalSearchField;
var karyawan_tglmedicalpengajuanakhirSearchField;
var karyawan_tglmedicalkuitansiawalSearchField;
var karyawan_tglmedicalkuitansiakhirSearchField;
var karyawan_medicalketeranganSearchField;
// FASILITAS SEARCH
var karyawan_fasilitasitemSearchField;
var karyawan_tglserahterimaawalSearchField;
var karyawan_tglserahterimaakhirSearchField;
var karyawan_fasilitasketeranganSearchField;



/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  
		Ext.util.Format.comboRenderer = function(combo){
  		//jpaket_bankDataStore.load();
  	    return function(value){
  	        var record = combo.findRecord(combo.valueField, value);
  	        return record ? record.get(combo.displayField) : combo.valueNotFoundText;
  	    }
  	}
  
  
  	/* Function for Saving inLine Editing */
	function karyawan_update(oGrid_event){
		var karyawan_id_update_pk="";
		var karyawan_no_update=null;
		var karyawan_npwp_update=null;
		var karyawan_username_update=null;
		var karyawan_nama_update=null;
		var karyawan_kelamin_update=null;
		var karyawan_tgllahir_update_date="";
		var karyawan_alamat_update=null;
		var karyawan_kota_update=null;
		var karyawan_kodepos_update=null;
		var karyawan_email_update=null;
		var karyawan_emiracle_update=null;
		var karyawan_keterangan_update=null;
		var karyawan_notelp_update=null;
		var karyawan_notelp2_update=null;
		var karyawan_notelp3_update=null;
		var karyawan_notelp4_update=null;
		var karyawan_cabang_update=null;
		var karyawan_jabatan_update=null;
		var karyawan_departemen_update=null;
		var karyawan_golongan_update=null;
		var karyawan_tglmasuk_update_date="";
		var karyawan_atasan_update=null;
		var karyawan_aktif_update=null;
	
		karyawan_id_update_pk = oGrid_event.record.data.karyawan_id;
		if(oGrid_event.record.data.karyawan_no!== null){karyawan_no_update = oGrid_event.record.data.karyawan_no;}
		if(oGrid_event.record.data.karyawan_npwp!== null){karyawan_npwp_update = oGrid_event.record.data.karyawan_npwp;}
		if(oGrid_event.record.data.karyawan_username!== null){karyawan_username_update = oGrid_event.record.data.karyawan_username;}
		if(oGrid_event.record.data.karyawan_nama!== null){karyawan_nama_update = oGrid_event.record.data.karyawan_nama;}
		if(oGrid_event.record.data.karyawan_kelamin!== null){karyawan_kelamin_update = oGrid_event.record.data.karyawan_kelamin;}
		if(oGrid_event.record.data.karyawan_tgllahir!== ""){karyawan_tgllahir_update_date =oGrid_event.record.data.karyawan_tgllahir.format('Y-m-d');}
		if(oGrid_event.record.data.karyawan_alamat!== null){karyawan_alamat_update = oGrid_event.record.data.karyawan_alamat;}
		if(oGrid_event.record.data.karyawan_kota!== null){karyawan_kota_update = oGrid_event.record.data.karyawan_kota;}
		if(oGrid_event.record.data.karyawan_kodepos!== null){karyawan_kodepos_update = oGrid_event.record.data.karyawan_kodepos;}
		if(oGrid_event.record.data.karyawan_email!== null){karyawan_email_update = oGrid_event.record.data.karyawan_email;}
		if(oGrid_event.record.data.karyawan_emiracle!== null){karyawan_emiracle_update = oGrid_event.record.data.karyawan_emiracle;}
		if(oGrid_event.record.data.karyawan_keterangan!== null){karyawan_keterangan_update = oGrid_event.record.data.karyawan_keterangan;}
		if(oGrid_event.record.data.karyawan_notelp!== null){karyawan_notelp_update = oGrid_event.record.data.karyawan_notelp;}
		if(oGrid_event.record.data.karyawan_notelp2!== null){karyawan_notelp2_update = oGrid_event.record.data.karyawan_notelp2;}
		if(oGrid_event.record.data.karyawan_notelp3!== null){karyawan_notelp3_update = oGrid_event.record.data.karyawan_notelp3;}
		if(oGrid_event.record.data.karyawan_notelp4!== null){karyawan_notelp4_update = oGrid_event.record.data.karyawan_notelp4;}
		if(oGrid_event.record.data.karyawan_cabang!== null){karyawan_cabang_update = oGrid_event.record.data.karyawan_cabang;}
		if(oGrid_event.record.data.karyawan_jabatan!== null){karyawan_jabatan_update = oGrid_event.record.data.karyawan_jabatan;}
		if(oGrid_event.record.data.karyawan_departemen!== null){karyawan_departemen_update = oGrid_event.record.data.karyawan_departemen;}
		if(oGrid_event.record.data.karyawan_idgolongan!== null){karyawan_golongan_update = oGrid_event.record.data.karyawan_idgolongan;}
		if(oGrid_event.record.data.karyawan_tglmasuk!== ""){karyawan_tglmasuk_update_date =oGrid_event.record.data.karyawan_tglmasuk.format('Y-m-d');}
		if(oGrid_event.record.data.karyawan_atasan!== null){karyawan_atasan_update = oGrid_event.record.data.karyawan_atasan;}
		if(oGrid_event.record.data.karyawan_aktif!== null){karyawan_aktif_update = oGrid_event.record.data.karyawan_aktif;}

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_karyawan&m=get_action',
			params: {
				task: "UPDATE",
				karyawan_id	: karyawan_id_update_pk,				
				karyawan_no	:karyawan_no_update,		
				karyawan_npwp	:karyawan_npwp_update,		
				karyawan_username	:karyawan_username_update,		
				karyawan_nama	:karyawan_nama_update,		
				karyawan_kelamin	:karyawan_kelamin_update,		
				karyawan_tgllahir	: karyawan_tgllahir_update_date,				
				karyawan_alamat	:karyawan_alamat_update,		
				karyawan_kota	:karyawan_kota_update,		
				karyawan_kodepos	:karyawan_kodepos_update,		
				karyawan_email	:karyawan_email_update,		
				karyawan_emiracle	:karyawan_emiracle_update,		
				karyawan_keterangan	:karyawan_keterangan_update,		
				karyawan_notelp	:karyawan_notelp_update,		
				karyawan_notelp2	:karyawan_notelp2_update,		
				karyawan_notelp3	:karyawan_notelp3_update,
				karyawan_notelp4	:karyawan_notelp4_update,
				karyawan_cabang	:karyawan_cabang_update,		
				karyawan_jabatan	:karyawan_jabatan_update,		
				karyawan_departemen	:karyawan_departemen_update,		
				karyawan_idgolongan	:karyawan_golongan_update,		
				karyawan_tglmasuk	: karyawan_tglmasuk_update_date,				
				karyawan_atasan	:karyawan_atasan_update,		
				karyawan_aktif	:karyawan_aktif_update,		
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						karyawan_DataStore.commitChanges();
						karyawan_DataStore.reload();
						cbo_karyawan_cabang_DataStore.reload();
						cbo_karyawan_departemen_DataStore.reload();
						cbo_karyawan_golongan_DataStore.reload();
						cbo_karyawan_jabatan_DataStore.reload();
						cbo_karyawan_bank_DataStore.reload();
						cbo_karyawan_atasan_DataStore.reload();
						break;
					default:
						Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Data karyawan tidak bisa disimpan',
							   buttons: Ext.MessageBox.OK,
							   animEl: 'save',
							   icon: Ext.MessageBox.WARNING
						});
						break;
				}
			},
			failure: function(response){
				var result=response.responseText;
				Ext.MessageBox.show({
					   title: 'Error',
					   msg: 'Tidak bisa terhubung dengan database server',
					   buttons: Ext.MessageBox.OK,
					   animEl: 'database',
					   icon: Ext.MessageBox.ERROR
				});	
			}									    
		});   
	}
  	/* End of Function */
  
  	/* Function for add data, open window create form */
	function karyawan_create(){
		if(is_karyawan_form_valid()){
		
		var karyawan_id_create_pk=null;
		var karyawan_no_create=null;
		var karyawan_noktp_create=null;
		var karyawan_alamatktp_create=null;
		var karyawan_agama_create=null;
		var karyawan_sip_create=null;
		var karyawan_npwp_create=null;
		var karyawan_username_create=null;
		var karyawan_jmlanak_create=null;
		var karyawan_nama_create=null;
		var karyawan_kelamin_create=null;
		//var karyawan_pph21_create=null;
		var karyawan_marriage_create=null;
		var karyawan_bank_create=null;
		var karyawan_bankcabang_create=null;
		var karyawan_norekening_create=null;
		var karyawan_atasnama_create=null;
		var karyawan_tgllahir_create_date="";
		var karyawan_tmplahir_create=null;
		var karyawan_alamat_create=null;
		var karyawan_kota_create=null;
		var karyawan_kodepos_create=null;
		var karyawan_email_create=null;
		var karyawan_emiracle_create=null;
		var karyawan_jamsostek_create=null;
		var karyawan_keterangan_create=null;
		var karyawan_notelp_create=null;
		var karyawan_notelp2_create=null;
		var karyawan_notelp3_create=null;
		var karyawan_notelp4_create=null;
		var karyawan_cabang_create=null;
		//var karyawan_jabatan_create=null;
		//var karyawan_departemen_create=null;
		//var karyawan_golongan_create=null;
		//var karyawan_golongantxt_create=null;
		var karyawan_tglmasuk_create_date="";
		//var karyawan_tglbatas_create_date="";
		//var karyawan_atasan_create=null;
		var karyawan_aktif_create=null;

		karyawan_id_create_pk=get_pk_id();
		if(karyawan_noField.getValue()!== null){karyawan_no_create = karyawan_noField.getValue();}
		if(karyawan_noktpField.getValue()!== null){karyawan_noktp_create = karyawan_noktpField.getValue();}
		if(karyawan_alamatktpField.getValue()!== null){karyawan_alamatktp_create = karyawan_alamatktpField.getValue();}
		if(karyawan_sipField.getValue()!== null){karyawan_sip_create = karyawan_sipField.getValue();}
		if(karyawan_npwpField.getValue()!== null){karyawan_npwp_create = karyawan_npwpField.getValue();}
		if(karyawan_usernameField.getValue()!== null){karyawan_username_create = karyawan_usernameField.getValue();}
		if(karyawan_jmlanakField.getValue()!== null){karyawan_jmlanak_create = karyawan_jmlanakField.getValue();}
		if(karyawan_namaField.getValue()!== null){karyawan_nama_create = karyawan_namaField.getValue();}
		if(karyawan_kelaminField.getValue()!== null){karyawan_kelamin_create = karyawan_kelaminField.getValue();}
		if(karyawan_agamaField.getValue()!== null){karyawan_agama_create = karyawan_agamaField.getValue();}
		//if(karyawan_pph21Field.getValue()!== null){karyawan_pph21_create = karyawan_pph21Field.getValue();}
		if(karyawan_marriageField.getValue()!== null){karyawan_marriage_create = karyawan_marriageField.getValue();}
		if(karyawan_bankField.getValue()!== null){karyawan_bank_create = karyawan_bankField.getValue();}
		if(karyawan_bankcabangField.getValue()!== null){karyawan_bankcabang_create = karyawan_bankcabangField.getValue();}
		if(karyawan_norekeningField.getValue()!== null){karyawan_norekening_create = karyawan_norekeningField.getValue();}
		if(karyawan_atasnamaField.getValue()!== null){karyawan_atasnama_create = karyawan_atasnamaField.getValue();}
		if(karyawan_tgllahirField.getValue()!== ""){karyawan_tgllahir_create_date = karyawan_tgllahirField.getValue().format('Y-m-d');}
		if(karyawan_tmplahirField.getValue()!== ""){karyawan_tmplahir_create = karyawan_tmplahirField.getValue();}
		if(karyawan_alamatField.getValue()!== null){karyawan_alamat_create = karyawan_alamatField.getValue();}
		if(karyawan_kotaField.getValue()!== null){karyawan_kota_create = karyawan_kotaField.getValue();}
		if(karyawan_kodeposField.getValue()!== null){karyawan_kodepos_create = karyawan_kodeposField.getValue();}
		if(karyawan_emailField.getValue()!== null){karyawan_email_create = karyawan_emailField.getValue();}
		if(karyawan_emiracleField.getValue()!== null){karyawan_emiracle_create = karyawan_emiracleField.getValue();}
		if(karyawan_jamsostekField.getValue()!== null){karyawan_jamsostek_create = karyawan_jamsostekField.getValue();}
		if(karyawan_keteranganField.getValue()!== null){karyawan_keterangan_create = karyawan_keteranganField.getValue();}
		if(karyawan_notelpField.getValue()!== null){karyawan_notelp_create = karyawan_notelpField.getValue();}
		if(karyawan_notelp2Field.getValue()!== null){karyawan_notelp2_create = karyawan_notelp2Field.getValue();}
		if(karyawan_notelp3Field.getValue()!== null){karyawan_notelp3_create = karyawan_notelp3Field.getValue();}
		if(karyawan_notelp4Field.getValue()!== null){karyawan_notelp4_create = karyawan_notelp4Field.getValue();}
		if(karyawan_cabangField.getValue()!== null){karyawan_cabang_create = karyawan_cabangField.getValue();}
		//if(karyawan_jabatanField.getValue()!== null){karyawan_jabatan_create = karyawan_jabatanField.getValue();}
		//if(karyawan_departemenField.getValue()!== null){karyawan_departemen_create = karyawan_departemenField.getValue();}
		//if(karyawan_golonganField.getValue()!== null){karyawan_golongan_create = karyawan_golonganField.getValue();}
		//if(karyawan_golongantxtField.getValue()!== null){karyawan_golongantxt_create = karyawan_golongantxtField.getValue();}
		if(karyawan_tglmasukField.getValue()!== ""){karyawan_tglmasuk_create_date = karyawan_tglmasukField.getValue().format('Y-m-d');}
		//if(karyawan_tglbatasField.getValue()!== ""){karyawan_tglbatas_create_date = karyawan_tglbatasField.getValue().format('Y-m-d');}
		//if(karyawan_atasanField.getValue()!== null){karyawan_atasan_create = karyawan_atasanField.getValue();}
		if(karyawan_aktifField.getValue()!== null){karyawan_aktif_create = karyawan_aktifField.getValue();}

			Ext.Ajax.request({  
				waitMsg: 'Mohon tunggu...',
				url: 'index.php?c=c_karyawan&m=get_action',
				params: {
					task: karyawan_post2db,
					karyawan_id			: karyawan_id_create_pk,	
					karyawan_no			: karyawan_no_create,
					karyawan_noktp		: karyawan_noktp_create,
					karyawan_alamatktp	: karyawan_alamatktp_create,
					karyawan_agama		: karyawan_agama_create,
					karyawan_sip		: karyawan_sip_create,
					karyawan_npwp		: karyawan_npwp_create,	
					karyawan_username	: karyawan_username_create,	
					karyawan_jmlanak	: karyawan_jmlanak_create,	
					karyawan_nama		: karyawan_nama_create,	
					karyawan_kelamin	: karyawan_kelamin_create,	
					//karyawan_pph21	: karyawan_pph21_create,
					karyawan_marriage	: karyawan_marriage_create,
					karyawan_bank		: karyawan_bank_create,
					karyawan_bankcabang	: karyawan_bankcabang_create,
					karyawan_norekening	: karyawan_norekening_create,
					karyawan_atasnama	: karyawan_atasnama_create,
					karyawan_tgllahir	: karyawan_tgllahir_create_date,	
					karyawan_tmplahir	: karyawan_tmplahir_create,					
					karyawan_alamat		: karyawan_alamat_create,	
					karyawan_kota		: karyawan_kota_create,	
					karyawan_kodepos	: karyawan_kodepos_create,	
					karyawan_email		: karyawan_email_create,	
					karyawan_emiracle	: karyawan_emiracle_create,	
					karyawan_jamsostek	: karyawan_jamsostek_create,	
					karyawan_keterangan	: karyawan_keterangan_create,	
					karyawan_notelp		: karyawan_notelp_create,	
					karyawan_notelp2	: karyawan_notelp2_create,	
					karyawan_notelp3	: karyawan_notelp3_create,	
					karyawan_notelp4	: karyawan_notelp4_create,	
					karyawan_cabang		: karyawan_cabangField.getValue(),	
					//karyawan_jabatan		: karyawan_jabatan_create,	
					//karyawan_departemen	: karyawan_departemen_create,	
					//karyawan_idgolongan	: karyawan_golongan_create,	
					//karyawan_golongantxt	: karyawan_golongantxt_create,	
					karyawan_tglmasuk	: karyawan_tglmasuk_create_date,	
					//karyawan_tgl_batas	: karyawan_tglbatas_create_date,					
					//karyawan_atasan	: karyawan_atasan_create,	
					karyawan_aktif		: karyawan_aktif_create,
					karyawan_cab_th 	: karyawan_cab_thField.getValue(),
					karyawan_cab_ki 	: karyawan_cab_kiField.getValue(),
					karyawan_cab_hr	 	: karyawan_cab_hrField.getValue(),
					karyawan_cab_tp 	: karyawan_cab_tpField.getValue(),
					karyawan_cab_dps 	: karyawan_cab_dpsField.getValue(),
					karyawan_cab_jkt 	: karyawan_cab_jktField.getValue(),
					karyawan_cab_mta 	: karyawan_cab_mtaField.getValue(),
					karyawan_cab_blpn 	: karyawan_cab_blpnField.getValue(),
					karyawan_cab_kuta 	: karyawan_cab_kutaField.getValue(),
					karyawan_cab_btm 	: karyawan_cab_btmField.getValue(),
					karyawan_cab_mks 	: karyawan_cab_mksField.getValue(),
					karyawan_cab_mdn 	: karyawan_cab_mdnField.getValue(),
					karyawan_cab_lbk 	: karyawan_cab_lbkField.getValue(),
					karyawan_cab_mnd 	: karyawan_cab_mndField.getValue(),
					karyawan_cab_ygk 	: karyawan_cab_ygkField.getValue(),
					karyawan_cab_sjl 	: karyawan_cab_sjlField.getValue(),
					karyawan_cab_smg 	: karyawan_cab_smgField.getValue(),					
					karyawan_cab_mlg 	: karyawan_cab_mlgField.getValue(),
					karyawan_cab_corp 	: karyawan_cab_corpField.getValue(),
					karyawan_cab_maa 	: karyawan_cab_maaField.getValue(),
					karyawan_cab_mg 	: karyawan_cab_mgField.getValue(),
					
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							detail_status_karyawan_insert();
							detail_jabatan_insert();
							detail_pendidikan_insert();
							detail_keluarga_insert();
							detail_cuti_insert();
							detail_gantioff_insert();
							detail_medical_insert();
							detail_fasilitas_insert();
							Ext.MessageBox.alert(karyawan_post2db+' OK', 'Data karyawan berhasil disimpan');
							karyawan_DataStore.reload();
							cbo_karyawan_cabang_DataStore.reload();
							cbo_karyawan_departemen_DataStore.reload();
							cbo_karyawan_golongan_DataStore.reload();
							cbo_karyawan_jabatan_DataStore.reload();
							cbo_karyawan_bank_DataStore.reload();
							cbo_karyawan_atasan_DataStore.reload();

							karyawan_createWindow.hide();
							break;
						default:
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Data karyawan tidak bisa disimpan',
							   buttons: Ext.MessageBox.OK,
							   animEl: 'save',
							   icon: Ext.MessageBox.WARNING
							});
						break;
					}        
				},
				failure: function(response){
					var result=response.responseText;
					Ext.MessageBox.show({
						   title: 'Error',
						   msg: 'Tidak bisa terhubung dengan database server',
						   buttons: Ext.MessageBox.OK,
						   animEl: 'database',
						   icon: Ext.MessageBox.ERROR
					});	
				}                      
			});
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				width: 230,
				msg: 'Isian belum sempurna !',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
 	/* End of Function */
  
  	/* Function for get PK field */
	function get_pk_id(){
		if(karyawan_post2db=='UPDATE')
			return karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function karyawan_reset_form(){
		karyawan_noField.reset();
		karyawan_noField.setValue(null);
		karyawan_noktpField.reset();
		karyawan_noktpField.setValue(null);
		karyawan_alamatktpField.reset();
		karyawan_alamatktpField.setValue(null);
		karyawan_agamaField.reset();
		karyawan_agamaField.setValue(null);
		karyawan_sipField.reset();
		karyawan_sipField.setValue(null);
		karyawan_npwpField.reset();
		karyawan_npwpField.setValue(null);
		karyawan_usernameField.reset();
		karyawan_usernameField.setValue(null);
		karyawan_jmlanakField.reset();
		karyawan_jmlanakField.setValue(null);
		karyawan_namaField.reset();
		karyawan_namaField.setValue(null);
		karyawan_bankcabangField.reset();
		karyawan_bankcabangField.setValue(null);
		karyawan_norekeningField.reset();
		karyawan_norekeningField.setValue(null);
		karyawan_atasnamaField.reset();
		karyawan_atasnamaField.setValue(null);
		karyawan_kelaminField.reset();
		karyawan_kelaminField.setValue(null);
		//karyawan_pph21Field.reset();
		//karyawan_pph21Field.setValue(null);
		karyawan_marriageField.reset();
		karyawan_marriageField.setValue(null);
		karyawan_bankField.reset();
		karyawan_bankField.setValue(null);
		karyawan_tgllahirField.reset();
		karyawan_tgllahirField.setValue(null);
		karyawan_tmplahirField.reset();
		karyawan_tmplahirField.setValue(null);
		karyawan_alamatField.reset();
		karyawan_alamatField.setValue(null);
		karyawan_kotaField.reset();
		karyawan_kotaField.setValue(null);
		karyawan_kodeposField.reset();
		karyawan_kodeposField.setValue(null);
		karyawan_emailField.reset();
		karyawan_emailField.setValue(null);
		karyawan_emiracleField.reset();
		karyawan_emiracleField.setValue(null);
		karyawan_jamsostekField.reset();
		karyawan_jamsostekField.setValue(null);
		karyawan_keteranganField.reset();
		karyawan_keteranganField.setValue(null);
		karyawan_notelpField.reset();
		karyawan_notelpField.setValue(null);
		karyawan_notelp2Field.reset();
		karyawan_notelp2Field.setValue(null);
		karyawan_notelp3Field.reset();
		karyawan_notelp3Field.setValue(null);
		karyawan_notelp4Field.reset();
		karyawan_notelp4Field.setValue(null);
		karyawan_cabangField.reset();
		karyawan_cabangField.setValue(null);
		//karyawan_jabatanField.reset();
		//karyawan_jabatanField.setValue(null);
		//karyawan_departemenField.reset();
		//karyawan_departemenField.setValue(null);
		//karyawan_golonganField.reset();
		//karyawan_golonganField.setValue(null);
		karyawan_tglmasukField.reset();
		karyawan_tglmasukField.setValue(null);
		//karyawan_tglbatasField.reset();
		//karyawan_tglbatasField.setValue(null);
		//karyawan_atasanField.reset();
		//karyawan_atasanField.setValue(null);
		dkaryawan_statuskaryawanField.reset();
		//kstatus_karyawan.setValue(null);
		
		karyawan_aktifField.reset();
		karyawan_aktifField.setValue('Aktif');
		cbo_karyawan_atasan_DataStore.load({params: {karyawan_id: -1}});
		
		//reset editor grid
		status_karyawan_DataStore.load({params: {master_id:-1}});
		jabatan_DataStore.load({params: {master_id:-1}});
		keluarga_DataStore.load({params: {master_id:-1}});
		pendidikan_DataStore.load({params: {master_id:-1}});
		cuti_DataStore.load({params: {master_id:-1}});
		gantioff_DataStore.load({params: {master_id:-1}});
		medical_DataStore.load({params: {master_id:-1}});
		fasilitas_DataStore.load({params: {master_id:-1}});
		
		karyawan_cab_thField.reset();
		//karyawan_cab_thField.setValue(true);
		karyawan_cab_kiField.reset();
		//karyawan_cab_kiField.setValue(true);
		karyawan_cab_hrField.reset();
		//karyawan_cab_hrField.setValue(true);
		karyawan_cab_tpField.reset();
		//karyawan_cab_tpField.setValue(true);
		karyawan_cab_dpsField.reset();
		//karyawan_cab_dpsField.setValue(true);
		karyawan_cab_jktField.reset();
		karyawan_cab_mtaField.reset();
		//karyawan_cab_jktField.setValue(true);
		karyawan_cab_blpnField.reset();
		//karyawan_cab_blpnField.setValue(true);
		karyawan_cab_kutaField.reset();
		//karyawan_cab_kutaField.setValue(true);
		karyawan_cab_btmField.reset();
		//karyawan_cab_btmField.setValue(true);
		karyawan_cab_mksField.reset();
		//karyawan_cab_mksField.setValue(true);
		karyawan_cab_mdnField.reset();
		//karyawan_cab_mdnField.setValue(true);
		karyawan_cab_lbkField.reset();
		//karyawan_cab_lbkField.setValue(true);
		karyawan_cab_mndField.reset();
		//karyawan_cab_mndField.setValue(true);
		karyawan_cab_ygkField.reset();
		//karyawan_cab_ygkField.setValue(true);	
		karyawan_cab_sjlField.reset();
		//karyawan_cab_sjlField.setValue(true);	
		karyawan_cab_smgField.reset();
		//karyawan_cab_smgField.setValue(true);	
		karyawan_cab_mlgField.reset();
		//karyawan_cab_mlgField.setValue(true);
		karyawan_cab_corpField.reset();
		//karyawan_cab_corpField.setValue(true);
		karyawan_cab_maaField.reset();
		//karyawan_cab_maaField.setValue(true);
		karyawan_cab_mgField.reset();
		//karyawan_cab_mgField.setValue(true);	
		
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function karyawan_set_form(){
		karyawan_noField.setValue(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_no'));
		karyawan_noktpField.setValue(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_ktp'));
		karyawan_alamatktpField.setValue(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_alamat_ktp'));
		karyawan_agamaField.setValue(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_agama'));
		karyawan_sipField.setValue(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_sip'));
		karyawan_npwpField.setValue(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_npwp'));
		karyawan_usernameField.setValue(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_username'));
		karyawan_jmlanakField.setValue(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_jmlanak'));
		karyawan_namaField.setValue(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_nama'));
		karyawan_kelaminField.setValue(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_kelamin'));
		//karyawan_pph21Field.setValue(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_pph21'));
		karyawan_marriageField.setValue(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_marriage'));
		karyawan_bankField.setValue(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_bank'));
		karyawan_bankcabangField.setValue(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_bank_cabang'));
		karyawan_norekeningField.setValue(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_rekening'));
		karyawan_atasnamaField.setValue(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_atasnama'));
		karyawan_tgllahirField.setValue(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_tgllahir'));
		karyawan_tmplahirField.setValue(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_tmplahir'));
		karyawan_alamatField.setValue(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_alamat'));
		karyawan_kotaField.setValue(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_kota'));
		karyawan_kodeposField.setValue(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_kodepos'));
		karyawan_emailField.setValue(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_email'));
		karyawan_emiracleField.setValue(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_emiracle'));
		karyawan_jamsostekField.setValue(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_jamsostek'));
		karyawan_keteranganField.setValue(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_keterangan'));
		karyawan_notelpField.setValue(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_notelp'));
		karyawan_notelp2Field.setValue(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_notelp2'));
		karyawan_notelp3Field.setValue(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_notelp3'));
		karyawan_notelp4Field.setValue(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_notelp4'));
		karyawan_cabangField.setValue(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang'));
		//karyawan_jabatanField.setValue(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_jabatan'));
		//karyawan_departemenField.setValue(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_departemen'));
		//karyawan_golonganField.setValue(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_idgolongan'));
		karyawan_tglmasukField.setValue(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_tglmasuk'));
		//karyawan_tglbatasField.setValue(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_tgl_batas'));
		//karyawan_atasanField.setValue(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_atasan'));
		karyawan_aktifField.setValue(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_aktif'));
		cbo_karyawan_atasan_DataStore.load({params: {karyawan_id: get_pk_id()}});
		cbo_karyawan_cabang_DataStore.load();
		status_karyawan_DataStore.load({params: { master_id: get_pk_id(), start:0, limit: karyawan_pageS}});
		jabatan_DataStore.load({params: { master_id: get_pk_id(), start:0, limit: karyawan_pageS}});
		keluarga_DataStore.load({params: { master_id: get_pk_id(), start:0, limit: karyawan_pageS}});
		pendidikan_DataStore.load({params: { master_id: get_pk_id(), start:0, limit: karyawan_pageS}});
		cuti_DataStore.load({params: { master_id: get_pk_id(), start:0, limit: karyawan_pageS}});
		gantioff_DataStore.load({params: { master_id: get_pk_id(), start:0, limit: karyawan_pageS}});
		medical_DataStore.load({params: { master_id: get_pk_id(), start:0, limit: karyawan_pageS}});
		fasilitas_DataStore.load({params: { master_id: get_pk_id(), start:0, limit: karyawan_pageS}});
		
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(0)=="1")	
			karyawan_cab_thField.setValue(true);	
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(0)=="0")
			karyawan_cab_thField.setValue(false);
		
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(1)=="1")	
			karyawan_cab_kiField.setValue(true);	
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(1)=="0")
			karyawan_cab_kiField.setValue(false);
		
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(2)=="1")	
			karyawan_cab_hrField.setValue(true);	
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(2)=="0")
			karyawan_cab_hrField.setValue(false);
		
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(3)=="1")
			karyawan_cab_tpField.setValue(true);	
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(3)=="0")
			karyawan_cab_tpField.setValue(false);
		
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(4)=="1")	
			karyawan_cab_dpsField.setValue(true);	
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(4)=="0")
			karyawan_cab_dpsField.setValue(false);
		
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(5)=="1")	
			karyawan_cab_jktField.setValue(true);	
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(5)=="0")
			karyawan_cab_jktField.setValue(false);
		
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(6)=="1")	
			karyawan_cab_mtaField.setValue(true);	
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(6)=="0")
			karyawan_cab_mtaField.setValue(false);
		
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(7)=="1")	
			karyawan_cab_blpnField.setValue(true);	
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(7)=="0")
			karyawan_cab_blpnField.setValue(false);
		
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(8)=="1")	
			karyawan_cab_kutaField.setValue(true);	
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(8)=="0")
			karyawan_cab_kutaField.setValue(false);
				
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(9)=="1")	
			karyawan_cab_corpField.setValue(true);	
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(9)=="0")
			karyawan_cab_corpField.setValue(false);
		
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(10)=="1")	
			karyawan_cab_mksField.setValue(true);	
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(10)=="0")
			karyawan_cab_mksField.setValue(false);
		
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(11)=="1")	
			karyawan_cab_mdnField.setValue(true);	
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(11)=="0")
			karyawan_cab_mdnField.setValue(false);
		
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(12)=="1")	
			karyawan_cab_lbkField.setValue(true);	
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(12)=="0")
			karyawan_cab_lbkField.setValue(false);
		
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(13)=="1")
			karyawan_cab_mndField.setValue(true);	
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(13)=="0")
			karyawan_cab_mndField.setValue(false);
		
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(14)=="1")	
			karyawan_cab_ygkField.setValue(true);	
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(14)=="0")
			karyawan_cab_ygkField.setValue(false);
			
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(15)=="1")	
			karyawan_cab_mlgField.setValue(true);	
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(15)=="0")
			karyawan_cab_mlgField.setValue(false);
		
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(16)=="1")	
			karyawan_cab_btmField.setValue(true);	
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(16)=="0")
			karyawan_cab_btmField.setValue(false);
		
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(17)=="1")
			karyawan_cab_maaField.setValue(true);	
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(17)=="0")
			karyawan_cab_maaField.setValue(false);
		
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(18)=="1")	
			karyawan_cab_mgField.setValue(true);	
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(18)=="0")
			karyawan_cab_mgField.setValue(false);
			
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(19)=="1")	
			karyawan_cab_sjlField.setValue(true);	
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(19)=="0")
			karyawan_cab_sjlField.setValue(false);
	
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(20)=="1")	
			karyawan_cab_smgField.setValue(true);	
		if(karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_cabang2').charAt(20)=="0")
			karyawan_cab_smgField.setValue(false);
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_karyawan_form_valid(){
		return ( karyawan_namaField.isValid() && 
				karyawan_usernameField.isValid() &&  
				karyawan_cabangField.isValid() &&
				//karyawan_jabatanField.isValid() && 
				//karyawan_departemenField.isValid() && 
				karyawan_kelaminField.isValid() && 
				karyawan_agamaField.isValid() &&
				karyawan_marriageField.isValid() &&
				karyawan_tglmasukField.isValid()
				);
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		cbo_karyawan_cabang_DataStore.reload();
		cbo_karyawan_departemen_DataStore.reload();
		cbo_karyawan_golongan_DataStore.reload();
		cbo_karyawan_jabatan_DataStore.reload();
		cbo_karyawan_bank_DataStore.reload();
		cbo_karyawan_atasan_DataStore.reload();
		
		if(!karyawan_createWindow.isVisible()){
			//status_karyawan_DataStore.load({params: {master_id:0}});
			//jabatan_DataStore.load({params: {master_id:0}});
			//pendidikan_DataStore.load({params: {master_id:0}});
			//keluarga_DataStore.load({params: {master_id:0}});
			karyawan_post2db='CREATE';
			msg='created';
			karyawan_reset_form();
			
			karyawan_createWindow.show();
		} else {
			karyawan_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function karyawan_confirm_delete(){
		// only one karyawan is selected here
		if(karyawanListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', karyawan_delete);
		} else if(karyawanListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', karyawan_delete);
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Tidak ada yang dipilih untuk dihapus',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
  
	/* Function for Update Confirm */
	function karyawan_confirm_update(){
		/* only one record is selected here */
		cbo_karyawan_departemen_DataStore.load({
				params:{
					karyawan_id:karyawanListEditorGrid.getSelectionModel().getSelected().get('karyawan_id'),
					query:''
				}
		});
			
		if(karyawanListEditorGrid.selModel.getCount() == 1) {
			
			karyawan_post2db='UPDATE';
			msg='updated';
			karyawan_set_form();
			karyawan_createWindow.show();
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Anda belum memilih data yang akan diubah',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
  
  	/* Function for Delete Record */
	function karyawan_delete(btn){
		if(btn=='yes'){
			var selections = karyawanListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< karyawanListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.karyawan_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Mohon tunggu...',
				url: 'index.php?c=c_karyawan&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							karyawan_DataStore.reload();
							cbo_karyawan_cabang_DataStore.reload();
							cbo_karyawan_departemen_DataStore.reload();
							cbo_karyawan_golongan_DataStore.reload();
							cbo_karyawan_jabatan_DataStore.reload();
							cbo_karyawan_bank_DataStore.reload();
							cbo_karyawan_atasan_DataStore.reload();

							break;
						default:
							Ext.MessageBox.show({
								title: 'Warning',
								msg: 'Tidak bisa menghapus data yang diplih',
								buttons: Ext.MessageBox.OK,
								animEl: 'save',
								icon: Ext.MessageBox.WARNING
							});
							break;
					}
				},
				failure: function(response){
					var result=response.responseText;
					Ext.MessageBox.show({
					   title: 'Error',
					   msg: 'Tidak bisa terhubung dengan database server',
					   buttons: Ext.MessageBox.OK,
					   animEl: 'database',
					   icon: Ext.MessageBox.ERROR
					});	
				}
			});
		}  
	}
  	/* End of Function */
	
	// STATUS KARYAWAN
	//Status Karyawan Reader
	// Function for json reader of detail
	var status_karyawan_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		//id: 'rpaket_id'
	},[
	/* dataIndex => insert intoperawatan_ColumnModel, Mapping => for initiate table column */
			{name: 'kstatus_id', type: 'int', mapping: 'kstatus_id'},
			{name: 'kstatus_karyawan', type: 'string', mapping: 'kstatus_karyawan'},
			{name: 'kstatus_tglawal', type: 'date', dateFormat: 'Y-m-d', mapping: 'kstatus_tglawal'},
			{name: 'kstatus_tglakhir', type: 'date', dateFormat: 'Y-m-d', mapping: 'kstatus_tglakhir'},
			{name: 'kstatus_keterangan', type: 'string', mapping: 'kstatus_keterangan'}
	]);
	//eof
	// Status Karyawan DataStore
	/* Function for Retrieve DataStore of detail*/
	status_karyawan_DataStore = new Ext.data.Store({
		id: 'status_karyawan_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_karyawan&m=detail_status_karyawan_list',
			method: 'POST'
		}),
		reader: status_karyawan_reader,
		baseParams:{master_id: get_pk_id(), start:0, limit: karyawan_pageS },
		sortInfo:{field: 'kstatus_tglakhir', direction: "ASC"}
	});
	/* End of Function */
	// EOF STATUS KARYAWAN
	
	// JABATAN
	//Status Karyawan Reader
	// Function for json reader of detail
	var jabatan_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		//id: 'rpaket_id'
	},[
	/* dataIndex => insert intoperawatan_ColumnModel, Mapping => for initiate table column */
			
			{name: 'kjabatan_id', type: 'int', mapping: 'kjabatan_id'},
			{name: 'karyawan_departemen_id', type: 'int', mapping: 'kjabatan_departemen'},
			{name: 'karyawan_departemen_display', type: 'string', mapping: 'departemen_nama'},
			
			{name: 'karyawan_jabatan_id', type: 'int', mapping: 'kjabatan_jabatan'},
			{name: 'karyawan_jabatan_display', type: 'string', mapping: 'jabatan_nama'},
			
			{name: 'karyawan_golongan_id', type: 'int', mapping: 'kjabatan_golongan'},
			{name: 'karyawan_golongan_display', type: 'string', mapping: 'golongan_nama'},
			
			{name: 'kjabatan_pph21', type: 'string', mapping: 'kjabatan_pph21'},
			
			{name: 'karyawan_atasan_id', type: 'int', mapping: 'kjabatan_atasan'},
			{name: 'karyawan_atasan_display', type: 'string', mapping: 'atasan_nama'},

			{name: 'kjabatan_tglawal', type: 'date', dateFormat: 'Y-m-d', mapping: 'kjabatan_tglawal'},
			{name: 'kjabatan_tglakhir', type: 'date', dateFormat: 'Y-m-d', mapping: 'kjabatan_tglakhir'},
			{name: 'kjabatan_keterangan', type: 'string', mapping: 'kjabatan_keterangan'}
	]);
	//eof
	// Status Karyawan DataStore
	/* Function for Retrieve DataStore of detail*/
	jabatan_DataStore = new Ext.data.Store({
		id: 'jabatan_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_karyawan&m=detail_jabatan_list',
			method: 'POST'
		}),
		reader: jabatan_reader,
		baseParams:{master_id: get_pk_id(), start:0, limit: karyawan_pageS },
		sortInfo:{field: 'kjabatan_tglakhir', direction: "ASC"}
	});
	/* End of Function */
	// EOF JABATAN
	
	// PENDIDIKAN
	// pendidikan Reader
	// Function for json reader of detail
	var pendidikan_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		//id: 'rpaket_id'
	},[
	/* dataIndex => insert intoperawatan_ColumnModel, Mapping => for initiate table column */
			{name: 'kpendidikan_id', type: 'int', mapping: 'kpendidikan_id'},
			{name: 'kpendidikan_pendidikan', type: 'string', mapping: 'kpendidikan_pendidikan'},
			{name: 'kpendidikan_sekolah', type: 'string', mapping: 'kpendidikan_sekolah'},
			{name: 'kpendidikan_jurusan', type: 'string', mapping: 'kpendidikan_jurusan'},
			{name: 'kpendidikan_thnmasuk', type: 'int', mapping: 'kpendidikan_thnmasuk'},
			{name: 'kpendidikan_thnselesai', type: 'int', mapping: 'kpendidikan_thnselesai'},
			{name: 'kpendidikan_wisuda', type: 'int', mapping: 'kpendidikan_wisuda'},
			{name: 'kpendidikan_keterangan', type: 'string', mapping: 'kpendidikan_keterangan'}
	]);
	//eof
	// Pendidikan DataStore
	/* Function for Retrieve DataStore of detail*/
	pendidikan_DataStore = new Ext.data.Store({
		id: 'pendidikan_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_karyawan&m=detail_pendidikan_list',
			method: 'POST'
		}),
		reader: pendidikan_reader,
		baseParams:{master_id: get_pk_id(), start:0, limit: karyawan_pageS },
		sortInfo:{field: 'kpendidikan_thnselesai', direction: "ASC"}
	});
	/* End of Function */
	// EOF PENDIDIKAN
	
	// KELUARGA
	// keluarga Reader
	// Function for json reader of detail
	var keluarga_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		//id: 'rpaket_id'
	},[
	/* dataIndex => insert intoperawatan_ColumnModel, Mapping => for initiate table column */
			{name: 'kkeluarga_id', type: 'int', mapping: 'kkeluarga_id'},
			{name: 'kkeluarga_nama', type: 'string', mapping: 'kkeluarga_nama'},
			{name: 'kkeluarga_hubungan', type: 'string', mapping: 'kkeluarga_hubungan'},
			{name: 'kkeluarga_keterangan', type: 'string', mapping: 'kkeluarga_keterangan'}
	]);
	//eof
	// Keluarga  DataStore
	/* Function for Retrieve DataStore of detail*/
	keluarga_DataStore = new Ext.data.Store({
		id: 'keluarga_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_karyawan&m=detail_keluarga_list',
			method: 'POST'
		}),
		reader: keluarga_reader,
		baseParams:{master_id: get_pk_id(), start:0, limit: karyawan_pageS },
		sortInfo:{field: 'kkeluarga_id', direction: "ASC"}
	});
	/* End of Function */
	// EOF KELUARGA
	
	// CUTI
	// cuti Reader
	// Function for json reader of detail
	var cuti_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		//id: 'rpaket_id'
	},[
	/* dataIndex => insert intoperawatan_ColumnModel, Mapping => for initiate table column */
			{name: 'kcuti_id', type: 'int', mapping: 'kcuti_id'},
			{name: 'kcuti_jenis', type: 'string', mapping: 'kcuti_jenis'},
			{name: 'kcuti_tglawal', type: 'date', dateFormat: 'Y-m-d', mapping: 'kcuti_tglawal'},
			{name: 'kcuti_tglakhir', type: 'date', dateFormat: 'Y-m-d', mapping: 'kcuti_tglakhir'},
			{name: 'kcuti_jmlhari', type: 'int', mapping: 'kcuti_jmlhari'},
			{name: 'kcuti_tglpengajuan', type: 'date', dateFormat: 'Y-m-d', mapping: 'kcuti_tglpengajuan'},
			{name: 'kcuti_keterangan', type: 'string', mapping: 'kcuti_keterangan'}
	]);
	//eof
	// Cuti  DataStore
	/* Function for Retrieve DataStore of detail*/
	cuti_DataStore = new Ext.data.Store({
		id: 'cuti_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_karyawan&m=detail_cuti_list',
			method: 'POST'
		}),
		reader: cuti_reader,
		baseParams:{master_id: get_pk_id(), start:0, limit: karyawan_pageS },
		sortInfo:{field: 'kcuti_tglakhir', direction: "ASC"}
	});
	/* End of Function */
	// EOF CUTI
	
	// GANTIOFF
	// gantioff Reader
	// Function for json reader of detail
	var gantioff_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		//id: 'rpaket_id'
	},[
	/* dataIndex => insert intoperawatan_ColumnModel, Mapping => for initiate table column */
			{name: 'kgantioff_id', type: 'int', mapping: 'kgantioff_id'},
			{name: 'kgantioff_jenis', type: 'string', mapping: 'kgantioff_jenis'},
			{name: 'kgantioff_tglawal', type: 'date', dateFormat: 'Y-m-d', mapping: 'kgantioff_tglawal'},
			{name: 'kgantioff_tglakhir', type: 'date', dateFormat: 'Y-m-d', mapping: 'kgantioff_tglakhir'},
			{name: 'kgantioff_jmlhari', type: 'int', mapping: 'kgantioff_jmlhari'},
			{name: 'kgantioff_tglgantiawal', type: 'date', dateFormat: 'Y-m-d', mapping: 'kgantioff_tglgantiawal'},
			{name: 'kgantioff_tglgantiakhir', type: 'date', dateFormat: 'Y-m-d', mapping: 'kgantioff_tglgantiakhir'},
			{name: 'kgantioff_tglpengajuan', type: 'date', dateFormat: 'Y-m-d', mapping: 'kgantioff_tglpengajuan'},
			{name: 'kgantioff_keterangan', type: 'string', mapping: 'kgantioff_keterangan'}
	]);
	//eof
	// Gantioff  DataStore
	/* Function for Retrieve DataStore of detail*/
	gantioff_DataStore = new Ext.data.Store({
		id: 'gantioff_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_karyawan&m=detail_gantioff_list',
			method: 'POST'
		}),
		reader: gantioff_reader,
		baseParams:{master_id: get_pk_id(), start:0, limit: karyawan_pageS },
		sortInfo:{field: 'kgantioff_tglakhir', direction: "ASC"}
	});
	/* End of Function */
	// EOF GANTIOFF
	
	// MEDICAL
	// medical Reader
	// Function for json reader of detail
	var medical_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		//id: 'rpaket_id'
	},[
	/* dataIndex => insert intoperawatan_ColumnModel, Mapping => for initiate table column */
			{name: 'kmedical_id', type: 'int', mapping: 'kmedical_id'},
			{name: 'kmedical_tujuan', type: 'string', mapping: 'kmedical_tujuan'},
			{name: 'kmedical_jenis_rawat', type: 'string', mapping: 'kmedical_jenis_rawat'},
			{name: 'kmedical_jenis_klaim', type: 'string', mapping: 'kmedical_jenis_klaim'},
			{name: 'kmedical_jumlah', type: 'int', mapping: 'kmedical_jumlah'},
			{name: 'kmedical_total', type: 'float', mapping: 'kmedical_total'},
			{name: 'kmedical_tglkuitansi', type: 'date', dateFormat: 'Y-m-d', mapping: 'kmedical_tglkuitansi'},
			{name: 'kmedical_tglpengajuan', type: 'date', dateFormat: 'Y-m-d', mapping: 'kmedical_tglpengajuan'},
			{name: 'kmedical_keterangan', type: 'string', mapping: 'kmedical_keterangan'}
	]);
	//eof
	// Gantioff  DataStore
	/* Function for Retrieve DataStore of detail*/
	medical_DataStore = new Ext.data.Store({
		id: 'medical_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_karyawan&m=detail_medical_list',
			method: 'POST'
		}),
		reader: medical_reader,
		baseParams:{master_id: get_pk_id(), start:0, limit: karyawan_pageS },
		sortInfo:{field: 'kmedical_tglpengajuan', direction: "ASC"}
	});
	/* End of Function */
	// EOF MEDICAL
	
	// FASILITAS
	// fasilitas Reader
	// Function for json reader of detail
	var fasilitas_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		//id: 'rpaket_id'
	},[
	/* dataIndex => insert intoperawatan_ColumnModel, Mapping => for initiate table column */
			{name: 'kfasilitas_id', type: 'int', mapping: 'kfasilitas_id'},
			{name: 'kfasilitas_item', type: 'string', mapping: 'kfasilitas_item'},
			{name: 'kfasilitas_tglserahterima', type: 'date', dateFormat: 'Y-m-d', mapping: 'kfasilitas_tglserahterima'},
			{name: 'kfasilitas_keterangan', type: 'string', mapping: 'kfasilitas_keterangan'}
	]);
	//eof
	// Fasilitas  DataStore
	/* Function for Retrieve DataStore of detail*/
	fasilitas_DataStore = new Ext.data.Store({
		id: 'fasilitas_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_karyawan&m=detail_fasilitas_list',
			method: 'POST'
		}),
		reader: fasilitas_reader,
		baseParams:{master_id: get_pk_id(), start:0, limit: karyawan_pageS },
		sortInfo:{field: 'kfasilitas_tglserahterima', direction: "ASC"}
	});
	/* End of Function */
	// EOF FASILITAS
	
	//function for editor of detail
	var editor_detail_status_karyawan= new Ext.ux.grid.RowEditor({
        saveText: 'Update'/*,
		listeners: {
			afteredit: function(){
				status_karyawan_DataStore.commitChanges();
			}
		}*/
    });
	//eof
	
	//function for editor of detail
	var editor_detail_jabatan_karyawan= new Ext.ux.grid.RowEditor({
        saveText: 'Update'/*,
		listeners: {
			afteredit: function(){
				status_karyawan_DataStore.commitChanges();
			}
		}*/
    });
	//eof
	
	//function for editor of detail
	var editor_detail_pendidikan_karyawan= new Ext.ux.grid.RowEditor({
        saveText: 'Update'/*,
		listeners: {
			afteredit: function(){
				status_karyawan_DataStore.commitChanges();
			}
		}*/
    });
	//eof
	
	//function for editor of detail
	var editor_detail_keluarga_karyawan= new Ext.ux.grid.RowEditor({
        saveText: 'Update'/*,
		listeners: {
			afteredit: function(){
				status_karyawan_DataStore.commitChanges();
			}
		}*/
    });
	//eof
	
	//function for editor of detail
	var editor_detail_fasilitas_karyawan= new Ext.ux.grid.RowEditor({
        saveText: 'Update'/*,
		listeners: {
			afteredit: function(){
				status_karyawan_DataStore.commitChanges();
			}
		}*/
    });
	//eof
	
	//function for editor of detail
	var editor_detail_cuti_karyawan= new Ext.ux.grid.RowEditor({
        saveText: 'Update'/*,
		listeners: {
			afteredit: function(){
				status_karyawan_DataStore.commitChanges();
			}
		}*/
    });
	//eof
	
	//function for editor of detail
	var editor_detail_gantioff_karyawan= new Ext.ux.grid.RowEditor({
        saveText: 'Update'/*,
		listeners: {
			afteredit: function(){
				status_karyawan_DataStore.commitChanges();
			}
		}*/
    });
	//eof
	
	//function for editor of detail
	var editor_detail_medical_karyawan= new Ext.ux.grid.RowEditor({
        saveText: 'Update'/*,
		listeners: {
			afteredit: function(){
				status_karyawan_DataStore.commitChanges();
			}
		}*/
    });
	//eof
  
	/* Function for Retrieve DataStore */
	// datastore karyawan
	karyawan_DataStore = new Ext.data.Store({
		id: 'karyawan_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_karyawan&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST",start:0, limit: karyawan_pageS }, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'karyawan_id'
		},[
			{name: 'karyawan_id', type: 'int', mapping: 'karyawan_id'},
			{name: 'karyawan_no', type: 'string', mapping: 'karyawan_no'},
			{name: 'karyawan_ktp', type: 'string', mapping: 'karyawan_ktp'},
			{name: 'karyawan_alamat_ktp', type: 'string', mapping: 'karyawan_alamat_ktp'},
			{name: 'karyawan_agama', type: 'string', mapping: 'karyawan_agama'},
			{name: 'karyawan_bank', type: 'string', mapping: 'karyawan_bank_nama'},
			{name: 'karyawan_bank_cabang', type: 'string', mapping: 'karyawan_bank_cabang'},
			{name: 'karyawan_rekening', type: 'string', mapping: 'karyawan_rekening'},
			{name: 'karyawan_atasnama', type: 'string', mapping: 'karyawan_atasnama'},
			{name: 'karyawan_jamsostek', type: 'string', mapping: 'karyawan_jamsostek'},
			{name: 'karyawan_sip', type: 'string', mapping: 'karyawan_sip'},
			{name: 'karyawan_npwp', type: 'string', mapping: 'karyawan_npwp'},
			{name: 'karyawan_username', type: 'string', mapping: 'karyawan_username'},
			{name: 'karyawan_nama', type: 'string', mapping: 'karyawan_nama'},
			{name: 'karyawan_kelamin', type: 'string', mapping: 'karyawan_kelamin'},
			{name: 'karyawan_tgllahir', type: 'date', dateFormat: 'Y-m-d', mapping: 'karyawan_tgllahir'},
			{name: 'karyawan_alamat', type: 'string', mapping: 'karyawan_alamat'},
			{name: 'karyawan_kota', type: 'string', mapping: 'karyawan_kota'},
			{name: 'karyawan_kodepos', type: 'string', mapping: 'karyawan_kodepos'},
			{name: 'karyawan_email', type: 'string', mapping: 'karyawan_email'},
			{name: 'karyawan_emiracle', type: 'string', mapping: 'karyawan_emiracle'},
			{name: 'karyawan_keterangan', type: 'string', mapping: 'karyawan_keterangan'},
			{name: 'karyawan_notelp', type: 'string', mapping: 'karyawan_notelp'},
			{name: 'karyawan_notelp2', type: 'string', mapping: 'karyawan_notelp2'},
			{name: 'karyawan_notelp3', type: 'string', mapping: 'karyawan_notelp3'},
			{name: 'karyawan_notelp4', type: 'string', mapping: 'karyawan_notelp4'},
			{name: 'karyawan_cabang', type: 'string', mapping: 'cabang_nama'},
			{name: 'karyawan_jabatan', type: 'string', mapping: 'jabatan_nama'},
			{name: 'karyawan_departemen', type: 'string', mapping: 'departemen_nama'},
			{name: 'karyawan_idgolongan', type: 'string', mapping: 'nama_golongan'},
			{name: 'karyawan_tglmasuk', type: 'date', dateFormat: 'Y-m-d', mapping: 'karyawan_tglmasuk'},
			{name: 'karyawan_atasan', type: 'int', mapping: 'karyawan_atasan'},
			{name: 'karyawan_pph21', type: 'string', mapping: 'karyawan_pph21'},
			{name: 'karyawan_marriage', type: 'string', mapping: 'karyawan_marriage'},
			{name: 'karyawan_jmlanak', type: 'int', mapping: 'karyawan_jmlanak'},
			{name: 'karyawan_tgl_batas', type: 'date', mapping: 'karyawan_tgl_batas'},
			{name: 'karyawan_tmplahir', type: 'string', mapping: 'karyawan_tmplahir'},
			{name: 'karyawan_aktif', type: 'string', mapping: 'karyawan_aktif'},
			{name: 'karyawan_creator', type: 'string', mapping: 'karyawan_creator'},
			{name: 'karyawan_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'karyawan_date_create'},
			{name: 'karyawan_update', type: 'string', mapping: 'karyawan_update'},
			{name: 'karyawan_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'karyawan_date_update'},
			{name: 'karyawan_revised', type: 'int', mapping: 'karyawan_revised'},
			{name: 'karyawan_cabang2', type: 'string', mapping: 'karyawan_cabang2'}
		]),
//		sortInfo:{field: 'karyawan_id', direction: "ASC"}
	});
	/* End of Function */
	
	cbo_karyawan_atasan_DataStore = new Ext.data.Store({
		id: 'cbo_karyawan_atasan_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_karyawan&m=get_karyawan_atasan_list', 
			method: 'POST'
		}),
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'
		},[
			{name: 'karyawan_atasan_display', type: 'string', mapping: 'karyawan_nama'},
			{name: 'karyawan_atasan_value', type: 'int', mapping: 'karyawan_id'}
		]),
		sortInfo:{field: 'karyawan_atasan_display', direction: "ASC"}
	});
	
	
	cbo_karyawan_jabatan_DataStore = new Ext.data.Store({
		id: 'cbo_karyawan_jabatan_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_karyawan&m=get_karyawan_jabatan_list', 
			method: 'POST'
		}),
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'
		},[
			{name: 'karyawan_jabatan_display', type: 'string', mapping: 'jabatan_nama'},
			{name: 'karyawan_jabatan_value', type: 'int', mapping: 'jabatan_id'}
		]),
		sortInfo:{field: 'karyawan_jabatan_value', direction: "ASC"}
	});
	
	cbo_karyawan_bank_DataStore = new Ext.data.Store({
		id: 'cbo_karyawan_bank_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_karyawan&m=get_karyawan_bank_list', 
			method: 'POST'
		}),
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'
		},[
			{name: 'karyawan_bank_display', type: 'string', mapping: 'mbank_nama'},
			{name: 'karyawan_bank_value', type: 'int', mapping: 'mbank_id'}
		]),
		sortInfo:{field: 'karyawan_bank_value', direction: "ASC"}
	});
	
	cbo_karyawan_cabang_DataStore = new Ext.data.Store({
		id: 'cbo_karyawan_cabang_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_karyawan&m=get_karyawan_cabang_list', 
			method: 'POST'
		}),
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'
		},[
			{name: 'karyawan_cabang_display', type: 'string', mapping: 'cabang_nama'},
			{name: 'karyawan_cabang_value', type: 'int', mapping: 'cabang_id'}
		]),
		sortInfo:{field: 'karyawan_cabang_value', direction: "ASC"}
	});
	
	cbo_karyawan_departemen_DataStore = new Ext.data.Store({
		id: 'cbo_karyawan_departemen_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_karyawan&m=get_karyawan_departemen_list', 
			method: 'POST'
		}),
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'
		},[
			{name: 'karyawan_departemen_display', type: 'string', mapping: 'departemen_nama'},
			{name: 'karyawan_departemen_value', type: 'int', mapping: 'departemen_id'}
		]),
		sortInfo:{field: 'karyawan_departemen_display', direction: "ASC"}
	});
	
	cbo_karyawan_golongan_DataStore = new Ext.data.Store({
		id: 'cbo_karyawan_golongan_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_karyawan&m=get_karyawan_golongan_list', 
			method: 'POST'
		}),
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'
		},[
			{name: 'karyawan_golongan_display', type: 'string', mapping: 'nama_golongan'},
			{name: 'karyawan_golongan_value', type: 'int', mapping: 'id_golongan'}
		]),
		sortInfo:{field: 'karyawan_golongan_value', direction: "ASC"}
	});
	
	
    
  	/* Function for Identify of Window Column Model */
	karyawan_ColumnModel = new Ext.grid.ColumnModel(
		[{
			//index=0
			header: '#',
			readOnly: true,
			dataIndex: 'karyawan_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},
		{
			/*index=1*/
			header: '<div align="center">' + 'NIK' + '</div>',
			dataIndex: 'karyawan_no',
			width: 100,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,editor: new Ext.form.TextField({
				maxLength: 30
          	})
			<?php } ?>
		},
		{
			/*index=2*/
			header: 'NPWP',
			dataIndex: 'karyawan_npwp',
			width: 150,
			sortable: true,
			hidden: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 30
          	})
			<?php } ?>
			
		},
		{
			/*index=2*/
			header: 'PPH 21',
			dataIndex: 'karyawan_pph21',
			width: 50,
			sortable: true,
			hidden: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 30
          	})
			<?php } ?>
		},
		{
			/*index=3*/
			header: '<div align="center">' + 'Nickname' + '</div>',
			dataIndex: 'karyawan_username',
			width: 80,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 15
          	})
			<?php } ?>
		},
		{
			/*index=4*/
			header: '<div align="center">' + 'Nama Lengkap' + '</div>',
			dataIndex: 'karyawan_nama',
			width: 170,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 50
          	})
			<?php } ?>
		},
		{
			/*index=5*/
			header: '<div align="center">' + 'L/P' + '</div>',
			dataIndex: 'karyawan_kelamin',
			width: 30,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['karyawan_kelamin_value', 'karyawan_kelamin_display'],
					data: [['L','Laki-laki'],['P','Perempuan']]
					}),
				mode: 'local',
               	displayField: 'karyawan_kelamin_display',
               	valueField: 'karyawan_kelamin_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
			<?php } ?>
		},
		{
			/*index=5*/
			header: '<div align="center">' + 'Menikah' + '</div>',
			dataIndex: 'karyawan_marriage',
			width: 80,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['karyawan_marriage_value', 'karyawan_marriage_display'],
					data: [['Single','Belum'],['Marriage','Menikah']]
					}),
				mode: 'local',
               	displayField: 'karyawan_marriage_display',
               	valueField: 'karyawan_marriage_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
			<?php } ?>
		},
		{
			/*index=6*/
			header: '<div align="center">' + 'Tgl Lahir' + '</div>',
			dataIndex: 'karyawan_tgllahir',
			width: 80,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			editor: new Ext.form.DateField({
				format: 'd-m-Y'
			})
			<?php } ?>
		},
		{
			/*index=7*/
			header: '<div align="center">' + 'Tmp Lahir' + '</div>',
			dataIndex: 'karyawan_tmplahir',
			width: 100,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 200
          	})
			<?php } ?>
		},
		{
			/*index=7*/
			header: '<div align="center">' + 'Alamat' + '</div>',
			dataIndex: 'karyawan_alamat',
			width: 280,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
			<?php } ?>
		},
		{
			/*index=8*/
			header: '<div align="center">' + 'Kota' + '</div>',
			dataIndex: 'karyawan_kota',
			width: 80,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 30
          	})
			<?php } ?>
		},
		{
			/*index=9*/
			header: 'Kode Pos',
			dataIndex: 'karyawan_kodepos',
			width: 150, 
			hidden: true,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 10
          	})
			<?php } ?>
		},
		{
			/*index=10*/
			header: 'Email',
			dataIndex: 'karyawan_email',
			width: 150,
			sortable: true,
			hidden: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 40
          	})
			<?php } ?>
		},
		/*
		{
			header: 'Email Miracle',
			dataIndex: 'karyawan_emiracle',
			width: 150,
			sortable: true,
			hidden: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 40
          	})
			<?php } ?>
		},
		*/
		{
			/*index=12*/
			header: 'Keterangan',
			dataIndex: 'karyawan_keterangan',
			width: 150,
			sortable: true,
			hidden: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 500
          	})
			<?php } ?>
		},
		{
			/*index=13*/
			header: '<div align="center">' + 'No.Telp Rmh' + '</div>',
			dataIndex: 'karyawan_notelp',
			width: 90,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 25
          	})
			<?php } ?>
		},
		{
			/*index=14*/
			header: '<div align="center">' + 'Ponsel 1' + '</div>',
			dataIndex: 'karyawan_notelp2',
			width: 90,
			sortable: true,
			hidden: false
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 25
          	})
			<?php } ?>
		},
		{
			/*index=15*/
			header: 'Ponsel 2',
			dataIndex: 'karyawan_notelp3',
			width: 90,
			sortable: true,
			hidden: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 25
          	})
			<?php } ?>
		},
		{
			/*index=16*/
			header: 'Ponsel 3',
			dataIndex: 'karyawan_notelp4',
			width: 90,
			sortable: true,
			hidden: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 25
          	})
			<?php } ?>
			
		},
		{
			/*index=17*/
			header: 'Cabang',
			dataIndex: 'karyawan_cabang',
			width: 100,
			sortable: true,
			hidden: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store: cbo_karyawan_cabang_DataStore,
				mode: 'remote',
               	displayField: 'karyawan_cabang_display',
               	valueField: 'karyawan_cabang_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
			<?php } ?>
		},
		{
			/*index=18*/
			header: 'Jabatan',
			dataIndex: 'karyawan_jabatan',
			width: 150,
			sortable: true,
			hidden: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store: cbo_karyawan_jabatan_DataStore,
				mode: 'remote',
               	displayField: 'karyawan_jabatan_display',
               	valueField: 'karyawan_jabatan_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
			<?php } ?>
		},
		/*
		{
			header: '<div align="center">' + 'Departemen' + '</div>',
			dataIndex: 'karyawan_departemen',
			width: 80,
			sortable: true,
			hidden: false
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store: cbo_karyawan_departemen_DataStore,
				mode: 'remote',
               	displayField: 'karyawan_departemen_display',
               	valueField: 'karyawan_departemen_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
			<?php } ?>
		},
		*/
		{
			/*index=20*/
			header: 'Golongan',
			dataIndex: 'karyawan_idgolongan',
			width: 150,
			sortable: true,
			hidden: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store: cbo_karyawan_golongan_DataStore,
				mode: 'remote',
               	displayField: 'karyawan_golongan_display',
               	valueField: 'karyawan_golongan_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
			<?php } ?>
		},
		{
			/*index=21*/
			header: 'Tgl Masuk',
			dataIndex: 'karyawan_tglmasuk',
			width: 150,
			sortable: true,
			hidden: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d')
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,
			editor: new Ext.form.DateField({
				format: 'Y-m-d'
			})
			<?php } ?>
		},
		{
			/*index=6*/
			header: '<div align="center">' + 'Tgl Batas' + '</div>',
			dataIndex: 'karyawan_tgl_batas',
			width: 80,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),	
			hidden: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,
			editor: new Ext.form.DateField({
				format: 'Y-m-d'
			})
			<?php } ?>
		},
		{
			/*index=22*/
			header: 'Atasan',
			dataIndex: 'karyawan_atasan',
			width: 150,
			sortable: true,
			hidden: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store: cbo_karyawan_atasan_DataStore,
				mode: 'remote',
               	displayField: 'karyawan_atasan_display',
               	valueField: 'karyawan_atasan_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
			<?php } ?>
		},
		{
			/*index=23*/
			header: '<div align="center">' + 'Status' + '</div>',
			dataIndex: 'karyawan_aktif',
			width: 70,
			sortable: true,
			hidden: false
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['karyawan_aktif_value', 'karyawan_aktif_display'],
					data: [['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
					}),
				mode: 'local',
               	displayField: 'karyawan_aktif_display',
               	valueField: 'karyawan_aktif_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
			<?php } ?>
		},
		{
			/*index=24*/
			header: 'Creator',
			dataIndex: 'karyawan_creator',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		},
		{
			/*index=25*/
			header: 'Create on',
			dataIndex: 'karyawan_date_create',
			width: 150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			hidden: true,
			readOnly: true
		},
		{
			/*index=26*/
			header: 'Last Update by',
			dataIndex: 'karyawan_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		},
		{
			/*index=27*/
			header: 'Last Update on',
			dataIndex: 'karyawan_date_update',
			width: 150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			hidden: true,
			readOnly: true
		},
		{
			/*index=28*/
			header: 'Revised',
			dataIndex: 'karyawan_revised',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		},
		{
			/*index=29*/
			header: 'No. KTP',
			dataIndex: 'karyawan_ktp',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}
		,
		{
			/*index=30*/
			header: 'Alamat KTP',
			dataIndex: 'karyawan_alamat_ktp',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}
		,
		{
			/*index=31*/
			header: 'Agama',
			dataIndex: 'karyawan_agama',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		},
		{
			/*index=32*/
			header: 'Bank',
			dataIndex: 'karyawan_bank',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		},
		{
			/*index=33*/
			header: 'Bank Cabang',
			dataIndex: 'karyawan_bank_cabang',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		},
		{
			/*index=34*/
			header: 'No. Rekening',
			dataIndex: 'karyawan_rekening',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		},
		{
			/*index=35*/
			header: 'Atas Nama',
			dataIndex: 'karyawan_atasnama',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		},
		{
			/*index=35*/
			header: 'No. Jamsostek',
			dataIndex: 'karyawan_jamsostek',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}
		]
	);
	karyawan_ColumnModel.defaultSortable= true;
	/* End of Function */
	// declaration status kekaryawanan
	dkaryawan_statuskaryawanField= new Ext.form.ComboBox({
		id : 'dkaryawan_statuskaryawanField',
		store:new Ext.data.SimpleStore({
			fields:['status_karyawan_value'],
			data:[['Percobaan'],['Kontrak I'],['Kontrak II'],['Tetap'],['Lain-lain'],['Tidak Aktif']]
		}),
		mode: 'local',
		displayField: 'status_karyawan_value',
		valueField: 'status_karyawan_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true
	});
	
	/* Identify  dkaryawan_tglawalField Field */
	dkaryawan_tglawalField= new Ext.form.DateField({
		id: 'dkaryawan_tglawalField',
		//fieldLabel: 'Tanggal Masuk',
		format : 'Y-m-d',
		//vtype: 'daterange',
		endDateField: 'dkaryawan_tglakhirField',
		width : 100
	});
	
	/* Identify  dkaryawan_tglakhirField Field */
	dkaryawan_tglakhirField= new Ext.form.DateField({
		id: 'dkaryawan_tglakhirField',
		//fieldLabel: 'Tanggal Masuk',
		format : 'Y-m-d',
		value : today,
		//vtype: 'daterange',
		startDateField: 'dkaryawan_tglawalField', 
		width : 100
	});
	
	// eof declaration status kekaryawanan
	
	//declaration of detail coloumn model
	detail_status_karyawan_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			align : 'Left',
			header: 'ID',
			dataIndex: 'kstatus_id',
            hidden: true
		},
		/*
		{	align : 'Left',
			header: '<div align="center">' + 'Paket' + '</div>',
			dataIndex: 'dpaket_paket',
			width: 300,
			sortable: false,
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			editor: combo_jual_paket,
			<?php } ?>
			renderer: Ext.util.Format.comboRenderer(combo_jual_paket)
		},
		{
			align : 'Right',
			header: '<div align="center">' + 'Jumlah' + '</div>',
			dataIndex: 'dpaket_jumlah',
			width: 60,
			sortable: false,
			renderer: Ext.util.Format.numberRenderer('0,000')
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,
			editor: dpaket_jumlahField
			<?php } ?>
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Kadaluarsa' + '</div>',
			dataIndex: 'dpaket_kadaluarsa',
			width: 80,
			sortable: false,
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			editor: dpaket_kadaluarsaField,
			<?php } ?>
			renderer: Ext.util.Format.dateRenderer('d-m-Y')
		},
		{
			align : 'Right',
			header: '<div align="center">' + 'Harga (Rp)' + '</div>',
			dataIndex: 'dpaket_harga',
			width: 100,
			sortable: false,
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			editor: dpaket_hargaField,
			<?php } ?>
			renderer: Ext.util.Format.numberRenderer('0,000')
		},{
			align : 'Right',
			header: '<div align="center">' + 'Sub Total (Rp)' + '</div>',
			dataIndex: 'dpaket_subtotal',
			width: 100,
			sortable: false,
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			editor: dpaket_subtotalField,
			<?php } ?>
			//renderer: Ext.util.Format.numberRenderer('0,000'),
			renderer: function(v, params, record){
				return Ext.util.Format.number(record.data.dpaket_jumlah * record.data.dpaket_harga,'0,000');
            }
		},
		*/
		{
			align : 'Left',
			header: '<div align="center">' + 'Status Kekaryawanan' + '</div>',
			dataIndex: 'kstatus_karyawan',
			width: 140,
			sortable: false
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,
			editor: dkaryawan_statuskaryawanField
			<?php } ?>
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Tgl Awal' + '</div>',
			dataIndex: 'kstatus_tglawal',
			width: 100,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			readOnly: false,
			editor: dkaryawan_tglawalField
			/*
			new Ext.form.DateField({
				format: 'd-m-Y',
				disabled :false,
				})
			*/
			//editor: combo_paket_rawat,
			//renderer: Ext.util.Format.comboRenderer(combo_paket_rawat)
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Tgl Akhir' + '</div>',
			dataIndex: 'kstatus_tglakhir',
			width: 100,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			readOnly: false,
			editor: dkaryawan_tglakhirField
			/*new Ext.form.DateField({
				format: 'd-m-Y',
				disabled :false,
				})
			*/
			//editor: combo_paket_rawat,
			//renderer: Ext.util.Format.comboRenderer(combo_paket_rawat)
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Keterangan' + '</div>',
			dataIndex: 'kstatus_keterangan',
			width: 680,
			sortable: true,
			editor: new Ext.form.TextField({maxLength:250})
			//editor: combo_paket_rawat,
			//renderer: Ext.util.Format.comboRenderer(combo_paket_rawat)
		}
		/*
		{
			align : 'Right',
			header: '<div align="center">' + 'Diskon (%)' + '</div>',
			dataIndex: 'dpaket_diskon',
			width: 80,
			sortable: false,
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			editor: dpaket_jumlahdiskonField,
			<?php } ?>
			renderer: Ext.util.Format.numberRenderer('0,000')
		},{
			align : 'Right',
			header: '<div align="center">' + 'Sub Tot Net (Rp)' + '</div>',
			dataIndex: 'dpaket_subtotal_net',
			width: 100,
			sortable: false,
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			editor: dpaket_subtotalnetField,
			<?php } ?>
			//renderer: Ext.util.Format.numberRenderer('0,000')
			renderer: function(v, params, record){
				var record_dtotal_net = record.data.dpaket_jumlah*record.data.dpaket_harga*((100-record.data.dpaket_diskon)/100);
				record_dtotal_net = (record_dtotal_net>0?Math.round(record_dtotal_net):0);
				return Ext.util.Format.number(record_dtotal_net,'0,000');
            }
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Referal' + '</div>',
			dataIndex: 'dpaket_karyawan',
			width: 150,
			sortable: false,
			allowBlank: false,
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			editor: combo_reveral_paket,
			<?php } ?>
			renderer: Ext.util.Format.comboRenderer(combo_reveral_paket)
		}*/
		]
	);
	detail_status_karyawan_ColumnModel.defaultSortable= true;
	//eof
	
	//declaration of detail list editor grid
	detail_status_karyawanListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'detail_status_karyawanListEditorGrid',
		el: 'fp_detail_status_karyawan',
		title: 'Status Kekaryawanan',
		height: 200,
		width: 1050,
		autoScroll: true,
		store: status_karyawan_DataStore, //detail_jual_paket_DataStore, // DataStore
		colModel: detail_status_karyawan_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 0 0 0',
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
		plugins: [editor_detail_status_karyawan],
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		<?php } ?>
		frame: true,
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:false},
		bbar: new Ext.PagingToolbar({
			pageSize: karyawan_pageS,
			store: status_karyawan_DataStore,
			displayInfo: true
		})
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
		,
		/* Add Control on ToolBar */
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			ref : '../djpaket_add',
			handler: detail_status_karyawan_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			ref : '../djpaket_delete',
			disabled: false,
			handler: detail_status_karyawan_confirm_delete
		}
		]
		<?php } ?>
	});
	//eof
	
	//function of detail add
	function detail_status_karyawan_add(){
		var edit_detail_jual_paket= new detail_status_karyawanListEditorGrid.store.recordType({
			kstatus_id			:'',		
			kstatus_karyawan	:'',
			kstatus_tglawal		:today.dateFormat('Y-m-d'), //today.dateFormat('Y-m-d'),
			kstatus_tglakhir	:today.dateFormat('Y-m-d'),
			kstatus_keterangan	:''

		});
		
		editor_detail_status_karyawan.stopEditing();
		status_karyawan_DataStore.insert(0, edit_detail_jual_paket);
		detail_status_karyawanListEditorGrid.getView().refresh();
		detail_status_karyawanListEditorGrid.getSelectionModel().selectRow(0);
		editor_detail_status_karyawan.startEditing(0);
	}
	
	//function for insert detail
	function detail_status_karyawan_insert(){
		var kstatus_id=[];
		var kstatus_karyawan=[];
		var kstatus_tglawal=[];
		var kstatus_tglakhir=[];
		var kstatus_keterangan=[];
		
		var dcount = status_karyawan_DataStore.getCount() - 1;
		
		if(status_karyawan_DataStore.getCount()>0){
			for(i=0; i<status_karyawan_DataStore.getCount();i++){
			
				kstatus_id.push(status_karyawan_DataStore.getAt(i).data.kstatus_id);
				kstatus_karyawan.push(status_karyawan_DataStore.getAt(i).data.kstatus_karyawan);
				kstatus_tglawal.push(status_karyawan_DataStore.getAt(i).data.kstatus_tglawal);
				kstatus_tglakhir.push(status_karyawan_DataStore.getAt(i).data.kstatus_tglakhir);
				kstatus_keterangan.push(status_karyawan_DataStore.getAt(i).data.kstatus_keterangan);
			/*
				if((/^\d+$/.test(detail_jual_paket_DataStore.getAt(i).data.dpaket_paket))
				   && detail_jual_paket_DataStore.getAt(i).data.dpaket_paket!==undefined
				   && detail_jual_paket_DataStore.getAt(i).data.dpaket_paket!==''
				   && detail_jual_paket_DataStore.getAt(i).data.dpaket_paket!==0){
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_id==undefined){
						dpaket_id.push('');
					}else{
						dpaket_id.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_id);
					}
					
					dpaket_paket.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_paket);
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_karyawan==undefined){
						dpaket_karyawan.push('');
					}else{
						dpaket_karyawan.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_karyawan);
					}
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_jumlah==undefined){
						dpaket_jumlah.push('');
					}else{
						dpaket_jumlah.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_jumlah);
					}
					
					dpaket_kadaluarsa.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_kadaluarsa.format('Y-m-d'));
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_harga==undefined){
						dpaket_harga.push('');
					}else{
						dpaket_harga.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_harga);
					}
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_diskon==undefined){
						dpaket_diskon.push('');
					}else{
						dpaket_diskon.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_diskon);
					}
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_diskon_jenis==undefined){
						dpaket_diskon_jenis.push('');
					}else{
						dpaket_diskon_jenis.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_diskon_jenis);
					}
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_sales==undefined){
						dpaket_sales.push('');
					}else{
						dpaket_sales.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_sales);
					}
				}
				*/
				if(i==dcount){
					var encoded_array_kstatus_id = Ext.encode(kstatus_id);
					var encoded_array_kstatus_karyawan = Ext.encode(kstatus_karyawan);
					var encoded_array_kstatus_tglawal = Ext.encode(kstatus_tglawal);
					var encoded_array_kstatus_tglakhir = Ext.encode(kstatus_tglakhir);
					var encoded_array_kstatus_keterangan = Ext.encode(kstatus_keterangan);
					Ext.Ajax.request({
						waitMsg: 'Mohon  Tunggu...',
						url: 'index.php?c=c_karyawan&m=detail_status_karyawan_insert',
						params:{
							kstatus_id			: encoded_array_kstatus_id, 
							kstatus_master		: eval(get_pk_id()),
							kstatus_karyawan	: encoded_array_kstatus_karyawan,
							kstatus_tglawal		: encoded_array_kstatus_tglawal,
							kstatus_tglakhir	: encoded_array_kstatus_tglakhir,
							kstatus_keterangan	: encoded_array_kstatus_keterangan
						},
						timeout: 60000,
						/*
						success: function(response){							
							var result=eval(response.responseText);
							if(result==0){
								Ext.MessageBox.alert(jpaket_post2db+' OK','Data penjualan paket berhasil disimpan');
								jpaket_btn_cancel();
							}else if(result>0){
								jpaket_cetak(result);
								cetak_jpaket=0;
							}else{
								jpaket_btn_cancel();
							}
						},
						failure: function(response){
							var result=response.responseText;
							Ext.MessageBox.show({
							   title: 'Error',
							   msg: 'Could not connect to the database. retry later.',
							   buttons: Ext.MessageBox.OK,
							   animEl: 'database',
							   icon: Ext.MessageBox.ERROR
							});
							jpaket_btn_cancel();
						}
						*/
					});
					
				}
				
			}
		}
		
	}
	//eof
	
	/* Function for Delete Confirm of detail */
	function detail_status_karyawan_confirm_delete(){
		// only one record is selected here
		if(detail_status_karyawanListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', detail_status_karyawan_delete);
		} else if(detail_status_karyawanListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', detail_status_karyawan_delete);
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Anda belum memilih data yang akan dihapus',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
	//eof
	
	//function for Delete of detail
	function detail_status_karyawan_delete(btn){
		if(btn=='yes'){
            var selections = detail_status_karyawanListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, record; record = selections[i]; i++){
                if(record.data.kstatus_id==''){
                    status_karyawan_DataStore.remove(record);
					//load_dstore_jpaket();
                }else if((/^\d+$/.test(record.data.kstatus_id))){
                    //Delete dari db.detail_jual_paket
                    Ext.MessageBox.show({
                        title: 'Please wait',
                        msg: 'Loading items...',
                        progressText: 'Initializing...',
                        width:300,
                        wait:true,
                        waitConfig: {interval:200},
                        closable:false
                    });
                    status_karyawan_DataStore.remove(record);
                    Ext.Ajax.request({ 
                        waitMsg: 'Please Wait',
                        url: 'index.php?c=c_karyawan&m=get_action', 
                        params: { task: "DDELETE", kstatus_id:  record.data.kstatus_id }, 
                        success: function(response){
							var result=eval(response.responseText);
							switch(result){
								case 1:
									//load_dstore_jpaket();
                                    Ext.MessageBox.hide();
									//Ext.Msg.alert('OK', 'Penghapusan secara permanen sudah dilakukan.');
									break;
								default:
									Ext.MessageBox.hide();
                                    Ext.MessageBox.show({
                                        title: 'Warning',
                                        msg: 'Could not delete the entire selection',
                                        buttons: Ext.MessageBox.OK,
                                        animEl: 'save',
                                        icon: Ext.MessageBox.WARNING
                                    });
                                    break;
							}
                        },
                        failure: function(response){
                            Ext.MessageBox.hide();
                            var result=response.responseText;
                            Ext.MessageBox.show({
                               title: 'Error',
                               msg: 'Could not connect to the database. retry later.',
                               buttons: Ext.MessageBox.OK,
                               animEl: 'database',
                               icon: Ext.MessageBox.ERROR
                            });	
                        }
                    });
                }
			}
		} 
		
	}
	//eof
	
	// JABATAN
	// declaration jabatan
	var jabatan_departemen_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span>{karyawan_departemen_display}</span>',
		'</div></tpl>'
    );
	
	var jabatan_jabatan_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span>{karyawan_jabatan_display}</span>',
		'</div></tpl>'
    );
	
	var jabatan_golongan_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span>{karyawan_golongan_display}</span>',
		'</div></tpl>'
    );
	
	var jabatan_atasan_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span>{karyawan_atasan_display}</span>',
		'</div></tpl>'
    );
	
	
	var djabatan_departemenField=new Ext.form.ComboBox({
		store: cbo_karyawan_departemen_DataStore,
		mode: 'remote',
		displayField: 'karyawan_departemen_display',
		valueField: 'karyawan_departemen_value',
		typeAhead: false,
		loadingText: 'Searching...',
		pageSize:karyawan_pageS,
		hideTrigger:false,
		tpl: jabatan_departemen_tpl,
		//applyTo: 'search',
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});
	
	var djabatan_jabatanField=new Ext.form.ComboBox({
		store: cbo_karyawan_jabatan_DataStore,
		mode: 'remote',
		displayField: 'karyawan_jabatan_display',
		valueField: 'karyawan_jabatan_value',
		typeAhead: false,
		loadingText: 'Searching...',
		pageSize:karyawan_pageS,
		hideTrigger:false,
		tpl: jabatan_jabatan_tpl,
		//applyTo: 'search',
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});
	
	var djabatan_golonganField=new Ext.form.ComboBox({
		store: cbo_karyawan_golongan_DataStore,
		mode: 'remote',
		displayField: 'karyawan_golongan_display',
		valueField: 'karyawan_golongan_value',
		typeAhead: false,
		loadingText: 'Searching...',
		pageSize:karyawan_pageS,
		hideTrigger:false,
		tpl: jabatan_golongan_tpl,
		//applyTo: 'search',
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});
	
	var djabatan_pph21Field= new Ext.form.ComboBox({
		store:new Ext.data.SimpleStore({
			fields:['karyawan_pph21_value'],
			data:[['TK'],['K'],['K/1'],['K/2'],['K/3'],['TK/1'],['TK/2'],['TK/3']]
		}),
		mode: 'local',
		displayField: 'karyawan_pph21_value',
		valueField: 'karyawan_pph21_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true
	});
	
	var djabatan_atasanField=new Ext.form.ComboBox({
		store: cbo_karyawan_atasan_DataStore,
		mode: 'remote',
		displayField: 'karyawan_atasan_display',
		valueField: 'karyawan_atasan_value',
		typeAhead: false,
		loadingText: 'Searching...',
		pageSize:karyawan_pageS,
		hideTrigger:false,
		tpl: jabatan_atasan_tpl,
		//applyTo: 'search',
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});
	
	
	
	// eof declaration status kekaryawanan
	
	//declaration of detail coloumn model
	detail_jabatan_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			align : 'Left',
			header: 'ID',
			dataIndex: 'kjabatan_id',
            hidden: true
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Departemen' + '</div>',
			dataIndex: 'karyawan_departemen_id',
			width: 100,
			sortable: false
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,
			editor: djabatan_departemenField
		
			<?php } ?>
			,renderer: Ext.util.Format.comboRenderer(djabatan_departemenField)
		}
		,
		{
			align : 'Left',
			header: '<div align="center">' + 'Jabatan' + '</div>',
			dataIndex: 'karyawan_jabatan_id',
			width: 100,
			sortable: false
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,
			editor: djabatan_jabatanField
			<?php } ?>
			,renderer: Ext.util.Format.comboRenderer(djabatan_jabatanField)
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Golongan' + '</div>',
			dataIndex: 'karyawan_golongan_id',
			width: 100,
			sortable: false
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,
			editor: djabatan_golonganField
			<?php } ?>
			,renderer: Ext.util.Format.comboRenderer(djabatan_golonganField)
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'PPH 21' + '</div>',
			dataIndex: 'kjabatan_pph21',
			width: 50,
			sortable: false
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,
			editor: djabatan_pph21Field
			<?php } ?>
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Atasan Langsung' + '</div>',
			dataIndex: 'karyawan_atasan_id',
			width: 140,
			sortable: false
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,
			editor: djabatan_atasanField
			<?php } ?>
			,renderer: Ext.util.Format.comboRenderer(djabatan_atasanField)
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Tgl Awal' + '</div>',
			dataIndex: 'kjabatan_tglawal',
			width: 100,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			readOnly: false,
			editor: new Ext.form.DateField({
				format: 'd-m-Y',
				disabled :false,
				})
			//editor: combo_paket_rawat,
			//renderer: Ext.util.Format.comboRenderer(combo_paket_rawat)
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Tgl Akhir' + '</div>',
			dataIndex: 'kjabatan_tglakhir',
			width: 100,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			readOnly: false,
			editor: new Ext.form.DateField({
				format: 'd-m-Y',
				disabled :false,
				})
			//editor: combo_paket_rawat,
			//renderer: Ext.util.Format.comboRenderer(combo_paket_rawat)
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Keterangan' + '</div>',
			dataIndex: 'kjabatan_keterangan',
			width: 300,
			sortable: true,
			editor: new Ext.form.TextField({maxLength:250})
			//editor: combo_paket_rawat,
			//renderer: Ext.util.Format.comboRenderer(combo_paket_rawat)
		}
		]
	);
	detail_jabatan_ColumnModel.defaultSortable= true;
	//eof
	//declaration of detail list editor grid
	detail_jabatanListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'detail_jabatanListEditorGrid',
		el: 'fp_detail_jabatan',
		title: 'Jabatan',
		height: 200,
		width: 1050,
		autoScroll: true,
		store: jabatan_DataStore, //detail_jual_paket_DataStore, // DataStore
		colModel: detail_jabatan_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 0 0 0',
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
		plugins: [editor_detail_jabatan_karyawan],
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		<?php } ?>
		frame: true,
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:false},
		bbar: new Ext.PagingToolbar({
			pageSize: karyawan_pageS,
			store: jabatan_DataStore,
			displayInfo: true
		})
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
		,
		/* Add Control on ToolBar */
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			ref : '../djpaket_add',
			handler: detail_jabatan_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			ref : '../djpaket_delete',
			disabled: false,
			handler: detail_jabatan_confirm_delete
		}
		]
		<?php } ?>
	});
	//eof
	
	//function of detail add
	function detail_jabatan_add(){
		var edit_detail_jual_paket= new detail_jabatanListEditorGrid.store.recordType({
			kjabatan_id				:'',		
			karyawan_departemen_id	:'',
			karyawan_jabatan_id		:'',
			karyawan_golongan_id	:'',
			kjabatan_pph21			:'',
			karyawan_atasan_id		:'',
			kjabatan_tglawal		:null,
			kjabatan_tglakhir		:null,
			kjabatan_keterangan		:''
			
		});
		editor_detail_jabatan_karyawan.stopEditing();
		jabatan_DataStore.insert(0, edit_detail_jual_paket);
		detail_jabatanListEditorGrid.getView().refresh();
		detail_jabatanListEditorGrid.getSelectionModel().selectRow(0);
		editor_detail_jabatan_karyawan.startEditing(0);
	}
	
	//function for insert detail
	function detail_jabatan_insert(){
		var	kjabatan_id				=[];		
		var	karyawan_departemen_id	=[];
		var	karyawan_jabatan_id		=[];
		var	karyawan_golongan_id	=[];
		var	kjabatan_pph21			=[];
		var	karyawan_atasan_id		=[];
		var	kjabatan_tglawal		=[];
		var	kjabatan_tglakhir		=[];
		var	kjabatan_keterangan		=[];
		
		var dcount = jabatan_DataStore.getCount() - 1;
		
		if(jabatan_DataStore.getCount()>0){
			for(i=0; i<jabatan_DataStore.getCount();i++){
				/*
				kjabatan_id.push(jabatan_DataStore.getAt(i).data.kjabatan_id);
				kjabatan_departemen.push(jabatan_DataStore.getAt(i).data.kjabatan_departemen);
				kjabatan_jabatan.push(jabatan_DataStore.getAt(i).data.kjabatan_jabatan);
				kjabatan_golongan.push(jabatan_DataStore.getAt(i).data.kjabatan_golongan);
				kjabatan_pph21.push(jabatan_DataStore.getAt(i).data.kjabatan_pph21);
				kjabatan_atasan.push(jabatan_DataStore.getAt(i).data.kjabatan_atasan);
				kjabatan_tglawal.push(jabatan_DataStore.getAt(i).data.kjabatan_tglawal);
				kjabatan_tglakhir.push(jabatan_DataStore.getAt(i).data.kjabatan_tglakhir);
				kjabatan_keterangan.push(jabatan_DataStore.getAt(i).data.kjabatan_keterangan);
				*/
				
			/*
				if((/^\d+$/.test(detail_jual_paket_DataStore.getAt(i).data.dpaket_paket))
				   && detail_jual_paket_DataStore.getAt(i).data.dpaket_paket!==undefined
				   && detail_jual_paket_DataStore.getAt(i).data.dpaket_paket!==''
				   && detail_jual_paket_DataStore.getAt(i).data.dpaket_paket!==0){
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_id==undefined){
						dpaket_id.push('');
					}else{
						dpaket_id.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_id);
					}
					
					dpaket_paket.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_paket);
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_karyawan==undefined){
						dpaket_karyawan.push('');
					}else{
						dpaket_karyawan.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_karyawan);
					}
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_jumlah==undefined){
						dpaket_jumlah.push('');
					}else{
						dpaket_jumlah.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_jumlah);
					}
					
					dpaket_kadaluarsa.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_kadaluarsa.format('Y-m-d'));
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_harga==undefined){
						dpaket_harga.push('');
					}else{
						dpaket_harga.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_harga);
					}
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_diskon==undefined){
						dpaket_diskon.push('');
					}else{
						dpaket_diskon.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_diskon);
					}
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_diskon_jenis==undefined){
						dpaket_diskon_jenis.push('');
					}else{
						dpaket_diskon_jenis.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_diskon_jenis);
					}
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_sales==undefined){
						dpaket_sales.push('');
					}else{
						dpaket_sales.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_sales);
					}
				}
				*/
				
				kjabatan_id.push(jabatan_DataStore.getAt(i).data.kjabatan_id);
				karyawan_departemen_id.push(jabatan_DataStore.getAt(i).data.karyawan_departemen_id);
				karyawan_jabatan_id.push(jabatan_DataStore.getAt(i).data.karyawan_jabatan_id);
				karyawan_golongan_id.push(jabatan_DataStore.getAt(i).data.karyawan_golongan_id);
				kjabatan_pph21.push(jabatan_DataStore.getAt(i).data.kjabatan_pph21);
				karyawan_atasan_id.push(jabatan_DataStore.getAt(i).data.karyawan_atasan_id);
				kjabatan_tglawal.push(jabatan_DataStore.getAt(i).data.kjabatan_tglawal);
				kjabatan_tglakhir.push(jabatan_DataStore.getAt(i).data.kjabatan_tglakhir);
				kjabatan_keterangan.push(jabatan_DataStore.getAt(i).data.kjabatan_keterangan);
				if(i==dcount){
					var encoded_array_djabatan_id = Ext.encode(kjabatan_id);
					var encoded_array_djabatan_departemen = Ext.encode(karyawan_departemen_id);
					var encoded_array_djabatan_jabatan = Ext.encode(karyawan_jabatan_id);
					var encoded_array_djabatan_golongan = Ext.encode(karyawan_golongan_id);
					var encoded_array_djabatan_pph21 = Ext.encode(kjabatan_pph21);
					var encoded_array_djabatan_atasan = Ext.encode(karyawan_atasan_id);
					var encoded_array_djabatan_tglawal = Ext.encode(kjabatan_tglawal);
					var encoded_array_djabatan_tglakhir = Ext.encode(kjabatan_tglakhir);
					var encoded_array_djabatan_keterangan = Ext.encode(kjabatan_keterangan);
					Ext.Ajax.request({
						waitMsg: 'Mohon  Tunggu...',
						url: 'index.php?c=c_karyawan&m=detail_jabatan_insert',
						params:{
							djabatan_id				: encoded_array_djabatan_id, 
							djabatan_master			: eval(get_pk_id()),
							djabatan_departemen		: encoded_array_djabatan_departemen,
							djabatan_jabatan		: encoded_array_djabatan_jabatan,
							djabatan_golongan		: encoded_array_djabatan_golongan,
							djabatan_pph21			: encoded_array_djabatan_pph21,
							djabatan_atasan			: encoded_array_djabatan_atasan,
							djabatan_tglawal		: encoded_array_djabatan_tglawal,
							djabatan_tglakhir		: encoded_array_djabatan_tglakhir,
							djabatan_keterangan		: encoded_array_djabatan_keterangan
						},
						timeout: 60000,
						/*
						success: function(response){							
							var result=eval(response.responseText);
							if(result==0){
								Ext.MessageBox.alert(jpaket_post2db+' OK','Data penjualan paket berhasil disimpan');
								jpaket_btn_cancel();
							}else if(result>0){
								jpaket_cetak(result);
								cetak_jpaket=0;
							}else{
								jpaket_btn_cancel();
							}
						},
						failure: function(response){
							var result=response.responseText;
							Ext.MessageBox.show({
							   title: 'Error',
							   msg: 'Could not connect to the database. retry later.',
							   buttons: Ext.MessageBox.OK,
							   animEl: 'database',
							   icon: Ext.MessageBox.ERROR
							});
							jpaket_btn_cancel();
						}
						*/
					});
					
				}
				
			}
		}
		
	}
	//eof
	
	/* Function for Delete Confirm of detail */
	function detail_jabatan_confirm_delete(){
		// only one record is selected here
		if(detail_jabatanListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', detail_status_karyawan_delete);
		} else if(detail_jabatanListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', detail_status_karyawan_delete);
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Anda belum memilih data yang akan dihapus',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
	//eof
	
	//function for Delete of detail
	function detail_jabatan_delete(btn){
		if(btn=='yes'){
            var selections = detail_jabatanListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, record; record = selections[i]; i++){
                if(record.data.kstatus_id==''){
                    jabatan_DataStore.remove(record);
					//load_dstore_jpaket();
                }else if((/^\d+$/.test(record.data.kstatus_id))){
                    //Delete dari db.detail_jual_paket
                    Ext.MessageBox.show({
                        title: 'Please wait',
                        msg: 'Loading items...',
                        progressText: 'Initializing...',
                        width:300,
                        wait:true,
                        waitConfig: {interval:200},
                        closable:false
                    });
                    jabatan_DataStore.remove(record);
                    Ext.Ajax.request({ 
                        waitMsg: 'Please Wait',
                        url: 'index.php?c=c_karyawan&m=get_action', 
                        params: { task: "DDELETE", kstatus_id:  record.data.kstatus_id }, 
                        success: function(response){
							var result=eval(response.responseText);
							switch(result){
								case 1:
									//load_dstore_jpaket();
                                    Ext.MessageBox.hide();
									//Ext.Msg.alert('OK', 'Penghapusan secara permanen sudah dilakukan.');
									break;
								default:
									Ext.MessageBox.hide();
                                    Ext.MessageBox.show({
                                        title: 'Warning',
                                        msg: 'Could not delete the entire selection',
                                        buttons: Ext.MessageBox.OK,
                                        animEl: 'save',
                                        icon: Ext.MessageBox.WARNING
                                    });
                                    break;
							}
                        },
                        failure: function(response){
                            Ext.MessageBox.hide();
                            var result=response.responseText;
                            Ext.MessageBox.show({
                               title: 'Error',
                               msg: 'Could not connect to the database. retry later.',
                               buttons: Ext.MessageBox.OK,
                               animEl: 'database',
                               icon: Ext.MessageBox.ERROR
                            });	
                        }
                    });
                }
			}
		} 
		
	}
	//eof
	// EOF JABATAN
	
	// PENDIDIKAN
	// declaration pendidikan
	var kpendidikan_Field= new Ext.form.ComboBox({
		store:new Ext.data.SimpleStore({
			fields:['karyawan_pendidikan_value'],
			data:[['SD'],['SMP'],['SMA'],['D1'],['D2'],['D3'],['D4'],['S1'],['S2'],['S3']]
		}),
		mode: 'local',
		displayField: 'karyawan_pendidikan_value',
		valueField: 'karyawan_pendidikan_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true
	});
	
	
	// eof declaration status kekaryawanan
	
	//declaration of detail coloumn model
	detail_pendidikan_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			align : 'Left',
			header: 'ID',
			dataIndex: 'kpendidikan_id',
            hidden: true
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Pendidikan' + '</div>',
			dataIndex: 'kpendidikan_pendidikan',
			width: 100,
			sortable: false
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,
			editor: kpendidikan_Field,
		
			<?php } ?>
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Nama Sekolah' + '</div>',
			dataIndex: 'kpendidikan_sekolah',
			width: 300,
			sortable: true,
			editor: new Ext.form.TextField({maxLength:250})
			//editor: combo_paket_rawat,
			//renderer: Ext.util.Format.comboRenderer(combo_paket_rawat)
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Jurusan' + '</div>',
			dataIndex: 'kpendidikan_jurusan',
			width: 100,
			sortable: true,
			editor: new Ext.form.TextField({maxLength:250})
			//editor: combo_paket_rawat,
			//renderer: Ext.util.Format.comboRenderer(combo_paket_rawat)
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Thn Masuk' + '</div>',
			dataIndex: 'kpendidikan_thnmasuk',
			width: 70,
			sortable: true,
			editor: new Ext.form.TextField({maxLength:250})
			//editor: combo_paket_rawat,
			//renderer: Ext.util.Format.comboRenderer(combo_paket_rawat)
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Thn Sls' + '</div>',
			dataIndex: 'kpendidikan_thnselesai',
			width: 70,
			sortable: true,
			editor: new Ext.form.TextField({maxLength:250})
			//editor: combo_paket_rawat,
			//renderer: Ext.util.Format.comboRenderer(combo_paket_rawat)
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Wisuda' + '</div>',
			dataIndex: 'kpendidikan_wisuda',
			width: 70,
			sortable: true,
			editor: new Ext.form.TextField({maxLength:250})
			//editor: combo_paket_rawat,
			//renderer: Ext.util.Format.comboRenderer(combo_paket_rawat)
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Keterangan' + '</div>',
			dataIndex: 'kpendidikan_keterangan',
			width: 300,
			sortable: true,
			editor: new Ext.form.TextField({maxLength:250})
			//editor: combo_paket_rawat,
			//renderer: Ext.util.Format.comboRenderer(combo_paket_rawat)
		}
		]
	);
	detail_pendidikan_ColumnModel.defaultSortable= true;
	//eof
	//declaration of detail list editor grid
	detail_pendidikanListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'detail_pendidikanListEditorGrid',
		el: 'fp_detail_pendidikan',
		title: 'Pendidikan',
		height: 200,
		width: 1050,
		autoScroll: true,
		store: pendidikan_DataStore, //detail_jual_paket_DataStore, // DataStore
		colModel: detail_pendidikan_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 0 0 0',
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
		plugins: [editor_detail_pendidikan_karyawan],
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		<?php } ?>
		frame: true,
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:false},
		bbar: new Ext.PagingToolbar({
			pageSize: karyawan_pageS,
			store: pendidikan_DataStore,
			displayInfo: true
		})
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
		,
		/* Add Control on ToolBar */
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			ref : '../djpaket_add',
			handler: detail_pendidikan_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			ref : '../djpaket_delete',
			disabled: false,
			handler: detail_pendidikan_confirm_delete
		}
		]
		<?php } ?>
	});
	//eof
	
	//function of detail add
	function detail_pendidikan_add(){
		var edit_detail_pendidikan= new detail_pendidikanListEditorGrid.store.recordType({
			kpendidikan_id			:'',		
			kpendidikan_pendidikan	:'',
			kpendidikan_sekolah		:'',
			kpendidikan_jurusan		:'',
			kpendidikan_thnmasuk	:'',
			kpendidikan_thnselesai	:'',
			kpendidikan_wisuda		:'',
			kpendidikan_keterangan	:''
			
		});
		editor_detail_pendidikan_karyawan.stopEditing();
		pendidikan_DataStore.insert(0, edit_detail_pendidikan);
		detail_pendidikanListEditorGrid.getView().refresh();
		detail_pendidikanListEditorGrid.getSelectionModel().selectRow(0);
		editor_detail_pendidikan_karyawan.startEditing(0);
	}
	
	//function for insert detail
	function detail_pendidikan_insert(){
		var	kpendidikan_id			=[];		
		var	kpendidikan_pendidikan	=[];
		var	kpendidikan_sekolah		=[];
		var	kpendidikan_jurusan		=[];
		var	kpendidikan_thnmasuk	=[];
		var	kpendidikan_thnselesai	=[];
		var	kpendidikan_wisuda		=[];
		var	kpendidikan_keterangan	=[];
		
		var dcount = pendidikan_DataStore.getCount() - 1;
		
		if(pendidikan_DataStore.getCount()>0){
			for(i=0; i<pendidikan_DataStore.getCount();i++){
				/*
				kjabatan_id.push(jabatan_DataStore.getAt(i).data.kjabatan_id);
				kjabatan_departemen.push(jabatan_DataStore.getAt(i).data.kjabatan_departemen);
				kjabatan_jabatan.push(jabatan_DataStore.getAt(i).data.kjabatan_jabatan);
				kjabatan_golongan.push(jabatan_DataStore.getAt(i).data.kjabatan_golongan);
				kjabatan_pph21.push(jabatan_DataStore.getAt(i).data.kjabatan_pph21);
				kjabatan_atasan.push(jabatan_DataStore.getAt(i).data.kjabatan_atasan);
				kjabatan_tglawal.push(jabatan_DataStore.getAt(i).data.kjabatan_tglawal);
				kjabatan_tglakhir.push(jabatan_DataStore.getAt(i).data.kjabatan_tglakhir);
				kjabatan_keterangan.push(jabatan_DataStore.getAt(i).data.kjabatan_keterangan);
				*/
				
			/*
				if((/^\d+$/.test(detail_jual_paket_DataStore.getAt(i).data.dpaket_paket))
				   && detail_jual_paket_DataStore.getAt(i).data.dpaket_paket!==undefined
				   && detail_jual_paket_DataStore.getAt(i).data.dpaket_paket!==''
				   && detail_jual_paket_DataStore.getAt(i).data.dpaket_paket!==0){
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_id==undefined){
						dpaket_id.push('');
					}else{
						dpaket_id.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_id);
					}
					
					dpaket_paket.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_paket);
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_karyawan==undefined){
						dpaket_karyawan.push('');
					}else{
						dpaket_karyawan.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_karyawan);
					}
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_jumlah==undefined){
						dpaket_jumlah.push('');
					}else{
						dpaket_jumlah.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_jumlah);
					}
					
					dpaket_kadaluarsa.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_kadaluarsa.format('Y-m-d'));
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_harga==undefined){
						dpaket_harga.push('');
					}else{
						dpaket_harga.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_harga);
					}
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_diskon==undefined){
						dpaket_diskon.push('');
					}else{
						dpaket_diskon.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_diskon);
					}
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_diskon_jenis==undefined){
						dpaket_diskon_jenis.push('');
					}else{
						dpaket_diskon_jenis.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_diskon_jenis);
					}
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_sales==undefined){
						dpaket_sales.push('');
					}else{
						dpaket_sales.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_sales);
					}
				}
				*/
		
				kpendidikan_id.push(pendidikan_DataStore.getAt(i).data.kpendidikan_id);
				kpendidikan_pendidikan.push(pendidikan_DataStore.getAt(i).data.kpendidikan_pendidikan);
				kpendidikan_sekolah.push(pendidikan_DataStore.getAt(i).data.kpendidikan_sekolah);
				kpendidikan_jurusan.push(pendidikan_DataStore.getAt(i).data.kpendidikan_jurusan);
				kpendidikan_thnmasuk.push(pendidikan_DataStore.getAt(i).data.kpendidikan_thnmasuk);
				kpendidikan_thnselesai.push(pendidikan_DataStore.getAt(i).data.kpendidikan_thnselesai);
				kpendidikan_wisuda.push(pendidikan_DataStore.getAt(i).data.kpendidikan_wisuda);
				kpendidikan_keterangan.push(pendidikan_DataStore.getAt(i).data.kpendidikan_keterangan);
				if(i==dcount){
					var encoded_array_kpendidikan_id = Ext.encode(kpendidikan_id);
					var encoded_array_kpendidikan_pendidikan = Ext.encode(kpendidikan_pendidikan);
					var encoded_array_kpendidikan_sekolah = Ext.encode(kpendidikan_sekolah);
					var encoded_array_kpendidikan_jurusan = Ext.encode(kpendidikan_jurusan);
					var encoded_array_kpendidikan_thnmasuk = Ext.encode(kpendidikan_thnmasuk);
					var encoded_array_kpendidikan_thnselesai = Ext.encode(kpendidikan_thnselesai);
					var encoded_array_kpendidikan_wisuda = Ext.encode(kpendidikan_wisuda);
					var encoded_array_kpendidikan_keterangan = Ext.encode(kpendidikan_keterangan);

					Ext.Ajax.request({
						waitMsg: 'Mohon  Tunggu...',
						url: 'index.php?c=c_karyawan&m=detail_pendidikan_insert',
						params:{
							kpendidikan_id			: encoded_array_kpendidikan_id, 
							kpendidikan_master		: eval(get_pk_id()),
							kpendidikan_pendidikan	: encoded_array_kpendidikan_pendidikan,
							kpendidikan_sekolah		: encoded_array_kpendidikan_sekolah,
							kpendidikan_jurusan		: encoded_array_kpendidikan_jurusan,
							kpendidikan_thnmasuk	: encoded_array_kpendidikan_thnmasuk,
							kpendidikan_thnselesai	: encoded_array_kpendidikan_thnselesai,
							kpendidikan_wisuda		: encoded_array_kpendidikan_wisuda,
							kpendidikan_keterangan	: encoded_array_kpendidikan_keterangan,
						},
						timeout: 60000,
						/*
						success: function(response){							
							var result=eval(response.responseText);
							if(result==0){
								Ext.MessageBox.alert(jpaket_post2db+' OK','Data penjualan paket berhasil disimpan');
								jpaket_btn_cancel();
							}else if(result>0){
								jpaket_cetak(result);
								cetak_jpaket=0;
							}else{
								jpaket_btn_cancel();
							}
						},
						failure: function(response){
							var result=response.responseText;
							Ext.MessageBox.show({
							   title: 'Error',
							   msg: 'Could not connect to the database. retry later.',
							   buttons: Ext.MessageBox.OK,
							   animEl: 'database',
							   icon: Ext.MessageBox.ERROR
							});
							jpaket_btn_cancel();
						}
						*/
					});
					
				}
				
			}
		}
		
	}
	//eof
	
	/* Function for Delete Confirm of detail */
	function detail_pendidikan_confirm_delete(){
		// only one record is selected here
		if(detail_pendidikanListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', detail_pendidikan_delete);
		} else if(detail_pendidikanListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', detail_pendidikan_delete);
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Anda belum memilih data yang akan dihapus',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
	//eof
	
	//function for Delete of detail
	function detail_pendidikan_delete(btn){
		if(btn=='yes'){
            var selections = detail_pendidikanListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, record; record = selections[i]; i++){
                if(record.data.kpendidikan_id==''){
                    pendidikan_DataStore.remove(record);
					//load_dstore_jpaket();
                }else if((/^\d+$/.test(record.data.kpendidikan_id))){
                    //Delete dari db.detail_jual_paket
                    Ext.MessageBox.show({
                        title: 'Please wait',
                        msg: 'Loading items...',
                        progressText: 'Initializing...',
                        width:300,
                        wait:true,
                        waitConfig: {interval:200},
                        closable:false
                    });
                    pendidikan_DataStore.remove(record);
                    Ext.Ajax.request({ 
                        waitMsg: 'Please Wait',
                        url: 'index.php?c=c_karyawan&m=get_action', 
                        params: { task: "PDELETE", kpendidikan_id:  record.data.kpendidikan_id }, 
                        success: function(response){
							var result=eval(response.responseText);
							switch(result){
								case 1:
									//load_dstore_jpaket();
                                    Ext.MessageBox.hide();
									//Ext.Msg.alert('OK', 'Penghapusan secara permanen sudah dilakukan.');
									break;
								default:
									Ext.MessageBox.hide();
                                    Ext.MessageBox.show({
                                        title: 'Warning',
                                        msg: 'Could not delete the entire selection',
                                        buttons: Ext.MessageBox.OK,
                                        animEl: 'save',
                                        icon: Ext.MessageBox.WARNING
                                    });
                                    break;
							}
                        },
                        failure: function(response){
                            Ext.MessageBox.hide();
                            var result=response.responseText;
                            Ext.MessageBox.show({
                               title: 'Error',
                               msg: 'Could not connect to the database. retry later.',
                               buttons: Ext.MessageBox.OK,
                               animEl: 'database',
                               icon: Ext.MessageBox.ERROR
                            });	
                        }
                    });
                }
			}
		} 
		
	}
	//eof
	// EOF PENDIDIKAN
	
	// KELUARGA
	// declaration keluarga
	var khubungan_Field= new Ext.form.ComboBox({
		store:new Ext.data.SimpleStore({
			fields:['karyawan_hubungan_value'],
			data:[['Suami'],['Istri'],['Anak'],['Bapak'],['Ibu'],['Saudara']]
		}),
		mode: 'local',
		displayField: 'karyawan_hubungan_value',
		valueField: 'karyawan_hubungan_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true
	});
	
	
	// eof declaration status kekaryawanan
	
	//declaration of detail coloumn model
	detail_keluarga_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			align : 'Left',
			header: 'ID',
			dataIndex: 'kkeluarga_id',
            hidden: true
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Nama' + '</div>',
			dataIndex: 'kkeluarga_nama',
			width: 300,
			sortable: true,
			editor: new Ext.form.TextField({maxLength:250})
			//editor: combo_paket_rawat,
			//renderer: Ext.util.Format.comboRenderer(combo_paket_rawat)
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Hubungan' + '</div>',
			dataIndex: 'kkeluarga_hubungan',
			width: 100,
			sortable: false
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,
			editor: khubungan_Field,
		
			<?php } ?>
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Keterangan' + '</div>',
			dataIndex: 'kkeluarga_keterangan',
			width: 300,
			sortable: true,
			editor: new Ext.form.TextField({maxLength:250})
			//editor: combo_paket_rawat,
			//renderer: Ext.util.Format.comboRenderer(combo_paket_rawat)
		}
		]
	);
	detail_keluarga_ColumnModel.defaultSortable= true;
	//eof
	//declaration of detail list editor grid
	detail_keluargaListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'detail_keluargaListEditorGrid',
		el: 'fp_detail_keluarga',
		title: 'Keluarga',
		height: 200,
		width: 1050,
		autoScroll: true,
		store: keluarga_DataStore, //detail_jual_paket_DataStore, // DataStore
		colModel: detail_keluarga_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 0 0 0',
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
		plugins: [editor_detail_keluarga_karyawan],
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		<?php } ?>
		frame: true,
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:false},
		bbar: new Ext.PagingToolbar({
			pageSize: karyawan_pageS,
			store: keluarga_DataStore,
			displayInfo: true
		})
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
		,
		/* Add Control on ToolBar */
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			ref : '../djpaket_add',
			handler: detail_keluarga_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			ref : '../djpaket_delete',
			disabled: false,
			handler: detail_keluarga_confirm_delete
		}
		]
		<?php } ?>
	});
	//eof
	
	//function of detail add
	function detail_keluarga_add(){
		var edit_detail_keluarga= new detail_keluargaListEditorGrid.store.recordType({
			kkeluarga_id			:'',		
			kkeluarga_nama			:'',
			kkeluarga_hubungan		:'',
			kkeluarga_keterangan	:''
		});
		editor_detail_keluarga_karyawan.stopEditing();
		keluarga_DataStore.insert(0, edit_detail_keluarga);
		detail_keluargaListEditorGrid.getView().refresh();
		detail_keluargaListEditorGrid.getSelectionModel().selectRow(0);
		editor_detail_keluarga_karyawan.startEditing(0);
	}
	
	//function for insert detail
	function detail_keluarga_insert(){
		var	kkeluarga_id			=[];		
		var	kkeluarga_nama			=[];
		var	kkeluarga_hubungan		=[];
		var	kkeluarga_keterangan	=[];

		var dcount = keluarga_DataStore.getCount() - 1;
		
		if(keluarga_DataStore.getCount()>0){
			for(i=0; i<keluarga_DataStore.getCount();i++){
				/*
				kjabatan_id.push(jabatan_DataStore.getAt(i).data.kjabatan_id);
				kjabatan_departemen.push(jabatan_DataStore.getAt(i).data.kjabatan_departemen);
				kjabatan_jabatan.push(jabatan_DataStore.getAt(i).data.kjabatan_jabatan);
				kjabatan_golongan.push(jabatan_DataStore.getAt(i).data.kjabatan_golongan);
				kjabatan_pph21.push(jabatan_DataStore.getAt(i).data.kjabatan_pph21);
				kjabatan_atasan.push(jabatan_DataStore.getAt(i).data.kjabatan_atasan);
				kjabatan_tglawal.push(jabatan_DataStore.getAt(i).data.kjabatan_tglawal);
				kjabatan_tglakhir.push(jabatan_DataStore.getAt(i).data.kjabatan_tglakhir);
				kjabatan_keterangan.push(jabatan_DataStore.getAt(i).data.kjabatan_keterangan);
				*/
				
			/*
				if((/^\d+$/.test(detail_jual_paket_DataStore.getAt(i).data.dpaket_paket))
				   && detail_jual_paket_DataStore.getAt(i).data.dpaket_paket!==undefined
				   && detail_jual_paket_DataStore.getAt(i).data.dpaket_paket!==''
				   && detail_jual_paket_DataStore.getAt(i).data.dpaket_paket!==0){
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_id==undefined){
						dpaket_id.push('');
					}else{
						dpaket_id.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_id);
					}
					
					dpaket_paket.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_paket);
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_karyawan==undefined){
						dpaket_karyawan.push('');
					}else{
						dpaket_karyawan.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_karyawan);
					}
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_jumlah==undefined){
						dpaket_jumlah.push('');
					}else{
						dpaket_jumlah.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_jumlah);
					}
					
					dpaket_kadaluarsa.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_kadaluarsa.format('Y-m-d'));
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_harga==undefined){
						dpaket_harga.push('');
					}else{
						dpaket_harga.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_harga);
					}
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_diskon==undefined){
						dpaket_diskon.push('');
					}else{
						dpaket_diskon.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_diskon);
					}
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_diskon_jenis==undefined){
						dpaket_diskon_jenis.push('');
					}else{
						dpaket_diskon_jenis.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_diskon_jenis);
					}
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_sales==undefined){
						dpaket_sales.push('');
					}else{
						dpaket_sales.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_sales);
					}
				}
				*/

				kkeluarga_id.push(keluarga_DataStore.getAt(i).data.kkeluarga_id);
				kkeluarga_nama.push(keluarga_DataStore.getAt(i).data.kkeluarga_nama);
				kkeluarga_hubungan.push(keluarga_DataStore.getAt(i).data.kkeluarga_hubungan);
				kkeluarga_keterangan.push(keluarga_DataStore.getAt(i).data.kkeluarga_keterangan);
	
				if(i==dcount){
					var encoded_array_kkeluarga_id = Ext.encode(kkeluarga_id);
					var encoded_array_kkeluarga_nama = Ext.encode(kkeluarga_nama);
					var encoded_array_kkeluarga_hubungan = Ext.encode(kkeluarga_hubungan);
					var encoded_array_kkeluarga_keterangan = Ext.encode(kkeluarga_keterangan);


					Ext.Ajax.request({
						waitMsg: 'Mohon  Tunggu...',
						url: 'index.php?c=c_karyawan&m=detail_keluarga_insert',
						params:{
							kkeluarga_id			: encoded_array_kkeluarga_id, 
							kkeluarga_master		: eval(get_pk_id()),
							kkeluarga_nama			: encoded_array_kkeluarga_nama,
							kkeluarga_hubungan		: encoded_array_kkeluarga_hubungan,
							kkeluarga_keterangan	: encoded_array_kkeluarga_keterangan
						},
						timeout: 60000,
						/*
						success: function(response){							
							var result=eval(response.responseText);
							if(result==0){
								Ext.MessageBox.alert(jpaket_post2db+' OK','Data penjualan paket berhasil disimpan');
								jpaket_btn_cancel();
							}else if(result>0){
								jpaket_cetak(result);
								cetak_jpaket=0;
							}else{
								jpaket_btn_cancel();
							}
						},
						failure: function(response){
							var result=response.responseText;
							Ext.MessageBox.show({
							   title: 'Error',
							   msg: 'Could not connect to the database. retry later.',
							   buttons: Ext.MessageBox.OK,
							   animEl: 'database',
							   icon: Ext.MessageBox.ERROR
							});
							jpaket_btn_cancel();
						}
						*/
					});
					
				}
				
			}
		}
		
	}
	//eof
	
	/* Function for Delete Confirm of detail */
	function detail_keluarga_confirm_delete(){
		// only one record is selected here
		if(detail_keluargaListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', detail_keluarga_delete);
		} else if(detail_keluargaListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', detail_keluarga_delete);
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Anda belum memilih data yang akan dihapus',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
	//eof
	
	//function for Delete of detail
	function detail_keluarga_delete(btn){
		if(btn=='yes'){
            var selections = detail_keluargaListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, record; record = selections[i]; i++){
                if(record.data.kkeluarga_id==''){
                    keluarga_DataStore.remove(record);
					//load_dstore_jpaket();
                }else if((/^\d+$/.test(record.data.kkeluarga_id))){
                    //Delete dari db.detail_jual_paket
                    Ext.MessageBox.show({
                        title: 'Please wait',
                        msg: 'Loading items...',
                        progressText: 'Initializing...',
                        width:300,
                        wait:true,
                        waitConfig: {interval:200},
                        closable:false
                    });
                    keluarga_DataStore.remove(record);
                    Ext.Ajax.request({ 
                        waitMsg: 'Please Wait',
                        url: 'index.php?c=c_karyawan&m=get_action', 
                        params: { task: "KDELETE", kkeluarga_id:  record.data.kkeluarga_id }, 
                        success: function(response){
							var result=eval(response.responseText);
							switch(result){
								case 1:
									//load_dstore_jpaket();
                                    Ext.MessageBox.hide();
									//Ext.Msg.alert('OK', 'Penghapusan secara permanen sudah dilakukan.');
									break;
								default:
									Ext.MessageBox.hide();
                                    Ext.MessageBox.show({
                                        title: 'Warning',
                                        msg: 'Could not delete the entire selection',
                                        buttons: Ext.MessageBox.OK,
                                        animEl: 'save',
                                        icon: Ext.MessageBox.WARNING
                                    });
                                    break;
							}
                        },
                        failure: function(response){
                            Ext.MessageBox.hide();
                            var result=response.responseText;
                            Ext.MessageBox.show({
                               title: 'Error',
                               msg: 'Could not connect to the database. retry later.',
                               buttons: Ext.MessageBox.OK,
                               animEl: 'database',
                               icon: Ext.MessageBox.ERROR
                            });	
                        }
                    });
                }
			}
		} 
		
	}
	//eof
	// EOF KELUARGA
	
	// CUTI
	// declaration cuti
	var kcuti_Field= new Ext.form.ComboBox({
		store:new Ext.data.SimpleStore({
			fields:['karyawan_cuti_value'],
			data:[['Umum Tahunan'],['Cuti Hamil'],['Cuti Istimewa'],['Cuti Panjang'],['Unpaid Leave']]
		}),
		mode: 'local',
		displayField: 'karyawan_cuti_value',
		valueField: 'karyawan_cuti_value',
		allowBlank: true,
		anchor: '50%',
		//hidden: true,
		triggerAction: 'all',
		lazyRenderer: true
	});
	
	/* Identify  kcuti_tglawalField Field */
	kcuti_tglawalField= new Ext.form.DateField({
		id: 'kcuti_tglawalField',
		format : 'Y-m-d',
		//vtype: 'daterange',
		value : today,
		endDateField: 'kcuti_tglakhirField',
		width : 100
	});
	
	/* Identify  kcuti_tglakhirField Field */
	kcuti_tglakhirField= new Ext.form.DateField({
		id: 'kcuti_tglakhirField',
		format : 'Y-m-d',
		value : today,
		//vtype: 'daterange',
		startDateField: 'kcuti_tglawalField', 
		width : 100
	});
	
	/* Identify  kcuti_tglakhirField Field */
	kcuti_jmlhariField= new Ext.form.TextField({
		id: 'kcuti_jmlhariField',
		//readOnly: true,
		align: 'Right',
		width : 100
	});
	
	
	// eof declaration status kekaryawanan
	
	//declaration of detail coloumn model
	detail_cuti_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			align : 'Left',
			header: 'ID',
			dataIndex: 'kcuti_id',
            hidden: true
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Jenis Cuti' + '</div>',
			dataIndex: 'kcuti_jenis',
			width: 100,
			//hidden: true,
			sortable: false
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,
			editor: kcuti_Field,
		
			<?php } ?>
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Tgl Awal' + '</div>',
			dataIndex: 'kcuti_tglawal',
			width: 100,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			readOnly: false,
			editor: kcuti_tglawalField
			/*new Ext.form.DateField({
				format: 'd-m-Y',
				disabled :false,
				})
			*/
			//editor: combo_paket_rawat,
			//renderer: Ext.util.Format.comboRenderer(combo_paket_rawat)
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Tgl Akhir' + '</div>',
			dataIndex: 'kcuti_tglakhir',
			width: 100,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			readOnly: false,
			editor: kcuti_tglakhirField
			/*new Ext.form.DateField({
				format: 'd-m-Y',
				disabled :false,
				})
			*/
			//editor: combo_paket_rawat,
			//renderer: Ext.util.Format.comboRenderer(combo_paket_rawat)
		},
		{
			align: 'Right',
			header: '<div align="center">' + 'Jml Hari' + '</div>',
			dataIndex: 'kcuti_jmlhari',
			width: 70,
			sortable: false,
			readOnly: true,
			editor: kcuti_jmlhariField
			//new Ext.form.TextField({maxLength:5})

		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Tgl Pengajuan' + '</div>',
			dataIndex: 'kcuti_tglpengajuan',
			width: 100,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			readOnly: false,
			editor: new Ext.form.DateField({
				format: 'd-m-Y',
				disabled :false,
				})
			//editor: combo_paket_rawat,
			//renderer: Ext.util.Format.comboRenderer(combo_paket_rawat)
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Keterangan' + '</div>',
			dataIndex: 'kcuti_keterangan',
			width: 300,
			sortable: true,
			editor: new Ext.form.TextField({maxLength:250})
			//editor: combo_paket_rawat,
			//renderer: Ext.util.Format.comboRenderer(combo_paket_rawat)
		}
		
		]
	);
	detail_cuti_ColumnModel.defaultSortable= true;
	//eof
	//declaration of detail list editor grid
	detail_cutiListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'detail_cutiListEditorGrid',
		el: 'fp_detail_cuti',
		title: 'Cuti',
		height: 200,
		width: 1050,
		autoScroll: true,
		store: cuti_DataStore, //detail_jual_paket_DataStore, // DataStore
		colModel: detail_cuti_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 0 0 0',
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
		plugins: [editor_detail_cuti_karyawan],
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		<?php } ?>
		frame: true,
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:false},
		bbar: new Ext.PagingToolbar({
			pageSize: karyawan_pageS,
			store: cuti_DataStore,
			displayInfo: true
		})
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
		,
		/* Add Control on ToolBar */
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			ref : '../djpaket_add',
			handler: detail_cuti_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			ref : '../djpaket_delete',
			disabled: false,
			handler: detail_cuti_confirm_delete
		}
		]
		<?php } ?>
	});
	//eof
	
	//function of detail add
	function detail_cuti_add(){
		var edit_detail_cuti= new detail_cutiListEditorGrid.store.recordType({
			kcuti_id			:'',		
			kcuti_jenis			:'',
			kcuti_tglawal		:today.dateFormat('Y-m-d'),
			kcuti_tglakhir		:today.dateFormat('Y-m-d'),
			kcuti_jmlhari		:null,
			kcuti_tglpengajuan	:null,
			kcuti_keterangan	:''
			
		});
		editor_detail_cuti_karyawan.stopEditing();
		cuti_DataStore.insert(0, edit_detail_cuti);
		detail_cutiListEditorGrid.getView().refresh();
		detail_cutiListEditorGrid.getSelectionModel().selectRow(0);
		editor_detail_cuti_karyawan.startEditing(0);
	}
	
	//function for insert detail
	function detail_cuti_insert(){
		var	kcuti_id			=[];		
		var	kcuti_jenis			=[];
		var	kcuti_tglawal		=[];
		var	kcuti_tglakhir		=[];
		var	kcuti_jmlhari		=[];
		var	kcuti_tglpengajuan	=[];
		var	kcuti_keterangan	=[];

		var dcount = cuti_DataStore.getCount() - 1;
		
		if(cuti_DataStore.getCount()>0){
			for(i=0; i<cuti_DataStore.getCount();i++){
				/*
				kjabatan_id.push(jabatan_DataStore.getAt(i).data.kjabatan_id);
				kjabatan_departemen.push(jabatan_DataStore.getAt(i).data.kjabatan_departemen);
				kjabatan_jabatan.push(jabatan_DataStore.getAt(i).data.kjabatan_jabatan);
				kjabatan_golongan.push(jabatan_DataStore.getAt(i).data.kjabatan_golongan);
				kjabatan_pph21.push(jabatan_DataStore.getAt(i).data.kjabatan_pph21);
				kjabatan_atasan.push(jabatan_DataStore.getAt(i).data.kjabatan_atasan);
				kjabatan_tglawal.push(jabatan_DataStore.getAt(i).data.kjabatan_tglawal);
				kjabatan_tglakhir.push(jabatan_DataStore.getAt(i).data.kjabatan_tglakhir);
				kjabatan_keterangan.push(jabatan_DataStore.getAt(i).data.kjabatan_keterangan);
				*/
				
			/*
				if((/^\d+$/.test(detail_jual_paket_DataStore.getAt(i).data.dpaket_paket))
				   && detail_jual_paket_DataStore.getAt(i).data.dpaket_paket!==undefined
				   && detail_jual_paket_DataStore.getAt(i).data.dpaket_paket!==''
				   && detail_jual_paket_DataStore.getAt(i).data.dpaket_paket!==0){
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_id==undefined){
						dpaket_id.push('');
					}else{
						dpaket_id.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_id);
					}
					
					dpaket_paket.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_paket);
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_karyawan==undefined){
						dpaket_karyawan.push('');
					}else{
						dpaket_karyawan.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_karyawan);
					}
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_jumlah==undefined){
						dpaket_jumlah.push('');
					}else{
						dpaket_jumlah.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_jumlah);
					}
					
					dpaket_kadaluarsa.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_kadaluarsa.format('Y-m-d'));
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_harga==undefined){
						dpaket_harga.push('');
					}else{
						dpaket_harga.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_harga);
					}
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_diskon==undefined){
						dpaket_diskon.push('');
					}else{
						dpaket_diskon.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_diskon);
					}
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_diskon_jenis==undefined){
						dpaket_diskon_jenis.push('');
					}else{
						dpaket_diskon_jenis.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_diskon_jenis);
					}
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_sales==undefined){
						dpaket_sales.push('');
					}else{
						dpaket_sales.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_sales);
					}
				}
				*/


				kcuti_id.push(cuti_DataStore.getAt(i).data.kcuti_id);
				kcuti_jenis.push(cuti_DataStore.getAt(i).data.kcuti_jenis);
				kcuti_tglawal.push(cuti_DataStore.getAt(i).data.kcuti_tglawal);
				kcuti_tglakhir.push(cuti_DataStore.getAt(i).data.kcuti_tglakhir);
				kcuti_jmlhari.push(cuti_DataStore.getAt(i).data.kcuti_jmlhari);
				kcuti_tglpengajuan.push(cuti_DataStore.getAt(i).data.kcuti_tglpengajuan);
				kcuti_keterangan.push(cuti_DataStore.getAt(i).data.kcuti_keterangan);
	
				if(i==dcount){
					var encoded_array_kcuti_id = Ext.encode(kcuti_id);
					var encoded_array_kcuti_jenis = Ext.encode(kcuti_jenis);
					var encoded_array_kcuti_tglawal = Ext.encode(kcuti_tglawal);
					var encoded_array_kcuti_tglakhir = Ext.encode(kcuti_tglakhir);
					var encoded_array_kcuti_jmlhari = Ext.encode(kcuti_jmlhari);
					var encoded_array_kcuti_tglpengajuan = Ext.encode(kcuti_tglpengajuan);
					var encoded_array_kcuti_keterangan = Ext.encode(kcuti_keterangan);


					Ext.Ajax.request({
						waitMsg: 'Mohon  Tunggu...',
						url: 'index.php?c=c_karyawan&m=detail_cuti_insert',
						params:{
							kcuti_id			: encoded_array_kcuti_id, 
							kcuti_master		: eval(get_pk_id()),
							kcuti_jenis			: encoded_array_kcuti_jenis,
							kcuti_tglawal		: encoded_array_kcuti_tglawal,
							kcuti_tglakhir		: encoded_array_kcuti_tglakhir,
							kcuti_jmlhari		: encoded_array_kcuti_jmlhari,
							kcuti_tglpengajuan	: encoded_array_kcuti_tglpengajuan,
							kcuti_keterangan	: encoded_array_kcuti_keterangan
						},
						timeout: 60000,
						/*
						success: function(response){							
							var result=eval(response.responseText);
							if(result==0){
								Ext.MessageBox.alert(jpaket_post2db+' OK','Data penjualan paket berhasil disimpan');
								jpaket_btn_cancel();
							}else if(result>0){
								jpaket_cetak(result);
								cetak_jpaket=0;
							}else{
								jpaket_btn_cancel();
							}
						},
						failure: function(response){
							var result=response.responseText;
							Ext.MessageBox.show({
							   title: 'Error',
							   msg: 'Could not connect to the database. retry later.',
							   buttons: Ext.MessageBox.OK,
							   animEl: 'database',
							   icon: Ext.MessageBox.ERROR
							});
							jpaket_btn_cancel();
						}
						*/
					});
					
				}
				
			}
		}
		
	}
	//eof
	
	/* Function for Delete Confirm of detail */
	function detail_cuti_confirm_delete(){
		// only one record is selected here
		if(detail_cutiListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', detail_cuti_delete);
		} else if(detail_cutiListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', detail_cuti_delete);
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Anda belum memilih data yang akan dihapus',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
	//eof
	
	//function for Delete of detail
	function detail_cuti_delete(btn){
		if(btn=='yes'){
            var selections = detail_cutiListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, record; record = selections[i]; i++){
                if(record.data.kcuti_id==''){
                    cuti_DataStore.remove(record);
					//load_dstore_jpaket();
                }else if((/^\d+$/.test(record.data.kcuti_id))){
                    //Delete dari db.detail_jual_paket
                    Ext.MessageBox.show({
                        title: 'Please wait',
                        msg: 'Loading items...',
                        progressText: 'Initializing...',
                        width:300,
                        wait:true,
                        waitConfig: {interval:200},
                        closable:false
                    });
                    cuti_DataStore.remove(record);
                    Ext.Ajax.request({ 
                        waitMsg: 'Please Wait',
                        url: 'index.php?c=c_karyawan&m=get_action', 
                        params: { task: "CDELETE", kcuti_id:  record.data.kcuti_id }, 
                        success: function(response){
							var result=eval(response.responseText);
							switch(result){
								case 1:
									//load_dstore_jpaket();
                                    Ext.MessageBox.hide();
									//Ext.Msg.alert('OK', 'Penghapusan secara permanen sudah dilakukan.');
									break;
								default:
									Ext.MessageBox.hide();
                                    Ext.MessageBox.show({
                                        title: 'Warning',
                                        msg: 'Could not delete the entire selection',
                                        buttons: Ext.MessageBox.OK,
                                        animEl: 'save',
                                        icon: Ext.MessageBox.WARNING
                                    });
                                    break;
							}
                        },
                        failure: function(response){
                            Ext.MessageBox.hide();
                            var result=response.responseText;
                            Ext.MessageBox.show({
                               title: 'Error',
                               msg: 'Could not connect to the database. retry later.',
                               buttons: Ext.MessageBox.OK,
                               animEl: 'database',
                               icon: Ext.MessageBox.ERROR
                            });	
                        }
                    });
                }
			}
		} 
		
	}
	//eof
	// EOF CUTI
	
	// GANTIOFF
	// declaration gantiooff
	var kgantioff_Field= new Ext.form.ComboBox({
		store:new Ext.data.SimpleStore({
			fields:['karyawan_gantioff_value'],
			data:[['Ganti Off']]
		}),
		mode: 'local',
		displayField: 'karyawan_gantioff_value',
		valueField: 'karyawan_gantioff_value',
		allowBlank: true,
		hidden: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true
	});
	
	
	// eof declaration status kekaryawanan
	
	//declaration of detail coloumn model
	detail_gantioff_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			align : 'Left',
			header: 'ID',
			dataIndex: 'kgantioff_id',
            hidden: true
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Jenis Cuti' + '</div>',
			dataIndex: 'kgantioff_jenis',
			width: 100,
			hidden: true,
			sortable: false
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,
			editor: kgantioff_Field,
		
			<?php } ?>
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Tgl Awal' + '</div>',
			dataIndex: 'kgantioff_tglawal',
			width: 100,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			readOnly: false,
			editor: new Ext.form.DateField({
				format: 'd-m-Y',
				disabled :false,
				})
			//editor: combo_paket_rawat,
			//renderer: Ext.util.Format.comboRenderer(combo_paket_rawat)
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Tgl Akhir' + '</div>',
			dataIndex: 'kgantioff_tglakhir',
			width: 100,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			readOnly: false,
			editor: new Ext.form.DateField({
				format: 'd-m-Y',
				disabled :false,
				})
			//editor: combo_paket_rawat,
			//renderer: Ext.util.Format.comboRenderer(combo_paket_rawat)
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Jml Hari' + '</div>',
			dataIndex: 'kgantioff_jmlhari',
			width: 100,
			sortable: false,
			readOnly: true,
			editor: new Ext.form.TextField({maxLength:5})

		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Tgl Diganti Awal' + '</div>',
			dataIndex: 'kgantioff_tglgantiawal',
			width: 100,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			readOnly: false,
			editor: new Ext.form.DateField({
				format: 'd-m-Y',
				disabled :false,
				})
			//editor: combo_paket_rawat,
			//renderer: Ext.util.Format.comboRenderer(combo_paket_rawat)
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Tgl Diganti Akhir' + '</div>',
			dataIndex: 'kgantioff_tglgantiakhir',
			width: 100,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			readOnly: false,
			editor: new Ext.form.DateField({
				format: 'd-m-Y',
				disabled :false,
				})
			//editor: combo_paket_rawat,
			//renderer: Ext.util.Format.comboRenderer(combo_paket_rawat)
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Tgl Pengajuan' + '</div>',
			dataIndex: 'kgantioff_tglpengajuan',
			width: 100,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			readOnly: false,
			editor: new Ext.form.DateField({
				format: 'd-m-Y',
				disabled :false,
				})
			//editor: combo_paket_rawat,
			//renderer: Ext.util.Format.comboRenderer(combo_paket_rawat)
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Keterangan' + '</div>',
			dataIndex: 'kgantioff_keterangan',
			width: 300,
			sortable: true,
			editor: new Ext.form.TextField({maxLength:250})
			//editor: combo_paket_rawat,
			//renderer: Ext.util.Format.comboRenderer(combo_paket_rawat)
		}
		
		]
	);
	detail_gantioff_ColumnModel.defaultSortable= true;
	//eof
	//declaration of detail list editor grid
	detail_gantioffListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'detail_gantioffListEditorGrid',
		el: 'fp_detail_gantioff',
		title: 'Ganti Off',
		height: 200,
		width: 1050,
		autoScroll: true,
		store: gantioff_DataStore, //detail_jual_paket_DataStore, // DataStore
		colModel: detail_gantioff_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 0 0 0',
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
		plugins: [editor_detail_gantioff_karyawan],
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		<?php } ?>
		frame: true,
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:false},
		bbar: new Ext.PagingToolbar({
			pageSize: karyawan_pageS,
			store: gantioff_DataStore,
			displayInfo: true
		})
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
		,
		/* Add Control on ToolBar */
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			ref : '../djpaket_add',
			handler: detail_gantioff_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			ref : '../djpaket_delete',
			disabled: false,
			handler: detail_gantioff_confirm_delete
		}
		]
		<?php } ?>
	});
	//eof
	
	//function of detail add
	function detail_gantioff_add(){
		var edit_detail_gantioff= new detail_gantioffListEditorGrid.store.recordType({
			kgantioff_id			:'',		
			kgantioff_jenis			:'',
			kgantioff_tglawal		:today.dateFormat('Y-m-d'),
			kgantioff_tglakhir		:today.dateFormat('Y-m-d'),
			kgantioff_jmlhari		:null,
			kgantioff_tglgantiawal	:today.dateFormat('Y-m-d'),
			kgantioff_tglgantiakhir	:today.dateFormat('Y-m-d'),
			kgantioff_tglpengajuan	:today.dateFormat('Y-m-d'),
			kgantioff_keterangan	:''
			
		});
		editor_detail_gantioff_karyawan.stopEditing();
		gantioff_DataStore.insert(0, edit_detail_gantioff);
		detail_gantioffListEditorGrid.getView().refresh();
		detail_gantioffListEditorGrid.getSelectionModel().selectRow(0);
		editor_detail_gantioff_karyawan.startEditing(0);
	}
	
	//function for insert detail
	function detail_gantioff_insert(){
		var	kgantioff_id			=[];		
		var	kgantioff_jenis			=[];
		var	kgantioff_tglawal		=[];
		var	kgantioff_tglakhir		=[];
		var	kgantioff_jmlhari		=[];
		var	kgantioff_tglgantiawal	=[];
		var	kgantioff_tglgantiakhir	=[];
		var	kgantioff_tglpengajuan	=[];
		var	kgantioff_keterangan	=[];

		var dcount = gantioff_DataStore.getCount() - 1;
		
		if(gantioff_DataStore.getCount()>0){
			for(i=0; i<gantioff_DataStore.getCount();i++){
				/*
				kjabatan_id.push(jabatan_DataStore.getAt(i).data.kjabatan_id);
				kjabatan_departemen.push(jabatan_DataStore.getAt(i).data.kjabatan_departemen);
				kjabatan_jabatan.push(jabatan_DataStore.getAt(i).data.kjabatan_jabatan);
				kjabatan_golongan.push(jabatan_DataStore.getAt(i).data.kjabatan_golongan);
				kjabatan_pph21.push(jabatan_DataStore.getAt(i).data.kjabatan_pph21);
				kjabatan_atasan.push(jabatan_DataStore.getAt(i).data.kjabatan_atasan);
				kjabatan_tglawal.push(jabatan_DataStore.getAt(i).data.kjabatan_tglawal);
				kjabatan_tglakhir.push(jabatan_DataStore.getAt(i).data.kjabatan_tglakhir);
				kjabatan_keterangan.push(jabatan_DataStore.getAt(i).data.kjabatan_keterangan);
				*/
				
			/*
				if((/^\d+$/.test(detail_jual_paket_DataStore.getAt(i).data.dpaket_paket))
				   && detail_jual_paket_DataStore.getAt(i).data.dpaket_paket!==undefined
				   && detail_jual_paket_DataStore.getAt(i).data.dpaket_paket!==''
				   && detail_jual_paket_DataStore.getAt(i).data.dpaket_paket!==0){
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_id==undefined){
						dpaket_id.push('');
					}else{
						dpaket_id.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_id);
					}
					
					dpaket_paket.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_paket);
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_karyawan==undefined){
						dpaket_karyawan.push('');
					}else{
						dpaket_karyawan.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_karyawan);
					}
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_jumlah==undefined){
						dpaket_jumlah.push('');
					}else{
						dpaket_jumlah.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_jumlah);
					}
					
					dpaket_kadaluarsa.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_kadaluarsa.format('Y-m-d'));
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_harga==undefined){
						dpaket_harga.push('');
					}else{
						dpaket_harga.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_harga);
					}
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_diskon==undefined){
						dpaket_diskon.push('');
					}else{
						dpaket_diskon.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_diskon);
					}
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_diskon_jenis==undefined){
						dpaket_diskon_jenis.push('');
					}else{
						dpaket_diskon_jenis.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_diskon_jenis);
					}
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_sales==undefined){
						dpaket_sales.push('');
					}else{
						dpaket_sales.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_sales);
					}
				}
				*/


				kgantioff_id.push(gantioff_DataStore.getAt(i).data.kgantioff_id);
				kgantioff_jenis.push(gantioff_DataStore.getAt(i).data.kgantioff_jenis);
				kgantioff_tglawal.push(gantioff_DataStore.getAt(i).data.kgantioff_tglawal);
				kgantioff_tglakhir.push(gantioff_DataStore.getAt(i).data.kgantioff_tglakhir);
				kgantioff_jmlhari.push(gantioff_DataStore.getAt(i).data.kgantioff_jmlhari);
				kgantioff_tglgantiawal.push(gantioff_DataStore.getAt(i).data.kgantioff_tglgantiawal);
				kgantioff_tglgantiakhir.push(gantioff_DataStore.getAt(i).data.kgantioff_tglgantiakhir);
				kgantioff_tglpengajuan.push(gantioff_DataStore.getAt(i).data.kgantioff_tglpengajuan);
				kgantioff_keterangan.push(gantioff_DataStore.getAt(i).data.kgantioff_keterangan);
	
				if(i==dcount){
					var encoded_array_kgantioff_id = Ext.encode(kgantioff_id);
					var encoded_array_kgantioff_jenis = Ext.encode(kgantioff_jenis);
					var encoded_array_kgantioff_tglawal = Ext.encode(kgantioff_tglawal);
					var encoded_array_kgantioff_tglakhir = Ext.encode(kgantioff_tglakhir);
					var encoded_array_kgantioff_jmlhari = Ext.encode(kgantioff_jmlhari);
					var encoded_array_kgantioff_tglgantiawal = Ext.encode(kgantioff_tglgantiawal);
					var encoded_array_kgantioff_tglgantiakhir = Ext.encode(kgantioff_tglgantiakhir);
					var encoded_array_kgantioff_tglpengajuan = Ext.encode(kgantioff_tglpengajuan);
					var encoded_array_kgantioff_keterangan = Ext.encode(kgantioff_keterangan);


					Ext.Ajax.request({
						waitMsg: 'Mohon  Tunggu...',
						url: 'index.php?c=c_karyawan&m=detail_gantioff_insert',
						params:{
							kgantioff_id			: encoded_array_kgantioff_id, 
							kgantioff_master		: eval(get_pk_id()),
							kgantioff_jenis			: encoded_array_kgantioff_jenis,
							kgantioff_tglawal		: encoded_array_kgantioff_tglawal,
							kgantioff_tglakhir		: encoded_array_kgantioff_tglakhir,
							kgantioff_jmlhari		: encoded_array_kgantioff_jmlhari,
							kgantioff_tglgantiawal	: encoded_array_kgantioff_tglgantiawal,
							kgantioff_tglgantiakhir	: encoded_array_kgantioff_tglgantiakhir,
							kgantioff_tglpengajuan	: encoded_array_kgantioff_tglpengajuan,
							kgantioff_keterangan	: encoded_array_kgantioff_keterangan
						},
						timeout: 60000,
						/*
						success: function(response){							
							var result=eval(response.responseText);
							if(result==0){
								Ext.MessageBox.alert(jpaket_post2db+' OK','Data penjualan paket berhasil disimpan');
								jpaket_btn_cancel();
							}else if(result>0){
								jpaket_cetak(result);
								cetak_jpaket=0;
							}else{
								jpaket_btn_cancel();
							}
						},
						failure: function(response){
							var result=response.responseText;
							Ext.MessageBox.show({
							   title: 'Error',
							   msg: 'Could not connect to the database. retry later.',
							   buttons: Ext.MessageBox.OK,
							   animEl: 'database',
							   icon: Ext.MessageBox.ERROR
							});
							jpaket_btn_cancel();
						}
						*/
					});
					
				}
				
			}
		}
		
	}
	//eof
	
	/* Function for Delete Confirm of detail */
	function detail_gantioff_confirm_delete(){
		// only one record is selected here
		if(detail_gantioffListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', detail_gantioff_delete);
		} else if(detail_gantioffListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', detail_gantioff_delete);
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Anda belum memilih data yang akan dihapus',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
	//eof
	
	//function for Delete of detail
	function detail_gantioff_delete(btn){
		if(btn=='yes'){
            var selections = detail_gantioffListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, record; record = selections[i]; i++){
                if(record.data.kgantioff_id==''){
                    gantioff_DataStore.remove(record);
					//load_dstore_jpaket();
                }else if((/^\d+$/.test(record.data.kgantioff_id))){
                    //Delete dari db.detail_jual_paket
                    Ext.MessageBox.show({
                        title: 'Please wait',
                        msg: 'Loading items...',
                        progressText: 'Initializing...',
                        width:300,
                        wait:true,
                        waitConfig: {interval:200},
                        closable:false
                    });
                    gantioff_DataStore.remove(record);
                    Ext.Ajax.request({ 
                        waitMsg: 'Please Wait',
                        url: 'index.php?c=c_karyawan&m=get_action', 
                        params: { task: "GDELETE", kgantioff_id:  record.data.kgantioff_id }, 
                        success: function(response){
							var result=eval(response.responseText);
							switch(result){
								case 1:
									//load_dstore_jpaket();
                                    Ext.MessageBox.hide();
									//Ext.Msg.alert('OK', 'Penghapusan secara permanen sudah dilakukan.');
									break;
								default:
									Ext.MessageBox.hide();
                                    Ext.MessageBox.show({
                                        title: 'Warning',
                                        msg: 'Could not delete the entire selection',
                                        buttons: Ext.MessageBox.OK,
                                        animEl: 'save',
                                        icon: Ext.MessageBox.WARNING
                                    });
                                    break;
							}
                        },
                        failure: function(response){
                            Ext.MessageBox.hide();
                            var result=response.responseText;
                            Ext.MessageBox.show({
                               title: 'Error',
                               msg: 'Could not connect to the database. retry later.',
                               buttons: Ext.MessageBox.OK,
                               animEl: 'database',
                               icon: Ext.MessageBox.ERROR
                            });	
                        }
                    });
                }
			}
		} 
		
	}
	//eof
	// EOF GANTIOFF
	
	// MEDICAL
	// declaration medical
	var kmedicaltujuan_Field= new Ext.form.ComboBox({
		store:new Ext.data.SimpleStore({
			fields:['kmedicaltujuan_value'],
			data:[['Diri Sendiri'],['Istri'],['Anak']]
		}),
		mode: 'local',
		displayField: 'kmedicaltujuan_value',
		valueField: 'kmedicaltujuan_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true
	});
	var kmedicalrawat_Field= new Ext.form.ComboBox({
		store:new Ext.data.SimpleStore({
			fields:['kmedicalrawat_value'],
			data:[['Rawat Jalan'],['Rawat Inap']]
		}),
		mode: 'local',
		displayField: 'kmedicalrawat_value',
		valueField: 'kmedicalrawat_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true
	});
	var kmedicaljenis_Field= new Ext.form.ComboBox({
		store:new Ext.data.SimpleStore({
			fields:['kmedicaljenis_value'],
			data:[['Umum'],['Spesialis'],['Frame'],['Lensa'],['Lain-lain']]
		}),
		mode: 'local',
		displayField: 'kmedicaljenis_value',
		valueField: 'kmedicaljenis_value',
		allowBlank: true,
		anchor: '50%',
		triggerAction: 'all',
		lazyRenderer: true
	});
	
	
	// eof declaration status kekaryawanan
	
	//declaration of detail coloumn model
	detail_medical_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			align : 'Left',
			header: 'ID',
			dataIndex: 'kmedical_id',
            hidden: true
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Tujuan Klaim' + '</div>',
			dataIndex: 'kmedical_tujuan',
			width: 100,
			sortable: false
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,
			editor: kmedicaltujuan_Field,
		
			<?php } ?>
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Jenis Rawat' + '</div>',
			dataIndex: 'kmedical_jenis_rawat',
			width: 100,
			sortable: false
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,
			editor: kmedicalrawat_Field,
		
			<?php } ?>
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Jenis Klaim' + '</div>',
			dataIndex: 'kmedical_jenis_klaim',
			width: 100,
			sortable: false
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			,
			editor: kmedicaljenis_Field,
		
			<?php } ?>
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Jml Kuitansi' + '</div>',
			dataIndex: 'kmedical_jumlah',
			width: 50,
			sortable: true,
			editor: new Ext.form.TextField({maxLength:10})
			//editor: combo_paket_rawat,
			//renderer: Ext.util.Format.comboRenderer(combo_paket_rawat)
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Total (Rp)' + '</div>',
			dataIndex: 'kmedical_total',
			width: 100,
			sortable: true,
			valueRenderer: 'numberToCurrency',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			editor: new Ext.form.NumberField({maxLength:10})
			
			//editor: combo_paket_rawat,
			//renderer: Ext.util.Format.comboRenderer(combo_paket_rawat)
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Tgl Kuitansi' + '</div>',
			dataIndex: 'kmedical_tglkuitansi',
			width: 100,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			readOnly: false,
			editor: new Ext.form.DateField({
				format: 'd-m-Y',
				disabled :false,
				})
			//editor: combo_paket_rawat,
			//renderer: Ext.util.Format.comboRenderer(combo_paket_rawat)
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Tgl Pengajuan' + '</div>',
			dataIndex: 'kmedical_tglpengajuan',
			width: 100,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			readOnly: false,
			editor: new Ext.form.DateField({
				format: 'd-m-Y',
				disabled :false,
				})
			//editor: combo_paket_rawat,
			//renderer: Ext.util.Format.comboRenderer(combo_paket_rawat)
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Keterangan' + '</div>',
			dataIndex: 'kmedical_keterangan',
			width: 500,
			sortable: true,
			editor: new Ext.form.TextField({maxLength:250})
			//editor: combo_paket_rawat,
			//renderer: Ext.util.Format.comboRenderer(combo_paket_rawat)
		}
		
		]
	);
	detail_medical_ColumnModel.defaultSortable= true;
	//eof
	//declaration of detail list editor grid
	detail_medicalListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'detail_medicalListEditorGrid',
		el: 'fp_detail_medical',
		title: 'Medical Reimbursement',
		height: 200,
		width: 1050,
		autoScroll: true,
		store: medical_DataStore, //detail_jual_paket_DataStore, // DataStore
		colModel: detail_medical_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 0 0 0',
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
		plugins: [editor_detail_medical_karyawan],
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		<?php } ?>
		frame: true,
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:false},
		bbar: new Ext.PagingToolbar({
			pageSize: karyawan_pageS,
			store: medical_DataStore,
			displayInfo: true
		})
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
		,
		/* Add Control on ToolBar */
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			ref : '../djpaket_add',
			handler: detail_medical_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			ref : '../djpaket_delete',
			disabled: false,
			handler: detail_medical_confirm_delete
		}
		]
		<?php } ?>
	});
	//eof
	
	//function of detail add
	function detail_medical_add(){
		var edit_detail_medical= new detail_medicalListEditorGrid.store.recordType({
			kmedical_id				:'',		
			kmedical_tujuan			:'',
			kmedical_jenis_rawat	:'',
			kmedical_jenis_klaim	:'',
			kmedical_jumlah			:'',
			kmedical_total			:'',
			kmedical_tglkuitansi	:today.dateFormat('Y-m-d'),
			kmedical_tglpengajuan	:today.dateFormat('Y-m-d'),
			kmedical_keterangan		:''
			
		});
		editor_detail_medical_karyawan.stopEditing();
		medical_DataStore.insert(0, edit_detail_medical);
		detail_medicalListEditorGrid.getView().refresh();
		detail_medicalListEditorGrid.getSelectionModel().selectRow(0);
		editor_detail_medical_karyawan.startEditing(0);
	}
	
	//function for insert detail
	function detail_medical_insert(){
		var	kmedical_id				=[];		
		var	kmedical_tujuan			=[];
		var	kmedical_jenis_rawat	=[];
		var	kmedical_jenis_klaim	=[];
		var	kmedical_jumlah			=[];
		var	kmedical_total			=[];
		var	kmedical_tglkuitansi	=[];
		var	kmedical_tglpengajuan	=[];
		var	kmedical_keterangan		=[];

		var dcount = medical_DataStore.getCount() - 1;
		
		if(medical_DataStore.getCount()>0){
			for(i=0; i<medical_DataStore.getCount();i++){
				/*
				kjabatan_id.push(jabatan_DataStore.getAt(i).data.kjabatan_id);
				kjabatan_departemen.push(jabatan_DataStore.getAt(i).data.kjabatan_departemen);
				kjabatan_jabatan.push(jabatan_DataStore.getAt(i).data.kjabatan_jabatan);
				kjabatan_golongan.push(jabatan_DataStore.getAt(i).data.kjabatan_golongan);
				kjabatan_pph21.push(jabatan_DataStore.getAt(i).data.kjabatan_pph21);
				kjabatan_atasan.push(jabatan_DataStore.getAt(i).data.kjabatan_atasan);
				kjabatan_tglawal.push(jabatan_DataStore.getAt(i).data.kjabatan_tglawal);
				kjabatan_tglakhir.push(jabatan_DataStore.getAt(i).data.kjabatan_tglakhir);
				kjabatan_keterangan.push(jabatan_DataStore.getAt(i).data.kjabatan_keterangan);
				*/
				
			/*
				if((/^\d+$/.test(detail_jual_paket_DataStore.getAt(i).data.dpaket_paket))
				   && detail_jual_paket_DataStore.getAt(i).data.dpaket_paket!==undefined
				   && detail_jual_paket_DataStore.getAt(i).data.dpaket_paket!==''
				   && detail_jual_paket_DataStore.getAt(i).data.dpaket_paket!==0){
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_id==undefined){
						dpaket_id.push('');
					}else{
						dpaket_id.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_id);
					}
					
					dpaket_paket.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_paket);
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_karyawan==undefined){
						dpaket_karyawan.push('');
					}else{
						dpaket_karyawan.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_karyawan);
					}
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_jumlah==undefined){
						dpaket_jumlah.push('');
					}else{
						dpaket_jumlah.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_jumlah);
					}
					
					dpaket_kadaluarsa.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_kadaluarsa.format('Y-m-d'));
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_harga==undefined){
						dpaket_harga.push('');
					}else{
						dpaket_harga.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_harga);
					}
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_diskon==undefined){
						dpaket_diskon.push('');
					}else{
						dpaket_diskon.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_diskon);
					}
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_diskon_jenis==undefined){
						dpaket_diskon_jenis.push('');
					}else{
						dpaket_diskon_jenis.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_diskon_jenis);
					}
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_sales==undefined){
						dpaket_sales.push('');
					}else{
						dpaket_sales.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_sales);
					}
				}
				*/
				kmedical_id.push(medical_DataStore.getAt(i).data.kmedical_id);
				kmedical_tujuan.push(medical_DataStore.getAt(i).data.kmedical_tujuan);
				kmedical_jenis_rawat.push(medical_DataStore.getAt(i).data.kmedical_jenis_rawat);
				kmedical_jenis_klaim.push(medical_DataStore.getAt(i).data.kmedical_jenis_klaim);
				kmedical_jumlah.push(medical_DataStore.getAt(i).data.kmedical_jumlah);
				kmedical_total.push(medical_DataStore.getAt(i).data.kmedical_total);
				kmedical_tglkuitansi.push(medical_DataStore.getAt(i).data.kmedical_tglkuitansi);
				kmedical_tglpengajuan.push(medical_DataStore.getAt(i).data.kmedical_tglpengajuan);
				kmedical_keterangan.push(medical_DataStore.getAt(i).data.kmedical_keterangan);
	
				if(i==dcount){
					var encoded_array_kmedical_id = Ext.encode(kmedical_id);
					var encoded_array_kmedical_tujuan = Ext.encode(kmedical_tujuan);
					var encoded_array_kmedical_jenis_rawat = Ext.encode(kmedical_jenis_rawat);
					var encoded_array_kmedical_jenis_klaim = Ext.encode(kmedical_jenis_klaim);
					var encoded_array_kmedical_jumlah = Ext.encode(kmedical_jumlah);
					var encoded_array_kmedical_total = Ext.encode(kmedical_total);
					var encoded_array_kmedical_tglkuitansi = Ext.encode(kmedical_tglkuitansi);
					var encoded_array_kmedical_tglpengajuan = Ext.encode(kmedical_tglpengajuan);
					var encoded_array_kmedical_keterangan = Ext.encode(kmedical_keterangan);


					Ext.Ajax.request({
						waitMsg: 'Mohon  Tunggu...',
						url: 'index.php?c=c_karyawan&m=detail_medical_insert',
						params:{
							kmedical_id				: encoded_array_kmedical_id, 
							kmedical_master			: eval(get_pk_id()),
							kmedical_tujuan			: encoded_array_kmedical_tujuan,
							kmedical_jenis_rawat	: encoded_array_kmedical_jenis_rawat,
							kmedical_jenis_klaim	: encoded_array_kmedical_jenis_klaim,
							kmedical_jumlah			: encoded_array_kmedical_jumlah,
							kmedical_total			: encoded_array_kmedical_total,
							kmedical_tglkuitansi	: encoded_array_kmedical_tglkuitansi,
							kmedical_tglpengajuan	: encoded_array_kmedical_tglpengajuan,
							kmedical_keterangan		: encoded_array_kmedical_keterangan
						},
						timeout: 60000,
						/*
						success: function(response){							
							var result=eval(response.responseText);
							if(result==0){
								Ext.MessageBox.alert(jpaket_post2db+' OK','Data penjualan paket berhasil disimpan');
								jpaket_btn_cancel();
							}else if(result>0){
								jpaket_cetak(result);
								cetak_jpaket=0;
							}else{
								jpaket_btn_cancel();
							}
						},
						failure: function(response){
							var result=response.responseText;
							Ext.MessageBox.show({
							   title: 'Error',
							   msg: 'Could not connect to the database. retry later.',
							   buttons: Ext.MessageBox.OK,
							   animEl: 'database',
							   icon: Ext.MessageBox.ERROR
							});
							jpaket_btn_cancel();
						}
						*/
					});
					
				}
				
			}
		}
		
	}
	//eof
	
	/* Function for Delete Confirm of detail */
	function detail_medical_confirm_delete(){
		// only one record is selected here
		if(detail_medicalListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', detail_medical_delete);
		} else if(detail_medicalListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', detail_medical_delete);
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Anda belum memilih data yang akan dihapus',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
	//eof
	
	//function for Delete of detail
	function detail_medical_delete(btn){
		if(btn=='yes'){
            var selections = detail_medicalListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, record; record = selections[i]; i++){
                if(record.data.kmedical_id==''){
                    medical_DataStore.remove(record);
					//load_dstore_jpaket();
                }else if((/^\d+$/.test(record.data.kmedical_id))){
                    //Delete dari db.detail_jual_paket
                    Ext.MessageBox.show({
                        title: 'Please wait',
                        msg: 'Loading items...',
                        progressText: 'Initializing...',
                        width:300,
                        wait:true,
                        waitConfig: {interval:200},
                        closable:false
                    });
                    medical_DataStore.remove(record);
                    Ext.Ajax.request({ 
                        waitMsg: 'Please Wait',
                        url: 'index.php?c=c_karyawan&m=get_action', 
                        params: { task: "MDELETE", kmedical_id:  record.data.kmedical_id }, 
                        success: function(response){
							var result=eval(response.responseText);
							switch(result){
								case 1:
									//load_dstore_jpaket();
                                    Ext.MessageBox.hide();
									//Ext.Msg.alert('OK', 'Penghapusan secara permanen sudah dilakukan.');
									break;
								default:
									Ext.MessageBox.hide();
                                    Ext.MessageBox.show({
                                        title: 'Warning',
                                        msg: 'Could not delete the entire selection',
                                        buttons: Ext.MessageBox.OK,
                                        animEl: 'save',
                                        icon: Ext.MessageBox.WARNING
                                    });
                                    break;
							}
                        },
                        failure: function(response){
                            Ext.MessageBox.hide();
                            var result=response.responseText;
                            Ext.MessageBox.show({
                               title: 'Error',
                               msg: 'Could not connect to the database. retry later.',
                               buttons: Ext.MessageBox.OK,
                               animEl: 'database',
                               icon: Ext.MessageBox.ERROR
                            });	
                        }
                    });
                }
			}
		} 
		
	}
	//eof
	// EOF MEDICAL
	
	// FASILITAS
	//declaration of detail coloumn model
	detail_fasilitas_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			align : 'Left',
			header: 'ID',
			dataIndex: 'kfasilitas_id',
            hidden: true
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Item' + '</div>',
			dataIndex: 'kfasilitas_item',
			width: 300,
			sortable: true,
			editor: new Ext.form.TextField({maxLength:250})
			//editor: combo_paket_rawat,
			//renderer: Ext.util.Format.comboRenderer(combo_paket_rawat)
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Tgl Serah Terima' + '</div>',
			dataIndex: 'kfasilitas_tglserahterima',
			width: 100,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			readOnly: false,
			editor: new Ext.form.DateField({
				format: 'd-m-Y',
				disabled :false,
				})
			//editor: combo_paket_rawat,
			//renderer: Ext.util.Format.comboRenderer(combo_paket_rawat)
		},
		{
			align : 'Left',
			header: '<div align="center">' + 'Keterangan' + '</div>',
			dataIndex: 'kfasilitas_keterangan',
			width: 300,
			sortable: true,
			editor: new Ext.form.TextField({maxLength:250})
			//editor: combo_paket_rawat,
			//renderer: Ext.util.Format.comboRenderer(combo_paket_rawat)
		}
		]
	);
	detail_fasilitas_ColumnModel.defaultSortable= true;
	//eof
	//declaration of detail list editor grid
	detail_fasilitasListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'detail_fasilitasListEditorGrid',
		el: 'fp_detail_fasilitas',
		title: 'Fasilitas',
		height: 200,
		width: 1050,
		autoScroll: true,
		store: fasilitas_DataStore, //detail_jual_paket_DataStore, // DataStore
		colModel: detail_fasilitas_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 0 0 0',
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
		plugins: [editor_detail_fasilitas_karyawan],
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		<?php } ?>
		frame: true,
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:false},
		bbar: new Ext.PagingToolbar({
			pageSize: karyawan_pageS,
			store: fasilitas_DataStore,
			displayInfo: true
		})
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
		,
		/* Add Control on ToolBar */
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			ref : '../djpaket_add',
			handler: detail_fasilitas_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			ref : '../djpaket_delete',
			disabled: false,
			handler: detail_fasilitas_confirm_delete
		}
		]
		<?php } ?>
	});
	//eof
	
	//function of detail add
	function detail_fasilitas_add(){
		var edit_detail_fasilitas= new detail_fasilitasListEditorGrid.store.recordType({
			kfasilitas_id				:'',		
			kfasilitas_item				:'',
			kfasilitas_tglserahterima	:today.dateFormat('Y-m-d'),
			kfasilitas_keterangan		:''
		});
		editor_detail_fasilitas_karyawan.stopEditing();
		fasilitas_DataStore.insert(0, edit_detail_fasilitas);
		detail_fasilitasListEditorGrid.getView().refresh();
		detail_fasilitasListEditorGrid.getSelectionModel().selectRow(0);
		editor_detail_fasilitas_karyawan.startEditing(0);
	}
	
	//function for insert detail
	function detail_fasilitas_insert(){
		var	kfasilitas_id				=[];		
		var	kfasilitas_item				=[];
		var	kfasilitas_tglserahterima	=[];
		var	kfasilitas_keterangan		=[];

		var dcount = fasilitas_DataStore.getCount() - 1;
		
		if(fasilitas_DataStore.getCount()>0){
			for(i=0; i<fasilitas_DataStore.getCount();i++){
				/*
				kjabatan_id.push(jabatan_DataStore.getAt(i).data.kjabatan_id);
				kjabatan_departemen.push(jabatan_DataStore.getAt(i).data.kjabatan_departemen);
				kjabatan_jabatan.push(jabatan_DataStore.getAt(i).data.kjabatan_jabatan);
				kjabatan_golongan.push(jabatan_DataStore.getAt(i).data.kjabatan_golongan);
				kjabatan_pph21.push(jabatan_DataStore.getAt(i).data.kjabatan_pph21);
				kjabatan_atasan.push(jabatan_DataStore.getAt(i).data.kjabatan_atasan);
				kjabatan_tglawal.push(jabatan_DataStore.getAt(i).data.kjabatan_tglawal);
				kjabatan_tglakhir.push(jabatan_DataStore.getAt(i).data.kjabatan_tglakhir);
				kjabatan_keterangan.push(jabatan_DataStore.getAt(i).data.kjabatan_keterangan);
				*/
				
			/*
				if((/^\d+$/.test(detail_jual_paket_DataStore.getAt(i).data.dpaket_paket))
				   && detail_jual_paket_DataStore.getAt(i).data.dpaket_paket!==undefined
				   && detail_jual_paket_DataStore.getAt(i).data.dpaket_paket!==''
				   && detail_jual_paket_DataStore.getAt(i).data.dpaket_paket!==0){
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_id==undefined){
						dpaket_id.push('');
					}else{
						dpaket_id.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_id);
					}
					
					dpaket_paket.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_paket);
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_karyawan==undefined){
						dpaket_karyawan.push('');
					}else{
						dpaket_karyawan.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_karyawan);
					}
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_jumlah==undefined){
						dpaket_jumlah.push('');
					}else{
						dpaket_jumlah.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_jumlah);
					}
					
					dpaket_kadaluarsa.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_kadaluarsa.format('Y-m-d'));
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_harga==undefined){
						dpaket_harga.push('');
					}else{
						dpaket_harga.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_harga);
					}
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_diskon==undefined){
						dpaket_diskon.push('');
					}else{
						dpaket_diskon.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_diskon);
					}
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_diskon_jenis==undefined){
						dpaket_diskon_jenis.push('');
					}else{
						dpaket_diskon_jenis.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_diskon_jenis);
					}
					
					if(detail_jual_paket_DataStore.getAt(i).data.dpaket_sales==undefined){
						dpaket_sales.push('');
					}else{
						dpaket_sales.push(detail_jual_paket_DataStore.getAt(i).data.dpaket_sales);
					}
				}
				*/

				kfasilitas_id.push(fasilitas_DataStore.getAt(i).data.kfasilitas_id);
				kfasilitas_item.push(fasilitas_DataStore.getAt(i).data.kfasilitas_item);
				kfasilitas_tglserahterima.push(fasilitas_DataStore.getAt(i).data.kfasilitas_tglserahterima);
				kfasilitas_keterangan.push(fasilitas_DataStore.getAt(i).data.kfasilitas_keterangan);
	
				if(i==dcount){
					var encoded_array_kfasilitas_id = Ext.encode(kfasilitas_id);
					var encoded_array_kfasilitas_item = Ext.encode(kfasilitas_item);
					var encoded_array_kfasilitas_tglserahterima = Ext.encode(kfasilitas_tglserahterima);
					var encoded_array_kfasilitas_keterangan = Ext.encode(kfasilitas_keterangan);


					Ext.Ajax.request({
						waitMsg: 'Mohon  Tunggu...',
						url: 'index.php?c=c_karyawan&m=detail_fasilitas_insert',
						params:{
							kfasilitas_id				: encoded_array_kfasilitas_id, 
							kfasilitas_master			: eval(get_pk_id()),
							kfasilitas_item				: encoded_array_kfasilitas_item,
							kfasilitas_tglserahterima	: encoded_array_kfasilitas_tglserahterima,
							kfasilitas_keterangan		: encoded_array_kfasilitas_keterangan
						},
						timeout: 60000,
						/*
						success: function(response){							
							var result=eval(response.responseText);
							if(result==0){
								Ext.MessageBox.alert(jpaket_post2db+' OK','Data penjualan paket berhasil disimpan');
								jpaket_btn_cancel();
							}else if(result>0){
								jpaket_cetak(result);
								cetak_jpaket=0;
							}else{
								jpaket_btn_cancel();
							}
						},
						failure: function(response){
							var result=response.responseText;
							Ext.MessageBox.show({
							   title: 'Error',
							   msg: 'Could not connect to the database. retry later.',
							   buttons: Ext.MessageBox.OK,
							   animEl: 'database',
							   icon: Ext.MessageBox.ERROR
							});
							jpaket_btn_cancel();
						}
						*/
					});
					
				}
				
			}
		}
		
	}
	//eof
	
	/* Function for Delete Confirm of detail */
	function detail_fasilitas_confirm_delete(){
		// only one record is selected here
		if(detail_fasilitasListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', detail_fasilitas_delete);
		} else if(detail_fasilitasListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', detail_fasilitas_delete);
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Anda belum memilih data yang akan dihapus',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
	//eof
	
	//function for Delete of detail
	function detail_fasilitas_delete(btn){
		if(btn=='yes'){
            var selections = detail_fasilitasListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, record; record = selections[i]; i++){
                if(record.data.kfasilitas_id==''){
                    fasilitas_DataStore.remove(record);
					//load_dstore_jpaket();
                }else if((/^\d+$/.test(record.data.kfasilitas_id))){
                    //Delete dari db.detail_jual_paket
                    Ext.MessageBox.show({
                        title: 'Please wait',
                        msg: 'Loading items...',
                        progressText: 'Initializing...',
                        width:300,
                        wait:true,
                        waitConfig: {interval:200},
                        closable:false
                    });
                    fasilitas_DataStore.remove(record);
                    Ext.Ajax.request({ 
                        waitMsg: 'Please Wait',
                        url: 'index.php?c=c_karyawan&m=get_action', 
                        params: { task: "FDELETE", kfasilitas_id:  record.data.kfasilitas_id }, 
                        success: function(response){
							var result=eval(response.responseText);
							switch(result){
								case 1:
									//load_dstore_jpaket();
                                    Ext.MessageBox.hide();
									//Ext.Msg.alert('OK', 'Penghapusan secara permanen sudah dilakukan.');
									break;
								default:
									Ext.MessageBox.hide();
                                    Ext.MessageBox.show({
                                        title: 'Warning',
                                        msg: 'Could not delete the entire selection',
                                        buttons: Ext.MessageBox.OK,
                                        animEl: 'save',
                                        icon: Ext.MessageBox.WARNING
                                    });
                                    break;
							}
                        },
                        failure: function(response){
                            Ext.MessageBox.hide();
                            var result=response.responseText;
                            Ext.MessageBox.show({
                               title: 'Error',
                               msg: 'Could not connect to the database. retry later.',
                               buttons: Ext.MessageBox.OK,
                               animEl: 'database',
                               icon: Ext.MessageBox.ERROR
                            });	
                        }
                    });
                }
			}
		} 
		
	}
	//eof
	// EOF FASILITAS
    
	/* Declare DataStore and  show datagrid list */
	karyawanListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'karyawanListEditorGrid',
		el: 'fp_karyawan',
		title: 'Daftar Karyawan',
		autoHeight: true,
		store: karyawan_DataStore, // DataStore
		cm: karyawan_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1220,
		bbar: new Ext.PagingToolbar({
			pageSize: karyawan_pageS,
			store: karyawan_DataStore,
			displayInfo: true
		}),
		/* Add Control on ToolBar */
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<?php } ?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: karyawan_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: karyawan_confirm_delete   // Confirm before deleting
		}, '-', 
		<?php } ?>
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: karyawan_DataStore,
			params: {task: 'LIST',start: 0, limit: karyawan_pageS},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						karyawan_DataStore.baseParams={task:'LIST',start: 0, limit: karyawan_pageS};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Search By'});
				Ext.get(this.id).set({qtip:'- NIK<br>- Nama Lengkap<br>- Nickname<br>- Departemen<br>- Jabatan'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: karyawan_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: karyawan_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: karyawan_print  
		}
		]
	});
	karyawanListEditorGrid.render();
	/* End of DataStore */
	
	/*karyawanListEditorGrid.getColumnModel().setHidden(3, true);
	karyawanListEditorGrid.getColumnModel().setHidden(9, true);
	karyawanListEditorGrid.getColumnModel().setHidden(14, true);
	karyawanListEditorGrid.getColumnModel().setHidden(15, true);
	karyawanListEditorGrid.getColumnModel().setHidden(24, true);
	karyawanListEditorGrid.getColumnModel().setHidden(25, true);
	karyawanListEditorGrid.getColumnModel().setHidden(26, true);
	karyawanListEditorGrid.getColumnModel().setHidden(27, true);
	karyawanListEditorGrid.getColumnModel().setHidden(26, true);*/
     
	/* Create Context Menu */
	karyawan_ContextMenu = new Ext.menu.Menu({
		id: 'karyawan_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: karyawan_confirm_update 
		},
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			handler: karyawan_confirm_delete 
		},
		<?php } ?>
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: karyawan_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: karyawan_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onkaryawan_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		karyawan_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		karyawan_SelectedRow=rowIndex;
		karyawan_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function karyawan_editContextMenu(){
      karyawanListEditorGrid.startEditing(karyawan_SelectedRow,1);
  	}
	/* End of Function */
  	
	karyawanListEditorGrid.addListener('rowcontextmenu', onkaryawan_ListEditGridContextMenu);
	karyawan_DataStore.load({params: {start: 0, limit: karyawan_pageS}});	// load DataStore
	karyawanListEditorGrid.on('afteredit', karyawan_update); // inLine Editing Record
	
	cbo_karyawan_golongan_DataStore.load();
	cbo_karyawan_jabatan_DataStore.load();
	cbo_karyawan_cabang_DataStore.load();
	cbo_karyawan_departemen_DataStore.load();
	cbo_karyawan_atasan_DataStore.load();
	
	/* Identify  karyawan_no Field */
	karyawan_noField= new Ext.form.TextField({
		id: 'karyawan_noField',
		fieldLabel: 'NIK',
		maxLength: 30,
		allowBlank: false,
		readOnly: true,
		emptyText: '(auto)',
		anchor: '95%'
	});
	
	/* Identify  karyawan_noktp Field */
	karyawan_noktpField= new Ext.form.TextField({
		id: 'karyawan_noktpField',
		fieldLabel: 'No. KTP',
		maxLength: 30,
		allowBlank: true,
		readOnly: false,
		//emptyText: '(auto)',
		anchor: '95%'
	});
	
	/* Identify  karyawan_alamatktp Field */
	karyawan_alamatktpField= new Ext.form.TextField({
		id: 'karyawan_alamatktpField',
		fieldLabel: 'Alamat KTP',
		maxLength: 250,
		allowBlank: true,
		readOnly: false,
		//emptyText: '(auto)',
		anchor: '95%'
	});
	
	/* Identify  karyawan_agama Field */
	karyawan_agamaField= new Ext.form.ComboBox({
		id: 'karyawan_agamaField',
		fieldLabel: 'Agama',
		store:new Ext.data.SimpleStore({
			fields:['karyawan_agama_value', 'karyawan_agama_display'],
			data:[['Kristen','Kristen'],['Katholik','Katholik'],['Islam','Islam'],['Budha','Budha'],['Hindu','Hindu'],['Kong Hu Chu','Kong Hu Chu']]
		}),
		mode: 'local',
		editable:false,
		allowBlank: false,
		displayField: 'karyawan_agama_display',
		valueField: 'karyawan_agama_value',
		width: 100,
		triggerAction: 'all'	
	});
	
	/*Identify karyawan_sip Field*/
	karyawan_sipField= new Ext.form.TextField({
		id: 'karyawan_sipField',
		fieldLabel: 'SIP (Jika Diperlukan)',
		maxLength: 15,
		anchor: '95%'
	});
	
	/* Identify  karyawan_npwp Field */
	karyawan_npwpField= new Ext.form.TextField({
		id: 'karyawan_npwpField',
		fieldLabel: 'NPWP',
		maxLength: 30,
		anchor: '95%'
	});
	/* Identify  karyawan_username Field */
	karyawan_usernameField= new Ext.form.TextField({
		id: 'karyawan_usernameField',
		fieldLabel: '&nbsp;&nbsp;&nbsp;Nickname',
		maxLength: 15,
		allowBlank: false,
		width: 100
	});
	/* Identify  karyawan_nama Field */
	karyawan_namaField= new Ext.form.TextField({
		id: 'karyawan_namaField',
		fieldLabel: 'Nama Lengkap',
		maxLength: 50,
		allowBlank: false,
		anchor: '95%'
	});
	/* Identify  karyawan_kelamin Field */
	karyawan_kelaminField= new Ext.form.ComboBox({
		id: 'karyawan_kelaminField',
		fieldLabel: 'Jenis Kelamin',
		store:new Ext.data.SimpleStore({
			fields:['karyawan_kelamin_value', 'karyawan_kelamin_display'],
			data:[['L','Laki-laki'],['P','Perempuan']]
		}),
		mode: 'local',
		editable:false,
		allowBlank: false,
		displayField: 'karyawan_kelamin_display',
		valueField: 'karyawan_kelamin_value',
		width: 100,
		triggerAction: 'all'	
	});
	/* Identify  karyawan_kelamin Field */
	karyawan_marriageField= new Ext.form.ComboBox({
		id: 'karyawan_marriageField',
		fieldLabel: 'Status Pernikahan',
		store:new Ext.data.SimpleStore({
			fields:['karyawan_marriage_value', 'karyawan_marriage_display'],
			data:[['Single','Belum Menikah'],['Marriage','Menikah']]
		}),
		mode: 'local',
		editable:false,
		allowBlank: false,
		displayField: 'karyawan_marriage_display',
		valueField: 'karyawan_marriage_value',
		width: 100,
		triggerAction: 'all'	
	});
	
	/* Identify  karyawan_jumlahanak Field */
	karyawan_jmlanakField= new Ext.form.TextField({
		id: 'karyawan_jmlanakField',
		fieldLabel: 'Jml Anak',
		maxLength: 15,
		allowBlank: false,
		disabled: true,
		width: 100
	});
	
	/* Identify  karyawan_bank Field */
	karyawan_bankField= new Ext.form.ComboBox({
		id: 'karyawan_bankField',
		fieldLabel: 'Nama Bank',
		store:cbo_karyawan_bank_DataStore,
		mode: 'remote',
		editable:false,
		allowBlank: true,
		displayField: 'karyawan_bank_display',
		valueField: 'karyawan_bank_value',
		width: 100,
		triggerAction: 'all'	
	});
	/* Identify  karyawan_bankcabang Field */
	karyawan_bankcabangField= new Ext.form.TextField({
		id: 'karyawan_bankcabangField',
		fieldLabel: 'Cabang',
		maxLength: 50,
		allowBlank: true,
		anchor: '95%'
	});
	/* Identify  karyawan_norekening Field */
	karyawan_norekeningField= new Ext.form.TextField({
		id: 'karyawan_norekeningField',
		fieldLabel: 'No Rekening',
		maxLength: 50,
		allowBlank: true,
		anchor: '95%'
	});
	/* Identify  karyawan_atasnama Field */
	karyawan_atasnamaField= new Ext.form.TextField({
		id: 'karyawan_atasnamaField',
		fieldLabel: 'Atas Nama',
		maxLength: 50,
		allowBlank: true,
		anchor: '95%'
	});
	
	/* Identify  karyawan_kelamin Field */
	karyawan_pph21Field= new Ext.form.ComboBox({
		id: 'karyawan_pph21Field',
		fieldLabel: 'PPH 21',
		store:new Ext.data.SimpleStore({
			fields:['karyawan_pph21_value', 'karyawan_pph21_display'],
			data:[['TK','TK'],['K','K'],['K/1','K/1'],['K/2','K/2'],['K/3','K/3'],['TK/1','TK/1'],['TK/2','TK/2'],['TK/3','TK/3']]
		}),
		mode: 'local',
		editable:false,
		allowBlank: false,
		displayField: 'karyawan_pph21_display',
		valueField: 'karyawan_pph21_value',
		width: 80,
		triggerAction: 'all'	
	});
	/* Identify  karyawan_tgllahir Field */
	karyawan_tgllahirField= new Ext.form.DateField({
		id: 'karyawan_tgllahirField',
		fieldLabel: '/',
		format : 'd-m-Y',
		allowBlank: false,
	});
	/* Identify  karyawan_tmplahir Field */
	karyawan_tmplahirField= new Ext.form.TextField({
		id: 'karyawan_tmplahirField',
		fieldLabel: 'Tempat / Tgl Lahir',
		maxLength: 100,
		allowBlank: false,
		anchor: '95%'
	});
	/* Identify  karyawan_alamat Field */
	karyawan_alamatField= new Ext.form.TextField({
		id: 'karyawan_alamatField',
		fieldLabel: 'Alamat Saat Ini',
		maxLength: 250,
		allowBlank: false,
		anchor: '95%'
	});
	/* Identify  karyawan_kota Field */
	karyawan_kotaField= new Ext.form.TextField({
		id: 'karyawan_kotaField ',
		fieldLabel: 'Kota',
		maxLength: 30,
		anchor: '95%'
	});
	/* Identify  karyawan_kodepos Field */
	karyawan_kodeposField= new Ext.form.TextField({
		id: 'karyawan_kodeposField',
		fieldLabel: 'Kode Pos',
		maxLength: 5,
		width: 60,
		maskRe: /([0-9]+)$/
	});
	/* Identify  karyawan_email Field */
	karyawan_emailField= new Ext.form.TextField({
		id: 'karyawan_emailField',
		fieldLabel: 'Email',
		maxLength: 40,
		anchor: '95%'
	});
	/* Identify  karyawan_emiracle Field */
	karyawan_emiracleField= new Ext.form.TextField({
		id: 'karyawan_emiracleField',
		fieldLabel: 'Email Miracle',
		maxLength: 40,
		anchor: '95%'
	});
	/* Identify  karyawan_jamsostek Field */
	karyawan_jamsostekField= new Ext.form.TextField({
		id: 'karyawan_jamsostekField',
		fieldLabel: 'No. Jamsostek',
		maxLength: 40,
		anchor: '95%'
	});
	/* Identify  karyawan_keterangan Field */
	karyawan_keteranganField= new Ext.form.TextArea({
		id: 'karyawan_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 500,
		anchor: '95%'
	});
	/* Identify  karyawan_notelp Field */
	karyawan_notelpField= new Ext.form.TextField({
		id: 'karyawan_notelpField',
		fieldLabel: 'No.Telp Rumah',
		maxLength: 25,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  karyawan_notelp2 Field */
	karyawan_notelp2Field= new Ext.form.TextField({
		id: 'karyawan_notelp2Field',
		fieldLabel: 'Ponsel',
		maxLength: 25,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  karyawan_notelp3 Field */
	karyawan_notelp3Field= new Ext.form.TextField({
		id: 'karyawan_notelp3Field',
		fieldLabel: '',
		maxLength: 25,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  karyawan_notelp4 Field */
	karyawan_notelp4Field= new Ext.form.TextField({
		id: 'karyawan_notelp4Field',
		fieldLabel: '',
		maxLength: 25,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  karyawan_cabang Field */
	karyawan_cabangField= new Ext.form.ComboBox({
		id: 'karyawan_cabangField ',
		fieldLabel: 'Cabang',
		store:cbo_karyawan_cabang_DataStore,
		mode: 'remote',
		editable:false,
		allowBlank: false,
		displayField: 'karyawan_cabang_display',
		valueField: 'karyawan_cabang_value',
		anchor: '95%',
		triggerAction: 'all'
	});
	/* Identify  karyawan_jabatan Field */
	karyawan_jabatanField= new Ext.form.ComboBox({
		id: 'karyawan_jabatanField',
		fieldLabel: 'Jabatan',
		store:cbo_karyawan_jabatan_DataStore,
		mode: 'remote',
		editable:false,
		allowBlank: false,
		displayField: 'karyawan_jabatan_display',
		valueField: 'karyawan_jabatan_value',
		anchor: '95%',
		triggerAction: 'all'
	});
	/* Identify  karyawan_departemen Field */
	karyawan_departemenField= new Ext.form.ComboBox({
		id: 'karyawan_departemenField',
		fieldLabel: 'Departemen',
		store:cbo_karyawan_departemen_DataStore,
		mode: 'remote',
		editable:false,
		allowBlank: false,
		displayField: 'karyawan_departemen_display',
		valueField: 'karyawan_departemen_value',
		anchor: '95%',
		triggerAction: 'all'
	});
	
	karyawan_golonganField= new Ext.form.ComboBox({
		id: 'karyawan_golonganField',
		fieldLabel: 'Golongan',
		store:cbo_karyawan_golongan_DataStore,
		mode: 'remote',
		editable:false,
		allowBlank: true,
		displayField: 'karyawan_golongan_display',
		valueField: 'karyawan_golongan_value',
		anchor: '95%',
		triggerAction: 'all'
	});
	
	/* Identify  karyawan_golongantxt Field */
	karyawan_golongantxtField= new Ext.form.TextField({
		id: 'karyawan_golongantxtField',
		fieldLabel: '&nbsp;&nbsp;&nbsp;Tambah (optional)',
		maxLength: 50,
		allowBlank: true,
		emptyText: 'Golongan lainnya...',
		anchor: '95%'
	});
	/* Identify  karyawan_tglmasuk Field */
	karyawan_tglmasukField= new Ext.form.DateField({
		id: 'karyawan_tglmasukField',
		fieldLabel: 'Tanggal Masuk',
		format : 'Y-m-d',
		allowBlank: false,
		width : 100
	});
	/* Identify  karyawan_tgl_batas Field */
	karyawan_tglbatasField= new Ext.form.DateField({
		id: 'karyawan_tglbatasField',
		fieldLabel: 'Tanggal Batas',
		format : 'Y-m-d',
	});
	/* Identify  karyawan_atasan Field */
	karyawan_atasanField= new Ext.form.ComboBox({
		id: 'karyawan_atasanField',
		fieldLabel: 'Atasan',
		store:cbo_karyawan_atasan_DataStore,
		mode: 'remote',
		editable:false,
		displayField: 'karyawan_atasan_display',
		valueField: 'karyawan_atasan_value',
		allowBlank: true,
		anchor: '95%',
		triggerAction: 'all'
	});
	
		/* Identify Paket Aktif*/
	karyawan_cab_thField=new Ext.form.Checkbox({
		id : 'karyawan_cab_thField',
		boxLabel: 'Thamrin',
		maxLength: 250,
		name: 'karyawan_cab_th'
	});
	
	karyawan_cab_kiField=new Ext.form.Checkbox({
		id : 'karyawan_cab_kiField',
		boxLabel: 'Kertajaya_Indah',
		maxLength: 250,
		name: 'karyawan_cab_ki'
	});
	
	karyawan_cab_hrField=new Ext.form.Checkbox({
		id : 'karyawan_cab_hrField',
		boxLabel: 'HR_Muhammad',
		maxLength: 250,
		name: 'karyawan_cab_hr'
	});
	
	karyawan_cab_tpField=new Ext.form.Checkbox({
		id : 'karyawan_cab_tpField',
		boxLabel: 'TP',
		maxLength: 250,
		name: 'karyawan_cab_tp'
	});
	
	karyawan_cab_dpsField=new Ext.form.Checkbox({
		id : 'karyawan_cab_dpsField',
		boxLabel: 'Denpasar',
		maxLength: 250,
		name: 'karyawan_cab_dps'
	});
	
	karyawan_cab_jktField=new Ext.form.Checkbox({
		id : 'karyawan_cab_jktField',
		boxLabel: 'Jakarta',
		maxLength: 250,
		name: 'karyawan_cab_jkt'
	});
	
	karyawan_cab_mtaField=new Ext.form.Checkbox({
		id : 'karyawan_cab_mtaField',
		boxLabel: 'MTA',
		maxLength: 250,
		name: 'karyawan_cab_mta'
	});
	
	karyawan_cab_blpnField=new Ext.form.Checkbox({
		id : 'karyawan_cab_blpnField',
		boxLabel: 'Balikpapan',
		maxLength: 250,
		name: 'karyawan_cab_blpn'
	});
	
	karyawan_cab_kutaField=new Ext.form.Checkbox({
		id : 'karyawan_cab_kutaField',
		boxLabel: 'Kuta',
		maxLength: 250,
		name: 'karyawan_cab_kuta'
	});
	
	karyawan_cab_btmField=new Ext.form.Checkbox({
		id : 'karyawan_cab_btmField',
		boxLabel: 'Batam',
		maxLength: 250,
		name: 'karyawan_cab_btm'
	});
	
	karyawan_cab_mksField=new Ext.form.Checkbox({
		id : 'karyawan_cab_mksField',
		boxLabel: 'Makasar',
		maxLength: 250,
		name: 'karyawan_cab_mks'
	});
	
	karyawan_cab_mdnField=new Ext.form.Checkbox({
		id : 'karyawan_cab_mdnField',
		boxLabel: 'Medan',
		maxLength: 250,
		name: 'karyawan_cab_mdn'
	});
	
	karyawan_cab_lbkField=new Ext.form.Checkbox({
		id : 'karyawan_cab_lbkField',
		boxLabel: 'Lombok',
		maxLength: 250,
		name: 'karyawan_cab_lbk'
	});
	
	karyawan_cab_mndField=new Ext.form.Checkbox({
		id : 'karyawan_cab_mndField',
		boxLabel: 'Manado',
		maxLength: 250,
		name: 'karyawan_cab_mnd'
	});
	
	karyawan_cab_ygkField=new Ext.form.Checkbox({
		id : 'karyawan_cab_ygkField',
		boxLabel: 'Yogyakarta',
		maxLength: 250,
		name: 'karyawan_cab_ygk'
	});
	
	karyawan_cab_smgField=new Ext.form.Checkbox({
		id : 'karyawan_cab_smgField',
		boxLabel: 'Semarang',
		maxLength: 250,
		name: 'karyawan_cab_smg'
	});
	
	karyawan_cab_sjlField=new Ext.form.Checkbox({
		id : 'karyawan_cab_sjlField',
		boxLabel: 'PT. SJL',
		maxLength: 250,
		name: 'karyawan_cab_sjl'
	});
	
	karyawan_cab_mlgField=new Ext.form.Checkbox({
		id : 'karyawan_cab_mlgField',
		boxLabel: 'Malang',
		maxLength: 250,
		name: 'karyawan_cab_mlg'
	});
	
	karyawan_cab_corpField=new Ext.form.Checkbox({
		id : 'karyawan_cab_corpField',
		boxLabel: 'Corporate',
		maxLength: 250,
		name: 'karyawan_cab_corp'
	});
	
	karyawan_cab_maaField=new Ext.form.Checkbox({
		id : 'karyawan_cab_maaField',
		boxLabel: 'MAA',
		maxLength: 250,
		name: 'karyawan_cab_maa'
	});
	
	karyawan_cab_mgField=new Ext.form.Checkbox({
		id : 'karyawan_cab_mgField',
		boxLabel: 'Manyar_Garden',
		maxLength: 250,
		name: 'karyawan_cab_mg'
	});
	
	karyawan_cab_checkField=new Ext.form.Checkbox({
		id : 'karyawan_cab_checkField',
		boxLabel: 'Check All',
		maxLength: 250,
		handler: function(node,checked){
			if (checked) {
				karyawan_cab_thField.setValue(true);
				karyawan_cab_kiField.setValue(true);
				karyawan_cab_hrField.setValue(true);
				karyawan_cab_tpField.setValue(true);
				karyawan_cab_dpsField.setValue(true);
				karyawan_cab_jktField.setValue(true);
				karyawan_cab_mtaField.setValue(true);
				karyawan_cab_blpnField.setValue(true);
				karyawan_cab_kutaField.setValue(true);
				karyawan_cab_btmField.setValue(true);
				karyawan_cab_mksField.setValue(true);
				karyawan_cab_mdnField.setValue(true);
				karyawan_cab_lbkField.setValue(true);
				karyawan_cab_mndField.setValue(true);
				karyawan_cab_ygkField.setValue(true);
				karyawan_cab_smgField.setValue(true);
				karyawan_cab_sjlField.setValue(true);
				karyawan_cab_mlgField.setValue(true);
				karyawan_cab_corpField.setValue(true);
				karyawan_cab_maaField.setValue(true);
				karyawan_cab_mgField.setValue(true);
			}
			else {
				karyawan_cab_thField.setValue(false);
				karyawan_cab_kiField.setValue(false);
				karyawan_cab_hrField.setValue(false);
				karyawan_cab_tpField.setValue(false);
				karyawan_cab_dpsField.setValue(false);
				karyawan_cab_jktField.setValue(false);
				karyawan_cab_mtaField.setValue(false);
				karyawan_cab_blpnField.setValue(false);
				karyawan_cab_kutaField.setValue(false);
				karyawan_cab_btmField.setValue(false);
				karyawan_cab_mksField.setValue(false);
				karyawan_cab_mdnField.setValue(false);
				karyawan_cab_lbkField.setValue(false);
				karyawan_cab_mndField.setValue(false);
				karyawan_cab_ygkField.setValue(false);
				karyawan_cab_sjlField.setValue(false);
				karyawan_cab_smgField.setValue(false);
				karyawan_cab_mlgField.setValue(false);
				karyawan_cab_corpField.setValue(false);
				karyawan_cab_maaField.setValue(false);
				karyawan_cab_mgField.setValue(false);

			}
		}
	});
	
	karyawan_cabGroup = new Ext.form.FieldSet({
		title: 'Cabang Lainnya',
		layout:'column',
		autoHeight: true,
		store:cbo_karyawan_cabang_DataStore,
		mode: 'remote',
		collapsed: false,
		collapsible: true,
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				labelAlign: 'left',
				border:false,
				items: [ karyawan_cab_corpField, karyawan_cab_thField, karyawan_cab_kiField, karyawan_cab_hrField, karyawan_cab_tpField,  karyawan_cab_mlgField, karyawan_cab_dpsField, karyawan_cab_mtaField, karyawan_cab_blpnField, karyawan_cab_mgField, karyawan_cab_sjlField]
			},
			 {
				   	layout: 'form',
					border: false,
					columnWidth: 0.5,
					labelWidth: 80,
					labelAlign: 'left',
					items:[karyawan_cab_kutaField, karyawan_cab_btmField, karyawan_cab_mksField, karyawan_cab_mdnField, karyawan_cab_lbkField, karyawan_cab_mndField, karyawan_cab_ygkField,karyawan_cab_jktField, karyawan_cab_smgField]
			   }
		]
	});
	
	/* Identify  karyawan_aktif Field */
	karyawan_aktifField= new Ext.form.ComboBox({
		id: 'karyawan_aktifField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['karyawan_aktif_value', 'karyawan_aktif_display'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		editable:false,
		displayField: 'karyawan_aktif_display',
		valueField: 'karyawan_aktif_value',
		emptyText: 'Aktif',
		width: 80,
		triggerAction: 'all'	
	});
	/*
	[
			{
				columnWidth:0.5,
				layout: 'form',
				labelAlign: 'left',
				border:false,
				items: [ karyawan_cab_corpField, karyawan_cab_thField, karyawan_cab_kiField, karyawan_cab_hrField, karyawan_cab_tpField,  karyawan_cab_mlgField, karyawan_cab_dpsField, karyawan_cab_jktField, karyawan_cab_mtaField, karyawan_cab_blpnField, karyawan_cab_mgField]
			},
			 {
				   	layout: 'form',
					border: false,
					columnWidth: 0.5,
					labelWidth: 80,
					labelAlign: 'left',
					items:[karyawan_cab_kutaField, karyawan_cab_btmField, karyawan_cab_mksField, karyawan_cab_mdnField, karyawan_cab_lbkField, karyawan_cab_mndField, karyawan_cab_ygkField]
			   }
		]
	*/
  	
	group_alamat = new Ext.form.FieldSet({
		title: 'Alamat',
		autoHeight: true,
		layout:'form',
		//mode: 'remote',
		//defaultType: 'textfield',	
		anchor: '95%',
		items:
			[karyawan_alamatField ,
			{
				columnWidth:1,
				layout: 'column',
				border:false,
				items: [
					{
						columnWidth:0.5,
						layout: 'form',
						labelAlign: 'left',
						border:false,
						items: [karyawan_kotaField]
					},
					{
						layout: 'form',
						border: false,
						columnWidth: 0.5,
						labelWidth: 70,
						//labelAlign: 'left',
						labelSeparator: ' ', 
						items:[karyawan_kodeposField]
					}
				]}, karyawan_notelpField,
				{
				columnWidth:1,
				layout: 'column',
				border:false,
				items: [
					{
						columnWidth:0.5,
						layout: 'form',
						labelAlign: 'left',
						border:false,
						items: [karyawan_notelp2Field]
					},
					{
						layout: 'form',
						border: false,
						columnWidth: 0.24,
						labelWidth: 3,
						//labelAlign: 'left',
						labelSeparator: ' ', 
						items:[karyawan_notelp3Field]
					},
					{
						layout: 'form',
						border: false,
						columnWidth: 0.23,
						labelWidth: 3,
						//labelAlign: 'left',
						labelSeparator: ' ', 
						items:[karyawan_notelp4Field]
					}
				]},karyawan_emailField
			]
	});
	/*
	group_kontak = new Ext.form.FieldSet({
		title: 'Kontak',
		autoHeight: true,
		defaultType: 'textfield',
		anchor: '95%',
		items:[karyawan_notelpField ,karyawan_notelp2Field ,karyawan_notelp3Field,karyawan_notelp4Field ,karyawan_emailField]
	});
	*/
	group_rekening = new Ext.form.FieldSet({
		title: 'Rekening',
		autoHeight: true,
		defaultType: 'textfield',
		anchor: '95%',
		items:[karyawan_bankField, karyawan_bankcabangField, karyawan_norekeningField, karyawan_atasnamaField ]
	});
	
	var detail_tab_data_karyawan = new Ext.TabPanel({
		plain:true,
		activeTab: 0,
		autoHeight: true,
		items: [detail_status_karyawanListEditorGrid,detail_jabatanListEditorGrid, detail_pendidikanListEditorGrid, detail_keluargaListEditorGrid]
	});
	
	var detail_tab_aktivitas_karyawan = new Ext.TabPanel({
		plain:true,
		activeTab: 0,
		autoHeight: true,
		items: [detail_cutiListEditorGrid,detail_gantioffListEditorGrid, detail_medicalListEditorGrid, detail_fasilitasListEditorGrid]
	});
	
	group_detail_data = new Ext.form.FieldSet({
		title: 'Detail Data Karyawan',
		autoHeight: true,
		defaultType: 'textfield',
		anchor: '95%',
		items:[detail_tab_data_karyawan]
	});
	group_detail_aktivitas = new Ext.form.FieldSet({
		title: 'Detail Aktivitas Karyawan',
		autoHeight: true,
		defaultType: 'textfield',
		anchor: '95%',
		items:[detail_tab_aktivitas_karyawan]
	});
	

	
	/* Function for retrieve create Window Panel*/ 
	karyawan_createForm = new Ext.FormPanel({
		labelAlign: 'left',
		labelWidth: 120,
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 1100,        
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [karyawan_cabangField, karyawan_noField, karyawan_namaField, karyawan_usernameField, karyawan_noktpField, karyawan_alamatktpField, karyawan_agamaField,
						{
							columnWidth:1,
							layout: 'column',
							border:false,
							items: [
								{
									columnWidth:0.5,
									layout: 'form',
									labelAlign: 'left',
									border:false,
									items: [karyawan_tmplahirField]
								},
								{
									layout: 'form',
									border: false,
									columnWidth: 0.5,
									labelWidth: 20,
									//labelAlign: 'left',
									labelSeparator: ' ', 
									items:[karyawan_tgllahirField]
								}
							]},karyawan_kelaminField,
							{	
							columnWidth:1,
							layout: 'column',
							border:false,
							items: [
								{
									columnWidth:0.5,
									layout: 'form',
									labelAlign: 'left',
									border:false,
									items: [karyawan_marriageField]
								},
								{
									layout: 'form',
									border: false,
									columnWidth: 0.5,
									labelWidth: 60,
									//labelAlign: 'left',
									labelSeparator: ' ', 
									items:[karyawan_jmlanakField]
								}
							]},karyawan_tglmasukField, group_alamat, group_rekening ] 
			}
			,{
				columnWidth:0.5,
				layout: 'form',
				border:false,	
				items: [/*karyawan_cabGroup, */ karyawan_sipField,  karyawan_jamsostekField, karyawan_npwpField,/* karyawan_emiracleField, */ karyawan_keteranganField, karyawan_aktifField ] 
			}
			]
		}/*, group_detail_data, group_detail_aktivitas*/]
		//detail_status_karyawanListEditorGrid, detail_jabatanListEditorGrid]
		,
		buttons: [
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KARYAWAN'))){ ?>
			{
				text: 'Save and Close',
				handler: karyawan_create
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					karyawan_reset_form();
					karyawan_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	/*
	var detail_tab_data_karyawan = new Ext.TabPanel({
		plain:true,
		activeTab: 0,
		autoHeight: true,
		items: [detail_status_karyawanListEditorGrid,detail_jabatanListEditorGrid]
	});
	*/
	
	/* Function for retrieve create Window Form */
	karyawan_createWindow= new Ext.Window({
		id: 'karyawan_createWindow',
		title: karyawan_post2db+'Karyawan',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_karyawan_create',
		items: karyawan_createForm
	});
	/* End Window */
	
	
	/* Function for action list search */
	function karyawan_list_search(){
		// render according to a SQL date format.
		// GENERAL SEARCH
		var karyawan_id_search=null;
		var karyawan_no_search=null;
		var karyawan_cabang_search=null;
		var karyawan_noktp_search=null;
		var karyawan_alamatktp_search=null;
		var karyawan_agama_search=null;
		var karyawan_npwp_search=null;
		var karyawan_jamsostek_search=null;
		var karyawan_sip_search=null;
		var karyawan_username_search=null;
		var karyawan_nama_search=null;
		var karyawan_kelamin_search=null;
		var karyawan_marriage_search=null;
		var karyawan_jmlanak_search=null;
		var karyawan_tglmasuk_search_date="";
		var karyawan_aktif_search=null;
		// TEMPAT TANGGAL LAHIR SEARCH
		var karyawan_tempatlahir_search=null;
		var karyawan_tgllahirawal_search="";
		var karyawan_tgllahirakhir_search="";
		var karyawan_tgllahir_search=null;
		var karyawan_blnlahir_search=null;
		// ALAMAT SEARCH
		var karyawan_alamat_search=null;
		var karyawan_kota_search=null;
		var karyawan_kodepos_search=null;
		var karyawan_email_search=null;
		//var karyawan_emiracle_search=null;
		var karyawan_keterangan_search=null;
		var karyawan_notelp_search=null;
		//var karyawan_notelp2_search=null;
		//var karyawan_notelp3_search=null;
		//var karyawan_notelp4_search=null;
		// INFO REKENING SEARCH
		var karyawan_bank_search=null;
		var karyawan_bankcabang_search=null;
		var karyawan_norekening_search=null;
		var karyawan_atasnama_search=null;
		// STATUS KEKARYAWANAN SEARCH
		var karyawan_statuskekaryawanan_search=null;
		var karyawan_statustglawalawal_search="";
		var karyawan_statustglawalakhir_search="";
		var karyawan_statustglakhirawal_search="";
		var karyawan_statustglakhirakhir_search="";
		var karyawan_statuskaryawan_search=null;
		// JABATAN SEARCH
		var karyawan_jabatan_search=null;
		var karyawan_departemen_search=null;
		var karyawan_golongan_search=null;
		var karyawan_atasan_search=null;
		var karyawan_pph21_search=null;
		var karyawan_tgljbtawalawal_search="";
		var karyawan_tgljbtawalakhir_search="";
		var karyawan_tgljbtakhirawal_search="";
		var karyawan_tgljbtakhirakhir_search="";
		var karyawan_jabatanketerangan_search=null;
		// PENDIDIKAN SEARCH
		var karyawan_pendidikan_search=null;
		var karyawan_namasekolah_search=null;
		var karyawan_jurusan_search=null;
		var karyawan_thnmskawal_search=null;
		var karyawan_thnmskakhir_search=null;
		var karyawan_thnslsawal_search=null;
		var karyawan_thnslsakhir_search=null;
		var karyawan_wisudaawal_search=null;
		var karyawan_wisudaakhir_search=null;
		var karyawan_pendidikanketerangan_search=null;
		// CUTI SEARCH
		var karyawan_jeniscuti_search=null;
		var karyawan_tglcutiawalawal_search=null;
		var karyawan_tglcutiawalakhir_search=null;
		var karyawan_tglcutiakhirawal_search=null;
		var karyawan_tglcutiakhirakhir_search=null;
		var karyawan_jmlharicutiawal_search=null;
		var karyawan_jmlharicutiakhir_search=null;
		var karyawan_tglpengajuanawal_search="";
		var karyawan_tglpengajuanakhir_search="";
		var karyawan_cutiketerangan_search=null;
		// GANTIOFF SEARCH		
		var karyawan_tgloffawalawal_search="";
		var karyawan_tgloffawalakhir_search="";
		var karyawan_tgloffakhirawal_search="";
		var karyawan_tgloffakhirakhir_search="";
		var karyawan_jmlharioffawal_search=null;
		var karyawan_jmlharioffakhir_search=null;
		var karyawan_tgloffgantiawalawal_search="";
		var karyawan_tgloffgantiawalakhir_search="";
		var karyawan_tgloffgantiakhirawal_search="";
		var karyawan_tgloffgantiakhirakhir_search="";
		var karyawan_tgloffpengajuanakhirawal_search="";
		var karyawan_tgloffpengajuanakhirakhir_search="";
		var karyawan_offketerangan_search=null;
		// MEDICAL SEARCH
		var karyawan_tujuanklaim_search=null;
		var karyawan_jenisrawat_search=null;
		var karyawan_jenisklaim_search=null;
		var karyawan_jmlkuitansiawal_search=null;
		var karyawan_jmlkuitansiakhir_search=null;
		var karyawan_totalkuitansiawal_search=null;
		var karyawan_totalkuitansiakhir_search=null;
		var karyawan_tglmedicalpengajuanawal_search="";
		var karyawan_tglmedicalpengajuanakhir_search="";
		var karyawan_tglmedicalkuitansiawal_search="";
		var karyawan_tglmedicalkuitansiakhir_search="";
		var karyawan_medicalketerangan_search=null;
		// FASILITAS SEARCH
		var karyawan_fasilitasitem_search=null;
		var karyawan_tglserahterimaawal_search="";
		var karyawan_tglserahterimaakhir_search="";
		var karyawan_fasilitasketerangan_search=null;
		// GENERAL SEARCH
		if(karyawan_idSearchField.getValue()!==null){karyawan_id_search=karyawan_idSearchField.getValue();}
		if(karyawan_noSearchField.getValue()!==null){karyawan_no_search=karyawan_noSearchField.getValue();}
		if(karyawan_cabangSearchField.getValue()!==null){karyawan_cabang_search=karyawan_cabangSearchField.getValue();}
		if(karyawan_noktpSearchField.getValue()!==null){karyawan_noktp_search=karyawan_noktpSearchField.getValue();}
		if(karyawan_alamatktpSearchField.getValue()!==null){karyawan_alamatktp_search=karyawan_alamatktpSearchField.getValue();}
		if(karyawan_agamaSearchField.getValue()!==null){karyawan_agama_search=karyawan_agamaSearchField.getValue();}
		if(karyawan_npwpSearchField.getValue()!==null){karyawan_npwp_search=karyawan_npwpSearchField.getValue();}
		if(karyawan_jamsostekSearchField.getValue()!==null){karyawan_jamsostek_search=karyawan_jamsostekSearchField.getValue();}
		if(karyawan_sipSearchField.getValue()!==null){karyawan_sip_search=karyawan_sipSearchField.getValue();}
		if(karyawan_usernameSearchField.getValue()!==null){karyawan_username_search=karyawan_usernameSearchField.getValue();}
		if(karyawan_namaSearchField.getValue()!==null){karyawan_nama_search=karyawan_namaSearchField.getValue();}
		if(karyawan_kelaminSearchField.getValue()!==null){karyawan_kelamin_search=karyawan_kelaminSearchField.getValue();}
		if(karyawan_marriageSearchField.getValue()!==null){karyawan_marriage_search=karyawan_marriageSearchField.getValue();}
		if(karyawan_jmlanakSearchField.getValue()!==null){karyawan_jmlanak_search=karyawan_jmlanakSearchField.getValue();}
		if(karyawan_tglmasukSearchField.getValue()!==""){karyawan_tglmasuk_search_date=karyawan_tglmasukSearchField.getValue().format('Y-m-d');}
		if(karyawan_aktifSearchField.getValue()!==null){karyawan_aktif_search=karyawan_aktifSearchField.getValue();}
		// TEMPAT TANGGAL LAHIR SEARCH
		if(karyawan_tempatlahirSearchField.getValue()!==null){karyawan_tempatlahir_search=karyawan_tempatlahirSearchField.getValue();}
		if(karyawan_tgllahirawalSearchField.getValue()!==""){karyawan_tgllahirawal_search=karyawan_tgllahirawalSearchField.getValue().format('Y-m-d');}
		if(karyawan_tgllahirakhirSearchField.getValue()!==""){karyawan_tgllahirakhir_search=karyawan_tgllahirakhirSearchField.getValue().format('Y-m-d');}
		if(karyawan_tgllahirSearchField.getValue()!==null){karyawan_tgllahir_search=karyawan_tgllahirSearchField.getValue();}
		if(karyawan_blnlahirSearchField.getValue()!==null){karyawan_blnlahir_search=karyawan_blnlahirSearchField.getValue();}
		// ALAMAT SEARCH
		if(karyawan_alamatSearchField.getValue()!==null){karyawan_alamat_search=karyawan_alamatSearchField.getValue();}
		if(karyawan_kotaSearchField.getValue()!==null){karyawan_kota_search=karyawan_kotaSearchField.getValue();}
		if(karyawan_kodeposSearchField.getValue()!==null){karyawan_kodepos_search=karyawan_kodeposSearchField.getValue();}
		if(karyawan_emailSearchField.getValue()!==null){karyawan_email_search=karyawan_emailSearchField.getValue();}
		//if(karyawan_emiracleSearchField.getValue()!==null){karyawan_emiracle_search=karyawan_emiracleSearchField.getValue();}
		if(karyawan_keteranganSearchField.getValue()!==null){karyawan_keterangan_search=karyawan_keteranganSearchField.getValue();}
		if(karyawan_notelpSearchField.getValue()!==null){karyawan_notelp_search=karyawan_notelpSearchField.getValue();}
		//if(karyawan_notelp2SearchField.getValue()!==null){karyawan_notelp2_search=karyawan_notelp2SearchField.getValue();}
		//if(karyawan_notelp3SearchField.getValue()!==null){karyawan_notelp3_search=karyawan_notelp3SearchField.getValue();}
		//if(karyawan_notelp4SearchField.getValue()!==null){karyawan_notelp4_search=karyawan_notelp4SearchField.getValue();}
		// INFO REKENING SEARCH
		if(karyawan_bankSearchField.getValue()!==null){karyawan_bank_search=karyawan_bankSearchField.getValue();}
		if(karyawan_bankcabangSearchField.getValue()!==null){karyawan_bankcabang_search=karyawan_bankcabangSearchField.getValue();}
		if(karyawan_norekeningSearchField.getValue()!==null){karyawan_norekening_search=karyawan_norekeningSearchField.getValue();}
		if(karyawan_atasnamaSearchField.getValue()!==null){karyawan_atasnama_search=karyawan_atasnamaSearchField.getValue();}
		// STATUS KEKARYAWANAN SEARCH
		if(karyawan_statuskekaryawananSearchField.getValue()!==null){karyawan_statuskekaryawanan_search=karyawan_statuskekaryawananSearchField.getValue();}
		if(karyawan_statustglawalawalSearchField.getValue()!==""){karyawan_statustglawalawal_search=karyawan_statustglawalawalSearchField.getValue().format('Y-m-d');}
		if(karyawan_statustglawalakhirSearchField.getValue()!==""){karyawan_statustglawalakhir_search=karyawan_statustglawalakhirSearchField.getValue().format('Y-m-d');}
		if(karyawan_statustglakhirawalSearchField.getValue()!==""){karyawan_statustglakhirawal_search=karyawan_statustglakhirawalSearchField.getValue().format('Y-m-d');}
		if(karyawan_statustglakhirakhirSearchField.getValue()!==""){karyawan_statustglakhirakhir_search=karyawan_statustglakhirakhirSearchField.getValue().format('Y-m-d');}
		if(karyawan_statuskaryawanSearchField.getValue()!==null){karyawan_statuskaryawan_search=karyawan_statuskaryawanSearchField.getValue();}
		// JABATAN SEARCH
		if(karyawan_jabatanSearchField.getValue()!==null){karyawan_jabatan_search=karyawan_jabatanSearchField.getValue();}
		if(karyawan_departemenSearchField.getValue()!==null){karyawan_departemen_search=karyawan_departemenSearchField.getValue();}
		if(karyawan_golonganSearchField.getValue()!==null){karyawan_golongan_search=karyawan_golonganSearchField.getValue();}
		if(karyawan_atasanSearchField.getValue()!==null){karyawan_atasan_search=karyawan_atasanSearchField.getValue();}
		if(karyawan_pph21SearchField.getValue()!==null){karyawan_pph21_search=karyawan_pph21SearchField.getValue();}
		if(karyawan_tgljbtawalawalSearchField.getValue()!==""){karyawan_tgljbtawalawal_search=karyawan_tgljbtawalawalSearchField.getValue().format('Y-m-d');}
		if(karyawan_tgljbtawalakhirSearchField.getValue()!==""){karyawan_tgljbtawalakhir_search=karyawan_tgljbtawalakhirSearchField.getValue().format('Y-m-d');}
		if(karyawan_tgljbtakhirawalSearchField.getValue()!==""){karyawan_tgljbtakhirawal_search=karyawan_tgljbtakhirawalSearchField.getValue().format('Y-m-d');}
		if(karyawan_tgljbtakhirakhirSearchField.getValue()!==""){karyawan_tgljbtakhirakhir_search=karyawan_tgljbtakhirakhirSearchField.getValue().format('Y-m-d');}
		if(karyawan_jabatanketeranganSearchField.getValue()!==null){karyawan_jabatanketerangan_search=karyawan_jabatanketeranganSearchField.getValue();}
		// PENDIDIKAN SEARCH
		if(karyawan_pendidikanSearchField.getValue()!==null){karyawan_pendidikan_search=karyawan_pendidikanSearchField.getValue();}
		if(karyawan_namasekolahSearchField.getValue()!==null){karyawan_namasekolah_search=karyawan_namasekolahSearchField.getValue();}
		if(karyawan_jurusanSearchField.getValue()!==null){karyawan_jurusan_search=karyawan_jurusanSearchField.getValue();}
		if(karyawan_thnmskawalSearchField.getValue()!==null){karyawan_thnmskawal_search=karyawan_thnmskawalSearchField.getValue();}
		if(karyawan_thnmskakhirSearchField.getValue()!==null){karyawan_thnmskakhir_search=karyawan_thnmskakhirSearchField.getValue();}
		if(karyawan_thnslsawalSearchField.getValue()!==null){karyawan_thnslsawal_search=karyawan_thnslsawalSearchField.getValue();}
		if(karyawan_thnslsakhirSearchField.getValue()!==null){karyawan_thnslsakhir_search=karyawan_thnslsakhirSearchField.getValue();}
		if(karyawan_wisudaawalSearchField.getValue()!==null){karyawan_wisudaawal_search=karyawan_wisudaawalSearchField.getValue();}
		if(karyawan_wisudaakhirSearchField.getValue()!==null){karyawan_wisudaakhir_search=karyawan_wisudaakhirSearchField.getValue();}
		if(karyawan_pendidikanketeranganSearchField.getValue()!==null){karyawan_pendidikanketerangan_search=karyawan_pendidikanketeranganSearchField.getValue();}	
		// CUTI SEARCH
		if(karyawan_jeniscutiSearchField.getValue()!==""){karyawan_jeniscuti_search=karyawan_jeniscutiSearchField.getValue();}
		if(karyawan_tglcutiawalawalSearchField.getValue()!==""){karyawan_tglcutiawalawal_search=karyawan_tglcutiawalawalSearchField.getValue().format('Y-m-d');}
		if(karyawan_tglcutiawalakhirSearchField.getValue()!==""){karyawan_tglcutiawalakhir_search=karyawan_tglcutiawalakhirSearchField.getValue().format('Y-m-d');}
		if(karyawan_tglcutiakhirawalSearchField.getValue()!==""){karyawan_tglcutiakhirawal_search=karyawan_tglcutiakhirawalSearchField.getValue().format('Y-m-d');}
		if(karyawan_tglcutiakhirakhirSearchField.getValue()!==""){karyawan_tglcutiakhirakhir_search=karyawan_tglcutiakhirakhirSearchField.getValue().format('Y-m-d');}
		if(karyawan_jmlharicutiawalSearchField.getValue()!==null){karyawan_jmlharicutiawal_search=karyawan_jmlharicutiawalSearchField.getValue();}
		if(karyawan_jmlharicutiakhirSearchField.getValue()!==null){karyawan_jmlharicutiakhir_search=karyawan_jmlharicutiakhirSearchField.getValue();}
		if(karyawan_tglpengajuanawalSearchField.getValue()!==""){karyawan_tglpengajuanawal_search=karyawan_tglpengajuanawalSearchField.getValue().format('Y-m-d');}
		if(karyawan_tglpengajuanakhirSearchField.getValue()!==""){karyawan_tglpengajuanakhir_search=karyawan_tglpengajuanakhirSearchField.getValue().format('Y-m-d');}
		if(karyawan_cutiketeranganSearchField.getValue()!==null){karyawan_cutiketerangan_search=karyawan_cutiketeranganSearchField.getValue();}	
		// GANTIOFF SEARCH
		if(karyawan_tgloffawalawalSearchField.getValue()!==""){karyawan_tgloffawalawal_search=karyawan_tgloffawalawalSearchField.getValue().format('Y-m-d');}
		if(karyawan_tgloffawalakhirSearchField.getValue()!==""){karyawan_tgloffawalakhir_search=karyawan_tgloffawalakhirSearchField.getValue().format('Y-m-d');}
		if(karyawan_tgloffakhirawalSearchField.getValue()!==""){karyawan_tgloffakhirawal_search=karyawan_tgloffakhirawalSearchField.getValue().format('Y-m-d');}
		if(karyawan_tgloffakhirakhirSearchField.getValue()!==""){karyawan_tgloffakhirakhir_search=karyawan_tgloffakhirakhirSearchField.getValue().format('Y-m-d');}
		if(karyawan_jmlharioffawalSearchField.getValue()!==null){karyawan_jmlharioffawal_search=karyawan_jmlharioffawalSearchField.getValue();}
		if(karyawan_jmlharioffakhirSearchField.getValue()!==null){karyawan_jmlharioffakhir_search=karyawan_jmlharioffakhirSearchField.getValue();}
		if(karyawan_tgloffgantiawalawalSearchField.getValue()!==""){karyawan_tgloffgantiawalawal_search=karyawan_tgloffgantiawalawalSearchField.getValue().format('Y-m-d');}
		if(karyawan_tgloffgantiawalakhirSearchField.getValue()!==""){karyawan_tgloffgantiawalakhir_search=karyawan_tgloffgantiawalakhirSearchField.getValue().format('Y-m-d');}
		if(karyawan_tgloffgantiakhirawalSearchField.getValue()!==""){karyawan_tgloffgantiakhirawal_search=karyawan_tgloffgantiakhirawalSearchField.getValue().format('Y-m-d');}
		if(karyawan_tgloffgantiakhirakhirSearchField.getValue()!==""){karyawan_tgloffgantiakhirakhir_search=karyawan_tgloffgantiakhirakhirSearchField.getValue().format('Y-m-d');}
		if(karyawan_tgloffpengajuanakhirawalSearchField.getValue()!==""){karyawan_tgloffpengajuanakhirawal_search=karyawan_tgloffpengajuanakhirawalSearchField.getValue().format('Y-m-d');}
		if(karyawan_tgloffpengajuanakhirakhirSearchField.getValue()!==""){karyawan_tgloffpengajuanakhirakhir_search=karyawan_tgloffpengajuanakhirakhirSearchField.getValue().format('Y-m-d');}
		if(karyawan_offketeranganSearchField.getValue()!==null){karyawan_offketerangan_search=karyawan_offketeranganSearchField.getValue();}
		// MEDICAL SEARCH
		if(karyawan_tujuanklaimSearchField.getValue()!==null){karyawan_tujuanklaim_search=karyawan_tujuanklaimSearchField.getValue();}
		if(karyawan_jenisrawatSearchField.getValue()!==null){karyawan_jenisrawat_search=karyawan_jenisrawatSearchField.getValue();}
		if(karyawan_jenisklaimSearchField.getValue()!==null){karyawan_jenisklaim_search=karyawan_jenisklaimSearchField.getValue();}
		if(karyawan_jmlkuitansiawalSearchField.getValue()!==null){karyawan_jmlkuitansiawal_search=karyawan_jmlkuitansiawalSearchField.getValue();}
		if(karyawan_jmlkuitansiakhirSearchField.getValue()!==null){karyawan_jmlkuitansiakhir_search=karyawan_jmlkuitansiakhirSearchField.getValue();}
		if(karyawan_totalkuitansiawalSearchField.getValue()!==null){karyawan_totalkuitansiawal_search=karyawan_totalkuitansiawalSearchField.getValue();}
		if(karyawan_totalkuitansiakhirSearchField.getValue()!==null){karyawan_totalkuitansiakhir_search=karyawan_totalkuitansiakhirSearchField.getValue();}
		if(karyawan_tglmedicalpengajuanawalSearchField.getValue()!==""){karyawan_tglmedicalpengajuanawal_search=karyawan_tglmedicalpengajuanawalSearchField.getValue().format('Y-m-d');}
		if(karyawan_tglmedicalpengajuanakhirSearchField.getValue()!==""){karyawan_tglmedicalpengajuanakhir_search=karyawan_tglmedicalpengajuanakhirSearchField.getValue().format('Y-m-d');}
		if(karyawan_tglmedicalkuitansiawalSearchField.getValue()!==""){karyawan_tglmedicalkuitansiawal_search=karyawan_tglmedicalkuitansiawalSearchField.getValue().format('Y-m-d');}
		if(karyawan_tglmedicalkuitansiakhirSearchField.getValue()!==""){karyawan_tglmedicalkuitansiakhir_search=karyawan_tglmedicalkuitansiakhirSearchField.getValue().format('Y-m-d');}
		if(karyawan_medicalketeranganSearchField.getValue()!==null){karyawan_medicalketerangan_search=karyawan_medicalketeranganSearchField.getValue();}
		// FASILITAS SEARCH
		if(karyawan_fasilitasitemSearchField.getValue()!==null){karyawan_fasilitasitem_search=karyawan_fasilitasitemSearchField.getValue();}
		if(karyawan_tglserahterimaawalSearchField.getValue()!==""){karyawan_tglserahterimaawal_search=karyawan_tglserahterimaawalSearchField.getValue().format('Y-m-d');}
		if(karyawan_tglserahterimaakhirSearchField.getValue()!==""){karyawan_tglserahterimaakhir_search=karyawan_tglserahterimaakhirSearchField.getValue().format('Y-m-d');}
		if(karyawan_fasilitasketeranganSearchField.getValue()!==null){karyawan_fasilitasketerangan_search=karyawan_fasilitasketeranganSearchField.getValue();}
		
		// change the store parameters
		karyawan_DataStore.baseParams = {
			task: 'SEARCH',
			start: 0,
			limit: karyawan_pageS,
			//variable here
			// GENERAL SEARCH
			karyawan_id				:	karyawan_id_search, 
			karyawan_cabang			:	karyawan_cabang_search, 
			karyawan_no				:	karyawan_no_search, 
			karyawan_noktp			:	karyawan_noktp_search, 
			karyawan_alamatktp		:	karyawan_alamatktp_search, 
			karyawan_npwp			:	karyawan_npwp_search, 
			karyawan_jamsostek		:	karyawan_jamsostek_search, 
			karyawan_sip			:	karyawan_sip_search, 
			karyawan_username		:	karyawan_username_search, 
			karyawan_nama			:	karyawan_nama_search, 
			karyawan_kelamin		:	karyawan_kelamin_search, 
			karyawan_marriage		:	karyawan_marriage_search,
			karyawan_agama			:	karyawan_agama_search,
			karyawan_jmlanak		:	karyawan_jmlanak_search, 
			karyawan_tglmasuk		:	karyawan_tglmasuk_search_date, 
			karyawan_aktif			:	karyawan_aktif_search,
			// TEMPAT TANGGAL LAHIR SEARCH
			karyawan_tempatlahir	:	karyawan_tempatlahir_search,
			karyawan_tgllahirawal	:	karyawan_tgllahirawal_search,
			karyawan_tgllahirakhir	:	karyawan_tgllahirakhir_search,
			karyawan_tgllahir		:	karyawan_tgllahir_search,
			karyawan_blnlahir		:	karyawan_blnlahir_search,
			// ALAMAT & KONTAK SEARCH
			karyawan_alamat			:	karyawan_alamat_search, 
			karyawan_kota			:	karyawan_kota_search, 
			karyawan_kodepos		:	karyawan_kodepos_search, 
			karyawan_email			:	karyawan_email_search, 
			karyawan_keterangan		:	karyawan_keterangan_search, 
			karyawan_notelp			:	karyawan_notelp_search, 
			// INFO REKENING SEARCH
			karyawan_bank			:	karyawan_bank_search, 
			karyawan_bankcabang		:	karyawan_bankcabang_search, 
			karyawan_norekening		:	karyawan_norekening_search, 
			karyawan_atasnama		:	karyawan_atasnama_search, 
			// STATUS KEKARYAWANAN SEARCH
			karyawan_statuskekaryawanan		:	karyawan_statuskekaryawanan_search, 
			karyawan_statustglawalawal		:	karyawan_statustglawalawal_search, 
			karyawan_statustglawalakhir		:	karyawan_statustglawalakhir_search, 
			karyawan_statustglakhirawal		:	karyawan_statustglakhirawal_search, 
			karyawan_statustglakhirakhir	:	karyawan_statustglakhirakhir_search, 
			karyawan_statuskaryawan			:	karyawan_statuskaryawan_search, 
			// JABATAN SEARCH
			karyawan_jabatan			:	karyawan_jabatan_search, 
			karyawan_departemen			:	karyawan_departemen_search, 
			karyawan_idgolongan			:	karyawan_golongan_search, 
			karyawan_atasan				:	karyawan_atasan_search,
			karyawan_pph21				:	karyawan_pph21_search,
			karyawan_tgljbtawalawal		:	karyawan_tgljbtawalawal_search,
			karyawan_tgljbtawalakhir	:	karyawan_tgljbtawalakhir_search,
			karyawan_tgljbtakhirawal	:	karyawan_tgljbtakhirawal_search,
			karyawan_tgljbtakhirakhir	:	karyawan_tgljbtakhirakhir_search,
			karyawan_jabatanketerangan	:	karyawan_jabatanketerangan_search,
			// PENDIDIKAN SEARCH
			karyawan_pendidikan				:	karyawan_pendidikan_search,
			karyawan_namasekolah			:	karyawan_namasekolah_search,
			karyawan_jurusan				:	karyawan_jurusan_search,
			karyawan_thnmskawal				:	karyawan_thnmskawal_search,
			karyawan_thnmskakhir			:	karyawan_thnmskakhir_search,
			karyawan_thnslsawal				:	karyawan_thnslsawal_search,
			karyawan_thnslsakhir			:	karyawan_thnslsakhir_search,
			karyawan_wisudaawal				:	karyawan_wisudaawal_search,
			karyawan_wisudaakhir			:	karyawan_wisudaakhir_search,
			karyawan_pendidikanketerangan	:	karyawan_pendidikanketerangan_search,
			// CUTI SEARCH
			karyawan_jeniscuti			:	karyawan_jeniscuti_search,
			karyawan_tglcutiawalawal	:	karyawan_tglcutiawalawal_search,
			karyawan_tglcutiawalakhir	:	karyawan_tglcutiawalakhir_search,
			karyawan_tglcutiakhirawal	:	karyawan_tglcutiakhirawal_search,
			karyawan_tglcutiakhirakhir	:	karyawan_tglcutiakhirakhir_search,
			karyawan_jmlharicutiawal	:	karyawan_jmlharicutiawal_search,
			karyawan_jmlharicutiakhir	:	karyawan_jmlharicutiakhir_search,
			karyawan_tglpengajuanawal	:	karyawan_tglpengajuanawal_search,
			karyawan_tglpengajuanakhir	:	karyawan_tglpengajuanakhir_search,
			karyawan_cutiketerangan		:	karyawan_cutiketerangan_search,
			// GANTIOFF SEARCH
			karyawan_tgloffawalawal				:	karyawan_tgloffawalawal_search,
			karyawan_tgloffawalakhir			:	karyawan_tgloffawalakhir_search,
			karyawan_tgloffakhirawal			:	karyawan_tgloffakhirawal_search,
			karyawan_tgloffakhirakhir			:	karyawan_tgloffakhirakhir_search,
			karyawan_jmlharioffawal				:	karyawan_jmlharioffawal_search,
			karyawan_jmlharioffakhir			:	karyawan_jmlharioffakhir_search,
			karyawan_tgloffgantiawalawal		:	karyawan_tgloffgantiawalawal_search,
			karyawan_tgloffgantiawalakhir		:	karyawan_tgloffgantiawalakhir_search,
			karyawan_tgloffgantiakhirawal		:	karyawan_tgloffgantiakhirawal_search,
			karyawan_tgloffgantiakhirakhir		:	karyawan_tgloffgantiakhirakhir_search,
			karyawan_tgloffpengajuanakhirawal	:	karyawan_tgloffpengajuanakhirawal_search,
			karyawan_tgloffpengajuanakhirakhir	:	karyawan_tgloffpengajuanakhirakhir_search,
			karyawan_offketerangan				:	karyawan_offketerangan_search,
			// MEDICAL SEARCH
			karyawan_tujuanklaim				:	karyawan_tujuanklaim_search,
			karyawan_jenisrawat					:	karyawan_jenisrawat_search,
			karyawan_jenisklaim					:	karyawan_jenisklaim_search,
			karyawan_jmlkuitansiawal			:	karyawan_jmlkuitansiawal_search,
			karyawan_jmlkuitansiakhir			:	karyawan_jmlkuitansiakhir_search,
			karyawan_totalkuitansiawal			:	karyawan_totalkuitansiawal_search,
			karyawan_totalkuitansiakhir			:	karyawan_totalkuitansiakhir_search,
			karyawan_tglmedicalpengajuanawal	:	karyawan_tglmedicalpengajuanawal_search,
			karyawan_tglmedicalpengajuanakhir	:	karyawan_tglmedicalpengajuanakhir_search,
			karyawan_tglmedicalkuitansiawal		:	karyawan_tglmedicalkuitansiawal_search,
			karyawan_tglmedicalkuitansiakhir	:	karyawan_tglmedicalkuitansiakhir_search,
			karyawan_medicalketerangan			:	karyawan_medicalketerangan_search,
			// FASILITAS SEARCH
			karyawan_fasilitasitem			:	karyawan_fasilitasitem_search,
			karyawan_tglserahterimaawal		:	karyawan_tglserahterimaawal_search,
			karyawan_tglserahterimaakhir	:	karyawan_tglserahterimaakhir_search,
			karyawan_fasilitasketerangan	:	karyawan_fasilitasketerangan_search,
		};
		// Cause the datastore to do another query : 
		karyawan_DataStore.reload({params: {start: 0, limit: karyawan_pageS}});
	}
		
	/* Function for reset search result */
	function karyawan_reset_search(){
		// reset the store parameters
		karyawan_DataStore.baseParams = { task: 'LIST',start:0, limit: karyawan_pageS };
		// Cause the datastore to do another query : 
		karyawan_DataStore.reload({params: {start: 0, limit: karyawan_pageS}});
		cbo_karyawan_cabang_DataStore.reload();
		cbo_karyawan_departemen_DataStore.reload();
		cbo_karyawan_golongan_DataStore.reload();
		cbo_karyawan_jabatan_DataStore.reload();
		cbo_karyawan_bank_DataStore.reload();
		cbo_karyawan_atasan_DataStore.reload();

		//karyawan_searchWindow.close();
	};
	/* End of Fuction */
	
	function karyawan_reset_SearchForm(){
		// GENERAL SEARCH
		karyawan_noSearchField.reset();
		karyawan_noSearchField.setValue(null);
		karyawan_cabangSearchField.reset();
		karyawan_cabangSearchField.setValue(null);
		karyawan_noktpSearchField.reset();
		karyawan_noktpSearchField.setValue(null);
		karyawan_alamatktpSearchField.reset();
		karyawan_alamatktpSearchField.setValue(null);
		karyawan_agamaSearchField.reset();
		karyawan_agamaSearchField.setValue(null);
		karyawan_npwpSearchField.reset();
		karyawan_npwpSearchField.setValue(null);
		karyawan_jamsostekSearchField.reset();
		karyawan_jamsostekSearchField.setValue(null);
		karyawan_sipSearchField.reset();
		karyawan_sipSearchField.setValue(null);
		karyawan_usernameSearchField.reset();
		karyawan_usernameSearchField.setValue(null);
		karyawan_namaSearchField.reset();
		karyawan_namaSearchField.setValue(null);
		karyawan_kelaminSearchField.reset();
		karyawan_kelaminSearchField.setValue(null);
		karyawan_marriageSearchField.reset();
		karyawan_marriageSearchField.setValue(null);
		karyawan_jmlanakSearchField.reset();
		karyawan_jmlanakSearchField.setValue(null);
		karyawan_tglmasukSearchField.reset();
		karyawan_tglmasukSearchField.setValue(null);
		karyawan_aktifSearchField.reset();
		karyawan_aktifSearchField.setValue(null);
		// TEMPAT TANGGAL LAHIR SEARCH
		karyawan_tempatlahirSearchField.reset();
		karyawan_tempatlahirSearchField.setValue(null);
		karyawan_tgllahirawalSearchField.reset();
		karyawan_tgllahirawalSearchField.setValue(null);
		karyawan_tgllahirakhirSearchField.reset();
		karyawan_tgllahirakhirSearchField.setValue(null);
		karyawan_tgllahirSearchField.reset();
		karyawan_tgllahirSearchField.setValue(null);
		karyawan_blnlahirSearchField.reset();
		karyawan_blnlahirSearchField.setValue(null);
		// ALAMAT SEARCH
		karyawan_alamatSearchField.reset();
		karyawan_alamatSearchField.setValue(null);
		karyawan_kotaSearchField.reset();
		karyawan_kotaSearchField.setValue(null);
		karyawan_kodeposSearchField.reset();
		karyawan_kodeposSearchField.setValue(null);
		karyawan_emailSearchField.reset();
		karyawan_emailSearchField.setValue(null);
		//karyawan_emiracleSearchField.reset();
		//karyawan_emiracleSearchField.setValue(null);
		karyawan_keteranganSearchField.reset();
		karyawan_keteranganSearchField.setValue(null);
		karyawan_notelpSearchField.reset();
		karyawan_notelpSearchField.setValue(null);
		//karyawan_notelp2SearchField.reset();
		//karyawan_notelp2SearchField.setValue(null);
		//karyawan_notelp3SearchField.reset();
		//karyawan_notelp3SearchField.setValue(null);
		//karyawan_notelp4SearchField.reset();
		//karyawan_notelp4SearchField.setValue(null);
		// INFO REKENING SEARCH
		karyawan_bankSearchField.reset();
		karyawan_bankSearchField.setValue(null);
		karyawan_bankcabangSearchField.reset();
		karyawan_bankcabangSearchField.setValue(null);
		karyawan_norekeningSearchField.reset();
		karyawan_norekeningSearchField.setValue(null);
		karyawan_atasnamaSearchField.reset();
		karyawan_atasnamaSearchField.setValue(null);
		// STATUS KEKARYAWANAN SEARCH
		karyawan_statuskekaryawananSearchField.reset();
		karyawan_statuskekaryawananSearchField.setValue(null);
		karyawan_statustglawalawalSearchField.reset();
		karyawan_statustglawalawalSearchField.setValue(null);
		karyawan_statustglawalakhirSearchField.reset();
		karyawan_statustglawalakhirSearchField.setValue(null);
		karyawan_statustglakhirawalSearchField.reset();
		karyawan_statustglakhirawalSearchField.setValue(null);
		karyawan_statustglakhirakhirSearchField.reset();
		karyawan_statustglakhirakhirSearchField.setValue(null);
		karyawan_statuskaryawanSearchField.reset();
		karyawan_statuskaryawanSearchField.setValue(null);
		// JABATAN SEARCH
		karyawan_jabatanSearchField.reset();
		karyawan_jabatanSearchField.setValue(null);
		karyawan_departemenSearchField.reset();
		karyawan_departemenSearchField.setValue(null);
		karyawan_golonganSearchField.reset();
		karyawan_golonganSearchField.setValue(null);
		karyawan_atasanSearchField.reset();
		karyawan_atasanSearchField.setValue(null);
		karyawan_pph21SearchField.reset();
		karyawan_pph21SearchField.setValue(null);
		karyawan_tgljbtawalawalSearchField.reset();
		karyawan_tgljbtawalawalSearchField.setValue(null);
		karyawan_tgljbtawalakhirSearchField.reset();
		karyawan_tgljbtawalakhirSearchField.setValue(null);
		karyawan_tgljbtakhirawalSearchField.reset();
		karyawan_tgljbtakhirawalSearchField.setValue(null);
		karyawan_tgljbtakhirakhirSearchField.reset();
		karyawan_tgljbtakhirakhirSearchField.setValue(null);
		karyawan_jabatanketeranganSearchField.reset();
		karyawan_jabatanketeranganSearchField.setValue(null);
		
		// PENDIDIKAN SEARCH
		karyawan_pendidikanSearchField.reset();
		karyawan_pendidikanSearchField.setValue(null);
		karyawan_namasekolahSearchField.reset();
		karyawan_namasekolahSearchField.setValue(null);
		karyawan_jurusanSearchField.reset();
		karyawan_jurusanSearchField.setValue(null);
		karyawan_thnmskawalSearchField.reset();
		karyawan_thnmskawalSearchField.setValue(null);
		karyawan_thnmskakhirSearchField.reset();
		karyawan_thnmskakhirSearchField.setValue(null);
		karyawan_thnslsawalSearchField.reset();
		karyawan_thnslsawalSearchField.setValue(null);
		karyawan_thnslsakhirSearchField.reset();
		karyawan_thnslsakhirSearchField.setValue(null);
		karyawan_wisudaawalSearchField.reset();
		karyawan_wisudaawalSearchField.setValue(null);
		karyawan_wisudaakhirSearchField.reset();
		karyawan_wisudaakhirSearchField.setValue(null);
		karyawan_pendidikanketeranganSearchField.reset();
		karyawan_pendidikanketeranganSearchField.setValue(null);
		
		// CUTI SEARCH
		karyawan_jeniscutiSearchField.reset();
		karyawan_jeniscutiSearchField.setValue(null);
		karyawan_tglcutiawalawalSearchField.reset();
		karyawan_tglcutiawalawalSearchField.setValue(null);
		karyawan_tglcutiawalakhirSearchField.reset();
		karyawan_tglcutiawalakhirSearchField.setValue(null);
		karyawan_tglcutiakhirawalSearchField.reset();
		karyawan_tglcutiakhirawalSearchField.setValue(null);
		karyawan_tglcutiakhirakhirSearchField.reset();
		karyawan_tglcutiakhirakhirSearchField.setValue(null);
		karyawan_jmlharicutiawalSearchField.reset();
		karyawan_jmlharicutiawalSearchField.setValue(null);
		karyawan_jmlharicutiakhirSearchField.reset();
		karyawan_jmlharicutiakhirSearchField.setValue(null);
		karyawan_tglpengajuanawalSearchField.reset();
		karyawan_tglpengajuanawalSearchField.setValue(null);
		karyawan_tglpengajuanakhirSearchField.reset();
		karyawan_tglpengajuanakhirSearchField.setValue(null);
		karyawan_cutiketeranganSearchField.reset();
		karyawan_cutiketeranganSearchField.setValue(null);
		
		// GANTIOFF SEARCH
		karyawan_tgloffawalawalSearchField.reset();
		karyawan_tgloffawalawalSearchField.setValue(null);
		karyawan_tgloffawalakhirSearchField.reset();
		karyawan_tgloffawalakhirSearchField.setValue(null);
		karyawan_tgloffakhirawalSearchField.reset();
		karyawan_tgloffakhirawalSearchField.setValue(null);
		karyawan_tgloffakhirakhirSearchField.reset();
		karyawan_tgloffakhirakhirSearchField.setValue(null);
		karyawan_jmlharioffawalSearchField.reset();
		karyawan_jmlharioffawalSearchField.setValue(null);
		karyawan_jmlharioffakhirSearchField.reset();
		karyawan_jmlharioffakhirSearchField.setValue(null);
		karyawan_tgloffgantiawalawalSearchField.reset();
		karyawan_tgloffgantiawalawalSearchField.setValue(null);
		karyawan_tgloffgantiawalakhirSearchField.reset();
		karyawan_tgloffgantiawalakhirSearchField.setValue(null);
		karyawan_tgloffgantiakhirawalSearchField.reset();
		karyawan_tgloffgantiakhirawalSearchField.setValue(null);
		karyawan_tgloffgantiakhirakhirSearchField.reset();
		karyawan_tgloffgantiakhirakhirSearchField.setValue(null);
		karyawan_tgloffpengajuanakhirawalSearchField.reset();
		karyawan_tgloffpengajuanakhirawalSearchField.setValue(null);
		karyawan_tgloffpengajuanakhirakhirSearchField.reset();
		karyawan_tgloffpengajuanakhirakhirSearchField.setValue(null);
		karyawan_offketeranganSearchField.reset();
		karyawan_offketeranganSearchField.setValue(null);
		
		// MEDICAL SEARCH
		karyawan_tujuanklaimSearchField.reset();
		karyawan_tujuanklaimSearchField.setValue(null);
		karyawan_jenisrawatSearchField.reset();
		karyawan_jenisrawatSearchField.setValue(null);
		karyawan_jenisklaimSearchField.reset();
		karyawan_jenisklaimSearchField.setValue(null);
		karyawan_jmlkuitansiawalSearchField.reset();
		karyawan_jmlkuitansiawalSearchField.setValue(null);
		karyawan_jmlkuitansiakhirSearchField.reset();
		karyawan_jmlkuitansiakhirSearchField.setValue(null);
		karyawan_totalkuitansiawalSearchField.reset();
		karyawan_totalkuitansiawalSearchField.setValue(null);
		karyawan_totalkuitansiakhirSearchField.reset();
		karyawan_totalkuitansiakhirSearchField.setValue(null);
		karyawan_tglmedicalpengajuanawalSearchField.reset();
		karyawan_tglmedicalpengajuanawalSearchField.setValue(null);
		karyawan_tglmedicalpengajuanakhirSearchField.reset();
		karyawan_tglmedicalpengajuanakhirSearchField.setValue(null);
		karyawan_tglmedicalkuitansiawalSearchField.reset();
		karyawan_tglmedicalkuitansiawalSearchField.setValue(null);
		karyawan_tglmedicalkuitansiakhirSearchField.reset();
		karyawan_tglmedicalkuitansiakhirSearchField.setValue(null);
		karyawan_medicalketeranganSearchField.reset();
		karyawan_medicalketeranganSearchField.setValue(null);
		
		// FASILITAS SEARCH
		karyawan_fasilitasitemSearchField.reset();
		karyawan_fasilitasitemSearchField.setValue(null);
		karyawan_tglserahterimaawalSearchField.reset();
		karyawan_tglserahterimaawalSearchField.setValue(null);
		karyawan_tglserahterimaakhirSearchField.reset();
		karyawan_tglserahterimaakhirSearchField.setValue(null);
		karyawan_fasilitasketeranganSearchField.reset();
		karyawan_fasilitasketeranganSearchField.setValue(null);

	}
	
	/* Field for search */
	
	// GENERAL SEARCH
	/* Identify  karyawan_id Search Field */
	karyawan_idSearchField= new Ext.form.NumberField({
		id: 'karyawan_idSearchField',
		fieldLabel: 'Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  karyawan_cabang Search Field */
	karyawan_cabangSearchField= new Ext.form.ComboBox({
		id: 'karyawan_cabangSearchField',
		fieldLabel: 'Cabang',
		store:cbo_karyawan_cabang_DataStore,
		mode: 'remote',
		displayField: 'karyawan_cabang_display',
		valueField: 'karyawan_cabang_value',
		allowBlank: true,
		anchor: '95%',
		triggerAction: 'all'
	
	});
	/* Identify  karyawan_no Search Field */
	karyawan_noSearchField= new Ext.form.TextField({
		id: 'karyawan_noSearchField',
		fieldLabel: 'NIK',
		maxLength: 30,
		anchor: '95%'
	
	});
	/* Identify  karyawan_no Search Field */
	karyawan_noktpSearchField= new Ext.form.TextField({
		id: 'karyawan_noktpSearchField',
		fieldLabel: 'No KTP',
		maxLength: 30,
		anchor: '95%'
	});
	/* Identify  karyawan_no Search Field */
	karyawan_alamatktpSearchField= new Ext.form.TextField({
		id: 'karyawan_alamatktpSearchField',
		fieldLabel: 'Alamat KTP',
		maxLength: 250,
		anchor: '95%'
	});
	/* Identify  karyawan_agama Field */
	karyawan_agamaSearchField= new Ext.form.ComboBox({
		id: 'karyawan_agamaSearchField',
		fieldLabel: 'Agama',
		store:new Ext.data.SimpleStore({
			fields:['karyawan_agamaSearch_value', 'karyawan_agamaSearch_display'],
			data:[['Kristen','Kristen'],['Katholik','Katholik'],['Islam','Islam'],['Budha','Budha'],['Hindu','Hindu'],['Kong Hu Chu','Kong Hu Chu']]
		}),
		mode: 'local',
		editable:false,
		allowBlank: true,
		displayField: 'karyawan_agamaSearch_display',
		valueField: 'karyawan_agamaSearch_value',
		width: 100,
		triggerAction: 'all'	
	});
	/* Identify  karyawan_username Search Field */
	karyawan_usernameSearchField= new Ext.form.TextField({
		id: 'karyawan_usernameSearchField',
		fieldLabel: '&nbsp;&nbsp;&nbsp;Nickname',
		maxLength: 15,
		width: 100
	
	});
	/* Identify  karyawan_nama Search Field */
	karyawan_namaSearchField= new Ext.form.TextField({
		id: 'karyawan_namaSearchField',
		fieldLabel: 'Nama Lengkap',
		maxLength: 50,
		anchor: '95%'
	
	});
	/* Identify  karyawan_npwp Search Field */
	karyawan_npwpSearchField= new Ext.form.TextField({
		id: 'karyawan_npwpSearchField',
		fieldLabel: 'NPWP',
		maxLength: 30,
		anchor: '95%'
	
	});
	/*Identify karyawan_sip Field*/
	karyawan_sipSearchField= new Ext.form.TextField({
		id: 'karyawan_sipsSearchField',
		fieldLabel: 'SIP',
		maxLength: 15,
		anchor: '95%'
	});
		/* Identify  karyawan_jamsostek Field */
	karyawan_jamsostekSearchField= new Ext.form.TextField({
		id: 'karyawan_jamsostekSearchField',
		fieldLabel: 'No. Jamsostek',
		maxLength: 40,
		anchor: '95%'
	});
	/* Identify  karyawan_kelamin Search Field */
	karyawan_kelaminSearchField= new Ext.form.ComboBox({
		id: 'karyawan_kelaminSearchField',
		fieldLabel: 'Jenis Kelamin',
		store:new Ext.data.SimpleStore({
			fields:['value', 'karyawan_kelamin'],
			data:[['L','Laki-laki'],['P','Perempuan']]
		}),
		mode: 'local',
		displayField: 'karyawan_kelamin',
		valueField: 'value',
		width: 100,
		triggerAction: 'all'	 
	
	});
	/* Identify  karyawan_marriage Search Field */
	karyawan_marriageSearchField= new Ext.form.ComboBox({
		id: 'karyawan_marriageSearchField',
		fieldLabel: 'Status Pernikahan',
		store:new Ext.data.SimpleStore({
			fields:['value', 'karyawan_marriage'],
			data:[['Single','Single'],['Marriage','Menikah']]
		}),
		mode: 'local',
		displayField: 'karyawan_marriage',
		valueField: 'value',
		width: 80,
		triggerAction: 'all'	 
	
	});
	/* Identify  karyawan_jumlahanak Field */
	karyawan_jmlanakSearchField= new Ext.form.TextField({
		id: 'karyawan_jmlanakSearchField',
		fieldLabel: 'Jml Anak',
		maxLength: 15,
		allowBlank: true,
		disabled: false,
		width: 100
	});
	/* Identify  karyawan_keterangan Search Field */
	karyawan_keteranganSearchField= new Ext.form.TextArea({
		id: 'karyawan_keteranganSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 500,
		anchor: '95%'
	
	});
	/* Identify  karyawan_tglmasuk Search Field */
	karyawan_tglmasukSearchField= new Ext.form.DateField({
		id: 'karyawan_tglmasukSearchField',
		fieldLabel: 'Tanggal Masuk',
		format : 'Y-m-d',
	
	});
	/* Identify  karyawan_aktif Search Field */
	karyawan_aktifSearchField= new Ext.form.ComboBox({
		id: 'karyawan_aktifSearchField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['value', 'karyawan_aktif'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		displayField: 'karyawan_aktif',
		valueField: 'value',
		emptyText: 'Aktif',
		width: 80,
		triggerAction: 'all'	 
	
	});
	//EOF GENERAL SEARCH
	
	// TEMPAT & TANGGAL LAHIR SEARCH
	/* Identify  karyawan_tgllahir Search Field */
	karyawan_tempatlahirSearchField= new Ext.form.TextField({
		id: 'karyawan_tempatlahirSearchField',
		fieldLabel: 'Tempat',
		maxLength: 250,
		anchor: '95%'
	
	});
	karyawan_tgllahirawalSearchField= new Ext.form.DateField({
		id: 'karyawan_tgllahirawalSearchField',
		fieldLabel: 'Tgl Lahir',
		format : 'd-m-Y'
	
	});	
	karyawan_tgllahirakhirSearchField= new Ext.form.DateField({
		id: 'karyawan_tgllahirakhirSearchField',
		fieldLabel: 's/d',
		format : 'd-m-Y'
	
	});	
	karyawan_tgllahirSearchField= new Ext.form.ComboBox({
		id : 'karyawan_tgllahirSearchField',
		fieldLabel: 'Tanggal & Bulan',
		store:new Ext.data.SimpleStore({
			fields:['status_karyawan_value'],
			data: [['1'],['2'],['3'],['4'],['5'],['6'],['7'],['8'],['9'],['10'],['11'],['12'],['13'],['14'],['15'],['16'],['17'],['18'],['19'],['20'],['21'],['22'],['23'],['24'],['25'],['26'],['27'],['28'],['29'],['30'],['31']]
		}),	
		mode: 'local',
		displayField: 'status_karyawan_value',
		valueField: 'status_karyawan_value',
		allowBlank: true,
		anchor: '80%',
		triggerAction: 'all',
		lazyRenderer: true
	});
	karyawan_blnlahirSearchField= new Ext.form.ComboBox({
		id : 'karyawan_blnlahirSearchField',
		fieldLabel: '',
		store:new Ext.data.SimpleStore({
			fields:['status_karyawan_bulan_value', 'status_karyawan_bulan_display'],
			data:[['01','Januari'],['02','Pebruari'],['03','Maret'],['04','April'],['05','Mei'],['06','Juni'],['07','Juli'],['08','Agustus'],['09','September'],['10','Oktober'],['11','Nopember'],['12','Desember']]
		}),
		mode: 'local',
		displayField: 'status_karyawan_bulan_display',
		valueField: 'status_karyawan_bulan_value',
		allowBlank: true,
		width: 100,
		//anchor: '95%',
		triggerAction: 'all',
		lazyRenderer: true
	});
	// EOF TEMPAT & TANGGAL LAHIR SEARCH
	
	// ALAMAT SEARCH
	/* Identify  karyawan_alamat Search Field */
	karyawan_alamatSearchField= new Ext.form.TextField({
		id: 'karyawan_alamatSearchField',
		fieldLabel: 'Alamat Saat Ini',
		maxLength: 250,
		anchor: '95%'
	
	});
	/* Identify  karyawan_kota Search Field */
	karyawan_kotaSearchField= new Ext.form.TextField({
		id: 'karyawan_kotaSearchField',
		fieldLabel: 'Kota',
		maxLength: 30,
		anchor: '95%'
	
	});
	/* Identify  karyawan_kodepos Search Field */
	karyawan_kodeposSearchField= new Ext.form.TextField({
		id: 'karyawan_kodeposSearchField',
		fieldLabel: 'Kode Pos',
		maxLength: 5,
		width: 60,
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  karyawan_email Search Field */
	
	karyawan_emailSearchField= new Ext.form.TextField({
		id: 'karyawan_emailSearchField',
		fieldLabel: 'Email',
		maxLength: 40,
		anchor: '95%'
	
	});
	
	/* Identify  karyawan_emiracle Search Field */
	karyawan_emiracleSearchField= new Ext.form.TextField({
		id: 'karyawan_emiracleSearchField',
		fieldLabel: 'Email Miracle',
		maxLength: 40,
		anchor: '95%'
	
	});
	
	/* Identify  karyawan_notelp Search Field */
	karyawan_notelpSearchField= new Ext.form.TextField({
		id: 'karyawan_notelpSearchField',
		fieldLabel: 'Telp',
		maxLength: 25,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	
	/*
	karyawan_notelp2SearchField= new Ext.form.TextField({
		id: 'karyawan_notelp2SearchField',
		fieldLabel: 'No Ponsel 1',
		maxLength: 25,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	karyawan_notelp3SearchField= new Ext.form.TextField({
		id: 'karyawan_notelp3SearchField',
		fieldLabel: 'No Ponsel 2',
		maxLength: 25,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	karyawan_notelp4SearchField= new Ext.form.TextField({
		id: 'karyawan_notelp4SearchField',
		fieldLabel: 'No Ponsel 3',
		maxLength: 25,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	*/
	// EOF ALAMAT SEARCH
	
	// INFO REKENING SEARCH
	/* Identify  karyawan_bank Field */
	karyawan_bankSearchField= new Ext.form.ComboBox({
		id: 'karyawan_bankSearchField',
		fieldLabel: 'Nama Bank',
		store:cbo_karyawan_bank_DataStore,
		mode: 'remote',
		editable:false,
		allowBlank: true,
		displayField: 'karyawan_bank_display',
		valueField: 'karyawan_bank_value',
		width: 100,
		triggerAction: 'all'	
	});
	/* Identify  karyawan_bankcabang Field */
	karyawan_bankcabangSearchField= new Ext.form.TextField({
		id: 'karyawan_bankcabangSearchField',
		fieldLabel: 'Cabang',
		maxLength: 50,
		allowBlank: true,
		anchor: '95%'
	});
	/* Identify  karyawan_norekening Field */
	karyawan_norekeningSearchField= new Ext.form.TextField({
		id: 'karyawan_norekeningSearchField',
		fieldLabel: 'No Rekening',
		maxLength: 50,
		allowBlank: true,
		anchor: '95%'
	});
	/* Identify  karyawan_atasnama Field */
	karyawan_atasnamaSearchField= new Ext.form.TextField({
		id: 'karyawan_atasnamaSearchField',
		fieldLabel: 'Atas Nama',
		maxLength: 50,
		allowBlank: true,
		anchor: '95%'
	});
	// EOF INFO REKENING SEARCH
	
	// STATUS KEKARYAWANAN SEARCH
	karyawan_statuskekaryawananSearchField= new Ext.form.ComboBox({
		id : 'karyawan_statuskekaryawananSearchField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['status_karyawan_value'],
			data:[['Percobaan'],['Kontrak I'],['Kontrak II'],['Tetap'],['Lain-lain'],['Tidak Aktif']]
		}),
		mode: 'local',
		displayField: 'status_karyawan_value',
		valueField: 'status_karyawan_value',
		allowBlank: true,
		anchor: '95%',
		triggerAction: 'all',
		lazyRenderer: true
	});
	karyawan_statustglawalawalSearchField= new Ext.form.DateField({
		id: 'karyawan_statustglawalawalSearchField',
		fieldLabel: 'Tgl Awal',
		format : 'd-m-Y'
	
	});	
	karyawan_statustglawalakhirSearchField= new Ext.form.DateField({
		id: 'karyawan_statustglawalakhirSearchField',
		fieldLabel: 's/d',
		format : 'd-m-Y'
	
	});	
	karyawan_statustglakhirawalSearchField= new Ext.form.DateField({
		id: 'karyawan_statustglakhirawalSearchField',
		fieldLabel: 'Tgl Akhir',
		format : 'd-m-Y'
	
	});	
	karyawan_statustglakhirakhirSearchField= new Ext.form.DateField({
		id: 'karyawan_statustglakhirakhirSearchField',
		fieldLabel: 's/d',
		format : 'd-m-Y'
	
	});
	karyawan_statuskaryawanSearchField= new Ext.form.TextField({
		id: 'karyawan_statuskaryawanSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 500,
		allowBlank: true,
		anchor: '95%'
	});

	// EOF STATUS KEKARYAWANAN SEARCH
	
	// JABATAN SEARCH
	/* Identify  karyawan_jabatan Search Field */
	karyawan_jabatanSearchField= new Ext.form.ComboBox({
		id: 'karyawan_jabatanSearchField',
		fieldLabel: 'Jabatan',
		store:cbo_karyawan_jabatan_DataStore,
		mode: 'remote',
		displayField: 'karyawan_jabatan_display',
		valueField: 'karyawan_jabatan_value',
		allowBlank: true,
		anchor: '95%',
		triggerAction: 'all'
	
	});
	/* Identify  karyawan_departemen Search Field */
	karyawan_departemenSearchField= new Ext.form.ComboBox({
		id: 'karyawan_departemenSearchField',
		fieldLabel: 'Departemen',
		store:cbo_karyawan_departemen_DataStore,
		mode: 'remote',
		displayField: 'karyawan_departemen_display',
		valueField: 'karyawan_departemen_value',
		allowBlank: true,
		anchor: '95%',
		triggerAction: 'all'
	
	});
	/* Identify  karyawan_golongan Search Field */
	karyawan_golonganSearchField= new Ext.form.ComboBox({
		id: 'karyawan_golonganSearchField',
		fieldLabel: 'Golongan',
		store:cbo_karyawan_golongan_DataStore,
		mode: 'remote',
		displayField: 'karyawan_golongan_display',
		valueField: 'karyawan_golongan_value',
		allowBlank: true,
		anchor: '95%',
		triggerAction: 'all'
	
	});
	/* Identify  karyawan_atasan Search Field */
	karyawan_atasanSearchField= new Ext.form.ComboBox({
		id: 'karyawan_atasanSearchField',
		fieldLabel: 'Atasan',
		store:cbo_karyawan_atasan_DataStore,
		mode: 'remote',
		displayField: 'karyawan_atasan_display',
		valueField: 'karyawan_atasan_value',
		allowBlank: true,
		anchor: '95%',
		triggerAction: 'all'
	
	});
	/* Identify  karyawan_kelamin Field */
	karyawan_pph21SearchField= new Ext.form.ComboBox({
		id: 'karyawan_pph21SearchField',
		fieldLabel: 'PPH 21',
		store:new Ext.data.SimpleStore({
			fields:['karyawan_pph21Search_value', 'karyawan_pph21Search_display'],
			data:[['TK','TK'],['K','K'],['K/1','K/1'],['K/2','K/2'],['K/3','K/3'],['TK/1','TK/1'],['TK/2','TK/2'],['TK/3','TK/3']]
		}),
		mode: 'local',
		editable:false,
		allowBlank: true,
		displayField: 'karyawan_pph21Search_display',
		valueField: 'karyawan_pph21Search_value',
		width: 80,
		triggerAction: 'all'	
	});
	karyawan_tgljbtawalawalSearchField= new Ext.form.DateField({
		id: 'karyawan_tgljbtawalawalSearchField',
		fieldLabel: 'Tgl Awal',
		format : 'd-m-Y'
	
	});	
	karyawan_tgljbtawalakhirSearchField= new Ext.form.DateField({
		id: 'karyawan_tgljbtawalakhirSearchField',
		fieldLabel: 's/d',
		format : 'd-m-Y'
	
	});	
	karyawan_tgljbtakhirawalSearchField= new Ext.form.DateField({
		id: 'karyawan_tgljbtakhirawalSearchField',
		fieldLabel: 'Tgl Akhir',
		format : 'd-m-Y'
	
	});	
	karyawan_tgljbtakhirakhirSearchField= new Ext.form.DateField({
		id: 'karyawan_tgljbtakhirakhirSearchField',
		fieldLabel: 's/d',
		format : 'd-m-Y'
	
	});	
	karyawan_jabatanketeranganSearchField= new Ext.form.TextField({
		id: 'karyawan_jabatanketeranganSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 500,
		allowBlank: true,
		anchor: '95%'
	});
	// EOF JABATAN SEARCH
	
	// PENDIDIKAN SEARCH
	karyawan_pendidikanSearchField= new Ext.form.ComboBox({
		id: 'karyawan_pendidikanSearchField',
		fieldLabel: 'Pendidikan',
		store:new Ext.data.SimpleStore({
			fields:['karyawan_pendidikan_value'],
			data:[['SD'],['SMP'],['SMA'],['D1'],['D2'],['D3'],['D4'],['S1'],['S2'],['S3']]
		}),
		mode: 'local',
		displayField: 'karyawan_pendidikan_value',
		valueField: 'karyawan_pendidikan_value',
		allowBlank: true,
		anchor: '95%',
		triggerAction: 'all',
		lazyRenderer: true
	});
	karyawan_namasekolahSearchField= new Ext.form.TextField({
		id: 'karyawan_namasekolahSearchField',
		fieldLabel: 'Nama Sekolah',
		maxLength: 50,
		allowBlank: true,
		anchor: '95%'
	});
	karyawan_jurusanSearchField= new Ext.form.TextField({
		id: 'karyawan_jurusanSearchField',
		fieldLabel: 'Jurusan',
		maxLength: 50,
		allowBlank: true,
		anchor: '95%'
	});
	karyawan_thnmskawalSearchField= new Ext.form.TextField({
		id: 'karyawan_thnmskawalSearchField',
		fieldLabel: 'Thn Masuk',
		maxLength: 50,
		width: 80,
		allowBlank: true,
		//anchor: '95%'
	});
	karyawan_thnmskakhirSearchField= new Ext.form.TextField({
		id: 'karyawan_thnmskakhirSearchField',
		fieldLabel: 's/d',
		maxLength: 50,
		width: 80,
		allowBlank: true,
		//anchor: '95%'
	});
	karyawan_thnslsawalSearchField= new Ext.form.TextField({
		id: 'karyawan_thnslsawalSearchField',
		fieldLabel: 'Thn Selesai',
		maxLength: 50,
		width: 80,
		allowBlank: true,
		//anchor: '95%'
	});
	karyawan_thnslsakhirSearchField= new Ext.form.TextField({
		id: 'karyawan_thnslsakhirSearchField',
		fieldLabel: 's/d',
		maxLength: 50,
		width: 80,
		allowBlank: true,
		//anchor: '95%'
	});
	karyawan_wisudaawalSearchField= new Ext.form.TextField({
		id: 'karyawan_wisudaawalSearchField',
		fieldLabel: 'Wisuda',
		maxLength: 50,
		width: 80,
		allowBlank: true,
		//anchor: '95%'
	});
	karyawan_wisudaakhirSearchField= new Ext.form.TextField({
		id: 'karyawan_wisudaakhirSearchField',
		fieldLabel: 's/d',
		maxLength: 50,
		width: 80,
		allowBlank: true,
		//anchor: '95%'
	});
	karyawan_pendidikanketeranganSearchField= new Ext.form.TextField({
		id: 'karyawan_pendidikanketeranganSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 500,
		allowBlank: true,
		anchor: '95%'
	});
	
	// EOF PENDIDIKAN SEARCH
	
	// KELUARGA SEARCH
	// EOF KELUARGA SEARCH
	
	// CUTI SEARCH
	karyawan_jeniscutiSearchField= new Ext.form.ComboBox({
		id: 'karyawan_jeniscutiSearchField',
		fieldLabel: 'Jenis Cuti',
		store:new Ext.data.SimpleStore({
			fields:['karyawan_cuti_value'],
			data:[['Umum Tahunan'],['Cuti Hamil'],['Cuti Istimewa'],['Cuti Panjang'],['Unpaid Leave']]
		}),
		mode: 'local',
		displayField: 'karyawan_cuti_value',
		valueField: 'karyawan_cuti_value',
		allowBlank: true,
		anchor: '95%',
		//hidden: true,
		triggerAction: 'all',
		lazyRenderer: true
	});
	karyawan_tglcutiawalawalSearchField= new Ext.form.DateField({
		id: 'karyawan_tglcutiawalawalSearchField',
		fieldLabel: 'Tgl Awal',
		format : 'd-m-Y'
	
	});	
	karyawan_tglcutiawalakhirSearchField= new Ext.form.DateField({
		id: 'karyawan_tglcutiawalakhirSearchField',
		fieldLabel: 's/d',
		format : 'd-m-Y'
	
	});	
	karyawan_tglcutiakhirawalSearchField= new Ext.form.DateField({
		id: 'karyawan_tglcutiakhirawalSearchField',
		fieldLabel: 'Tgl Akhir',
		format : 'd-m-Y'
	
	});	
	karyawan_tglcutiakhirakhirSearchField= new Ext.form.DateField({
		id: 'karyawan_tglcutiakhirakhirSearchField',
		fieldLabel: 's/d',
		format : 'd-m-Y'
	
	});	
	karyawan_jmlharicutiawalSearchField= new Ext.form.TextField({
		id: 'karyawan_jmlharicutiawalSearchField',
		fieldLabel: 'Jml Hari',
		maxLength: 50,
		width: 80,
		allowBlank: true,
		//anchor: '95%'
	});
	karyawan_jmlharicutiakhirSearchField= new Ext.form.TextField({
		id: 'karyawan_jmlharicutiakhirSearchField',
		fieldLabel: 's/d',
		maxLength: 50,
		width: 80,
		allowBlank: true,
		//anchor: '95%'
	});
	karyawan_tglpengajuanawalSearchField= new Ext.form.DateField({
		id: 'karyawan_tglpengajuanawalSearchField',
		fieldLabel: 'Tgl Pengajuan',
		format : 'd-m-Y'
	
	});	
	karyawan_tglpengajuanakhirSearchField= new Ext.form.DateField({
		id: 'karyawan_tglpengajuanakhirSearchField',
		fieldLabel: 's/d',
		format : 'd-m-Y'
	
	});
	karyawan_cutiketeranganSearchField= new Ext.form.TextField({
		id: 'karyawan_cutiketeranganSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 500,
		allowBlank: true,
		anchor: '95%'
	});
	// EOF CUTI SEARCH
	
	// GANTIOFF SEARCH
	karyawan_tgloffawalawalSearchField= new Ext.form.DateField({
		id: 'karyawan_tgloffawalawalSearchField',
		fieldLabel: 'Tgl Awal',
		format : 'd-m-Y'
	
	});	
	karyawan_tgloffawalakhirSearchField= new Ext.form.DateField({
		id: 'karyawan_tgloffawalakhirSearchField',
		fieldLabel: 's/d',
		format : 'd-m-Y'
	
	});	
	karyawan_tgloffakhirawalSearchField= new Ext.form.DateField({
		id: 'karyawan_tgloffakhirawalSearchField',
		fieldLabel: 'Tgl Akhir',
		format : 'd-m-Y'
	
	});	
	karyawan_tgloffakhirakhirSearchField= new Ext.form.DateField({
		id: 'karyawan_tgloffakhirakhirSearchField',
		fieldLabel: 's/d',
		format : 'd-m-Y'
	
	});
	karyawan_jmlharioffawalSearchField= new Ext.form.TextField({
		id: 'karyawan_jmlharioffawalSearchField',
		fieldLabel: 'Jml Hari',
		maxLength: 50,
		width: 80,
		allowBlank: true,
		//anchor: '95%'
	});
	karyawan_jmlharioffakhirSearchField= new Ext.form.TextField({
		id: 'karyawan_jmlharioffakhirSearchField',
		fieldLabel: 's/d',
		maxLength: 50,
		width: 80,
		allowBlank: true,
		//anchor: '95%'
	});
	karyawan_tgloffgantiawalawalSearchField= new Ext.form.DateField({
		id: 'karyawan_tgloffgantiawalawalSearchField',
		fieldLabel: 'Tgl Diganti Awal',
		format : 'd-m-Y'
	
	});	
	karyawan_tgloffgantiawalakhirSearchField= new Ext.form.DateField({
		id: 'karyawan_tgloffgantiawalakhirSearchField',
		fieldLabel: 's/d',
		format : 'd-m-Y'
	
	});
	karyawan_tgloffgantiakhirawalSearchField= new Ext.form.DateField({
		id: 'karyawan_tgloffgantiakhirawalSearchField',
		fieldLabel: 'Tgl Diganti Akhir',
		format : 'd-m-Y'
	
	});	
	karyawan_tgloffgantiakhirakhirSearchField= new Ext.form.DateField({
		id: 'karyawan_tgloffgantiakhirakhirSearchField',
		fieldLabel: 's/d',
		format : 'd-m-Y'
	
	});
	karyawan_tgloffpengajuanakhirawalSearchField= new Ext.form.DateField({
		id: 'karyawan_tgloffpengajuanakhirawalSearchField',
		fieldLabel: 'Tgl Pengajuan',
		format : 'd-m-Y'
	
	});	
	karyawan_tgloffpengajuanakhirakhirSearchField= new Ext.form.DateField({
		id: 'karyawan_tgloffpengajuanakhirakhirSearchField',
		fieldLabel: 's/d',
		format : 'd-m-Y'
	
	});
	karyawan_offketeranganSearchField= new Ext.form.TextField({
		id: 'karyawan_offketeranganSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 500,
		allowBlank: true,
		anchor: '95%'
	});
	// EOF GANTIOFF SEARCH
	
	// MEDICAL SEARCH
	karyawan_tujuanklaimSearchField= new Ext.form.ComboBox({
		id: 'karyawan_tujuanklaimSearchField',
		fieldLabel: 'Tujuan Klaim',
		store:new Ext.data.SimpleStore({
			fields:['kmedicaltujuan_value'],
			data:[['Diri Sendiri'],['Istri'],['Anak']]
		}),
		mode: 'local',
		displayField: 'kmedicaltujuan_value',
		valueField: 'kmedicaltujuan_value',
		allowBlank: true,
		anchor: '95%',
		triggerAction: 'all',
		lazyRenderer: true
	});
	karyawan_jenisrawatSearchField= new Ext.form.ComboBox({
		id: 'karyawan_jenisrawatSearchField',
		fieldLabel: 'Jenis Rawat',
		store:new Ext.data.SimpleStore({
			fields:['kmedicalrawat_value'],
			data:[['Rawat Jalan'],['Rawat Inap']]
		}),
		mode: 'local',
		displayField: 'kmedicalrawat_value',
		valueField: 'kmedicalrawat_value',
		allowBlank: true,
		anchor: '95%',
		triggerAction: 'all',
		lazyRenderer: true
	});
	karyawan_jenisklaimSearchField= new Ext.form.ComboBox({
		id: 'karyawan_jenisklaimSearchField',
		fieldLabel: 'Jenis Klaim',
		store:new Ext.data.SimpleStore({
			fields:['kmedicaljenis_value'],
			data:[['Umum'],['Spesialis'],['Frame'],['Lensa'],['Lain-lain']]
		}),
		mode: 'local',
		displayField: 'kmedicaljenis_value',
		valueField: 'kmedicaljenis_value',
		allowBlank: true,
		anchor: '95%',
		triggerAction: 'all',
		lazyRenderer: true
	});
	karyawan_jmlkuitansiawalSearchField= new Ext.form.TextField({
		id: 'karyawan_jmlkuitansiawalSearchField',
		fieldLabel: 'Jml Kuitansi',
		maxLength: 50,
		width: 80,
		allowBlank: true,
		//anchor: '95%'
	});
	karyawan_jmlkuitansiakhirSearchField= new Ext.form.TextField({
		id: 'karyawan_jmlkuitansiakhirSearchField',
		fieldLabel: 's/d',
		maxLength: 50,
		width: 80,
		allowBlank: true,
		//anchor: '95%'
	});
	karyawan_totalkuitansiawalSearchField= new Ext.form.TextField({
		id: 'karyawan_totalkuitansiawalSearchField',
		fieldLabel: 'Total (Rp.)',
		maxLength: 50,
		width: 80,
		allowBlank: true,
		//anchor: '95%'
	});
	karyawan_totalkuitansiakhirSearchField= new Ext.form.TextField({
		id: 'karyawan_totalkuitansiakhirSearchField',
		fieldLabel: 's/d',
		maxLength: 50,
		width: 80,
		allowBlank: true,
		//anchor: '95%'
	});
	karyawan_tglmedicalpengajuanawalSearchField= new Ext.form.DateField({
		id: 'karyawan_tglmedicalpengajuanawalSearchField',
		fieldLabel: 'Tgl Pengajuan',
		format : 'd-m-Y'
	
	});	
	karyawan_tglmedicalpengajuanakhirSearchField= new Ext.form.DateField({
		id: 'karyawan_tglmedicalpengajuanakhirSearchField',
		fieldLabel: 's/d',
		format : 'd-m-Y'
	
	});
	karyawan_tglmedicalkuitansiawalSearchField= new Ext.form.DateField({
		id: 'karyawan_tglmedicalkuitansiawalSearchField',
		fieldLabel: 'Tgl Kuitansi',
		format : 'd-m-Y'
	
	});	
	karyawan_tglmedicalkuitansiakhirSearchField= new Ext.form.DateField({
		id: 'karyawan_tglmedicalkuitansiakhirSearchField',
		fieldLabel: 's/d',
		format : 'd-m-Y'
	
	});
	karyawan_medicalketeranganSearchField= new Ext.form.TextField({
		id: 'karyawan_medicalketeranganSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 500,
		allowBlank: true,
		anchor: '95%'
	});
	// EOF MEDICAL SEARCH
	
	// FASILITAS SEARCH
	karyawan_fasilitasitemSearchField= new Ext.form.TextField({
		id: 'karyawan_fasilitasitemSearchField',
		fieldLabel: 'Item',
		maxLength: 500,
		allowBlank: true,
		anchor: '95%'
	});
	karyawan_tglserahterimaawalSearchField= new Ext.form.DateField({
		id: 'karyawan_tglserahterimaawalSearchField',
		fieldLabel: 'Tgl Serah Terima',
		format : 'd-m-Y'
	
	});	
	karyawan_tglserahterimaakhirSearchField= new Ext.form.DateField({
		id: 'karyawan_tglserahterimaakhirSearchField',
		fieldLabel: 's/d',
		format : 'd-m-Y'
	
	});
	karyawan_fasilitasketeranganSearchField= new Ext.form.TextField({
		id: 'karyawan_fasilitasketeranganSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 500,
		allowBlank: true,
		anchor: '95%'
	});

	// EOF FASILITAS SEARCH
	
	// GROUP PLACEMENT
	group_search_alamat = new Ext.form.FieldSet({
		title: 'Alamat & Kontak',
		autoHeight: true,
		collapsed: true,
		collapsible: true,
		defaultType: 'textfield',
		anchor: '95%',
		items:[karyawan_alamatSearchField ,karyawan_kotaSearchField ,karyawan_kodeposSearchField, karyawan_notelpSearchField, karyawan_emailSearchField]
	});
	
	group_search_rekening = new Ext.form.FieldSet({
		title: 'Info Rekening',
		autoHeight: true,
		collapsed: true,
		collapsible: true,
		defaultType: 'textfield',
		anchor: '95%',
		items:[karyawan_bankSearchField, karyawan_bankcabangSearchField, karyawan_norekeningSearchField, karyawan_atasnamaSearchField]
	});
	
	
	/*
	group_search_kontak = new Ext.form.FieldSet({
		title: 'Kontak',
		autoHeight: true,
		defaultType: 'textfield',
		anchor: '95%',
		items:[karyawan_notelpSearchField ,karyawan_notelp2SearchField ,karyawan_notelp3SearchField,karyawan_notelp4SearchField ,karyawan_emailSearchField]
	});
	*/
	group_search_tgllahir = new Ext.form.FieldSet({
		title: 'Tgl & Tmp Lahir',
		autoHeight: true,
		collapsed: true,
		collapsible: true,
		//defaultType: 'textfield',
		layout: 'form',
		anchor: '95%',
		items:[karyawan_tempatlahirSearchField,
		{
				columnWidth:1,
				layout: 'column',
				border:false,
				items: [
					{
						columnWidth:0.5,
						layout: 'form',
						labelAlign: 'left',
						border:false,
						items: [karyawan_tgllahirawalSearchField]
					},
					{
						layout: 'form',
						border: false,
						columnWidth: 0.5,
						labelWidth: 30,
						//labelAlign: 'left',
						labelSeparator: ' ', 
						items:[karyawan_tgllahirakhirSearchField]
					}
				]},
		{
				columnWidth:1,
				layout: 'column',
				border:false,
				items: [
					{
						columnWidth:0.5,
						layout: 'form',
						labelAlign: 'left',
						border:false,
						items: [karyawan_tgllahirSearchField]
					},
					{
						layout: 'form',
						border: false,
						columnWidth: 0.5,
						labelWidth: 30,
						//labelAlign: 'left',
						labelSeparator: ' ', 
						items:[karyawan_blnlahirSearchField]
					}
				]}]
	});
	group_search_status = new Ext.form.FieldSet({
		title: 'Status Kekaryawanan',
		autoHeight: true,
		collapsed: true,
		collapsible: true,
		//defaultType: 'textfield',
		layout: 'form',
		anchor: '95%',
		items:[karyawan_statuskekaryawananSearchField,
		{
				columnWidth:1,
				layout: 'column',
				border:false,
				items: [
					{
						columnWidth:0.5,
						layout: 'form',
						labelAlign: 'left',
						border:false,
						items: [karyawan_statustglawalawalSearchField]
					},
					{
						layout: 'form',
						border: false,
						columnWidth: 0.5,
						labelWidth: 30,
						//labelAlign: 'left',
						labelSeparator: ' ', 
						items:[karyawan_statustglawalakhirSearchField]
					}
				]},
		{
				columnWidth:1,
				layout: 'column',
				border:false,
				items: [
					{
						columnWidth:0.5,
						layout: 'form',
						labelAlign: 'left',
						border:false,
						items: [karyawan_statustglakhirawalSearchField]
					},
					{
						layout: 'form',
						border: false,
						columnWidth: 0.5,
						labelWidth: 30,
						//labelAlign: 'left',
						labelSeparator: ' ', 
						items:[karyawan_statustglakhirakhirSearchField]
					}
				]}, karyawan_statuskaryawanSearchField]
	});
	group_search_jabatan = new Ext.form.FieldSet({
		title: 'Jabatan',
		autoHeight: true,
		collapsed: true,
		collapsible: true,
		//defaultType: 'textfield',
		layout: 'form',
		anchor: '95%',
		items:[karyawan_departemenSearchField, karyawan_jabatanSearchField, karyawan_golonganSearchField, karyawan_pph21SearchField, karyawan_atasanSearchField,
		{
				columnWidth:1,
				layout: 'column',
				border:false,
				items: [
					{
						columnWidth:0.5,
						layout: 'form',
						labelAlign: 'left',
						border:false,
						items: [karyawan_tgljbtawalawalSearchField]
					},
					{
						layout: 'form',
						border: false,
						columnWidth: 0.5,
						labelWidth: 30,
						//labelAlign: 'left',
						labelSeparator: ' ', 
						items:[karyawan_tgljbtawalakhirSearchField]
					}
				]},
		{
				columnWidth:1,
				layout: 'column',
				border:false,
				items: [
					{
						columnWidth:0.5,
						layout: 'form',
						labelAlign: 'left',
						border:false,
						items: [karyawan_tgljbtakhirawalSearchField]
					},
					{
						layout: 'form',
						border: false,
						columnWidth: 0.5,
						labelWidth: 30,
						//labelAlign: 'left',
						labelSeparator: ' ', 
						items:[karyawan_tgljbtakhirakhirSearchField]
					}
				]}, karyawan_jabatanketeranganSearchField]
	});
	
	group_search_pendidikan = new Ext.form.FieldSet({
		title: 'Pendidikan',
		autoHeight: true,
		collapsed: true,
		collapsible: true,
		//defaultType: 'textfield',
		layout: 'form',
		anchor: '95%',
		items:[karyawan_pendidikanSearchField, karyawan_namasekolahSearchField, karyawan_jurusanSearchField,
		{
				columnWidth:1,
				layout: 'column',
				border:false,
				items: [
					{
						columnWidth:0.45,
						layout: 'form',
						labelAlign: 'left',
						border:false,
						items: [karyawan_thnmskawalSearchField]
					},
					{
						layout: 'form',
						border: false,
						columnWidth: 0.55,
						labelWidth: 30,
						//labelAlign: 'left',
						labelSeparator: ' ', 
						items:[karyawan_thnmskakhirSearchField]
					}
				]},
		{
				columnWidth:1,
				layout: 'column',
				border:false,
				items: [
					{
						columnWidth:0.45,
						layout: 'form',
						labelAlign: 'left',
						border:false,
						items: [karyawan_thnslsawalSearchField]
					},
					{
						layout: 'form',
						border: false,
						columnWidth: 0.55,
						labelWidth: 30,
						//labelAlign: 'left',
						labelSeparator: ' ', 
						items:[karyawan_thnslsakhirSearchField]
					}
				]}, 
		{
				columnWidth:1,
				layout: 'column',
				border:false,
				items: [
					{
						columnWidth:0.45,
						layout: 'form',
						labelAlign: 'left',
						border:false,
						items: [karyawan_wisudaawalSearchField]
					},
					{
						layout: 'form',
						border: false,
						columnWidth: 0.55,
						labelWidth: 30,
						//labelAlign: 'left',
						labelSeparator: ' ', 
						items:[karyawan_wisudaakhirSearchField]
					}
				]},
		karyawan_pendidikanketeranganSearchField]
	});
	
	group_search_cuti = new Ext.form.FieldSet({
		title: 'Cuti',
		autoHeight: true,
		collapsed: true,
		collapsible: true,
		//defaultType: 'textfield',
		layout: 'form',
		anchor: '95%',
		items:[karyawan_jeniscutiSearchField,
		{
				columnWidth:1,
				layout: 'column',
				border:false,
				items: [
					{
						columnWidth:0.5,
						layout: 'form',
						labelAlign: 'left',
						border:false,
						items: [karyawan_tglcutiawalawalSearchField]
					},
					{
						layout: 'form',
						border: false,
						columnWidth: 0.5,
						labelWidth: 30,
						//labelAlign: 'left',
						labelSeparator: ' ', 
						items:[karyawan_tglcutiawalakhirSearchField]
					}
				]},
		{
				columnWidth:1,
				layout: 'column',
				border:false,
				items: [
					{
						columnWidth:0.5,
						layout: 'form',
						labelAlign: 'left',
						border:false,
						items: [karyawan_tglcutiakhirawalSearchField]
					},
					{
						layout: 'form',
						border: false,
						columnWidth: 0.5,
						labelWidth: 30,
						//labelAlign: 'left',
						labelSeparator: ' ', 
						items:[karyawan_tglcutiakhirakhirSearchField]
					}
				]}, 
		{
				columnWidth:1,
				layout: 'column',
				border:false,
				items: [
					{
						columnWidth:0.45,
						layout: 'form',
						labelAlign: 'left',
						border:false,
						items: [karyawan_jmlharicutiawalSearchField]
					},
					{
						layout: 'form',
						border: false,
						columnWidth: 0.55,
						labelWidth: 30,
						//labelAlign: 'left',
						labelSeparator: ' ', 
						items:[karyawan_jmlharicutiakhirSearchField]
					}
				]},
		{
				columnWidth:1,
				layout: 'column',
				border:false,
				items: [
					{
						columnWidth:0.5,
						layout: 'form',
						labelAlign: 'left',
						border:false,
						items: [karyawan_tglpengajuanawalSearchField]
					},
					{
						layout: 'form',
						border: false,
						columnWidth: 0.5,
						labelWidth: 30,
						//labelAlign: 'left',
						labelSeparator: ' ', 
						items:[karyawan_tglpengajuanakhirSearchField]
					}
				]},
		karyawan_cutiketeranganSearchField]
	});

	group_search_gantioff = new Ext.form.FieldSet({
		title: 'Ganti Off',
		autoHeight: true,
		collapsed: true,
		collapsible: true,
		//defaultType: 'textfield',
		layout: 'form',
		anchor: '95%',
		items:[
		{
				columnWidth:1,
				layout: 'column',
				border:false,
				items: [
					{
						columnWidth:0.5,
						layout: 'form',
						labelAlign: 'left',
						border:false,
						items: [karyawan_tgloffawalawalSearchField]
					},
					{
						layout: 'form',
						border: false,
						columnWidth: 0.5,
						labelWidth: 30,
						//labelAlign: 'left',
						labelSeparator: ' ', 
						items:[karyawan_tgloffawalakhirSearchField]
					}
				]},
		{
				columnWidth:1,
				layout: 'column',
				border:false,
				items: [
					{
						columnWidth:0.5,
						layout: 'form',
						labelAlign: 'left',
						border:false,
						items: [karyawan_tgloffakhirawalSearchField]
					},
					{
						layout: 'form',
						border: false,
						columnWidth: 0.5,
						labelWidth: 30,
						//labelAlign: 'left',
						labelSeparator: ' ', 
						items:[karyawan_tgloffakhirakhirSearchField]
					}
				]}, 
		{
				columnWidth:1,
				layout: 'column',
				border:false,
				items: [
					{
						columnWidth:0.45,
						layout: 'form',
						labelAlign: 'left',
						border:false,
						items: [karyawan_jmlharioffawalSearchField]
					},
					{
						layout: 'form',
						border: false,
						columnWidth: 0.55,
						labelWidth: 30,
						//labelAlign: 'left',
						labelSeparator: ' ', 
						items:[karyawan_jmlharioffakhirSearchField]
					}
				]},
		{
				columnWidth:1,
				layout: 'column',
				border:false,
				items: [
					{
						columnWidth:0.5,
						layout: 'form',
						labelAlign: 'left',
						border:false,
						items: [karyawan_tgloffgantiawalawalSearchField]
					},
					{
						layout: 'form',
						border: false,
						columnWidth: 0.5,
						labelWidth: 30,
						//labelAlign: 'left',
						labelSeparator: ' ', 
						items:[karyawan_tgloffgantiawalakhirSearchField]
					}
				]},
		{
				columnWidth:1,
				layout: 'column',
				border:false,
				items: [
					{
						columnWidth:0.5,
						layout: 'form',
						labelAlign: 'left',
						border:false,
						items: [karyawan_tgloffgantiakhirawalSearchField]
					},
					{
						layout: 'form',
						border: false,
						columnWidth: 0.5,
						labelWidth: 30,
						//labelAlign: 'left',
						labelSeparator: ' ', 
						items:[karyawan_tgloffgantiakhirakhirSearchField]
					}
				]},
		{
				columnWidth:1,
				layout: 'column',
				border:false,
				items: [
					{
						columnWidth:0.5,
						layout: 'form',
						labelAlign: 'left',
						border:false,
						items: [karyawan_tgloffpengajuanakhirawalSearchField]
					},
					{
						layout: 'form',
						border: false,
						columnWidth: 0.5,
						labelWidth: 30,
						//labelAlign: 'left',
						labelSeparator: ' ', 
						items:[karyawan_tgloffpengajuanakhirakhirSearchField]
					}
				]},
		karyawan_offketeranganSearchField]
	});
	
	group_search_medical = new Ext.form.FieldSet({
		title: 'Medical Reimbursemen',
		autoHeight: true,
		collapsed: true,
		collapsible: true,
		//defaultType: 'textfield',
		layout: 'form',
		anchor: '95%',
		items:[karyawan_tujuanklaimSearchField, karyawan_jenisrawatSearchField, karyawan_jenisklaimSearchField,
		{
				columnWidth:1,
				layout: 'column',
				border:false,
				items: [
					{
						columnWidth:0.45,
						layout: 'form',
						labelAlign: 'left',
						border:false,
						items: [karyawan_jmlkuitansiawalSearchField]
					},
					{
						layout: 'form',
						border: false,
						columnWidth: 0.55,
						labelWidth: 30,
						//labelAlign: 'left',
						labelSeparator: ' ', 
						items:[karyawan_jmlkuitansiakhirSearchField]
					}
				]},
		{
				columnWidth:1,
				layout: 'column',
				border:false,
				items: [
					{
						columnWidth:0.45,
						layout: 'form',
						labelAlign: 'left',
						border:false,
						items: [karyawan_totalkuitansiawalSearchField]
					},
					{
						layout: 'form',
						border: false,
						columnWidth: 0.55,
						labelWidth: 30,
						//labelAlign: 'left',
						labelSeparator: ' ', 
						items:[karyawan_totalkuitansiakhirSearchField]
					}
				]}, 
		{
				columnWidth:1,
				layout: 'column',
				border:false,
				items: [
					{
						columnWidth:0.5,
						layout: 'form',
						labelAlign: 'left',
						border:false,
						items: [karyawan_tglmedicalpengajuanawalSearchField]
					},
					{
						layout: 'form',
						border: false,
						columnWidth: 0.5,
						labelWidth: 30,
						//labelAlign: 'left',
						labelSeparator: ' ', 
						items:[karyawan_tglmedicalpengajuanakhirSearchField]
					}
				]},
			{
				columnWidth:1,
				layout: 'column',
				border:false,
				items: [
					{
						columnWidth:0.5,
						layout: 'form',
						labelAlign: 'left',
						border:false,
						items: [karyawan_tglmedicalkuitansiawalSearchField]
					},
					{
						layout: 'form',
						border: false,
						columnWidth: 0.5,
						labelWidth: 30,
						//labelAlign: 'left',
						labelSeparator: ' ', 
						items:[karyawan_tglmedicalkuitansiakhirSearchField]
					}
				]}, karyawan_medicalketeranganSearchField]
	});
	
	group_search_fasilitas = new Ext.form.FieldSet({
		title: 'Fasilitas',
		autoHeight: true,
		collapsed: true,
		collapsible: true,
		//defaultType: 'textfield',
		layout: 'form',
		anchor: '95%',
		items:[karyawan_fasilitasitemSearchField,
		{
				columnWidth:1,
				layout: 'column',
				border:false,
				items: [
					{
						columnWidth:0.5,
						layout: 'form',
						labelAlign: 'left',
						border:false,
						items: [karyawan_tglserahterimaawalSearchField]
					},
					{
						layout: 'form',
						border: false,
						columnWidth: 0.5,
						labelWidth: 30,
						//labelAlign: 'left',
						labelSeparator: ' ', 
						items:[karyawan_tglserahterimaakhirSearchField]
					}
				]}, karyawan_fasilitasketeranganSearchField]
	});
	// EOF GROUP PLACEMENT
    
	/* Function for retrieve search Form Panel */
	karyawan_searchForm = new Ext.FormPanel({
		labelAlign: 'left',
		labelWidth: 120,
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 1100,        
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [karyawan_cabangSearchField, karyawan_noSearchField, karyawan_namaSearchField, karyawan_usernameSearchField, karyawan_noktpSearchField, karyawan_alamatktpSearchField, karyawan_agamaSearchField, karyawan_kelaminSearchField, 
				{	
							columnWidth:1,
							layout: 'column',
							border:false,
							items: [
								{
									columnWidth:0.5,
									layout: 'form',
									labelAlign: 'left',
									border:false,
									items: [karyawan_marriageSearchField]
								},
								{
									layout: 'form',
									border: false,
									columnWidth: 0.5,
									labelWidth: 60,
									//labelAlign: 'left',
									labelSeparator: ' ', 
									items:[karyawan_jmlanakSearchField]
								}
							]},
				karyawan_tglmasukSearchField, group_search_alamat, group_search_rekening, group_search_status,
				group_search_jabatan, group_search_pendidikan,] 
			}
			,{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [group_search_tgllahir, karyawan_sipSearchField, karyawan_jamsostekSearchField, karyawan_npwpSearchField, karyawan_keteranganSearchField, karyawan_aktifSearchField, group_search_cuti, group_search_gantioff, group_search_medical, group_search_fasilitas] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: karyawan_list_search
			},{
				text: 'Close',
				handler: function(){
					karyawan_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	karyawan_searchWindow = new Ext.Window({
		title: 'Pencarian Karyawan',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_karyawan_search',
		items: karyawan_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!karyawan_searchWindow.isVisible()){
			karyawan_reset_SearchForm();
			karyawan_searchWindow.show();
		} else {
			karyawan_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	// Event utk sub kategori
	dkaryawan_statuskaryawanField.on("select", function(){
		if(dkaryawan_statuskaryawanField.getValue()=='Tidak Aktif'){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk membuat Tidak Aktif karyawan ini?', karyawan_tidak_aktif);

		}else if(dkaryawan_statuskaryawanField.getValue()!='Tidak Aktif'){
			karyawan_aktifField.setValue('Aktif');
		}
	});
	
	function karyawan_tidak_aktif(btn){
	if(btn=='yes'){
		karyawan_aktifField.setValue('Tidak Aktif');
	} else{
		dkaryawan_statuskaryawanField.setValue('Percobaan')
		karyawan_aktifField.setValue('Aktif');
	}
	}
	

	/* Function for print List Grid */
	function karyawan_print(){
		var searchquery = "";
		var karyawan_no_print=null;
		var karyawan_npwp_print=null;
		var karyawan_username_print=null;
		var karyawan_nama_print=null;
		var karyawan_kelamin_print=null;
		var karyawan_tgllahir_print_date="";
		var karyawan_alamat_print=null;
		var karyawan_kota_print=null;
		var karyawan_kodepos_print=null;
		var karyawan_email_print=null;
		var karyawan_emiracle_print=null;
		var karyawan_keterangan_print=null;
		var karyawan_notelp_print=null;
		var karyawan_notelp2_print=null;
		var karyawan_notelp3_print=null;
		var karyawan_cabang_print=null;
		var karyawan_jabatan_print=null;
		var karyawan_departemen_print=null;
		var karyawan_golongan_print=null;
		var karyawan_tglmasuk_print_date="";
		var karyawan_atasan_print=null;
		var karyawan_aktif_print=null;
		var win;              
		// check if we do have some search data...
		if(karyawan_DataStore.baseParams.query!==null){searchquery = karyawan_DataStore.baseParams.query;}
		if(karyawan_DataStore.baseParams.karyawan_no!==null){karyawan_no_print = karyawan_DataStore.baseParams.karyawan_no;}
		if(karyawan_DataStore.baseParams.karyawan_npwp!==null){karyawan_npwp_print = karyawan_DataStore.baseParams.karyawan_npwp;}
		if(karyawan_DataStore.baseParams.karyawan_username!==null){karyawan_username_print = karyawan_DataStore.baseParams.karyawan_username;}
		if(karyawan_DataStore.baseParams.karyawan_nama!==null){karyawan_nama_print = karyawan_DataStore.baseParams.karyawan_nama;}
		if(karyawan_DataStore.baseParams.karyawan_kelamin!==null){karyawan_kelamin_print = karyawan_DataStore.baseParams.karyawan_kelamin;}
		if(karyawan_DataStore.baseParams.karyawan_tgllahir!==""){karyawan_tgllahir_print_date = karyawan_DataStore.baseParams.karyawan_tgllahir;}
		if(karyawan_DataStore.baseParams.karyawan_alamat!==null){karyawan_alamat_print = karyawan_DataStore.baseParams.karyawan_alamat;}
		if(karyawan_DataStore.baseParams.karyawan_kota!==null){karyawan_kota_print = karyawan_DataStore.baseParams.karyawan_kota;}
		if(karyawan_DataStore.baseParams.karyawan_kodepos!==null){karyawan_kodepos_print = karyawan_DataStore.baseParams.karyawan_kodepos;}
		if(karyawan_DataStore.baseParams.karyawan_email!==null){karyawan_email_print = karyawan_DataStore.baseParams.karyawan_email;}
		if(karyawan_DataStore.baseParams.karyawan_emiracle!==null){karyawan_emiracle_print = karyawan_DataStore.baseParams.karyawan_emiracle;}
		if(karyawan_DataStore.baseParams.karyawan_keterangan!==null){karyawan_keterangan_print = karyawan_DataStore.baseParams.karyawan_keterangan;}
		if(karyawan_DataStore.baseParams.karyawan_notelp!==null){karyawan_notelp_print = karyawan_DataStore.baseParams.karyawan_notelp;}
		if(karyawan_DataStore.baseParams.karyawan_notelp2!==null){karyawan_notelp2_print = karyawan_DataStore.baseParams.karyawan_notelp2;}
		if(karyawan_DataStore.baseParams.karyawan_notelp3!==null){karyawan_notelp3_print = karyawan_DataStore.baseParams.karyawan_notelp3;}
		if(karyawan_DataStore.baseParams.karyawan_cabang!==null){karyawan_cabang_print = karyawan_DataStore.baseParams.karyawan_cabang;}
		if(karyawan_DataStore.baseParams.karyawan_jabatan!==null){karyawan_jabatan_print = karyawan_DataStore.baseParams.karyawan_jabatan;}
		if(karyawan_DataStore.baseParams.karyawan_departemen!==null){karyawan_departemen_print = karyawan_DataStore.baseParams.karyawan_departemen;}
		if(karyawan_DataStore.baseParams.karyawan_golongan!==null){karyawan_golongan_print = karyawan_DataStore.baseParams.karyawan_golongan;}
		if(karyawan_DataStore.baseParams.karyawan_tglmasuk!==""){karyawan_tglmasuk_print_date = karyawan_DataStore.baseParams.karyawan_tglmasuk;}
		if(karyawan_DataStore.baseParams.karyawan_atasan!==null){karyawan_atasan_print = karyawan_DataStore.baseParams.karyawan_atasan;}
		if(karyawan_DataStore.baseParams.karyawan_aktif!==null){karyawan_aktif_print = karyawan_DataStore.baseParams.karyawan_aktif;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_karyawan&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		
			karyawan_no : karyawan_no_print,
			karyawan_npwp : karyawan_npwp_print,
			karyawan_username : karyawan_username_print,
			karyawan_nama : karyawan_nama_print,
			karyawan_kelamin : karyawan_kelamin_print,
		  	karyawan_tgllahir : karyawan_tgllahir_print_date, 
			karyawan_alamat : karyawan_alamat_print,
			karyawan_kota : karyawan_kota_print,
			karyawan_kodepos : karyawan_kodepos_print,
			karyawan_email : karyawan_email_print,
			karyawan_emiracle : karyawan_emiracle_print,
			karyawan_keterangan : karyawan_keterangan_print,
			karyawan_notelp : karyawan_notelp_print,
			karyawan_notelp2 : karyawan_notelp2_print,
			karyawan_notelp3 : karyawan_notelp3_print,
			karyawan_cabang : karyawan_cabang_print,
			karyawan_jabatan : karyawan_jabatan_print,
			karyawan_departemen : karyawan_departemen_print,
			karyawan_idgolongan : karyawan_golongan_print,
		  	karyawan_tglmasuk : karyawan_tglmasuk_print_date, 
			karyawan_atasan : karyawan_atasan_print,
			karyawan_aktif : karyawan_aktif_print,
		  	currentlisting: karyawan_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./karyawanlist.html','karyawanlist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
				break;
		  	default:
				Ext.MessageBox.show({
					title: 'Warning',
					msg: 'Tidak bisa mencetak data!',
					buttons: Ext.MessageBox.OK,
					animEl: 'save',
					icon: Ext.MessageBox.WARNING
				});
				break;
		  	}  
		},
		failure: function(response){
		  	var result=response.responseText;
			Ext.MessageBox.show({
			   title: 'Error',
			   msg: 'Tidak bisa terhubung dengan database server',
			   buttons: Ext.MessageBox.OK,
			   animEl: 'database',
			   icon: Ext.MessageBox.ERROR
			});		
		} 	                     
		});
	}
	/* Enf Function */
	
	/* Function for print Export to Excel Grid */
	function karyawan_export_excel(){
		var searchquery = "";
		var karyawan_no_2excel=null;
		var karyawan_npwp_2excel=null;
		var karyawan_username_2excel=null;
		var karyawan_nama_2excel=null;
		var karyawan_kelamin_2excel=null;
		var karyawan_tgllahir_2excel_date="";
		var karyawan_alamat_2excel=null;
		var karyawan_kota_2excel=null;
		var karyawan_kodepos_2excel=null;
		var karyawan_email_2excel=null;
		var karyawan_emiracle_2excel=null;
		var karyawan_keterangan_2excel=null;
		var karyawan_notelp_2excel=null;
		var karyawan_notelp2_2excel=null;
		var karyawan_notelp3_2excel=null;
		var karyawan_cabang_2excel=null;
		var karyawan_jabatan_2excel=null;
		var karyawan_departemen_2excel=null;
		var karyawan_golongan_2excel=null;
		var karyawan_tglmasuk_2excel_date="";
		var karyawan_atasan_2excel=null;
		var karyawan_aktif_2excel=null;
		var win;              
		// check if we do have some search data...
		if(karyawan_DataStore.baseParams.query!==null){searchquery = karyawan_DataStore.baseParams.query;}
		if(karyawan_DataStore.baseParams.karyawan_no!==null){karyawan_no_2excel = karyawan_DataStore.baseParams.karyawan_no;}
		if(karyawan_DataStore.baseParams.karyawan_npwp!==null){karyawan_npwp_2excel = karyawan_DataStore.baseParams.karyawan_npwp;}
		if(karyawan_DataStore.baseParams.karyawan_username!==null){karyawan_username_2excel = karyawan_DataStore.baseParams.karyawan_username;}
		if(karyawan_DataStore.baseParams.karyawan_nama!==null){karyawan_nama_2excel = karyawan_DataStore.baseParams.karyawan_nama;}
		if(karyawan_DataStore.baseParams.karyawan_kelamin!==null){karyawan_kelamin_2excel = karyawan_DataStore.baseParams.karyawan_kelamin;}
		if(karyawan_DataStore.baseParams.karyawan_tgllahir!==""){karyawan_tgllahir_2excel_date = karyawan_DataStore.baseParams.karyawan_tgllahir;}
		if(karyawan_DataStore.baseParams.karyawan_alamat!==null){karyawan_alamat_2excel = karyawan_DataStore.baseParams.karyawan_alamat;}
		if(karyawan_DataStore.baseParams.karyawan_kota!==null){karyawan_kota_2excel = karyawan_DataStore.baseParams.karyawan_kota;}
		if(karyawan_DataStore.baseParams.karyawan_kodepos!==null){karyawan_kodepos_2excel = karyawan_DataStore.baseParams.karyawan_kodepos;}
		if(karyawan_DataStore.baseParams.karyawan_email!==null){karyawan_email_2excel = karyawan_DataStore.baseParams.karyawan_email;}
		if(karyawan_DataStore.baseParams.karyawan_emiracle!==null){karyawan_emiracle_2excel = karyawan_DataStore.baseParams.karyawan_emiracle;}
		if(karyawan_DataStore.baseParams.karyawan_keterangan!==null){karyawan_keterangan_2excel = karyawan_DataStore.baseParams.karyawan_keterangan;}
		if(karyawan_DataStore.baseParams.karyawan_notelp!==null){karyawan_notelp_2excel = karyawan_DataStore.baseParams.karyawan_notelp;}
		if(karyawan_DataStore.baseParams.karyawan_notelp2!==null){karyawan_notelp2_2excel = karyawan_DataStore.baseParams.karyawan_notelp2;}
		if(karyawan_DataStore.baseParams.karyawan_notelp3!==null){karyawan_notelp3_2excel = karyawan_DataStore.baseParams.karyawan_notelp3;}
		if(karyawan_DataStore.baseParams.karyawan_cabang!==null){karyawan_cabang_2excel = karyawan_DataStore.baseParams.karyawan_cabang;}
		if(karyawan_DataStore.baseParams.karyawan_jabatan!==null){karyawan_jabatan_2excel = karyawan_DataStore.baseParams.karyawan_jabatan;}
		if(karyawan_DataStore.baseParams.karyawan_departemen!==null){karyawan_departemen_2excel = karyawan_DataStore.baseParams.karyawan_departemen;}
		if(karyawan_DataStore.baseParams.karyawan_idgolongan!==null){karyawan_golongan_2excel = karyawan_DataStore.baseParams.karyawan_idgolongan;}
		if(karyawan_DataStore.baseParams.karyawan_tglmasuk!==""){karyawan_tglmasuk_2excel_date = karyawan_DataStore.baseParams.karyawan_tglmasuk;}
		if(karyawan_DataStore.baseParams.karyawan_atasan!==null){karyawan_atasan_2excel = karyawan_DataStore.baseParams.karyawan_atasan;}
		if(karyawan_DataStore.baseParams.karyawan_aktif!==null){karyawan_aktif_2excel = karyawan_DataStore.baseParams.karyawan_aktif;}

		Ext.Ajax.request({   
		waitMsg: 'Mohon tunggu...',
		url: 'index.php?c=c_karyawan&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		
			karyawan_no : karyawan_no_2excel,
			karyawan_npwp : karyawan_npwp_2excel,
			karyawan_username : karyawan_username_2excel,
			karyawan_nama : karyawan_nama_2excel,
			karyawan_kelamin : karyawan_kelamin_2excel,
		  	karyawan_tgllahir : karyawan_tgllahir_2excel_date, 
			karyawan_alamat : karyawan_alamat_2excel,
			karyawan_kota : karyawan_kota_2excel,
			karyawan_kodepos : karyawan_kodepos_2excel,
			karyawan_email : karyawan_email_2excel,
			karyawan_emiracle : karyawan_emiracle_2excel,
			karyawan_keterangan : karyawan_keterangan_2excel,
			karyawan_notelp : karyawan_notelp_2excel,
			karyawan_notelp2 : karyawan_notelp2_2excel,
			karyawan_notelp3 : karyawan_notelp3_2excel,
			karyawan_cabang : karyawan_cabang_2excel,
			karyawan_jabatan : karyawan_jabatan_2excel,
			karyawan_departemen : karyawan_departemen_2excel,
			karyawan_idgolongan : karyawan_golongan_2excel,
		  	karyawan_tglmasuk : karyawan_tglmasuk_2excel_date, 
			karyawan_atasan : karyawan_atasan_2excel,
			karyawan_aktif : karyawan_aktif_2excel,
		  	currentlisting: karyawan_DataStore.baseParams.task // this tells us if we are searching or not
		},
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.location=('./export2excel.php');
				break;
		  	default:
				Ext.MessageBox.show({
					title: 'Warning',
					msg: 'Tidak bisa meng-export data ke dalam format excel!',
					buttons: Ext.MessageBox.OK,
					animEl: 'save',
					icon: Ext.MessageBox.WARNING
				});
				break;
		  	}  
		},
		failure: function(response){
		  	var result=response.responseText;
			Ext.MessageBox.show({
			   title: 'Error',
			   msg: 'Tidak bisa terhubung dengan database server',
			   buttons: Ext.MessageBox.OK,
			   animEl: 'database',
			   icon: Ext.MessageBox.ERROR
			});    
		} 	                     
		});
	}
	/*End of Function */		
	
});
	
	
	
	// EVENTS
	// Event utk sub kategori
	karyawan_marriageField.on("select", function(){
		if(karyawan_marriageField.getValue()=='Marriage'){
			karyawan_jmlanakField.setDisabled(false);
		}else if(karyawan_marriageField.getValue()=='Single'){
			karyawan_jmlanakField.setDisabled(true);
		}
	});
	
	// otomatis mengisi jum hari
	/*
	kcuti_tglawalField.on("select", function(){
		kcuti_jmlhariField.setValue(((kcuti_tglakhirField.getValue()-kcuti_tglawalField.getValue())/86400000)+1); 		
	});
	kcuti_tglakhirField.on("select", function(){
		kcuti_jmlhariField.setValue(((kcuti_tglakhirField.getValue()-kcuti_tglawalField.getValue())/86400000)+1); 		
	});
	*/

	
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_karyawan"></div>
		<div id="fp_detail_status_karyawan"></div>
		<div id="fp_detail_jabatan"></div>
		<div id="fp_detail_pendidikan"></div>
		<div id="fp_detail_keluarga"></div>
		<div id="fp_detail_cuti"></div>
		<div id="fp_detail_gantioff"></div>
		<div id="fp_detail_medical"></div>
		<div id="fp_detail_fasilitas"></div>
		<div id="elwindow_karyawan_create"></div>
        <div id="elwindow_karyawan_search"></div>
    </div>
</div>
</body>