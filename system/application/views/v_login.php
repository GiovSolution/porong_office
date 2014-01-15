<html>
<head>
<title>Welcome | Porong Wei - Information System</title>
<link rel="shortcut icon" href="<?=base_url();?>favicon.ico" />
<?=css_asset('ext-all.css');?>
<?=css_asset('xtheme-slate.css');?>
<?=js_asset('ext-base.js');?>
<?=js_asset('ext-all.js');?>
<script type="text/javascript">
	var s = document.createElement("script");
	s.type = 'text/javascript';
	s.src = "<?=base_url();?>/assets/js/locale/ext-lang-id.js";
	s.charset = "ascii";
	document.getElementsByTagName("head")[0].appendChild(s);
</script>
<?=js_asset('PagingMemoryProxy.js');?>
<?=js_asset('login.js','login');?>
</head>
<?php if(file_exists("./uploads/".$background) && $background!==""){?>
<body background="./uploads/background.jpg"></body>
<?php }else {?>
<body background="./assets/wallpapers/desktop.jpg"></body>
<?php } ?>
</html>