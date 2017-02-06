<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class App_Model extends CI_Model {

	
	 
	//query otomatis dengan active record
	public function getAllData($table)
	{
		return $this->db->get($table);
	}
	
	public function getAllDataLimited($table,$limit,$offset)
	{
		return $this->db->get($table, $limit, $offset);
	}
	
	public function getSelectedDataLimited($table,$data,$limit,$offset)
	{
		return $this->db->get_where($table, $data, $limit, $offset);
	}
	
	public function getSelectedData($table,$data)
	{
		return $this->db->get_where($table, $data);
	}
	
	function updateData($table,$data,$field_key)
	{
		$this->db->update($table,$data,$field_key);
	}
	
	function deleteData($table,$data)
	{
		$this->db->delete($table,$data);
	}
	
	function insertData($table,$data)
	{
		$this->db->insert($table,$data);
	}
	
	function manualQuery($q)
	{
		return $this->db->query($q);
	}
	
	public function getMaxKodeBarang()
	{
		$q = $this->db->query("select MAX(RIGHT(kode_barang,4)) as kd_max from tbl_barang");
		$kd = "";
		if($q->num_rows()>0)
		{
			foreach($q->result() as $k)
			{
				$tmp = ((int)$k->kd_max)+1;
				$kd = sprintf("%04s", $tmp);
			}
		}
		else
		{
			$kd = "0001";
		}	
		return "BR".$kd;
	}
	
	public function getMaxKodePelanggan()
	{
		$q = $this->db->query("select MAX(RIGHT(kode_pelanggan,5)) as kd_max from tbl_pelanggan");
		$kd = "";
		if($q->num_rows()>0)
		{
			foreach($q->result() as $k)
			{
				$tmp = ((int)$k->kd_max)+1;
				$kd = sprintf("%05s", $tmp);
			}
		}
		else
		{
			$kd = "00001";
		}	
		return "PL".$kd;
	}
	

	public function getMaxKodeSuplier()
	{
		$q = $this->db->query("select MAX(RIGHT(kode_suplier,5)) as kd_max from tbl_suplier");
		$kd = "";
		if($q->num_rows()>0)
		{
			foreach($q->result() as $k)
			{
				$tmp = ((int)$k->kd_max)+1;
				$kd = sprintf("%05s", $tmp);
			}
		}
		else
		{
			$kd = "00001";
		}	
		return "SP".$kd;
	}

	public function getMaxKodePesanan()
	{
		$q = $this->db->query("select MAX(RIGHT(kode_pesanan,8)) as kd_max from tbl_pesanan_header");
		$kd = "";
		if($q->num_rows()>0)
		{
			foreach($q->result() as $k)
			{
				$tmp = ((int)$k->kd_max)+1;
				$kd = sprintf("%08s", $tmp);
			}
		}
		else
		{
			$kd = "00000001";
		}	
		return "PS".$kd;
	}
	
	public function getMaxKodeFaktur()
	{
		$q = $this->db->query("select MAX(RIGHT(kode_faktur,8)) as kd_max from tbl_faktur");
		$kd = "";
		if($q->num_rows()>0)
		{
			foreach($q->result() as $k)
			{
				$tmp = ((int)$k->kd_max)+1;
				$kd = sprintf("%08s", $tmp);
			}
		}
		else
		{
			$kd = "00000001";
		}	
		return "FK".$kd;
	}
	
	public function getMaxKodeSuratJalan()
	{
		$q = $this->db->query("select MAX(RIGHT(kode_surat_jalan,8)) as kd_max from tbl_surat_jalan");
		$kd = "";
		if($q->num_rows()>0)
		{
			foreach($q->result() as $k)
			{
				$tmp = ((int)$k->kd_max)+1;
				$kd = sprintf("%08s", $tmp);
			}
		}
		else
		{
			$kd = "00000001";
		}	
		return "SJ".$kd;
	}
	
	public function getSisaStok($kode_barang)
	{
		$q = $this->db->query("select stok from tbl_barang where kode_barang='".$kode_barang."'");
		$stok = "";
		foreach($q->result() as $d)
		{
			$stok = $d->stok;
		}
		return $stok;
	}
	
	public function getBalancedStok($kode_barang,$kurangi)
	{
		$q = $this->db->query("select stok from tbl_barang where kode_barang='".$kode_barang."'");
		$stok = "";
		foreach($q->result() as $d)
		{
			$stok = $d->stok-$kurangi;
		}
		return $stok;
	}
	
	
	//query login
	public function getLoginData($usr,$psw)
	{
		$u = mysql_real_escape_string($usr);
		$p = md5(mysql_real_escape_string($psw.'appFakturDlmbg32'));
		$q_cek_login = $this->db->get_where('tbl_login', array('username' => $u, 'password' => $p));
		if(count($q_cek_login->result())>0)
		{
			foreach($q_cek_login->result() as $qck)
			{
				if($qck->stts=='admin')
				{
					foreach($q_cek_login->result() as $qad)
					{
						$sess_data['logged_in'] = 'yesGetMeLogin';
						$sess_data['username'] = $qad->username;
						$sess_data['nama_pengguna'] = $qad->nama_pengguna;
						$sess_data['stts'] = $qad->stts;
						$this->session->set_userdata($sess_data);
					}
					header('location:'.base_url().'pemesanan/pending');
				}
			}
		}
		else
		{
			$this->session->set_flashdata('result_login', 'Username atau Password yang anda masukkan salah.');
			header('location:'.base_url().'front');
		}
	}
}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */