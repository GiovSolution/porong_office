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
var master_mutasi_DataStore;
var master_mutasi_ColumnModel;
var master_mutasiListEditorGrid;
var master_mutasi_createForm;
var master_mutasi_createWindow;
var master_mutasi_searchForm;
var master_mutasi_searchWindow;
var master_mutasi_SelectedRow;
var master_mutasi_ContextMenu;
//for detail data
var detail_mutasi_DataStore;
var detail_mutasi_racikanDataStore;
var detail_mutasiListEditorGrid;
var detail_mutasi_produk_jadiListEditorGrid;
var detail_mutasi_ColumnModel;
var detail_mutasi_proxy;
var detail_mutasi_writer;
var detail_mutasi_reader;
var editor_detail_mutasi;
var editor_detail_mutasi_produk_jadi;
var detail_mutasi_racikan_reader;
var detail_mutasi_racikan_writer;

//declare konstant
var mutasi_post2db = '';
var msg = '';
var pageS=15;
var today=new Date().format('Y-m-d');
var cetak=0;
var printonly=0;
var group_id=<?=$_SESSION[SESSION_GROUPID];?>;

/* declare variable here for Field*/
var mutasi_idField;
var mutasi_noField;
var mutasi_asalField;
var mutasi_tujuanField;
var mutasi_tanggalField;
var mutasi_keteranganField;
var mutasi_kategori_barang_keluarField;
var mutasi_idSearchField;
var mutasi_asalSearchField;
var mutasi_tujuanSearchField;
var mutasi_tanggalSearchField;
var mutasi_keteranganSearchField;
var mutasi_statusSearchField;
var mutasi_status_terima_SearchField;

