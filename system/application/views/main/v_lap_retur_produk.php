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
</head>
<script>

var rpt_rprodukukWindow;
var rpt_rprodukForm;

/* declare variable here */
var rpt_rproduk_tglawalField;
var rpt_rproduk_tglakhirField;
var rpt_rproduk_rekapField;
var rpt_rproduk_detailField;
var rpt_rproduk_bulanField;
var rpt_rproduk_tahunField;
var rpt_rproduk_opsitglField;
var rpt_rproduk_opsiblnField;
var rpt_rproduk_opsiallField;

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
			data:[['No Faktur'],['No Faktur Jual'],['Tanggal'],['Customer']]
	});
	
	var group_detail_Store= new Ext.data.SimpleStore({
			id: 'group_detail_Store',
			fields:['group'],
			data:[['No Faktur'],['No Faktur Jual'],['Tanggal'],['Customer'],['Produk']]
	});
	
	var rpt_rproduk_groupField=new Ext.form.ComboBox({
		id:'rpt_rproduk_groupField',
		fieldLabel:'Kelompokkan',
		store: group_master_Store,
		mode: 'local',
		displayField: 'group',
		valueField: 'group',
		value: 'No Faktur',
		width: 150,
		triggerAction: 'all',
		typeAhead: true,
		lazyRender: true
	});
	
	rpt_rproduk_bulanField=new Ext.form.ComboBox({
		id:'rpt_rproduk_bulanField',
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
	
	rpt_rproduk_tahunField=new Ext.form.ComboBox({
		id:'rpt_rproduk_tahunField',
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
	
	rpt_rproduk_opsitglField=new Ext.form.Radio({
		id:'rpt_rproduk_opsitglField',
		boxLabel:'Tanggal',
		width:100,
		name: 'filter_opsi',
		checked: true
	});
	
	rpt_rproduk_opsiblnField=new Ext.form.Radio({
		id:'rpt_rproduk_opsiblnField',
		boxLabel:'Bulan',
		width:100,
		name: 'filter_opsi'
	});
	
	rpt_rproduk_opsiallField=new Ext.form.Radio({
		id:'rpt_rproduk_opsiallField',
		boxLabel:'Semua',
		name: 'filter_opsi'
	});
	
	rpt_rproduk_tglawalField= new Ext.form.DateField({
		id: 'rpt_rproduk_tglawalField',
		fieldLabel: ' ',
		format : 'Y-m-d',
		name: 'rpt_rproduk_tglawalField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
		value: today
        //endDateField: 'rpt_rproduk_tglakhirField'
	});
	
	rpt_rproduk_tglakhirField= new Ext.form.DateField({
		id: 'rpt_rproduk_tglakhirField',
		fieldLabel: 's/d',
		format : 'Y-m-d',
		name: 'rpt_rproduk_tglakhirField',
       // vtype: 'daterange',
		allowBlank: true,
		width: 100,
        //startDateField: 'rpt_rproduk_tglawalField',
		value: today
	});
	
	rpt_rproduk_rekapField=new Ext.form.Radio({
		id: 'rpt_rproduk_rekapField',
		boxLabel: 'Rekap',
		name: 'rproduk_opsi',
		checked: true
	});
	
	rpt_rproduk_detailField=new Ext.form.Radio({
		id: 'rpt_rproduk_detailField',
		boxLabel: 'Detail',
		name: 'rproduk_opsi'
	});
	
	var rpt_rproduk_periodeField=new Ext.form.FieldSet({
		id:'rpt_rproduk_periodeField',
		title : 'Periode',
		layout: 'form',
		bodyStyle:'padding: 0px 0px 0',
		frame: false,
		bolder: false,
		anchor: '98%',
		items:[/*{
				layout: 'column',
				border: false,
				items:[rpt_rproduk_opsiallField]
			},*/{
				layout: 'column',
				border: false,
				items:[rpt_rproduk_opsitglField, {
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[rpt_rproduk_tglawalField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[rpt_rproduk_tglakhirField]
					   }]
			},{
				layout: 'column',
				border: false,
				items:[rpt_rproduk_opsiblnField,{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[rpt_rproduk_bulanField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[rpt_rproduk_tahunField]
					   }]
			}]
	});
	
	var	rpt_rproduk_opsiField=new Ext.form.FieldSet({
		id: 'rpt_rproduk_opsiField',
		title: 'Opsi',
		border: true,
		anchor: '98%',
		items: [rpt_rproduk_rekapField ,rpt_rproduk_detailField]
	});
	
	var	rpt_rproduk_groupbyField=new Ext.form.FieldSet({
		id: 'rpt_rproduk_groupbyField',
		title: 'Group By',
		border: true,
		anchor: '98%',
		items: [rpt_rproduk_groupField]
	});
	
	function is_valid_form(){
		if(rpt_rproduk_opsitglField.getValue()==true){
			rpt_rproduk_tglawalField.allowBlank=false;
			rpt_rproduk_tglakhirField.allowBlank=false;
			if(rpt_rproduk_tglawalField.isValid() && rpt_rproduk_tglakhirField.isValid())
				return true;
			else
				return false;
		}else{
			rpt_rproduk_tglawalField.allowBlank=true;
			rpt_rproduk_tglakhirField.allowBlank=true;
			return true;
		}
	}
	
	/* Function for print List Grid */
	function print_rpt_rproduk(){
		
		var rproduk_tglawal="";
		var rproduk_tglakhir="";
		var jrpdouk_opsi="";
		var rproduk_bulan="";
		var rproduk_tahun="";
		var rproduk_periode="";
		var rproduk_group="";
		
		var win;               
		if(is_valid_form()){
			
		if(rpt_rproduk_tglawalField.getValue()!==""){rproduk_tglawal = rpt_rproduk_tglawalField.getValue().format('Y-m-d');}
		if(rpt_rproduk_tglakhirField.getValue()!==""){rproduk_tglakhir = rpt_rproduk_tglakhirField.getValue().format('Y-m-d');}
		if(rpt_rproduk_bulanField.getValue()!==""){rproduk_bulan=rpt_rproduk_bulanField.getValue(); }
		if(rpt_rproduk_tahunField.getValue()!==""){rproduk_tahun=rpt_rproduk_tahunField.getValue(); }
		if(rpt_rproduk_opsitglField.getValue()==true){
			rproduk_periode='tanggal';
		}else if(rpt_rproduk_opsiblnField.getValue()==true){
			rproduk_periode='bulan';
		}else{
			rproduk_periode='all';
		}
		
		if(rpt_rproduk_groupField.getValue()!==""){rproduk_group=rpt_rproduk_groupField.getValue(); }
		if(rpt_rproduk_rekapField.getValue()==true){rproduk_opsi='rekap';}else{rproduk_opsi='detail';}
		
			Ext.Ajax.request({   
				waitMsg: 'Please Wait...',
				url: 'index.php?c=c_master_retur_jual_produk&m=print_laporan',
				params: {
					tgl_awal	: rproduk_tglawal,
					tgl_akhir	: rproduk_tglakhir,
					opsi		: rproduk_opsi,
					bulan		: rproduk_bulan,
					tahun		: rproduk_tahun,
					periode		: rproduk_periode,
					group		: rproduk_group
				}, 
				success: function(response){              
					var result=eval(response.responseText);
					switch(result){
					case 1:
						win = window.open('./print/report_rproduk.html','report_rproduk','height=400,width=800,resizable=1,scrollbars=1, menubar=1');
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
		width: 400, 
		autoHeight: true,
		items: [rpt_rproduk_periodeField,rpt_rproduk_opsiField, rpt_rproduk_groupbyField],
		monitorValid:true,
		buttons: [{
				text: 'Print',
				formBind: true,
				handler: print_rpt_rproduk
			},{
				text: 'Close',
				handler: function(){
					rpt_rprodukWindow.hide();
					mainPanel.remove(mainPanel.getActiveTab().getId());
				}
		}]
		
	});
	
	/* Form Advanced Search */
	rpt_rprodukWindow = new Ext.Window({
		title: 'Laporan Retur Penjualan Produk',
		closable:false,
		closeAction: 'hide',
		resizable: false,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_rpt_rproduk',
		items: rpt_jrpdukForm
	});
  	rpt_rprodukWindow.show();
	
	//EVENTS
	/*rpt_rproduk_opsitglField.on("check",function(){
		if(rpt_rproduk_opsitglField.getValue()==true){
			rpt_rproduk_tglawalField.allowBlank=false;
			rpt_rproduk_tglakhirField.allowBlank=false;
		}else{
			rpt_rproduk_tglawalField.allowBlank=true;
			rpt_rproduk_tglakhirField.allowBlank=true;
		}
	});
	*/
	
	//EVENTS
	
	rpt_rproduk_rekapField.on("check", function(){
		rpt_rproduk_groupField.setValue('No faktur');
		if(rpt_rproduk_rekapField.getValue()==true){
			rpt_rproduk_groupField.bindStore(group_master_Store);
		}else
		{
			rpt_rproduk_groupField.bindStore(group_detail_Store);
		}
	});
	
	rpt_rproduk_detailField.on("check", function(){
		rpt_rproduk_groupField.setValue('No Faktur');
		if(rpt_rproduk_detailField.getValue()==true){
			rpt_rproduk_groupField.bindStore(group_detail_Store);
		}else
		{
			rpt_rproduk_groupField.bindStore(group_master_Store);
		}
	});
	
	rpt_rproduk_opsitglField.on("check",function(){
		if(rpt_rproduk_opsitglField.getValue()==true){
			rpt_rproduk_tglawalField.allowBlank=false;
			rpt_rproduk_tglakhirField.allowBlank=false;
		}else{
			rpt_rproduk_tglawalField.allowBlank=true;
			rpt_rproduk_tglakhirField.allowBlank=true;
		}
		
	});
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_info"></div>
		<div id="elwindow_rpt_rproduk"></div>
    </div>
</div>
</body>