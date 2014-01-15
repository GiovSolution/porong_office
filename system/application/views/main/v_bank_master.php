<?
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: bank_master View
	+ Description	: For record view
	+ Filename 		: v_bank_master.php
 	+ Author  		: 
 	+ Created on 13/Oct/2009 10:17:38
	
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
var bank_master_DataStore;
var bank_master_ColumnModel;
var bank_masterListEditorGrid;
var bank_master_createForm;
var bank_master_createWindow;
var bank_master_searchForm;
var bank_master_searchWindow;
var bank_master_SelectedRow;
var bank_master_ContextMenu;
//for detail data
var _DataStor;
var ListEditorGrid;
var _ColumnModel;
var _proxy;
var _writer;
var _reader;
var editor_;

//declare konstant
var post2db = '';
var msg = '';
var pageS=15;

/* declare variable here for Field*/
var mbank_idField;
var mbank_namaField;
var mbank_keteranganField;
var mbank_aktifField;
var mbank_idSearchField;
var mbank_namaSearchField;
var mbank_keteranganSearchField;
var mbank_aktifSearchField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  	/* Function for Saving inLine Editing */
	function bank_master_update(oGrid_event){
		var mbank_id_update_pk="";
		var mbank_nama_update=null;
		var mbank_keterangan_update=null;
		var mbank_aktif_update=null;

		mbank_id_update_pk = oGrid_event.record.data.mbank_id;
		if(oGrid_event.record.data.mbank_nama!== null){mbank_nama_update = oGrid_event.record.data.mbank_nama;}
		if(oGrid_event.record.data.mbank_keterangan!== null){mbank_keterangan_update = oGrid_event.record.data.mbank_keterangan;}
		if(oGrid_event.record.data.mbank_aktif!== null){mbank_aktif_update = oGrid_event.record.data.mbank_aktif;}

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_bank_master&m=get_action',
			params: {
				task: "UPDATE",
				mbank_id	: mbank_id_update_pk, 
				mbank_nama	:mbank_nama_update,  
				mbank_keterangan	:mbank_keterangan_update,  
				mbank_aktif	:mbank_aktif_update,  
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						bank_master_DataStore.commitChanges();
						bank_master_DataStore.reload();
						break;
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Data Bank tidak bisa disimpan.',
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
	function bank_master_create(){
	
		if(is_bank_master_form_valid()){	
		var mbank_id_create_pk=null; 
		var mbank_nama_create=null; 
		var mbank_keterangan_create=null; 
		var mbank_aktif_create=null; 

		if(mbank_idField.getValue()!== null){mbank_id_create_pk = mbank_idField.getValue();}else{mbank_id_create_pk=get_pk_id();} 
		if(mbank_namaField.getValue()!== null){mbank_nama_create = mbank_namaField.getValue();} 
		if(mbank_keteranganField.getValue()!== null){mbank_keterangan_create = mbank_keteranganField.getValue();} 
		if(mbank_aktifField.getValue()!== null){mbank_aktif_create = mbank_aktifField.getValue();} 

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_bank_master&m=get_action',
			params: {
				task: post2db,
				mbank_id	: mbank_id_create_pk, 
				mbank_nama	: mbank_nama_create, 
				mbank_keterangan	: mbank_keterangan_create, 
				mbank_aktif	: mbank_aktif_create, 
			}, 
			success: function(response){             
				var result=eval(response.responseText);
				switch(result){
					case 1:
						Ext.MessageBox.alert(post2db+' OK','Data Bank berhasil disimpan.');
						bank_master_DataStore.reload();
						bank_master_createWindow.hide();
						break;
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Data Bank tidak bisa disimpan !.',
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
			return bank_masterListEditorGrid.getSelectionModel().getSelected().get('mbank_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function bank_master_reset_form(){
		mbank_idField.reset();
		mbank_idField.setValue(null);
		mbank_namaField.reset();
		mbank_namaField.setValue(null);
		mbank_keteranganField.reset();
		mbank_keteranganField.setValue(null);
		mbank_aktifField.reset();
		mbank_aktifField.setValue('Aktif');
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function bank_master_set_form(){
		mbank_idField.setValue(bank_masterListEditorGrid.getSelectionModel().getSelected().get('mbank_id'));
		mbank_namaField.setValue(bank_masterListEditorGrid.getSelectionModel().getSelected().get('mbank_nama'));
		mbank_keteranganField.setValue(bank_masterListEditorGrid.getSelectionModel().getSelected().get('mbank_keterangan'));
		mbank_aktifField.setValue(bank_masterListEditorGrid.getSelectionModel().getSelected().get('mbank_aktif'));
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_bank_master_form_valid(){
		return (mbank_namaField.isValid()  );
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!bank_master_createWindow.isVisible()){
			
			post2db='CREATE';
			msg='created';
			bank_master_reset_form();
			
			bank_master_createWindow.show();
		} else {
			bank_master_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function bank_master_confirm_delete(){
		// only one bank_master is selected here
		if(bank_masterListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', bank_master_delete);
		} else if(bank_masterListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', bank_master_delete);
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
	function bank_master_confirm_update(){
		/* only one record is selected here */
		if(bank_masterListEditorGrid.selModel.getCount() == 1) {
			
			post2db='UPDATE';
			msg='updated';
			bank_master_set_form();
			
			bank_master_createWindow.show();
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
	function bank_master_delete(btn){
		if(btn=='yes'){
			var selections = bank_masterListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< bank_masterListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.mbank_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_bank_master&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							bank_master_DataStore.reload();
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
	bank_master_DataStore = new Ext.data.Store({
		id: 'bank_master_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_bank_master&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit:pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'mbank_id'
		},[
			{name: 'mbank_id', type: 'int', mapping: 'mbank_id'}, 
			{name: 'mbank_nama', type: 'string', mapping: 'mbank_nama'}, 
			{name: 'mbank_keterangan', type: 'string', mapping: 'mbank_keterangan'}, 
			{name: 'mbank_aktif', type: 'string', mapping: 'mbank_aktif'}, 
			{name: 'mbank_creator', type: 'string', mapping: 'mbank_creator'}, 
			{name: 'mbank_date_create', type: 'date', dateFormat: 'Y-m-d', mapping: 'mbank_date_create'}, 
			{name: 'mbank_update', type: 'string', mapping: 'mbank_update'}, 
			{name: 'mbank_date_update', type: 'date', dateFormat: 'Y-m-d', mapping: 'mbank_date_update'}, 
			{name: 'mbank_revised', type: 'int', mapping: 'mbank_revised'} 
		]),
		sortInfo:{field: 'mbank_id', direction: "DESC"}
	});
	/* End of Function */
    
  	/* Function for Identify of Window Column Model */
	bank_master_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'mbank_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},
		{
			header: 'Nama',
			dataIndex: 'mbank_nama',
			width: 150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_BANK'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 50
          	})
			<?php } ?>
		}, 
		{
			header: 'Keterangan',
			dataIndex: 'mbank_keterangan',
			width: 150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_BANK'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
			<?php } ?>
		}, 
		{
			header: 'Status',
			dataIndex: 'mbank_aktif',
			width: 150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_BANK'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['mbank_aktif_value', 'mbank_aktif_display'],
					data: [['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
					}),
				mode: 'local',
               	displayField: 'mbank_aktif_display',
               	valueField: 'mbank_aktif_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
			<?php } ?>
		}, 
		{
			header: 'Creator',
			dataIndex: 'mbank_creator',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Create on',
			dataIndex: 'mbank_date_create',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Last Update by',
			dataIndex: 'mbank_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Last Update on',
			dataIndex: 'mbank_date_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Revised',
			dataIndex: 'mbank_revised',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}	]);
	
	bank_master_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	bank_masterListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'bank_masterListEditorGrid',
		el: 'fp_bank_master',
		title: 'Daftar Bank',
		autoHeight: true,
		store: bank_master_DataStore, // DataStore
		cm: bank_master_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 700,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: bank_master_DataStore,
			displayInfo: true
		}),
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_BANK'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<?php } ?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_BANK'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: bank_master_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_BANK'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			disabled:true,
			handler: bank_master_confirm_delete   // Confirm before deleting
		}, '-', 
		<?php } ?>
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: bank_master_DataStore,
			params: {task: 'LIST',start: 0, limit: pageS},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						bank_master_DataStore.baseParams={task:'LIST',start: 0, limit: pageS};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Search By'});
				Ext.get(this.id).set({qtip:'- Nama<br>- Keterangan'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: bank_master_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: bank_master_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: bank_master_print  
		}
		]
	});
	bank_masterListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	bank_master_ContextMenu = new Ext.menu.Menu({
		id: 'bank_master_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_BANK'))){ ?>
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: bank_master_confirm_update 
		},
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_BANK'))){ ?>
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			handler: bank_master_confirm_delete 
		},
		<?php } ?>
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: bank_master_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: bank_master_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onbank_master_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		bank_master_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		bank_master_SelectedRow=rowIndex;
		bank_master_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function bank_master_editContextMenu(){
		bank_masterListEditorGrid.startEditing(bank_master_SelectedRow,1);
  	}
	/* End of Function */
  	
	bank_masterListEditorGrid.addListener('rowcontextmenu', onbank_master_ListEditGridContextMenu);
	bank_master_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	bank_masterListEditorGrid.on('afteredit', bank_master_update); // inLine Editing Record
	
	/* Identify  mbank_id Field */
	mbank_idField= new Ext.form.NumberField({
		id: 'mbank_idField',
		allowNegatife : false,
		blankText: '0',
		allowBlank: true,
		allowDecimals: false,
		hidden: true,
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  mbank_nama Field */
	mbank_namaField= new Ext.form.TextField({
		id: 'mbank_namaField',
		fieldLabel: 'Nama <span style="color: #ec0000">*</span>',
		maxLength: 50,
		allowBlank: false,
		anchor: '95%'
	});
	/* Identify  mbank_keterangan Field */
	mbank_keteranganField= new Ext.form.TextArea({
		id: 'mbank_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '95%'
	});
	/* Identify  mbank_aktif Field */
	mbank_aktifField= new Ext.form.ComboBox({
		id: 'mbank_aktifField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['mbank_aktif_value', 'mbank_aktif_display'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		editable:false,
		emptyText: 'Aktif',
		displayField: 'mbank_aktif_display',
		valueField: 'mbank_aktif_value',
		width: 80,
		triggerAction: 'all'	
	});

	
	/* Function for retrieve create Window Panel*/ 
	bank_master_createForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 300,        
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [mbank_namaField, mbank_keteranganField, mbank_aktifField, mbank_idField] 
			}
			],
		buttons: [
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_BANK'))){ ?>
			{
				text: 'Save and Close',
				handler: bank_master_create
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					bank_master_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	bank_master_createWindow= new Ext.Window({
		id: 'bank_master_createWindow',
		title: post2db+' Bank',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_bank_master_create',
		items: bank_master_createForm
	});
	/* End Window */
	
	/* Function for action list search */
	function bank_master_list_search(){
		// render according to a SQL date format.
		var mbank_id_search=null;
		var mbank_nama_search=null;
		var mbank_keterangan_search=null;
		var mbank_aktif_search=null;

		if(mbank_idSearchField.getValue()!==null){mbank_id_search=mbank_idSearchField.getValue();}
		if(mbank_namaSearchField.getValue()!==null){mbank_nama_search=mbank_namaSearchField.getValue();}
		if(mbank_keteranganSearchField.getValue()!==null){mbank_keterangan_search=mbank_keteranganSearchField.getValue();}
		if(mbank_aktifSearchField.getValue()!==null){mbank_aktif_search=mbank_aktifSearchField.getValue();}
		// change the store parameters
		bank_master_DataStore.baseParams = {
			task: 'SEARCH',
			start: 0,
			limit: pageS,
			//variable here
			mbank_id	:	mbank_id_search, 
			mbank_nama	:	mbank_nama_search, 
			mbank_keterangan	:	mbank_keterangan_search, 
			mbank_aktif	:	mbank_aktif_search, 
		};
		bank_master_DataStore.reload({params: {start: 0, limit: pageS}});
	}
		
	/* Function for reset search result */
	function bank_master_reset_search(){
		// reset the store parameters
		bank_master_DataStore.baseParams = { task: 'LIST', start: 0, limit: pageS };
		bank_master_DataStore.reload({params: {start: 0, limit: pageS}});
		//bank_master_searchWindow.close();
	};
	/* End of Fuction */

	function bank_master_reset_SearchForm(){
		mbank_namaSearchField.reset();
		mbank_keteranganSearchField.reset();
		mbank_aktifSearchField.reset();
	}
	
	/* Field for search */
	/* Identify  mbank_id Search Field */
	mbank_idSearchField= new Ext.form.NumberField({
		id: 'mbank_idSearchField',
		fieldLabel: 'Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  mbank_nama Search Field */
	mbank_namaSearchField= new Ext.form.TextField({
		id: 'mbank_namaSearchField',
		fieldLabel: 'Nama Bank',
		maxLength: 50,
		anchor: '95%'
	
	});
	/* Identify  mbank_keterangan Search Field */
	mbank_keteranganSearchField= new Ext.form.TextArea({
		id: 'mbank_keteranganSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '95%'
	
	});
	/* Identify  mbank_aktif Search Field */
	mbank_aktifSearchField= new Ext.form.ComboBox({
		id: 'mbank_aktifSearchField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['value', 'mbank_aktif'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		displayField: 'mbank_aktif',
		valueField: 'value',
		emptyText: 'Aktif',
		width: 80,
		triggerAction: 'all'	 
	
	});
    
	/* Function for retrieve search Form Panel */
	bank_master_searchForm = new Ext.FormPanel({
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
				items: [mbank_namaSearchField, mbank_keteranganSearchField, mbank_aktifSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: bank_master_list_search
			},{
				text: 'Close',
				handler: function(){
					bank_master_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	bank_master_searchWindow = new Ext.Window({
		title: 'Pencarian Bank',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_bank_master_search',
		items: bank_master_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!bank_master_searchWindow.isVisible()){
			bank_master_reset_SearchForm();
			bank_master_searchWindow.show();
		} else {
			bank_master_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function bank_master_print(){
		var searchquery = "";
		var mbank_nama_print=null;
		var mbank_keterangan_print=null;
		var mbank_aktif_print=null;
		var win;              
		// check if we do have some search data...
		if(bank_master_DataStore.baseParams.query!==null){searchquery = bank_master_DataStore.baseParams.query;}
		if(bank_master_DataStore.baseParams.mbank_nama!==null){mbank_nama_print = bank_master_DataStore.baseParams.mbank_nama;}
		if(bank_master_DataStore.baseParams.mbank_keterangan!==null){mbank_keterangan_print = bank_master_DataStore.baseParams.mbank_keterangan;}
		if(bank_master_DataStore.baseParams.mbank_aktif!==null){mbank_aktif_print = bank_master_DataStore.baseParams.mbank_aktif;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_bank_master&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		
			mbank_nama : mbank_nama_print,
			mbank_keterangan : mbank_keterangan_print,
			mbank_aktif : mbank_aktif_print,
		  	currentlisting: bank_master_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./bank_masterlist.html','bank_masterlist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
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
	function bank_master_export_excel(){
		var searchquery = "";
		var mbank_nama_2excel=null;
		var mbank_keterangan_2excel=null;
		var mbank_aktif_2excel=null;
		var win;              
		// check if we do have some search data...
		if(bank_master_DataStore.baseParams.query!==null){searchquery = bank_master_DataStore.baseParams.query;}
		if(bank_master_DataStore.baseParams.mbank_nama!==null){mbank_nama_2excel = bank_master_DataStore.baseParams.mbank_nama;}
		if(bank_master_DataStore.baseParams.mbank_keterangan!==null){mbank_keterangan_2excel = bank_master_DataStore.baseParams.mbank_keterangan;}
		if(bank_master_DataStore.baseParams.mbank_aktif!==null){mbank_aktif_2excel = bank_master_DataStore.baseParams.mbank_aktif;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_bank_master&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		
			mbank_nama : mbank_nama_2excel,
			mbank_keterangan : mbank_keterangan_2excel,
			mbank_aktif : mbank_aktif_2excel,
		  	currentlisting: bank_master_DataStore.baseParams.task // this tells us if we are searching or not
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
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_bank_master"></div>
		<div id="elwindow_bank_master_create"></div>
        <div id="elwindow_bank_master_search"></div>
    </div>
</div>
</body>