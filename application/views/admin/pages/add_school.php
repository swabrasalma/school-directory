<?php $this->load->view('admin/header/header.php') ?>
<div class="container">
	<div style="margin-top:50px; margin-left:150px;">
	<?php
  		$attributes = array('class' => 'form-signin', 'id' => 'myform', 'role' => 'form', 'method' => 'post');
		echo form_open('dashboard/school/add', $attributes);
		if ($this->session->flashdata('error')) {
  			echo '<span class="alert alert-danger">' . $this->session->flashdata('error') . '</span><Br><Br>';
  		}
		echo form_fieldset('Add School');
		?>
		<div class="form-group">
			<?php
				echo form_label('School Center number', 'School');

				//username form input
				$schoolData = array(
			        'name' => 'sch_reg_no',
			        'id' => 'sch_reg_no',
			        'maxlength' => '100',
			        'size'  => '50',
			        'style' => 'width:50%',
			        'class' => 'form-control'
				);

				echo form_input($schoolData);
			?>
		</div>

		<div class="form-group">
			<?php
				//name label
				echo form_label('School Name', 'name');
				$nameData = array(
			        'name' => 'name',
			        'id' => 'name',
			        'maxlength' => '100',
			        'size'  => '50',
			        'style' => 'width:50%',
			        'type' => 'text',
			        'class' => 'form-control'
				);

				echo form_input($nameData);
			?>
		</div>

		<div class="form-group">
			<?php
				//name label
				echo form_label('Academic Year', 'year');
				$yearData = array(
			        'name' => 'year',
			        'id' => 'year',
			        'maxlength' => '100',
			        'size'  => '50',
			        'style' => 'width:50%',
			        'type' => 'text',
			        'class' => 'form-control'
				);

				echo form_input($yearData);
			?>
		</div>

		<div class="form-group">
			<?php
				$options = array(
			        '1'  => 'Government',
			        '2'  => 'Private School'
				);

				echo form_dropdown('school_type', $options, '1');
			?>
		</div>

		<div class="form-group">
			<?php
				//name label
				echo form_label('District', 'district');
				$distictData = array(
			        'name' => 'district',
			        'id' => 'district',
			        'maxlength' => '100',
			        'size'  => '50',
			        'style' => 'width:50%',
			        'type' => 'text',
			        'class' => 'form-control'
				);

				echo form_input($distictData);
			?>
		</div>

		<div class="form-group">
			<?php
				//name label
				echo form_label('Latitude', 'Latitude');
				$latitudeData = array(
			        'name' => 'latitude',
			        'id' => 'latitude',
			        'maxlength' => '100',
			        'size'  => '50',
			        'style' => 'width:50%',
			        'type' => 'text',
			        'class' => 'form-control'
				);

				echo form_input($latitudeData);
			?>
		</div>
		
		<div class="form-group">
			<?php
				//name label
				echo form_label('longitude', 'longitude');
				$longtitudeData = array(
			        'name' => 'longitude',
			        'id' => 'name',
			        'maxlength' => '100',
			        'size'  => '50',
			        'style' => 'width:50%',
			        'type' => 'text',
			        'class' => 'form-control'
				);

				echo form_input($longtitudeData);
			?>
		</div>
		
		<div class="form-group">
			<?php
				//submit button
				$data = array(
			        'id' => 'button',
			        'class' => 'btn btn-success',
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
<?php $this->load->view('admin/footer/footer.php') ?>