<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: akun_map View
	+ Description	: For record view
	+ Filename 		: v_akun_map.php
 	+ creator  		: 
 	+ Created on 06/Oct/2010 10:15:56
	
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
var akun_map_DataStore;
var akun_map_ColumnModel;
var akun_mapListEditorGrid;
var akun_map_saveForm;
var akun_map_saveWindow;
var akun_map_searchForm;
var akun_map_searchWindow;
var akun_map_SelectedRow;
var akun_map_ContextMenu;

//declare konstant
var post2db = '';
var msg = '';
var pageS=15;

/* declare variable here for Field*/
var map_idField;
var map_kategoriField;
var map_namaField;
var map_akunField;
var map_akun_kodeField;
var map_aktifField;
var map_idSearchField;
var map_kategoriSearchField;
var map_namaSearchField;
var map_akunSearchField;
var map_akun_kodeSearchField;
var map_aktifSearchField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  	/* Function for add and edit data form, open window form */
	function akun_map_save(){
	
		if(is_akun_map_form_valid()){	
			var map_id_field_pk=null; 
			var map_kategori_field=null; 
			var map_nama_field=null; 
			var map_akun_field=null; 
			var map_akun_kode_field=null; 
			var map_aktif_field=null; 
			var map_jenis_field=null; 

			map_id_field_pk=get_pk_id();
			if(map_kategoriField.getValue()!== null){map_kategori_field = map_kategoriField.getValue();} 
			if(map_namaField.getValue()!== null){map_nama_field = map_namaField.getValue();} 
			if(map_akunField.getValue()!== null){map_akun_field = map_akunField.getValue();} 
			if(map_akun_kodeField.getValue()!== null){map_akun_kode_field = map_akun_kodeField.getValue();} 
			if(map_aktifField.getValue()!== null){map_aktif_field = map_aktifField.getValue();} 
			if(map_jenisField.getValue()!== null){map_jenis_field = map_jenisField.getValue();} 

			Ext.Ajax.request({  
				waitMsg: 'Please wait...',
				url: 'index.php?c=c_akun_map&m=get_action',
				params: {
					map_id			: map_id_field_pk, 
					map_kategori	: map_kategori_field, 
					map_nama		: map_nama_field, 
					map_akun		: map_akun_field, 
					map_akun_kode	: map_akun_kode_field, 
					map_aktif		: map_aktif_field, 
					map_jenis		: map_jenis_field, 
					task			: post2db
				}, 
				success: function(response){             
					var result=eval(response.responseText);
					switch(result){
						case 1:
							Ext.MessageBox.alert(post2db+' OK','Mapping Kode Akun berhasil disimpan.');
							akun_map_DataStore.reload();
							akun_map_saveWindow.hide();
							break;
						default:
							Ext.MessageBox.show({
							   title: 'Warning',
							   msg: 'Mapping Kode Akun tidak bisa disimpan !.',
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
						   msg: 'Tidak bisa terhubung ke database server.',
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
			return akun_mapListEditorGrid.getSelectionModel().getSelected().get('map_id');
		else 
			return 0;
	}
	/* End of Function  */
	
	/* Reset form before loading */
	function akun_map_reset_form(){
		map_kategoriField.reset();
		map_kategoriField.setValue(null);
		map_namaField.reset();
		map_namaField.setValue(null);
		map_akunField.reset();
		map_akunField.setValue(null);
		map_akun_kodeField.reset();
		map_akun_kodeField.setValue(null);
		map_jenisField.reset();
		map_jenisField.setValue('Master');
		map_aktifField.reset();
		map_aktifField.setValue('Ya');
	}
 	/* End of Function */
  
	/* setValue to EDIT */
	function akun_map_set_form(){
		map_kategoriField.setValue(akun_mapListEditorGrid.getSelectionModel().getSelected().get('map_kategori'));
		map_namaField.setValue(akun_mapListEditorGrid.getSelectionModel().getSelected().get('map_nama'));
		map_akunField.setValue(akun_mapListEditorGrid.getSelectionModel().getSelected().get('map_akun'));
		map_akun_kodeField.setValue(akun_mapListEditorGrid.getSelectionModel().getSelected().get('map_akun_kode'));
		map_jenisField.setValue(akun_mapListEditorGrid.getSelectionModel().getSelected().get('map_jenis'));
		map_aktifField.setValue(akun_mapListEditorGrid.getSelectionModel().getSelected().get('map_aktif'));
	}
	/* End setValue to EDIT*/
  
	/* Function for Check if the form is valid */
	function is_akun_map_form_valid(){
		return ( map_kategoriField.isValid() && 
				 map_namaField.isValid() );
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!akun_map_saveWindow.isVisible()){
			
			post2db='CREATE';
			msg='created';
			
			akun_map_reset_form();
			akun_map_saveWindow.show();
		} else {
			akun_map_saveWindow.toFront();
		}
	}
  	/* End of Function */
 
  	/* Function for Delete Confirm */
	function akun_map_confirm_delete(){
		// only one akun_map is selected here
		if(akun_mapListEditorGrid.selModel.getCount() == 1){
			Ext.MessageBox.confirm('Konfirmasi','Apakah Anda yakin menghapus data ini?', akun_map_delete);
		} else if(akun_mapListEditorGrid.selModel.getCount() > 1){
			Ext.MessageBox.confirm('Konfirmasi','Apakah Anda yakin menghapus data2 ini?', akun_map_delete);
		} else {
			Ext.MessageBox.show({
				title: 'Perhatian !',
				msg: 'Tidak ada data yang dipilih untuk dihapus',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
  
	/* Function for Update Confirm */
	function akun_map_confirm_update(){
		/* only one record is selected here */
		if(akun_mapListEditorGrid.selModel.getCount() == 1) {
			
			post2db='UPDATE';
			msg='updated';
			akun_map_set_form();
			
			akun_map_saveWindow.show();
		} else {
			Ext.MessageBox.show({
				title: 'Perhatian',
				msg: 'Tidak ada data yang dipilih untuk diubah',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
  	/* End of Function */
  
  	/* Function for Delete Record */
	function akun_map_delete(btn){
		if(btn=='yes'){
			var selections = akun_mapListEditorGrid.selModel.getSelections();
			var prez = [];
			for(i = 0; i< akun_mapListEditorGrid.selModel.getCount(); i++){
				prez.push(selections[i].json.map_id);
			}
			var encoded_array = Ext.encode(prez);
			Ext.Ajax.request({ 
				waitMsg: 'Please Wait',
				url: 'index.php?c=c_akun_map&m=get_action', 
				params: { task: "DELETE", ids:  encoded_array }, 
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
						case 1:  // Success : simply reload
							akun_map_DataStore.reload();
							break;
						default:
							Ext.MessageBox.show({
								title: 'Warning',
								msg: 'Gagal menghapus data !',
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
					   msg: 'Tidak terkoneksi ke database',
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
	akun_map_DataStore = new Ext.data.GroupingStore({
		id: 'akun_map_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_akun_map&m=get_action', 
			method: 'POST'
		}),
		groupField:'map_kategori',
		baseParams:{task: "LIST", start: 0, limit: pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'map_id'
		},[
			{name: 'map_id', type: 'int', mapping: 'map_id'}, 
			{name: 'map_kategori', type: 'string', mapping: 'map_kategori'}, 
			{name: 'map_nama', type: 'string', mapping: 'map_nama'}, 
			{name: 'map_akun', type: 'int', mapping: 'map_akun'}, 
			{name: 'akun_nama', type: 'string', mapping: 'akun_nama'}, 
			{name: 'map_akun_kode', type: 'string', mapping: 'map_akun_kode'}, 
			{name: 'map_aktif', type: 'string', mapping: 'map_aktif'}, 
			{name: 'map_jenis', type: 'string', mapping: 'map_jenis'}, 
			{name: 'map_author', type: 'string', mapping: 'map_author'}, 
			{name: 'map_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'map_date_create'}, 
			{name: 'map_update', type: 'string', mapping: 'map_update'}, 
			{name: 'map_date_update', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'map_date_update'}, 
			{name: 'map_revised', type: 'int', mapping: 'map_revised'} 
		]),
		sortInfo:{field: 'map_id', direction: "DESC"}
	});
	/* End of Function */
    
	cbo_map_akunDataStore = new Ext.data.Store({
		id: 'cbo_map_akunDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_akun&m=get_akun_list', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit: pageS},
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'akun_id'
		},[
			{name: 'akun_id', type: 'int', mapping: 'akun_id'}, 
			{name: 'akun_kode', type: 'string', mapping: 'akun_kode'}, 
			{name: 'akun_jenis', type: 'string', mapping: 'akun_jenis'}, 
			{name: 'akun_parent', type: 'int', mapping: 'akun_parent'}, 
			{name: 'akun_level', type: 'int', mapping: 'akun_level'}, 
			{name: 'akun_nama', type: 'string', mapping: 'akun_nama'}
		]),
		sortInfo:{field: 'akun_id', direction: "ASC"}
	});
	
	cbo_map_kategoriDataStore = new Ext.data.Store({
		id: 'cbo_map_kategoriDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_akun_map&m=get_map_kategori_list', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start:0, limit: pageS},
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'map_kategori'
		},[
			{name: 'map_kategori', type: 'string', mapping: 'map_kategori'}
		]),
		sortInfo:{field: 'map_kategori', direction: "ASC"}
	});
	
  	/* Function for Identify of Window Column Model */
	akun_map_ColumnModel = new Ext.grid.ColumnModel(
		[{
			header: '#',
			readOnly: true,
			dataIndex: 'map_id',
			width: 40,
			renderer: function(value, cell){
				cell.css = "readonlycell"; // Mengambil Value dari Class di dalam CSS 
				return value;
			},
			hidden: true
		},
		{
			header: 'Kategori',
			dataIndex: 'map_kategori',
			width: 150,
			sortable: true,
			readOnly: true
		}, 
		{
			header: 'Nama',
			dataIndex: 'map_nama',
			width: 150,
			sortable: true,
			readOnly: true
		},
		
		{
			header: 'Akun Kode',
			dataIndex: 'map_akun_kode',
			width: 150,
			sortable: true,
			readOnly: true
		}, 
		{
			header: 'Nama Akun',
			dataIndex: 'akun_nama',
			width: 150,
			sortable: true,
			readOnly: true
		}, 
		{
			header: 'Jenis',
			dataIndex: 'map_jenis',
			width: 150,
			sortable: true,
			readOnly: true
		}, 
		{
			header: 'Aktif',
			dataIndex: 'map_aktif',
			width: 150,
			sortable: true,
			readOnly: true,
			hidden: true
		}, 
		{
			header: 'Author',
			dataIndex: 'map_author',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Create on',
			dataIndex: 'map_date_create',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Last Update By',
			dataIndex: 'map_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}, 
		{
			header: 'Last Update on',
			dataIndex: 'map_date_update',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true,
		}, 
		{
			header: 'Revised',
			dataIndex: 'map_revised',
			width: 150,
			sortable: true,
			hidden: true,
			readOnly: true
		}	]);
	
	akun_map_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	var summary = new Ext.ux.grid.GroupSummary();
	
	/* Declare DataStore and  show datagrid list */
	akun_mapListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'akun_mapListEditorGrid',
		el: 'fp_akun_map',
		title: 'Daftar Mapping Kode Akun',
		autoHeight: true,
		store: akun_map_DataStore, // DataStore
		cm: akun_map_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 800,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS,
			store: akun_map_DataStore,
			displayInfo: true
		}),
		view: new Ext.grid.GroupingView({
            forceFit: true,
            showGroupName: true,
            enableNoGroups: false,
			enableGroupingMenu: false,
            hideGroupedColumn: true
        }),
		plugins: summary,
		tbar: [
		<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_AKUNMAP'))){ ?>
		{
			text: 'Add',
			tooltip: 'Add new record',
			iconCls:'icon-adds',    				// this is defined in our styles.css
			handler: display_form_window
		}, '-',
		<?php } ?>
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_AKUNMAP'))){ ?>
		{
			text: 'Edit',
			tooltip: 'Edit selected record',
			iconCls:'icon-update',
			handler: akun_map_confirm_update   // Confirm before updating
		}, '-',
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_AKUNMAP'))){ ?>
		{
			text: 'Delete',
			tooltip: 'Delete selected record',
			iconCls:'icon-delete',
			handler: akun_map_confirm_delete   // Confirm before deleting
		}, '-', 
		<?php } ?>
		{
			text: 'Adv Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			new Ext.app.SearchField({
			store: akun_map_DataStore,
			params: {start: 0, limit: pageS},
			width: 120
		}),'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: akun_map_reset_search,
			iconCls:'icon-refresh'
		}
		]
	});
	akun_mapListEditorGrid.render();
	/* End of DataStore */
     
	/* Create Context Menu */
	akun_map_ContextMenu = new Ext.menu.Menu({
		id: 'akun_map_ListEditorGridContextMenu',
		items: [
		<?php if(eregi('U|R',$this->m_security->get_access_group_by_kode('MENU_AKUNMAP'))){ ?>
		{ 
			text: 'Edit', tooltip: 'Edit selected record', 
			iconCls:'icon-update',
			handler: akun_map_confirm_update
		},
		<?php } ?>
		<?php if(eregi('D',$this->m_security->get_access_group_by_kode('MENU_AKUNMAP'))){ ?>
		{ 
			text: 'Delete', 
			tooltip: 'Delete selected record', 
			iconCls:'icon-delete',
			handler: akun_map_confirm_delete 
		},
		<?php } ?>
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onakun_map_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		akun_map_ContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		akun_map_SelectedRow=rowIndex;
		akun_map_ContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
	
	/* function for editing row via context menu */
	function akun_map_editContextMenu(){
		//akun_mapListEditorGrid.startEditing(akun_map_SelectedRow,1);
		akun_map_confirm_update();
  	}
	/* End of Function */
  	
	akun_mapListEditorGrid.addListener('rowcontextmenu', onakun_map_ListEditGridContextMenu);
	akun_map_DataStore.load({params: {start: 0, limit: pageS}});	// load DataStore
	
	/* Identify  map_kategori Field */
	
	map_kategoriField=new Ext.form.ComboBox({
		id: 'map_kategoriField',
		fieldLabel: 'Kategori',
		store:new Ext.data.SimpleStore({
			fields:['map_aktif_value', 'map_aktif_display'],
			data:[['Pembelian','Pembelian'],['Penjualan','Penjualan'],['Perawatan','Perawatan'],['Paket','Paket'],['Kas/Bank','Kas/Bank']]
		}),
		mode: 'local',
		displayField: 'map_aktif_display',
		valueField: 'map_aktif_value',
		allowBlank: false,
		triggerAction: 'all',
		anchor: '95%'
	});
	
	
	map_xkategoriField= new Ext.form.TextField({
		id: 'map_xkategoriField',
		fieldLabel: '&nbsp; &nbsp; <i>Lainnya</i>',
		maxLength: 50,
		allowBlank: false,
		anchor: '95%'
	});
	/* Identify  map_nama Field */
	map_namaField= new Ext.form.TextField({
		id: 'map_namaField',
		fieldLabel: 'Nama',
		maxLength: 50,
		allowBlank: false,
		anchor: '95%'
	});
	
	var map_akun_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{akun_kode}</b> -  {akun_nama}</span>',
        '</div></tpl>'
    );
	
	/* Identify  map_akun Field */
	map_akunField= new Ext.form.ComboBox({
		id: 'map_akunField',
		fieldLabel: 'Nama Akun',
		store: cbo_map_akunDataStore,
		displayField:'akun_nama',
		mode : 'remote',
		valueField: 'akun_id',
        typeAhead: false,
        loadingText: 'Searching...',
		pageSize:10,
        hideTrigger:false,
		allowBlank: false,
        tpl: map_akun_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	});
	/* Identify  map_akun_kode Field */
	map_akun_kodeField= new Ext.form.TextField({
		id: 'map_akun_kodeField',
		fieldLabel: 'Kode Akun',
		anchor: '70%',
		readOnly: true
	});
	
	map_jenisField= new Ext.form.ComboBox({
		id: 'map_jenisField',
		fieldLabel: 'Jenis',
		store:new Ext.data.SimpleStore({
			fields:['map_aktif_value', 'map_aktif_display'],
			data:[['Master','Master'],['Detail','Detail']]
		}),
		mode: 'local',
		displayField: 'map_aktif_display',
		valueField: 'map_aktif_value',
		allowBlank: false,
		anchor: '50%',
		triggerAction: 'all'	
	});
	
	/* Identify  map_aktif Field */
	map_aktifField= new Ext.form.ComboBox({
		id: 'map_aktifField',
		fieldLabel: 'Aktif',
		store:new Ext.data.SimpleStore({
			fields:['map_aktif_value', 'map_aktif_display'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		displayField: 'map_aktif_display',
		valueField: 'map_aktif_value',
		allowBlank: false,
		anchor: '50%',
		triggerAction: 'all'	
	});

	
	/* Function for retrieve create Window Panel*/ 
	akun_map_saveForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 450,        
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [map_kategoriField, map_namaField, map_akunField, map_akun_kodeField,map_jenisField, map_aktifField] 
			}
			],
		buttons: [
			<?php if(eregi('U|C',$this->m_security->get_access_group_by_kode('MENU_AKUNMAP'))){ ?>
			{
				text: 'Save and Close',
				handler: akun_map_save
			}
			,
			<?php } ?>
			{
				text: 'Cancel',
				handler: function(){
					akun_map_saveWindow.hide();
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	akun_map_saveWindow= new Ext.Window({
		id: 'akun_map_saveWindow',
		title: post2db+' Mapping Kode Akun',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_akun_map_save',
		items: akun_map_saveForm
	});
	/* End Window */
	
	/* Function for action list search */
	function akun_map_list_search(){
		// render according to a SQL date format.
		var map_id_search=null;
		var map_kategori_search=null;
		var map_nama_search=null;
		var map_akun_search=null;
		var map_akun_kode_search=null;
		var map_aktif_search=null;

		if(map_kategoriSearchField.getValue()!==null){map_kategori_search=map_kategoriSearchField.getValue();}
		if(map_namaSearchField.getValue()!==null){map_nama_search=map_namaSearchField.getValue();}
		if(map_akunSearchField.getValue()!==null){map_akun_search=map_akunSearchField.getValue();}
		if(map_akun_kodeSearchField.getValue()!==null){map_akun_kode_search=map_akun_kodeSearchField.getValue();}
		if(map_aktifSearchField.getValue()!==null){map_aktif_search=map_aktifSearchField.getValue();}
		// change the store parameters
		akun_map_DataStore.baseParams = {
			task			: 	'SEARCH',
			map_kategori	:	map_kategori_search, 
			map_nama		:	map_nama_search, 
			map_akun		:	map_akun_search, 
			map_akun_kode	:	map_akun_kode_search, 
			map_aktif		:	map_aktif_search
		};
		// Cause the datastore to do another query : 
		akun_map_DataStore.reload({params: {start: 0, limit: pageS}});
	}
		
	/* Function for reset search result */
	function akun_map_reset_search(){
		// reset the store parameters
		akun_map_DataStore.baseParams = { task: 'LIST', start:0, limit: pageS };
		akun_map_DataStore.reload({params: {start: 0, limit: pageS}});
		//akun_map_searchWindow.close();
	};
	/* End of Fuction */
	
	/* Field for search */
	/* Identify  map_id Search Field */
	map_idSearchField= new Ext.form.NumberField({
		id: 'map_idSearchField',
		fieldLabel: 'Map Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  map_kategori Search Field */
	map_kategoriSearchField= new Ext.form.TextField({
		id: 'map_kategoriSearchField',
		fieldLabel: 'Kategori',
		maxLength: 50,
		anchor: '95%'
	
	});
	/* Identify  map_nama Search Field */
	map_namaSearchField= new Ext.form.TextField({
		id: 'map_namaSearchField',
		fieldLabel: 'Nama',
		maxLength: 50,
		anchor: '95%'
	
	});
	/* Identify  map_akun Search Field */
	map_akunSearchField= new Ext.form.ComboBox({
		id: 'map_akunSearchField',
		fieldLabel: 'Nama Akun',
		store: cbo_map_akunDataStore,
		displayField:'akun_nama',
		mode : 'remote',
		valueField: 'akun_id',
        typeAhead: false,
        loadingText: 'Searching...',
		pageSize:10,
        hideTrigger:false,
		allowBlank: false,
        tpl: map_akun_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '95%'
	
	});
	/* Identify  map_akun_kode Search Field */
	map_akun_kodeSearchField= new Ext.form.NumberField({
		id: 'map_akun_kodeSearchField',
		fieldLabel: 'Kode Akun',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  map_aktif Search Field */
	map_aktifSearchField= new Ext.form.ComboBox({
		id: 'map_aktifSearchField',
		fieldLabel: 'Aktif',
		store:new Ext.data.SimpleStore({
			fields:['value', 'map_aktif'],
			data:[['Aktif','Aktif'],['Tidak Aktif','Tidak Aktif']]
		}),
		mode: 'local',
		displayField: 'map_aktif',
		valueField: 'value',
		anchor: '50%',
		triggerAction: 'all'	 
	
	});
    
	/* Function for retrieve search Form Panel */
	akun_map_searchForm = new Ext.FormPanel({
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
				items: [map_kategoriSearchField, map_namaSearchField, map_akunSearchField, map_aktifSearchField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: akun_map_list_search
			},{
				text: 'Close',
				handler: function(){
					akun_map_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	akun_map_searchWindow = new Ext.Window({
		title: 'Percarian Mapping Kode Akun',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_akun_map_search',
		items: akun_map_searchForm
	});
    /* End of Function */ 
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!akun_map_searchWindow.isVisible()){
			akun_map_searchWindow.show();
		} else {
			akun_map_searchWindow.toFront();
		}
	}
  	/* End Function */
	
		
	/*cbo_map_kategoriField.on('select', function(){
		map_kategoriField.setValue(cbo_map_kategoriField.getValue());
	});*/
	
	map_akunField.on('select', function(){
		var j=cbo_map_akunDataStore.findExact('akun_id',map_akunField.getValue());
		if(j>-1){
			map_akun_kodeField.setValue(cbo_map_akunDataStore.getAt(j).data.akun_kode);
		}
	});
	/*End of Function */
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_akun_map"></div>
		<div id="elwindow_akun_map_save"></div>
        <div id="elwindow_akun_map_search"></div>
    </div>
</div>
</body>
</html>