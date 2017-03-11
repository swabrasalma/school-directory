<?php $this->load->view('header/header.php') ?>
<div id="main" role="main" class="container">
	<div style="margin-top:150px; margin-left:100px;">
		<!-- Main jumbotron for a primary marketing message or call to action -->
	    <div class="jumbotron">
	      <div class="container">
	        <h1>School search</h1>
	        
	        <?php echo form_open('dashboard/school/search_school');
	        echo form_open('dashboard/school/search_school');
	        echo form_fieldset('Please type in the name of the school or its district of location');
	        // echo form_label('school name or district', 'School');

				//username form input
				$school = array(
			        'name' => 'sch_name',
			        'id' => 'sch_name',
			        'maxlength' => '100',
			        'size'  => '50',
			        'style' => 'width:50%',
			        'class' => 'form-control'
				);
				echo form_input($school);
				?>
				<p></p>
	        <p><a class="btn btn-success btn-lg" href="#" role="button">Search&raquo;</a></p>
	      </div>
	    </div>
	</div>
</div>
<?php $this->load->view('footer/footer.php') ?>