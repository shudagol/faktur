<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Grafik extends CI_Controller {


	
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

			$bc['dt_barang'] = $this->app_model->manualQuery("SELECT tbl_pesanan_detail.kode_barang,tbl_barang.nama_barang,count(tbl_pesanan_detail.kode_barang) as jumlah FROM tbl_pesanan_detail INNER JOIN tbl_barang ON tbl_pesanan_detail.kode_barang=tbl_barang.kode_barang GROUP BY nama_barang ORDER BY jumlah DESC");

			//$bc['dt_barang'] = $this->app_model->manualQuery("SELECT kode_barang, count(kode_barang) as jumlah FROM tbl_pesanan_detail GROUP BY kode_barang ORDER BY jumlah DESC");




			$this->load->view('global/bg_top',$d);
			$this->load->view('grafik/bg_home',$bc);
			$this->load->view('global/bg_footer',$d);

		}
	}}