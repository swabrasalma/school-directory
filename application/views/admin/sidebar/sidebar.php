
<div class="col-sm-3 col-md-2 sidebar">
<?php 
	if ($this->session->userdata('section') == 'school'  || $this->aauth->get_user_id() == 1 ) { ?> 
		<ul class="nav nav-sidebar">
		    <li><a href="#"><h4 style="font-weight:bold;">School</h4><span class="sr-only">(current)</span></a></li>
		    <li><a href="<?php echo base_url()?>dashboard/school"><i class="glyphicon glyphicon-plus">&nbsp;</i>Add School</a></li>
		    <li><a href="<?php echo base_url()?>dashboard/school/view/"><i class="glyphicon glyphicon-list">&nbsp;</i>List Schools
		    <li><a href="<?php echo base_url()?>dashboard/students"><i class="glyphicon glyphicon-list">&nbsp;</i>Upload Student Details</a></li>
		    <li><a href="<?php echo base_url()?>dashboard/students/list"><i class="glyphicon glyphicon-list">&nbsp;</i>View Student Results

		    </a></li>
	  	</ul>
	<?php } ?>

	<?php 
	if ($this->session->userdata('section') == 'university'|| $this->aauth->get_user_id() == 1 ) { ?> 
		<ul class="nav nav-sidebar">
		    <li><a href="#"><h4 style="font-weight:bold;">University</h4><span class="sr-only">(current)</span></a></li>
		    <li><a href="<?php echo base_url()?>dashboard/university"><i class="glyphicon glyphicon-plus">&nbsp;</i>Add university</a></li>
		    <li><a href="<?php echo base_url()?>dashboard/university/view"><i class="glyphicon glyphicon-list">&nbsp;</i>List university</a></li>
		     <li><a href="<?php echo base_url()?>dashboard/courses"><i class="glyphicon glyphicon-list">&nbsp;</i>Upload Course details</a></li>
		      <li><a href="<?php echo base_url()?>dashboard/school/view/"><i class="glyphicon glyphicon-list">&nbsp;</i>View Student-Course lists</a></li>
	  	</ul>
	<?php } ?>


	<?php 
	if ($this->session->userdata('section') == 'uneb' || $this->aauth->get_user_id() == 1) { ?> 
	  	<ul class="nav nav-sidebar">
		    <li><a href="#"><h4 style="font-weight:bold;">Uneb</h4><span class="sr-only">(current)</span></a></li>
		    <li><a href="<?php echo base_url()?>dashboard/upload"><i class="glyphicon glyphicon-plus">&nbsp;</i>Upload Results</a></li>
		    <li><a href="<?php echo base_url()?>dashboard/excel"><i class="glyphicon glyphicon-plus">&nbsp;</i>Export Results</a></li>

		    <li><a href="<?php echo base_url()?>dashboard/students/list"><i class="glyphicon glyphicon-list">&nbsp;</i>View Results</a></li>
		    <li><a href="<?php echo base_url()?>dashboard/subject"><i class="glyphicon glyphicon-list">&nbsp;</i>Upload Subjects</a></li>
	  	</ul>
	<?php }?>
  	<?php 
  	if($this->aauth->get_user_id() == 1) { ?>
  		<ul class="nav nav-sidebar">
		    <li><a href="#"><h4 style="font-weight:bold;">Accounts</h4><span class="sr-only">(current)</span></a></li>
		    <li><a href="<?php echo base_url()?>dashboard/user"><i class="glyphicon glyphicon-plus">&nbsp;</i>Add User</a></li>
		    <li><a href="<?php echo base_url()?>dashboard/user/view"><i class="glyphicon glyphicon-list">&nbsp;</i>List Users</a>
		    </li>
	  	</ul>
  	<?php 
  	} else { 
  	}
  	?>
  	
</div>