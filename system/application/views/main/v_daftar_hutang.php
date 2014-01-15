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
var list_hutang_DataStore;
var list_hutang_ColumnModel;
var list_hutang_ListEditorGrid;
var list_hutang_createForm;
var list_hutang_createWindow;
var list_hutang_searchForm;
var list_hutang_searchWindow;
var list_hutang_SelectedRow;
var list_hutang_ContextMenu;
var today=new Date().format('Y-m-d');
var date_end=new Date().add(Date.DAY, +5).format('Y-m-d');
//date_end.setDate(today.getDate()+5);

//declare konstant
var list_hutang_post2db = '';
var msg = '';
var pageS_hutang=15;

/* declare variable here */
var list_hutang_idField;
var list_hutang_kodeField;
var list_hutang_namaField;
var bank_norekField;
var ship_namaField;
var bank_saldoField;
var list_hutang_keteranganField;
var list_hutang_aktifField;

var list_hutang_idSearchField;
var list_hutang_kodeSearchField;
var bank_namaSearchField;
var bank_norekSearchField;
var bank_atasnamaSearchField;
var bank_saldoSearchField;
var list_hutang_keteranganSearchField;
var list_hutang_aktifSearchField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  	// utilize custom extension for Group Summary
    var summary = new Ext.ux.grid.GroupSummary();
  
  /* Function for Saving inLine Editing */
  function list_hutang_update(oGrid_event){
  	// alert(oGrid_event);
	var hutang_id_update_pk="";
	var hutang_order_faktur="";
	var hutang_faktur_update=null;
	var hutang_supplier_update=null;
	var hutang_tanggal_update=null;
	var hutang_tanggal_jatuh_tempo_update=null;
	var hutang_invoice_update=null;
	var hutang_keterangan_update=null;
	var hutang_status_update=null;
	var hutang_status_hutang_update=null;
	var hutang_total_update=null;

	hutang_id_update_pk = oGrid_event.record.data.hutang_op_id;
	if(oGrid_event.record.data.hutang_faktur!== null){hutang_order_faktur = oGrid_event.record.data.hutang_faktur;}
	if(oGrid_event.record.data.supplier_id!== null){hutang_supplier_update = oGrid_event.record.data.supplier_id;}
	if(oGrid_event.record.data.hutang_tanggal!== null){hutang_tanggal_update = oGrid_event.record.data.hutang_tanggal.format('Y-m-d');}
	if(oGrid_event.record.data.hutang_jatuhtempo!== null){hutang_tanggal_jatuh_tempo_update = oGrid_event.record.data.hutang_jatuhtempo.format('Y-m-d');}
	if(oGrid_event.record.data.hutang_status_hutang!== null){hutang_status_hutang_update = oGrid_event.record.data.hutang_status_hutang;}
	if(oGrid_event.record.data.hutang_invoice!== null){hutang_invoice_update = oGrid_event.record.data.hutang_invoice;}
	if(oGrid_event.record.data.hutang_keterangan!== null){hutang_keterangan_update = oGrid_event.record.data.hutang_keterangan;}
	if(oGrid_event.record.data.hutang_status!== null){hutang_status_update = oGrid_event.record.data.hutang_status;}
	if(oGrid_event.record.data.hutang_total!== null){hutang_total_update = oGrid_event.record.data.hutang_total;}

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_daftar_hutang&m=get_action',
			params: {
				task: "UPDATE",
				hutang_order_id				: hutang_id_update_pk,				
				hutang_order_faktur			: hutang_order_faktur,				
				hutang_supplier				: hutang_supplier_update,		
				hutang_tanggal				: hutang_tanggal_update,		
				hutang_tanggal_jatuh_tempo	: hutang_tanggal_jatuh_tempo_update,		
				hutang_invoice				: hutang_invoice_update,		
				hutang_keterangan			: hutang_keterangan_update,		
				hutang_status				: hutang_status_update,		
				hutang_status_hutang		: hutang_status_hutang_update,		
				hutang_total				: hutang_total_update
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						list_hutang_DataStore.commitChanges();
						list_hutang_DataStore.reload();
						break;
					case 2:
						list_hutang_DataStore.reload();
						break;
					default:
						Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Data Ship tidak bisa disimpan.',
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
	function ship_create(){
		if(is_ship_form_valid()){
		
		var ship_id_create_pk=null;
		//var bank_kode_create=null;
		//var bank_nama_create=null;
		//var bank_norek_create=null;
		var ship_nama_create=null;
		//var bank_saldo_create=null;
		var ship_keterangan_create=null;
		var ship_aktif_create=null;

		ship_id_create_pk=get_pk_id();
		//if(list_hutang_kodeField.getValue()!== null){bank_kode_create = list_hutang_kodeField.getValue();}
		//if(list_hutang_namaField.getValue()!== null){bank_nama_create = list_hutang_namaField.getValue();}
		//if(bank_norekField.getValue()!== null){bank_norek_create = bank_norekField.getValue();}
		if(ship_namaField.getValue()!== null){ship_nama_create = ship_namaField.getValue();}
		//if(bank_saldoField.getValue()!== null){bank_saldo_create = convertToNumber(bank_saldoField.getValue());}
		if(list_hutang_keteranganField.getValue()!== null){ship_keterangan_create = list_hutang_keteranganField.getValue();}
		if(list_hutang_aktifField.getValue()!== null){ship_aktif_create = list_hutang_aktifField.getValue();}

		Ext.Ajax.request({  
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_daftar_hutang&m=get_action',
				params: {
					task: list_hutang_post2db,
					ship_id			: ship_id_create_pk,	
					//bank_kode		: bank_kode_create,	
					//bank_nama		: bank_nama_create,	
					//bank_norek	: bank_norek_create,	
					ship_nama		: ship_nama_create,	
					//bank_saldo	: bank_saldo_create,	
					ship_keterangan	: ship_keterangan_create,	
					ship_aktif		: ship_aktif_create
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							Ext.MessageBox.alert(list_hutang_post2db+' OK','Data Ship berhasil disimpan.');
							list_hutang_DataStore.reload();
							list_hutang_createWindow.hide();
							break;
						default:
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Data Ship tidak bisa disimpan!.',
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
		if(list_hutang_post2db=='UPDATE')
			return list_hutang_ListEditorGrid.getSelectionModel().getSelected().get('ship_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function bank_reset_form(){
		list_hutang_kodeField.reset();
		list_hutang_kodeField.setValue(null);
		list_hutang_namaField.reset();
		list_hutang_namaField.setValue(null);
		bank_norekField.reset();
		bank_norekField.setValue(null);
		ship_namaField.reset();
		ship_namaField.setValue(null);
		bank_saldoField.reset();
		bank_saldoField.setValue(null);
		list_hutang_keteranganField.reset();
		list_hutang_keteranganField.setValue(null);
		list_hutang_aktifField.reset();
		list_hutang_aktifField.setValue('Aktif');
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function ship_set_form(){
		//list_hutang_kodeField.setValue(list_hutang_ListEditorGrid.getSelectionModel().getSelected().get('bank_kode'));
		//list_hutang_namaField.setValue(list_hutang_ListEditorGrid.getSelectionModel().getSelected().get('bank_nama'));
		//bank_norekField.setValue(list_hutang_ListEditorGrid.getSelectionModel().getSelected().get('bank_norek'));
		ship_namaField.setValue(list_hutang_ListEditorGrid.getSelectionModel().getSelected().get('ship_nama'));
		//bank_saldoField.setValue(CurrencyFormatted(list_hutang_ListEditorGrid.getSelectionModel().getSelected().get('bank_saldo')));
		list_hutang_keteranganField.setValue(list_hutang_ListEditorGrid.getSelectionModel().getSelected().get('hutang_keterangan'));
		list_hutang_aktifField.setValue(list_hutang_ListEditorGrid.getSelectionModel().getSelected().get('hutang_status'));
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_ship_form_valid(){
		return (ship_namaField.isValid());
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!list_hutang_createWindow.isVisible()){
			
			list_hutang_post2db='CREATE';
			msg='created';
			bank_reset_form();
			
			list_hutang_createWindow.show();
		} else {
			list_hutang_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function bank_confirm_delete(){
		// only one bank is selected here
		if(list_hutang_ListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', bank_delete);
		} else if(list_hutang_ListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', bank_delete);
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
	function ship_confirm_update(){
		/* only one record is selected here */
		if(list_hutang_ListEditorGrid.selModel.getCount() == 1) {
			
			list_hutang_post2db='UPDATE';
			msg='updated';
			ship_set_form();
			
			list_hutang_createWindow.show();
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
	function bank_delete(btn){
		if(btn=='yes'){
			var selections = list_hutang_ListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< list_hutang_ListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.bank_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_daftar_hutang&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							list_hutang_DataStore.reload();
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
	list_hutang_DataStore = new Ext.data.Store({
		id: 'list_hutang_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_daftar_hutang&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start: 0, limit: pageS_hutang}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'hutang_id'
		},[
			{name: 'hutang_id', type: 'int', mapping: 'hutang_id'},
			{name: 'hutang_no', type: 'string', mapping: 'hutang_no'},
			{name: 'supplier_id', type: 'string', mapping: 'supplier_id'},
			{name: 'hutang_op_id', type: 'string', mapping: 'hutang_op_id'},
			{name: 'supplier_nama', type: 'string', mapping: 'supplier_nama'},
			{name: 'hutang_faktur', type: 'string', mapping: 'hutang_faktur'},
			{name: 'hutang_total', type: 'float', mapping: 'hutang_total'},
			{name: 'hutang_total_terima', type: 'float', mapping: 'total_terima'},
			{name: 'hutang_sisa', type: 'float', mapping: 'hutang_sisa'},
			{name: 'hutang_invoice', type: 'string', mapping: 'hutang_invoice'},
			{name: 'hutang_keterangan', type: 'string', mapping: 'hutang_keterangan'},
			{name: 'hutang_status', type: 'string', mapping: 'hutang_status'},
			{name: 'hutang_status_hutang', type: 'string', mapping: 'hutang_status_hutang'},
			{name: 'ship_creator', type: 'string', mapping: 'ship_creator'},
			{name: 'ship_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'ship_date_create'},
			{name: 'hutang_tanggal', type: 'date', dateFormat: 'Y-m-d', mapping: 'hutang_tanggal'},
			{name: 'hutang_jatuhtempo', type: 'date', dateFormat: 'Y-m-d', mapping: 'hutang_jatuhtempo'},
			{name: 'ship_update', type: 'string', mapping: 'ship_update'},
			{name: 'ship_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'ship_date_update'},
			{name: 'ship_revised', type: 'int', mapping: 'ship_revised'}
		]),
		sortInfo:{field: 'hutang_jatuhtempo', direction: "ASC"}
	});
	/* End of Function */
	
	cbo_bank_akunDataStore = new Ext.data.Store({
		id: 'cbo_bank_akunDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_daftar_hutang&m=get_akun_list', 
			method: 'POST'
		}),
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'akun_id'
		},[
			{name: 'bank_akun_value', type: 'int', mapping: 'akun_id'},
			{name: 'bank_akun_display', type: 'string', mapping: 'akun_nama'}
		]),
		sortInfo:{field: 'bank_akun_value', direction: "ASC"}
	});
	
	cbo_bank_mbankDataStore = new Ext.data.Store({
	id: 'cbo_bank_mbankDataStore',
	proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_daftar_hutang&m=get_mbank_list', 
			method: 'POST'
		}),
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'mbank_id'
		},[
			{name: 'bank_mbank_value', type: 'int', mapping: 'mbank_id'},
			{name: 'bank_mbank_display', type: 'string', mapping: 'mbank_nama'}
		]),
	sortInfo:{field: 'bank_mbank_display', direction: "ASC"}
	});


	/* Start Data Store untuk Detail List Piutang */
	detail_list_hutang_DataStore = new Ext.data.GroupingStore({
		id: 'detail_list_hutang_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_daftar_hutang&m=detail_list_hutang_list', 
			method: 'POST'
		}),
		baseParams:{task: "LIST",start:0,limit:100}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'//,
		},[
        	{name: 'dhutang_id', type: 'int', mapping: 'dhutang_id'}, 
			{name: 'status_dokumen', type: 'string', mapping: 'status_dokumen'}, 
			{name: 'nobukti', type: 'string', mapping: 'nobukti'}, 
			{name: 'keterangan', type: 'string', mapping: 'keterangan'}, 
			{name: 'creator', type: 'string', mapping: 'creator'}, 
			{name: 'dhutang_cara', type: 'string', mapping: 'dhutang_cara'}, 
			{name: 'tanggal', type: 'date', dateFormat: 'Y-m-d', mapping: 'tanggal'}, 
			{name: 'dhutang_nilai', type: 'float', mapping: 'dhutang_nilai'},
			{name: 'dfcl_update', type: 'string', mapping: 'dfcl_update'}, 
			{name: 'dfcl_date_update', type: 'date', dateFormat: 'Y-m-d', mapping: 'dfcl_date_update'}
		]),
		sortInfo:{field: 'dhutang_id', direction: "ASC"}
		//groupField: 'customer_nama'
	});
	/* End DataStore */

	
  	/* Function for Identify of Window Column Model */
	list_hutang_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'hutang_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},
		{
			header: '#',
			readOnly: true,
			dataIndex: 'hutang_op_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},
		{
			header: 'Supplier',
			dataIndex: 'supplier_nama',
			width: 100,
			sortable: true
		},
		{
			header: 'No Faktur OP',
			dataIndex: 'hutang_faktur',
			width: 100,
			sortable: true
		},
		{
			header: '<div align="center">' + 'Tgl Faktur Hutang' + '</div>',
			dataIndex: 'hutang_tanggal',
			width: 120,	//150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			editor: new Ext.form.DateField({
				format: 'd-m-Y'
			})
		}, 
		{
			header: '<div align="center">' + 'Tgl Jatuh Tempo' + '</div>',
			dataIndex: 'hutang_jatuhtempo',
			width: 70,	//150,
			sortable: true,
			//renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			renderer: function(value, cell, record){
				//cell.css = "readonlycell";

				//alert (date_end);
				//alert (record.data.hutang_jatuhtempo.dateFormat('Y-m-d'));
				if(record.data.hutang_jatuhtempo.dateFormat('Y-m-d')<=date_end && record.data.hutang_jatuhtempo.dateFormat('Y-m-d')>=today){
					return '<span style="color:red; font-size:120%;"><b>' + value.dateFormat('d-m-Y') + '</span>';
				}else if(record.data.hutang_jatuhtempo.dateFormat('Y-m-d')<today){
					return '<span style="color:#820000; font-size:130%;"><b>' + value.dateFormat('d-m-Y') + '</span>';
				}else{
					return value.dateFormat('d-m-Y');
				}
			},	
			editor: new Ext.form.DateField({
				format: 'd-m-Y'
			})
		},
		{
			header: 'No Invoice',
			dataIndex: 'hutang_invoice',
			width: 100,
			hidden: false,
			sortable: true,
			editor: new Ext.form.TextField({
				maxLength: 250,
			})
		},
		{
			header: 'Total PO(Rp)',
			dataIndex: 'hutang_total',
			width: 100,
			align: 'right',
			sortable: true,
			renderer: function(val){
				return '<span>Rp. '+Ext.util.Format.number(val,'0,000')+'</span>';
			}
		},
		{
			header: 'Total LBM(Rp)',
			dataIndex: 'hutang_total_terima',
			width: 100,
			align: 'right',
			sortable: true,
			renderer: function(val){
				return '<span>Rp. '+Ext.util.Format.number(val,'0,000')+'</span>';
			}
		},
		{
			header: 'Sisa (Rp)',
			dataIndex: 'hutang_sisa',
			width: 100,
			align: 'right',
			sortable: true,
			hidden: true,
			renderer: function(val){
				return '<span>Rp. '+Ext.util.Format.number(val,'0,000')+'</span>';
			}
		},
		{
			header: 'Keterangan',
			dataIndex: 'hutang_keterangan',
			width: 100,
			hidden: false,
			sortable: true
		},
		{
			header: 'Status',
			dataIndex: 'hutang_status',
			width: 80,
			hidden: true,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_ship'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['ship_aktif_value', 'ship_aktif_display'],
					data: [['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
					}),
				mode: 'local',
               	displayField: 'ship_aktif_display',
               	valueField: 'ship_aktif_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
			<?php } ?>
		},
		{
			header: 'Status Hutang',
			dataIndex: 'hutang_status_hutang',
			width: 80,
			hidden: false,
			sortable: true,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['ship_aktif_value', 'ship_aktif_display'],
					data: [['Terbuka','Terbuka'],['Tertutup','Tertutup']]
					}),
				mode: 'local',
               	displayField: 'ship_aktif_display',
               	valueField: 'ship_aktif_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })

		},
		
		{
			header: 'Creator',
			dataIndex: 'ship_creator',
			width: 150,
			sortable: true,
			hidden:true
		},
		{
			header: 'Create on',
			dataIndex: 'ship_date_create',
			width: 150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			hidden:true
		},
		{
			header: 'Last Update By',
			dataIndex: 'ship_update',
			width: 150,
			sortable: true,
			hidden:true
		},
		{
			header: 'Last Update on',
			dataIndex: 'ship_date_update',
			width: 150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			hidden:true
		},
		{
			header: 'Revised',
			dataIndex: 'ship_revised',
			width: 150,
			sortable: true,
			hidden:true
		}]
	);
	list_hutang_ColumnModel.defaultSortable= true;
	/* End of Function */

	//ColumnModel for Detail List Piutang
	detail_list_hutang_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '<div align="center">' + 'Tgl' + '</div>',
			dataIndex: 'tanggal',
			width: 50,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y')
		},
		{
			header: '<div align="center">' + 'No Bukti' + '</div>',
			dataIndex: 'nobukti',
			width: 80,
			sortable: true
		},
		{
			header: 'Nilai (Rp)',
			dataIndex: 'dhutang_nilai',
			width: 100,
			align: 'right',
			sortable: true,
			renderer: function(val){
				return '<span>Rp. '+Ext.util.Format.number(val,'0,000')+'</span>';
			}
		},
		{
			header: '<div align="center">' + 'Cara Bayar' + '</div>',
			dataIndex: 'dhutang_cara',
			width: 130,
			sortable: true
		},
		{
			header: '<div align="center">' + 'Keterangan' + '</div>',
			dataIndex: 'keterangan',
			width: 130,
			sortable: true
		}]
    );
    detail_list_hutang_ColumnModel.defaultSortable= true;

    
	/* Declare DataStore and  show datagrid list */
	list_hutang_ListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'list_hutang_ListEditorGrid',
		el: 'fp_list_hutang',
		title: ' List Pengakuan Hutang',
		autoHeight: true,
		store: list_hutang_DataStore, // DataStore
		cm: list_hutang_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1200,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS_hutang,
			store: list_hutang_DataStore,
			displayInfo: true
		}),
		/* Add Control on ToolBar */
		tbar: [
		/*
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_BANKREK'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<?php } ?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_BANKREK'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: ship_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_BANKREK'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			disabled:true,
			handler: bank_confirm_delete   // Confirm before deleting
		}, '-', 
		<?php } ?>

		
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			disabled:true,
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: list_hutang_DataStore,
			params: {task: 'LIST',start: 0, limit: pageS_hutang},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						list_hutang_DataStore.baseParams={task:'LIST',start: 0, limit: pageS_hutang};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Search By'});
				Ext.get(this.id).set({qtip:'- Kode Akun<br>- Nama Bank<br>- No.Rekening<br>- Atas Nama'});
				}
			},
			width: 120
		}),'-',*/{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: lpiutang_reset_search,
			iconCls:'icon-refresh'
		}/*,'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			disabled:true,
			handler: listpiutang_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			disabled:true,
			handler: listpiutang_print  
		}*/
		]
	});
	list_hutang_ListEditorGrid.render();
	/* End of DataStore */
	
	/*Event ketika ngeklik List Piutang*/
