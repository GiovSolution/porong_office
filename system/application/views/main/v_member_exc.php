<?
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: member View
	+ Description	: For record view
	+ Filename 		: v_member.php
 	+ Author  		: 
 	+ Created on 01/Sep/2009 10:36:44
	
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
/* declare function */		
var member_exc_add_cutomerDataStore;
var member_exc_addForm;
var member_exc_addWindow;

//declare konstant
var post2db = '';
var msg = '';
var pageS=15;

/* declare variable here for Field*/
var member_exc_add_custField;

/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
	
	/* Function ADD member tanpa transaksi */
	function member_exc_add(){
	
		if(is_member_exc_form_valid()){	
		var member_exc_add_cust=null;

		if(member_exc_add_custField.getValue()!== null){member_exc_add_cust = member_exc_add_custField.getValue();} 

		Ext.Ajax.request({  
			waitMsg: 'Please wait...',
			url: 'index.php?c=c_member_exc&m=get_action',
			params: {
				task	: 'MEMBERADD',
				member_cust	: member_exc_add_cust
			}, 
			success: function(response){             
				var result=eval(response.responseText);
				switch(result){
					case 1:
						Ext.MessageBox.alert(' OK','Customer: '+member_cust_namaField.getValue()+'<br/> telah ditambahkan.');
						member_exc_addWindow.hide();
						mainPanel.remove(mainPanel.getActiveTab().getId());
						break;
					case 2:
						Ext.MessageBox.alert(' Warning','Kartu Member dari Customer: '+member_cust_namaField.getValue()+'<br/> masih dalam proses.');
						member_exc_addWindow.hide();
						mainPanel.remove(mainPanel.getActiveTab().getId());
						break;
					default:
						Ext.MessageBox.show({
						   title: 'Warning',
						   width: 300,
						   msg: 'Customer: '+member_cust_namaField.getValue()+'<br/> telah menjadi member sebelumnya.',
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
					   msg: 'Could not connect to the database. retry later.',
					   buttons: Ext.MessageBox.OK,
					   animEl: 'database',
					   icon: Ext.MessageBox.ERROR
				});	
			}                      
		});
		} else {
			Ext.MessageBox.show({
				title: 'Warning',
				msg: 'Your Form is not valid!.',
				buttons: Ext.MessageBox.OK,
				animEl: 'save',
				icon: Ext.MessageBox.WARNING
			});
		}
	}
 	/* End of Function */
	
	/* Function for Check if the form is valid */
	function is_member_exc_form_valid(){
		return ( true  );
	}
  	/* End of Function */
  
  	/* Function for Displaying  create Window Form */
	function display_form_window(){
		if(!member_exc_addWindow.isVisible()){
			post2db='CREATE';
			msg='created';
			member_exc_reset_form();
			member_exc_addWindow.show();
		} else {
			member_exc_addWindow.toFront();
		}
	}
  	/* End of Function */
  
	//ComboBox ambil data Customer
	member_exc_add_cutomerDataStore = new Ext.data.Store({
		id: 'member_exc_add_cutomerDataStore',
		proxy: new Ext.data.HttpProxy({
			url: 'index.php?c=c_member_exc&m=get_customer_list', 
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
	//Template yang akan tampil di ComboBox
	var member_exc_add_tpl = new Ext.XTemplate(
        '<tpl for="."><div class="search-item">',
            '<span><b>{cust_no} : {cust_nama}</b> | Tgl-Lahir:{cust_tgllahir:date("M j, Y")}<br /></span>',
            'Alamat: {cust_alamat}&nbsp;&nbsp;&nbsp;[Telp. {cust_telprumah}]',
        '</div></tpl>'
    );
	
	/* Identify  member_exc_add_customer Field */
	member_exc_add_custField= new Ext.form.ComboBox({
		id: 'member_exc_add_custField',
		fieldLabel: 'Customer',
		store: member_exc_add_cutomerDataStore,
		mode: 'remote',
		displayField:'cust_nama',
		valueField: 'cust_id',
        typeAhead: false,
        loadingText: 'Searching...',
        pageSize:10,
        hideTrigger:false,
        tpl: member_exc_add_tpl,
        //applyTo: 'search',
        itemSelector: 'div.search-item',
		triggerAction: 'query',
		lazyRender:true,
		listClass: 'x-combo-list-small',
		allowBlank: true,
		anchor: '95%',
		queryDelay:1200,
		listeners:{
			/*beforequery: function(qe){
	            delete qe.combo.lastQuery;
	        },*/
			specialkey: function(f,e){
				if(e.getKey() == e.ENTER){
					member_exc_add_cutomerDataStore.load({params: {query:member_exc_add_custField.getValue()}});
	            }
			},
			render: function(c){
				Ext.get(this.id).set({qtitle:'Search By'});
				Ext.get(this.id).set({qtip:'- No.Customer<br>- Nama Customer<br>- No.Telp Rumah<br>- No.Telp Kantor<br>- No.HP'});
			}
		}
	});
	var member_cust_namaField= new Ext.form.TextField();
	
	member_exc_add_custField.on('select', function(){
		var j=member_exc_add_cutomerDataStore.findExact('cust_id',member_exc_add_custField.getValue(),0);
		if(member_exc_add_cutomerDataStore.getCount()){
			member_cust_namaField.setValue(member_exc_add_cutomerDataStore.getAt(j).data.cust_nama);
		}
	});

	
	/* Function for retrieve create Window Panel*/ 
	member_exc_addForm = new Ext.FormPanel({
		labelAlign: 'left',
		labelWidth: 120,
		bodyStyle:'padding:5px',
		autoHeight:true,
		layout: 'column',
		width: 400,        
		items:[
			{
				columnWidth:1,
				layout: 'form',
				border:false,
				items: [member_exc_add_custField] 
			}
			],
		buttons: [{
				text: 'Save and Close',
				handler: member_exc_add
			}
			,{
				text: 'Cancel',
				handler: function(){
					member_exc_addWindow.hide();
					mainPanel.remove(mainPanel.getActiveTab().getId());
				}
			}
		]
	});
	/* End  of Function*/
	
	/* Function for retrieve create Window Form */
	member_exc_addWindow= new Ext.Window({
		id: 'member_exc_addWindow',
		title: 'Add Member',
		closable:true,
		closeAction: 'hide',
		autoWidth: true,
		autoHeight: true,
		x:0,
		y:0,
		plain:true,
		layout: 'fit',
		modal: true,
		renderTo: 'elwindow_member_exc_add',
		items: member_exc_addForm
	});
	/* End Window */
	member_exc_addWindow.show();
	
	
});
	</script>
<body>
<div>
	<div class="col">
		<div id="elwindow_member_exc_add"></div>
    </div>
</div>
</body>