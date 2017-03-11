<?php $this->load->view('admin/header/header.php') ?>
<div class="container">
	<?php
		if(!empty($school)) {
	?>
		<h1>School: <?php echo $school['name']; ?></h1>
		<table class="table table-striped">
			<caption>List of users</caption>	
		  <tbody> 
	  		<tr>
		  		<td> Center No: <?php echo $school['sch_reg_no']; ?> </td>
		  	</tr>
		  	<tr>
		  		<td> Name <?php echo $school['name']; ?> </td>
		  	</tr>
		  	<tr>
		  		<td> Year: <?php echo $school['year']; ?> </td>
		  	</tr>
		  	<tr>
		  		<td> District: <?php echo $school['district']; ?> </td>
		  	</tr>
		  	</tr>
		  		<td> Latitude: <?php echo $school['latitude']; ?> </td>
		  	</tr>
		  	<tr>
		  		<td> Longitude: <?php echo $school['longitude']; ?> </td>
		  	</tr>
		  </tbody>
		</table>
	<?php
		} else {
			?>
			<h3>No Record was found</h3>
			<?php
		}
	?>
</div>

<?php $this->load->view('admin/footer/footer.php') ?>