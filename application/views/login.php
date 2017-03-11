<?php $this->load->view('header/header.php') ?>
<div style="margin-top:150px; margin-left:150px;">
	<?php
  		$attributes = array('class' => 'form-signin', 'id' => 'myform', 'role' => 'form', 'method' => 'post');
		echo form_open('login/loginAction', $attributes);
		if ($this->session->flashdata('error')) {
  			echo '<span class="alert alert-danger">' . $this->session->flashdata('error') . '</span><Br><Br>';
  		}
		echo form_fieldset('Admin Login');
		echo form_label('Username', 'username');

		//username form input
		$usernameData = array(
	        'name' => 'username',
	        'id' => 'username',
	        'maxlength' => '100',
	        'size'  => '50',
	        'style' => 'width:50%',
	        'class' => 'form-control'
		);

		echo form_input($usernameData);

		//password label
		echo form_label('Password', 'password');
		$passwordData = array(
	        'name' => 'password',
	        'id' => 'password',
	        'maxlength' => '100',
	        'size'  => '50',
	        'style' => 'width:50%',
	        'type' => 'password',
	        'class' => 'form-control'
		);

		echo form_input($passwordData);

		//submit button
		$data = array(
	        'id' => 'button',
	        'class' => 'btn btn-success',
	        'type' => 'submit',
	        'content'=> 'submit'
		);

		echo form_button($data);
		echo form_fieldset_close();
		echo form_close();
  	?>
</div>
