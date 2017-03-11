<?php $this->load->view('admin/header/header.php') ?>
<div style="margin-top:50px; margin-left:150px;">
	<?php

  		$attributes = array('class' => 'form-signin', 'id' => 'myform', 'role' => 'form', 'method' => 'post');
		echo form_open('dashboard/university/add', $attributes);
		if ($this->session->flashdata('error')) {
  			echo '<span class="alert alert-danger">' . $this->session->flashdata('error') . '</span><Br><Br>';
  		}
		echo form_fieldset('Add university');
		?>
		<div class="form-group">
			<?php
				//name label
				echo form_label('Name', 'name');
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
				//co-ordinates label
				echo form_label('Co-ordinates', 'co_ordinates');
				$cordinatesData = array(
			        'name' => 'co_ordinates',
			        'id' => 'co_ordinates',
			        'maxlength' => '100',
			        'size'  => '50',
			        'style' => 'width:50%',
			        'type' => 'text',
			        'class' => 'form-control'
				);

				echo form_input($cordinatesData);
			?>
		</div>

		

		<div class="form-group">
			<?php
				//district label
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
