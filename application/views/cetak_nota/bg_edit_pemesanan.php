
<link href="<?php echo base_url(); ?>asset/css/chosen.css" rel="stylesheet" type="text/css">
<div id="container">
	<h1><?php echo $nama_perusahaan; ?></h1>
	<h2><?php echo $alamat_perusahaan; ?></h2>

	<div id="body">
		<?php
			echo $bio;
			echo $menu;
		?>
		<div class="cleaner_h10"></div>
	<h6><?php echo $jdl; ?> Data - Pembelian</h6>
		<div id="body">
		<h3> Data Pelanggan</h3>
			<table width="100%" cellpadding="3" cellspacing="0">
				<tr><td width="130">Kode Pesanan</td><td width="20">:</td><td><input type="text" value="<?php echo $kode_pesanan; ?>" class="input-read-only" readonly="true" 
				 style="width:350px;" name="kode_pesanan" /></td></tr>
				<tr><td width="180">Nama Pelanggan</td><td>:</td><td>
				<select data-placeholder="Cari nama pelanggan..." class="chzn-select" style="width:500px;" tabindex="2" name="kode_pelanggan" id="kode_pelanggan">
          		<option value=""></option> 
					<?php
						foreach($dt_pelanggan->result_array() as $dp)
						{
						$pilih='';
						if($dp['kode_pelanggan']==$this->session->userdata("kd_pemesan"))
						{
						$pilih='selected="selected"';
					?>
						<option value="<?php echo $dp['kode_pelanggan']; ?>" <?php echo $pilih; ?>><?php echo $dp['nama_pelanggan']; ?></option>
					<?php
					}
					else
					{
					?>
						<option value="<?php echo $dp['kode_pelanggan']; ?>"><?php echo $dp['nama_pelanggan']; ?></option>
					<?php
					}
						}
					?>
				</select>
				</td></tr>
				<tr><td colspan="4"><div id="data_pelanggan"></div></td></tr>
			</table>
			
		<h3>Data Pesanan</h3>
			<?php echo form_open('cetak_nota/update_pesanan'); ?>
			<table border="1" cellpadding="3" cellspacing="0" width="100%" style=" border-collapse: collapse;" class="record">
			<tr style="background-color:#333; color:#FFFFFF;" align="center">
				<td>No.</td>
				<td>Kode Barang</td>
				<td>Nama Barang</td>
				<td>Jumlah Pesanan</td>
				<td width="180">Status Barang | Jumlah Terkirim</td>
				<td width="100">Harga</td>
				<td width="100">Sub Total</td>
				<td width="130"><a href="<?php echo base_url(); ?>pemesanan/daftar_barang" class="cblsbarang"><div class="btn-add">Tambah Pesanan</div></a></td>
			</tr>
			<?php $i = 1; $no=1; ?>
			<?php foreach($this->cart->contents() as $items): ?>
			
			<?php echo form_hidden('rowid[]', $items['rowid']); ?>
			<tr class="content">
				
				<td class="td-keranjang"><?php echo $no; ?></td>
				<td class="td-keranjang"><?php echo $items['id']; ?><input type="hidden" name="kode_barang[]" value="<?php echo $items['id']; ?>" /></td>
				<td class="td-keranjang"><?php echo $items['name']; ?></td>
				<td class="td-keranjang">
				<select name="qty[]" class="input-read-only" style="width:70px;">
					<?php 
					echo "<option selected>".$items['qty']."</option>";
					for($i=0;$i<=$this->app_model->getSisaStok($items['id']);$i++)
					{
						echo "<option>".$i."</option>";
					}	
					?>
				</select>
				</td>
				<td class="td-keranjang">
				<?php foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value)
				{
					switch ($option_name) {
						case "StatusBarang":
							?>
							<select name="status_barang[]" class="input-read-only" style="width:85px;">
										<?php if($option_value=="Pending") { ?>
											<option value="Pending" selected="selected">Pending</option>
											<option value="Ready">Ready</option>
										<?php } else if($option_value=="Ready") { ?>
											<option value="Pending">Pending</option>
											<option value="Ready" selected="selected">Ready</option>
								<?php } ?>
							</select>
							<?php
							break;
						case "QtyTerkirim":
							?>
							<select name="qty_terkirim[]" class="input-read-only" style="width:85px;">
								<?php
								echo "<option selected>".$option_value."</option>";
								for($j=0;$j<=$this->app_model->getSisaStok($items['id']);$j++)
								{
									echo "<option>".$j."</option>";
								}	
								?>
							</select>
							<?php
							break;
						case "SttsPengiriman":
							if($option_value=="terkirim")
							{
							?>
							<input type="checkbox" value="terkirim" name="stts_pengiriman[]" checked="checked" />Barang Terkirim
							<?php
							}
							else
							{
							?>
							<input type="checkbox" value="terkirim" name="stts_pengiriman[]" />Barang Terkirim
							<?php
							}
							break;
					}
				} 
				?>
				</td>
				
				<td class="td-keranjang">Rp. <?php echo $this->cart->format_number($items['price']); ?></td>
				<td class="td-keranjang">Rp. <?php echo $this->cart->format_number($items['subtotal']); ?></td>
				<td class="td-keranjang" align="center">
				<a href="#" class="delbutton" id="<?php echo 'edit/'.$items['rowid'].'/'.$kode_pesanan.'/'.$items['id'].'/'.$this->app_model->getSisaStok($items['id']).'/'.$items['qty']; ?>">
				<div class="btn-delete">Hapus Pesanan</div></a></td>
			</tr>
	  	
	  	<?php $i++; $no++; ?>
		<?php endforeach; ?>
			<tr>
				<td colspan="6">Total</td>
				<td>Rp. <?php echo $this->cart->format_number($this->cart->total()); ?></td>
				<td><input type="submit" class="btn-add" value="Save"></td>
			</tr>
			</table>
			<?php echo form_close(); ?>
			<div class="cleaner_h10"></div>
			
		<?php $atr = array('name' => 'frm', 'id' => 'frm', 'onSubmit' => $alert); echo form_open('cetak_nota/update_pemesanan',$atr); ?>
		<input type="hidden" value="<?php echo $kode_pesanan; ?>" name="kode_pesanan">
				<input type="hidden" name="stts_order" value="Ok" />
			<div class="cleaner_h10"></div>
			<input type="submit" class="btn-kirim-login" value="Simpan Data Pesanan" onclick="tanda();">
			<script src="<?php echo base_url(); ?>asset/js/chosen.jquery.js" type="text/javascript"></script>
			<script type="text/javascript"> $(".chzn-select").chosen().change(function(){ 
						var kode_pelanggan = $("#kode_pelanggan").val(); 
						$.ajax({ 
						url: "<?php echo base_url(); ?>pemesanan/ambil_data_pelanggan_ajax", 
						data: "kode_pelanggan="+kode_pelanggan, 
						cache: false, 
						success: function(msg){ 
						$("#data_pelanggan").html(msg); 
					} 
				})
				});
				$('#data_pelanggan').load('<?php echo base_url(); ?>pemesanan/ambil_data_pelanggan_session');
				
				$(document).ready(function() {
					$(".delbutton").click(function(){
					 var element = $(this);
					 var del_id = element.attr("id");
					 var info = del_id;
					 if(confirm("Anda yakin akan menghapus?"))
					 {
							 $.ajax({
							 url: "<?php echo base_url(); ?>pemesanan/hapus_pesanan", 
							 data: "kode="+info, 
							 cache: false, 
							 success: function(){
							 }
						 });	
					 	$(this).parents(".content").animate({ opacity: "hide" }, "slow");
						}
					 return false;
					 });
				})
			</script>
		<?php echo form_close(); ?>
		</div>
	</div>