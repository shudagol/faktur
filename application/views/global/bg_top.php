<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $judul; ?></title>
	<link href="<?php echo base_url(); ?>asset/css/style.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url(); ?>asset/colorbox/colorbox.css" />
	<script>!window.jQuery && document.write('<script src="<?php echo base_url(); ?>asset/js/jquery.min.js"><\/script>');</script>
	<script src="<?php echo base_url(); ?>asset/colorbox/jquery.colorbox.js"></script>
	<script src="<?php echo base_url(); ?>asset/js/highcharts.js"></script>
	<script src="<?php echo base_url(); ?>asset/js/exporting.js"></script>
	<script>
		  $(document).ready(function(){
			  //Examples of how to assign the ColorBox event to elements
			  $(".cbbarang").colorbox({rel:'group', iframe:true, width:"700", height:"500"});
			  $(".cbpelanggan").colorbox({rel:'group', iframe:true, width:"700", height:"90%"});
			  $(".cblsbarang").colorbox({rel:'group', iframe:true, width:"700", height:"60%"});
			  $(".cbuser").colorbox({rel:'group', iframe:true, width:"700", height:"60%"});
	
		  });
	</script>
</head>
<body>