/*
	list_hutang_ListEditorGrid.on('rowclick', function (list_hutang_ListEditorGrid, rowIndex, eventObj) {
        var dp_recordMaster = list_hutang_ListEditorGrid.getSelectionModel().getSelected();
        detail_list_hutang_DataStore.setBaseParam('master_id',dp_recordMaster.get("hutang_id"));
        detail_list_hutang_DataStore.setBaseParam('supplier_id',dp_recordMaster.get("supplier_id"));
		detail_list_hutang_DataStore.load({params : {master_id : dp_recordMaster.get("hutang_id"), supplier_id : dp_recordMaster.get("supplier_id"), start:0, limit:100}});
		list_hutang_DataStore.reload();
    });
*/
	
	//
	var detail_list_piutang_Panel = new Ext.grid.GridPanel({
		id: 'detail_list_piutang_Panel',
		title: 'Detail Pembayaran Hutang',
        store: detail_list_hutang_DataStore,
        cm: detail_list_hutang_ColumnModel,
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Items" : "Item"]})'
        }),
		plugins: summary,
        stripeRows: true,
        autoExpandColumn: 'customer_nama',
        autoHeight: true,
		style: 'margin-top: 10px',
        width: 1200	//800
    });
    
	// ditutup karena sementara tidak dipakai
    //detail_list_piutang_Panel.render('fp_detail_list_hutang');
     
	/* Create Context Menu */
	list_hutang_ContextMenu = new Ext.menu.Menu({
		id: 'list_piutang_ListEditorGridContextMenu',
		items: [
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: listpiutang_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: listpiutang_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onlpiutang_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		list_hutang_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		list_hutang_SelectedRow=rowIndex;
		list_hutang_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function lpiutang_editContextMenu(){
      list_hutang_ListEditorGrid.startEditing(list_hutang_SelectedRow,1);
  	}
	/* End of Function */
  	
	list_hutang_ListEditorGrid.addListener('rowcontextmenu', onlpiutang_ListEditGridContextMenu);
	list_hutang_DataStore.load({params: {start: 0, limit: pageS_hutang}});	// load DataStore
	list_hutang_ListEditorGrid.on('afteredit', list_hutang_update); // inLine Editing Record

	
	/* Identify  bank_kode Field */
	list_hutang_kodeField= new Ext.form.ComboBox({
		id: 'list_hutang_kodeField',
		fieldLabel: 'Kode Akun',
		store: cbo_bank_akunDataStore,
		mode: 'remote',
		editable:false,
		displayField: 'bank_akun_display',
		valueField: 'bank_akun_value',
		anchor: '95%',
		triggerAction: 'all'
	});
	/* Identify  bank_nama Field */
	list_hutang_namaField= new Ext.form.ComboBox({
		id: 'list_hutang_namaField',
		fieldLabel: 'Nama Bank <span style="color: #ec0000">*</span>',
		typeAhead: true,
		triggerAction: 'all',
		store: cbo_bank_mbankDataStore,
		mode: 'remote',
		editable:false,
		displayField: 'bank_mbank_display',
		valueField: 'bank_mbank_value',
		lazyRender:true,
		width: 100,
		allowBlank: false,
		listClass: 'x-combo-list-small'
	});
	/* Identify  bank_norek Field */
	bank_norekField= new Ext.form.TextField({
		id: 'bank_norekField',
		fieldLabel: 'No. Rekening <span style="color: #ec0000">*</span>',
		maxLength: 250,
		allowBlank: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  bank_atasnama Field */
	ship_namaField= new Ext.form.TextField({
		id: 'ship_namaField',
		fieldLabel: 'Nama Ship <span style="color: #ec0000">*</span>',
		maxLength: 250,
		allowBlank: false,
		anchor: '95%'
	});
	/* Identify  bank_saldo Field */
	bank_saldoField= new Ext.form.TextField({
		id: 'bank_saldoField',
		fieldLabel: 'Saldo',
		itemCls: 'rmoney',
		emptyText: '0',
		allowBlank: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  bank_keterangan Field */
	list_hutang_keteranganField= new Ext.form.TextArea({
		id: 'list_hutang_keteranganField',
		fieldLabel: 'Keterangan',
		allowBlank: true,
		anchor: '95%'
	});
	/* Identify  bank_aktif Field */
	list_hutang_aktifField= new Ext.form.ComboBox({
		id: 'list_hutang_aktifField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['ship_aktif_value', 'ship_aktif_display'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		editable:false,
		emptyText: 'Aktif',
		displayField: 'ship_aktif_display',
		valueField: 'ship_aktif_value',
		width: 80,
		triggerAction: 'all'	
	});
	
	/* Function for retrieve create Window Panel*/ 
	list_hutang_createForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 300,        
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [ship_namaField, list_hutang_keteranganField, list_hutang_aktifField] 
			}
			]
		}]
		,
		buttons: [
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_BANKREK'))){ ?>
			{
				text: 'Save and Close',
				handler: ship_create
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					list_hutang_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	list_hutang_createWindow= new Ext.Window({
		id: 'list_hutang_createWindow',
		title: list_hutang_post2db+'Ship',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_hutang_create',
		items: list_hutang_createForm
	});
	/* End Window */
	
	
	/* Function for action list search */
	function bank_list_search(){
		// render according to a SQL date format.
		var bank_id_search=null;
		var bank_kode_search=null;
		var bank_nama_search=null;
		var bank_norek_search=null;
		var bank_atasnama_search=null;
		var bank_saldo_search=null;
		var bank_keterangan_search=null;
		var bank_aktif_search=null;

		if(list_hutang_idSearchField.getValue()!==null){bank_id_search=list_hutang_idSearchField.getValue();}
		if(list_hutang_kodeSearchField.getValue()!==null){bank_kode_search=list_hutang_kodeSearchField.getValue();}
		if(bank_namaSearchField.getValue()!==null){bank_nama_search=bank_namaSearchField.getValue();}
		if(bank_norekSearchField.getValue()!==null){bank_norek_search=bank_norekSearchField.getValue();}
		if(bank_atasnamaSearchField.getValue()!==null){bank_atasnama_search=bank_atasnamaSearchField.getValue();}
		if(bank_saldoSearchField.getValue()!==null){bank_saldo_search=bank_saldoSearchField.getValue();}
		if(list_hutang_keteranganSearchField.getValue()!==null){bank_keterangan_search=list_hutang_keteranganSearchField.getValue();}
		if(list_hutang_aktifSearchField.getValue()!==null){bank_aktif_search=list_hutang_aktifSearchField.getValue();}
		// change the store parameters
		list_hutang_DataStore.baseParams = {
			task: 'SEARCH',
			start: 0,
			limit: pageS_hutang,
			//variable here
			bank_id	:	bank_id_search, 
			bank_kode	:	bank_kode_search, 
			bank_nama	:	bank_nama_search, 
			bank_norek	:	bank_norek_search, 
			bank_atasnama	:	bank_atasnama_search, 
			bank_saldo	:	bank_saldo_search, 
			bank_keterangan	:	bank_keterangan_search, 
			bank_aktif	:	bank_aktif_search
		};
		// Cause the datastore to do another query : 
		list_hutang_DataStore.reload({params: {start: 0, limit: pageS_hutang}});
	}
		
	/* Function for reset search result */
	function lpiutang_reset_search(){
		// reset the store parameters
		list_hutang_DataStore.baseParams = { task: 'LIST' };
		// Cause the datastore to do another query : 
		list_hutang_DataStore.reload({params: {start: 0, limit: pageS_hutang}});
		//list_hutang_searchWindow.close();
	};
	/* End of Fuction */
	
	function lpiutang_reset_SearchForm(){
		list_hutang_kodeSearchField.reset();
		list_hutang_kodeSearchField.setValue(null);
		bank_namaSearchField.reset();
		bank_namaSearchField.setValue(null);
		bank_norekSearchField.reset();
		bank_norekSearchField.setValue(null);
		bank_atasnamaSearchField.reset();
		bank_atasnamaSearchField.setValue(null);
		bank_saldoSearchField.reset();
		bank_saldoSearchField.setValue(null);
		list_hutang_keteranganSearchField.reset();
		list_hutang_keteranganSearchField.setValue(null);
		list_hutang_aktifSearchField.reset();
		list_hutang_aktifSearchField.setValue(null);
	}
	
	/* Field for search */
	/* Identify  bank_id Search Field */
	list_hutang_idSearchField= new Ext.form.NumberField({
		id: 'list_hutang_idSearchField',
		fieldLabel: 'Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  bank_kode Search Field */
	list_hutang_kodeSearchField= new Ext.form.ComboBox({
		id: 'list_hutang_kodeSearchField',
		fieldLabel: 'Kode Akun',
		store: cbo_bank_akunDataStore,
		mode: 'local',
		displayField: 'bank_akun_display',
		valueField: 'bank_akun_value',
		anchor: '95%',
		triggerAction: 'all'
	});
	/* Identify  bank_nama Search Field */
	bank_namaSearchField= new Ext.form.ComboBox({
		id: 'bank_namaSearchField',
		fieldLabel: 'Nama Bank',
		typeAhead: true,
		triggerAction: 'all',
		store: cbo_bank_mbankDataStore,
		mode: 'remote',
		displayField: 'bank_mbank_display',
		valueField: 'bank_mbank_value',
		lazyRender:true,
		anchor: '95%',
		listClass: 'x-combo-list-small'
	});
	/* Identify  bank_norek Search Field */
	bank_norekSearchField= new Ext.form.TextField({
		id: 'bank_norekSearchField',
		fieldLabel: 'No. Rekening',
		maxLength: 250,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  bank_atasnama Search Field */
	bank_atasnamaSearchField= new Ext.form.TextField({
		id: 'bank_atasnamaSearchField',
		fieldLabel: 'Atas Nama',
		maxLength: 250,
		anchor: '95%'
	
	});
	/* Identify  bank_saldo Search Field */
	bank_saldoSearchField= new Ext.form.NumberField({
		id: 'bank_saldoSearchField',
		fieldLabel: 'Saldo',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  bank_keterangan Search Field */
	list_hutang_keteranganSearchField= new Ext.form.TextArea({
		id: 'list_hutang_keteranganSearchField',
		fieldLabel: 'Keterangan',
		allowBlank: true,
		anchor: '95%'
	});
	/* Identify  bank_aktif Search Field */
	list_hutang_aktifSearchField= new Ext.form.ComboBox({
		id: 'list_hutang_aktifSearchField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['value', 'bank_aktif'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		displayField: 'bank_aktif',
		valueField: 'value',
		emptyText: 'Aktif',
		width: 80,
		triggerAction: 'all'	 
	
	});
	
	/* Function for retrieve search Form Panel */
	list_hutang_searchForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 300,        
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [bank_namaSearchField, bank_norekSearchField, bank_atasnamaSearchField, bank_saldoSearchField, list_hutang_keteranganSearchField,
						list_hutang_aktifSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: bank_list_search
			},{
				text: 'Close',
				handler: function(){
					list_hutang_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	list_hutang_searchWindow = new Ext.Window({
		title: 'Pencarian Ship',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_hutang_search',
		items: list_hutang_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!list_hutang_searchWindow.isVisible()){
			lpiutang_reset_SearchForm();
			list_hutang_searchWindow.show();
		} else {
			list_hutang_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function listpiutang_print(){
		var searchquery = "";
		var bank_kode_print=null;
		var bank_nama_print=null;
		var bank_norek_print=null;
		var bank_atasnama_print=null;
		var bank_saldo_print=null;
		var bank_keterangan_print=null;
		var bank_aktif_print=null;
		var win;              
		// check if we do have some search data...
		if(list_hutang_DataStore.baseParams.query!==null){searchquery = list_hutang_DataStore.baseParams.query;}
		if(list_hutang_DataStore.baseParams.bank_kode!==null){bank_kode_print = list_hutang_DataStore.baseParams.bank_kode;}
		if(list_hutang_DataStore.baseParams.bank_nama!==null){bank_nama_print = list_hutang_DataStore.baseParams.bank_nama;}
		if(list_hutang_DataStore.baseParams.bank_norek!==null){bank_norek_print = list_hutang_DataStore.baseParams.bank_norek;}
		if(list_hutang_DataStore.baseParams.bank_atasnama!==null){bank_atasnama_print = list_hutang_DataStore.baseParams.bank_atasnama;}
		if(list_hutang_DataStore.baseParams.bank_saldo!==null){bank_saldo_print = list_hutang_DataStore.baseParams.bank_saldo;}
		if(list_hutang_DataStore.baseParams.bank_keterangan!==null){bank_keterangan_print = list_hutang_DataStore.baseParams.bank_keterangan;}
		if(list_hutang_DataStore.baseParams.bank_aktif!==null){bank_aktif_print = list_hutang_DataStore.baseParams.bank_aktif;}
		

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_daftar_hutang&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			bank_kode : bank_kode_print,
			bank_nama : bank_nama_print,
			bank_norek : bank_norek_print,
			bank_atasnama : bank_atasnama_print,
			bank_saldo : bank_saldo_print,
			bank_keterangan : bank_keterangan_print,
			bank_aktif : bank_aktif_print,
		  	currentlisting: list_hutang_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./banklist.html','banklist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
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
	function listpiutang_export_excel(){
		var searchquery = "";
		var bank_kode_2excel=null;
		var bank_nama_2excel=null;
		var bank_norek_2excel=null;
		var bank_atasnama_2excel=null;
		var bank_saldo_2excel=null;
		var bank_keterangan_2excel=null;
		var bank_aktif_2excel=null;
		var win;              
		// check if we do have some search data...
		if(list_hutang_DataStore.baseParams.query!==null){searchquery = list_hutang_DataStore.baseParams.query;}
		if(list_hutang_DataStore.baseParams.bank_kode!==null){bank_kode_2excel = list_hutang_DataStore.baseParams.bank_kode;}
		if(list_hutang_DataStore.baseParams.bank_nama!==null){bank_nama_2excel = list_hutang_DataStore.baseParams.bank_nama;}
		if(list_hutang_DataStore.baseParams.bank_norek!==null){bank_norek_2excel = list_hutang_DataStore.baseParams.bank_norek;}
		if(list_hutang_DataStore.baseParams.bank_atasnama!==null){bank_atasnama_2excel = list_hutang_DataStore.baseParams.bank_atasnama;}
		if(list_hutang_DataStore.baseParams.bank_saldo!==null){bank_saldo_2excel = list_hutang_DataStore.baseParams.bank_saldo;}
		if(list_hutang_DataStore.baseParams.bank_keterangan!==null){bank_keterangan_2excel = list_hutang_DataStore.baseParams.bank_keterangan;}
		if(list_hutang_DataStore.baseParams.bank_aktif!==null){bank_aktif_2excel = list_hutang_DataStore.baseParams.bank_aktif;}
		

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_daftar_hutang&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			bank_kode : bank_kode_2excel,
			bank_nama : bank_nama_2excel,
			bank_norek : bank_norek_2excel,
			bank_atasnama : bank_atasnama_2excel,
			bank_saldo : bank_saldo_2excel,
			bank_keterangan : bank_keterangan_2excel,
			bank_aktif : bank_aktif_2excel,
		  	currentlisting: list_hutang_DataStore.baseParams.task // this tells us if we are searching or not
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
	
	bank_saldoField.on('focus',function(){ bank_saldoField.setValue(convertToNumber(bank_saldoField.getValue())); });
	bank_saldoField.on('blur',function(){ bank_saldoField.setValue(CurrencyFormatted(bank_saldoField.getValue())); });
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_list_hutang"></div>
        <div id="fp_detail_list_hutang"></div>
		<div id="elwindow_hutang_create"></div>
        <div id="elwindow_hutang_search"></div>
    </div>
</div>
</body>