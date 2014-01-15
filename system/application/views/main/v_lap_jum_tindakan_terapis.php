<?
/* 
	+ Module  		: report Tindakan View
	+ Description	: For record view
	+ Filename 		: v_lap_jum_tindakan_terapis.php
 	+ Author  		: Fred
	
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
Ext.namespace('Ext.ux.plugin');

Ext.ux.plugin.triggerfieldTooltip = function(config){
    Ext.apply(this, config);
};

Ext.extend(Ext.ux.plugin.triggerfieldTooltip, Ext.util.Observable,{
    init: function(component){
        this.component = component;
        this.component.on('render', this.onRender, this);
    },
    
    //private
    onRender: function(){
        if(this.component.tooltip){
            if(typeof this.component.tooltip == 'object'){
                Ext.QuickTips.register(Ext.apply({
                      target: this.component.trigger
                }, this.component.tooltip));
            } else {
                this.component.trigger.dom[this.component.tooltipType] = this.component.tooltip;
            }
        }
    }
}); 

Ext.apply(Ext.form.VTypes, {
    daterange : function(val, field) {
        var date = field.parseDate(val);

        if(!date){
            return;
        }
        if (field.startDateField && (!this.dateRangeMax || (date.getTime() != this.dateRangeMax.getTime()))) {
            var start = Ext.getCmp(field.startDateField);
            start.setMaxValue(date);
            start.validate();
            this.dateRangeMax = date;
        } 
        else if (field.endDateField && (!this.dateRangeMin || (date.getTime() != this.dateRangeMin.getTime()))) {
            var end = Ext.getCmp(field.endDateField);
            end.setMinValue(date);
            end.validate();
            this.dateRangeMin = date;
        }
        /*
         * Always return true since we're only using this vtype to set the
         * min/max allowed values (these are tested for after the vtype test)
         */
        return true;
    }
});
/* declare function */		
var lap_jum_tindakan_terapisDataStore;
var sum_lap_jum_DataStore;
var lap_jum_tindakan_terapisColumnModel;
var sum_lap_jum_ColumnModel;
var lap_jum_tindakan_terapisListEditorGrid;
var lap_jum_tindakan_terapis_searchForm;
var lap_jum_tindakan_terapis_searchWindow;
var lap_jum_tindakan_terapisSelectedRow;
var lap_jum_tindakan_terapisContextMenu;
//for detail data
var lap_jum_tindakan_terapis_detail_DataStore;
var lap_jum_tindakan_terapisdetailListEditorGrid;

var today=new Date().format('d-m-Y');
var yesterday=new Date().add(Date.DAY, -1).format('Y-m-d');
var thismonth=new Date().format('m');
var thisyear=new Date().format('Y');

//declare konstant
var post2db = '';
var msg = '';
var pageS_tr=250;

