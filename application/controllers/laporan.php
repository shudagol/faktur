<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan extends CI_Controller {


	
	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek))
		{
			$d['judul'] = 'SIM - '.$this->config->item('nama_perusahaan');
			$d['nama_perusahaan'] = $this->config->item('nama_perusahaan');
			$d['alamat_perusahaan'] = $this->config->item('alamat_perusahaan');
			$d['lisensi'] = $this->config->item('lisensi_app');
			
			$bc['menu'] = $this->load->view('app/menu', '', true);
			$bc['bio'] = $this->load->view('app/bio', $bc, true);
			
			$sess = $this->session->userdata("tipe_laporan");
			$tipe = isset($sess) ? $sess:'';
			$dt_laporan = "";
			$dt_faktur = "";
			$total_pendapatan = 0;
			if($tipe=="bulanan")
			{
				$bulan = $this->session->userdata("bulan_cari");
				$tahun = $this->session->userdata("tahun_cari");
				
				$total_pendapatan = 0;
				
				$dt_faktur = $this->app_model->manualQuery("select * from tbl_faktur where 
				SUBSTRING(DATE_FORMAT(FROM_UNIXTIME(tanggal_faktur), '%d/%m/%Y'),4,7)='".$bulan."/".$tahun."'");
				
				foreach($dt_faktur->result() as $df)
				{
					$q_detail = $this->app_model->manualQuery("select a.kode_pesanan, a.kode_barang, a.qty, b.harga_barang, b.nama_barang, a.options from 
					tbl_pesanan_detail a left join tbl_barang b on a.kode_barang=b.kode_barang where a.kode_pesanan='".$df->kode_pesanan."'");
					
					$nama_pelanggan = "";
					$detail_pelanggan = $this->app_model->manualQuery("select b.nama_pelanggan from tbl_pesanan_header a left join tbl_pelanggan b 
					on a.kode_pelanggan=b.kode_pelanggan where a.kode_pesanan='".$df->kode_pesanan."'");
					foreach($detail_pelanggan->result() as $dp)
					{
						$nama_pelanggan = $dp->nama_pelanggan;
					}
					
					$dt_laporan .= "
					<table border='1' cellpadding='0' cellspacing='0' width='100%' style=' border-collapse: collapse;' class='record' bordercolor='#ccc'>
					<tr style='background-color:#333; color:#FFFFFF;' align='center'>
						<td style='padding:5px;'>Kode Faktur</td>
						<td>Tanggal Faktur</td>
						<td>Kode Pesanan/Pembelian</td>
						<td>Nama Pelanggan</td>
					</tr>
					<tr align='center'>
						<td style='padding:5px;' width='120'>".$df->kode_faktur."</td>
						<td style='padding:5px;' width='130'>".gmdate('d/m/Y - H:i:s',$df->tanggal_faktur)."</td>
						<td style='padding:5px;' width='70'>".$df->kode_pesanan."</td>
						<td style='padding:5px;' width='200'>".$nama_pelanggan."</td>
					</tr>
					<tr>
					<td colspan=6>
						<table style='border-collapse:collapse;' bordercolor='#ccc' border='1' cellpadding='5' cellspacing='0' width='100%'>";
							$dt_laporan .= "<tr style='background-color:#666; color:#fff;' align='center'>
								<td colspan>Kode Barang</td>
								<td colspan>Nama Barang</td>
								<td colspan>Jumlah</td>
								<td colspan>Harga</td>
								<td colspan width='120'>Sub Total</td>
							</tr>";
							foreach($q_detail->result() as $qd)
							{
								$dt_laporan .= "<tr>
									<td colspan>".$qd->kode_barang."</td>
									<td colspan>".$qd->nama_barang."</td>
									<td colspan>".$qd->qty."</td>
									<td colspan>Rp. ".number_format($qd->harga_barang,2,',','.')."</td>
									<td colspan width='120'>Rp. ".number_format($qd->qty*$qd->harga_barang,2,',','.')."</td>
								</tr>";
								$total_pendapatan = $total_pendapatan+($qd->qty*$qd->harga_barang);
							}
					$dt_laporan .= "<tr>
						<td colspan='2'></td>
						<td colspan='2'>".$df->qty_barang_terjual."</td>
						<td>Rp. ".number_format($df->total_bayar,2,',','.')."</td>
					</tr>";
					$dt_laporan .= "</table>
					</td>
					</tr>
					</table>
					<div class='cleaner_h30'></div>
					";
				}
				$dt_laporan .= "<h3>Total pendapatan : Rp. ".number_format($total_pendapatan,2,',','.')."</h3>
				<h3>Periode : ".$bulan."/".$tahun."</h3>";

			}
			else if($tipe=="periodik")
			{
				$mulai = $this->session->userdata("mulai");
				$akhir = $this->session->userdata("akhir");
				
				$dt_faktur = $this->app_model->manualQuery("select * from tbl_faktur where DATE_FORMAT(FROM_UNIXTIME(tanggal_faktur-3600*7), '%d/%m/%Y') >= '".$mulai."' and 
				DATE_FORMAT(FROM_UNIXTIME(tanggal_faktur-3600*7), '%d/%m/%Y') <= '".$akhir."'");
				
				foreach($dt_faktur->result() as $df)
				{
					$q_detail = $this->app_model->manualQuery("select a.kode_pesanan, a.kode_barang, a.qty, b.harga_barang, b.nama_barang, a.options from 
					tbl_pesanan_detail a left join tbl_barang b on a.kode_barang=b.kode_barang where a.kode_pesanan='".$df->kode_pesanan."'");
					
					$nama_pelanggan = "";
					$detail_pelanggan = $this->app_model->manualQuery("select b.nama_pelanggan from tbl_pesanan_header a left join tbl_pelanggan b 
					on a.kode_pelanggan=b.kode_pelanggan where a.kode_pesanan='".$df->kode_pesanan."'");
					foreach($detail_pelanggan->result() as $dp)
					{
						$nama_pelanggan = $dp->nama_pelanggan;
					}
					
					$dt_laporan .= "
					<table border='1' cellpadding='0' cellspacing='0' width='100%' style=' border-collapse: collapse;' class='record' bordercolor='#ccc'>
					<tr style='background-color:#333; color:#FFFFFF;' align='center'>
						<td style='padding:5px;'>Kode Faktur</td>
						<td>Tanggal Faktur</td>
						<td>Kode Pesanan/Pembelian</td>
						<td>Nama Pelanggan</td>
					</tr>
					<tr align='center'>
						<td style='padding:5px;' width='120'>".$df->kode_faktur."</td>
						<td style='padding:5px;' width='130'>".gmdate('d/m/Y - H:i:s',$df->tanggal_faktur)."</td>
						<td style='padding:5px;' width='70'>".$df->kode_pesanan."</td>
						<td style='padding:5px;' width='200'>".$nama_pelanggan."</td>
					</tr>
					<tr>
					<td colspan=6>
						<table style='border-collapse:collapse;' bordercolor='#ccc' border='1' cellpadding='5' cellspacing='0' width='100%'>";
							$dt_laporan .= "<tr style='background-color:#666; color:#fff;' align='center'>
								<td colspan>Kode Barang</td>
								<td colspan>Nama Barang</td>
								<td colspan>Jumlah</td>
								<td colspan>Harga</td>
								<td colspan width='120'>Sub Total</td>
							</tr>";
							foreach($q_detail->result() as $qd)
							{
								$dt_laporan .= "<tr>
									<td colspan>".$qd->kode_barang."</td>
									<td colspan>".$qd->nama_barang."</td>
									<td colspan>".$qd->qty."</td>
									<td colspan>Rp. ".number_format($qd->harga_barang,2,',','.')."</td>
									<td colspan width='120'>Rp. ".number_format($qd->qty*$qd->harga_barang,2,',','.')."</td>
								</tr>";
								$total_pendapatan = $total_pendapatan+($qd->qty*$qd->harga_barang);
							}
					$dt_laporan .= "<tr>
						<td colspan='2'></td>
						<td colspan='2'>".$df->qty_barang_terjual."</td>
						<td>Rp. ".number_format($df->total_bayar,2,',','.')."</td>
					</tr>";
					$dt_laporan .= "</table>
					</td>
					</tr>
					</table>
					<div class='cleaner_h30'></div>
					";
				}
				$dt_laporan .= "<h3>Total pendapatan : Rp. ".number_format($total_pendapatan,2,',','.')."</h3>
				<h3>Periode : ".$mulai." sampai ".$akhir."</h3>";
			}
			
			$bc['dt_laporan'] = $dt_laporan;
			
			$this->load->view('global/bg_top',$d);
			$this->load->view('laporan/bg_home',$bc);
			$this->load->view('global/bg_footer',$d);
		}
		else
		{
			$st = $this->session->userdata('stts');
			if($st=='admin')
			{
				header('location:'.base_url().'app');
			}
			else
			{
				header('location:'.base_url().'front');
			}
		}
	}
	
	public function cetak()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek))
		{
			$d['judul'] = 'SIM - '.$this->config->item('nama_perusahaan');
			$d['nama_perusahaan'] = $this->config->item('nama_perusahaan');
			$d['alamat_perusahaan'] = $this->config->item('alamat_perusahaan');
			$d['lisensi'] = $this->config->item('lisensi_app');
			
			$sess = $this->session->userdata("tipe_laporan");
			$tipe = isset($sess) ? $sess:'';
			$dt_laporan = "";
			$dt_faktur = "";
			$total_pendapatan = 0;
			if($tipe=="bulanan")
			{
				$bulan = $this->session->userdata("bulan_cari");
				$tahun = $this->session->userdata("tahun_cari");
				
				$total_pendapatan = 0;
				
				$dt_faktur = $this->app_model->manualQuery("select * from tbl_faktur where 
				SUBSTRING(DATE_FORMAT(FROM_UNIXTIME(tanggal_faktur), '%d/%m/%Y'),4,7)='".$bulan."/".$tahun."'");
				
				foreach($dt_faktur->result() as $df)
				{
					$q_detail = $this->app_model->manualQuery("select a.kode_pesanan, a.kode_barang, a.qty, b.harga_barang, b.nama_barang, a.options from 
					tbl_pesanan_detail a left join tbl_barang b on a.kode_barang=b.kode_barang where a.kode_pesanan='".$df->kode_pesanan."'");
					
					$nama_pelanggan = "";
					$detail_pelanggan = $this->app_model->manualQuery("select b.nama_pelanggan from tbl_pesanan_header a left join tbl_pelanggan b 
					on a.kode_pelanggan=b.kode_pelanggan where a.kode_pesanan='".$df->kode_pesanan."'");
					foreach($detail_pelanggan->result() as $dp)
					{
						$nama_pelanggan = $dp->nama_pelanggan;
					}
					
					$dt_laporan .= "
					<table border='1' cellpadding='0' cellspacing='0' width='100%' style=' border-collapse: collapse;' class='record' bordercolor='#ccc'>
					<tr style='background-color:#333; color:#FFFFFF;' align='center'>
						<td style='padding:5px;'>Kode Faktur</td>
						<td>Tanggal Faktur</td>
						<td>Kode Pesanan/Pembelian</td>
						<td>Nama Pelanggan</td>
					</tr>
					<tr align='center'>
						<td style='padding:5px;' width='120'>".$df->kode_faktur."</td>
						<td style='padding:5px;' width='130'>".gmdate('d/m/Y - H:i:s',$df->tanggal_faktur)."</td>
						<td style='padding:5px;' width='70'>".$df->kode_pesanan."</td>
						<td style='padding:5px;' width='200'>".$nama_pelanggan."</td>
					</tr>
					<tr>
					<td colspan=6>
						<table style='border-collapse:collapse;' bordercolor='#ccc' border='1' cellpadding='5' cellspacing='0' width='100%'>";
							$dt_laporan .= "<tr style='background-color:#666; color:#fff;' align='center'>
								<td colspan>Kode Barang</td>
								<td colspan>Nama Barang</td>
								<td colspan>Jumlah</td>
								<td colspan>Harga</td>
								<td colspan width='120'>Sub Total</td>
							</tr>";
							foreach($q_detail->result() as $qd)
							{
								$dt_laporan .= "<tr>
									<td colspan>".$qd->kode_barang."</td>
									<td colspan>".$qd->nama_barang."</td>
									<td colspan>".$qd->qty."</td>
									<td colspan>Rp. ".number_format($qd->harga_barang,2,',','.')."</td>
									<td colspan width='120'>Rp. ".number_format($qd->qty*$qd->harga_barang,2,',','.')."</td>
								</tr>";
								$total_pendapatan = $total_pendapatan+($qd->qty*$qd->harga_barang);
							}
					$dt_laporan .= "<tr>
						<td colspan='2'></td>
						<td colspan='2'>".$df->qty_barang_terjual."</td>
						<td>Rp. ".number_format($df->total_bayar,2,',','.')."</td>
					</tr>";
					$dt_laporan .= "</table>
					</td>
					</tr>
					</table>
					<div class='cleaner_h30'></div>
					";
				}
				$dt_laporan .= "<h3>Total pendapatan : Rp. ".number_format($total_pendapatan,2,',','.')."</h3>
				<h3>Periode : ".$bulan."/".$tahun."</h3>";

			}
			else if($tipe=="periodik")
			{
				$mulai = $this->session->userdata("mulai");
				$akhir = $this->session->userdata("akhir");
				
				$dt_faktur = $this->app_model->manualQuery("select * from tbl_faktur where DATE_FORMAT(FROM_UNIXTIME(tanggal_faktur-3600*7), '%d/%m/%Y') >= '".$mulai."' and 
				DATE_FORMAT(FROM_UNIXTIME(tanggal_faktur-3600*7), '%d/%m/%Y') <= '".$akhir."'");
				
				foreach($dt_faktur->result() as $df)
				{
					$q_detail = $this->app_model->manualQuery("select a.kode_pesanan, a.kode_barang, a.qty, b.harga_barang, b.nama_barang, a.options from 
					tbl_pesanan_detail a left join tbl_barang b on a.kode_barang=b.kode_barang where a.kode_pesanan='".$df->kode_pesanan."'");
					
					$nama_pelanggan = "";
					$detail_pelanggan = $this->app_model->manualQuery("select b.nama_pelanggan from tbl_pesanan_header a left join tbl_pelanggan b 
					on a.kode_pelanggan=b.kode_pelanggan where a.kode_pesanan='".$df->kode_pesanan."'");
					foreach($detail_pelanggan->result() as $dp)
					{
						$nama_pelanggan = $dp->nama_pelanggan;
					}
					
					$dt_laporan .= "
					<table border='1' cellpadding='0' cellspacing='0' width='100%' style=' border-collapse: collapse;' class='record' bordercolor='#ccc'>
					<tr style='background-color:#333; color:#FFFFFF;' align='center'>
						<td style='padding:5px;'>Kode Faktur</td>
						<td>Tanggal Faktur</td>
						<td>Kode Pesanan/Pembelian</td>
						<td>Nama Pelanggan</td>
					</tr>
					<tr align='center'>
						<td style='padding:5px;' width='120'>".$df->kode_faktur."</td>
						<td style='padding:5px;' width='130'>".gmdate('d/m/Y - H:i:s',$df->tanggal_faktur)."</td>
						<td style='padding:5px;' width='70'>".$df->kode_pesanan."</td>
						<td style='padding:5px;' width='200'>".$nama_pelanggan."</td>
					</tr>
					<tr>
					<td colspan=6>
						<table style='border-collapse:collapse;' bordercolor='#ccc' border='1' cellpadding='5' cellspacing='0' width='100%'>";
							$dt_laporan .= "<tr style='background-color:#666; color:#fff;' align='center'>
								<td colspan>Kode Barang</td>
								<td colspan>Nama Barang</td>
								<td colspan>Jumlah</td>
								<td colspan>Harga</td>
								<td colspan width='120'>Sub Total</td>
							</tr>";
							foreach($q_detail->result() as $qd)
							{
								$dt_laporan .= "<tr>
									<td colspan>".$qd->kode_barang."</td>
									<td colspan>".$qd->nama_barang."</td>
									<td colspan>".$qd->qty."</td>
									<td colspan>Rp. ".number_format($qd->harga_barang,2,',','.')."</td>
									<td colspan width='120'>Rp. ".number_format($qd->qty*$qd->harga_barang,2,',','.')."</td>
								</tr>";
								$total_pendapatan = $total_pendapatan+($qd->qty*$qd->harga_barang);
							}
					$dt_laporan .= "<tr>
						<td colspan='2'></td>
						<td colspan='2'>".$df->qty_barang_terjual."</td>
						<td>Rp. ".number_format($df->total_bayar,2,',','.')."</td>
					</tr>";
					$dt_laporan .= "</table>
					</td>
					</tr>
					</table>
					<div class='cleaner_h30'></div>
					";
				}
				$dt_laporan .= "<h3>Total pendapatan : Rp. ".number_format($total_pendapatan,2,',','.')."</h3>
				<h3>Periode : ".$mulai." sampai ".$akhir."</h3>";
			}
			
			$bc['dt_laporan'] = $dt_laporan;
			
			$this->load->view('global/bg_top',$d);
			$this->load->view('laporan/cetak',$bc);
			$this->load->view('global/bg_footer',$d);
		}
		else
		{
			$st = $this->session->userdata('stts');
			if($st=='admin')
			{
				header('location:'.base_url().'app');
			}
			else
			{
				header('location:'.base_url().'front');
			}
		}
	}
	
	public function cari()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek))
		{
			$this->session->unset_userdata('tipe_laporan');
			$sess['tipe_laporan'] = $this->input->post("tipe_laporan");
			if($sess['tipe_laporan']=="bulanan")
			{
				$sess['bulan_cari'] = $this->input->post("bulan_cari");
				$sess['tahun_cari'] = $this->input->post("tahun_cari");
				$this->session->unset_userdata('mulai');
				$this->session->unset_userdata('akhir');
				$this->session->set_userdata($sess);
			}
			else if($sess['tipe_laporan']=="periodik")
			{
				$sess['mulai'] = $this->input->post("mulai");
				$sess['akhir'] = $this->input->post("akhir");
				$this->session->unset_userdata('bulan_cari');
				$this->session->unset_userdata('tahun_cari');
				$this->session->set_userdata($sess);
			}
			header('location:'.base_url().'laporan');
		}
		else
		{
			$st = $this->session->userdata('stts');
			if($st=='admin')
			{
				header('location:'.base_url().'app');
			}
			else
			{
				header('location:'.base_url().'front');
			}
		}
	}
}

/* End of file pelanggan.php */
/* Location: ./application/controllers/pelanggan.php */