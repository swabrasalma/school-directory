<?php $this->load->view('admin/header/header.php') ?>
<div class="container">
	<div style="margin-top:180px;">
		<h1 style="font-size:26px; font-weight:bold;">Result Slip:</h1><br>
		<div style="margin-top:50px; background-color:whitesmoke; border:1px solid #e2e2e2; margin:10px; padding:20px;">
			<?php
				if ($results['student']['entry'] == 1) {
					$this->load->view('admin/pages/UCE_results.php');
				} else {
					$this->load->view('admin/pages/UACE_passlip.php');
				}
			?>
		</div>	
	</div>
	
</div>

<?php $this->load->view('admin/footer/footer.php') ?>
 