<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pelanggan extends CI_Controller {


	
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
			
			$page=$this->uri->segment(3);
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$tot_hal = $this->app_model->getAllData("tbl_pelanggan");
			$config['base_url'] = base_url() . 'pelanggan/index/';
			$config['total_rows'] = $tot_hal->num_rows();
			$config['per_page'] = $limit;
			$config['uri_segment'] = 3;
			$config['first_link'] = 'Awal';
			$config['last_link'] = 'Akhir';
			$config['next_link'] = 'Selanjutnya';
			$config['prev_link'] = 'Sebelumnya';
			$this->pagination->initialize($config);
			$bc["paginator"] =$this->pagination->create_links();
			
			$bc['dt_pelanggan'] = $this->app_model->getAllDataLimited("tbl_pelanggan",$limit,$offset);
			
			$this->load->view('global/bg_top',$d);
			$this->load->view('pelanggan/bg_home',$bc);
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
			$pilih['kode_pelanggan'] = $this->uri->segment(3);
			$bc['jdl'] = "Edit";
			$bc['stts'] = "edit";
			$dt_barang = $this->app_model->getSelectedData("tbl_pelanggan",$pilih);
			foreach($dt_barang->result() as $db)
			{
				$bc['kode_pelanggan'] = $db->kode_pelanggan;
				$bc['nama_pelanggan'] = $db->nama_pelanggan;
				$bc['alamat'] = $db->alamat;
				$bc['kota'] = $db->kota;
				$bc['provinsi'] = $db->provinsi;
				$bc['no_telp'] = $db->no_telp;
				$bc['hutang'] = $db->hutang;
				$bc['stts_bayar'] = $db->stts;
			}
			
			$this->load->view('pelanggan/bg_input_pelanggan',$bc);
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
			$bc['jdl'] = "Tambah";
			$bc['kode_pelanggan'] = $this->app_model->getMaxKodePelanggan();
			$bc['nama_pelanggan'] = "";
			$bc['alamat'] = "";
			$bc['kota'] = "";
			$bc['provinsi'] = "";
			$bc['no_telp'] = "";
			$bc['hutang'] = "";
			$bc['stts_bayar'] = "";
			$bc['stts'] = "tambah";
			
			$this->load->view('pelanggan/bg_input_pelanggan',$bc);
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
	
	public function simpan_input()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek))
		{
			$st = $this->input->post('stts');
			if($st=="edit")
			{
				$id['kode_pelanggan'] = $this->input->post('kode_pelanggan');
				$up['nama_pelanggan'] = $this->input->post('nama_pelanggan');
				$up['alamat'] = $this->input->post('alamat');
				$up['kota'] = $this->input->post('kota');
				$up['provinsi'] = $this->input->post('provinsi');
				$up['no_telp'] = $this->input->post('no_telp');
				$up['hutang'] = $this->input->post('hutang');
				$up['stts'] = $this->input->post('stts_bayar');
				$this->app_model->updateData("tbl_pelanggan",$up,$id);
				?>
					<script>
						window.parent.location.reload(true);
					</script>
				<?php
			}
			else if($st=="tambah")
			{
				$in['kode_pelanggan'] = $this->input->post('kode_pelanggan');
				$in['nama_pelanggan'] = $this->input->post('nama_pelanggan');
				$in['alamat'] = $this->input->post('alamat');
				$in['kota'] = $this->input->post('kota');
				$in['provinsi'] = $this->input->post('provinsi');
				$in['no_telp'] = $this->input->post('no_telp');
				$in['hutang'] = $this->input->post('hutang');
				$in['stts'] = $this->input->post('stts_bayar');
				$this->app_model->insertData("tbl_pelanggan",$in);
				?>
					<script>
						window.parent.location.reload(true);
					</script>
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
	
	public function hapus()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek))
		{
			$hapus['kode_pelanggan'] = $this->uri->segment(3);
			$dt_barang = $this->app_model->deleteData("tbl_pelanggan",$hapus);
			?>
				<script> window.location = "<?php echo base_url(); ?>pelanggan"; </script>
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

/* End of file pelanggan.php */
/* Location: ./application/controllers/pelanggan.php */