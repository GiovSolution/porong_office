<?
/* 	
	GIOV Solution - Keep IT Simple
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
var master_minta_beli_DataStore;
var master_minta_beli_ColumnModel;
var master_minta_beli_ListEditorGrid;
var master_minta_beli_createForm;
var master_minta_beli_createWindow;
var master_minta_beli_searchForm;
var master_minta_beli_searchWindow;
var master_minta_beli_SelectedRow;
var master_minta_beli_ContextMenu;
//for detail data
var detail_minta_beli_DataStore;
var detail_minta_beli_ListEditorGrid;
var detail_minta_beli_ColumnModel;
var detail_minta_beli_proxy;
var detail_minta_beli_writer;
var detail_minta_beli_reader;
var editor_detail_minta_beli;
var today=new Date().format('Y-m-d');
var firstday=(new Date().format('Y-m'))+'-01';
//declare konstant
var mintabeli_post2db = '';
var msg = '';
var pageS=15;
var cetak_minta=0;
var minta_acc_group=<?=$_SESSION[SESSION_GROUPID];?>;
var stat='ADD';
/* declare variable here for Field*/
var minta_idField;
var minta_noField;
var minta_supplierField;
var minta_tanggalField;
var minta_carabayarField;
var minta_diskonField;
var minta_biayaField;
var minta_bayarField;
var minta_keteranganField;
var minta_idSearchField;
var minta_noSearchField;
var minta_supplierSearchField;
var minta_tanggalSearchField;
var minta_tanggal_akhirSearchField;
var minta_carabayarSearchField;
//var order_diskonSearchField;
//var order_biayaSearchField;
//var order_bayarSearchField;
var minta_keteranganSearchField;
var minta_statusSearchField;
var minta_status_accSearchField;
var detail_minta_beli_DataStore;

