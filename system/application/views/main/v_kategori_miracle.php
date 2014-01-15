<?
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: kategori View
	+ Description	: For record view
	+ Filename 		: v_kategori.php
 	+ Author  		: Zainal, Mukhlison
 	+ Created on 11/Jul/2009 06:46:58
	
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
var kategori_DataStore;
var kategori_ColumnModel;
var kategoriListEditorGrid;
var kategori_createForm;
var kategori_createWindow;
var kategori_searchForm;
var kategori_searchWindow;
var kategori_SelectedRow;
var kategori_ContextMenu;
//declare konstant
var post2db = '';
var msg = '';
var pageS=15;

/* declare variable here */
var kategori_idField;
var kategori_namaField;
var kategori_jenisField;
var kategori_keteranganField;
var kategori_aktifField;
var kategori_creatorField;
var kategori_date_createField;
var kategori_updateField;
var kategori_date_updateField;
var kategori_revisedField;
var kategori_idSearchField;
var kategori_namaSearchField;
var kategori_jenisSearchField;
var kategori_keteranganSearchField;
var kategori_aktifSearchField;


/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  	/* Function for Saving inLine Editing */
	function kategori_update(oGrid_event){
	var kategori_id_update_pk="";
	var kategori_nama_update=null;
	var kategori_jenis_update=null;
	var kategori_keterangan_update=null;
	var kategori_aktif_update=null;


	kategori_id_update_pk = oGrid_event.record.data.kategori_id;
	if(oGrid_event.record.data.kategori_nama!== null){kategori_nama_update = oGrid_event.record.data.kategori_nama;}
	if(oGrid_event.record.data.kategori_jenis!== null){kategori_jenis_update = oGrid_event.record.data.kategori_jenis;}
	if(oGrid_event.record.data.kategori_keterangan!== null){kategori_keterangan_update = oGrid_event.record.data.kategori_keterangan;}
	if(oGrid_event.record.data.kategori_aktif!== null){kategori_aktif_update = oGrid_event.record.data.kategori_aktif;}

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_kategori&m=get_action',
			params: {
				task: "UPDATE",
				kategori_id			: kategori_id_update_pk,				
				kategori_nama		: kategori_nama_update,		
				kategori_jenis		: kategori_jenis_update,		
				kategori_keterangan	: kategori_keterangan_update,		
				kategori_aktif		: kategori_aktif_update			
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						kategori_DataStore.commitChanges();
						kategori_DataStore.reload();
						break;
					default:
						Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Data Group 2 tidak bisa disimpan.',
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
	function kategori_create(){
		if(is_kategori_form_valid()){
		
		var kategori_id_create_pk=null;
		var kategori_nama_create=null;
		var kategori_jenis_create=null;
		var kategori_keterangan_create=null;
		var kategori_aktif_create=null;


		kategori_id_create_pk=get_pk_id();
		if(kategori_namaField.getValue()!== null){kategori_nama_create = kategori_namaField.getValue();}
		if(kategori_jenisField.getValue()!== null){kategori_jenis_create = kategori_jenisField.getValue();}
		if(kategori_keteranganField.getValue()!== null){kategori_keterangan_create = kategori_keteranganField.getValue();}
		if(kategori_aktifField.getValue()!== null){kategori_aktif_create = kategori_aktifField.getValue();}

			Ext.Ajax.request({  
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_kategori&m=get_action',
				params: {
					task: post2db,
					kategori_id			: kategori_id_create_pk,	
					kategori_nama		: kategori_nama_create,	
					kategori_jenis		: kategori_jenis_create,	
					kategori_keterangan	: kategori_keterangan_create,	
					kategori_aktif		: kategori_aktif_create
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							Ext.MessageBox.alert(post2db+' OK','Data Group2 berhasil disimpan.');
							kategori_DataStore.reload();
							kategori_createWindow.hide();
							break;
						default:
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Data Group 2 tidak bisa disimpan !',
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
		if(post2db=='UPDATE')
			return kategoriListEditorGrid.getSelectionModel().getSelected().get('kategori_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function kategori_reset_form(){
		kategori_namaField.reset();
		kategori_jenisField.reset();
		kategori_keteranganField.reset();
		kategori_aktifField.reset();
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function kategori_set_form(){
		kategori_namaField.setValue(kategoriListEditorGrid.getSelectionModel().getSelected().get('kategori_nama'));
		kategori_jenisField.setValue(kategoriListEditorGrid.getSelectionModel().getSelected().get('kategori_jenis'));
		kategori_keteranganField.setValue(kategoriListEditorGrid.getSelectionModel().getSelected().get('kategori_keterangan'));
		kategori_aktifField.setValue(kategoriListEditorGrid.getSelectionModel().getSelected().get('kategori_aktif'));
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_kategori_form_valid(){
		return (kategori_namaField.isValid() && kategori_jenisField.isValid() );
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!kategori_createWindow.isVisible()){
			kategori_reset_form();
			post2db='CREATE';
			msg='created';
			kategori_createWindow.show();
		} else {
			kategori_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function kategori_confirm_delete(){
		// only one kategori is selected here
		if(kategoriListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', kategori_delete);
		} else if(kategoriListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', kategori_delete);
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
	function kategori_confirm_update(){
		/* only one record is selected here */
		if(kategoriListEditorGrid.selModel.getCount() == 1) {
			kategori_set_form();
			post2db='UPDATE';
			msg='updated';
			kategori_createWindow.show();
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
	function kategori_delete(btn){
		if(btn=='yes'){
			var selections = kategoriListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< kategoriListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.kategori_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_kategori&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							kategori_DataStore.reload();
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
	kategori_DataStore = new Ext.data.Store({
		id: 'kategori_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_kategori&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit:pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'kategori_id'
		},[
			{name: 'kategori_id', type: 'int', mapping: 'kategori_id'},
			{name: 'kategori_nama', type: 'string', mapping: 'kategori_nama'},
			{name: 'kategori_jenis', type: 'string', mapping: 'kategori_jenis'},
			{name: 'kategori_keterangan', type: 'string', mapping: 'kategori_keterangan'},
			{name: 'kategori_aktif', type: 'string', mapping: 'kategori_aktif'},
			{name: 'kategori_creator', type: 'string', mapping: 'kategori_creator'},
			{name: 'kategori_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'kategori_date_create'},
			{name: 'kategori_update', type: 'string', mapping: 'kategori_update'},
			{name: 'kategori_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'kategori_date_update'},
			{name: 'kategori_revised', type: 'int', mapping: 'kategori_revised'}
		]),
		sortInfo:{field: 'kategori_id', direction: "ASC"}
	});
	/* End of Function */
    
  	/* Function for Identify of Window Column Model */
	kategori_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'kategori_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},
		{
			header: 'Nama',
			dataIndex: 'kategori_nama',
			width: 150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_JENIS'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
			<?php } ?>
		},
		{
			header: 'Kelompok',
			dataIndex: 'kategori_jenis',
			width: 150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_JENIS'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['kategori_jenis_value', 'kategori_jenis_display'],
					data: [['produk','Produk'],['perawatan','Perawatan'],['paket','Paket']]
					}),
				mode: 'local',
               	displayField: 'kategori_jenis_display',
               	valueField: 'kategori_jenis_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small',
				anchor: '60%'
            })
			<?php } ?>
		},
		{
			header: 'Keterangan',
			dataIndex: 'kategori_keterangan',
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
			dataIndex: 'kategori_aktif',
			width: 150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_JENIS'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['kategori_aktif_value', 'kategori_aktif_display'],
					data: [['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
					}),
				mode: 'local',
               	displayField: 'kategori_aktif_display',
               	valueField: 'kategori_aktif_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small',
				anchor: '30%'
            })
			<?php } ?>
		},
		{
			header: 'Creator',
			dataIndex: 'kategori_creator',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		},
		{
			header: 'Create on',
			dataIndex: 'kategori_date_create',
			width: 150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			hidden: true,
			readOnly: true
		},
		{
			header: 'Last Update By',
			dataIndex: 'kategori_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		},
		{
			header: 'Last Update on',
			dataIndex: 'kategori_date_update',
			width: 150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			hidden: true,
			readOnly: true
		},
		{
			header: 'Revised',
			dataIndex: 'kategori_revised',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}]
	);
	kategori_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	kategoriListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'kategoriListEditorGrid',
		el: 'fp_kategori',
		title: 'Daftar Jenis',
		autoHeight: true,
		store: kategori_DataStore, // DataStore
		cm: kategori_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 700,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: kategori_DataStore,
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
			handler: kategori_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_JENIS'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: kategori_confirm_delete   // Confirm before deleting
		}, '-', 
		<?php } ?>
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: kategori_DataStore,
			params: {task: 'LIST',start: 0, limit: pageS},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						kategori_DataStore.baseParams={task:'LIST',start: 0, limit: pageS};
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
			handler: kategori_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: kategori_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: kategori_print  
		}
		]
	});
	kategoriListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	kategori_ContextMenu = new Ext.menu.Menu({
		id: 'kategori_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_JENIS'))){ ?>
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: kategori_confirm_update 
		},
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_JENIS'))){ ?>
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			handler: kategori_confirm_delete 
		},
		<?php } ?>
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: kategori_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: kategori_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onkategori_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		kategori_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		kategori_SelectedRow=rowIndex;
		kategori_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function kategori_editContextMenu(){
      kategoriListEditorGrid.startEditing(kategori_SelectedRow,1);
  	}
	/* End of Function */
  	
	kategoriListEditorGrid.addListener('rowcontextmenu', onkategori_ListEditGridContextMenu);
	kategori_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	kategoriListEditorGrid.on('afteredit', kategori_update); // inLine Editing Record
	
	/* Identify  kategori_nama Field */
	kategori_namaField= new Ext.form.TextField({
		id: 'kategori_namaField',
		fieldLabel: 'Nama <span style="color: #ec0000">*</span>',
		maxLength: 250,
		allowBlank: false,
		anchor: '95%'
	});
	/* Identify  kategori_jenis Field */
	kategori_jenisField= new Ext.form.ComboBox({
		id: 'kategori_jenisField',
		fieldLabel: 'Kelompok <span style="color: #ec0000">*</span>',
		store:new Ext.data.SimpleStore({
			fields:['kategori_jenis_value', 'kategori_jenis_display'],
			data:[['produk','Produk'],['perawatan','Perawatan'],['paket','Paket']]
		}),
		mode: 'local',
		allowBlank: false,
		editable: false,
		displayField: 'kategori_jenis_display',
		valueField: 'kategori_jenis_value',
		anchor: '95%',
		triggerAction: 'all'	
	});
	/* Identify  kategori_keterangan Field */
	kategori_keteranganField= new Ext.form.TextArea({
		id: 'kategori_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '95%'
	});
	/* Identify  kategori_aktif Field */
	kategori_aktifField= new Ext.form.ComboBox({
		id: 'kategori_aktifField',
		name: 'kategori_aktifField',
		fieldLabel: 'Status',
		editable: false,
		store:new Ext.data.SimpleStore({
			fields:['kategori_aktif_value', 'kategori_aktif_display'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		emptyText: 'Aktif',
		displayField: 'kategori_aktif_display',
		valueField: 'kategori_aktif_value',
		width: 80,
		triggerAction: 'all'	
	});
	
	/* Function for retrieve create Window Panel*/ 
	kategori_createForm = new Ext.FormPanel({
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
				items: [kategori_namaField, kategori_jenisField, kategori_keteranganField, kategori_aktifField] 
			}
			]
		}]
		,
		buttons: [
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_JENIS'))){ ?>
			{
				text: 'Save and Close',
				handler: kategori_create
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					kategori_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	kategori_createWindow= new Ext.Window({
		id: 'kategori_createWindow',
		title: post2db+'Jenis',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_kategori_create',
		items: kategori_createForm
	});
	/* End Window */
	
	
	/* Function for action list search */
	function kategori_list_search(){
		// render according to a SQL date format.
		var kategori_id_search=null;
		var kategori_nama_search=null;
		var kategori_jenis_search=null;
		var kategori_keterangan_search=null;
		var kategori_aktif_search=null;


		if(kategori_idSearchField.getValue()!==null){kategori_id_search=kategori_idSearchField.getValue();}
		if(kategori_namaSearchField.getValue()!==null){kategori_nama_search=kategori_namaSearchField.getValue();}
		if(kategori_jenisSearchField.getValue()!==null){kategori_jenis_search=kategori_jenisSearchField.getValue();}
		if(kategori_keteranganSearchField.getValue()!==null){kategori_keterangan_search=kategori_keteranganSearchField.getValue();}
		if(kategori_aktifSearchField.getValue()!==null){kategori_aktif_search=kategori_aktifSearchField.getValue();}

		// change the store parameters
		kategori_DataStore.baseParams = {
			task: 'SEARCH',
			start: 0,
			limit: pageS,
			//variable here
			kategori_id			:	kategori_id_search, 
			kategori_nama		:	kategori_nama_search, 
			kategori_jenis		:	kategori_jenis_search, 
			kategori_keterangan	:	kategori_keterangan_search, 
			kategori_aktif		:	kategori_aktif_search 
		};
		// Cause the datastore to do another query : 
		kategori_DataStore.reload({params: {start: 0, limit: pageS}});
	}
		
	/* Function for reset search result */
	function kategori_reset_search(){
		// reset the store parameters
		kategori_DataStore.baseParams = { task: 'LIST' };
		// Cause the datastore to do another query : 
		kategori_DataStore.reload({params: {start: 0, limit: pageS}});
		//kategori_searchWindow.close();
	};
	/* End of Fuction */
	
	function kategori_reset_SearchForm(){
		kategori_namaSearchField.reset();
		kategori_jenisSearchField.reset();
		kategori_keteranganSearchField.reset();
		kategori_aktifSearchField.reset();
	}
	
	
	/* Field for search */
	/* Identify  kategori_id Search Field */
	kategori_idSearchField= new Ext.form.NumberField({
		id: 'kategori_idSearchField',
		fieldLabel: 'ID',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  kategori_nama Field */
	kategori_namaSearchField= new Ext.form.TextField({
		id: 'kategori_namaSearchField',
		fieldLabel: 'Nama',
		maxLength: 250,
		allowBlank: false,
		anchor: '95%'
	});
	/* Identify  kategori_jenis Field */
	kategori_jenisSearchField= new Ext.form.ComboBox({
		id: 'kategori_jenisSearchField',
		fieldLabel: 'Kelompok',
		store:new Ext.data.SimpleStore({
			fields:['kategori_jenis_value', 'kategori_jenis_display'],
			data:[['produk','Produk'],['perawatan','Perawatan'],['paket','Paket']]
		}),
		mode: 'local',
		allowBlank: false,
		editable: false,
		displayField: 'kategori_jenis_display',
		valueField: 'kategori_jenis_value',
		anchor: '95%',
		triggerAction: 'all'	
	});
	/* Identify  kategori_keterangan Field */
	kategori_keteranganSearchField= new Ext.form.TextArea({
		id: 'kategori_keteranganSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '95%'
	});
	/* Identify  kategori_aktif Field */
	kategori_aktifSearchField= new Ext.form.ComboBox({
		id: 'kategori_aktifSearchField',
		fieldLabel: 'Status',
		editable: false,
		store:new Ext.data.SimpleStore({
			fields:['kategori_aktif_value', 'kategori_aktif_display'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		emptyText: 'Aktif',
		displayField: 'kategori_aktif_display',
		valueField: 'kategori_aktif_value',
		width: 80,
		triggerAction: 'all'	
	});
    
	/* Function for retrieve search Form Panel */
	kategori_searchForm = new Ext.FormPanel({
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
				items: [kategori_namaSearchField, kategori_jenisSearchField, kategori_keteranganSearchField, kategori_aktifSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: kategori_list_search
			},{
				text: 'Close',
				handler: function(){
					kategori_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	kategori_searchWindow = new Ext.Window({
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
		renderTo: 'elwindow_kategori_search',
		items: kategori_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!kategori_searchWindow.isVisible()){
			kategori_reset_SearchForm();
			kategori_searchWindow.show();
		} else {
			kategori_searchWindow.toFront();
		}
	}
  	/* End Function  */
	
	/* Function for print List Grid */
	function kategori_print(){
		var searchquery = "";
		var kategori_nama_print=null;
		var kategori_jenis_print=null;
		var kategori_keterangan_print=null;
		var kategori_aktif_print=null;
		var win;              
		// check if we do have some search data...
		if(kategori_DataStore.baseParams.query!==null){searchquery = kategori_DataStore.baseParams.query;}
		if(kategori_DataStore.baseParams.kategori_nama!==null){kategori_nama_print = kategori_DataStore.baseParams.kategori_nama;}
		if(kategori_DataStore.baseParams.kategori_jenis!==null){kategori_jenis_print = kategori_DataStore.baseParams.kategori_jenis;}
		if(kategori_DataStore.baseParams.kategori_keterangan!==null){kategori_keterangan_print = kategori_DataStore.baseParams.kategori_keterangan;}
		if(kategori_DataStore.baseParams.kategori_aktif!==null){kategori_aktif_print = kategori_DataStore.baseParams.kategori_aktif;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_kategori&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		
			kategori_nama : kategori_nama_print,
			kategori_jenis : kategori_jenis_print,
			kategori_keterangan : kategori_keterangan_print,
			kategori_aktif : kategori_aktif_print,
		  	currentlisting: kategori_DataStore.baseParams.task // this tells us if we are searching or not
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
	function kategori_export_excel(){
		var searchquery = "";
		var kategori_nama_2excel=null;
		var kategori_jenis_2excel=null;
		var kategori_keterangan_2excel=null;
		var kategori_aktif_2excel=null;
		var win;              
		// check if we do have some search data...
		if(kategori_DataStore.baseParams.query!==null){searchquery = kategori_DataStore.baseParams.query;}
		if(kategori_DataStore.baseParams.kategori_nama!==null){kategori_nama_2excel = kategori_DataStore.baseParams.kategori_nama;}
		if(kategori_DataStore.baseParams.kategori_jenis!==null){kategori_jenis_2excel = kategori_DataStore.baseParams.kategori_jenis;}
		if(kategori_DataStore.baseParams.kategori_keterangan!==null){kategori_keterangan_2excel = kategori_DataStore.baseParams.kategori_keterangan;}
		if(kategori_DataStore.baseParams.kategori_aktif!==null){kategori_aktif_2excel = kategori_DataStore.baseParams.kategori_aktif;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_kategori&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		
			kategori_nama : kategori_nama_2excel,
			kategori_jenis : kategori_jenis_2excel,
			kategori_keterangan : kategori_keterangan_2excel,
			kategori_aktif : kategori_aktif_2excel,
		  	currentlisting: kategori_DataStore.baseParams.task // this tells us if we are searching or not
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
        <div id="fp_kategori"></div>
		<div id="elwindow_kategori_create"></div>
        <div id="elwindow_kategori_search"></div>
    </div>
</div>
</body>