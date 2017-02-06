<div id="container">
	<h1><?php echo $nama_perusahaan; ?></h1>
	<h2><?php echo $alamat_perusahaan; ?></h2>

	<div id="body">
		<?php
			echo $bio;
			echo $menu;
		?>
		<div class="cleaner_h0"></div>
		
		<div id="list">
			<ul>
				<li><strong>Master Barang</strong><br />Berfungsi untuk mengelola data barang (tambah, edit, hapus) yang tersimpan di dalam database</li>
				<li><strong>Master Pelanggan</strong><br />Berfungsi untuk mengelola data pelanggan (tambah, edit, hapus) yang tersimpan di dalam database</li>
				<li><strong>Manajemen Pemesanan</strong><br />Berfungsi untuk mengelola data pesanan (tambah, edit, hapus) yang tersimpan di dalam database</li>
				<li><strong>Manajemen Faktur Penjualan</strong><br />Berfungsi untuk mencetak faktur</li>
				<li><strong>Setting/Pengaturan</strong><br />Berfungsi untuk kelola user dan backup data</li>
				<li><strong>Log Out</strong><br />Keluar dari sistem aplikasi</li>
			</ul>
		</div>
	</div>