var minta_button_saveField;
var minta_button_saveandprintField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */

  /*Function for pengecekan _dokumen */
	function pengecekan_dokumen(){
		var minta_tanggal_create_date = "";
		if(minta_tanggalField.getValue()!== ""){minta_tanggal_create_date = minta_tanggalField.getValue().format('Y-m-d');}
		Ext.Ajax.request({
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_master_minta_beli&m=get_action',
			params: {
				task: "CEK",
				tanggal_pengecekan	: minta_tanggal_create_date

			},
			success: function(response){
				var result=eval(response.responseText);
				switch(result){
						case 1:
							cetak_minta=1;
							master_minta_beli_create('print');
						break;
						default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Data Permintaan Pembelian tidak bisa disimpan, karena telah melebihi batas hari yang diperbolehkan ',
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
		var minta_tanggal_create_date = "";
		if(minta_tanggalField.getValue()!== ""){minta_tanggal_create_date = minta_tanggalField.getValue().format('Y-m-d');}
		Ext.Ajax.request({
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_master_minta_beli&m=get_action',
			params: {
				task: "CEK",
				tanggal_pengecekan	: minta_tanggal_create_date

			},
			success: function(response){
				var result=eval(response.responseText);
				switch(result){
						case 1:
							cetak_minta=0;
							master_minta_beli_create();
						break;
						default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Data Permintaan Pembelian tidak bisa disimpan, karena telah melebihi batas hari yang diperbolehkan ',
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
	function master_minta_beli_create(opsi){

		/*
		if(minta_supplierField.getValue()==0){
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Supplier tidak ada',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});

		}else 
		*/
		if(detail_minta_beli_DataStore.getCount()<1){
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Data detail harus ada minimal 1 (satu)',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		} else if(is_master_minta_beli_form_valid()){

		var minta_id_create_pk=null;
		var minta_no_create=null;
		var minta_supplier_create=null;
		var minta_tanggal_create_date="";
		var minta_carabayar_create=null;
		var order_diskon_create=null;
		var order_cashback_create=null;
		var order_biaya_create=null;
		var order_bayar_create=null;
		var minta_keterangan_create=null;
		var minta_status_create=null;
		var minta_status_acc_create=null;
		var minta_gudang_create=null;
		var minta_jenis_create=null;

		if(minta_idField.getValue()!== null){minta_id_create_pk = minta_idField.getValue();}else{minta_id_create_pk=get_pk_id();}
		if(minta_noField.getValue()!== null){minta_no_create = minta_noField.getValue();}
		if(minta_supplierField.getValue()!== null){minta_supplier_create = minta_supplierField.getValue();}
		if(minta_tanggalField.getValue()!== ""){minta_tanggal_create_date = minta_tanggalField.getValue().format('Y-m-d');}
		if(minta_carabayarField.getValue()!== null){minta_carabayar_create = minta_carabayarField.getValue();}
		if(minta_gudangField.getValue()!== null){minta_gudang_create = minta_gudangField.getValue();}

		<?php if(($_SESSION[SESSION_GROUPID]==9) || ($_SESSION[SESSION_GROUPID]==1)){ ?>
		if(minta_diskonField.getValue()!== null){order_diskon_create = convertToNumber(minta_diskonField.getValue());}
		if(minta_cashbackField.getValue()!== null){order_cashback_create = convertToNumber(minta_cashbackField.getValue());}
		if(minta_biayaField.getValue()!== null){order_biaya_create = convertToNumber(minta_biayaField.getValue());}
		if(minta_bayarField.getValue()!== null){order_bayar_create = convertToNumber(minta_bayarField.getValue());}
		<?php } ?>
		if(minta_keteranganField.getValue()!== null){minta_keterangan_create = minta_keteranganField.getValue();}
		if(minta_statusField.getValue()!== null){minta_status_create = minta_statusField.getValue();}
		if(minta_status_accField.getValue()!== null){minta_status_acc_create = minta_status_accField.getValue();}
		if(minta_jenisField.getValue()!== null){minta_jenis_create = minta_jenisField.getValue();}

		var dminta_id = [];
	    var dminta_produk = [];
	    var dminta_satuan = [];
	    var dminta_jumlah = [];
	    var dminta_harga = [];
	    var dminta_diskon = [];
	    var dminta_keterangan =[];

	    var dcount = detail_minta_beli_DataStore.getCount() - 1;
		var dminta_jum_terima=0;
		
        if(detail_minta_beli_DataStore.getCount()>0){
            for(i=0; i<detail_minta_beli_DataStore.getCount();i++){
                if((/^\d+$/.test(detail_minta_beli_DataStore.getAt(i).data.dminta_produk))
				   && detail_minta_beli_DataStore.getAt(i).data.dminta_produk!==undefined
				   && detail_minta_beli_DataStore.getAt(i).data.dminta_produk!==''
				   && detail_minta_beli_DataStore.getAt(i).data.dminta_produk!==0
				   && detail_minta_beli_DataStore.getAt(i).data.dminta_satuan!==''
				   && detail_minta_beli_DataStore.getAt(i).data.dminta_jumlah>0){

                  	dminta_id.push(detail_minta_beli_DataStore.getAt(i).data.dminta_id);
					dminta_produk.push(detail_minta_beli_DataStore.getAt(i).data.dminta_produk);
                   	dminta_satuan.push(detail_minta_beli_DataStore.getAt(i).data.dminta_satuan);
					dminta_jumlah.push(detail_minta_beli_DataStore.getAt(i).data.dminta_jumlah);
					dminta_harga.push(detail_minta_beli_DataStore.getAt(i).data.dminta_harga);
					dminta_diskon.push(detail_minta_beli_DataStore.getAt(i).data.dminta_diskon);
					dminta_keterangan.push(detail_minta_beli_DataStore.getAt(i).data.dminta_keterangan);
                }
				dminta_jum_terima=dminta_jum_terima+detail_minta_beli_record.data.dorder_terima;
            }

			var encoded_array_dminta_id = Ext.encode(dminta_id);
			var encoded_array_dminta_produk = Ext.encode(dminta_produk);
			var encoded_array_dminta_satuan = Ext.encode(dminta_satuan);
			var encoded_array_dminta_jumlah = Ext.encode(dminta_jumlah);
			var encoded_array_dminta_harga = Ext.encode(dminta_harga);
			var encoded_array_dminta_diskon = Ext.encode(dminta_diskon);
			var encoded_array_dminta_keterangan = Ext.encode(dminta_keterangan);
			
	    }
	    
		Ext.MessageBox.show({
			msg:   'Sedang memproses data, mohon tunggu hingga proses ini selesai agar keamanan data anda terjaga...',
			progressText: 'proses...',
			width:350,
			wait:true
		});
		
		Ext.Ajax.request({
			waitMsg: 'Mohon tunggu...',
			url: 'index.php?c=c_master_minta_beli&m=get_action',
			params: {
				task				: mintabeli_post2db,
				minta_id			: minta_id_create_pk,
				minta_no			: minta_no_create,
				minta_supplier		: minta_supplier_create,
				minta_tanggal		: minta_tanggal_create_date,
				minta_gudang		: minta_gudang_create,
				minta_jenis		 	: minta_jenis_create,
				order_carabayar		: minta_carabayar_create,
				order_diskon		: order_diskon_create,
				order_cashback		: order_cashback_create,
				order_biaya			: order_biaya_create,
				order_bayar			: order_bayar_create,
				minta_keterangan	: minta_keterangan_create,
				minta_status		: minta_status_create,
				minta_status_acc	: minta_status_acc_create,
				cetak_minta			: cetak_minta,
				dminta_id			: encoded_array_dminta_id,
				dminta_produk		: encoded_array_dminta_produk,
				dminta_satuan		: encoded_array_dminta_satuan,
				dminta_jumlah		: encoded_array_dminta_jumlah,
				dminta_harga		: encoded_array_dminta_harga,
				dminta_diskon		: encoded_array_dminta_diskon,
				dminta_keterangan	: encoded_array_dminta_keterangan
			},
			success: function(response){
				var result=eval(response.responseText);
				if(dminta_jum_terima > 0 && minta_statusField.getValue()=='Batal'){
					Ext.MessageBox.show({
						title: 'Warning',
						msg: 'PP yang pernah diambil di OP tidak dapat dibatalkan!',
						buttons: Ext.MessageBox.OK,
						animEl: 'save',
						icon: Ext.MessageBox.WARNING
					});
					minta_statusField.setValue(master_minta_beli_ListEditorGrid.getSelectionModel().getSelected().get('minta_status'));
					
				} else if(result!==0){
						Ext.MessageBox.alert(mintabeli_post2db+' OK','Data Permintaan Pembelian berhasil disimpan');
						if(opsi=='print'){
							master_minta_beli_cetak_faktur(result);
						}
						master_minta_beli_DataStore.reload()
						master_minta_beli_createWindow.hide();
				} else {
						Ext.MessageBox.show({
						   title: 'Warning',
						   //msg: 'We could\'t not '+msg+' the Master_order_beli.',
						   msg: 'Data Permintaan Pembelian tidak bisa disimpan',
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
		if(mintabeli_post2db=='UPDATE')
			return master_minta_beli_ListEditorGrid.getSelectionModel().getSelected().get('minta_id');
		else if(mintabeli_post2db=='CREATE')
			return minta_idField.getValue();
		else
			return -1;
	}
	/* End of Function  */

	/*Function utk mengecek, jika Field Supplier blom diisikan, maka Detail Item akan di disabled , dan field Supplier akan di disabled juga (utk keperluan last OP Price, kalau suppliernya di ganti2, nanti Last OP Price jg ikut ganti2*/
	function check_supplier(){
		if(minta_gudangField.getValue()=="" || minta_gudangField.getValue()==null){
			detail_minta_beli_ListEditorGrid.setDisabled(true);
		}else{
			detail_minta_beli_ListEditorGrid.setDisabled(false);
			minta_supplier_idField.setValue(minta_supplierField.getValue());
			// minta_supplierField.setDisabled(true);
			/*
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Untuk kevalidan data, kolom Supplier tidak dapat diubah lagi.',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
			*/
		}
	}
	
	
	/* Reset form before loading */
	function master_minta_beli_reset_form(){
		minta_idField.reset();
		minta_idField.setValue(null);
		minta_noField.reset();
		minta_noField.setValue('(Auto)');
		minta_supplierField.reset();
		minta_supplierField.setValue(null);
		minta_supplier_idField.reset();
		minta_supplier_idField.setValue(null);
		minta_tanggalField.setValue(today);
		minta_carabayarField.reset();
		minta_carabayarField.setValue('Kredit');
		minta_diskonField.reset();
		minta_diskonField.setValue('0');
		minta_cashbackField.reset();
		minta_cashbackField.setValue('0');
		minta_biayaField.reset();
		minta_biayaField.setValue('0');
		minta_bayarField.reset();
		minta_bayarField.setValue('0');
		minta_keteranganField.reset();
		minta_keteranganField.setValue(null);
		minta_statusField.reset();
		minta_statusField.setValue('Terbuka');
		minta_jenisField.reset();
		minta_jenisField.setValue(null);
		minta_status_accField.reset();
		minta_status_accField.setValue('Terbuka');
		minta_idField.setDisabled(false);
		minta_noField.setDisabled(false);
		minta_supplierField.setDisabled(false);
		minta_tanggalField.setDisabled(false);
		minta_jenisField.setDisabled(false);
		minta_carabayarField.setDisabled(false);
		minta_diskonField.setDisabled(false);
		minta_cashbackField.setDisabled(false);
		minta_biayaField.setDisabled(false);
		minta_bayarField.setDisabled(false);
		minta_keteranganField.setDisabled(false);
		minta_statusField.setDisabled(false);
		minta_status_accField.setDisabled(false);
		combo_minta_produk.setDisabled(false);
		combo_minta_satuan.setDisabled(false);
		minta_jumlah_barangField.setDisabled(false);
		/*cbo_minta_satuanDataStore.load();
		cbo_minta_produk_DataStore.load();*/
		detail_minta_beli_DataStore.load({params: {master_id:-1}});
		master_minta_beli_createForm.obeli_savePrint.enable();
		master_minta_beli_createForm.printOnlyButton.disable();	
		master_minta_beli_createForm.saveHargaButton.disable();	

		check_acc();
		check_supplier();
	}
 	/* End of Function */

	/* setValue to EDIT */
	function master_minta_beli_set_form(){
		
		minta_idField.setValue(master_minta_beli_ListEditorGrid.getSelectionModel().getSelected().get('minta_id'));
		minta_noField.setValue(master_minta_beli_ListEditorGrid.getSelectionModel().getSelected().get('minta_no'));
		minta_supplierField.setValue(master_minta_beli_ListEditorGrid.getSelectionModel().getSelected().get('minta_supplier'));
		minta_gudangField.setValue(master_minta_beli_ListEditorGrid.getSelectionModel().getSelected().get('minta_gudang_nama'));
		minta_gudang_idField.setValue(master_minta_beli_ListEditorGrid.getSelectionModel().getSelected().get('minta_gudang_id'));
		//minta_supplier_idField.setValue(master_minta_beli_ListEditorGrid.getSelectionModel().getSelected().get(''));
		// disini mesti e ditambahin OrderSupplier_IDField, set value bla bla bla minta_supplier_id / supplier_id
		//Nanti jangan lupa, pengecekan get_last_op_price nya di get value() dari ordersupplier_idField ini.. 
		minta_supplier_idField.setValue(master_minta_beli_ListEditorGrid.getSelectionModel().getSelected().get('minta_supplier_id'));
		minta_tanggalField.setValue(master_minta_beli_ListEditorGrid.getSelectionModel().getSelected().get('minta_tanggal'));
		minta_carabayarField.setValue(master_minta_beli_ListEditorGrid.getSelectionModel().getSelected().get('order_carabayar'));
		minta_diskonField.setValue(CurrencyFormatted(master_minta_beli_ListEditorGrid.getSelectionModel().getSelected().get('order_diskon')));
		minta_cashbackField.setValue(CurrencyFormatted(master_minta_beli_ListEditorGrid.getSelectionModel().getSelected().get('order_cashback')));
		minta_biayaField.setValue(CurrencyFormatted(master_minta_beli_ListEditorGrid.getSelectionModel().getSelected().get('order_biaya')));
		minta_bayarField.setValue(CurrencyFormatted(master_minta_beli_ListEditorGrid.getSelectionModel().getSelected().get('order_bayar')));
		minta_keteranganField.setValue(master_minta_beli_ListEditorGrid.getSelectionModel().getSelected().get('minta_keterangan'));
		minta_statusField.setValue(master_minta_beli_ListEditorGrid.getSelectionModel().getSelected().get('minta_status'));
		minta_jenisField.setValue(master_minta_beli_ListEditorGrid.getSelectionModel().getSelected().get('minta_jenis'));
		minta_status_accField.setValue(master_minta_beli_ListEditorGrid.getSelectionModel().getSelected().get('minta_status_acc'));

		//LOAD DETAIL
		cbo_minta_satuanDataStore.setBaseParam('task','detail');
		cbo_minta_satuanDataStore.setBaseParam('master_id',get_pk_id());
		cbo_minta_satuanDataStore.load();

		minta_button_saveField.setDisabled(true);
		//minta_button_saveandprintField.setDisabled(true);

		cbo_minta_produk_DataStore.setBaseParam('master_id',get_pk_id());
		cbo_minta_produk_DataStore.setBaseParam('task','detail');
		cbo_minta_produk_DataStore.load({
			callback: function(r,opt,success){
				if(success==true){
					detail_minta_beli_DataStore.setBaseParam('master_id',get_pk_id());
					detail_minta_beli_DataStore.load({
						callback: function(r,opt,success){
							if(success==true){
								Ext.MessageBox.hide();
								minta_button_saveField.setDisabled(false);
								//minta_button_saveandprintField.setDisabled(false);
							}
						}
					});
				}
			}
		});

		//END OF LOAD

		check_acc();
		//check_supplier();

		if(mintabeli_post2db=="UPDATE" && master_minta_beli_ListEditorGrid.getSelectionModel().getSelected().get('minta_status')=="Terbuka"){
			minta_idField.setDisabled(false);
			minta_noField.setDisabled(false);
			minta_supplierField.setDisabled(true);
			minta_tanggalField.setDisabled(false);
			minta_jenisField.setDisabled(false);
			minta_carabayarField.setDisabled(false);
			minta_diskonField.setDisabled(false);
			minta_cashbackField.setDisabled(false);
			minta_biayaField.setDisabled(false);
			minta_bayarField.setDisabled(false);
			minta_keteranganField.setDisabled(false);
			minta_statusField.setDisabled(false);
			minta_status_accField.setDisabled(false);
			combo_minta_produk.setDisabled(false);
			combo_minta_satuan.setDisabled(false);
			minta_jumlah_barangField.setDisabled(false);
			master_minta_beli_createForm.obeli_savePrint.enable();
			master_minta_beli_createForm.printOnlyButton.disable();	
			master_minta_beli_createForm.saveHargaButton.disable();	
			minta_button_saveandprintField.setDisabled(false);	
			detail_minta_beli_ListEditorGrid.setDisabled(false);		
		}
		if(mintabeli_post2db=="UPDATE" && master_minta_beli_ListEditorGrid.getSelectionModel().getSelected().get('minta_status')=="Tertutup"){
			minta_idField.setDisabled(true);
			minta_noField.setDisabled(true);
			minta_supplierField.setDisabled(true);
			minta_tanggalField.setDisabled(true);
			minta_jenisField.setDisabled(true);
			minta_carabayarField.setDisabled(true);
			minta_diskonField.setDisabled(true);
			minta_cashbackField.setDisabled(true);
			minta_biayaField.setDisabled(true);
			minta_bayarField.setDisabled(true);
			minta_keteranganField.setDisabled(true);
			minta_status_accField.setDisabled(true);
			minta_statusField.setDisabled(false);
			combo_minta_produk.setDisabled(true);
			combo_minta_satuan.setDisabled(true);
			minta_jumlah_barangField.setDisabled(true);
			master_minta_beli_createForm.printOnlyButton.enable();	
			master_minta_beli_createForm.saveHargaButton.enable();	
			minta_button_saveandprintField.setDisabled(true);
			detail_minta_beli_ListEditorGrid.setDisabled(true);
			if(cetak_minta==1){
					//jproduk_cetak(jproduk_id_for_cetak);
				cetak_minta=0;
			}

		}
		if(mintabeli_post2db=="UPDATE" && master_minta_beli_ListEditorGrid.getSelectionModel().getSelected().get('minta_status')=="Batal"){
			minta_idField.setDisabled(true);
			minta_noField.setDisabled(true);
			minta_supplierField.setDisabled(true);
			minta_tanggalField.setDisabled(true);
			minta_jenisField.setDisabled(true);
			minta_carabayarField.setDisabled(true);
			minta_diskonField.setDisabled(true);
			minta_cashbackField.setDisabled(true);
			minta_biayaField.setDisabled(true);
			minta_bayarField.setDisabled(true);
			minta_keteranganField.setDisabled(true);
			minta_status_accField.setDisabled(true);
			minta_statusField.setDisabled(true);
			combo_minta_produk.setDisabled(true);
			combo_minta_satuan.setDisabled(true);
			minta_jumlah_barangField.setDisabled(true);
			master_minta_beli_createForm.printOnlyButton.enable();	
			master_minta_beli_createForm.saveHargaButton.enable();	
			master_minta_beli_createForm.obeli_savePrint.disable();
			minta_button_saveandprintField.setDisabled(true);
			detail_minta_beli_ListEditorGrid.setDisabled(true);
		}


		minta_statusField.on("select",function(){
		var status_awal = master_minta_beli_ListEditorGrid.getSelectionModel().getSelected().get('minta_status');
		if(status_awal =='Terbuka' && minta_statusField.getValue()=='Tertutup')
		{
		Ext.MessageBox.show({
			msg: 'Dokumen tidak bisa ditutup. Gunakan Save & Print untuk menutup dokumen',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		minta_statusField.setValue('Terbuka');
		}

		else if(status_awal =='Tertutup' && minta_statusField.getValue()=='Terbuka')
		{
		Ext.MessageBox.show({
			msg: 'Status yang sudah Tertutup tidak dapat diganti Terbuka',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		minta_statusField.setValue('Tertutup');
		}

		else if(status_awal =='Batal' && minta_statusField.getValue()=='Terbuka')
		{
		Ext.MessageBox.show({
			msg: 'Status yang sudah Tertutup tidak dapat diganti Terbuka',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		minta_statusField.setValue('Tertutup');
		}

		else if(minta_statusField.getValue()=='Batal')
		{
		Ext.MessageBox.confirm('Confirmation','Anda yakin untuk membatalkan dokumen ini? Pembatalan dokumen tidak bisa dikembalikan lagi', minta_status_batal);
		}

       else if(status_awal =='Tertutup' && minta_statusField.getValue()=='Tertutup'){
            <?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_ORDER'))){ ?>
			master_minta_beli_createForm.obeli_savePrint.enable();
			<?php } ?>
        }

		});

	}
	/* End setValue to EDIT*/

	function minta_status_batal(btn){
		if(btn=='yes')
		{
			minta_statusField.setValue('Batal');
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_ORDER'))){ ?>
			master_minta_beli_createForm.obeli_savePrint.disable();
			<?php } ?>
		}
		else
			minta_statusField.setValue(master_minta_beli_ListEditorGrid.getSelectionModel().getSelected().get('minta_status'));
	}


	/* Function for Check if the form is valid */
	function is_master_minta_beli_form_valid(){
		return true;
	}
  	/* End of Function */

  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!master_minta_beli_createWindow.isVisible()){
			mintabeli_post2db='CREATE';
			msg='created';
			master_minta_beli_reset_form();
			master_minta_beli_createWindow.show();
		} else {
			master_minta_beli_createWindow.toFront();
		}
	}
  	/* End of Function */

  	/* Function for Delete Confirm */
	function master_minta_beli_confirm_delete(){
		// only one master_order_beli is selected here
		if(master_minta_beli_ListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', master_minta_beli_delete);
		} else if(master_minta_beli_ListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', master_minta_beli_delete);
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

  	function check_acc(){
		if(minta_acc_group==9 || minta_acc_group==1 || minta_acc_group==29 || minta_acc_group==45 ){
			minta_harga_satuanField.setDisabled(false);
			minta_diskon_satuanField.setDisabled(false);
		}else{
			minta_harga_satuanField.setDisabled(true);
			minta_diskon_satuanField.setDisabled(true);
		}
	}

	function minta_print_only(){
		if(minta_idField.getValue()==''){
			Ext.MessageBox.show({
			msg: 'Faktur OP tidak dapat dicetak, karena data kosong',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		}
		else{
			var minta_id = minta_idField.getValue();
			cetak_minta=1;
			//master_minta_beli_create('print');
			master_minta_beli_cetak_faktur(minta_id);
			master_minta_beli_DataStore.reload()
			
			Ext.MessageBox.show({
				title: 'INFO',
				msg: 'Data berhasil di cetak kembali',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.INFO
			});
			master_minta_beli_createWindow.hide();
		}
	}

	/* Function for Update Confirm */
	function master_minta_beli_confirm_update(){
		/* only one record is selected here */
		if(master_minta_beli_ListEditorGrid.selModel.getCount() == 1) {
			mintabeli_post2db='UPDATE';
			msg='updated';
			master_minta_beli_set_form();
			master_minta_beli_createWindow.show();

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
	function master_minta_beli_delete(btn){
		if(btn=='yes'){
			var selections = master_minta_beli_ListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< master_minta_beli_ListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.minta_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({
				waitMsg: 'Mohon tunggu',
				url: 'index.php?c=c_master_minta_beli&m=get_action',
				params: { task: "DELETE", ids:  encoded_array },
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							master_minta_beli_DataStore.reload();
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
	master_minta_beli_DataStore = new Ext.data.Store({
		id: 'master_minta_beli_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_minta_beli&m=get_action',
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit: pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'minta_id'
		},[
			{name: 'minta_id', type: 'int', mapping: 'minta_id'},
			{name: 'minta_no', type: 'string', mapping: 'minta_no'},
			{name: 'minta_supplier', type: 'string', mapping: 'supplier_nama'},
			{name: 'minta_gudang_nama', type: 'string', mapping: 'gudang_nama'},
			{name: 'minta_jenis', type: 'string', mapping: 'minta_jenis'},
			{name: 'minta_supplier_id', type: 'int', mapping: 'supplier_id'},
			{name: 'minta_gudang_id', type: 'int', mapping: 'gudang_id'},
			{name: 'minta_tanggal', type: 'date', dateFormat: 'Y-m-d', mapping: 'minta_tanggal'},
			{name: 'order_carabayar', type: 'string', mapping: 'order_carabayar'},
			{name: 'order_diskon', type: 'float', mapping: 'order_diskon'},
			{name: 'order_cashback', type: 'float', mapping: 'order_cashback'},
			{name: 'order_biaya', type: 'float', mapping: 'order_biaya'},
			{name: 'order_jumlah', type: 'float', mapping: 'jumlah_barang'},
			{name: 'order_total', type: 'float', mapping: 'total_nilai'},
			{name: 'order_bayar', type: 'float', mapping: 'order_bayar'},
			{name: 'minta_keterangan', type: 'string', mapping: 'minta_keterangan'},
			{name: 'minta_status', type: 'string', mapping: 'minta_status'},
			{name: 'minta_status_acc', type: 'string', mapping: 'minta_status_acc'},
			{name: 'minta_creator', type: 'string', mapping: 'minta_creator'},
			{name: 'order_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'order_date_create'},
			{name: 'order_update', type: 'string', mapping: 'order_update'},
			{name: 'order_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'order_date_update'},
			{name: 'order_revised', type: 'int', mapping: 'order_revised'}
		]),
		sortInfo:{field: 'minta_id', direction: "DESC"}
	});
	/* End of Function */

	/* Function for Retrieve permission DataStore */
	permission_op_DataStore = new Ext.data.Store({
		id: 'permission_op_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_minta_beli&m=get_permission_op',
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
	var cbo_minta_produk_DataStore = new Ext.data.Store({
		id: 'cbo_minta_produk_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_minta_beli&m=get_produk_list',
			method: 'POST'
		}),
		baseParams:{task: "detail",start:0,limit:pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'order_produk_value'
		},[
			{name: 'order_produk_value', type: 'int', mapping: 'produk_id'},
			{name: 'order_produk_nama', type: 'string', mapping: 'produk_nama'},
			{name: 'order_produk_kode', type: 'string', mapping: 'produk_kode'},
			{name: 'order_produk_kategori', type: 'string', mapping: 'kategori_nama'},
			{name: 'order_produk_satuan', type: 'string', mapping: 'satuan_id'},
			{name: 'dminta_harga', type: 'float', mapping: 'dminta_harga'},
			{name: 'dminta_harga_log', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'dminta_harga_log'}
		]),
		sortInfo:{field: 'order_produk_nama', direction: "ASC"}
	});

	/* Function for Retrieve Supplier DataStore */
	cbo_minta_supplier_DataStore = new Ext.data.Store({
		id: 'cbo_minta_supplier_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_minta_beli&m=get_supplier_list',
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit:10}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'minta_supplier_value'
		},[
			{name: 'minta_supplier_value', type: 'int', mapping: 'supplier_id'},
			{name: 'minta_supplier_nama', type: 'string', mapping: 'supplier_nama'},
			{name: 'minta_supplier_alamat', type: 'string',  mapping: 'supplier_alamat'},
			{name: 'minta_supplier_kota', type: 'string', mapping: 'supplier_kota'},
			{name: 'minta_supplier_notelp', type: 'string', mapping: 'supplier_notelp'}
		]),
		sortInfo:{field: 'minta_supplier_nama', direction: "ASC"}
	});

	// Custom rendering Template
    var minta_supplier_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{minta_supplier_nama}</b><br /></span>',
//            'Alamat: {minta_supplier_alamat}, {minta_supplier_kota}<br>Telp. {minta_supplier_notelp}',
            '{minta_supplier_alamat}, {minta_supplier_kota}',
        '</div></tpl>'
    );

    // Data Store Minta Gudang
    cbo_minta_gudang_DataStore = new Ext.data.Store({
		id: 'cbo_minta_gudang_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_minta_beli&m=get_gudang_list', 
			method: 'POST'
		}),
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'gudang_id'
		},[
			{name: 'terima_gudang_display', type: 'string', mapping: 'gudang_nama'},
			{name: 'terima_gudang_value', type: 'int', mapping: 'gudang_id'},
			{name: 'terima_gudang_lokasi', type: 'string', mapping: 'gudang_lokasi'},
			{name: 'terima_gudang_keterangan', type: 'string', mapping: 'gudang_keterangan'},
		]),
		sortInfo:{field: 'terima_gudang_value', direction: "ASC"}
	});

	var minta_gudangbeli_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{terima_gudang_display}</b><br /></span>',
            'Lokasi: {terima_gudang_lokasi}<br>',
        '</div></tpl>'
    );

	var minta_produk_detail_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{order_produk_nama} ({order_produk_kode})</b><br /></span>',
            'Kategori: {order_produk_kategori}',
        '</div></tpl>'
    );

  	/* Function for Identify of Window Column Model */
	master_minta_beli_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: '<div align="center">' + 'Tanggal' + '</div>',
			dataIndex: 'minta_tanggal',
			width: 80,	//150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			readOnly: true
		},
		{
			//header: '<div align="center">' + 'No Order' + '</div>',
			header: '<div align="center">' + 'No PP' + '</div>',
			dataIndex: 'minta_no',
			width: 80,	//150,
			sortable: true,
			readOnly: true
		},
		
		{
			header: '<div align="center">' + 'Gudang' + '</div>',
			dataIndex: 'minta_gudang_nama',
			width: 200,	//150,
			sortable: true,
			readOnly: true
		},

		{
			header: '<div align="center">' + 'Jenis' + '</div>',
			dataIndex: 'minta_jenis',
			width: 200,	//150,
			sortable: true,
			readOnly: true
		},
		
		{
			header: 'Creator',
			dataIndex: 'minta_creator',
			width: 150,
			sortable: true,
			// hidden: true,
			readOnly: true
		},
		/*
		{
			header: '<div align="center">' + 'Jml Item' + '</div>',
			align: 'right',
			dataIndex: 'order_jumlah',
			width: 60,	//150,
			sortable: true,
			readOnly: true,
			renderer: Ext.util.Format.numberRenderer('0,000')
		},
		*/
		/*
		<? if(($_SESSION[SESSION_GROUPID]==9) || ($_SESSION[SESSION_GROUPID]==1)){ ?>
		{
			header: '<div align="center">' + 'Sub Total (Rp)' + '</div>',
			align: 'right',
			dataIndex: 'order_total',
			width: 100,	//150,
			sortable: true,
			readOnly: true,
			renderer: function(val){
				return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
			}
		},
		{
			header: '<div align="center">' + 'Disk (%)' + '</div>',
			align: 'right',
			dataIndex: 'order_diskon',
			width: 60,	//150,
			sortable: true,
			renderer: function(val){
				return '<span>'+val+'</span>';
			},
			readOnly: true
		},
		{
			header: '<div align="center">' + 'Disk (Rp)' + '</div>',
			align: 'right',
			width: 100,	//150,
			dataIndex: 'order_cashback',
			sortable: true,
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true
		},
		{
			header: '<div align="center">' + 'Biaya (Rp)' + '</div>',
			align: 'right',
			dataIndex: 'order_biaya',
			width: 100,	//150,
			sortable: true,
			renderer: function(val){
				return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
			},
			readOnly: true
		},
		{
			header: '<div align="center">' + 'Total Nilai (Rp)' + '</div>',
			align: 'right',
			width: 100,	//150,
			//sortable: true,
			readOnly: true,
			renderer: function(v, params, record){
					order_total_nilai=Ext.util.Format.number((record.data.order_total-(record.data.order_diskon*record.data.order_total/100)+record.data.order_biaya-record.data.order_cashback),"0,000");
                    return '<span>' + order_total_nilai+ '</span>';
            }
		},
		<? } ?>

		{
			header: '<div align="center">' + 'Cara Bayar' + '</div>',
			dataIndex: 'order_carabayar',
			width: 80,	//150,
			sortable: true,
			readOnly: true
		},
		*/
		{
			header: '<div align="center">' + 'Keterangan' + '</div>',
			dataIndex: 'minta_keterangan',
			width: 150,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
		},
		{
			header: '<div align="center">' + 'Stat Dok' + '</div>',
			dataIndex: 'minta_status',
			width: 60
		},

		{
			header: '<div align="center">' + 'Stat Acc' + '</div>',
			dataIndex: 'minta_status_acc',
			hidden : true,
			width: 60
		},
		
		{
			header: 'Create on',
			dataIndex: 'order_date_create',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		},
		{
			header: 'Last Update by',
			dataIndex: 'order_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		},
		{
			header: 'Last Update on',
			dataIndex: 'order_date_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		},
		{
			header: 'Revised',
			dataIndex: 'order_revised',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}	]);

	//master_minta_beli_ColumnModel.defaultSortable= true;
	/* End of Function */
    var master_minta_paging_toolbar=new Ext.PagingToolbar({
			pageSize: pageS,
			store: master_minta_beli_DataStore,
			displayInfo: true
		});
	/* Declare DataStore and  show datagrid list */
	master_minta_beli_ListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'master_minta_beli_ListEditorGrid',
		el: 'fp_master_minta_beli',
		title: 'Daftar Permintaan Pembelian',
		autoHeight: true,
		store: master_minta_beli_DataStore, // DataStore
		cm: master_minta_beli_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1200,	//900,
		bbar: master_minta_paging_toolbar,
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_ORDER'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<?php } ?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_ORDER'))){ ?>
		{
			text: 'Open/Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: master_minta_beli_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_ORDER'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: master_minta_beli_confirm_delete   // Confirm before deleting
		}, '-',
		<?php } ?>
		{
			text: 'Adv Search',
			tooltip: 'Pencarian detail',
			iconCls:'icon-search',
			handler: display_form_search_window
		}, '-',
			new Ext.app.SearchField({
			store: master_minta_beli_DataStore,
			params: {start: 0, limit: pageS},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						master_minta_beli_DataStore.baseParams={task:'LIST',start: 0, limit: pageS};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Search By (aktif only)'});
				Ext.get(this.id).set({qtip:'- No PP<br>- <br>-'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: master_minta_beli_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: master_minta_beli_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: master_minta_beli_print
		}
		]
	});
	master_minta_beli_ListEditorGrid.render();
	/* End of DataStore */

	/* Create Context Menu */
	master_minta_beli_ContextMenu = new Ext.menu.Menu({
		id: 'master_minta_beli_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_ORDER'))){ ?>
		{
			text: 'Edit', tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: master_minta_beli_confirm_update
		},
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_ORDER'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: master_minta_beli_confirm_delete
		},
		<?php } ?>
		'-',
		{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: master_minta_beli_print
		},
		{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: master_minta_beli_export_excel
		}
		]
	});
	/* End of Declaration */

	/* Event while selected row via context menu */
	function onmaster_minta_beli_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		master_minta_beli_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		master_minta_beli_SelectedRow=rowIndex;
		master_minta_beli_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */

	/* function for editing row via context menu */
	function master_minta_beli_editContextMenu(){
		master_minta_beli_ListEditorGrid.startEditing(master_minta_beli_SelectedRow,1);
  	}
	/* End of Function */

	/* Identify  supplier id*/
	minta_supplier_idField= new Ext.form.NumberField();
	
	/* Identify  minta_id Field */
	minta_idField= new Ext.form.NumberField({
		id: 'minta_idField',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: false,
		hidden: true,
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});

	/* Identify  minta_no Field */
	minta_noField= new Ext.form.TextField({
		id: 'minta_noField',
		fieldLabel: 'No PP',
		emptyText: '(Auto)',
		readOnly: true,
		maxLength: 50,
		anchor: '95%'
	});
	
	/* Identify  minta_supplier Field */
	minta_supplierField= new Ext.form.ComboBox({
		id: 'minta_supplierField',
		fieldLabel: 'Supplier <span style="color: #ec0000">*</span>',
		store: cbo_minta_supplier_DataStore,
		displayField:'minta_supplier_nama',
		mode : 'remote',
		valueField: 'minta_supplier_value',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
		allowBlank: false,
        tpl: minta_supplier_tpl,
		forceSelection: true,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});

	//Minta Gudang Field
	minta_gudangField= new Ext.form.ComboBox({
		id: 'minta_gudangField',
		fieldLabel: 'Gudang',
		index : 4,
		store:cbo_minta_gudang_DataStore,
		mode: 'remote',
		displayField: 'terima_gudang_display',
		valueField: 'terima_gudang_value',
		typeAhead: false,
        hideTrigger:false,
		tpl: minta_gudangbeli_tpl,
		//blankText : 'GUDANG BESAR (CABIN)',
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});

	//Declare field minta_gudang_idField
	minta_gudang_idField= new Ext.form.TextField();

	var dt = new Date();
	/* Identify  minta_tanggal Field */
	minta_tanggalField= new Ext.form.DateField({
		id: 'minta_tanggalField',
		name: 'minta_tanggalField',
		fieldLabel: 'Tanggal',
		//emptyText : dt.format('d-m-Y'),
		format : 'd-m-Y'
	});
	/* Identify  order_carabayar Field */
	minta_carabayarField= new Ext.form.ComboBox({
		id: 'minta_carabayarField',
		fieldLabel: 'Cara Bayar',
		forceSelection: true,
		store:new Ext.data.SimpleStore({
			fields:['order_carabayar_value', 'order_carabayar_display'],
			data:[['Tunai','Tunai'],['Kredit','Kredit'],['Konsinyasi','Konsinyasi']]
		}),
		mode: 'local',
		displayField: 'order_carabayar_display',
		valueField: 'order_carabayar_value',
		anchor: '80%',
		allowBlank: false,
		triggerAction: 'all'
	});

	minta_jenisField= new Ext.form.ComboBox({
		id: 'minta_jenisField',
		fieldLabel: 'Jenis',
		forceSelection: true,
		store:new Ext.data.SimpleStore({
			fields:['minta_jenis_value', 'minta_jenis_display'],
			data:[['PO','Pembelian PO'],['Pasar','Pembelian Pasar']]
		}),
		mode: 'local',
		displayField: 'minta_jenis_display',
		valueField: 'minta_jenis_value',
		anchor: '60%',
		allowBlank: false,
		triggerAction: 'all'
	});

	minta_statusField= new Ext.form.ComboBox({
		id: 'minta_statusField',
		fieldLabel: 'Status Dok',
		forceSelection: true,
		store:new Ext.data.SimpleStore({
			fields:['minta_status_value', 'minta_status_display'],
			data:[['Terbuka','Terbuka'],['Tertutup','Tertutup'],['Batal', 'Batal']]
		}),
		mode: 'local',
		displayField: 'minta_status_display',
		valueField: 'minta_status_value',
		anchor: '60%',
		allowBlank: false,
		triggerAction: 'all'
	});

	minta_status_accField= new Ext.form.ComboBox({
		id: 'minta_status_accField',
		fieldLabel: 'Status Acc',
		forceSelection: true,
		store:new Ext.data.SimpleStore({
			fields:['minta_status_acc_value', 'minta_status_acc_display'],
			data:[['Terbuka','Terbuka'],['Tertutup','Tertutup']]
		}),
		mode: 'local',
		displayField: 'minta_status_acc_display',
		valueField: 'minta_status_acc_value',
		anchor: '60%',
		allowBlank: false,
		triggerAction: 'all'
	});

	/* Identify  order_diskon Field */
	minta_diskonField= new Ext.form.TextField({
		id: 'minta_diskonField',
		fieldLabel: 'Diskon (%)',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		enableKeyEvents: true,
		anchor: '50%',
		maxLength: 2,
		maskRe: /([0-9]+)$/
	});
	

	/* Identify  order_diskon Field */
	minta_group_id_temp= new Ext.form.TextField({
		id: 'minta_group_id_temp',
		anchor: '50%',
		maxLength: 5
	});

	minta_cashbackField= new Ext.form.TextField({
		id: 'minta_cashbackField',
		fieldLabel: 'Diskon (Rp)',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		enableKeyEvents: true,
		anchor: '50%',
		maxLength: 10,
		maskRe: /([0-9]+)$/
	});

	/* Identify  minta_biaya Field */
	minta_biayaField= new Ext.form.TextField({
		id: 'minta_biayaField',
		fieldLabel: 'Biaya (Rp)',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		enableKeyEvents: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});

	/* START Field master_minta_beli_bayarGroup */
	minta_subtotalField= new Ext.form.TextField({
		id: 'minta_subtotalField',
		fieldLabel: 'Sub Total (Rp)',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});

	/* Identify  order_bayar Field */
	minta_totalField= new Ext.form.TextField({
		id: 'minta_totalField',
		fieldLabel: '<span><b>Total (Rp)</b></span>',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		readOnly: true,
		anchor: '95%'
	});

	/* Identify  order_bayar Field */
	minta_jumlahField= new Ext.form.TextField({
		id: 'minta_jumlahField',
		fieldLabel: 'Jumlah Total Barang',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		readOnly: true,
		anchor: '95%'
	});

	/* Identify  order_bayar Field */
	minta_itemField= new Ext.form.TextField({
		id: 'minta_itemField',
		fieldLabel: 'Jumlah Jenis Barang',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		readOnly: true,
		anchor: '95%'
	});

	minta_bayarField= new Ext.form.TextField({
		id: 'minta_bayarField',
		fieldLabel: 'Uang Muka (Rp)',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		anchor: '95%',
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});

	minta_totalbayarField= new Ext.form.TextField({
		id: 'minta_totalbayarField',
		fieldLabel: 'Total Bayar (Rp)',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		readOnly: true,
		anchor: '95%'
	});
	/* END Field master_minta_beli_bayarGroup */

	/* Identify  minta_keterangan Field */
	minta_keteranganField= new Ext.form.TextArea({
		id: 'minta_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 500,
		anchor: '95%'
	});
  	/*Fieldset Master*/

	//untuk menampung nilai button save harga
	var minta_save_hargaField= new Ext.form.TextArea({
		id: 'message_infoField',
		maxLength: 5,
		anchor: '95%'
	});
	
	minta_button_saveField=new Ext.Button({
		text: 'Save',
		handler: pengecekan_dokumen2
	});

	minta_button_saveandprintField=new Ext.Button({
		text: 'Save and Print',
		ref: '../obeli_savePrint',
		handler: pengecekan_dokumen
	});

	master_minta_beli_masterGroup = new Ext.form.FieldSet({
		// title: 'Master',
		autoHeight: true,
		// collapsible: true,
		layout:'column',
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [minta_noField, /*minta_supplierField,*/ minta_tanggalField, minta_gudangField, minta_jenisField /*, minta_carabayarField*/]
			},
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [minta_keteranganField, minta_statusField, minta_idField]
			}
			]

	});
	//master_order_beli_FootGroup
	master_minta_beli_bayarGroup = new Ext.form.FieldSet({
		// title: '-',
		autoHeight: true,
		// collapsible: true,
		layout:'column',
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				labelAlign: 'left',
				border:false,
				labelWidth: 120,
				items: [minta_jumlahField, minta_itemField <?php if(($_SESSION[SESSION_GROUPID]==9) || ($_SESSION[SESSION_GROUPID]==1)){ ?>, minta_totalField <?php } ?>]
			},{
				columnWidth:0.5,
				layout: 'form',
				labelAlign: 'left',
				border:false
				<?php if(($_SESSION[SESSION_GROUPID]==9) || ($_SESSION[SESSION_GROUPID]==1)){ ?>
				,
				items: [minta_diskonField, minta_cashbackField, minta_biayaField,minta_bayarField, minta_totalbayarField]
				<?php } ?>
			}
			]

	});

	// Function for json reader of detail
	var detail_minta_beli_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: 'dminta_id'
	},[
			{name: 'dminta_id', type: 'int', mapping: 'dminta_id'},
			{name: 'dminta_master', type: 'int', mapping: 'dminta_master'},
			{name: 'dminta_produk', type: 'int', mapping: 'dminta_produk'},
			{name: 'produk_nama', type: 'string', mapping: 'produk_nama'},
			{name: 'produk_kode', type: 'string', mapping: 'produk_kode'},
			{name: 'dminta_keterangan', type: 'string', mapping: 'dminta_keterangan'},
			{name: 'dorder_terima', type: 'float', mapping: 'jumlah_terima'},
			{name: 'dminta_satuan', type: 'int', mapping: 'dminta_satuan'},
			{name: 'dminta_jumlah', type: 'int', mapping: 'dminta_jumlah'},
			{name: 'dminta_harga', type: 'float', mapping: 'harga_satuan'},
			{name: 'dminta_diskon', type: 'float', mapping: 'diskon'},
			{name: 'dorder_subtotal', type: 'float', mapping: 'dorder_subtotal'},
			{name: 'dminta_harga_log', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'dminta_harga_log'}
	]);
	//eof

	//function for json writer of detail
	var detail_minta_beli_writer = new Ext.data.JsonWriter({
		encode: true,
		writeAllFields: false
	});
	//eof

	/* Function for Retrieve DataStore of detail*/
	detail_minta_beli_DataStore = new Ext.data.Store({
		id: 'detail_minta_beli_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_minta_beli&m=detail_detail_minta_beli_list',
			method: 'POST'
		}),
		reader: detail_minta_beli_reader,
		baseParams:{start:0, limit:pageS, task: 'detail'},
		sortInfo:{field: 'dminta_id', direction: 'DESC'}
	});
	/* End of Function */

	//function for editor of detail
	var editor_detail_minta_beli= new Ext.ux.grid.RowEditor({
        saveText: 'Update'
    });
	//eof

	cbo_minta_satuanDataStore = new Ext.data.Store({
		id: 'cbo_minta_satuanDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_minta_beli&m=get_satuan_list',
			method: 'POST'
		}),
		baseParams:{start:0,limit:pageS,task:'detail'},
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'order_satuan_value'
		},[
			{name: 'order_satuan_value', type: 'int', mapping: 'satuan_id'},
			{name: 'order_satuan_kode', type: 'string', mapping: 'satuan_kode'},
			{name: 'order_satuan_display', type: 'string', mapping: 'satuan_nama'},
			{name: 'order_satuan_default', type: 'string', mapping: 'konversi_default'},
		]),
		sortInfo:{field: 'order_satuan_display', direction: "ASC"}
	});
	
	
	cbo_dminta_produk_hargaDataStore = new Ext.data.Store({
		id: 'cbo_dminta_produk_hargaDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_minta_beli&m=get_pp_last_price', 
			method: 'POST'
		}),baseParams: {start: 0, limit: 5},
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'produk_id'
		},[
			{name: 'produk_id', type: 'int', mapping: 'produk_id'},
			{name: 'dminta_produk', type: 'int', mapping: 'dminta_produk'},
			{name: 'dminta_harga', type: 'float', mapping: 'dminta_harga'},
			{name: 'produk_kode', type: 'string', mapping: 'produk_kode'}
		]),
		sortInfo:{field: 'produk_id', direction: "DESC"}
	});
	
	Ext.util.Format.comboRenderer = function(combo){
		return function(value){
			var record = combo.findRecord(combo.valueField, value);
			return record ? record.get(combo.displayField) : combo.valueNotFoundText;
		}
	}
	
	var combo_minta_produk=new Ext.form.ComboBox({
		store: cbo_minta_produk_DataStore,
		mode: 'remote',
		typeAhead: false,
		displayField: 'order_produk_nama',
		valueField: 'order_produk_value',
		triggerAction: 'all',
		lazyRender: false,
		pageSize: pageS,
		enableKeyEvents: true,
		tpl: minta_produk_detail_tpl,
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});

	var combo_minta_satuan=new Ext.form.ComboBox({
		store: cbo_minta_satuanDataStore,
		mode: 'remote',
		typeAhead: true,
		displayField: 'order_satuan_display',
		valueField: 'order_satuan_value',
		triggerAction: 'all',
		lazyRender:true
	});

	var minta_jumlah_barangField = new Ext.form.NumberField({
		id : 'minta_jumlah_barangField',
		name : 'minta_jumlah_barangField',
		allowDecimals: false,
		allowNegative: false,
		blankText : '0',
		maxLength: 11,
		enableKeyEvents: true,
		readOnly : false,
		maskRe: /([0-9]+)$/

	});

	var dminta_ketField= new Ext.form.TextField({
		id: 'dminta_ketField',
		readOnly: false,
		maxLength: 250
	});

	var dminta_kodeprodukField= new Ext.form.TextField({
		id: 'dminta_kodeprodukField',
		readOnly: true,
		disabled : true,
		enableKeyEvents : true,	
		maxLength: 250
	});
	
	var minta_harga_satuanField=new Ext.form.NumberField({
		allowDecimals: true,
		allowNegative: false,
		//blankText: '0',
		maxLength: 22,
		maskRe: /([0-9]+)$/
	});

	var minta_diskon_satuanField=new Ext.form.NumberField({
		allowDecimals: true,
		allowNegative: false,
		blankText: '0',
		maxLength: 22,
		maskRe: /([0-9]+)$/
	});

	//declaration of detail coloumn model
	detail_minta_beli_ColumnModel = new Ext.grid.ColumnModel(
		[ {
			header: '<div align="center">' + 'ID' + '</div>',
			dataIndex: 'dminta_id',
			width: 30,	//250,
			sortable: true,
			hidden: true
		},
		 {
			header: '<div align="center">' + 'Produk' + '</div>',
			dataIndex: 'dminta_produk',
			width: 260,	//250,
			sortable: true,
			editor: combo_minta_produk,
			renderer: Ext.util.Format.comboRenderer(combo_minta_produk)
		},
		{
			header: '<div align="center">' + 'Kode' + '</div>',
			dataIndex: 'produk_kode',
			width: 60,	//250,
			sortable: true,
			editor : dminta_kodeprodukField
			// hidden: true
		},
		{
			header: '<div align="center">' + 'Satuan' + '</div>',
			dataIndex: 'dminta_satuan',
			width: 80,	//150,
			editor: combo_minta_satuan,
			renderer: Ext.util.Format.comboRenderer(combo_minta_satuan)
		},
		{
			header: '<div align="center">' + 'Jumlah' + '</div>',
			align: 'right',
			dataIndex: 'dminta_jumlah',
			width: 60,	//100,
			sortable: true,
			renderer: Ext.util.Format.numberRenderer('0,000'),
			editor: minta_jumlah_barangField
		},
		{
			header: '<div align="center">' + 'Keterangan' + '</div>',
			align: 'right',
			dataIndex: 'dminta_keterangan',
			width: 200,
			sortable: true,
			editor: dminta_ketField
		},
		/*
		{
			header: '<div align="center">' + 'Harga (Rp)' + '</div>',
			align: 'right',
			dataIndex: 'dminta_harga',
			width: 100,	//150,
			sortable: true,
			editor:  minta_harga_satuanField,
		
			renderer: function(val){
				harga = val;
				//if (minta_save_hargaField.getValue()=='1'){
					return '<span> '+Ext.util.Format.number(harga,'0,000')+'</span>';
				//}else{
				//	return '<span>'+'NA'+'</span>';
				//}
			}

		},
	*/
	/*
		{
			header: '<div align="center">' + 'Sub Total (Rp)' + '</div>',
			align: 'right',
			dataIndex: 'dorder_subtotal',
			width: 100,	//150,
			sortable: true,
			readOnly: true,
			
			renderer: function(v, params, record){
				subtotal=Ext.util.Format.number((record.data.dminta_harga * record.data.dminta_jumlah*(100-record.data.dminta_diskon)/100),"0,000");
				
				//if (minta_save_hargaField.getValue()=='1'){
					return '<span> '+subtotal+'</span>';
				//}else{
				//	return '<span>'+'NA'+'</span>';
				//}
			}
			
		},
		{
			header: '<div align="center">Jml Terima</div>',
			align: 'right',
			dataIndex: 'dorder_terima',
			width: 60,
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">' + 'Disk (%)' + '</div>',
			align: 'right',
			dataIndex: 'dminta_diskon',
			width: 60,	//100,
			renderer: Ext.util.Format.numberRenderer('0,000'),
			sortable: true,
			editor: minta_diskon_satuanField
		},
		*/
		/*
		{
			header: '<div align="center">' + 'Last Modified' + '</div>',
			align: 'right',
			dataIndex: 'dminta_harga_log',
			width: 100,	//150,
			sortable: true,
			readOnly : true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y H:i:s')
		}
		*/
		]
	);
	detail_minta_beli_ColumnModel.defaultSortable= true;
	//eof
	var detail_minta_bAdd=new Ext.Button({
		text: 'Add',
		tooltip: 'Add new detail record',
		iconCls:'icon-adds',    				// this is defined in our styles.css
		handler: detail_minta_beli_add
	});
	//declaration of detail list editor grid
	detail_minta_beli_ListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'detail_minta_beli_ListEditorGrid',
		el: 'fp_detail_minta_beli',
		title: 'Detail Item',
		height: 350,
		width: 920,	//690,
		autoScroll: false,
		store: detail_minta_beli_DataStore, // DataStore
		colModel: detail_minta_beli_ColumnModel, // Nama-nama Columns
		enableColLock:true,
		region: 'center',
        margins: '0 5 5 5',
		plugins: [editor_detail_minta_beli],
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true}
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_ORDER'))){ ?>
		,
		tbar: [detail_minta_bAdd
		, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			handler: detail_minta_beli_confirm_delete
		},
		'-',
		'<span style="color:white;">Info: <b>Pilih Gudang dahulu utk mengaktifkan list detail item yang ingin diinput</b></span>'
		]
		<?php } ?>
	});
	//eof

	//function of detail add
	function detail_minta_beli_add(){
		var edit_detail_order_beli= new detail_minta_beli_ListEditorGrid.store.recordType({
			dminta_id		:0,
			dminta_master	:'',
			dminta_produk	:'',
			dminta_satuan	:'',
			dminta_jumlah	:0,
			dminta_harga	:0,
			dminta_diskon	:0
		});
		editor_detail_minta_beli.stopEditing();
		detail_minta_beli_DataStore.insert(0, edit_detail_order_beli);
		//detail_minta_beli_ListEditorGrid.getView().refresh();
		detail_minta_beli_ListEditorGrid.getSelectionModel().selectRow(0);
		editor_detail_minta_beli.startEditing(0);
	}

	//function for refresh detail
	function refresh_detail_minta_beli(){
		detail_minta_beli_DataStore.commitChanges();
		detail_minta_beli_ListEditorGrid.getView().refresh();
	}
	//eof


	//function for insert detail
	function detail_minta_save_harga_insert(){
		var dminta_id = [];
        var dminta_produk = [];
        var dminta_satuan = [];
        var dminta_jumlah = [];
        var dminta_harga = [];
        var dminta_diskon = [];

		var dcount = detail_minta_beli_DataStore.getCount() - 1;
		
		if(detail_minta_beli_DataStore.getCount()>0){
			 for(i=0; i<detail_minta_beli_DataStore.getCount();i++){
                if((/^\d+$/.test(detail_minta_beli_DataStore.getAt(i).data.dminta_produk))
				   && detail_minta_beli_DataStore.getAt(i).data.dminta_produk!==undefined
				   && detail_minta_beli_DataStore.getAt(i).data.dminta_produk!==''
				   && detail_minta_beli_DataStore.getAt(i).data.dminta_produk!==0
				   && detail_minta_beli_DataStore.getAt(i).data.dminta_satuan!==''
				   && detail_minta_beli_DataStore.getAt(i).data.dminta_jumlah>0){

                  	dminta_id.push(detail_minta_beli_DataStore.getAt(i).data.dminta_id);
					dminta_produk.push(detail_minta_beli_DataStore.getAt(i).data.dminta_produk);
                   	dminta_satuan.push(detail_minta_beli_DataStore.getAt(i).data.dminta_satuan);
					dminta_jumlah.push(detail_minta_beli_DataStore.getAt(i).data.dminta_jumlah);
					dminta_harga.push(detail_minta_beli_DataStore.getAt(i).data.dminta_harga);
					dminta_diskon.push(detail_minta_beli_DataStore.getAt(i).data.dminta_diskon);
                }
            }


					var encoded_array_dminta_id = Ext.encode(dminta_id);
					var encoded_array_dminta_produk = Ext.encode(dminta_produk);
					var encoded_array_dminta_harga = Ext.encode(dminta_harga);

					Ext.Ajax.request({
						waitMsg: 'Mohon  Tunggu...',
						url: 'index.php?c=c_master_minta_beli&m=detail_minta_save_harga_insert',
						params:{
							dminta_id		: encoded_array_dminta_id,
							dminta_produk 	: encoded_array_dminta_produk,
							dminta_harga	: encoded_array_dminta_harga
						},
						timeout: 60000,
						success: function(response){
							var result=eval(response.responseText);
						switch(result){
						case 1 :
							master_minta_beli_createWindow.hide();
							Ext.MessageBox.show({
							   title: 'INFO',
							   msg: 'Save Harga telah diupdate.',
							   buttons: Ext.MessageBox.OK,
							   animEl: 'save',
							   icon: Ext.MessageBox.INFO
							});
							master_minta_beli_DataStore.reload();
							break;
						default :
							Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Save Harga tidak dapat dilakukan',
						   buttons: Ext.MessageBox.OK,
						   animEl: 'save',
						   icon: Ext.MessageBox.WARNING
						});
						}
							//jpaket_btn_cancel();
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
							//jpaket_btn_cancel();
						}
					});


		}

	}
	//eof

	/* Function for Delete Confirm of detail */
	function detail_minta_beli_confirm_delete(){
		// only one record is selected here
		if(detail_minta_beli_ListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', detail_minta_beli_delete);
		} else if(detail_minta_beli_ListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', detail_minta_beli_delete);
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
	function detail_minta_beli_delete(btn){
		if(btn=='yes'){
			var s = detail_minta_beli_ListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, r; r = s[i]; i++){
				//s[i].dminta_id=0;
				detail_minta_beli_DataStore.remove(r);
				detail_minta_beli_DataStore.commitChanges();
				detail_minta_beli_total();
			}
		}
	}
	//eof


	/* Function for retrieve create Window Panel*/
	master_minta_beli_createForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 700,
		monitorValid: true,
		items: [master_minta_beli_masterGroup,detail_minta_beli_ListEditorGrid /*,master_minta_beli_bayarGroup*/],
		buttons: [
			{
				text: 'Print Only',
				ref:'../printOnlyButton',
				handler: minta_print_only
			},
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_ORDER'))){ ?>

			{
				//id: 'op_save_harga',
				text: 'Save Harga',
				ref:'../saveHargaButton',
				hidden : true,
				handler: detail_minta_save_harga_insert
			},
			{
				xtype:'spacer',
				width: 500
			},
			minta_button_saveandprintField
			,minta_button_saveField
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					mintabeli_post2db='CREATE';
					master_minta_beli_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/


	/* Function for retrieve create Window Form */
	master_minta_beli_createWindow= new Ext.Window({
		id: 'master_minta_beli_createWindow',
		title: mintabeli_post2db+'Permintaan Pembelian',
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
		renderTo: 'elwindow_master_minta_beli_create',
		items: master_minta_beli_createForm
	});
	/* End Window */


	/* Function for action list search */
	function master_minta_beli_list_search(){
		// render according to a SQL date format.
		var order_id_search=null;
		var minta_no_search=null;
		var minta_supplier_search=null;
		var minta_tanggal_search_date="";
		var minta_tanggal_akhir_search_date="";
		var order_carabayar_search=null;
		var minta_keterangan_search=null;
		var minta_status_search=null;
		var minta_status_acc_search=null;

		if(minta_idSearchField.getValue()!==null){order_id_search=minta_idSearchField.getValue();}
		if(minta_noSearchField.getValue()!==null){minta_no_search=minta_noSearchField.getValue();}
		if(minta_supplierSearchField.getValue()!==null){minta_supplier_search=minta_supplierSearchField.getValue();}
		if(minta_tanggalSearchField.getValue()!==""){minta_tanggal_search_date=minta_tanggalSearchField.getValue().format('Y-m-d');}
		if(minta_tanggal_akhirSearchField.getValue()!==""){minta_tanggal_akhir_search_date=minta_tanggal_akhirSearchField.getValue().format('Y-m-d');}
		if(minta_carabayarSearchField.getValue()!==null){order_carabayar_search=minta_carabayarSearchField.getValue();}
		if(minta_keteranganSearchField.getValue()!==null){minta_keterangan_search=minta_keteranganSearchField.getValue();}
		if(minta_statusSearchField.getValue()!==null){minta_status_search=minta_statusSearchField.getValue();}
		if(minta_status_accSearchField.getValue()!==null){minta_status_acc_search=minta_status_accSearchField.getValue();}

		// change the store parameters
		master_minta_beli_DataStore.baseParams = {
			task				: 'SEARCH',
			minta_id			:	order_id_search,
			minta_no			:	minta_no_search,
			minta_supplier		:	minta_supplier_search,
			order_tgl_awal		:	minta_tanggal_search_date,
			order_tgl_akhir		:	minta_tanggal_akhir_search_date,
			order_carabayar		:	order_carabayar_search,
			minta_keterangan	:	minta_keterangan_search,
			minta_status		:	minta_status_search,
			minta_status_acc	:	minta_status_acc_search
		};
		master_minta_beli_DataStore.reload({params: {start: 0, limit: pageS}});
	}

	/* Function for reset search result */
	function master_minta_beli_reset_search(){
		// reset the store parameters
		master_minta_beli_DataStore.baseParams = { task: 'LIST', start: 0, limit: pageS };
		master_minta_beli_DataStore.reload({params: {start: 0, limit: pageS}});
		//master_minta_beli_searchWindow.close();
	};
	/* End of Fuction */

	function master_minta_beli_cetak_faktur(pkid){

		Ext.Ajax.request({
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_master_minta_beli&m=print_faktur',
		params: {
			faktur	: pkid
		},
		success: function(response){
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/order_faktur.html','order_faktur','height=800,width=670,resizable=1,scrollbars=1, menubar=1');
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

	function master_minta_beli_reset_SearchForm(){
		minta_noSearchField.reset();
		minta_supplierSearchField.reset();
		minta_tanggalSearchField.reset();
		minta_tanggal_akhirSearchField.reset();
		minta_carabayarSearchField.reset();
		minta_keteranganSearchField.reset();
		minta_statusSearchField.reset();
		minta_status_accSearchField.reset();
	}
	/* Field for search */
	/* Identify  minta_id Search Field */
	minta_idSearchField= new Ext.form.NumberField({
		id: 'minta_idSearchField',
		fieldLabel: 'Id Order',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/

	});
	/* Identify  minta_no Search Field */
	minta_noSearchField= new Ext.form.TextField({
		id: 'minta_noSearchField',
		//fieldLabel: 'No Order',
		fieldLabel: 'No PP',
		maxLength: 50,
		anchor: '95%'

	});
	/* Identify  minta_supplier Search Field */
	minta_supplierSearchField= new Ext.form.ComboBox({
		id: 'minta_supplierSearchField',
		fieldLabel: 'Supplier',
		store: cbo_minta_supplier_DataStore,
		displayField:'minta_supplier_nama',
		mode : 'remote',
		valueField: 'minta_supplier_value',
        typeAhead: false,
        //loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
		allowBlank: true,
        tpl: minta_supplier_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'

	});
	/* Identify  minta_tanggal Search Field */
	minta_tanggalSearchField= new Ext.form.DateField({
		id: 'minta_tanggalSearchField',
		fieldLabel: 'Tanggal',
		format : 'd-m-Y'
//		value: firstday

	});

	minta_tanggal_akhirSearchField= new Ext.form.DateField({
		id: 'minta_tanggal_akhirSearchField',
		fieldLabel: 's/d',
		format : 'd-m-Y'
//		value: today
	});

	minta_label_tanggal_labelField=new Ext.form.Label({html: 'Tanggal :' });

	minta_label_tanggalField= new Ext.form.Label({ html: ' &nbsp; s/d  &nbsp;' });

	minta_tanggalSearchFieldSet=new Ext.form.FieldSet({
		id:'minta_tanggalSearchFieldSet',
		title: 'Opsi Tanggal',
		layout: 'column',
		boduStyle: 'padding: 5px;',
		frame: false,
		items:[minta_tanggalSearchField, minta_label_tanggalField, minta_tanggal_akhirSearchField]
	});

	/* Identify  order_carabayar Search Field */
	minta_carabayarSearchField= new Ext.form.ComboBox({
		id: 'minta_carabayarSearchField',
		fieldLabel: 'Cara Pembayaran',
		store:new Ext.data.SimpleStore({
			fields:['value', 'order_carabayar'],
			data:[['Tunai','Tunai'],['Kredit','Kredit'],['Konsinyasi','Konsinyasi']]
		}),
		mode: 'local',
		displayField: 'order_carabayar',
		valueField: 'value',
		anchor: '41%',
		triggerAction: 'all'

	});
/*
	order_diskonSearchField= new Ext.form.NumberField({
		id: 'order_diskonSearchField',
		fieldLabel: 'Diskon (%)',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: true,
		anchor: '50%',
		maxLength: 2,
		maskRe: /([0-9]+)$/

	});

	order_cashbackSearchField= new Ext.form.NumberField({
		id: 'order_cashbackSearchField',
		fieldLabel: 'Diskon (Rp)',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/

	});

	order_biayaSearchField= new Ext.form.NumberField({
		id: 'order_biayaSearchField',
		fieldLabel: 'Biaya',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/

	});

	order_bayarSearchField= new Ext.form.NumberField({
		id: 'order_bayarSearchField',
		fieldLabel: 'Bayar',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/

	});
*/

	/* Identify  minta_keterangan Search Field */
	minta_keteranganSearchField= new Ext.form.TextField({
		id: 'minta_keteranganSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 500,
		anchor: '95%'
	});

	minta_statusSearchField= new Ext.form.ComboBox({
		id: 'minta_statusSearchField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['value', 'minta_status'],
			data:[['Terbuka','Terbuka'],['Tertutup','Tertutup'],['Batal','Batal']]
		}),
		mode: 'local',
		displayField: 'minta_status',
		valueField: 'value',
		anchor: '41%',
		triggerAction: 'all'
	});

	minta_status_accSearchField= new Ext.form.ComboBox({
		id: 'minta_status_accSearchField',
		fieldLabel: 'Status Acc',
		store:new Ext.data.SimpleStore({
			fields:['value', 'minta_status_acc'],
			data:[['Terbuka','Terbuka'],['Tertutup','Tertutup']]
		}),
		mode: 'local',
		displayField: 'minta_status_acc',
		valueField: 'value',
		anchor: '41%',
		triggerAction: 'all'
	});


	/* Function for retrieve search Form Panel */
	master_minta_beli_searchForm = new Ext.FormPanel({
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
					minta_noSearchField,
					minta_supplierSearchField,
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
								minta_tanggalSearchField
							]
						},
						{
							columnWidth:0.30,
							layout: 'form',
							border:false,
							labelWidth:30,
							defaultType: 'datefield',
							items: [
								minta_tanggal_akhirSearchField
							]
						}
				        ]
					},
					// minta_carabayarSearchField,
					minta_keteranganSearchField,
					minta_statusSearchField
					]
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: master_minta_beli_list_search
			},{
				text: 'Close',
				handler: function(){
					master_minta_beli_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */

	/* Function for retrieve search Window Form, used for andvaced search */
	master_minta_beli_searchWindow = new Ext.Window({
		title: 'Pencarian Permintaan Pembelian',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_master_minta_beli_search',
		items: master_minta_beli_searchForm
	});
    /* End of Function */

  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!master_minta_beli_searchWindow.isVisible()){
			master_minta_beli_reset_SearchForm();
			master_minta_beli_searchWindow.show();
		} else {
			master_minta_beli_searchWindow.toFront();
		}
	}
  	/* End Function */



	/* Function for print List Grid */
	function master_minta_beli_print(){
		var searchquery = "";
		var minta_no_print=null;
		var minta_supplier_print=null;
		var order_tgl_awal_print_date="";
		var order_tgl_akhir_print_date;
		var order_carabayar_print=null;
		var minta_keterangan_print=null;
		var minta_status_print=null;
		var minta_status_acc_print=null;

		var win;

		if(master_minta_beli_DataStore.baseParams.query!==null){searchquery = master_minta_beli_DataStore.baseParams.query;}
		if(master_minta_beli_DataStore.baseParams.minta_no!==null){minta_no_print = master_minta_beli_DataStore.baseParams.minta_no;}
		if(master_minta_beli_DataStore.baseParams.minta_supplier!==null){minta_supplier_print = master_minta_beli_DataStore.baseParams.minta_supplier;}
		if(master_minta_beli_DataStore.baseParams.order_tgl_awal!==""){order_tgl_awal_print_date = master_minta_beli_DataStore.baseParams.order_tgl_awal;}
		if(master_minta_beli_DataStore.baseParams.order_tgl_akhir!==""){order_tgl_akhir_print_date = master_minta_beli_DataStore.baseParams.order_tgl_akhir;}
		if(master_minta_beli_DataStore.baseParams.order_carabayar!==null){order_carabayar_print = master_minta_beli_DataStore.baseParams.order_carabayar;}
		if(master_minta_beli_DataStore.baseParams.minta_keterangan!==null){minta_keterangan_print = master_minta_beli_DataStore.baseParams.minta_keterangan;}
		if(master_minta_beli_DataStore.baseParams.minta_status!==null){minta_status_print = master_minta_beli_DataStore.baseParams.minta_status;}
		if(master_minta_beli_DataStore.baseParams.minta_status_acc!==null){minta_status_acc_print = master_minta_beli_DataStore.baseParams.minta_status_acc;}


		Ext.Ajax.request({
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_master_minta_beli&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,
			minta_no 			: minta_no_print,
			minta_supplier 		: minta_supplier_print,
		  	order_tgl_awal 		: order_tgl_awal_print_date,
			order_tgl_akhir		: order_tgl_akhir_print_date,
			order_carabayar 	: order_carabayar_print,
			minta_keterangan 	: minta_keterangan_print,
			minta_status		: minta_status_print,
			minta_status_acc	: minta_status_acc_print,
		  	currentlisting		: master_minta_beli_DataStore.baseParams.task // this tells us if we are searching or not
		},
		success: function(response){
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/print_order_belilist.html','print_order_belilist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
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
	function master_minta_beli_export_excel(){
		var searchquery = "";
		var minta_no_2excel=null;
		var minta_supplier_2excel=null;
		var order_tgl_awal_2excel_date="";
		var order_tgl_akhir_2excel_date="";
		var order_carabayar_2excel=null;
		var minta_status_2excel=null;
		var minta_status_acc_2excel=null;
		var minta_keterangan_2excel=null;
		var win;
		// check if we do have some search data...
		if(master_minta_beli_DataStore.baseParams.query!==null){searchquery = master_minta_beli_DataStore.baseParams.query;}
		if(master_minta_beli_DataStore.baseParams.minta_no!==null){minta_no_2excel = master_minta_beli_DataStore.baseParams.minta_no;}
		if(master_minta_beli_DataStore.baseParams.minta_supplier!==null){minta_supplier_2excel = master_minta_beli_DataStore.baseParams.minta_supplier;}
		if(master_minta_beli_DataStore.baseParams.order_tgl_awal!==""){order_tgl_awal_2excel_date = master_minta_beli_DataStore.baseParams.order_tgl_awal;}
		if(master_minta_beli_DataStore.baseParams.order_tgl_akhir!==""){order_tgl_akhir_2excel_date = master_minta_beli_DataStore.baseParams.order_tgl_akhir;}
		if(master_minta_beli_DataStore.baseParams.order_carabayar!==null){order_carabayar_2excel = master_minta_beli_DataStore.baseParams.order_carabayar;}
		if(master_minta_beli_DataStore.baseParams.minta_status!==null){minta_status_2excel = master_minta_beli_DataStore.baseParams.minta_status;}
		if(master_minta_beli_DataStore.baseParams.minta_status_acc!==null){minta_status_acc_2excel = master_minta_beli_DataStore.baseParams.minta_status_acc;}
		if(master_minta_beli_DataStore.baseParams.minta_keterangan!==null){minta_keterangan_2excel = master_minta_beli_DataStore.baseParams.minta_keterangan;}

		Ext.Ajax.request({
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_master_minta_beli&m=get_action',
		params: {
			task				: "EXCEL",
		  	query				: searchquery,
			minta_no 			: minta_no_2excel,
			minta_supplier 		: minta_supplier_2excel,
		  	order_tgl_awal		: order_tgl_awal_2excel_date,
			order_tgl_akhir		: order_tgl_akhir_2excel_date,
			order_carabayar 	: order_carabayar_2excel,
			minta_status		: minta_status_2excel,
			minta_status_acc	: minta_status_acc_2excel,
			minta_keterangan 	: minta_keterangan_2excel,
		  	currentlisting		: master_minta_beli_DataStore.baseParams.task
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

	function detail_minta_beli_total(){
		var minta_jumlah_item=0;
		var minta_total_harga=0;
		for(i=0;i<detail_minta_beli_DataStore.getCount();i++){
			detail_minta_beli_record=detail_minta_beli_DataStore.getAt(i);
			minta_jumlah_item=minta_jumlah_item+detail_minta_beli_record.data.dminta_jumlah;
			minta_total_harga=minta_total_harga+(detail_minta_beli_record.data.dminta_jumlah*detail_minta_beli_record.data.dminta_harga*(100-detail_minta_beli_record.data.dminta_diskon)/100);
		}
		minta_jumlahField.setValue(CurrencyFormatted(minta_jumlah_item));
		minta_itemField.setValue(CurrencyFormatted(detail_minta_beli_DataStore.getCount()));
		<?php if(($_SESSION[SESSION_GROUPID]==9) || ($_SESSION[SESSION_GROUPID]==1)){ ?>
	
		var diskon=convertToNumber(minta_diskonField.getValue())*minta_total_harga/100;
		//if (minta_save_hargaField.getValue()=='1'){
			minta_totalField.setValue(CurrencyFormatted(minta_total_harga));
			minta_totalbayarField.setValue(CurrencyFormatted(minta_total_harga+convertToNumber(minta_biayaField.getValue())-convertToNumber(minta_bayarField.getValue())-convertToNumber(minta_cashbackField.getValue())-diskon));
		//}else{
		//	minta_totalField.setValue('NA');
		//	minta_totalbayarField.setValue('NA');
		//}
		<?php } ?>
	}

	master_minta_beli_DataStore.load({params:{start:0, limit: pageS}});
	detail_minta_beli_DataStore.on("load",detail_minta_beli_total);

	<?php if(($_SESSION[SESSION_GROUPID]==9) || ($_SESSION[SESSION_GROUPID]==1)){ ?>
	minta_bayarField.on("keyup",detail_minta_beli_total);
	minta_biayaField.on("keyup",detail_minta_beli_total);
	minta_cashbackField.on("keyup",detail_minta_beli_total);
	minta_diskonField.on("keyup",detail_minta_beli_total);

	minta_bayarField.on("focus", function() {  minta_bayarField.setValue(convertToNumber(minta_bayarField.getValue())); });
	minta_biayaField.on("focus", function() {  minta_biayaField.setValue(convertToNumber(minta_biayaField.getValue())); });
	minta_cashbackField.on("focus", function() {  minta_cashbackField.setValue(convertToNumber(minta_cashbackField.getValue())); });

	minta_bayarField.on("blur", function() {  minta_bayarField.setValue(CurrencyFormatted(minta_bayarField.getValue())); });
	minta_biayaField.on("blur", function() {  minta_biayaField.setValue(CurrencyFormatted(minta_biayaField.getValue())); });
	minta_cashbackField.on("blur", function() {  minta_cashbackField.setValue(CurrencyFormatted(minta_cashbackField.getValue())); });
	<? } ?>
	master_minta_beli_ListEditorGrid.addListener('rowcontextmenu', onmaster_minta_beli_ListEditGridContextMenu);

	combo_minta_produk.on("focus",function(){
		cbo_minta_produk_DataStore.setBaseParam('task','list');
		var selectedquery=detail_minta_beli_ListEditorGrid.getSelectionModel().getSelected().get('produk_nama');
		cbo_minta_produk_DataStore.setBaseParam('query',selectedquery);

		//cbo_minta_produk_DataStore.load();
	});

	combo_minta_satuan.on("focus",function(){
		cbo_minta_satuanDataStore.setBaseParam('task','produk');
		cbo_minta_satuanDataStore.setBaseParam('selected_id',combo_minta_produk.getValue());
		cbo_minta_satuanDataStore.load();
	});

	combo_minta_produk.on("select",function(){
		//var check_supplier_id = master_minta_beli_ListEditorGrid.getSelectionModel().getSelected().get('minta_supplier_id');
		//minta_supplier_idField.setValue(check_supplier_id);
		cbo_minta_satuanDataStore.setBaseParam('task','produk');
		cbo_minta_satuanDataStore.setBaseParam('selected_id',combo_minta_produk.getValue());
		cbo_dminta_produk_hargaDataStore.setBaseParam('task','op_last_price');
		cbo_dminta_produk_hargaDataStore.setBaseParam('supplier_id',minta_supplier_idField.getValue());
		cbo_dminta_produk_hargaDataStore.setBaseParam('produk_id',combo_minta_produk.getValue());
		cbo_dminta_produk_hargaDataStore.setBaseParam('minta_tanggal',minta_tanggalField.getValue().format('Y-m-d'));
		cbo_minta_satuanDataStore.load({
			callback: function(r,opt,success){
				cbo_dminta_produk_hargaDataStore.load({
					callback: function(r,opt,success){
				if(success==true){
					if(cbo_minta_satuanDataStore.getCount()>0){
						var j=cbo_minta_satuanDataStore.findExact('order_satuan_default','true');
						//var k=cbo_dminta_produk_hargaDataStore.findExact('dminta_produk',combo_minta_produk.getValue(),0);
						if(j>-1){
							var sat_default=cbo_minta_satuanDataStore.getAt(j);
							combo_minta_satuan.setValue(sat_default.data.order_satuan_value);
						}	
					}		
					if(cbo_dminta_produk_hargaDataStore.getCount()>0){
					var last_price_pp=cbo_dminta_produk_hargaDataStore.getAt(0);
					minta_harga_satuanField.setValue(last_price_pp.data.dminta_harga);
					dminta_kodeprodukField.setValue(last_price_pp.data.produk_kode);
					
					<? if(($_SESSION[SESSION_GROUPID]==9 || ($_SESSION[SESSION_GROUPID]==1) || ($_SESSION[SESSION_GROUPID]==29))){ ?>
						minta_harga_satuanField.setVisible(true);
					<? } ?>
					<? if(($_SESSION[SESSION_GROUPID]==4 || ($_SESSION[SESSION_GROUPID]==26) )){ ?>
						minta_harga_satuanField.setVisible(false);
					<? } ?>
					
					}
				}
			}
			});	
			}
		});
	});


	detail_minta_beli_DataStore.on("update",function(){
		var	query_selected="";
		var satuan_selected="";
		detail_minta_beli_DataStore.commitChanges();
		detail_minta_beli_total();
		cbo_minta_produk_DataStore.lastQuery=null;
		for(i=0;i<detail_minta_beli_DataStore.getCount();i++){
			detail_minta_beli_record=detail_minta_beli_DataStore.getAt(i);
			query_selected=query_selected+detail_minta_beli_record.data.dminta_produk+",";
		}
		cbo_minta_produk_DataStore.setBaseParam('task','selected');
		cbo_minta_produk_DataStore.setBaseParam('master_id',get_pk_id());
		cbo_minta_produk_DataStore.setBaseParam('selected_id',query_selected);
		cbo_minta_produk_DataStore.load();

		for(i=0;i<detail_minta_beli_DataStore.getCount();i++){
			detail_minta_beli_record=detail_minta_beli_DataStore.getAt(i);
			satuan_selected=satuan_selected+detail_minta_beli_record.data.dminta_satuan+",";
		}
		cbo_minta_satuanDataStore.setBaseParam('task','selected');
		cbo_minta_satuanDataStore.setBaseParam('selected_id',satuan_selected);
		cbo_minta_satuanDataStore.load();
		stat='EDIT';
		
	});

	detail_minta_beli_DataStore.on("load", function(){
		if(detail_minta_beli_DataStore.getCount()==pageS && detail_minta_beli_DataStore.getTotalCount()>pageS){
			detail_minta_bAdd.disabled=true;
		}else{
			detail_minta_bAdd.disabled=false;
		}
	});

	
	minta_gudangField.on("select",function(){
		//cbo_stok_produkDataStore.setBaseParam('gudang',get_gudang_id());
		//cbo_stok_produkDataStore.setBaseParam('task','list');
		check_supplier();
	});


	/*master_minta_paging_toolbar.on("change", function(){
			console.log('aktive page :');
	});*/

});
	</script>
</head>
<body>
<div>
	<div class="col">
        <div id="fp_master_minta_beli"></div>
         <div id="fp_detail_minta_beli"></div>
		<div id="elwindow_master_minta_beli_create"></div>
        <div id="elwindow_master_minta_beli_search"></div>
    </div>
</div>
</body>
</html>