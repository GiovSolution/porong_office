<?php
/* 	These code was generated using phpCIGen v 0.1.b (24/06/2009)
	#zaqi 		zaqi.smart@gmail.com,http://zenzaqi.blogspot.com, 
	#CV. Trust Solution, jl. Saronojiwo 19 Surabaya, http://www.ts.co.id
	
	+ Module  		: m_unit Print
	+ Description	: For Print View
	+ Filename 		: p_m_unit.php
 	+ Author  		: 
 	+ Created on 10/May/2011 17:26:04
	
*/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Highcharts lib examples</title>
	<style type="text/css">
		a, a:link, a:visited {
			color: #444;
			text-decoration: none;
		}
		a:hover {
			color: #000;
		}
		.left {
			float: left;
		}
		#menu {
			width: 20%;
		}
		#g_render {
			width: 80%;
		}
		li {
			margin-bottom: 1em;
		}
	</style>
	<!-- <script type="text/javascript" src="http://www.google.com/jsapi"></script>-->
	<script type="text/javascript" src="<?=base_url();?>assets/js/jquery-1.6.4.min.js"></script>
	<!-- <script type="text/javascript" src="../../assets/js/jquery-1.5.2.min.js">
		google.load("jquery", "1.4.4");
	</script>-->
	<!--<script type="text/javascript" src="http://www.highcharts.com/js/highcharts.js"></script>-->
    <script type="text/javascript" src="<?=base_url();?>assets/js/highcharts.js"></script>
    <!-- <script type="text/javascript" src="<?=base_url();?>assets/modules/main/js/exporting.js"></script> -->
</head>
<body>
	<div id="g_render"  class="left">
		<?php if (isset($charts)) echo $charts; ?>
		<?php if (isset($json)): ?>
			<h3>Json string output: associative array with global options and 'local options' (for each graph)</h3>
			<pre><?php echo print_r($json); ?></pre>
		<?php endif; if (isset($array)): ?>
			<h3>Array output: associative array with global options and 'local options' (for each graph)</h3>
			<pre><?php echo print_r($array); ?></pre>
		<?php endif; ?>
	</div>
</body>
</html>