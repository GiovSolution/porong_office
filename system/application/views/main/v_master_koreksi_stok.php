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
var master_koreksi_stok_DataStore;
var master_koreksi_stok_ColumnModel;
var master_koreksi_stokListEditorGrid;
var master_koreksi_stok_createForm;
var master_koreksi_stok_createWindow;
var master_koreksi_stok_searchForm;
var master_koreksi_stok_searchWindow;
var master_koreksi_stok_SelectedRow;
var master_koreksi_stok_ContextMenu;
//for detail data
var detail_koreksi_stok_DataStore;
var detail_koreksi_stokListEditorGrid;
var detail_koreksi_stok_ColumnModel;
var detail_koreksi_stok_proxy;
var detail_koreksi_stok_writer;
var detail_koreksi_stok_reader;
var editor_detail_koreksi_stok;

//declare konstant
var koreksi_post2db = '';
var msg = '';
var pageS=15;
var koreksi_cetak=0;
var today=new Date().format('Y-m-d');

/* declare variable here for Field*/
var koreksi_idField;
var koreksi_noField;
var koreksi_gudangField;
var koreksi_tanggalField;
var koreksi_keteranganField;
var koreksi_idSearchField;
var koreksi_noSearchField;
var koreksi_gudangSearchField;
var koreksi_tgl_awalSearchField;
var koreksi_keteranganSearchField;
var koreksi_statusSearchField;

