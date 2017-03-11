<?php $this->load->view('admin/header/header.php') ?>
<div class="container">
	<div style="margin-top:50px;">
	<?php
		echo form_open_multipart('students/do_upload');;
		if ($this->session->flashdata('error')) {
  			echo '<span class="alert alert-danger">' . $this->session->flashdata('error') . '</span><Br><Br>';
  		}
		echo form_fieldset('Upload students');
		?>
		 
		<div class="form-group">
			<?php 
				$uploadData = array(
			        'name' => 'userfile',
			        'id' => 'userfile',
			        'maxlength' => '100',
			        'size'  => '50',
			        'style' => 'width:50%',
			        'type' => 'file',
			        'class' => 'form-control'
				);

				echo form_input($uploadData);
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