<?
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: customer_note View
	+ Description	: For record view
	+ Filename 		: v_customer_note.php
 	+ Author  		: zainal. mukhlison
 	+ Created on 12/Aug/2009 11:16:45
	
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
var customer_note_DataStore;
var customer_note_ColumnModel;
var customer_noteListEditorGrid;
var customer_note_createForm;
var customer_note_createWindow;
var customer_note_searchForm;
var customer_note_searchWindow;
var customer_note_SelectedRow;
var customer_note_ContextMenu;
//declare konstant
var post2db = '';
var msg = '';
var pageS=15;

/* declare variable here */
var note_idField;
var note_customerField;
var note_tanggalField;
var note_detailField;
var note_aktifField;
var dt= new Date();

var note_idSearchField;
var note_customerSearchField;
var note_tanggalSearchField;
var note_detailSearchField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  	/* Function for Saving inLine Editing */
	function customer_note_update(oGrid_event){
		var note_id_update_pk="";
		var note_customer_update=null;
		var note_tanggal_update_date="";
		var note_detail_update=null;
		var note_aktif_update=null;
	
	
		note_id_update_pk = oGrid_event.record.data.note_id;
		if(oGrid_event.record.data.note_customer!== null){note_customer_update = oGrid_event.record.data.note_customer;}
		if(oGrid_event.record.data.note_tanggal!== ""){note_tanggal_update_date = oGrid_event.record.data.note_tanggal.format('Y-m-d');}
		if(oGrid_event.record.data.note_detail!== null){note_detail_update = oGrid_event.record.data.note_detail;}
		if(oGrid_event.record.data.note_aktif!== null){note_aktif_update = oGrid_event.record.data.note_aktif;}

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_customer_note&m=get_action',
			params: {
				task: "UPDATE",
				note_id			: note_id_update_pk,				
				note_customer	: note_customer_update,		
				note_tanggal	: note_tanggal_update_date,				
				note_detail		: note_detail_update,
				note_aktif		: note_aktif_update
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						customer_note_DataStore.commitChanges();
						customer_note_DataStore.reload();
						cbo_note_customer_DataSore.reload();
						break;
					default:
						Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Data Catatan Customer tidak bisa disimpan!.',
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
	function customer_note_create(){
		if(is_customer_note_form_valid()){
		
		var note_id_create_pk=null;
		var note_customer_create=null;
		var note_tanggal_create_date="";
		var note_detail_create=null;
		var note_aktif_create=null;

		note_id_create_pk=get_pk_id();
		if(note_customerField.getValue()!== null){note_customer_create = note_customerField.getValue();}
		if(note_tanggalField.getValue()!== ""){note_tanggal_create_date = note_tanggalField.getValue().format('Y-m-d H:i:s');}
		if(note_detailField.getValue()!== null){note_detail_create = note_detailField.getValue();}
		if(note_aktifField.getValue()!== null){note_aktif_create = note_aktifField.getValue();}

			Ext.Ajax.request({  
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_customer_note&m=get_action',
				params: {
					task			: post2db,
					note_id			: note_id_create_pk,	
					note_customer	: note_customer_create,	
					note_tanggal	: note_tanggal_create_date,					
					note_detail		: note_detail_create,
					note_aktif		: note_aktif_create
				}, 
				success: function(response){   
					var result=eval(response.responseText);
					switch(result){
						case 1:
							Ext.MessageBox.alert(post2db+' OK','Data Catatan Customer berhasil disimpan');
							customer_note_DataStore.reload();
							cbo_note_customer_DataSore.reload();
							customer_note_createWindow.hide();
							break;
						default:
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Data Catatan Customer tidak bisa disimpan !',
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
			return customer_noteListEditorGrid.getSelectionModel().getSelected().get('note_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function customer_note_reset_form(){
		//note_customerField.reset();
		note_tanggalField.reset();
		note_detailField.reset();
		//note_tanggalField.setValue("");
		note_detailField.setValue(null);
		note_customerField.reset();
		note_customerField.setValue(null);
		note_customerField.setDisabled(false);
		note_aktifField.reset();
		note_aktifField.setValue('Aktif');
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function customer_note_set_form(){
		note_customerField.setValue(customer_noteListEditorGrid.getSelectionModel().getSelected().get('note_customer'));
		note_tanggalField.setValue(customer_noteListEditorGrid.getSelectionModel().getSelected().get('note_tanggal'));
		note_detailField.setValue(customer_noteListEditorGrid.getSelectionModel().getSelected().get('note_detail'));
		note_aktifField.setValue(customer_noteListEditorGrid.getSelectionModel().getSelected().get('note_aktif'));
		note_customerField.setDisabled(true);
		
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_customer_note_form_valid(){
		return (note_customerField.isValid() && note_tanggalField.isValid() && note_detailField.isValid() );
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		
		if(!customer_note_createWindow.isVisible()){
			post2db='CREATE';
			msg='created';
			customer_note_reset_form();
			customer_note_createWindow.show();
		} else {
			customer_note_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function customer_note_confirm_delete(){
		// only one customer_note is selected here
		if(customer_noteListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', customer_note_delete);
		} else if(customer_noteListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', customer_note_delete);
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
	function customer_note_confirm_update(){
		/* only one record is selected here */
		if(customer_noteListEditorGrid.selModel.getCount() == 1) {
			post2db='UPDATE';
			msg='updated';
			customer_note_set_form();
			customer_note_createWindow.show();
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
	function customer_note_delete(btn){
		if(btn=='yes'){
			var selections = customer_noteListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< customer_noteListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.note_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_customer_note&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							customer_note_DataStore.reload();
							cbo_note_customer_DataSore.reload();
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
	customer_note_DataStore = new Ext.data.Store({
		id: 'customer_note_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_customer_note&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'note_id'
		},[
			{name: 'note_id', type: 'int', mapping: 'note_id'},
			{name: 'no_customer', type: 'string', mapping: 'cust_no'},
			{name: 'note_customer', type: 'string', mapping: 'cust_nama'},
			{name: 'note_tanggal', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'note_tanggal'},
			{name: 'note_detail', type: 'string', mapping: 'note_detail'},
			{name: 'note_aktif', type: 'string', mapping: 'note_aktif'},
			{name: 'note_creator', type: 'string', mapping: 'note_creator'},
			{name: 'note_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'note_date_create'},
			{name: 'note_update', type: 'string', mapping: 'note_update'},
			{name: 'note_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'note_date_update'},
			{name: 'note_revised', type: 'int', mapping: 'note_revised'}
		]),
		sortInfo:{field: 'note_tanggal', direction: "DESC"}
	});
	/* End of Function */
    
	
	/* Function for Retrieve DataStore */
	cbo_note_customer_DataSore = new Ext.data.Store({
		id: 'cbo_note_customer_DataSore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_customer_note&m=get_customer_list', 
			method: 'POST'
		}),
		baseParams:{task: "LIST",start:0, limit:pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'cust_id'
		},[
			{name: 'cust_id', type: 'int', mapping: 'cust_id'},
			{name: 'cust_nama', type: 'string', mapping: 'cust_nama'},
			{name: 'cust_no', type: 'string', mapping: 'cust_no'},
			{name: 'cust_tgllahir', type: 'date', dateFormat: 'Y-m-d', mapping: 'cust_tgllahir'},
			{name: 'cust_alamat', type: 'string', mapping: 'cust_alamat'},
			{name: 'cust_notelprumah', type: 'string', mapping: 'cust_telprumah'}
		]),
		sortInfo:{field: 'cust_no', direction: "ASC"}
	});
	/* End of Function */
	
  	/* Function for Identify of Window Column Model */
	customer_note_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'note_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},
		{
			header: '<div align="center">' + 'Tanggal dan Jam' + '</div>',
			dataIndex: 'note_tanggal',
			width: 80,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y H:i:s'),
			readOnly: true
		},
		{
			header: '<div align="center">' + 'No Cust' + '</div>',
			dataIndex: 'no_customer',
			width: 60,
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">' + 'Customer' + '</div>',
			dataIndex: 'note_customer',
			width: 150,
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">' + 'Detail Catatan' + '</div>',
			dataIndex: 'note_detail',
			width: 300,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_CUSTCAT'))){ ?>
			,
			editor: new Ext.form.TextArea({
				maxLength: 250
          	})
			<?php } ?>
		},
		{
			header: '<div align="center">' + 'Status' + '</div>',
			dataIndex: 'note_aktif',
			width: 45,	//150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_CUSTCAT'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['note_aktif_value', 'note_aktif_display'],
					data: [['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
					}),
				mode: 'local',
               	displayField: 'note_aktif_display',
               	valueField: 'note_aktif_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
			<?php } ?>
		},
		
		{
			header: 'Creator',
			dataIndex: 'note_creator',
			width: 150,
			sortable: true,
			readOnly: true,
			hidden: true
		},
		{
			header: 'Create on',
			dataIndex: 'note_date_create',
			width: 150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			readOnly: true,
			hidden: true
		},
		{
			header: 'Last Update by',
			dataIndex: 'note_update',
			width: 150,
			sortable: true,
			readOnly: true,
			hidden: true
		},
		{
			header: 'Last Update on',
			dataIndex: 'note_date_update',
			width: 150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			readOnly: true,
			hidden: true
		},
		{
			header: 'Revised',
			dataIndex: 'note_revised',
			width: 150,
			sortable: true,
			readOnly: true,
			hidden: true
		}]
	);
	customer_note_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	customer_noteListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'customer_noteListEditorGrid',
		el: 'fp_customer_note',
		title: 'Daftar Catatan Customer',
		autoHeight: true,
		store: customer_note_DataStore, // DataStore
		cm: customer_note_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1220,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: customer_note_DataStore,
			displayInfo: true
		}),
		/* Add Control on ToolBar */
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_CUSTCAT'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<?php } ?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_CUSTCAT'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: customer_note_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_CUSTCAT'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: customer_note_confirm_delete   // Confirm before deleting
		}, 
		'-', 
		<?php } ?>
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: customer_note_DataStore,
			params: {start: 0, limit: pageS},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: customer_note_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: customer_note_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: customer_note_print  
		}
		]
	});
	customer_noteListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	customer_note_ContextMenu = new Ext.menu.Menu({
		id: 'customer_note_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_CUSTCAT'))){ ?>
		{ 
			text: 'Edit', disabled: true, tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: customer_note_confirm_update 
		},
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_CUSTCAT'))){ ?>
		{ 
			text: 'Delete', disabled: true, 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			handler: customer_note_confirm_delete 
		},
		<?php } ?>
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: customer_note_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: customer_note_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function oncustomer_note_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		customer_note_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		customer_note_SelectedRow=rowIndex;
		customer_note_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function customer_note_editContextMenu(){
      customer_noteListEditorGrid.startEditing(customer_note_SelectedRow,1);
  	}
	/* End of Function */
  	
	customer_noteListEditorGrid.addListener('rowcontextmenu', oncustomer_note_ListEditGridContextMenu);
	customer_note_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	customer_noteListEditorGrid.on('afteredit', customer_note_update); // inLine Editing Record
	
	
	// Custom rendering Template
    var note_customerTpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>({cust_no}) {cust_nama}</b><br/>',
			'Tgl Lahir: {cust_tgllahir:date("j M Y")}<br />',
            /*'Alamat: {cust_alamat}&nbsp;&nbsp;&nbsp;[Telp. {cust_notelprumah}]</span>',*/
        '</div></tpl>'
    );
	
	/* Identify  note_customer Field */
	note_customerField= new Ext.form.ComboBox({
		id: 'note_customerField',
		fieldLabel: 'Customer',
		store: cbo_note_customer_DataSore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        //hideTrigger:true,
        tpl: note_customerTpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});
	/* Identify  note_tanggal Field */
	note_tanggalField= new Ext.form.DateField({
		id: 'note_tanggalField',
		fieldLabel: 'Tanggal dan Jam',
		format : 'd-m-Y H:i:s',
		emptyText: dt.format('d-m-Y H:i:s'),
		blankText: dt.format('d-m-Y H:i:s'),	
		allowBlank: true,
		//readOnly: true,
		hideTrigger: false,
		width: 150
	});
	/* Identify  note_detail Field */
	note_detailField= new Ext.form.TextArea({
		id: 'note_detailField',
		fieldLabel: 'Detail Catatan',
		maxLength: 250,
		anchor: '95%'
	});
	
	/* Identify  note_aktif Field */
	note_aktifField= new Ext.form.ComboBox({
		id: 'note_aktifField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['note_aktif_value', 'note_aktif_display'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		emptyText: 'Aktif',
		//allowBlank: true,
		displayField: 'note_aktif_display',
		valueField: 'note_aktif_value',
		anchor: '50%',
		triggerAction: 'all'	
	});
	
	
	/* Function for retrieve create Window Panel*/ 
	customer_note_createForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 400,        
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [note_customerField, note_tanggalField, note_detailField, note_aktifField] 
			}
			]
		}]
		,
		buttons: [
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_CUSTCAT'))){ ?>
			{
				text: 'Save and Close',
				handler: customer_note_create
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					customer_note_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	customer_note_createWindow= new Ext.Window({
		id: 'customer_note_createWindow',
		title: post2db+' Catatan Customer',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_customer_note_create',
		items: customer_note_createForm
	});
	/* End Window */
	
	
	/* Function for action list search */
	function customer_note_list_search(){
		// render according to a SQL date format.
		var note_id_search=null;
		var note_customer_search=null;
		var note_tanggal_search_date="";
		var note_detail_search=null;
		var note_aktif_search=null;


		if(note_idSearchField.getValue()!==null){note_id_search=note_idSearchField.getValue();}
		if(note_customerSearchField.getValue()!==null){note_customer_search=note_customerSearchField.getValue();}
		if(note_tanggalSearchField.getValue()!==""){note_tanggal_search_date=note_tanggalSearchField.getValue().format('Y-m-d');}
		if(note_detailSearchField.getValue()!==null){note_detail_search=note_detailSearchField.getValue();}
		if(note_aktifSearchField.getValue()!==null){note_aktif_search=note_aktifSearchField.getValue();}
	
		// change the store parameters
		customer_note_DataStore.baseParams = {
			task: 'SEARCH',
			//variable here
			note_id	:	note_id_search, 
			note_customer	:	note_customer_search, 
			note_tanggal	:	note_tanggal_search_date, 
			note_detail	:	note_detail_search,
			note_aktif	:	note_aktif_search
		};
		// Cause the datastore to do another query : 
		customer_note_DataStore.reload({params: {start: 0, limit: pageS}});
	}
		
	/* Function for reset search result */
	function customer_note_reset_search(){
		// reset the store parameters
		customer_note_DataStore.baseParams = { task: 'LIST' };
		// Cause the datastore to do another query : 
		customer_note_DataStore.reload({params: {start: 0, limit: pageS}});
		cbo_note_customer_DataSore.reload();
		customer_note_searchWindow.close();
	};
	/* End of Fuction */

	function customer_note_reset_SearchForm(){
		note_customerSearchField.reset();
		note_tanggalSearchField.reset();
		note_detailSearchField.reset();
		note_aktifSearchField.setValue(null);
		note_aktifSearchField.reset();
	}
	
	/* Field for search */
	/* Identify  note_id Search Field */
	note_idSearchField= new Ext.form.NumberField({
		id: 'note_idSearchField',
		fieldLabel: 'Note Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  note_customer Search Field */
	note_customerSearchField= new Ext.form.ComboBox({
		id: 'note_customerSearchField',
		fieldLabel: 'Customer',
		store: cbo_note_customer_DataSore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:true,
        tpl: note_customerTpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	
	});
	
	/* Identify note_aktif Search Field*/
	note_aktifSearchField= new Ext.form.ComboBox({
		id: 'note_aktifSearchField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['note_aktif_value', 'note_aktif_display'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		//emptyText: 'Aktif',
		//allowBlank: true,
		displayField: 'note_aktif_display',
		valueField: 'note_aktif_value',
		anchor: '50%',
		triggerAction: 'all'	
	});
	

	/* Identify  note_tanggal Search Field */
	note_tanggalSearchField= new Ext.form.DateField({
		id: 'note_tanggalSearchField',
		fieldLabel: 'Tanggal',
		//hideTrigger: true,
		format : 'Y-m-d'
	
	});
	/* Identify  note_detail Search Field */
	note_detailSearchField= new Ext.form.TextArea({
		id: 'note_detailSearchField',
		fieldLabel: 'Detail Catatan',
		maxLength: 250,
		anchor: '95%'
	
	});
	
	/* Function for retrieve search Form Panel */
	customer_note_searchForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 400,        
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [note_customerSearchField, note_tanggalSearchField, note_detailSearchField,note_aktifSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: customer_note_list_search
			},{
				text: 'Close',
				handler: function(){
					customer_note_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	customer_note_searchWindow = new Ext.Window({
		title: 'Pencarian Catatan Customer',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_customer_note_search',
		items: customer_note_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!customer_note_searchWindow.isVisible()){
			customer_note_reset_SearchForm();
			customer_note_searchWindow.show();
		} else {
			customer_note_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function customer_note_print(){
		var searchquery = "";
		var note_customer_print=null;
		var note_tanggal_print_date="";
		var note_detail_print=null;
		var win;              
		// check if we do have some search data...
		if(customer_note_DataStore.baseParams.query!==null){searchquery = customer_note_DataStore.baseParams.query;}
		if(customer_note_DataStore.baseParams.note_customer!==null){note_customer_print = customer_note_DataStore.baseParams.note_customer;}
		if(customer_note_DataStore.baseParams.note_tanggal!==""){note_tanggal_print_date = customer_note_DataStore.baseParams.note_tanggal;}
		if(customer_note_DataStore.baseParams.note_detail!==null){note_detail_print = customer_note_DataStore.baseParams.note_detail;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_customer_note&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			note_customer : note_customer_print,
		  	note_tanggal : note_tanggal_print_date, 
			note_detail : note_detail_print,
		  	currentlisting: customer_note_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./customer_notelist.html','customer_notelist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
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
	function customer_note_export_excel(){
		var searchquery = "";
		var note_customer_2excel=null;
		var note_tanggal_2excel_date="";
		var note_detail_2excel=null;
		var win;              
		// check if we do have some search data...
		if(customer_note_DataStore.baseParams.query!==null){searchquery = customer_note_DataStore.baseParams.query;}
		if(customer_note_DataStore.baseParams.note_customer!==null){note_customer_2excel = customer_note_DataStore.baseParams.note_customer;}
		if(customer_note_DataStore.baseParams.note_tanggal!==""){note_tanggal_2excel_date = customer_note_DataStore.baseParams.note_tanggal;}
		if(customer_note_DataStore.baseParams.note_detail!==null){note_detail_2excel = customer_note_DataStore.baseParams.note_detail;}
		

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_customer_note&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			note_customer : note_customer_2excel,
		  	note_tanggal : note_tanggal_2excel_date, 
			note_detail : note_detail_2excel,
		  	currentlisting: customer_note_DataStore.baseParams.task // this tells us if we are searching or not
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
        <div id="fp_customer_note"></div>
		<div id="elwindow_customer_note_create"></div>
        <div id="elwindow_customer_note_search"></div>
    </div>
</div>
</body>