var koreksi_button_saveField;
var koreksi_button_saveprintField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
	
 /*Function for pengecekan _dokumen */
	function pengecekan_dokumen(){
		var koreksi_tanggal_create_date = "";
		if(koreksi_tanggalField.getValue()!== ""){koreksi_tanggal_create_date = koreksi_tanggalField.getValue().format('Y-m-d');} 
		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_master_koreksi_stok&m=get_action',
			params: {
				task: "CEK",
				tanggal_pengecekan	: koreksi_tanggal_create_date
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
						case 1:
							koreksi_cetak=1;
							master_koreksi_stok_create('print');
						break;
						default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Data Penyesuaian Stok tidak bisa disimpan, karena telah melebihi batas hari yang diperbolehkan ',
						   buttons: Ext.MessageBox.OK,
						   animEl: 'save',
						   icon: Ext.MessageBox.WARNING,
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
	
	/*Function for pengecekan _dokumen untuk save */
	function pengecekan_dokumen2(){
		var koreksi_tanggal_create_date = "";
		if(koreksi_tanggalField.getValue()!== ""){koreksi_tanggal_create_date = koreksi_tanggalField.getValue().format('Y-m-d');} 
		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_master_koreksi_stok&m=get_action',
			params: {
				task: "CEK",
				tanggal_pengecekan	: koreksi_tanggal_create_date
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
						case 1:
							master_koreksi_stok_create();
						break;
						default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Data Penyesuaian Stok tidak bisa disimpan, karena telah melebihi batas hari yang diperbolehkan ',
						   buttons: Ext.MessageBox.OK,
						   animEl: 'save',
						   icon: Ext.MessageBox.WARNING,
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
	
  	/* Function for add data, open window create form */
	function master_koreksi_stok_create(opsi){
		if(detail_koreksi_stok_DataStore.getCount()<1){
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Data detail harus ada minimal 1 (satu)',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
			
		}else if(is_master_koreksi_stok_form_valid()){	
		
		var koreksi_id_create_pk=null; 
		var koreksi_no_create_pk=null;
		var koreksi_gudang_create=null; 
		var koreksi_tgl_awal_create_date=""; 
		var koreksi_keterangan_create=null;
		var koreksi_status_create=null;
		
		koreksi_id_create_pk=get_pk_id();
		if(koreksi_noField.getValue()!== null){koreksi_no_create = koreksi_noField.getValue();} 
		if(koreksi_gudangField.getValue()!== null){koreksi_gudang_create = koreksi_gudangField.getValue();} 
		if(koreksi_tanggalField.getValue()!== ""){koreksi_tgl_awal_create_date = koreksi_tanggalField.getValue().format('Y-m-d');} 
		if(koreksi_keteranganField.getValue()!== null){koreksi_keterangan_create = koreksi_keteranganField.getValue();}
		if(koreksi_statusField.getValue()!== null){koreksi_status_create = koreksi_statusField.getValue();} 
		
		/*Insert Detail Penyesuaian Stok */
		var dkoreksi_id = [];
        var dkoreksi_produk = [];
        var dkoreksi_satuan = [];
        var dkoreksi_jmlawal = [];
		var dkoreksi_jmlkoreksi = [];
		var dkoreksi_jmlsaldo = [];
        var dkoreksi_ket=[];
		
        if(detail_koreksi_stok_DataStore.getCount()>0){
            for(i=0; i<detail_koreksi_stok_DataStore.getCount();i++){
                if((/^\d+$/.test(detail_koreksi_stok_DataStore.getAt(i).data.dkoreksi_produk))
				   && detail_koreksi_stok_DataStore.getAt(i).data.dkoreksi_produk!==undefined
				   && detail_koreksi_stok_DataStore.getAt(i).data.dkoreksi_produk!==''
				   && detail_koreksi_stok_DataStore.getAt(i).data.dkoreksi_produk!==0
				   && detail_koreksi_stok_DataStore.getAt(i).data.dkoreksi_satuan!==0
				   && detail_koreksi_stok_DataStore.getAt(i).data.dkoreksi_jmlkoreksi!==0){
                    
					if(detail_koreksi_stok_DataStore.getAt(i).data.dkoreksi_id==undefined ||
					   detail_koreksi_stok_DataStore.getAt(i).data.dkoreksi_id==''){
						detail_koreksi_stok_DataStore.getAt(i).data.dkoreksi_id=0;
					}
					
                  	dkoreksi_id.push(detail_koreksi_stok_DataStore.getAt(i).data.dkoreksi_id);
					dkoreksi_produk.push(detail_koreksi_stok_DataStore.getAt(i).data.dkoreksi_produk);
                   	dkoreksi_satuan.push(detail_koreksi_stok_DataStore.getAt(i).data.dkoreksi_satuan);
					dkoreksi_jmlawal.push(detail_koreksi_stok_DataStore.getAt(i).data.dkoreksi_jmlawal);
					dkoreksi_jmlkoreksi.push(detail_koreksi_stok_DataStore.getAt(i).data.dkoreksi_jmlkoreksi);
					dkoreksi_jmlsaldo.push(detail_koreksi_stok_DataStore.getAt(i).data.dkoreksi_jmlsaldo);
					dkoreksi_ket.push(detail_koreksi_stok_DataStore.getAt(i).data.dkoreksi_ket);
                }
            }
			
			var encoded_array_dkoreksi_id = Ext.encode(dkoreksi_id);
			var encoded_array_dkoreksi_produk = Ext.encode(dkoreksi_produk);
			var encoded_array_dkoreksi_satuan = Ext.encode(dkoreksi_satuan);
			var encoded_array_dkoreksi_jmlawal = Ext.encode(dkoreksi_jmlawal);
			var encoded_array_dkoreksi_jmlkoreksi = Ext.encode(dkoreksi_jmlkoreksi);
			var encoded_array_dkoreksi_jmlsaldo = Ext.encode(dkoreksi_jmlsaldo);
			var encoded_array_dkoreksi_ket = Ext.encode(dkoreksi_ket);
		}
		Ext.MessageBox.show({
			msg:   'Sedang memproses data, mohon tunggu hingga proses ini selesai agar keamanan data anda terjaga...',
			progressText: 'proses...',
			width:350,
			wait:true
		});
		
		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_master_koreksi_stok&m=get_action',
			params: {
				task				: koreksi_post2db,
				koreksi_id			: koreksi_id_create_pk, 
				koreksi_no			: koreksi_no_create,
				koreksi_gudang		: koreksi_gudang_create, 
				koreksi_tanggal		: koreksi_tgl_awal_create_date, 
				koreksi_keterangan	: koreksi_keterangan_create,
				koreksi_status		: koreksi_status_create,
				koreksi_cetak		: koreksi_cetak,
				
				/*Insert Detail Koreksi Stok */
					dkoreksi_id			: encoded_array_dkoreksi_id,
					//dkoreksi_master		: pkid, 
					dkoreksi_produk		: encoded_array_dkoreksi_produk,
					dkoreksi_satuan		: encoded_array_dkoreksi_satuan,
					dkoreksi_jmlawal	: encoded_array_dkoreksi_jmlawal,
					dkoreksi_jmlkoreksi	: encoded_array_dkoreksi_jmlkoreksi,
					dkoreksi_jmlsaldo	: encoded_array_dkoreksi_jmlsaldo,
					dkoreksi_ket		: encoded_array_dkoreksi_ket
				
			}, 
			success: function(response){             
				var result=eval(response.responseText);
				if(result!==0){
					if(opsi=='print'){
							master_koreksi_stok_cetak_faktur(result);
						}
						master_koreksi_stok_DataStore.reload();
						Ext.MessageBox.alert(koreksi_post2db+' OK','Data Koreksi Stok berhasil disimpan');
						master_koreksi_stok_createWindow.hide();
				}else{
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Data Penyesuaian Stok  tidak bisa disimpan',
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
				msg: 'Isian belum sempurna!.',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
 	/* End of Function */
  
  	/* Function for get PK field */
	function get_pk_id(){
		if(koreksi_post2db=='UPDATE')
			return master_koreksi_stokListEditorGrid.getSelectionModel().getSelected().get('koreksi_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	function check_gudang(){
		if(koreksi_gudangField.getValue()=="" || koreksi_gudangField.getValue()==null){
			detail_koreksi_stokListEditorGrid.setDisabled(true);
		}else{
			detail_koreksi_stokListEditorGrid.setDisabled(false);
		}
	}
	
	/* Reset form before loading */
	function master_koreksi_stok_reset_form(){
		koreksi_idField.reset();
		koreksi_idField.setValue(null);
		koreksi_noField.reset();
		koreksi_noField.setValue('(Auto)');
		koreksi_gudangField.reset();
		koreksi_gudangField.setValue(null);
		koreksi_tanggalField.reset();
		koreksi_tanggalField.setValue(today);
		koreksi_keteranganField.reset();
		koreksi_keteranganField.setValue(null);
		koreksi_statusField.reset();
		koreksi_statusField.setValue('Terbuka');
//		detail_koreksi_stok_DataStore.removeAll();				
		
		//cbo_stok_satuanDataStore.setBaseParam('task','detail');
		//cbo_stok_satuanDataStore.setBaseParam('master_id',-1);
		cbo_stok_satuanDataStore.load();
		
		//cbo_stok_produkDataStore.setBaseParam('master_id',-1);
		//cbo_stok_produkDataStore.setBaseParam('task','detail');
		//cbo_stok_produkDataStore.setBaseParam('gudang',0);
		cbo_stok_produkDataStore.load();
		detail_koreksi_stok_DataStore.setBaseParam('master_id', -1);		
		detail_koreksi_stok_DataStore.load();
		koreksi_button_saveprintField.setDisabled(false);
		master_koreksi_stok_createForm.psPrintOnlyButton.disable();
		koreksi_idField.setDisabled(false);
		koreksi_noField.setDisabled(false);
		koreksi_gudangField.setDisabled(false);
		koreksi_tanggalField.setDisabled(false);
		koreksi_keteranganField.setDisabled(false);
		koreksi_statusField.setDisabled(false);
		
		combo_stok_produk.setDisabled(false);
		combo_stok_satuan.setDisabled(false);
		stok_terkoreksiField.setDisabled(false)
		stok_saldoField.setDisabled(false);
		detail_koreksi_stokListEditorGrid.dkoreksi_add.enable();
		
		check_gudang();
	}
	
 	/* End of Function */
  
  	function get_gudang_id(){
		if(isNaN(parseInt(koreksi_gudangField.getValue())) || parseInt(koreksi_gudangField.getValue())==0)
		{
			return master_koreksi_stokListEditorGrid.getSelectionModel().getSelected().get('koreksi_gudang_id');
		}else{
			return koreksi_gudangField.getValue();
		}
	}
	
	/* setValue to EDIT */
	function master_koreksi_stok_set_form(){
		cbo_koreksi_gudangDataSore.load();
		
		koreksi_idField.setValue(master_koreksi_stokListEditorGrid.getSelectionModel().getSelected().get('koreksi_id'));
		koreksi_noField.setValue(master_koreksi_stokListEditorGrid.getSelectionModel().getSelected().get('koreksi_no'));
		koreksi_gudangField.setValue(master_koreksi_stokListEditorGrid.getSelectionModel().getSelected().get('koreksi_gudang'));
		koreksi_tanggalField.setValue(master_koreksi_stokListEditorGrid.getSelectionModel().getSelected().get('koreksi_tanggal'));
		koreksi_keteranganField.setValue(master_koreksi_stokListEditorGrid.getSelectionModel().getSelected().get('koreksi_keterangan'));
		koreksi_statusField.setValue(master_koreksi_stokListEditorGrid.getSelectionModel().getSelected().get('koreksi_status'));
		
		//LOAD DETAIL
		cbo_stok_satuanDataStore.setBaseParam('task','detail');
		cbo_stok_satuanDataStore.setBaseParam('master_id',get_pk_id());
		cbo_stok_satuanDataStore.load();
		
		koreksi_button_saveField.setDisabled(true);
		//koreksi_button_saveprintField.setDisabled(true);
								
		cbo_stok_produkDataStore.setBaseParam('master_id',get_pk_id());
		cbo_stok_produkDataStore.setBaseParam('task','detail');
		cbo_stok_produkDataStore.setBaseParam('gudang',master_koreksi_stokListEditorGrid.getSelectionModel().getSelected().get('koreksi_gudang_id'));
		cbo_stok_produkDataStore.load({
			callback: function(r,opt,success){
				if(success==true){
					detail_koreksi_stok_DataStore.setBaseParam('master_id',get_pk_id());
					detail_koreksi_stok_DataStore.load({
						callback: function(r,opt,success){
							if(success==true){
								Ext.MessageBox.hide();
								koreksi_button_saveField.setDisabled(false);
								//koreksi_button_saveprintField.setDisabled(false);
							}
						}
					});
				}
			}
		});
		
		check_gudang();
		//END OF DETAIL
		
		if(koreksi_post2db=="UPDATE" && master_koreksi_stokListEditorGrid.getSelectionModel().getSelected().get('koreksi_status')=="Terbuka"){
			koreksi_idField.setDisabled(false);
			koreksi_noField.setDisabled(false);
			koreksi_gudangField.setDisabled(false);
			koreksi_tanggalField.setDisabled(false);
			koreksi_keteranganField.setDisabled(false);
			koreksi_statusField.setDisabled(false);
			koreksi_button_saveprintField.setDisabled(false);
			
			combo_stok_produk.setDisabled(false);
			combo_stok_satuan.setDisabled(false);
			stok_terkoreksiField.setDisabled(false)
			stok_saldoField.setDisabled(false);
			detail_koreksi_stokListEditorGrid.dkoreksi_add.enable();
			master_koreksi_stok_createForm.psPrintOnlyButton.disable();
			koreksi_button_saveprintField.setDisabled(false);
			
		}
		if(koreksi_post2db=="UPDATE" && master_koreksi_stokListEditorGrid.getSelectionModel().getSelected().get('koreksi_status')=="Tertutup"){
			koreksi_idField.setDisabled(true);
			koreksi_noField.setDisabled(true);
			koreksi_gudangField.setDisabled(true);
			koreksi_tanggalField.setDisabled(true);
			koreksi_keteranganField.setDisabled(true);
			koreksi_statusField.setDisabled(false);
			if(koreksi_cetak==1){
					//jproduk_cetak(jproduk_id_for_cetak);
				koreksi_cetak=0;
			}
			
			combo_stok_produk.setDisabled(true);
			combo_stok_satuan.setDisabled(true);
			stok_terkoreksiField.setDisabled(true)
			stok_saldoField.setDisabled(true);
			detail_koreksi_stokListEditorGrid.dkoreksi_add.disable();
			master_koreksi_stok_createForm.psPrintOnlyButton.enable();
			koreksi_button_saveprintField.setDisabled(true);
			
		}
		if(koreksi_post2db=="UPDATE" && master_koreksi_stokListEditorGrid.getSelectionModel().getSelected().get('koreksi_status')=="Batal"){
			koreksi_idField.setDisabled(true);
			koreksi_noField.setDisabled(true);
			koreksi_gudangField.setDisabled(true);
			koreksi_tanggalField.setDisabled(true);
			koreksi_keteranganField.setDisabled(true);
			koreksi_statusField.setDisabled(true);
			koreksi_button_saveprintField.setDisabled(true);
			
			combo_stok_produk.setDisabled(true);
			combo_stok_satuan.setDisabled(true);
			stok_terkoreksiField.setDisabled(false)
			stok_saldoField.setDisabled(false);
			detail_koreksi_stokListEditorGrid.dkoreksi_add.disable();
			master_koreksi_stok_createForm.psPrintOnlyButton.enable();
			koreksi_button_saveprintField.setDisabled(true);
		}
		
		
		koreksi_statusField.on("select",function(){
		var status_awal = master_koreksi_stokListEditorGrid.getSelectionModel().getSelected().get('koreksi_status');
		if(status_awal =='Terbuka' && koreksi_statusField.getValue()=='Tertutup')
		{
		Ext.MessageBox.show({
			msg: 'Dokumen tidak bisa ditutup. Gunakan Save & Print untuk menutup dokumen',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		koreksi_statusField.setValue('Terbuka');
		}
		
		else if(status_awal =='Tertutup' && koreksi_statusField.getValue()=='Terbuka')
		{
		Ext.MessageBox.show({
			msg: 'Status yang sudah Tertutup tidak dapat diganti Terbuka',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		koreksi_statusField.setValue('Tertutup');
		}
		
		else if(status_awal =='Batal' && koreksi_statusField.getValue()=='Terbuka')
		{
		Ext.MessageBox.show({
			msg: 'Status yang sudah Tertutup tidak dapat diganti Terbuka',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		koreksi_statusField.setValue('Tertutup');
		}
		
		else if(koreksi_statusField.getValue()=='Batal')
		{
		Ext.MessageBox.confirm('Confirmation','Anda yakin untuk membatalkan dokumen ini? Pembatalan dokumen tidak bisa dikembalikan lagi', koreksi_status_batal);
		}
        
       else if(status_awal =='Tertutup' && koreksi_statusField.getValue()=='Tertutup'){
            <?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KOREKSI'))){ ?>
			koreksi_button_saveprintField.setDisabled(false);
			<?php } ?>
        }
		
		});	
	}
	/* End setValue to EDIT*/
  
  function koreksi_status_batal(btn){
		if(btn=='yes')
		{
			koreksi_statusField.setValue('Batal');
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KOREKSI'))){ ?>
			koreksi_button_saveprintField.setDisabled(true);
			<?php } ?>
		}  
		else
			koreksi_statusField.setValue(master_koreksi_stokListEditorGrid.getSelectionModel().getSelected().get('koreksi_status'));
	}
  
	/* Function for Check if the form is valid */
	function is_master_koreksi_stok_form_valid(){
		return (koreksi_gudangField.isValid());
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!master_koreksi_stok_createWindow.isVisible()){
			koreksi_post2db='CREATE';
			msg='created';
			master_koreksi_stok_reset_form();
			master_koreksi_stok_createWindow.show();
		} else {
			master_koreksi_stok_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function master_koreksi_stok_confirm_delete(){
		// only one master_koreksi_stok is selected here
		if(master_koreksi_stokListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', master_koreksi_stok_delete);
		} else if(master_koreksi_stokListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', master_koreksi_stok_delete);
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
  
	/*Function  for Print Only*/
	function ps_print_only(){
		if(koreksi_idField.getValue()==''){
			Ext.MessageBox.show({
			msg: 'Faktur PS tidak dapat dicetak, karena data kosong',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		}
		else{
			var koreksi_id = koreksi_idField.getValue();
			koreksi_cetak=1;
			
			master_koreksi_stok_cetak_faktur(koreksi_id);
			Ext.MessageBox.show({
				title: 'INFO',
				msg: 'Data berhasil di cetak kembali',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.INFO
			});
			
			master_koreksi_stok_DataStore.reload();
			master_koreksi_stok_createWindow.hide();
		}
	}
	
	/* Function for Update Confirm */
	function master_koreksi_stok_confirm_update(){
		/* only one record is selected here */
		if(master_koreksi_stokListEditorGrid.selModel.getCount() == 1) {
			koreksi_post2db='UPDATE';
			msg='updated';
			master_koreksi_stok_set_form();
			master_koreksi_stok_createWindow.show();
			Ext.MessageBox.show({
			   msg: 'Sedang memuat data, mohon tunggu...',
			   progressText: 'proses...',
			   width:350,
			   wait:true
			});
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Tidak ada data yang dipilih untuk diedit',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
  
  	/* Function for Delete Record */
	function master_koreksi_stok_delete(btn){
		if(btn=='yes'){
			var selections = master_koreksi_stokListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< master_koreksi_stokListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.koreksi_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_master_koreksi_stok&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							master_koreksi_stok_DataStore.reload();
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
	master_koreksi_stok_DataStore = new Ext.data.Store({
		id: 'master_koreksi_stok_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_koreksi_stok&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start: 0, limit: pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'koreksi_id'
		},[
			{name: 'koreksi_id', type: 'int', mapping: 'koreksi_id'}, 
			{name: 'koreksi_no', type: 'string', mapping: 'koreksi_no'},
			{name: 'koreksi_gudang', type: 'string', mapping: 'gudang_nama'},
			{name: 'koreksi_gudang_id', type: 'int', mapping: 'gudang_id'},
			{name: 'koreksi_tanggal', type: 'date', dateFormat: 'Y-m-d', mapping: 'koreksi_tanggal'}, 
			{name: 'koreksi_keterangan', type: 'string', mapping: 'koreksi_keterangan'},
			{name: 'koreksi_status', type: 'string', mapping: 'koreksi_status'}, 
			{name: 'koreksi_creator', type: 'string', mapping: 'koreksi_creator'}, 
			{name: 'koreksi_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'koreksi_date_create'}, 
			{name: 'koreksi_update', type: 'string', mapping: 'koreksi_update'}, 
			{name: 'koreksi_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'koreksi_date_update'}, 
			{name: 'koreksi_revised', type: 'int', mapping: 'koreksi_revised'} 
		]),
		sortInfo:{field: 'koreksi_id', direction: "DESC"}
	});
	/* End of Function */
	
	cbo_koreksi_gudangDataSore = new Ext.data.Store({
		id: 'cbo_koreksi_gudangDataSore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_koreksi_stok&m=get_gudang_list', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start: 0, limit: pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'gudang_id'
		},[
			{name: 'gudang_id', type: 'int', mapping: 'gudang_id'},
			{name: 'gudang_nama', type: 'string', mapping: 'gudang_nama'}
		]),
		sortInfo:{field: 'gudang_nama', direction: "ASC"}
	});
    
  	/* Function for Identify of Window Column Model */
	master_koreksi_stok_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'koreksi_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},{
			header: '<div align="center">Tanggal</div>',
			dataIndex: 'koreksi_tanggal',
			width: 70,	//100,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			readOnly: true
		},
		{
			header: '<div align="center">' + 'No PS' + '</div>',
			dataIndex: 'koreksi_no',
			width: 100,	//150,
			sortable: true,
			readOnly: true
		}, 		
		{
			header: '<div align="center">Gudang</div>',
			dataIndex: 'koreksi_gudang',
			width: 150,
			sortable: true,
			readOnly: true
		}, 
		{
			header: '<div align="center">Keterangan</div>',
			dataIndex: 'koreksi_keterangan',
			width: 200,
			sortable: true,
			readOnly: true
		}, 
		
		{
			header: '<div align="center">' + 'Stat Dok' + '</div>',
			dataIndex: 'koreksi_status',
			width: 60,
			readOnly: true
		}, 
		
		{
			header: 'Creator',
			dataIndex: 'koreksi_creator',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Create on',
			dataIndex: 'koreksi_date_create',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Last Update by',
			dataIndex: 'koreksi_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Last Update on',
			dataIndex: 'koreksi_date_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Revised',
			dataIndex: 'koreksi_revised',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}	
		]);
	
	master_koreksi_stok_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	master_koreksi_stokListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'master_koreksi_stokListEditorGrid',
		el: 'fp_master_koreksi_stok',
		title: 'Daftar Penyesuaian Stok',
		autoHeight: true,
		store: master_koreksi_stok_DataStore, // DataStore
		cm: master_koreksi_stok_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 800,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: master_koreksi_stok_DataStore,
			displayInfo: true
		}),
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_KOREKSI'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<?php } ?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_KOREKSI'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: master_koreksi_stok_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_KOREKSI'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			disabled : true,
			handler: master_koreksi_stok_confirm_delete   // Confirm before deleting
		}, '-',
		<?php } ?>
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: master_koreksi_stok_DataStore,
			params: {start: 0, limit: pageS},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						master_koreksi_stok_DataStore.baseParams={task:'LIST',start: 0, limit: pageS};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Search By (aktif only)'});
				Ext.get(this.id).set({qtip:'- No PS<br>- Gudang<br>- Keterangan<br>'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: master_koreksi_stok_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: master_koreksi_stok_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: master_koreksi_stok_print  
		}
		]
	});
	master_koreksi_stokListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	master_koreksi_stok_ContextMenu = new Ext.menu.Menu({
		id: 'master_koreksi_stok_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_KOREKSI'))){ ?>
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: master_koreksi_stok_confirm_update 
		},
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_KOREKSI'))){ ?>
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			disabled : true,
			handler: master_koreksi_stok_confirm_delete 
		},
		<?php } ?>
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: master_koreksi_stok_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: master_koreksi_stok_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onmaster_koreksi_stok_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		master_koreksi_stok_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		master_koreksi_stok_SelectedRow=rowIndex;
		master_koreksi_stok_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function master_koreksi_stok_editContextMenu(){
		master_koreksi_stokListEditorGrid.startEditing(master_koreksi_stok_SelectedRow,1);
  	}
	/* End of Function */
  	
	master_koreksi_stokListEditorGrid.addListener('rowcontextmenu', onmaster_koreksi_stok_ListEditGridContextMenu);
	master_koreksi_stok_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStore

	/* Identify  koreksi_id Field */
	koreksi_idField= new Ext.form.NumberField({
		id: 'koreksi_idField',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: false,
		hidden: true,
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	/* Identify  koreksi_no Field */
	koreksi_noField= new Ext.form.TextField({
		id: 'koreksi_noField',
		fieldLabel: 'No PS',
		emptyText: '(Auto)',
		readOnly: true,
		maxLength: 50,
		anchor: '95%'
	});
	
	/* Identify  koreksi_gudang Field */
	koreksi_gudangField= new Ext.form.ComboBox({
		id: 'koreksi_gudangField',
		fieldLabel: 'Gudang *',
		store: cbo_koreksi_gudangDataSore,
		displayField:'gudang_nama',
		valueField: 'gudang_id',
		mode : 'remote',
        typeAhead: false,
        hideTrigger:false,
		triggerAction: 'all',
		forceSelection: true,
		allowBlank: false,
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});

	/* Identify  label peringatan Field */
	label_disable_tanggalField= new Ext.form.Label({
		html: '(Tanggal akan otomatis ter-disabled setelah detail item dibawah ini terisi)'
	});
	
	/* Identify  koreksi_tanggal Field */
	koreksi_tanggalField= new Ext.form.DateField({
		id: 'koreksi_tanggalField',
		fieldLabel: 'Tanggal',
		format : 'Y-m-d',
		value: today
	});
	/* Identify  koreksi_keterangan Field */
	koreksi_keteranganField= new Ext.form.TextArea({
		id: 'koreksi_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 500,
		anchor: '95%'
	});
	
	koreksi_statusField= new Ext.form.ComboBox({
		id: 'koreksi_statusField',
		fieldLabel: 'Status Dok',
		forceSelection: true,
		store:new Ext.data.SimpleStore({
			fields:['koreksi_status_value', 'koreksi_status_display'],
			data:[['Terbuka','Terbuka'],['Tertutup','Tertutup'],['Batal', 'Batal']]
		}),
		mode: 'local',
		displayField: 'koreksi_status_display',
		valueField: 'koreksi_status_value',
		anchor: '80%',
		allowBlank: false,
		triggerAction: 'all'	
	});
	
  	/*Fieldset Master*/
	master_koreksi_stok_masterGroup = new Ext.form.FieldSet({
		title: 'Master',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [koreksi_noField, koreksi_gudangField, koreksi_tanggalField, label_disable_tanggalField, koreksi_idField] 
			}
			,{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [koreksi_keteranganField, koreksi_statusField] 
			}
			]
	});
	
	/*Detail Declaration */	
	// Function for json reader of detail
	var detail_koreksi_stok_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: 'dkoreksi_id'
	},[
			{name: 'dkoreksi_id', type: 'int', mapping: 'dkoreksi_id'}, 
			{name: 'dkoreksi_master', type: 'int', mapping: 'dkoreksi_master'}, 
			{name: 'dkoreksi_produk', type: 'int', mapping: 'dkoreksi_produk'}, 
			{name: 'dkoreksi_satuan', type: 'int', mapping: 'dkoreksi_satuan'}, 
			{name: 'dkoreksi_jmlawal', type: 'int', mapping: 'dkoreksi_jmlawal'}, 
			{name: 'dkoreksi_jmlkoreksi', type: 'int', mapping: 'dkoreksi_jmlkoreksi'}, 
			{name: 'dkoreksi_jmlsaldo', type: 'int', mapping: 'dkoreksi_jmlsaldo'}, 
			{name: 'dkoreksi_ket', type: 'string', mapping: 'dkoreksi_ket'} 
	]);
	//eof
	
	//function for json writer of detail
	var detail_koreksi_stok_writer = new Ext.data.JsonWriter({
		encode: true,
		writeAllFields: false
	});
	//eof
	
	/* Function for Retrieve DataStore of detail*/
	detail_koreksi_stok_DataStore = new Ext.data.Store({
		id: 'detail_koreksi_stok_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_koreksi_stok&m=detail_detail_koreksi_stok_list', 
			method: 'POST'
		}),
		reader: detail_koreksi_stok_reader,
		baseParams:{master_id: 0, start:0, limit: pageS, gudang: 0},
		sortInfo:{field: 'dkoreksi_id', direction: "ASC"}
	});
	/* End of Function */
	
	//function for editor of detail
	var editor_detail_koreksi_stok= new Ext.ux.grid.RowEditor({
        saveText: 'Update'
    });
	//eof
	
	Ext.util.Format.comboRenderer = function(combo){
		return function(value){
			var record = combo.findRecord(combo.valueField, value);
			return record ? record.get(combo.displayField) : combo.valueNotFoundText;
		}
	}
	
	cbo_stok_byprodukDataStore= new Ext.data.Store({
		id: 'cbo_stok_byprodukDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_koreksi_stok&m=get_produk_stok', 
			method: 'POST',
			timeout: 3600000,
		}),baseParams:{produk_id:0, gudang:0},
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'produk_id'
		},[
			{name: 'produk_id', type: 'int', mapping: 'produk_id'},
			{name: 'produk_nama', type: 'string', mapping: 'produk_nama'},
			{name: 'produk_kode', type: 'string', mapping: 'produk_kode'},
			{name: 'produk_satuan', type: 'string', mapping: 'satuan_nama'},
			{name: 'produk_satuan_id', type: 'int', mapping: 'satuan_id'},
			{name: 'produk_stok', type: 'float', mapping: 'jumlah_stok'}
		]),
		sortInfo:{field: 'produk_id', direction: "ASC"}
	});
	
	cbo_stok_produkDataStore = new Ext.data.Store({
		id: 'cbo_stok_produkDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_koreksi_stok&m=get_produk_list', 
			method: 'POST'
		}),baseParams:{start:0, limit:pageS, master_id:0, gudang:0, task:'detail'},
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'produk_id'
		},[
			{name: 'produk_id', type: 'int', mapping: 'produk_id'},
			{name: 'produk_nama', type: 'string', mapping: 'produk_nama'},
			{name: 'produk_kode', type: 'string', mapping: 'produk_kode'},
			{name: 'produk_satuan', type: 'string', mapping: 'satuan_nama'},
			{name: 'produk_satuan_id', type: 'int', mapping: 'satuan_id'}
		]),
		sortInfo:{field: 'produk_id', direction: "ASC"}
	});
	
	cbo_stok_satuanDataStore = new Ext.data.Store({
		id: 'cbo_stok_satuanDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_koreksi_stok&m=get_satuan_list', 
			method: 'POST'
		}),baseParams:{start:0, limit:pageS, task:'detail'},
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'satuan_id'
		},[
			{name: 'satuan_id', type: 'int', mapping: 'satuan_id'},
			{name: 'satuan_nama', type: 'string', mapping: 'satuan_nama'},
			{name: 'satuan_kode', type: 'string', mapping: 'satuan_kode'},
			{name: 'konversi_nilai', type: 'float', mapping: 'konversi_nilai'}
		]),
		sortInfo:{field: 'satuan_id', direction: "ASC"}
	});
	
	var produk_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{produk_nama} ({produk_kode})</b><br /></span>',
        '</div></tpl>'
    );
	
	var combo_stok_produk=new Ext.form.ComboBox({
		store: cbo_stok_produkDataStore,
		mode: 'remote',
		typeAhead: false,
		displayField: 'produk_nama',
		valueField: 'produk_id',
		triggerAction: 'all',
		lazyRender:true,
		loadingText: 'Searching...',
		pageSize: pageS,
		hideTrigger:false,
		tpl : produk_tpl,
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		listClass: 'x-combo-list-small',
		anchor: '95%'

	});
	
	var combo_stok_satuan=new Ext.form.ComboBox({
		store: cbo_stok_satuanDataStore,
		mode: 'local',
		typeAhead: true,
		displayField: 'satuan_nama',
		valueField: 'satuan_id',
		triggerAction: 'all',
		allowBlank: false
		//lazyRender:true
	});
	
	var stok_awalField=new Ext.form.NumberField({
		allowDecimals: true,
		allowNegative: true,
		blankText: '0',
		maxLength: 11,
		readOnly: true,
		maskRe: /([0-9.]+)$/
	});
	
	var stok_terkoreksiField=new Ext.form.NumberField({
		allowDecimals: true,
		allowNegative: true,
		blankText: '0',
		maxLength: 11,
		enableKeyEvents: true,
		maskRe: /([0-9.]+)$/
	});
	
	var stok_saldoField=new Ext.form.NumberField({
		allowDecimals: true,
		allowNegative: true,
		enableKeyEvents: true,
		blankText: '0',
		maxLength: 11,
		maskRe: /([0-9]+)$/
	});
	
	//declaration of detail coloumn model
	detail_koreksi_stok_ColumnModel = new Ext.grid.ColumnModel(
		[
		 {
			header: '<div align="center">ID</div>',
			dataIndex: 'dkoreksi_id',
			width: 80,	//350,
			sortable: true,
			readOnly: true,
			hidden: true
		},
		{
			header: '<div align="center">Produk</div>',
			dataIndex: 'dkoreksi_produk',
			width: 200,	//350,
			sortable: true,
			editor: combo_stok_produk,
			renderer: Ext.util.Format.comboRenderer(combo_stok_produk)
		},
		{
			header: '<div align="center">Satuan</div>',
			dataIndex: 'dkoreksi_satuan',
			width: 80,
			sortable: true,
			readOnly: true,
			editor: combo_stok_satuan,
			renderer: Ext.util.Format.comboRenderer(combo_stok_satuan)
		},
		{
			header: '<div align="center">S Awal Sebelum</div>',
			dataIndex: 'dkoreksi_jmlawal',
			width: 60,
			align: 'right',
			editor: stok_awalField,
			renderer: Ext.util.Format.numberRenderer('0,000.00'),
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">Koreksi</div>',
			dataIndex: 'dkoreksi_jmlkoreksi',
			width: 60,
			align: 'right',
			sortable: true,
			renderer: Ext.util.Format.numberRenderer('0,000.00'),
			editor: stok_terkoreksiField
		},
		{
			header: '<div align="center">S Awal Sesudah</div>',
			dataIndex: 'dkoreksi_jmlsaldo',
			width: 60,
			align: 'right',
			sortable: true,
			renderer: Ext.util.Format.numberRenderer('0,000.00'),
			editor: stok_saldoField
		}
		]
	);
	detail_koreksi_stok_ColumnModel.defaultSortable= true;
	//eof
	var detail_koreksi_pagingToolbar= new Ext.PagingToolbar({
			pageSize: pageS,
			store: detail_koreksi_stok_DataStore,
			displayInfo: true
		});
	
	//declaration of detail list editor grid
	detail_koreksi_stokListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'detail_koreksi_stokListEditorGrid',
		el: 'fp_detail_koreksi_stok',
		title: 'Detail Item',
		height: 450,
		width: 800,
		autoScroll: true,
		store: detail_koreksi_stok_DataStore, // DataStore
		colModel: detail_koreksi_stok_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 5 5 5',
		plugins: [editor_detail_koreksi_stok],
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true}
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KOREKSI'))){ ?>
		,
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			ref : '../dkoreksi_add',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: detail_koreksi_stok_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			disabled : true,
			handler: detail_koreksi_stok_confirm_delete
		}
		]
		<?php } ?>
	});
	//eof
	
	
	//function of detail add
	function detail_koreksi_stok_add(){
		var edit_detail_koreksi_stok= new detail_koreksi_stokListEditorGrid.store.recordType({
			dkoreksi_id			: 0,		
			dkoreksi_master		: null,		
			dkoreksi_produk		: 0,		
			dkoreksi_satuan		: 0,		
			dkoreksi_jmlawal	: 0,		
			dkoreksi_jmlkoreksi	: 0,		
			dkoreksi_jmlsaldo	: 0,		
			dkoreksi_ket		: null		
		});
		editor_detail_koreksi_stok.stopEditing();
		detail_koreksi_stok_DataStore.insert(0, edit_detail_koreksi_stok);
		detail_koreksi_stokListEditorGrid.getView().refresh();
		detail_koreksi_stokListEditorGrid.getSelectionModel().selectRow(0);
		editor_detail_koreksi_stok.startEditing(0);
	}
	
	//function for refresh detail
	function refresh_detail_koreksi_stok(){
		detail_koreksi_stok_DataStore.commitChanges();
		detail_koreksi_stokListEditorGrid.getView().refresh();
	}
	//eof
	
	//function for insert detail
	function detail_koreksi_stok_insert(pkid, opsi){
		
		var dkoreksi_id = [];
        var dkoreksi_produk = [];
        var dkoreksi_satuan = [];
        var dkoreksi_jmlawal = [];
		var dkoreksi_jmlkoreksi = [];
		var dkoreksi_jmlsaldo = [];
        var dkoreksi_ket=[];
		
        if(detail_koreksi_stok_DataStore.getCount()>0){
            for(i=0; i<detail_koreksi_stok_DataStore.getCount();i++){
                if((/^\d+$/.test(detail_koreksi_stok_DataStore.getAt(i).data.dkoreksi_produk))
				   && detail_koreksi_stok_DataStore.getAt(i).data.dkoreksi_produk!==undefined
				   && detail_koreksi_stok_DataStore.getAt(i).data.dkoreksi_produk!==''
				   && detail_koreksi_stok_DataStore.getAt(i).data.dkoreksi_produk!==0
				   && detail_koreksi_stok_DataStore.getAt(i).data.dkoreksi_satuan!==0
				   && detail_koreksi_stok_DataStore.getAt(i).data.dkoreksi_jmlkoreksi!==0){
                    
					if(detail_koreksi_stok_DataStore.getAt(i).data.dkoreksi_id==undefined ||
					   detail_koreksi_stok_DataStore.getAt(i).data.dkoreksi_id==''){
						detail_koreksi_stok_DataStore.getAt(i).data.dkoreksi_id=0;
					}
					
                  	dkoreksi_id.push(detail_koreksi_stok_DataStore.getAt(i).data.dkoreksi_id);
					dkoreksi_produk.push(detail_koreksi_stok_DataStore.getAt(i).data.dkoreksi_produk);
                   	dkoreksi_satuan.push(detail_koreksi_stok_DataStore.getAt(i).data.dkoreksi_satuan);
					dkoreksi_jmlawal.push(detail_koreksi_stok_DataStore.getAt(i).data.dkoreksi_jmlawal);
					dkoreksi_jmlkoreksi.push(detail_koreksi_stok_DataStore.getAt(i).data.dkoreksi_jmlkoreksi);
					dkoreksi_jmlsaldo.push(detail_koreksi_stok_DataStore.getAt(i).data.dkoreksi_jmlsaldo);
					dkoreksi_ket.push(detail_koreksi_stok_DataStore.getAt(i).data.dkoreksi_ket);
                }
            }
			
			var encoded_array_dkoreksi_id = Ext.encode(dkoreksi_id);
			var encoded_array_dkoreksi_produk = Ext.encode(dkoreksi_produk);
			var encoded_array_dkoreksi_satuan = Ext.encode(dkoreksi_satuan);
			var encoded_array_dkoreksi_jmlawal = Ext.encode(dkoreksi_jmlawal);
			var encoded_array_dkoreksi_jmlkoreksi = Ext.encode(dkoreksi_jmlkoreksi);
			var encoded_array_dkoreksi_jmlsaldo = Ext.encode(dkoreksi_jmlsaldo);
			var encoded_array_dkoreksi_ket = Ext.encode(dkoreksi_ket);
			
			Ext.Ajax.request({
				waitMsg: 'Mohon tunggu...',
				url: 'index.php?c=c_master_koreksi_stok&m=detail_detail_koreksi_stok_insert',
				params:{
					dkoreksi_id			: encoded_array_dkoreksi_id,
					dkoreksi_master		: pkid, 
					dkoreksi_produk		: encoded_array_dkoreksi_produk,
					dkoreksi_satuan		: encoded_array_dkoreksi_satuan,
					dkoreksi_jmlawal	: encoded_array_dkoreksi_jmlawal,
					dkoreksi_jmlkoreksi	: encoded_array_dkoreksi_jmlkoreksi,
					dkoreksi_jmlsaldo	: encoded_array_dkoreksi_jmlsaldo,
					dkoreksi_ket		: encoded_array_dkoreksi_ket
				},
				success:function(response){
					var result=eval(response.responseText);
					if(opsi=='print'){
						master_koreksi_stok_cetak_faktur(pkid);
					}
					master_koreksi_stok_DataStore.reload();
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
	function detail_koreksi_stok_purge(pkid){
		Ext.Ajax.request({
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_master_koreksi_stok&m=detail_detail_koreksi_stok_purge',
			params:{ master_id:  pkid },
			success:function(response){
				detail_koreksi_stok_insert(pkid);
			}
		});
		master_koreksi_stok_DataStore.reload();	
	}
	//eof
	
	/* Function for Delete Confirm of detail */
	function detail_koreksi_stok_confirm_delete(){
		// only one record is selected here
		if(detail_koreksi_stokListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', detail_koreksi_stok_delete);
		} else if(detail_koreksi_stokListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', detail_koreksi_stok_delete);
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
	function detail_koreksi_stok_delete(btn){
		if(btn=='yes'){
			var s = detail_koreksi_stokListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, r; r = s[i]; i++){
				detail_koreksi_stok_DataStore.remove(r);
				detail_koreksi_stok_DataStore.commitChanges();
			}
		}  
	}
	//eof
	
	koreksi_button_saveprintField=new Ext.Button({
		text: 'Save and Print',
		ref: '../kstok_savePrint',
		handler: pengecekan_dokumen
	});

	koreksi_button_saveField=new Ext.Button({
		text: 'Save',
		handler: pengecekan_dokumen2
	});
	
	/* Function for retrieve create Window Panel*/ 
	master_koreksi_stok_createForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		monitorValid: true,
		width: 800,        
		items: [master_koreksi_stok_masterGroup,detail_koreksi_stokListEditorGrid],
		buttons: [
			{
				text: 'Print Only',
				ref:'../psPrintOnlyButton',
				handler: ps_print_only
			},
			{
				xtype:'spacer',
				width: 450
			},
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_KOREKSI'))){ ?>
			koreksi_button_saveprintField
			,
			koreksi_button_saveField
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					master_koreksi_stok_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	master_koreksi_stok_createWindow= new Ext.Window({
		id: 'master_koreksi_stok_createWindow',
		title: koreksi_post2db+' Penyesuaian Stok',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_master_koreksi_stok_create',
		items: master_koreksi_stok_createForm
	});
	/* End Window */
	
	/* Function for action list search */
	function master_koreksi_stok_list_search(){
		// render according to a SQL date format.
		var koreksi_id_search=null;
		var koreksi_no_search=null;
		var koreksi_gudang_search=null;
		var koreksi_tgl_awal_search_date="";
		var koreksi_tgl_akhir_search_date="";
		var koreksi_keterangan_search=null;
		var koreksi_status_search=null;

		if(koreksi_noSearchField.getValue()!==null){koreksi_no_search=koreksi_noSearchField.getValue();}
		if(koreksi_gudangSearchField.getValue()!==null){koreksi_gudang_search=koreksi_gudangSearchField.getValue();}
		if(koreksi_tgl_awalSearchField.getValue()!==""){koreksi_tgl_awal_search_date=koreksi_tgl_awalSearchField.getValue().format('Y-m-d');}
		if(koreksi_tgl_akhirSearchField.getValue()!==""){koreksi_tgl_akhir_search_date=koreksi_tgl_akhirSearchField.getValue().format('Y-m-d');}
		if(koreksi_keteranganSearchField.getValue()!==null){koreksi_keterangan_search=koreksi_keteranganSearchField.getValue();}
		if(koreksi_statusSearchField.getValue()!==null){koreksi_status_search=koreksi_statusSearchField.getValue();}
		// change the store parameters
		master_koreksi_stok_DataStore.baseParams = {
			task				: 'SEARCH',
			koreksi_no			: koreksi_no_search,
			koreksi_gudang		: koreksi_gudang_search, 
			koreksi_tgl_awal	: koreksi_tgl_awal_search_date, 
			koreksi_tgl_akhir	: koreksi_tgl_akhir_search_date, 
			koreksi_keterangan	: koreksi_keterangan_search,
			koreksi_status		: koreksi_status_search
		};
		// Cause the datastore to do another query : 
		master_koreksi_stok_DataStore.reload({params: {start: 0, limit: pageS}});
	}
		
	/* Function for reset search result */
	function master_koreksi_stok_reset_search(){
		// reset the store parameters
		master_koreksi_stok_DataStore.baseParams = { task: 'LIST', start: 0, limit: pageS };
		master_koreksi_stok_DataStore.reload({params: {start: 0, limit: pageS}});
		//master_koreksi_stok_searchWindow.close();
	};
	/* End of Fuction */
	
	function master_koreksi_stok_reset_SearchForm(){
		koreksi_noSearchField.reset();
		koreksi_gudangSearchField.reset();
		koreksi_tgl_awalSearchField.reset();
		koreksi_tgl_akhirSearchField.reset();
		koreksi_keteranganSearchField.reset();
		koreksi_statusSearchField.reset();
	}
	
	/* Field for search */
	/* Identify  koreksi_id Search Field */
	koreksi_idSearchField= new Ext.form.NumberField({
		id: 'koreksi_idSearchField',
		fieldLabel: 'Koreksi Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	/* Identify  koreksi_no Search Field */
	koreksi_noSearchField= new Ext.form.TextField({
		id: 'koreksi_noSearchField',
		fieldLabel: 'No PS',
		maxLength: 50,
		anchor: '95%'
	});
	
	/* Identify  koreksi_gudang Search Field */
	koreksi_gudangSearchField= new Ext.form.ComboBox({
		id: 'koreksi_gudangSearchField',
		fieldLabel: 'Gudang',
		store: cbo_koreksi_gudangDataSore,
		displayField:'gudang_nama',
		valueField: 'gudang_id',
		mode : 'remote',
        typeAhead: false,
        hideTrigger:false,
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});
	
	/* Identify  koreksi_tanggal Search Field */
	koreksi_tgl_awalSearchField= new Ext.form.DateField({
		id: 'koreksi_tgl_awalSearchField',
		fieldLabel: 'Tanggal',
		format : 'Y-m-d'
	});
	
	koreksi_tgl_akhirSearchField= new Ext.form.DateField({
		id: 'koreksi_tgl_akhirSearchField',
		fieldLabel: 's/d',
		format : 'Y-m-d',
		labelSeparator: ' '
	});
	
	/* Identify  koreksi_keterangan Search Field */
	koreksi_keteranganSearchField= new Ext.form.TextArea({
		id: 'koreksi_keteranganSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 500,
		anchor: '95%'
	});
	
	koreksi_statusSearchField= new Ext.form.ComboBox({
		id: 'koreksi_statusSearchField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['value', 'koreksi_status'],
			data:[['Terbuka','Terbuka'],['Tertutup','Tertutup'],['Batal','Batal']]
		}),
		mode: 'local',
		displayField: 'koreksi_status',
		valueField: 'value',
		anchor: '70%',
		triggerAction: 'all'	 
	});
	
	koreksi_statusSearchField= new Ext.form.ComboBox({
		id: 'koreksi_statusSearchField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['value', 'koreksi_status'],
			data:[['Terbuka','Terbuka'],['Tertutup','Tertutup'],['Batal','Batal']]
		}),
		mode: 'local',
		displayField: 'koreksi_status',
		valueField: 'value',
		anchor: '80%',
		triggerAction: 'all'	 
	});	
    
	/* Function for retrieve search Form Panel */
	master_koreksi_stok_searchForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 400,        
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [koreksi_noSearchField, koreksi_gudangSearchField, 
						{
							layout: 'column',
							border: false,
							items:[{
								   		layout: 'form',
										border: false,
										columnWidth: 0.6,
										labelWidth: 100,
										items:[koreksi_tgl_awalSearchField]
								   },
								   {
								   		layout: 'form',
										border: false,
										columnWidth: 0.4,
										labelWidth: 20,
										items:[koreksi_tgl_akhirSearchField]
								   }
							]
						}, koreksi_keteranganSearchField, koreksi_statusSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: master_koreksi_stok_list_search
			},{
				text: 'Close',
				handler: function(){
					master_koreksi_stok_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	master_koreksi_stok_searchWindow = new Ext.Window({
		title: 'Pencarian Penyesuaian Stok',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_master_koreksi_stok_search',
		items: master_koreksi_stok_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!master_koreksi_stok_searchWindow.isVisible()){
			master_koreksi_stok_reset_SearchForm();
			master_koreksi_stok_searchWindow.show();
		} else {
			master_koreksi_stok_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	function master_koreksi_stok_cetak_faktur(pkid){
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_master_koreksi_stok&m=print_faktur',
		params: {
			faktur	: pkid
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/koreksi_faktur.html','master_terima_faktur','height=800,width=600,resizable=1,scrollbars=1, menubar=1');
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
	
	/* Function for print List Grid */
	function master_koreksi_stok_print(){
		var searchquery = "";
		var koreksi_gudang_print=null;
		var koreksi_tgl_awal_print_date="";
		var koreksi_tgl_akhir_print_date="";
		var koreksi_keterangan_print=null;
		var win;              
		// check if we do have some search data...
		if(master_koreksi_stok_DataStore.baseParams.query!==null){searchquery = master_koreksi_stok_DataStore.baseParams.query;}
		if(master_koreksi_stok_DataStore.baseParams.koreksi_gudang!==null){koreksi_gudang_print = master_koreksi_stok_DataStore.baseParams.koreksi_gudang;}
		if(master_koreksi_stok_DataStore.baseParams.koreksi_tgl_awal!==""){koreksi_tgl_awal_print_date = master_koreksi_stok_DataStore.baseParams.koreksi_tgl_awal;}
		if(master_koreksi_stok_DataStore.baseParams.koreksi_tgl_akhir!==""){koreksi_tgl_akhir_print_date = master_koreksi_stok_DataStore.baseParams.koreksi_tgl_akhir;}
		if(master_koreksi_stok_DataStore.baseParams.koreksi_keterangan!==null){koreksi_keterangan_print = master_koreksi_stok_DataStore.baseParams.koreksi_keterangan;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_master_koreksi_stok&m=get_action',
		params: {
			task				: "PRINT",
		  	query				: searchquery,                    		
			koreksi_gudang 		: koreksi_gudang_print,
		  	koreksi_tgl_awal 	: koreksi_tgl_awal_print_date, 
			koreksi_tgl_akhir 	: koreksi_tgl_akhir_print_date, 
			koreksi_keterangan 	: koreksi_keterangan_print,
		  	currentlisting	: master_koreksi_stok_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/print_koreksi_stoklist.html','master_koreksi_stoklist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
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
	function master_koreksi_stok_export_excel(){
		var searchquery = "";
		var koreksi_gudang_2excel=null;
		var koreksi_tgl_awal_2excel_date="";
		var koreksi_tgl_akhir_2excel_date="";
		var koreksi_keterangan_2excel=null;
		var win;              
		// check if we do have some search data...
		if(master_koreksi_stok_DataStore.baseParams.query!==null){searchquery = master_koreksi_stok_DataStore.baseParams.query;}
		if(master_koreksi_stok_DataStore.baseParams.koreksi_gudang!==null){koreksi_gudang_2excel = master_koreksi_stok_DataStore.baseParams.koreksi_gudang;}
		if(master_koreksi_stok_DataStore.baseParams.koreksi_tgl_awal!==""){koreksi_tgl_awal_2excel_date = master_koreksi_stok_DataStore.baseParams.koreksi_tgl_awal;}
		if(master_koreksi_stok_DataStore.baseParams.koreksi_tgl_akhir!==""){koreksi_tgl_awal_2excel_date = master_koreksi_stok_DataStore.baseParams.koreksi_tgl_akhir;}
		if(master_koreksi_stok_DataStore.baseParams.koreksi_keterangan!==null){koreksi_keterangan_2excel = master_koreksi_stok_DataStore.baseParams.koreksi_keterangan;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_master_koreksi_stok&m=get_action',
		params: {
			task				: "EXCEL",
		  	query				: searchquery,                    		
			koreksi_gudang 		: koreksi_gudang_2excel,
		  	koreksi_tgl_awal 	: koreksi_tgl_awal_2excel_date, 
			koreksi_tgl_akhir 	: koreksi_tgl_akhir_2excel_date, 
			koreksi_keterangan 	: koreksi_keterangan_2excel,
		  	currentlisting		: master_koreksi_stok_DataStore.baseParams.task // this tells us if we are searching or not
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
	
	//EVENTS
	//event on update of detail data store
	//detail_koreksi_stok_DataStore.on('update', refresh_detail_koreksi_stok);
	
	koreksi_gudangField.on("select",function(){
		cbo_stok_produkDataStore.setBaseParam('gudang',get_gudang_id());
		cbo_stok_produkDataStore.setBaseParam('task','list');
		check_gudang();
	});
	
	combo_stok_produk.on("focus",function(){
		cbo_stok_produkDataStore.setBaseParam('task','list');
		var selectedquery=detail_koreksi_stokListEditorGrid.getSelectionModel().getSelected().get('produk_nama');
		cbo_stok_produkDataStore.setBaseParam('query',selectedquery);
	});
	
	combo_stok_satuan.on("focus",function(){
		cbo_stok_satuanDataStore.setBaseParam('task','produk');
		cbo_stok_satuanDataStore.setBaseParam('selected_id',combo_stok_produk.getValue());
		cbo_stok_satuanDataStore.load();
	});
	
	combo_stok_produk.on("select",function(){
		var jumlah_awal=0;
		var satuan_id=0;
		
		Ext.MessageBox.show({
		   msg: 'Sedang mengambil data, silakan tunggu...',
		   progressText: 'proses...',
		   width:350,
		   wait:true
		});
		
		cbo_stok_satuanDataStore.setBaseParam('task','produk');
		cbo_stok_satuanDataStore.setBaseParam('selected_id',combo_stok_produk.getValue());
		
		cbo_stok_byprodukDataStore.setBaseParam('produk_id',combo_stok_produk.getValue());
		cbo_stok_byprodukDataStore.setBaseParam('gudang',get_gudang_id());
		cbo_stok_byprodukDataStore.setBaseParam('tanggal',koreksi_tanggalField.getValue().format('Y-m-d'));
		cbo_stok_byprodukDataStore.load({
			callback: function(r,opt,success){
				if(success==true){
					var j=cbo_stok_byprodukDataStore.findExact('produk_id',combo_stok_produk.getValue(),0);
					if(j>=0){
						var record_produk=cbo_stok_byprodukDataStore.getAt(j);
						satuan_id=record_produk.data.produk_satuan_id;
						jumlah_awal=record_produk.data.produk_stok;
					}
					cbo_stok_satuanDataStore.load({
						callback: function(r,opt,success){
							combo_stok_satuan.setValue(satuan_id);
							stok_awalField.setValue(jumlah_awal);
							stok_saldoField.setValue(stok_awalField.getValue()+stok_terkoreksiField.getValue());
						}
					});
					Ext.MessageBox.hide();
				}else{
					Ext.MessageBox.show({
						   title: 'Error',
						   msg: 'Tidak bisa terhubung dengan database server',
						   buttons: Ext.MessageBox.OK,
						   animEl: 'database',
						   icon: Ext.MessageBox.ERROR
					});	
				}
			}
		});
	});
	
	function rounding(num, dec) {
		var result = Math.round(num*Math.pow(10,dec))/Math.pow(10,dec);
		return result;
	}

	combo_stok_satuan.on("select",function(){
		var jumlah_awal=0;
		var konversi=1;
		var j=cbo_stok_byprodukDataStore.findExact('produk_id',combo_stok_produk.getValue(),0);
		if(j>=0){
			var record_produk=cbo_stok_byprodukDataStore.getAt(j);
			jumlah_awal=record_produk.data.produk_stok;
		}
		
		var j=cbo_stok_satuanDataStore.findExact('satuan_id',combo_stok_satuan.getValue(),0);
		if(j>=0){
			var record_satuan=cbo_stok_satuanDataStore.getAt(j);
			konversi=record_satuan.data.konversi_nilai;
			jumlah_konversi=jumlah_awal/konversi;
			jumlah_konversi=rounding(jumlah_konversi,2);
			stok_awalField.setValue(jumlah_konversi);
			stok_saldoField.setValue(stok_awalField.getValue()+stok_terkoreksiField.getValue());
		}
	});
	
	stok_terkoreksiField.on("keyup", function(){
		stok_saldoField.setValue(rounding(stok_awalField.getValue()+stok_terkoreksiField.getValue(),2));
	});
	
	stok_saldoField.on("keyup", function(){
		stok_terkoreksiField.setValue(rounding(stok_saldoField.getValue()-stok_awalField.getValue(),2));
	});
	
	detail_koreksi_stok_DataStore.on("update",function(){
		var	query_selected="";
		var satuan_selected="";
		detail_koreksi_stok_DataStore.commitChanges();
		for(i=0;i<detail_koreksi_stok_DataStore.getCount();i++){
			var detail_koreksi_record=detail_koreksi_stok_DataStore.getAt(i);
			query_selected=query_selected+detail_koreksi_record.data.dkoreksi_produk+",";
		}
		cbo_stok_produkDataStore.setBaseParam('task','selected');
		cbo_stok_produkDataStore.setBaseParam('selected_id',query_selected);
		cbo_stok_produkDataStore.load({
			callback: function(r,opt,success){
				if(success==true){
					for(i=0;i<detail_koreksi_stok_DataStore.getCount();i++){
						var detail_koreksi_record=detail_koreksi_stok_DataStore.getAt(i);
						satuan_selected=satuan_selected+detail_koreksi_record.data.dkoreksi_satuan+",";
					}
					cbo_stok_satuanDataStore.setBaseParam('task','selected');
					cbo_stok_satuanDataStore.setBaseParam('selected_id',satuan_selected);
					cbo_stok_satuanDataStore.load();
				}
			}
		});
		koreksi_tanggalField.setDisabled(true);
	});
		
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_master_koreksi_stok"></div>
         <div id="fp_detail_koreksi_stok"></div>
		<div id="elwindow_master_koreksi_stok_create"></div>
        <div id="elwindow_master_koreksi_stok_search"></div>
    </div>
</div>
</body>