var mutasi_button_saveField;
var mutasi_button_saveprintField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
	
  /* Function for Retrieve permission DataStore */
	mutasi_no_DataStore = new Ext.data.Store({
		id: 'mutasi_no_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_mutasi&m=master_mutasi_pengecekan',
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results'
		},[
				{name: 'mutasi_no', type: 'string', mapping: 'mutasi_no'}
		])
	});
	
	/*Function for pengecekan _dokumen untuk save n print */		
	function pengecekan_dokumen(){
		var mutasi_tanggal_create_date = "";
		if(mutasi_tanggalField.getValue()!== ""){mutasi_tanggal_create_date = mutasi_tanggalField.getValue().format('Y-m-d');} 
		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_master_mutasi&m=get_action',
			params: {
				task: "CEK",
				tanggal_pengecekan	: mutasi_tanggal_create_date,
				mutasi_asal		: mutasi_asalField.getValue(),
				mutasi_tujuan	: mutasi_tujuanField.getValue()
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
						case 1:
							cetak=1;
							master_mutasi_create('print');
						break;
						case 0:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Data Penerimaan Barang tidak bisa disimpan, karena telah melebihi batas hari yang diperbolehkan ',
						   buttons: Ext.MessageBox.OK,
						   animEl: 'save',
						   icon: Ext.MessageBox.WARNING,
						  // master_mutasi_create('print')
						});
						//jproduk_btn_cancel();
						break
						default:
						
						mutasi_no_DataStore.load({
						params: {tanggal_pengecekan	: mutasi_tanggal_create_date,
									mutasi_asal		: mutasi_asalField.getValue(),
									mutasi_tujuan	: mutasi_tujuanField.getValue()},
							callback: function(opts, success, response)  {
								  if (success) {
									if(mutasi_no_DataStore.getCount()!=0){
										var mutasi_no = null;
										mutasi_no_record=mutasi_no_DataStore.getAt(0).data;
										mutasi_no_temp.setValue(mutasi_no_record.mutasi_no);
										mutasi_no = mutasi_no_temp.getValue();
										Ext.MessageBox.show({
											title: 'Warning',
											msg: 'Tidak dapat melanjutkan, ada Status Terima yang masih "Tunggu" '+'<br> No MB : '+mutasi_no,
											buttons: Ext.MessageBox.OK,
											animEl: 'save',
											icon: Ext.MessageBox.INFO
										});
									}
								  }
							  }
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
	
	/*Function for pengecekan _dokumen untuk save and close*/
	function pengecekan_dokumen_saveclose(){
		var mutasi_tanggal_create_date = "";
		var mutasi_id_create_pk=null;
		mutasi_id_create_pk=get_pk_id();
		
		if(mutasi_tanggalField.getValue()!== ""){mutasi_tanggal_create_date = mutasi_tanggalField.getValue().format('Y-m-d');} 
		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_master_mutasi&m=get_action',
			params: {
				task: "CEKSAVECLOSE",
				tanggal_pengecekan	: mutasi_tanggal_create_date,
				no_mb : mutasi_id_create_pk,
				mutasi_asal		: mutasi_asalField.getValue(),
				mutasi_tujuan	: mutasi_tujuanField.getValue()
			},  
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
						case 1:
							cetak=0;
							master_mutasi_create();
						break;
						default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Data Penerimaan Barang tidak bisa disimpan, karena telah melebihi batas hari yang diperbolehkan ',
						   buttons: Ext.MessageBox.OK,
						   animEl: 'save',
						   icon: Ext.MessageBox.WARNING,
						  // master_mutasi_create('print')
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
  
   	/* Function for add data, open window create form */
	function master_mutasi_create(opsi){
	
		if(detail_mutasi_DataStore.getCount()<1){
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Data detail harus ada minimal 1 (satu)',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
		else if((detail_mutasi_produkJadi_DataStore.getCount()<1) && (mutasi_barang_racikan_keluarField.getValue(true))){
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Data detail Produk Jadi harus ada minimal 1 (satu)',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
		
		
		else if(is_master_mutasi_form_valid()){	
		
		var mutasi_id_create_pk=null; 
		var mutasi_no_create=null;
		var mutasi_asal_create=null; 
		var mutasi_tujuan_create=null; 
		var mutasi_tanggal_create_date=""; 
		var mutasi_keterangan_create=null;
		var mutasi_status_create=null;
		var mutasi_status_terima_create=null;
		var mutasi_spb_create=null;
		var racikan_produk_create = null;
		var racikan_satuan_create = null;
		var racikan_jumlah_create = null;
		var racikan_dmracikan_id_create = null;
		var mutasi_kategori_barang_keluar_create = null;

		mutasi_id_create_pk=get_pk_id();
		if(mutasi_asalField.getValue()!== null){mutasi_asal_create = mutasi_asalField.getValue();} 
		if(mutasi_noField.getValue()!== null){mutasi_no_create = mutasi_noField.getValue();} 
		if(mutasi_tujuanField.getValue()!== null){mutasi_tujuan_create = mutasi_tujuanField.getValue();} 
		if(mutasi_tanggalField.getValue()!== ""){mutasi_tanggal_create_date = mutasi_tanggalField.getValue().format('Y-m-d');} 
		if(mutasi_keteranganField.getValue()!== null){mutasi_keterangan_create = mutasi_keteranganField.getValue();} 
		if(mutasi_statusField.getValue()!== null){mutasi_status_create = mutasi_statusField.getValue();}
		if(mutasi_kategori_barang_keluarField.getValue()!== null){mutasi_kategori_barang_keluar_create = mutasi_kategori_barang_keluarField.getValue();} 

		if(mutasi_status_terimaField.getValue()!== null){mutasi_status_terima_create = mutasi_status_terimaField.getValue();}
		
		if(mutasi_spbField.getValue()!== null){mutasi_spb_create = mutasi_spbField.getValue();}
		if(mutasi_produkjadiField.getValue()!== null){racikan_produk_create = mutasi_produkjadiField.getValue();} 
		if(mutasi_produkjadi_jumlahField.getValue()!== null){racikan_jumlah_create = mutasi_produkjadi_jumlahField.getValue();} 
		if(mutasi_satuan_produkjadiField.getValue()!== null){racikan_satuan_create = mutasi_satuan_produkjadiField.getValue();} 
		if(mutasi_norefField.getValue()!== null){racikan_dmracikan_id_create = mutasi_norefField.getValue();} 
		
		
		/*Insert detail produk Jadi */
		var dmracikan_id = [];
        var dmracikan_produk = [];
        var dmracikan_satuan = [];
        var dmracikan_jumlah = [];
      
             var dcount = detail_mutasi_produkJadi_DataStore.getCount() - 1;
                    
                    if(detail_mutasi_produkJadi_DataStore.getCount()>0){
                        for(i=0; i<detail_mutasi_produkJadi_DataStore.getCount();i++){
                            if((/^\d+$/.test(detail_mutasi_produkJadi_DataStore.getAt(i).data.dmracikan_produk))
                               && detail_mutasi_produkJadi_DataStore.getAt(i).data.dmracikan_produk!==undefined
                               && detail_mutasi_produkJadi_DataStore.getAt(i).data.dmracikan_produk!==''
                               && detail_mutasi_produkJadi_DataStore.getAt(i).data.dmracikan_produk!==0){
                                
                                dmracikan_id.push(detail_mutasi_produkJadi_DataStore.getAt(i).data.dmracikan_id);
                                
                                dmracikan_produk.push(detail_mutasi_produkJadi_DataStore.getAt(i).data.dmracikan_produk);
								
								dmracikan_satuan.push(detail_mutasi_produkJadi_DataStore.getAt(i).data.dmracikan_satuan);
                                
                                if((detail_mutasi_produkJadi_DataStore.getAt(i).data.dmracikan_jumlah==undefined) || (detail_mutasi_produkJadi_DataStore.getAt(i).data.dmracikan_jumlah=='') || (detail_mutasi_produkJadi_DataStore.getAt(i).data.dmracikan_jumlah==0)){
                                    dmracikan_jumlah.push(1);
                                }else{
                                    dmracikan_jumlah.push(detail_mutasi_produkJadi_DataStore.getAt(i).data.dmracikan_jumlah);
                                }
  
                            }
                        }
                    }
		
		var encoded_array_dmracikan_id = Ext.encode(dmracikan_id);
		var encoded_array_dmracikan_produk = Ext.encode(dmracikan_produk);
		var encoded_array_dmracikan_satuan = Ext.encode(dmracikan_satuan);
		var encoded_array_dmracikan_jumlah = Ext.encode(dmracikan_jumlah);

		
		Ext.MessageBox.show({
			msg:   'Sedang memproses data, mohon tunggu hingga proses ini selesai agar keamanan data anda terjaga...',
			progressText: 'proses...',
			width:350,
			wait:true
		});
		
		Ext.Ajax.request({  
			waitMsg: 'Mohon tunggu...',
			url: 'index.php?c=c_master_mutasi&m=get_action',
			params: {
				task				: mutasi_post2db,
				mutasi_id			: mutasi_id_create_pk, 
				mutasi_no			: mutasi_no_create,
				mutasi_asal			: mutasi_asal_create, 
				mutasi_tujuan		: mutasi_tujuan_create, 
				mutasi_tanggal		: mutasi_tanggal_create_date, 
				mutasi_keterangan	: mutasi_keterangan_create,
				mutasi_status		: mutasi_status_create,
				mutasi_status_terima: mutasi_status_terima_create,
				mutasi_spb			: mutasi_spb_create,
				mutasi_barang_keluar: mutasi_barang_keluarField.getValue(),
				mutasi_racikan	    : mutasi_barang_racikan_title.getValue(),
				racikan_keluar		: mutasi_barang_racikan_keluarField.getValue(),
				racikan_masuk		: mutasi_barang_racikan_masukField.getValue(),
				mutasi_kategori_barang_keluar : mutasi_kategori_barang_keluar_create,
				
				/*Insert detail produk jadi */
				dmracikan_id		: encoded_array_dmracikan_id,
				dmracikan_mutasi_id	: mutasi_id_create_pk, 
				dmracikan_produk	: encoded_array_dmracikan_produk, 
				dmracikan_satuan	: encoded_array_dmracikan_satuan, 
				dmracikan_jumlah	: encoded_array_dmracikan_jumlah,
				//racikan_produk		: racikan_produk_create,
				//racikan_jumlah		: racikan_jumlah_create,
				//racikan_satuan		: racikan_satuan_create,
				racikan_dmracikan_id: racikan_dmracikan_id_create,
				cetak				: cetak,
				printonly			: printonly
			}, 
			success: function(response){             
				var result=eval(response.responseText);
				if(result!==0){
						detail_mutasi_insert(result,opsi);
						Ext.MessageBox.alert(mutasi_post2db+' OK','Data Mutasi Barang berhasil disimpan');
						master_mutasi_createWindow.hide();
				}else{
						Ext.MessageBox.show({
						   title: 'Warning',
						   //msg: 'We could\'t not '+msg+' the Master_order_beli.',
						   msg: 'Data Mutasi Barang tidak bisa disimpan',
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
				msg: 'Form anda belum valid',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
 	/* End of Function */
  
  	/* Function for get PK field */
	function get_pk_id(){
		if(mutasi_post2db=='UPDATE')
			return master_mutasiListEditorGrid.getSelectionModel().getSelected().get('mutasi_id');
		else if(mutasi_post2db=='CREATE')
			return mutasi_idField.getValue();
		else 
			return 0;
	}
	/* End of Function  */
	
	function get_asal_id(){
		if(isNaN(parseInt(mutasi_asalField.getValue())) || parseInt(mutasi_asalField.getValue())==0)
		{
			return master_mutasiListEditorGrid.getSelectionModel().getSelected().get('mutasi_asal_id');
		}else{
			return mutasi_asalField.getValue();
		}
	}
	
	function get_tujuan_id(){
		if(isNaN(parseInt(mutasi_tujuanField.getValue())) || parseInt(mutasi_tujuanField.getValue())==0)
		{
			return master_mutasiListEditorGrid.getSelectionModel().getSelected().get('mutasi_tujuan_id');
		}else{
			return mutasi_tujuanField.getValue();
		}
	}
	
	/* Reset form before loading */
	function master_mutasi_reset_form(){
		mutasi_idField.reset();
		mutasi_idField.setValue(null);
		mutasi_noField.reset();
		mutasi_noField.setValue('(Auto)');
		mutasi_asalField.reset();
		mutasi_asalField.setValue(null);
		mutasi_tujuanField.reset();
		mutasi_tujuanField.setValue(null);
		mutasi_tanggalField.reset();
		mutasi_tanggalField.setValue(today);
		mutasi_keteranganField.reset();
		mutasi_keteranganField.setValue(null);
		mutasi_kategori_barang_keluarField.reset();
		mutasi_kategori_barang_keluarField.setValue(null);
		mutasi_statusField.reset();
		mutasi_statusField.setValue('Terbuka');
		mutasi_status_terimaField.reset();
		mutasi_status_terimaField.setValue(null);
		mutasi_spbField.reset();
		mutasi_spbField.setValue('(Manual Input)');
		dmracikan_jenisField.reset();
		dmracikan_jenisField.setValue(null);
		mutasi_barang_racikan_title.reset();
		mutasi_barang_racikan_title.setValue(false);
		mutasi_racikanFieldSet.setDisabled(true);
		
		//mutasi_barang_racikan_keluarField.setValue(null);
		//mutasi_barang_racikan_keluarField.reset();
		
		mutasi_produkjadiField.reset();
		mutasi_produkjadiField.setValue(null);
		mutasi_produkjadi_jumlahField.reset();
		mutasi_produkjadi_jumlahField.setValue(null);
		mutasi_satuan_produkjadiField.reset();
		mutasi_satuan_produkjadiField.setValue(null);
		mutasi_norefField.reset();
		mutasi_norefField.setValue(null);
		mutasi_barang_keluarField.reset();
		mutasi_barang_keluarField.setValue(null);
		
		detail_mutasi_DataStore.removeAll();
		mutasi_totaljumlahField.reset();
		mutasi_totaljumlahField.setValue(null);
		produk_jadi_totaljumlahField.reset();
		produk_jadi_totaljumlahField.setValue(null);
		mutasi_itemjumlahField.reset();
		mutasi_itemjumlahField.setValue(null);
		produk_jadi_itemjumlahField.reset();
		produk_jadi_itemjumlahField.setValue(null);

		cbo_mutasi_satuanDataStore.setBaseParam('task','all');
		cbo_mutasi_satuanDataStore.load();
		
		mutasi_button_saveprintField.setDisabled(false);
		mutasi_button_saveField.setDisabled(false);
		
		mutasi_barang_racikan_title.setDisabled(false);
		mutasi_asalField.setDisabled(false);
		mutasi_tujuanField.setDisabled(false);
		mutasi_noField.setDisabled(false);
		mutasi_tanggalField.setDisabled(false);
		mutasi_keteranganField.setDisabled(false);
		mutasi_kategori_barang_keluarField.setDisabled(true);
		mutasi_statusField.setDisabled(false);
		detail_mutasiListEditorGrid.setDisabled(false);
		detail_mutasiListEditorGrid.dmutasi_add.enable();
		detail_mutasiListEditorGrid.dmutasi_delete.enable();
		combo_mutasi_produk.setDisabled(false);
		combo_mutasi_satuan.setDisabled(false);
		djumlah_mutasiField.setDisabled(false);
		mutasi_spbField.setDisabled(false);
		mutasi_barang_keluarField.setDisabled(false);
		mutasi_status_terimaField.setDisabled(true);
		
		mutasi_produkjadiField.setDisabled(false);
		mutasi_satuan_produkjadiField.setDisabled(false);
		mutasi_produkjadi_jumlahField.setDisabled(false);
		
		
		detail_mutasi_produk_jadiListEditorGrid.setDisabled(true);
		
		//detail_mutasi_produk_jadiListEditorGrid.dmutasi_add_produk_jadi.disable();
		//detail_mutasi_produk_jadiListEditorGrid.dmutasi_delete_produk_jadi.disable();
		//detail_mutasi_produk_jadiListEditorGrid.setDisabled(true);
		//master_mutasi_createForm.mmutasi_savePrint.enable();
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function master_mutasi_set_form(){
		mutasi_idField.setValue(master_mutasiListEditorGrid.getSelectionModel().getSelected().get('mutasi_id'));
		mutasi_noField.setValue(master_mutasiListEditorGrid.getSelectionModel().getSelected().get('mutasi_no'));
		mutasi_asalField.setValue(master_mutasiListEditorGrid.getSelectionModel().getSelected().get('mutasi_asal'));
		mutasi_tujuanField.setValue(master_mutasiListEditorGrid.getSelectionModel().getSelected().get('mutasi_tujuan'));
		mutasi_tanggalField.setValue(master_mutasiListEditorGrid.getSelectionModel().getSelected().get('mutasi_tanggal'));
		mutasi_keteranganField.setValue(master_mutasiListEditorGrid.getSelectionModel().getSelected().get('mutasi_keterangan'));
		mutasi_statusField.setValue(master_mutasiListEditorGrid.getSelectionModel().getSelected().get('mutasi_status'));
		mutasi_status_terimaField.setValue(master_mutasiListEditorGrid.getSelectionModel().getSelected().get('mutasi_status_terima'));
		mutasi_barang_keluarField.setValue(master_mutasiListEditorGrid.getSelectionModel().getSelected().get('mutasi_barang_keluar'));
		mutasi_spbField.setValue(master_mutasiListEditorGrid.getSelectionModel().getSelected().get('mutasi_spb'));
		mutasi_barang_racikan_title.setValue(master_mutasiListEditorGrid.getSelectionModel().getSelected().get('mutasi_racikan'));
		dmracikan_jenisField.setValue(master_mutasiListEditorGrid.getSelectionModel().getSelected().get('dmracikan_jenis'));
		mutasi_kategori_barang_keluarField.setValue(master_mutasiListEditorGrid.getSelectionModel().getSelected().get('kbk_nama'));
		
		mutasi_barang_racikan_title.setDisabled(true);
		
		/*Jika mutasi_racikan nilainya True, maka Racikan Field Set akan di disabled, sehingga tidak bisa di Edit lagi..*/
		if(master_mutasiListEditorGrid.getSelectionModel().getSelected().get('mutasi_racikan')==true)
		{
			mutasi_racikanFieldSet.setDisabled(true);
			mutasi_barang_racikan_title.setDisabled(true);
		}
		else if(master_mutasiListEditorGrid.getSelectionModel().getSelected().get('mutasi_racikan')==false)
		{
		mutasi_barang_racikan_title.reset();
		mutasi_barang_racikan_title.setValue(false);
		mutasi_racikanFieldSet.setDisabled(true);
		mutasi_barang_racikan_title.setDisabled(false);
		}
		
		//LOAD OF DETAIL
		cbo_mutasi_satuanDataStore.setBaseParam('task','detail');
		cbo_mutasi_satuanDataStore.setBaseParam('master_id',get_pk_id());
		cbo_mutasi_satuanDataStore.load();
		
		cbo_mutasi_produkDataStore.setBaseParam('master_id',get_pk_id());
		cbo_mutasi_produkDataStore.setBaseParam('task','detail');
		cbo_mutasi_produkDataStore.setBaseParam('gudang',master_mutasiListEditorGrid.getSelectionModel().getSelected().get('mutasi_asal_id'));
		
		cbo_mracikan_satuanDataStore.setBaseParam('task','detail');
		cbo_mracikan_satuanDataStore.setBaseParam('master_id',get_pk_id());
		cbo_mracikan_satuanDataStore.load();
		
		//cbo_mutasi_produkjadi_DataSore.setBaseParam('master_id',get_pk_id());
		//cbo_mutasi_produkjadi_DataSore.setBaseParam('task','detail');
		//cbo_mutasi_produkjadi_DataSore.setBaseParam('gudang',master_mutasiListEditorGrid.getSelectionModel().getSelected().get('mutasi_asal_id'));
		cbo_mutasi_produkjadi_DataSore.load(
		{
				params: {
					query: master_mutasiListEditorGrid.getSelectionModel().getSelected().get('mutasi_id'),
					task : 'detail',
					aktif : 'yes'
				}
		
		});
		
		//mutasi_button_saveField.setDisabled(true);
		//mutasi_button_saveprintField.setDisabled(true);

		cbo_mutasi_produkDataStore.load({
			callback: function(r,opt,success){
				if(success==true){
					detail_mutasi_DataStore.setBaseParam('master_id',get_pk_id());
					detail_mutasi_DataStore.load({
						callback: function(r,opt,success){
							if(success==true){
								Ext.MessageBox.hide();
								/*Jika dmracikan_jenis = 0 , itu tandanya racikan Keluar, maka harus mengload detail_mutasi_produkJadiDataStore, jika dmracikan_jenis =1 , maka tidak perlu load*/
								if(master_mutasiListEditorGrid.getSelectionModel().getSelected().get('dmracikan_jenis')==0 && master_mutasiListEditorGrid.getSelectionModel().getSelected().get('mutasi_racikan')==true)
								{
									detail_mutasi_produkJadi_DataStore.setBaseParam('master_id',get_pk_id());
									detail_mutasi_produkJadi_DataStore.setBaseParam('task','master_id');
									detail_mutasi_produkJadi_DataStore.load({
									params : { master_id: get_pk_id()}
				
								});
								mutasi_barang_racikan_keluarField.setValue(true);
								mutasi_asalField.setValue('Gudang Retail');
								mutasi_asalField.setDisabled(true);
								detail_mutasi_produk_jadiListEditorGrid.setDisabled(false);
								
								}
								else if(master_mutasiListEditorGrid.getSelectionModel().getSelected().get('dmracikan_jenis')==1 && master_mutasiListEditorGrid.getSelectionModel().getSelected().get('mutasi_racikan')==true)
								{
									detail_mutasi_produkJadi_DataStore.setBaseParam('no_ref',get_pk_id());
									detail_mutasi_produkJadi_DataStore.setBaseParam('task','no_ref');
									detail_mutasi_produkJadi_DataStore.load({
										params : { no_ref: get_pk_id()},
										callback: function(opts, success, response){
											if (success) {
												if(detail_mutasi_produkJadi_DataStore.getCount()){
													dmracikan_record=detail_mutasi_produkJadi_DataStore.getAt(0).data;
													mutasi_norefField.setValue(dmracikan_record.mutasi_no);
												}
											}
										}
					
								});
									
								mutasi_barang_racikan_masukField.setValue(true);
								
								}
			
													
							}
						}
					});
				}
			}
		});
		// END OF DETAIL
		
		if(mutasi_post2db=="UPDATE" && master_mutasiListEditorGrid.getSelectionModel().getSelected().get('mutasi_status')=="Terbuka"){
			if(master_mutasiListEditorGrid.getSelectionModel().getSelected().get('mutasi_barang_keluar')==true)
			{
				mutasi_barang_keluarField.setDisabled(true);
				mutasi_tujuanField.setDisabled(true);
				mutasi_idField.setDisabled(false);
				mutasi_noField.setDisabled(false);
				mutasi_asalField.setDisabled(false);
				mutasi_tanggalField.setDisabled(false);
				mutasi_keteranganField.setDisabled(false);
				mutasi_kategori_barang_keluarField.setDisabled(false);
				mutasi_statusField.setDisabled(false);
				mutasi_button_saveprintField.setDisabled(false);
				mutasi_button_saveField.setDisabled(false);
				//detail_mutasiListEditorGrid.setDisabled(false);
				//mutasi_produkjadiField.setDisabled(true);
				//mutasi_satuan_produkjadiField.setDisabled(true);
				//mutasi_produkjadi_jumlahField.setDisabled(true);
				detail_mutasiListEditorGrid.dmutasi_add.enable();
				detail_mutasiListEditorGrid.dmutasi_delete.enable();
				combo_mutasi_produk.setDisabled(false);
				combo_mutasi_satuan.setDisabled(false);
				djumlah_mutasiField.setDisabled(false);
			}
			else
			{
				mutasi_idField.setDisabled(false);
				mutasi_noField.setDisabled(false);
				mutasi_asalField.setDisabled(false);
				//mutasi_tujuanField.setDisabled(false);
				mutasi_tanggalField.setDisabled(false);
				mutasi_keteranganField.setDisabled(false);
				mutasi_kategori_barang_keluarField.setDisabled(false);
				mutasi_statusField.setDisabled(false);
				mutasi_button_saveprintField.setDisabled(false);
				mutasi_button_saveField.setDisabled(false);
				
				//mutasi_produkjadiField.setDisabled(false);
				//mutasi_satuan_produkjadiField.setDisabled(false);
				//mutasi_produkjadi_jumlahField.setDisabled(false);
				//detail_mutasiListEditorGrid.setDisabled(false);
				detail_mutasiListEditorGrid.dmutasi_add.enable();
				detail_mutasiListEditorGrid.dmutasi_delete.enable();
				combo_mutasi_produk.setDisabled(false);
				combo_mutasi_satuan.setDisabled(false);
				djumlah_mutasiField.setDisabled(false);
			}
			//master_mutasi_createForm.mmutasi_savePrint.enable();
		}
		if(mutasi_post2db=="UPDATE" && master_mutasiListEditorGrid.getSelectionModel().getSelected().get('mutasi_status')=="Tertutup"){
			mutasi_idField.setDisabled(true);
			mutasi_noField.setDisabled(true);
			mutasi_asalField.setDisabled(true);
			mutasi_tujuanField.setDisabled(true);
			mutasi_tanggalField.setDisabled(true);
			mutasi_keteranganField.setDisabled(true);
			mutasi_kategori_barang_keluarField.setDisabled(true);
			mutasi_statusField.setDisabled(false);
			//detail_mutasiListEditorGrid.setDisabled(true);
			combo_mutasi_produk.setDisabled(true);
			combo_mutasi_satuan.setDisabled(true);
			djumlah_mutasiField.setDisabled(true);
			detail_mutasiListEditorGrid.dmutasi_add.disable();
			detail_mutasiListEditorGrid.dmutasi_delete.disable();

			mutasi_produkjadiField.setDisabled(true);
			mutasi_satuan_produkjadiField.setDisabled(true);
			mutasi_produkjadi_jumlahField.setDisabled(true);
			//detail_mutasiListEditorGrid.setReadOnly(true);
			mutasi_button_saveprintField.setDisabled(true);
			mutasi_button_saveField.setDisabled(false);
			mutasi_spbField.setDisabled(true);
			mutasi_barang_keluarField.setDisabled(true);
			mutasi_status_terimaField.setDisabled(true);
			if(cetak==1){
					//jproduk_cetak(jproduk_id_for_cetak);
				cetak=0;
			}
			
		}
		/*Status Tunggu utk Kasir, jika status Tunggu dan di klik Edit dan yg login adalah kasir/apoteker maka Stat Dok akan di disable, dan status_terima akan di enable */
		if(mutasi_post2db=="UPDATE" && master_mutasiListEditorGrid.getSelectionModel().getSelected().get('mutasi_status')=="Tunggu"){
			mutasi_idField.setDisabled(true);
			mutasi_noField.setDisabled(true);
			mutasi_asalField.setDisabled(true);
			mutasi_tujuanField.setDisabled(true);
			mutasi_tanggalField.setDisabled(true);
			mutasi_keteranganField.setDisabled(true);
			mutasi_kategori_barang_keluarField.setDisabled(true);
			//mutasi_statusField.setDisabled(true);
			//detail_mutasiListEditorGrid.setDisabled(true);
			//mutasi_produkjadiField.setDisabled(true);
			//mutasi_satuan_produkjadiField.setDisabled(true);
			//mutasi_produkjadi_jumlahField.setDisabled(true);
			
			detail_mutasiListEditorGrid.dmutasi_add.disable();
			detail_mutasiListEditorGrid.dmutasi_delete.disable();
			combo_mutasi_produk.setDisabled(true);
			combo_mutasi_satuan.setDisabled(true);
			djumlah_mutasiField.setDisabled(true);
			mutasi_button_saveprintField.setDisabled(true);
			mutasi_button_saveField.setDisabled(false);
			mutasi_spbField.setDisabled(true);
			mutasi_barang_keluarField.setDisabled(true);
			if(cetak==1){
				cetak=0;
			}
			/*Jika Gudang Tujuan sama dengan user login yg bersangkutan, maka Stat Dok akan di disable, sehingga hanya bisa meengconfirm status terima */
		if((master_mutasiListEditorGrid.getSelectionModel().getSelected().get('mutasi_tujuan')=="Gudang Retail" && (group_id == 4 || group_id == 23)) || (master_mutasiListEditorGrid.getSelectionModel().getSelected().get('mutasi_tujuan')=="Gudang Besar" && (group_id == 23 || group_id == 4)) || (master_mutasiListEditorGrid.getSelectionModel().getSelected().get('mutasi_tujuan')=="Kabin Terapis" && group_id == 7) || (master_mutasiListEditorGrid.getSelectionModel().getSelected().get('mutasi_tujuan')=="Kabin Suster" && group_id == 12) ){
			mutasi_status_terimaField.setDisabled(false);
			mutasi_statusField.setDisabled(true);
		}
			/*Jika Gudang Asal sama dgn user login yg bersangkutan, maka stat terima akan di disable, sehingga harus menunggu user dr gudang tujuan utk mengconfirm */
		else if((master_mutasiListEditorGrid.getSelectionModel().getSelected().get('mutasi_asal')=="Gudang Retail" && (group_id == 4 || group_id == 23)) || (master_mutasiListEditorGrid.getSelectionModel().getSelected().get('mutasi_asal')=="Gudang Besar" && (group_id == 23 || group_id == 4)) || (master_mutasiListEditorGrid.getSelectionModel().getSelected().get('mutasi_asal')=="Kabin Terapis" && group_id == 7) || (master_mutasiListEditorGrid.getSelectionModel().getSelected().get('mutasi_asal')=="Kabin Suster" && group_id == 12) ){
			mutasi_status_terimaField.setDisabled(true);
			mutasi_statusField.setDisabled(false);
		}
		else
		{
			mutasi_status_terimaField.setDisabled(false);
			mutasi_statusField.setDisabled(false);
		}
		}
		
		if(mutasi_post2db=="UPDATE" && master_mutasiListEditorGrid.getSelectionModel().getSelected().get('mutasi_status')=="Batal"){
			mutasi_idField.setDisabled(true);
			mutasi_noField.setDisabled(true);
			mutasi_asalField.setDisabled(true);
			mutasi_tujuanField.setDisabled(true);
			mutasi_tanggalField.setDisabled(true);
			mutasi_keteranganField.setDisabled(true);
			mutasi_kategori_barang_keluarField.setDisabled(true);
			mutasi_statusField.setDisabled(true);
			mutasi_status_terimaField.setDisabled(true);
			mutasi_button_saveprintField.setDisabled(true);
			mutasi_button_saveField.setDisabled(true);
			//detail_mutasiListEditorGrid.setDisabled(true);
			detail_mutasiListEditorGrid.dmutasi_add.disable();
			detail_mutasiListEditorGrid.dmutasi_delete.disable();
			combo_mutasi_produk.setDisabled(true);
			combo_mutasi_satuan.setDisabled(true);
			djumlah_mutasiField.setDisabled(true);
			mutasi_spbField.setDisabled(true);
			mutasi_barang_keluarField.setDisabled(true);
			
		}
		
		
	mutasi_statusField.on("select",function(){
		var status_awal = master_mutasiListEditorGrid.getSelectionModel().getSelected().get('mutasi_status');
		if(status_awal =='Terbuka' && mutasi_statusField.getValue()=='Tertutup')
		{
		Ext.MessageBox.show({
			msg: 'Dokumen hanya bisa Tertutup jika Status Terima menjadi Diterima',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		mutasi_statusField.setValue('Terbuka');
		}
		
		else if(status_awal =='Tertutup' && mutasi_statusField.getValue()=='Terbuka')
		{
		Ext.MessageBox.show({
			msg: 'Status yang sudah Tertutup tidak dapat diganti Terbuka',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		mutasi_statusField.setValue('Tertutup');
		}
		
		else if(status_awal =='Batal' && mutasi_statusField.getValue()=='Terbuka')
		{
		Ext.MessageBox.show({
			msg: 'Status yang sudah Tertutup tidak dapat diganti Terbuka',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		mutasi_statusField.setValue('Tertutup');
		}
		
		else if(mutasi_statusField.getValue()=='Batal')
		{
		Ext.MessageBox.confirm('Confirmation','Anda yakin untuk membatalkan dokumen ini? Pembatalan dokumen tidak bisa dikembalikan lagi', mutasi_status_batal);
		}
        
       else if(status_awal =='Tertutup' && mutasi_statusField.getValue()=='Tertutup'){
            <?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_TERIMA'))){ ?>
			master_mutasi_createForm.tbeli_savePrint.enable();
			<?php } ?>
        }
		/* Peringatan utk merubah dari terbuka menjadi Tunggu*/
		else if(status_awal =='Terbuka' && mutasi_statusField.getValue()=='Tunggu')
		{
		Ext.MessageBox.show({
			msg: 'Lakukan Save and Print untuk merubah status menjadi Tunggu',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		mutasi_statusField.setValue('Terbuka');
		}
		else if(status_awal =='Tertutup' && mutasi_statusField.getValue()=='Tunggu')
		{
		Ext.MessageBox.show({
			msg: 'Status yang sudah Tertutup tidak dapat diganti menjadi Tunggu',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		mutasi_statusField.setValue('Tertutup');
		}
		else if(status_awal =='Tunggu' && mutasi_statusField.getValue()=='Tertutup')
		{
		Ext.MessageBox.show({
			msg: 'Dokumen hanya bisa Tertutup jika Status Terima menjadi Diterima (sudah diterima oleh user yang bersangkutan)',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		mutasi_statusField.setValue('Tunggu');
		}
		else if(status_awal =='Tunggu' && mutasi_statusField.getValue()=='Terbuka')
		{
		Ext.MessageBox.show({
			msg: 'Status yang sudah Tunggu tidak dapat dikembalikan menjadi Terbuka',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		mutasi_statusField.setValue('Tunggu');
		}
		
		});	
		
	}
	/* End setValue to EDIT*/
	
	function mutasi_status_batal(btn){
	if(btn=='yes')
	{
		mutasi_statusField.setValue('Batal');
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_MUTASI'))){ ?>
       // master_mutasi_createForm.mmutasi_savePrint.disable();
		<?php } ?>
	}  
	else
		mutasi_statusField.setValue(master_mutasiListEditorGrid.getSelectionModel().getSelected().get('mutasi_status'));
	}
  
	/* Function for Check if the form is valid */
	function is_master_mutasi_form_valid(){
		return ( mutasi_asalField.isValid() && mutasi_tujuanField.isValid() && mutasi_asalField.getValue()!==mutasi_tujuanField.getValue() );
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!master_mutasi_createWindow.isVisible()){
			mutasi_post2db='CREATE';
			msg='created';
			master_mutasi_reset_form();
			master_mutasi_createWindow.show();
		} else {
			master_mutasi_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function master_mutasi_confirm_delete(){
		// only one master_mutasi is selected here
		if(master_mutasiListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', master_mutasi_delete);
		} else if(master_mutasiListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', master_mutasi_delete);
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
  	/* End of Function */
  
	/*Function  for Print Only*/
	function mb_print_only(){
		if(mutasi_idField.getValue()==''){
			Ext.MessageBox.show({
			msg: 'Faktur MB tidak dapat dicetak, karena data kosong',
			buttons: Ext.MessageBox.OK,
			animEl: 'save',
			icon: Ext.MessageBox.WARNING
		   });
		}
		else{
			var mutasi_id = mutasi_idField.getValue();
			cetak=1;
			printonly=1;
			
			master_mutasi_print_faktur(mutasi_id);
			Ext.MessageBox.show({
				title: 'INFO',
				msg: 'Data berhasil di cetak kembali',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.INFO
			});
			//master_mutasi_create('print');
			master_mutasi_DataStore.reload();
			master_mutasi_createWindow.hide();
		}

		//jproduk_btn_cancel();
	}
  
  
	/* Function for Update Confirm */
	function master_mutasi_confirm_update(){
		master_mutasi_reset_form();
		/* only one record is selected here */
		if(master_mutasiListEditorGrid.selModel.getCount() == 1) {
			mutasi_post2db='UPDATE';
			msg='updated';
			master_mutasi_set_form();
			master_mutasi_createWindow.show();
			Ext.MessageBox.show({
			   msg: 'Sedang memuat data, mohon tunggu...',
			   progressText: 'proses...',
			   width:350,
			   wait:true
			});
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Anda belum memilih datang yang akan diubah',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
  
  	/* Function for Delete Record */
	function master_mutasi_delete(btn){
		if(btn=='yes'){
			var selections = master_mutasiListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< master_mutasiListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.mutasi_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Mohon tunggu...',
				url: 'index.php?c=c_master_mutasi&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							master_mutasi_DataStore.reload();
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
	master_mutasi_DataStore = new Ext.data.Store({
		id: 'master_mutasi_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_mutasi&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start: 0, limit: pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'mutasi_id'
		},[
			{name: 'mutasi_id', type: 'int', mapping: 'mutasi_id'}, 
			{name: 'mutasi_no', type: 'string', mapping: 'mutasi_no'}, 
			{name: 'mutasi_spb', type: 'string', mapping: 'mutasi_spb'}, 
			{name: 'mutasi_barang_keluar', type: 'int', mapping: 'mutasi_barang_keluar'},
			{name: 'mutasi_kategori_barang_keluar', type: 'int', mapping: 'mutasi_kategori_barang_keluar'},
			{name: 'kbk_nama', type: 'string', mapping: 'kbk_nama'}, 
			{name: 'mutasi_racikan', type: 'int', mapping: 'mutasi_racikan'}, 
			{name: 'dmracikan_jenis', type: 'int', mapping: 'dmracikan_jenis'}, 
			{name: 'mutasi_asal', type: 'string', mapping: 'gudang_asal_nama'}, 
			{name: 'mutasi_asal_id', type: 'int', mapping: 'mutasi_asal'}, 
			{name: 'mutasi_tujuan', type: 'string', mapping: 'gudang_tujuan_nama'},
			{name: 'mutasi_tujuan_id', type: 'string', mapping: 'mutasi_tujuan'},
			{name: 'mutasi_jumlah', type: 'float', mapping: 'jumlah_barang'}, 
			{name: 'mutasi_tanggal', type: 'date', dateFormat: 'Y-m-d', mapping: 'mutasi_tanggal'}, 
			{name: 'mutasi_keterangan', type: 'string', mapping: 'mutasi_keterangan'}, 
			{name: 'mutasi_status', type: 'string', mapping: 'mutasi_status'}, 
			{name: 'mutasi_status_terima', type: 'string', mapping: 'mutasi_status_terima'}, 
			{name: 'mutasi_creator', type: 'string', mapping: 'mutasi_creator'}, 
			{name: 'mutasi_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'mutasi_date_create'}, 
			{name: 'mutasi_update', type: 'string', mapping: 'mutasi_update'}, 
			{name: 'mutasi_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'mutasi_date_update'}, 
			{name: 'mutasi_revised', type: 'int', mapping: 'mutasi_revised'} 
		]),
		sortInfo:{field: 'mutasi_id', direction: "DESC"}
	});
	/* End of Function */
	
	/* Data store utk auto insert ke Detail Item Mutasi melalui No Ref*/
	var cbo_mutasi_noref_detail_DataStore=new Ext.data.Store({
		id: 'cbo_mutasi_noref_detail_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_mutasi&m=get_detail_item_by_noref',
			method: 'POST'
		}),
		baseParams:{task: "LIST"},
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: ''
		},[
			{name: 'dmracikan_id', type: 'int', mapping: 'dmracikan_id'},
			{name: 'dmutasi_produk', type: 'int', mapping: 'dmracikan_produk'},
			{name: 'dmutasi_satuan', type: 'int', mapping: 'dmracikan_satuan'},
			{name: 'dmutasi_jumlah', type: 'float', mapping: 'dmracikan_jumlah'},
			{name: 'dorder_stok_akhir', type: 'float', mapping: 'dorder_stok_akhir'}
			
		]),
		sortInfo:{field: 'dmutasi_produk', direction: "ASC"}
	});
	
	
	/* Function for Retrieve Gudang Awal DataStore, gudang ini hanya menampilkan list gudang pada user yang bersangkutan */
	cbo_mutasi_gudang_DataSore = new Ext.data.Store({
		id: 'cbo_mutasi_gudang_DataSore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_mutasi&m=get_gudang_list', 
			method: 'POST'
		}),
		baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'gudang_id'
		},[
			{name: 'mutasi_gudang_value', type: 'int', mapping: 'gudang_id'},
			{name: 'mutasi_gudang_nama', type: 'string', mapping: 'gudang_nama'}
		]),
		sortInfo:{field: 'mutasi_gudang_nama', direction: "ASC"}
	});
	
	/* Function for Retrieve Kategori Barang Keluar DataStore*/
	cbo_kategoribarangkeluar_DataSore = new Ext.data.Store({
		id: 'cbo_kategoribarangkeluar_DataSore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_mutasi&m=get_kategori_barang_keluar_list', 
			method: 'POST'
		}),
		baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'kbk_id'
		},[
			{name: 'kbk_id', type: 'int', mapping: 'kbk_id'},
			{name: 'kbk_nama', type: 'string', mapping: 'kbk_nama'}
		]),
		sortInfo:{field: 'kbk_nama', direction: "ASC"}
	});
	
	/* Function for Store utk Gudang Tujuan, dimana ini menampilkan semua Gudang */
	cbo_mutasi_gudang_all_DataStore = new Ext.data.Store({
		id: 'cbo_mutasi_gudang_all_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_mutasi&m=get_gudang_all_list', 
			method: 'POST'
		}),
		baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'gudang_id'
		},[
			{name: 'mutasi_gudang_value', type: 'int', mapping: 'gudang_id'},
			{name: 'mutasi_gudang_nama', type: 'string', mapping: 'gudang_nama'}
		]),
		sortInfo:{field: 'mutasi_gudang_nama', direction: "ASC"}
	});
	
	/* Function utk Produk Jadi DataStore */
	cbo_mutasi_produkjadi_DataSore = new Ext.data.Store({
		id: 'cbo_mutasi_produkjadi_DataSore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_mutasi&m=get_produk_jadi_list', 
			method: 'POST'
		}),
		baseParams:{master_id :0 , aktif: 'yes', task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'produk_id'
		},[
			{name: 'produk_jadi_value', type: 'int', mapping: 'produk_id'},
			{name: 'produk_jadi_nama', type: 'string', mapping: 'produk_nama'}
		]),
		sortInfo:{field: 'produk_jadi_nama', direction: "ASC"}
	});
	
	var produk_jadi_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{produk_jadi_nama} ({produk_jadi_kode})</b><br /></span>',
        '</div></tpl>'
    );
	
	/*DataStore utk satuan yang di columnModel */
	cbo_mutasi_satuanDataStore = new Ext.data.Store({
		id: 'cbo_mutasi_satuanDataStore ',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_mutasi&m=get_satuan_list', 
			method: 'POST'
		}),baseParams: {start:0,limit:pageS, task:'all'},
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'mutasi_satuan_id'
		},[
			{name: 'mutasi_satuan_id', type: 'int', mapping: 'satuan_id'},
			{name: 'satuan_kode', type: 'string', mapping: 'satuan_kode'},
			{name: 'mutasi_satuan_nama', type: 'string', mapping: 'satuan_nama'}
		]),
		sortInfo:{field: 'mutasi_satuan_nama', direction: "ASC"}
		
	});
    
	/*DatasTore khusus utk Racikan */
	cbo_mracikan_satuanDataStore = new Ext.data.Store({
		id: 'cbo_mracikan_satuanDataStore ',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_mutasi&m=get_satuan_racikan_list', 
			method: 'POST'
		}),
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'satuan_id'
		},[
			{name: 'satuan_id', type: 'int', mapping: 'satuan_id'},
			{name: 'satuan_kode', type: 'string', mapping: 'satuan_kode'},
			{name: 'satuan_nama', type: 'string', mapping: 'satuan_nama'}
		]),
		sortInfo:{field: 'satuan_kode', direction: "ASC"}
	});
	
	
	/* Function for browse No Ref DataStore */
	cbo_racikan_noref_DataSore = new Ext.data.Store({
		id: 'cbo_racikan_noref_DataSore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_mutasi&m=get_racikan_noref_list', 
			method: 'POST'
		}),
		baseParams:{start: 0, limit:pageS }, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'
			//id: 'dmracikan_noref'
		},[
			{name: 'mutasi_id', type: 'int', mapping: 'mutasi_id'},
			{name: 'dmracikan_noref', type: 'int', mapping: 'dmracikan_noref'},
			{name: 'racikan_masuk_mb', type: 'string', mapping: 'mutasi_no'},
			{name: 'produk_nama', type: 'string', mapping: 'produk_nama'},
			{name: 'racikan_masuk_jumlah', type: 'string', mapping: 'dmracikan_jumlah'},
			{name: 'racikan_masuk_satuan', type: 'string', mapping: 'satuan_nama'},
			{name: 'racikan_masuk_keterangan', type: 'string', mapping: 'mutasi_keterangan'}
		]),
		sortInfo:{field: 'racikan_masuk_mb', direction: "ASC"}
	});
	
	var racikan_noref_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{racikan_masuk_mb}</b><br /></span>',
        '</div></tpl>'
    );
	
	/*DataStore utk ngambil stok akhir suatu produk */
	mutasi_stok_byprodukDataStore= new Ext.data.Store({
		id: 'mutasi_stok_byprodukDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_mutasi&m=get_stok_akhir_mutasi', 
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
			{name: 'satuan_terkecil', type: 'int', mapping: 'satuan_terkecil'},
			{name: 'produk_stok', type: 'float', mapping: 'stok_akhir'},
			{name: 'harga', type: 'float', mapping: 'harga'}
		]),
		sortInfo:{field: 'produk_id', direction: "ASC"}
	});
	
	
  	/* Function for Identify of Window Column Model */
	master_mutasi_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: '<div align="center">' + 'No MB' + '</div>',
			dataIndex: 'mutasi_no',
			width: 100,	//150,
			sortable: true,
			readOnly: true
		}, 
		
		{
			header: '<div align="center">Tanggal</div>',
			dataIndex: 'mutasi_tanggal',
			width: 60,	//150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			readOnly: true
		},
		{
			header: '<div align="center">Gudang Asal</div>',
			dataIndex: 'mutasi_asal',
			width: 100,
			sortable: true,
			readOnly: true
		}, 
		{
			header: '<div align="center">Gudang Tujuan</div>',
			dataIndex: 'mutasi_tujuan',
			width: 100,
			sortable: true,
			readOnly: true
		}, 
		/*
		{
			header: '<div align="center">Jml Barang</div>',
			dataIndex: 'mutasi_jumlah',
			width: 60,
			align: 'right',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			sortable: true,
			readOnly: true
		}, 
		*/
		{
			header: '<div align="center">Keterangan</div>',
			dataIndex: 'mutasi_keterangan',
			width: 200,	//150,
			sortable: true,
			readOnly: true
		}, 
		{
			header: '<div align="center">' + 'Stat Dok' + '</div>',
			dataIndex: 'mutasi_status',
			width: 60,
			readOnly: true
		}, 
		/*
		{
			header: '<div align="center">' + 'Stat Terima' + '</div>',
			dataIndex: 'mutasi_status_terima',
			width: 60,
			readOnly: true
		}, 
		*/
		{
			header: '<div align="center">' + 'Mutasi Racikan' + '</div>',
			dataIndex: 'mutasi_racikan',
			width: 10,
			hidden : true,
			readOnly: true
		}, 
		{
			header: '<div align="center">' + 'Racikan Jenis' + '</div>',
			dataIndex: 'dmracikan_jenis',
			width: 10,
			hidden : true,
			readOnly: true
		}, 
		{
			header: '<div align="center">' + 'Mutasi Barang Keluar' + '</div>',
			dataIndex: 'mutasi_barang_keluar',
			width: 10,
			hidden : true,
			readOnly: true
		}, 
		{
			header: '<div align="center">' + 'Mutasi Kategori Barang Keluar' + '</div>',
			dataIndex: 'mutasi_kategori_barang_keluar',
			width: 10,
			hidden : true,
			readOnly: true
		}, 
		{
			header: 'Creator',
			dataIndex: 'mutasi_creator',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Create on',
			dataIndex: 'mutasi_date_create',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Last Update by',
			dataIndex: 'mutasi_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'last Update on',
			dataIndex: 'mutasi_date_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Revised',
			dataIndex: 'mutasi_revised',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}	]);
	
	master_mutasi_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	master_mutasiListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'master_mutasiListEditorGrid',
		el: 'fp_master_mutasi',
		title: 'Daftar Mutasi Barang',
		autoHeight: true,
		store: master_mutasi_DataStore, // DataStore
		cm: master_mutasi_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1220,	//700,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: master_mutasi_DataStore,
			displayInfo: true
		}),
		/* Add Control on ToolBar */
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_MUTASI'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<?php } ?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_MUTASI'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: master_mutasi_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_MUTASI'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			disabled : true,
			handler: master_mutasi_confirm_delete   // Confirm before deleting
		}, '-', 
		<?php } ?>
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: master_mutasi_DataStore,
			params: {start: 0, limit: pageS},
			listeners:{
/*				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						customer_DataStore.baseParams={task:'LIST',start: 0, limit: pageS};
		            }
				},
*/				render: function(c){
				Ext.get(this.id).set({qtitle:'Simple search:'});
				Ext.get(this.id).set({qtip:'- No MB<br>- Gudang Asal<br>- Gudang Tujuan<br>- Keterangan'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: master_mutasi_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: master_mutasi_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: master_mutasi_print  
		}
		]
	});
	master_mutasiListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	master_mutasi_ContextMenu = new Ext.menu.Menu({
		id: 'master_mutasi_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_MUTASI'))){ ?>
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: master_mutasi_confirm_update  
		},
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_MUTASI'))){ ?>
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			disabled : true,
			handler: master_mutasi_confirm_delete 
		},
		<?php } ?>
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: master_mutasi_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: master_mutasi_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onmaster_mutasi_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		master_mutasi_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		master_mutasi_SelectedRow=rowIndex;
		master_mutasi_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function master_mutasi_editContextMenu(){
		master_mutasi_confirm_update()
		//master_mutasiListEditorGrid.startEditing(master_mutasi_SelectedRow,1);
  	}
	/* End of Function */
  	
	mutasi_no_temp= new Ext.form.TextField({
		id: 'mutasi_no_temp',
		maxLength: 50,
		anchor: '95%'
	});
	
	/* Identify  dmracikan_jenis Field */
	dmracikan_jenisField= new Ext.form.NumberField({
		id: 'dmracikan_jenisField',
		allowNegatife : false,
		//blankText: '0',
		allowBlank: false,
		allowDecimals: false,
		hidden: true,
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	/* Identify  mutasi_id Field */
	mutasi_idField= new Ext.form.NumberField({
		id: 'mutasi_idField',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: false,
		hidden: true,
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify mutasi_no Field*/
	mutasi_noField= new Ext.form.TextField({
		id: 'mutasi_noField',
		fieldLabel: 'No MB',
		emptyText: '(Auto)',
		readOnly: true,
		maxLength: 50,
		anchor: '95%'
	});
	
	/* Identify mutasi_spb Field*/
	mutasi_spbField= new Ext.form.TextField({
		id: 'mutasi_spbField',
		fieldLabel: 'No SMB',
		emptyText: '(Manual Input)',
		//readOnly: true,
		maxLength: 50,
		anchor: '95%'
	});
	
	/*Identify Barang Keluar checkField */
	mutasi_barang_keluarField=new Ext.form.Checkbox({
		id : 'mutasi_barang_keluarField',
		boxLabel: 'Barang Keluar',
		name: 'mutasi_barang_keluar',
		tooltip : 'Jika ini dicentang, maka Mutasi Barang hanya akan mengurangi Gudang Asal saja (tanpa menambah ke Gudang Tujuan)',
		anchor : '95%',
		handler: function(node,checked){
			if (checked) {
				mutasi_tujuanField.reset();
				mutasi_tujuanField.setValue(null);
				mutasi_tujuanField.setDisabled(true);
				//mutasi_kategori_barang_keluarField.setVisible(true);
				mutasi_kategori_barang_keluarField.setDisabled(false);
				//mutasi_kategori_barang_keluarField.hideLabel(false);
				//detail_mutasi_produk_jadiListEditorGrid.setDisabled(false);
				//mutasi_tujuanField.isValid(false);
			}
			else {
				mutasi_tujuanField.setDisabled(false);
				//mutasi_kategori_barang_keluarField.setVisible(false)
				mutasi_kategori_barang_keluarField.setDisabled(true);
				//detail_mutasi_produk_jadiListEditorGrid.setDisabled(true);
			}
		}
	});

	/*Identify Barang Masuk checkField */
	mutasi_barang_masukField=new Ext.form.Checkbox({
		id : 'mutasi_barang_masukField',
		boxLabel: 'Barang Masuk',
		name: 'mutasi_barang_masuk',
		tooltip : 'Jika ini dicentang, maka Mutasi Barang hanya akan menambah Gudang Tujuan saja (tanpa mengurangi dari Gudang Asal)',
		anchor : '95%',
		handler: function(node,checked){
			if (checked) {
				// mutasi_tujuanField.reset();
				// mutasi_tujuanField.setValue(null);
				// mutasi_tujuanField.setDisabled(true);
				// mutasi_kategori_barang_keluarField.setDisabled(false);
			}
			else {
				// mutasi_tujuanField.setDisabled(false);
				// mutasi_kategori_barang_keluarField.setDisabled(true);
			}
		}
	});
	
	mutasi_produkjadi_labelField=new Ext.form.Label({ html: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Produk Jadi &nbsp; : &nbsp;'});
	mutasi_produkjadi_jumlah_labelField=new Ext.form.Label({ html: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Jumlah &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;'});
	mutasi_produkjadi_satuan_labelField=new Ext.form.Label({ html: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Satuan &nbsp; : &nbsp;'});
	mutasi_noref_labelField=new Ext.form.Label({ html: '&nbsp;&nbsp;&nbsp; No Ref &nbsp; : &nbsp;'});
	

	// field utk nyimpan stok akhir
	var mutasi_stok_akhirField=new Ext.form.NumberField({
		allowDecimals: true,
		allowNegative: true,
		blankText: '0',
		maxLength: 11,
		readOnly: true,
		maskRe: /([0-9.]+)$/
	});
	
	/* Identify  Produk Jadi Field */
	mutasi_produkjadiField=new Ext.form.ComboBox({
		store: cbo_mutasi_produkjadi_DataSore,
		mode: 'remote',
		displayField: 'produk_jadi_nama',
		valueField: 'produk_jadi_value',
		typeAhead: false,
		loadingText: 'Searching...',
		pageSize:pageS,
		hideTrigger:false,
		tpl: produk_jadi_tpl,
		//applyTo: 'search',
		//applyTo: 'search',
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		width : 220
		//anchor: '100%'
	});
	
	/*Identify Produk Jadi Jumlah field */
	mutasi_produkjadi_jumlahField= new Ext.form.NumberField({
		id: 'mutasi_produkjadi_jumlahField',
		//name: 'setcrm_disiplin_telat_value_morethan',
		fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:bold"> >= </span>',
		allowNegatife : false,
		//blankText: '15',
		allowDecimals: false,
		//store : detail_mutasi_racikanDataStore,
		//dataIndex : 'dmracikan_jumlah',
		width : 60,
		//anchor: '35%',
		maskRe: /([0-9]+)$/
	});
	
	/* Identify Produk Jadi Satuan Field*/
	var mutasi_satuan_produkjadiField=new Ext.form.ComboBox({
			store: cbo_mracikan_satuanDataStore ,
			mode: 'remote',
			typeAhead: true,
			displayField: 'satuan_nama',
			valueField: 'satuan_id',
			triggerAction: 'all',
			lazyRender:true,
			allowBlank : false,
			width : 75
			//anchor : '50%'
	});
	
	/* Identify  No. Ref Field */
	mutasi_norefField= new Ext.form.ComboBox({
		//id: 'mutasi_norefField',
		tooltip : 'No Ref ini adalah browse Produk Jadi yang sudah selesai dibuat dan status nya Tertutup',
		//fieldLabel: 'Produk Jadi',
		store: cbo_racikan_noref_DataSore,
		mode : 'remote',
		//forceSelection: true,
		displayField:'racikan_masuk_mb',
		valueField: 'mutasi_id',
        typeAhead: false,
        hideTrigger:false,
		allowBlank: false,
		triggerAction: 'all',
		itemSelector: 'div.search-item',
		lazyRender:true,
		tpl : racikan_noref_tpl,
		listClass: 'x-combo-list-small',
		anchor: '100%'
		
	});
	
	/* Identify  mutasi_asal Field */
	mutasi_asalField= new Ext.form.ComboBox({
		id: 'mutasi_asalField',
		fieldLabel: 'Gudang Asal',
		store: cbo_mutasi_gudang_DataSore,
		mode : 'remote',
		forceSelection: true,
		displayField:'mutasi_gudang_nama',
		valueField: 'mutasi_gudang_value',
        typeAhead: false,
        hideTrigger:false,
		allowBlank: false,
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});
	
	/* Identify  mutasi_tujuan Field */
	mutasi_tujuanField= new Ext.form.ComboBox({
		id: 'mutasi_tujuanField',
		fieldLabel: 'Gudang Tujuan',
		store: cbo_mutasi_gudang_all_DataStore,
		mode : 'remote',
		forceSelection: true,
		displayField:'mutasi_gudang_nama',
		valueField: 'mutasi_gudang_value',
        typeAhead: false,
        hideTrigger:false,
		allowBlank: false,
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});
	/* Identify  mutasi_tanggal Field */
	mutasi_tanggalField= new Ext.form.DateField({
		id: 'mutasi_tanggalField',
		fieldLabel: 'Tanggal',
		format : 'd-m-Y'
	});
	/* Identify  mutasi_keterangan Field */
	mutasi_keteranganField= new Ext.form.TextArea({
		id: 'mutasi_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 500,
		anchor: '95%'
	});
	
	/* Identify  mutasi_kategori_barang_keluarField Field */
	mutasi_kategori_barang_keluarField= new Ext.form.ComboBox({
		id: 'mutasi_kategori_barang_keluarField',
		fieldLabel : 'Kategori Barang Keluar/Masuk',
		//hideLabel : true,
		store: cbo_kategoribarangkeluar_DataSore,
		mode : 'remote',
		forceSelection: true,
		displayField:'kbk_nama',
		valueField: 'kbk_id',
        typeAhead: false,
        hideTrigger:false,
		allowBlank: true,
		triggerAction: 'all',
		lazyRender:true,
		disabled : true,
		hidden : false,
		listClass: 'x-combo-list-small',
		anchor: '75%'
	});
	
	/* Identify  Jumlah Total Barang Field */
	mutasi_totaljumlahField= new Ext.form.TextField({
		id: 'mutasi_totaljumlahField',
		fieldLabel: 'Jumlah Total Barang',
		blankText: '0',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		readOnly: true,
		anchor: '75%',
	});
	
	/* Identify  Jumlah total barang untuk Produk Jadi Field */
	produk_jadi_totaljumlahField= new Ext.form.TextField({
		id: 'produk_jadi_totaljumlahField',
		fieldLabel: 'Jumlah Total Produk Jadi',
		blankText: '0',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		readOnly: true,
		anchor: '75%',
	});
	
	mutasi_button_saveField=new Ext.Button({
		text: 'Save and Close',
		ref : '../mmutasi_saveClose',
		handler: pengecekan_dokumen_saveclose
	});
	
	mutasi_button_saveprintField=new Ext.Button({
		text: 'Save and Print',
		ref: '../mmutasi_savePrint',
		handler: pengecekan_dokumen
	});


	mutasi_itemjumlahField= new Ext.form.TextField({
		id: 'mutasi_itemjumlahField',
		fieldLabel: 'Jumlah Jenis Barang',
		blankText: '0',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		readOnly: true,
		anchor: '75%',
	});
	/*Identify Jenis Item utk Produk Jadi */
	produk_jadi_itemjumlahField= new Ext.form.TextField({
		id: 'produk_jadi_itemjumlahField',
		fieldLabel: 'Jumlah Jenis Produk Jadi',
		blankText: '0',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		readOnly: true,
		anchor: '75%',
	});
	
	mutasi_statusField= new Ext.form.ComboBox({
		id: 'mutasi_statusField',
		fieldLabel: 'Status Dok',
		forceSelection: true,
		store:new Ext.data.SimpleStore({
			fields:['mutasi_status_value', 'mutasi_status_display'],
			data:[['Terbuka','Terbuka'],['Tertutup','Tertutup'],['Batal', 'Batal'],['Tunggu','Tunggu']]
		}),
		mode: 'local',
		displayField: 'mutasi_status_display',
		valueField: 'mutasi_status_value',
		anchor: '80%',
		allowBlank: false,
		triggerAction: 'all'	
	});
	
	/*Field mutasi_status_terimaField */
	mutasi_status_terimaField= new Ext.form.ComboBox({
		id: 'mutasi_status_terimaField',
		fieldLabel: 'Status Terima',
		forceSelection: true,
		store:new Ext.data.SimpleStore({
			fields:['mutasi_status_terima_value', 'mutasi_status_terima_display'],
			data:[['Diterima','Diterima'],['Ditolak','Ditolak'],['Tunggu', 'Tunggu']]
		}),
		mode: 'local',
		displayField: 'mutasi_status_terima_display',
		valueField: 'mutasi_status_terima_value',
		anchor: '80%',
		//disabled : true,
		allowBlank: true,
		triggerAction: 'all'	
	});
	
	/*Identify Racikan title checkField */
	mutasi_barang_racikan_title=new Ext.form.Checkbox({
		id : 'mutasi_barang_racikan_title',
		boxLabel: 'Racikan',
		name: 'mutasi_racikan',
		tooltip : 'Khusus untuk produk Racikan',
		anchor : '95%',
		handler: function(node,checked){
			if (checked) {
				mutasi_barang_keluarField.setDisabled(true);
				mutasi_barang_keluarField.setValue(false);
				mutasi_asalField.reset();
				mutasi_asalField.setValue(null);
				mutasi_tujuanField.reset();
				mutasi_tujuanField.setValue(null);
				mutasi_asalField.setDisabled(true);
				mutasi_tujuanField.setDisabled(true);
				mutasi_racikanFieldSet.setDisabled(false);
				mutasi_barang_racikan_keluarField.setValue(true);

			}
			else {
				mutasi_barang_keluarField.setDisabled(false);
				mutasi_barang_keluarField.setValue(false);
				mutasi_asalField.reset();
				mutasi_asalField.setValue(null);
				mutasi_tujuanField.reset();
				mutasi_tujuanField.setValue(null);
				mutasi_asalField.setDisabled(false);
				mutasi_tujuanField.setDisabled(false);
				mutasi_barang_racikan_keluarField.reset()
				mutasi_barang_racikan_keluarField.setValue(null);
				mutasi_barang_racikan_masukField.reset()
				mutasi_barang_racikan_masukField.setValue(null);		
				mutasi_racikanFieldSet.setDisabled(true);
				detail_mutasi_produk_jadiListEditorGrid.setDisabled(true);
				
			}
		}
	});
	
	/*Identify Barang Racikan Keluar checkField */
	mutasi_barang_racikan_keluarField=new Ext.form.Radio({
		id : 'mutasi_barang_racikan_keluarField',
		name:'mutasi_racikanFieldSet',
		boxLabel: 'Keluar',
		//name: 'mutasi_barang_keluar',
		tooltip : 'Jika ini di centang, maka Gudang Asal otomatis diarahkan ke Gudang Retail',
		anchor : '95%',
		value: 'selected',
		handler: function(node,checked){
			if (checked) {
				mutasi_asalField.setValue('Gudang Retail');
				mutasi_asalField.setDisabled(true);
				mutasi_tujuanField.reset();
				mutasi_tujuanField.setValue(null);
				mutasi_tujuanField.setDisabled(true);
				mutasi_barang_racikan_masukField.setValue(false);
				mutasi_norefField.setDisabled(true);
				mutasi_produkjadiField.setDisabled(false);
				mutasi_produkjadi_jumlahField.setDisabled(false);
				mutasi_satuan_produkjadiField.setDisabled(false);
				mutasi_norefField.reset();
				mutasi_norefField.setValue(null);
				detail_mutasi_produk_jadiListEditorGrid.setDisabled(false);
				detail_mutasi_DataStore.removeAll();
				detail_mutasi_DataStore.commitChanges();
				//detail_mutasi_total();
				
			}
		}
	});
	
	/*Identify Barang Racikan Masuk checkField */
	mutasi_barang_racikan_masukField=new Ext.form.Radio({
		id : 'mutasi_barang_racikan_masukField',
		name:'mutasi_racikanFieldSet',
		boxLabel: 'Masuk',
		//name: 'mutasi_barang_keluar',
		tooltip : 'Jika ini di centang, maka Gudang Tujuan otomatis diarahkan ke Gudang Retail',
		anchor : '95%',
		value: 'selected',
		handler: function(node,checked){
			if (checked) {
				mutasi_asalField.reset();
				mutasi_asalField.setValue(null);
				mutasi_asalField.setDisabled(true);
				mutasi_tujuanField.setValue('Gudang Retail');
				mutasi_tujuanField.setDisabled(true);
				mutasi_barang_racikan_masukField.setValue(true);
				mutasi_norefField.setDisabled(false);
				mutasi_produkjadiField.setDisabled(true);
				mutasi_produkjadi_jumlahField.setDisabled(true);
				mutasi_satuan_produkjadiField.setDisabled(true);
				mutasi_produkjadiField.reset();
				mutasi_produkjadiField.setValue();
				mutasi_produkjadi_jumlahField.reset();
				mutasi_produkjadi_jumlahField.setValue(null);
				mutasi_satuan_produkjadiField.reset();
				mutasi_satuan_produkjadiField.setValue(null);
				detail_mutasi_produk_jadiListEditorGrid.setDisabled(true);
				detail_mutasi_produkJadi_DataStore.removeAll();
				detail_mutasi_produkJadi_DataStore.commitChanges();
				//detail_mutasi_DataStore.removeAll();
				//detail_mutasi_DataStore.commitChanges();
				//detail_mutasi_total();
				
			}
			//else {
				//mutasi_barang_racikan_keluarField.setValue(true);
			//}
		}
		
	});
	
	
	var mutasi_racikanFieldSet = new Ext.form.FieldSet({
		//title: 'Tujuan',
		anchor: '100%',
		layout:'column',
		//store : detail_mutasi_racikanDataStore,
		frame: false,
		border: true,
		items:[
				{
					columnWidth:1,
					layout: 'column',
					border:false,
					items: [mutasi_barang_racikan_keluarField, {xtype: 'spacer',height:10},{xtype: 'spacer',width:1000}, mutasi_barang_racikan_masukField,mutasi_noref_labelField,mutasi_norefField] 
				}
				
				/*
				{
					columnWidth:0.8,
					layout: 'column',
					border:false,
					//labelWidth : 1,
					items: [mutasi_produkjadi_labelField,mutasi_produkjadiField,{ html: '<br> <br>'}, mutasi_produkjadi_jumlah_labelField,mutasi_produkjadi_jumlahField,mutasi_produkjadi_satuan_labelField,mutasi_satuan_produkjadiField, { html: '<br> <br><br> <br> <br><br><br><br>'}, mutasi_noref_labelField,{ html: '<br> <br><br> <br> <br><br><br><br>'},mutasi_norefField] 
				}
				*/
				
	
		   ]
	});
	
  	/*Fieldset Master*/
	master_mutasi_masterGroup = new Ext.form.FieldSet({
		// title: 'Master',
		autoHeight: true,
		// collapsible: true,
		layout:'column',
		items:[
			{
				columnWidth:0.4,
				layout: 'form',
				border:false,
				items: [mutasi_tanggalField,mutasi_noField/*, mutasi_spbField*/, mutasi_asalField, mutasi_tujuanField, mutasi_kategori_barang_keluarField,  mutasi_idField,mutasi_keteranganField,mutasi_statusField/*, mutasi_status_terimaField*/] 
			},
			{
				columnWidth:0.2,
				layout: 'form',
				border:false,
				labelWidth: 1,
				items: [{xtype: 'spacer',height:110},mutasi_barang_keluarField, mutasi_barang_masukField] 
			}
			/*
			{
				columnWidth:0.4,
				layout: 'form',
				border:false,
				labelWidth : 1,
				items: [mutasi_barang_racikan_title,mutasi_racikanFieldSet] 
			}
			*/
			]
	
	});
	
	//master_mutasi_FootGroup
	master_mutasi_footGroup = new Ext.form.FieldSet({
		title: '-',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		anchor: '100%',
		labelWidth: 150,
		items: [{
					layout: 'form',
					columnWidth: 0.5,
					border: false,
					items:[mutasi_totaljumlahField]
				},{ 
					layout: 'form',
					columnWidth: 0.5,
					border: false,
					items:[mutasi_itemjumlahField]
				}] 
	
	});
	
		
	/*Detail Declaration */
		
	// Function menampung data mapping ketika list detail mutasi racikan di tampilkan
	var detail_mutasi_racikan_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: 'dmracikan_id'
	},[
			{name: 'dmracikan_id', type: 'int', mapping: 'dmracikan_id'}, 
			{name: 'dmracikan_mutasi_id', type: 'int', mapping: 'dmracikan_mutasi_id'}, 
			{name: 'dmracikan_jenis', type: 'int', mapping: 'dmracikan_jenis'}, 
			{name: 'dmracikan_produk', type: 'int', mapping: 'dmracikan_produk'}, 
			{name: 'dmracikan_jumlah', type: 'int', mapping: 'dmracikan_jumlah'},
			{name: 'dmracikan_satuan', type: 'int', mapping: 'dmracikan_satuan'},
			{name: 'dmracikan_noref', type: 'int', mapping: 'dmracikan_noref'},
			{name: 'produk_nama', type: 'string', mapping: 'produk_nama'},
			{name: 'satuan_nama', type: 'string', mapping: 'satuan_nama'},
			{name: 'mutasi_no', type: 'string', mapping: 'mutasi_no'}			
	]);
	//eof
	
	//function for detail_mutasi_racikan_writer
	var detail_mutasi_racikan_writer = new Ext.data.JsonWriter({
		encode: true,
		writeAllFields: false
	});
	//eof
	
	
	// Function for json reader of detail
	var detail_mutasi_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: ''
	},[
			{name: 'dmutasi_id', type: 'int', mapping: 'dmutasi_id'}, 
			{name: 'dmutasi_master', type: 'int', mapping: 'dmutasi_master'}, 
			{name: 'dmutasi_produk', type: 'int', mapping: 'dmutasi_produk'}, 
			{name: 'dmutasi_satuan', type: 'int', mapping: 'dmutasi_satuan'}, 
			{name: 'dmutasi_jumlah', type: 'int', mapping: 'dmutasi_jumlah'} 
	]);
	//eof
	
	// Function for json reader of detail mutasi produk jadi
	var detail_mutasi_produk_jadi_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: ''
	},[
			{name: 'dmracikan_id', type: 'int', mapping: 'dmracikan_id'}, 
			{name: 'dmracikan_mutasi_id', type: 'int', mapping: 'dmracikan_mutasi_id'}, 
			{name: 'dmracikan_produk', type: 'int', mapping: 'dmracikan_produk'}, 
			{name: 'dmracikan_satuan', type: 'int', mapping: 'dmracikan_satuan'}, 
			{name: 'dmracikan_jumlah', type: 'int', mapping: 'dmracikan_jumlah'},
			{name: 'mutasi_no', type: 'string', mapping: 'mutasi_no'}
	]);
	//eof
	
	//function for json writer of detail
	var detail_mutasi_writer = new Ext.data.JsonWriter({
		encode: true,
		writeAllFields: false
	});
	//eof
	
	//function for json writer of detail mutasi produk jadi
	var detail_mutasi_produk_jadi_writer = new Ext.data.JsonWriter({
		encode: true,
		writeAllFields: false
	});
	//eof
	
	/* Function for Retrieve DataStore of detail*/
	detail_mutasi_DataStore = new Ext.data.Store({
		id: 'detail_mutasi_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_mutasi&m=detail_detail_mutasi_list', 
			method: 'POST'
		}),
		reader: detail_mutasi_reader,
		baseParams:{master_id: 0, start: 0, limit: pageS},
		sortInfo:{field: 'dmutasi_produk', direction: "DESC"}
	});
	/* End of Function */
	
	/* Function for Retrieve DataStore of detail mutasi produk Jadi*/
	detail_mutasi_produkJadi_DataStore = new Ext.data.Store({
		id: 'detail_mutasi_produkJadi_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_mutasi&m=detail_detail_mutasi_produk_jadi_list', 
			method: 'POST'
		}),
		reader: detail_mutasi_produk_jadi_reader,
		baseParams:{master_id: 0, start: 0, limit: pageS, no_ref : 0},
		sortInfo:{field: 'dmracikan_produk', direction: "DESC"}
	});
	/* End of Function */
	
	
	/* Function for Retrieve DataStore of detail*/
	detail_mutasi_racikanDataStore = new Ext.data.Store({
		id: 'detail_mutasi_racikanDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_mutasi&m=detail_detail_mutasi_racikan_list', 
			method: 'POST'
		}),
		reader: detail_mutasi_racikan_reader,
		baseParams:{master_id: 0, start: 0, limit: pageS},
		sortInfo:{field: 'dmracikan_id', direction: "DESC"}
	});
	/* End of Function */
	
	
	//function for editor of detail
	var editor_detail_mutasi= new Ext.ux.grid.RowEditor({
        saveText: 'Update'
    });
	//eof
	
	//function for editor of detail mutasi produk jadi
	var editor_detail_mutasi_produk_jadi= new Ext.ux.grid.RowEditor({
        saveText: 'Update'
    });
	//eof
	
	Ext.util.Format.comboRenderer = function(combo){
		return function(value){
			var record = combo.findRecord(combo.valueField, value);
			return record ? record.get(combo.displayField) : combo.valueNotFoundText;
		}
	}
	
	cbo_mutasi_produkDataStore = new Ext.data.Store({
		id: 'cbo_mutasi_produkDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_mutasi&m=get_produk_list', 
			method: 'POST'
		}),baseParams: {start: 0, limit: pageS, gudang: 0, task: 'list'},
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'produk_id'
		},[
			{name: 'mutasi_produk_id', type: 'int', mapping: 'produk_id'},
			{name: 'mutasi_produk_kode', type: 'string', mapping: 'produk_kode'},
			{name: 'mutasi_produk_nama', type: 'string', mapping: 'produk_nama'},
			{name: 'mutasi_satuan_nama', type: 'string', mapping: 'satuan_nama'},
			{name: 'mutasi_produk_stok', type: 'float', mapping: 'jumlah_stok'}
		]),
		sortInfo:{field: 'mutasi_produk_kode', direction: "ASC"}
	});
	
	var produk_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{mutasi_produk_nama} ({mutasi_produk_kode})</b><br /></span>',
            'stok: {mutasi_produk_stok} {mutasi_satuan_nama}',
        '</div></tpl>'
    );
	
	var combo_mutasi_produk=new Ext.form.ComboBox({
			store: cbo_mutasi_produkDataStore,
			mode: 'remote',
			displayField: 'mutasi_produk_nama',
			valueField: 'mutasi_produk_id',
			typeAhead: false,
			loadingText: 'Searching...',
			pageSize:pageS,
			hideTrigger:false,
			tpl: produk_tpl,
			//applyTo: 'search',
			itemSelector: 'div.search-item',
			triggerAction: 'all',
			lazyRender:true,
			listClass: 'x-combo-list-small',
			anchor: '95%'
	});
	
	/*Identify JumlahField */
	var djumlah_mutasiField = new Ext.form.NumberField({
		allowDecimals: false,
		allowNegative: false,
		maxLength: 11,
		enableKeyEvents: true,
		maskRe: /([0-9]+)$/
	});
	
	var combo_mutasi_satuan=new Ext.form.ComboBox({
			store: cbo_mutasi_satuanDataStore ,
			mode: 'local',
			typeAhead: true,
			displayField: 'mutasi_satuan_nama',
			valueField: 'mutasi_satuan_id',
			triggerAction: 'all',
			lazyRender:true,
			allowBlank : false,
			loadingText: 'Searching...',
			//hideTrigger:false,
			//itemSelector: 'div.search-item',
			//triggerAction: 'all',
			//listClass: 'x-combo-list-small'
			
	});
	
	//declaration of detail coloumn model
	detail_mutasi_ColumnModel = new Ext.grid.ColumnModel(
		[
		 {
			header: '<div align="center">ID</div>',
			dataIndex: 'dmutasi_id',
			width: 80,
			sortable: true,
			readOnly: true,
			hidden: true
		},
		/*
		{
			header: '<div align="center">' + 'Kode Produk' + '</div>',
			dataIndex: 'produk_kode',
			width: 75,	//150,
			sortable: true,
			readOnly: true
		}, 
		*/
		{
			header: '<div align="center">Produk</div>',
			dataIndex: 'dmutasi_produk',
			width: 200,
			sortable: true,
			editor: combo_mutasi_produk,
			renderer: Ext.util.Format.comboRenderer(combo_mutasi_produk)
		},
		{
			header: '<div align="center">Satuan</div>',
			dataIndex: 'dmutasi_satuan',
			width: 80,
			sortable: true,
			editor: combo_mutasi_satuan,
			renderer: Ext.util.Format.comboRenderer(combo_mutasi_satuan)
		},
		{
			header: '<div align="center">Jumlah</div>',
			dataIndex: 'dmutasi_jumlah',
			width: 60,
			sortable: true,
			align: 'right',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			editor : djumlah_mutasiField
			/*
			editor: new Ext.form.NumberField({
				allowDecimals: false,
				allowNegative: false,
				blankText: '0',
				maxLength: 11,
				//ref : '../dmutasi_jumlah',
				maskRe: /([0-9]+)$/
			})
			*/
		},
		{
			header: '<div align="center">' + 'Keterangan' + '</div>',
			align: 'right',
			dataIndex: 'dminta_keterangan',
			width: 200,
			sortable: true
			// editor: dminta_ketField
		},
		/*
		,
		{
			header: '<div align="center">Stok Akhir Tgl MB</div>',
			dataIndex: 'dorder_stok_akhir',
			width: 60,
			align: 'right',
			editor: mutasi_stok_akhirField,
			renderer: Ext.util.Format.numberRenderer('0,000'),
			sortable: true,
			readOnly: true
		}
		*/
		]
	);
	detail_mutasi_ColumnModel.defaultSortable= true;
	//eof
	
	
	
	//declaration of detail list editor grid
	detail_mutasiListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'detail_mutasiListEditorGrid',
		el: 'fp_detail_mutasi',
		title: 'Item Mutasi',
		height: 250,
		width: 1100,	//690,
		autoScroll: true,
		store: detail_mutasi_DataStore, // DataStore
		colModel: detail_mutasi_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 5 5 5',
		plugins: [editor_detail_mutasi],
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true}
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_MUTASI'))){ ?>
		,
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			ref : '../dmutasi_add',
			handler: detail_mutasi_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			ref : '../dmutasi_delete',
			handler: detail_mutasi_confirm_delete
		}
		]
		<?php } ?>
	});
	//eof
	
	
	//function of detail add
	function detail_mutasi_add(){
		var edit_detail_mutasi= new detail_mutasiListEditorGrid.store.recordType({
			dmutasi_id		: 0,
			dmutasi_master	: null,		
			dmutasi_produk	: '',		
			dmutasi_satuan	: '',		
			dmutasi_jumlah	: 0		
		});
		editor_detail_mutasi.stopEditing();
		detail_mutasi_DataStore.insert(0, edit_detail_mutasi);
		//detail_mutasiListEditorGrid.getView().refresh();
		detail_mutasiListEditorGrid.getSelectionModel().selectRow(0);
		editor_detail_mutasi.startEditing(0);
	}
	
	//function for refresh detail
	function refresh_detail_mutasi(){
		detail_mutasi_DataStore.commitChanges();
		detail_mutasiListEditorGrid.getView().refresh();
	}
	//eof
	
	//function for insert detail
	function detail_mutasi_insert(pkid, opsi){
		
		var dmutasi_id = [];
        var dmutasi_produk = [];
        var dmutasi_satuan = [];
        var dmutasi_jumlah = [];

		if(detail_mutasi_DataStore.getCount()>0){
			for(i=0; i<detail_mutasi_DataStore.getCount();i++){
				if((/^\d+$/.test(detail_mutasi_DataStore.getAt(i).data.dmutasi_produk))
				   && detail_mutasi_DataStore.getAt(i).data.dmutasi_produk!==undefined
				   && detail_mutasi_DataStore.getAt(i).data.dmutasi_produk!==''
				   && detail_mutasi_DataStore.getAt(i).data.dmutasi_produk!==0
				   && detail_mutasi_DataStore.getAt(i).data.dmutasi_satuan!==''
				   && detail_mutasi_DataStore.getAt(i).data.dmutasi_jumlah>0){
					
					if((detail_mutasi_DataStore.getAt(i).data.dmutasi_id==undefined) || (detail_mutasi_DataStore.getAt(i).data.dmutasi_id=='')){
						dmutasi_id.push(0);
					}else{
						dmutasi_id.push(detail_mutasi_DataStore.getAt(i).data.dmutasi_id);
					}
					
					//dmutasi_id.push(detail_mutasi_DataStore.getAt(i).data.dmutasi_id);
					dmutasi_produk.push(detail_mutasi_DataStore.getAt(i).data.dmutasi_produk);
					dmutasi_satuan.push(detail_mutasi_DataStore.getAt(i).data.dmutasi_satuan);
					dmutasi_jumlah.push(detail_mutasi_DataStore.getAt(i).data.dmutasi_jumlah);
				}
			}
		}
		
		var encoded_array_dmutasi_id = Ext.encode(dmutasi_id);
		var encoded_array_dmutasi_produk = Ext.encode(dmutasi_produk);
		var encoded_array_dmutasi_satuan = Ext.encode(dmutasi_satuan);
		var encoded_array_dmutasi_jumlah = Ext.encode(dmutasi_jumlah);

		Ext.Ajax.request({
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_master_mutasi&m=detail_detail_mutasi_insert',
			params:{
			dmutasi_id		: encoded_array_dmutasi_id,
			dmutasi_master	: pkid, 
			dmutasi_produk	: encoded_array_dmutasi_produk, 
			dmutasi_satuan	: encoded_array_dmutasi_satuan, 
			dmutasi_jumlah	: encoded_array_dmutasi_jumlah
			},
			callback: function(opts, success, response){
				if(success){
						if(opsi=='print'){
							master_mutasi_print_faktur(pkid);
						}
						master_mutasi_DataStore.load();
				}
			}
		});

	}
	//eof
	
	
	//function for insert detail mutasi produk jadi insert
	function detail_mutasi_produk_jadi_insert(pkid, opsi){
		
		var dmracikan_id = [];
        var dmracikan_produk = [];
        var dmracikan_satuan = [];
        var dmracikan_jumlah = [];

		if(detail_mutasi_DataStore.getCount()>0){
			for(i=0; i<detail_mutasi_DataStore.getCount();i++){
				if((/^\d+$/.test(detail_mutasi_DataStore.getAt(i).data.dmracikan_produk))
				   && detail_mutasi_DataStore.getAt(i).data.dmracikan_produk!==undefined
				   && detail_mutasi_DataStore.getAt(i).data.dmracikan_produk!==''
				   && detail_mutasi_DataStore.getAt(i).data.dmracikan_produk!==0
				   && detail_mutasi_DataStore.getAt(i).data.dmracikan_satuan!==''
				   && detail_mutasi_DataStore.getAt(i).data.dmracikan_jumlah>0){
					
					dmracikan_id.push(detail_mutasi_DataStore.getAt(i).data.dmracikan_id);
					dmracikan_produk.push(detail_mutasi_DataStore.getAt(i).data.dmracikan_produk);
					dmracikan_satuan.push(detail_mutasi_DataStore.getAt(i).data.dmracikan_satuan);
					dmracikan_jumlah.push(detail_mutasi_DataStore.getAt(i).data.dmracikan_jumlah);
				}
			}
		}
		
		var encoded_array_dmracikan_id = Ext.encode(dmracikan_id);
		var encoded_array_dmracikan_produk = Ext.encode(dmracikan_produk);
		var encoded_array_dmracikan_satuan = Ext.encode(dmracikan_satuan);
		var encoded_array_dmracikan_jumlah = Ext.encode(dmracikan_jumlah);

		Ext.Ajax.request({
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_master_mutasi&m=detail_detail_mutasi_produk_jadi_insert',
			params:{
			dmracikan_id		: encoded_array_dmracikan_id,
			dmutasi_master		: pkid, 
			dmracikan_produk	: encoded_array_dmracikan_produk, 
			dmracikan_satuan	: encoded_array_dmracikan_satuan, 
			dmracikan_jumlah	: encoded_array_dmracikan_jumlah
			},
			callback: function(opts, success, response){
				if(success){
						if(opsi=='print'){
							master_mutasi_print_faktur(pkid);
						}
						master_mutasi_DataStore.load();
				}
			}
		});

	}
	
	
	
	//function for purge detail
	function detail_mutasi_purge(pkid){
		Ext.Ajax.request({
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_master_mutasi&m=detail_detail_mutasi_purge',
			params:{ master_id: pkid },
			success:function(response){
				detail_mutasi_insert(pkid);
			}
		});
	}
	//eof
	
	/* Function for Delete Confirm of detail */
	function detail_mutasi_confirm_delete(){
		// only one record is selected here
		if(detail_mutasiListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', detail_mutasi_delete);
		} else if(detail_mutasiListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', detail_mutasi_delete);
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
	function detail_mutasi_delete(btn){
		if(btn=='yes'){
			var s = detail_mutasiListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, r; r = s[i]; i++){
				detail_mutasi_DataStore.remove(r);
				detail_mutasi_DataStore.commitChanges();
				detail_mutasi_total();
			}
		} 
		
	}
	//eof
	
	/*Function utk melakukan insert ke tabel detail_mutasi_racikan_insert */
	/*
	function detail_mutasi_racikan_insert(pkid){
		
		var dmutasi_id = [];
        var dmutasi_produk = [];
        var dmutasi_satuan = [];
        var dmutasi_jumlah = [];

		if(detail_mutasi_DataStore.getCount()>0){
			for(i=0; i<detail_mutasi_DataStore.getCount();i++){
				if((/^\d+$/.test(detail_mutasi_DataStore.getAt(i).data.dmutasi_produk))
				   && detail_mutasi_DataStore.getAt(i).data.dmutasi_produk!==undefined
				   && detail_mutasi_DataStore.getAt(i).data.dmutasi_produk!==''
				   && detail_mutasi_DataStore.getAt(i).data.dmutasi_produk!==0
				   && detail_mutasi_DataStore.getAt(i).data.dmutasi_satuan!==''
				   && detail_mutasi_DataStore.getAt(i).data.dmutasi_jumlah>0){
					
					dmutasi_id.push(detail_mutasi_DataStore.getAt(i).data.dmutasi_id);
					dmutasi_produk.push(detail_mutasi_DataStore.getAt(i).data.dmutasi_produk);
					dmutasi_satuan.push(detail_mutasi_DataStore.getAt(i).data.dmutasi_satuan);
					dmutasi_jumlah.push(detail_mutasi_DataStore.getAt(i).data.dmutasi_jumlah);
				}
			}
		}
		
		var encoded_array_dmutasi_id = Ext.encode(dmutasi_id);
		var encoded_array_dmutasi_produk = Ext.encode(dmutasi_produk);
		var encoded_array_dmutasi_satuan = Ext.encode(dmutasi_satuan);
		var encoded_array_dmutasi_jumlah = Ext.encode(dmutasi_jumlah);

		Ext.Ajax.request({
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_master_mutasi&m=detail_detail_mutasi_insert',
			params:{
			dmutasi_id		: encoded_array_dmutasi_id,
			dmutasi_master	: pkid, 
			dmutasi_produk	: encoded_array_dmutasi_produk, 
			dmutasi_satuan	: encoded_array_dmutasi_satuan, 
			dmutasi_jumlah	: encoded_array_dmutasi_jumlah
			},
			callback: function(opts, success, response){
				if(success){
						if(opsi=='print'){
							master_mutasi_print_faktur(pkid);
						}
						master_mutasi_DataStore.load();
				}
			}
		});
	}
	*/
	
	//declaration of detail coloumn model for detail mutasi produk jadi
	detail_mutasi_produk_jadiColumnModel = new Ext.grid.ColumnModel(
		[
		 {
			header: '<div align="center">ID</div>',
			dataIndex: 'dmracikan_id',
			width: 80,
			sortable: true,
			readOnly: true,
			hidden: true
		},
		/*
		{
			header: '<div align="center">' + 'Kode Produk' + '</div>',
			dataIndex: 'produk_kode',
			width: 75,	//150,
			sortable: true,
			readOnly: true
		}, 
		*/
		{
			header: '<div align="center">Produk Jadi</div>',
			dataIndex: 'dmracikan_produk',
			width: 200,
			sortable: true,
			editor: mutasi_produkjadiField,
			renderer: Ext.util.Format.comboRenderer(mutasi_produkjadiField)
		},
		{
			header: '<div align="center">Satuan</div>',
			dataIndex: 'dmracikan_satuan',
			width: 80,
			sortable: true,
			editor: mutasi_satuan_produkjadiField,
			renderer: Ext.util.Format.comboRenderer(mutasi_satuan_produkjadiField)
		},
		{
			header: '<div align="center">Jumlah</div>',
			dataIndex: 'dmracikan_jumlah',
			width: 60,
			sortable: true,
			align: 'right',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			editor : mutasi_produkjadi_jumlahField
		}]
	);
	detail_mutasi_produk_jadiColumnModel.defaultSortable= true;
	//eof
	
	/*List eDitor Grid Panel untuk Detail Produk Jadi */
	detail_mutasi_produk_jadiListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'detail_mutasi_produk_jadiListEditorGrid',
		el: 'fp_detail_mutasi_produk_jadi',
		title: 'Racikan : Detail Produk Jadi',
		height: 250,
		width: 1100,	//690,
		autoScroll: true,
		store: detail_mutasi_produkJadi_DataStore, // DataStore
		colModel: detail_mutasi_produk_jadiColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 5 5 5',
		plugins: [editor_detail_mutasi_produk_jadi],
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true}

		,
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			ref : '../dmutasi_add_produk_jadi',
			handler: detail_mutasi_produk_jadi_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			ref : '../dmutasi_delete_produk_jadi',
			handler: detail_mutasi_produk_jadi_confirm_delete
		}
		]
	
	});
	//eof
	
	//function of detail add produk jadi
	function detail_mutasi_produk_jadi_add(){
		var edit_detail_mutasi_produk_jadi= new detail_mutasi_produk_jadiListEditorGrid.store.recordType({
			dmracikan_id		: 0,
			dmracikan_mutasi_id	: null,		
			dmracikan_produk	: '',		
			dmracikan_satuan	: '',		
			dmracikan_jumlah	: 0		
		});
		editor_detail_mutasi_produk_jadi.stopEditing();
		detail_mutasi_produkJadi_DataStore.insert(0, edit_detail_mutasi_produk_jadi);
		//detail_mutasi_produk_jadiListEditorGrid.getView().refresh();
		detail_mutasi_produk_jadiListEditorGrid.getSelectionModel().selectRow(0);
		editor_detail_mutasi_produk_jadi.startEditing(0);
	}
	
	
	
	
	/* Function for Delete Confirm of detail produk jadi */
	function detail_mutasi_produk_jadi_confirm_delete(){
		// only one record is selected here
		if(detail_mutasi_produk_jadiListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', detail_mutasi_produk_jadi_delete);
		} else if(detail_mutasi_produk_jadiListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', detail_mutasi_produk_jadi_delete);
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
	
	//function for Delete of detail produk jadi
	function detail_mutasi_produk_jadi_delete(btn){
		if(btn=='yes'){
			var s = detail_mutasi_produk_jadiListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, r; r = s[i]; i++){
				detail_mutasi_produkJadi_DataStore.remove(r);
				detail_mutasi_produkJadi_DataStore.commitChanges();
				detail_mutasi_produk_jadi_total();
			}
		} 
		
	}
	//eof
	
	/*Tab Panel utk master mutasi form */
	var detail_tab_master_mutasi = new Ext.TabPanel({
		plain:true,
		activeTab: 0,
		autoHeight: true,
		items: [detail_mutasiListEditorGrid]
	});

	//event on update of detail data store
	//detail_mutasi_DataStore.on('update', refresh_detail_mutasi);
	
	/* Function for retrieve create Window Panel*/ 
	master_mutasi_createForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 1100,	//700,        
		items: [master_mutasi_masterGroup,detail_tab_master_mutasi /*,master_mutasi_footGroup*/]
		,
		buttons: [
			{
				text: 'Print Only',
				handler: mb_print_only
			},
			{
				xtype:'spacer',
				width: 750
			},
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_MUTASI'))){ ?>
			mutasi_button_saveprintField
			,
			mutasi_button_saveField
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					//master_mutasi_reset_form
					master_mutasi_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	master_mutasi_createWindow= new Ext.Window({
		id: 'master_mutasi_createWindow',
		title: mutasi_post2db+' Mutasi Barang',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_master_mutasi_create',
		items: master_mutasi_createForm
	});
	/* End Window */
	
	function detail_mutasi_total(){
		var jumlah_item=0;
		for(i=0;i<detail_mutasi_DataStore.getCount();i++){
			var detail_mutasi_record=detail_mutasi_DataStore.getAt(i);
			jumlah_item=jumlah_item+detail_mutasi_record.data.dmutasi_jumlah;
		}
		mutasi_totaljumlahField.setValue(CurrencyFormatted(jumlah_item));
		mutasi_itemjumlahField.setValue(CurrencyFormatted(detail_mutasi_DataStore.getCount()));
	}
	
	function detail_mutasi_produk_jadi_total(){
		var jumlah_item_pj=0;
		for(i=0;i<detail_mutasi_produkJadi_DataStore.getCount();i++){
			var detail_mutasi_produk_jadi_record=detail_mutasi_produkJadi_DataStore.getAt(i);
			jumlah_item_pj=jumlah_item_pj+detail_mutasi_produk_jadi_record.data.dmracikan_jumlah;
		}
		produk_jadi_totaljumlahField.setValue(CurrencyFormatted(jumlah_item_pj));
		produk_jadi_itemjumlahField.setValue(CurrencyFormatted(detail_mutasi_produkJadi_DataStore.getCount()));
	}
	
		
	/* Function for action list search */
	function master_mutasi_list_search(){
		// render according to a SQL date format.
		var mutasi_id_search=null;
		var mutasi_no_search=null;
		var mutasi_asal_search=null;
		var mutasi_tujuan_search=null;
		var mutasi_tgl_awal_search_date="";
		var mutasi_tgl_akhir_search_date="";
		var mutasi_keterangan_search=null;
		var mutasi_status_search=null;
		var mutasi_status_terima_search=null;

		if(mutasi_idSearchField.getValue()!==null){mutasi_id_search=mutasi_idSearchField.getValue();}
		if(mutasi_noSearchField.getValue()!==null){mutasi_no_search=mutasi_noSearchField.getValue();}
		if(mutasi_asalSearchField.getValue()!==null){mutasi_asal_search=mutasi_asalSearchField.getValue();}
		if(mutasi_tujuanSearchField.getValue()!==null){mutasi_tujuan_search=mutasi_tujuanSearchField.getValue();}
		if(mutasi_tanggalSearchField.getValue()!==""){mutasi_tgl_awal_search_date=mutasi_tanggalSearchField.getValue().format('Y-m-d');}
		if(mutasi_tanggal_akhirSearchField.getValue()!==""){mutasi_tgl_akhir_search_date=mutasi_tanggal_akhirSearchField.getValue().format('Y-m-d');}
		if(mutasi_keteranganSearchField.getValue()!==null){mutasi_keterangan_search=mutasi_keteranganSearchField.getValue();}
		if(mutasi_statusSearchField.getValue()!==null){mutasi_status_search=mutasi_statusSearchField.getValue();}
		if(mutasi_status_terima_SearchField.getValue()!==null){mutasi_status_terima_search=mutasi_status_terima_SearchField.getValue();}

		// change the store parameters
		master_mutasi_DataStore.baseParams = {
			task: 'SEARCH',
			//variable here
			mutasi_id			:	mutasi_id_search, 
			mutasi_no			:	mutasi_no_search,
			mutasi_asal			:	mutasi_asal_search, 
			mutasi_tujuan		:	mutasi_tujuan_search, 
			mutasi_tgl_awal		:	mutasi_tgl_awal_search_date, 
			mutasi_tgl_akhir	:	mutasi_tgl_akhir_search_date, 
			mutasi_keterangan	:	mutasi_keterangan_search,
			mutasi_status		:	mutasi_status_search,
			mutasi_status_terima: 	mutasi_status_terima_search
		};
		// Cause the datastore to do another query : 
		master_mutasi_DataStore.reload({params: {start: 0, limit: pageS}});
	}
		
	/* Function for reset search result */
	function master_mutasi_reset_search(){
		// reset the store parameters
		master_mutasi_DataStore.baseParams = { task: 'LIST', start: 0, limit: pageS };
		master_mutasi_DataStore.reload({params: {start: 0, limit: pageS}});
		//master_mutasi_searchWindow.close();
	};
	/* End of Fuction */
	
	function master_mutasi_reset_SearchForm(){
		mutasi_noSearchField.reset();
		mutasi_asalSearchField.reset();
		mutasi_tujuanSearchField.reset();
		mutasi_tanggalSearchField.reset();
		mutasi_keteranganSearchField.reset();
		mutasi_statusSearchField.reset();
		mutasi_status_terima_SearchField.reset();
	}
	
	
	/* Field for search */
	/* Identify  mutasi_id Search Field */
	mutasi_idSearchField= new Ext.form.NumberField({
		id: 'mutasi_idSearchField',
		fieldLabel: 'Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  mutasi_no Search Field */
	mutasi_noSearchField= new Ext.form.TextField({
		id: 'mutasi_noSearchField',
		fieldLabel: 'No MB',
		maxLength: 50,
		anchor: '95%'
	
	});
	
	/* Identify  mutasi_asal Search Field */
	mutasi_asalSearchField= new Ext.form.ComboBox({
		id: 'mutasi_asalSearchField',
		fieldLabel: 'Gudang Asal',
		store: cbo_mutasi_gudang_DataSore,
		mode : 'remote',
		displayField:'mutasi_gudang_nama',
		valueField: 'mutasi_gudang_value',
        typeAhead: false,
        hideTrigger:false,
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	
	});
	/* Identify  mutasi_tujuan Search Field */
	mutasi_tujuanSearchField= new Ext.form.ComboBox({
		id: 'mutasi_tujuanSearchField',
		fieldLabel: 'Gudang Tujuan',
		store: cbo_mutasi_gudang_all_DataStore,
		mode : 'remote',
		displayField:'mutasi_gudang_nama',
		valueField: 'mutasi_gudang_value',
        typeAhead: false,
        hideTrigger:false,
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	
	});
	/* Identify  mutasi_tanggal Search Field */
	mutasi_tanggalSearchField= new Ext.form.DateField({
		id: 'mutasi_tanggalSearchField',
		fieldLabel: 'Tanggal',
		format : 'd-m-Y'
	});
	/* Identify  mutasi_keterangan Search Field */
	mutasi_keteranganSearchField= new Ext.form.TextArea({
		id: 'mutasi_keteranganSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 500,
		anchor: '95%'
	});
	
	mutasi_label_tanggalField= new Ext.form.Label({ html: ' &nbsp; s/d  &nbsp;' });
    
	mutasi_tanggal_akhirSearchField= new Ext.form.DateField({
		id: 'mutasi_tanggal_akhirSearchField',
		fieldLabel: 's/d',
		format : 'd-m-Y'
	});

	mutasi_statusSearchField= new Ext.form.ComboBox({
		id: 'mutasi_statusSearchField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['value', 'mutasi_status'],
			data:[['Terbuka','Terbuka'],['Tertutup','Tertutup'],['Batal','Batal'], ['Tunggu','Tunggu']]
		}),
		mode: 'local',
		displayField: 'mutasi_status',
		valueField: 'value',
		anchor: '60%',
		triggerAction: 'all'	 
	});
	
	/*Field mutasi_status_terimaSearchField */
	mutasi_status_terima_SearchField= new Ext.form.ComboBox({
		id: 'mutasi_status_terima_SearchField',
		fieldLabel: 'Status Terima',
		forceSelection: true,
		store:new Ext.data.SimpleStore({
			fields:['mutasi_status_terima_value', 'mutasi_status_terima_display'],
			data:[['Diterima','Diterima'],['Ditolak','Ditolak'],['Tunggu', 'Tunggu']]
		}),
		mode: 'local',
		displayField: 'mutasi_status_terima_display',
		valueField: 'mutasi_status_terima_value',
		anchor: '80%',
		//disabled : true,
		allowBlank: true,
		triggerAction: 'all'	
	});
    
	/* Function for retrieve search Form Panel */
	master_mutasi_searchForm = new Ext.FormPanel({
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
				items: [mutasi_noSearchField,mutasi_asalSearchField, mutasi_tujuanSearchField,{
							layout: 'column',
							border : false,
							items:[
							{
								layout: 'form',
								columnWidth: 0.6,
								border: false,
								items:[mutasi_tanggalSearchField]
							},
							{
								layout: 'form',
								columnWidth: 0.4,
								border: false,
								labelWidth: 30,
								items:[mutasi_tanggal_akhirSearchField]
							}
							
							]
						}
						, mutasi_keteranganSearchField, mutasi_statusSearchField, mutasi_status_terima_SearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: master_mutasi_list_search
			},{
				text: 'Close',
				handler: function(){
					master_mutasi_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	master_mutasi_searchWindow = new Ext.Window({
		title: 'Pencarian Mutasi',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_master_mutasi_search',
		items: master_mutasi_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!master_mutasi_searchWindow.isVisible()){
			master_mutasi_reset_SearchForm();
			master_mutasi_searchWindow.show();
		} else {
			master_mutasi_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	function master_mutasi_print_faktur(pkid){
		
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_master_mutasi&m=print_faktur',
		params: {
			faktur	: pkid
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/mutasi_faktur.html','mutasi_faktur','height=800,width=670,resizable=1,scrollbars=1, menubar=1');
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
	function master_mutasi_print(){
		var searchquery = "";
		var mutasi_asal_print=null;
		var mutasi_no_print=null;
		var mutasi_tujuan_print=null;
		var mutasi_tgl_awal_print_date="";
		var mutasi_tgl_akhir_print_date="";
		var mutasi_keterangan_print=null;
		var mutasi_status=null;
		var win;              
		// check if we do have some search data...
		if(master_mutasi_DataStore.baseParams.query!==null){searchquery = master_mutasi_DataStore.baseParams.query;}
		if(master_mutasi_DataStore.baseParams.mutasi_no!==null){mutasi_no = master_mutasi_DataStore.baseParams.mutasi_no;}
		if(master_mutasi_DataStore.baseParams.mutasi_asal!==null){mutasi_asal_print = master_mutasi_DataStore.baseParams.mutasi_asal;}
		if(master_mutasi_DataStore.baseParams.mutasi_tujuan!==null){mutasi_tujuan_print = master_mutasi_DataStore.baseParams.mutasi_tujuan;}
		if(master_mutasi_DataStore.baseParams.mutasi_tgl_awal!==""){mutasi_tgl_awal_print_date = master_mutasi_DataStore.baseParams.mutasi_tgl_awal;}
		if(master_mutasi_DataStore.baseParams.mutasi_tgl_akhir!==""){mutasi_tgl_akhir_print_date = master_mutasi_DataStore.baseParams.mutasi_tgl_akhir;}
		if(master_mutasi_DataStore.baseParams.mutasi_keterangan!==null){mutasi_keterangan_print = master_mutasi_DataStore.baseParams.mutasi_keterangan;}
		if(master_mutasi_DataStore.baseParams.mutasi_status!==null){mutasi_status_print = master_mutasi_DataStore.baseParams.mutasi_status;}
		

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_master_mutasi&m=get_action',
		params: {
			task			: "PRINT",
		  	query			: searchquery,                    		
			mutasi_asal 	: mutasi_asal_print,
			mutasi_tujuan 	: mutasi_tujuan_print,
		  	mutasi_tgl_awal	: mutasi_tgl_awal_print_date, 
			mutasi_tgl_akhir: mutasi_tgl_akhir_print_date, 
			mutasi_no		: mutasi_no_print, 
			mutasi_status	: mutasi_status_print, 
			mutasi_keterangan : mutasi_keterangan_print,
		  	currentlisting: master_mutasi_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/print_mutasilist.html','master_mutasilist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
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
	function master_mutasi_export_excel(){
		var searchquery = "";
		var mutasi_asal_2excel=null;
		var mutasi_no_2excel=null;
		var mutasi_tujuan_2excel=null;
		var mutasi_tgl_awal_2excel_date="";
		var mutasi_tgl_akhir_2excel_date="";
		var mutasi_tgl_status_2excel=null;
		var mutasi_keterangan_2excel=null;
		var win;              
		// check if we do have some search data...
		if(master_mutasi_DataStore.baseParams.query!==null){searchquery = master_mutasi_DataStore.baseParams.query;}
		if(master_mutasi_DataStore.baseParams.mutasi_no!==null){mutasi_asal_2excel = master_mutasi_DataStore.baseParams.mutasi_no;}
		if(master_mutasi_DataStore.baseParams.mutasi_asal!==null){mutasi_asal_2excel = master_mutasi_DataStore.baseParams.mutasi_asal;}
		if(master_mutasi_DataStore.baseParams.mutasi_tujuan!==null){mutasi_tujuan_2excel = master_mutasi_DataStore.baseParams.mutasi_tujuan;}
		if(master_mutasi_DataStore.baseParams.mutasi_tgl_awal!==""){mutasi_tgl_awal_2excel_date = master_mutasi_DataStore.baseParams.mutasi_tgl_awal;}
		if(master_mutasi_DataStore.baseParams.mutasi_tgl_akhir!==""){mutasi_tgl_akhir_2excel_date = master_mutasi_DataStore.baseParams.mutasi_tgl_akhir;}
		if(master_mutasi_DataStore.baseParams.mutasi_status!==null){mutasi_status_2excel = master_mutasi_DataStore.baseParams.mutasi_status;}
		if(master_mutasi_DataStore.baseParams.mutasi_keterangan!==null){mutasi_keterangan_2excel = master_mutasi_DataStore.baseParams.mutasi_keterangan;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_master_mutasi&m=get_action',
		params: {
			task				: "EXCEL",
		  	query				: searchquery,
			mutasi_no	 		: mutasi_no_2excel,
			mutasi_asal 		: mutasi_asal_2excel,
			mutasi_tujuan 		: mutasi_tujuan_2excel,
		  	mutasi_tgl_awal		: mutasi_tgl_awal_2excel_date, 
			mutasi_tgl_akhir	: mutasi_tgl_akhir_2excel_date, 
			mutasi_status		: mutasi_status_2excel, 
			mutasi_keterangan 	: mutasi_keterangan_2excel,
		  	currentlisting		: master_mutasi_DataStore.baseParams.task // this tells us if we are searching or not
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
	detail_mutasi_DataStore.on("update",detail_mutasi_total);
	detail_mutasi_DataStore.on("load",detail_mutasi_total);
	detail_mutasi_produkJadi_DataStore.on("update",detail_mutasi_produk_jadi_total);
	detail_mutasi_produkJadi_DataStore.on("load",detail_mutasi_produk_jadi_total);
	master_mutasiListEditorGrid.addListener('rowcontextmenu', onmaster_mutasi_ListEditGridContextMenu);
	master_mutasi_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	
	mutasi_asalField.on("select",function(){
		//cbo_mutasi_produkDataStore.setBaseParam('gudang', get_asal_id()); //by masongbee
		cbo_mutasi_produkDataStore.setBaseParam('gudang', mutasi_asalField.getValue()); //by masongbee
		cbo_mutasi_produkDataStore.setBaseParam('task','list');
		//cbo_mutasi_produkDataStore.reload();
	});
	
	combo_mutasi_produk.on("focus",function(){
		cbo_mutasi_produkDataStore.setBaseParam('task','list');
		var selectedquery=detail_mutasiListEditorGrid.getSelectionModel().getSelected().get('produk_nama');
		cbo_mutasi_produkDataStore.setBaseParam('query',selectedquery);
		
		//cbo_order_produk_DataStore.load();
	});
	
	combo_mutasi_satuan.on("focus",function(){
		cbo_mutasi_satuanDataStore.setBaseParam('task','produk');
		cbo_mutasi_satuanDataStore.setBaseParam('selected_id',combo_mutasi_produk.getValue());
		cbo_mutasi_satuanDataStore.load();
	});
	
	combo_mutasi_produk.on("select",function(){
		var satuan_id = 0;
		var jumlah_awal = 0;
	
		cbo_mutasi_satuanDataStore.setBaseParam('task','produk');
		cbo_mutasi_satuanDataStore.setBaseParam('selected_id',combo_mutasi_produk.getValue());
		cbo_mutasi_satuanDataStore.reload();
		
		mutasi_stok_byprodukDataStore.setBaseParam('produk_id',combo_mutasi_produk.getValue());
		mutasi_stok_byprodukDataStore.setBaseParam('gudang',mutasi_asalField.getValue());
		mutasi_stok_byprodukDataStore.setBaseParam('tanggal',mutasi_tanggalField.getValue().format('Y-m-d'));
		mutasi_stok_byprodukDataStore.load({
			callback: function(r,opt,success){
				if(success==true){
					var j=mutasi_stok_byprodukDataStore.findExact('produk_id',combo_mutasi_produk.getValue(),0);
					if(j>=0){
						var mutasi_record_produk=mutasi_stok_byprodukDataStore.getAt(j);
						satuan_id=mutasi_record_produk.data.produk_satuan_id;
						satuan_terkecil=mutasi_record_produk.data.satuan_terkecil;
						jumlah_awal=mutasi_record_produk.data.produk_stok;
						//harga_total = mutasi_record_produk.data.harga;
					}
					cbo_mutasi_satuanDataStore.load({
						callback: function(r,opt,success){
							combo_mutasi_satuan.setValue(satuan_id);
							mutasi_stok_akhirField.setValue(jumlah_awal);
							//order_harga_totalField.setValue(harga_total);
							
							if(mutasi_stok_akhirField.getValue()==0 || mutasi_stok_akhirField.getValue()<=0){
							alert('Stok Produk ini 0 atau minus! Klik Cancel utk tidak memaksa produk ini dijual.');
							/*
							Ext.MessageBox.show({
								msg: 'Stok Produk ini 0 atau minus! Klik Cancel utk tidak memaksa produk ini dijual.',
								buttons: Ext.MessageBox.OK,
								animEl: 'save',
								icon: Ext.MessageBox.WARNING
							   });
							   */
						}
							
							
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
	
	/*Ketika klik Produk Jadi, maka langsung load satuan yang hanya bisa dipakai oleh produk tersebut */
	mutasi_produkjadiField.on("select", function(){
		cbo_mracikan_satuanDataStore.setBaseParam('task','produk');
		cbo_mracikan_satuanDataStore.setBaseParam('selected_id',mutasi_produkjadiField.getValue());
		cbo_mracikan_satuanDataStore.reload();
	});
	
	mutasi_satuan_produkjadiField.on("focus",function(){
		cbo_mracikan_satuanDataStore.setBaseParam('task','produk');
		cbo_mracikan_satuanDataStore.setBaseParam('selected_id',mutasi_produkjadiField.getValue());
		cbo_mracikan_satuanDataStore.load();
	});
	

	detail_mutasi_DataStore.on("update",function(){
		var	query_selected="";
		var satuan_selected="";
		detail_mutasi_DataStore.commitChanges();
		detail_mutasi_total();
		for(i=0;i<detail_mutasi_DataStore.getCount();i++){
			var detail_mutasi_record=detail_mutasi_DataStore.getAt(i);
			query_selected=query_selected+detail_mutasi_record.data.dmutasi_produk+",";
		}
		cbo_mutasi_produkDataStore.setBaseParam('task','selected');
		cbo_mutasi_produkDataStore.setBaseParam('selected_id',query_selected);
		cbo_mutasi_produkDataStore.load();
		
		for(i=0;i<detail_mutasi_DataStore.getCount();i++){
			var detail_mutasi_record=detail_mutasi_DataStore.getAt(i);
			satuan_selected=satuan_selected+detail_mutasi_record.data.dmutasi_satuan+",";
		}
		cbo_mutasi_satuanDataStore.setBaseParam('task','selected');
		cbo_mutasi_satuanDataStore.setBaseParam('selected_id',satuan_selected);
		cbo_mutasi_satuanDataStore.load();
		//detail_order_beliListEditorGrid.getView().refresh();
	});

	
	/*Event ketika No Ref dipilih, maka akan menginsertkan detail produk yang sudah diinput ke Detail Data Store */
	mutasi_norefField.on("select",function(){
		var j=cbo_racikan_noref_DataSore.findExact('mutasi_id',mutasi_norefField.getValue());
		
		cbo_mutasi_noref_detail_DataStore.load({
			params:{no_ref : mutasi_norefField.getValue()},
			callback: function(r,opt,success){
				if(success==true){
					cbo_mutasi_produkDataStore.setBaseParam('task','no_ref');
					cbo_mutasi_produkDataStore.setBaseParam('no_ref',mutasi_norefField.getValue());
					cbo_mutasi_produkDataStore.load({
						callback: function(r,opt,success){
							if(success==true){
								detail_mutasi_DataStore.removeAll();
								for(i=0;i<cbo_mutasi_noref_detail_DataStore.getCount();i++){
										var detail_mutasi_record=cbo_mutasi_noref_detail_DataStore.getAt(i);
										detail_mutasi_DataStore.insert(i,detail_mutasi_record);
								}
								detail_mutasi_total();
							}
						}
					});
				}
			}
		});
		detail_mutasi_DataStore.commitChanges();
		detail_mutasi_total();
		//detail_mutasiListEditorGrid.setDisabled(true);
	});

	mutasi_post2db = '';
	task = '';
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_master_mutasi"></div>
         <div id="fp_detail_mutasi"></div>
		<div id="elwindow_master_mutasi_create"></div>
        <div id="elwindow_master_mutasi_search"></div>
    </div>
</div>
</body>