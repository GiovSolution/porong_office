<?
/* 	
	+ Module  		: UserManual View
	+ Description	: For record view
	+ Filename 		: v_usermanual.php
 	+ Author  		: Fred

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

//var menuListEditorGrid;

//declare konstant
var post2db = '';
var msg = '';
var pageS=15;



/* on ready fuction */
Ext.onReady(function(){
  	Ext.QuickTips.init();	/* Initiate quick tips icon */
  	

	/* Declare DataStore and  show datagrid list */
	/*menuListEditorGrid =  new Ext.grid.EditorGridPanel({
		id: 'menuListEditorGrid',
		el: 'fp_bank',
		title: 'Daftar Golongan',
		autoHeight: true,
		enableColLock:false,
		frame: true,
		clicksToEdit:2, // 2xClick untuk bisa meng-Edit inLine Data
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		viewConfig: { forceFit:true },
	  	width: 350,
		tbar: [
		{
			text: 'Refresh',
			tooltip: 'Refresh datagrid',
			handler : function(){window.open("../Add-on/help/mis_help.htm")} 
		}
		]
	});*/

	window.open("http://192.168.1.2:81/mis_helpdesk/?c=main")
	mainPanel.remove(mainPanel.getActiveTab().getId());


});
	</script>
<body>
<div>
	<div class="col">
        <div id="fp_bank"></div>
    </div>
</div>
</body>