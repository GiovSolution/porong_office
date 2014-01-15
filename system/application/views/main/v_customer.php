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
var customer_DataStore;
var customer_ColumnModel;
var customerListEditorGrid;
var cust_noteListEditorGrid;
var cust_memberListEditorGrid;
var customer_createForm;
var customer_createWindow;
var customer_searchForm;
var customer_searchWindow;
var customer_SelectedRow;
var customer_ContextMenu;
var customer_phonegroup_saveForm;
//declare konstant
var post2db = '';
var msg = '';
var pageS=15;
var thismonth=new Date().format('m');

/* declare variable here */
var cust_idField;
//var cust_nolamaField;
var cust_noField;
var cust_memberField;
var cust_titleField;
var cust_namaField;
var cust_pangglianField;
var cust_kelaminField;
var cust_alamatField;
var cust_kotaField;
var cust_kodeposField;
var cust_propinsiField;
var cust_negaraField;
var cust_alamat2Field;
var cust_kota2Field;
var cust_kodepos2Field;
var cust_propinsi2Field;
var cust_negara2Field;
var cust_telprumahField;
var cust_telprumah2Field;
var cust_telpkantorField;
var cust_hpField;
var cust_hp2Field;
var cust_hp3Field;
var cust_bbField;
var cust_emailField;
var cust_fbField;
var cust_tweeterField;
var cust_email2Field;
var cust_fb2Field;
var cust_tweeter2Field;
var cust_agamaField;
var cust_pendidikanField;
var cust_profesiField;
var cust_tmptlahirField;
var cust_tgllahirField;
var cust_hobiField;
var cust_referensiField;
var cust_referensilainField;
var cust_keteranganField;
var cust_terdaftarField;
var cust_tglawaltransField;
var cust_statusnikahField;
var cust_priorityField;
var cust_crm_dateField;
var cust_jmlanakField;
var cust_unitField;
var cust_aktifField;
var cust_fretfulnessField;
var dt = new Date();
var customer_phonegroup_namaField;

var cust_idSearchField;
var cust_nolamaSearchField;
var cust_noSearchField;
var cust_no_awalSearchField;
var cust_no_akhirSearchField;
var cust_namaSearchField;
var cust_panggilanSearchField;
var cust_foreignerSearchField;
var cust_kelaminSearchField;
var cust_alamatSearchField;
//var cust_alamat2SearchField;
var cust_kotaSearchField;
var cust_kodeposSearchField;
var cust_propinsiSearchField;
var cust_negaraSearchField;
var cust_telprumahSearchField;
//var cust_telprumah2SearchField;
//var cust_telpkantorSearchField;
//var cust_hpSearchField;
//var cust_hp2SearchField;
//var cust_hp3SearchField;
var cust_bbSearchField;
var cust_emailSearchField;
var cust_fbSearchField;
var cust_tweeterSearchField;
//var cust_email2SearchField;
var cust_fb2SearchField;
var cust_tweeter2SearchField;
var cust_agamaSearchField;
var cust_pendidikanSearchField;
var cust_profesiSearchField;
var cust_tmptlahirSearchField;
var cust_tgllahirSearchField;
var cust_tgllahirSearchFieldEnd;
var cust_hobiSearchField;
var cust_referensiSearchField;
var cust_referensilainSearchField;
var cust_keteranganSearchField;
var cust_memberSearchField;
var cust_memberSearch2Field;
var cust_terdaftarSearchField;
var cust_tgldaftarSearchFieldEnd;
var member_terdaftarSearchField;
var member_tgldaftarSearchFieldEnd;
var cust_tglawaltransSearchField;
var cust_tglawaltransSearchFieldEnd;
var cust_statusnikahSearchField;
var cust_prioritySearchField;
var cust_jmlanakSearchField;
var cust_unitSearchField;
var cust_aktifSearchField;
var sortby_SearchField;
var fretfulness_SearchField;
var cust_umurstartSearchField;
var cust_umurendSearchField;
var cust_bulanSearchField;
var cust_tglSearchField;
var today=new Date().format('Y-m-d');

var editor_cust_note;
/* Function for get PK field */
	function get_pk_id(){
		if(post2db=='UPDATE')
			return customerListEditorGrid.getSelectionModel().getSelected().get('cust_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function customer_reset_form(){
		cust_noField.reset();
		//cust_nolamaField.reset();
		cust_memberField.reset();
		cust_namaField.reset();
		cust_panggilanField.reset();
		cust_foreignerField.reset();
		cust_kelaminField.reset();
		cust_titleField.reset();
		cust_alamatField.reset();
		cust_kotaField.reset();
		cust_kodeposField.reset();
		cust_propinsiField.reset();
		cust_negaraField.reset();
		cust_alamat2Field.reset();
		cust_kota2Field.reset();
		cust_kodepos2Field.reset();
		cust_propinsi2Field.reset();
		cust_negara2Field.reset();
		cust_telprumahField.reset();
		cust_telprumah2Field.reset();
		cust_telpkantorField.reset();
		cust_hpField.reset();
		cust_hp2Field.reset();
		cust_hp3Field.reset();
		cust_bbField.reset();
		cust_emailField.reset();
		cust_fbField.reset();
		cust_tweeterField.reset();
		cust_email2Field.reset();
		cust_fb2Field.reset();
		cust_tweeter2Field.reset();
		cust_agamaField.reset();
		cust_pendidikanField.reset();
		cust_profesiField.reset();
		cust_profesitxtField.reset();
		cust_tmptlahirField.reset();
		cust_tgllahirField.reset();
		//cust_hobiField.reset();
		//cust_hobitxtField.reset();
		cust_hobi_bacaField.reset();
		cust_hobi_olahField.reset();
		cust_hobi_masakField.reset();
		cust_hobi_travelField.reset();
		cust_hobi_fotoField.reset();
		cust_hobi_lukisField.reset();
		cust_hobi_nariField.reset();
		cust_hobi_lainField.reset();
		cust_referensiField.reset();
		cust_referensilainField.reset();
		//cust_referensilaintxtField.reset();
		cust_keteranganField.reset();
		cust_terdaftarField.reset();
		cust_tglawaltransField.reset();
		cust_statusnikahField.reset();
		cust_priorityField.reset();
		cust_crm_dateField.reset();
		cust_crm_valueField.reset();
		cust_jmlanakField.reset();
		cust_unitField.reset();
		cust_aktifField.reset();
		cust_fretfulnessField.reset();
		cust_cpField.reset();
		cust_cptelpField.reset();
		cust_umurField.reset();
		
		cust_noField.setValue('(Auto)');
		//cust_nolamaField.setValue(null);
		cust_keteranganField.setValue(true);
		cust_terdaftarField.setValue(true);
		cust_tglawaltransField.setValue(true);
		cust_statusnikahField.setValue(true);
		cust_priorityField.setValue(true);
		cust_crm_dateField.setValue(true);
		cust_crm_valueField.setValue(true);
		cust_jmlanakField.setValue(true);
		cust_unitField.setValue(true);
		cust_aktifField.setValue(true);
		cust_fretfulnessField.setValue('Medium');
		cust_cpField.setValue(true);
		cust_cptelpField.setValue(true);
		cust_umurField.setValue(true);
		cust_memberField.setValue(null);
		cust_namaField.setValue(null);
		cust_panggilanField.setValue(null);
		cust_foreignerField.setValue(null);
		cust_kelaminField.setValue(null);
		cust_titleField.setValue(null);
		cust_alamatField.setValue(null);
		cust_kotaField.setValue(null);
		cust_kodeposField.setValue(null);
		cust_propinsiField.setValue(null);
		cust_negaraField.setValue(null);
		cust_alamat2Field.setValue(null);
		cust_kota2Field.setValue(null);
		cust_kodepos2Field.setValue(null);
		cust_propinsi2Field.setValue(null);
		cust_negara2Field.setValue(null);
		cust_telprumahField.setValue(null);
		cust_telprumah2Field.setValue(null);
		cust_telpkantorField.setValue(null);
		cust_hpField.setValue(null);
		cust_hp2Field.setValue(null);
		cust_hp3Field.setValue(null);
		cust_bbField.setValue(null);
		cust_emailField.setValue(null);
		cust_fbField.setValue(null);
		cust_tweeterField.setValue(null);
		cust_email2Field.setValue(null);
		cust_fb2Field.setValue(null);
		cust_tweeter2Field.setValue(null);
		cust_agamaField.setValue(null);
		cust_pendidikanField.setValue(null);
		cust_profesiField.setValue(null);
		cust_profesitxtField.setValue(null);
		cust_tmptlahirField.setValue(null);
		cust_tgllahirField.setValue(null);
		//cust_hobiField.setValue(null);
		//cust_hobitxtField.setValue(null);
		cust_hobi_bacaField.setValue(null);
		cust_hobi_olahField.setValue(null);
		cust_hobi_masakField.setValue(null);
		cust_hobi_travelField.setValue(null);
		cust_hobi_fotoField.setValue(null);
		cust_hobi_lukisField.setValue(null);
		cust_hobi_nariField.setValue(null);
		cust_hobi_lainField.setValue(null);
		cust_referensiField.setValue(null);
		cust_referensilainField.setValue(null);
		cust_referensiField.setValue(null);
		cust_referensilainField.setValue(null);
		//cust_referensilaintxtField.setValue(null);
		cust_keteranganField.setValue(null);
		cust_terdaftarField.setValue(null);
		cust_tglawaltransField.setValue(null);
		cust_statusnikahField.setValue(null);
		cust_priorityField.setValue(null);
		cust_crm_dateField.setValue(null);
		//cust_crm_dateField.setValue(null);
		cust_crm_valueField.setValue(null);
		cust_jmlanakField.setValue(null);
		cust_unitField.setValue(null);
		cust_aktifField.setValue(null);
		cust_aktifField.setValue('Medium');
		cust_cpField.setValue(null);
		cust_cptelpField.setValue(null);
		cust_umurField.setValue(null);	
	}
 	/* End of Function */
	
	function customer_set_defaultForm(){
		//cust_unitField.setValue('Miracle Thamrin');
		cust_aktifField.setValue('Aktif');
		cbo_cust_cabang_DataStore.load({
					//params : { cabang_id: cabangField.getValue() },
				callback: function(opts, success, response)  {
					 if (success) {
						if(cbo_cust_cabang_DataStore.getCount()){
							info_auto_cabang=cbo_cust_cabang_DataStore.getAt(0).data;
							cust_unitField.setValue(info_auto_cabang.cust_cabang_display);
							//info_alamatField.setValue(info_auto_nama.cabang_alamat);
							//info_id_cabangField.setValue(info_auto_nama.cabang_id);
							if(cust_unitField.getValue()=='Miracle Thamrin' || cust_unitField.getValue()=='Miracle HR Muhammad' || cust_unitField.getValue()=='Miracle Kertajaya Indah' || cust_unitField.getValue()=='Miracle Tunjungan Plaza')
							{
							cust_kotaField.setValue('Surabaya');
							cust_propinsiField.setValue('Jawa Timur');
							cust_negaraField.setValue('Indonesia');
							cust_priorityField.setValue('Reguler');
							}
							else if(cust_unitField.getValue()=='Miracle Malang')
							{
							cust_kotaField.setValue('Malang');
							cust_propinsiField.setValue('Jawa Timur');
							cust_negaraField.setValue('Indonesia');
							cust_priorityField.setValue('Reguler');
							}
							else if(cust_unitField.getValue()=='Miracle Malang')
							{
							cust_kotaField.setValue('Malang');
							cust_propinsiField.setValue('Jawa Timur');
							cust_negaraField.setValue('Indonesia');
							cust_priorityField.setValue('Reguler');
							}
							else if(cust_unitField.getValue()=='Miracle Denpasar'|| cust_unitField.getValue()=='Miracle Kuta')
							{
							cust_kotaField.setValue('Denpasar');
							cust_propinsiField.setValue('Bali');
							cust_negaraField.setValue('Indonesia');
							cust_priorityField.setValue('Reguler');
							}
							else if(cust_unitField.getValue()=='Miracle Jakarta'|| cust_unitField.getValue()=='Mall Taman Anggrek')
							{
							cust_kotaField.setValue('Jakarta');
							cust_propinsiField.setValue('DKI Jakarta');
							cust_negaraField.setValue('Indonesia');
							cust_priorityField.setValue('Reguler');
							}
							else if(cust_unitField.getValue()=='Miracle Makassar')
							{
							cust_kotaField.setValue('Makassar');
							cust_propinsiField.setValue('Sulawesi Selatan');
							cust_negaraField.setValue('Indonesia');
							cust_priorityField.setValue('Reguler');
							}
							else if(cust_unitField.getValue()=='Miracle Balikpapan')
							{
							cust_kotaField.setValue('Balikpapan');
							cust_propinsiField.setValue('Kalimantan Timur');
							cust_negaraField.setValue('Indonesia');
							cust_priorityField.setValue('Reguler');
							}
							else if(cust_unitField.getValue()=='Miracle Batam')
							{
							cust_kotaField.setValue('Batam');
							cust_propinsiField.setValue('Kep. Riau');
							cust_negaraField.setValue('Indonesia');
							cust_priorityField.setValue('Reguler');
							}
							else if(cust_unitField.getValue()=='Miracle Medan')
							{
							cust_kotaField.setValue('Medan');
							cust_propinsiField.setValue('Sumatera Utara');
							cust_negaraField.setValue('Indonesia');
							cust_priorityField.setValue('Reguler');
							}
							else if(cust_unitField.getValue()=='Miracle Lombok')
							{
							cust_kotaField.setValue('Mataram');
							cust_propinsiField.setValue('NTB');
							cust_negaraField.setValue('Indonesia');
							cust_priorityField.setValue('Reguler');
							}
							else if(cust_unitField.getValue()=='Miracle Manado')
							{
							cust_kotaField.setValue('Manado');
							cust_propinsiField.setValue('Sulawesi Utara');
							cust_negaraField.setValue('Indonesia');
							cust_priorityField.setValue('Reguler');
							}
							else if(cust_unitField.getValue()=='Miracle Yogyakarta')
							{
							cust_kotaField.setValue('Yogyakarta');
							cust_propinsiField.setValue('DI Yogyakarta');
							cust_negaraField.setValue('Indonesia');
							cust_priorityField.setValue('Reguler');
							}
						}
					}
				}
			}); 	
	}
  
  /* Reset form before loading */
	function customer_phonegroup_reset_form(){
		customer_phonegroup_namaField.reset();
		cust_delete_phonegroupField.reset();
		customer_phonegroup_namaField.setValue(null);
		//phonenumber_DataStore.removeAll();
		//phonegrouped_DataStore.removeAll();
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function customer_set_form(){
		customer_reset_form();
		cust_noField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_no'));
		//cust_nolamaField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_nolama'));
		cust_namaField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_nama'));
		cust_panggilanField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_panggilan'));
		cust_foreignerField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_foreigner'));
		cust_kelaminField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_kelamin'));
		cust_titleField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_title'));
		cust_alamatField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_alamat'));
		cust_kotaField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_kota'));
		cust_kodeposField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_kodepos'));
		cust_propinsiField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_propinsi'));
		cust_negaraField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_negara'));
		cust_alamat2Field.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_alamat2'));
		cust_kota2Field.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_kota2'));
		cust_kodepos2Field.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_kodepos2'));
		cust_propinsi2Field.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_propinsi2'));
		cust_negara2Field.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_negara2'));
		cust_telprumahField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_telprumah'));
		cust_telprumah2Field.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_telprumah2'));
		cust_telpkantorField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_telpkantor'));
		cust_hpField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_hp'));
		cust_hp2Field.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_hp2'));
		cust_hp3Field.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_hp3'));
		cust_bbField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_bb'));
		cust_emailField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_email'));
		cust_email2Field.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_email2'));
		cust_agamaField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_agama'));
		cust_pendidikanField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_pendidikan'));
		cust_profesiField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_profesi'));
		cust_tmptlahirField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_tmptlahir'));
		cust_tgllahirField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_tgllahir'));
		//cust_hobiField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_hobi'));
		cust_referensiField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_nama_ref'));
		cust_referensilainField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_referensilain'));
		cust_keteranganField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_keterangan'));
		cust_terdaftarField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_terdaftar'));
		cust_tglawaltransField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_tglawaltrans'));
		cust_statusnikahField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_statusnikah'));
		//cust_priorityField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_priority'));
		cust_jmlanakField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_jmlanak'));
		cust_unitField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_unit'));
		cust_aktifField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_aktif'));
		cust_fretfulnessField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_fretfulness'));
		cust_cpField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_cp'));
		cust_cptelpField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_cptelp'));
		cust_fbField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_fb'));
		cust_tweeterField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_tweeter'));
		cust_fb2Field.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_fb2'));
		cust_tweeter2Field.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('cust_tweeter2'));
		cust_memberField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('member_no'));
		cust_priorityField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('crmvalue_priority'));
		cust_crm_valueField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('crmvalue_total'));
		cust_crm_dateField.setValue(customerListEditorGrid.getSelectionModel().getSelected().get('crmvalue_date'));
		
		if(customerListEditorGrid.getSelectionModel().getSelected().get('cust_hobi').charAt(0)=="1")	
			cust_hobi_bacaField.setValue(true);	
		if(customerListEditorGrid.getSelectionModel().getSelected().get('cust_hobi').charAt(0)=="0")
			cust_hobi_bacaField.setValue(false);
		
		if(customerListEditorGrid.getSelectionModel().getSelected().get('cust_hobi').charAt(1)=="1")	
			cust_hobi_olahField.setValue(true);	
		if(customerListEditorGrid.getSelectionModel().getSelected().get('cust_hobi').charAt(1)=="0")
			cust_hobi_olahField.setValue(false);
		
		if(customerListEditorGrid.getSelectionModel().getSelected().get('cust_hobi').charAt(2)=="1")	
			cust_hobi_masakField.setValue(true);	
		if(customerListEditorGrid.getSelectionModel().getSelected().get('cust_hobi').charAt(2)=="0")
			cust_hobi_masakField.setValue(false);
		
		if(customerListEditorGrid.getSelectionModel().getSelected().get('cust_hobi').charAt(3)=="1")
			cust_hobi_travelField.setValue(true);	
		if(customerListEditorGrid.getSelectionModel().getSelected().get('cust_hobi').charAt(3)=="0")
			cust_hobi_travelField.setValue(false);
		
		if(customerListEditorGrid.getSelectionModel().getSelected().get('cust_hobi').charAt(4)=="1")	
			cust_hobi_fotoField.setValue(true);	
		if(customerListEditorGrid.getSelectionModel().getSelected().get('cust_hobi').charAt(4)=="0")
			cust_hobi_fotoField.setValue(false);
		
		if(customerListEditorGrid.getSelectionModel().getSelected().get('cust_hobi').charAt(5)=="1")	
			cust_hobi_lukisField.setValue(true);	
		if(customerListEditorGrid.getSelectionModel().getSelected().get('cust_hobi').charAt(5)=="0")
			cust_hobi_lukisField.setValue(false);
		
		if(customerListEditorGrid.getSelectionModel().getSelected().get('cust_hobi').charAt(6)=="1")	
			cust_hobi_nariField.setValue(true);	
		if(customerListEditorGrid.getSelectionModel().getSelected().get('cust_hobi').charAt(6)=="0")
			cust_hobi_nariField.setValue(false);
		
		if(customerListEditorGrid.getSelectionModel().getSelected().get('cust_hobi').charAt(7)=="1")	
			cust_hobi_lainField.setValue(true);	
		if(customerListEditorGrid.getSelectionModel().getSelected().get('cust_hobi').charAt(7)=="0")
			cust_hobi_lainField.setValue(false);
			
