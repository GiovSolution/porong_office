<?
/* 	These code was generated using phpCIGen v 0.1.a (21/04/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
    #songbee	mukhlisona@gmail.com
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: Report Order Pembelian
	+ Description	: For record view
	+ Filename 		: V_report_customer.php
 	+ Author  		: 
 	+ Created on 01/May/2009 06:35:27
	
*/
?>
<div id="welcome">
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

var customerWindow;
var customerForm;

/* declare variable here */

var rpt_customertglstartField;
var rpt_customertglendField;
var rpt_carabayarField;

<?
$idForm=20;
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


Ext.onReady(function(){
  Ext.QuickTips.init();
	
	cbo_cust_profesi_DataStore = new Ext.data.Store({
		id: 'cbo_cust_profesi_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_report_customer&m=get_profesi_list', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'cust_profesi'
		},[
		/* dataIndex => insert intocustomer_ColumnModel, Mapping => for initiate table column */ 
			{name: 'cust_profesi_display', type: 'string', mapping: 'cust_profesi'}
		]),
		sortInfo:{field: 'cust_profesi_display', direction: "ASC"}
	});
	
	cbo_cust_hobi_DataStore = new Ext.data.Store({
		id: 'cbo_cust_hobi_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_report_customer&m=get_hobi_list', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'cust_hobi'
		},[
		/* dataIndex => insert intocustomer_ColumnModel, Mapping => for initiate table column */ 
			{name: 'cust_hobi_display', type: 'string', mapping: 'cust_hobi'}
		]),
		sortInfo:{field: 'cust_hobi_display', direction: "ASC"}
	});
	
	cbo_cust_cabang_DataStore = new Ext.data.Store({
		id: 'cbo_cust_cabang_DataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_report_customer&m=get_cabang_list', 
			method: 'POST'
		}),
		reader: new Ext.data.JsonReader({
			root: 'results',
			totalProperty: 'total',
			id: 'cabang_id'
		},[
		/* dataIndex => insert intocustomer_ColumnModel, Mapping => for initiate table column */ 
			{name: 'cust_cabang_value', type: 'int', mapping: 'cabang_id'},
			{name: 'cust_cabang_display', type: 'string', mapping: 'cabang_nama'}
		]),
		sortInfo:{field: 'cust_cabang_display', direction: "ASC"}
	});
	
	rpt_cust_namaField= new Ext.form.TextField({
		id: 'rpt_cust_namaField',
		fieldLabel: 'Nama',
		maxLength: 50,
		anchor: '95%'
	});
	
	rpt_cust_kelaminField= new Ext.form.ComboBox({
		id: 'rpt_cust_kelaminField',
		fieldLabel: 'Jenis Kelamin',
		store:new Ext.data.SimpleStore({
			fields:['cust_kelamin_value', 'cust_kelamin_display'],
			data:[['L','L'],['P','P']]
		}),
		mode: 'local',
		displayField: 'cust_kelamin_display',
		valueField: 'cust_kelamin_value',
		anchor: '30%',
		triggerAction: 'all'	
	});
	
	rpt_cust_kotaField= new Ext.form.TextField({
		id: 'rpt_cust_kotaField',
		fieldLabel: 'Kota',
		maxLength: 100,
		anchor: '95%'
	});
	
	rpt_cust_propinsiField= new Ext.form.TextField({
		id: 'rpt_cust_propinsiField',
		fieldLabel: 'Propinsi',
		maxLength: 100,
		anchor: '95%'
	});
	
	rpt_cust_pendidikanField= new Ext.form.ComboBox({
		id: 'rpt_cust_pendidikanField',
		fieldLabel: 'Pendidikan',
		maxLength: 50,
		store:new Ext.data.SimpleStore({
			fields:['cust_pendidikan_value_display'],
			data: [['SMA'],['Diploma'],['Sarjana'],['Pasca Sarjana'],['Doktoral'],['Lainnya']]
		}),
		mode: 'local',
		displayField: 'cust_pendidikan_value_display',
		valueField: 'cust_pendidikan_value_display',
		anchor: '50%',
		triggerAction: 'all'
	});
	
	rpt_cust_profesiField= new Ext.form.ComboBox({
		id: 'rpt_cust_profesiField',
		fieldLabel: 'Profesi',
		maxLength: 100,
		store: cbo_cust_profesi_DataStore,
		mode: 'remote',
		displayField: 'cust_profesi_display',
		valueField: 'cust_profesi_display',
		anchor: '95%',
		triggerAction: 'all'
	});
	
	rpt_cust_hobiField= new Ext.form.ComboBox({
		id: 'rpt_cust_hobiField',
		fieldLabel: 'Hobi',
		maxLength: 500,
		store: cbo_cust_hobi_DataStore,
		mode: 'remote',
		displayField: 'cust_hobi_display',
		valueField: 'cust_hobi_display',
		anchor: '95%',
		triggerAction: 'all'
	});
	
	rpt_cust_statusnikahField= new Ext.form.ComboBox({
		id: 'rpt_cust_statusnikahField',
		fieldLabel: 'Status Pernikahan',
		store:new Ext.data.SimpleStore({
			fields:['cust_statusnikah_value', 'cust_statusnikah_display'],
			data:[['menikah','menikah'],['belum menikah','belum menikah']]
		}),
		mode: 'local',
		displayField: 'cust_statusnikah_display',
		valueField: 'cust_statusnikah_value',
		anchor: '50%',
		triggerAction: 'all'	
	});
	
	rpt_cust_unitField= new Ext.form.ComboBox({
		id: 'rpt_cust_unitField',
		fieldLabel: 'Cabang',
		store: cbo_cust_cabang_DataStore,
		mode: 'remote',
		displayField: 'cust_cabang_display',
		valueField: 'cust_cabang_value',
		anchor: '95%',
		triggerAction: 'all'
	});
	
	rpt_cust_agamaField= new Ext.form.ComboBox({
		id: 'rpt_cust_agamaField',
		fieldLabel: 'Agama',
		maxLength: 50,
		store:new Ext.data.SimpleStore({
			fields:['cust_agama_value_display'],
			data: [['Islam'],['Katholik'],['Kristen'],['Hindu'],['Budha'],['Lainnya']]
		}),
		mode: 'local',
		displayField: 'cust_agama_value_display',
		valueField: 'cust_agama_value_display',
		anchor: '50%',
		triggerAction: 'all'	
	});
	
	rpt_cust_tgllahirField= new Ext.form.DateField({
		id: 'rpt_cust_tgllahirField',
		fieldLabel: 'Tanggal Lahir',
		format : 'Y-m-d',
		anchor: '50%'
	});
	
	rpt_cust_terdaftarstartField= new Ext.form.DateField({
		id: 'rpt_cust_terdaftarstartField',
		fieldLabel: 'Mulai',
		format : 'Y-m-d',
		name: 'rpt_cust_terdaftarstartField',
        vtype: 'daterange',
        endDateField: 'rpt_cust_terdaftarendField'
	});
	
	rpt_cust_terdaftarendField= new Ext.form.DateField({
		id: 'rpt_cust_terdaftarendField',
		fieldLabel: 's/d',
		format : 'Y-m-d',
		name: 'rpt_cust_terdaftarendField',
        vtype: 'daterange',
        startDateField: 'rpt_cust_terdaftarstartField'
	});
	
	rpt_cust_alamatGroup = new Ext.form.FieldSet({
		title: 'Alamat',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [rpt_cust_kotaField, rpt_cust_propinsiField] 
			}
			]
	
	});
	
	rpt_cust_terdaftarGroup = new Ext.form.FieldSet({
		title: 'Tanggal Terdaftar',
		autoHeight: true,
		collapsible: true,
		layout:'column',
		items:[
			{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [rpt_cust_terdaftarstartField] 
			}
			,{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [rpt_cust_terdaftarendField] 
			}
			]
	
	});
	
	rpt_carabayarField= new Ext.form.ComboBox({
		id: 'rpt_carabayarField',
		fieldLabel: 'Cara Bayar',
		store:new Ext.data.SimpleStore({
			fields:['order_carabayar_value', 'order_carabayar_display'],
			data:[['tunai','tunai'],['kredit','kredit'],['konsinyasi','konsinyasi']]
		}),
		mode: 'local',
		displayField: 'order_carabayar_display',
		valueField: 'order_carabayar_value',
		anchor: '50%',
		triggerAction: 'all'
	});
	
	function printreport_customer(){

		var rpt_cust_nama="";
		var rpt_cust_kelamin="";
//		var rpt_cust_tgllahir="";
		var rpt_cust_agama="";
		var rpt_cust_statusnikah="";
		var rpt_cust_hobi="";
		var rpt_cust_kota="";
		var rpt_cust_propinsi="";
		var rpt_cust_pendidikan="";
		var rpt_cust_profesi="";
		var rpt_cust_terdaftarstart="";
		var rpt_cust_terdaftarend="";
		var rpt_cust_cabang="";
//		var customer_tanggal_akhir="";
//		var customer_carabayar="";
//		var searchrpt_customertglstart="";
//		var searchrpt_customertglend="";
//		var searchrpt_customercarabayar=null;
		var win;               
		
		if(rpt_cust_namaField.getValue()!=''){rpt_cust_nama = rpt_cust_namaField.getValue();}
		if(rpt_cust_kelaminField.getValue()!=''){rpt_cust_kelamin = rpt_cust_kelaminField.getValue();}
		if(rpt_cust_agamaField.getValue()!=''){rpt_cust_agama = rpt_cust_agamaField.getValue();}
		if(rpt_cust_statusnikahField.getValue()!=''){rpt_cust_statusnikah = rpt_cust_statusnikahField.getValue();}
		if(rpt_cust_hobiField.getValue()!=''){rpt_cust_hobi = rpt_cust_hobiField.getValue();}
		if(rpt_cust_kotaField.getValue()!=''){rpt_cust_kota = rpt_cust_kotaField.getValue();}
		if(rpt_cust_propinsiField.getValue()!=''){rpt_cust_propinsi = rpt_cust_propinsiField.getValue();}
		if(rpt_cust_pendidikanField.getValue()!=''){rpt_cust_pendidikan = rpt_cust_pendidikanField.getValue();}
		if(rpt_cust_profesiField.getValue()!=''){rpt_cust_profesi = rpt_cust_profesiField.getValue();}
		if(rpt_cust_unitField.getValue()!=''){rpt_cust_cabang = rpt_cust_unitField.getValue();}
		if(rpt_cust_terdaftarstartField.getValue()!=''){rpt_cust_terdaftarstart = rpt_cust_terdaftarstartField.getValue().format('Y-m-d');}
		if(rpt_cust_terdaftarendField.getValue()!=''){rpt_cust_terdaftarend = rpt_cust_terdaftarendField.getValue().format('Y-m-d');}
//		if(rpt_carabayarField.getValue()!==null){searchrpt_customercarabayar = rpt_carabayarField.getValue();}

		Ext.Ajax.request({   
		waitMsg: 'Please Wait...',
		url: 'index.php?c=c_report_customer&m=printreport_customer',
		params: {
		  	cust_nama : rpt_cust_nama,
			cust_kelamin : rpt_cust_kelamin,
			cust_agama : rpt_cust_agama,
			cust_statusnikah : rpt_cust_statusnikah,
			cust_hobi : rpt_cust_hobi,
			cust_kota : rpt_cust_kota,
			cust_propinsi : rpt_cust_propinsi,
			cust_pendidikan : rpt_cust_pendidikan,
			cust_profesi : rpt_cust_profesi,
			cust_cabang : rpt_cust_cabang,
			cust_terdaftarstart : rpt_cust_terdaftarstart,
			cust_terdaftarend : rpt_cust_terdaftarend
		}, 
		success: function(response){              
		  	var result=eval(response.responseText);
		  	switch(result){
		  	case 1:
				win = window.open('./report_customerlist.html','report_customerlist','height=400,width=600,resizable=1,scrollbars=1, menubar=1');
				
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
	}
	/* Enf Function */
	
	
	rpt_customerreportForm = new Ext.FormPanel({
		labelAlign: 'top',
		bodyStyle:'padding:5px',
		x:0,
		y:0,
		width: 500,
		height: 380,
		items: [{
			layout:'column',
			border:false,
			items:[{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [rpt_cust_namaField, rpt_cust_kelaminField, rpt_cust_tgllahirField, rpt_cust_agamaField, rpt_cust_statusnikahField, rpt_cust_hobiField, rpt_cust_pendidikanField] 
			},{
				columnWidth:0.5,
				layout: 'form',
				border:false,
				items: [rpt_cust_profesiField, rpt_cust_alamatGroup, rpt_cust_terdaftarGroup, rpt_cust_unitField] 
			}]
		}],
		buttons: [{
				text: 'Print',
				formBind: true,
				handler: printreport_customer
			},{
				text: 'Close',
				handler: function(){
				// because of the global vars, we can only instantiate one window... so let's just hide it.
				rpt_customerreportWindow.hide();
				mainPanel.remove(mainPanel.getActiveTab().getId());
			}
		}]
		
	});
	
	/* Form Advanced Search */
	rpt_customerreportWindow = new Ext.Window({
		title: 'Report Order Pembelian',
		closable:false,
		closeAction: 'hide',
		resizable: false,
		plain:true,
		layout: 'fit',
		x: 0,
		y: 0,
		modal: true,
		renderTo: 'elwindow_rpt_customerreport',
		items: rpt_customerreportForm
	});
	rpt_customerreportForm.getForm().load();
  	rpt_customerreportWindow.show();
  	
});
	</script>
	<div class="col">
		<div id="elwindow_rpt_customerreport"></div>
    </div>
</div>