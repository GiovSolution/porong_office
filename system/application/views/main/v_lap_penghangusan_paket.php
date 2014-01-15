<?
/* 	
	Miracle IT Team
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

//var rpt_jrpdukWindow;
var rpt_ppaketForm;

/* declare variable here */
var rpt_ppaket_tglawalField;
var rpt_ppaket_tglakhirField;
var rpt_ppaket_rekapField;
var rpt_ppaket_detailField;
var rpt_ppaket_semuaField;
var rpt_ppaket_tertutupField;
var rpt_ppaket_bulanField;
var rpt_ppaket_tahunField;
var rpt_ppaket_opsitglField;
var rpt_ppaket_opsiblnField;
var rpt_ppaket_opsiallField;

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
			data:[['Paket'],['Tanggal'],['Customer']]
	});
	
	var group_detail_Store= new Ext.data.SimpleStore({
			id: 'group_detail_Store',
			fields:['group'],
			data:[['Paket'],['Tanggal'],['Customer'],['Paket'],['Sales'],['Jenis Diskon']]
	});
	
	var rpt_ppaket_groupField=new Ext.form.ComboBox({
		id:'rpt_ppaket_groupField',
		fieldLabel:'Kelompokkan',
		store: group_master_Store,
		mode: 'local',
		displayField: 'group',
		valueField: 'group',
		value: 'Tanggal',
		width: 100,
		triggerAction: 'all',
		typeAhead: true,
		lazyRender: true
	});
	
	rpt_ppaket_bulanField=new Ext.form.ComboBox({
		id:'rpt_ppaket_bulanField',
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
	
	rpt_ppaket_tahunField=new Ext.form.ComboBox({
		id:'rpt_ppaket_tahunField',
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
	
	rpt_ppaket_opsitglField=new Ext.form.Radio({
		id:'rpt_ppaket_opsitglField',
		boxLabel:'Tanggal',
		width:100,
		name: 'filter_opsi',
		checked: true
	});
	
	rpt_ppaket_opsiblnField=new Ext.form.Radio({
		id:'rpt_ppaket_opsiblnField',
		boxLabel:'Bulan',
		width:100,
		name: 'filter_opsi'
	});
	
	rpt_ppaket_opsiallField=new Ext.form.Radio({
		id:'rpt_ppaket_opsiallField',
		boxLabel:'Semua',
		name: 'filter_opsi'
	});
	
	rpt_ppaket_tglawalField= new Ext.form.DateField({
		id: 'rpt_ppaket_tglawalField',
		fieldLabel: ' ',
		format : 'Y-m-d',
		name: 'rpt_ppaket_tglawalField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
       // endDateField: 'rpt_ppaket_tglakhirField'
	    value: today
	});
	
	rpt_ppaket_tglakhirField= new Ext.form.DateField({
		id: 'rpt_ppaket_tglakhirField',
		fieldLabel: 's/d',
		format : 'Y-m-d',
		name: 'rpt_ppaket_tglakhirField',
       // vtype: 'daterange',
		allowBlank: true,
		width: 100,
        //startDateField: 'rpt_ppaket_tglawalField',
		value: today
	});
	
	rpt_ppaket_rekapField=new Ext.form.Radio({
		id: 'rpt_ppaket_rekapField',
		boxLabel: 'Rekap',
		name: 'ppaket_opsi',
		checked: true
	});
	
	rpt_ppaket_detailField=new Ext.form.Radio({
		id: 'rpt_ppaket_detailField',
		boxLabel: 'Detail',
		name: 'ppaket_opsi'
	});
	
	// opsi status
	rpt_ppaket_semuaField=new Ext.form.Radio({
		id: 'rpt_ppaket_semuaField',
		boxLabel: 'Semua',
		name: 'ppaket_opsi_status',
		checked: false
	});
	
	rpt_ppaket_tertutupField=new Ext.form.Radio({
		id: 'rpt_ppaket_tertutupField',
		boxLabel: 'Tertutup',
		name: 'ppaket_opsi_status',
		checked: true
	});
	// eof opsi status
	
	
	var rpt_ppaket_periodeField=new Ext.form.FieldSet({
		id:'rpt_ppaket_periodeField',
		title : 'Periode',
		layout: 'form',
		bodyStyle:'padding: 0px 0px 0',
		frame: false,
		bolder: false,
		anchor: '98%',
		items:[/*{
				layout: 'column',
				border: false,
				items:[rpt_ppaket_opsiallField]
			},*/{
				layout: 'column',
				border: false,
				items:[rpt_ppaket_opsitglField, {
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[rpt_ppaket_tglawalField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[rpt_ppaket_tglakhirField]
					   }]
			},{
				layout: 'column',
				border: false,
				items:[rpt_ppaket_opsiblnField,{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[rpt_ppaket_bulanField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[rpt_ppaket_tahunField]
					   }]
			}]
	});
	
	var	rpt_ppaket_opsiField=new Ext.form.FieldSet({
		id: 'rpt_ppaket_opsiField',
		title: 'Opsi',
		border: true,
		anchor: '98%',
		items: [rpt_ppaket_rekapField ,rpt_ppaket_detailField]
	});
	
	// opsi status
	var	rpt_ppaket_opsistatusField=new Ext.form.FieldSet({
		id: 'rpt_ppaket_opsistatusField',
		title: 'Opsi Status',
		border: true,
		anchor: '98%',
		items: [rpt_ppaket_tertutupField ,rpt_ppaket_semuaField]
	});
	
	var	rpt_ppaket_groupbyField=new Ext.form.FieldSet({
		id: 'rpt_ppaket_groupbyField',
		title: 'Group By',
		border: true,
		anchor: '98%',
		items: [rpt_ppaket_groupField]
	});
	
	function rpt_ppaket_is_valid_form(){
		if(rpt_ppaket_opsitglField.getValue()==true){
			rpt_ppaket_tglawalField.allowBlank=false;
			rpt_ppaket_tglakhirField.allowBlank=false;
			if(rpt_ppaket_tglawalField.isValid() && rpt_ppaket_tglakhirField.isValid())
				return true;
			else
				return false;
		}else{
			rpt_ppaket_tglawalField.allowBlank=true;
			rpt_ppaket_tglakhirField.allowBlank=true;
			return true;
		}
	}
	
	/* Function for print List Grid */
	function print_rpt_ppaket(){
		
		var ppaket_tgl_awal="";
		var ppaket_tglakhir="";
		var ppaket_opsi="";
		var ppaket_opsi_status="";
		var ppaket_bulan="";
		var ppaket_tahun="";
		var ppaket_periode="";
		
		var win;               
		if(rpt_ppaket_is_valid_form()){
			
		if(rpt_ppaket_tglawalField.getValue()!==""){ppaket_tgl_awal = rpt_ppaket_tglawalField.getValue().format('Y-m-d');}
		if(rpt_ppaket_tglakhirField.getValue()!==""){ppaket_tglakhir = rpt_ppaket_tglakhirField.getValue().format('Y-m-d');}
		if(rpt_ppaket_bulanField.getValue()!==""){ppaket_bulan=rpt_ppaket_bulanField.getValue(); }
		if(rpt_ppaket_tahunField.getValue()!==""){ppaket_tahun=rpt_ppaket_tahunField.getValue(); }
		if(rpt_ppaket_opsitglField.getValue()==true){
			ppaket_periode='tanggal';
		}else if(rpt_ppaket_opsiblnField.getValue()==true){
			ppaket_periode='bulan';
		}else{
			ppaket_periode='all';
		}
		if(rpt_ppaket_groupField.getValue()!==""){jpaket_group=rpt_ppaket_groupField.getValue(); }
		if(rpt_ppaket_rekapField.getValue()==true){ppaket_opsi='rekap';}else{ppaket_opsi='detail';}
		if(rpt_ppaket_tertutupField.getValue()==true){ppaket_opsi_status='tertutup';}
		if(rpt_ppaket_semuaField.getValue()==true){ppaket_opsi_status='semua';}
		
		Ext.MessageBox.show({
		   msg: 'Sedang memproses data, mohon tunggu...',
		   progressText: 'proses...',
		   width:350,
		   wait:true
		});
		
			Ext.Ajax.request({   
				waitMsg: 'Please Wait...',
				timeout: 3600000,
				url: 'index.php?c=c_penghangusan_paket&m=print_laporan',
				params: {
					tgl_awal	: ppaket_tgl_awal,
					tgl_akhir	: ppaket_tglakhir,
					opsi		: ppaket_opsi,
					opsi_status	: ppaket_opsi_status,
					bulan		: ppaket_bulan,
					tahun		: ppaket_tahun,
					periode		: ppaket_periode,
					group		: jpaket_group
					
				}, 
				success: function(response){              
					var result=eval(response.responseText);
					switch(result){
					case 1:
						Ext.MessageBox.hide(); 
						win = window.open('./print/report_ppaket.html','report_ppaket','height=400,width=800,resizable=1,scrollbars=1, menubar=1');
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
	
	rpt_ppaketForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		x:0,
		y:0,
		width: 400, 
		autoHeight: true,
		items: [rpt_ppaket_periodeField/*rpt_ppaket_opsiField,*/ /*rpt_ppaket_groupbyField *//*rpt_ppaket_opsistatusField*/],
		monitorValid:true,
		buttons: [{
				text: 'Print',
				formBind: true,
				handler: print_rpt_ppaket
			},{
				text: 'Close',
				handler: function(){
					rpt_ppaketWindow.hide();
					mainPanel.remove(mainPanel.getActiveTab().getId());
				}
		}]
		
	});
	
	/* Form Advanced Search */
	rpt_ppaketWindow = new Ext.Window({
		title: 'Laporan Penghangusan Paket',
		closable:false,
		closeAction: 'hide',
		resizable: false,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_rpt_ppaket',
		items: rpt_ppaketForm
	});
  	rpt_ppaketWindow.show();
	
	//EVENTS
	rpt_ppaket_rekapField.on("check", function(){
		rpt_ppaket_groupField.setValue('No faktur');
		if(rpt_ppaket_rekapField.getValue()==true){
			rpt_ppaket_groupField.bindStore(group_master_Store);
			rpt_ppaket_semuaField.setDisabled(true);
			rpt_ppaket_tertutupField.setDisabled(true);
			rpt_ppaket_tertutupField.setValue(true);
		}else
		{
			rpt_ppaket_groupField.bindStore(group_detail_Store);
		}
	});
	
	rpt_ppaket_detailField.on("check", function(){
		rpt_ppaket_groupField.setValue('Tanggal');
		if(rpt_ppaket_detailField.getValue()==true){
			rpt_ppaket_groupField.bindStore(group_detail_Store);
			rpt_ppaket_semuaField.setDisabled(false);
			rpt_ppaket_tertutupField.setDisabled(false);
			rpt_ppaket_tertutupField.setValue(true);
		}else
		{
			rpt_ppaket_groupField.bindStore(group_master_Store);
		}
	});
	
	rpt_ppaket_opsitglField.on("check",function(){
		if(rpt_ppaket_opsitglField.getValue()==true){
			rpt_ppaket_tglawalField.allowBlank=false;
			rpt_ppaket_tglakhirField.allowBlank=false;
		}else{
			rpt_ppaket_tglawalField.allowBlank=true;
			rpt_ppaket_tglakhirField.allowBlank=true;
		}
	});
	
	// event opsi status
	rpt_ppaket_groupField.on("select",function(){
	if(rpt_ppaket_groupField.getValue()=='Tanggal' && rpt_ppaket_detailField.getValue()==true ){
		rpt_ppaket_semuaField.setDisabled(false);
		rpt_ppaket_tertutupField.setDisabled(false);
		rpt_ppaket_semuaField.setValue(true);
	}
	else
	{
		rpt_ppaket_semuaField.setDisabled(true);
		rpt_ppaket_tertutupField.setDisabled(true);
		rpt_ppaket_tertutupField.setValue(true);
	}
	});
		
	// pertamax
	rpt_ppaket_semuaField.setDisabled(true);
	rpt_ppaket_tertutupField.setDisabled(true);
	rpt_ppaket_tertutupField.setValue(true);
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_info"></div>
		<div id="elwindow_rpt_ppaket"></div>
    </div>
</div>
</body>