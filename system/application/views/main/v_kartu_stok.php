<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: kartu_stok View
	+ Description	: For record view
	+ Filename 		: v_kartu_stok.php
 	+ creator  		: 
 	+ Created on 09/Apr/2010 10:47:15
	
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
var kartu_stok_DataStore;
var kartu_stok_ColumnModel;
var kartu_stokListEditorGrid;
var kartu_stok_saveForm;
var kartu_stok_saveWindow;
var kartu_stok_searchForm;
var kartu_stok_searchWindow;
var kartu_stok_SelectedRow;
var kartu_stok_ContextMenu;

//declare konstant
var post2db = '';
var msg = '';
var pageS=15;
var today=new Date().format('Y-m-d');
var firstday=(new Date().format('Y-m'))+'-01';
var thismonth=new Date().format('m');
var thisyear=new Date().format('Y');
/* declare variable here for Field*/
var produk_idField;
var produk_namaField;
var satuan_idField;
var satuan_namaField;
var stok_saldoField;
var produk_idSearchField;
var produk_namaSearchField;
var satuan_idSearchField;
var satuan_namaSearchField;
var stok_saldoSearchField;

<?
$tahun="[";
for($i=(date('Y')-4);$i<=date('Y');$i++){
	$tahun.="['$i'],";
}
$tahun=substr($tahun,0,strlen($tahun)-1);
$tahun.="]";
$bulan="";

