<?
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com,
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id

	+ Module  		: usergroups View
	+ Description	: For record view
	+ Filename 		: v_usergroups.php
 	+ Author  		: zainal, mukhlison
 	+ Created on 17/Jul/2009 11:36:16

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
var usergroups_DataStore;
var usergroups_ColumnModel;
var usergroupsListEditorGrid;
var usergroups_createForm;
var usergroups_createWindow;
var usergroups_searchForm;
var usergroups_searchWindow;
var usergroups_SelectedRow;
var usergroups_ContextMenu;
//declare konstant
var post2db = '';
var msg = '';
var pageS=15;

/* declare variable here */
var group_idField;
var group_nameField;
var group_descField;
var group_activeField;
var group_idSearchField;
var group_nameSearchField;
var group_descSearchField;
var group_activeSearchField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */

  	/* Function for Saving inLine Editing */
	function usergroups_update(oGrid_event){
	var group_id_update_pk="";
	var group_name_update=null;
	var group_desc_update=null;
	var group_active_update=null;

	group_id_update_pk = oGrid_event.record.data.group_id;
	if(oGrid_event.record.data.group_name!== null){group_name_update = oGrid_event.record.data.group_name;}
	if(oGrid_event.record.data.group_desc!== null){group_desc_update = oGrid_event.record.data.group_desc;}
	if(oGrid_event.record.data.group_active!== null){group_active_update = oGrid_event.record.data.group_active;}

		Ext.Ajax.request({
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_usergroups&m=get_action',
			params: {
				task			: "UPDATE",
				group_id		: group_id_update_pk,
				group_name		: group_name_update,
				group_desc		: group_desc_update,
				group_active	: group_active_update
			},
			success: function(response){
				var result=eval(response.responseText);
				if(result!==0){
						Ext.MessageBox.alert(post2db+' OK','Group dan Hak Akses berhasil disimpan');
						usergroups_DataStore.commitChanges();
						usergroups_DataStore.reload();
				}else{
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Group dan Hak Akses tidak bisa disimpan',
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
	}
  	/* End of Function */

  	/* Function for add data, open window create form */
	function usergroups_create(){
				//usergroups_reset_form();

		if(is_usergroups_form_valid()){

		var group_id_create_pk=null;
		var group_name_create=null;
		var group_desc_create=null;
		var group_active_create=null;

		group_id_create_pk=get_pk_id();
		if(group_nameField.getValue()!== null){group_name_create = group_nameField.getValue();}
		if(group_descField.getValue()!== null){group_desc_create = group_descField.getValue();}
		if(group_activeField.getValue()!== null){group_active_create = group_activeField.getValue();}

			Ext.Ajax.request({
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_usergroups&m=get_action',
				params: {
					task			: post2db,
					group_id		: group_id_create_pk,
					group_name		: group_name_create,
					group_desc		: group_desc_create,
					group_active	: group_active_create
				},
				success: function(response){
					var result=eval(response.responseText);
					if(result!==0){
						permission_insert(result);
					}else{
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Group dan Hak Akses tidak bisa disimpan',
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
			return usergroupsListEditorGrid.getSelectionModel().getSelected().get('group_id');
		else
			return 0;
	}
	/* End of Function  */

	/* Reset form before loading */
	function usergroups_reset_form(){
		group_nameField.reset();
		group_nameField.setValue(null);
		group_descField.reset();
		group_descField.setValue(null);
		group_activeField.reset();
		group_activeField.setValue(null);
		group_allprivField.reset();
		group_allprivField.setValue(false);
		group_allreadprivField.reset();
		group_allreadprivField.setValue(false);
		group_allcreateprivField.reset();
		group_allcreateprivField.setValue(false);
		group_allupdateprivField.reset();
		group_allupdateprivField.setValue(false);
		group_alldeleteprivField.reset();
		group_alldeleteprivField.setValue(false);
		group_allprintprivField.reset();
		group_allprintprivField.setValue(false);
		/*group_allhargaprivField.reset();
		group_allhargaprivField.setValue(false);*/
		

	}
 	/* End of Function */

	/* setValue to EDIT */
	function usergroups_set_form(){
		group_nameField.setValue(usergroupsListEditorGrid.getSelectionModel().getSelected().get('group_name'));
		group_descField.setValue(usergroupsListEditorGrid.getSelectionModel().getSelected().get('group_desc'));
		group_activeField.setValue(usergroupsListEditorGrid.getSelectionModel().getSelected().get('group_active'));
		group_allprivField.setValue(false);
		group_allreadprivField.setValue(false);
		group_allcreateprivField.setValue(false);
		group_allupdateprivField.setValue(false);
		group_alldeleteprivField.setValue(false);
		group_allprintprivField.setValue(false);
		//group_allhargaprivField.setValue(false);
		/*if(menu_id == 31){
			lain_label.setValue("Harga");
			permissionListEditorGrid.get
		}*/
	}
	/* End setValue to EDIT*/

	/* Function for Check if the form is valid */
	function is_usergroups_form_valid(){
		return (true &&  group_nameField.isValid() && group_activeField.isValid() );
	}
  	/* End of Function */

  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!usergroups_createWindow.isVisible()){
			post2db='CREATE';
			msg='created';
			usergroups_reset_form();

			usergroups_createWindow.show();
			permission_DataStore.load({params:{group:0}});
			//permissionListEditorGrid.reconfigure(permission_DataStore,permission_ColumnModel);
		} else {
			usergroups_createWindow.toFront();
		}
	}
  	/* End of Function */

  	/* Function for Delete Confirm */
	function usergroups_confirm_delete(){
		// only one usergroups is selected here
		if(usergroupsListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data berikut?', usergroups_delete);
		} else if(usergroupsListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Apakah Anda yakin akan menghapus data-data berikut?', usergroups_delete);
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
	function usergroups_confirm_update(){
		/* only one record is selected here */
		if(usergroupsListEditorGrid.selModel.getCount() == 1) {
			post2db='UPDATE';
			msg='updated';
			usergroups_set_form();
			permission_DataStore.setBaseParam('group',get_pk_id());
			permission_DataStore.load();
			usergroups_createWindow.show();
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
	function usergroups_delete(btn){
		if(btn=='yes'){
			var selections = usergroupsListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< usergroupsListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.group_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_usergroups&m=get_action',
				params: { task: "DELETE", ids:  encoded_array },
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							usergroups_DataStore.reload();
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
	usergroups_DataStore = new Ext.data.Store({
		id: 'usergroups_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_usergroups&m=get_action',
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit: pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'group_id'
		},[
			{name: 'group_id', type: 'int', mapping: 'group_id'},
			{name: 'group_name', type: 'string', mapping: 'group_name'},
			{name: 'group_desc', type: 'string', mapping: 'group_desc'},
			{name: 'group_active', type: 'string', mapping: 'group_active'}
		]),
		sortInfo:{field: 'group_id', direction: "ASC"}
	});
	/* End of Function */

  	/* Function for Identify of Window Column Model */
	usergroups_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'group_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS
				return value;
				},
			hidden: true
		},
		{
			header: 'Nama Group',
			dataIndex: 'group_name',
			width: 150,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_USERGROUP'))){ ?>
			,
			editor: new Ext.form.TextField({
				allowBlank: false,
				maxLength: 50
          	})
			<?php } ?>
		},
		{
			header: 'Keterangan',
			dataIndex: 'group_desc',
			width: 200,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_USERGROUP'))){ ?>
			,
			editor: new Ext.form.TextField({
				maxLength: 250
          	})
			<?php } ?>
		},
		{
			header: 'Status',
			dataIndex: 'group_active',
			width: 80,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_USERGROUP'))){ ?>
			,
			editor: new Ext.form.ComboBox({
				typeAhead: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({
					fields:['group_active_value', 'group_active_display'],
					data: [['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
					}),
				mode: 'local',
               	displayField: 'group_active_display',
               	valueField: 'group_active_value',
               	lazyRender:true,
               	listClass: 'x-combo-list-small'
            })
			<?php } ?>
		}]
	);
	usergroups_ColumnModel.defaultSortable= true;
	/* End of Function */

	/* Declare DataStore and  show datagrid list */
	usergroupsListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'usergroupsListEditorGrid',
		el: 'fp_usergroups',
		title: 'Daftar Grup User',
		autoHeight: true,
		store: usergroups_DataStore, // DataStore
		cm: usergroups_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 700,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: usergroups_DataStore,
			displayInfo: true
		}),
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_USERGROUP'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<?php } ?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_USERGROUP'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: usergroups_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_USERGROUP'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: usergroups_confirm_delete   // Confirm before deleting
		}, '-',
		<?php } ?>
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window
		}, '-',
			new Ext.app.SearchField({
			store: usergroups_DataStore,
			params: {start: 0, limit: pageS},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: usergroups_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: usergroups_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: usergroups_print
		}
		]
	});
	usergroupsListEditorGrid.render();
	/* End of DataStore */

	/* Create Context Menu */
	usergroups_ContextMenu = new Ext.menu.Menu({
		id: 'usergroups_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_USERGROUP'))){ ?>
		{
			text: 'Edit', tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: usergroups_confirm_update
		},
		<?php } ?>
		<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_USERGROUP'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: usergroups_confirm_delete
		},
		<?php } ?>
		'-',
		{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: usergroups_print
		},
		{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: usergroups_export_excel
		}
		]
	});
	/* End of Declaration */

	/* Event while selected row via context menu */
	function onusergroups_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		usergroups_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		usergroups_SelectedRow=rowIndex;
		usergroups_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */

	/* function for editing row via context menu */
	function usergroups_editContextMenu(){
      usergroupsListEditorGrid.startEditing(usergroups_SelectedRow,1);
  	}
	/* End of Function */

	usergroupsListEditorGrid.addListener('rowcontextmenu', onusergroups_ListEditGridContextMenu);
	usergroups_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	usergroupsListEditorGrid.on('afteredit', usergroups_update); // inLine Editing Record

	/* Identify  group_name Field */
	group_nameField= new Ext.form.TextField({
		id: 'group_nameField',
		fieldLabel: 'Nama Group',
		maxLength: 50,
		allowBlank: false,
		anchor: '95%'
	});
	/* Identify  group_desc Field */
	group_descField= new Ext.form.TextArea({
		id: 'group_descField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '95%'
	});
	/* Identify  group_active Field */
	group_activeField= new Ext.form.ComboBox({
		id: 'group_activeField',
		fieldLabel: 'Aktif',
		store:new Ext.data.SimpleStore({
			fields:['group_active_value', 'group_active_display'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		displayField: 'group_active_display',
		valueField: 'group_active_value',
		allowBlank: false,
		width: 80,
		triggerAction: 'all'
	});

	/* Identify  group_desc Field */
	group_allprivField= new Ext.form.Checkbox({
		id: 'group_allprivField',
		fieldLabel: 'All Privileges ?',
		maxLength: 250,
		anchor: '95%'
	});

	group_allreadprivField= new Ext.form.Checkbox({
		id: 'group_allreadprivField',
		fieldLabel: 'All Read?',
		maxLength: 250,
		anchor: '95%'
	});

	group_allcreateprivField= new Ext.form.Checkbox({
		id: 'group_allcreateprivField',
		fieldLabel: 'All Create?',
		maxLength: 250,
		anchor: '95%'
	});

	group_allupdateprivField= new Ext.form.Checkbox({
		id: 'group_allupdateprivField',
		fieldLabel: 'All Update?',
		maxLength: 250,
		anchor: '95%'
	});

	group_alldeleteprivField= new Ext.form.Checkbox({
		id: 'group_alldeleteprivField',
		fieldLabel: 'All Delete ?',
		maxLength: 250,
		anchor: '95%'
	});
	
	group_allprintprivField= new Ext.form.Checkbox({
		id: 'group_allprintprivField',
		fieldLabel: 'All Print/Excel ?',
		maxLength: 250,
		anchor: '95%'
	});
	
	/*group_allhargaprivField= new Ext.form.Checkbox({
		id: 'group_allhargaprivField',
		fieldLabel: 'All Harga ?',
		maxLength: 250,
		anchor: '95%'
	});*/

	group_permissionField=new Ext.form.FieldSet({
		fieldLabel:'Permission',
		layout: 'column',
		labelAlign: 'left',
		anchor: '95%',
		border: false,
		items:[{
			   		layout: 'form',
					border: false,
					columnWidth: 0.5,
					labelAlign: 'left',
					items:[group_allprivField]
			   }
			   ,{
				   	layout: 'form',
					border: false,
					columnWidth: 0.5,
					labelWidth: 80,
					labelAlign: 'left',
					items:[group_allreadprivField,group_allcreateprivField,group_allupdateprivField,group_alldeleteprivField,group_allprintprivField]
			   }]
	});
	//detail permission


	/* Function for Retrieve DataStore */
	permission_DataStore = new Ext.data.Store({
		id: 'permission_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_usergroups&m=get_permission',
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'menu_id'
		},[
			{name: 'menu_id', type: 'int', mapping: 'menu_id'},
			{name: 'menu_parent', type: 'int', mapping: 'menu_parent'},
			{name: 'menu_position', type: 'int', mapping: 'menu_position'},
			{name: 'menu_title', type: 'string', mapping: 'menu_title'},
			{name: 'perm_create', type: 'int', mapping: 'perm_create'},
			{name: 'perm_update', type: 'int', mapping: 'perm_update'},
			{name: 'perm_read', type: 'int', mapping: 'perm_read'},
			{name: 'perm_delete', type: 'int', mapping: 'perm_delete'},
			{name: 'perm_print', type: 'int', mapping: 'perm_print'},
			{name: 'perm_harga', type: 'int', mapping: 'perm_harga'}
		])
	});


	var readColumn = new Ext.grid.CheckColumn({
		header: '<div align="center">' + 'Read' + '</div>',
		dataIndex: 'perm_read',
		width: 60,
		sortable: false,
		renderer: function(v,params,record){
				if(record.data.menu_parent==0)
					return '';
				else{
				   params.css += ' x-grid3-check-col-td';
            		return '<div class="x-grid3-check-col'+(v?'-on':'')+' x-grid3-cc-'+this.id+'">&#160;</div>';
				}
			}
	});

	var createColumn = new Ext.grid.CheckColumn({
		header: '<div align="center">' + 'Create' + '</div>',
		dataIndex: 'perm_create',
		width: 60,
		sortable: false,
		renderer: function(v,params,record){
				if(record.data.menu_parent==0)
					return '';
				else  if((record.data.menu_id==437) /*cek apakah menu = Lap Net Sales*/ || (record.data.menu_id==86)) /*Lap Penerimaan Kas*/{
					params.css = ' x-gridcheck-col-td';
            		return '<div class="x-grid3-check-col'+(v?'-on':'')+' x-grid3-cc-'+this.id+'">&#160;</div>Graph';
				}else{
				   params.css = ' x-grid3-check-col-td';
            		return '<div class="x-grid3-check-col'+(v?'-on':'')+' x-grid3-cc-'+this.id+'">&#160;</div>';
				}
			}
	});

	var updateColumn = new Ext.grid.CheckColumn({
		header: '<div align="center">' + 'Update' + '</div>',
		dataIndex: 'perm_update',
		width: 60,
		sortable: false,
		renderer: function(v,params,record){
				if(record.data.menu_parent==0)
					return '';
				else{
				   params.css = ' x-grid3-check-col-td';
            		return '<div class="x-grid3-check-col'+(v?'-on':'')+' x-grid3-cc-'+this.id+'">&#160;</div>';
				}
				
			}
	});

	var deleteColumn = new Ext.grid.CheckColumn({
		header: '<div align="center">' + 'Delete' + '</div>',
		dataIndex: 'perm_delete',
		width: 60,
		sortable: false,
		renderer: function(v,params,record){
				if(record.data.menu_parent==0)
					return '';
				else{
				   	params.css = ' x-grid3-check-col-td';
            		return '<div class="x-grid3-check-col'+(v?'-on':'')+' x-grid3-cc-'+this.id+'">&#160;</div>';
				}
			}
	});
	
	var printColumn = new Ext.grid.CheckColumn({
		header: '<div align="center">' + 'Print & Excel' + '</div>',
		dataIndex: 'perm_print',
		width: 60,
		sortable: false,
		renderer: function(v,params,record){
				if(record.data.menu_parent==0)
					return '';
				else{
				   	params.css = ' x-grid3-check-col-td';
            		return '<div class="x-grid3-check-col'+(v?'-on':'')+' x-grid3-cc-'+this.id+'">&#160;</div>';
				}
			}
	});
	
	var lainColumn = new Ext.grid.CheckColumn({
		header: '<div align="center">' + 'Lain-lain' + '</div>',
		dataIndex: 'perm_harga',
		width: 60,
		sortable: true,
		renderer: function(v,params,record){
				if(record.data.menu_parent==0)
					return '';
				else if(record.data.menu_id==31){//cek apakah menu = order
					params.css = ' x-grid3-check-col-td';
            		return '<div class="x-grid3-check-col'+(v?'-on':'')+' x-grid3-cc-'+this.id+'">&#160;</div>Harga';
				}else if((record.data.menu_id==80) || (record.data.menu_id==81) || (record.data.menu_id==82) || (record.data.menu_id==37) || (record.data.menu_id==38) || (record.data.menu_id==39) || (record.data.menu_id==83)){//cek apakah menu = lap jual produk , rawat , paket / kasir jual produk, rawat, paket / lap ambil paket
					params.css = ' x-grid3-check-col-td';
            		return '<div class="x-grid3-check-col'+(v?'-on':'')+' x-grid3-cc-'+this.id+'">&#160;</div>Semua Tgl';
				}
				else if((record.data.menu_id==86) || (record.data.menu_id==441) || (record.data.menu_id==446)) {//cek apakah menu = lap penerimaan kas / lap jum tind semua dr
					params.css = ' x-grid3-check-col-td';
            		return '<div class="x-grid3-check-col'+(v?'-on':'')+' x-grid3-cc-'+this.id+'">&#160;</div>Online';
				}
				else if((record.data.menu_id==426) || (record.data.menu_id==421) || (record.data.menu_id==381)) {//cek apakah menu = lap penerimaan kas / lap jum tind semua dr
					params.css = ' x-grid3-check-col-td';
            		return '<div class="x-grid3-check-col'+(v?'-on':'')+' x-grid3-cc-'+this.id+'">&#160;</div>Hak Akses Semua';
				}
				else{
				   	params.css = ' x-grid3-check-col-td';
            		return '<div class="x-grid3-check-col'+(v?'-on':'')+' x-grid3-cc-'+this.id+'">&#160;</div>';
				}
			}
	});

	//readchk.unlock();
	/* Function for Identify of Window Column Model */
	permission_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'menu_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS
				return value;
				},
			hidden: true
		},
		{
			header: '<div align="center">' + 'Menu' + '</div>',
			dataIndex: 'menu_title',
			width: 160,
			readOnly: true,
			renderer: function(v,params,record){
				if(record.data.menu_parent==0)
					return '<b><font size=\'medium\'>'+record.data.menu_title+'</font></b>';
				else
					return record.data.menu_title;
			}
		},
		readColumn,
		createColumn,
		updateColumn,
		deleteColumn,
		printColumn,
		lainColumn
		]
	);


	function permission_insert(pkid){

		 var permission = [];
		 var menu = [];

		for(i=0;i<permission_DataStore.getCount();i++){
			var perm_priv="";
			var permission_record=permission_DataStore.getAt(i);
			if(permission_record.data.perm_read==1)
				perm_priv="R";
			if(permission_record.data.perm_create==1)
				perm_priv=perm_priv+"C";
			if(permission_record.data.perm_update==1)
				perm_priv=perm_priv+"U";
			if(permission_record.data.perm_delete==1)
				perm_priv=perm_priv+"D";
			if(permission_record.data.perm_print==1)
				perm_priv=perm_priv+"P";
			if(permission_record.data.perm_harga==1)
				perm_priv=perm_priv+"H";
							
			if(perm_priv!==""){
				permission.push(perm_priv);
				menu.push(permission_record.data.menu_id);
			}
		}

		var encoded_menu = Ext.encode(menu);
		var encoded_permission = Ext.encode(permission);


		Ext.Ajax.request({
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_usergroups&m=permission_insert',
			params:{
				menu_id		: encoded_menu,
				menu_group	: pkid,
				menu_priv	: encoded_permission
			},
			timeout: 360000,
			success: function(response){
				var result=eval(response.responseText);
				Ext.MessageBox.alert(post2db+' OK','Group dan Hak Akses sukses disimpan');
				usergroups_DataStore.reload();
				usergroups_createWindow.hide();
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
	//eof

	//function for purge detail
	function permission_purge(pkid){
		Ext.Ajax.request({
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_usergroups&m=permission_purge',
			params:{ menu_group: get_pk_id()},
			callback: function(opts, success, response){
				if(success){
					permission_insert(pkid);
					usergroups_DataStore.reload();
				}
			}
		});
	}



	/* Declare DataStore and  show datagrid list */
	permissionListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'permissionListEditorGrid',
		el: 'fp_permission',
		title: 'Daftar Hak Akses',
		autoHeight: true,
		store: permission_DataStore, // DataStore
		cm: permission_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		plugins: [readColumn,createColumn,updateColumn,deleteColumn,printColumn,lainColumn],
		clicksToEdit:1, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true, markDirty: false },
		autoSave: true,
	  	width: 790
	});
	//permissionListEditorGrid.render();
	/* End of DataStore */



	/* Function for retrieve create Window Panel*/
	usergroups_createForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 800,
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [group_nameField, group_descField, group_activeField,group_permissionField,permissionListEditorGrid]
			}
			]
		}]
		,
		buttons: [
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_USERGROUP'))){ ?>
			{
				text: 'Save and Close',
				handler: usergroups_create
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					usergroups_reset_form();
					usergroups_createWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/

	/* Function for retrieve create Window Form */
	usergroups_createWindow= new Ext.Window({
		id: 'usergroups_createWindow',
		title: post2db+' Group dan Hak Akses User',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_usergroups_create',
		items: usergroups_createForm
	});
	/* End Window */


	/* Function for action list search */
	function usergroups_list_search(){
		// render according to a SQL date format.
		var group_id_search=null;
		var group_name_search=null;
		var group_desc_search=null;
		var group_active_search=null;

		if(group_idSearchField.getValue()!==null){group_id_search=group_idSearchField.getValue();}
		if(group_nameSearchField.getValue()!==null){group_name_search=group_nameSearchField.getValue();}
		if(group_descSearchField.getValue()!==null){group_desc_search=group_descSearchField.getValue();}
		if(group_activeSearchField.getValue()!==null){group_active_search=group_activeSearchField.getValue();}
		// change the store parameters
		usergroups_DataStore.baseParams = {
			task: 'SEARCH',
			//variable here
			group_id	:	group_id_search,
			group_name	:	group_name_search,
			group_desc	:	group_desc_search,
			group_active	:	group_active_search
		};
		// Cause the datastore to do another query :
		usergroups_DataStore.reload({params: {start: 0, limit: pageS}});
	}

	/* Function for reset search result */
	function usergroups_reset_search(){
		// reset the store parameters
		usergroups_DataStore.baseParams = { task: 'LIST', start: 0, limit: pageS };
		// Cause the datastore to do another query :
		usergroups_DataStore.reload({params: {start: 0, limit: pageS}});
		usergroups_searchWindow.close();
	};
	/* End of Fuction */

	/* Field for search */
	/* Identify  group_id Search Field */
	group_idSearchField= new Ext.form.NumberField({
		id: 'group_idSearchField',
		fieldLabel: 'Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/

	});
	/* Identify  group_name Search Field */
	group_nameSearchField= new Ext.form.TextField({
		id: 'group_nameSearchField',
		fieldLabel: 'Nama Group',
		maxLength: 50,
		anchor: '95%'

	});
	/* Identify  group_desc Search Field */
	group_descSearchField= new Ext.form.TextArea({
		id: 'group_descSearchField',
		fieldLabel: 'Keterangan',
		maxLength: 250,
		anchor: '95%'

	});
	/* Identify  group_active Search Field */
	group_activeSearchField= new Ext.form.ComboBox({
		id: 'group_activeSearchField',
		fieldLabel: 'Aktif',
		store:new Ext.data.SimpleStore({
			fields:['value', 'group_active'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		displayField: 'group_active',
		valueField: 'value',
		width: 80,
		triggerAction: 'all'

	});

	/* Function for retrieve search Form Panel */
	usergroups_searchForm = new Ext.FormPanel({
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
				items: [group_nameSearchField, group_descSearchField, group_activeSearchField]
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: usergroups_list_search
			},{
				text: 'Close',
				handler: function(){
					usergroups_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */

	/* Function for retrieve search Window Form, used for andvaced search */
	usergroups_searchWindow = new Ext.Window({
		title: 'Pencarian Group User',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_usergroups_search',
		items: usergroups_searchForm
	});
    /* End of Function */

  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!usergroups_searchWindow.isVisible()){
			usergroups_searchWindow.show();
		} else {
			usergroups_searchWindow.toFront();
		}
	}
  	/* End Function */

	/* Function for print List Grid */
	function usergroups_print(){
		var searchquery = "";
		var group_name_print=null;
		var group_desc_print=null;
		var group_active_print=null;
		var win;
		// check if we do have some search data...
		if(usergroups_DataStore.baseParams.query!==null){searchquery = usergroups_DataStore.baseParams.query;}
		if(usergroups_DataStore.baseParams.group_name!==null){group_name_print = usergroups_DataStore.baseParams.group_name;}
		if(usergroups_DataStore.baseParams.group_desc!==null){group_desc_print = usergroups_DataStore.baseParams.group_desc;}
		if(usergroups_DataStore.baseParams.group_active!==null){group_active_print = usergroups_DataStore.baseParams.group_active;}

		Ext.Ajax.request({
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_usergroups&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,
			group_name : group_name_print,
			group_desc : group_desc_print,
			group_active : group_active_print,
		  	currentlisting: usergroups_DataStore.baseParams.task // this tells us if we are searching or not
		},
		success: function(response){
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./usergroupslist.html','usergroupslist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
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
	function usergroups_export_excel(){
		var searchquery = "";
		var group_name_2excel=null;
		var group_desc_2excel=null;
		var group_active_2excel=null;
		var win;
		// check if we do have some search data...
		if(usergroups_DataStore.baseParams.query!==null){searchquery = usergroups_DataStore.baseParams.query;}
		if(usergroups_DataStore.baseParams.group_name!==null){group_name_2excel = usergroups_DataStore.baseParams.group_name;}
		if(usergroups_DataStore.baseParams.group_desc!==null){group_desc_2excel = usergroups_DataStore.baseParams.group_desc;}
		if(usergroups_DataStore.baseParams.group_active!==null){group_active_2excel = usergroups_DataStore.baseParams.group_active;}

		Ext.Ajax.request({
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_usergroups&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,
			group_name : group_name_2excel,
			group_desc : group_desc_2excel,
			group_active : group_active_2excel,
		  	currentlisting: usergroups_DataStore.baseParams.task // this tells us if we are searching or not
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

	group_allprivField.on('check',function(){
			if(group_allprivField.getValue()==1)
			{
				for(i=0;i<permission_DataStore.getCount();i++){
					var datapriv=permission_DataStore.getAt(i);
					datapriv.data.perm_read=1;
					datapriv.data.perm_create=1;
					datapriv.data.perm_update=1;
					datapriv.data.perm_delete=1;
					datapriv.data.perm_print=1;
					datapriv.data.perm_harga=1;
				}
			}else{
				for(i=0;i<permission_DataStore.getCount();i++){
					var datapriv=permission_DataStore.getAt(i);
					datapriv.data.perm_read=0;
					datapriv.data.perm_create=0;
					datapriv.data.perm_update=0;
					datapriv.data.perm_delete=0;
					datapriv.data.perm_print=0;
					datapriv.data.perm_harga=0;
				}
			}
			permission_DataStore.commitChanges();
			permissionListEditorGrid.reconfigure(permission_DataStore,permission_ColumnModel);
	});

	group_allreadprivField.on('check',function(){
			if(group_allreadprivField.getValue()==1)
			{
				for(i=0;i<permission_DataStore.getCount();i++){
					var datapriv=permission_DataStore.getAt(i);
					datapriv.data.perm_read=1;
				}
			}else{
				for(i=0;i<permission_DataStore.getCount();i++){
					var datapriv=permission_DataStore.getAt(i);
					datapriv.data.perm_read=0;
				}
			}
			permission_DataStore.commitChanges();
			permissionListEditorGrid.reconfigure(permission_DataStore,permission_ColumnModel);
	});

	group_allcreateprivField.on('check',function(){
			if(group_allcreateprivField.getValue()==1)
			{
				for(i=0;i<permission_DataStore.getCount();i++){
					var datapriv=permission_DataStore.getAt(i);
					datapriv.data.perm_create=1;
				}
			}else{
				for(i=0;i<permission_DataStore.getCount();i++){
					var datapriv=permission_DataStore.getAt(i);
					datapriv.data.perm_create=0;
				}
			}
			permission_DataStore.commitChanges();
			permissionListEditorGrid.reconfigure(permission_DataStore,permission_ColumnModel);
	});

	group_allupdateprivField.on('check',function(){
			if(group_allupdateprivField.getValue()==1)
			{
				for(i=0;i<permission_DataStore.getCount();i++){
					var datapriv=permission_DataStore.getAt(i);
					datapriv.data.perm_update=1;
				}
			}else{
				for(i=0;i<permission_DataStore.getCount();i++){
					var datapriv=permission_DataStore.getAt(i);
					datapriv.data.perm_update=0;
				}
			}
			permission_DataStore.commitChanges();
			permissionListEditorGrid.reconfigure(permission_DataStore,permission_ColumnModel);
	});

	group_alldeleteprivField.on('check',function(){
			if(group_alldeleteprivField.getValue()==1)
			{
				for(i=0;i<permission_DataStore.getCount();i++){
					var datapriv=permission_DataStore.getAt(i);
					datapriv.data.perm_delete=1;
				}
			}else{
				for(i=0;i<permission_DataStore.getCount();i++){
					var datapriv=permission_DataStore.getAt(i);
					datapriv.data.perm_delete=0;
				}
			}
			permission_DataStore.commitChanges();
			permissionListEditorGrid.reconfigure(permission_DataStore,permission_ColumnModel);
	});
	
	group_allprintprivField.on('check',function(){
			if(group_allprintprivField.getValue()==1)
			{
				for(i=0;i<permission_DataStore.getCount();i++){
					var datapriv=permission_DataStore.getAt(i);
					datapriv.data.perm_print=1;
				}
			}else{
				for(i=0;i<permission_DataStore.getCount();i++){
					var datapriv=permission_DataStore.getAt(i);
					datapriv.data.perm_print=0;
				}
			}
			permission_DataStore.commitChanges();
			permissionListEditorGrid.reconfigure(permission_DataStore,permission_ColumnModel);
	});
	
	/*group_allhargaprivField.on('check',function(){
			if(group_allhargaprivField.getValue()==1)
			{
				for(i=0;i<permission_DataStore.getCount();i++){
					var datapriv=permission_DataStore.getAt(i);
					datapriv.data.perm_harga=1;
				}
			}else{
				for(i=0;i<permission_DataStore.getCount();i++){
					var datapriv=permission_DataStore.getAt(i);
					datapriv.data.perm_harga=0;
				}
			}
			permission_DataStore.commitChanges();
			permissionListEditorGrid.reconfigure(permission_DataStore,permission_ColumnModel);
	});*/

});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_permission"></div>
        <div id="fp_usergroups"></div>
		<div id="elwindow_usergroups_create"></div>
        <div id="elwindow_usergroups_search"></div>
    </div>
</div>
</body>