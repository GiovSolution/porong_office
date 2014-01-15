<?
/* 	These code was generated using phpCIGen v 0.1.b (1/08/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: master_invoice View
	+ Description	: For record view
	+ Filename 		: v_master_invoice.php
 	+ Author  		: 
 	+ Created on 13/Oct/2009 15:51:36
	
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
var master_invoice_DataStore;
var master_invoice_ColumnModel;
var master_invoiceListEditorGrid;
var master_invoice_createForm;
var master_invoice_createWindow;
var master_invoice_searchForm;
var master_invoice_searchWindow;
var master_invoice_SelectedRow;
var master_invoice_ContextMenu;
//for detail data
var detail_invoice_DataStor;
var detail_invoiceListEditorGrid;
var detail_invoice_ColumnModel;
var detail_invoice_proxy;
var detail_invoice_writer;
var detail_invoice_reader;
var editor_detail_invoice;

//declare konstant
var post2db = '';
var msg = '';
var pageS=15;
var today=new Date().format('Y-m-d');
var tempday=new Date().format('Y-m-d',+0,+0,+14);
/* declare variable here for Field*/
var invoice_idField;
var invoice_noField;
var invoice_no_autoField;
var invoice_supplierField;
var invoice_noterimaField;
var invoice_tanggalField;
var invoice_biayaField;
var invoice_jatuhtempoField;
var invoice_penagihField;
var invoice_keteranganField;
var invoice_idSearchField;
var invoice_noSearchField;
var invoice_no_autoSearchField;
var invoice_supplierSearchField;
var invoice_noterimaSearchField;
var invoice_tgl_awalSearchField;
var invoice_nilaiSearchField;
var invoice_jatuhtempoSearchField;
var invoice_penagihSearchField;
var invoice_statusSearchField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  	/* Function for add data, open window create form */
	function master_invoice_create(opsi){
	
		if(detail_invoice_DataStore.getCount()<1){
		
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Data detail harus ada minimal 1 (satu)',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
			
		}else if(is_master_invoice_form_valid()){	
		
		var invoice_id_create_pk=null; 
		var invoice_no_create=null; 
		var invoice_no_auto_create=null;
		var invoice_supplier_create=null; 
		var invoice_noterima_create=null; 
		var invoice_tanggal_create_date=""; 
		var invoice_nilai_create=null; 
		var invoice_jatuhtempo_create_date=""; 
		var invoice_penagih_create=null; 
		var invoice_diskon_cerate=null;
		var invoice_cahsback_create=null;
		var invoice_biaya_create=null;
		var invoice_uangmuka_create=null;
		var invoice_total_create=null;
		var invoice_keterangan_create=null;
		var invoice_status_creeate=null;
		
		if(invoice_idField.getValue()!== null){invoice_id_create_pk = invoice_idField.getValue();}else{invoice_id_create_pk=get_pk_id();} 
		if(invoice_noField.getValue()!== null){invoice_no_create = invoice_noField.getValue();} 
		if(invoice_no_autoField.getValue()!== null){invoice_no_auto_create = invoice_no_autoField.getValue();} 
		if(invoice_supplierField.getValue()!== null){invoice_supplier_create = invoice_supplier_idField.getValue();} 
		if(invoice_noterimaField.getValue()!== null){invoice_noterima_create = invoice_noterimaField.getValue();} 
		if(invoice_tanggalField.getValue()!== ""){invoice_tanggal_create_date = invoice_tanggalField.getValue().format('Y-m-d');} 
		if(invoice_jatuhtempoField.getValue()!== ""){invoice_jatuhtempo_create_date = invoice_jatuhtempoField.getValue().format('Y-m-d');} 
		if(invoice_penagihField.getValue()!== null){invoice_penagih_create = invoice_penagihField.getValue();} 
		if(invoice_diskonField.getValue()!==null){invoice_diskon_create = invoice_diskonField.getValue();}
		if(invoice_cashbackField.getValue()!==null){invoice_cashback_create = invoice_cashbackField.getValue();}
		if(invoice_biayaField.getValue()!== null){invoice_biaya_create = invoice_biayaField.getValue();} 
		if(invoice_uangmukaField.getValue()!==null){invoice_uangmuka_create = invoice_uangmukaField.getValue();}
		if(invoice_totalField.getValue()!==null){invoice_total_create = invoice_totalField.getValue();}
		if(invoice_keteranganField.getValue()!==null){invoice_keterangan_create = invoice_keteranganField.getValue();}
		if(invoice_statusField.getValue()!==null){invoice_status_create = invoice_statusField.getValue();}
		
		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_master_invoice&m=get_action',
			params: {
				task				: post2db,
				invoice_id			: invoice_id_create_pk, 
				invoice_no			: invoice_no_create, 
				invoice_no_auto		: invoice_no_auto_create,
				invoice_supplier	: invoice_supplier_create, 
				invoice_noterima	: invoice_noterima_create, 
				invoice_tanggal		: invoice_tanggal_create_date, 
				invoice_jatuhtempo	: invoice_jatuhtempo_create_date, 
				invoice_penagih		: invoice_penagih_create,
				invoice_diskon		: invoice_diskon_create,
				invoice_cashback	: invoice_cashback_create,
				invoice_biaya		: invoice_biaya_create,
				invoice_uangmuka	: invoice_uangmuka_create,
				invoice_total		: invoice_total_create,
				invoice_keterangan	: invoice_keterangan_create,
				invoice_status		: invoice_status_create
			}, 
			success: function(response){             
				var result=eval(response.responseText);
				if(result!==0){
						detail_invoice_insert(result, opsi)
						Ext.MessageBox.alert(post2db+' OK','Data Penerimaan Tagihan berhasil disimpan');
						master_invoice_createWindow.hide();
					}else{
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Data Penerimaan Tagihan tidak bisa disimpan',
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
		if(post2db=='UPDATE')
			return master_invoiceListEditorGrid.getSelectionModel().getSelected().get('invoice_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function master_invoice_reset_form(){
		invoice_idField.reset();
		invoice_idField.setValue(null);
		invoice_noField.reset();
		invoice_noField.setValue(null);
		invoice_no_autoField.reset();
		invoice_no_autoField.setValue('(Auto)');
		invoice_supplierField.reset();
		invoice_supplierField.setValue(null);
		invoice_noterimaField.reset();
		invoice_noterimaField.setValue(null);
		invoice_tanggalField.reset();
		invoice_tanggalField.setValue(today);
		invoice_biayaField.reset();
		invoice_biayaField.setValue(0);
		invoice_jatuhtempoField.reset();
		invoice_jatuhtempoField.setValue(today);
		invoice_penagihField.reset();
		invoice_penagihField.setValue(null);
		invoice_keteranganField.reset();
		invoice_keteranganField.setValue(null);
		invoice_statusField.reset();
		invoice_statusField.setValue('Terbuka');
		
		invoice_diskonField.setValue(0);
		invoice_cashbackField.setValue(0);
		invoice_uangmukaField.setValue(0);
		invoice_totalField.setValue(0);
		
		cbo_invoice_produkDataStore.load();
		cbo_invoice_satuanDataStore.load();
		detail_invoice_DataStore.setBaseParam('master_id',-1);
		detail_invoice_DataStore.load();
					
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function master_invoice_set_form(){
		invoice_idField.setValue(master_invoiceListEditorGrid.getSelectionModel().getSelected().get('invoice_id'));
		invoice_noField.setValue(master_invoiceListEditorGrid.getSelectionModel().getSelected().get('invoice_no'));
		invoice_no_autoField.setValue(master_invoiceListEditorGrid.getSelectionModel().getSelected().get('invoice_no_auto'));
		invoice_supplierField.setValue(master_invoiceListEditorGrid.getSelectionModel().getSelected().get('invoice_supplier'));
		invoice_noterimaField.setValue(master_invoiceListEditorGrid.getSelectionModel().getSelected().get('invoice_noterima'));
		invoice_tanggalField.setValue(master_invoiceListEditorGrid.getSelectionModel().getSelected().get('invoice_tanggal'));
		invoice_jatuhtempoField.setValue(master_invoiceListEditorGrid.getSelectionModel().getSelected().get('invoice_jatuhtempo'));
		invoice_penagihField.setValue(master_invoiceListEditorGrid.getSelectionModel().getSelected().get('invoice_penagih'));
		
		invoice_biayaField.setValue(CurrencyFormatted(master_invoiceListEditorGrid.getSelectionModel().getSelected().get('invoice_biaya')));
		invoice_diskonField.setValue(CurrencyFormatted(master_invoiceListEditorGrid.getSelectionModel().getSelected().get('invoice_diskon')));
		invoice_cashbackField.setValue(CurrencyFormatted(master_invoiceListEditorGrid.getSelectionModel().getSelected().get('invoice_cashback')));
		invoice_uangmukaField.setValue(CurrencyFormatted(master_invoiceListEditorGrid.getSelectionModel().getSelected().get('invoice_uangmuka')));
		invoice_totalField.setValue(CurrencyFormatted(master_invoiceListEditorGrid.getSelectionModel().getSelected().get('invoice_total')));
		
		invoice_keteranganField.setValue(master_invoiceListEditorGrid.getSelectionModel().getSelected().get('invoice_keterangan'));
		invoice_statusField.setValue(master_invoiceListEditorGrid.getSelectionModel().getSelected().get('invoice_status'));	
			
		cbo_invoice_produkDataStore.setBaseParam('master_id',get_pk_id());
		cbo_invoice_produkDataStore.setBaseParam('task','detail');
		cbo_invoice_satuanDataStore.load();
		cbo_invoice_produkDataStore.load({
			callback: function(opts, response, success){
				if(success==true){
					detail_invoice_DataStore.setBaseParam('master_id',get_pk_id());
					detail_invoice_DataStore.load({
						callback: function(opts, response, success){
							if(success==true){
								get_total_invoice();
								Ext.MessageBox.hide();
							}
						}
					});
				}
			}
		});
		//set detail data di sini !
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_master_invoice_form_valid(){
		return (invoice_noterimaField.isValid());
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!master_invoice_createWindow.isVisible()){
			post2db='CREATE';
			msg='created';
			master_invoice_reset_form();
			master_invoice_createWindow.show();
		} else {
			master_invoice_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function master_invoice_confirm_delete(){
		// only one master_invoice is selected here
		if(master_invoiceListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', master_invoice_delete);
		} else if(master_invoiceListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', master_invoice_delete);
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
  
	/* Function for Update Confirm */
	function master_invoice_confirm_update(){
		/* only one record is selected here */
		if(master_invoiceListEditorGrid.selModel.getCount() == 1) {
			post2db='UPDATE';
			msg='updated';
			master_invoice_set_form();
			master_invoice_createWindow.show();
			Ext.MessageBox.show({
			   msg: 'Sedang memuat data, mohon tunggu...',
			   progressText: 'proses...',
			   width:350,
			   wait:true
			});
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
	function master_invoice_delete(btn){
		if(btn=='yes'){
			var selections = master_invoiceListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< master_invoiceListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.invoice_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Mohon tunggu...',
				url: 'index.php?c=c_master_invoice&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							master_invoice_DataStore.reload();
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
	master_invoice_DataStore = new Ext.data.Store({
		id: 'master_invoice_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_invoice&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit: pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'invoice_id'
		},[
			{name: 'invoice_id', type: 'int', mapping: 'invoice_id'}, 
			{name: 'invoice_no', type: 'string', mapping: 'no_bukti'}, 
			{name: 'invoice_no_auto', type: 'string', mapping: 'no_bukti_auto'}, 
			{name: 'invoice_supplier', type: 'string', mapping: 'supplier_nama'}, 
			{name: 'invoice_noterima', type: 'string', mapping: 'terima_no'}, 
			{name: 'invoice_tanggal', type: 'date', dateFormat: 'Y-m-d', mapping: 'tanggal'}, 
			{name: 'invoice_diskon', type: 'int', mapping: 'invoice_diskon'},
			{name: 'invoice_cashback', type: 'float', mapping: 'invoice_cashback'},
			{name: 'invoice_biaya', type: 'float', mapping: 'invoice_biaya'},
			{name: 'invoice_uangmuka', type: 'float', mapping: 'invoice_uangmuka'},
			{name: 'invoice_jumlah', type: 'float', mapping: 'jumlah_barang'},
			{name: 'invoice_total', type: 'float', mapping: 'total_nilai'},
			{name: 'invoice_jatuhtempo', type: 'date', dateFormat: 'Y-m-d', mapping: 'invoice_jatuhtempo'}, 
			{name: 'invoice_penagih', type: 'string', mapping: 'invoice_penagih'},
			{name: 'invoice_keterangan', type: 'string', mapping: 'invoice_keterangan'},
			{name: 'invoice_status', type: 'string', mapping: 'invoice_status'},  			
			{name: 'invoice_creator', type: 'string', mapping: 'invoice_creator'}, 
			{name: 'invoice_date_create', type: 'date', dateFormat: 'Y-m-d', mapping: 'invoice_date_create'}, 
			{name: 'invoice_update', type: 'string', mapping: 'invoice_update'}, 
			{name: 'invoice_date_update', type: 'date', dateFormat: 'Y-m-d', mapping: 'invoice_date_update'}, 
			{name: 'invoice_revised', type: 'int', mapping: 'invoice_revised'} 
		]),
		sortInfo:{field: 'invoice_id', direction: "DESC"}
	});
	/* End of Function */
	
	cbo_invoice_tbeliDataStore = new Ext.data.Store({
		id: 'cbo_invoice_tbeliDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_invoice&m=get_tbeli_list', 
			method: 'POST'
		}),
		baseParams:{start: 0, limit: pageS }, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'terima_id'
		},[
			{name: 'cbo_invoice_terima_id', type: 'int', mapping: 'terima_id'},
			{name: 'cbo_invoice_terima_no', type: 'string', mapping: 'terima_no'},
			{name: 'cbo_invoice_terima_supplier', type: 'string', mapping: 'supplier_nama'},
			{name: 'cbo_invoice_terima_supplier_id', type: 'string', mapping: 'supplier_id'}
		]),
		sortInfo:{field: 'cbo_invoice_terima_no', direction: "ASC"}
	});
	
	var invoice_tbeli_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{cbo_invoice_terima_no}</b><br /></span>',
            'Supplier: {cbo_invoice_terima_supplier}',
        '</div></tpl>'
    );
    
	detail_invoice_tbeliDataStore = new Ext.data.Store({
		id: 'detail_invoice_tbeliDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_invoice&m=get_dtbeli_list', 
			method: 'POST'
		}),
		baseParams:{start: 0, limit: pageS }, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'terima_id'
		},[
			{name: 'cbo_invoice_terima_id', type: 'int', mapping: 'terima_id'},
			{name: 'cbo_invoice_terima_no', type: 'string', mapping: 'terima_no'},
			{name: 'cbo_invoice_terima_supplier', type: 'string', mapping: 'supplier_nama'},
			{name: 'cbo_invoice_terima_supplier_id', type: 'string', mapping: 'supplier_id'}
		]),
		sortInfo:{field: 'cbo_invoice_terima_no', direction: "ASC"}
	});
	
  	/* Function for Identify of Window Column Model */
	master_invoice_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'invoice_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},
		{
			header: '<div align="center">Tanggal</div>',
			dataIndex: 'invoice_tanggal',
			width: 70,	//100,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			readOnly: true
		},
		
		{
			header: '<div align="center">' + 'No PT' + '</div>',
			dataIndex: 'invoice_no_auto',
			width: 100,	//150,
			sortable: true,
			readOnly: true
		}, 
		
		{
			header: '<div align="center">No Tagihan</div>',
			dataIndex: 'invoice_no',
			width: 80,	//100,
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">No PB</div>',
			dataIndex: 'invoice_noterima',
			width: 80,	//120,
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">Supplier</div>',
			dataIndex: 'invoice_supplier',
			width: 200,	//250,
			sortable: true,
			readOnly: true
		}, 
		{
			header: '<div align="center">Jml Item</div>',
			align: 'right',
			dataIndex: 'invoice_jumlah',
			width: 60,	//100,
			sortable: true,
			readOnly: true,
			renderer: Ext.util.Format.numberRenderer('0,000')
		},
		{
			header: '<div align="center">Sub Total (Rp)</div>',
			align: 'right',
			dataIndex: 'invoice_total',
			width: 100,
			sortable: true,
			hidden: true,
			readOnly: true,
			renderer: Ext.util.Format.numberRenderer('0,000')
		},
		{
			header: '<div align="center">Diskon (%)</div>',
			dataIndex: 'invoice_diskon',
			align: 'right',
			width: 50,	//100,
			sortable: true,
			readOnly: true,
			hidden: true,
			renderer: Ext.util.Format.numberRenderer('0,000')
		},
		{
			header: '<div align="center">Diskon (Rp)</div>',
			dataIndex: 'invoice_cashback',
			align: 'right',
			width: 80,
			sortable: true,
			readOnly: true,
			hidden: true,
			renderer: Ext.util.Format.numberRenderer('0,000')
		},
		{
			header: '<div align="center">Biaya (Rp)</div>',
			dataIndex: 'invoice_biaya',
			align: 'right',
			width: 80,
			sortable: true,
			hidden: true,
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true
		},
		{
			header: '<div align="center">Total Nilai (Rp)</div>',
			align: 'right',
			width:80,
			sortable: true,
			readOnly: true,
			renderer: function(v, params, record){
					invoice_total_nilai=Ext.util.Format.number((record.data.invoice_total-(record.data.invoice_diskon*record.data.invoice_total/100)+record.data.invoice_biaya-record.data.invoice_cashback),"0,000");
                    return '<span>' + invoice_total_nilai+ '</span>';
            }
		},
		{
			header: 'Jatuh Tempo',
			dataIndex: 'invoice_jatuhtempo',
			width: 70,	//100,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			readOnly: true
		}, 
		
		{
			header: '<div align="center">' + 'Keterangan' + '</div>',
			dataIndex: 'invoice_keterangan',
			sortable: true,
			hidden: true,
			width: 150
		}, 
		{
			header: '<div align="center">' + 'Stat Dok' + '</div>',
			dataIndex: 'invoice_status',
			sortable: true,
			width: 80
		}, 
		
		{
			header: 'Penagih',
			dataIndex: 'invoice_penagih',
			width: 150,
			sortable: true,
			readOnly: true,
			hidden: true
		}, 
		{
			header: 'Creator',
			dataIndex: 'invoice_creator',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Create on',
			dataIndex: 'invoice_date_create',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Last Update by',
			dataIndex: 'invoice_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Last Update on',
			dataIndex: 'invoice_date_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Revised',
			dataIndex: 'invoice_revised',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}	]);
	
	master_invoice_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	master_invoiceListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'master_invoiceListEditorGrid',
		el: 'fp_master_invoice',
		title: 'Daftar Penerimaan Tagihan',
		autoHeight: true,
		store: master_invoice_DataStore, // DataStore
		cm: master_invoice_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1220,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: master_invoice_DataStore,
			displayInfo: true
		}),
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_TAGIHAN'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<?php } ?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_TAGIHAN'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: master_invoice_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_TAGIHAN'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			disabled : true,
			handler: master_invoice_confirm_delete   // Confirm before deleting
		}, '-', 
		<?php } ?>
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: master_invoice_DataStore,
			params: {start: 0, limit: pageS},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						master_invoice_DataStore.baseParams={task:'LIST',start: 0, limit: pageS};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Search By (aktif only)'});
				Ext.get(this.id).set({qtip:'- No Tagihan<br>- No PB<br>- No PT<br>- Supplier<br>- Nama Penagih'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: master_invoice_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: master_invoice_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: master_invoice_print  
		}
		]
	});
	master_invoiceListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	master_invoice_ContextMenu = new Ext.menu.Menu({
		id: 'master_invoice_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_TAGIHAN'))){ ?>
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: master_invoice_confirm_update 
		},
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_TAGIHAN'))){ ?>
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			disabled : true,
			handler: master_invoice_confirm_delete 
		},
		<?php } ?>
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: master_invoice_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: master_invoice_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onmaster_invoice_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		master_invoice_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		master_invoice_SelectedRow=rowIndex;
		master_invoice_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function master_invoice_editContextMenu(){
		master_invoiceListEditorGrid.startEditing(master_invoice_SelectedRow,1);
  	}
	/* End of Function */
  	
		
	/* Identify  invoice_id Field */
	invoice_idField= new Ext.form.NumberField({
		id: 'invoice_idField',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: false,
		hidden: true,
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  invoice_no Field */
	invoice_noField= new Ext.form.TextField({
		id: 'invoice_noField',
		fieldLabel: 'No Tagihan',
		maxLength: 50,
		anchor: '95%'
	});
	
	/* Identify invoice_no_auto Field*/
	invoice_no_autoField= new Ext.form.TextField({
		id: 'invoice_no_autoField',
		fieldLabel: 'No PT',
		emptyText: '(Auto)',
		readOnly: true,
		maxLength: 50,
		anchor: '95%'
	});
	
	/* Identify  invoice_supplier Field */
	invoice_supplierField= new Ext.form.TextField({
		id: 'invoice_supplierField',
		fieldLabel: 'Supplier',
		maxLength: 50,
		//editable: ,
		readOnly : true,
		anchor: '95%'
	});
	invoice_supplier_idField=new Ext.form.NumberField();
	/* Identify  invoice_noterima Field */
	invoice_noterimaField= new Ext.form.ComboBox({
		id: 'invoice_noterimaField',
		fieldLabel: 'No PB',
		store: cbo_invoice_tbeliDataStore,
		mode: 'remote',
		displayField:'cbo_invoice_terima_no',
		valueField: 'cbo_invoice_terima_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: invoice_tbeli_tpl,
		forceSelection: true,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%',
		allowBlank: false
	});
	/* Identify  invoice_tanggal Field */
	invoice_tanggalField= new Ext.form.DateField({
		id: 'invoice_tanggalField',
		fieldLabel: 'Tanggal',
		format : 'd-m-Y'
	});
	
	invoice_subtotalField= new Ext.form.TextField({
		id: 'invoice_subtotalField',
		fieldLabel: 'Sub Total (Rp)',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		anchor: '75%',
		readOnly: true,
		maskRe: /([0-9]+)$/
	});
	
	invoice_jumlahitemField= new Ext.form.TextField({
		id: 'invoice_jumlahitemField',
		fieldLabel: 'Jumlah Total Barang',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		anchor: '75%',
		readOnly: true,
		maskRe: /([0-9]+)$/
	});
	
	invoice_jenisitemField= new Ext.form.TextField({
		id: 'invoice_jenisitemField',
		fieldLabel: 'Jumlah Jenis Barang',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		anchor: '75%',
		readOnly: true,
		maskRe: /([0-9]+)$/
	});
	
	/* Identify  invoice_nilai Field */
	invoice_biayaField= new Ext.form.TextField({
		id: 'invoice_biayaField',
		fieldLabel: 'Biaya (Rp)',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	invoice_diskonField= new Ext.form.TextField({
		id: 'invoice_diskonField',
		fieldLabel: 'Diskon (%)',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		anchor: '95%',
		maxLength: 2,
		readOnly: true,
		maskRe: /([0-9]+)$/
	});
	
	invoice_cashbackField= new Ext.form.TextField({
		id: 'invoice_cashbackField',
		fieldLabel: 'Diskon (Rp)',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		anchor: '95%',
		readOnly: true,
		maskRe: /([0-9]+)$/
	});
	
	
	invoice_uangmukaField= new Ext.form.TextField({
		id: 'invoice_uangmukaField',
		fieldLabel: 'Uang Muka (Rp)',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		anchor: '95%',
		readOnly: true,
		maskRe: /([0-9]+)$/
	});
	
	invoice_totalField= new Ext.form.TextField({
		id: 'invoice_totalField',
		fieldLabel: 'Total Tagihan (Rp)',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		anchor: '95%',
		readOnly: true,
		maskRe: /([0-9]+)$/
	});
	
	
	/* Identify  invoice_jatuhtempo Field */
	invoice_jatuhtempoField= new Ext.form.DateField({
		id: 'invoice_jatuhtempoField',
		fieldLabel: 'Jatuh Tempo',
		format : 'd-m-Y'
		//value : tempday
	});
	/* Identify  invoice_penagih Field */
	invoice_penagihField= new Ext.form.TextField({
		id: 'invoice_penagihField',
		fieldLabel: 'Penagih',
		maxLength: 50,
		anchor: '95%'
	});
	
	/* Identify invoice_keterangan Field*/
	invoice_keteranganField= new Ext.form.TextArea({
		id: 'invoice_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 500,
		anchor: '95%'
	});
	
	/* Identify invoice_status Field*/
	invoice_statusField= new Ext.form.ComboBox({
		id: 'invoice_statusField',
		fieldLabel: 'Status Dok',
		forceSelection: true,
		store:new Ext.data.SimpleStore({
			fields:['invoice_status_value', 'invoice_status_display'],
			data:[['Terbuka','Terbuka'],['Tertutup','Tertutup'],['Batal', 'Batal']]
		}),
		mode: 'local',
		displayField: 'invoice_status_display',
		valueField: 'invoice_status_value',
		anchor: '70%',
		allowBlank: false,
		triggerAction: 'all'	
	});
	
	
	invoice_orderDataStore = new Ext.data.Store({
		id: 'invoice_orderDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_invoice&m=get_invoice_order', 
			method: 'POST'
		}),
		baseParams:{terima_id: 0, start:0, limit: pageS},
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'order_id'
		},[
			{name: 'order_id', type: 'int', mapping: 'order_id'},
			{name: 'order_uangmuka', type: 'float', mapping: 'order_uangmuka'},
			{name: 'order_biaya', type: 'float', mapping: 'order_biaya'},
			{name: 'order_diskon', type: 'int', mapping: 'order_diskon'},
			{name: 'order_cashback', type: 'float', mapping: 'order_cashback'}
		]),
		sortInfo:{field: 'order_id', direction: "ASC"}
	});
	
	invoice_dtbeliDataStore = new Ext.data.Store({
		id: 'invoice_dtbeliDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_invoice&m=get_dtbeli_list', 
			method: 'POST'
		}),
		baseParams:{start:0, limit: pageS},
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'dinvoice_produk'
		},[
			{name: 'dinvoice_produk', type: 'int', mapping: 'produk'},
			{name: 'dinvoice_satuan', type: 'int', mapping: 'satuan'},
			{name: 'dinvoice_jumlah', type: 'int', mapping: 'jumlah_terima'},
			{name: 'dinvoice_harga', type: 'int', mapping:  'harga'},
			{name: 'dinvoice_diskon', type: 'int', mapping: 'diskon'}
		]),
		sortInfo:{field: 'dinvoice_produk', direction: "ASC"}
	});
	//invoice_dtbeliDataStore.load({params: {master:3}});
	
	
  	/*Fieldset Master*/
	master_invoice_masterGroup = new Ext.form.FieldSet({
		title: 'Master',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [invoice_idField, invoice_no_autoField, invoice_noterimaField, invoice_supplierField , invoice_noField, invoice_penagihField] 
			},
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [invoice_tanggalField, invoice_jatuhtempoField, invoice_keteranganField, invoice_statusField, invoice_idField] 
			}
			]
	
	});
	
		
	master_invoice_footerGroup = new Ext.form.FieldSet({
		title: '',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		labelWidth: 200,
		items:[
			{
				columnWidth:0.6,
				layout: 'form',
				border:false,
				items: [invoice_jumlahitemField, invoice_jenisitemField, invoice_subtotalField] 
			},
			{
				columnWidth:0.4,
				layout: 'form',
				labelWidth: 150,
				border:false,
				items: [invoice_biayaField, invoice_diskonField, invoice_cashbackField, invoice_uangmukaField, invoice_totalField] 
			}
			]
	
	});
		
	/*Detail Declaration */
		
	// Function for json reader of detail
	var detail_invoice_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: 'dinvoice_id'
	},[
			{name: 'dinvoice_id', type: 'int', mapping: 'dinvoice_id'}, 
			{name: 'dinvoice_master', type: 'int', mapping: 'dinvoice_master'}, 
			{name: 'dinvoice_produk', type: 'int', mapping: 'dinvoice_produk'}, 
			{name: 'dinvoice_satuan', type: 'int', mapping: 'dinvoice_satuan'}, 
			{name: 'dinvoice_jumlah', type: 'int', mapping: 'dinvoice_jumlah'}, 
			{name: 'dinvoice_harga', type: 'float', mapping: 'dinvoice_harga'}, 
			{name: 'dinvoice_diskon', type: 'float', mapping: 'dinvoice_diskon'} 
	]);
	//eof
	
	//function for json writer of detail
	var detail_invoice_writer = new Ext.data.JsonWriter({
		encode: true,
		writeAllFields: false
	});
	//eof
	
	/* Function for Retrieve DataStore of detail*/
	detail_invoice_DataStore = new Ext.data.Store({
		id: 'detail_invoice_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_invoice&m=detail_detail_invoice_list', 
			method: 'POST'
		}),
		baseParams:{start:0,limit:pageS},
		reader: detail_invoice_reader,
		sortInfo:{field: 'dinvoice_id', direction: "ASC"}
	});
	/* End of Function */
	
	//function for editor of detail
	var editor_detail_invoice= new Ext.ux.grid.RowEditor({
        saveText: 'Update'
    });
	//eof
	
	/*=== cbo_dproduk_byorderDataStore ==> mengambil "Detail Produk" dari detailList Modul Order Pembelian ===*/
	cbo_invoice_produkDataStore = new Ext.data.Store({
		id: 'cbo_invoice_produkDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_invoice&m=get_produk_list', 
			method: 'POST'
		}),
		baseParams: {task: 'detail',start: 0, limit: pageS},
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'produk_id'
		},[
			{name: 'produk_id', type: 'int', mapping: 'produk_id'},
			{name: 'produk_nama', type: 'string', mapping: 'produk_nama'},
			{name: 'produk_kategori', type: 'string', mapping: 'kategori_nama'}
		]),
		sortInfo:{field: 'produk_nama', direction: "ASC"}
	});
	/*======= END cbo_dproduk_byorderDataStore =======*/
	
	/*=== cbo_dproduk_byorderDataStore ==> mengambil "Detail Produk" dari detailList Modul Order Pembelian ===*/
	cbo_invoice_satuanDataStore = new Ext.data.Store({
		id: 'cbo_invoice_satuanDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_invoice&m=get_satuan_list', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'satuan_id'
		},[
			{name: 'satuan_id', type: 'int', mapping: 'satuan_id'},
			{name: 'satuan_nama', type: 'string', mapping: 'satuan_nama'},
			{name: 'satuan_kode', type: 'string', mapping: 'satuan_kode'}
		]),
		sortInfo:{field: 'satuan_nama', direction: "DESC"}
	});
	/*======= END cbo_dproduk_byorderDataStore =======*/
	
	Ext.util.Format.comboRenderer = function(combo){
		return function(value){
			var record = combo.findRecord(combo.valueField, value);
			return record ? record.get(combo.displayField) : combo.valueNotFoundText;
		}
	}
	
	var combo_invoice_produk=new Ext.form.ComboBox({
		store: cbo_invoice_produkDataStore,
		mode: 'remote',
		typeAhead: true,
		displayField: 'produk_nama',
		valueField: 'produk_id',
		triggerAction: 'all',
		lazyRender: false
	});
	
	var combo_invoice_satuan=new Ext.form.ComboBox({
		store: cbo_invoice_satuanDataStore,
		mode: 'local',
		typeAhead: true,
		displayField: 'satuan_nama',
		valueField: 'satuan_id',
		triggerAction: 'all',
		lazyRender: false
	});
	

	
	//declaration of detail coloumn model
	detail_invoice_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '<div align="center">ID</div>',
			dataIndex: 'dinvoice_id',
			width: 80,
			sortable: true,
			hidden: true,
			readOnly: true
		},
		{
			header: '<div align="center">Produk</div>',
			dataIndex: 'dinvoice_produk',
			width: 200,	//250,
			sortable: true,
			renderer: Ext.util.Format.comboRenderer(combo_invoice_produk)
		},
		{
			header: '<div align="center">Satuan</div>',
			dataIndex: 'dinvoice_satuan',
			width: 100,
			sortable: true,
			renderer: Ext.util.Format.comboRenderer(combo_invoice_satuan)
		},
		{
			header: '<div align="center">Jumlah</div>',
			align: 'right',
			dataIndex: 'dinvoice_jumlah',
			width: 60,
			renderer: Ext.util.Format.numberRenderer('0,000'),
			sortable: true,
			editable: false
		},
		{
			header: '<div align="center">Harga (Rp)</div>',
			align: 'right',
			dataIndex: 'dinvoice_harga',
			width: 100,	//150,
			sortable: true,
			renderer: Ext.util.Format.numberRenderer('0,000'),
			editor: new Ext.form.NumberField({
				allowDecimals: true,
				allowNegative: false,
				blankText: '0',
				maxLength: 22,
				maskRe: /([0-9]+)$/
			})
		},
		{
			header: '<div align="center">Diskon (%)</div>',
			dataIndex: 'dinvoice_diskon',
			width: 60,
			align: 'right',
			sortable: true,
			editor: new Ext.form.NumberField({
				allowDecimals: true,
				allowNegative: false,
				blankText: '0',
				maxLength: 2,
				maskRe: /([0-9]+)$/
			})
		},
		{
			header: '<div align="center">Sub Total (Rp)</div>',
			width: 100,	//150,
			align: 'right',
			sortable: true,
			readOnly: true,
			renderer: function(v, params, record){
					subtotal=Ext.util.Format.number((record.data.dinvoice_harga * record.data.dinvoice_jumlah*(100-record.data.dinvoice_diskon)/100),"0,000");
                    return subtotal;
            }
		}]
	);
	detail_invoice_ColumnModel.defaultSortable= true;
	//eof

	
	//declaration of detail list editor grid
	detail_invoiceListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'detail_invoiceListEditorGrid',
		el: 'fp_detail_invoice',
		title: 'Detail Item Barang',
		height: 250,
		width: 940,	//692,
		autoScroll: true,
		store: detail_invoice_DataStore, // DataStore
		colModel: detail_invoice_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 5 5 5',
		plugins: [editor_detail_invoice],
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true}
	});
	//eof
	
	
	//function of detail add
	function detail_invoice_add(){
		var edit_detail_invoice= new detail_invoiceListEditorGrid.store.recordType({
			dinvoice_id		: 0,		
			dinvoice_master	:'',		
			dinvoice_produk	: 0,		
			dinvoice_satuan	: 0,		
			dinvoice_jumlah	: 0,		
			dinvoice_harga	: 0,		
			dinvoice_diskon	: 0		
		});
		editor_detail_invoice.stopEditing();
		detail_invoice_DataStore.insert(0, edit_detail_invoice);
		detail_invoiceListEditorGrid.getView().refresh();
		detail_invoiceListEditorGrid.getSelectionModel().selectRow(0);
		editor_detail_invoice.startEditing(0);
	}
	
	function detail_invoice_add_bytbeli($dinvoice_produk, $dinvoice_satuan, $dinvoice_jumlah, $dinvoice_harga, $dinvoice_diskon){
		var edit_detail_invoice= new detail_invoiceListEditorGrid.store.recordType({
			dinvoice_id		: 0,		
			dinvoice_master	:'',		
			dinvoice_produk	:$dinvoice_produk,		
			dinvoice_satuan	:$dinvoice_satuan,		
			dinvoice_jumlah	:$dinvoice_jumlah,		
			dinvoice_harga	:$dinvoice_harga,		
			dinvoice_diskon	:$dinvoice_diskon		
		});
		detail_invoice_DataStore.insert(0, edit_detail_invoice);
		detail_invoiceListEditorGrid.getView().refresh();
		detail_invoiceListEditorGrid.getSelectionModel().selectRow(0);
		editor_detail_invoice.startEditing(0);
		editor_detail_invoice.stopEditing();
	}
	
	//function for refresh detail
	function refresh_detail_invoice(){
		detail_invoice_DataStore.commitChanges();
		detail_invoiceListEditorGrid.getView().refresh();
	}
	//eof
	
	//function for insert detail
	function detail_invoice_insert(pkid, opsi){
		var dinvoice_id 	= [];
        var dinvoice_produk = [];
        var dinvoice_satuan = [];
        var dinvoice_jumlah = [];
		var dinvoice_harga 	= [];
		var dinvoice_diskon	= [];
       
        if(detail_invoice_DataStore.getCount()>0){
            for(i=0; i<detail_invoice_DataStore.getCount();i++){
                if((/^\d+$/.test(detail_invoice_DataStore.getAt(i).data.dinvoice_produk))
				   && detail_invoice_DataStore.getAt(i).data.dinvoice_produk!==undefined
				   && detail_invoice_DataStore.getAt(i).data.dinvoice_produk!==''
				   && detail_invoice_DataStore.getAt(i).data.dinvoice_produk!==0
				   && detail_invoice_DataStore.getAt(i).data.dinvoice_satuan!==0
				   && detail_invoice_DataStore.getAt(i).data.dinvoice_jumlah>0){
                    
					if(detail_invoice_DataStore.getAt(i).data.dinvoice_id==undefined ||
					   detail_invoice_DataStore.getAt(i).data.dinvoice_id==''){
						detail_invoice_DataStore.getAt(i).data.dinvoice_id=0;
					}
					
                  	dinvoice_id.push(detail_invoice_DataStore.getAt(i).data.dinvoice_id);
					dinvoice_produk.push(detail_invoice_DataStore.getAt(i).data.dinvoice_produk);
                   	dinvoice_satuan.push(detail_invoice_DataStore.getAt(i).data.dinvoice_satuan);
					dinvoice_jumlah.push(detail_invoice_DataStore.getAt(i).data.dinvoice_jumlah);
					dinvoice_harga.push(detail_invoice_DataStore.getAt(i).data.dinvoice_harga);
					dinvoice_diskon.push(detail_invoice_DataStore.getAt(i).data.dinvoice_diskon);
					
                }
            }
			
			var encoded_array_dinvoice_id = Ext.encode(dinvoice_id);
			var encoded_array_dinvoice_produk = Ext.encode(dinvoice_produk);
			var encoded_array_dinvoice_satuan = Ext.encode(dinvoice_satuan);
			var encoded_array_dinvoice_jumlah = Ext.encode(dinvoice_jumlah);
			var encoded_array_dinvoice_harga  = Ext.encode(dinvoice_harga);
			var encoded_array_dinvoice_diskon = Ext.encode(dinvoice_diskon);
			
				
			Ext.Ajax.request({
				waitMsg: 'Mohon tunggu...',
				url: 'index.php?c=c_master_invoice&m=detail_detail_invoice_insert',
				params:{
					dinvoice_id		: encoded_array_dinvoice_id,
					dinvoice_master	: pkid, 
					dinvoice_produk	: encoded_array_dinvoice_produk,
					dinvoice_satuan	: encoded_array_dinvoice_satuan,
					dinvoice_jumlah	: encoded_array_dinvoice_jumlah,
					dinvoice_harga	: encoded_array_dinvoice_harga,
					dinvoice_diskon	: encoded_array_dinvoice_diskon
				},
				success:function(response){
					var result=eval(response.responseText);
					
					if(opsi=='print'){
						master_invoice_cetak_faktur(pkid);
					}
					master_invoice_DataStore.reload()
					
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
	function detail_invoice_purge(pkid){
		Ext.Ajax.request({
			waitMsg: 'Mohon tunggu...',
			url: 'index.php?c=c_master_invoice&m=detail_invoice_purge',
			params:{ master_id: pkid},
			success: function(response){
				detail_invoice_insert(pkid);
			}
		});
		master_invoice_DataStore.reload();
	}
	//eof
	
	/* Function for Delete Confirm of detail */
	function detail_invoice_confirm_delete(){
		if(detail_invoiceListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', detail_invoice_delete);
		} else if(detail_invoiceListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', detail_invoice_delete);
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
	function detail_invoice_delete(btn){
		if(btn=='yes'){
			var s = detail_invoiceListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, r; r = s[i]; i++){
				detail_invoice_DataStore.remove(r);
			}
		}  
	}
	//eof
	
	/* Function for retrieve create Window Panel*/ 
	master_invoice_createForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 940,	//700,        
		items: [master_invoice_masterGroup,detail_invoiceListEditorGrid, master_invoice_footerGroup],
		buttons: [
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_TAGIHAN'))){ ?>
			{
				text: 'Save and Print',
				handler: function (){ master_invoice_create('print') }
			},
			{
				text: 'Save',
				handler: function (){ master_invoice_create('close') }
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					master_invoice_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	master_invoice_createWindow= new Ext.Window({
		id: 'master_invoice_createWindow',
		title: post2db+' Penerimaan Tagihan',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_master_invoice_create',
		items: master_invoice_createForm
	});
	/* End Window */
	
	/* Function for action list search */
	function master_invoice_list_search(){
		// render according to a SQL date format.
		var invoice_id_search=null;
		var invoice_no_search=null;
		var invoice_no_auto_search=null;
		var invoice_supplier_search=null;
		var invoice_noterima_search=null;
		var invoice_tgl_awal_search_date="";
		var invoice_tgl_akhir_search_date="";
		var invoice_nilai_search=null;
		var invoice_jatuhtempo_search_date="";
		var invoice_penagih_search=null;
		var invoice_keterangan_search=null;
		var invoice_status_search=null;

		if(invoice_idSearchField.getValue()!==null){invoice_id_search=invoice_idSearchField.getValue();}
		if(invoice_noSearchField.getValue()!==null){invoice_no_search=invoice_noSearchField.getValue();}
		if(invoice_no_autoSearchField.getValue()!==null){invoice_no_auto_search=invoice_no_autoSearchField.getValue();}
		if(invoice_supplierSearchField.getValue()!==null){invoice_supplier_search=invoice_supplierSearchField.getValue();}
		if(invoice_noterimaSearchField.getValue()!==null){invoice_noterima_search=invoice_noterimaSearchField.getValue();}
		if(invoice_tgl_awalSearchField.getValue()!==""){invoice_tgl_awal_search_date=invoice_tgl_awalSearchField.getValue().format('Y-m-d');}
		if(invoice_tgl_akhirSearchField.getValue()!==""){invoice_tgl_akhir_search_date=invoice_tgl_akhirSearchField.getValue().format('Y-m-d');}
		//if(invoice_nilaiSearchField.getValue()!==null){invoice_nilai_search=invoice_nilaiSearchField.getValue();}
		if(invoice_jatuhtempoSearchField.getValue()!==""){invoice_jatuhtempo_search_date=invoice_jatuhtempoSearchField.getValue().format('Y-m-d');}
		if(invoice_penagihSearchField.getValue()!==null){invoice_penagih_search=invoice_penagihSearchField.getValue();}
		if(invoice_keteranganSearchField.getValue()!==null){invoice_keterangan_search=invoice_keteranganSearchField.getValue();}
		if(invoice_statusSearchField.getValue()!==null){invoice_status_search=invoice_statusSearchField.getValue();}
		
		// change the store parameters
		master_invoice_DataStore.baseParams = {
			task				: 'SEARCH',
			invoice_no			:	invoice_no_search, 
			invoice_no_auto		:	invoice_no_auto_search,
			invoice_supplier	:	invoice_supplier_search, 
			invoice_noterima	:	invoice_noterima_search, 
			invoice_tgl_awal	:	invoice_tgl_awal_search_date, 
			invoice_tgl_akhir	:	invoice_tgl_akhir_search_date, 
			//invoice_nilai		:	invoice_nilai_search, 
			invoice_jatuhtempo	:	invoice_jatuhtempo_search_date, 
			invoice_penagih		:	invoice_penagih_search, 
			invoice_keterangan	:	invoice_keterangan_search,
			invoice_status		:	invoice_status_search
		};
		// Cause the datastore to do another query : 
		master_invoice_DataStore.reload({params: {start: 0, limit: pageS}});
	}
		
	/* Function for reset search result */
	function master_invoice_reset_search(){
		// reset the store parameters
		master_invoice_DataStore.baseParams = { task: 'LIST', start: 0, limit: pageS };
		master_invoice_DataStore.reload({params: {start: 0, limit: pageS}});
		//master_invoice_searchWindow.close();
	};
	/* End of Fuction */

	function master_invoice_reset_SearchForm(){
		invoice_noSearchField.reset();
		invoice_no_autoSearchField.reset();
		invoice_supplierSearchField.reset();
		invoice_noterimaSearchField.reset();
		invoice_tgl_awalSearchField.reset();
		invoice_tgl_akhirSearchField.reset();
		invoice_nilaiSearchField.reset();
		invoice_jatuhtempoSearchField.reset();
		invoice_penagihSearchField.reset();
		invoice_keteranganSearchField.reset();
		invoice_statusSearchField.reset();
	}
	
	/* Field for search */
	/* Identify  invoice_id Search Field */
	invoice_idSearchField= new Ext.form.NumberField({
		id: 'invoice_idSearchField',
		fieldLabel: 'Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  invoice_no Search Field */
	invoice_noSearchField= new Ext.form.TextField({
		id: 'invoice_noSearchField',
		fieldLabel: 'No Tagihan',
		maxLength: 50,
		anchor: '95%'
	});
	
	/* Identify  invoice_no_auto Search Field */
	invoice_no_autoSearchField= new Ext.form.TextField({
		id: 'invoice_no_autoSearchField',
		fieldLabel: 'No PT',
		maxLength: 50,
		anchor: '95%'
	
	});
	
	/* Identify  invoice_supplier Search Field */
	invoice_supplierSearchField= new Ext.form.NumberField({
		id: 'invoice_supplierSearchField',
		fieldLabel: 'Supplier',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  invoice_noterima Search Field */
	invoice_noterimaSearchField= new Ext.form.ComboBox({
		id: 'invoice_noterimaSearchField',
		fieldLabel: 'No PB',
		store: cbo_invoice_tbeliDataStore,
		mode: 'remote',
		displayField:'cbo_invoice_terima_no',
		valueField: 'cbo_invoice_terima_id',
        typeAhead: false,
        loadingText: 'Mencari...',
        pageSize:10,
        hideTrigger:false,
        tpl: invoice_tbeli_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	
	});
	/* Identify  invoice_tanggal Search Field */
	invoice_tgl_awalSearchField= new Ext.form.DateField({
		id: 'invoice_tgl_awalSearchField',
		fieldLabel: 'Tanggal',
		format : 'd-m-Y'
	});
	
	invoice_tgl_akhirSearchField= new Ext.form.DateField({
		id: 'invoice_tgl_akhirSearchField',
		fieldLabel: 's/d',
		labelSeparator: ' ',
		format : 'd-m-Y',
		
	});
	
	/* Identify  invoice_nilai Search Field */
	invoice_nilaiSearchField= new Ext.form.NumberField({
		id: 'invoice_nilaiSearchField',
		fieldLabel: 'Nilai (Rp)',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  invoice_jatuhtempo Search Field */
	invoice_jatuhtempoSearchField= new Ext.form.DateField({
		id: 'invoice_jatuhtempoSearchField',
		fieldLabel: 'Jatuh Tempo',
		format : 'd-m-Y'
	
	});
	/* Identify  invoice_penagih Search Field */
	invoice_penagihSearchField= new Ext.form.TextField({
		id: 'invoice_penagihSearchField',
		fieldLabel: 'Penagih',
		maxLength: 50,
		anchor: '95%'
	});
	
	/* Identify  invoice_keterangan Search Field */
	invoice_keteranganSearchField= new Ext.form.TextField({
		id: 'invoice_keteranganSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 500,
		anchor: '95%'
	});
	
	
	invoice_label_tanggalField= new Ext.form.Label({ html: ' &nbsp; s/d  &nbsp;' });
    
	
	invoice_tgl_awalSearchFieldSet=new Ext.form.FieldSet({
		id:'invoice_tgl_awalSearchFieldSet',
		title: 'Opsi Tanggal',
		layout: 'column',
		boduStyle: 'padding: 5px;',
		frame: false,
		items:[invoice_tgl_awalSearchField]
	});
	
	invoice_statusSearchField= new Ext.form.ComboBox({
		id: 'invoice_statusSearchField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['value', 'invoice_status'],
			data:[['Terbuka','Terbuka'],['Tertutup','Tertutup'],['Batal','Batal']]
		}),
		mode: 'local',
		displayField: 'invoice_status',
		valueField: 'value',
		anchor: '80%',
		triggerAction: 'all'	 
	
	});
	

    
	/* Function for retrieve search Form Panel */
	master_invoice_searchForm = new Ext.FormPanel({
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
				items: [invoice_no_autoSearchField, invoice_noSearchField, invoice_noterimaSearchField,
						{
							layout: 'column',
							border: false,
							items: [{
								layout: 'form',
								columnWidth: 0.6,
								border: false,
								labelWidth: 100,
								items:[invoice_tgl_awalSearchField]
							},{
								layout: 'form',
								columnWidth: 0.3,
								border: false,
								labelWidth: 15,
								items:[invoice_tgl_akhirSearchField]
							}]
						}, invoice_jatuhtempoSearchField, 
						invoice_penagihSearchField, invoice_keteranganSearchField, invoice_statusSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: master_invoice_list_search
			},{
				text: 'Close',
				handler: function(){
					master_invoice_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	master_invoice_searchWindow = new Ext.Window({
		title: 'Pencarian Penerimaan Tagihan',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_master_invoice_search',
		items: master_invoice_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!master_invoice_searchWindow.isVisible()){
			master_invoice_reset_SearchForm();
			master_invoice_searchWindow.show();
		} else {
			master_invoice_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	function master_invoice_cetak_faktur(pkid){
		
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_master_invoice&m=print_faktur',
		params: {
			faktur	: pkid
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/tagihan_faktur.html','tagihan_faktur','height=800,width=600,resizable=1,scrollbars=1, menubar=1');
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
	function master_invoice_print(){
		var searchquery = "";
		var invoice_no_print=null;
		var invoice_supplier_print=null;
		var invoice_noterima_print=null;
		var invoice_tgl_awal_print_date="";
		var invoice_tgl_akhir_print_date="";
		var invoice_nilai_print=null;
		var invoice_jatuhtempo_print_date="";
		var invoice_penagih_print=null;
		var win;              
		// check if we do have some search data...
		if(master_invoice_DataStore.baseParams.query!==null){searchquery = master_invoice_DataStore.baseParams.query;}
		if(master_invoice_DataStore.baseParams.invoice_no!==null){invoice_no_print = master_invoice_DataStore.baseParams.invoice_no;}
		if(master_invoice_DataStore.baseParams.invoice_supplier!==null){invoice_supplier_print = master_invoice_DataStore.baseParams.invoice_supplier;}
		if(master_invoice_DataStore.baseParams.invoice_noterima!==null){invoice_noterima_print = master_invoice_DataStore.baseParams.invoice_noterima;}
		if(master_invoice_DataStore.baseParams.invoice_tgl_awal!==""){invoice_tgl_awal_print_date = master_invoice_DataStore.baseParams.invoice_tgl_awal;}
		if(master_invoice_DataStore.baseParams.invoice_tgl_akhir!==""){invoice_tgl_akhir_print_date = master_invoice_DataStore.baseParams.invoice_tgl_akhir;}
		//if(master_invoice_DataStore.baseParams.invoice_nilai!==null){invoice_nilai_print = master_invoice_DataStore.baseParams.invoice_nilai;}
		if(master_invoice_DataStore.baseParams.invoice_jatuhtempo!==""){invoice_jatuhtempo_print_date = master_invoice_DataStore.baseParams.invoice_jatuhtempo;}
		if(master_invoice_DataStore.baseParams.invoice_penagih!==null){invoice_penagih_print = master_invoice_DataStore.baseParams.invoice_penagih;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_master_invoice&m=get_action',
		params: {
			task				: "PRINT",
		  	query				: searchquery,                    		
			invoice_no 			: invoice_no_print,
			invoice_supplier 	: invoice_supplier_print,
			invoice_noterima 	: invoice_noterima_print,
		  	invoice_tgl_awal 	: invoice_tgl_awal_print_date, 
			invoice_tgl_akhir 	: invoice_tgl_akhir_print_date, 
			//invoice_nilai 		: invoice_nilai_print,
		  	invoice_jatuhtempo 	: invoice_jatuhtempo_print_date, 
			invoice_penagih 	: invoice_penagih_print,
		  	currentlisting		: master_invoice_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/print_tagihanlist.html','master_invoicelist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
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
	function master_invoice_export_excel(){
		var searchquery = "";
		var invoice_no_2excel=null;
		var invoice_supplier_2excel=null;
		var invoice_noterima_2excel=null;
		var invoice_tgl_awal_2excel_date="";
		var invoice_tgl_akhir_2excel_date="";
		var invoice_nilai_2excel=null;
		var invoice_jatuhtempo_2excel_date="";
		var invoice_penagih_2excel=null;
		var win;              
		// check if we do have some search data...
		if(master_invoice_DataStore.baseParams.query!==null){searchquery = master_invoice_DataStore.baseParams.query;}
		if(master_invoice_DataStore.baseParams.invoice_no!==null){invoice_no_2excel = master_invoice_DataStore.baseParams.invoice_no;}
		if(master_invoice_DataStore.baseParams.invoice_supplier!==null){invoice_supplier_2excel = master_invoice_DataStore.baseParams.invoice_supplier;}
		if(master_invoice_DataStore.baseParams.invoice_noterima!==null){invoice_noterima_2excel = master_invoice_DataStore.baseParams.invoice_noterima;}
		if(master_invoice_DataStore.baseParams.invoice_tgl_awal!==""){invoice_tgl_awal_2excel_date = master_invoice_DataStore.baseParams.invoice_tgl_awal;}
		if(master_invoice_DataStore.baseParams.invoice_tgl_akhir!==""){invoice_tgl_akhir_2excel_date = master_invoice_DataStore.baseParams.invoice_tgl_akhir;}
		//if(master_invoice_DataStore.baseParams.invoice_nilai!==null){invoice_nilai_2excel = master_invoice_DataStore.baseParams.invoice_nilai;}
		if(master_invoice_DataStore.baseParams.invoice_jatuhtempo!==""){invoice_jatuhtempo_2excel_date = master_invoice_DataStore.baseParams.invoice_jatuhtempo;}
		if(master_invoice_DataStore.baseParams.invoice_penagih!==null){invoice_penagih_2excel = master_invoice_DataStore.baseParams.invoice_penagih;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_master_invoice&m=get_action',
		params: {
			task				: "EXCEL",
		  	query				: searchquery,                    		
			invoice_no 			: invoice_no_2excel,
			invoice_supplier 	: invoice_supplier_2excel,
			invoice_noterima 	: invoice_noterima_2excel,
		  	invoice_tgl_awal 	: invoice_tgl_awal_2excel_date, 
			invoice_tgl_akhir 	: invoice_tgl_akhir_2excel_date, 
			//invoice_nilai 		: invoice_nilai_2excel,
		  	invoice_jatuhtempo 	: invoice_jatuhtempo_2excel_date, 
			invoice_penagih 	: invoice_penagih_2excel,
		  	currentlisting		: master_invoice_DataStore.baseParams.task // this tells us if we are searching or not
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
	
	function get_total_invoice(){
		var total_barang=0;
		var total_nilai=0;
		
		for(i=0;i<detail_invoice_DataStore.getCount();i++){
			record_dinvoice=detail_invoice_DataStore.getAt(i);
			total_barang=total_barang+record_dinvoice.data.dinvoice_jumlah;
			total_nilai=total_nilai+record_dinvoice.data.dinvoice_jumlah*record_dinvoice.data.dinvoice_harga*(100-record_dinvoice.data.dinvoice_diskon)/100;
		}
		invoice_jumlahitemField.setValue(CurrencyFormatted(total_barang));
		invoice_jenisitemField.setValue(CurrencyFormatted(detail_invoice_DataStore.getCount()));
		invoice_subtotalField.setValue(CurrencyFormatted(total_nilai));
		get_total_tagihan();
	}
	
	function get_total_tagihan(){
		var total_tagihan=0;
		var total_diskon=0;
		
		total_tagihan=convertToNumber(invoice_subtotalField.getValue())-convertToNumber(invoice_cashbackField.getValue());
		total_diskon=convertToNumber(invoice_subtotalField.getValue())*convertToNumber(invoice_diskonField.getValue())/100;
		total_tagihan=total_tagihan+convertToNumber(invoice_biayaField.getValue())-convertToNumber(invoice_uangmukaField.getValue())-total_diskon;
		invoice_totalField.setValue(CurrencyFormatted(total_tagihan));
	}
	
	//EVENTS
	master_invoiceListEditorGrid.addListener('rowcontextmenu', onmaster_invoice_ListEditGridContextMenu);
	master_invoice_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	
	detail_invoice_DataStore.on("update",function(){
		get_total_invoice();
	});
	
	invoice_biayaField.on('focus',function(){ invoice_biayaField.setValue(convertToNumber(invoice_biayaField.getValue())) });
	invoice_biayaField.on('blur',function(){ invoice_biayaField.setValue(CurrencyFormatted(invoice_biayaField.getValue())) });
	
	invoice_noterimaField.on('select', function(){
		
		invoice_orderDataStore.setBaseParam('terima_id',invoice_noterimaField.getValue());
		invoice_orderDataStore.load({
			callback:function(opts, response, success){
				if(success==true){
					var data_invoice_order=invoice_orderDataStore.getAt(0);
					invoice_diskonField.setValue(data_invoice_order.data.order_diskon);
					invoice_cashbackField.setValue(data_invoice_order.data.order_cashback);
					invoice_uangmukaField.setValue(data_invoice_order.data.order_uangmuka);
					invoice_biayaField.setValue(data_invoice_order.data.order_biaya);
				}
			}
		});
		get_total_tagihan();
		
		cbo_invoice_produkDataStore.setBaseParam('terima_id',invoice_noterimaField.getValue());
		cbo_invoice_produkDataStore.setBaseParam('task','terima');
		cbo_invoice_produkDataStore.load({
			callback:function(opts, response, success){
				if(success==true){
					var j=cbo_invoice_tbeliDataStore.findExact('cbo_invoice_terima_id',invoice_noterimaField.getValue(),0);
		
					if(cbo_invoice_tbeliDataStore.getCount()){
						invoice_supplierField.setValue(cbo_invoice_tbeliDataStore.getAt(j).data.cbo_invoice_terima_supplier);
						invoice_supplier_idField.setValue(cbo_invoice_tbeliDataStore.getAt(j).data.cbo_invoice_terima_supplier_id);
							
						invoice_dtbeliDataStore.load({
							params: {master:invoice_noterimaField.getValue()},
							callback: function(opts, response, success){
								if(success==true){
									detail_invoice_DataStore.removeAll();
									for(i=0;i<invoice_dtbeliDataStore.getTotalCount();i++){
										var dtbeli_record=invoice_dtbeliDataStore.getAt(i);
										detail_invoice_DataStore.insert(i,dtbeli_record);	
									}
									get_total_invoice();
								}
							}
						});
						detail_invoice_DataStore.commitChanges();
					}
				}
			}
										 
		});
		
		
		
	});
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_master_invoice"></div>
         <div id="fp_detail_invoice"></div>
		<div id="elwindow_master_invoice_create"></div>
        <div id="elwindow_master_invoice_search"></div>
    </div>
</div>
</body>