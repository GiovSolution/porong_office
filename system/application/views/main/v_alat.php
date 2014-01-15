<?
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: alat View
	+ Description	: For record view
	+ Filename 		: v_alat.php
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
var alat_DataStore;
var alat_ColumnModel;
var alatListEditorGrid;
var alat_createForm;
var alat_createWindow;
var alat_searchForm;
var alat_searchWindow;
var alat_SelectedRow;
var alat_ContextMenu;
//declare konstant
var post2db = '';
var msg = '';
var pageS=15;

/* declare variable here */
var alat_idField;
var alat_namaField;
var alat_jumlahField;
var alat_aktifField;

var alat_idSearchField;
var alat_namaSearchField;
var alat_jumlahSearchField;
var alat_aktifSearchField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  	/* Function for Saving inLine Editing */
	function alat_update(oGrid_event){
	var alat_id_update_pk="";
	var alat_nama_update=null;
	var alat_jumlah_update=null;
	var alat_aktif_update=null;

	alat_id_update_pk = oGrid_event.record.data.alat_id;
	if(oGrid_event.record.data.alat_nama!== null){alat_nama_update = oGrid_event.record.data.alat_nama;}
	if(oGrid_event.record.data.alat_jumlah!== null){alat_jumlah_update = oGrid_event.record.data.alat_jumlah;}
	if(oGrid_event.record.data.alat_aktif!== null){alat_aktif_update = oGrid_event.record.data.alat_aktif;}

	Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_alat&m=get_action',
			params: {
				task: "UPDATE",
				alat_id	: alat_id_update_pk,				
				alat_nama	:alat_nama_update,		
				alat_jumlah	:alat_jumlah_update,		
				alat_aktif	:alat_aktif_update	
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						alat_DataStore.commitChanges();
						alat_DataStore.reload();
						break;
					default:
						Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Data Peralatan Medis tidak bisa disimpan !',
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
	function alat_create(){
		if(is_alat_form_valid()){
		
		var alat_id_create_pk=null;
		var alat_nama_create=null;
		var alat_jumlah_create=null;
		var alat_aktif_create=null;

		alat_id_create_pk=get_pk_id();
		if(alat_namaField.getValue()!== null){alat_nama_create = alat_namaField.getValue();}
		if(alat_jumlahField.getValue()!== null){alat_jumlah_create = alat_jumlahField.getValue();}
		if(alat_aktifField.getValue()!== null){alat_aktif_create = alat_aktifField.getValue();}
	
			Ext.Ajax.request({  
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_alat&m=get_action',
				params: {
					task: post2db,
					alat_id	: alat_id_create_pk,	
					alat_nama	: alat_nama_create,	
					alat_jumlah	: alat_jumlah_create,	
					alat_aktif	: alat_aktif_create
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							Ext.MessageBox.alert(post2db+' OK','Data Peralatan Medis berhasil disimpan.');
							alat_DataStore.reload();
							alat_createWindow.hide();
							break;
						default:
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Data Peralatan Medis tidak bisa disimpan !',
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
			return alatListEditorGrid.getSelectionModel().getSelected().get('alat_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function alat_reset_form(){
		alat_namaField.reset();
		alat_namaField.setValue(null);
		alat_jumlahField.reset();
		alat_jumlahField.setValue(null);
		alat_aktifField.reset();
		alat_aktifField.setValue(null);
		alat_aktifField.setValue('Aktif');
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function alat_set_form(){
		alat_namaField.setValue(alatListEditorGrid.getSelectionModel().getSelected().get('alat_nama'));
		alat_jumlahField.setValue(alatListEditorGrid.getSelectionModel().getSelected().get('alat_jumlah'));
		alat_aktifField.setValue(alatListEditorGrid.getSelectionModel().getSelected().get('alat_aktif'));
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_alat_form_valid(){
		return (alat_namaField.isValid());
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!alat_createWindow.isVisible()){
			
			post2db='CREATE';
			msg='created';
			alat_reset_form();
			alat_createWindow.show();
		} else {
			alat_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function alat_confirm_delete(){
		// only one alat is selected here
		if(alatListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', alat_delete);
		} else if(alatListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', alat_delete);
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
	function alat_confirm_update(){
		/* only one record is selected here */
		if(alatListEditorGrid.selModel.getCount() == 1) {
			
			post2db='UPDATE';
			msg='updated';
			alat_set_form();
			alat_createWindow.show();
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
	function alat_delete(btn){
		if(btn=='yes'){
			var selections = alatListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< alatListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.alat_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_alat&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							alat_DataStore.reload();
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
	alat_DataStore = new Ext.data.Store({
		id: 'alat_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_alat&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit:pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'alat_id'
		},[
			{name: 'alat_id', type: 'int', mapping: 'alat_id'},
			{name: 'alat_nama', type: 'string', mapping: 'alat_nama'},
			{name: 'alat_jumlah', type: 'int', mapping: 'alat_jumlah'},
			{name: 'alat_aktif', type: 'string', mapping: 'alat_aktif'},
			{name: 'alat_creator', type: 'string', mapping: 'alat_creator'},
			{name: 'alat_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'alat_date_create'},
			{name: 'alat_update', type: 'string', mapping: 'alat_update'},
			{name: 'alat_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'alat_date_update'},
			{name: 'alat_revised', type: 'int', mapping: 'alat_revised'}
		]),
		sortInfo:{field: 'alat_id', direction: "ASC"}
	});
	/* End of Function */
    
  	/* Function for Identify of Window Column Model */
	alat_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'alat_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},
		{
			header: 'Nama',
			dataIndex: 'alat_nama',
			width: 150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_ALAT'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 150
          	})
			<?php } ?>
		},
		{
			header: 'Jumlah',
			dataIndex: 'alat_jumlah',
			width: 150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_ALAT'))){ ?>
			,
			editor: new Ext.form.NumberField({
				allowDecimals: false,
				allowNegative: false,
				blankText: '0',
				maxLength: 3,
				maskRe: /([0-9]+)$/
			})
			<?php } ?>
		},
		{
			header: 'Status',
			dataIndex: 'alat_aktif',
			width: 150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_ALAT'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['alat_aktif_value', 'alat_aktif_display'],
					data: [['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
					}),
				mode: 'local',
               	displayField: 'alat_aktif_display',
               	valueField: 'alat_aktif_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
			<?php } ?>
		},
		{
			header: 'Creator',
			dataIndex: 'alat_creator',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		},
		{
			header: 'Create on',
			dataIndex: 'alat_date_create',
			width: 150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			hidden: true,
			readOnly: true
		},
		{
			header: 'Last Update by',
			dataIndex: 'alat_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		},
		{
			header: 'Last Update on',
			dataIndex: 'alat_date_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		},
		{
			header: 'Revised',
			dataIndex: 'alat_revised',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}]
	);
	alat_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	alatListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'alatListEditorGrid',
		el: 'fp_alat',
		title: 'Daftar Peralatan Medis',
		autoHeight: true,
		store: alat_DataStore, // DataStore
		cm: alat_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 700,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: alat_DataStore,
			displayInfo: true
		}),
		
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_ALAT'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<?php } ?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_ALAT'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: alat_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_ALAT'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			disabled:true,
			handler: alat_confirm_delete   // Confirm before deleting
		}, '-', 
		<?php } ?>
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: alat_DataStore,
			params: {task: 'LIST',start: 0, limit: pageS},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						alat_DataStore.baseParams={task:'LIST',start: 0, limit: pageS};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Search By'});
				Ext.get(this.id).set({qtip:'- Nama'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: alat_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: alat_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: alat_print  
		}
		]
	});
	alatListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	alat_ContextMenu = new Ext.menu.Menu({
		id: 'alat_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_ALAT'))){ ?>
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: alat_confirm_update 
		},
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_ALAT'))){ ?>
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			handler: alat_confirm_delete 
		},
		<?php } ?>
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: alat_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: alat_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onalat_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		alat_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		alat_SelectedRow=rowIndex;
		alat_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function alat_editContextMenu(){
      alatListEditorGrid.startEditing(alat_SelectedRow,1);
  	}
	/* End of Function */
  	
	alatListEditorGrid.addListener('rowcontextmenu', onalat_ListEditGridContextMenu);
	alat_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	alatListEditorGrid.on('afteredit', alat_update); // inLine Editing Record
	
	/* Identify  alat_nama Field */
	alat_namaField= new Ext.form.TextField({
		id: 'alat_namaField',
		fieldLabel: 'Nama <span style="color: #ec0000">*</span>',
		maxLength: 150,
		allowBlank: false,
		anchor: '95%'
	});
	/* Identify  alat_jumlah Field */
	alat_jumlahField= new Ext.form.NumberField({
		id: 'alat_jumlahField',
		fieldLabel: 'Jumlah',
		allowNegatife : false,
		emptyText: '0',
		allowDecimals: false,
		allowBlank: true,
		width: 60,
		maskRe: /([0-9]+)$/
	});
	/* Identify  alat_aktif Field */
	alat_aktifField= new Ext.form.ComboBox({
		id: 'alat_aktifField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['alat_aktif_value', 'alat_aktif_display'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		editable:false,
		displayField: 'alat_aktif_display',
		valueField: 'alat_aktif_value',
		emptyText: 'Aktif',
		width: 80,
		triggerAction: 'all'	
	});
	  	
	/* Function for retrieve create Window Panel*/ 
	alat_createForm = new Ext.FormPanel({
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
				items: [alat_namaField, alat_jumlahField, alat_aktifField] 
			}
			]
		}]
		,
		buttons: [
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_ALAT'))){ ?>
			{
				text: 'Save and Close',
				handler: alat_create
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					alat_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	alat_createWindow= new Ext.Window({
		id: 'alat_createWindow',
		title: post2db+'Peralatan Medis',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_alat_create',
		items: alat_createForm
	});
	/* End Window */
	
	
	/* Function for action list search */
	function alat_list_search(){
		// render according to a SQL date format.
		var alat_id_search=null;
		var alat_nama_search=null;
		var alat_jumlah_search=null;
		var alat_aktif_search=null;

		if(alat_idSearchField.getValue()!==null){alat_id_search=alat_idSearchField.getValue();}
		if(alat_namaSearchField.getValue()!==null){alat_nama_search=alat_namaSearchField.getValue();}
		if(alat_jumlahSearchField.getValue()!==null){alat_jumlah_search=alat_jumlahSearchField.getValue();}
		if(alat_aktifSearchField.getValue()!==null){alat_aktif_search=alat_aktifSearchField.getValue();}
		// change the store parameters
		alat_DataStore.baseParams = {
			task: 'SEARCH',
			start: 0,
			limit: pageS,
			alat_id	:	alat_id_search, 
			alat_nama	:	alat_nama_search, 
			alat_jumlah	:	alat_jumlah_search, 
			alat_aktif	:	alat_aktif_search
		};
		// Cause the datastore to do another query : 
		alat_DataStore.reload({params: {start: 0, limit: pageS}});
	}
		
	/* Function for reset search result */
	function alat_reset_search(){
		// reset the store parameters
		alat_DataStore.baseParams = { task: 'LIST', start:0, limit:pageS };
		alat_DataStore.reload({params: {start: 0, limit: pageS}});
		//alat_searchWindow.close();
	};
	/* End of Fuction */
	
	function alat_reset_SearchForm(){
		alat_namaSearchField.reset();
		alat_namaSearchField.setValue(null);
		alat_jumlahSearchField.reset();
		alat_jumlahSearchField.setValue(null);
		alat_aktifSearchField.reset();
		alat_aktifSearchField.setValue(null);
	}
	
	/* Field for search */
	/* Identify  alat_id Search Field */
	alat_idSearchField= new Ext.form.NumberField({
		id: 'alat_idSearchField',
		fieldLabel: 'Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  alat_nama Search Field */
	alat_namaSearchField= new Ext.form.TextField({
		id: 'alat_namaSearchField',
		fieldLabel: 'Nama Alat',
		maxLength: 150,
		anchor: '95%'
	
	});
	/* Identify  alat_jumlah Search Field */
	alat_jumlahSearchField= new Ext.form.NumberField({
		id: 'alat_jumlahSearchField',
		fieldLabel: 'Jumlah',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		width: 60,
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  alat_aktif Search Field */
	alat_aktifSearchField= new Ext.form.ComboBox({
		id: 'alat_aktifSearchField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['value', 'alat_aktif'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		displayField: 'alat_aktif',
		valueField: 'value',
		emptyText: 'Aktif',
		width: 80,
		triggerAction: 'all'	 
	
	});
	
    
	/* Function for retrieve search Form Panel */
	alat_searchForm = new Ext.FormPanel({
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
				items: [alat_namaSearchField, alat_jumlahSearchField, alat_aktifSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: alat_list_search
			},{
				text: 'Close',
				handler: function(){
					alat_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	alat_searchWindow = new Ext.Window({
		title: 'Pencarian Peralatan Medis',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_alat_search',
		items: alat_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!alat_searchWindow.isVisible()){
			alat_reset_SearchForm();
			alat_searchWindow.show();
		} else {
			alat_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function alat_print(){
		var searchquery = "";
		var alat_nama_print=null;
		var alat_jumlah_print=null;
		var alat_aktif_print=null;
		var win;              
		// check if we do have some search data...
		if(alat_DataStore.baseParams.query!==null){searchquery = alat_DataStore.baseParams.query;}
		if(alat_DataStore.baseParams.alat_nama!==null){alat_nama_print = alat_DataStore.baseParams.alat_nama;}
		if(alat_DataStore.baseParams.alat_jumlah!==null){alat_jumlah_print = alat_DataStore.baseParams.alat_jumlah;}
		if(alat_DataStore.baseParams.alat_aktif!==null){alat_aktif_print = alat_DataStore.baseParams.alat_aktif;}
		

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_alat&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		
			alat_nama : alat_nama_print,
			alat_jumlah : alat_jumlah_print,
			alat_aktif : alat_aktif_print,
		  	currentlisting: alat_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./alatlist.html','alatlist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
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
	function alat_export_excel(){
		var searchquery = "";
		var alat_nama_2excel=null;
		var alat_jumlah_2excel=null;
		var alat_aktif_2excel=null;
		var win;              
		// check if we do have some search data...
		if(alat_DataStore.baseParams.query!==null){searchquery = alat_DataStore.baseParams.query;}
		if(alat_DataStore.baseParams.alat_nama!==null){alat_nama_2excel = alat_DataStore.baseParams.alat_nama;}
		if(alat_DataStore.baseParams.alat_jumlah!==null){alat_jumlah_2excel = alat_DataStore.baseParams.alat_jumlah;}
		if(alat_DataStore.baseParams.alat_aktif!==null){alat_aktif_2excel = alat_DataStore.baseParams.alat_aktif;}
		
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_alat&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		
			alat_nama : alat_nama_2excel,
			alat_jumlah : alat_jumlah_2excel,
			alat_aktif : alat_aktif_2excel,
		  	currentlisting: alat_DataStore.baseParams.task // this tells us if we are searching or not
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
        <div id="fp_alat"></div>
		<div id="elwindow_alat_create"></div>
        <div id="elwindow_alat_search"></div>
    </div>
</div>
</body>