/*		cust_member_DataStore.load({
			params:{cust_id: customerListEditorGrid.getSelectionModel().getSelected().get('cust_id'), start: 0, limit: pageS },
			callback: function(opts, success, response)  {
				if (success) {
					j=cust_member_DataStore.findExact('member_aktif','Y',0);
					if(j>-1) cust_memberField.setValue(cust_member_DataStore.getAt(j).data.member_no);
				}
			}
		});
*/		

		cust_note_DataStore.load({
			params:{cust_id: customerListEditorGrid.getSelectionModel().getSelected().get('cust_id'), start: 0, limit: pageS }
		});
		
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_customer_form_valid(){
		return (cust_namaField.isValid() && cust_noField.isValid() && cust_kelaminField.isValid());
	}
  	/* End of Function */
  
  /* Function for add and edit data form, open window form */
	function customer_phonegroup_save(){

			var customer_phonegroup_id_field_pk=null;
			var customer_phonegroup_nama_field=null;
			var hapus_cust=0;
			var phonegroupquery = "";
			var cust_phonegroup_no=null;
			var cust_phonegroup_nolama=null;
			var cust_phonegroup_no_awal=null;
			var cust_phonegroup_no_akhir=null;
			var cust_phonegroup_nama=null;
			var cust_phonegroup_panggilan=null;
			var cust_phonegroup_foreigner=null;
			var cust_phonegroup_kelamin=null;
			var cust_phonegroup_alamat=null;
			var cust_phonegroup_alamat2=null;
			var cust_phonegroup_kota=null;
			var cust_phonegroup_kodepos=null;
			var cust_phonegroup_propinsi=null;
			var cust_phonegroup_negara=null;
			var cust_phonegroup_telprumah=null;
			var cust_phonegroup_telprumah2=null;
			var cust_phonegroup_telpkantor=null;
			var cust_phonegroup_hp=null;
			var cust_phonegroup_hp2=null;
			var cust_phonegroup_hp3=null;
			var cust_phonegroup_email=null;
			var cust_phonegroup_agama=null;
			var cust_phonegroup_pendidikan=null;
			var cust_phonegroup_profesi=null;
			var cust_phonegroup_tgllahir_date="";
			var cust_phonegroup_tgllahir_dateEnd="";

			//var cust_phonegroup_hobi=null;
			var cust_phonegroup_referensi=null;
			var cust_phonegroup_keterangan=null;
			var cust_phonegroup_member=null;
			var cust_phonegroup_member2=null;
			var cust_phonegroup_terdaftar_date="";
			var cust_phonegroup_tglawaltrans_date="";
			var cust_phonegroup_statusnikah=null;
			var cust_phonegroup_priority=null;
			var cust_phonegroup_jmlanak=null;
			var cust_phonegroup_unit=null;
			var cust_phonegroup_aktif=null;
			var sortby_phonegroup=null;
			var cust_fretfulness_phonegroup=null;
			var cust_umurstart_phonegroup=null;
			var cust_umurend_phonegroup=null;
			var cust_tgl_phonegroup=null;
			var cust_bulan_phonegroup=null;
			var cust_bb_phonegroup=null;
			var cust_terdaftar_date_phonegroup="";
			var cust_tgldaftar_dateEnd_phonegroup="";
			var member_terdaftar_date_phonegroup="";
			var member_tgldaftar_dateEnd_phonegroup="";			
			var cust_tglawaltrans_date_phonegroup="";
			var cust_tglawaltrans_dateEnd_phonegroup="";
			var cust_tgl_transaksi_date_phonegroup="";
			var cust_tgl_transaksi_dateEnd_phonegroup="";
			var cust_tidak_tgl_transaksi_date_phonegroup="";
			var cust_tidak_tgl_transaksi_dateEnd_phonegroup="";
			var cust_tgllahir_phonegroup_date="";
			var cust_tgllahir_phonegroup_dateEnd="";
			
			// check if we do have some search data...
			if(customer_DataStore.baseParams.query!==null){phonegroupquery = customer_DataStore.baseParams.query;}
			if(customer_DataStore.baseParams.cust_no!==null){cust_phonegroup_no = customer_DataStore.baseParams.cust_no;}
			if(customer_DataStore.baseParams.cust_nolama!==null){cust_phonegroup_nolama = customer_DataStore.baseParams.cust_nolama;}
			if(customer_DataStore.baseParams.cust_no_awal!==null){cust_phonegroup_no_awal = customer_DataStore.baseParams.cust_no_awal;}
			if(customer_DataStore.baseParams.cust_no_akhir!==null){cust_phonegroup_no_akhir = customer_DataStore.baseParams.cust_no_akhir;}
			if(customer_DataStore.baseParams.cust_nama!==null){cust_phonegroup_nama = customer_DataStore.baseParams.cust_nama;}
			if(customer_DataStore.baseParams.cust_panggilan!==null){cust_phonegroup_panggilan = customer_DataStore.baseParams.cust_panggilan;}
			if(customer_DataStore.baseParams.cust_foreigner!==null){cust_phonegroup_foreigner = customer_DataStore.baseParams.cust_foreigner;}
			if(customer_DataStore.baseParams.cust_kelamin!==null){cust_phonegroup_kelamin = customer_DataStore.baseParams.cust_kelamin;}
			if(customer_DataStore.baseParams.cust_alamat!==null){cust_phonegroup_alamat = customer_DataStore.baseParams.cust_alamat;}
			if(customer_DataStore.baseParams.cust_alamat2!==null){cust_phonegroup_alamat2 = customer_DataStore.baseParams.cust_alamat2;}
			if(customer_DataStore.baseParams.cust_kota!==null){cust_phonegroup_kota = customer_DataStore.baseParams.cust_kota;}
			if(customer_DataStore.baseParams.cust_kodepos!==null){cust_phonegroup_kodepos = customer_DataStore.baseParams.cust_kodepos;}
			if(customer_DataStore.baseParams.cust_propinsi!==null){cust_phonegroup_propinsi = customer_DataStore.baseParams.cust_propinsi;}
			if(customer_DataStore.baseParams.cust_negara!==null){cust_phonegroup_negara = customer_DataStore.baseParams.cust_negara;}
			if(customer_DataStore.baseParams.cust_telprumah!==null){cust_phonegroup_telprumah = customer_DataStore.baseParams.cust_telprumah;}
			if(customer_DataStore.baseParams.cust_telprumah2!==null){cust_phonegroup_telprumah2 = customer_DataStore.baseParams.cust_telprumah2;}
			if(customer_DataStore.baseParams.cust_telpkantor!==null){cust_phonegroup_telpkantor = customer_DataStore.baseParams.cust_telpkantor;}
			if(customer_DataStore.baseParams.cust_hp!==null){cust_phonegroup_hp = customer_DataStore.baseParams.cust_hp;}
			if(customer_DataStore.baseParams.cust_hp2!==null){cust_phonegroup_hp2 = customer_DataStore.baseParams.cust_hp2;}
			if(customer_DataStore.baseParams.cust_hp3!==null){cust_phonegroup_hp3 = customer_DataStore.baseParams.cust_hp3;}
			if(customer_DataStore.baseParams.cust_email!==null){cust_phonegroup_email = customer_DataStore.baseParams.cust_email;}
			if(customer_DataStore.baseParams.cust_agama!==null){cust_phonegroup_agama = customer_DataStore.baseParams.cust_agama;}
			if(customer_DataStore.baseParams.cust_pendidikan!==null){cust_phonegroup_pendidikan = customer_DataStore.baseParams.cust_pendidikan;}
			if(customer_DataStore.baseParams.cust_profesi!==null){cust_phonegroup_profesi = customer_DataStore.baseParams.cust_profesi;}
			if(customer_DataStore.baseParams.cust_tgllahir!==""){cust_phonegroup_tgllahir_date = customer_DataStore.baseParams.cust_tgllahir;}
			if(customer_DataStore.baseParams.cust_tgllahirend!==""){cust_phonegroup_tgllahir_dateEnd = customer_DataStore.baseParams.cust_tgllahirend;}
			//if(customer_DataStore.baseParams.cust_hobi!==null){cust_phonegroup_hobi = customer_DataStore.baseParams.cust_hobi;}
			if(customer_DataStore.baseParams.cust_referensi!==null){cust_phonegroup_referensi = customer_DataStore.baseParams.cust_referensi;}
			if(customer_DataStore.baseParams.cust_keterangan!==null){cust_phonegroup_keterangan = customer_DataStore.baseParams.cust_keterangan;}
			if(customer_DataStore.baseParams.cust_member!==null){cust_phonegroup_member = customer_DataStore.baseParams.cust_member;}
			if(customer_DataStore.baseParams.cust_member2!==null){cust_phonegroup_member2 = customer_DataStore.baseParams.cust_member2;}
			if(customer_DataStore.baseParams.cust_terdaftar!==""){cust_phonegroup_terdaftar_date = customer_DataStore.baseParams.cust_terdaftar;}
			if(customer_DataStore.baseParams.cust_tglawaltrans!==""){cust_phonegroup_terdaftar_date = customer_DataStore.baseParams.cust_tglawaltrans;}
			
			if(customer_DataStore.baseParams.cust_statusnikah!==null){cust_phonegroup_statusnikah = customer_DataStore.baseParams.cust_statusnikah;}
			if(customer_DataStore.baseParams.cust_priority!==null){cust_phonegroup_priority = customer_DataStore.baseParams.cust_priority;}
			if(customer_DataStore.baseParams.cust_jmlanak!==null){cust_phonegroup_jmlanak = customer_DataStore.baseParams.cust_jmlanak;}
			if(customer_DataStore.baseParams.cust_unit!==null){cust_phonegroup_unit = customer_DataStore.baseParams.cust_unit;}
			if(customer_DataStore.baseParams.cust_aktif!==null){cust_phonegroup_aktif = customer_DataStore.baseParams.cust_aktif;}
			if(sortby_SearchField.getValue()!==null){sortby=sortby_SearchField.getValue();}
			
			if(customer_DataStore.baseParams.cust_fretfulness!==null){cust_fretfulness_phonegroup = customer_DataStore.baseParams.cust_fretfulness;}
			if(customer_DataStore.baseParams.cust_umurstart!==null){cust_umurstart_phonegroup=customer_DataStore.baseParams.cust_umurstart;}
			if(customer_DataStore.baseParams.cust_umurend!==null){cust_umurend_phonegroup=customer_DataStore.baseParams.cust_umurend;}	
			if(cust_terdaftarSearchField.getValue()!==""){cust_terdaftar_date_phonegroup=cust_terdaftarSearchField.getValue().format('Y-m-d');}
			if(cust_tgldaftarSearchFieldEnd.getValue()!==""){cust_tgldaftar_dateEnd_phonegroup=cust_tgldaftarSearchFieldEnd.getValue().format('Y-m-d');}
			
			if(member_terdaftarSearchField.getValue()!==""){member_terdaftar_date_phonegroup=member_terdaftarSearchField.getValue().format('Y-m-d');}
			if(member_tgldaftarSearchFieldEnd.getValue()!==""){member_tgldaftar_dateEnd_phonegroup=member_tgldaftarSearchFieldEnd.getValue().format('Y-m-d');}
			
			if(cust_tglawaltransSearchField.getValue()!==""){cust_tglawaltrans_date_phonegroup=cust_tglawaltransSearchField.getValue().format('Y-m-d');}
			if(cust_tglawaltransSearchFieldEnd.getValue()!==""){cust_tglawaltrans_dateEnd_phonegroup=cust_tglawaltransSearchFieldEnd.getValue().format('Y-m-d');}
			
			//if(cust_tgltransaksi_opsiField.getValue()==true){
			if(cust_tgl_transaksiSearchFieldStart.getValue()!==""){cust_tgl_transaksi_date_phonegroup=cust_tgl_transaksiSearchFieldStart.getValue().format('Y-m-d');}
			if(cust_tgl_transaksiSearchFieldEnd.getValue()!==""){cust_tgl_transaksi_dateEnd_phonegroup=cust_tgl_transaksiSearchFieldEnd.getValue().format('Y-m-d');}
		//}
		//else if(cust_tidak_tgltransaksi_opsiField.getValue()==true){
			if(cust_tidak_tgl_transaksiSearchFieldStart.getValue()!==""){cust_tidak_tgl_transaksi_date_phonegroup=cust_tidak_tgl_transaksiSearchFieldStart.getValue().format('Y-m-d');}
			if(cust_tidak_tgl_transaksiSearchFieldEnd.getValue()!==""){cust_tidak_tgl_transaksi_dateEnd_phonegroup=cust_tidak_tgl_transaksiSearchFieldEnd.getValue().format('Y-m-d');}
		//}
		
		//if(cust_tgl_opsiField.getValue()==true){			
			if(cust_tgllahirSearchField.getValue()!==""){cust_tgllahir_phonegroup_date=cust_tgllahirSearchField.getValue().format('Y-m-d');}
			if(cust_tgllahirSearchFieldEnd.getValue()!==""){cust_tgllahir_phonegroup_dateEnd=cust_tgllahirSearchFieldEnd.getValue().format('Y-m-d');}
		//}		
		//else if(cust_bulan_opsiField.getValue()==true){
			if(cust_tglSearchField.getValue()!==null){cust_tgl_phonegroup=cust_tglSearchField.getValue();}
			if(cust_bulanSearchField.getValue()!==null){cust_bulan_phonegroup=cust_bulanSearchField.getValue();}
			if(cust_tglSearchFieldEnd.getValue()!==null){cust_tgl_phonegroupEnd=cust_tglSearchFieldEnd.getValue();}
			if(cust_bulanSearchFieldEnd.getValue()!==null){cust_bulan_phonegroupEnd=cust_bulanSearchFieldEnd.getValue();}
		//}

		//konfirmasi untuk menghapus data phonegroup yang telah ada	
		if(cust_delete_phonegroupField.getValue(true)){
			hapus_cust = 1;
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus detail Phone Group yang sebelumnya? Detail Phone Group yang telah terhapus tidak bisa dikembalikan lagi', cust_delete_phonegroup);
		}else{
			hapus_cust = 0;
			cust_delete_phonegroup('yes');
		}
		
		function cust_delete_phonegroup(btn){
			if(btn=='yes' )
			{
				Ext.Ajax.request({  
					waitMsg: 'Please wait...',
					url: 'index.php?c=c_customer&m=get_action',
					params: {
		
						task: 'PHONEGROUP',
						query: phonegroupquery, 
						hapus_cust : hapus_cust,
						phonegroup_id : customer_phonegroup_namaField.getValue(),
						cust_no : cust_phonegroup_no,
						cust_nolama :cust_phonegroup_nolama,
						cust_no_awal: cust_phonegroup_no_awal,
						cust_no_akhir: cust_phonegroup_no_akhir,
						cust_nama:cust_phonegroup_nama,
						cust_panggilan:cust_phonegroup_panggilan,
						cust_foreigner:cust_phonegroup_foreigner,
						cust_kelamin:cust_phonegroup_kelamin,
						cust_alamat:cust_phonegroup_alamat,
						cust_alamat2:cust_phonegroup_alamat2,
						cust_kota:cust_phonegroup_kota,
						cust_kodepos:cust_phonegroup_kodepos,
						cust_propinsi:cust_phonegroup_propinsi,
						cust_negara: cust_phonegroup_negara,
						cust_telprumah :cust_phonegroup_telprumah,
						cust_telprumah2: cust_phonegroup_telprumah2,
						cust_telpkantor:cust_phonegroup_telpkantor,
						cust_hp:cust_phonegroup_hp,
						cust_hp2:cust_phonegroup_hp2,
						cust_hp3:cust_phonegroup_hp3,
						cust_email :cust_phonegroup_email,
						cust_agama: cust_phonegroup_agama,
						cust_pendidikan:cust_phonegroup_pendidikan,
						cust_profesi :cust_phonegroup_profesi,
						cust_tgllahir:cust_tgllahir_phonegroup_date,
						cust_tgllahirend:cust_tgllahir_phonegroup_dateEnd,
						// cust_hobi:
						cust_referensi: cust_phonegroup_referensi,
						cust_keterangan: cust_phonegroup_keterangan,
						cust_member: cust_phonegroup_member,
						cust_member2: cust_phonegroup_member2,
						cust_terdaftar_date : cust_phonegroup_terdaftar_date,
						cust_statusnikah: cust_phonegroup_statusnikah,
						cust_priority: cust_phonegroup_priority,
						cust_jmlanak: cust_phonegroup_jmlanak,
						cust_unit: cust_phonegroup_unit,
						cust_aktif :cust_phonegroup_aktif,
						sortby		:	sortby_phonegroup,
						cust_fretfulness : cust_fretfulness_phonegroup,
						cust_umurstart : cust_umurstart_phonegroup,
						cust_umurend : cust_umurend_phonegroup,
						cust_tgl	: cust_tgl_phonegroup,
						cust_bulan	: cust_bulan_phonegroup,
						cust_tglEnd	: cust_tgl_phonegroupEnd,
						cust_bulanEnd	: cust_bulan_phonegroupEnd,
						/*cust_hobi_baca : cust_hobi_bacacrm.getValue(),
						cust_hobi_olah : cust_hobi_olahcrm.getValue(),
						cust_hobi_masak : cust_hobi_masakcrm.getValue(),
						cust_hobi_travel : cust_hobi_travelcrm.getValue(),
						cust_hobi_foto : cust_hobi_fotocrm.getValue(),
						cust_hobi_lukis : cust_hobi_lukiscrm.getValue(),
						cust_hobi_nari : cust_hobi_naricrm.getValue(),
						cust_hobi_lain : cust_hobi_laincrm.getValue(),*/
						cust_bb		:	cust_bb_phonegroup,
						cust_terdaftar			:	cust_terdaftar_date_phonegroup, 
						cust_tgldaftarend		:	cust_tgldaftar_dateEnd_phonegroup,
						cust_tglawaltrans		:	cust_tglawaltrans_date_phonegroup,
						member_terdaftarstart		: member_terdaftar_date_phonegroup,
						member_terdaftarend			: member_tgldaftar_dateEnd_phonegroup,
						cust_tglawaltrans_end		:	cust_tglawaltrans_dateEnd_phonegroup, 
						cust_transaksi_end 		: cust_tgl_transaksi_dateEnd_phonegroup,
						cust_transaksi_start   	: cust_tgl_transaksi_date_phonegroup,
						cust_tidak_transaksi_start : cust_tidak_tgl_transaksi_date_phonegroup,
						cust_tidak_transaksi_end	: cust_tidak_tgl_transaksi_dateEnd_phonegroup,
						//crmvalue_id	: crm_generator_id_create_pk,		
						//crmvalue_cust	: customerListEditorGrid.getSelectionModel().getSelected().get('cust_id'),
						//cust_tujuan_id	: cust_tujuan_id_field,
						//cust_point		: cust_point_field,
						//crmvalue_date	: crm_generator_date_create	,
						currentlisting: customer_DataStore.baseParams.task,
						task: post2db					
						//join_keterangan	: joincustomer_keterangan_create
					}, 
					success: function(response){
						var result=eval(response.responseText);
						switch(result){
							case 1:
								Ext.MessageBox.alert(post2db+' OK','Data Phonegroup berhasil disimpan ');
								//customer_phonegroup_DataStore.reload();
								customer_phonegroup_saveWindow.hide();
								break;
							default:
								Ext.MessageBox.show({
								   title: 'Warning',
								   msg: 'Data Phonegroup tidak bisa disimpan ',
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
			else
				cust_delete_phonegroupField.setValue(false);
			}
	}
 	/* End of Function */
  
  function get_umur(){

		if(customerListEditorGrid.getSelectionModel().getSelected().get('cust_tgllahir').format('Y-m-d') == "00-1-11-30"){
		cust_umurField.setValue('0');
		}
		else
		{
		var datDate1=cust_tgllahirField.getValue();
		var getBlnLahir=datDate1.getMonth()+1;
		var getSelisihBln=(dt.getMonth()+1)-getBlnLahir;
		var getUmur=(dt.getFullYear())-(datDate1.getFullYear());
		var tempBln=0;
		/*if(getSelisihBln<0){
			tempBln=12-getBlnLahir;
			getSelisihBln=tempBln+(-(getSelisihBln));
		}*/
	
		if((getBlnLahir) < (dt.getMonth()+1)){
			getUmur=getUmur+1;
		}
		var umur=getUmur+" Th"
		//+getSelisihBln+" Bln";
		
		cust_umurField.setValue(umur);
		
		}
	}
  
  function cust_crm_generator_save(){
			var crm_generator_id_create_pk=null;
			var crm_generator_cust_field = null;
			var cust_tujuan_id_field = null;
			var cust_point_field = null;
			var crm_generator_date_create=today;
			var joincustomer_keterangan_create=null;
													
			Ext.Ajax.request({  
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_customer&m=get_action',
				params: {
	
					task: 'CRMVAL',
					crmvalue_id	: crm_generator_id_create_pk,		
					crmvalue_cust	: customerListEditorGrid.getSelectionModel().getSelected().get('cust_id'),
					crmvalue_date	: crm_generator_date_create				
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							Ext.MessageBox.alert('Generate CRM Value'+' OK','Generate CRM Value berhasil dilakukan.');
							break;
						default:
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Generate CRM Value tidak dapat dilakukan.',
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
						   msg: 'Could not connect to the database. retry later.',
						   buttons: Ext.MessageBox.OK,
						   animEl: 'database',
						   icon: Ext.MessageBox.ERROR
					});	
				}                      
			});
		}
 	/* End of Function */
  
  function cust_crm_generator_save_all(){
			var crm_generator_id_create_pk=null;
			var crm_generator_cust_field = null;
			var cust_tujuan_id_field = null;
			var cust_point_field = null;
			var crm_generator_date_create=today;
			var joincustomer_keterangan_create=null;
			
			var crmquery = "";
			var cust_crm_no=null;
			var cust_crm_nolama=null;
			var cust_crm_no_awal=null;
			var cust_crm_no_akhir=null;
			var cust_crm_nama=null;
			var cust_crm_kelamin=null;
			var cust_crm_alamat=null;
			var cust_crm_alamat2=null;
			var cust_crm_kota=null;
			var cust_crm_kodepos=null;
			var cust_crm_propinsi=null;
			var cust_crm_negara=null;
			var cust_crm_telprumah=null;
			var cust_crm_telprumah2=null;
			var cust_crm_telpkantor=null;
			var cust_crm_hp=null;
			var cust_crm_hp2=null;
			var cust_crm_hp3=null;
			var cust_crm_email=null;
			var cust_crm_agama=null;
			var cust_crm_pendidikan=null;
			var cust_crm_profesi=null;
			var cust_crm_tgllahir_date="";
			var cust_crm_tgllahir_dateEnd="";

			//var cust_crm_hobi=null;
			var cust_crm_referensi=null;
			var cust_crm_keterangan=null;
			var cust_crm_member=null;
			var cust_crm_member2=null;
			var cust_crm_terdaftar_date="";
			var cust_crm_tglawaltrans_date="";
			var cust_crm_statusnikah=null;
			var cust_crm_priority=null;
			var cust_crm_jmlanak=null;
			var cust_crm_unit=null;
			var cust_crm_aktif=null;
			var sortby_crm=null;
			var cust_fretfulness_crm=null;
			var cust_umurstart_crm=null;
			var cust_umurend_crm=null;
			var cust_tgl_crm=null;
			var cust_bulan_crm=null;
			var cust_bb_crm=null;

			var win;              
			// check if we do have some search data...
			if(customer_DataStore.baseParams.query!==null){crmquery = customer_DataStore.baseParams.query;}
			if(customer_DataStore.baseParams.cust_no!==null){cust_crm_no = customer_DataStore.baseParams.cust_no;}
			if(customer_DataStore.baseParams.cust_nolama!==null){cust_crm_nolama = customer_DataStore.baseParams.cust_nolama;}
			if(customer_DataStore.baseParams.cust_no_awal!==null){cust_crm_no_awal = customer_DataStore.baseParams.cust_no_awal;}
			if(customer_DataStore.baseParams.cust_no_akhir!==null){cust_crm_no_akhir = customer_DataStore.baseParams.cust_no_akhir;}
			if(customer_DataStore.baseParams.cust_nama!==null){cust_crm_nama = customer_DataStore.baseParams.cust_nama;}
			if(customer_DataStore.baseParams.cust_kelamin!==null){cust_crm_kelamin = customer_DataStore.baseParams.cust_kelamin;}
			if(customer_DataStore.baseParams.cust_alamat!==null){cust_crm_alamat = customer_DataStore.baseParams.cust_alamat;}
			if(customer_DataStore.baseParams.cust_alamat2!==null){cust_crm_alamat2 = customer_DataStore.baseParams.cust_alamat2;}
			if(customer_DataStore.baseParams.cust_kota!==null){cust_crm_kota = customer_DataStore.baseParams.cust_kota;}
			if(customer_DataStore.baseParams.cust_kodepos!==null){cust_crm_kodepos = customer_DataStore.baseParams.cust_kodepos;}
			if(customer_DataStore.baseParams.cust_propinsi!==null){cust_crm_propinsi = customer_DataStore.baseParams.cust_propinsi;}
			if(customer_DataStore.baseParams.cust_negara!==null){cust_crm_negara = customer_DataStore.baseParams.cust_negara;}
			if(customer_DataStore.baseParams.cust_telprumah!==null){cust_crm_telprumah = customer_DataStore.baseParams.cust_telprumah;}
			if(customer_DataStore.baseParams.cust_telprumah2!==null){cust_crm_telprumah2 = customer_DataStore.baseParams.cust_telprumah2;}
			if(customer_DataStore.baseParams.cust_telpkantor!==null){cust_crm_telpkantor = customer_DataStore.baseParams.cust_telpkantor;}
			if(customer_DataStore.baseParams.cust_hp!==null){cust_crm_hp = customer_DataStore.baseParams.cust_hp;}
			if(customer_DataStore.baseParams.cust_hp2!==null){cust_crm_hp2 = customer_DataStore.baseParams.cust_hp2;}
			if(customer_DataStore.baseParams.cust_hp3!==null){cust_crm_hp3 = customer_DataStore.baseParams.cust_hp3;}
			if(customer_DataStore.baseParams.cust_email!==null){cust_crm_email = customer_DataStore.baseParams.cust_email;}
			if(customer_DataStore.baseParams.cust_agama!==null){cust_crm_agama = customer_DataStore.baseParams.cust_agama;}
			if(customer_DataStore.baseParams.cust_pendidikan!==null){cust_crm_pendidikan = customer_DataStore.baseParams.cust_pendidikan;}
			if(customer_DataStore.baseParams.cust_profesi!==null){cust_crm_profesi = customer_DataStore.baseParams.cust_profesi;}
			if(customer_DataStore.baseParams.cust_tgllahir!==""){cust_crm_tgllahir_date = customer_DataStore.baseParams.cust_tgllahir;}
			if(customer_DataStore.baseParams.cust_tgllahirend!==""){cust_crm_tgllahir_dateEnd = customer_DataStore.baseParams.cust_tgllahirend;}
			//if(customer_DataStore.baseParams.cust_hobi!==null){cust_crm_hobi = customer_DataStore.baseParams.cust_hobi;}
			if(customer_DataStore.baseParams.cust_referensi!==null){cust_crm_referensi = customer_DataStore.baseParams.cust_referensi;}
			if(customer_DataStore.baseParams.cust_keterangan!==null){cust_crm_keterangan = customer_DataStore.baseParams.cust_keterangan;}
			if(customer_DataStore.baseParams.cust_member!==null){cust_crm_member = customer_DataStore.baseParams.cust_member;}
			if(customer_DataStore.baseParams.cust_member2!==null){cust_crm_member2 = customer_DataStore.baseParams.cust_member2;}
			if(customer_DataStore.baseParams.cust_terdaftar!==""){cust_crm_terdaftar_date = customer_DataStore.baseParams.cust_terdaftar;}
			if(customer_DataStore.baseParams.cust_tglawaltrans!==""){cust_crm_tglawaltrans_date = customer_DataStore.baseParams.cust_tglawaltrans;}
			if(customer_DataStore.baseParams.cust_statusnikah!==null){cust_crm_statusnikah = customer_DataStore.baseParams.cust_statusnikah;}
			if(customer_DataStore.baseParams.cust_priority!==null){cust_crm_priority = customer_DataStore.baseParams.cust_priority;}
			if(customer_DataStore.baseParams.cust_jmlanak!==null){cust_crm_jmlanak = customer_DataStore.baseParams.cust_jmlanak;}
			if(customer_DataStore.baseParams.cust_unit!==null){cust_crm_unit = customer_DataStore.baseParams.cust_unit;}
			if(customer_DataStore.baseParams.cust_aktif!==null){cust_crm_aktif = customer_DataStore.baseParams.cust_aktif;}
			if(sortby_SearchField.getValue()!==null){sortby=sortby_SearchField.getValue();}
			if(customer_DataStore.baseParams.cust_fretfulness!==null){cust_fretfulness_crm = customer_DataStore.baseParams.cust_fretfulness;}
			if(customer_DataStore.baseParams.cust_umurstart!==null){cust_umurstart_crm=customer_DataStore.baseParams.cust_umurstart;}
			if(customer_DataStore.baseParams.cust_umurend!==null){cust_umurend_crm=customer_DataStore.baseParams.cust_umurend;}	
			if(customer_DataStore.baseParams.cust_tgl!==null){cust_tgl_crm=customer_DataStore.baseParams.cust_tgl;}
			if(customer_DataStore.baseParams.cust_bulan!==null){cust_bulan_crm=customer_DataStore.baseParams.cust_bulan;}

		Ext.MessageBox.show({
		   msg: 'Sedang memproses data, mohon tunggu...',
		   progressText: 'proses...',
		   width:350,
		   wait:true
		});		
		
			Ext.Ajax.request({  
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_customer&m=get_action',
				timeout: 3600000,
				params: {
	
					task: 'CRMVAL2',
					query: crmquery, 
					cust_no : cust_crm_no,
					cust_nolama :cust_crm_nolama,
					cust_no_awal: cust_crm_no_awal,
					cust_no_akhir: cust_crm_no_akhir,
					cust_nama:cust_crm_nama,
					cust_kelamin:cust_crm_kelamin,
					cust_alamat:cust_crm_alamat,
					cust_alamat2:cust_crm_alamat2,
					cust_kota:cust_crm_kota,
					cust_kodepos:cust_crm_kodepos,
					cust_propinsi:cust_crm_propinsi,
					cust_negara: cust_crm_negara,
					cust_telprumah :cust_crm_telprumah,
					cust_telprumah2: cust_crm_telprumah2,
					cust_telpkantor:cust_crm_telpkantor,
					cust_hp:cust_crm_hp,
					cust_hp2:cust_crm_hp2,
					cust_hp3:cust_crm_hp3,
					cust_email :cust_crm_email,
					cust_agama: cust_crm_agama,
					cust_pendidikan:cust_crm_pendidikan,
					cust_profesi :cust_crm_profesi,
					cust_tgllahir:cust_crm_tgllahir_date,
					cust_tgllahirend:cust_crm_tgllahir_dateEnd,
					// cust_hobi:
					cust_referensi: cust_crm_referensi,
					cust_keterangan: cust_crm_keterangan,
					cust_member: cust_crm_member,
					cust_member2: cust_crm_member2,
					cust_terdaftar_date : cust_crm_terdaftar_date,
					cust_statusnikah: cust_crm_statusnikah,
					cust_priority: cust_crm_priority,
					cust_jmlanak: cust_crm_jmlanak,
					cust_unit: cust_crm_unit,
					cust_aktif :cust_crm_aktif,
					sortby		:	sortby_crm,
					cust_fretfulness : cust_fretfulness_crm,
					cust_umurstart : cust_umurstart_crm,
					cust_umurend : cust_umurend_crm,
					cust_tgl	: cust_tgl_crm,
					cust_bulan	: cust_bulan_crm,
					/*cust_hobi_baca : cust_hobi_bacacrm.getValue(),
					cust_hobi_olah : cust_hobi_olahcrm.getValue(),
					cust_hobi_masak : cust_hobi_masakcrm.getValue(),
					cust_hobi_travel : cust_hobi_travelcrm.getValue(),
					cust_hobi_foto : cust_hobi_fotocrm.getValue(),
					cust_hobi_lukis : cust_hobi_lukiscrm.getValue(),
					cust_hobi_nari : cust_hobi_naricrm.getValue(),
					cust_hobi_lain : cust_hobi_laincrm.getValue(),*/
					cust_bb		:	cust_bb_crm,
					crmvalue_id	: crm_generator_id_create_pk,		
					//crmvalue_cust	: customerListEditorGrid.getSelectionModel().getSelected().get('cust_id'),
					crmvalue_date	: crm_generator_date_create,
					currentlisting: customer_DataStore.baseParams.task					
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							Ext.MessageBox.alert('Generate CRM Value'+' OK','Generate CRM Value berhasil dilakukan.');
							break;
						case 2:
							Ext.MessageBox.alert('WARNING'+' OK','Untuk melakukan Generate CRM Value, data customer tidak boleh melebihi batas maksimum 100 data.');
							break;
						default:
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Generate CRM Value tidak dapat dilakukan',
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
						   msg: 'Could not connect to the database. retry later.',
						   buttons: Ext.MessageBox.OK,
						   animEl: 'database',
						   icon: Ext.MessageBox.ERROR
					});	
				}                      
			});
			
		}
 	/* End of Function */
	
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!customer_createWindow.isVisible()){
			customer_reset_form();
			//cbo_cust_cabang_DataStore.load();
			customer_set_defaultForm();
			cust_terdaftarField.setValue(dt.format('Y-m-d'));
			cust_tglawaltransField.setValue(dt.format('Y-m-d'));
			post2db='CREATE';
			msg='created';
			Ext.getCmp('check_update').setVisible(false);
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_CUSTOMER'))){ ?>
			customer_createForm.saveButton.enable();
			<?php } ?>
			//Ext.getCmp('btn_saveclose').setDisabled(false);
			customer_createWindow.show();
			customer_createForm.load();
		} else {
			customer_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function customer_confirm_delete(){
		if(customerListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', customer_delete);
		} else if(customerListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', customer_delete);
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
  
  /* Function for generate crm Confirm */
	function customer_confirm_crm(){
		if(customerListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk melakukan Generate CRM Value pada customer ini?', crm_generator_button);
		} else if(customerListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk melakukan Generate CRM Value pada customer ini?', crm_generator_button);
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Tidak ada yang dipilih untuk digenerate',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
    
	function crm_generator_button(btn){
		if(btn=='yes'){
			cust_crm_generator_save();
		}
	}
	
	/* Function for generate crm Confirm */
	function customer_confirm_crm2(){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk melakukan Generate CRM Value?', crm_generator_button2);
	}
  	/* End of Function */
    
	function crm_generator_button2(btn2){
		if(btn2=='yes'){
			if(customer_DataStore.getCount() > 5){
				Ext.MessageBox.confirm('Confirmation','Generate CRM Value untuk banyak data memerlukan waktu cukup lama. Anda yakin untuk melanjutkan?', crm_generator_button3);
			}
			else 
				cust_crm_generator_save_all();
		}
	}
	
	function crm_generator_button3(btn3){
		if(btn3=='yes'){
			cust_crm_generator_save_all();
		}
	}
	
	/* Function for Update Confirm */
	function customer_confirm_update(){
		if(customerListEditorGrid.selModel.getCount() == 1) {
			post2db='UPDATE';
			msg='updated';
			customer_set_form();
			get_umur();
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_CUSTOMER'))){ ?>
			cust_update_confirmField.setVisible(true);
			cust_update_confirmField.setValue(false);
			customer_createForm.saveButton.disable();
			<?php } ?>
			customer_createWindow.show();
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Anda belum memilih data yang akan diedit',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
	
	/* Function for Displaying  add to phonegroup Window Form */
	function display_customer_phonegroup(){
		if(!customer_phonegroup_saveWindow.isVisible()){
			post2db='PHONEGROUP';
			msg='createphonegroup';
			customer_phonegroup_reset_form();
			customer_phonegroup_saveWindow.show();
		} else {
			customer_phonegroup_saveWindow.toFront();
		}
	}
  	/* End of Function */
	
  	/* Function for Delete Record */
	function customer_delete(btn){
		if(btn=='yes'){
			var selections = customerListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< customerListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.cust_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Silahkan tunggu',
				url: 'index.php?c=c_customer&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							customer_DataStore.reload();
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

	/* Event while selected row via context menu */
	function oncustomer_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		customer_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		customer_SelectedRow=rowIndex;
		customer_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
		
	/* function for editing row via context menu */
	function customer_editContextMenu(){
      customerListEditorGrid.startEditing(customer_SelectedRow,1);
  	}
	/* End of Function */
	
	var cbo_phonegroup_DataStore = new Ext.data.Store({
		id: 'cbo_phonegroup_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_customer&m=phonegroup_list', 
			method: 'POST'
		}),
		baseParams:{start: 0, limit: 10 }, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'phonegroup_id'
		},[
			{name: 'phonegroup_id', type: 'string', mapping: 'phonegroup_id'},
			{name: 'phonegroup_nama', type: 'string', mapping: 'phonegroup_nama'},
		]),
		sortInfo:{field: 'phonegroup_id', direction: "ASC"}
	});
	
	var customer_phonegroup_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{phonegroup_nama}</b></span>',
        '</div></tpl>'
    );
	
	/* Identify  phonegroup_nama Field */
	customer_phonegroup_namaField= new Ext.form.ComboBox({
		id: 'customer_phonegroup_namaField',
		fieldLabel: 'Nama Group',
		store: cbo_phonegroup_DataStore,
		mode: 'remote',
		editable: false,
		displayField:'phonegroup_nama',
		valueField: 'phonegroup_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: customer_phonegroup_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%',
		editable: true,
		forceSelection: true,
	});
	
	cust_delete_phonegroupField=new Ext.form.Checkbox({
		boxLabel: 'Hapus detail Phonegroup',
		//name: 'email_fb'
	});
	
	/* Function for retrieve create Window Panel*/
	customer_phonegroup_saveForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 300,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [customer_phonegroup_namaField,cust_delete_phonegroupField]
			}
			],
		buttons: [
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_CUSTOMER'))){ ?>
			{
				text: 'Save and Close',
				handler: customer_phonegroup_save
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					customer_phonegroup_saveWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	customer_phonegroup_saveWindow= new Ext.Window({
		id: 'customer_phonegroup_saveWindow',
		title: post2db+' Phone Group',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_customer_phonegroup_save',
		items: customer_phonegroup_saveForm
	});
	/* End Window */
	
	function customer_list_search(){
		// render according to a SQL date format.
		//var cust_id_search=null;
		var cust_no_search=null;
		var cust_nolama_search=null;
		var cust_nama_search=null;
		var cust_panggilan_search=null;
		var cust_foreigner_search=null;
		var cust_kelamin_search=null;
		var cust_alamat_search=null;
		//var cust_alamat2_search=null;
		var cust_kota_search=null;
		var cust_kodepos_search=null;
		var cust_propinsi_search=null;
		var cust_negara_search=null;
		var cust_telprumah_search=null;
		//var cust_telprumah2_search=null;
		//var cust_telpkantor_search=null;
		//var cust_hp_search=null;
		//var cust_hp2_search=null;
		//var cust_hp3_search=null;
		var cust_email_search=null;
		var cust_agama_search=null;
		var cust_pendidikan_search=null;
		var cust_profesi_search=null;
		var cust_tgllahir_search_date="";
		var cust_tgllahir_search_dateEnd="";
		var cust_hobi_search=null;
		var cust_referensi_search=null;
		var cust_referensilain_search=null;
		var cust_keterangan_search=null;
		var cust_member_search=null;
		var cust_terdaftar_search_date="";
		var cust_tgldaftar_search_dateEnd="";
		
		var member_terdaftar_search_date="";
		var member_tgldaftar_search_dateEnd="";
		
		var cust_tglawaltrans_search_date="";
		var cust_tglawaltrans_search_dateEnd="";
		var cust_tgl_transaksi_search_date="";
		var cust_tgl_transaksi_search_dateEnd="";
		var cust_tidak_tgl_transaksi_search_date="";
		var cust_tidak_tgl_transaksi_search_dateEnd="";
		var cust_statusnikah_search=null;
		var cust_priority_search=null;
		var cust_jmlanak_search=null;
		var cust_unit_search=null;
		var cust_aktif_search=null;
		var sortby_search=null;
		var fretfulness_search=null;
		var cust_umurstart_search=null;
		var cust_umurend_search=null;
		var cust_tgl_search=null;
		var cust_bulan_search=null;
		var cust_tgl_searchEnd=null;
		var cust_bulan_searchEnd=null;
		var cust_bb_search=null;

		///if(cust_idSearchField.getValue()!==null){cust_id_search=cust_idSearchField.getValue();}
		if(cust_noSearchField.getValue()!==null){cust_no_search=cust_noSearchField.getValue();}
		if(cust_no_awalSearchField.getValue()!==null){cust_no_awal_search=cust_no_awalSearchField.getValue();}
		if(cust_no_akhirSearchField.getValue()!==null){cust_no_akhir_search=cust_no_akhirSearchField.getValue();}
		//if(cust_nolamaSearchField.getValue()!==null){cust_nolama_search=cust_nolamaSearchField.getValue();}
		if(cust_namaSearchField.getValue()!==null){cust_nama_search=cust_namaSearchField.getValue();}
		if(cust_panggilanSearchField.getValue()!==null){cust_panggilan_search=cust_panggilanSearchField.getValue();}
		if(cust_foreignerSearchField.getValue()!==null){cust_foreigner_search=cust_foreignerSearchField.getValue();}
		if(cust_kelaminSearchField.getValue()!==null){cust_kelamin_search=cust_kelaminSearchField.getValue();}
		if(cust_alamatSearchField.getValue()!==null){cust_alamat_search=cust_alamatSearchField.getValue();}
		//if(cust_alamat2SearchField.getValue()!==null){cust_alamat2_search=cust_alamat2SearchField.getValue();}
		if(cust_kotaSearchField.getValue()!==null){cust_kota_search=cust_kotaSearchField.getValue();}
		if(cust_kodeposSearchField.getValue()!==null){cust_kodepos_search=cust_kodeposSearchField.getValue();}
		if(cust_propinsiSearchField.getValue()!==null){cust_propinsi_search=cust_propinsiSearchField.getValue();}
		if(cust_negaraSearchField.getValue()!==null){cust_negara_search=cust_negaraSearchField.getValue();}
		if(cust_telprumahSearchField.getValue()!==null){cust_telprumah_search=cust_telprumahSearchField.getValue();}
		//if(cust_telprumah2SearchField.getValue()!==null){cust_telprumah2_search=cust_telprumah2SearchField.getValue();}
		//if(cust_telpkantorSearchField.getValue()!==null){cust_telpkantor_search=cust_telpkantorSearchField.getValue();}
		//if(cust_hpSearchField.getValue()!==null){cust_hp_search=cust_hpSearchField.getValue();}
		//if(cust_hp2SearchField.getValue()!==null){cust_hp2_search=cust_hp2SearchField.getValue();}
		//if(cust_hp3SearchField.getValue()!==null){cust_hp3_search=cust_hp3SearchField.getValue();}
		if(cust_bbSearchField.getValue()!==null){cust_bb_search=cust_bbSearchField.getValue();}
		if(cust_emailSearchField.getValue()!==null){cust_email_search=cust_emailSearchField.getValue();}
		if(cust_agamaSearchField.getValue()!==null){cust_agama_search=cust_agamaSearchField.getValue();}
		if(cust_pendidikanSearchField.getValue()!==null){cust_pendidikan_search=cust_pendidikanSearchField.getValue();}
		if(cust_profesiSearchField.getValue()!==null){cust_profesi_search=cust_profesiSearchField.getValue();}
		
		if(cust_referensiSearchField.getValue()!==null){cust_referensi_search=cust_referensiSearchField.getValue();}
		if(cust_referensilainSearchField.getValue()!==null){cust_referensilain_search=cust_referensilainSearchField.getValue();}
		if(cust_keteranganSearchField.getValue()!==null){cust_keterangan_search=cust_keteranganSearchField.getValue();}
		if(cust_memberSearchField.getValue()!==null){cust_member_search=cust_memberSearchField.getValue();}
		if(cust_memberSearch2Field.getValue()!==null){cust_member2_search=cust_memberSearch2Field.getValue();}
		if(cust_terdaftarSearchField.getValue()!==""){cust_terdaftar_search_date=cust_terdaftarSearchField.getValue().format('Y-m-d');}
		if(cust_tgldaftarSearchFieldEnd.getValue()!==""){cust_tgldaftar_search_dateEnd=cust_tgldaftarSearchFieldEnd.getValue().format('Y-m-d');}
		
		if(member_terdaftarSearchField.getValue()!==""){member_terdaftar_search_date=member_terdaftarSearchField.getValue().format('Y-m-d');}
		if(member_tgldaftarSearchFieldEnd.getValue()!==""){member_tgldaftar_search_dateEnd=member_tgldaftarSearchFieldEnd.getValue().format('Y-m-d');}
		
		if(cust_tglawaltransSearchField.getValue()!==""){cust_tglawaltrans_search_date=cust_tglawaltransSearchField.getValue().format('Y-m-d');}
		if(cust_tglawaltransSearchFieldEnd.getValue()!==""){cust_tglawaltrans_search_dateEnd=cust_tglawaltransSearchFieldEnd.getValue().format('Y-m-d');}
		if(cust_statusnikahSearchField.getValue()!==null){cust_statusnikah_search=cust_statusnikahSearchField.getValue();}
		if(cust_prioritySearchField.getValue()!==null){cust_priority_search=cust_prioritySearchField.getValue();}
		if(cust_jmlanakSearchField.getValue()!==null){cust_jmlanak_search=cust_jmlanakSearchField.getValue();}
		if(cust_unitSearchField.getValue()!==null){cust_unit_search=cust_unitSearchField.getValue();}
		if(cust_aktifSearchField.getValue()!==null){cust_aktif_search=cust_aktifSearchField.getValue();}
		if(sortby_SearchField.getValue()!==null){sortby_search=sortby_SearchField.getValue();}
		if(fretfulness_SearchField.getValue()!==null){fretfulness_search=fretfulness_SearchField.getValue();}
		
		if(cust_umurstartSearchField.getValue()!==null){cust_umurstart_search=cust_umurstartSearchField.getValue();}
		if(cust_umurendSearchField.getValue()!==null){cust_umurend_search=cust_umurendSearchField.getValue();}	
		
		//if(cust_tgltransaksi_opsiField.getValue()==true){
			if(cust_tgl_transaksiSearchFieldStart.getValue()!==""){cust_tgl_transaksi_search_date=cust_tgl_transaksiSearchFieldStart.getValue().format('Y-m-d');}
			if(cust_tgl_transaksiSearchFieldEnd.getValue()!==""){cust_tgl_transaksi_search_dateEnd=cust_tgl_transaksiSearchFieldEnd.getValue().format('Y-m-d');}
		//}
		//else if(cust_tidak_tgltransaksi_opsiField.getValue()==true){
			if(cust_tidak_tgl_transaksiSearchFieldStart.getValue()!==""){cust_tidak_tgl_transaksi_search_date=cust_tidak_tgl_transaksiSearchFieldStart.getValue().format('Y-m-d');}
			if(cust_tidak_tgl_transaksiSearchFieldEnd.getValue()!==""){cust_tidak_tgl_transaksi_search_dateEnd=cust_tidak_tgl_transaksiSearchFieldEnd.getValue().format('Y-m-d');}
		//}
	
		if(cust_tgl_opsiField.getValue()==true){
			
			if(cust_tgllahirSearchField.getValue()!==""){cust_tgllahir_search_date=cust_tgllahirSearchField.getValue().format('Y-m-d');}
			if(cust_tgllahirSearchFieldEnd.getValue()!==""){cust_tgllahir_search_dateEnd=cust_tgllahirSearchFieldEnd.getValue().format('Y-m-d');}
		}		
		else if(cust_bulan_opsiField.getValue()==true){

			if(cust_tglSearchField.getValue()!==null){cust_tgl_search=cust_tglSearchField.getValue();}
			if(cust_bulanSearchField.getValue()!==null){cust_bulan_search=cust_bulanSearchField.getValue();}
			if(cust_tglSearchFieldEnd.getValue()!==null){cust_tgl_searchEnd=cust_tglSearchFieldEnd.getValue();}
			if(cust_bulanSearchFieldEnd.getValue()!==null){cust_bulan_searchEnd=cust_bulanSearchFieldEnd.getValue();}
		}
		
		// change the store parameters
		customer_DataStore.baseParams = {
			task: 'SEARCH',
			start: 0,
			limit: pageS,
			//variable here
			//cust_id					:	cust_id_search, 
			cust_no					:	cust_no_search,
			cust_no_awal			:	cust_no_awal_search,
			cust_no_akhir			:	cust_no_akhir_search,
			cust_nolama				:	cust_nolama_search, 
			cust_nama				:	cust_nama_search, 
			cust_panggilan			:	cust_panggilan_search, 
			cust_foreigner			:	cust_foreigner_search, 
			cust_kelamin			:	cust_kelamin_search, 
			cust_alamat				:	cust_alamat_search, 
			//cust_alamat2				:	cust_alamat2_search, 
			cust_kota				:	cust_kota_search, 
			cust_kodepos			:	cust_kodepos_search, 
			cust_propinsi			:	cust_propinsi_search, 
			cust_negara				:	cust_negara_search, 
			cust_telprumah			:	cust_telprumah_search, 
			//cust_telprumah2			:	cust_telprumah2_search, 
			//cust_telpkantor				:	cust_telpkantor_search, 
			//cust_hp					:	cust_hp_search, 
			//cust_hp2					:	cust_hp2_search, 
			//cust_hp3					:	cust_hp3_search, 
			cust_bb					:	cust_bb_search, 
			cust_email				:	cust_email_search, 
			cust_agama				:	cust_agama_search, 
			cust_pendidikan			:	cust_pendidikan_search, 
			cust_profesi			:	cust_profesi_search, 
			cust_tgllahir			:	cust_tgllahir_search_date, 
			cust_tgllahirend		:	cust_tgllahir_search_dateEnd, 
			//cust_hobi				:	cust_hobi_search, 
			cust_hobi_baca 			: cust_hobi_bacaSearchField.getValue(),
			cust_hobi_olah 			: cust_hobi_olahSearchField.getValue(),
			cust_hobi_masak 		: cust_hobi_masakSearchField.getValue(),
			cust_hobi_travel 		: cust_hobi_travelSearchField.getValue(),
			cust_hobi_foto 			: cust_hobi_fotoSearchField.getValue(),
			cust_hobi_lukis 		: cust_hobi_lukisSearchField.getValue(),
			cust_hobi_nari 			: cust_hobi_nariSearchField.getValue(),
			cust_hobi_lain 			: cust_hobi_lainSearchField.getValue(),
			cust_referensi			:	cust_referensi_search, 
			cust_referensilain		:	cust_referensilain_search, 
			cust_keterangan			:	cust_keterangan_search, 
			cust_member				:	cust_member_search, 
			cust_member2			:	cust_member2_search, 
			cust_terdaftar			:	cust_terdaftar_search_date, 
			cust_tgldaftarend		:	cust_tgldaftar_search_dateEnd,
			member_terdaftarstart	:	member_terdaftar_search_date, 
			member_terdaftarend		:	member_tgldaftar_search_dateEnd,
			cust_tglawaltrans		:	cust_tglawaltrans_search_date,
			cust_tglawaltrans_end		:	cust_tglawaltrans_search_dateEnd, 
			cust_statusnikah		:	cust_statusnikah_search,
			cust_priority			:	cust_priority_search,
			cust_jmlanak			:	cust_jmlanak_search, 
			cust_unit				:	cust_unit_search, 
			cust_aktif				:	cust_aktif_search,
			sortby					:	sortby_search,
			cust_fretfulness 		: fretfulness_search,
			cust_umurstart 			: cust_umurstart_search,
			cust_umurend 			: cust_umurend_search,
			cust_tgl				: cust_tgl_search,
			cust_bulan				: cust_bulan_search,
			cust_tglEnd				: cust_tgl_searchEnd,
			cust_bulanEnd				: cust_bulan_searchEnd,
			cust_transaksi_end 		: cust_tgl_transaksi_search_dateEnd,
			cust_transaksi_start   	: cust_tgl_transaksi_search_date,
			cust_tidak_transaksi_start : cust_tidak_tgl_transaksi_search_date,
			cust_tidak_transaksi_end	: cust_tidak_tgl_transaksi_search_dateEnd,
		};
		// Cause the datastore to do another query : 
		//customer_DataStore.load({params: {start: 0, limit: pageS}});
		customer_DataStore.reload({params: {start: 0, limit: pageS}});;
	}
		
	/* Function for reset search result */
	function customer_reset_search(){
		// reset the store parameters
		customer_DataStore.baseParams = { task: 'LIST',start:0,limit:pageS };
		// Cause the datastore to do another query : 
		customer_DataStore.reload({params: {start: 0, limit: pageS}});
		//customer_searchWindow.close();
	};
	/* End of Fuction */

	function customer_reset_SearchForm(){
		cust_noSearchField.reset();
		cust_no_awalSearchField.reset();
		cust_no_akhirSearchField.reset();
		//cust_nolamaSearchField.reset();
		cust_namaSearchField.reset();
		cust_panggilanSearchField.reset();
		cust_foreignerSearchField.reset();
		cust_kelaminSearchField.reset();
		cust_alamatSearchField.reset();
		//cust_alamat2SearchField.reset();
		cust_kotaSearchField.reset();
		cust_kodeposSearchField.reset();
		cust_propinsiSearchField.reset();
		cust_negaraSearchField.reset();
		cust_telprumahSearchField.reset();
		//cust_telprumah2SearchField.reset();
		//cust_telpkantorSearchField.reset();
		//cust_hpSearchField.reset();
		//cust_hp2SearchField.reset();
		//cust_hp3SearchField.reset();
		cust_bbSearchField.reset();
		cust_emailSearchField.reset();
		cust_agamaSearchField.reset();
		cust_pendidikanSearchField.reset();
		cust_profesiSearchField.reset();
		cust_tgllahirSearchField.reset();
		cust_tgllahirSearchFieldEnd.reset();
		//cust_hobiSearchField.reset();
		cust_referensiSearchField.reset();
		cust_referensilainSearchField.reset();
		cust_keteranganSearchField.reset();
		cust_memberSearchField.reset();
		cust_memberSearch2Field.reset();
		cust_terdaftarSearchField.reset();
		cust_tgldaftarSearchFieldEnd.reset();
		
		member_terdaftarSearchField.reset();
		member_tgldaftarSearchFieldEnd.reset();
		
		cust_tglawaltransSearchField.reset();
		cust_tglawaltransSearchFieldEnd.reset();
		cust_statusnikahSearchField.reset();
		cust_prioritySearchField.reset();
		cust_jmlanakSearchField.reset();
		cust_unitSearchField.reset();
		cust_aktifSearchField.reset();
		sortby_SearchField.reset();
		fretfulness_SearchField.reset();
		cust_hobi_bacaSearchField.reset();
		cust_hobi_olahSearchField.reset();
		cust_hobi_masakSearchField.reset();
		cust_hobi_travelSearchField.reset();
		cust_hobi_fotoSearchField.reset();
		cust_hobi_lukisSearchField.reset();
		cust_hobi_nariSearchField.reset();
		cust_hobi_lainSearchField.reset();
		cust_umurstartSearchField.reset();
		cust_umurendSearchField.reset();
		cust_tglSearchField.reset();
		cust_bulanSearchField.reset();
		cust_tidak_tgl_transaksiSearchFieldStart.reset();
		cust_tidak_tgl_transaksiSearchFieldEnd.reset();
		cust_tgl_transaksiSearchFieldStart.reset();
		cust_tgl_transaksiSearchFieldEnd.reset();
		
		cust_tglSearchField.disable();
		cust_bulanSearchField.disable();
		cust_tglSearchFieldEnd.disable();
		cust_bulanSearchFieldEnd.disable();
		
		cust_tgllahirSearchField.enable();
		cust_tgllahirSearchFieldEnd.enable();
	}

	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!customer_searchWindow.isVisible()){
			customer_reset_SearchForm();
			cust_aktifSearchField.setValue('Aktif');
			//fretfulness_SearchField.setValue('Undefined');
			customer_searchWindow.show();
		} else {
			customer_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function customer_print(){
		var searchquery = "";
		var cust_no_print=null;
		var cust_nolama_print=null;
		var cust_no_awal_print=null;
		var cust_no_akhir_print=null;
		var cust_nama_print=null;
		var cust_panggilan_print=null;
		var cust_foreigner_print=null;
		var cust_kelamin_print=null;
		var cust_alamat_print=null;
		var cust_alamat2_print=null;
		var cust_kota_print=null;
		var cust_kodepos_print=null;
		var cust_propinsi_print=null;
		var cust_negara_print=null;
		var cust_telprumah_print=null;
		var cust_telprumah2_print=null;
		var cust_telpkantor_print=null;
		var cust_hp_print=null;
		var cust_hp2_print=null;
		var cust_hp3_print=null;
		var cust_email_print=null;
		var cust_agama_print=null;
		var cust_pendidikan_print=null;
		var cust_profesi_print=null;
		var cust_referensi_print=null;
		var cust_referensilain_print=null;
		var cust_keterangan_print=null;
		var cust_member_print=null;
		var cust_member2_print=null;
		var cust_statusnikah_print=null;
		var cust_priority_print=null;
		var cust_jmlanak_print=null;
		var cust_unit_print=null;
		var cust_aktif_print=null;
		var cust_bb_print=null;
		var sortby_print=null;
		var fretfulness_print=null;		
		var cust_tgl_transaksi_print_date="";
		var cust_tgl_transaksi_print_dateEnd="";
		var cust_tidak_tgl_transaksi_print_date="";
		var cust_tidak_tgl_transaksi_print_dateEnd="";		
		var cust_tgl_print=null;
		var cust_bulan_print=null;
		var cust_tgl_printEnd=null;
		var cust_bulan_printEnd=null;
		var cust_umurstart_print=null;
		var cust_umurend_print=null;
		var cust_tgllahir_print_date="";
		var cust_tgllahir_print_dateEnd="";
		var cust_terdaftar_print_date="";
		var cust_terdaftarend_print_date="";		
		var member_terdaftar_print_date="";
		var member_terdaftarend_print_date="";		
		var cust_tglawaltrans_print_date="";
		var cust_tglawaltransend_print_date="";
		var cust_tglawaltrans_end_print_date="";		
		var win;              
		
		// check if we do have some search data...
		if(customer_DataStore.baseParams.query!==null){searchquery = customer_DataStore.baseParams.query;}
		if(customer_DataStore.baseParams.cust_no!==null){cust_no_print = customer_DataStore.baseParams.cust_no;}
		if(customer_DataStore.baseParams.cust_nolama!==null){cust_nolama_print = customer_DataStore.baseParams.cust_nolama;}
		if(customer_DataStore.baseParams.cust_no_awal!==null){cust_no_awal_print = customer_DataStore.baseParams.cust_no_awal;}
		if(customer_DataStore.baseParams.cust_no_akhir!==null){cust_no_akhir_print = customer_DataStore.baseParams.cust_no_akhir;}
		if(customer_DataStore.baseParams.cust_nama!==null){cust_nama_print = customer_DataStore.baseParams.cust_nama;}
		if(customer_DataStore.baseParams.cust_panggilan!==null){cust_panggilan_print = customer_DataStore.baseParams.cust_panggilan;}
		if(customer_DataStore.baseParams.cust_foreigner!==null){cust_foreigner_print = customer_DataStore.baseParams.cust_foreigner;}
		if(customer_DataStore.baseParams.cust_kelamin!==null){cust_kelamin_print = customer_DataStore.baseParams.cust_kelamin;}
		if(customer_DataStore.baseParams.cust_alamat!==null){cust_alamat_print = customer_DataStore.baseParams.cust_alamat;}
		if(customer_DataStore.baseParams.cust_alamat2!==null){cust_alamat2_print = customer_DataStore.baseParams.cust_alamat2;}
		if(customer_DataStore.baseParams.cust_kota!==null){cust_kota_print = customer_DataStore.baseParams.cust_kota;}
		if(customer_DataStore.baseParams.cust_kodepos!==null){cust_kodepos_print = customer_DataStore.baseParams.cust_kodepos;}
		if(customer_DataStore.baseParams.cust_propinsi!==null){cust_propinsi_print = customer_DataStore.baseParams.cust_propinsi;}
		if(customer_DataStore.baseParams.cust_negara!==null){cust_negara_print = customer_DataStore.baseParams.cust_negara;}
		if(customer_DataStore.baseParams.cust_telprumah!==null){cust_telprumah_print = customer_DataStore.baseParams.cust_telprumah;}
		if(customer_DataStore.baseParams.cust_telprumah2!==null){cust_telprumah2_print = customer_DataStore.baseParams.cust_telprumah2;}
		if(customer_DataStore.baseParams.cust_telpkantor!==null){cust_telpkantor_print = customer_DataStore.baseParams.cust_telpkantor;}
		if(customer_DataStore.baseParams.cust_hp!==null){cust_hp_print = customer_DataStore.baseParams.cust_hp;}
		if(customer_DataStore.baseParams.cust_hp2!==null){cust_hp2_print = customer_DataStore.baseParams.cust_hp2;}
		if(customer_DataStore.baseParams.cust_hp3!==null){cust_hp3_print = customer_DataStore.baseParams.cust_hp3;}
		if(customer_DataStore.baseParams.cust_email!==null){cust_email_print = customer_DataStore.baseParams.cust_email;}
		if(customer_DataStore.baseParams.cust_agama!==null){cust_agama_print = customer_DataStore.baseParams.cust_agama;}
		if(customer_DataStore.baseParams.cust_pendidikan!==null){cust_pendidikan_print = customer_DataStore.baseParams.cust_pendidikan;}
		if(customer_DataStore.baseParams.cust_profesi!==null){cust_profesi_print = customer_DataStore.baseParams.cust_profesi;}
		if(customer_DataStore.baseParams.cust_referensi!==null){cust_referensi_print = customer_DataStore.baseParams.cust_referensi;}
		if(cust_referensilainSearchField.getValue()!==null){cust_referensilain_print=cust_referensilainSearchField.getValue();}
		if(customer_DataStore.baseParams.cust_keterangan!==null){cust_keterangan_print = customer_DataStore.baseParams.cust_keterangan;}
		if(customer_DataStore.baseParams.cust_member!==null){cust_member_print = customer_DataStore.baseParams.cust_member;}
		if(customer_DataStore.baseParams.cust_member2!==null){cust_member2_print = customer_DataStore.baseParams.cust_member2;}
		if(customer_DataStore.baseParams.cust_statusnikah!==null){cust_statusnikah_print = customer_DataStore.baseParams.cust_statusnikah;}
		if(customer_DataStore.baseParams.cust_priority!==null){cust_priority_print = customer_DataStore.baseParams.cust_priority;}
		if(customer_DataStore.baseParams.cust_jmlanak!==null){cust_jmlanak_print = customer_DataStore.baseParams.cust_jmlanak;}
		if(customer_DataStore.baseParams.cust_unit!==null){cust_unit_print = customer_DataStore.baseParams.cust_unit;}
		if(customer_DataStore.baseParams.cust_aktif!==null){cust_aktif_print = customer_DataStore.baseParams.cust_aktif;}
		if(sortby_SearchField.getValue()!==null){sortby_print=sortby_SearchField.getValue();}
		if(fretfulness_SearchField.getValue()!==null){fretfulness_print=fretfulness_SearchField.getValue();}
		if(cust_umurstartSearchField.getValue()!==null){cust_umurstart_print=cust_umurstartSearchField.getValue();}
		if(cust_umurendSearchField.getValue()!==null){cust_umurend_print=cust_umurendSearchField.getValue();}
		if(cust_terdaftarSearchField.getValue()!==""){cust_terdaftar_print_date=cust_terdaftarSearchField.getValue().format('Y-m-d');}
		if(cust_tgldaftarSearchFieldEnd.getValue()!==""){cust_terdaftarend_print_date=cust_tgldaftarSearchFieldEnd.getValue().format('Y-m-d');}
		if(member_terdaftarSearchField.getValue()!==""){member_terdaftar_print_date=member_terdaftarSearchField.getValue().format('Y-m-d');}
		if(member_tgldaftarSearchFieldEnd.getValue()!==""){member_terdaftarend_print_date=member_tgldaftarSearchFieldEnd.getValue().format('Y-m-d');}
		if(cust_tglawaltransSearchField.getValue()!==""){cust_tglawaltrans_print_date=cust_tglawaltransSearchField.getValue().format('Y-m-d');}
		if(cust_tglawaltransSearchFieldEnd.getValue()!==""){cust_tglawaltransend_print_date=cust_tglawaltransSearchFieldEnd.getValue().format('Y-m-d');}		
		if(cust_tgl_transaksiSearchFieldStart.getValue()!==""){cust_tgl_transaksi_print_date=cust_tgl_transaksiSearchFieldStart.getValue().format('Y-m-d');}
		if(cust_tgl_transaksiSearchFieldEnd.getValue()!==""){cust_tgl_transaksi_print_dateEnd=cust_tgl_transaksiSearchFieldEnd.getValue().format('Y-m-d');}
		if(cust_tidak_tgl_transaksiSearchFieldStart.getValue()!==""){cust_tidak_tgl_transaksi_print_date=cust_tidak_tgl_transaksiSearchFieldStart.getValue().format('Y-m-d');}
		if(cust_tidak_tgl_transaksiSearchFieldEnd.getValue()!==""){cust_tidak_tgl_transaksi_print_dateEnd=cust_tidak_tgl_transaksiSearchFieldEnd.getValue().format('Y-m-d');}

		if(cust_tgl_opsiField.getValue()==true){			
			if(cust_tgllahirSearchField.getValue()!==""){cust_tgllahir_print_date=cust_tgllahirSearchField.getValue().format('Y-m-d');}
			if(cust_tgllahirSearchFieldEnd.getValue()!==""){cust_tgllahir_print_dateEnd=cust_tgllahirSearchFieldEnd.getValue().format('Y-m-d');}
		}		
		else if(cust_bulan_opsiField.getValue()==true){
			if(cust_tglSearchField.getValue()!==null){cust_tgl_print=cust_tglSearchField.getValue();}
			if(cust_bulanSearchField.getValue()!==null){cust_bulan_print=cust_bulanSearchField.getValue();}
			if(cust_tglSearchFieldEnd.getValue()!==null){cust_tgl_printEnd=cust_tglSearchFieldEnd.getValue();}
			if(cust_bulanSearchFieldEnd.getValue()!==null){cust_bulan_printEnd=cust_bulanSearchFieldEnd.getValue();}
		}

		Ext.Ajax.request({   
//		waitMsg: 'Please Wait...',
		waitMsg: 'Silahkan tunggu...',
		url: 'index.php?c=c_customer&m=get_action',
		params: {
			task					: "PRINT",
		  	query					: searchquery,                    		
			cust_no 				: cust_no_print,
			cust_nolama 			: cust_nolama_print,
			cust_no_awal 			: cust_no_awal_print,
			cust_no_akhir 			: cust_no_akhir_print,
			cust_nama 				: cust_nama_print,
			cust_panggilan			: cust_panggilan_print,
			cust_foreigner			: cust_foreigner_print,
			cust_kelamin 			: cust_kelamin_print,
			cust_alamat 			: cust_alamat_print,
			cust_alamat2 			: cust_alamat2_print,
			cust_kota 				: cust_kota_print,
			cust_kodepos 			: cust_kodepos_print,
			cust_propinsi 			: cust_propinsi_print,
			cust_negara 			: cust_negara_print,
			cust_telprumah 			: cust_telprumah_print,
			cust_telprumah2 		: cust_telprumah2_print,
			cust_telpkantor 		: cust_telpkantor_print,
			cust_hp 				: cust_hp_print,
			cust_hp2 				: cust_hp2_print,
			cust_hp3 				: cust_hp3_print,
			cust_email 				: cust_email_print,
			cust_agama 				: cust_agama_print,
			cust_pendidikan 		: cust_pendidikan_print,
			cust_profesi 			: cust_profesi_print,
		  	cust_tgllahir 			: cust_tgllahir_print_date, 
			cust_tgllahirend		:	cust_tgllahir_print_dateEnd, 
			cust_hobi_baca 			: cust_hobi_bacaSearchField.getValue(),
			cust_hobi_olah 			: cust_hobi_olahSearchField.getValue(),
			cust_hobi_masak 		: cust_hobi_masakSearchField.getValue(),
			cust_hobi_travel 		: cust_hobi_travelSearchField.getValue(),
			cust_hobi_foto 			: cust_hobi_fotoSearchField.getValue(),
			cust_hobi_lukis 		: cust_hobi_lukisSearchField.getValue(),
			cust_hobi_nari 			: cust_hobi_nariSearchField.getValue(),
			cust_hobi_lain 			: cust_hobi_lainSearchField.getValue(),
			cust_referensilain		:	cust_referensilain_print, 
			cust_referensi 			: cust_referensi_print,
			cust_bb					:	cust_bb_print, 
			cust_umurstart 			: cust_umurstart_print,
			cust_umurend 			: cust_umurend_print,
			cust_tgl				: cust_tgl_print,
			cust_bulan				: cust_bulan_print,
			cust_tglEnd				: cust_tgl_printEnd,
			cust_bulanEnd			: cust_bulan_printEnd,
			cust_keterangan 		: cust_keterangan_print,
			cust_member 			: cust_member_print,
			cust_member2 			: cust_member2_print,
		  	cust_terdaftar 			: cust_terdaftar_print_date,
			cust_terdaftar_end 		: cust_terdaftarend_print_date,			
			member_terdaftarstart 	: member_terdaftar_print_date,
			member_terdaftarend	 	: member_terdaftarend_print_date,			
			cust_tglawaltrans		: cust_tglawaltrans_print_date,	
			cust_tglawaltrans_end	: cust_tglawaltransend_print_date,			
			cust_statusnikah 		: cust_statusnikah_print,
			cust_priority 			: cust_priority_print,
			cust_jmlanak 			: cust_jmlanak_print,
			cust_unit 				: cust_unit_print,
			cust_aktif 				: cust_aktif_print,
			sortby					:	sortby_print,
			cust_fretfulness 		: fretfulness_print,
			cust_transaksi_start 	: cust_tgl_transaksi_print_date,
			cust_transaksi_end 		: cust_tgl_transaksi_print_dateEnd,
			cust_tidak_transaksi_start : cust_tidak_tgl_transaksi_print_date,
			cust_tidak_transaksi_end   : cust_tidak_tgl_transaksi_print_dateEnd,
		  	currentlisting			: customer_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/customerlist.html','customerlist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
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
	
	/* Function for print Label */
	function customer_print_label(){
		var searchquery = "";
		var cust_no_print=null;
		var cust_nolama_print=null;
		var cust_no_awal_print=null;
		var cust_no_akhir_print=null;
		var cust_nama_print=null;
		var cust_panggilan_print=null;
		var cust_foreigner_print=null;
		var cust_kelamin_print=null;
		var cust_alamat_print=null;
		var cust_alamat2_print=null;
		var cust_kota_print=null;
		var cust_kodepos_print=null;
		var cust_propinsi_print=null;
		var cust_negara_print=null;
		var cust_telprumah_print=null;
		var cust_telprumah2_print=null;
		var cust_telpkantor_print=null;
		var cust_hp_print=null;
		var cust_hp2_print=null;
		var cust_hp3_print=null;
		var cust_email_print=null;
		var cust_agama_print=null;
		var cust_pendidikan_print=null;
		var cust_profesi_print=null;
		var cust_referensi_print=null;
		var cust_referensilain_print=null;
		var cust_keterangan_print=null;
		var cust_member_print=null;
		var cust_member2_print=null;
		var cust_statusnikah_print=null;
		var cust_priority_print=null;
		var cust_jmlanak_print=null;
		var cust_unit_print=null;
		var cust_aktif_print=null;
		var cust_bb_print=null;
		var sortby_print=null;
		var fretfulness_print=null;		
		var cust_tgl_transaksi_print_date="";
		var cust_tgl_transaksi_print_dateEnd="";
		var cust_tidak_tgl_transaksi_print_date="";
		var cust_tidak_tgl_transaksi_print_dateEnd="";		
		var cust_tgl_print=null;
		var cust_bulan_print=null;
		var cust_tgl_printEnd=null;
		var cust_bulan_printEnd=null;
		var cust_umurstart_print=null;
		var cust_umurend_print=null;
		var cust_tgllahir_print_date="";
		var cust_tgllahir_print_dateEnd="";
		var cust_terdaftar_print_date="";
		var cust_terdaftarend_print_date="";		
		var member_terdaftar_print_date="";
		var member_terdaftarend_print_date="";		
		var cust_tglawaltrans_print_date="";
		var cust_tglawaltransend_print_date="";
		var cust_tglawaltrans_end_print_date="";	
		var win;          
		
		// check if we do have some search data...
		if(customer_DataStore.baseParams.query!==null){searchquery = customer_DataStore.baseParams.query;}
		if(customer_DataStore.baseParams.cust_no!==null){cust_no_print = customer_DataStore.baseParams.cust_no;}
		if(customer_DataStore.baseParams.cust_nolama!==null){cust_nolama_print = customer_DataStore.baseParams.cust_nolama;}
		if(customer_DataStore.baseParams.cust_no_awal!==null){cust_no_awal_print = customer_DataStore.baseParams.cust_no_awal;}
		if(customer_DataStore.baseParams.cust_no_akhir!==null){cust_no_akhir_print = customer_DataStore.baseParams.cust_no_akhir;}
		if(customer_DataStore.baseParams.cust_nama!==null){cust_nama_print = customer_DataStore.baseParams.cust_nama;}
		if(customer_DataStore.baseParams.cust_panggilan!==null){cust_panggilan_print = customer_DataStore.baseParams.cust_panggilan;}
		if(customer_DataStore.baseParams.cust_foreigner!==null){cust_foreigner_print = customer_DataStore.baseParams.cust_foreigner;}
		if(customer_DataStore.baseParams.cust_kelamin!==null){cust_kelamin_print = customer_DataStore.baseParams.cust_kelamin;}
		if(customer_DataStore.baseParams.cust_alamat!==null){cust_alamat_print = customer_DataStore.baseParams.cust_alamat;}
		if(customer_DataStore.baseParams.cust_alamat2!==null){cust_alamat2_print = customer_DataStore.baseParams.cust_alamat2;}
		if(customer_DataStore.baseParams.cust_kota!==null){cust_kota_print = customer_DataStore.baseParams.cust_kota;}
		if(customer_DataStore.baseParams.cust_kodepos!==null){cust_kodepos_print = customer_DataStore.baseParams.cust_kodepos;}
		if(customer_DataStore.baseParams.cust_propinsi!==null){cust_propinsi_print = customer_DataStore.baseParams.cust_propinsi;}
		if(customer_DataStore.baseParams.cust_negara!==null){cust_negara_print = customer_DataStore.baseParams.cust_negara;}
		if(customer_DataStore.baseParams.cust_telprumah!==null){cust_telprumah_print = customer_DataStore.baseParams.cust_telprumah;}
		if(customer_DataStore.baseParams.cust_telprumah2!==null){cust_telprumah2_print = customer_DataStore.baseParams.cust_telprumah2;}
		if(customer_DataStore.baseParams.cust_telpkantor!==null){cust_telpkantor_print = customer_DataStore.baseParams.cust_telpkantor;}
		if(customer_DataStore.baseParams.cust_hp!==null){cust_hp_print = customer_DataStore.baseParams.cust_hp;}
		if(customer_DataStore.baseParams.cust_hp2!==null){cust_hp2_print = customer_DataStore.baseParams.cust_hp2;}
		if(customer_DataStore.baseParams.cust_hp3!==null){cust_hp3_print = customer_DataStore.baseParams.cust_hp3;}
		if(customer_DataStore.baseParams.cust_email!==null){cust_email_print = customer_DataStore.baseParams.cust_email;}
		if(customer_DataStore.baseParams.cust_agama!==null){cust_agama_print = customer_DataStore.baseParams.cust_agama;}
		if(customer_DataStore.baseParams.cust_pendidikan!==null){cust_pendidikan_print = customer_DataStore.baseParams.cust_pendidikan;}
		if(customer_DataStore.baseParams.cust_profesi!==null){cust_profesi_print = customer_DataStore.baseParams.cust_profesi;}
		if(customer_DataStore.baseParams.cust_referensi!==null){cust_referensi_print = customer_DataStore.baseParams.cust_referensi;}
		if(cust_referensilainSearchField.getValue()!==null){cust_referensilain_print=cust_referensilainSearchField.getValue();}
		if(customer_DataStore.baseParams.cust_keterangan!==null){cust_keterangan_print = customer_DataStore.baseParams.cust_keterangan;}
		if(customer_DataStore.baseParams.cust_member!==null){cust_member_print = customer_DataStore.baseParams.cust_member;}
		if(customer_DataStore.baseParams.cust_member2!==null){cust_member2_print = customer_DataStore.baseParams.cust_member2;}
		if(customer_DataStore.baseParams.cust_statusnikah!==null){cust_statusnikah_print = customer_DataStore.baseParams.cust_statusnikah;}
		if(customer_DataStore.baseParams.cust_priority!==null){cust_priority_print = customer_DataStore.baseParams.cust_priority;}
		if(customer_DataStore.baseParams.cust_jmlanak!==null){cust_jmlanak_print = customer_DataStore.baseParams.cust_jmlanak;}
		if(customer_DataStore.baseParams.cust_unit!==null){cust_unit_print = customer_DataStore.baseParams.cust_unit;}
		if(customer_DataStore.baseParams.cust_aktif!==null){cust_aktif_print = customer_DataStore.baseParams.cust_aktif;}
		if(sortby_SearchField.getValue()!==null){sortby_print=sortby_SearchField.getValue();}
		if(fretfulness_SearchField.getValue()!==null){fretfulness_print=fretfulness_SearchField.getValue();}
		if(cust_umurstartSearchField.getValue()!==null){cust_umurstart_print=cust_umurstartSearchField.getValue();}
		if(cust_umurendSearchField.getValue()!==null){cust_umurend_print=cust_umurendSearchField.getValue();}
		if(cust_terdaftarSearchField.getValue()!==""){cust_terdaftar_print_date=cust_terdaftarSearchField.getValue().format('Y-m-d');}
		if(cust_tgldaftarSearchFieldEnd.getValue()!==""){cust_terdaftarend_print_date=cust_tgldaftarSearchFieldEnd.getValue().format('Y-m-d');}
		if(member_terdaftarSearchField.getValue()!==""){member_terdaftar_print_date=member_terdaftarSearchField.getValue().format('Y-m-d');}
		if(member_tgldaftarSearchFieldEnd.getValue()!==""){member_terdaftarend_print_date=member_tgldaftarSearchFieldEnd.getValue().format('Y-m-d');}
		if(cust_tglawaltransSearchField.getValue()!==""){cust_tglawaltrans_print_date=cust_tglawaltransSearchField.getValue().format('Y-m-d');}
		if(cust_tglawaltransSearchFieldEnd.getValue()!==""){cust_tglawaltransend_print_date=cust_tglawaltransSearchFieldEnd.getValue().format('Y-m-d');}		
		if(cust_tgl_transaksiSearchFieldStart.getValue()!==""){cust_tgl_transaksi_print_date=cust_tgl_transaksiSearchFieldStart.getValue().format('Y-m-d');}
		if(cust_tgl_transaksiSearchFieldEnd.getValue()!==""){cust_tgl_transaksi_print_dateEnd=cust_tgl_transaksiSearchFieldEnd.getValue().format('Y-m-d');}
		if(cust_tidak_tgl_transaksiSearchFieldStart.getValue()!==""){cust_tidak_tgl_transaksi_print_date=cust_tidak_tgl_transaksiSearchFieldStart.getValue().format('Y-m-d');}
		if(cust_tidak_tgl_transaksiSearchFieldEnd.getValue()!==""){cust_tidak_tgl_transaksi_print_dateEnd=cust_tidak_tgl_transaksiSearchFieldEnd.getValue().format('Y-m-d');}

		if(cust_tgl_opsiField.getValue()==true){			
			if(cust_tgllahirSearchField.getValue()!==""){cust_tgllahir_print_date=cust_tgllahirSearchField.getValue().format('Y-m-d');}
			if(cust_tgllahirSearchFieldEnd.getValue()!==""){cust_tgllahir_print_dateEnd=cust_tgllahirSearchFieldEnd.getValue().format('Y-m-d');}
		}		
		else if(cust_bulan_opsiField.getValue()==true){
			if(cust_tglSearchField.getValue()!==null){cust_tgl_print=cust_tglSearchField.getValue();}
			if(cust_bulanSearchField.getValue()!==null){cust_bulan_print=cust_bulanSearchField.getValue();}
			if(cust_tglSearchFieldEnd.getValue()!==null){cust_tgl_printEnd=cust_tglSearchFieldEnd.getValue();}
			if(cust_bulanSearchFieldEnd.getValue()!==null){cust_bulan_printEnd=cust_bulanSearchFieldEnd.getValue();}
		}
		
		Ext.Ajax.request({   
		waitMsg: 'Silahkan tunggu ...',
		url: 'index.php?c=c_customer&m=get_action',
		params: {
			task: "PRINT_LABEL",
		  	query: searchquery,                    		
			cust_no 				: cust_no_print,
			cust_nolama 			: cust_nolama_print,
			cust_no_awal 			: cust_no_awal_print,
			cust_no_akhir 			: cust_no_akhir_print,
			cust_nama 				: cust_nama_print,
			cust_panggilan			: cust_panggilan_print,
			cust_foreigner 			: cust_foreigner_print,
			cust_kelamin 			: cust_kelamin_print,
			cust_alamat 			: cust_alamat_print,
			cust_alamat2 			: cust_alamat2_print,
			cust_kota 				: cust_kota_print,
			cust_kodepos 			: cust_kodepos_print,
			cust_propinsi 			: cust_propinsi_print,
			cust_negara 			: cust_negara_print,
			cust_telprumah 			: cust_telprumah_print,
			cust_telprumah2 		: cust_telprumah2_print,
			cust_telpkantor 		: cust_telpkantor_print,
			cust_hp 				: cust_hp_print,
			cust_hp2 				: cust_hp2_print,
			cust_hp3 				: cust_hp3_print,
			cust_email 				: cust_email_print,
			cust_agama 				: cust_agama_print,
			cust_pendidikan 		: cust_pendidikan_print,
			cust_profesi 			: cust_profesi_print,
		  	cust_tgllahir 			: cust_tgllahir_print_date, 
			cust_tgllahirend		:	cust_tgllahir_print_dateEnd, 
			cust_hobi_baca 			: cust_hobi_bacaSearchField.getValue(),
			cust_hobi_olah 			: cust_hobi_olahSearchField.getValue(),
			cust_hobi_masak 		: cust_hobi_masakSearchField.getValue(),
			cust_hobi_travel 		: cust_hobi_travelSearchField.getValue(),
			cust_hobi_foto 			: cust_hobi_fotoSearchField.getValue(),
			cust_hobi_lukis 		: cust_hobi_lukisSearchField.getValue(),
			cust_hobi_nari 			: cust_hobi_nariSearchField.getValue(),
			cust_hobi_lain 			: cust_hobi_lainSearchField.getValue(),
			cust_referensilain		:	cust_referensilain_print, 
			cust_referensi 			: cust_referensi_print,
			cust_bb					:	cust_bb_print, 
			cust_umurstart 			: cust_umurstart_print,
			cust_umurend 			: cust_umurend_print,
			cust_tgl				: cust_tgl_print,
			cust_bulan				: cust_bulan_print,
			cust_tglEnd				: cust_tgl_printEnd,
			cust_bulanEnd			: cust_bulan_printEnd,
			cust_keterangan 		: cust_keterangan_print,
			cust_member 			: cust_member_print,
			cust_member2 			: cust_member2_print,
		  	cust_terdaftar 			: cust_terdaftar_print_date,
			cust_terdaftar_end 		: cust_terdaftarend_print_date,			
			member_terdaftarstart 	: member_terdaftar_print_date,
			member_terdaftarend	 	: member_terdaftarend_print_date,			
			cust_tglawaltrans		: cust_tglawaltrans_print_date,	
			cust_tglawaltrans_end	: cust_tglawaltransend_print_date,			
			cust_statusnikah 		: cust_statusnikah_print,
			cust_priority 			: cust_priority_print,
			cust_jmlanak 			: cust_jmlanak_print,
			cust_unit 				: cust_unit_print,
			cust_aktif 				: cust_aktif_print,
			sortby					:	sortby_print,
			cust_fretfulness 		: fretfulness_print,
			cust_transaksi_start 	: cust_tgl_transaksi_print_date,
			cust_transaksi_end 		: cust_tgl_transaksi_print_dateEnd,
			cust_tidak_transaksi_start : cust_tidak_tgl_transaksi_print_date,
			cust_tidak_transaksi_end   : cust_tidak_tgl_transaksi_print_dateEnd,
		  	currentlisting: customer_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./customerlist.html','customerlist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
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
	
	/* Function for print Export to Excel Grid */
	function customer_export_excel(){
		var searchquery = "";
		var cust_no_2excel=null;
		var cust_nolama_2excel=null;
		var cust_no_awal_2excel=null;
		var cust_no_akhir_2excel=null;
		var cust_nama_2excel=null;
		var cust_panggilan_2excel=null;
		var cust_foreigner_2excel=null;
		var cust_kelamin_2excel=null;
		var cust_alamat_2excel=null;
		var cust_alamat2_2excel=null;
		var cust_kota_2excel=null;
		var cust_kodepos_2excel=null;
		var cust_propinsi_2excel=null;
		var cust_negara_2excel=null;
		var cust_telprumah_2excel=null;
		var cust_telprumah2_2excel=null;
		var cust_telpkantor_2excel=null;
		var cust_hp_2excel=null;
		var cust_hp2_2excel=null;
		var cust_hp3_2excel=null;
		var cust_email_2excel=null;
		var cust_agama_2excel=null;
		var cust_pendidikan_2excel=null;
		var cust_profesi_2excel=null;
		var cust_referensi_2excel=null;
		var cust_referensilain_2excel=null;
		var cust_keterangan_2excel=null;
		var cust_member_2excel=null;
		var cust_member2_2excel=null;
		var cust_statusnikah_2excel=null;
		var cust_priority_2excel=null;
		var cust_jmlanak_2excel=null;
		var cust_unit_2excel=null;
		var cust_aktif_2excel=null;
		var cust_bb_2excel=null;
		var sortby_2excel=null;
		var fretfulness_2excel=null;		
		var cust_tgl_transaksi_2excel_date="";
		var cust_tgl_transaksi_2excel_dateEnd="";
		var cust_tidak_tgl_transaksi_2excel_date="";
		var cust_tidak_tgl_transaksi_2excel_dateEnd="";		
		var cust_tgl_2excel=null;
		var cust_bulan_2excel=null;
		var cust_tgl_2excelEnd=null;
		var cust_bulan_2excelEnd=null;
		var cust_umurstart_2excel=null;
		var cust_umurend_2excel=null;
		var cust_tgllahir_2excel_date="";
		var cust_tgllahir_2excel_dateEnd="";
		var cust_terdaftar_2excel_date="";
		var cust_terdaftarend_2excel_date="";		
		var member_terdaftar_2excel_date="";
		var member_terdaftarend_2excel_date="";		
		var cust_tglawaltrans_2excel_date="";
		var cust_tglawaltransend_2excel_date="";
		var cust_tglawaltrans_end_2excel_date="";	
		var win;              
		
		// check if we do have some search data...
		if(customer_DataStore.baseParams.query!==null){searchquery = customer_DataStore.baseParams.query;}
		if(customer_DataStore.baseParams.cust_no!==null){cust_no_2excel = customer_DataStore.baseParams.cust_no;}
		if(customer_DataStore.baseParams.cust_nolama!==null){cust_nolama_2excel = customer_DataStore.baseParams.cust_nolama;}
		if(customer_DataStore.baseParams.cust_no_awal!==null){cust_no_awal_2excel = customer_DataStore.baseParams.cust_no_awal;}
		if(customer_DataStore.baseParams.cust_no_akhir!==null){cust_no_akhir_2excel = customer_DataStore.baseParams.cust_no_akhir;}
		if(customer_DataStore.baseParams.cust_nama!==null){cust_nama_2excel = customer_DataStore.baseParams.cust_nama;}
		if(customer_DataStore.baseParams.cust_panggilan!==null){cust_panggilan_2excel = customer_DataStore.baseParams.cust_panggilan;}
		if(customer_DataStore.baseParams.cust_foreigner!==null){cust_foreigner_2excel = customer_DataStore.baseParams.cust_foreigner;}
		if(customer_DataStore.baseParams.cust_kelamin!==null){cust_kelamin_2excel = customer_DataStore.baseParams.cust_kelamin;}
		if(customer_DataStore.baseParams.cust_alamat!==null){cust_alamat_2excel = customer_DataStore.baseParams.cust_alamat;}
		if(customer_DataStore.baseParams.cust_alamat2!==null){cust_alamat2_2excel = customer_DataStore.baseParams.cust_alamat2;}
		if(customer_DataStore.baseParams.cust_kota!==null){cust_kota_2excel = customer_DataStore.baseParams.cust_kota;}
		if(customer_DataStore.baseParams.cust_kodepos!==null){cust_kodepos_2excel = customer_DataStore.baseParams.cust_kodepos;}
		if(customer_DataStore.baseParams.cust_propinsi!==null){cust_propinsi_2excel = customer_DataStore.baseParams.cust_propinsi;}
		if(customer_DataStore.baseParams.cust_negara!==null){cust_negara_2excel = customer_DataStore.baseParams.cust_negara;}
		if(customer_DataStore.baseParams.cust_telprumah!==null){cust_telprumah_2excel = customer_DataStore.baseParams.cust_telprumah;}
		if(customer_DataStore.baseParams.cust_telprumah2!==null){cust_telprumah2_2excel = customer_DataStore.baseParams.cust_telprumah2;}
		if(customer_DataStore.baseParams.cust_telpkantor!==null){cust_telpkantor_2excel = customer_DataStore.baseParams.cust_telpkantor;}
		if(customer_DataStore.baseParams.cust_hp!==null){cust_hp_2excel = customer_DataStore.baseParams.cust_hp;}
		if(customer_DataStore.baseParams.cust_hp2!==null){cust_hp2_2excel = customer_DataStore.baseParams.cust_hp2;}
		if(customer_DataStore.baseParams.cust_hp3!==null){cust_hp3_2excel = customer_DataStore.baseParams.cust_hp3;}
		if(customer_DataStore.baseParams.cust_email!==null){cust_email_2excel = customer_DataStore.baseParams.cust_email;}
		if(customer_DataStore.baseParams.cust_agama!==null){cust_agama_2excel = customer_DataStore.baseParams.cust_agama;}
		if(customer_DataStore.baseParams.cust_pendidikan!==null){cust_pendidikan_2excel = customer_DataStore.baseParams.cust_pendidikan;}
		if(customer_DataStore.baseParams.cust_profesi!==null){cust_profesi_2excel = customer_DataStore.baseParams.cust_profesi;}
		if(customer_DataStore.baseParams.cust_referensi!==null){cust_referensi_2excel = customer_DataStore.baseParams.cust_referensi;}
		if(cust_referensilainSearchField.getValue()!==null){cust_referensilain_2excel=cust_referensilainSearchField.getValue();}
		if(customer_DataStore.baseParams.cust_keterangan!==null){cust_keterangan_2excel = customer_DataStore.baseParams.cust_keterangan;}
		if(customer_DataStore.baseParams.cust_member!==null){cust_member_2excel = customer_DataStore.baseParams.cust_member;}
		if(customer_DataStore.baseParams.cust_member2!==null){cust_member2_2excel = customer_DataStore.baseParams.cust_member2;}
		if(customer_DataStore.baseParams.cust_statusnikah!==null){cust_statusnikah_2excel = customer_DataStore.baseParams.cust_statusnikah;}
		if(customer_DataStore.baseParams.cust_priority!==null){cust_priority_2excel = customer_DataStore.baseParams.cust_priority;}
		if(customer_DataStore.baseParams.cust_jmlanak!==null){cust_jmlanak_2excel = customer_DataStore.baseParams.cust_jmlanak;}
		if(customer_DataStore.baseParams.cust_unit!==null){cust_unit_2excel = customer_DataStore.baseParams.cust_unit;}
		if(customer_DataStore.baseParams.cust_aktif!==null){cust_aktif_2excel = customer_DataStore.baseParams.cust_aktif;}
		if(sortby_SearchField.getValue()!==null){sortby_2excel=sortby_SearchField.getValue();}
		if(fretfulness_SearchField.getValue()!==null){fretfulness_2excel=fretfulness_SearchField.getValue();}
		if(cust_umurstartSearchField.getValue()!==null){cust_umurstart_2excel=cust_umurstartSearchField.getValue();}
		if(cust_umurendSearchField.getValue()!==null){cust_umurend_2excel=cust_umurendSearchField.getValue();}
		if(cust_terdaftarSearchField.getValue()!==""){cust_terdaftar_2excel_date=cust_terdaftarSearchField.getValue().format('Y-m-d');}
		if(cust_tgldaftarSearchFieldEnd.getValue()!==""){cust_terdaftarend_2excel_date=cust_tgldaftarSearchFieldEnd.getValue().format('Y-m-d');}
		if(member_terdaftarSearchField.getValue()!==""){member_terdaftar_2excel_date=member_terdaftarSearchField.getValue().format('Y-m-d');}
		if(member_tgldaftarSearchFieldEnd.getValue()!==""){member_terdaftarend_2excel_date=member_tgldaftarSearchFieldEnd.getValue().format('Y-m-d');}
		if(cust_tglawaltransSearchField.getValue()!==""){cust_tglawaltrans_2excel_date=cust_tglawaltransSearchField.getValue().format('Y-m-d');}
		if(cust_tglawaltransSearchFieldEnd.getValue()!==""){cust_tglawaltransend_2excel_date=cust_tglawaltransSearchFieldEnd.getValue().format('Y-m-d');}		
		if(cust_tgl_transaksiSearchFieldStart.getValue()!==""){cust_tgl_transaksi_2excel_date=cust_tgl_transaksiSearchFieldStart.getValue().format('Y-m-d');}
		if(cust_tgl_transaksiSearchFieldEnd.getValue()!==""){cust_tgl_transaksi_2excel_dateEnd=cust_tgl_transaksiSearchFieldEnd.getValue().format('Y-m-d');}
		if(cust_tidak_tgl_transaksiSearchFieldStart.getValue()!==""){cust_tidak_tgl_transaksi_2excel_date=cust_tidak_tgl_transaksiSearchFieldStart.getValue().format('Y-m-d');}
		if(cust_tidak_tgl_transaksiSearchFieldEnd.getValue()!==""){cust_tidak_tgl_transaksi_2excel_dateEnd=cust_tidak_tgl_transaksiSearchFieldEnd.getValue().format('Y-m-d');}

		if(cust_tgl_opsiField.getValue()==true){			
			if(cust_tgllahirSearchField.getValue()!==""){cust_tgllahir_2excel_date=cust_tgllahirSearchField.getValue().format('Y-m-d');}
			if(cust_tgllahirSearchFieldEnd.getValue()!==""){cust_tgllahir_2excel_dateEnd=cust_tgllahirSearchFieldEnd.getValue().format('Y-m-d');}
		}		
		else if(cust_bulan_opsiField.getValue()==true){
			if(cust_tglSearchField.getValue()!==null){cust_tgl_2excel=cust_tglSearchField.getValue();}
			if(cust_bulanSearchField.getValue()!==null){cust_bulan_2excel=cust_bulanSearchField.getValue();}
			if(cust_tglSearchFieldEnd.getValue()!==null){cust_tgl_2excelEnd=cust_tglSearchFieldEnd.getValue();}
			if(cust_bulanSearchFieldEnd.getValue()!==null){cust_bulan_2excelEnd=cust_bulanSearchFieldEnd.getValue();}
		}
		
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_customer&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			cust_no : cust_no_2excel,
			cust_no 				: cust_no_2excel,
			cust_nolama 			: cust_nolama_2excel,
			cust_no_awal 			: cust_no_awal_2excel,
			cust_no_akhir 			: cust_no_akhir_2excel,
			cust_nama 				: cust_nama_2excel,
			cust_panggilan 			: cust_panggilan_2excel,
			cust_foreigner			: cust_foreigner_2excel,
			cust_kelamin 			: cust_kelamin_2excel,
			cust_alamat 			: cust_alamat_2excel,
			cust_alamat2 			: cust_alamat2_2excel,
			cust_kota 				: cust_kota_2excel,
			cust_kodepos 			: cust_kodepos_2excel,
			cust_propinsi 			: cust_propinsi_2excel,
			cust_negara 			: cust_negara_2excel,
			cust_telprumah 			: cust_telprumah_2excel,
			cust_telprumah2 		: cust_telprumah2_2excel,
			cust_telpkantor 		: cust_telpkantor_2excel,
			cust_hp 				: cust_hp_2excel,
			cust_hp2 				: cust_hp2_2excel,
			cust_hp3 				: cust_hp3_2excel,
			cust_email 				: cust_email_2excel,
			cust_agama 				: cust_agama_2excel,
			cust_pendidikan 		: cust_pendidikan_2excel,
			cust_profesi 			: cust_profesi_2excel,
		  	cust_tgllahir 			: cust_tgllahir_2excel_date, 
			cust_tgllahirend		:	cust_tgllahir_2excel_dateEnd, 
			cust_hobi_baca 			: cust_hobi_bacaSearchField.getValue(),
			cust_hobi_olah 			: cust_hobi_olahSearchField.getValue(),
			cust_hobi_masak 		: cust_hobi_masakSearchField.getValue(),
			cust_hobi_travel 		: cust_hobi_travelSearchField.getValue(),
			cust_hobi_foto 			: cust_hobi_fotoSearchField.getValue(),
			cust_hobi_lukis 		: cust_hobi_lukisSearchField.getValue(),
			cust_hobi_nari 			: cust_hobi_nariSearchField.getValue(),
			cust_hobi_lain 			: cust_hobi_lainSearchField.getValue(),
			cust_referensilain		:	cust_referensilain_2excel, 
			cust_referensi 			: cust_referensi_2excel,
			cust_bb					:	cust_bb_2excel, 
			cust_umurstart 			: cust_umurstart_2excel,
			cust_umurend 			: cust_umurend_2excel,
			cust_tgl				: cust_tgl_2excel,
			cust_bulan				: cust_bulan_2excel,
			cust_tglEnd				: cust_tgl_2excelEnd,
			cust_bulanEnd			: cust_bulan_2excelEnd,
			cust_keterangan 		: cust_keterangan_2excel,
			cust_member 			: cust_member_2excel,
			cust_member2 			: cust_member2_2excel,
		  	cust_terdaftar 			: cust_terdaftar_2excel_date,
			cust_terdaftar_end 		: cust_terdaftarend_2excel_date,			
			member_terdaftarstart 	: member_terdaftar_2excel_date,
			member_terdaftarend	 	: member_terdaftarend_2excel_date,			
			cust_tglawaltrans		: cust_tglawaltrans_2excel_date,	
			cust_tglawaltrans_end	: cust_tglawaltransend_2excel_date,			
			cust_statusnikah 		: cust_statusnikah_2excel,
			cust_priority 			: cust_priority_2excel,
			cust_jmlanak 			: cust_jmlanak_2excel,
			cust_unit 				: cust_unit_2excel,
			cust_aktif 				: cust_aktif_2excel,
			sortby					:	sortby_2excel,
			cust_fretfulness 		: fretfulness_2excel,
			cust_transaksi_start 	: cust_tgl_transaksi_2excel_date,
			cust_transaksi_end 		: cust_tgl_transaksi_2excel_dateEnd,
			cust_tidak_transaksi_start : cust_tidak_tgl_transaksi_2excel_date,
			cust_tidak_transaksi_end   : cust_tidak_tgl_transaksi_2excel_dateEnd,
		  	currentlisting: customer_DataStore.baseParams.task // this tells us if we are searching or not
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
	
		/* Function for Saving inLine Editing */
	function customer_update(oGrid_event){
		var cust_id_update_pk="";
		var cust_no_update=null;
		var cust_nolama_update=null;
		var cust_nama_update=null;
		var cust_panggilan_update=null;
		var cust_kelamin_update=null;
		var cust_alamat_update=null;
		var cust_kota_update=null;
		var cust_kodepos_update=null;
		var cust_propinsi_update=null;
		var cust_negara_update=null;
		var cust_alamat2_update=null;
		var cust_kota2_update=null;
		var cust_kodepos2_update=null;
		var cust_propinsi2_update=null;
		var cust_negara2_update=null;
		var cust_telprumah_update=null;
		var cust_telprumah2_update=null;
		var cust_telpkantor_update=null;
		var cust_hp_update=null;
		var cust_hp2_update=null;
		var cust_hp3_update=null;
		var cust_bb_update=null;
		var cust_email_update=null;
		var cust_email2_update=null;
		var cust_agama_update=null;
		var cust_pendidikan_update=null;
		var cust_profesi_update=null;
		var cust_tgllahir_update_date="";
		//var cust_hobi_update=null;
		var cust_referensi_update=null;
		var cust_referensilain_update=null;
		var cust_keterangan_update=null;
		var cust_terdaftar_update_date="";
		var cust_statusnikah_update=null;
		var cust_priority_update=null;
		var cust_jmlanak_update=null;
		var cust_unit_update=null;
		var cust_aktif_update=null;
	
		cust_id_update_pk = oGrid_event.record.data.cust_id;
		if(oGrid_event.record.data.cust_no!== null){cust_no_update = oGrid_event.record.data.cust_no;}
		if(oGrid_event.record.data.cust_nolama!== null){cust_nolama_update = oGrid_event.record.data.cust_nolama;}
		if(oGrid_event.record.data.cust_nama!== null){cust_nama_update = oGrid_event.record.data.cust_nama;}
		if(oGrid_event.record.data.cust_panggilan!== null){cust_panggilan_update = oGrid_event.record.data.cust_panggilan;}
		if(oGrid_event.record.data.cust_kelamin!== null){cust_kelamin_update = oGrid_event.record.data.cust_kelamin;}
		if(oGrid_event.record.data.cust_alamat!== null){cust_alamat_update = oGrid_event.record.data.cust_alamat;}
		if(oGrid_event.record.data.cust_kota!== null){cust_kota_update = oGrid_event.record.data.cust_kota;}
		if(oGrid_event.record.data.cust_kodepos!== null){cust_kodepos_update = oGrid_event.record.data.cust_kodepos;}
		if(oGrid_event.record.data.cust_propinsi!== null){cust_propinsi_update = oGrid_event.record.data.cust_propinsi;}
		if(oGrid_event.record.data.cust_negara!== null){cust_negara_update = oGrid_event.record.data.cust_negara;}
		if(oGrid_event.record.data.cust_alamat2!== null){cust_alamat2_update = oGrid_event.record.data.cust_alamat2;}
		if(oGrid_event.record.data.cust_kota2!== null){cust_kota2_update = oGrid_event.record.data.cust_kota2;}
		if(oGrid_event.record.data.cust_kodepos2!== null){cust_kodepos2_update = oGrid_event.record.data.cust_kodepos2;}
		if(oGrid_event.record.data.cust_propinsi2!== null){cust_propinsi2_update = oGrid_event.record.data.cust_propinsi2;}
		if(oGrid_event.record.data.cust_negara2!== null){cust_negara2_update = oGrid_event.record.data.cust_negara2;}
		if(oGrid_event.record.data.cust_telprumah!== null){cust_telprumah_update = oGrid_event.record.data.cust_telprumah;}
		if(oGrid_event.record.data.cust_telprumah2!== null){cust_telprumah2_update = oGrid_event.record.data.cust_telprumah2;}
		if(oGrid_event.record.data.cust_telpkantor!== null){cust_telpkantor_update = oGrid_event.record.data.cust_telpkantor;}
		if(oGrid_event.record.data.cust_hp!== null){cust_hp_update = oGrid_event.record.data.cust_hp;}
		if(oGrid_event.record.data.cust_hp2!== null){cust_hp2_update = oGrid_event.record.data.cust_hp2;}
		if(oGrid_event.record.data.cust_hp3!== null){cust_hp3_update = oGrid_event.record.data.cust_hp3;}
		if(oGrid_event.record.data.cust_bb!== null){cust_bb_update = oGrid_event.record.data.cust_bb;}
		if(oGrid_event.record.data.cust_email!== null){cust_email_update = oGrid_event.record.data.cust_email;}
		if(oGrid_event.record.data.cust_email2!== null){cust_email2_update = oGrid_event.record.data.cust_email2;}
		if(oGrid_event.record.data.cust_agama!== null){cust_agama_update = oGrid_event.record.data.cust_agama;}
		if(oGrid_event.record.data.cust_pendidikan!== null){cust_pendidikan_update = oGrid_event.record.data.cust_pendidikan;}
		if(oGrid_event.record.data.cust_profesi!== null){cust_profesi_update = oGrid_event.record.data.cust_profesi;}
		if(oGrid_event.record.data.cust_tgllahir!== ""){cust_tgllahir_update_date = oGrid_event.record.data.cust_tgllahir.format('Y-m-d');}
		//if(oGrid_event.record.data.cust_hobi!== null){cust_hobi_update = oGrid_event.record.data.cust_hobi;}
		if(oGrid_event.record.data.cust_referensi!== null){cust_referensi_update = oGrid_event.record.data.cust_referensi;}
		if(oGrid_event.record.data.cust_referensilain!== null){cust_referensilain_update = oGrid_event.record.data.cust_referensilain;}
		if(oGrid_event.record.data.cust_keterangan!== null){cust_keterangan_update = oGrid_event.record.data.cust_keterangan;}
		if(oGrid_event.record.data.cust_terdaftar!== ""){cust_terdaftar_update_date = oGrid_event.record.data.cust_terdaftar.format('Y-m-d');}
		if(oGrid_event.record.data.cust_tglawaltrans!== ""){cust_tglawaltrans_update_date = oGrid_event.record.data.cust_tglawaltrans.format('Y-m-d');}
		cust_ttglawaltrans
		if(oGrid_event.record.data.cust_statusnikah!== null){cust_statusnikah_update = oGrid_event.record.data.cust_statusnikah;}
		if(oGrid_event.record.data.cust_priority!== null){cust_priority_update = oGrid_event.record.data.cust_priority;}
		if(oGrid_event.record.data.cust_jmlanak!== null){cust_jmlanak_update = oGrid_event.record.data.cust_jmlanak;}
		if(oGrid_event.record.data.cust_unit!== null){cust_unit_update = oGrid_event.record.data.cust_unit;}
		if(oGrid_event.record.data.cust_aktif!== null){cust_aktif_update = oGrid_event.record.data.cust_aktif;}

		Ext.Ajax.request({  
//			waitMsg: 'Please wait...',
			waitMsg: 'Mohon tunggu...',
			url: 'index.php?c=c_customer&m=get_action',
			params: {
				task: "UPDATE",
				cust_id			:cust_id_update_pk,				
				cust_no			:cust_no_update,
				cust_nolama		:cust_nolama_update,
				cust_nama		:cust_nama_update,
				cust_panggilan	:cust_panggilan_update,	
				cust_kelamin	:cust_kelamin_update,		
				cust_alamat		:cust_alamat_update,		
				cust_kota		:cust_kota_update,		
				cust_kodepos	:cust_kodepos_update,		
				cust_propinsi	:cust_propinsi_update,		
				cust_negara		:cust_negara_update,		
				cust_alamat2	:cust_alamat2_update,		
				cust_kota2		:cust_kota2_update,		
				cust_kodepos2	:cust_kodepos2_update,		
				cust_propinsi2	:cust_propinsi2_update,		
				cust_negara2	:cust_negara2_update,		
				cust_telprumah	:cust_telprumah_update,		
				cust_telprumah2	:cust_telprumah2_update,		
				cust_telpkantor	:cust_telpkantor_update,		
				cust_hp			:cust_hp_update,		
				cust_hp2		:cust_hp2_update,		
				cust_hp3		:cust_hp3_update,	
				cust_bb			:cust_bb_update,					
				cust_email		:cust_email_update,	
				cust_email2		:cust_email2_update,	
				cust_agama		:cust_agama_update,		
				cust_pendidikan	:cust_pendidikan_update,		
				cust_profesi	:cust_profesi_update,		
				cust_tgllahir	: cust_tgllahir_update_date,				
				//cust_hobi		:cust_hobi_update,		
				cust_referensi	:cust_referensi_update,		
				cust_referensilain	:cust_referensilain_update,		
				cust_keterangan	:cust_keterangan_update,		
				cust_terdaftar	: cust_terdaftar_update_date,	
				cust_tglawaltrans	:	cust_tglawaltrans_update_date,			
				cust_statusnikah:cust_statusnikah_update,
				//cust_priority	:cust_priority_update,
				cust_jmlanak	:cust_jmlanak_update,			
				cust_unit		:cust_unit_update,		
				cust_aktif		:cust_aktif_update	
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						customer_DataStore.commitChanges();
						customer_DataStore.reload();
						break;
					default:
						Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Data customer tidak bisa disimpan',
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
	function customer_create(){
		if(is_customer_form_valid()){
		
		var cust_id_create_pk=null;
		var cust_no_create=null;
		var cust_nolama_create=null;
		var cust_nama_create=null;
		var cust_panggilan_create=null;
		var cust_foreigner_create=null;
		var cust_kelamin_create=null;
		var cust_title_create=null;
		var cust_alamat_create=null;
		var cust_kota_create=null;
		var cust_kodepos_create=null;
		var cust_propinsi_create=null;
		var cust_negara_create=null;
		var cust_alamat2_create=null;
		var cust_kota2_create=null;
		var cust_kodepos2_create=null;
		var cust_propinsi2_create=null;
		var cust_negara2_create=null;
		var cust_telprumah_create=null;
		var cust_telprumah2_create=null;
		var cust_telpkantor_create=null;
		var cust_hp_create=null;
		var cust_hp2_create=null;
		var cust_hp3_create=null;
		var cust_bb_create=null;
		var cust_email_create=null;
		//var cust_fb_create=false;
		//var cust_tweeter_create=false;
		var cust_email2_create=null;
		//var cust_fb2_create=false;
		//var cust_tweeter2_create=false;
		var cust_agama_create=null;
		var cust_pendidikan_create=null;
		var cust_profesi_create=null;
		var cust_tmptlahir_create=null;
		var cust_tgllahir_create_date="";
		var cust_hobi_create=null;
		var cust_referensi_create=null;
		var cust_referensilain_create=null;
		var cust_keterangan_create=null;
		var cust_terdaftar_create_date="";
		var cust_tglawaltrans_create_date="";
		var cust_statusnikah_create=null;
		var cust_priority_create=null;
		var cust_jmlanak_create=null;
		var cust_unit_create=null;
		var cust_aktif_create=null;
		var cust_fretfulness_create=null;
		var cust_kelamin_create=null;
		var cust_cp_create=null;
		var cust_cptelp_create=null;
		var cust_bb_create=null;
		
		cust_id_create_pk=get_pk_id();
		if(cust_noField.getValue()!== null){cust_no_create = cust_noField.getValue();}
		//if(cust_nolamaField.getValue()!== null){cust_nolama_create = cust_nolamaField.getValue();}
		if(cust_namaField.getValue()!== null){cust_nama_create = cust_namaField.getValue();}
		if(cust_panggilanField.getValue()!== null){cust_panggilan_create = cust_panggilanField.getValue();}
		if(cust_foreignerField.getValue()!== null){cust_foreigner_create = cust_foreignerField.getValue();}
		if(cust_kelaminField.getValue()!== null){cust_kelamin_create = cust_kelaminField.getValue();}
		if(cust_titleField.getValue()!== null){cust_title_create = cust_titleField.getValue();}
		if(cust_alamatField.getValue()!== null){cust_alamat_create = cust_alamatField.getValue();}
		if(cust_kotaField.getValue()!== null){cust_kota_create = cust_kotaField.getValue();}
		if(cust_kodeposField.getValue()!== null){cust_kodepos_create = cust_kodeposField.getValue();}
		if(cust_propinsiField.getValue()!== null){cust_propinsi_create = cust_propinsiField.getValue();}
		if(cust_negaraField.getValue()!== null){cust_negara_create = cust_negaraField.getValue();}
		if(cust_alamat2Field.getValue()!== null){cust_alamat2_create = cust_alamat2Field.getValue();}
		if(cust_kota2Field.getValue()!== null){cust_kota2_create = cust_kota2Field.getValue();}
		if(cust_kodepos2Field.getValue()!== null){cust_kodepos2_create = cust_kodepos2Field.getValue();}
		if(cust_propinsi2Field.getValue()!== null){cust_propinsi2_create = cust_propinsi2Field.getValue();}
		if(cust_negara2Field.getValue()!== null){cust_negara2_create = cust_negara2Field.getValue();}
		if(cust_telprumahField.getValue()!== null){cust_telprumah_create = cust_telprumahField.getValue();}
		if(cust_telprumah2Field.getValue()!== null){cust_telprumah2_create = cust_telprumah2Field.getValue();}
		if(cust_telpkantorField.getValue()!== null){cust_telpkantor_create = cust_telpkantorField.getValue();}
		if(cust_hpField.getValue()!== null){cust_hp_create = cust_hpField.getValue();}
		if(cust_hp2Field.getValue()!== null){cust_hp2_create = cust_hp2Field.getValue();}
		if(cust_hp3Field.getValue()!== null){cust_hp3_create = cust_hp3Field.getValue();}
		if(cust_bbField.getValue()!== null){cust_bb_create = cust_bbField.getValue();}
		if(cust_bbField.getValue()!== null){cust_bb_create = cust_bbField.getValue();}
		if(cust_emailField.getValue()!== null){cust_email_create = cust_emailField.getValue();}
		//if(cust_fbField.getValue()!== false){cust_fb_create = cust_fbField.getValue();}
		//if(cust_tweeterField.getValue()!== false){cust_tweeter_create = cust_tweeterField.getValue();}
		if(cust_email2Field.getValue()!== null){cust_email2_create = cust_email2Field.getValue();}
		//if(cust_fb2Field.getValue()!== false){cust_fb2_create = cust_fb2Field.getValue();}
		//if(cust_tweeter2Field.getValue()!== false){cust_tweeter2_create = cust_tweeter2Field.getValue();}
		if(cust_agamaField.getValue()!== null){cust_agama_create = cust_agamaField.getValue();}
		if(cust_pendidikanField.getValue()!== null){cust_pendidikan_create = cust_pendidikanField.getValue();}
		if(cust_profesiField.getValue()!== null){cust_profesi_create = cust_profesiField.getValue();}
		//if(cust_profesitxtField.getValue()!== null){cust_profesitxt_create = cust_profesitxtField.getValue();}
		if(cust_tmptlahirField.getValue()!== null){cust_tmptlahir_create = cust_tmptlahirField.getValue();}
		if(cust_tgllahirField.getValue()!== ""){cust_tgllahir_create_date = cust_tgllahirField.getValue().format('Y-m-d');}
		//if(cust_hobiField.getValue()!== null){cust_hobi_create = cust_hobiField.getValue();}
		//if(cust_hobitxtField.getValue()!== null){cust_hobitxt_create = cust_hobitxtField.getValue();}
		if(cust_referensiField.getValue()!== null){cust_referensi_create = cust_referensiField.getValue();}
		if(cust_referensilainField.getValue()!== null){cust_referensilain_create = cust_referensilainField.getValue();}
		//if(cust_referensilaintxtField.getValue()!== null){cust_referensilaintxt_create = cust_referensilaintxtField.getValue();}
		if(cust_keteranganField.getValue()!== null){cust_keterangan_create = cust_keteranganField.getValue();}
		if(cust_terdaftarField.getValue()!== ""){cust_terdaftar_create_date = cust_terdaftarField.getValue().format('Y-m-d');}
		if(cust_tglawaltransField.getValue()!== ""){cust_tglawaltrans_create_date = cust_tglawaltransField.getValue().format('Y-m-d');}
		if(cust_statusnikahField.getValue()!== null){cust_statusnikah_create = cust_statusnikahField.getValue();}
		if(cust_priorityField.getValue()!== null){cust_priority_create = cust_priorityField.getValue();}
		if(cust_jmlanakField.getValue()!== null){cust_jmlanak_create = cust_jmlanakField.getValue();}
		if(cust_unitField.getValue()!== null){cust_unit_create = cust_unitField.getValue();}
		if(cust_aktifField.getValue()!== null){cust_aktif_create = cust_aktifField.getValue();}
		if(cust_fretfulnessField.getValue()!== null){cust_fretfulness_create = cust_fretfulnessField.getValue();}
		if(cust_cpField.getValue()!== null){cust_cp_create = cust_cpField.getValue();}
		if(cust_cptelpField.getValue()!== null){cust_cptelp_create = cust_cptelpField.getValue();}

		Ext.MessageBox.show({
		   msg: 'Sedang menyimpan data, mohon tunggu...',
		   progressText: 'proses...',
		   width:350,
		   wait:true
		});	
			Ext.Ajax.request({  
//				waitMsg: 'Please wait...',
				waitMsg: 'Silahkan tunggu...',
				url: 'index.php?c=c_customer&m=get_action',
				params: {
					task: post2db,
					cust_id			: cust_id_create_pk,	
					cust_no			:cust_no_create,
					cust_nolama		:cust_nolama_create,
					cust_nama		:cust_nama_create,
					cust_panggilan	:cust_panggilan_create,	
					cust_foreigner	:cust_foreigner_create,	
					cust_kelamin	:cust_kelamin_create,
					cust_title		:cust_title_create,
					cust_alamat		:cust_alamat_create,		
					cust_kota		:cust_kota_create,		
					cust_kodepos	:cust_kodepos_create,		
					cust_propinsi	:cust_propinsi_create,		
					cust_negara		:cust_negara_create,		
					cust_alamat2	:cust_alamat2_create,		
					cust_kota2		:cust_kota2_create,		
					cust_kodepos2	:cust_kodepos2_create,		
					cust_propinsi2	:cust_propinsi2_create,		
					cust_negara2	:cust_negara2_create,		
					cust_telprumah	:cust_telprumah_create,		
					cust_telprumah2	:cust_telprumah2_create,		
					cust_telpkantor	:cust_telpkantor_create,		
					cust_hp			:cust_hp_create,		
					cust_hp2		:cust_hp2_create,		
					cust_hp3		:cust_hp3_create,
					cust_bb			:cust_bb_create,					
					cust_email		:cust_email_create,
					cust_fb			:cust_fbField.getValue(),
					cust_tweeter	:cust_tweeterField.getValue(),
					cust_email2		:cust_email2_create,
					cust_fb2		:cust_fb2Field.getValue(),
					cust_tweeter2	:cust_tweeter2Field.getValue(),
					cust_agama		:cust_agama_create,		
					cust_pendidikan	: cust_pendidikan_create,	
					cust_profesi	: cust_profesi_create,	
					//cust_profesitxt	: cust_profesitxt_create,	
					cust_tmptlahir	: cust_tmptlahir_create,
					cust_tgllahir	: cust_tgllahir_create_date,
					cust_hobi		: cust_hobi_create,	
					//cust_hobitxt	: cust_hobitxt_create,	
					cust_referensi	: cust_referensi_create,
					cust_referensilain	: cust_referensilain_create,
					cust_hobi_baca : cust_hobi_bacaField.getValue(),
					cust_hobi_olah : cust_hobi_olahField.getValue(),
					cust_hobi_masak : cust_hobi_masakField.getValue(),
					cust_hobi_travel : cust_hobi_travelField.getValue(),
					cust_hobi_foto : cust_hobi_fotoField.getValue(),
					cust_hobi_lukis : cust_hobi_lukisField.getValue(),
					cust_hobi_nari : cust_hobi_nariField.getValue(),
					cust_hobi_lain : cust_hobi_lainField.getValue(),
					//cust_referensilaintxt	: cust_referensilaintxt_create,
					cust_keterangan	: cust_keterangan_create,	
					cust_terdaftar	: cust_terdaftar_create_date,
					cust_tglawaltrans : cust_tglawaltrans_create_date,					
					cust_statusnikah	: cust_statusnikah_create,
					cust_priority	: cust_priority_create,
					cust_jmlanak	: cust_jmlanak_create,	
					cust_unit	: cust_unit_create,	
					cust_aktif	: cust_aktif_create,
					cust_fretfulness : cust_fretfulness_create,
					cust_cp	: cust_cp_create,
					cust_cptelp	: cust_cptelp_create
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							customer_DataStore.reload();
							customer_createWindow.hide();
							Ext.MessageBox.alert(post2db+' OK','Data customer berhasil disimpan');			
							break;
						case 2:						
						Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Tidak dapat di non-aktifkan, Customer masih memiliki sisa paket',
							   buttons: Ext.MessageBox.OK,
							   animEl: 'save',
							   icon: Ext.MessageBox.WARNING
						});
						break;
						default:
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Data customer tidak bisa disimpan',
							   buttons: Ext.MessageBox.OK,
							   animEl: 'save',
							   icon: Ext.MessageBox.WARNING
							});
						break;
					};
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
				msg: 'Form Anda belum lengkap',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
 	/* End of Function */
	
	function cust_note_confirm_delete(){
		if(cust_noteListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', cust_note_delete);
		} else if(cust_noteListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', cust_note_delete);
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
	
	//function for Delete of detail
	function cust_note_delete(btn){
		if(btn=='yes'){
			var s = cust_noteListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, r; r = s[i]; i++){
				cust_note_DataStore.remove(r);
			}
		} 
		cust_note_DataStore.commitChanges();
	}
	//eof
	
	function cust_note_add(){
		var edit_cust_note= new cust_noteListEditorGrid.store.recordType({
			note_id			:'',		
			note_cust		:'',		
			note_tanggal	:dt.format('Y-m-d'),		
			note_detail		:null	
		});
		editor_cust_note.stopEditing();
		cust_note_DataStore.insert(0, edit_cust_note);
		cust_noteListEditorGrid.getView().refresh();
		cust_noteListEditorGrid.getSelectionModel().selectRow(0);
		editor_cust_note.startEditing(0);
	}
	
	//function for insert detail
	function cust_note_insert(){
		for(i=0;i<cust_note_DataStore.getCount();i++){
			cust_note_record=cust_note_DataStore.getAt(i);
			Ext.Ajax.request({
				waitMsg: 'Silahkan tunggu...',
				url: 'index.php?c=c_customer&m=cust_note_insert',
				params:{
					note_id	: cust_note_record.data.note_id, 
					note_cust	: eval(customerListEditorGrid.getSelectionModel().getSelected().get('cust_id')), 
					note_detail	: cust_note_record.data.note_detail
				},
				timeout: 60000,
				success: function(response){							
					var result=eval(response.responseText);
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
	//eof
	
/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  	  
	/* Function for Retrieve DataStore */
	customer_DataStore = new Ext.data.Store({
		id: 'customer_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_customer&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST",start:0,limit:pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'cust_id'
		},[
			{name: 'cust_id', type: 'int', mapping: 'cust_id'},
			{name: 'cust_no', type: 'string', mapping: 'cust_no'},
			{name: 'cust_nolama', type: 'string', mapping: 'cust_nolama'},
			{name: 'cust_nama', type: 'string', mapping: 'cust_nama'},
			{name: 'cust_panggilan', type: 'string', mapping: 'cust_panggilan'},
			{name: 'cust_foreigner', type: 'string', mapping: 'cust_foreigner'},
			{name: 'cust_kelamin', type: 'string', mapping: 'cust_kelamin'},
			{name: 'cust_title', type: 'string', mapping: 'cust_title'},
			{name: 'cust_alamat', type: 'string', mapping: 'cust_alamat'},
			{name: 'cust_kota', type: 'string', mapping: 'cust_kota'},
			{name: 'cust_kodepos', type: 'string', mapping: 'cust_kodepos'},
			{name: 'cust_propinsi', type: 'string', mapping: 'cust_propinsi'},
			{name: 'cust_negara', type: 'string', mapping: 'cust_negara'},
			{name: 'cust_alamat2', type: 'string', mapping: 'cust_alamat2'},
			{name: 'cust_kota2', type: 'string', mapping: 'cust_kota2'},
			{name: 'cust_kodepos2', type: 'string', mapping: 'cust_kodepos2'},
			{name: 'cust_propinsi2', type: 'string', mapping: 'cust_propinsi2'},
			{name: 'cust_negara', type: 'string', mapping: 'cust_negara'},
			{name: 'cust_telprumah', type: 'string', mapping: 'cust_telprumah'},
			{name: 'cust_telprumah2', type: 'string', mapping: 'cust_telprumah2'},
			{name: 'cust_telpkantor', type: 'string', mapping: 'cust_telpkantor'},
			{name: 'cust_hp', type: 'string', mapping: 'cust_hp'},
			{name: 'cust_hp2', type: 'string', mapping: 'cust_hp2'},
			{name: 'cust_hp3', type: 'string', mapping: 'cust_hp3'},
			{name: 'cust_bb', type: 'string', mapping: 'cust_bb'},
			{name: 'cust_email', type: 'string', mapping: 'cust_email'},
			{name: 'cust_email2', type: 'string', mapping: 'cust_email2'},
			{name: 'cust_agama', type: 'string', mapping: 'cust_agama'},
			{name: 'cust_pendidikan', type: 'string', mapping: 'cust_pendidikan'},
			{name: 'cust_profesi', type: 'string', mapping: 'cust_profesi'},
			{name: 'cust_tmptlahir', type: 'string', mapping: 'cust_tmptlahir'},
			{name: 'cust_tgllahir', type: 'date', dateFormat: 'Y-m-d', mapping: 'cust_tgllahir'},
			{name: 'cust_hobi', type: 'string', mapping: 'cust_hobi'},
			{name: 'cust_nama_ref', type: 'string', mapping: 'cust_nama_ref'},
			{name: 'cust_referensilain', type: 'string', mapping: 'cust_referensilain'},
			{name: 'cust_keterangan', type: 'string', mapping: 'cust_keterangan'},
			//{name: 'cust_member', type: 'string', mapping: 'cust_member'},
			{name: 'member_no', type: 'string', mapping: 'member_no'},
			{name: 'member_valid', type: 'date', dateFormat: 'Y-m-d', mapping: 'member_valid'}, 
//			{name: 'cust_statusmember', type: 'string', mapping: 'cust_statusmember'},
			{name: 'cust_terdaftar', type: 'date', dateFormat: 'Y-m-d', mapping: 'cust_terdaftar'},
			{name: 'cust_tglawaltrans', type: 'date', dateFormat: 'Y-m-d', mapping: 'cust_tglawaltrans'},
			{name: 'cust_statusnikah', type: 'string', mapping: 'cust_statusnikah'},
			{name: 'cust_priority', type: 'string', mapping: 'cust_priority'},
			{name: 'cust_jmlanak', type: 'int', mapping: 'cust_jmlanak'},
			{name: 'cust_unit', type: 'string', mapping: 'cabang_nama'},
			{name: 'cust_aktif', type: 'string', mapping: 'cust_aktif'},
			{name: 'cust_fretfulness', type: 'string', mapping: 'cust_fretfulness'},
			//{name: 'crmvalue_date', type: 'date', dateFormat: 'Y-m-d', mapping: 'crmvalue_date'}, 
			//{name: 'crmvalue_total', type: 'string', mapping: 'crmvalue_total'},
			//{name: 'crmvalue_priority', type: 'string', mapping: 'crmvalue_priority'},
			{name: 'cust_creator', type: 'string', mapping: 'cust_creator'},
			{name: 'cust_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'cust_date_create'},
			{name: 'cust_update', type: 'string', mapping: 'cust_update'},
			{name: 'cust_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'cust_date_update'},
			{name: 'cust_revised', type: 'int', mapping: 'cust_revised'},
			{name: 'cust_cp', type: 'string', mapping: 'cust_cp'},
			{name: 'cust_cptelp', type: 'string', mapping: 'cust_cptelp'},
			{name: 'cust_fb', type: 'int', mapping: 'cust_fb'},
			{name: 'cust_tweeter', type: 'int', mapping: 'cust_tweeter'},
			{name: 'cust_fb2', type: 'int', mapping: 'cust_fb2'},
			{name: 'cust_tweeter2', type: 'int', mapping: 'cust_tweeter2'},
			{name: 'crmvalue_date', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'crmvalue_date'},
			{name: 'crmvalue_total', type: 'float', mapping: 'crmvalue_total'},
			{name: 'crmvalue_priority', type: 'string', mapping: 'crmvalue_priority'}
		]),
		//sortInfo:{field: 'cust_id', direction: "ASC"}
	});
	/* End of Function */
    
	cust_crm_generator_DataStore = new Ext.data.Store({
		id: 'cust_crm_generator_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_customer&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "CRMVAL", start:0, limit: pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: ''
		},[
		/* dataIndex => insert intohpp_ColumnModel, Mapping => for initiate table column */ 
			{name: 'crmvalue_id', type: 'int', mapping: 'crmvalue_id'},
			{name: 'crmvalue_date', type: 'date',dateFormat: 'Y-m-d H:i:s', mapping: 'crmvalue_date'},
			{name: 'crmvalue_cust_no', type: 'string', mapping: 'crmvalue_cust_no'},
			{name: 'crmvalue_cust', type: 'string', mapping: 'crmvalue_cust'},
			{name: 'crmvalue_frequency', type: 'float', mapping: 'crmvalue_frequency'},
			{name: 'crmvalue_recency', type: 'float', mapping: 'crmvalue_recency'},
			{name: 'crmvalue_spending', type: 'float', mapping: 'crmvalue_spending'},
			{name: 'crmvalue_highmargin', type: 'float', mapping: 'crmvalue_highmargin'},
			{name: 'crmvalue_referal', type: 'float', mapping: 'crmvalue_referal'},
			{name: 'crmvalue_kerewelan', type: 'float', mapping: 'crmvalue_kerewelan'},
			{name: 'crmvalue_disiplin_batal', type: 'float', mapping: 'crmvalue_disiplin_batal'},
			{name: 'crmvalue_disiplin_telat', type: 'float', mapping: 'crmvalue_disiplin_telat'},
			{name: 'crmvalue_treatment', type: 'float', mapping: 'crmvalue_treatment'},
			{name: 'crmvalue_frequency_real', type: 'int', mapping: 'crmvalue_frequency_real'},
			{name: 'crmvalue_recency_real', type: 'float', mapping: 'crmvalue_recency_real'},
			{name: 'crmvalue_spending_real_rp', type: 'float', mapping: 'crmvalue_spending_real_rp'},
			{name: 'crmvalue_spending_real_kunj', type: 'float', mapping: 'crmvalue_spending_real_kunj'},
			{name: 'crmvalue_highmargin_real', type: 'float', mapping: 'crmvalue_highmargin_real'},
			{name: 'crmvalue_referal_real', type: 'float', mapping: 'crmvalue_referal_real'},
			{name: 'crmvalue_kerewelan_real', type: 'string', mapping: 'crmvalue_kerewelan_real'},
			{name: 'crmvalue_disiplin_batal_real', type: 'float', mapping: 'crmvalue_disiplin_batal_real'},
			{name: 'crmvalue_disiplin_telat_real', type: 'float', mapping: 'crmvalue_disiplin_telat_real'},
			{name: 'crmvalue_treatment', type: 'float', mapping: 'crmvalue_treatment'},
			{name: 'crmvalue_total', type: 'float', mapping: 'crmvalue_total'},
			{name: 'crmvalue_priority', type: 'string', mapping: 'crmvalue_priority'}
		]),
		sortInfo:{field: 'crmvalue_id', direction: "ASC"}
	});
	/* End of Function */
	
	cust_crm_generator_DataStore2 = new Ext.data.Store({
		id: 'cust_crm_generator_DataStore2',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_customer&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "CRMVAL2", start:0, limit: pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: ''
		},[
		/* dataIndex => insert intohpp_ColumnModel, Mapping => for initiate table column */ 
			{name: 'crmvalue_id', type: 'int', mapping: 'crmvalue_id'},
			{name: 'crmvalue_date', type: 'date',dateFormat: 'Y-m-d H:i:s', mapping: 'crmvalue_date'},
			{name: 'crmvalue_cust_no', type: 'string', mapping: 'crmvalue_cust_no'},
			{name: 'crmvalue_cust', type: 'string', mapping: 'crmvalue_cust'},
			{name: 'crmvalue_frequency', type: 'float', mapping: 'crmvalue_frequency'},
			{name: 'crmvalue_recency', type: 'float', mapping: 'crmvalue_recency'},
			{name: 'crmvalue_spending', type: 'float', mapping: 'crmvalue_spending'},
			{name: 'crmvalue_highmargin', type: 'float', mapping: 'crmvalue_highmargin'},
			{name: 'crmvalue_referal', type: 'float', mapping: 'crmvalue_referal'},
			{name: 'crmvalue_kerewelan', type: 'float', mapping: 'crmvalue_kerewelan'},
			{name: 'crmvalue_disiplin_batal', type: 'float', mapping: 'crmvalue_disiplin_batal'},
			{name: 'crmvalue_disiplin_telat', type: 'float', mapping: 'crmvalue_disiplin_telat'},
			{name: 'crmvalue_treatment', type: 'float', mapping: 'crmvalue_treatment'},
			{name: 'crmvalue_frequency_real', type: 'int', mapping: 'crmvalue_frequency_real'},
			{name: 'crmvalue_recency_real', type: 'float', mapping: 'crmvalue_recency_real'},
			{name: 'crmvalue_spending_real_rp', type: 'float', mapping: 'crmvalue_spending_real_rp'},
			{name: 'crmvalue_spending_real_kunj', type: 'float', mapping: 'crmvalue_spending_real_kunj'},
			{name: 'crmvalue_highmargin_real', type: 'float', mapping: 'crmvalue_highmargin_real'},
			{name: 'crmvalue_referal_real', type: 'float', mapping: 'crmvalue_referal_real'},
			{name: 'crmvalue_kerewelan_real', type: 'string', mapping: 'crmvalue_kerewelan_real'},
			{name: 'crmvalue_disiplin_batal_real', type: 'float', mapping: 'crmvalue_disiplin_batal_real'},
			{name: 'crmvalue_disiplin_telat_real', type: 'float', mapping: 'crmvalue_disiplin_telat_real'},
			{name: 'crmvalue_treatment', type: 'float', mapping: 'crmvalue_treatment'},
			{name: 'crmvalue_total', type: 'float', mapping: 'crmvalue_total'},
			{name: 'crmvalue_priority', type: 'string', mapping: 'crmvalue_priority'}
		]),
		sortInfo:{field: 'crmvalue_id', direction: "ASC"}
	});
	/* End of Function */
	
	//datastore of profesi
	/*
	cbo_cust_profesi_DataStore = new Ext.data.Store({
		id: 'cbo_cust_profesi_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_customer&m=get_profesi_list', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'cust_profesi'
		},[
			{name: 'cust_profesi_display', type: 'string', mapping: 'cust_profesi'}
		]),
		sortInfo:{field: 'cust_profesi_display', direction: "ASC"}
	});
	*/
	/* eof */
	
	//datastore of hobi
	/*
	cbo_cust_hobi_DataStore = new Ext.data.Store({
		id: 'cbo_cust_hobi_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_customer&m=get_hobi_list', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'cust_hobi'
		},[
			{name: 'cust_hobi_display', type: 'string', mapping: 'cust_hobi'}
		]),
		sortInfo:{field: 'cust_hobi_display', direction: "ASC"}
	});
	*/
	/* eof */
	
	//datastore of hobi
	cust_member_DataStore = new Ext.data.Store({
		id: 'cust_member_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_customer&m=get_cust_member', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'member_id'
		},[
			{name: 'member_id', type: 'int', mapping: 'member_id'},
			{name: 'member_cust', type: 'int', mapping: 'member_cust'},
			{name: 'member_no', type: 'string', mapping: 'member_no'},
			{name: 'member_register', type: 'string', mapping: 'member_register'},
			{name: 'member_valid', type: 'string', mapping: 'member_valid'},
			{name: 'member_jenis', type: 'string', mapping: 'member_jenis'},
			{name: 'member_nota_ref', type: 'string', mapping: 'member_nota_ref'},
			{name: 'member_point', type: 'int', mapping: 'member_point'},
			{name: 'member_status', type: 'string', mapping: 'member_status'},
			{name: 'member_tglserahterima', type: 'date', format: 'Y-m-d', mapping: 'member_tglserahterima'},
			{name: 'member_aktif', type: 'string', mapping: 'member_aktif'}
		]),
		sortInfo:{field: 'member_id', direction: "DESC"}
	});
	
	//datastore of Nota
	cust_note_DataStore = new Ext.data.Store({
		id: 'cust_note_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_customer&m=get_cust_note', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'note_id'
		},[
		/* dataIndex => insert intocustomer_ColumnModel, Mapping => for initiate table column */ 
			{name: 'note_id', type: 'int', mapping: 'note_id'},
			{name: 'note_customer', type: 'int', mapping: 'note_customer'},
			{name: 'note_tanggal', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'note_tanggal'},
			{name: 'note_detail', type: 'string', mapping: 'note_detail'}
		]),
		sortInfo:{field: 'note_id', direction: "DESC"}
	});
	
	//datastore of Cabang
	cbo_cust_cabang_DataStore = new Ext.data.Store({
		id: 'cbo_cust_cabang_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_customer&m=get_cabang_list', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'cabang_id'
		},[
		/* dataIndex => insert intocustomer_ColumnModel, Mapping => for initiate table column */ 
			{name: 'cust_cabang_value', type: 'int', mapping: 'cabang_id'},
			{name: 'cust_cabang_display', type: 'string', mapping: 'cabang_nama'}
		]),
		sortInfo:{field: 'cust_cabang_display', direction: "ASC"}
	});
	/* eof */
	
  	/* Function for Identify of Window Column Model */
	customer_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'cust_id',
			width: 80,	//40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},
		/*{
//			header: 'No Customer (Lama)',
			header: 'No. Cust (Lama)',
			dataIndex: 'cust_nolama',
			width: 80,	//110,
			sortable: true,
			hidden: true,
			editor: new Ext.form.TextField({
				maxLength: 50
          	})
		},*/
		{
//			header: 'No Customer',
			header: '<div align="center">' + 'No Cust' + '</div>',
			dataIndex: 'cust_no',
			width: 50,	//90,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_CUSTOMER'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 50
          	})
			<?php } ?>
		},
		{
			header: '<div align="center">' + 'Title' + '</div>',
			dataIndex: 'cust_title',
			width: 30,
			hidden : false,
			sortable: true
		},
		{
			header: '<div align="center">' + 'Nama Lengkap' + '</div>',
			dataIndex: 'cust_nama',
			width: 160,	//167,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_CUSTOMER'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 50
          	})
			<?php } ?>
		},
		/*
		{
			header: '<div align="center">' + 'No Member' + '</div>',
			dataIndex: 'member_no',
			width: 90,	//150,
			sortable: true,
			readOnly: true
		},
		*/
		/*
		{
			header: '<div align="center">Tgl Valid</div>',
			dataIndex: 'member_valid',
			width: 70,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			readOnly: true
		}, 
		*/
		/*
		{
			header: '<div align="center">' + 'L/P' + '</div>',
			dataIndex: 'cust_kelamin',
			width: 20,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_CUSTOMER'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['cust_kelamin_value', 'cust_kelamin_display'],
					data: [['L','Laki-laki'],['P','Perempuan']]
					}),
				mode: 'local',
               	displayField: 'cust_kelamin_display',
               	valueField: 'cust_kelamin_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
			<?php } ?>
		},
		*/
		{
			header: '<div align="center">' + 'Alamat' + '</div>',
			dataIndex: 'cust_alamat',
			width: 160,	//127,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_CUSTOMER'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
			<?php } ?>
		},
		{
			header: '<div align="center">' + 'Kota' + '</div>',
			dataIndex: 'cust_kota',
			width: 60,	//97,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_CUSTOMER'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 100
          	})
			<?php } ?>
		},
		{
			header: '<div align="center">' + 'Telp Rumah' + '</div>',
			dataIndex: 'cust_telprumah',
			width: 55,	//97,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_CUSTOMER'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 30,
				maskRe: /([0-9]+)$/
          	})
			<?php } ?>
		},
		{
			header: '<div align="center">' + 'HP' + '</div>',
			dataIndex: 'cust_hp',
			width: 65,	//97,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_CUSTOMER'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 25,
				maskRe: /([0-9]+)$/
          	})
			<?php } ?>
		},
		{
			header: '<div align="center">' + 'Tgl Lahir' + '</div>',
			dataIndex: 'cust_tgllahir',
			width: 60,	//67,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y')
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_CUSTOMER'))){ ?>
			,
			editor: new Ext.form.DateField({
				format: 'Y-m-d'
			})
			<?php } ?>
		},
		{
			header: '<div align="center">' + 'Stat Nikah' + '</div>',
			dataIndex: 'cust_statusnikah',
			width: 60,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_CUSTOMER'))){ ?>
			,
			hidden: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['cust_statusnikah_value', 'cust_statusnikah_display'],
					data: [['menikah','menikah'],['belum menikah','belum menikah']]
					}),
				mode: 'local',
               	displayField: 'cust_statusnikah_display',
               	valueField: 'cust_statusnikah_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
			<?php } ?>
		},
		{
			header: '<div align="center">' + 'Status' + '</div>',
			dataIndex: 'cust_aktif',
			width: 45,	//150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_CUSTOMER'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['cust_aktif_value', 'cust_aktif_display'],
					data: [['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
					}),
				mode: 'local',
               	displayField: 'cust_aktif_display',
               	valueField: 'cust_aktif_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
			<?php } ?>
		},
		{
			header: '<div align="center">' + 'Keterangan' + '</div>',
			dataIndex: 'cust_keterangan',
			width: 160,	//150,
			sortable: true,
			hidden: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_CUSTOMER'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 500
          	})
			<?php } ?>
			
		},
		{
			header: 'Creator',
			dataIndex: 'cust_creator',
			width: 150,
			sortable: true,
			hidden: true
		},
		{
			header: 'Create on',
			dataIndex: 'cust_date_create',
			width: 150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			hidden: true
		},
		{
			header: 'Last Update by',
			dataIndex: 'cust_update',
			width: 150,
			sortable: true,
			hidden: true
		},
		{
			header: 'Last Update on',
			dataIndex: 'cust_date_update',
			width: 97,
			sortable: true,
			hidden: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d')
		},
		{
			header: 'Revised',
			dataIndex: 'cust_revised',
			width: 150,
			sortable: true,
			hidden: true
		}]
	);
	customer_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Function for Identify of Window Column Model */
	cust_member_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'member_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},
		{
			header: 'No Member',
			dataIndex: 'member_no',
			width: 150,
			sortable: true,
			reaOnly: true
		},
		{
			header: 'Tgl. Register',
			dataIndex: 'member_register',
			width: 150,
			sortable: true,
			reaOnly: true
		},
		{
			header: 'Tgl. valid',
			dataIndex: 'member_valid',
			width: 150,
			sortable: true,
			reaOnly: true
		},
		{
			header: 'No Ref. Nota',
			dataIndex: 'member_nota_ref',
			width: 150,
			sortable: true,
			reaOnly: true
		},
		{
			header: 'Poin',
			dataIndex: 'member_point',
			width: 70,
			sortable: true,
			reaOnly: true
		},
		{
			header: 'Jenis',
			dataIndex: 'member_jenis',
			width: 150,
			sortable: true,
			reaOnly: true
		},
		{
			header: 'Status',
			dataIndex: 'member_status',
			width: 150,
			sortable: true,
			reaOnly: true
		},
		{
			header: 'Tgl Serah Terima',
			dataIndex: 'member_tglserahterima',
			width: 150,
			sortable: true,
			reaOnly: true
		},
		{
			header: 'Aktif',
			dataIndex: 'member_aktif',
			width: 70,
			sortable: true,
			reaOnly: true
		}
		]
	);
	cust_member_ColumnModel.defaultSortable= true;
	
	/* Function for Identify of Window Column Model */
	cust_note_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'note_id',
			width: 20,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},
		{
			header: '<div align="center">' + 'Tanggal dan Jam' + '</div>',
			dataIndex: 'note_tanggal',
			sortable: true,
			width: 40,
			renderer: Ext.util.Format.dateRenderer('d-m-Y H:i:s'),
			readOnly: true
		},
		{
			header: '<div align="center">' + 'Catatan' + '</div>',
			dataIndex: 'note_detail',
			width: 250,
			sortable: true,
			readonly: true
		}		
		]
	);
	cust_note_ColumnModel.defaultSortable= true;
	
	/* Declare DataStore and  show datagrid list */
	customerListEditorGrid =  new Ext.grid.GridPanel({
		id: 'customerListEditorGrid',
		el: 'fp_customer',
		title: 'Daftar Customer',
		autoHeight: true,
		store: customer_DataStore, // DataStore
		cm: customer_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		//clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1235, //940,
	  	//autoWidth: true,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: customer_DataStore,
			displayInfo: true
		}),
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_CUSTOMER'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<?php } ?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_CUSTOMER'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: customer_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_CUSTOMER'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: customer_confirm_delete   // Confirm before deleting
		}, '-', 
		<?php } ?>
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: customer_DataStore,
			params: {task: 'LIST',start: 0, limit: pageS},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						customer_DataStore.baseParams={task:'LIST',start: 0, limit: pageS};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Simple search:'});
				Ext.get(this.id).set({qtip:'- (Aktif only)<br>- No Cust<br>- Nama Customer<br>- No Telp dan HP<br>- No Member'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: customer_reset_search,
			iconCls:'icon-refresh'
		},'-',
		 <?php if(eregi('P',$this->m_security->get_access_group_by_kode('MENU_CUSTOMER'))){ ?>
		{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: customer_export_excel
		}, '-',
		{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: customer_print  
		}, '-'
		<?php } ?>
		/*
		{
			text: 'Cetak Label',
			tooltip: 'Menu untuk cetak label',
			iconCls:'',
			//handler: tindakan_nonmedis_print  
			handler: customer_print_label
		}, '-',
		*/
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_CUSTOMER'))){ ?>
		/*
		{
			text: 'Generate CRM Value',
			//tooltip: 'Edit selected record',
			//iconCls:'icon-update',
			handler: customer_confirm_crm2
		}, '-',
		*/
		<?php } ?>
		/*
		{
			text: 'Add to Phonegroup',
			iconCls:'',
			//handler: tindakan_nonmedis_print  
			handler: display_customer_phonegroup
		}
		*/
		]
	});
	customerListEditorGrid.render();
	/* End of DataStore */
    
	editor_cust_note= new Ext.ux.grid.RowEditor({
        saveText: 'Update',
		listeners: {
			afteredit: function(){
				cust_note_DataStore.commitChanges();
			}
		}
    });
	
	cust_memberListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'cust_memberListEditorGrid',
		el: 'fp_cust_member',
		title: 'History Of Member',
		height: 400,
		store: cust_member_DataStore, // DataStore
		cm: cust_member_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 900
	});
	
	cust_noteListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'cust_noteListEditorGrid',
		el: 'fp_cust_note',
		title: 'Catatan Customer',
		height: 400,
		store: cust_note_DataStore, // DataStore
		cm: cust_note_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		plugins: [editor_cust_note],
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 900
	});
	
	//cust_memberListEditorGrid.render();
	
	/* Create Context Menu */
	customer_ContextMenu = new Ext.menu.Menu({
		id: 'customer_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_CUSTOMER'))){ ?>
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: customer_confirm_update 
		},
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_CUSTOMER'))){ ?>
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			handler: customer_confirm_delete 
		},
		<?php } ?>
		{ 
			text: 'Generate CRM Value (single data)',
			//iconCls:'icon-update',
			handler:customer_confirm_crm
		},
		<?php if(eregi('P',$this->m_security->get_access_group_by_kode('MENU_CUSTOMER'))){ ?>
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			disabled: true,
			handler: customer_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			disabled: true,
			handler: customer_export_excel 
		}
		<?php } ?>
		]
	}); 
	/* End of Declaration */
	
	customerListEditorGrid.addListener('rowcontextmenu', oncustomer_ListEditGridContextMenu);
	customer_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	customerListEditorGrid.on('afteredit', customer_update); // inLine Editing Record
	
	var cbo_propinsi_DataStore = new Ext.data.Store({
		id: 'cbo_propinsi_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_customer&m=get_propinsi_list', 
			method: 'POST'
		}),
		baseParams:{start: 0, limit: 10 }, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'propinsi_nama'
		},[
			{name: 'propinsi_nama', type: 'string', mapping: 'propinsi_nama'},
		]),
		sortInfo:{field: 'propinsi_nama', direction: "ASC"}
	});
	
	var cbo_cust_ref_DataStore = new Ext.data.Store({
		id: 'cbo_cust_ref_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_customer&m=customer_list', 
			method: 'POST'
		}),
		baseParams:{start: 0, limit: 10 }, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'cust_id'
		},[
			{name: 'cust_id', type: 'int', mapping: 'cust_id'},
			{name: 'cust_no', type: 'string', mapping: 'cust_no'},
			{name: 'cust_nolama', type: 'string', mapping: 'cust_nolama'},
			{name: 'cust_nama', type: 'string', mapping: 'cust_nama'},
			{name: 'cust_tgllahir', type: 'date', dateFormat: 'Y-m-d', mapping: 'cust_tgllahir'},
			{name: 'cust_alamat', type: 'string', mapping: 'cust_alamat'},
			{name: 'cust_telprumah', type: 'string', mapping: 'cust_telprumah'}
		]),
		sortInfo:{field: 'cust_no', direction: "ASC"}
	});
	
	var cbo_reflain_DataStore = new Ext.data.Store({
		id: 'cbo_reflain_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_customer&m=get_reflain_list', 
			method: 'POST'
		}),
		baseParams:{start: 0, limit: 10 }, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'cust_referensilain'
		},[
			{name: 'cust_referensilain', type: 'string', mapping: 'cust_referensilain'},
		]),
		sortInfo:{field: 'cust_referensilain', direction: "ASC"}
	});
	
	var customer_ref_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{cust_no} : {cust_nama}</b> | Tgl-Lahir:{cust_tgllahir:date("M j, Y")}<br /></span>',
            'Alamat: {cust_alamat}&nbsp;&nbsp;&nbsp;[Telp. {cust_telprumah}]',
        '</div></tpl>'
    );
	
	/* Identify  cust_no Field */
	cust_noField= new Ext.form.TextField({
		id: 'cust_noField',
		fieldLabel: 'No Cust',
		maxLength: 50,
		readOnly : true,
		emptyText : '(Auto)',
		allowBlank: true,
		anchor: '50%'
	});
	
	/*cust_nolamaField= new Ext.form.TextField({
		id: 'cust_nolamaField',
		fieldLabel: 'No Customer (Lama)',
		maxLength: 50,
		anchor: '50%'
	});*/
	/* Identify  cust_nama Field */
	cust_namaField= new Ext.form.TextField({
		id: 'cust_namaField',
		fieldLabel: 'Nama Lengkap <span style="color: #ec0000">*</span>',
		maxLength: 50,
		allowBlank: false,
		anchor: '95%'
	});
	
	/* Identify  cust_panggilan Field */
	cust_panggilanField= new Ext.form.TextField({
		id: 'cust_panggilanField',
		fieldLabel: 'Nama Panggilan',
		maxLength: 50,
		anchor: '95%'
	});
	
	/* Identify  cust_foreigner Field */
	cust_foreignerField=new Ext.form.Checkbox({
		id : 'cust_foreignerField',
		fieldLabel: 'Warga Asing',
		maxLength: 250,
		name: 'cust_foreigner'
	});
	
	/* Identify  cust_title Field */
	cust_titleField= new Ext.form.ComboBox({
		id: 'cust_titleField',
		fieldLabel: 'Title',
		maxLength: 50,
		store:new Ext.data.SimpleStore({
			fields:['cust_title_value_display'],
			data: [['MR.'],['MRS.'],['MS.']]
		}),
		mode: 'local',
		editable: false,
		displayField: 'cust_title_value_display',
		valueField: 'cust_title_value_display',
		anchor: '50%',
		//allowBlank: false,
		triggerAction: 'all'	
	});
	
	/* Identify  cust_kelamin Field */
	cust_kelaminField= new Ext.form.ComboBox({
		id: 'cust_kelaminField',
		fieldLabel: 'Jenis Kelamin',
		store:new Ext.data.SimpleStore({
			fields:['cust_kelamin_value', 'cust_kelamin_display'],
			data:[['L','Laki-laki'],['P','Perempuan']]
		}),
		mode: 'local',
		editable: false,
		// allowBlank : false,
		displayField: 'cust_kelamin_display',
		valueField: 'cust_kelamin_value',
		//allowBlank: false,
		anchor: '50%',
		triggerAction: 'all'	
	});
	/* Identify  cust_alamat Field */
	cust_alamatField= new Ext.form.TextField({
		id: 'cust_alamatField',
		fieldLabel: 'Alamat',
		maxLength: 250,
		//allowBlank: false,
		anchor: '95%'
	});
	
	/* Identify  cust_kota Field */
	cust_kotaField= new Ext.form.TextField({
		id: 'cust_kotaField',
		fieldLabel: 'Kota',
		maxLength: 100,
		//emptyText: 'Surabaya',
		//allowBlank: true,
		anchor: '95%'
	});
	/* Identify  cust_kodepos Field */
	cust_kodeposField= new Ext.form.TextField({
		id: 'cust_kodeposField',
		fieldLabel: 'Kode Pos',
		maxLength: 5,
		anchor: '50%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  cust_propinsi Field */
	cust_propinsiField= new Ext.form.ComboBox({
		id: 'cust_propinsiField',
		fieldLabel: 'Propinsi',
		//blankText: 'Jawa Timur',
		//emptyText: 'Jawa Timur',
		maxLength: 100,
		store: cbo_propinsi_DataStore,
		mode: 'remote',
		editable: false,
		displayField: 'propinsi_nama',
		valueField: 'propinsi_nama',
		anchor: '95%',
		triggerAction: 'all'
	});
	/* Identify  cust_negara Field */
	cust_negaraField= new Ext.form.TextField({
		id: 'cust_negaraField',
		fieldLabel: 'Negara',
		//blankText: 'Indonesia',
		//emptyText: 'Indonesia',
		maxLength: 100,
		anchor: '95%'
	});
	
	/* Identify  cust_alamat2 Field */
	cust_alamat2Field= new Ext.form.TextField({
		id: 'cust_alamat2Field',
		fieldLabel: 'Alamat',
		maxLength: 150,
		anchor: '95%'
	});
	
	/* Identify  cust_kota Field */
	cust_kota2Field= new Ext.form.TextField({
		id: 'cust_kota2Field',
		fieldLabel: 'Kota',
		maxLength: 100,
		anchor: '95%'
	});
	/* Identify  cust_kodepos Field */
	cust_kodepos2Field= new Ext.form.TextField({
		id: 'cust_kodepos2Field',
		fieldLabel: 'Kode Pos',
		maxLength: 5,
		anchor: '50%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  cust_propinsi Field */
	cust_propinsi2Field= new Ext.form.ComboBox({
		id: 'cust_propinsi2Field',
		fieldLabel: 'Propinsi',
		//blankText: 'Jawa Timur',
		emptyText: 'Pilihan...',
		maxLength: 100,
		store: cbo_propinsi_DataStore,
		mode: 'remote',
		editable: false,
		displayField: 'propinsi_nama',
		valueField: 'propinsi_nama',
		anchor: '95%',
		triggerAction: 'all'
	});
	/* Identify  cust_negara Field */
	cust_negara2Field= new Ext.form.TextField({
		id: 'cust_negara2Field',
		fieldLabel: 'Negara',
		//blankText: 'Indonesia',
		emptyText: 'Isi nama negara...',
		maxLength: 100,
		anchor: '95%'
	});
	
	/* Identify  cust_telprumah Field */
	cust_telprumahField= new Ext.form.TextField({
		id: 'cust_telprumahField',
		fieldLabel: 'Telp Rumah',
		maxLength: 30,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  cust_telprumah2 Field */
	cust_telprumah2Field= new Ext.form.TextField({
		id: 'cust_telprumah2Field',
		//fieldLabel: 'Telp. Rumah 2',
		hideLabel:true,
		maxLength: 30,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  cust_telpkantor Field */
	cust_telpkantorField= new Ext.form.TextField({
		id: 'cust_telpkantorField',
		//fieldLabel: 'Telp. Kantor',
		hideLabel:true,
		maxLength: 100,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  cust_hp Field */
	cust_hpField= new Ext.form.TextField({
		id: 'cust_hpField',
		fieldLabel: 'HP',
		maxLength: 25,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  cust_hp2 Field */
	cust_hp2Field= new Ext.form.TextField({
		id: 'cust_hp2Field',
		//fieldLabel: 'No. Ponsel 2',
		hideLabel:true,
		maxLength: 25,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  cust_hp3 Field */
	cust_hp3Field= new Ext.form.TextField({
		id: 'cust_hp3Field',
		//fieldLabel: 'No. Ponsel 3',
		hideLabel:true,
		maxLength: 25,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	/* Identify  pin bb Field */
	cust_bbField= new Ext.form.TextField({
		id: 'cust_bbField',
		fieldLabel: 'Pin BB',
		maxLength: 30,
		anchor: '95%'
	});
	
	/* Identify  cust_email Field */
	cust_emailField= new Ext.form.TextField({
		id: 'cust_emailField',
		fieldLabel: 'Email',
		maxLength: 100,
		vtype: 'email',
		anchor: '95%'
	});
	
	/* Identify  cust_email Field */
	cust_email2Field= new Ext.form.TextField({
		id: 'cust_email2Field',
		fieldLabel: 'Email Alternatif',
		maxLength: 100,
		vtype: 'email',
		anchor: '95%'
	});
	
	/* Identify  cust_agama Field */
	cust_agamaField= new Ext.form.ComboBox({
		id: 'cust_agamaField',
		fieldLabel: 'Agama',
		maxLength: 50,
		store:new Ext.data.SimpleStore({
			fields:['cust_agama_value_display'],
			data: [['Islam'],['Katholik'],['Kristen'],['Hindu'],['Budha'],['Konghucu'],['Lainnya']]
		}),
		mode: 'local',
		editable: false,
		displayField: 'cust_agama_value_display',
		valueField: 'cust_agama_value_display',
		anchor: '50%',
		//allowBlank: false,
		triggerAction: 'all'	
	});
	/* Identify  cust_pendidikan Field */
	cust_pendidikanField= new Ext.form.ComboBox({
		id: 'cust_pendidikanField',
		fieldLabel: 'Pendidikan',
		maxLength: 50,
		store:new Ext.data.SimpleStore({
			fields:['cust_pendidikan_value_display'],
			data: [['SMA'],['Diploma/Akademi'],['Sarjana (S1)'],['Pasca Sarjana (S2)'],['Doktoral (S3)'],['Lainnya']]
		}),
		mode: 'local',
		editable: false,
		//allowBlank: false,
		displayField: 'cust_pendidikan_value_display',
		valueField: 'cust_pendidikan_value_display',
		anchor: '50%',
		triggerAction: 'all'
	});
	/* Identify  cust_profesi Field */
	cust_profesiField= new Ext.form.ComboBox({
		id: 'cust_profesiField',
		fieldLabel: 'Profesi',
		maxLength: 100,
		//store: cbo_cust_profesi_DataStore,
		store:new Ext.data.SimpleStore({
			fields:['cust_profesi_display'],
			data: [['Pelajar / Mahasiswa'],['Ibu Rumah Tangga'],['Karyawan / Swasta'],['Wiraswasta'],['Profesional'],['Selebritis'],['Lain-lain']]
		}),
		mode: 'local',
		displayField: 'cust_profesi_display',
		valueField: 'cust_profesi_display',
		anchor: '95%',
		triggerAction: 'all'
	});
	/* Identify  cust_profesi Field */
	cust_profesitxtField= new Ext.form.TextField({
		id: 'cust_profesitxtField',
		fieldLabel: '&nbsp;&nbsp;&nbsp;Tambah (Optional)',
		emptyText: 'Profesi lainnya...',
		maxLength: 100,
		anchor: '95%'
	});
	
	/* Identify  cust_tgllahir Field */
	cust_tmptlahirField= new Ext.form.TextField({
		id: 'cust_tmptlahirField',
		fieldLabel: 'Tempat Lahir',
		maxLength: 100,
		anchor: '95%'
	});
	//Label utk keterangan info mengenai inputan Tanggal Lahir
	cust_tgllahir_infoLabel=new Ext.form.Label({
		html: "<font size=1>*Jika customer tidak ingin diketahui tahun lahirnya, inputkan tahun dengan format '0000', contoh penginputan : '22-05-0000', ini artinya customer berultah tanggal 22 Mei"
	});
	
	cust_tgllahirField= new Ext.form.DateField({
		id: 'cust_tgllahirField',
		fieldLabel: 'Tgl Lahir',
		format : 'd-m-Y',
		anchor: '50%',
		//allowBlank: false,
		enableKeyEvents: true,
		listeners:{
			keyup: function(){
				var datDate1=cust_tgllahirField.getValue();
				var getBlnLahir=datDate1.getMonth()+1;
				var getSelisihBln=(dt.getMonth()+1)-getBlnLahir;
				var getUmur=(dt.getFullYear())-(datDate1.getFullYear());				
				var tempBln=0;
			
				if((getBlnLahir) < (dt.getMonth()+1)){
					getUmur=getUmur+1;
				}
				var umur=getUmur+" Th"
				//+getSelisihBln+" Bln";
				
				cust_umurField.setValue(umur);
			}
		}
	});
	cust_umurField= new Ext.form.TextField({
		id: 'cust_umurField',
		fieldLabel: '&nbsp;&nbsp;&nbsp;Umur',
		disabled:true,
		width:107
	});
	cust_tgllahirField.on('select',function(){
		var datDate1=cust_tgllahirField.getValue();
		var getBlnLahir=datDate1.getMonth()+1;
		var getSelisihBln=(dt.getMonth()+1)-getBlnLahir;
		var getUmur=(dt.getFullYear())-(datDate1.getFullYear());
		var tempBln=0;
		
		if((getBlnLahir) < (dt.getMonth()+1)){
			getUmur=getUmur+1;
		}
		var umur=getUmur+" Th"
		//+getSelisihBln+" Bln";
		
		cust_umurField.setValue(umur);
	});
	tgl_lahir_group = new Ext.form.FieldSet({
		title: '',
		labelWidth: 100,
		anchor: '95%',
		layout:'column',
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [cust_tgllahirField, cust_umurField]
			},
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [cust_tgllahir_infoLabel]
			}
		]
	});
	/* Identify  cust_hobi Field 
	cust_hobiField= new Ext.form.ComboBox({
		id: 'cust_hobiField',
		fieldLabel: 'Hobi',
		maxLength: 500,
		//store: cbo_cust_hobi_DataStore,
		store:new Ext.data.SimpleStore({
			fields:['cust_hobi_display'],
			data: [['Membaca'],['Olahraga'],['Memasak'],['Travelling'],['Fotografi'],['Melukis'],['Menari'],['Lain-lain']]
		}),	
		mode: 'local',
		displayField: 'cust_hobi_display',
		valueField: 'cust_hobi_display',
		anchor: '95%',
		triggerAction: 'all'
	});*/
		
		/* Identify hobi*/
	cust_hobi_bacaField=new Ext.form.Checkbox({
		id : 'cust_hobi_bacaField',
		boxLabel: 'Membaca',
		maxLength: 250,
		name: 'cust_hobi_baca'
	});
	
	cust_hobi_olahField=new Ext.form.Checkbox({
		id : 'cust_hobi_olahField',
		boxLabel: 'Olahraga',
		maxLength: 250,
		name: 'cust_hobi_olah'
	});
	
	cust_hobi_masakField=new Ext.form.Checkbox({
		id : 'cust_hobi_masakField',
		boxLabel: 'Memasak',
		maxLength: 250,
		name: 'cust_hobi_masak'
	});
	
	cust_hobi_travelField=new Ext.form.Checkbox({
		id : 'cust_hobi_travelField',
		boxLabel: 'Travelling',
		maxLength: 250,
		name: 'cust_hobi_travel'
	});
	
	cust_hobi_fotoField=new Ext.form.Checkbox({
		id : 'cust_hobi_fotoField',
		boxLabel: 'Fotografi',
		maxLength: 250,
		name: 'cust_hobi_foto'
	});
	
	cust_hobi_lukisField=new Ext.form.Checkbox({
		id : 'cust_hobi_lukisField',
		boxLabel: 'Melukis',
		maxLength: 250,
		name: 'cust_hobi_lukis'
	});
	
	cust_hobi_nariField=new Ext.form.Checkbox({
		id : 'cust_hobi_nariField',
		boxLabel: 'Menari',
		maxLength: 250,
		name: 'cust_hobi_nari'
	});
	
	cust_hobi_lainField=new Ext.form.Checkbox({
		id : 'cust_hobi_lainField',
		boxLabel: 'Lain-lain',
		maxLength: 250,
		name: 'cust_hobi_lain'
	});
	
	cust_hobiField = new Ext.form.FieldSet({
		title: 'Hobi',
		anchor: '95%',
		layout:'column',
		autoHeight: true,
		collapsed: false,
		collapsible: true,
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				labelAlign: 'left',
				border:false,
				items: [ cust_hobi_bacaField, cust_hobi_olahField, cust_hobi_masakField, cust_hobi_travelField]
			},
			 {
				   	layout: 'form',
					border: false,
					columnWidth: 0.5,
					labelWidth: 80,
					labelAlign: 'left',
					items:[cust_hobi_fotoField, cust_hobi_lukisField, cust_hobi_nariField, cust_hobi_lainField]
			   }
		]
	});
	
	
	
	/* Identify  cust_referensi Field */
	cust_referensiField= new Ext.form.ComboBox({
		id: 'cust_referensiField',
		fieldLabel: 'Referal',
		store: cbo_cust_ref_DataStore,
		mode: 'remote',
		editable: false,
		displayField:'cust_nama',
		valueField: 'cust_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: customer_ref_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%',
		editable: true
	});
	
		/* Identify  cust_referensi Field */
	cust_referensilainField= new Ext.form.ComboBox({
		id: 'cust_referensilainField',
		fieldLabel: 'Referal Lain',
		maxLength: 250,
		anchor: '50%',
		//store: cbo_reflain_DataStore,
		store:new Ext.data.SimpleStore({
			fields:['cust_referensilain'],
			data: [['Lewat'],['Billboard'],['Keluarga'],['Teman'],['Dokter klinik'],['Miracle cabang lain'],['Staff'],['Koran'],['Majalah'],['Senam'],['Radio'],['Lain-lain']]
		}),	
		mode: 'local',
		displayField:'cust_referensilain',
		valueField: 'cust_referensilain',
        typeAhead: false,
        loadingText: 'Searching...',
       // pageSize:10,
        hideTrigger:false,
		triggerAction: 'all',
		lazyRender:true,
		anchor: '95%'
	});
		
	/* Identify  cust_referensi Field */
	cust_referensilaintxtField= new Ext.form.TextField({
		id: 'cust_referensilaintxtField',
		fieldLabel: '&nbsp;&nbsp;&nbsp;Tambah (Optional)',
		emptyText: 'Referal lainnya...',
		maxLength: 250,
		anchor: '50%'
	});
		
	/* Identify  cust_keterangan Field */
	cust_keteranganField= new Ext.form.TextArea({
		id: 'cust_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 500,
		anchor: '95%'
	});
	/* Identify  cust_member Field */
	cust_memberField= new Ext.form.TextField({
		id: 'cust_memberField',
		fieldLabel: 'No Member',
		anchor: '95%',
		readOnly: true
	});
	/* Identify  cust_terdaftar Field */
	cust_terdaftarField= new Ext.form.DateField({
		id: 'cust_terdaftarField',
		fieldLabel: 'Tgl Terdaftar',
		format : 'd-m-Y',
		emptyText: '<?=date('d/m/Y'); ?>',
		//allowBlank: false,
		anchor: '50%'
	});
	/* Identify  cust_tglawaltrans Field */
	cust_tglawaltransField= new Ext.form.DateField({
		id: 'cust_tglawaltransField',
		fieldLabel: 'Tgl Awal Transaksi',
		format : 'd-m-Y',
		emptyText: '<?=date('d/m/Y'); ?>',
		//allowBlank: false,
		anchor: '50%',
		readOnly: true
	});
	/* Identify  cust_statusnikah Field */
	cust_statusnikahField= new Ext.form.ComboBox({
		id: 'cust_statusnikahField',
		fieldLabel: 'Status Pernikahan',
		store:new Ext.data.SimpleStore({
			fields:['cust_statusnikah_value', 'cust_statusnikah_display'],
			data:[['menikah','menikah'],['belum menikah','belum menikah']]
		}),
		mode: 'local',
		editable: false,
		//allowBlank: false,
		displayField: 'cust_statusnikah_display',
		valueField: 'cust_statusnikah_value',
		anchor: '50%',
		triggerAction: 'all'	
	});
	
	
	/* Identify  CRM_dateField */
	cust_crm_dateField= new Ext.form.DateField({
		id: 'cust_crm_dateField',
		fieldLabel: 'Last update',
		format : 'd-m-Y',
		disabled : true,
		//emptyText: '<?=date('Y/m/d'); ?>',
		//allowBlank: false,
		anchor: '30%'
	});
	
	
	/* Identify  CRM value Field */
	cust_crm_valueField= new Ext.form.NumberField({
		id: 'cust_crm_valueField',
		fieldLabel: 'CRM Value',
		allowNegatife : false,
		blankText: '0',
		maxLength: 10,
		disabled : true,
		allowDecimals: false,
		anchor: '20%',
		maskRe: /([0-9]+)$/
	});
	
	cust_priorityField= new Ext.form.ComboBox({
		id: 'cust_priorityField',
		fieldLabel: 'Priority',
		store:new Ext.data.SimpleStore({
			fields:['cust_priority_value', 'cust_priority_display'],
			data:[['High','High'],['Normal','Normal'],['Low','Low']]
		}),
		mode: 'local',
		editable: false,
		//allowBlank: false,
		displayField: 'cust_priority_display',
		disabled : true,
		valueField: 'cust_priority_value',
		anchor: '30%',
		triggerAction: 'all'	
	});
	
	/* Identify  cust_jmlanak Field */
	cust_jmlanakField= new Ext.form.NumberField({
		id: 'cust_jmlanakField',
		fieldLabel: 'Jumlah Anak',
		allowNegatife : false,
		blankText: '0',
		maxLength: 2,
		allowDecimals: false,
		anchor: '50%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  cust_daftar Field */

	/* Identify  cust_unit Field */
	cust_unitField= new Ext.form.ComboBox({
		id: 'cust_unitField',
		fieldLabel: 'Cabang',
		store: cbo_cust_cabang_DataStore,
		mode: 'remote',
		//emptyText: 'Miracle Thamrin',
		editable: false,
		//allowBlank: false,
		displayField: 'cust_cabang_display',
		valueField: 'cust_cabang_value',
		anchor: '95%',
		triggerAction: 'all'
	});
	
	/*cust_unitField= new Ext.form.TextField({
		id: 'cust_unitField',
		name: 'cabang_nama',
		fieldLabel: 'Cabang',
		anchor: '95%',
		readOnly : true
	});*/
	
	/* Identify  cust_aktif Field */
	cust_aktifField= new Ext.form.ComboBox({
		id: 'cust_aktifField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['cust_aktif_value', 'cust_aktif_display'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		emptyText: 'Aktif',
		//allowBlank: true,
		displayField: 'cust_aktif_display',
		valueField: 'cust_aktif_value',
		anchor: '50%',
		triggerAction: 'all'	
	});
	
	/* Identify  cust_fretfulness Field */
	cust_fretfulnessField= new Ext.form.ComboBox({
		id: 'cust_fretfulnessField',
		fieldLabel: 'Fretfulness',
		store:new Ext.data.SimpleStore({
			fields:['cust_fretfulness_value', 'cust_fretfulness_display'],
			data:[['High','High'],['Medium','Medium'],['Low','Low']]
		}),
		mode: 'local',
		editable: false,
		//allowBlank: false,
		displayField: 'cust_fretfulness_display',
		valueField: 'cust_fretfulness_value',
		anchor: '30%',
		triggerAction: 'all'	
	});
	
	cust_fbField=new Ext.form.Checkbox({
		boxLabel: 'facebook',
		name: 'email_fb'
	});
	cust_tweeterField=new Ext.form.Checkbox({
		boxLabel: 'tweeter',
		name: 'email_tweeter'
	});
	
	cust_fb2Field=new Ext.form.Checkbox({
		boxLabel: 'facebook',
		name: 'email_fb2'
	});
	cust_tweeter2Field=new Ext.form.Checkbox({
		boxLabel: 'tweeter',
		name: 'email_tweeter2'
	});
	
	<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_CUSTOMER'))){ ?>
	cust_update_confirmField=new Ext.form.Checkbox({
		id: 'check_update',
//		boxLabel: 'Update data...',
		boxLabel: 'Simpan data',
		handler: function(node,checked){
			if (checked) {
				//Ext.Msg.alert('Status', 'Changes saved successfully.');
				customer_createForm.saveButton.enable();
			}else{
				customer_createForm.saveButton.disable();
			}
		}
	});
	<?php } ?>
	

	cust_alamat_group = new Ext.form.FieldSet({
		title: 'Alamat',
		autoHeight: true,
		defaultType: 'textfield',
		anchor: '95%',
		items:[cust_alamatField ,cust_kotaField, cust_kodeposField,cust_propinsiField,cust_negaraField]
	});
	
	cust_alamat2_group = new Ext.form.FieldSet({
		title: 'Alamat Lain',
		autoHeight: true,
		defaultType: 'textfield',
		anchor: '95%',
		items:[cust_alamat2Field ,cust_kota2Field, cust_kodepos2Field,cust_propinsi2Field,cust_negara2Field]
	});
	
	cust_kontak_group = new Ext.form.FieldSet({
		title: 'Kontak',
		labelWidth: 100,
		anchor: '95%',
		layout:'column',
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [cust_telprumahField, cust_hpField, cust_bbField]
			},{
				columnWidth:0.25,
				layout: 'form',
				border:false,
				items: [cust_telprumah2Field, cust_hp2Field] 
			},
			{
				columnWidth:0.25,
				layout: 'form',
				border:false,
				items: [cust_telpkantorField, cust_hp3Field] 
			}
		]
	});
	
	cust_cpField=new Ext.form.TextField({
		id: 'cust_cpField',
		fieldLabel: 'Contact Person',
		anchor: '95%'
	});
	cust_cptelpField= new Ext.form.TextField({
		id: 'cust_cptelpField',
		fieldLabel: 'Telp',
		maxLength: 30,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	contact_personGroup = new Ext.form.FieldSet({
		title: 'Contact Person',
		anchor: '95%',
		layout:'column',
		autoHeight: true,
		collapsed: true,
		collapsible: true,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [cust_cpField, cust_cptelpField]
			}
		]
	});
	
	crm_panel_group = new Ext.form.FieldSet({
		title: 'CRM Panel',
		autoHeight: true,
		defaultType: 'textfield',
		anchor: '95%',
		items:[cust_priorityField, cust_crm_valueField, cust_crm_dateField]
	});

	
	var tab_customer = new Ext.TabPanel({
		//el: 'tab_customer',
		activeTab: 0,
		labelWidth:120,
		items: [
			{
				layout:'column',
				title : 'Data Customer',
				border:false,
				frame: true,
				anchor: '95%',
				autoHeight: true,
				items:[
					{
						columnWidth:0.5,
						layout: 'form',
						border:false,
						items: [cust_noField, cust_titleField, cust_namaField, cust_panggilanField, cust_alamat_group, cust_kontak_group] 
					}
					,{
						columnWidth:0.5,
						layout: 'form',
						border:false,
						items: [cust_emailField,{
							xtype: 'checkboxgroup',
							fieldLabel:'',
							items:[cust_fbField,cust_tweeterField]
						},cust_email2Field,{
							xtype: 'checkboxgroup',
							fieldLabel:'',
							items:[cust_fb2Field,cust_tweeter2Field]
						}, cust_kelaminField, cust_tmptlahirField, cust_tgllahirField, {
							fieldLabel:'',
							items:[cust_tgllahir_infoLabel]
						},

						cust_umurField, 
						cust_referensiField,
						cust_terdaftarField, /*cust_tglawaltransField,*/ cust_unitField, 
						cust_keteranganField, cust_aktifField
						<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_CUSTOMER'))){ ?>
						, cust_update_confirmField
						<?php } ?>
						] 
					}
				]
			}
			/*,{
				border:false,
				frame: true, 
				anchor: '95%',
				autoHeight: true,
//				title: 'History Membership',
				title: 'Membership',
				items: cust_memberListEditorGrid
			},
			*/
			/*
			{
				border:false,
				frame: true,
				anchor: '95%',
				autoHeight: true,
//				title: 'History Catatan',
				title: 'Catatan Customer',
				items: [
					{
						columnWidth:0.5,
						layout: 'form',
						border:false,
						items: [cust_fretfulnessField,crm_panel_group] 
					}, 
					cust_noteListEditorGrid]
			}
			*/
		]
	});
	
	/* Function for retrieve create Window Panel*/ 
	customer_createForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		//height:680,
		width: 950,       
		items: tab_customer
		,buttons: [
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_CUSTOMER'))){ ?>
			{
				text: 'Save and Close',
				//id: 'btn_saveclose',
				ref: '../saveButton',
				//disabled: true,
				handler: customer_create
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					customer_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	customer_createWindow= new Ext.Window({
		id: 'customer_createWindow',
		title: post2db+'Customer',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_customer_create',
		items: customer_createForm
	});
	/* End Window */
	
	tab_customer.on("tabchange",function(panel,tab){
		cust_member_DataStore.load({params:{cust_id: get_pk_id(), start: 0, limit: pageS }});
		cust_note_DataStore.load({params:{cust_id: get_pk_id(), start: 0, limit: pageS }});
	});

	/* Function for action list search */
	
	/* Field for search */
	/* Identify  cust_no Field */
	cust_noSearchField= new Ext.form.TextField({
		id: 'cust_noSearchField',
		fieldLabel: 'No Cust',
		maxLength: 50,
		anchor: '50%'
	});
	cust_no_awalSearchField= new Ext.form.TextField({
		id: 'cust_no_awalSearchField',
		fieldLabel: 'No Cust Awal',
		maxLength: 50,
		anchor: '50%'
	});
	cust_no_akhirSearchField= new Ext.form.TextField({
		id: 'cust_no_akhirSearchField',
		fieldLabel: 'No Cust Akhir',
		maxLength: 50,
		anchor: '50%'
	});
	
	cust_label_nocustSearchField=new Ext.form.Label({ html: ' &nbsp; s/d  &nbsp;'});

	
	cust_nocust_opsiSearchField=new Ext.form.FieldSet({
		id:'cust_nocust_opsiSearchField',
		title: 'No Cust (6 digit)',
		layout: 'column',
		boduStyle: 'padding: 5px;',
		//border : false,
		//frame: false,
		anchor: '95%',
		align:'right',
		items:[cust_no_awalSearchField, cust_label_nocustSearchField, cust_no_akhirSearchField]
	});
	/*
	cust_nolamaSearchField= new Ext.form.TextField({
		id: 'cust_nolamaSearchField',
		fieldLabel: 'No Customer (Lama)',
		maxLength: 50,
		anchor: '50%'
	});*/
	/* Identify  cust_nama Field */
	cust_namaSearchField= new Ext.form.TextField({
		id: 'cust_namaSearchField',
		fieldLabel: 'Nama Lengkap',
		maxLength: 50,
		anchor: '95%'
	});
	
	/* Identify  cust_panggilan Field */
	cust_panggilanSearchField= new Ext.form.TextField({
		id: 'cust_panggilanSearchField',
		fieldLabel: 'Nama Panggilan',
		maxLength: 50,
		anchor: '95%'
	});
	
	/* Identify  cust_foreigner Field */
	cust_foreignerSearchField=new Ext.form.Checkbox({
		id : 'cust_foreignerSearchField',
		fieldLabel: 'Warga Asing',
		maxLength: 250,
	});
	
	/* Identify  cust_kelamin Field */
	cust_kelaminSearchField= new Ext.form.ComboBox({
		id: 'cust_kelaminSearchField',
		fieldLabel: 'Jenis Kelamin',
		store:new Ext.data.SimpleStore({
			fields:['cust_kelamin_value', 'cust_kelamin_display'],
			data:[['L','Laki-laki'],['P','Perempuan']]
		}),
		mode: 'local',
		displayField: 'cust_kelamin_display',
		valueField: 'cust_kelamin_value',
		anchor: '50%',
		triggerAction: 'all'	
	});
	/* Identify  cust_alamat Field */
	cust_alamatSearchField= new Ext.form.TextField({
		id: 'cust_alamatSearchField',
		fieldLabel: 'Alamat',
		maxLength: 250,
		anchor: '95%'
	});
	
	/* Identify  cust_kota Field */
	cust_kotaSearchField= new Ext.form.TextField({
		id: 'cust_kotaSearchField',
		fieldLabel: 'Kota',
		maxLength: 100,
		anchor: '95%'
	});
	/* Identify  cust_kodepos Field */
	cust_kodeposSearchField= new Ext.form.TextField({
		id: 'cust_kodeposSearchField',
		fieldLabel: 'Kode Pos',
		maxLength: 5,
		anchor: '50%'
		//maskRe: /([0-9]+)$/
	});
	/* Identify  cust_propinsi Field */
	cust_propinsiSearchField= new Ext.form.ComboBox({
		id: 'cust_propinsiSearchField',
		fieldLabel: 'Propinsi',
		maxLength: 100,
		store: cbo_propinsi_DataStore,
		mode: 'remote',
		displayField: 'propinsi_nama',
		valueField: 'propinsi_nama',
		anchor: '95%',
		triggerAction: 'all'
	});
	/* Identify  cust_negara Field */
	cust_negaraSearchField= new Ext.form.TextField({
		id: 'cust_negaraSearchField',
		fieldLabel: 'Negara',
		maxLength: 100,
		anchor: '95%'
	});
	
	/* Identify  cust_alamat2 Field */
	/*
	cust_alamat2SearchField= new Ext.form.TextField({
		id: 'cust_alamat2SearchField',
		fieldLabel: 'Alamat',
		maxLength: 150,
		anchor: '95%'
	});
	*/
	/* Identify  cust_kota Field */
	/*
	cust_kota2SearchField= new Ext.form.TextField({
		id: 'cust_kota2SearchField',
		fieldLabel: 'Kota',
		maxLength: 100,
		anchor: '95%'
	});
	*/
	/* Identify  cust_kodepos Field */
	/*
	cust_kodepos2SearchField= new Ext.form.TextField({
		id: 'cust_kodepos2SearchField',
		fieldLabel: 'Kode Pos',
		maxLength: 5,
		anchor: '50%'
		//maskRe: /([0-9]+)$/
	});
	*/
	/* Identify  cust_propinsi Field */
	/*
	cust_propinsi2SearchField= new Ext.form.ComboBox({
		id: 'cust_propinsi2SearchField',
		fieldLabel: 'Propinsi',
		maxLength: 100,
		store: cbo_propinsi_DataStore,
		mode: 'remote',
		displayField: 'propinsi_nama',
		valueField: 'propinsi_nama',
		anchor: '95%',
		triggerAction: 'all'
	});
	*/
	/* Identify  cust_negara Field */
	/*
	cust_negara2SearchField= new Ext.form.TextField({
		id: 'cust_negara2SearchField',
		fieldLabel: 'Negara',
		maxLength: 100,
		anchor: '95%'
	});
	*/
	
	/* Identify  cust_telprumah Field */
	cust_telprumahSearchField= new Ext.form.TextField({
		id: 'cust_telprumahSearchField',
		fieldLabel: 'Telp / HP',
		maxLength: 30,
		anchor: '95%'
		//maskRe: /([0-9]+)$/
	});
	/* Identify  cust_telprumah2 Field */
	/*
	cust_telprumah2SearchField= new Ext.form.TextField({
		id: 'cust_telprumah2SearchField',
		//fieldLabel: 'Telp. Rumah 2',
		hideLabel:true,
		maxLength: 30,
		anchor: '95%'
		//maskRe: /([0-9]+)$/
	});
	*/
	/* Identify  cust_telpkantor Field */
	/*
	cust_telpkantorSearchField= new Ext.form.TextField({
		id: 'cust_telpkantorSearchField',
		//fieldLabel: 'Telp. Kantor',
		hideLabel:true,
		maxLength: 100,
		anchor: '95%'
		//maskRe: /([0-9]+)$/
	});
	*/
	/* Identify  cust_hp Field */
	/*
	cust_hpSearchField= new Ext.form.TextField({
		id: 'cust_hpSearchField',
		fieldLabel: 'HP',
		maxLength: 25,
		anchor: '95%'
		//maskRe: /([0-9]+)$/
	});
	*/
	/* Identify  cust_hp2 Field */
	/*
	cust_hp2SearchField= new Ext.form.TextField({
		id: 'cust_hp2SearchField',
		//fieldLabel: 'No. Ponsel 2',
		hideLabel:true,
		maxLength: 25,
		anchor: '95%'
		//maskRe: /([0-9]+)$/
	});
	*/
	/* Identify  cust_hp3 Field */
	/*
	cust_hp3SearchField= new Ext.form.TextField({
		id: 'cust_hp3SearchField',
		//fieldLabel: 'No. Ponsel 3',
		hideLabel:true,
		maxLength: 25,
		anchor: '95%'
		//maskRe: /([0-9]+)$/
	});
	*/
	
	/* Identify  cust_bbField */
	cust_bbSearchField= new Ext.form.TextField({
		id: 'cust_bbSearchField',
		fieldLabel: 'Pin BB',
		maxLength: 30,
		anchor: '95%'
	});
	
	/* Identify  cust_email Field */
	cust_emailSearchField= new Ext.form.TextField({
		id: 'cust_emailSearchField',
		fieldLabel: 'Email',
		maxLength: 100,
		anchor: '95%'
	});
	
	/* Identify  cust_email Field */
	/*
	cust_email2SearchField= new Ext.form.TextField({
		id: 'cust_email2Field',
		fieldLabel: 'Email Alternatif',
		maxLength: 100,
		anchor: '95%'
	});
	*/
	
	/* Identify  cust_agama Field */
	cust_agamaSearchField= new Ext.form.ComboBox({
		id: 'cust_agamaSearchField',
		fieldLabel: 'Agama',
		maxLength: 50,
		store:new Ext.data.SimpleStore({
			fields:['cust_agama_value_display'],
			data: [['Islam'],['Katholik'],['Kristen'],['Hindu'],['Budha'],['Konghucu'],['Lainnya']]
		}),
		mode: 'local',
		displayField: 'cust_agama_value_display',
		valueField: 'cust_agama_value_display',
		anchor: '50%',
		triggerAction: 'all'	
	});
	/* Identify  cust_pendidikan Field */
	cust_pendidikanSearchField= new Ext.form.ComboBox({
		id: 'cust_pendidikanSearchField',
		fieldLabel: 'Pendidikan',
		maxLength: 50,
		store:new Ext.data.SimpleStore({
			fields:['cust_pendidikan_value_display'],
			data: [['SMA'],['Diploma/Akademi'],['Sarjana (S1)'],['Pasca Sarjana (S2)'],['Doktoral (S3)'],['Lainnya']]
		}),
		mode: 'local',
		displayField: 'cust_pendidikan_value_display',
		valueField: 'cust_pendidikan_value_display',
		anchor: '50%',
		triggerAction: 'all'
	});
	/* Identify  cust_member2 Field */
	cust_memberSearch2Field= new Ext.form.ComboBox({
		id: 'cust_memberSearch2Field',
		fieldLabel: 'Member',
		maxLength: 50,
		store:new Ext.data.SimpleStore({
			fields:['cust_member2_value_display'],
			data: [['Semua'],['Aktif'],['Tidak Aktif'],['Non Member']]
		}),
		mode: 'local',
		displayField: 'cust_member2_value_display',
		valueField: 'cust_member2_value_display',
		anchor: '50%',
		triggerAction: 'all'
	});
	/* Identify  cust_profesi Field */
	cust_profesiSearchField= new Ext.form.ComboBox({
		id: 'cust_profesiSearchField',
		fieldLabel: 'Profesi',
		maxLength: 100,
		//store: cbo_cust_profesi_DataStore,
		store:new Ext.data.SimpleStore({
			fields:['cust_profesi_display'],
			data: [['Pelajar / Mahasiswa'],['Ibu Rumah Tangga'],['Karyawan / Swasta'],['Wiraswasta'],['Profesional'],['Selebritis'],['Lain-lain']]
		}),
		mode: 'local',
		displayField: 'cust_profesi_display',
		valueField: 'cust_profesi_display',
		anchor: '95%',
		triggerAction: 'all'
	});
	/* Identify  cust_profesi Field */
	cust_profesitxtSearchField= new Ext.form.TextField({
		id: 'cust_profesitxtSearchField',
		fieldLabel: '&nbsp;&nbsp;&nbsp;Tambah (Optional)',
		emptyText: 'Profesi lainnya...',
		maxLength: 100,
		anchor: '95%'
	});
	
	/* Identify  cust_tgllahir Field 
	cust_tgllahirSearchField= new Ext.form.DateField({
		id: 'cust_tgllahirSearchField',
		fieldLabel: 'Tanggal Lahir',
		format : 'Y-m-d',
		anchor: '50%'
	});*/

	cust_tglSearchField= new Ext.form.ComboBox({
		id: 'cust_tglSearchField',
		store:new Ext.data.SimpleStore({
			fields:['cust_tgl_display'],
			data: [['1'],['2'],['3'],['4'],['5'],['6'],['7'],['8'],['9'],['10'],['11'],['12'],['13'],['14'],['15'],['16'],['17'],['18'],['19'],['20'],['21'],['22'],['23'],['24'],['25'],['26'],['27'],['28'],['29'],['30'],['31']]
		}),	
		mode: 'local',
		displayField: 'cust_tgl_display',
		valueField: 'cust_tgl_display',
		anchor: '55%',
		triggerAction: 'all',
		
	});
	
	cust_bulanSearchField=new Ext.form.ComboBox({
		id:'cust_bulanSearchField',
		fieldLabel:' ',
		store:new Ext.data.SimpleStore({
			fields:['value', 'display'],
			data:[['01','Januari'],['02','Pebruari'],['03','Maret'],['04','April'],['05','Mei'],['06','Juni'],['07','Juli'],['08','Agustus'],['09','September'],['10','Oktober'],['11','Nopember'],['12','Desember']]
		}),
		mode: 'local',
		displayField: 'display',
		valueField: 'value',
		//value: thismonth,
		width: 90,
		triggerAction: 'all'
	});
	
	cust_label_tglSearchField=new Ext.form.Label({ html: ' &nbsp; &nbsp; s/d'});
	
	cust_tglSearchFieldEnd= new Ext.form.ComboBox({
		id: 'cust_tglSearchFieldEnd',
		store:new Ext.data.SimpleStore({
			fields:['cust_tgl_displayEnd'],
			data: [['1'],['2'],['3'],['4'],['5'],['6'],['7'],['8'],['9'],['10'],['11'],['12'],['13'],['14'],['15'],['16'],['17'],['18'],['19'],['20'],['21'],['22'],['23'],['24'],['25'],['26'],['27'],['28'],['29'],['30'],['31']]
		}),	
		mode: 'local',
		displayField: 'cust_tgl_displayEnd',
		valueField: 'cust_tgl_displayEnd',
		anchor: '55%',
		triggerAction: 'all',
		
	});
	
	cust_bulanSearchFieldEnd=new Ext.form.ComboBox({
		id:'cust_bulanSearchFieldEnd',
		fieldLabel:' ',
		store:new Ext.data.SimpleStore({
			fields:['value', 'display'],
			data:[['01','Januari'],['02','Pebruari'],['03','Maret'],['04','April'],['05','Mei'],['06','Juni'],['07','Juli'],['08','Agustus'],['09','September'],['10','Oktober'],['11','Nopember'],['12','Desember']]
		}),
		mode: 'local',
		displayField: 'display',
		valueField: 'value',
		//value: thismonth,
		width: 90,
		triggerAction: 'all'
	});
	
	cust_tgllahirSearchField= new Ext.form.DateField({
		//fieldLabel: 'Tanggal Lahir',
		//name: 'cust_tgllahirSearchField',
		id: 'cust_tgllahirSearchField',
		//vtype: 'daterange',
		//allowBlank: false,
		format: 'd-m-Y'
		//endDateField: 'cust_tgllahirSearchFieldEnd' 
	});
	
	cust_tgllahirSearchFieldEnd= new Ext.form.DateField({
		fieldLabel: 's/d',
		//name: 'cust_tgllahirSearchFieldEnd',
		id: 'cust_tgllahirSearchFieldEnd',
		//vtype: 'daterange',
		//allowBlank: false,
		format: 'd-m-Y'
		//startDateField: 'cust_tgllahirSearchField' // id of the end date field
	});
	
	cust_tgl_opsiField=new Ext.form.Radio({
		id:'cust_tgl_opsiField',
		boxLabel:'Antara Tanggal',
		width:100,
		name: 'filter_lahir',
		checked: true,
		handler: function(node,checked){
		if(cust_tgl_opsiField.checked==true){
			cust_tglSearchField.disable();
			cust_bulanSearchField.disable();
			cust_tglSearchFieldEnd.disable();
			cust_bulanSearchFieldEnd.disable();			
			cust_tgllahirSearchField.enable();
			cust_tgllahirSearchFieldEnd.enable();
		}else{
			cust_tglSearchField.enable();
			cust_bulanSearchField.enable();
			cust_tglSearchFieldEnd.enable();
			cust_bulanSearchFieldEnd.enable();			
			cust_tgllahirSearchField.disable();
			cust_tgllahirSearchFieldEnd.disable();
		}}
	});
	
	cust_bulan_opsiField=new Ext.form.Radio({
		id:'cust_bulan_opsiField',
		boxLabel:'Tanggal & Bulan',
		width:100,
		name: 'filter_lahir'
	});
	
	//cust_label_tgllahirSearchField=new Ext.form.Label({ html: ' &nbsp; s/d  &nbsp;'});
	
	cust_tanggal_opsiSearchField=new Ext.form.FieldSet({
		id:'cust_tanggal_opsiSearchField',
		title: 'Tanggal Lahir',
		layout: 'form',
		//bodyStyle: 'padding: 5px;',
		anchor: '95%',
		//border : false,
		//frame: false,
		//items:[cust_tgllahirSearchField, cust_label_tgllahirSearchField, cust_tgllahirSearchFieldEnd]
		
		items:[/*{
				layout: 'column',
				border: false,
				items:[rpt_jpaket_opsiallField]
			},*/{
				layout: 'column',
				border: false,
				items:[cust_tgl_opsiField, {
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[cust_tgllahirSearchField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[cust_tgllahirSearchFieldEnd]
					   }]
			},{
				layout: 'column',
				border: false,
				items:[cust_bulan_opsiField,{
					   		layout: 'form',
							border: false,
							labelWidth: 5,
							//bodyStyle:'padding:3px',
							items:[cust_tglSearchField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							//bodyStyle:'padding:3px',
							labelSeparator: '', 
							items:[cust_bulanSearchField]
					   },
					   cust_label_tglSearchField,
					   {
					   		layout: 'form',
							border: false,
							labelWidth: 5,
							//bodyStyle:'padding:3px',
							items:[cust_tglSearchFieldEnd]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							//bodyStyle:'padding:3px',
							labelSeparator: '', 
							items:[cust_bulanSearchFieldEnd]
					   }]
			}]
	});
	
	/* Identify  cust_hobi Field */
	/*cust_hobiSearchField= new Ext.form.ComboBox({
		id: 'cust_hobiSearchField',
		fieldLabel: 'Hobi',
		maxLength: 500,
		//store: cbo_cust_hobi_DataStore,
		store:new Ext.data.SimpleStore({
			fields:['cust_hobi_display'],
			data: [['Membaca'],['Olahraga'],['Memasak'],['Travelling'],['Fotografi'],['Melukis'],['Menari'],['Lain-lain']]
		}),	
		mode: 'local',
		displayField: 'cust_hobi_display',
		valueField: 'cust_hobi_display',
		anchor: '95%',
		triggerAction: 'all'
	});
	
	cust_hobitxtSearchField= new Ext.form.TextField({
		id: 'cust_hobitxtSearchField',
		fieldLabel: '&nbsp;&nbsp;&nbsp;Tambah (Optional)',
		emptyText: 'Hobi lainnya...',
		maxLength: 500,
		anchor: '95%'
	});*/
	
	cust_hobi_bacaSearchField=new Ext.form.Checkbox({
		id : 'cust_hobi_bacaSearchField',
		boxLabel: 'Membaca',
		maxLength: 250,
		name: 'cust_hobi_baca'
	});
	
	cust_hobi_olahSearchField=new Ext.form.Checkbox({
		id : 'cust_hobi_olahSearchField',
		boxLabel: 'Olahraga',
		maxLength: 250,
		name: 'cust_hobi_olah'
	});
	
	cust_hobi_masakSearchField=new Ext.form.Checkbox({
		id : 'cust_hobi_masakSearchField',
		boxLabel: 'Memasak',
		maxLength: 250,
		name: 'cust_hobi_masak'
	});
	
	cust_hobi_travelSearchField=new Ext.form.Checkbox({
		id : 'cust_hobi_travelSearchField',
		boxLabel: 'Travelling',
		maxLength: 250,
		name: 'cust_hobi_travel'
	});
	
	cust_hobi_fotoSearchField=new Ext.form.Checkbox({
		id : 'cust_hobi_fotoSearchField',
		boxLabel: 'Fotografi',
		maxLength: 250,
		name: 'cust_hobi_foto'
	});
	
	cust_hobi_lukisSearchField=new Ext.form.Checkbox({
		id : 'cust_hobi_lukisSearchField',
		boxLabel: 'Melukis',
		maxLength: 250,
		name: 'cust_hobi_lukis'
	});
	
	cust_hobi_nariSearchField=new Ext.form.Checkbox({
		id : 'cust_hobi_nariSearchField',
		boxLabel: 'Menari',
		maxLength: 250,
		name: 'cust_hobi_nari'
	});
	
	cust_hobi_lainSearchField=new Ext.form.Checkbox({
		id : 'cust_hobi_lainSearchField',
		boxLabel: 'Lain-lain',
		maxLength: 250,
		name: 'cust_hobi_lain'
	});
	
	cust_hobiSearchField = new Ext.form.FieldSet({
		id : 'cust_hobiSearchField',
		title: 'Hobi',
		anchor: '95%',
		layout:'column',
		autoHeight: true,
		collapsed: true,
		collapsible: true,
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				labelAlign: 'left',
				border:false,
				items: [ cust_hobi_bacaSearchField, cust_hobi_olahSearchField, cust_hobi_masakSearchField, cust_hobi_travelSearchField]
			},
			 {
				   	layout: 'form',
					border: false,
					columnWidth: 0.5,
					labelWidth: 80,
					labelAlign: 'left',
					items:[cust_hobi_fotoSearchField, cust_hobi_lukisSearchField, cust_hobi_nariSearchField, cust_hobi_lainSearchField]
			   }
		]
	});
	
	/* Identify  cust_referensi Field */
	cust_referensiSearchField= new Ext.form.ComboBox({
		id: 'cust_referensiSearchField',
		fieldLabel: 'Referal',
		store: cbo_cust_ref_DataStore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: customer_ref_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});
	
	/* Identify  cust_referensi Field */
	cust_referensilainSearchField= new Ext.form.ComboBox({
		id: 'cust_referensilainSearchField',
		fieldLabel: 'Referal Lain',
		maxLength: 250,
		anchor: '50%',
		//store: cbo_reflain_DataStore,
		store:new Ext.data.SimpleStore({
			fields:['cust_referensilain'],
			data: [['Lewat'],['Billboard'],['Keluarga'],['Teman'],['Dokter klinik'],['Miracle cabang lain'],['Staff'],['Koran'],['Majalah'],['Senam'],['Radio'],['Lain-lain']]
		}),	
		mode: 'local',
		displayField:'cust_referensilain',
		valueField: 'cust_referensilain',
        typeAhead: false,
        loadingText: 'Searching...',
       //pageSize:10,
        hideTrigger:false,
		triggerAction: 'all',
		lazyRender:true,
		anchor: '95%'
	});
		
	/* Identify  cust_referensi Field */
	cust_referensilaintxtSearchField= new Ext.form.TextField({
		id: 'cust_referensilaintxtSearchField',
		fieldLabel: '&nbsp;&nbsp;&nbsp;Tambah (Optional)',
		emptyText: 'Referal lainnya...',
		maxLength: 250,
		anchor: '50%'
	});
	
	/* Identify  cust_keterangan Field */
	cust_keteranganSearchField= new Ext.form.TextArea({
		id: 'cust_keteranganSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 500,
		anchor: '95%'
	});
	/* Identify  cust_member Field */
	cust_memberSearchField= new Ext.form.TextField({
		id: 'cust_memberSearchField',
		fieldLabel: 'No Member',
		anchor: '95%',
		//readOnly: true
	});
	
	/* Identify  cust_terdaftar Field */
	cust_terdaftarSearchField= new Ext.form.DateField({
		fieldLabel: 'Tgl Terdaftar',
		id: 'cust_terdaftarSearchField',
		format: 'd-m-Y'
	});
	
	cust_tgldaftarSearchFieldEnd= new Ext.form.DateField({
		fieldLabel: 's/d',
		id: 'cust_tgldaftarSearchFieldEnd',
		format: 'd-m-Y'
	});
	
	/*Identify cust tanggal terdaftar search field */
	cust_label_tgldaftarSearchField=new Ext.form.Label({ html: ' &nbsp; s/d  &nbsp;'});
	cust_tanggaldaftar_opsiSearchField=new Ext.form.FieldSet({
		id:'cust_tanggaldaftar_opsiSearchField',
		title: 'Tanggal Terdaftar Customer',
		layout: 'column',
		boduStyle: 'padding: 5px;',
		anchor: '95%',
		//border : false,
		//frame: false,
		items:[cust_terdaftarSearchField, cust_label_tgldaftarSearchField, cust_tgldaftarSearchFieldEnd]
	});
	
	/* Identify  member_terdaftar Field */
	member_terdaftarSearchField= new Ext.form.DateField({
		fieldLabel: 'Tgl Terdaftar',
		id: 'member_terdaftarSearchField',
		format: 'd-m-Y'
	});
	
	member_tgldaftarSearchFieldEnd= new Ext.form.DateField({
		fieldLabel: 's/d',
		id: 'member_tgldaftarSearchFieldEnd',
		format: 'd-m-Y'
	});
	
	/*Identify member tanggal terdaftar search field */
	member_label_tgldaftarSearchField=new Ext.form.Label({ html: ' &nbsp; s/d  &nbsp;'});
	member_tanggaldaftar_opsiSearchField=new Ext.form.FieldSet({
		id:'member_tanggaldaftar_opsiSearchField',
		title: 'Tanggal Terdaftar Member',
		layout: 'column',
		boduStyle: 'padding: 5px;',
		anchor: '95%',
		//border : false,
		//frame: false,
		items:[member_terdaftarSearchField, member_label_tgldaftarSearchField, member_tgldaftarSearchFieldEnd]
	});
	
	/* Identify  cust_tglawaltrans Field */
	cust_tglawaltransSearchField= new Ext.form.DateField({
		fieldLabel: 'Tgl Awal Transaksi',
		id: 'cust_tglawaltransSearchField', 
		format: 'd-m-Y'
	});
	
	cust_tglawaltransSearchFieldEnd= new Ext.form.DateField({
		fieldLabel: 's/d',
		id: 'cust_tglawaltransSearchFieldEnd',
		format: 'd-m-Y'
	});
	
	cust_label_tglawaltransSearchField=new Ext.form.Label({ html: ' &nbsp; s/d  &nbsp;'});
	cust_tglawaltrans_opsiSearchField=new Ext.form.FieldSet({
		id:'cust_tglawaltrans_opsiSearchField',
		title: 'Tgl Awal Transaksi',
		layout: 'column',
		boduStyle: 'padding: 5px;',
		anchor: '95%',
		//border : false,
		//frame: false,
		items:[cust_tglawaltransSearchField, cust_label_tglawaltransSearchField, cust_tglawaltransSearchFieldEnd]
	});	
	
	/*Identify radio button utk tanggal transaksi */	
	/*cust_tgltransaksi_opsiField=new Ext.form.Radio({
		id:'cust_tgltransaksi_opsiField',
		boxLabel:'Yang melakukan transaksi',
		width:100,
		name: 'filter_transaksi',
		checked: true
	});
	cust_tidak_tgltransaksi_opsiField=new Ext.form.Radio({
		id:'cust_tidak_tgltransaksi_opsiField',
		boxLabel:'Yang tidak melakukan transaksi',
		width:100,
		name: 'filter_transaksi'
	});	*/
		
	/* Identify  cust_tgl_transaksiField */
	cust_tgl_transaksiSearchFieldStart= new Ext.form.DateField({
		//fieldLabel: 'Tanggal Transaksi',
		fieldLabel:'Yang melakukan transaksi',
		id: 'cust_tgl_transaksiSearchFieldStart',
		format: 'd-m-Y'
	});
	
	cust_tgl_transaksiSearchFieldEnd= new Ext.form.DateField({
		fieldLabel: 's/d',
		id: 'cust_tgl_transaksiSearchFieldEnd',
		format: 'd-m-Y'
	});
	
	cust_tidak_tgl_transaksiSearchFieldStart= new Ext.form.DateField({
		//fieldLabel: 'Tanggal Transaksi',
		fieldLabel:'Yang tidak melakukan transaksi',
		id: 'cust_tidak_tgl_transaksiSearchFieldStart',
		format: 'd-m-Y'
	});
	
	cust_tidak_tgl_transaksiSearchFieldEnd= new Ext.form.DateField({
		fieldLabel: 's/d',
		id: 'cust_tidak_tgl_transaksiSearchFieldEnd',
		format: 'd-m-Y'
	});
	
	cust_label_transaksi=new Ext.form.Label({ html: ' &nbsp; Yang Melakukan : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'});
	cust_label_tidaktransaksi=new Ext.form.Label({ html: ' &nbsp; Yang Tidak : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'});
	cust_label_tgl_transaksiSearchField=new Ext.form.Label({ html: ' &nbsp; s/d  &nbsp;'});
	cust_label_tgl_tdktransaksiSearchField=new Ext.form.Label({ html: ' &nbsp; s/d  &nbsp;'});
	cust_label_enter=new Ext.form.Label({ html: '&nbsp;<br> <br>'});
	/*
	cust_tanggaltransaksi_opsiSearchField=new Ext.form.FieldSet({
		id:'cust_tanggaltransaksi_opsiSearchField',
		title: 'Tanggal Transaksi',
		layout: 'column',
		boduStyle: 'padding: 5px;',
		anchor: '95%',
		collapsed: true,
		collapsible: true,
		items:[cust_tgl_transaksiSearchFieldStart, cust_label_tgl_transaksiSearchField, cust_tgl_transaksiSearchFieldEnd]
	});	
	*/
	cust_tanggaltransaksi_opsiSearchField=new Ext.form.FieldSet({
		id:'cust_tanggaltransaksi_opsiSearchField',
		title: 'Tanggal Transaksi',
		layout: 'form',
		boduStyle: 'padding: 5px;',
		collapsed: false,
		collapsible: true,
		anchor: '95%',
		items:[{
				layout: 'column',
				border: false,
				items:[cust_label_transaksi, cust_tgl_transaksiSearchFieldStart,cust_label_tgl_transaksiSearchField, cust_tgl_transaksiSearchFieldEnd,cust_label_enter]
				/*[cust_tgltransaksi_opsiField, {
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[cust_tgl_transaksiSearchFieldStart]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[cust_tgl_transaksiSearchFieldEnd]
					   }]*/
			},{
				layout: 'column',
				border: false,
				items:[cust_label_tidaktransaksi,cust_tidak_tgl_transaksiSearchFieldStart,cust_label_tgl_tdktransaksiSearchField,cust_tidak_tgl_transaksiSearchFieldEnd]
				/*[cust_tidak_tgltransaksi_opsiField,{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[cust_tidak_tgl_transaksiSearchFieldStart]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[cust_tidak_tgl_transaksiSearchFieldEnd]
					   }]*/
			}]
	});
		
	/* Identify  cust_statusnikah Field */
	cust_statusnikahSearchField= new Ext.form.ComboBox({
		id: 'cust_statusnikahSearchField',
		fieldLabel: 'Status Pernikahan',
		store:new Ext.data.SimpleStore({
			fields:['cust_statusnikah_value', 'cust_statusnikah_display'],
			data:[['menikah','menikah'],['belum menikah','belum menikah']]
		}),
		mode: 'local',
		displayField: 'cust_statusnikah_display',
		valueField: 'cust_statusnikah_value',
		anchor: '50%',
		triggerAction: 'all'	
	});
	
	cust_prioritySearchField= new Ext.form.ComboBox({
		id: 'cust_prioritySearchField',
		fieldLabel: 'Priority',
		store:new Ext.data.SimpleStore({
			fields:['cust_priority_value', 'cust_priority_display'],
			data:[['High','High'],['Normal','Normal'],['Low','Low']]
		}),
		mode: 'local',
		displayField: 'cust_priority_display',
		valueField: 'cust_priority_value',
		anchor: '50%',
		triggerAction: 'all'	
	});
	
	/* Identify  cust_jmlanak Field */
	cust_jmlanakSearchField= new Ext.form.NumberField({
		id: 'cust_jmlanakSearchField',
		fieldLabel: 'Jumlah Anak',
		allowNegatife : false,
		blankText: '0',
		maxLength: 2,
		allowDecimals: false,
		anchor: '50%'
		//maskRe: /([0-9]+)$/
	});
	/* Identify  cust_daftar Field */

	/* Identify  cust_unit Field */
	cust_unitSearchField= new Ext.form.ComboBox({
		id: 'cust_unitSearchField',
		fieldLabel: 'Cabang',
		store: cbo_cust_cabang_DataStore,
		mode: 'remote',
		displayField: 'cust_cabang_display',
		valueField: 'cust_cabang_value',
		anchor: '95%',
		triggerAction: 'all'
	});
	/* Identify  cust_aktif Field */
	cust_aktifSearchField= new Ext.form.ComboBox({
		id: 'cust_aktifSearchField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['cust_aktif_value', 'cust_aktif_display'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		displayField: 'cust_aktif_display',
		valueField: 'cust_aktif_value',
		emptyText: 'Aktif',
		anchor: '50%',
		triggerAction: 'all'	
	});
	
	/* Identify  sort_by Field */
	sortby_SearchField= new Ext.form.ComboBox({
		id: 'sortby_SearchField',
		fieldLabel: 'Urutkan',
		store:new Ext.data.SimpleStore({
			fields:['sortby_value', 'sortby_display'],
			data:[['No Cust','No Cust'],['Nama','Nama'],['Alamat','Alamat'],['Tgl Lahir','Tgl Lahir'],['Telp Rmh','Telp Rumah'],['Handphone','HP']]
		}),
		mode: 'local',
		displayField: 'sortby_display',
		valueField: 'sortby_value',
		//emptyText: 'Aktif',
		anchor: '50%',
		triggerAction: 'all'	
	});
	
	/* Identify  Fretfulness_search Field */
	fretfulness_SearchField= new Ext.form.ComboBox({
		id: 'fretfulness_SearchField',
		fieldLabel: 'Fretfulness',
		store:new Ext.data.SimpleStore({
			fields:['fretfulness_value', 'fretfulness_display'],
			data:[['High','High'],['Medium','Medium'],['Low','Low'],['Undefined','Undefined']]
		}),
		mode: 'local',
		displayField: 'fretfulness_display',
		valueField: 'fretfulness_value',
		emptyText: '',
		anchor: '50%',
		triggerAction: 'all'	
	});
	
	/* Identify  umur Field */
	cust_umurstartSearchField= new Ext.form.TextField({
		id: 'cust_umurstartSearchField',
		fieldLabel: 'Umur',
		maxLength: 10,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  batas umur Field */
	cust_umurendSearchField= new Ext.form.TextField({
		id: 'cust_umurendSearchField',
		//fieldLabel: 'Telp. Rumah 2',
		hideLabel:true,
		maxLength: 10,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	cust_label_umurSearchField=new Ext.form.Label({ html: ' &nbsp; s/d  &nbsp;'});
	cust_label_thncustSearchField=new Ext.form.Label({ html: ' &nbsp; tahun'});
	cust_umur_groupSearch = new Ext.form.FieldSet({
		title: 'Umur',
		labelWidth: 100,
		anchor: '95%',
		layout:'column',
		items: [cust_umurstartSearchField, cust_label_umurSearchField, cust_umurendSearchField,cust_label_thncustSearchField]

	});
	
	cust_alamat_groupSearch = new Ext.form.FieldSet({
		title: 'Alamat',
		autoHeight: true,
		defaultType: 'textfield',
		collapsed: true,
		collapsible: true,
		anchor: '95%',
		items:[cust_alamatSearchField ,cust_kotaSearchField, cust_kodeposSearchField,cust_propinsiSearchField,cust_negaraSearchField]
	});
	
	
	cust_alamat2_groupSearch = new Ext.form.FieldSet({
		title: 'Alamat Lain',
		autoHeight: true,
		defaultType: 'textfield',
		anchor: '95%',
		items:[]
	});
	
	cust_kontak_groupSearch = new Ext.form.FieldSet({
		title: 'Kontak',
		labelWidth: 100,
		anchor: '95%',
		layout:'column',
		collapsed: true,
		collapsible: true,
		items:[
			{
				columnWidth:0.8,
				layout: 'form',
				border:false,
				items: [cust_telprumahSearchField, cust_bbSearchField, cust_emailSearchField]
			}
		]
	});
	
	/* Function for retrieve search Form Panel */
	customer_searchForm = new Ext.FormPanel({
		labelAlign: 'left',
		labelWidth:120,
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 1000,        
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:0.45,
				layout: 'form',
				border:false,
				items: [cust_nocust_opsiSearchField, cust_namaSearchField, cust_panggilanSearchField,  cust_alamat_groupSearch, cust_kontak_groupSearch, cust_hobiSearchField,cust_kelaminSearchField, cust_tanggaltransaksi_opsiSearchField] 
			}
			,{
				columnWidth:0.55,
				layout: 'form',
				border:false,
				items: [cust_tanggal_opsiSearchField, cust_umur_groupSearch, cust_tanggaldaftar_opsiSearchField, member_tanggaldaftar_opsiSearchField, cust_tglawaltrans_opsiSearchField, cust_referensiSearchField, cust_keteranganSearchField, cust_prioritySearchField, cust_unitSearchField, cust_aktifSearchField,sortby_SearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: customer_list_search
			},{
				text: 'Close',
				handler: function(){
					customer_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	customer_searchWindow = new Ext.Window({
		title: 'Pencarian Customer',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_customer_search',
		items: customer_searchForm
	});
    /* End of Function */ 
	 
	/*cust_tgl_opsiField.on("check",function(){
	if(cust_tgl_opsiField.getValue()==true){
		cust_tgllahirSearchField.disabled=false;
		cust_tgllahirSearchFieldEnd.disabled=false;
	}else{
		cust_tgllahirSearchField.disabled=true;
		cust_tgllahirSearchFieldEnd.disabled=true;
	}
	});*/
	
});
	</script>
<body>
<div>
	<div class="col">
    	<div id="tab_customer"></div>
        <div id="fp_customer"></div>
        <div id="fp_cust_member"></div>
         <div id="fp_cust_note"></div>
		<div id="elwindow_customer_create"></div>
        <div id="elwindow_customer_search"></div>
		<div id="elwindow_customer_phonegroup_save"></div>
    </div>
</div>
</body>