<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Restore extends CI_Controller {

	
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
			$this->load->view('restore/bg_home',$bc);
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
	
	public function upload()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek))
		{
			$acak=rand(00000000000,99999999999);
			$bersih=$_FILES['userfile']['name'];
			$nm=str_replace(" ","_","$bersih");
			$pisah=explode(".",$nm);
			$nama_murni_lama = preg_replace("/^(.+?);.*$/", "\\1",$pisah[0]);
			$nama_murni=date('Ymd-His');
			$ekstensi_kotor = $pisah[1];
			
			$file_type = preg_replace("/^(.+?);.*$/", "\\1", $ekstensi_kotor);
			$file_type_baru = strtolower($file_type);
			
			$ubah=$acak; //tanpa ekstensi
			$n_baru = $ubah.'.'.$file_type_baru;
			
			$in['gbr'] = $n_baru;
		
			$config['upload_path'] = './asset/db_temp/';
			$config['allowed_types'] = 'txt';
			$config['max_size'] = '1000000';
			$config['max_width'] = '100';
			$config['max_height'] = '100';		
			$config['file_name'] = $n_baru;						
			$this->load->library('upload', $config);
			
			if(!$this->upload->do_upload())
			{
				echo $this->upload->display_errors();
			}
			else 
			{
				$this->app_model->manualQuery("TRUNCATE TABLE ci_sessions");
				$this->app_model->manualQuery("TRUNCATE TABLE tbl_barang");
				$this->app_model->manualQuery("TRUNCATE TABLE tbl_faktur");
				$this->app_model->manualQuery("TRUNCATE TABLE tbl_faktur_detail");
				$this->app_model->manualQuery("TRUNCATE TABLE tbl_login");
				$this->app_model->manualQuery("TRUNCATE TABLE tbl_pelanggan");
				$this->app_model->manualQuery("TRUNCATE TABLE tbl_pesanan_detail");
				$this->app_model->manualQuery("TRUNCATE TABLE tbl_pesanan_header");
				$this->app_model->manualQuery("TRUNCATE TABLE tbl_surat_jalan");
				session_start();
				session_destroy();
				$direktori = "./asset/db_temp/".$config['file_name'];
				$isi_file=file_get_contents($direktori);
				$string_query=rtrim($isi_file, "\n;" );
				$array_query=explode(";", $string_query);
				foreach($array_query as $query)
				{
					$this->db->query($query);
				}
				unlink($direktori);
				header('location:'.base_url().'app');
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

/* End of file restore.php */
/* Location: ./application/controllers/restore.php */