<?
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: jabatan View
	+ Description	: For record view
	+ Filename 		: v_jabatan.php
 	+ Author  		: zainal, mukhlison
 	+ Created on 06/Aug/2009 15:46:36
	
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
var jabatan_DataStore;
var jabatan_ColumnModel;
var jabatanListEditorGrid;
var jabatan_createForm;
var jabatan_createWindow;
var jabatan_searchForm;
var jabatan_searchWindow;
var jabatan_SelectedRow;
var jabatan_ContextMenu;
//declare konstant
var post2db = '';
var msg = '';
var pageS=15;

/* declare variable here */
var jabatan_idField;
var jabatan_namaField;
var jabatan_keteranganField;
var jabatan_aktifField;

var jabatan_idSearchField;
var jabatan_namaSearchField;
var jabatan_keteranganSearchField;
var jabatan_aktifSearchField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  	/* Function for Saving inLine Editing */
	function jabatan_update(oGrid_event){
	var jabatan_id_update_pk="";
	var jabatan_nama_update=null;
	var jabatan_keterangan_update=null;
	var jabatan_aktif_update=null;

	jabatan_id_update_pk = get_pk_id();
	if(oGrid_event.record.data.jabatan_nama!== null){jabatan_nama_update = oGrid_event.record.data.jabatan_nama;}
	if(oGrid_event.record.data.jabatan_keterangan!== null){jabatan_keterangan_update = oGrid_event.record.data.jabatan_keterangan;}
	if(oGrid_event.record.data.jabatan_aktif!== null){jabatan_aktif_update = oGrid_event.record.data.jabatan_aktif;}

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_jabatan&m=get_action',
			params: {
				task: "UPDATE",
				jabatan_id	: get_pk_id(),				
				jabatan_nama	:jabatan_nama_update,		
				jabatan_keterangan	:jabatan_keterangan_update,		
				jabatan_aktif	:jabatan_aktif_update,		
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						jabatan_DataStore.commitChanges();
						jabatan_DataStore.reload();
						break;
					default:
						Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Data Jabatan tidak bisa disimpan !.',
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
	function jabatan_create(){
		if(is_jabatan_form_valid()){
		
		var jabatan_id_create_pk=null;
		var jabatan_nama_create=null;
		var jabatan_keterangan_create=null;
		var jabatan_aktif_create=null;

		jabatan_id_create_pk=get_pk_id();
		if(jabatan_namaField.getValue()!== null){jabatan_nama_create = jabatan_namaField.getValue();}
		if(jabatan_keteranganField.getValue()!== null){jabatan_keterangan_create = jabatan_keteranganField.getValue();}
		if(jabatan_aktifField.getValue()!== null){jabatan_aktif_create = jabatan_aktifField.getValue();}

			Ext.Ajax.request({  
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_jabatan&m=get_action',
				params: {
					task: post2db,
					jabatan_id	: jabatan_id_create_pk,	
					jabatan_nama	: jabatan_nama_create,	
					jabatan_keterangan	: jabatan_keterangan_create,	
					jabatan_aktif	: jabatan_aktif_create,	
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							Ext.MessageBox.alert(post2db+' OK','Data Jabatan berhasil disimpan ');
							jabatan_DataStore.reload();
							jabatan_createWindow.hide();
							break;
						default:
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Data Jabatan tidak bisa disimpan !',
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
			return jabatanListEditorGrid.getSelectionModel().getSelected().get('jabatan_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function jabatan_reset_form(){
		jabatan_namaField.reset();
		jabatan_namaField.setValue(null);
		jabatan_keteranganField.reset();
		jabatan_keteranganField.setValue(null);
		jabatan_aktifField.reset();
		jabatan_aktifField.setValue(null);
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function jabatan_set_form(){
		jabatan_namaField.setValue(jabatanListEditorGrid.getSelectionModel().getSelected().get('jabatan_nama'));
		jabatan_keteranganField.setValue(jabatanListEditorGrid.getSelectionModel().getSelected().get('jabatan_keterangan'));
		jabatan_aktifField.setValue(jabatanListEditorGrid.getSelectionModel().getSelected().get('jabatan_aktif'));
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_jabatan_form_valid(){
		return (jabatan_namaField.isValid());
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!jabatan_createWindow.isVisible()){
			
			post2db='CREATE';
			msg='created';
			jabatan_reset_form();
			
			jabatan_createWindow.show();
		} else {
			jabatan_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function jabatan_confirm_delete(){
		// only one jabatan is selected here
		if(jabatanListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', jabatan_delete);
		} else if(jabatanListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', jabatan_delete);
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
	function jabatan_confirm_update(){
		/* only one record is selected here */
		if(jabatanListEditorGrid.selModel.getCount() == 1) {
			
			post2db='UPDATE';
			msg='updated';
			jabatan_set_form();
			
			jabatan_createWindow.show();
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
	function jabatan_delete(btn){
		if(btn=='yes'){
			var selections = jabatanListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< jabatanListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.jabatan_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_jabatan&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							jabatan_DataStore.reload();
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
	jabatan_DataStore = new Ext.data.Store({
		id: 'jabatan_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_jabatan&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit:pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'jabatan_id'
		},[
			{name: 'jabatan_id', type: 'int', mapping: 'jabatan_id'},
			{name: 'jabatan_nama', type: 'string', mapping: 'jabatan_nama'},
			{name: 'jabatan_keterangan', type: 'string', mapping: 'jabatan_keterangan'},
			{name: 'jabatan_aktif', type: 'string', mapping: 'jabatan_aktif'},
			{name: 'jabatan_creator', type: 'string', mapping: 'jabatan_creator'},
			{name: 'jabatan_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'jabatan_date_create'},
			{name: 'jabatan_update', type: 'string', mapping: 'jabatan_update'},
			{name: 'jabatan_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'jabatan_date_update'},
			{name: 'jabatan_revised', type: 'int', mapping: 'jabatan_revised'}
		]),
		sortInfo:{field: 'jabatan_id', direction: "ASC"}
	});
	/* End of Function */
    
  	/* Function for Identify of Window Column Model */
	jabatan_ColumnModel = new Ext.grid.ColumnModel(
		[{
			//index=0
			header: '#',
			readOnly: true,
			dataIndex: 'jabatan_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},
		{
			/*index=1*/
			header: 'Nama',
			dataIndex: 'jabatan_nama',
			width: 150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_JABATAN'))){ ?>
			,
			editor: new Ext.form.TextField({
				allowBlank: false,
				maxLength: 250
          	})
			<?php } ?>
		},
		{
			/*index=2*/
			header: 'Keterangan',
			dataIndex: 'jabatan_keterangan',
			width: 150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_JABATAN'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
			<?php } ?>
		},
		{
			/*index=3*/
			header: 'Status',
			dataIndex: 'jabatan_aktif',
			width: 150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_JABATAN'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['jabatan_aktif_value', 'jabatan_aktif_display'],
					data: [['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
					}),
				mode: 'local',
               	displayField: 'jabatan_aktif_display',
               	valueField: 'jabatan_aktif_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
			<?php } ?>
		},
		{
			/*index=4*/
			header: 'Creator',
			dataIndex: 'jabatan_creator',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		},
		{
			/*index=5*/
			header: 'Create on',
			dataIndex: 'jabatan_date_create',
			width: 150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			hidden: true,
			readOnly: true
		},
		{
			/*index=6*/
			header: 'Last Update by',
			dataIndex: 'jabatan_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		},
		{
			/*index=7*/
			header: 'Last Update on',
			dataIndex: 'jabatan_date_update',
			width: 150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			hidden: true,
			readOnly: true
		},
		{
			/*index=8*/
			header: 'Revised',
			dataIndex: 'jabatan_revised',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}]
	);
	jabatan_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	jabatanListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'jabatanListEditorGrid',
		el: 'fp_jabatan',
		title: 'Daftar Jabatan',
		autoHeight: true,
		store: jabatan_DataStore, // DataStore
		cm: jabatan_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 700,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: jabatan_DataStore,
			displayInfo: true
		}),
		/* Add Control on ToolBar */
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_JABATAN'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<?php } ?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_JABATAN'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: jabatan_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_JABATAN'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: jabatan_confirm_delete   // Confirm before deleting
		}, '-', 
		<?php } ?>
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: jabatan_DataStore,
			params: {task: 'LIST',start: 0, limit: pageS},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						jabatan_DataStore.baseParams={task:'LIST',start: 0, limit: pageS};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Search By'});
				Ext.get(this.id).set({qtip:'- Nama <br>- Keterangan'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: jabatan_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: jabatan_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: jabatan_print  
		}
		]
	});
	jabatanListEditorGrid.render();
	/* End of DataStore */
	
	/*jabatanListEditorGrid.getColumnModel().setHidden(4, true);
	jabatanListEditorGrid.getColumnModel().setHidden(5, true);
	jabatanListEditorGrid.getColumnModel().setHidden(6, true);
	jabatanListEditorGrid.getColumnModel().setHidden(7, true);
	jabatanListEditorGrid.getColumnModel().setHidden(8, true);*/
     
	/* Create Context Menu */
	jabatan_ContextMenu = new Ext.menu.Menu({
		id: 'jabatan_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_JABATAN'))){ ?>
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: jabatan_confirm_update 
		},
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_JABATAN'))){ ?>
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			handler: jabatan_confirm_delete 
		},
		<?php } ?>
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: jabatan_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: jabatan_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onjabatan_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		jabatan_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		jabatan_SelectedRow=rowIndex;
		jabatan_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function jabatan_editContextMenu(){
      jabatanListEditorGrid.startEditing(jabatan_SelectedRow,1);
  	}
	/* End of Function */
  	
	jabatanListEditorGrid.addListener('rowcontextmenu', onjabatan_ListEditGridContextMenu);
	jabatan_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	jabatanListEditorGrid.on('afteredit', jabatan_update); // inLine Editing Record
	
	/* Identify  jabatan_nama Field */
	jabatan_namaField= new Ext.form.TextField({
		id: 'jabatan_namaField',
		fieldLabel: 'Nama <span style="color: #ec0000">*</span>',
		maxLength: 250,
		allowBlank: false,
		anchor: '95%'
	});
	/* Identify  jabatan_keterangan Field */
	jabatan_keteranganField= new Ext.form.TextArea({
		id: 'jabatan_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '95%'
	});
	/* Identify  jabatan_aktif Field */
	jabatan_aktifField= new Ext.form.ComboBox({
		id: 'jabatan_aktifField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['jabatan_aktif_value', 'jabatan_aktif_display'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		editable: false,
		emptyText: 'Aktif',
		displayField: 'jabatan_aktif_display',
		valueField: 'jabatan_aktif_value',
		width: 80,
		triggerAction: 'all'	
	});
  	
	/* Function for retrieve create Window Panel*/ 
	jabatan_createForm = new Ext.FormPanel({
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
				items: [jabatan_namaField, jabatan_keteranganField, jabatan_aktifField] 
			}
			]
		}]
		,
		buttons: [
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JABATAN'))){ ?>
			{
				text: 'Save and Close',
				handler: jabatan_create
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					jabatan_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	jabatan_createWindow= new Ext.Window({
		id: 'jabatan_createWindow',
		title: post2db+'Jabatan',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_jabatan_create',
		items: jabatan_createForm
	});
	/* End Window */
	
	
	/* Function for action list search */
	function jabatan_list_search(){
		// render according to a SQL date format.
		var jabatan_id_search=null;
		var jabatan_nama_search=null;
		var jabatan_keterangan_search=null;
		var jabatan_aktif_search=null;

		if(jabatan_idSearchField.getValue()!==null){jabatan_id_search=jabatan_idSearchField.getValue();}
		if(jabatan_namaSearchField.getValue()!==null){jabatan_nama_search=jabatan_namaSearchField.getValue();}
		if(jabatan_keteranganSearchField.getValue()!==null){jabatan_keterangan_search=jabatan_keteranganSearchField.getValue();}
		if(jabatan_aktifSearchField.getValue()!==null){jabatan_aktif_search=jabatan_aktifSearchField.getValue();}
		// change the store parameters
		jabatan_DataStore.baseParams = {
			task: 'SEARCH',
			start: 0,
			limit: pageS,
			//variable here
			jabatan_id	:	jabatan_id_search, 
			jabatan_nama	:	jabatan_nama_search, 
			jabatan_keterangan	:	jabatan_keterangan_search, 
			jabatan_aktif	:	jabatan_aktif_search, 
		};
		// Cause the datastore to do another query : 
		jabatan_DataStore.reload({params: {start: 0, limit: pageS}});
	}
		
	/* Function for reset search result */
	function jabatan_reset_search(){
		// reset the store parameters
		jabatan_DataStore.baseParams = { task: 'LIST' };
		// Cause the datastore to do another query : 
		jabatan_DataStore.reload({params: {start: 0, limit: pageS}});
		//jabatan_searchWindow.close();
	};
	/* End of Fuction */
	
	function jabatan_reset_SearchForm(){
		jabatan_namaSearchField.reset();
		jabatan_namaSearchField.setValue(null);
		jabatan_keteranganSearchField.reset();
		jabatan_keteranganSearchField.setValue(null);
		jabatan_aktifSearchField.reset();
		jabatan_aktifSearchField.setValue(null);
	}
	
	/* Field for search */
	/* Identify  jabatan_id Search Field */
	jabatan_idSearchField= new Ext.form.NumberField({
		id: 'jabatan_idSearchField',
		fieldLabel: 'Jabatan Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  jabatan_nama Search Field */
	jabatan_namaSearchField= new Ext.form.TextField({
		id: 'jabatan_namaSearchField',
		fieldLabel: 'Nama Jabatan',
		maxLength: 250,
		anchor: '95%'
	
	});
	/* Identify  jabatan_keterangan Search Field */
	jabatan_keteranganSearchField= new Ext.form.TextField({
		id: 'jabatan_keteranganSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '95%'
	
	});
	/* Identify  jabatan_aktif Search Field */
	jabatan_aktifSearchField= new Ext.form.ComboBox({
		id: 'jabatan_aktifSearchField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['value', 'jabatan_aktif'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		displayField: 'jabatan_aktif',
		valueField: 'value',
		emptyText: 'Aktif',
		width: 80,
		triggerAction: 'all'	 
	
	});
    
	/* Function for retrieve search Form Panel */
	jabatan_searchForm = new Ext.FormPanel({
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
				items: [jabatan_namaSearchField, jabatan_keteranganSearchField, jabatan_aktifSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: jabatan_list_search
			},{
				text: 'Close',
				handler: function(){
					jabatan_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	jabatan_searchWindow = new Ext.Window({
		title: 'Pencarian Jabatan',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_jabatan_search',
		items: jabatan_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!jabatan_searchWindow.isVisible()){
			jabatan_reset_SearchForm();
			jabatan_searchWindow.show();
		} else {
			jabatan_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function jabatan_print(){
		var searchquery = "";
		var jabatan_nama_print=null;
		var jabatan_keterangan_print=null;
		var jabatan_aktif_print=null;
		var win;              
		// check if we do have some search data...
		if(jabatan_DataStore.baseParams.query!==null){searchquery = jabatan_DataStore.baseParams.query;}
		if(jabatan_DataStore.baseParams.jabatan_nama!==null){jabatan_nama_print = jabatan_DataStore.baseParams.jabatan_nama;}
		if(jabatan_DataStore.baseParams.jabatan_keterangan!==null){jabatan_keterangan_print = jabatan_DataStore.baseParams.jabatan_keterangan;}
		if(jabatan_DataStore.baseParams.jabatan_aktif!==null){jabatan_aktif_print = jabatan_DataStore.baseParams.jabatan_aktif;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_jabatan&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		
			jabatan_nama : jabatan_nama_print,
			jabatan_keterangan : jabatan_keterangan_print,
			jabatan_aktif : jabatan_aktif_print,
		  	currentlisting: jabatan_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./jabatanlist.html','jabatanlist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
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
	function jabatan_export_excel(){
		var searchquery = "";
		var jabatan_nama_2excel=null;
		var jabatan_keterangan_2excel=null;
		var jabatan_aktif_2excel=null;
		var win;              
		// check if we do have some search data...
		if(jabatan_DataStore.baseParams.query!==null){searchquery = jabatan_DataStore.baseParams.query;}
		if(jabatan_DataStore.baseParams.jabatan_nama!==null){jabatan_nama_2excel = jabatan_DataStore.baseParams.jabatan_nama;}
		if(jabatan_DataStore.baseParams.jabatan_keterangan!==null){jabatan_keterangan_2excel = jabatan_DataStore.baseParams.jabatan_keterangan;}
		if(jabatan_DataStore.baseParams.jabatan_aktif!==null){jabatan_aktif_2excel = jabatan_DataStore.baseParams.jabatan_aktif;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_jabatan&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		
			jabatan_nama : jabatan_nama_2excel,
			jabatan_keterangan : jabatan_keterangan_2excel,
			jabatan_aktif : jabatan_aktif_2excel,
		  	currentlisting: jabatan_DataStore.baseParams.task // this tells us if we are searching or not
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
        <div id="fp_jabatan"></div>
		<div id="elwindow_jabatan_create"></div>
        <div id="elwindow_jabatan_search"></div>
    </div>
</div>
</body>