<link href="<?php echo base_url(); ?>asset/css/chosen.css" rel="stylesheet" type="text/css">

<script>
function hitBayar(){
	var total = parseInt(document.frm.total.value);
	var bayar = parseInt(document.frm.bayar.value);
	var sisa = bayar-total;
	if(bayar<total)
	{
		document.frm.kembalian.value=0;
		document.frm.hutang.value=Math.abs(sisa)+<?php echo $hutang; ?>;
	}
	else
	{
		document.frm.kembalian.value=sisa;
		document.frm.hutang.value=<?php echo $hutang; ?>;
	}
	if(document.frm.bayar_hutang.checked==true)
	{
		bayarHutang();
	}
	document.frm.btnsimpan.disabled=false;
}
function bayarHutang(){
	var total = parseInt(document.frm.total.value);
	var bayar = parseInt(document.frm.bayar.value);
	var sisa = bayar-total;
	if(document.frm.bayar_hutang.checked==true)
	{
		if(bayar<total)
		{
			document.frm.kembalian.value=0;
			document.frm.hutang.value=Math.abs(sisa)+<?php echo $hutang; ?>;
		}
		else
		{
			var hit_hutang = sisa-<?php echo $hutang; ?>;
			var hit_hutang_tampil = Math.abs(sisa-<?php echo $hutang; ?>);
			if(<?php echo $hutang; ?>>sisa)
			{
				document.frm.hutang.value=Math.abs(sisa-<?php echo $hutang; ?>);
				document.frm.kembalian.value=0;
			}
			else
			{
				document.frm.hutang.value=0;
				document.frm.kembalian.value=hit_hutang;
			}
		}
	}
	else
	{
		if(bayar>total)
		{
			document.frm.hutang.value=<?php echo $hutang; ?>;
			document.frm.kembalian.value=sisa;
		}
		else
		{
			var hit_hutang = sisa-<?php echo $hutang; ?>;
			var hit_hutang_tampil = Math.abs(sisa-<?php echo $hutang; ?>);
			if(<?php echo $hutang; ?>>sisa)
			{
				document.frm.hutang.value=Math.abs(sisa-<?php echo $hutang; ?>);
				document.frm.kembalian.value=0;
			}
			else
			{
				document.frm.hutang.value=0;
				document.frm.kembalian.value=hit_hutang_tampil;
			}
		}
	}
}

function hitungUlang(){
	var input_tipe = document.getElementsByTagName("textarea");
	var select_tipe = document.getElementsByTagName("select");
	var arr_harga = new Array();
	var arr_jum = new Array();
	for(var j = 0; j<input_tipe.length; j++)
	{
		if (input_tipe[j].name=="harga[]"){
			arr_harga[j] = input_tipe[j].value;
		}
	}
	for(var i = 0; i<select_tipe.length; i++)
	{
		if (select_tipe[i].name=="qty_dikirim[]"){
			arr_jum[i] = select_tipe[i].value;
		}
	}
	var sum = 0;
	var jum_total =0;
	for(var k=0; k< arr_harga.length; k++) {
		sum = arr_harga[k]*arr_jum[k];
		jum_total +=arr_harga[k]*arr_jum[k];
		document.getElementById('subtotal'+k).innerHTML = addCommas(sum);
		document.getElementById('total').innerHTML = addCommas(jum_total);
		document.frm.total.value = jum_total;
	}
}

