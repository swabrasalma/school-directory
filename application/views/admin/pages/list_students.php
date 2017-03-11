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
	  	<th>Id</th>
	  	<th>Student No.</th>
	  	<th>School</th>
	  	<th>Name</th>
	  	<th>Sex</th>
	  	<th>Academic Year</th>
	  	<th>Entry</th>
	  	<th>Action</th>
	  </thead>
	  <tbody>

		  <?php if(!empty($students)) { ?>
		  	<?php foreach ($students as $key => $value) { 
		  	?>
		  		<tr> 
		  			<td> <?php echo $value['id']; ?> </td>
			  		<td> <?php echo $value['stud_reg_no']; ?> </td>
			  		<td> <?php echo $value['school']['name']; ?> </td>
			  		<td> <?php echo $value['name']; ?> </td>
			  		<td> <?php echo $value['sex']; ?> </td>
			  		<td> <?php echo $value['academic_year']; ?> </td>
			  		<td> <?php echo $value['entry']; ?> </td>    
			  		
			  		<td> 
				  		<div class="dropdown">
						  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						    <span class="caret"></span>
						  </button>
						  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
						  	<li><a href="<?php echo base_url()?>dashboard/students/result/<?php echo $value['stud_reg_no'];?>/<?php echo $value['academic_year'];?>">View Results</a></li>
						    <li><a href="<?php echo base_url()?>dashboard/students/edit/<?php echo $value['stud_reg_no']; ?>">Edit</a></li>
						    <li><a href="<?php echo base_url()?>dashboard/students/delete/<?php echo $value['stud_reg_no']; ?>">Delete</a></li>
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