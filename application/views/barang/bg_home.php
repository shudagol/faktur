<style>
.editbox
{
display:none
}
td
{
padding:5px;
}
.editbox
{
font-size:14px;
width:70px;
background-color:#ffffcc;
border:solid 1px #000;
padding:4px;
}
.edit_tr:hover
{
cursor:pointer;
}
</style>


<script type="text/javascript">
$(document).ready(function()
{
	$(".edit_tr").click(function()
	{
	var ID=$(this).attr('id');
		$("#stok_"+ID).hide();
		$("#stok_input_"+ID).show();
	}).change(function()
	{
	var ID=$(this).attr('id');
	var first=$("#stok_input_"+ID).val();
	var dataString = 'kode_data='+ ID +'|'+first;
	$("#stok_"+ID).html('<img src="<?php echo base_url(); ?>asset/images/load.gif" />');
		if(first.length>0)
		{
			$.ajax({
				type: "GET",
				url: "<?php echo base_url(); ?>barang/simpan_input_inline",
				data: dataString,
				cache: false,
				success: function(html)
				{
					$("#stok_"+ID).html(first);
				}
			});
		}
		else
		{
			alert('Inputan masih kosong');
		}
	});
	
	$(".editbox").mouseup(function() 
	{
		return false
	});
	
	$(document).mouseup(function()
	{
		$(".editbox").hide();
		$(".text").show();
	});

});
</script>
<div id="container">
	<h1><?php echo $nama_perusahaan; ?></h1>
	<h2><?php echo $alamat_perusahaan; ?></h2>

	<div id="body">
		<?php
			echo $bio;
			echo $menu;
		?>
		<div class="cleaner_h10"></div>
		<table align="center">
			<tr align="center">
				<td>
					<?php
						echo $paginator;
					?>
				</td>
			</tr>
		</table>
		<div class="cleaner_h10"></div>
		<table border="1" cellpadding="3" cellspacing="0" width="100%" style=" border-collapse: collapse;" class="record" bordercolor="#CCCCCC">
			<tr style="background-color:#000000; color:#FFFFFF;" align="center"><td colspan="8" height="25">MASTER BARANG</td></tr>
			<tr style="background-color:#333; color:#FFFFFF;" align="center">
				<td>Kode Barang</td>
				<td>Nama Barang</td>
				<td width="80">Stok Barang Di Suplier</td>
				<td>Harga Beli</td>
				<td>Suplier</td>
				<td>Harga Jual</td>
				<td colspan="2"><a href="<?php echo base_url(); ?>barang/tambah" class="cbbarang"><div class="btn-add">Tambah Data</div></a></td>
			</tr>
			<?php
				if($dt_barang->num_rows()>0)
				{
					foreach($dt_barang->result_array() as $db)
					{
				?>
				<tr id="<?php echo $db['kode_barang']; ?>" class="edit_tr">
					<td><?php echo $db['kode_barang']; ?></td>
					<td><?php echo $db['nama_barang']; ?></td>
					<td class="edit_td">
					
					<span id="stok_<?php echo $db['kode_barang']; ?>" class="text"><?php echo $db['stok']; ?></span> 
					<input type="text" value="<?php echo $db['stok']; ?>" class="editbox" id="stok_input_<?php echo $db['kode_barang']; ?>"/>

					</td>
					<td>Rp. <?php echo number_format($db['harga_beli'],2,',','.'); ?></td>
					<td><?php echo $db['nama_suplier']; ?></td>
					<td>Rp. <?php echo number_format($db['harga_barang'],2,',','.'); ?></td>
					<td width="90"><a href="<?php echo base_url(); ?>barang/edit/<?php echo $db['kode_barang']; ?>" class="cbbarang"><div class="btn-edit">Edit Data</div></a></td>
					<td width="100"><a href="<?php echo base_url(); ?>barang/hapus/<?php echo $db['kode_barang']; ?>" onclick="return confirm('Anda yakin?');"><div class=
					"btn-delete">Hapus Data</div></a></td>
				</tr>
				<?php
					}
				}
				else
				{
					?>
					
				<tr style="text-align:center;">
					<td colspan="6">Belum ada data</td>
				</tr>
					<?php
				}
			?>
		</table>
		<div class="cleaner_h10"></div>
		<table align="center">
			<tr align="center">
				<td>
					<?php
						echo $paginator;
					?>
				</td>
			</tr>
		</table>
	</div>
