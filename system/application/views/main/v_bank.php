<?
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: bank View
	+ Description	: For record view
	+ Filename 		: v_bank.php
 	+ Author  		: zainal, mukhlison
 	+ Created on 14/Jul/2009 15:33:36
	
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
var bank_DataStore;
var bank_ColumnModel;
var bankListEditorGrid;
var bank_createForm;
var bank_createWindow;
var bank_searchForm;
var bank_searchWindow;
var bank_SelectedRow;
var bank_ContextMenu;
//declare konstant
var post2db = '';
var msg = '';
var pageS=15;

/* declare variable here */
var bank_idField;
var bank_kodeField;
var bank_namaField;
var bank_norekField;
var bank_atasnamaField;
var bank_saldoField;
var bank_keteranganField;
var bank_aktifField;

var bank_idSearchField;
var bank_kodeSearchField;
var bank_namaSearchField;
var bank_norekSearchField;
var bank_atasnamaSearchField;
var bank_saldoSearchField;
var bank_keteranganSearchField;
var bank_aktifSearchField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  	/* Function for Saving inLine Editing */
	function bank_update(oGrid_event){
	var bank_id_update_pk="";
	var bank_kode_update=null;
	var bank_nama_update=null;
	var bank_norek_update=null;
	var bank_atasnama_update=null;
	var bank_saldo_update=null;
	var bank_keterangan_update=null;
	var bank_aktif_update=null;

	bank_id_update_pk = oGrid_event.record.data.bank_id;
	if(oGrid_event.record.data.bank_kode!== null){bank_kode_update = oGrid_event.record.data.bank_kode;}
	if(oGrid_event.record.data.bank_nama!== null){bank_nama_update = oGrid_event.record.data.bank_nama;}
	if(oGrid_event.record.data.bank_norek!== null){bank_norek_update = oGrid_event.record.data.bank_norek;}
	if(oGrid_event.record.data.bank_atasnama!== null){bank_atasnama_update = oGrid_event.record.data.bank_atasnama;}
	if(oGrid_event.record.data.bank_saldo!== null){bank_saldo_update = oGrid_event.record.data.bank_saldo;}
	if(oGrid_event.record.data.bank_keterangan!== null){bank_keterangan_update = oGrid_event.record.data.bank_keterangan;}
	if(oGrid_event.record.data.bank_aktif!== null){bank_aktif_update = oGrid_event.record.data.bank_aktif;}

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_bank&m=get_action',
			params: {
				task: "UPDATE",
				bank_id	: bank_id_update_pk,				
				bank_kode	:bank_kode_update,		
				bank_nama	:bank_nama_update,		
				bank_norek	:bank_norek_update,		
				bank_atasnama	:bank_atasnama_update,		
				bank_saldo	:bank_saldo_update,		
				bank_keterangan	:bank_keterangan_update,		
				bank_aktif	:bank_aktif_update
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						bank_DataStore.commitChanges();
						bank_DataStore.reload();
						break;
					case 2:
						bank_DataStore.reload();
						break;
					default:
						Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Data Rekening Bank tidak bisa disimpan.',
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
	function bank_create(){
		if(is_bank_form_valid()){
		
		var bank_id_create_pk=null;
		var bank_kode_create=null;
		var bank_nama_create=null;
		var bank_norek_create=null;
		var bank_atasnama_create=null;
		var bank_saldo_create=null;
		var bank_keterangan_create=null;
		var bank_aktif_create=null;

		bank_id_create_pk=get_pk_id();
		if(bank_kodeField.getValue()!== null){bank_kode_create = bank_kodeField.getValue();}
		if(bank_namaField.getValue()!== null){bank_nama_create = bank_namaField.getValue();}
		if(bank_norekField.getValue()!== null){bank_norek_create = bank_norekField.getValue();}
		if(bank_atasnamaField.getValue()!== null){bank_atasnama_create = bank_atasnamaField.getValue();}
		if(bank_saldoField.getValue()!== null){bank_saldo_create = convertToNumber(bank_saldoField.getValue());}
		if(bank_keteranganField.getValue()!== null){bank_keterangan_create = bank_keteranganField.getValue();}
		if(bank_aktifField.getValue()!== null){bank_aktif_create = bank_aktifField.getValue();}

		Ext.Ajax.request({  
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_bank&m=get_action',
				params: {
					task: post2db,
					bank_id	: bank_id_create_pk,	
					bank_kode	: bank_kode_create,	
					bank_nama	: bank_nama_create,	
					bank_norek	: bank_norek_create,	
					bank_atasnama	: bank_atasnama_create,	
					bank_saldo	: bank_saldo_create,	
					bank_keterangan	: bank_keterangan_create,	
					bank_aktif	: bank_aktif_create
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							Ext.MessageBox.alert(post2db+' OK','Data Rekening Bank berhasil disimpan.');
							bank_DataStore.reload();
							bank_createWindow.hide();
							break;
						default:
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Data Rekening Bank tidak bisa disimpan!.',
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
		if(post2db=='UPDATE')
			return bankListEditorGrid.getSelectionModel().getSelected().get('bank_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function bank_reset_form(){
		bank_kodeField.reset();
		bank_kodeField.setValue(null);
		bank_namaField.reset();
		bank_namaField.setValue(null);
		bank_norekField.reset();
		bank_norekField.setValue(null);
		bank_atasnamaField.reset();
		bank_atasnamaField.setValue(null);
		bank_saldoField.reset();
		bank_saldoField.setValue(null);
		bank_keteranganField.reset();
		bank_keteranganField.setValue(null);
		bank_aktifField.reset();
		bank_aktifField.setValue('Aktif');
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function bank_set_form(){
		bank_kodeField.setValue(bankListEditorGrid.getSelectionModel().getSelected().get('bank_kode'));
		bank_namaField.setValue(bankListEditorGrid.getSelectionModel().getSelected().get('bank_nama'));
		bank_norekField.setValue(bankListEditorGrid.getSelectionModel().getSelected().get('bank_norek'));
		bank_atasnamaField.setValue(bankListEditorGrid.getSelectionModel().getSelected().get('bank_atasnama'));
		bank_saldoField.setValue(CurrencyFormatted(bankListEditorGrid.getSelectionModel().getSelected().get('bank_saldo')));
		bank_keteranganField.setValue(bankListEditorGrid.getSelectionModel().getSelected().get('bank_keterangan'));
		bank_aktifField.setValue(bankListEditorGrid.getSelectionModel().getSelected().get('bank_aktif'));
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_bank_form_valid(){
		return (bank_kodeField.isValid() && bank_namaField.isValid() && bank_norekField.isValid() && bank_atasnamaField.isValid());
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!bank_createWindow.isVisible()){
			
			post2db='CREATE';
			msg='created';
			bank_reset_form();
			
			bank_createWindow.show();
		} else {
			bank_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function bank_confirm_delete(){
		// only one bank is selected here
		if(bankListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', bank_delete);
		} else if(bankListEditorGrid.selModel.getCount() > 1){
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
	function bank_confirm_update(){
		/* only one record is selected here */
		if(bankListEditorGrid.selModel.getCount() == 1) {
			
			post2db='UPDATE';
			msg='updated';
			bank_set_form();
			
			bank_createWindow.show();
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
			var selections = bankListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< bankListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.bank_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_bank&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							bank_DataStore.reload();
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
	bank_DataStore = new Ext.data.Store({
		id: 'bank_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_bank&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start: 0, limit: pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'bank_id'
		},[
			{name: 'bank_id', type: 'int', mapping: 'bank_id'},
			{name: 'bank_kode', type: 'string', mapping: 'akun_nama'},
			{name: 'bank_nama', type: 'string', mapping: 'mbank_nama'},
			{name: 'bank_norek', type: 'string', mapping: 'bank_norek'},
			{name: 'bank_atasnama', type: 'string', mapping: 'bank_atasnama'},
			{name: 'bank_saldo', type: 'float', mapping: 'bank_saldo'},
			{name: 'bank_keterangan', type: 'string', mapping: 'bank_keterangan'},
			{name: 'bank_aktif', type: 'string', mapping: 'bank_aktif'},
			{name: 'bank_creator', type: 'string', mapping: 'bank_creator'},
			{name: 'bank_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'bank_date_create'},
			{name: 'bank_update', type: 'string', mapping: 'bank_update'},
			{name: 'bank_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'bank_date_update'},
			{name: 'bank_revised', type: 'int', mapping: 'bank_revised'}
		]),
		sortInfo:{field: 'bank_id', direction: "ASC"}
	});
	/* End of Function */
	
	cbo_bank_akunDataStore = new Ext.data.Store({
		id: 'cbo_bank_akunDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_bank&m=get_akun_list', 
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
			url: 'index.php?c=c_bank&m=get_mbank_list', 
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
	
  	/* Function for Identify of Window Column Model */
	bank_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'bank_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},
		/*
		{
			header: 'Kode Akun',
			dataIndex: 'bank_kode',
			width: 150,
			sortable: true,
			editor: new Ext.form.ComboBox({
				store: cbo_bank_akunDataStore,
				mode: 'local',
				displayField: 'bank_akun_display',
				valueField: 'bank_akun_value',
				triggerAction: 'all'
			})
		}, */
		{
			header: 'Nama Bank',
			dataIndex: 'bank_nama',
			width: 150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_BANKREK'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store: cbo_bank_mbankDataStore,
				mode: 'remote',
				displayField: 'bank_mbank_display',
				valueField: 'bank_mbank_value',
				lazyRender:true,
				width: 100,
				listClass: 'x-combo-list-small'
			})
			<? } ?>
		},
		{
			header: 'No. Rekening',
			dataIndex: 'bank_norek',
			width: 150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_BANKREK'))){ ?>
			,
			editor: new Ext.form.NumberField({
				maxLength: 250
          	})
			<?php } ?>
		},
		{
			header: 'Atas Nama',
			dataIndex: 'bank_atasnama',
			width: 150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_BANKREK'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
			<?php } ?>
		},
		{
			header: 'Saldo',
			dataIndex: 'bank_saldo',
			width: 150,
			sortable: true,
			align: 'right',
			renderer: function(val){
				return '<span>Rp. '+Ext.util.Format.number(val,'0,000')+'</span>';
			}
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_BANKREK'))){ ?>
			,
			editor: new Ext.form.NumberField({
				allowDecimals: true,
				allowNegative: false,
				blankText: '0',
				maxLength: 22,
				maskRe: /([0-9]+)$/
			})
			<?php } ?>
		},
		{
			header: 'Keterangan',
			dataIndex: 'bank_keterangan',
			width: 150,
			hidden: true,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_BANKREK'))){ ?>
			,
			editor: new Ext.form.TextField({
				allowBlank: true,
				maxLength: 500
			})
			<?php } ?>
		},
		{
			header: 'Status',
			dataIndex: 'bank_aktif',
			width: 150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_BANKREK'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['bank_aktif_value', 'bank_aktif_display'],
					data: [['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
					}),
				mode: 'local',
               	displayField: 'bank_aktif_display',
               	valueField: 'bank_aktif_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
			<?php } ?>
		},
		{
			header: 'Creator',
			dataIndex: 'bank_creator',
			width: 150,
			sortable: true,
			hidden:true
		},
		{
			header: 'Create on',
			dataIndex: 'bank_date_create',
			width: 150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			hidden:true
		},
		{
			header: 'Last Update By',
			dataIndex: 'bank_update',
			width: 150,
			sortable: true,
			hidden:true
		},
		{
			header: 'Last Update on',
			dataIndex: 'bank_date_update',
			width: 150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			hidden:true
		},
		{
			header: 'Revised',
			dataIndex: 'bank_revised',
			width: 150,
			sortable: true,
			hidden:true
		}]
	);
	bank_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	bankListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'bankListEditorGrid',
		el: 'fp_bank',
		title: 'Rekening Bank',
		autoHeight: true,
		store: bank_DataStore, // DataStore
		cm: bank_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 800,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: bank_DataStore,
			displayInfo: true
		}),
		/* Add Control on ToolBar */
		tbar: [
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
			handler: bank_confirm_update   // Confirm before updating
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
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: bank_DataStore,
			params: {task: 'LIST',start: 0, limit: pageS},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						bank_DataStore.baseParams={task:'LIST',start: 0, limit: pageS};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Search By'});
				Ext.get(this.id).set({qtip:'- Kode Akun<br>- Nama Bank<br>- No.Rekening<br>- Atas Nama'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: bank_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: bank_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: bank_print  
		}
		]
	});
	bankListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	bank_ContextMenu = new Ext.menu.Menu({
		id: 'bank_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_BANKREK'))){ ?>
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: bank_confirm_update 
		},
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_BANKREK'))){ ?>
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			handler: bank_confirm_delete 
		},
		<?php } ?>
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: bank_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: bank_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onbank_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		bank_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		bank_SelectedRow=rowIndex;
		bank_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function bank_editContextMenu(){
      bankListEditorGrid.startEditing(bank_SelectedRow,1);
  	}
	/* End of Function */
  	
	bankListEditorGrid.addListener('rowcontextmenu', onbank_ListEditGridContextMenu);
	bank_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	bankListEditorGrid.on('afteredit', bank_update); // inLine Editing Record
	
	cbo_bank_akunDataStore.load();
	
	/* Identify  bank_kode Field */
	bank_kodeField= new Ext.form.ComboBox({
		id: 'bank_kodeField',
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
	bank_namaField= new Ext.form.ComboBox({
		id: 'bank_namaField',
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
	bank_atasnamaField= new Ext.form.TextField({
		id: 'bank_atasnamaField',
		fieldLabel: 'Atas Nama <span style="color: #ec0000">*</span>',
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
	bank_keteranganField= new Ext.form.TextArea({
		id: 'bank_keteranganField',
		fieldLabel: 'Keterangan',
		allowBlank: true,
		anchor: '95%'
	});
	/* Identify  bank_aktif Field */
	bank_aktifField= new Ext.form.ComboBox({
		id: 'bank_aktifField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['bank_aktif_value', 'bank_aktif_display'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		editable:false,
		emptyText: 'Aktif',
		displayField: 'bank_aktif_display',
		valueField: 'bank_aktif_value',
		width: 80,
		triggerAction: 'all'	
	});
	
	/* Function for retrieve create Window Panel*/ 
	bank_createForm = new Ext.FormPanel({
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
				items: [ bank_namaField, bank_norekField, bank_atasnamaField, bank_saldoField, bank_keteranganField, bank_aktifField] 
			}
			]
		}]
		,
		buttons: [
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_BANKREK'))){ ?>
			{
				text: 'Save and Close',
				handler: bank_create
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					bank_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	bank_createWindow= new Ext.Window({
		id: 'bank_createWindow',
		title: post2db+'Rekening Bank',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_bank_create',
		items: bank_createForm
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

		if(bank_idSearchField.getValue()!==null){bank_id_search=bank_idSearchField.getValue();}
		if(bank_kodeSearchField.getValue()!==null){bank_kode_search=bank_kodeSearchField.getValue();}
		if(bank_namaSearchField.getValue()!==null){bank_nama_search=bank_namaSearchField.getValue();}
		if(bank_norekSearchField.getValue()!==null){bank_norek_search=bank_norekSearchField.getValue();}
		if(bank_atasnamaSearchField.getValue()!==null){bank_atasnama_search=bank_atasnamaSearchField.getValue();}
		if(bank_saldoSearchField.getValue()!==null){bank_saldo_search=bank_saldoSearchField.getValue();}
		if(bank_keteranganSearchField.getValue()!==null){bank_keterangan_search=bank_keteranganSearchField.getValue();}
		if(bank_aktifSearchField.getValue()!==null){bank_aktif_search=bank_aktifSearchField.getValue();}
		// change the store parameters
		bank_DataStore.baseParams = {
			task: 'SEARCH',
			start: 0,
			limit: pageS,
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
		bank_DataStore.reload({params: {start: 0, limit: pageS}});
	}
		
	/* Function for reset search result */
	function bank_reset_search(){
		// reset the store parameters
		bank_DataStore.baseParams = { task: 'LIST' };
		// Cause the datastore to do another query : 
		bank_DataStore.reload({params: {start: 0, limit: pageS}});
		//bank_searchWindow.close();
	};
	/* End of Fuction */
	
	function bank_reset_SearchForm(){
		bank_kodeSearchField.reset();
		bank_kodeSearchField.setValue(null);
		bank_namaSearchField.reset();
		bank_namaSearchField.setValue(null);
		bank_norekSearchField.reset();
		bank_norekSearchField.setValue(null);
		bank_atasnamaSearchField.reset();
		bank_atasnamaSearchField.setValue(null);
		bank_saldoSearchField.reset();
		bank_saldoSearchField.setValue(null);
		bank_keteranganSearchField.reset();
		bank_keteranganSearchField.setValue(null);
		bank_aktifSearchField.reset();
		bank_aktifSearchField.setValue(null);
	}
	
	/* Field for search */
	/* Identify  bank_id Search Field */
	bank_idSearchField= new Ext.form.NumberField({
		id: 'bank_idSearchField',
		fieldLabel: 'Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  bank_kode Search Field */
	bank_kodeSearchField= new Ext.form.ComboBox({
		id: 'bank_kodeSearchField',
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
	bank_keteranganSearchField= new Ext.form.TextArea({
		id: 'bank_keteranganSearchField',
		fieldLabel: 'Keterangan',
		allowBlank: true,
		anchor: '95%'
	});
	/* Identify  bank_aktif Search Field */
	bank_aktifSearchField= new Ext.form.ComboBox({
		id: 'bank_aktifSearchField',
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
	bank_searchForm = new Ext.FormPanel({
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
				items: [bank_namaSearchField, bank_norekSearchField, bank_atasnamaSearchField, bank_saldoSearchField, bank_keteranganSearchField,
						bank_aktifSearchField] 
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
					bank_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	bank_searchWindow = new Ext.Window({
		title: 'Pencarian Rekening Bank',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_bank_search',
		items: bank_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!bank_searchWindow.isVisible()){
			bank_reset_SearchForm();
			bank_searchWindow.show();
		} else {
			bank_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function bank_print(){
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
		if(bank_DataStore.baseParams.query!==null){searchquery = bank_DataStore.baseParams.query;}
		if(bank_DataStore.baseParams.bank_kode!==null){bank_kode_print = bank_DataStore.baseParams.bank_kode;}
		if(bank_DataStore.baseParams.bank_nama!==null){bank_nama_print = bank_DataStore.baseParams.bank_nama;}
		if(bank_DataStore.baseParams.bank_norek!==null){bank_norek_print = bank_DataStore.baseParams.bank_norek;}
		if(bank_DataStore.baseParams.bank_atasnama!==null){bank_atasnama_print = bank_DataStore.baseParams.bank_atasnama;}
		if(bank_DataStore.baseParams.bank_saldo!==null){bank_saldo_print = bank_DataStore.baseParams.bank_saldo;}
		if(bank_DataStore.baseParams.bank_keterangan!==null){bank_keterangan_print = bank_DataStore.baseParams.bank_keterangan;}
		if(bank_DataStore.baseParams.bank_aktif!==null){bank_aktif_print = bank_DataStore.baseParams.bank_aktif;}
		

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_bank&m=get_action',
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
		  	currentlisting: bank_DataStore.baseParams.task // this tells us if we are searching or not
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
	function bank_export_excel(){
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
		if(bank_DataStore.baseParams.query!==null){searchquery = bank_DataStore.baseParams.query;}
		if(bank_DataStore.baseParams.bank_kode!==null){bank_kode_2excel = bank_DataStore.baseParams.bank_kode;}
		if(bank_DataStore.baseParams.bank_nama!==null){bank_nama_2excel = bank_DataStore.baseParams.bank_nama;}
		if(bank_DataStore.baseParams.bank_norek!==null){bank_norek_2excel = bank_DataStore.baseParams.bank_norek;}
		if(bank_DataStore.baseParams.bank_atasnama!==null){bank_atasnama_2excel = bank_DataStore.baseParams.bank_atasnama;}
		if(bank_DataStore.baseParams.bank_saldo!==null){bank_saldo_2excel = bank_DataStore.baseParams.bank_saldo;}
		if(bank_DataStore.baseParams.bank_keterangan!==null){bank_keterangan_2excel = bank_DataStore.baseParams.bank_keterangan;}
		if(bank_DataStore.baseParams.bank_aktif!==null){bank_aktif_2excel = bank_DataStore.baseParams.bank_aktif;}
		

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_bank&m=get_action',
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
		  	currentlisting: bank_DataStore.baseParams.task // this tells us if we are searching or not
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
        <div id="fp_bank"></div>
		<div id="elwindow_bank_create"></div>
        <div id="elwindow_bank_search"></div>
    </div>
</div>
</body>