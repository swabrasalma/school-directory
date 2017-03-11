<?php $this->load->view('admin/header/header.php') ?>
<div class="container">
	<h1>Accounts</h1>
	<table class="table table-striped">
		<caption>List of users</caption>
	  <thead>
	  	<th>No.</th>
	  	<th>Name</th>
	  	<th>Email</th>
	  	<th>Date Created</th>
	  	<th>Action</th>
	  </thead>
	  <tbody>
	  	<?php foreach ($users as $key => $value) {
	  	?>
	  		<tr>
	  		
		  		<td> <?php echo $value['id']; ?> </td>
		  		<td> <?php echo $value['username']; ?> </td>
		  		<td> <?php echo $value['email']; ?> </td>
		  		<td> <?php echo $value['date_created']; ?> </td>
		  		<td> 
			  		<div class="dropdown">
					  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					    <span class="caret"></span>
					  </button>
					  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
					    <li><a href="<?php echo base_url()?>dashboard/user/edit/<?php echo $value['id']; ?>">Edit</a></li>
					    <li><a href="<?php echo base_url()?>dashboard/user/delete/<?php echo $value['id']; ?>">Delete</a></li>
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