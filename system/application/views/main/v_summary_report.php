<?
/* 	These code was generated using phpCIGen v 0.1.b (1/08/2009)
	
	+ Description	: For record view
	+ Filename 		: v_summary_report.php
 	+ Author  		: Freddy

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
var summary_reportDataStore;
//var lap_totalkunjungan_DataStore;
var lap_kunjunganColumnModel;
//var lap_totalkunjungan_nonColumnModel;
//var lap_averageColumnModel;
var summary_reportListEditorGrid;
//var lap_kunjunganListEditorGrid2;
var lap_kunjungan_averageListEditorGrid;
var summary_report_searchForm;
var summary_report_GenerateForm;
var summary_report_searchWindow;
var summary_report_GenerateWindow;
var lap_kunjunganSelectedRow;
var summary_reportContextMenu;
//for detail data
var lap_kunjungan_detail_DataStore;
var lap_kunjungan_detail_proxy;
var lap_kunjungan_detail_writer;

var today=new Date().format('d-m-Y');
var thismonth=new Date().format('m');
var bulanlalu=new Date().add(Date.MONTH, -1).format('m');
var thisyear=new Date().format('Y');
var tahunlalu=new Date().add(Date.YEAR, -1).format('Y');

//declare konstant
var post2db = '';
var msg = '';
var pageS=31;

/* declare variable here for Field*/
//var lap_kunjungan_idSearchField;

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

	function is_summary_report_searchForm_valid(){
		//return (lap_kunjungan_tglStartSearchField.isValid()) && (lap_kunjungan_tglEndSearchField.isValid());
		return (summary_report_bulantujuanField.isValid()) && (summary_report_tahuntujuanField.isValid()
		&& summary_report_bulanpembanding1Field.isValid()) && (summary_report_tahunpembanding1Field.isValid());
	}
	
	function is_summary_report_generateForm_valid(){
		//return (lap_kunjungan_tglStartSearchField.isValid()) && (lap_kunjungan_tglEndSearchField.isValid());
		return (summary_report_bulantujuanGenerateField.isValid()) && (summary_report_tahuntujuanGenerateField.isValid()
		&& summary_report_bulanpembanding1GenerateField.isValid()) && (summary_report_tahunpembanding1GenerateField.isValid());
	}

	Ext.util.Format.comboRenderer = function(combo){
		return function(value){
			var record = combo.findRecord(combo.valueField, value);
			return record ? record.get(combo.displayField) : combo.valueNotFoundText;
		}
	}
  
	/* Function for Retrieve DataStore */
	summary_reportDataStore = new Ext.data.Store({
		id: 'summary_reportDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_summary_report&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST",start:0,limit:31}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'
			//id: 'dtrawat_id'
		},[
			{name: 'summary_jenis', type: 'string', mapping: 'jenis'},
			{name: 'summary_nilai_tujuan', type: 'int', mapping: 'nilai_tujuan'},
			{name: 'summary_nilai_target', type: 'int', mapping: 'target'},
			{name: 'summary_rata_rata', type: 'float', mapping: 'rata_rata'},
			{name: 'summary_pencapaian', type: 'float', mapping: 'pencapaian_target'},
			{name: 'summary_pembanding1', type: 'int', mapping: 'nilai_pembanding1'},
			{name: 'summary_pencapaian_pembanding1', type: 'float', mapping: 'pencapaian_pembanding1'},
			{name: 'summary_naik_turun_pencapaian_pembanding1', type: 'float', mapping: 'naik_turun_pencapaian_pembanding1'},
			{name: 'summary_rata_rata1', type: 'float', mapping: 'rata2_pembanding1'},
			{name: 'summary_naikturun_rata2_1', type: 'float', mapping: 'naik_turun_rata2_1'},
			{name: 'summary_naikturun_rata2_persen_1', type: 'float', mapping: 'naik_turun_rata2_persen_1'},
			{name: 'summary_naikturun1', type: 'int', mapping: 'naik_turun1'},
			{name: 'summary_prosentase1', type: 'float', mapping: 'prosentase_naik_turun1'},
			{name: 'summary_pembanding2', type: 'int', mapping: 'nilai_pembanding2'},
			{name: 'summary_pencapaian_pembanding2', type: 'int', mapping: 'pencapaian_pembanding2'},
			{name: 'summary_naik_turun_pencapaian_pembanding2', type: 'float', mapping: 'naik_turun_pencapaian_pembanding2'},
			{name: 'summary_rata_rata2', type: 'float', mapping: 'rata2_pembanding2'},
			{name: 'summary_naikturun_rata2_2', type: 'float', mapping: 'naik_turun_rata2_2'},
			{name: 'summary_naikturun_rata2_persen_2', type: 'float', mapping: 'naik_turun_rata2_persen_2'},
			{name: 'summary_naikturun2', type: 'int', mapping: 'naik_turun2'},
			{name: 'summary_prosentase2', type: 'float', mapping: 'prosentase_naik_turun2'}
		])
		//sortInfo:{field: 'tgl_tindakan', direction: "DESC"}
	});
	/* End of Function */
	
	/* Function for summary kredit data store */ 
	/*
	lap_totalkunjungan_DataStore = new Ext.data.Store({
		id: 'lap_totalkunjungan_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_summary_report&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST2",start:0,limit:31}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'
			
		},[
		/* dataIndex => insert intolap_kunjunganColumnModel, Mapping => for initiate table column */ 
		/*
			{name: 'dtrawat_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'dtrawat_date_create'},
			{name: 'dtrawat_id', type: 'int', mapping: 'dtrawat_id'},
			{name: 'jum_total', type: 'int', mapping: 'sum(jum_total)'},
			{name: 'jum_cust_medis', type: 'int', mapping: 'sum(jum_cust_medis)'},
			{name: 'jum_cust_surgery', type: 'int', mapping: 'sum(jum_cust_surgery)'},
			{name: 'jum_cust_antiaging', type: 'int', mapping: 'sum(jum_cust_antiaging)'},
			{name: 'jum_cust_nonmedis', type: 'int', mapping: 'sum(jum_cust_nonmedis)'},
			{name: 'jum_cust_produk', type: 'int', mapping: 'sum(jum_cust_produk)'}
		])
		//sortInfo:{field: 'tindakan_dokter', direction: "DESC"}
	});
	/* End of Function */
	
	/* Function for average  data store */ 
	/*
	lap_average_kunjungan_DataStore = new Ext.data.Store({
		id: 'lap_average_kunjungan_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_summary_report&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST3",start:0,limit:31}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'
			
		},[
		/* dataIndex => insert intolap_kunjunganColumnModel, Mapping => for initiate table column */ 
		/*
			{name: 'dtrawat_date_create', type: 'date', dateFormat: 'Y-m-d H:i:s', mapping: 'dtrawat_date_create'},
			{name: 'dtrawat_id', type: 'int', mapping: 'dtrawat_id'},
			{name: 'avg_jum_total', type: 'float', mapping: 'sum(jum_total)/count(distinct tgl_tindakan)'},
			{name: 'avg_jum_cust_medis', type: 'float', mapping: 'sum(jum_cust_medis)/count(distinct tgl_tindakan)'},
			{name: 'avg_jum_cust_surgery', type: 'float', mapping: 'sum(jum_cust_surgery)/count(distinct tgl_tindakan)'},
			{name: 'avg_jum_cust_antiaging', type: 'float', mapping: 'sum(jum_cust_antiaging)/count(distinct tgl_tindakan)'},
			{name: 'avg_jum_cust_nonmedis', type: 'float', mapping: 'sum(jum_cust_nonmedis)/count(distinct tgl_tindakan)'},
			{name: 'avg_jum_cust_produk', type: 'float', mapping: 'sum(jum_cust_produk)/count(distinct tgl_tindakan)'}
		])
		//sortInfo:{field: 'tindakan_dokter', direction: "DESC"}
	});
	/* End of Function */
	

  	/* Function for Identify of Window Column Model */
	lap_kunjunganColumnModel = new Ext.grid.ColumnModel(
		[
		{
			align : 'Left',
			header: '<div align="center">' + 'Target' + '</div>',
			dataIndex: 'summary_jenis',
			width: 80,	//55,
			sortable: true
		}, 
		{	
			align : 'Right',
			header: '<div align="center">' + 'Nilai Tujuan' + '</div>',
			dataIndex: 'summary_nilai_tujuan',
			width: 80,	//55,
			sortable: true,
			renderer: function(val){
				return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
			}
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Rata-rata' + '</div>',
			dataIndex: 'summary_rata_rata',
			width: 80,	//55,
			sortable: true,
			hidden : true,
			renderer: function(val){
				return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
			}
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Nilai Target' + '</div>',
			dataIndex: 'summary_nilai_target',
			width: 80,	//55,
			sortable: true,
			renderer: function(val){
				return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
			}
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Penc. Trgt (%)' + '</div>',
			dataIndex: 'summary_pencapaian',
			width: 80,	//55,
			sortable: true,
			hidden : true,
			renderer: function(val){
				return '<span>'+Ext.util.Format.number(val,'0.00')+'</span>';
			}
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Nilai Pemb. 1' + '</div>',
			dataIndex: 'summary_pembanding1',
			width: 80,	//55,
			sortable: true,
			renderer: function(val){
				return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
			}
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Selisih Pemb. 1' + '</div>',
			dataIndex: 'summary_naikturun1',
			width: 80,	//55,
			sortable: true,
			hidden : true,
			renderer: function(val){
				return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
			}
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Selisih Pemb. 1 (%)' + '</div>',
			dataIndex: 'summary_prosentase1',
			width: 80,	//55,
			sortable: true,
			hidden : true,
			renderer: function(val){
				return '<span>'+Ext.util.Format.number(val,'0.00')+'</span>';
			}
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Penc. Pemb. 1 (%)' + '</div>',
			dataIndex: 'summary_pencapaian_pembanding1',
			width: 80,	//55,
			sortable: true,
			hidden : true,
			renderer: function(val){
				return '<span>'+Ext.util.Format.number(val,'0.00')+'</span>';
			}
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Selisih Penc. 1 (%)' + '</div>',
			dataIndex: 'summary_naik_turun_pencapaian_pembanding1',
			width: 80,	//55,
			sortable: true,
			hidden : true,
			renderer: function(val){
				return '<span>'+Ext.util.Format.number(val,'0.00')+'</span>';
			}
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Rata-rata Pemb. 1' + '</div>',
			dataIndex: 'summary_rata_rata1',
			width: 80,	//55,
			sortable: true,
			hidden : true,
			renderer: function(val){
				return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
			}
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Selisih Rata-rata 1' + '</div>',
			dataIndex: 'summary_naikturun_rata2_1',
			width: 80,	//55,
			sortable: true,
			hidden : true,
			renderer: function(val){
				return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
			}
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Selisih Rata-rata 1 (%)' + '</div>',
			dataIndex: 'summary_naikturun_rata2_persen_1',
			width: 80,	//55,
			sortable: true,
			hidden : true,
			renderer: function(val){
				return '<span>'+Ext.util.Format.number(val,'0.00')+'</span>';
			}
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Nilai Pemb. 2' + '</div>',
			dataIndex: 'summary_pembanding2',
			width: 80,	//55,
			sortable: true,
			hidden : false,
			renderer: function(val){
				return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
			}
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Selisih Pemb. 2' + '</div>',
			dataIndex: 'summary_naikturun2',
			width: 80,	//55,
			sortable: true,
			hidden : true,
			renderer: function(val){
				return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
			}
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Selisih Pemb. 2 (%)' + '</div>',
			dataIndex: 'summary_prosentase2',
			width: 80,	//55,
			sortable: true,
			hidden : true,
			renderer: function(val){
				return '<span>'+Ext.util.Format.number(val,'0.00')+'</span>';
			}
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Penc. Pemb. 2 (%)' + '</div>',
			dataIndex: 'summary_pencapaian_pembanding2',
			width: 80,	//55,
			sortable: true,
			hidden : true,
			renderer: function(val){
				return '<span>'+Ext.util.Format.number(val,'0.00')+'</span>';
			}
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Selisih Penc. 2 (%)' + '</div>',
			dataIndex: 'summary_naik_turun_pencapaian_pembanding2',
			width: 80,	//55,
			sortable: true,
			hidden : true,
			renderer: function(val){
				return '<span>'+Ext.util.Format.number(val,'0.00')+'</span>';
			}
		},	
		{	
			align : 'Right',
			header: '<div align="center">' + 'Rata-rata Pemb. 2' + '</div>',
			dataIndex: 'summary_rata_rata2',
			width: 80,	//55,
			sortable: true,
			hidden : true,
			renderer: function(val){
				return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
			}
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Selisih Rata-rata 2' + '</div>',
			dataIndex: 'summary_naikturun_rata2_2',
			width: 80,	//55,
			sortable: true,
			hidden : true,
			renderer: function(val){
				return '<span>'+Ext.util.Format.number(val,'0,000')+'</span>';
			}
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Selisih Rata-rata 2 (%)' + '</div>',
			dataIndex: 'summary_naikturun_rata2_persen_2',
			width: 80,	//55,
			sortable: true,
			hidden : true,
			renderer: function(val){
				return '<span>'+Ext.util.Format.number(val,'0.00')+'</span>';
			}
		}

		/*
		{	
			align : 'Right',
			header: '<div align="center">' + 'Total' + '</div>',
			tooltip: 'Jumlah ini TIDAK SELALU sama dengan Medis+nonMedis+Produk',
			dataIndex: 'jum_total',
			width: 80,	//55,
			sortable: true
		}
		*/
	]);
	
	lap_kunjunganColumnModel.defaultSortable= true;
	/* End of Function */
	/* 
	lap_totalkunjungan_nonColumnModel = new Ext.grid.ColumnModel(
		[
		{	
			align : 'Right',
			header: '<div align="center">' + '<span style="font-weight:bold">Grand Total</span>' + '</div>',
			dataIndex: '',
			//hidden : true,
			disabled : false,
			width: 100,	//55,
			//sortable: true
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Medis' + '</div>',
			dataIndex: 'jum_cust_medis',
			width: 80,	//55,
			sortable: true
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Surgery' + '</div>',
			dataIndex: 'jum_cust_surgery',
			width: 80,	//55,
			sortable: true
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Anti Aging' + '</div>',
			dataIndex: 'jum_cust_antiaging',
			width: 80,	//55,
			sortable: true
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Non Medis' + '</div>',
			dataIndex: 'jum_cust_nonmedis',
			width: 80,	//55,
			sortable: true
		},
		
		{	
			align : 'Right',
			header: '<div align="center">' + 'Produk' + '</div>',
			dataIndex: 'jum_cust_produk',
			width: 80,	//55,
			sortable: true
		},
		
		{	
			align : 'Right',
			header: '<div align="center">' + 'Grand Total' + '</div>',
			dataIndex: 'jum_total',
			width: 80,	//55,
			sortable: true
		},
		]);
	
	lap_totalkunjungan_nonColumnModel.defaultSortable= true;
	*/
	/*
	lap_averageColumnModel = new Ext.grid.ColumnModel(
		[
		{	
			align : 'Right',
			header: '<div align="center">' + '<span style="font-weight:bold">Average</span>' + '</div>',
			dataIndex: '',
			//hidden : true,
			disabled : false,
			width: 100,	//55,
			//sortable: true
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Medis' + '</div>',
			dataIndex: 'avg_jum_cust_medis',
			width: 80,	//55,
			sortable: true
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Surgery' + '</div>',
			dataIndex: 'avg_jum_cust_surgery',
			width: 80,	//55,
			sortable: true
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Anti Aging' + '</div>',
			dataIndex: 'avg_jum_cust_antiaging',
			width: 80,	//55,
			sortable: true
		},
		{	
			align : 'Right',
			header: '<div align="center">' + 'Non Medis' + '</div>',
			dataIndex: 'avg_jum_cust_nonmedis',
			width: 80,	//55,
			sortable: true
		},
		
		{	
			align : 'Right',
			header: '<div align="center">' + 'Produk' + '</div>',
			dataIndex: 'avg_jum_cust_produk',
			width: 80,	//55,
			sortable: true
		},
		
		{	
			align : 'Right',
			header: '<div align="center">' + 'Average' + '</div>',
			dataIndex: 'avg_jum_total',
			width: 80,	//55,
			sortable: true
		},
		]);
	
	lap_averageColumnModel.defaultSortable= true;
	*/
	
	
	/* End of Function */

	/* Declare DataStore and  show datagrid list */
	summary_reportListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'summary_reportListEditorGrid',
		el: 'fp_lap_kunjungan',
		title: 'Summary Report',
		autoHeight: true,
		store: summary_reportDataStore, // DataStore
		cm: lap_kunjunganColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		//clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 970, //940,//1200,	//970,
		/*
		bbar: new Ext.PagingToolbar({
			//pageSize: pageS,
			disabled:true,
			store: summary_reportDataStore,
			displayInfo: true
		}),
		*/
		/* Add Control on ToolBar */
		tbar: [
		{
			text: 'Input Periode',
			tooltip: 'Tombol untuk memasukkan periode Summary Report',
			//iconCls:'icon-search',
			handler: display_form_search_window 
		}, '-', 
			{
			text: 'Generate Summary Report',
			tooltip: 'Tombol untuk menampilkan Summary Report',
			//iconCls:'icon-xls',
			//disabled : true,
			handler: display_form_generate
		}, '-', 
			{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			disabled : true,
			handler: lap_lunjungan_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Summary Report',
			iconCls:'icon-print',
			disabled : false,
			handler: summary_report_print  
		}
		]
	});
	summary_reportListEditorGrid.render();
	/* End of DataStore */
	
	/*
	lap_kunjunganListEditorGrid2 =  new Ext.grid.EditorGridPanel({
		id: 'lap_kunjunganListEditorGrid2',
		el: 'fp_lap_kunjungan2',
		title: '',
		autoHeight: true,
		store: lap_totalkunjungan_DataStore, // DataStore
		cm: lap_totalkunjungan_nonColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		//clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 600,
	
		/* Add Control on ToolBar */
	/*
	});
	lap_kunjunganListEditorGrid2.render();
	/*
	
	lap_kunjungan_averageListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'lap_kunjungan_averageListEditorGrid',
		el: 'fp_lap_kunjungan_average',
		title: '',
		autoHeight: true,
		store: lap_average_kunjungan_DataStore, // DataStore
		cm: lap_averageColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		//clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 600, 

	});
	lap_kunjungan_averageListEditorGrid.render();
	
	
	/* Create Context Menu */
	summary_reportContextMenu = new Ext.menu.Menu({
		id: '',
		items: [
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: summary_report_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			handler: lap_lunjungan_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onlap_kunjungan_ListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		summary_reportContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		lap_kunjunganSelectedRow=rowIndex;
		summary_reportContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
		
	summary_reportListEditorGrid.addListener('rowcontextmenu', onlap_kunjungan_ListEditGridContextMenu);
	summary_reportDataStore.load({params: {start: 0, limit: 31}});
	//lap_totalkunjungan_DataStore.load({params: {start: 0, limit: 31}});	// load DataStore
	//lap_average_kunjungan_DataStore.load({params: {start: 0, limit: 31}});	// load DataStore
	//summary_reportListEditorGrid.on('afteredit', tindakan_medis_update); // inLine Editing Record
	
	/*Detail Declaration */	
	/* Function for Retrieve DataStore of detail*/
	lap_kunjungan_detail_DataStore = new Ext.data.Store({
		id: 'lap_kunjungan_detail_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_summary_report&m=detail_tindakan_detail_list', 
			method: 'POST'
		}),
		//reader: report_tindakan_detail_reader,
		//baseParams:{master_id: lap_kunjungan_idField.getValue()},
		sortInfo:{field: 'dtrawat_id', direction: "ASC"}
	});
	/* End of Function */

	/* Function for action list search */
	function summary_report_search(){
		// render according to a SQL date format.
		
		if(is_summary_report_searchForm_valid())
		{
		var summary_report_bulantujuan_search=null;
		var summary_report_tahuntujuan_search=null;
		var summary_report_bulanpembanding1_search=null;
		var summary_report_tahunpembanding1_search=null;
		var summary_report_bulanpembanding2_search=null;
		var summary_report_tahunpembanding2_search=null;
		
		if(summary_report_bulantujuanField.getValue()!==null){summary_report_bulantujuan_search=summary_report_bulantujuanField.getValue();}
		if(summary_report_tahuntujuanField.getValue()!==null){summary_report_tahuntujuan_search=summary_report_tahuntujuanField.getValue();}
		if(summary_report_bulanpembanding1Field.getValue()!==null){summary_report_bulanpembanding1_search=summary_report_bulanpembanding1Field.getValue();}
		if(summary_report_tahunpembanding1Field.getValue()!==null){summary_report_tahunpembanding1_search=summary_report_tahunpembanding1Field.getValue();}
		if(summary_report_bulanpembanding2Field.getValue()!==null){summary_report_bulanpembanding2_search=summary_report_bulanpembanding2Field.getValue();}
		if(summary_report_tahunpembanding2Field.getValue()!==null){summary_report_tahunpembanding2_search=summary_report_tahunpembanding2Field.getValue();}

		// change the store parameters
		summary_reportDataStore.baseParams = {
			task: 'INPUT',
			//variable here
			summary_report_bulantujuan 		: summary_report_bulantujuan_search,
			summary_report_tahuntujuan		: summary_report_tahuntujuan_search,
			summary_report_bulanpembanding1	: summary_report_bulanpembanding1_search,
			summary_report_tahunpembanding1	: summary_report_tahunpembanding1_search,
			summary_report_bulanpembanding2	: summary_report_bulanpembanding2_search,
			summary_report_tahunpembanding2	: summary_report_tahunpembanding2_search,
		}
		/*
		lap_totalkunjungan_DataStore.baseParams = {
			task: 'SEARCH2',
			//variable here
			lap_kunjungan_id	:	lap_kunjungan_id_search, 
			trawat_tglapp_start	: 	lap_kunjungan_tgl_start_search,
			trawat_tglapp_end	: 	lap_kunjungan_tgl_end_search,
			lap_kunjungan_kelamin : lap_kunjungan_kelamin_search,
			lap_kunjungan_member : lap_kunjungan_member_search,
			lap_kunjungan_cust : lap_kunjungan_cust_search,
			lap_kunjungan_umurstart : lap_kunjungan_umurstart_search,
			lap_kunjungan_umurend : lap_kunjungan_umurend_search,
			lap_kunjungan_tgllahir	:	lap_kunjungan_tgllahir_search_date, 
			lap_kunjungan_tgllahirend	:	lap_kunjungan_tgllahir_search_dateEnd 
			//trawat_dokter	:	report_tindakan_dokter_search,
		};
		lap_average_kunjungan_DataStore.baseParams = {
			task: 'SEARCH3',
			//variable here
			lap_kunjungan_id	:	lap_kunjungan_id_search, 
			trawat_tglapp_start	: 	lap_kunjungan_tgl_start_search,
			trawat_tglapp_end	: 	lap_kunjungan_tgl_end_search,
			lap_kunjungan_kelamin : lap_kunjungan_kelamin_search,
			lap_kunjungan_member : lap_kunjungan_member_search,
			lap_kunjungan_cust : lap_kunjungan_cust_search,
			lap_kunjungan_umurstart : lap_kunjungan_umurstart_search,
			lap_kunjungan_umurend : lap_kunjungan_umurend_search,
			lap_kunjungan_tgllahir	:	lap_kunjungan_tgllahir_search_date, 
			lap_kunjungan_tgllahirend	:	lap_kunjungan_tgllahir_search_dateEnd 		
			//trawat_dokter	:	report_tindakan_dokter_search,
		};
		*/
		
		// Cause the datastore to do another query : 
		summary_reportDataStore.reload({params: {start: 0, limit: 31}});
		//lap_totalkunjungan_DataStore.reload({params: {start: 0, limit: 31}});
		//lap_average_kunjungan_DataStore.reload({params: {start: 0, limit: 31}});
		}
		else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Tanggal belum diisi',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
	
	/* Function for action list generate */
	function summary_report_generate(){
		// render according to a SQL date format.
		
		if(is_summary_report_generateForm_valid())
		{
		var summary_report_bulantujuan_Generate=null;
		var summary_report_tahuntujuan_Generate=null;
		var summary_report_bulanpembanding1_Generate=null;
		var summary_report_tahunpembanding1_Generate=null;
		var summary_report_bulanpembanding2_Generate=null;
		var summary_report_tahunpembanding2_Generate=null;
		
		if(summary_report_bulantujuanGenerateField.getValue()!==null){summary_report_bulantujuan_Generate=summary_report_bulantujuanGenerateField.getValue();}
		if(summary_report_tahuntujuanGenerateField.getValue()!==null){summary_report_tahuntujuan_Generate=summary_report_tahuntujuanGenerateField.getValue();}
		if(summary_report_bulanpembanding1GenerateField.getValue()!==null){summary_report_bulanpembanding1_Generate=summary_report_bulanpembanding1GenerateField.getValue();}
		if(summary_report_tahunpembanding1GenerateField.getValue()!==null){summary_report_tahunpembanding1_Generate=summary_report_tahunpembanding1GenerateField.getValue();}
		if(summary_report_bulanpembanding2GenerateField.getValue()!==null){summary_report_bulanpembanding2_Generate=summary_report_bulanpembanding2GenerateField.getValue();}
		if(summary_report_tahunpembanding2GenerateField.getValue()!==null){summary_report_tahunpembanding2_Generate=summary_report_tahunpembanding2GenerateField.getValue();}

		// change the store parameters
		summary_reportDataStore.baseParams = {
			task: 'SEARCH',
			//variable here
			summary_report_bulantujuan 		: summary_report_bulantujuan_Generate,
			summary_report_tahuntujuan		: summary_report_tahuntujuan_Generate,
			summary_report_bulanpembanding1	: summary_report_bulanpembanding1_Generate,
			summary_report_tahunpembanding1	: summary_report_tahunpembanding1_Generate,
			summary_report_bulanpembanding2	: summary_report_bulanpembanding2_Generate,
			summary_report_tahunpembanding2	: summary_report_tahunpembanding2_Generate,
		}
		
		// Cause the datastore to do another query : 
		summary_reportDataStore.reload({params: {start: 0, limit: 31}});
		//lap_totalkunjungan_DataStore.reload({params: {start: 0, limit: 31}});
		//lap_average_kunjungan_DataStore.reload({params: {start: 0, limit: 31}});
		}
		else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Tanggal belum diisi',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
		
	/* Field for search */
	/* Identify  lap_kunjungan_id Search Field */
	/*
	lap_kunjungan_idSearchField= new Ext.form.NumberField({
		id: 'lap_kunjungan_idSearchField',
		fieldLabel: 'Id',
		allowNegatife : false,
		blankText: '0',
		allowDecimals: false,
		anchor: '95%',
		maskRe: /([0-9]+)$/
	
	});
	*/

	var dt = new Date(); 
	
	// Field2 Input Data
	summary_report_bulantujuanField=new Ext.form.ComboBox({
		id:'summary_report_bulantujuanField',
		fieldLabel:'Bulan Tujuan',
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
	summary_report_tahuntujuanField=new Ext.form.ComboBox({
		id:'summary_report_tahuntujuanField',
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
	
	summary_report_bulanpembanding1Field=new Ext.form.ComboBox({
		id:'summary_report_bulanpembanding1Field',
		fieldLabel:'Bulan Pembanding 1',
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
	
	summary_report_tahunpembanding1Field=new Ext.form.ComboBox({
		id:'summary_report_tahunpembanding1Field',
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
	
	summary_report_bulanpembanding2Field=new Ext.form.ComboBox({
		id:'summary_report_bulanpembanding2Field',
		fieldLabel:'Bulan Pembanding 2',
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
	
	summary_report_tahunpembanding2Field=new Ext.form.ComboBox({
		id:'summary_report_tahunpembanding2Field',
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
	// End of Field2 Input Data
	
	// Field2 Generate Data
	summary_report_bulantujuanGenerateField=new Ext.form.ComboBox({
		id:'summary_report_bulantujuanGenerateField',
		fieldLabel:'Bulan Tujuan',
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
	summary_report_tahuntujuanGenerateField=new Ext.form.ComboBox({
		id:'summary_report_tahuntujuanGenerateField',
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
	
	summary_report_bulanpembanding1GenerateField=new Ext.form.ComboBox({
		id:'summary_report_bulanpembanding1GenerateField',
		fieldLabel:'Bulan Pembanding 1',
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
	
	summary_report_tahunpembanding1GenerateField=new Ext.form.ComboBox({
		id:'summary_report_tahunpembanding1GenerateField',
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
	
	summary_report_bulanpembanding2GenerateField=new Ext.form.ComboBox({
		id:'summary_report_bulanpembanding2GenerateField',
		fieldLabel:'Bulan Pembanding 2',
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
	
	summary_report_tahunpembanding2GenerateField=new Ext.form.ComboBox({
		id:'summary_report_tahunpembanding2GenerateField',
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
	// End of Field2 Generate Data
	
	// FieldSet Input Data
	summary_report_bulanSearchField=new Ext.form.FieldSet({
		id:'summary_report_bulanSearchField',
		title: 'Bulan Summary Report',
		layout: 'form',
		boduStyle: 'padding: 5px;',
		anchor: '100%',
		items:[{
				layout: 'column',
				border: false,
				items:[{
					   		layout: 'form',
							border: false,
							labelWidth: 90,
							bodyStyle:'padding:3px',
							items:[summary_report_bulantujuanField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[summary_report_tahuntujuanField]
					   }]
				},{
				layout: 'column',
				border: false,
				items:[{
					   		layout: 'form',
							border: false,
							labelWidth: 90,
							bodyStyle:'padding:3px',
							items:[summary_report_bulanpembanding1Field]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[summary_report_tahunpembanding1Field]
					   }]
				},{
				layout: 'column',
				border: false,
				items:[{
					   		layout: 'form',
							border: false,
							labelWidth: 90,
							bodyStyle:'padding:3px',
							items:[summary_report_bulanpembanding2Field]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[summary_report_tahunpembanding2Field]
					   }]
				}			   
			]
	});
	// End of FieldSet Input Data 
	
	// FieldSer Generate
	summary_report_bulanGenerateField=new Ext.form.FieldSet({
		id:'summary_report_bulanGenerateField',
		title: 'Bulan Summary Report',
		layout: 'form',
		boduStyle: 'padding: 5px;',
		anchor: '100%',
		items:[{
				layout: 'column',
				border: false,
				items:[{
					   		layout: 'form',
							border: false,
							labelWidth: 90,
							bodyStyle:'padding:3px',
							items:[summary_report_bulantujuanGenerateField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[summary_report_tahuntujuanGenerateField]
					   }]
				},{
				layout: 'column',
				border: false,
				items:[{
					   		layout: 'form',
							border: false,
							labelWidth: 90,
							bodyStyle:'padding:3px',
							items:[summary_report_bulanpembanding1GenerateField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[summary_report_tahunpembanding1GenerateField]
					   }]
				},{
				layout: 'column',
				border: false,
				items:[{
					   		layout: 'form',
							border: false,
							labelWidth: 90,
							bodyStyle:'padding:3px',
							items:[summary_report_bulanpembanding2GenerateField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[summary_report_tahunpembanding2GenerateField]
					   }]
				}			   
			]
	});
	
	
	/* Function for retrieve search Form Panel */
	summary_report_searchForm = new Ext.FormPanel({
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
				items: [
				        {
						layout:'column',
						border:false,
						items:[
				        {
							columnWidth:1,
							layout: 'form',
							border:false,
							defaultType: 'datefield',
							items: [summary_report_bulanSearchField]
							/*lap_kunjungan_kelaminSearchField,lap_kunjungan_memberSearchField,lap_kunjungan_custSearchField, lap_kunjungan_tanggal_opsiSearchField,lap_kunjungan_umur_groupSearch] 
							*/
						}]}
						] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Input',
				handler: summary_report_search
			},{
				text: 'Close',
				handler: function(){
					summary_report_searchWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
	
	/* Function for retrieve search Form Panel */
	summary_report_GenerateForm = new Ext.FormPanel({
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
				items: [
				        {
						layout:'column',
						border:false,
						items:[
				        {
							columnWidth:1,
							layout: 'form',
							border:false,
							defaultType: 'datefield',
							items: [summary_report_bulanGenerateField]
							/*lap_kunjungan_kelaminSearchField,lap_kunjungan_memberSearchField,lap_kunjungan_custSearchField, lap_kunjungan_tanggal_opsiSearchField,lap_kunjungan_umur_groupSearch] 
							*/
						}]}
						] 
			}
			]
		}]
		,
		buttons: [{
				text: 'Generate',
				handler: summary_report_generate
			},{
				text: 'Close',
				handler: function(){
					summary_report_GenerateWindow.hide();
				}
			}
		]
	});
    /* End of Function */ 
    
	function summary_report_reset_formSearch(){
		summary_report_bulantujuanField.reset();
		summary_report_bulantujuanField.setValue(null);
		summary_report_tahuntujuanField.reset();
		summary_report_tahuntujuanField.setValue(null);
		
		summary_report_bulanpembanding1Field.reset();
		summary_report_bulanpembanding1Field.setValue(null);
		summary_report_bulanpembanding1Field.reset();
		summary_report_bulanpembanding1Field.setValue(null);
		
		summary_report_bulanpembanding2Field.reset();
		summary_report_bulanpembanding2Field.setValue(null);
		summary_report_bulanpembanding2Field.reset();
		summary_report_bulanpembanding2Field.setValue(null);
	}
	
	function summary_report_reset_formGenerate(){
		summary_report_bulantujuanGenerateField.reset();
		summary_report_bulantujuanGenerateField.setValue(null);
		summary_report_tahuntujuanGenerateField.reset();
		summary_report_tahuntujuanGenerateField.setValue(null);
		
		summary_report_bulanpembanding1GenerateField.reset();
		summary_report_bulanpembanding1GenerateField.setValue(null);
		summary_report_bulanpembanding1GenerateField.reset();
		summary_report_bulanpembanding1GenerateField.setValue(null);
		
		summary_report_bulanpembanding2GenerateField.reset();
		summary_report_bulanpembanding2GenerateField.setValue(null);
		summary_report_bulanpembanding2GenerateField.reset();
		summary_report_bulanpembanding2GenerateField.setValue(null);
	}
	 
	/* Function for retrieve search Window Form, used for andvaced search */
	summary_report_searchWindow = new Ext.Window({
		title: 'Input Periode Summary Report',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_summary_report_search',
		items: summary_report_searchForm
	});
    /* End of Function */ 
	
	/* Function for retrieve Generate Summary Report */
	summary_report_GenerateWindow = new Ext.Window({
		title: 'Generate Summary Report',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_summary_report_generate',
		items: summary_report_GenerateForm
	});
    /* End of Function */
	 
  	/* Function for Displaying  Search Window Form */
	function display_form_search_window(){
		if(!summary_report_searchWindow.isVisible()){
			summary_report_reset_formSearch();
			summary_report_bulantujuanField.setValue(thismonth);
			summary_report_tahuntujuanField.setValue(thisyear);
			summary_report_bulanpembanding1Field.setValue(bulanlalu);
			summary_report_tahunpembanding1Field.setValue(thisyear);
			summary_report_bulanpembanding2Field.setValue(thismonth);
			summary_report_tahunpembanding2Field.setValue(tahunlalu);
			summary_report_searchWindow.show();
		} else {
			summary_report_searchWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for Displaying  Search Window Form */
	function display_form_generate(){
		if(!summary_report_GenerateWindow.isVisible()){
			summary_report_reset_formGenerate();
			summary_report_bulantujuanGenerateField.setValue(thismonth);
			summary_report_tahuntujuanGenerateField.setValue(thisyear);
			summary_report_bulanpembanding1GenerateField.setValue(bulanlalu);
			summary_report_tahunpembanding1GenerateField.setValue(thisyear);
			summary_report_bulanpembanding2GenerateField.setValue(thismonth);
			summary_report_tahunpembanding2GenerateField.setValue(tahunlalu);
			summary_report_GenerateWindow.show();
		} else {
			summary_report_GenerateWindow.toFront();
		}
	}
  	/* End Function */
	
	/* Function for print List Grid */
	function summary_report_print(){
		var searchquery = "";
		var summary_report_bulantujuan_print=null;
		var summary_report_tahuntujuan_print=null;
		var summary_report_bulanpembanding1_print=null;
		var summary_report_tahunpembanding1_print=null;
		var summary_report_bulanpembanding2_print=null;
		var summary_report_tahunpembanding2_print=null;
		var win;              
		// check if we do have some search data...

		if(summary_reportDataStore.baseParams.query!==null){searchquery = summary_reportDataStore.baseParams.query;}
		if(summary_reportDataStore.baseParams.summary_report_bulantujuan!==null){summary_report_bulantujuan_print = summary_reportDataStore.baseParams.summary_report_bulantujuan;}
		if(summary_reportDataStore.baseParams.summary_report_tahuntujuan!==null){summary_report_tahuntujuan_print = summary_reportDataStore.baseParams.summary_report_tahuntujuan;}
		if(summary_reportDataStore.baseParams.summary_report_bulanpembanding1!==null){summary_report_bulanpembanding1_print = summary_reportDataStore.baseParams.summary_report_bulanpembanding1;}
		if(summary_reportDataStore.baseParams.summary_report_tahunpembanding1!==null){summary_report_tahunpembanding1_print = summary_reportDataStore.baseParams.summary_report_tahunpembanding1;}
		if(summary_reportDataStore.baseParams.summary_report_bulanpembanding2!==null){summary_report_bulanpembanding2_print = summary_reportDataStore.baseParams.summary_report_bulanpembanding2;}
		if(summary_reportDataStore.baseParams.summary_report_tahunpembanding2!==null){summary_report_tahunpembanding2_print = summary_reportDataStore.baseParams.summary_report_tahunpembanding2;}
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_summary_report&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			summary_report_bulantujuan 		: summary_report_bulantujuan_print,
			summary_report_tahuntujuan		: summary_report_tahuntujuan_print,
			summary_report_bulanpembanding1	: summary_report_bulanpembanding1_print,
			summary_report_tahunpembanding1	: summary_report_tahunpembanding1_print,
			summary_report_bulanpembanding2	: summary_report_bulanpembanding2_print,
			summary_report_tahunpembanding2	: summary_report_tahunpembanding2_print,
		  	currentlisting: summary_reportDataStore.baseParams.task // this tells us if we are searching or not
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
	function lap_lunjungan_export_excel(){
		//var searchquery = "";
		//var tindakan_dokter_2excel=null;
		//var win;              
		// check if we do have some search data...
		//if(summary_reportDataStore.baseParams.query!==null){searchquery = summary_reportDataStore.baseParams.query;}
		//if(summary_reportDataStore.baseParams.trawat_dokter!==null){tindakan_dokter_2excel = summary_reportDataStore.baseParams.trawat_dokter;}
		summary_reportDataStore.reload({params: {start: 0, limit: 31}});
		
		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_summary_report&m=get_action',
		params: {
			task: "GENERATE",
		  	//query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			trawat_dokter : tindakan_dokter_2excel,
		  	currentlisting: summary_reportDataStore.baseParams.task // this tells us if we are searching or not
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
        <div id="fp_lap_kunjungan"></div>
		 <div id="fp_lap_kunjungan2"></div>
		 <div id="fp_lap_kunjungan_average"></div>
         <div id="fp_lap_kunjungan_detail"></div>
		 <div id="fp_dlap_kunjungan"></div>
		<div id="elwindow_lap_kunjungan_create"></div>
        <div id="elwindow_summary_report_search"></div>
		<div id="elwindow_summary_report_generate"></div>
    </div>
</div>
</body>