<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: draft View
	+ Description	: For record view
	+ Filename 		: v_draft.php
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
var draft_DataStore;
var draft_ColumnModel;
var draftListEditorGrid;
var draft_saveForm;
var draft_saveWindow;
var draft_searchForm;
var draft_searchWindow;
var draft_SelectedRow;
var draft_ContextMenu;

//declare konstant
var post2db = '';
var msg = '';
var pageS=15;

/* declare variable here for Field*/
var draft_idField;
var draft_destgroupField;
var draft_destnumField;
var draft_messageField;

var draft_idSearchField;
var draft_destinationSearchField;
var draft_messageSearchField;
var draft_dateSearchField;

var draft_count_isiField;
var max_isi=320;
var dua_sms = 'no';

var today = new Date();

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  	/* Function for Saving inLine Editing */
	function draft_inline_update(oGrid_event){
		var draft_id_update_pk="";
		var draft_message_update=null;

		draft_id_update_pk = oGrid_event.record.data.draft_id;
		if(oGrid_event.record.data.draft_message!== null){draft_message_update = oGrid_event.record.data.draft_message;}
	 	
		Ext.Ajax.request({  
			waitMsg: 'Mohon tunggu...',
			url: 'index.php?c=c_draft&m=get_action',
			params: {
				draft_id	: draft_id_update_pk, 
				draft_message	:draft_message_update,
				task: "UPDATE"
			}, 
			success: function(response){							
				var result=eval(response.responseText);
				switch(result){
					case 1:
						draft_DataStore.commitChanges();
						draft_DataStore.reload();
						break;
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   msg: 'Draft SMS tidak bisa disimpan',
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
 
  
  	/* Function for get PK field */
	function get_pk_id(){
		if(post2db=='UPDATE')
			return draftListEditorGrid.getSelectionModel().getSelected().get('draft_id');
		else 
			return 0;
	}
	/* End of Function  */
  

  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		draft_reset_form();
		if(!draft_saveWindow.isVisible()){
			post2db='CREATE';
			msg='created';
			draft_reset_form();
			draft_saveWindow.show();
		} else {
			draft_saveWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function draft_confirm_delete(){
		// only one draft is selected here
		if(draftListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', draft_delete);
		} else if(draftListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Confirmation','Anda yakin untuk menghapus data ini?', draft_delete);
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Anda belum memilih data yang akan dihapus',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
  
	/* Function for Update Confirm */
	function draft_confirm_update(){
		/* only one record is selected here */
		if(draftListEditorGrid.selModel.getCount() == 1) {
			post2db='UPDATE';
			msg='updated';
			draft_saveWindow.show();
			draft_set_form();
			setDisableAll();
			draft_custField.setDisabled(false);
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Anda belum memilih data yang akan diubah',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
  
  	/* Function for Delete Record */
	function draft_delete(btn){
		if(btn=='yes'){
			var selections = draftListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< draftListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.draft_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Mohon tunggu...',
				url: 'index.php?c=c_draft&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							draft_DataStore.reload();
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
	draft_DataStore = new Ext.data.Store({
		id: 'draft_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_draft&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'draft_id'
		},[
		/* dataIndex => insert intodraft_ColumnModel, Mapping => for initiate table column */ 
			{name: 'draft_id', type: 'int', mapping: 'draft_id'},
			{name: 'draft_destid', type: 'int', mapping: 'draft_destid'},

/*			{name: 'draft_jenis', type: 'string', mapping: 'draft_jenis'}, 
			{name: 'draft_destnama', type: 'string', mapping: 'draft_destination'}, 
			{name: 'draft_destnama_view', type: 'string', mapping: 'draft_destination_view'},
			{name: 'draft_dest_tglawal', type: 'int', mapping: 'draft_destination_tglawal'}, 
			{name: 'draft_dest_blnawal', type: 'int', mapping: 'draft_destination_blnawal'}, 
			{name: 'draft_dest_tglakhir', type: 'int', mapping: 'draft_destination_tglakhir'},
			{name: 'draft_dest_blnakhir', type: 'int', mapping: 'draft_destination_blnakhir'}, 
*/
			{name: 'draft_message', type: 'string', mapping: 'draft_message'}, 
			{name: 'draft_date', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'draft_date'}, 
			{name: 'draft_creator', type: 'string', mapping: 'draft_creator'}, 
			{name: 'draft_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'draft_date_create'}, 
			{name: 'draft_update', type: 'string', mapping: 'draft_update'}, 
			{name: 'draft_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'draft_date_update'}, 
			{name: 'draft_revised', type: 'int', mapping: 'draft_revised'} 
		]),
		sortInfo:{field: 'draft_id', direction: "DESC"}
	});
	/* End of Function */
    
  	/* Function for Identify of Window Column Model */
	draft_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'draft_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
				},
			hidden: true
		},
/*		{
			header: 'Jenis',
			dataIndex: 'draft_jenis',
			width: 80,
			sortable: true,
			readOnly: true
		}, 
		{
			header: 'Tujuan',
			dataIndex: 'draft_destnama_view',
			width: 200,
			sortable: true,
			readOnly: true
		}, 
*/
		{
			header: '<div align="center">Tanggal</div>',
			dataIndex: 'draft_date',
			width: 40,
			sortable: true,
			renderer: Ext.util.Format.dateRenderer('d-m-Y'),
			readOnly: true
		}, 
		{
			header: '<div align="center">Isi Pesan</div>',
			dataIndex: 'draft_message',
			width: 250,
			sortable: true
			<?php if(eregi('U',$this->m_security->get_access_group_by_kode('MENU_DRAFT'))){ ?>
			,
			editor: new Ext.form.TextArea({
				height: 5
			})
			<?php } ?>
		}, 
		{
			header: 'Creator',
			dataIndex: 'draft_creator',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Create on',
			dataIndex: 'draft_date_create',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Last Update by',
			dataIndex: 'draft_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Last Update on',
			dataIndex: 'draft_date_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Revised',
			dataIndex: 'draft_revised',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}	]);
	
	draft_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	/* Declare DataStore and  show datagrid list */
	draftListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'draftListEditorGrid',
		el: 'fp_draft',
		title: 'Draft SMS',
		autoHeight: true,
		store: draft_DataStore, // DataStore
		cm: draft_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 800,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: draft_DataStore,
			displayInfo: true
		}),
		
		tbar: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_DRAFT'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: draft_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_DRAFT'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: draft_confirm_delete   // Confirm before deleting
		}, '-', 
		<?php } ?>
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: draft_DataStore,
			params: {start: 0, limit: pageS},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: draft_reset_search,
			iconCls:'icon-refresh'
		},'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: draft_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: draft_print  
		}
		]
	});
	draftListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	draft_ContextMenu = new Ext.menu.Menu({
		id: 'draft_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_DRAFT'))){ ?>
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: draft_editContextMenu 
		},
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_DRAFT'))){ ?>
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			handler: draft_confirm_delete 
		},
		<?php } ?>
		'-',
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: draft_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: draft_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function ondraft_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		draft_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		draft_SelectedRow=rowIndex;
		draft_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function draft_editContextMenu(){
		//draftListEditorGrid.startEditing(draft_SelectedRow,1);
		draft_confirm_update();
  	}
	/* End of Function */
  	
	draftListEditorGrid.addListener('rowcontextmenu', ondraft_ListEditGridContextMenu);
	draft_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	draftListEditorGrid.on('afteredit', draft_inline_update); // inLine Editing Record
	
	
	/* setValue to EDIT */
	function draft_set_form(){
/*		var f_jenis=draftListEditorGrid.getSelectionModel().getSelected().get('draft_jenis');
		var f_dest=draftListEditorGrid.getSelectionModel().getSelected().get('draft_destnama');
		var f_dest_tgl_awal=draftListEditorGrid.getSelectionModel().getSelected().get('draft_dest_tglawal');
		var f_dest_bln_awal=draftListEditorGrid.getSelectionModel().getSelected().get('draft_dest_blnawal');
		var f_dest_tgl_akhir=draftListEditorGrid.getSelectionModel().getSelected().get('draft_dest_tglakhir');
		var f_dest_bln_akhir=draftListEditorGrid.getSelectionModel().getSelected().get('draft_dest_blnakhir');
*/		
		var f_isi=draftListEditorGrid.getSelectionModel().getSelected().get('draft_message');

/*		if(f_jenis=='Semua'){
			draft_semua_radioField.setValue(true);
		}else if(f_jenis=='Group'){
			draft_group_radioField.setValue(true);
			draft_destgroupField.setValue(f_dest);
			draft_destgroupField.setDisabled(false);
			draft_destgroupField.allowBlank=false;
		}else if(f_jenis=='Number'){
			draft_destnumField.setValue(f_dest);
			draft_number_radioField.setValue(true);
			draft_destnumField.setDisabled(false);
			draft_destnumField.allowBlank=false;
		}else if(f_jenis=='Ultah'){
			draft_ultah_radioField.setValue(true);
			draft_bulanlahir_startField.setValue(f_dest_bln_awal);
			draft_tgllahir_startField.setValue(f_dest_tgl_awal);
			draft_tgllahir_endField.setValue(f_dest_tgl_akhir);
			draft_bulanlahir_endField.setValue(f_dest_bln_akhir);
			
			draft_ultah_groupField.setDisabled(false);
			
		}else if(f_jenis=='Kelamin'){
			draft_kelamin_radioField.setValue(true);
			draft_kelaminField.setValue(f_dest);
			
			draft_kelaminField.setDisabled(false);
			draft_kelaminField.allowBlank=false;


		}else if(f_jenis=='Member'){
			draft_member_radioField.setValue(true);
			draft_membershipField.setValue(f_dest);
			
			draft_membershipField.setDisabled(false);
			draft_membershipField.allowBlank=false;
			
			if(f_dest=='Expired'){
				draft_tglexp_startField.setValue(f_dest_tgl_awal);
				draft_tglexp_endField.setValue(f_dest_tgl_akhir);
				draft_member_expField.setDisabled(false);
			}
		}
*/		
		draft_detailField.setValue(f_isi);
		//setDisableAll();
	}
	
	/* setValue to EDIT */
	function draft_reset_form(){
		draft_number_radioField.reset();
		draft_kelamin_checkField.reset();
		draft_ultah_checkField.reset();
		draft_member_radioField.reset();
		draft_crm_checkField.reset();
		draft_crmField.reset();
		draft_custField.reset();
		
		//draft_number_radioField.setValue();
		draft_kelamin_checkField.setValue(false);
		draft_ultah_checkField.setValue(false);
		//draft_member_radioField.setValue(false);
		draft_crm_checkField.setValue(false);
		draft_crmField.setValue('Medium');
	}
	
	
	function draft_save(post2db){
		if(is_draft_form_valid()){
			var draft_pk="";
			var draft_opsi="";
			var draft_dest="";
			var draft_isi="";
			var draft_jnsklm = "";
			var draft_ultah = "";
			var draft_crm = "";
			
			if(draft_detailField.getValue()!=="") draft_isi=draft_detailField.getValue();

			if(draft_semua_radioField.getValue()==true){
				draft_opsi='semua';
			}else if(draft_group_radioField.getValue()==true){
				draft_opsi='group';
				draft_dest=draft_destgroupField.getValue();
			}else if(draft_number_radioField.getValue()==true){
				draft_opsi='number';
				draft_dest=draft_destnumField.getValue();
			}else if(draft_cust_radioField.getValue()==true){
				draft_opsi='cust';
				draft_dest=draft_custField.getValue();
			}
			
/*			else if(draft_kelamin_radioField.getValue()==true){
				draft_opsi='kelamin';
				draft_dest=draft_kelaminField.getValue();
			}
			else if(draft_ultah_radioField.getValue()==true){
				draft_opsi='ultah';
				draft_dest=draft_bulanlahir_startField.getValue() + '-' +draft_tgllahir_startField.getValue()+ 's/d'+draft_bulanlahir_endField.getValue() + '-' +draft_tgllahir_endField.getValue();
			}
*/			
			else if(draft_member_radioField.getValue()==true){
				draft_opsi='member';
				
				if(draft_membershipField.getValue()=='Expired'){
					draft_dest=draft_membershipField.getValue()+':'+draft_tglexp_startField.getValue().format('Y-m-d')+ 's/d'+draft_tglexp_endField.getValue().format('Y-m-d');
				}
				else{
//					draft_dest=draft_membershipField.getValue();
					draft_dest=draft_membershipField.getValue() + ':' + 'x';
				}	
				
				if (draft_kelamin_checkField.getValue()==true) {
					draft_jnsklm = draft_kelaminField.getValue();
				}
				if (draft_ultah_checkField.getValue()==true) {
					draft_ultah = draft_tglultah_startField.getValue().format('Y-m-d') + 's/d' + draft_tglultah_endField.getValue().format('Y-m-d');
				}
				
				if (draft_crm_checkField.getValue()==true) {
					draft_crm = draft_crmField.getValue();
				}
			}
			
			Ext.Ajax.request({  
				waitMsg: 'Mohon tunggu...',
				url: 'index.php?c=c_draft&m=draft_save',
				timeout: 3600000,
				params: {
					idraft_id	: get_pk_id(),
					idraft_opsi	: draft_opsi,
					idraft_dest	: draft_dest,
					idraft_isi	: draft_isi,
					idraft_task	: post2db,
					idraft_jnsklm	: draft_jnsklm,
					idraft_ultah	: draft_ultah,
					idraft_crm	: draft_crm
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							if (post2db=='send') {
								Ext.MessageBox.alert(post2db+' OK','Send SMS sukses. Cek di Outbox untuk status pengiriman');
								draft_reset_form();
							}
							else {
								Ext.MessageBox.alert(post2db+' OK','Draft SMS berhasil disimpan');
								draft_reset_form();
							}
							draft_saveWindow.hide();
							draft_DataStore.reload();
							break;
						case 2:
							if (post2db=='send') {
								Ext.MessageBox.alert('Sending'+' Failed','Customer tidak memiliki data No HP. Lengkapi data Customer pada Master Data Customer');
							}
							mainPanel.remove(mainPanel.getActiveTab().getId());
							break;
						default:
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Draft SMS tidak bisa disimpan',
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
				msg: 'Form anda belum lengkap',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	
	}
 	/* End of Function */
	
  	/* Function for Retrieve DataStore */
	phonegroup_DataStore = new Ext.data.Store({
		id: 'phonegroup_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_sms&m=get_phonegroup_list', 
			method: 'POST'
		}),
		baseParams:{query:'',start:0, limit: 15 }, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'phonegroup_id'
		},[
			{name: 'phonegroup_id', type: 'int', mapping: 'phonegroup_id'}, 
			{name: 'phonegroup_nama', type: 'string', mapping: 'phonegroup_nama'},
			{name: 'phonegroup_detail', type: 'string', mapping: 'phonegroup_detail'},
			{name: 'phonegroup_jumlah', type: 'float', mapping: 'phonegroup_jumlah'}
		]),
		sortInfo:{field: 'phonegroup_nama', direction: "ASC"}
	});
	
	var phonegroup_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{phonegroup_nama} ({phonegroup_jumlah} orang)</b> <br/>',
			'{phonegroup_detail}</span>',
        '</div></tpl>'
    );
	
	
	/* Identify  draft_nama Field */
	var draft_destgroupField= new Ext.form.ComboBox({
		id: 'draft_destgroupField',
		fieldLabel: 'Group',
		store: phonegroup_DataStore,
		mode: 'remote',
		displayField: 'phonegroup_nama',
		valueField: 'phonegroup_id',
		loadingText: 'Searching...',
		typeAhead: false,
        pageSize: pageS,
        tpl: phonegroup_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		width: 300
	});
	/* Identify  draft_detail Field */
	
	var draft_destnumField=new Ext.form.TextArea({
		id: 'draft_destnumField',
		fieldLabel: 'Nomer (pisahkan dengan koma [,])',
		maxLength: 250,
		maskRe: /^\+|,|([0-9]+)$/,
		width: 300
	});
	
	var bulanStore=new Ext.data.SimpleStore({
		fields:['bulan_id','bulan_nama'],
		data:[['01','Januari'],['02','Pebruari'],['03','Maret'],['04','April'],['05','Mei'],['06','Juni'],['07','Juli'],['08','Agustus'],['09','September'],['10','Oktober'],['11','Nopember'],['12','Desember']]
	});
	
	var tanggalStore=new Ext.data.SimpleStore({
		fields:['tanggal'],
		data:[['01'],['02'],['03'],['04'],['05'],['06'],['07'],['08'],['09'],['10'],
			  ['11'],['12'],['13'],['14'],['15'],['16'],['17'],['18'],['19'],['20'],
			  ['21'],['22'],['23'],['24'],['25'],['26'],['27'],['28'],['29'],['30'],['31']]
	});
	
	var draft_tgllahir_startField=new Ext.form.ComboBox({
		id:	'draft_tgllahir_startField',
		name: 'draft_tgllahir_startField',
		typeAhead: true,
		triggerAction: 'all',
		store:tanggalStore,
		mode: 'local',
		width: 50,
		displayField: 'tanggal',
		valueField: 'tanggal',
		value: '01',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		bodyStyle:'padding:5px'
	});
	
	var draft_bulanlahir_startField=new Ext.form.ComboBox({
		id:	'draft_bulanlahir_startField',
		name: 'draft_bulanlahir_startField',
		typeAhead: true,
		triggerAction: 'all',
		store: bulanStore,
		mode: 'local',
		value: '01',
		width: 80,
		displayField: 'bulan_nama',
		valueField: 'bulan_id',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		bodyStyle:'padding:5px'
	});
	
	var draft_tgllahir_endField=new Ext.form.ComboBox({
		id:	'draft_tgllahir_endField',
		name: 'draft_tgllahir_endField',
		typeAhead: true,
		triggerAction: 'all',
		store: tanggalStore,
		mode: 'local',
		width: 50,
		value: '01',
		displayField: 'tanggal',
		valueField: 'tanggal',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		bodyStyle:'padding:5px'
	});
	
	var draft_bulanlahir_endField=new Ext.form.ComboBox({
		id:	'draft_bulanlahir_endField',
		name: 'draft_bulanlahir_endField',
		typeAhead: true,
		triggerAction: 'all',
		store: bulanStore,
		mode: 'local',
		width: 80,
		value: '01',
		displayField: 'bulan_nama',
		valueField: 'bulan_id',
		lazyRender:true,
		listClass: 'x-combo-list-small'
	});
	
	var draft_tgllahir_labelField=new Ext.form.Label({
		bodyStyle:'padding:5px',
		html: '&nbsp; s/d ',
		width: 30,
		frame: false,
		border: false
	});
		
	var draft_tglexp_labelField=new Ext.form.Label({
		bodyStyle:'padding:5px',
		html: '&nbsp; s/d ',
		width: 30,
		frame: false,
		border: false
	});
	
	var draft_tglexp_label2Field=new Ext.form.Label({
		bodyStyle:'padding:5px',
		html: 'exp: ',
		width: 30,
		frame: false,
		border: false
	});

	var draft_membershipField=new Ext.form.ComboBox({
		id:	'draft_membershipField',
		name: 'draft_membershipField',
		typeAhead: true,
		triggerAction: 'all',
		store: new Ext.data.SimpleStore({
			fields:['membership'],
			data:[['Semua'],['Aktif'],['Non Aktif'],['Expired'], ['Non Member']]
		}),
		mode: 'local',
		width: 80,
		value : 'Semua',
		displayField: 'membership',
		valueField: 'membership',
		lazyRender:true,
		listClass: 'x-combo-list-small'
	});
	
	var draft_crmField=new Ext.form.ComboBox({
		id:	'draft_crmField',
		name: 'draft_crmField',
		typeAhead: true,
		triggerAction: 'all',
		store: new Ext.data.SimpleStore({
			fields:['crmvalue'],
			data:[['Low'],['Medium'],['High']]
		}),
		mode: 'local',
		width: 80,
		//value : 'Semua',
		value : 'Medium',
		displayField: 'crmvalue',
		valueField: 'crmvalue',
		lazyRender:true,
		listClass: 'x-combo-list-small'
	});
	
	var draft_tglexp_startField=new Ext.form.DateField({
		id:	'draft_tglexp_startField',
		name: 'draft_tglexp_startField',
		format: 'd-m-Y',
		value: today
	});
	
	var draft_tglexp_endField=new Ext.form.DateField({
		id:	'draft_tglexp_endField',
		name: 'draft_tglexp_endField',
		format: 'd-m-Y',
		value: today
	});
	
	var draft_tglultah_startField=new Ext.form.DateField({
		id:	'draft_tglultah_startField',
		name: 'draft_tglultah_startField',
		format: 'd-m-Y',
		value: today
	});
		
	var draft_tglultah_endField=new Ext.form.DateField({
		id:	'draft_tglultah_endField',
		name: 'draft_tglultah_endField',
		format: 'd-m-Y',
		value: today
	});
	
	var draft_ultah_groupField=new Ext.form.FieldSet({
		id:	'draft_ultah_groupField',
		name: 'draft_ultah_groupField',
		layout: 'column',
		frame: false,
		border: false,
//		items:[draft_tgllahir_startField,draft_bulanlahir_startField,draft_tgllahir_labelField,draft_tgllahir_endField,draft_bulanlahir_endField]
		items:[draft_tglultah_startField, draft_tgllahir_labelField, draft_tglultah_endField]	
	});
		
	var draft_member_expField=new Ext.form.FieldSet({
		layout: 'column',
		frame: false,
		border: false,
		disabled : true,
		bodyStyle:'padding-top:5px;padding-bottom:5px;padding-left:0px',
		items: [draft_tglexp_startField,draft_tglexp_labelField,draft_tglexp_endField]
	});
	
	var draft_member_groupField=new Ext.form.FieldSet({
		id:	'draft_member_groupField',
		name: 'draft_member_groupField',
		layout: 'form',
		frame: false,
		border: false,
		items:[{
			   		layout:'column',
					frame: false,
					border: false,
					bodyStyle:'padding-top:5px;padding-bottom:5px',
					items: [draft_membershipField]
			   },
			   {
			   		layout:'column',
					frame: false,
					border: false,
					bodyStyle:'padding-top:5px;padding-bottom:5px',
					items: [draft_member_expField]
			   }]
	});
	
	
	var draft_kelaminField=new Ext.form.ComboBox({
		id:	'draft_kelaminField',
		name: 'draft_kelaminField',
		typeAhead: true,
		triggerAction: 'all',
		store: new Ext.data.SimpleStore({
			fields:['kelamin_id','kelamin_nama'],
			data:[['L','Laki-laki'],['P','Perempuan']]
		}),
		mode: 'local',
		width: 100,
		value: 'P',
		displayField: 'kelamin_nama',
		valueField: 'kelamin_id',
		lazyRender:true,
		listClass: 'x-combo-list-small'
	});
	
	function is_draft_form_valid(){
		return (draft_destgroupField.isValid() && draft_destnumField.isValid() && draft_kelaminField.isValid() && draft_membershipField.isValid() && draft_detailField.isValid() && draft_crmField.isValid() && draft_custField.isValid());
	}
	
	
	var draft_group_radioField=new Ext.form.Radio({
		id:'draft_group_radioField',
		name:'draft_opsiField',
		width: 100,
		boxLabel: 'Phone Group',
		value: 'selected'
	});
	
	var draft_semua_radioField=new Ext.form.Radio({
		id:'draft_semua_radioField',
		name:'draft_opsiField',
		width: 100,
		boxLabel: 'Semua Customer',
		value: 'selected'
	});
	
	var draft_number_radioField=new Ext.form.Radio({
		id:'draft_number_radioField',
		name:'draft_opsiField',
		width: 100,
		boxLabel: 'Nomor <br> P',
		value: 'selected'
	});
	
	var draft_cust_radioField=new Ext.form.Radio({
		id:'draft_cust_radioField',
		name:'draft_opsiField',
		width: 100,
		boxLabel: 'Customer',
		checked: true,
		value: 'selected'
	});
	
	/* Function for Retrieve DataStore */
	cbo_draft_cust_DataStore = new Ext.data.Store({
		id: 'cbo_draft_cust_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_draft&m=get_customer_list', 
			method: 'POST'
		}),
		baseParams:{start: 0, limit: 10 }, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'cust_id'
		},[
		/* dataIndex => insert intocustomer_note_ColumnModel, Mapping => for initiate table column */ 
			{name: 'cust_id', type: 'int', mapping: 'cust_id'},
			{name: 'cust_no', type: 'string', mapping: 'cust_no'},
			{name: 'cust_nama', type: 'string', mapping: 'cust_nama'},
			{name: 'cust_tgllahir', type: 'date', dateFormat: 'Y-m-d', mapping: 'cust_tgllahir'},
			{name: 'cust_alamat', type: 'string', mapping: 'cust_alamat'},
			{name: 'cust_telprumah', type: 'string', mapping: 'cust_telprumah'}
		]),
		sortInfo:{field: 'cust_no', direction: "ASC"}
	});
	
	// Customer rendering Template
    var draft_cust_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{cust_no} : {cust_nama}</b><br /></span>',
            '{cust_alamat} | {cust_telprumah}<br>',
			'Tgl-Lahir:{cust_tgllahir:date("j M Y")}',
        '</div></tpl>'
    );
	
	/* Identify  cust Field */
	draft_custField= new Ext.form.ComboBox({
		id: 'draft_custField',
		fieldLabel: 'Customer',
		store: cbo_draft_cust_DataStore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
		forceSelection: true,
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: draft_cust_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%',
		width: 300
	});
	
