<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class App extends CI_Controller {

	
	
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
			
			$this->load->view('global/bg_top',$d);
			$this->load->view('app/bg_home',$bc);
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
}

/* End of file app.php */
/* Location: ./application/controllers/app.php */