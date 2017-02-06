<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cetak_Nota extends CI_Controller {

	
	
	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek))
		{
			$this->cart->destroy();
			$this->session->unset_userdata('limit_add_cart');
			$this->session->unset_userdata('kd_pemesan');
			$d['judul'] = 'SIM - '.$this->config->item('nama_perusahaan');
			$d['nama_perusahaan'] = $this->config->item('nama_perusahaan');
			$d['alamat_perusahaan'] = $this->config->item('alamat_perusahaan');
			$d['lisensi'] = $this->config->item('lisensi_app');
			
			$bc['menu'] = $this->load->view('app/menu', '', true);
			$bc['bio'] = $this->load->view('app/bio', $bc, true);
			
			$page=$this->uri->segment(3);
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$tot_hal = $this->app_model->manualQuery("SELECT * from tbl_pesanan_header a left join tbl_pelanggan b on a.kode_pelanggan=b.kode_pelanggan where a.jenis='Pembelian' and a.stts='Pending'");
			$config['base_url'] = base_url() . 'pemesanan/index/';
			$config['total_rows'] = $tot_hal->num_rows();
			$config['per_page'] = $limit;
			$config['uri_segment'] = 3;
			$config['first_link'] = 'Awal';
			$config['last_link'] = 'Akhir';
			$config['next_link'] = 'Selanjutnya';
			$config['prev_link'] = 'Sebelumnya';
			$this->pagination->initialize($config);
			$bc["paginator"] =$this->pagination->create_links();
			
			$bc['dt_pesanan'] = $this->app_model->manualQuery("SELECT a.kode_pesanan, b.nama_pelanggan, a.tanggal_pesanan, a.stts, a.jenis,
			(select count(kode_pesanan) as jum from tbl_pesanan_detail where kode_pesanan=a.kode_pesanan) as jumlah from tbl_pesanan_header a left join tbl_pelanggan 
			b on a.kode_pelanggan=b.kode_pelanggan where a.jenis='Pembelian' and a.stts='Pending' order by stts DESC LIMIT ".$offset.","
			.$limit."");
			
			$this->load->view('global/bg_top',$d);
			$this->load->view('cetak_nota/bg_home',$bc);
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
	
	public function edit()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek))
		{
			$bc['alert'] = "";
			$id['kode_pesanan'] = $this->uri->segment(3);
			$cek_faktur = $this->app_model->getSelectedData("tbl_faktur",$id);
			/*if($cek_faktur->num_rows()>0)
			{
				$bc['alert'] = 'return confirm(\' Faktur untuk kode pesanan : '.$id['kode_pesanan'].' telah tersimpan dan akan terhapus otomatis jika anda melakukan perubahan data pesanan. Silahkan menginputkan kembali data faktur untuk kode '.$id['kode_pesanan'].' setelah melakukan perubahan data pesanan.\');';
				$this->session->set_userdata("alert_edit","ok");
			}*/
			
			$d['judul'] = 'SIM - '.$this->config->item('nama_perusahaan');
			$d['nama_perusahaan'] = $this->config->item('nama_perusahaan');
			$d['alamat_perusahaan'] = $this->config->item('alamat_perusahaan');
			$d['lisensi'] = $this->config->item('lisensi_app');
			
			$bc['menu'] = $this->load->view('app/menu', '', true);
			$bc['bio'] = $this->load->view('app/bio', $bc, true);
			
			$bc['jdl'] = "Edit";
			$bc['kode_pesanan'] = $id['kode_pesanan'];
			$bc['dt_pelanggan'] = $this->app_model->getAllData("tbl_pelanggan");
			$bc['dt_pesanan_header'] = $this->app_model->getSelectedData("tbl_pesanan_header",$id);
			foreach($bc['dt_pesanan_header']->result() as $dph)
			{
				$sess_data['kd_pemesan'] = $dph->kode_pelanggan;
				$bc['stts'] = $dph->stts;
				$this->session->set_userdata($sess_data);
			}
			$bc['dt_pesanan_detail'] = $this->app_model->manualQuery("select a.kode_pesanan, a.kode_barang, a.qty, a.qty_terkirim, a.stts_pengiriman, a.harga_tersimpan, 
			b.nama_barang from 
			tbl_pesanan_detail a left join tbl_barang b on a.kode_barang=b.kode_barang where a.kode_pesanan='".$id['kode_pesanan']."'");
			
			
			if($this->session->userdata("limit_add_cart")=="")
			{
				$in_cart = array();
				foreach($bc['dt_pesanan_detail']->result() as $dpd)
				{
					$in_cart[] = array(
					'id'      => $dpd->kode_barang,
					'qty'     => $dpd->qty,
					'price'   => $dpd->harga_tersimpan,
					'name'    => $dpd->nama_barang,
                	'options' => array('QtyTerkirim' => $dpd->qty_terkirim, 'SttsPengiriman' => $dpd->stts_pengiriman));
				}
				$this->cart->insert($in_cart);
				$sess_data['limit_add_cart'] = "edit";
				$this->session->set_userdata($sess_data);
			}
			
			$this->load->view('global/bg_top',$d);
			$this->load->view('cetak_nota/bg_edit_pemesanan',$bc);
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
	
	public function tambah()
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
			
			$bc['jdl'] = "Tambah";
			$bc['dt_pelanggan'] = $this->app_model->getAllData("tbl_pelanggan");
			$bc['kode_pesanan'] = $this->app_model->getMaxKodePesanan();
			
			$this->load->view('global/bg_top',$d);
			$this->load->view('cetak_nota/bg_input_pembelian',$bc);
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
	
	public function daftar_barang()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek))
		{
			$bc['jdl'] = "Daftar Barang";
			$bc['dt_barang'] = $this->app_model->getAllData("tbl_barang");
			
			$this->load->view('cetak_nota/bg_daftar_barang',$bc);
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
	
	public function hapus_pesanan()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek))
		{
			$kode = explode("/",$_GET['kode']);
			if($kode[0]=="tambah")
			{
				$data = array(
				'rowid' => $kode[1],
				'qty'   => 0);
				$this->cart->update($data);
			}
			else if($kode[0]=="edit")
			{
				$data = array(
				'rowid' => $kode[1],
				'qty'   => 0);
				$this->cart->update($data);
				$hps['kode_pesanan'] = $kode[2];
				$hps['kode_barang'] = $kode[3];
				$key_barang['kode_barang'] = $hps['kode_barang'];
				$d_u['stok'] = $kode[4]+$kode[5];
				$this->app_model->deleteData("tbl_pesanan_detail",$hps);
				$this->app_model->updateData("tbl_barang",$d_u,$key_barang);
			}
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
	
	public function hapus()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek))
		{
			$hapus['kode_pesanan'] = $this->uri->segment(3);
			//kembalikan kuantitas barang
			$q = $this->app_model->getSelectedData("tbl_pesanan_detail",$hapus);
			foreach($q->result() as $d)
			{
				$data['stok'] = $d->qty+$this->app_model->getSisaStok($d->kode_barang);
				$key['kode_barang'] = $d->kode_barang;
				$this->app_model->updateData("tbl_barang",$data,$key);
			}
			$this->app_model->deleteData("tbl_pesanan_header",$hapus);
			$this->app_model->deleteData("tbl_pesanan_detail",$hapus);
			$this->app_model->deleteData("tbl_faktur",$hapus);
			$this->app_model->deleteData("tbl_surat_jalan",$hapus);
			?>
				<script> window.location = "<?php echo base_url(); ?>cetak_nota"; </script>
			<?php
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
	
	public function update_pesanan()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek))
		{
			$total = $this->cart->total_items();
			$item = $this->input->post('rowid');
			$qty = $this->input->post('qty');
			$qty_terkirim = $this->input->post('qty_terkirim');
			$status_barang = $this->input->post('status_barang');
			$stts_terkirim = $this->input->post('stts_pengiriman');
			for($i=0;$i < $total;$i++)
			{
				if($stts_terkirim[$i]=="")
				{
					$stts_terkirim[$i] = "pending";
				}
				$data = array(
				'rowid' => $item[$i],
				'qty'   => $qty[$i],
				'options'   => array('QtyTerkirim' => $qty_terkirim[$i], 'SttsPengiriman' => $stts_terkirim[$i])
				);
				$this->cart->update_options($data);
			}
			?>
			<script> window.history.go(-1); </script>
			<?php
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
	
	public function tambah_barang_pesanan()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek))
		{
			$data = array(
				'id'      => $this->input->post('kode_barang'),
				'qty'     => $this->input->post('jumlah_barang'),
				'price'   => $this->input->post('harga_barang'),
				'name'    => $this->input->post('nama_barang'),
                'options' => array('QtyTerkirim' => 0, 'SttsPengiriman' => 'pending'));
			$this->cart->insert($data);
			?>
				<script>
					window.parent.location.reload(true);
				</script>
			<?php
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
	
	public function simpan_pesanan()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek))
		{
			$d_header['kode_pesanan'] = $this->app_model->getMaxKodePesanan();
			$temp = $d_header['kode_pesanan'];
			$d_header['tanggal_pesanan'] = strtotime(date('Y-m-d H:i:s'));
			$d_header['kode_pelanggan'] = $this->session->userdata("kd_pemesan");
			$d_header['username'] = $this->session->userdata("username");
			$d_header['stts'] = $this->input->post('stts_order');
			$d_header['jenis'] = "Pembelian";
			
			$this->app_model->insertData("tbl_pesanan_header",$d_header);
			foreach($this->cart->contents() as $items)
			{
				$d_detail['kode_pesanan'] = $temp;
				$d_detail['kode_barang'] = $items['id'];
				$d_detail['qty'] = $items['qty'];
				$d_detail['harga_tersimpan'] = $items['price'];
				$this->app_model->insertData("tbl_pesanan_detail",$d_detail);
				$d_u['stok'] = $this->app_model->getBalancedStok($d_detail['kode_barang'],$d_detail['qty']);
				$key['kode_barang'] = $d_detail['kode_barang'];
				$this->app_model->updateData("tbl_barang",$d_u,$key);
			}
			$this->session->unset_userdata('kd_pemesan');
			$this->session->unset_userdata('limit_add_cart');
			$this->cart->destroy();
			header('location:'.base_url().'cetak_nota');
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
	
	public function update_pemesanan()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek))
		{
			$barang_terjual = 0;
			$id['kode_pesanan'] = $this->input->post('kode_pesanan');
			$d_header['kode_pelanggan'] = $this->session->userdata("kd_pemesan");
			$d_header['stts'] = $this->input->post('stts_order');
			
			$this->app_model->updateData("tbl_pesanan_header",$d_header,$id);
			//kembalikan kuantitas barang
			$q = $this->app_model->getSelectedData("tbl_pesanan_detail",$id);
			foreach($q->result() as $d)
			{
				$data['stok'] = $d->qty+$this->app_model->getSisaStok($d->kode_barang);
				$key['kode_barang'] = $d->kode_barang;
				$this->app_model->updateData("tbl_barang",$data,$key);
			}
			
			$this->app_model->deleteData("tbl_pesanan_detail",$id);
			foreach($this->cart->contents() as $items)
			{
				$d_detail['kode_pesanan'] = $id['kode_pesanan'];
				$d_detail['kode_barang'] = $items['id'];
				$d_detail['qty'] = $items['qty'];
				$d_detail['harga_tersimpan'] = $items['price'];
				$barang_terjual = $barang_terjual+$items['qty'];
				$d_detail['qty_terkirim'] = $items['options']['QtyTerkirim'];
				$d_detail['stts_pengiriman'] = $items['options']['SttsPengiriman'];
				$this->app_model->insertData("tbl_pesanan_detail",$d_detail);
				$d_u['stok'] = $this->app_model->getBalancedStok($d_detail['kode_barang'],$d_detail['qty']);
				$key['kode_barang'] = $d_detail['kode_barang'];
				$this->app_model->updateData("tbl_barang",$d_u,$key);
			}
			/*$cek_faktur = $this->app_model->getSelectedData("tbl_faktur",$id);
			if($cek_faktur->num_rows()>0)
			{
				$this->app_model->deleteData("tbl_faktur",$id);
			}*/
			
			$this->session->unset_userdata('kd_pemesan');
			$this->session->unset_userdata('limit_add_cart');
			$this->cart->destroy();
			header('location:'.base_url().'cetak_nota');
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
	
	public function ambil_data_barang()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek))
		{
			$data["kode_barang"] = $_GET["kode_barang"];
			$q = $this->app_model->getSelectedData("tbl_barang",$data);
			foreach($q->result() as $d)
			{
			?>
			<table cellpadding="0" cellspacing="0" border="0">
			<tr><td width="130">Kode Barang</td><td width="20">:</td><td><input type="text" value="<?php echo $d->kode_barang; ?>" class="input-read-only"
			 style="width:350px;" name="kode_barang" readonly="readonly" /></td></tr>
			<tr><td>Nama Barang</td><td>:</td><td><input type="text" value="<?php echo $d->nama_barang; ?>" class="input-read-only" style="width:350px;" name=
			"nama_barang" readonly="readonly" /></td></tr>
			<tr><td>Harga</td><td>:</td><td><input type="text" value="<?php echo $d->harga_barang; ?>" class="input-read-only" style="width:280px;" name=
			"harga_barang" id="hargabarang" readonly="readonly" /> <input type="checkbox" onclick="bolehUbah();" /> Edit Harga</td></tr>
			<tr><td>Jumlah</td><td>:</td><td>
			<select name="jumlah_barang" class="input-read-only" class="chzn-select">
			<?php
				for($i=0;$i<=$d->stok;$i++)
				{
			?>
				<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
			<?php
				}
			?>
			</select>
			</td></tr>
			</table>
			<?php
			}
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
	
	public function ambil_data_pelanggan_ajax()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek))
		{
			$data["kode_pelanggan"] = $_GET["kode_pelanggan"];
			$sess_data['kd_pemesan'] = $data["kode_pelanggan"];
			$this->session->set_userdata($sess_data);
			$q = $this->app_model->getSelectedData("tbl_pelanggan",$data);
			foreach($q->result() as $d)
			{
			?>
			<table cellpadding="5" cellspacing="0" border="0">
			<tr><td width="200">Kode Pelanggan</td><td width="20">:</td><td><input type="text" value="<?php echo $d->kode_pelanggan; ?>" class="input-read-only" readonly="true" 
			 style="width:500px;" /></td></tr>
			<tr><td>Alamat Pelanggan</td><td>:</td><td><input type="text" value="<?php echo $d->alamat; ?>" class="input-read-only" readonly="true" style="width:500px;" /></td></tr>
			<tr><td>No Telepon</td><td>:</td><td><input type="text" value="<?php echo $d->no_telp; ?>" class="input-read-only" readonly="true" style="width:500px;" /></td></tr>
			</table>
			<?php
			}
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
	
	public function ambil_data_pelanggan_session()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek))
		{
			if($this->session->userdata("kd_pemesan")!=NULL)
			{
				$data["kode_pelanggan"] = $this->session->userdata("kd_pemesan");
				$q = $this->app_model->getSelectedData("tbl_pelanggan",$data);
				foreach($q->result() as $d)
				{
					$kode_pelanggan = $d->kode_pelanggan;
					$alamat = $d->alamat;
					$no_telp = $d->no_telp;
				}
			}
			else
			{
				$kode_pelanggan = "";
				$alamat = "";
				$no_telp = "";
			}
			
			?>
			<table cellpadding="5" cellspacing="0" border="0">
			<tr><td width="200">Kode Pelanggan</td><td width="20">:</td><td><input type="text" value="<?php echo $kode_pelanggan; ?>" class="input-read-only" readonly="true" 
			 style="width:500px;" /></td></tr>
			<tr><td>Alamat Pelanggan</td><td>:</td>
			<td><input type="text" value="<?php echo $alamat; ?>" class="input-read-only" readonly="true" style="width:500px;" /></td></tr>
			<tr><td>No Telepon</td><td>:</td><td><input type="text" value="<?php echo $no_telp; ?>" class="input-read-only" readonly="true" style="width:500px;" /></td></tr>
			</table>
			<?php
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

/* End of file pemesanan.php */
/* Location: ./application/controllers/pemesanan.php */