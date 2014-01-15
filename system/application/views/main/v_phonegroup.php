<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com,
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id

	+ Module  		: phonegroup View
	+ Description	: For record view
	+ Filename 		: v_phonegroup.php
 	+ creator  		:
 	+ Created on 01/Feb/2010 14:30:05

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
var phonegroup_DataStore;
var phonegroup_detail_DataStore;
var phonegroup_ColumnModel;
var phonegroupListEditorGrid;
var phonegroup_saveForm;
var phonegroup_saveWindow;
var phonegroup_searchForm;
var phonegroup_searchWindow;
var phonegroup_SelectedRow;
var phonegroup_ContextMenu;

//declare konstant
var post2db = '';
var msg = '';
var pageS=15;

/* declare variable here for Field*/
var phonegroup_idField;
var phonegroup_namaField;
var phonegroup_detailField;
var phonegroup_aktifField;
var phonegroup_idSearchField;
var phonegroup_namaSearchField;
var phonegroup_detailSearchField;
var phonegroup_aktifSearchField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  	Ext.form.Field.prototype.msgTarget = 'side';

  	/* Function for Saving inLine Editing */
	function phonegroup_inline_update(oGrid_event){
		var phonegroup_id_update_pk="";
		var phonegroup_nama_update=null;
		var phonegroup_detail_update=null;

		phonegroup_id_update_pk = oGrid_event.record.data.phonegroup_id;
		if(oGrid_event.record.data.phonegroup_nama!== null){phonegroup_nama_update = oGrid_event.record.data.phonegroup_nama;}
		if(oGrid_event.record.data.phonegroup_detail!== null){phonegroup_detail_update = oGrid_event.record.data.phonegroup_detail;}

		Ext.Ajax.request({
			waitMsg: 'Mohon tunggu...',
			url: 'index.php?c=c_phonegroup&m=get_action',
			params: {
				phonegroup_id	: phonegroup_id_update_pk,
				phonegroup_nama	:phonegroup_nama_update,
				phonegroup_detail	:phonegroup_detail_update,
				task: "UPDATE"
			},
			success: function(response){
				var result=eval(response.responseText);
				switch(result){
					case 1:
						phonegroup_DataStore.commitChanges();
						phonegroup_DataStore.reload();
						break;
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Data Phone Group tidak bisa disimpan',
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

  	/* Function for add and edit data form, open window form */
	function phonegroup_save(){

		if(is_phonegroup_form_valid()){
			var phonegroup_id_field_pk=null;
			var phonegroup_nama_field=null;
			var phonegroup_detail_field=null;
			var phonegroup_aktif_field=null;

			phonegroup_id_field_pk=get_pk_id();
			if(phonegroup_namaField.getValue()!== null){phonegroup_nama_field = phonegroup_namaField.getValue();}
			if(phonegroup_detailField.getValue()!== null){phonegroup_detail_field = phonegroup_detailField.getValue();}
			if(phonegroup_aktifField.getValue()!== null){phonegroup_aktif_field = phonegroup_aktifField.getValue();}

			Ext.Ajax.request({
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_phonegroup&m=get_action',
				params: {
					phonegroup_id		: phonegroup_id_field_pk,
					phonegroup_nama		: phonegroup_nama_field,
					phonegroup_detail	: phonegroup_detail_field,
					phonegroup_aktif 	: phonegroup_aktif_field,
					//phonegroup_data 	: phonegroup_saveForm.getForm().findField('itemselector').getValue(),
					task: post2db
				},
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:
							Ext.MessageBox.alert(post2db+' OK','Data Phonegroup berhasil disimpan ');
							phonegroup_DataStore.reload();
							phonegroup_saveWindow.hide();
							break;
						default:
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Data Phonegroup tidak bisa disimpan ',
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
			return phonegroupListEditorGrid.getSelectionModel().getSelected().get('phonegroup_id');
		else
			return 0;
	}
	/* End of Function  */

	/* Reset form before loading */
	function phonegroup_reset_form(){
		phonegroup_namaField.reset();
		phonegroup_namaField.setValue(null);
		phonegroup_detailField.reset();
		phonegroup_detailField.setValue(null);
		phonegroup_aktifField.reset();
		phonegroup_aktifField.setValue('Aktif');
		phonenumber_DataStore.removeAll();
		phonegrouped_DataStore.removeAll();
	}
 	/* End of Function */

	/* setValue to EDIT */
	function phonegroup_set_form(){
		phonegroup_namaField.setValue(phonegroupListEditorGrid.getSelectionModel().getSelected().get('phonegroup_nama'));
		phonegroup_detailField.setValue(phonegroupListEditorGrid.getSelectionModel().getSelected().get('phonegroup_detail'));
		phonegroup_aktifField.setValue(phonegroupListEditorGrid.getSelectionModel().getSelected().get('phonegroup_aktif'));
	}
	/* End setValue to EDIT*/

	/* Function for Check if the form is valid */
	function is_phonegroup_form_valid(){
		return (phonegroup_namaField.isValid());
	}
  	/* End of Function */

  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!phonegroup_saveWindow.isVisible()){

			post2db='CREATE';
			msg='created';
			phonegroup_reset_form();
			phonegroup_aktifField.setValue('Aktif');

			phonegroup_saveWindow.show();
		} else {
			phonegroup_saveWindow.toFront();
		}
	}
  	/* End of Function */

  	/* Function for Delete Confirm */
	function phonegroup_confirm_delete(){
		// only one phonegroup is selected here
		if(phonegroupListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', phonegroup_delete);
		} else if(phonegroupListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', phonegroup_delete);
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
	
	/* Function for Delete Confirm */
	function detail_phonegroup_confirm_delete(){
		// only one phonegroup is selected here
		if(phonegroupdetailEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', detail_phonegroup_delete);
		} else if(phonegroupdetailEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', detail_phonegroup_delete);
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
	function phonegroup_confirm_update(){
		/* only one record is selected here */
		if(phonegroupListEditorGrid.selModel.getCount() == 1) {

			post2db='UPDATE';
			msg='updated';
			phonegroup_set_form();

			phonegroup_saveWindow.show();
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
	function phonegroup_delete(btn){
		if(btn=='yes'){
			var selections = phonegroupListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< phonegroupListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.phonegroup_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_phonegroup&m=get_action',
				params: { task: "DELETE", ids:  encoded_array },
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							phonegroup_DataStore.reload();
							phonegroup_detail_DataStore.load();
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

	  /* Function for Delete Record */
	function detail_phonegroup_delete(btn2){
		if(btn2=='yes'){
			var selections = phonegroupdetailEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< phonegroupdetailEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.phonegrouped_cust);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_phonegroup&m=get_action',
				params: { task: "DELETEDETAIL", ids2:  encoded_array },
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							phonegroup_DataStore.reload();		
							Ext.MessageBox.alert(post2db+' OK','Detail Phonegroup berhasil dihapus ');
							phonegroup_detail_DataStore.load();
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
	phonegroup_DataStore = new Ext.data.Store({
		id: 'phonegroup_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_phonegroup&m=get_action',
			method: 'POST'
		}),
		baseParams:{task: "LIST", start: 0, limit:pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'phonegroup_id'
		},[
			{name: 'phonegroup_id', type: 'int', mapping: 'phonegroup_id'},
			{name: 'phonegroup_nama', type: 'string', mapping: 'phonegroup_nama'},
			{name: 'phonegroup_detail', type: 'string', mapping: 'phonegroup_detail'},
			{name: 'phonegroup_creator', type: 'string', mapping: 'phonegroup_creator'},
			{name: 'phonegroup_aktif', type: 'string', mapping: 'phonegroup_aktif'},
			{name: 'phonegroup_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'phonegroup_date_create'},
			{name: 'phonegroup_update', type: 'string', mapping: 'phonegroup_update'},
			{name: 'phonegroup_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'phonegroup_date_update'},
			{name: 'phonegroup_revised', type: 'int', mapping: 'phonegroup_revised'}
		]),
		sortInfo:{field: 'phonegroup_id', direction: "DESC"}
	});
	/* End of Function */

	/* Function for Retrieve DataStore */
	phonegroup_detail_DataStore = new Ext.data.GroupingStore({
		id: 'phonegroup_detail_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_phonegroup&m=get_action',
			method: 'POST'
		}),
		baseParams:{task: "LIST2", start: 0, limit:10000}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'phonegrouped_group'
		},[
			{name: 'phonegrouped_group', type: 'int', mapping: 'phonegrouped_group'},
			{name: 'phonegrouped_cust', type: 'int', mapping: 'phonegroup_cust'},
			{name: 'cust_nama', type: 'string', mapping: 'cust_nama'},
			{name: 'cust_no', type: 'string', mapping: 'cust_no'},
			{name: 'cust_alamat', type: 'string', mapping: 'cust_alamat'},
			{name: 'cust_kota', type: 'string', mapping: 'cust_kota'}
		]),
		sortInfo:{field: 'phonegrouped_group', direction: "DESC"}
	});
	/* End of Function */
	
  	/* Function for Identify of Window Column Model */
	phonegroup_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'phonegroup_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS
				return value;
				},
			hidden: true
		},
		{
			header: 'Nama Group',
			dataIndex: 'phonegroup_nama',
			width: 200,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_PHONEGROUP'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
			<?php } ?>
		},
		{
			header: 'Keterangan',
			dataIndex: 'phonegroup_detail',
			width: 300,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_PHONEGROUP'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 500
          	})
			<?php } ?>
		},
		{
			header: 'Creator',
			dataIndex: 'phonegroup_creator',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		},
		{
			header: 'Create on',
			dataIndex: 'phonegroup_date_create',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		},
		{
			header: 'Last Update by',
			dataIndex: 'phonegroup_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		},
		{
			header: 'Last Update on',
			dataIndex: 'phonegroup_date_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		},
		{
			header: 'Revised',
			dataIndex: 'phonegroup_revised',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}	]);

	phonegroup_ColumnModel.defaultSortable= true;
	/* End of Function */

	  	/* Function for Identify of Window Column Model */
	phonegroup_detail_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'phonegrouped_group',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS
				return value;
				},
			hidden: true
		},
		{
			align : 'right',
			header: '<div align="center">' + 'No' + '</div>',
			renderer: function(v, p, r, rowIndex, i, ds){return '' + (rowIndex+1)},
			width: 4
		},
		{
			header: 'Client Card',
			dataIndex: 'cust_no',
			width: 80,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_PHONEGROUP'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
			<?php } ?>
		},
		{
			header: 'Nama',
			dataIndex: 'cust_nama',
			width: 150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_PHONEGROUP'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
			<?php } ?>
		},
		{
			header: 'Alamat',
			dataIndex: 'cust_alamat',
			width: 200,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_PHONEGROUP'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
			<?php } ?>
		},
		{
			header: 'Kota',
			dataIndex: 'cust_kota',
			width: 100,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_PHONEGROUP'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
			<?php } ?>
		}]);

	phonegroup_detail_ColumnModel.defaultSortable= true;
	/* End of Function */
	
	/* Declare DataStore and  show datagrid list */
	phonegroupListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'phonegroupListEditorGrid',
		el: 'fp_phonegroup',
		title: 'Daftar Phone Group',
		autoHeight: true,
		store: phonegroup_DataStore, // DataStore
		cm: phonegroup_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 800,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: phonegroup_DataStore,
			displayInfo: true
		}),
		/* Add Control on ToolBar */
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_PHONEGROUP'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<?php }?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_PHONEGROUP'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: phonegroup_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_PHONEGROUP'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			//disabled: true,
			handler: phonegroup_confirm_delete   // Confirm before deleting
		}, '-',
		<?php } ?>
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window
		}, '-',
			new Ext.app.SearchField({
			store: phonegroup_DataStore,
			params: {start: 0, limit: pageS},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: phonegroup_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: phonegroup_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: phonegroup_print
		}
		]
	});
	phonegroupListEditorGrid.render();
	/* End of DataStore */
	
	
	phonegroupListEditorGrid.on('rowclick', function (phonegroupListEditorGrid, rowIndex, eventObj) {
        var recordMaster = phonegroupListEditorGrid.getSelectionModel().getSelected();
		phonegroup_namaField.setValue(recordMaster.get("phonegrouped_id"));
		phonegroup_detail_DataStore.load({params : {phonegroup_id : recordMaster.get("phonegroup_id")}});
    });

	/* Declare DataStore and  show datagrid list */
	phonegroupdetailEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'phonegroupdetailEditorGrid',
		el: 'fp_detailphonegroup',
		title: 'Detail Phone Group',
		autoHeight: true,
		store: phonegroup_detail_DataStore, // DataStore
		cm: phonegroup_detail_ColumnModel, // Nama-nama Columns
		
		view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Items" : "Item"]})'
        }),
        stripeRows: true,
        autoExpandColumn: 'company',
		
		enableColLock:false,
		frame: true,
		//clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		//selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 800,
		/*bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: phonegroup_detail_DataStore,
			displayInfo: true
		}),
		/* Add Control on ToolBar */
		tbar: [<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_PHONEGROUP'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			//disabled: true,
			handler: detail_phonegroup_confirm_delete   // Confirm before deleting
		}, '-',
		<?php } ?>
		'<span style="color:white;"> Info : <b>Untuk menambah detail phonegroup, dapat dilakukan pada modul Customer atau Informasi Pengambilan Paket.</b></span>'
		]
	});
	phonegroupdetailEditorGrid.render();
	
	
	/* Create Context Menu */
	phonegroup_ContextMenu = new Ext.menu.Menu({
		id: 'phonegroup_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_PHONEGROUP'))){ ?>
		{
			text: 'Edit', tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: phonegroup_confirm_update
		},
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_PHONEGROUP'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			//disabled: true,
			handler: phonegroup_confirm_delete
		},
		<?php } ?>
		'-',
		{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: phonegroup_print
		},
		{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: phonegroup_export_excel
		}
		]
	});
	/* End of Declaration */

	var customer_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{cust_no} : {cust_nama}</b><br /></span>',
            '{cust_alamat} | {cust_telprumah}',
        '</div></tpl>'
    );

	/* Event while selected row via context menu */
	function onphonegroup_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		phonegroup_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		phonegroup_SelectedRow=rowIndex;
		phonegroup_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */

	/* function for editing row via context menu */
	function phonegroup_editContextMenu(){
		//phonegroupListEditorGrid.startEditing(phonegroup_SelectedRow,1);
		phonegroup_confirm_update();
  	}
	/* End of Function */

	phonegroupListEditorGrid.addListener('rowcontextmenu', onphonegroup_ListEditGridContextMenu);
	phonegroup_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	phonegroupListEditorGrid.on('afteredit', phonegroup_inline_update); // inLine Editing Record

	/* Function for Retrieve DataStore */
	phonegrouped_DataStore = new Ext.data.Store({
		id: 'phonegrouped_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_phonegroup&m=get_phonegrouped',
			method: 'POST'
		}),
		baseParams:{start:0, limit: 15 }, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'phonenumber_number'
		},[
			{name: 'phonenumber_number', type: 'string', mapping: 'cust_hp'},
			{name: 'phonenumber_nama', type: 'string', mapping: 'cust_nama'},
			{name: 'phonenumber_id', type: 'int', mapping: 'cust_id'},
		]),
		sortInfo:{field: 'phonenumber_nama', direction: "ASC"}
	});

	/* Function for Retrieve DataStore */
	phonenumber_DataStore = new Ext.data.Store({
		id: 'phonenumer_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_phonegroup&m=get_available',
			method: 'POST'
		}),
		baseParams:{id: get_pk_id(),start:0, limit: 15, task: 'all'}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'phonenumber_number'
		},[
			{name: 'phonenumber_nama', type: 'string', mapping: 'cust_nama'},
			{name: 'phonenumber_number', type: 'string', mapping: 'cust_hp'},
			{name: 'phonenumber_no', type: 'string', mapping: 'cust_no'},
			{name: 'phonenumber_id', type: 'int', mapping: 'cust_id'}
		]),
		sortInfo:{field: 'phonenumber_nama', direction: "ASC"}
	});

	var cust_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{phonenumber_nama} ({phonenumber_no})</b><br /></span>',
            'No HP: {phonenumber_member}',
        '</div></tpl>'
    );

	/* Identify  phonegroup_nama Field */
	phonegroup_namaField= new Ext.form.TextField({
		id: 'phonegroup_namaField',
		fieldLabel: 'Nama Grup',
		maxLength: 250,
		anchor: '95%'
	});
	/* Identify  phonegroup_aktif Field */
	phonegroup_aktifField= new Ext.form.ComboBox({
		id: 'phonegroup_aktifField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['phonegroup_aktif_value', 'phonegroup_aktif_display'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		emptyText: 'Aktif',
		//allowBlank: true,
		displayField: 'phonegroup_aktif_display',
		valueField: 'phonegroup_aktif_value',
		anchor: '50%',
		triggerAction: 'all'	
	});
	/* Identify  phonegroup_detail Field */
	phonegroup_detailField= new Ext.form.TextArea({
		id: 'phonegroup_detailField',
		fieldLabel: 'Keterangan',
		maxLength: 500,
		anchor: '95%'
	});

	//datastore of profesi
	cbo_pgcust_profesi_DataStore = new Ext.data.Store({
		id: 'cbo_pgcust_profesi_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_customer&m=get_profesi_list',
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'cust_profesi'
		},[
			{name: 'cust_profesi_display', type: 'string', mapping: 'cust_profesi'}
		]),
		sortInfo:{field: 'cust_profesi_display', direction: "ASC"}
	});
	/* eof */

	//datastore of hobi
	cbo_pgcust_hobi_DataStore = new Ext.data.Store({
		id: 'cbo_pgcust_hobi_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_customer&m=get_hobi_list',
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'cust_hobi'
		},[
			{name: 'cust_hobi_display', type: 'string', mapping: 'cust_hobi'}
		]),
		sortInfo:{field: 'cust_hobi_display', direction: "ASC"}
	});
	/* eof */

	//datastore of hobi
	cbo_pgcust_cabang_DataStore = new Ext.data.Store({
		id: 'cbo_pgcust_cabang_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_customer&m=get_cabang_list',
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'cabang_id'
		},[
			{name: 'cust_cabang_value', type: 'int', mapping: 'cabang_id'},
			{name: 'cust_cabang_display', type: 'string', mapping: 'cabang_nama'}
		]),
		sortInfo:{field: 'cust_cabang_display', direction: "ASC"}
	});
	/* eof */


	var cbo_propinsi_DataStore = new Ext.data.Store({
		id: 'cbo_propinsi_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_customer&m=get_propinsi_list',
			method: 'POST'
		}),
		baseParams:{start: 0, limit: 10 }, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'propinsi_nama'
		},[
			{name: 'propinsi_nama', type: 'string', mapping: 'propinsi_nama'},
		]),
		sortInfo:{field: 'propinsi_nama', direction: "ASC"}
	});


	/*cbo_cust_DataStore = new Ext.data.Store({
		id: 'cbo_cust_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_phonegroup&m=get_customer_list',
			method: 'POST'
		}),
		baseParams:{start: 0, limit: 10 }, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'cust_id'
		},[
			{name: 'cust_id', type: 'int', mapping: 'cust_id'},
			{name: 'cust_no', type: 'string', mapping: 'cust_no'},
			{name: 'cust_nama', type: 'string', mapping: 'cust_nama'},
			{name: 'cust_tgllahir', type: 'date', dateFormat: 'Y-m-d', mapping: 'cust_tgllahir'},
			{name: 'cust_alamat', type: 'string', mapping: 'cust_alamat'},
			{name: 'cust_telprumah', type: 'string', mapping: 'cust_telprumah'}
		]),
		sortInfo:{field: 'cust_no', direction: "ASC"}
	});*/


	var pgcust_kota_SearchField=new Ext.form.TextField({
		id: 'pgcust_kota_SearchField',
		name: 'pgcust_kota_SearchField',
		fieldLabel: 'Kota',
		anchor: '98%'
	});

	var pgcust_no_SearchField=new Ext.form.TextField({
		id: 'pgcust_no_SearchField',
		name: 'pgcust_no_SearchField',
		fieldLabel: 'No Customer',
		anchor: '98%'
	});

	var pgcust_nama_SearchField=new Ext.form.TextField({
		id: 'pgcust_nama_SearchField',
		name: 'pgcust_nama_SearchField',
		fieldLabel: 'Nama Customer',
		anchor: '98%'
	});

	/* Identify  cust_kelamin Field */
	var pgcust_kelamin_SearchField= new Ext.form.ComboBox({
		id: 'pgcust_kelamin_SearchField',
		fieldLabel: 'Jenis Kelamin',
		store:new Ext.data.SimpleStore({
			fields:['cust_kelamin_value', 'cust_kelamin_display'],
			data:[['L','Laki-laki'],['P','Perempuan']]
		}),
		mode: 'local',
		editable: false,
		displayField: 'cust_kelamin_display',
		valueField: 'cust_kelamin_value',
		//allowBlank: false,
		anchor: '55%',
		triggerAction: 'all'
	});

	/*var pgcust_custSearchField= new Ext.form.ComboBox({
		id: 'pgcust_custSearchField',
		fieldLabel: 'Customer',
		store: cbo_cust_DataStore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: customer_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});*/



	var pgcust_propinsi_SearchField= new Ext.form.ComboBox({
		id: 'pgcust_propinsi_SearchField',
		fieldLabel: 'Propinsi',
		maxLength: 100,
		store: cbo_propinsi_DataStore,
		mode: 'remote',
		editable: false,
		displayField: 'propinsi_nama',
		valueField: 'propinsi_nama',
		anchor: '98%',
		triggerAction: 'all'
	});

	/* Identify  cust_agama Field */
	var pgcust_agama_SearchField= new Ext.form.ComboBox({
		id: 'pgcust_agama_SearchField',
		fieldLabel: 'Agama',
		maxLength: 50,
		store:new Ext.data.SimpleStore({
			fields:['cust_agama_value_display'],
			data: [['Islam'],['Katholik'],['Kristen'],['Hindu'],['Budha'],['Konghucu'],['Lainnya']]
		}),
		mode: 'local',
		editable: false,
		displayField: 'cust_agama_value_display',
		valueField: 'cust_agama_value_display',
		anchor: '60%',
		triggerAction: 'all'
	});

	/* Identify  cust_pendidikan Field */
	var pgcust_pendidikan_SearchField= new Ext.form.ComboBox({
		id: 'pgcust_pendidikan_SearchField',
		fieldLabel: 'Pendidikan',
		maxLength: 50,
		store:new Ext.data.SimpleStore({
			fields:['cust_pendidikan_value_display'],
			data: [['SMA'],['Diploma/Akademi'],['Sarjana (S1)'],['Pasca Sarjana (S2)'],['Doktoral (S3)'],['Lainnya']]
		}),
		mode: 'local',
		editable: false,
		//allowBlank: false,
		displayField: 'cust_pendidikan_value_display',
		valueField: 'cust_pendidikan_value_display',
		anchor: '70%',
		triggerAction: 'all'
	});

	var pgcust_profesi_SearchField= new Ext.form.ComboBox({
		id: 'pgcust_profesi_SearchField',
		fieldLabel: 'Profesi',
		maxLength: 100,
		store: cbo_pgcust_profesi_DataStore,
		mode: 'remote',
		displayField: 'cust_profesi_display',
		valueField: 'cust_profesi_display',
		anchor: '98%',
		pageSize: pageS,
		triggerAction: 'all'
	});

	var pgcust_umur_SearchField= new Ext.form.TextField({
		id: 'pgcust_umur_SearchField',
		fieldLabel: 'Umur',
		anchor:'50%'
	});

	var pgcust_hobi_SearchField= new Ext.form.ComboBox({
		id: 'pgcust_hobi_SearchField',
		fieldLabel: 'Hobi',
		maxLength: 500,
		store: cbo_pgcust_hobi_DataStore,
		mode: 'remote',
		displayField: 'cust_hobi_display',
		valueField: 'cust_hobi_display',
		anchor: '98%',
		pageSize: pageS,
		triggerAction: 'all'
	});

	var pgcust_stsnikah_SearchField= new Ext.form.ComboBox({
		id: 'pgcust_stsnikah_SearchField',
		fieldLabel: 'Status Pernikahan',
		store:new Ext.data.SimpleStore({
			fields:['cust_statusnikah_value', 'cust_statusnikah_display'],
			data:[['menikah','menikah'],['belum menikah','belum menikah']]
		}),
		mode: 'local',
		editable: false,
		//allowBlank: false,
		displayField: 'cust_statusnikah_display',
		valueField: 'cust_statusnikah_value',
		anchor: '70%',
		triggerAction: 'all'
	});

	var pgcust_priority_SearchField= new Ext.form.ComboBox({
		id: 'pgcust_priority_SearchField',
		fieldLabel: 'Priority',
		store:new Ext.data.SimpleStore({
			fields:['cust_priority_value', 'cust_priority_display'],
			data:[['Core','Core'],['Reguler','Reguler'],['Low','Low']]
		}),
		mode: 'local',
		editable: false,
		//allowBlank: false,
		displayField: 'cust_priority_display',
		valueField: 'cust_priority_value',
		anchor: '60%',
		triggerAction: 'all'
	});

	/* Identify  cust_unit Field */
	var pgcust_unit_SearchField= new Ext.form.ComboBox({
		id: 'pgcust_unit_SearchField',
		fieldLabel: 'Cabang',
		store: cbo_pgcust_cabang_DataStore,
		mode: 'remote',
		emptyText: 'Miracle Thamrin',
		editable: false,
		//allowBlank: false,
		displayField: 'cust_cabang_display',
		valueField: 'cust_cabang_value',
		anchor: '95%',
		triggerAction: 'all'
	});
	/* Identify  cust_aktif Field */
	var pgcust_aktif_SearchField= new Ext.form.ComboBox({
		id: 'pgcust_aktif_SearchField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['cust_aktif_value', 'cust_aktif_display'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		emptyText: 'Aktif',
		//allowBlank: true,
		displayField: 'cust_aktif_display',
		valueField: 'cust_aktif_value',
		anchor: '60%',
		triggerAction: 'all'
	});


	function phonegroup_cust_reset_search(){
		pgcust_umur_SearchField.reset();
		pgcust_agama_SearchField.reset();
		pgcust_kota_SearchField.reset();
		//pgcust_custSearchField.reset();
		pgcust_no_SearchField.reset();
		pgcust_nama_SearchField.reset();
		pgcust_propinsi_SearchField.reset();
		pgcust_pendidikan_SearchField.reset();
		pgcust_kelamin_SearchField.reset();
		pgcust_profesi_SearchField.reset();
		pgcust_stsnikah_SearchField.reset();
		pgcust_priority_SearchField.reset();
		pgcust_unit_SearchField.reset();
		pgcust_aktif_SearchField.reset();
		phonenumber_DataStore.removeAll();
		//phonegrouped_DataStore.removeAll();
	}

	function phonegroup_cust_list_search(){
		var cust_umur_search="";
		var cust_agama_search="";
		var cust_kota_search="";
		var cust_propinsi_search="";
		var cust_kelamin_search="";
		var cust_pendidikan_search="";
		var cust_profesi_search="";
		var cust_hobi_search="";
		var cust_stsnikah_search="";
		var cust_priority_search="";
		var cust_unit_search="";
		var cust_aktif_search="";
		var cust_no_search="";
		var cust_nama_search="";

		if( pgcust_umur_SearchField.getValue()!==""){ cust_umur_search=pgcust_umur_SearchField.getValue(); }
		if( pgcust_agama_SearchField.getValue()!==""){ cust_agama_search=pgcust_agama_SearchField.getValue(); }
		if( pgcust_kota_SearchField.getValue()!==""){ cust_kota_search=pgcust_kota_SearchField.getValue(); }
		if( pgcust_propinsi_SearchField.getValue()!==""){ cust_propinsi_search=pgcust_propinsi_SearchField.getValue(); }
		if( pgcust_pendidikan_SearchField.getValue()!==""){ cust_pendidikan_search=pgcust_pendidikan_SearchField.getValue(); }
		if( pgcust_kelamin_SearchField.getValue()!==""){ cust_kelamin_search=pgcust_kelamin_SearchField.getValue(); }
		if( pgcust_profesi_SearchField.getValue()!==""){ cust_profesi_search=pgcust_profesi_SearchField.getValue(); }
		if( pgcust_stsnikah_SearchField.getValue()!==""){ cust_stsnikah_search=pgcust_stsnikah_SearchField.getValue(); }
		if( pgcust_priority_SearchField.getValue()!==""){ cust_priority_search=pgcust_priority_SearchField.getValue(); }
		if( pgcust_unit_SearchField.getValue()!==""){ cust_unit_search=pgcust_unit_SearchField.getValue(); }
		if( pgcust_aktif_SearchField.getValue()!==""){ cust_aktif_search=pgcust_aktif_SearchField.getValue(); }
		if( pgcust_no_SearchField.getValue()!==""){ cust_no_search=pgcust_no_SearchField.getValue(); }
		if( pgcust_nama_SearchField.getValue()!==""){ cust_nama_search=pgcust_nama_SearchField.getValue(); }
		//if( pgcust_custSearchField.getValue()!==""){ cust_nama_search=pgcust_custSearchField.getValue(); }

		phonenumber_DataStore.baseParams = {
			task			: 	'search',
			group_id		:   get_pk_id(),
			umur			:	cust_umur_search,
			agama			:	cust_agama_search,
			kota			:	cust_kota_search,
			propinsi		:	cust_propinsi_search,
			pendidikan		:	cust_pendidikan_search,
			kelamin			:	cust_kelamin_search,
			profesi			:	cust_profesi_search,
			hobi			:	cust_hobi_search,
			stsnikah		:	cust_stsnikah_search,
			priority		:	cust_priority_search,
			unit			:	cust_unit_search,
			aktif			:	cust_aktif_search,
			no				:	cust_no_search,
			nama			:	cust_nama_search
		};
		// Cause the datastore to do another query :
		phonenumber_DataStore.reload({params: {start: 0, limit: pageS}});

	}

	/* Function for retrieve search Form Panel */
	var phonegroup_cust_searchForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 700,
		layout: 'column',
		border: true,
		items:[
			{
			   	layout: 'form',
				columnWidth: 0.5,
				border: false,
				items: [pgcust_no_SearchField, pgcust_nama_SearchField, pgcust_umur_SearchField, pgcust_agama_SearchField, pgcust_kota_SearchField,
						pgcust_propinsi_SearchField, pgcust_kelamin_SearchField, pgcust_pendidikan_SearchField  ]
			 },{
				layout: 'form',
				columnWidth: 0.5,
				border: false,
				items: [pgcust_profesi_SearchField, pgcust_hobi_SearchField, pgcust_stsnikah_SearchField, pgcust_priority_SearchField,
						pgcust_unit_SearchField, pgcust_aktif_SearchField ]

			}
		],
		buttons: [{
				text: 'Search',
				handler: phonegroup_cust_list_search
			},{
				text: 'Close',
				handler: function(){
					phonegroup_cust_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */

	/* Function for retrieve search Window Form, used for andvaced search */
	var phonegroup_cust_searchWindow = new Ext.Window({
		title: 'Pencarian Customer',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_phonegroup_cust_search',
		items: phonegroup_cust_searchForm
	});
    /* End of Function */


	function display_cust_phonegroup_form_search_window(){
		phonegroup_cust_reset_search();
		if(!phonegroup_cust_searchWindow.isVisible()){
			phonegroup_cust_searchWindow.show();
		} else {
			phonegroup_cust_searchWindow.toFront();
		}
	}

	/* Function for retrieve create Window Panel*/
	phonegroup_saveForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 400,
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [phonegroup_namaField, phonegroup_detailField, phonegroup_aktifField]
			}
			],
		buttons: [
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_PHONEGROUP'))){ ?>
			{
				text: 'Save and Close',
				handler: phonegroup_save
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					phonegroup_saveWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/

	/* Function for retrieve create Window Form */
	phonegroup_saveWindow= new Ext.Window({
		id: 'phonegroup_saveWindow',
		title: post2db+' Phone Group',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_phonegroup_save',
		items: phonegroup_saveForm
	});
	/* End Window */

	/* Function for action list search */
	function phonegroup_list_search(){
		// render according to a SQL date format.
		var phonegroup_id_search=null;
		var phonegroup_nama_search=null;
		var phonegroup_detail_search=null;
		var phonegroup_aktif_search=null;

		if(phonegroup_idSearchField.getValue()!==null){phonegroup_id_search=phonegroup_idSearchField.getValue();}
		if(phonegroup_namaSearchField.getValue()!==null){phonegroup_nama_search=phonegroup_namaSearchField.getValue();}
		if(phonegroup_detailSearchField.getValue()!==null){phonegroup_detail_search=phonegroup_detailSearchField.getValue();}
		if(phonegroup_aktifSearchField.getValue()!==null){phonegroup_aktif_search=phonegroup_aktifSearchField.getValue();}
		
		// change the store parameters
		phonegroup_DataStore.baseParams = {
			task: 'SEARCH',
			//variable here
			phonegroup_id	:	phonegroup_id_search,
			phonegroup_nama	:	phonegroup_nama_search,
			phonegroup_detail	:	phonegroup_detail_search,
			phonegroup_aktif : phonegroup_aktif_search
		};
		// Cause the datastore to do another query :
		phonegroup_DataStore.reload({params: {start: 0, limit: pageS}});
	}

	/* Function for reset search result */
	function phonegroup_reset_search(){
		// reset the store parameters
		phonegroup_DataStore.baseParams = { task: 'LIST', start: 0, limit: pageS };
		// Cause the datastore to do another query :
		phonegroup_DataStore.reload({params: {start: 0, limit: pageS}});
		//phonegroup_searchWindow.close();
	};
	/* End of Fuction */
	
	function customer_reset_SearchForm(){
		phonegroup_namaSearchField.reset();
		phonegroup_detailSearchField.reset();
		phonegroup_aktifSearchField.reset();
	}
	
	/* Function for reset search result */
	function phonegrouped_reset_search(){
		// reset the store parameters
		phonegroup_detail_DataStore.baseParams = { task: 'LIST2', start: 0, limit: pageS };
		// Cause the datastore to do another query :
		phonegroup_detail_DataStore.reload({params: {start: 0, limit: pageS}});
		phonegroup_searchWindow.close();
	};
	/* End of Fuction */

	/* Field for search */
	/* Identify  phonegroup_id Search Field */
	phonegroup_idSearchField= new Ext.form.NumberField({
		id: 'phonegroup_idSearchField',
		fieldLabel: 'Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/

	});
	/* Identify  phonegroup_nama Search Field */
	phonegroup_namaSearchField= new Ext.form.TextField({
		id: 'phonegroup_namaSearchField',
		fieldLabel: 'Nama',
		maxLength: 250,
		anchor: '95%'

	});
	/* Identify  phonegroup_detail Search Field */
	phonegroup_detailSearchField= new Ext.form.TextArea({
		id: 'phonegroup_detailSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 500,
		anchor: '95%'

	});

	/* Identify  phonegroup_aktif Field */
	phonegroup_aktifSearchField= new Ext.form.ComboBox({
		id: 'phonegroup_aktifSearchField',
		fieldLabel: 'Status',
		store:new Ext.data.SimpleStore({
			fields:['phonegroup_aktif_value', 'phonegroup_aktif_display'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		displayField: 'phonegroup_aktif_display',
		valueField: 'phonegroup_aktif_value',
		emptyText: 'Aktif',
		//anchor: '100%',
		triggerAction: 'all'	
	});
	
	/* Function for retrieve search Form Panel */
	phonegroup_searchForm = new Ext.FormPanel({
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
				items: [phonegroup_namaSearchField, phonegroup_detailSearchField, phonegroup_aktifSearchField]
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: phonegroup_list_search
			},{
				text: 'Close',
				handler: function(){
					phonegroup_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */

	/* Function for retrieve search Window Form, used for andvaced search */
	phonegroup_searchWindow = new Ext.Window({
		title: 'Pencarian Phonegroup',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_phonegroup_search',
		items: phonegroup_searchForm
	});
    /* End of Function */

  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!phonegroup_searchWindow.isVisible()){
			customer_reset_SearchForm();
			phonegroup_aktifSearchField.setValue('Aktif');
			phonegroup_searchWindow.show();
		} else {
			phonegroup_searchWindow.toFront();
		}
	}
  	/* End Function */

	/* Function for print List Grid */
	function phonegroup_print(){
		var searchquery = "";
		var phonegroup_nama_print=null;
		var phonegroup_detail_print=null;
		var phonegroup_aktif_print=null;
		var win;
		// check if we do have some search data...
		if(phonegroup_DataStore.baseParams.query!==null){searchquery = phonegroup_DataStore.baseParams.query;}
		if(phonegroup_DataStore.baseParams.phonegroup_nama!==null){phonegroup_nama_print = phonegroup_DataStore.baseParams.phonegroup_nama;}
		if(phonegroup_DataStore.baseParams.phonegroup_detail!==null){phonegroup_detail_print = phonegroup_DataStore.baseParams.phonegroup_detail;}
		if(phonegroup_DataStore.baseParams.phonegroup_detail!==null){phonegroup_aktif_print = phonegroup_DataStore.baseParams.phonegroup_aktif;}

		Ext.Ajax.request({
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_phonegroup&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,
			phonegroup_nama : phonegroup_nama_print,
			phonegroup_aktif : phonegroup_aktif_print,
			phonegroup_detail : phonegroup_detail_print,
		  	currentlisting: phonegroup_DataStore.baseParams.task // this tells us if we are searching or not
		},
		success: function(response){
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/phonegroup_printlist.html','phonegrouplist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');

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
	function phonegroup_export_excel(){
		var searchquery = "";
		var phonegroup_nama_2excel=null;
		var phonegroup_detail_2excel=null;
		var phonegroup_aktif_2excel=null;
		var win;
		// check if we do have some search data...
		if(phonegroup_DataStore.baseParams.query!==null){searchquery = phonegroup_DataStore.baseParams.query;}
		if(phonegroup_DataStore.baseParams.phonegroup_nama!==null){phonegroup_nama_2excel = phonegroup_DataStore.baseParams.phonegroup_nama;}
		if(phonegroup_DataStore.baseParams.phonegroup_detail!==null){phonegroup_detail_2excel = phonegroup_DataStore.baseParams.phonegroup_detail;}
		if(phonegroup_DataStore.baseParams.phonegroup_detail!==null){phonegroup_aktif_2excel = phonegroup_DataStore.baseParams.phonegroup_aktif;}
		
		Ext.Ajax.request({
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_phonegroup&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,
			phonegroup_nama : phonegroup_nama_2excel,
			phonegroup_detail : phonegroup_detail_2excel,
			phonegroup_aktif : phonegroup_aktif_2excel,
		  	currentlisting: phonegroup_DataStore.baseParams.task // this tells us if we are searching or not
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
	phonegroup_saveWindow.on("show",function(){
			phonegrouped_DataStore.setBaseParam('id',get_pk_id());
			phonenumber_DataStore.setBaseParam('id',get_pk_id());
			//phonenumber_DataStore.load();
			phonegrouped_DataStore.load();
	});


});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_phonegroup"></div>
		<div id="fp_detailphonegroup"></div>
		<div id="elwindow_phonegroup_save"></div>
        <div id="elwindow_phonegroup_search"></div>
        <div id="elwindow_phonegroup_cust_search"></div>
    </div>
</div>
</body>