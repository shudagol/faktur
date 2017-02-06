<div id="container">
	<h1><?php echo $nama_perusahaan; ?></h1>
	<h2><?php echo $alamat_perusahaan; ?></h2>

	<div id="body">
		<?php
			echo $bio;
			echo $menu;
		?>
		<div class="cleaner_h0"></div>

		<?php
				if($dt_barang->num_rows()>0)
				{
					foreach($dt_barang->result_array() as $db)
					{
				echo $db['nama_barang']."="; 
				echo $db['jumlah']."</br>";
				}}
					?>
		
		<div id="list">

		<script type="text/javascript">
 var chart1; // globally available
$(document).ready(function() {
      chart1 = new Highcharts.Chart({
         chart: {
            renderTo: 'container',
            type: 'column'
         },   
         title: {
            text: 'Grafik Penjualan Kamera '
         },
         xAxis: {
            categories: ['brand']
         },
         yAxis: {
            title: {
               text: 'Jumlah terjual'
            }
         },
              series:             
            [
            <?php
				if($dt_barang->num_rows()>0)
				{
					foreach($dt_barang->result_array() as $db)
					{ ?>
						{
                      name: '<?php echo $db['nama_barang']; ?>',
                      data: [<?php echo $db['jumlah']; ?>]
                  },
                  <?php }} ?>
                   ]
      });
   }); 
</script>
			
		</div>
	</div>