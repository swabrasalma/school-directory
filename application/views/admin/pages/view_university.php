<div style="margin-top:50px; margin-left:150px;">
	<?php

  		$attributes = array('class' => 'form-signin', 'id' => 'myform', 'role' => 'form', 'method' => 'post');
		echo form_open('dashboard/university/add', $attributes);
		if ($this->session->flashdata('error')) {
  			echo '<span class="alert alert-danger">' . $this->session->flashdata('error') . '</span><Br><Br>';
  		}
		echo form_fieldset('University Details');
		echo form_label('University Name', 'name');

		//username form input
		$university = array(
	        'name' => 'name',
	        'id' => 'name',
	        'maxlength' => '100',
	        'size'  => '50',
	        'style' => 'width:50%',
	        'class' => 'form-control'
		);

		echo form_input($university);

		//password label
		echo form_label('district', 'district');
		$district = array(
	        'name' => 'district',
	        'id' => 'district',
	        'maxlength' => '100',
	        'size'  => '50',
	        'style' => 'width:50%',
	        'type' => 'text',
	        'class' => 'form-control'
		);

		echo form_input($district);

	 
		

		echo form_label('latitude', 'latitude');
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

		echo form_label('longitude', 'longitude');
		$longitudeData = array(
	        'name' => 'longitude',
	        'id' => 'sname',
	        'maxlength' => '100',
	        'size'  => '50',
	        'style' => 'width:50%',
	        'type' => 'text',
	        'class' => 'form-control'
		);

		echo form_input($longitudeData);


		//submit button
		$data = array(
	        'id' => 'button',
	        'class' => 'btn btn-success',
	        'type' => 'submit',
	        'content'=> 'submit'
		);

		echo form_button($data);
		echo form_fieldset_close();
		echo form_close();?>
		<a href="dashboard/university/displaydetails">displaydetails</a>
	
  	

</div>
