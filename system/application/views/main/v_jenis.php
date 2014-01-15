<?
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#GIOV SOLUTION
	
	+ Module  		: jenis View
	+ Description	: For record view
	+ Filename 		: v_jenis.php
 	+ Author  		: Isaac & Freddy
	
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
var jenis_DataStore;
var jenis_ColumnModel;
var jenisListEditorGrid;
var jenis_createForm;
var jenis_createWindow;
var jenis_searchForm;
var jenis_searchWindow;
var jenis_SelectedRow;
var jenis_ContextMenu;
//declare konstant
var post2db_jenis = '';
var msg = '';
var pageS_jenis=15;

/* declare variable here */
var jenis_idField;
var jenis_namaField;
var jenis_jenisField;
var jenis_keteranganField;
var jenis_aktifField;
var jenis_creatorField;
var jenis_date_createField;
var jenis_updateField;
var jenis_date_updateField;
var jenis_revisedField;
var jenis_idSearchField;
var jenis_namaSearchField;
var jenis_jenisSearchField;
var jenis_keteranganSearchField;
var jenis_aktifSearchField;


/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  	/* Function for Saving inLine Editing */
	function jenis_update(oGrid_event){
	var jenis_id_update_pk="";
	var jenis_nama_update=null;
	var jenis_jenis_update=null;
	var jenis_keterangan_update=null;
	var jenis_aktif_update=null;


	jenis_id_update_pk = oGrid_event.record.data.jenis_id;
	if(oGrid_event.record.data.jenis_nama!== null){jenis_nama_update = oGrid_event.record.data.jenis_nama;}
	if(oGrid_event.record.data.jenis_jenis!== null){jenis_jenis_update = oGrid_event.record.data.jenis_jenis;}
	if(oGrid_event.record.data.jenis_keterangan!== null){jenis_keterangan_update = oGrid_event.record.data.jenis_keterangan;}
	if(oGrid_event.record.data.jenis_aktif!== null){jenis_aktif_update = oGrid_event.record.data.jenis_aktif;}

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_jenis&m=get_action',
			params: {
				task: "UPDATE",
				jenis_id			: jenis_id_update_pk,				
				jenis_nama			: jenis_nama_update,		
				jenis_jenis			: jenis_jenis_update,		
				jenis_keterangan	: jenis_keterangan_update,		
				jenis_aktif			: jenis_aktif_update			
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						jenis_DataStore.commitChanges();
						jenis_DataStore.reload();
						break;
					default:
						Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Data Jenis tidak bisa disimpan.',
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
	function jenis_create(){
		if(is_jenis_form_valid()){
		
		var jenis_id_create_pk=null;
		var jenis_nama_create=null;
		var jenis_jenis_create=null;
		var jenis_keterangan_create=null;
		var jenis_aktif_create=null;


		jenis_id_create_pk=get_pk_id();
		if(jenis_namaField.getValue()!== null){jenis_nama_create = jenis_namaField.getValue();}
		if(jenis_jenisField.getValue()!== null){jenis_jenis_create = jenis_jenisField.getValue();}
		if(jenis_keteranganField.getValue()!== null){jenis_keterangan_create = jenis_keteranganField.getValue();}
		if(jenis_aktifField.getValue()!== null){jenis_aktif_create = jenis_aktifField.getValue();}

			Ext.Ajax.request({  
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_jenis&m=get_action',
				params: {
					task: post2db_jenis,
					jenis_id			: jenis_id_create_pk,	
					jenis_nama			: jenis_nama_create,	
					jenis_jenis			: jenis_jenis_create,	
					jenis_keterangan	: jenis_keterangan_create,	
					jenis_aktif			: jenis_aktif_create
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							Ext.MessageBox.alert(post2db_jenis+' OK','Data Jenis berhasil disimpan.');
							jenis_DataStore.reload();
							jenis_createWindow.hide();
							break;
						default:
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Data Jenis tidak bisa disimpan !',
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
				msg: 'Isian belum sempurna !.',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
 	/* End of Function */
  
  	/* Function for get PK field */
	function get_pk_id(){
		if(post2db_jenis=='UPDATE')
			return jenisListEditorGrid.getSelectionModel().getSelected().get('jenis_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function jenis_reset_form(){
		jenis_namaField.reset();
		jenis_jenisField.reset();
		jenis_keteranganField.reset();
		jenis_aktifField.reset();
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function jenis_set_form(){
		jenis_namaField.setValue(jenisListEditorGrid.getSelectionModel().getSelected().get('jenis_nama'));
		jenis_jenisField.setValue(jenisListEditorGrid.getSelectionModel().getSelected().get('jenis_jenis'));
		jenis_keteranganField.setValue(jenisListEditorGrid.getSelectionModel().getSelected().get('jenis_keterangan'));
		jenis_aktifField.setValue(jenisListEditorGrid.getSelectionModel().getSelected().get('jenis_aktif'));
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_jenis_form_valid(){
		return (jenis_namaField.isValid() );
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!jenis_createWindow.isVisible()){
			jenis_reset_form();
			post2db_jenis='CREATE';
			msg='created';
			jenis_createWindow.show();
		} else {
			jenis_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function jenis_confirm_delete(){
		// only one kategori is selected here
		if(jenisListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', jenis_delete);
		} else if(jenisListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', jenis_delete);
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
	function jenis_confirm_update(){
		/* only one record is selected here */
		if(jenisListEditorGrid.selModel.getCount() == 1) {
			jenis_set_form();
			post2db_jenis='UPDATE';
			msg='updated';
			jenis_createWindow.show();
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
	function jenis_delete(btn){
		if(btn=='yes'){
			var selections = jenisListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< jenisListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.jenis_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_jenis&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							jenis_DataStore.reload();
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
	jenis_DataStore = new Ext.data.Store({
		id: 'jenis_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_jenis&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit:pageS_jenis}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'jenis_id'
		},[
			{name: 'jenis_id', type: 'int', mapping: 'jenis_id'},
			{name: 'jenis_nama', type: 'string', mapping: 'jenis_nama'},
			{name: 'jenis_jenis', type: 'string', mapping: 'jenis_jenis'},
			{name: 'jenis_keterangan', type: 'string', mapping: 'jenis_keterangan'},
			{name: 'jenis_aktif', type: 'string', mapping: 'jenis_aktif'},
			{name: 'jenis_creator', type: 'string', mapping: 'jenis_creator'},
			{name: 'jenis_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'jenis_date_create'},
			{name: 'jenis_update', type: 'string', mapping: 'jenis_update'},
			{name: 'jenis_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'jenis_date_update'},
			{name: 'jenis_revised', type: 'int', mapping: 'jenis_revised'}
		]),
		sortInfo:{field: 'jenis_id', direction: "ASC"}
	});
	/* End of Function */
    
  	/* Function for Identify of Window Column Model */
	jenis_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'jenis_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},
		{
			header: 'Nama',
			dataIndex: 'jenis_nama',
			width: 150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_JENIS'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
			<?php } ?>
		},
		/*
		{
			header: 'Kelompok',
			dataIndex: 'jenis_jenis',
			width: 150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_JENIS'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['jenis_jenis_value', 'jenis_jenis_display'],
					data: [['produk','Produk'],['perawatan','Perawatan'],['paket','Paket']]
					}),
				mode: 'local',
               	displayField: 'jenis_jenis_display',
               	valueField: 'jenis_jenis_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small',
				anchor: '60%'
            })
			<?php } ?>
		},
		*/
		{
			header: 'Keterangan',
			dataIndex: 'jenis_keterangan',
			width: 150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_JENIS'))){ ?>
			,
			editor: new Ext.form.TextArea({
				height: 30						  
			})
			<?php } ?>
		},
		{
			header: 'Status',
			dataIndex: 'jenis_aktif',
			width: 150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_JENIS'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['jenis_aktif_value', 'jenis_aktif_display'],
					data: [['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
					}),
				mode: 'local',
               	displayField: 'jenis_aktif_display',
               	valueField: 'jenis_aktif_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small',
				anchor: '30%'
            })
			<?php } ?>
		},
		{
			header: 'Creator',
			dataIndex: 'jenis_creator',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		},
		{
			header: 'Create on',
			dataIndex: 'jenis_date_create',
			width: 150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			hidden: true,
			readOnly: true
		},
		{
			header: 'Last Update By',
			dataIndex: 'jenis_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		},
		{
			header: 'Last Update on',
			dataIndex: 'jenis_date_update',
			width: 150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			hidden: true,
			readOnly: true
		},
		{
			header: 'Revised',
			dataIndex: 'jenis_revised',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}]
	);
	jenis_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	jenisListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'jenisListEditorGrid',
		el: 'fp_jenis',
		title: 'Daftar Jenis',
		autoHeight: true,
		store: jenis_DataStore, // DataStore
		cm: jenis_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 700,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS_jenis,
			store: jenis_DataStore,
			displayInfo: true
		}),
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_JENIS'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<?php } ?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_JENIS'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: jenis_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_JENIS'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: jenis_confirm_delete   // Confirm before deleting
		}, '-', 
		<?php } ?>
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: jenis_DataStore,
			params: {task: 'LIST',start: 0, limit: pageS_jenis},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						jenis_DataStore.baseParams={task:'LIST',start: 0, limit: pageS_jenis};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Search By'});
				Ext.get(this.id).set({qtip:'- Nama Jenis<br>- Nama Kelompok'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: jenis_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: jenis_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: jenis_print  
		}
		]
	});
	jenisListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	jenis_ContextMenu = new Ext.menu.Menu({
		id: 'kategori_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_JENIS'))){ ?>
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: jenis_confirm_update 
		},
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_JENIS'))){ ?>
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			handler: jenis_confirm_delete 
		},
		<?php } ?>
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: jenis_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: jenis_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onjenis_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		jenis_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		jenis_SelectedRow=rowIndex;
		jenis_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function jenis_editContextMenu(){
      jenisListEditorGrid.startEditing(jenis_SelectedRow,1);
  	}
	/* End of Function */
  	
	jenisListEditorGrid.addListener('rowcontextmenu', onjenis_ListEditGridContextMenu);
	jenis_DataStore.load({params: {start: 0, limit: pageS_jenis}});	// load DataStore
	jenisListEditorGrid.on('afteredit', jenis_update); // inLine Editing Record
	
	/* Identify  jenis_nama Field */
	jenis_namaField= new Ext.form.TextField({
		id: 'jenis_namaField',
		fieldLabel: 'Nama <span style="color: #ec0000">*</span>',
		maxLength: 250,
		allowBlank: false,
		anchor: '95%'
	});
	/* Identify  jenis_jenis Field */
	jenis_jenisField= new Ext.form.ComboBox({
		id: 'jenis_jenisField',
		fieldLabel: 'Kelompok <span style="color: #ec0000">*</span>',
		store:new Ext.data.SimpleStore({
			fields:['jenis_jenis_value', 'jenis_jenis_display'],
			data:[['produk','Produk'],['perawatan','Perawatan'],['paket','Paket']]
		}),
		mode: 'local',
		allowBlank: false,
		editable: false,
		displayField: 'jenis_jenis_display',
		valueField: 'jenis_jenis_value',
		anchor: '95%',
		triggerAction: 'all'	
	});
	/* Identify  jenis_keterangan Field */
	jenis_keteranganField= new Ext.form.TextArea({
		id: 'jenis_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '95%'
	});
	/* Identify  jenis_aktif Field */
	jenis_aktifField= new Ext.form.ComboBox({
		id: 'jenis_aktifField',
		name: 'jenis_aktifField',
		fieldLabel: 'Status',
		editable: false,
		store:new Ext.data.SimpleStore({
			fields:['jenis_aktif_value', 'jenis_aktif_display'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		emptyText: 'Aktif',
		displayField: 'jenis_aktif_display',
		valueField: 'jenis_aktif_value',
		width: 80,
		triggerAction: 'all'	
	});
	
	/* Function for retrieve create Window Panel*/ 
	jenis_createForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 350,        
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [jenis_namaField, /* jenis_jenisField, */ jenis_keteranganField, jenis_aktifField] 
			}
			]
		}]
		,
		buttons: [
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JENIS'))){ ?>
			{
				text: 'Save and Close',
				handler: jenis_create
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					jenis_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	jenis_createWindow= new Ext.Window({
		id: 'jenis_createWindow',
		title: post2db_jenis+'Jenis',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_jenis_create',
		items: jenis_createForm
	});
	/* End Window */
	
	
	/* Function for action list search */
	function jenis_list_search(){
		// render according to a SQL date format.
		var jenis_id_search=null;
		var jenis_nama_search=null;
		var jenis_jenis_search=null;
		var jenis_keterangan_search=null;
		var jenis_aktif_search=null;


		if(jenis_idSearchField.getValue()!==null){jenis_id_search=jenis_idSearchField.getValue();}
		if(jenis_namaSearchField.getValue()!==null){jenis_nama_search=jenis_namaSearchField.getValue();}
		if(jenis_jenisSearchField.getValue()!==null){jenis_jenis_search=jenis_jenisSearchField.getValue();}
		if(jenis_keteranganSearchField.getValue()!==null){jenis_keterangan_search=jenis_keteranganSearchField.getValue();}
		if(jenis_aktifSearchField.getValue()!==null){jenis_aktif_search=jenis_aktifSearchField.getValue();}

		// change the store parameters
		jenis_DataStore.baseParams = {
			task: 'SEARCH',
			start: 0,
			limit: pageS_jenis,
			//variable here
			jenis_id			:	jenis_id_search, 
			jenis_nama			:	jenis_nama_search, 
			jenis_jenis			:	jenis_jenis_search, 
			jenis_keterangan	:	jenis_keterangan_search, 
			jenis_aktif			:	jenis_aktif_search 
		};
		// Cause the datastore to do another query : 
		jenis_DataStore.reload({params: {start: 0, limit: pageS_jenis}});
	}
		
	/* Function for reset search result */
	function jenis_reset_search(){
		// reset the store parameters
		jenis_DataStore.baseParams = { task: 'LIST' };
		// Cause the datastore to do another query : 
		jenis_DataStore.reload({params: {start: 0, limit: pageS_jenis}});
		//jenis_searchWindow.close();
	};
	/* End of Fuction */
	
	function jenis_reset_SearchForm(){
		jenis_namaSearchField.reset();
		jenis_jenisSearchField.reset();
		jenis_keteranganSearchField.reset();
		jenis_aktifSearchField.reset();
	}
	
	
	/* Field for search */
	/* Identify  jenis_id Search Field */
	jenis_idSearchField= new Ext.form.NumberField({
		id: 'jenis_idSearchField',
		fieldLabel: 'ID',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  jenis_nama Field */
	jenis_namaSearchField= new Ext.form.TextField({
		id: 'jenis_namaSearchField',
		fieldLabel: 'Nama',
		maxLength: 250,
		allowBlank: false,
		anchor: '95%'
	});
	/* Identify  jenis_jenis Field */
	jenis_jenisSearchField= new Ext.form.ComboBox({
		id: 'jenis_jenisSearchField',
		fieldLabel: 'Kelompok',
		store:new Ext.data.SimpleStore({
			fields:['jenis_jenis_value', 'jenis_jenis_display'],
			data:[['produk','Produk'],['perawatan','Perawatan'],['paket','Paket']]
		}),
		mode: 'local',
		allowBlank: false,
		editable: false,
		displayField: 'jenis_jenis_display',
		valueField: 'jenis_jenis_value',
		anchor: '95%',
		triggerAction: 'all'	
	});
	/* Identify  jenis_keterangan Field */
	jenis_keteranganSearchField= new Ext.form.TextArea({
		id: 'jenis_keteranganSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '95%'
	});
	/* Identify  jenis_aktif Field */
	jenis_aktifSearchField= new Ext.form.ComboBox({
		id: 'jenis_aktifSearchField',
		fieldLabel: 'Status',
		editable: false,
		store:new Ext.data.SimpleStore({
			fields:['jenis_aktif_value', 'jenis_aktif_display'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		emptyText: 'Aktif',
		displayField: 'jenis_aktif_display',
		valueField: 'jenis_aktif_value',
		width: 80,
		triggerAction: 'all'	
	});
    
	/* Function for retrieve search Form Panel */
	jenis_searchForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 350,        
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [jenis_namaSearchField, /* jenis_jenisSearchField, */ jenis_keteranganSearchField, jenis_aktifSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: jenis_list_search
			},{
				text: 'Close',
				handler: function(){
					jenis_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	jenis_searchWindow = new Ext.Window({
		title: 'Pencarian Jenis',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_jenis_search',
		items: jenis_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!jenis_searchWindow.isVisible()){
			jenis_reset_SearchForm();
			jenis_searchWindow.show();
		} else {
			jenis_searchWindow.toFront();
		}
	}
  	/* End Function  */
	
	/* Function for print List Grid */
	function jenis_print(){
		var searchquery = "";
		var jenis_nama_print=null;
		var jenis_jenis_print=null;
		var jenis_keterangan_print=null;
		var jenis_aktif_print=null;
		var win;              
		// check if we do have some search data...
		if(jenis_DataStore.baseParams.query!==null){searchquery = jenis_DataStore.baseParams.query;}
		if(jenis_DataStore.baseParams.jenis_nama!==null){jenis_nama_print = jenis_DataStore.baseParams.jenis_nama;}
		if(jenis_DataStore.baseParams.jenis_jenis!==null){jenis_jenis_print = jenis_DataStore.baseParams.jenis_jenis;}
		if(jenis_DataStore.baseParams.jenis_keterangan!==null){jenis_keterangan_print = jenis_DataStore.baseParams.jenis_keterangan;}
		if(jenis_DataStore.baseParams.jenis_aktif!==null){jenis_aktif_print = jenis_DataStore.baseParams.jenis_aktif;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_jenis&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		
			jenis_nama : jenis_nama_print,
			jenis_jenis : jenis_jenis_print,
			jenis_keterangan : jenis_keterangan_print,
			jenis_aktif : jenis_aktif_print,
		  	currentlisting: jenis_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./kategorilist.html','kategorilist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
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
	/* End Function */
	
	/* Function for print Export to Excel Grid */
	function jenis_export_excel(){
		var searchquery = "";
		var jenis_nama_2excel=null;
		var jenis_jenis_2excel=null;
		var jenis_keterangan_2excel=null;
		var jenis_aktif_2excel=null;
		var win;              
		// check if we do have some search data...
		if(jenis_DataStore.baseParams.query!==null){searchquery = jenis_DataStore.baseParams.query;}
		if(jenis_DataStore.baseParams.jenis_nama!==null){jenis_nama_2excel = jenis_DataStore.baseParams.jenis_nama;}
		if(jenis_DataStore.baseParams.jenis_jenis!==null){jenis_jenis_2excel = jenis_DataStore.baseParams.jenis_jenis;}
		if(jenis_DataStore.baseParams.jenis_keterangan!==null){jenis_keterangan_2excel = jenis_DataStore.baseParams.jenis_keterangan;}
		if(jenis_DataStore.baseParams.jenis_aktif!==null){jenis_aktif_2excel = jenis_DataStore.baseParams.jenis_aktif;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_jenis&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		
			jenis_nama : jenis_nama_2excel,
			jenis_jenis : jenis_jenis_2excel,
			jenis_keterangan : jenis_keterangan_2excel,
			jenis_aktif : jenis_aktif_2excel,
		  	currentlisting: jenis_DataStore.baseParams.task // this tells us if we are searching or not
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
        <div id="fp_jenis"></div>
		<div id="elwindow_jenis_create"></div>
        <div id="elwindow_jenis_search"></div>
    </div>
</div>
</body>