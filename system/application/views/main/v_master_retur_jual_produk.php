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
var master_retur_jual_produk_DataStore;
var master_retur_jual_produk_ColumnModel;
var master_retur_jual_produkListEditorGrid;
var master_retur_jual_produk_createForm;
var master_retur_jual_produk_createWindow;
var master_retur_jual_produk_searchForm;
var master_retur_jual_produk_searchWindow;
var master_retur_jual_produk_SelectedRow;
var master_retur_jual_produk_ContextMenu;
//for detail data
var detail_retur_jual_produk_DataStor;
var detail_retur_jual_produkListEditorGrid;
var detail_retur_jual_produk_ColumnModel;
var detail_retur_jual_produk_proxy;
var detail_retur_jual_produk_writer;
var detail_retur_jual_produk_reader;
var editor_detail_retur_jual_produk;

//declare konstant
var rproduk_post2db = '';
var msg = '';
var rproduk_pageS=15;
var today=new Date().format('d-m-Y');

/* declare variable here for Field*/
var rproduk_idField;
var rproduk_nobuktiField;
var rproduk_nobuktijualField;
var rproduk_custField;
var rproduk_tanggalField;
var rproduk_keteranganField;
var rproduk_stat_dokField;
var rproduk_idSearchField;
var rproduk_nobuktiSearchField;
var rproduk_nobuktijualSearchField;
var rproduk_custSearchField;
var rproduk_tanggalSearchField;
var rproduk_tanggal_akhirSearchField;
var rproduk_keteranganSearchField;
var rproduk_stat_dokSearchField;

var rproduk_cetak_kuitansi = 0;

var dt= new Date();

