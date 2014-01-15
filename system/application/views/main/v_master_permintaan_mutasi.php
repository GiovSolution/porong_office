<?
/* 	These code was generated using phpCIGen v 0.1.b (1/08/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com,
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id

	+ Module  		: master_permintaan_mutasi View
	+ Description	: For record view
	+ Filename 		: v_master_permintaan_mutasi.php
 	+ Author  		:
 	+ Created on 20/Aug/2009 15:43:12

*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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
var master_minta_mutasi_DataStore;
var master_minta_mutasi_ColumnModel;
var master_minta_mutasiListEditorGrid;
var master_minta_mutasi_createForm;
var master_minta_mutasi_createWindow;
var master_minta_mutasi_searchForm;
var master_minta_mutasi_searchWindow;
var master_minta_mutasi_SelectedRow;
var master_minta_mutasi_ContextMenu;
//for detail data
var detail_minta_mutasi_DataStore;
var detail_minta_mutasiListEditorGrid;
var detail_minta_mutasi_ColumnModel;
var detail_minta_mutasi_proxy;
var detail_minta_mutasi_writer;
var detail_minta_mutasi_reader;
var editor_detail_minta_mutasi;
var today=new Date().format('Y-m-d');
var firstday=(new Date().format('Y-m'))+'-01';
//declare konstant
var orderbeli_post2db = '';
var msg = '';
var pageS=15;
var cetak_order=0;
var stat='ADD';
/* declare variable here for Field*/
var minta_mutasi_idField;
var minta_mutasi_noField;
var minta_mutasi_tanggalField;
var minta_mutasi_keteranganField;
var minta_mutasi_idSearchField;
var minta_mutasi_noSearchField;
var minta_mutasi_tanggalSearchField;
var minta_mutasi_tanggal_akhirSearchField;
var minta_mutasi_keteranganSearchField;
var minta_mutasi_statusSearchField;
var minta_mutasi_status_accSearchField;
var detail_minta_mutasi_DataStore;

