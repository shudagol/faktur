<script>
	window.print();
</script>
<link href="<?php echo base_url(); ?>asset/css/chosen.css" rel="stylesheet" type="text/css">
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/themes/redmond/jquery-ui.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript">
	$(function(){
		$('#mulai').datepicker({dateFormat: 'dd/mm/yy'});
		$('#akhir').datepicker({dateFormat: 'dd/mm/yy'});
	});
</script>
<div id="container">
	<h1><?php echo $nama_perusahaan; ?></h1>
	<h2><?php echo $alamat_perusahaan; ?></h2>

	<div id="body">
		<div style="float:left; width:48%; padding:5px;">
		<h3>Laporan Bulanan</h3>
		<?php echo form_open("laporan/cari"); ?>
		Bulan : 
			<select name="bulan_cari" class="chzn-select" data-placeholder="Pilih bulan..." style="width:110px;">
				<option value=""></option>
				<?php for($i=1;$i<=12;$i++) {
					$i_length=strlen($i);
					if ($i_length==1)
					{
						$i="0".$i;
					}
					else
					{
						$i=$i;
					}
					if($i==$this->session->userdata("bulan_cari"))
					{
				?>
						<option value="<?php echo $i; ?>" selected="selected"><?php echo $i; ?></option>
				<?php }
					else
					{
					?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php
					}
					} ?>
			</select>
		Tahun :
			<select name="tahun_cari" class="chzn-select" data-placeholder="Pilih tahun..." style="width:110px;">
				<option value=""></option>
				<?php for($j=2010;$j<=date('Y');$j++) { 
					if($j==$this->session->userdata("tahun_cari"))
					{
					?>
						<option value="<?php echo $j; ?>" selected="selected"><?php echo $j; ?></option>
					<?php 
					}
					else
					{
					?>
						<option value="<?php echo $j; ?>"><?php echo $j; ?></option>
				<?php 
					}
				} ?>
			</select>
			<input type="hidden" name="tipe_laporan" value="bulanan" />
			<input type="submit" value="Cari" class="btn-kirim-login" />
			<script src="<?php echo base_url(); ?>asset/js/chosen.jquery.js" type="text/javascript"></script>
			<script type="text/javascript"> 
				$(".chzn-select").chosen();
			</script>
		<?php echo form_close(); ?>
		</div>
		
		
		<div style="float:right; width:48%; padding:5px;">
		<h3>Laporan Periodik</h3>
		<?php echo form_open("laporan/cari"); ?>
		Dari : 
		<input type="text" class="input-read-only" name="mulai" id="mulai" style="width:80px;" autocomplete="off" value="<?php echo $this->session->userdata("mulai"); ?>" />
		Sampai : 
		<input type="text" class="input-read-only" name="akhir" id="akhir" style="width:80px;" autocomplete="off" value="<?php echo $this->session->userdata("akhir"); ?>" />
			<input type="hidden" name="tipe_laporan" value="periodik" />
			
			<input type="submit" value="Cari" class="btn-kirim-login" />
			<script src="<?php echo base_url(); ?>asset/js/chosen.jquery.js" type="text/javascript"></script>
			<script type="text/javascript"> 
				$(".chzn-select").chosen();
			</script>
		<?php echo form_close(); ?>
		</div>
		
		<div class="cleaner_h10"></div>
		
		
			<?php
				echo $dt_laporan;
			?>
		</table>
		<div class="cleaner_h10"></div>
	</div>