/* declare variable here for Field*/
//var lap_jum_tindakan_terapis_idField;
var lap_jum_tindakan_terapis_idSearchField;
var lap_jum_tindakan_terapis_groupbyField;

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

	function is_lap_jum_tindakan_terapis_searchform_valid(){
		return (Ext.getCmp('lap_jum_tindakan_tglStartSearchField').isValid() && lap_jum_tindakan_terapis_dokterSearchField.isValid());
	}

	Ext.util.Format.comboRenderer = function(combo){
		return function(value){
			var record = combo.findRecord(combo.valueField, value);
			return record ? record.get(combo.displayField) : combo.valueNotFoundText;
		}
	}
  
	/* Function for Retrieve DataStore */
	lap_jum_tindakan_terapisDataStore = new Ext.data.Store({
		id: 'lap_jum_tindakan_terapisDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_lap_jum_tindakan_terapis&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST",start:0,limit:pageS_tr, terapis_id : 0}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'dtrawat_id'
		},[
		/* dataIndex => insert intolap_jum_tindakan_terapisColumnModel, Mapping => for initiate table column */ 
			{name: 'dtrawat_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'dtrawat_date_create'},
			{name: 'tindakan_dokter', type: 'string', mapping: 'karyawan_username'}, 
			{name: 'tindakan_perawatan', type: 'string', mapping: 'rawat_nama'},
			{name: 'rawat_kode', type: 'string', mapping: 'rawat_kode'},
			{name: 'dtrawat_id', type: 'int', mapping: 'dtrawat_id'},
			{name: 'dtrawat_edit', type: 'string', mapping: 'Jumlah_rawat'},
			{name: 'dtrawat_skredit', type: 'string', mapping: 'rawat_kredit'},
			{name: 'dtrawat_jkredit', type: 'string', mapping: 'Total_kredit'},
		]),
		sortInfo:{field: 'tindakan_dokter', direction: "DESC"}
	});
	/* End of Function */
	
	/* Function for summary kredit data store */ 
	sum_lap_jum_DataStore = new Ext.data.Store({
		id: 'sum_lap_jum_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_lap_jum_tindakan_terapis&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST2",start:0,limit:pageS_tr}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'dtrawat_id'
		},[
		/* dataIndex => insert intolap_jum_tindakan_terapisColumnModel, Mapping => for initiate table column */ 
			{name: 'dtrawat_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'dtrawat_date_create'},
			{name: 'tindakan_dokter', type: 'string', mapping: 'karyawan_username'}, 
			{name: 'tindakan_perawatan', type: 'string', mapping: 'rawat_nama'},
			{name: 'rawat_kode', type: 'string', mapping: 'rawat_kode'},
			{name: 'dtrawat_id', type: 'int', mapping: 'dtrawat_id'},
			{name: 'dtrawat_edit', type: 'string', mapping: 'Jumlah_rawat'},
			{name: 'dtrawat_skredit', type: 'string', mapping: 'rawat_kredit'},
			{name: 'dtrawat_jkredit', type: 'string', mapping: 'Total_kredit'},
			{name: 'dtrawat_kredit', type: 'string', mapping: 'grand_total'},
		]),
		sortInfo:{field: 'tindakan_dokter', direction: "DESC"}
	});
	/* End of Function */
	
	cbo_dtindakan_dokterDataStore = new Ext.data.Store({
		id: 'cbo_dtindakan_dokterDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_lap_jum_tindakan_terapis&m=get_terapis_list', 
			method: 'POST'
		}),baseParams: {task : "LIST", start: 0, limit: 30 },
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id : 'karyawan_id'
		},[
		/* dataIndex => insert intotbl_usersColumnModel, Mapping => for initiate table column */ 
			{name: 'karyawan_display', type: 'string', mapping: 'karyawan_nama'},
			{name: 'karyawan_username', type: 'string', mapping: 'karyawan_username'},
			{name: 'karyawan_value', type: 'int', mapping: 'karyawan_id'}
			//{name: 'karyawan_jmltindakan', type: 'int', mapping: 'reportt_jmltindakan'}
		]),
		sortInfo:{field: 'karyawan_display', direction: "ASC"}
	});
	var dokter_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{karyawan_username}</b> | {karyawan_display} </span>',
        '</div></tpl>'
    );
    
  	/* Function for Identify of Window Column Model */
	lap_jum_tindakan_terapisColumnModel = new Ext.grid.ColumnModel(
		[
		{
			align : 'right',
			header: '<div align="center">' + 'No' + '</div>',
			renderer: function(v, p, r, rowIndex, i, ds){return '' + (rowIndex+1)},
			width: 40,
			autoWidth: true
		},
		{
			header: '<div align="center">' + 'Kode' + '</div>',
			dataIndex: 'rawat_kode',
			width: 100,//185,	//210,
			sortable: true,
		}, 
		{
			header: '<div align="center">' + 'Perawatan' + '</div>',
			dataIndex: 'tindakan_perawatan',
			width: 300,//185,	//210,
			sortable: true,
		}, 
		{	
			align : 'Right',
			header: '<div align="center">' + 'Jml' + '</div>',
			dataIndex: 'dtrawat_edit',
			width: 60,	//55,
			sortable: false
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Kredit (Poin)' + '</div>',
			dataIndex: 'dtrawat_skredit',
			width: 120,	//55,
			sortable: false
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Tot Kredit (Poin)' + '</div>',
			dataIndex: 'dtrawat_jkredit',
			width: 120,
			sortable: true
		},
	]);
	
	lap_jum_tindakan_terapisColumnModel.defaultSortable= true;
	/* End of Function */
	
	
	var lap_jum_tindakan_terapis_dokterField=new Ext.form.TextField({
		id: 'lap_jum_tindakan_terapis_dokterField',
		name: 'lap_jum_tindakan_terapis_dokterField',
		//dataIndex : 'tindakan_dokter',
		fieldLabel: '<b>Terapis</b>',
		width: 100,
		readOnly: true,
		disabled: true
	});
	
	 
	sum_lap_jum_ColumnModel = new Ext.grid.ColumnModel(
		[
		{	
			align : 'Right',
			header: '<div align="right">' + 'Grand Tot Kredit (Rp)' + '</div>',
			dataIndex: 'dtrawat_kredit',
			width: 80,	//55,
			sortable: false
		},
		]);
	
	sum_lap_jum_ColumnModel.defaultSortable= true;
	/* End of Function */

	/* Declare DataStore and  show datagrid list */
	lap_jum_tindakan_terapisListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'lap_jum_tindakan_terapisListEditorGrid',
		el: 'fp_lap_jum_tindakan_terapis',
		title: 'Laporan Jumlah Tindakan Aesthetic',
		autoHeight: false,
		height: 444,
		store: lap_jum_tindakan_terapisDataStore, // DataStore
		cm: lap_jum_tindakan_terapisColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		//clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 900, //940,//1200,	//970,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS_tr,
			disabled:false,
			store: lap_jum_tindakan_terapisDataStore,
			displayInfo: true
		}),
		/* Add Control on ToolBar */
		tbar: [
		{
			'text':'Terapis : '
		},
		lap_jum_tindakan_terapis_dokterField,
		{
			text: 'Search',
			tooltip: 'Advanced Search',
			iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: lap_jum_tindakan_terapis_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: lap_jum_tindakan_terapis_print  
		}
		]
	});
	lap_jum_tindakan_terapisListEditorGrid.render();
	/* End of DataStore */
	
	lap_jum_tindakan_terapisListEditorGrid2 =  new Ext.grid.EditorGridPanel({
		id: 'lap_jum_tindakan_terapisListEditorGrid2',
		el: 'fp_lap_jum_tindakan_terapis',
		title: '',
		autoHeight: true,
		store: sum_lap_jum_DataStore, // DataStore
		cm: sum_lap_jum_ColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		//clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 900, //940,//1200,	//970,
	
		/* Add Control on ToolBar */
	
	});
	lap_jum_tindakan_terapisListEditorGrid2.render();
	
	/* Create Context Menu */
	lap_jum_tindakan_terapisContextMenu = new Ext.menu.Menu({
		id: '',
		items: [
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: lap_jum_tindakan_terapis_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: lap_jum_tindakan_terapis_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onlap_jum_tindakan_terapisListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		lap_jum_tindakan_terapisContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		lap_jum_tindakan_terapisSelectedRow=rowIndex;
		lap_jum_tindakan_terapisContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
		
	lap_jum_tindakan_terapisListEditorGrid.addListener('rowcontextmenu', onlap_jum_tindakan_terapisListEditGridContextMenu);
	//lap_jum_tindakan_terapisDataStore.load({params: {start: 0, limit: pageS_tr}});	// load DataStore
	//lap_jum_tindakan_terapisListEditorGrid.on('afteredit', tindakan_medis_update); // inLine Editing Record
	
	/*Detail Declaration */	
	/* Function for Retrieve DataStore of detail*/
	lap_jum_tindakan_terapis_detail_DataStore = new Ext.data.Store({
		id: 'lap_jum_tindakan_terapis_detail_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_lap_jum_tindakan_terapis&m=detail_tindakan_detail_list', 
			method: 'POST'
		}),
		//reader: lap_jum_tindakan_terapis_detail_reader,
		//baseParams:{master_id: lap_jum_tindakan_terapis_idField.getValue()},
		sortInfo:{field: 'dtrawat_id', direction: "ASC"}
	});
	/* End of Function */
	
	var checkColumn = new Ext.grid.CheckColumn({
		header: 'Ambil Paket',
		dataIndex: 'dtrawat_ambil_paket',
		hidden: true,
		width: 75
	});
	

	/* Function for action list search */
	function lap_jum_tindakan_terapis_search(){
		// render according to a SQL date format.
		
		
		if(is_lap_jum_tindakan_terapis_searchform_valid())
		{
		var lap_jum_tindakan_terapis_id_search=null;
		var lap_jum_tindakan_terapis_tgl_start_search=null;
		var lap_jum_tindakan_terapis_tgl_end_search=null;
		var lap_jum_tindakan_terapis_dokter_search=null;
		var lap_jum_tindakan_terapis_groupby_search=null;
		var lap_jum_tindakan_tmedis_bulan=null;
		var lap_jum_tindakan_tmedis_tahun=null;
		var lap_jum_tindakan_tmedis_periode=null;
		
	
		cbo_dtindakan_dokterDataStore.load({
		 	callback: function(r,opt,success){
				if(success==true){
					var j=cbo_dtindakan_dokterDataStore.findExact('karyawan_value',lap_jum_tindakan_terapis_dokterSearchField.getValue(),0);
					if(j>-1){
						var dokter_record=cbo_dtindakan_dokterDataStore.getAt(j);
						lap_jum_tindakan_terapis_dokterField.setValue(dokter_record.data.karyawan_username);
					}
				}
			}
		});

		if(lap_jum_tindakan_terapis_idSearchField.getValue()!==null){lap_jum_tindakan_terapis_id_search=lap_jum_tindakan_terapis_idSearchField.getValue();}
		if(lap_jum_tindakan_bulanField.getValue()!==null){lap_jum_tindakan_tmedis_bulan=lap_jum_tindakan_bulanField.getValue();}
		if(lap_jum_tindakan_tahunField.getValue()!==null){lap_jum_tindakan_tmedis_tahun=lap_jum_tindakan_tahunField.getValue();}
		if(Ext.getCmp('lap_jum_tindakan_tglStartSearchField').getValue()!==null){lap_jum_tindakan_terapis_tgl_start_search=Ext.getCmp('lap_jum_tindakan_tglStartSearchField').getValue().format('Y-m-d');}
		if(Ext.getCmp('lap_jum_tindakan_tglEndSearchField').getValue()!==null){lap_jum_tindakan_terapis_tgl_end_search=Ext.getCmp('lap_jum_tindakan_tglEndSearchField').getValue().format('Y-m-d');}
		if(lap_jum_tindakan_terapis_dokterSearchField.getValue()!==null){lap_jum_tindakan_terapis_dokter_search=lap_jum_tindakan_terapis_dokterSearchField.getValue();}
		if(lap_jum_tindakan_terapis_groupbyField.getValue()!==null){lap_jum_tindakan_terapis_groupby_search=lap_jum_tindakan_terapis_groupbyField.getValue();}

		if(lap_jum_tindakan_opsitglField.getValue()==true){
			lap_jum_tindakan_tmedis_periode='tanggal';
		}else if(lap_jum_tindakan_opsiblnField.getValue()==true){
			lap_jum_tindakan_tmedis_periode='bulan';
		}else{
			lap_jum_tindakan_tmedis_periode='all';
		}
		// change the store parameters
		
		lap_jum_tindakan_terapisDataStore.baseParams = {
			task: 'SEARCH',
			//variable here
			lap_jum_tindakan_id	:	lap_jum_tindakan_terapis_id_search, 
			lapjum_tglapp_start	: 	lap_jum_tindakan_terapis_tgl_start_search,
			lapjum_tglapp_end	: 	lap_jum_tindakan_terapis_tgl_end_search,
			terapis_id	:	lap_jum_tindakan_terapis_dokter_search,
			lapjum_groupby	: lap_jum_tindakan_terapis_groupby_search,
			bulan		: lap_jum_tindakan_tmedis_bulan,
			tahun		: lap_jum_tindakan_tmedis_tahun,
			periode		: lap_jum_tindakan_tmedis_periode
		};
		sum_lap_jum_DataStore.baseParams = {
			task: 'SEARCH2',
			//variable here
			lap_jum_tindakan_id	:	lap_jum_tindakan_terapis_id_search, 
			lapjum_tglapp_start	: 	lap_jum_tindakan_terapis_tgl_start_search,
			lapjum_tglapp_end	: 	lap_jum_tindakan_terapis_tgl_end_search,
			terapis_id	:	lap_jum_tindakan_terapis_dokter_search,
			lapjum_groupby	:	lap_jum_tindakan_terapis_groupby_search,
			bulan		: lap_jum_tindakan_tmedis_bulan,
			tahun		: lap_jum_tindakan_tmedis_tahun,
			periode		: lap_jum_tindakan_tmedis_periode
		};
		// Cause the datastore to do another query : 
		lap_jum_tindakan_terapisDataStore.reload({params: {start: 0, limit: pageS_tr}});
		sum_lap_jum_DataStore.reload({params: {start: 0, limit: pageS_tr}});
		}
		else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Tanggal atau Terapis belum diisi',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
		
	/* Field for search */
	/* Identify  lap_jum_tindakan_terapis_id Search Field */
	lap_jum_tindakan_terapis_idSearchField= new Ext.form.NumberField({
		id: 'lap_jum_tindakan_terapis_idSearchField',
		fieldLabel: 'Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});

	/* Identify  Group_byField*/
	lap_jum_tindakan_terapis_groupbyField= new Ext.form.ComboBox({
		id: 'lap_jum_tindakan_terapis_groupbyField',
		fieldLabel: 'Group By',
		store:new Ext.data.SimpleStore({
			fields:['group_value', 'group_display'],
			data:[['Perawatan','Penjualan Perawatan Satuan'],['Pengambilan_Paket','Pengambilan Paket'],['Semua','Semua']]
		}),
		mode: 'local',
		editable:false,
		//emptyText: 'Semua',
		displayField: 'group_display',
		valueField: 'group_value',
		width: 200,
		triggerAction: 'all'	
	});
	
	lap_jum_tindakan_terapis_dokterSearchField= new Ext.form.ComboBox({
		fieldLabel: 'Terapis',
		store: cbo_dtindakan_dokterDataStore,
		mode: 'remote',
		displayField:'karyawan_username',
		valueField: 'karyawan_value',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: dokter_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		allowBlank: false,
		width: 214
	});

	
	/////tgl n bulan
	lap_jum_tindakan_opsitglField=new Ext.form.Radio({
		id:'lap_jum_tindakan_opsitglField',
		boxLabel:'Tanggal',
		width:100,
		name: 'filter_opsi',
		checked: true
	});
	
	lap_jum_tindakan_opsiblnField=new Ext.form.Radio({
		id:'lap_jum_tindakan_opsiblnField',
		boxLabel:'Bulan',
		width:100,
		name: 'filter_opsi'
	});
	
	lap_jum_tindakan_tglStartSearchField= new Ext.form.DateField({
		id: 'lap_jum_tindakan_tglStartSearchField',
		fieldLabel: ' ',
		format : 'Y-m-d',
		name: 'lap_jum_tindakan_tglStartSearchField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
        //endDateField: 'lap_jum_tindakan_tglakhirField'
		value: today
	});
	
	lap_jum_tindakan_tglEndSearchField= new Ext.form.DateField({
		id: 'lap_jum_tindakan_tglEndSearchField',
		fieldLabel: 's/d',
		format : 'Y-m-d',
		name: 'lap_jum_tindakan_tglEndSearchField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
        //startDateField: 'lap_jum_tindakan_tglawalField',
		value: today
	});
	
	lap_jum_tindakan_bulanField=new Ext.form.ComboBox({
		id:'lap_jum_tindakan_bulanField',
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
		triggerAction: 'all'
	});
	
	lap_jum_tindakan_tahunField=new Ext.form.ComboBox({
		id:'lap_jum_tindakan_tahunField',
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
		triggerAction: 'all'
	});
	
	var lap_jum_tindakan_periodeField=new Ext.form.FieldSet({
		id:'lap_jum_tindakan_periodeField',
		title : 'Periode',
		layout: 'form',
		bodyStyle:'padding: 0px 0px 0',
		frame: false,
		bolder: false,
		anchor: '98%',
		items:[/*{
				layout: 'column',
				border: false,
				items:[lap_jum_tindakan_opsiallField]
			},*/{
				layout: 'column',
				border: false,
				items:[lap_jum_tindakan_opsitglField, {
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[lap_jum_tindakan_tglStartSearchField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[lap_jum_tindakan_tglEndSearchField]
					   }]
			},{
				layout: 'column',
				border: false,
				items:[lap_jum_tindakan_opsiblnField,{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[lap_jum_tindakan_bulanField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[lap_jum_tindakan_tahunField]
					   }]
			}]
	});
	
	//end of tgl n bulan
	var dt = new Date(); 
	
	/* Function for retrieve search Form Panel */
	lap_jum_tindakan_terapis_searchForm = new Ext.FormPanel({
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
				items: [
				        /*{
						layout:'column',
						border:false,
						items:[
				        {
							columnWidth:0.33,
							layout: 'form',
							border:false,
							defaultType: 'datefield',
							items: [
							    {
									fieldLabel: 'Tanggal Tindakan',
							        name: 'lap_jum_tindakan_terapis_tglStartSearchField',
							        id: 'lap_jum_tindakan_terapis_tglStartSearchField',
									vtype: 'daterange',
									allowBlank: false,
									format: 'd-m-Y',
							        endDateField: 'lap_jum_tindakan_terapis_tglEndSearchField' // id of the end date field Ext.getCmp('lap_jum_tindakan_terapis_tglStartSearchField').isValid()
							    }] 
						},
						{
							columnWidth:0.30,
							layout: 'form',
							labelWidth:20,
							border:false,
							defaultType: 'datefield',
							items: [
						      	{
									fieldLabel: 's/d',
							        name: 'lap_jum_tindakan_terapis_tglEndSearchField',
							        id: 'lap_jum_tindakan_terapis_tglEndSearchField',
							        vtype: 'daterange',
									allowBlank: false,
									format: 'd-m-Y',
							        startDateField: 'lap_jum_tindakan_terapis_tglStartSearchField' // id of the end date field
							    }] 
						}]}*/lap_jum_tindakan_periodeField,lap_jum_tindakan_terapis_dokterSearchField,lap_jum_tindakan_terapis_groupbyField] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Search',
				handler: lap_jum_tindakan_terapis_search
			},{
				text: 'Close',
				handler: function(){
					lap_jum_tindakan_terapis_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
    
	function lap_jum_tindakan_terapis_reset_formSearch(){
		lap_jum_tindakan_terapis_idSearchField.reset();
		lap_jum_tindakan_terapis_idSearchField.setValue(null);
		lap_jum_tindakan_terapis_dokterSearchField.reset();
		lap_jum_tindakan_terapis_dokterSearchField.setValue(null);
		lap_jum_tindakan_terapis_groupbyField.reset();
		lap_jum_tindakan_terapis_groupbyField.setValue('Semua');
		Ext.getCmp('lap_jum_tindakan_tglStartSearchField').reset();
		Ext.getCmp('lap_jum_tindakan_tglStartSearchField').setValue(today);
		Ext.getCmp('lap_jum_tindakan_tglEndSearchField').reset();
		Ext.getCmp('lap_jum_tindakan_tglEndSearchField').setValue(today);
	}
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	lap_jum_tindakan_terapis_searchWindow = new Ext.Window({
		title: 'Pencarian Jumlah Tindakan Aesthetic',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_lap_jum_tindakan_terapis_search',
		items: lap_jum_tindakan_terapis_searchForm
	});
    /* End of Function */ 
	 
	lap_jum_tindakan_terapis_searchWindow.show();
	lap_jum_tindakan_terapis_reset_formSearch();
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!lap_jum_tindakan_terapis_searchWindow.isVisible()){
			lap_jum_tindakan_terapis_reset_formSearch();
			lap_jum_tindakan_terapis_searchWindow.show();
		} else {
			lap_jum_tindakan_terapis_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	function is_valid_form(){
		if(lap_jum_tindakan_opsitglField.getValue()==true){
			lap_jum_tindakan_tglStartSearchField.allowBlank=false;
			lap_jum_tindakan_tglEndSearchField.allowBlank=false;
			if(lap_jum_tindakan_tglStartSearchField.isValid() && lap_jum_tindakan_tglEndSearchField.isValid())
				return true;
			else
				return false;
		}else{
			lap_jum_tindakan_tglStartSearchField.allowBlank=true;
			lap_jum_tindakan_tglEndSearchField.allowBlank=true;
			return true;
		}
	}

	/* Function for print List Grid */
	function lap_jum_tindakan_terapis_print(){
		var searchquery = "";
		var trawat_cust_print=null;
		var trawat_keterangan_print=null;
		var lap_jum_tindakan_terapis_id_print=null;
		var lap_jum_tindakan_terapis_tgl_start_print=null;
		var lap_jum_tindakan_terapis_tgl_end_print=null;
		var lap_jum_tindakan_terapis_dokter_print=null;
		var lap_jum_tindakan_terapis_groupby_print=null;
		var lap_jum_tindakan_tmedis_bulan=null;
		var lap_jum_tindakan_tmedis_tahun=null;
		var lap_jum_tindakan_tmedis_periode=null;
		var win;              
		// check if we do have some search data...
		
		if(lap_jum_tindakan_terapis_idSearchField.getValue()!==null){lap_jum_tindakan_terapis_id_print=lap_jum_tindakan_terapis_idSearchField.getValue();}
		if(lap_jum_tindakan_bulanField.getValue()!==null){lap_jum_tindakan_tmedis_bulan=lap_jum_tindakan_bulanField.getValue();}
		if(lap_jum_tindakan_tahunField.getValue()!==null){lap_jum_tindakan_tmedis_tahun=lap_jum_tindakan_tahunField.getValue();}
		if(Ext.getCmp('lap_jum_tindakan_tglStartSearchField').getValue()!==null){lap_jum_tindakan_terapis_tgl_start_print=Ext.getCmp('lap_jum_tindakan_tglStartSearchField').getValue().format('Y-m-d');}
		if(Ext.getCmp('lap_jum_tindakan_tglEndSearchField').getValue()!==null){lap_jum_tindakan_terapis_tgl_end_print=Ext.getCmp('lap_jum_tindakan_tglEndSearchField').getValue().format('Y-m-d');}
		if(lap_jum_tindakan_terapis_dokterSearchField.getValue()!==null){lap_jum_tindakan_terapis_dokter_print=lap_jum_tindakan_terapis_dokterSearchField.getValue();}
		if(lap_jum_tindakan_terapis_groupbyField.getValue()!==null){lap_jum_tindakan_terapis_groupby_print=lap_jum_tindakan_terapis_groupbyField.getValue();}

		if(lap_jum_tindakan_opsitglField.getValue()==true){
			lap_jum_tindakan_tmedis_periode='tanggal';
		}else if(lap_jum_tindakan_opsiblnField.getValue()==true){
			lap_jum_tindakan_tmedis_periode='bulan';
		}else{
			lap_jum_tindakan_tmedis_periode='all';
		}
		

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_lap_jum_tindakan_terapis&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			
			lap_jum_tindakan_id	:	lap_jum_tindakan_terapis_id_print, 
			lapjum_tglapp_start	: 	lap_jum_tindakan_terapis_tgl_start_print,
			lapjum_tglapp_end	: 	lap_jum_tindakan_terapis_tgl_end_print,
			terapis_id	:	lap_jum_tindakan_terapis_dokter_print,
			lapjum_groupby	: lap_jum_tindakan_terapis_groupby_print,
			bulan		: lap_jum_tindakan_tmedis_bulan,
			tahun		: lap_jum_tindakan_tmedis_tahun,
			periode		: lap_jum_tindakan_tmedis_periode,
			


		  	currentlisting: lap_jum_tindakan_terapisDataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./tindakanlist.html','tindakanlist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
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
	function lap_jum_tindakan_terapis_export_excel(){
		var searchquery = "";
		var tindakan_dokter_2excel=null;
		var lap_jum_tindakan_terapis_tgl_start_search=null;
		var lap_jum_tindakan_terapis_tgl_end_search=null;
		var lap_jum_tindakan_terapis_dokter_search=null;
		var lap_jum_tindakan_terapis_groupby_search=null;
		var lap_jum_tindakan_tmedis_bulan=null;
		var lap_jum_tindakan_tmedis_tahun=null;
		var lap_jum_tindakan_tmedis_periode=null;
		var win;              
		// check if we do have some search data...
		if(lap_jum_tindakan_terapisDataStore.baseParams.query!==null){searchquery = lap_jum_tindakan_terapisDataStore.baseParams.query;}
		//if(lap_jum_tindakan_terapisDataStore.baseParams.terapis_id!==null){tindakan_dokter_2excel = lap_jum_tindakan_terapisDataStore.baseParams.terapis_id;}
		if(Ext.getCmp('lap_jum_tindakan_tglStartSearchField').getValue()!==null){lap_jum_tindakan_terapis_tgl_start_search=Ext.getCmp('lap_jum_tindakan_tglStartSearchField').getValue().format('Y-m-d');}
		if(Ext.getCmp('lap_jum_tindakan_tglEndSearchField').getValue()!==null){lap_jum_tindakan_terapis_tgl_end_search=Ext.getCmp('lap_jum_tindakan_tglEndSearchField').getValue().format('Y-m-d');}
		if(lap_jum_tindakan_terapis_dokterSearchField.getValue()!==null){lap_jum_tindakan_terapis_dokter_search=lap_jum_tindakan_terapis_dokterSearchField.getValue();}
		if(lap_jum_tindakan_terapis_groupbyField.getValue()!==null){lap_jum_tindakan_terapis_groupby_search=lap_jum_tindakan_terapis_groupbyField.getValue();}
		if(lap_jum_tindakan_bulanField.getValue()!==null){lap_jum_tindakan_tmedis_bulan=lap_jum_tindakan_bulanField.getValue();}
		if(lap_jum_tindakan_tahunField.getValue()!==null){lap_jum_tindakan_tmedis_tahun=lap_jum_tindakan_tahunField.getValue();}

		if(lap_jum_tindakan_opsitglField.getValue()==true){
			lap_jum_tindakan_tmedis_periode='tanggal';
		}else if(lap_jum_tindakan_opsiblnField.getValue()==true){
			lap_jum_tindakan_tmedis_periode='bulan';
		}else{
			lap_jum_tindakan_tmedis_periode='all';
		}
		
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_lap_jum_tindakan_terapis&m=get_action',
		params: {
			task: "EXCEL",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			//terapis_id : tindakan_dokter_2excel,
			lapjum_tglapp_start	: 	lap_jum_tindakan_terapis_tgl_start_search,
			lapjum_tglapp_end	: 	lap_jum_tindakan_terapis_tgl_end_search,
			terapis_id	:	lap_jum_tindakan_terapis_dokter_search,
			lapjum_groupby	: lap_jum_tindakan_terapis_groupby_search,
		  	currentlisting: lap_jum_tindakan_terapisDataStore.baseParams.task, // this tells us if we are searching or not
			bulan		: lap_jum_tindakan_tmedis_bulan,
			tahun		: lap_jum_tindakan_tmedis_tahun,
			periode		: lap_jum_tindakan_tmedis_periode
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
	
	lap_jum_tindakan_opsitglField.on("check",function(){
		if(lap_jum_tindakan_opsitglField.getValue()==true){
			lap_jum_tindakan_tglStartSearchField.allowBlank=false;
			lap_jum_tindakan_tglEndSearchField.allowBlank=false;
		}else{
			lap_jum_tindakan_tglStartSearchField.allowBlank=true;
			lap_jum_tindakan_tglEndSearchField.allowBlank=true;
		}
		
	});
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_lap_jum_tindakan_terapis"></div>
         <div id="fp_lap_jum_tindakan_terapis_detail"></div>
		 <div id="fp_dlap_jum_tindakan_terapis"></div>
		<div id="elwindow_lap_jum_tindakan_terapis_create"></div>
        <div id="elwindow_lap_jum_tindakan_terapis_search"></div>
    </div>
</div>
</body>