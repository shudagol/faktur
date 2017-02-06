<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Barang extends CI_Controller {

	
	
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
			
			$tot_hal = $this->app_model->getAllData("tbl_barang");
			$config['base_url'] = base_url() . 'barang/index/';
			$config['total_rows'] = $tot_hal->num_rows();
			$config['per_page'] = $limit;
			$config['uri_segment'] = 3;
			$config['first_link'] = 'Awal';
			$config['last_link'] = 'Akhir';
			$config['next_link'] = 'Selanjutnya';
			$config['prev_link'] = 'Sebelumnya';
			$this->pagination->initialize($config);
			$bc["paginator"] =$this->pagination->create_links();


			$bc['dt_barang'] = $this->app_model->manualQuery("SELECT * from tbl_barang b JOIN tbl_suplier s ON b.kode_suplier=s.kode_suplier LIMIT ".$offset.","
			.$limit."");
			
			// $bc['dt_barang'] = $this->app_model->getAllDataLimited("tbl_barang",$limit,$offset);
			
			$this->load->view('global/bg_top',$d);
			$this->load->view('barang/bg_home',$bc);
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
			$d['judul'] = 'SIM - '.$this->config->item('nama_perusahaan');
			$d['nama_perusahaan'] = $this->config->item('nama_perusahaan');
			$d['alamat_perusahaan'] = $this->config->item('alamat_perusahaan');
			$d['lisensi'] = $this->config->item('lisensi_app');
			
			$bc['menu'] = $this->load->view('app/menu', '', true);
			$bc['bio'] = $this->load->view('app/bio', $bc, true);
			$bc['jdl'] = "Edit";
			
			$pilih['kode_barang'] = $this->uri->segment(3);
			$dt_barang = $this->app_model->getSelectedData("tbl_barang",$pilih);
			foreach($dt_barang->result() as $db)
			{
				$bc['dt_suplier'] = $this->app_model->getAllData("tbl_suplier");
				$bc['kode_suplier'] = $db->kode_suplier;
				$bc['kode_barang'] = $db->kode_barang;
				$bc['nama_barang'] = $db->nama_barang;
				$bc['harga_beli'] = $db->harga_beli;
				$bc['stok'] = $db->stok;
				$bc['harga_barang'] = $db->harga_barang;
				$bc['keterangan'] = $db->keterangan;
				$bc['stts'] = "edit";
			}
			
			$this->load->view('barang/bg_input_barang',$bc);
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

			$bc['dt_suplier'] = $this->app_model->getAllData("tbl_suplier");
			$bc['kode_barang'] = $this->app_model->getMaxKodeBarang();
			$bc['nama_barang'] = "";
			$bc['stok'] = "";
			$bc['harga_barang'] = "";
			$bc['keterangan'] = "";
			$bc['harga_beli'] = "";
			$bc['stts'] = "tambah";
			
			$this->load->view('barang/bg_input_barang',$bc);
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
				$up['nama_barang'] = $this->input->post('nama_barang');
				$up['harga_barang'] = $this->input->post('harga_barang');
				$up['harga_beli'] = $this->input->post('harga_beli');
				$up['kode_suplier'] = $this->input->post('kode_suplier');
				$up['stok'] = $this->input->post('stok');
				$up['keterangan'] = $this->input->post('keterangan');
				$id['kode_barang'] = $this->input->post('kode_barang');
				$this->app_model->updateData("tbl_barang",$up,$id);
				?>
					<script>
						window.parent.location.reload(true);
					</script>
				<?php
			}
			else if($st=="tambah")
			{
				$in['nama_barang'] = $this->input->post('nama_barang');
				$in['harga_barang'] = $this->input->post('harga_barang');
				$in['harga_beli'] = $this->input->post('harga_beli');
				$in['kode_suplier'] = $this->input->post('kode_suplier');
				$in['stok'] = $this->input->post('stok');
				$in['keterangan'] = $this->input->post('keterangan');
				$in['kode_barang'] = $this->input->post('kode_barang');
				$this->app_model->insertData("tbl_barang",$in);
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
	
	public function simpan_input_inline()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek))
		{
			if(isset($_GET['kode_data']))
			{
				$data = explode("|",isset($_GET['kode_data']) ? $_GET['kode_data'] : "");
				$up['stok'] = $data[1];
				$id['kode_barang'] = $data[0];
				$this->app_model->updateData("tbl_barang",$up,$id);
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
			$hapus['kode_barang'] = $this->uri->segment(3);
			$dt_barang = $this->app_model->deleteData("tbl_barang",$hapus);
			?>
				<script> window.location = "<?php echo base_url(); ?>barang"; </script>
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

/* End of file barang.php */
/* Location: ./application/controllers/barang.php */