
				<tr><td width="110">Tanggal Faktur</td><td>:</td><td>
				<input type="text" value="<?php $gmt = time(); echo gmdate('d/m/Y H:i:s',$gmt+3600*7); ?>" class="input-read-only" readonly="true" 
				 style="width:280px;" /><input type="hidden" value="<?php echo ($gmt+3600*7); ?>" name="tanggal_faktur" />
				<td width="110">Banyak Item/Barang</td><td>:</td><td>
				<input type="text" value="<?php echo $bc['jum_item']; ?>" class="input-read-only" readonly="true" 
				 style="width:130px;" name="jum_item" />
				 <input type="text" value="<?php echo $bc['jum_barang']; ?>" class="input-read-only" readonly="true" 
				 style="width:130px;" name="qty_barang_terjual" /></td></tr>
				<tr><td width="110">Kode Pelanggan</td><td width="20">:</td><td><input type="text" value="<?php echo $bc['kode_pelanggan']; ?>" class="input-read-only" readonly=
				"true" style="width:280px;" name="kode_pelanggan" /></td>
				<td width="110">Nama Pelanggan</td><td>:</td><td>
				<input type="text" value="<?php echo $bc['nama_pelanggan']; ?>" class="input-read-only" readonly="true" 
				 style="width:280px;" name="nama_pelanggan" /></td></tr>
				<tr><td width="110">Alamat Pelanggan</td><td>:</td><td>
				<input type="text" value="<?php echo $bc['alamat']; ?>" class="input-read-only" readonly="true" 
				 style="width:280px;" name="alamat" />
				<td width="110">No. Telepon</td><td>:</td><td>
				<input type="text" value="<?php echo $bc['no_telp']; ?>" class="input-read-only" readonly="true" 
				 style="width:280px;" name="no_telp" /></td></tr>
				<tr><td width="110">Tanggal Pesanan</td><td>:</td><td>
				<input type="text" value="<?php echo $bc['tgl_pesanan']; ?>" class="input-read-only" readonly="true" 
				 style="width:280px;" name="tanggal_pesanan" />
				<td width="110">Kota - Provinsi</td><td>:</td><td>
				<input type="text" value="<?php echo $bc['provinsi']; ?>" class="input-read-only" readonly="true" 
				 style="width:280px;" name="kota_provinsi" /></td></tr>
			</table>
		<h3>Data Pesanan</h3>
			<table border="1" cellpadding="7" cellspacing="0" width="100%" style=" border-collapse: collapse;" class="record">
			<tr style="background-color:#333; color:#FFFFFF;" align="center">
				<td>No.</td>
				<td>Kode Barang</td>
				<td>Nama Barang</td>
				<td>Jumlah Pesanan</td>
				<td>Harga</td>
				<td width="180">Sub Total</td>
			</tr>
			<?php $i = 1; $no=1;?>
			<?php foreach($this->cart->contents() as $items): ?>
			
			<?php echo form_hidden('rowid[]', $items['rowid']); ?>
			<tr class="content">
				
				<td class="td-keranjang"><?php echo $no; ?></td>
				<td class="td-keranjang"><?php echo $items['id']; ?></td>
				<td class="td-keranjang"><?php echo $items['name']; ?></td>
				<td class="td-keranjang"><?php echo $items['qty']; ?></td>
				<td class="td-keranjang">Rp. <?php echo $this->cart->format_number($items['price']); ?></td>
				<td class="td-keranjang">Rp. <?php echo $this->cart->format_number($items['subtotal']); ?></td>
			</tr>
	  	
	  	<?php $i++; $no++;?>
		<?php endforeach; ?>
			<tr>
				<td colspan="5">Total Bayar</td>
				<td>Rp. <?php echo $this->cart->format_number($this->cart->total()); ?><input type="hidden" value="<?php echo $this->cart->total(); ?>" name="total" /></td>
			</tr>
			<tr>
				<td colspan="5">Jumlah Yang Dibayar</td>
				<td>Rp. <input type="text" class="input-read-only" style="width:140px;" name="bayar" onchange="hitBayar();" /></td>
			</tr>
			<tr>
				<td colspan="5">Kembalian | <input type="checkbox" name="bayar_hutang" id="bayar_hutang" onclick="bayarHutang();" /><label for="bayar_hutang">Bayar hutang...???</label></td>
				<td>Rp. <input type="text" class="input-read-only" readonly="true" style="width:140px;" name="kembalian" /></td>
			</tr>
			<tr>
				<td colspan="5">Hutang</td>
				<td>Rp. <input type="text" class="input-read-only" readonly="true" style="width:140px;" name="hutang" value="<?php echo $hutang; ?>" /></td>
			</tr>
			</table>
			<div class="cleaner_h10"></div>
			<input type="submit" class="btn-kirim-login" value="Simpan Dan Cetak Faktur">