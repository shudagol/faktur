<!DOCTYPE html>
<link href="<?php echo base_url(); ?>/asset/css/style.css" rel="stylesheet">
<div id="container">
	<h1><?php echo $nama_perusahaan; ?> - FAKTUR PEMBELIAN</h1>
	<h2><?php echo $alamat_perusahaan; ?></h2>

	<div id="body">
		<div id="body">
			<table width="100%" cellpadding="3" cellspacing="0">
				<tr><td width="110">Kode Faktur</td><td width="20">:</td><td><input type="text" value="<?php echo $kode_faktur; ?>" class="input-read-only" readonly="true" 
				 style="width:280px;" name="kode_faktur" /></td>
				<td width="110">Kode Pesanan</td><td>:</td><td>
				<input type="text" value="<?php echo $kode_pesanan; ?>" class="input-read-only" readonly="true" 
				 style="width:280px;" name="kode_pesanan" /></td></tr>
				<tr><td width="110">Tanggal Faktur</td><td>:</td><td>
				<input type="text" value="<?php echo $tanggal_faktur; ?>" class="input-read-only" readonly="true" 
				 style="width:280px;" /><input type="hidden" value="<?php echo ($tanggal_faktur); ?>" name="tanggal_faktur" />
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
			<div class="cleaner_h5"></div>
			<table border="1" cellpadding="4" cellspacing="0" width="100%" style=" border-collapse: collapse;" class="record">
			<tr style="background-color:#333; color:#FFFFFF;" align="center">
				<td>No.</td>
				<td>Kode Barang</td>
				<td>Nama Barang</td>
				<td>Jumlah Pesanan</td>
				<td width="150"><table width="100%"><tr><td width="100">Status Barang</td><td width="50">Terkirim</td></tr></table></td>
				<td>Harga</td>
				<td width="180">Sub Total</td>
			</tr>
			<?php $i = 1; $no=1;?>
			<?php 
			$total = 0;
			foreach($this->cart->contents() as $items): ?>
			
			<?php echo form_hidden('rowid[]', $items['rowid']); ?>
			<tr class="content">
				
				<td class="td-keranjang"><?php echo $no; ?></td>
				<td class="td-keranjang"><?php echo $items['id']; ?></td>
				<td class="td-keranjang"><?php echo $items['name']; ?></td>
				<td class="td-keranjang"><?php echo $items['qty']; ?></td>
				<td class="td-keranjang">
				<table width="100%"><tr>
				<?php 
				$terkirim = 0;
				foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value)
				{
					switch ($option_name) {
						case "StatusBarang":
							echo '<td width="100">'.$option_value.'</td>';
							break;
						case "QtyTerkirim":
							$terkirim = $option_value;
							echo '<td width="50">'.$option_value.'</td>';
							break;
					}
				} 
				?>
				</tr></table>
				</td>
				<td class="td-keranjang">Rp. <?php echo $this->cart->format_number($items['price']); ?></td>
				<td class="td-keranjang">Rp. <?php echo $this->cart->format_number($items['price']*$terkirim); ?></td>
			</tr>
	  	
	  	<?php 
		$total += $items['price']*$terkirim;
		$i++; $no++;?>
		<?php endforeach; ?>
			<tr>
				<td colspan="6">Total Bayar</td>
				<td>Rp. <?php echo $this->cart->format_number($total); ?><input type="hidden" value="<?php echo $total; ?>" name="total" /></td>
			</tr>
			<tr>
				<td colspan="6">Jumlah Yang Dibayar</td>
				<td>Rp. <?php echo number_format($bayar,2,'.',','); ?></td>
			</tr>
			<tr>
				<td colspan="6">Kembalian</td>
				<td>Rp. <?php echo number_format($sisa_bayar,2,'.',','); ?></td>
			</tr>
			</table>
			<div class="cleaner_h10"></div>
		</div>
	</div>