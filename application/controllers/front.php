<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Front extends CI_Controller {

	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		if(empty($cek))
		{
			$d['judul'] = 'Login - '.$this->config->item('nama_perusahaan');
			$d['nama_perusahaan'] = $this->config->item('nama_perusahaan');
			$d['alamat_perusahaan'] = $this->config->item('alamat_perusahaan');
			$d['lisensi'] = $this->config->item('lisensi_app');
			
			//buat atribut form
			$frm['username'] = array('name' => 'username',
				'id' => 'username',
				'type' => 'text',
				'class' => 'input-teks-login',
				'autocomplete' => 'off',
				'placeholder' => 'Masukkan username.....'
			);
			$frm['password'] = array('name' => 'password',
				'id' => 'password',
				'type' => 'password',
				'class' => 'input-teks-login',
				'autocomplete' => 'off',
				'placeholder' => 'Masukkan password.....'
			);
			
			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
	
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('global/bg_top',$d);
				$this->load->view('front/bg_login',$frm);
				$this->load->view('global/bg_footer',$d);
			}
			else
			{
				$u = $this->input->post('username');
				$p = $this->input->post('password');
				$this->app_model->getLoginData($u,$p);
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
	
	public function login()
	{
		$d['judul'] = "Login - Sistem Informasi Akademik Online";
		$u = $this->input->post('username');
		$p = $this->input->post('password');
		$this->app_model->getLoginData($u,$p);
	}
	
	public function logout()
	{
		$cek = $this->session->userdata('logged_in');
		if(empty($cek))
		{
			header('location:'.base_url().'front');
		}
		else
		{
			$this->session->sess_destroy();
			header('location:'.base_url().'front');
		}
	}
}

/* End of file front.php */
/* Location: ./application/controllers/front.php */