?>

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  
  	/* Function for get PK field */
	function get_pk_id(){
		if(post2db=='UPDATE')
			return kartu_stokListEditorGrid.getSelectionModel().getSelected().get('produk_id');
		else 
			return 0;
	}
  	/* End of Function */
	
	/* Function for Retrieve DataStore */
	kartu_stok_DataStore = new Ext.data.Store({
		id: 'kartu_stok_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_kartu_stok&m=get_action', 
			method: 'POST',
			timeout: 3600000
		}),
		baseParams:{task: "LIST", start:0, limit: pageS, produk_id:0, query: null}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'stok_tanggal'
		},[
			{name: 'stok_tanggal', type: 'date', dateFormat: 'Y-m-d', mapping: 'tanggal'}, 
			{name: 'stok_nobukti', type: 'string', mapping: 'no_bukti'}, 
			{name: 'stok_keterangan', type: 'string', mapping: 'keterangan'}, 
			{name: 'stok_masuk', type: 'float', mapping: 'masuk'}, 
			{name: 'stok_keluar', type: 'float', mapping: 'keluar'}
		]),
		sortInfo:{field: 'stok_tanggal', direction: "ASC"}
	});
	/* End of Function */
	
	/* Function for Retrieve DataStore */
	kartu_stok_awal_DataStore = new Ext.data.Store({
		id: 'kartu_stok_awal_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_kartu_stok&m=kartu_stok_awal', 
			method: 'POST',
			timeout: 3600000
		}),
		baseParams:{start:0, limit: pageS, produk_id:0, query: null}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'stok_awal'
		},[
			{name: 'stok_awal', type: 'float', mapping: 'stok_awal'}
		]),
		sortInfo:{field: 'stok_awal', direction: "ASC"}
	});
	/* End of Function */
	
	/* Function for Retrieve DataStore */
	kartu_stok_resume_DataStore = new Ext.data.Store({
		id: 'kartu_stok_resume_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_kartu_stok&m=stok_resume', 
			method: 'POST',
			timeout: 3600000
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'stok_masuk'
		},[
			{name: 'stok_masuk', type: 'float', mapping: 'masuk'},
			{name: 'stok_keluar', type: 'float', mapping: 'keluar'}
		]),
		sortInfo:{field: 'stok_masuk', direction: "ASC"}
	});
	/* End of Function */
	
	/* Function for Retrieve DataStore */
	kartu_stok_produk_DataStore = new Ext.data.Store({
		id: 'kartu_stok_produk_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_hpp&m=get_produk_list', 
			method: 'POST'
		}),
		baseParams:{task: "LIST", start: 0, limit:pageS}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'produk_id'
		},[
			{name: 'produk_id', type: 'int', mapping: 'produk_id'}, 
			{name: 'produk_kode', type: 'string', mapping: 'produk_kode'}, 
			{name: 'produk_jenis', type: 'string', mapping: 'produk_jenis'}, 
			{name: 'produk_nama', type: 'string', mapping: 'produk_nama'}, 
			{name: 'satuan_id', type: 'int', mapping: 'satuan_id'}, 
			{name: 'satuan_kode', type: 'string', mapping: 'satuan_kode'}, 
			{name: 'satuan_nama', type: 'string', mapping: 'satuan_nama'}
		]),
		sortInfo:{field: 'produk_id', direction: "DESC"}
	});
	
	/* End of Function */
	var produk_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{produk_nama} ({produk_kode})</b><br /></span>',
            'Satuan: {satuan_nama}',
        '</div></tpl>'
    );
	
	kartu_stok_ColumnModel = new Ext.grid.ColumnModel(
		[
		{
			header: '<div align="center">Tanggal</div>',
			dataIndex: 'stok_tanggal',
			renderer: Ext.util.Format.dateRenderer('Y-m-d'),
			width: 150,
			sortable: true,
			readOnly: true
		}, 
		{
			header: '<div align="center">No Bukti</div>',
			dataIndex: 'stok_nobukti',
			width: 150,
			sortable: true,
			readOnly: true
		}, 
		{
			header: '<div align="center">Keterangan</div>',
			dataIndex: 'stok_keterangan',
			width: 350,
			sortable: true,
			//hidden: true,
			readOnly: true
		}, 
		{
			header: '<div align="center">Masuk</div>',
			dataIndex: 'stok_masuk',
			align: 'right',
			renderer: Ext.util.Format.numberRenderer('0.00'),
			width: 150,
			sortable: true,
			readOnly: true
		},
		{
			header: '<div align="center">Keluar</div>',
			dataIndex: 'stok_keluar',
			align: 'right',
			renderer: Ext.util.Format.numberRenderer('0.00'),
			width: 150,
			sortable: true,
			readOnly: true
		}]);
	
	kartu_stok_ColumnModel.defaultSortable= true;
	/* End of Function */
    
	  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!kartu_stok_searchWindow.isVisible()){
			kartu_stok_searchWindow.show();
		} else {
			kartu_stok_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	kartu_stok_produkField=new Ext.form.TextField({
		id: 'kartu_stok_produkField',
		name: 'kartu_stok_produkField',
		fieldLabel: '<b>Produk</b>',
		width: 300,
		readOnly: true
	});
	
	kartu_stok_satuanField=new Ext.form.TextField({
		id: 'kartu_stok_satuanField',
		name: 'kartu_stok_satuanField',
		fieldLabel: '<b>Satuan</b>',
		readOnly: true
	});
	
	
	kartu_stok_awalField=new Ext.form.TextField({
		id: 'kartu_stok_awalField',
		name: 'kartu_stok_awalField',
		fieldLabel: '<b>Stok Awal</b>',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		readOnly: true,
		width: 60
	});
	
	kartu_stok_saldoField=new Ext.form.TextField({
		id: 'kartu_stok_saldoField',
		name: 'kartu_stok_saldoField',
		fieldLabel: '<b>Stok Akhir</b>',
		valueRenderer: 'numberToCurrency',
		itemCls: 'rmoney',
		readOnly: true,
		width: 60
	});
	
	kartu_stok_masterField=new Ext.form.FieldSet({
		layout: 'column',
		items:[{
			   		columWindth: 0.75,
					layout: 'form',
					items:[kartu_stok_produkField]
			   },{
				   	columWindth: 0.25,
					layout: 'form',
					items:[kartu_stok_satuanField]
			   }]
	});

	
	function rounding(num, dec) {
		var result = Math.round(num*Math.pow(10,dec))/Math.pow(10,dec);
		return result;
	}
	
	/* Declare DataStore and  show datagrid list */
	kartu_stokListEditorGrid =  new Ext.grid.GridPanel({
		id: 'kartu_stokListEditorGrid',
		title: 'Kartu Stok',
		el: 'fp_vu_kartu_stok',
		autoHeight: true,
		store: kartu_stok_DataStore, // DataStore
		cm: kartu_stok_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 900,
		autoHeight: true,
		bbar: [new Ext.PagingToolbar({
			pageSize: pageS,
			store: kartu_stok_DataStore,
			displayInfo: true
		}),{
			'text':'Stok Awal'
		},
		{
			'text':':'
		},
		kartu_stok_awalField,
		{
			'text':'Stok Akhir'
		},
		{
			'text':':'
		},
		kartu_stok_saldoField
		],tbar: [
		{
			'text':'Produk'
		},
		{
			'text':':'
		},
		kartu_stok_produkField,
		{
			'text':'Satuan'
		},
		{
			'text':':'
		},
		kartu_stok_satuanField
		,
		{
			text: 'Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		},/*'-',{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler: kartu_stok_reset_search,
			iconCls:'icon-refresh'
		}*/
		'-',{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: kartu_stok_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: kartu_stok_print  
		}]
	});
	
	kartu_stokListEditorGrid.render();
	kartu_stokListEditorGrid.show();
	
	function is_valid_form(){
		if(kartu_stok_produk_namaSearchField.getValue()!=="" && kartu_stok_gudangSearchField.getValue()!=="" && 
		   kartu_stok_tanggal_startSearchField.isValid() && kartu_stok_tanggal_endSearchField.isValid())
		{
			return true;
		}else
			return false;
	}
	
	/* Function for action list search */
	function kartu_stok_list_search(){
		// render according to a SQL date format.
		var produk_nama_search=null;
		var tanggal_start_search="";
		var tanggal_end_search="";
		var opsi_satuan_search='default';
		var gudang_search=null;
		var kartu_stok_bulan=null;
		var kartu_stok_tahun=null;
		var kartu_stok_periode=null;
		
		
		
		if(is_valid_form()){
		
			if(kartu_stok_produk_namaSearchField.getValue()!==null){produk_nama_search=kartu_stok_produk_namaSearchField.getValue();}
			/*if(kartu_stok_produk_allField.getValue()==true){ produk_nama_search=null; }*/
			if(kartu_stok_tanggal_startSearchField.getValue()!==null){tanggal_start_search=kartu_stok_tanggal_startSearchField.getValue().format('Y-m-d');}
			if(kartu_stok_tanggal_endSearchField.getValue()!==null){tanggal_end_search=kartu_stok_tanggal_endSearchField.getValue().format('Y-m-d');}
			if(kartu_stok_satuan_terkecilField.getValue()==true){ opsi_satuan_search='terkecil'; }else{ opsi_satuan_search='default'; }
			if(kartu_stok_gudangSearchField.getValue()!==null){ gudang_search=kartu_stok_gudangSearchField.getValue()}
			
			kartu_stok_produk_DataStore.load({
				params:{satuan: opsi_satuan_search },
				callback: function(r,opt,success){
					if(success==true){
						var j=kartu_stok_produk_DataStore.findExact('produk_id',kartu_stok_produk_namaSearchField.getValue(),0);
						if(j>-1){
							var produk_record=kartu_stok_produk_DataStore.getAt(j);
							kartu_stok_produkField.setValue(produk_record.data.produk_nama);
							kartu_stok_satuanField.setValue(produk_record.data.satuan_nama);
						}
					}
				}
			});
		
			if(kartu_stok_bulanField.getValue()!==null){kartu_stok_bulan=kartu_stok_bulanField.getValue();}
			if(kartu_stok_tahunField.getValue()!==null){kartu_stok_tahun=kartu_stok_tahunField.getValue();}
			
			if(kartu_stok_opsitglField.getValue()==true){
				kartu_stok_periode='tanggal';
			}else if(kartu_stok_opsiblnField.getValue()==true){
				if (kartu_stok_bulanField.getValue() == '01') {
					nama_bulan='Januari'
				}else if(kartu_stok_bulanField.getValue() == '02') {
					nama_bulan='Februari'
				}else if(kartu_stok_bulanField.getValue() == '03') {
					nama_bulan='Maret'
				}else if(kartu_stok_bulanField.getValue() == '01') {
					nama_bulan='April'
				}else if(kartu_stok_bulanField.getValue() == '05') {
					nama_bulan='Mei'
				}else if(kartu_stok_bulanField.getValue() == '06') {
					nama_bulan='Juni'
				}else if(kartu_stok_bulanField.getValue() == '07') {
					nama_bulan='Juli'
				}else if(kartu_stok_bulanField.getValue() == '08') {
					nama_bulan='Agustus'
				}else if(kartu_stok_bulanField.getValue() == '09') {
					nama_bulan='September'
				}else if(kartu_stok_bulanField.getValue() == '10') {
					nama_bulan='Oktober'
				}else if(kartu_stok_bulanField.getValue() == '11') {
					nama_bulan='November'
				}else if(kartu_stok_bulanField.getValue() == '12') {
					nama_bulan='Desember'
				}
				
				kartu_stok_periode='bulan';
			}else{
				kartu_stok_periode='all';
			}
			
			kartu_stok_DataStore.baseParams = {
				task			: 	'SEARCH',
				produk_id		:	produk_nama_search, 
				tanggal_start	:	tanggal_start_search, 
				tanggal_end		:	tanggal_end_search,
				opsi_satuan		: 	opsi_satuan_search,
				gudang			: 	gudang_search,
				bulan		: kartu_stok_bulan,
				tahun		: kartu_stok_tahun,
				periode		: kartu_stok_periode
			};
			
			
			
			// Cause the datastore to do another query : 
			Ext.MessageBox.show({
			   msg: 'Sedang memproses data, mohon tunggu...',
			   progressText: 'proses...',
			   width:350,
			   wait:true
			});
			
			Ext.Ajax.request({
				waitMsg: 'Mohon tunggu...',
				timeout: 3600000,
				url: 'index.php?c=c_kartu_stok&m=generate_kartu_stok',
				params:{ 
					produk_id		:	produk_nama_search, 
					tanggal_start	:	tanggal_start_search, 
					tanggal_end		:	tanggal_end_search,
					opsi_satuan		: 	opsi_satuan_search,
					gudang			: 	gudang_search,
					bulan		: kartu_stok_bulan,
					tahun		: kartu_stok_tahun,
					periode		: kartu_stok_periode					
				},
				success:function(response){
					
					kartu_stok_DataStore.reload({
					params: {start: 0, limit: pageS, query: null},
					callback: function(r,opt,success){
						if(success==true){
							
							kartu_stok_awal_DataStore.baseParams = {
								task			: 'LIST',
								produk_id		:	produk_nama_search, 
								tanggal_start	:	tanggal_start_search, 
								tanggal_end		:	tanggal_end_search,
								opsi_satuan		: 	opsi_satuan_search,
								gudang			: 	gudang_search,
								bulan		: kartu_stok_bulan,
								tahun		: kartu_stok_tahun,
								periode		: kartu_stok_periode
							};
							
							kartu_stok_resume_DataStore.baseParams={
								produk_id		:	produk_nama_search, 
								tanggal_start	:	tanggal_start_search, 
								tanggal_end		:	tanggal_end_search,
								opsi_satuan		: 	opsi_satuan_search,
								gudang			: 	gudang_search,
								bulan		: kartu_stok_bulan,
								tahun		: kartu_stok_tahun,
								periode		: kartu_stok_periode
							};
							kartu_stok_awal_DataStore.load({
								callback: function(r,opt,success){
									if(success==true){ 
									
										kartu_stok_resume_DataStore.load({
										callback: function(r,opt,success){
											if(success==true){ 
												var stok_awal=0;
												var stok_masuk=0;
												var stok_keluar=0;
																							
												var data_awal=kartu_stok_awal_DataStore.getAt(0);
												var data_resume=kartu_stok_resume_DataStore.getAt(0);
												
												stok_awal=rounding(data_awal.data.stok_awal,2);
												stok_masuk=rounding(data_resume.data.stok_masuk,2);
												stok_keluar=rounding(data_resume.data.stok_keluar,2);
												
												//kartu_stok_awalField.setValue(CurrencyFormatted(stok_awal));
												kartu_stok_awalField.setValue(stok_awal);
												stok_akhir=rounding((stok_awal+stok_masuk-stok_keluar),2);
										
												//kartu_stok_saldoField.setValue(CurrencyFormatted(stok_akhir));
												kartu_stok_saldoField.setValue(stok_akhir);
												Ext.MessageBox.hide(); 
												kartu_stok_searchWindow.hide();
												
											}
										}
										});
										
									}
								}
							});
						
					}					 
				}
			});
				}
			});
			
			
			
		}else{
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Form anda belum lengkap',
				buttons: Ext.MessageBox.OK,
				animEl: 'search',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
		
	/* Function for reset search result */
	function kartu_stok_reset_search(){
		// reset the store parameters
		kartu_stok_DataStore.baseParams = { task: 'LIST' };
		// Cause the datastore to do another query : 
		kartu_stok_DataStore.reload({params: {start: 0, limit: pageS}});
		kartu_stok_searchWindow.close();
	};
	/* End of Fuction */
	
	/* Field for search */
	/* Identify  produk_id Search Field */
	kartu_stok_produk_idSearchField= new Ext.form.NumberField({
		id: 'kartu_stok_produk_idSearchField',
		fieldLabel: 'Produk Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	/* Identify  stok_produk_nama Search Field */
	kartu_stok_produk_namaSearchField= new Ext.form.ComboBox({
		id: 'kartu_stok_produk_namaSearchField',
		fieldLabel: 'Produk',
		store: kartu_stok_produk_DataStore,
		mode: 'remote',
		typeAhead: false,
		displayField: 'produk_nama',
		valueField: 'produk_id',
		triggerAction: 'all',
		lazyRender: true,
		pageSize: pageS,
		tpl: produk_tpl,
		itemSelector: 'div.search-item',
		triggerAction: 'all',
		allowBlank: false,
		listClass: 'x-combo-list-small',
		width: 300
	
	});
	
		/* Function for Retrieve Supplier DataStore */
	mutasi_gudang_DataSore = new Ext.data.Store({
		id: 'mutasi_gudang_DataSore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_mutasi&m=get_gudang_list', 
			method: 'POST'
		}),
		baseParams:{task: "LIST"}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'gudang_id'
		},[
		/* dataIndex => insert intocustomer_note_ColumnModel, Mapping => for initiate table column */ 
			{name: 'mutasi_gudang_value', type: 'int', mapping: 'gudang_id'},
			{name: 'mutasi_gudang_nama', type: 'string', mapping: 'gudang_nama'}
		]),
		sortInfo:{field: 'mutasi_gudang_nama', direction: "ASC"}
	});
	
	kartu_stok_gudangSearchField= new Ext.form.ComboBox({
		id: 'kartu_stok_gudangSearchField',
		fieldLabel: 'Gudang',
		store: mutasi_gudang_DataSore,
		mode: 'remote',
		typeAhead: false,
		displayField: 'mutasi_gudang_nama',
		valueField: 'mutasi_gudang_value',
		triggerAction: 'all',
		lazyRender: false,
		pageSize: pageS,
		allowBlank: false,
		enableKeyEvents: true,
		//itemSelector: 'div.search-item',
		triggerAction: 'all',
		//listClass: 'x-combo-list-small',
		width: 300
	
	});
	
	/////tgl n bulan
	kartu_stok_opsitglField=new Ext.form.Radio({
		id:'kartu_stok_opsitglField',
		boxLabel:'Tanggal',
		width:100,
		name: 'filter_opsi',
		checked: true
	});
	
	kartu_stok_opsiblnField=new Ext.form.Radio({
		id:'kartu_stok_opsiblnField',
		boxLabel:'Bulan',
		//disabled: true,
		width:100,
		name: 'filter_opsi'
	});
	
	kartu_stok_tanggal_startSearchField= new Ext.form.DateField({
		id: 'kartu_stok_tanggal_startSearchField',
		fieldLabel: ' ',
		format : 'Y-m-d',
		name: 'kartu_stok_tanggal_startSearchField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
        //endDateField: 'stok_tglakhirField'
		value: firstday
	});
	
	kartu_stok_tanggal_endSearchField= new Ext.form.DateField({
		id: 'kartu_stok_tanggal_endSearchField',
		fieldLabel: 's/d',
		format : 'Y-m-d',
		name: 'kartu_stok_tanggal_endSearchField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
        //startDateField: 'stok_tglawalField',
		value: today
	});
	
	kartu_stok_bulanField=new Ext.form.ComboBox({
		id:'kartu_stok_bulanField',
		fieldLabel:' ',
		store:new Ext.data.SimpleStore({
			fields:['value', 'display'],
			data:[['01','Januari'],['02','Pebruari'],['03','Maret'],['04','April'],['05','Mei'],['06','Juni'],['07','Juli'],['08','Agustus'],['09','September'],['10','Oktober'],['11','Nopember'],['12','Desember']]
		}),
		mode: 'local',
		displayField: 'display',
		valueField: 'value',
		value: thismonth,
		width: 100,
		//disabled: true,
		triggerAction: 'all'
	});
	
	kartu_stok_tahunField=new Ext.form.ComboBox({
		id:'kartu_stok_tahunField',
		fieldLabel:' ',
		store:new Ext.data.SimpleStore({
			fields:['tahun'],
			data: <?php echo $tahun; ?>
		}),
		mode: 'local',
		displayField: 'tahun',
		valueField: 'tahun',
		value: thisyear,
		width: 100,
		//disabled: true,
		triggerAction: 'all'
	});
	
	var kartu_stok_opsiperiodeField=new Ext.form.FieldSet({
		id:'kartu_stok_opsiperiodeField',
		title : 'Periode',
		layout: 'form',
		bodyStyle:'padding: 0px 0px 0',
		frame: false,
		bolder: false,
		anchor: '98%',
		items:[/*{
				layout: 'column',
				border: false,
				items:[kartu_stok_opsiallField]
			},*/{
				layout: 'column',
				border: false,
				items:[kartu_stok_opsitglField, {
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[kartu_stok_tanggal_startSearchField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[kartu_stok_tanggal_endSearchField]
					   }]
			},{
				layout: 'column',
				border: false,
				items:[kartu_stok_opsiblnField,{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[kartu_stok_bulanField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[kartu_stok_tahunField]
					   }]
			}]
	});
	//// end of tgl n bulan
	
	
	/*kartu_stok_tanggal_startSearchField=new Ext.form.DateField({
		id: 'kartu_stok_tanggal_startSearchField',
		fieldLabel: 'Tanggal',
		format: 'd-m-Y',
		allowBlank: false,
		value: firstday
	});
    
	kartu_stok_tanggal_endSearchField=new Ext.form.DateField({
		id: 'kartu_stok_tanggal_endSearchField',
		fieldLabel: 's/d',
		format: 'd-m-Y',
		allowBlank: false,
		value: today
	});*/
	
	kartu_stok_produk_allField=new Ext.form.Radio({
		name:'opsi_produk',
		boxLabel: 'Semua',
		checked: true,
		width: 100
	});
	
	kartu_stok_produk_selectField=new Ext.form.Radio({
		name:'opsi_produk',
		boxLabel: 'Produk',
		width: 100
	});
	
	kartu_stok_satuan_terkecilField=new Ext.form.Radio({
		name:'opsi_satuan',
		boxLabel: 'Satuan Terkecil',
		width: 100
	});
	
	kartu_stok_satuan_defaultField=new Ext.form.Radio({
		name:'opsi_satuan',
		boxLabel: 'Satuan Default',
		checked: true,
		width: 100
	});
	
	kartu_stok_label_tanggalField=new Ext.form.Label({ html: ' &nbsp; s/d  &nbsp;'});
	
	kartu_stok_produk_opsiSearchField=new Ext.form.FieldSet({
		id:'kartu_stok_produk_opsiSearchField',
		title: 'Opsi Produk',
		layout: 'form',
		frame: false,
		boduStyle: 'padding: 5px;',
		items:[{
			   		layout	: 'column',
					border: false,
					items	: [kartu_stok_produk_allField]
			   },
			   {
				   layout	: 'column',
				   border: false,
				   items	: [kartu_stok_produk_selectField,kartu_stok_produk_namaSearchField]
			   }
			
		]
	});
	
	kartu_stok_satuan_opsiSearchField=new Ext.form.FieldSet({
		id:'kartu_stok_satuan_opsiSearchField',
		title: 'Opsi Satuan',
		layout: 'form',
		frame: false,
		boduStyle: 'padding: 5px;',
		items:[{
			   		layout	: 'column',
					border: false,
					items	: [kartu_stok_satuan_defaultField]
			   },
			   {
				   layout	: 'column',
				   border: false,
				   items	: [kartu_stok_satuan_terkecilField]
			   }
			
		]
	});
	
	/* Function for retrieve search Form Panel */
	kartu_stok_searchForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		autoHeight:true,
		width: 450,        
		items: [{
			layout:'column',
			border:false,
			items:[
			{
				columnWidth: 1,
				layout: 'form',
				border:false,
				items: [kartu_stok_gudangSearchField, kartu_stok_produk_namaSearchField,kartu_stok_satuan_opsiSearchField, kartu_stok_opsiperiodeField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: kartu_stok_list_search
			},{
				text: 'Close',
				handler: function(){
					kartu_stok_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	kartu_stok_searchWindow = new Ext.Window({
		title: 'Pencarian Kartu Stok',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_kartu_stok_search',
		items: kartu_stok_searchForm
	});
    /* End of Function */ 
	 
	function reset_search_form(){
		//kartu_stok_gudangSearchField.reset();
		//kartu_stok_gudangSearchField.setValue(null);
		kartu_stok_satuan_defaultField.setValue(true);
		kartu_stok_produk_allField.setValue(true);
		//kartu_stok_produk_namaSearchField.reset();
		//kartu_stok_produk_namaSearchField.setValue(null);
		kartu_stok_tanggal_startSearchField.reset();
		kartu_stok_tanggal_startSearchField.setValue(firstday);
		kartu_stok_tanggal_endSearchField.reset();
		kartu_stok_tanggal_endSearchField.setValue(today);
	}
	
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		reset_search_form();
		
		if(!kartu_stok_searchWindow.isVisible()){
			kartu_stok_searchWindow.show();
		} else {
			kartu_stok_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function kartu_stok_print(){
		var searchquery = "";
		var produk_id_print=null;
		var tanggal_start_print=null;
		var tanggal_end_print=null;
		var opsi_satuan_print=null;
		var gudang_print=null;
		var win;            
		
		
		Ext.MessageBox.show({
		   msg: 'Sedang memproses data, mohon tunggu...',
		   progressText: 'proses...',
		   width:350,
		   wait:true
		});
		
		// check if we do have some search data...
		if(kartu_stok_DataStore.baseParams.query!==null){searchquery = kartu_stok_DataStore.baseParams.query;}
		if(kartu_stok_DataStore.baseParams.produk_id!==null){produk_id_print = kartu_stok_DataStore.baseParams.produk_id;}
		if(kartu_stok_DataStore.baseParams.tanggal_start!==null){tanggal_start_print = kartu_stok_DataStore.baseParams.tanggal_start;}
		if(kartu_stok_DataStore.baseParams.tanggal_end!==null){tanggal_end_print = kartu_stok_DataStore.baseParams.tanggal_end;}
		if(kartu_stok_DataStore.baseParams.opsi_satuan!==null){opsi_satuan_print = kartu_stok_DataStore.baseParams.opsi_satuan;}
		if(kartu_stok_DataStore.baseParams.gudang!==null){gudang_print = kartu_stok_DataStore.baseParams.gudang;}
		
				if(kartu_stok_bulanField.getValue()!==null){kartu_stok_bulan=kartu_stok_bulanField.getValue();}
			if(kartu_stok_tahunField.getValue()!==null){kartu_stok_tahun=kartu_stok_tahunField.getValue();}
			
			if(kartu_stok_opsitglField.getValue()==true){
				kartu_stok_periode='tanggal';
			}else if(kartu_stok_opsiblnField.getValue()==true){
				if (kartu_stok_bulanField.getValue() == '01') {
					nama_bulan='Januari'
				}else if(kartu_stok_bulanField.getValue() == '02') {
					nama_bulan='Februari'
				}else if(kartu_stok_bulanField.getValue() == '03') {
					nama_bulan='Maret'
				}else if(kartu_stok_bulanField.getValue() == '01') {
					nama_bulan='April'
				}else if(kartu_stok_bulanField.getValue() == '05') {
					nama_bulan='Mei'
				}else if(kartu_stok_bulanField.getValue() == '06') {
					nama_bulan='Juni'
				}else if(kartu_stok_bulanField.getValue() == '07') {
					nama_bulan='Juli'
				}else if(kartu_stok_bulanField.getValue() == '08') {
					nama_bulan='Agustus'
				}else if(kartu_stok_bulanField.getValue() == '09') {
					nama_bulan='September'
				}else if(kartu_stok_bulanField.getValue() == '10') {
					nama_bulan='Oktober'
				}else if(kartu_stok_bulanField.getValue() == '11') {
					nama_bulan='November'
				}else if(kartu_stok_bulanField.getValue() == '12') {
					nama_bulan='Desember'
				}
				
				kartu_stok_periode='bulan';
			}else{
				kartu_stok_periode='all';
			}
		
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_kartu_stok&m=get_action',
		timeout: 3600000,
		params: {
			task			: "PRINT",
		  	query			: searchquery,                    		
			produk_id 		: produk_id_print,
			tanggal_start 	: tanggal_start_print,
			tanggal_end 	: tanggal_end_print,
			opsi_satuan 	: opsi_satuan_print,
			gudang 			: gudang_print,
			bulan		: kartu_stok_bulan,
			tahun		: kartu_stok_tahun,
			periode		: kartu_stok_periode,
		  	currentlisting	: kartu_stok_DataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				Ext.MessageBox.hide();
				win = window.open('./print/kartu_stok_printlist.html','kartu_stoklist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
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
	function kartu_stok_export_excel(){
		var searchquery = "";
		var produk_id_2excel=null;
		var produk_nama_2excel=null;
		var satuan_id_2excel=null;
		var satuan_nama_2excel=null;
		var stok_saldo_2excel=null;
		var tanggal_start_2excel=null;
		var tanggal_end_2excel=null;
		var gudang_2excel=null;
		var opsi_satuan_2excel=null;
		var win;                      
		
		// check if we do have some search data...
		if(kartu_stok_DataStore.baseParams.query!==null){searchquery = kartu_stok_DataStore.baseParams.query;}
		if(kartu_stok_DataStore.baseParams.produk_id!==null){produk_id_2excel = kartu_stok_DataStore.baseParams.produk_id;}
		if(kartu_stok_DataStore.baseParams.tanggal_start!==null){tanggal_start_2excel = kartu_stok_DataStore.baseParams.tanggal_start;}
		if(kartu_stok_DataStore.baseParams.tanggal_end!==null){tanggal_end_2excel = kartu_stok_DataStore.baseParams.tanggal_end;}
		if(kartu_stok_DataStore.baseParams.opsi_satuan!==null){opsi_satuan_2excel = kartu_stok_DataStore.baseParams.opsi_satuan;}
		if(kartu_stok_DataStore.baseParams.gudang!==null){gudang_2excel = kartu_stok_DataStore.baseParams.gudang;}
		
		
		// check if we do have some search data...
		if(kartu_stok_DataStore.baseParams.query!==null){searchquery = kartu_stok_DataStore.baseParams.query;}
		if(kartu_stok_DataStore.baseParams.produk_id!==null){produk_id_print = kartu_stok_DataStore.baseParams.produk_id;}
		if(kartu_stok_DataStore.baseParams.tanggal_start!==null){tanggal_start_print = kartu_stok_DataStore.baseParams.tanggal_start;}
		if(kartu_stok_DataStore.baseParams.tanggal_end!==null){tanggal_end_print = kartu_stok_DataStore.baseParams.tanggal_end;}
		if(kartu_stok_DataStore.baseParams.opsi_satuan!==null){opsi_satuan_print = kartu_stok_DataStore.baseParams.opsi_satuan;}
		if(kartu_stok_DataStore.baseParams.gudang!==null){gudang_print = kartu_stok_DataStore.baseParams.gudang;}
		
		if(kartu_stok_bulanField.getValue()!==null){kartu_stok_bulan=kartu_stok_bulanField.getValue();}
			if(kartu_stok_tahunField.getValue()!==null){kartu_stok_tahun=kartu_stok_tahunField.getValue();}
			
			if(kartu_stok_opsitglField.getValue()==true){
				kartu_stok_periode='tanggal';
			}else if(kartu_stok_opsiblnField.getValue()==true){
				if (kartu_stok_bulanField.getValue() == '01') {
					nama_bulan='Januari'
				}else if(kartu_stok_bulanField.getValue() == '02') {
					nama_bulan='Februari'
				}else if(kartu_stok_bulanField.getValue() == '03') {
					nama_bulan='Maret'
				}else if(kartu_stok_bulanField.getValue() == '01') {
					nama_bulan='April'
				}else if(kartu_stok_bulanField.getValue() == '05') {
					nama_bulan='Mei'
				}else if(kartu_stok_bulanField.getValue() == '06') {
					nama_bulan='Juni'
				}else if(kartu_stok_bulanField.getValue() == '07') {
					nama_bulan='Juli'
				}else if(kartu_stok_bulanField.getValue() == '08') {
					nama_bulan='Agustus'
				}else if(kartu_stok_bulanField.getValue() == '09') {
					nama_bulan='September'
				}else if(kartu_stok_bulanField.getValue() == '10') {
					nama_bulan='Oktober'
				}else if(kartu_stok_bulanField.getValue() == '11') {
					nama_bulan='November'
				}else if(kartu_stok_bulanField.getValue() == '12') {
					nama_bulan='Desember'
				}
				
				kartu_stok_periode='bulan';
			}else{
				kartu_stok_periode='all';
			}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_kartu_stok&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			produk_id : produk_id_2excel,
			tanggal_start : tanggal_start_2excel,
			tanggal_end : tanggal_end_2excel,
			opsi_satuan : opsi_satuan_2excel,
			gudang : gudang_2excel,
			bulan		: kartu_stok_bulan,
			tahun		: kartu_stok_tahun,
			periode		: kartu_stok_periode,
		  	currentlisting: kartu_stok_DataStore.baseParams.task // this tells us if we are searching or not
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
	
	
	kartu_stok_searchWindow.show();
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_kartu_stok"></div>
         <div id="fp_vu_kartu_stok"></div>
		<div id="elwindow_kartu_stok_save"></div>
        <div id="elwindow_kartu_stok_search"></div>
    </div>
</div>
</body>
</html>