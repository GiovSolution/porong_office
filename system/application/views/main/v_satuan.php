<?
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: satuan View
	+ Description	: For record view
	+ Filename 		: v_satuan.php
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
var satuan_DataStore;
var satuan_ColumnModel;
var satuanListEditorGrid;
var satuan_createForm;
var satuan_createWindow;
var satuan_searchForm;
var satuan_searchWindow;
var satuan_SelectedRow;
var satuan_ContextMenu;
//declare konstant
var satuan_post2db = '';
var msg = '';
var satuan_pageS=15;

/* declare variable here */
var satuan_idField;
var satuan_kodeField;
var satuan_namaField;
var satuan_aktifField;

var satuan_idSearchField;
var satuan_kodeSearchField;
var satuan_namaSearchField;
var satuan_aktifSearchField;


/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  	/* Function for Saving inLine Editing */
	function satuan_update(oGrid_event){
	var satuan_id_update_pk="";
	var satuan_kode_update=null;
	var satuan_nama_update=null;
	var satuan_aktif_update=null;


	satuan_id_update_pk =  oGrid_event.record.data.satuan_id;
	if(oGrid_event.record.data.satuan_kode!== null){satuan_kode_update = oGrid_event.record.data.satuan_kode;}
	if(oGrid_event.record.data.satuan_nama!== null){satuan_nama_update = oGrid_event.record.data.satuan_nama;}
	if(oGrid_event.record.data.satuan_aktif!== null){satuan_aktif_update = oGrid_event.record.data.satuan_aktif;}
	
		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_satuan&m=get_action',
			params: {
				task: "UPDATE",
				satuan_id	: satuan_id_update_pk,				
				satuan_kode	:satuan_kode_update,		
				satuan_nama	:satuan_nama_update,		
				satuan_aktif	:satuan_aktif_update		
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						satuan_DataStore.commitChanges();
						satuan_DataStore.reload();
						break;
					default:
						Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Data Satuan tidak bisa disimpan.',
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
	function satuan_create(){
		if(is_satuan_form_valid()){
		
		var satuan_id_create_pk=null;
		var satuan_kode_create=null;
		var satuan_nama_create=null;
		var satuan_aktif_create=null;
		var satuan_creator_create=null;
		var satuan_date_create_create_date="";
		var satuan_update_create=null;
		var satuan_date_update_create_date="";
		var satuan_revised_create=null;

		satuan_id_create_pk=get_pk_id();
		if(satuan_kodeField.getValue()!== null){satuan_kode_create = satuan_kodeField.getValue();}
		if(satuan_namaField.getValue()!== null){satuan_nama_create = satuan_namaField.getValue();}
		if(satuan_aktifField.getValue()!== null){satuan_aktif_create = satuan_aktifField.getValue();}
	
			Ext.Ajax.request({  
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_satuan&m=get_action',
				params: {
					task: satuan_post2db,
					satuan_id	: satuan_id_create_pk,	
					satuan_kode	: satuan_kode_create,	
					satuan_nama	: satuan_nama_create,	
					satuan_aktif	: satuan_aktif_create	
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							Ext.MessageBox.alert(satuan_post2db+' OK','Data Satuan berhasil disimpan.');
							satuan_DataStore.reload();
							satuan_createWindow.hide();
							break;
						default:
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Data Satuan tidak bisa disimpan !',
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
		if(satuan_post2db=='UPDATE')
			return satuanListEditorGrid.getSelectionModel().getSelected().get('satuan_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function satuan_reset_form(){
		satuan_kodeField.reset();
		satuan_namaField.reset();
		satuan_aktifField.reset();
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function satuan_set_form(){
		satuan_kodeField.setValue(satuanListEditorGrid.getSelectionModel().getSelected().get('satuan_kode'));
		satuan_namaField.setValue(satuanListEditorGrid.getSelectionModel().getSelected().get('satuan_nama'));
		satuan_aktifField.setValue(satuanListEditorGrid.getSelectionModel().getSelected().get('satuan_aktif'));
		
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_satuan_form_valid(){
		return (satuan_kodeField.isValid() &&  satuan_namaField.isValid());
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!satuan_createWindow.isVisible()){
			
			satuan_post2db='CREATE';
			msg='created';
			satuan_reset_form();
			
			satuan_createWindow.show();
		} else {
			satuan_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function satuan_confirm_delete(){
		// only one satuan is selected here
		if(satuanListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', satuan_delete);
		} else if(satuanListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', satuan_delete);
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
	function satuan_confirm_update(){
		/* only one record is selected here */
		if(satuanListEditorGrid.selModel.getCount() == 1) {
			
			satuan_post2db='UPDATE';
			msg='updated';
			satuan_set_form();
			
			satuan_createWindow.show();
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
	function satuan_delete(btn){
		if(btn=='yes'){
			var selections = satuanListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< satuanListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.satuan_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_satuan&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							satuan_DataStore.reload();
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
	satuan_DataStore = new Ext.data.Store({
		id: 'satuan_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_satuan&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit:satuan_pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'satuan_id'
		},[
			{name: 'satuan_id', type: 'int', mapping: 'satuan_id'},
			{name: 'satuan_kode', type: 'string', mapping: 'satuan_kode'},
			{name: 'satuan_nama', type: 'string', mapping: 'satuan_nama'},
			{name: 'satuan_aktif', type: 'string', mapping: 'satuan_aktif'},
			{name: 'satuan_creator', type: 'string', mapping: 'satuan_creator'},
			{name: 'satuan_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'satuan_date_create'},
			{name: 'satuan_update', type: 'string', mapping: 'satuan_update'},
			{name: 'satuan_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'satuan_date_update'},
			{name: 'satuan_revised', type: 'int', mapping: 'satuan_revised'}
		]),
		sortInfo:{field: 'satuan_kode', direction: "ASC"}
	});
	/* End of Function */
    
  	/* Function for Identify of Window Column Model */
	satuan_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'satuan_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},
		{
			header: 'Kode',
			dataIndex: 'satuan_kode',
			width: 150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_SATUAN'))){ ?>
			,
			editor: new Ext.form.TextField({
				allowBlank: false,
				maxLength: 50
          	})
			<?php } ?>
		},
		{
			header: 'Nama',
			dataIndex: 'satuan_nama',
			width: 150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_SATUAN'))){ ?>
			,
			editor: new Ext.form.TextArea({
				maxLength: 250
          	})
			<?php } ?>
		},
		{
			header: 'Status',
			dataIndex: 'satuan_aktif',
			width: 150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_SATUAN'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['satuan_aktif_value', 'satuan_aktif_display'],
					data: [['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
					}),
				mode: 'local',
               	displayField: 'satuan_aktif_display',
               	valueField: 'satuan_aktif_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
			<?php } ?>
		},
		{
			header: 'Creator',
			dataIndex: 'satuan_creator',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly:true
		},
		{
			header: 'Create on',
			dataIndex: 'satuan_date_create',
			width: 150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			hidden: true,
			readOnly: true
		},
		{
			header: 'Last Update by',
			dataIndex: 'satuan_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		},
		{
			header: 'Last Update on',
			dataIndex: 'satuan_date_update',
			width: 150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			hidden: true,
			readOnly: true
		},
		{
			header: 'Revised',
			dataIndex: 'satuan_revised',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}]
	);
	satuan_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	satuanListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'satuanListEditorGrid',
		el: 'fp_satuan',
		title: 'Daftar Satuan',
		autoHeight: true,
		store: satuan_DataStore, // DataStore
		cm: satuan_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 700,
		bbar: new Ext.PagingToolbar({
			pageSize: satuan_pageS,
			store: satuan_DataStore,
			displayInfo: true
		}),
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_SATUAN'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<?php } ?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_SATUAN'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: satuan_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_SATUAN'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: satuan_confirm_delete   // Confirm before deleting
		}, '-', 
		<?php } ?>
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: satuan_DataStore,
			params: {task: 'LIST',start: 0, limit: satuan_pageS},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						satuan_DataStore.baseParams={task:'LIST',start: 0, limit: satuan_pageS};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Search By'});
				Ext.get(this.id).set({qtip:'- Kode<br>- Nama'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: satuan_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: satuan_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: satuan_print  
		}
		]
	});
	satuanListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	satuan_ContextMenu = new Ext.menu.Menu({
		id: 'satuan_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_SATUAN'))){ ?>
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: satuan_confirm_update 
		},
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_SATUAN'))){ ?>
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			handler: satuan_confirm_delete 
		},
		<?php } ?>
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: satuan_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: satuan_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onsatuan_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		satuan_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		satuan_SelectedRow=rowIndex;
		satuan_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function satuan_editContextMenu(){
      satuanListEditorGrid.startEditing(satuan_SelectedRow,1);
  	}
	/* End of Function */
  	
	satuanListEditorGrid.addListener('rowcontextmenu', onsatuan_ListEditGridContextMenu);
	satuan_DataStore.load({params: {start: 0, limit: satuan_pageS}});	// load DataStore
	satuanListEditorGrid.on('afteredit', satuan_update); // inLine Editing Record
	
	/* Identify  satuan_kode Field */
	satuan_kodeField= new Ext.form.TextField({
		id: 'satuan_kodeField',
		fieldLabel: 'Nama <span style="color: #ec0000">*</span>',
		maxLength: 10,
		allowBlank: false,
		anchor: '95%'
	});
	/* Identify  satuan_nama Field */
	satuan_namaField= new Ext.form.TextArea({
		id: 'satuan_namaField',
		fieldLabel: 'Keterangan <span style="color: #ec0000">*</span>',
		maxLength: 250,
		allowBlank: false,
		anchor: '95%'
	});
	/* Identify  satuan_aktif Field */
	satuan_aktifField= new Ext.form.ComboBox({
		id: 'satuan_aktifField',
		name: 'satuan_aktifField',
		emptyText : 'Aktif',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['satuan_aktif_value', 'satuan_aktif_display'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		editable:false,
		displayField: 'satuan_aktif_display',
		valueField: 'satuan_aktif_value',
		width: 80,
		triggerAction: 'all'	
	});
	
	/* Function for retrieve create Window Panel*/ 
	satuan_createForm = new Ext.FormPanel({
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
				items: [satuan_kodeField, satuan_namaField, satuan_aktifField] 
			}
			]
		}]
		,
		buttons: [
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_SATUAN'))){ ?>
			{
				text: 'Save and Close',
				handler: satuan_create
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					satuan_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	satuan_createWindow= new Ext.Window({
		id: 'satuan_createWindow',
		title: satuan_post2db+'Satuan',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_satuan_create',
		items: satuan_createForm
	});
	/* End Window */
	
	
	/* Function for action list search */
	function satuan_list_search(){
		// render according to a SQL date format.
		var satuan_id_search=null;
		var satuan_kode_search=null;
		var satuan_nama_search=null;
		var satuan_aktif_search=null;

		if(satuan_idSearchField.getValue()!==null){satuan_id_search=satuan_idSearchField.getValue();}
		if(satuan_kodeSearchField.getValue()!==null){satuan_kode_search=satuan_kodeSearchField.getValue();}
		if(satuan_namaSearchField.getValue()!==null){satuan_nama_search=satuan_namaSearchField.getValue();}
		if(satuan_aktifSearchField.getValue()!==null){satuan_aktif_search=satuan_aktifSearchField.getValue();}
		// change the store parameters
		satuan_DataStore.baseParams = {
			task: 'SEARCH',
			start: 0,
			limit: satuan_pageS,
			satuan_id	:	satuan_id_search, 
			satuan_kode	:	satuan_kode_search, 
			satuan_nama	:	satuan_nama_search, 
			satuan_aktif	:	satuan_aktif_search
	};
		// Cause the datastore to do another query : 
		satuan_DataStore.reload({params: {start: 0, limit: satuan_pageS}});
	}
		
	/* Function for reset search result */
	function satuan_reset_search(){
		// reset the store parameters
		satuan_DataStore.baseParams = { task: 'LIST', start:0, limit:satuan_pageS };
		satuan_DataStore.reload({params: {start: 0, limit: satuan_pageS}});
		//satuan_searchWindow.close();
	};
	/* End of Fuction */
	
	function satuan_reset_SearchForm(){
		satuan_kodeSearchField.reset();
		satuan_namaSearchField.reset();
		satuan_aktifSearchField.reset();
	}
	
	/* Field for search */
	/* Identify  satuan_id Search Field */
	satuan_idSearchField= new Ext.form.NumberField({
		id: 'satuan_idSearchField',
		fieldLabel: 'Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  satuan_kode Search Field */
	satuan_kodeSearchField= new Ext.form.TextField({
		id: 'satuan_kodeSearchField',
		fieldLabel: 'Nama Satuan',
		maxLength: 10,
		anchor: '95%'
	
	});
	/* Identify  satuan_nama Search Field */
	satuan_namaSearchField= new Ext.form.TextArea({
		id: 'satuan_namaSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '95%'
	
	});
	/* Identify  satuan_aktif Search Field */
	satuan_aktifSearchField= new Ext.form.ComboBox({
		id: 'satuan_aktifSearchField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['value', 'satuan_aktif'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		displayField: 'satuan_aktif',
		valueField: 'value',
		width: 80,
		triggerAction: 'all'	 
	
	});
	/* Function for retrieve search Form Panel */
	satuan_searchForm = new Ext.FormPanel({
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
				items: [satuan_kodeSearchField, satuan_namaSearchField, satuan_aktifSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: satuan_list_search
			},{
				text: 'Close',
				handler: function(){
					satuan_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	satuan_searchWindow = new Ext.Window({
		title: 'Pencarian Satuan',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_satuan_search',
		items: satuan_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!satuan_searchWindow.isVisible()){
			satuan_reset_SearchForm();
			satuan_searchWindow.show();
		} else {
			satuan_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function satuan_print(){
		var searchquery = "";
		var satuan_kode_print=null;
		var satuan_nama_print=null;
		var satuan_aktif_print=null;
		var win;              
		// check if we do have some search data...
		if(satuan_DataStore.baseParams.query!==null){searchquery = satuan_DataStore.baseParams.query;}
		if(satuan_DataStore.baseParams.satuan_kode!==null){satuan_kode_print = satuan_DataStore.baseParams.satuan_kode;}
		if(satuan_DataStore.baseParams.satuan_nama!==null){satuan_nama_print = satuan_DataStore.baseParams.satuan_nama;}
		if(satuan_DataStore.baseParams.satuan_aktif!==null){satuan_aktif_print = satuan_DataStore.baseParams.satuan_aktif;}
		

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_satuan&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		
			satuan_kode : satuan_kode_print,
			satuan_nama : satuan_nama_print,
			satuan_aktif : satuan_aktif_print,
		  	currentlisting: satuan_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./satuanlist.html','satuanlist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
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
	function satuan_export_excel(){
		var searchquery = "";
		var satuan_kode_2excel=null;
		var satuan_nama_2excel=null;
		var satuan_aktif_2excel=null;
		var win;              
		// check if we do have some search data...
		if(satuan_DataStore.baseParams.query!==null){searchquery = satuan_DataStore.baseParams.query;}
		if(satuan_DataStore.baseParams.satuan_kode!==null){satuan_kode_2excel = satuan_DataStore.baseParams.satuan_kode;}
		if(satuan_DataStore.baseParams.satuan_nama!==null){satuan_nama_2excel = satuan_DataStore.baseParams.satuan_nama;}
		if(satuan_DataStore.baseParams.satuan_aktif!==null){satuan_aktif_2excel = satuan_DataStore.baseParams.satuan_aktif;}
		

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_satuan&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		
			satuan_kode : satuan_kode_2excel,
			satuan_nama : satuan_nama_2excel,
			satuan_aktif : satuan_aktif_2excel,
		  	currentlisting: satuan_DataStore.baseParams.task // this tells us if we are searching or not
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
        <div id="fp_satuan"></div>
		<div id="elwindow_satuan_create"></div>
        <div id="elwindow_satuan_search"></div>
    </div>
</div>
</body>