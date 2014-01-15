<?
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: kategori2 View
	+ Description	: For record view
	+ Filename 		: v_kategori2.php
 	+ Author  		: 
 	+ Created on 22/Oct/2009 16:24:37
	
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
var kategori2_DataStore;
var kategori2_ColumnModel;
var kategori2ListEditorGrid;
var kategori2_createForm;
var kategori2_createWindow;
var kategori2_searchForm;
var kategori2_searchWindow;
var kategori2_SelectedRow;
var kategori2_ContextMenu;


//declare konstant
var post2db = '';
var msg = '';
var pageS=15;

/* declare variable here for Field*/
var kategori2_idField;
var kategori2_namaField;
var kategori2_jenisField;
var kategori2_keteranganField;
var kategori2_aktifField;
var kategori2_idSearchField;
var kategori2_namaSearchField;
var kategori2_jenisSearchField;
var kategori2_keteranganSearchField;
var kategori2_aktifSearchField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */

  	Ext.util.Format.comboRenderer = function(combo){
  		kategori2_jenisDataStore.load();
  	    return function(value){
  	        var record = combo.findRecord(combo.valueField, value);
  	        return record ? record.get(combo.displayField) : combo.valueNotFoundText;
  	    }
  	}
  
  	/* Function for Saving inLine Editing */
	function kategori2_update(oGrid_event){
		var kategori2_id_update_pk="";
		var kategori2_nama_update=null;
		var kategori2_jenis_update=null;
		var kategori2_keterangan_update=null;
		var kategori2_aktif_update=null;

		kategori2_id_update_pk = oGrid_event.record.data.kategori2_id;
		if(oGrid_event.record.data.kategori2_nama!== null){kategori2_nama_update = oGrid_event.record.data.kategori2_nama;}
		if(oGrid_event.record.data.kategori2_jenis!== null){kategori2_jenis_update = oGrid_event.record.data.kategori2_jenis;}
		if(oGrid_event.record.data.kategori2_keterangan!== null){kategori2_keterangan_update = oGrid_event.record.data.kategori2_keterangan;}
		if(oGrid_event.record.data.kategori2_aktif!== null){kategori2_aktif_update = oGrid_event.record.data.kategori2_aktif;}

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_kategori2&m=get_action',
			params: {
				task: "UPDATE",
				kategori2_id	: kategori2_id_update_pk, 
				kategori2_nama	:kategori2_nama_update,  
				kategori2_jenis	:kategori2_jenis_update,  
				kategori2_keterangan	:kategori2_keterangan_update,  
				kategori2_aktif	:kategori2_aktif_update,  
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						kategori2_DataStore.commitChanges();
						kategori2_DataStore.reload();
						break;
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Data Contribution Category tidak bisa disimpan.',
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
	function kategori2_create(){
	
		if(is_kategori2_form_valid()){	
		var kategori2_id_create_pk=null; 
		var kategori2_nama_create=null; 
		var kategori2_jenis_create=null; 
		var kategori2_keterangan_create=null; 
		var kategori2_aktif_create=null; 

		if(kategori2_idField.getValue()!== null){kategori2_id_create_pk = kategori2_idField.getValue();}else{kategori2_id_create_pk=get_pk_id();} 
		if(kategori2_namaField.getValue()!== null){kategori2_nama_create = kategori2_namaField.getValue();} 
		if(kategori2_jenisField.getValue()!== null){kategori2_jenis_create = kategori2_jenisField.getValue();} 
		if(kategori2_keteranganField.getValue()!== null){kategori2_keterangan_create = kategori2_keteranganField.getValue();} 
		if(kategori2_aktifField.getValue()!== null){kategori2_aktif_create = kategori2_aktifField.getValue();} 

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_kategori2&m=get_action',
			params: {
				task: post2db,
				kategori2_id	: kategori2_id_create_pk, 
				kategori2_nama	: kategori2_nama_create, 
				kategori2_jenis	: kategori2_jenis_create, 
				kategori2_keterangan	: kategori2_keterangan_create, 
				kategori2_aktif	: kategori2_aktif_create, 
			}, 
			success: function(response){             
				var result=eval(response.responseText);
				switch(result){
					case 1:
						Ext.MessageBox.alert(post2db+' OK','Data Contribution Category berhasil disimpan.');
						kategori2_DataStore.reload();
						kategori2_createWindow.hide();
						break;
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Data Contribution Category tidak bisa disimpan !',
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
			return kategori2ListEditorGrid.getSelectionModel().getSelected().get('kategori2_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function kategori2_reset_form(){
		kategori2_idField.reset();
		kategori2_idField.setValue(null);
		kategori2_namaField.reset();
		kategori2_namaField.setValue(null);
		kategori2_jenisField.reset();
		kategori2_jenisField.setValue(null);
		kategori2_keteranganField.reset();
		kategori2_keteranganField.setValue(null);
		kategori2_aktifField.reset();
		kategori2_aktifField.setValue(null);
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function kategori2_set_form(){
		kategori2_idField.setValue(kategori2ListEditorGrid.getSelectionModel().getSelected().get('kategori2_id'));
		kategori2_namaField.setValue(kategori2ListEditorGrid.getSelectionModel().getSelected().get('kategori2_nama'));
		kategori2_jenisField.setValue(kategori2ListEditorGrid.getSelectionModel().getSelected().get('kategori2_jenis'));
		kategori2_keteranganField.setValue(kategori2ListEditorGrid.getSelectionModel().getSelected().get('kategori2_keterangan'));
		kategori2_aktifField.setValue(kategori2ListEditorGrid.getSelectionModel().getSelected().get('kategori2_aktif'));
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_kategori2_form_valid(){
		return (true );
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!kategori2_createWindow.isVisible()){
			kategori2_reset_form();
			post2db='CREATE';
			msg='created';
			kategori2_createWindow.show();
		} else {
			kategori2_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function kategori2_confirm_delete(){
		// only one kategori2 is selected here
		if(kategori2ListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', kategori2_delete);
		} else if(kategori2ListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', kategori2_delete);
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
	function kategori2_confirm_update(){
		/* only one record is selected here */
		if(kategori2ListEditorGrid.selModel.getCount() == 1) {
			kategori2_set_form();
			post2db='UPDATE';
			msg='updated';
			kategori2_createWindow.show();
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
	function kategori2_delete(btn){
		if(btn=='yes'){
			var selections = kategori2ListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< kategori2ListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.kategori2_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_kategori2&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							kategori2_DataStore.reload();
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
  
	/* Function for Retrieve DataStoree */
	kategori2_DataStore = new Ext.data.Store({
		id: 'kategori2_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_kategori2&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit:pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'kategori2_id'
		},[
			{name: 'kategori2_id', type: 'int', mapping: 'kategori2_id'}, 
			{name: 'kategori2_nama', type: 'string', mapping: 'kategori2_nama'}, 
			{name: 'kategori2_jenis', type: 'string', mapping: 'kategori_nama'}, 
			{name: 'kategori2_keterangan', type: 'string', mapping: 'kategori2_keterangan'}, 
			{name: 'kategori2_aktif', type: 'string', mapping: 'kategori2_aktif'}, 
			{name: 'kategori2_creator', type: 'string', mapping: 'kategori2_creator'}, 
			{name: 'kategori2_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'kategori2_date_create'}, 
			{name: 'kategori2_update', type: 'string', mapping: 'kategori2_update'}, 
			{name: 'kategori2_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'kategori2_date_update'}, 
			{name: 'kategori2_revised', type: 'int', mapping: 'kategori2_revised'} 
		]),
		sortInfo:{field: 'kategori2_id', direction: "DESC"}
	});
	/* End of Function */
	
	kategori2_jenisDataStore = new Ext.data.Store({
		id: 'kategori2_jenisDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_kategori2&m=get_kategori_list', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'kategori_id'
		},[
		/* dataIndex => insert intokategori2_ColumnModel, Mapping => for initiate table column */ 
			{name: 'kategori_id', type: 'int', mapping: 'kategori_id'}, 
			{name: 'kategori_nama', type: 'string', mapping: 'kategori_nama'}
		]),
		sortInfo:{field: 'kategori_id', direction: "DESC"}
	});
    
  	/* Function for Identify of Window Column Model */
	kategori2_ColumnModel = new Ext.grid.ColumnModel(
		[/*{
			header: '#',
			readOnly: true,
			dataIndex: 'kategori2_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: false
		},*/
		{
			header: 'Nama',
			dataIndex: 'kategori2_nama',
			width: 150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_CONTCAT'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
			<?php } ?>
		}, 
		{
			header: 'Jenis',
			dataIndex: 'kategori2_jenis',
			width: 100,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_CONTCAT'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				id: 'kategori2_jenisField',
				fieldLabel: 'Jenis',
				store: kategori2_jenisDataStore,
				mode: 'remote',
				editable: false,
				displayField: 'kategori_nama',
				valueField: 'kategori_id',
				anchor: '95%',
				triggerAction: 'all'	
			})
			<?php } ?>
		}, 
		{
			header: 'Keterangan',
			dataIndex: 'kategori2_keterangan',
			width: 350,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_CONTCAT'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
			<?php } ?>
		}, 
		{
			header: 'Aktif',
			dataIndex: 'kategori2_aktif',
			width: 100,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_CONTCAT'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['kategori2_aktif_value', 'kategori2_aktif_display'],
					data: [['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
					}),
				mode: 'local',
               	displayField: 'kategori2_aktif_display',
               	valueField: 'kategori2_aktif_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
			<?php } ?>
		}, 
		{
			header: 'Creator',
			dataIndex: 'kategori2_creator',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}, 
		{
			header: 'Create on',
			dataIndex: 'kategori2_date_create',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}, 
		{
			header: 'Last Update By',
			dataIndex: 'kategori2_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}, 
		{
			header: 'Last Update on',
			dataIndex: 'kategori2_date_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}, 
		{
			header: 'Revised',
			dataIndex: 'kategori2_revised',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}	]);
	
	kategori2_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStoree and  show datagrid list */
	kategori2ListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'kategori2ListEditorGrid',
		el: 'fp_kategori2',
		title: 'Contribution Category',
		autoHeight: true,
		store: kategori2_DataStore, // DataStoree
		cm: kategori2_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 780,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: kategori2_DataStore,
			displayInfo: true
		}),
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_CONTCAT'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<?php } ?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_CONTCAT'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: kategori2_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_CONTCAT'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: kategori2_confirm_delete   // Confirm before deleting
		}, '-',
		<?php } ?>
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: kategori2_DataStore,
			params: {task: 'LIST',start: 0, limit: pageS},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						kategori2_DataStore.baseParams={task:'LIST',start: 0, limit: pageS};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Search By'});
				Ext.get(this.id).set({qtip:'- Nama<br>- Jenis<br>- Keterangan'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: kategori2_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: kategori2_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: kategori2_print  
		}
		]
	});
	kategori2ListEditorGrid.render();
	/* End of DataStoree */
     
	/* Create Context Menu */
	kategori2_ContextMenu = new Ext.menu.Menu({
		id: 'kategori2_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_CONTCAT'))){ ?>
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: kategori2_confirm_update
		},
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_CONTCAT'))){ ?>
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			handler: kategori2_confirm_delete 
		},
		<?php } ?>
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: kategori2_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: kategori2_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onkategori2_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		kategori2_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		kategori2_SelectedRow=rowIndex;
		kategori2_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function kategori2_editContextMenu(){
		kategori2ListEditorGrid.startEditing(kategori2_SelectedRow,1);
  	}
	/* End of Function */
  	
	kategori2ListEditorGrid.addListener('rowcontextmenu', onkategori2_ListEditGridContextMenu);
	kategori2_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStoree
	kategori2ListEditorGrid.on('afteredit', kategori2_update); // inLine Editing Record
	
	/* Identify  kategori2_id Field */
	kategori2_idField= new Ext.form.NumberField({
		id: 'kategori2_idField',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: false,
				hidden: true,
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  kategori2_nama Field */
	kategori2_namaField= new Ext.form.TextField({
		id: 'kategori2_namaField',
		fieldLabel: 'Nama',
		maxLength: 250,
		anchor: '95%'
	});
	/* Identify  kategori2_jenis Field */
	kategori2_jenisField= new Ext.form.ComboBox({
		id: 'kategori2_jenisField',
		fieldLabel: 'Jenis',
		store: kategori2_jenisDataStore,
		mode: 'remote',
		editable: false,
		displayField: 'kategori_nama',
		valueField: 'kategori_id',
		anchor: '95%',
		triggerAction: 'all'	
	});
	/* Identify  kategori2_keterangan Field */
	kategori2_keteranganField= new Ext.form.TextArea({
		id: 'kategori2_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '95%'
	});
	/* Identify  kategori2_aktif Field */
	kategori2_aktifField= new Ext.form.ComboBox({
		id: 'kategori2_aktifField',
		fieldLabel: 'Aktif',
		store:new Ext.data.SimpleStore({
			fields:['kategori2_aktif_value', 'kategori2_aktif_display'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		editable: false,
		emptyText: 'Aktif',
		displayField: 'kategori2_aktif_display',
		valueField: 'kategori2_aktif_value',
		width: 80,
		triggerAction: 'all'	
	});

	
	/* Function for retrieve create Window Panel*/ 
	kategori2_createForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 300,        
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [kategori2_namaField, kategori2_jenisField, kategori2_keteranganField, kategori2_aktifField] 
			}
			],
		buttons: [
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_CONTCAT'))){ ?>
			{
				text: 'Save and Close',
				handler: kategori2_create
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					kategori2_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	kategori2_createWindow= new Ext.Window({
		id: 'kategori2_createWindow',
		title: post2db+'Contribution Category',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_kategori2_create',
		items: kategori2_createForm
	});
	/* End Window */
	
	/* Function for action list search */
	function kategori2_list_search(){
		// render according to a SQL date format.
		var kategori2_id_search=null;
		var kategori2_nama_search=null;
		var kategori2_jenis_search=null;
		var kategori2_keterangan_search=null;
		var kategori2_aktif_search=null;

		if(kategori2_idSearchField.getValue()!==null){kategori2_id_search=kategori2_idSearchField.getValue();}
		if(kategori2_namaSearchField.getValue()!==null){kategori2_nama_search=kategori2_namaSearchField.getValue();}
		if(kategori2_jenisSearchField.getValue()!==null){kategori2_jenis_search=kategori2_jenisSearchField.getValue();}
		if(kategori2_keteranganSearchField.getValue()!==null){kategori2_keterangan_search=kategori2_keteranganSearchField.getValue();}
		if(kategori2_aktifSearchField.getValue()!==null){kategori2_aktif_search=kategori2_aktifSearchField.getValue();}
		// change the store parameters
		kategori2_DataStore.baseParams = {
			task: 'SEARCH',
			start: 0,
			limit: pageS,
			//variable here
			kategori2_id	:	kategori2_id_search, 
			kategori2_nama	:	kategori2_nama_search, 
			kategori2_jenis	:	kategori2_jenis_search, 
			kategori2_keterangan	:	kategori2_keterangan_search, 
			kategori2_aktif	:	kategori2_aktif_search, 
		};
		// Cause the DataStoree to do another query : 
		kategori2_DataStore.reload({params: {start: 0, limit: pageS}});
	}
		
	/* Function for reset search result */
	function kategori2_reset_search(){
		// reset the store parameters
		kategori2_DataStore.baseParams = { task: 'LIST', start:0, limit:pageS };
		// Cause the DataStoree to do another query : 
		kategori2_DataStore.reload({params: {start: 0, limit: pageS}});
		kategori2_searchWindow.close();
	};
	/* End of Fuction */
	
	/* Field for search */
	/* Identify  kategori2_id Field */
	kategori2_idSearchField= new Ext.form.NumberField({
		id: 'kategori2_idSearchField',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: false,
				hidden: true,
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  kategori2_nama Field */
	kategori2_namaSearchField= new Ext.form.TextField({
		id: 'kategori2_namaSearchField',
		fieldLabel: 'Nama',
		maxLength: 250,
		anchor: '95%'
	});
	/* Identify  kategori2_jenis Field */
	kategori2_jenisSearchField= new Ext.form.ComboBox({
		id: 'kategori2_jenisSearchField',
		fieldLabel: 'Jenis',
		store: kategori2_jenisDataStore,
		mode: 'remote',
		editable: false,
		displayField: 'kategori_nama',
		valueField: 'kategori_id',
		anchor: '95%',
		triggerAction: 'all'	
	});
	/* Identify  kategori2_keterangan Field */
	kategori2_keteranganSearchField= new Ext.form.TextArea({
		id: 'kategori2_keteranganSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '95%'
	});
	/* Identify  kategori2_aktif Field */
	kategori2_aktifSearchField= new Ext.form.ComboBox({
		id: 'kategori2_aktifSearchField',
		fieldLabel: 'Aktif',
		store:new Ext.data.SimpleStore({
			fields:['kategori2_aktif_value', 'kategori2_aktif_display'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		editable: false,
		emptyText: 'Aktif',
		displayField: 'kategori2_aktif_display',
		valueField: 'kategori2_aktif_value',
		width: 80,
		triggerAction: 'all'	
	});
    
	/* Function for retrieve search Form Panel */
	kategori2_searchForm = new Ext.FormPanel({
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
				items: [kategori2_namaSearchField, kategori2_jenisSearchField, kategori2_keteranganSearchField, kategori2_aktifSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: kategori2_list_search
			},{
				text: 'Close',
				handler: function(){
					kategori2_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	
	function kategori2_reset_SearchForm(){
		kategori2_namaSearchField.reset();
		kategori2_namaSearchField.setValue(null);
		kategori2_jenisSearchField.reset();
		kategori2_jenisSearchField.setValue(null);
		kategori2_keteranganSearchField.reset();
		kategori2_keteranganSearchField.setValue(null);
		kategori2_aktifSearchField.reset();
		kategori2_aktifSearchField.setValue(null);
	}
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	kategori2_searchWindow = new Ext.Window({
		title: 'Pencarian Contribution Category',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_kategori2_search',
		items: kategori2_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!kategori2_searchWindow.isVisible()){
			kategori2_reset_SearchForm();
			kategori2_searchWindow.show();
		} else {
			kategori2_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function kategori2_print(){
		var searchquery = "";
		var kategori2_nama_print=null;
		var kategori2_jenis_print=null;
		var kategori2_keterangan_print=null;
		var kategori2_aktif_print=null;
		var win;              
		// check if we do have some search data...
		if(kategori2_DataStore.baseParams.query!==null){searchquery = kategori2_DataStore.baseParams.query;}
		if(kategori2_DataStore.baseParams.kategori2_nama!==null){kategori2_nama_print = kategori2_DataStore.baseParams.kategori2_nama;}
		if(kategori2_DataStore.baseParams.kategori2_jenis!==null){kategori2_jenis_print = kategori2_DataStore.baseParams.kategori2_jenis;}
		if(kategori2_DataStore.baseParams.kategori2_keterangan!==null){kategori2_keterangan_print = kategori2_DataStore.baseParams.kategori2_keterangan;}
		if(kategori2_DataStore.baseParams.kategori2_aktif!==null){kategori2_aktif_print = kategori2_DataStore.baseParams.kategori2_aktif;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_kategori2&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			kategori2_nama : kategori2_nama_print,
			kategori2_jenis : kategori2_jenis_print,
			kategori2_keterangan : kategori2_keterangan_print,
			kategori2_aktif : kategori2_aktif_print,
		  	currentlisting: kategori2_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./kategori2list.html','kategori2list','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
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
	function kategori2_export_excel(){
		var searchquery = "";
		var kategori2_nama_2excel=null;
		var kategori2_jenis_2excel=null;
		var kategori2_keterangan_2excel=null;
		var kategori2_aktif_2excel=null;
		var win;              
		// check if we do have some search data...
		if(kategori2_DataStore.baseParams.query!==null){searchquery = kategori2_DataStore.baseParams.query;}
		if(kategori2_DataStore.baseParams.kategori2_nama!==null){kategori2_nama_2excel = kategori2_DataStore.baseParams.kategori2_nama;}
		if(kategori2_DataStore.baseParams.kategori2_jenis!==null){kategori2_jenis_2excel = kategori2_DataStore.baseParams.kategori2_jenis;}
		if(kategori2_DataStore.baseParams.kategori2_keterangan!==null){kategori2_keterangan_2excel = kategori2_DataStore.baseParams.kategori2_keterangan;}
		if(kategori2_DataStore.baseParams.kategori2_aktif!==null){kategori2_aktif_2excel = kategori2_DataStore.baseParams.kategori2_aktif;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_kategori2&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			kategori2_nama : kategori2_nama_2excel,
			kategori2_jenis : kategori2_jenis_2excel,
			kategori2_keterangan : kategori2_keterangan_2excel,
			kategori2_aktif : kategori2_aktif_2excel,
		  	currentlisting: kategori2_DataStore.baseParams.task // this tells us if we are searching or not
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
        <div id="fp_kategori2"></div>
		<div id="elwindow_kategori2_create"></div>
        <div id="elwindow_kategori2_search"></div>
    </div>
</div>
</body>