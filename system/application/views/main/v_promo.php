<?
/* 	These code was generated using phpCIGen v 0.1.b (1/08/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: promo View
	+ Description	: For record view
	+ Filename 		: v_promo.php
 	+ Author  		: 
 	+ Created on 27/Aug/2009 08:57:17
	
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
var promo_DataStore;
var promo_ColumnModel;
var promoListEditorGrid;
var promo_createForm;
var promo_createWindow;
var promo_searchForm;
var promo_searchWindow;
var promo_SelectedRow;
var promo_ContextMenu;
//for detail data
var promo_berlaku_DataStor;
var promo_berlakuListEditorGrid;
var promo_berlaku_ColumnModel;
var promo_berlaku_proxy;
var promo_berlaku_writer;
var promo_berlaku_reader;
var editor_promo_berlaku;

//declare konstant
var post2db = '';
var msg = '';
var pageS=15;

/* declare variable here for Field*/
var promo_idField;
var promo_acaraField;
var promo_tempatField;
var promo_keteranganField;
var promo_tglmulaiField;
var promo_tglselesaiField;
var promo_diskonField;
var promo_allprodukField;
var promo_allrawatField;

var promo_idSearchField;
var promo_acaraSearchField;
var promo_tempatSearchField;
var promo_keteranganSearchField;
var promo_tglmulaiSearchField;
var promo_tglselesaiSearchField;
var promo_diskonSearchField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
 	/* Function for add data, open window create form */
	function promo_create(){
	
		if(is_promo_form_valid()){	
		var promo_id_create=null; 
		var promo_acara_create=null; 
		var promo_tempat_create=null; 
		var promo_keterangan_create=null;
		var promo_tglmulai_create_date=""; 
		var promo_tglselesai_create_date=""; 
		var promo_diskon_create=null; 
		var promo_allproduk_create=null; 
		var promo_allrawat_create=null; 

		if(promo_idField.getValue()!== null){promo_id_create_pk = promo_idField.getValue();} 
		if(promo_acaraField.getValue()!== null){promo_acara_create = promo_acaraField.getValue();} 
		if(promo_tempatField.getValue()!== null){promo_tempat_create = promo_tempatField.getValue();} 
		if(promo_keteranganField.getValue()!== null){promo_keterangan_create = promo_keteranganField.getValue();} 
		if(promo_tglmulaiField.getValue()!== ""){promo_tglmulai_create_date = promo_tglmulaiField.getValue().format('Y-m-d');} 
		if(promo_tglselesaiField.getValue()!== ""){promo_tglselesai_create_date = promo_tglselesaiField.getValue().format('Y-m-d');} 
		if(promo_diskonField.getValue()!== null){promo_diskon_create = promo_diskonField.getValue();} 
		if(promo_allprodukField.getValue()!== null){promo_allproduk_create = promo_allprodukField.getValue();} 
		if(promo_allrawatField.getValue()!== null){promo_allrawat_create = promo_allrawatField.getValue();} 

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_promo&m=get_action',
			params: {
				task: post2db,
				promo_id		: promo_id_create_pk, 
				promo_acara		: promo_acara_create, 
				promo_tempat	: promo_tempat_create, 
				promo_keterangan	: promo_keterangan_create, 
				promo_tglmulai	: promo_tglmulai_create_date, 
				promo_tglselesai	: promo_tglselesai_create_date, 
				promo_diskon	: promo_diskon_create, 
				promo_allproduk	: promo_allproduk_create, 
				promo_allrawat	: promo_allrawat_create
			}, 
			success: function(response){             
				var result=eval(response.responseText);
				if(result!==0){
						
						Ext.MessageBox.alert(post2db+' OK','Data Promo berhasil disimpan');
						promo_produk_insert(result)
						promo_createWindow.hide();
				}else{
						Ext.MessageBox.show({
						   title: 'Warning',
						   //msg: 'We could\'t not '+msg+' the Master_order_beli.',
						   msg: 'Data Promo tidak bisa disimpan',
						   buttons: Ext.MessageBox.OK,
						   animEl: 'save',
						   icon: Ext.MessageBox.WARNING
						});
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
			return promoListEditorGrid.getSelectionModel().getSelected().get('promo_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function promo_reset_form(){
		promo_idField.reset();
		promo_idField.setValue(null);
		promo_acaraField.reset();
		promo_acaraField.setValue(null);
		promo_tempatField.reset();
		promo_tempatField.setValue(null);
		promo_keteranganField.reset();
		promo_keteranganField.setValue(null);
		promo_tglmulaiField.reset();
		promo_tglmulaiField.setValue(null);
		promo_tglselesaiField.reset();
		promo_tglselesaiField.setValue(null);
		promo_diskonField.reset();
		promo_diskonField.setValue(0);
		promo_allprodukField.reset();
		promo_allprodukField.setValue(false);
		promo_allrawatField.reset();
		promo_allrawatField.setValue(false);
		
		promo_produk_DataStore.setBaseParam('master_id',-1);
		promo_perawatan_DataStore.setBaseParam('master_id',-1);
		promo_produk_DataStore.load();
		promo_perawatan_DataStore.load();
		
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function promo_set_form(){
		promo_idField.setValue(promoListEditorGrid.getSelectionModel().getSelected().get('promo_id'));
		promo_acaraField.setValue(promoListEditorGrid.getSelectionModel().getSelected().get('promo_acara'));
		promo_tempatField.setValue(promoListEditorGrid.getSelectionModel().getSelected().get('promo_tempat'));
		promo_keteranganField.setValue(promoListEditorGrid.getSelectionModel().getSelected().get('promo_keterangan'));
		promo_tglmulaiField.setValue(promoListEditorGrid.getSelectionModel().getSelected().get('promo_tglmulai'));
		promo_tglselesaiField.setValue(promoListEditorGrid.getSelectionModel().getSelected().get('promo_tglselesai'));
		promo_diskonField.setValue(promoListEditorGrid.getSelectionModel().getSelected().get('promo_diskon'));
		promo_allprodukField.setValue(promoListEditorGrid.getSelectionModel().getSelected().get('promo_allproduk'));
		promo_allrawatField.setValue(promoListEditorGrid.getSelectionModel().getSelected().get('promo_allrawat'));
		
		if(promoListEditorGrid.getSelectionModel().getSelected().get('promo_allproduk')=='Y'){
			promo_allprodukField.setValue(true);
			promo_produkListEditorGrid.setDisabled(true);
		}else{
			promo_allprodukField.setValue(false);
			promo_produkListEditorGrid.setDisabled(false);
		}
		
		if(promoListEditorGrid.getSelectionModel().getSelected().get('promo_allrawat')=='Y'){
			promo_allrawatField.setValue(true);
			promo_perawatanListEditorGrid.setDisabled(true)
		}else{
			promo_allrawatField.setValue(false);
			promo_perawatanListEditorGrid.setDisabled(false);
		}
		
		promo_produk_DataStore.setBaseParam('master_id',get_pk_id());
		promo_perawatan_DataStore.setBaseParam('master_id',get_pk_id());
		promo_produk_DataStore.load();
		promo_perawatan_DataStore.load();
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_promo_form_valid(){
		return ( promo_acaraField.isValid());
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!promo_createWindow.isVisible()){
			
			post2db='CREATE';
			msg='created';
			promo_reset_form();
			promo_createWindow.show();
		} else {
			promo_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function promo_confirm_delete(){
		// only one promo is selected here
		if(promoListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', promo_delete);
		} else if(promoListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', promo_delete);
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
	function promo_confirm_update(){
		/* only one record is selected here */
		if(promoListEditorGrid.selModel.getCount() == 1) {
			
			post2db='UPDATE';
			msg='updated';
			promo_set_form();
			promo_createWindow.show();
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
	function promo_delete(btn){
		if(btn=='yes'){
			var selections = promoListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< promoListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.promo_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_promo&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							promo_DataStore.reload();
							break;
						default:
							Ext.MessageBox.show({
								title: 'Perhatian',
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
	promo_DataStore = new Ext.data.Store({
		id: 'promo_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_promo&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'promo_id'
		},[
			{name: 'promo_id', type: 'int', mapping: 'promo_id'}, 
			{name: 'promo_acara', type: 'string', mapping: 'promo_acara'}, 
			{name: 'promo_tempat', type: 'string', mapping: 'promo_tempat'}, 
			{name: 'promo_keterangan', type: 'string', mapping: 'promo_keterangan'}, 
			{name: 'promo_tglmulai', type: 'date', dateFormat: 'Y-m-d', mapping: 'promo_tglmulai'}, 
			{name: 'promo_tglselesai', type: 'date', dateFormat: 'Y-m-d', mapping: 'promo_tglselesai'}, 
			{name: 'promo_diskon', type: 'float', mapping: 'promo_diskon'}, 
			{name: 'promo_allproduk', type: 'string', mapping: 'promo_allproduk'}, 
			{name: 'promo_allrawat', type: 'string', mapping: 'promo_allrawat'}, 
			{name: 'promo_creator', type: 'string', mapping: 'promo_creator'}, 
			{name: 'promo_date_create', type: 'date', dateFormat: 'Y-m-d', mapping: 'promo_date_create'}, 
			{name: 'promo_update', type: 'string', mapping: 'promo_update'}, 
			{name: 'promo_date_update', type: 'date', dateFormat: 'Y-m-d', mapping: 'promo_date_update'}, 
			{name: 'promo_revised', type: 'int', mapping: 'promo_revised'} 
		]),
		sortInfo:{field: 'promo_id', direction: "DESC"}
	});
	/* End of Function */
    
  	/* Function for Identify of Window Column Model */
	promo_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'promo_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},
		{
			header: '<div align="center">' + 'Acara' + '</div>',
			dataIndex: 'promo_acara',
			width: 260,
			sortable: true,
			readOnly: true
		}, 
		{
			header: '<div align="center">' + 'Tempat' + '</div>',
			dataIndex: 'promo_tempat',
			width: 200,
			sortable: true,
			readOnly: true
		}, 
		{
			header: '<div align="center">' + 'Tgl Mulai' + '</div>',
			dataIndex: 'promo_tglmulai',
			width: 70,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			readOnly: true
		}, 
		{
			header: '<div align="center">' + 'Tgl Selesai' + '</div>',
			dataIndex: 'promo_tglselesai',
			width: 70,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			readOnly: true
		},
		{
			header: '<div align="center">' + 'Diskon (%)' + '</div>',
			dataIndex: 'promo_diskon',
			align: 'right',
			width: 100,
			sortable: true,
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true
		}, 
		{
			header: 'Creator',
			dataIndex: 'promo_creator',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Create on',
			dataIndex: 'promo_date_create',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Last Update by',
			dataIndex: 'promo_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Last Update on',
			dataIndex: 'promo_date_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Revised',
			dataIndex: 'promo_revised',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}	]);
	
	promo_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	promoListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'promoListEditorGrid',
		el: 'fp_promo',
		title: 'Daftar Promo',
		autoHeight: true,
		store: promo_DataStore, // DataStore
		cm: promo_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1220,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: promo_DataStore,
			displayInfo: true
		}),
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_PROMO'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<?php } ?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_PROMO'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: promo_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_PROMO'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			disabled: true,
			iconCls:'icon-delete',
			handler: promo_confirm_delete   // Confirm before deleting
		}, '-',
		<?php } ?>
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: promo_DataStore,
			params: {start: 0, limit: pageS},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						promo_DataStore.baseParams={task:'LIST',start: 0, limit: pageS};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Search By (aktif only)'});
				Ext.get(this.id).set({qtip:'- Acara<br>- Tempat<br>- Keterangan'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: promo_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: promo_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: promo_print  
		}
		]
	});
	promoListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	promo_ContextMenu = new Ext.menu.Menu({
		id: 'promo_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_PROMO'))){ ?>
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: promo_editContextMenu 
		},
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_PROMO'))){ ?>
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			disabled: true,
			iconCls:'icon-delete',
			handler: promo_confirm_delete 
		},
		<?php } ?>
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: promo_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: promo_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onpromo_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		promo_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		promo_SelectedRow=rowIndex;
		promo_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function promo_editContextMenu(){
		promoListEditorGrid.startEditing(promo_SelectedRow,1);
  	}
	/* End of Function */
  	
	promoListEditorGrid.addListener('rowcontextmenu', onpromo_ListEditGridContextMenu);
	promo_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	
	/* Identify  promo_id Field */
	promo_idField= new Ext.form.NumberField({
		id: 'promo_idField',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: false,
		hidden: true,
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  promo_acara Field */
	promo_acaraField= new Ext.form.TextField({
		id: 'promo_acaraField',
		fieldLabel: 'Acara <font color=RED>*</font>',
		maxLength: 250,
		allowBlank: false,
		anchor: '95%'
	});
	/* Identify  promo_tempat Field */
	promo_tempatField= new Ext.form.TextField({
		id: 'promo_tempatField',
		fieldLabel: 'Tempat',
		maxLength: 250,
		anchor: '95%'
	});
	
	/* Identify  promo_tempat Field */
	promo_keteranganField= new Ext.form.TextArea({
		id: 'promo_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 500,
		anchor: '95%'
	});
	
	/* Identify  promo_tglmulai Field */
	promo_tglmulaiField= new Ext.form.DateField({
		id: 'promo_tglmulaiField',
		fieldLabel: 'Tanggal',
		format : 'Y-m-d',
		anchor: '90%'
	});
	/* Identify  promo_tglselesai Field */
	promo_tglselesaiField= new Ext.form.DateField({
		id: 'promo_tglselesaiField',
		fieldLabel: 's/d',
		anchor: '90%'
	});

	/* Identify  promo_diskon Field */
	promo_diskonField= new Ext.form.NumberField({
		id: 'promo_diskonField',
		fieldLabel: 'Diskon (%)',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: true,
		anchor: '90%',
		maxLength: 2,
		maskRe: /([0-9]+)$/
	});
	/* Identify  promo_allproduk Field */
	promo_allprodukField= new Ext.form.Checkbox({
		id: 'promo_allprodukField',
		fieldLabel: 'Berlaku u/ semua Produk ?',
		anchor: '90%',
		triggerAction: 'all'	
	});
	/* Identify  promo_allrawat Field */
	promo_allrawatField= new Ext.form.Checkbox({
		id: 'promo_allrawatField',
		fieldLabel: 'Berlaku u/ semua Perawatan ?',
		anchor: '90%',
		triggerAction: 'all'	
	});
  	/*Fieldset Master*/
	promo_masterGroup = new Ext.form.FieldSet({
		title: 'Master',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		items:[
			{
				columnWidth:0.6,
				layout: 'form',
				border:false,
				items: [promo_acaraField, promo_tempatField, 
						{
						layout:'column',
						border:false,
						anchor:'90%',
						items:[
							{
								columnWidth:0.6,
								layout: 'form',
								border:false,
								defaultType: 'datefield',
								items: [						
									promo_tglmulaiField
								]
							},
							{
								columnWidth:0.4,
								layout: 'form',
								border:false,
								labelWidth:30,
								defaultType: 'datefield',
								items: [						
									promo_tglselesaiField
								]
							}						
							]
						}, promo_keteranganField] 
			},
			{
				columnWidth:0.4,
				layout: 'form',
				labelWidth: 180,
				border:false,
				items: [promo_diskonField, promo_allprodukField, promo_allrawatField,promo_idField] 
			}
			]
	
	});
	
		
		
	/*Detail Declaration */
		
	// Function for json reader of detail
	var promo_perawatan_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: 'rpromo_id'
	},[
			{name: 'rpromo_id', type: 'int', mapping: 'rpromo_id'}, 
			{name: 'rpromo_master', type: 'int', mapping: 'rpromo_master'}, 
			{name: 'rpromo_perawatan', type: 'int', mapping: 'rpromo_perawatan'}
	]);
	//eof
	
	//function for json writer of detail
	var promo_perawatan_writer = new Ext.data.JsonWriter({
		encode: true,
		writeAllFields: false
	});
	//eof
	
	/* Function for Retrieve DataStore of detail*/
	promo_perawatan_DataStore = new Ext.data.Store({
		id: 'promo_perawatan_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_promo&m=detail_promo_perawatan_list', 
			method: 'POST'
		}),
		reader: promo_perawatan_reader,
		baseParams:{master_id: get_pk_id(), start:0, limit: pageS },
		sortInfo:{field: 'rpromo_id', direction: "ASC"}
	});
	/* End of Function */

	//function for editor of detail
	var editor_promo_perawatan= new Ext.ux.grid.RowEditor({
        saveText: 'Update',
		listeners: {
			afteredit: function(){
				promo_perawatan_DataStore.commitChanges();
			}
		}
    });
	//eof
	
	cbo_produk_listDataStore = new Ext.data.Store({
	id: 'cbo_produk_listDataStore',
	proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_promo&m=get_produk_list', 
			method: 'POST'
		}), baseParams: {start: 0, limit: pageS},
			reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'produk_id'
		},[
			{name: 'produk_id', type: 'int', mapping: 'produk_id'},
			{name: 'produk_kode', type: 'string', mapping: 'produk_kode'},
			{name: 'produk_group', type: 'string', mapping: 'group_nama'},
			{name: 'produk_kategori', type: 'string', mapping: 'kategori_nama'},
			{name: 'produk_nama', type: 'string', mapping: 'produk_nama'}
		]),
	sortInfo:{field: 'produk_nama', direction: "ASC"}
	});
	
	cbo_rawat_listDataStore = new Ext.data.Store({
		id: 'cbo_rawat_listDataStore',
		proxy: new Ext.data.HttpProxy({
				url: 'index.php?c=c_promo&m=get_rawat_list', 
				method: 'POST'
			}), baseParams: {start: 0, limit: pageS},
				reader: new Ext.data.JsonReader({
				root: 'results',
				totalProperty: 'total',
				id: 'rawat_id'
			},[
			/* dataIndex => insert intotbl_usersColumnModel, Mapping => for initiate table column */ 
				{name: 'rawat_id', type: 'int', mapping: 'rawat_id'},
				{name: 'rawat_kode', type: 'string', mapping: 'rawat_kode'},
				{name: 'rawat_nama', type: 'string', mapping: 'rawat_nama'}
			]),
		sortInfo:{field: 'rawat_nama', direction: "ASC"}
	});
	
	
	var promo_produk_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span>{produk_kode}| <b>{produk_nama}</b></span>',
		'</div></tpl>'
    );
	
	var promo_rawat_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span>{rawat_kode}| <b>{rawat_nama}</b></span>',
		'</div></tpl>'
    );
	
	Ext.util.Format.comboRenderer = function(combo){
		
		cbo_rawat_listDataStore.load({params:{query:get_pk_id()}});
		cbo_produk_listDataStore.load({params:{query:get_pk_id()}});
		return function(value){
			var record = combo.findRecord(combo.valueField, value);
			return record ? record.get(combo.displayField) : combo.valueNotFoundText;
		}
	}
	
	var combo_promo_produk=new Ext.form.ComboBox({
			store: cbo_produk_listDataStore,
			mode: 'remote',
			typeAhead: true,
			displayField: 'produk_nama',
			valueField: 'produk_id',
			typeAhead: false,
			loadingText: 'Searching...',
			pageSize:pageS,
			hideTrigger:false,
			tpl: promo_produk_tpl,
			//applyTo: 'search',
			itemSelector: 'div.search-item',
			triggerAction: 'all',
			lazyRender:true,
			listClass: 'x-combo-list-small',
			anchor: '95%'

	});
	
	var combo_promo_rawat=new Ext.form.ComboBox({
			store: cbo_rawat_listDataStore,
			mode: 'remote',
			typeAhead: true,
			displayField: 'rawat_nama',
			valueField: 'rawat_id',
			typeAhead: false,
			loadingText: 'Searching...',
			pageSize:pageS,
			hideTrigger:false,
			tpl: promo_rawat_tpl,
			//applyTo: 'search',
			itemSelector: 'div.search-item',
			triggerAction: 'all',
			lazyRender:true,
			listClass: 'x-combo-list-small',
			anchor: '95%'

	});
	
	//function of detail add
	function promo_perawatan_add(){
		var edit_promo_perawatan= new promo_perawatanListEditorGrid.store.recordType({
			rpromo_id		:'',		
			rpromo_master	:'',		
			rpromo_perawatan:null
		});
		editor_promo_perawatan.stopEditing();
		promo_perawatan_DataStore.insert(0, edit_promo_perawatan);
		promo_perawatanListEditorGrid.getView().refresh();
		promo_perawatanListEditorGrid.getSelectionModel().selectRow(0);
		editor_promo_perawatan.startEditing(0);
	}
	//eof
	
	//declaration of detail coloumn model
	promo_perawatan_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			dataIndex: 'rpromo_id',
			readOnly: true,
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},
		{
			header: 'Perawatan',
			dataIndex: 'rpromo_perawatan',
			width: 150,
			sortable: true,
			editor: combo_promo_rawat,
			renderer: Ext.util.Format.comboRenderer(combo_promo_rawat)
		}
		]
	);
	promo_perawatan_ColumnModel.defaultSortable= true;
	//eof
	
	
	
	//declaration of detail list editor grid
	promo_perawatanListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'promo_perawatanListEditorGrid',
		el: 'fp_promo_perawatan',
		title: 'Perawatan',
		height: 250,
		width: 690,
		autoScroll: true,
		store: promo_perawatan_DataStore, // DataStore
		colModel: promo_perawatan_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 5 5 5',
		plugins: [editor_promo_perawatan],
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true}
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_PROMO'))){ ?>
		,
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: promo_perawatan_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			handler: promo_perawatan_confirm_delete
		}
		]
		<?php } ?>
	});
	//eof
	
	//function for insert detail
	function promo_perawatan_insert(pkid){
				
		var rpromo_id = [];
        var rpromo_perawatan = [];
       
        if(promo_perawatan_DataStore.getCount()>0){
            for(i=0; i<promo_perawatan_DataStore.getCount();i++){
                if((/^\d+$/.test(promo_perawatan_DataStore.getAt(i).data.rpromo_perawatan))
				   && promo_perawatan_DataStore.getAt(i).data.rpromo_perawatan!==undefined
				   && promo_perawatan_DataStore.getAt(i).data.rpromo_perawatan!==''
				   && promo_perawatan_DataStore.getAt(i).data.rpromo_perawatan!==0){
                    
					if(promo_perawatan_DataStore.getAt(i).data.rpromo_id==undefined ||
					   promo_perawatan_DataStore.getAt(i).data.rpromo_id==''){
						promo_perawatan_DataStore.getAt(i).data.rpromo_id=0;
					}
					
                  	rpromo_id.push(promo_perawatan_DataStore.getAt(i).data.rpromo_id);
					rpromo_perawatan.push(promo_perawatan_DataStore.getAt(i).data.rpromo_perawatan);
                }
            }
			
			var encoded_array_rpromo_id = Ext.encode(rpromo_id);
			var encoded_array_rpromo_perawatan = Ext.encode(rpromo_perawatan);
				
			Ext.Ajax.request({
				waitMsg: 'Mohon tunggu...',
				url: 'index.php?c=c_promo&m=detail_promo_perawatan_insert',
				params:{
					rpromo_id		: encoded_array_rpromo_id,
					rpromo_master	: pkid, 
					rpromo_perawatan	: encoded_array_rpromo_perawatan
				},
				success:function(response){
					var result=eval(response.responseText);
					promo_DataStore.reload();
				},
				failure: function(response){
					Ext.MessageBox.hide();
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
	//eof
	
	
	/* Function for Delete Confirm of detail */
	function promo_perawatan_confirm_delete(){
		// only one record is selected here
		if(promo_perawatanListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', promo_perawatan_delete);
		} else if(promo_perawatanListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', promo_perawatan_delete);
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
	//eof
	
	//function for Delete of detail
	function promo_perawatan_delete(btn){
		if(btn=='yes'){
			var s = promo_perawatanListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, r; r = s[i]; i++){
				promo_perawatan_DataStore.remove(r);
			}
		} 
		promo_perawatan_DataStore.commitChanges();
	}
	//eof
	// EOF DETAIL
	
	/*Detail Declaration of detail produk*/
		
	// Function for json reader of detail
	var promo_produk_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: 'ipromo_id'
	},[
			{name: 'ipromo_id', type: 'int', mapping: 'ipromo_id'}, 
			{name: 'ipromo_master', type: 'int', mapping: 'ipromo_master'}, 
			{name: 'ipromo_produk', type: 'int', mapping: 'ipromo_produk'}
	]);
	//eof
	
	//function for json writer of detail
	var promo_produk_writer = new Ext.data.JsonWriter({
		encode: true,
		writeAllFields: false
	});
	//eof
	
	/* Function for Retrieve DataStore of detail*/
	promo_produk_DataStore = new Ext.data.Store({
		id: 'promo_produk_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_promo&m=detail_promo_produk_list', 
			method: 'POST'
		}),
		reader: promo_produk_reader,
		baseParams:{master_id: get_pk_id(), start:0, limit: pageS},
		sortInfo:{field: 'ipromo_id', direction: "ASC"}
	});
	/* End of Function */
	
	//function for editor of detail
	var editor_promo_produk= new Ext.ux.grid.RowEditor({
        saveText: 'Update',
		listeners: {
			afteredit: function(){
				promo_produk_DataStore.commitChanges();
			}
		}
    });
	//eof
	
	
	//function of detail add
	function promo_produk_add(){
		var edit_promo_produk= new promo_produkListEditorGrid.store.recordType({
			ipromo_id	:'',		
			ipromo_master	: null,		
			ipromo_produk	: null	
		});
		editor_promo_produk.stopEditing();
		promo_produk_DataStore.insert(0, edit_promo_produk);
		promo_produkListEditorGrid.getView().refresh();
		promo_produkListEditorGrid.getSelectionModel().selectRow(0);
		editor_promo_produk.startEditing(0);
	}
	
	//declaration of detail coloumn model
	promo_produk_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			dataIndex: 'ipromo_id',
			readOnly: true,
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},
		{
			header: 'Produk',
			dataIndex: 'ipromo_produk',
			width: 250,
			sortable: true,
			editor: combo_promo_produk,
			renderer: Ext.util.Format.comboRenderer(combo_promo_produk)
		}]
	);
	promo_produk_ColumnModel.defaultSortable= true;
	//eof
	
	
	//declaration of detail list editor grid
	promo_produkListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'promo_produkListEditorGrid',
		el: 'fp_promo_produk',
		title: 'Produk',
		height: 250,
		width: 690,
		autoScroll: true,
		store: promo_produk_DataStore, // DataStore
		colModel: promo_produk_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 5 5 5',
		plugins: [editor_promo_produk],
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true}
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_PROMO'))){ ?>
		,
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: promo_produk_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			handler: promo_produk_confirm_delete
		}
		]
		<?php } ?>
	});
	//eof
		
	//function for insert detail
	function promo_produk_insert(pkid){
				
		var ipromo_id = [];
        var ipromo_produk = [];
       
        if(promo_produk_DataStore.getCount()>0){
            for(i=0; i<promo_produk_DataStore.getCount();i++){
                if((/^\d+$/.test(promo_produk_DataStore.getAt(i).data.ipromo_produk))
				   && promo_produk_DataStore.getAt(i).data.ipromo_produk!==undefined
				   && promo_produk_DataStore.getAt(i).data.ipromo_produk!==''
				   && promo_produk_DataStore.getAt(i).data.ipromo_produk!==0){
                    
					if(promo_produk_DataStore.getAt(i).data.ipromo_id==undefined ||
					   promo_produk_DataStore.getAt(i).data.ipromo_id==''){
						promo_produk_DataStore.getAt(i).data.ipromo_id=0;
					}
					
                  	ipromo_id.push(promo_produk_DataStore.getAt(i).data.ipromo_id);
					ipromo_produk.push(promo_produk_DataStore.getAt(i).data.ipromo_produk);
                }
            }
			
			var encoded_array_ipromo_id = Ext.encode(ipromo_id);
			var encoded_array_ipromo_produk = Ext.encode(ipromo_produk);
				
			Ext.Ajax.request({
				waitMsg: 'Mohon tunggu...',
				url: 'index.php?c=c_promo&m=detail_promo_produk_insert',
				params:{
					ipromo_id		: encoded_array_ipromo_id,
					ipromo_master	: pkid, 
					ipromo_produk	: encoded_array_ipromo_produk
				},
				success:function(response){
					var result=eval(response.responseText);
					promo_perawatan_insert(pkid)
				},
				failure: function(response){
					Ext.MessageBox.hide();
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
	//eof
	
	
	
	/* Function for Delete Confirm of detail */
	function promo_produk_confirm_delete(){
		// only one record is selected here
		if(promo_produkListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', promo_produk_delete);
		} else if(promo_produkListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', promo_produk_delete);
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
	//eof
	
	//function for Delete of detail
	function promo_produk_delete(btn){
		if(btn=='yes'){
			var s = promo_produkListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, r; r = s[i]; i++){
				promo_produk_DataStore.remove(r);
			}
		}  
		promo_produk_DataStore.commitChanges();
	}
	//eof
	
		
	var detail_tab_promo = new Ext.TabPanel({
		activeTab: 0,
		items: [promo_perawatanListEditorGrid,promo_produkListEditorGrid]
	});
	
	// EOF detail
	
	/* Function for retrieve create Window Panel*/ 
	promo_createForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 700,        
		items: [promo_masterGroup,detail_tab_promo]
		,
		buttons: [
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_PROMO'))){ ?>
			{
				text: 'Save and Close',
				handler: promo_create
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					promo_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	promo_createWindow= new Ext.Window({
		id: 'promo_createWindow',
		title: post2db+'Promo',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_promo_create',
		items: promo_createForm
	});
	/* End Window */
	
	/* Function for action list search */
	function promo_list_search(){
		// render according to a SQL date format.
		var promo_acara_search=null;
		var promo_tempat_search=null;
		var promo_tglmulai_search_date="";
		var promo_tglselesai_search_date="";
		var promo_diskon_search=null;

		if(promo_acaraSearchField.getValue()!==null){promo_acara_search=promo_acaraSearchField.getValue();}
		if(promo_tempatSearchField.getValue()!==null){promo_tempat_search=promo_tempatSearchField.getValue();}
		if(promo_tglmulaiSearchField.getValue()!==""){promo_tglmulai_search_date=promo_tglmulaiSearchField.getValue().format('Y-m-d');}
		if(promo_tglselesaiSearchField.getValue()!==""){promo_tglselesai_search_date=promo_tglselesaiSearchField.getValue().format('Y-m-d');}
		if(promo_diskonSearchField.getValue()!==null){promo_diskon_search=promo_diskonSearchField.getValue();}
		// change the store parameters
		promo_DataStore.baseParams = {
			task: 'SEARCH',
			promo_acara		:	promo_acara_search, 
			promo_tempat	:	promo_tempat_search, 
			promo_tglmulai	:	promo_tglmulai_search_date, 
			promo_tglselesai	:	promo_tglselesai_search_date, 
			promo_diskon	:	promo_diskon_search
		};
		// Cause the datastore to do another query : 
		promo_DataStore.reload({params: {start: 0, limit: pageS}});
	}
		
	/* Function for reset search result */
	function promo_reset_search(){
		// reset the store parameters
		promo_DataStore.baseParams = { task: 'LIST', start: 0, limit: pageS};
		promo_DataStore.reload({params: {start: 0, limit: pageS}});
		promo_searchWindow.close();
	};
	/* End of Fuction */

	function promo_reset_SearchForm(){
		promo_acaraSearchField.reset();
		promo_tempatSearchField.reset();
		promo_tglmulaiSearchField.reset();
		promo_tglselesaiSearchField.reset();
		promo_diskonSearchField.reset();
	}

	
	/* Identify  promo_acara Search Field */
	promo_acaraSearchField= new Ext.form.TextField({
		id: 'promo_acaraSearchField',
		fieldLabel: 'Nama Acara',
		maxLength: 250,
		anchor: '95%'
	
	});
	/* Identify  promo_tempat Search Field */
	promo_tempatSearchField= new Ext.form.TextField({
		id: 'promo_tempatSearchField',
		fieldLabel: 'Tempat',
		maxLength: 250,
		anchor: '95%'
	
	});
	/* Identify  promo_tglmulai Search Field */
	promo_tglmulaiSearchField= new Ext.form.DateField({
		id: 'promo_tglmulaiSearchField',
		fieldLabel: 'Tanggal mulai',
		format : 'Y-m-d'
	
	});
	/* Identify  promo_tglselesai Search Field */
	promo_tglselesaiSearchField= new Ext.form.DateField({
		id: 'promo_tglselesaiSearchField',
		fieldLabel: 'Tanggal selesai',
		format : 'Y-m-d'
	
	});
	
	/* Identify  promo_diskon Search Field */
	promo_diskonSearchField= new Ext.form.NumberField({
		id: 'promo_diskonSearchField',
		fieldLabel: 'Diskon (%)',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: true,
		anchor: '40%',
		maxLength: 2,
		maskRe: /([0-9]+)$/
	
	});
	    
	/* Function for retrieve search Form Panel */
	promo_searchForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 450,        
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [promo_acaraSearchField, promo_tempatSearchField, promo_tglmulaiSearchField, 
						promo_tglselesaiSearchField,  promo_diskonSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: promo_list_search
			},{
				text: 'Close',
				handler: function(){
					promo_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	promo_searchWindow = new Ext.Window({
		title: 'Pencarian Promo',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_promo_search',
		items: promo_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!promo_searchWindow.isVisible()){
			promo_reset_SearchForm();
			promo_searchWindow.show();
		} else {
			promo_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function promo_print(){
		var searchquery = "";

		var promo_acara_print=null;
		var promo_tempat_print=null;
		var promo_tglmulai_print_date="";
		var promo_tglselesai_print_date="";
		var promo_diskon_print=null;
		var win;              
		// check if we do have some search data...
		if(promo_DataStore.baseParams.query!==null){searchquery = promo_DataStore.baseParams.query;}
		if(promo_DataStore.baseParams.promo_acara!==null){promo_acara_print = promo_DataStore.baseParams.promo_acara;}
		if(promo_DataStore.baseParams.promo_tempat!==null){promo_tempat_print = promo_DataStore.baseParams.promo_tempat;}
		if(promo_DataStore.baseParams.promo_tglmulai!==""){promo_tglmulai_print_date = promo_DataStore.baseParams.promo_tglmulai;}
		if(promo_DataStore.baseParams.promo_tglselesai!==""){promo_tglselesai_print_date = promo_DataStore.baseParams.promo_tglselesai;}
		if(promo_DataStore.baseParams.promo_diskon!==null){promo_diskon_print = promo_DataStore.baseParams.promo_diskon;}
		

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_promo&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		
			promo_acara : promo_acara_print,
			promo_tempat : promo_tempat_print,
		  	promo_tglmulai : promo_tglmulai_print_date, 
		  	promo_tglselesai : promo_tglselesai_print_date, 
			promo_diskon : promo_diskon_print,
		  	currentlisting: promo_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/print_promolist.html','promolist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
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
	function promo_export_excel(){
		var searchquery = "";
		var promo_acara_2excel=null;
		var promo_tempat_2excel=null;
		var promo_tglmulai_2excel_date="";
		var promo_tglselesai_2excel_date="";
		var promo_diskon_2excel=null;
		var win;              
		// check if we do have some search data...
		if(promo_DataStore.baseParams.query!==null){searchquery = promo_DataStore.baseParams.query;}
		if(promo_DataStore.baseParams.promo_acara!==null){promo_acara_2excel = promo_DataStore.baseParams.promo_acara;}
		if(promo_DataStore.baseParams.promo_tempat!==null){promo_tempat_2excel = promo_DataStore.baseParams.promo_tempat;}
		if(promo_DataStore.baseParams.promo_tglmulai!==""){promo_tglmulai_2excel_date = promo_DataStore.baseParams.promo_tglmulai;}
		if(promo_DataStore.baseParams.promo_tglselesai!==""){promo_tglselesai_2excel_date = promo_DataStore.baseParams.promo_tglselesai;}
		if(promo_DataStore.baseParams.promo_diskon!==null){promo_diskon_2excel = promo_DataStore.baseParams.promo_diskon;}
		

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_promo&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		
			promo_acara : promo_acara_2excel,
			promo_tempat : promo_tempat_2excel,
		  	promo_tglmulai : promo_tglmulai_2excel_date, 
		  	promo_tglselesai : promo_tglselesai_2excel_date, 
			promo_diskon : promo_diskon_2excel,
		  	currentlisting: promo_DataStore.baseParams.task // this tells us if we are searching or not
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
	
	promo_produkListEditorGrid.setDisabled(false);
	promo_perawatanListEditorGrid.setDisabled(false);
	
	promo_allprodukField.on("check",function(){
		if(promo_allprodukField.getValue()==true)
			promo_produkListEditorGrid.setDisabled(true);
		else
			promo_produkListEditorGrid.setDisabled(false);
	});
	
	promo_allrawatField.on("check",function(){
		if(promo_allrawatField.getValue()==true)
			promo_perawatanListEditorGrid.setDisabled(true);
		else
			promo_perawatanListEditorGrid.setDisabled(false);
	});
	
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_promo"></div>
         <div id="fp_promo_perawatan"></div>
         <div id="fp_promo_produk"></div>
		<div id="elwindow_promo_create"></div>
        <div id="elwindow_promo_search"></div>
    </div>
</div>
</body>