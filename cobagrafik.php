
<? 
//takengonscript.blogspot.com
mysql_connect("localhost","root","");
mysql_select_db("db_faktur");

$result=mysql_query("select tbl_pesanan_detail, count(kd_barang) as jumlah from kd_barang group by kd_barang order by jumlah desc");

$sql = "select * from tbl_pesanan_detail";
			$data = mysql_query($sql);
			$row=mysql_fetch_array($data);
			
echo $row;
}
?>
