
/**
 * List of schools
 */
<?php $this->load->view('admin/header/header.php') ?>

<div class="container">
	<h1>University</h1>
		<table class="table table-striped">
			<caption>List of universities</caption>
		  <thead>
		  	<th>name</th>
		  	<th>co_ordinates</th>
		  	<th>district</th>
		  	
		  
		  	<th>Action</th>
		  </thead>
		  <tbody>
		  <?php if(!empty($university)) { ?>
		  	<?php foreach ($university as $key => $value) { 
		  	?>
		  		<tr> 
			  		<td> <?php echo $value['name']; ?> </td>
			  		<td> <?php echo $value['co_ordinates']; ?> </td>
			  		<td> <?php echo $value['district']; ?> </td> 
			  		
			  		<td> 
				  		<div class="dropdown">
						  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						    <span class="caret"></span>
						  </button>
						  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
						    <li><a href="<?php echo base_url()?>dashboard/university/edit/<?php echo $value['name']; ?>">Edit</a></li>
						    <li><a href="<?php echo base_url()?>dashboard/university/delete/<?php echo $value['name']; ?>">Delete</a></li>
						  </ul>
						</div>
					</td>
		  		</tr>
		  	<?php
		  	} 
		} else {
			?>
			<tr>
				<td><h3>No Record was found</h3></td>
			</tr>
		<?php
		} ?>
	  </tbody>
	</table>
</div>

<?php $this->load->view('admin/footer/footer.php') ?>