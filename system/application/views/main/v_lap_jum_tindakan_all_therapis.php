<?
/* 
	+ Module  		: Laporan Tindakan Dokter View
	+ Description	: For record view
	+ Filename 		: v_lap_jum_tindakan_all_therapis.php
 	+ Author  		: Isaac
	
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
var report_tindakan_all_therapisDataStore;
var report_tindakan_all_therapisColumnModel;
var report_tindakan_all_therapisListEditorGrid;
var report_tindakan_all_therapissearchForm;
var report_tindakan_all_therapissearchWindow;
var report_tindakan_all_therapisSelectedRow;
var report_tindakan_all_therapisContextMenu;

var today=new Date().format('d-m-Y');
var yesterday=new Date().add(Date.DAY, -1).format('Y-m-d');
var thismonth=new Date().format('m');
var thisyear=new Date().format('Y');

//declare konstant
var post2db = '';
var msg = '';
var pageS_alldr=250;

/* declare variable here for Field*/
//var report_tindakan_idField;
var report_tindakan_all_therapis_groupbyField;

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


	Ext.util.Format.comboRenderer = function(combo){
		return function(value){
			var record = combo.findRecord(combo.valueField, value);
			return record ? record.get(combo.displayField) : combo.valueNotFoundText;
		}
	}
  
	/* Function for Retrieve DataStore */
	report_tindakan_all_therapisDataStore = new Ext.data.Store({
		id: 'report_tindakan_all_therapisDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_lap_jum_tindakan_all_therapis&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST",start:0,limit:pageS_alldr, trawat_dokter : 0}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'dtrawat_id'
		},[
		/* dataIndex => insert intoreport_tindakanColumnModel, Mapping => for initiate table column */ 
			{name: 'tindakan_perawatan', type: 'string', mapping: 'rawat_nama'},
			{name: 'rawat_kode', type: 'string', mapping: 'rawat_kode'},
			{name: 'tjtt_ref0', type: 'int', mapping: 'tjtt_ref0'},
			{name: 'tjtt_ref1', type: 'int', mapping: 'tjtt_ref1'},
			{name: 'tjtt_ref2', type: 'int', mapping: 'tjtt_ref2'},
			{name: 'tjtt_ref3', type: 'int', mapping: 'tjtt_ref3'},
			{name: 'tjtt_ref4', type: 'int', mapping: 'tjtt_ref4'},
			{name: 'tjtt_ref5', type: 'int', mapping: 'tjtt_ref5'},
			{name: 'tjtt_ref6', type: 'int', mapping: 'tjtt_ref6'},
			{name: 'tjtt_ref7', type: 'int', mapping: 'tjtt_ref7'},
			{name: 'tjtt_ref8', type: 'int', mapping: 'tjtt_ref8'},
			{name: 'tjtt_ref9', type: 'int', mapping: 'tjtt_ref9'},
			{name: 'tjtt_ref10', type: 'int', mapping: 'tjtt_ref10'},
			{name: 'tjtt_ref11', type: 'int', mapping: 'tjtt_ref11'},
			{name: 'tjtt_ref12', type: 'int', mapping: 'tjtt_ref12'},
			{name: 'tjtt_ref13', type: 'int', mapping: 'tjtt_ref13'},
			{name: 'tjtt_ref14', type: 'int', mapping: 'tjtt_ref14'},
			{name: 'tjtt_ref15', type: 'int', mapping: 'tjtt_ref15'},
			{name: 'tjtt_ref16', type: 'int', mapping: 'tjtt_ref16'},
			{name: 'tjtt_ref17', type: 'int', mapping: 'tjtt_ref17'},
			{name: 'tjtt_ref18', type: 'int', mapping: 'tjtt_ref18'},
			{name: 'tjtt_ref19', type: 'int', mapping: 'tjtt_ref19'},
			{name: 'tjtt_ref20', type: 'int', mapping: 'tjtt_ref20'},
			{name: 'tjtt_ref21', type: 'int', mapping: 'tjtt_ref21'},
			{name: 'tjtt_ref22', type: 'int', mapping: 'tjtt_ref22'}
			
		])
	});

	report_tindakan_alltotalDataStore = new Ext.data.Store({
		id: 'report_tindakan_alltotalDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_lap_jum_tindakan_all_therapis&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "TOTAL",start:0,limit:pageS_alldr, trawat_dokter : 0}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'dtrawat_id'
		},[
		/* dataIndex => insert intoreport_tindakanColumnModel, Mapping => for initiate table column */ 
			{name: 'tjtt_total_ref0', type: 'int', mapping: 'tjtt_total_ref0'},
			{name: 'tjtt_total_ref1', type: 'int', mapping: 'tjtt_total_ref1'},
			{name: 'tjtt_total_ref2', type: 'int', mapping: 'tjtt_total_ref2'},
			{name: 'tjtt_total_ref3', type: 'int', mapping: 'tjtt_total_ref3'},
			{name: 'tjtt_total_ref4', type: 'int', mapping: 'tjtt_total_ref4'},
			{name: 'tjtt_total_ref5', type: 'int', mapping: 'tjtt_total_ref5'},
			{name: 'tjtt_total_ref6', type: 'int', mapping: 'tjtt_total_ref6'},
			{name: 'tjtt_total_ref7', type: 'int', mapping: 'tjtt_total_ref7'},
			{name: 'tjtt_total_ref8', type: 'int', mapping: 'tjtt_total_ref8'},
			{name: 'tjtt_total_ref9', type: 'int', mapping: 'tjtt_total_ref9'},
			{name: 'tjtt_total_ref10', type: 'int', mapping: 'tjtt_total_ref10'},
			{name: 'tjtt_total_ref11', type: 'int', mapping: 'tjtt_total_ref11'},
			{name: 'tjtt_total_ref12', type: 'int', mapping: 'tjtt_total_ref12'},
			{name: 'tjtt_total_ref13', type: 'int', mapping: 'tjtt_total_ref13'},
			{name: 'tjtt_total_ref14', type: 'int', mapping: 'tjtt_total_ref14'},
			{name: 'tjtt_total_ref15', type: 'int', mapping: 'tjtt_total_ref15'},
			{name: 'tjtt_total_ref16', type: 'int', mapping: 'tjtt_total_ref16'},
			{name: 'tjtt_total_ref17', type: 'int', mapping: 'tjtt_total_ref17'},
			{name: 'tjtt_total_ref18', type: 'int', mapping: 'tjtt_total_ref18'},
			{name: 'tjtt_total_ref19', type: 'int', mapping: 'tjtt_total_ref19'},
			{name: 'tjtt_total_ref20', type: 'int', mapping: 'tjtt_total_ref20'},
			{name: 'tjtt_total_ref21', type: 'int', mapping: 'tjtt_total_ref21'},
			{name: 'tjtt_total_ref22', type: 'int', mapping: 'tjtt_total_ref22'},
		])	
	});
	
   
	/* Function for Identify of Window Column Model */
	report_tindakan_all_therapisColumnModel = new Ext.grid.ColumnModel(
		[
		{
			align : 'right',
			header: '<div align="center">' + 'No' + '</div>',
			renderer: function(v, p, r, rowIndex, i, ds){return '' + (rowIndex+1)},
			width: 20
		},{
			header: '<div align="center">' + 'Kode' + '</div>',
			dataIndex: 'rawat_kode',
			width: 100,//185,	//210,
			sortable: true,
		}, 
		{
			header: '<div align="center">' + 'Perawatan' + '</div>',
			dataIndex: 'tindakan_perawatan',
			width: 260,//185,	//210,
			sortable: true,
		}, 
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_ref0',
			width: 70,	//55,
			sortable: false
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_ref1',
			width: 70,	//55,
			sortable: false
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_ref2',
			width: 70,	//55,
			sortable: false
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_ref3',
			width: 70,	//55,
			sortable: false
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_ref4',
			width: 70,	//55,
			sortable: false
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_ref5',
			width: 70,	//55,
			sortable: false
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_ref6',
			width: 70,	//55,
			sortable: false
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_ref7',
			width: 70,	//55,
			sortable: false
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_ref8',
			width: 70,	//55,
			sortable: false
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_ref9',
			width: 70,	//55,
			sortable: false
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_ref10',
			width: 70,	//55,
			sortable: false
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_ref11',
			width: 70,	//55,
			sortable: false
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_ref12',
			width: 70,	//55,
			sortable: false
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_ref13',
			width: 70,	//55,
			sortable: false
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_ref14',
			width: 70,	//55,
			sortable: false
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_ref15',
			width: 70,	//55,
			sortable: false
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_ref16',
			width: 70,	//55,
			sortable: false
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_ref17',
			width: 70,	//55,
			sortable: false
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_ref18',
			width: 70,	//55,
			sortable: false
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_ref19',
			width: 70,	//55,
			sortable: false
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_ref20',
			width: 70,	//55,
			sortable: false
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_ref21',
			width: 70,	//55,
			sortable: false
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_ref22',
			width: 70,	//55,
			sortable: false
		}	
	]);
	
	report_tindakan_alltotalColumnModel = new Ext.grid.ColumnModel(
		[
		{
			align : 'right',
			header: '<div align="center">' + '' + '</div>',
			dataIndex: '',
			width: 20
		},{
			header: '<div align="center">' + '' + '</div>',
			dataIndex: '',
			width: 100,//185,	//210,
		}, 
		{
			header: '<div align="center">' + '<span style="font-weight:bold">TOTAL</span>' + '</div>',
			dataIndex: '',
			width: 260,//185,	//210,
		}, 
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_total_ref0',
			width: 70,	//55,
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_total_ref1',
			width: 70,	//55,
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_total_ref2',
			width: 70,	//55,
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_total_ref3',
			width: 70,	//55,
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_total_ref4',
			width: 70,	//55,
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_total_ref5',
			width: 70,	//55,
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_total_ref6',
			width: 70,	//55,
			sortable: false
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_total_ref7',
			width: 70,	//55,
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_total_ref8',
			width: 70,	//55,
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_total_ref9',
			width: 70,	//55,
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_total_ref10',
			width: 70,	//55,
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_total_ref11',
			width: 70,	//55,
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_total_ref12',
			width: 70,	//55,
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_total_ref13',
			width: 70,	//55,
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_total_ref14',
			width: 70,	//55,
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_total_ref15',
			width: 70,	//55,
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_total_ref16',
			width: 70,	//55,
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_total_ref17',
			width: 70,	//55,
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_total_ref18',
			width: 70,	//55,
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_total_ref19',
			width: 70,	//55,
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_total_ref20',
			width: 70,	//55,
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_total_ref21',
			width: 70,	//55,
		},
		{
			align : 'Right',
			header: '<div align="left">' + '' + '</div>',
			dataIndex: 'tjtt_total_ref22',
			width: 70,	//55,
		}
	]);
	
	report_tindakan_all_therapisColumnModel.defaultSortable= true;
	/* End of Function */

	report_tindakan_all_therapis_tbar_periodeField= new Ext.form.ComboBox({
		id: 'report_tindakan_all_therapis_tbar_periodeField',
		store:new Ext.data.SimpleStore({
			fields:['periode_value', 'periode_display'],
			data:[['Tanggal','Tanggal'],['Bulan','Bulan']]
		}),
		mode: 'local',
		displayField: 'periode_display',
		valueField: 'periode_value',
		listeners:{
			render: function(c){
			Ext.get(this.id).set({qtip:'Pilihan Periode'});
			}
		},
		editable:false,
		width: 76,
		triggerAction: 'all'	
	});

	report_tindakan_all_therapis_tglStartSearchField= new Ext.form.DateField({
		id: 'report_tindakan_all_therapis_tglStartSearchField',
		fieldLabel: ' ',
		format : 'd-m-Y',
		name: 'report_tindakan_all_therapis_tglStartSearchField',
        allowBlank: true,
		width: 100,
		emptyText: 'Tgl Awal'
        //value: today
	});
	
	report_tindakan_all_therapis_tglEndSearchField= new Ext.form.DateField({
		id: 'report_tindakan_all_therapis_tglEndSearchField',
		fieldLabel: ' ',
		format : 'd-m-Y',
		name: 'report_tindakan_all_therapis_tglEndSearchField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
		emptyText: 'Tgl Akhir'
        //value: today
	});
	
	report_tindakan_all_therapis_bulanField=new Ext.form.ComboBox({
		id:'report_tindakan_all_therapis_bulanField',
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
	
	report_tindakan_all_therapis_tahunField=new Ext.form.ComboBox({
		id:'report_tindakan_all_therapis_tahunField',
		fieldLabel:' ',
		store:new Ext.data.SimpleStore({
			fields:['tahun'],
			data: <?php echo $tahun; ?>
		}),
		mode: 'local',
		displayField: 'tahun',
		valueField: 'tahun',
		value: thisyear,
		width: 60,
		triggerAction: 'all'
	});

	cbo_report_tindakan_all_cabangDataStore = new Ext.data.Store({
		id: 'cbo_report_tindakan_all_cabangDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_lap_jum_tindakan_all_therapis&m=get_cabang_list', 
			method: 'POST'
		}),baseParams: {start: 0, limit: 15 },
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'
		},[
			{name: 'cabang_display', type: 'string', mapping: 'cabang_nama'},
			{name: 'cabang_value', type: 'string', mapping: 'cabang_kode'},
		]),
		sortInfo:{field: 'cabang_display', direction: "ASC"}
	});

	var report_tindakan_all_cabang_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span>{cabang_display}</span>',
        '</div></tpl>'
    );

	report_tindakan_all_therapis_cabangField= new Ext.form.ComboBox({
		id: 'report_tindakan_all_therapis_cabangField',
		fieldLabel: 'Cabang',
		store: cbo_report_tindakan_all_cabangDataStore,
		mode: 'remote',
		displayField:'cabang_display',
		valueField: 'cabang_value',
        typeAhead: false,
        loadingText: 'Searching...',
        //pageSize:10,
        hideTrigger:false,
        tpl: report_tindakan_all_cabang_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		allowBlank: true,
		disabled:false,
		anchor: '95%'
	});

	function report_tindakan_all_online_confirm(){
		Ext.MessageBox.confirm('Confirmation', 'Fitur Online hanya dapat diakses di MIS Thamrin dan mungkin akan membutuhkan waktu cukup lama. Anda yakin untuk melanjutkan?', report_tindakan_all_online_yes);
	}
	
	function report_tindakan_all_online_yes(btn){
		if(btn=='yes'){		
		}
		else {
			report_tindakan_all_therapis_onlineField.reset();
		}
	}
	
	report_tindakan_all_therapis_onlineField=new Ext.form.Checkbox({
		id : 'report_tindakan_all_therapis_onlineField',
		boxLabel: '',
		name: 'online',
		handler: function(node,checked){
			if (checked) {
				report_tindakan_all_online_confirm();
			}else{
				
			}
		}
	});

	report_tindakan_all_therapis_groupbyField= new Ext.form.ComboBox({
		id: 'report_tindakan_all_therapis_groupbyField',
		fieldLabel: '',
		store:new Ext.data.SimpleStore({
			fields:['group_value', 'group_display'],
			data:[['Perawatan','Perawatan Satuan'],['Pengambilan_Paket','Pengambilan Paket'],['Semua','Semua']]
		}),
		mode: 'local',
		editable:false,
		//emptyText: 'Semua',
		displayField: 'group_display',
		valueField: 'group_value',
		width: 120,
		triggerAction: 'all'	
	});

	report_tindakan_all_therapisListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'report_tindakan_all_therapisListEditorGrid',
		el: 'fp_report_tindakan_all_therapis',
		title: 'Laporan Jumlah Tindakan Aesthetic - Semua',
		autoHeight: false,
		height: 444,
		store: report_tindakan_all_therapisDataStore, // DataStore
		cm: report_tindakan_all_therapisColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		//clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1300, //940,//1200,	//970,
		bbar: new Ext.PagingToolbar({
			pageSize: pageS_alldr,
			disabled:false,
			store: report_tindakan_all_therapisDataStore,
			displayInfo: true
		}),
		/* Add Control on ToolBar */
		tbar: [
			'<b><font color=white>Periode : </b>', report_tindakan_all_therapis_tbar_periodeField, 
			'-', report_tindakan_all_therapis_tglStartSearchField, 
			'-', report_tindakan_all_therapis_tglEndSearchField,
			'-', report_tindakan_all_therapis_bulanField, 
			'-', report_tindakan_all_therapis_tahunField,
			'-', '<b><font color=white>Group by : </b>', report_tindakan_all_therapis_groupbyField,
			<?php if(eregi('H',$this->m_security->get_access_group_by_kode('MENU_LAPALLTR'))){ ?>	
				'-', report_tindakan_all_therapis_cabangField, 
				'-', report_tindakan_all_therapis_onlineField, '<b><font color=white>Online</b>',
			<?  } ?>			
			'-', 
		{
			text: 'Search',
			tooltip: 'Search',
			iconCls:'icon-search',
			handler: report_tindakan_all_therapis_search
		}, '-', 
			{
			text: 'Export Excel',
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			disabled: false,
			handler: report_tindakan_all_therapis_export_excel
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			disabled: false,
			handler: report_tindakan_all_therapis_print  
		}
		]
	});
	report_tindakan_all_therapisListEditorGrid.render();
	
	// inisialisasi awal
	report_tindakan_all_therapis_tbar_periodeField.setValue('Tanggal');
	report_tindakan_all_therapis_tglStartSearchField.setVisible(true);
	report_tindakan_all_therapis_tglEndSearchField.setVisible(true);
	report_tindakan_all_therapis_bulanField.setVisible(false);
	report_tindakan_all_therapis_tahunField.setVisible(false);			
	report_tindakan_all_therapis_cabangField.setValue('Miracle Thamrin');
	report_tindakan_all_therapis_groupbyField.setValue('Semua');
		
	function is_report_tindakan_therapis_searchform_valid(){
		if(report_tindakan_all_therapis_tbar_periodeField.getValue() == 'Tanggal'){
			report_tindakan_all_therapis_tglStartSearchField.allowBlank=false;
			report_tindakan_all_therapis_tglEndSearchField.allowBlank=false;
			if(report_tindakan_all_therapis_tglStartSearchField.isValid() && report_tindakan_all_therapis_tglEndSearchField.isValid())
				return true;
			else
				return false;
		}else{
			report_tindakan_all_therapis_tglStartSearchField.allowBlank=true;
			report_tindakan_all_therapis_tglEndSearchField.allowBlank=true;
			return true;
		}
	}
			
	report_tindakan_all_therapis_tbar_periodeField.on('select', function(){
		if (report_tindakan_all_therapis_tbar_periodeField.getValue() == 'Tanggal'){
			report_tindakan_all_therapis_tglStartSearchField.setVisible(true);
			report_tindakan_all_therapis_tglEndSearchField.setVisible(true);
			report_tindakan_all_therapis_bulanField.setVisible(false);
			report_tindakan_all_therapis_tahunField.setVisible(false);			
		} else if (report_tindakan_all_therapis_tbar_periodeField.getValue() == 'Bulan'){
			report_tindakan_all_therapis_tglStartSearchField.setVisible(false);
			report_tindakan_all_therapis_tglEndSearchField.setVisible(false);
			report_tindakan_all_therapis_bulanField.setVisible(true);
			report_tindakan_all_therapis_tahunField.setVisible(true);			
		}
	});
	
		/* Declare DataStore and  show datagrid list */
	report_tindakan_alltotalListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'report_tindakan_alltotalListEditorGrid',
		el: 'fp_report_tindakan_all_therapis_total',
		title: '',
		autoHeight: true,
		store: report_tindakan_alltotalDataStore, // DataStore
		cm: report_tindakan_alltotalColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		//clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 1300, //940,//1200,	//970,
	});
	report_tindakan_alltotalListEditorGrid.render();
	
	
	/* Create Context Menu */
	report_tindakan_all_therapisContextMenu = new Ext.menu.Menu({
		id: '',
		items: [
		{ 
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: report_tindakan_all_therapis_print 
		},
		{ 
			text: 'Export Excel', 
			tooltip: 'Export to Excel(.xls) Document',
			iconCls:'icon-xls',
			disabled: true,
			handler: report_tindakan_all_therapis_export_excel 
		}
		]
	}); 
	/* End of Declaration */
	
	/* Event while selected row via context menu */
	function onreport_tindakan_all_therapisListEditGridContextMenu(grid, rowIndex, e) {
		e.stopEvent();
		var coords = e.getXY();
		report_tindakan_all_therapisContextMenu.rowRecord = grid.store.getAt(rowIndex);
		grid.selModel.selectRow(rowIndex);
		report_tindakan_all_therapisSelectedRow=rowIndex;
		report_tindakan_all_therapisContextMenu.showAt([coords[0], coords[1]]);
  	}
  	/* End of Function */
		
	report_tindakan_all_therapisListEditorGrid.addListener('rowcontextmenu', onreport_tindakan_all_therapisListEditGridContextMenu);
	//report_tindakan_all_therapisDataStore.load({params: {start: 0, limit: pageS_alldr}});	// load DataStore
	//report_tindakan_all_therapisListEditorGrid.on('afteredit', tindakan_medis_update); // inLine Editing Record
	
	var checkColumn = new Ext.grid.CheckColumn({
		header: 'Ambil Paket',
		dataIndex: 'dtrawat_ambil_paket',
		hidden: true,
		width: 75
	});
	
	function headerSettingLabel(daftarNamaTherapis){
	//alert('here');
	
		var i=3;
		daftarNamaTherapis.each(function(nama){
		//alert(nama.get("karyawan_nama"));
			report_tindakan_all_therapisColumnModel.setColumnHeader(i, '<div align="left">' + nama.get("karyawan_username") + '</div>');
			report_tindakan_all_therapisColumnModel.setHidden(i, false);
			report_tindakan_alltotalColumnModel.setColumnHeader(i, '<div align="left">' + nama.get("karyawan_username") + '</div>');
			report_tindakan_alltotalColumnModel.setHidden(i, false);
			i++;
		});
		
		for(i2=i;i2<=25;i2++){
			report_tindakan_all_therapisColumnModel.setHidden(i2, true);
			report_tindakan_alltotalColumnModel.setHidden(i2, true);
		}
		
		Ext.MessageBox.hide();
	}
	/* Function for action list search */
	function report_tindakan_all_therapis_search(){
		// render according to a SQL date format.
		if(is_report_tindakan_therapis_searchform_valid())
		{
		var report_tindakan_therapis_id_search=null;
		var report_tindakan_therapis_tgl_start_search=null;
		var report_tindakan_therapis_tgl_end_search=null;
		var report_tindakan_therapis_groupby_search=null;
		var report_tindakan_therapis_tmedis_bulan=null;
		var report_tindakan_therapis_tmedis_tahun=null;
		var report_tindakan_therapis_tmedis_periode=null;
		var cabang_conn	= '';

		if(report_tindakan_all_therapis_bulanField.getValue()!==null){report_tindakan_therapis_tmedis_bulan=report_tindakan_all_therapis_bulanField.getValue();}
		if(report_tindakan_all_therapis_tahunField.getValue()!==null){report_tindakan_therapis_tmedis_tahun=report_tindakan_all_therapis_tahunField.getValue();}
		
		if(report_tindakan_all_therapis_tglStartSearchField.getValue()!==""){
			report_tindakan_therapis_tgl_start_search = report_tindakan_all_therapis_tglStartSearchField.getValue().format('Y-m-d');}
		if(report_tindakan_all_therapis_tglEndSearchField.getValue()!==""){
			report_tindakan_therapis_tgl_end_search = report_tindakan_all_therapis_tglEndSearchField.getValue().format('Y-m-d');}

		if(report_tindakan_all_therapis_groupbyField.getValue()!==null){report_tindakan_therapis_groupby_search=report_tindakan_all_therapis_groupbyField.getValue();}
		
		if(report_tindakan_all_therapis_cabangField.getValue()=='Miracle Thamrin') {cabang_conn = 'default';}
		else {
			cabang_conn=report_tindakan_all_therapis_cabangField.getValue(); 
			if (report_tindakan_all_therapis_onlineField.getValue() == true) {cabang_conn = cabang_conn + '2';}
		}
			
		if(report_tindakan_all_therapis_tbar_periodeField.getValue()=='Tanggal'){
			report_tindakan_therapis_tmedis_periode='tanggal';
		}else if(report_tindakan_all_therapis_tbar_periodeField.getValue()=='Bulan'){
			report_tindakan_therapis_tmedis_periode='bulan';
		}else{
			report_tindakan_therapis_tmedis_periode='all';
		}
				
		// change the store parameters
		
		report_tindakan_all_therapisDataStore.baseParams = {
			task: 'SEARCH',
			//variable here
			trawat_tglapp_start		: report_tindakan_therapis_tgl_start_search,
			trawat_tglapp_end		: report_tindakan_therapis_tgl_end_search,
			report_groupby			: report_tindakan_therapis_groupby_search,
			bulan					: report_tindakan_therapis_tmedis_bulan,
			tahun					: report_tindakan_therapis_tmedis_tahun,
			periode					: report_tindakan_therapis_tmedis_periode,
			cabang					: cabang_conn
		};
		
		report_tindakan_alltotalDataStore.baseParams = {
			task: 'SEARCHTOTAL',
			//variable here
			trawat_tglapp_start		: report_tindakan_therapis_tgl_start_search,
			trawat_tglapp_end		: report_tindakan_therapis_tgl_end_search,
			report_groupby			: report_tindakan_therapis_groupby_search,
			bulan					: report_tindakan_therapis_tmedis_bulan,
			tahun					: report_tindakan_therapis_tmedis_tahun,
			periode					: report_tindakan_therapis_tmedis_periode,
			cabang					: cabang_conn
		};
		
		Ext.MessageBox.show({
		   msg: 'Mohon tunggu...',
		   progressText: 'proses...',
		   width:350,
		   wait:true
		});
		
		report_tindakan_all_therapisDataStore.reload({
			params: {start: 0, limit: pageS_alldr},
			callback: function(opts, success, response){
				if(success){
					report_tindakan_alltotalDataStore.reload();
					//Ext.MessageBox.hide();
				}
			}
		});
			
		var daftarNamaTherapis = new Ext.data.JsonStore({
				url: 'index.php?c=c_lap_jum_tindakan_all_therapis&m=get_action',
				baseParams:{
					task: 'LIST_DOKTER',
					method: 'POST',
					//variable here
					report_tindakan_id	: report_tindakan_therapis_id_search, 
					trawat_tglapp_start	: report_tindakan_therapis_tgl_start_search,
					trawat_tglapp_end	: report_tindakan_therapis_tgl_end_search,
					report_groupby		: report_tindakan_therapis_groupby_search,
					bulan				: report_tindakan_therapis_tmedis_bulan,
					tahun				: report_tindakan_therapis_tmedis_tahun,
					periode				: report_tindakan_therapis_tmedis_periode,
					cabang		: cabang_conn,
					start:0,
					limit:pageS_alldr
				},
				root: 'results',
				fields: [
					{name: 'dokter_id', mapping: 'dokter_id'},
					{name: 'karyawan_nama', mapping:'karyawan_nama'},
					{name: 'karyawan_username', mapping:'karyawan_username'}
				],
				listeners: {
				load: headerSettingLabel
				}	
			});
			daftarNamaTherapis.load();
				
		}
		else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Form Anda belum lengkap.',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
			
	var dt = new Date(); 
	   	 
	/* Function for retrieve search Window Form, used for andvaced search */
	report_tindakan_all_therapissearchWindow = new Ext.Window({
		title: 'Pencarian Jumlah Tindakan Aesthetic - Semua',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_report_tindakan_all_therapis_search',
		items: report_tindakan_all_therapissearchForm
	});
    /* End of Function */ 
	
	function is_valid_form(){
		if(report_tindakan_all_therapis_tbar_periodeField.getValue()=='Tanggal'){
			report_tindakan_all_therapis_tglStartSearchField.allowBlank=false;
			report_tindakan_all_therapis_tglEndSearchField.allowBlank=false;
			if(report_tindakan_all_therapis_tglStartSearchField.isValid() && report_tindakan_all_therapis_tglEndSearchField.isValid())
				return true;
			else
				return false;
		}else{
			report_tindakan_all_therapis_tglStartSearchField.allowBlank=true;
			report_tindakan_all_therapis_tglEndSearchField.allowBlank=true;
			return true;
		}
	}

	/* Function for print List Grid */
	function report_tindakan_all_therapis_print(){
		var searchquery = "";
		var trawat_cust_print=null;
		var win;              
		var report_tindakan_id_print=null;
		var report_tindakan_tgl_start_print=null;
		var report_tindakan_tgl_end_print=null;
		var report_tindakan_groupby_print=null;
		var report_tindakan_therapis_tmedis_bulan=null;
		var report_tindakan_therapis_tmedis_tahun=null;
		var report_tindakan_therapis_tmedis_periode=null;
		var cabang_conn	= '';
		
		// check if we do have some search data...
		if(report_tindakan_all_therapisDataStore.baseParams.query!==null){searchquery = report_tindakan_all_therapisDataStore.baseParams.query;}
		if(report_tindakan_all_therapisDataStore.baseParams.trawat_cust!==null){trawat_cust_print = report_tindakan_all_therapisDataStore.baseParams.trawat_cust;}
		if(Ext.getCmp('report_tindakan_all_therapis_tglStartSearchField').getValue()!==null){report_tindakan_tgl_start_print=Ext.getCmp('report_tindakan_all_therapis_tglStartSearchField').getValue();}
		if(Ext.getCmp('report_tindakan_all_therapis_tglEndSearchField').getValue()!==null){report_tindakan_tgl_end_print=Ext.getCmp('report_tindakan_all_therapis_tglEndSearchField').getValue();}
		if(report_tindakan_all_therapis_groupbyField.getValue()!==null){report_tindakan_groupby_print=report_tindakan_all_therapis_groupbyField.getValue();}
		if(report_tindakan_all_therapis_bulanField.getValue()!==null){report_tindakan_therapis_tmedis_bulan=report_tindakan_all_therapis_bulanField.getValue();}
		if(report_tindakan_all_therapis_tahunField.getValue()!==null){report_tindakan_therapis_tmedis_tahun=report_tindakan_all_therapis_tahunField.getValue();}
		if(report_tindakan_all_therapis_cabangField.getValue()=='Miracle Thamrin') {cabang_conn = 'default';}
		else {
			cabang_conn=report_tindakan_all_therapis_cabangField.getValue(); 
			if (report_tindakan_all_therapis_onlineField.getValue() == true) {cabang_conn = cabang_conn + '2';}
		}
		if(report_tindakan_all_therapis_tbar_periodeField.getValue()=='Tanggal'){
			report_tindakan_therapis_tmedis_periode='tanggal';
		}else if(report_tindakan_all_therapis_tbar_periodeField.getValue()=='Bulan'){
			report_tindakan_therapis_tmedis_periode='bulan';
		}else{
			report_tindakan_therapis_tmedis_periode='all';
		}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_lap_jum_tindakan_all_therapis&m=get_action',
		params: {
			task: "PRINT",
		  	query: searchquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			report_tindakan_id	: report_tindakan_id_print,
			trawat_tglapp_start	: 	report_tindakan_tgl_start_print,
			trawat_tglapp_end	: 	report_tindakan_tgl_end_print,
			report_groupby	:	report_tindakan_groupby_print,
			bulan		: report_tindakan_therapis_tmedis_bulan,
			tahun		: report_tindakan_therapis_tmedis_tahun,
			periode		: report_tindakan_therapis_tmedis_periode,
			cabang		: cabang_conn,
		  	currentlisting: report_tindakan_all_therapisDataStore.baseParams.task // this tells us if we are searching or not
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./print/Laporan_JumAllTerapis.html','Laporan_JumAllTerapis','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
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
	function report_tindakan_all_therapis_export_excel(){
		var excelquery = "";
		var report_tindakan_id_excel=null;
		var report_tindakan_tgl_start_excel=null;
		var report_tindakan_tgl_end_excel=null;
		var report_tindakan_groupby_excel=null;
		var report_tindakan_therapis_tmedis_bulan=null;
		var report_tindakan_therapis_tmedis_tahun=null;
		var report_tindakan_therapis_tmedis_periode=null;
		var cabang_conn	= '';
		
		var win;              
		// check if we do have some search data...
		if(report_tindakan_all_therapisDataStore.baseParams.query!==null){excelquery = report_tindakan_all_therapisDataStore.baseParams.query;}
		if(Ext.getCmp('report_tindakan_all_therapis_tglStartSearchField').getValue()!==null){report_tindakan_tgl_start_excel=Ext.getCmp('report_tindakan_all_therapis_tglStartSearchField').getValue();}
		if(Ext.getCmp('report_tindakan_all_therapis_tglEndSearchField').getValue()!==null){report_tindakan_tgl_end_excel=Ext.getCmp('report_tindakan_all_therapis_tglEndSearchField').getValue();}
		if(report_tindakan_all_therapis_groupbyField.getValue()!==null){report_tindakan_groupby_excel=report_tindakan_all_therapis_groupbyField.getValue();}
		if(report_tindakan_all_therapis_bulanField.getValue()!==null){report_tindakan_therapis_tmedis_bulan=report_tindakan_all_therapis_bulanField.getValue();}
		if(report_tindakan_all_therapis_tahunField.getValue()!==null){report_tindakan_therapis_tmedis_tahun=report_tindakan_all_therapis_tahunField.getValue();}
		if(report_tindakan_all_therapis_cabangField.getValue()=='Miracle Thamrin') {cabang_conn = 'default';}
		else {
			cabang_conn=report_tindakan_all_therapis_cabangField.getValue(); 
			if (report_tindakan_all_therapis_onlineField.getValue() == true) {cabang_conn = cabang_conn + '2';}
		}
		if(report_tindakan_all_therapis_tbar_periodeField.getValue()=='Tanggal'){
			report_tindakan_therapis_tmedis_periode='tanggal';
		}else if(report_tindakan_all_therapis_tbar_periodeField.getValue()=='Bulan'){
			report_tindakan_therapis_tmedis_periode='bulan';
		}else{
			report_tindakan_therapis_tmedis_periode='all';
		}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_lap_jum_tindakan_all_therapis&m=get_action',
		params: {
			task: "EXCEL",
		  	query: excelquery,                    		// if we are doing a quicksearch, use this
			//if we are doing advanced search, use this
			report_tindakan_id	: report_tindakan_id_excel,
			trawat_tglapp_start	: 	report_tindakan_tgl_start_excel,
			trawat_tglapp_end	: 	report_tindakan_tgl_end_excel,
			report_groupby	:	report_tindakan_groupby_excel,
			bulan		: report_tindakan_therapis_tmedis_bulan,
			tahun		: report_tindakan_therapis_tmedis_tahun,
			periode		: report_tindakan_therapis_tmedis_periode,
			cabang		: cabang_conn,
			currentlisting: report_tindakan_all_therapisDataStore.baseParams.task // this tells us if we are searching or not
		},
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				//win = window.location=('./export2excel.php');
				//Ext.MessageBox.hide();
				win = window.open('./print/Laporan_JumAllTerapis.xls','lap_jum_tind_dokterlist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
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
	
	report_tindakan_all_therapis_tbar_periodeField.on("select",function(){
		if(report_tindakan_all_therapis_tbar_periodeField.getValue()=='Tanggal'){
			report_tindakan_all_therapis_tglStartSearchField.allowBlank=false;
			report_tindakan_all_therapis_tglEndSearchField.allowBlank=false;
		}else{
			report_tindakan_all_therapis_tglStartSearchField.allowBlank=true;
			report_tindakan_all_therapis_tglEndSearchField.allowBlank=true;
		}
		
	});
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_report_tindakan_all_therapis"></div>
        <div id="fp_report_tindakan_all_therapis_total"></div>
        <div id="elwindow_report_tindakan_all_therapis_search"></div>
    </div>
</div>
</body>