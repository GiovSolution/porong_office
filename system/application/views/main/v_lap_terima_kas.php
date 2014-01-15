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

var rpt_terimakasWindow;

var rpt_terimakas_tglawalField;
var rpt_terimakas_tglakhirField;
var rpt_terimakas_bulanField;
var rpt_terimakas_tahunField;
var terimakasChart;
//var acc_group=<?=$_SESSION[SESSION_USERID];?>;

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

	rpt_terimakasDataStore = new Ext.data.Store({
		id: 'rpt_terimakasDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_lap_terima_kas&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST",start:0}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: ''
		},[
		/* dataIndex => insert into rekap_penjualanColumnModel, Mapping => for initiate table column */
			{name: 'jenis_transaksi', type: 'string', mapping: 'jenis_transaksi'},
			{name: 'nilai_card', type: 'float', mapping: 'nilai_card'},
			{name: 'nilai_cek', type: 'float', mapping: 'nilai_cek'},
			{name: 'nilai_kredit', type: 'float', mapping: 'nilai_kredit'},
			{name: 'nilai_kwitansi', type: 'float', mapping: 'nilai_kwitansi'},
			{name: 'nilai_transfer', type: 'float', mapping: 'nilai_transfer'},
			{name: 'nilai_tunai', type: 'float', mapping: 'nilai_tunai'},
			{name: 'nilai_voucher', type: 'float', mapping: 'nilai_voucher'},
			{name: 'nilai_total', type: 'float', mapping: 'nilai_total'},
		]),
		//sortInfo:{field: 'tot_net', direction: "DESC"}
	});
	
	rpt_terimakas_totalDataStore = new Ext.data.Store({
		id: 'rpt_terimakas_totalDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_lap_terima_kas&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST",start:0}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: ''
		},[
			{name: 'nilai_card_total', type: 'float', mapping: 'nilai_card_total'},
			{name: 'nilai_cek_total', type: 'float', mapping: 'nilai_cek_total'},
			{name: 'nilai_kredit_total', type: 'float', mapping: 'nilai_kredit_total'},
			{name: 'nilai_kwitansi_total', type: 'float', mapping: 'nilai_kwitansi_total'},
			{name: 'nilai_transfer_total', type: 'float', mapping: 'nilai_transfer_total'},
			{name: 'nilai_tunai_total', type: 'float', mapping: 'nilai_tunai_total'},
			{name: 'nilai_voucher_total', type: 'float', mapping: 'nilai_voucher_total'},
			{name: 'nilai_grand_total', type: 'float', mapping: 'nilai_grand_total'},
		]),
		//sortInfo:{field: 'tot_net', direction: "DESC"}
	});
	
	rpt_terimakas_total2DataStore = new Ext.data.Store({
		id: 'rpt_terimakas_total2DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_lap_terima_kas&m=get_action', 
			method: 'POST'
		}),
		baseParams:{task: "LIST",start:0}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: ''
		},[
			{name: 'nilai_card_total', type: 'float', mapping: 'nilai_card_total'},
			{name: 'nilai_cek_total', type: 'float', mapping: 'nilai_cek_total'},
			{name: 'nilai_kredit_total', type: 'float', mapping: 'nilai_kredit_total'},
			{name: 'nilai_kwitansi_total', type: 'float', mapping: 'nilai_kwitansi_total'},
			{name: 'nilai_transfer_total', type: 'float', mapping: 'nilai_transfer_total'},
			{name: 'nilai_tunai_total', type: 'float', mapping: 'nilai_tunai_total'},
			{name: 'nilai_voucher_total', type: 'float', mapping: 'nilai_voucher_total'},
			{name: 'nilai_grand_total', type: 'float', mapping: 'nilai_grand_total'},
		]),
		//sortInfo:{field: 'tot_net', direction: "DESC"}
	});

	rpt_terimakas_targetDataStore = new Ext.data.Store({
		id: 'rpt_terimakas_targetDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_lap_terima_kas&m=get_action', 
			method: 'POST',
		}),
		baseParams:{task: "TARGET",start:0}, // parameter yang di $_POST ke Controller
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: ''
		},[
			{name: 'tt_rp', type: 'float', mapping: 'tt_rp'},
		]),
		//sortInfo:{field: 'tot_net', direction: "DESC"}
	});
	rpt_terimakas_targetDataStore.load();
	rpt_terimakasColumnModel = new Ext.grid.ColumnModel(
		[{	
			align : 'Left',
			header: '<div align="center">' + 'Jenis Transaksi' + '</div>',
			dataIndex: 'jenis_transaksi',
			readOnly: true,
			width: 140,	//55,
			sortable: true
		},{	
			align : 'Right',
			header: '<div align="center">' + 'Tunai' + '</div>',
			dataIndex: 'nilai_tunai',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,
			sortable: true
		},{	
			align : 'Right',
			header: '<div align="center">' + 'Kuitansi' + '</div>',
			dataIndex: 'nilai_kwitansi',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		},{	
			align : 'Right',
			header: '<div align="center">' + 'Kartu Kredit' + '</div>',
			dataIndex: 'nilai_card',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		},{	
			align : 'Right',
			header: '<div align="center">' + 'Cek / Giro' + '</div>',
			dataIndex: 'nilai_cek',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		},{	
			align : 'Right',
			header: '<div align="center">' + 'Transfer' + '</div>',
			dataIndex: 'nilai_transfer',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		},{	
			align : 'Right',
			header: '<div align="center">' + 'Total' + '</div>',
			dataIndex: 'nilai_total',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		}
	]);
	
	rpt_terimakasColumnModel.defaultSortable= true;

	rpt_terimakas_totalColumnModel = new Ext.grid.ColumnModel(
		[{	
			align : 'Left',
			header: '<div align="center">' + '' + '</div>',
			dataIndex: '',
			readOnly: true,
			width: 140,	//55,
			sortable: true
		},{	
			align : 'Right',
			header: '<div align="center">' + 'Tunai' + '</div>',
			dataIndex: 'nilai_tunai_total',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,
			sortable: true
		},{	
			align : 'Right',
			header: '<div align="center">' + 'Kuitansi' + '</div>',
			dataIndex: 'nilai_kwitansi_total',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		},{	
			align : 'Right',
			header: '<div align="center">' + 'Kartu Kredit' + '</div>',
			dataIndex: 'nilai_card_total',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		},{	
			align : 'Right',
			header: '<div align="center">' + 'Cek / Giro' + '</div>',
			dataIndex: 'nilai_cek_total',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		},{	
			align : 'Right',
			header: '<div align="center">' + 'Transfer' + '</div>',
			dataIndex: 'nilai_transfer_total',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		},{	
			align : 'Right',
			header: '<div align="center">' + '<span style="font-weight:bold">Grand Total</span>' + '</div>',
			dataIndex: 'nilai_grand_total',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		}
	]);

	rpt_terimakas_total2ColumnModel = new Ext.grid.ColumnModel(
		[{	
			align : 'Left',
			header: '<span style="font-weight:bold">Pencapaian</span>',
			dataIndex: '',
			readOnly: true,
			width: 140,	//55,
			sortable: true
		},{	
			align : 'Right',
			header: '<div align="center">' + 'Tunai' + '</div>',
			dataIndex: 'nilai_tunai_total',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,
			sortable: true
		},{	
			align : 'Right',
			header: '<div align="center">' + 'Kuitansi' + '</div>',
			dataIndex: 'nilai_kwitansi_total',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		},{	
			align : 'Right',
			header: '<div align="center">' + 'Kartu Kredit' + '</div>',
			dataIndex: 'nilai_card_total',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		},{	
			align : 'Right',
			header: '<div align="center">' + 'Cek / Giro' + '</div>',
			dataIndex: 'nilai_cek_total',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		},{	
			align : 'Right',
			header: '<div align="center">' + 'Transfer' + '</div>',
			dataIndex: 'nilai_transfer_total',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		},{	
			align : 'Right',
			header: '<div align="center">' + '<span style="font-weight:bold">Grand Total</span>' + '</div>',
			dataIndex: 'nilai_grand_total',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 80,	//55,
			sortable: true
		}
	]);
	
	rpt_terimakas_totalColumnModel.defaultSortable= true;

	cbo_cabangDataStore = new Ext.data.Store({
		id: 'cbo_cabangDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_lap_terima_kas&m=get_cabang_list', 
			method: 'POST'
		}),baseParams: {start: 0, limit: 15 },
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total'
		},[
		/* dataIndex => insert intotbl_usersColumnModel, Mapping => for initiate table column */ 
			{name: 'cabang_display', type: 'string', mapping: 'cabang_nama'},
			{name: 'cabang_value', type: 'string', mapping: 'cabang_kode'},			
		])
	});

	rpt_terimakas_targetColumnModel = new Ext.grid.ColumnModel(
		[{	
			align : 'Left',
			header: '<div align="center">' + '' + '</div>',
			dataIndex: '',
			readOnly: true,
			width: 540,	//55,
			sortable: true
		},{	
			align : 'Right',
			header: '<div align="center">' + '<span style="font-weight:bold">Target</span>' + '</div>',
			dataIndex: 'tt_rp',
			renderer: Ext.util.Format.numberRenderer('0,000'),
			readOnly: true,
			width: 85,	//55,
			sortable: true
		}
	]);
	
	rpt_terimakas_targetColumnModel.defaultSortable= true;

	var cabang_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span>{cabang_display}</span>',
        '</div></tpl>'
    );

	cabangField= new Ext.form.ComboBox({
		id: 'cabangField',
		fieldLabel: 'Cabang',
		store: cbo_cabangDataStore,
		mode: 'remote',
		displayField:'cabang_display',
		valueField: 'cabang_value',
        typeAhead: false,
        loadingText: 'Searching...',
        //pageSize:10,
        hideTrigger:false,
        tpl: cabang_tpl,
        itemSelector: 'div.search-item',
		triggerAction: 'all',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		allowBlank: true,
		disabled:false,
		anchor: '95%'
	});

	cabangField.on('select', function(){
		if (cabangField.getValue() !== '[Pilih Cabang]'){
		
			<?php 
			$cabang = $this->m_public_function->get_info();
			$info_cabang = $cabang->info_cabang;
			$pesan = "Data untuk cabang lain hanya dapat diakses melalui MIS Miracle Thamrin.<br><br>(Saat ini Anda sedang berada di MIS ".$cabang->info_nama.')';
			if($info_cabang<>1){
			?> 
				Ext.MessageBox.alert('Information','<?echo $pesan?>');
				cabangField.setValue('[Pilih Cabang]');
			<? } ?>			
		}
	}
	);

	
	function online_confirm(){
		Ext.MessageBox.confirm('Confirmation', 'Fitur Online hanya dapat diakses di MIS Thamrin dan mungkin akan membutuhkan waktu cukup lama. Anda yakin untuk melanjutkan?', online_yes);
	}
	
	function online_yes(btn){
		if(btn=='yes'){
			
		}
		else {
			onlineField.reset();
		}
	}
	
	onlineField=new Ext.form.Checkbox({
		id : 'onlineField',
		boxLabel: '',
		name: 'online',
		handler: function(node,checked){
			if (checked) {
				online_confirm();
			}else{
				
			}
		}
	});
	
	tbar_periodeField= new Ext.form.ComboBox({
		id: 'tbar_periodeField',
		store:new Ext.data.SimpleStore({
			fields:['tbar_periode_value', 'tbar_periode_display'],
			data:[['Tanggal','Tanggal'],['Bulan','Bulan']]
		}),
		mode: 'local',
		displayField: 'tbar_periode_display',
		valueField: 'tbar_periode_value',
		listeners:{
			render: function(c){
			Ext.get(this.id).set({qtip:'Pilihan Periode'});
			}
		},
		editable:false,
		width: 76,
		triggerAction: 'all'	
	});
	
	rpt_terimakas_tglawalField= new Ext.form.DateField({
		id: 'rpt_terimakas_tglawalField',
		fieldLabel: ' ',
		format : 'd-m-Y',
		name: 'rpt_terimakas_tglawalField',
        //vtype: 'daterange',
		allowBlank: true,
		//width: 100,
        //endDateField: 'rpt_terimakas_tglakhirField'
		emptyText: 'Tgl Awal',
		//value: today
	});
	
	rpt_terimakas_tglakhirField= new Ext.form.DateField({
		id: 'rpt_terimakas_tglakhirField',
		fieldLabel: 's/d',
		format : 'd-m-Y',
		name: 'rpt_terimakas_tglakhirField',
        //vtype: 'daterange',
		allowBlank: true,
		//width: 100,
        //startDateField: 'rpt_terimakas_tglawalField',
		emptyText: 'Tgl Akhir',
		//value: today
	});

	rpt_terimakas_bulanField=new Ext.form.ComboBox({
		id:'rpt_terimakas_bulanField',
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
	
	rpt_terimakas_tahunField=new Ext.form.ComboBox({
		id:'rpt_terimakas_tahunField',
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
	
	function lap_terimakas_search(){
		
		var terimakas_tglawal="";
		var terimakas_tglakhir="";
		var terimakas_opsi="";
		var terimakas_bulan="";
		var terimakas_tahun="";
		var terimakas_periode="";
		var cabang_conn	= '';
		
		if(is_valid_form()){
			
			if(rpt_terimakas_tglawalField.getValue()!==""){terimakas_tglawal = rpt_terimakas_tglawalField.getValue().format('Y-m-d');}
			if(rpt_terimakas_tglakhirField.getValue()!==""){terimakas_tglakhir = rpt_terimakas_tglakhirField.getValue().format('Y-m-d');}
			if(rpt_terimakas_bulanField.getValue()!==""){terimakas_bulan=rpt_terimakas_bulanField.getValue(); }
			if(rpt_terimakas_tahunField.getValue()!==""){terimakas_tahun=rpt_terimakas_tahunField.getValue(); }
			if(cabangField.getValue()=='[Pilih Cabang]') {cabang_conn = 'default';}
			else {
				cabang_conn=cabangField.getValue(); 
				if (onlineField.getValue() == true) {cabang_conn = cabang_conn + '2';}
			}
			
			if (tbar_periodeField.getValue() == 'Tanggal') {
				terimakas_periode = 'tanggal';
			}else if (tbar_periodeField.getValue() == 'Bulan') {
				terimakas_periode = 'bulan';
			}

			rpt_terimakasDataStore.baseParams = {
						task		: 'SEARCH',
						tgl_awal	: terimakas_tglawal,
						tgl_akhir	: terimakas_tglakhir,
						bulan		: terimakas_bulan,
						tahun		: terimakas_tahun,
						periode		: terimakas_periode,
						opsi		: 'columnmodel',
						cabang		: cabang_conn
			};
					
			rpt_terimakas_totalDataStore.baseParams = {
						task		: 'SEARCH2',
						tgl_awal	: terimakas_tglawal,
						tgl_akhir	: terimakas_tglakhir,
						bulan		: terimakas_bulan,
						tahun		: terimakas_tahun,
						periode		: terimakas_periode,
						cabang		: cabang_conn						
			};
			
			rpt_terimakas_total2DataStore.baseParams = {
						task		: 'SEARCH3',
						tgl_awal	: terimakas_tglawal,
						tgl_akhir	: terimakas_tglakhir,
						bulan		: terimakas_bulan,
						tahun		: terimakas_tahun,
						periode		: terimakas_periode,
						cabang		: cabang_conn						
			};
			
			
			Ext.MessageBox.show({
			   msg: 'Sedang Proses...',
			   progressText: 'proses...',
			   width:350,
			   wait:true
			});
			
			rpt_terimakasDataStore.reload({
				callback: function(r, opt, success){
					if(success == true){
						rpt_terimakas_totalDataStore.reload();
						//terimakasChart.render();
						//terimakasChart.update("<iframe frameborder='0' width='100%' height='100%' src='http://localhost/mis2/index.php?c=c_gauge_chart&n=total&nilai=80'></iframe>");
						
							
						<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_LAPTERIMAKAS'))){ ?>
						
						rpt_terimakas_total2DataStore.reload();

						rpt_terimakas_targetDataStore.baseParams = {
							task		: 'TARGET',		
							tgl_awal	: terimakas_tglawal,
							tgl_akhir	: terimakas_tglakhir,	
							periode		: terimakas_periode,
							cabang		: cabang_conn						
						};
						
						rpt_terimakas_targetDataStore.reload();
						
						Ext.Ajax.request({
							waitMsg: 'Please Wait...',
							url: 'index.php?c=c_lap_terima_kas&m=get_action',
							params: {
								task: 'CHART',						
								tgl_awal	: terimakas_tglawal,
								tgl_akhir	: terimakas_tglakhir,
								bulan		: terimakas_bulan,
								tahun		: terimakas_tahun,
								periode		: terimakas_periode,
								opsi		: 'columnmodel',
								cabang		: cabang_conn,
								method: 'POST'
								
							},
							success: function(result, request){
								var hasil=eval(result.responseText);
								if (hasil > 0 )
								{
									<? $info=$this->m_public_function->get_info();?>
									//alert(<?$info->info_nama;?>);
									terimakasChart.render();
									terimakasChart.update("<iframe frameborder='0' width='100%' height='100%' src='http://"+"<? echo $_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT']?>"+"/mis2/index.php?c=c_gauge_chart&n=total&nilai="+hasil+"'></iframe>");
								}
							},
							failure: function(response){
								Ext.MessageBox.hide();
								Ext.MessageBox.show({
								   title: 'Error',
								   msg: FAILED_CONNECTION,
								   buttons: Ext.MessageBox.OK,
								   animEl: 'database',
								   icon: Ext.MessageBox.ERROR
								});
							}
						}); 
						
						<?  } ?>
						
						
						Ext.MessageBox.hide();
					}
					else if (success == false){
						Ext.MessageBox.hide();
						Ext.MessageBox.show({
							title: 'Error',
							msg: 'Tidak bisa terhubung dengan database server',
							buttons: Ext.MessageBox.OK,
							animEl: 'database',
							icon: Ext.MessageBox.ERROR
						});	
					}
				}
			});		
		
		}else{
			Ext.MessageBox.show({
			   title: 'Warning',
			   msg: 'Form Anda belum lengkap',
			   buttons: Ext.MessageBox.OK,
			   animEl: 'database',
			   icon: Ext.MessageBox.WARNING
			});	
		}
	}
	
	rpt_terimakasListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'rpt_terimakasListEditorGrid',
		el: 'fp_rpt_terimakas_list',
		title: 'Laporan Penerimaan Kas',
		autoHeight: true,
		store: rpt_terimakasDataStore, // DataStore
		cm: rpt_terimakasColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		//clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 800, 
		/* Add Control on ToolBar */
		tbar: [
			'<b><font color=white>Periode : </b>', tbar_periodeField, 
			'-', rpt_terimakas_tglawalField, 
			'-', rpt_terimakas_tglakhirField, 
			'-', rpt_terimakas_bulanField, 
			'-', rpt_terimakas_tahunField,
			<?php if(eregi('H',$this->m_security->get_access_group_by_kode('MENU_LAPTERIMAKAS'))){ ?>	
				'-', cabangField, 
				'-', onlineField, '<b><font color=white>Online</b>',
			<?  } ?>			
			'-', 
		{
			text: 'Search',
			tooltip: 'Search',
			iconCls:'icon-search',
			handler: lap_terimakas_search
		}, '-',{
			text: 'Print',
			tooltip: 'Print Document',
			iconCls:'icon-print',
			handler: print_rpt_terimakas  
		}
		]
	});
	rpt_terimakasListEditorGrid.render();

	rpt_terimakas_totalListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'rpt_terimakas_totalListEditorGrid',
		el: 'fp_terimakas_total_list',
		title: '',
		autoHeight: true,
		store: rpt_terimakas_totalDataStore, // DataStore
		cm: rpt_terimakas_totalColumnModel, // Nama-nama Columns
		enableColLock:false,
		frame: true,
		//clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 800,
	});
	rpt_terimakas_totalListEditorGrid.render();

	rpt_terimakas_total2ListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'rpt_terimakas_total2ListEditorGrid',
		title: 'Mid Year Festival 2012',
		el: 'fp_terimakas_total2_list',
		autoHeight: true,
		store: rpt_terimakas_total2DataStore, // DataStore
		cm: rpt_terimakas_total2ColumnModel, // Nama-nama Columns
		enableColLock:false,
		//frame: true,
		//clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 800,
	});
	

	rpt_terimakas_targetListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'rpt_terimakas_targetListEditorGrid',
		el: 'fp_terimakas_target_list',
		title: '',
		autoHeight: true,
		store: rpt_terimakas_targetDataStore, // DataStore
		cm: rpt_terimakas_targetColumnModel, // Nama-nama Columns
		enableColLock:false,
		//clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 800,
	});
	
	<?php if(eregi('C',$this->m_security->get_access_group_by_kode('MENU_LAPTERIMAKAS'))){ ?>
		rpt_terimakas_targetListEditorGrid.render();
		rpt_terimakas_total2ListEditorGrid.render();
	<?  } ?>
		
	// inisialisasi awal
	tbar_periodeField.setValue('Tanggal');
	rpt_terimakas_tglawalField.setVisible(true);
	rpt_terimakas_tglakhirField.setVisible(true);
	rpt_terimakas_bulanField.setVisible(false);
	rpt_terimakas_tahunField.setVisible(false);			
	cabangField.setValue('[Pilih Cabang]');
		
				
	tbar_periodeField.on('select', function(){
		if (tbar_periodeField.getValue() == 'Tanggal'){
			rpt_terimakas_tglawalField.setVisible(true);
			rpt_terimakas_tglakhirField.setVisible(true);
			rpt_terimakas_bulanField.setVisible(false);
			rpt_terimakas_tahunField.setVisible(false);			
		} else if (tbar_periodeField.getValue() == 'Bulan'){
			rpt_terimakas_tglawalField.setVisible(false);
			rpt_terimakas_tglakhirField.setVisible(false);
			rpt_terimakas_bulanField.setVisible(true);
			rpt_terimakas_tahunField.setVisible(true);			
		}
	});

				
	function is_valid_form(){
		if(tbar_periodeField.getValue() == 'Tanggal'){
			rpt_terimakas_tglawalField.allowBlank=false;
			rpt_terimakas_tglakhirField.allowBlank=false;
			if(rpt_terimakas_tglawalField.isValid() && rpt_terimakas_tglakhirField.isValid())
				return true;
			else
				return false;
		}else{
			rpt_terimakas_tglawalField.allowBlank=true;
			rpt_terimakas_tglakhirField.allowBlank=true;
			return true;
		}
	}
	
	/* Function for print List Grid */
	function print_rpt_terimakas(){
		
		var terimakas_tglawal="";
		var terimakas_tglakhir="";
		var terimakas_opsi="";
		var terimakas_bulan="";
		var terimakas_tahun="";
		var terimakas_periode="";
		var terimakas_group="";
		
		var win;               
		if(is_valid_form()){
			
			if(rpt_terimakas_tglawalField.getValue()!==""){terimakas_tglawal = rpt_terimakas_tglawalField.getValue().format('Y-m-d');}
			if(rpt_terimakas_tglakhirField.getValue()!==""){terimakas_tglakhir = rpt_terimakas_tglakhirField.getValue().format('Y-m-d');}
			if(rpt_terimakas_bulanField.getValue()!==""){terimakas_bulan=rpt_terimakas_bulanField.getValue(); }
			if(rpt_terimakas_tahunField.getValue()!==""){terimakas_tahun=rpt_terimakas_tahunField.getValue(); }		
			if (tbar_periodeField.getValue() == 'Tanggal') {
					terimakas_periode = 'tanggal';
				}else if (tbar_periodeField.getValue() == 'Bulan') {
					terimakas_periode = 'bulan';
				}
			if(cabangField.getValue()=='[Pilih Cabang]') {cabang_conn = 'default';}
			else {
				cabang_conn=cabangField.getValue(); 
				if (onlineField.getValue() == true) {cabang_conn = cabang_conn + '2';}
			}
		
			Ext.Ajax.request({   
				waitMsg: 'Please Wait...',
				url: 'index.php?c=c_lap_terima_kas&m=print_laporan',
				params: {
					tgl_awal	: terimakas_tglawal,
					tgl_akhir	: terimakas_tglakhir,
					opsi		: terimakas_opsi,
					bulan		: terimakas_bulan,
					tahun		: terimakas_tahun,
					periode		: terimakas_periode,
					cabang		: cabang_conn
				}, 
				success: function(response){              
					var result=eval(response.responseText);
					switch(result){
					case 1:
						win = window.open('./print/report_terimakas.html','report_terimakas','height=400,width=800,resizable=1,scrollbars=1, menubar=1');
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
			   msg: 'Form Anda belum lengkap',
			   buttons: Ext.MessageBox.OK,
			   animEl: 'database',
			   icon: Ext.MessageBox.WARNING
			});	
		}
	}
	/* Enf Function */
					
	var terimakasChart =	new Ext.form.FormPanel ({
							title: 'Grafik Pencapaian Target Mid Year Festival 2012',
							resizeable: true,
							id: 'terimakasChart',
							el: 'elwindow_chart_terimakas',
					        width: 800,
							height: 300,
							collapsible: true,
							layout: 'fit',
							//autoLoad: 'true',
							frame: true,
							html: "<iframe frameborder='0' width='100%' height='100%' src=''></iframe>",
							autoDestroy: true,
							});
});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_info"></div>	
		<div id="fp_rpt_terimakas_list"></div> 
		<div id="fp_terimakas_total_list"></div> 
		<div id="fp_terimakas_total2_list"></div> 
		<div id="fp_terimakas_target_list"></div> 
		<div id="elwindow_chart_terimakas"></div>	

    </div>
</div>
</body>