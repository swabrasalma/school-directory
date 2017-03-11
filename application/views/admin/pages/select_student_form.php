<?php $this->load->view('admin/header/header.php') ?>
<div class="container">
	<div style="margin-top:50px;">
	<?php
		echo form_open_multipart('dashboard/students/list');;
		if ($this->session->flashdata('error')) {
  			echo '<span class="alert alert-danger">' . $this->session->flashdata('error') . '</span><Br><Br>';
  		}
		echo form_fieldset('List Students');
		?>
		<div class="form-group">
			<?php
				echo form_label('School', 'School');

				 
				echo form_dropdown('sch_reg_no', $schools, '1',  ['class' => 'form-control', 'style' => 'width:50%']);
			?>
		</div>


		<div class="form-group">
			<?php
				//paper label
				echo form_label('Entry', 'Entry');
				$options = array(
			        '1'  => 'UCE',
			        '2'  => 'UACE'
				);

				echo form_dropdown('entry', $options, '1',  ['class' => 'form-control', 'style' => 'width:50%']);
			?>
		</div>

		<div class="form-group">
			<?php
				echo form_dropdown('academic_year', $years, '1',  ['class' => 'form-control', 'style' => 'width:50%']);
			?>
		</div>
		
		<div class="form-group">
			<?php
				//submit button
				$data = array(
			        'id' => 'button',
			        'class' => 'btn btn-primary',
			        'type' => 'submit',
			        'content'=> 'submit'
				);

				echo form_button($data);
			?>
		</div>
		<?php
		echo form_fieldset_close();
		echo form_close();
  	?>
  	</div>
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