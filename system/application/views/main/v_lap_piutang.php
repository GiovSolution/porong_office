<?
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: info View
	+ Description	: For record view
	+ Filename 		: v_info.php
 	+ Author  		: zainal, mukhlison
 	+ Created on 14/Jul/2009 15:33:36
	
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

var rpt_jrpdukWindow;
var rpt_jrpdukForm;

var rpt_piutang_tglawalField;
var rpt_piutang_tglakhirField;
var rpt_piutang_rekapField;
var rpt_piutang_detailField;
var rpt_piutang_bulanField;
var rpt_piutang_tahunField;
var rpt_piutang_opsitglField;
var rpt_piutang_opsiblnField;
var rpt_piutang_opsiallField;
var rpt_piutang_groupField;

var today=new Date().format('Y-m-d');
var yesterday=new Date().add(Date.DAY, -1).format('Y-m-d');
var thismonth=new Date().format('m');
var thisyear=new Date().format('Y');
<?
$idForm=24;
?>

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
        return true;
    }
});
<?
$tahun="[";
for($i=(date('Y')-4);$i<=date('Y');$i++){
	$tahun.="['$i'],";
}
$tahun=substr($tahun,0,strlen($tahun)-1);
$tahun.="]";
$bulan="";
?>
Ext.onReady(function(){
  Ext.QuickTips.init();

	var group_master_Store= new Ext.data.SimpleStore({
			id: 'group_master_Store',
			fields:['group'],
			data:[['No Faktur'],['Tanggal'],['Customer']]
	});
	
	var group_detail_Store= new Ext.data.SimpleStore({
			id: 'group_detail_Store',
			fields:['group'],
			data:[['No Faktur'],['Tanggal'],['Customer']]
	});
	
	custDataStore = new Ext.data.Store({
		id: 'custDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_master_lunas_piutang&m=get_customer_list', 
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
	var customer_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{cust_no} : {cust_nama}</b><br /></span>',
        '</div></tpl>'
    );
	
	var rpt_piutang_groupField=new Ext.form.ComboBox({
		id:'rpt_piutang_groupField',
		fieldLabel:'Kelompokkan',
		store: group_master_Store,
		mode: 'local',
		displayField: 'group',
		valueField: 'group',
		value: 'No Faktur',
		width: 100,
		triggerAction: 'all',
		typeAhead: true,
		lazyRender: true
	});
	
	var rpt_piutang_custField=new Ext.form.ComboBox({
		id: 'rpt_piutang_custField',
		fieldLabel: 'Customer',
		store: custDataStore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
		forceSelection: true,
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: customer_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		anchor: '100%'
	});
	
	rpt_piutang_lunasField=new Ext.form.ComboBox({
		id:'rpt_piutang_lunasField',
		fieldLabel:'Pelunasan',
		store:new Ext.data.SimpleStore({
			fields:['value', 'display'],
			data:[['1','Lunas'],['0','Belum Lunas']]
		}),
		mode: 'local',
		displayField: 'display',
		valueField: 'value',
		value: 0,
		width: 100,
		triggerAction: 'all'
	});
	
	rpt_piutang_bulanField=new Ext.form.ComboBox({
		id:'rpt_piutang_bulanField',
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
	
	rpt_piutang_tahunField=new Ext.form.ComboBox({
		id:'rpt_piutang_tahunField',
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
	
	rpt_piutang_opsitglField=new Ext.form.Radio({
		id:'rpt_piutang_opsitglField',
		boxLabel:'Tanggal',
		width:100,
		name: 'filter_opsi',
		checked: true
	});
	
	rpt_piutang_opsiblnField=new Ext.form.Radio({
		id:'rpt_piutang_opsiblnField',
		boxLabel:'Bulan',
		width:100,
		name: 'filter_opsi'
	});
	
	rpt_piutang_opsiallField=new Ext.form.Radio({
		id:'rpt_piutang_opsiallField',
		boxLabel:'Semua',
		name: 'filter_opsi'
	});
	
	rpt_piutang_tglawalField= new Ext.form.DateField({
		id: 'rpt_piutang_tglawalField',
		fieldLabel: ' ',
		format : 'Y-m-d',
		name: 'rpt_piutang_tglawalField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
        //endDateField: 'rpt_piutang_tglakhirField'
		value: today
	});
	
	rpt_piutang_tglakhirField= new Ext.form.DateField({
		id: 'rpt_piutang_tglakhirField',
		fieldLabel: 's/d',
		format : 'Y-m-d',
		name: 'rpt_piutang_tglakhirField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
        //startDateField: 'rpt_piutang_tglawalField',
		value: today
	});
	
	rpt_piutang_rekapField=new Ext.form.Radio({
		id: 'rpt_piutang_rekapField',
		boxLabel: 'Rekap',
		name: 'piutang_opsi',
		checked: true
	});
	
	rpt_piutang_detailField=new Ext.form.Radio({
		id: 'rpt_piutang_detailField',
		boxLabel: 'Detail',
		name: 'piutang_opsi'
	});
	
	var rpt_piutang_periodeField=new Ext.form.FieldSet({
		id:'rpt_piutang_periodeField',
		title : 'Periode',
		layout: 'form',
		bodyStyle:'padding: 0px 0px 0',
		frame: false,
		bolder: false,
		anchor: '98%',
		items:[{
				layout: 'column',
				border: false,
				items:[rpt_piutang_opsiallField]
			},{
				layout: 'column',
				border: false,
				items:[rpt_piutang_opsitglField, {
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[rpt_piutang_tglawalField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[rpt_piutang_tglakhirField]
					   }]
			},{
				layout: 'column',
				border: false,
				items:[rpt_piutang_opsiblnField,{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[rpt_piutang_bulanField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[rpt_piutang_tahunField]
					   }]
			}]
	});
	
	var	rpt_piutang_opsiField=new Ext.form.FieldSet({
		id: 'rpt_piutang_opsiField',
		title: 'Opsi',
		border: true,
		anchor: '98%',
		items: [rpt_piutang_rekapField ,rpt_piutang_detailField]
	});
	
	var	rpt_piutang_groupbyField=new Ext.form.FieldSet({
		id: 'rpt_piutang_groupbyField',
		title: 'Group By',
		border: true,
		anchor: '98%',
		items: [rpt_piutang_groupField]
	});
	
	var	rpt_piutang_custbyField=new Ext.form.FieldSet({
		id: 'rpt_piutang_custbyField',
		title: 'Group By',
		border: true,
		anchor: '98%',
		items: [rpt_piutang_custField,rpt_piutang_lunasField]
	});
	
	function is_valid_form(){
		if(rpt_piutang_opsitglField.getValue()==true){
			rpt_piutang_tglawalField.allowBlank=false;
			rpt_piutang_tglakhirField.allowBlank=false;
			if(rpt_piutang_tglawalField.isValid() && rpt_piutang_tglakhirField.isValid())
				return true;
			else
				return false;
		}else{
			rpt_piutang_tglawalField.allowBlank=true;
			rpt_piutang_tglakhirField.allowBlank=true;
			return true;
		}
	}
	
	/* Function for print List Grid */
	function print_rpt_piutang(){
		
		var piutang_tglawal="";
		var piutang_tglakhir="";
		var piutang_bulan="";
		var piutang_tahun="";
		var piutang_periode="";
		//var piutang_group="";
		var piutang_customer="";
		var piutang_lunas="";
		
		var win;               
		if(is_valid_form()){
			
		if(rpt_piutang_tglawalField.getValue()!==""){piutang_tglawal = rpt_piutang_tglawalField.getValue().format('Y-m-d');}
		if(rpt_piutang_tglakhirField.getValue()!==""){piutang_tglakhir = rpt_piutang_tglakhirField.getValue().format('Y-m-d');}
		if(rpt_piutang_bulanField.getValue()!==""){piutang_bulan=rpt_piutang_bulanField.getValue(); }
		if(rpt_piutang_tahunField.getValue()!==""){piutang_tahun=rpt_piutang_tahunField.getValue(); }
		if(rpt_piutang_lunasField.getValue()!==""){piutang_lunas=rpt_piutang_lunasField.getValue();}
		if(rpt_piutang_opsitglField.getValue()==true){
			piutang_periode='tanggal';
		}else if(rpt_piutang_opsiblnField.getValue()==true){
			piutang_periode='bulan';
		}else{
			piutang_periode='all';
		}
		//if(rpt_piutang_groupField.getValue()!==""){piutang_group=rpt_piutang_groupField.getValue(); }
		if((/^\d+$/.test(rpt_piutang_custField.getValue())) && rpt_piutang_custField.getValue()!==""){piutang_customer=rpt_piutang_custField.getValue()}
		
		if(rpt_piutang_rekapField.getValue()==true){piutang_opsi='rekap';}else{piutang_opsi='detail';}
		
		Ext.MessageBox.show({
		   msg: 'Sedang memproses data, mohon tunggu...',
		   progressText: 'proses...',
		   width:350,
		   wait:true
		});
		
			Ext.Ajax.request({   
				waitMsg: 'Please Wait...',
				timeout: 3600000,
				url: 'index.php?c=c_master_lunas_piutang&m=print_laporan',
				params: {
					tgl_awal	: piutang_tglawal,
					tgl_akhir	: piutang_tglakhir,
					opsi		: piutang_opsi,
					bulan		: piutang_bulan,
					tahun		: piutang_tahun,
					periode		: piutang_periode,
					customer	: piutang_customer,
					lunas		: piutang_lunas
					//group		: piutang_group
					
				}, 
				success: function(response){              
					var result=eval(response.responseText);
					switch(result){
					case 1:
						Ext.MessageBox.hide(); 
						win = window.open('./print/report_piutang.html','report_piutang','height=400,width=800,resizable=1,scrollbars=1, menubar=1');
						//
						break;
					default:
						Ext.MessageBox.show({
							title: 'Warning',
							msg: 'Unable to print the report!',
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
		}else{
			Ext.MessageBox.show({
			   title: 'Warning',
			   msg: 'Not valid form.',
			   buttons: Ext.MessageBox.OK,
			   animEl: 'database',
			   icon: Ext.MessageBox.WARNING
			});	
		}
	}
	/* Enf Function */
	
	rpt_jrpdukForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		x:0,
		y:0,
		width: 500, 
		autoHeight: true,
		items: [rpt_piutang_periodeField,rpt_piutang_opsiField, rpt_piutang_custbyField],
		monitorValid:true,
		buttons: [{
				text: 'Print',
				formBind: true,
				handler: print_rpt_piutang
			},{
				text: 'Close',
				handler: function(){
					rpt_piutangWindow.hide();
					mainPanel.remove(mainPanel.getActiveTab().getId());
				}
		}]
		
	});
	
	/* Form Advanced Search */
	rpt_piutangWindow = new Ext.Window({
		title: 'Laporan Piutang Penjualan',
		closable:false,
		closeAction: 'hide',
		resizable: false,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_rpt_piutang',
		items: rpt_jrpdukForm
	});
  	rpt_piutangWindow.show();
	
	//EVENTS
	
	rpt_piutang_rekapField.on("check", function(){
		rpt_piutang_groupField.setValue('No faktur');
		if(rpt_piutang_rekapField.getValue()==true){
			rpt_piutang_groupField.bindStore(group_master_Store);
		}else
		{
			rpt_piutang_groupField.bindStore(group_detail_Store);
		}
	});
	
	rpt_piutang_detailField.on("check", function(){
		rpt_piutang_groupField.setValue('No Faktur');
		if(rpt_piutang_detailField.getValue()==true){
			rpt_piutang_groupField.bindStore(group_detail_Store);
		}else
		{
			rpt_piutang_groupField.bindStore(group_master_Store);
		}
	});
	
	rpt_piutang_opsitglField.on("check",function(){
		if(rpt_piutang_opsitglField.getValue()==true){
			rpt_piutang_tglawalField.allowBlank=false;
			rpt_piutang_tglakhirField.allowBlank=false;
		}else{
			rpt_piutang_tglawalField.allowBlank=true;
			rpt_piutang_tglakhirField.allowBlank=true;
		}
		
	});
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_info"></div>
		<div id="elwindow_rpt_piutang"></div>
    </div>
</div>
</body>