<?php $this->load->view('admin/header/header.php') ?>
<div class="container">
	<div style="margin-top:50px; margin-left:150px;">
	<?php
  		$attributes = array('class' => 'form-signin', 'id' => 'myform', 'role' => 'form', 'method' => 'post');
		echo form_open('dashboard/user/add', $attributes);
		if ($this->session->flashdata('error')) {
  			echo '<span class="alert alert-danger">' . $this->session->flashdata('error') . '</span><Br><Br>';
  		}
		echo form_fieldset('Add User');
		?>
		<div class="form-group">
			<?php
			echo form_label('Email', 'email');

			//username form input
			$usernameData = array(
		        'name' => 'email',
		        'id' => 'email',
		        'maxlength' => '100',
		        'size'  => '50',
		        'style' => 'width:50%',
		        'class' => 'form-control'
			);

			echo form_input($usernameData);
			?>
		</div>

		<div class="form-group">
			<?php
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
			?>
		</div>
		
		<div class="form-group">
			<?php
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
			?>
		</div>

		<div class="form-group">
			<?php
				echo form_label('Department', 'department').'&nbsp;';
				$options = array(
			        'uneb'  => 'Uneb',
			        'school'  => 'School',
			        'university' => 'University'
				);

				echo form_dropdown('perm', $options, 'school', ['class' => 'form-control', 'style' => 'width:50%',]);
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
</div>
