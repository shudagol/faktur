<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Suplier extends CI_Controller {


	
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
			
			$tot_hal = $this->app_model->getAllData("tbl_suplier");
			$config['base_url'] = base_url() . 'suplier/index/';
			$config['total_rows'] = $tot_hal->num_rows();
			$config['per_page'] = $limit;
			$config['uri_segment'] = 3;
			$config['first_link'] = 'Awal';
			$config['last_link'] = 'Akhir';
			$config['next_link'] = 'Selanjutnya';
			$config['prev_link'] = 'Sebelumnya';
			$this->pagination->initialize($config);
			$bc["paginator"] =$this->pagination->create_links();
			
			$bc['dt_suplier'] = $this->app_model->getAllDataLimited("tbl_suplier",$limit,$offset);
			
			$this->load->view('global/bg_top',$d);
			$this->load->view('suplier/bg_home',$bc);
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
			$pilih['kode_suplier'] = $this->uri->segment(3);
			$bc['jdl'] = "Edit";
			$bc['stts'] = "edit";
			$dt_barang = $this->app_model->getSelectedData("tbl_suplier",$pilih);
			foreach($dt_barang->result() as $db)
			{
				$bc['kode_suplier'] = $db->kode_suplier;
				$bc['nama_suplier'] = $db->nama_suplier;
				$bc['alamat'] = $db->alamat;
				$bc['kota'] = $db->kota;
				$bc['provinsi'] = $db->provinsi;
				$bc['kontak'] = $db->kontak;
			}
			
			$this->load->view('suplier/bg_input_suplier',$bc);
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
			$bc['kode_suplier'] = $this->app_model->getMaxKodeSuplier();
			$bc['nama_suplier'] = "";
			$bc['alamat'] = "";
			$bc['kota'] = "";
			$bc['provinsi'] = "";
			$bc['kontak'] = "";
			$bc['stts'] = "tambah";
			
			$this->load->view('suplier/bg_input_suplier',$bc);
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
				$id['kode_suplier'] = $this->input->post('kode_suplier');
				$up['nama_suplier'] = $this->input->post('nama_suplier');
				$up['alamat'] = $this->input->post('alamat');
				$up['kota'] = $this->input->post('kota');
				$up['provinsi'] = $this->input->post('provinsi');
				$up['kontak'] = $this->input->post('kontak');
				$this->app_model->updateData("tbl_suplier",$up,$id);
				?>
					<script>
						window.parent.location.reload(true);
					</script>
				<?php
			}
			else if($st=="tambah")
			{
				$in['kode_suplier'] = $this->input->post('kode_suplier');
				$in['nama_suplier'] = $this->input->post('nama_suplier');
				$in['alamat'] = $this->input->post('alamat');
				$in['kota'] = $this->input->post('kota');
				$in['provinsi'] = $this->input->post('provinsi');
				$in['kontak'] = $this->input->post('kontak');
				$this->app_model->insertData("tbl_suplier",$in);
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
			$hapus['kode_suplier'] = $this->uri->segment(3);
			$dt_barang = $this->app_model->deleteData("tbl_suplier",$hapus);
			?>
				<script> window.location = "<?php echo base_url(); ?>suplier"; </script>
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