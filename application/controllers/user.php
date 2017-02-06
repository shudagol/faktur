<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {


	
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
			
			$tot_hal = $this->app_model->getAllData("tbl_login");
			$bc['dt_user'] = $this->app_model->getAllDataLimited("tbl_login",$limit,$offset);
			$config['base_url'] = base_url() . 'user/index/';
			$config['total_rows'] = $tot_hal->num_rows();
			$config['per_page'] = $limit;
			$config['uri_segment'] = 3;
			$config['first_link'] = 'Awal';
			$config['last_link'] = 'Akhir';
			$config['next_link'] = 'Selanjutnya';
			$config['prev_link'] = 'Sebelumnya';
			$this->pagination->initialize($config);
			$bc["paginator"] =$this->pagination->create_links();
			
			$this->load->view('global/bg_top',$d);
			$this->load->view('user/bg_home',$bc);
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
			$bc['username'] = "";
			$bc['password'] = "";
			$bc['nama_pengguna'] = "";
			$bc['stts'] = "";
			$bc['stts_input'] = "tambah";
			
			$this->load->view('user/bg_input_user',$bc);
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
			
			$id['username'] = $this->uri->segment(3);
			$detail = $this->app_model->getSelectedData("tbl_login",$id);
			foreach($detail->result() as $d)
			{
				$bc['jdl'] = "Edit";
				$bc['username'] = $d->username;
				$bc['password'] = "";
				$bc['nama_pengguna'] = $d->nama_pengguna;
				$bc['stts'] = $d->stts;
				$bc['stts_input'] = "edit";
			}
			
			$this->load->view('user/bg_input_user',$bc);
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
			$del['username'] = $this->uri->segment(3);
			$this->app_model->deleteData("tbl_login",$del);
			header('location:'.base_url().'user');
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
			$d['judul'] = 'SIM - '.$this->config->item('nama_perusahaan');
			$d['nama_perusahaan'] = $this->config->item('nama_perusahaan');
			$d['alamat_perusahaan'] = $this->config->item('alamat_perusahaan');
			$d['lisensi'] = $this->config->item('lisensi_app');
			
			$bc['menu'] = $this->load->view('app/menu', '', true);
			$bc['bio'] = $this->load->view('app/bio', $bc, true);
			
			$st = $this->input->post('stts_input');
			if($st=="tambah")
			{
				$ck['username'] = $this->input->post('username');
				$in['nama_pengguna'] = $this->input->post('nama_pengguna');
				$in['username'] = clear_teks($this->input->post('username'));
				$in['password'] = md5($this->input->post('password').'appFakturDlmbg32');
				$in['stts'] = $this->input->post('stts');
				$cek = $this->app_model->getSelectedData("tbl_login",$ck);
				if($cek->num_rows()>0)
				{
					$this->session->set_flashdata('gagal_user', 'Username telah terdaftar...!!!');
					header('location:'.base_url().'user/tambah');
				}
				else
				{
					$this->app_model->insertData("tbl_login",$in);
					?>
						<script>
							window.parent.location.reload(true);
						</script>
					<?php
				}
			}
			else if($st=="edit")
			{
				if($this->input->post('password')!="")
				{
					$up['nama_pengguna'] = $this->input->post('nama_pengguna');
					$id['username'] = $this->input->post('username');
					$up['password'] = md5($this->input->post('password').'appFakturDlmbg32');
					$up['stts'] = $this->input->post('stts');
					$this->app_model->updateData("tbl_login",$up,$id);
				}
				else
				{
					$up['nama_pengguna'] = $this->input->post('nama_pengguna');
					$id['username'] = $this->input->post('username');
					$up['stts'] = $this->input->post('stts');
					$this->app_model->updateData("tbl_login",$up,$id);
				}
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
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */