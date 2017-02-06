

<script src="<?php echo base_url(); ?>asset/js/menu.js" type="text/javascript"></script>
<link href="<?php echo base_url(); ?>asset/css/menu.css" rel="stylesheet" type="text/css" />
<div id="menu">
	<div id="MainMenu">
		<div id="Menu">
			<div class="suckertreemenu">
				<ul id="treemenu1">
					<li><a href="<?php echo base_url(); ?>app/">Home</a></li>
					<li><a href="<?php echo base_url(); ?>barang">Master Barang</a></li>
					<li><a href="<?php echo base_url(); ?>pelanggan">Master Pelanggan</a></li>
					<li><a href="<?php echo base_url(); ?>suplier">Master Suplier</a></li>
					<li><a href="#">Manajemen Pemesanan</a>
						<ul>
							<li><a href="<?php echo base_url(); ?>pemesanan/pending">Pesanan Pending</a></li>
							<li><a href="<?php echo base_url(); ?>pemesanan/ok">Pesanan Ok</a></li>
						</ul>
					</li>
					<li><a href="<?php echo base_url(); ?>faktur">Manajemen Faktur Penjualan</a></li>
					<li><a href="<?php echo base_url(); ?>grafik">Grafik</a></li>
					<!-- <li><a href="<?php echo base_url(); ?>cetak_nota">Manajemen Cetak Nota</a></li> -->
					<!-- <li><a href="<?php echo base_url(); ?>laporan">Manajemen Laporan</a></li> -->
					<li><a href="#">Setting</a>
						<ul>
							<li><a href="<?php echo base_url(); ?>user">User / Pengguna</a></li>
							<li><a href="<?php echo base_url(); ?>backup">Backup Data</a></li>
							<li><a href="<?php echo base_url(); ?>restore">Restore Data</a></li>
						</ul>
					</li>
					<li><a href="<?php echo base_url(); ?>front/logout">Log Out</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="cleaner_h0"></div>
</div>