function addCommas(nStr)
{
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}

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
	<h6><?php echo $jdl; ?> Data - Faktur</h6>
		<div id="body">
		<?php echo form_open('faktur/tambah_faktur', 'name="frm"'); ?>
		<h3> Data Pelanggan & Faktur</h3>
			<table width="100%" cellpadding="3" cellspacing="0">
				<tr><td width="110">Kode Faktur</td><td width="20">:</td><td><input type="text" value="<?php echo $kode_faktur; ?>" class="input-read-only" readonly="true" 
				 style="width:280px;" name="kode_faktur" /></td>
				<td width="110">Kode Pesanan</td><td>:</td><td>
				<input type="text" value="<?php echo $kode_pesanan; ?>" class="input-read-only" readonly="true" 
				 style="width:280px;" name="kode_pesanan" /></td></tr>
				<tr><td width="110">Tanggal Faktur</td><td>:</td><td>
				<input type="text" value="<?php $gmt = time(); echo gmdate('d/m/Y H:i:s',$gmt+3600*7); ?>" class="input-read-only" readonly="true" 
				 style="width:280px;" /><input type="hidden" value="<?php echo ($gmt+3600*7); ?>" name="tanggal_faktur" />
				<td width="110">Banyak Item/Barang</td><td>:</td><td>
				<input type="text" value="<?php echo $jum_item; ?>" class="input-read-only" readonly="true" 
				 style="width:130px;" name="jum_item" />
				 <input type="text" value="<?php echo $jum_barang; ?>" class="input-read-only" readonly="true" 
				 style="width:130px;" name="qty_barang_terjual" /></td></tr>
				<tr><td width="110">Kode Pelanggan</td><td width="20">:</td><td><input type="text" value="<?php echo $kode_pelanggan; ?>" class="input-read-only" readonly="true" 
				 style="width:280px;" name="kode_pelanggan" /></td>
				<td width="110">Nama Pelanggan</td><td>:</td><td>
				<input type="text" value="<?php echo $nama_pelanggan; ?>" class="input-read-only" readonly="true" 
				 style="width:280px;" name="nama_pelanggan" /></td></tr>
				<tr><td width="110">Alamat Pelanggan</td><td>:</td><td>
				<input type="text" value="<?php echo $alamat; ?>" class="input-read-only" readonly="true" 
				 style="width:280px;" name="alamat" />
				<td width="110">No. Telepon</td><td>:</td><td>
				<input type="text" value="<?php echo $no_telp; ?>" class="input-read-only" readonly="true" 
				 style="width:280px;" name="no_telp" /></td></tr>
				<tr><td width="110">Tanggal Pesanan</td><td>:</td><td>
				<input type="text" value="<?php echo $tgl_pesanan; ?>" class="input-read-only" readonly="true" 
				 style="width:280px;" name="tanggal_pesanan" />
				<td width="110">Kota - Provinsi</td><td>:</td><td>
				<input type="text" value="<?php echo $kota_provinsi; ?>" class="input-read-only" readonly="true" 
				 style="width:280px;" name="kota_provinsi" /></td></tr>
			</table>
		<h3>Data Pesanan</h3>
			<table border="1" cellpadding="3" cellspacing="0" width="100%" style=" border-collapse: collapse;" class="record">
			<tr style="background-color:#333; color:#FFFFFF;" align="center">
				<td>No.</td>
				<td>Kode Barang</td>
				<td>Nama Barang</td>
				<td width="50" align="center">Jumlah Pesanan</td>
				<td width="50"><table width="100%"><tr><td width="50">Dikirim</td></tr></table></td>
				<td width="50" align="center">Telah Terkirim</td>
				<td>Harga</td>
				<td width="150">Sub Total</td>
			</tr>
			<?php $i = 1; $no=1; $js=0; ?>
			<?php foreach($this->cart->contents() as $items): ?>
			
			<?php echo form_hidden('rowid[]', $items['rowid']); ?>
			<tr class="content">
				
				<td class="td-keranjang"><?php echo $no; ?></td>
				<td class="td-keranjang"><?php echo $items['id']; ?></td>
				<td class="td-keranjang"><?php echo $items['name']; ?></td>
				<td class="td-keranjang" align="center"><?php echo $items['qty']; ?></td>
				<td class="td-keranjang">
				<table width="100%"><tr>
				<?php 
				$terkirim = 0;
				foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value)
				{
					switch ($option_name) {
						case "QtyTerkirim":
							echo '<td width="50">';
							$terkirim = $option_value;
							?>
							<select name="qty_dikirim[]" class="input-read-only" style="width:55px;" onchange="hitungUlang();">
								<?php
								for($j=0;$j<=$items['qty']-$terkirim;$j++)
								{
									echo "<option value='".$j."'>".$j."</option>";
								}	
								?>
							</select>
							<input type="hidden" name="qty_terkirim[]" value="<?php echo $option_value; ?>" />
							<?php
							echo '</td>';
							break;
					}
				} 
				?>
				</tr></table>
				</td>
				<td class="td-keranjang" align="center"><?php echo $terkirim; ?></td>
				<td class="td-keranjang">Rp. <textarea class="input-read-only" style="resize:none; width:80px; height:18px; font-family:Arial;" readonly="readonly" name="harga[]" /><?php echo $items['price']; ?></textarea></td>
				<td class="td-keranjang" id="subtotal<?php echo $js; ?>"></td>
			</tr>
	  	
	  	<?php $i++; $no++; $js++; ?>
		<?php endforeach; ?>
			<tr height="40">
				<td colspan="7">Total Bayar <input type="hidden" value="" name="total" /></td>
				<td id="total">Rp. </td>
			</tr>
			<tr>
				<td colspan="7">Jumlah Yang Dibayar</td>
				<td>Rp. <input type="text" class="input-read-only" style="width:110px;" name="bayar" onchange="hitBayar();" /></td>
			</tr>
			<tr>
				<td colspan="7">Kembalian | <input type="checkbox" name="bayar_hutang" id="bayar_hutang" onclick="bayarHutang();" /><label for="bayar_hutang">Bayar hutang...???</label></td>
				<td>Rp. <input type="text" class="input-read-only" readonly="true" style="width:110px;" name="kembalian" /></td>
			</tr>
			<tr>
				<td colspan="7">Hutang</td>
				<td>Rp. <input type="text" class="input-read-only" readonly="true" style="width:110px;" name="hutang" value="<?php echo $hutang; ?>" /></td>
			</tr>
			</table>
			<div class="cleaner_h10"></div>
			<input type="submit" class="btn-kirim-login" value="Simpan Dan Cetak Faktur" disabled="disabled" name="btnsimpan">
		<?php echo form_close(); ?>
		</div>
	</div>