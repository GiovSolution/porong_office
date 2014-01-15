<?
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: cabang View
	+ Description	: For record view
	+ Filename 		: v_cabang.php
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
			border-bottom:1px solid #eeeeee;+
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
var cabang_DataStore;
var cabang_ColumnModel;
var cabangListEditorGrid;
var cabang_createForm;
var cabang_createWindow;
var cabang_searchForm;
var cabang_searchWindow;
var cabang_SelectedRow;
var cabang_ContextMenu;
//declare konstant
var post2db = '';
var msg = '';
var pageS=15;

/* declare variable here */
var cabang_idField;
var cabang_namaField;
var cabang_kodeField;
var cabang_kode_akunField;
var cabang_alamatField;
var cabang_kotaField;
var cabang_kodeposField;
var cabang_propinsiField;
var cabang_keteranganField;
var cabang_aktifField;
var cabang_pajakField;

var cabang_idSearchField;
var cabang_namaSearchField;
var cabang_alamatSearchField;
var cabang_kotaSearchField;
var cabang_kodeposSearchField;
var cabang_propinsiSearchField;
var cabang_keteranganSearchField;
var cabang_aktifSearchField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  	/* Function for Saving inLine Editing */
	function cabang_update(oGrid_event){
	var cabang_id_update_pk="";
	var cabang_nama_update=null;
	var cabang_alamat_update=null;
	var cabang_kota_update=null;
	var cabang_kodepos_update=null;
	var cabang_propinsi_update=null;
	var cabang_keterangan_update=null;
	var cabang_aktif_update=null;

	cabang_id_update_pk = get_pk_id();
	if(oGrid_event.record.data.cabang_nama!== null){cabang_nama_update = oGrid_event.record.data.cabang_nama;}
	if(oGrid_event.record.data.cabang_alamat!== null){cabang_alamat_update = oGrid_event.record.data.cabang_alamat;}
	if(oGrid_event.record.data.cabang_kota!== null){cabang_kota_update = oGrid_event.record.data.cabang_kota;}
	if(oGrid_event.record.data.cabang_kodepos!== null){cabang_kodepos_update = oGrid_event.record.data.cabang_kodepos;}
	if(oGrid_event.record.data.cabang_propinsi!== null){cabang_propinsi_update = oGrid_event.record.data.cabang_propinsi;}
	if(oGrid_event.record.data.cabang_keterangan!== null){cabang_keterangan_update = oGrid_event.record.data.cabang_keterangan;}
	if(oGrid_event.record.data.cabang_aktif!== null){cabang_aktif_update = oGrid_event.record.data.cabang_aktif;}

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_cabang&m=get_action',
			params: {
				task: "UPDATE",
				cabang_id	: get_pk_id(),				
				cabang_nama	:cabang_nama_update,		
				cabang_alamat	:cabang_alamat_update,		
				cabang_kota	:cabang_kota_update,
				cabang_kodepos	:cabang_kodepos_update,
				cabang_propinsi	:cabang_propinsi_update,		
				cabang_keterangan	:cabang_keterangan_update,		
				cabang_aktif	:cabang_aktif_update,		
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						cabang_DataStore.commitChanges();
						cabang_DataStore.reload();
						break;
					default:
						Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Data Cabang tidak bisa disimpan.',
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
	function cabang_create(){
		if(is_cabang_form_valid()){
		
		var cabang_id_create_pk=null;
		var cabang_nama_create=null;
		var cabang_kode_create=null;
		var cabang_kode_akun_create=null;
		var cabang_alamat_create=null;
		var cabang_kota_create=null;
		var cabang_kodepos_create=null;
		var cabang_propinsi_create=null;
		var cabang_keterangan_create=null;
		var cabang_aktif_create=null;
		var cabang_pajak_create=null;

		cabang_id_create_pk=get_pk_id();
		if(cabang_namaField.getValue()!== null){cabang_nama_create = cabang_namaField.getValue();}
		if(cabang_kodeField.getValue()!== null){cabang_kode_create = cabang_kodeField.getValue();}
		if(cabang_kode_akunField.getValue()!== null){cabang_kode_akun_create = cabang_kode_akunField.getValue();}
		if(cabang_alamatField.getValue()!== null){cabang_alamat_create = cabang_alamatField.getValue();}
		if(cabang_kotaField.getValue()!== null){cabang_kota_create = cabang_kotaField.getValue();}
		if(cabang_kodeposField.getValue()!== null){cabang_kodepos_create = cabang_kodeposField.getValue();}
		if(cabang_propinsiField.getValue()!== null){cabang_propinsi_create = cabang_propinsiField.getValue();}
		if(cabang_keteranganField.getValue()!== null){cabang_keterangan_create = cabang_keteranganField.getValue();}
		if(cabang_aktifField.getValue()!== null){cabang_aktif_create = cabang_aktifField.getValue();}
		if(cabang_pajakField.getValue()!== null){cabang_pajak_create = cabang_pajakField.getValue();}
		

			Ext.Ajax.request({  
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_cabang&m=get_action',
				params: {
					task: post2db,
					cabang_id	: cabang_id_create_pk,	
					cabang_kode	: cabang_kode_create,
					cabang_kode_akun	: cabang_kode_akun_create,
					cabang_nama	: cabang_nama_create,	
					cabang_alamat	: cabang_alamat_create,	
					cabang_kota	: cabang_kota_create,	
					cabang_kodepos	: cabang_kodepos_create,	
					cabang_propinsi	: cabang_propinsi_create,	
					cabang_keterangan	: cabang_keterangan_create,	
					cabang_aktif	: cabang_aktif_create,	
					cabang_pajak	: cabang_pajak_create
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							Ext.MessageBox.alert(post2db+' OK','Data Cabang berhasil disimpan.');
							cabang_DataStore.reload();
							cabang_createWindow.hide();
							break;
						default:
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Data Cabang tidak bisa disimpan',
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
			return cabangListEditorGrid.getSelectionModel().getSelected().get('cabang_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function cabang_reset_form(){
		cabang_namaField.reset();
		cabang_namaField.setValue(null);
		cabang_kodeField.reset();
		cabang_kodeField.setValue(null);
		cabang_kode_akunField.reset();
		cabang_kode_akunField.setValue(null);
		cabang_alamatField.reset();
		cabang_alamatField.setValue(null);
		cabang_kotaField.reset();
		cabang_kotaField.setValue(null);
		cabang_kodeposField.reset();
		cabang_kodeposField.setValue(null);
		cabang_propinsiField.reset();
		cabang_propinsiField.setValue(null);
		cabang_keteranganField.reset();
		cabang_keteranganField.setValue(null);
		cabang_aktifField.reset();
		cabang_aktifField.setValue('Aktif');
		cabang_pajakField.reset();
		cabang_pajakField.setValue(false);
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function cabang_set_form(){
		cabang_namaField.setValue(cabangListEditorGrid.getSelectionModel().getSelected().get('cabang_nama'));
		cabang_kodeField.setValue(cabangListEditorGrid.getSelectionModel().getSelected().get('cabang_kode'));
		cabang_kode_akunField.setValue(cabangListEditorGrid.getSelectionModel().getSelected().get('cabang_kode_akun'));
		cabang_alamatField.setValue(cabangListEditorGrid.getSelectionModel().getSelected().get('cabang_alamat'));
		cabang_kotaField.setValue(cabangListEditorGrid.getSelectionModel().getSelected().get('cabang_kota'));
		cabang_kodeposField.setValue(cabangListEditorGrid.getSelectionModel().getSelected().get('cabang_kodepos'));
		cabang_propinsiField.setValue(cabangListEditorGrid.getSelectionModel().getSelected().get('cabang_propinsi'));
		cabang_keteranganField.setValue(cabangListEditorGrid.getSelectionModel().getSelected().get('cabang_keterangan'));
		cabang_aktifField.setValue(cabangListEditorGrid.getSelectionModel().getSelected().get('cabang_aktif'));
		if(cabangListEditorGrid.getSelectionModel().getSelected().get('cabang_pajak')=="1")	
			cabang_pajakField.setValue(true);	
		if(cabangListEditorGrid.getSelectionModel().getSelected().get('cabang_pajak')=="0")
			cabang_pajakField.setValue(false);
		
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_cabang_form_valid(){
		return (cabang_namaField.isValid() && cabang_alamatField.isValid() && cabang_kodeField.isValid() && cabang_kode_akunField.isValid());
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!cabang_createWindow.isVisible()){
			
			post2db='CREATE';
			msg='created';
			cabang_reset_form();
			
			cabang_createWindow.show();
		} else {
			cabang_createWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function cabang_confirm_delete(){
		// only one cabang is selected here
		if(cabangListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', cabang_delete);
		} else if(cabangListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', cabang_delete);
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
	function cabang_confirm_update(){
		/* only one record is selected here */
		if(cabangListEditorGrid.selModel.getCount() == 1) {
			
			post2db='UPDATE';
			msg='updated';
			cabang_set_form();
			
			cabang_createWindow.show();
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
	function cabang_delete(btn){
		if(btn=='yes'){
			var selections = cabangListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< cabangListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.cabang_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_cabang&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							cabang_DataStore.reload();
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
	cabang_DataStore = new Ext.data.Store({
		id: 'cabang_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_cabang&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST",start: 0, limit: pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'cabang_id'
		},[
			{name: 'cabang_id', type: 'int', mapping: 'cabang_id'},
			{name: 'cabang_kode', type: 'string', mapping: 'cabang_kode'},
			{name: 'cabang_kode_akun', type: 'string', mapping: 'cabang_kode_akun'},
			{name: 'cabang_nama', type: 'string', mapping: 'cabang_nama'},
			{name: 'cabang_alamat', type: 'string', mapping: 'cabang_alamat'},
			{name: 'cabang_kota', type: 'string', mapping: 'cabang_kota'},
			{name: 'cabang_kodepos', type: 'string', mapping: 'cabang_kodepos'},
			{name: 'cabang_propinsi', type: 'string', mapping: 'cabang_propinsi'},
			{name: 'cabang_keterangan', type: 'string', mapping: 'cabang_keterangan'},
			{name: 'cabang_aktif', type: 'string', mapping: 'cabang_aktif'},
			{name: 'cabang_creator', type: 'string', mapping: 'cabang_creator'},
			{name: 'cabang_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'cabang_date_create'},
			{name: 'cabang_update', type: 'string', mapping: 'cabang_update'},
			{name: 'cabang_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'cabang_date_update'},
			{name: 'cabang_revised', type: 'int', mapping: 'cabang_revised'},
			{name: 'cabang_pajak', type: 'string', mapping: 'cabang_pajak'}
		]),
		sortInfo:{field: 'cabang_nama', direction: "ASC"}
	});
	/* End of Function */
    
  	/* Function for Identify of Window Column Model */
	cabang_ColumnModel = new Ext.grid.ColumnModel(
		[{
			//index=0
			header: '#',
			readOnly: true,
			dataIndex: 'cabang_id',
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
			dataIndex: 'cabang_nama',
			width: 250,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_CABANG'))){ ?>
			,
			editor: new Ext.form.TextField({
				allowBlank: false,
				maxLength: 250
          	})
			<?php } ?>
		},
		{
			/*index=2*/
			header: 'Alamat',
			dataIndex: 'cabang_alamat',
			width: 250,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_CABANG'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
			<?php } ?>
		},
		{
			/*index=3*/
			header: 'Kota',
			dataIndex: 'cabang_kota',
			width: 150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_CABANG'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
			<?php } ?>
		},
		{
			/*index=4*/
			header: 'Kode Pos',
			dataIndex: 'cabang_kodepos',
			width: 80,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_CABANG'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 5
          	})
			<?php } ?>
		},
		{
			/*index=5*/
			header: 'Propinsi',
			dataIndex: 'cabang_propinsi',
			width: 150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_CABANG'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
			<?php } ?>
		},
		{
			/*index=6*/
			header: 'Keterangan',
			dataIndex: 'cabang_keterangan',
			width: 150,
			sortable: true,
			hidden: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_CABANG'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
			<?php } ?>
		},
		{
			/*index=7*/
			header: 'Status',
			dataIndex: 'cabang_aktif',
			width: 150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_CABANG'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['cabang_aktif_value', 'cabang_aktif_display'],
					data: [['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
					}),
				mode: 'local',
               	displayField: 'cabang_aktif_display',
               	valueField: 'cabang_aktif_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
			<?php } ?>
		},
		{
			/*index=8*/
			header: 'Creator',
			dataIndex: 'cabang_creator',
			width: 150,
			sortable: true,
			hidden: true
		},
		{
			/*index=9*/
			header: 'Create on',
			dataIndex: 'cabang_date_create',
			width: 150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			hidden: true
		},
		{
			/*index=10*/
			header: 'Last Update by',
			dataIndex: 'cabang_update',
			width: 150,
			sortable: true,
			hidden: true
		},
		{
			/*index=11*/
			header: 'Last Update on',
			dataIndex: 'cabang_date_update',
			width: 150,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			hidden: true
		},
		{
			/*index=12*/
			header: 'Revised',
			dataIndex: 'cabang_revised',
			width: 150,
			sortable: true,
			hidden: true
		}]
	);
	cabang_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	cabangListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'cabangListEditorGrid',
		el: 'fp_cabang',
		title: 'Daftar Cabang',
		autoHeight: true,
		store: cabang_DataStore, // DataStore
		cm: cabang_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 900,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: cabang_DataStore,
			displayInfo: true
		}),
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_CABANG'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<?php } ?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_CABANG'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: cabang_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_CABANG'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			disabled:true,
			handler: cabang_confirm_delete   // Confirm before deleting
		}, '-', 
		<?php } ?>
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: cabang_DataStore,
			params: {task: 'LIST',start: 0, limit: pageS},
			listeners:{
				specialkey: function(f,e){
					if(e.getKey() == e.ENTER){
						cabang_DataStore.baseParams={task:'LIST',start: 0, limit: pageS};
		            }
				},
				render: function(c){
				Ext.get(this.id).set({qtitle:'Search By'});
				Ext.get(this.id).set({qtip:'- Nama<br>- Kota'});
				}
			},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: cabang_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: cabang_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: cabang_print  
		}
		]
	});
	cabangListEditorGrid.render();
	/* End of DataStore */
	
	/*cabangListEditorGrid.getColumnModel().setHidden(8, true);
	cabangListEditorGrid.getColumnModel().setHidden(9, true);
	cabangListEditorGrid.getColumnModel().setHidden(10, true);
	cabangListEditorGrid.getColumnModel().setHidden(11, true);
	cabangListEditorGrid.getColumnModel().setHidden(12, true);*/
     
	/* Create Context Menu */
	cabang_ContextMenu = new Ext.menu.Menu({
		id: 'cabang_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_CABANG'))){ ?>
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: cabang_confirm_update 
		},
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_CABANG'))){ ?>
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			handler: cabang_confirm_delete 
		},
		<?php } ?>
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: cabang_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: cabang_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function oncabang_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		cabang_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		cabang_SelectedRow=rowIndex;
		cabang_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function cabang_editContextMenu(){
      cabangListEditorGrid.startEditing(cabang_SelectedRow,1);
  	}
	/* End of Function */
  	
	cabangListEditorGrid.addListener('rowcontextmenu', oncabang_ListEditGridContextMenu);
	cabang_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	cabangListEditorGrid.on('afteredit', cabang_update); // inLine Editing Record
	
	/* Identify  cabang_kode Field */
	cabang_kodeField= new Ext.form.TextField({
		id: 'cabang_kodeField',
		fieldLabel: 'Cabang<span style="color: #ec0000">*</span>',
		maxLength: 100,
		allowBlank: false,
		anchor: '100%'
	});
	
	/* Identify  cabang_kode_akun Field */
	cabang_kode_akunField= new Ext.form.TextField({
		id: 'cabang_kode_akunField',
		fieldLabel: 'Cabang Akun<span style="color: #ec0000">*</span>',
		maxLength: 2,
		allowBlank: false,
		maskRe: /([0-9]+)$/,
		anchor: '100%'
	});
	
	cabang_kode_group = new Ext.form.FieldSet({
		title: 'Kode',
		labelWidth: 100,
		anchor: '95%',
		layout:'form',
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [cabang_kode_akunField, cabang_kodeField]
			}
		]
	});
	
	/* Identify  cabang_nama Field */
	cabang_namaField= new Ext.form.TextField({
		id: 'cabang_namaField',
		fieldLabel: 'Nama Cabang<span style="color: #ec0000">*</span>',
		maxLength: 250,
		allowBlank: false,
		anchor: '95%'
	});
	/* Identify  cabang_alamat Field */
	cabang_alamatField= new Ext.form.TextField({
		id: 'cabang_alamatField',
		fieldLabel: 'Alamat <span style="color: #ec0000">*</span>',
		maxLength: 250,
		allowBlank: false,
		anchor: '95%'
	});
	/* Identify  cabang_kota Field */
	cabang_kotaField= new Ext.form.TextField({
		id: 'cabang_kotaField',
		fieldLabel: 'Kota',
		maxLength: 250,
		anchor: '95%'
	});
	/* Identify  cabang_kodepos Field */
	cabang_kodeposField= new Ext.form.TextField({
		id: 'cabang_kodeposField',
		fieldLabel: 'Kode Pos',
		maxLength: 5,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	});
	/* Identify  cabang_propinsi Field */
	cabang_propinsiField= new Ext.form.TextField({
		id: 'cabang_propinsiField',
		fieldLabel: 'Propinsi',
		maxLength: 250,
		anchor: '95%'
	});
	/* Identify  cabang_keterangan Field */
	cabang_keteranganField= new Ext.form.TextArea({
		id: 'cabang_keteranganField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '95%'
	});
	/* Identify  cabang_aktif Field */
	cabang_aktifField= new Ext.form.ComboBox({
		id: 'cabang_aktifField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['cabang_aktif_value', 'cabang_aktif_display'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		editable:false,
		emptyText: 'Aktif',
		displayField: 'cabang_aktif_display',
		valueField: 'cabang_aktif_value',
		width: 80,
		triggerAction: 'all'	
	});
  	/* Identify Pajak Aktif*/
	cabang_pajakField=new Ext.form.Checkbox({
		id : 'cabang_pajakField',
		fieldLabel: 'Pajak',
		maxLength: 250,
		name: 'cabang_pajak'
	});
	/* Function for retrieve create Window Panel*/ 
	cabang_createForm = new Ext.FormPanel({
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
				items: [cabang_kode_group, cabang_namaField, cabang_alamatField, cabang_kotaField, cabang_kodeposField, cabang_propinsiField, cabang_keteranganField, 
						cabang_aktifField, cabang_pajakField] 
			}
			]
		}]
		,
		buttons: [
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_CABANG'))){ ?>
			{
				text: 'Save and Close',
				handler: cabang_create
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					cabang_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	cabang_createWindow= new Ext.Window({
		id: 'cabang_createWindow',
		title: post2db+'Cabang',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_cabang_create',
		items: cabang_createForm
	});
	/* End Window */
	
	
	/* Function for action list search */
	function cabang_list_search(){
		// render according to a SQL date format.
		var cabang_id_search=null;
		var cabang_nama_search=null;
		var cabang_alamat_search=null;
		var cabang_kota_search=null;
		var cabang_kodepos_search=null;
		var cabang_propinsi_search=null;
		var cabang_keterangan_search=null;
		var cabang_aktif_search=null;

		if(cabang_idSearchField.getValue()!==null){cabang_id_search=cabang_idSearchField.getValue();}
		if(cabang_namaSearchField.getValue()!==null){cabang_nama_search=cabang_namaSearchField.getValue();}
		if(cabang_alamatSearchField.getValue()!==null){cabang_alamat_search=cabang_alamatSearchField.getValue();}
		if(cabang_kotaSearchField.getValue()!==null){cabang_kota_search=cabang_kotaSearchField.getValue();}
		if(cabang_kodeposSearchField.getValue()!==null){cabang_kodepos_search=cabang_kodeposSearchField.getValue();}
		if(cabang_propinsiSearchField.getValue()!==null){cabang_propinsi_search=cabang_propinsiSearchField.getValue();}
		if(cabang_keteranganSearchField.getValue()!==null){cabang_keterangan_search=cabang_keteranganSearchField.getValue();}
		if(cabang_aktifSearchField.getValue()!==null){cabang_aktif_search=cabang_aktifSearchField.getValue();}
		// change the store parameters
		cabang_DataStore.baseParams = {
			task: 'SEARCH',
			start: 0,
			limit: pageS,
			//variable here
			cabang_id	:	cabang_id_search, 
			cabang_nama	:	cabang_nama_search, 
			cabang_alamat	:	cabang_alamat_search, 
			cabang_kota	:	cabang_kota_search, 
			cabang_kodepos	:	cabang_kodepos_search, 
			cabang_propinsi	:	cabang_propinsi_search, 
			cabang_keterangan	:	cabang_keterangan_search, 
			cabang_aktif	:	cabang_aktif_search, 
		};
		// Cause the datastore to do another query : 
		cabang_DataStore.reload({params: {start: 0, limit: pageS}});
	}
		
	/* Function for reset search result */
	function cabang_reset_search(){
		// reset the store parameters
		cabang_DataStore.baseParams = { task: 'LIST',start: 0, limit: pageS };
		// Cause the datastore to do another query : 
		cabang_DataStore.reload({params: {start: 0, limit: pageS}});
		//cabang_searchWindow.close();
	};
	/* End of Fuction */
	
	function cabang_reset_SearchForm(){
		cabang_namaSearchField.reset();
		cabang_namaSearchField.setValue(null);
		cabang_alamatSearchField.reset();
		cabang_alamatSearchField.setValue(null);
		cabang_kotaSearchField.reset();
		cabang_kotaSearchField.setValue(null);
		cabang_kodeposSearchField.reset();
		cabang_kodeposSearchField.setValue(null);
		cabang_propinsiSearchField.reset();
		cabang_propinsiSearchField.setValue(null);
		cabang_keteranganSearchField.reset();
		cabang_keteranganSearchField.setValue(null);
		cabang_aktifSearchField.reset();
		cabang_aktifSearchField.setValue(null);
	}
	
	/* Field for search */
	/* Identify  cabang_id Search Field */
	cabang_idSearchField= new Ext.form.NumberField({
		id: 'cabang_idSearchField',
		fieldLabel: 'Cabang Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  cabang_nama Search Field */
	cabang_namaSearchField= new Ext.form.TextField({
		id: 'cabang_namaSearchField',
		fieldLabel: 'Nama Cabang',
		maxLength: 250,
		anchor: '95%'
	
	});
	/* Identify  cabang_alamat Search Field */
	cabang_alamatSearchField= new Ext.form.TextField({
		id: 'cabang_alamatSearchField',
		fieldLabel: 'Alamat',
		maxLength: 250,
		anchor: '95%'
	
	});
	/* Identify  cabang_kota Search Field */
	cabang_kotaSearchField= new Ext.form.TextField({
		id: 'cabang_kotaSearchField',
		fieldLabel: 'Kota',
		maxLength: 250,
		anchor: '95%'
	
	});
	/* Identify  cabang_kodepos Search Field */
	cabang_kodeposSearchField= new Ext.form.TextField({
		id: 'cabang_kodeposSearchField',
		fieldLabel: 'Kode Pos',
		maxLength: 250,
		anchor: '95%'
	
	});
	/* Identify  cabang_propinsi Search Field */
	cabang_propinsiSearchField= new Ext.form.TextField({
		id: 'cabang_propinsiSearchField',
		fieldLabel: 'Propinsi',
		maxLength: 250,
		anchor: '95%'
	
	});
	/* Identify  cabang_keterangan Search Field */
	cabang_keteranganSearchField= new Ext.form.TextField({
		id: 'cabang_keteranganSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '95%'
	
	});
	/* Identify  cabang_aktif Search Field */
	cabang_aktifSearchField= new Ext.form.ComboBox({
		id: 'cabang_aktifSearchField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['value', 'cabang_aktif'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		displayField: 'cabang_aktif',
		valueField: 'value',
		emptyText: 'Aktif',
		width: 80,
		triggerAction: 'all'	 
	
	});
    
	/* Function for retrieve search Form Panel */
	cabang_searchForm = new Ext.FormPanel({
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
				items: [cabang_namaSearchField, cabang_alamatSearchField, cabang_kotaSearchField, cabang_kodeposSearchField, 
						cabang_propinsiSearchField, cabang_keteranganSearchField, cabang_aktifSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: cabang_list_search
			},{
				text: 'Close',
				handler: function(){
					cabang_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	cabang_searchWindow = new Ext.Window({
		title: 'Pencarian Cabang',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_cabang_search',
		items: cabang_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!cabang_searchWindow.isVisible()){
			cabang_reset_SearchForm();
			cabang_searchWindow.show();
		} else {
			cabang_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function cabang_print(){
		var searchquery = "";
		var cabang_nama_print=null;
		var cabang_alamat_print=null;
		var cabang_kota_print=null;
		var cabang_kodepos_print=null;
		var cabang_propinsi_print=null;
		var cabang_keterangan_print=null;
		var cabang_aktif_print=null;
		var win;              
		// check if we do have some search data...
		if(cabang_DataStore.baseParams.query!==null){searchquery = cabang_DataStore.baseParams.query;}
		if(cabang_DataStore.baseParams.cabang_nama!==null){cabang_nama_print = cabang_DataStore.baseParams.cabang_nama;}
		if(cabang_DataStore.baseParams.cabang_alamat!==null){cabang_alamat_print = cabang_DataStore.baseParams.cabang_alamat;}
		if(cabang_DataStore.baseParams.cabang_kota!==null){cabang_kota_print = cabang_DataStore.baseParams.cabang_kota;}
		if(cabang_DataStore.baseParams.cabang_kodepos!==null){cabang_kodepos_print = cabang_DataStore.baseParams.cabang_kodepos;}
		if(cabang_DataStore.baseParams.cabang_propinsi!==null){cabang_propinsi_print = cabang_DataStore.baseParams.cabang_propinsi;}
		if(cabang_DataStore.baseParams.cabang_keterangan!==null){cabang_keterangan_print = cabang_DataStore.baseParams.cabang_keterangan;}
		if(cabang_DataStore.baseParams.cabang_aktif!==null){cabang_aktif_print = cabang_DataStore.baseParams.cabang_aktif;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_cabang&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		
			cabang_nama : cabang_nama_print,
			cabang_alamat : cabang_alamat_print,
			cabang_kota : cabang_kota_print,
			cabang_kodepos : cabang_kodepos_print,
			cabang_propinsi : cabang_propinsi_print,
			cabang_keterangan : cabang_keterangan_print,
			cabang_aktif : cabang_aktif_print,
		  	currentlisting: cabang_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./cabanglist.html','cabanglist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
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
	function cabang_export_excel(){
		var searchquery = "";
		var cabang_nama_2excel=null;
		var cabang_alamat_2excel=null;
		var cabang_kota_2excel=null;
		var cabang_kodepos_2excel=null;
		var cabang_propinsi_2excel=null;
		var cabang_keterangan_2excel=null;
		var cabang_aktif_2excel=null;
		var win;              
		// check if we do have some search data...
		if(cabang_DataStore.baseParams.query!==null){searchquery = cabang_DataStore.baseParams.query;}
		if(cabang_DataStore.baseParams.cabang_nama!==null){cabang_nama_2excel = cabang_DataStore.baseParams.cabang_nama;}
		if(cabang_DataStore.baseParams.cabang_alamat!==null){cabang_alamat_2excel = cabang_DataStore.baseParams.cabang_alamat;}
		if(cabang_DataStore.baseParams.cabang_kota!==null){cabang_kota_2excel = cabang_DataStore.baseParams.cabang_kota;}
		if(cabang_DataStore.baseParams.cabang_kodepos!==null){cabang_kodepos_2excel = cabang_DataStore.baseParams.cabang_kodepos;}
		if(cabang_DataStore.baseParams.cabang_propinsi!==null){cabang_propinsi_2excel = cabang_DataStore.baseParams.cabang_propinsi;}
		if(cabang_DataStore.baseParams.cabang_keterangan!==null){cabang_keterangan_2excel = cabang_DataStore.baseParams.cabang_keterangan;}
		if(cabang_DataStore.baseParams.cabang_aktif!==null){cabang_aktif_2excel = cabang_DataStore.baseParams.cabang_aktif;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_cabang&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		
			cabang_nama : cabang_nama_2excel,
			cabang_alamat : cabang_alamat_2excel,
			cabang_kota : cabang_kota_2excel,
			cabang_kodepos : cabang_kodepos_2excel,
			cabang_propinsi : cabang_propinsi_2excel,
			cabang_keterangan : cabang_keterangan_2excel,
			cabang_aktif : cabang_aktif_2excel,
		  	currentlisting: cabang_DataStore.baseParams.task // this tells us if we are searching or not
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
        <div id="fp_cabang"></div>
		<div id="elwindow_cabang_create"></div>
        <div id="elwindow_cabang_search"></div>
    </div>
</div>
</body>