var minta_mutasi_button_saveField;
var minta_mutasi_button_saveprintField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */

  /*Function for pengecekan _dokumen */
	function pengecekan_dokumen(){
		var minta_mutasi_tanggal_create_date = "";
		if(minta_mutasi_tanggalField.getValue()!== ""){minta_mutasi_tanggal_create_date = minta_mutasi_tanggalField.getValue().format('Y-m-d');}
		Ext.Ajax.request({
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_master_permintaan_mutasi&m=get_action',
			params: {
				task: "CEK",
				tanggal_pengecekan	: minta_mutasi_tanggal_create_date

			},
			success: function(response){
				var result=eval(response.responseText);
				switch(result){
						case 1:
							cetak_order=1;
							master_minta_mutasi_create('print');
						break;
						default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Data Permintaan Mutasi Barang tidak bisa disimpan, karena telah melebihi batas hari yang diperbolehkan ',
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
		var minta_mutasi_tanggal_create_date = "";
		if(minta_mutasi_tanggalField.getValue()!== ""){minta_mutasi_tanggal_create_date = minta_mutasi_tanggalField.getValue().format('Y-m-d');}
		Ext.Ajax.request({
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_master_permintaan_mutasi&m=get_action',
			params: {
				task: "CEK",
				tanggal_pengecekan	: minta_mutasi_tanggal_create_date

			},
			success: function(response){
				var result=eval(response.responseText);
				switch(result){
						case 1:
							cetak_order=0;
							master_minta_mutasi_create();
						break;
						default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Data Permintaan Mutasi Barang tidak bisa disimpan, karena telah melebihi batas hari yang diperbolehkan ',
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
	function master_minta_mutasi_create(opsi){
		if(detail_minta_mutasi_DataStore.getCount()<1){
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Data detail harus ada minimal 1 (satu)',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		} else if(is_master_minta_mutasi_form_valid()){

		var minta_mutasi_id_create_pk=null;
		var minta_mutasi_no_create=null;
		var minta_mutasi_tanggal_create_date="";
		var minta_mutasi_keterangan_create=null;
		var minta_mutasi_status_create=null;
		var minta_mutasi_asal_create=null; 
		var minta_mutasi_tujuan_create=null; 

		if(minta_mutasi_idField.getValue()!== null){minta_mutasi_id_create_pk = minta_mutasi_idField.getValue();}else{minta_mutasi_id_create_pk=get_pk_id();}
		if(minta_mutasi_noField.getValue()!== null){minta_mutasi_no_create = minta_mutasi_noField.getValue();}
		if(minta_mutasi_asalField.getValue()!== null){minta_mutasi_asal_create = minta_mutasi_asalField.getValue();} 
		if(minta_mutasi_tujuanField.getValue()!== null){minta_mutasi_tujuan_create = minta_mutasi_tujuanField.getValue();} 
		if(minta_mutasi_tanggalField.getValue()!== ""){minta_mutasi_tanggal_create_date = minta_mutasi_tanggalField.getValue().format('Y-m-d');}
		if(minta_mutasi_keteranganField.getValue()!== null){minta_mutasi_keterangan_create = minta_mutasi_keteranganField.getValue();}
		if(minta_mutasi_statusField.getValue()!== null){minta_mutasi_status_create = minta_mutasi_statusField.getValue();}
		if(minta_mutasi_status_accField.getValue()!== null){minta_mutasi_status_acc_create = minta_mutasi_status_accField.getValue();}

		var domutasi_id = [];
	    var domutasi_produk = [];
	    var domutasi_satuan = [];
	    var domutasi_jumlah = [];

	    var dcount = detail_minta_mutasi_DataStore.getCount() - 1;
		var jum_terima=0;
		
        if(detail_minta_mutasi_DataStore.getCount()>0){
            for(i=0; i<detail_minta_mutasi_DataStore.getCount();i++){
                if((/^\d+$/.test(detail_minta_mutasi_DataStore.getAt(i).data.domutasi_produk))
				   && detail_minta_mutasi_DataStore.getAt(i).data.domutasi_produk!==undefined
				   && detail_minta_mutasi_DataStore.getAt(i).data.domutasi_produk!==''
				   && detail_minta_mutasi_DataStore.getAt(i).data.domutasi_produk!==0
				   && detail_minta_mutasi_DataStore.getAt(i).data.domutasi_satuan!==''
				   && detail_minta_mutasi_DataStore.getAt(i).data.domutasi_jumlah>0){

                  	domutasi_id.push(detail_minta_mutasi_DataStore.getAt(i).data.domutasi_id);
					domutasi_produk.push(detail_minta_mutasi_DataStore.getAt(i).data.domutasi_produk);
                   	domutasi_satuan.push(detail_minta_mutasi_DataStore.getAt(i).data.domutasi_satuan);
					domutasi_jumlah.push(detail_minta_mutasi_DataStore.getAt(i).data.domutasi_jumlah);
                }
				jum_terima=jum_terima+detail_minta_mutasi_record.data.dminta_mutasi_terima;
            }

			var encoded_array_dminta_mutasi_id = Ext.encode(domutasi_id);
			var encoded_array_dminta_mutasi_produk = Ext.encode(domutasi_produk);
			var encoded_array_dminta_mutasi_satuan = Ext.encode(domutasi_satuan);
			var encoded_array_dminta_mutasi_jumlah = Ext.encode(domutasi_jumlah);
			
	    }
	    
		Ext.MessageBox.show({
			msg:   'Sedang memproses data, mohon tunggu hingga proses ini selesai agar keamanan data anda terjaga...',
			progressText: 'proses...',
			width:350,
			wait:true
		});
		
		Ext.Ajax.request({
			waitMsg: 'Mohon tunggu...',
			url: 'index.php?c=c_master_permintaan_mutasi&m=get_action',
			params: {
				task				: orderbeli_post2db,
				omutasi_id			: minta_mutasi_id_create_pk,
				omutasi_no			: minta_mutasi_no_create,
				omutasi_tanggal		: minta_mutasi_tanggal_create_date,
				omutasi_asal		: minta_mutasi_asal_create, 
				omutasi_tujuan		: minta_mutasi_tujuan_create, 
				omutasi_keterangan	: minta_mutasi_keterangan_create,
				omutasi_status		: minta_mutasi_status_create,
				cetak_order			: cetak_order,
				domutasi_id			: encoded_array_dminta_mutasi_id,
				domutasi_produk		: encoded_array_dminta_mutasi_produk,
				domutasi_satuan		: encoded_array_dminta_mutasi_satuan,
				domutasi_jumlah		: encoded_array_dminta_mutasi_jumlah
			},
			success: function(response){
				var result=eval(response.responseText);
				if(jum_terima > 0 && minta_mutasi_statusField.getValue()=='Batal'){
					Ext.MessageBox.show({
						title: 'Warning',
						msg: 'OP yang pernah diambil di PB tidak dapat dibatalkan!',
						buttons: Ext.MessageBox.OK,
						animEl: 'save',
						icon: Ext.MessageBox.WARNING
					});
					minta_mutasi_statusField.setValue(master_minta_mutasiListEditorGrid.getSelectionModel().getSelected().get('omutasi_status'));
					
				} else if(result!==0){
						Ext.MessageBox.alert(orderbeli_post2db+' OK','Data Permintaan Mutasi Barang berhasil disimpan');
						if(opsi=='print'){
							master_minta_mutasi_cetak_faktur(result);
						}
						master_minta_mutasi_DataStore.reload()
						master_minta_mutasi_createWindow.hide();
				} else {
						Ext.MessageBox.show({
						   title: 'Warning',
						   //msg: 'We could\'t not '+msg+' the Master_minta_mutasi.',
						   msg: 'Data Permintaan Mutasi Barang tidak bisa disimpan',
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
		if(orderbeli_post2db=='UPDATE')
			return master_minta_mutasiListEditorGrid.getSelectionModel().getSelected().get('omutasi_id');
		else if(orderbeli_post2db=='CREATE')
			return minta_mutasi_idField.getValue();
		else
			return -1;
	}
	/* End of Function  */
	
	function get_asal_mutasi_id(){
		if(isNaN(parseInt(minta_mutasi_asalField.getValue())) || parseInt(minta_mutasi_asalField.getValue())==0)
		{
			return master_minta_mutasiListEditorGrid.getSelectionModel().getSelected().get('omutasi_asal_id');
		}else{
			return minta_mutasi_asalField.getValue();
		}
	}
	
	function get_tujuan_mutasi_id(){
		if(isNaN(parseInt(minta_mutasi_tujuanField.getValue())) || parseInt(minta_mutasi_tujuanField.getValue())==0)
		{
			return master_minta_mutasiListEditorGrid.getSelectionModel().getSelected().get('omutasi_tujuan_id');
		}else{
			return minta_mutasi_tujuanField.getValue();
		}
	}

	/* Reset form before loading */
	function master_minta_mutasi_reset_form(){
		minta_mutasi_idField.reset();
		minta_mutasi_idField.setValue(null);
		minta_mutasi_noField.reset();
		minta_mutasi_noField.setValue('(Auto)');
		minta_mutasi_asalField.reset();
		minta_mutasi_tujuanField.reset();
		minta_mutasi_tanggalField.setValue(today);
		minta_mutasi_keteranganField.reset();
		minta_mutasi_keteranganField.setValue(null);
		minta_mutasi_statusField.reset();
		minta_mutasi_statusField.setValue('Terbuka');
		minta_mutasi_status_accField.reset();
		minta_mutasi_status_accField.setValue('Terbuka');
		minta_mutasi_idField.setDisabled(false);
		minta_mutasi_noField.setDisabled(false);
		minta_mutasi_asalField.setDisabled(false);
		minta_mutasi_tujuanField.setDisabled(false);
		minta_mutasi_tanggalField.setDisabled(false);
		minta_mutasi_keteranganField.setDisabled(false);
		minta_mutasi_statusField.setDisabled(false);
		combo_minta_mutasi_produk.setDisabled(false);
		combo_minta_mutasi_satuan.setDisabled(false);
		minta_mutasi_jumlah_barangField.setDisabled(false);
		cbo_minta_mutasi_produk_DataStore.load();
		detail_minta_mutasi_DataStore.load({params: {master_id:-1}});
		master_minta_mutasi_createForm.obeli_savePrint.enable();
		master_minta_mutasi_createForm.smbPrintOnlyButton.disable();
		
	}
 	/* End of Function */

	/* setValue to EDIT */
	function master_minta_mutasi_set_form(){
		minta_mutasi_idField.setValue(master_minta_mutasiListEditorGrid.getSelectionModel().getSelected().get('omutasi_id'));
		minta_mutasi_noField.setValue(master_minta_mutasiListEditorGrid.getSelectionModel().getSelected().get('omutasi_no'));
		minta_mutasi_asalField.setValue(master_minta_mutasiListEditorGrid.getSelectionModel().getSelected().get('omutasi_asal'));
		minta_mutasi_tujuanField.setValue(master_minta_mutasiListEditorGrid.getSelectionModel().getSelected().get('omutasi_tujuan'));
		minta_mutasi_tanggalField.setValue(master_minta_mutasiListEditorGrid.getSelectionModel().getSelected().get('omutasi_tanggal'));
		minta_mutasi_statusField.setValue(master_minta_mutasiListEditorGrid.getSelectionModel().getSelected().get('omutasi_status'));

		//LOAD DETAIL
		cbo_minta_mutasi_satuanDataStore.setBaseParam('task','detail');
		cbo_minta_mutasi_satuanDataStore.setBaseParam('master_id',get_pk_id());
		cbo_minta_mutasi_satuanDataStore.load();

		minta_mutasi_button_saveField.setDisabled(true);
		//minta_mutasi_button_saveprintField.setDisabled(true);

		cbo_minta_mutasi_produk_DataStore.setBaseParam('master_id',get_pk_id());
		cbo_minta_mutasi_produk_DataStore.setBaseParam('task','detail');
		cbo_minta_mutasi_produk_DataStore.load({
			callback: function(r,opt,success){
				if(success==true){
					detail_minta_mutasi_DataStore.setBaseParam('master_id',get_pk_id());
					detail_minta_mutasi_DataStore.load({
						callback: function(r,opt,success){
							if(success==true){
								Ext.MessageBox.hide();
								minta_mutasi_button_saveField.setDisabled(false);
								//minta_mutasi_button_saveprintField.setDisabled(false);
							}
						}
					});
				}
			}
		});

		//END OF LOAD
		if(orderbeli_post2db=="UPDATE" && master_minta_mutasiListEditorGrid.getSelectionModel().getSelected().get('omutasi_status')=="Terbuka"){
			minta_mutasi_idField.setDisabled(false);
			minta_mutasi_noField.setDisabled(false);
			minta_mutasi_tanggalField.setDisabled(false);
			minta_mutasi_keteranganField.setDisabled(false);
			minta_mutasi_statusField.setDisabled(false);
			minta_mutasi_status_accField.setDisabled(false);
			combo_minta_mutasi_produk.setDisabled(false);
			combo_minta_mutasi_satuan.setDisabled(false);
			minta_mutasi_jumlah_barangField.setDisabled(false);
			master_minta_mutasi_createForm.obeli_savePrint.enable();
			minta_mutasi_button_saveprintField.setDisabled(false);
			master_minta_mutasi_createForm.smbPrintOnlyButton.disable();
		}
		if(orderbeli_post2db=="UPDATE" && master_minta_mutasiListEditorGrid.getSelectionModel().getSelected().get('omutasi_status')=="Tertutup"){
			minta_mutasi_idField.setDisabled(true);
			minta_mutasi_noField.setDisabled(true);
			minta_mutasi_tanggalField.setDisabled(true);
			minta_mutasi_keteranganField.setDisabled(true);
			minta_mutasi_status_accField.setDisabled(true);
			minta_mutasi_statusField.setDisabled(false);
			combo_minta_mutasi_produk.setDisabled(true);
			combo_minta_mutasi_satuan.setDisabled(true);
			minta_mutasi_jumlah_barangField.setDisabled(true);
			master_minta_mutasi_createForm.smbPrintOnlyButton.enable();
			minta_mutasi_button_saveprintField.setDisabled(true);
			if(cetak_order==1){
					//jproduk_cetak(jproduk_id_for_cetak);
				cetak_order=0;
			}

		}
		if(orderbeli_post2db=="UPDATE" && master_minta_mutasiListEditorGrid.getSelectionModel().getSelected().get('omutasi_status')=="Batal"){
			minta_mutasi_idField.setDisabled(true);
			minta_mutasi_noField.setDisabled(true);
			minta_mutasi_tanggalField.setDisabled(true);
			minta_mutasi_keteranganField.setDisabled(true);
			minta_mutasi_status_accField.setDisabled(true);
			minta_mutasi_statusField.setDisabled(true);
			combo_minta_mutasi_produk.setDisabled(true);
			combo_minta_mutasi_satuan.setDisabled(true);
			minta_mutasi_jumlah_barangField.setDisabled(true);
			master_minta_mutasi_createForm.smbPrintOnlyButton.enable();
			minta_mutasi_button_saveprintField.setDisabled(true);
			master_minta_mutasi_createForm.obeli_savePrint.disable();
		}


		minta_mutasi_statusField.on("select",function(){
		var status_awal = master_minta_mutasiListEditorGrid.getSelectionModel().getSelected().get('omutasi_status');
		if(status_awal =='Terbuka' && minta_mutasi_statusField.getValue()=='Tertutup')
		{
		Ext.MessageBox.show({
			msg: 'Dokumen tidak bisa ditutup. Gunakan Save & Print untuk menutup dokumen',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		minta_mutasi_statusField.setValue('Terbuka');
		}

		else if(status_awal =='Tertutup' && minta_mutasi_statusField.getValue()=='Terbuka')
		{
		Ext.MessageBox.show({
			msg: 'Status yang sudah Tertutup tidak dapat diganti Terbuka',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		minta_mutasi_statusField.setValue('Tertutup');
		}

		else if(status_awal =='Batal' && minta_mutasi_statusField.getValue()=='Terbuka')
		{
		Ext.MessageBox.show({
			msg: 'Status yang sudah Tertutup tidak dapat diganti Terbuka',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		minta_mutasi_statusField.setValue('Tertutup');
		}

		else if(minta_mutasi_statusField.getValue()=='Batal')
		{
		Ext.MessageBox.confirm('Confirmation','Anda yakin untuk membatalkan dokumen ini? Pembatalan dokumen tidak bisa dikembalikan lagi', minta_mutasi_status_batal);
		}

       else if(status_awal =='Tertutup' && minta_mutasi_statusField.getValue()=='Tertutup'){
            <?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_MINTAMUTASI'))){ ?>
			master_minta_mutasi_createForm.obeli_savePrint.enable();
			<?php } ?>
        }

		});



	}
	/* End setValue to EDIT*/

	function minta_mutasi_status_batal(btn){
		if(btn=='yes')
		{
			minta_mutasi_statusField.setValue('Batal');
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_MINTAMUTASI'))){ ?>
			master_minta_mutasi_createForm.obeli_savePrint.disable();
			<?php } ?>
		}
		else
			minta_mutasi_statusField.setValue(master_minta_mutasiListEditorGrid.getSelectionModel().getSelected().get('omutasi_status'));
	}


	/* Function for Check if the form is valid */
	function is_master_minta_mutasi_form_valid(){
		return (minta_mutasi_asalField.isValid() && minta_mutasi_tujuanField.isValid() && (minta_mutasi_asalField.getValue()!==minta_mutasi_tujuanField.getValue()));
	}
  	/* End of Function */

  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!master_minta_mutasi_createWindow.isVisible()){
			orderbeli_post2db='CREATE';
			msg='created';
			master_minta_mutasi_reset_form();
			master_minta_mutasi_createWindow.show();
		} else {
			master_minta_mutasi_createWindow.toFront();
		}
	}
  	/* End of Function */

  	/* Function for Delete Confirm */
	function master_minta_mutasi_confirm_delete(){
		// only one master_minta_mutasi is selected here
		if(master_minta_mutasiListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', master_minta_mutasi_delete);
		} else if(master_minta_mutasiListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', master_minta_mutasi_delete);
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				//msg: 'Tidak ada yang dipilih untuk dihapus',
				msg: 'Anda belum memilih data yang akan dihapus',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */

	function op_print_only(){
		if(minta_mutasi_idField.getValue()==''){
			Ext.MessageBox.show({
			msg: 'Faktur OP tidak dapat dicetak, karena data kosong',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		}
		else{
				
			var omutasi_id = minta_mutasi_idField.getValue();
			cetak_order=1;
			//master_minta_mutasi_create('print');
			master_minta_mutasi_cetak_faktur(omutasi_id);
			master_minta_mutasi_DataStore.reload()
			
			Ext.MessageBox.show({
				title: 'INFO',
				msg: 'Data berhasil di cetak kembali',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.INFO
			});
			
			master_minta_mutasi_createWindow.hide();
		}

		//jproduk_btn_cancel();
	}



	/* Function for Update Confirm */
	function master_minta_mutasi_confirm_update(){
		/* only one record is selected here */
		if(master_minta_mutasiListEditorGrid.selModel.getCount() == 1) {
			orderbeli_post2db='UPDATE';
			msg='updated';
			master_minta_mutasi_set_form();
			master_minta_mutasi_createWindow.show();

			Ext.MessageBox.show({
			   msg: 'Sedang memuat data, mohon tunggu...',
			   progressText: 'proses...',
			   width:350,
			   wait:true
			});

		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				//msg: 'Tidak ada data yang dipilih untuk diedit',
				msg: 'Anda belum memilih data yang akan diubah',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */

  	/* Function for Delete Record */
	function master_minta_mutasi_delete(btn){
		if(btn=='yes'){
			var selections = master_minta_mutasiListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< master_minta_mutasiListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.omutasi_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({
				waitMsg: 'Mohon tunggu',
				url: 'index.php?c=c_master_permintaan_mutasi&m=get_action',
				params: { task: "DELETE", ids:  encoded_array },
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							master_minta_mutasi_DataStore.reload();
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
	
	/* Function for Retrieve Gudang Awal DataStore, gudang ini hanya menampilkan list gudang pada user yang bersangkutan */
	cbo_minta_mutasi_gudang_DataSore = new Ext.data.Store({
		id: 'cbo_minta_mutasi_gudang_DataSore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_permintaan_mutasi&m=get_gudang_list', 
			method: 'POST'
		}),
		baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'gudang_id'
		},[
			{name: 'minta_mutasi_gudang_value', type: 'int', mapping: 'gudang_id'},
			{name: 'minta_mutasi_gudang_nama', type: 'string', mapping: 'gudang_nama'}
		]),
		sortInfo:{field: 'minta_mutasi_gudang_nama', direction: "ASC"}
	});
	
	/* Function for Store utk Gudang Tujuan, dimana ini menampilkan semua Gudang */
	cbo_minta_mutasi_gudang_all_DataStore = new Ext.data.Store({
		id: 'cbo_minta_mutasi_gudang_all_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_permintaan_mutasi&m=get_gudang_all_list', 
			method: 'POST'
		}),
		baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'gudang_id'
		},[
			{name: 'minta_mutasi_gudang_value', type: 'int', mapping: 'gudang_id'},
			{name: 'minta_mutasi_gudang_nama', type: 'string', mapping: 'gudang_nama'}
		]),
		sortInfo:{field: 'minta_mutasi_gudang_nama', direction: "ASC"}
	});

	/* Function for Retrieve DataStore */
	master_minta_mutasi_DataStore = new Ext.data.Store({
		id: 'master_minta_mutasi_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_permintaan_mutasi&m=get_action',
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit: pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'omutasi_id'
		},[
			{name: 'omutasi_id', type: 'int', mapping: 'omutasi_id'},
			{name: 'omutasi_no', type: 'string', mapping: 'omutasi_no'},
			{name: 'omutasi_asal', type: 'string', mapping: 'gudang_asal_nama'}, 
			{name: 'omutasi_asal_id', type: 'int', mapping: 'omutasi_asal'}, 
			{name: 'omutasi_tujuan', type: 'string', mapping: 'gudang_tujuan_nama'},
			{name: 'omutasi_tujuan_id', type: 'string', mapping: 'omutasi_tujuan'},
			{name: 'omutasi_tanggal', type: 'date', dateFormat: 'Y-m-d', mapping: 'omutasi_tanggal'},
			{name: 'omutasi_keterangan', type: 'string', mapping: 'omutasi_keterangan'},
			{name: 'omutasi_jumlah', type: 'float', mapping: 'jml_order_mutasi'}, 
			{name: 'omutasi_status', type: 'string', mapping: 'omutasi_status'},
			{name: 'omutasi_creator', type: 'string', mapping: 'omutasi_creator'},
			{name: 'omutasi_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'omutasi_date_create'},
			{name: 'omutasi_update', type: 'string', mapping: 'omutasi_update'},
			{name: 'omutasi_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'omutasi_date_update'},
			{name: 'omutasi_revised', type: 'int', mapping: 'omutasi_revised'}
		]),
		sortInfo:{field: 'omutasi_id', direction: "DESC"}
	});
	/* End of Function */

	/* Function for Retrieve permission DataStore */
	permission_op_DataStore = new Ext.data.Store({
		id: 'permission_op_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_permintaan_mutasi&m=get_permission_op',
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'menu_id'
		},[
			{name: 'menu_id', type: 'int', mapping: 'menu_id'},
			{name: 'perm_group', type: 'int', mapping: 'perm_group'},
		])
	});

	
	/* Function for Retrieve Supplier DataStore */
	var cbo_minta_mutasi_produk_DataStore = new Ext.data.Store({
		id: 'cbo_minta_mutasi_produk_DataStore',
		proxy: new Ext.data.HttpProxy({
			timeout: 480000,
			url: 'index.php?c=c_master_permintaan_mutasi&m=get_produk_list',
			method: 'POST'
		}),
		baseParams:{task: "detail",start:0,limit:pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'minta_mutasi_produk_value'
		},[
			{name: 'minta_mutasi_produk_value', type: 'int', mapping: 'produk_id'},
			{name: 'minta_mutasi_produk_nama', type: 'string', mapping: 'produk_nama'},
			{name: 'minta_mutasi_produk_kode', type: 'string', mapping: 'produk_kode'},
			{name: 'minta_mutasi_produk_kategori', type: 'string', mapping: 'kategori_nama'},
			{name: 'minta_mutasi_produk_satuan', type: 'string', mapping: 'satuan_id'}
		]),
		sortInfo:{field: 'minta_mutasi_produk_nama', direction: "ASC"}
	});

	var minta_mutasi_produk_detail_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{minta_mutasi_produk_nama} ({minta_mutasi_produk_kode})</b><br /></span>',
            'Kategori: {minta_mutasi_produk_kategori}',
        '</div></tpl>'
    );

  	/* Function for Identify of Window Column Model */
	master_minta_mutasi_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: '<div align="center">' + 'Tanggal' + '</div>',
			dataIndex: 'omutasi_tanggal',
			width: 70,	//150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			readOnly: true
		},
		{
			//header: '<div align="center">' + 'No Order' + '</div>',
			header: '<div align="center">' + 'No SMB' + '</div>',
			dataIndex: 'omutasi_no',
			width: 80,	//150,
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">Gudang Asal</div>',
			dataIndex: 'omutasi_asal',
			width: 100,
			sortable: true,
			readOnly: true
		}, 
		{
			header: '<div align="center">Gudang Tujuan</div>',
			dataIndex: 'omutasi_tujuan',
			width: 100,
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">' + 'Jml Barang' + '</div>',
			align: 'right',
			dataIndex: 'omutasi_jumlah',
			width: 60,	//150,
			sortable: true,
			readOnly: true,
			renderer: Ext.util.Format.numberRenderer('0,000')
		},
		{
			header: '<div align="center">' + 'Keterangan' + '</div>',
			dataIndex: 'omutasi_keterangan',
			width: 150,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
		},
		{
			header: '<div align="center">' + 'Stat Dok' + '</div>',
			dataIndex: 'omutasi_status',
			width: 60
		},

		{
			header: '<div align="center">' + 'Stat Acc' + '</div>',
			dataIndex: 'minta_mutasi_status_acc',
			hidden : true,
			width: 60
		},
		{
			header: 'Creator',
			dataIndex: 'omutasi_creator',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		},
		{
			header: 'Create on',
			dataIndex: 'omutasi_date_create',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		},
		{
			header: 'Last Update by',
			dataIndex: 'omutasi_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		},
		{
			header: 'Last Update on',
			dataIndex: 'omutasi_date_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		},
		{
			header: 'Revised',
			dataIndex: 'omutasi_revised',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}	]);

	//master_minta_mutasi_ColumnModel.defaultSortable= true;
	/* End of Function */
    var master_minta_mutasi_paging_toolbar=new Ext.PagingToolbar({
			pageSize: pageS,
			store: master_minta_mutasi_DataStore,
			displayInfo: true
		});
	/* Declare DataStore and  show datagrid list */
	master_minta_mutasiListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'master_minta_mutasiListEditorGrid',
		el: 'fp_master_minta_mutasi',
		title: 'Daftar Permintaan Mutasi Barang',
		autoHeight: true,
		store: master_minta_mutasi_DataStore, // DataStore
		cm: master_minta_mutasi_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1220,	//900,
		bbar: master_minta_mutasi_paging_toolbar,
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_MINTAMUTASI'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<?php } ?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_MINTAMUTASI'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: master_minta_mutasi_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_MINTAMUTASI'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: master_minta_mutasi_confirm_delete   // Confirm before deleting
		}, '-',
		<?php } ?>
		{
			text: 'Adv Search',
			tooltip: 'Pencarian detail',
			iconCls:'icon-search',
			handler: display_form_search_window
		}, '-',
			new Ext.app.SearchField({
			store: master_minta_mutasi_DataStore,
			params: {start: 0, limit: pageS},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						master_minta_mutasi_DataStore.baseParams={task:'LIST',start: 0, limit: pageS};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Search By (aktif only)'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: master_minta_mutasi_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: master_minta_mutasi_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: master_minta_mutasi_print
		}
		]
	});
	master_minta_mutasiListEditorGrid.render();
	/* End of DataStore */

	/* Create Context Menu */
	master_minta_mutasi_ContextMenu = new Ext.menu.Menu({
		id: 'master_minta_mutasi_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_MINTAMUTASI'))){ ?>
		{
			text: 'Edit', tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: master_minta_mutasi_confirm_update
		},
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_MINTAMUTASI'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: master_minta_mutasi_confirm_delete
		},
		<?php } ?>
		'-',
		{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: master_minta_mutasi_print
		},
		{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: master_minta_mutasi_export_excel
		}
		]
	});
	/* End of Declaration */

	/* Event while selected row via context menu */
	function onmaster_minta_mutasi_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		master_minta_mutasi_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		master_minta_mutasi_SelectedRow=rowIndex;
		master_minta_mutasi_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */

	/* function for editing row via context menu */
	function master_minta_mutasi_editContextMenu(){
		master_minta_mutasiListEditorGrid.startEditing(master_minta_mutasi_SelectedRow,1);
  	}
	/* End of Function */
	
	/* Identify  omutasi_id Field */
	minta_mutasi_idField= new Ext.form.NumberField({
		id: 'minta_mutasi_idField',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: false,
		hidden: true,
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});

	/* Identify  omutasi_no Field */
	minta_mutasi_noField= new Ext.form.TextField({
		id: 'minta_mutasi_noField',
		fieldLabel: 'No SMB',
		emptyText: '(Auto)',
		readOnly: true,
		maxLength: 50,
		anchor: '95%'
	});
	
	/* Identify  mutasi_asal Field */
	minta_mutasi_asalField= new Ext.form.ComboBox({
		id: 'minta_mutasi_asalField',
		fieldLabel: 'Gudang Asal',
		store: cbo_minta_mutasi_gudang_all_DataStore,
		mode : 'remote',
		forceSelection: true,
		displayField:'minta_mutasi_gudang_nama',
		valueField: 'minta_mutasi_gudang_value',
        typeAhead: false,
        hideTrigger:false,
		allowBlank: false,
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});
	
	/* Identify  mutasi_tujuan Field */
	minta_mutasi_tujuanField= new Ext.form.ComboBox({
		id: 'minta_mutasi_tujuanField',
		fieldLabel: 'Gudang Tujuan',
		store: cbo_minta_mutasi_gudang_DataSore,
		mode : 'remote',
		forceSelection: true,
		displayField:'minta_mutasi_gudang_nama',
		valueField: 'minta_mutasi_gudang_value',
        typeAhead: false,
        hideTrigger:false,
		allowBlank: false,
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});
	
	var dt = new Date();
	/* Identify  omutasi_tanggal Field */
	minta_mutasi_tanggalField= new Ext.form.DateField({
		id: 'minta_mutasi_tanggalField',
		name: 'minta_mutasi_tanggalField',
		fieldLabel: 'Tanggal',
		//emptyText : dt.format('d-m-Y'),
		format : 'd-m-Y'
	});
	
	minta_mutasi_statusField= new Ext.form.ComboBox({
		id: 'minta_mutasi_statusField',
		fieldLabel: 'Status Dok',
		forceSelection: true,
		store:new Ext.data.SimpleStore({
			fields:['minta_mutasi_status_value', 'minta_mutasi_status_display'],
			data:[['Terbuka','Terbuka'],['Tertutup','Tertutup'],['Batal', 'Batal']]
		}),
		mode: 'local',
		displayField: 'minta_mutasi_status_display',
		valueField: 'minta_mutasi_status_value',
		anchor: '60%',
		allowBlank: false,
		triggerAction: 'all'
	});

	minta_mutasi_status_accField= new Ext.form.ComboBox({
		id: 'minta_mutasi_status_accField',
		fieldLabel: 'Status Acc',
		forceSelection: true,
		store:new Ext.data.SimpleStore({
			fields:['minta_mutasi_status_acc_value', 'minta_mutasi_status_acc_display'],
			data:[['Terbuka','Terbuka'],['Tertutup','Tertutup']]
		}),
		mode: 'local',
		displayField: 'minta_mutasi_status_acc_display',
		valueField: 'minta_mutasi_status_acc_value',
		anchor: '60%',
		allowBlank: false,
		triggerAction: 'all'
	});
	
	/* Identify  minta_mutasi_diskon Field */
	group_id_temp= new Ext.form.TextField({
		id: 'group_id_temp',
		anchor: '50%',
		maxLength: 5
	});

	/* Identify  minta_mutasi_biaya Field */
	minta_mutasi_biayaField= new Ext.form.TextField({
		id: 'minta_mutasi_biayaField',
		fieldLabel: 'Biaya (Rp)',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		enableKeyEvents: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});

	/* START Field master_minta_mutasi_bayarGroup */
	minta_mutasi_subtotalField= new Ext.form.TextField({
		id: 'minta_mutasi_subtotalField',
		fieldLabel: 'Sub Total (Rp)',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});

	/* Identify  minta_mutasi_bayar Field */
	minta_mutasi_totalField= new Ext.form.TextField({
		id: 'minta_mutasi_totalField',
		fieldLabel: '<span><b>Total (Rp)</b></span>',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		readOnly: true,
		anchor: '95%'
	});

	/* Identify  minta_mutasi_bayar Field */
	minta_mutasi_jumlahField= new Ext.form.TextField({
		id: 'minta_mutasi_jumlahField',
		fieldLabel: 'Jumlah Total Barang',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		readOnly: true,
		anchor: '95%'
	});

	/* Identify  minta_mutasi_bayar Field */
	minta_mutasi_itemField= new Ext.form.TextField({
		id: 'minta_mutasi_itemField',
		fieldLabel: 'Jumlah Jenis Barang',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		readOnly: true,
		anchor: '95%'
	});

	minta_mutasi_bayarField= new Ext.form.TextField({
		id: 'minta_mutasi_bayarField',
		fieldLabel: 'Uang Muka (Rp)',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		anchor: '95%',
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});

	minta_mutasi_totalbayarField= new Ext.form.TextField({
		id: 'minta_mutasi_totalbayarField',
		fieldLabel: 'Total Bayar (Rp)',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		readOnly: true,
		anchor: '95%'
	});
	/* END Field master_minta_mutasi_bayarGroup */

	/* Identify  omutasi_keterangan Field */
	minta_mutasi_keteranganField= new Ext.form.TextArea({
		id: 'minta_mutasi_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 500,
		anchor: '95%'
	});
  	/*Fieldset Master*/
	
	minta_mutasi_button_saveField=new Ext.Button({
		text: 'Save',
		handler: pengecekan_dokumen2
	});

	minta_mutasi_button_saveprintField=new Ext.Button({
		text: 'Save and Print',
		ref: '../obeli_savePrint',
		handler: pengecekan_dokumen
	});


	master_minta_mutasi_masterGroup = new Ext.form.FieldSet({
		title: 'Master',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [minta_mutasi_noField, minta_mutasi_tanggalField, minta_mutasi_asalField, minta_mutasi_tujuanField]
			},
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [minta_mutasi_keteranganField, minta_mutasi_statusField, minta_mutasi_idField]

			}
			]

	});
	//master_minta_mutasi_FootGroup
	master_minta_mutasi_bayarGroup = new Ext.form.FieldSet({
		title: '-',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				labelAlign: 'left',
				border:false,
				labelWidth: 120,
				items: [minta_mutasi_jumlahField]
			},{
				columnWidth:0.5,
				layout: 'form',
				labelAlign: 'left',
				border:false,
				items: [minta_mutasi_itemField]
			}
			]

	});

	// Function for json reader of detail
	var detail_minta_mutasi_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: 'domutasi_id'
	},[
			{name: 'domutasi_id', type: 'int', mapping: 'domutasi_id'},
			{name: 'domutasi_master', type: 'int', mapping: 'domutasi_master'},
			{name: 'domutasi_produk', type: 'int', mapping: 'domutasi_produk'},
			{name: 'produk_nama', type: 'string', mapping: 'produk_nama'},
			{name: 'dminta_mutasi_terima', type: 'float', mapping: 'jumlah_terima'},
			{name: 'domutasi_satuan', type: 'int', mapping: 'domutasi_satuan'},
			{name: 'domutasi_jumlah', type: 'int', mapping: 'jumlah_barang'}
	]);
	//eof

	//function for json writer of detail
	var detail_minta_mutasi_writer = new Ext.data.JsonWriter({
		encode: true,
		writeAllFields: false
	});
	//eof

	/* Function for Retrieve DataStore of detail*/
	detail_minta_mutasi_DataStore = new Ext.data.Store({
		id: 'detail_minta_mutasi_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_permintaan_mutasi&m=detail_detail_minta_mutasi_list',
			method: 'POST'
		}),
		reader: detail_minta_mutasi_reader,
		baseParams:{start:0, limit:pageS, task: 'detail'},
		sortInfo:{field: 'domutasi_id', direction: 'DESC'}
	});
	/* End of Function */

	//function for editor of detail
	var editor_detail_minta_mutasi= new Ext.ux.grid.RowEditor({
        saveText: 'Update'
    });
	//eof

	cbo_minta_mutasi_satuanDataStore = new Ext.data.Store({
		id: 'cbo_minta_mutasi_satuanDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_permintaan_mutasi&m=get_satuan_list',
			method: 'POST'
		}),
		baseParams:{start:0,limit:pageS,task:'detail'},
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'minta_mutasi_satuan_value'
		},[
			{name: 'minta_mutasi_satuan_value', type: 'int', mapping: 'satuan_id'},
			{name: 'minta_mutasi_satuan_kode', type: 'string', mapping: 'satuan_kode'},
			{name: 'minta_mutasi_satuan_display', type: 'string', mapping: 'satuan_nama'},
			{name: 'minta_mutasi_satuan_default', type: 'string', mapping: 'konversi_default'},
		]),
		sortInfo:{field: 'minta_mutasi_satuan_display', direction: "ASC"}
	});
	
	Ext.util.Format.comboRenderer = function(combo){
		return function(value){
			var record = combo.findRecord(combo.valueField, value);
			return record ? record.get(combo.displayField) : combo.valueNotFoundText;
		}
	}
	
	var combo_minta_mutasi_produk=new Ext.form.ComboBox({
		store: cbo_minta_mutasi_produk_DataStore,
		mode: 'remote',
		typeAhead: false,
		displayField: 'minta_mutasi_produk_nama',
		valueField: 'minta_mutasi_produk_value',
		triggerAction: 'all',
		lazyRender: false,
		pageSize: pageS,
		enableKeyEvents: true,
		tpl: minta_mutasi_produk_detail_tpl,
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});

	var combo_minta_mutasi_satuan=new Ext.form.ComboBox({
		store: cbo_minta_mutasi_satuanDataStore,
		mode: 'remote',
		typeAhead: true,
		displayField: 'minta_mutasi_satuan_display',
		valueField: 'minta_mutasi_satuan_value',
		triggerAction: 'all',
		lazyRender:true
	});

	var minta_mutasi_jumlah_barangField = new Ext.form.NumberField({
		id : 'minta_mutasi_jumlah_barangField',
		name : 'minta_mutasi_jumlah_barangField',
		allowDecimals: false,
		allowNegative: false,
		blankText : '0',
		maxLength: 11,
		enableKeyEvents: true,
		readOnly : false,
		maskRe: /([0-9]+)$/

	});
	
	//declaration of detail coloumn model
	detail_minta_mutasi_ColumnModel = new Ext.grid.ColumnModel(
		[ {
			header: '<div align="center">' + 'ID' + '</div>',
			dataIndex: 'domutasi_id',
			width: 30,	//250,
			sortable: true,
			hidden: true
		},
		 {
			header: '<div align="center">' + 'Produk' + '</div>',
			dataIndex: 'domutasi_produk',
			width: 260,	//250,
			sortable: true,
			editor: combo_minta_mutasi_produk,
			renderer: Ext.util.Format.comboRenderer(combo_minta_mutasi_produk)
		},
		{
			header: '<div align="center">' + 'Satuan' + '</div>',
			dataIndex: 'domutasi_satuan',
			width: 80,	//150,
			editor: combo_minta_mutasi_satuan,
			renderer: Ext.util.Format.comboRenderer(combo_minta_mutasi_satuan)
		},
		{
			header: '<div align="center">' + 'Jml Mutasi' + '</div>',
			align: 'right',
			dataIndex: 'domutasi_jumlah',
			width: 60,	//100,
			sortable: true,
			renderer: Ext.util.Format.numberRenderer('0,000'),
			editor: minta_mutasi_jumlah_barangField
		},
		]
	);
	detail_minta_mutasi_ColumnModel.defaultSortable= true;
	//eof
	var detail_minta_mutasi_bAdd=new Ext.Button({
		text: 'Add',
		tooltip: 'Add new detail record',
		iconCls:'icon-adds',    				// this is defined in our styles.css
		handler: detail_minta_mutasi_add
	});
	//declaration of detail list editor grid
	detail_minta_mutasiListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'detail_minta_mutasiListEditorGrid',
		el: 'fp_detail_minta_mutasi',
		title: 'Detail Item',
		height: 250,
		width: 920,	//690,
		autoScroll: false,
		store: detail_minta_mutasi_DataStore, // DataStore
		colModel: detail_minta_mutasi_ColumnModel, // Nama-nama Columns
		enableColLock:true,
		region: 'center',
        margins: '0 5 5 5',
		plugins: [editor_detail_minta_mutasi],
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true}
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_MINTAMUTASI'))){ ?>
		,
		tbar: [detail_minta_mutasi_bAdd
		, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			handler: detail_minta_mutasi_confirm_delete
		}
		]
		<?php } ?>
	});
	//eof

	//function of detail add
	function detail_minta_mutasi_add(){
		var edit_detail_minta_mutasi= new detail_minta_mutasiListEditorGrid.store.recordType({
			domutasi_id		:0,
			domutasi_master	:'',
			domutasi_produk	:'',
			domutasi_satuan	:'',
			domutasi_jumlah	:0,
		});
		editor_detail_minta_mutasi.stopEditing();
		detail_minta_mutasi_DataStore.insert(0, edit_detail_minta_mutasi);
		detail_minta_mutasiListEditorGrid.getSelectionModel().selectRow(0);
		editor_detail_minta_mutasi.startEditing(0);
	}

	//function for refresh detail
	function refresh_detail_minta_mutasi(){
		detail_minta_mutasi_DataStore.commitChanges();
		detail_minta_mutasiListEditorGrid.getView().refresh();
	}
	//eof

	/* Function for Delete Confirm of detail */
	function detail_minta_mutasi_confirm_delete(){
		// only one record is selected here
		if(detail_minta_mutasiListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', detail_minta_mutasi_delete);
		} else if(detail_minta_mutasiListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', detail_minta_mutasi_delete);
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
	function detail_minta_mutasi_delete(btn){
		if(btn=='yes'){
			var s = detail_minta_mutasiListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, r; r = s[i]; i++){
				//s[i].domutasi_id=0;
				detail_minta_mutasi_DataStore.remove(r);
				detail_minta_mutasi_DataStore.commitChanges();
				detail_minta_mutasi_total();
			}
		}
	}
	//eof



	/* Function for retrieve create Window Panel*/
	master_minta_mutasi_createForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 700,
		monitorValid: true,
		items: [master_minta_mutasi_masterGroup,detail_minta_mutasiListEditorGrid,master_minta_mutasi_bayarGroup],
		buttons: [
			{
				text: 'Print Only',
				ref:'../smbPrintOnlyButton',
				handler: op_print_only
			},
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_MINTAMUTASI'))){ ?>
			{
				xtype:'spacer',
				width: 500
			},
			minta_mutasi_button_saveprintField
			,minta_mutasi_button_saveField
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					orderbeli_post2db='CREATE';
					master_minta_mutasi_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/


	/* Function for retrieve create Window Form */
	master_minta_mutasi_createWindow= new Ext.Window({
		id: 'master_minta_mutasi_createWindow',
		title: orderbeli_post2db+'Permintaan Mutasi Barang',
		closable:true,
		closeAction: 'hide',
		width: 940,
		//autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_master_minta_mutasi_create',
		items: master_minta_mutasi_createForm
	});
	/* End Window */


	/* Function for action list search */
	function master_minta_mutasi_list_search(){
		// render according to a SQL date format.
		var minta_mutasi_id_search=null;
		var minta_mutasi_no_search=null;
		var minta_mutasi_tanggal_search_date="";
		var minta_mutasi_tanggal_akhir_search_date="";
		var minta_mutasi_keterangan_search=null;
		var minta_mutasi_status_search=null;

		if(minta_mutasi_idSearchField.getValue()!==null){minta_mutasi_id_search=minta_mutasi_idSearchField.getValue();}
		if(minta_mutasi_noSearchField.getValue()!==null){minta_mutasi_no_search=minta_mutasi_noSearchField.getValue();}
		if(minta_mutasi_tanggalSearchField.getValue()!==""){minta_mutasi_tanggal_search_date=minta_mutasi_tanggalSearchField.getValue().format('Y-m-d');}
		if(minta_mutasi_tanggal_akhirSearchField.getValue()!==""){minta_mutasi_tanggal_akhir_search_date=minta_mutasi_tanggal_akhirSearchField.getValue().format('Y-m-d');}
		if(minta_mutasi_keteranganSearchField.getValue()!==null){minta_mutasi_keterangan_search=minta_mutasi_keteranganSearchField.getValue();}
		if(minta_mutasi_statusSearchField.getValue()!==null){minta_mutasi_status_search=minta_mutasi_statusSearchField.getValue();}
		if(minta_mutasi_status_accSearchField.getValue()!==null){minta_mutasi_status_acc_search=minta_mutasi_status_accSearchField.getValue();}

		// change the store parameters
		master_minta_mutasi_DataStore.baseParams = {
			task				: 'SEARCH',
			omutasi_id			:	minta_mutasi_id_search,
			omutasi_no			:	minta_mutasi_no_search,
			minta_mutasi_tgl_awal		:	minta_mutasi_tanggal_search_date,
			minta_mutasi_tgl_akhir		:	minta_mutasi_tanggal_akhir_search_date,
			omutasi_keterangan	:	minta_mutasi_keterangan_search,
			omutasi_status		:	minta_mutasi_status_search
		};
		master_minta_mutasi_DataStore.reload({params: {start: 0, limit: pageS}});
	}

	/* Function for reset search result */
	function master_minta_mutasi_reset_search(){
		// reset the store parameters
		master_minta_mutasi_DataStore.baseParams = { task: 'LIST', start: 0, limit: pageS };
		master_minta_mutasi_DataStore.reload({params: {start: 0, limit: pageS}});
		//master_minta_mutasi_searchWindow.close();
	};
	/* End of Fuction */

	function master_minta_mutasi_cetak_faktur(pkid){

		Ext.Ajax.request({
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_master_permintaan_mutasi&m=print_faktur',
		params: {
			faktur	: pkid
		},
		success: function(response){
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/minta_mutasi_faktur.html','minta_mutasi_faktur','height=800,width=670,resizable=1,scrollbars=1, menubar=1');
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

	function master_minta_mutasi_reset_SearchForm(){
		minta_mutasi_noSearchField.reset();
		minta_mutasi_tanggalSearchField.reset();
		minta_mutasi_tanggal_akhirSearchField.reset();
		minta_mutasi_keteranganSearchField.reset();
		minta_mutasi_statusSearchField.reset();
		minta_mutasi_status_accSearchField.reset();
	}
	/* Field for search */
	/* Identify  omutasi_id Search Field */
	minta_mutasi_idSearchField= new Ext.form.NumberField({
		id: 'minta_mutasi_idSearchField',
		fieldLabel: 'Id Order',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/

	});
	/* Identify  omutasi_no Search Field */
	minta_mutasi_noSearchField= new Ext.form.TextField({
		id: 'minta_mutasi_noSearchField',
		//fieldLabel: 'No Order',
		fieldLabel: 'No SMB',
		maxLength: 50,
		anchor: '95%'

	});
	
	/* Identify  omutasi_tanggal Search Field */
	minta_mutasi_tanggalSearchField= new Ext.form.DateField({
		id: 'minta_mutasi_tanggalSearchField',
		fieldLabel: 'Tanggal',
		format : 'd-m-Y'
//		value: firstday

	});

	minta_mutasi_tanggal_akhirSearchField= new Ext.form.DateField({
		id: 'minta_mutasi_tanggal_akhirSearchField',
		fieldLabel: 's/d',
		format : 'd-m-Y'
//		value: today
	});

	minta_mutasi_label_tanggal_labelField=new Ext.form.Label({html: 'Tanggal :' });

	minta_mutasi_label_tanggalField= new Ext.form.Label({ html: ' &nbsp; s/d  &nbsp;' });

	minta_mutasi_tanggalSearchFieldSet=new Ext.form.FieldSet({
		id:'minta_mutasi_tanggalSearchFieldSet',
		title: 'Opsi Tanggal',
		layout: 'column',
		boduStyle: 'padding: 5px;',
		frame: false,
		items:[minta_mutasi_tanggalSearchField, minta_mutasi_label_tanggalField, minta_mutasi_tanggal_akhirSearchField]
	});

	/* Identify  omutasi_keterangan Search Field */
	minta_mutasi_keteranganSearchField= new Ext.form.TextField({
		id: 'minta_mutasi_keteranganSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 500,
		anchor: '95%'
	});

	minta_mutasi_statusSearchField= new Ext.form.ComboBox({
		id: 'minta_mutasi_statusSearchField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['value', 'omutasi_status'],
			data:[['Terbuka','Terbuka'],['Tertutup','Tertutup'],['Batal','Batal']]
		}),
		mode: 'local',
		displayField: 'omutasi_status',
		valueField: 'value',
		anchor: '41%',
		triggerAction: 'all'
	});

	minta_mutasi_status_accSearchField= new Ext.form.ComboBox({
		id: 'minta_mutasi_status_accSearchField',
		fieldLabel: 'Status Acc',
		store:new Ext.data.SimpleStore({
			fields:['value', 'minta_mutasi_status_acc'],
			data:[['Terbuka','Terbuka'],['Tertutup','Tertutup']]
		}),
		mode: 'local',
		displayField: 'minta_mutasi_status_acc',
		valueField: 'value',
		anchor: '41%',
		triggerAction: 'all'
	});


	/* Function for retrieve search Form Panel */
	master_minta_mutasi_searchForm = new Ext.FormPanel({
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
				items: [
					minta_mutasi_noSearchField,
					{
						layout:'column',
						border:false,
						items:[
						{
							columnWidth:0.45,
							layout: 'form',
							border:false,
							defaultType: 'datefield',
							items: [
								minta_mutasi_tanggalSearchField
							]
						},
						{
							columnWidth:0.30,
							layout: 'form',
							border:false,
							labelWidth:30,
							defaultType: 'datefield',
							items: [
								minta_mutasi_tanggal_akhirSearchField
							]
						}
				        ]
					},
					minta_mutasi_keteranganSearchField,
					minta_mutasi_statusSearchField
					]
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: master_minta_mutasi_list_search
			},{
				text: 'Close',
				handler: function(){
					master_minta_mutasi_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */

	/* Function for retrieve search Window Form, used for andvaced search */
	master_minta_mutasi_searchWindow = new Ext.Window({
		title: 'Percarian Permintaan Mutasi Barang',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_master_minta_mutasi_search',
		items: master_minta_mutasi_searchForm
	});
    /* End of Function */

  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!master_minta_mutasi_searchWindow.isVisible()){
			master_minta_mutasi_reset_SearchForm();
			master_minta_mutasi_searchWindow.show();
		} else {
			master_minta_mutasi_searchWindow.toFront();
		}
	}
  	/* End Function */



	/* Function for print List Grid */
	function master_minta_mutasi_print(){
		var searchquery = "";
		var minta_mutasi_no_print=null;
		var minta_mutasi_tgl_awal_print_date="";
		var minta_mutasi_tgl_akhir_print_date;
		var minta_mutasi_keterangan_print=null;
		var minta_mutasi_status_print=null;
		var win;

		if(master_minta_mutasi_DataStore.baseParams.query!==null){searchquery = master_minta_mutasi_DataStore.baseParams.query;}
		if(master_minta_mutasi_DataStore.baseParams.omutasi_no!==null){minta_mutasi_no_print = master_minta_mutasi_DataStore.baseParams.omutasi_no;}
		if(master_minta_mutasi_DataStore.baseParams.minta_mutasi_tgl_awal!==""){minta_mutasi_tgl_awal_print_date = master_minta_mutasi_DataStore.baseParams.minta_mutasi_tgl_awal;}
		if(master_minta_mutasi_DataStore.baseParams.minta_mutasi_tgl_akhir!==""){minta_mutasi_tgl_akhir_print_date = master_minta_mutasi_DataStore.baseParams.minta_mutasi_tgl_akhir;}
		if(master_minta_mutasi_DataStore.baseParams.omutasi_keterangan!==null){minta_mutasi_keterangan_print = master_minta_mutasi_DataStore.baseParams.omutasi_keterangan;}
		if(master_minta_mutasi_DataStore.baseParams.omutasi_status!==null){minta_mutasi_status_print = master_minta_mutasi_DataStore.baseParams.omutasi_status;}
		if(master_minta_mutasi_DataStore.baseParams.minta_mutasi_status_acc!==null){minta_mutasi_status_acc_print = master_minta_mutasi_DataStore.baseParams.minta_mutasi_status_acc;}


		Ext.Ajax.request({
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_master_permintaan_mutasi&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,
			omutasi_no 			: minta_mutasi_no_print,
		  	minta_mutasi_tgl_awal 		: minta_mutasi_tgl_awal_print_date,
			minta_mutasi_tgl_akhir		: minta_mutasi_tgl_akhir_print_date,
			omutasi_keterangan 	: minta_mutasi_keterangan_print,
			omutasi_status		: minta_mutasi_status_print,
		  	currentlisting		: master_minta_mutasi_DataStore.baseParams.task // this tells us if we are searching or not
		},
		success: function(response){
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/print_minta_mutasilist.html','print_minta_mutasilist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
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
	function master_minta_mutasi_export_excel(){
		var searchquery = "";
		var minta_mutasi_no_2excel=null;
		var minta_mutasi_tgl_awal_2excel_date="";
		var minta_mutasi_tgl_akhir_2excel_date="";
		var minta_mutasi_status_2excel=null;
		var minta_mutasi_keterangan_2excel=null;
		var win;
		// check if we do have some search data...
		if(master_minta_mutasi_DataStore.baseParams.query!==null){searchquery = master_minta_mutasi_DataStore.baseParams.query;}
		if(master_minta_mutasi_DataStore.baseParams.omutasi_no!==null){minta_mutasi_no_2excel = master_minta_mutasi_DataStore.baseParams.omutasi_no;}
		if(master_minta_mutasi_DataStore.baseParams.minta_mutasi_tgl_awal!==""){minta_mutasi_tgl_awal_2excel_date = master_minta_mutasi_DataStore.baseParams.minta_mutasi_tgl_awal;}
		if(master_minta_mutasi_DataStore.baseParams.minta_mutasi_tgl_akhir!==""){minta_mutasi_tgl_akhir_2excel_date = master_minta_mutasi_DataStore.baseParams.minta_mutasi_tgl_akhir;}
		if(master_minta_mutasi_DataStore.baseParams.omutasi_status!==null){minta_mutasi_status_2excel = master_minta_mutasi_DataStore.baseParams.omutasi_status;}
		if(master_minta_mutasi_DataStore.baseParams.omutasi_keterangan!==null){minta_mutasi_keterangan_2excel = master_minta_mutasi_DataStore.baseParams.omutasi_keterangan;}

		Ext.Ajax.request({
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_master_permintaan_mutasi&m=get_action',
		params: {
			task				: "EXCEL",
		  	query				: searchquery,
			omutasi_no 			: minta_mutasi_no_2excel,
		  	minta_mutasi_tgl_awal		: minta_mutasi_tgl_awal_2excel_date,
			minta_mutasi_tgl_akhir		: minta_mutasi_tgl_akhir_2excel_date,
			omutasi_status		: minta_mutasi_status_2excel,
			omutasi_keterangan 	: minta_mutasi_keterangan_2excel,
		  	currentlisting		: master_minta_mutasi_DataStore.baseParams.task
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

	function detail_minta_mutasi_total(){
		var jumlah_item=0;
		for(i=0;i<detail_minta_mutasi_DataStore.getCount();i++){
			detail_minta_mutasi_record=detail_minta_mutasi_DataStore.getAt(i);
			jumlah_item=jumlah_item+detail_minta_mutasi_record.data.domutasi_jumlah;
		}
		minta_mutasi_jumlahField.setValue(CurrencyFormatted(jumlah_item));
		minta_mutasi_itemField.setValue(CurrencyFormatted(detail_minta_mutasi_DataStore.getCount()));
	}

	master_minta_mutasi_DataStore.load({params:{start:0, limit: pageS}});
	detail_minta_mutasi_DataStore.on("load",detail_minta_mutasi_total);

	master_minta_mutasiListEditorGrid.addListener('rowcontextmenu', onmaster_minta_mutasi_ListEditGridContextMenu);

	combo_minta_mutasi_produk.on("focus",function(){
		cbo_minta_mutasi_produk_DataStore.setBaseParam('task','list');
		var selectedquery=detail_minta_mutasiListEditorGrid.getSelectionModel().getSelected().get('produk_nama');
		cbo_minta_mutasi_produk_DataStore.setBaseParam('query',selectedquery);

		//cbo_minta_mutasi_produk_DataStore.load();
	});

	combo_minta_mutasi_satuan.on("focus",function(){
		cbo_minta_mutasi_satuanDataStore.setBaseParam('task','produk');
		cbo_minta_mutasi_satuanDataStore.setBaseParam('selected_id',combo_minta_mutasi_produk.getValue());
		cbo_minta_mutasi_satuanDataStore.load();
	});

	combo_minta_mutasi_produk.on("select",function(){
		cbo_minta_mutasi_satuanDataStore.setBaseParam('task','produk');
		cbo_minta_mutasi_satuanDataStore.setBaseParam('selected_id',combo_minta_mutasi_produk.getValue());
		/*cbo_minta_mutasi_satuanDataStore.load({
			callback: function(r,opt,success){
				cbo_dminta_mutasi_produk_hargaDataStore.load({
					callback: function(r,opt,success){
				if(success==true){
					if(cbo_minta_mutasi_satuanDataStore.getCount()>0){
						var j=cbo_minta_mutasi_satuanDataStore.findExact('minta_mutasi_satuan_default','true');
						if(j>-1){
							var sat_default=cbo_minta_mutasi_satuanDataStore.getAt(j);							
							combo_minta_mutasi_satuan.setValue(sat_default.data.minta_mutasi_satuan_value);
						}	
					}	
				}
			}
			});	
			}

		});*/
	});

	detail_minta_mutasi_DataStore.on("update",function(){
		var	query_selected="";
		var satuan_selected="";
		detail_minta_mutasi_DataStore.commitChanges();
		detail_minta_mutasi_total();
		cbo_minta_mutasi_produk_DataStore.lastQuery=null;
		for(i=0;i<detail_minta_mutasi_DataStore.getCount();i++){
			detail_minta_mutasi_record=detail_minta_mutasi_DataStore.getAt(i);
			query_selected=query_selected+detail_minta_mutasi_record.data.domutasi_produk+",";
		}
		cbo_minta_mutasi_produk_DataStore.setBaseParam('task','selected');
		cbo_minta_mutasi_produk_DataStore.setBaseParam('master_id',get_pk_id());
		cbo_minta_mutasi_produk_DataStore.setBaseParam('selected_id',query_selected);
		cbo_minta_mutasi_produk_DataStore.load();

		for(i=0;i<detail_minta_mutasi_DataStore.getCount();i++){
			detail_minta_mutasi_record=detail_minta_mutasi_DataStore.getAt(i);
			satuan_selected=satuan_selected+detail_minta_mutasi_record.data.domutasi_satuan+",";
		}
		cbo_minta_mutasi_satuanDataStore.setBaseParam('task','selected');
		cbo_minta_mutasi_satuanDataStore.setBaseParam('selected_id',satuan_selected);
		cbo_minta_mutasi_satuanDataStore.load();
		stat='EDIT';
		


	});

	detail_minta_mutasi_DataStore.on("load", function(){
		if(detail_minta_mutasi_DataStore.getCount()==pageS && detail_minta_mutasi_DataStore.getTotalCount()>pageS){
			detail_minta_mutasi_bAdd.disabled=true;
		}else{
			detail_minta_mutasi_bAdd.disabled=false;
		}


	});

	/*master_minta_mutasi_paging_toolbar.on("change", function(){
			console.log('aktive page :');
	});*/

});
	</script>
</head>
<body>
<div>
	<div class="col">
        <div id="fp_master_minta_mutasi"></div>
         <div id="fp_detail_minta_mutasi"></div>
		<div id="elwindow_master_minta_mutasi_create"></div>
        <div id="elwindow_master_minta_mutasi_search"></div>
    </div>
</div>
</body>
</html>