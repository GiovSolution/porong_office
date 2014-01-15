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

var rpt_postingWindow;
var rpt_postingForm;

var rpt_posting_tglawalField;
var rpt_posting_tglakhirField;
var rpt_posting_rekapField;
var rpt_posting_detailField;
var rpt_posting_bulanField;
var rpt_posting_tahunField;
var rpt_posting_opsitglField;
var rpt_posting_opsiblnField;
var rpt_posting_opsiallField;
var rpt_posting_groupField;

var firstday=(new Date().format('Y-m'))+'-01';
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
			data:[['No Faktur'],['Tanggal'],['Customer'],['Produk'],['Sales'],['Jenis Diskon']]
	});

	var rpt_posting_groupField=new Ext.form.ComboBox({
		id:'rpt_posting_groupField',
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

	rpt_posting_bulanField=new Ext.form.ComboBox({
		id:'rpt_posting_bulanField',
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
		triggerAction: 'all',
		disabled: true
	});

	rpt_posting_tahunField=new Ext.form.ComboBox({
		id:'rpt_posting_tahunField',
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
		triggerAction: 'all',
		disabled: true
	});

	rpt_posting_opsitglField=new Ext.form.Radio({
		id:'rpt_posting_opsitglField',
		boxLabel:'Tanggal',
		width:100,
		name: 'filter_opsi',
		checked: true,		
	});

	rpt_posting_opsiblnField=new Ext.form.Radio({
		id:'rpt_posting_opsiblnField',
		boxLabel:'Bulan',
		width:100,
		name: 'filter_opsi',
		disabled: true
	});

	rpt_posting_opsiallField=new Ext.form.Radio({
		id:'rpt_posting_opsiallField',
		boxLabel:'Semua',
		name: 'filter_opsi',
		checked: true
	});

	rpt_posting_tglawalField= new Ext.form.DateField({
		id: 'rpt_posting_tglawalField',
		fieldLabel: ' ',
		format : 'Y-m-d',
		name: 'rpt_posting_tglawalField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
		value: firstday
        //endDateField: 'rpt_posting_tglakhirField'
	});

	rpt_posting_tglakhirField= new Ext.form.DateField({
		id: 'rpt_posting_tglakhirField',
		fieldLabel: 's/d',
		format : 'Y-m-d',
		name: 'rpt_posting_tglakhirField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
        //startDateField: 'rpt_posting_tglawalField',
		value: today
	});

	rpt_posting_rekapField=new Ext.form.Radio({
		id: 'rpt_posting_rekapField',
		boxLabel: 'Rekap',
		name: 'posting_opsi',
		checked: true
	});

	rpt_posting_detailField=new Ext.form.Radio({
		id: 'rpt_posting_detailField',
		boxLabel: 'Detail',
		name: 'posting_opsi'
	});

	var rpt_posting_periodeField=new Ext.form.FieldSet({
		id:'rpt_posting_periodeField',
		title : 'Periode',
		layout: 'form',
		bodyStyle:'padding: 0px 0px 0',
		frame: false,
		bolder: false,
		anchor: '98%',
		items:[{
				layout: 'column',
				border: false,
				items:[rpt_posting_opsitglField, {
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[rpt_posting_tglawalField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ',
							items:[rpt_posting_tglakhirField]
					   }]
			},{
				layout: 'column',
				border: false,
				items:[rpt_posting_opsiblnField,{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[rpt_posting_bulanField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ',
							items:[rpt_posting_tahunField]
					   }]
			}]
	});

	var	rpt_posting_opsiField=new Ext.form.FieldSet({
		id: 'rpt_posting_opsiField',
		title: 'Opsi',
		border: true,
		anchor: '98%',
		items: [rpt_posting_rekapField ,rpt_posting_detailField]
	});

	var	rpt_posting_groupbyField=new Ext.form.FieldSet({
		id: 'rpt_posting_groupbyField',
		title: 'Group By',
		border: true,
		anchor: '98%',
		items: [rpt_posting_groupField]
	});

	function is_valid_form(){
		if(rpt_posting_opsitglField.getValue()==true){
			rpt_posting_tglawalField.allowBlank=false;
			rpt_posting_tglakhirField.allowBlank=false;
			if(rpt_posting_tglawalField.isValid() && rpt_posting_tglakhirField.isValid())
				return true;
			else
				return false;
		}else{
			rpt_posting_tglawalField.allowBlank=true;
			rpt_posting_tglakhirField.allowBlank=true;
			return true;
		}
	}

	/* Function for print List Grid */
	function proses_posting(){

		var posting_tglawal="";
		var posting_tglakhir="";
		var posting_opsi="";
		var posting_bulan="";
		var posting_tahun="";
		var posting_periode="";
		var posting_group="";

		var win;
		if(is_valid_form()){

		if(rpt_posting_tglawalField.getValue()!==""){posting_tglawal = rpt_posting_tglawalField.getValue().format('Y-m-d');}
		if(rpt_posting_tglakhirField.getValue()!==""){posting_tglakhir = rpt_posting_tglakhirField.getValue().format('Y-m-d');}
		if(rpt_posting_bulanField.getValue()!==""){posting_bulan=rpt_posting_bulanField.getValue(); }
		if(rpt_posting_tahunField.getValue()!==""){posting_tahun=rpt_posting_tahunField.getValue(); }
		if(rpt_posting_opsitglField.getValue()==true){
			posting_periode='tanggal';
		}else if(rpt_posting_opsiblnField.getValue()==true){
			posting_periode='bulan';
		}else{
			posting_periode='all';
		}
		if(rpt_posting_groupField.getValue()!==""){posting_group=rpt_posting_groupField.getValue(); }

		//if(rpt_posting_rekapField.getValue()==true){posting_opsi='rekap';}else{posting_opsi='detail';}

		Ext.MessageBox.show({
		   msg: 'Sedang memproses data, mohon tunggu...',
		   progressText: 'proses...',
		   width:350,
		   wait:true
		});	
		
			Ext.Ajax.request({
				waitMsg: 'Please Wait...',
				timeout: 600000,
				url: 'index.php?c=c_posting&m=post_transaksi',
				params: {
					tgl_awal	: posting_tglawal,
					tgl_akhir	: posting_tglakhir,
					/*opsi		: posting_opsi,*/
					bulan		: posting_bulan,
					tahun		: posting_tahun,
					periode		: posting_periode

				},
				success: function(response){
					var result=eval(response.responseText);
					switch(result){
					case 1:
						Ext.MessageBox.alert(' OK','Posting berhasil dilakukan.');
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
					   msg: 'Koneksi database gagal.',
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

	rpt_postingForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		x:0,
		y:0,
		width: 400,
		autoHeight: true,
		items: [rpt_posting_periodeField],
		monitorValid:true,
		buttons: [{
				text: 'Posting',
				formBind: true,
				handler: proses_posting
			},{
				text: 'Close',
				handler: function(){
					rpt_postingWindow.hide();
					mainPanel.remove(mainPanel.getActiveTab().getId());
				}
		}]

	});

	/* Form Advanced Search */
	rpt_postingWindow = new Ext.Window({
		title: 'Posting Transaksi',
		closable:false,
		closeAction: 'hide',
		resizable: false,
		plain:true,
		width: 420,
		autoHeight: true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_rpt_posting',
		items: rpt_postingForm
	});
  	rpt_postingWindow.show();


});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_info"></div>
		<div id="elwindow_rpt_posting"></div>
    </div>
</div>
</body>