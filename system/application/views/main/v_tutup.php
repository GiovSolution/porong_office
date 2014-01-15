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

var rpt_tutupWindow;
var rpt_tutupForm;

var rpt_tutup_tglawalField;
var rpt_tutup_tglakhirField;
var rpt_tutup_rekapField;
var rpt_tutup_detailField;
var rpt_tutup_bulanField;
var rpt_tutup_tahunField;
var rpt_tutup_opsitglField;
var rpt_tutup_opsiblnField;
var rpt_tutup_opsiallField;
var rpt_tutup_groupField;

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
	
	var rpt_tutup_groupField=new Ext.form.ComboBox({
		id:'rpt_tutup_groupField',
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
	
	rpt_tutup_bulanField=new Ext.form.ComboBox({
		id:'rpt_tutup_bulanField',
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
	
	rpt_tutup_tahunField=new Ext.form.ComboBox({
		id:'rpt_tutup_tahunField',
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
	
	rpt_tutup_opsitglField=new Ext.form.Radio({
		id:'rpt_tutup_opsitglField',
		boxLabel:'Tanggal',
		width:100,
		name: 'filter_opsi'
	});
	
	rpt_tutup_opsiblnField=new Ext.form.Radio({
		id:'rpt_tutup_opsiblnField',
		boxLabel:'Bulan',
		width:100,
		name: 'filter_opsi',
		checked: true
	});
	
	rpt_tutup_opsiallField=new Ext.form.Radio({
		id:'rpt_tutup_opsiallField',
		boxLabel:'Semua',
		name: 'filter_opsi',
		checked: true
	});
	
	rpt_tutup_tglawalField= new Ext.form.DateField({
		id: 'rpt_tutup_tglawalField',
		fieldLabel: ' ',
		format : 'Y-m-d',
		name: 'rpt_tutup_tglawalField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
		value: firstday
        //endDateField: 'rpt_tutup_tglakhirField'
	});
	
	rpt_tutup_tglakhirField= new Ext.form.DateField({
		id: 'rpt_tutup_tglakhirField',
		fieldLabel: 's/d',
		format : 'Y-m-d',
		name: 'rpt_tutup_tglakhirField',
        //vtype: 'daterange',
		allowBlank: true,
		width: 100,
        //startDateField: 'rpt_tutup_tglawalField',
		value: today
	});
	
	rpt_tutup_rekapField=new Ext.form.Radio({
		id: 'rpt_tutup_rekapField',
		boxLabel: 'Rekap',
		name: 'tutup_opsi',
		checked: true
	});
	
	rpt_tutup_detailField=new Ext.form.Radio({
		id: 'rpt_tutup_detailField',
		boxLabel: 'Detail',
		name: 'tutup_opsi'
	});
	
	var rpt_tutup_periodeField=new Ext.form.FieldSet({
		id:'rpt_tutup_periodeField',
		title : 'Periode',
		layout: 'form',
		bodyStyle:'padding: 0px 0px 0',
		frame: false,
		bolder: false,
		anchor: '98%',
		items:[{
				layout: 'column',
				border: false,
				items:[rpt_tutup_opsitglField, {
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[rpt_tutup_tglawalField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[rpt_tutup_tglakhirField]
					   }]
			},{
				layout: 'column',
				border: false,
				items:[rpt_tutup_opsiblnField,{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							items:[rpt_tutup_bulanField]
					   },{
					   		layout: 'form',
							border: false,
							labelWidth: 15,
							bodyStyle:'padding:3px',
							labelSeparator: ' ', 
							items:[rpt_tutup_tahunField]
					   }]
			}]
	});
	
	var	rpt_tutup_opsiField=new Ext.form.FieldSet({
		id: 'rpt_tutup_opsiField',
		title: 'Opsi',
		border: true,
		anchor: '98%',
		items: [rpt_tutup_rekapField ,rpt_tutup_detailField]
	});
	
	var	rpt_tutup_groupbyField=new Ext.form.FieldSet({
		id: 'rpt_tutup_groupbyField',
		title: 'Group By',
		border: true,
		anchor: '98%',
		items: [rpt_tutup_groupField]
	});
	
	function is_valid_form(){
		if(rpt_tutup_opsitglField.getValue()==true){
			rpt_tutup_tglawalField.allowBlank=false;
			rpt_tutup_tglakhirField.allowBlank=false;
			if(rpt_tutup_tglawalField.isValid() && rpt_tutup_tglakhirField.isValid())
				return true;
			else
				return false;
		}else{
			rpt_tutup_tglawalField.allowBlank=true;
			rpt_tutup_tglakhirField.allowBlank=true;
			return true;
		}
	}
	
	/* Function for print List Grid */
	function proses_tutup(btn){
		
		var tutup_tglawal="";
		var tutup_tglakhir="";
		var tutup_opsi="";
		var tutup_bulan="";
		var tutup_tahun="";
		var tutup_periode="";
		var tutup_group="";
		
		var win;               
		//if(is_valid_form()){
		if(btn=='yes'){
	/*	if(rpt_tutup_tglawalField.getValue()!==""){tutup_tglawal = rpt_tutup_tglawalField.getValue().format('Y-m-d');}
		if(rpt_tutup_tglakhirField.getValue()!==""){tutup_tglakhir = rpt_tutup_tglakhirField.getValue().format('Y-m-d');}
		if(rpt_tutup_bulanField.getValue()!==""){tutup_bulan=rpt_tutup_bulanField.getValue(); }
		if(rpt_tutup_tahunField.getValue()!==""){tutup_tahun=rpt_tutup_tahunField.getValue(); }
		if(rpt_tutup_opsitglField.getValue()==true){
			tutup_periode='tanggal';
		}else if(rpt_tutup_opsiblnField.getValue()==true){
			tutup_periode='bulan';
		}else{
			tutup_periode='all';
		}
		if(rpt_tutup_groupField.getValue()!==""){tutup_group=rpt_tutup_groupField.getValue(); }
		*/
		//if(rpt_tutup_rekapField.getValue()==true){tutup_opsi='rekap';}else{tutup_opsi='detail';}
		
/*		Ext.MessageBox.show({
		   msg: 'Sedang memproses data, mohon tunggu...',
		   progressText: 'proses...',
		   width:350,
		   wait:true
		});	
*/		
			Ext.Ajax.request({   
				waitMsg: 'Please Wait...',
				url: 'index.php?c=c_tutup&m=tutup_transaksi',
				timeout: 120000,
				/*params: {
					tgl_awal	: tutup_tglawal,
					tgl_akhir	: tutup_tglakhir,
					/*opsi		: tutup_opsi,
					bulan		: tutup_bulan,
					tahun		: tutup_tahun,
					periode		: tutup_periode
					
				}, */
				success: function(response){              
					var result=eval(response.responseText);
					switch(result){
					case 1:
//						Ext.MessageBox.hide();
						Ext.MessageBox.alert(' OK','Proses Tutup Buku berhasil.');
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
		/*}else{
			Ext.MessageBox.show({
			   title: 'Warning',
			   msg: 'Not valid form.',
			   buttons: Ext.MessageBox.OK,
			   animEl: 'database',
			   icon: Ext.MessageBox.WARNING
			});	
		}*/
		}
	}
	/* Enf Function */
	
	rpt_tutupForm = new Ext.FormPanel({
		labelAlign: 'left',
		bodyStyle:'padding:5px',
		x:0,
		y:0,
		width: 600, 
		autoHeight: true,
		//items: [{ xtype:'label', html: 'Tutup Buku, <br> Penutupan Buku Akuntansi di akhir periode <br/> Semua transaksi akan diarsip dan disaldo di Master Akun'}],
		items: [{ 
			xtype:'label', 
			html: 	'Beberapa hal yang perlu diperhatikan pada proses Tutup Buku:<br>'+
					'1. Transaksi periode sebelumnya pada akun Neraca akan dipindahkan menjadi saldo awal pada periode berikutnya.<br>'+
					'2. Saldo awal pada akun Laba Rugi akan menjadi 0.<br>'+
					'3. Periode Akun akan otomatis diubah menjadi periode selanjutnya.'
				}],
		//monitorValid:true,
		buttons: [{
				text: 'Tutup Buku Sekarang',
				//formBind: true,
				handler: function(){
					Ext.MessageBox.confirm('Konfirmasi','Apakah Anda yakin akan melakukan proses Tutup Buku sekarang?',proses_tutup);
					
				}
			},{
				text: 'Close',
				handler: function(){
					rpt_tutupWindow.hide();
					mainPanel.remove(mainPanel.getActiveTab().getId());
				}
		}]
		
	});
	
	/* Form Advanced Search */
	rpt_tutupWindow = new Ext.Window({
		title: 'Tutup Buku',
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
		renderTo: 'elwindow_rpt_tutup',
		items: rpt_tutupForm
	});
  	rpt_tutupWindow.show();
	
	
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_info"></div>
		<div id="elwindow_rpt_tutup"></div>
    </div>
</div>
</body>