<?
/* 	
	GIOV Solution - Keep IT Simple
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
var master_retur_beli_DataStore;
var master_retur_beli_ColumnModel;
var master_retur_beliListEditorGrid;
var master_retur_beli_createForm;
var master_retur_beli_createWindow;
var master_retur_beli_searchForm;
var master_retur_beli_searchWindow;
var master_retur_beli_SelectedRow;
var master_retur_beli_ContextMenu;
//for detail data
var detail_retur_beli_DataStor;
var detail_retur_beliListEditorGrid;
var detail_retur_beli_ColumnModel;
var detail_retur_beli_proxy;
var detail_retur_beli_writer;
var detail_retur_beli_reader;
var editor_detail_retur_beli;

//declare konstant
var post2db = '';
var msg = '';
var pageS=15;
var today=new Date().format('Y-m-d');

/* declare variable here for Field*/
var rbeli_idField;
var rbeli_nobuktiField;
var rbeli_terimaField;
var rbeli_supplierField;
var rbeli_tanggalField;
var rbeli_keteranganField;
var rbeli_idSearchField;
var rbeli_terimaSearchField;
var rbeli_supplierSearchField;
var rbeli_tgl_awalSearchField;
var rbeli_keteranganSearchField;
var rbeli_statusSearchField;

var rbeli_button_saveField;
var rbeli_button_saveprintField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  
  	/* Function for add data, open window create form */
	function master_retur_beli_create(opsi){
		
		if(detail_retur_beli_DataStore.getCount()<1){
			
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Data detail harus ada minimal 1 (satu)',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
			
		}else if(is_master_retur_beli_form_valid()){	

		var rbeli_id_create_pk=null; 
		var rbeli_nobukti_create="";
		var rbeli_terima_create=null; 
		var rbeli_supplier_create=null; 
		var rbeli_tanggal_create_date=""; 
		var rbeli_keterangan_create=null; 
		var rbeli_status_create=null;

		if(rbeli_idField.getValue()!== null){rbeli_id_create_pk = rbeli_idField.getValue();}else{rbeli_id_create_pk=get_pk_id();} 
		if(rbeli_nobuktiField.getValue()!== ""){rbeli_nobukti_create = rbeli_nobuktiField.getValue();} 
		if(rbeli_terimaField.getValue()!== null){rbeli_terima_create = rbeli_terimaField.getValue();} 
		if(rbeli_supplierField.getValue()!== null){rbeli_supplier_create = rbeli_supplier_idField.getValue();} 
		if(rbeli_tanggalField.getValue()!== ""){rbeli_tanggal_create_date = rbeli_tanggalField.getValue().format('Y-m-d');} 
		if(rbeli_keteranganField.getValue()!== null){rbeli_keterangan_create = rbeli_keteranganField.getValue();} 
		if(rbeli_statusField.getValue()!== null){rbeli_status_create = rbeli_statusField.getValue();} 

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_master_retur_beli&m=get_action',
			params: {
				task				: post2db,
				rbeli_id			: rbeli_id_create_pk, 
				rbeli_nobukti		: rbeli_nobukti_create, 
				rbeli_terima		: rbeli_terima_create, 
				rbeli_supplier		: rbeli_supplier_create, 
				rbeli_tanggal		: rbeli_tanggal_create_date, 
				rbeli_keterangan	: rbeli_keterangan_create,
				rbeli_status		: rbeli_status_create
			}, 
			success: function(response){             
				var result=eval(response.responseText);
				if(result!==0){
						detail_retur_beli_insert(result,opsi)
						Ext.MessageBox.alert(post2db+' OK','Data Retur Pembelian berhasil disimpan.');
						master_retur_beli_createWindow.hide();
				}else{
						Ext.MessageBox.show({
						   title: 'Warning',
						   //msg: 'We could\'t not '+msg+' the Master_retur_beli.',
						   msg: 'Data Retur Pembelian tidak bisa disimpan !',
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
				//msg: 'Isian tidak valid!.',
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
			return master_retur_beliListEditorGrid.getSelectionModel().getSelected().get('rbeli_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function master_retur_beli_reset_form(){
		rbeli_idField.reset();
		rbeli_idField.setValue(null);
		rbeli_nobuktiField.reset();
		rbeli_nobuktiField.setValue(null);
		rbeli_terimaField.reset();
		rbeli_terimaField.setValue(null);
		rbeli_supplierField.reset();
		rbeli_supplierField.setValue(null);
		//rbeli_tanggalField.reset();
		rbeli_tanggalField.setValue(today);
		rbeli_keteranganField.reset();
		rbeli_keteranganField.setValue(null);
		rbeli_statusField.reset();
		rbeli_statusField.setValue('Terbuka');
		cbo_satuan_DataStore.setBaseParam('task','detail');
		cbo_satuan_DataStore.setBaseParam('master_id',-1);
		cbo_satuan_DataStore.load();
		cbo_produk_DataStore.setBaseParam('master_id',-1);
		cbo_produk_DataStore.setBaseParam('task','detail');
		cbo_produk_DataStore.load({
			callback: function(r,opt,success){
				if(success==true){
					detail_retur_beli_DataStore.setBaseParam('master_id',-1);
					detail_retur_beli_DataStore.load();
				}
			}
		});
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function master_retur_beli_set_form(){
		rbeli_idField.setValue(master_retur_beliListEditorGrid.getSelectionModel().getSelected().get('rbeli_id'));
		rbeli_nobuktiField.setValue(master_retur_beliListEditorGrid.getSelectionModel().getSelected().get('rbeli_nobukti'));
		rbeli_terimaField.setValue(master_retur_beliListEditorGrid.getSelectionModel().getSelected().get('rbeli_terima'));
		rbeli_terima_idField.setValue(master_retur_beliListEditorGrid.getSelectionModel().getSelected().get('rbeli_terima_id'));
		rbeli_supplierField.setValue(master_retur_beliListEditorGrid.getSelectionModel().getSelected().get('rbeli_supplier'));
		rbeli_supplier_idField.setValue(master_retur_beliListEditorGrid.getSelectionModel().getSelected().get('rbeli_supplier_id'));
		rbeli_tanggalField.setValue(master_retur_beliListEditorGrid.getSelectionModel().getSelected().get('rbeli_tanggal'));
		rbeli_keteranganField.setValue(master_retur_beliListEditorGrid.getSelectionModel().getSelected().get('rbeli_keterangan'));
		rbeli_statusField.setValue(master_retur_beliListEditorGrid.getSelectionModel().getSelected().get('rbeli_status'));
		cbo_satuan_DataStore.setBaseParam('task','detail');
		cbo_satuan_DataStore.setBaseParam('master_id',get_pk_id());
		cbo_satuan_DataStore.load();
		
		rbeli_button_saveField.setDisabled(true);
		rbeli_button_saveprintField.setDisabled(true);
								
		cbo_produk_DataStore.setBaseParam('master_id',get_pk_id());
		cbo_produk_DataStore.setBaseParam('task','detail');
		cbo_produk_DataStore.load({
			callback: function(r,opt,success){
				if(success==true){
					detail_retur_beli_DataStore.setBaseParam('master_id',get_pk_id());
					detail_retur_beli_DataStore.load({
						callback: function(r,opt,success){
							if(success==true){
								rbeli_button_saveField.setDisabled(false);
								rbeli_button_saveprintField.setDisabled(false);
								Ext.MessageBox.hide();
							}
						}
					});
				}
			}
		});
		
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_master_retur_beli_form_valid(){
		return (rbeli_terimaField.isValid());
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!master_retur_beli_createWindow.isVisible()){
			post2db='CREATE';
			msg='created';
			master_retur_beli_reset_form();
			master_retur_beli_createWindow.show();
		} else {
			master_retur_beli_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function master_retur_beli_confirm_delete(){
		// only one master_retur_beli is selected here
		if(master_retur_beliListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', master_retur_beli_delete);
		} else if(master_retur_beliListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data-data ini?', master_retur_beli_delete);
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				//msg: 'Tidak ada yang dipilih untuk dihapus',
				msg: 'Anda belum memilih data yang akan dihapus',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
  
	/* Function for Update Confirm */
	function master_retur_beli_confirm_update(){
		/* only one record is selected here */
		if(master_retur_beliListEditorGrid.selModel.getCount() == 1) {
			post2db='UPDATE';
			msg='updated';
			master_retur_beli_set_form();
			master_retur_beli_createWindow.show();
			Ext.MessageBox.show({
			   msg: 'Sedang memuat data, mohon tunggu...',
			   progressText: 'proses...',
			   width:350,
			   wait:true
			});
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				//msg: 'Tidak ada data yang dipilih untuk diedit',
				msg: 'Anda belum memilih data yang akan diubah',	
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
  
  	/* Function for Delete Record */
	function master_retur_beli_delete(btn){
		if(btn=='yes'){
			var selections = master_retur_beliListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< master_retur_beliListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.rbeli_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_master_retur_beli&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							master_retur_beli_DataStore.reload();
							break;
						default:
							Ext.MessageBox.show({
								title: 'Warning',
								//msg: 'Tidak bisa menghapus data yang diplih',
								msg: 'Anda belum memilih data yang akan dihapus',
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
	master_retur_beli_DataStore = new Ext.data.Store({
		id: 'master_retur_beli_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_retur_beli&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST",start: 0, limit: pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'rbeli_id'
		},[
			{name: 'rbeli_id', type: 'int', mapping: 'rbeli_id'}, 
			{name: 'rbeli_nobukti', type: 'string', mapping: 'no_bukti'}, 
			{name: 'rbeli_terima_id', type: 'int', mapping: 'rbeli_terima'}, 
			{name: 'rbeli_terima', type: 'string', mapping: 'no_terima'}, 
			{name: 'rbeli_order', type: 'string', mapping: 'no_order'}, 
			{name: 'rbeli_supplier', type: 'string', mapping: 'supplier_nama'}, 
			{name: 'rbeli_jumlah', type: 'float', mapping: 'jumlah_barang'}, 
			{name: 'rbeli_total', type: 'float', mapping: 'total_nilai'}, 
			{name: 'rbeli_supplier_id', type: 'int', mapping: 'supplier_id'}, 
			{name: 'rbeli_tanggal', type: 'date', dateFormat: 'Y-m-d', mapping: 'tanggal'}, 
			{name: 'rbeli_keterangan', type: 'string', mapping: 'rbeli_keterangan'}, 
			{name: 'rbeli_status', type: 'string', mapping: 'rbeli_status'}, 
			{name: 'rbeli_creator', type: 'string', mapping: 'rbeli_creator'}, 
			{name: 'rbeli_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'rbeli_date_create'}, 
			{name: 'rbeli_update', type: 'string', mapping: 'rbeli_update'}, 
			{name: 'rbeli_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'rbeli_date_update'}, 
			{name: 'rbeli_revised', type: 'int', mapping: 'rbeli_revised'} 
		]),
		sortInfo:{field: 'rbeli_id', direction: "DESC"}
	});
	/* End of Function */
	
	cbo_rbeli_terimabeli_DataSore = new Ext.data.Store({
		id: 'cbo_rbeli_terimabeli_DataSore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_retur_beli&m=get_terima_list', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit:pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'terima_id'
		},[
			{name: 'terima_id', type: 'int', mapping: 'terima_id'},
			{name: 'terima_no', type: 'string', mapping: 'terima_no'},
			{name: 'terima_tanggal', type: 'date', dateFormat: 'Y-m-d', mapping: 'terima_tanggal'},
			{name: 'terima_supplier', type: 'string', mapping: 'supplier_nama'},
			{name: 'terima_order', type: 'string', mapping: 'order_no'}
		]),
		sortInfo:{field: 'terima_no', direction: "ASC"}
	});
	
	var rbeli_terimabeli_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{terima_no}</b><br /></span>',
            'Tgl-Penerimaan : {terima_tanggal:date("M j, Y")}<br>',
			'Supplier: {terima_supplier}<br/>',
			'No Order: {terima_order}',
        '</div></tpl>'
    );
	
  	/* Function for Identify of Window Column Model */
	master_retur_beli_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: 'ID',
			dataIndex: 'rbeli_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			readOnly: true,
			hidden: true
		},
		{
			header: '<div align="center">Tanggal</div>',
			dataIndex: 'rbeli_tanggal',
			width: 70,	//100,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			readOnly: true
		},
		{
			header: '<div align="center">No Retur</div>',
			dataIndex: 'rbeli_nobukti',
			width: 80,
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">No LBM</div>',
			dataIndex: 'rbeli_terima',
			width: 80,
			sortable: true,
			readOnly: true
		}, 
		{
			header: '<div align="center">No PO</div>',
			dataIndex: 'rbeli_order',
			width: 80,
			sortable: true,
			readOnly: true
		}, 
		{
			header: '<div align="center">Supplier</div>',
			dataIndex: 'rbeli_supplier',
			width: 200,
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">Jml Item</div>',
			align: 'right',
			dataIndex: 'rbeli_jumlah',
			width: 60,
			sortable: true,
			readOnly: true,
			renderer: Ext.util.Format.numberRenderer('0,000')
		},
		{
			header: '<div align="center">Tot Nilai (Rp)</div>',
			dataIndex: 'rbeli_total',
			width: 100,
			align: 'right',
			sortable: true,
			readOnly: true,
			renderer: Ext.util.Format.numberRenderer('0,000')
		},
		{
			header: '<div align="center">Keterangan</div>',
			dataIndex: 'rbeli_keterangan',
			width: 150,
			sortable: true,
			readOnly: true
		}, 
		{
			header: '<div align="center">' + 'Stat Dok' + '</div>',
			dataIndex: 'rbeli_status',
			width: 60
		}, 
		{
			header: 'Creator',
			dataIndex: 'rbeli_creator',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Create on',
			dataIndex: 'rbeli_date_create',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Last Update by',
			dataIndex: 'rbeli_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Last Update on',
			dataIndex: 'rbeli_date_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Revised',
			dataIndex: 'rbeli_revised',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}	]);
	
	master_retur_beli_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	master_retur_beliListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'master_retur_beliListEditorGrid',
		el: 'fp_master_retur_beli',
		title: 'Daftar Retur Pembelian',
		autoHeight: true,
		store: master_retur_beli_DataStore, // DataStore
		cm: master_retur_beli_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1220,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: master_retur_beli_DataStore,
			displayInfo: true
		}),
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_RETURBELI'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<?php } ?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_RETURBELI'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: master_retur_beli_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_RETURBELI'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: master_retur_beli_confirm_delete   // Confirm before deleting
		}, '-', 
		<?php } ?>
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: master_retur_beli_DataStore,
			params: {start: 0, limit: pageS},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						master_retur_beli_DataStore.baseParams={task:'LIST',start: 0, limit: pageS};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Search By (aktif only)'});
				Ext.get(this.id).set({qtip:'- No Retur<br>- No PO<br>- No LBM<br>- Supplier<br>'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: master_retur_beli_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: master_retur_beli_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: master_retur_beli_print  
		}
		]
	});
	master_retur_beliListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	master_retur_beli_ContextMenu = new Ext.menu.Menu({
		id: 'master_retur_beli_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_RETURBELI'))){ ?>
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: master_retur_beli_confirm_update 
		},
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_RETURBELI'))){ ?>
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			handler: master_retur_beli_confirm_delete 
		},
		<?php } ?>
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: master_retur_beli_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: master_retur_beli_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onmaster_retur_beli_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		master_retur_beli_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		master_retur_beli_SelectedRow=rowIndex;
		master_retur_beli_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function master_retur_beli_editContextMenu(){
		master_retur_beliListEditorGrid.startEditing(master_retur_beli_SelectedRow,1);
  	}
	/* End of Function */
  	
		
	/* Identify  rbeli_id Field */
	rbeli_idField= new Ext.form.NumberField({
		id: 'rbeli_idField',
		allowNegatife : false,
		blankText: '0',
		allowBlank: false,
		allowDecimals: false,
		hidden: true,
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	rbeli_nobuktiField= new Ext.form.TextField({
		id: 'rbeli_nobuktiField',
		fieldLabel: 'No Retur',
		emptyText: '(Auto)',
		readOnly: true,
		maxLength: 100,
		anchor: '95%'
	});
	/* Identify  rbeli_terima Field */
	rbeli_terimaField= new Ext.form.ComboBox({
		id: 'rbeli_terimaField',
		fieldLabel: 'No LBM',
		store: cbo_rbeli_terimabeli_DataSore,
		displayField:'terima_no',
		mode : 'remote',
		valueField: 'terima_id',
        typeAhead: false,
        hideTrigger:false,
		tpl: rbeli_terimabeli_tpl,
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		forceSelection: true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});
	rbeli_terima_idField= new Ext.form.NumberField();
	/* Identify  rbeli_supplier Field */
	rbeli_supplierField= new Ext.form.TextField({
		id: 'rbeli_supplierField',
		fieldLabel: 'Supplier',
		maxLength: 30,
		anchor: '95%'
	});
	
	rbeli_supplier_idField= new Ext.form.NumberField({
		id: 'rbeli_supplier_idField',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: true,
		readOnly: true,
		hidden: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  rbeli_tanggal Field */
	rbeli_tanggalField= new Ext.form.DateField({
		id: 'rbeli_tanggalField',
		fieldLabel: 'Tanggal',
		format : 'd-m-Y'
	});
	/* Identify  rbeli_keterangan Field */
	rbeli_keteranganField= new Ext.form.TextArea({
		id: 'rbeli_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 500,
		anchor: '95%'
	});
	
	rbeli_statusField= new Ext.form.ComboBox({
		id: 'rbeli_statusField',
		fieldLabel: 'Status Dok',
		forceSelection: true,
		store:new Ext.data.SimpleStore({
			fields:['rbeli_status_value', 'rbeli_status_display'],
			data:[['Terbuka','Terbuka'],['Tertutup','Tertutup'],['Batal', 'Batal']]
		}),
		mode: 'local',
		displayField: 'rbeli_status_display',
		valueField: 'rbeli_status_value',
		anchor: '80%',
		allowBlank: false,
		triggerAction: 'all'	
	});
	
	
	rbeli_totaljumlahField= new Ext.form.TextField({
		id: 'rbeli_totaljumlahField',
		fieldLabel: 'Total Jumlah Barang',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	rbeli_totalitemField= new Ext.form.TextField({
		id: 'rbeli_totalitemField',
		fieldLabel: 'Total Jenis Barang',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	
	rbeli_totalhargaField= new Ext.form.TextField({
		id: 'rbeli_totalhargaField',
		fieldLabel: 'Total Harga (Rp)',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		readOnly: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	rbeli_terima_orderField= new Ext.form.NumberField();
	rbeli_dproduk_idField= new Ext.form.NumberField();
	
	
	
  	/*Fieldset Master*/
	master_retur_beli_masterGroup = new Ext.form.FieldSet({
		// title: 'Master',
		autoHeight: true,
		// collapsible: true,
		layout:'column',
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [rbeli_nobuktiField, rbeli_terimaField, rbeli_supplierField, rbeli_idField] 
			}
			,{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [rbeli_tanggalField, rbeli_keteranganField, rbeli_statusField] 
			}
			]
	
	});
	
	//master_order_beli_FootGroup
	master_retur_beli_footGroup = new Ext.form.FieldSet({
		title: '-',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		labelWidth: 150,
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				labelAlign: 'left',
				border:false,
				items: [rbeli_totaljumlahField,rbeli_totalitemField] 
			}
			,{
				columnWidth:0.5,
				layout: 'form',
				labelAlign: 'left',
				border:false,
				items: [rbeli_totalhargaField] 
			}
			]
	
	});
	
		
	/*Detail Declaration */
		
	// Function for json reader of detail
	var detail_retur_beli_reader=new Ext.data.JsonReader({
		root: 'results',
		totalProperty: 'total',
		id: 'drbeli_id'
	},[
			{name: 'drbeli_id', type: 'int', mapping: 'drbeli_id'}, 
			{name: 'drbeli_master', type: 'int', mapping: 'drbeli_master'}, 
			{name: 'drbeli_produk', type: 'int', mapping: 'drbeli_produk'}, 
			{name: 'drbeli_satuan', type: 'int', mapping: 'drbeli_satuan'}, 
			{name: 'drbeli_jumlah', type: 'int', mapping: 'drbeli_jumlah'}, 
			{name: 'drbeli_harga', type: 'float', mapping: 'drbeli_harga'},
			{name: 'drbeli_diskon', type: 'int', mapping: 'drbeli_diskon'} 
	]);
	//eof
	
	//function for json writer of detail
	var detail_retur_beli_writer = new Ext.data.JsonWriter({
		encode: true,
		writeAllFields: false
	});
	//eof
	
	/* Function for Retrieve DataStore of detail*/
	detail_retur_beli_DataStore = new Ext.data.Store({
		id: 'detail_retur_beli_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_retur_beli&m=detail_detail_retur_beli_list', 
			method: 'POST'
		}),
		reader: detail_retur_beli_reader,
		baseParams:{start:0, limit: pageS, master_id: 0},
		sortInfo:{field: 'drbeli_id', direction: "ASC"}
	});
	/* End of Function */
	
	//function for editor of detail
	var editor_detail_retur_beli= new Ext.ux.grid.RowEditor({
        saveText: 'Update',
		listeners: {
			afteredit: function(){
				detail_retur_beli_DataStore.commitChanges();
				cbo_satuan_DataStore.load({params: {dterima_master: "", dterima_produk: ""}});
			}
		}
    });
	//eof
	
	Ext.util.Format.comboRenderer = function(combo){
		return function(value){
			var record = combo.findRecord(combo.valueField, value);
			return record ? record.get(combo.displayField) : combo.valueNotFoundText;
		}
	}
	
	/*=== cbo_produk_DataStore ==> untuk mengambil data produk yang diterima pada Modul Penerimaan Pembelian dgn params: rbeli_terima_idField. Parameter rbeli_terima_idField didapatkan dari ComboBox No.Faktur ===*/
	cbo_produk_DataStore = new Ext.data.Store({
		id: 'cbo_produk_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_retur_beli&m=get_produk_list', 
			method: 'POST'
		}),
		baseParams: {start: 0, limit: pageS, task:'detail', master_id: 0},
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'produk_id'
		},[
			{name: 'produk_id', type: 'int', mapping: 'produk_id'},
			{name: 'produk_nama', type: 'string', mapping: 'produk_nama'},
			{name: 'produk_kode', type: 'string', mapping: 'produk_kode'},
			{name: 'produk_satuan', type: 'int', mapping: 'satuan_id'},
			{name: 'produk_satuan_nama', type: 'string', mapping: 'satuan_nama'},
			{name: 'produk_harga', type: 'float', mapping: 'dinvoice_harga'},
			{name: 'produk_kategori', type: 'string', mapping: 'kategori_nama'},
			{name: 'produk_diskon', type: 'int', mapping: 'dinvoice_diskon'}
		]),
		sortInfo:{field: 'produk_nama', direction: "ASC"}
	});
	/*======= END cbo_produk_DataStore =======*/
	
	cbo_satuan_DataStore = new Ext.data.Store({
		id: 'cbo_satuan_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_retur_beli&m=get_satuan_list', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'satuan_id'
		},[
			{name: 'satuan_id', type: 'int', mapping: 'satuan_id'},
			{name: 'satuan_nama', type: 'string', mapping: 'satuan_nama'}
		]),
		sortInfo:{field: 'satuan_nama', direction: "ASC"}
	});
	/*======= END cbo_satuan_DataStore =======*/
	
	get_harga_onorderDataStore = new Ext.data.Store({
		id: 'get_harga_onorderDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_retur_beli&m=get_harga_on_order',
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'
		},[
			{name: 'dorder_harga_value', type: 'int', mapping: 'dorder_harga'}
		])
	});
	
	var retur_produk_detail_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{produk_nama} ({produk_kode})</b><br /></span>',
            'Kategori: {produk_kategori}',
        '</div></tpl>'
    );
	
	
	var combo_detail_produk=new Ext.form.ComboBox({
		store: cbo_produk_DataStore,
		mode: 'remote',
		typeAhead: false,
		displayField: 'produk_nama',
		valueField: 'produk_id',
		triggerAction: 'all',
		lazyRender: false,
		pageSize: pageS,
		enableKeyEvents: true,
		tpl: retur_produk_detail_tpl,
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});
	
	var combo_detail_satuan=new Ext.form.ComboBox({
		store: cbo_satuan_DataStore,
		mode: 'remote',
		typeAhead: false,
		displayField: 'satuan_nama',
		valueField: 'satuan_id',
		triggerAction: 'all',
		lazyRender:true
		//hideTrigger: true,
		//readOnly:true
	});
	
	dretur_beli_satuanField= new Ext.form.TextField({
		id: 'dretur_beli_satuanField',
		fieldLabel: 'Satuan',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: true,
		readOnly: true,
		anchor: '95%',
		readOnly: true,
		maskRe: /([0-9]+)$/
	});
	
	dretur_beli_jumlahField= new Ext.form.NumberField({
		id: 'dretur_beli_jumlahField',
		fieldLabel: 'Jumlah',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: true,
		enableKeyEvents: true,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	
	dretur_beli_hargaField= new Ext.form.NumberField({
		id: 'dinvoice_hargaField',
		fieldLabel: 'Harga',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: true,
		anchor: '95%',
		readOnly: true,
		maskRe: /([0-9]+)$/
	});
	
	dretur_beli_diskonField= new Ext.form.NumberField({
		id: 'dinvoice_diskonField',
		fieldLabel: 'Diskon',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: true,
		anchor: '95%',
		readOnly: true,
		maskRe: /([0-9]+)$/
	});
	
	dretur_beli_subtotalField= new Ext.form.NumberField({
		id: 'dinvoice_subtotalField',
		fieldLabel: 'Sub Total',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: true,
		enableKeyEvents: true,
		anchor: '95%',
		readOnly: true,
		maskRe: /([0-9]+)$/
	});
	
	//declaration of detail coloumn model
	detail_retur_beli_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '<div align="center">ID</div>',
			dataIndex: 'drbeli_id',
			width: 80,
			sortable: true,
			readOnly: true,
			hidden: true
		},
		{
			header: '<div align="center">Produk</div>',
			dataIndex: 'drbeli_produk',
			width: 200,
			sortable: true,
			editor: combo_detail_produk,
			renderer: Ext.util.Format.comboRenderer(combo_detail_produk)
		},
		{
			header: '<div align="center">Satuan</div>',
			dataIndex: 'drbeli_satuan',
			width: 80,
			sortable: true,
			editor: combo_detail_satuan,
			renderer: Ext.util.Format.comboRenderer(combo_detail_satuan)
		},
		{
			header: '<div align="center">Jumlah</div>',
			align: 'right',
			dataIndex: 'drbeli_jumlah',
			width: 80,
			sortable: true,
			editor: dretur_beli_jumlahField
		},
		/*
		{
			header: '<div align="center">Harga (Rp)</div>',
			align: 'right',
			dataIndex: 'drbeli_harga',
			width: 100,
			sortable: true,
			readOnly: true,
			editor: dretur_beli_hargaField,
			renderer: Ext.util.Format.numberRenderer('0,000')
		},
		{
			header: '<div align="center">Diskon (%)</div>',
			align: 'right',
			dataIndex: 'drbeli_diskon',
			width: 80,
			sortable: true,
			readOnly: true,
			editor: dretur_beli_diskonField,
			renderer: Ext.util.Format.numberRenderer('0,000')
		},
		{
			header: '<div align="center">Sub Total (Rp)</div>',
			align: 'right',
			width: 100,
			sortable: true,
			readOnly: true,
			editor: dretur_beli_subtotalField,
			renderer: function(v, params, record){
					subtotal=Ext.util.Format.number((record.data.drbeli_harga * record.data.drbeli_jumlah*(100-record.data.drbeli_diskon)/100),"0,000");
                    return '<span>' + subtotal+ '</span>';
            }
		},
		*/
		{
			header: '<div align="center">' + 'Keterangan' + '</div>',
			align: 'right',
			dataIndex: 'dminta_keterangan',
			width: 200,
			sortable: true
			// editor: dminta_ketField
		}
		]
	);
	detail_retur_beli_ColumnModel.defaultSortable= true;
	//eof
	
	
	
	//declaration of detail list editor grid
	detail_retur_beliListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'detail_retur_beliListEditorGrid',
		el: 'fp_detail_retur_beli',
		title: 'Detail Item Retur Pembelian',
		height: 250,
		width: 940,	//800,
		autoScroll: true,
		store: detail_retur_beli_DataStore, // DataStore
		colModel: detail_retur_beli_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		region: 'center',
        margins: '0 5 5 5',
		plugins: [editor_detail_retur_beli],
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true}
		<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_RETURBELI'))){ ?>
		,
		tbar: [
		{
			text: 'Add',
			tooltip: 'Add new detail record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: detail_retur_beli_add
		}, '-',{
			text: 'Delete',
			tooltip: 'Delete detail selected record',
			iconCls:'icon-delete',
			handler: detail_retur_beli_confirm_delete
		}
		]
		<?php } ?>
	});
	//eof
	
	
	//function of detail add
	function detail_retur_beli_add(){
		var edit_detail_retur_beli= new detail_retur_beliListEditorGrid.store.recordType({
			drbeli_id		:0,		
			drbeli_master	:'',		
			drbeli_produk	:0,		
			drbeli_satuan	:0,		
			drbeli_jumlah	:0,		
			drbeli_harga	:0,
			drbeli_diskon	:0	
		});
		editor_detail_retur_beli.stopEditing();
		detail_retur_beli_DataStore.insert(0, edit_detail_retur_beli);
		detail_retur_beliListEditorGrid.getView().refresh();
		detail_retur_beliListEditorGrid.getSelectionModel().selectRow(0);
		editor_detail_retur_beli.startEditing(0);
	}
	
	//function for refresh detail
	function refresh_detail_retur_beli(){
		detail_retur_beli_DataStore.commitChanges();
		detail_retur_beliListEditorGrid.getView().refresh();
	}
	//eof
	
	//function for insert detail
	function detail_retur_beli_insert(pkid,opsi){
		
		var drbeli_id = [];
        var drbeli_produk = [];
        var drbeli_satuan = [];
        var drbeli_jumlah = [];
        var drbeli_harga = [];
        var drbeli_diskon = [];
        
        var dcount = detail_retur_beli_DataStore.getCount() - 1;
        
        if(detail_retur_beli_DataStore.getCount()>0){
            for(i=0; i<detail_retur_beli_DataStore.getCount();i++){
                if((/^\d+$/.test(detail_retur_beli_DataStore.getAt(i).data.drbeli_produk))
				   && detail_retur_beli_DataStore.getAt(i).data.drbeli_produk!==undefined
				   && detail_retur_beli_DataStore.getAt(i).data.drbeli_produk!==''
				   && detail_retur_beli_DataStore.getAt(i).data.drbeli_produk!==0
				   && detail_retur_beli_DataStore.getAt(i).data.drbeli_satuan!==0
				   && detail_retur_beli_DataStore.getAt(i).data.drbeli_jumlah>0){
                    
					if(detail_retur_beli_DataStore.getAt(i).data.drbeli_id==undefined ||
					   detail_retur_beli_DataStore.getAt(i).data.drbeli_id==''){
						detail_retur_beli_DataStore.getAt(i).data.drbeli_id=0;
					}
					
                  	drbeli_id.push(detail_retur_beli_DataStore.getAt(i).data.drbeli_id);
					drbeli_produk.push(detail_retur_beli_DataStore.getAt(i).data.drbeli_produk);
                   	drbeli_satuan.push(detail_retur_beli_DataStore.getAt(i).data.drbeli_satuan);
					drbeli_jumlah.push(detail_retur_beli_DataStore.getAt(i).data.drbeli_jumlah);
					drbeli_harga.push(detail_retur_beli_DataStore.getAt(i).data.drbeli_harga);
					drbeli_diskon.push(detail_retur_beli_DataStore.getAt(i).data.drbeli_diskon);
                }
            }
			
			var encoded_array_drbeli_id = Ext.encode(drbeli_id);
			var encoded_array_drbeli_produk = Ext.encode(drbeli_produk);
			var encoded_array_drbeli_satuan = Ext.encode(drbeli_satuan);
			var encoded_array_drbeli_jumlah = Ext.encode(drbeli_jumlah);
			var encoded_array_drbeli_harga = Ext.encode(drbeli_harga);
			var encoded_array_drbeli_diskon = Ext.encode(drbeli_diskon);
				
			Ext.Ajax.request({
				waitMsg: 'Mohon tunggu...',
				url: 'index.php?c=c_master_retur_beli&m=detail_detail_retur_beli_insert',
				params:{
					drbeli_id		: encoded_array_drbeli_id,
					drbeli_master	: pkid, 
					drbeli_produk	: encoded_array_drbeli_produk,
					drbeli_satuan	: encoded_array_drbeli_satuan,
					drbeli_jumlah	: encoded_array_drbeli_jumlah,
					drbeli_harga	: encoded_array_drbeli_harga,
					drbeli_diskon	: encoded_array_drbeli_diskon
				},
				success:function(response){
					var result=eval(response.responseText);
					if(opsi=='print'){
						master_retur_beli_cetak_faktur(pkid);
					}
					master_retur_beli_DataStore.reload()
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
	
	//function for purge detail
	function detail_retur_beli_purge(pkid){
		Ext.Ajax.request({
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_master_retur_beli&m=detail_detail_retur_beli_purge',
			params:{ master_id: pkid},
			success:function(response){
				detail_retur_beli_insert(pkid);
			}
		});
		master_retur_beli_DataStore.reload();
	}
	//eof
	
	/* Function for Delete Confirm of detail */
	function detail_retur_beli_confirm_delete(){
		// only one record is selected here
		if(detail_retur_beliListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', detail_retur_beli_delete);
		} else if(detail_retur_beliListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', detail_retur_beli_delete);
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
	function detail_retur_beli_delete(btn){
		if(btn=='yes'){
			var s = detail_retur_beliListEditorGrid.getSelectionModel().getSelections();
			for(var i = 0, r; r = s[i]; i++){
				detail_retur_beli_DataStore.remove(r);
				detail_retur_beli_DataStore.commitChanges();
				detail_retur_beli_total();
			}
		}  
	}
	//eof

	rbeli_button_saveprintField=new Ext.Button({
		text: 'Save and Print',
		handler: function(){ master_retur_beli_create('print'); }
	});
	
	rbeli_button_saveField=new Ext.Button({
		text: 'Save',
		handler: function () { master_retur_beli_create('close'); }
	});
	
	/* Function for retrieve create Window Panel*/ 
	master_retur_beli_createForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 932,	//815,        
		items: [master_retur_beli_masterGroup,detail_retur_beliListEditorGrid /*,master_retur_beli_footGroup*/]
		,
		buttons: [
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_RETURBELI'))){ ?>
			rbeli_button_saveprintField
			,
			rbeli_button_saveField
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					master_retur_beli_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	master_retur_beli_createWindow= new Ext.Window({
		id: 'master_retur_beli_createWindow',
		title: post2db+' Retur Pembelian',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_master_retur_beli_create',
		items: master_retur_beli_createForm
	});
	/* End Window */
	
	
	/* Function for action list search */
	function master_retur_beli_list_search(){
		// render according to a SQL date format.
		var rbeli_nobukti_search=null;
		var rbeli_terima_search=null;
		var rbeli_supplier_search=null;
		var rbeli_tgl_awal_search_date="";
		var rbeli_tgl_akhir_search_date="";
		var rbeli_keterangan_search=null;
		var rbeli_status_search=null;

		if(rbeli_nobuktiSearchField.getValue()!==null){rbeli_nobukti_search=rbeli_nobuktiSearchField.getValue();}
		if(rbeli_terimaSearchField.getValue()!==null){rbeli_terima_search=rbeli_terimaSearchField.getValue();}
		if(rbeli_supplierSearchField.getValue()!==null){rbeli_supplier_search=rbeli_supplierSearchField.getValue();}
		if(rbeli_tgl_awalSearchField.getValue()!==""){rbeli_tgl_awal_search_date=rbeli_tgl_awalSearchField.getValue().format('Y-m-d');}
		if(rbeli_tgl_akhirSearchField.getValue()!==""){rbeli_tgl_akhir_search_date=rbeli_tgl_akhirSearchField.getValue().format('Y-m-d');}
		if(rbeli_keteranganSearchField.getValue()!==null){rbeli_keterangan_search=rbeli_keteranganSearchField.getValue();}
		if(rbeli_statusSearchField.getValue()!==null){rbeli_status_search=rbeli_statusSearchField.getValue();}
		// change the store parameters
		master_retur_beli_DataStore.baseParams = {
			task				: 'SEARCH',
			rbeli_nobukti		:	rbeli_nobukti_search, 
			rbeli_terima		:	rbeli_terima_search, 
			rbeli_supplier		:	rbeli_supplier_search, 
			rbeli_tgl_awal		:	rbeli_tgl_awal_search_date, 
			rbeli_tgl_akhir		:	rbeli_tgl_akhir_search_date, 
			rbeli_keterangan	:	rbeli_keterangan_search,
			rbeli_status		:	rbeli_status_search
		};
		// Cause the datastore to do another query : 
		master_retur_beli_DataStore.reload({params: {start: 0, limit: pageS}});
	}
		
	/* Function for reset search result */
	function master_retur_beli_reset_search(){
		master_retur_beli_DataStore.baseParams = { task: 'LIST', start: 0, limit: pageS };
		master_retur_beli_DataStore.reload({params: {start: 0, limit: pageS}});
		//master_retur_beli_searchWindow.close();
	};
	/* End of Fuction */
	
	function master_retur_beli_reset_SearchForm(){
		rbeli_nobuktiSearchField.reset();
		rbeli_terimaSearchField.reset();
		rbeli_supplierSearchField.reset();
		rbeli_tgl_awalSearchField.reset();
		rbeli_tgl_akhirSearchField.reset();
		rbeli_keteranganSearchField.reset();
		rbeli_statusSearchField.reset();
	}
	
	
	/* Field for search */
	/* Identify  rbeli_id Search Field */
	rbeli_idSearchField= new Ext.form.NumberField({
		id: 'rbeli_idSearchField',
		fieldLabel: 'Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	rbeli_nobuktiSearchField= new Ext.form.TextField({
		id: 'rbeli_nobuktiSearchField',
		fieldLabel: 'No Retur',
		maxLength: 100,
		anchor: '95%'
	});
	/* Identify  rbeli_terima Search Field */
	rbeli_terimaSearchField= new Ext.form.ComboBox({
		id: 'rbeli_terimaSearchField',
		fieldLabel: 'No LBM',
		store: cbo_rbeli_terimabeli_DataSore,
		displayField:'terima_no',
		mode : 'remote',
		valueField: 'terima_id',
        typeAhead: false,
        hideTrigger:false,
		tpl: rbeli_terimabeli_tpl,
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	
	});
	/* Identify  rbeli_supplier Search Field */
	rbeli_supplierSearchField= new Ext.form.NumberField({
		id: 'rbeli_supplierSearchField',
		fieldLabel: 'Supplier',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  rbeli_tanggal Search Field */
	rbeli_tgl_awalSearchField= new Ext.form.DateField({
		id: 'rbeli_tgl_awalSearchField',
		fieldLabel: 'Tanggal',
		format : 'd-m-Y'
	});
	
	rbeli_tgl_akhirSearchField= new Ext.form.DateField({
		id: 'rbeli_tgl_akhirSearchField',
		fieldLabel: 's/d',
		labelSeparator: ' ',
		format : 'd-m-Y'
	});
	
	/* Identify  rbeli_keterangan Search Field */
	rbeli_keteranganSearchField= new Ext.form.TextField({
		id: 'rbeli_keteranganSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 500,
		anchor: '95%'
	});

		
	rbeli_statusSearchField= new Ext.form.ComboBox({
		id: 'rbeli_statusSearchField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['value', 'rbeli_status'],
			data:[['Terbuka','Terbuka'],['Tertutup','Tertutup'],['Batal','Batal']]
		}),
		mode: 'local',
		displayField: 'rbeli_status',
		valueField: 'value',
		anchor: '70%',
		triggerAction: 'all'	 
	
	});
	
	/* Function for retrieve search Form Panel */
	master_retur_beli_searchForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 450,  
		labelWidth: 150,
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [rbeli_nobuktiSearchField, rbeli_terimaSearchField,
						{
							layout: 'column',
							border: false,
							items:[
								   {
									   layout: 'form',
									   border: false,
									   columnWidth: 0.6,
									   items:[rbeli_tgl_awalSearchField]
								   },
								    {
									   layout: 'form',
									   border: false,
									   columnWidth: 0.4,
									   labelWidth: 15,
									   items:[rbeli_tgl_akhirSearchField]
								   }
							]
						}, rbeli_keteranganSearchField, rbeli_statusSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: master_retur_beli_list_search
			},{
				text: 'Close',
				handler: function(){
					master_retur_beli_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	master_retur_beli_searchWindow = new Ext.Window({
		title: 'Pencarian Retur Pembelian',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_master_retur_beli_search',
		items: master_retur_beli_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!master_retur_beli_searchWindow.isVisible()){
			master_retur_beli_reset_SearchForm();
			master_retur_beli_searchWindow.show();
		} else {
			master_retur_beli_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	function master_retur_beli_cetak_faktur(pkid){
		
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_master_retur_beli&m=print_faktur',
		params: {
			faktur	: pkid
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/retur_faktur.html','order_faktur','height=800,width=670,resizable=1,scrollbars=1, menubar=1');
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
	
	/* Function for print List Grid */
	function master_retur_beli_print(){
		var searchquery = "";
		var rbeli_nobukti_print=null;
		var rbeli_terima_print=null;
		var rbeli_supplier_print=null;
		var rbeli_tgl_awal_print_date="";
		var rbeli_tgl_akhir_print_date="";
		var rbeli_keterangan_print=null;
		var win;              
		// check if we do have some search data...
		if(master_retur_beli_DataStore.baseParams.query!==null){searchquery = master_retur_beli_DataStore.baseParams.query;}
		if(master_retur_beli_DataStore.baseParams.rbeli_nobukti!==null){rbeli_nobukti_print = master_retur_beli_DataStore.baseParams.rbeli_nobukti;}
		if(master_retur_beli_DataStore.baseParams.rbeli_terima!==null){rbeli_terima_print = master_retur_beli_DataStore.baseParams.rbeli_terima;}
		if(master_retur_beli_DataStore.baseParams.rbeli_supplier!==null){rbeli_supplier_print = master_retur_beli_DataStore.baseParams.rbeli_supplier;}
		if(master_retur_beli_DataStore.baseParams.rbeli_tgl_awal!==""){rbeli_tgl_awal_print_date = master_retur_beli_DataStore.baseParams.rbeli_tgl_awal;}
		if(master_retur_beli_DataStore.baseParams.rbeli_tgl_akhir!==""){rbeli_tgl_akhir_print_date = master_retur_beli_DataStore.baseParams.rbeli_tgl_akhir;}
		if(master_retur_beli_DataStore.baseParams.rbeli_keterangan!==null){rbeli_keterangan_print = master_retur_beli_DataStore.baseParams.rbeli_keterangan;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_master_retur_beli&m=get_action',
		params: {
			task			: "PRINT",
		  	query			: searchquery,                    		
			rbeli_nobukti 	: rbeli_nobukti_print,
			rbeli_terima 	: rbeli_terima_print,
			rbeli_supplier 	: rbeli_supplier_print,
		  	rbeli_tgl_awal 	: rbeli_tgl_awal_print_date, 
			rbeli_tgl_akhir	: rbeli_tgl_akhir_print_date, 
			rbeli_keterangan: rbeli_keterangan_print,
		  	currentlisting	: master_retur_beli_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/print_retur_belilist.html','master_retur_belilist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
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
	function master_retur_beli_export_excel(){
		var searchquery = "";
		var rbeli_nobukti_2excel=null;
		var rbeli_terima_2excel=null;
		var rbeli_supplier_2excel=null;
		var rbeli_tgl_awal_2excel_date="";
		var rbeli_tgl_akhir_2excel_date="";
		var rbeli_keterangan_2excel=null;
		var win;              
		// check if we do have some search data...
		if(master_retur_beli_DataStore.baseParams.query!==null){searchquery = master_retur_beli_DataStore.baseParams.query;}
		if(master_retur_beli_DataStore.baseParams.rbeli_nobukti!==null){rbeli_nobukti_2excel = master_retur_beli_DataStore.baseParams.rbeli_nobukti;}
		if(master_retur_beli_DataStore.baseParams.rbeli_terima!==null){rbeli_terima_2excel = master_retur_beli_DataStore.baseParams.rbeli_terima;}
		if(master_retur_beli_DataStore.baseParams.rbeli_supplier!==null){rbeli_supplier_2excel = master_retur_beli_DataStore.baseParams.rbeli_supplier;}
		if(master_retur_beli_DataStore.baseParams.rbeli_tgl_awal!==""){rbeli_tgl_awal_2excel_date = master_retur_beli_DataStore.baseParams.rbeli_tgl_awal;}
		if(master_retur_beli_DataStore.baseParams.rbeli_tgl_akhir!==""){rbeli_tgl_akhir_2excel_date = master_retur_beli_DataStore.baseParams.rbeli_tgl_akhir;}
		if(master_retur_beli_DataStore.baseParams.rbeli_keterangan!==null){rbeli_keterangan_2excel = master_retur_beli_DataStore.baseParams.rbeli_keterangan;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_master_retur_beli&m=get_action',
		params: {
			task				: "EXCEL",
		  	query				: searchquery,                    		
			rbeli_nobukti 		: rbeli_nobukti_2excel,
			rbeli_terima 		: rbeli_terima_2excel,
			rbeli_supplier 		: rbeli_supplier_2excel,
		  	rbeli_tgl_awal		: rbeli_tgl_awal_2excel_date, 
			rbeli_tgl_akhir		: rbeli_tgl_akhir_2excel_date, 
			rbeli_keterangan 	: rbeli_keterangan_2excel,
		  	currentlisting		: master_retur_beli_DataStore.baseParams.task // this tells us if we are searching or not
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
	
	function detail_retur_beli_total(){
		var jumlah_item=0;
		var total_harga=0;
		for(i=0;i<detail_retur_beli_DataStore.getCount();i++){
			detail_retur_beli_record=detail_retur_beli_DataStore.getAt(i);
			jumlah_item=jumlah_item+detail_retur_beli_record.data.drbeli_jumlah;
			total_harga=total_harga+detail_retur_beli_record.data.drbeli_harga*jumlah_item*(100-detail_retur_beli_record.data.drbeli_diskon)/100;
		}
		rbeli_totaljumlahField.setValue(CurrencyFormatted(jumlah_item));
		rbeli_totalitemField.setValue(CurrencyFormatted(detail_retur_beli_DataStore.getCount()));
		rbeli_totalhargaField.setValue(CurrencyFormatted(total_harga));
	}
	
	//EVENTS
	

	master_retur_beliListEditorGrid.addListener('rowcontextmenu', onmaster_retur_beli_ListEditGridContextMenu);
	master_retur_beli_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStore

	detail_retur_beli_DataStore.on('update', function(){
		detail_retur_beli_DataStore.commitChanges();
		detail_retur_beli_total();
		for(i=0;i<detail_retur_beli_DataStore.getCount();i++){
			var detail_data=detail_retur_beli_DataStore.getAt(i);
			var j=cbo_produk_DataStore.findExact('produk_id',detail_data.data.drbeli_produk,0);
			if(j>-1)
			{
				var data_combo=cbo_produk_DataStore.getAt(j);
				detail_data.data.drbeli_satuan=data_combo.data.produk_satuan;
				detail_data.data.drbeli_harga=data_combo.data.produk_harga;
				detail_data.data.drbeli_diskon=data_combo.data.produk_diskon;
			}
		}
		var query_selected="";
		for(i=0;i<detail_retur_beli_DataStore.getCount();i++){
			var data_record=detail_retur_beli_DataStore.getAt(i);
			query_selected=query_selected+data_record.data.drbeli_produk+",";
		}
		cbo_produk_DataStore.setBaseParam('task','selected');
		cbo_produk_DataStore.setBaseParam('selected_id',query_selected);
		
		
	});
	detail_retur_beli_DataStore.on("load",detail_retur_beli_total);
	
	rbeli_terimaField.on('select', function(){
		var j=cbo_rbeli_terimabeli_DataSore.findExact('terima_id',rbeli_terimaField.getValue());
		cbo_produk_DataStore.setBaseParam('task','list');
		cbo_produk_DataStore.load({params: {terima_id: rbeli_terimaField.getValue()}});
		var detail_data=detail_retur_beli_DataStore.getAt(j);
		if(cbo_rbeli_terimabeli_DataSore.getCount()>0){
			rbeli_supplierField.setValue(cbo_rbeli_terimabeli_DataSore.getAt(j).data.terima_supplier);
			rbeli_terima_orderField.setValue(cbo_rbeli_terimabeli_DataSore.getAt(j).data.terima_order);
			rbeli_terima_idField.setValue(cbo_rbeli_terimabeli_DataSore.getAt(j).data.terima_id);
		}
	});
	
	combo_detail_produk.on('select', function(){
			
		for(i=0;i<detail_retur_beli_DataStore.getCount();i++){
			var detail_data=detail_retur_beli_DataStore.getAt(i);
			cbo_satuan_DataStore.setBaseParam('task','produk');
			cbo_satuan_DataStore.setBaseParam('selected_id',combo_detail_produk.getValue());
			cbo_satuan_DataStore.load();
			var j=cbo_produk_DataStore.findExact('produk_id',combo_detail_produk.getValue(),0);
			if(j>-1)
			{
				var data_combo=cbo_produk_DataStore.getAt(j);
				detail_data.data.drbeli_satuan=data_combo.data.produk_satuan;
				detail_data.data.drbeli_harga=data_combo.data.produk_harga;
				detail_data.data.drbeli_diskon=data_combo.data.produk_diskon;
				combo_detail_satuan.setValue(data_combo.data.produk_satuan);
				dretur_beli_diskonField.setValue(data_combo.data.produk_diskon);
				dretur_beli_hargaField.setValue(data_combo.data.produk_harga);
				dretur_beli_subtotalField.setValue((100-data_combo.data.produk_diskon)*data_combo.data.produk_harga*dretur_beli_jumlahField.getValue()/100);
			}
		}
	});
	
	dretur_beli_jumlahField.on('keyup',function(){
		dretur_beli_subtotalField.setValue((100-dretur_beli_diskonField.getValue())*dretur_beli_hargaField.getValue()*dretur_beli_jumlahField.getValue()/100);
	});
	
	combo_detail_produk.on('focus', function(){
		var query_selected="";
		for(i=0;i<detail_retur_beli_DataStore.getCount();i++){
			var data_record=detail_retur_beli_DataStore.getAt(i);
			query_selected=query_selected+data_record.data.drbeli_produk+",";
		}
		cbo_produk_DataStore.setBaseParam('task','list');
		cbo_produk_DataStore.setBaseParam('terima_id',rbeli_terimaField.getValue());
		//cbo_produk_DataStore.load({params: {terima_id: rbeli_terimaField.getValue()}});
		//cbo_produk_DataStore.load();
	});
	
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_master_retur_beli"></div>
         <div id="fp_detail_retur_beli"></div>
		<div id="elwindow_master_retur_beli_create"></div>
        <div id="elwindow_master_retur_beli_search"></div>
    </div>
</div>
</body>