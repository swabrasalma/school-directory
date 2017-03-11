<?php $this->load->view('header/header.php') ?>
<div style="background:url('images/sch.jpg'); height:100%">
	<div class="container" style="position:relative; top:150px;">
        	<h1 style="color:white; font-weight:bold; font-size:60px !important;">School Directory!</h1>
		</div>
	<div style="min-height:150px;"></div>
	<div class="jumbotron" style="margin-bottom:-50px; margin-top:150px;">
      	<div class="container">
      		<h2 style="font-weight:bold; margin-top:-10px;">Search:</h3>
      		<div style="margin-top:0px; margin-left:100px;">
				<!-- Main jumbotron for a primary marketing message or call to action -->
			    <?php $this->load->view('search_form.php') ?>
			</div><br><br>
        	<h2 style="font-weight:bold;">Statistics, Results, Course Recommendation</h3><br>
        	<p>This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
			<div style="min-height:150px;"></div>
		</div>
    </div>
</div>

 
<?php $this->load->view('footer/footer.php') ?>