<?
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: gudang View
	+ Description	: For record view
	+ Filename 		: v_gudang.php
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
var gudang_DataStore;
var gudang_ColumnModel;
var gudangListEditorGrid;
var gudang_createForm;
var gudang_createWindow;
var gudang_searchForm;
var gudang_searchWindow;
var gudang_SelectedRow;
var gudang_ContextMenu;
//declare konstant
var post2db = '';
var msg = '';
var pageS=15;

/* declare variable here */
var gudang_idField;
var gudang_namaField;
var gudang_lokasiField;
var gudang_keteranganField;
var gudang_aktifField;

var gudang_idSearchField;
var gudang_namaSearchField;
var gudang_lokasiSearchField;
var gudang_keteranganSearchField;
var gudang_aktifSearchField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  	/* Function for Saving inLine Editing */
	function gudang_update(oGrid_event){
	var gudang_id_update_pk="";
	var gudang_nama_update=null;
	var gudang_lokasi_update=null;
	var gudang_keterangan_update=null;
	var gudang_aktif_update=null;


	gudang_id_update_pk = oGrid_event.record.data.gudang_id;
	if(oGrid_event.record.data.gudang_nama!== null){gudang_nama_update = oGrid_event.record.data.gudang_nama;}
	if(oGrid_event.record.data.gudang_lokasi!== null){gudang_lokasi_update = oGrid_event.record.data.gudang_lokasi;}
	if(oGrid_event.record.data.gudang_keterangan!== null){gudang_keterangan_update = oGrid_event.record.data.gudang_keterangan;}
	if(oGrid_event.record.data.gudang_aktif!== null){gudang_aktif_update = oGrid_event.record.data.gudang_aktif;}
	

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_gudang&m=get_action',
			params: {
				task: "UPDATE",
				gudang_id	: gudang_id_update_pk,				
				gudang_nama	:gudang_nama_update,		
				gudang_lokasi	:gudang_lokasi_update,		
				gudang_keterangan	:gudang_keterangan_update,		
				gudang_aktif	:gudang_aktif_update	
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						gudang_DataStore.commitChanges();
						gudang_DataStore.reload();
						break;
					default:
						Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Data Gudang tidak bisa disimpan.',
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
	function gudang_create(){
		if(is_gudang_form_valid()){
		
		var gudang_id_create_pk=null;
		var gudang_nama_create=null;
		var gudang_lokasi_create=null;
		var gudang_keterangan_create=null;
		var gudang_aktif_create=null;

		gudang_id_create_pk=get_pk_id();
		if(gudang_namaField.getValue()!== null){gudang_nama_create = gudang_namaField.getValue();}
		if(gudang_lokasiField.getValue()!== null){gudang_lokasi_create = gudang_lokasiField.getValue();}
		if(gudang_keteranganField.getValue()!== null){gudang_keterangan_create = gudang_keteranganField.getValue();}
		if(gudang_aktifField.getValue()!== null){gudang_aktif_create = gudang_aktifField.getValue();}
		
			Ext.Ajax.request({  
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_gudang&m=get_action',
				params: {
					task: post2db,
					gudang_id	: gudang_id_create_pk,	
					gudang_nama	: gudang_nama_create,	
					gudang_lokasi	: gudang_lokasi_create,	
					gudang_keterangan	: gudang_keterangan_create,	
					gudang_aktif	: gudang_aktif_create
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							Ext.MessageBox.alert(post2db+' OK','Data Gudang berhasil disimpan');
							gudang_DataStore.reload();
							gudang_createWindow.hide();
							break;
						default:
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Data Gudang tidak bisa disimpan !.',
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
			return gudangListEditorGrid.getSelectionModel().getSelected().get('gudang_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function gudang_reset_form(){
		gudang_namaField.reset();
		gudang_lokasiField.reset();
		gudang_keteranganField.reset();
		gudang_aktifField.reset();
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function gudang_set_form(){
		gudang_namaField.setValue(gudangListEditorGrid.getSelectionModel().getSelected().get('gudang_nama'));
		gudang_lokasiField.setValue(gudangListEditorGrid.getSelectionModel().getSelected().get('gudang_lokasi'));
		gudang_keteranganField.setValue(gudangListEditorGrid.getSelectionModel().getSelected().get('gudang_keterangan'));
		gudang_aktifField.setValue(gudangListEditorGrid.getSelectionModel().getSelected().get('gudang_aktif'));
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_gudang_form_valid(){
		return (gudang_namaField.isValid());
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!gudang_createWindow.isVisible()){
			
			post2db='CREATE';
			msg='created';
			gudang_reset_form();
			
			gudang_createWindow.show();
		} else {
			gudang_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function gudang_confirm_delete(){
		// only one gudang is selected here
		if(gudangListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', gudang_delete);
		} else if(gudangListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', gudang_delete);
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
	function gudang_confirm_update(){
		/* only one record is selected here */
		if(gudangListEditorGrid.selModel.getCount() == 1) {
			
			post2db='UPDATE';
			msg='updated';
			gudang_set_form();
			
			gudang_createWindow.show();
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
	function gudang_delete(btn){
		if(btn=='yes'){
			var selections = gudangListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< gudangListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.gudang_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Mohon tunggu...',
				url: 'index.php?c=c_gudang&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							gudang_DataStore.reload();
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
	gudang_DataStore = new Ext.data.Store({
		id: 'gudang_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_gudang&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit:pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'gudang_id'
		},[
			{name: 'gudang_id', type: 'int', mapping: 'gudang_id'},
			{name: 'gudang_nama', type: 'string', mapping: 'gudang_nama'},
			{name: 'gudang_lokasi', type: 'string', mapping: 'gudang_lokasi'},
			{name: 'gudang_keterangan', type: 'string', mapping: 'gudang_keterangan'},
			{name: 'gudang_aktif', type: 'string', mapping: 'gudang_aktif'},
			{name: 'gudang_creator', type: 'string', mapping: 'gudang_creator'},
			{name: 'gudang_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'gudang_date_create'},
			{name: 'gudang_update', type: 'string', mapping: 'gudang_update'},
			{name: 'gudang_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'gudang_date_update'},
			{name: 'gudang_revised', type: 'int', mapping: 'gudang_revised'}
		]),
		sortInfo:{field: 'gudang_nama', direction: "ASC"}
	});
	/* End of Function */
    
  	/* Function for Identify of Window Column Model */
	gudang_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'gudang_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},
		{
			header: '<div align="center">' + 'Nama Gudang' + '</div>',
			dataIndex: 'gudang_nama',
			width: 120,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_GUDANG'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
			<?php } ?>
		},
		{
			header: '<div align="center">' + 'Lokasi' + '</div>',
			dataIndex: 'gudang_lokasi',
			width: 100,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_GUDANG'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
			  <?php } ?>
		},
		{
			header: '<div align="center">' + 'Keterangan' + '</div>',
			dataIndex: 'gudang_keterangan',
			width: 200,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_GUDANG'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
			<?php } ?>
		},
		{
			header: '<div align="center">' + 'Status' + '</div>',
			dataIndex: 'gudang_aktif',
			width: 80,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_GUDANG'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['gudang_aktif_value', 'gudang_aktif_display'],
					data: [['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
					}),
				mode: 'local',
               	displayField: 'gudang_aktif_display',
               	valueField: 'gudang_aktif_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
			<?php } ?>
		},
		{
			header: 'Creator',
			dataIndex: 'gudang_creator',
			width: 150,
			sortable: true,
			hidden: true
		},
		{
			header: 'Create on',
			dataIndex: 'gudang_date_create',
			width: 150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			hidden: true
		},
		{
			header: 'Last Update by',
			dataIndex: 'gudang_update',
			width: 150,
			sortable: true,
			hidden: true
		},
		{
			header: 'Last Update on',
			dataIndex: 'gudang_date_update',
			width: 150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			hidden: true
		},
		{
			header: 'Revised',
			dataIndex: 'gudang_revised',
			width: 150,
			sortable: true,
			hidden: true
		}]
	);
	gudang_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	gudangListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'gudangListEditorGrid',
		el: 'fp_gudang',
		title: 'Daftar Gudang',
		autoHeight: true,
		store: gudang_DataStore, // DataStore
		cm: gudang_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 800,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: gudang_DataStore,
			displayInfo: true
		}),
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_GUDANG'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<?php } ?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_GUDANG'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: gudang_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_GUDANG'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: gudang_confirm_delete   // Confirm before deleting
		}, '-', 
		<?php } ?>
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: gudang_DataStore,
			params: {task: 'LIST',start: 0, limit: pageS},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						gudang_DataStore.baseParams={task:'LIST',start: 0, limit: pageS};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Search By'});
				Ext.get(this.id).set({qtip:'- Nama Gudang<br>- Lokasi<br>- Keterangan'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: gudang_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: gudang_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: gudang_print  
		}
		]
	});
	gudangListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	gudang_ContextMenu = new Ext.menu.Menu({
		id: 'gudang_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_GUDANG'))){ ?>
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: gudang_confirm_update 
		},
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_GUDANG'))){ ?>
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			handler: gudang_confirm_delete 
		},
		<?php } ?>
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: gudang_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: gudang_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function ongudang_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		gudang_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		gudang_SelectedRow=rowIndex;
		gudang_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function gudang_editContextMenu(){
      gudangListEditorGrid.startEditing(gudang_SelectedRow,1);
  	}
	/* End of Function */
  	
	gudangListEditorGrid.addListener('rowcontextmenu', ongudang_ListEditGridContextMenu);
	gudang_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	gudangListEditorGrid.on('afteredit', gudang_update); // inLine Editing Record
	
	/* Identify  gudang_nama Field */
	gudang_namaField= new Ext.form.TextField({
		id: 'gudang_namaField',
		fieldLabel: 'Nama Gudang <span style="color: #ec0000">*</span>',
		maxLength: 250,
		allowBlank: false,
		anchor: '95%'
	});
	/* Identify  gudang_lokasi Field */
	gudang_lokasiField= new Ext.form.TextField({
		id: 'gudang_lokasiField',
		fieldLabel: 'Lokasi',
		maxLength: 250,
		anchor: '95%'
	});
	/* Identify  gudang_keterangan Field */
	gudang_keteranganField= new Ext.form.TextArea({
		id: 'gudang_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '95%'
	});
	/* Identify  gudang_aktif Field */
	gudang_aktifField= new Ext.form.ComboBox({
		id: 'gudang_aktifField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['gudang_aktif_value', 'gudang_aktif_display'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		editable:false,
		displayField: 'gudang_aktif_display',
		valueField: 'gudang_aktif_value',
		emptyText: 'Aktif',
		width: 80,
		triggerAction: 'all'	
	});
	
  	
	/* Function for retrieve create Window Panel*/ 
	gudang_createForm = new Ext.FormPanel({
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
				items: [gudang_namaField, gudang_lokasiField, gudang_keteranganField, gudang_aktifField] 
			}
			]
		}]
		,
		buttons: [
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_GUDANG'))){ ?>
			{
				text: 'Save and Close',
				handler: gudang_create
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					gudang_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	gudang_createWindow= new Ext.Window({
		id: 'gudang_createWindow',
		title: post2db+'Gudang',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_gudang_create',
		items: gudang_createForm
	});
	/* End Window */
	
	
	/* Function for action list search */
	function gudang_list_search(){
		// render according to a SQL date format.
		var gudang_id_search=null;
		var gudang_nama_search=null;
		var gudang_lokasi_search=null;
		var gudang_keterangan_search=null;
		var gudang_aktif_search=null;


		if(gudang_idSearchField.getValue()!==null){gudang_id_search=gudang_idSearchField.getValue();}
		if(gudang_namaSearchField.getValue()!==null){gudang_nama_search=gudang_namaSearchField.getValue();}
		if(gudang_lokasiSearchField.getValue()!==null){gudang_lokasi_search=gudang_lokasiSearchField.getValue();}
		if(gudang_keteranganSearchField.getValue()!==null){gudang_keterangan_search=gudang_keteranganSearchField.getValue();}
		if(gudang_aktifSearchField.getValue()!==null){gudang_aktif_search=gudang_aktifSearchField.getValue();}

		// change the store parameters
		gudang_DataStore.baseParams = {
			task: 'SEARCH',
			start: 0,
			limit: pageS,
			gudang_id	:	gudang_id_search, 
			gudang_nama	:	gudang_nama_search, 
			gudang_lokasi	:	gudang_lokasi_search, 
			gudang_keterangan	:	gudang_keterangan_search, 
			gudang_aktif	:	gudang_aktif_search
	};
		// Cause the datastore to do another query : 
		gudang_DataStore.reload({params: {start: 0, limit: pageS}});
	}
		
	/* Function for reset search result */
	function gudang_reset_search(){
		// reset the store parameters
		gudang_DataStore.baseParams = { task: 'LIST', start:0, limit:pageS };
		gudang_DataStore.reload({params: {start: 0, limit: pageS}});
		//gudang_searchWindow.close();
	};
	/* End of Fuction */
	
	function gudang_reset_SearchForm(){
		gudang_namaSearchField.reset();
		gudang_lokasiSearchField.reset();
		gudang_keteranganSearchField.reset();
		gudang_aktifSearchField.reset();
	}
	
	/* Field for search */
	/* Identify  gudang_id Search Field */
	gudang_idSearchField= new Ext.form.NumberField({
		id: 'gudang_idSearchField',
		fieldLabel: 'Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  gudang_nama Search Field */
	gudang_namaSearchField= new Ext.form.TextField({
		id: 'gudang_namaSearchField',
		fieldLabel: 'Nama Gudang',
		maxLength: 250,
		anchor: '95%'
	
	});
	/* Identify  gudang_lokasi Search Field */
	gudang_lokasiSearchField= new Ext.form.TextField({
		id: 'gudang_lokasiSearchField',
		fieldLabel: 'Lokasi',
		maxLength: 250,
		anchor: '95%'
	
	});
	/* Identify  gudang_keterangan Search Field */
	gudang_keteranganSearchField= new Ext.form.TextField({
		id: 'gudang_keteranganSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '95%'
	
	});
	/* Identify  gudang_aktif Search Field */
	gudang_aktifSearchField= new Ext.form.ComboBox({
		id: 'gudang_aktifSearchField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['value', 'gudang_aktif'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		displayField: 'gudang_aktif',
		valueField: 'value',
		emptyText: 'Aktif',
		width: 80,
		triggerAction: 'all'	 
	
	});
	    
	/* Function for retrieve search Form Panel */
	gudang_searchForm = new Ext.FormPanel({
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
				items: [gudang_namaSearchField, gudang_lokasiSearchField, gudang_keteranganSearchField, gudang_aktifSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: gudang_list_search
			},{
				text: 'Close',
				handler: function(){
					gudang_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	gudang_searchWindow = new Ext.Window({
		title: 'Pencarian Gudang',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_gudang_search',
		items: gudang_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!gudang_searchWindow.isVisible()){
			gudang_reset_SearchForm();
			gudang_searchWindow.show();
		} else {
			gudang_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function gudang_print(){
		var searchquery = "";
		var gudang_nama_print=null;
		var gudang_lokasi_print=null;
		var gudang_keterangan_print=null;
		var gudang_aktif_print=null;
		var win;              
		// check if we do have some search data...
		if(gudang_DataStore.baseParams.query!==null){searchquery = gudang_DataStore.baseParams.query;}
		if(gudang_DataStore.baseParams.gudang_nama!==null){gudang_nama_print = gudang_DataStore.baseParams.gudang_nama;}
		if(gudang_DataStore.baseParams.gudang_lokasi!==null){gudang_lokasi_print = gudang_DataStore.baseParams.gudang_lokasi;}
		if(gudang_DataStore.baseParams.gudang_keterangan!==null){gudang_keterangan_print = gudang_DataStore.baseParams.gudang_keterangan;}
		if(gudang_DataStore.baseParams.gudang_aktif!==null){gudang_aktif_print = gudang_DataStore.baseParams.gudang_aktif;}
		

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_gudang&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		
			gudang_nama : gudang_nama_print,
			gudang_lokasi : gudang_lokasi_print,
			gudang_keterangan : gudang_keterangan_print,
			gudang_aktif : gudang_aktif_print,
		  	currentlisting: gudang_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./gudanglist.html','gudanglist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
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
	function gudang_export_excel(){
		var searchquery = "";
		var gudang_nama_2excel=null;
		var gudang_lokasi_2excel=null;
		var gudang_keterangan_2excel=null;
		var gudang_aktif_2excel=null;
		var win;              
		// check if we do have some search data...
		if(gudang_DataStore.baseParams.query!==null){searchquery = gudang_DataStore.baseParams.query;}
		if(gudang_DataStore.baseParams.gudang_nama!==null){gudang_nama_2excel = gudang_DataStore.baseParams.gudang_nama;}
		if(gudang_DataStore.baseParams.gudang_lokasi!==null){gudang_lokasi_2excel = gudang_DataStore.baseParams.gudang_lokasi;}
		if(gudang_DataStore.baseParams.gudang_keterangan!==null){gudang_keterangan_2excel = gudang_DataStore.baseParams.gudang_keterangan;}
		if(gudang_DataStore.baseParams.gudang_aktif!==null){gudang_aktif_2excel = gudang_DataStore.baseParams.gudang_aktif;}
		
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_gudang&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		
			gudang_nama : gudang_nama_2excel,
			gudang_lokasi : gudang_lokasi_2excel,
			gudang_keterangan : gudang_keterangan_2excel,
			gudang_aktif : gudang_aktif_2excel,
		  	currentlisting: gudang_DataStore.baseParams.task // this tells us if we are searching or not
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
        <div id="fp_gudang"></div>
		<div id="elwindow_gudang_create"></div>
        <div id="elwindow_gudang_search"></div>
    </div>
</div>
</body>