<?
/* 	
	Miracle IT Team
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
var perawatan_DataStore;
var perawatan_ColumnModel;
var perawatanListEditorGrid;
var perawatan_createForm;
var perawatan_createWindow;
var perawatan_searchForm;
var perawatan_searchWindow;
var perawatan_SelectedRow;
var perawatan_ContextMenu;
//for detail data
var perawatan_konsumsi_DataStor;
var perawatan_konsumsiListEditorGrid;
var perawatan_konsumsi_ColumnModel;
var perawatan_konsumsi_writer;
var perawatan_konsumsi_reader;
var editor_perawatan_konsumsi;

//declare konstant
var perawatan_post2db = '';
var msg = '';
var perawatan_pageS=15;

/* declare variable here for Field*/
var rawat_idField;
var rawat_kodeField;
var rawat_kodelamaField;
var rawat_namaField;
var rawat_highmarginField;
var rawat_edit_hargaField;
var rawat_groupField;
var rawat_jenisField;
var rawat_kontribusiField;
var rawat_kategoriField;
var rawat_kategoritxtField;
var rawat_keteranganField;
var rawat_duField;
var rawat_dmField;
var rawat_dultahField;
var rawat_dcardField;
var rawat_dkolegaField;
var rawat_dkeluargaField;
var rawat_downerField;
var rawat_dgroomingField;
var rawat_dwartawanField;
var rawat_dstaffdokterField;
var rawat_dstaffnondokterField;
var rawat_dpromoField;
var rawat_pointField;
var rawat_durasiField;
var rawat_kreditField;
var rawat_kreditrpField;
var rawat_jumlah_tindakanField;
var rawat_hargaField;
var rawat_harga_kiField;
var rawat_harga_mdnField;
var rawat_harga_mndField;
var rawat_harga_mtaField;
var rawat_harga_ygkField;
var rawat_harga_lbkField;
var rawat_harga_tpField;
var rawat_harga_dpsField;
var rawat_harga_jktField;
var rawat_harga_blpnField;
var rawat_harga_kutaField;
var rawat_harga_btmField;
var rawat_harga_smgField;
var rawat_harga_mksField;
var rawat_harga_mlgField;
var rawat_gudangField;
var rawat_aktifField;
var rawat_idSearchField;
var rawat_kodeSearchField;
var rawat_kodelamaSearchField;
var rawat_namaSearchField;
var rawat_groupSearchField;
var rawat_kategoriSearchField;
var rawat_jenisSearchField;
var rawat_keteranganSearchField;
var rawat_duSearchField;
var rawat_dmSearchField;
var rawat_dultahSearchField;
var rawat_dcardSearchField;
var rawat_dkolegaSearchField;
var rawat_dkeluargaSearchField;
var rawat_downerSearchField;
var rawat_dgroomingSearchField;
var rawat_pointSearchField;
var rawat_durasiSearchField;
var rawat_kreditSearchField;
var rawat_hargaSearchField;
var rawat_jumlah_tindakanSearchField;
var rawat_gudangSearchField;
var rawat_aktifSearchField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  	/* Function for Saving inLine Editing */
	function perawatan_update(oGrid_event){
		var rawat_id_update_pk="";
		var rawat_kode_update=null;
		var rawat_kodelama_update=null;
		var rawat_nama_update=null;
		var rawat_group_update=null;
		var rawat_kategori_update=null;
		var rawat_kontribusi_update=null;
		var rawat_jenis_update=null;
		var rawat_keterangan_update=null;
		var rawat_du_update=null;
		var rawat_dm_update=null;
		var rawat_point_update=null;
		var rawat_durasi_update=null;
		var rawat_kredit_update=null;
		var rawat_jumlah_tindakan_update=null;
		var rawat_harga_update=null;
		var rawat_gudang_update=null;
		var rawat_aktif_update=null;

		rawat_id_update_pk = oGrid_event.record.data.rawat_id;
		if(oGrid_event.record.data.rawat_kode!== null){rawat_kode_update = oGrid_event.record.data.rawat_kode;}
		if(oGrid_event.record.data.rawat_kodelama!== null){rawat_kodelama_update = oGrid_event.record.data.rawat_kodelama;}
		if(oGrid_event.record.data.rawat_nama!== null){rawat_nama_update = oGrid_event.record.data.rawat_nama;}
		if(oGrid_event.record.data.rawat_group!== null){rawat_group_update = oGrid_event.record.data.rawat_group;}
		if(oGrid_event.record.data.rawat_kategori!== null){rawat_kategori_update = oGrid_event.record.data.rawat_kategori;}
		if(oGrid_event.record.data.rawat_kontribusi!== null){rawat_kontribusi_update = oGrid_event.record.data.rawat_kontribusi;}
		if(oGrid_event.record.data.rawat_jenis!== null){rawat_jenis_update = oGrid_event.record.data.rawat_jenis;}
		if(oGrid_event.record.data.rawat_keterangan!== null){rawat_keterangan_update = oGrid_event.record.data.rawat_keterangan;}
		if(oGrid_event.record.data.rawat_du!== null){rawat_du_update = oGrid_event.record.data.rawat_du;}
		if(oGrid_event.record.data.rawat_dm!== null){rawat_dm_update = oGrid_event.record.data.rawat_dm;}
		if(oGrid_event.record.data.rawat_point!== null){rawat_point_update = oGrid_event.record.data.rawat_point;}
		if(oGrid_event.record.data.rawat_durasi!== null){rawat_durasi_update = oGrid_event.record.data.rawat_durasi;}
		if(oGrid_event.record.data.rawat_kredit!== null){rawat_kredit_update = oGrid_event.record.data.rawat_kredit;}
		if(oGrid_event.record.data.rawat_harga!== null){rawat_harga_update = oGrid_event.record.data.rawat_harga;}
		if(oGrid_event.record.data.rawat_jumlah_tindakan!== null){rawat_jumlah_tindakan_update = oGrid_event.record.data.rawat_jumlah_tindakan;}
		if(oGrid_event.record.data.rawat_gudang!== null){rawat_gudang_update = oGrid_event.record.data.rawat_gudang;}
		if(oGrid_event.record.data.rawat_aktif!== null){rawat_aktif_update = oGrid_event.record.data.rawat_aktif;}

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_perawatan&m=get_action',
			params: {
				task: "UPDATE",
				rawat_id	: rawat_id_update_pk, 
				rawat_kode	:rawat_kode_update,  
				rawat_kodelama	:rawat_kodelama_update,  
				rawat_nama	:rawat_nama_update,  
				rawat_group	:rawat_group_update,  
				rawat_kategori	:rawat_kategori_update,
				rawat_kontribusi : rawat_kontribusi_update,
				rawat_jenis	:rawat_jenis_update,  
				rawat_keterangan	:rawat_keterangan_update,  
				rawat_du	:rawat_du_update,  
				rawat_dm	:rawat_dm_update,  
				rawat_point	:rawat_point_update,
				rawat_durasi:rawat_durasi_update,
				rawat_kredit :rawat_kredit_update,
				rawat_jumlah_tindakan : rawat_jumlah_tindakan_update,
				rawat_harga	:rawat_harga_update,  
				rawat_gudang	:rawat_gudang_update,  
				rawat_aktif	:rawat_aktif_update,  
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						perawatan_DataStore.commitChanges();
						perawatan_DataStore.reload();
						break;
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Data Perawatan tidak bisa disimpan',
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
	function perawatan_create(){
	
		if(is_perawatan_form_valid()){	
		var rawat_id_create_pk=null; 
		var rawat_kode_create=null; 
		var rawat_kodelama_create=null; 
		var rawat_nama_create=null; 
		var rawat_group_create=null; 
		var rawat_kategori_create=null; 
		var rawat_kontribusi_create=null;
		var rawat_jenis_create=null; 
		var rawat_keterangan_create=null; 
		var rawat_du_create=null; 
		var rawat_dm_create=null; 
		var rawat_dultah_create=null;
		var rawat_dcard_create=null;
		var rawat_dkolega_create=null;
		var rawat_dkeluarga_create=null;
		var rawat_downer_create=null;
		var rawat_dgrooming_create=null;
		var rawat_dwartawan_create=null;
		var rawat_dstaffdokter_create=null;
		var rawat_dstaffnondokter_create=null;
		var rawat_dpromo_create=null;
		var rawat_point_create=null;
		var rawat_durasi_create=null;
		var rawat_kredit_create=null;
		var rawat_kreditrp_create=null;
		var rawat_jumlah_tindakan_create=null;
		var rawat_harga_create=null; 
		var rawat_harga_createki=null;
		var rawat_harga_createmta=null;
		var rawat_harga_createmdn=null;
		var rawat_harga_createmnd=null;
		var rawat_harga_createygk=null;
		var rawat_harga_createlbk=null;
		var rawat_harga_createhr=null;
		var rawat_harga_createtp=null;
		var rawat_harga_createdps=null;
		var rawat_harga_createjkt=null;
		var rawat_harga_createblpn=null;
		var rawat_harga_createkuta=null;
		var rawat_harga_createbtm=null;
		var rawat_harga_createsmg=null;
		var rawat_harga_createmks=null;
		var rawat_harga_createmlg=null;
		var rawat_gudang_create=null; 
		var rawat_aktif_create=null; 

		if(rawat_idField.getValue()!== null){rawat_id_create_pk = rawat_idField.getValue();}else{rawat_id_create_pk=get_pk_id();} 
		if(rawat_kodeField.getValue()!== null){rawat_kode_create = rawat_kodeField.getValue();} 
		if(rawat_kodelamaField.getValue()!== null){rawat_kodelama_create = rawat_kodelamaField.getValue();} 
		if(rawat_namaField.getValue()!== null){rawat_nama_create = rawat_namaField.getValue();} 
		if(rawat_groupField.getValue()!== null){rawat_group_create = rawat_groupField.getValue();} 
		if(rawat_jenisField.getValue()!== null){rawat_jenis_create = rawat_jenisField.getValue();} 
		if(rawat_kontribusiField.getValue()!== null){rawat_kontribusi_create = rawat_kontribusiField.getValue();} 
		if(rawat_kategoriField.getValue()!== null){rawat_kategori_create = rawat_kategoriField.getValue();} 
		if(rawat_keteranganField.getValue()!== null){rawat_keterangan_create = rawat_keteranganField.getValue();} 
		if(rawat_duField.getValue()!== null){rawat_du_create = rawat_duField.getValue();} 
		if(rawat_dmField.getValue()!== null){rawat_dm_create = rawat_dmField.getValue();}
		if(rawat_dultahField.getValue()!== null){rawat_dultah_create = rawat_dultahField.getValue();}
		if(rawat_dcardField.getValue()!== null){rawat_dcard_create = rawat_dcardField.getValue();}
		if(rawat_dkolegaField.getValue()!== null){rawat_dkolega_create = rawat_dkolegaField.getValue();} 
		if(rawat_dkeluargaField.getValue()!== null){rawat_dkeluarga_create = rawat_dkeluargaField.getValue();}
		if(rawat_downerField.getValue()!== null){rawat_downer_create = rawat_downerField.getValue();} 
		if(rawat_dgroomingField.getValue()!== null){rawat_dgrooming_create = rawat_dgroomingField.getValue();} 
		if(rawat_dwartawanField.getValue()!== null){rawat_dwartawan_create = rawat_dwartawanField.getValue();}
		if(rawat_dstaffdokterField.getValue()!== null){rawat_dstaffdokter_create = rawat_dstaffdokterField.getValue();}
		if(rawat_dstaffnondokterField.getValue()!== null){rawat_dstaffnondokter_create = rawat_dstaffnondokterField.getValue();}
		if(rawat_dpromoField.getValue()!== null){rawat_dpromo_create = rawat_dpromoField.getValue();}
		if(rawat_pointField.getValue()!== null){rawat_point_create = rawat_pointField.getValue();}
		if(rawat_durasiField.getValue()!== null){rawat_durasi_create = rawat_durasiField.getValue();}
		if(rawat_kreditField.getValue()!== null){rawat_kredit_create = rawat_kreditField.getValue();} 
		if(rawat_kreditrpField.getValue()!== null){rawat_kreditrp_create = rawat_kreditrpField.getValue();} 
		if(rawat_hargaField.getValue()!== null){rawat_harga_create = convertToNumber(rawat_hargaField.getValue());}
		if(rawat_harga_kiField.getValue()!== null){rawat_harga_createki = convertToNumber(rawat_harga_kiField.getValue());}
		if(rawat_harga_mdnField.getValue()!== null){rawat_harga_createmdn = convertToNumber(rawat_harga_mdnField.getValue());}
		if(rawat_harga_mndField.getValue()!== null){rawat_harga_createmnd = convertToNumber(rawat_harga_mndField.getValue());}
		if(rawat_harga_mtaField.getValue()!== null){rawat_harga_createmta = convertToNumber(rawat_harga_mtaField.getValue());}
		if(rawat_harga_ygkField.getValue()!== null){rawat_harga_createygk = convertToNumber(rawat_harga_ygkField.getValue());}
		if(rawat_harga_lbkField.getValue()!== null){rawat_harga_createlbk = convertToNumber(rawat_harga_lbkField.getValue());}
		if(rawat_harga_hrField.getValue()!== null){rawat_harga_createhr = convertToNumber(rawat_harga_hrField.getValue());}
		if(rawat_harga_tpField.getValue()!== null){rawat_harga_createtp = convertToNumber(rawat_harga_tpField.getValue());}
		if(rawat_harga_dpsField.getValue()!== null){rawat_harga_createdps = convertToNumber(rawat_harga_dpsField.getValue());}
		if(rawat_harga_jktField.getValue()!== null){rawat_harga_createjkt = convertToNumber(rawat_harga_jktField.getValue());}
		if(rawat_harga_blpnField.getValue()!== null){rawat_harga_createblpn = convertToNumber(rawat_harga_blpnField.getValue());}
		if(rawat_harga_kutaField.getValue()!== null){rawat_harga_createkuta = convertToNumber(rawat_harga_kutaField.getValue());}
		if(rawat_harga_btmField.getValue()!== null){rawat_harga_createbtm = convertToNumber(rawat_harga_btmField.getValue());}
		if(rawat_harga_smgField.getValue()!== null){rawat_harga_createsmg = convertToNumber(rawat_harga_smgField.getValue());}
		if(rawat_harga_mksField.getValue()!== null){rawat_harga_createmks = convertToNumber(rawat_harga_mksField.getValue());}
		if(rawat_harga_mlgField.getValue()!== null){rawat_harga_createmlg = convertToNumber(rawat_harga_mlgField.getValue());}
		
		//if(rawat_jumlah_tindakanField.getValue()!== null){rawat_jumlah_tindakan_create = rawat_jumlah_tindakanField.getValue();} 
		if(rawat_gudangField.getValue()!== null){rawat_gudang_create = rawat_gudangField.getValue();} 
		if(rawat_aktifField.getValue()!== null){rawat_aktif_create = rawat_aktifField.getValue();} 

		Ext.Ajax.request({  
			waitMsg: 'Mohon tunggu...',
			url: 'index.php?c=c_perawatan&m=get_action',
			params: {
				task: perawatan_post2db,
				rawat_id	: rawat_id_create_pk, 
				rawat_kode	: rawat_kode_create, 
				rawat_kodelama	: rawat_kodelama_create, 
				rawat_nama	: rawat_nama_create, 
				rawat_highmargin : rawat_highmarginField.getValue(),
				rawat_edit_harga : rawat_edit_hargaField.getValue(),
				rawat_group	: rawat_group_create, 
				rawat_kategori	: rawat_kategori_create,
				rawat_kontribusi : rawat_kontribusi_create,
				rawat_jenis	: rawat_jenis_create, 
				rawat_keterangan	: rawat_keterangan_create, 
				rawat_du	: rawat_du_create, 
				rawat_dm	: rawat_dm_create, 
				rawat_dultah: rawat_dultah_create,
				rawat_dcard : rawat_dcard_create,
				rawat_dkolega : rawat_dkolega_create,
				rawat_dkeluarga : rawat_dkeluarga_create,
				rawat_downer	: rawat_downer_create,
				rawat_dgrooming	: rawat_dgrooming_create,
				rawat_dwartawan	: rawat_dwartawan_create,
				rawat_dstaffdokter	: rawat_dstaffdokter_create,
				rawat_dstaffnondokter	: rawat_dstaffnondokter_create,
				rawat_dpromo	: rawat_dpromo_create,
				rawat_point	: rawat_point_create,
				rawat_durasi: rawat_durasi_create,
				rawat_kredit : rawat_kredit_create,
				rawat_kreditrp : rawat_kreditrp_create,
				rawat_jumlah_tindakan : rawat_jumlah_tindakan_create,
				rawat_harga	: rawat_harga_create, 
				rawat_harga_mta : rawat_harga_createmta,
				rawat_harga_ki : rawat_harga_createki,
				rawat_harga_mdn : rawat_harga_createmdn,
				rawat_harga_mnd : rawat_harga_createmnd,
				rawat_harga_ygk : rawat_harga_createygk,
				rawat_harga_lbk : rawat_harga_createlbk,
				rawat_harga_hr  : rawat_harga_createhr,
				rawat_harga_tp	: rawat_harga_createtp,
				rawat_harga_dps	: rawat_harga_createdps,
				rawat_harga_jkt	: rawat_harga_createjkt,
				rawat_harga_blpn: rawat_harga_createblpn,
				rawat_harga_kuta: rawat_harga_createkuta,
				rawat_harga_btm: rawat_harga_createbtm,
				rawat_harga_smg: rawat_harga_createsmg,
				rawat_harga_mks: rawat_harga_createmks,
				rawat_harga_mlg: rawat_harga_createmlg,
				rawat_gudang	: rawat_gudang_create, 
				rawat_aktif	: rawat_aktif_create, 
				rawat_aktif_th : rawat_aktif_thField.getValue(),
				rawat_aktif_ki : rawat_aktif_kiField.getValue(),
				rawat_aktif_hr : rawat_aktif_hrField.getValue(),
				rawat_aktif_tp : rawat_aktif_tpField.getValue(),
				rawat_aktif_dps : rawat_aktif_dpsField.getValue(),
				rawat_aktif_jkt : rawat_aktif_jktField.getValue(),
				rawat_aktif_mta : rawat_aktif_mtaField.getValue(),
				rawat_aktif_blpn : rawat_aktif_blpnField.getValue(),
				rawat_aktif_kuta : rawat_aktif_kutaField.getValue(),
				rawat_aktif_btm : rawat_aktif_btmField.getValue(),
				rawat_aktif_mks : rawat_aktif_mksField.getValue(),
				rawat_aktif_mdn : rawat_aktif_mdnField.getValue(),
				rawat_aktif_lbk : rawat_aktif_lbkField.getValue(),
				rawat_aktif_mnd : rawat_aktif_mndField.getValue(),
				rawat_aktif_ygk : rawat_aktif_ygkField.getValue(),
				rawat_aktif_mlg : rawat_aktif_mlgField.getValue(),
				rawat_aktif_smg : rawat_aktif_smgField.getValue()
			}, 
			success: function(response){             			
				var result=eval(response.responseText);
				if(result!==0){
						perawatanListEditorGrid.getStore().reload();
						Ext.MessageBox.alert(perawatan_post2db+' OK','Data perawatan berhasil disimpan');
						perawatan_konsumsi_insert(result);
						perawatan_alat_insert(result);
						perawatan_createWindow.hide();
				}else{
						Ext.MessageBox.show({
						   title: 'Warning',
						   //msg: 'We could\'t not '+msg+' the Master_order_beli.',
						   msg: 'Data perawatan tidak bisa disimpan !',
						   buttons: Ext.MessageBox.OK,
						   animEl: 'save',
						   icon: Ext.MessageBox.WARNING
						});
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
				msg: 'Form anda belum lengkap',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
 	/* End of Function */
  
  	/* Function for get PK field */
	function get_pk_id(){
		if(perawatan_post2db=='UPDATE')
			return perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_id');
		else if(perawatan_post2db=='CREATE')
			return rawat_idField.getValue();
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function perawatan_reset_form(){
		rawat_idField.reset();
		rawat_idField.setValue(null);
		rawat_kodeField.reset();
		rawat_kodeField.setValue(null);
		rawat_kodelamaField.reset();
		rawat_kodelamaField.setValue(null);
		rawat_namaField.reset();
		rawat_namaField.setValue(null);
		rawat_highmarginField.reset();
		rawat_highmarginField.setValue(null);
		rawat_edit_hargaField.reset();
		rawat_edit_hargaField.setValue(null);
		rawat_groupField.reset();
		rawat_groupField.setValue(null);
		rawat_jenisField.reset();
		rawat_jenisField.setValue(null);
		rawat_kontribusiField.reset();
		rawat_kontribusiField.setValue(null);
		rawat_kategoriField.reset();
		rawat_kategoriField.setValue(null);
		rawat_kontribusiField.reset();
		rawat_kontribusiField.setValue(null);
		rawat_keteranganField.reset();
		rawat_keteranganField.setValue(null);
		rawat_duField.reset();
		rawat_duField.setValue(null);
		rawat_dmField.reset();
		rawat_dmField.setValue(null);
		rawat_dultahField.reset();
		rawat_dultahField.setValue(null);
		rawat_dcardField.reset();
		rawat_dcardField.setValue(null);
		rawat_dkolegaField.reset();
		rawat_dkolegaField.setValue(null);
		rawat_dkeluargaField.reset();
		rawat_dkeluargaField.setValue(null);
		rawat_downerField.reset();
		rawat_downerField.setValue(null);
		rawat_dgroomingField.reset();
		rawat_dgroomingField.setValue(null);
		rawat_dwartawanField.reset();
		rawat_dwartawanField.setValue(null);
		rawat_dstaffdokterField.reset();
		rawat_dstaffdokterField.setValue(null);
		rawat_dstaffnondokterField.reset();
		rawat_dstaffnondokterField.setValue(null);
		rawat_dpromoField.reset();
		rawat_dpromoField.setValue(null);
		rawat_pointField.reset();
		rawat_pointField.setValue(null);
		rawat_durasiField.reset();
		rawat_durasiField.setValue(null);
		rawat_kreditField.reset();
		rawat_kreditField.setValue(null);
		rawat_kreditrpField.reset();
		rawat_kreditrpField.setValue(null);
		//rawat_jumlah_tindakanField.reset();
		//rawat_jumlah_tindakanField.setValue(null);
		rawat_hargaField.reset();
		rawat_hargaField.setValue(null);
		rawat_harga_thField.reset();
		rawat_harga_thField.setValue(null);
		rawat_harga_kiField.reset();
		rawat_harga_kiField.setValue(null);
		rawat_harga_hrField.reset();
		rawat_harga_hrField.setValue(null);
		rawat_harga_tpField.reset();
		rawat_harga_tpField.setValue(null);
		rawat_harga_dpsField.reset();
		rawat_harga_dpsField.setValue(null);
		rawat_harga_jktField.reset();
		rawat_harga_jktField.setValue(null);
		rawat_harga_mtaField.reset();
		rawat_harga_mtaField.setValue(null);
		rawat_harga_blpnField.reset();
		rawat_harga_blpnField.setValue(null);
		rawat_harga_kutaField.reset();
		rawat_harga_kutaField.setValue(null);
		rawat_harga_btmField.reset();
		rawat_harga_btmField.setValue(null);
		rawat_harga_mksField.reset();
		rawat_harga_mksField.setValue(null);
		rawat_harga_mdnField.reset();
		rawat_harga_mdnField.setValue(null);
		rawat_harga_lbkField.reset();
		rawat_harga_lbkField.setValue(null);
		rawat_harga_mndField.reset();
		rawat_harga_mndField.setValue(null);
		rawat_harga_ygkField.reset();
		rawat_harga_ygkField.setValue(null);		
		rawat_harga_mlgField.reset();
		rawat_harga_mlgField.setValue(null);
		rawat_harga_smgField.reset();
		rawat_harga_smgField.setValue(null);
		rawat_hargaField.setValue(0);
		rawat_harga_thField.setValue(0);
		rawat_harga_mlgField.setValue(0);
		rawat_harga_smgField.setValue(0);
		rawat_harga_mksField.setValue(0);
		rawat_harga_mdnField.setValue(0);
		rawat_harga_mndField.setValue(0);
		rawat_harga_kiField.setValue(0);
		rawat_harga_mtaField.setValue(0);
		rawat_harga_ygkField.setValue(0);
		rawat_harga_lbkField.setValue(0);
		rawat_harga_kutaField.setValue(0);
		rawat_harga_btmField.setValue(0);
		rawat_harga_blpnField.setValue(0);
		rawat_harga_hrField.setValue(0);
		rawat_harga_tpField.setValue(0);
		rawat_harga_dpsField.setValue(0);
		rawat_harga_jktField.setValue(0);
		rawat_harga_checkField.reset();
		rawat_harga_checkField.setValue(false);
		
		rawat_gudangField.reset();
		rawat_gudangField.setValue(null);
		rawat_aktifField.reset();
		rawat_aktifField.setValue('Aktif');
		rawat_aktif_thField.reset();
		rawat_aktif_thField.setValue(false);
		rawat_aktif_kiField.reset();
		rawat_aktif_kiField.setValue(false);
		rawat_aktif_hrField.reset();
		rawat_aktif_hrField.setValue(false);
		rawat_aktif_tpField.reset();
		rawat_aktif_tpField.setValue(false);
		rawat_aktif_dpsField.reset();
		rawat_aktif_dpsField.setValue(false);
		rawat_aktif_jktField.reset();
		rawat_aktif_jktField.setValue(false);
		rawat_aktif_mtaField.reset();
		rawat_aktif_mtaField.setValue(false);
		rawat_aktif_blpnField.reset();
		rawat_aktif_blpnField.setValue(false);
		rawat_aktif_kutaField.reset();
		rawat_aktif_kutaField.setValue(false);
		rawat_aktif_btmField.reset();
		rawat_aktif_btmField.setValue(false);
		rawat_aktif_mksField.reset();
		rawat_aktif_mksField.setValue(false);
		rawat_aktif_mdnField.reset();
		rawat_aktif_mdnField.setValue(false);
		rawat_aktif_lbkField.reset();
		rawat_aktif_lbkField.setValue(false);
		rawat_aktif_mndField.reset();
		rawat_aktif_mndField.setValue(false);
		rawat_aktif_ygkField.reset();
		rawat_aktif_ygkField.setValue(false);		
		rawat_aktif_mlgField.reset();
		rawat_aktif_mlgField.setValue(false);
		rawat_aktif_smgField.reset();
		rawat_aktif_smgField.setValue(false);
		rawat_aktif_checkField.reset();
		rawat_aktif_checkField.setValue(false);
		combo_rawat_produk.reset();
		combo_rawat_produk.reset();
		
		//cbo_satuan_produkDataStore.setBaseParam('master_id',-1);
		//cbo_satuan_produkDataStore.load();
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function perawatan_set_form(){
		rawat_idField.setValue(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_id'));
		rawat_kodeField.setValue(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_kode'));
		rawat_kodelamaField.setValue(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_kodelama'));
		rawat_namaField.setValue(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_nama'));
		rawat_highmarginField.setValue(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_highmargin'));
		rawat_edit_hargaField.setValue(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_edit_harga'));
		rawat_groupField.setValue(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_group'));
		rawat_jenisField.setValue(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_jenis'));
		rawat_kontribusiField.setValue(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_kontribusi'));
		rawat_kategoriField.setValue(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_kategori_id'));
		rawat_kategoritxtField.setValue(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_kategori_nama'));
		rawat_keteranganField.setValue(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_keterangan'));
		rawat_duField.setValue(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_du'));
		rawat_dmField.setValue(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_dm'));
		rawat_dultahField.setValue(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_dultah'));
		rawat_dcardField.setValue(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_dcard'));
		rawat_dkolegaField.setValue(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_dkolega'));
		rawat_dkeluargaField.setValue(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_dkeluarga'));
		rawat_downerField.setValue(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_downer'));
		rawat_dgroomingField.setValue(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_dgrooming'));
		rawat_dwartawanField.setValue(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_dwartawan'));
		rawat_dstaffdokterField.setValue(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_dstaffdokter'));
		rawat_dstaffnondokterField.setValue(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_dstaffnondokter'));
		rawat_dpromoField.setValue(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_dpromo'));
		rawat_pointField.setValue(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_point'));
		rawat_durasiField.setValue(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_durasi'));
		rawat_kreditField.setValue(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_kredit'));
		rawat_kreditrpField.setValue(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_kreditrp'));
		rawat_hargaField.setValue(CurrencyFormatted(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_harga')));
		rawat_harga_thField.setValue(CurrencyFormatted(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_harga')));		
		rawat_harga_kiField.setValue(CurrencyFormatted(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_harga_ki')));
		rawat_harga_mtaField.setValue(CurrencyFormatted(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_harga_mta')));
		rawat_harga_lbkField.setValue(CurrencyFormatted(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_harga_lbk')));
		rawat_harga_hrField.setValue(CurrencyFormatted(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_harga_hr')));
		rawat_harga_mdnField.setValue(CurrencyFormatted(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_harga_mdn')));
		rawat_harga_mndField.setValue(CurrencyFormatted(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_harga_mnd')));
		rawat_harga_ygkField.setValue(CurrencyFormatted(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_harga_ygk')));
		
		rawat_harga_tpField.setValue(CurrencyFormatted(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_harga_tp')));
		rawat_harga_dpsField.setValue(CurrencyFormatted(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_harga_dps')));
		rawat_harga_jktField.setValue(CurrencyFormatted(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_harga_jkt')));
		rawat_harga_blpnField.setValue(CurrencyFormatted(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_harga_blpn')));
		rawat_harga_kutaField.setValue(CurrencyFormatted(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_harga_kuta')));
		rawat_harga_btmField.setValue(CurrencyFormatted(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_harga_btm')));
		rawat_harga_smgField.setValue(CurrencyFormatted(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_harga_smg')));
		rawat_harga_mksField.setValue(CurrencyFormatted(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_harga_mks')));
		rawat_harga_mlgField.setValue(CurrencyFormatted(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_harga_mlg')));
		//rawat_jumlah_tindakanField.setValue(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_jumlah_tindakan'));
		rawat_gudangField.setValue(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_gudang'));
		rawat_aktifField.setValue(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_aktif'));
		
		if(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_aktif_cabang').charAt(0)=="1")	
			rawat_aktif_thField.setValue(true);	
		if(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_aktif_cabang').charAt(0)=="0")
			rawat_aktif_thField.setValue(false);
		
		if(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_aktif_cabang').charAt(1)=="1")	
			rawat_aktif_kiField.setValue(true);	
		if(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_aktif_cabang').charAt(1)=="0")
			rawat_aktif_kiField.setValue(false);
		
		if(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_aktif_cabang').charAt(2)=="1")	
			rawat_aktif_hrField.setValue(true);	
		if(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_aktif_cabang').charAt(2)=="0")
			rawat_aktif_hrField.setValue(false);
		
		if(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_aktif_cabang').charAt(3)=="1")
			rawat_aktif_tpField.setValue(true);	
		if(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_aktif_cabang').charAt(3)=="0")
			rawat_aktif_tpField.setValue(false);
		
		if(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_aktif_cabang').charAt(4)=="1")	
			rawat_aktif_dpsField.setValue(true);	
		if(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_aktif_cabang').charAt(4)=="0")
			rawat_aktif_dpsField.setValue(false);
		
		if(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_aktif_cabang').charAt(5)=="1")	
			rawat_aktif_jktField.setValue(true);	
		if(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_aktif_cabang').charAt(5)=="0")
			rawat_aktif_jktField.setValue(false);
			
		if(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_aktif_cabang').charAt(6)=="1")	
			rawat_aktif_mtaField.setValue(true);	
		if(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_aktif_cabang').charAt(6)=="0")
			rawat_aktif_mtaField.setValue(false);
		
		if(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_aktif_cabang').charAt(7)=="1")	
			rawat_aktif_blpnField.setValue(true);	
		if(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_aktif_cabang').charAt(7)=="0")
			rawat_aktif_blpnField.setValue(false);
		
		if(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_aktif_cabang').charAt(8)=="1")	
			rawat_aktif_kutaField.setValue(true);	
		if(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_aktif_cabang').charAt(8)=="0")
			rawat_aktif_kutaField.setValue(false);
		
		if(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_aktif_cabang').charAt(10)=="1")	
			rawat_aktif_mksField.setValue(true);	
		if(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_aktif_cabang').charAt(10)=="0")
			rawat_aktif_mksField.setValue(false);
		
		if(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_aktif_cabang').charAt(11)=="1")	
			rawat_aktif_mdnField.setValue(true);	
		if(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_aktif_cabang').charAt(11)=="0")
			rawat_aktif_mdnField.setValue(false);
		
		if(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_aktif_cabang').charAt(12)=="1")	
			rawat_aktif_lbkField.setValue(true);	
		if(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_aktif_cabang').charAt(12)=="0")
			rawat_aktif_lbkField.setValue(false);
		
		if(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_aktif_cabang').charAt(13)=="1")
			rawat_aktif_mndField.setValue(true);	
		if(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_aktif_cabang').charAt(13)=="0")
			rawat_aktif_mndField.setValue(false);
		
		if(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_aktif_cabang').charAt(14)=="1")	
			rawat_aktif_ygkField.setValue(true);	
		if(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_aktif_cabang').charAt(14)=="0")
			rawat_aktif_ygkField.setValue(false);
			
		if(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_aktif_cabang').charAt(15)=="1")	
			rawat_aktif_mlgField.setValue(true);	
		if(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_aktif_cabang').charAt(15)=="0")
			rawat_aktif_mlgField.setValue(false);	
			
		if(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_aktif_cabang').charAt(16)=="1")	
			rawat_aktif_btmField.setValue(true);	
		if(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_aktif_cabang').charAt(16)=="0")
			rawat_aktif_btmField.setValue(false);
			
		if(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_aktif_cabang').charAt(20)=="1")	
			rawat_aktif_smgField.setValue(true);	
		if(perawatanListEditorGrid.getSelectionModel().getSelected().get('rawat_aktif_cabang').charAt(20)=="0")
			rawat_aktif_smgField.setValue(false);
		
		cbo_rawat_produkDataStore.setBaseParam('query',get_pk_id());
		cbo_rawat_produkDataStore.load();
		cbo_rawat_alatDataStore.load();
		
		cbo_satuan_produkDataStore.setBaseParam('task','detail');
		cbo_satuan_produkDataStore.setBaseParam('master_id',get_pk_id());
		cbo_satuan_produkDataStore.load();
		
		perawatan_konsumsi_DataStore.setBaseParam('master_id',get_pk_id());
		perawatan_konsumsi_DataStore.load();
		perawatan_alat_DataStore.load({params : {master_id : get_pk_id(), start:0, limit:perawatan_pageS}});
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_perawatan_form_valid(){
		return (rawat_namaField.isValid() && rawat_groupField.isValid() && rawat_jenisField.isValid() && rawat_gudangField.isValid() );
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!perawatan_createWindow.isVisible()){
			perawatan_reset_form();
			perawatan_konsumsi_DataStore.load({params:{master_id:0}});
			perawatan_post2db='CREATE';
			msg='created';
			perawatan_createWindow.show();
		} else {
			perawatan_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function perawatan_confirm_delete(){
		// only one perawatan is selected here
		if(perawatanListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', perawatan_delete);
		} else if(perawatanListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', perawatan_delete);
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
	function perawatan_confirm_update(){
		/* only one record is selected here */
		if(perawatanListEditorGrid.selModel.getCount() == 1) {
			perawatan_post2db='UPDATE';
			perawatan_set_form();
			msg='updated';
			perawatan_createWindow.show();
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
	function perawatan_delete(btn){
		if(btn=='yes'){
			var selections = perawatanListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< perawatanListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.rawat_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_perawatan&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							perawatan_DataStore.reload();
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
  
	/* Function for Retrieve DataStore */
	perawatan_DataStore = new Ext.data.Store({
		id: 'perawatan_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_perawatan&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST",start:0,limit:perawatan_pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'rawat_id'
		},[
			{name: 'rawat_id', type: 'int', mapping: 'rawat_id'}, 
			{name: 'rawat_kode', type: 'string', mapping: 'rawat_kode'}, 
			{name: 'rawat_kodelama', type: 'string', mapping: 'rawat_kodelama'}, 
			{name: 'rawat_nama', type: 'string', mapping: 'rawat_nama'}, 
			{name: 'rawat_highmargin', type: 'int', mapping: 'rawat_highmargin'}, 
			{name: 'rawat_edit_harga', type: 'int', mapping: 'rawat_edit_harga'}, 
			{name: 'rawat_group', type: 'string', mapping: 'group_nama'}, 
			{name: 'rawat_kategori_nama', type: 'string', mapping: 'kategori_nama'},
			{name: 'rawat_kategori_id', type: 'string', mapping: 'rawat_kategori'},
			{name: 'rawat_kontribusi', type: 'string', mapping: 'kategori2_nama'}, 
			{name: 'rawat_jenis', type: 'string', mapping: 'jenis_nama'}, 
			{name: 'rawat_keterangan', type: 'string', mapping: 'rawat_keterangan'}, 
			{name: 'rawat_du', type: 'int', mapping: 'rawat_du'}, 
			{name: 'rawat_dm', type: 'int', mapping: 'rawat_dm'}, 
			{name: 'rawat_dultah', type: 'int', mapping: 'rawat_dultah'}, 
			{name: 'rawat_dcard', type: 'int', mapping: 'rawat_dcard'}, 
			{name: 'rawat_dkolega', type: 'int', mapping: 'rawat_dkolega'},
			{name: 'rawat_dkeluarga', type: 'int', mapping: 'rawat_dkeluarga'}, 
			{name: 'rawat_downer', type: 'int', mapping: 'rawat_downer'}, 
			{name: 'rawat_dgrooming', type: 'int', mapping: 'rawat_dgrooming'}, 
			{name: 'rawat_dwartawan', type: 'int', mapping: 'rawat_dwartawan'}, 
			{name: 'rawat_dstaffdokter', type: 'int', mapping: 'rawat_dstaffdokter'}, 
			{name: 'rawat_dstaffnondokter', type: 'int', mapping: 'rawat_dstaffnondokter'}, 
			{name: 'rawat_dpromo', type: 'int', mapping: 'rawat_dpromo'}, 
			{name: 'rawat_point', type: 'int', mapping: 'rawat_point'},
			{name: 'rawat_durasi', tupe: 'int', mapping: 'rawat_durasi'},
			{name: 'rawat_kredit', type: 'int', mapping: 'rawat_kredit'},
			{name: 'rawat_kreditrp', type: 'float', mapping: 'rawat_kreditrp'},
			{name: 'rawat_jumlah_tindakan', type: 'int', mapping: 'rawat_jumlah_tindakan'},			
			{name: 'rawat_harga', type: 'float', mapping: 'rawat_harga'}, 
			{name: 'rawat_gudang', type: 'string', mapping: 'gudang_nama'}, 
			{name: 'rawat_aktif', type: 'string', mapping: 'rawat_aktif'}, 
			{name: 'rawat_creator', type: 'string', mapping: 'rawat_creator'}, 
			{name: 'rawat_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'rawat_date_create'}, 
			{name: 'rawat_update', type: 'string', mapping: 'rawat_update'}, 
			{name: 'rawat_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'rawat_date_update'}, 
			{name: 'rawat_revised', type: 'int', mapping: 'rawat_revised'},
			{name: 'rawat_aktif_cabang', type: 'string', mapping: 'rawat_aktif_cabang'},
			{name: 'rawat_harga_ki', type: 'float', mapping: 'rawat_harga_ki'},
			{name: 'rawat_harga_mnd', type: 'float', mapping: 'rawat_harga_mnd'},
			{name: 'rawat_harga_mdn', type: 'float', mapping: 'rawat_harga_mdn'},
			{name: 'rawat_harga_ygk', type: 'float', mapping: 'rawat_harga_ygk'},
			{name: 'rawat_harga_mta', type: 'float', mapping: 'rawat_harga_mta'},
			{name: 'rawat_harga_lbk', type: 'float', mapping: 'rawat_harga_lbk'},
			{name: 'rawat_harga_hr', type: 'float', mapping: 'rawat_harga_hr'},
			{name: 'rawat_harga_tp', type: 'float', mapping: 'rawat_harga_tp'},
			{name: 'rawat_harga_dps', type: 'float', mapping: 'rawat_harga_dps'},
			{name: 'rawat_harga_blpn', type: 'float', mapping: 'rawat_harga_blpn'},
			{name: 'rawat_harga_kuta', type: 'float', mapping: 'rawat_harga_kuta'},
			{name: 'rawat_harga_btm', type: 'float', mapping: 'rawat_harga_btm'},
			{name: 'rawat_harga_jkt', type: 'float', mapping: 'rawat_harga_jkt'},
			{name: 'rawat_harga_smg', type: 'float', mapping: 'rawat_harga_smg'},
			{name: 'rawat_harga_mks', type: 'float', mapping: 'rawat_harga_mks'},
			{name: 'rawat_harga_mlg', type: 'float', mapping: 'rawat_harga_mlg'}
		]),
		sortInfo:{field: 'rawat_id', direction: "DESC"}
	});
	/* End of Function */
	
	/* Datastore Rawat Group*/
	cbo_rawat_groupDataStore = new Ext.data.Store({
		id: 'cbo_rawat_groupDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_perawatan&m=get_group_perawatan_list', 
			method: 'POST'
		}),
		baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'group_id'
		},[
		/* dataIndex => insert intocustomer_note_ColumnModel, Mapping => for initiate table column */ 
			{name: 'rawat_group_value', type: 'int', mapping: 'group_id'},
			{name: 'rawat_group_display', type: 'string', mapping: 'group_nama'},
			{name: 'rawat_group_durawat', type: 'int', mapping: 'group_durawat'},
			{name: 'rawat_group_dmrawat', type: 'int', mapping: 'group_dmrawat'},
			{name: 'rawat_group_dultah', type: 'int', mapping: 'group_dultah'},
			{name: 'rawat_group_dcard', type: 'int', mapping: 'group_dcard'},
			{name: 'rawat_group_dkolega', type: 'int', mapping: 'group_dkolega'},
			{name: 'rawat_group_dkeluarga', type: 'int', mapping: 'group_dkeluarga'},
			{name: 'rawat_group_downer', type: 'int', mapping: 'group_downer'},
			{name: 'rawat_group_dgrooming', type: 'int', mapping: 'group_dgrooming'},
			{name: 'rawat_group_dwartawan', type: 'int', mapping: 'group_dwartawan'},
			{name: 'rawat_group_dstaffdokter', type: 'int', mapping: 'group_dstaffdokter'},
			{name: 'rawat_group_dstaffnondokter', type: 'int', mapping: 'group_dstaffnondokter'},
			{name: 'rawat_group_kelompok', type: 'string', mapping: 'kategori_nama'},
			{name: 'rawat_group_kelompok_id', type: 'int', mapping: 'kategori_id'}
		]),
		sortInfo:{field: 'rawat_group_display', direction: "ASC"}
	});
	
	/* Datastore Rawat kategori */
	cbo_rawat_jenisDataSore = new Ext.data.Store({
		id: 'cbo_rawat_jenisDataSore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_perawatan&m=get_jenis_perawatan_list', 
			method: 'POST'
		}),
		baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'jenis_id'
		},[
		/* dataIndex => insert intocustomer_note_ColumnModel, Mapping => for initiate table column */ 
			{name: 'rawat_jenis_value', type: 'int', mapping: 'jenis_id'},
			{name: 'rawat_jenis_display', type: 'string', mapping: 'jenis_nama'}
		]),
		sortInfo:{field: 'rawat_jenis_display', direction: "ASC"}
	});
	
	/* Datastore Rawat Kontribusi */
	cbo_rawat_kontribusiDataSore = new Ext.data.Store({
		id: 'cbo_rawat_kontribusiDataSore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_perawatan&m=get_kontribusi_rawat_list', 
			method: 'POST'
		}),
		baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'kategori2_id'
		},[
		/* dataIndex => insert intocustomer_note_ColumnModel, Mapping => for initiate table column */ 
			{name: 'rawat_kontribusi_value', type: 'string', mapping: 'kategori2_nama'},
			{name: 'rawat_kontribusi_display', type: 'string', mapping: 'kategori2_nama'}
		]),
		sortInfo:{field: 'rawat_kontribusi_display', direction: "ASC"}
	});
	
	/* Datastore Rawat Jenis */
	cbo_rawat_kategoriDataStore = new Ext.data.Store({
		id: 'cbo_rawat_kategoriDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_perawatan&m=get_kategori_perawatan_list', 
			method: 'POST'
		}),
		baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'kategori_id'
		},[
		/* dataIndex => insert intocustomer_note_ColumnModel, Mapping => for initiate table column */ 
			{name: 'rawat_kategori_value', type: 'int', mapping: 'kategori_id'},
			{name: 'rawat_kategori_display', type: 'string', mapping: 'kategori_nama'}
		]),
		sortInfo:{field: 'rawat_kategori_display', direction: "ASC"}
	});
	
	/* Datastore Rawat Gudang */
	cbo_rawat_gudangDataSore = new Ext.data.Store({
		id: 'cbo_rawat_gudangDataSore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_perawatan&m=get_gudang_list', 
			method: 'POST'
		}),
		baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'gudang_id'
		},[
		/* dataIndex => insert intocustomer_note_ColumnModel, Mapping => for initiate table column */ 
			{name: 'rawat_gudang_value', type: 'int', mapping: 'gudang_id'},
			{name: 'rawat_gudang_display', type: 'string', mapping: 'gudang_nama'}
		]),
		sortInfo:{field: 'rawat_gudang_display', direction: "ASC"}
	});
    
  	/* Function for Identify of Window Column Model */
	perawatan_ColumnModel = new Ext.grid.ColumnModel(
		[/*{
			header: '#',
			readOnly: true,
			dataIndex: 'rawat_id',
			width: 70,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: false
		},*/
		{
			header: '<div align="center">' + 'Kode Baru' + '</div>',
			dataIndex: 'rawat_kode',
			width: 70,
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">' + 'Nama Perawatan' + '</div>',
			dataIndex: 'rawat_nama',
			width: 220,
			sortable: true
		}, 
		{
			header: '<div align="center">' + 'Group 1' + '</div>',
			dataIndex: 'rawat_group',
			width: 100,
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">' + 'Group 2' + '</div>',
			dataIndex: 'rawat_jenis',
			width: 100,
			sortable: true,
			readOnly: true
		}, 
		{
			header: '<div align="center">' + 'Jenis' + '</div>',
			dataIndex: 'rawat_kategori_nama',
			width: 70,	//150,
			sortable: true,
			editable: false
		}, 
		{
			header: '<div align="center">' + 'Gudang' + '</div>',
			dataIndex: 'rawat_gudang',
			width: 80,
			sortable: true,
			readOnly: true
		}, 
		{
			header: '<div align="center">' + 'Harga (Rp)' + '</div>',
			dataIndex: 'rawat_harga',
			align: 'right',
			width: 60,	//150,
			sortable: true,
			readOnly: true,
			renderer: function(val){
				return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
			}
		}, 
		{
			header: '<div align="center">' + 'Poin' + '</div>',
			dataIndex: 'rawat_point',
			align: 'right',
			width: 40,	//100,
			sortable: true,
			readOnly: true
		},
		<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_PERAWATAN'))){ ?>
		{
			
			header: '<div align="center">' + 'Kr (Poin)' + '</div>',
			dataIndex: 'rawat_kredit',
			align: 'right',
			width: 60,	//100,
			sortable: true,
			readOnly: true
		},
		<?php } ?>
		<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_PERAWATAN'))){ ?>
		{
			header: '<div align="center">' + 'Kr (Rp)' + '</div>',
			dataIndex: 'rawat_kreditrp',
			align: 'right',
			width: 60,	//100,
			sortable: true,
			readOnly: true
			
		},
		<?php } ?>
		{
			header: '<div align="center">' + 'Status' + '</div>',
			dataIndex: 'rawat_aktif',
			width: 60,	//150,
			sortable: true,
			readOnly: true
		}, 
		{
			header: '<div align="center">' + 'Umum' + '</div>',
			align: 'right',
			dataIndex: 'rawat_du',
			width: 45,	//100,
			readOnly: true,
			renderer: function(val){
				return '<span>' + val + '</span>';
			}
		}, 
		{
			header: '<div align="center">' + 'Member' + '</div>',
			align: 'right',
			dataIndex: 'rawat_dm',
			width: 45,	//100,
			readOnly: true,
			renderer: function(val){
				return '<span>' + val + '</span>';
			}
		},
		{
			header: '<div align="center">' + 'Ultah' + '</div>',
			align: 'right',
			dataIndex: 'rawat_dultah',
			width: 45,	//100,
			readOnly: true,
			renderer: function(val){
				return '<span>' + val + '</span>';
			}
		}, 	
		{
			header: '<div align="center">' + 'Card' + '</div>',
			align: 'right',
			dataIndex: 'rawat_dcard',
			width: 45,	//100,
			readOnly: true,
			renderer: function(val){
				return '<span>' + val + '</span>';
			}
		}, 
		{
			header: '<div align="center">' + 'Kolega' + '</div>',
			align: 'right',
			dataIndex: 'rawat_dkolega',
			width: 45,	//100,
			readOnly: true,
			renderer: function(val){
				return '<span>' + val + '</span>';
			}
		}, 
		{
			header: '<div align="center">' + 'Klrga' + '</div>',
			align: 'right',
			dataIndex: 'rawat_dkeluarga',
			width: 45,	//100,
			readOnly: true,
			renderer: function(val){
				return '<span>' + val + '</span>';
			}
		}, 
		{
			header: '<div align="center">' + 'Owner' + '</div>',
			align: 'right',
			dataIndex: 'rawat_downer',
			width: 45,	//100,
			readOnly: true,
			renderer: function(val){
				return '<span>' + val + '</span>';
			}
		}, 
		{
			header: '<div align="center">' + 'Groom' + '</div>',
			align: 'right',
			dataIndex: 'rawat_dgrooming',
			width: 45,	//100,
			readOnly: true,
			renderer: function(val){
				return '<span>' + val + '</span>';
			}
		}, 
		
		{
			header: '<div align="center">' + 'Wrtwn' + '</div>',
			align: 'right',
			dataIndex: 'rawat_dwartawan',
			width: 45,	//100,
			readOnly: true,
			renderer: function(val){
				return '<span>' + val + '</span>';
			}
		}, 
		{
			header: '<div align="center">' + 'Staf Dr' + '</div>',
			align: 'right',
			dataIndex: 'rawat_dstaffdokter',
			width: 45,	//100,
			readOnly: true,
			renderer: function(val){
				return '<span>' + val + '</span>';
			}
		}, 
		{
			header: '<div align="center">' + 'Staf Non Dr' + '</div>',
			align: 'right',
			dataIndex: 'rawat_dstaffnondokter',
			width: 45,	//100,
			readOnly: true,
			renderer: function(val){
				return '<span>' + val + '</span>';
			}
		}, 
		{
			header: '<div align="center">' + 'Promo' + '</div>',
			align: 'right',
			dataIndex: 'rawat_dpromo',
			width: 45,	//100,
			readOnly: true,
			renderer: function(val){
				return '<span>' + val + '</span>';
			}
		}, 		
		{
			header: '<div align="center">' + 'Durasi' + '</div>',
			dataIndex: 'rawat_durasi',
			align: 'right',
			width: 40,	//100,
			sortable: true,
			readOnly: true,
			hidden: true
		}, 		
		{
			header: 'Creator',
			dataIndex: 'rawat_creator',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}, 
		{
			header: 'Create on',
			dataIndex: 'rawat_date_create',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}, 
		{
			header: 'Last Update by',
			dataIndex: 'rawat_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}, 
		{
			header: 'Last Update on',
			dataIndex: 'rawat_date_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}, 
		{
			header: 'Revised',
			dataIndex: 'rawat_revised',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}	]);
	
	perawatan_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	perawatanListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'perawatanListEditorGrid',
		el: 'fp_perawatan',
		title: 'Daftar Perawatan',
		autoHeight: true,
		store: perawatan_DataStore, // DataStore
		cm: perawatan_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1600,
		bbar: new Ext.PagingToolbar({
			pageSize: perawatan_pageS,
			hideParent:true,
			store: perawatan_DataStore,
			displayInfo: true
		}),
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_PERAWATAN'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<?php } ?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_PERAWATAN'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: perawatan_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_PERAWATAN'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: perawatan_confirm_delete   // Confirm before deleting
		}, '-', 
		<?php } ?>
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: perawatan_DataStore,
			params: {task: 'LIST',start: 0, limit: perawatan_pageS},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						perawatan_DataStore.baseParams={task:'LIST',start: 0, limit: perawatan_pageS};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Simple search:'});
				Ext.get(this.id).set({qtip:'- (Aktif only)<br>- Kode Baru<br>- Kode Lama<br>- Nama Perawatan<br>- Group 1<br>- Group 2<br>- Jenis'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: perawatan_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: perawatan_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: perawatan_print  
		}
		]
	});
	perawatanListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	perawatan_ContextMenu = new Ext.menu.Menu({
		id: 'perawatan_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_PERAWATAN'))){ ?>
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: perawatan_confirm_update 
		},
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_PERAWATAN'))){ ?>
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			disabled: true,
			handler: perawatan_confirm_delete 
		},
		'-',
		<?php } ?>
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: perawatan_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: perawatan_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onperawatan_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		perawatan_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		perawatan_SelectedRow=rowIndex;
		perawatan_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function perawatan_editContextMenu(){
		perawatanListEditorGrid.startEditing(perawatan_SelectedRow,1);
  	}
	/* End of Function */
  	
	perawatanListEditorGrid.addListener('rowcontextmenu', onperawatan_ListEditGridContextMenu);
	perawatan_DataStore.load({params: {start: 0, limit: perawatan_pageS}});	// load DataStore
	perawatanListEditorGrid.on('afteredit', perawatan_update); // inLine Editing Record
	
	/* Identify  rawat_id Field */
	rawat_idField= new Ext.form.NumberField({
		id: 'rawat_idField',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: false,
		hidden: true,
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  rawat_kode Field */
	rawat_kodeField= new Ext.form.TextField({
		id: 'rawat_kodeField',
		fieldLabel: 'Kode Baru',
		maxLength: 20,
		readOnly: false,
		emptyText: '(auto)',
		width: 100,
		maskRe: /([A-Z0-9]+)$/
	});
	/* Identify  rawat_kodelama Field */
	rawat_kodelamaField= new Ext.form.TextField({
		id: 'rawat_kodelamaField',
		fieldLabel: 'Kode Lama',
		maxLength: 20,
		width: 100
	});
	/* Identify  rawat_nama Field */
	rawat_namaField= new Ext.form.TextField({
		id: 'rawat_namaField',
		fieldLabel: 'Nama <span style="color: #ec0000">*</span>',
		maxLength: 250,
		allowBlank: false,
		anchor: '95%'
	});
	
	/* Identify rawat_highmargin Field*/
	rawat_highmarginField=new Ext.form.Checkbox({
		id : 'rawat_highmarginField',
		boxLabel: 'High Margin?',
		name: 'rawat_highmargin'
	});
	
	/* Identify rawat_edit_harga Field*/
	rawat_edit_hargaField=new Ext.form.Checkbox({
		id : 'rawat_edit_hargaField',
		boxLabel: 'Editable Harga?',
		name: 'rawat_edit_harga'
	});
	
	/* Identify  rawat_group Field */
	rawat_groupField= new Ext.form.ComboBox({
		id: 'rawat_groupField',
		fieldLabel: 'Group 1 <span style="color: #ec0000">*</span>',
		store: cbo_rawat_groupDataStore,
		mode: 'remote',
		editable:false,
		allowBlank: false,
		displayField: 'rawat_group_display',
		valueField: 'rawat_group_value',
		width: 120,
		triggerAction: 'all'
	});
	/* Identify  rawat_kategori Field */
	rawat_jenisField= new Ext.form.ComboBox({
		id: 'rawat_jenisField',
		fieldLabel: 'Group 2 <span style="color: #ec0000">*</span>',
		store: cbo_rawat_jenisDataSore,
		mode: 'remote',
		editable:false,
		allowBlank: false,
		displayField: 'rawat_jenis_display',
		valueField: 'rawat_jenis_value',
		width: 120,
		triggerAction: 'all'
	});
	rawat_kontribusiField= new Ext.form.ComboBox({
		id: 'rawat_kontribusiField',
		fieldLabel: 'Contribution Category',
		store: cbo_rawat_kontribusiDataSore,
		mode: 'remote',
		editable:false,
		displayField: 'rawat_kontribusi_display',
		valueField: 'rawat_kontribusi_value',
		triggerAction: 'all'
	});
	
	/* Identify  rawat_jenis Field */
	rawat_kategoriField= new Ext.form.NumberField();
	rawat_kategoritxtField= new Ext.form.TextField({
		id: 'rawat_kategoritxtField',
		fieldLabel: 'Jenis',
		disabled: true,
		width: 120
	});
	/* Identify  rawat_keterangan Field */
	rawat_keteranganField= new Ext.form.TextArea({
		id: 'rawat_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '95%'
	});
	/* Identify  rawat_du Field */
	rawat_duField= new Ext.form.NumberField({
		id: 'rawat_duField',
		name: 'rawat_duField',
		fieldLabel: 'Umum',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		allowBlank : true,
		enableKeyEvents : true,
		width: 45,
		maskRe: /([0-9]+)$/
	});
	/* Identify  rawat_dm Field */
	rawat_dmField= new Ext.form.NumberField({
		id: 'rawat_dmField',
		name: 'rawat_dmField',
		fieldLabel: 'Member',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		allowBlank : true,
		enableKeyEvents : true,
		width: 45,
		maskRe: /([0-9]+)$/
	});
	/* Identify  rawat_dultah Field */
	rawat_dultahField= new Ext.form.NumberField({
		id: 'rawat_dultahField',
		name: 'rawat_dultahField',
		fieldLabel: 'Ultah',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		allowBlank : true,
		enableKeyEvents : true,
		width: 45,
		maskRe: /([0-9]+)$/
	});
	/* Identify  rawat_dcard Field */
	rawat_dcardField= new Ext.form.NumberField({
		id: 'rawat_dcardField',
		name: 'rawat_dcardField',
		fieldLabel: 'Card',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		allowBlank : true,
		enableKeyEvents : true,
		width: 45,
		maskRe: /([0-9]+)$/
	});
	/* Identify  rawat_dkolega Field */
	rawat_dkolegaField= new Ext.form.NumberField({
		id: 'rawat_dkolegaField',
		name: 'rawat_dkolegaField',
		fieldLabel: 'Kolega',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		allowBlank : true,
		enableKeyEvents : true,
		width: 45,
		maskRe: /([0-9]+)$/
	});
	/* Identify  rawat_dkeluarga Field */
	rawat_dkeluargaField= new Ext.form.NumberField({
		id: 'rawat_dkeluargaField',
		name: 'rawat_dkeluargaField',
		fieldLabel: 'Keluarga',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		allowBlank : true,
		enableKeyEvents : true,
		width: 45,
		maskRe: /([0-9]+)$/
	});
	/* Identify  rawat_downer Field */
	rawat_downerField= new Ext.form.NumberField({
		id: 'rawat_downerField',
		name: 'rawat_downerField',
		fieldLabel: 'Owner',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		allowBlank : true,
		enableKeyEvents : true,
		width: 45,
		maskRe: /([0-9]+)$/
	});
	/* Identify  rawat_dgrooming Field */
	rawat_dgroomingField= new Ext.form.NumberField({
		id: 'rawat_dgroomingField',
		name: 'rawat_dgroomingField',
		fieldLabel: 'Grooming',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		allowBlank : true,
		enableKeyEvents : true,
		width: 45,
		maskRe: /([0-9]+)$/
	});
	/* Identify  rawat_dwartawan Field */
	rawat_dwartawanField= new Ext.form.NumberField({
		id: 'rawat_dwartawanField',
		name: 'rawat_dwartawanField',
		fieldLabel: 'Wartawan',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		allowBlank : true,
		enableKeyEvents : true,
		width: 45,
		maskRe: /([0-9]+)$/
	});
	/* Identify  rawat_dstaffdokter Field */
	rawat_dstaffdokterField= new Ext.form.NumberField({
		id: 'rawat_dstaffdokterField',
		name: 'rawat_dstaffdokterField',
		fieldLabel: 'Staf Dokter',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		allowBlank : true,
		enableKeyEvents : true,
		width: 45,
		maskRe: /([0-9]+)$/
	});
	/* Identify  rawat_dstaffnondokter Field */
	rawat_dstaffnondokterField= new Ext.form.NumberField({
		id: 'rawat_dstaffnondokterField',
		name: 'rawat_dstaffnondokterField',
		fieldLabel: 'Staf Non Dokter',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		allowBlank : true,
		enableKeyEvents : true,
		width: 45,
		maskRe: /([0-9]+)$/
	});
	/* Identify  rawat_dpromo Field */
	rawat_dpromoField= new Ext.form.NumberField({
		id: 'rawat_dpromoField',
		name: 'rawat_dpromoField',
		fieldLabel: 'Promo',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		allowBlank : true,
		enableKeyEvents : true,
		width: 45,
		maskRe: /([0-9]+)$/
	});
	/* Identify  rawat_point Field */
	rawat_pointField= new Ext.form.NumberField({
		id: 'rawat_pointField',
		name: 'rawat_pointField',
		fieldLabel: 'Poin (x)',
		allowNegatife : false,
		emptyText: '1',
		allowDecimals: false,
		width: 60,
		maskRe: /([0-9]+)$/
	});
	/* Identify  rawat_durasi Field */
	rawat_durasiField= new Ext.form.NumberField({
		id: 'rawat_durasiField',
		name: 'rawat_durasiField',
		fieldLabel: 'Durasi (dalam menit)',
		allowNegatife : false,
		//emptyText: '1',
		allowDecimals: false,
		width: 60,
		maskRe: /([0-9]+)$/
	});
	rawat_kreditField= new Ext.form.NumberField({
		id: 'rawat_kreditField',
		name: 'rawat_kreditField',
		fieldLabel: 'Kredit (Poin)',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		width: 60,
		maskRe: /([0-9]+)$/
	});
	/* Identify  rawat_harga Field */
	rawat_kreditrpField= new Ext.form.TextField({
		id: 'rawat_kreditrpField',
		name: 'rawat_kreditrpField',
		fieldLabel: 'Kredit (Rp)',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		allowBlank: true,
		width: 120,
		maskRe: /([0-9]+)$/
	});
	/*rawat_jumlah_tindakanField= new Ext.form.NumberField({
		id: 'rawat_jumlah_tindakanField',
		name: 'rawat_jumlah_tindakanField',
		fieldLabel: 'Sat.Jml.Tindakan',
		allowNegatife : false,
		emptyText: '1',
		allowBlank: true,
		allowDecimals: true,
		width: 60,
		maskRe: /([0-9]+)$/
	});*/
	/* Identify  rawat_harga Field */
	rawat_hargaField= new Ext.form.TextField({
		id: 'rawat_hargaField',
		name: 'rawat_hargaField',
		fieldLabel: 'Harga (Rp)',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		allowBlank: true,
		width: 120,
		maskRe: /([0-9]+)$/
	});
	/* Identify  rawat_gudang Field */
	rawat_gudangField= new Ext.form.ComboBox({
		id: 'rawat_gudangField',
		fieldLabel: 'Gudang',
		store: cbo_rawat_gudangDataSore,
		mode: 'remote',
		editable:false,
		allowBlank: false,
		displayField: 'rawat_gudang_display',
		valueField: 'rawat_gudang_value',
		width: 120,
		triggerAction: 'all'
	});
	/* Identify  rawat_aktif Field */
	rawat_aktifField= new Ext.form.ComboBox({
		id: 'rawat_aktifField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['rawat_aktif_value', 'rawat_aktif_display'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		editable:false,
		displayField: 'rawat_aktif_display',
		valueField: 'rawat_aktif_value',
		//anchor: '95%',
		width: 80,
		triggerAction: 'all'	
	});
	/* Identify Paket Aktif*/
	rawat_aktif_thField=new Ext.form.Checkbox({
		id : 'rawat_aktif_thField',
		boxLabel: 'TH',
		maxLength: 250,
		name: 'rawat_aktif_th',
		handler: function(node,checked){
			if (checked) {
				rawat_aktifField.setValue('Aktif');
				//Ext.Msg.alert('Status', 'Changes saved successfully.');
			}
			else {
				rawat_aktifField.setValue('Tidak Aktif');
			}
		}
	});
	rawat_aktif_kiField=new Ext.form.Checkbox({
		id : 'rawat_aktif_kiField',
		boxLabel: 'KI',
		maxLength: 250,
		name: 'rawat_aktif_ki'
	});
	
	rawat_aktif_hrField=new Ext.form.Checkbox({
		id : 'rawat_aktif_hrField',
		boxLabel: 'HR',
		maxLength: 250,
		name: 'rawat_aktif_hr'
	});
	
	rawat_aktif_tpField=new Ext.form.Checkbox({
		id : 'rawat_aktif_tpField',
		boxLabel: 'TP',
		maxLength: 250,
		name: 'rawat_aktif_tp'
	});
	
	rawat_aktif_dpsField=new Ext.form.Checkbox({
		id : 'rawat_aktif_dpsField',
		boxLabel: 'DPS',
		maxLength: 250,
		name: 'rawat_aktif_dps'
	});
	
	rawat_aktif_jktField=new Ext.form.Checkbox({
		id : 'rawat_aktif_jktField',
		boxLabel: 'JKT',
		maxLength: 250,
		name: 'rawat_aktif_jkt'
	});
	
	rawat_aktif_mtaField=new Ext.form.Checkbox({
		id : 'rawat_aktif_mtaField',
		boxLabel: 'MTA',
		maxLength: 250,
		name: 'rawat_aktif_mta'
	});
	
	rawat_aktif_blpnField=new Ext.form.Checkbox({
		id : 'rawat_aktif_blpnField',
		boxLabel: 'BLPN',
		maxLength: 250,
		name: 'rawat_aktif_blpn'
	});
	
	rawat_aktif_kutaField=new Ext.form.Checkbox({
		id : 'rawat_aktif_kutaField',
		boxLabel: 'KUTA',
		maxLength: 250,
		name: 'rawat_aktif_kuta'
	});
	
	rawat_aktif_btmField=new Ext.form.Checkbox({
		id : 'rawat_aktif_btmField',
		boxLabel: 'BTM',
		maxLength: 250,
		name: 'rawat_aktif_btm'
	});
	
	rawat_aktif_mksField=new Ext.form.Checkbox({
		id : 'rawat_aktif_mksField',
		boxLabel: 'MKS',
		maxLength: 250,
		name: 'rawat_aktif_mks'
	});
	
	rawat_aktif_mdnField=new Ext.form.Checkbox({
		id : 'rawat_aktif_mdnField',
		boxLabel: 'MDN',
		maxLength: 250,
		name: 'rawat_aktif_mdn'
	});
	
	rawat_aktif_lbkField=new Ext.form.Checkbox({
		id : 'rawat_aktif_lbkField',
		boxLabel: 'LBK',
		maxLength: 250,
		name: 'rawat_aktif_lbk'
	});
	
	rawat_aktif_mndField=new Ext.form.Checkbox({
		id : 'rawat_aktif_mndField',
		boxLabel: 'MND',
		maxLength: 250,
		name: 'rawat_aktif_mnd'
	});
	
	rawat_aktif_ygkField=new Ext.form.Checkbox({
		id : 'rawat_aktif_ygkField',
		boxLabel: 'YGK',
		maxLength: 250,
		name: 'rawat_aktif_ygk'
	});
	
	rawat_aktif_mlgField=new Ext.form.Checkbox({
		id : 'rawat_aktif_mlgField',
		boxLabel: 'MLG',
		maxLength: 250,
		name: 'rawat_aktif_mlg'
	});
	
	rawat_aktif_smgField=new Ext.form.Checkbox({
		id : 'rawat_aktif_smgField',
		boxLabel: 'SMG',
		maxLength: 250,
		name: 'rawat_aktif_smg'
	});
	
	rawat_aktif_checkField=new Ext.form.Checkbox({
		id : '',
		boxLabel: 'Check All',
		maxLength: 250,
		handler: function(node,checked){
			if (checked) {
				rawat_aktif_thField.setValue(true);
				rawat_aktif_kiField.setValue(true);
				rawat_aktif_hrField.setValue(true);
				rawat_aktif_tpField.setValue(true);
				rawat_aktif_dpsField.setValue(true);
				rawat_aktif_jktField.setValue(true);
				rawat_aktif_mtaField.setValue(true);
				rawat_aktif_blpnField.setValue(true);
				rawat_aktif_kutaField.setValue(true);
				rawat_aktif_btmField.setValue(true);
				rawat_aktif_mksField.setValue(true);
				rawat_aktif_mdnField.setValue(true);
				rawat_aktif_lbkField.setValue(true);
				rawat_aktif_mndField.setValue(true);
				rawat_aktif_ygkField.setValue(true);
				rawat_aktif_mlgField.setValue(true);
				rawat_aktif_smgField.setValue(true);
			}
			else {
				rawat_aktif_thField.setValue(false);
				rawat_aktif_kiField.setValue(false);
				rawat_aktif_hrField.setValue(false);
				rawat_aktif_tpField.setValue(false);
				rawat_aktif_dpsField.setValue(false);
				rawat_aktif_jktField.setValue(false);
				rawat_aktif_mtaField.setValue(false);
				rawat_aktif_blpnField.setValue(false);
				rawat_aktif_kutaField.setValue(false);
				rawat_aktif_btmField.setValue(false);
				rawat_aktif_mksField.setValue(false);
				rawat_aktif_mdnField.setValue(false);
				rawat_aktif_lbkField.setValue(false);
				rawat_aktif_mndField.setValue(false);
				rawat_aktif_ygkField.setValue(false);
				rawat_aktif_mlgField.setValue(false);
				rawat_aktif_smgField.setValue(false);
			}
		}
	});
	
	rawat_aktifGroup = new Ext.form.FieldSet({
		title: 'Rawat Aktif',
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
				items: [ rawat_aktif_thField, rawat_aktif_kiField, rawat_aktif_hrField, rawat_aktif_tpField, rawat_aktif_mlgField, rawat_aktif_dpsField, rawat_aktif_jktField, rawat_aktif_mtaField,rawat_aktif_blpnField]
			},
			 {
				   	layout: 'form',
					border: false,
					columnWidth: 0.5,
					labelWidth: 80,
					labelAlign: 'left',
					items:[rawat_aktif_kutaField, rawat_aktif_btmField, rawat_aktif_mksField, rawat_aktif_mdnField, rawat_aktif_lbkField, rawat_aktif_mndField, rawat_aktif_ygkField, rawat_aktif_jktField, rawat_aktif_smgField]
			   }
		]
	});	
	
	//untuk Panel Diskon 
	rawat_diskonGroup = new Ext.form.FieldSet({
		title: 'Jenis Diskon (%)',
		layout:'column',
		autoHeight: true,
		mode: 'remote',
		collapsible: true,
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				labelAlign: 'left',
				border:false,
				items: [rawat_duField, rawat_dmField, rawat_dultahField,rawat_dcardField, rawat_dwartawanField,rawat_dpromoField]
			},
			{
				columnWidth:0.5,
				layout: 'form',
				labelAlign: 'left',
				border:false,
				items: [rawat_dkolegaField, rawat_dkeluargaField, rawat_downerField, rawat_dgroomingField, rawat_dstaffdokterField, rawat_dstaffnondokterField]
			}
		]
	});
	
	/* Identify harga rawat*/
	rawat_harga_allField=new Ext.form.TextField({
		id : 'rawat_harga_allField',
		fieldLabel: '(Rp.)',
		maxLength: 20,
		allowBlank: true,
		itemCls: 'rmoney',
		maskRe: /([0-9]+)$/,
		width: 100,
		renderer: function(val){
			return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
		}
	});
	
	rawat_harga_thField=new Ext.form.TextField({
		id : 'rawat_harga_thField',
		fieldLabel: 'Thamrin',
		maxLength: 20,
		allowBlank: true,
		disabled : true,
		itemCls: 'rmoney',
		maskRe: /([0-9]+)$/,
		width: 100,
		renderer: function(val){
			return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
		}
	});
	
	rawat_harga_kiField=new Ext.form.TextField({
		id : 'rawat_harga_kiField',
		fieldLabel: 'Kertajaya Indah',
		maxLength: 20,
		allowBlank: true,
		itemCls: 'rmoney',
		maskRe: /([0-9]+)$/,
		width: 100,
		renderer: function(val){
			return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
		}
	});
	
	rawat_harga_hrField=new Ext.form.TextField({
		id : 'rawat_harga_hrField',
		fieldLabel: 'HR',
		maxLength: 20,
		allowBlank: true,
		itemCls: 'rmoney',
		maskRe: /([0-9]+)$/,
		width: 100,
		renderer: function(val){
			return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
		}
	});
	
	rawat_harga_tpField=new Ext.form.TextField({
		id : 'rawat_harga_tpField',
		fieldLabel: 'TP',
		maxLength: 20,
		allowBlank: true,
		itemCls: 'rmoney',
		maskRe: /([0-9]+)$/,
		width: 100,
		renderer: function(val){
			return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
		}
	});
	
	rawat_harga_dpsField=new Ext.form.TextField({
		id : 'rawat_harga_dpsField',
		fieldLabel: 'DPS',
		maxLength: 20,
		allowBlank: true,
		itemCls: 'rmoney',
		maskRe: /([0-9]+)$/,
		width: 100,
		renderer: function(val){
			return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
		}
	});
	
	rawat_harga_jktField=new Ext.form.TextField({
		id : 'rawat_harga_jktField',
		fieldLabel: 'JKT',
		maxLength: 20,
		allowBlank: true,
		itemCls: 'rmoney',
		maskRe: /([0-9]+)$/,
		width: 100,
		renderer: function(val){
			return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
		}
	});
	
	rawat_harga_mtaField=new Ext.form.TextField({
		id : 'rawat_harga_mtaField',
		fieldLabel: 'Mall Taman Anggrek',
		maxLength: 20,
		allowBlank: true,
		itemCls: 'rmoney',
		maskRe: /([0-9]+)$/,
		width: 100,
		renderer: function(val){
			return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
		}
	});
	
	rawat_harga_blpnField=new Ext.form.TextField({
		id : 'rawat_harga_blpnField',
		fieldLabel: 'BLPN',
		maxLength: 20,
		allowBlank: true,
		itemCls: 'rmoney',
		maskRe: /([0-9]+)$/,
		width: 100,
		renderer: function(val){
			return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
		}
	});
	
	rawat_harga_kutaField=new Ext.form.TextField({
		id : 'rawat_harga_kutaField',
		fieldLabel: 'KUTA',
		maxLength: 20,
		allowBlank: true,
		itemCls: 'rmoney',
		maskRe: /([0-9]+)$/,
		width: 100,
		renderer: function(val){
			return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
		}
	});
	
	rawat_harga_btmField=new Ext.form.TextField({
		id : 'rawat_harga_btmField',
		fieldLabel: 'BTM',
		maxLength: 20,
		allowBlank: true,
		itemCls: 'rmoney',
		maskRe: /([0-9]+)$/,
		width: 100,
		renderer: function(val){
			return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
		}
	});
	
	rawat_harga_mksField=new Ext.form.TextField({
		id : 'rawat_harga_mksField',
		fieldLabel: 'MKS',
		maxLength: 20,
		allowBlank: true,
		itemCls: 'rmoney',
		maskRe: /([0-9]+)$/,
		width: 100,
		renderer: function(val){
			return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
		}
	});
	
	rawat_harga_mdnField=new Ext.form.TextField({
		id : 'rawat_harga_mdnField',
		fieldLabel: 'Medan',
		maxLength: 20,
		allowBlank: true,
		itemCls: 'rmoney',
		maskRe: /([0-9]+)$/,
		width: 100,
		renderer: function(val){
			return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
		}
	});
	
	rawat_harga_lbkField=new Ext.form.TextField({
		id : 'rawat_harga_lbkField',
		fieldLabel: 'Lombok',
		maxLength: 20,
		allowBlank: true,
		itemCls: 'rmoney',
		maskRe: /([0-9]+)$/,
		width: 100,
		renderer: function(val){
			return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
		}
	});
	
	rawat_harga_mndField=new Ext.form.TextField({
		id : 'rawat_harga_mndField',
		fieldLabel: 'Manado',
		maxLength: 20,
		allowBlank: true,
		itemCls: 'rmoney',
		maskRe: /([0-9]+)$/,
		width: 100,
		renderer: function(val){
			return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
		}
	});
	
	rawat_harga_ygkField=new Ext.form.TextField({
		id : 'rawat_harga_ygkField',
		fieldLabel: 'Yogyakarta',
		maxLength: 20,
		allowBlank: true,
		itemCls: 'rmoney',
		maskRe: /([0-9]+)$/,
		width: 100,
		renderer: function(val){
			return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
		}
	});
	
	rawat_harga_mlgField=new Ext.form.TextField({
		id : 'rawat_harga_mlgField',
		fieldLabel: 'MLG',
		maxLength: 20,
		allowBlank: true,
		itemCls: 'rmoney',
		maskRe: /([0-9]+)$/,
		width: 100,
		renderer: function(val){
			return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
		}
	});
	
	rawat_harga_smgField=new Ext.form.TextField({
		id : 'rawat_harga_smgField',
		fieldLabel: 'SMG',
		maxLength: 20,
		allowBlank: true,
		itemCls: 'rmoney',
		maskRe: /([0-9]+)$/,
		width: 100,
		renderer: function(val){
			return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
		}
	});
	
	rawat_harga_checkField=new Ext.form.Checkbox({
		id : '',
		boxLabel: 'Semua cabang sama',
		width: 150,
		handler: function(node,checked){
			if (checked) {
				rawat_harga_thField.setValue(rawat_hargaField.getValue());
				rawat_harga_kiField.setValue(rawat_hargaField.getValue());
				rawat_harga_hrField.setValue(rawat_hargaField.getValue());
				rawat_harga_tpField.setValue(rawat_hargaField.getValue());
				rawat_harga_dpsField.setValue(rawat_hargaField.getValue());
				rawat_harga_jktField.setValue(rawat_hargaField.getValue());
				rawat_harga_mtaField.setValue(rawat_hargaField.getValue());
				rawat_harga_blpnField.setValue(rawat_hargaField.getValue());
				rawat_harga_kutaField.setValue(rawat_hargaField.getValue());
				rawat_harga_btmField.setValue(rawat_hargaField.getValue());
				rawat_harga_mksField.setValue(rawat_hargaField.getValue());
				rawat_harga_mdnField.setValue(rawat_hargaField.getValue());
				rawat_harga_lbkField.setValue(rawat_hargaField.getValue());
				rawat_harga_mndField.setValue(rawat_hargaField.getValue());
				rawat_harga_ygkField.setValue(rawat_hargaField.getValue());
				rawat_harga_mlgField.setValue(rawat_hargaField.getValue());
				rawat_harga_smgField.setValue(rawat_hargaField.getValue());
			}
		}
	});
	
	//untuk panel harga
	rawat_hargaGroup = new Ext.form.FieldSet({
		title: 'Harga Cabang (Rp)',
		layout:'column',
		width:350,
		autoHeight: true,
		//collapsed: true,
		collapsible: true,
		items:[
			{
				columnWidth:0.7,
				layout: 'form',
				labelAlign: 'left',
				border:false,
				items: [rawat_harga_thField, rawat_harga_kiField, rawat_harga_hrField, rawat_harga_tpField, rawat_harga_dpsField, rawat_harga_mtaField, rawat_harga_blpnField, rawat_harga_kutaField, rawat_harga_mdnField, rawat_harga_lbkField, rawat_harga_mndField, rawat_harga_ygkField,rawat_harga_btmField, rawat_harga_jktField, rawat_harga_smgField, rawat_harga_mksField, rawat_harga_mlgField]
			}
		]
	});
	
	rawat_groupField.on('select', function(){
		var record=cbo_rawat_groupDataStore.findExact('rawat_group_value', rawat_groupField.getValue(),0);
		if(cbo_rawat_groupDataStore.getCount()){
			rawat_duField.setValue(cbo_rawat_groupDataStore.getAt(record).data.rawat_group_durawat);
			rawat_dmField.setValue(cbo_rawat_groupDataStore.getAt(record).data.rawat_group_dmrawat);
			rawat_dultahField.setValue(cbo_rawat_groupDataStore.getAt(record).data.rawat_group_dultah);
			rawat_dcardField.setValue(cbo_rawat_groupDataStore.getAt(record).data.rawat_group_dcard);
			rawat_dkolegaField.setValue(cbo_rawat_groupDataStore.getAt(record).data.rawat_group_dkolega);
			rawat_dkeluargaField.setValue(cbo_rawat_groupDataStore.getAt(record).data.rawat_group_dkeluarga);
			rawat_downerField.setValue(cbo_rawat_groupDataStore.getAt(record).data.rawat_group_downer);
			rawat_dgroomingField.setValue(cbo_rawat_groupDataStore.getAt(record).data.rawat_group_dgrooming);
			rawat_dwartawanField.setValue(cbo_rawat_groupDataStore.getAt(record).data.rawat_group_dwartawan);
			rawat_dstaffdokterField.setValue(cbo_rawat_groupDataStore.getAt(record).data.rawat_group_dstaffdokter);
			rawat_dstaffnondokterField.setValue(cbo_rawat_groupDataStore.getAt(record).data.rawat_group_dstaffnondokter);
			rawat_dpromoField.setValue(cbo_rawat_groupDataStore.getAt(record).data.rawat_group_dpromo);
			rawat_kategoritxtField.setValue(cbo_rawat_groupDataStore.getAt(record).data.rawat_group_kelompok);
			rawat_kategoriField.setValue(cbo_rawat_groupDataStore.getAt(record).data.rawat_group_kelompok_id);
			if(cbo_rawat_groupDataStore.getAt(record).data.rawat_group_kelompok=="Medis" || cbo_rawat_groupDataStore.getAt(record).data.rawat_group_kelompok=="Surgery"){
				//rawat_gudangField.setValue("Gudang Besar");
				cbo_rawat_gudangDataSore.load();
			}else if(cbo_rawat_groupDataStore.getAt(record).data.rawat_group_kelompok=="Non Medis"){
				//rawat_gudangField.setValue("Gudang BT");
				cbo_rawat_gudangDataSore.load();
			}else{
				rawat_gudangField.setValue("");
			}
		}
	});
	
  	/*Fieldset Master*/
	perawatan_masterGroup = new Ext.form.FieldSet({
		title: 'Master',
		labelWidth:120,
		autoHeight: true,
		collapsible: true,
		layout:'column',
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [rawat_kodelamaField, rawat_kodeField, rawat_namaField, rawat_highmarginField, rawat_edit_hargaField, rawat_groupField, rawat_jenisField, rawat_hargaField, rawat_harga_checkField, rawat_kategoritxtField, rawat_hargaGroup] 
			}
			,{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [rawat_durasiField, rawat_pointField, 
				<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_PERAWATAN'))){ ?>
					rawat_kreditField, rawat_kreditrpField, 
				<? } ?>
				rawat_kontribusiField, rawat_gudangField, rawat_keteranganField,  rawat_idField, rawat_aktifGroup, rawat_diskonGroup] 
			}
			]
	
	});
	
	/*Detail Declaration */
	// Function for json reader of detail
	var perawatan_konsumsi_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: ''
	},[
	/* dataIndex => insert intoperawatan_ColumnModel, Mapping => for initiate table column */ 
			{name: 'krawat_id', type: 'int', mapping: 'krawat_id'}, 
			{name: 'krawat_master', type: 'int', mapping: 'krawat_master'}, 
			{name: 'krawat_produk', type: 'int', mapping: 'krawat_produk'}, 
			{name: 'krawat_satuan', type: 'int', mapping: 'krawat_satuan'}, 
			{name: 'krawat_jumlah', type: 'float', mapping: 'krawat_jumlah'} 
	]);
	//eof
	
	var perawatan_alat_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: ''
	},[
	/* dataIndex => insert intoperawatan_ColumnModel, Mapping => for initiate table column */ 
			{name: 'arawat_id', type: 'int', mapping: 'arawat_id'}, 
			{name: 'arawat_master', type: 'int', mapping: 'arawat_master'}, 
			{name: 'arawat_alat', type: 'int', mapping: 'arawat_alat'}, 
			{name: 'arawat_jumlah', type: 'int', mapping: 'arawat_jumlah'} 
	]);
	//eof
	
	//function for json writer of detail
	var perawatan_konsumsi_writer = new Ext.data.JsonWriter({
		encode: true,
		writeAllFields: false
	});
	//eof
	
	/* Function for Retrieve DataStore of detail*/
	perawatan_konsumsi_DataStore = new Ext.data.Store({
		id: 'perawatan_konsumsi_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_perawatan&m=detail_perawatan_konsumsi_list', 
			method: 'POST'
		}),
		reader: perawatan_konsumsi_reader,
		baseParams:{start: 0, limit: perawatan_pageS},
		sortInfo:{field: 'krawat_id', direction: "ASC"}
	});
	/* End of Function */
	
	/* Function for Retrieve DataStore of detail*/
	perawatan_alat_DataStore = new Ext.data.Store({
		id: 'perawatan_alat_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_perawatan&m=detail_perawatan_alat_list', 
			method: 'POST'
		}),
		reader: perawatan_alat_reader,
		baseParams:{master_id: get_pk_id(), start: 0, limit: perawatan_pageS},
		sortInfo:{field: 'arawat_id', direction: "ASC"}
	});
	/* End of Function */
	
	//function for editor of detail
	var editor_perawatan_konsumsi= new Ext.ux.grid.RowEditor({
        saveText: 'Update'/*,
		listeners: {
			afteredit: function(){
				perawatan_konsumsi_DataStore.commitChanges();
			}
		}*/
    });
	//eof
	
	//function for editor of detail
	var editor_perawatan_alat= new Ext.ux.grid.RowEditor({
        saveText: 'Update',
		listeners: {
			afteredit: function(){
				perawatan_alat_DataStore.commitChanges();
			}
		}
    });
	//eof
	
	Ext.util.Format.comboRenderer = function(combo){
		return function(value){
			var record = combo.findRecord(combo.valueField, value);
			return record ? record.get(combo.displayField) : combo.valueNotFoundText;
		}
	}
	
	
	cbo_rawat_produkDataStore = new Ext.data.Store({
		id: 'cbo_rawat_produkDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_perawatan&m=get_produk_list', 
			method: 'POST'
		}),baseParams: {start: 0, limit: 50},
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'produk_id'
		},[
			{name: 'rawat_produk_value', type: 'int', mapping: 'produk_id'},
			{name: 'rawat_produk_harga', type: 'float', mapping: 'produk_harga'},
			{name: 'rawat_produk_kode', type: 'string', mapping: 'produk_kode'},
			{name: 'rawat_produk_kodelama', type: 'string', mapping: 'produk_kodelama'},
			{name: 'rawat_produk_satuan', type: 'string', mapping: 'satuan_kode'},
			{name: 'rawat_produk_group', type: 'string', mapping: 'group_nama'},
			{name: 'rawat_produk_kategori', type: 'string', mapping: 'kategori_nama'},
			{name: 'produk_display', type: 'string', mapping: 'produk_display'},
			{name: 'rawat_produk_du', type: 'float', mapping: 'produk_du'},
			{name: 'rawat_produk_dm', type: 'float', mapping: 'produk_dm'},
			{name: 'rawat_produk_display', type: 'string', mapping: 'produk_nama'},
			{name: 'rawat_paket_aktif', type: 'string', mapping: 'rawat_aktif_cabang'}	///////////////////// rawat_pakket_aktif
		]),
		sortInfo:{field: 'rawat_produk_display', direction: "ASC"}
	});
	
	cbo_rawat_alatDataStore = new Ext.data.Store({
		id: 'cbo_rawat_alatDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_perawatan&m=get_alat_list', 
			method: 'POST'
		}),
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'alat_id'
		},[
			{name: 'alat_value', type: 'int', mapping: 'alat_id'},
			{name: 'alat_display', type: 'string', mapping: 'alat_nama'},
			{name: 'alat_jumlah', type: 'int', mapping: 'alat_jumlah'}
		]),
		sortInfo:{field: 'alat_display', direction: "ASC"}
	});
	
	var rawat_produk_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span>{rawat_produk_display}<br/>Lama:{rawat_produk_kodelama}| Baru:<b>{rawat_produk_kode}</b> <br/>Group 1: {rawat_produk_group}, ',
			'Kategori: {rawat_produk_kategori}</span>',
		'</div></tpl>'
    );
	
	cbo_satuan_produkDataStore = new Ext.data.Store({
		id: 'cbo_satuan_produkDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_perawatan&m=get_satuan_list', 
			method: 'POST'
		}),
		baseParams: {start:0,limit:perawatan_pageS, task:'detail'},
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'satuan_value'
		},[
			{name: 'satuan_value', type: 'int', mapping: 'satuan_id'},
			{name: 'satuan_nama', type: 'string', mapping: 'satuan_nama'}
		]),
		sortInfo:{field: 'satuan_nama', direction: "ASC"}
	});
	
	var combo_rawat_produk=new Ext.form.ComboBox({
			store: cbo_rawat_produkDataStore,
			mode: 'remote',
			typeAhead: false,
			displayField: 'produk_display',
			valueField: 'rawat_produk_value',
			triggerAction: 'all',
			loadingText: 'Searching...',
			pageSize:perawatan_pageS,
			hideTrigger:false,
			tpl: rawat_produk_tpl,
			//applyTo: 'search',
			itemSelector: 'div.search-item',
			lazyRender:true,
			listClass: 'x-combo-list-small',
			anchor: '95%'
	});
	
	var combo_rawat_alat=new Ext.form.ComboBox({
			store: cbo_rawat_alatDataStore,
			mode: 'remote',
			typeAhead: true,
			displayField: 'alat_display',
			valueField: 'alat_value',
			triggerAction: 'all',
			loadingText: 'Searching...',
			pageSize: perawatan_pageS,
			hideTrigger:false,
			lazyRender:true,
			anchor: '95%'
	});
	
	var combo_dproduk_satuan=new Ext.form.ComboBox({
		store: cbo_satuan_produkDataStore,
		mode: 'local',
		typeAhead: true,
		displayField: 'satuan_nama',
		valueField: 'satuan_value',
		triggerAction: 'all',
		lazyRender:true
	});
	
	//declaration of detail coloumn model
	perawatan_konsumsi_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '<div align="center">ID</div>',
			dataIndex: 'krawat_id',
			width: 80,
			sortable: true,
			hidden: true,
			readOnly: true
		},
		{
			header: '<div align="center">Produk</div>',
			dataIndex: 'krawat_produk',
			width: 300,
			sortable: true,
			editor: combo_rawat_produk,
			renderer: Ext.util.Format.comboRenderer(combo_rawat_produk)
		},
		{
			header: '<div align="center">Satuan</div>',
			dataIndex: 'krawat_satuan',
			width: 60,
			sortable: true,
			/*editor: combo_dproduk_satuan,
			renderer: Ext.util.Format.comboRenderer(combo_dproduk_satuan)*/
			readOnly: true,
			renderer: function(v, params, record){
				j=cbo_rawat_produkDataStore.findExact('rawat_produk_value',record.data.krawat_produk,0);
				if(j>-1)
					return cbo_rawat_produkDataStore.getAt(j).data.rawat_produk_satuan;
			}
		},
		{
			header: '<div align="center">Jumlah</div>',
			dataIndex: 'krawat_jumlah',
			align: 'right',
			width: 40,
			sortable: true,
			editor: new Ext.form.NumberField({
				allowDecimals: true,
				allowNegative: false,
				blankText: '0',
				emptyText: '0',
				maxLength: 11,
				maskRe: /([0-9]+)$/
			})
		}]
	);
	perawatan_konsumsi_ColumnModel.defaultSortable= true;
	//eof
	
	//declaration of detail coloumn model
	perawatan_alat_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: 'ID',
			dataIndex: 'arawat_id',
			width: 80,
			sortable: true,
			hidden: true,
			readOnly: true
		},
		{
			header: 'Nama Alat',
			dataIndex: 'arawat_alat',
			width: 250,
			sortable: true,
			editor: combo_rawat_alat,
			renderer: Ext.util.Format.comboRenderer(combo_rawat_alat)
		},
		{
			header: 'Jumlah',
			dataIndex: 'arawat_jumlah',
			width: 100,
			sortable: true,
			editor: new Ext.form.NumberField({
				allowDecimals: true,
				allowNegative: false,
				blankText: '0',
				emptyText: '0',
				maxLength: 2,
				maskRe: /([0-9]+)$/
			})
		}]
	);
	perawatan_alat_ColumnModel.defaultSortable= true;
	
	//declaration of detail list editor grid
	perawatan_konsumsiListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'perawatan_konsumsiListEditorGrid',
		el: 'fp_perawatan_konsumsi',
		title: 'Detail Standar Bahan',
		height: 350,
		width: 690,
		autoScroll: true,
		store: perawatan_konsumsi_DataStore, // DataStore
		colModel: perawatan_konsumsi_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 5 5 5',
		plugins: [editor_perawatan_konsumsi],
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true},
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_PERAWATAN'))){ ?>
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: perawatan_konsumsi_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			handler: perawatan_konsumsi_confirm_delete
		}
		]
		<?php } ?>
	});
	//eof
	
	//declaration of detail list editor grid
	perawatan_alatListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'perawatan_alatListEditorGrid',
		el: 'fp_perawatan_alat',
		title: 'Detail Standar Alat',
		height: 350,
		width: 690,
		autoScroll: true,
		store: perawatan_alat_DataStore, // DataStore
		colModel: perawatan_alat_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 5 5 5',
		plugins: [editor_perawatan_alat],
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true},
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_PERAWATAN'))){ ?>
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: perawatan_alat_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			handler: perawatan_alat_confirm_delete
		}
		]
		<?php } ?>
	});
	//eof
	
	//function of detail add
	function perawatan_konsumsi_add(){
		var edit_perawatan_konsumsi= new perawatan_konsumsiListEditorGrid.store.recordType({
			krawat_id		: 0,		
			krawat_master	: 0,		
			krawat_produk	:'',		
			krawat_satuan	:'',		
			krawat_jumlah	:''		
		});
		editor_perawatan_konsumsi.stopEditing();
		perawatan_konsumsi_DataStore.insert(0, edit_perawatan_konsumsi);
		//perawatan_konsumsiListEditorGrid.getView().refresh();
		perawatan_konsumsiListEditorGrid.getSelectionModel().selectRow(0);
		editor_perawatan_konsumsi.startEditing(0);
	}
	
	//function of detail add
	function perawatan_alat_add(){
		var edit_perawatan_alat= new perawatan_alatListEditorGrid.store.recordType({
			arawat_id		:0,		
			arawat_master	:0,		
			arawat_alat		:'',		
			arawat_jumlah	:''		
		});
		editor_perawatan_alat.stopEditing();
		perawatan_alat_DataStore.insert(0, edit_perawatan_alat);
		perawatan_alatListEditorGrid.getView().refresh();
		perawatan_alatListEditorGrid.getSelectionModel().selectRow(0);
		editor_perawatan_alat.startEditing(0);
	}
	
	//function for refresh detail
	function refresh_perawatan_konsumsi(){
		perawatan_konsumsi_DataStore.commitChanges();
		perawatan_konsumsiListEditorGrid.getView().refresh();
	}
	//eof
	
	//function for insert detail
	function perawatan_konsumsi_insert(pkid){
		
		var krawat_id = [];
		var krawat_produk = [];
        var krawat_satuan = [];
        var krawat_jumlah = [];
       
        if(perawatan_konsumsi_DataStore.getCount()>0){
            for(i=0; i<perawatan_konsumsi_DataStore.getCount();i++){
                if((/^\d+$/.test(perawatan_konsumsi_DataStore.getAt(i).data.krawat_produk))
				   && perawatan_konsumsi_DataStore.getAt(i).data.krawat_produk!==undefined
				   && perawatan_konsumsi_DataStore.getAt(i).data.krawat_produk!==''
				   && perawatan_konsumsi_DataStore.getAt(i).data.krawat_produk!==0
				   && perawatan_konsumsi_DataStore.getAt(i).data.krawat_jumlah>0){
                    
                  	krawat_id.push(perawatan_konsumsi_DataStore.getAt(i).data.krawat_id);
					krawat_satuan.push(perawatan_konsumsi_DataStore.getAt(i).data.krawat_satuan);
					krawat_jumlah.push(perawatan_konsumsi_DataStore.getAt(i).data.krawat_jumlah);
					krawat_produk.push(perawatan_konsumsi_DataStore.getAt(i).data.krawat_produk);
                }
            }
			
			var encoded_array_krawat_id = Ext.encode(krawat_id);
			var encoded_array_krawat_satuan = Ext.encode(krawat_satuan);
			var encoded_array_krawat_jumlah = Ext.encode(krawat_jumlah);
			var encoded_array_krawat_produk = Ext.encode(krawat_produk);
				
			Ext.Ajax.request({
				waitMsg: 'Mohon tunggu...',
				url: 'index.php?c=c_perawatan&m=detail_perawatan_konsumsi_insert',
				params:{
					krawat_id			: encoded_array_krawat_id,
					krawat_master		: pkid,
					krawat_produk		: encoded_array_krawat_produk,
					krawat_satuan		: encoded_array_krawat_satuan,
					krawat_jumlah		: encoded_array_krawat_jumlah
				},
				success:function(response){
					//perawatan_DataStore.reload();
					//perawatan_alat_insert(pkid);
				},
				failure: function(response){
					Ext.MessageBox.hide();
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
	
	//function for insert detail
	function perawatan_alat_insert(pkid){
		
		var arawat_id = [];
		var arawat_alat = [];
        var arawat_jumlah = [];
       
        if(perawatan_alat_DataStore.getCount()>0){
            for(i=0; i<perawatan_alat_DataStore.getCount();i++){
                if((/^\d+$/.test(perawatan_alat_DataStore.getAt(i).data.arawat_alat))
				   && perawatan_alat_DataStore.getAt(i).data.arawat_alat!==undefined
				   && perawatan_alat_DataStore.getAt(i).data.arawat_alat!==''
				   && perawatan_alat_DataStore.getAt(i).data.arawat_alat!==0
				   && perawatan_alat_DataStore.getAt(i).data.arawat_jumlah>0){
                    
                  	arawat_id.push(perawatan_alat_DataStore.getAt(i).data.arawat_id);
					arawat_jumlah.push(perawatan_alat_DataStore.getAt(i).data.arawat_jumlah);
					arawat_alat.push(perawatan_alat_DataStore.getAt(i).data.arawat_alat);
                }
            }
			
			var encoded_array_arawat_id = Ext.encode(arawat_id);
			var encoded_array_arawat_jumlah = Ext.encode(arawat_jumlah);
			var encoded_array_arawat_alat = Ext.encode(arawat_alat);
				
			Ext.Ajax.request({
				waitMsg: 'Mohon tunggu...',
				url: 'index.php?c=c_perawatan&m=detail_perawatan_alat_insert',
				params:{
					arawat_id			: encoded_array_arawat_id,
					arawat_master		: pkid,
					arawat_alat			: encoded_array_arawat_alat,
					arawat_jumlah		: encoded_array_arawat_jumlah
				},
				success:function(response){
					perawatan_DataStore.reload();
				},
				failure: function(response){
					Ext.MessageBox.hide();
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
	
	//function for purge detail
	function perawatan_konsumsi_purge(){
		Ext.Ajax.request({
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_perawatan&m=detail_perawatan_konsumsi_purge',
			params:{ master_id: get_pk_id() },
			timeout: 5000,			
			success: function(response){             
				var result=eval(response.responseText);
				switch(result){
					case 1:
						perawatan_konsumsi_insert();
						break;
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'We could\'t not '+msg+' the Produk.',
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
	//eof
	
	//function for purge detail
	function perawatan_alat_purge(){
		Ext.Ajax.request({
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_perawatan&m=detail_perawatan_alat_purge',
			params:{ master_id: get_pk_id() },
			timeout: 5000,			
			success: function(response){             
				var result=eval(response.responseText);
				switch(result){
					case 1:
						perawatan_alat_insert();
						break;
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'We could\'t not '+msg+' the Produk.',
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
	//eof
	
	/* Function for Delete Confirm of detail */
	function perawatan_konsumsi_confirm_delete(){
		// only one record is selected here
		if(perawatan_konsumsiListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', perawatan_konsumsi_delete);
		} else if(perawatan_konsumsiListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', perawatan_konsumsi_delete);
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
	//eof
	
	/* Function for Delete Confirm of detail */
	function perawatan_alat_confirm_delete(){
		// only one record is selected here
		if(perawatan_alatListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', perawatan_alat_delete);
		} else if(perawatan_alatListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', perawatan_alat_delete);
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
	//eof
	
	//function for Delete of detail
	function perawatan_konsumsi_delete(btn){
		if(btn=='yes'){
			var s = perawatan_konsumsiListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, r; r = s[i]; i++){
				perawatan_konsumsi_DataStore.remove(r);
			}
		}
	}
	//eof
	
	//function for Delete of detail
	function perawatan_alat_delete(btn){
		if(btn=='yes'){
			var s = perawatan_alatListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, r; r = s[i]; i++){
				perawatan_alat_DataStore.remove(r);
			}
		} 
		perawatan_alat_DataStore.commitChanges();
	}
	//eof
	
	//event on update of detail data store
	//perawatan_konsumsi_DataStore.on('update', refresh_perawatan_konsumsi);
	var detail_tab_rawat = new Ext.TabPanel({
		activeTab: 0,
		items: [perawatan_konsumsiListEditorGrid,perawatan_alatListEditorGrid]
	});
	
	/* Function for retrieve create Window Panel*/ 
	perawatan_createForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 800,
		items: [perawatan_masterGroup,detail_tab_rawat],
		buttons: [
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_PERAWATAN'))){ ?>
			{
				text: 'Save and Close',
				handler: perawatan_create
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					perawatan_reset_form();
					perawatan_DataStore.reload();
					perawatan_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	perawatan_createWindow= new Ext.Window({
		id: 'perawatan_createWindow',
		title: perawatan_post2db+'Perawatan',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_perawatan_create',
		items: perawatan_createForm
	});
	/* End Window */
	
	/* Function for action list search */
	function perawatan_list_search(){
		// render according to a SQL date format.
		var rawat_id_search=null;
		var rawat_kode_search=null;
		var rawat_kodelama_search=null;
		var rawat_nama_search=null;
		var rawat_group_search=null;
		var rawat_kategori_search=null;
		var rawat_jenis_search=null;
		var rawat_keterangan_search=null;
		var rawat_du_search=null;
		var rawat_dm_search=null;
		var rawat_dultah_search=null;
		var rawat_dcard_search=null;
		var rawat_dkolega_search=null;
		var rawat_dkeluarga_search=null;
		var rawat_downer_search=null;
		var rawat_dgrooming_search=null;
		var rawat_point_search=null;
		var rawat_durasi_search=null;
		var rawat_kredit_search=null;
		var rawat_jumlah_tindakan_search=null;
		var rawat_harga_search=null;
		var rawat_gudang_search=null;
		var rawat_aktif_search=null;
		var kategori2_nama_search=null;

		if(rawat_idSearchField.getValue()!==null){rawat_id_search=rawat_idSearchField.getValue();}
		if(rawat_kodeSearchField.getValue()!==null){rawat_kode_search=rawat_kodeSearchField.getValue();}
		if(rawat_kodelamaSearchField.getValue()!==null){rawat_kodelama_search=rawat_kodelamaSearchField.getValue();}
		if(rawat_namaSearchField.getValue()!==null){rawat_nama_search=rawat_namaSearchField.getValue();}
		if(rawat_groupSearchField.getValue()!==null){rawat_group_search=rawat_groupSearchField.getValue();}
		if(rawat_kategoriSearchField.getValue()!==null){rawat_kategori_search=rawat_kategoriSearchField.getValue();}
		if(rawat_kontribusiSearchField.getValue()!==null){kategori2_nama_search=rawat_kontribusiSearchField.getValue();}
		
		if(rawat_jenisSearchField.getValue()!==null){rawat_jenis_search=rawat_jenisSearchField.getValue();}
		if(rawat_keteranganSearchField.getValue()!==null){rawat_keterangan_search=rawat_keteranganSearchField.getValue();}
		if(rawat_duSearchField.getValue()!==null){rawat_du_search=rawat_duSearchField.getValue();}
		if(rawat_dmSearchField.getValue()!==null){rawat_dm_search=rawat_dmSearchField.getValue();}
		if(rawat_dultahSearchField.getValue()!==null){rawat_dultah_search=rawat_dultahSearchField.getValue();}
		if(rawat_dcardSearchField.getValue()!==null){rawat_dcard_search=rawat_dcardSearchField.getValue();}
		if(rawat_dkolegaSearchField.getValue()!==null){rawat_dkolega_search=rawat_dkolegaSearchField.getValue();}
		if(rawat_dkeluargaSearchField.getValue()!==null){rawat_dkeluarga_search=rawat_dkeluargaSearchField.getValue();}
		if(rawat_downerSearchField.getValue()!==null){rawat_downer_search=rawat_downerSearchField.getValue();}
		if(rawat_dgroomingSearchField.getValue()!==null){rawat_dgrooming_search=rawat_dgroomingSearchField.getValue();}
		if(rawat_pointSearchField.getValue()!==null){rawat_point_search=rawat_pointSearchField.getValue();}
		if(rawat_durasiSearchField.getValue()!==null){rawat_durasi_search=rawat_durasiSearchField.getValue();}
		if(rawat_kreditSearchField.getValue()!==null){rawat_kredit_search=rawat_kreditSearchField.getValue();}
		if(rawat_jumlah_tindakanSearchField.getValue()!==null){rawat_jumlah_tindakan_search=rawat_jumlah_tindakanSearchField.getValue();}
		if(rawat_hargaSearchField.getValue()!==null){rawat_harga_search=rawat_hargaSearchField.getValue();}
		if(rawat_gudangSearchField.getValue()!==null){rawat_gudang_search=rawat_gudangSearchField.getValue();}
		if(rawat_aktifSearchField.getValue()!==null){rawat_aktif_search=rawat_aktifSearchField.getValue();}
		
		// change the store parameters
		perawatan_DataStore.baseParams = {
			task: 'SEARCH',
			start: 0,
			limit: perawatan_pageS,
			//variable here
			rawat_id	:	rawat_id_search, 
			rawat_kode	:	rawat_kode_search, 
			rawat_kodelama	:	rawat_kodelama_search, 
			rawat_nama	:	rawat_nama_search, 
			rawat_group	:	rawat_group_search, 
			rawat_kategori	:	rawat_kategori_search, 
			kategori2_nama : kategori2_nama_search,
			rawat_jenis	:	rawat_jenis_search, 
			rawat_keterangan	:	rawat_keterangan_search, 
			rawat_du	:	rawat_du_search, 
			rawat_dm	:	rawat_dm_search,
			rawat_dultah	: rawat_dultah_search,
			rawat_dcard		: rawat_dcard_search,
			rawat_dkolega	: rawat_dkolega_search,
			rawat_dkeluarga	: rawat_dkeluarga_search,
			rawat_downer	: rawat_downer_search,
			rawat_dgrooming	: rawat_dgrooming_search,
			rawat_point	:	rawat_point_search, 
			rawat_kredit :	rawat_kredit_search,
			rawat_jumlah_tindakan : rawat_jumlah_tindakan_search,
			rawat_harga	:	rawat_harga_search, 
			rawat_gudang	:	rawat_gudang_search, 
			rawat_aktif	:	rawat_aktif_search, 
		};
		// Cause the datastore to do another query : 
		perawatan_DataStore.reload({params: {start: 0, limit: perawatan_pageS}});
	}
		
	/* Function for reset search result */
	function perawatan_reset_search(){
		// reset the store parameters
		perawatan_DataStore.baseParams = { task: 'LIST',start:0,limit:perawatan_pageS };
		// Cause the datastore to do another query : 
		perawatan_DataStore.reload({params: {start: 0, limit: perawatan_pageS}});
		//perawatan_searchWindow.close();
	};
	/* End of Fuction */
	
	function perawatan_reset_SearchForm(){
		rawat_idSearchField.reset();
		rawat_idSearchField.setValue(null);
		rawat_kodeSearchField.reset();
		rawat_kodeSearchField.setValue(null);
		rawat_kodelamaSearchField.reset();
		rawat_kodelamaSearchField.setValue(null);
		rawat_namaSearchField.reset();
		rawat_namaSearchField.setValue(null);
		rawat_groupSearchField.reset();
		rawat_groupSearchField.setValue(null);
		rawat_kategoriSearchField.reset();
		rawat_kategoriSearchField.setValue(null);
		rawat_kontribusiSearchField.reset();
		rawat_kontribusiSearchField.setValue(null);
		rawat_jenisSearchField.reset();
		rawat_jenisSearchField.setValue(null);
		rawat_keteranganSearchField.reset();
		rawat_keteranganSearchField.setValue(null);
		rawat_duSearchField.reset();
		rawat_duSearchField.setValue(null);
		rawat_dmSearchField.reset();
		rawat_dmSearchField.setValue(null);
		rawat_dultahSearchField.reset();
		rawat_dultahSearchField.setValue(null);
		rawat_dcardSearchField.reset();
		rawat_dcardSearchField.setValue(null);
		rawat_dkolegaSearchField.reset();
		rawat_dkolegaSearchField.setValue(null);
		rawat_dkeluargaSearchField.reset();
		rawat_dkeluargaSearchField.setValue(null);
		rawat_downerSearchField.reset();
		rawat_downerSearchField.setValue(null);
		rawat_dgroomingSearchField.reset();
		rawat_dgroomingSearchField.setValue(null);
		rawat_pointSearchField.reset();
		rawat_pointSearchField.setValue(null);
		rawat_durasiSearchField.reset();
		rawat_durasiSearchField.setValue(null);
		rawat_kreditSearchField.reset();
		rawat_kreditSearchField.setValue(null);
		rawat_jumlah_tindakanSearchField.reset();
		rawat_jumlah_tindakanSearchField.setValue(null);
		rawat_hargaSearchField.reset();
		rawat_hargaSearchField.setValue(null);
		rawat_gudangSearchField.reset();
		rawat_gudangSearchField.setValue(null);
		rawat_aktifSearchField.reset();
		rawat_aktifSearchField.setValue('Aktif');
	}
	
	/* Field for search */
	/* Identify  rawat_id Search Field */
	rawat_idSearchField= new Ext.form.NumberField({
		id: 'rawat_idSearchField',
		fieldLabel: 'Rawat Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  rawat_kode Search Field */
	rawat_kodeSearchField= new Ext.form.TextField({
		id: 'rawat_kodeSearchField',
		fieldLabel: 'Kode Baru',
		maxLength: 20,
		width: 100
	
	});
	/* Identify  rawat_kodelama Search Field */
	rawat_kodelamaSearchField= new Ext.form.TextField({
		id: 'rawat_kodelamaSearchField',
		fieldLabel: 'Kode Lama',
		maxLength: 20,
		width: 100
	
	});
	/* Identify  rawat_nama Search Field */
	rawat_namaSearchField= new Ext.form.TextField({
		id: 'rawat_namaSearchField',
		fieldLabel: 'Nama',
		maxLength: 250,
		anchor: '95%'
	
	});
	/* Identify  rawat_group Search Field */
	rawat_groupSearchField= new Ext.form.ComboBox({
		id: 'rawat_groupSearchField',
		fieldLabel: 'Group 1',
		store: cbo_rawat_groupDataStore,
		mode: 'remote',
		displayField: 'rawat_group_display',
		valueField: 'rawat_group_value',
		width: 120,
		triggerAction: 'all'
	});
	/* Identify  rawat_kategori Search Field */
	rawat_jenisSearchField= new Ext.form.ComboBox({
		id: 'rawat_jenisSearchField',
		fieldLabel: 'Group 2',
		store: cbo_rawat_jenisDataSore,
		mode: 'remote',
		displayField: 'rawat_jenis_display',
		valueField: 'rawat_jenis_value',
		width: 120,
		triggerAction: 'all'
	});
	
	rawat_kategoriSearchField= new Ext.form.ComboBox({
		id: 'rawat_kategoriSearchField',
		fieldLabel: 'Jenis',
		store: cbo_rawat_kategoriDataStore,
		mode: 'remote',
		displayField: 'rawat_kategori_display',
		valueField: 'rawat_kategori_value',
		width: 120,
		triggerAction: 'all'
	});
	
	/* Identify  rawat_keterangan Search Field */
	rawat_keteranganSearchField= new Ext.form.TextArea({
		id: 'rawat_keteranganSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '95%'
	
	});
	/* Identify  rawat_du Search Field */
	rawat_duSearchField= new Ext.form.NumberField({
		id: 'rawat_duSearchField',
		fieldLabel: 'Diskon Umum (%)',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		width: 60,
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  rawat_dm Search Field */
	rawat_dmSearchField= new Ext.form.NumberField({
		id: 'rawat_dmSearchField',
		fieldLabel: 'Diskon Member (%)',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		width: 60,
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  rawat_dultah Search Field */
	rawat_dultahSearchField= new Ext.form.NumberField({
		id: 'rawat_dultahSearchField',
		fieldLabel: 'Diskon Ultah (%)',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		width: 60,
		maskRe: /([0-9]+)$/
	});
	/* Identify  rawat_dcard Search Field */
	rawat_dcardSearchField= new Ext.form.NumberField({
		id: 'rawat_dcardSearchField',
		fieldLabel: 'Diskon Card (%)',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		width: 60,
		maskRe: /([0-9]+)$/
	});
	/* Identify  rawat_dkolega Search Field */
	rawat_dkolegaSearchField= new Ext.form.NumberField({
		id: 'rawat_dkolegaSearchField',
		fieldLabel: 'Diskon Kolega (%)',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		width: 60,
		maskRe: /([0-9]+)$/
	});
	/* Identify  rawat_dkeluarga Search Field */
	rawat_dkeluargaSearchField= new Ext.form.NumberField({
		id: 'rawat_dkeluargaSearchField',
		fieldLabel: 'Diskon Keluarga (%)',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		width: 60,
		maskRe: /([0-9]+)$/
	});
	/* Identify  rawat_downer Search Field */
	rawat_downerSearchField= new Ext.form.NumberField({
		id: 'rawat_downerSearchField',
		fieldLabel: 'Diskon Owner (%)',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		width: 60,
		maskRe: /([0-9]+)$/
	});
	/* Identify  rawat_dgrooming Search Field */
	rawat_dgroomingSearchField= new Ext.form.NumberField({
		id: 'rawat_dgroomingSearchField',
		fieldLabel: 'Diskon Grooming (%)',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		width: 60,
		maskRe: /([0-9]+)$/
	});
	/* Identify  rawat_point Search Field */
	rawat_pointSearchField= new Ext.form.NumberField({
		id: 'rawat_pointSearchField',
		fieldLabel: 'Poin (x)',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		width: 60,
		maskRe: /([0-9]+)$/
	});
	
	/* Identify  rawat_durasi Search Field */
	rawat_durasiSearchField= new Ext.form.NumberField({
		id: 'rawat_durasiSearchField',
		fieldLabel: 'Durasi (dalam menit)',
		allowNegatife : false,
		//blankText: '0',
		allowDecimals: false,
		width: 60,
		maskRe: /([0-9]+)$/
	});
	
	
	rawat_kreditSearchField= new Ext.form.NumberField({
		id: 'rawat_kreditSearchField',
		fieldLabel: 'Kredit',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		width: 60,
		maskRe: /([0-9]+)$/
	});
	
	/* Identify  rawat_harga Search Field */
	rawat_hargaSearchField= new Ext.form.NumberField({
		id: 'rawat_hargaSearchField',
		fieldLabel: 'Harga (Rp)',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: true,
		width: 60,
		maskRe: /([0-9]+)$/
	});
	
	rawat_jumlah_tindakanSearchField= new Ext.form.NumberField({
		id: 'rawat_jumlah_tindakanSearchField',
		fieldLabel: 'Sat.Jmlh.Tindakan',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: true,
		width: 60,
		maskRe: /([0-9]+)$/
	});
	
	/* Identify  rawat_kontribusi Search Field */
	rawat_kontribusiSearchField= new Ext.form.ComboBox({
		id: 'rawat_kontribusiSearchField',
		fieldLabel: 'Contribution Category',
		store: cbo_rawat_kontribusiDataSore,
		mode: 'remote',
		editable:false,
		displayField: 'rawat_kontribusi_display',
		valueField: 'rawat_kontribusi_value',
		triggerAction: 'all'
	});
	/* Identify  rawat_gudang Search Field */
	rawat_gudangSearchField= new Ext.form.ComboBox({
		id: 'rawat_gudangSearchField',
		fieldLabel: 'Gudang',
		store: cbo_rawat_gudangDataSore,
		mode: 'remote',
		displayField: 'rawat_gudang_display',
		valueField: 'rawat_gudang_value',
		width: 120,
		triggerAction: 'all'
	});
	
	
	/* Identify  rawat_aktif Search Field */
	rawat_aktifSearchField= new Ext.form.ComboBox({
		id: 'rawat_aktifSearchField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['value', 'rawat_aktif'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		//emptyText: 'Aktif',
		displayField: 'rawat_aktif',
		valueField: 'value',
		width: 120,
		triggerAction: 'all'
	
	});
    
	/* Function for retrieve search Form Panel */
	perawatan_searchForm = new Ext.FormPanel({
		labelAlign: 'left',
		labelWidth:120,
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 600,        
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [rawat_kodelamaSearchField, rawat_kodeSearchField, rawat_namaSearchField, rawat_groupSearchField, rawat_jenisSearchField, rawat_kategoriSearchField, rawat_duSearchField, rawat_dmSearchField,rawat_dultahSearchField, rawat_dcardSearchField, rawat_dkolegaSearchField, rawat_dkeluargaSearchField, rawat_downerSearchField, rawat_dgroomingSearchField ] 
			}
 
			,{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [rawat_durasiSearchField, rawat_pointSearchField, 
				<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_PERAWATAN'))){ ?>
					rawat_kreditSearchField, 
				<? } ?>
				rawat_jumlah_tindakanSearchField, rawat_hargaSearchField, rawat_kontribusiSearchField, rawat_gudangSearchField, rawat_keteranganSearchField, rawat_aktifSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: perawatan_list_search
			},{
				text: 'Close',
				handler: function(){
					perawatan_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	perawatan_searchWindow = new Ext.Window({
		title: 'Pencarian Perawatan',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_perawatan_search',
		items: perawatan_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!perawatan_searchWindow.isVisible()){
			perawatan_reset_SearchForm();
			perawatan_searchWindow.show();
		} else {
			perawatan_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function perawatan_print(){
		var searchquery = "";
		var rawat_kode_print=null;
		var rawat_kodelama_print=null;
		var rawat_nama_print=null;
		var rawat_group_print=null;
		var rawat_kategori_print=null;
		var rawat_jenis_print=null;
		var rawat_keterangan_print=null;
		var rawat_du_print=null;
		var rawat_dm_print=null;
		var rawat_dultah_print=null;
		var rawat_dcard_print=null;
		var rawat_dkolega_print=null;
		var rawat_dkeluarga_print=null;
		var rawat_downer_print=null;
		var rawat_dgrooming_print=null;
		var rawat_point_print=null;
		var rawat_kredit_print=null;
		var rawat_harga_print=null;
		var rawat_gudang_print=null;
		var rawat_aktif_print=null;
		var win;              
		// check if we do have some search data...
		if(perawatan_DataStore.baseParams.query!==null){searchquery = perawatan_DataStore.baseParams.query;}
		if(perawatan_DataStore.baseParams.rawat_kode!==null){rawat_kode_print = perawatan_DataStore.baseParams.rawat_kode;}
		if(perawatan_DataStore.baseParams.rawat_kodelama!==null){rawat_kodelama_print = perawatan_DataStore.baseParams.rawat_kodelama;}
		if(perawatan_DataStore.baseParams.rawat_nama!==null){rawat_nama_print = perawatan_DataStore.baseParams.rawat_nama;}
		if(perawatan_DataStore.baseParams.rawat_group!==null){rawat_group_print = perawatan_DataStore.baseParams.rawat_group;}
		if(perawatan_DataStore.baseParams.rawat_kategori!==null){rawat_kategori_print = perawatan_DataStore.baseParams.rawat_kategori;}
		if(perawatan_DataStore.baseParams.rawat_jenis!==null){rawat_jenis_print = perawatan_DataStore.baseParams.rawat_jenis;}
		if(perawatan_DataStore.baseParams.rawat_keterangan!==null){rawat_keterangan_print = perawatan_DataStore.baseParams.rawat_keterangan;}
		if(perawatan_DataStore.baseParams.rawat_du!==null){rawat_du_print = perawatan_DataStore.baseParams.rawat_du;}
		if(perawatan_DataStore.baseParams.rawat_dm!==null){rawat_dm_print = perawatan_DataStore.baseParams.rawat_dm;}
		if(perawatan_DataStore.baseParams.rawat_dultah!==null){rawat_dultah_print = perawatan_DataStore.baseParams.rawat_dultah;}
		if(perawatan_DataStore.baseParams.rawat_dcard!==null){rawat_dcard_print = perawatan_DataStore.baseParams.rawat_dcard;}
		if(perawatan_DataStore.baseParams.rawat_dkolega!==null){rawat_dkolega_print = perawatan_DataStore.baseParams.rawat_dkolega;}
		if(perawatan_DataStore.baseParams.rawat_dkeluarga!==null){rawat_dkeluarga_print = perawatan_DataStore.baseParams.rawat_dkeluarga;}
		if(perawatan_DataStore.baseParams.rawat_downer!==null){rawat_downer_print = perawatan_DataStore.baseParams.rawat_downer;}
		if(perawatan_DataStore.baseParams.rawat_dgrooming!==null){rawat_dgrooming_print = perawatan_DataStore.baseParams.rawat_dgrooming;}
		if(perawatan_DataStore.baseParams.rawat_point!==null){rawat_point_print = perawatan_DataStore.baseParams.rawat_point;}
		if(perawatan_DataStore.baseParams.rawat_kredit!==null){rawat_kredit_print = perawatan_DataStore.baseParams.rawat_kredit;}
		if(perawatan_DataStore.baseParams.rawat_harga!==null){rawat_harga_print = perawatan_DataStore.baseParams.rawat_harga;}
		if(perawatan_DataStore.baseParams.rawat_gudang!==null){rawat_gudang_print = perawatan_DataStore.baseParams.rawat_gudang;}
		if(perawatan_DataStore.baseParams.rawat_aktif!==null){rawat_aktif_print = perawatan_DataStore.baseParams.rawat_aktif;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_perawatan&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			rawat_kode : rawat_kode_print,
			rawat_kodelama : rawat_kodelama_print,
			rawat_nama : rawat_nama_print,
			rawat_group : rawat_group_print,
			rawat_kategori : rawat_kategori_print,
			rawat_jenis : rawat_jenis_print,
			rawat_keterangan : rawat_keterangan_print,
			rawat_du : rawat_du_print,
			rawat_dm : rawat_dm_print,
			rawat_dultah	: rawat_dultah_print,
			rawat_dcard		: rawat_dcard_print,
			rawat_dkolega	: rawat_dkolega_print,
			rawat_dkeluarga	: rawat_dkeluarga_print,
			rawat_downer	: rawat_downer_print,
			rawat_dgrooming	: rawat_dgrooming_print,
			rawat_point : rawat_point_print,
			rawat_kredit : rawat_kredit_print,
			rawat_harga : rawat_harga_print,
			rawat_gudang : rawat_gudang_print,
			rawat_aktif : rawat_aktif_print,
		  	currentlisting: perawatan_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./perawatanlist.html','perawatanlist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
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
	function perawatan_export_excel(){
		var searchquery = "";
		var rawat_kode_2excel=null;
		var rawat_kodelama_2excel=null;
		var rawat_nama_2excel=null;
		var rawat_group_2excel=null;
		var rawat_kategori_2excel=null;
		var rawat_jenis_2excel=null;
		var rawat_keterangan_2excel=null;
		var rawat_du_2excel=null;
		var rawat_dm_2excel=null;
		var rawat_dultah_2excel=null;
		var rawat_dcard_2excel=null;
		var rawat_dkolega_2excel=null;
		var rawat_dkeluarga_2excel=null;
		var rawat_downer_2excel=null;
		var rawat_dgrooming_2excel=null;
		var rawat_point_2excel=null;
		var rawat_harga_2excel=null;
		var rawat_gudang_2excel=null;
		var rawat_aktif_2excel=null;
		var win;              
		// check if we do have some search data...
		if(perawatan_DataStore.baseParams.query!==null){searchquery = perawatan_DataStore.baseParams.query;}
		if(perawatan_DataStore.baseParams.rawat_kode!==null){rawat_kode_2excel = perawatan_DataStore.baseParams.rawat_kode;}
		if(perawatan_DataStore.baseParams.rawat_kodelama!==null){rawat_kodelama_2excel = perawatan_DataStore.baseParams.rawat_kodelama;}
		if(perawatan_DataStore.baseParams.rawat_nama!==null){rawat_nama_2excel = perawatan_DataStore.baseParams.rawat_nama;}
		if(perawatan_DataStore.baseParams.rawat_group!==null){rawat_group_2excel = perawatan_DataStore.baseParams.rawat_group;}
		if(perawatan_DataStore.baseParams.rawat_kategori!==null){rawat_kategori_2excel = perawatan_DataStore.baseParams.rawat_kategori;}
		if(perawatan_DataStore.baseParams.rawat_jenis!==null){rawat_jenis_2excel = perawatan_DataStore.baseParams.rawat_jenis;}
		if(perawatan_DataStore.baseParams.rawat_keterangan!==null){rawat_keterangan_2excel = perawatan_DataStore.baseParams.rawat_keterangan;}
		if(perawatan_DataStore.baseParams.rawat_du!==null){rawat_du_2excel = perawatan_DataStore.baseParams.rawat_du;}
		if(perawatan_DataStore.baseParams.rawat_dm!==null){rawat_dm_2excel = perawatan_DataStore.baseParams.rawat_dm;}
		if(perawatan_DataStore.baseParams.rawat_dultah!==null){rawat_dultah_2excel = perawatan_DataStore.baseParams.rawat_dultah;}
		if(perawatan_DataStore.baseParams.rawat_dcard!==null){rawat_dcard_2excel = perawatan_DataStore.baseParams.rawat_dcard;}
		if(perawatan_DataStore.baseParams.rawat_dkolega!==null){rawat_dkolega_2excel = perawatan_DataStore.baseParams.rawat_dkolega;}
		if(perawatan_DataStore.baseParams.rawat_dkeluarga!==null){rawat_dkeluarga_2excel = perawatan_DataStore.baseParams.rawat_dkeluarga;}
		if(perawatan_DataStore.baseParams.rawat_downer!==null){rawat_downer_2excel = perawatan_DataStore.baseParams.rawat_downer;}
		if(perawatan_DataStore.baseParams.rawat_dgrooming!==null){rawat_dgrooming_2excel = perawatan_DataStore.baseParams.rawat_dgrooming;}
		if(perawatan_DataStore.baseParams.rawat_point!==null){rawat_point_2excel = perawatan_DataStore.baseParams.rawat_point;}
		if(perawatan_DataStore.baseParams.rawat_harga!==null){rawat_harga_2excel = perawatan_DataStore.baseParams.rawat_harga;}
		if(perawatan_DataStore.baseParams.rawat_gudang!==null){rawat_gudang_2excel = perawatan_DataStore.baseParams.rawat_gudang;}
		if(perawatan_DataStore.baseParams.rawat_aktif!==null){rawat_aktif_2excel = perawatan_DataStore.baseParams.rawat_aktif;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_perawatan&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			rawat_kode : rawat_kode_2excel,
			rawat_kodelama : rawat_kodelama_2excel,
			rawat_nama : rawat_nama_2excel,
			rawat_group : rawat_group_2excel,
			rawat_kategori : rawat_kategori_2excel,
			rawat_jenis : rawat_jenis_2excel,
			rawat_keterangan : rawat_keterangan_2excel,
			rawat_du : rawat_du_2excel,
			rawat_dm : rawat_dm_2excel,
			rawat_dultah	: rawat_dultah_2excel,
			rawat_dcard		: rawat_dcard_2excel,
			rawat_dkolega	: rawat_dkolega_2excel,
			rawat_dkeluarga	: rawat_dkeluarga_2excel,
			rawat_downer	: rawat_downer_2excel,
			rawat_dgrooming	: rawat_dgrooming_2excel,
			rawat_point : rawat_point_2excel,
			rawat_harga : rawat_harga_2excel,
			rawat_gudang : rawat_gudang_2excel,
			rawat_aktif : rawat_aktif_2excel,
		  	currentlisting: perawatan_DataStore.baseParams.task // this tells us if we are searching or not
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
	
	rawat_hargaField.on('focus',function(){ rawat_hargaField.setValue(convertToNumber(rawat_hargaField.getValue())); });
	rawat_hargaField.on('blur',function(){ rawat_hargaField.setValue(CurrencyFormatted(rawat_hargaField.getValue())); });
	rawat_harga_kiField.on('focus',function(){ rawat_harga_kiField.setValue(convertToNumber(rawat_harga_kiField.getValue())); });
	rawat_harga_kiField.on('blur',function(){ rawat_harga_kiField.setValue(CurrencyFormatted(rawat_harga_kiField.getValue())); });
	rawat_harga_mndField.on('focus',function(){ rawat_harga_mndField.setValue(convertToNumber(rawat_harga_mndField.getValue())); });
	rawat_harga_mndField.on('blur',function(){ rawat_harga_mndField.setValue(CurrencyFormatted(rawat_harga_mndField.getValue())); });
	rawat_harga_mdnField.on('focus',function(){ rawat_harga_mdnField.setValue(convertToNumber(rawat_harga_mdnField.getValue())); });
	rawat_harga_mdnField.on('blur',function(){ rawat_harga_mdnField.setValue(CurrencyFormatted(rawat_harga_mdnField.getValue())); });
	rawat_harga_ygkField.on('focus',function(){ rawat_harga_ygkField.setValue(convertToNumber(rawat_harga_ygkField.getValue())); });
	rawat_harga_ygkField.on('blur',function(){ rawat_harga_ygkField.setValue(CurrencyFormatted(rawat_harga_ygkField.getValue())); });
	rawat_harga_mtaField.on('focus',function(){ rawat_harga_mtaField.setValue(convertToNumber(rawat_harga_mtaField.getValue())); });
	rawat_harga_mtaField.on('blur',function(){ rawat_harga_mtaField.setValue(CurrencyFormatted(rawat_harga_mtaField.getValue())); });
	rawat_harga_lbkField.on('focus',function(){ rawat_harga_lbkField.setValue(convertToNumber(rawat_harga_lbkField.getValue())); });
	rawat_harga_lbkField.on('blur',function(){ rawat_harga_lbkField.setValue(CurrencyFormatted(rawat_harga_lbkField.getValue())); });
	rawat_harga_hrField.on('focus',function(){ rawat_harga_hrField.setValue(convertToNumber(rawat_harga_hrField.getValue())); });
	rawat_harga_hrField.on('blur',function(){ rawat_harga_hrField.setValue(CurrencyFormatted(rawat_harga_hrField.getValue())); });
	
	rawat_harga_tpField.on('focus',function(){ rawat_harga_tpField.setValue(convertToNumber(rawat_harga_tpField.getValue())); });
	rawat_harga_tpField.on('blur',function(){ rawat_harga_tpField.setValue(CurrencyFormatted(rawat_harga_tpField.getValue())); });
	
	rawat_harga_dpsField.on('focus',function(){ rawat_harga_dpsField.setValue(convertToNumber(rawat_harga_dpsField.getValue())); });
	rawat_harga_dpsField.on('blur',function(){ rawat_harga_dpsField.setValue(CurrencyFormatted(rawat_harga_dpsField.getValue())); });
	
	rawat_harga_jktField.on('focus',function(){ rawat_harga_jktField.setValue(convertToNumber(rawat_harga_jktField.getValue())); });
	rawat_harga_jktField.on('blur',function(){ rawat_harga_jktField.setValue(CurrencyFormatted(rawat_harga_jktField.getValue())); });
	
	rawat_harga_blpnField.on('focus',function(){ rawat_harga_blpnField.setValue(convertToNumber(rawat_harga_blpnField.getValue())); });
	rawat_harga_blpnField.on('blur',function(){ rawat_harga_blpnField.setValue(CurrencyFormatted(rawat_harga_blpnField.getValue())); });
	
	rawat_harga_kutaField.on('focus',function(){ rawat_harga_kutaField.setValue(convertToNumber(rawat_harga_kutaField.getValue())); });
	rawat_harga_kutaField.on('blur',function(){ rawat_harga_kutaField.setValue(CurrencyFormatted(rawat_harga_kutaField.getValue())); });
	
	rawat_harga_btmField.on('focus',function(){ rawat_harga_btmField.setValue(convertToNumber(rawat_harga_btmField.getValue())); });
	rawat_harga_btmField.on('blur',function(){ rawat_harga_btmField.setValue(CurrencyFormatted(rawat_harga_btmField.getValue())); });
	
	rawat_harga_smgField.on('focus',function(){ rawat_harga_smgField.setValue(convertToNumber(rawat_harga_smgField.getValue())); });
	rawat_harga_smgField.on('blur',function(){ rawat_harga_smgField.setValue(CurrencyFormatted(rawat_harga_smgField.getValue())); });
	
	rawat_harga_mksField.on('focus',function(){ rawat_harga_mksField.setValue(convertToNumber(rawat_harga_mksField.getValue())); });
	rawat_harga_mksField.on('blur',function(){ rawat_harga_mksField.setValue(CurrencyFormatted(rawat_harga_mksField.getValue())); });
	
	rawat_harga_mlgField.on('focus',function(){ rawat_harga_mlgField.setValue(convertToNumber(rawat_harga_mlgField.getValue())); });
	rawat_harga_mlgField.on('blur',function(){ rawat_harga_mlgField.setValue(CurrencyFormatted(rawat_harga_mlgField.getValue())); });
	
	//Events for poin dan kredit
	//rawat_kreditField
	rawat_kreditField.on("change",function(){
		rawat_kreditrpField.setValue(0);
	});
	
	rawat_kreditrpField.on("change",function(){
		rawat_kreditField.setValue(0);	
	});
	
	//Events for diskon
	rawat_duField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	rawat_dmField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	rawat_dultahField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	rawat_dcardField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	rawat_dkolegaField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	rawat_dkeluargaField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	rawat_downerField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	rawat_dgroomingField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	rawat_dwartawanField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	rawat_dstaffdokterField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	rawat_dstaffnondokterField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	rawat_dpromoField.on("keyup",function(){
		if(this.getRawValue()>100){
			this.setRawValue(100);
		}
	});
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_perawatan"></div>
        <div id="fp_perawatan_konsumsi"></div>
        <div id="fp_perawatan_alat"></div>
		<div id="elwindow_perawatan_create"></div>
        <div id="elwindow_perawatan_search"></div>
    </div>
</div>
</body>