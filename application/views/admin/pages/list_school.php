/**
 * List of schools
 */
<?php $this->load->view('admin/header/header.php') ?>

<div class="container">
	<h1>School</h1>
	<table class="table table-striped">
		<caption>List of Schools</caption>
	  <thead>
	  	<th>Center No.</th>
	  	<th>Name</th>
	  	<th>year</th>
	  	<th>District</th>
	  	<th>Latitude</th>
	  	<th>Longtitude</th>
	  	<th>Action</th>
	  </thead>
	  <tbody>
	  	<?php foreach ($school as $key => $value) {
	  	?>
	  		<tr>
		  		<td> <?php echo $value['sch_reg_no']; ?> </td>
		  		<td> <?php echo $value['name']; ?> </td>
		  		<td> <?php echo $value['year']; ?> </td>
		  		<td> <?php echo $value['district']; ?> </td>
		  		<td> <?php echo $value['latitude']; ?> </td>
		  		<td> <?php echo $value['longitude']; ?> </td>
		  		<td> 
			  		<div class="dropdown">
					  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					    <span class="caret"></span>
					  </button>
					  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
					    <li><a href="<?php echo base_url()?>dashboard/school/edit/<?php echo $value['sch_reg_no']; ?>">Edit</a></li>
					    <li><a href="<?php echo base_url()?>dashboard/school/delete/<?php echo $value['sch_reg_no']; ?>">Delete</a></li>
					  </ul>
					</div>
				</td>
	  		</tr>
	  	<?php
	  	} ?>
	  </tbaody>
	</table>
</div>

<?php $this->load->view('admin/footer/footer.php') ?>