function retur_jproduk_cetak(kwitansi_ref){
	Ext.Ajax.request({   
		waitMsg: 'Mohon tunggu...',
		url: 'index.php?c=c_master_retur_jual_produk&m=print_paper',
		params: { kwitansi_ref : kwitansi_ref}, 
		success: function(response){              
			var result=eval(response.responseText);
			switch(result){
			case 1:
				win = window.open('./kwitansi_paper.html','Cetak Kwitansi Retur Produk','height=480,width=1240,resizable=1,scrollbars=0, menubar=0');
				//
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

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
	
	Ext.util.Format.comboRenderer = function(combo){
  	    return function(value){
  	        var record = combo.findRecord(combo.valueField, value);
  	        return record ? record.get(combo.displayField) : combo.valueNotFoundText;
  	    }
  	}
  
  
	/*Function for pengecekan _dokumen */
	function pengecekan_dokumen(){
		var rproduk_tanggal_create_date = "";
	
		if(rproduk_tanggalField.getValue()!== ""){rproduk_tanggal_create_date = rproduk_tanggalField.getValue().format('Y-m-d');} 
		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_master_retur_jual_produk&m=get_action',
			params: {
				task: "CEK",
				tanggal_pengecekan	: rproduk_tanggal_create_date
		
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
							master_retur_jual_produk_create();
						break;
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Data Retur Penjualan Produk tidak bisa disimpan, karena telah melebihi batas hari yang diperbolehkan ',
						   buttons: Ext.MessageBox.OK,
						   animEl: 'save',
						   icon: Ext.MessageBox.WARNING
						});
						//jproduk_btn_cancel();
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

  	/* Function for Saving inLine Editing */
	function master_retur_jual_produk_update(oGrid_event){
		var rproduk_id_update_pk="";
		var rproduk_nobukti_update=null;
		var rproduk_nobuktijual_update=null;
		var rproduk_cust_update=null;
		var rproduk_tanggal_update_date="";
		var rproduk_keterangan_update=null;

		rproduk_id_update_pk = oGrid_event.record.data.rproduk_id;
		if(oGrid_event.record.data.rproduk_nobukti!== null){rproduk_nobukti_update = oGrid_event.record.data.rproduk_nobukti;}
		if(oGrid_event.record.data.rproduk_nobuktijual!== null){rproduk_nobuktijual_update = oGrid_event.record.data.rproduk_nobuktijual;}
		if(oGrid_event.record.data.rproduk_cust!== null){rproduk_cust_update = oGrid_event.record.data.rproduk_cust;}
	 	if(oGrid_event.record.data.rproduk_tanggal!== ""){rproduk_tanggal_update_date =oGrid_event.record.data.rproduk_tanggal.format('Y-m-d');}
		if(oGrid_event.record.data.rproduk_keterangan!== null){rproduk_keterangan_update = oGrid_event.record.data.rproduk_keterangan;}

		Ext.Ajax.request({  
			waitMsg: 'Mohon  Tunggu...',
			url: 'index.php?c=c_master_retur_jual_produk&m=get_action',
			params: {
				task: "UPDATE",
				rproduk_id	: rproduk_id_update_pk, 
				rproduk_nobukti	:rproduk_nobukti_update,  
				rproduk_nobuktijual	:rproduk_nobuktijual_update,  
				rproduk_cust	:rproduk_cust_update,  
				rproduk_tanggal	: rproduk_tanggal_update_date, 
				rproduk_keterangan	:rproduk_keterangan_update 
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						master_retur_jual_produk_DataStore.commitChanges();
						master_retur_jual_produk_DataStore.reload();
						break;
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Data retur penjualan produk tidak bisa disimpan',
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
	function master_retur_jual_produk_create(){
	
		if(is_master_retur_jual_produk_form_valid() && rproduk_post2db=='CREATE' && rproduk_stat_dokField.getValue()=='Terbuka'){
			var rproduk_id_create_pk=null; 
			var rproduk_nobukti_create=null; 
			var rproduk_nobuktijual_create=null; 
			var rproduk_cust_create=null; 
			var rproduk_tanggal_create_date=""; 
			var rproduk_keterangan_create=null;
			var rproduk_stat_dok_create=null;
			var rproduk_kwitansi_nilai_create=null; 
			var rproduk_kwitansi_keterangan_create=null;
			var rproduk_voucher_nilai_create=null;
			
			if(rproduk_idField.getValue()!== null){rproduk_id_create_pk = rproduk_idField.getValue();}else{rproduk_id_create_pk=get_pk_id();} 
			if(rproduk_nobuktiField.getValue()!== null){rproduk_nobukti_create = rproduk_nobuktiField.getValue();} 
			if(rproduk_nobuktijualField.getValue()!== null){rproduk_nobuktijual_create = rproduk_nobuktijualField.getValue();} 
			if(rproduk_custField.getValue()!== null){rproduk_cust_create = rproduk_custidField.getValue();} 
			if(rproduk_tanggalField.getValue()!== ""){rproduk_tanggal_create_date = rproduk_tanggalField.getValue().format('Y-m-d');} 
			if(rproduk_keteranganField.getValue()!== null){rproduk_keterangan_create = rproduk_keteranganField.getValue();}
			if(rproduk_stat_dokField.getValue()!== null){rproduk_stat_dok_create = rproduk_stat_dokField.getValue();} 
			if(rproduk_kwitansi_nilaiField.getValue()!== null){rproduk_kwitansi_nilai_create = rproduk_kwitansi_nilaiField.getValue();} 
			if(rproduk_voucher_nilaiField.getValue()!== null){rproduk_voucher_nilai_create = rproduk_voucher_nilaiField.getValue();}
			if(rproduk_kwitansi_keteranganField.getValue()!== null){rproduk_kwitansi_keterangan_create = rproduk_kwitansi_keteranganField.getValue();} 
			
			Ext.Ajax.request({  
				waitMsg: 'Mohon  Tunggu...',
				url: 'index.php?c=c_master_retur_jual_produk&m=get_action',
				params: {
					task: rproduk_post2db,
					rproduk_id	: rproduk_id_create_pk, 
					rproduk_nobukti	: rproduk_nobukti_create, 
					rproduk_nobuktijual	: rproduk_nobuktijual_create, 
					rproduk_cust	: rproduk_cust_create, 
					rproduk_tanggal	: rproduk_tanggal_create_date, 
					rproduk_keterangan	: rproduk_keterangan_create,
					rproduk_stat_dok		: rproduk_stat_dok_create,
					rproduk_kwitansi_nilai	: rproduk_kwitansi_nilai_create, 
					rproduk_kwitansi_keterangan	: rproduk_kwitansi_keterangan_create,
					rproduk_voucher				: rproduk_voucher_nilai_create
				}, 
				success: function(response){             
					//var result=eval(response.responseText);
					var result=response.responseText;
					if(result==0 || result==1){
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Data retur penjualan produk tidak bisa disimpan.',
						   buttons: Ext.MessageBox.OK,
						   animEl: 'save',
						   icon: Ext.MessageBox.WARNING
						});
					}/*else if(result==-1){
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'No.Faktur ini sudah pernah di-Retur.',
						   buttons: Ext.MessageBox.OK,
						   animEl: 'save',
						   icon: Ext.MessageBox.WARNING
						});
					}*/else{
						retur_jproduk_cetak(result);
						detail_retur_jual_produk_purge();
						detail_retur_jual_produk_insert();
						master_retur_jual_produk_DataStore.reload();
						master_retur_jual_produk_createWindow.hide();
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
		}else if(rproduk_post2db=='UPDATE' && rproduk_stat_dokField.getValue()=='Tertutup'){
			if(rproduk_cetak_kuitansi==1){
				retur_jproduk_cetak(rproduk_nobuktiField.getValue());
			}
			master_retur_jual_produk_DataStore.reload();
			master_retur_jual_produk_createWindow.hide();
		}else if(rproduk_post2db=='UPDATE' && rproduk_stat_dokField.getValue()=='Batal'){
			var rproduk_id_create_pk=rproduk_idField.getValue();
			Ext.Ajax.request({  
				waitMsg: 'Mohon  Tunggu...',
				url: 'index.php?c=c_master_retur_jual_produk&m=get_action',
				params: {
					task: 'BATAL',
					rproduk_id	: rproduk_id_create_pk
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					if(result==1){
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Data retur penjualan produk telah dibatalkan.',
						   buttons: Ext.MessageBox.OK,
						   animEl: 'save',
						   icon: Ext.MessageBox.OK
						});
						master_retur_jual_produk_DataStore.reload();
						master_retur_jual_produk_createWindow.hide();
					}else{
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Data retur penjualan produk tidak bisa dibatalkan.',
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
		}else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Form anda belum lengkap!',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
 	/* End of Function */
  
  	/* Function for get PK field */
	function get_pk_id(){
		if(rproduk_post2db=='UPDATE')
			return master_retur_jual_produkListEditorGrid.getSelectionModel().getSelected().get('rproduk_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function master_retur_jual_produk_reset_form(){
		rproduk_idField.reset();
		rproduk_idField.setValue(null);
		rproduk_nobuktiField.reset();
		rproduk_nobuktiField.setValue(null);
		rproduk_nobuktijualField.reset();
		rproduk_nobuktijualField.setValue(null);
		rproduk_custField.reset();
		rproduk_custField.setValue(null);
		rproduk_tanggalField.reset();
		rproduk_tanggalField.setValue(dt.format('Y-m-d'));
		rproduk_keteranganField.reset();
		rproduk_keteranganField.setValue(null);
		rproduk_stat_dokField.reset();
		rproduk_stat_dokField.setValue('Terbuka');
		rproduk_voucher_nilaicfField.reset();
		rproduk_voucher_nilaicfField.setValue(null);
		rproduk_voucher_nilaiField.reset();
		rproduk_voucher_nilaiField.setValue(null);
		rproduk_kwitansi_nilaiField.reset();
		rproduk_kwitansi_nilaiField.setValue(null);
		rproduk_kwitansi_nilai_cfField.reset();
		rproduk_kwitansi_nilai_cfField.setValue(null);
		rproduk_nobuktijualField.setDisabled(false);
		rproduk_custField.setDisabled(false);
		rproduk_tanggalField.setDisabled(false);
		if(rproduk_stat_dokField.getValue()=='Tertutup'){
			detail_retur_jual_produkListEditorGrid.setDisabled(true);
			rproduk_keteranganField.setDisabled(true);
			rproduk_kwitansi_keteranganField.setDisabled(true);
			rproduk_voucher_nilaicfField.setDisabled(true);
		}else if(rproduk_stat_dokField.getValue()=='Terbuka'){
			detail_retur_jual_produkListEditorGrid.setDisabled(false);
			rproduk_keteranganField.setDisabled(false);
			rproduk_kwitansi_keteranganField.setDisabled(false);
			rproduk_voucher_nilaicfField.setDisabled(false);
		}
		detail_retur_jual_produk_DataStore.load({params: {master_id:0, start:0, limit:rproduk_pageS}});
		
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_RETURPRODUK'))){ ?>
		master_retur_jual_produk_createForm.save_btn.disable();
		master_retur_jual_produk_createForm.cetak_kuitansi_btn.enable();
		<?php } ?>
		
		cbo_drproduk_produkDataStore.load({params: {query: -1}});
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function master_retur_jual_produk_set_form(){
		rproduk_idField.setValue(master_retur_jual_produkListEditorGrid.getSelectionModel().getSelected().get('rproduk_id'));
		rproduk_nobuktiField.setValue(master_retur_jual_produkListEditorGrid.getSelectionModel().getSelected().get('rproduk_nobukti'));
		rproduk_nobuktijualField.setValue(master_retur_jual_produkListEditorGrid.getSelectionModel().getSelected().get('rproduk_nobuktijual'));
		rproduk_custField.setValue(master_retur_jual_produkListEditorGrid.getSelectionModel().getSelected().get('rproduk_cust'));
		rproduk_custidField.setValue(master_retur_jual_produkListEditorGrid.getSelectionModel().getSelected().get('rproduk_cust_id'));
		rproduk_tanggalField.setValue(master_retur_jual_produkListEditorGrid.getSelectionModel().getSelected().get('rproduk_tanggal'));
		rproduk_keteranganField.setValue(master_retur_jual_produkListEditorGrid.getSelectionModel().getSelected().get('rproduk_keterangan'));
		rproduk_stat_dokField.setValue(master_retur_jual_produkListEditorGrid.getSelectionModel().getSelected().get('rproduk_stat_dok'));
		rproduk_kwitansi_nilaiField.setValue(master_retur_jual_produkListEditorGrid.getSelectionModel().getSelected().get('kwitansi_nilai'));
		rproduk_kwitansi_nilai_cfField.setValue(master_retur_jual_produkListEditorGrid.getSelectionModel().getSelected().get('kwitansi_nilai'));
		rproduk_voucher_nilaicfField.setValue(master_retur_jual_produkListEditorGrid.getSelectionModel().getSelected().get('rproduk_voucher'));
		rproduk_kwitansi_keteranganField.setValue(master_retur_jual_produkListEditorGrid.getSelectionModel().getSelected().get('kwitansi_keterangan'));
		rproduk_nobuktijualField.setDisabled(true);
		rproduk_custField.setDisabled(true);
		rproduk_tanggalField.setDisabled(true);
		if(master_retur_jual_produkListEditorGrid.getSelectionModel().getSelected().get('rproduk_stat_dok')=='Tertutup'){
			detail_retur_jual_produkListEditorGrid.setDisabled(true);
			rproduk_keteranganField.setDisabled(true);
			rproduk_kwitansi_keteranganField.setDisabled(true);
			rproduk_voucher_nilaicfField.setDisabled(true);
		}else if(master_retur_jual_produkListEditorGrid.getSelectionModel().getSelected().get('rproduk_stat_dok')=='Terbuka'){
			detail_retur_jual_produkListEditorGrid.setDisabled(false);
			rproduk_keteranganField.setDisabled(false);
			rproduk_kwitansi_keteranganField.setDisabled(false);
			rproduk_voucher_nilaicfField.setDisabled(false);
		}
		
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_RETURPRODUK'))){ ?>
		master_retur_jual_produk_createForm.save_btn.enable();
		if((master_retur_jual_produkListEditorGrid.getSelectionModel().getSelected().get('rproduk_stat_dok')!=='Terbuka')){
			master_retur_jual_produk_createForm.cetak_kuitansi_btn.disable();
		}else{
			master_retur_jual_produk_createForm.cetak_kuitansi_btn.enable();
		}
		<?php } ?>
		
		rproduk_stat_dokField.on("select",function(){
		var status_awal = master_retur_jual_produkListEditorGrid.getSelectionModel().getSelected().get('rproduk_stat_dok');
		if(status_awal =='Terbuka' && rproduk_stat_dokField.getValue()=='Tertutup')
		{
		Ext.MessageBox.show({
			msg: 'Tidak bisa, harus print dulu supaya status menjadi Tertutup',
		   //progressText: 'proses...',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		rproduk_stat_dokField.setValue('Terbuka');
		}
		
		else if(status_awal =='Tertutup' && rproduk_stat_dokField.getValue()=='Terbuka')
		{
		Ext.MessageBox.show({
			msg: 'Status yang sudah Tertutup tidak dapat diganti Terbuka',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		rproduk_stat_dokField.setValue('Tertutup');
		}
		
		else if(status_awal =='Batal' && rproduk_stat_dokField.getValue()=='Terbuka')
		{
		Ext.MessageBox.show({
			msg: 'Status yang sudah Tertutup tidak dapat diganti Terbuka',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		rproduk_stat_dokField.setValue('Tertutup');
		}
		
		else if(rproduk_stat_dokField.getValue()=='Batal')
		{
		Ext.MessageBox.confirm('Confirmation','Apakah anda yakin merubah status ini menjadi Batal? status Batal sudah tidak bisa diganti lagi', rproduk_stat_dok_delete);
		}
		
		});		
	
	}
	/* End setValue to EDIT*/
	
	function rproduk_stat_dok_delete(btn){
	if(btn=='yes')
	{
		rproduk_stat_dokField.setValue('Batal');
	}  
	else
		rproduk_stat_dokField.setValue(master_retur_jual_produkListEditorGrid.getSelectionModel().getSelected().get('rproduk_stat_dok'));
	}
	
	
	/* function for set_status*/
	function master_retur_jual_produk_set_updating(){
		if(rproduk_post2db=="UPDATE" && master_retur_jual_produkListEditorGrid.getSelectionModel().getSelected().get('rproduk_stat_dok')=="Terbuka"){
				rproduk_custField.setDisabled(true);
                rproduk_tanggalField.setDisabled(true);
                rproduk_keteranganField.setDisabled(false);
                detail_retur_jual_produkListEditorGrid.setDisabled(false);
				rproduk_kwitansi_keteranganField.setDisabled(false);
                rproduk_stat_dokField.setDisabled(false);
		}
		if(rproduk_post2db=="UPDATE" && master_retur_jual_produkListEditorGrid.getSelectionModel().getSelected().get('rproduk_stat_dok')=="Tertutup"){
			    rproduk_custField.setDisabled(true);
                rproduk_tanggalField.setDisabled(true);
                rproduk_keteranganField.setDisabled(true);
                detail_retur_jual_produkListEditorGrid.setDisabled(true);
				rproduk_kwitansi_keteranganField.setDisabled(true);
                rproduk_stat_dokField.setDisabled(false);
		}
		if(rproduk_post2db=="UPDATE" && master_retur_jual_produkListEditorGrid.getSelectionModel().getSelected().get('rproduk_stat_dok')=="Batal"){
				rproduk_custField.setDisabled(true);
				rproduk_tanggalField.setDisabled(true);
				rproduk_keteranganField.setDisabled(true);
				rproduk_stat_dokField.setDisabled(true);
				detail_retur_jual_produkListEditorGrid.setDisabled(true);
				rproduk_kwitansi_keteranganField.setDisabled(true);
		}
	}
	

	/* Function for Check if the form is valid */
	function is_master_retur_jual_produk_form_valid(){
		return (true);
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		detail_retur_jual_produk_DataStore.load({params : {master_id : 0, start:0, limit:rproduk_pageS}});
		
		//cbo_retur_produk_DataStore.load();
		cbo_drproduk_satuanDataStore.load();
		if(!master_retur_jual_produk_createWindow.isVisible()){
			
			rproduk_post2db='CREATE';
			msg='created';
			master_retur_jual_produk_reset_form();
			master_retur_jual_produk_createWindow.show();
		} else {
			master_retur_jual_produk_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function master_retur_jual_produk_confirm_delete(){
		// only one master_retur_jual_produk is selected here
		if(master_retur_jual_produkListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', master_retur_jual_produk_delete);
		} else if(master_retur_jual_produkListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', master_retur_jual_produk_delete);
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Anda belum memilih data yang akan dihapus?',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
  
	/* Function for Update Confirm */
	function master_retur_jual_produk_confirm_update(){
		//master_retur_jual_produk_reset_form();
		cbo_drproduk_produkDataStore.load({params : {query : master_retur_jual_produkListEditorGrid.getSelectionModel().getSelected().get('rproduk_nobuktijual')}});
		cbo_drproduk_satuanDataStore.load();
		/* only one record is selected here */
		if(master_retur_jual_produkListEditorGrid.selModel.getCount() == 1) {
			//master_retur_jual_produk_set_form();
			rproduk_post2db='UPDATE';
			detail_retur_jual_produk_DataStore.load({
				params : {master_id : eval(get_pk_id()), start:0, limit:rproduk_pageS},
				callback: function(opts, success, response){
					master_retur_jual_produk_set_form();
					master_retur_jual_produk_set_updating();
				}
			});
			msg='updated';
			master_retur_jual_produk_createWindow.show();
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Anda belum memilih data yang akan diedit?',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
  
  	/* Function for Delete Record */
	function master_retur_jual_produk_delete(btn){
		if(btn=='yes'){
			var selections = master_retur_jual_produkListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< master_retur_jual_produkListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.rproduk_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Mohon tunggu...',
				url: 'index.php?c=c_master_retur_jual_produk&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							master_retur_jual_produk_DataStore.reload();
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
	master_retur_jual_produk_DataStore = new Ext.data.Store({
		id: 'master_retur_jual_produk_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_retur_jual_produk&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'rproduk_id'
		},[
			{name: 'rproduk_id', type: 'int', mapping: 'rproduk_id'}, 
			{name: 'rproduk_nobukti', type: 'string', mapping: 'rproduk_nobukti'}, 
			{name: 'rproduk_nobuktijual', type: 'string', mapping: 'jproduk_nobukti'}, 
			{name: 'rproduk_cust_no', type: 'string', mapping: 'cust_no'}, 
			{name: 'rproduk_cust', type: 'string', mapping: 'cust_nama'}, 
			{name: 'rproduk_cust_id', type: 'int', mapping: 'cust_id'}, 
			{name: 'rproduk_tanggal', type: 'date', dateFormat: 'Y-m-d', mapping: 'rproduk_tanggal'}, 
			{name: 'rproduk_keterangan', type: 'string', mapping: 'rproduk_keterangan'}, 
			{name: 'rproduk_voucher', type: 'float', mapping: 'rproduk_voucher'},
			{name: 'rproduk_stat_dok', type: 'string', mapping: 'rproduk_stat_dok'}, 
			{name: 'rproduk_creator', type: 'string', mapping: 'rproduk_creator'}, 
			{name: 'rproduk_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'rproduk_date_create'}, 
			{name: 'rproduk_update', type: 'string', mapping: 'rproduk_update'}, 
			{name: 'rproduk_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'rproduk_date_update'}, 
			{name: 'rproduk_revised', type: 'int', mapping: 'rproduk_revised'},
			{name: 'kwitansi_id', type: 'int', mapping: 'kwitansi_id'},
			{name: 'kwitansi_nilai', type: 'float', mapping: 'kwitansi_nilai'},
			{name: 'kwitansi_keterangan', type: 'string', mapping: 'kwitansi_keterangan'} 
		]),
		sortInfo:{field: 'rproduk_id', direction: "DESC"}
	});
	/* End of Function */
	
	/* Function for Retrieve DataStore */
	cbo_retur_produk_DataStore = new Ext.data.Store({
		id: 'cbo_retur_produk_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_retur_jual_produk&m=get_jual_produk_list', 
			method: 'POST'
		}),
		baseParams:{start: 0, limit: rproduk_pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'jproduk_id'
		},[
			{name: 'retur_produk_value', type: 'int', mapping: 'jproduk_id'},
			{name: 'retur_produk_display', type: 'string', mapping: 'jproduk_nobukti'},
			{name: 'retur_produk_tanggal', type: 'date', dateFormat: 'Y-m-d', mapping: 'jproduk_tanggal'},
			{name: 'retur_produk_nama_customer', type: 'string', mapping: 'cust_nama'},
			{name: 'retur_produk_customer_id', type: 'string', mapping: 'cust_id'},
			{name: 'retur_produk_alamat', type: 'string', mapping: 'cust_alamat'},
			{name: 'voucher', type: 'float', mapping: 'voucher'}
		]),
		sortInfo:{field: 'retur_produk_display', direction: "ASC"}
	});
	/* End of Function */
    
	
	//ComboBox ambil data Customer
	cbo_rproduk_customerDataStore = new Ext.data.Store({
		id: 'cbo_rproduk_customerDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_retur_jual_produk&m=get_customer_list', 
			method: 'POST'
		}),
		baseParams:{start: 0, limit:rproduk_pageS }, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'cust_id'
		},[
			{name: 'cust_id', type: 'int', mapping: 'cust_id'},
			{name: 'cust_no', type: 'string', mapping: 'cust_no'},
			{name: 'cust_nama', type: 'string', mapping: 'cust_nama'},
			{name: 'cust_tgllahir', type: 'date', dateFormat: 'Y-m-d', mapping: 'cust_tgllahir'},
			{name: 'cust_alamat', type: 'string', mapping: 'cust_alamat'},
			{name: 'cust_telprumah', type: 'string', mapping: 'cust_telprumah'}
		]),
		sortInfo:{field: 'cust_no', direction: "ASC"}
	});
	//Template yang akan tampil di ComboBox
	var customer_rproduk_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>({cust_no}) {cust_nama}</b><br/>',
			'Tgl Lahir: {cust_tgllahir:date("j M Y")}<br /></span>',
            'Alamat: {cust_alamat}<br/>',
			'Telp Rumah: {cust_telprumah}',
        '</div></tpl>'
    );
	
 	/* Function for Identify of Window Column Model */
	master_retur_jual_produk_ColumnModel = new Ext.grid.ColumnModel(
		[{
			align : 'Right',
			header: '<div align="center">' + '#' + '</div>',
			readOnly: true,
			dataIndex: 'rproduk_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},
		{
			header: '<div align="center">' + 'Tanggal' + '</div>',
			dataIndex: 'rproduk_tanggal',
			width: 70,	//150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y')
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_RETURPRODUK'))){ ?>
			,
			editor: new Ext.form.DateField({
				format: 'd-m-Y'
			})
			<?php } ?>
		}, 
		{
			header: '<div align="center">' + 'No Faktur' + '</div>',
			dataIndex: 'rproduk_nobukti',
			width: 100, //150,
			sortable: true
		}, 
		{
			header: '<div align="center">' + 'No Faktur Jual' + '</div>' ,
			dataIndex: 'rproduk_nobuktijual',
			width: 100, //150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_RETURPRODUK'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 100
          	})
			<?php } ?>
		}, 
		{
			header: '<div align="center">' + 'No Cust' + '</div>',
			dataIndex: 'rproduk_cust_no',
			width: 80,
			sortable: true,
			readOnly: true
		}, 
		{
			header: '<div align="center">' + 'Customer' + '</div>',
			dataIndex: 'rproduk_cust',
			width: 200, //150,
			sortable: true,
			readOnly: true
		}, 
		{
			header: '<div align="center">' + 'Nilai Kuitansi (Rp)' + '</div>',
			dataIndex: 'kwitansi_nilai',
			align: 'right',
			width: 100,
			sortable: true,
			readOnly: true,
			renderer: function(val){
				return '<span> '+Ext.util.Format.number(val,'0,000')+'</span>';
			}
		},
		{
			header: '<div align="center">' + 'Keterangan' + '</div>',
			dataIndex: 'rproduk_keterangan',
			width: 200, //150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_RETURPRODUK'))){ ?>
			,
			editor: new Ext.form.TextArea({
				maxLength: 250
          	})
			<?php } ?>
		}, 
		
		{
			header: '<div align="center">' + 'Stat Dok' + '</div>',
			dataIndex: 'rproduk_stat_dok',
			width: 60
		}, 
		
		{
			header: 'Creator',
			dataIndex: 'rproduk_creator',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Create on',
			dataIndex: 'rproduk_date_create',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Last Update by',
			dataIndex: 'rproduk_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Last Update on',
			dataIndex: 'rproduk_date_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Revised',
			dataIndex: 'rproduk_revised',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}	]);
	
	master_retur_jual_produk_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	master_retur_jual_produkListEditorGrid =  new Ext.grid.GridPanel({
		id: 'master_retur_jual_produkListEditorGrid',
		el: 'fp_master_retur_jual_produk',
		title: 'Daftar Retur Penjualan Produk',
		autoHeight: true,
		store: master_retur_jual_produk_DataStore, // DataStore
		cm: master_retur_jual_produk_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		trackMouseOver: false,
		//clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1220,	//800,
		bbar: new Ext.PagingToolbar({
			pageSize: rproduk_pageS,
			store: master_retur_jual_produk_DataStore,
			displayInfo: true
		}),
		/* Add Control on ToolBar */
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_RETURPRODUK'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<?php } ?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_RETURPRODUK'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: master_retur_jual_produk_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_RETURPRODUK'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: master_retur_jual_produk_confirm_delete   // Confirm before deleting
		}, '-', 
		<?php } ?>
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: master_retur_jual_produk_DataStore,
			params: {start: 0, limit: rproduk_pageS},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						master_retur_jual_produk_DataStore.baseParams={task:'LIST',start: 0, limit: rproduk_pageS};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Search By (aktif only)'});
				Ext.get(this.id).set({qtip:'- No Faktur<br>- No Faktur Jual<br>- No Cust<br>- Customer'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: master_retur_jual_produk_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: master_retur_jual_produk_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: master_retur_jual_produk_print  
		}
		]
	});
	master_retur_jual_produkListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	master_retur_jual_produk_ContextMenu = new Ext.menu.Menu({
		id: 'master_retur_jual_produk_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_RETURPRODUK'))){ ?>
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: master_retur_jual_produk_confirm_update
		},
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_RETURPRODUK'))){ ?>
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			disabled : true,
			handler: master_retur_jual_produk_confirm_delete 
		},
		<?php } ?>
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: master_retur_jual_produk_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: master_retur_jual_produk_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onmaster_retur_jual_produk_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		master_retur_jual_produk_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		master_retur_jual_produk_SelectedRow=rowIndex;
		master_retur_jual_produk_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function master_retur_jual_produk_editContextMenu(){
		master_retur_jual_produkListEditorGrid.startEditing(master_retur_jual_produk_SelectedRow,1);
  	}
	/* End of Function */
  	
	master_retur_jual_produkListEditorGrid.addListener('rowcontextmenu', onmaster_retur_jual_produk_ListEditGridContextMenu);
	master_retur_jual_produk_DataStore.load({params: {start: 0, limit: rproduk_pageS}});	// load DataStore
	master_retur_jual_produkListEditorGrid.on('afteredit', master_retur_jual_produk_update); // inLine Editing Record
	
	// Custom rendering Template
    var retur_jual_produk_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{retur_produk_display}</b> | Tgl Faktur:{retur_produk_tanggal:date("j M Y")}<br /></span>',
            'Customer: {retur_produk_nama_customer}&nbsp;&nbsp;&nbsp;[Alamat: {retur_produk_alamat}]',
        '</div></tpl>'
    );
	
	/* Identify  rproduk_id Field */
	rproduk_idField= new Ext.form.NumberField({
		id: 'rproduk_idField',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: false,
		hidden: true,
		hideLabel: true,
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  rproduk_nobukti Field */
	rproduk_nobuktiField= new Ext.form.TextField({
		id: 'rproduk_nobuktiField',
		fieldLabel: 'No Faktur',
		maxLength: 100,
		readOnly: true,
		anchor: '95%'
	});
	/* Identify  rproduk_nobuktijual Field */
	rproduk_nobuktijualField= new Ext.form.ComboBox({
		id: 'rproduk_nobuktijualField',
		fieldLabel: 'No Faktur Jual',
		store: cbo_retur_produk_DataStore,
		mode: 'remote',
		displayField:'retur_produk_display',
		valueField: 'retur_produk_value',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: retur_jual_produk_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});
	
	/* Identify  rproduk_cust Field */
	/*rproduk_custField= new Ext.form.ComboBox({
		fieldLabel: 'Customer',
		store: cbo_rproduk_customerDataStore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
		tpl: customer_rproduk_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		allowBlank: false,
		disabled:false,
		anchor: '95%'
	});*/
	rproduk_custField= new Ext.form.TextField({
		id: 'rproduk_custField',
		fieldLabel: 'Customer',
		readOnly: true,
		anchor: '95%'
	});
	
	
	rproduk_custidField= new Ext.form.NumberField();
	/* Identify  rproduk_tanggal Field */
	rproduk_tanggalField= new Ext.form.DateField({
		id: 'rproduk_tanggalField',
		fieldLabel: 'Tanggal',
		format : 'd-m-Y',
	});
	/* Identify  rproduk_keterangan Field */
	rproduk_keteranganField= new Ext.form.TextArea({
		id: 'rproduk_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '95%'
	});
	
	/* Identify rproduk_stat_dok Field */
	rproduk_stat_dokField= new Ext.form.ComboBox({
		id: 'rproduk_stat_dokField',
		fieldLabel: 'Status Dok',
		store:new Ext.data.SimpleStore({
			fields:['rproduk_stat_dok_value', 'rproduk_stat_dok_display'],
			data:[['Terbuka','Terbuka'],['Tertutup','Tertutup'],['Batal', 'Batal']]
		}),
		mode: 'local',
		displayField: 'rproduk_stat_dok_display',
		valueField: 'rproduk_stat_dok_value',
		width: 98,
		allowBlank: false,
		editable: false,
		triggerAction: 'all'	
	});
	
	rproduk_voucher_nilaicfField= new Ext.form.TextField({
		id: 'rproduk_voucher_nilaicfField',
		fieldLabel: 'Nilai Potongan (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		itemCls: 'rmoney',
		//readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/ 
	});
	rproduk_voucher_nilaiField= new Ext.form.NumberField({
		id: 'rproduk_voucher_nilaiField',
		fieldLabel: 'Nilai Potongan (Rp)',
		enableKeyEvents: true,
		//valueRenderer: 'numberToCurrency',
		//allowNegatife : false,
		//blankText: '0',
		//allowDecimals: true,
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	
	/*rproduk_kwitansi_nilaiField= new Ext.form.NumberField({
		id: 'rproduk_kwitansi_nilaiField',
		fieldLabel: 'Nilai Kuitansi (Rp)',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: true,
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});*/
	
	rproduk_kwitansi_nilai_cfField= new Ext.form.TextField({
		id: 'rproduk_kwitansi_nilai_cfField',
		fieldLabel: 'Nilai Kuitansi (Rp)',
		allowNegatife : false,
		enableKeyEvents: true,
		allowDecimals : false,
		itemCls: 'rmoney',
		width: 120,
		readOnly : true,
		maskRe: /([0-9]+)$/ 
	});
	
	rproduk_kwitansi_nilaiField= new Ext.form.NumberField({
		id: 'rproduk_kwitansi_nilaiField',
		enableKeyEvents: true,
		fieldLabel: 'Nilai Kuitansi (Rp)',
		allowBlank: true,
		anchor : '95%',
		readOnly : true,
		itemCls : 'rmoney',
		maskRe: /([0-9]+)$/
	});
	
	/*
	rproduk_kwitansi_nilaiField= new Ext.ux.form.CFTextField({
		id: 'rproduk_kwitansi_nilaiField',
		fieldLabel: 'Nilai Kuitansi (Rp)',
		valueRenderer: 'numberToCurrency',
		readOnly: true,
		anchor: '95%'
	});
	*/
	
	
	rproduk_kwitansi_keteranganField= new Ext.form.TextArea({
		id: 'rproduk_kwitansi_keteranganField',
		fieldLabel: 'Keterangan Kuitansi',
		maxLength: 250,
		anchor: '95%'
	});
	
	rproduk_nobuktijualField.on('select', function(){
		var j=cbo_retur_produk_DataStore.findExact('retur_produk_value',rproduk_nobuktijualField.getValue(),0);
		if(cbo_retur_produk_DataStore.getCount()){
			rproduk_custField.setValue(cbo_retur_produk_DataStore.getAt(j).data.retur_produk_nama_customer);
			rproduk_custidField.setValue(cbo_retur_produk_DataStore.getAt(j).data.retur_produk_customer_id);	
			rproduk_voucher_nilaiField.setValue(cbo_retur_produk_DataStore.getAt(j).data.voucher);
			rproduk_voucher_nilaicfField.setValue(CurrencyFormatted(cbo_retur_produk_DataStore.getAt(j).data.voucher));
			cbo_drproduk_produkDataStore.load({params: {query: rproduk_nobuktijualField.getValue()}});
		}
	});
	
  	/*Fieldset Master*/
	master_retur_jual_produk_masterGroup = new Ext.form.FieldSet({
		title: 'Master',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [rproduk_nobuktiField, rproduk_nobuktijualField, rproduk_custField] 
			}
			,{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [rproduk_tanggalField, rproduk_keteranganField, rproduk_stat_dokField, rproduk_idField] 
			}
			]
	
	});
	
		
	/*Detail Declaration */
		
	// Function for json reader of detail
	var detail_retur_jual_produk_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: ''
	},[
			{name: 'drproduk_id', type: 'int', mapping: 'drproduk_id'}, 
			{name: 'drproduk_master', type: 'int', mapping: 'drproduk_master'}, 
			{name: 'drproduk_produk', type: 'int', mapping: 'drproduk_produk'}, 
			{name: 'drproduk_satuan', type: 'int', mapping: 'drproduk_satuan'}, 
			//{name: 'drproduk_satuan', type: 'string', mapping: 'satuan_nama'}, 
			{name: 'drproduk_jumlah', type: 'int', mapping: 'drproduk_jumlah'},
			{name: 'sisa_produk', type: 'int', mapping: 'sisa_produk'},	
			{name: 'drproduk_harga', type: 'float', mapping: 'drproduk_harga'} 
	]);
	//eof
	
	//function for json writer of detail
	var detail_retur_jual_produk_writer = new Ext.data.JsonWriter({
		encode: true,
		writeAllFields: false
	});
	//eof
	
	/* Function for Retrieve DataStore of detail*/
	detail_retur_jual_produk_DataStore = new Ext.data.Store({
		id: 'detail_retur_jual_produk_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_retur_jual_produk&m=detail_detail_retur_jual_produk_list', 
			method: 'POST'
		}),
		reader: detail_retur_jual_produk_reader,
		baseParams:{master_id: rproduk_idField.getValue()},
		sortInfo:{field: 'drproduk_id', direction: "ASC"}
	});
	/* End of Function */
	
	//function for editor of detail
	var editor_detail_retur_jual_produk= new Ext.ux.grid.RowEditor({
        saveText: 'Update'
    });
	//eof
	
	cbo_drproduk_produkDataStore = new Ext.data.Store({
		id: 'cbo_drproduk_produkDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_retur_jual_produk&m=get_produk_list', 
			method: 'POST'
		}),baseParams: {start: 0, limit: 30 },
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'produk_id'
		},[
			{name: 'drproduk_produk_value', type: 'int', mapping: 'produk_id'},
			{name: 'drproduk_produk_harga', type: 'float', mapping: 'retur_produk_harga'},
			//{name: 'drproduk_produk_satuan', type: 'string', mapping: 'satuan_kode'},
			{name: 'drproduk_produk_satuan', type: 'int', mapping: 'satuan_id'},
			{name: 'drproduk_produk_display', type: 'string', mapping: 'produk_nama'},
			{name: 'drproduk_produk_jumlah', type: 'int', mapping: 'dproduk_jumlah'},
			{name: 'drproduk_sisa_produk', type: 'int', mapping: 'sisa_produk'}
			
			
		]),
		sortInfo:{field: 'drproduk_produk_display', direction: "ASC"}
	});
	var produk_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span>{drproduk_produk_kode}| <b>{drproduk_produk_display}</b>',
		'</div></tpl>'
    );
	
	cbo_drproduk_satuanDataStore = new Ext.data.Store({
		id: 'cbo_drproduk_satuanDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_retur_jual_produk&m=get_satuan_list', 
			method: 'POST'
		}),baseParams: {start: 0, limit: 15 },
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'satuan_id'
		},[
			{name: 'drproduk_satuan_value', type: 'int', mapping: 'satuan_id'},
			{name: 'drproduk_satuan_display', type: 'string', mapping: 'satuan_kode'}
		]),
		sortInfo:{field: 'drproduk_satuan_display', direction: "ASC"}
	});
	
	//ComboBox ambil data Customer
	cbo_rproduk_customerDataStore = new Ext.data.Store({
		id: 'cbo_rproduk_customerDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_retur_jual_produk&m=get_customer_list', 
			method: 'POST'
		}),
		baseParams:{start: 0, limit:rproduk_pageS }, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'cust_id'
		},[
			{name: 'cust_id', type: 'int', mapping: 'cust_id'},
			{name: 'cust_no', type: 'string', mapping: 'cust_no'},
			{name: 'cust_nama', type: 'string', mapping: 'cust_nama'},
			{name: 'cust_tgllahir', type: 'date', dateFormat: 'Y-m-d', mapping: 'cust_tgllahir'},
			{name: 'cust_alamat', type: 'string', mapping: 'cust_alamat'},
			{name: 'cust_telprumah', type: 'string', mapping: 'cust_telprumah'}
		]),
		sortInfo:{field: 'cust_no', direction: "ASC"}
	});
	//Template yang akan tampil di ComboBox
	var customer_rproduk_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>({cust_no}) {cust_nama}</b><br/>',
			'Tgl Lahir: {cust_tgllahir:date("j M Y")}<br /></span>',
            'Alamat: {cust_alamat}<br/>',
			'Telp Rumah: {cust_telprumah}',
        '</div></tpl>'
    );
	

	var combo_retur_produk=new Ext.form.ComboBox({
			store: cbo_drproduk_produkDataStore,
			mode: 'local',
			displayField: 'drproduk_produk_display',
			valueField: 'drproduk_produk_value',
			typeAhead: false,
			loadingText: 'Searching...',
			pageSize:rproduk_pageS,
			hideTrigger:false,
			tpl: produk_tpl,
			//applyTo: 'search',
			itemSelector: 'div.search-item',
			triggerAction: 'all',
			lazyRender:true,
			listClass: 'x-combo-list-small',
			anchor: '95%'
	});
	combo_retur_produk.on('select', function(){
		var j=cbo_drproduk_produkDataStore.findExact('drproduk_produk_value', combo_retur_produk.getValue(), 0);
		if(cbo_drproduk_produkDataStore.getCount()){
			combo_retur_satuan.setValue(cbo_drproduk_produkDataStore.getAt(j).data.drproduk_produk_satuan);
			drproduk_jumlahField.setValue(cbo_drproduk_produkDataStore.getAt(j).data.drproduk_sisa_produk);
			temp_drproduk_jumlahField.setValue(cbo_drproduk_produkDataStore.getAt(j).data.drproduk_sisa_produk);
			drproduk_hargaField.setValue(cbo_drproduk_produkDataStore.getAt(j).data.drproduk_produk_harga);
			drproduk_subtotalField.setValue(cbo_drproduk_produkDataStore.getAt(j).data.drproduk_sisa_produk * cbo_drproduk_produkDataStore.getAt(j).data.drproduk_produk_harga);
		}
	});
	
	var combo_retur_satuan=new Ext.form.ComboBox({
			store: cbo_drproduk_satuanDataStore,
			mode: 'local',
			typeAhead: true,
			displayField: 'drproduk_satuan_display',
			valueField: 'drproduk_satuan_value',
			triggerAction: 'all',
			disabled: true,
			anchor: '95%'
	});
	
	var temp_drproduk_jumlahField = new Ext.form.NumberField({
		allowDecimals: false,
		allowNegative: false,
		maxLength: 3,
		readOnly : true,
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	
	var drproduk_jumlahField= new Ext.form.NumberField({
		allowDecimals: false,
		allowNegative: false,
		blankText: '0',
		maxLength: 3,
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	drproduk_jumlahField.on('keyup', function(){
		var sub_total = 0;
		sub_total = drproduk_jumlahField.getValue()*drproduk_hargaField.getValue();
		drproduk_subtotalField.setValue(sub_total);
		if(this.getRawValue()>temp_drproduk_jumlahField.getValue()){ ////////////ini ganti
			this.setRawValue(temp_drproduk_jumlahField.getValue());
		}
	});
	
	var drproduk_hargaField= new Ext.form.NumberField({
		allowDecimals: false,
		allowNegative: false,
		blankText: '0',
		readOnly: true,
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	
	var drproduk_subtotalField= new Ext.form.NumberField({
		allowDecimals: false,
		allowNegative: false,
		blankText: '0',
		readOnly: true,
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	
	//declaration of detail coloumn model
	detail_retur_jual_produk_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: '<div align="center">' + 'Produk' + '</div>',
			dataIndex: 'drproduk_produk',
			width: 200,
			sortable: true,
			editor: combo_retur_produk,
			renderer: Ext.util.Format.comboRenderer(combo_retur_produk)
		},
		{
			header: '<div align="center">' + 'Satuan' + '</div>',
			dataIndex: 'drproduk_satuan',
			width: 80,
			sortable: true,
			readOnly: true,
			editor: combo_retur_satuan,
			renderer: Ext.util.Format.comboRenderer(combo_retur_satuan)
		},
		{
			header: '<div align="center">' + 'Jumlah' + '</div>',
			align: 'right',
			dataIndex: 'sisa_produk',
			width: 60,
			sortable: true,
			editor: drproduk_jumlahField,
			renderer: Ext.util.Format.numberRenderer('0,000')
		},
		{
			header: '<div align="center">' + 'Jumlah2' + '</div>',
			align: 'right',
			dataIndex: 'sisa_produk',
			width: 60,
			sortable: true,
			editor: temp_drproduk_jumlahField,
			hidden : true,
			renderer: Ext.util.Format.numberRenderer('0,000')
		},
		{
			header: '<div align="center">' + 'Harga (Rp)' + '</div>',
			align: 'right',
			dataIndex: 'drproduk_harga',
			width: 100,
			sortable: true,
			editor: drproduk_hargaField,
			renderer: Ext.util.Format.numberRenderer('0,000')
		},
		{
			header: '<div align="center">' + 'Sub Total (Rp)' + '</div>',
			align: 'right',
			dataIndex: 'drproduk_subtotal',
			width: 100,
			sortable: true,
			editor: drproduk_subtotalField,
			renderer: Ext.util.Format.numberRenderer('0,000')
			/*,renderer: function(v, params, record){
				return Ext.util.Format.number(record.data.drproduk_jumlah*record.data.drproduk_harga,'0,000');
			}*/
		}]
	);
	detail_retur_jual_produk_ColumnModel.defaultSortable= true;
	//eof
	
	
	
	//declaration of detail list editor grid
	detail_retur_jual_produkListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'detail_retur_jual_produkListEditorGrid',
		el: 'fp_detail_retur_jual_produk',
		title: 'Detail Retur Produk',
		height: 250,
		width: 690,
		autoScroll: true,
		store: detail_retur_jual_produk_DataStore, // DataStore
		colModel: detail_retur_jual_produk_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 5 5 5',
		plugins: [editor_detail_retur_jual_produk],
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true}/*,
		bbar: new Ext.PagingToolbar({
			pageSize: rproduk_pageS,
			store: detail_retur_jual_produk_DataStore,
			displayInfo: true
		})*/
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_RETURPRODUK'))){ ?>
		,
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: detail_retur_jual_produk_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			handler: detail_retur_jual_produk_confirm_delete
		}
		]
		<?php } ?>
	});
	//eof
	
	
	//function of detail add
	function detail_retur_jual_produk_add(){
		var edit_detail_retur_jual_produk= new detail_retur_jual_produkListEditorGrid.store.recordType({
			drproduk_id	:'',		
			drproduk_master	:'',		
			drproduk_produk	:'',		
			drproduk_jumlah	:'',		
			drproduk_harga	:''		
		});
		editor_detail_retur_jual_produk.stopEditing();
		detail_retur_jual_produk_DataStore.insert(0, edit_detail_retur_jual_produk);
		detail_retur_jual_produkListEditorGrid.getView().refresh();
		detail_retur_jual_produkListEditorGrid.getSelectionModel().selectRow(0);
		editor_detail_retur_jual_produk.startEditing(0);
	}
	
	//function for refresh detail
	/*function refresh_detail_retur_jual_produk(){
		var sum_subtotal_detail=0;
		//detail_retur_jual_produk_DataStore.commitChanges();
		detail_retur_jual_produkListEditorGrid.getView().refresh();
		detail_retur_produk_record=detail_retur_jual_produk_DataStore.getAt(0);
		if(detail_retur_jual_produk_DataStore.getCount()>=0){
			var dproduk = cbo_drproduk_produkDataStore.findExact('drproduk_produk_value',detail_retur_produk_record.data.drproduk_produk,0);
			if(dproduk>=0){
				detail_retur_produk_record.data.drproduk_satuan=cbo_drproduk_produkDataStore.getAt(dproduk).data.drproduk_produk_satuan;
				detail_retur_produk_record.data.drproduk_harga=cbo_drproduk_produkDataStore.getAt(dproduk).data.drproduk_produk_harga;
				
				for(i=0;i<detail_retur_jual_produk_DataStore.getCount();i++){
					sum_subtotal_detail+=(detail_retur_jual_produk_DataStore.getAt(i).data.drproduk_jumlah*cbo_drproduk_produkDataStore.getAt(dproduk).data.drproduk_produk_harga);
					rproduk_kwitansi_nilaiField.setValue(sum_subtotal_detail);
				}
			}
		}
	}*/
	//eof
	
	function refresh_detail_retur_jual_produk(){
		var sum_subtotal_detail=0;
		var voucher = rproduk_voucher_nilaiField.getValue();
		for(i=0;i<detail_retur_jual_produk_DataStore.getCount();i++){
			sum_subtotal_detail+=(detail_retur_jual_produk_DataStore.getAt(i).data.sisa_produk*detail_retur_jual_produk_DataStore.getAt(i).data.drproduk_harga);
			rproduk_kwitansi_nilaiField.setValue(sum_subtotal_detail-voucher);
			rproduk_kwitansi_nilai_cfField.setValue(CurrencyFormatted(sum_subtotal_detail-voucher));
		}
		
	}
	
	//function for insert detail
	function detail_retur_jual_produk_insert(){
		for(i=0;i<detail_retur_jual_produk_DataStore.getCount();i++){
			detail_retur_jual_produk_record=detail_retur_jual_produk_DataStore.getAt(i);
			Ext.Ajax.request({
				waitMsg: 'Mohon  Tunggu...',
				url: 'index.php?c=c_master_retur_jual_produk&m=detail_detail_retur_jual_produk_insert',
				params:{
				drproduk_id	: detail_retur_jual_produk_record.data.drproduk_id, 
				drproduk_master	: eval(rproduk_idField.getValue()), 
				drproduk_produk	: detail_retur_jual_produk_record.data.drproduk_produk, 
				drproduk_satuan	: detail_retur_jual_produk_record.data.drproduk_satuan, 
				drproduk_jumlah	: detail_retur_jual_produk_record.data.sisa_produk, 
				drproduk_harga	: detail_retur_jual_produk_record.data.drproduk_harga 
				
				}
			});
		}
	}
	//eof
	
	//function for purge detail
	function detail_retur_jual_produk_purge(){
		Ext.Ajax.request({
			waitMsg: 'Mohon  Tunggu...',
			url: 'index.php?c=c_master_retur_jual_produk&m=detail_detail_retur_jual_produk_purge',
			params:{ master_id: eval(rproduk_idField.getValue()) }
		});
	}
	//eof
	
	/* Function for Delete Confirm of detail */
	function detail_retur_jual_produk_confirm_delete(){
		// only one record is selected here
		if(detail_retur_jual_produkListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', detail_retur_jual_produk_delete);
		} else if(detail_retur_jual_produkListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', detail_retur_jual_produk_delete);
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Anda belum memilih data yang akan dihapus?',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
	//eof
	
	//function for Delete of detail
	function detail_retur_jual_produk_delete(btn){
		if(btn=='yes'){
			var s = detail_retur_jual_produkListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, r; r = s[i]; i++){
				detail_retur_jual_produk_DataStore.remove(r);
			}
		}  
	}
	//eof
	
	//event on update of detail data store
	detail_retur_jual_produk_DataStore.on('update', refresh_detail_retur_jual_produk);
	
	kwitansi_tercetakGroup = new Ext.form.FieldSet({
		title: 'Kuitansi Tercetak',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [rproduk_voucher_nilaicfField,rproduk_kwitansi_nilai_cfField] 
			}
			,{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [rproduk_kwitansi_keteranganField] 
			}
			]
	
	});
	
	/* Function for retrieve create Window Panel*/ 
	master_retur_jual_produk_createForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 700,        
		items: [master_retur_jual_produk_masterGroup,detail_retur_jual_produkListEditorGrid, kwitansi_tercetakGroup],
		buttons: [
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_RETURPRODUK'))){ ?>
			{
				text: 'Cetak Kuitansi',
				ref: '../cetak_kuitansi_btn',
				handler: rproduk_save_and_cetak
			},
			{
				text: 'Save',
				ref: '../save_btn',
				handler: rproduk_save
			},
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					master_retur_jual_produk_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	master_retur_jual_produk_createWindow= new Ext.Window({
		id: 'master_retur_jual_produk_createWindow',
		title: rproduk_post2db+'Retur Penjualan Produk',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_master_retur_jual_produk_create',
		items: master_retur_jual_produk_createForm
	});
	/* End Window */
	
	function rproduk_save_and_cetak(){
		rproduk_cetak_kuitansi = 1;
		master_retur_jual_produk_create();
	}
	
	function rproduk_save(){
		rproduk_cetak_kuitansi = 0;
		pengecekan_dokumen();
	}
	
	/* Function for action list search */
	function master_retur_jual_produk_list_search(){
		// render according to a SQL date format.
		var rproduk_nobukti_search=null;
		var rproduk_nobuktijual_search=null;
		var rproduk_cust_search=null;
		var rproduk_tanggal_search_date="";
		var rproduk_tanggal_akhir_search_date="";
		var rproduk_keterangan_search=null;
		var rproduk_stat_dok_search=null;

		if(rproduk_nobuktiSearchField.getValue()!==null){rproduk_nobukti_search=rproduk_nobuktiSearchField.getValue();}
		if(rproduk_nobuktijualSearchField.getValue()!==null){rproduk_nobuktijual_search=rproduk_nobuktijualSearchField.getValue();}
		if(rproduk_custSearchField.getValue()!==null){rproduk_cust_search=rproduk_custSearchField.getValue();}
		if(rproduk_tanggalSearchField.getValue()!==""){rproduk_tanggal_search_date=rproduk_tanggalSearchField.getValue().format('Y-m-d');}
		if(rproduk_tanggal_akhirSearchField.getValue()!==""){rproduk_tanggal_akhir_search_date=rproduk_tanggal_akhirSearchField.getValue().format('Y-m-d');}
		if(rproduk_keteranganSearchField.getValue()!==null){rproduk_keterangan_search=rproduk_keteranganSearchField.getValue();}
		if(rproduk_stat_dokSearchField.getValue()!==null){rproduk_stat_dok_search=rproduk_stat_dokSearchField.getValue();}
		// change the store parameters
		master_retur_jual_produk_DataStore.baseParams = {
			task: 'SEARCH',
			//variable here
			rproduk_nobukti	:	rproduk_nobukti_search, 
			rproduk_nobuktijual	:	rproduk_nobuktijual_search, 
			rproduk_cust	:	rproduk_cust_search, 
			rproduk_tanggal	:	rproduk_tanggal_search_date, 
			rproduk_tanggal_akhir : rproduk_tanggal_akhir_search_date,
			rproduk_keterangan	:	rproduk_keterangan_search,
			rproduk_stat_dok		:	rproduk_stat_dok_search
		};
		// Cause the datastore to do another query : 
		master_retur_jual_produk_DataStore.reload({params: {start: 0, limit: rproduk_pageS}});
	}
		
	/* Function for reset search result */
	function master_retur_jual_produk_reset_search(){
		// reset the store parameters
		master_retur_jual_produk_DataStore.baseParams = { task: 'LIST' };
		// Cause the datastore to do another query : 
		master_retur_jual_produk_DataStore.reload({params: {start: 0, limit: rproduk_pageS}});
		//master_retur_jual_produk_searchWindow.close();
	};
	/* End of Fuction */
	
	function master_retur_jual_reset_SearchForm(){
		rproduk_nobuktiSearchField.reset();
		rproduk_nobuktijualSearchField.reset();
		rproduk_custSearchField.reset();
		rproduk_tanggalSearchField.reset();
		rproduk_tanggal_akhirSearchField.reset();
		rproduk_tanggal_akhirSearchField.setValue(today);
		rproduk_keteranganSearchField.reset();
		rproduk_stat_dokSearchField.reset();
	}
	
	
	/* Field for search */
	/* Identify  rproduk_id Search Field */
	rproduk_idSearchField= new Ext.form.NumberField({
		id: 'rproduk_idSearchField',
		fieldLabel: 'Rproduk Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  rproduk_nobukti Search Field */
	rproduk_nobuktiSearchField= new Ext.form.TextField({
		id: 'rproduk_nobuktiSearchField',
		fieldLabel: 'No Faktur',
		maxLength: 100,
		anchor: '95%'
	
	});
	/* Identify  rproduk_nobuktijual Search Field */
	rproduk_nobuktijualSearchField= new Ext.form.TextField({
		id: 'rproduk_nobuktijualSearchField',
		fieldLabel: 'No Faktur Jual',
		maxLength: 100,
		anchor: '95%'
	
	});
	
	/* Identify  rproduk_cust Search Field */
	rproduk_custSearchField= new Ext.form.ComboBox({
		fieldLabel: 'Customer',
		store: cbo_rproduk_customerDataStore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_nama',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
		tpl: customer_rproduk_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		allowBlank: false,
		disabled:false,
		anchor: '95%'
	});
	
	/* Identify  rproduk_tanggal Search Field */
	rproduk_tanggalSearchField= new Ext.form.DateField({
		id: 'rproduk_tanggalSearchField',
		fieldLabel: 'Tanggal',
		format : 'd-m-Y',
	
	});
	/* Identify  rproduk_keterangan Search Field */
	rproduk_keteranganSearchField= new Ext.form.TextArea({
		id: 'rproduk_keteranganSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '95%'
	});
	
	rproduk_tanggal_akhirSearchField= new Ext.form.DateField({
		id: 'rproduk_tanggal_akhirSearchField',
		fieldLabel: 's/d',
		format : 'd-m-Y'
	});
	
	rproduk_label_tanggalField= new Ext.form.Label({ html: ' &nbsp; s/d  &nbsp;' });
    
	
	rproduk_tanggalSearchFieldSet=new Ext.form.FieldSet({
		id:'rproduk_tanggalSearchFieldSet',
		title: 'Opsi Tanggal',
		layout: 'column',
		boduStyle: 'padding: 5px;',
		frame: false,
		items:[rproduk_tanggalSearchField, rproduk_label_tanggalField, rproduk_tanggal_akhirSearchField]
	});
	
	
	rproduk_stat_dokSearchField= new Ext.form.ComboBox({
		id: 'rproduk_stat_dokSearchField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['value', 'rproduk_stat_dok'],
			data:[['Terbuka','Terbuka'],['Tertutup','Tertutup'],['Batal','Batal']]
		}),
		mode: 'local',
		displayField: 'rproduk_stat_dok',
		valueField: 'value',
		anchor: '80%',
		triggerAction: 'all'	 
	
	});
	

	/* Function for retrieve search Form Panel */
	master_retur_jual_produk_searchForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 500,        
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [rproduk_nobuktiSearchField, rproduk_nobuktijualSearchField, rproduk_custSearchField, rproduk_tanggalSearchFieldSet, rproduk_keteranganSearchField, rproduk_stat_dokSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: master_retur_jual_produk_list_search
			},{
				text: 'Close',
				handler: function(){
					master_retur_jual_produk_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	master_retur_jual_produk_searchWindow = new Ext.Window({
		title: 'Pencarian Retur Penjualan Produk',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_master_retur_jual_produk_search',
		items: master_retur_jual_produk_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!master_retur_jual_produk_searchWindow.isVisible()){
			master_retur_jual_reset_SearchForm();
			master_retur_jual_produk_searchWindow.show();
		} else {
			master_retur_jual_produk_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function master_retur_jual_produk_print(){
		var searchquery = "";
		var rproduk_nobukti_print=null;
		var rproduk_nobuktijual_print=null;
		var rproduk_cust_print=null;
		var rproduk_tanggal_print_date="";
		var rproduk_tanggal_akhir_print_date="";
		var rproduk_keterangan_print=null;
		var rproduk_stat_dok_print=null;
		var win;              
		// check if we do have some search data...
		if(master_retur_jual_produk_DataStore.baseParams.query!==null){searchquery = master_retur_jual_produk_DataStore.baseParams.query;}
		if(master_retur_jual_produk_DataStore.baseParams.rproduk_nobukti!==null){rproduk_nobukti_print = master_retur_jual_produk_DataStore.baseParams.rproduk_nobukti;}
		if(master_retur_jual_produk_DataStore.baseParams.rproduk_nobuktijual!==null){rproduk_nobuktijual_print = master_retur_jual_produk_DataStore.baseParams.rproduk_nobuktijual;}
		if(master_retur_jual_produk_DataStore.baseParams.rproduk_cust!==null){rproduk_cust_print = master_retur_jual_produk_DataStore.baseParams.rproduk_cust;}
		if(master_retur_jual_produk_DataStore.baseParams.rproduk_tanggal!==""){rproduk_tanggal_print_date = master_retur_jual_produk_DataStore.baseParams.rproduk_tanggal;}
		if(master_retur_jual_produk_DataStore.baseParams.rproduk_tanggal_akhir!==""){rproduk_tanggal_akhir_print_date = master_retur_jual_produk_DataStore.baseParams.rproduk_tanggal_akhir;}
		if(master_retur_jual_produk_DataStore.baseParams.rproduk_keterangan!==null){rproduk_keterangan_print = master_retur_jual_produk_DataStore.baseParams.rproduk_keterangan;}
		if(master_retur_jual_produk_DataStore.baseParams.rproduk_stat_dok!==null){rproduk_stat_dok_print = master_retur_jual_produk_DataStore.baseParams.rproduk_stat_dok;}

		Ext.Ajax.request({   
		waitMsg: 'Mohon  Tunggu...',
		url: 'index.php?c=c_master_retur_jual_produk&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			rproduk_nobukti	:	rproduk_nobukti_print, 
			rproduk_nobuktijual	:	rproduk_nobuktijual_print, 
			rproduk_cust	:	rproduk_cust_print, 
			rproduk_tanggal	:	rproduk_tanggal_print_date, 
			rproduk_tanggal_akhir : rproduk_tanggal_akhir_print_date,
			rproduk_keterangan	:	rproduk_keterangan_print,
			rproduk_stat_dok	:	rproduk_stat_dok_print,
		  	currentlisting: master_retur_jual_produk_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/master_retur_jual_produklist.html','master_retur_jual_produklist','height=400,width=900,resizable=1,scrollbars=1, menubar=1');
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
	function master_retur_jual_produk_export_excel(){
		var searchquery = "";
		var rproduk_nobukti_2excel=null;
		var rproduk_nobuktijual_2excel=null;
		var rproduk_cust_2excel=null;
		var rproduk_tanggal_2excel_date="";
		var rproduk_tanggal_akhir_2excel_date="";
		var rproduk_keterangan_2excel=null;
		var rproduk_stat_dok_2excel=null;
		var win;              
		// check if we do have some 2excel data...
		if(master_retur_jual_produk_DataStore.baseParams.query!==null){searchquery = master_retur_jual_produk_DataStore.baseParams.query;}
		if(master_retur_jual_produk_DataStore.baseParams.rproduk_nobukti!==null){rproduk_nobukti_2excel = master_retur_jual_produk_DataStore.baseParams.rproduk_nobukti;}
		if(master_retur_jual_produk_DataStore.baseParams.rproduk_nobuktijual!==null){rproduk_nobuktijual_2excel = master_retur_jual_produk_DataStore.baseParams.rproduk_nobuktijual;}
		if(master_retur_jual_produk_DataStore.baseParams.rproduk_cust!==null){rproduk_cust_2excel = master_retur_jual_produk_DataStore.baseParams.rproduk_cust;}
		if(master_retur_jual_produk_DataStore.baseParams.rproduk_tanggal!==""){rproduk_tanggal_2excel_date = master_retur_jual_produk_DataStore.baseParams.rproduk_tanggal;}
		if(master_retur_jual_produk_DataStore.baseParams.rproduk_tanggal_akhir!==""){rproduk_tanggal_akhir_2excel_date = master_retur_jual_produk_DataStore.baseParams.rproduk_tanggal_akhir;}
		if(master_retur_jual_produk_DataStore.baseParams.rproduk_keterangan!==null){rproduk_keterangan_2excel = master_retur_jual_produk_DataStore.baseParams.rproduk_keterangan;}
		if(master_retur_jual_produk_DataStore.baseParams.rproduk_stat_dok!==null){rproduk_stat_dok_2excel = master_retur_jual_produk_DataStore.baseParams.rproduk_stat_dok;}
		
		Ext.Ajax.request({   
		waitMsg: 'Mohon  Tunggu...',
		url: 'index.php?c=c_master_retur_jual_produk&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quick2excel, use this
			//if we are doing advanced 2excel, use this
			rproduk_nobukti	:	rproduk_nobukti_2excel, 
			rproduk_nobuktijual	:	rproduk_nobuktijual_2excel, 
			rproduk_cust	:	rproduk_cust_2excel, 
			rproduk_tanggal	:	rproduk_tanggal_2excel_date, 
			rproduk_tanggal_akhir : rproduk_tanggal_akhir_2excel_date,
			rproduk_keterangan	:	rproduk_keterangan_2excel,
			rproduk_stat_dok	:	rproduk_stat_dok_2excel,
		  	currentlisting: master_retur_jual_produk_DataStore.baseParams.task // this tells us if we are searching or not
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
	
	
	rproduk_voucher_nilaicfField.on("keyup",function(){
		var cf_value = rproduk_voucher_nilaicfField.getValue();
		var cf_tonumber = convertToNumber(cf_value);
		rproduk_voucher_nilaiField.setValue(cf_tonumber);
		//load_total_bayar();
		
		var number_tocf = CurrencyFormatted(cf_value);
		this.setRawValue(number_tocf);
		
		refresh_detail_retur_jual_produk();
		
	});
	
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_master_retur_jual_produk"></div>
         <div id="fp_detail_retur_jual_produk"></div>
		<div id="elwindow_master_retur_jual_produk_create"></div>
        <div id="elwindow_master_retur_jual_produk_search"></div>
    </div>
</div>
</body>