<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Faktur extends CI_Controller {

	
	
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
			
			$tot_hal = $this->app_model->manualQuery("SELECT * from tbl_faktur a left join tbl_pesanan_header b on a.kode_pesanan=b.kode_pesanan");
			$config['base_url'] = base_url() . 'faktur/index/';
			$config['total_rows'] = $tot_hal->num_rows();
			$config['per_page'] = $limit;
			$config['uri_segment'] = 3;
			$config['first_link'] = 'Awal';
			$config['last_link'] = 'Akhir';
			$config['next_link'] = 'Selanjutnya';
			$config['prev_link'] = 'Sebelumnya';
			$this->pagination->initialize($config);
			$bc["paginator"] =$this->pagination->create_links();
			
			$bc['dt_pesanan'] = $this->app_model->manualQuery("SELECT a.kode_faktur, a.kode_pesanan, b.nama_pelanggan, a.tanggal_faktur, 
			a.qty_barang_terjual, a.total_barang, a.total_bayar, b.kode_pelanggan  from tbl_faktur a left join (select y.nama_pelanggan, x.kode_pesanan, 
			y.kode_pelanggan from tbl_pesanan_header x left join tbl_pelanggan y on 
			x.kode_pelanggan=y.kode_pelanggan) b on a.kode_pesanan=b.kode_pesanan order by a.kode_faktur DESC LIMIT 
			".$offset.","
			.$limit."");
			
			$this->load->view('global/bg_top',$d);
			$this->load->view('faktur/bg_home',$bc);
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
	
	public function buat_faktur()
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
			
			$id['kode_pesanan'] = $this->uri->segment(3);
			
			$cs['stts'] = "Ok";
			if(substr($id['kode_pesanan'],0,2)=="PS")
			{
				$id_pil['kode_pesanan'] = $this->uri->segment(3);
				$cs['kode_pesanan'] = $id['kode_pesanan'];
			}
			else if(substr($id['kode_pesanan'],0,2)=="FK")
			{
				$id_pil['kode_faktur'] = $this->uri->segment(3);
			}
			$cek_stts = $this->app_model->getSelectedData("tbl_pesanan_header",$cs);
			/*if($cek_stts->num_rows()>0)
			{*/
				$cek = $this->app_model->getSelectedData("tbl_faktur",$id_pil);
				$dt_pelanggan = $this->app_model->manualQuery("SELECT (select count(kode_pesanan) as jum from tbl_pesanan_detail where 
				kode_pesanan=a.kode_pesanan and stts_pengiriman='pending') as jum_item, (select
				sum(qty) as jum_barang from tbl_pesanan_detail where kode_pesanan=a.kode_pesanan and stts_pengiriman='pending') as 
				jum_barang, b.nama_pelanggan, b.alamat, b.no_telp, a.tanggal_pesanan, b.kota, 
				b.provinsi, b.hutang, b.kode_pelanggan from tbl_pesanan_header a left join tbl_pelanggan b on a.kode_pelanggan=b.kode_pelanggan where 
				a.kode_pesanan='".$id['kode_pesanan']."'");
				foreach($dt_pelanggan->result() as $dp)
				{
					$bc['nama_pelanggan'] = $dp->nama_pelanggan;
					$bc['alamat'] = $dp->alamat;
					$bc['no_telp'] = $dp->no_telp;
					$bc['tgl_pesanan'] = $dp->tanggal_pesanan;
					$bc['kota_provinsi'] = $dp->kota.'-'.$dp->provinsi;
					$bc['jum_item'] =  $dp->jum_item;
					$bc['jum_barang'] = $dp->jum_barang;
					$bc['hutang'] = $dp->hutang;
					$bc['kode_pelanggan'] = $dp->kode_pelanggan;
				}
					$bc['dt_pesanan_detail'] = $this->app_model->manualQuery("select a.kode_pesanan, a.kode_barang, a.qty, a.qty_terkirim, a.harga_tersimpan, 
					b.nama_barang from tbl_pesanan_detail a left join tbl_barang b on a.kode_barang=b.kode_barang where a.kode_pesanan='".$id['kode_pesanan']."'
					 and a.stts_pengiriman='pending'"); 
					$in_cart = array();
					foreach($bc['dt_pesanan_detail']->result() as $dpd)
					{
						$in_cart[] = array(
						'id'      => $dpd->kode_barang,
						'qty'     => $dpd->qty,
						'price'   => $dpd->harga_tersimpan,
						'name'    => $dpd->nama_barang,
						'options'    => array('QtyTerkirim' => $dpd->qty_terkirim));
					}
					$this->cart->insert($in_cart);
					$bc['jdl'] = "Tambah";
					$bc['kode_faktur'] = $this->app_model->getMaxKodeFaktur();
					$bc['kode_pesanan'] = $id['kode_pesanan'];
					$this->load->view('global/bg_top',$d);
					$this->load->view('faktur/bg_tambah_faktur',$bc);
					$this->load->view('global/bg_footer',$d);
			/*}
			else
			{
				?>
				<script> 
					alert('Status pesanan Pending. Tidak dapat mencetak Faktur.'); 
				</script>
				<?php
				header('location:'.base_url().'pemesanan');
			}*/
			
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
	
	public function cetak_faktur()
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
			
			$id['kode_pesanan'] = $this->uri->segment(3);
			
			$cs['stts'] = "Ok";
			if(substr($id['kode_pesanan'],0,2)=="PS")
			{
				$id_pil['kode_pesanan'] = $this->uri->segment(3);
				$cs['kode_pesanan'] = $id['kode_pesanan'];
			}
			else if(substr($id['kode_pesanan'],0,2)=="FK")
			{
				$id_pil['kode_faktur'] = $this->uri->segment(3);
			}
			$cek_stts = $this->app_model->getSelectedData("tbl_pesanan_header",$cs);
			/*if($cek_stts->num_rows()>0)
			{*/
				$cek = $this->app_model->getSelectedData("tbl_faktur",$id_pil);
				$dt_pelanggan = $this->app_model->manualQuery("SELECT (select count(kode_pesanan) as jum from tbl_pesanan_detail where 
				kode_pesanan=a.kode_pesanan) as jum_item, (select
				sum(qty) as jum_barang from tbl_pesanan_detail where kode_pesanan=a.kode_pesanan) as jum_barang, b.nama_pelanggan, b.alamat, b.no_telp, 
				a.tanggal_pesanan, b.kota, 
				b.provinsi, b.hutang, b.kode_pelanggan from tbl_pesanan_header a left join tbl_pelanggan b on a.kode_pelanggan=b.kode_pelanggan where 
				a.kode_pesanan='".$id['kode_pesanan']."'");
				foreach($dt_pelanggan->result() as $dp)
				{
					$bc['nama_pelanggan'] = $dp->nama_pelanggan;
					$bc['alamat'] = $dp->alamat;
					$bc['no_telp'] = $dp->no_telp;
					$bc['tgl_pesanan'] = $dp->tanggal_pesanan;
					$bc['kota_provinsi'] = $dp->kota.'-'.$dp->provinsi;
					$bc['jum_item'] =  $dp->jum_item;
					$bc['jum_barang'] = $dp->jum_barang;
					$bc['hutang'] = $dp->hutang;
					$bc['kode_pelanggan'] = $dp->kode_pelanggan;
				}
				//if($cek->num_rows()>0)
				//{
					$d['jdl'] = "Cetak";
					$this->cart->destroy();
					$kode_faktur = "";
					$kode_pesanan = "";
					foreach($cek->result() as $c)
					{
						$kode_faktur = $c->kode_faktur;
						$kode_pesanan = $c->kode_pesanan;
					}
					$d['dt_faktur'] = $this->app_model->manualQuery("select 
					(select count(kode_faktur) as jum from tbl_faktur_detail where kode_faktur=a.kode_faktur) as jum_item, a.kode_faktur, 
					a.kode_pesanan,a.tanggal_faktur, b.kode_pelanggan, a.qty_barang_terjual, b.nama_pelanggan, b.alamat, b.no_telp, b.tanggal_pesanan, 
					b.kota, b.provinsi, a.bayar, a.sisa_bayar from tbl_faktur a left join (select x.kode_pesanan,
					x.kode_pelanggan,y.nama_pelanggan,y.alamat,y.no_telp,y.kota,y.provinsi,x.tanggal_pesanan from tbl_pesanan_header x left join 
					tbl_pelanggan y on x.kode_pelanggan=y.kode_pelanggan) b on a.kode_pesanan=b.kode_pesanan where a.kode_faktur='".$kode_faktur."'");
					
					foreach($d['dt_faktur']->result() as $df)
					{
						$d['kode_faktur'] = $df->kode_faktur;
						$d['kode_pesanan'] = $df->kode_pesanan;
						$d['kode_pelanggan'] = $df->kode_pelanggan;
						$d['tanggal_faktur'] = $df->tanggal_faktur;
						$d['jum_item'] = $df->qty_barang_terjual;
						$d['nama_pelanggan'] = $df->nama_pelanggan;
						$d['alamat'] = $df->alamat;
						$d['no_telp'] = $df->no_telp;
						$d['tgl_pesanan'] = $df->tanggal_pesanan;
						$d['kota_provinsi'] = $df->kota.' - '.$df->provinsi;
						$d['jum_barang'] = $df->jum_item;
						$d['bayar'] = $df->bayar;
						$d['sisa_bayar'] = $df->sisa_bayar;
					}
					
					$d['dt_pesanan_detail'] = $this->app_model->manualQuery("select a.kode_faktur, a.kode_barang, a.qty, a.qty_terkirim, a.harga_tersimpan, b.nama_barang
					 from tbl_faktur_detail a left join tbl_barang b on a.kode_barang=b.kode_barang where a.kode_faktur='".$kode_faktur."'");
					$in_cart = array();
					foreach($d['dt_pesanan_detail']->result() as $dpd)
					{
						$in_cart[] = array(
						'id'      => $dpd->kode_barang,
						'qty'     => $dpd->qty,
						'price'   => $dpd->harga_tersimpan,
						'name'    => $dpd->nama_barang,
						'options'    => array('QtyTerkirim' => $dpd->qty_terkirim));
					}
					$this->cart->insert($in_cart);
					$d['jdl'] = "Tambah";
					$this->load->view('faktur/bg_cetak_faktur',$d);
				/*}
				else
				{
					$this->cart->destroy();
					$bc['dt_pesanan_detail'] = $this->app_model->manualQuery("select a.kode_pesanan, a.kode_barang, a.qty, a.qty_terkirim, a.harga_tersimpan, 
					b.nama_barang, a.options from tbl_pesanan_detail a left join tbl_barang b on a.kode_barang=b.kode_barang where a.kode_pesanan='".$id['kode_pesanan']."'
					and a.options='Ready' and a.stts_pengiriman='pending'"); 
					$in_cart = array();
					foreach($bc['dt_pesanan_detail']->result() as $dpd)
					{
						$in_cart[] = array(
						'id'      => $dpd->kode_barang,
						'qty'     => $dpd->qty,
						'price'   => $dpd->harga_tersimpan,
						'name'    => $dpd->nama_barang,
						'options'    => array('StatusBarang' => $dpd->options,'QtyTerkirim' => $dpd->qty_terkirim));
					}
					$this->cart->insert($in_cart);
					$bc['jdl'] = "Tambah";
					$bc['kode_faktur'] = $this->app_model->getMaxKodeFaktur();
					$bc['kode_pesanan'] = $id['kode_pesanan'];
					$this->load->view('global/bg_top',$d);
					$this->load->view('faktur/bg_tambah_faktur',$bc);
					$this->load->view('global/bg_footer',$d);
				}*/
			/*}
			else
			{
				?>
				<script> 
					alert('Status pesanan Pending. Tidak dapat mencetak Faktur.'); 
				</script>
				<?php
				header('location:'.base_url().'pemesanan');
			}*/
			
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
	
	public function tambah_faktur()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek))
		{
			$total = $this->cart->total_items();
			$qty_terkirim = $this->input->post('qty_terkirim');
			$qty_dikirim = $this->input->post('qty_dikirim');
			$id_detail['kode_pesanan'] = $this->input->post('kode_pesanan');
			$i = 0;
			$jum_terjual = 0;
			foreach($this->cart->contents() as $items)
			{
				$qty = $items['qty'];
				$id_detail['kode_barang'] = $items['id'];
				$dt['qty_terkirim'] = $qty_terkirim[$i]+$qty_dikirim[$i];
				$dt['stts_pengiriman'] = 'pending';
				if($dt['qty_terkirim']==$qty)
				{
					$dt['stts_pengiriman'] = 'terkirim';
				}
				$this->db->update('tbl_pesanan_detail', $dt, $id_detail); 
				$jum_terjual = $jum_terjual+$qty_dikirim[$i];
				$i++;
			}
			$this->load->helper('date');
			$date = date('Y-m-d H:i:s'); 
			$in_faktur['kode_faktur'] = $this->input->post("kode_faktur");
			$in_faktur['tanggal_faktur'] = $date;
			$in_faktur['kode_pesanan'] = $this->input->post("kode_pesanan");
			$in_faktur['qty_barang_terjual'] = $jum_terjual;
			$in_faktur['total_barang'] = $jum_terjual;
			$in_faktur['total_bayar'] = $this->input->post("total");
			$in_faktur['bayar'] = $this->input->post("bayar");
			$in_faktur['sisa_bayar'] = $this->input->post("kembalian");
			$this->app_model->insertData("tbl_faktur",$in_faktur);
			
			$j = 0;
			foreach($this->cart->contents() as $items)
			{
				$dt2['kode_faktur'] = $in_faktur['kode_faktur'];
				$dt2['kode_barang'] = $items['id'];
				$dt2['qty'] = $items['qty'];
				$dt2['qty_terkirim'] = $qty_dikirim[$j];
				$dt2['harga_tersimpan'] = $items['price'];
				
				$this->db->insert('tbl_faktur_detail', $dt2); 
				$j++;
			}
			
			$id['kode_pelanggan'] = $this->input->post("kode_pelanggan");
			$up_pelanggan['hutang'] = $this->input->post("hutang");
			$this->app_model->updateData("tbl_pelanggan",$up_pelanggan,$id);
			$this->cart->destroy();
			
			$q_tot = $this->db->get_where("tbl_pesanan_detail",array('kode_pesanan'=>$in_faktur['kode_pesanan']));
			$q_tot_ok = $this->db->get_where("tbl_pesanan_detail",array('kode_pesanan'=>$in_faktur['kode_pesanan'],'stts_pengiriman'=>'terkirim'));
			if($q_tot->num_rows()==$q_tot_ok->num_rows())
			{
				$this->app_model->updateData("tbl_pesanan_header",array('stts'=>'Ok'),array('kode_pesanan'=>$in_faktur['kode_pesanan']));
			}
			header('location:'.base_url().'faktur');
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
			$this->cart->destroy();
			$this->session->unset_userdata('limit_add_cart');
			$this->session->unset_userdata('kd_pemesan');
			$d['judul'] = 'SIM - '.$this->config->item('nama_perusahaan');
			$d['nama_perusahaan'] = $this->config->item('nama_perusahaan');
			$d['alamat_perusahaan'] = $this->config->item('alamat_perusahaan');
			$d['lisensi'] = $this->config->item('lisensi_app');
			$d['jdl'] = "Tambah";
			
			$bc['menu'] = $this->load->view('app/menu', '', true);
			$bc['bio'] = $this->load->view('app/bio', $bc, true);
			
			$bc['kode_faktur'] = $this->app_model->getMaxKodeFaktur();
			$bc['dt_pesanan'] = $this->app_model->getSelectedData("tbl_pesanan_header",array('stts'=>'Pending'));
			
			$this->load->view('global/bg_top',$d);
			$this->load->view('faktur/bg_tambah_manual_faktur',$bc);
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
	
	public function tambah_surat_jalan()
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
			$d['jdl'] = "Tambah";
			
			$bc['menu'] = $this->load->view('app/menu', '', true);
			$bc['bio'] = $this->load->view('app/bio', $bc, true);
			
			$id['kode_faktur'] = $this->uri->segment(3);
			$id['kode_pesanan'] = $this->uri->segment(4);
			$cek = $this->db->get_where("tbl_surat_jalan",$id);
			if($cek->num_rows()>0)
			{
				header('location:'.base_url().'faktur/cetak_surat_jalan/'.$id['kode_faktur'] .'/'.$id['kode_pesanan'] .'');
			}
			else
			{
				$bc['kode_surat_jalan'] = $this->app_model->getMaxKodeSuratJalan();
				$bc['kode_faktur'] = $id['kode_faktur'];
				$bc['kode_pesanan'] = $id['kode_pesanan'];
				$bc['tanggal_surat_jalan'] = gmdate('d/m/Y H:i:s',time()+3600*7);
				
				$dt_pelanggan = $this->app_model->manualQuery("SELECT b.nama_pelanggan,b.alamat from tbl_pesanan_header a left join tbl_pelanggan b on 
				a.kode_pelanggan=b.kode_pelanggan where a.kode_pesanan='".$bc['kode_pesanan']."'");
				foreach($dt_pelanggan->result() as $dp)
				{
					$bc['nama_pelanggan'] = $dp->nama_pelanggan;
					$bc['alamat_pelanggan'] = $dp->alamat;
				}
				
				$bc['dt_pesanan_detail'] = $this->app_model->manualQuery("select a.kode_faktur, a.kode_barang, a.qty_terkirim, a.harga_tersimpan, b.nama_barang
				from tbl_faktur_detail a left join tbl_barang b on a.kode_barang=b.kode_barang where a.kode_faktur='".$bc['kode_faktur']."'");
				$in_cart = array();
				foreach($bc['dt_pesanan_detail']->result() as $dpd)
				{
					$in_cart[] = array(
					'id'      => $dpd->kode_barang,
					'qty'     => $dpd->qty_terkirim,
					'price'   => $dpd->harga_tersimpan,
					'name'    => $dpd->nama_barang);
				}
				$this->cart->insert($in_cart);
				
				$this->load->view('global/bg_top',$d);
				$this->load->view('faktur/bg_tambah_surat_jalan',$bc);
				$this->load->view('global/bg_footer',$d);
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
	
	public function simpan_surat_jalan()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek))
		{
			$in_surat_jalan['kode_faktur'] = $this->input->post("kode_faktur");
			$in_surat_jalan['kode_surat_jalan'] = $this->input->post("kode_surat_jalan");
			$in_surat_jalan['kode_pesanan'] = $this->input->post("kode_pesanan");
			$in_surat_jalan['tanggal_surat_jalan'] = time()+3600*7;
			$this->app_model->insertData("tbl_surat_jalan",$in_surat_jalan);
			$this->cart->destroy();
			header('location:'.base_url().'faktur/cetak_surat_jalan/'.$in_surat_jalan['kode_faktur'].'/'.$in_surat_jalan['kode_pesanan'].'');
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
			$del['kode_faktur'] = $this->uri->segment(3);
			$del2['kode_pesanan'] = $this->uri->segment(4);
			$this->app_model->deleteData("tbl_faktur",$del);
			$this->app_model->deleteData("tbl_faktur_detail",$del);
			$this->app_model->deleteData("tbl_surat_jalan",$del2);
			header('location:'.base_url().'faktur/');
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
	
	public function cetak_surat_jalan()
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
			$d['jdl'] = "Tambah";
			
			$bc['menu'] = $this->load->view('app/menu', '', true);
			$bc['bio'] = $this->load->view('app/bio', $bc, true);
			
				
			$id['kode_faktur'] = $this->uri->segment(3);
			$id['kode_pesanan'] = $this->uri->segment(4);
			$bc['kode_faktur'] = $id['kode_faktur'];
			$bc['kode_pesanan'] = $id['kode_pesanan'];
			$cek = $this->db->get_where("tbl_surat_jalan",$id);
			if($cek->num_rows()>0)
			{
				$dt_pelanggan = $this->app_model->manualQuery("select x.kode_surat_jalan, y.nama_pelanggan, y.alamat, x.tanggal_surat_jalan from tbl_surat_jalan 
				x left join (SELECT b.nama_pelanggan, b.alamat, a.kode_pesanan from tbl_pesanan_header a left join tbl_pelanggan b on 
				a.kode_pelanggan=b.kode_pelanggan) y on x.kode_pesanan=y.kode_pesanan where x.kode_pesanan='".$bc['kode_pesanan']."'");
				foreach($dt_pelanggan->result() as $dp)
				{
					$bc['nama_pelanggan'] = $dp->nama_pelanggan;
					$bc['alamat_pelanggan'] = $dp->alamat;
					$bc['kode_surat_jalan'] = $dp->kode_surat_jalan;
					$bc['tanggal_surat_jalan'] = gmdate('d/m/Y - H:i:s',$dp->tanggal_surat_jalan);
				}
				
				$bc['dt_pesanan_detail'] = $this->app_model->manualQuery("select a.kode_faktur, a.kode_barang, a.qty_terkirim, a.harga_tersimpan, b.nama_barang, a.options 
				from tbl_faktur_detail a left join tbl_barang b on a.kode_barang=b.kode_barang where a.kode_faktur='".$bc['kode_faktur']."' and a.options='Ready'");
				$in_cart = array();
				foreach($bc['dt_pesanan_detail']->result() as $dpd)
				{
					$in_cart[] = array(
					'id'      => $dpd->kode_barang,
					'qty'     => $dpd->qty_terkirim,
					'price'   => $dpd->harga_tersimpan,
					'name'    => $dpd->nama_barang,
					'options'    => array('StatusBarang' => $dpd->options));
				}
				$this->cart->insert($in_cart);
				
				$this->load->view('global/bg_top',$d);
				$this->load->view('faktur/bg_cetak_surat_jalan',$bc);
				$this->load->view('global/bg_footer',$d);
			}
			else
			{
				header('location:'.base_url().'faktur/tambah_surat_jalan/'.$id['kode_pesanan'] .'');
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
	
	public function ambil_data_pesanan_ajax()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek))
		{
			$this->cart->destroy();
			$data["kode_pesanan"] = $_GET["kode_pesanan"];
			$data["stts"] = "Ok";
			$sess_data['kode_pesanan'] = $data["kode_pesanan"];
			$this->session->set_userdata($sess_data);
			
			$cek = $this->app_model->getSelectedData("tbl_pesanan_header",$data);
			if($cek->num_rows()>0)
			{
				$kode_pesanan = $_GET['kode_pesanan'];
				?> <script> window.location="<?php echo base_url(); ?>faktur/"; </script> <?php
			}
			else
			{
			$dt_pelanggan = $this->app_model->manualQuery("SELECT (select count(kode_pesanan) as jum from tbl_pesanan_detail where kode_pesanan=a.kode_pesanan) as jum_item, (select
			sum(qty) as jum_barang from tbl_pesanan_detail where kode_pesanan=a.kode_pesanan) as jum_barang, b.nama_pelanggan, b.alamat, b.no_telp, a.tanggal_pesanan, b.kota, 
			b.provinsi, b.hutang, b.kode_pelanggan from tbl_pesanan_header a left join tbl_pelanggan b on a.kode_pelanggan=b.kode_pelanggan where 
			a.kode_pesanan='".$this->session->userdata('kode_pesanan')."'");
			foreach($dt_pelanggan->result() as $dp)
			{
				$bc['nama_pelanggan'] = $dp->nama_pelanggan;
				$bc['alamat'] = $dp->alamat;
				$bc['no_telp'] = $dp->no_telp;
				$bc['tgl_pesanan'] = $dp->tanggal_pesanan;
				$bc['kota_provinsi'] = $dp->kota.' - '.$dp->provinsi;
				$bc['jum_item'] =  $dp->jum_item;
				$bc['jum_barang'] = $dp->jum_barang;
				$bc['hutang'] = $dp->hutang;
				$bc['kode_pelanggan'] = $dp->kode_pelanggan;
			}
			
			$bc['dt_pesanan_detail'] = $this->app_model->manualQuery("select a.kode_pesanan, a.kode_barang, a.qty_terkirim, a.stts_pengiriman, a.qty, a.harga_tersimpan, b.nama_barang from tbl_pesanan_detail a left 
			join tbl_barang b on a.kode_barang=b.kode_barang where a.kode_pesanan='".$this->session->userdata('kode_pesanan')."'");
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
			?>
			<script>
			function hitBayar(){
				var total = parseInt(document.frm.total.value);
				var bayar = parseInt(document.frm.bayar.value);
				var sisa = bayar-total;
				if(bayar<total)
				{
					document.frm.kembalian.value=0;
					document.frm.hutang.value=Math.abs(sisa)+<?php echo $bc['hutang']; ?>;
				}
				else
				{
					document.frm.kembalian.value=sisa;
					document.frm.hutang.value=<?php echo $bc['hutang']; ?>;
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
						document.frm.hutang.value=Math.abs(sisa)+<?php echo $bc['hutang']; ?>;
					}
					else
					{
						var hit_hutang = sisa-<?php echo $bc['hutang']; ?>;
						var hit_hutang_tampil = Math.abs(sisa-<?php echo $bc['hutang']; ?>);
						if(<?php echo $bc['hutang']; ?>>sisa)
						{
							document.frm.hutang.value=Math.abs(sisa-<?php echo $bc['hutang']; ?>);
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
						document.frm.hutang.value=<?php echo $bc['hutang']; ?>;
						document.frm.kembalian.value=sisa;
					}
					else
					{
						var hit_hutang = sisa-<?php echo $bc['hutang']; ?>;
						var hit_hutang_tampil = Math.abs(sisa-<?php echo $bc['hutang']; ?>);
						if(<?php echo $bc['hutang']; ?>>sisa)
						{
							document.frm.hutang.value=Math.abs(sisa-<?php echo $bc['hutang']; ?>);
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
		sum = arr_harga[k]*arr_jum[k+1];
		jum_total +=arr_harga[k]*arr_jum[k+1];
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
			<table width="100%" cellpadding="3" cellspacing="0">
			<tr><td width="110">Tanggal Faktur</td><td>:</td><td width="300">
				<input type="text" value="<?php $gmt = time(); echo gmdate('d/m/Y H:i:s',$gmt+3600*7); ?>" class="input-read-only" readonly="true" 
				 style="width:280px;" /><input type="hidden" value="<?php echo ($gmt+3600*7); ?>" name="tanggal_faktur" />
				<td width="110">Banyak Item/Barang</td><td>:</td><td width="300">
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
				<input type="text" value="<?php echo $bc['kota_provinsi']; ?>" class="input-read-only" readonly="true" 
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
				<td class="td-keranjang">Rp. <textarea class="input-read-only" style="resize:none; width:80px; height:18px; font-family:Arial;" readonly="readonly" name="harga[]"><?php echo $items['price']; ?></textarea></td>
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
				<td>Rp. <input type="text" class="input-read-only" readonly="true" style="width:110px;" name="hutang" value="<?php echo $bc['hutang']; ?>" /></td>
			</tr>
			</table>
			<div class="cleaner_h10"></div>
			<input type="submit" class="btn-kirim-login" value="Simpan Dan Cetak Faktur" disabled="disabled" name="btnsimpan">
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
}

/* End of file faktur.php */
/* Location: ./application/controllers/faktur.php */