<?
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: diagnosa View
	+ Description	: For record view
	+ Filename 		: v_diagnosa.php
 	+ Author  		: 
 	+ Created on 03/Oct/2009 22:52:15
	
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
var diagnosa_DataStore;
var diagnosa_ColumnModel;
var diagnosaListEditorGrid;
var diagnosa_createForm;
var diagnosa_createWindow;
var diagnosa_searchForm;
var diagnosa_searchWindow;
var diagnosa_SelectedRow;
var diagnosa_ContextMenu;
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
var diagnosa_idField;
var diagnosa_kodeField;
var diagnosa_kategoriField;
var diagnosa_namaField;
var diagnosa_keteranganField;
var diagnosa_idSearchField;
var diagnosa_kodeSearchField;
var diagnosa_kategoriSearchField;
var diagnosa_namaSearchField;
var diagnosa_keteranganSearchField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  	/* Function for Saving inLine Editing */
	function diagnosa_update(oGrid_event){
		var diagnosa_id_update_pk="";
		var diagnosa_kode_update=null;
		var diagnosa_kategori_update=null;
		var diagnosa_nama_update=null;
		var diagnosa_keterangan_update=null;

		diagnosa_id_update_pk = oGrid_event.record.data.diagnosa_id;
		if(oGrid_event.record.data.diagnosa_kode!== null){diagnosa_kode_update = oGrid_event.record.data.diagnosa_kode;}
		if(oGrid_event.record.data.diagnosa_kategori!== null){diagnosa_kategori_update = oGrid_event.record.data.diagnosa_kategori;}
		if(oGrid_event.record.data.diagnosa_nama!== null){diagnosa_nama_update = oGrid_event.record.data.diagnosa_nama;}
		if(oGrid_event.record.data.diagnosa_keterangan!== null){diagnosa_keterangan_update = oGrid_event.record.data.diagnosa_keterangan;}

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_diagnosa&m=get_action',
			params: {
				task: "UPDATE",
				diagnosa_id	: diagnosa_id_update_pk, 
				diagnosa_kode	:diagnosa_kode_update,  
				diagnosa_kategori	:diagnosa_kategori_update,  
				diagnosa_nama	:diagnosa_nama_update,  
				diagnosa_keterangan	:diagnosa_keterangan_update
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						diagnosa_DataStore.commitChanges();
						diagnosa_DataStore.reload();
						break;
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'We could\'t not save the diagnosa.',
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
	function diagnosa_create(){
	
		if(is_diagnosa_form_valid()){	
		var diagnosa_id_create=null; 
		var diagnosa_kode_create=null; 
		var diagnosa_kategori_create=null; 
		var diagnosa_nama_create=null; 
		var diagnosa_keterangan_create=null;

		if(diagnosa_idField.getValue()!== null){diagnosa_id_create_pk = diagnosa_idField.getValue();} 
		if(diagnosa_kodeField.getValue()!== null){diagnosa_kode_create = diagnosa_kodeField.getValue();} 
		if(diagnosa_kategoriField.getValue()!== null){diagnosa_kategori_create = diagnosa_kategoriField.getValue();} 
		if(diagnosa_namaField.getValue()!== null){diagnosa_nama_create = diagnosa_namaField.getValue();} 
		if(diagnosa_keteranganField.getValue()!== null){diagnosa_keterangan_create = diagnosa_keteranganField.getValue();}

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_diagnosa&m=get_action',
			params: {
				task: post2db,
				diagnosa_id	: diagnosa_id_create_pk, 
				diagnosa_kode	: diagnosa_kode_create, 
				diagnosa_kategori	: diagnosa_kategori_create, 
				diagnosa_nama	: diagnosa_nama_create, 
				diagnosa_keterangan	: diagnosa_keterangan_create
			}, 
			success: function(response){             
				var result=eval(response.responseText);
				switch(result){
					case 1:
						Ext.MessageBox.alert(post2db+' OK','The Diagnosa was '+msg+' successfully.');
						diagnosa_DataStore.reload();
						diagnosa_createWindow.hide();
						break;
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'We could\'t not '+msg+' the Diagnosa.',
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
			return diagnosaListEditorGrid.getSelectionModel().getSelected().get('diagnosa_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function diagnosa_reset_form(){
		diagnosa_idField.reset();
		diagnosa_idField.setValue(null);
		diagnosa_kodeField.reset();
		diagnosa_kodeField.setValue(null);
		diagnosa_kategoriField.reset();
		diagnosa_kategoriField.setValue(null);
		diagnosa_namaField.reset();
		diagnosa_namaField.setValue(null);
		diagnosa_keteranganField.reset();
		diagnosa_keteranganField.setValue(null);
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function diagnosa_set_form(){
		diagnosa_idField.setValue(diagnosaListEditorGrid.getSelectionModel().getSelected().get('diagnosa_id'));
		diagnosa_kodeField.setValue(diagnosaListEditorGrid.getSelectionModel().getSelected().get('diagnosa_kode'));
		diagnosa_kategoriField.setValue(diagnosaListEditorGrid.getSelectionModel().getSelected().get('diagnosa_kategori'));
		diagnosa_namaField.setValue(diagnosaListEditorGrid.getSelectionModel().getSelected().get('diagnosa_nama'));
		diagnosa_keteranganField.setValue(diagnosaListEditorGrid.getSelectionModel().getSelected().get('diagnosa_keterangan'));
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_diagnosa_form_valid(){
		return (true );
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!diagnosa_createWindow.isVisible()){
			diagnosa_reset_form();
			post2db='CREATE';
			msg='created';
			diagnosa_createWindow.show();
		} else {
			diagnosa_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function diagnosa_confirm_delete(){
		// only one diagnosa is selected here
		if(diagnosaListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', diagnosa_delete);
		} else if(diagnosaListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', diagnosa_delete);
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
	function diagnosa_confirm_update(){
		/* only one record is selected here */
		if(diagnosaListEditorGrid.selModel.getCount() == 1) {
			diagnosa_set_form();
			post2db='UPDATE';
			msg='updated';
			diagnosa_createWindow.show();
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
	function diagnosa_delete(btn){
		if(btn=='yes'){
			var selections = diagnosaListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< diagnosaListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.diagnosa_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_diagnosa&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							diagnosa_DataStore.reload();
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
	diagnosa_DataStore = new Ext.data.Store({
		id: 'diagnosa_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_diagnosa&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'diagnosa_id'
		},[
		/* dataIndex => insert intodiagnosa_ColumnModel, Mapping => for initiate table column */ 
			{name: 'diagnosa_id', type: 'int', mapping: 'diagnosa_id'}, 
			{name: 'diagnosa_kode', type: 'string', mapping: 'diagnosa_kode'}, 
			{name: 'diagnosa_kategori', type: 'string', mapping: 'diagnosa_kategori'}, 
			{name: 'diagnosa_nama', type: 'string', mapping: 'diagnosa_nama'}, 
			{name: 'diagnosa_keterangan', type: 'string', mapping: 'diagnosa_keterangan'}, 
			{name: 'diagnosa_author', type: 'string', mapping: 'diagnosa_author'}, 
			{name: 'diagnosa_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'diagnosa_date_create'}, 
			{name: 'diagnosa_update', type: 'string', mapping: 'diagnosa_update'}, 
			{name: 'diagnosa_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'diagnosa_date_update'}, 
			{name: 'diagnosa_revised', type: 'int', mapping: 'diagnosa_revised'} 
		]),
		sortInfo:{field: 'diagnosa_id', direction: "DESC"}
	});
	/* End of Function */
    
  	/* Function for Identify of Window Column Model */
	diagnosa_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'diagnosa_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: false
		},
		{
			header: 'Kode',
			dataIndex: 'diagnosa_kode',
			width: 150,
			sortable: true,
			editor: new Ext.form.TextField({
				allowBlank: false,
				maxLength: 255
          	})
		}, 
		{
			header: 'Kategori',
			dataIndex: 'diagnosa_kategori',
			width: 150,
			sortable: true,
			editor: new Ext.form.TextField({
				allowBlank: false,
				maxLength: 255
          	})
		}, 
		{
			header: 'Nama',
			dataIndex: 'diagnosa_nama',
			width: 150,
			sortable: true,
			editor: new Ext.form.TextField({
				allowBlank: false,
				maxLength: 255
          	})
		}, 
		{
			header: 'Keterangan',
			dataIndex: 'diagnosa_keterangan',
			width: 150,
			sortable: true,
			editor: new Ext.form.TextField({
				allowBlank: false,
				maxLength: 255
          	})
		}, 
		{
			header: 'Author',
			dataIndex: 'diagnosa_author',
			width: 150,
			sortable: true,
			readOnly: true,
			hidden: true
		}, 
		{
			header: 'Create on',
			dataIndex: 'diagnosa_date_create',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}, 
		{
			header: 'Last Update by',
			dataIndex: 'diagnosa_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}, 
		{
			header: 'Last Update on',
			dataIndex: 'diagnosa_date_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}, 
		{
			header: 'Revised',
			dataIndex: 'diagnosa_revised',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}	]);
	
	diagnosa_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	diagnosaListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'diagnosaListEditorGrid',
		el: 'fp_diagnosa',
		title: 'List Of Diagnosa',
		autoHeight: true,
		store: diagnosa_DataStore, // DataStore
		cm: diagnosa_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 700,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: diagnosa_DataStore,
			displayInfo: true
		}),
		/* Add Control on ToolBar */
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: diagnosa_confirm_update   // Confirm before updating
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: diagnosa_confirm_delete   // Confirm before deleting
		}, '-', {
			text: 'Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: diagnosa_DataStore,
			params: {start: 0, limit: pageS},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: diagnosa_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: diagnosa_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: diagnosa_print  
		}
		]
	});
	diagnosaListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	diagnosa_ContextMenu = new Ext.menu.Menu({
		id: 'diagnosa_ListEditorGridContextMenu',
		items: [
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: diagnosa_editContextMenu 
		},
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			handler: diagnosa_confirm_delete 
		},
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: diagnosa_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: diagnosa_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function ondiagnosa_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		diagnosa_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		diagnosa_SelectedRow=rowIndex;
		diagnosa_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function diagnosa_editContextMenu(){
		diagnosaListEditorGrid.startEditing(diagnosa_SelectedRow,1);
  	}
	/* End of Function */
  	
	diagnosaListEditorGrid.addListener('rowcontextmenu', ondiagnosa_ListEditGridContextMenu);
	diagnosa_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	diagnosaListEditorGrid.on('afteredit', diagnosa_update); // inLine Editing Record
	
	/* Identify  diagnosa_id Field */
	diagnosa_idField= new Ext.form.NumberField({
		id: 'diagnosa_idField',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: false,
				hidden: true,
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  diagnosa_kode Field */
	diagnosa_kodeField= new Ext.form.TextField({
		id: 'diagnosa_kodeField',
		fieldLabel: 'Kode',
		maxLength: 255,
		allowBlank: false,
		anchor: '50%'
	});
	/* Identify  diagnosa_kategori Field */
	diagnosa_kategoriField= new Ext.form.TextField({
		id: 'diagnosa_kategoriField',
		fieldLabel: 'Kategori',
		maxLength: 255,
		allowBlank: true,
		anchor: '95%'
	});
	/* Identify  diagnosa_nama Field */
	diagnosa_namaField= new Ext.form.TextField({
		id: 'diagnosa_namaField',
		fieldLabel: 'Nama',
		maxLength: 255,
		allowBlank: false,
		anchor: '95%'
	});
	/* Identify  diagnosa_keterangan Field */
	diagnosa_keteranganField= new Ext.form.TextArea({
		id: 'diagnosa_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 255,
		allowBlank: true,
		anchor: '95%'
	});
	
	/* Function for retrieve create Window Panel*/ 
	diagnosa_createForm = new Ext.FormPanel({
		labelAlign: 'top',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 300,        
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [diagnosa_kodeField, diagnosa_kategoriField, diagnosa_namaField, diagnosa_keteranganField] 
			}
			],
		buttons: [{
				text: 'Save and Close',
				handler: diagnosa_create
			}
			,{
				text: 'Cancel',
				handler: function(){
					diagnosa_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	diagnosa_createWindow= new Ext.Window({
		id: 'diagnosa_createWindow',
		title: post2db+'Diagnosa',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_diagnosa_create',
		items: diagnosa_createForm
	});
	/* End Window */
	
	/* Function for action list search */
	function diagnosa_list_search(){
		// render according to a SQL date format.
		var diagnosa_id_search=null;
		var diagnosa_kode_search=null;
		var diagnosa_kategori_search=null;
		var diagnosa_nama_search=null;
		var diagnosa_keterangan_search=null;

		if(diagnosa_idSearchField.getValue()!==null){diagnosa_id_search=diagnosa_idSearchField.getValue();}
		if(diagnosa_kodeSearchField.getValue()!==null){diagnosa_kode_search=diagnosa_kodeSearchField.getValue();}
		if(diagnosa_kategoriSearchField.getValue()!==null){diagnosa_kategori_search=diagnosa_kategoriSearchField.getValue();}
		if(diagnosa_namaSearchField.getValue()!==null){diagnosa_nama_search=diagnosa_namaSearchField.getValue();}
		if(diagnosa_keteranganSearchField.getValue()!==null){diagnosa_keterangan_search=diagnosa_keteranganSearchField.getValue();}
		// change the store parameters
		diagnosa_DataStore.baseParams = {
			task: 'SEARCH',
			//variable here
			diagnosa_id	:	diagnosa_id_search, 
			diagnosa_kode	:	diagnosa_kode_search, 
			diagnosa_kategori	:	diagnosa_kategori_search, 
			diagnosa_nama	:	diagnosa_nama_search, 
			diagnosa_keterangan	:	diagnosa_keterangan_search
		};
		// Cause the datastore to do another query : 
		diagnosa_DataStore.reload({params: {start: 0, limit: pageS}});
	}
		
	/* Function for reset search result */
	function diagnosa_reset_search(){
		// reset the store parameters
		diagnosa_DataStore.baseParams = { task: 'LIST' };
		// Cause the datastore to do another query : 
		diagnosa_DataStore.reload({params: {start: 0, limit: pageS}});
		diagnosa_searchWindow.close();
	};
	/* End of Fuction */
	
	/* Field for search */
	/* Identify  diagnosa_id Search Field */
	diagnosa_idSearchField= new Ext.form.NumberField({
		id: 'diagnosa_idSearchField',
		fieldLabel: 'Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  diagnosa_kode Search Field */
	diagnosa_kodeSearchField= new Ext.form.TextField({
		id: 'diagnosa_kodeSearchField',
		fieldLabel: 'Kode',
		maxLength: 255,
		anchor: '95%'
	
	});
	/* Identify  diagnosa_kategori Search Field */
	diagnosa_kategoriSearchField= new Ext.form.TextField({
		id: 'diagnosa_kategoriSearchField',
		fieldLabel: 'Kategori',
		maxLength: 255,
		anchor: '95%'
	
	});
	/* Identify  diagnosa_nama Search Field */
	diagnosa_namaSearchField= new Ext.form.TextField({
		id: 'diagnosa_namaSearchField',
		fieldLabel: 'Nama',
		maxLength: 255,
		anchor: '95%'
	
	});
	/* Identify  diagnosa_keterangan Search Field */
	diagnosa_keteranganSearchField= new Ext.form.TextField({
		id: 'diagnosa_keteranganSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 255,
		anchor: '95%'
	
	});
	    
	/* Function for retrieve search Form Panel */
	diagnosa_searchForm = new Ext.FormPanel({
		labelAlign: 'top',
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
				items: [diagnosa_idSearchField, diagnosa_kodeSearchField, diagnosa_kategoriSearchField, diagnosa_namaSearchField, diagnosa_keteranganSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: diagnosa_list_search
			},{
				text: 'Close',
				handler: function(){
					diagnosa_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	diagnosa_searchWindow = new Ext.Window({
		title: 'diagnosa Search',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_diagnosa_search',
		items: diagnosa_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!diagnosa_searchWindow.isVisible()){
			diagnosa_searchWindow.show();
		} else {
			diagnosa_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function diagnosa_print(){
		var searchquery = "";
		var diagnosa_id_print=null;
		var diagnosa_kode_print=null;
		var diagnosa_kategori_print=null;
		var diagnosa_nama_print=null;
		var diagnosa_keterangan_print=null;
		var win;              
		// check if we do have some search data...
		if(diagnosa_DataStore.baseParams.query!==null){searchquery = diagnosa_DataStore.baseParams.query;}
		if(diagnosa_DataStore.baseParams.diagnosa_id!==null){diagnosa_id_print = diagnosa_DataStore.baseParams.diagnosa_id;}
		if(diagnosa_DataStore.baseParams.diagnosa_kode!==null){diagnosa_kode_print = diagnosa_DataStore.baseParams.diagnosa_kode;}
		if(diagnosa_DataStore.baseParams.diagnosa_kategori!==null){diagnosa_kategori_print = diagnosa_DataStore.baseParams.diagnosa_kategori;}
		if(diagnosa_DataStore.baseParams.diagnosa_nama!==null){diagnosa_nama_print = diagnosa_DataStore.baseParams.diagnosa_nama;}
		if(diagnosa_DataStore.baseParams.diagnosa_keterangan!==null){diagnosa_keterangan_print = diagnosa_DataStore.baseParams.diagnosa_keterangan;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_diagnosa&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			diagnosa_id : diagnosa_id_print,
			diagnosa_kode : diagnosa_kode_print,
			diagnosa_kategori : diagnosa_kategori_print,
			diagnosa_nama : diagnosa_nama_print,
			diagnosa_keterangan : diagnosa_keterangan_print,
		  	currentlisting: diagnosa_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./diagnosalist.html','diagnosalist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
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
	function diagnosa_export_excel(){
		var searchquery = "";
		var diagnosa_id_2excel=null;
		var diagnosa_kode_2excel=null;
		var diagnosa_kategori_2excel=null;
		var diagnosa_nama_2excel=null;
		var diagnosa_keterangan_2excel=null;
		var win;              
		// check if we do have some search data...
		if(diagnosa_DataStore.baseParams.query!==null){searchquery = diagnosa_DataStore.baseParams.query;}
		if(diagnosa_DataStore.baseParams.diagnosa_id!==null){diagnosa_id_2excel = diagnosa_DataStore.baseParams.diagnosa_id;}
		if(diagnosa_DataStore.baseParams.diagnosa_kode!==null){diagnosa_kode_2excel = diagnosa_DataStore.baseParams.diagnosa_kode;}
		if(diagnosa_DataStore.baseParams.diagnosa_kategori!==null){diagnosa_kategori_2excel = diagnosa_DataStore.baseParams.diagnosa_kategori;}
		if(diagnosa_DataStore.baseParams.diagnosa_nama!==null){diagnosa_nama_2excel = diagnosa_DataStore.baseParams.diagnosa_nama;}
		if(diagnosa_DataStore.baseParams.diagnosa_keterangan!==null){diagnosa_keterangan_2excel = diagnosa_DataStore.baseParams.diagnosa_keterangan;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_diagnosa&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			diagnosa_id : diagnosa_id_2excel,
			diagnosa_kode : diagnosa_kode_2excel,
			diagnosa_kategori : diagnosa_kategori_2excel,
			diagnosa_nama : diagnosa_nama_2excel,
			diagnosa_keterangan : diagnosa_keterangan_2excel,
		  	currentlisting: diagnosa_DataStore.baseParams.task // this tells us if we are searching or not
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
        <div id="fp_diagnosa"></div>
		<div id="elwindow_diagnosa_create"></div>
        <div id="elwindow_diagnosa_search"></div>
    </div>
</div>
</body>