/*	var draft_kelamin_radioField=new Ext.form.Radio({
		id:'draft_kelamin_radioField',
		name:'draft_opsiField',
		width: 100,
		boxLabel: 'Jenis Kelamin',
		value: 'selected'
	});
*/	
	draft_kelamin_checkField=new Ext.form.Checkbox({
		id: 'draft_kelamin_checkField',
		boxLabel: 'Jenis Kelamin',
		width: 100,
		handler: function(node,checked){
			if (checked) {
				draft_kelaminField.setDisabled(false);
				//Ext.Msg.alert('Status', 'Changes saved successfully.');
			}
			else {
				draft_kelaminField.setDisabled(true);
			}
		}
	});

	
	draft_crm_checkField=new Ext.form.Checkbox({
		id: 'draft_crm_checkField',
		boxLabel: 'Nilai CRM',
		width: 100,
		handler: function(node,checked){
			if (checked) {
				draft_crmField.setDisabled(false);
				//Ext.Msg.alert('Status', 'Changes saved successfully.');
			}
			else {
				draft_crmField.setDisabled(true);
			}
		}
	});
/*	var draft_ultah_radioField=new Ext.form.Radio({
		id:'draft_ultah_radioField',
		name:'draft_opsiField',
		width: 100,
		boxLabel: 'Ulang Tahun',
		value: 'selected'
	});
*/	
	var draft_ultah_checkField=new Ext.form.Checkbox({
		id:'draft_ultah_checkField',
		width: 100,
		boxLabel: 'Ulang Tahun',
		handler: function(node,checked){
			if (checked) {
				draft_ultah_groupField.setDisabled(false);
			}
			else {
				draft_ultah_groupField.setDisabled(true);
			}
		}		
	});

	var draft_member_radioField=new Ext.form.Radio({
		id:'draft_member_radioField',
		name:'draft_opsiField',
		width: 100,
		boxLabel: 'Member',
		value: 'selected'
	});

	var draft_destinationField = new Ext.form.FieldSet({
		title: 'Tujuan',
		anchor: '98%',
		layout:'form',
		frame: false,
		border: true,
		items:[{
			     	layout: 'column',
					frame: false,
					border: false,
					bodyStyle:'padding:5px',
				 	items: [draft_semua_radioField]
			   },{
			     	layout: 'column',
					frame: false,
					border: false,
					bodyStyle:'padding:5px',
				 	items: [draft_group_radioField,draft_destgroupField]
			   },{
					layout: 'column',
					frame: false,
					border: false,
					bodyStyle:'padding:5px',
					items: [draft_number_radioField,draft_destnumField]
			   },{
					layout: 'column',
					frame: false,
					border: false,
					bodyStyle:'padding:5px',
					items: [draft_cust_radioField,draft_custField]
			   },
/*			   {
				   	layout: 'column',
					frame: false,
					border: false,
					bodyStyle:'padding:5px',
					items: [draft_kelamin_radioField,draft_kelaminField]
			   },{
				   	layout: 'column',
					frame: false,
					border: false,
					bodyStyle:'padding:5px',
					items: [draft_ultah_radioField,draft_ultah_groupField]
			   },{
				   	layout: 'column',
					frame: false,
					border: false,
					bodyStyle:'padding:5px',
					items: [draft_member_radioField,draft_member_groupField]
			   }
*/			   ]
	});
	
	var draft_opsiField = new Ext.form.FieldSet({
		title: 'Pilihan',
		anchor: '98%',
		layout:'form',
		frame: false,
		border: true,
		items:[{
				   	layout: 'column',
					frame: false,
					border: false,
					bodyStyle:'padding:5px',
					items: [draft_member_radioField, draft_member_groupField]
			   },{
				   	layout: 'column',
					frame: false,
					border: false,
					bodyStyle:'padding:5px',
					items: [draft_kelamin_checkField, draft_kelaminField]
			   },{
				   	layout: 'column',
					frame: false,
					border: false,
					bodyStyle:'padding:5px',
					items: [draft_ultah_checkField, draft_ultah_groupField]
			   },{
				   	layout: 'column',
					frame: false,
					border: false,
					bodyStyle:'padding:5px',
					items: [draft_crm_checkField,draft_crmField]
			   }]
	});
	
	draft_detailField= new Ext.form.TextArea({
		id: 'draft_detailField',
		fieldLabel: 'Isi Pesan',
		maxLength: 500,
		bodyStyle:'padding:5px',
		anchor: '95%',
		allowBlank: false,		
		enableKeyEvents: true,
		maxLength: 320		
	});

	draft_count_isiField= new Ext.form.NumberField({
		width: 40
	});	
	
	draft_detailField.on('keyup', function(){
		var isi_length = draft_detailField.getValue().length;
		var sisa_length = max_isi - isi_length;
		draft_count_isiField.setValue(isi_length);
		if(dua_sms=='no' && isi_length==161){
			//* satu sms terlewati /
			Ext.Msg.alert('Content SMS', 'Pengiriman = 2 SMS.');
			dua_sms = 'yes';
		}else if(isi_length==321){
			//* dua sms terlewati /
			Ext.MessageBox.show({
				title: 'Warning',
				width: 200,
				msg: 'Maksimal pengiriman adalah 2 SMS.',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			 });
		}else if(isi_length==160 && dua_sms=='yes'){
			dua_sms = 'no';
		}
	});

	/* Function for retrieve create Window Panel*/ 
	draft_saveForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 500,        
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [draft_destinationField, draft_opsiField, draft_detailField, draft_count_isiField] 
			}
			],
		buttons: [
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_DRAFT'))){ ?>
			{
				text: 'Send',
				handler: function(){ 			
					draft_save('send'); }
			},{
				text: 'Save',
				handler: function(){ 
					draft_save('draft'); }
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					draft_reset_form();
					draft_saveWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	draft_saveWindow= new Ext.Window({
		id: 'draft_saveWindow',
		title: 'Draft SMS',
		closable:false,
		closeAction: 'close',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_draft_save',
		items: draft_saveForm
	});
	/* End Window */
	
	function setDisableAll(){
		draft_destgroupField.setDisabled(true);
		draft_destnumField.setDisabled(true);
		draft_kelaminField.setDisabled(true);
		draft_ultah_groupField.setDisabled(true);
		draft_membershipField.setDisabled(true);
		draft_member_expField.setDisabled(true);
		draft_crmField.setDisabled(true);
		draft_custField.setDisabled(true);
		
		draft_destgroupField.allowBlank=true;
		draft_destnumField.allowBlank=true;
		draft_kelaminField.allowBlank=true;
		draft_membershipField.allowBlank=true;
		draft_crmField.allowBlank=true;
		draft_custField.allowBlank=true;
		
		draft_kelamin_checkField.setValue(false);
		draft_ultah_checkField.setValue(false);
		draft_kelamin_checkField.setDisabled(true);
		draft_ultah_checkField.setDisabled(true);
		draft_crm_checkField.setDisabled(true);
	}	
		
	draft_semua_radioField.on("check",function(){
		if(draft_semua_radioField.getValue()==true){
			setDisableAll();
	 	}
	});
	
	draft_membershipField.on("select",function(){
		if(draft_membershipField.getValue()=='Expired'){
			draft_member_expField.setDisabled(false);
		}else{
			draft_member_expField.setDisabled(true);
		}
	});
	
	draft_group_radioField.on("check",function(){
		if(draft_group_radioField.getValue()==true){
			setDisableAll();
			draft_destgroupField.setDisabled(false);
			draft_destgroupField.allowBlank=false;
		}		
	});
 
	draft_number_radioField.on("check",function(){
	 	if(draft_number_radioField.getValue()==true){
			setDisableAll();
			draft_destnumField.setDisabled(false);
			draft_destnumField.allowBlank=false;
	 	}
	});
	
	draft_cust_radioField.on("check",function(){
		if(draft_cust_radioField.getValue()==true){
			setDisableAll();
			draft_custField.setDisabled(false);
			draft_custField.allowBlank=false;
		}		
	});
	
/*	draft_kelamin_radioField.on("check",function(){
		if(draft_kelamin_radioField.getValue()==true){
			setDisableAll();
			draft_kelaminField.setDisabled(false);
			draft_kelaminField.allowBlank=false;
		}
	});
	
	draft_ultah_radioField.on("check",function(){
		if(draft_ultah_radioField.getValue()==true){
			setDisableAll();
			draft_ultah_groupField.setDisabled(false);
		}
	});
*/	
	draft_member_radioField.on("check",function(){
		if(draft_member_radioField.getValue()==true){
			setDisableAll();
			draft_membershipField.setDisabled(false);
			draft_membershipField.allowBlank=false;
			draft_kelamin_checkField.setDisabled(false);
			draft_ultah_checkField.setDisabled(false);
			draft_crm_checkField.setDisabled(false);
		}
	});
	
	
	/* Function for action list search */
	function draft_list_search(){
		// render according to a SQL date format.
		var draft_id_search=null;
		var draft_destination_search=null;
		var draft_message_search=null;
		var draft_date_search_date="";

		if(draft_idSearchField.getValue()!==null){draft_id_search=draft_idSearchField.getValue();}
		if(draft_destinationSearchField.getValue()!==null){draft_destination_search=draft_destinationSearchField.getValue();}
		if(draft_messageSearchField.getValue()!==null){draft_message_search=draft_messageSearchField.getValue();}
		if(draft_dateSearchField.getValue()!==""){draft_date_search_date=draft_dateSearchField.getValue().format('Y-m-d');}
		// change the store parameters
		draft_DataStore.baseParams = {
			task: 'SEARCH',
			draft_id	:	draft_id_search, 
			draft_destination	:	draft_destination_search, 
			draft_message	:	draft_message_search, 
			draft_date	:	draft_date_search_date
		};
		// Cause the datastore to do another query : 
		draft_DataStore.reload({params: {start: 0, limit: pageS}});
	}
		
	/* Function for reset search result */
	function draft_reset_search(){
		// reset the store parameters
		draft_DataStore.baseParams = { task: 'LIST', start: 0, limit: pageS };
		draft_DataStore.reload({params: {start: 0, limit: pageS}});
		draft_searchWindow.close();
	};
	/* End of Fuction */
	
	/* Field for search */
	/* Identify  draft_id Search Field */
	draft_idSearchField= new Ext.form.NumberField({
		id: 'draft_idSearchField',
		fieldLabel: 'Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  draft_destination Search Field */
	draft_destinationSearchField= new Ext.form.TextField({
		id: 'draft_destinationSearchField',
		fieldLabel: 'Destination',
		maxLength: 500,
		anchor: '95%'
	
	});
	/* Identify  draft_message Search Field */
	draft_messageSearchField= new Ext.form.TextField({
		id: 'draft_messageSearchField',
		fieldLabel: 'Message',
		maxLength: 250,
		anchor: '95%'
	
	});
	/* Identify  draft_date Search Field */
	draft_dateSearchField= new Ext.form.DateField({
		id: 'draft_dateSearchField',
		fieldLabel: 'Date',
		format : 'Y-m-d'
	
	});
    
	/* Function for retrieve search Form Panel */
	draft_searchForm = new Ext.FormPanel({
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
				items: [draft_dateSearchField, draft_messageSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: draft_list_search
			},{
				text: 'Close',
				handler: function(){
					draft_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	draft_searchWindow = new Ext.Window({
		title: 'Pencarian Draft SMS',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_draft_search',
		items: draft_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!draft_searchWindow.isVisible()){
			draft_searchWindow.show();
		} else {
			draft_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function draft_print(){
		var searchquery = "";
		var draft_destination_print=null;
		var draft_message_print=null;
		var draft_date_print_date="";
		var win;              
		// check if we do have some search data...
		if(draft_DataStore.baseParams.query!==null){searchquery = draft_DataStore.baseParams.query;}
		if(draft_DataStore.baseParams.draft_destination!==null){draft_destination_print = draft_DataStore.baseParams.draft_destination;}
		if(draft_DataStore.baseParams.draft_message!==null){draft_message_print = draft_DataStore.baseParams.draft_message;}
		if(draft_DataStore.baseParams.draft_date!==""){draft_date_print_date = draft_DataStore.baseParams.draft_date;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_draft&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		
			draft_destination : draft_destination_print,
			draft_message : draft_message_print,
		  	draft_date : draft_date_print_date, 
		  	currentlisting: draft_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/draft_printlist.html','draftlist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
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
	function draft_export_excel(){
		var searchquery = "";
		var draft_destination_2excel=null;
		var draft_message_2excel=null;
		var draft_date_2excel_date="";
		var win;              
		// check if we do have some search data...
		if(draft_DataStore.baseParams.query!==null){searchquery = draft_DataStore.baseParams.query;}
		if(draft_DataStore.baseParams.draft_destination!==null){draft_destination_2excel = draft_DataStore.baseParams.draft_destination;}
		if(draft_DataStore.baseParams.draft_message!==null){draft_message_2excel = draft_DataStore.baseParams.draft_message;}
		if(draft_DataStore.baseParams.draft_date!==""){draft_date_2excel_date = draft_DataStore.baseParams.draft_date;}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_draft&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		
			draft_destination : draft_destination_2excel,
			draft_message : draft_message_2excel,
		  	draft_date : draft_date_2excel_date, 
		  	currentlisting: draft_DataStore.baseParams.task // this tells us if we are searching or not
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
        <div id="fp_draft"></div>
		<div id="elwindow_draft_save"></div>
        <div id="elwindow_draft_search"></div>
    </div>
</div>
</body>